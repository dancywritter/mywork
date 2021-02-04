 <?php
 	global $cs_node,$post,$cs_theme_option, $cs_blog_large_layout; 
 	cs_enqueue_masonry_style_script();
	cs_enqueue_flexslider();
	cs_enqueue_text_rotator_script();
	$no_image ='';
	if($cs_node->cs_home_view_option=='home_video'){
		if($cs_node->cs_home_v2_captions == ''){$cs_node->cs_home_v2_captions = 'no-catpion';}
		?>
		<div class="wrapper-banner-home-v2 wrapper-banner-home-main <?php echo ' cs-home-option'.$cs_node->cs_home_v2_captions;?>">
        <?php
		if(isset($cs_node->cs_home_v2_video) && $cs_node->cs_home_v2_video <> ''){
			
			if(cs_videoType($cs_node->cs_home_v2_video)=='vimeo'){
				if($cs_node->cs_home_v2_video_mute == 'Yes'){
					$video_volume = '0';
				} else {
					$video_volume = '60';
				}
			?>
			<div id="videowrapper" style="opacity:0">
				<span class="pattrenbg"></span>
<iframe id="fullplayer" class="vimeo-player" src="http://player.vimeo.com/video/<?php echo cs_parse_vimeo($cs_node->cs_home_v2_video);?>?api=1&title=0&byline=0&portrait=0&playbar=0&loop=1&player_id=fullplayer" width="100%" height="100%" webkitAllowFullScreen mozallowfullscreen allowFullScreen="true"></iframe>
		</div>
 	
 	<script src="http://a.vimeocdn.com/js/froogaloop2.min.js"></script> 
		<script>

		jQuery(document).ready(function($) {
			jQuery(window).load(function() {
				jQuery('iframe.vimeo-player').each(function(){
					jQuery("#videowrapper").css({
						"opacity":"1"
					})
			$f(this).addEvent('ready', ready);

			});
			});
		// Enable the API on each Vimeo video
			jQuery(".flexslider").flexslider({
				slideshowSpeed:2000
			});
			resizevideo ();
			var ab = jQuery(window).height();
			var ah = jQuery(window).width();
			jQuery(".wrapper-banner-home-main") .height(ab)
			jQuery(".wrapper-banner-home-main") .width(ah)
			jQuery(window).resize(function() {
			var ab = jQuery(window).height();
			var ah = jQuery(window).width();
			resizevideo ();
			jQuery(".wrapper-banner-home-main") .width(ah)	
			jQuery(".wrapper-banner-home-main") .height(ab)
			});
		});
		function ready(player_id){
		  $f(player_id).api('setVolume',<?php echo $video_volume;?>);
		    $f(player_id).api('play');
		}


		</script>
        <?php } else if(cs_videoType($cs_node->cs_home_v2_video)=='youtube'){
			if($cs_node->cs_home_v2_video_mute == 'Yes'){
					$video_volume = 'true';
				} else {
					$video_volume = 'false';
				}
			
			?>
			
			<div id="videowrapper" style="opacity:1">
				<video width="100%" height="100%" id="player1" preload="none" autoplay="true" loop="true" >
					<source type="video/youtube" src="http://www.youtube.com/watch?v=<?php echo cs_parse_yturl($cs_node->cs_home_v2_video);?>"  />
				</video>
				<span class="pattrenbg"></span>
			</div>
			<script> 
				jQuery(document).ready(function($) {
			 		// declare object for video
					jQuery('#player1').mediaelementplayer({
					// shows debug errors on screen
						success: function (mediaElement, domObject) { 
							mediaElement.addEventListener('play', function (e) {
							mediaElement.setMuted(<?php echo $video_volume;?>)
						}, true);
						mediaElement.addEventListener('ended', function (e) {
							mediaElement.play()
						}, true);
						}
						
					});
			 		resizevideo ()
			 	});
			 function resizevideo () {
				jQuery("#videowrapper").each(function(index, el) {
				var windowW = jQuery(window).width();
				var windowH = jQuery(window).height();
				var mediaAspect = 16/9;
				var vidEl  = jQuery(this).find("video")
				var embEl  = jQuery(this).find("iframe")
				var windowAspect = windowW/windowH;
				if (windowAspect < mediaAspect) {
                // taller
                     jQuery(this)
                        .width(windowH*mediaAspect)
                        .height(windowH);
                    jQuery(vidEl)
                        .css('top',0)
                        .css('left',-(windowH*mediaAspect-windowW)/2)
                        .css('height',windowH);
                        jQuery(embEl)
                        .css('top',0)
                        .css('left',-(windowH*mediaAspect-windowW)/2)
                        .css('height',windowH);
            	 } else {
                // wider
                     jQuery(this)
                        .width(windowW)
                        .height(windowW/mediaAspect);
                    jQuery(vidEl)
                        .css('top',-(windowW/mediaAspect-windowH)/2)
                        .css('left',0)
                        .css('height',windowW/mediaAspect);
                    jQuery(embEl)
                        .css('top',-(windowW/mediaAspect-windowH)/2)
                        .css('left',0)
                        .css('height',windowW/mediaAspect);    
                  
           			 }
                    });       
                 }
			</script>
		<?php }?>	
        <div class="wrapper-banner-home">
          <?php if($cs_node->cs_home_v2_text_rotator <> ''){
			  if(!isset($cs_node->cs_home_v2_text_rotator_style)){
			  		$cs_node->cs_home_v2_text_rotator_style  = 'fade';
			  } 
			  
			  ?>
              <script>
           		jQuery(document).ready(function($){
			   		$(".cs-rotation-text .cs-rotate").textrotator({
					animation: "<?php echo $cs_node->cs_home_v2_text_rotator_style;?>",
					speed: 1000
				  });
				});	  
			</script>
          <h1 class="cs-rotation-text"><span class="cs-rotate rotate"><?php echo $cs_node->cs_home_v2_text_rotator;?></span></h1><?php }?>
           <?php if($cs_node->cs_home_v2_text <> ''){?> <h3><?php echo $cs_node->cs_home_v2_text;?></h3><?php }?>
           
            <?php	} ?>
           <script>
				jQuery(document).ready(function($) {
					jQuery(".flexslider").flexslider({
						slideshowSpeed:2000
					});
					var ab = jQuery(window).height();
					var ah = jQuery(window).width();
					jQuery(".wrapper-banner-home-main") .height(ab);
					jQuery(".wrapper-banner-home-main") .width(ah)
					jQuery(window).resize(function() {
						var ab = jQuery(window).height();
						var ah = jQuery(window).width();
						jQuery(".wrapper-banner-home-main") .height(ab);
						jQuery(".wrapper-banner-home-main") .width(ah)
					});
				});
				</script>
			 <div class="flexslider">
			 	<ul class="slides">
				 <?php
                    if ( !isset($cs_node->cs_home_v2_blog_num_post) || empty($cs_node->cs_home_v2_blog_num_post) || $cs_node->cs_home_v2_blog_num_post<0 ) {
                         $cs_node->cs_home_v2_blog_num_post = -1; 
                    }
                    if (empty($_GET['page_id_all'])) $_GET['page_id_all'] = 1;
                     if(!empty($cs_node->cs_home_blog_cat)){
                        $args = array('posts_per_page' => "$cs_node->cs_home_num_post", 'paged' => $_GET['page_id_all'], 'category_name' => "$cs_node->cs_home_blog_cat");
                        $custom_query = new WP_Query($args);
                        while ($custom_query->have_posts()) : $custom_query->the_post();
                    ?>	
                        <li>
                            <h1><?php the_title();?></h1>
                            <span class="btnreadmore2 bgcolr"><a href="<?php the_permalink();?>" ><i class="fa fa-angle-right fa-1x"></i></a></span>	
                        </li>
                        <?php
                        endwhile;
                    }
                ?>
				</ul>
        	</div>
         </div>
    </div>
	<?php
	} elseif($cs_node->cs_home_view_option=='home_view_gallery'){
		if($cs_node->cs_home_v5_captions == ''){$cs_node->cs_home_v5_captions = 'no-catpion';}
		echo '<div class="wrapper-banner-home-v5 wrapper-banner-home-main cs-home-option'.$cs_node->cs_home_v5_captions.'">';
				cs_enqueue_swiper();
				cs_enqueue_slideshowify();
					$count_post =0;
 				?>
         	<script>
				jQuery(document).ready(function($) {
					jQuery(".flexslider").flexslider({
						slideshowSpeed:2000
					});
					var ab = jQuery(window).height();
					var ah = jQuery(window).width();
					jQuery(".wrapper-banner-home-main") .height(ab);
					jQuery(".home-gallery-page-v5") .height(ab);
					jQuery(".wrapper-banner-home-main") .width(ah)
					jQuery(window).resize(function() {
						var ab = jQuery(window).height();
						var ah = jQuery(window).width();
						jQuery(".home-gallery-page-v5") .height(ab);
						jQuery(".wrapper-banner-home-main") .height(ab);
						jQuery(".wrapper-banner-home-main") .width(ah)
					});
				});
				</script>
          <div class="wrapper-banner-home">
          <?php if($cs_node->cs_home_v5_text_rotator <> ''){
			  if(!isset($cs_node->cs_home_v5_text_rotator_style)){
			  		$cs_node->cs_home_v2_text_rotator_style  = 'fade';
			  } 
			  
			  ?>
          <script>
           jQuery(document).ready(function($){
			   $(".cs-rotation-text .cs-rotate").textrotator({
					animation: "<?php echo $cs_node->cs_home_v5_text_rotator_style;?>",
					speed: 1000
				  });
			});	  
			</script>
          <h1 class="cs-rotation-text"><span class="cs-rotate rotate"><?php echo $cs_node->cs_home_v5_text_rotator;?></span></h1><?php }?>
          <?php if($cs_node->cs_home_v5_text <> ''){?><h3><?php echo $cs_node->cs_home_v5_text;?></h3><?php }?>
			 <div class="flexslider">
			 	<ul class="slides">
			 	<?php						   
					if ( !isset($cs_node->cs_home_num_post) || empty($cs_node->cs_home_num_post) || $cs_node->cs_home_num_post<0 ) { $cs_node->cs_home_num_post = -1; }
 				if (empty($_GET['page_id_all'])) $_GET['page_id_all'] = 1;

				if(!empty($cs_node->cs_home_blog_cat)){
                    $args = array('posts_per_page' => "$cs_node->cs_home_num_post", 'paged' => $_GET['page_id_all'], 'category_name' => "$cs_node->cs_home_blog_cat");
                
					$custom_query = new WP_Query($args);
						while ($custom_query->have_posts()) : $custom_query->the_post();
					?>	<li>
                            <h1><a href="<?php the_permalink();?>" class="colrhover"><?php the_title();?></a></h1>
                            <span class="btnreadmore2 bgcolr"><a href="<?php the_permalink();?>" class="colrhover"><i class="fa fa-angle-right fa-1x"></i></a></span>	
                        </li>
						<?php
						endwhile;
					}
 		echo '</ul>
			</div> 
			</div>
		</div>';
	} else {
		if($cs_node->cs_home_v4_captions == ''){$cs_node->cs_home_v4_captions = 'no-catpion';}
		cs_enqueue_bnggallery_script();
		$slider_layout = '';
		echo '<div class="wrapper-banner-home-v4 wrapper-banner-home-main '.$cs_node->cs_home_view_option.' cs-home-option'.$cs_node->cs_home_v4_captions.'">';
		if($cs_node->cs_home_view_option == 'big-image-zoom-home'){
			$slider_layout = 'zoomBlur';
		} elseif($cs_node->cs_home_view_option == 'fade-slider-home'){
			$slider_layout = 'blur';
		} elseif($cs_node->cs_home_view_option == 'half-layout-home'){
			$slider_layout = 'blur';
		} elseif($cs_node->cs_home_view_option == 'custom-home'){
			$slider_layout = 'slideLeft';
		} else {
			$slider_layout = 'blur';
		}
		$imaages_array = array();
		$imaages_string = '';
		if(!empty($cs_node->cs_home_v4_slider)){
			
			// slider slug to id start
				$args=array(
				  'name' => $cs_node->cs_home_v4_slider,
				  'post_type' => 'cs_slider',
				  'post_status' => 'publish',
				  'showposts' => 1,
				);
				$get_posts = get_posts($args);
				if($get_posts){
					$slider_id = $get_posts[0]->ID;
					$cs_meta_slider_options = get_post_meta($slider_id, "cs_meta_slider_options", true); 
						$cs_xmlObject_flex = new SimpleXMLElement($cs_meta_slider_options);
					foreach ( $cs_xmlObject_flex->children() as $as_node ){
 						$image_url = cs_attachment_image_src($as_node->path,0,0); 
						if($image_url <> ''){
							$imaages_string .='"'.$image_url.'",';
						}
					}
				}
		} else {
			echo "Please Select Slider";
		}
		?>
       <script type="text/javascript">

    		jQuery(document).ready(function($){
				$.mbBgndGallery.buildGallery({
					containment:"body",
					timer:3000,
					effTimer:1000,
					grayScale:false,
					shuffle:true,
					preserveWidth:false,
					effect:"<?php echo $slider_layout;?>",
					images:[
						<?php echo $imaages_string;?>
					]
				});
		});
	</script> 
          <div class="wrapper-banner-home">
         <?php if($cs_node->cs_home_v4_text_rotator <> ''){
			  if(!isset($cs_node->cs_home_v4_text_rotator_style)){
			  		$cs_node->cs_home_v4_text_rotator_style  = 'fade';
			  } 
			  
			  ?>
          <script>
           jQuery(document).ready(function($){
			   $(".cs-rotation-text .cs-rotate").textrotator({
					animation: "<?php echo $cs_node->cs_home_v4_text_rotator_style;?>",
					speed: 1000
				  });
			});	  
			</script>
          <h1 class="cs-rotation-text"><span class="cs-rotate rotate"><?php echo $cs_node->cs_home_v4_text_rotator;?></span></h1><?php }?>
          <?php if($cs_node->cs_home_v4_text <> ''){?><h3><?php echo $cs_node->cs_home_v4_text;?></h3><?php }?>
             <script>
				jQuery(document).ready(function($) {
					jQuery(".flexslider").flexslider({
						slideshowSpeed:2000
					});
					var ab = jQuery(window).height();
					var ah = jQuery(window).width();
					jQuery(".wrapper-banner-home-main") .height(ab)
					jQuery(".wrapper-banner-home-main") .width(ah)
					jQuery(window).resize(function() {
						var ab = jQuery(window).height();
						var ah = jQuery(window).width();
						jQuery(".wrapper-banner-home-main") .width(ah)	
						jQuery(".wrapper-banner-home-main") .height(ab)
					});
				});
				</script>
			 <div class="flexslider">
			 	<ul class="slides">
			 	<?php
				if ( !isset($cs_node->cs_home_num_post) || empty($cs_node->cs_home_num_post) || $cs_node->cs_home_num_post<0 ) { $cs_node->cs_home_num_post = -1; }
 				if (empty($_GET['page_id_all'])) $_GET['page_id_all'] = 1;

				if(!empty($cs_node->cs_home_blog_cat)){
                    $args = array('posts_per_page' => "$cs_node->cs_home_num_post", 'paged' => $_GET['page_id_all'], 'category_name' => "$cs_node->cs_home_blog_cat");
                
                $custom_query = new WP_Query($args);
                    while ($custom_query->have_posts()) : $custom_query->the_post();
                ?>	<li>
                    	<h1><a href="<?php the_permalink();?>" class="colrhover"><?php the_title();?></a></h1>
                    	<span class="btnreadmore2 bgcolr"><a href="<?php the_permalink();?>" class="colrhover"><i class="fa fa-angle-right fa-1x"></i></a></span>	
                    </li>
                    <?php
                    endwhile;
				}
		echo '</ul>
        </div>
        </div>
		</div>';
	}