<?php
	cs_enqueue_parallax_script();
?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery(".parallaxbg").parallax("50%",0.05);
  	parallaxfullwidth ();
});
</script>
<?php
 		global $cs_node, $post, $element_size_class, $counter_node, $cs_theme_option;
		$parallax_element_size = $cs_node->parallax_element_size;
		$parallax_element = $cs_node->parallax_element;
		$parallax_view = $cs_node->parallax_view;
		$parallax_height = $cs_node->parallax_height;
		$parallax_margin_top = $cs_node->parallax_margin_top;
		$parallax_margin_bottom = $cs_node->parallax_margin_bottom;
		$parallax_back_top = $cs_node->parallax_back_top;
 		// $counter = $post->ID . $count_node;
		if ($parallax_element == 'twitter') {
			
			if(isset($cs_node->parallax_twitter_profile) && !empty($cs_node->parallax_twitter_profile)){
				 $parallax_twitter_profile = $cs_node->parallax_twitter_profile;
			} else {
				$parallax_twitter_profile = '';
			}
			if(isset($cs_node->parallax_twitter_bgcolor) && !empty($cs_node->parallax_twitter_bgcolor)){
				$parallax_twitter_bgcolor = $cs_node->parallax_twitter_bgcolor;
			} else {
				$parallax_twitter_bgcolor = '';
			}
			if(isset($cs_node->parallax_twitter_num_tweets) && !empty($cs_node->parallax_twitter_num_tweets)){
				$parallax_twitter_num_tweets = $cs_node->parallax_twitter_num_tweets;
			} else {
				$parallax_twitter_num_tweets = '';
			}
			if(isset($cs_node->parallax_twitter_bgimg) && !empty($cs_node->parallax_twitter_bgimg)){
				$parallax_twitter_bgimg = $cs_node->parallax_twitter_bgimg;
			} else {
				$parallax_twitter_bgimg = '';
			}
			?>
            <?php cs_enqueue_flexslider_script(); ?>
            <script type="text/javascript">
			jQuery(window).load(function(){
				var speed = <?php echo $cs_theme_option['flex_animation_speed']; ?>; 
				var slidespeed = <?php echo $cs_theme_option['flex_pause_time']; ?>;
				jQuery('#flexslider<?php echo $counter_node; ?>').flexslider({
					animation: "<?php echo $cs_theme_option['flex_effect']; ?>", // fade
					slideshowSpeed:speed,
					animationSpeed:slidespeed
					
				});
			});
		</script>
        <div class="parallax-fullwidth fullwidth twitterarea <?php if(isset($parallax_view) && !empty($parallax_view)){ echo $parallax_view.'-width';} else { echo 'parallax-full-width';}?>"  style=" <?php if($parallax_twitter_bgimg <> '') { ?> background: url(<?php echo $parallax_twitter_bgimg; ?>) no-repeat center top fixed; <?php } if(isset($parallax_height) && !empty($parallax_height)){ ?> height: <?php echo $parallax_height ?>px; <?php }?>  margin-bottom:<?php echo $parallax_margin_bottom?>px; margin-top:<?php echo $parallax_margin_top?>px; <?php if(isset($parallax_twitter_bgcolor) && !empty($parallax_twitter_bgcolor)){ ?> background-color:<?php echo $parallax_twitter_bgcolor; } ?>">
                            <div class="container">
                                <div class="row">
                                <div id="flexslider<?php echo $counter_node; ?>">
                                <div class="flexslider">
                                    <ul class="slides">
                                    <?php
											if (strlen($parallax_twitter_profile) > 1) {
												$return = '';
												$response = '';
												$exclude_replies = '0';
				
												$include_rts = '0';
												$token = get_option('TWITTER_BEARER_TOKEN');
												if ($token && $parallax_twitter_profile) {
													$args = array(
														'httpversion' => '1.1',
														'blocking' => true,
														'headers' => array(
															'Authorization' => "Bearer $token"
														)
													);
													add_filter('https_ssl_verify', '__return_false');
													$api_url = "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=$parallax_twitter_profile&count=$parallax_twitter_num_tweets&exclude_replies=$exclude_replies&include_rts=$include_rts";
													$response = wp_remote_get($api_url, $args);
													//print_r($response);
													if (!is_wp_error($response) and $response <> "") {
														$tweets = json_decode($response['body']);
														foreach ($tweets as $i => $tweet) {
															$text = $tweet->{'text'};
															foreach ($tweet->{'entities'} as $type => $entity) {
																if ($type == 'urls') {
																	foreach ($entity as $j => $url) {
																		$update_with = '<a href="' . $url->{'url'} . '" target="_blank" title="' . $url->{'expanded_url'} . '">' . $url->{'display_url'} . '</a>';
																		$text = str_replace($url->{'url'}, $update_with, $text);
																	}
																} else if ($type == 'hashtags') {
																	foreach ($entity as $j => $hashtag) {
																		$update_with = '<a href="https://twitter.com/search?q=%23' . $hashtag->{'text'} . '&src=hash" target="_blank" title="' . $hashtag->{'text'} . '">#' . $hashtag->{'text'} . '</a>';
																		$text = str_replace('#' . $hashtag->{'text'}, $update_with, $text);
																	}
																} else if ($type == 'user_mentions') {
																	foreach ($entity as $j => $user) {
																		$update_with = '<a href="https://twitter.com/' . $user->{'screen_name'} . '" target="_blank" title="' . $user->{'name'} . '">@' . $user->{'screen_name'} . '</a>';
																		$text = str_replace('@' . $user->{'screen_name'}, $update_with, $text);
																	}
																}
															}
															$large_ts = time();
															$n = $large_ts - strtotime($tweet->{'created_at'});
															if ($n < (60)) {
																$posted = sprintf(__('%d seconds ago', 'rotatingtweets'), $n);
															} elseif ($n < (60 * 60)) {
																$minutes = round($n / 60);
																$posted = sprintf(_n('About a Minute Ago', '%d Minutes Ago', $minutes, 'rotatingtweets'), $minutes);
															} elseif ($n < (60 * 60 * 16)) {
																$hours = round($n / (60 * 60));
																$posted = sprintf(_n('About an Hour Ago', '%d Hours Ago', $hours, 'rotatingtweets'), $hours);
															} elseif ($n < (60 * 60 * 24)) {
																$hours = round($n / (60 * 60));
																$posted = sprintf(_n('About an Hour Ago', '%d Hours Ago', $hours, 'rotatingtweets'), $hours);
															} elseif ($n < (60 * 60 * 24 * 6.5)) {
																$days = round($n / (60 * 60 * 24));
																$posted = sprintf(_n('About a Day Ago', '%d Days Ago', $days, 'rotatingtweets'), $days);
															} elseif ($n < (60 * 60 * 24 * 7 * 3.5)) {
																$weeks = round($n / (60 * 60 * 24 * 7));
																$posted = sprintf(_n('About a Week Ago', '%d Weeks Ago', $weeks, 'rotatingtweets'), $weeks);
															} elseif ($n < (60 * 60 * 24 * 7 * 4 * 11.5)) {
																$months = round($n / (60 * 60 * 24 * 7 * 4));
																$posted = sprintf(_n('About a Month Ago', '%d Months Ago', $months, 'rotatingtweets'), $months);
															} elseif ($n >= (60 * 60 * 24 * 7 * 4 * 12)) {
																$years = round($n / (60 * 60 * 24 * 7 * 52));
																$posted = sprintf(_n('About a year Ago', '%d years Ago', $years, 'rotatingtweets'), $years);
															}
															$user = $tweet->{'user'};
															$return .= '<li><div class="iconarea float-left"><em class="fa fa-twitter fa-4x"></em></div>
															<div class="text">';
															$return .= "<h2>" . $text . "</h2>";
															$return .= '<p><a href="http://www.twitter.com/' . $parallax_twitter_profile . '" >' . $parallax_twitter_profile . '</a> said ';
															$return .= '<time datetime="' . $posted . '">"' . $posted . '"</time></p>';
															$return .= "</div></li>";
														}
				
														echo $return;
													}
												} else {
													if ($response <> "") {
														echo $response->errors['http_failure'][0];
													} else {
														echo "'._e('No results found.', 'Rocky').'";
													}
												}
												?>
										<?php
											} else {
												echo '<li><h4 class="heading-color">No User information given.</h4></li>';
											}
											?>
                                    		</ul>
                                    	</div>
                                    </div>
                                 </div>
                                 <?php if($parallax_back_top  == "Yes"){?><a class="gotop" id="gotop" href="#"><i class="fa fa-angle-double-up"></i></a> <?php } ?>
                            </div>
                         </div>
                <?php
				}
				elseif ($parallax_element == 'gallery') {
					if ( !isset($cs_node->album) or $cs_node->album == "" ) { $cs_node->album = ''; }
                    if ( !isset($cs_node->parallax_gallery_title) or $cs_node->parallax_gallery_title == "" ) { $cs_node->parallax_gallery_title = ''; }
				?>	
					<?php
					cs_enqueue_masonry_style_script();
					
					?>
                    <script type="text/javascript">
					jQuery(window).load(function() {
						cs_mas_gallery_script('containergallery');
						
					});
					</script>
					
					<?php
					global $cs_node,$counter_node;
					$count_post =0;
					cs_enqueue_gallery_style_script();
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
					if ( $cs_meta_gallery_options <> "" ) {
						?>
                        <div id="masonrygallery" class="fullwidth parallax-fullwidth lightbox <?php if(isset($parallax_view) && !empty($parallax_view)){ echo $parallax_view.'-width';} else { echo 'parallax-full-width';}?>" style=" <?php if(isset($parallax_height) && !empty($parallax_height)){ ?> height: <?php echo $parallax_height ?>px; <?php }?>  margin-bottom:<?php echo $parallax_margin_bottom?>px; margin-top:<?php echo $parallax_margin_top?>px;">
                        <?php if ( isset($cs_node->parallax_gallery_title) or $cs_node->parallax_gallery_title <> "" ){?>
							<header class="heading">
								<h2 class="section-title cs-heading-color"><?php echo $cs_node->parallax_gallery_title;?></h2>
								<?php if($parallax_back_top  == "Yes"){?><a href="#" class="btngotop"><em class="fa fa-angle-up"></em></a> <?php } ?>
							</header>
                            <?php }?>
							<div class="masnscroll">
								<div id="containergallery">
						<?php

						for ( $i = $limit_start; $i < $limit_end-1; $i++ ) {
							$path = $cs_xmlObject->gallery[$i]->path;
							$title = $cs_xmlObject->gallery[$i]->title;
							$description = $cs_xmlObject->gallery[$i]->description;
							$social_network = $cs_xmlObject->gallery[$i]->social_network;
							$use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;
							$video_code = $cs_xmlObject->gallery[$i]->video_code;
							$link_url = $cs_xmlObject->gallery[$i]->link_url;
							$image_url = cs_attachment_image_src($path, 270, 152);
							$image_url_full = cs_attachment_image_src($path, 0, 0);
							?>
							<!-- Masonry Gallery -->
							<figure>
								<img src="<?php  echo $image_url; ?>" alt="">
								<figcaption><a class="btnreadmore" data-title="<?php if ( $cs_node->desc == "On" ) { echo $description; }?>"  href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" target="<?php if($use_image_as==2) echo '_blank'; ?>" data-rel="<?php if($use_image_as==1)echo "prettyPhoto";  elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>"><?php echo "<img style='display:none' data-alt='".$title."' />";  ?><em class="fa fa-plus"></em></a></figcaption>
							</figure>
							
						<?php
						}
						?>
								</div>
							</div>
						</div>  
						<?php
					}
				}
				elseif ($parallax_element == 'album') {
					if ( !isset($cs_node->parallax_album) or $cs_node->parallax_album == "" ) { $cs_node->parallax_album = ''; }
                    if ( !isset($cs_node->parallax_album_bgcolor) or $cs_node->parallax_album_bgcolor == "" ) { $cs_node->parallax_album_bgcolor = ''; }
					if ($cs_node->parallax_album_autoplay == "true" ) { $parallax_album_autoplay = 'play'; }else{ $parallax_album_autoplay = 'pause'; }
					//echo $cs_node->parallax_album; 
				if(isset($cs_node->parallax_album) && $cs_node->parallax_album <> ''){
					$custom_query = new WP_Query('p='.$cs_node->parallax_album.'&post_type=albums' );
					$playtracks = '';
					$track_counter = 0;
				  	if ( $custom_query->have_posts() <> "" ) {
						cs_enqueue_jplayer();
						while ( $custom_query->have_posts() ): $custom_query->the_post();
							$image_url = cs_get_post_img_src( $post->ID,150,150 ); 
							$cs_album = get_post_meta($post->ID, "cs_album", true);
							 if ( $cs_album <> "" ) {
								  $cs_xmlObject = new SimpleXMLElement($cs_album);
								  $album_artist = (int) $album_artist = $cs_xmlObject->album_artist;
								  
							 }
							foreach ($cs_xmlObject->track as $track) {
									$track_counter++;
									$playtracks .= '{
														title:"'.$track->album_track_title.'",
														artist:"'.get_the_title($album_artist).'",
														desc:"'.$track->album_track_lyrics.'",
														mp3:"'.$track->album_track_mp3_url.'",
													},';
								}
							$playtracks = substr($playtracks, 0, -1);
						?>
				 <script>
					jQuery(document).ready(function($) {
						var myPlaylist = new jPlayerPlaylist({
						jPlayer: "#jquery_jplayer_n",
						cssSelectorAncestor: "#jp_container_n"
					}, [
						<?php echo $playtracks;?>
					], {
						swfPath: "<?php echo get_template_directory_uri().'/scripts/frontend/Jplayer.swf';?>",
						supplied: "mp3",
						wmode: "window",
						smoothPlayBar: true,
						keyEnabled: true,
						canplay: function() {
							jQuery("#jquery_jplayer_n").jPlayer("<?php echo $parallax_album_autoplay; ?>");
						}
											
					});
 					});
					</script>
                    <div id="albumarea" class="fullwidth parallax-fullwidth" style="background-color:<?php echo $cs_node->parallax_album_bgcolor;?>">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="albumcover float-left">
                                        <?php if($image_url <> ''){?><span class="imgbox"><img src="<?php echo $image_url;?>" alt=""></span><?php }?>
                                    </div>
                                    <div class="alubmdetail">
                                        <h2><a href="<?php the_permalink()?>"> <?php the_title();?></a></h2>
                                        <div id="player">
                                            <div id="jquery_jplayer_n" class="jp-jplayer"></div>
                                            <div id="jp_container_n" class="jp-audio">
                                                <div class="jp-type-playlist">

                                                    <div class="jp-gui">

                                                        <div class="jp-interface">
                                                            <div class="jp-controls-holder">
                                                                <ul class="jp-controls audio-control">
                                                                    <li>
                                                                        <a href="javascript:;" class="jp-previous" tabindex="1"> <em class="fa fa-backward"></em>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;" class="jp-play" tabindex="1"> <em class="fa fa-play"></em>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;" class="jp-pause" tabindex="1">
                                                                            <em class="fa fa-pause"></em>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="javascript:;" class="jp-next" tabindex="1">
                                                                            <em class="fa fa-forward"></em>
                                                                        </a>
                                                                    </li>
                                                                </ul>

                                                                <div class="main-progress">
                                                                    
                                                                    <div class="jp-current-time"></div>
                                                                    <div class="jp-progress">
                                                                        <div class="jp-seek-bar">
                                                                            <div class="jp-play-bar bgcolr"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="jp-duration"></div>
                                                                    <div class="volume-wrap">
                                                                        <a title="mute" tabindex="1" class="jp-mute" href="javascript:;"><em class="fa fa-volume-down"></em></a>
                                                                        <a title="unmute" tabindex="1" class="jp-unmute" href="javascript:;" style="display: none;"><em class="fa fa-volume-off"></em></a>
                                                                        <div class="jp-volume-bar">
                                                                            <div class="jp-volume-bar-value bgcolr" style="width: 80%;"></div>
                                                                        </div>
                                                                        <a title="max volume" tabindex="1" class="jp-volume-max" href="javascript:;"><em class="fa fa-volume-up"></em></a>
                                                                    </div>
                                                                    <a href="#playheader" class="jp-playlist-icon btntoggle"><em class="fa fa-align-justify"></em></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="jp-playlist " id="playheader">
                                                        <div class="trackcounter">
                                                            <em class="fa fa-music"></em>
                                                            <h5><?php echo $track_counter;?> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Tracks','Rocky');}else{ echo $cs_theme_option['trans_album_tracks']; } ?></h5>
                                                        </div>
                                                        <div class="wrapper-payerlsit">
                                                        <ul>
                                                            <!-- The method Playlist.displayPlaylist() uses this unordered list -->                    
                                                            <li></li>
                                                        </ul>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if($parallax_back_top  == "Yes"){?><a class="gotop" id="gotop" href="#"><i class="fa fa-angle-double-up"></i></a> <?php } ?>
                        </div>
                    </div>
				<?php
				endwhile; }
				 wp_reset_query();}
				 } elseif ($parallax_element == 'photo_album') {
					 if ( !isset($cs_node->parallax_photo_album_title) or $cs_node->parallax_photo_album_title == "" ) { $cs_node->parallax_photo_album_title = ''; }
                    if ( !isset($cs_node->parallax_photo_album_bgcolor) or $cs_node->parallax_photo_album_bgcolor == "" ) { $cs_node->parallax_photo_album_bgcolor = ''; }
					if ( !isset($cs_node->parallax_photo_album_post_per_page) or $cs_node->parallax_photo_album_post_per_page == "" ) { $cs_node->parallax_photo_album_post_per_page = '6'; }
					 ?>
					 <!-- Our Music Area -->
                    <div  id="ourmusicsection" class="fullwidth parallax-fullwidth ourmusicsec"  style="background-color:<?php echo $cs_node->parallax_photo_album_bgcolor;?>; <?php if(isset($parallax_height) && !empty($parallax_height)){ ?> height: <?php echo $parallax_height ?>px; <?php }?>  margin-bottom:<?php echo $parallax_margin_bottom?>px; margin-top:<?php echo $parallax_margin_top?>px; ">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php if ( $cs_node->parallax_photo_album_title <> "" ) {?><header><h2 class="section-title cs-heading-color"><?php echo $cs_node->parallax_photo_album_title;?></h2></header><?php }?>
                                    <div class="masonray-wrapp fullwidth">
                                    <?php 
									$args = array(
										'posts_per_page'			=> "$cs_node->parallax_photo_album_post_per_page",
										'post_type'					=> 'albums',
										'post_status'				=> 'publish',
										'order'						=> 'ASC',
									 );
									 $custom_query = new WP_Query($args);
									 $width = 288; 
									$height = 203;
									$album_artist = '';
									if ( $custom_query->have_posts() <> "" ) {
										$counter_album = 0;
										while ( $custom_query->have_posts() ): $custom_query->the_post();
										$counter_album++;
										$cs_album = get_post_meta($post->ID, "cs_album", true);
										if ( $cs_album <> "" ) {
											$cs_xmlObject = new SimpleXMLElement($cs_album);
											$album_artist = (int) $album_artist = $cs_xmlObject->album_artist;
										}
									 		$image_url = cs_get_post_img_src( $post->ID,$width,$height ); 
											if($image_url <> ''){
									 ?>
                                            <!-- Article Start -->
                                            <article>
                                                <a class="caption-link" href="<?php the_permalink();?>"></a>
                                                <figure >
                                                    <img src="<?php echo $image_url;?>" alt="">
                                                    <figcaption>
                                                        <a href="<?php the_permalink();?>" class="btnarrow"></a>
                                                        <h2 class="post-title">
                                                            <a href="<?php the_permalink();?>"><?php the_title();?></a>
                                                            </h2>
                                                            <?php if(isset($cs_xmlObject->album_artist) && $cs_xmlObject->album_artist <> ''){?>
                                                                <h6>
                                                                   <strong><?php echo get_the_title($album_artist); ?> </strong>
                                                                </h6>
                                                            <?php }?>
                                                        
                                                    </figcaption>
                                                </figure>
                                            </article>
                                            <!-- Article Close -->
                                       <?php }
									   endwhile; }
				 						wp_reset_query();
									   ?>
                                    </div>
                                    
                                    <div class="clear"></div>
                                </div>
                                
                             </div>
                             <?php if($parallax_back_top  == "Yes"){?><a class="gotop" id="gotop" href="#"><i class="fa fa-angle-double-up"></i></a> <?php } ?>
                        </div>
                    </div>
                    <!-- Our Music Area Close -->
				<?php 
					 
				}elseif ($parallax_element == 'map') {
				if ( !isset($cs_node->parallax_height) or $cs_node->parallax_height == "" ) { $cs_node->parallax_height = 200; }
                if ( !isset($cs_node->parallax_map_lat) or $cs_node->parallax_map_lat == "" ) { $cs_node->parallax_map_lat = 0; }
                if ( !isset($cs_node->parallax_map_bgcolor) or $cs_node->parallax_map_bgcolor == "" ) { $cs_node->parallax_map_bgcolor = 0; }
                if ( !isset($cs_node->parallax_map_lon) or $cs_node->parallax_map_lon == "" ) { $cs_node->parallax_map_lon = 0; }
                if ( !isset($cs_node->parallax_map_zoom) or $cs_node->parallax_map_zoom == "" ) { $cs_node->parallax_map_zoom = 11; }
                if ( !isset($cs_node->parallax_map_info_width) or $cs_node->parallax_map_info_width == "" ) { $cs_node->parallax_map_info_width = 200; }
                if ( !isset($cs_node->parallax_map_info_height) or $cs_node->parallax_map_info_height == "" ) { $cs_node->parallax_map_info_height = 100; }
                if ( !isset($cs_node->parallax_map_show_marker) or $cs_node->parallax_map_show_marker == "" ) { $cs_node->parallax_map_show_marker = 'true'; }
                if ( !isset($cs_node->parallax_map_controls) or $cs_node->parallax_map_controls == "" ) { $cs_node->parallax_map_controls = 'false'; }
                if ( !isset($cs_node->parallax_map_scrollwheel) or $cs_node->parallax_map_scrollwheel == "" ) { $cs_node->parallax_map_scrollwheel = 'true'; }
                if ( !isset($cs_node->parallax_map_draggable) or $cs_node->parallax_map_draggable == "" )  { $cs_node->parallax_map_draggable = 'true'; }
                if ( !isset($cs_node->parallax_map_type) or $cs_node->parallax_map_type == "" ) { $cs_node->parallax_map_type = 'ROADMAP'; }
                if ( !isset($cs_node->parallax_map_info)) { $cs_node->parallax_map_info = ''; }
                if( !isset($cs_node->parallax_map_marker_icon)){ $cs_node->parallax_map_marker_icon = ''; }
                if( !isset($cs_node->parallax_map_title)){ $cs_node->parallax_map_title ='';}
                if( !isset($cs_node->parallax_map_element_size)){ $cs_node->parallax_map_element_size ='default';}
				
                     $map_show_marker = '';
                    ?>
                     <div class="parallaxbg parallax-fullwidth fullwidth <?php if(isset($parallax_view) && !empty($parallax_view)){ echo $parallax_view.'-width';} else { echo 'parallax-full-width';}?>" style=" <?php if(isset($cs_node->parallax_height) && !empty($cs_node->parallax_height)){ ?> height: <?php echo $cs_node->parallax_height ?>px; <?php } if(isset($cs_node->parallax_map_bgcolor) && !empty($cs_node->parallax_map_bgcolor)){ ?>background-color:<?php echo $cs_node->parallax_map_bgcolor; ?>; <?php }?> margin-bottom:<?php echo $parallax_margin_bottom?>px; margin-top:<?php echo $parallax_margin_top?>px; padding:0px;">
                     <?php 
                    if ( $cs_node->parallax_map_show_marker == "true" ) { 
                            $map_show_marker = " var marker = new google.maps.Marker({
                                                    position: myLatlng,
                                                    map: map,
                                                    title: '',
                                                    icon: '".$cs_node->parallax_map_marker_icon."',
                                                    shadow:''
                                            });
                            ";
                    }
                    //wp_enqueue_script('googleapis', 'https://maps.googleapis.com/maps/api/js?sensor=true', '', '', true);
                    $html = '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>';
                  
                    $html .= '<div class="webkit map_sec">';
					if(isset($cs_node->parallax_map_title) && $cs_node->parallax_map_title <> ''){
                       $html .= '<h1 class="color heading-color cs-heading-color">'.$cs_node->parallax_map_title.'</h1>';
					}
                     $html .= '<div class="mapcode mapcode'.$counter_node.' iframe mapsection gmapwrapp" id="map_canvas'.$counter_node.'" style="height:'.$cs_node->parallax_height.'px;"> </div>';
                    $html .= '</div>';
                    $html .= "<script type='text/javascript'>
						function initialize() {
								var myLatlng = new google.maps.LatLng(".$cs_node->parallax_map_lat.", ".$cs_node->parallax_map_lon.");
								var mapOptions = {
										zoom: ".$cs_node->parallax_map_zoom.",
										scrollwheel: ".$cs_node->parallax_map_scrollwheel.",
										draggable: ".$cs_node->parallax_map_draggable.",
										center: myLatlng,
										mapTypeId: google.maps.MapTypeId.".$cs_node->parallax_map_type." ,
										disableDefaultUI: ".$cs_node->parallax_map_controls.",
								}
								var map = new google.maps.Map(document.getElementById('map_canvas".$counter_node."'), mapOptions);
								var infowindow = new google.maps.InfoWindow({
										content: '".$cs_node->parallax_map_info."',
										maxWidth: ".$cs_node->parallax_map_info_width.",
										maxHeight:".$cs_node->parallax_map_info_height.",
								});
								".$map_show_marker."
								//google.maps.event.addListener(marker, 'click', function() {
									if (infowindow.content != ''){
									  infowindow.open(map, marker);
									   map.panBy(1,-60);
									   google.maps.event.addListener(marker, 'click', function(event) {
										infowindow.open(map, marker);
			
									   });
									}
								//});
						}
	
				google.maps.event.addDomListener(window, 'load', initialize);
			</script>";
		echo $html;
		
		echo '</div>';
		} elseif ($parallax_element == 'custom') {
		if ( !isset($cs_node->parallax_custom_text) or $cs_node->parallax_custom_text == "" ) { $cs_node->parallax_custom_text = ''; }
		if ( !isset($cs_node->parallax_custom_img) or $cs_node->parallax_custom_img == "" ) { $cs_node->parallax_custom_img = ''; }
 		if ( !isset($cs_node->parallax_custom_bgcolor) or $cs_node->parallax_custom_bgcolor == "" ) { $cs_node->parallax_custom_bgcolor = ''; }
		
	?>
	<div class="parallaxbg parallax-fullwidth fullwidth bannerarea"  style=" <?php if ($cs_node->parallax_custom_img <> '') { ?> background: url(<?php echo $cs_node->parallax_custom_img; ?>) no-repeat center top fixed;<?php } if(isset($cs_node->parallax_height) && !empty($cs_node->parallax_height)){ ?> height: <?php echo $cs_node->parallax_height ?>px; <?php } ?>  margin-bottom:<?php echo $parallax_margin_bottom?>px; margin-top:<?php echo $parallax_margin_top?>px;
       <?php if(!($cs_node->parallax_custom_bgcolor)){ ?> background-color:<?php echo $cs_node->parallax_custom_bgcolor; ?>; <?php } ?>">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-7 col-md-7">
                                     <?php if ($cs_node->parallax_custom_text <> ''){ echo cs_textarea_filter($cs_node->parallax_custom_text); }?>
                                     <div class="clear"></div>
                                </div>
                                <?php if($parallax_back_top  == "Yes"){?><a class="gotop" id="gotop" href="#"><i class="fa fa-angle-double-up"></i></a> <?php } ?>
                            </div>
                        </div>
                    </div>
		<!-- Qoute Start -->
	<?php
	}

?>
