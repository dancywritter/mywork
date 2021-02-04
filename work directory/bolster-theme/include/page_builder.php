<?php
global $cs_theme_option;
add_action( 'add_meta_boxes', 'cs_page_bulider_add' );
function cs_page_bulider_add() {
	add_meta_box( 'id_page_builder', 'Page Options', 'cs_page_bulider', 'page', 'normal', 'high' );  
}  
function cs_page_bulider( $post ) {
?>
    <div class="page-wrap page-opts" style="overflow:hidden; position:relative; height: 705px;">
        <div class="page-builder">
            <div class="page-head">
                <h5>Layout Sections</h5>
                <div class="add-widget">
                    <span class="addwidget">+ Add Page Elements</span>
                    <div class="widgets-list">
                        <a href="javascript:ajaxSubmit('cs_pb_album')">Album</a>
                        <a href="javascript:ajaxSubmit('cs_pb_blog')">Blog</a>
                        <a href="javascript:ajaxSubmit('cs_pb_column')">Column</a>
                        <a href="javascript:ajaxSubmit('cs_pb_contact')">Contact</a>
                        <a href="javascript:ajaxSubmit('cs_pb_event')">Events</a>
                        <a href="javascript:ajaxSubmit('cs_pb_gallery')">Gallery</a>
                        <a href="javascript:ajaxSubmit('cs_pb_map')">Map</a>
                        <a href="javascript:ajaxSubmit('cs_pb_artists')">Artists</a>
                     </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div id="add_page_builder_item">
            <?php
				global $cs_node, $count_node, $cs_xmlObject,$cs_theme_option;
                $count_node = 0;
				$count_widget = 0;
				$page_title = '';
				$page_content = '';
 				$header_banner = '';
				$slider_id = '';
				$header_styles = '';
				$switch_footer_widgets = '';
                $cs_page_bulider = get_post_meta($post->ID, "cs_page_builder", true);
 				if ( $cs_page_bulider <> "" ) {
                   	$cs_xmlObject = new stdClass();
					$cs_xmlObject = new SimpleXMLElement($cs_page_bulider);
 						$count_widget = count($cs_xmlObject->children())-10;
                        foreach ( $cs_xmlObject->children() as $cs_node ){
							if ( $cs_node->getName() == "gallery" ) { cs_pb_gallery(1); }
							else if ( $cs_node->getName() == "blog" ) { cs_pb_blog(1); }
 							else if ( $cs_node->getName() == "event" ) { cs_pb_event(1); }
							else if ( $cs_node->getName() == "artists" ) { cs_pb_artists(1); }
							else if ( $cs_node->getName() == "album" ) { cs_pb_album(1); }
 							else if ( $cs_node->getName() == "contact" ) { cs_pb_contact(1); }
							else if ( $cs_node->getName() == "column" ) { cs_pb_column(1); }
							else if ( $cs_node->getName() == "map" ) { cs_pb_map(1); }
                          }
                }
 				if ( $cs_page_bulider <> "" ) {
					if ( isset($cs_xmlObject->page_title) ) $page_title = $cs_xmlObject->page_title;
					if ( isset($cs_xmlObject->page_content) ) $page_content = $cs_xmlObject->page_content;
					if ( isset($cs_xmlObject->slider_id) ) $slider_id = htmlspecialchars($cs_xmlObject->slider_id);
					if ( isset($cs_xmlObject->switch_footer_widgets) ) $switch_footer_widgets = $cs_xmlObject->switch_footer_widgets;
  				}else{
					//$header_styles = $cs_theme_option['default_header'];	
				}
			?>
            <div id="no_widget" class="placehoder">Page Builder is Empty, Please Select Page Element. <img src="<?php echo get_template_directory_uri()?>/images/admin/bg-arrowup.png" alt="" /></div>
        </div>
		<div id="loading" class="builderload"></div>
         <div class="clear"></div>
           <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/prettyCheckable.js"></script>
            <div class="elementhidden">
                <ul class="form-elements">
                    <li class="to-label"><label>Show Page Title</label></li>
                    <li class="to-field">
                        <select name="page_title" class="dropdown">
                            <option value="Yes" <?php if($page_title=="Yes")echo "selected";?> >Yes</option>
                            <option value="No" <?php if($page_title=="No")echo "selected";?> >No</option>
                        </select>
                        <p>Show the title of the page.</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Show Page Description</label></li>
                    <li class="to-field">
                        <select name="page_content" class="dropdown">
                            <option value="Yes" <?php if($page_content=="Yes")echo "selected";?> >Yes</option>
                            <option value="No" <?php if($page_content=="No")echo "selected";?> >No</option>
                        </select>
                        <p>Show the description of the page.</p>
                    </li>
                </ul>
            </div>
          <input type="hidden" name="cs_orderby[]" value="cs_metalayout" />   
        <input type="hidden" name="page_builder_form" value="1" />
        <div class="clear"></div>
    </div>
<div class="clear"></div>
	
    <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery.scrollTo-min.js"></script>
    <script type="text/javascript">
		jQuery(function() {
			jQuery( "#add_page_builder_item" ).sortable({
				cancel : 'div div.poped-up'
			});
			//jQuery( "#add_page_builder_item" ).disableSelection();
		});
    </script>
	<script type="text/javascript">
		var count_widget = <?php echo $count_widget ; ?>;
        function ajaxSubmit(action){
 			counter++;
			count_widget++;
            var newCustomerForm = "action=" + action + '&counter=' + counter;
            jQuery.ajax({
                type:"POST",
                url: "<?php echo home_url()?>/wp-admin/admin-ajax.php",
                data: newCustomerForm,
                success:function(data){
                    jQuery("#add_page_builder_item").append(data);
					if (count_widget > 0) jQuery("#add_page_builder_item").addClass('hasclass');
					//alert(count_widget);
                }
            });
            //return false;
        }
    </script>

<?php  
}
	if ( isset($_POST['page_builder_form']) and $_POST['page_builder_form'] == 1 ) {
		add_action( 'save_post', 'save_page_builder' );
		function save_page_builder( $post_id ) {
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
				if ( isset($_POST['cs_orderby']) ) {
					//creating xml page builder start
					$sxe = new SimpleXMLElement("<pagebuilder></pagebuilder>");
						if (empty($_POST['page_title']))$_POST['page_title'] = "";
						$sxe->addChild('page_title', $_POST['page_title']);
						$sxe->addChild('page_content', $_POST['page_content']);
						
							if ( isset($_POST['cs_orderby']) ) {
								$counter = 0;
								$counter_gal = 0;
								$counter_port = 0;
								$counter_event = 0;
								$counter_artist = 0;
								$counter_slider = 0;
								$counter_blog = 0;
								$counter_news = 0;
								$counter_contact = 0;
								$counter_testimonial = 0;
								$counter_client = 0;
 								$counter_column = 0;
								$counter_mb = 0;
								$counter_map = 0;
								$counter_testimonial = 0;
								$counter_testimonial_node = 0;

								$counter_album = 0;
 								foreach ( $_POST['cs_orderby'] as $count ){
									if ( $_POST['cs_orderby'][$counter] == "gallery" ) {
										$gallery = $sxe->addChild('gallery');
											$gallery->addChild('header_title', $_POST['cs_gal_header_title'][$counter_gal] );
											$gallery->addChild('layout', $_POST['cs_gal_layout'][$counter_gal] );
											$gallery->addChild('cs_gal_show_thumbnail', $_POST['cs_gal_show_thumbnail'][$counter_gal] );
											$gallery->addChild('cs_gal_image_size', $_POST['cs_gal_image_size'][$counter_gal] );
											$gallery->addChild('cs_gal_show_pagination', $_POST['cs_gal_show_pagination'][$counter_gal] );
											$gallery->addChild('album', $_POST['cs_gal_album'][$counter_gal] );
 											$gallery->addChild('margin_left', $_POST['cs_gal_margin_left'][$counter_gal] );
											$gallery->addChild('thumb_space', $_POST['cs_gal_thumb_space'][$counter_gal] );
 											$gallery->addChild('media_per_page', $_POST['cs_gal_media_per_page'][$counter_gal] );
											$gallery->addChild('cs_images_per_gallery', $_POST['cs_images_per_gallery'][$counter_gal] );
 											$gallery->addChild('gallery_element_size', $_POST['gallery_element_size'][$counter_gal] );
										$counter_gal++;
									}
									else if ( $_POST['cs_orderby'][$counter] == "blog" ) {
										$blog = $sxe->addChild('blog');
											$blog->addChild('cs_blog_title', htmlspecialchars($_POST['cs_blog_title'][$counter_blog]) );
											$blog->addChild('cs_blog_cat', $_POST['cs_blog_cat'][$counter_blog] );
											$blog->addChild('cs_blog_sidebar', $_POST['cs_blog_sidebar'][$counter_blog] );
											$blog->addChild('cs_blog_view', $_POST['cs_blog_view'][$counter_blog] );
											$blog->addChild('cs_blog_excerpt', $_POST['cs_blog_excerpt'][$counter_blog] );
											$blog->addChild('cs_blog_left_space', $_POST['cs_blog_left_space'][$counter_blog] );
 											$blog->addChild('cs_blog_num_post', $_POST['cs_blog_num_post'][$counter_blog] );
 											$blog->addChild('cs_blog_description', $_POST['cs_blog_description'][$counter_blog] );
											$blog->addChild('blog_element_size', $_POST['blog_element_size'][$counter_blog] );
											$blog->addChild('cs_featured_post', $_POST['cs_featured_post'][$counter_blog] );
											
										$counter_blog++;
									}
 									else if ( $_POST['cs_orderby'][$counter] == "event" ) {
										$event = $sxe->addChild('event');
											$event->addChild('cs_event_title', htmlspecialchars($_POST['cs_event_title'][$counter_event]) );
											$event->addChild('cs_event_view', $_POST['cs_event_view'][$counter_event] );
											$event->addChild('cs_event_type', $_POST['cs_event_type'][$counter_event] );
											$event->addChild('cs_event_category', $_POST['cs_event_category'][$counter_event] );
 											$event->addChild('cs_event_showmap', $_POST['cs_event_showmap'][$counter_event] );
											$event->addChild('cs_event_map_width', $_POST['cs_event_map_width'][$counter_event] );
											$event->addChild('cs_event_map_zoom', $_POST['cs_event_map_zoom'][$counter_event] );
											$event->addChild('cs_event_map_type', $_POST['cs_event_map_type'][$counter_event] );
											$event->addChild('cs_event_map_controls', $_POST['cs_event_map_controls'][$counter_event] );
											$event->addChild('cs_event_map_draggable', $_POST['cs_event_map_draggable'][$counter_event] );
											$event->addChild('cs_event_map_scrollwheel', $_POST['cs_event_map_scrollwheel'][$counter_event] );
											$event->addChild('cs_event_filterables', $_POST['cs_event_filterables'][$counter_event] );
											$event->addChild('cs_event_per_page', $_POST['cs_event_per_page'][$counter_event] );
										$counter_event++;
									}
									else if ( $_POST['cs_orderby'][$counter] == "artists" ) {
										$artist = $sxe->addChild('artists');
											$artist->addChild('cs_artist_title', htmlspecialchars($_POST['cs_artist_title'][$counter_artist]) );
											$artist->addChild('cs_artist_view', $_POST['cs_artist_view'][$counter_artist] );
											$artist->addChild('cs_artist_category', $_POST['cs_artist_category'][$counter_artist] );
											$artist->addChild('cs_artist_filterables', $_POST['cs_artist_filterables'][$counter_artist] );
											$artist->addChild('cs_artist_per_page', $_POST['cs_artist_per_page'][$counter_artist] );
										$counter_artist++;
									}
 									else if ( $_POST['cs_orderby'][$counter] == "album" ) {
										$album = $sxe->addChild('album');
											$album->addChild('cs_album_title', htmlspecialchars($_POST['cs_album_title'][$counter_album]) );
											$album->addChild('cs_album_cat', $_POST['cs_album_cat'][$counter_album] );
											$album->addChild('cs_album_filterable', $_POST['cs_album_filterable'][$counter_album] );
											$album->addChild('cs_album_cat_show', $_POST['cs_album_cat_show'][$counter_album] );
											$album->addChild('cs_album_buynow', $_POST['cs_album_buynow'][$counter_album] );
 											$album->addChild('cs_album_per_page', $_POST['cs_album_per_page'][$counter_album] );
											$album->addChild('album_element_size', $_POST['album_element_size'][$counter_album] );
										$counter_album++;
									}
									else if ( $_POST['cs_orderby'][$counter] == "contact" ) {
										$contact = $sxe->addChild('contact');
 											$contact->addChild('cs_contact_email', $_POST['cs_contact_email'][$counter_contact] );
											$contact->addChild('cs_contact_succ_msg', $_POST['cs_contact_succ_msg'][$counter_contact] );
											$contact->addChild('cs_contact_form_text', $_POST['cs_contact_form_text'][$counter_contact] );
											$contact->addChild('contact_element_size', $_POST['contact_element_size'][$counter_contact] );
										$counter_contact++;
									}
									else if ( $_POST['cs_orderby'][$counter] == "column" ) {
										$column = $sxe->addChild('column');
											$column->addChild('column_element_size', htmlspecialchars($_POST['column_element_size'][$counter_column]) );
											$column->addChild('column_text', $_POST['column_text'][$counter_column] );
										$counter_column++;
									}
									else if ( $_POST['cs_orderby'][$counter] == "map" ) {
										$divider = $sxe->addChild('map');
											$divider->addChild('map_element_size', htmlspecialchars($_POST['map_element_size'][$counter_map]) );
											$divider->addChild('map_title', htmlspecialchars($_POST['map_title'][$counter_map]) );
											$divider->addChild('map_width', htmlspecialchars($_POST['map_width'][$counter_map]) );
											$divider->addChild('map_height', htmlspecialchars($_POST['map_height'][$counter_map]) );
											$divider->addChild('map_lat', htmlspecialchars($_POST['map_lat'][$counter_map]) );
											$divider->addChild('map_lon', htmlspecialchars($_POST['map_lon'][$counter_map]) );
											$divider->addChild('map_zoom', htmlspecialchars($_POST['map_zoom'][$counter_map]) );
											$divider->addChild('map_type', htmlspecialchars($_POST['map_type'][$counter_map]) );
											$divider->addChild('map_info', $_POST['map_info'][$counter_map] );
											$divider->addChild('map_info_width', $_POST['map_info_width'][$counter_map] );
											$divider->addChild('map_info_height', $_POST['map_info_height'][$counter_map] );
											$divider->addChild('map_marker_icon', $_POST['map_marker_icon'][$counter_map] );
											$divider->addChild('map_show_marker', $_POST['map_show_marker'][$counter_map] );
											$divider->addChild('map_controls', $_POST['map_controls'][$counter_map] );
											$divider->addChild('map_draggable', htmlspecialchars($_POST['map_draggable'][$counter_map]) );
											$divider->addChild('map_scrollwheel', htmlspecialchars($_POST['map_scrollwheel'][$counter_map]) );
											$divider->addChild('map_view', htmlspecialchars($_POST['map_view'][$counter_map]) );

										$counter_map++;
									}
									$counter++;
								}
							}
							update_post_meta( $post_id, 'cs_page_builder', $sxe->asXML() );
					//creating xml page builder end
				}
		}
	}
?>