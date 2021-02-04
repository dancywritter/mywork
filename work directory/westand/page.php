<?php get_header(); 
				   	wp_reset_query();
				   	$width =980;
					$height = 408;
					$image_url ='';
					$image_url = cs_get_post_img_src($post->ID, $width, $height);
					if (post_password_required()) { 
						
						echo '<div class="rich_editor_text">'.cs_password_form().'</div>';
					}else{
					$cs_meta_page = cs_meta_page('cs_page_builder');
					if (count($cs_meta_page) > 0) {
						if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout <> "none" and $cs_meta_page->sidebar_layout->cs_layout == 'left') :   ?>
            				<aside class="col-md-3">
                     			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_meta_page->sidebar_layout->cs_sidebar_left) ) : endif; ?>
                     		</aside>
                		<?php endif; ?>
                        <?php if ( $cs_meta_page->cs_layout == 'both_left') :   ?>
						   <?php cs_meta_sidebar();?>
                        <?php endif; ?>
               	 		<div class="<?php echo cs_meta_content_class();  ?> ">
                        <?php 
 						
						
						if($image_url <> ''){ 
					  		echo '<figure class="featured-img"><a href="'.get_permalink().'" ><img src="'.$image_url.'" alt="" ></a></figure>';
					   	}
						if($cs_meta_page->page_content == "Yes" && get_the_content() <> ''){
 							echo '<div class="rich_editor_text">';
								the_content();
								wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'WeStand' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
 							echo '</div>';
						}
						global $cs_counter_node;
						foreach ( $cs_meta_page->children() as $cs_node ) {
							
   							if ( $cs_node->getName() == "blog" ) {
								$cs_counter_node++;
								$layout = $cs_meta_page->sidebar_layout->cs_layout;
								get_template_part( 'page_blog', 'page' );
 							}
							else if ( $cs_node->getName() == "gallery" ) {
								$cs_counter_node++;
  								if ( $cs_node->album <> "" and $cs_node->album <> "0" ) {
									get_template_part( 'page_gallery', 'page' );
								}
							}
							else if ( $cs_node->getName() == "event" ) {
								$cs_counter_node++;
 								if ( $cs_node->cs_event_category <> "") {
									get_template_part( 'page_event', 'page' );
								}
							}
							elseif($cs_node->getName() == "cause"){

							   $cs_counter_node++;

							   get_template_part('page_cause','page');

 							}
							else if ( $cs_node->getName() == "slider"  and $cs_node->slider_view == "content") {
								$cs_counter_node++;
 								get_template_part( 'page_slider', 'page' );
 							}
														
							elseif($cs_node->getName() == "contact"){
							   $cs_counter_node++;
							   get_template_part('page_contact','page');
 							}
							else if ( $cs_node->getName() == "team" ) {
								$cs_counter_node++;
								get_template_part( 'page_team', 'page' );
							}
							
							
							elseif($cs_node->getName() == "accordions"){
								$cs_counter_node++;
								cs_accordions_page();
							}
							elseif($cs_node->getName() == "tabs"){
								$cs_counter_node++;
								echo cs_tabs_page();
							}
							elseif ($cs_node->getName() == "services") {
                                $cs_counter_node++;
                                cs_services_page();
                            }
							elseif($cs_node->getName() == "video"){
								$cs_counter_node++;
								echo cs_video_page();
							}
							elseif($cs_node->getName() == "quote"){
								$cs_counter_node++;
								echo cs_quote_page();
							}
							
 							elseif($cs_node->getName() == "column"){
								$cs_counter_node++;
								cs_column_page();
							}
							
							elseif($cs_node->getName() == "map"  and $cs_node->map_view == "content"){
								$cs_counter_node++;
								echo cs_map_page();
							}
							elseif ($cs_node->getName() == "parallax") {
                                $cs_counter_node++;
								get_template_part('page_parallax','page');
                            }
							
							

						}
                     	wp_reset_query(); 
					 	if ( comments_open() ) : 
					 		comments_template('', true); 
		   				endif; 
						?>
                 </div>
						<?php if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout <> "none" and $cs_meta_page->sidebar_layout->cs_layout == 'right') : ?>
                            <aside class="col-md-3">
                                    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_meta_page->sidebar_layout->cs_sidebar_right) ) : endif; ?>
                             </aside>
                        <?php endif; ?>
                       
             		<?php }else{ 
						if($image_url <> ''){ 
					  		echo '<figure class="featured-img"><a href="'.get_permalink().'" ><img src="'.$image_url.'" alt="" ></a></figure>';
					   	}
					?>
            		<div class="rich_editor_text">
					<?php 
                        while (have_posts()) : the_post();
                            the_content();
							wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'WeStand' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                        endwhile; 
						if ( comments_open() ) { 
					 		comments_template('', true); 
						}
						wp_reset_query();
                    ?>
                </div>
			<?php }
			} 
		?>
<?php get_footer();?>
<!-- Columns End -->