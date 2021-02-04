 <?php
 	global $cs_node,$post,$cs_theme_option,$counter_node,$video_width; 
  	if ( !isset($cs_node->cs_blog_num_post) || empty($cs_node->cs_blog_num_post) ) { $cs_node->cs_blog_num_post = -1; }
	?>
     <!-- Postlist Start -->
  <div class="element_size_<?php echo $cs_node->blog_element_size;?>">
    <div class="<?php if($cs_node->cs_blog_view == "blog-masonry" ){ echo 'postlist blog blog-masonry-three-col';} else if($cs_node->cs_blog_view == "blog-home"){ echo 'latest-news';} else if($cs_node->cs_blog_view == "blog-medium"){ echo 'postlist blog blog-medium-view';} else { echo 'postlist blog ';}?>">
    	<?php	if ($cs_node->cs_blog_title <> '') { ?>
                <header class="cs-heading-title">
                    <h2 class="cs-section-title cs-heading-color"><?php echo $cs_node->cs_blog_title; ?></h2>
                </header>
        <?php  } ?>
        <?php
            if (empty($_GET['page_id_all'])) $_GET['page_id_all'] = 1;
            $args = array('posts_per_page' => "-1", 'paged' => $_GET['page_id_all'], 'category_name' => "$cs_node->cs_blog_cat",'post_status' => 'publish');
            $custom_query = new WP_Query($args);
            $post_count = $custom_query->post_count;
            $count_post = 0;
			$args = array('posts_per_page' => "$cs_node->cs_blog_num_post", 'paged' => $_GET['page_id_all'], 'category_name' => "$cs_node->cs_blog_cat", 'post_status' => 'publish', 'orderby' => 'ID', 'order' => 'DESC');
            $custom_query = new WP_Query($args);
            $counter = 0;
			if($cs_node->cs_blog_view == "blog-masonry" ){
				cs_enqueue_gallery_style_script();
				cs_enqueue_masonry_style_script();
				 $qrystr= "";
                 if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
				 ?>
                  <script type="text/javascript">
              		jQuery(document).ready(function(){ 
						cs_mas_script('container');
	 				});
               </script>
                <?php
				$custom_width = 310;
				$custom_height = 250;
				echo '<div id="container">';	
				if(have_posts()):
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
					$width 	=730;
					$height	=350;
                    $image_url = cs_attachment_image_src(get_post_thumbnail_id($post->ID),0,0);
                 }else{
					$post_view = '';
				}
				?>
                <div class="box photo">
                                <article>
                                    <figure>
                                    <?php
										if( $post_view == "Slider" and $post_slider <> "" ){
											 cs_flex_slider($width, $height,$post_slider);
										}elseif($post_view == "Single Image"){
											if($image_url <> ''){ echo "<a href='".get_permalink()."'><img src=".$image_url." alt='' ></a>";
                                        echo '<figcaption class="gallery">
													<div class="blogimg-hover lightbox clearfix">
														<a href="'.get_permalink().'"><i class="fa fa-link fa-2x"></i></a>
														<a rel="prettyPhoto" data-title="" href="'.$image_url.'" data-rel="prettyPhoto"><i class="fa fa-plus fa-2x"></i></a>
													</div>
												</figcaption>';
											 }
										}elseif($post_view == "Video"){
											$url = parse_url($post_video);
											if($url['host'] == $_SERVER["SERVER_NAME"]){
											?>
												<video width="<?php echo $custom_width;?>" class="mejs-wmp" height="<?php echo $custom_height;?>" src="<?php echo $post_video ?>" id="player1" poster="<?php if($post_featured_image == "on"){ echo $image_url; } ?>" controls="controls" preload="none"></video>
											<?php
											}else{
												echo wp_oembed_get($post_video,array('width'=>$custom_width));
											}
										}elseif($post_view == "Audio" and $post_audio <> ''){
										?>
										<div class="audiowrapp fullwidth">
											<audio style="width:<?php echo $custom_width;?>;" src="<?php echo $post_audio; ?>" type="audio/mp3" controls="controls"></audio>
										</div>    
										<?php
										}
									?>
                                    </figure>
                                    <div class="blog-text webkit">
                                        <div class="text">
                                            <h2 class="cs-post-title cs-heading-color"><a href="<?php the_permalink(); ?>" class="colrhover"><?php echo substr(get_the_title(), 0, 54); if(strlen(get_the_title())>54) echo '...'; ?></a></h2>
                                     <?php if($cs_node->cs_blog_description == "yes"){?>
                                         		<p><?php echo cs_get_the_excerpt($cs_node->cs_blog_excerpt,false) ?></p>
                                 	<?php } ?>
                                        </div>
                                    </div>
                                    <ul class="post-options">
                                        <li><i class="fa fa-user"></i><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"> <?php echo get_the_author(); ?></a> <time datetime="<?php echo date('d-m-y',strtotime(get_the_date()));?>">/  <?php echo date('d.m.y',strtotime(get_the_date()));?></time></li>
                                        <?php cs_featured();?>
                                    </ul>
                                </article>
                            </div>
                <?php
				endwhile; endif;
              	echo '</div>';
			}elseif($cs_node->cs_blog_view == "blog-medium" ){
				cs_enqueue_gallery_style_script();
				 $qrystr= "";
                 if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
				 
				$custom_width = 310;
				$custom_height = 250;
				if(have_posts()):
				$counter_news = 0;
				while ($custom_query->have_posts()) : $custom_query->the_post();
				$counter_news++;
                $post_xml = get_post_meta($post->ID, "post", true);	
                if ( $post_xml <> "" ) {
                    $cs_xmlObject = new SimpleXMLElement($post_xml);
                    $post_view = $cs_xmlObject->post_thumb_view;
                    $post_image = $cs_xmlObject->post_thumb_image;
                    $post_video = $cs_xmlObject->post_thumb_video;
					$post_audio = $cs_xmlObject->post_thumb_audio;
					$post_slider = $cs_xmlObject->post_thumb_slider;
                    $post_slider_type = $cs_xmlObject->post_thumb_slider_type;
					$width 	=730;
					$height	=350;
                    $image_url = cs_attachment_image_src(get_post_thumbnail_id($post->ID),730,350);
                 }else{
					$post_view = '';
				}
				$no_image = "";
				if($image_url == ""){
					$no_image = "class='no-image'";
				}
				?>
                    <article <?php echo $no_image; ?>>
                    	
                        <div class="blog-medium-text">
                        	<div class="medium-time">
                                <span><?php echo date('d M',strtotime(get_the_date()));?></span><time datetime="<?php echo date('d-m-y',strtotime(get_the_date()));?>"><?php echo date('Y',strtotime(get_the_date()));?></time>
                            </div>
                            <div class="blog-text webkit">
                                <div class="text">
                                    <h2 class="cs-post-title cs-heading-color"><a href="<?php the_permalink(); ?>" class="colrhover"><?php echo substr(get_the_title(), 0, 54); if(strlen(get_the_title())>54) echo '...'; ?></a></h2>
                                    <?php cs_featured();?>
                                    <ul class="post-options">
                                    
                                     <?php
									  /* translators: used between list items, there is a space after the comma */
									  $before_cat = '<li>'.__( 'in: ', 'Spikes');
									  $categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '</li>' );
									  if ( $categories_list ){
										  printf( __( '%1$s', 'Spikes'),$categories_list );
									  }
                                      
                                      ?>
                                     
                                
                            </ul>
                            	
                             <?php if($cs_node->cs_blog_description == "yes"){?>
                                        <p><?php echo cs_get_the_excerpt($cs_node->cs_blog_excerpt,false) ?></p>
                            <?php } ?>
                                </div>
                            </div>
                            
                        </div>
                    </article>
                <?php
				endwhile; endif;
              	
			} elseif($cs_node->cs_blog_view == "blog-home"){
				 cs_cycleslider_script();
	 		?>
                 <div class="center">
                    <a id="prev4" href="#" class="prev-btn bordercolr colr backcolrhover"><i class="fa fa-angle-left fa-1x"></i></a>
                    <a id="next4" href="#" class="next-btn bordercolr colr backcolrhover"><i class="fa fa-angle-right fa-1x"></i></a>
                </div>
                <div class="cycle-slideshow"
                data-cycle-timeout=400000
                data-cycle-fx=carousel
                data-cycle-slides="article"
                data-cycle-carousel-fluid="false"
                data-allow-wrap="true"
                    data-cycle-next="#next4"
                    data-cycle-prev="#prev4">
                        <?php
							//$image_url= '';
                             while ($custom_query->have_posts()) : $custom_query->the_post();
                                  $post_xml = get_post_meta($post->ID, "post", true);	
                                  if ( $post_xml <> "" ) {
                                      $cs_xmlObject = new SimpleXMLElement($post_xml);
                                      $post_icon = $cs_xmlObject->post_icon;
                                      $no_image = '';
                                      $width 	=230;
                                      $height	=152;
                                      $image_url = cs_get_post_img_src($post->ID, $width, $height);
                                       
                                  }else{
                                      $post_view = '';
                                      $no_image = '';
                                      $post_icon = '';	
                                  }
                              ?>
                              <article <?php post_class();?>>
                                <?php if($image_url <> ''){?><figure><a href="<?php the_permalink();?>"><img src="<?php echo $image_url;?>" alt=""></a></figure><?php }?>
                                <div class="text webkit">
                                    <h2 class="cs-post-title cs-heading-color"><a href="<?php the_permalink();?>"><?php echo substr(get_the_title(), 0, 40); if(strlen(get_the_title())>40) echo '...'; ?></a></h2>
                                     <?php if($cs_node->cs_blog_description == "yes"){?>
                                             <p><?php echo cs_get_the_excerpt($cs_node->cs_blog_excerpt,false) ?></p>
                                        <?php } ?>
                                    <time datetime="<?php echo date('d.m.Y',strtotime(get_the_date()));?>"><?php echo date('d.m.Y',strtotime(get_the_date()));?> /</time>
                                    <?php
                                              /* translators: used between list items, there is a space after the comma */
                                              $before_cat = '<div class="category">';
                                              $categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '</div>' );
                                              if ( $categories_list ){
                                                  printf( __( '%1$s', 'Spikes'),$categories_list );
                                              }
                                        ?>
                                </div>
                            </article>
                             <?php  endwhile;?>
                         </div>
				<?php
			} else {
				cs_enqueue_gallery_style_script();
				$custom_width = '100%';
				$custom_height = 410;
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
							$width 	=830;
							$height	=350;
							$image_url = cs_get_post_img_src($post->ID, $width, $height);
							$pos_class = array();
							if($image_url == ''){ $pos_class = 'no-img';}
 					}else{
						$post_view = '';
						$no_image = '';
						$post_icon = '';	
					}	
				?>
					 <article <?php post_class(); ?>>
                        <figure>
                            <?php
                                if( $post_view == "Slider" and $post_slider <> "" ){
                                     cs_flex_slider($width, $height,$post_slider);
                                }elseif($post_view == "Single Image"){
                                    if($image_url <> ''){ echo "<a href='".get_permalink()."'><img src=".$image_url." alt='' ></a>";
                                        echo '<figcaption class="gallery">
                                            <div class="blogimg-hover lightbox clearfix">
                                                <a href="'.get_permalink().'"><i class="fa fa-link fa-2x"></i></a>
                                                <a rel="prettyPhoto" data-title="" href="'.$image_url.'" data-rel="prettyPhoto"><i class="fa fa-plus fa-2x"></i></a>
                                            </div>
                                        </figcaption>';
                                     }
                                }elseif($post_view == "Video"){
                                    $url = parse_url($post_video);
                                    if($url['host'] == $_SERVER["SERVER_NAME"]){
                                    ?>
                                        <video width="100%" class="mejs-wmp" height="<?php echo $custom_height; ?>" src="<?php echo $post_video ?>" id="player1" poster="<?php if($post_featured_image == "on"){ echo $image_url; } ?>" controls="controls" preload="none"></video>
                                    <?php
                                    }else{
                                        echo wp_oembed_get($post_video,array('height' =>$custom_height, 'width' =>'720'));
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
                        <div class="blog-text webkit">
                        	
                            <div class="blog-date webkit"><time datetime="<?php echo date('d-m-y',strtotime(get_the_date()));?>"><?php echo date('d',strtotime(get_the_date()));?></time><span class="uppercase"><?php echo date('M',strtotime(get_the_date()));?></span></div>
                            <div class="text">
                                
                                <h2 class="cs-post-title cs-heading-color"><a href="<?php the_permalink();?>" class="colrhover"><?php echo substr(get_the_title(), 0, 130); if(strlen(get_the_title())>130) echo '...'; ?></a></h2>
                                <?php if($cs_node->cs_blog_description == "yes"){?>
                                     <p><?php echo cs_get_the_excerpt($cs_node->cs_blog_excerpt,false) ?></p>
                                <?php } ?>
                            </div>
                        </div>
                        <ul class="post-options">
                            <li><i class="fa fa-user"></i><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"> <?php echo get_the_author(); ?></a></li>
                             <?php
                                  /* translators: used between list items, there is a space after the comma */
                                  $before_cat = "<li><i class='fa fa-th-list'></i>".__( '','Spikes')."";
                                  $categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '</li>' );
                                  if ( $categories_list ){
                                      printf( __( '%1$s', 'Spikes'),$categories_list );
                                  }
                                $before_cat = '<li><i class="fa fa-tag"></i>';
                                $categories_list = get_the_term_list ( get_the_id(), 'post_tag', $before_cat, ', ', '</li>' );
                                if ( $categories_list ){ printf( __( '%1$s', 'Spikes' ),$categories_list ); }
                            	if ( comments_open() ) { echo "<li><i class='fa fa-comment'></i>";comments_popup_link( __( 'Comment', 'Spikes' ) , __( 'Comment', 'Spikes' ), __( 'Comment', 'Spikes' ) ); echo "</li>"; }
                            	cs_featured(); ?>
                        </ul>
                    </article>
				<?php 
				endwhile;
			}
			?>
         <!-- Postlist End -->
		 <?php
			$qrystr = '';
			if ( $cs_node->cs_blog_pagination == "Show Pagination" and $post_count > $cs_node->cs_blog_num_post and $cs_node->cs_blog_num_post > 0 ) {
				if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
					echo cs_pagination($post_count, $cs_node->cs_blog_num_post,$qrystr);
			}
			 // pagination end
		?>
    </div>   
		
</div>