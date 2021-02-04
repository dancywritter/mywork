<?php get_header();  
					wp_reset_query();
					
					if (post_password_required()) { 
					
						
						echo '<div class="rich_editor_text">'.px_password_form().'</div>';
					}else{
					$px_meta_page = px_meta_page('px_page_builder');
					if (count($px_meta_page) > 0) {
						 ?>
               	 		<div class="col-md-12 page_element_area">
						<?php
 						wp_reset_query();
						
							if($px_theme_option['announcement_blog_category'] <> '' && (is_home() || is_front_page())){
									fnc_announcement();
								}
							if( $px_meta_page->page_content == "on"  && get_the_content() <> ''){
 							echo '<div class="rich_editor_text">';
								
								if( $px_meta_page->page_content == "on"  && get_the_content() <> ''){
									the_content();
									wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Rocky' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
								}
 							echo '</div>';
						}
						global $px_counter_node;
						foreach ( $px_meta_page->children() as $px_node ) {
							if ( $px_node->getName() == "blog" ) {
								if ( !isset($_SESSION["px_page_back"]) ||  isset($_SESSION["px_page_back"])){
									$_SESSION["px_page_back"] = get_the_ID();
								}
								$px_counter_node++;
								get_template_part( 'page_blog', 'page' );
 							}else if ( $px_node->getName() == "gallery" ) {
								$px_counter_node++;
  								if ( $px_node->album <> "" and $px_node->album <> "0" ) {
									get_template_part( 'page_gallery', 'page' );
								}
							}else if ( $px_node->getName() == "sermon" ) {
								$px_counter_node++;
								if ( !isset($_SESSION["px_page_back_sermon"]) ||  isset($_SESSION["px_page_back_sermon"])){
									$_SESSION["px_page_back_sermon"] = get_the_ID();
								}
									get_template_part( 'page_sermon', 'page' );
							}else if ( $px_node->getName() == "event" ) {
								if ( !isset($_SESSION["px_page_back_event"]) ||  isset($_SESSION["px_page_back_event"])){
									$_SESSION["px_page_back_event"] = get_the_ID();
								}
								$px_counter_node++;
									get_template_part( 'page_event', 'page' );
							}elseif($px_node->getName() == "team"){
							   	$px_counter_node++;
								get_template_part( 'page_team', 'page' );
 							}elseif($px_node->getName() == "contact"){
							   $px_counter_node++;
							   get_template_part('page_contact','page');
							}elseif($px_node->getName() == "column"){
								$px_counter_node++;
								px_column_page();
							}
						}
                     	wp_reset_query(); 
					 	if ( comments_open() ) : 
					 		comments_template('', true); 
		   				endif; 
						?>
                 </div>
						
                       
             		<?php }else{ ?>
            		<div class="rich_editor_text">
					<?php 
                        while (have_posts()) : the_post();
                            the_content();
							wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Rocky' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
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