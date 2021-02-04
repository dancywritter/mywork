<?php
	cs_slider_gallery_template_redirect();
	global $cs_node,$cs_theme_option,$cs_counter_node;
	$cs_node = new stdClass();
  	get_header();
	$cs_layout = '';
	if (have_posts()):
		while (have_posts()) : the_post();	
	$post_xml = get_post_meta($post->ID, "post", true);	
	if ( $post_xml <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($post_xml);
		$cs_layout = $cs_xmlObject->sidebar_layout->cs_layout;
 		$cs_sidebar_left = $cs_xmlObject->sidebar_layout->cs_sidebar_left;
		$cs_sidebar_right = $cs_xmlObject->sidebar_layout->cs_sidebar_right;
		if ( $cs_layout == "left") {
			$cs_layout = "content-right col-md-9";
			$custom_height = 390;
 		}
		else if ( $cs_layout == "right" ) {
			$cs_layout = "content-left col-md-9";
			$custom_height = 390;
 		}
		else {
			$cs_layout = "col-md-12";
			$custom_height = 390;
		}
 	}else{
		$cs_layout = "col-md-12";
	}

			if ( $post_xml <> "" ) {
				$cs_xmlObject = new SimpleXMLElement($post_xml);
				$post_view = $cs_xmlObject->inside_post_thumb_view;
 				$post_video = $cs_xmlObject->inside_post_thumb_video;
				$post_audio = $cs_xmlObject->inside_post_thumb_audio;
				$post_slider = $cs_xmlObject->inside_post_thumb_slider;
 				$post_featured_image = $cs_xmlObject->inside_post_featured_image_as_thumbnail;
				$width = 716;
				$height = 393;
				$image_url = cs_get_post_img_src($post->ID, $width, $height);
			}
			else {
				$cs_xmlObject = new stdClass();
				$post_view = '';
 				$post_video = '';
				$post_audio = '';
				$post_slider = '';
				$post_slider_type = '';
				$image_url = '';
				$width = 0;
				$height = 0;
				$image_id = 0;
				$custom_height = 390;
				$cs_xmlObject->post_social_sharing = '';
 			}		
			?>
                        <!-- Need to add code below in function file to call it on all pages -->
                        <!--Left Sidebar Starts-->
                        <?php if ($cs_layout == 'content-right col-md-9'){ ?>
                            <div class="col-lg-3 col-md-3 col-sm-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_left) ) : ?><?php endif; ?></div>
                        <?php } ?>
                        <!--Left Sidebar End-->
                        <!-- Blog Detail Start -->
                        <div class="<?php echo $cs_layout; ?>">
							<!-- Blog Start -->
 							<!-- Blog Post Start -->
                            <div class="cs-blog blog_detail">
                            <article <?php post_class(fnc_post_type($post_view ,$image_url)); ?>>
                                <?php if(isset($post_view) and $post_view <> ''){
									
									 ?>
                                        <!-- Blog Post Thumbnail Start -->
								<?php
                                    if( $post_view == "Slider" and $post_slider <> ''){
                                        echo '<figure class="detail_figure">';
                                         cs_flex_slider($width, $height,$post_slider);
										   echo '</figure>';
                                     }elseif($post_view == "Single Image" && $image_url <> ''){ 
                                          echo '<figure class="detail_figure">';
										 echo '<img src="'.$image_url.'" >';
										  echo '</figure>';
                                       }elseif($post_view == "Video" and $post_video <> '' and $post_view <> ''){
                                          
										  $url = parse_url($post_video);
                                         if($url['host'] == $_SERVER["SERVER_NAME"]){?>
                                            <figure class="detail_figure">
                                            <video width="<?php echo $width;?>" class="mejs-wmp" height="100%"  style="width: 100%; height: 100%;" src="<?php echo $post_video ?>"  id="player1" poster="<?php if($post_featured_image == "on"){ echo $image_url; } ?>" controls="controls" preload="none"></video>
                                            </figure>
                                        <?php
                                        }else{
                                              echo wp_oembed_get($post_video,array('height' => $custom_height));
                                        }
                                     }elseif($post_view == "Audio" and $post_view <> ''){
                                          echo '<figure class="detail_figure">';
										 ?>
                                         <figcaption class="gallery">
                                            <div class="audiowrapp fullwidth">
                                                <audio style="width:100%;" src="<?php echo $post_audio; ?>" type="audio/mp3" controls="controls"></audio>
                                            </div>  
                                        </figcaption>
                                        <?php
                                       echo '</figure>';
                                    }
								
                                    ?>
                             <?php } ?>
                             <div class="cs-blog-panel">
                                <ul class="post-options">
                                    <li><i class="fa fa-calendar"></i><time><?php echo get_the_date(); ?></time></li>
                                    <li><i class="fa fa-user"></i><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author(); ?></a></li>
									<?php 
										/* tr
										anslators: used between list items, there is a space after the comma */
										$before_cat = "<li><i class='fa fa-align-justify'></i>";
										$categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '</li>' );
										if ( $categories_list ){
											printf( __( '%1$s', 'WeStand'),$categories_list );
										} // End if categories 
										
										
									$cs_like_counter = '';
									$cs_like_counter = get_post_meta(get_the_id(), "cs_like_counter", true);
									if ( !isset($cs_like_counter) or empty($cs_like_counter) ) $cs_like_counter = 0;
									if ( isset($_COOKIE["cs_like_counter".get_the_id()]) ) { 
									?>
									   <li><a><i class="fa fa-heart"></i><?php echo $cs_like_counter;?></a></li>
								<?php	
									} else {?>
									  <li><a  class="likethis" href="javascript:cs_like_counter('<?php echo get_template_directory_uri()?>',<?php echo get_the_id()?>)" id="like_this<?php echo get_the_id()?>" ><i class="fa fa-heart-o"></i> <span class="count-numbers like_counter<?php echo get_the_id()?>"><?php echo $cs_like_counter; ?></span> </a>
										<a class="likes likethis" id="you_liked<?php echo get_the_id()?>" style="display:none;"><i class="fa fa-heart"></i><span class="count-numbers like_counter<?php echo get_the_id()?>"><?php echo $cs_like_counter; ?></span> </a>
										<div id="loading_div<?php echo get_the_id()?>" style="display:none;"><i class="fa fa-spinner fa-spin"></i></div>
                                 </li>
								<?php }?>
									
                                    
                                    <?php 
                                        if ( comments_open() ) {  echo "<li><i class='fa fa-comment-o'></i>"; comments_popup_link( __( '0 Comment', 'WeStand' ) , __( '1 Comment', 'WeStand' ), __( '% Comment', 'WeStand' ) ); } ?>
                                </ul>
                              </div>
                                <div class="detail_text rich_editor_text">
                                	<?php the_content();
										wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'WeStand' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
								  ?>
                                </div>
                            </article>
                            <!-- Post tags Section -->
								<?php 
								if(isset($cs_xmlObject->post_tags_show) &&  $cs_xmlObject->post_tags_show == 'on'){
                                    /* translators: used between list items, there is a space after the comma */
									$before_cat = "<div class='post-tags'><h6>".__('Tags','WeStand')."<i class='fa fa-tags'></i></h6>";
                                   // $before_cat = "<i class='fa fa-tags'></i>";
                                    $categories_list = get_the_term_list ( get_the_id(), 'post_tag', $before_cat, ' ', '</div>' );
                                    if ( $categories_list ){
                                        printf( __( '%1$s', 'WeStand'),$categories_list );
                                    } // End if categories 
								}
                                ?>
                            <!-- Post tags Section Close -->
                            <div class="share-post">
                            	<?php 
								if ($cs_xmlObject->post_social_sharing == "on"){
									cs_addthis_script_init_method();
								?>
                                <a class="addthis_button_compact btnshare" href="#"><i class="fa fa-share-square-o"></i><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Sahre','WeStand');}else{ echo $cs_theme_option['trans_share_this_post']; } ?> </a>
                                <?php
								}
								?>
                              <?php if(isset($cs_xmlObject->post_pagination_show) &&  $cs_xmlObject->post_pagination_show == 'on'){cs_next_prev_post();} ?>
                            </div>
                            <?php if (isset($cs_xmlObject->post_author_info_show) && $cs_xmlObject->post_author_info_show == "on"){?>
                            	<!-- About Author Section -->
                                <div class="about-author">
                                    <figure><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('PixFill_author_bio_avatar_size', 59)); ?></a></figure>
                                    <div class="text">
                                        <h2><?php echo get_the_author(); ?></h2>
                                        <p><?php the_author_meta('description'); ?></p>
                                        <?php if(get_the_author_meta('twitter') <> ''){?><a class="follow-tweet" href="http://twitter.com/<?php the_author_meta('twitter'); ?>"><i class="fa fa-twitter"></i>@<?php the_author_meta('twitter'); ?></a><?php }?>
                                    </div>
                                </div>
                            <!-- About Author Section Close -->
                          <?php }?>
						<?php comments_template('', true); ?>
                     <!-- Blog Post End -->
                     </div>
               	</div>
		  		<?php endwhile;   endif;?>
                <!--Content Area End-->
                <!--Right Sidebar Starts-->
                <?php if ( $cs_layout  == 'content-left col-md-9'){ ?>
                	<div class="col-lg-3 col-md-3 col-sm-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_right) ) : ?><?php endif; ?></div>
                <?php } ?>
<!-- Columns End -->
<!--Footer-->
<?php get_footer(); ?>
