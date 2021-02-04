<?php
	cs_slider_gallery_template_redirect();
	global $cs_node,$cs_theme_option,$counter_node,$video_width;
	$cs_node = new stdClass();
  	get_header();
	$cs_layout = '';
	$post_xml = get_post_meta($post->ID, "post", true);	
	if ( $post_xml <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($post_xml);
		$cs_layout = $cs_xmlObject->sidebar_layout->cs_layout;
 		$cs_sidebar_left = $cs_xmlObject->sidebar_layout->cs_sidebar_left;
		$cs_sidebar_right = $cs_xmlObject->sidebar_layout->cs_sidebar_right;
		if ( $cs_layout == "left") {
			$cs_layout = "content-right col-lg-9 col-md-9";
			$custom_height = 320;
 		}
		else if ( $cs_layout == "right" ) {
			$cs_layout = "content-left col-lg-9 col-md-9";
			$custom_height = 320;
 		}
		else {
			$cs_layout = "col-md-12";
			$custom_height = 430;
		}
 	}else{
		$cs_layout = "col-md-12";
	}
	if (have_posts()):
		while (have_posts()) : the_post();
			$image_id = get_post_thumbnail_id($post->ID);
			$post_xml = get_post_meta($post->ID, "post", true);	
			if ( $post_xml <> "" ) {
				$cs_xmlObject = new SimpleXMLElement($post_xml);
				$post_view = $cs_xmlObject->inside_post_thumb_view;
 				$post_video = $cs_xmlObject->inside_post_thumb_video;
				$post_audio = $cs_xmlObject->inside_post_thumb_audio;
				$post_slider = $cs_xmlObject->inside_post_thumb_slider;
				$post_slider_type = $cs_xmlObject->inside_post_thumb_slider_type;
				$post_featured_image = $cs_xmlObject->inside_post_featured_image_as_thumbnail;
				$width = 1170;
				$height = 430;
				$image_url = cs_get_post_img_src($post->ID, $width, $height);
			}
			else {
				$cs_xmlObject = new stdClass();
				$post_view = '';
 				$post_video = '';
				$post_audio = '';
				$post_slider = '';
				$post_slider_type = '';
				$width = 0;
				$height = 0;
				$image_id = 0;
				$cs_xmlObject->post_social_sharing = '';
				$cs_xmlObject->post_related = '';
			}								
			?>
                        <!-- Need to add code below in function file to call it on all pages -->
                        <!--Left Sidebar Starts-->
                      <?php if ($cs_layout == 'content-right col-lg-9 col-md-9'){ ?>
                            <aside class="sidebar-left col-md-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_left) ) : ?><?php endif; ?></aside>
                        <?php } ?>
                        <!--Left Sidebar End-->
                        <!-- Blog Detail Start -->
                        <div class="<?php echo $cs_layout; ?>">
							<!-- Blog Start -->
							<div class="blog blogdetail  fullwidth">
                       		 	<article>
                     				<!-- Blog Post Thumbnail Start -->
                        	 		<figure class="detail_figure" >
										<?php
											if ( $post_view == "Map" and $post_view <> ''){
												$cs_node->map_lat = $cs_xmlObject->inside_post_thumb_map_lat;
												$cs_node->map_lon = $cs_xmlObject->inside_post_thumb_map_lon;
												$cs_node->map_zoom = $cs_xmlObject->inside_post_thumb_map_zoom;
												$cs_node->map_info = $cs_xmlObject->inside_post_thumb_map_address;
												$cs_node->map_controls = $cs_xmlObject->inside_post_thumb_map_controls;
												$cs_node->map_height = $height;
												$cs_node->map_element_size = 'default';
												$cs_node->map_title = '';
												$cs_node->map_show_marker = '';
												
												echo cs_map_page();
											}elseif( $post_view == "Slider" and $post_slider <> "" and $post_view <> ''){
                                                 cs_flex_slider($width, $height,$post_slider);
                                            } elseif($post_view == "Single Image"){ 
                                                echo '<img src="'.$image_url.'" >';
                                              }elseif($post_view == "Video" and $post_video <> '' and $post_view <> ''){
												  
                                                $url = parse_url($post_video);
												
                                                if($url['host'] == $_SERVER["SERVER_NAME"]){?>
                                                    <video width="<?php echo $width;?>" class="mejs-wmp" height="100%"  style="width: 100%; height: 100%;" src="<?php echo $post_video ?>"  id="player1" poster="<?php if($post_featured_image == "on"){ echo $image_url; } ?>" controls="controls" preload="none"></video>
                                                <?php
                                                }else{
                                                      echo wp_oembed_get($post_video,array('height'=>$custom_height));
                                                }
                                            }elseif($post_view == "Audio" and $post_view <> ''){
												?>
												<audio style="width:100%;" src="<?php echo $post_audio; ?>" type="audio/mp3" controls="controls"></audio>
                                                <?php
											}
											?>
                                     </figure>
                                 	<!-- Blog Post Thumbnail End -->
                                    <!-- Post Options Start -->
                            		<div class="postpanel">
                                        <ul class="post-options">
                                        	<?php echo cs_featured(); ?>
                                            <li> <em class='fa fa-calendar'></em><time datetime="<?php echo date('Y-m-d',strtotime(get_the_date()));?>"><?php echo get_the_date();?></time>
                                            <?php
												  /* translators: used between list items, there is a space after the comma */
												  $before_cat = "<li><em class='fa fa-list'></em>".__( '','Rocky')."";
												  $categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '</li>' );
												  if ( $categories_list ){
													  printf( __( '%1$s', 'Rocky'),$categories_list );
												  }
											?>
                                           <?php  if ( comments_open() ) { echo "<li><em class='fa fa-comment'></em>";comments_popup_link( __( 'Comment', 'Rocky' ) , __( 'Comment', 'Rocky' ), __( 'Comment', 'Rocky' ) ); echo "</li>"; } ?>
                                        </ul>
                                    </div>
                                    <!-- Post Options End -->
                   			<!-- Blog Post End -->
                            <!-- Detail Text Start -->
                                <div class="detail_text fullwidth rich_editor_text">
                                     <?php the_content();
								wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Rocky' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); 
								?>
                                </div>   
							</article>

                            <!-- Post Text End -->
                            <!-- Post Media attachment-->
                            <div class="mediaelements-post fullwidth lightbox">
							<?php 
                            $args = array(
                               'post_type' => 'attachment',
                               'numberposts' => -1,
                               'post_status' => null,
                               'post_parent' => $post->ID
                              );
                              $attachments = get_posts( $args );
                                 if ( $attachments ) {
                                     cs_enqueue_gallery_style_script();
                                    foreach ( $attachments as $attachment ) {
                                        $attachment_title = apply_filters( 'the_title', $attachment->post_title );
                                       $type = get_post_mime_type( $attachment->ID );
                                       if($type=='image/jpeg'){
                                          ?>
                                           <a <?php if ( $attachment_title <> '' ) { echo 'data-title="'.$attachment_title.'"'; }?> href="<?php echo $attachment->guid; ?>" data-rel="<?php echo "prettyPhoto[gallery1]"?>" class="me-imgbox"><?php echo wp_get_attachment_image( $attachment->ID, array(270,152),true ) ?></a>
                                        <?php
										
                                        } elseif($type=='audio/mpeg') {
                                            ?>
                                           <!-- Button to trigger modal -->
                                            <a href="#audioattachment<?php echo $attachment->ID;?>" role="button" data-toggle="modal" class="iconbox"><em class="fa fa-microphone"></em></a>
                                            <!-- Modal -->
                                        <div class="modal fade" id="audioattachment<?php echo $attachment->ID;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            								<div class="modal-dialog">
                                            	<audio style="width:100%;" src="<?php echo $attachment->guid; ?>" type="audio/mp3" controls="controls"></audio>
                                            </div>
                                         </div>
                                        <?php
                                        } elseif($type=='video/mp4') {
                                         ?>
                                            <a href="#videoattachment<?php echo $attachment->ID;?>" role="button" data-toggle="modal" class="iconbox"><em class="fa fa-play"></em></a>
                                            <div class="modal fade" id="videoattachment<?php echo $attachment->ID;?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <video width="100%" class="mejs-wmp" height="380" src="<?php echo $attachment->guid; ?>"  id="player1" poster="" controls="controls" preload="none"></video>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                      }
                                 }
                              ?>
                              </ul>
                            </div>
                            <!-- Post Media attachment end-->
                            <!-- Share Post Start -->
                            <div class="share_post fullwidth">
                            <div class="float-left sharing-section">
                                <a class="btn btnsharenow" ><em class="fa fa-share"> </em> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Share Now','Rocky');}else{ echo $cs_theme_option['trans_share_this_post']; } ?></a>
                                <?php  cs_social_share(); ?>
                                
                                <?php 
									$before_cat = '<div class="tags-area"> <em class="fa fa-tags"></em>';
									$categories_list = get_the_term_list ( get_the_id(), 'post_tag', $before_cat, ', ', '</div>' );
									if ( $categories_list ){ printf( __( '%1$s', 'Rocky' ),$categories_list ); }
									?>
                        </div>
                          <?php cs_next_prev_post();?>
                       </div>
                            <!-- Post Sharing Section End -->
                            <!-- About Author Start -->
                            <?php 
							if (get_the_author_meta('description')){ ?>
                     			<div class="about-author fullwidth">
 	                                <!-- Thumbnail List Start -->
									<!-- Thumbnail List Item Start -->
									<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="float-left"><?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('PixFill_author_bio_avatar_size', 60)); ?></a>
                                    <div class="text">
                                    	<h4><a class="colr" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"> <?php echo get_the_author(); ?></a> <?php echo cs_get_user_role(); ?></h4>
                                        <p><?php the_author_meta('description'); ?></p>
                                        <?php if(get_the_author_meta('twitter') <> ''){?><a href="http://twitter.com/<?php the_author_meta('twitter'); ?>" class="btn tweet_follow"><em class="fa fa-twitter"></em> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Follow Us on Twitter','Rocky');}else{ echo $cs_theme_option['trans_follow_twitter']; } ?></a><?php }?>
                       					<?php if(get_the_author_meta('url') <> ''){?><a href="<?php the_author_meta('url'); ?>" class="btn view_blog"><em class="fa fa-pencil"></em> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('View More Blogs','Rocky');}else{ echo $cs_theme_option['trans_view_more_blogs']; } ?></a><?php }?>
                                  	</div>
                              	</div>
                                <!-- About Author End -->
                        <?php } ?>
                        <?php comments_template('', true); ?>
					</div>
                    <!-- Blog Post End -->
               	</div>
			  	<?php endwhile;   endif;?>
                <!--Content Area End-->
                <!--Right Sidebar Starts-->
                  <?php if ( $cs_layout  == 'content-left col-lg-9 col-md-9'){ ?>
                	<aside class="sidebar-right col-md-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_right) ) : ?><?php endif; ?></aside>
                <?php } ?>

<!-- Columns End -->
<!--Footer-->
<?php get_footer(); ?>
