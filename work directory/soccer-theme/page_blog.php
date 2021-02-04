 <?php
 	global $px_node,$post,$px_theme_option,$px_counter_node,$px_meta_page; 
	$image_url = '';
   	if ( !isset($px_node->var_pb_blog_num_post) || empty($px_node->var_pb_blog_num_post) ) { $px_node->var_pb_blog_num_post = -1; }
		if($px_node->var_pb_blog_view =="blog-carousel"){
			$clses= 'blog-grid';
			$divstart= '<div class="pix-content-wrap">';
			$divend= '</div>';
		}else{
			$clses ='';
			$divstart = '';
			$divend = '';
		}
	?>
	<div class="element_size_<?php echo $px_node->blog_element_size; ?>">
    	<?php
		if($px_node->var_pb_featured_cat <> ''){
			$args = array('posts_per_page' => "3",  'category_name' => "$px_node->var_pb_featured_cat");
            $custom_query = new WP_Query($args);
			if($custom_query->have_posts()):
		?>
            <div class="pix-blog blog-carousel-view">
                <div class="cycle-slideshow"
                    data-cycle-fx=scrollHorz
                    pagination=".cycle-pager"
                    data-cycle-slides=">article"
                    data-cycle-timeout=3000>
                    <div class="cycle-pager"></div>
                    <?php 
                        px_enqueue_cycle_script();
                        while ($custom_query->have_posts()) : $custom_query->the_post();
                        $image_url = px_get_post_img_src($post->ID,1100,556); 
                       	if($image_url <> ""){ ?>
                        	<article>
                                <figure><a href="<?php the_permalink(); ?>"><img src="<?php echo $image_url;?>" alt=""></a></figure>
                                <div class="text">
                                    <h2 class="pix-post-title"><a href="<?php the_permalink(); ?>" class="pix-colrhvr"><?php the_title(); ?></a></h2>
                                    <?php px_get_the_excerpt(255,false); ?>
                                </div>
                      		</article>
                      <?php }?>
                       <?php endwhile; ?>
                   </div>
             </div>
        <?php endif; 
		}
		?> 
		<?php echo $divstart;?>
    	<div class="pix-blog <?php echo $px_node->var_pb_blog_view; ?> <?php echo $clses; ?>">
		
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
			if($px_node->var_pb_blog_view =="blog-large"){
				$width = 1102;
				$height = 376;
			}elseif($px_node->var_pb_blog_view =="blog-medium"){
				$width = 240;
				$height = 180;
			}else{
				$width = 370;
				$height = 184;
			}
		
			if($px_node->var_pb_blog_view !="blog-carousel"){
              	if ($px_node->var_pb_blog_title <> '') { ?>
                <header class="pix-heading-title">
                    <?php	if ($px_node->var_pb_blog_title <> '') { ?>
                    <h2 class="pix-heading-color pix-section-title"><?php echo $px_node->var_pb_blog_title; ?></h2>
					<?php  } ?>
                </header>
        <?php  }  
            while ($custom_query->have_posts()) : $custom_query->the_post();
				$post_xml = get_post_meta($post->ID, "post", true);	
				$blog_classes = array();
				if ( $post_xml <> "" ) {
					$px_xmlObject = new SimpleXMLElement($post_xml);
					$no_image = '';
 					$image_url = px_get_post_img_src($post->ID,$width,$height);
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
                         <?php 
 							px_get_the_excerpt($px_node->var_pb_blog_excerpt,false);
							wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Soccer Club' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                           ?>
                          
                        <div class="blog-bottom">
                     		<?php px_posted_on(true,false,false,false,true,false);?>
                         	<?php if($px_node->var_pb_blog_view !="blog-grid"){?>
                            	<a href="<?php the_permalink(); ?>" class="btnreadmore btn pix-bgcolrhvr"><i class="fa fa-plus"></i>READ MORE</a>
                            <?php } ?>
                     	</div>
                    </div>
                </article>
				<!-- Blog Post End -->
               	<?php endwhile;  ?>
                 	<!-- Blog End -->
                    <?php }else{
						px_enqueue_cycle_script();
						?>
                           <header class="pix-heading-title">
                              <?php	if ($px_node->var_pb_blog_title <> '') { ?>
                              <h2 class="pix-heading-color pix-section-title"><?php echo $px_node->var_pb_blog_title; ?></h2>
                              <?php  } ?>
                               <div class="carousel-default-button">
                                          <span class="cycle-prev btn pix-bgcolrhvr" id="cycle-prev-2"> <i class="fa fa-long-arrow-left"></i></span>
                                          <span class="cycle-next btn pix-bgcolrhvr" id="cycle-next-2"> <i class="fa fa-long-arrow-right"></i></span>
                                      </div>
                           </header>
                             <div class="cycle-slideshow fullwidth"
                                    data-cycle-fx=carousel
                                    data-cycle-next="#cycle-next-2"
                                    data-cycle-prev="#cycle-prev-2"
                                    data-cycle-slides=">article"
                                    data-cycle-timeout=3000>
                                    <!-- Blog Post Start -->
                                    <?php
                                    while ($custom_query->have_posts()) : $custom_query->the_post();
									$post_xml = get_post_meta($post->ID, "post", true);	
									$blog_classes = array();
									if ( $post_xml <> "" ) {
										$px_xmlObject = new SimpleXMLElement($post_xml);
										$no_image = '';
										$image_url = px_get_post_img_src($post->ID,236,158);
										$image_url_full = px_get_post_img_src($post->ID, '' ,'');
										if($image_url == ""){
											$blog_classes[] = 'no-image';
										}
										}else{
											$image_url = '';	
											$post_view = '';
											$no_image = '';	
											$image_url_full = '';
										}	
 									$format = get_post_format( $post->ID );
									?>
                                    <article <?php post_class($blog_classes); ?>>
                                    <?php if($image_url <> ""){?>
                                        <figure><a href="<?php the_permalink(); ?>"><img src="<?php echo $image_url;?>" alt=""></a></figure>
                                    <?php }?>
                                    <div class="text">
                                      <h2 class="pix-post-title"><a href="<?php the_permalink(); ?>" class="pix-colrhvr">
									  	<?php echo px_title_lenght(get_the_title(),0,45); ?></a>
                                      </h2>
                                         <?php 
 											px_get_the_excerpt($px_node->var_pb_blog_excerpt,false); 
                                            wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Soccer Club' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                                            ?>
                                        <div class="blog-bottom">
                                            <?php px_posted_on(false,false,false,true,false,true);?>
                                         </div>
                                    </div>
                                </article>
                        	<?php endwhile;  ?>
                        	<!-- Blog Post End -->
                            </div>
                    </div>
		<?php } ?>
              
              <?php echo $divend = ''; ?>
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