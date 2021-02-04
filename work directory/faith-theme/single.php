<?php
	cs_slider_gallery_template_redirect();
	global $cs_node,$cs_theme_option,$cs_counter_node,$cs_video_width;
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
			$custom_height = 348;
 		}
		else if ( $cs_layout == "right" ) {
			$cs_layout = "content-left col-md-9";
			$custom_height = 348;
 		}
		else {
			$cs_layout = "col-md-12";
			$custom_height = 354;
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
				$post_gallery = $cs_xmlObject->inside_post_thumb_gallery;
				$post_author_description =$cs_xmlObject->post_author_description;
				
				$width = 1058;
				$height = 364;
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
				$custom_height = 364;
				$post_gallery = '';
				$post_author_description = '';
				$cs_xmlObject->post_related_posts = '';
				$cs_xmlObject->related_posts_title = '';
				$cs_xmlObject->post_social_sharing = '';
				
 			}		
			?>
      
            <!-- Need to add code below in function file to call it on all pages -->
            <!--Left Sidebar Starts-->
            <?php if ($cs_layout == 'content-right col-md-9'){ ?>
               <div class="col-lg-3 col-md-3 col-sm-3">
                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_left) ) : ?><?php endif; ?>
               </div>
            <?php } ?>
            <!--Left Sidebar End-->
            <!-- Blog Detail Start -->
            <div class="<?php echo $cs_layout; ?> lightbox">
                <!-- Blog Start -->
                <!-- Blog Post Start -->
                <div class="blog blog-detail">
                <article <?php post_class(cs_post_type($post_view ,$image_url)); ?>>
                    <?php if(isset($post_view) and $post_view <> ''){
                         echo '<figure class="detail-figure">';
                         ?>
                            <!-- Blog Post Thumbnail Start -->
                    <?php
                        if( $post_view == "Slider" and $post_slider <> ''){
                           
                             cs_flex_slider($width, $height,$post_slider);
                         }elseif($post_view == "Single Image" && $image_url <> ''){ 
                             echo '<img src="'.$image_url.'" >';
                           }elseif($post_view == "Video" and $post_video <> '' and $post_view <> ''){
                              $url = parse_url($post_video);
                             if($url['host'] == $_SERVER["SERVER_NAME"]){?>
                                <video width="<?php echo $width;?>" class="mejs-wmp" height="100%"  style="width: 100%; height: 100%;" src="<?php echo $post_video ?>"  id="player1" poster="<?php if($post_featured_image == "on"){ echo $image_url; } ?>" controls="controls" preload="none"></video>
                            <?php
                            }else{
                                  echo wp_oembed_get($post_video,array('height' => $custom_height));
                            }
                         }elseif($post_view == "Audio" and $post_view <> ''){
                             ?>
                             <figcaption class="gallery">
                                <div class="audiowrapp fullwidth">
                                    <audio style="width:100%;" src="<?php echo $post_audio; ?>" type="audio/mp3" controls="controls"></audio>
                                </div>  
                            </figcaption>
                            <?php
                          
                        }elseif($post_view == "Gallery"){
                            if($image_url <> ''){ 
                            echo '<a href="'.get_permalink().'" ><img src="'.$image_url.'" alt="" ></a>';
                             }
                             echo cs_post_gallery($post_gallery);
                        }
                          echo '</figure>';
                        ?>
                 <?php } ?>
                     
                    <div class="detail-text rich_editor_text">
                        <?php the_content();

                            wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Faith' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                      ?>
                    </div>
                    <div class="cs-attachments mediaelements-post fullwidth lightbox">
							<?php 
                            $args = array(
                               'post_type' => 'attachment',
                               'numberposts' => -1,
                               'post_status' => null,
                               'post_parent' => $post->ID
                              );
                              $attachments = get_posts( $args );
                                 if ( $attachments ) {
                                     foreach ( $attachments as $attachment ) {
                                        $attachment_title = apply_filters( 'the_title', $attachment->post_title );
                                       $type = get_post_mime_type( $attachment->ID );
                                       if($type=='image/jpeg'){
                                          ?>
                                           <a <?php if ( $attachment_title <> '' ) { echo 'data-title="'.$attachment_title.'"'; }?> href="<?php echo $attachment->guid; ?>" data-rel="<?php echo "prettyPhoto[gallery1]"?>" class="me-imgbox"> <figure>
 										 <?php $attachment_image= wp_get_attachment_image_src( $attachment->ID, array(330,248),true ); ?> 
                                           <img src="<?php echo $attachment_image[0]; ?>"  alt="" />
                                           <i class="fa fa-plus-circle"></i>
                                           </figure></a>
                                        <?php
										
                                        } elseif($type=='audio/mpeg') {
                                            ?>
                                           <!-- Button to trigger modal -->
                                            <a>
                                             <figure>
                                             <audio style="width:100%;" src="<?php echo $attachment->guid; ?>" type="audio/mp3" controls="controls"></audio>
                                           </figure>
                                           </a>
                                            <!-- Modal -->
                                        
                                        <?php
                                        } elseif($type=='video/mp4') {
                                         ?>
                                           
                                            <a href="#videoattachment<?php echo $attachment->ID;?>" role="button" data-toggle="modal" class="iconbox"
                                            ><figure><i class="fa fa-video-camera"></i></figure></a>
                                            <div class="modal fade in" id="videoattachment<?php echo $attachment->ID;?>" class="modal hide fade">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
      <div class="modal-header">
                                                    <video width="100%" class="mejs-wmp" height="380" src="<?php echo $attachment->guid; ?>"  id="player1" poster="" controls="controls" preload="none"></video>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                      }
                                 }
                              ?>
                              </ul>
                            </div>
                </article>
                <!-- Post tags Section -->
                <div class="share-post">
                    <div class="cs-post-top-section">
                    	<div class="cs-share-comment-link">
                       		<?php 
							if ($cs_xmlObject->post_social_sharing == "on"){
								cs_addthis_script_init_method();
							?>
							<a class="addthis_button_compact backcolrhover" href="#">
								<i class="fa fa-share-square-o"></i>
								<?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Share post','Faith');}else{ echo $cs_theme_option['trans_share_this_post']; } ?> </a>
							<?php
							}
							if ( comments_open() ) {
							?>
								 <a href="#respond"><i class="fa fa-comments"></i><?php _e('Leave a Reply','Faith'); ?></a>
							<?php
							}
							?>
                            </div>
                    </div>
                </div>
                <!-- Post tags Section Close -->
                <?php
                echo cs_next_prev_post();
                ?>
                <!-- About Author Section -->
                <?php
                if($post_author_description == 'on'){
                    cs_author_description();
                }
                ?>
                <!-- About Author Section Close -->
                <?php if($cs_xmlObject->post_related_posts == 'on'){ ?>
                <!--Related Blog Post Section-->
                <div class="element_size_100">
                    <?php if($cs_xmlObject->related_posts_title <> ''){ ?>
                     <header class="cs-heading-title">
                        <h2 class="cs-section-title"><?php echo $cs_xmlObject->related_posts_title; ?></h2>
                     </header>
                    <?php } ?>
                    <div class="blog blog-grid">
                        <?php
                        wp_reset_query();
                        $custom_taxterms='';
                        $custom_taxterms = wp_get_object_terms( $post->ID, array('category', 'post_tag'), array('fields' => 'ids') );
                        // arguments
                        $args = array(
                            'post_type' => 'post',
                            'post_status' => 'publish',
                            'posts_per_page' => 3, // you may edit this number
                            'orderby' => 'DESC',
                            'tax_query' => array(
                                'relation' => 'OR',
                                array(
                                    'taxonomy' => 'post_tag',
                                    'field' => 'id',
                                    'terms' => $custom_taxterms
                                ),
                                array(
                                    'taxonomy' => 'category',
                                    'field' => 'id',
                                    'terms' => $custom_taxterms
                                )
                            ),
                            'post__not_in' => array ($post->ID),
                        ); 
                        $custom_query = new WP_Query($args);
                        $counter_posts_db = 0;
                        if($custom_query->have_posts()):
                        while ( $custom_query->have_posts()) : $custom_query->the_post();
                             $cs_album = get_post_meta($post->ID, "post", true);
                             if ( $cs_album <> "" ) {
                                  $cs_xmlObject = new SimpleXMLElement($cs_album);
                             }
                            $counter_posts_db++;
                            $width 	= 325;
                            $height	= 183;
                            $cats = array();
                            $image_url = cs_get_post_img_src($post->ID, $width, $height);                    
                        ?>
                        <article <?php post_class(cs_post_type($post_view ,$image_url)); ?>>
                            <figure>
                            <?php 
                                if($image_url <> ''){
                                    echo "<img src=".$image_url." alt='' >";
                                } else {
                                    echo '<img src="' . get_template_directory_uri() . '/images/Dummy.jpg" alt="" />';
                                }
                                echo '<figcaption>
                                 <a href="'.get_permalink().'"><i class="fa fa-plus-circle"></i></a>
                                </figcaption>';
                            ?>
                            </figure>
                             <div class="text">
                                <h2 class="heading-color cs-post-title"><a href="<?php the_permalink(); ?>" class="cs-colrhvr">
                                <?php echo substr(get_the_title(),0,20); if(strlen(get_the_title()) > 20) { echo "...";} ?></a></h2>
                             </div>
                        </article>
                        <?php endwhile; endif;
                        wp_reset_query();
                        ?> 
                    </div>
                </div>
                <!--Related Blog Post Section Close-->
                <?php } ?>
               
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
