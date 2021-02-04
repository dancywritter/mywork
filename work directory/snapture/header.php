<?php
	global $cs_theme_option, $cs_page_builder, $cs_meta_page, $cs_node;
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
     <link rel="shortcut icon" href="<?php if(isset($cs_theme_option['fav_icon']) and !empty($cs_theme_option['fav_icon']))echo $cs_theme_option['fav_icon'] ?>" />
     <!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		<?php 
            if ( is_singular() && get_option( 'thread_comments' ) )
            	wp_enqueue_script( 'comment-reply' );  
         		wp_head(); 
        ?>
    </head>
    <body <?php body_class();  ?> >
		
	<?php
	cs_under_construction();
	cs_color_switcher();
	cs_custom_styles();
	
	$cs_blog_large_layout = 'cs_full_width';
	$page_content_postion = $portfolio_post_detail_class = '';
	
	if(is_page()){
		$cs_meta_page = cs_meta_page('cs_page_builder');
		
		 if (count($cs_meta_page) > 0) {
			if(isset($cs_meta_page->cs_blog_large_layout) && $cs_meta_page->cs_blog_large_layout <> ''){
				global $cs_blog_large_layout;
				$cs_blog_large_layout = $cs_meta_page->cs_blog_large_layout;
				
			}
			if(isset($cs_meta_page->page_content_postion) && $cs_meta_page->page_content_postion <> '' && $cs_meta_page->page_content_postion == 'Yes'){
				global $page_content_postion;
				$page_content_postion = ' page-content-postion';
				
			}
		 }
	
	} else if(is_single()){
		global $post;
		$post_type = get_post_type($post->ID);
		 if ($post_type == "portfolio") {
			 $post_type = "portfolio";
			 $portfolio_post_detail_class = 'post-detail-bgcolr';
		 }
		 else {
			 $post_type = "post";
		 }
		 $post_xml_single = get_post_meta($post->ID, $post_type, true);
		 if ($post_xml_single <> "") {
		   $cs_xmlObject_single = new SimpleXMLElement($post_xml_single);
		   if(isset($cs_xmlObject_single->cs_blog_large_layout) && $cs_xmlObject_single->cs_blog_large_layout <> ''){
				$cs_blog_large_layout = $cs_xmlObject_single->cs_blog_large_layout;
			}
			if(isset($cs_xmlObject_single->page_content_postion)){
				if($cs_xmlObject_single->page_content_postion <> '' && $cs_xmlObject_single->page_content_postion == 'Yes'){
					$page_content_postion = ' page-content-postion '.$portfolio_post_detail_class;
				}
			}
		 }
		}
	 if ( class_exists( 'woocommerce' ) ){
		if(is_shop()){
			$cs_shop_id = woocommerce_get_page_id( 'shop' );
			$cs_meta_page = cs_meta_shop_page('cs_page_builder', $cs_shop_id);
			 if (count($cs_meta_page) > 0) {
				if(isset($cs_meta_page->cs_blog_large_layout) && $cs_meta_page->cs_blog_large_layout <> ''){
					global $cs_blog_large_layout;
					$cs_blog_large_layout = $cs_meta_page->cs_blog_large_layout;
					
				}
				if(isset($cs_meta_page->page_content_postion) && $cs_meta_page->page_content_postion <> '' && $cs_meta_page->page_content_postion == 'Yes'){
					global $page_content_postion;
					$page_content_postion = ' page-content-postion';
				}
			 }
		}else if(is_product()){
			$post_xml_single = get_post_meta($post->ID, "product", true);	
				if ( $post_xml_single <> "" ) {
					$cs_xmlObject_single = new SimpleXMLElement($post_xml_single);
					if(isset($cs_xmlObject_single->cs_blog_large_layout) && $cs_xmlObject_single->cs_blog_large_layout <> ''){
						$cs_blog_large_layout = $cs_xmlObject_single->cs_blog_large_layout;
					}
					if(isset($cs_xmlObject_single->page_content_postion)){
						if($cs_xmlObject_single->page_content_postion <> '' && $cs_xmlObject_single->page_content_postion == 'Yes'){
							$page_content_postion = ' page-content-postion';
						}
					}
				}
		}
	} 

 	?>
	<!-- Wrapper Start -->
	<div id="wrappermain-pix" class="wrapper wrapper-menu-loaded <?php cs_header_views_set(); echo $cs_blog_large_layout.$page_content_postion;?>">
		 
    	<!-- Header Start -->
		<?php cs_custom_header_styles(); ?>
		<!-- Header End -->
        <div id="main">
            <!-- Container Start -->
            <div class="container">
            	<!---Boxed view -->
                <?php if($cs_blog_large_layout=='cs_boxed_layout'){?>
               	 <div class="bg-color-full"></div>
                <?php }?>
                <!-- Row Start -->
                <div class="row">