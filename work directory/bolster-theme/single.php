<?php
	cs_slider_gallery_template_redirect();
	 cs_enqueue_masonry_style_script();
 	 cs_enqueue_gallery_style_script();
	global $cs_theme_option;
  	get_header();
	$image_url = '';
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
				$width = 800;
				$height = 800;
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
				$image_id = '';
				$cs_xmlObject->post_social_sharing = '';
				$cs_xmlObject->post_related = '';
			}
			?>
            <div class="main-section">
            <div class="main-wrapp blog blogdetail"> 
                <!-- Article Start -->
                <figure class="<?php if($image_url <> ''){ echo 'wideimg parallaxbg featured-img-wrapper inline-item'; $cs_feature_class= 'cs-featured-image'; }else{ echo 'no-image'; $cs_feature_class = ''; }?>">
                <?php 
				  	if($image_url <> ''){
						cs_enqueue_parallax();
						echo '<img class="wp-post-image" src="'.$image_url.'" alt="">';
						
 					?>
                    <script type="text/javascript">
						jQuery(document).ready(function() {
							cs_parallax();
						});
						jQuery(window).resize(function() {
                            		cs_parallax();
								});
					</script>
                    <?php } ?>
                   </figure>
                	<div class="right-content <?php echo $cs_feature_class; ?>">
                      	<!-- Article Figure -->
                       	<div class="column-wrapp-box detail_text">
                      		<div class="detail_text_wrapp col-counter">
                                <h6><strong><?php printf( __('%s','Bolster'), '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'">'.get_the_author().'</a>' ); ?></strong></h6>
                                <h2 class="post-title"><?php the_title(); ?></h2>
                                <ul class="post-options">
                                  <li>
                                    <time><em class="fa fa-clock-o">&nbsp;</em><?php echo get_the_date();?></time>
                                  </li>
                                    <?php 
                                      /* translators: used between list items, there is a space after the comma */
                                      $before_cat = "<li><em class='fa fa-bars'>&nbsp;</em>".__( '','Bolster')."";
                                      $categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '</li>' );
                                      if ( $categories_list ){
                                          printf( __( '%1$s', 'Bolster'),$categories_list );  
                                      } // End if categories 
                                    ?>
                                    <li>
                                    <?php
                                        $cs_like_counter = '';
                                        $cs_like_counter = get_post_meta(get_the_id(), "cs_like_counter", true);
                                        if ( isset($_COOKIE["cs_like_counter".get_the_id()]) ) { 
                                    ?>
                                            <a class="likes"><em class="fa fa-heart">&nbsp;</em><?php echo $cs_like_counter; ?> <?php if($cs_theme_option['trans_switcher']== "on"){ _e('Likes','Bolster');}else{ echo $cs_theme_option['trans_likes']; } ?></a>
                                    <?php	
                                        } else {?>
                                            <a href="javascript:cs_like_counter('<?php echo get_template_directory_uri()?>',<?php echo get_the_id()?>)" id="like_this<?php echo get_the_id()?>"><em class="fa fa-thumbs-up">&nbsp;</em> <?php if($cs_theme_option['trans_switcher']== "on"){ _e('Like','Bolster');}else{ echo $cs_theme_option['trans_like']; } ?> </a>
                                            <a class="likes" id="you_liked<?php echo get_the_id()?>" style="display:none;"><em class="fa fa-heart">&nbsp;</em> <span id="like_counter<?php echo get_the_id()?>"></span> <?php if($cs_theme_option['trans_switcher']== "on"){ _e('Like','Bolster');}else{ echo $cs_theme_option['trans_like']; } ?> </a>
                                            <div id="loading_div<?php echo get_the_id()?>" style="display:none;"><img src="<?php echo get_template_directory_uri()?>/images/ajax-loader.gif" /></div>
                                    <?php }?>
                                    </li>
                                 </ul>
								<?php 
                                    the_content();
									wp_link_pages();
                                    cs_enqueue_gallery_style_script();
                                    echo "<div class='cs_media_attach lightbox'>";
                                    cs_media_attachment($post->ID,120,120);
                                    echo "</div>";
                                    wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Bolster' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); 
									echo "<div class='album-tags'>";
                                    /* translators: used between list items, there is a space after the comma */
                                    $before_tag = "<h6 class='post-subtitle'>" . __( 'Tags', 'Bolster' ) ."</h6><p>";
                                    $tags_list = get_the_term_list ( get_the_id(), 'post_tag',$before_tag, ', ', '</p>' );
                                    if ( $tags_list){
                                        printf( __( '%1$s', 'Bolster'),$tags_list ); 
                                    } // End if categories 
                                ?>  
                                <?php if($cs_xmlObject->post_social_sharing == "on"){?><a class="btn-share" data-toggle="modal" role="button" href="#myshare"><em class="fa fa-plus-square">&nbsp;</em><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Share','Bolster');}else{ echo $cs_theme_option['trans_share_this_post']; } ?> </a><?php 
								cs_social_share();
								}
								echo '</div>';
								?>
                          
                        <!-- Content Section Close -->  
                        </div>
                       	<!-- Detail Close --> 
                 	</div>
              	<?php 
					if ( comments_open() ){
						comments_template('', true); 
					}else{
						 echo '<div style="width:20px; display:inline-block;"></div>';	
					}
				?>
             </div>
           </div>
          </div>
    <!-- Need to add code below in function file to call it on all pages -->
    <!-- Blog Detail Start -->
 <?php endwhile;   endif;?>
<!--Footer-->
<?php  get_footer(); ?>