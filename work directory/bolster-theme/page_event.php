<?php
	global $cs_node,$post,$cs_theme_option,$counter_node,$wpdb;
	if ( !isset($cs_node->cs_event_per_page) || empty($cs_node->cs_event_per_page) ) { $cs_node->cs_event_per_page = -1; } else if($cs_node->cs_event_per_page>0 && $cs_node->cs_event_per_page<40){ $cs_node->cs_event_per_page = 40;}
	if ( !isset($cs_node->cs_event_map_zoom) || empty($cs_node->cs_event_map_zoom) ) { $cs_node->cs_event_map_zoom = 7; }
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
        if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
            if ( $cs_node->cs_event_type == "All Events" ) {
                $args = array(
                    'posts_per_page'			=> "-1",
                    'post_type'					=> 'gigs',
                    'event-category'			=> "$filter_category",
                    'post_status'				=> 'publish',
                    'orderby'					=> 'meta_value',
                    'order'						=> 'ASC',
                );
            }
            else {
                $args = array(
                    'posts_per_page'			=> "-1",
                    'post_type'					=> 'gigs',
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
            $count_post = 0;
			$count_post = $custom_query->post_count;
			if ( $cs_node->cs_event_type == "Upcoming Events") {
                            $args = array(
                                'posts_per_page'			=> "$cs_node->cs_event_per_page",
								'paged'						=> $_GET['page_id_all'],
                                'post_type'					=> 'gigs',
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
                                'post_type'					=> 'gigs',
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
                                'post_type'					=> 'gigs',
                                'post_status'				=> 'publish',
                                'meta_key'					=> 'cs_event_from_date',
                                'meta_value'				=> date('Y-m-d'),
                                'meta_compare'				=> $meta_compare,
                                'orderby'					=> 'meta_value',
                                'order'						=> 'ASC',
                             );
                        }
						if($row_cat->slug != "all"){
							$event_category_array = array('event-category' => "$filter_category");
							$args = array_merge($args, $event_category_array);
						}
  						$custom_query = new WP_Query($args);
    ?>
    	<div class="right-content" >
                <div class="gigs-wrapp">
                    <div class="concert-area">
                        <div class="heading-area">
                        <?php
							if ($cs_node->cs_event_title <> '') { ?>
                            	<header class="section-header">
									<h2 class="section-title cs-heading-color"><?php echo $cs_node->cs_event_title; ?></h2>
                                 </header>
						<?php  } 
							if(isset($cs_node->cs_event_filterables) && $cs_node->cs_event_filterables == 'Yes'){
								cs_enqueue_masonry_style_script();
                            ?>   
                            <script type="application/javascript">
								jQuery(document).ready(function() {
								 //	filteable_onchange();
								 cs_filters_callback('event_more_articles');
								});
							</script>
                            <ul id="filters">
                                	<li class="bgcolr"><a data-filter="*"><?php _e("All",'Bolster'); ?></a></li>
                                 <?php
                                    $row_cat = $wpdb->get_row("SELECT * from ".$wpdb->prefix."terms WHERE slug = '" . $cs_node->cs_event_category ."'" );
                                     if(isset($cs_node->cs_event_category) && $cs_node->cs_event_category <> '' && $cs_node->cs_event_category <> '0'){
                                    $categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'event-category', 'hide_empty' => 0) );
                                    } else {
                                        $categories = get_categories( array('taxonomy' => 'event-category', 'hide_empty' => 0) );
                                    }
                                   // $categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'event-category', 'hide_empty' => 0) );
                                    foreach ($categories as $category) {
                                    ?>
                                        <li><a data-filter=".<?php echo $category->slug; ?>" href="#"><?php echo $category->cat_name?></a></li>
                                    <?php }?>
                                 </ul>
                            <?php }?>
                        </div>
                        <?php if($cs_node->cs_event_per_page <> '-1' && $cs_node->cs_event_per_page < $count_post){?>
                        <script type="text/javascript">
							 jQuery(document).ready(function() {
								 event_load_more_js(<?php echo $cs_node->cs_event_per_page; ?>, '<?php echo $cs_node->cs_event_view; ?>', '<?php echo $cs_node->cs_event_type; ?>', '<?php echo $count_post;?>', '<?php echo $filter_category; ?>', '<?php echo home_url() ?>','<?php echo get_template_directory_uri() ?>');
								
						   });
						</script>
                        <?php }?>
                        <div class="concert-list">
                        	<div class="event_more_articles" id="event_filteabale_articles">
                        <?php
						$count_first = 0;
						$map_list = '';
                       	if ( $custom_query->have_posts() <> "" ) {
							while ( $custom_query->have_posts() ): $custom_query->the_post();
                                $cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
                                if ( $cs_event_meta <> "" ) {
                                	$cs_event_meta = new SimpleXMLElement($cs_event_meta);
 									if($cs_event_meta->event_address <> ''){
 										$address_map = get_the_title("$cs_event_meta->event_address");	
									}else{
										$address_map = '';
									}
                                }
								$loc_address = $loc_city = $loc_country = $location_map_type = '';
								$event_loc_lat = '';
								$event_loc_long = '';
								$event_loc_zoom = '';
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
									$location_map_type = $cs_xmlObject->loc_city;
									if(!isset($location_map_type) && $location_map_type == ''){
										$location_map_type = $cs_xmlObject->loc_country;
									}
									$event_map_title = '<a class="colrhover" href="'.get_permalink().'">'.addslashes(get_the_title()).'</a>';
									
 								}
   								$event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
								$categories_list = get_the_terms($post->ID,'event-category');
								$conter = 1;
								foreach($categories_list as $cat){
									if ( $cs_event_loc <> "" && $event_loc_lat && $event_loc_long && $loc_address && $loc_city) {
										$map_list .= "{pos:{lat:".$event_loc_lat.",lng:".$event_loc_long."},address:'".addslashes($loc_address).' '.addslashes($loc_city).' '.addslashes($loc_country)."',title:'".addslashes($event_map_title)."',type:'".$cat->slug."'},";
									}
									$cats[0] = 'mix box';
									$cats[$conter] =$cat->slug;
									$conter++;
								}
  								?>
                               <article <?php post_class($cats); ?>>
                                <div class="date-box"><big><?php echo date('d',strtotime($event_from_date));  ?></big><small><?php echo date('M',strtotime($event_from_date));  ?></small></div>
                                <div class="text">
                                    <h2 class="post-title"><a href="<?php the_permalink();?>" class="colrhover"><?php the_title(); ?></a></h2>
                                    <p class="panel">
									<?php 
										$before_cat = '<em class="fa fa-folder-open"></em>';
										$categories_list = get_the_term_list ( get_the_id(), 'event-category', $before_cat, ', ', '' );
										if ( $categories_list ){ printf( __( '%1$s', 'Bolster' ),$categories_list ); }
									?> 
									<?php if ( $cs_event_loc <> "" ) {?><a><em class="fa fa-map-marker"></em><?php echo $address_map;?></a><?php }?></p>        
                                </div>
                            </article>
                            <?php 
                    		endwhile;
                        }
						$map_list = substr($map_list, 0, -1);
						?>
                        
                        </div>
                        </div>
                    </div>
                    <?php if($cs_node->cs_event_showmap == "Yes"){  ?>
                    	<div class="gigs-area-map <?php if($cs_node->cs_event_map_width == ""){ echo 'cs-full-map'; } ?>" id="gigs-area-map" <?php if($cs_node->cs_event_map_width != ""){ ?> style=" width:<?php echo $cs_node->cs_event_map_width.'px'; ?> "<?php } ?>>
                        <div id="map_canvas<?php echo $counter_node;?>" style="width: 100%;height: 100%;"></div>
                        <?php
									$counter_first=0;
									$title_first_id = '';
									$location_options = '';
									query_posts( array('posts_per_page' => "-1", 'post_status' => 'publish', 'post_type' => 'event-location') );
										while ( have_posts()) : the_post();
										$cs_event_loc_xml = get_post_meta(get_the_id(), "cs_event_loc_meta", true);
										if ( $cs_event_loc_xml <> "" ) {
											$cs_xmlObject = new SimpleXMLElement($cs_event_loc_xml);
											$location_map_type = $cs_xmlObject->loc_city;
											if(!isset($location_map_type) && $location_map_type ==''){
												$location_map_type = $cs_xmlObject->loc_country;
											}
											
										} else {
											$loc_country = '';
											$loc_city = '';
										}
										if($counter_first == '0' ){
										$event_loc_lat_first = $cs_xmlObject->event_loc_lat;
										$event_loc_long_first = $cs_xmlObject->event_loc_long;
										 $title_first_id = get_the_title(); $counter_first++;}
										endwhile;
		                                ?>
                        <div class="map-panel">
                            <a href="#" class="btn-expand btndetail-g" data-tooltip="Expand Map"> <em class="fa fa-arrows-alt"></em></a>
                        </div>
                    </div>
                   <?php } ?>
                </div>
         </div>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript">
        var map;
        var markers = [];
        var lastinfowindow;
        var locIndex;
        //Credit: MDN
        if ( !Array.prototype.forEach ) {
          Array.prototype.forEach = function(fn, scope) {
            for(var i = 0, len = this.length; i < len; ++i) {
              fn.call(scope, this[i], i, this);
            }
          }
        }
        /*
        This is the data as a JS array. It could be generated by CF of course. This
        drives the map and the div on the side.
        */
        var data = [ <?php echo $map_list;?> ];
    //A utility function that translates a given type to an icon
        function getIcon(type) {
            switch(type) {
                // case "pharmacy": return "images/map-marker.png";
                // case "hospital": return "images/map-marker.png";
                // case "lab": return "images/map-marker.png";
                default: return "<?php echo get_template_directory_uri();?>/images/map-marker.png";
            }
        }
        //console.log(results[0].geometry.location.lat()+','+results[0].geometry.location.lng(),mapData.title);
        function initialize() {
            var latlng = new google.maps.LatLng(<?php echo $event_loc_lat_first;?>, <?php echo $event_loc_long_first;?>);
            var myOptions = {
                zoom: <?php echo $cs_node->cs_event_map_zoom;?>,
                center: latlng,
				scrollwheel:<?php echo $cs_node->cs_event_map_scrollwheel; ?>,
				draggable:<?php echo $cs_node->cs_event_map_draggable; ?>,
                mapTypeId: google.maps.MapTypeId.<?php echo $cs_node->cs_event_map_type;?>,
				disableDefaultUI:<?php echo $cs_node->cs_event_map_controls; ?>
            };
            map = new google.maps.Map(document.getElementById("map_canvas<?php echo $counter_node;?>"),myOptions);
            geocoder = new google.maps.Geocoder();
            data.forEach(function(mapData,idx) {
                var marker = new google.maps.Marker({
                    map: map, 
                    position: new google.maps.LatLng(mapData.pos.lat,mapData.pos.lng),
                    title: mapData.title,
                    icon: getIcon(mapData.type)
                });
                var contentHtml = "<div style='width:200px;height:100px'><h3>"+mapData.title+"</h3>"+mapData.address+"</div>";
                var infowindow = new google.maps.InfoWindow({
                    content: contentHtml
                });
                google.maps.event.addListener(marker, 'click', function() {
                  infowindow.open(map,marker);
                });
				 jQuery(".minict_wrapper ul li").live('click', function() {
					  infowindow.close();
					});
                marker.locid = idx+1;
                marker.infowindow = infowindow;
                markers[markers.length] = marker;
                var sideHtml = '<p class="loc" data-locid="'+marker.locid+'"><b>'+mapData.title+'</b><br/>';
                     sideHtml += mapData.address + '</p>';
                     jQuery("#locs").append(sideHtml); 
                //Are we all done? Not 100% sure of this
                if(markers.length == data.length) doFilter();
            });
            /*
            Run on every change to the checkboxes. If you add more checkboxes to the page,
            we should use a class to make this more specific.
            */
            function doFilter() {
                if(!locIndex) {
                    locIndex = {};
                    //I reverse index markers to figure out the position of loc to marker index
                    for(var x=0, len=markers.length; x<len; x++) {
                        locIndex[markers[x].locid] = x;
                    }
                }
                var checked = jQuery(".minict_wrapper input[type^='radio']:checked");
                var selTypes = [];
                for(var i=0, len=checked.length; i<len; i++) {
                    selTypes.push(jQuery(checked[i]).val());
                }
                for(var i=0, len=data.length; i<len; i++) {
                    var sideDom = "p.loc[data-locid="+(i+1)+"]";
                    //Only hide if length != 0
                    if(checked.length !=0 && selTypes.indexOf(data[i].type) < 0) {
                        jQuery(sideDom).hide();
                        markers[locIndex[i+1]].setVisible(false);
                    } else {
                        jQuery(sideDom).show();
                        markers[locIndex[i+1]].setVisible(true);
                         map.panTo(markers[i].getPosition());
                    }
                }
            }
            jQuery(".select-area").on("change", "input[type^='radio']", doFilter);
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>