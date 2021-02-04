<?php get_header(); ?>
<?php 
	wp_reset_query();
	cs_enqueue_flexslider_script();
	if (post_password_required()) { 
	  
	  echo '<div class="rich_editor_text">'.cs_password_form().'</div>';
	}else{
	$cs_meta_page = cs_meta_page('cs_page_builder');
	if (count($cs_meta_page) > 0) {
	  if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout <> "none" and $cs_meta_page->sidebar_layout->cs_layout == 'left' or  $cs_meta_page->sidebar_layout->cs_layout == 'both') :   ?>
		  <aside class="sidebar-left span3">
			  <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_meta_page->sidebar_layout->cs_sidebar_left) ) : endif; ?>
		  </aside>
	  <?php endif; ?>
	  <?php if ( $cs_meta_page->cs_layout == 'both_left') :   ?>
		 <?php cs_meta_sidebar();?>
	  <?php endif; ?>
	  <div class="<?php echo cs_meta_content_class();  ?> ">
	  <?php
	  wp_reset_query();
	  if($cs_meta_page->page_content == "Yes"){
		  echo '<div class="rich_editor_text">';
			  the_content();
			  wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Rocky' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
		  echo '</div>';
	  }
	  global $cs_counter_node;
	  if ( count($cs_meta_page) > 0 ) {
			  echo '<div class="element-size-parent">';
		  }
	  foreach ( $cs_meta_page->children() as $cs_node ) {
 		  if ( $cs_node->getName() == "blog" ) {
			  $cs_counter_node++;
			  $layout = $cs_meta_page->sidebar_layout->cs_layout;
			  if ( $cs_node->cs_blog_cat <> "" and $cs_node->cs_blog_cat <> "0" ) 
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
			  if ( $cs_node->cs_event_category <> "" and $cs_node->cs_event_category <> "0" ) {
				  get_template_part( 'page_event', 'page' );
			  }
		  }
		  else if ( $cs_node->getName() == "prayer" ) {
			  $cs_counter_node++;
			  get_template_part( 'page_prayer', 'page' );
		  }
		  else if ( $cs_node->getName() == "slider"  and $cs_node->slider_view == "content") {
			  $cs_counter_node++;
			  get_template_part( 'page_slider', 'page' );
		  }
		  elseif($cs_node->getName() == "contact"){
			 $cs_counter_node++;
			 get_template_part('page_contact','page');
		  }
		  elseif($cs_node->getName() == "portfolio"){
			 $cs_counter_node++;
			 if ( $cs_node->portfolio_cat <> "" and $cs_node->portfolio_cat <> "0" ) {
				  get_template_part( 'page_portfolio', 'page' );
			 }
		  }
		  elseif($cs_node->getName() == "client"){
			  $cs_counter_node++;
			  cs_client_page();
		  }
		  elseif($cs_node->getName() == "column"){
			  $cs_counter_node++;
			  cs_column_page();
		  }
		  elseif($cs_node->getName() == "divider"){
			  $cs_counter_node++;
			  echo cs_divider_page();
		  }
		  elseif($cs_node->getName() == "message_box"){
			  $cs_counter_node++;
			  cs_message_box_page();
		  }
		  elseif($cs_node->getName() == "image"){
			  $cs_counter_node++;
			  echo cs_image_page();
		  }
		  elseif($cs_node->getName() == "map" and $cs_node->map_view == "content"){
			  $cs_counter_node++;
			  echo cs_map_page();
		  }
		  elseif($cs_node->getName() == "video"){
			  $cs_counter_node++;
			  echo cs_video_page();
		  }
		  elseif($cs_node->getName() == "quote"){
			  $cs_counter_node++;
			  echo cs_quote_page();
		  }
		  elseif($cs_node->getName() == "dropcap"){
			  $cs_counter_node++;
			  echo cs_dropcap_page();
		  }
		  elseif($cs_node->getName() == "pricetable"){
			  $cs_counter_node++;
			  cs_pricetable_page();
		  }
		  elseif ($cs_node->getName() == "services") {
			  $cs_counter_node++;
			  cs_services_page();
		  }
		  elseif($cs_node->getName() == "tabs"){
			  $cs_counter_node++;
			  echo cs_tabs_page();
		  }
		  elseif($cs_node->getName() == "accordions"){
			  $cs_counter_node++;
			  cs_accordions_page();
		  }
		  elseif ($cs_node->getName() == "parallax") {
			  $cs_counter_node++;
			  get_template_part('page_parallax','page');
		  }
	  }
	  if ( count($cs_meta_page) > 0 ) {
			  echo '</div>';
		  }
	  wp_reset_query(); 
	  if ( comments_open() ) : 
		  comments_template('', true); 
	  endif; 
	  ?>
	</div>
    
	  <?php if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout <> "none" and $cs_meta_page->sidebar_layout->cs_layout == 'right' or $cs_meta_page->sidebar_layout->cs_layout == 'both') : ?>
		  <aside class="sidebar-right span3">
				  <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_meta_page->sidebar_layout->cs_sidebar_right) ) : endif; ?>
		   </aside>
	  <?php endif; ?>
	  <?php if ( $cs_meta_page->cs_layout <> '' and $cs_meta_page->cs_layout <> "none" and $cs_meta_page->cs_layout == 'both_right') : ?>
	<?php cs_meta_sidebar()?> 
	<?php endif; ?>
	<?php }else{ ?>
	<div class="rich_editor_text">
	<?php 
	  while (have_posts()) : the_post();
		  the_content();
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
