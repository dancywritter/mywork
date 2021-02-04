<?php
get_header();
	global $px_node, $px_theme_option, $px_event_meta;
	$px_layout = '';
	$px_counter_events=1;
 while ( have_posts() ) : the_post();
 	$post_xml = get_post_meta($post->ID, "px_event_meta", true);	
	if ( $post_xml <> "" ) {
		$px_event_meta = new SimpleXMLElement($post_xml);
		$event_social_sharing = $px_event_meta->event_social_sharing;
		$event_start_time = $px_event_meta->event_start_time;
		$event_end_time = $px_event_meta->event_end_time;
 		$event_all_day = $px_event_meta->event_all_day;
		$event_booking_url = $px_event_meta->event_booking_url;
		$event_phone_no = $px_event_meta->event_phone_no;
		$event_address = $px_event_meta->event_address;
 		$inside_event_map = $px_event_meta->event_map;
		
  	}
	$px_event_loc = get_post_meta($px_event_meta->event_address, "px_event_loc_meta", true);
	if ( $px_event_loc <> "" ) {
		$px_event_loc = new SimpleXMLElement($px_event_loc);
 			$event_loc_lat = $px_event_loc->event_loc_lat;
			$event_loc_long = $px_event_loc->event_loc_long;
			$event_loc_zoom = $px_event_loc->event_loc_zoom;
			$loc_address = $px_event_loc->loc_address;
			$loc_city = $px_event_loc->loc_city;
			$loc_postcode = $px_event_loc->loc_postcode;
	}
	else {
		$event_loc_lat = '';
		$event_loc_long = '';
		$event_loc_zoom = '';
		$loc_address = '';
		$loc_city = '';
		$loc_postcode = '';
	}
	$px_event_to_date = get_post_meta($post->ID, "px_event_to_date", true); 
	$px_event_from_date = get_post_meta($post->ID, "px_event_from_date", true); 
	$year_event = date("Y", strtotime($px_event_from_date));
	$month_event = date("m", strtotime($px_event_from_date));
	$date_event = date("d", strtotime($px_event_from_date));
		$width = 742;
		$height = 170;
		$image_url = px_get_post_img_src($post->ID, $width, $height);
		px_enqueue_countdown_script();
	?>
	 <div class="event event-detail sing-page-area">
                <article>
                <div class="event-shortcode bg-eventcode" <?php if($image_url <> ''){?>style="background:url(<?php echo $image_url;?>) no-repeat center center"<?php }?>>
                    <article class="event-v1">
                        <h2><?php the_title();?></h2>
                        <h3 class="pix-colr">
                            <span id="textLayout" class="countdown"></span>
                        </h3>
                        <script>
						<?php if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'on'){?>
									px_event_countdown('<?php echo $year_event;?>','<?php echo $month_event;?>','<?php echo $date_event;?>');
						<?php } else {?>
								jQuery(document).ready(function($) {
									px_event_countdown('<?php echo $year_event;?>','<?php echo $month_event;?>','<?php echo $date_event;?>');
								});
						<?php } ?>
							
                        </script>
                    </article>
                </div>
                <div class="bottom-event">
                    <div class="calender-date">
                      <time datetime="2011-01-12">
                          <?php echo date(get_option('date_format'), strtotime($px_event_from_date));?>
                      </time>
                  </div>
                  <div class="text">
                  	<?php px_event_options();?>
                   </div>
                </div>
                <div class="detail-text rich_editor_text">
                     <?php 
					   	the_content();
					   	wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Church Life' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
						
				if($inside_event_map == "on" && $px_event_meta->event_address <> '' && $event_loc_lat <> '' && $event_loc_long <> ''){	
					 ?>
                        <h4><?php if($px_theme_option['trans_switcher']== "on"){ _e('Event Location','Church Life');}else{ echo $px_theme_option['trans_event_location']; } ?></h4>
                        <div class="fullwidth map-area"  style="float:left; height:220px; width:100%;">
							
							<?php 
							if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'on'){  ?>
								<script type="text/javascript">
                                     var gMapsLoaded = false;
                                    window.gMapsCallback = function(){
                                        gMapsLoaded = true;
                                        jQuery(window).trigger('gMapsLoaded');
                                    }
                                    window.loadGoogleMaps = function(){
                                        if(gMapsLoaded) return window.gMapsCallback();
                                        var script_tag = document.createElement('script');
                                        script_tag.setAttribute("type","text/javascript");
                                        script_tag.setAttribute("src","http://maps.googleapis.com/maps/api/js?sensor=true&callback=gMapsCallback");
                                        (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(script_tag);
                                    }
                                    
                                  //  $(document).ready(function(){
                                        function initialize(){
                                        	var styles = [
                                                    {
                                                      stylers: [
                                                        { hue: "#000000" },
                                                        { saturation: -100 }
                                                      ]
                                                    },{
                                                      featureType: "road",
                                                      elementType: "geometry",
                                                      stylers: [
                                                        { lightness: -40 },
                                                        { visibility: "simplified" }
                                                      ]
                                                    },{
                                                      featureType: "road",
                                                      elementType: "labels",
                                                      stylers: [
                                                        { visibility: "on" }
                                                      ]
                                                    }
                                                  ];
                                            var styledMap = new google.maps.StyledMapType(styles,{name: "Styled Map"});
                                            var myLatLng = new google.maps.LatLng(<?php echo $event_loc_lat ?>,<?php echo $event_loc_long ?>);
                                            var mapOptions = {
                                                zoom:<?php echo $event_loc_zoom ?>,
                                                center: myLatLng,
                                                mapTypeControlOptions: {
                                                    mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
                                                }
                                            };
                                            map = new google.maps.Map(document.getElementById('map_canvas<?php echo $post->ID; ?>'),mapOptions);
                                            map.mapTypes.set('map_style', styledMap);
                                            map.setMapTypeId('map_style');
                                            //Set Marker
                                        	var marker = new google.maps.Marker({
                                          		position: map.getCenter(),
                                         		map: map
                                        	});
                                        	marker.getPosition();
                                        	var marker = new google.maps.Marker({
                                        		position:myLatLng,
                                        		map: map,
                                        		title: '',
                                        		// icon: 'images/map-marker.png',
                                        		shadow:''
                                    		});
                                        	//End marker
                                            //Set info window
                                        	var infowindow = new google.maps.InfoWindow({
                                            	content: "<?php echo addslashes($loc_address.'<br>'.$loc_city.'<br>'.$loc_postcode); ?>"
                                            	//position: myLatLng
                                        	});
                                        	infowindow.open(map, marker);
                                         	map.panBy(1,-60);
                                        	google.maps.event.addListener(marker, 'click', function() {
                                            	infowindow.open(map,marker);
                                        	});
                                        }
										initialize();
                                       // jQuery(window).bind('gMapsLoaded', initialize);
                                       // window.loadGoogleMaps();
                                   // });
                                </script>
						<?php } else {?>
                        	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script> 
                        	<script type="text/javascript">
								jQuery(document).ready(function(){
									event_map("<?php echo addslashes($loc_address.'<br>'.$loc_city.'<br>'.$loc_postcode); ?>",<?php echo $event_loc_lat ?>, <?php echo $event_loc_long ?>,<?php echo $event_loc_zoom ?>,<?php echo $post->ID; ?>);
								}); 
								</script>
								
						<?php } ?>
                             <div id="map_canvas<?php echo $post->ID; ?>" class="event-map" style="float:left; height:220px; width:100%;"></div>
                        </div>
                  <?php  }?>
                </div>
                </article>
            </div>
             <!-- Share Post -->
             <div class="share-post">
            	<?php
					$before_tag = '<div class="post-tags"><i class="fa fa-tag"></i>';
						$tags_list = get_the_term_list ( get_the_id(), 'event-tag',$before_tag, ', ', '</div>' );
						if ( $tags_list){
							printf( __( '%1$s', 'Church Life'),$tags_list ); 
						} // End if tags 
				 if ($px_event_meta->event_social_sharing == "on"){
				 	px_social_share();
				  }?>
            </div>
            <!-- Share Post Close -->
             <?php 
			 if(isset($px_event_meta->var_pb_event_author) && $px_event_meta->var_pb_event_author <> ''){
			 	px_author_description();
			 }
            comments_template('', true); 
		 endwhile;
	get_footer();