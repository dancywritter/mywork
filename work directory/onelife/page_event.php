<?php
	global $cs_node,$post,$cs_theme_option,$cs_counter_node,$wpdb;
    cs_enqueue_jcycle_script();
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
		$cs_counter_events = 0;
	?>
 	<div class="event element_size_<?php echo $cs_node->event_element_size;?>">
    <!-- Event List Start -->


    	<header class="heading">
 	<?php
    	if ($cs_node->cs_event_title <> '') { ?>
	      	<h2 class="heading-color section-title"><?php echo $cs_node->cs_event_title; ?></h2>
    <?php } ?>
       	</header>
     <?php  if($cs_node->cs_event_filterables == "Yes" && !empty($filter_category)){?> 
              <!-- Filter Nav Start -->
                <div class="filter_nav">
                  <ul class="splitter">
                     <?php 
                    $qrystr= "";
                    if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
						?>   
						<li class="filter <?php if($filter_category==$row_cat->slug || empty($filter_category)) echo "active"; ?>" >
						<a href="?<?php echo $qrystr."&filter_category=".$row_cat->slug?>"><?php _e("All",'OneLife');?></a></li>
						<?php
							$categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'event-category', 'hide_empty' => 0) );
							foreach ($categories as $category) {
						?>
							<li class="filter <?php if($filter_category==$category->slug) echo "active"; ?>" ><a href="?<?php echo $qrystr."&filter_category=".$category->slug?>" onclick="this.form.submit()" ><?php echo $category->cat_name?></a></li>
					<?php }?>
              </ul>
            </div>
            <!-- Filter Nav End -->
		<?php }?>
         <?php
        if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
            if ( $cs_node->cs_event_type == "All Events" ) {
                $args = array(
                    'posts_per_page'			=> "-1",
                    'post_type'					=> 'events',
                    'event-category'			=> "$filter_category",
                    'post_status'				=> 'publish',
                    'orderby'					=> 'meta_value',
                    'order'						=> 'ASC',
                );
            }
            else {
                $args = array(
                    'posts_per_page'			=> "-1",
                    'post_type'					=> 'events',
                    'event-category'			=> "$filter_category",
                    'post_status'				=> 'publish',
                    'meta_key'					=> 'cs_event_to_date',
                    'meta_value'				=> date('Y-m-d'),
                    'meta_compare'				=> $meta_compare,
                    'orderby'					=> 'meta_value',
                    'order'						=> 'ASC',
                );
            }
            $custom_query = new WP_Query($args);
			//echo $custom_query->post_count();
            $count_post = 0;
            while ( $custom_query->have_posts()) : $custom_query->the_post();
                $count_post++;
            endwhile; wp_reset_query();		
            if ( $cs_node->cs_event_pagination == "Single Page") { $cs_node->cs_event_per_page = $cs_node->cs_event_per_page; }?>
                
                <?php 
 						if ( $cs_node->cs_event_type == "Upcoming Events") {
                            $args = array(
                                'posts_per_page'			=> "$cs_node->cs_event_per_page",
								'paged'						=> $_GET['page_id_all'],
                                'post_type'					=> 'events',
                                'event-category'			=> "$filter_category",
                                'post_status'				=> 'publish',
                                'meta_key'					=> 'cs_event_from_date',
                                'meta_value'				=> date('Y-m-d'),
                                'meta_compare'				=> $meta_compare,
                                'orderby'					=> 'meta_value',
                                'order'						=> 'ASC',
                             );
						}else if ( $cs_node->cs_event_type == "All Events" ) {
                            $args = array(
                                'posts_per_page'			=> "$cs_node->cs_event_per_page",
                                'paged'						=> $_GET['page_id_all'],
                                'post_type'					=> 'events',
                                'event-category'			=> "$filter_category",
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
                                'event-category'			=> "$filter_category",
                                'post_status'				=> 'publish',
                                'meta_key'					=> 'cs_event_from_date',
                                'meta_value'				=> date('Y-m-d'),
                                'meta_compare'				=> $meta_compare,
                                'orderby'					=> 'meta_value',
                                'order'						=> 'ASC',
                             );
                        }
  						$custom_query = new WP_Query($args);
						$width = 301;
						$height = 169;
					if ($cs_node->cs_event_view == "List View" && $cs_node->cs_event_view <> 'Calendar View') {
						echo '<div class="eventlist">';
							
                       	if ( $custom_query->have_posts() <> "" ) {
							$cs_counter_events = 0;
							while ( $custom_query->have_posts() ): $custom_query->the_post();
								$cs_counter_events++;
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
									$loc_city = '';
									$loc_country = '';
									$event_loc_lat = '';
									$event_loc_long = '';
									$event_loc_zoom = '';
							 	}
   								$event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
								
  								 $image_id = cs_get_post_img( $post->ID,$width,$height ); 
									if($image_id == ''){
										$noimg = 'no-img';
									}else{
										$noimg  ='';
									}
								?>
                                	<!-- Article Start -->
                                <article <?php post_class($noimg); ?>>
                                    <!-- Event Content Start -->
                                    <div class="eventcont"> 
                                    	<?php
											if ( $image_id <> "" ) {
												echo '<figure><a href="'.get_permalink().'">'.$image_id.'</a><figcaption class="backcolr"></figcaption></figure>';
											}
                                          ?>	
                                        <div class="text">
                                            <h2 class="heading-color post-title"><a href="<?php the_permalink();?>" class="colrhover"><?php the_title(); ?></a></h2>
                                            <ul>
                                            
                                                <li>
                                                    <span><i class="icon-map-marker"></i><?php 
														if ($cs_theme_option['trans_switcher'] == "on") {
															_e('Event Location', "OneLife");
														} else {
															echo $cs_theme_option['trans_event_location'];
														}
														?></span>
                                                    <p><?php echo $loc_address.''.$loc_city.' '.$loc_country  ?></p>
                                                </li>
                                                 <?php if($cs_node->cs_event_time == 'Yes'){?>
                                                <li>
                                                    <span><i class="icon-time"></i><?php 
														if ($cs_theme_option['trans_switcher'] == "on") {
															_e('Event Timing', "OneLife");
														} else {
															echo $cs_theme_option['trans_event_date'];
														}
														?></span>
                                                    <p>
                                                    <?php 
														$cs_event_from_date = get_post_meta(get_the_id(), "cs_event_from_date", true);
														echo date('l d M, Y', strtotime($cs_event_from_date)).', ';
                                                        if ( $cs_event_meta->event_all_day != "on" ) {
                                                            echo $cs_event_meta->event_start_time; if($cs_event_meta->event_end_time <> ''){ echo " - ";  echo $cs_event_meta->event_end_time; }
                                                        }else{
                                                            _e("All",'OneLife') . printf( __("%s day",'OneLife'), ' ');
                                                        }
                                                    ?>
                                                   </p>
                                                </li>
                                                <?php }?>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- Event Content End -->
                                    <!-- Event Admin Start -->
                                    <div class="eventadmin">
                                        <div class="post-thumb">
                                        	<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('PixFill_author_bio_avatar_size', 57)); ?></a>
                                            <p><?php if ($cs_theme_option['trans_switcher'] == "on") {_e('Organizer', "OneLife");} else {echo $cs_theme_option['trans_event_organizer'];} ?> <a class="colrhover" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"> <?php echo get_the_author(); ?></a></p>
                                        </div>
                                        <ul class="post-options">
                                        	<?php 
												 $before_cat ='<li>';
                                                 $categories_list = get_the_term_list ( get_the_id(), 'event-category', $before_cat, ',</li><li>', '' );
												 if($categories_list){
											?>
                                                   
                                                        <li><i class="icon-reorder"></i></li>
                                                       <?php
															 /* translators: used between list items, there is a space after the comma */
															if ( $categories_list ): printf( __( '%1$s', 'OneLife'),$categories_list ); endif;  
														?>
                                                   </li>
                                                  <?php }?>
                                        </ul>
                                        <div class="showicons showicons<?php echo $post->ID;?>" style="display:none;">
                                            <div class="social-network webkit">
                                                <?php cs_social_share(); ?>
                                            </div>
                                            <div class="share_link webkit">
                                                <p><?php
                                                    if ($cs_theme_option['trans_switcher'] == "on") {
                                                        _e('Share This Post', "OneLife");
                                                    } else {
                                                        echo $cs_theme_option['trans_share_this_post'];
                                                    }
                                                    ?>
                                                 </p>
                                                    <input value="<?php the_permalink($post->ID);?>" onfocus="this.select();">
                                            </div>
                                        </div>
                                        <div class="share_btn" onclick="event_listing_share_toggle(<?php echo $post->ID;?>);">
                                            <i class="icon-reply-all"></i>
                                            <a><?php
											if ($cs_theme_option['trans_switcher'] == "on") {
												_e('Share This Post', "OneLife");
											} else {
												echo $cs_theme_option['trans_share_this_post'];
											}
											?></a>
                                        </div>
                                        
                                    </div>
                                    <!-- Event Admin End -->
                                </article>
                        <!-- Article End -->
                                 	
                     		<?php 
							$cs_counter_events++;
                    		endwhile;
							} 
							echo '</div>';
							} else if($cs_node->cs_event_view=='Calendar View' && $cs_node->cs_event_view <> 'List View'){
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
										$event_all_day = false;
										if(isset($cs_event_meta->event_all_day) && $cs_event_meta->event_all_day == 'on'){
											$event_all_day = true;
										}
								 	$aaa[] = array(
												'id' => $post->ID,
												'title' => substr(get_the_title(), 0, 35) . '....',
												'start' => date("Y-m-d", strtotime($event_from_date)),
												'end' => date("Y-m-d", strtotime($cs_event_to_date)),
												'url' => get_permalink(),
												'allDay' => $event_all_day
											);
							$cs_counter_events++;
                    		endwhile;	
							cs_calender_enqueue_scripts();
							 ?>
                        <!--Calendar View start-->
                           <script type="text/javascript">
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
										  var x =$(this) .offset().left;
										  var y =$(this) .offset().top;
										  var xw = $(".wrappertooltip") .outerWidth();
										  var xh = $(".wrappertooltip") .outerHeight();
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
                    <!--Calendar View end -->
                <?php } else { ?>
                    <h2><?php _e('No results found.', "OneLife") ?></h2>
        		<?php 
						}
													
					}
					wp_reset_query();
					if ($cs_node->cs_event_view == "List View" && $cs_node->cs_event_view <> 'Calendar View') {
						$qrystr = '';
						if(cs_pagination($count_post, $cs_node->cs_event_per_page, $qrystr) <> ''){
							// pagination start
							if ( $cs_node->cs_event_pagination == "Show Pagination" and $cs_node->cs_event_per_page > 0 ) {
								echo "<nav class='pagination'><ul>";
									if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
									if ( isset($_GET['filter_category']) ) $qrystr .= "&filter_category=".$_GET['filter_category'];
									echo cs_pagination($count_post, $cs_node->cs_event_per_page, $qrystr);
								echo "</ul></nav>";
								}
							// pagination end
						}
					}
				?>
				<!-- Event List End -->
       
</div>
<div class="clear"></div>