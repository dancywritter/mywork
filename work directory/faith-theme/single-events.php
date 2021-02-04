<?php
get_header();
	global $cs_node, $cs_theme_option;
	$cs_layout = '';
	$cs_counter_events=1;
 	$post_xml = get_post_meta($post->ID, "cs_event_meta", true);	
	if ( $post_xml <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($post_xml);
  		$cs_layout = $cs_xmlObject->sidebar_layout->cs_layout;
		$cs_sidebar_left = $cs_xmlObject->sidebar_layout->cs_sidebar_left;
		$cs_sidebar_right = $cs_xmlObject->sidebar_layout->cs_sidebar_right;
		$event_social_sharing = $cs_xmlObject->event_social_sharing;
		$event_start_time = $cs_xmlObject->event_start_time;
		$event_end_time = $cs_xmlObject->event_end_time;
 		$event_all_day = $cs_xmlObject->event_all_day;
		$event_booking_url = $cs_xmlObject->event_booking_url;
		$event_phone_no = $cs_xmlObject->event_phone_no;
		$event_address = $cs_xmlObject->event_address;
 		$inside_event_map = $cs_xmlObject->event_map;
		$width = 330;
		$height = 248;
		$image_url = cs_get_post_img_src($post->ID, $width, $height);
		
		if ( $cs_layout == "left") {
			$cs_layout = "content-right col-md-9";
			$custom_height = 300;
 		}
		else if ( $cs_layout == "right" ) {
			$cs_layout = "content-left col-md-9";
			$custom_height = 300;
 		}
		else {
			$cs_layout = "col-md-12";
			$custom_height = 403;
		}
  	}else{
		$event_social_sharing = '';
 		$inside_event_thumb_view = '';
   		$inside_event_thumb_map_lat = '';
		$inside_event_thumb_map_lon = '';
		$inside_event_thumb_map_zoom = '';
		$inside_event_thumb_map_address = '';
		$inside_event_thumb_map_controls = '';
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
	$year_event = date("Y", strtotime($cs_event_from_date));
	$month_event = date("m", strtotime($cs_event_from_date));
	$month_event_c = date("M", strtotime($cs_event_from_date));							
	$date_event = date("d", strtotime($cs_event_from_date));
	$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
	$date_format = get_option( 'date_format' );
	$time_format = get_option( 'time_format' );							
	if ( $cs_event_meta <> "" ) {
		$cs_event_meta = new SimpleXMLElement($cs_event_meta);
	}	
	$address_map = '';
	$address_map = get_the_title("$cs_xmlObject->event_address");		
	$time_left = date("H,i,s", strtotime("$cs_event_meta->event_start_time"));
	$current_date = date('Y-m-d');
    if ( have_posts() ) while ( have_posts() ) : the_post();
		$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
		if ( $cs_event_meta <> "" ) $cs_event_meta = new SimpleXMLElement($cs_event_meta);
		
		if($inside_event_map != "on"){
			$class = 'eventdetail-parallax-full';
		}else{
			$class ='';
		}
		
	?>
			<!--Left Sidebar Starts-->
			<?php if ($cs_layout == 'content-right col-md-9'){ ?>
                <aside class="sidebar-left col-md-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_left) ) : ?><?php endif; ?></aside>
            <?php wp_reset_query();} ?>
			<!--Left Sidebar End-->
			<div class="<?php echo $cs_layout; ?>">
                <div class="event event-detail">
                  <article>
                      <div class="event-detail-top">
                      <div class="leftdesc">
                          <span class="ico-box">
                              <i class="fa fa-clock-o"></i>
                          </span>
                          <div class="desc">
                              <h5> 
                                  <?php 
                                      if($cs_theme_option['trans_switcher'] == "on"){
                                          _e('Event Time','Statford');
                                      }else{ 
                                          echo $cs_theme_option['trans_event_eventtime']; 
                                      } 
                                  ?>
                                  </h5>
                                  <p><time datetime="2011-01-12"> <?php echo date(get_option('date_format'),strtotime($cs_event_from_date));?>, 
                                  <?php if($event_start_time <> ""){?>
                                            <?php if ( $cs_event_meta->event_all_day != "on" ) {?>
                                                     <?php echo $event_start_time; if($event_end_time <> ''){ echo " to ";  echo $event_end_time; }?>
                                             <?php } else {
                                                       _e("All",'Statford') . printf( __("%s day",'Statford'), ' ');
                                              }?>
                                   <?php }?>
                                  </time>
                                 </p>
                          </div>
                      </div>
                      <div class="bottom-event">
                      	<ul><?php echo cs_bynow_button($cs_event_meta); ?></ul>
               		 </div>
                      
                  </div>
                   <div class="detail-text rich_editor_text">
                          <?php if($image_url <> ""){   echo '<img src="'.$image_url.'" class="alignleft" >'; }?>
                          <?php the_content();
                           wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Faith' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );?>
                     
					  </div>
                      
					 <?php 
                      if($inside_event_map == "on"){
                          echo '<div class="event-map-address">';
                          if($address_map <> "" && $event_loc_lat <> "" && $event_loc_long <>"" && $event_loc_zoom <> ''){ ?>
                              <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script> 
                              <script type="text/javascript">
                              jQuery(document).ready(function(){
                                  event_map("<?php echo $loc_address.'<br>'.$loc_city.'<br>'.$loc_postcode.'<br>'.$loc_country  ?>",<?php echo $event_loc_lat ?>,			<?php echo $event_loc_long ?>,<?php echo $event_loc_zoom ?>,<?php echo $cs_counter_events; ?>);
                              });
                              </script>
                                  <div id="map_canvas<?php echo $cs_counter_events; ?>" class="event-map map-section"></div>
                          <?php }?>
						  <div class="event-address-section">
                                    <i class="fa fa fa-map-marker"></i>
                                    <h5>
										<?php 
											if($cs_theme_option['trans_switcher'] == "on"){ 
                                            	_e('Location','Statford');
											}else{ 
                                                echo $cs_theme_option['trans_event_location']; 
                                            } 
                                         ?>
                                    </h5>
                                    <address>
                                      <?php echo $loc_address.'<br>'.$loc_city.'<br>'.$loc_postcode.'<br>'.$loc_country;  ?>
                                    </address>  
                                </div>
                          </div>
                    <?php  }   ?>
                  </article>
                  <div class="share-post">
                    	<div class="cs-post-top-section">
                        	<div class="cs-share-comment-link">
							   <?php 
                                if($cs_xmlObject->event_social_sharing == 'on') { 
                                    cs_addthis_script_init_method();
                                ?>
                                <a class="addthis_button_compact backcolrhover" href="#">
                                    <i class="fa fa-share-square-o"></i>
                                    <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Share post','Faith');}else{ echo $cs_theme_option['trans_share_this_post']; } ?> 
                                  </a>
                            <?php
                            }
                            ?>
                         	<a href="#respond"><i class="fa fa-comments"></i><?php _e('Leave a Reply','Faith'); ?></a>
                         </div>
                   		</div>
                    </div>
                    <?php cs_next_prev_custom_links('events'); ?>             
                  	<!-- About Author Section -->
                   	<?php
					cs_author_description();
					?>
                  <!-- About Author Section Close -->   
                  <?php comments_template('', true); ?>
                </div>
             
                </div>
			<!-- layout End -->
				<?php if ( $cs_layout  == 'content-left col-md-9'){ ?>
                    <aside class="sidebar-right col-md-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_right) ) : ?><?php endif; ?></aside>
                <?php wp_reset_query();} ?>
<?php
    endwhile;
  get_footer(); ?>