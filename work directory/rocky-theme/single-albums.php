<?php
get_header();
	global $cs_node, $cs_theme_option, $video_width;
	$cs_layout = '';
	$counter_album_tracks = 0;
	$counter_load_tracks = 0;
	cs_enqueue_gallery_style_script();
if ( have_posts() ) while ( have_posts() ) : the_post();
 	$cs_album = get_post_meta($post->ID, "cs_album", true);
	
	if ( $cs_album <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($cs_album);
  		$cs_layout = $cs_xmlObject->sidebar_layout->cs_layout;
		$cs_sidebar_left = $cs_xmlObject->sidebar_layout->cs_sidebar_left;
		$cs_sidebar_right = $cs_xmlObject->sidebar_layout->cs_sidebar_right;
		$album_artist = $cs_xmlObject->album_artist;
		foreach ( $cs_xmlObject->track as $track ){
			$counter_album_tracks++;
		}
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
	$width = 270;
	$height = 270;
	$image_id = cs_get_post_img($post->ID, $width,$height);
	
	?>
<!-- Event Detail Start -->
		<?php if ($cs_layout == 'content-right col-lg-9 col-md-9' || $cs_layout == 'col-lg-6 col-md-6'){ ?>
            	<aside class="sidebar-left col-lg-3 col-md-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_left) ) : ?><?php endif; ?></aside>
        <?php } ?>
          <div class="<?php echo $cs_layout;?>">
           <!-- Album detail -->
             <div class="albumdetail  fullwidth lightbox">
                        <article>
                            <div class="track-detail fullwidth">
                                <div class="left-album">
                                	<?php if($image_id <> ''){?>
                                        <figure><?php echo $image_id;?></figure>
                                       <?php }?>
                                    <div class="left-pan-album">
                                    
                                        <a class="bgcolrhover" href="#"><em class="fa fa-music"></em> <?php echo $counter_album_tracks;?> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Tracks','Rocky');}else{ echo $cs_theme_option['trans_album_tracks']; } ?></a>
                                        <?php if($cs_xmlObject->album_buynow <> ''){?><a href="<?php echo $cs_xmlObject->album_buynow;?>" class="bgcolrhover"><em class="fa fa-shopping-cart"></em><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Buy Now','Rocky');}else{ echo $cs_theme_option['trans_album_buynow']; } ?></a><?php }?>
                                    </div>
                                </div>
                                <div class="tracklist-detail">
                                    <!-- Album info -->
                                    <div class="track-info fullwidth">
                                      
                                        <div class="postpanel">
                                            <ul class="post-options">
												 <?php if(isset($cs_xmlObject->cs_album_rating) && $cs_xmlObject->cs_album_rating <> ''){?>
                                                        <li>
                                                            <div class="ratingbox">
                                                                <?php for($i=1; $i<=5; $i++){?>
                                                                        <a> <em class="<?php if($i<=$cs_xmlObject->cs_album_rating){ echo 'fa fa-star';} else { echo 'fa fa-star-o';}?>"></em></a>
                                                                 <?php }?>
                                                           </div>
                                                       </li>
                                                   <?php }?>
                                                <li>
													<em><?php printf(__('By: %s','Rocky'), " "); ?></em> <?php echo get_the_title("$album_artist");?>
													<?php if($cs_theme_option['trans_switcher'] == "on"){ _e('on','Rocky');}else{ echo $cs_theme_option['trans_other_on']; } ?>
                                                    <time datetime="<?php echo date('j, M Y', strtotime($cs_xmlObject->album_release_date));?>"><?php echo date('d.m.Y', strtotime($cs_xmlObject->album_release_date));?></time>
                                                </li>
                                                <?php 
													$before_cat = '<li>';
													$categories_list = get_the_term_list ( get_the_id(), 'album-category', $before_cat, ', ', '</li>' );
													if ( $categories_list ){ printf( __( '%1$s', 'Rocky' ),$categories_list ); }
												?>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- Album Info Close -->
                                    <?php if($counter_album_tracks>0){
											cs_enqueue_jplayer();
									?>
                                        <!-- Album List -->
                                        <div class="album-list fullwidth">
                                            <?php foreach ( $cs_xmlObject->track as $track ){
													$filetype = wp_check_filetype($track->album_track_mp3_url);
													if(isset($track->album_track_playable) && $track->album_track_playable == 'Yes' && $filetype['ext'] == 'mp3'){
														$counter_load_tracks++;
												?>
                                                <div class="tracklist bgcolrhover fullwidth light-box" <?php if($counter_load_tracks>7){?> style="display:none;" <?php }?> >
                                                    <ul>
                                                    	<li class="play-item">
                                                            <div  id="jquery_jplayer_<?php echo $counter_load_tracks;?>" class="jp-jplayer"></div>
                                                            <div  id="jp_container_<?php echo $counter_load_tracks;?>" class="jp-audio">
                                                                <a href="javascript:;" class="jp-play" tabindex="1"> <em class="fa fa-play"></em>
                                                                </a>
                                                                <a href="javascript:;" class="jp-pause" tabindex="1"> <em class="fa fa-pause"></em>
                                                                </a>
                                                            </div>
                                                            <script type="text/javascript">
														   //<![CDATA[
																jQuery(document).ready(function($){
																	 album_detail_playlist('<?php echo $counter_load_tracks;?>', '<?php echo $track->album_track_mp3_url;?>');
															 	 });
															 //]]> 
															 </script>
                                                        </li>
                                                        <li class="album-title"> <strong><?php echo $track->album_track_title;?></strong></li>
                                                        <!--<li class="album-author">&nbsp;</li>-->
                                                        <li class="album-dur">&nbsp;</li>
                                                        <li class="desc-track">
                                                                <?php if($track->album_track_lyrics <> ''){?>
                                                                    <a href="#inline-<?php echo $counter_load_tracks;?>" data-rel="prettyPhoto"> <em class="fa fa-file-text">&nbsp;</em></a>
                                                                    <div id="inline-<?php echo $counter_load_tracks;?>" style="display:none;">
                                                                        <p><?php echo $track->album_track_lyrics;?></p>
                                                                    </div>
                                                                  <?php } else { echo '&nbsp;';}?> 
                                                          </li>
                                                        <li class="download-track">
                                                            <?php if($track->album_track_downloadable == 'Yes'){?>
                                                                    <a href="<?php echo $track->album_track_mp3_url;?>"  target="_blank"><em class="fa fa-share-square-o">&nbsp;</em></a>
                                                               <?php }?>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <?php } }?>
                                            <?php if($counter_album_tracks>7){?><a class="btnloadmore fullwidth"><em class="fa fa-plus-circle"></em> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Load More','Rocky');}else{ echo $cs_theme_option['trans_album_load_more']; } ?></a><?php }?>
                                        </div>
                                        <!-- Album List Close -->
                                        <?php }?>
                                </div>
                            </div>
                            <div class="album-text-detail fullwidth">
                                <?php the_content();
								wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Rocky' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); 
								?>
                            </div>
                        </article>
                        <div class="share_post fullwidth">
                            <div class="float-left sharing-section">
                                <?php
									$cs_share_now = "";
									if($cs_theme_option['trans_switcher'] == "on"){ $cs_share_now = __('Share Now','Rocky');}else{ $cs_share_now = $cs_theme_option['trans_share_this_post']; }
									if ($cs_xmlObject->album_social_share == "on"){
										echo '<a class="btn btnsharenow"><em class="fa fa-share"> </em> '.$cs_share_now.'</a>';
										cs_social_share();
									}
									$before_cat = '<div class="tags-area"> <em class="fa fa-tags"></em>';
									$categories_list = get_the_term_list ( get_the_id(), 'event-tag', $before_cat, ', ', '</div>' );
									if ( $categories_list ){ printf( __( '%1$s', 'Rocky' ),$categories_list ); }
								?>
                            </div>
                            <?php cs_next_prev_post();?>
                        </div>
                        <?php if (get_the_author_meta('description')) : ?>
                            <!-- About Admin -->
                            <div class="about-author fullwidth">
                                <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="float-left"><?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('PixFill_author_bio_avatar_size', 60)); ?></a>
                                <div class="text">
                                    <h4><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="colr"> <?php the_author_meta('display_name'); ?></a> <?php echo cs_get_user_role();?></h4>
                                    <p><?php the_author_meta('description'); ?></p>
                                     <?php if(get_the_author_meta('twitter') <> ''){?><a href="http://twitter.com/<?php the_author_meta('twitter'); ?>" class="btn tweet_follow"><em class="fa fa-twitter"></em> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Follow Us on Twitter','Rocky');}else{ echo $cs_theme_option['trans_follow_twitter']; } ?></a><?php }?>
                            <?php if(get_the_author_meta('url') <> ''){?><a href="<?php the_author_meta('url'); ?>" class="btn view_blog"><em class="fa fa-pencil"></em> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('View More Blogs','Rocky');}else{ echo $cs_theme_option['trans_view_more_blogs']; } ?></a><?php }?>
                                </div>
                              </div>
                        <?php endif; ?>
                        </div>
          				<?php comments_template('', true); ?>
		</div>
         <!--Right Sidebar Starts-->
		<?php if ( $cs_layout  == 'content-left col-lg-9 col-md-9' || $cs_layout  == 'col-lg-6 col-md-6' ){ ?>
            <aside class="sidebar-right col-lg-3 col-md-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_right) ) : ?><?php endif; ?></aside>
        <?php } ?>
        <!-- Span3 End --> 
<?php
    endwhile;
 get_footer(); ?>