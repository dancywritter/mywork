<?php
get_header();
	global $cs_node, $cs_theme_option, $video_width;
	$cs_layout = '';
	$counter_events=1;
	cs_event_countdown_scripts();
if ( have_posts() ) while ( have_posts() ) : the_post();
 	$post_xml = get_post_meta($post->ID, "cs_event_meta", true);	
	if ( $post_xml <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($post_xml);
  		$cs_layout = $cs_xmlObject->sidebar_layout->cs_layout;
		$cs_sidebar_left = $cs_xmlObject->sidebar_layout->cs_sidebar_left;
		$cs_sidebar_right = $cs_xmlObject->sidebar_layout->cs_sidebar_right;
		$event_social_sharing = $cs_xmlObject->event_social_sharing;
		$event_address = $cs_xmlObject->event_address;
		$inside_event_map = $cs_xmlObject->event_map;
/*		$width = 420;
		$height = 400;*/
		$width = 314;
		$height = 314;
		$image_id = cs_get_post_img($post->ID, $width,$height);
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
  	}else{
		$event_social_sharing = '';
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
	$location = '';
	if($loc_address <> ''){
		$location .=$loc_address;
	} else if($loc_city <> ''){
		$location .= ' '.$loc_city;
	} else if($loc_postcode <> ''){
		$location .= ' '.$loc_postcode;
	} else if($loc_country <> ''){
		$location .= ' '.$loc_country;
	}
	$cs_event_to_date = get_post_meta($post->ID, "cs_event_to_date", true); 
	$cs_event_from_date = get_post_meta($post->ID, "cs_event_from_date", true); 
	$year_event = date("Y", strtotime($cs_event_from_date));
	$month_event = date("m", strtotime($cs_event_from_date));
	$month_event_c = date("M", strtotime($cs_event_from_date));							
	$date_event_day = date("d", strtotime($cs_event_from_date));
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
		$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
		if ( $cs_event_meta <> "" ) $cs_event_meta = new SimpleXMLElement($cs_event_meta);
	?>
		 
          <!-- Col-Md-12 Start -->
                <div class="col-md-12">
                    <div class="header_element">
                     <?php if($location <> "" && $event_loc_lat <> "" && $event_loc_long <>"" && $event_loc_long <> '' && $event_loc_zoom <> ''){?>
                            <div class="mapcode fullwidth mapsection gmapwrapp" id="map_canvas<?php echo $post->ID; ?>" style="height:248px; width:100%;"></div>
                                <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
                                    <script type="text/javascript">
                                        jQuery(document).ready(function(){
                                            event_map("<?php echo $location ?>",<?php echo $event_loc_lat ?>,<?php echo $event_loc_long ?>,<?php echo $event_loc_zoom; ?>, <?php echo $post->ID; ?>);
                                        });
                                    </script>
                        <?php } ?>
                    </div>
                    <!-- Event Detail Start -->
                    <div class="event-detail">
                        <!-- Detail Content Left Start -->
                        <?php if($image_id <> ''){?>
                            <article class="detail-cont-left">
                                <figure><a><?php echo $image_id;?></a></figure>
                            </article>
                        <?php }?>
                        <script type="text/javascript">
							jQuery(document).ready(function($){
								cs_map_toggle();
							});
						</script>
                        <!-- Detail Content Left End -->
                        <!-- Detail Content Right Start -->
                        <article class="detail-cont-right <?php if(empty($image_id) || $image_id == ''){ echo ' cs_fullwidth';}?>">
                            <div class="read-loc webkit">
                                <ul>
                                	<?php
									  /* translators: used between list items, there is a space after the comma */
									  $before_cat = '<li><i class="fa fa-list"></i>';
									  $categories_list = get_the_term_list ( get_the_id(), 'event-category', $before_cat, ', ', '</li>' );
									  if ( $categories_list ){
										  printf( __( '%1$s', 'Spikes'),$categories_list );
									  }
									?>
                                    <li>
                                    <?php if($cs_event_from_date <> ""){ ?>
                                    <i class="fa fa-calendar"></i><?php echo date("d.m.Y l", strtotime($cs_event_from_date));?>
                                    <?php } ?>
                                    <?php if ( $cs_event_meta->event_all_day != "on" ) {
										echo $cs_event_meta->event_start_time; if($cs_event_meta->event_end_time <> ''){ echo "-";  echo $cs_event_meta->event_end_time; }
									}else{
										_e("All",'Spikes') . printf( __("%s day",'Spikes'), ' ');
									}
									?>
                                    </li>
                                    <?php if($location <> ""){ ?>
                                    <li><i class="fa fa-map-marker"></i><?php echo $location;?></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <script>
                                //Countdown callback function
                                jQuery(function () {
                                var austDay = new Date();
                                austDay = new Date(<?php echo date("Y", strtotime($cs_event_from_date));?>,<?php echo date("m", strtotime($cs_event_from_date))-1;?>,<?php echo date("d", strtotime($cs_event_from_date));?>);
                                jQuery('#defaultCountdown').countdown({until: austDay});
                                jQuery('#year').text(austDay.getFullYear());
                                }); 
                            </script>
                             <?php
									$cs_like_counter = '';
									$cs_like_counter = get_post_meta(get_the_id(), "cs_like_counter", true);
									if ( !isset($cs_like_counter) or empty($cs_like_counter) ) $cs_like_counter = 0;
								?>
                            <!-- Icons Section Start -->
                            <div class="icons-sec">
                                    <div class="countdownit"><div id="defaultCountdown"></div></div>
                                    <div class="detail-sec">
                                        <ul>
                                        	<li><i class="fa fa-users fa-1x"></i><p> <span class="like_counter<?php echo $post->ID;?>"><?php echo $cs_like_counter;?></span> <?php if($cs_theme_option['trans_switcher']== "on"){ _e('Coming','Spikes');}else{ echo $cs_theme_option['trans_event_coming']; } ?></p></li>
                                            
                                            <li>
                                            <?php
                                        $cs_like_counter = '';
                                        $cs_like_counter = get_post_meta(get_the_id(), "cs_like_counter", true);
                                        if ( isset($_COOKIE["cs_like_counter".get_the_id()]) ) { 
                                    ?>
                                           <i class="fa fa-thumbs-o-up fa-1x"></i><p><a class="likes"><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Thanks for joining','Spikes');}else{ echo $cs_theme_option['trans_event_thanks']; } ?></a></p>
                                    <?php	
                                        } else {?>
                                          <p><a href="javascript:cs_like_counter('<?php echo get_template_directory_uri()?>',<?php echo get_the_id()?>)" id="like_this<?php echo get_the_id()?>"><i class="fa fa-thumbs-o-up fa-1x"></i><?php if($cs_theme_option['trans_switcher']== "on"){ _e('i am Joining','Spikes');}else{ echo $cs_theme_option['trans_event_joining']; } ?> </a>
                                            <a class="likes" id="you_liked<?php echo get_the_id()?>" style="display:none;"><i class="fa fa-thumbs-o-up fa-1x"></i><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Thanks for joining','Spikes');}else{ echo $cs_theme_option['trans_event_thanks']; } ?> </a>
                                            <div id="loading_div<?php echo get_the_id()?>" style="display:none;" ><img src="<?php echo get_template_directory_uri()?>/images/ajax-loader.gif" alt="" /></div>
                                         </p>
                                    <?php }?>
                                    </li>
                                    <?php if($cs_event_meta->event_ticket_options <> ''){?> 
                                               <li>
                                                    <?php if($cs_event_meta->event_ticket_options == "Buy Now"){?> 
                                                    <a class="cs-buynow" href="<?php echo $cs_event_meta->event_buy_now;?>"><i class="fa fa-ticket fa-1x"></i><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Buy Ticket','Spikes');}else{ echo $cs_theme_option['trans_event_buy_ticket']; } ?></a>
                                                    <?php } ?>
                                                    <?php if($cs_event_meta->event_ticket_options == "Free"){?> 
                                                    <a class="cs-free" href="<?php echo $cs_event_meta->event_buy_now;?>"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Free Entry','Spikes');}else{ echo $cs_theme_option['trans_event_free_entry']; } ?></a>
                                                    <?php } ?>
                                                    <?php if($cs_event_meta->event_ticket_options == "Cancelled"){?> 
                                                    <a class="cs-cancel"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Cancelled','Spikes');}else{ echo $cs_theme_option['trans_event_cancelled']; } ?></a>
                                                    <?php } ?>
                                                    <?php if($cs_event_meta->event_ticket_options == "Full Booked"){?> 
                                                    <a class="cs-fullbook" href="<?php echo $cs_event_meta->event_buy_now;?>"></i><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Sold Out','Spikes');}else{ echo $cs_theme_option['trans_event_sold_out']; } ?></a>
                                                    <?php } ?>
                                                </li>
											<?php }?>
                                    
                                        </ul>
                                    </div>
                            </div>
                            <!-- Icons Section End -->
                        </article>
                        <!-- Detail Content Right End -->
                    </div>
                    <!-- Event Detail End -->
                    <!-- Detail Text Strat -->
                    <div class="detail_text rich_editor_text">
                       <?php 
					   		the_content();
					   		wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Spikes' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
					   ?>
                    </div>
                    <!-- Detail Text End -->
                    <!-- Share Post Start -->
                    <div class="share_post">
						<?php 
						if($cs_xmlObject->event_social_sharing == 'on') { cs_social_share();}
                        $before_cat = '<div class="tagcloud">';
                        $categories_list = get_the_term_list ( get_the_id(), 'event-tag', $before_cat, ', ', '</div>' );
                        if ( $categories_list ){ printf( __( '%1$s', 'Spikes' ),$categories_list ); }
                        ?>
                        <div class="right-sec">
                           <?php 
                           
                            cs_next_prev_post();
                            ?>
                        </div>
                    </div>
                    <!-- Share Post End -->
                    <!-- About Author Start -->
                    <?php 
							if (get_the_author_meta('description')){ ?>
                     			<div class="about-author">
                                     <figure><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="float-left"><?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('PixFill_author_bio_avatar_size', 80)); ?></a></figure>
                                     <div class="text">
                                        <h2 class="cs-post-title cs-heading-color"><a class="colrhover" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author_meta('nicename'); ?></a></h2>
                                        <p><?php the_author_meta('description'); ?></p>
                                        <?php if(get_the_author_meta('twitter') <> ''){?><a class="follow-tweet" href="http://twitter.com/<?php the_author_meta('twitter'); ?>"><i class="fa fa-twitter"></i>@<?php the_author_meta('twitter'); ?></a><?php }?>
                                    </div>
                              	</div>
                                <!-- About Author End -->
                        	<?php } ?>
                    <!-- About Author End -->
                    <?php 
				$cs_event_gallery = get_post_meta($cs_xmlObject->event_gallery, "cs_meta_gallery_options", true);
				if ( $cs_event_gallery <> "" ) {
					 $gallery_event_count = 0;
					 cs_cycleslider_script();
					cs_enqueue_gallery_style_script();
					$event_gallery_xml = new SimpleXMLElement($cs_event_gallery);
					$limit_start = 0;
					$limit_end = count($event_gallery_xml->gallery);
					$count_post = count($event_gallery_xml->gallery);
                    ?>
                    <!-- Gig Images Start -->
                    <div class="gig-images">
                        <header class="cs-heading-title"><h2 class="cs-section-title cs-heading-color"><?php echo get_the_title((int)$cs_xmlObject->event_gallery);?></h2></header>
                        <div class="center">
                            <a id="prev3" href="#" class="prev-btn bordercolr colr backcolrhover"><i class="fa fa-angle-left fa-1x"></i></a>
                            <a id="next3" href="#" class="next-btn bordercolr colr backcolrhover"><i class="fa fa-angle-right fa-1x"></i></a>
                        </div>
                        <div class="cycle-slideshow"
                            data-cycle-timeout=4000
                            data-cycle-fx="carousel"
                            data-cycle-slides="div"
                            data-cycle-carousel-fluid="false"
                            data-allow-wrap="true"
                                data-cycle-next="#next3"
                                data-cycle-prev="#prev3">
                                 <?php
								 $count_gal = 0;
								 for ( $i = $limit_start; $i < $limit_end-1; $i++ ) {
									 		$count_gal++;
											$path = $event_gallery_xml->gallery[$i]->path;
											$title = $event_gallery_xml->gallery[$i]->title;
											$description = $event_gallery_xml->gallery[$i]->description;
											$social_network = $event_gallery_xml->gallery[$i]->social_network;
											$use_image_as = $event_gallery_xml->gallery[$i]->use_image_as;
											$video_code = $event_gallery_xml->gallery[$i]->video_code;
											$link_url = $event_gallery_xml->gallery[$i]->link_url;
											$image_url_full = cs_attachment_image_src($path, 0, 0);
											$image_url = cs_attachment_image_src($path, 314, 314);
											if($count_gal == '1'){
											} else {
												$image_url = cs_attachment_image_src($path, 150, 150);
												if($count_gal%2 == '0'){echo '<div>';}
												?>
                                                 	<figure><a><img src="<?php echo $image_url;?>" alt=""></a>
                                                        <figcaption>
                                                        	  <a class="backcolr webkit" data-rel="<?php if($use_image_as==1)echo "prettyPhoto";  elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>" href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" target="<?php if($use_image_as==2) echo '_blank'; ?>" data-title="<?php if ( $description <> "" ) { echo $description; }?>" rel="prettyPhoto"><i class="fa fa-plus-circle fa-2x"></i></a>
                                                         </figcaption>
                                                    </figure>
                                                <?php
												if($count_gal%2 <> '0' || $count_gal==$count_post){echo '</div>';}
											}			
									}
								?>
                        </div>
                    </div>
                    <!-- Gig Images End -->
                    <?php }?>
                     <?php comments_template('', true); ?>
                </div>
            <!-- Col-Md-12 End -->
	<?php
    endwhile;
    $counter_events++;
  get_footer();