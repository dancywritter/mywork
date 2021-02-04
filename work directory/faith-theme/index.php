<?php
// Header File
 get_header();
 
 	if(isset($cs_theme_option['cs_layout'])){ $cs_layout = $cs_theme_option['cs_layout']; }else{ $cs_layout = 'right';} 
 	if ( $cs_layout <> '' and $cs_layout  <> "none" and $cs_layout  == 'left') :  ?>
		<aside class="left-content col-md-3">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_theme_option['cs_sidebar_left']) ) : endif; ?>
		</aside>
	<?php endif; ?>	
	<div class="<?php cs_default_pages_meta_content_class( $cs_layout ); ?>">
 	<?php if ( have_posts() ) : ?>
  
		<div class="postlist blog archive-page">
			<?php /* The loop */
			
				 if (empty($_GET['page_id_all']))
                        $_GET['page_id_all'] = 1;
                    if (!isset($_GET["s"])) {
                        $_GET["s"] = '';
                    }
			 ?>
            <?php while ( have_posts() ) : the_post();  ?>
 				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
                    <!-- Text Start -->
                    <div class="blog_text webkit">
                        <div class="text">
                            <h2 class="heading-color cs-post-title"><a href="<?php the_permalink(); ?>" class="cs-colrhvr"><?php the_title(); ?></a></h2>
                        </div>
                        <?php cs_posted_on(); ?> 
                        <p><?php the_excerpt(); ?></p>
                    </div>
                    <!-- Text End -->
				</article>
            <?php endwhile; 
 			else:
            	cs_no_result_found();
            endif; 
			?>
		</div>
 			<?php
				$qrystr = '';
				if ( isset($_GET['page_id']) ) $qrystr .= "&page_id=".$_GET['page_id'];
				// pagination start
					if (isset($cs_theme_option['pagination']) and $cs_theme_option['pagination'] == "Show Pagination" and $wp_query->found_posts > get_option('posts_per_page')) {
						echo cs_pagination(wp_count_posts()->publish,get_option('posts_per_page'), $qrystr);
					 }elseif($wp_query->found_posts > get_option('posts_per_page')){
						echo cs_pagination(wp_count_posts()->publish,get_option('posts_per_page'), $qrystr);
					}
				// pagination end
			?>
	</div>
    <?php
			if ( $cs_layout <> '' and $cs_layout  <> "none" and $cs_layout  == 'right') :  ?>
				<aside class="left-content col-md-3">
					<?php 
 					if(isset($cs_theme_option['cs_sidebar_right'])){
					if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_theme_option['cs_sidebar_right']) ) : endif;
					}else{
						if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-1') ) : endif;
					}
					  ?>
				</aside>
		<?php endif; ?>	
 <?php
 //Footer FIle
 get_footer();
?>