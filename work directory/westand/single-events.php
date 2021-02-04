<?php
get_header();
	global $cs_node, $cs_theme_option;
	$cs_layout = '';
	$cs_counter_events=1;
	if ( have_posts() ) while ( have_posts() ) : the_post();
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
		$event_address = $cs_xmlObject->event_address;
 		$inside_event_map = $cs_xmlObject->event_map;
		$width = 342;
		$height = 193;
		$image_id = cs_get_post_img($post->ID, $width,$height);
		
		if ( $cs_layout == "left") {
			$cs_layout = "content-right col-md-9";
			$custom_height = 193;
 		}
		else if ( $cs_layout == "right" ) {
			$cs_layout = "content-left col-md-9";
			$custom_height = 193;
 		}
		else {
			$cs_layout = "col-md-12";
			$custom_height = 193;
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
	$year_event = date_i18n("Y", strtotime($cs_event_from_date));
	$month_event = date_i18n("m", strtotime($cs_event_from_date));
	$month_event_c = date_i18n("M", strtotime($cs_event_from_date));							
	$date_event = date_i18n("d", strtotime($cs_event_from_date));
	$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
	$date_format = get_option( 'date_format' );
	$time_format = get_option( 'time_format' );							
	if ( $cs_event_meta <> "" ) {
		$cs_event_meta = new SimpleXMLElement($cs_event_meta);
	}	
	$address_map = '';
	$address_map = get_the_title("$cs_xmlObject->event_address");		
	$time_left = date_i18n("H,i,s", strtotime("$cs_event_meta->event_start_time"));
	$current_date = date_i18n('Y-m-d');

		$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
		if ( $cs_event_meta <> "" ) $cs_event_meta = new SimpleXMLElement($cs_event_meta);
	$post_class = '';
	$post_class_no_image = '';
	if($image_id == ""){
		$post_class_no_image .= ' no-image';
	}

	if($inside_event_map == "" || ($cs_xmlObject->event_address == "0" || $cs_xmlObject->event_address == '')){
		$post_class .= ' no-event-map';
	}
		
		
	?>
			<!--Left Sidebar Starts-->
			<?php if ($cs_layout == 'content-right col-md-9'){ ?>
                <aside class="sidebar-left col-md-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_left) ) : ?><?php endif; ?></aside>
            <?php wp_reset_query();} ?>
			<!--Left Sidebar End-->
			<div class="<?php echo $cs_layout; ?>">
            <div class="element_size_100">
                        <div class="event  event-detail <?php echo $post_class;?>">
                            <article>
                                <?php 
								
								if($inside_event_map == "on" && $address_map <> "0"){
									echo '<div class="detail_figure">';
									if($address_map <> "" && $event_loc_lat <> "" && $event_loc_long <>"" && $event_loc_zoom <> ''){ ?>
										<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script> 
										<script type="text/javascript">
										jQuery(document).ready(function(){
											event_map("<?php echo addslashes(get_the_title((int)$cs_xmlObject->event_address))  ?>",<?php echo $event_loc_lat ?>,<?php echo $event_loc_long ?>,<?php echo $event_loc_zoom ?>,<?php echo $cs_counter_events; ?>);
										});
										</script>
											<div id="map_canvas<?php echo $cs_counter_events; ?>" class="event-map" style="height:300px; width:100%;"></div>
									<?php }
									echo '</div>';
								}
								?>
                                <div class="detail_inner <?php echo $post_class_no_image;?>">
                                    <?php if($image_id <> ""){ echo '<figure>'.$image_id.'</figure>';}?>
                                    <div class="text">
                                            <ul class="post-options">
                                                <li>
                                                    <time datetime="2013-12-04"><i class="fa fa-calendar"></i><?php echo date_i18n(get_option( 'date_format' ),strtotime($cs_event_from_date));?>,</time>
                                                </li>
                                             <?php if($event_start_time <> ""){?>
                                                    <li><i class="fa fa-clock-o"></i>
                                                     <?php if ( $cs_event_meta->event_all_day != "on" ) {?>
                                                                <span class="hd"><?php _e('Event Time','WeStand'); ?>:</span> <time> <?php echo $event_start_time; if($event_end_time <> ''){ echo "-";  echo $event_end_time; }?></time>
                                                       <?php } else {
                                                           echo '<time>';
                                                                _e("All",'WeStand') . printf( __("%s day",'WeStand'), ' ');
                                                           echo '</time>';
                                                       }?>
                                                    </li>
                                            <?php }?>
                                               <?php if($cs_xmlObject->event_address <> ""){?>
                                                	<li><i class="fa fa-map-marker"></i><span class="hd"><?php _e('Location','WeStand'); ?>:</span> <?php echo get_the_title((int)$cs_xmlObject->event_address);?></li>
                                                <?php }?>
                                            </ul>
                                    <div class="bottom-event">
                                    	<?php if($cs_event_meta->event_ticket_options <> ""){?> 
                                        	<?php if($cs_event_meta->event_buy_now <> ""){?> 
                                                 <a class="buy-ticket btn" <?php if($cs_event_meta->event_ticket_color <> ''){?>style="background-color: <?php echo $cs_event_meta->event_ticket_color;?>" <?php }?> href="<?php echo $cs_event_meta->event_buy_now;?>"><i class="fa fa-ticket"></i> <?php echo $cs_event_meta->event_ticket_options;?></a>
                                                <?php 
                                                } else {
                                                    ?> 
                                                 <span class="buy-ticket btn cs-bgcolr" <?php if($cs_event_meta->event_ticket_color <> ''){?>style="background-color: <?php echo $cs_event_meta->event_ticket_color;?>" <?php }?>><?php echo $cs_event_meta->event_ticket_options;?></span>
                                                <?php 
                                                }
                                        	?>
                                       
                                            <?php } 
											if(isset($cs_xmlObject->event_like) &&  $cs_xmlObject->event_like == "on"){
												$cs_like_counter = '';
												$cs_like_counter = get_post_meta(get_the_id(), "cs_like_counter", true);
												if ( !isset($cs_like_counter) or empty($cs_like_counter) ) $cs_like_counter = 0;
												if ( isset($_COOKIE["cs_like_counter".get_the_id()]) ) { 
												?>
												   <a class="btn buy-ticket liks"> <i class="fa fa-thumbs-up"></i> <?php if($cs_theme_option['trans_switcher']== "on"){ _e('Likes','WeStand');}else{ echo $cs_theme_option['trans_likes']; } ?><span><?php echo $cs_like_counter;?></span></a>
											<?php	
												} else {?>
												  <a  class="likethis btn buy-ticket liks" href="javascript:cs_like_counter('<?php echo get_template_directory_uri()?>',<?php echo get_the_id()?>)" id="like_this<?php echo get_the_id()?>" > <i class="fa fa-heart-o"></i>  <?php if($cs_theme_option['trans_switcher']== "on"){ _e('Likes','WeStand');}else{ echo $cs_theme_option['trans_likes']; } ?><span class="count-numbers like_counter<?php echo get_the_id()?>"><?php echo $cs_like_counter; ?></span></a>
													<a class="likes likethis btn buy-ticket liks" id="you_liked<?php echo get_the_id()?>" style="display:none;"><i class="fa fa-heart"></i> <?php if($cs_theme_option['trans_switcher']== "on"){ _e('Likes','WeStand');}else{ echo $cs_theme_option['trans_likes']; } ?><span class="count-numbers like_counter<?php echo get_the_id()?>"><?php echo $cs_like_counter; ?></span></a>
													<div id="loading_div<?php echo get_the_id()?>" style="display:none;"><i class="fa fa-spin"></i></div>
											
											<?php }
											}
											?> 
                                            <?php if(isset($cs_xmlObject->event_calendar) &&  $cs_xmlObject->event_calendar == "on"){
                                             			add_to_calender(); 
												}
											 ?>
                                            
                                      
                                    </div>
                                    </div>
                                </div>
                            <div class="detail_text rich_editor_text">
                                   <?php the_content();
					  				 wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'WeStand' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );?>
                            </div>
                            </article>
                            <!-- Post tags Section -->
							<?php 
								if ( $cs_xmlObject->event_tags == "on" ) {
                                    /* translators: used between list items, there is a space after the comma */
									$before_cat = "<div class='post-tags'><h6>".__('Tags','WeStand')."<i class='fa fa-tags'></i></h6>";
                                   // $before_cat = "<i class='fa fa-tags'></i>";
                                    $categories_list = get_the_term_list ( get_the_id(), 'event-tag', $before_cat, ' ', '</div>' );
                                    if ( $categories_list ){
                                        printf( __( '%1$s', 'WeStand'),$categories_list );
                                    } // End if categories 
								}
                                ?>
                            <!-- Post tags Section Close -->
                            <div class="share-post">
                            	<?php if(isset($cs_xmlObject->event_social_sharing) && $cs_xmlObject->event_social_sharing <> ''){cs_addthis_script_init_method();?>
                            				<a href="#" class="btnshare addthis_button_compact"><i class="fa fa-share-square-o"></i><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Share Now','WeStand');}else{ echo $cs_theme_option['trans_share_this_post']; } ?> </a>
                                <?php }?>
                                <?php if ( $cs_xmlObject->event_pagination == "on" ) {px_next_prev_custom_links('events'); }?>
                            </div>
                            <?php if (isset($cs_xmlObject->post_author_info_show) && $cs_xmlObject->post_author_info_show == "on"){?>
                            	<!-- About Author Section -->
                                <div class="about-author">
                                    <figure><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('PixFill_author_bio_avatar_size', 59)); ?></a></figure>
                                    <div class="text">
                                        <h4><?php echo get_the_author(); ?></h4>
                                        <p><?php the_author_meta('description'); ?></p>
                                        <?php if(get_the_author_meta('twitter') <> ''){?><a class="follow-tweet" href="http://twitter.com/<?php the_author_meta('twitter'); ?>"><i class="fa fa-twitter"></i>@<?php the_author_meta('twitter'); ?></a><?php }?>
                                    </div>
                                </div>
                            <!-- About Author Section Close -->
                          <?php }?>
                         	<?php comments_template('', true); ?>
                        </div>
                   </div>
            
                </div>
			<!-- layout End -->
				<?php if ( $cs_layout  == 'content-left col-md-9'){ ?>
                    <aside class="sidebar-right col-md-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_right) ) : ?><?php endif; ?></aside>
                <?php wp_reset_query();} ?>
<?php
    endwhile;
  get_footer(); ?>