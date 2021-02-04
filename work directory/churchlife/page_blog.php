 <?php
 
 	global $px_node,$post,$px_theme_option,$px_counter_node,$px_meta_page; 
  	if ( !isset($px_node->var_pb_blog_num_post) || empty($px_node->var_pb_blog_num_post) ) { $px_node->var_pb_blog_num_post = -1; }
	?>
	<div class=" element_size_<?php echo $px_node->blog_element_size; ?>">
    	<?php if ( isset($px_node->var_pb_blog_sidebar) && $px_node->var_pb_blog_sidebar == 'yes') : ?>
        		<?php if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'on'){?>
                		<script type="text/javascript" charset="utf-8">
							  jQuery(".pix-btnsidebar") .click(function(event) {
								/* Act on the event */
								if(jQuery("#right-content").hasClass('pix-active')){
									jQuery(".blog-sidebar").hide();
								} else {
									jQuery(".blog-sidebar").show();
								}
								jQuery("#right-content").toggleClass('pix-active');
								return false;
							  });
						</script>
                <?php }?>
        		<a class="pix-btnsidebar"><i class="fa fa-bars"></i></a>
                <aside class="blog-sidebar" style="display:none;">
                        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-1') ) : endif; ?>
                 </aside>
            <?php endif; ?>
    	<div class="blog blog-large">
		 <?php	if ($px_node->var_pb_blog_title <> '') { ?>
                <header class="pix-heading-title">
                    <?php	if ($px_node->var_pb_blog_title <> '') { ?>
                    <h2 class="px-heading-color pix-section-title"><?php echo $px_node->var_pb_blog_title; ?></h2>
					<?php  } ?>

                </header>
        <?php  } ?>
        <?php if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'on'){?>
        			<script type="text/javascript" charset="utf-8">
						jQuery("audio, video") .mediaelementplayer();
             		</script>
        <?php }?>
     	<!-- Blog Start -->
		<?php
            if (empty($_GET['page_id_all'])) $_GET['page_id_all'] = 1;
            $args = array('posts_per_page' => "-1", 'paged' => $_GET['page_id_all'], 'category_name' => "$px_node->var_pb_blog_cat",'post_status' => 'publish');
            $custom_query = new WP_Query($args);
            $post_count = $custom_query->post_count;
            $count_post = 0;
            $args = array('posts_per_page' => "$px_node->var_pb_blog_num_post", 'paged' => $_GET['page_id_all'], 'category_name' => "$px_node->var_pb_blog_cat");
            $custom_query = new WP_Query($args);
            $px_counter = 0;
            	while ($custom_query->have_posts()) : $custom_query->the_post();
					$post_xml = get_post_meta($post->ID, "post", true);	
					$blog_classes = array();
 					if ( $post_xml <> "" ) {
						$px_xmlObject = new SimpleXMLElement($post_xml);
 						$no_image = '';
						$width = 742;
						$height = 224;
						$image_url = px_get_post_img_src($post->ID, $width, $height);
						$image_url_full = px_get_post_img_src($post->ID, '' ,'');
						if($image_url == ""){
							$blog_classes[] = 'no-image';
						}
					}else{
						$post_view = '';
						$no_image = '';	
						$image_url_full = '';
					}	
					//$format = get_post_format( $post->ID );
					$format = get_post_format( $post->ID );
					?>
                    <!-- Blog Post Start -->
                    <article <?php post_class($blog_classes); ?>>
                	<?php if($image_url <> ""){?>
						<figure><a href="<?php the_permalink(); ?>"><img src="<?php echo $image_url;?>" alt=""></a></figure>
                     <?php }?>
                    <div class="text">
                    	<h2 class="pix-post-title"><a href="<?php the_permalink(); ?>" class="pix-colrhvr"><?php the_title(); ?>.</a></h2>
                        <ul class="post-options">
                        	
                        	<li><?php px_featured();?>
                            <?php if(get_post_format( $post->ID ) <> ''){?>
                                <span class="post-format">
                                    <a class="entry-format" href="<?php echo esc_url( get_post_format_link( get_post_format( $post->ID ) ) ); ?>"><?php echo get_post_format( $post->ID ); ?></a>
                                </span>
                            <?php }?>
                            <span><?php if($px_theme_option['trans_switcher'] == "on"){ _e('Posted on','Church Life');}else{ echo $px_theme_option['trans_posted_on']; } ?></span> <?php if($px_theme_option['trans_switcher'] == "on"){ _e('in','Church Life');}else{ echo $px_theme_option['trans_listed_in']; } ?><time datetime="2020-08-02"><?php echo get_the_date();?></time>
							<?php
                              $before_cat = ", <span>in</span> ".__( '','Church Life')."";
                              $categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '' );
                              if ( $categories_list ){
                                  printf( __( '%1$s', 'Church Life'),$categories_list );
                              }
                            ?>
                           </li>
                        </ul>
                       			 <?php 
									 global $more;
								 	$more = 0;
									the_content(' ::'.$px_theme_option['trans_read_more']);
									wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Church Life' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
								   ?>
                    </div>
                </article>
                    <!-- Blog Post End -->
               <?php endwhile;  ?>
                 	<!-- Blog End -->
                    <div class="clear"></div>
    			</div>   
                <?php
                $qrystr = '';
               if ( $px_node->var_pb_blog_pagination == "Show Pagination" and $post_count > $px_node->var_pb_blog_num_post and $px_node->var_pb_blog_num_post > 0 ) {
                	echo "<nav class='pagination'><ul>";
                    	if ( isset($_GET['page_id']) ) $qrystr = "&amp;page_id=".$_GET['page_id'];
                        	echo px_pagination($post_count, $px_node->var_pb_blog_num_post,$qrystr);
                    echo "</ul></nav>";
                }
                 // pagination end
             ?>
           </div>