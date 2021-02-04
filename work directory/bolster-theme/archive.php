<?php
get_header();
	global  $cs_theme_option; 
	cs_enqueue_masonry_style_script();
 ?>
  <script type="text/javascript">
						jQuery(document).ready(function() {
							cs_masonary_callback('blog-gallery');
						});
						
					</script>
<div class="main-section">
    <?php 
			 if(is_author()){
				 global $author;
				 $userdata = get_userdata($author);
			 }
			 if(category_description() || is_tag() || (is_author() && isset($userdata->description) && !empty($userdata->description))){
				echo '<div class="rich_editor_text"><div class="column-wrapp-box heading-area"><div class="detail_text_wrapp col-counter">';
				if(is_author()){
					echo '<h2 class="page-title cs-heading-color">';
					the_author_meta( 'nickname' );
					echo '</h2>';
					echo $userdata->description;
				} elseif ( is_category() ) {
					echo '<h2 class="page-title cs-heading-color">';
						single_cat_title();
					echo '</h2>';
					 echo category_description();
				} elseif(is_tag()){
					echo '<h2 class="page-title cs-heading-color">';
						single_tag_title();
					echo '</h2>';
					$tag_description = tag_description();
					   if ( ! empty( $tag_description ) )
							echo apply_filters( 'tag_archive_meta', $tag_description );
				}
				echo '</div></div></div>';
				
			}?>
 		<div class="cs-blog cs-default-view">
		<div class="blog-gallery">
			<?php
				if (empty($_GET['page_id_all']))
					$_GET['page_id_all'] = 1;
				if (!isset($_GET["s"])) {
					$_GET["s"] = '';
				}
				$author_archive = $calendar_archive = $calendar_archive = $events_archive  = $album_archive = $artists_archive = $blog_cat_archive = $blog_tag_archive = 0;
				$author = '';
				rewind_posts();
				$taxonomy = 'category';
				$taxonomy_tag = 'post_tag';
				$taxonomy_category='';
				$args_cat = array();
				if(is_author()){
					$author_archive = 1;
					$author = $wp_query->query_vars['author'];
					$args_cat = array('author' => $wp_query->query_vars['author']);
					$post_type = array( 'post', 'events', 'albums', 'artists' );
				} elseif(is_date()){
					if(is_month() || is_year() || is_day() || is_time()){
						$calendar_archive = 1;
						$args_cat = array('m' => $wp_query->query_vars['m'],'year' => $wp_query->query_vars['year'],'day' => $wp_query->query_vars['day'],'hour' => $wp_query->query_vars['hour'], 'minute' => $wp_query->query_vars['minute'], 'second' => $wp_query->query_vars['second']);
					}
					$post_type = array( 'post');
				} elseif (isset($wp_query->query_vars['taxonomy']) && !empty($wp_query->query_vars['taxonomy'])){
					$taxonomy = $wp_query->query_vars['taxonomy'];
					$taxonomy_category='';
						$taxonomy_category=$wp_query->query_vars[$taxonomy];
					if( $wp_query->query_vars['taxonomy']=='album-category' || $wp_query->query_vars['taxonomy']=='album-tag') {
						$album_archive = 1;
					  $args_cat = array( $taxonomy => "$taxonomy_category");
					  $post_type='albums';
				  } else if( $wp_query->query_vars['taxonomy']=='event-category' || $wp_query->query_vars['taxonomy']=='event-tag') {
					  $args_cat = array( $taxonomy => "$taxonomy_category");
					  $post_type='events';
						$events_archive = 1;						  
					} else if( $wp_query->query_vars['taxonomy']=='artists-category'  ) {
						$args_cat = array( $taxonomy => "$taxonomy_category");
						$post_type='artists';
						$artists_archive = 1;
						
					} else {
						$taxonomy = 'category';
						$args_cat = array();
						$post_type='post';
					}
				} elseif(is_category()){
					$taxonomy = 'category';
					$args_cat = array();
					$category_blog = $wp_query->query_vars['cat'];
					$blog_cat_archive = 1;
					$post_type='post';
					$args_cat = array( 'cat' => "$category_blog");
				} elseif(is_tag()){
					$taxonomy = 'category';
					$args_cat = array();
					$blog_tag_archive = 1;
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
				'posts_per_page' => "-1",
				//'paged'			 => $_GET['page_id_all'],
				'post_status'	 => 'publish', 
				'order'			 => 'ASC',
			);
			$argsss = array_merge($args_cat,$args);
			$custom_queryy = new WP_Query($argsss);
			$post_count = $custom_queryy->post_count;
			$args = array( 
				'post_type'		 => $post_type, 
				'posts_per_page' => "25",
				'paged'			 => $_GET['page_id_all'],
				'post_status'	 => 'publish', 
				'order'			 => 'ASC',
			);
			$args = array_merge($args_cat,$args);
			$custom_query = new WP_Query($args);
			 ?>
			<?php if ( $custom_query->have_posts() ): ?>
            <?php if ( $post_count>25 ){ ?>
            <script type="text/javascript">
				 jQuery(document).ready(function() {
					 archive_load_more_js('25', '<?php echo $post_count;?>', '<?php echo $author_archive; ?>', '<?php echo $author; ?>', '<?php echo $calendar_archive; ?>', '<?php echo $wp_query->query_vars['m']; ?>', '<?php echo $wp_query->query_vars['year']; ?>', '<?php echo $wp_query->query_vars['hour']; ?>', '<?php echo $wp_query->query_vars['day']; ?>', '<?php echo $wp_query->query_vars['minute']; ?>', '<?php echo $wp_query->query_vars['second']; ?>', '<?php echo $taxonomy; ?>', '<?php echo $taxonomy_category; ?>', '<?php echo $events_archive; ?>', '<?php echo $album_archive; ?>', '<?php echo $artists_archive; ?>', '<?php echo $blog_cat_archive; ?>', '<?php echo $wp_query->query_vars['cat']; ?>', '<?php echo $blog_tag_archive; ?>', '<?php echo $wp_query->query_vars['tag']; ?>', '<?php echo home_url() ?>', '<?php echo get_template_directory_uri() ?>');
			   });
			 </script>
				<?php
			}
				while ( $custom_query->have_posts() ) : $custom_query->the_post();
				$event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);  
				?> 
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
				<?php endwhile;  endif;  ?>
			  
		</div>
		</div>
 </div>
<?php get_footer(); ?>