<?php
global $cs_theme_option, $cs_position, $cs_page_builder, $cs_meta_page, $cs_node;
$cs_theme_option = get_option('cs_theme_option');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title>
	<?php
	    bloginfo('name'); ?> | 
    <?php 
		if ( is_home() or is_front_page() ) { bloginfo('description'); }
		else { wp_title(''); }
    ?>
    </title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<?php 
            if ( is_singular() && get_option( 'thread_comments' ) )
            	wp_enqueue_script( 'comment-reply' );  
				cs_header_settings();
				wp_head(); 
        ?>
    </head>
	<body <?php body_class(); cs_bg_image(); cs_bgcolor_pattern(); ?> >
	  <?php
	  	$sidebars_widgets = get_option('sidebars_widgets');
              cs_custom_styles();
              cs_under_construction();
              cs_color_switcher(); 
			  $main_wrapper_class = '';
                if (is_home() || is_front_page()) {
					$main_wrapper_class = ' home-slider-off';
					if($cs_theme_option['show_slider'] =="on"){
						$main_wrapper_class = '';
						
						if(isset($cs_theme_option['slider_type']) and $cs_theme_option['slider_type'] == "custom"){
							$main_wrapper_class .= ' cs-custom-slider';
						}
					}
					
				}
        ?>
		<!-- Wrapper Start -->
		<div id="wrappermain-cs" class="wrapper <?php echo cs_wrapper_class().$main_wrapper_class;?>">
			<?php
                cs_get_header();
				
           		 if(isset($cs_theme_option['header_sticky_menu']) and $cs_theme_option['header_sticky_menu'] == "on"){ 
					?>
					<script type="text/javascript">
						jQuery(document).ready(function(){	
							cs_menu_sticky();
							sticky_menu_scroll();
							
						});
						
					</script>
					<?php
					} 
				
				$page_title = '';
				$main_wrapper_class = '';
                if (is_home() || is_front_page()) {
					$main_wrapper_class = 'home-slider-off';
					if($cs_theme_option['show_slider'] =="on"){
						$main_wrapper_class = '';
						//Home page Slider Start
							cs_get_home_slider();
						//Home page Slider End 
					}
                  } else { 
				  $header_banner_style = '';
				  $page_subheader_color = '';
				    $header_banner_style = '';
					 $header_banner_image = '';
					 $header_banner_flex_slider = '';
					 $custom_slider_id = '';
				  if(is_page()){
                       $cs_meta_page = cs_meta_page('cs_page_builder');
                       if (!empty($cs_meta_page)) {
						  $header_banner_style = $cs_meta_page->header_banner_style;
						   if(isset($cs_meta_page->page_subheader_color)) {  
						 	$page_subheader_color = $cs_meta_page->page_subheader_color;
						 }
						  $header_banner_image = $cs_meta_page->header_banner_image;
						  $header_banner_flex_slider = $cs_meta_page->header_banner_flex_slider;
						  $custom_slider_id = $cs_meta_page->custom_slider_id;
					   }
				  } else if(is_single()){
					$post_xml = get_post_meta($post->ID, "post", true);
					$post_type = get_post_type($post->ID);
					if ($post_type == "events") {
						$post_type = "cs_event_meta";
					} else if($post_type == "cs_cause") {
						$post_type = "cs_cause_meta";
					} else if($post_type == "teams") {
						$post_type = "cs_team";
					} else {
						$post_type = "post";
					}
					$post_xml = get_post_meta($post->ID, $post_type, true);
					if ( $post_xml <> "" ) {
						$cs_meta_page = new SimpleXMLElement($post_xml);
						 $header_banner_style = $cs_meta_page->header_banner_style;
						  if(isset($cs_meta_page->page_subheader_color)) {  
						 	$page_subheader_color = $cs_meta_page->page_subheader_color;
						 }
						 $header_banner_image = $cs_meta_page->header_banner_image;
						 $header_banner_flex_slider = $cs_meta_page->header_banner_flex_slider;
						 $custom_slider_id = $cs_meta_page->custom_slider_id;
					}	
				} else {
						$header_banner_style = $cs_theme_option['header_banner_style'];
						if(isset($cs_theme_option['page_subheader_color'])) {  
							$page_subheader_color = $cs_theme_option['page_subheader_color'];
						}
						 $header_banner_image = $cs_theme_option['header_banner_image'];
						 $header_banner_flex_slider = $cs_theme_option['header_banner_flex_slider'];
						 $custom_slider_id = $cs_theme_option['custom_slider_id'];
					
				}
				
				$default_color_bg = '';
				if(isset($header_banner_style) && $header_banner_style == 'default_header'){
					
	
				if(isset($cs_theme_option['header_banner_style_default']))   
				  $header_banner_style  =   $cs_theme_option['header_banner_style_default'];
				if(isset($cs_theme_option['page_subheader_color_default']))
				  $page_subheader_color  =   $cs_theme_option['page_subheader_color_default'];
				if(isset($cs_theme_option['header_banner_image_default'])) 
				  $header_banner_image  =   $cs_theme_option['header_banner_image_default'];
				if(isset($cs_theme_option['page_sub_title_default'])) 
				  $page_sub_title  =   $cs_theme_option['page_sub_title_default'];
				if(isset($cs_theme_option['header_banner_flex_slider_default'])) 
				  $header_banner_flex_slider = $cs_theme_option['header_banner_flex_slider_default'];
				if(isset($cs_theme_option['custom_slider_id_default'])) 
				  $custom_slider_id = $cs_theme_option['custom_slider_id_default'];
					
				}
				if(isset($header_banner_style) && $header_banner_style == 'breadcrumbs'){
				
                ?>
                <style>
					.breadcrumbs ul li {
						background-color:<?php echo $page_subheader_color;?>;
					}
				</style>
                
                <div class="breadcrumb" <?php if(isset($header_banner_image) && $header_banner_image <> ''){?>style=" background: url('<?php echo $header_banner_image;?>') no-repeat scroll center bottom / cover  <?php echo $page_subheader_color;?>"<?php } else {?>style="background-color:<?php echo $page_subheader_color;?>;"<?php }?>>
                	<div class="container">
                    	<div class="breadcrumb-inner">
                        	<?php
							if(function_exists("is_shop") and is_shop()){
								$cs_shop_id = woocommerce_get_page_id( 'shop' );
								echo "<div class=\"subtitle\"><h1 class=\"cs-page-title\">".get_the_title($cs_shop_id)."</h1></div>";
							}else if(function_exists("is_shop") and !is_shop()){
								echo '<div class="subtitle">';
									get_subheader_title();
								echo '</div>';
							}else{
								echo '<div class="subtitle">';
									get_subheader_title();
								echo '</div>';
							}
							cs_breadcrumbs();
							?>
                         </div>
                    </div>
                </div>
                <div class="clear"></div>
                <?php } else if(isset($header_banner_style) && $header_banner_style == 'flex_slider'){
							
							if(!empty($header_banner_flex_slider)){
								// slider slug to id start
									$args=array(
									  'name' => (string)$header_banner_flex_slider,
									  'post_type' => 'cs_slider',
									  'post_status' => 'publish',
									  'showposts' => 1,
									);
									$get_posts = get_posts($args);
									if($get_posts){
										$slider_id = $get_posts[0]->ID;
											cs_flex_slider('1600','610',(int)$slider_id);
									}
								}else{
								echo "Please Select Slider";
							}
                 } else if(isset($header_banner_style) && $header_banner_style == 'custom_slider'){
						
                		if(isset($custom_slider_id) && $custom_slider_id <> ''){
							echo do_shortcode(htmlspecialchars_decode($custom_slider_id));	
						} else {
								echo "Please Enter Shortcode";
						}
                }
				
                   /* Header Slider and Map Code start  */
                   if(is_page()){
					   $page_element_header = 0;
                       $cs_meta_page = cs_meta_page('cs_page_builder');
                       if (!empty($cs_meta_page)) {
						   echo '<div class="header_element">';
                           foreach ( $cs_meta_page->children() as $cs_node ){ 
                           		if($cs_node->getName() == "map" and $cs_node->map_view == "header"){
									$page_element_header++;
                                	echo cs_map_page();
                                } elseif ($cs_node->getName() == "slider" and $cs_node->slider_view == "header" and $cs_node->slider_type != "Custom Slider") {
									get_template_part( 'page_slider', 'page' );
									$page_element_header++;
									$cs_position = 'absolute';
								}
                           }
						   echo '</div>';
						   
						   if($page_element_header>=1){
							   echo '<div class="clear"></div>';
						   }
                       }
					   
                   }
                   /* Header Slider and Map Code End  */
                }                      
                ?>
				
                <div id="main">
                    <div class="container">
                        <div class="row">