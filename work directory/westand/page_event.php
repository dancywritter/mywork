<?php
	global $cs_node,$post,$cs_theme_option,$cs_counter_node,$wpdb;
	if ( !isset($cs_node->cs_event_per_page) || empty($cs_node->cs_event_per_page) ) { $cs_node->cs_event_per_page = -1; }
	if ( !isset($cs_node->cs_event_view) || empty($cs_node->cs_event_view) ) { $cs_node->cs_event_view = 'eventlisting'; }
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
		if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
            if ( $cs_node->cs_event_type == "All Events" ) {
                $args = array(
                    'posts_per_page'			=> "-1",
                    'post_type'					=> 'events',
                  //  'event-category'			=> "$filter_category",
                    'post_status'				=> 'publish',
                    'orderby'					=> 'meta_value',
                    'order'						=> 'ASC',
                );
            }
            else {
                $args = array(
                    'posts_per_page'			=> "-1",
                    'post_type'					=> 'events',
                  //  'event-category'			=> "$filter_category",
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
			$counter = 1;
			$count_post = $custom_query->post_count;
			if ( $cs_node->cs_event_type == "Upcoming Events") {
				$args = array(
					'posts_per_page'			=> "$cs_node->cs_event_per_page",
					'paged'						=> $_GET['page_id_all'],
					'post_type'					=> 'events',
					'event-category'			=> "$filter_category",
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
					//'event-category'			=> "$filter_category",
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
				//	'event-category'			=> "$filter_category",
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
		$width = 342;
		$height=193;	
		
		if($cs_node->cs_event_view == 'eventlisting'){
			$cs_event_view = 'event eventlisting';
			 $width = 230;
			$height=186;
		} else if($cs_node->cs_event_view == 'event-gridview'){
			$cs_event_view = 'event event-grid';
			 $width = 342;
			 $height=193;
		} elseif($cs_node->cs_event_view == 'event-timeline'){
			$width = 259;
			$height=142;
			 if($cs_node->cs_event_thumbnail == 'Yes'){
				$cs_event_view = 'cs-timeline cs-timeline-v2';
			} else {
				$cs_event_view = 'cs-timeline home-page-timeline';
			}
		}
	if(isset($cs_node->event_element_size) && $cs_node->event_element_size == '33')	{
	?>
    <div class="element_size_<?php echo $cs_node->event_element_size; ?>">
    <div class="widget widget-latest-event">
		<?php if ($cs_node->cs_event_title <> '') { ?>
            <header class="cs-heading-title">
                    <h2 class="cs-section-title"><?php echo $cs_node->cs_event_title;?></h2>
            </header>
       <?php }?> 
       
       <?php			 
				 $event_count = 0;
				 $post_class = 'featured';
				 while ( $custom_query->have_posts() ): $custom_query->the_post();	
					$event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
					$year_event = date_i18n("Y", strtotime($event_from_date));
					$month_event = date_i18n("m", strtotime($event_from_date));
					$month_event_c = date_i18n("M", strtotime($event_from_date));							
					$date_event = date_i18n("d", strtotime($event_from_date));
					$image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID),$width,$height ); 
					$event_count++;
					if($image_url == ''){
						$post_class .= ' no-image';
					}
					$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
					if ( $cs_event_meta <> "" ) {
						$cs_event_meta = new SimpleXMLElement($cs_event_meta);
						$inside_event_gallery = $cs_event_meta->inside_event_gallery;
						$event_start_time = $cs_event_meta->event_start_time;
						$event_end_time = $cs_event_meta->event_end_time;
						$event_all_day = $cs_event_meta->event_all_day;
						$event_all_day = $cs_event_meta->event_all_day;
						$event_thumb_view = $cs_event_meta->event_thumb_view;
					}
		?>
    	<article <?php post_class($post_class);?>>
        <?php if($event_count == 1){?>
            <figure>
            	<?php if($image_url <> ''){?>
                        <img src="<?php echo $image_url;?>" alt="">
                <?php }?>       
                <figcaption>
                    <div class="calendar-date">
                        <span><?php echo date_i18n('d',strtotime($event_from_date));?></span><?php echo date_i18n('M',strtotime($event_from_date));?>
                    </div>
                </figcaption>
            </figure>
            <?php } else {?>
            		<div class="calendar-date">
                        <span><?php echo date_i18n('d',strtotime($event_from_date));?></span><?php echo date_i18n('M',strtotime($event_from_date));?>
                    </div>
            <?php }?>
            <div class="text">
                <h2 class="cs-post-title"><a href="<?php the_permalink();?>" class="cs-colrhvr"><?php echo substr(get_the_title(), 0, 21) . '....';?></a></h2>
                <ul class="post-options">
                	
                	<?php if($cs_event_meta->event_address <> ''){?>
                            <li>
                                <i class="fa fa-map-marker"></i><?php echo get_the_title((int)$cs_event_meta->event_address);?>
                            </li>
                     <?php }?>
                    
                </ul>
            </div>
        </article>
    <?php $post_class = '';
	
		endwhile;?>
        <?php if ( $cs_node->cs_event_view_all_link <> "" ) {?>
            <div class="fullwidth">
                <a href="<?php echo $cs_node->cs_event_view_all_link;?>" class="btnviewall"><i class="fa fa-list-ul"></i><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('View all events','WeStand');}else{ echo $cs_theme_option['trans_sortby']; } ?></a>
            </div>
       <?php }?>
   	</div>
   </div> 
    
    <?php } else {?>
    <div class="element_size_<?php echo $cs_node->event_element_size; ?>">
    <?php if ($cs_node->cs_event_title <> '' || $cs_node->cs_event_filterables == "Yes") { ?>
    	<header class="cs-heading-title">
        	<?php if ($cs_node->cs_event_title <> '') { ?>
            	<h2 class="cs-section-title"><?php echo $cs_node->cs_event_title;?></h2>
         	<?php }?>
             <?php if($cs_node->cs_event_filterables == "Yes"){
				$qrystr= "";
				if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
			?>
            <div class="sortby">
                <a class="btn sort-link" href="#"><i class="fa fa-list-ul"></i><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Events Sort By','WeStand');}else{ echo $cs_theme_option['trans_sortby']; } ?></a>
                <ul>
					<?php
                        if( isset($cs_node->cs_event_category) && ($cs_node->cs_event_category <> "" && $cs_node->cs_event_category <> "0") && isset( $row_cat->term_id )){
                        $categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'event-category', 'hide_empty' => 0) );
                        ?>
                            <li class="<?php if(($cs_node->cs_event_category==$filter_category)){echo 'bgcolr';}?>">
                                <a href="?<?php echo $qrystr."&filter_category=".$row_cat->slug?>"><?php _e("All",'WeStand');?></a>
                            </li>
                        <?php
                        }else{
                        $categories = get_categories( array('taxonomy' => 'event-category', 'hide_empty' => 0) );
                        }
                        foreach ($categories as $category) {
                        ?>
                            <li <?php if($category->slug==$filter_category){echo 'class="active"';}?>><a href="?<?php echo $qrystr."&filter_category=".$category->slug?>"><?php echo $category->cat_name?></a>
                            </li>
                   <?php }?>
                </ul>
            </div>
          <?php }?>
        </header>
       <?php }?>
    <div class="<?php echo $cs_event_view;?>">
    
       <?php if ( $custom_query->have_posts() <> "" ) { 
       		
 			 if($cs_node->cs_event_view == 'eventlisting' || $cs_node->cs_event_view == 'event-gridview'){?>
				 
				 <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script> 
				<?php			 
				 while ( $custom_query->have_posts() ): $custom_query->the_post();	
					$event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
					$year_event = date_i18n("Y", strtotime($event_from_date));
					$month_event = date_i18n("m", strtotime($event_from_date));
					$month_event_c = date_i18n("M", strtotime($event_from_date));							
					$date_event = date_i18n("d", strtotime($event_from_date));
					$image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID),$width,$height ); 
					if($image_url == ''){
						$noimg = ' no-image';
					}else{
						$noimg  ='';
					}
					$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
					if ( $cs_event_meta <> "" ) {
						$cs_event_meta = new SimpleXMLElement($cs_event_meta);
						$inside_event_gallery = $cs_event_meta->inside_event_gallery;
						$event_start_time = $cs_event_meta->event_start_time;
						$event_end_time = $cs_event_meta->event_end_time;
						$event_all_day = $cs_event_meta->event_all_day;
						$event_all_day = $cs_event_meta->event_all_day;
						$event_thumb_view = $cs_event_meta->event_thumb_view;
					}
					
						$cs_event_loc = get_post_meta($cs_event_meta->event_address, "cs_event_loc_meta", true);
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
		 ?>
                    <article <?php post_class($noimg);?>>
                    <?php if($image_url <> '' && $event_thumb_view <> 'Map'){?>
                            <figure>
                                <img src="<?php echo $image_url;?>" alt="">
                            </figure>
                      <?php } else if($event_thumb_view == 'Map' && $cs_event_meta->event_address <> ''){?>
                      			<figure>
                                <?php if($cs_event_meta->event_address <> "" && $event_loc_lat <> "" && $event_loc_long <>"" && $event_loc_zoom <> ''){ ?>
										<script type="text/javascript">
										jQuery(document).ready(function(){
											event_map("<?php echo $loc_address.'<br>'.$loc_city.'<br>'.$loc_postcode.'<br>'.$loc_country  ?>",<?php echo $event_loc_lat ?>, <?php echo $event_loc_long ?>,<?php echo $event_loc_zoom ?>,<?php echo $post->ID; ?>);
										});
										</script>
											<div id="map_canvas<?php echo $post->ID; ?>" class="event-map" style="height:<?php echo $height;?>px; width:<?php echo $width;?>px; float: left;"></div>
									<?php }?>
                                
                            	</figure>
                                
                                
                      <?php }?>
                        <div class="text">
                            <h2 class="cs-post-title">
                                <a href="<?php the_permalink();?>"><?php the_title();?></a>
                            </h2>
                           	<p><?php  cs_get_the_excerpt($cs_node->cs_event_excerpt,false);?></p>
                            <ul class="post-options">
                                <li>
                                    <i class="fa fa-calendar"></i>
                                    <time datetime="2013-12-04"><?php echo date_i18n(get_option( 'date_format' ),strtotime($event_from_date));?>,</time>
                                </li>
                                <?php if ( $cs_node->cs_event_time == "Yes" ) {
									$to = '-';
									
									?>
                                        <?php if ( $cs_event_meta->event_all_day != "on" ) {?>
                                            <li>
                                                <i class="fa fa-clock-o"></i>
                                                <time datetime="2013-12-04"><?php echo $event_start_time. ' '.$to.' '.$event_end_time;?></time>
                                            </li>
                                         <?php } else {?>
                                            <li>
                                                <i class="fa fa-clock-o"></i>
                                                <time datetime="2013-12-04"><?php _e("All",'WeStand') . printf( __("%s day",'WeStand'), ' ');?></time>
                                            </li>
                                         <?php }?>
                                 <?php }?>
                                  <?php if($cs_event_meta->event_address <> ''){?>
                                  		<li>
                                            <i class="fa fa-map-marker"></i><?php echo get_the_title((int)$cs_event_meta->event_address);?>
                                        </li>
                                 <?php }?>
                            </ul>
                          
                                    <div class="bottom-event">
                                    	<?php if($cs_event_meta->event_ticket_options <> ""){?> 
                                        		
                                        	<?php if($cs_event_meta->event_buy_now <> ""){?> 
                                                 <a class="buy-ticket btn" <?php if($cs_event_meta->event_ticket_color <> ''){?>style="background-color: <?php echo $cs_event_meta->event_ticket_color;?>" <?php }?> href="<?php echo $cs_event_meta->event_buy_now;?>"><i class="fa fa-ticket"></i> <?php echo $cs_event_meta->event_ticket_options;?></a>
                                                <?php 
                                                } else {
                                                    ?> 
                                                 <span class="buy-ticket btn" <?php if($cs_event_meta->event_ticket_color <> ''){?>style="background-color: <?php echo $cs_event_meta->event_ticket_color;?>" <?php }?>><?php echo $cs_event_meta->event_ticket_options;?></span>
                                                <?php 
                                                }
											
											} 
											if(isset($cs_event_meta->event_like) &&  $cs_event_meta->event_like == "on"){
												$cs_like_counter = '';
												$cs_like_counter = get_post_meta(get_the_id(), "cs_like_counter", true);
												if ( !isset($cs_like_counter) or empty($cs_like_counter) ) $cs_like_counter = 0;
												if ( isset($_COOKIE["cs_like_counter".get_the_id()]) ) { 
												?>
												   <a class="liks btn"> <i class="fa fa-thumbs-up"></i> <?php if($cs_theme_option['trans_switcher']== "on"){ _e('Likes','WeStand');}else{ echo $cs_theme_option['trans_likes']; } ?><span><?php echo $cs_like_counter;?></span></a>
											<?php } else {?>
												  <a  class="likethis liks btn" href="javascript:cs_like_counter('<?php echo get_template_directory_uri()?>',<?php echo get_the_id()?>)" id="like_this<?php echo get_the_id()?>" > <i class="fa fa-heart-o"></i>  <?php if($cs_theme_option['trans_switcher']== "on"){ _e('Likes','WeStand');}else{ echo $cs_theme_option['trans_likes']; } ?><span class="count-numbers like_counter<?php echo get_the_id()?>"><?php echo $cs_like_counter; ?></span></a>
													<a class="likes liks btn" id="you_liked<?php echo get_the_id()?>" style="display:none;"><i class="fa fa-heart"></i> <?php if($cs_theme_option['trans_switcher']== "on"){ _e('Likes','WeStand');}else{ echo $cs_theme_option['trans_likes']; } ?><span class="count-numbers like_counter<?php echo get_the_id()?>"><?php echo $cs_like_counter; ?></span></a>
													<div id="loading_div<?php echo get_the_id()?>" style="display:none;"><i class="fa fa-spin"></i></div>
											<?php }
											
											}?> 
                                            
                                    </div>
                        </div>
                    </article>
                <?php endwhile;?>
                
                
				<?php } elseif($cs_node->cs_event_view == 'event-timeline'){?>
                <?php 
					if($cs_node->cs_event_featured_category <> '' && $cs_node->cs_event_featured_category <> '0'){ 
					cs_enqueue_countdown_script();
						$featured_args = array(
								'posts_per_page'			=> "1",
								'paged'						=> $_GET['page_id_all'],
								'post_type'					=> 'events',
								'event-category' 			=> "$cs_node->cs_event_featured_category",
								'meta_key'					=> 'cs_event_from_date',
								'meta_value'				=> date('Y-m-d'),
								'meta_compare'				=> ">=",
								'orderby'					=> 'meta_value',
								'post_status'				=> 'publish',
								'order'						=> 'ASC',
							 );
					$cs_featured_post= new WP_Query($featured_args);
					while ($cs_featured_post->have_posts()) : $cs_featured_post->the_post();	
						$event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
						$cs_featured_meta = get_post_meta($post->ID, "cs_event_meta", true);
							$year_event = date("Y", strtotime($event_from_date));
							$month_event = date("m", strtotime($event_from_date));
							$date_event = date("d", strtotime($event_from_date));
						if ( $cs_featured_meta <> "" ) {
							$cs_featured_event_meta = new SimpleXMLElement($cs_featured_meta);
						}
					?>
					<div class="widget widget-countdown">
                        <h2 class="cs-post-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                        <span id="textLayout"></span>
                    </div>
                    <script>
						jQuery(document).ready(function($) {
						   cs_event_countdown('<?php echo $year_event;?>','<?php echo $month_event;?>','<?php echo $date_event;?>');
						});
					</script>
                      
					<?php
					endwhile;
					}
					
					cs_addthis_script_init_method();
                		  while ( $custom_query->have_posts() ): $custom_query->the_post();	
							$event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
							$year_event = date_i18n("Y", strtotime($event_from_date));
							$month_event = date_i18n("m", strtotime($event_from_date));
							$month_event_c = date_i18n("M", strtotime($event_from_date));							
							$date_event = date_i18n("d", strtotime($event_from_date));
							$image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID),$width,$height ); 
							if($image_url == ''){
								$noimg = ' no-image';
							}else{
								$noimg  ='';
							}
							$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
							if ( $cs_event_meta <> "" ) {
								$cs_event_meta = new SimpleXMLElement($cs_event_meta);
								$inside_event_gallery = $cs_event_meta->inside_event_gallery;
								$event_start_time = $cs_event_meta->event_start_time;
								$event_end_time = $cs_event_meta->event_end_time;
								$event_all_day = $cs_event_meta->event_all_day;
							}
					?>	
                    <article>
                    	 <?php if($image_url <> '' && $cs_node->cs_event_thumbnail == 'Yes'){?>
                                <figure>
                                    <img src="<?php echo $image_url;?>" alt="">
                                    <figcaption>
                                        <a href="<?php the_permalink();?>"><i class="fa fa-hand-o-right"></i></a>
                                    </figcaption>
                                </figure>
                      <?php }?>
                       	  
                  		<div class="text">
                            <div class="left-timeline-sec">
                                <h2  class="cs-post-title"><a href="<?php the_permalink();?>"><?php echo substr(get_the_title(),0,30); if ( strlen(get_the_title()) > 30) echo "...";?></a></h2>
                                <?php if ( $cs_event_meta->event_all_day != "on" ) {
									$to = '-';
									$to = __('To','WeStand');
									?>
                                	<time datetime="2011-01-12"><?php echo date_i18n(get_option( 'date_format' ),strtotime($event_from_date));?></time>
                                <?php } else {?>
                                	<time datetime="2011-01-12"><?php _e("All",'WeStand') . printf( __("%s day",'WeStand'), ' ');?></time>
                                <?php }?>
                            </div>
                            <div class="right-timeline-sec">
                            	<?php 
									$cs_like_counter = '';
									$cs_like_counter = get_post_meta(get_the_id(), "cs_like_counter", true);
									if ( !isset($cs_like_counter) or empty($cs_like_counter) ) $cs_like_counter = 0;
									if ( isset($_COOKIE["cs_like_counter".get_the_id()]) ) { 
									?>
									   <a class="btnlikes"> <i class="fa fa-thumbs-up"></i> <?php echo $cs_like_counter;?> <span></span></a>
								<?php	
									} else {?>
									  <a  class="likethis btnlikes" href="javascript:cs_like_counter('<?php echo get_template_directory_uri()?>',<?php echo get_the_id()?>)" id="like_this<?php echo get_the_id()?>" > <i class="fa fa-heart-o"></i>  <span class="count-numbers like_counter<?php echo get_the_id()?>"><?php echo $cs_like_counter; ?></span></a>
										<a class="likes btnlikes" id="you_liked<?php echo get_the_id()?>" style="display:none;"><i class="fa fa-heart"></i> <span class="count-numbers like_counter<?php echo get_the_id()?>"><?php echo $cs_like_counter; ?></span> </a>
										<div id="loading_div<?php echo get_the_id()?>" style="display:none;"><i class="fa fa-spin"></i></div>
								
								<?php }?> 
                               
                                <a class="btnshare  addthis_button_compact"><i class="fa fa-share-square-o"></i> </a>
                            </div>
                        </div>
                    </article>
                <?php endwhile;?>
                <?php } elseif($cs_node->cs_event_view == 'event-calendarview'){
					cs_calender_enqueue_scripts();
					$event_calendar = '';
					if ( isset($_GET['filter_event']) ) {echo $filter_event = $_GET['filter_event'];}
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
						 $event_ticket_class = str_replace(' ', '-', $cs_event_meta->event_ticket_options);
						 if(isset($_GET['filter_event'])){
							 if($_GET['filter_event'] == $cs_event_meta->event_ticket_options){
							  	$event_title = addslashes(substr(get_the_title(), 0, 35) . '....');
								 $event_full_title = addslashes(get_the_title());
								 $event_calendar .= '{"title":"'.$event_title.'","start":"2014-03-22","end":"2014-03-22","full_title":"'.$event_full_title.'","url":"'.addslashes(get_permalink()).'"},';
								 $aaa[] = array(
										'title' => addslashes(substr(get_the_title(), 0, 35) . '....'),
										'start' => date_i18n("Y-m-d", strtotime($event_from_date)),
										'end' => date_i18n("Y-m-d", strtotime($cs_event_to_date)),
										'full_title' => addslashes(get_the_title()),
										'event_class' => $event_ticket_class,
										//'allDay' => $allday,
										'url' => addslashes(get_permalink())
									);
						 	}
						 } else {
								 $event_title = addslashes(substr(get_the_title(), 0, 35) . '....');
								 $event_full_title = addslashes(get_the_title());
								 
								 $event_calendar .= '{"title":"'.$event_title.'","start":"2014-03-22","end":"2014-03-22","full_title":"'.$event_full_title.'","url":"'.addslashes(get_permalink()).'"},';
								 $aaa[] = array(
										'title' => addslashes(substr(html_entity_decode(get_the_title()), 0, 35) . '....'),
										'start' => date_i18n("Y-m-d", strtotime($event_from_date)),
										//'end' => date_i18n("Y-m-d", strtotime($cs_event_to_date)),
										'full_title' => addslashes(get_the_title()),
										'event_class' => $event_ticket_class,
										//'allDay' => $allday,
										'url' => addslashes(get_permalink())
									); 
						 }
						$event_ticket_class = '';
					endwhile;
					
					?>
                	<script type='text/javascript'>
					
					jQuery(document).ready(function(){
                        event_calendar();
                    });
					function event_calendar(){
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
                                var thistxt = jQuery(this) .html();
                                rsponse = jQuery(thistxt);
                                var response2 = rsponse.find(".fc-event-title").attr( "data-title" );
                                jQuery('body') .append("<div class='wrappertooltip'><span class='innertooltip'><div class='fc-event-inner'><span class='fc-event-title'>"+ response2 +"</span></div></span></div>");
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
                     }
					
					
						</script>
                	<div class="calendar">
                        <div id='calendar'></div>
                    </div>
                	
                <?php }?>
                   
        <?php }?>
        
    </div>
   		<?php 
        $qrystr = '';
          if ( $cs_node->cs_event_pagination == "Show Pagination" and $count_post > $cs_node->cs_event_per_page and $cs_node->cs_event_per_page > 0 and $cs_node->cs_event_filterables != "Yes" && $cs_node->cs_event_view <> 'event-calendarview' ) {
				if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
					echo cs_pagination($count_post, $cs_node->cs_event_per_page,$qrystr);
        }
        ?>
</div>
<?php }?>