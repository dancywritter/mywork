<?php
// Header File
 get_header();
 global  $cs_theme_option; 
 isset($cs_theme_option['cs_layout']);  $cs_layout = $cs_theme_option['cs_layout'];
 ?> <div id="main" role="main">
        <!-- Container Start -->
            <div class="container">
                <!-- Row Start -->
                <div class="row">
 <?php if ( have_posts() ) : ?>
 	<div class="<?php cs_default_pages_meta_content_class( $cs_layout ); ?>">
		<div class="postlist blog">
			<?php /* The loop */
			
				 if (empty($_GET['page_id_all']))
                        $_GET['page_id_all'] = 1;
                    if (!isset($_GET["s"])) {
                        $_GET["s"] = '';
                    }
			  while ( have_posts() ) : the_post();  ?>
            	<article <?php post_class(); ?>>
							<div class="blog_text webkit">
									<!-- Thumb Start -->
									<div class="post-thumb">
                                    	<time><h2 class="uppercase"><?php echo date('d',strtotime(get_the_date()));?><span><?php echo date('M',strtotime(get_the_date()));?></span></h2></time>
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
													  $categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '' );
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
                     <?php endwhile; ?>
 					 <?php
                        $qrystr = '';
                        // pagination start
                        	if ( $cs_theme_option['pagination'] == "Show Pagination" and $wp_query->found_posts > get_option('posts_per_page')) {
                            	echo "<nav class='pagination'><ul>";
                                     if ( isset($_GET['page_id']) ) $qrystr .= "&page_id=".$_GET['page_id'];
									 if ( isset($_GET['author']) ) $qrystr .= "&author=".$_GET['author'];
									 if ( isset($_GET['tag']) ) $qrystr .= "&tag=".$_GET['tag'];
									 if ( isset($_GET['cat']) ) $qrystr .= "&cat=".$_GET['cat'];
									 if ( isset($_GET['event-category']) ) $qrystr .= "&event-category=".$_GET['event-category'];
									 if ( isset($_GET['m']) ) $qrystr .= "&m=".$_GET['m'];
									 
						        echo cs_pagination(wp_count_posts()->publish,get_option('posts_per_page'), $qrystr);
                                echo "</ul></nav>";
                            }
                        // pagination end
 				?>
                     <?php endif; ?>
                     
 </div>
 <?php
 //Footer FIle
 get_footer();
?>