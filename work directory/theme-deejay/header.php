<?php
	global $px_theme_option, $px_page_builder, $px_meta_page, $px_node;
	$px_theme_option = get_option('px_theme_option');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
	<?php
	    bloginfo('name'); ?> | 
    <?php 
		if ( is_home() or is_front_page() ) { bloginfo('description'); }
		else { wp_title(''); }
    ?>
    </title>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
	<link rel="shortcut icon" href="<?php echo $px_theme_option['fav_icon'] ?>" />
    <!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<?php 
    	echo  htmlspecialchars_decode($px_theme_option['header_code']); 
	    if ( is_singular() && get_option( 'thread_comments' ) )
        	wp_enqueue_script( 'comment-reply' );  
         	wp_head(); 
    ?>
    </head>
	<body <?php body_class();?>>
	  <?php
	  	if (isset($px_theme_option['rtl_switcher']) &&  $px_theme_option['rtl_switcher'] == "on"){
			?>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
					px_rtl_menu();
				});
			</script>
			<?php
			} else {
				?>
				<script type="text/javascript">
                    jQuery(document).ready(function($) {
                       px_ltr_menu();
                    });
                </script>
                <?php
			}
	   
	  
              px_custom_styles();
			echo '<div class="page-background" id="background_section">';
			 		px_background_options();
			echo '</div>';

			$content_display_class = '';
			$content_display_width = '';
			$parallaxfullwidth = '';
			$galleryslider = '';
			if (is_page()) {
				$px_meta_page = px_meta_page('px_page_builder');
				if (count($px_meta_page) > 0) {
					$count_element = 0;
					foreach ( $px_meta_page->children() as $px_meta_page_eelemnt ) {
						if ( $px_meta_page_eelemnt->getName() == "blog" ) {
										
								$count_element++;
		
							}else if ( $px_meta_page_eelemnt->getName() == "gallery" ) {
								$count_element++;
							}else if ( $px_meta_page_eelemnt->getName() == "gallery_albums" ) {
								$parallaxfullwidth = 'parallaxfullwidth';
								$galleryslider = ' body-gallery-wrapp';
								$count_element++;
							}else if ( $px_meta_page_eelemnt->getName() == "map" ) {
								$count_element++;								
								
							}else if ( $px_meta_page_eelemnt->getName() == "album" ) {
								$count_element++;
								
							}else if ( $px_meta_page_eelemnt->getName() == "event" ) {
								
								$count_element++;
									
							}elseif($px_meta_page_eelemnt->getName() == "team"){
								$count_element++;
								
							}elseif($px_meta_page_eelemnt->getName() == "contact"){
							   $count_element++;
							   
							}elseif($px_meta_page_eelemnt->getName() == "column"){
								$count_element++;
							}
					}
					if( $px_meta_page->page_content <> "on"  && $count_element<1 ){
						$content_display_class = 'style="display: none;"';
						$content_display_width = 'style="width: 100%;"';
					}
				}
			}
        ?>
        <!-- Wrapper Start -->
          <!-- <svg xmlns="http://www.w3.org/2000/svg" version="1.1">
          <defs>
            <filter id="f1" x="0" y="0">
              <feGaussianBlur stdDeviation="5" />
            </filter>
          </defs>
        </svg> -->
 <div id="wrappermain-pix" class="wrapper pix-sticky-header<?php echo $galleryslider;?>">
	<header id="header">
            <a href="" class="btnheadertoggle"><span>Toggle</span></a>
            <div id="headerwrapp">
                <div class="logo">
                    <?php
						 if(isset($px_theme_option['logo']) && $px_theme_option['logo'] <> ''){
							  px_logo($px_theme_option['logo'], $px_theme_option['logo_width'], $px_theme_option['logo_height']);
						} else {
							echo '<a href="'.home_url().'">';
								bloginfo('name');
							echo '</a>';
						}
					?>
                </div>
                <!-- Navigation -->
                <div id="menus-wrapper">
                    <nav class="navigation">
                        <?php px_navigation('main-menu'); ?>
                    </nav>
                </div>
                <!-- Navigation Close -->
                <!-- Footer SEction --> </div>
            <div id="footer">
                <div class="pix-option-panel">
                    <ul>
                        <li>
                            <?php 
                              if(function_exists( 'is_woocommerce' ) && isset($px_theme_option['header_cart']) && $px_theme_option['header_cart'] == 'on'){
                                  px_woocommerce_header_cart();
                              }
                              ?>
                        </li>
                        <li>
                            <?php
                              if($px_theme_option['header_languages'] == 'on'){
                                  do_action('icl_language_selector');
                              }
                              ?>
                        </li>
                    </ul>
                </div>
                <?php 
					if($px_theme_option['header_social_icons'] == 'on'){
						px_social_network('false');
						
					}
				?>
             <?php if(isset($px_theme_option['px_music_album']) && $px_theme_option['px_music_album'] <> ''){
				 
				 $px_album = get_post_meta($px_theme_option['px_music_album'], "px_album", true);
				if ( $px_album <> "" ) {
					$px_xmlObject = new SimpleXMLElement($px_album);
				
				}
				$counter_load_tracks = count($px_xmlObject->track);
			 $playtracks = '';
			 if($counter_load_tracks >0){
				 px_enqueue_jplayer_script();
			 
 			 	 foreach ( $px_xmlObject->track as $track ){
					$filetype = wp_check_filetype($track->var_pb_album_track_mp3_url);
					if(isset($track->var_pb_album_track_mp3_url) && ($filetype['ext'] == 'mp3'|| $filetype['ext'] == 'oga')){
						$playtracks .= '{
									title:"'.$track->var_pb_album_track_title.'",
									artist:"'.$track->var_pb_album_speaker.'",
									dwnload: "'.$track->var_pb_album_track_mp3_url.'",
									dwnloadurl:"'.$track->var_pb_album_track_buy_mp3.'",
									mp3:"'.$track->var_pb_album_track_mp3_url.'",
									play:"'.$track->var_pb_album_track_mp3_url.'",
								},';
					}
			 	}
				 
				 
				 ?>
               			 <div class="audio-play-list fullwidth">
                    <div id="jquery_jplayer_1" class="jp-jplayer"></div>
                    <div id="jp_container_1" class="jp-audio">
                        <div class="jp-type-playlist">
                            <div class="jp-gui">
                                <div class="jp-gui jp-interface">
                                    <div class="jp-progress">
                                        <div class="jp-seek-bar">
                                            <div class="jp-play-bar pix-bgcolr"></div>
                                        </div>
                                    </div>
                                    <div class="jp-controls">
                                        <a href="javascript:;" class="jp-mute" tabindex="1" data-toggle="tooltip" data-placement="top" title="Mute"> <i class="fa fa-volume-up"></i>
                                        </a>
                                        <a href="javascript:;" class="jp-unmute" tabindex="1" data-toggle="tooltip" data-placement="top" title="unmute">
                                            <i class="fa fa-volume-off"></i>
                                        </a>
                                        <a href="javascript:;" class="jp-play" tabindex="1" data-toggle="tooltip" data-placement="top" title="Pause">
                                            <i class="fa fa-play"></i>
                                        </a>
                                        <a href="javascript:;" class="jp-pause" tabindex="1" data-toggle="tooltip" data-placement="top" title="Play">
                                            <i class="fa fa-pause"></i>
                                        </a>
                                        <a href="" class="jp-menu" data-toggle="tooltip" data-placement="top" title="Play list">
                                            <i class="fa fa-bars"></i>
                                        </a>

                                    </div>
                                </div>
                            </div>
                            <div class="jp-playlist" id="playlistarea">
                                <a href="" class="btnclose-playlist">
                                   
                                </a>
                                <h2>
                                    <i class="fa fa-bars"></i>
                                    Playlist
                                </h2>
                                <ul>
                                    <!-- The method Playlist.displayPlaylist() uses this unordered list -->
                                    <li></li>
                                </ul>
                            </div>

                            
                        </div>
                    </div>
                    <script>
                        jQuery(document).ready(function($) {
                            var myPlaylist2 = new jPlayerPlaylist({
                                jPlayer: "#jquery_jplayer_1",
                                cssSelectorAncestor: "#jp_container_1"
                            }, [
                                <?php echo $playtracks;?>
                            ], {
                            playlistOptions: {
							<?php if($px_theme_option['px_music_autoplay'] == 'on'){
								echo 'autoPlay: true,';
							}?>
                                enableRemoveControls: false
                            },
                            play: function () {
									jQuery(this).parents(".audio-play-list").find(".jp-playpause").removeClass("jp-pause-item")   
									jQuery(this).parents(".audio-play-list").find(".jp-playlist-current .jp-playpause").addClass("jp-pause-item")   
                                },
                            pause: function () {
                              jQuery(this).parents(".audio-play-list").find(".jp-playpause").removeClass("jp-pause-item")   
                            },
                                swfPath: "<?php echo get_template_directory_uri();?>/scripts/frontend/",
                                supplied: "oga, mp3",
                                wmode: "window",
                                smoothPlayBar: true,
                                keyEnabled: true
                        });
                   });
                </script>
                </div>
             <?php }
			 }?>
            </div>
            <!-- Footer SEction Close --> 
        </header>
    <div id="main" role="main" >
    	<?php 
			if(is_home()  || is_front_page()){
				if(isset($px_theme_option['blog_banner_category']) && $px_theme_option['blog_banner_category'] <> ''){
					px_enqueue_swiper_script();
					$bannerargs = array('posts_per_page' => $px_theme_option['banner_no_posts'], 'category_name' => $px_theme_option['blog_banner_category'], 'paged' => '1', 'post_status' => 'publish');
					$banner_query = new WP_Query($bannerargs);
			?>
                  <div id="banner">
                        <?php
                             if(isset($px_theme_option['main_logo']) && $px_theme_option['main_logo'] <> ''){
                                 echo '<div class="logo-large">';
								 ?>
                                 <a href="<?php  echo home_url(); ?>">
                                    <img src="<?php  echo $px_theme_option['main_logo']; ?>" alt="<?php  echo bloginfo('name'); ?>" />
                                </a>
								<?php 	
                                 echo '</div>';
                            } 
                        ?>
                    <div id="banner-background">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                            <?php 
								while ($banner_query->have_posts()) : $banner_query->the_post();
								$banner_url_full = px_get_post_img_src($post->ID, '' ,'');
							?>
                                <div class="swiper-slide" style="background-image: url('<?php echo $banner_url_full;?>');"></div>
                             <?php endwhile;?>   
                            </div>
                        </div>
                    </div>
                    <div class="pagination"></div>
                    <div id="banner-container">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                            <?php 
								while ($banner_query->have_posts()) : $banner_query->the_post();
							?>
                                <div class="swiper-slide">
                                    <div class="inner">
                                        <article>
                                            <h5>
                                                <a href="<?php the_permalink();?>">
                                                    <i class="fa fa-headphones"></i>
                                                </a>
                                            </h5>
                                            <h2 class="pix-post-title">
                                                <a href="<?php the_permalink();?>" class="pix-colrhvr"><?php the_title();?></a>
                                            </h2>
                                            <div class="pix-desc">
                                            	
                                                <p>
                                                	<?php  px_get_the_excerpt('154',false);?>
                                                </p>
                                                <?php echo '<a href="' . get_permalink() . '" class="btn">' . $px_theme_option['trans_read_more'] . '</a>';?>
                                            </div>
                                        </article>
                                    </div>
                                </div>
                              <?php endwhile;?>  
                            </div>
                        </div>
                    </div>
                    <script>
                       jQuery(document).ready(function($) {
                            galleryMain ();                
                        });
            </script>
                </div>
            <!-- Banner Ends -->
        	<?php
				}
			}
		?>
    	<div class="container" <?php echo $content_display_class;?>>
        	<div class="row">
            	<div class="col-md-12">
            		<div class="<?php if($parallaxfullwidth <> ''){ echo $parallaxfullwidth;} else {?> blog-parrallax pix-parrallax <?php }?>">
                	<?php 
						global $post;
						 if(is_single() || is_page()){
							$image_url = px_attachment_image_src( get_post_thumbnail_id($post->ID),0,0); 
							if($image_url <> ''){
								px_enqueue_parallax_script();
								?>
								<script>
								jQuery(document).ready(function($) {
									 px_parrallax_callback();
								});
								</script>
								<div style="background-image: url('<?php echo $image_url;?>');" data-stellar-background-ratio="0.1" class="parrallax-bg"></div>
						<?php }
						 }?>
                    <?php 
						if(!is_home()  || !is_front_page()){
							if(function_exists("is_shop") and is_shop()){
								$px_shop_id = woocommerce_get_page_id( 'shop' );
								echo "<header class='pix-heading-title'><h1 class=\"pix-page-title\">".get_the_title($px_shop_id)."</h1></header>";
							}else if(function_exists("is_shop") and !is_shop() and !is_single()){
								get_subheader_title();
							} else if(!is_single()){
								get_subheader_title();
							}
						}
					?>