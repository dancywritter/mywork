<?php
get_header();
	global  $cs_theme_option; 
	isset($cs_theme_option['cs_layout']); $cs_layout = $cs_theme_option['cs_layout'];
?>
		<?php	
			if ( $cs_layout <> '' and $cs_layout  <> "none" and $cs_layout  == 'left' or $cs_layout  == 'both') {  ?>
            	<aside class="col-lg-3 col-md-3 sidebar-right">
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
						$args_cat = array('author' => $wp_query->query_vars['author']);
						$post_type = array( 'post', 'events', 'albums' );
					} elseif(is_date()){
						if(is_month() || is_year() || is_day() || is_time()){
							$args_cat = array('m' => $wp_query->query_vars['m'],'year' => $wp_query->query_vars['year'],'day' => $wp_query->query_vars['day'],'hour' => $wp_query->query_vars['hour'], 'minute' => $wp_query->query_vars['minute'], 'second' => $wp_query->query_vars['second']);
						}
						$post_type = array( 'post');
					} elseif (isset($wp_query->query_vars['taxonomy']) && !empty($wp_query->query_vars['taxonomy'])){
						$taxonomy = $wp_query->query_vars['taxonomy'];
						$taxonomy_category='';
							$taxonomy_category=$wp_query->query_vars[$taxonomy];
						if( $wp_query->query_vars['taxonomy']=='event-category' || $wp_query->query_vars['taxonomy']=='event-tag') {
							  $args_cat = array( $taxonomy => "$taxonomy_category");
							  $post_type='events';
							  
						}
						else if( $wp_query->query_vars['taxonomy']=='album-category' || $wp_query->query_vars['taxonomy']=='album-tag') {
							  $args_cat = array( $taxonomy => "$taxonomy_category");
							  $post_type='albums';
							  
						}  
						else {
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
                    	<article <?php post_class(); ?>>
                        
                            <div class="blog-text webkit">
                                <div class="blog-date webkit"><time datetime="<?php echo date('d-m-y',strtotime(get_the_date()));?>"><?php echo date('d',strtotime(get_the_date()));?></time><span class="uppercase"><?php echo date('M',strtotime(get_the_date()));?></span></div>
                                <div class="text <?php if(isset($post_icon) && $post_icon <> ''){?>ad-icon<?php }?>">
                                    <?php if(isset($post_icon) && $post_icon <> ''){?><i class="fa <?php echo $post_icon;?> fa-2x backcolr"></i><?php }?>
                                    <h2 class="cs-post-title cs-heading-color"><a href="<?php the_permalink();?>" class="colrhover"><?php the_title(); ?></a></h2>
                                         <p><?php echo cs_get_the_excerpt(255,true);?></p>
    
                                </div>
                            </div>
                            <ul class="post-options">
                                <li><i class="fa fa-user"></i><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"> <?php echo get_the_author(); ?></a></li>
                               <?php edit_post_link( __( '<li><i class="fa fa-pencil-square-o"></i></li>', 'Spikes'), '', '' ); ?>
                            </ul>
                    </article>
                    <?php endwhile;  endif;  ?>
                  
        		</div>
                
                  <?php
                         $qrystr = '';
                        // pagination start
                        	if ($custom_query->found_posts > get_option('posts_per_page')) {
                            	
                                     if ( isset($_GET['page_id']) ) $qrystr .= "&page_id=".$_GET['page_id'];
									 if ( isset($_GET['author']) ) $qrystr .= "&author=".$_GET['author'];
									 if ( isset($_GET['tag']) ) $qrystr .= "&tag=".$_GET['tag'];
									 if ( isset($_GET['cat']) ) $qrystr .= "&cat=".$_GET['cat'];
									 if ( isset($_GET['event-category']) ) $qrystr .= "&event-category=".$_GET['event-category'];
									 if ( isset($_GET['event-tag']) ) $qrystr .= "&event-tag=".$_GET['event-tag'];
									 if ( isset($_GET['album-category']) ) $qrystr .= "&album-category=".$_GET['album-category'];
									 if ( isset($_GET['album-tag']) ) $qrystr .= "&album-tag=".$_GET['album-tag'];
									 if ( isset($_GET['m']) ) $qrystr .= "&m=".$_GET['m'];
 						        echo cs_pagination($custom_query->found_posts,get_option('posts_per_page'), $qrystr);
                               
                            }
                        // pagination end
                    
				?>
        </div>  
        <?php
            if ( $cs_layout <> '' and $cs_layout  <> "none" and $cs_layout  == 'right' ) { ?>
                <aside class="col-lg-3 col-md-3 sidebar-right">
 						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_theme_option['cs_sidebar_right']) ) : endif; ?>
                 </aside>
        <?php 
			}
         ?>	
         
<?php get_footer(); ?>