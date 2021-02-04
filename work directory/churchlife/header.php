<?php
	global $px_theme_option, $px_page_builder, $px_meta_page, $px_node;
	$px_theme_option = get_option('px_theme_option');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
	<?php
	    bloginfo('name'); ?> | 
    <?php 
		if ( is_home() or is_front_page() ) { bloginfo('description'); }
		else { wp_title(''); }
    ?>
    </title>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
	<link rel="shortcut icon" href="<?php echo $px_theme_option['fav_icon'] ?>" />
    <!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<?php 
    	echo  htmlspecialchars_decode($px_theme_option['header_code']); 
	    if ( is_singular() && get_option( 'thread_comments' ) )
        	wp_enqueue_script( 'comment-reply' );  
         	wp_head(); 
    ?>
    </head>
	<body <?php body_class(); ?> >
	  <?php
	  		if (isset($px_theme_option['site_ajax']) &&  $px_theme_option['site_ajax'] == "on"){ // ajax search? ?>
            <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script> 
            
        	<script type="text/javascript">
				px_dropdown_menu_ajax('<?php echo get_template_directory_uri();?>');
				px_search_result_ajax('<?php echo get_template_directory_uri();?>');
				px_pagination_ajax('<?php echo get_template_directory_uri();?>');
				px_default_menu_ajax('<?php echo get_template_directory_uri();?>');
				
				
			</script>
        <?php }
			if (isset($px_theme_option['site_nicescroll']) &&  $px_theme_option['site_nicescroll'] == "on"){
			?>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					px_nicescroll();
				});
			</script>
			<?php
			}
              px_custom_styles();
			 echo '<div class="page-background" id="background_section">';
			 		px_background_options();
			echo '</div>';
        ?>
        <!-- Wrapper Start -->
          <!-- <svg xmlns="http://www.w3.org/2000/svg" version="1.1">
          <defs>
            <filter id="f1" x="0" y="0">
              <feGaussianBlur stdDeviation="5" />
            </filter>
          </defs>
        </svg> -->

<div id="wrappermain-pix" class="wrapper">
 <?php
	$content_display_class = '';
	$content_display_width = '';
	if (is_page()) {
		$px_meta_page = px_meta_page('px_page_builder');
		if (count($px_meta_page) > 0) {
			$count_element = 0;
			foreach ( $px_meta_page->children() as $px_meta_page_eelemnt ) {
				if ( $px_meta_page_eelemnt->getName() == "blog" ) {
								
						$count_element++;

					}else if ( $px_meta_page_eelemnt->getName() == "gallery" ) {
						$count_element++;
						
					}else if ( $px_meta_page_eelemnt->getName() == "sermon" ) {
						$count_element++;
						
					}else if ( $px_meta_page_eelemnt->getName() == "event" ) {
						
						$count_element++;
							
					}elseif($px_meta_page_eelemnt->getName() == "team"){
						$count_element++;
						
					}elseif($px_meta_page_eelemnt->getName() == "contact"){
					   $count_element++;
					   
					}elseif($px_meta_page_eelemnt->getName() == "column"){
						$count_element++;
					}
			}
			if( $px_meta_page->page_content <> "on"  && $count_element<1 ){
				$content_display_class = 'style="display: none;"';
				$content_display_width = 'style="width: 100%;"';
			}
		}
	}
	?>
	<!-- Left Section Includes header, rotation slider social icons, languages, cart-->        
        <div id="left-content" <?php echo $content_display_width;?>>
            <header id="header">
            	<div class="logo">
					<?php
					
						 if(isset($px_theme_option['logo']) && $px_theme_option['logo'] <> ''){
							  px_logo($px_theme_option['logo'], $px_theme_option['logo_width'], $px_theme_option['logo_height']);
						} else {
							bloginfo('name');
						}
	
						
                    ?>
                </div>
                <a class="pix-btnmenu"></a>
                <nav class="navigation">
                    <h5 class="pix-bgcolr"><?php if($px_theme_option['trans_switcher'] == "on"){ _e('EXPLORE THIS SITE','Church Life');}else{ echo $px_theme_option['trans_menu_title']; } ?></h5>
                    <?php  px_navigation('main-menu'); ?>
                </nav>
            </header>
            <div class="pix-heading-area">
					<?php if(is_home() || is_front_page()){
                     if(isset($px_theme_option['px_rotation_text']) && $px_theme_option['px_rotation_text'] <> ''){
						 $rotation_title = explode(',', $px_theme_option['px_rotation_text']);
						$roation_string = '';
						foreach($rotation_title as $rotation){
							if($rotation){
								$rotation_a ="'".trim($rotation)."'";
								$roation_string .= $rotation_a.',';
							}
						}
							 px_enqueue_text_rotator_script();
							 ?>
                                <div id="slider">
                                    <h1><span class="rotate" id="myWords"><?php //echo $px_theme_option['px_rotation_text'];?></span></h1>
                                    <script>
                                        <?php if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'on'){?>
											jQuery("#myWords").wordsrotator({
													words: [<?php echo $roation_string;?>] //Array of words, it may contain HTML values
												});
                                            
                                         <?php } else {?>
                                            jQuery(document).ready(function($) {
												jQuery("#myWords").wordsrotator({
													words: [<?php echo $roation_string;?>] //Array of words, it may contain HTML values
												});
                                                
                                            });   
                                        <?php }?>   
                                    </script>
                                </div>
						<?php
                     }
                     } else {
                        if(function_exists("is_shop") and is_shop()){
                            $px_shop_id = woocommerce_get_page_id( 'shop' );
                            echo "<h1 class=\"pix-page-title\">".get_the_title($px_shop_id)."</h1>";
                        }else if(function_exists("is_shop") and !is_shop()){
                            get_subheader_title();
                        }else if(is_page()){
                            get_subheader_title();
						}else if(is_single()){
                            get_subheader_title();
                        }
                     }?>
                     
            </div>
            
				<?php 
                  if(is_single()){
					echo '<div class="nex-prev-paginate">';
                    $post_type = get_post_type($post->ID);
                    if ($post_type == "events") {
                        px_next_prev_custom_links('events');
                    } else if($post_type == "sermons"){
                        px_next_prev_custom_links('sermons');
                    } else {
                        px_next_prev_post();
                    }
					echo ' </div>';
                 }
                ?> 
                 
             <footer id="footer">
                <?php
					if($px_theme_option['header_social_icons'] == 'on'){
					px_social_network();
					}
				?>
                <div class="pix-option-panel">
                    <ul>
                        <li>
                          <?php
						  if($px_theme_option['header_languages'] == 'on'){
							  do_action('icl_language_selector');
						  }
                          ?>
                        </li>
                        <li>
                        <?php 
                          if(function_exists( 'is_woocommerce' ) && isset($px_theme_option['header_cart']) && $px_theme_option['header_cart'] == 'on'){
                              px_woocommerce_header_cart();
                          }
                          ?>
                        </li>
                        <?php px_background_music($px_theme_option['header_track_mp3_url']);?>
                    </ul>
                </div>
            </footer>
            <?php 
			if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'on'){
		 		echo '<div class="page-background" id="background_section_view">';
			 		px_background_options();
				echo '</div>';
			}
		?> 
    </div>
    <div id="right-content" <?php echo $content_display_class;?>>
    <div id="main" class="pix-main-content" role="main" >