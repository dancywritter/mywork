<?php
	global $cs_node, $post, $element_size_class, $cs_counter_node, $cs_theme_option;
	$parallax_element = $cs_node->parallax_element;
	$parallax_height = $cs_node->parallax_height;
	$parallax_margin_top = $cs_node->parallax_margin_top;
	$parallax_margin_bottom = $cs_node->parallax_margin_bottom;
	$parallax_back_top = $cs_node->parallax_back_top;
	// $counter = $post->ID . $count_node;
	cs_enqueue_parallax_script();
?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
        jQuery.stellar({
    		horizontalScrolling: false,
        verticalOffset: 500
 		 });
			parallaxfullwidth ();
		});
	</script>
	<div class="element_size_<?php echo $cs_node->parallax_element_size; ?>">
	<?php
		if ($parallax_element == 'event') {
			if ( !isset($cs_node->album) or $cs_node->album == "" ) { $cs_node->album = ''; }
			if ( !isset($cs_node->parallax_event_title) or $cs_node->parallax_event_title == "" ) { $cs_node->parallax_event_title = ''; }
		?>	
         	<div data-stellar-background-ratio="0.1" class="parallaxbg cs-next-event" style=" <?php 
            	if ($cs_node->parallax_event_img <> '') { ?> 
                      background-image: url(<?php echo $cs_node->parallax_event_img; ?>);<?php } 
                      if(isset($parallax_height) && !empty($parallax_height)){ ?> 
                      height: <?php echo $parallax_height ?>px; <?php }?>  
                      margin-bottom:<?php echo $parallax_margin_bottom?>px; 
                      margin-top:<?php echo $parallax_margin_top?>px;">
                      
                      <div class="cs-parallax-container">
                          <?php if ( isset($cs_node->parallax_event_title) or $cs_node->parallax_event_title <> "" ){?>
                          <h5 class="cs-colr"><?php echo $cs_node->parallax_event_title;?></h5>
                          <?php } ?>
                         
                          <?php
                              $args = array(
                                  'posts_per_page'			=> "1",
                                  'post_type'					=> 'events',
                                  'event-category'			=> " $cs_node->parallax_event_cat",
                                  'post_status'				=> 'publish',
                                  'meta_key'					=> 'cs_event_from_date',
                                  'meta_value'				=> date('Y-m-d'),
                                  'meta_compare'				=> ">=",
                                  'orderby'					=> 'meta_value',
                                  'order'						=> 'ASC',
                               );
                              $custom_query = new WP_Query($args);
                              if ($custom_query->have_posts()) {
                                  cs_enqueue_countdown_script();
                                  ?>
                                  
                                  <?php
                                  while ( $custom_query->have_posts() ): $custom_query->the_post();	
                                      $event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
                                      $year_event = date("Y", strtotime($event_from_date));
                                      $month_event = date("m", strtotime($event_from_date));
                                      $month_event_c = date("M", strtotime($event_from_date));
                                      $date_event = date("d", strtotime($event_from_date));
                                      ?>
                                       <h2 class="cs-post-title"><a href="<?php the_permalink(); ?>" class="cs-colr"><?php the_title(); ?></a></h2>
                                      <h2>in <span id="textLayout" class="countdown"></span></h2>
                                      
                                      <script>
                                      jQuery(document).ready(function($) {
                                          var austDay = new Date();
                                          austDay = new Date(<?php echo $year_event;?>, <?php echo $month_event;?>-1, <?php echo $date_event;?>)
                                           jQuery('#textLayout').countdown({until: austDay,
                                          layout: '<strong>{dn}</strong> {dl}, <strong>{hn}</strong> {hl}, <strong>{mn}</strong> {ml} &amp; <strong>{sn}</strong> {sl} '});
                                      });
                                      </script>
                                      <?php
                                  endwhile;
                                  
                              }else{
                                  cs_no_result_found(false);
                                  
                              }
                          ?>
                         
                          
                      </div>
                
                  </div>
 				<?php
 				}
				elseif ($parallax_element == 'custom') {
				if ( !isset($cs_node->parallax_custom_text) or $cs_node->parallax_custom_text == "" ) { $cs_node->parallax_custom_text = ''; }
				if ( !isset($cs_node->parallax_custom_img) or $cs_node->parallax_custom_img == "" ) { $cs_node->parallax_custom_img = ''; }
				if ( !isset($cs_node->parallax_custom_bgcolor) or $cs_node->parallax_custom_bgcolor == "" ) { $cs_node->parallax_custom_bgcolor = ''; }
		
			?>
			<div data-stellar-background-ratio="0.1" class="parallaxbg cs-custom-parallax"  style=" <?php if ($cs_node->parallax_custom_img <> '') { ?> 
            	background-image:url(<?php echo $cs_node->parallax_custom_img; ?>);<?php } if(isset($cs_node->parallax_height) && !empty($cs_node->parallax_height)){ ?> height: <?php echo $cs_node->parallax_height ?>px; <?php } ?>  margin-bottom:<?php echo $parallax_margin_bottom?>px; margin-top:<?php echo $parallax_margin_top?>px; background-color:<?php echo $cs_node->parallax_custom_bgcolor; ?>;">
                        <div class="cs-parallax-container">
                        	<div class="container">
                                <div class="text">
                                     <?php if ($cs_node->parallax_custom_text <> ''){ echo cs_textarea_filter($cs_node->parallax_custom_text); }?>
                                     <div class="clear"></div>
                                </div>
                             </div>
                            </div>
                     </div>
		<!-- Qoute Start -->
	<?php
	}

?>
</div>