<?php
// Header File
 get_header();
 if ( have_posts() ) : ?>
	<div class="postlist blog">
                 <!-- Blog Post Start -->
                 <?php
				 if (empty($_GET['page_id_all']))
                        $_GET['page_id_all'] = 1;
                    if (!isset($_GET["s"])) {
                        $_GET["s"] = '';
                    }
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

 endif;
 //Footer FIle
 get_footer();
?>