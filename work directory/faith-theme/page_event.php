<?php
	global $cs_node,$post,$cs_theme_option,$cs_counter_node,$wpdb;
	if ( !isset($cs_node->cs_event_per_page) || empty($cs_node->cs_event_per_page) ) { $cs_node->cs_event_per_page = -1; }
	if ( !isset($cs_node->cs_event_view) || empty($cs_node->cs_event_view) ) { $cs_node->cs_event_view = 'event-listing'; }
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
	?>
    
    <div class="element_size_<?php echo $cs_node->event_element_size; ?>">
		<header class="cs-heading-title">
    	<?php if ($cs_node->cs_event_title <> '') { ?>
        	<h2 class="cs-section-title float-left"><?php echo $cs_node->cs_event_title;?></h2>
         <?php }?>
        <?php
			if(isset($cs_node->cs_event_viewall) && $cs_node->cs_event_viewall <> ''){
				echo '<a class="cs-btnviewall float-right" href="'.$cs_node->cs_event_viewall.'"><i class="fa fa-right-dir"></i>';
					if($cs_theme_option['trans_switcher'] == "on"){ _e('View All','Faith'); }else{ echo $cs_theme_option['trans_view_all']; }
				echo '</a>';
			}
		?>
     	</header>
     <?php if($cs_node->cs_event_filterables == "Yes"){
			$qrystr= "";
			if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
		?>  
     	<!-- Sortby Start -->
    	<ul class="sortby cs-filter">
		 <?php
            if( isset($cs_node->cs_event_category) && ($cs_node->cs_event_category <> "" && $cs_node->cs_event_category <> "0") && isset( $row_cat->term_id )){
            $categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'event-category', 'hide_empty' => 0) );
            ?>
            <li class="<?php if(($cs_node->cs_event_category==$filter_category)){echo 'bgcolr';}?>">
                <a href="?<?php echo $qrystr."&filter_category=".$row_cat->slug?>"><?php _e("All",'Faith');?></a>
            </li>
            <?php
            }else{
            $categories = get_categories( array('taxonomy' => 'event-category', 'hide_empty' => 0) );
            }
            foreach ($categories as $category) {
            ?>
                <li <?php if($category->slug==$filter_category){echo 'class="bgcolr"';}?>><a href="?<?php echo $qrystr."&filter_category=".$category->slug?>"><?php echo $category->cat_name?></a>
                </li>
        <?php }?>
        </ul>
    	<!-- Sortby End -->
    <?php }?>
    <div class="event <?php echo $cs_node->cs_event_view;?>">
    
    
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
			if ( $custom_query->have_posts() <> "" ) {
				$width = 330;
				$height=248;
				while ( $custom_query->have_posts() ): $custom_query->the_post();	
				$event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
				$year_event = date("Y", strtotime($event_from_date));
				$month_event = date("m", strtotime($event_from_date));
				$month_event_c = date("M", strtotime($event_from_date));							
				$date_event = date("d", strtotime($event_from_date));
				$image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID),$width,$height ); 
				if($image_url == ''){
					$noimg = ' no-img';
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
                <article <?php post_class($noimg);?>>
                  <?php if($cs_node->cs_event_view == 'event-medium'){ ?>
                  <div class="calendar-date">
                    	<span><?php echo date_i18n('M',strtotime($event_from_date));?></span>
                    	<time datetime="2014-02-01"><?php echo date_i18n('d',strtotime($event_from_date));?></time>
                    </div>
                    
                <?php }elseif($image_url<>''){?>
                    <figure>
                        <a href="<?php the_permalink();?>" > <img src="<?php echo $image_url;?>" alt=""> </a>
                     </figure>
                    <?php }?>
                   
                    <div class="text">
                             <h2 class="cs-post-title">
                                <a href="<?php the_permalink();?>" class="cs-colrhvr"><?php the_title(); ?></a>
                            </h2>
                               <?php if($cs_node->cs_event_view == 'event-listing'){ ?> 
                             <ul class="post-options">
                            	<li><time><?php echo date_i18n(get_option('date_format'),strtotime($event_from_date));?>,
                                <?php if($event_start_time <> ""){?>
                                          <?php if ( $cs_event_meta->event_all_day != "on" ) {?>
 												<?php echo $event_start_time; if($cs_event_meta->event_end_time <> ''){ echo " to ";  echo $cs_event_meta->event_end_time; }?>
                                            <?php } else {
                                                     _e("All",'Statford') . printf( __("%s day",'Statford'), ' ');
                                            }?>
                                 <?php }	?> 
                                 </time></li>
                            </ul>
                            <?php } ?>
                            <?php
                           if($cs_node->cs_event_description == "yes"){
                              ?>
                              <p><?php echo cs_get_the_excerpt($cs_node->cs_event_excerpt,false);?></p>
                          <?php
                          }  
						  
                        ?>
                        <div class="bottom-event">
                        	<ul>
                        	<?php echo cs_bynow_button($cs_event_meta); ?>
							<?php
                            	if($cs_event_meta->event_address <> ''){?>
                                    <li>
                                        <address>
                                            <i class="fa fa-map-marker"></i>
                                           <?php if(is_home() or is_front_page()){ }else{?>
                                            <strong>
                                            <?php if($cs_theme_option['trans_switcher'] == "on"){ 
                                                _e('Location','Statford');}else{ 
                                                echo $cs_theme_option['trans_event_location']; 
                                            } 
                                            ?>: 
                                            </strong>
                                            <?php } ?>
                                            <?php echo get_the_title((int)$cs_event_meta->event_address);?>
                                        </address> 
                                    </li>
                             <?php }?>
                         	</ul>
                        </div> 
                    </div>
                </article>
			<?php
			endwhile; 
 			}
            wp_reset_query();
            ?>
      </div>
		<?php 
        $qrystr = '';
          if ( $cs_node->cs_event_pagination == "Show Pagination" and $count_post > $cs_node->cs_event_per_page and $cs_node->cs_event_per_page > 0 and $cs_node->cs_event_filterables != "Yes" ) {
				if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
					echo cs_pagination($count_post, $cs_node->cs_event_per_page,$qrystr);
        }
        ?>
</div>