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
        ?>
		<!-- Wrapper Start -->
		<div class="wrapper wrapper_boxed" id="wrappermain-pix">
			<?php
                cs_get_header();
            // Header sticky menu
            if(isset($cs_theme_option['header_sticky_menu']) and $cs_theme_option['header_sticky_menu'] == "on"){ 
 				?>
                <script type="text/javascript">
					jQuery(document).ready(function(){	
 						cs_menu_sticky();
					});
				</script>
                <?php
            } 
             ?>
            <?php 
                if (is_home() || is_front_page()) {
					?>
                    <div id="bannerwrapp">
       					<div class="container">
						<?php  
							$slider_size=100;
							$service_size=100;
							$width = 1060;
             				$height = 418;
							if(isset($cs_theme_option['show_slider']) and $cs_theme_option['show_slider'] =="on" and isset($cs_theme_option['varto_services_shortcode']) and $cs_theme_option['varto_services_shortcode'] <> ""){
								$slider_size=75;
								$service_size=25;
								$width = 786;
             					$height = 418;
								
							}
							//Home page Slider Start
							if(isset($cs_theme_option['show_slider']) and $cs_theme_option['show_slider'] =="on"){
								
								echo '<div class="element_size_'.$slider_size.'">';
                    			cs_get_home_slider($width,$height);
							 echo '</div>';
							}
							if(isset($cs_theme_option['varto_services_shortcode']) and $cs_theme_option['varto_services_shortcode'] <> ""){ 
								echo '<div class="element_size_'.$service_size.'">';
								cs_services(); 
								  echo '</div>';
                            }
						?>
                    	</div>
                    </div>
					<?php
 					if(isset($cs_theme_option['announcement_blog_category']) and $cs_theme_option['announcement_blog_category'] <> ""){
                     //Home page Slider End
					cs_announcement(); 
					}
				
			?> 
            <?php
                  } else { 
                  ?>
                <div class="breadcrumb">
                	<div class="container">
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
							
							cs_header_breadcrums();
						?>
                     </div>
                     
                </div>
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
 								}
                           }
						   echo '</div>';
                       }
                   }
                   /* Header Slider and Map Code End  */
                }                      
                ?>
				<div class="clear"></div>
				<div id="main" role="main">
       	 		<!-- Container Start -->
            	<div class="container">
                	<!-- Row Start -->
                	<div class="row">