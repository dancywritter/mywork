<?php
	get_header();
	global  $cs_theme_option; 
 	$cs_layout = $cs_theme_option['cs_layout'];
?>
    		<?php
    			if ( $cs_layout <> '' and $cs_layout  <> "none" and $cs_layout  == 'left') :  ?>
					<aside class="<?php cs_default_pages_sidebar_class($cs_layout )?>"><?php cs_default_pages_sidebar()?></aside>
   			<?php endif; ?>	
        	<div class="<?php cs_default_pages_meta_content_class( $cs_layout ); ?>">
             	<div class="postlist blog">
                 <!-- Blog Post Start -->
                 <?php
                
               		if ( have_posts() ) : 
						 while ( have_posts() ) : the_post();
						 ?>	
                			<article <?php post_class(); ?>>
                            	<div class="blog_text fullwidth">
									<div class="fullwidth">
										<div class="head-group">
											<h2 class="post-title"><a href="<?php the_permalink(); ?>" class="colrhover"><?php echo get_the_title(); ?></a></h2>
											<div class="postpanel">
												<ul class="post-options">
													<li><?php printf( '<em>'.__('By: %s','Rocky').'</em>', '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="colrhover">'.get_the_author().'</a>' );?> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('on','Rocky');}else{ echo $cs_theme_option['trans_other_on']; } ?> <time datetime="<?php echo date('Y-m-d',strtotime(get_the_date()));?>"><?php echo get_the_date();?></time>  </li>
													 <?php  if ( comments_open() ) { echo "<li><em class='fa fa-comment'></em>";comments_popup_link( __( 'Comment', 'Rocky' ) , __( 'Comment', 'Rocky' ), __( 'Comment', 'Rocky' ) ); echo "</li>"; } ?>
													
												</ul>
											</div>
										</div>
									</div>
									<div class="text"><p><?php echo cs_get_the_excerpt(255,true);?></p></div>
									<?php edit_post_link( __( 'Edit', 'Rocky'), '<li><span class="edit-link">', '</span></li>' ); ?>
								</div>
                     		</article>
						<?php  
						endwhile;   
					else:
					?>
                		<div class="pagenone">
                            	<h3 class="colr"><?php _e( 'No results found.', 'Rocky'); ?></h3>
                        	<div class="password_protected">               
								<?php get_search_form(); ?>
							</div>
                    	</div>
                	<?php 
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
                if ( $cs_layout <> '' and $cs_layout  <> "none" and $cs_layout  == 'right') :  ?>
                    <aside class="<?php cs_default_pages_sidebar_class( $cs_theme_option['cs_layout'] )?>"><?php cs_default_pages_sidebar()?></aside>
            <?php endif; ?>	
<?php get_footer();?>
<!-- Columns End -->