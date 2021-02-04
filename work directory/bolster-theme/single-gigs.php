<?php
get_header();
	global $cs_node, $cs_theme_option;
if ( have_posts() ) while ( have_posts() ) : the_post();
 	$post_xml = get_post_meta($post->ID, "cs_event_meta", true);	
	if ( $post_xml <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($post_xml);
 		$event_start_time = $cs_xmlObject->event_start_time;
		$event_end_time = $cs_xmlObject->event_end_time;
 		$event_all_day = $cs_xmlObject->event_all_day;
		$event_booking_url = $cs_xmlObject->event_booking_url;
		$event_address = $cs_xmlObject->event_address;
		$event_rating = (float) $cs_xmlObject->event_rating;
		$inside_event_map = $cs_xmlObject->event_map;
		$width = 800;
		$height = 800;
		$image_id = cs_get_post_img($post->ID, $width,$height);
	
  	}else{
		$event_social_sharing = '';
		$cs_xmlObject->event_related = '';
	}
	$cs_event_loc = get_post_meta($cs_xmlObject->event_address, "cs_event_loc_meta", true);
	if ( $cs_event_loc <> "" ) {
		$cs_event_loc = new SimpleXMLElement($cs_event_loc);
 			$event_loc_lat = $cs_event_loc->event_loc_lat;
			$event_loc_long = $cs_event_loc->event_loc_long;
			$event_loc_zoom = $cs_event_loc->event_loc_zoom;
			$loc_address = $cs_event_loc->loc_address;
			$loc_city = $cs_event_loc->loc_city;
			$loc_postcode = $cs_event_loc->loc_postcode;
			$loc_region = $cs_event_loc->loc_region;
			$loc_country = $cs_event_loc->loc_country;
	}
	else {
		$event_loc_lat = '';
		$event_loc_long = '';
		$event_loc_zoom = '';
		$loc_address = '';
		$loc_city = '';
		$loc_postcode = '';
		$loc_region = '';
		$loc_country = '';
	}
	$cs_event_to_date = get_post_meta($post->ID, "cs_event_to_date", true); 
	$cs_event_from_date = get_post_meta($post->ID, "cs_event_from_date", true); 
	$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
	$date_format = get_option( 'date_format' );
	if ( $cs_event_meta <> "" ) {
		$cs_event_meta = new SimpleXMLElement($cs_event_meta);
 	}	
	$address_map = '';
	$address_map = get_the_title("$cs_xmlObject->event_address");		

		$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
		if ( $cs_event_meta <> "" ) $cs_event_meta = new SimpleXMLElement($cs_event_meta);
	?>
		<!-- Event Detail Start -->
            <div class="main-section gigs-wrapp gigs-detail">
              <div class="main-wrapp gigs-wrapp-inner"> 
                <!-- Article Start -->
                <figure class="<?php if($image_id <> ''){ echo 'wideimg parallaxbg featured-img-wrapper inline-item'; $cs_feature_class= 'cs-featured-image'; }else{ echo 'cs-no-image';  $cs_feature_class = ''; }?>">
                  	<?php 
						if( $image_id <> '' ){ 
							cs_enqueue_parallax();
							echo $image_id; 
						}
					?>
                    <script type="text/javascript">
                      	jQuery(document).ready(function() {
                        	cs_parallax();
                    	});
						jQuery(window).resize(function() {
                            		cs_parallax();
								});
                  	</script>
       <!-- Detail --> 
                  </figure>
                <div class="right-content <?php echo $cs_feature_class; ?>">    
                	<article> 
                  <!-- Article Figure -->
                  <div class="column-wrapp-box gigs-detail-text">
                  <div class="detail_text_wrapp  col-counter">
                    <div class="gigs-header">
                      <h2 class="section-title cs-heading-color"><?php the_title();?></h2>
                      <div class="tag-rating">
						<?php
                            /* translators: used between list items, there is a space after the comma */
                            $before_tag = '<div class="tags-box">';
                            $tags_list = get_the_term_list ( get_the_id(), 'event-tag',$before_tag, ' ', '</div>' );
                            if ( $tags_list){
                                printf( __( '%1$s', 'Bolster'),$tags_list ); 
                            } // End if categories 
							$rating_multiple=20;
                        ?>  
                          <div class="rating">
                          	<div class="rating-area">
                                <span class="stars-large">
                                    <span style="width:<?php echo $rating = $event_rating*$rating_multiple; ?>%"></span>
                                </span>
                            </div>
                        </div>
                      </div>
                      </div>
                      <div class="days-info">
                          <div class="days-left"><?php 
						  		$event_past= 0;
						  		$days_to_go = "";
								if($cs_theme_option['trans_switcher'] == "on"){ $days_before = __('Days Past','Bolster');}else{ $days_before = $cs_theme_option['trans_days_before']; }
								if($cs_theme_option['trans_switcher'] == "on"){ $days_to_go = __('Days to go','Bolster');}else{ $days_to_go = $cs_theme_option['trans_days_to_go']; }
								//if($cs_theme_option['trans_switcher'] == "on"){ $days_before = _e('Days Before','Bolster');}else{ $days_before = $cs_theme_option['trans_event_days_before']; }

								if(strtotime($cs_event_from_date) > strtotime(date('Y-m-d'))){
									echo cs_dateDiff(date('Y-m-d'), $cs_event_from_date).' '.$days_to_go;
								} else {
									$event_past= 1;
									echo cs_dateDiff($cs_event_from_date, date('Y-m-d')).' '.$days_before;
								}
							?></div>
                          <ul>
                            <li>
                              <h6><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Event Date','Bolster');}else{ echo $cs_theme_option['trans_start_date']; } ?></h6>
                              <p>
                                <time><strong><?php echo date(get_option( 'date_format' ),strtotime($cs_event_from_date));?></strong></time>
                              </p>
                              <p><time>
							  <?php 
							  		
									if ( $cs_event_meta->event_all_day == "" ) {
										echo $cs_event_meta->event_start_time; if($cs_event_meta->event_end_time <> ''){ echo " to ";  echo $cs_event_meta->event_end_time; }
									}else{
										_e('All','Bolster'); echo '&nbsp;'; _e('%s day','Bolster'); 
									}
								?>
							  </time></p>
                            </li>
                           <?php if($event_past <> '1'){?>
                               <li>
                                  <h6><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Ticket','Bolster');}else{ echo $cs_theme_option['trans_ticket']; } ?></h6>
                                  <p>
                                    <strong><?php if($cs_theme_option['trans_switcher']== "on"){ _e('From:','Bolster');}else{ echo $cs_theme_option['trans_event_from']; } ?> <?php echo $cs_xmlObject->event_ticket_price;?></strong>
                                  </p>
                               <?php if($cs_xmlObject->event_ticket_url <> ''){?><a href="<?php echo $cs_xmlObject->event_ticket_url;?>" class="btn-buyticket bgcolr"><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Buy Ticket','Bolster');}else{ echo $cs_theme_option['trans_buy_ticket']; } ?></a><?php }?>
                                </li>
                            <?php }?>
                          </ul>
                      </div>
                      <?php if($inside_event_map == 'on'){?><div class="location-info"><p><a><em class="fa fa-map-marker"></em><?php echo $loc_address.' '.$loc_city.' '.$loc_country;?> <em class="fa fa-angle-double-right"></em></a></p></div><?php }?>
                      <?php 
                      	if(isset($cs_xmlObject->inside_event_artists) && $cs_xmlObject->inside_event_artists <> ''){
								$inside_event_artists = $cs_xmlObject->inside_event_artists;
								if ($inside_event_artists)
								{
									$inside_event_artists = explode(",", $inside_event_artists);
								}
							} else {
								$inside_event_artists = array();
							}
							if(isset($inside_event_artists) && count($inside_event_artists)>0){
					  ?>
                      <div class="widget widget_gallery">
                        <header class="heading">
                          <h6 class="post-subtitle"><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Featured Artist','Bolster');}else{ echo $cs_theme_option['trans_featured_artist']; } ?></h6>
                        </header>
                        <ul class="gallery-list lightbox">
                          <!-- Gallery List Start --> 
                          <?php
							$custom_query = new WP_Query( array( 'post_type' => 'artists', 'post__in' => $inside_event_artists ) );
						  if ( $custom_query->have_posts() <> "" ) {
							while ( $custom_query->have_posts() ): $custom_query->the_post();
							$image_url_full = cs_get_post_img_src( $post->ID,0,0 ); 
							 $image_url = cs_get_post_img_src( $post->ID,50,50 ); 
							?>
                              <li>
                                <a href="<?php the_permalink();?>">
                                  <?php if($image_url <> ''){echo "<img src=".$image_url." alt='' >";} else {echo '<img src="' . get_template_directory_uri() . '/images/artist_default.jpg" alt="" />';}?> <em class="fa fa-plus fa-border">&nbsp;</em>
                                </a>
                              </li>
                          <?php endwhile; } wp_reset_query();?>
                          <!-- Gallery List close -->                      
                        </ul>
                      </div>
                      <?php
					}
					   the_content();
					   wp_link_pages();
					   ?>
                       <div class="album-tags">
                        	<?php 
							$before_tag = "<h6>".__('Tags','Bolster')."</h6><p>";
							$tags_list = get_the_term_list ( get_the_id(), 'event-tag',$before_tag, ', ', '</P>' );
							if ( $tags_list){
								printf( __( '%1$s', 'Bolster'),$tags_list ); 
							} 
							?>
                            <?php if($cs_xmlObject->event_social_sharing == "on"){
								cs_social_share();
								?><a class="btn-share" data-toggle="modal" role="button" href="#myshare"><em class="fa fa-plus-square">&nbsp;</em><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Share','Bolster');}else{ echo $cs_theme_option['trans_share_this_post']; } ?> </a><?php }?>
                        </div>
                  </div>
                </div>
                  <!-- Detail Close --> 
                  <!-- Article Figure Close --> 
                </article>
                
              <?php if($inside_event_map == 'on' && ($event_loc_long <> '' && $event_loc_lat <> '' && $event_loc_zoom <> '')){ ?>
              <!-- Map Area Start -->
              <div class="gigs-area-map" id="map-gigs">
                        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
                        <script type="text/javascript">
						jQuery(document).ready(function(){
							cs_event_map("<?php echo addslashes($loc_address) ?>",<?php echo $event_loc_lat ?>,<?php echo $event_loc_long ?>,<?php echo $event_loc_zoom ?>,1);
					});
					</script>
                    
                <div class="mapcode iframe mapsection gmapwrapp" id="map_canvas1" style="height:100%;"></div>
                    </div>
                  <!-- Map area Close -->
                  <?php }?>
                  <!-- Events photo -->
                  <?php
					if($cs_xmlObject->inside_event_gallery <> ''){
						$cs_image_per_gallery = '';
						$cs_sinside_event_gallery = (int) $cs_xmlObject->inside_event_gallery;
						$cs_image_per_gallery = $cs_xmlObject->cs_images_per_gallery;

						// galery slug to id end
						$cs_meta_gallery_options = get_post_meta($cs_xmlObject->inside_event_gallery, "cs_meta_gallery_options", true);
						// pagination start
						if ( $cs_meta_gallery_options <> "" ) {
							cs_enqueue_gallery_style_script();
							cs_enqueue_masonry_style_script();
							$cs_xmlObject = new SimpleXMLElement($cs_meta_gallery_options);
								$limit_start = 0;
 								$limit_end = $limit_start+$cs_image_per_gallery;
								if($limit_end < 1){
									$limit_end = count($cs_xmlObject);
								}
								$count_post = count($cs_xmlObject);
						}
						if($count_post>0){
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
                        
                        <div class="main-wrapp gallery cs-event-gallery gallery_squre_view">
                            <div class="latest-gallery-wrapper inline-item">
                            <?php if ($cs_sinside_event_gallery <>  '' ) { ?>
                                <header class="section-header">
                                    <h2 class="section-title cs-heading-color"><?php echo get_the_title($cs_sinside_event_gallery);?></h2>
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
                                        if($image_url <> ''){
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
										}}
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <?php }
					 
					 	}?> 
					<?php 
						if ( comments_open() ){
							comments_template('', true); 
						}else{
							echo '<div style="width:20px; display:inline-block;"></div>';
						}
					?>
            </div></div>
              </div>
    	<!-- Gigs Detail Close -->
        <?php endwhile; ?>
<!-- main End -->
<?php
get_footer(); ?>