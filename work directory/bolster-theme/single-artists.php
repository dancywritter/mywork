 <?php
get_header();
	global $cs_node, $post, $cs_theme_option;
	$cs_layout = '';
	$cs_images_per_gallery = '';
if ( have_posts() ) while ( have_posts() ) : the_post();
 	$post_xml = get_post_meta($post->ID, "cs_artist_meta", true);	
	if ( $post_xml <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($post_xml);
 		$cs_images_per_gallery =$cs_xmlObject->cs_images_per_gallery;
  	}
  	$width = 800;
	$height = 800;
	$image_id = cs_get_post_img($post->ID, $width,$height);
    $artist_title = get_the_title();
	cs_enqueue_gallery_style_script();
	cs_enqueue_masonry_style_script();	
	?> 
    <script type="text/javascript">
		jQuery(document).ready(function() {
			cs_masonary_callback('album-masonry-gallery');
		});
	</script>
     	<!-- Artist Detail-->
            <div class="main-section">
              <div class="main-wrapp">
                  <!-- Article Figure -->
                  <?php if( $image_id <> '' ){
					  cs_enqueue_parallax();
					  $cs_feature_class= 'cs-featured-image';
				  ?>
                  <figure class="wideimg parallaxbg featured-img-wrapper inline-item"> <?php echo $image_id; ?></figure>
				  <script type="text/javascript">
                      jQuery(document).ready(function() {
                          cs_parallax();
                      });
					  jQuery(window).resize(function() {
                            		cs_parallax();
								});
                  </script>
				  <?php }else{
					  $cs_feature_class= '';
					}?>
                  <div class="right-content <?php echo $cs_feature_class; ?>">   
                      <div class="column-wrapp-box artist-detail">
                      <div class="detail_text_wrapp col-counter">
                        <h2 class="section-title cs-heading-color"><?php the_title();?></h2>
                        <!-- Celebrity Bio -->
                        <div class="bio-graphy">
                          <ul>
                          <?php 
                            $before_cat = '<p><strong>';
                            $categories_list = get_the_term_list ( get_the_id(), 'artists-category', $before_cat, ' / ', '</strong></p>' );
                            if ( $categories_list ){
                          ?>
                            <li class="box1">
                              <p class="title-bio"><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Genre','Bolster');}else{ echo $cs_theme_option['trans_genre']; } ?></p>
                              <?php 
                                     printf( __( '%1$s', 'Bolster' ),$categories_list );
                                ?>
                            </li>
                            <?php }?>
                            <?php if($cs_xmlObject->artist_address <> ''){?>
                            <li class="box2">
                              <p class="title-bio"><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Hometown','Bolster');}else{ echo $cs_theme_option['trans_hometown']; } ?></p>
                              <p><strong><?php if ( $cs_xmlObject->artist_address <> "" ) {echo $cs_xmlObject->artist_address;}?></strong></p>
                            </li>
                            <?php }?>
                            <?php if($cs_xmlObject->artist_start_date <> ''){?>
                            <li class="box3">
                              <p class="title-bio"><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Started','Bolster');}else{ echo $cs_theme_option['trans_started']; } ?></p>
                              <p><strong><?php echo date('Y', strtotime($cs_xmlObject->artist_start_date));?></strong></p>
                            </li>
                            <?php }?>
                            <?php if($cs_xmlObject->artist_live_url <> ''){?>
                            <li class="box4">
                              <p class="title-bio"><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Live Link','Bolster');}else{ echo $cs_theme_option['trans_live_link']; } ?></p>
                              <p><a href="<?php echo $cs_xmlObject->artist_live_url; ?>" target="_blank"><strong><?php echo $str = preg_replace('#^https?://#', '', $cs_xmlObject->artist_live_url);?></strong></a></p>
                            </li>
                            <?php }?>
                          </ul>
                        </div>
                        <!-- Celebrity Bio Close -->
                        <?php the_content();
                                wp_link_pages();
                        ?>
                        <div class="buy-album">
                            <div class="rightbox">
                           <?php
                                $cs_like_counter = '';
                                $cs_like_counter = get_post_meta(get_the_id(), "cs_like_counter", true);
                                if ( isset($_COOKIE["cs_like_counter".get_the_id()]) ) { 
                            ?>
                                    <a class="likes btnlike"><em class="fa fa-heart">&nbsp;</em><?php echo $cs_like_counter; ?> <?php if($cs_theme_option['trans_switcher']== "on"){ _e('Likes','Bolster');}else{ echo $cs_theme_option['trans_likes']; } ?></a>
                            <?php	
                                } else {?>
                                    <a href="javascript:cs_like_counter('<?php echo get_template_directory_uri()?>',<?php echo get_the_id()?>)" class="btnlike" id="like_this<?php echo get_the_id()?>"><em class="fa fa-thumbs-up">&nbsp;</em> <?php echo $cs_like_counter; ?> <?php if($cs_theme_option['trans_switcher']== "on"){ _e('Like','Bolster');}else{ echo $cs_theme_option['trans_like']; } ?> </a>
                                    <a class="likes btnlike" id="you_liked<?php echo get_the_id()?>" style="display:none;"><em class="fa fa-heart">&nbsp;</em> <span id="like_counter<?php echo get_the_id()?>"></span> <?php if($cs_theme_option['trans_switcher']== "on"){ _e('Likes','Bolster');}else{ echo $cs_theme_option['trans_likes']; } ?> </a>
                                    <div id="loading_div<?php echo get_the_id()?>" style="display:none;"><img src="<?php echo get_template_directory_uri()?>/images/ajax-loader.gif" /></div>
                            <?php }?>
                            </div>
                            <?php 
                                if($cs_xmlObject->artist_social_sharing == 'on'){
									cs_social_share();
									?>
                                        <a href="#myshare" role="button"  data-toggle="modal" class="btn-share"><em class="fa fa-plus-square">&nbsp;</em><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Share','Bolster');}else{ echo $cs_theme_option['trans_share_this_post']; } ?> </a>
                            <?php }?>
                        </div>
                       </div>
                      </div>
                      <!-- Detail Close --> 
                      <?php 
						if(isset($cs_xmlObject->cs_artist_albums) && $cs_xmlObject->cs_artist_albums <> ''){
							$cs_artist_albums = $cs_xmlObject->cs_artist_albums;
							if ($cs_artist_albums)
							{
								$cs_artist_albums = explode(",", $cs_artist_albums);
							}
						} else {
							$cs_artist_albums = array();
						}
						if(isset($cs_artist_albums) && count($cs_artist_albums)>0){
						  $custom_query = new WP_Query( array( 'post_type' => 'albums', 'post__in' => $cs_artist_albums ) );
						  if ( $custom_query->have_posts() <> "" ) {
                  ?>
                                  <div class="discography-wrapper">
                                    <header class="section-header">
                                        <h2 class="section-title cs-heading-color"><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Discography','Bolster');}else{ echo $cs_theme_option['trans_discography']; } ?></h2>
                                    </header>
                                    <div class="album-gallery album-masonry-gallery">
                                                 <!-- Album Post -->
                                          <?php
                                        while ( $custom_query->have_posts() ): $custom_query->the_post();
                                         $image_url = cs_get_post_img_src( $post->ID,150, 150 ); 
                                         $cs_album = get_post_meta($post->ID, "cs_album", true);
                                         if ( $cs_album <> "" ) {
                                              $album__track_count = new SimpleXMLElement($cs_album);
                                              $album_buy_amazon = $album__track_count->album_buy_amazon;
                                                $album_buy_apple = $album__track_count->album_buy_apple;
                                                $album_buy_groov = $album__track_count->album_buy_groov;
                                                $album_buy_cloud = $album__track_count->album_buy_cloud;
                                                $album_buy_url = $album__track_count->album_buy_url;
                                         }
                                         $counter = 0;
                                         $counter = count($album__track_count->track);
                                        $image_id = get_post_thumbnail_id($post->ID);
                                        ?>     
                                            <!-- Album Post -->
                                                <article <?php post_class();?>>
                                                    <figure>
                                                     <!-- Album Image -->
                                                        <?php 
                                                            $image_url = cs_attachment_image_src($image_id, 150, 150);
                                                            if($image_url <> ''){echo "<img src=".$image_url." alt='' >";} else {echo '<img src="' . get_template_directory_uri() . '/images/artist_default.jpg" alt="" />';}
                                                        ?>
                                                        <figcaption>
                                                            <a href="<?php the_permalink();?>" class="btnplay"><em class="fa fa-play"></em></a>
                                                            <p>
                                                                <a href="<?php the_permalink();?>" class="track-con"><em class="fa fa-music"></em> <?php echo $counter;?> <?php if($cs_theme_option['trans_switcher']== "on"){ _e('Tracks','Bolster');}else{ echo $cs_theme_option['trans_track']; }?> </a>
                                                            </p>
                                                        </figcaption>
                                                     <!-- Album Image Close -->
                                                    </figure>
                                                     <!-- Album Post Description -->    
                                                        <div class="desc">
                                                            <h2 class="post-title"><a href="<?php the_permalink();?>" ><?php the_title();?></a></h2>
                                                            <h5><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Release Date','Bolster');}else{ echo $cs_theme_option['trans_release_date']; }?>: <?php echo $album__track_count->album_release_date;?></h5>
                                                            <?php if ($album_buy_amazon != '' or $album_buy_apple != '' or $album_buy_groov != '' or $album_buy_cloud != '' or $album_buy_url <> "") { ?>
                                                            <div class="buy-now">
                                                                <h5><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Buy Now','Bolster');}else{ echo $cs_theme_option['trans_buy_now']; }?></h5>
                                                                <?php 
                                                                    if ($album_buy_apple <> "")
                                                                        echo ' <a target="_blank" href="' . $album_buy_apple . '" ><img src="' . get_template_directory_uri() . '/images/img-bn1.png" alt="" /></a> ';
                                                                    if ($album_buy_amazon <> "")
                                                                        echo ' <a target="_blank" href="' . $album_buy_amazon . '" ><img src="' . get_template_directory_uri() . '/images/img-bn2.png" alt="" /></a> ';
                                                                    if ($album_buy_cloud <> "")
                                                                        echo ' <a target="_blank" href="' . $album_buy_cloud . '" ><img src="' . get_template_directory_uri() . '/images/img-bn3.png" alt="" /></a> ';
                                                                    if ($album_buy_groov <> "")
                                                                        echo ' <a target="_blank" href="' . $album_buy_groov . '" ><img src="' . get_template_directory_uri() . '/images/img-bn4.png" alt="" /></a> ';
                                                                    if ($album_buy_url <> "")
                                                                        echo ' <a target="_blank" href="' . $album_buy_url . '" ><img src="' . get_template_directory_uri() . '/images/img-bn5.png" alt="" /></a> ';		
                                                               ?>
                                                            </div>
                                                            <?php }?>
                                                        </div>
                                                   <!-- Album Post Description Close -->     
                                                </article>
                                            <!-- Album Post Close -->
                                            <?php
                                            endwhile;
                                            wp_reset_query();
                                            ?>
                                </div>
                            </div>
					   <?php
                          }}
                         ?>     
                 <?php
					if($cs_xmlObject->inside_artist_gallery <> ''){
						$cs_inside_artist_gallery = (int) $cs_xmlObject->inside_artist_gallery;
 						
						// galery slug to id end
						$cs_meta_gallery_options = get_post_meta($cs_xmlObject->inside_artist_gallery, "cs_meta_gallery_options", true);
						// pagination start
						if ( $cs_meta_gallery_options <> "" ) {
							$cs_xmlObject = new SimpleXMLElement($cs_meta_gallery_options);
								$limit_start = 0;
								$limit_end = $limit_start+$cs_images_per_gallery;
								if($limit_end < 1){
									$limit_end = count($cs_xmlObject);
								}
								$count_post = count($cs_xmlObject);
						}
						?>
                         <script type="text/javascript">
							jQuery(document).ready(function() {
								LoadedItem ("gallerymas article");
								cs_masonary_callback('gallerymas')
								resize_inner_gallery()
							});
							jQuery(window).load(function($) {
								jQuery("body").trigger('resize')
								resize_inner_gallery()
							});
								jQuery(window).resize(function($) {
								resize_inner_gallery()
							});
						</script>
                         
                        <div class="main-wrapp gallery cs-artist-gallery gallery_squre_view">
                            <div class="latest-gallery-wrapper inline-item">
                            <?php if ($cs_inside_artist_gallery <>  '' ) { ?>
                                <header class="section-header">
                                    <h2 class="section-title cs-heading-color"><?php echo get_the_title($cs_inside_artist_gallery);?></h2>
                                </header>
                                <div class="clear"></div>
                            <?php  }?>
                            <div class="events-photo gallery_load">
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
                                        $image_url = cs_attachment_image_src($path, 270, 270);
                                        $image_url_full = cs_attachment_image_src($path, 0, 0);
                                        ?>
                                        <article>
                                            <figure>
                                                <img src="<?php echo $image_url; ?>" alt="<?php echo $title; ?>" data-alt="<?php echo $title; ?>">
                                                <span class="gallery_stack_element fa fa-stack ">
                                                <a href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" class="fa fa-stack colr btnhover" target="<?php if($use_image_as==2) echo '_blank'; ?>" data-rel="<?php if($use_image_as==1)echo "prettyPhoto";  elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>" >
													<?php 
														  if($use_image_as==1){
															  echo '<i class="fa fa-square fa-stack-2x"></i> <i class="fa fa-play fa-stack-1x fa-inverse"></i>';
														  }elseif($use_image_as==2){
															  echo '<i class="fa fa-square fa-stack-2x"></i> <i class="fa fa-link fa-stack-1x fa-inverse"></i>';	
														  }
													  ?>
                                                      </a>
                                                   </span>
                                                <figcaption>
                                                    <a href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" class="fa fa-stack colr btnhover" target="<?php if($use_image_as==2) echo '_blank'; ?>" data-rel="<?php if($use_image_as==1)echo "prettyPhoto";  elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>" >
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
                     <?php }?> 
                   
                     <?php 
                      if ( comments_open() ){
                          comments_template('', true); 
                      }else{
                          echo '<div style="width:20px; display:inline-block;"></div>';	
                      }
                  ?>
              </div>
				   </div>
            </div>
     	<!-- Content Section End --> 
<?php
endwhile;
get_footer(); ?>