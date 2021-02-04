<?php
	global $cs_node,$post,$cs_theme_option,$counter_node,$wpdb;
	if ( !isset($cs_node->cs_event_per_page) || empty($cs_node->cs_event_per_page) ) { $cs_node->cs_event_per_page = -1; }
	if (isset($_GET['event_view']) && !empty($_GET['event_view']) && $_GET['event_view'] == 'calendar_view') {
         $cs_node->cs_event_view = 'Calendar View';
     } elseif (isset($_GET['event_view']) && !empty($_GET['event_view']) && $_GET['event_view'] == 'list_view') {
		 $cs_node->cs_event_view = 'List View';
	 }
	  $meta_compare = '';
        $filter_category = '';
        if ( $cs_node->cs_event_type == "Upcoming Events" ) $meta_compare = ">=";
        else if ( $cs_node->cs_event_type == "Past Events" ) $meta_compare = "<";
        $row_cat = $wpdb->get_row("SELECT * from ".$wpdb->prefix."terms WHERE slug = '" . $cs_node->cs_event_category ."'" );
        if ( isset($_GET['filter_category']) ) {$filter_category = $_GET['filter_category'];}
        else {
            if(isset($row_cat->slug)){
            $filter_category = $row_cat->slug;
            }
        }
		$counter_events = 0;
	if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
		if ( $cs_node->cs_event_type == "All Events" ) {
			$args = array(
				'posts_per_page'			=> "-1",
				'post_type'					=> 'events',
				'post_status'				=> 'publish',
				'orderby'					=> 'meta_value',
				'order'						=> 'ASC',
			);
		}
		else {
			$args = array(
				'posts_per_page'			=> "-1",
				'post_type'					=> 'events',
				'post_status'				=> 'publish',
				'meta_key'					=> 'cs_event_to_date',
				'meta_value'				=> date('Y-m-d'),
				'meta_compare'				=> $meta_compare,
				'orderby'					=> 'meta_value',
				'order'						=> 'ASC',
			);
		}
		if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
			$event_category_array = array('event-category' => "$filter_category");
			$args = array_merge($args, $event_category_array);
		}
		$custom_query = new WP_Query($args);
		$count_post = 0;
		$count_post = $custom_query->post_count;
		if ( $cs_node->cs_event_pagination == "Single Page") { $cs_node->cs_event_per_page = $cs_node->cs_event_per_page; }
	
					if ( $cs_node->cs_event_type == "Upcoming Events") {
						$args = array(
							'posts_per_page'			=> "$cs_node->cs_event_per_page",
							'paged'						=> $_GET['page_id_all'],
							'post_type'					=> 'events',
							'post_status'				=> 'publish',
							'meta_key'					=> 'cs_event_from_date',
							'meta_value'				=> date('Y-m-d'),
							'meta_compare'				=> ">=",
							'orderby'					=> 'meta_value',
							'order'						=> 'ASC',
						 );
					}else if ( $cs_node->cs_event_type == "All Events" ) {
						$args = array(
							'posts_per_page'			=> "$cs_node->cs_event_per_page",
							'paged'						=> $_GET['page_id_all'],
							'post_type'					=> 'events',
							'meta_key'					=> 'cs_event_from_date',
							'meta_value'				=> '',
							'post_status'				=> 'publish',
							'orderby'					=> 'meta_value',
							'order'						=> 'ASC',
						);
					}
					else {
						$args = array(
							'posts_per_page'			=> "$cs_node->cs_event_per_page",
							'paged'						=> $_GET['page_id_all'],
							'post_type'					=> 'events',
							'post_status'				=> 'publish',
							'meta_key'					=> 'cs_event_from_date',
							'meta_value'				=> date('Y-m-d'),
							'meta_compare'				=> $meta_compare,
							'orderby'					=> 'meta_value',
							'order'						=> 'ASC',
						 );
					}
					if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
						$event_category_array = array('event-category' => "$filter_category");
						$args = array_merge($args, $event_category_array);
					}
					$custom_query = new WP_Query($args);
					if ( $custom_query->have_posts() <> "" ){?>
                    <?php
					$cs_event_class = "event-view-1";
					if($cs_node->cs_event_view == "List View 2"){
						$cs_event_class = "event-view-2";
					}
					?>
                    <div class=" element_size_<?php echo $cs_node->event_element_size;?>">
                    <?php if($cs_node->cs_event_view != "Calendar View"){ ?>
                    <div class="event <?php echo $cs_event_class; ?>">
                    <?php } ?>
                    <?php
					if($cs_node->cs_event_view == "Calendar View") {
					?>
					<header class="cs-heading-title">
						 <?php if ($cs_node->cs_event_title <> ''){?><h2 class="cs-section-title cs-heading-color"><?php echo $cs_node->cs_event_title; ?></h2><?php  } ?>
					 </header>
					 <?php
							while ($custom_query->have_posts()): $custom_query->the_post();
										$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
										$event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
										$cs_event_to_date = get_post_meta($post->ID, "cs_event_to_date", true); 
										if ($cs_event_meta <> "") {
											$cs_event_meta = new SimpleXMLElement($cs_event_meta);
										}
										 if ( $cs_event_meta->event_all_day != "on" ) {
											 $allday=false;
										 } else { 
										 	$allday=true;
										 }
										 if($cs_event_meta->event_ticket_options == "Free"){
											$event_class = 'cs-free';
										} else if($cs_event_meta->event_ticket_options == "Cancelled"){
											$event_class = 'cs-cancel';
										} else if($cs_event_meta->event_ticket_options == "Full Booked"){
											$event_class = 'cs-fullbook';
										} else {
											$event_class = 'cs-buynow';
										}
								 	$aaa[] = array(
												'title' => substr(get_the_title(), 0, 35) . '....',
												'start' => date("Y-m-d", strtotime($event_from_date)),
												'end' => date("Y-m-d", strtotime($cs_event_to_date)),
												'class' => $event_class,
												//'allDay' => $allday,
												'url' => get_permalink()
											);
							$counter_events++;
                    		endwhile;	
							cs_calender_enqueue_scripts();
							 ?>		
							  <script type='text/javascript'>
                                jQuery(document).ready(function($) {
                                    var date = new Date();
                                    var d = date.getDate();
                                    var m = date.getMonth();
                                    var y = date.getFullYear();
                                    
                                    jQuery('#calendar').fullCalendar({
                                        header: {
                                            left: 'prev,next today',
                                            center: 'title',
                                            right: 'month,agendaWeek,agendaDay'
                                        },
                                        editable: true,
                                        eventMouseover: function(calEvent, domEvent) {
                                            var thistxt = $(this) .html();
                                            jQuery('body') .append("<div class='wrappertooltip'><span class='innertooltip'>"+ thistxt +"</span></div>");
                                            var x =jQuery(this) .offset().left;
                                            var y =jQuery(this) .offset().top;
                                            var xw = jQuery(".wrappertooltip") .outerWidth();
                                            var xh = jQuery(".wrappertooltip") .outerHeight();
                                            jQuery(".wrappertooltip") .css({"top":y,"left":x,"margin-left":-xw/2,"margin-top":-(xh)});
                                        },
                                        eventMouseout: function(calEvent, domEvent) {
                                            jQuery(".wrappertooltip") .remove();	
                                        }, 
                                        disableResizing:true,
                                        disableDragging : true,
                                        events: <?php echo json_encode($aaa); ?>
                                    });
                                 });
                                </script>
                                   <!-- Calender Protected Start -->
                                    <div class="calendar">
                                        <div id='calendar'></div>
                                    </div>
                                   <!-- Calender Protected End -->
			<?php	} else {
						?>
                        <script type="text/javascript">
							jQuery(document).ready(function($){
								// Add Tag Last child Script
								cs_add_class_last_child();
								// Add Tag Last child Script
							});
						</script>
                        <?php
                        if($cs_node->cs_event_view != "List View 2"){
						?>
						<div class="event">
                        <?php } ?>
                        <header class="cs-heading-title">
                        <?php if ($cs_node->cs_event_title <> ''){?><h2 class="cs-section-title cs-heading-color"><?php echo $cs_node->cs_event_title; ?></h2><?php  } ?>
                        <?php if($cs_node->cs_event_filterables == "Yes" && $cs_node->cs_event_view != "Calendar View"){
                                $qrystr= "";
                                if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
                            ?>  
                            <div class="sortby">
                                <ul>
                                    <li><a href="<?php the_permalink();?>"><?php _e('All', 'Spikes');?></a></li>
                                    <?php
                                        if(isset($cs_node->cs_event_category) && $cs_node->cs_event_category <> '' && $cs_node->cs_event_category <> '0'){
                                            $categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'event-category', 'hide_empty' => 0) );
                                        } else {
                                            $categories = get_categories( array('taxonomy' => 'event-category', 'hide_empty' => 0) );
                                        }
                                        foreach ($categories as $category) {
                                    ?>
                                        <li <?php if($category->slug==$filter_category){echo 'class="active"';}?>><a href="?<?php echo $qrystr."&filter_category=".$category->slug?>"><?php echo $category->cat_name?></a></li>
                                       <?php }?>
                                </ul>
                            </div>
                            <?php }?>
                        </header>
    				<?php 
						echo '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>';
						$width = 150; 
						$height = 150;
						$counter_events = 0;
						while ( $custom_query->have_posts() ): $custom_query->the_post();
							$counter_events++;
							$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
							if ( $cs_event_meta <> "" ) {
								$cs_event_meta = new SimpleXMLElement($cs_event_meta);
								if($cs_event_meta->event_address <> ''){
									$address_map = get_the_title("$cs_event_meta->event_address");	
								}else{
									$address_map = '';
								}
							}
							$cs_event_loc = get_post_meta($cs_event_meta->event_address, "cs_event_loc_meta", true);
							if ( $cs_event_loc <> "" ) {
								$cs_xmlObject = new SimpleXMLElement($cs_event_loc);
								$loc_address = $cs_xmlObject->loc_address;
								$event_loc_lat = $cs_xmlObject->event_loc_lat;
								$event_loc_long = $cs_xmlObject->event_loc_long;
								$event_loc_zoom = $cs_xmlObject->event_loc_zoom;
								$loc_city = $cs_xmlObject->loc_city;
								$loc_postcode = $cs_xmlObject->loc_postcode;
								$loc_country = $cs_xmlObject->loc_country;
								
							} else {
								$loc_address = '';
								$event_loc_lat = '';
								$event_loc_long = '';
								$event_loc_zoom = '';
								$loc_city = '';
								$loc_postcode = '';
								$loc_country = '';
							}
							$location = $noimg = '';
							if($loc_address <> ''){
								$location .=$loc_address;
							} else if($loc_city <> ''){
								$location .= ' '.$loc_city;
							} else if($loc_postcode <> ''){
								$location .= ' '.$loc_postcode;
							} else if($loc_country <> ''){
								$location .= ' '.$loc_country;
							}
							$event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
							$image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID),$width,$height ); 
								if($image_url == ''){
									$noimg = 'no-img';
								}else{
									$noimg  ='';
								}
					?>
                                <article <?php post_class($noimg);?>>
                                <div class="event-inn">
                                <?php
								if($cs_node->cs_event_view != "List View 2"){
								?>
                                <figure>
                                    <a href="<?php the_permalink();?>"><?php if($image_url <> ''){?><img src="<?php echo $image_url;?>" alt=""><?php }?></a>
                                </figure>
                                <?php
								}if($cs_node->cs_event_view == "List View 2"){
								?>
                                	<figure>
                                    	<span><?php echo date('d M',strtotime($event_from_date));?></span>
                                        <time><?php echo date('Y',strtotime($event_from_date));?></time>
                                    </figure>
                                 <?php
								}
								 ?>
                                    <div class="text <?php if($cs_event_meta->event_ticket_options == "Cancelled"){?>cs-main-cancel<?php } ?>">
                                        <h2 class="cs-post-title cs-heading-color"><a class="colrhover" href="<?php the_permalink();?>"><?php echo substr(get_the_title(), '0', '40');if(strlen(get_the_title())>40){ echo '...';} ?></a></h2>
                                       <ul>
									   <?php if($cs_event_meta->event_ticket_options <> '' and $cs_node->cs_event_view <> "List View 2"){?> 
                                       <li>
                                        	<?php if($cs_event_meta->event_ticket_options == "Buy Now"){?> 
                                            <a class="cs-buynow" href="<?php echo $cs_event_meta->event_buy_now;?>"><i class="fa fa-ticket"></i><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Buy Ticket','Spikes');}else{ echo $cs_theme_option['trans_event_buy_ticket']; } ?></a>
                                            <?php } ?>
                                            <?php if($cs_event_meta->event_ticket_options == "Free"){?> 
                                            <a class="cs-free"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Free Entry','Spikes');}else{ echo $cs_theme_option['trans_event_free_entry']; } ?></a>
                                            <?php } ?>
                                            <?php if($cs_event_meta->event_ticket_options == "Cancelled"){?> 
                                            <a class="cs-cancel" ><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Cancelled','Spikes');}else{ echo $cs_theme_option['trans_event_cancelled']; } ?></a>
                                            <?php } ?>
                                            <?php if($cs_event_meta->event_ticket_options == "Full Booked"){?> 
                                            <a class="cs-fullbook" ></i><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Sold Out','Spikes');}else{ echo $cs_theme_option['trans_event_sold_out']; } ?></a>
                                            <?php } ?>
                                        </li>
                                        <?php }
										if($cs_node->cs_event_view == "List View 2" and $cs_xmlObject->loc_address <> ""){
										?>
                                        <li>
										<?php 
                                        echo "<i class='fa fa-map-marker'></i>".$cs_xmlObject->loc_address;
                                        ?>
                                        </li>
                                        <?php
										}
                                        ?>
                                            <li><i class='fa fa-clock-o'></i><?php echo date('l d.m.Y',strtotime($event_from_date));?>,
                                              <?php 
											  if ( $cs_node->cs_event_time == "Yes" ) {
												if ( $cs_event_meta->event_all_day != "on" ) {
													echo $cs_event_meta->event_start_time; if($cs_event_meta->event_end_time <> ''){ echo "-";  echo $cs_event_meta->event_end_time; }
												}else{
													_e("All",'Spikes') . printf( __("%s day",'Spikes'), ' ');
												}
											  }
											?></li>
                                        </ul>
                                        <?php
										if($cs_node->cs_event_view != "List View 2"){
										?>
                                       <?php if($event_loc_lat <> ""  && $event_loc_long <> '' && $cs_event_meta->event_map == 'on'){?> <a class="map-marker" onclick="show_mapp('<?php echo $post->ID; ?>', '<?php echo $address_map;?>', '<?php echo $event_loc_lat;?>', '<?php echo $event_loc_long;?>', '<?php echo $event_loc_zoom;?>', '<?php echo home_url() ?>','<?php echo get_template_directory_uri() ?>')"><i class="fa fa-map-marker fa-2x"></i></a><?php }?>	
                                       <?php
										}else{
                                       if($cs_event_meta->event_ticket_options <> ''){?> 
                                       
                                        	<?php if($cs_event_meta->event_ticket_options == "Buy Now"){?> 
                                            <a class="cs-buynow" href="<?php echo $cs_event_meta->event_buy_now;?>"><i class="fa fa-ticket"></i><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Buy Ticket','Spikes');}else{ echo $cs_theme_option['trans_event_buy_ticket']; } ?></a>
                                            <?php } ?>
                                            <?php if($cs_event_meta->event_ticket_options == "Free"){?> 
                                            <a class="cs-free"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Free Entry','Spikes');}else{ echo $cs_theme_option['trans_event_free_entry']; } ?></a>
                                            <?php } ?>
                                            <?php if($cs_event_meta->event_ticket_options == "Cancelled"){?> 
                                            <a class="cs-cancel" ><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Cancelled','Spikes');}else{ echo $cs_theme_option['trans_event_cancelled']; } ?></a>
                                            <?php } ?>
                                            <?php if($cs_event_meta->event_ticket_options == "Full Booked"){?> 
                                            <a class="cs-fullbook" ></i><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Sold Out','Spikes');}else{ echo $cs_theme_option['trans_event_sold_out']; } ?></a>
                                            <?php } ?>
                                        
                                        <?php }
                                       
										}
									   ?>
                                    </div>
                                </div>
                                <?php 
								 $cs_map_show = false;
								   if($cs_event_meta->event_map == 'on'){
									   $cs_map_show =true;
								   }
								   if($event_loc_lat <> ""  && $event_loc_long <> '' && $cs_event_meta->event_map == 'on'){
								?>

                                <div class="event-map post-<?php echo $post->ID;?>" id="">
                                	<div class="mapcode fullwidth mapsection gmapwrapp" id="map_canvas<?php echo $post->ID; ?>" style="height:182px; width:100%;"></div>
										
                                    <!-- Map Caption Start -->
                                    <div class="map-caption">
                                        <ul>
                                           <?php if($location <> ''){?> <li><i class="fa fa-map-marker"></i><?php echo $location;?></li><?php }?>
                                            <?php if($cs_event_meta->event_phone_no <> ''){?> <li><i class="fa fa-phone"></i><?php echo $cs_event_meta->event_phone_no;?></li><?php }?>
                                        </ul>
                                      
                                    </div>
                                    <!-- Map Caption End -->
                                </div>
                                <?php }?>
                            </article>
			    <?php endwhile;
					$qrystr = '';
					if(cs_pagination($count_post, $cs_node->cs_event_per_page, $qrystr) <> ''){
						// pagination start
						if ( $cs_node->cs_event_pagination == "Show Pagination" and $cs_node->cs_event_per_page < $count_post ) {
								if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
								if ( isset($_GET['filter_category']) ) $qrystr .= "&filter_category=".$_GET['filter_category'];
								echo cs_pagination($count_post, $cs_node->cs_event_per_page, $qrystr);
							}
						// pagination end
					}
				echo '</div>';
				}  ?>
            <?php if($cs_node->cs_event_view != "Calendar View" and $cs_node->cs_event_view != "List View 2"){ ?>
            </div>
            <?php } ?>
            </div>
	 <?php } else { ?>
    	<h2><?php _e('No results found.', "Spikes") ?></h2>
    <?php  }?>
	