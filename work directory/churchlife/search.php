<?php
	get_header();
	global  $px_theme_option; 
?>	
        	<div class="col-md-12 sing-page-area">
             	<div class="blog blog-large">
                 <!-- Blog Post Start -->
                 <?php
                
               		if ( have_posts() ) : 
						 while ( have_posts() ) : the_post();
						 
						 	px_defautlt_artilce();
						  
						endwhile;   
					else:
					?>
                    <aside class="col-md-3">
                		<div class="widget widget_search">
                        	<header class="heading">
                            	<h2 class="section_title heading-color"><?php _e( 'No results found.', 'Church Life'); ?></h2>
                            </header>
                        	<?php get_search_form(); ?>
                    	</div>
                    </aside>
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
							echo px_pagination($wp_query->found_posts,get_option('posts_per_page'), $qrystr);
						 echo "</ul></nav>";
					}
					// pagination end
             	?>                    
             </div>
	
<?php get_footer();?>
<!-- Columns End -->