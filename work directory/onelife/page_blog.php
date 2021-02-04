 <?php
 	global $cs_node,$post,$cs_theme_option,$cs_counter_node,$cs_video_width; 
 	if ( !isset($cs_node->cs_blog_num_post) || empty($cs_node->cs_blog_num_post) ) { $cs_node->cs_blog_num_post = -1; }
    cs_enqueue_gallery_style_script();
    cs_enqueue_jcycle_script();
	?>
	<div class="<?php cs_blog_classes($cs_node->cs_blog_view);?> element_size_<?php echo $cs_node->blog_element_size; ?> <?php  echo $cs_node->cs_blog_view; ?> <?php if($cs_node->cs_blog_title == ''){ echo 'no-heading';} ?> lightbox">
		 <?php	if ($cs_node->cs_blog_title <> '') { ?>
                <header class="heading">
                    <h2 class="heading-color section-title"><?php echo $cs_node->cs_blog_title; ?></h2>
                </header>
        <?php  } ?>
     	<!-- Blog Start -->
		<?php
            if (empty($_GET['page_id_all'])) $_GET['page_id_all'] = 1;
            $args = array('posts_per_page' => "-1", 'paged' => $_GET['page_id_all'], 'category_name' => "$cs_node->cs_blog_cat",'post_status' => 'publish');
            $custom_query = new WP_Query($args);
            $post_count = $custom_query->post_count;
            $count_post = 0;
            // if ($cs_node->cs_blog_pagination == "Single Page") $cs_node->cs_blog_num_post = $cs_node->cs_blog_num_post;
            $args = array('posts_per_page' => "$cs_node->cs_blog_num_post", 'paged' => $_GET['page_id_all'], 'category_name' => "$cs_node->cs_blog_cat");
            $custom_query = new WP_Query($args);
            $cs_counter = 0;
			if($cs_node->cs_blog_view == "blog-masonry-four-col" || $cs_node->cs_blog_view == "blog-masonry-three-col" ){
				 cs_enqueue_masonry_style_script();

				 ?>
                  <script type="text/javascript">
              		jQuery(document).ready(function(){ 
 						var container = jQuery('#container<?php echo $cs_counter_node; ?>, .blog #container<?php echo $cs_counter_node;?>');
						jQuery(container).imagesLoaded( function(){
						jQuery(container).isotope({
						columnWidth: 10,
						itemSelector: '.box'
 						});
					});
					if (jQuery.browser.msie && navigator.userAgent.indexOf('Trident')!==-1){
						jQuery(container).isotope({
						columnWidth: 10,
						itemSelector: '.box'
 					});
				}	
 				});
               </script>
                <?php
				
				echo '<div class="bolg_column mas-con" id="container'.$cs_counter_node.'">';	
				if(have_posts()):
					if( cs_meta_content_class() == "span12"){
					if($cs_node->cs_blog_view == "blog-masonry-four-col"){ $custom_width = 270; $custom_height = 152; }elseif($cs_node->cs_blog_view == "blog-masonry-three-col"){ $custom_width = 370; $custom_height = 156;  }	
					}elseif( cs_meta_content_class() == "span9"){
						if($cs_node->cs_blog_view == "blog-masonry-four-col"){ $custom_height = 134; }elseif($cs_node->cs_blog_view == "blog-masonry-three-col"){ $custom_width = 270; $custom_height = 152; }
					}elseif( cs_meta_content_class() == "span6"){
						$custom_width = 370;
						$custom_height = 278;
					}
				while ($custom_query->have_posts()) : $custom_query->the_post();
                $post_xml = get_post_meta($post->ID, "post", true);	
                if ( $post_xml <> "" ) {
                    $cs_xmlObject = new SimpleXMLElement($post_xml);
                    $post_view = $cs_xmlObject->post_thumb_view;
                    $post_image = $cs_xmlObject->post_thumb_image;
                    $post_video = $cs_xmlObject->post_thumb_video;
					$post_audio = $cs_xmlObject->post_thumb_audio;
					$post_slider = $cs_xmlObject->post_thumb_slider;
 					$width = 1170;
					$height = 487;
                    $image_url = cs_attachment_image_src(get_post_thumbnail_id($post->ID),$width,$height);
					$image_url_full = cs_get_post_img_src($post->ID, '', '');
                 }else{
					$post_view = '';
					$image_url_full = '';
				}
				?>
                 <div class="box photo">
                	<!-- List Post Start -->
                    <article <?php post_class(); ?> >
						<!-- Blog Post Thumbnail Start -->
						<figure>
							<?php
                                if ( $post_view == "Map" ){
                                    $cs_node->map_lat = $cs_xmlObject->post_thumb_map_lat;
                                    $cs_node->map_lon = $cs_xmlObject->post_thumb_map_lon;
                                    $cs_node->map_zoom = $cs_xmlObject->post_thumb_map_zoom;
                                    $cs_node->map_info = $cs_xmlObject->post_thumb_map_address;
                                    $cs_node->map_controls = $cs_xmlObject->post_thumb_map_controls;
                                    $cs_node->map_height = $height;
                                    echo cs_map_page();
                                }elseif( $post_view == "Slider" and $post_slider <> ''){
                                     cs_flex_slider($width,$height,$post_slider);
                                }elseif($post_view == "Single Image"){
                                     echo "<a href='".get_permalink()."' ><img src='".$image_url."' alt=''></a>";
									echo '<figcaption class="backcolr">
										<div class="share-icons">
											<a class="icon-zoom-in icon-2x webkit" href="'.$image_url_full.'" data-rel="prettyPhoto"></a>
											<a class="icon-link icon-2x webkit" href="'.get_permalink().'"></a>
										</div>
                                	</figcaption>';
                                }elseif($post_view == "Video" and $post_video <> ''){
                                    $url = parse_url($post_video);
                                    if($url['host'] == $_SERVER["SERVER_NAME"]){?>
                                        <video width="100%" height="100%" class="mejs-wmp" src="<?php echo $post_video ?>" poster="<?php echo $image_url; ?>"  controls="controls" preload="none"></video>
                                <?php
                                    }else{
                                        echo wp_oembed_get($post_video);
                                    }
                                }elseif($post_view == "Audio" and $post_audio <> ''){
                                ?>
                                    <audio style="width:100%;" src="<?php echo $post_audio; ?>"  controls="controls"></audio>
                                <?php	
                                }
                            ?>
							</figure>
                            <!-- Text Start -->
                            <div class="blog_text">
                                <!-- Post Text Start -->
                                <div class="post-text">
                                    <!-- Post Options Start -->
                                    <ul class="post-options">
                                        <li>
                                            <i class="icon-time">&nbsp;</i>
                                            <time datetime="<?php echo date('Y-m-d',strtotime(get_the_date()));?>"><?php echo get_the_date();?></time>
                                        </li>
                                        <li>
                                        	<?php
												/* translators: used between list items, there is a space after the comma */
												$before_cat = "<i class=icon-reorder>&nbsp;</i>";
												$categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '' );
												if ( $categories_list ){
													printf( __( '%1$s', 'OneLife'),$categories_list );
												}
                                      		?>
                                        </li>
                                        <?php edit_post_link( __( 'Edit', 'OneLife'), '<li><span class="edit-link">', '</span></li>' ); ?>
                                    </ul>
                                    <!-- Post Options End -->
                                    <?php cs_featured(); ?>
									<header><h2 class="heading-color post-title"><a href="<?php the_permalink(); ?>" class="colrhover"><?php echo substr(get_the_title(),0,30); ?></a></h2></header>
                                    <?php if($cs_node->cs_blog_description == "yes"){?><p><?php echo cs_get_the_excerpt($cs_node->cs_blog_excerpt,true) ?></p><?php } ?>
                                </div>
                                <!-- Post Text End -->
                                <!-- Post Thumb Start -->
                                <div class="post-thumb">
                                	<p><i class="icon icon-user">&nbsp;</i> <?php printf( __('%s','OneLife'), '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="colrhover">'.get_the_author().'</a>' );?></p>
                                    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('PixFill_author_bio_avatar_size', 61)); ?></a>
                                </div>
                                <!-- Post Thumb End -->
                            </div>
                            <!-- Text End -->
                                                       
						</article>
                    <!-- Blog Post End -->
               	</div>
                <?php
				endwhile; endif;
              	echo '</div>';
			}else{
				$custom_width = 1170; 
				$custom_height = 487;	
				if( cs_meta_content_class() == "span12"){
					if($cs_node->cs_blog_view == "blog-large"){$custom_width = 1170; $custom_height = 487; }elseif($cs_node->cs_blog_view == "blog-medium"){  $custom_width = 370; $custom_height = 203; }	
					
				}elseif( cs_meta_content_class() == "span9"){
					if($cs_node->cs_blog_view == "blog-large"){ $custom_width = 870; $custom_height = 362; }elseif($cs_node->cs_blog_view == "blog-medium"){  $custom_width = 370; $custom_height = 203; }
					
				}elseif( cs_meta_content_class() == "span6"){
					if($cs_node->cs_blog_view == "blog-large"){ $custom_width = 572; $custom_height = 238; }elseif($cs_node->cs_blog_view == "blog-medium"){  $custom_width = 370; $custom_height = 203; }
					$custom_width = 270;
					$custom_height = 203;
 				}
            	while ($custom_query->have_posts()) : $custom_query->the_post();
					$post_xml = get_post_meta($post->ID, "post", true);	
					if ( $post_xml <> "" ) {
						$cs_xmlObject = new SimpleXMLElement($post_xml);
						$post_view = $cs_xmlObject->post_thumb_view;
						$post_image = $cs_xmlObject->post_thumb_image;
						$post_featured_image = $cs_xmlObject->post_featured_image_as_thumbnail;
						$post_video = $cs_xmlObject->post_thumb_video;
						$post_audio = $cs_xmlObject->post_thumb_audio;
						$post_slider = $cs_xmlObject->post_thumb_slider;
 						$no_image = '';
						if($cs_node->cs_blog_view == "blog-medium"){
							$width 	= 370;
							$height	= 278;
						}else{
							$width 	=1170;
							$height	=487;
 						}
						$image_url = cs_get_post_img_src($post->ID, $width, $height);
						$image_url_full = cs_get_post_img_src($post->ID, '', '');
						if($image_url == "" and $post_view == "Single Image"){
							$no_image = 'no-image';
						}
					}else{
						$post_view = '';
						$no_image = '';	
						$image_url_full = '';
					}	
					?>
                    <!-- Blog Post Start -->
                    <article <?php post_class($no_image); ?>>
                        <!-- Blog Post Thumbnail Start -->
                        <figure>
                            <?php
 							 	if ( $post_view == "Map" ){
									$cs_node->map_lat = $cs_xmlObject->post_thumb_map_lat;
									$cs_node->map_lon = $cs_xmlObject->post_thumb_map_lon;
									$cs_node->map_zoom = $cs_xmlObject->post_thumb_map_zoom;
									$cs_node->map_info = $cs_xmlObject->post_thumb_map_address;
									$cs_node->map_control = $cs_xmlObject->post_thumb_map_controls;
									$cs_node->map_height = $custom_height;
									echo cs_map_page( $cs_node);
								}elseif ( $post_view == "Slider" and $post_slider <> ''){
                                     cs_flex_slider($width, $height,$post_slider);
                                }elseif($post_view == "Single Image"){
                                	if($image_url <> ''){ echo "<a href='".get_permalink()."' ><img src=".$image_url." alt='' ></a>";
									echo '<figcaption class="backcolr">
										<div class="share-icons">
											<a class="icon-zoom-in icon-2x webkit" href="'.$image_url_full.'" data-rel="prettyPhoto"></a>
											<a class="icon-link icon-2x webkit" href="'.get_permalink().'"></a>
										</div>
                                	</figcaption>';
									}
                                }elseif($post_view == "Video"){
									$url = parse_url($post_video);
									if($url['host'] == $_SERVER["SERVER_NAME"]){
									?>
										<video width="100%" class="mejs-wmp" height="<?php echo $custom_height; ?>" src="<?php echo $post_video ?>" id="player1" poster="<?php if($post_featured_image == "on"){ echo $image_url; } ?>" controls="controls" preload="none"></video>
									<?php
									}else{
  									  	echo wp_oembed_get($post_video,array('width' => $custom_width,'height' => $custom_height));
									}
								}elseif($post_view == "Audio" and $post_audio <> ''){
								?>
									<audio style="width:100%;" src="<?php echo $post_audio; ?>" type="audio/mp3" controls="controls"></audio>
								<?php
								}
   	
							?>	
                        </figure>
                        <!-- Blog Post Thumbnail End -->
                        <div class="blog_text webkit">
                        	<!-- Thumb Start -->
                            <?php 
 								if($cs_node->cs_blog_view == 'blog-large'){ 
									cs_blog_avatar(); 
								}
							?>
                            <!-- Thumb End -->
                            <!-- Post Text Start -->
                            <div class="post-text">
                            	<?php cs_featured(); ?>
								<h2 class="heading-color post-title"><a href="<?php the_permalink(); ?>" class="colrhover"><?php the_title(); ?></a></h2>
                                <!-- Post Options Start -->
								<ul class="post-options">
                                    <li><i class="icon icon-user">&nbsp;</i><?php printf( __('%s','OneLife'), '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="colrhover">'.get_the_author().'</a>' );?></li>
                                          <?php
                                            /* translators: used between list items, there is a space after the comma */
                                            $before_cat = "<li><i class='icon icon-reorder'>&nbsp;</i>";
                                            $categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '</li>' );
                                            if ( $categories_list ){
                                                printf( __( '%1$s', 'OneLife'),$categories_list );
                                            }
                                        ?>
                                    <li>
                                        <?php  if ( comments_open() ) { echo "<i class='icon-comment'>&nbsp;</i>";comments_popup_link( __( '0', 'OneLife' ) , __( '1', 'OneLife' ), __( '%', 'OneLife' ) ); echo ' <a href="'.get_permalink().'#respond">' . __( 'Comments', 'OneLife' ).'</a>'; } ?>
                                    </li>
                                    <?php
                                        /* translators: used between list items, there is a space after the comma */
                                        $before_tag = "<li><i class='icon icon-tag'>&nbsp;</i>";
                                        $tags_list = get_the_term_list ( get_the_id(), 'post_tag',$before_tag, ', ', '</li>' );
                                        if ( $tags_list){
                                            printf( __( '%1$s', 'OneLife'),$tags_list ); 
                                        } // End if categories 
                                    ?>  
                                    <?php edit_post_link( __( 'Edit', 'OneLife'), '<li><span class="edit-link">', '</span></li>' ); ?>
                           		</ul>
                            	<!-- Post Options End -->
                                <!-- Thumb Start -->
                            	<?php 
 									if($cs_node->cs_blog_view == 'blog-medium'){ 
										cs_blog_avatar(); 
									}?>	
                            	<!-- Thumb End -->
                                <?php if($cs_node->cs_blog_description == "yes"){?>
 									<p><?php  cs_get_the_excerpt($cs_node->cs_blog_excerpt,true);?></p>
                            	<?php }?>
                            </div>
                            <!-- Post Text End -->
                          </div>
                     </article>
                     <?php wp_link_pages( $args ); ?>
                    <!-- Blog Post End -->
               		<?php endwhile; } ?>
                 	<!-- Blog End -->
    			</div>   
                <?php
                $qrystr = '';
                if ( $cs_node->cs_blog_pagination == "Show Pagination" and $post_count > $cs_node->cs_blog_num_post and $cs_node->cs_blog_num_post > 0 ) {
                	echo "<nav class='pagination'><ul>";
                    	if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
                        	echo cs_pagination($post_count, $cs_node->cs_blog_num_post,$qrystr);
                    echo "</ul></nav>";
                }
                 // pagination end
             ?>   	