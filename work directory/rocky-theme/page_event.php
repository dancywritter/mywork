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
	?>
    <div class="element_size_<?php echo $cs_node->event_element_size;?> cs_event_page">
		<div class="events fullwidth">
        		 <?php if($cs_node->cs_event_view=='Calendar View'){
                           			if ($cs_node->cs_event_type == "All Events") {
								$args = array(
									'posts_per_page' => "-1",
									'post_type' => 'events',
									'event-category' => "$filter_category",
									'post_status' => 'publish',
									'orderby' => 'meta_value',
									'order' => 'ASC',
								);
							} else {
								$args = array(
									'posts_per_page' => "-1",
									'post_type' => 'events',
									'event-category' => "$filter_category",
									'post_status' => 'publish',
									'meta_key' => 'cs_event_to_date',
									'meta_value' => date('Y-m-d'),
									'meta_compare' => $meta_compare,
									'orderby' => 'meta_value',
									'order' => 'ASC',
								);
							}
							$custom_query = new WP_Query($args);
								if ($custom_query->have_posts() <> "") {
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
								 	$aaa[] = array(
												'title' => substr(get_the_title(), 0, 35) . '....',
												'start' => date("Y-m-d", strtotime($event_from_date)),
												'end' => date("Y-m-d", strtotime($cs_event_to_date)),
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
                                 <?php } else { ?>
                                    <h2><?php _e('No results found.', "Rocky") ?></h2>
                                	<?php 
                                        }
                           	 } else {
								 
						if(is_home() || is_front_page()){	
							if ($cs_node->cs_event_title <> '') { echo '<h2 class="section-title cs-heading-color">'.$cs_node->cs_event_title.'</h2>';}
						} else {
						?>
                       	<div class="fullwidth title-album <?php if($cs_node->cs_event_filterables != "Yes"){ echo 'cs_filterable_hide';}?>">
                           <header class="heading-2">
                           		<?php
									if ($cs_node->cs_event_title <> '') { ?>
										<h2 class="section-title cs-heading-color"><?php echo $cs_node->cs_event_title; ?></h2>
								<?php  } ?>
                           </header>
                          
 								<?php if($cs_node->cs_event_filterables == "Yes"){
								$qrystr= "";
								if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
							?>  
                            <script>
								function reload(form){
									var val=filterable_event.event_category.options[filterable_event.event_category.options.selectedIndex].value; 
									if(val){
										self.location = val;
									}
								}
							</script>
                            <form id="filterable_event" name="filterable_event" method="get" action="">
                               <select class="float-right" name="event_category"  onChange="javascript:reload();">
                                   <option value="">  
                                       <?php   
                                        if ($cs_theme_option['trans_switcher'] == "on") {
                                            _e('Sort By', "Rocky");
                                        } else {
                                            echo $cs_theme_option['trans_filter_by'];
                                        }?>
                                     </option>
                                     <?php if(isset($cs_node->cs_event_category) && $cs_node->cs_event_category <> '' && $row_cat->slug <> ''){?>
                                     	<option value="?<?php echo $qrystr."&filter_category=".$row_cat->slug?>" <?php if($cs_node->cs_event_category==$filter_category){echo 'selected="selected"';}?>><?php echo $row_cat->name;?></option>
                                   <?php
									 }	
									 	if($cs_node->cs_event_category <> ''){
                                        	$categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'event-category', 'hide_empty' => 0) );
										} else {
											$categories = get_categories( array('taxonomy' => 'event-category', 'hide_empty' => 0) );
										}
                                        foreach ($categories as $category) {
                                    ?>
                                         <option value="?<?php echo $qrystr."&filter_category=".$category->slug?>" <?php if($category->slug==$filter_category){echo 'selected="selected"';}?>><?php echo $category->cat_name?></option>
                                      <?php 
                                        } 
                                    ?>
                               </select>
                               </form>
                              <?php }?>
                       </div>
                       <?php }?>
                       <div class="<?php if ($cs_node->cs_event_view == "List View"){ echo 'eventsection';} else { echo 'events-grid';}?> fullwidth">
                        <?php
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
								if ( $cs_node->cs_event_pagination == "Single Page") { $cs_node->cs_event_per_page = $cs_node->cs_event_per_page; }?>
									
									<?php 
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
													'order'						=> 'DESC',
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
											$width = 270; 
											$height = 152;
											if ( $custom_query->have_posts() <> "" ) {
												if ($cs_node->cs_event_view == "List View") {
												echo '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>';													
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
														
													}
													else {
														$loc_address = '';
														$event_loc_lat = '';
														$event_loc_long = '';
														$event_loc_zoom = '';
														$loc_city = '';
														$loc_postcode = '';
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
													$event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
													$image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID),$width,$height ); 
														if($image_url == ''){
															$noimg = 'no-img';
														}else{
															$noimg  ='';
														}
													?>
                                                               <!-- List Article -->                       
                                                               <article <?php post_class($noimg); ?>>
                                                               	<div class="event-inn">
																	<?php if ( $image_url <> "" ) {?>
                                                                       <figure class="bgcolr">
                                                                        <img src="<?php echo $image_url?>" alt="" />                                                                       <!-- Image List -->                                                                       <!-- Figcaption With date -->                       
                                                                           <figcaption>
                                                                               <a class="btnarrow" href="<?php the_permalink();?>"></a>
                                                                               <time datetime="<?php echo date('M',strtotime($event_from_date));?>"><?php echo date('d',strtotime($event_from_date));?> <strong> <?php echo date('M',strtotime($event_from_date));?></strong></time>
                                                                           </figcaption>
                                                                       </figure>
                                                                      <?php }?>
                                                                       <!-- list Desc Strat -->                       
                                                                       <div class="text">
                                                                           <h2 class="post-title">
                                                                               <a class="colrhover" href="<?php the_permalink();?>"><?php echo substr(get_the_title(), '0', '40');if(strlen(get_the_title())>40){ echo '...';} ?></a>
                                                                           </h2>
                                                                           <div class="bottompanel">
                                                                               <time datetime="<?php echo date('d.m.Y',strtotime($event_from_date));?>">
                                                                                <?php 
                                                                                    if ( $cs_event_meta->event_all_day != "on" ) {
                                                                                        echo $cs_event_meta->event_start_time; if($cs_event_meta->event_end_time <> ''){ echo "-";  echo $cs_event_meta->event_end_time; }
                                                                                    }else{
                                                                                        _e("All",'Rocky') . printf( __("%s day",'Rocky'), ' ');
                                                                                    }
                                                                                ?>
                                                                               </time>
                                                                               <?php if($address_map <> "" && $event_loc_lat <> ""  && $event_loc_long <> ''){?>
                                                                                   <span class="locaddress">
                                                                                       <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Location','Rocky');}else{ echo $cs_theme_option['trans_event_location']; } ?> <strong><?php echo $location;?></strong>
                                                                                   </span>
                                                                                 <?php }?> 
                                                                           </div>
                                                                           <?php 
                                                                           
                                                                           $cs_map_show = false;
                                                                           if($cs_event_meta->event_map == 'on'){
                                                                               $cs_map_show =true;
                                                                           }
                                                                           ?>
                                                                                       <div class="event-panel <?php if($cs_event_meta->event_map !='on' or $cs_event_meta->event_buy_now == ''){ echo 'cs_full_event_panel'; }?>">
                                                                                           <?php if($cs_event_meta->event_buy_now <> ''){?><a class="btnlocation colrhover" href="<?php echo $cs_event_meta->event_buy_now;?>"> <em class="fa fa-tags"></em> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Buy Ticket','Rocky');}else{ echo $cs_theme_option['trans_event_buy_ticket']; } ?> </a><?php }?>
                                                                                           <?php if($event_loc_lat <> ""  && $event_loc_long <> '' && $cs_event_meta->event_map == 'on'){?><a class="btnlocation iconticker colrhover"> <em class="fa fa-map-marker"></em> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Location','Rocky');}else{ echo $cs_theme_option['trans_event_location']; } ?></a><?php }?> 
                                                                                       </div>
                                                                                
                                                                       </div>
                                                                  </div> 
                                                                   <?php if($address_map <> "" && $event_loc_lat <> ""  && $event_loc_long <> '' && $cs_map_show == true){?>
                                                                        <div class="mapareawrapper fullwidth">
                                                                            
                                                                            <div class="mapcode fullwidth mapsection gmapwrapp" id="map_canvas<?php echo $post->ID; ?>" style="height:200px;"></div>
                                                                            <script type="text/javascript">
                                                                                jQuery(document).ready(function(){
                                                                                    event_map("<?php echo $location;?>",<?php echo $event_loc_lat ?>,<?php echo $event_loc_long ?>,<?php echo $event_loc_zoom; ?>, <?php echo $post->ID; ?>);
                                                                                });
                                                                            </script>
                                                                            
                                                                        </div> 
                                                                    <?php }?> 
                                                                    <!-- List Desc Close --> 
                                                                 </article>
                                                               <!-- List Article Close -->                       
                                                    <?php	
													endwhile;
													} elseif ($cs_node->cs_event_view == "Grid View"){
														
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
														
													}
													else {
														$loc_address = '';
														$event_loc_lat = '';
														$event_loc_long = '';
														$event_loc_zoom = '';
														$loc_city = '';
														$loc_postcode = '';
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
													$event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
													$image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID),$width,$height ); 
														if($image_url == ''){
															$noimg = 'no-img';
														}else{
															$noimg  ='';
														}
														?>
														
														<article>
                                                            <div class="wrappgrid">
                                                            	<?php if($image_url <> ''){?>
                                                                        <figure class="bgcolr">
                                                                            <img src="<?php echo $image_url?>" alt="" />
                                                                            <figcaption><a href="<?php the_permalink();?>" class="btnarrow"></a></figcaption>
                                                                        </figure>
                                                                <?php }?>
                                                                <div class="text">
                                                                    <div class="topgrid">
                                                                    <h2 class="post-title"><a href="<?php the_permalink();?>" class="colrhover"><?php echo substr(get_the_title(), '0', '40');if(strlen(get_the_title()>40)) echo '...'; ?></a></h2>
                                                                    <time><?php echo date('d.m.Y',strtotime($event_from_date)).', ';?> 
                                                                    	<?php 
                                                                                if ( $cs_event_meta->event_all_day != "on" ) {
                                                                                    echo $cs_event_meta->event_start_time; if($cs_event_meta->event_end_time <> ''){ echo " - ";  echo $cs_event_meta->event_end_time; }
                                                                                }else{
                                                                                    _e("All",'Rocky') . printf( __("%s day",'Rocky'), ' ');
                                                                                }
                                                                            ?>
                                                                       </time>
                                                                    </div>
                                                                    <?php if($address_map <> "" && $event_loc_lat <> ""  && $event_loc_long <> '' && $cs_event_meta->event_map == 'on'){?>
                                                                    <div class="bottomgrid">
                                                                    <a class="btnmapmarker" href="<?php the_permalink();?>#map_canvas<?php echo $post->ID; ?>">
                                                                       <em class="fa fa-map-marker"></em></a>
                                                                        <p><?php echo $location;?></p>
                                                                    </div>
                                                                    <?php }?> 
                                                                </div>
                                                            </div>
                                                            
                                                            <?php if($cs_event_meta->event_buy_now <> ''){?><a href="<?php echo $cs_event_meta->event_buy_now;?>" class="btnbuytickets"><em class="fa fa-tags"></em> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Buy Ticket','Rocky');}else{ echo $cs_theme_option['trans_event_buy_ticket']; } ?></a><?php }?>
                                                        </article>
													<?php endwhile;
														}
														
                                                        } ?>
                                                  </div> 
                                               <!-- Event Close -->
						<?php
					wp_reset_query();
					if (($cs_node->cs_event_view == "List View" || $cs_node->cs_event_view == 'Grid View') ) {
						$qrystr = '';
						if(cs_pagination($count_post, $cs_node->cs_event_per_page, $qrystr) <> ''){
							// pagination start
							if ( $cs_node->cs_event_pagination == "Show Pagination" and $cs_node->cs_event_per_page > 0 ) {
									if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
									if ( isset($_GET['filter_category']) ) $qrystr .= "&filter_category=".$_GET['filter_category'];
									echo cs_pagination($count_post, $cs_node->cs_event_per_page, $qrystr);
								}
							// pagination end
						}
					}
					
					}
					?>
         </div>
	</div>