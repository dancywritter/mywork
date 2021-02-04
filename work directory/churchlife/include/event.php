<?php
// event start
	//adding columns start
    add_filter('manage_events_posts_columns', 'event_columns_add' );
		function event_columns_add($columns) {
			$columns['category'] = 'Categories';
			$columns['author'] = 'Author';
			$columns['tag'] = 'Tags';
			return $columns;
	    }
    add_action('manage_events_posts_custom_column', 'event_columns');
		function event_columns($name) {
			global $post;
			switch ($name) {
				case 'category':
					$categories = get_the_terms( $post->ID, 'event-category' );
						if($categories <> ""){
							$couter_comma = 0;
							foreach ( $categories as $category ) {
								echo $category->name;
								$couter_comma++;
								if ( $couter_comma < count($categories) ) {
									echo ", ";
								}
							}
						}
					break;
				case 'author':
					echo get_the_author();
					break;
				case 'tag':
					$categories = get_the_terms( $post->ID, 'event-tag' );
						if($categories <> ""){
							$couter_comma = 0;
							foreach ( $categories as $category ) {
								echo $category->name;
								$couter_comma++;
								if ( $couter_comma < count($categories) ) {
									echo ", ";
								}
							}
						}
					break;
			}
		}
	//adding columns end
	
	function px_event_register() {  
		$labels = array(
			'name' => 'Events',
			'add_new_item' => 'Add New Event',
			'edit_item' => 'Edit Event',
			'new_item' => 'New Event Item',
			'add_new' => 'Add New Event',
			'view_item' => 'View Event Item',
			'search_items' => 'Search Event',
			'not_found' => 'Nothing found',
			'not_found_in_trash' => 'Nothing found in Trash',
			'parent_item_colon' => ''
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon' => 'dashicons-calendar',
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'has_archive' => true,
			'supports' => array('title','editor','thumbnail', 'excerpt', 'comments')
		); 
        register_post_type( 'events' , $args );  

			// adding Manage Location start
				$labels = array(
					'name' => 'Locations',
					'add_new_item' => 'Add New Location (Venue Title)',
					'edit_item' => 'Edit Location',
					'new_item' => 'New Location Item',
					'add_new' => 'Add New Location',
					'view_item' => 'View Location Item',
					'search_items' => 'Search Location',
					'not_found' => 'Nothing found',
					'not_found_in_trash' => 'Nothing found in Trash',
					'parent_item_colon' => ''
				);
				$args = array(
					'labels' => $labels,
					'public' => true,
					'publicly_queryable' => true,
					'show_ui' => true,
					'query_var' => true,
					'menu_icon' => get_stylesheet_directory_uri() . '/images/calendar.png',
					'show_in_menu' => 'edit.php?post_type=events',
					'show_in_nav_menus'=>true,
					'rewrite' => true,
					'capability_type' => 'post',
					'hierarchical' => false,
					'menu_position' => null,
					'supports' => array('title')
				); 
				register_post_type( 'event-location' , $args );  
			// adding Manage Location end
    }
	add_action('init', 'px_event_register');

	function px_event_categories() 
	{
		  $labels = array(
			'name' => 'Event Categories',
			'search_items' => 'Search Event Categories',
			'edit_item' => 'Edit Event Category',
			'update_item' => 'Update Event Category',
			'add_new_item' => 'Add New Category',
			'menu_name' => 'Event Categories',
		  ); 	
		  register_taxonomy('event-category',array('events'), array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'event-category' ),
		  ));
	}
	add_action( 'init', 'px_event_categories');

	function px_event_tag() {
		  $labels = array(
			'name' => 'Event Tags',
			'singular_name' => 'event-tag',
			'search_items' => 'Search Tags',
			'popular_items' => 'Popular Tags',
			'all_items' => 'All Tags',
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => 'Edit Tag',
			'update_item' => 'Update Tag',
			'add_new_item' => 'Add New Tag',
			'new_item_name' => 'New Tag Name',
			'separate_items_with_commas' => 'Separate writers with commas',
			'add_or_remove_items' => 'Add or remove tags',
			'choose_from_most_used' => 'Choose from the most used tags',
			'menu_name' => 'Event Tags',
		  ); 
		  register_taxonomy('event-tag','events',array(
			'hierarchical' => false,
			'labels' => $labels,
			'show_ui' => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var' => true,
			'rewrite' => array( 'slug' => 'event-tag' ),
		  ));
	}
	add_action( 'init', 'px_event_tag');

	// event-location custom fields start
		add_action( 'add_meta_boxes', 'event_loc_meta' );  
		function event_loc_meta()
		{
			add_meta_box( 'event_loc_meta', 'Add Location With Map', 'event_loc_meta_data', 'event-location', 'normal', 'high' );
		}
		function event_loc_meta_data($post) {
			$event_loc_meta = get_post_meta($post->ID, "px_event_loc_meta", true);
			if ( $event_loc_meta <> "" ) {
				$px_xmlObject = new SimpleXMLElement($event_loc_meta);
					$event_loc_lat = $px_xmlObject->event_loc_lat;
					$event_loc_long = $px_xmlObject->event_loc_long;
					$event_loc_zoom = $px_xmlObject->event_loc_zoom;
					$loc_address = $px_xmlObject->loc_address;
					$loc_city = $px_xmlObject->loc_city;
					$loc_postcode = $px_xmlObject->loc_postcode;
			}
			else {
				$event_loc_lat = '';
				$event_loc_long = '';
				$event_loc_zoom = '';
				$loc_address = '';
				$loc_city = '';
				$loc_postcode = '';
			}
			?>
				<fieldset class="gllpLatlonPicker">
                <div class="page-wrap page-opts event-location-section left" style="overflow:hidden; position:relative;">
                	<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
                    <script src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery-gmaps-latlon-picker.js"></script>
            		<div class="option-sec" style="margin-bottom:0;">
                        <div class="opt-conts">
                            <ul class="form-elements noborder">
                                <li class="to-label"><label>Address</label></li>
                                <li class="to-field"><input name="loc_address" id="loc_address" type="text" value="<?php echo htmlspecialchars($loc_address)?>" class="gllpSearchButton" onblur="gll_search_map()" /></li>
                            </ul>
                            <ul class="form-elements noborder">
                                <li class="to-label"><label>City / Town</label></li>
                                <li class="to-field"><input name="loc_city" id="loc_city" type="text" value="<?php echo htmlspecialchars($loc_city)?>" class="gllpSearchButton" onblur="gll_search_map()" /></li>
                            </ul>
                            <ul class="form-elements noborder">
                                <li class="to-label"><label>Post Code</label></li>
                                <li class="to-field"><input name="loc_postcode" id="loc_postcode" type="text" value="<?php echo htmlspecialchars($loc_postcode)?>" class="gllpSearchButton" onblur="gll_search_map()" /></li>
                            </ul>
                           
                            <ul class="form-elements noborder">
                                <li class="to-label"><label></label></li>
                                <li class="to-field"><input type="button" class="gllpSearchButton" value="Search This Location on Map" onclick="gll_search_map()"></li>
                            </ul>
                            <ul class="form-elements">
                                <input type="hidden" name="add_new_loc" class="gllpSearchField" style="margin-bottom:10px;" >
                                <div class="gllpMap">Google Maps</div>
                                <input type="hidden" name="event_loc_lat" value="<?php echo $event_loc_lat?>" class="gllpLatitude" />
                                <input type="hidden" name="event_loc_long" value="<?php echo $event_loc_long?>" class="gllpLongitude" />
                                <input type="hidden" name="event_loc_zoom" value="<?php echo $event_loc_zoom?>" class="gllpZoom" />
                                <input type="button" class="gllpUpdateButton" value="update map" style="display:none">
							</ul>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
				</fieldset>
				<input type="hidden" name="event_loc_meta_form" value="1" />
			<?php
		}
	// event-location custom fields end

	// event custom fields start
	add_action( 'add_meta_boxes', 'px_event_meta' );  
    function px_event_meta()
    {
        add_meta_box( 'event_meta', 'Event Options', 'px_event_meta_data', 'events', 'normal', 'high' );
    }
	function px_event_meta_data($post) {
		$px_event_meta = get_post_meta($post->ID, "px_event_meta", true);
		global $px_xmlObject;
		if ( $px_event_meta <> "" ) {
			$px_xmlObject = new SimpleXMLElement($px_event_meta);
				$sub_title = $px_xmlObject->sub_title;
				$event_social_sharing = $px_xmlObject->event_social_sharing;
				$event_start_time = $px_xmlObject->event_start_time;
				$event_end_time = $px_xmlObject->event_end_time;
				$event_all_day = $px_xmlObject->event_all_day;
				$event_address = $px_xmlObject->event_address;
				$event_buy_now = $px_xmlObject->event_buy_now;
				$event_ticket_price = $px_xmlObject->event_ticket_price;
				$event_map = $px_xmlObject->event_map;
				$event_ticket_options = $px_xmlObject->event_ticket_options;
				$var_pb_event_author = $px_xmlObject->var_pb_event_author;
				$event_ticket_color = $px_xmlObject->event_ticket_color;
		}
		else {
			$sub_title = '';
			$event_social_sharing = '';
			$event_related = '';
			$event_start_time = '';
			$event_end_time = '';
			$event_all_day = '';
			$event_address = '';
			$event_loc_lat = '';
			$event_loc_long = '';
			$event_loc_zoom = '';
			$event_map = '';
			$event_ticket_price = '';
			$event_buy_now = '';
			$event_ticket_options = '';
			$var_pb_event_author = '';
			$event_ticket_color = '';
 		}
		$px_event_from_date = get_post_meta($post->ID, "px_event_from_date", true);
		$px_event_to_date = get_post_meta($post->ID, "px_event_to_date", true);
	?>
    	
    	<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/admin/bootstrap.min.css">
		<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/select.js"></script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/bootstrap-3.0.js"></script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/bootstrap-datepicker.js"></script>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/admin/datepicker.css">
        <link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/admin/bootstrap-timepicker.min.css">
        <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/bootstrap-timepicker.js"></script>
        <script>
		
		jQuery(function($) {
					jQuery( "#event_start_time, #event_end_time" ).click(function(event) {
						jQuery( this ).prev( "div" ).show();
						event.stopPropagation();
					});
					jQuery( "html" ).click(function() {
						jQuery( '.bootstrap-timepicker-widget' ).hide();
					});
					
					jQuery('#event_start_time').timepicker({showInputs: false,disableFocus: true});
					jQuery('#event_end_time').timepicker({
									showInputs: false,
									disableFocus: true,
									//modalBackdrop: true,
								//	showMeridian: false
					});
					    var nowTemp = new Date();
						var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
						 
						var checkin = $('#from_date').datepicker({
						onRender: function(date) {
						return date.valueOf() < now.valueOf() ? 'disabled' : '';
						}
						}).on('changeDate', function(ev) {
						if (ev.date.valueOf() > checkout.date.valueOf()) {
						var newDate = new Date(ev.date)
						newDate.setDate(newDate.getDate());
						checkout.setValue(newDate);
						}
						checkin.hide();
						$('#to_date')[0].focus();
						}).data('datepicker');
						var checkout = $('#to_date').datepicker({
						onRender: function(date) {
						return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
						}
						}).on('changeDate', function(ev) {
						checkout.hide();
						}).data('datepicker');
				});
			
        </script>

    	<div class="page-wrap  event-meta-section">
            <div class="option-sec" style="margin-bottom:0;">
            	
                <div class="opt-conts">
                    <div class="opt-head">
                      <h4>Date and Time options</h4>
                      <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                    <?php if ( empty( $_GET['post']) ) {?>
                        <div class="message-box">
                            <div class="messagebox alert alert-info">
                                <button type="button" class="close" data-dismiss="alert"><em class="fa fa-times"></em></button>
                                <div class="masg-text">
                                    <p>Repeat an event maximum up to 25 times with 1 repeat option. For example if a user create an event and repeat it 7 times with repeat option "Every Day" then 7 Events Posts will created automatically with same name with 1 day interval in all Events.</p>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                    <ul class="form-elements  time-page-options noborder">
                            <li class="to-field">
                            	<div data-date-minviewmode="months" data-date-viewmode="years" data-date-format="mm/yyyy" data-date="102/2012" id="dpMonths" class="input-append date">
                                <input type="text" id="from_date"  class="span2 icon-calendar" name="event_from_date" value="<?php if($px_event_from_date=='') echo gmdate("Y-m-d"); else echo $px_event_from_date?>" /><span class="add-on"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                                <p>Start Date</p>
                            </li>
                            <li class="label-to">To</li>
                            <li class="to-field">
                            	<div data-date-minviewmode="months" data-date-viewmode="years" data-date-format="mm/yyyy" data-date="102/2012" id="dpMonths" class="input-append date">
                                <input type="text" id="to_date" name="event_to_date"   class="span2 icon-calendar" value="<?php if($px_event_to_date=='') echo gmdate("Y-m-d"); else echo $px_event_to_date?>" />
                                <span class="add-on"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                                <p>End Date</p>
                            </li>
                        </ul>
                        <ul class="form-elements  time-page-options noborder">
                            <li class="to-field add-on">
                            	
                                <div class="input-append bootstrap-timepicker">
                                    <input id="event_start_time" name="event_start_time"  data-format="hh:mm:ss" value="<?php echo $event_start_time?>" type="text" class="vsmall glyphicon glyphicon-time" />
                                    <span class="add-on"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                                <p>Start time from</p>
                            </li>
                            <li class="label-to">To</li>
                            <li class="to-field">
                            	
                                <div id="event_time" class="input-append bootstrap-timepicker">
                                    <input id="event_end_time" name="event_end_time" value="<?php echo $event_end_time?>" type="text" readonly="readonly" class="vsmall"  />
                                    <span class="add-on"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                                <p>End time</p>
                                
                            </li>
                            <li  class="event-or label-to">Or</li>
                            <li class="event-all to-field">
                            	<div class="checkbox-list">
                                    <div class="checkbox-item">
                                        <input type="checkbox" name="event_all_day" value="on" <?php if($event_all_day=='on')echo "checked"?> onclick="px_toggle('event_time')" class="styled" />
                                        <label>All Day</label>
                                    </div>
                                </div>
                            </li>
                            
                    </ul>
                    <?php if ( empty( $_GET['post']) ) {?>
                        <ul class="form-elements noborder">
                            <li class="to-field">
                                <select name="repeat" class="dropdown" onchange="toggle_with_value('num_repeat', this.value)">
									<option value="0">-- Never Repeat --</option>
									<option value="+1 day">Every Day</option>
									<option value="+1 week">Every Week</option>
									<option value="+1 month">Every Month</option>
                                </select>
                                <p>Repeat</p>
                            </li>
                        </ul>
                        <ul class="form-elements noborder" id="num_repeat" style="display:none">
                            <li class="to-field">
                                <select name="num_repeat" class="dropdown">
                                    <?php for ( $i = 1; $i <= 25; $i++ ) {?>
                                        <option><?php echo $i?></option>
                                    <?php }?>
                                </select>
                                
                               <!-- <p>Repeat how many time</p>-->
                            </li>
                        </ul>
                    <?php }?>
                    
                    <div class="opt-head">
                      <h4>Ticket Options</h4>
                      <div class="clear"></div>
                    </div>
                    <ul class="form-elements">
                        
                        <li class="to-field">
                        	<input type="text" id="event_ticket_options" name="event_ticket_options" value="<?php echo $event_ticket_options;?>" />
                            <p>Please enter ticket button text. e.g: Buy Now,Free,Cancelled,Full Booked</p>
                        </li>
                   </ul>
                    
                    <ul class="form-elements noborder">
                        <li class="to-field">
                            <input type="text" id="event_buy_now" name="event_buy_now" value="<?php echo $event_buy_now;?>" />
                            <p>Buy Now URL.</p>
                        </li>
                    </ul>
                    <ul class="form-elements noborder">
                      <li class="to-field">
                        <input type="text" name="event_ticket_color" value="<?php echo $event_ticket_color?>" class="bg_color" />
                        <p>Tickets Button color</p>
                      </li>
                    </ul>
                    
                    <div class="opt-head">
                      <h4>Other options</h4>
                      <div class="clear"></div>
                    </div>
                    <ul class="form-elements noborder">
                     
                        <li class="to-field">
                        	<?php
                            //echo $event_address."<br />";
								query_posts( array('post_type' => 'event-location') );
									while ( have_posts()) : the_post();
										//echo get_the_ID();
									endwhile;
							?>
                        	<select name="event_address" class="dropdown" onchange="javascript:inside_event_map_showhide(this)">
                            	<option value="0">Select Location</option>
                                <?php
									query_posts( array('posts_per_page' => "-1", 'post_status' => 'publish', 'post_type' => 'event-location') );
										while ( have_posts()) : the_post();
										?>
	                                        <option <?php if($event_address==get_the_ID())echo "selected"?> value="<?php the_ID()?>"><?php the_title()?></option>
                                        <?php
										endwhile;
                                ?>
                            </select>
                        </li>
                    </ul>
                    <ul class="form-elements on-off-options noborder">
                    <li class="to-label"><label>Show Map</label></li>
                        <li class="to-field">
                        	<label class="cs-on-off">
                                <input type="checkbox" name="event_map" value="on" class="myClass" <?php if($event_map=='on')echo "checked"?> />
                                <span></span>
                            </label>
                        </li>
                        <li class="to-label"><label>Social Sharing</label></li>
                        <li class="to-field">
                        	<label class="cs-on-off">
                                <input type="checkbox" name="event_social_sharing" value="on" class="myClass" <?php if($event_social_sharing=='on')echo "checked"?> />
                                <span></span>
                            </label>
                        </li>
                        
                        <li class="to-label"><label>Author Description</label></li>
                            <li class="to-field">
                                <label class="cs-on-off">
                                	<input type="checkbox" name="var_pb_event_author" value="on" class="myClass" <?php if($var_pb_event_author=='on')echo "checked"?> />
                                	<span></span>
                                </label>
                            </li>
                    </ul>
                    <?php meta_layout()?>
                </div>
                
            </div>
            
            <input type="hidden" name="event_meta_form" value="1" />
			<div class="clear"></div>
		</div>
    
    <?php
	}
	// event custom fields end
	// event-location custom fields save start
		if ( isset($_POST['event_loc_meta_form']) and $_POST['event_loc_meta_form'] == 1 ) {
			add_action( 'save_post', 'event_loc_meta_save' );
			function event_loc_meta_save( $post_id ) {
				if (empty($_POST["event_loc_lat"])){ $_POST["event_loc_lat"] = "";}
				if (empty($_POST["event_loc_long"])){ $_POST["event_loc_long"] = "";}
				if (empty($_POST["event_loc_zoom"])){ $_POST["event_loc_zoom"] = "";}
				if (empty($_POST["loc_address"])){ $_POST["loc_address"] = "";}
				if (empty($_POST["loc_city"])){ $_POST["loc_city"] = "";}
				if (empty($_POST["loc_postcode"])){ $_POST["loc_postcode"] = "";}
				
				$sxe = new SimpleXMLElement("<event_loc></event_loc>");
					$sxe->addChild('event_loc_lat',$_POST['event_loc_lat']);
					$sxe->addChild('event_loc_long',$_POST['event_loc_long']);
					$sxe->addChild('event_loc_zoom',$_POST['event_loc_zoom']);
					$sxe->addChild('loc_address',htmlspecialchars($_POST['loc_address']) );
					$sxe->addChild('loc_city',htmlspecialchars($_POST['loc_city']) );
					$sxe->addChild('loc_postcode',htmlspecialchars($_POST['loc_postcode']) );
						update_post_meta( $post_id, 'px_event_loc_meta', $sxe->asXML() );
			}
		}
	// event-location custom fields save end
	// event custom fields save start
		if ( isset($_POST['event_meta_form']) and $_POST['event_meta_form'] == 1 ) {
			add_action( 'save_post', 'px_event_meta_save' );
			function px_event_meta_save( $post_id ) {
				// repeating events start
				if ( isset($_POST['num_repeat'] ) ) {
					global $wpdb;
					$post_thumbnail_id = get_post_thumbnail_id( $post_id );
					$post = get_post($post_id);
					$from_date = $_POST["event_from_date"];
					$to_date = $_POST["event_to_date"];
						for ( $i = 1; $i < $_POST['num_repeat']; $i++ ) {
							$wpdb->insert( $wpdb->prefix.'posts',
									array(
										'post_author'		=> $post->post_author,
										'post_date'			=> $post->post_date,
										'post_date_gmt'		=> $post->post_date_gmt,
										'post_content'		=> $post->post_content,
										'post_title'		=> $post->post_title,
										'post_excerpt'		=> $post->post_excerpt,
										'post_status'		=> $post->post_status,
										'comment_status'	=> $post->comment_status,
										'ping_status'		=> $post->ping_status,
										'post_name'			=> $post->post_name."-".$i,
										'post_modified'		=> $post->post_modified,
										'post_modified_gmt'	=> $post->post_modified_gmt,
										'post_type'			=> $post->post_type
									)
							);
							$inserted_id = (int) $wpdb->insert_id;
							// adding categories start
								$terms = wp_get_post_terms($post->ID, "event-category");
								foreach ( $terms as $val ) {
									$wpdb->insert( $wpdb->prefix.'term_relationships',
											array(
												'object_id'	=> $inserted_id,
												'term_taxonomy_id'	=> $val->term_id,
												'term_order'	=> 0
											)
									);
								}
							// adding categories end
							// adding tag start
								$terms = wp_get_post_terms($post->ID, "event-tag");
								foreach ( $terms as $val ) {
									$wpdb->insert( $wpdb->prefix.'term_relationships',
											array(
												'object_id'	=> $inserted_id,
												'term_taxonomy_id'	=> $val->term_id,
												'term_order'	=> 0
											)
									);
								}
							// adding tag end
							// adding feature image start
								if ( $post_thumbnail_id ) update_post_meta( $inserted_id, '_thumbnail_id', $post_thumbnail_id );
							// adding feature image end
							events_meta_save($inserted_id);
							if ( $_POST['repeat'] <> 0 ) {
								$from_date = strtotime(date("Y-m-d", strtotime($from_date)) . $_POST['repeat'] );
									$from_date = date('Y-m-d', $from_date);
								$to_date = strtotime(date("Y-m-d", strtotime($to_date)) . $_POST['repeat'] );
									$to_date = date('Y-m-d', $to_date);

								update_post_meta( $inserted_id, 'px_event_from_date', $from_date );
								update_post_meta( $inserted_id, 'px_event_to_date', $to_date );
							}
						}
				}
				// repeating events end
					events_meta_save($post_id);
					update_post_meta( $post_id, 'px_event_from_date', $_POST["event_from_date"] );
					update_post_meta( $post_id, 'px_event_to_date', $_POST["event_to_date"] );
			}
		}
	// event custom fields save end
	
// event end
?>