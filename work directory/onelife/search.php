<?php
	get_header();
	cs_enqueue_jcycle_script();
	global  $cs_theme_option; 
 	$cs_layout = $cs_theme_option['cs_layout'];
?>
    		<?php	
			if ( $cs_layout <> '' and $cs_layout  <> "none" and $cs_layout  == 'left' or $cs_layout  == 'both') {  ?>
            	<aside class="sidebar-left span3">
 					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_theme_option['cs_sidebar_left']) ) : endif; ?>
                 </aside>
        <?php 
			}
 		?>	
        	<div class="<?php cs_default_pages_meta_content_class( $cs_layout ); ?>">
             	<div class="postlist blog">
                 <!-- Blog Post Start -->
                 <?php
                
               		if ( have_posts() ) : 
						 while ( have_posts() ) : the_post();
						 ?>	
						 
						<article <?php post_class(); ?>>
							<div class="blog_text webkit">
									<!-- Thumb Start -->
									<div class="post-thumb">
										<time><h2 class="uppercase"><?php echo date('d',strtotime(get_the_date()));?><span><?php echo date('M',strtotime(get_the_date()));?></span></h2></time>
                                        <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('PixFill_author_bio_avatar_size', 57)); ?></a>
									</div>
									<!-- Thumb End -->
									<!-- Post Text Start -->
									<div class="post-text">
										<h2 class="heading-color post-title"><a class="colrhover" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
										<!-- Post Options Start -->
										<ul class="post-options">
											<li>
                                            	<?php printf( __('By: %s ','OneLife'), '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="">'.get_the_author().'</a>' );?>
                                            </li>
                                            <?php $posttype = get_post_type( $post );
											if($posttype == 'events'){
												$cs_taxnomy = 'event-category';
											} else if($posttype == 'portfolio'){
												$cs_taxnomy = 'portfolio-category';
											} else {
												$cs_taxnomy = 'category';
											}
											 ?>
                                            </li>
                                            <?php $before_cat = " ".__( '','OneLife')."";
												  $categories_list = get_the_term_list ( get_the_id(), $cs_taxnomy, $before_cat, ', ', '' );
												  if ( $categories_list ){
													?>
                                                <li>
                                                    <i class="icon icon-reorder">&nbsp;</i>
                                                    <?php 
                                                        printf( __( '%1$s', 'OneLife'),$categories_list );
                                                    ?>
                                                </li>
                                            <?php }?>
                                            
											<li>
												<?php  if ( comments_open() ) { echo "<i class='icon-comment'>&nbsp;</i>";comments_popup_link( __( '0', 'OneLife' ) , __( '1', 'OneLife' ), __( '%', 'OneLife' ) ); echo ' <a href="'.get_permalink().'#respond">' . __( 'Comments', 'OneLife' ).'</a>'; } ?>
											</li>
                                            <li><?php edit_post_link( __( 'Edit', 'OneLife'), ' <li><span class="edit-link colr">', '</span></li>' ); ?></li>
										</ul>
										<!-- Post Options End -->
										<p><?php cs_get_the_excerpt(255,true);?></p>
									</div>
								<!-- Post Text End -->
							  </div>
						 </article>
							
						<?php  
						endwhile;   
					else:
					?>
                		<div class="in-sec">
                        	<header class="heading">
                            	<h2 class="colr"><?php _e( 'No results found.', 'OneLife'); ?></h2>
                            </header>
                        	<div class="widget_search">
							<form id="searchform" method="get" action="<?php echo home_url()?>"  role="search">
								<input name="s" id="searchinput" value="<?php _e('Search for:', 'OneLife'); ?>"
								onFocus="if(this.value=='<?php _e('Search for:', 'OneLife'); ?>') {this.value='';}"
								onblur="if(this.value=='') {this.value='<?php _e('Search for:', 'OneLife'); ?>';}" type="text" />
								<input type="submit" id="searchsubmit"  value="" />
							</form>
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

						echo "<nav class='pagination'><ul>";
							if ( isset($_GET['s']) ) $qrystr = "&s=".$_GET['s'];
							if ( isset($_GET['page_id']) ) $qrystr .= "&page_id=".$_GET['page_id'];
							echo cs_pagination($wp_query->found_posts,get_option('posts_per_page'), $qrystr);
						 echo "</ul></nav>";
					}
					// pagination end
             	?>                    
             </div>
			 <?php
            if ( $cs_layout <> '' and $cs_layout  <> "none" and $cs_layout  == 'right' or $cs_layout  == 'both') { ?>
                <aside class="sidebar-right span3">
 						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_theme_option['cs_sidebar_right']) ) : endif; ?>
                 </aside>
        <?php 
			}
             ?>
<?php get_footer();?>
<!-- Columns End -->