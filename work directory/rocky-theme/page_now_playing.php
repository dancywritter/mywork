<?php
	global $cs_node,$post,$cs_theme_option,$counter_node;
?>
<div class="element_size_<?php echo $cs_node->now_playing_element_size; ?> cs_now_playing">
<div class="soundcloud">
<?php if($cs_node->now_playing_title <> ''){?><h2 class="section-title cs-heading-color"><?php echo $cs_node->now_playing_title; ?></h2> <?php } ?>
<?php
   if(isset($cs_node->now_playing_album) && $cs_node->now_playing_album <> ''){
 	   if ($cs_node->now_playing_autoplay == "true" ) { $now_playing_autoplay = 'play'; }else{ $now_playing_autoplay = 'pause'; }
					$custom_query = new WP_Query('p='.$cs_node->now_playing_album.'&post_type=albums' );
					$playtracks = '';
					$track_counter = 0;
				  	if ( $custom_query->have_posts() <> "" ) {
						cs_enqueue_jplayer();
						while ( $custom_query->have_posts() ): $custom_query->the_post();
							$cs_album = get_post_meta($post->ID, "cs_album", true);
							 if ( $cs_album <> "" ) {
								  $cs_xmlObject = new SimpleXMLElement($cs_album);
								  $album_artist = (int) $album_artist = $cs_xmlObject->album_artist;
							 }
							foreach ($cs_xmlObject->track as $track) {
 									$playtracks .= '{
														title:"'.$track->album_track_title.'",
														artist:"'.get_the_title($album_artist).'",
 														mp3:"'.$track->album_track_mp3_url.'",
													},';
								$track_counter++;					
								if($cs_node->now_playing_tracks == $track_counter){
									$track_counter =0;
									break;
								}					
							}
							$playtracks = substr($playtracks, 0, -1);
						?>
					 <script>
                        jQuery(document).ready(function($) {
                            var myPlaylist2 = new jPlayerPlaylist({
                            jPlayer: "#jquery_jplayer_2",
                            cssSelectorAncestor: "#jp_container_2"
                        }, [
                            <?php echo $playtracks;?>
                        ], {
                            swfPath: "<?php echo get_template_directory_uri().'/scripts/frontend/Jplayer.swf';?>",
                            supplied: "mp3",
                            wmode: "window",
                            smoothPlayBar: true,
                            keyEnabled: true,
							canplay: function() {
								jQuery("#jquery_jplayer_2").jPlayer("<?php echo $now_playing_autoplay; ?>");
							}
                        });
                     });
                    </script>
                    <div class="player-theme-sec">
                        <div id="jquery_jplayer_2" class="jp-jplayer"></div>
                        <div id="jp_container_2" class="jp-audio">
                            <div class="jp-type-playlist">
                                <div class="jp-gui">
                                   <div class="jp-interface">
                                        <div class="jp-top-player">
                                            <ul class="jp-controls">
                                                <li>
                                                    <a href="javascript:;" class="jp-play" tabindex="1"> <em class="fa fa-play"></em>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" class="jp-pause" tabindex="1"> <em class="fa fa-pause"></em>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="jp-title">
                                                <ul>
                                                    <li></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="jp-bottom-player">
                                            <div class="jp-controls-holder">
                                                <ul class="jp-controls">
                                                    <li>
                                                        <a href="javascript:;" class="jp-previous" tabindex="1"> <em class="fa fa-fast-backward"></em>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:;" class="jp-next" tabindex="1"> <em class="fa fa-fast-forward"></em>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <div class="volume-wrap">
                                                        <a title="mute" tabindex="1" class="jp-mute" href="javascript:;">
                                                            <em class="fa fa-volume-up"></em>
                                                        </a>
                                                        <a title="unmute" tabindex="1" class="jp-unmute" href="javascript:;" style="display: none;">
                                                            <em class="fa fa-volume-off"></em>
                                                        </a>
                                                    </div>
                                                <div class="main-progress-sec">
                                                    <div class="time-wrap-jp">
                                                  <div class="jp-current-time"></div>
                                                  <div class="jp-duration"></div>
                                                  </div>
                                                    <div class="jp-progress">
                                                        <div class="jp-seek-bar">
                                                            <div class="jp-play-bar bgcolr"></div>
                                                        </div>
                                                    </div>
                                                </div>
                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="jp-playlist playheader-sec" >
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
    <?php endwhile; } } ?>
	</div>
</div>