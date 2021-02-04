<?php
get_header();
	global $cs_node, $cs_theme_option, $video_width;
	$cs_layout = '';
	$counter_events=1;
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
		$width = 270;
		$height = 270;
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
		$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
		if ( $cs_event_meta <> "" ) $cs_event_meta = new SimpleXMLElement($cs_event_meta);
	?>
		<!-- Event Detail Start -->
		<?php if ($cs_layout == 'content-right col-lg-9 col-md-9' || $cs_layout == 'col-lg-6 col-md-6'){ ?>
            <aside class="sidebar-left col-lg-3 col-md-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_left) ) : ?><?php endif; ?></aside>
        <?php } ?>
          <div class="<?php echo $cs_layout;?>">
          <!-- event detail -->
             <div class="eventdetail fullwidth">
                <article class="eventswrapp fullwidth">
                    <?php if($image_id <> ''){?>
                        <figure class="float-left">
                            <?php echo $image_id;?>
                        </figure>
                       <?php }?>
                    <div class="text">
                        <div class="track-info">
                            <div class="postpanel">
                                <ul class="post-options">
                                    <li>
                                    <?php if(isset($cs_xmlObject->event_rating) && $cs_xmlObject->event_rating <> ''){?>
                                        <div class="ratingbox">
                                            <?php for($i=1; $i<=5; $i++){?>
                                                    <a><em class="<?php if($i<=$cs_xmlObject->event_rating){ echo 'fa fa-star';} else { echo 'fa fa-star-o';}?>"></em></a>
                                             <?php }?>
                                       </div>
                                       <?php }?>
                                    </li>
                                    <li>
                                        <em><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Organizer','Rocky');}else{ echo $cs_theme_option['trans_event_organizer']; } ?>:<?php printf(__('%s','Rocky'),"") ?></em>
                                        <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="colrhover"> <?php echo get_the_author(); ?></a>
                                        
                                        
                                    </li>
                                     <?php 
                                        $before_cat = '<li>';
                                        $categories_list = get_the_term_list ( get_the_id(), 'event-category', $before_cat, ', ', '</li>' );
                                        if ( $categories_list ){ printf( __( '%1$s', 'Rocky' ),$categories_list ); }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <!-- Event desc -->
                            <div class="event-desc-list fullwidth">
                                <ul>
                                    <li class="days-remaining bgcolr">
                                  <?php 
								  		$days_to_go = "";
										$days_before = "";
										
										if($cs_theme_option['trans_switcher'] == "on"){ $days_to_go = _e('Days to go','Rocky');}else{ $days_to_go = $cs_theme_option['trans_event_days_to_go']; }
										if($cs_theme_option['trans_switcher'] == "on"){ $days_before = _e('Days Before','Rocky');}else{ $days_before = $cs_theme_option['trans_event_days_before']; }

                                        if(strtotime($cs_event_from_date) > strtotime(date('Y-m-d'))){
											echo cs_dateDiff(date('Y-m-d'), $cs_event_from_date).' '.$days_to_go;
                                        } else {
											echo cs_dateDiff($cs_event_from_date, date('Y-m-d')).' '.$days_before;
                                        }
                                    ?>
                                    <time datetime="<?php echo date('j, M Y', strtotime($cs_event_from_date));?>"><?php echo date('d.m.Y', strtotime($cs_event_from_date));?></time>
                                    </li>
                                    <li class="event-time"><h5><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Event Time','Rocky');}else{ echo $cs_theme_option['trans_event_time']; } ?></h5><time datetime="2011-01-12">
                                        <?php 
                                            if ( $cs_event_meta->event_all_day != "on" ) {
                                                echo $cs_event_meta->event_start_time; if($cs_event_meta->event_end_time <> ''){ echo " - ";  echo $cs_event_meta->event_end_time; }
                                            }else{
                                                _e("All",'Rocky') . printf( __("%s day",'Rocky'), ' ');
                                            }
                                        ?>
                                      </time></li>
                                    <li class="event-ticket"><h5><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Tickets','Rocky');}else{ echo $cs_theme_option['trans_event_tickets']; } ?></h5><h4><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('From:','Rocky');}else{ echo $cs_theme_option['trans_event_from']; } ?> <?php echo $cs_xmlObject->event_ticket_price;?></h4></li>
                                </ul>
                                    <span class="event-loca"><em class="fa fa-map-marker"></em> <?php echo $loc_address.' '. $loc_city.' '.$loc_country;?></span>
                            </div>
                        <!-- Event desc Close -->
                        <!-- Artist Standing -->
                            <div class="artist-standing fullwidth">
                                <?php if(count($cs_xmlObject->artists_list)>0){?><h5><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Artist Title','Rocky');}else{ echo $cs_theme_option['trans_event_artist_title']; } ?></h5><?php }?>
                                <?php if($cs_xmlObject->event_buy_now <> ''){?><a href="<?php echo $cs_xmlObject->event_buy_now;?>" class="btnticker"><em class="fa fa-ticket"></em> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Buy Ticket','Rocky');}else{ echo $cs_theme_option['trans_event_buy_ticket']; } ?></a><?php }?>
                                <ul>
                                <?php 
                                    $event_artists_array = array();
                                    foreach ( $cs_xmlObject->artists_list->artists as $val ) {
                                        $event_artists_array[] = (int)$val;
                                    }
                                    if(count($event_artists_array)>0){
                                    ?>
                                    <?php 
                                            $custom_query = new WP_Query( array( 'post_type' => 'artists', 'post__in' => $event_artists_array ) );
                                          if ( $custom_query->have_posts() <> "" ) {
                                            while ( $custom_query->have_posts() ): $custom_query->the_post();
                                             $image_url = cs_get_post_img_src( $post->ID,50,50 ); 
											 if($image_url <> ''){
                                            ?>
                                                <li><a><img src="<?php echo $image_url;?>" alt=""></a></li>
                                       <?php } endwhile; } wp_reset_query();}?>
                                </ul>
                            </div>
                        <!-- Artist Standing Close -->
                    </div>
                    <?php if($location <> "" && $event_loc_lat <> "" && $event_loc_long <>"" && $event_loc_long <> '' && $event_loc_zoom <> ''){?>
                    <div class="mapwrapper fullwidth">
                        <div class="mapcode fullwidth mapsection gmapwrapp" id="map_canvas<?php echo $post->ID; ?>" style="height:205px;"></div>
                            <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
                                <script type="text/javascript">
                                    jQuery(document).ready(function(){
                                        event_map("<?php echo $location ?>",<?php echo $event_loc_lat ?>,<?php echo $event_loc_long ?>,<?php echo $event_loc_zoom; ?>, <?php echo $post->ID; ?>);
                                    });
                                </script>
                    </div>
                    <?php } ?>
                </article>
                <div class="detail_text fullwidth">
                    <?php the_content();
								wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Rocky' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); 
								?>
                </div>
                <?php 
				$cs_event_gallery = get_post_meta($cs_xmlObject->event_gallery, "cs_meta_gallery_options", true);
				if ( $cs_event_gallery <> "" ) {
					cs_enqueue_masonry_style_script();
					cs_enqueue_gallery_style_script();
					$event_gallery_xml = new SimpleXMLElement($cs_event_gallery);
					$limit_start = 0;
					$limit_end = count($event_gallery_xml);
					$count_post = count($event_gallery_xml);
                    ?>
                	<div class="widget widget_gallery">
                        <header class="heading">
                            <h2 class="section-title cs-heading-color float-left colr"><?php echo get_the_title((int)$cs_xmlObject->event_gallery);?></h2>
                        </header>
                        <div class="gallerylist gal-three-col fullwidth lightbox">
                       <?php for ( $i = $limit_start; $i < $limit_end-1; $i++ ) {
                                $path = $event_gallery_xml->gallery[$i]->path;
                                $title = $event_gallery_xml->gallery[$i]->title;
                                $description = $event_gallery_xml->gallery[$i]->description;
                                $social_network = $event_gallery_xml->gallery[$i]->social_network;
                                $use_image_as = $event_gallery_xml->gallery[$i]->use_image_as;
                                $video_code = $event_gallery_xml->gallery[$i]->video_code;
                                $link_url = $event_gallery_xml->gallery[$i]->link_url;
                                $image_url = cs_attachment_image_src($path, 270, 152);
                                $image_url_full = cs_attachment_image_src($path, 0, 0);
                        ?>
                           <article>
                                <figure class=""><img alt="" src="<?php echo $image_url; ?>"><figcaption><a data-title="<?php echo $description;?>" href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" class="btnarrow" target="<?php if($use_image_as==2) echo '_blank'; ?>" data-rel="<?php if($use_image_as==1)echo "prettyPhoto";  elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>" ></a></figcaption></figure>
                                
                            </article>
                           <?php }?>
                        </div>
                    </div>
                    <?php }?>
                <div class="share_post fullwidth">
                    <div class="float-left sharing-section">
                        <?php
						$cs_share_now = ""; 
						if($cs_theme_option['trans_switcher'] == "on"){ $cs_share_now = __('Share Now','Rocky');}else{ $cs_share_now = $cs_theme_option['trans_share_this_post']; }
						if ($cs_xmlObject->event_social_sharing == "on"){
								echo '<a class="btn btnsharenow" ><em class="fa fa-share"> </em> '.$cs_share_now.'</a>';
								cs_social_share();
							} 
                        $before_cat = '<div class="tags-area"> <em class="fa fa-tags"></em>';
                        $categories_list = get_the_term_list ( get_the_id(), 'event-tag', $before_cat, ', ', '</div>' );
                        if ( $categories_list ){ printf( __( '%1$s', 'Rocky' ),$categories_list ); }
                        ?>
                        
                    </div>
                    <?php cs_next_prev_post();?>
                </div>
        <?php if (get_the_author_meta('description')) : ?>
                <!-- About Admin -->
                <div class="about-author fullwidth">
                    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="float-left"><?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('PixFill_author_bio_avatar_size', 63)); ?></a>
                    <div class="text">
                        <h4><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="colr"> <?php the_author_meta('display_name'); ?></a> <?php echo cs_get_user_role(); ?></h4>
                        <p>
                           <?php the_author_meta('description'); ?>
                        </p>
                        <?php if(get_the_author_meta('twitter') <> ''){?><a href="http://twitter.com/<?php the_author_meta('twitter'); ?>" class="btn tweet_follow"><em class="fa fa-twitter"></em> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Follow Us on Twitter','Rocky');}else{ echo $cs_theme_option['trans_follow_twitter']; } ?></a><?php }?>
                        <?php if(get_the_author_meta('url') <> ''){?><a href="<?php the_author_meta('url'); ?>" class="btn view_blog"><em class="fa fa-pencil"></em> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('View More Blogs','Rocky');}else{ echo $cs_theme_option['trans_view_more_blogs']; } ?></a><?php }?>
                    </div>
                    </div>
                    <?php endif; ?>
                </div>
             <?php comments_template('', true); ?>
		</div>
         <!--Right Sidebar Starts-->
		<?php if ( $cs_layout  == 'content-left col-lg-9 col-md-9' || $cs_layout  == 'col-lg-6 col-md-6' ){ ?>
            <aside class="sidebar-right col-lg-3 col-md-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_right) ) : ?><?php endif; ?></aside>
        <?php } ?>
        <!-- Event Detail End --> 
	<?php
    endwhile;
    $counter_events++;
  get_footer(); ?>