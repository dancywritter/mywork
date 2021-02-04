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
            if ( is_singular() && get_option( 'thread_comments' ) )
            	wp_enqueue_script( 'comment-reply' );  
         		wp_head(); 
        ?>
    </head>
	<body <?php body_class(); cs_bg_image(); cs_bgcolor_pattern(); ?> >
	  <?php
              cs_custom_styles();
              cs_under_construction();
              cs_color_switcher(); 
        ?>
		<!-- Wrapper Start -->
		<div class="<?php cs_wrapper_class()?>" id="wrappermain-pix" >
			<?php
                cs_get_header();
				
            // Header sticky menu
            if($cs_theme_option['logo_sticky'] == ''){ 
                cs_header_sticky_menu();
            } 
             ?>
            <div class="clear"></div>
            <?php 
                if (is_home() || is_front_page()) {
                    //Home page Slider Start
                    cs_get_home_slider();
                    //Home page Slider End 
                } else { 
                    // Subheader
                    cs_get_subheader();
                   ?>
                    <div class="clear"></div>
                   <?php 
                   /* Header Slider and Map Code start  */
                   if(is_page()){
                       $cs_meta_page = cs_meta_page('cs_page_builder');
                       if (!empty($cs_meta_page)) {
						   echo '<div class="header_element">';
                           foreach ( $cs_meta_page->children() as $cs_node ){ 
                           		if($cs_node->getName() == "map" and $cs_node->map_view == "header"){
                                	echo cs_map_page();
                                } elseif ($cs_node->getName() == "slider" and $cs_node->slider_view == "header" and $cs_node->slider_type != "Custom Slider") {
									get_template_part( 'page_slider', 'page' );
									$cs_position = 'absolute';
								}
                           }
						   echo '</div><div class="clear"></div>';
                       }
                   }
                   /* Header Slider and Map Code End  */
                }                      
                ?>
		<!-- Content Section Start -->
         <div id="main" role="main">
           <div class="container">
               <div class="row">