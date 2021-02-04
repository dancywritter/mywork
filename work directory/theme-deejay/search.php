<?php
	get_header();
	global  $px_theme_option; 
 	$px_layout = $px_theme_option['px_layout'];
?>	
			<?php
    			if ( $px_layout <> '' and $px_layout  <> "none" and $px_layout  == 'left' or $px_layout  == 'both') :  ?>
					<aside class="col-md-3">
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($px_theme_option['px_sidebar_left']) ) : endif; ?>
					</aside>
   			<?php wp_reset_query();endif; ?>	
        	<div class="<?php px_default_pages_meta_content_class( $px_layout ); ?>">
             	<div class="blog blog-medium">
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
                            	<h2 class="section_title heading-color"><?php _e( 'No results found.', 'Deejay'); ?></h2>
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
			<?php
                if ( $px_layout <> '' and $px_layout  <> "none" and $px_layout  == 'right' or $px_layout  == 'both') :  ?>
                    <aside class=" col-md-3">
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($px_theme_option['px_sidebar_left']) ) : endif; ?>
					</aside>
            <?php wp_reset_query();endif; ?>	
<?php get_footer();?>
<!-- Columns End -->