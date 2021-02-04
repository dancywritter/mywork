 <?php
 	cs_enqueue_masonry_style_script();
  	global $cs_node,$post,$cs_theme_option; 
    if ( !isset($cs_node->cs_blog_num_post) || empty($cs_node->cs_blog_num_post) || $cs_node->cs_blog_num_post<0 ) { $cs_node->cs_blog_num_post = -1; } else if($cs_node->cs_blog_num_post>0 && $cs_node->cs_blog_num_post<40){ $cs_node->cs_album_per_page = 40;}
 	if (empty($_GET['page_id_all'])) $_GET['page_id_all'] = 1;
	$args = array('posts_per_page' => "-1", 'paged' => $_GET['page_id_all'], 'category_name' => "$cs_node->cs_blog_cat",'post_status' => 'publish');
	$custom_query = new WP_Query($args);
	$post_count = $custom_query->post_count;
	if ( $cs_node->cs_blog_sidebar <> '') {  ?>
			<aside class="left-content">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_node->cs_blog_sidebar) ) : endif; ?>
			</aside>
		<?php 
			}
 	?>
	<div class="cs-blog" style="padding-left:<?php echo $cs_node->cs_blog_left_space; ?>px">
		<?php
		if($cs_node->cs_blog_title <> ""){
			$cs_fullheight = '';
		?>
            <header class="section-header">
                <h2 class="section-title cs-heading-color"><?php echo $cs_node->cs_blog_title; ?></h2>
            </header>
		<?php
		}else{
			$cs_fullheight = 'cs_fullheight';
		}
		?>
        <?php if($cs_node->cs_blog_num_post <> "-1" && $cs_node->cs_blog_num_post < $post_count){?>
		<script type="text/javascript">
        	jQuery(document).ready(function() {
            	blog_load_more_js(<?php echo $cs_node->cs_blog_num_post; ?>, '<?php echo $cs_node->cs_blog_view; ?>', '<?php echo $cs_node->cs_blog_excerpt; ?>', '<?php echo $post_count;?>', '<?php echo $cs_node->cs_blog_cat; ?>', '<?php echo home_url() ?>','<?php echo get_template_directory_uri() ?>','<?php echo $cs_node->cs_blog_description?>');
				return false;
            });
       	</script>
        <?php } ?>

        <?php 
        	$count_post = 0;
			if($cs_node->cs_blog_cat == "all"){
				$args = array('posts_per_page' => "$cs_node->cs_blog_num_post", 'paged' => $_GET['page_id_all']);
			}else{
				$args = array('posts_per_page' => "$cs_node->cs_blog_num_post", 'paged' => $_GET['page_id_all'], 'category_name' => "$cs_node->cs_blog_cat");
			}
			$custom_query = new WP_Query($args);
			$counter = 0;
			if(have_posts()):
				if($cs_node->cs_blog_view == 'gird_view'){
				?>
                 <script type="text/javascript">
					jQuery(document).ready(function() {
					  LoadedItem ("home-gallery article");
						cs_masonary_callback('home-gallery')
						blog_grid_view()
					});
					jQuery(window).load(function($) {
						blog_grid_view()
						jQuery(window).trigger('resize')
					});
						jQuery(window).resize(function($) {
						blog_grid_view()
					});
				</script>
               
                <div class="home-gallery <?php echo $cs_fullheight.' '.$cs_node->cs_blog_view;?>" ><?php
				$custom_width = 270; 
                $custom_height = 270;	
				$count_first = 1;
 				$cs_featured_post_args =  array('post_type' => "post", 'p' => $cs_node->cs_featured_post);
				$cs_featured_post_custom_query = new WP_Query($cs_featured_post_args);
				 while ($cs_featured_post_custom_query->have_posts()) : $cs_featured_post_custom_query->the_post();
				$image_url = cs_get_post_img_src($post->ID, 550, 550);
				if($image_url <> ''){
						$cs_like_counter = get_post_meta($post->ID, "cs_like_counter", true);
						if ( !isset($cs_like_counter) or empty($cs_like_counter) ) $cs_like_counter = 0;
				?>
				<article class="featured">
                        <figure>
                            <img src="<?php echo $image_url;?>" alt="">
                            <figcaption>
                                <h2 class="post-title cs_featured_title"><a href="<?php the_permalink(); ?>" class="colrhover"><?php the_title(); ?></a></h2>
                                <div class="bottompanel">
                                     <span class="post-panel float-right">
                                      <p class="date-event"><time datetime="<?php echo date('d/m/Y',strtotime(get_the_date()));?>"><em class="fa fa-time">&nbsp;</em><?php echo date('d/m/Y',strtotime(get_the_date()));?></time></p>
                                    <?php 
									if ( comments_open() ) {  comments_popup_link( __( '<em class="fa fa-comment">&nbsp;</em> 0', 'Rocky' ) , __( '<em class="fa fa-comment">&nbsp;</em> 1', 'Rocky' ), __( '<em class="fa fa-comment">&nbsp;</em> %', 'Rocky' ) ); } ?>
                                   
                                    <a href="<?php the_permalink(); ?>"><em class="fa fa-heart">&nbsp;</em><?php echo $cs_like_counter;?></a></span>
                                </div>
                               <p><?php  if($cs_node->cs_blog_description == "yes" ){ cs_get_the_excerpt($cs_node->cs_blog_excerpt,true); }?></p>
                            </figcaption>
                        </figure>
                    </article>
                    
				<?php
				}
				endwhile;
				
                while ($custom_query->have_posts()) : $custom_query->the_post();
                	$post_xml = get_post_meta($post->ID, "post", true);	
                    if ( $post_xml <> "" ) {
						
                    	$cs_xmlObject = new SimpleXMLElement($post_xml);
						
                        $post_view = $cs_xmlObject->post_thumb_view;
                        $post_image = $cs_xmlObject->post_thumb_image;
                        $post_featured_image = $cs_xmlObject->post_featured_image_as_thumbnail;
						$cs_post_description = $cs_xmlObject->cs_post_description;
						$cs_char_length = 55;
						$width 	= 270;
						$height	= 270;
                        $image_url = cs_get_post_img_src($post->ID, $width, $height);
                        
                    }else{
                    	$post_view = '';
						$cs_post_description = '';
                        $no_image = '';	
                    }	
					if($image_url <> ''){
						
						$cs_like_counter = get_post_meta($post->ID, "cs_like_counter", true);
						if ( !isset($cs_like_counter) or empty($cs_like_counter) ) $cs_like_counter = 0;
						
                    ?>
                    <article class="album">
                        <figure>
                            <img src="<?php echo $image_url;?>" alt="">
                            <figcaption>
                                <h2 class="post-title"><a href="<?php the_permalink(); ?>" class="colrhover"><?php echo substr(get_the_title(),0,$cs_char_length); if(strlen(get_the_title()) > $cs_char_length) echo "..."; ?></a></h2>
                                <div class="bottompanel">
                                     <span class="post-panel float-right">
                                      <p class="date-event"><time datetime="<?php echo date('d/m/Y',strtotime(get_the_date()));?>"><em class="fa fa-time">&nbsp;</em><?php echo date('d/m/Y',strtotime(get_the_date()));?></time></p>
                                    <?php 
									if ( comments_open() ) {  comments_popup_link( __( '<em class="fa fa-comment">&nbsp;</em> 0', 'Rocky' ) , __( '<em class="fa fa-comment">&nbsp;</em> 1', 'Rocky' ), __( '<em class="fa fa-comment">&nbsp;</em> %', 'Rocky' ) ); } ?>
                                   
                                    <a href="<?php the_permalink(); ?>"><em class="fa fa-heart">&nbsp;</em><?php echo $cs_like_counter;?></a></span>
                                </div>
                               
                            </figcaption>
                        </figure>
                    </article>
                  <!-- Blog Post Close -->
                 <?php
				 $count_first++;
					}
				  endwhile;
				echo '</div>';
				} else {
		?><div class="blog-gallery <?php echo $cs_fullheight.' '.$cs_node->cs_blog_view; ?> cs-blog-list-view">
         <script type="text/javascript">
						jQuery(document).ready(function() {
							cs_masonary_callback('blog-gallery');
							 resize_blog_template ();
						});
							jQuery(window).load(function() {
							/* Act on the event */
							 resize_blog_template ()
							 jQuery("body") .trigger('resize')
						});
						jQuery(window).resize(function() {
							/* Act on the event */
							 resize_blog_template ()
						});
						
					</script>
		<?php
				$cs_like_counter = get_post_meta($post->ID, "cs_like_counter", true);
						if ( !isset($cs_like_counter) or empty($cs_like_counter) ) $cs_like_counter = 0;
				
            	$custom_width = 270; 
                $custom_height = 270;	
                while ($custom_query->have_posts()) : $custom_query->the_post();
                	$post_xml = get_post_meta($post->ID, "post", true);	
                    if ( $post_xml <> "" ) {
                    	$cs_xmlObject = new SimpleXMLElement($post_xml);
                        $post_view = $cs_xmlObject->post_thumb_view;
                        $post_image = $cs_xmlObject->post_thumb_image;
                        $post_featured_image = $cs_xmlObject->post_featured_image_as_thumbnail;
						$post_audio_featured_image_as_thumbnail =$cs_xmlObject->post_audio_featured_image_as_thumbnail;
                        $post_slider = $cs_xmlObject->post_thumb_slider;
                        $post_slider_type = $cs_xmlObject->post_thumb_slider_type;
                        $post_audio = $cs_xmlObject->post_thumb_audio;
						$post_video = $cs_xmlObject->post_thumb_video;
						$cs_post_description = $cs_xmlObject->cs_post_description;
						$no_image = '';
                        $width 	= 300;
                        $height	= 169;
                        $image_url = cs_get_post_img_src($post->ID, $width, $height);
						$image_url_full = cs_get_post_img_src($post->ID,'' ,'');
                        if($image_url == "" and $post_view == "Single Image"){
                        	$no_image = ' no-image';
                        }
                    }else{
						$cs_post_description = '';	
                    	$post_view = '';
                        $no_image = '';	
                    }
					$cs_like_counter = get_post_meta($post->ID, "cs_like_counter", true);
								if ( !isset($cs_like_counter) or empty($cs_like_counter) ) $cs_like_counter = 0;	
                    ?>
                   
                    <!-- Blog Post -->
                    <article class="post lightbox">
                    	<div class="article-wrapp">
                        	<figure>
                        	<?php 
                            if ( $post_view == "Slider" and $post_slider_type == "Flex Slider" ){
 									cs_flex_slider($width, $height,$post_slider,false);
                             }elseif($post_view == "Video" and $post_video <> ''){
								$url = parse_url($post_video);
								if($url['host'] == $_SERVER["SERVER_NAME"]){?>
								<video width="100%" height="100%" class="mejs-wmp" src="<?php echo $post_video ?>" poster="<?php if($post_featured_image =="on"){ echo $image_url; } ?>"  controls="controls" preload="none"></video>
							<?php
								}else{
									echo wp_oembed_get($post_video, array('width'=>$custom_width));
								}
							}elseif($post_view == "Audio" and $post_audio <> ''){
 							?>
                            	<audio style="width:100%; height:100%" src="<?php echo $post_audio; ?>" type="audio/mp3" poster="<?php if($post_audio_featured_image_as_thumbnail =="on"){ echo $image_url; } ?>" controls="controls"></audio>
							 <?php
                              }elseif($post_view == "Map"){
 									$cs_node->map_lat = $cs_xmlObject->post_thumb_map_lat;
									$cs_node->map_lon = $cs_xmlObject->post_thumb_map_lon;
									$cs_node->map_zoom = $cs_xmlObject->post_thumb_map_zoom;
									$cs_node->map_address = $cs_xmlObject->post_thumb_map_address;
									$cs_node->map_controls = $cs_xmlObject->post_thumb_map_controls;
									$cs_node->map_height = 180;
									echo cs_blog_thum_map();
 							  ?>
							  <?php
                             }elseif($post_view == "Single Image" and $image_url <> ''){
                                
  									echo "<a href=".get_permalink()." >	<img src=".$image_url." alt='' ></a>";
                               } 
							 ?>
                             </figure>
							  <div class="cs-text">
                                <h2 class="post-title"><a href="<?php the_permalink(); ?>" class="colrhover"><?php the_title(); ?></a></h2>
                                <p><?php  if($cs_node->cs_blog_description == "yes" ){ cs_get_the_excerpt($cs_node->cs_blog_excerpt,true); }?></p>
                                <div class="bottompanel">
                                     <span class="post-panel float-right">
                                      <p class="date-event"><time datetime="<?php echo date('d/m/Y',strtotime(get_the_date()));?>"><em class="fa fa-time">&nbsp;</em><?php echo get_the_date();?></time></p>
                                    <?php 
									if ( comments_open() ) {  comments_popup_link( __( '<em class="fa fa-comment">&nbsp;</em> 0', 'Rocky' ) , __( '<em class="fa fa-comment">&nbsp;</em> 1', 'Rocky' ), __( '<em class="fa fa-comment">&nbsp;</em> %', 'Rocky' ) ); } ?>
                                   
                                    <a href="<?php the_permalink(); ?>"><em class="fa fa-heart">&nbsp;</em><?php echo $cs_like_counter;?></a></span>
                                </div>
                             </div>
                             
                          </div>
                      </article>
                      <!-- Blog Post Close -->
                  <?php endwhile;?>
            </div>
            <?php 
				  
				}
		endif; ?>
  </div>