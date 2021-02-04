 <?php
	cs_enqueue_swiper();
	cs_enqueue_slideshowify();
  	global $cs_node,$post,$cs_theme_option, $cs_blog_large_layout;
?>
    <script>
	jQuery(document).ready(function($) {
		LazyLoad("#container-gallery",".box")
	});
</script>
    <?php
	$no_image ='';
	$videos_listing = array();
	$array_class= array();
	if($cs_theme_option['trans_switcher']== "on"){ $facebook_text = __('Facebook','Snapture');}else{ $facebook_text = $cs_theme_option['trans_facebook']; }
	if($cs_theme_option['trans_switcher']== "on"){ $twitter_text = __('Twitter','Snapture');}else{ $twitter_text = $cs_theme_option['trans_twitter']; }

    if ( !isset($cs_node->cs_blog_num_post) || empty($cs_node->cs_blog_num_post) || $cs_node->cs_blog_num_post<0 ) { $cs_node->cs_blog_num_post = -1; }
 	if (empty($_GET['page_id_all'])) $_GET['page_id_all'] = 1;
	if($cs_node->cs_blog_cat == "all"){
		$args = array('posts_per_page' => "-1", 'paged' => $_GET['page_id_all'], 'post_status' => 'publish');
	}else{
		$args = array('posts_per_page' => "-1", 'paged' => $_GET['page_id_all'], 'category_name' => "$cs_node->cs_blog_cat", 'post_status' => 'publish');
	}
	$custom_query = new WP_Query($args);
	$post_count = $custom_query->post_count;

			if($cs_node->cs_blog_cat == "all"){
				$args_blog = array('posts_per_page' => "$cs_node->cs_blog_num_post", 'paged' => $_GET['page_id_all']);
			}else{
				$args_blog = array('posts_per_page' => "$cs_node->cs_blog_num_post", 'paged' => $_GET['page_id_all'], 'category_name' => "$cs_node->cs_blog_cat");
			}
			$custom_query = new WP_Query($args_blog);
			$counter = 0;
			if($custom_query->have_posts()):
			if($cs_node->cs_blog_view == 'large_view'){
				cs_enqueue_masonry_style_script();
			?>
            <div class="page-listing">
			<!-- PostList Start -->
           	 <div class="postlist blog">
            	
            	<?php  while ($custom_query->have_posts()) : $custom_query->the_post();
                	$post_xml = get_post_meta($post->ID, "post", true);	
                    if ( $post_xml <> "" ) {
						$cs_xmlObject = new SimpleXMLElement($post_xml);
						$post_view = $cs_xmlObject->post_thumb_view;
						$post_image = $cs_xmlObject->post_thumb_image;
						$post_video = $cs_xmlObject->post_thumb_video;
						$post_audio = $cs_xmlObject->post_thumb_audio;
						$post_slider = $cs_xmlObject->post_thumb_slider;
						$post_slider_type = $cs_xmlObject->post_thumb_slider_type;
						$post_thumb_gallery = $cs_xmlObject->post_thumb_gallery;
						$post_featured_image_as_thumbnail = $cs_xmlObject->post_featured_image_as_thumbnail;
						$post_thumb_twitter_status = $cs_xmlObject->post_thumb_twitter_status;
						$post_thumb_facebook_status = $cs_xmlObject->post_thumb_facebook_status;
						$post_thumb_custom_status = $cs_xmlObject->post_thumb_custom_status;
						$custom_width = '';
						$width 	= 890;
						$height	=468;
						$article_class = $post_icon = '';
						if($post_view == "Facebook"){
							$article_class = 'facebook-style';
							$post_icon = 'fa-facebook fa-1x';
						} else if($post_view == "Twitter"){
							$article_class = 'facebook-style twitter';
							$post_icon = 'fa fa-twitter fa-1x';
						} else if($post_view == "Custom Status"){
							$article_class = 'no-image';
							$post_icon = 'fa-arrow-right fa-1x';
						} else if($post_view == "Video"){
							$article_class = 'no-image';
							$post_icon = 'fa-play fa-1x';
						} else {
							$article_class = '';
							$post_icon = 'fa-arrow-right fa-1x';
						}
						$image_url = cs_attachment_image_src(get_post_thumbnail_id($post->ID),$width,$height);
                    }else{
                    	$post_view = '';
						$cs_post_description = '';
                        $no_image = '';	
						$image_url = '';
						$article_class = '';
                    }	
					if($image_url == ''){
						$array_class[] = 'no-image';
					}
					if($article_class <> ''){
						$array_class[] = $article_class;
					}
					if($cs_blog_large_layout == 'cs_wide_layout'){
						$custom_width 	= 680;
						$custom_height	=468;
					} else {
						$custom_width 	= 890;
						$custom_height	=468;
						$video_height = 384;	
					}
                    ?>
                <article <?php post_class($array_class);?>>
							<?php
                                if( $post_view == "Slider" and $post_slider <> "" ){
									echo "<figure class='custom_slider'>";
                                     	cs_swiper_slider($width, $height,$post_slider,$post->ID);
									echo "</figure>"; 
								}elseif($post_view == "Facebook" and $post_thumb_facebook_status <> "" ){
 										echo "<figure class='facebook_status ".$no_image."'><a href='".get_permalink()."'><img src=".$image_url." alt='' ></a>";
										?>
										<figcaption>
                                        <div class="inn">
											<?php echo '<ul class="post-options"><li>'.$facebook_text.'</li></ul>';?>
                                             
                                            	<p><?php echo do_shortcode(html_entity_decode($post_thumb_facebook_status));?></p>
                                            <div class="text">
                                                <a href="<?php the_permalink();?>" class="arrow-right"><i class="fa <?php echo $post_icon;?>"></i></a>
                                                <time datetime="<?php the_time('Y-m-d') ?>">
                                                <i class="fa fa-clock-o"></i><?php echo get_the_date();?></time>
                                            </div>
                                          </div>
                                      </figcaption>
									<?php	
									echo "</figure>";
								}elseif($post_view == "Twitter" and $post_thumb_twitter_status <> "" ){
 										echo "<figure class='twitter_status ".$no_image."'><a href='".get_permalink()."'><img src=".$image_url." alt='' ></a>";
										?>
										<figcaption>
                                        <div class="inn">
											<?php echo '<ul class="post-options"><li>'.$twitter_text.'</li></ul>';?>
                                              <p><?php echo do_shortcode(html_entity_decode($post_thumb_twitter_status));?></p>
                                            <div class="text">
                                                <a href="<?php the_permalink();?>" class="arrow-right"><i class="fa <?php echo $post_icon;?>"></i></a>
                                                <time datetime="<?php the_time('Y-m-d') ?>">
                                                	<i class="fa fa-clock-o"></i><?php echo get_the_date();?>
                                                </time>
                                            </div>
                                        </div>
                                      </figcaption>
									<?php	
									echo "</figure>";
								}elseif($post_view == "Custom Status" and $post_thumb_custom_status <> "" ){
 										echo "<figure class='custom_status ".$no_image."'><a href='".get_permalink()."'><img src=".$image_url." alt='' ></a>";
										?>
										<figcaption>
                                        <div class="inn">
											<?php echo '<ul class="post-options"><li>'.__('Quote', 'Snapture').'</li></ul>';?>
                                            	<p><?php echo do_shortcode(html_entity_decode($post_thumb_custom_status));?></p>
                                            <div class="text">
                                                <a href="<?php the_permalink();?>" class="arrow-right"><i class="fa <?php echo $post_icon;?>"></i></a>
                                                <time datetime="<?php echo get_the_date();?>"><i class="fa fa-clock-o"></i><?php echo get_the_date();?></time>
                                            </div>
                                        </div>
                                      </figcaption>
									<?php	
									echo "</figure>";
								}elseif($post_view == "Gallery" and $post_thumb_gallery <> "" ){
									echo "<figure class='cs-slideshowify'>";
										cs_slideshowify_slider($width, $height,$post_thumb_gallery);
									echo "</figure>";
                                }elseif($post_view == "Single Image"){
                                    if($image_url <> ''){ echo "<figure><a href='".get_permalink()."'><img src=".$image_url." alt='' ></a></figure>";}
                                }elseif($post_view == "Video"){
                                    $url = parse_url($post_video);
									 echo "<figure class='video-box'>";
                                    if($url['host'] == $_SERVER["SERVER_NAME"]){
										$videos_listing[] = $post_video;
                                    ?>
    										<video class="mejs-wmp" height="<?php echo $video_height;?>" src="<?php echo $post_video ?>" <?php if($post_featured_image_as_thumbnail <> ""){ echo 'poster="'.$image_url.'"'; } ?> controls="controls" preload="none"></video>
                                        <figcaption>
                                            <div class="inn">
                                                <div class="text">
                                                    <a data-toggle="modal" data-target="#myModal<?php echo $post->ID;?>" href="#"><i class="fa fa-play fa-1x"></i></a>
                                                </div>
                                            </div>
                                        </figcaption>
                                    <?php
                                    }else{
                                        echo wp_oembed_get($post_video,array('width'=>$custom_width));
                                    }
									echo "</figure>";
                                }elseif($post_view == "Audio" and $post_audio <> ''){
									echo "<figure class='audio-box'>";
                                ?>
                                <audio class="audio" src="<?php echo $post_audio; ?>"></audio>

                                    <img src="<?php echo $image_url;?>" alt="" />
                                        <figcaption>
                                            <div class="inn">
											<?php $before_cat = '<ul class="post-options"><li>';
											  $categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '</li></ul>' );
											  if ( $categories_list ){
												  printf( __( '%1$s', 'Snapture'),$categories_list );
											  }?>
                                              <h4 class="cs-heading-color"><a href="<?php the_permalink();?>"><?php echo substr(get_the_title(), 0, 48); if(strlen(get_the_title())>48) echo '...'; ?></a></h4>
                                            	<p><?php echo do_shortcode(html_entity_decode($post_thumb_custom_status));?></p>
                                            <div class="text">
                                                <a href="<?php the_permalink();?>" class="arrow-right"><i class="fa <?php echo $post_icon;?>"></i></a>
                                                <time datetime="<?php the_time('Y-m-d') ?>"><i class="fa fa-clock-o"></i><?php echo get_the_date();?></time>
                                            </div>
                                        </div>
                                        </figcaption>
                                <?php
								echo "</figure>";
                                }
                            ?>
                    <div class="blog-text webkit">
                        <h2 class="cs-post-title cs-heading-color"><a href="<?php the_permalink();?>" class="colrhvr"><?php the_title();?></a></h2>
                        <ul class="post-options">
                        	<?php cs_featured();?>
                            <li><i class="fa fa-calendar"></i><a><?php echo get_the_date();?></a></li>
                            <?php $before_cat = '<li><i class="fa fa-list"></i>';
						    $categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '</li>' );
						    if ( $categories_list ){
							  printf( __( '%1$s', 'Snapture'),$categories_list );
						    }?>
                            <li><i class="fa fa-user"></i><a class="colrhvr" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author(); ?></a></li>
                            
                            <li><?php  if ( comments_open() ) {echo '<i class="fa fa-comment"></i>'; comments_popup_link( __( '0', 'Snapture' ) , __( '1', 'Snapture' ), __( '%', 'Snapture' ) );  } ?></li>
                            
                            <li><?php edit_post_link( __( '<i class="fa fa-edit"></i> Edit', 'Snapture'), '', '' ); ?></li>
                            
                            
                        </ul>
					   <?php if($cs_node->cs_blog_description == "yes"){?>
                            <div class="text">
                                <p><?php echo cs_get_the_excerpt($cs_node->cs_blog_excerpt,false) ?></p>
                             </div>
                        <?php } ?>
                        
                    </div>
                </article>
                <?php endwhile;?>
                <!-- Pagination Start -->
                  <?php
				$qrystr = '';
				if ( $cs_node->cs_blog_pagination == "Show Pagination" and $post_count > $cs_node->cs_blog_num_post and $cs_node->cs_blog_num_post > 0 ) {
					if ( isset($_GET['page_id']) )  $qrystr = "&page_id=".$_GET['page_id'];
						echo cs_pagination($post_count, $cs_node->cs_blog_num_post,$qrystr);
				}?>
                <!-- Pagination End -->
           
              
            </div>
             </div>
            <!-- PostList End -->
           <?php
			
			} else if($cs_node->cs_blog_view == 'masonry_view'){cs_enqueue_masonry_blog_style_script();
			
			?>
			 <!-- PostList Start -->
             <script>
			 	jQuery(document).ready(function($) {
					gallery_mas();
					jQuery(window).load(function() {
						gallery_mas();
					});

				});
			 </script>
            <div class="postlist postlist-mas-listing" id="gallery">
            <?php  while ($custom_query->have_posts()) : $custom_query->the_post();
                	$post_xml = get_post_meta($post->ID, "post", true);	
                    if ( $post_xml <> "" ) {
						$cs_xmlObject = new SimpleXMLElement($post_xml);
						
						$post_view = $cs_xmlObject->post_thumb_view;
						$post_image = $cs_xmlObject->post_thumb_image;
						$post_video = $cs_xmlObject->post_thumb_video;
						$post_audio = $cs_xmlObject->post_thumb_audio;
						$post_slider = $cs_xmlObject->post_thumb_slider;
						$post_slider_type = $cs_xmlObject->post_thumb_slider_type;
						$post_thumb_gallery = $cs_xmlObject->post_thumb_gallery;
						$post_featured_image_as_thumbnail = $cs_xmlObject->post_featured_image_as_thumbnail;
						$post_thumb_twitter_status = $cs_xmlObject->post_thumb_twitter_status;
						$post_thumb_facebook_status = $cs_xmlObject->post_thumb_facebook_status;
						$post_thumb_custom_status = $cs_xmlObject->post_thumb_custom_status;
						if($post_view == "Facebook"){
							$article_class = 'facebook-style';
							$post_icon = 'fa-facebook fa-1x';
						} else if($post_view == "Twitter"){
							$article_class = 'facebook-style twitter';
							$post_icon = 'fa fa-twitter fa-1x';
						} else if($post_view == "Custom Status"){
							$article_class = 'no-image';
							$post_icon = 'fa-arrow-right fa-1x';
						} else if($post_view == "Video"){
							$article_class = 'no-image';
							$post_icon = 'fa-play fa-1x';
						} else {
							$article_class = '';
							$post_icon = 'fa-arrow-right fa-1x';
						}
						$width 	= $custom_width = 890;
						$height	=450;
						$no_image = '';
						$width = 529;
						$height	=400;
						$image_url = cs_attachment_image_src(get_post_thumbnail_id($post->ID),$width, $height);
                    }else{
                    	$post_view = '';
						$cs_post_description = '';
                        $no_image = '';	
						$image_url = '';
						$article_class = '';
                    }	
					if($image_url == ''){
						$no_image = 'no-image';
					}
					if($cs_blog_large_layout == 'cs_wide_layout'){
						$custom_width 	= 485;
						$custom_height	=340;
					} else {
						$custom_width 	= 305;
						$custom_height	=340;	
					}
					$cs_like_counter = get_post_meta($post->ID, "cs_like_counter", true);
					if ( !isset($cs_like_counter) or empty($cs_like_counter) ) $cs_like_counter = 0;
                    ?>
                	<div class="box">
                        <article class="<?php echo $article_class;?>">
                        <?php
                                if( $post_view == "Slider" and $post_slider <> "" ){
                                     cs_swiper_slider($width, $height,$post_slider,$post->ID,$cs_node->cs_blog_view);
								}elseif($post_view == "Facebook" and $post_thumb_facebook_status <> "" ){
 										echo "<figure class='facebook_status ".$no_image."'><a href='".get_permalink()."'><img src=".$image_url." alt='' ></a>";
										?>
										<figcaption>
                                        <div class="inn">
											<?php echo '<ul class="post-options"><li>'.$facebook_text.'</li></ul>';?>
                                            	<p><?php echo do_shortcode(html_entity_decode($post_thumb_facebook_status));?></p>
                                            <div class="text">
                                                <a href="<?php the_permalink();?>" class="arrow-right"><i class="fa <?php echo $post_icon;?>"></i></a>
                                                <time datetime="<?php the_time('Y-m-d') ?>"><i class="fa fa-clock-o"></i><?php echo get_the_date();?></time>
                                            </div>
                                        </div>
                                      </figcaption>
									<?php	
									echo "</figure>";
								}elseif($post_view == "Twitter" and $post_thumb_twitter_status <> "" ){
 										echo "<figure class='twitter_status ".$no_image."'><a href='".get_permalink()."'><img src=".$image_url." alt='' ></a>";
										?>
										<figcaption>
                                        <div class="inn">
											<?php echo '<ul class="post-options"><li>'.$twitter_text.'</li></ul>';?>
                                            	<p><?php echo do_shortcode(html_entity_decode($post_thumb_twitter_status));?></p>
                                            <div class="text">
                                                <a href="<?php the_permalink();?>" class="arrow-right"><i class="fa <?php echo $post_icon;?>"></i></a>
                                                <time datetime="<?php the_time('Y-m-d') ?>"><i class="fa fa-clock-o"></i><?php echo get_the_date();?></time>
                                            </div>
                                        </div>
                                      </figcaption>
									<?php	
									echo "</figure>";
								}elseif($post_view == "Custom Status" and $post_thumb_custom_status <> "" ){
									echo "<figure class='custom_status'>";
										echo "<figure class='".$no_image."'><a href='".get_permalink()."'><img src=".$image_url." alt='' ></a>";
										?>
										<figcaption>
                                        <div class="inn">
											<?php echo '<ul class="post-options"><li>'.__('Quote', 'Snapture').'</li></ul>';?>
                                            	<p><?php echo do_shortcode(html_entity_decode($post_thumb_custom_status));?></p>
                                            <div class="text">
                                                <a href="<?php the_permalink();?>" class="arrow-right"><i class="fa <?php echo $post_icon;?>"></i></a>
                                                <time datetime="<?php the_time('Y-m-d') ?>"><i class="fa fa-clock-o"></i><?php echo get_the_date();?></time>
                                            </div>
                                        </div>
                                      </figcaption>
									<?php	
									echo "</figure>";
								}elseif($post_view == "Gallery" and $post_thumb_gallery <> "" ){
									echo "<figure class='cs-slideshowify'>";
										cs_slideshowify_slider($width, $height,$post_thumb_gallery);
									echo "</figure>";
									
                                }elseif($post_view == "Single Image"){
                                     echo "<figure class='".$no_image."'><a href='".get_permalink()."'>";
									if($image_url <> ''){
										echo "<img src=".$image_url." alt='' ></a><figcaption><a href='".get_permalink()."'>";
									}
									echo "</a></figcaption></figure>";
                                }elseif($post_view == "Video"){
									$poster_url = '';
									if($post_featured_image_as_thumbnail=='on'){$poster_url = $image_url;}
                                    $url = parse_url($post_video);
									 echo "<figure class='video-box'>";
                                    if($url['host'] == $_SERVER["SERVER_NAME"]){
										$videos_listing[$post->ID] = $post_video;
                                    ?>
                                    <img src="<?php echo $image_url;?>" alt="">
                                        <figcaption>
                                            <div class="inn">
                                                <div class="text">
                                                    <a data-toggle="modal" data-target="#myModal<?php echo $post->ID;?>"  onclick="cs_video_load('<?php echo get_template_directory_uri();?>', <?php echo $post->ID;?>, '<?php echo $post_video;?>','<?php echo $poster_url;?>');" href="#"><i class="fa fa-play fa-1x"></i></a>
                                                </div>
                                            </div>
                                        </figcaption>
                                    <?php
                                    }else{
                                        echo wp_oembed_get($post_video,array('width'=>$custom_width, 'height'=>350));
                                    }
									echo "</figure>";
								
                                }elseif($post_view == "Audio" and $post_audio <> ''){
									echo "<figure class='audio-box'>";
                                ?>
                                    <a href="<?php the_permalink();?>"><img src="<?php echo $image_url;?>" alt=""></a>
                                        <figcaption>
                                            <audio class="audio" src="<?php echo $post_audio; ?>"></audio>
                                        </figcaption>
                                <?php
								echo "</figure>";
                                }
                            ?>
                        <div class="blog-text webkit">
                            <h2 class="cs-post-title cs-heading-color"><a href="<?php the_permalink();?>" class="colrhvr"><?php echo substr(get_the_title(), 0, 48); if(strlen(get_the_title())>48) echo '...'; ?>.</a></h2>
                            <ul class="post-options">
                                <li><i class="fa fa-clock-o"></i><?php echo get_the_date();?></li>
                                <?php
									  /* translators: used between list items, there is a space after the comma */
									  $before_cat = '<li><i class="fa fa-folder-open-o"></i>';
									  $categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '</li>' );
									  if ( $categories_list ){
										  printf( __( '%1$s', 'Snapture'),$categories_list );
									  }
								?>
                                <?php cs_featured();?>
                            </ul>
                            <?php if($cs_node->cs_blog_description == "yes"){?>
                            <div class="text">
                                <p><?php echo cs_get_the_excerpt($cs_node->cs_blog_excerpt,false) ?></p>
                             </div>
                        <?php } ?>
                        </div>
                    </article>
                </div>
                <?php endwhile;?>
               
     
               
            </div>
        <!-- PostList End -->
			<?php
			$qrystr = '';
				if ( $cs_node->cs_blog_pagination == "Show Pagination" and $post_count > $cs_node->cs_blog_num_post and $cs_node->cs_blog_num_post > 0 ) {
					//<!-- Pagination Start -->
					if ( isset($_GET['page_id']) )  $qrystr = "&page_id=".$_GET['page_id'];
						echo cs_pagination($post_count, $cs_node->cs_blog_num_post,$qrystr);
				}
				// <!-- Pagination End -->
			 if(count($videos_listing)>0){
					  	foreach($videos_listing as $video_key=>$video){
							?>
						 <!-- Modal -->
						<div class="modal fade" id="myModal<?php echo $video_key;?>" tabindex="-1" role="dialog" aria-hidden="true">
						  <!-- /.modal-dialog -->
						</div><!-- /.modal -->
						<?php }
				  }
			
            } else if($cs_node->cs_blog_view == 'gird_view'){cs_enqueue_masonry_style_script();?>
            	<script type="text/javascript">
					jQuery(document).ready(function($) {
						perfect_masonary_gallery();
					});
                </script>
            
				<!-- Mas Content Section Start -->
                <div class="mas-cont-sec">
                    <!-- Container Start -->
                    <div id="container-gallery" class="page-listing">
                    <?php  while ($custom_query->have_posts()) : $custom_query->the_post();
                	$post_xml = get_post_meta($post->ID, "post", true);	
                    if ( $post_xml <> "" ) {
						$cs_xmlObject = new SimpleXMLElement($post_xml);
						$post_view = $cs_xmlObject->post_thumb_view;
						$post_image = $cs_xmlObject->post_thumb_image;
						$post_video = $cs_xmlObject->post_thumb_video;
						$post_audio = $cs_xmlObject->post_thumb_audio;
						$post_slider = $cs_xmlObject->post_thumb_slider;
						$post_slider_type = $cs_xmlObject->post_thumb_slider_type;
						$cs_blog_img_type = $cs_xmlObject->cs_blog_img_type;
						$post_thumb_gallery = $cs_xmlObject->post_thumb_gallery;
						$post_featured_image_as_thumbnail = $cs_xmlObject->post_featured_image_as_thumbnail;
						$post_thumb_twitter_status = $cs_xmlObject->post_thumb_twitter_status;
						$post_thumb_facebook_status = $cs_xmlObject->post_thumb_facebook_status;
						$post_thumb_custom_status = $cs_xmlObject->post_thumb_custom_status;
						$article_class = $post_icon = '';
						if($post_view == "Facebook"){
							$article_class = 'facebook-style';
							$post_icon = 'fa-facebook fa-1x';
						} else if($post_view == "Twitter"){
							$article_class = 'facebook-style twitter';
							$post_icon = 'fa fa-twitter fa-1x';
						} else if($post_view == "Custom Status"){
							$article_class = 'no-image';
							$post_icon = 'fa-arrow-right fa-1x';
						} else if($post_view == "Video"){
							
							$url = parse_url($post_video);
                            if($url['host'] == $_SERVER["SERVER_NAME"]){
								$article_class = '';
							} else {
								$article_class = 'no-image';
							}
							$post_icon = 'fa-play fa-1x';
						} else {
							$article_class = '';
							$post_icon = 'fa-arrow-right fa-1x';
						}
						$width 	= $custom_width = 800;
						$height	=450;
						$no_image = '';
						if($cs_blog_img_type=='cs-big-square'){
							$width = 800;
							$height	=450;
							$custom_width 	= 800;
							$custom_height	=340;
						} else if($cs_blog_img_type=='cs-horizental'){
							$width = 500;
							$height	=186;
							$custom_width 	= 500;
							$custom_height	=340;
						} else if($cs_blog_img_type=='cs-vertical'){
							$width = 250;
							$height	=380;
							$custom_width 	= 250;
							$custom_height	=340;
							
						}  else {
							$width = 529;
							$height	=400;	
							$custom_width 	= 529;
							$custom_height	=340;
						}
						$image_url = cs_attachment_image_src(get_post_thumbnail_id($post->ID), $width, $height);
                    }else{
                    	$post_view = '';
						$cs_post_description = '';
                        $no_image = '';	
						$image_url = '';
						$article_class = '';
						$post_icon = 'fa-arrow-right fa-1x';
                    }	
					if($image_url == ''){
						$no_image = 'no-image';
					}

                    ?>
                        <div class="box <?php echo $cs_blog_img_type;?>">
                            <article class="<?php echo $article_class;?>">
                            	<?php
                                if( $post_view == "Slider" and $post_slider <> "" ){
                                     cs_swiper_slider($width, $height,$post_slider,$post->ID,'');
								}elseif($post_view == "Facebook" and $post_thumb_facebook_status <> "" ){
 										echo "<figure class='facebook_status ".$no_image."'><a href='".get_permalink()."'><img src=".$image_url." alt='' ></a>";
										?>
										<figcaption>
                                        <div class="inn">
											<?php echo '<ul class="post-options"><li>'.$facebook_text.'</li></ul>';?>
                                            <p><?php echo do_shortcode(html_entity_decode($post_thumb_facebook_status));?></p>
                                            <div class="text">
                                                <a href="<?php the_permalink();?>" class="arrow-right"><i class="fa <?php echo $post_icon;?>"></i></a>
                                                <time datetime="<?php the_time('Y-m-d') ?>"><i class="fa fa-clock-o"></i><?php echo get_the_date();?></time>
                                            </div>
                                        </div>
                                      </figcaption>
									<?php	
									echo "</figure>";
								}elseif($post_view == "Twitter" and $post_thumb_twitter_status <> "" ){
 										echo "<figure class='twitter_status ".$no_image."'><a href='".get_permalink()."'><img src=".$image_url." alt='' ></a>";
										?>
										<figcaption>
                                        <div class="inn">
											<?php echo '<ul class="post-options"><li>'.$twitter_text.'</li></ul>';?>
                                            	<p><?php echo do_shortcode(html_entity_decode($post_thumb_twitter_status));?></p>
                                            <div class="text">
                                                <a href="<?php the_permalink();?>" class="arrow-right"><i class="fa <?php echo $post_icon;?>"></i></a>
                                                <time datetime="<?php the_time('Y-m-d') ?>"><i class="fa fa-clock-o"></i><?php echo get_the_date();?></time>
                                            </div>
                                        </div>
                                      </figcaption>
									<?php	
									echo "</figure>";
								}elseif($post_view == "Custom Status" and $post_thumb_custom_status <> "" ){
									echo "<figure class='custom_status'>";
										echo "<figure class='".$no_image."'><a href='".get_permalink()."'><img src=".$image_url." alt='' ></a>";
										?>
										<figcaption>
                                        <div class="inn">
											<?php echo '<ul class="post-options"><li>'.__('Quote', 'Snapture').'</li></ul>';?>
                                            	<p><?php echo do_shortcode(html_entity_decode($post_thumb_custom_status));?></p>
                                            <div class="text">
                                                <a href="<?php the_permalink();?>" class="arrow-right"><i class="fa <?php echo $post_icon;?>"></i></a>
                                                <time datetime="<?php the_time('Y-m-d') ?>"><i class="fa fa-clock-o"></i><?php echo get_the_date();?></time>
                                            </div>
                                        </div>
                                      </figcaption>
									<?php	
									echo "</figure>";
								}elseif($post_view == "Gallery" and $post_thumb_gallery <> "" ){
									cs_slideshowify_slider($width, $height,$post_thumb_gallery);
                                }elseif($post_view == "Single Image"){
                                     echo "<figure class='".$no_image."'><a href='".get_permalink()."'><img src=".$image_url." alt='' ></a>";?>
                                     <?php if($cs_node->cs_blog_show_title == 'yes'){?><h4 class="cs-heading-color cs-main-heading"><?php echo substr(get_the_title(), 0, 48); if(strlen(get_the_title())>48) echo '...'; ?></h4><?php }?>
									<figcaption>
                                        <div class="inn">
											<?php $before_cat = '<ul class="post-options"><li>';
											  $categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '</li></ul>' );
											  if ( $categories_list ){
												  printf( __( '%1$s', 'Snapture'),$categories_list );
											  }?>
                                              <?php if($cs_node->cs_blog_show_title == 'yes'){?><h4 class="cs-heading-color"><a href="<?php the_permalink();?>"><?php echo substr(get_the_title(), 0, 20); if(strlen(get_the_title())>20) echo '...'; ?></a></h4><?php }?>
                                              <?php if($cs_node->cs_blog_description == "yes"){?>
                                                	<div class="blog-grid-text">
                                                    	<p><?php echo cs_get_the_excerpt($cs_node->cs_blog_excerpt,false) ?></p>
                                                	</div>
                                            	<?php } ?>
                                            <div class="text">
                                                <time datetime="<?php the_time('Y-m-d') ?>"><i class="fa fa-clock-o"></i><?php echo get_the_date();?></time>
                                                <a href="<?php the_permalink();?>" class="arrow-right"><i class="fa <?php echo $post_icon;?>"></i></a>
                                            </div>
                                        </div>
                                      </figcaption>
                                     </figure>
                                 <?php 
                                }elseif($post_view == "Video"){
									$poster_url = '';
									
                                    $url = parse_url($post_video);
									 echo "<figure class='video-box'>";
                                    if($url['host'] == $_SERVER["SERVER_NAME"]){
										
										$videos_listing[$post->ID] = $post_video;
										if($post_featured_image_as_thumbnail=='on'){$poster_url = $image_url;}
                                    ?>
                                    <img src="<?php echo $image_url;?>" alt="">
                                   <?php if($cs_node->cs_blog_show_title == 'yes'){?><h4 class="cs-heading-color cs-main-heading"><?php echo substr(get_the_title(), 0, 20); if(strlen(get_the_title())>20) echo '...'; ?></h4><?php }?>
                                        <figcaption>
                                            <div class="inn">
                                                <div class="text">
                                                    <a data-toggle="modal" data-target="#myModal<?php echo $post->ID;?>" onclick="cs_video_load('<?php echo get_template_directory_uri();?>', <?php echo $post->ID;?>, '<?php echo $post_video;?>','<?php echo $poster_url;?>');" href="#"><i class="fa fa-play fa-1x"></i></a>
                                                </div>
                                            </div>
                                        </figcaption>
                                    <?php
                                    }else{
                                        echo wp_oembed_get($post_video,array('width'=>$width));
                                    }
									echo "</figure>";
									
									
                                }elseif($post_view == "Audio" and $post_audio <> ''){
									echo "<figure class='audio-box'>";
                                ?>
                                <?php if($cs_node->cs_blog_show_title == 'yes'){?><h4 class="cs-heading-color cs-main-heading"><?php echo substr(get_the_title(), 0, 20); if(strlen(get_the_title())>20) echo '...'; ?></h4><?php }?>
                                <audio class="audio" src="<?php echo $post_audio; ?>"></audio>
                                            <img src="<?php echo $image_url;?>" alt="">
                                <?php
								echo "</figure>";
                                }
                            ?>
                                
                            </article>
                        </div>
                        <?php
						 endwhile;
						?>
                    </div>
                   <!-- Pagination Start -->
                  <?php
				  if(count($videos_listing)>0){
					  	foreach($videos_listing as $video_key=>$video){
								?>
							 <!-- Modal -->
							<div class="modal fade" id="myModal<?php echo $video_key;?>" tabindex="-1" role="dialog" aria-hidden="true">
							
							  </div><!-- /.modal-dialog -->
							</div><!-- /.modal -->
							<?php }
				  }
				$qrystr = '';
				if ( $cs_node->cs_blog_pagination == "Show Pagination" and $post_count > $cs_node->cs_blog_num_post and $cs_node->cs_blog_num_post > 0 ) {
					if ( isset($_GET['page_id']) )  $qrystr = "&page_id=".$_GET['page_id'];
						echo cs_pagination($post_count, $cs_node->cs_blog_num_post,$qrystr);
				}?>
                <!-- Pagination End -->
                </div>
                <!-- Mas Content Section End -->
			<?php }
		endif; ?>

