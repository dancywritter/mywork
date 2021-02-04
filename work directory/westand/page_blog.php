 <?php
 	global $cs_node,$post,$cs_theme_option,$cs_counter_node,$cs_meta_page,$cs_video_width; 
 	if ( !isset($cs_node->cs_blog_num_post) || empty($cs_node->cs_blog_num_post) ) { $cs_node->cs_blog_num_post = -1; }
	if ( !isset($cs_node->cs_blog_orderby) || empty($cs_node->cs_blog_orderby) ) { $cs_node->cs_blog_orderby = 'DESC'; }
	$image_url = '';
	cs_addthis_script_init_method();
	?>
    <div class="element_size_<?php echo $cs_node->blog_element_size; ?>">
    <?php	
		$blog_view = $cs_node->cs_blog_view;
		 	if ($cs_node->cs_blog_title <> '' && $cs_node->cs_blog_view == "blog-carousel-view") { 
			$blog_view = '  blog-grid blog-carousel-view';
				echo'<header class="cs-heading-title">
						<h2 class="cs-section-title">'.$cs_node->cs_blog_title.'</h2>';
						echo'<div class="cs-carousel-control">
							<span class="arrow-left"><i class="fa fa-angle-left"></i></span> 
							<span class="arrow-right"><i class="fa fa-angle-right"></i></span>
							</div>';
                echo'</header>';
         	} 
			
			else if ($cs_node->cs_blog_title <> '') { 
				echo'<header class="cs-heading-title">
						<h2 class="cs-section-title">'.$cs_node->cs_blog_title.'</h2>';
                echo'</header>';
         	}
		 ?>
	<div class="cs-blog <?php  echo $blog_view; ?>">
     	<!-- Blog Start -->
		<?php
            if (empty($_GET['page_id_all'])) $_GET['page_id_all'] = 1;
            $args = array('posts_per_page' => "-1", 'paged' => $_GET['page_id_all'], 'post_status' => 'publish');
			if(isset($cs_node->cs_blog_cat) && $cs_node->cs_blog_cat <> '' &&  $cs_node->cs_blog_cat <> '0'){
				$blog_category_array = array('category_name' => "$cs_node->cs_blog_cat");
				$args = array_merge($args, $blog_category_array);
			}
			
            $custom_query = new WP_Query($args);
            $post_count = $custom_query->post_count;
            $count_post = 0;
            // if ($cs_node->cs_blog_pagination == "Single Page") $cs_node->cs_blog_num_post = $cs_node->cs_blog_num_post;
            $args = array('posts_per_page' => "$cs_node->cs_blog_num_post", 'paged' => $_GET['page_id_all'], 'order' => "$cs_node->cs_blog_orderby");
			if(isset($cs_node->cs_blog_cat) && $cs_node->cs_blog_cat <> '' &&  $cs_node->cs_blog_cat <> '0'){
				$blog_category_array = array('category_name' => "$cs_node->cs_blog_cat");
				$args = array_merge($args, $blog_category_array);
				
			}
            $custom_query = new WP_Query($args);
            $cs_counter = 0;
				cs_meta_content_class();
				if( cs_meta_content_class() == "col-md-12"){
					
					
				if($cs_node->cs_blog_view == "blog-large"){$custom_width = 716; $custom_height = 393;}
				}elseif( cs_meta_content_class() == "col-md-9"){
					if($cs_node->cs_blog_view == "blog-large"){ $custom_width = 716; $custom_height = 393; }
				}
				if($cs_node->cs_blog_view == "blog-grid" || $cs_node->cs_blog_view == "blog-medium"){
					$custom_width = 342;
					$custom_height = 193;
					$width 	= 342;
					$height	= 193;
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
						$image_url = cs_get_post_img_src($post->ID, $width, $height);
						$image_url_full = cs_get_post_img_src($post->ID, '' ,'');
						if($image_url == ""){
							$no_image = ' no-image';
						}
					}else{
						$post_view = '';
						$no_image = '';	
						$image_url_full = '';
					}
					?>
						<article <?php post_class($no_image);?>>
                        <?php 
							if($image_url <> ""){
								 $cs_like_counter = '';
									$cs_like_counter = get_post_meta(get_the_id(), "cs_like_counter", true);
									if ( !isset($cs_like_counter) or empty($cs_like_counter) ) $cs_like_counter = 0;
  								echo '<figure>
								
								
								<a href="'.get_permalink().'" ><img src="'.$image_url.'" alt="" ></a>
								<figcaption>
									<a class="btn cs-bgcolr"> <i class="fa fa-heart-o"></i>'.$cs_like_counter.'</a>
								</figcaption>
								
								
								</figure>';
							}
                        ?>
                            <div class="text">
                            <h2 class="cs-post-title">
                                <a href="<?php the_permalink();?>" class="cs-colrhvr"><?php the_title();?></a>
                            </h2>
                             <?php if($cs_node->cs_blog_description == "yes"){?>
                                 	<p><?php  cs_get_the_excerpt($cs_node->cs_blog_excerpt,false);?></p>
                            <?php }?>
                            <div class="cs-blog-panel">
                                <ul class="post-options">
                                	<?php cs_featured(); ?>
                                    <li><?php echo date_i18n(get_option( 'date_format' ),strtotime(get_the_date()));?></li>
                                    <li><i class="fa fa-user"></i><?php printf( __('%s','WeStand'), '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" >'.get_the_author().'</a>' );?></li>
                                   
                                    <?php
                                    	
									if ( comments_open() ) {  echo "<li><i class='fa fa-comment'></i>"; comments_popup_link( __( '0 Comment', 'WeStand' ) , __( '1 Comment', 'WeStand' ), __( '% Comments', 'WeStand' ) ); }
                                    ?>
                                     <li>
									<?php
										edit_post_link( __( '<i class="fa fa-pencil-square-o"></i>Edit', 'WeStand'), '', '' ); 
									 ?>
                                     </li>
                                </ul>
                                
                                <a class="btnshare addthis_button_compact"><i class="fa fa-share-square-o"></i></a>
                            </div>
                        </div>
                        </article>
				<?php
				endwhile;

				} else if($cs_node->cs_blog_view == "blog-large"){
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
						$custom_cls = '';
						$width 	=716;
						$height	=393;
							
						$image_url = cs_get_post_img_src($post->ID, $width, $height);
						$image_url_full = cs_get_post_img_src($post->ID, '' ,'');
						if($image_url == "" and $post_view == "Single Image"){
							$no_image = ' no-image';
						}
					}else{
						$post_view = '';
						$no_image = '';	
						$image_url_full = '';
					}	
					?>
                    <!-- Blog Post Start -->
                    <article <?php post_class(fnc_post_type($post_view ,$image_url)); ?>>
                    	 <?php
  								echo '<figure>';
  							 	if ( $post_view == "Slider"  and $post_slider <> ''){
                                 	cs_flex_slider($width, $height,$post_slider);
                                 }elseif($post_view == "Single Image"){
                                	if($image_url <> ''){ 
									echo '<a href="'.get_permalink().'" ><img src="'.$image_url.'" alt="" ></a>';
									 }
                                }elseif($post_view == "Video"){
 									$url = parse_url($post_video);
									if($url['host'] == $_SERVER["SERVER_NAME"]){
 									$poster_url = '';
										if($post_featured_image=='on'){$poster_url = $image_url;}
										 if($image_url <> ''){ echo "<a href='".get_permalink()."'><img src=".$image_url." alt='' ></a>";}
                                    ?>
                                        <figcaption class="gallery">
                                                      <a data-toggle="modal" data-target="#myModal<?php echo $post->ID;?>"  onclick="cs_video_load('<?php echo get_template_directory_uri();?>', <?php echo $post->ID;?>, '<?php echo $post_video;?>','<?php echo $poster_url;?>');" href="#"><i class="fa fa-video-camera fa-2x"></i></a>
                                         </figcaption>
									<?php
									}else{
  									  	echo wp_oembed_get($post_video,array('height' =>$custom_height));
									}
  								}elseif($post_view == "Audio" and $post_audio <> ''){
 									if($image_url <> ''){ echo "<a href='".get_permalink()."'><img src=".$image_url." alt='' ></a>";
								}
 								?>
								<figcaption class="gallery">
                                    <div class="audiowrapp fullwidth">
                                        <audio style="width:100%;" src="<?php echo $post_audio; ?>" type="audio/mp3" controls="controls"></audio>
                                    </div>  
                                </figcaption>
								<?php
 								}
								echo '</figure>';
 							 ?>
                        <!-- Blog Post Thumbnail End -->
                                <div class="calendardate-wrap">
                                    <div class="calendar-date">
                                        <span><?php echo date_i18n('d',strtotime(get_the_date()));?></span>
                                        <?php echo date_i18n('M',strtotime(get_the_date()));?>
                                    </div>
                                    <?php 
									 $cs_like_counter = '';
									$cs_like_counter = get_post_meta(get_the_id(), "cs_like_counter", true);
									if ( !isset($cs_like_counter) or empty($cs_like_counter) ) $cs_like_counter = 0;
										
									?>
									<a class="btn cs-bgcolr"><i class="fa fa-heart-o"></i><?php echo $cs_like_counter;?></a></li>
									
								
                                </div>
                                <div class="text">
                                    <h2 class="cs-post-title">
                                        <a href="<?php the_permalink();?>" class="cs-colrhvr"><?php the_title();?></a>
                                    </h2>
                                     <?php if($cs_node->cs_blog_description == "yes"){?>
                                            <p><?php  cs_get_the_excerpt($cs_node->cs_blog_excerpt,false);?></p>
                                    <?php }?>
                                    <div class="cs-blog-panel">
                                        <ul class="post-options">
                                            <?php cs_featured(); ?>
                                            <li><i class="fa fa-user"></i><?php printf( __('%s','WeStand'), '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" >'.get_the_author().'</a>' );?></li>
                                            <?php
                                                $before_cat = " ".__( '<li><i class="fa fa-list"></i>','WeStand')."";
                                                $categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '</li>' );
                                                if ( $categories_list ){
                                                    printf( __( '%1$s', 'WeStand'),$categories_list );
                                                }
                                            if ( comments_open() ) {  echo "<li><i class='fa fa-comment'></i>"; comments_popup_link( __( '0 Comment', 'WeStand' ) , __( '1 Comment', 'WeStand' ), __( '% Comments', 'WeStand' ) ); }
                                            ?>
                                            <li>
											<?php
                                                edit_post_link( __( '<i class="fa fa-pencil-square-o"></i>Edit', 'WeStand'), '', '' ); 
                                             ?>
                                             </li>
                                            
                                   
                                        </ul>
                                        <a class="btnshare addthis_button_compact"><i class="fa fa-share-square-o"></i><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Sahre','WeStand');}else{ echo $cs_theme_option['trans_share_this_post']; } ?></a>
                                    </div>
                                </div>
                     </article>
                     <?php if($post_view == "Video"){?>
                    <div class="modal fade" id="myModal<?php echo $post->ID;?>" tabindex="-1" role="dialog" aria-hidden="true"></div>
                    <?php }?>
                      <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'WeStand' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
                    <!-- Blog Post End -->
               		<?php endwhile;  ?>
                 	<!-- Blog End -->
                <?php
				} else if($cs_node->cs_blog_view == "blog-carousel-view"){
					cs_enqueue_swiper_script();
					?>
                    <div class="device">
                    	
                    	<div class="swiper-container">
                        	<div class="swiper-wrapper">
                        
                                    
                                    	<?php 
											$width 	= 406;
											$height	= 202;
											$count_carousal = 0;
											$no_image = 'featured-slide ';
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
												
												$image_url = cs_get_post_img_src($post->ID, $width, $height);
												if($image_url == ""){
													$no_image .= ' no-image';
												}
											}else{
												$post_view = '';
												$no_image = '';	
												$image_url = '';
											}
											$count_carousal++;
											?>
                                            <div class="swiper-slide">
                                            <article <?php post_class($no_image);?>>
                                                <figure>
                                                    <?php if($image_url <> ""){?><img src="<?php echo $image_url;?>" alt=""><?php }?>
                                                    <figcaption>
                                                         <a href="<?php the_permalink();?>" class="readmore"><i class="fa fa-plus"></i></a>
                                                         <?php 
														 $cs_like_counter = '';
														$cs_like_counter = get_post_meta(get_the_id(), "cs_like_counter", true);
														if ( !isset($cs_like_counter) or empty($cs_like_counter) ) $cs_like_counter = 0;
															
														?>
														<a class="btn cs-bgcolr"><i class="fa fa-heart-o"></i><?php echo $cs_like_counter;?></a></li>
														
                                                        
                                                    </figcaption>
                                                </figure>
                                                <div class="text">
                                                    <h2 class="cs-post-title">
                                                    	<?php if($count_carousal == '1'){?>
                                                        	<a href="<?php the_permalink();?>" class="cs-colrhvr"><?php the_title(); ?></a>
                                                        <?php } else {?>
                                                        	<a href="<?php the_permalink();?>" class="cs-colrhvr"><?php echo substr(get_the_title(),0,36); if ( strlen(get_the_title()) > 36) echo "..."; ?></a>
                                                         <?php }?>
                                                        
                                                        
                                                    </h2>
                                                    <ul class="post-options">
                                                        <li>
                                                            <i class="fa fa-clock-o"></i>
                                                            <time datetime="<?php echo date_i18n('Y-m-d',strtotime(get_the_date()));?>"><?php echo date_i18n(get_option( 'date_format' ),strtotime(get_the_date()));?></time>
                                                        </li>
                                                        <?php if($count_carousal == '1'){?>
                                                        <li><i class="fa fa-user"></i><?php printf( __('By: %s','WeStand'), '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" >'.get_the_author().'</a>' );?></li>
                                                        <?php }?>
                                                    </ul>
                                                </div>
                                            </article>
                                            </div>
                                    	<?php 
												$no_image = '';
												$width = 250;
												$height	= 250;

											 endwhile;?>
                                </div>
                          </div>  	
                          <script type='text/javascript'>
     						jQuery(document).ready(function(){
								post_swiper_carousal();
							});
                    </script>
                  	</div>                  
                    
                    <?php
				}
				echo '</div>';
                $qrystr = '';
               if ( $cs_node->cs_blog_pagination == "Show Pagination" and $post_count > $cs_node->cs_blog_num_post and $cs_node->cs_blog_num_post > 0 && $cs_node->cs_blog_view <> "blog-carousel-view" ) {
					if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
						echo cs_pagination($post_count, $cs_node->cs_blog_num_post,$qrystr);
                }
                 // pagination end
             ?>
	</div>