<?php get_header(); ?>

	<div class="main-section">
				<?php 
					wp_reset_query();
					if (post_password_required()) { 
						echo '<div class="rich_editor_text">'.cs_password_form().'</div>';
					}else{
					$cs_meta_page = cs_meta_page('cs_page_builder');
					if (count($cs_meta_page) > 0) {
						$classes = '';
						foreach ( $cs_meta_page->children() as $cs_node ) {
							if ( $cs_node->getName() == "gallery" ) {
								$classes = 'cs-template-'.$cs_node->layout;
							}
						}
					 
  						wp_reset_query();
						if(has_post_thumbnail()){
							cs_enqueue_parallax();
							?>
                            <script type="text/javascript">
								jQuery(document).ready(function() {
                            		cs_parallax();
								});
								jQuery(window).resize(function() {
                            		cs_parallax();
								});
                            </script>
                            <?php
							$width = 800;
							$height = 800;
							$cs_feature_class= 'cs-featured-image';
							$image_id = cs_get_post_img($post->ID, $width,$height);
							echo '<figure class="parallaxbg featured-img-wrapper inline-item">'.$image_id.'</figure>';
						}else{
							$cs_feature_class= '';
						} 
						
						echo '<div class="right-content '.$classes.' '.$cs_feature_class.'">';
 						if($cs_meta_page->page_content == "Yes" or $cs_meta_page->page_title == "Yes"){
							
 							echo '<div class="rich_editor_text"><div class="column-wrapp-box heading-area">
                            <div class="detail_text_wrapp col-counter">';
							if($cs_meta_page->page_title == "Yes"){ echo '<h2 class="page-title cs-heading-color">'.get_the_title().'</h2>'; }
							if(get_the_content() <> ""){
									the_content();
									wp_link_pages();
									}
								echo '</div>
									 </div>
                        </div>';
							
						}
						global $counter_node;
						foreach ( $cs_meta_page->children() as $cs_node ) {
							
   							if ( $cs_node->getName() == "blog" ) {
								$counter_node++;
								$layout = $cs_meta_page->sidebar_layout->cs_layout;
								if ( $cs_node->cs_blog_cat <> "" and $cs_node->cs_blog_cat <> "0" ) 
								get_template_part( 'page_blog', 'page' );
 							}
							else if ( $cs_node->getName() == "gallery" ) {
								$counter_node++;
  								if ( $cs_node->album <> "" and $cs_node->album <> "0" ) {
 									get_template_part( 'page_gallery', 'page' );
								}
							}
							else if ( $cs_node->getName() == "event" ) {
								$counter_node++;
 								if ( $cs_node->cs_event_category <> "" and $cs_node->cs_event_category <> "0" ) {
									get_template_part( 'page_event', 'page' );
								}
							}
							elseif($cs_node->getName() == "contact"){
							   $counter_node++;
							   get_template_part('page_contact','page');
 							}
							elseif($cs_node->getName() == "artists"){
							   $counter_node++;
								get_template_part( 'page_artists', 'page' );
							}
							elseif($cs_node->getName() == "album"){
							   $counter_node++;
								get_template_part( 'page_album', 'page' );
							}
 						  	elseif($cs_node->getName() == "client"){
								$counter_node++;
								cs_client_page();
							}
							elseif($cs_node->getName() == "column"){
								$counter_node++;
								cs_column_page();
							}
							elseif($cs_node->getName() == "divider"){
								$counter_node++;
								echo cs_divider_page();
							}
							elseif($cs_node->getName() == "message_box"){
								$counter_node++;
								cs_message_box_page();
							}
							elseif($cs_node->getName() == "image"){
								$counter_node++;
								echo cs_image_page();
							}
							elseif($cs_node->getName() == "map" and $cs_node->map_view == "content"){
								$counter_node++;
								echo cs_map_page();
							}
							elseif($cs_node->getName() == "video"){
								$counter_node++;
								echo cs_video_page();
							}
							elseif($cs_node->getName() == "quote"){
								$counter_node++;
								echo cs_quote_page();
							}
							elseif($cs_node->getName() == "dropcap"){
								$counter_node++;
								echo cs_dropcap_page();
							}
							elseif($cs_node->getName() == "pricetable"){
								$counter_node++;
								cs_pricetable_page();
							}
							elseif ($cs_node->getName() == "services") {
                                $counter_node++;
                                cs_services_page();
                            }
							elseif($cs_node->getName() == "tabs"){
								$counter_node++;
								echo cs_tabs_page();
							}
							elseif($cs_node->getName() == "accordions"){
								$counter_node++;
								cs_accordions_page();
							}
						}
                     	wp_reset_query(); 
					 	echo '</div>';
						if ( comments_open() ){
					 		comments_template('', true); 
						}else{
 						 		echo '<div class="cs-hide-div" style="width:20px; display:inline-block;"></div>';	
							 
						}
						
						
						?>
                        
                         
             		<?php }else{
						if(has_post_thumbnail()){
							cs_enqueue_parallax();
							?>
                            <script type="text/javascript">
								jQuery(document).ready(function() {
                            		cs_parallax();
								});
								jQuery(window).resize(function() {
                            		cs_parallax();
								});
                            </script>
                            <?php
							$width = 800;
							$height = 800;
							$cs_feature_class= 'cs-featured-image';
							$image_id = cs_get_post_img($post->ID, $width,$height);
							echo '<figure class="parallaxbg featured-img-wrapper inline-item">'.$image_id.'</figure>';
						}else{
							$cs_feature_class= '';
						} 
						
						 ?>
                    <div class="right-content <?php echo $cs_feature_class; ?>">
                     <div class="rich_editor_text">
                     	<div class="column-wrapp-box heading-area">
                        	<div class="detail_text_wrapp col-counter">
								<?php 
                                    while (have_posts()) : the_post();
                                        the_content();
										wp_link_pages();
                                    endwhile; 
                                ?>
                    		</div>
                    	</div>
                    </div>
                    <?php 
						 if ( comments_open() ) { 
							comments_template('', true); 
						}
					wp_reset_query();
					?>
					
                 </div>
			<?php }
			} 
		?>
	</div> 
         
<!-- main End --> 
<?php get_footer();?>
<!-- Columns End -->