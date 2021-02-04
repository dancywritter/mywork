<?php
get_header();
	global $cs_node, $cs_theme_option, $video_width;
	$cs_layout = '';
	$counter_album_tracks = 0;
	$counter_load_tracks = 0;
	cs_enqueue_gallery_style_script();
if ( have_posts() ) :
while ( have_posts() ) : the_post();
 	$cs_album = get_post_meta($post->ID, "cs_album", true);
	if ( $cs_album <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($cs_album);
  		$cs_layout = $cs_xmlObject->sidebar_layout->cs_layout;
		$cs_sidebar_left = $cs_xmlObject->sidebar_layout->cs_sidebar_left;
		$cs_sidebar_right = $cs_xmlObject->sidebar_layout->cs_sidebar_right;
		$counter_album_tracks = count($cs_xmlObject->track);
		if ( $cs_layout == "left") {
			$cs_layout = "content-right col-lg-9 col-md-9";
 		}
		else if ( $cs_layout == "right" ) {
			$cs_layout = "content-left col-lg-9 col-md-9";
 		}elseif( $cs_layout == "both_right" ){
			$cs_layout = "content-left col-lg-6 col-md-6";
		}
		elseif( $cs_layout == "both_left" ){
			$cs_layout = "content-right col-lg-6 col-md-6";
		}
		elseif( $cs_layout == "both" ){
			$cs_layout = "col-lg-6 col-md-6";
		}
		else {
			$cs_layout = "col-lg-12 col-md-12";
		}
  	}
	$width = 314;
	$height = 314;
	$image_id = cs_get_post_img($post->ID, $width,$height);
	
	?>
	<!-- Col-Md-4 Start -->
    <div class="col-md-4">
        <div class="detail-cover-style">
            <figure><?php if($image_id <> ''){echo $image_id;} else { echo '<img src="'.get_template_directory_uri().'/images/dummy.jpg" height="314" width="314" alt="'.get_the_title().'">';}?><figcaption><i class="fa fa-music"></i><?php echo $counter_album_tracks;?> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Tracks','Spikes');}else{ echo $cs_theme_option['trans_album_tracks']; } ?></figcaption></figure>
            <?php if($cs_xmlObject->album_buynow <> ''){?><a href="<?php echo $cs_xmlObject->album_buynow;?>" class="bay-album webkit backcolrhover"><i class="fa fa-shopping-cart"></i><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Buy Now','Spikes');}else{ echo $cs_theme_option['trans_album_buynow']; } ?></a><?php }?>
            <?php if($cs_xmlObject->album_buy_now_promotion_text <> ''){?><div class="text"><?php echo $cs_xmlObject->album_buy_now_promotion_text;?></div><?php }?>
        </div>
    </div>
    <!-- Col-Md-4 End -->
    <!-- Col-Md-8 Start -->
    <div class="col-md-8">
        <article class="album-detail-sec">
            <ul class="post-options">
                <li><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Released Date','Spikes');}else{ echo $cs_theme_option['trans_album_release_date']; } ?>: <?php echo date('d.m.Y', strtotime($cs_xmlObject->album_release_date));?></li>
                <?php 
					$before_cat = "<li>".__( 'Categories','Spikes')."<span class='cs-album-cat'>";
					$categories_list = get_the_term_list ( get_the_id(), 'album-category', $before_cat, ', ', '</span></li>' );
					if ( $categories_list ){ printf( __( '%1$s', 'Spikes' ),$categories_list ); }
				?>
                <?php if($cs_xmlObject->album_label <> ''){?><li><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Label','Spikes');}else{ echo $cs_theme_option['trans_album_label']; } ?> : <a><?php echo $cs_xmlObject->album_label;?></a></li><?php }?>
            </ul>
           <?php if($cs_xmlObject->album_tracks_title <> ''){?> <header class="cs-heading-title"><h2 class="cs-section-title cs-heading-color"><?php echo $cs_xmlObject->album_tracks_title;?></h2></header><?php }?>
            <figure>
             <?php
			 $counter_load_tracks = count($cs_xmlObject->track);
			 if($counter_load_tracks >0){
			 $playtracks = '';
			 cs_enqueue_jplayer();
			 	 foreach ( $cs_xmlObject->track as $track ){
							$filetype = wp_check_filetype($track->album_track_mp3_url);
							if(isset($track->album_track_playable) && $track->album_track_playable == 'Yes' && $filetype['ext'] == 'mp3'){
								$counter_load_tracks++;
								$playtracks .= '{
											title:"'.$track->album_track_title.'",
											lyrice:"'.$track->album_track_lyrics.'",
											share: "'.$track->album_track_title.'",
											mp3:"'.$track->album_track_mp3_url.'",
											url:"'.$track->album_track_mp3_url.'"
										},';
							}
			 	}
			?>
            <script>
					jQuery(document).ready(function($) {
						 var myPlaylist2 = new jPlayerPlaylist({
								jPlayer: "#jquery_jplayer_1",
								cssSelectorAncestor: "#jp_container_1"
							}, [
								<?php echo $playtracks;?>
							], {
								swfPath: "<?php echo get_template_directory_uri();?>/scripts/frontend/Jplayer.swf",
								supplied: "oga, mp3",
								wmode: "window",
								currentTime: '.jp-current-time',
								smoothPlayBar: true,
								displayTime: 'slow',
								keyEnabled: true
						});
				
					});
			</script>
                <div class="album-detail fullwidth">
                    <div class="player-album fullwidth">
                        <div id="jquery_jplayer_1" class="jp-jplayer "></div>
                        <div id="jp_container_1" class="jp-audio">
                            <div class="jp-type-playlist">
                                <div class="jp-gui">
                                    <div class="jp-interface">
                                        <div class="jp-controls-holder">
                                            <ul class="jp-controls audio-control">
                                                <li>
                                                    <a href="javascript:;" class="jp-previous" tabindex="1"> <em class="fa fa-step-backward"></em>
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
                                                        <em class="fa fa-step-forward"></em>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="volume-wrap">
                                                <ul class="jp-controls">
                                                    <li>
                                                        <a title="mute" tabindex="1" class="jp-mute" href="javascript:;"> <em class="fa fa-volume-up"></em>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a title="unmute" tabindex="1" class="jp-unmute" href="javascript:;" style="display: none;"> <em class="fa fa-volume-down"></em>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <div class="vbtop">
                                                    <a href="javascript:;">
                                                        <em class="fa fa-volume-off"></em>
                                                    </a>
                                                    <div class="jp-volume-bar">
    
                                                        <div class="jp-volume-bar-value bgcolr"></div>
    
                                                    </div>
                                                    <a href="javascript:;">
                                                        <em class="fa fa-volume-up"></em>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="jp-play-wrap">
                                                <div class="fullwidth">
                                                    <div class="jp-title gallery">
                                                        <ul>
                                                            <li></li>
                                                        </ul>
                                                    </div>
                                                    <div class="jp-current-time float-right"></div>
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
                                <div class="jp-playlist">
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
                <?php }?>
            </figure>
        </article>
        <!-- Share Post Start -->
        <div class="share_post album_share_post">
            <div class="amazoon-icon">
                <?php if($cs_xmlObject->album_buy_amazon <> ''){?><a href="<?php echo $cs_xmlObject->album_buy_amazon;?>" class="amz-one"></a><?php }?>
                <?php if($cs_xmlObject->album_buy_apple <> ''){?><a href="<?php echo $cs_xmlObject->album_buy_apple;?>" class="amz-two"></a><?php }?>
                <?php if($cs_xmlObject->album_buy_groov <> ''){?><a href="<?php echo $cs_xmlObject->album_buy_groov;?>" class="amz-three"></a><?php }?>
                <?php if($cs_xmlObject->album_buy_cloud <> ''){?><a href="<?php echo $cs_xmlObject->album_buy_cloud;?>" class="amz-four"></a><?php }?>
            </div>
            <?php if($cs_xmlObject->album_social_share == 'on') { cs_social_share();}?>
        </div>
        <!-- Share Post End -->
        <!-- Detail Text Strat -->
        <div class="detail_text rich_editor_text">
             <?php 
				the_content();
				wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Spikes' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
		   ?>
        </div>
        <!-- Detail Text End -->
        <!-- Share Post Start -->
        <div class="share_post">
        	<?php 
				$before_cat = '';
				$tags_list = get_the_term_list ( get_the_id(), 'album-tag', $before_cat, ', ', '' );
				if ( $tags_list ){ echo '<div class="tagcloud">';printf( __( '%1$s', 'Spikes' ),$tags_list ); echo '</div>'; }
			
			?>
            <div class="right-sec">
			   <?php cs_next_prev_post();?>
            </div>
        </div>
        <!-- Share Post End -->
    </div>
    <!-- Col-Md-8 End -->
    <?php 
	if ($cs_xmlObject->album_related== "on") {
			cs_cycleslider_script();
		?>
		<?php
			$custom_taxterms='';
			 $custom_taxterms = wp_get_object_terms( $post->ID, array('album-category','album-tag'), array('fields' => 'ids') );
			  // arguments
			  $args = array(
			  'post_type' => 'albums',
			  'post_status' => 'publish',
			  'posts_per_page' => -1, // you may edit this number
			  'orderby' => 'DESC',
			  'tax_query' => array(
				  'relation' => 'OR',
				  array(
					  'taxonomy' => 'album-tag',
					  'field' => 'id',
					  'terms' => $custom_taxterms
				  ),
				  array(
					  'taxonomy' => 'album-category',
					  'field' => 'id',
					  'terms' => $custom_taxterms
				  )
			  ),
			  'post__not_in' => array ($post->ID),
			  ); 
			  $custom_query = new WP_Query($args);
			  $count = 0;
			  $count = $custom_query->post_count;
			  
			  if ($count) {
		?>
     <!-- Col-md-12 Start -->
    <div class="col-md-12">
        <!-- New Releases Start -->
        <div class="new-releases">
            <header class="cs-heading-title"><h2 class="cs-section-title cs-heading-color"><?php echo $cs_xmlObject->album_related_title;?></h2></header>
                <div class="center">
                    <a id="prev3" href="#" class="prev-btn bordercolr colr backcolrhover"><i class="fa fa-angle-left fa-1x"></i></a>
                    <a id="next3" href="#" class="next-btn bordercolr colr backcolrhover"><i class="fa fa-angle-right fa-1x"></i></a>
                </div>
                <div class="cycle-slideshow"
                data-cycle-timeout=4000
                data-cycle-fx=carousel
                data-cycle-slides="article"
                data-cycle-carousel-fluid="false"
                data-allow-wrap="true"
                    data-cycle-next="#next3"
                    data-cycle-prev="#prev3">
                     <?php
						while ( $custom_query->have_posts() ): $custom_query->the_post();
							$cs_album = get_post_meta($post->ID, "cs_album", true);
							if ( $cs_album <> "" ) {
								$counter_album_tracks = 0;
								$album_track_mp3_url_audio = '';
								$cs_xmlObject = new SimpleXMLElement($cs_album);
									$album_release_date_db = $cs_xmlObject->album_release_date;
									$album_buynow = $cs_xmlObject->album_buynow;
							}
							$image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID),228,205 ); 
							if($image_url == ''){
								$noimg = 'no-img';
							}else{
								$noimg  ='';
							}
							?>
                        <article <?php post_class($noimg);?>>
                            <figure>
                                <a href="<?php the_permalink();?>"><img src="<?php echo $image_url;?>" alt=""></a>
                            </figure>
                            <div class="text webkit">
                                <h2 class="cs-post-title cs-heading-color"><a href="<?php the_permalink();?>"><?php echo substr(get_the_title(), 0, 33); if(strlen(get_the_title())>33) echo '...'; ?></a></h2>
                                <?php if($album_release_date_db <> ''){?><time datetime="<?php echo $album_release_date_db;?>"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Released Date','Spikes');}else{ echo $cs_theme_option['trans_album_release_date']; } ?>: <?php echo date('d.m.Y', strtotime($cs_xmlObject->album_release_date));?></time><?php }?>
                                <div class="social-area">
                                    <div class="social-network">
                                        <?php if($cs_xmlObject->album_buy_amazon <> ''){?><a href="<?php echo $cs_xmlObject->album_buy_amazon;?>" class="icon1"></a><?php }?>
                                        <?php if($cs_xmlObject->album_buy_apple <> ''){?><a href="<?php echo $cs_xmlObject->album_buy_apple;?>" class="icon2"></a><?php }?>
                                        <?php if($cs_xmlObject->album_buy_groov <> ''){?><a href="<?php echo $cs_xmlObject->album_buy_groov;?>" class="icon3"></a><?php }?>
                                        <?php if($cs_xmlObject->album_buy_cloud <> ''){?><a href="<?php echo $cs_xmlObject->album_buy_cloud;?>" class="icon4"></a><?php }?>
                                    </div>
                                    <?php if($album_buynow <> ''){?><a href="<?php echo $album_buynow;?>" class="bay-btn uppercase"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Buy Now','Spikes');}else{ echo $cs_theme_option['trans_album_buynow']; } ?></a><?php }?>
                                </div>
                            </div>
                        </article>
  				<?php endwhile; wp_reset_query();?>
            </div>
        </div>
        <!-- New Releases End -->
    </div>
    <!-- Col-md-12 End -->
    <?php }}?>
 <?php comments_template('', true); ?>
<?php
 endwhile; endif;
 get_footer();
 ?>