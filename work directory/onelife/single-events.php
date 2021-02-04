<?php
get_header();
	global $cs_node, $cs_theme_option, $cs_video_width;
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
		$event_address = $cs_xmlObject->event_address;
		$cs_sidebar_left = $cs_xmlObject->sidebar_layout->cs_sidebar_left;
		$cs_sidebar_right = $cs_xmlObject->sidebar_layout->cs_sidebar_right;
		$post_view = $cs_xmlObject->inside_event_thumb_view;
		$post_video = $cs_xmlObject->inside_event_thumb_video;
		$post_audio = $cs_xmlObject->inside_event_thumb_audio;
		$post_slider = $cs_xmlObject->inside_event_thumb_slider;
		$post_slider_type = $cs_xmlObject->inside_event_thumb_slider_type;
		$inside_event_related_post_title = $cs_xmlObject->inside_event_related_post_title;
		$inside_event_map = $cs_xmlObject->event_map;
		$cs_video_width = 301;
		if ( $cs_layout == "left") {
			$cs_layout = "content-right span9";
 		}
		else if ( $cs_layout == "right" ) {
			$cs_layout = "content-left span9";
 		}elseif( $cs_layout == "both_right" ){
			$cs_layout = "content-left span6";
		}
		elseif( $cs_layout == "both_left" ){
			$cs_layout = "content-right span6";
		}
		elseif( $cs_layout == "both" ){
			$cs_layout = "span6";
		}
		else {
			$cs_layout = "span12";
		}
  	}else{
		$event_social_sharing = '';
		$cs_xmlObject->event_related = '';
		$inside_event_thumb_view = '';
		$inside_event_featured_image_as_thumbnail = '';
		$inside_event_thumb_audio = '';
		$inside_event_thumb_video = '';
		$inside_event_thumb_slider = '';
		$inside_event_thumb_slider_type = '';
		$inside_event_related_post_title = '';
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
	?>
<!-- Event Detail Start -->

<div class="eventdetail">
	<!-- Map Section Start -->
    <?php 
	if($inside_event_map == "on"){
		if($address_map <> "" && $event_loc_lat <> "" && $event_loc_long <>"" && $event_loc_long <> '' && $event_loc_zoom <> ''){?>
			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script> 
			<script type="text/javascript">
			jQuery(document).ready(function(){
				event_map("<?php echo $loc_address.'<br>'.$loc_city.'<br>'.$loc_postcode.'<br>'.$loc_country  ?>",<?php echo $event_loc_lat ?>,<?php echo $event_loc_long ?>,<?php echo $event_loc_zoom ?>,<?php echo $post->ID; ?>);
			});
			</script>
			<div class="qoute parallaxbg webkit event-detail-parallax">
				<div class="webkit map_sec event_map ">
					<div id="map_canvas<?php echo $post->ID; ?>" style="width: 100%; height:379px" class="event-map show-map"></div>
				 </div>
			</div>
		<?php }
	}?>
    <!-- Map Section End --> 
  <!-- Container Start -->
     <div class="container"> 
        <!-- Row Start -->
        <div class="row">
            <!-- Span12 Start -->
            <div class="span12">
				<?php
					$width 	= 301;
					$height = 169;
					$image_id = cs_get_post_img( $post->ID,$width,$height );
				?>
              	<article class="<?php if(isset($image_id) && $image_id == ''){echo "no-image";} ?>" <?php if($inside_event_map == ""){ echo 'id="hide-event-map"';} ?> >
	              	<?php 
						$width 	= 301;
						$height = 169;
						$image_id = cs_get_post_img( $post->ID,$width,$height ); 
						if(isset($image_id) && $image_id <> ''){
					?>
	                    <figure><?php echo '<a>'.$image_id.'</a>';?></figure>
	                <?php }?>
	                <div class="text">
	                	<div class="eventcont">
                        	<ul>
                                <li>
                                    <span><i class="icon-map-marker"></i><?php 
                                    if ($cs_theme_option['trans_switcher'] == "on") {
                                        _e('Event Location', "OneLife");
                                    } else {
                                        echo $cs_theme_option['trans_event_location'];
                                    }
                                    ?></span>
                                    <p><?php echo $loc_address.' '.$loc_city.' '.$loc_country  ?></p>
                                </li>
                                <li>
                                    <span><i class="icon-time"></i><?php 
                                        if ($cs_theme_option['trans_switcher'] == "on") {
                                            _e('Event Date', "OneLife");
                                        } else {
                                            echo $cs_theme_option['trans_event_date'];
                                        }
                                        ?></span>
                                    <p><?php echo date('l d M, Y', strtotime($cs_event_from_date)).', ';
										 if ( $cs_event_meta->event_all_day != "on" ) {
                                        	echo $cs_event_meta->event_start_time; if($cs_event_meta->event_end_time <> ''){ echo " - ";  echo $cs_event_meta->event_end_time; }
										}else{
											_e("All",'OneLife') . printf( __("%s day",'OneLife'), ' ');
										}
									
									?></p>
                                </li>
                                <li>
                                 <?php
									$cs_event_from_date = get_post_meta(get_the_id(), "cs_event_from_date", true);
									$cs_event_meta = get_post_meta(get_the_id(), "cs_event_meta", true);
									$year_event = date("Y", strtotime($cs_event_from_date));
									$month_event = date("m", strtotime($cs_event_from_date));
									$month_event_c = date("M", strtotime($cs_event_from_date));
									$date_event = date("d", strtotime($cs_event_from_date));
									if ($cs_event_meta <> "") {
										$cs_event_meta = new SimpleXMLElement($cs_event_meta);
									}
									if ($cs_event_meta->event_all_day == '') {
										$time_left = date("H,i,s", strtotime("$cs_event_meta->event_start_time"));
									} else {
										$time_left = date("H,i,s", strtotime(12, 00));
									}
								
									if (strtotime($cs_event_from_date) > strtotime(date('Y-m-d'))) {
										$current_gtm = get_option('gmt_offset');
									cs_countdown_enqueue_scripts();
									?>
									<script type="text/javascript">
										jQuery(function($) {
											var austDay = new Date();
											austDay = new Date(<?php echo $year_event; ?>, <?php echo $month_event; ?> - 1, <?php echo $date_event; ?>,<?php echo $time_left ?>);
											console.log(austDay);
											$('#defaultCountdown<?php echo get_the_id(); ?>').countdown({timezone: <?php echo $current_gtm; ?>, until: austDay});
											$('#year').text(austDay.getFullYear());
										});
									</script>
                                    
                                        <div class="countdownit">
                                            <h6 class="uppercase"><?php if ($cs_theme_option['trans_switcher'] == "on") {_e('Event Countdown', "OneLife");} else {echo $cs_theme_option['trans_event_countdown'];} ?></h6>
                                            <div id="defaultCountdown<?php echo get_the_id(); ?>"></div>
                                        </div>
                                    
                                  <?php } ?>
                                  </li>
                            </ul>
                        </div>
                    <!-- Event Admin Start -->
                    <div class="eventadmin">
                        <div class="post-thumb">
                            <p><?php if ($cs_theme_option['trans_switcher'] == "on") {_e('Organizer', "OneLife");} else {echo $cs_theme_option['trans_event_organizer'];} ?> <a class="colrhover" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"> <?php echo get_the_author(); ?></a></p>
                        </div>
                        <ul class="post-options">
                            <?php 
                                 $before_cat ='';
                                 $categories_list = get_the_term_list ( get_the_id(), 'event-category', $before_cat, ', ', '' );
                                 if($categories_list){
                            ?>
	                            <li>
	                                <i class="icon-reorder"></i>
	                               <?php
	                                 /* translators: used between list items, there is a space after the comma */
	                                if ( $categories_list ): printf( __( '%1$s', 'OneLife'),$categories_list ); endif;  
	                                  ?>
	                            </li>
                          	<?php }?>
                        </ul>
                    </div>
                    <!-- Event Admin End -->
                </div>
            </article>
             <!-- Article End -->
            </div>
            <!-- Span12 End -->
            <div class="clear"></div>
             <?php if ($cs_layout == 'content-right span9' || $cs_layout == 'span6'){ ?>
                <aside class="sidebar-left span3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_left) ) : ?><?php endif; ?></aside>
           	 <?php } ?>
            	<!-- Content Start -->
            	<div class="<?php if(isset($cs_layout)) echo $cs_layout;?>"> 
					<div class="postlist blogdetail">
                    	<div class="detail_text">
                        <!-- Detail Text Start -->
                        	<?php the_content(); ?>
                        </div>
                        
                        <!-- Post Media attachment-->
                        <?php cs_get_media_attachment();?>
                        
                        <!-- Post Media attachment end-->
                        <?php
						$before_cat ='';
						 $tags_list = get_the_term_list ( $post->ID, 'event-tag', $before_cat, ' ', '' );
						 if ( $tags_list ){
						?>
                        <!-- Widget Tag Cloud Start -->
                        <div class="widget_tag_cloud">
                            <h6><?php _e('Post', "OneLife"). ' ' . _e('Tags', "OneLife"); ?></h6>
                            <div class="tagcloud">
                            	<?php 
									 /* translators: used between list items, there is a space after the comma */
                                     if ( $tags_list ): printf( __( '%1$s', 'OneLife'),$tags_list ); endif;
								?>
                            </div>
                        </div>
                        <!-- Widget Tag Cloud End -->
                        <?php }?>
                        <!-- Post Change Section Start -->
                        <?php cs_next_prev_post($cs_xmlObject->event_social_sharing);?>
						
                        <!-- Post Change Section End -->
                        <!-- Related Posts Starts -->
                     <?php if ($cs_xmlObject->event_related == "on") {
					
                                $custom_taxterms='';
                            	$custom_taxterms = wp_get_object_terms( $post->ID, array('event-category','event-tag'), array('fields' => 'ids') );
                                // arguments
                                $args = array(
								'post_type' => 'events',
								'post_status' => 'publish',
								'posts_per_page' => -1, // you may edit this number
								'orderby' => 'DESC',
								'tax_query' => array(
								  array(
									  'taxonomy' => 'event-tag',
									  'field' => 'id',
									  'terms' => $custom_taxterms
								  ),
								  array(
									  'taxonomy' => 'event-category',
									  'field' => 'id',
									  'terms' => $custom_taxterms
								  )
								),
								'post__not_in' => array ($post->ID),
								); 
                            	$custom_query = new WP_Query($args);
                                if($custom_query->have_posts()):
						 
						  ?>
                	<div class="detailcarousel portfoliopage related-events">
                    	<?php cs_enqueue_jcycle_script(); ?>
                        	<h2 class="heading-color section-title"><?php echo $cs_xmlObject->inside_event_related_post_title; ?></h2>
                        	<div class="cycle-slideshow"
                            data-cycle-timeout=4000
                            data-cycle-fx=carousel
                            data-cycle-carousel-visible=4
                            data-cycle-slides="article"
                                data-cycle-next="#next2"
                                data-cycle-prev="#prev2">
								
                               <?php
                                while ($custom_query->have_posts()) : $custom_query->the_post();
								$width 	= 301;
                                $height = 169;
								$image_id = cs_get_post_img( $post->ID,$width,$height ); 
									if($image_id == ''){
										$noimg = 'no-img';
									}else{
										$noimg  ='';
									}
                                ?>
                                <!-- List Post Start -->
                                <article <?php post_class($noimg); ?> >
                                <!-- Blog Post Thumbnail Start -->
                               <?php
									if ( $image_id <> "" ) {
										echo '<figure><a href="'.get_permalink().'">'.$image_id.'</a><figcaption class="backcolr"></figcaption></figure>';
									}
								  ?>
                                <!-- Text Start -->
                                <div class="text">
                                    <span><a href="<?php the_permalink();?>"><?php echo substr(get_the_title(), '0', '35'); if(strlen(get_the_title())>35){ echo '...';} ?></a></span>
									<?php 
                                     $before_cat ='';
                                     $categories_list = get_the_term_list ( get_the_id(), 'event-category', $before_cat, ', ', '' );
                                     if($categories_list){
                               			 ?>
                                        <p><i class="icon-reorder"></i>
                                       <?php
                                         /* translators: used between list items, there is a space after the comma */
                                        if ( $categories_list ): printf( __( '%1$s', 'OneLife'),$categories_list ); endif;  
                                          ?>
                                    </p>
                                  <?php }?>
                                 </div>
                                <!-- Text End -->                            
                                </article>
                                <!-- Blog Post End -->
                                <?php
                                endwhile; 
                                ?>
                             
                              </div>
                            <div class=center>
                                <a href="#" id="prev2"><i class="icon-chevron-left"></i></a>
                                <a href="#" id="next2"><i class="icon-chevron-right"></i></a>
                            </div>
                        </div>
              	<?php endif; } wp_reset_query();?>
            	<!-- Related Posts End -->
                         <?php if (get_the_author_meta('description')) : ?>
                        <!-- About Author Start -->
						<div class="about-author">
							<figure>
                            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('PixFill_author_bio_avatar_size', 91)); ?></a>
                        	</figure>
                            <div class="text">
                            	 <h6><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="colrhover"> <?php echo get_the_author(); ?></a></h6>
                                <p><?php the_author_meta('description'); ?></p>
                                <a class="twitter_btn" href="http://twitter.com/<?php the_author_meta('twitter'); ?>"><i class="icon-twitter"></i><?php if($cs_theme_option['trans_switcher']== "on"){ echo _e('Follow Us on Twitter','Onelife');}else{ echo $cs_theme_option['trans_follow_twitter'];} ?></a>
                            </div>
                        </div>
                        <?php endif; ?>
                        <!-- About Author End -->
                        <!-- Comments Start -->
                        <?php comments_template('', true); ?>
                        <!-- Comments End -->
                    </div>
              </div>
              <!--Right Sidebar Starts-->
            <?php if ( $cs_layout  == 'content-left span9' || $cs_layout  == 'span6' ){ ?>
                <aside class="sidebar-right span3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_right) ) : ?><?php endif; ?></aside>
            <?php } ?>
            </div>
        <!-- Row End -->
    </div>
<!-- Container End -->
</div>
<!-- EventDetail End -->

<?php
endwhile;
$cs_counter_events++;
get_footer(); ?>
