<?php
get_header();
	global  $cs_theme_option; 
	cs_enqueue_masonry_style_script();
 ?>
 <style>
 	.archive-page .box{
		display:inline-block;
		
	}
 </style>
  <?php 
			 if(is_author()){
				 global $author;
				 $userdata = get_userdata($author);
			 }
			 if(category_description() || is_tag() || (is_author() && isset($userdata->description) && !empty($userdata->description))){
				echo '<div class="rich_editor_text detail-text"><div class="column-wrapp-box heading-area"><div class="detail_text_wrapp col-counter">';
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
<script>
			 	jQuery(document).ready(function($) {
					default_mas_gallery();
					jQuery(window).load(function() {
						default_mas_gallery();
					});

				});
			 </script>
          <div class="postlist postlist-mas-listing archive-page" id="default_mas_gallery">
   
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
					$post_type = array( 'post', 'portfolio' );
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
					if( $wp_query->query_vars['taxonomy']=='portfolio-category' || $wp_query->query_vars['taxonomy']=='portfolio-tag') {
						$album_archive = 1;
					  $args_cat = array( $taxonomy => "$taxonomy_category");
					  $post_type='portfolio';
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
				'posts_per_page' => get_option('posts_per_page'),
				'paged'			 => $_GET['page_id_all'],
				'post_status'	 => 'publish', 
				'order'			 => 'ASC',
			);
			$args = array_merge($args_cat,$args);
			$custom_query = new WP_Query($args);
			 ?>
			<?php if ( $custom_query->have_posts() ): 
				while ( $custom_query->have_posts() ) : $custom_query->the_post();
				$event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);  
				?> 
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
				<?php endwhile;  endif; 
                       
				?>
 </div>
<?php
  $qrystr = '';
// pagination start
	if ($custom_query->found_posts > get_option('posts_per_page')) {
			 if ( isset($_GET['page_id']) ) $qrystr .= "&page_id=".$_GET['page_id'];
			 if ( isset($_GET['author']) ) $qrystr .= "&author=".$_GET['author'];
			 if ( isset($_GET['tag']) ) $qrystr .= "&tag=".$_GET['tag'];
			 if ( isset($_GET['cat']) ) $qrystr .= "&cat=".$_GET['cat'];
			 if ( isset($_GET['portfolio-category']) ) $qrystr .= "&portfolio-category=".$_GET['portfolio-category'];
			 if ( isset($_GET['m']) ) $qrystr .= "&m=".$_GET['m'];
		echo cs_pagination($custom_query->found_posts,get_option('posts_per_page'), $qrystr);
	}
// pagination end


 get_footer(); ?>