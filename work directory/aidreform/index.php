<?php
// Header File
 get_header();
 ?> <div id="main" role="main">
        <!-- Container Start -->
            <div class="container">
                <!-- Row Start -->
                <div class="row">
 <?php if ( have_posts() ) : ?>
		<div class="postlist blog archive-page">
			<?php /* The loop */
			
				 if (empty($_GET['page_id_all']))
                        $_GET['page_id_all'] = 1;
                    if (!isset($_GET["s"])) {
                        $_GET["s"] = '';
                    }
			 ?>
            
			<?php while ( have_posts() ) : the_post();  ?>
 					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
                            <!-- Text Start -->
                            <div class="blog_text webkit">
                            	<div class="text">
									<?php cs_featured(); ?>
									<h2 class="heading-color post-title"><a href="<?php the_permalink(); ?>" class="colrhover"><?php the_title(); ?></a></h2>
								</div>
                            		<ul class="post-options">
								  <li><i class="icon icon-user">&nbsp;</i><?php printf( __('%s','AidReform'), '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" >'.get_the_author().'</a>' );?></li>
                                  <li>
                                      <i class="icon icon-calendar">&nbsp;</i>
                                      <time datetime="<?php echo date('Y-m-d',strtotime(get_the_date()));?>"><?php echo get_the_date();?></time>
                                  </li>
								  
                                  <li><?php  if ( comments_open() ) {echo '<i class="icon-comment"></i>'; comments_popup_link( __( '0', 'AidReform' ) , __( '1', 'AidReform' ), __( '%', 'AidReform' ) );  } ?></li>
								  
                                  <?php edit_post_link( __( 'Edit', 'AidReform'), '<li><span class="edit-link">', '</span></li>' ); ?>
                           	</ul> 
                            	<p><?php echo cs_get_the_excerpt(255,true); ?></p>
                            </div>
                            <!-- Text End -->
                                                       
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