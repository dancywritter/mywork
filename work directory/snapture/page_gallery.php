<?php
	global $cs_node,$counter_node;
  	cs_enqueue_gallery_style_script();
 	$count_post =0;
	$gal_album_db = $cs_node->album;
	// galery slug to id start
		$args=array(
			'name' => $gal_album_db,
			'post_type' => 'cs_gallery',
			'post_status' => 'publish',
			'showposts' => 1,
		);
 		$get_posts = get_posts($args);
		if($get_posts){
			$gal_album_db = $get_posts[0]->ID;
		}
	// galery slug to id end
	$cs_meta_gallery_options = get_post_meta($gal_album_db, "cs_meta_gallery_options", true);
	if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
	// pagination start
	if ( $cs_meta_gallery_options <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($cs_meta_gallery_options);
		if ($cs_node->media_per_page > 0 ) {
			$limit_start = $cs_node->media_per_page * ($_GET['page_id_all']-1);
			$limit_end = $limit_start + $cs_node->media_per_page;
			$count_post = count($cs_xmlObject);
				if ( $limit_end > count($cs_xmlObject) ) 
					$limit_end = count($cs_xmlObject);
		}
		else {
			$limit_start = 0;
			$limit_end = count($cs_xmlObject);
			$count_post = count($cs_xmlObject);
		}
	}
	$gal_margin_left = "";
	$gal_margin_left = $cs_node->margin_left;
	
	if($cs_node->layout == ""){
		$cs_node->layout = "cs-gutter-gallery";
	}
	?>
    <script>
		jQuery(document).ready(function($) {
			LazyLoad(".gallery","article")
		});
	</script>
	<?php 
		if($cs_node->layout == "cs-banner-thumb-gallery"){
			cs_enqueue_swiper();
			cs_enqueue_slideshowify();
			?>
		 				<div class="banner">
                            <script>
                            jQuery(document).ready(function($) {
                                cs_swipe_gallery()
                            });
                            </script>
                            <div id="bannerwrapper" class="cs_fullwidth_banner cs_thumbview_banner">
                                <div id="bannermainslider">
                                    <div class="swiper-container banner-slides">
                                        <div class="swiper-wrapper">
                                        <?php
											if ( $cs_meta_gallery_options <> "" ) {
											for ( $i = $limit_start; $i < $limit_end; $i++ ) {
												$path = $cs_xmlObject->gallery[$i]->path;
												$title = $cs_xmlObject->gallery[$i]->title;
												$social_network = $cs_xmlObject->gallery[$i]->social_network;
												$use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;
												$post_video = $cs_xmlObject->gallery[$i]->video_code;
												$link_url = $cs_xmlObject->gallery[$i]->link_url;
												$image_full_url = cs_attachment_image_src($path, 0, 0);
												$video_slide_class = '';
												if($use_image_as==1){
													$video_slide_class = 'video-slide';
												}
											?>
                                            <div class="swiper-slide <?php echo $video_slide_class;?>">
                                                <img src="<?php echo $image_full_url;?>" alt="">  
                                                
                                                 <?php 
											if($use_image_as==1){
											$custom_height = 433;
												$custom_width = '100%';
												$url = parse_url($post_video);?>
												 <div class="cs-gal-video">
                                                 
                                                 <?php
												if($url['host'] == $_SERVER["SERVER_NAME"]){
												?>
												<script>
													jQuery('audio,video').mediaelementplayer({
														sfeatures: ['playpause']
													});
												</script>
													<video width="<?php echo $custom_width;?>" class="mejs-wmp" height="<?php echo $custom_height;?>" src="<?php echo $post_video ?>" poster="<?php  echo $image_full_url; ?>" controls="controls" preload="none"></video>
												<?php
												}else{
													?>
                                                    <?php
													echo wp_oembed_get($post_video,array('height'=>$custom_height));
												}?>
												</div>
												<?php }?>                          
                                                <div class="slide-caption">
                                                    <?php if($title <> '' and $cs_node->cs_gal_images_title == "Yes"){?><h2><?php echo $title;?></h2><?php }?>
                                                    <?php 
                                                    if($use_image_as==1){
                                                      echo '<span class="gallery_stack_element"> <i class="fa fa-play fa-stack-1x fa-inverse"></i> <i class="fa fa-times-circle-o fa-stack-1x fa-inverse"></i>
                                                            </span>';
                                                      }
                                                    ?>
                                                </div>
                                            </div>
                                            
                                            <?php }}?>
                                           
                                            
                                        </div>
                                    </div>
                                </div>
                                <!-- Banner Thumb Area -->
                                    <div id="thumbarea">
                                            <div id="carousearea" class="swiper-container mc-control">
                                                <div class="swiper-wrapper">
                                                <?php 
                                                if ( $cs_meta_gallery_options <> "" ) {
                                                    for ( $i = $limit_start; $i < $limit_end; $i++ ) {
                                                        $path = $cs_xmlObject->gallery[$i]->path;
                                                        $title = $cs_xmlObject->gallery[$i]->title;
                                                        $social_network = $cs_xmlObject->gallery[$i]->social_network;
                                                        $use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;
                                                        $video_code = $cs_xmlObject->gallery[$i]->video_code;
                                                        $link_url = $cs_xmlObject->gallery[$i]->link_url;
                                                        $image_full_url = cs_attachment_image_src($path, 150, 150);
                                                        ?>
                                                        <div class="swiper-slide">
                                                            <img src="<?php echo $image_full_url;?>" alt="">
                                                        </div>
                                                        
                                                 <?php }}?>
                                                </div>
                                            </div>
                                        </div>
                                <!-- Banner Thumb Area Close -->
                            </div>
                        </div>
		
		
		
		<?php } else if($cs_node->layout == "cs-banner-gallery"){
				cs_enqueue_swiper();
				cs_enqueue_slideshowify();
		?>
        <div class="banner">
            <script>
            jQuery(document).ready(function($) {
                cs_swipe_gallery();
            });
            </script>
            <div id="bannerwrapper" class="cs_fullwidth_banner <?php if($cs_node->layout == "cs-banner-thumb-gallery"){echo ' cs_thumbview_banner';}?>">
                <div id="bannermainslider">
                    <div class="caption-area-slider">
                        <span class="swipe-left"> <em class="fa fa-angle-left"></em>
                        </span>
                        <span class="swipe-right"> <em class="fa fa-angle-right"></em>
                        </span>
                    </div>
                    <div class="swiper-container banner-slides">
                        <div class="swiper-wrapper">
                        	<?php 
							
							if ( $cs_meta_gallery_options <> "" ) {
								for ( $i = $limit_start; $i < $limit_end; $i++ ) {
									$path = $cs_xmlObject->gallery[$i]->path;
									$title = $cs_xmlObject->gallery[$i]->title;
									$social_network = $cs_xmlObject->gallery[$i]->social_network;
									$use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;
									$post_video = $cs_xmlObject->gallery[$i]->video_code;
									$link_url = $cs_xmlObject->gallery[$i]->link_url;
									$image_full_url = cs_attachment_image_src($path, 0, 0);
									$video_slide_class = '';
									if($use_image_as==1){
										$video_slide_class = 'video-slide';
									}
										?>
                                        <div class="swiper-slide <?php echo $video_slide_class;?>">
                                            <img src="<?php echo $image_full_url; ?>" alt="<?php echo $title; ?>" data-alt="<?php echo $title; ?>"> 
                                            <?php 
											if($use_image_as==1){
											$custom_height = 433;
												$custom_width = '100%';
												$url = parse_url($post_video);
												 echo '<div class="cs-gal-video">';
												if($url['host'] == $_SERVER["SERVER_NAME"]){
												?>
												<script>
													jQuery('audio,video').mediaelementplayer({
														sfeatures: ['playpause']
													});
												</script>
													<video width="<?php echo $custom_width;?>" class="mejs-wmp" height="<?php echo $custom_height;?>" src="<?php echo $post_video ?>" poster="<?php  echo $image_full_url; ?>" controls="controls" preload="none"></video>
												<?php
												}else{
												  echo wp_oembed_get($post_video,array('height'=>$custom_height));
												}
												echo '</div';
												}
												?>
                                                <div class="slide-caption">
                                                    <?php if($title <> '' and $cs_node->cs_gal_images_title == "Yes"){?><h2><?php echo $title;?></h2><?php }?>
                                                    <?php 
                                                    if($use_image_as==1){
                                                      echo '<span class="gallery_stack_element"> <i class="fa fa-play fa-stack-1x fa-inverse"></i> <i class="fa fa-times-circle-o fa-stack-1x fa-inverse"></i>
                                                            </span>';
                                                      }elseif($use_image_as==2){
                                                          echo '<span class="gallery_stack_element"> <i class="fa fa-play fa-stack-1x fa-inverse"></i> <i class="fa fa-times-circle-o fa-stack-1x fa-inverse"></i></span>';	
                                                      }
                                                    ?>
                                                    
                                                </div>
                                            </div>
                                        <?php }}?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php 
	} else {
	if($cs_node->layout == "cs-mass-gallery"){
	cs_enqueue_masonry_style_script();
	?>
      <script>
		jQuery(document).ready(function($) {
			gallery_mas();
		});
	</script>
    <div class="gallery">
    <div id="gallery" class="lightbox">
	<?php
	}
	else{
	?>
    <div class="gallery <?php echo $cs_node->layout; ?>">
        <div class="lightbox">
    <?php
	}
        if ( $cs_meta_gallery_options <> "" ) {
            for ( $i = $limit_start; $i < $limit_end; $i++ ) {
                $path = $cs_xmlObject->gallery[$i]->path;
                $title = $cs_xmlObject->gallery[$i]->title;
                $social_network = $cs_xmlObject->gallery[$i]->social_network;
                $use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;
                $video_code = $cs_xmlObject->gallery[$i]->video_code;
                $link_url = $cs_xmlObject->gallery[$i]->link_url;
                
				if($cs_node->layout == "cs-mass-gallery"){
					$image_url = cs_attachment_image_src($path, 0, 0);
				}
				else if($cs_node->layout == "cs-thumb-gallery"){
					$image_url = cs_attachment_image_src($path, 150, 150);
				}
				else{
					$image_url = cs_attachment_image_src($path, 297, 224);
				}
				$image_full_url = cs_attachment_image_src($path, 0, 0);
                
				if($cs_node->layout == "cs-mass-gallery"){
				?>
                <div class="box">
                <?php
				}
				?>
                <article>
                    <figure>
                    	 <?php if($cs_node->layout == 'cs-thumb-gallery'){?>
                        			 <a data-title="<?php if ( $cs_node->cs_gal_images_title == "Yes" ) { echo $title;}?>" href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_full_url;?>"  target="<?php if($use_image_as==2) echo '_blank'; else echo '_self';  ?>" data-rel="<?php if($use_image_as==1)echo "prettyPhoto";  elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>" ><img src="<?php echo $image_url; ?>" alt="<?php echo $title; ?>" data-alt="<?php echo $title; ?>">
                                    </a>
                        
                        
                        <?php } else {?>
                        <a href="#"><img src="<?php echo $image_url; ?>" alt="<?php echo $title; ?>" data-alt="<?php echo $title; ?>"></a>
                       <?php }?>
                        <figcaption>
                            <a data-title="<?php if ( $cs_node->cs_gal_images_title == "Yes" ) { echo $title;}?>" href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_full_url;?>"  target="<?php if($use_image_as==2) echo '_blank'; else echo '_self';?>" data-rel="<?php if($use_image_as==1)echo "prettyPhoto";  elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>" > 
                            
                                <?php 
								  if($use_image_as==1){
									  echo '<i class="fa fa-play hovicon effect-1 sub-b"></i>';
								  }elseif($use_image_as==2){
									  echo '<i class="fa fa-link hovicon effect-1 sub-b"></i>';	
								  }else{
									  echo '<i class="fa fa-plus hovicon effect-1 sub-b"></i>';
								  }
								?>
                            </a>
                          <?php   if($title <> "" and $cs_node->cs_gal_images_title == "Yes"){?><div class="gallery-title"><?php echo $title; ?></div><?php }?>
                        </figcaption>
                    </figure>
                </article>
                <?php
				if($cs_node->layout == "cs-mass-gallery"){
				echo "</div>";
				}
				?>
                <?php
            }
        }
        ?>
		</div>
	</div>
   <?php $qrystr = '';
		if ( $cs_node->pagination == "Show Pagination" and $count_post > $cs_node->media_per_page and $cs_node->media_per_page > 0 ) {
			if ( isset($_GET['page_id']) )  $qrystr = "&page_id=".$_GET['page_id'];
				echo cs_pagination($count_post, $cs_node->media_per_page,$qrystr);
		}
     }?>