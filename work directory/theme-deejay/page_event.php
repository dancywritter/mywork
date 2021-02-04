<?php
	global $px_node,$post, $px_event_meta,$px_theme_option,$px_counter_node,$wpdb;
	if ( !isset($px_node->var_pb_event_per_page) || empty($px_node->var_pb_event_per_page) ) { $px_node->var_pb_event_per_page = -1; }
	if ( $px_node->var_pb_event_pagination == "Single Page") { $px_node->var_pb_event_per_page = $px_node->var_pb_event_per_page; }
	  $meta_compare = '';
        $filter_category = '';
        if ( $px_node->px_event_type == "Upcoming Events" ) $meta_compare = ">=";
        else if ( $px_node->px_event_type == "Past Events" ) $meta_compare = "<";
        $row_cat = $wpdb->get_row("SELECT * from ".$wpdb->prefix."terms WHERE slug = '" . $px_node->var_pb_event_category ."'" );
        if ( isset($_GET['filter_category']) ) {$filter_category = $_GET['filter_category'];}
        else {
            if(isset($row_cat->slug)){
            $filter_category = $row_cat->slug;
            }
        }
		$px_counter_events = 0;
		if ( empty($_GET['page_id_all']) ){ $_GET['page_id_all'] = 1;}
            if ( $px_node->var_pb_event_type == "All Events" ) {
                $args = array(
                    'posts_per_page'			=> "-1",
					'paged'						=> $_GET['page_id_all'],
                    'post_type'					=> 'events',
                    'post_status'				=> 'publish',
                    'orderby'					=> 'meta_value',
                    'order'						=> 'ASC',
                );
            }
            else {
                $args = array(
                    'posts_per_page'			=> "-1",
					'paged'						=> $_GET['page_id_all'],
                    'post_type'					=> 'events',
                    'post_status'				=> 'publish',
                    'meta_key'					=> 'px_event_to_date',
                    'meta_value'				=> date('Y-m-d'),
                    'meta_compare'				=> $meta_compare,
                    'orderby'					=> 'meta_value',
                    'order'						=> 'ASC',
                );
            }
			if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0' && $filter_category <> 'All' ){
				$event_category_array = array('event-category' => "$filter_category");
				$args = array_merge($args, $event_category_array);
			}
            $custom_query = new WP_Query($args);
            $count_post = 0;
			$count_post = $custom_query->post_count;
	?>
   <div class=" element_size_<?php echo $px_node->event_element_size; ?>"> 
        	<?php if ($px_node->var_pb_event_title <> '') { ?>
				<header class="pix-heading-title"><h2 class="pix-page-title"><?php echo $px_node->var_pb_event_title; ?></h2></header>
		<?php  }
		if(isset($filter_category) && $filter_category <> '0'){
			if ( $px_node->var_pb_event_type == "Upcoming Events") {
				$args = array(
					'posts_per_page'			=> "$px_node->var_pb_event_per_page",
					'paged'						=> $_GET['page_id_all'],
					'post_type'					=> 'events',
					'post_status'				=> 'publish',
					'meta_key'					=> 'px_event_from_date',
					'meta_value'				=> date('Y-m-d'),
					'meta_compare'				=> ">=",
					'orderby'					=> 'meta_value',
					'order'						=> 'ASC',
				 );
			}else if ( $px_node->var_pb_event_type == "All Events" ) {
				$args = array(
					'posts_per_page'			=> "$px_node->var_pb_event_per_page",
					'paged'						=> $_GET['page_id_all'],
					'post_type'					=> 'events',
					'meta_key'					=> 'px_event_from_date',
					'meta_value'				=> '',
					'post_status'				=> 'publish',
					'orderby'					=> 'meta_value',
					'order'						=> 'DESC',
				);
			}
			else {
				$args = array(
					'posts_per_page'			=> "$px_node->var_pb_event_per_page",
					'paged'						=> $_GET['page_id_all'],
					'post_type'					=> 'events',
					'post_status'				=> 'publish',
					'meta_key'					=> 'px_event_from_date',
					'meta_value'				=> date('Y-m-d'),
					'meta_compare'				=> $meta_compare,
					'orderby'					=> 'meta_value',
					'order'						=> 'ASC',
				 );
			}
			if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0' && $filter_category <> 'All'){
				$event_category_array = array('event-category' => "$filter_category");
				$args = array_merge($args, $event_category_array);
			}
			$custom_query = new WP_Query($args);
			if ( $custom_query->have_posts() <> "" ) {
            ?>
              <div class="event-listing">
              <?php
                    while ( $custom_query->have_posts() ): $custom_query->the_post();
                    $event_from_date = get_post_meta($post->ID, "px_event_from_date", true);
                    $post_xml = get_post_meta($post->ID, "px_event_meta", true);	
                    if ( $post_xml <> "" ) {
                        $px_event_meta = new SimpleXMLElement($post_xml);
                        if($px_event_meta->event_address <> ''){
                            $address_map = get_the_title("$px_event_meta->event_address");	
                        }else{
                            $address_map = '';
                        }
                    }
                    ?>
                    
                        <article <?php post_class();?>>
                            <div class="text">
                                <h2 class="pix-post-title">
                                    <a href="<?php the_permalink();?>"><?php the_title();?></a>
                                </h2>
                                <address>
                                    <time>0n <?php echo date_i18n(get_option('date_format'), strtotime($event_from_date));?></time>
                                    <?php if($address_map <> ''){echo '@ '.$address_map;}?>
                                </address>
                                
                                <?php if($px_event_meta->event_ticket_options <> ''){?> 
                                <a <?php if(isset($px_event_meta->event_ticket_color) && $px_event_meta->event_ticket_color <> ''){?>style=" background-color: <?php echo $px_event_meta->event_ticket_color;?>"<?php }?> class="btn pix-btnprice" href="<?php echo $px_event_meta->event_buy_now;?>"><?php if(isset($px_event_meta->event_ticket_options) && $px_event_meta->event_ticket_options <> ''){echo $px_event_meta->event_ticket_options;}?></a>
                            <?php }?>
                              
                            </div>
                        </article>
                    
                  <?php endwhile;?>
                  <?php 
				   $qrystr = '';
					  if ( $px_node->var_pb_event_pagination == "Show Pagination" and $count_post > $px_node->var_pb_event_per_page and $px_node->var_pb_event_per_page > 0 and $px_node->var_pb_event_filterables != "On" ) {
						echo "<nav class='pagination'><ul>";
							if ( isset($_GET['page_id']) ) $qrystr = "&amp;page_id=".$_GET['page_id'];
								echo px_pagination($count_post, $px_node->var_pb_event_per_page,$qrystr);
						echo "</ul></nav>";
					}
			  
			  }
			
		  		?>
              </div>
           <?php }?>
       </div>
