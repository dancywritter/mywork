<?php
	get_header();
	global  $cs_theme_option; 
 	if(isset($cs_theme_option['cs_layout'])){ $cs_layout = $cs_theme_option['cs_layout']; }else{ $cs_layout = '';} 
	if(isset($cs_theme_option['default_excerpt_length'])){ $default_excerpt_length = $cs_theme_option['default_excerpt_length']; }else{ $default_excerpt_length = '255';} 
	


    			if ( $cs_layout <> '' and $cs_layout  <> "none" and $cs_layout  == 'left' or $cs_layout  == 'both') :  ?>
					<aside class="left-content col-md-3">
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_theme_option['cs_sidebar_left']) ) : endif; ?>
					</aside>
   			<?php endif; ?>	
        	<div class="<?php cs_default_pages_meta_content_class( $cs_layout ); ?>">
             	<div class="postlist blog archive-page">
                 <!-- Blog Post Start -->
					 <?php
                        if ( have_posts() ) : 
                             while ( have_posts() ) : the_post();
							   $image_url = cs_attachment_image_src(get_post_thumbnail_id($post->ID), 342, 193);	
							 	$post_class = '';
								 if($image_url == ''){
								  $post_class = ' no-image';
								 }
                                  	
                             ?>	
                                <article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?> >
                                    <!-- Text Start -->
                                    <?php 
										if($image_url <> ""){
											echo '<figure>
											
											
											<a href="'.get_permalink().'" ><img src="'.$image_url.'" alt="" ></a>
											
											
											</figure>';
										}
									?>
								<div class="blog_text webkit">
									<div class="text">
 										<h2 class="heading-color cs-post-title"><a href="<?php the_permalink(); ?>" class="colrhvr"><?php the_title(); ?></a></h2>
									</div>
 									<?php cs_posted_on(); ?>  
                                    <?php //echo get_the_excerpt();?>
                                	<p><?php echo cs_get_the_excerpt($default_excerpt_length,true); ?></p>
								</div>
								<!-- Text End -->
														   
							</article>
						<?php  
						endwhile;   
					else:
						fnc_no_result_found(); 
					endif;
     				
					?>
               	</div>
                <?php
                	$qrystr = '';
                    // pagination start
					if ($wp_query->found_posts > get_option('posts_per_page')) {

							if ( isset($_GET['s']) ) $qrystr = "&s=".$_GET['s'];
							if ( isset($_GET['page_id']) ) $qrystr .= "&page_id=".$_GET['page_id'];
							echo cs_pagination($wp_query->found_posts,get_option('posts_per_page'), $qrystr);
					}
					// pagination end
             	?>                    
             </div>
			<?php
                if ( $cs_layout <> '' and $cs_layout  <> "none" and $cs_layout  == 'right' or $cs_layout  == 'both') :  ?>
                    <aside class="left-content col-md-3">
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_theme_option['cs_sidebar_left']) ) : endif; ?>
					</aside>
            <?php endif; ?>	
<?php get_footer();?>
<!-- Columns End -->