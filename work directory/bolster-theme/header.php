<?php
	global $cs_theme_option, $cs_page_builder, $cs_meta_page, $cs_node;
	$cs_theme_option = get_option('cs_theme_option');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
    <title>
	<?php
	    bloginfo('name'); ?> | 
    <?php 
		if ( is_home() or is_front_page() ) { bloginfo('description'); }
		else { wp_title(''); }
    ?>
    </title>
    <?php echo cs_favicon(); ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
		<?php 
            if ( is_singular() && get_option( 'thread_comments' ) )
            	wp_enqueue_script( 'comment-reply' );  
         		wp_head(); 
				
        ?>
        
    </head>
    <body <?php  body_class();  ?> >
    <div id="followingBallsG">
			<div id="followingBallsG_1" class="followingBallsG"></div>
			<div id="followingBallsG_2" class="followingBallsG"></div>
			<div id="followingBallsG_3" class="followingBallsG"></div>
			<div id="followingBallsG_4" class="followingBallsG"></div>
		</div>

	<?php
	cs_under_construction();
	cs_custom_styles();
	cs_color_switcher(); 
 	?>
	<!-- Wrapper Start -->
	<div class="wrapper fullwidth">
		 
    	<!-- Header Start -->
		<?php cs_custom_header_styles();?>
		<!-- Header End -->
    <!-- Content Section Start -->
    <div id="main" role="main">
    	<?php 
			if(is_page() and is_front_page()){
				echo cs_home_sliders();
			}
		?>