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
 		<?php  px_custom_styles(); ?>	
		<?php 
            if(is_home() or is_front_page()){
				if(isset($px_theme_option['slider_blog_category'])){ $slider_category = $px_theme_option['slider_blog_category']; }else{ $slider_category =''; }
				if($slider_category == ''){
		?>
            <div class="page-background" id="background_section">
                <?php px_background_options(); ?>
            </div>
        <?php }
		}else{ ?>
			<div class="page-background" id="background_section">
                <?php px_background_options(); ?>
            </div>
		<?php } ?>
		<div id="wrappermain-pix" class="wrapper">
		<!-- Header Start -->
        <header id="header">
            <?php  if(isset($px_theme_option['header_search']) and $px_theme_option['header_search'] == 'on'){?>
            <div id="searcharea">
                <div class="searchform">
                	<a href="#" class="close-form"><i class="fa fa-times"></i></a>
                    <?php echo px_search(); ?>
                   </div>
            </div>
            <?php } ?>
            <div id="mainheader">
                <div class="container">
                    <!-- Logo -->    
                    <div class="logo">
                        <?php
                             if(isset($px_theme_option['logo']) && $px_theme_option['logo'] <> ''){
                                  px_logo($px_theme_option['logo'], $px_theme_option['logo_width'], $px_theme_option['logo_height']);
                            } else {
                                bloginfo('name');
                            }
                         ?>
                          <h4><?php bloginfo('description'); ?></h4>
                    </div>
                    <!-- Logo Close -->    
                    <!-- Right Header -->    
                    <div id="rightheader">
                        <nav class="navigation">
                          <?php  px_navigation('main-menu'); ?>
                        </nav>
                        <!-- Pix Post Panel -->    
                        <div class="pix-option-panel">
                            <ul>
                                <li>
                                <?php
                                  if(isset($px_theme_option['header_languages']) and $px_theme_option['header_languages'] == 'on'){
                                      echo do_action('icl_language_selector');
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
                            </ul>
                        </div>
                        <!-- Pix Post Panel Close -->
                        <?php  if(isset($px_theme_option['header_search']) and $px_theme_option['header_search'] == 'on'){?>    
                        <!-- Search Section -->    
                        <div class="searcharea">
                            <a class="btnsearch" href="#searchbox">
                                <i class="fa fa-search"></i>
                            </a>
                        </div>
                        <!-- Search Section Close--> 
                        <?php } ?>
                        </div>
                    <!-- Right Header Close --> 
                    </div>
            </div>
        </header>
    <!-- Header Close -->
    <?php if(is_home() || is_front_page()){?>
        <!-- Banner Section -->
        <?php 
            if(isset($px_theme_option['slider_blog_category'])){ $slider_category = $px_theme_option['slider_blog_category']; }else{ $slider_category =''; }
            if($slider_category <> ''){
				if(isset($px_theme_option['slider_no_posts'])){ $slider_no_posts = $px_theme_option['slider_no_posts']; }else{ $slider_no_posts=1; }
				$args = array('posts_per_page' => "$slider_no_posts", 'category_name' => "$slider_category",'post_status' => 'publish');
				$custom_query = new WP_Query($args);
				if($custom_query->have_posts()):
        ?>
                <div id="banner">
                    <div class="flexslider">
                        <ul class="slides">
                            <?php  
                                while ($custom_query->have_posts()) : $custom_query->the_post();
                                $image_url = px_get_post_img_src($post->ID,'','');
                            ?>
                            <li>
                                <figure>
                                    <img src="<?php echo $image_url;?>" alt="">
                                </figure>
                                <figcaption>
                                    <div class="pix-desc">
                                       <h4> <time datetime="2011-01-12">From the <?php echo get_the_date(); ?> </time></h4>
                                        <h2>
                                            <a href="<?php the_permalink(); ?>" class="pix-bgcolr"><?php echo px_title_lenght(get_the_title(),0,40); ?></a>
                                        </h2>
                                        <h3>
                                            <span class="pix-bgcolr"><?php echo substr(get_the_excerpt(),0,50); ?></span>
                                        </h3>
                                    </div>
                                </figcaption>
                            </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                    <?php  px_enqueue_flexslider_script(); ?>
                    <script>
                        jQuery(document).ready(function($) {
                            BannerGallery(); 
                        });
                    </script>
                </div>
        <?php endif; 
			}
		?>
        <!-- Banner Section Close -->
    <?php }?>
    <div class="clear"></div>
    <div id="main">
    <?php
		if(isset($px_theme_option['announcement_blog_category'])){ 
			$announcement_category =$px_theme_option['announcement_blog_category']; 
		}else{
			$announcement_category ='';
		}
    	if($announcement_category <> '' && (is_home() || is_front_page())){
			fnc_announcement();
		}
     ?>
        <!-- Inner Main -->
        <div id="innermain">
           <div class="container">
                <div class="row">
                    
                    	 <div class="breadcrumb">
                        	<div class="subtitle"><?php get_subheader_title(); ?></div> 
							 <?php if(!is_home() and !is_front_page()) { ?>
								<?php px_breadcrumbs(); ?>
							<?php } ?>
                        </div>
                    
                  