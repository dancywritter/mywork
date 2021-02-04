<?php
	cs_slider_gallery_template_redirect();
	 cs_enqueue_masonry_style_script();
 	 cs_enqueue_gallery_style_script();
	 
	global $cs_theme_option, $cs_blog_large_layout;
  	get_header();
	$image_url = $cs_layout = $cs_sidebar_left = $cs_sidebar_righ = '';
	if (have_posts()):
	while (have_posts()) : the_post();
			$image_id = get_post_thumbnail_id($post->ID);
			$post_xml = get_post_meta($post->ID, "post", true);	
			$custom_height = 411;
			if ( $post_xml <> "" ) {
				$cs_xmlObject = new SimpleXMLElement($post_xml);
				$post_view = $cs_xmlObject->inside_post_thumb_view;
 				$post_video = $cs_xmlObject->inside_post_thumb_video;
				$post_audio = $cs_xmlObject->inside_post_thumb_audio;
				$post_slider = $cs_xmlObject->inside_post_thumb_slider;
				$post_slider_type = $cs_xmlObject->inside_post_thumb_slider_type;
				$inside_post_thumb_gallery = $cs_xmlObject->inside_post_thumb_gallery;
				$post_featured_image = $cs_xmlObject->inside_post_featured_image_as_thumbnail;
				$width = 890;
				$height = 468;
				$cs_layout = $cs_xmlObject->sidebar_layout->cs_layout;
				$cs_sidebar_left = $cs_xmlObject->sidebar_layout->cs_sidebar_left;
				$cs_sidebar_right = $cs_xmlObject->sidebar_layout->cs_sidebar_right;
				if ( $cs_layout == "left") {
					$cs_layout = "content-left col-md-9 col-sm-9";
				}
				else if ( $cs_layout == "right" ) {
					$cs_layout = "content-right col-md-9 col-sm-9";
				}
				else {
					$cs_layout = "col-md-12";
					
				}
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
				$cs_blog_large_layout  = '';
				$image_id = '';
				$cs_xmlObject->post_social_sharing = '';
				$cs_xmlObject->post_related = '';
				$post_slider = $inside_post_thumb_gallery = $image_url = $post_audio = $post_video = '';
			}
			$custom_height = 411;
			$custom_width = 890;
			if($cs_blog_large_layout == 'cs_wide_layout'){
				$custom_width 	= 485;
				$custom_height	=340;
			} else {
				$custom_width 	= 1093;
				$custom_height	=340;	
			}
			cs_enqueue_masonry_style_script();
			?>
            
            <div class="<?php echo $cs_layout;?> ">
            	
                    <?php if ($cs_layout == 'content-left col-md-9 col-sm-9'){ ?>
                            <div class="aside table-cell-right"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_left) ) : ?><?php endif; ?></div>
                    <?php } ?>
                        <div class="detail-text blog <?php if ($cs_layout == 'col-md-12'){ ?>  cs-full-width <?php //echo $cs_layout;?><?php }?>">
                        	<?php 
						if( $post_view == "Slider" and $post_slider <> "" ){
                                     cs_swiper_slider($width, $height,$post_slider,$post->ID,'');
								}elseif($post_view == "Gallery" and $inside_post_thumb_gallery <> "" ){
									echo "<figure class='cs-slideshowify'>";
										cs_slideshowify_slider($width, $height,$inside_post_thumb_gallery);
									echo "</figure>";
                                }elseif($post_view == "Single Image" && $image_url <> ''){
                                    if($image_url <> ''){ echo '<figure class="detail-figure"><a><img class="wp-post-image" src="'.$image_url.'" alt=""></a></figure>';}
                                }elseif($post_view == "Video" && $post_video <> ''){
                                    $url = parse_url($post_video);
									 echo "<figure class='detail-figure'>";
                                    if($url['host'] == $_SERVER["SERVER_NAME"]){
                                    ?>
                                    <script>
										jQuery('audio,video').mediaelementplayer({
											sfeatures: ['playpause']
										});
									</script>
                                        <video width="100%" class="mejs-wmp" height="<?php echo $custom_height;?>" src="<?php echo $post_video ?>"  poster="<?php if($post_featured_image == "on"){ echo $image_url; } ?>" controls="controls" preload="none"></video>
                                    <?php
                                    }else{
                                        echo wp_oembed_get($post_video,array('width'=>$custom_width));
                                    }
									echo "</figure>";
                                }elseif($post_view == "Audio" and $post_audio <> ''){
									echo "<figure class='detail-figure'>";
                                ?>
                                <script>
									jQuery('audio,video').mediaelementplayer({
										sfeatures: ['playpause']
									});
                            	</script>
                                <div class="audiowrapp fullwidth">
                                    <audio style="width:100%;" src="<?php echo $post_audio; ?>" type="audio/mp3" controls="controls"></audio>
                                </div>    
                                <?php
								echo "</figure>";
                                }
 					?>
                            <!--<figure class="thumb-img">
                            	<a href="<?php //echo get_author_posts_url(get_the_author_meta('ID')); ?>" data-toggle="tooltip" title="<?php //the_author_meta('nicename'); ?>"><?php //echo get_avatar(get_the_author_meta('user_email'), apply_filters('PixFill_author_bio_avatar_size', 48)); ?></a>
                            </figure>-->
                            <script>
                                jQuery(document).ready(function($) {
                                    $('[data-toggle]').tooltip();
                                });
                            </script>
                            <div class="inner-sec">
                                <?php cs_next_prev_post();?>
                                <h2><?php the_title();?></h2>
                                <ul class="post-options">
                                    <li><i class="fa fa-clock-o"></i><?php echo get_the_date();?></li>
                                    <?php
										  /* translators: used between list items, there is a space after the comma */
										  $before_cat = "<li><i class='fa fa-folder-open'></i>".__( '','Snapture')."";
										  $categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '</li>' );
										  if ( $categories_list ){
											  printf( __( '%1$s', 'Snapture'),$categories_list );
										  }
									?>
                                    <?php 
									if ( comments_open() ) {  echo "<li><i class='fa fa-comment'></i>"; comments_popup_link( __( '0 Comment', 'Snapture' ) , __( '1 Comment', 'Snapture' ), __( '% Comment', 'Snapture' ) ); } ?>
                                </ul>
                                <?php the_content();
								wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Snapture' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );?>
                                <!-- Share Post Start -->
                                <div class="share_post">
                                	<?php 
										$before_cat = '<div class="tagcloud">';
										$categories_list = get_the_term_list ( get_the_id(), 'post_tag', $before_cat, ', ', '</div>' );
										if ( $categories_list ){ printf( __( '%1$s', 'Snapture' ),$categories_list ); }
										
										if($cs_xmlObject->post_social_sharing == 'on') { cs_social_share();}
									?>
                                </div>
                                <!-- Share Post End -->
                                <!-- Comments Start -->
                                <?php comments_template('', true); ?>
                                <!-- Comments End -->
                            </div>
                        </div>
                    </div>
                    <!-- Col 2 Start -->
					 <?php if ( $cs_layout  == 'content-right col-md-9 col-sm-9'){ ?>
                        <div class="aside table-cell-right col-md-3">
							<div class="cs-right-widgets">
							<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_right) ) : ?><?php endif; ?>
                            </div>
                        </div>
                    <?php } ?>
                    
                    <!-- Col 2 End -->
    <!-- Blog Detail Start -->
 <?php endwhile;   endif;?>
<!--Footer-->
<?php  get_footer(); ?>