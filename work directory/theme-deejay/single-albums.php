<?php
get_header();
	global $px_node, $px_theme_option;
	$px_layout = '';
	$counter_load_tracks = 0;
	if ( have_posts() ) :
	while ( have_posts() ) : the_post();
 		$px_album = get_post_meta($post->ID, "px_album", true);
		if ( $px_album <> "" ) {
			$px_xmlObject = new SimpleXMLElement($px_album);
			$px_layout = $px_xmlObject->sidebar_layout->px_layout;
			$counter_load_tracks = count($px_xmlObject->track);
			if ( $px_layout == "left") {
				$px_layout = "col-md-9";
			}
			else if ( $px_layout == "right" ) {
				$px_layout = "col-md-9";
			}
			else {
				$px_layout = "col-md-12";
			}
		}
	$width = 272;
	$height = 272;
	$image_url = px_get_post_img_src($post->ID, $width, $height);	
	?>
    <?php if ( $px_xmlObject->sidebar_layout->px_layout <> '' and $px_xmlObject->sidebar_layout->px_layout <> "none" and $px_xmlObject->sidebar_layout->px_layout == 'left') : ?>
                <aside class="col-md-3">
                        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($px_xmlObject->sidebar_layout->px_sidebar_left) ) : endif; ?>
                 </aside>
        <?php wp_reset_query(); endif; ?>
        <div class="<?php echo $px_layout;?>">
            <!-- Album Detail -->
            <div class="album-detail">
                
                <div class="detail-inner">
                   <?php if($image_url <> ''){?> <figure><img src="<?php echo $image_url;?>" alt="title"></figure><?php }?>
                    <h1 class="pix-page-title"><?php the_title();?></h1>
                    <ul class="pix-post-options">
                        <li><span><?php _e('by','Deejay');?></span><?php the_author_meta('nicename'); ?>,</li>
                        <?php if($px_theme_option['trans_switcher'] == "on"){ $trans_gener = __('Gener','Deejay');}else{ $trans_gener = $px_theme_option['trans_gener']; } ?>
                         <?php
                            $before_tag = '<li><span>'.$trans_gener.':</span>';
                            $tags_list = get_the_term_list ( get_the_id(), 'album-category',$before_tag, ', ', '</li>' );
                            if ( $tags_list){
                                printf( __( '%1$s', 'Deejay'),$tags_list ); 
                            } // End if tags 
                        ?>
                        <?php if($px_xmlObject->album_release_date <> ''){?> 
                        <li>
                            <span><?php if($px_theme_option['trans_switcher'] == "on"){ _e('Released','Deejay');}else{ echo $px_theme_option['trans_released']; } ?> :</span>
                            <time><?php echo date_i18n(get_option('date_format'), strtotime($px_xmlObject->album_release_date));?>,</time>
                        </li>
                        <?php }?>
                        <?php if(isset($counter_load_tracks) && $counter_load_tracks >0){?><li><a class="pix-colrhvr"><?php echo $counter_load_tracks;?> <?php if($px_theme_option['trans_switcher'] == "on"){ _e('Trackes','Deejay');}else{ echo $px_theme_option['trans_tracks']; } ?></a></li><?php }?>
                    </ul>
                    <ul class="post-pannel">
                        <li><a href="#" id="playlist-play" data-toggle="tooltip" data-placement="right" title="Mute"><i class="fa fa-play"></i></a></li>
                        <li style="display: none;"><a href="#" id="playlist-pause" data-toggle="tooltip" data-placement="right" title="Play"><i class="fa fa-pause"></i></a></li>
                        <?php if ( $px_xmlObject->album_buynow ) { ?>
                        <li><a href="<?php echo $px_xmlObject->album_buynow;?>"><i class="fa fa-shopping-cart"></i></a></li>
                        <?php }?>
                         <?php if ( comments_open() ) { ?>
                        <li><a href="#respond"><i class="fa fa-comment-o"></i></a></li>
                        <?php }?>
                        <?php 
							if ($px_xmlObject->var_pb_album_social_share == "on"){
								px_social_share();
							  }
						?>
                    </ul>
                    <?php
                     $playtracks = '';
                     if(isset($counter_load_tracks) && $counter_load_tracks >0){
                         px_enqueue_jplayer_script();
                         foreach ( $px_xmlObject->track as $track ){
                                    $filetype = wp_check_filetype($track->var_pb_album_track_mp3_url);
                                    if(isset($track->var_pb_album_track_mp3_url) && ($filetype['ext'] == 'mp3'|| $filetype['ext'] == 'oga')){
                                        $playtracks .= '{
                                                    title:"'.$track->var_pb_album_track_title.'",
                                                    artist:"'.$track->var_pb_album_speaker.'",
													buynow: "'.$track->var_pb_album_track_buy_mp3.'",
													dwnloadurl:"'.$track->var_pb_album_track_buy_mp3.'",
                                                    dwnload: "'.$track->var_pb_album_track_mp3_url.'",
                                                    mp3:"'.$track->var_pb_album_track_mp3_url.'",
                                                },';
                                    }
                        }
                    ?>
                    <div class="ablum-detail-player">
                        <div class="audio-play-list fullwidth">
                        <div id="jquery_jplayer_2" class="jp-jplayer"></div>
                        <div id="jp_container_2" class="jp-audio">
                            <div class="jp-type-playlist">
                                <div class="jp-playlist" style="display: block;">
                                    <ul>
                                        <!-- The method Playlist.displayPlaylist() uses this unordered list -->
                                        <li></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
							<script>
                                jQuery(document).ready(function($) {
                                     px_parrallax_callback()
                                    var myPlaylist2 = new jPlayerPlaylist({
                                        jPlayer: "#jquery_jplayer_2",
                                        cssSelectorAncestor: "#jp_container_2"
                                    }, [
                                        <?php echo $playtracks;?>
                                    ], {
                                   playlistOptions: {
                                                enableRemoveControls: false
                                            }, 
                                    play: function () {
                                       jQuery(this).parents(".audio-play-list").find(".jp-playpause").removeClass("jp-pause-item")   
                                    jQuery(this).parents(".audio-play-list").find(".jp-playlist-current .jp-playpause").addClass("jp-pause-item") 
                                        jQuery("#playlist-play").parent("li").hide();
                                        jQuery("#playlist-play").parent("li").next().show();
                                        jQuery(".mejs-pause").trigger('click'); 
                                            
                                        },
                                    pause: function () {
                                     jQuery(this).parents(".audio-play-list").find(".jp-playpause").removeClass("jp-pause-item")    
                                    jQuery("#playlist-pause").parent("li").hide();
                                    jQuery("#playlist-pause").parent("li").prev().show();
                                            
                                    },
                                        swfPath: "js",
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
                    </div>
               		<?php }?>
                </div>
                <div class="detail-text rich_editor_text">
					<?php 
						the_content();
						wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Church Life' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                   ?>
                </div>
				<div class="share-post">
					<?php
                      $before_tag = '<div class="post-tags"><i class="fa fa-tag"></i>';
                        $tags_list = get_the_term_list ( get_the_id(), 'album-tag',$before_tag, ', ', '</div>' );
                        if ( $tags_list){
                            printf( __( '%1$s', 'Deejay'),$tags_list ); 
                        } // End if tags 
						
						px_next_prev_custom_links('albums');
                      ?>
                  </div>
                <?php 
					if(isset($px_xmlObject->var_pb_album_author) && $px_xmlObject->var_pb_album_author <> ''){
                        px_author_description();
                    }
                    comments_template('', true);
				?>
            <!--  -->
            </div>
            <!-- Album Detail Close -->
         </div>
            <?php
			if ( $px_xmlObject->sidebar_layout->px_layout <> '' and $px_xmlObject->sidebar_layout->px_layout <> "none" and $px_xmlObject->sidebar_layout->px_layout == 'right') : ?>
                <aside class="col-md-3">
                        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($px_xmlObject->sidebar_layout->px_sidebar_right) ) : endif; ?>
                 </aside>
            <?php 
			wp_reset_query();
			endif;	
			
			
		 endwhile; endif;
	get_footer();