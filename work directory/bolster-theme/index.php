<?php
// Header File
global $cs_theme_option;
  get_header();
if ( have_posts() ) : 
		 	cs_enqueue_masonry_style_script();
			//cs_load_more_index_posts(cs_no_post_per_page, total_count, cs_search_db, home_url, get_template_directory_uri);
		 ?>
         <script type="text/javascript">
				jQuery(document).ready(function() {
					cs_load_more_index_posts(<?php echo get_option('posts_per_page') ?>, '<?php echo wp_count_posts()->publish; ?>', '<?php echo $_GET['page_id_all']; ?>', '<?php echo home_url() ?>','<?php echo get_template_directory_uri() ?>');
			   });
        </script>
         <div class="main-section">
         <aside class="left-content">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar') ) : endif; ?>
			</aside>
            <div class="right-content">
                <div class="cs-blog cs-default-view">
                <div class="blog-gallery">
        			<script type="text/javascript">
						jQuery(document).ready(function() {
							cs_masonary_callback('blog-gallery');
							 resize_blog_template ();
						});
							jQuery(window).load(function() {
							/* Act on the event */
							 resize_blog_template ()
							 jQuery("body") .trigger('resize')
						});
						jQuery(window).resize(function() {
							/* Act on the event */
							 resize_blog_template ()
						});
						
					</script>
                    <?php /* The loop */
					
                     if (empty($_GET['page_id_all']))
                            $_GET['page_id_all'] = 1;
                      while ( have_posts() ) : the_post();  ?>
                            <article  class="post">
                                <!-- News List Start -->
                                 <div class="article-wrapp">
                                    <div class="desc">
                                        <h2 class="post-title">
                                            <a href="<?php the_permalink(); ?>" class="colrhover"><?php echo substr(get_the_title(),0,32); if(strlen(get_the_title()) > 32) echo "..."; ?></a>
                                        </h2>
                                        <p>
                                            <?php 
												cs_get_the_excerpt(255,true);
												wp_link_pages();
											?>
                                         </p>
                                        <div class="bottom-post">
											<a class="img-icon-box" title="" data-toggle="tooltip" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" data-original-title="<?php echo get_the_author(); ?>"><?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('cs_author_bio_avatar_size', 50)); ?></a>
                                            <div class="text">
                                                <p class="panel">
                                                    <time><?php echo get_the_date();?></time>
                                                </p>
                                             </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                      <?php endwhile; ?>
                </div>
                </div>
            </div>  
           </div> 
	<?php
  	endif;
  //Footer FIle
 get_footer();
?>