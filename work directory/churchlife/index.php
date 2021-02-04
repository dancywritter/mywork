<?php
// Header File
 get_header();
  if ( have_posts() ) : ?>
		<div class="blog blog-large sing-page-area">
			<?php /* The loop */
			
				 if (empty($_GET['page_id_all']))
                        $_GET['page_id_all'] = 1;
                    if (!isset($_GET["s"])) {
                        $_GET["s"] = '';
                    }
			 ?>
            
			<?php while ( have_posts() ) : the_post(); 
                        
						px_defautlt_artilce();
 					
                      endwhile; 
                        $qrystr = '';
                        // pagination start
                        	if ( $px_theme_option['pagination'] == "Show Pagination" and $wp_query->found_posts > get_option('posts_per_page')) {
                            	echo "<nav class='pagination'><ul>";
                                     if ( isset($_GET['page_id']) ) $qrystr .= "&page_id=".$_GET['page_id'];
									 if ( isset($_GET['author']) ) $qrystr .= "&author=".$_GET['author'];
									 if ( isset($_GET['tag']) ) $qrystr .= "&tag=".$_GET['tag'];
									 if ( isset($_GET['cat']) ) $qrystr .= "&cat=".$_GET['cat'];
									 if ( isset($_GET['sermon-tag']) ) $qrystr .= "&sermon-tag=".$_GET['sermon-tag'];
									 if ( isset($_GET['sermon-category']) ) $qrystr .= "&sermon-category=".$_GET['sermon-category'];
									 if ( isset($_GET['event-category']) ) $qrystr .= "&event-category=".$_GET['event-category'];
									 if ( isset($_GET['m']) ) $qrystr .= "&m=".$_GET['m'];
									 
						        echo px_pagination(wp_count_posts()->publish,get_option('posts_per_page'), $qrystr);
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