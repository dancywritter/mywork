<?php
get_header();
	global $px_node, $px_theme_option;
	$px_layout = '';
	$counter_load_tracks = 0;
	if ( have_posts() ) :
	while ( have_posts() ) : the_post();
 		$px_sermon = get_post_meta($post->ID, "px_sermon", true);
		if ( $px_sermon <> "" ) {
			$px_xmlObject = new SimpleXMLElement($px_sermon);
		
		}
	$width = 380;
	$height = 200;
	$image_id = px_get_post_img($post->ID, $width,$height);
	?>
    <div class="sermons sermondetail sing-page-area">
                <article>
                    <div class="sermon-desc-area">
                        <figure>
                            <?php if($image_id <> ''){echo $image_id;}?>
                        </figure>
                        <div class="text">
                            <header class="pix-heading-title">
                            <h2 class="pix-section-title"><?php the_title();?></h2>
                            </header>
                            <ul class="post-options">
                                <li><a><?php echo count($px_xmlObject->track);?> <?php if($px_theme_option['trans_switcher'] == "on"){ _e('Sermons','Church Life');}else{ echo $px_theme_option['trans_sermons']; } ?> </a></li>
                                <li><time datetime="2011-01-12"><?php echo get_the_date();?></time></li>
                            </ul>
                            <?php if($px_xmlObject->small_desc <> ''){?><p><?php echo $px_xmlObject->small_desc; ?></p><?php }?>
                            <ul class="sermons-options">
                            <?php if(count($px_xmlObject->track)>0){?>
                                <li><a class="pix-btnplayall" id="playlist-play"><i class="fa fa-play"></i><?php if($px_theme_option['trans_switcher'] == "on"){ _e('Play All','Church Life');}else{ echo $px_theme_option['trans_play_all']; } ?></a></li>
                                <li style="display:none"><a class="pix-btnplayall" id="playlist-pause"><i class="fa fa-pause"></i><?php if($px_theme_option['trans_switcher'] == "on"){ _e('Pause All','Church Life');}else{ echo $px_theme_option['trans_pause_all']; } ?></a></li>
                            <?php }?>
                                <?php 
								if ($px_xmlObject->var_pb_sermon_social_share == "on"){
									px_social_share();
								 }?>
                            </ul>
                        </div>
                    </div>
                    <?php
			 $counter_load_tracks = count($px_xmlObject->track);
			 $playtracks = '';
			 if($counter_load_tracks >0){
				 px_enqueue_jplayer_script();
			 
 			 	 foreach ( $px_xmlObject->track as $track ){
							$filetype = wp_check_filetype($track->var_pb_sermon_track_mp3_url);
							if(isset($track->var_pb_sermon_track_mp3_url) && ($filetype['ext'] == 'mp3'|| $filetype['ext'] == 'oga')){
								$playtracks .= '{
											title:"'.$track->var_pb_sermon_track_title.'",
											artist:"'.$track->var_pb_sermon_speaker.'",
											dwnload: "'.$track->var_pb_sermon_track_mp3_url.'",
											dwnloadurl:"'.$track->var_pb_sermon_track_buy_mp3.'",
											mp3:"'.$track->var_pb_sermon_track_mp3_url.'",
											play:"'.$track->var_pb_sermon_track_mp3_url.'",
										},';
							}
			 	}
			?>
                    <div class="sermons-play-list">
                            <div id="jquery_jplayer_1" class="jp-jplayer"></div>
                                    <div id="jp_container_1" class="jp-audio">
                                        <div class="jp-type-playlist">
                                            <div class="jp-gui">
                                            </div>
                                                <div class="jp-playlist">
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
													enableRemoveControls: false
												}, play: function () {
													jQuery("#playlist-play").parent("li").hide();
													jQuery("#playlist-play").parent("li").next().show();
													
														jQuery(".mejs-pause").trigger('click'); 
												
												},
												pause: function () {
													jQuery("#playlist-pause").parent("li").hide();
													jQuery("#playlist-pause").parent("li").prev().show();
												
												},
													swfPath: "<?php echo get_template_directory_uri();?>/scripts/frontend/",
													supplied: "oga, mp3",
													wmode: "window",
													smoothPlayBar: true,
													keyEnabled: true
											});
											jQuery("#playlist-play").click(function() {
												jQuery(this).parent("li").hide();
												jQuery(this).parent("li").next().show();
												myPlaylist2.play();
												return false;
											});
											jQuery("#playlist-pause").click(function() {
												jQuery(this).parent("li").hide();
												jQuery(this).parent("li").prev().show();
												myPlaylist2.pause();
												return false;
										});
											
								});
							</script>
                    </div>
                    <?php }
					
						$before_tag = '<div class="post-tags"><i class="fa fa-tag"></i>';
						$tags_list = get_the_term_list ( get_the_id(), 'sermon-tag',$before_tag, ', ', '</div>' );
						if ( $tags_list){
							printf( __( '%1$s', 'Church Life'),$tags_list ); 
						} // End if tags 
					?>
                    <div class="detail-text rich_editor_text">
                    
                       <?php 
                        the_content();
                        wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Church Life' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                       ?>
                    </div>
                    
                </article>
            </div>
            <?php 
			if(isset($px_xmlObject->var_pb_sermon_author) && $px_xmlObject->var_pb_sermon_author <> ''){
				px_author_description();
			}
			comments_template('', true); 
		 endwhile; endif;
	get_footer();