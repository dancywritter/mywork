<?php
get_header();
?>
 
 <?php if (have_posts()) while (have_posts()) : the_post(); 
 $cs_album = get_post_meta($post->ID, "cs_album", true);
	if ($cs_album <> "") {
		$cs_xmlObject = new SimpleXMLElement($cs_album);
		$album_release_date = $cs_xmlObject->album_release_date;
		$album_buy_amazon = $cs_xmlObject->album_buy_amazon;
		$album_buy_apple = $cs_xmlObject->album_buy_apple;
		$album_buy_groov = $cs_xmlObject->album_buy_groov;
		$album_buy_cloud = $cs_xmlObject->album_buy_cloud;
		$album_buy_url = $cs_xmlObject->album_buy_url;
	}
 	$width = 800;
	$height = 800;
	$counter = 0;
	$image_url = cs_get_post_img_src($post->ID, $width, $height);
	cs_enqueue_jplayer();
 ?>
   
    <div class="main-section album-detail-wrapp"> 
    <div class="main-wrapp albumdetail album">
    
    <figure class="<?php if($image_url <> ''){ echo 'wideimg parallaxbg featured-img-wrapper inline-item'; $cs_feature_class= 'cs-featured-image'; }else{ echo 'cs-no-image';  $cs_feature_class = ''; }?>">
          	<?php 
		  		if($image_url <> ''){
					cs_enqueue_parallax();
			  		echo "<img class='wp-post-image' src=".$image_url." alt='' >";
			  	
			?>
			<script type="text/javascript">
            	jQuery(document).ready(function() {
            		cs_parallax();
            	});
				jQuery(window).resize(function() {
                            		cs_parallax();
								});
            </script>
            <?php
				}
			?>
          <figcaption>
          <?php $counter = count($cs_xmlObject->track);
              if($counter<> '0'){cs_enqueue_gallery_style_script();}
          ?>
               <a class="trackcounter"><em class="fa fa-music"></em> <?php echo $counter;?> <?php if($cs_theme_option['trans_switcher']== "on"){ _e('Tracks','Bolster');}else{ echo $cs_theme_option['trans_track']; } ?></a> 
          </figcaption>
      </figure>
     <div class="right-content <?php echo $cs_feature_class; ?>"> 
    	<article class="album-list">
     
      <div class="album-detail-box scroll-box">
          <div class="header-box">
              <h2 class="section-title cs-heading-color"><?php the_title();?></h2>
              <div class="tag-rating">
                  <div class="tags-box">
                      <?php
                      $before_cat = "".__( '','Bolster')."";
                      $categories_list = get_the_term_list ( get_the_id(), 'album-category', $before_cat, ' ', '' );
                      if ( $categories_list ){
                          printf( __( '%1$s', 'Bolster'),$categories_list );
                      }
                      ?>
                  </div>
                  <time class="release-date"><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Release Date','Bolster');}else{ echo $cs_theme_option['trans_release_date']; } ?> <?php if($album_release_date <> ''){ echo date("d/m/Y", strtotime($album_release_date)); }?></time>
                      <div class="buy-now">
                       <?php if ($album_buy_amazon != '' or $album_buy_apple != '' or $album_buy_groov != '' or $album_buy_cloud != '' or $album_buy_url != '') { 
                          if ($album_buy_apple <> "")
                              echo ' <a target="_blank" href="' . $album_buy_apple . '" ><img src="' . get_template_directory_uri() . '/images/img-bn2.png" alt="" /></a> ';
                          if ($album_buy_amazon <> "")
                              echo ' <a target="_blank" href="' . $album_buy_amazon . '" ><img src="' . get_template_directory_uri() . '/images/img-bn1.png" alt="" /></a> ';
                          if ($album_buy_cloud <> "")
                              echo ' <a target="_blank" href="' . $album_buy_cloud . '" ><img src="' . get_template_directory_uri() . '/images/img-bn4.png" alt="" /></a> ';
                          if ($album_buy_groov <> "")
                              echo ' <a target="_blank" href="' . $album_buy_groov . '" ><img src="' . get_template_directory_uri() . '/images/img-bn3.png" alt="" /></a> ';		
                          if ($album_buy_url <> "")
                              echo ' <a target="_blank" href="' . $album_buy_url . '" ><img src="' . get_template_directory_uri() . '/images/img-bn5.png" alt="" /></a> ';				}
                          ?>
                      </div>
              </div>
          </div>
          <div class="jp-player-wrapp">
       
              <div id="jquery_jplayer_1" class="jp-jplayer"></div>
              <div id="jp_container_1" class="jp-audio">
    <div class="jp-type-playlist">
    <div class="jp-gui">
      <div class="jp-interface">
          <div class="jp-controls-holder">
              <ul class="jp-controls audio-control">
                  <li><a href="javascript:;" class="jp-previous" tabindex="1"><em class="fa fa-step-backward"></em></a></li>
                  <li><a href="javascript:;" class="jp-play" tabindex="1"><em class="fa fa-play"></em></a></li>
                  <li><a href="javascript:;" class="jp-pause" tabindex="1"><em class="fa fa-pause"></em></a></li>
                  <li><a href="javascript:;" class="jp-next" tabindex="1"><em class="fa fa-step-forward"></em></a></li>
              </ul>
              <div class="main-progress ">
                   <div class="jp-title hidden-mobile hidden-tablet">
              <ul>
                  <li></li>
              </ul>
          </div>
          <div class="jp-current-time hidden-mobile hidden-tablet"></div>
              <div class="jp-progress">
              <div class="jp-seek-bar">
                  <div class="jp-play-bar"></div>
              </div>
          </div>
      </div>
          <div class="volume-wrap">
              <ul class="jp-controls">
                  <li>
                      <a href="javascript:;" class="jp-mute" tabindex="1" title="mute"> <em class="fa fa-volume-up"></em>
                      </a>
                  </li>
                  <li>
                      <a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute"> <em class="fa fa-volume-down"></em>
                      </a>
                  </li>
              </ul>
              <div class="vbtop">
                  <a href="javascript:;"> <em class="fa fa-volume-off"></em>
                  </a>
                  <div class="jp-volume-bar">
                      <div class="jp-volume-bar-value"></div>
                  </div>
                  <a href="javascript:;"> <em class="fa fa-volume-up"></em>
                  </a>
              </div>
          </div>
          </div>
      </div>
    </div>
    <div class="jp-playlist album-playlist ">
      <ul>
          <!-- The method Playlist.displayPlaylist() uses this unordered list -->
          <li></li>
      </ul>
    </div>
    
    </div>
    </div>
    </div>
    <?php
    	$counter = 0;
		$playtracks = '';
     	cs_enqueue_gallery_style_script();
      	foreach ($cs_xmlObject->track as $track) {
        	$counter++;
			if($track->album_track_downloadable == "No"){
				$playtracks .='{ 
							  title:"'.$track->album_track_title.'",
							  mp3:"'.$track->album_track_mp3_url.'",
							  buylink:"'.$track->album_track_buy_mp3.'",
							  
						  },';
			}
			else if($track->album_track_playable == "No"){
				$playtracks .='{ 
							  title:"'.$track->album_track_title.'",
							  dwnload:"'.$track->album_track_mp3_url.'",
							  buylink:"'.$track->album_track_buy_mp3.'",
							  
						  },';
			}
			else if($track->album_track_playable == "No" and $track->album_track_downloadable == "No"){
				$playtracks .='{ 
							  title:"'.$track->album_track_title.'",
							  buylink:"'.$track->album_track_buy_mp3.'",
							  
						  },';
			}
			else{
				$playtracks .='{ 
							  title:"'.$track->album_track_title.'",
							  mp3:"'.$track->album_track_mp3_url.'",
							  dwnload:"'.$track->album_track_mp3_url.'",
							  buylink:"'.$track->album_track_buy_mp3.'",
							  
						  },';
			}
	      }
		  $playtracks = substr($playtracks, 0, -1);
      ?>

	<script>
    	jQuery(document).ready(function($) {
 			var myPlaylist2 = new jPlayerPlaylist({
            jPlayer: "#jquery_jplayer_1",
            cssSelectorAncestor: "#jp_container_1"
        }, [
            <?php echo $playtracks; ?>
        ], {
            swfPath: "<?php echo get_template_directory_uri();?>/scripts/frontend/Jplayer.swf",
            supplied: "oga, mp3",
            wmode: "window",
            smoothPlayBar: true,
            keyEnabled: true
    });

jQuery(".loadmorealbum") .live("click",function(event) {
  /* Act on the event */
  jQuery(".album-detail-box .jp-playlist li") .show();
  jQuery(this).hide();
  return false;
});

});

</script>
      <?php  $counter; if($counter>7){?>
           <!-- Load More -->
              <a class="loadmorealbum">
                  <em class="fa fa-plus-o"></em> Load More
              </a>
          <!-- Load More Close -->
        <?php }?>
      </div>
    </article>
   
    <div class="column-wrapp-box album-desc-text">
        <div class="detail_text_wrapp  col-counter">
              <?php the_content();
              wp_link_pages();
              ?>
              <div class="album-tags">
                  <?php 
                  $before_tag = "<h6>".__('Tags','Bolster')."</h6><p>";
                  $tags_list = get_the_term_list ( get_the_id(), 'album-tag',$before_tag, ', ', '</P>' );
                  if ( $tags_list){
                      printf( __( '%1$s', 'Bolster'),$tags_list ); 
                  } 
                  ?>
                  <?php if($cs_xmlObject->album_social_share == "Yes"){
					  cs_social_share();
					  ?><a class="btn-share" data-toggle="modal" role="button" href="#myshare"><em class="fa fa-plus-square">&nbsp;</em><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Share','Bolster');}else{ echo $cs_theme_option['trans_share_this_post']; } ?> </a><?php }?>
              </div>
               </div>
	</div>
     
      <!-- aLBUM Detail Area Close --> 
      <!-- Comment Section Start -->
      <?php 
          if ( comments_open() ){
              comments_template('', true); 
          }else{
              echo '<div style="width:20px; display:inline-block;"></div>';
          }
      ?>
      <!-- Comment Section Close -->
      </div>
     </div>
    </div>
 <?php endwhile; // end of the loop. ?>                
 <?php get_footer();