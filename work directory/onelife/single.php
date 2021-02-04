<?php
	cs_slider_gallery_template_redirect();
	global $cs_node,$cs_theme_option,$cs_counter_node,$cs_video_width;
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
			$cs_layout = "content-right span9";
			$custom_height = 300;
 		}
		else if ( $cs_layout == "right" ) {
			$cs_layout = "content-left span9";
			$custom_height = 300;
 		}elseif( $cs_layout == "both" ){
			$cs_layout = "span6";
			$custom_height = 270;
		}
		else {
			$cs_layout = "span12";
			$custom_height = 487;
		}
 	}else{
		$cs_layout = "span12";
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
 				$post_featured_image = $cs_xmlObject->inside_post_featured_image_as_thumbnail;
				$width = 1170;
				$height = 487;
				$image_url = cs_get_post_img_src($post->ID, $width, $height);
			}
			else {
				$cs_xmlObject = new stdClass();
				$post_view = '';
 				$post_video = '';
				$post_audio = '';
				$post_slider = '';
 				$width = 0;
				$height = 0;
				$image_id = 0;
				$cs_xmlObject->post_social_sharing = '';
				$cs_xmlObject->post_related = '';
			}	
			?>
            <!-- Need to add code below in function file to call it on all pages -->
            <!--Left Sidebar Starts-->
            <?php if ($cs_layout == 'content-right span9' || $cs_layout == 'span6'){ ?>
                <aside class="sidebar-left span3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_left) ) : ?><?php endif; ?></aside>
            <?php } ?>
            <!--Left Sidebar End-->
            <!-- Blog Detail Start -->
            <div class="<?php echo $cs_layout; ?>">
                <!-- Blog Start -->
                <div class="postlist blogdetail">
                    <!-- Blog Post Start -->
                    <article>
                        <!-- Blog Post Thumbnail Start -->
                        <figure class="detail_figure <?php if ($image_id == '') echo 'no-image'; ?>" >
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
                                }elseif( $post_view == "Slider" and $post_slider <> '' and $post_view <> ''){
                                     cs_flex_slider($width, $height,$post_slider);
                                }elseif($post_view == "Single Image"){ 
                                	echo '<a><img src="'.$image_url.'" alt="" ></a>
                                    <span class="cuting_border"></span>';
                                }elseif($post_view == "Video" and $post_video <> '' and $post_view <> ''){
                                    $url = parse_url($post_video);
                                    if($url['host'] == $_SERVER["SERVER_NAME"]){?>
                                    	<video width="<?php echo $width;?>" class="mejs-wmp" height="100%"  style="width: 100%; height: 100%;" src="<?php echo $post_video ?>"  id="player1" poster="<?php if($post_featured_image == "on"){ echo $image_url; } ?>" controls="controls" preload="none"></video>
                                    <?php
                                    }else{
                                    	echo wp_oembed_get($post_video);
                                    }
                                }elseif($post_view == "Audio" and $post_view <> ''){
                                    ?>
                                    <audio style="width:100%;" src="<?php echo $post_audio; ?>" type="audio/mp3" controls="controls"></audio>
                                    <?php
                                }
                                ?>
                        	</figure>
                        	<!-- Blog Post Thumbnail End -->
                         	<!-- Detail Text Start -->
                        	<div class="blog_text">
                                <!-- Post Text Start -->
                                <div class="post-text">
                                	<!-- Post Options Start -->
                      		 		<ul class="post-options">
                                        <li>
                                            <?php cs_featured(); ?>
                                        </li>
                                        <li><i class="icon icon-user">&nbsp;</i><?php printf( __('%s','OneLife'), '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="colr">'.get_the_author().'</a>' );?></li>
                                              <?php
                                                /* translators: used between list items, there is a space after the comma */
                                                $before_cat = "<li><i class='icon icon-reorder'>&nbsp;</i>".__( '','OneLife')."";
                                                $categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '</li>' );
                                                if ( $categories_list ){
                                                    printf( __( '%1$s', 'OneLife'),$categories_list );
                                                }
                                            ?>
                                        <li>
                                            <?php  if ( comments_open() ) { echo "<i class='icon-comment'>&nbsp;</i>";comments_popup_link( __( '0', 'OneLife' ) , __( '1', 'OneLife' ), __( '%', 'OneLife' ) ); echo ' <a href="#respond">' . __( 'Comments', 'OneLife' ).'</a>'; } ?>
                                        </li>
                                        <?php edit_post_link( __( 'Edit', 'OneLife'), '<li><span class="edit-link">', '</span></li>' ); ?>
                                    </ul>
                                                <!-- Post Options End -->
                                 </div>
                        	</div>   
                			<!-- Post Text End -->
                     </article>
               		 <!-- Blog Post End -->
               		<!-- Detail Text Start -->
                    <div class="detail_text rich_editor_text">
                    	<?php 
							the_content();
							wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'OneLife' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
						?>
                        <!-- Post Media attachment-->
                        <?php cs_get_media_attachment(); ?>
                        <!-- Post Media attachment end-->
                    </div>	
                    <!-- Detail Text End -->
                     <!-- Widget Tag Cloud Start -->
                    <div class="widget_tag_cloud">
                    	<?php
							/* translators: used between list items, there is a space after the comma */
							$before_tag = "<h2 class='section-title heading-color'>".__( 'Post','OneLife'). " " . __( 'Tags','OneLife') . "</h2><div class='tagcloud'>";
							$tags_list = get_the_term_list ( get_the_id(), 'post_tag',$before_tag, ' ', '</div>' );
							if ( $tags_list){
								printf( __( '%1$s', 'OneLife'),$tags_list ); 
							} // End if categories 
						?> 
                    </div>
                    <!-- Widget Tag Cloud End -->
                    <!-- Post Change Section Start -->
                    <?php cs_next_prev_post($cs_xmlObject->post_social_sharing); ?>
                    <!-- Post Change Section End -->
                    <!-- Share Post Start -->
                <!-- Post Sharing Section End -->
                 <!-- Related Posts Starts -->
                <?php if ($cs_xmlObject->post_related == "on") { ?>
                	<div class="detailcarousel portfoliopage related-posts">
                    	<?php cs_enqueue_jcycle_script(); ?>
                        	<header class="heading">
                       			<h2 class="heading-color section-title"><?php echo $cs_xmlObject->inside_post_related_post_title; ?></h2>
                			</header>
                        	<div class="cycle-slideshow"
                            data-cycle-timeout=0
                            data-cycle-fx=carousel
                             data-cycle-carousel-visible=5
                             data-cycle-slides="article"
                                data-cycle-next="#next"
                                data-cycle-prev="#prev">
								<?php
                                $custom_taxterms='';
                                $custom_taxterms = wp_get_object_terms( $post->ID, array('category','post_tag'), array('fields' => 'ids') );
                                // arguments
                                $args = array(
                                'post_type' => 'post',
                                'post_status' => 'publish',
                                'posts_per_page' => -1, // you may edit this number
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
                                if($custom_query->have_posts()):
								 cs_enqueue_jcycle_script(); 
                                 
                                while ($custom_query->have_posts()) : $custom_query->the_post();
                                $post_xml = get_post_meta($post->ID, "post", true);	
                                if ( $post_xml <> "" ) {
									$cs_xmlObject = new SimpleXMLElement($post_xml);
									$post_view = $cs_xmlObject->post_thumb_view;
									$post_image = $cs_xmlObject->post_thumb_image;
									$post_video = $cs_xmlObject->post_thumb_video;
									$post_audio = $cs_xmlObject->post_thumb_audio;
									$post_slider = $cs_xmlObject->post_thumb_slider;
 									$width 	= 370;
									$height = 278;
                                 	$image_url = cs_get_post_img_src($post->ID, $width, $height);
                                }else{
                                $post_view = '';
                                }
                                ?>
                                <!-- List Post Start -->
                                <article <?php post_class(); ?> >
                                <!-- Blog Post Thumbnail Start -->
                                <figure>
                                <?php
                                $custom_height = 195;
                                if ($post_view == "Map" and $post_view <> ''){
									$cs_node->map_lat = $cs_xmlObject->post_thumb_map_lat;
									$cs_node->map_lon = $cs_xmlObject->post_thumb_map_lon;
									$cs_node->map_zoom = $cs_xmlObject->post_thumb_map_zoom;
									$cs_node->map_address = $cs_xmlObject->post_thumb_map_address;
									$cs_node->map_controls = $cs_xmlObject->post_thumb_map_controls;
									$cs_node->map_height = $custom_height;
									echo cs_map_page();
                                }elseif( $post_view == "Slider" and $post_slider <> "" and $post_view <> ''){
                                   cs_flex_slider($width,$height,$post_slider);
                                }elseif($post_view == "Single Image" and $post_view <> ''){
                                  cs_enqueue_gallery_style_script();
                                  echo "<a href='".get_permalink()."' ><img src='".$image_url."' alt=''></a>";
                                }elseif($post_view == "Video" and $post_view <> ''){
                                  $url = parse_url($post_video);
                                  if($url['host'] == $_SERVER["SERVER_NAME"]){?>
                                      <video width="100%" class="mejs-wmp" height="<?php echo $custom_height; ?>" src="<?php echo $post_video ?>" id="player1" poster="<?php echo $image_url; ?>" controls="controls" preload="none"></video>
                                <?php
                                  }else{
                                      echo wp_oembed_get($post_video,array('height'=>200));
                                  }
                                }elseif($post_view == "Audio" and $post_audio <> ''){
                                  ?>
                                  <audio style="width:100%;" src="<?php echo $post_audio; ?>" controls="controls"></audio>
                                  <?php
                                }
                                ?>
                                </figure>
                                <!-- Text Start -->
                                <div class="text">
                                	<span><a href="<?php the_permalink(); ?>"><?php echo substr(get_the_title(),0,30); ?></a></span>
									<?php
                                        $before_cat = '<p><i class="icon-reorder"></i>';
                                        $categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '</p>' );
                                        if ( $categories_list ){ printf( __( '%1$s', 'OneLife' ),$categories_list ); } 
                                    ?>
                                </div>
                                <!-- Text End -->                            
                                </article>
                                <!-- Blog Post End -->
                                <?php
                                endwhile; endif;
                                wp_reset_query();
                                ?>
                             
                            	</div>
                           		<div class=center>
                                	<a href="#" id="prev"><i class="icon-chevron-left"></i></a>
                                	<a href="#" id="next"><i class="icon-chevron-right"></i></a>
                            	</div>
                        </div>
              	<?php }?>
            	<!-- Related Posts End -->
                <!-- About Author Start -->
                <?php 
                if (get_the_author_meta('description')){ ?>
                    <div class="about-author">
                        <!-- Thumbnail List Start -->
                         <figure>
                            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('PixFill_author_bio_avatar_size', 61)); ?></a>
                        </figure>
                        <div class="text">
                            <h6><a class="colrhover" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"> <?php echo get_the_author(); ?></a></h6>
                            <p><?php the_author_meta('description'); ?></p>
                            <a class="twitter_btn" href="http://twitter.com/<?php the_author_meta('twitter'); ?>" target="_blank"><i class="icon-twitter"></i><?php if ($cs_theme_option['trans_switcher'] == "on") {_e('Follow us on Twitter', "OneLife");} else {echo $cs_theme_option['trans_follow_twitter'];}?></a>
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
    <?php if ( $cs_layout  == 'content-left span9' || $cs_layout  == 'span6' ){ ?>
        <aside class="sidebar-right span3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_right) ) : ?><?php endif; ?></aside>
    <?php } ?>

<!-- Columns End -->
<!--Footer-->
<?php get_footer(); ?>
