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
    <div class="event">
    	<?php if ($px_node->var_pb_event_title <> '') { ?>
				<header class="pix-heading-title"><h2 class=" px-heading-color pix-section-title"><?php echo $px_node->var_pb_event_title; ?></h2></header>
		<?php  }
    	if($px_node->var_pb_featured_post <> '' && $px_node->var_pb_featured_post <> '0'){ 
		$px_featured_post_args = array(
					'posts_per_page'			=> "1",
					'post_type'					=> 'events',
					'event-category' 			=> "$px_node->var_pb_featured_post",
					'post_status'				=> 'publish',
					'meta_key'					=> 'px_event_from_date',
					'meta_value'				=> date('Y-m-d'),
					'meta_compare'				=> ">=",
					'orderby'					=> 'meta_value',
					'order'						=> 'ASC',
				 );
		$px_featured_post_custom_query = new WP_Query($px_featured_post_args);
		while ($px_featured_post_custom_query->have_posts()) : $px_featured_post_custom_query->the_post();	
			$image_url = px_get_post_img_src($post->ID, 550, 550);
			$event_from_date = get_post_meta($post->ID, "px_event_from_date", true);
			$px_featured_meta = get_post_meta($post->ID, "px_event_meta", true);
				$year_event = date("Y", strtotime($event_from_date));
				$month_event = date("m", strtotime($event_from_date));
				$date_event = date("d", strtotime($event_from_date));
			if ( $px_featured_meta <> "" ) {
				$px_featured_event_meta = new SimpleXMLElement($px_featured_meta);
			}
			px_enqueue_countdown_script();
 		?>
                <div class="event-shortcode">
                <article class="event-v1">
                    <?php if($px_node->var_pb_featuredevent_title <> ''){ ?>
                   		<h5 class="pix-bgcolr-alt"><?php echo $px_node->var_pb_featuredevent_title; ?></h5>
                    <?php } ?>
                    <h2><a href="<?php the_permalink();?>" class="colrhover"><?php the_title(); ?></a></h2>
                    <h3 class="pix-colr-alt"><span id="textLayout" class="countdown"></span></h3>
                                <script>
									<?php if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'on'){?>
											px_event_countdown('<?php echo $year_event;?>','<?php echo $month_event;?>','<?php echo $date_event;?>');
									<?php } else {?>
											jQuery(document).ready(function($) {
												px_event_countdown('<?php echo $year_event;?>','<?php echo $month_event;?>','<?php echo $date_event;?>');
											});
									<?php } ?>
								 	jQuery(document).ready(function($) {
										px_event_countdown('<?php echo $year_event;?>','<?php echo $month_event;?>','<?php echo $date_event;?>')
                                    });
                                </script>
                    <?php if($px_featured_event_meta->event_address <> ''){?>
                        <address><?php echo get_the_title((int) $px_featured_event_meta->event_address);?></address>
                     <?php }?>
                </article>
              </div>
		   <?php
            endwhile; 
            wp_reset_query();
            }
		if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
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
				$px_event_to_date = get_post_meta($post->ID, "px_event_to_date", true);
				$post_xml = get_post_meta($post->ID, "px_event_meta", true);	
				if ( $post_xml <> "" ) {
					$px_event_meta = new SimpleXMLElement($post_xml);
				}
				?>
              <article>
                  <div class="calender-date">
                      <time datetime="2011-01-12">
                      	<?php echo date(get_option('date_format'), strtotime($event_from_date));?>
                      </time>
                  </div>
                  <div class="text">
                      <h2 class="pix-post-title">
                          <a href="<?php the_permalink();?>" class="pix-colrhvr-alt"><?php the_title();?></a>
                      </h2>
                      <?php px_event_options();?>
                  </div>
              </article>
              <?php endwhile;
			 
			  ?>
          </div>
          <?php 
		   $qrystr = '';
			  if ( $px_node->var_pb_event_pagination == "Show Pagination" and $count_post > $px_node->var_pb_event_per_page and $px_node->var_pb_event_per_page > 0 and $px_node->var_pb_event_filterables != "On" ) {
				echo "<nav class='pagination'><ul>";
					if ( isset($_GET['page_id']) ) $qrystr = "&amp;page_id=".$_GET['page_id'];
						echo px_pagination($count_post, $px_node->var_pb_event_per_page,$qrystr);
				echo "</ul></nav>";
			}
			  
			  }
		}
		  ?>
       </div>
       </div>