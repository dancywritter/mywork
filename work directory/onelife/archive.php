<?php
get_header();
	global  $cs_theme_option; 
	isset($cs_theme_option['cs_layout']);  $cs_layout = $cs_theme_option['cs_layout'];
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
				 if(is_author()){
					 global $author;
					 $userdata = get_userdata($author);
				 }
				 if(category_description() || is_tag() || (is_author() && isset($userdata->description) && !empty($userdata->description))){
					echo '<div class="rich_editor_text">';
					if(is_author()){
						echo $userdata->description;
					} elseif ( is_category() ) {
						 echo category_description();
					} elseif(is_tag()){
						$tag_description = tag_description();
                           if ( ! empty( $tag_description ) )
                                echo apply_filters( 'tag_archive_meta', $tag_description );
					}
					echo '</div>';
					
				}?>
				<?php
                    if (empty($_GET['page_id_all']))
                        $_GET['page_id_all'] = 1;
                    if (!isset($_GET["s"])) {
                        $_GET["s"] = '';
                    }
                    rewind_posts();
					$taxonomy = 'category';
					$taxonomy_tag = 'post_tag';
					$args_cat = array();
					if(is_author()){
						//$taxonomy = 'post-category';
						$args_cat = array('author' => $wp_query->query_vars['author']);
						$post_type = array( 'post', 'events', 'portfolio' );
					} elseif(is_date()){
						if(is_month() || is_year() || is_day() || is_time()){
							$args_cat = array('m' => $wp_query->query_vars['m'],'year' => $wp_query->query_vars['year'],'day' => $wp_query->query_vars['day'],'hour' => $wp_query->query_vars['hour'], 'minute' => $wp_query->query_vars['minute'], 'second' => $wp_query->query_vars['second']);
						}
						$post_type = array( 'post');
					} elseif (isset($wp_query->query_vars['taxonomy']) && !empty($wp_query->query_vars['taxonomy'])){
						$taxonomy = $wp_query->query_vars['taxonomy'];
						$taxonomy_category='';
							$taxonomy_category=$wp_query->query_vars[$taxonomy];
						if( $wp_query->query_vars['taxonomy']=='portfolio-category' || $wp_query->query_vars['taxonomy']=='portfolio-tag') {
						  $args_cat = array( $taxonomy => "$taxonomy_category");
						  $post_type='portfolio';
							
					  } else if( $wp_query->query_vars['taxonomy']=='event-category' || $wp_query->query_vars['taxonomy']=='event-tag') {
						  $args_cat = array( $taxonomy => "$taxonomy_category");
						  $post_type='events';
					} else {
							$taxonomy = 'category';
							$args_cat = array();
							$post_type='post';
						}
					} elseif(is_category()){
						$taxonomy = 'category';
						$args_cat = array();
						$category_blog = $wp_query->query_vars['cat'];
						$post_type='post';
						$args_cat = array( 'cat' => "$category_blog");
					} elseif(is_tag()){
						$taxonomy = 'category';
						$args_cat = array();
						$tag_blog = $wp_query->query_vars['tag'];
						$post_type='post';
						$args_cat = array( 'tag' => "$tag_blog");
					} else {
						$taxonomy = 'category';
						$args_cat = array();
						$post_type='post';
					}
					$args = array( 
					'post_type'		 => $post_type, 
					'paged'			 => $_GET['page_id_all'],
					'post_status'	 => 'publish', 
					'order'			 => 'ASC',
				);
				$args = array_merge($args_cat,$args);
				$custom_query = new WP_Query($args);
                 ?>
                <?php if ( $custom_query->have_posts() ): ?>
	                <?php
                    while ( $custom_query->have_posts() ) : $custom_query->the_post();
 					$event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);  
					?> 
						<article>
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
                                            	<?php printf( __('By: %s','OneLife'), '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="colr">'.get_the_author().'</a>' );?>
                                            </li>
                                            <?php $before_cat = " ";
													  $categories_list = get_the_term_list ( get_the_id(), $taxonomy, $before_cat, ', ', '' );
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
											<?php edit_post_link( __( 'Edit', 'OneLife'), ' <li><span class="edit-link colr">', '</span></li>' ); ?>                           		
										</ul>
										<!-- Post Options End -->
										<p><?php cs_get_the_excerpt(255,true);?></p>
									</div>
								<!-- Post Text End -->
							  </div>
						 </article>
                    <?php endwhile;  endif;  ?>
                  
        		</div>
                  <?php
                         $qrystr = '';
                        // pagination start
                        	if ($custom_query->found_posts > get_option('posts_per_page')) {
                            	echo "<nav class='pagination'><ul>";
                                     if ( isset($_GET['page_id']) ) $qrystr .= "&page_id=".$_GET['page_id'];
									 if ( isset($_GET['author']) ) $qrystr .= "&author=".$_GET['author'];
									 if ( isset($_GET['tag']) ) $qrystr .= "&tag=".$_GET['tag'];
									 if ( isset($_GET['cat']) ) $qrystr .= "&cat=".$_GET['cat'];
									 if ( isset($_GET['event-category']) ) $qrystr .= "&event-category=".$_GET['event-category'];
									 if ( isset($_GET['portfolio-category']) ) $qrystr .= "&portfolio-category=".$_GET['portfolio-category'];
									 if ( isset($_GET['event-tag']) ) $qrystr .= "&event-tag=".$_GET['event-tag'];
									 if ( isset($_GET['portfolio-tag']) ) $qrystr .= "&portfolio-tag=".$_GET['portfolio-tag'];
									 if ( isset($_GET['m']) ) $qrystr .= "&m=".$_GET['m'];
 						        echo cs_pagination($custom_query->found_posts,get_option('posts_per_page'), $qrystr);
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
<?php get_footer(); ?>