 <?php
 	global $cs_node,$post,$cs_theme_option,$cs_counter_node,$cs_meta_page,$cs_video_width; 
 	if ( !isset($cs_node->cs_blog_num_post) || empty($cs_node->cs_blog_num_post) ) { $cs_node->cs_blog_num_post = -1; }
	if ( !isset($cs_node->cs_blog_orderby) || empty($cs_node->cs_blog_orderby) ) { $cs_node->cs_blog_orderby = 'DESC'; }
 	$image_url = '';
	?>
    <div class="element_size_<?php echo $cs_node->blog_element_size; ?>">
  	<?php	
		 	if ($cs_node->cs_blog_title <> '') { 
				echo'<header class="cs-heading-title">
					<h2 class="cs-section-title '.$cs_node->cs_blog_view.'-center">'.$cs_node->cs_blog_title.'</h2>';
					if(isset($cs_node->var_pb_blog_view_all) && $cs_node->var_pb_blog_view_all <> ''){
						 echo '<a class="cs-btnviewall float-right" href="'.$cs_node->var_pb_blog_view_all.'"><i class="fa fa-right-dir"></i>';
									if($cs_theme_option['trans_switcher'] == "on"){ _e('View All','Faith'); }else{ echo $cs_theme_option['trans_view_all']; }
						 echo '</a>';
					}
                echo'</header>';
         	} 
		 ?>
	<div class="postlist blog <?php  echo $cs_node->cs_blog_view; ?> lightbox">
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
				$custom_width = 1028; 
				$custom_height = 354;	
				cs_meta_content_class();
				if( cs_meta_content_class() == "col-md-12"){
				if($cs_node->cs_blog_view == "blog-large"){$custom_width = 1028; $custom_height = 354; }elseif($cs_node->cs_blog_view == "blog-medium"){  $custom_width = 325; $custom_height = 183; }	
				}elseif( cs_meta_content_class() == "col-md-9"){
					if($cs_node->cs_blog_view == "blog-large"){ $custom_width = 730; $custom_height = 346; }elseif($cs_node->cs_blog_view == "blog-medium"){  $custom_width = 230; $custom_height = 172; }	
				}
				
			if($cs_node->cs_blog_view == "blog-large"){
				$width 	=1058;
				$height	=364;
				$cat = true;
				$tag = false;
			}elseif($cs_node->cs_blog_view == "blog-grid"){
				$width 	=325;
				$height	=183;
			}else{
				$width 	=330;
				$height	=248;
				$cat = false;
				$tag = false;
				$comment = false;
			}			
			?>
			<?php
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
						$post_gallery = $cs_xmlObject->post_thumb_gallery;
 						$no_image = '';
						$custom_cls = '';
						
						$image_url = cs_get_post_img_src($post->ID, $width, $height);
						$image_url_full = cs_get_post_img_src($post->ID, '' ,'');
						if($image_url == "" and $post_view == "Single Image"){
							$no_image = 'no-image';
						}
					}else{
						$post_view = '';
						$no_image = '';	
						$image_url = '';
						$image_url_full = '';
						$post_gallery = '';
					}	
					?>
                    <!-- Blog Post Start -->
                    <article <?php post_class(cs_post_type($post_view ,$image_url)); ?>>
                    	 <?php
  							echo '<figure>';
  							 	if ( $post_view == "Slider"  and $post_slider <> ''){
                                 	cs_flex_slider($width, $height,$post_slider);
                                 }elseif($post_view == "Single Image"){
                                	if($image_url <> ''){ 
									echo '<a href="'.get_permalink().'" ><img src="'.$image_url.'" alt="" ></a>
										 <figcaption>
                                   		 <a href="'.get_permalink().'"><i class="fa fa-plus-circle"></i></a>
                                		</figcaption>';
									 }
                                }elseif($post_view == "Video"){
 									$url = parse_url($post_video);
									if($url['host'] == $_SERVER["SERVER_NAME"]){
 									$poster_url = '';
										if($post_featured_image=='on'){$poster_url = $image_url;}
										 if($image_url <> ''){ echo "<a href='".get_permalink()."'><img src=".$image_url." alt='' ></a>";}
									
                                    ?>
                                        <figcaption class="gallery">
                                           <a data-toggle="modal" data-target="#myModal<?php echo $post->ID;?>"  onclick="cs_video_load('<?php echo get_template_directory_uri();?>', <?php echo $post->ID;?>, '<?php echo $post_video;?>','<?php echo $poster_url;?>');" href="#"><i class="fa fa-video-camera"></i></a>
                                         </figcaption>
                                     
									<?php
									}else{
  									  	if($cs_node->cs_blog_view == "blog-large"){
											echo wp_oembed_get($post_video);
										}
									}
  								}elseif($post_view == "Audio" and $post_audio <> ''){
 									if($image_url <> ''){ echo "<a href='".get_permalink()."'><img src=".$image_url." alt='' ></a>";}
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
									if($cs_node->cs_blog_view == "blog-large"){
										cs_post_gallery($post_gallery);
									}
									
								}
								echo '</figure>';
 							 ?>
                        <!-- Blog Post Thumbnail End -->
                         	<div class="text">
                            	<h2 class="heading-color cs-post-title"> 
                                	<a href="<?php the_permalink(); ?>" class="cs-colrhvr">
									<?php the_title(); ?>
                                    </a>
                                </h2>
                                 <?php if($cs_node->cs_blog_view != "blog-grid"){ cs_posted_on($cat,$tag,$comment); } ?>
                                 <?php
								if($cs_node->cs_blog_description == "yes"){?>
                                 	<p><?php cs_get_the_excerpt($cs_node->cs_blog_excerpt,true);?></p>
                                      <?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Faith' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
                            <?php }?>
                            
                             </div>
                      </article>
                     <?php if($post_view == "Video"){?>
                    <div class="modal fade" id="myModal<?php echo $post->ID;?>" tabindex="-1" role="dialog" aria-hidden="true"></div>
                    <?php }?>
                    
                    <!-- Blog Post End -->
               		<?php endwhile;  ?>
                 	<!-- Blog End -->
                <?php
 				echo '</div>';
                $qrystr = '';
               if ( $cs_node->cs_blog_pagination == "Show Pagination" and $post_count > $cs_node->cs_blog_num_post and $cs_node->cs_blog_num_post > 0 ) {
					if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
						echo cs_pagination($post_count, $cs_node->cs_blog_num_post,$qrystr);
                }
                 // pagination end
             ?>
	</div>