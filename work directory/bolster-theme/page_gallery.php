<?php
	cs_enqueue_masonry_style_script();
	cs_enqueue_gallery_style_script();
	
	global $cs_node,$counter_node;
  	if ( !isset($cs_node->media_per_page) || empty($cs_node->media_per_page) || $cs_node->media_per_page<0) { $cs_node->media_per_page = -1; } else if($cs_node->media_per_page>0 && $cs_node->media_per_page<40){ $cs_node->media_per_page = 40;}
	if($cs_node->cs_images_per_gallery > 0){
		$cs_node->media_per_page = $cs_node->cs_images_per_gallery;
		
	}
 	$count_post = 0;
	$cs_fullheight = '';
	if ($cs_node->header_title ==  '' ) {
		$cs_fullheight = 'cs_fullheight';
	} 
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
	?>
    <?php if($cs_node->layout != 'gallery_full_page' && $cs_node->media_per_page <> '-1'){?>
	<script type="text/javascript">
   jQuery(document).ready(function() {
     gallery_load_more_js(<?php echo $cs_node->media_per_page; ?>, '<?php echo $cs_node->layout; ?>', '<?php echo $count_post;?>', '<?php echo $gal_album_db; ?>', '<?php echo $cs_node->desc;?>', '<?php echo home_url() ?>','<?php echo get_template_directory_uri() ?>','<?php echo $cs_node->thumb_space; ?>');
     });
        </script>
        <?php } ?>
        <script type="text/javascript">
        jQuery(document).ready(function($) {
			LoadedItem ("gallerymas article");
		   cs_masonary_callback('gallerymas')
        });
            jQuery(window).load(function() {
                //alert("test")
				jQuery("body").trigger("resize");
            });
		</script>
	<div style="padding-left:<?php echo $gal_margin_left; ?>px; height:100%; display: inline-block;" class="webkit">
    <?php if($cs_node->layout == 'gallery_masonry_view'){?>
        	<div class="main-wrapp gallery <?php echo $cs_node->layout; ?>">
		<div class="latest-gallery-wrapper inline-item">
    	<?php if ($cs_node->header_title <>  '' ) {?>
    		<header class="section-header">
        		<h2 class="section-title cs-heading-color"><?php echo $cs_node->header_title; ?></h2>
        	</header>
			<div class="clear"></div>
   	 	<?php  } ?>
		<div class="events-photo gallery_load cs-mas-view <?php echo $cs_fullheight; ?>">
		<div class="lightbox gallerymas inline-item">
			<div id="container">
            <?php
			
            if ( $cs_meta_gallery_options <> "" ) {
                for ( $i = $limit_start; $i < $limit_end; $i++ ) {
                    $path = $cs_xmlObject->gallery[$i]->path;
                    $title = $cs_xmlObject->gallery[$i]->title;
                    $description = $cs_xmlObject->gallery[$i]->description;
                    $social_network = $cs_xmlObject->gallery[$i]->social_network;
                    $use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;
                    $video_code = $cs_xmlObject->gallery[$i]->video_code;
                    $link_url = $cs_xmlObject->gallery[$i]->link_url;
 					$image_url = cs_attachment_image_src($path, 0, 0);
 					?>
					<article style="margin:0 <?php echo $cs_node->thumb_space; ?>px <?php echo $cs_node->thumb_space;?>px 0;">
						<figure>
							<img src="<?php echo $image_url; ?>" alt="<?php echo $title; ?>" data-alt="<?php echo $title; ?>">
                            
							<figcaption>
								<a data-title="<?php if ( $cs_node->desc == "On" ) { echo $description;}?>" href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" target="<?php if($use_image_as==2) echo '_blank'; ?>" class="fa fa-stack btnhover" <?php if($use_image_as <> 2){ ?>data-rel="<?php if($use_image_as==1)echo "prettyPhoto"; elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>" <?php } ?> >
                                              <span class="plus-icon"></span>
                                            </a>
							</figcaption>
                           </figure>
					</article>
                    <?php
                }
            }
            ?>
			</div>
		</div>
		</div>
        </div>
        </div>
		<?php
		}else if($cs_node->layout == 'gallery_full_page'){
			cs_enqueue_swiper_script();
		?>
        <div id="gallertwowrapp" class="<?php if($cs_node->cs_gal_image_size =="full_width"){ echo 'fullwidth-slider';}else{ echo $cs_node->cs_gal_image_size; } ?>">
        <?php if($cs_node->cs_gal_show_pagination =="On" ){
				$cs_flag = '';
				if($cs_node->cs_gal_show_thumbnail =="On"){
					$cs_flag="cs_full_width_thumbnail";
				}
			
			 ?>
        	<div class="caption-area-slider <?php echo $cs_flag;?>">
                            <span class="swipe-left colrhover">
                                <em class="fa fa-angle-left"></em>
                            </span>
                            <span id="slider-counter">
                                <span id="current-slide-number" class="colr">1</span>
                                /
                                <span id="total-slider-slide"><?php echo $limit_end; ?></span>
                            </span>
                            <span class="swipe-right colrhover">
                                <em class="fa fa-angle-right"></em>
                            </span>
                        </div>
         <?php if($cs_node->cs_gal_image_size !="full_width"){ ?>
                    <span class="swipe-left colrhover"><em class="fa fa-angle-left"></em></span>
                    <span class="swipe-right colrhover"><em class="fa fa-angle-right"></em></span>
          <?php }
		  } ?>
                            <div class="swiper-container mc-posters" id="slider">
                                <div class="swiper-wrapper">
                                    
                                <?php
									$cs_video_list = '';
									if ( $cs_meta_gallery_options <> "" ) {
                                    	for ( $i = $limit_start; $i < $limit_end; $i++ ) {
											$path = $cs_xmlObject->gallery[$i]->path;
											$title = $cs_xmlObject->gallery[$i]->title;
											$description = $cs_xmlObject->gallery[$i]->description;
											$social_network = $cs_xmlObject->gallery[$i]->social_network;
											$use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;
											$video_code = $cs_xmlObject->gallery[$i]->video_code;
											$link_url = $cs_xmlObject->gallery[$i]->link_url;
											$image_url = cs_attachment_image_src($path, 0, 0);
											?>
                                            <div class="swiper-slide">
                                            	<img src="<?php echo $image_url; ?>" alt="<?php echo $title; ?>" data-alt="<?php echo $title; ?>">
                                                <?php if($use_image_as==1){ echo '<div class="cs-gal-video">'.wp_oembed_get($video_code).'</div>'; }?>
                                                <span class="gallery_stack_element">
                                         
													<?php 
														  if($use_image_as==1){
															  echo '<i class="fa fa-play-circle-o fa-stack-1x fa-inverse colr"></i>
															  <i class="fa fa-times-circle-o fa-stack-1x fa-inverse colr"></i>';
														  }elseif($use_image_as==2){
															  echo '<i class="fa fa-link fa-stack-1x fa-inverse"></i>';	
														  }
													  ?>
                                                    </span>
                                            </div>
									 <?php
										}
									}
									if($cs_video_list <> ''){
									?>
                                     <div id="jp_container_1" class="jp-video jp-video-fullwidth">
                                        <div class="jp-type-single">
                                            <div id="jquery_jplayer_1" class="jp-jplayer"></div>
                                            <div class="jp-gui">
                                                <ul class="jp-controls">
                                                    <li>
                                                        <a href="javascript:;" class="jp-play colr" tabindex="1">
                                                            <em class="fa fa-play"></em>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;" class="jp-pause colr" tabindex="1">
                                                            <em class="fa fa-pause"></em>
                                                        </a>
                                                    </li>
                                                </ul>

                                            </div>
                                            
                                        </div>
                                    </div>
                                    
 											
                                <?php } ?>
                                				
                                </div>
                            </div>
                            <?php if($cs_node->cs_gal_show_thumbnail =="On"){?>
                            <div class="swiper-thumb-container">    
                                    <span class="swipe-left-thumb colrhover"><em class="fa fa-angle-left"></em></span>
                                    <span class="swipe-right-thumb colrhover"><em class="fa fa-angle-right"></em></span>
                                <div class="swiper-container mc-control" id="carousearea">
                                    <div class="swiper-wrapper">
                                     <?php
    									if ( $cs_meta_gallery_options <> "" ) {
                                        	for ( $i = $limit_start; $i < $limit_end; $i++ ) {
    											$path = $cs_xmlObject->gallery[$i]->path;
    											$title = $cs_xmlObject->gallery[$i]->title;
    											$description = $cs_xmlObject->gallery[$i]->description;
    											$social_network = $cs_xmlObject->gallery[$i]->social_network;
    											$use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;
    											$video_code = $cs_xmlObject->gallery[$i]->video_code;
    											$link_url = $cs_xmlObject->gallery[$i]->link_url;
    											$image_url = cs_attachment_image_src($path, 150, 150);
    											?>
                                                <div class="swiper-slide">
    												<img src="<?php echo $image_url; ?>" alt="<?php echo $title; ?>" data-alt="<?php echo $title; ?>">
    											</div>
                                          <?php
    										}
    									}
    									?>  
    					            </div>
                                </div>
                            </div>
                            <?php 
							}?>
							<script>
                            	jQuery(document).ready(function($) {
                            		cs_swipe_gallery();
                            	});
							</script>
               	<!-- Gallery two close -->
              </div>

        <?php
		
		} else if($cs_node->layout == 'gallery_squre_view'){
 			?>
            <script type="text/javascript">
			  jQuery(document).ready(function() {
				  LoadedItem ("gallerymas article");
 				  resizegallery()
			  });
			  jQuery(window).load(function($) {
 				  resizegallery()
			  });
				  jQuery(window).resize(function($) {
				  resizegallery()
			  });
		  </script>
            
			<div class="latest-gallery-wrapper inline-item <?php echo $cs_node->layout; ?>">
				<?php if ($cs_node->header_title <>  '' ) { ?>
                    <header class="section-header">
                        <h2 class="section-title cs-heading-color"><?php echo $cs_node->header_title; ?></h2>
                    </header>
                 <?php }?>
                  <div class="events-photo gallery_load cs-mas-view <?php echo $cs_fullheight; ?>">
                    <div class="lightbox gallerymas inline-item">
                        <div id="container">
                    <?php
                    if ( $cs_meta_gallery_options <> "" ) {
                        for ( $i = $limit_start; $i < $limit_end; $i++ ) {
                            $path = $cs_xmlObject->gallery[$i]->path;
                            $title = $cs_xmlObject->gallery[$i]->title;
                            $description = $cs_xmlObject->gallery[$i]->description;
                            $social_network = $cs_xmlObject->gallery[$i]->social_network;
                            $use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;
                            $video_code = $cs_xmlObject->gallery[$i]->video_code;
                            $link_url = $cs_xmlObject->gallery[$i]->link_url;
                            $image_url = cs_attachment_image_src($path,270,270);
                            $image_url_full = cs_attachment_image_src($path, 0, 0);
                            if($image_url <> ''){
                        ?>
                             <article style="margin:0 <?php echo $cs_node->thumb_space; ?>px <?php echo $cs_node->thumb_space;?>px 0;">
                                    <figure>
                                        <img src="<?php echo $image_url; ?>" alt="<?php echo $title; ?>" data-alt="<?php echo $title; ?>">
                                        
                                        <figcaption>
                                        	<a data-title="<?php if ( $cs_node->desc == "On" ) { echo $description;}?>" href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" target="<?php if($use_image_as==2) echo '_blank'; ?>" class="fa fa-stack btnhover" <?php if($use_image_as <> 2){ ?>data-rel="<?php if($use_image_as==1)echo "prettyPhoto"; elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>" <?php } ?> >
                                              <span class="plus-icon"></span>
                                            </a>
                                        </figcaption>
                                    </figure>
                                </article>
                      <?php }}}?>
                      </div>
                   </div>
                 </div>
               </div>
		<?php
		} else {
		?>
        
        	<script type="text/javascript">
			  jQuery(document).ready(function() {
				  LoadedItem ("gallerymas article");
 				  resizegallerygrid()
			  });
			  jQuery(window).load(function($) {
 				  resizegallerygrid()
			  });
				  jQuery(window).resize(function($) {
				  resizegallerygrid()
			  });
		  </script>  
			
            <div class="main-wrapp gallery <?php echo $cs_node->layout; ?>">
            <div class="latest-gallery-wrapper inline-item">
            <?php if ($cs_node->header_title <>  '' ) { ?>
                <header class="section-header">
                    <h2 class="section-title cs-heading-color"><?php echo $cs_node->header_title; ?></h2>
                </header>
                <div class="clear"></div>
            <?php  }?>
            <div class="events-photo gallery_load cs-mas-view <?php echo $cs_fullheight; ?>">
            <div class="lightbox gallerymas inline-item">
                <div id="container">
                <?php
				$image_url = '';
				$image_url_full = '';
                if ( $cs_meta_gallery_options <> "" ) {
                    for ( $i = $limit_start; $i < $limit_end; $i++ ) {
                        $path = $cs_xmlObject->gallery[$i]->path;
                        $title = $cs_xmlObject->gallery[$i]->title;
                        $description = $cs_xmlObject->gallery[$i]->description;
                        $social_network = $cs_xmlObject->gallery[$i]->social_network;
                        $use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;
                        $video_code = $cs_xmlObject->gallery[$i]->video_code;
                        $link_url = $cs_xmlObject->gallery[$i]->link_url;
                        $image_url = cs_attachment_image_src($path, 800, 450);
						$image_url_full = cs_attachment_image_src($path, 0, 0);
                        ?>
                        <article style="margin:0 <?php echo $cs_node->thumb_space; ?>px <?php echo $cs_node->thumb_space;?>px 0;">
                            <figure>
                                <img src="<?php echo $image_url; ?>" alt="<?php echo $title; ?>" data-alt="<?php echo $title; ?>">
                                
                                <figcaption>
                                    <a data-title="<?php if ( $cs_node->desc == "On" ) { echo $description;}?>" href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" target="<?php if($use_image_as==2) echo '_blank'; ?>" class="fa fa-stack btnhover" <?php if($use_image_as <> 2){ ?>data-rel="<?php if($use_image_as==1)echo "prettyPhoto"; elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>" <?php } ?> >
                                              <span class="plus-icon"></span>
                                            </a>
								</figcaption>
                            </figure>
                        </article>
                        <?php
							}
						}
						?>
                	</div>
            	</div>
        	</div>
        </div>
    </div>	
    <?php }	?>
 </div>