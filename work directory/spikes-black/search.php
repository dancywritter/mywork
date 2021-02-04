<?php
	get_header();
	global  $cs_theme_option; 
 	$cs_layout = $cs_theme_option['cs_layout'];

		if ( $cs_layout <> '' and $cs_layout  <> "none" and $cs_layout  == 'left') :  ?>
			<aside class="<?php cs_default_pages_sidebar_class($cs_layout )?>"><?php cs_default_pages_sidebar()?></aside>
	<?php endif; ?>	
        	<div class="<?php cs_default_pages_meta_content_class( $cs_layout ); ?>">
             	<div class="postlist blog">
                 <!-- Blog Post Start -->
                 <?php
               		if ( have_posts() ) : 
						 while ( have_posts() ) : the_post();
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
				<?php endwhile; else:?>
                    <div class="pagenone">
                        <span class="icon-warning-sign icon-4"></span>
                        <h1><?php _e( 'No results found.', 'Spikes'); ?></h1>
                        <div class="password_protected">
                            <?php get_search_form(); ?>
                        </div>
                    </div>
                	<?php endif;?>
               	</div>
                <?php
                	$qrystr = '';
                    // pagination start
					if ($wp_query->found_posts > get_option('posts_per_page')) {

							if ( isset($_GET['s']) ) $qrystr = "&s=".$_GET['s'];
							if ( isset($_GET['page_id']) ) $qrystr .= "&page_id=".$_GET['page_id'];
							echo cs_pagination($wp_query->found_posts,get_option('posts_per_page'), $qrystr);
					}
					// pagination end
             	?>                    
             </div>
			<?php
                if ( $cs_layout <> '' and $cs_layout  <> "none" and $cs_layout  == 'right') :  ?>
                    <aside class="<?php cs_default_pages_sidebar_class( $cs_theme_option['cs_layout'] )?>"><?php cs_default_pages_sidebar()?></aside>
            <?php endif; ?>	
<?php get_footer();?>
<!-- Columns End -->