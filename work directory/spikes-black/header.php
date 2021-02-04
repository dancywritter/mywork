<?php
global $cs_theme_option, $cs_position, $cs_page_builder, $cs_meta_page, $cs_node;
$cs_theme_option = get_option('cs_theme_option');
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
		<?php 
			cs_custom_color_skin();
            if ( is_singular() && get_option( 'thread_comments' ) )
            	wp_enqueue_script( 'comment-reply' );  
				cs_header_settings();
         		wp_head(); 
				
        ?>
    </head>
	<body <?php body_class(); cs_bg_image(); cs_bgcolor_pattern(); ?> >
	  <?php
	  		cs_under_construction();
		  	cs_custom_styles();
		  	cs_color_switcher(); 
        ?>
		<!-- Wrapper Start -->
		<div class="wrapper wrapper_boxed" id="wrappermain-pix" >
			<?php
                cs_get_header();
            	// Header sticky menu
				  // Header sticky menu
					if($cs_theme_option['header_sticky_menu'] == "on"){ 
						cs_scrolltofixed_script();
						?>
						<script type="text/javascript">
							jQuery(document).ready(function(){	
								cs_menu_sticky();
							});
						</script>
						<?php
					} 
                if (is_home() || is_front_page()) {
				?>
                <div id="banner">
                <?php
					if(isset($cs_theme_option['show_slider']) && $cs_theme_option['show_slider'] =="on"){
						//Home page Slider Start
						cs_get_home_slider();
					}
                    //Home page Slider End 
					if($cs_theme_option['show_player'] == 'on'){ 
						// Home page Player
						cs_get_home_player();
					}
				?></div><?php
                } else { 
                    // Subheader
						$show_title='Yes';
						if (is_page() ){
							$cs_meta_page = cs_meta_page('cs_page_builder');
							if(isset($cs_meta_page)){
								if ( $cs_meta_page->page_title <> "" ) {
									if ($cs_meta_page->page_title == "No") {
										$show_title = 'No';
									}
								}
							}
						}
						if($show_title == 'Yes'){
							cs_get_subheader();
						}
                   ?>
                    <div class="clear"></div>
                   <?php 
                   /* Header Slider and Map Code start  */
                   if(is_page()){
                       if (!empty($cs_meta_page)) {
                           foreach ( $cs_meta_page->children() as $cs_node ){ 
                           		if($cs_node->getName() == "map" and $cs_node->map_view == "header"){
									echo ' <div class="header_element"><div class="contact-map">';
                                		echo cs_map_page();
									echo '</div></div><div class="clear"></div>';
                                } elseif ($cs_node->getName() == "slider" and $cs_node->slider_view == "header" and $cs_node->slider_type != "Custom Slider") {
									echo '<div class="header_element">';
										get_template_part( 'page_slider', 'page' );
									echo '</div><div class="clear"></div>';
									$cs_position = 'absolute';
								}
                           }
                       }
                   }
                   /* Header Slider and Map Code End  */
                }                      
                ?>
    <!-- Content Section Start -->
    <div id="main" role="main" <?php if (is_home() || is_front_page()) {?>class="home-page"<?php }?>>
        <!-- Container Start -->
        <div class="container">
            <!-- Row Start -->
            <div class="row">