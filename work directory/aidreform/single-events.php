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
		$cs_sidebar_left = $cs_xmlObject->sidebar_layout->cs_sidebar_left;
		$cs_sidebar_right = $cs_xmlObject->sidebar_layout->cs_sidebar_right;
 		$inside_event_map = $cs_xmlObject->event_map;
		//print_r($cs_xmlObject);
		$width = 262;
		$height = 262;
		$image_id = cs_get_post_img($post->ID, $width,$height);
		
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
	 
<!-- Event Outer Image Strat -->
 <div id="main" role="main"> 
  <!-- Container Start -->
  <div class="container"> 
        <!-- Row Start -->
        <div class="row"> 
			<!--Left Sidebar Starts-->
			<?php if ($cs_layout == 'content-right col-md-9'){ ?>
                <aside class="sidebar-left col-md-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_left) ) : ?><?php endif; ?></aside>
            <?php } ?>
			<!--Left Sidebar End-->
			<div class="<?php echo $cs_layout; ?>">
           		<div class="event_detail  fullwidth">
                    <article>
                         <?php 
							if($inside_event_map == "on"){
								if($address_map <> "" && $event_loc_lat <> "" && $event_loc_long <>"" && $event_loc_zoom <> ''){ ?>
									<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script> 
									<script type="text/javascript">
									jQuery(document).ready(function(){
										event_map("<?php echo $loc_address.'<br>'.$loc_city.'<br>'.$loc_postcode.'<br>'.$loc_country  ?>",<?php echo $event_loc_lat ?>,			<?php echo $event_loc_long ?>,<?php echo $event_loc_zoom ?>,<?php echo $cs_counter_events; ?>);
									});
									</script>
										<div id="map_canvas<?php echo $cs_counter_events; ?>" class="event-map" style="height:300px; width:100%;"></div>
								<?php }
							}
						?>
                         
                        <div class="text-group fullwidth" >
                        	<div class="side-post desc-area-box">
                                <?php
								if($image_id <> ""){
								?>
                                <figure>
                                    <?php echo $image_id; ?>                                            
                                </figure>
                             	<?php 
								}
								?>
                                <div class="event-desc">
                                <ul> 
                               <li><em class="fa fa-clock-o"></em> <span><time><?php echo date("l, d F Y", strtotime($cs_event_from_date)) ?>,  
                                <?php
								if($event_all_day <> ""){
									echo "All day";
								}else{
									echo $event_start_time . " - " . $event_end_time;
								}
								?>
								</time></span> </li> 
                                <li><em class="fa fa-map-marker"></em><span>
                                <?php echo get_the_title((int)$event_address); ?></span></li>
                                 <li><em class="fa fa-tags"></em>
										<?php 
                                            /* translators: used between list items, there is a space after the comma */
                                            $before_cat = " ";
                                            $categories_list = get_the_term_list ( get_the_id(), 'event-tag', $before_cat, ', ', '</span></li>' );
                                            if ( $categories_list ){
                                                printf( __( '%1$s', 'AidReform'),$categories_list );
                                            } // End if categories 
                                        ?>
                               
                                </ul>
                                </div>
                            </div>
                            <div class="text-inner">
                                <div class="post-options">
                                    <ul>
                                      <!--  <li> <em class="fa fa-calendar"></em>
                                            <time><?php echo $cs_event_from_date; ?></time>
                                            </li>-->
                                            <?php 
											$before_cat = "<li><em class='fa fa-list'></em>";
											$categories_list = get_the_term_list ( get_the_id(), 'event-category', $before_cat, ', ', '</li>' );
											if ( $categories_list ){
												printf( __( '%1$s', 'AidReform'),$categories_list );  
											} // End if categories 
										?>
                                       
                                    </ul>
                                </div>
                                <div class="detail_text rich_editor_text">
                                    <?php the_content(); ?>
                                </div>
                            </div>
                            
                        </div>
                    </article>
                    
                    <div class="share-post fullwidth">
                        <?php
 						if ($event_social_sharing == "on"){
							cs_social_share();
						} 
						cs_next_prev_post(); 
					?>
                    </div>
                    <?php comments_template('', true); ?>
                </div>
                </div>
<!-- main End -->
				<?php if ( $cs_layout  == 'content-left col-md-9'){ ?>
                    <aside class="sidebar-right col-md-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_right) ) : ?><?php endif; ?></aside>
                <?php } ?>
<?php
    endwhile;
    $cs_counter_events++;
  get_footer(); ?>