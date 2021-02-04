<?php
get_header();
	global $px_node, $px_theme_option, $px_event_meta;
	$px_layout = '';
	$px_counter_events=1;
 while ( have_posts() ) : the_post();
 	$post_xml = get_post_meta($post->ID, "px_event_meta", true);	
	if ( $post_xml <> "" ) {
		$px_event_meta = new SimpleXMLElement($post_xml);
		$px_layout = $px_event_meta->sidebar_layout->px_layout;
		if ( $px_layout == "left") {
			$px_layout = "col-md-9";
		}
		else if ( $px_layout == "right" ) {
			$px_layout = "col-md-9";
		}
		else {
			$px_layout = "col-md-12";
		}
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
		$width = 272;
		$height = 272;
		$image_url = px_get_post_img_src($post->ID, $width, $height);
		px_enqueue_countdown_script();
	?>
    <?php if ( $px_event_meta->sidebar_layout->px_layout <> '' and $px_event_meta->sidebar_layout->px_layout <> "none" and $px_event_meta->sidebar_layout->px_layout == 'left') : ?>
                <aside class="col-md-3">
                        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($px_event_meta->sidebar_layout->px_sidebar_left) ) : endif; ?>
                 </aside>
        <?php wp_reset_query(); endif; ?>
     <div class="<?php echo $px_layout;?>">
     
     	<div class="event-detail">
            <div class="detail-inner">
            <?php if($px_event_from_date <> ''){?>
                <time class="event-time" id="defaultCountdown"></time>
                <script>
				   jQuery(document).ready(function($) {
						px_event_countdown('<?php echo $year_event;?>','<?php echo $month_event;?>','<?php echo $date_event;?>');
					});
				</script>
                <?php }?>
                <h1 class="pix-page-title"><?php the_title();?></h1>
                <ul class="pix-post-options">
                    <li>
                    <?php if($px_theme_option['trans_switcher'] == "on"){ $listed_in = __('in','Deejay');}else{ $listed_in = $px_theme_option['trans_listed_in']; } ?>
                    <?php
					
                            $before_tag = '<span class="pix-categories"><span>'.$listed_in.' </span>';
                            $tags_list = get_the_term_list ( get_the_id(), 'event-category',$before_tag, ', ', '</span>' );
                            if ( $tags_list){
                                printf( __( '%1$s', 'Deejay'),$tags_list ); 
                            } // End if tags 
                        ?>
                        <?php if($px_event_from_date <> ''){?>
                        <span><?php if($px_theme_option['trans_switcher'] == "on"){ _e('Posted on','Deejay');}else{ echo $px_theme_option['trans_posted_on']; } ?> </span>	
                     <time>
						<?php echo date_i18n(get_option('date_format'), strtotime($px_event_from_date));?>, 
                        <?php 
                            if ( $px_event_meta->event_all_day != "on" ) {
                                echo $px_event_meta->event_start_time; if($px_event_meta->event_end_time <> ''){ echo "- ";  echo $px_event_meta->event_end_time; }
                            }else{
                                _e("All",'Deejay') . printf( __("%s day",'Deejay'), ' ');
                            }
                        ?>
                     </time>,<?php }?></li>
                   <?php if($px_event_meta->event_address <> ''){?> <li><span>@</span><?php echo get_the_title((int) $px_event_meta->event_address);?></li><?php }?>
                </ul>
                <ul class="post-pannel">
                	<?php 
						if ($px_event_meta->event_social_sharing == "on"){
							px_social_share();
						  }
					?>
                    <?php if($px_event_meta->event_ticket_options <> ''){?> 
                            <li><a <?php if(isset($px_event_meta->event_ticket_color) && $px_event_meta->event_ticket_color <> ''){?>style=" background-color: <?php echo $px_event_meta->event_ticket_color;?>"<?php }?> class="likethis" href="<?php echo $px_event_meta->event_buy_now;?>"> <?php if(isset($px_event_meta->event_ticket_options) && $px_event_meta->event_ticket_options <> ''){echo $px_event_meta->event_ticket_options;}?></a></li>
                        <?php }?>
                    <?php  if($inside_event_map == "on" && $px_event_meta->event_address <> '' && $event_loc_lat <> '' && $event_loc_long <> ''){?>
                    			<li><a class="map-marker" onclick="show_mapp('<?php echo $post->ID; ?>', '<?php echo addslashes($loc_address.'<br>'.$loc_city.'<br>'.$loc_postcode); ?>', '<?php echo $event_loc_lat;?>', '<?php echo $event_loc_long;?>', '<?php echo $event_loc_zoom;?>', '<?php echo home_url() ?>','<?php echo get_template_directory_uri() ?>')"><i class="fa fa-map-marker"></i></a></li>
                    <?php }?>
                </ul>
            </div>
                    <div class="detail-text rich_editor_text">
                    <?php 
                        if($inside_event_map == "on" && $px_event_meta->event_address <> '' && $event_loc_lat <> '' && $event_loc_long <> ''){	
                     ?>
                     <div class="post-<?php echo $post->ID;?>" id="event-map" style="width:100%; float:left;">
                     	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
                                <div class="mapcode fullwidth mapsection gmapwrapp" id="map_canvas<?php echo $post->ID; ?>" style="height:140px; width:100%; float:left;"></div>
                               
                                <!-- Map Caption End -->
                            </div>
                    
                    <?php }?>
                    <?php if($image_url <> ''){?><figure class="detail-figure"><img src="<?php echo $image_url;?>" alt="#"></figure><?php }?>
                    <?php 
                        the_content();
                        wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Deejay' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                    ?>
                    </div>
                    <div class="share-post">
						<?php
                         
                          $before_tag = '<div class="post-tags"><i class="fa fa-tag"></i>';
                            $tags_list = get_the_term_list ( get_the_id(), 'event-tag',$before_tag, ', ', '</div>' );
                            if ( $tags_list){
                                printf( __( '%1$s', 'Deejay'),$tags_list ); 
                            } // End if tags 
							
							px_next_prev_custom_links('events');
                          ?>
                      </div>
                     <?php
					 if(isset($px_event_meta->var_pb_event_author) && $px_event_meta->var_pb_event_author <> ''){
						px_author_description();
					 }
					 
					 comments_template('', true);?>  
                    </div>
			 </div>
			<?php
            if ( $px_event_meta->sidebar_layout->px_layout <> '' and $px_event_meta->sidebar_layout->px_layout <> "none" and $px_event_meta->sidebar_layout->px_layout == 'right') : ?>
                <aside class="col-md-3">
                        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($px_event_meta->sidebar_layout->px_sidebar_right) ) : endif; ?>
                 </aside>
            <?php 
            wp_reset_query();
            endif;	
	
	endwhile;
	get_footer();