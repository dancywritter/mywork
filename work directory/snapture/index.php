<?php
// Header File
global $cs_theme_option;
  get_header();
if ( have_posts() ) : 
		 	cs_enqueue_masonry_style_script();
		 ?>
         <script>
			 	jQuery(document).ready(function($) {
					default_mas_gallery();
					jQuery(window).load(function() {
						default_mas_gallery();
					});

				});
			 </script>
          <div class="postlist postlist-mas-listing archive-page" id="default_mas_gallery">
        			
                    <?php /* The loop */
					
                     if (empty($_GET['page_id_all']))
                            $_GET['page_id_all'] = 1;
                      while ( have_posts() ) : the_post();  ?>
                            <div class="box">
                                <article <?php post_class(); ?> >
                                <div class="blog-text webkit">
                                    <h2 class="cs-post-title cs-heading-color"><a href="<?php the_permalink();?>" class="colrhvr"><?php echo substr(get_the_title(), 0, 48); if(strlen(get_the_title())>48) echo '...'; ?>.</a></h2>
                                    <ul class="post-options">
                                            <li><i class="fa fa-clock-o"></i><a class="colrhvr" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author(); ?></a></li>
                                            <li><?php  if ( comments_open() ) {echo '<i class="fa fa-comment"></i>'; comments_popup_link( __( '0', 'Snapture' ) , __( '1', 'Snapture' ), __( '%', 'Snapture' ) );  } ?></li>
                                            <?php cs_featured();?>
                                        </ul>
                                    <div class="text">
                                       <p><?php echo cs_get_the_excerpt('255',false) ?></p>
                                     </div>
                                </div>
                            </article>
                         </div>
                      <?php endwhile; 
					  
					  ?>
                </div>
	<?php
	$qrystr = '';
	// pagination start
	$count_posts = wp_count_posts();
	if ($count_posts->publish > get_option('posts_per_page')) {
			if ( isset($_GET['s']) ) $qrystr = "&s=".$_GET['s'];
			if ( isset($_GET['page_id']) ) $qrystr .= "&page_id=".$_GET['page_id'];
			echo cs_pagination($count_posts->publish,get_option('posts_per_page'), $qrystr);
	}
	// pagination end
	
  	endif;
  //Footer FIle
 get_footer();
?>