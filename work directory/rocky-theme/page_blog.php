 <?php
 	global $cs_node,$post,$cs_theme_option,$counter_node,$video_width; 
  	if ( !isset($cs_node->cs_blog_num_post) || empty($cs_node->cs_blog_num_post) ) { $cs_node->cs_blog_num_post = -1; }
	?>
	<div class="<?php cs_blog_classes($cs_node->cs_blog_view);?> element_size_<?php echo $cs_node->blog_element_size; ?>  <?php if($cs_node->cs_blog_title == ''){ echo 'no-heading';} ?>">
		 <?php	if ($cs_node->cs_blog_title <> '') { ?>
                <header class="heading">
                    <h2 class="cs-heading-color section-title"><?php echo $cs_node->cs_blog_title; ?></h2>
                </header>
        <?php  } ?>
  		<?php if($cs_node->cs_blog_view_all <> ''){?>
        	<a class="btnviewall float-right" href="<?php if($cs_node->cs_blog_view_all_url <> ''){ echo $cs_node->cs_blog_view_all_url; }else{ echo '#'; };?>">				<em class="fa fa-reorder"></em>
                <?php echo $cs_node->cs_blog_view_all;?>
            </a>
        <?php } ?> 
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
            $counter = 0;
			if($cs_node->cs_blog_view == "blog-masonry" ){
				 cs_enqueue_masonry_style_script();
				 ?>
                  <script type="text/javascript">
              		jQuery(document).ready(function(){ 
					cs_mas_script('container<?php echo $counter_node;?>');
 				
 				});
               </script>
               
                 
                <?php
				$custom_width = 270;
				$custom_height = 270;
				echo '<div class="bolg_column mas-con" id="container'.$counter_node.'">';	
				if(have_posts()):
			
					if( cs_meta_content_class() == "col-lg-12 col-md-12"){
					if($cs_node->cs_blog_view == "blog-masonry-four-col"){ $custom_width = 270; $custom_height = 152; }elseif($cs_node->cs_blog_view == "blog-masonry-three-col"){ $custom_width = 370; $custom_height = 208;  }	
					}elseif( cs_meta_content_class() == "col-lg-9 col-md-9"){
						if($cs_node->cs_blog_view == "blog-masonry-four-col"){ $custom_height = 134; }elseif($cs_node->cs_blog_view == "blog-masonry-three-col"){ $custom_width = 270; $custom_height = 152; }
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
                    $post_slider_type = $cs_xmlObject->post_thumb_slider_type;
					$width = 570;
					$height = 320;
                    $image_url = cs_attachment_image_src(get_post_thumbnail_id($post->ID),$width,$height);
                 }else{
					$post_view = '';
				}
				?>
                <article <?php post_class(); ?>>
                	<figure>
                        	<?php
								if ( $post_view == "Map" ){
									$cs_node->map_lat = $cs_xmlObject->post_thumb_map_lat;
									$cs_node->map_lon = $cs_xmlObject->post_thumb_map_lon;
									$cs_node->map_zoom = $cs_xmlObject->post_thumb_map_zoom;
									$cs_node->map_address = $cs_xmlObject->post_thumb_map_address;
									$cs_node->map_control = $cs_xmlObject->post_thumb_map_controls;
									$cs_node->map_height = $custom_height;
									echo cs_map_page();
								}elseif( $post_view == "Slider" and $post_slider <> "" ){
                                     cs_flex_slider($width, $height,$post_slider);
                                }elseif($post_view == "Single Image"){
                                	if($image_url <> ''){ echo "<img src=".$image_url." alt='' >
									<figcaption><a href='".get_permalink()."' class='btnarrow'></a></figcaption>";
									 }
                                }elseif($post_view == "Video"){
									$url = parse_url($post_video);
									if($url['host'] == $_SERVER["SERVER_NAME"]){
									?>
										<video width="100%" class="mejs-wmp" height="100%" src="<?php echo $post_video ?>" id="player1" poster="<?php if($post_featured_image == "on"){ echo $image_url; } ?>" controls="controls" preload="none"></video>
									<?php
									}else{
  									  	echo wp_oembed_get($post_video,array('width'=>$custom_width));
									}
								}elseif($post_view == "Audio" and $post_audio <> ''){
								?>
                                <div class="audiowrapp fullwidth">
									<audio style="width:100%;" src="<?php echo $post_audio; ?>" type="audio/mp3" controls="controls"></audio>
                                </div>    
								<?php
								}
   							?>	
                        </figure>
                        <div class="blog_text fullwidth">
                                    <h2 class="post-title">
                                        <a href="<?php the_permalink(); ?>" class="colrhover"><?php echo substr(get_the_title(),0,30); ?></a>
                                    </h2>
                                    <div class="postpanel">
                                        <ul class="post-options">
                                            <li> <em><?php printf(__('By: %s','Rocky'),"") ?></em> <?php printf( __('%s','Rocky'), '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="colrhover">'.get_the_author().'</a>' );?> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('on','Rocky');}else{ echo $cs_theme_option['trans_other_on']; } ?> <time datetime="<?php echo date('Y-m-d',strtotime(get_the_date()));?>"><?php echo get_the_date();?></time>
                                            </li>
                                             <?php edit_post_link( __( 'Edit', 'Rocky'), '<li><span class="edit-link">', '</span></li>' ); ?>
                                        </ul>
                                    </div>
                                    <?php if($cs_node->cs_blog_description == "yes"){?>
                                         <p><?php echo cs_get_the_excerpt($cs_node->cs_blog_excerpt,false) ?></p>
                                 	<?php } ?>
                                     
                                </div>
                        <div class="postpanel postpanel-bottom">
                                        <ul class="post-options">
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
                    </article>
                 
                <?php
				endwhile; endif;
              	echo '</div>';
			}elseif($cs_node->cs_blog_view == "blog-small"){
			?>
             <?php
				  while ($custom_query->have_posts()) : $custom_query->the_post();
					  $post_xml = get_post_meta($post->ID, "post", true);	
					  if ( $post_xml <> "" ) {
						  $cs_xmlObject = new SimpleXMLElement($post_xml);
						  $post_icon = $cs_xmlObject->post_icon;
						  $no_image = '';
						  $width 	=69;
						  $height	=53;
						  $image_url = cs_get_post_img_src($post->ID, $width, $height);
						   
					  }else{
						  $post_view = '';
						  $no_image = '';
						  $post_icon = '';	
					  }
				  ?>
				  <article class="<?php if($image_url ==''){ echo 'no-image';}?>">
					  <?php if($image_url <> ''){ echo "<img src=".$image_url." alt=''  class='float-left'>"; } ?>
					   <div class="text">
						  <h2 class="cs-heading-color post-title"><a href="<?php the_permalink(); ?>" class="colrhover"><?php the_title(); ?></a></h2>
						  <div class="bottompanel-blog">
							  <em><?php printf(__('By: %s','Rocky'),"") ?></em> <?php printf( __('%s','Rocky'), '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="colrhover">'.get_the_author().'</a>' );?> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('on','Rocky');}else{ echo $cs_theme_option['trans_other_on']; } ?> <time datetime="<?php echo date('Y-m-d',strtotime(get_the_date()));?>"><?php echo get_the_date();?></time>
							  <?php edit_post_link( __( 'Edit', 'Rocky'), '<span class="edit-link">', '</span>' ); ?>
						   </div>
					  </div>
				  </article>
                 <?php endwhile;?>
				<?php
 				
				}else{
				$custom_width = 1170; 
				$custom_height = 430;
 				if( cs_meta_content_class() == "col-lg-12 col-md-12"){
					if($cs_node->cs_blog_view == "blog-large"){$custom_width = 1170; $custom_height = 430; }elseif($cs_node->cs_blog_view == "blog-medium"){  $custom_width = 370; $custom_height = 208; }	
					}elseif( cs_meta_content_class() == "col-lg-9 col-md-9"){
						if($cs_node->cs_blog_view == "blog-large"){ $custom_width = 870; $custom_height = 320; }elseif($cs_node->cs_blog_view == "blog-medium"){  $custom_width = 370; $custom_height = 208; }	
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
							$post_slider_type = $cs_xmlObject->post_thumb_slider_type;
							$post_icon = $cs_xmlObject->post_icon;
							$no_image = '';
							$width 	=1170;
							$height	=430;
							$image_url = cs_get_post_img_src($post->ID, $width, $height);
 					}else{
						$post_view = '';
						$no_image = '';
						$post_icon = '';	
					}	
					?>
                    <!-- Blog Post Start -->
                    <article <?php post_class(); ?>>
                    	<figure>
                        	<?php
								if ( $post_view == "Map" ){
									$cs_node->map_lat = $cs_xmlObject->post_thumb_map_lat;
									$cs_node->map_lon = $cs_xmlObject->post_thumb_map_lon;
									$cs_node->map_zoom = $cs_xmlObject->post_thumb_map_zoom;
									$cs_node->map_address = $cs_xmlObject->post_thumb_map_address;
									$cs_node->map_control = $cs_xmlObject->post_thumb_map_controls;
									$cs_node->map_height = $custom_height;
									echo cs_map_page();
								}elseif( $post_view == "Slider" and $post_slider <> "" ){
                                     cs_flex_slider($width, $height,$post_slider);
                                }elseif($post_view == "Single Image"){
                                	if($image_url <> ''){ echo "<img src=".$image_url." alt='' >
									<figcaption><a href='".get_permalink()."' class='btnarrow'></a></figcaption>";
									 }
                                }elseif($post_view == "Video"){
									$url = parse_url($post_video);
									if($url['host'] == $_SERVER["SERVER_NAME"]){
									?>
										<video width="100%" class="mejs-wmp" height="<?php echo $custom_height; ?>" src="<?php echo $post_video ?>" id="player1" poster="<?php if($post_featured_image == "on"){ echo $image_url; } ?>" controls="controls" preload="none"></video>
									<?php
									}else{
  									  	echo wp_oembed_get($post_video,array('height' =>$custom_height));
									}
								}elseif($post_view == "Audio" and $post_audio <> ''){
								?>
                                <div class="audiowrapp fullwidth">
									<audio style="width:100%;" src="<?php echo $post_audio; ?>" type="audio/mp3" controls="controls"></audio>
                                </div>    
								<?php
								}
   							?>	
                        </figure>
                        <div class="blog_text fullwidth">
                        	<?php //cs_featured(); ?>
                            <div class="fullwidth">
                            	<?php if($post_icon <> ''){?>
                                	<span class="cate-icon">
                                    <span class="fa-stack fa-lg">
                                      <i class="fa fa-square fa-stack-2x"></i>
                                      <i class="fa <?php echo $post_icon; ?> fa-stack-1x fa-inverse"></i>
                                    </span>
                                </span>
                                <?php }?>
                                <div class="head-group">
                                     <h2 class="cs-heading-color post-title"><a href="<?php the_permalink(); ?>" class="colrhover"><?php the_title(); ?></a></h2>
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
                                </div>
                            </div>
                            <?php if($cs_node->cs_blog_description == "yes"){?>
                           		<div class="text">
                                	<p><?php  cs_get_the_excerpt($cs_node->cs_blog_excerpt, false);?></p>
                          		</div>
                           	<?php }?>
                            <?php
								/* translators: used between list items, there is a space after the comma */
								$before_tag = "<div class='tags-area'> <em class='fa fa-tags'></em>".__( '','Rocky')."";
								$tags_list = get_the_term_list ( get_the_id(), 'post_tag',$before_tag, ', ', '</div>' );
								if ( $tags_list){
									printf( __( '%1$s', 'Rocky'),$tags_list ); 
								} // End if categories 
							?>  
                             <?php edit_post_link( __( 'Edit', 'Rocky'), '<span class="edit-link">', '</span>' ); ?>    
                        </div>
					</article>
                    <!-- Blog Post End -->
               		<?php endwhile; } ?>
                 	<!-- Blog End -->
    			</div>   
                <?php
                $qrystr = '';
                if ( $cs_node->cs_blog_pagination == "Show Pagination" and $post_count > $cs_node->cs_blog_num_post and $cs_node->cs_blog_num_post > 0 ) {
					if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
						echo cs_pagination($post_count, $cs_node->cs_blog_num_post,$qrystr);
                }
                 // pagination end
             ?>
     	