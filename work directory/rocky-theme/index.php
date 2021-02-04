<?php
// Header File
 get_header();
?>
<?php if ( have_posts() ) : ?>
	<div class="postlist cs-blog cs-home">
		<?php /* The loop */
			if (empty($_GET['page_id_all']))
            $_GET['page_id_all'] = 1;
            if (!isset($_GET["s"])) {
            	$_GET["s"] = '';
            }
	 	?>
		<?php while ( have_posts() ) : the_post();  ?>
        	<article <?php post_class(); ?>>
            <div class="blog_text fullwidth">
                <div class="fullwidth">
                    <div class="head-group">
                        <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h2>
                        <div class="postpanel">
                            <ul class="post-options">
                                <li><?php printf( '<em>'.__('By: %s','Rocky').'</em>', '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="colr">'.get_the_author().'</a>' );?> on <time datetime="<?php echo date('Y-m-d',strtotime(get_the_date()));?>"><?php echo get_the_date();?></time>  </li>
                                 <?php  if ( comments_open() ) { echo "<li><em class='fa fa-comment'></em>";comments_popup_link( __( 'Comment', 'Rocky' ) , __( 'Comment', 'Rocky' ), __( 'Comment', 'Rocky' ) ); echo "</li>"; } ?>
                                
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="text"><p><?php echo cs_get_the_excerpt(255,true);?></p></div>
                <?php edit_post_link( __( 'Edit', 'Rocky'), '<li><span class="edit-link">', '</span></li>' ); ?>
            </div>
        </article>
        <?php endwhile; ?>
		<?php
          $qrystr = '';
          // pagination start
             if ( $cs_theme_option['pagination'] == "Show Pagination" and $wp_query->found_posts > get_option('posts_per_page')) {
				 if ( isset($_GET['page_id']) ) $qrystr .= "&page_id=".$_GET['page_id'];
				 if ( isset($_GET['author']) ) $qrystr .= "&author=".$_GET['author'];
				 if ( isset($_GET['tag']) ) $qrystr .= "&tag=".$_GET['tag'];
				 if ( isset($_GET['cat']) ) $qrystr .= "&cat=".$_GET['cat'];
				 if ( isset($_GET['event-category']) ) $qrystr .= "&event-category=".$_GET['event-category'];
				 if ( isset($_GET['m']) ) $qrystr .= "&m=".$_GET['m'];
                 echo cs_pagination(wp_count_posts()->publish,get_option('posts_per_page'), $qrystr);
              }
          // pagination end
        ?>
        <?php endif; ?>
        
 </div>
 <?php
 //Footer FIle
 get_footer();
?>