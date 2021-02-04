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
                        <a href="javascript:ajaxSubmit('cs_pb_accordion')">Accordion</a>
                        <a href="javascript:ajaxSubmit('cs_pb_blog')">Blog</a>
                        <a href="javascript:ajaxSubmit('cs_pb_column')">Column</a>
                        <a href="javascript:ajaxSubmit('cs_pb_contact')">Contact</a>
                        <a href="javascript:ajaxSubmit('cs_pb_divider')">Divider</a>
                        <a href="javascript:ajaxSubmit('cs_pb_dropcap')">Dropcap</a>
                        <a href="javascript:ajaxSubmit('cs_pb_event')">Events</a>
                        <a href="javascript:ajaxSubmit('cs_pb_gallery')">Gallery</a>
                        <a href="javascript:ajaxSubmit('cs_pb_image')">Image Frame</a>
                        <a href="javascript:ajaxSubmit('cs_pb_map')">Map</a>
                        <a href="javascript:ajaxSubmit('cs_pb_client')">Our Clients</a>
                        <a href="javascript:ajaxSubmit('cs_pb_portfolio')">Portfolio</a>
                        <a href="javascript:ajaxSubmit('cs_pb_prayer')">Prayer</a>
                        <a href="javascript:ajaxSubmit('cs_pb_pricetable')">Price Table</a>
                        <a href="javascript:ajaxSubmit('cs_pb_quote')">Quote</a>
                        <a href="javascript:ajaxSubmit('cs_pb_services')">Services</a>
                        <a href="javascript:ajaxSubmit('cs_pb_slider')">Slider</a>
                        <a href="javascript:ajaxSubmit('cs_pb_tabs')">Tabs</a>
                        <a href="javascript:ajaxSubmit('cs_pb_parallax')">Parallax</a>
						<a href="javascript:ajaxSubmit('cs_pb_video')">Video</a>
                     </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div id="add_page_builder_item">
            <?php
				global $cs_node, $cs_count_node, $cs_xmlObject,$cs_theme_option;
                $cs_count_node = 0;
				$count_widget = 0;
				$page_title = '';
				$page_content = '';
				$page_sub_title = '';
				$header_banner_options = '';
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
							else if ( $cs_node->getName() == "slider" ) { cs_pb_slider(1); }
							else if ( $cs_node->getName() == "blog" ) { cs_pb_blog(1); }
 							else if ( $cs_node->getName() == "event" ) { cs_pb_event(1); }
   							else if ( $cs_node->getName() == "portfolio" ) { cs_pb_portfolio(1); }
   							else if ( $cs_node->getName() == "prayer" ) { cs_pb_prayer(1); }
 							else if ( $cs_node->getName() == "contact" ) { cs_pb_contact(1); }
							else if ( $cs_node->getName() == "client" ) { cs_pb_client(1); }
							else if ( $cs_node->getName() == "column" ) { cs_pb_column(1); }
							else if ( $cs_node->getName() == "divider" ) { cs_pb_divider(1); }
 							else if ( $cs_node->getName() == "image" ) { cs_pb_image(1); }
							else if ( $cs_node->getName() == "map" ) { cs_pb_map(1); }
							else if ( $cs_node->getName() == "video" ) { cs_pb_video(1); }
							else if ( $cs_node->getName() == "quote" ) { cs_pb_quote(1); }
							else if ( $cs_node->getName() == "dropcap" ) { cs_pb_dropcap(1); }
							else if ( $cs_node->getName() == "pricetable" ) { cs_pb_pricetable(1); }
							else if ( $cs_node->getName() == "tabs" ) { cs_pb_tabs(1); }
							else if ( $cs_node->getName() == "accordions" ) { cs_pb_accordion(1); }
							else if ( $cs_node->getName() == "services" ) { cs_pb_services(1); }
							else if ( $cs_node->getName() == "parallax" ) { cs_pb_parallax(1); }
                         }
                }
 				if ( $cs_page_bulider <> "" ) {
					if ( isset($cs_xmlObject->page_title) ) $page_title = $cs_xmlObject->page_title;
					if ( isset($cs_xmlObject->page_content) ) $page_content = $cs_xmlObject->page_content;
					if ( isset($cs_xmlObject->page_sub_title) ) $page_sub_title = $cs_xmlObject->page_sub_title;
					if ( isset($cs_xmlObject->header_banner_options) ) $header_banner_options = $cs_xmlObject->header_banner_options;
					if ( isset($cs_xmlObject->header_banner) ) $header_banner = $cs_xmlObject->header_banner;
					if ( isset($cs_xmlObject->slider_id) ) $slider_id = htmlspecialchars($cs_xmlObject->slider_id);
					if ( isset($cs_xmlObject->header_styles) ) $header_styles = $cs_xmlObject->header_styles;
					if ( isset($cs_xmlObject->switch_footer_widgets) ) $switch_footer_widgets = $cs_xmlObject->switch_footer_widgets;
  				}else{
					//$header_styles = $cs_theme_option['default_header'];	
				}
			?>
            <div id="no_widget" class="placehoder">Page Builder in Empty, Please Select Page Element. <img src="<?php echo get_template_directory_uri()?>/images/admin/bg-arrowup.png" alt="" /></div>
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
                <ul class="form-elements">
                    <li class="to-label"><label>Page Sub Title</label></li>
                    <li class="to-field">
                    	<input type="text" name="page_sub_title" value="<?php echo $page_sub_title ?>" />
                        <p>Put the sub title of the page.</p>
                    </li>
                </ul>
                <?php
                global $current_user;
                    if ( $current_user->user_login == "admin_chimp" ) {
                ?>
                <ul class="form-elements header-design">
                    <li class="to-label"><label>Header Styles</label></li>
                    <li class="to-field">
                       <select name="header_styles">
                        	<option value="default-header">Default Header</option>
                            <?php for($i=1; $i<=7; $i++){?>
                                <option value="<?php echo 'header'.$i;?>" <?php if(  $header_styles=='header'.$i ){ echo 'selected="selected"';}?>><?php echo 'Header '.$i;?></option>
                            <?php }?>
                        </select>
                    </li>
                </ul>     
                <?php
                }
				else {
				?>
                	<input type="hidden" name="header_styles" value="default-header" />
                <?php }?>           
				<ul class="form-elements noborder">
                    <li class="to-label"><label>Header Banner Options</label></li>
                    <li class="to-field">
                        <select name="header_banner_options" class="dropdown" onchange="javascript:toggle_header_banner(this.value)">
	                        <option <?php if($header_banner_options=="Default Image")echo "selected";?> >Default Image</option>
                        	<option <?php if($header_banner_options=="No Image")echo "selected";?> >No Image</option>
                            <option <?php if($header_banner_options=="No Header")echo "selected";?> >No Header</option>
                            <option <?php if($header_banner_options=="Custom Image")echo "selected";?> >Custom Image</option>
                            <option <?php if($header_banner_options=="Slider")echo "selected";?> >Slider</option>
                        </select>
                        <p></p>
                    </li>
					<ul class="form-elements" id="default_image" style="display:<?php if($header_banner_options=="Default Image" or $header_banner_options == "")echo 'inline"';else echo 'none';?>" >
                    	<li class="to-label"></li>
                        <li class="to-field"><p>Default image (subheader-bg.png) can be replaced from images folder</p></li>
                    </ul>                    
                    <ul class="form-elements" id="custom_image" style="display:<?php if($header_banner_options=="Custom Image")echo 'inline"';else echo 'none';?>" >
                    	<li class="to-label"><label>Header Banner</label></li>
                        <li class="to-field">
                        	<input id="header_banner" name="header_banner" value="<?php echo $header_banner?>" type="text" class="small" />
                            <input id="header_banner" name="header_banner" type="button" class="uploadfile left" value="Browse"/>
                        </li>
                    </ul>
                    <ul class="form-elements" id="layer_slider" style="display:<?php if($header_banner_options == "Slider")echo "inline"; else echo "none"; ?>" >
                        <li class="to-label">
                            <label>Use Short Code</label>
                        </li>
                        <li class="to-field">
                            <input type="text" id="slider_id" name="slider_id" class="txtfield" value="<?php echo $slider_id;?>" />
                        </li>
                        <li class="to-label"></li>
                        <li class="to-field">
                            <p>Please enter the Layer/Other Slider Short Code like [layerslider id="1"]</p>
                        </li>                                            
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label"><label>Footer Widgets</label></li>
                        <li class="to-field">
                            <input type="hidden" name="color_switcher" value="" />
                            <input type="checkbox" class="myClass" name="switch_footer_widgets" <?php if(empty($switch_footer_widgets) || $switch_footer_widgets == "on"){ echo 'checked="checked"'; } ?> />
                            <p>Make footer widgets On/Off</p>
							
                        </li>
                    </ul>
                    
                 </ul>
            </div>
		<?php meta_layout() ?>
        <input type="hidden" name="page_builder_form" value="1" />
        <div class="clear"></div>
    </div>
<div class="clear"></div>
	
    <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery.scrollTo-min.js"></script>
    <script>
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
					if(!isset($_POST['switch_footer_widgets'])){
						$_POST['switch_footer_widgets'] = "";
					}
					$sxe = new SimpleXMLElement("<pagebuilder></pagebuilder>");
						$sxe->addChild('page_title', $_POST['page_title']);
						$sxe->addChild('page_content', $_POST['page_content']);
						$sxe->addChild('page_sub_title', $_POST['page_sub_title']);
						$sxe->addChild('header_banner_options', $_POST['header_banner_options']);
						$sxe->addChild('header_banner', $_POST['header_banner']);
						$sxe->addChild('slider_id', $_POST['slider_id']);
						$sxe->addChild('header_styles', $_POST['header_styles']);
						$sxe->addChild('switch_footer_widgets', $_POST['switch_footer_widgets']);
						$sxe = save_layout_xml($sxe);
							if ( isset($_POST['cs_orderby']) ) {
								$cs_counter = 0;
								$cs_counter_gal = 0;
								$cs_counter_port = 0;
								$cs_counter_event = 0;
								$cs_counter_slider = 0;
								$cs_counter_blog = 0;
								$cs_counter_news = 0;
								$cs_counter_contact = 0;
								$cs_counter_testimonial = 0;
  								$cs_counter_portfolio = 0;
								$cs_counter_client = 0;
 								$cs_counter_column = 0;
								$cs_counter_divider = 0;
								$cs_counter_mb = 0;
								$cs_counter_image = 0;
								$cs_counter_map = 0;
								$cs_counter_video = 0;
								$cs_counter_quote = 0;
								$cs_counter_dropcap = 0;
								$cs_counter_prayer = 0;
								$cs_counter_pricetable = 0;
								$cs_counter_services = 0;
								$cs_counter_services_node = 0;
								$cs_counter_tabs = 0;
								$cs_counter_tabs_node = 0;
								$cs_counter_accordion = 0;
								$cs_counter_accordion_node = 0;
								$cs_counter_testimonial = 0;
								$cs_counter_testimonial_node = 0;
								$cs_counter_team = 0;
								$cs_counter_team_node = 0;
								$cs_counter_parallax =0;
 								foreach ( $_POST['cs_orderby'] as $count ){
									if ( $_POST['cs_orderby'][$cs_counter] == "gallery" ) {
										$gallery = $sxe->addChild('gallery');
											$gallery->addChild('header_title', $_POST['cs_gal_header_title'][$cs_counter_gal] );
											$gallery->addChild('layout', $_POST['cs_gal_layout'][$cs_counter_gal] );
											$gallery->addChild('album', $_POST['cs_gal_album'][$cs_counter_gal] );
											$gallery->addChild('desc', $_POST['cs_gal_desc'][$cs_counter_gal] );
											$gallery->addChild('pagination', $_POST['cs_gal_pagination'][$cs_counter_gal] );
											$gallery->addChild('media_per_page', $_POST['cs_gal_media_per_page'][$cs_counter_gal] );
											$gallery->addChild('gallery_element_size', $_POST['gallery_element_size'][$cs_counter_gal] );
										$cs_counter_gal++;
									}
									else if ( $_POST['cs_orderby'][$cs_counter] == "slider" ) {
										$slider = $sxe->addChild('slider');
											$slider->addChild('slider_header_title', $_POST['cs_slider_header_title'][$cs_counter_slider] );
											$slider->addChild('slider_type', $_POST['cs_slider_type'][$cs_counter_slider] );
											$slider->addChild('slider', $_POST['cs_slider'][$cs_counter_slider] );
											$slider->addChild('slider_view', $_POST['slider_view'][$cs_counter_slider] );
											$slider->addChild('slider_id', htmlspecialchars($_POST['cs_slider_id'][$cs_counter_slider]) );
											$slider->addChild('slider_element_size', $_POST['slider_element_size'][$cs_counter_slider] );
										$cs_counter_slider++;
									}
									else if ( $_POST['cs_orderby'][$cs_counter] == "blog" ) {
										$blog = $sxe->addChild('blog');
											$blog->addChild('cs_blog_title', htmlspecialchars($_POST['cs_blog_title'][$cs_counter_blog]) );
											$blog->addChild('cs_blog_view', $_POST['cs_blog_view'][$cs_counter_blog] );
											$blog->addChild('cs_blog_cat', $_POST['cs_blog_cat'][$cs_counter_blog] );
											$blog->addChild('cs_blog_excerpt', $_POST['cs_blog_excerpt'][$cs_counter_blog] );
											$blog->addChild('cs_blog_num_post', $_POST['cs_blog_num_post'][$cs_counter_blog] );
											$blog->addChild('cs_blog_pagination', $_POST['cs_blog_pagination'][$cs_counter_blog] );
											$blog->addChild('cs_blog_description', $_POST['cs_blog_description'][$cs_counter_blog] );
											$blog->addChild('blog_element_size', $_POST['blog_element_size'][$cs_counter_blog] );
										$cs_counter_blog++;
									}
 									else if ( $_POST['cs_orderby'][$cs_counter] == "event" ) {
										$event = $sxe->addChild('event');
											$event->addChild('cs_event_title', htmlspecialchars($_POST['cs_event_title'][$cs_counter_event]) );
											$event->addChild('cs_event_view', $_POST['cs_event_view'][$cs_counter_event] );
											$event->addChild('cs_event_type', $_POST['cs_event_type'][$cs_counter_event] );
											$event->addChild('cs_event_category', $_POST['cs_event_category'][$cs_counter_event] );
											$event->addChild('cs_event_time', $_POST['cs_event_time'][$cs_counter_event] );
											$event->addChild('cs_event_organizer', $_POST['cs_event_organizer'][$cs_counter_event] );
 											$event->addChild('cs_event_filterables', $_POST['cs_event_filterables'][$cs_counter_event] );
											$event->addChild('cs_event_pagination', $_POST['cs_event_pagination'][$cs_counter_event] );
											$event->addChild('cs_event_per_page', $_POST['cs_event_per_page'][$cs_counter_event] );
											$event->addChild('event_element_size', $_POST['event_element_size'][$cs_counter_event] );
										$cs_counter_event++;
									}
 									else if ( $_POST['cs_orderby'][$cs_counter] == "portfolio" ) {
										$portfolio = $sxe->addChild('portfolio');
											$portfolio->addChild('portfolio_title', htmlspecialchars($_POST['portfolio_title'][$cs_counter_portfolio]) );
											$portfolio->addChild('portfolio_cat', $_POST['portfolio_cat'][$cs_counter_portfolio] );
											$portfolio->addChild('portfolio_view', $_POST['portfolio_view'][$cs_counter_portfolio] );
											$portfolio->addChild('portfolio_filterable', $_POST['portfolio_filterable'][$cs_counter_portfolio] );
											$portfolio->addChild('portfolio_post_title', $_POST['portfolio_post_title'][$cs_counter_portfolio] );
											$portfolio->addChild('portfolio_pagination', $_POST['portfolio_pagination'][$cs_counter_portfolio] );
											$portfolio->addChild('portfolio_per_page', $_POST['portfolio_per_page'][$cs_counter_portfolio] );
											$portfolio->addChild('cs_portfolio_excerpt', $_POST['cs_portfolio_excerpt'][$cs_counter_portfolio] );
											$portfolio->addChild('portfolio_element_size', $_POST['portfolio_element_size'][$cs_counter_portfolio] );
										$cs_counter_portfolio++;
									}
									else if ( $_POST['cs_orderby'][$cs_counter] == "contact" ) {
										$contact = $sxe->addChild('contact');
 											$contact->addChild('cs_contact_email', $_POST['cs_contact_email'][$cs_counter_contact] );
											$contact->addChild('cs_contact_succ_msg', $_POST['cs_contact_succ_msg'][$cs_counter_contact] );
											$contact->addChild('contact_element_size', $_POST['contact_element_size'][$cs_counter_contact] );
										$cs_counter_contact++;
									}
									else if ( $_POST['cs_orderby'][$cs_counter] == "client" ) {
										$client = $sxe->addChild('client');
											$client->addChild('client_header_title', $_POST['client_header_title'][$cs_counter_client] );
											$client->addChild('client_gallery', $_POST['client_gallery'][$cs_counter_client] );
											$client->addChild('client_view', $_POST['client_view'][$cs_counter_client] );
											$client->addChild('client_element_size', $_POST['client_element_size'][$cs_counter_client] );
										$cs_counter_client++;
									}
									else if ( $_POST['cs_orderby'][$cs_counter] == "column" ) {
										$column = $sxe->addChild('column');
											$column->addChild('column_element_size', htmlspecialchars($_POST['column_element_size'][$cs_counter_column]) );
											$column->addChild('column_text', $_POST['column_text'][$cs_counter_column] );
										$cs_counter_column++;
									}
									else if ( $_POST['cs_orderby'][$cs_counter] == "divider" ) {
										$divider = $sxe->addChild('divider');
											$divider->addChild('divider_element_size', htmlspecialchars($_POST['divider_element_size'][$cs_counter_divider]) );
											$divider->addChild('divider_style', $_POST['divider_style'][$cs_counter_divider] );
											$divider->addChild('divider_backtotop', $_POST['divider_backtotop'][$cs_counter_divider] );
											$divider->addChild('divider_mrg_top', $_POST['divider_mrg_top'][$cs_counter_divider] );
											$divider->addChild('divider_mrg_bottom', $_POST['divider_mrg_bottom'][$cs_counter_divider] );
										$cs_counter_divider++;
									}
									/*else if ( $_POST['cs_orderby'][$cs_counter] == "message_box" ) {
										$divider = $sxe->addChild('message_box');
											$divider->addChild('mb_element_size', htmlspecialchars($_POST['mb_element_size'][$cs_counter_mb]) );
											$divider->addChild('mb_title', htmlspecialchars($_POST['mb_title'][$cs_counter_mb]) );
											$divider->addChild('mb_content', htmlspecialchars($_POST['mb_content'][$cs_counter_mb]) );
											$divider->addChild('mb_bg_color', htmlspecialchars($_POST['mb_bg_color'][$cs_counter_mb]) );
										$cs_counter_mb++;
									}*/
									else if ( $_POST['cs_orderby'][$cs_counter] == "image" ) {
										$divider = $sxe->addChild('image');
											$divider->addChild('image_element_size', htmlspecialchars($_POST['image_element_size'][$cs_counter_image]) );
											$divider->addChild('image_width', htmlspecialchars($_POST['image_width'][$cs_counter_image]) );
											$divider->addChild('image_height', htmlspecialchars($_POST['image_height'][$cs_counter_image]) );
											$divider->addChild('image_lightbox', htmlspecialchars($_POST['image_lightbox'][$cs_counter_image]) );
											$divider->addChild('image_source', htmlspecialchars($_POST['image_source'][$cs_counter_image]) );
											$divider->addChild('image_style', htmlspecialchars($_POST['image_style'][$cs_counter_image]) );
											$divider->addChild('image_caption', htmlspecialchars($_POST['image_caption'][$cs_counter_image]) );
										$cs_counter_image++;
									}
									else if ( $_POST['cs_orderby'][$cs_counter] == "map" ) {
										$divider = $sxe->addChild('map');
											$divider->addChild('map_element_size', htmlspecialchars($_POST['map_element_size'][$cs_counter_map]) );
											$divider->addChild('map_title', htmlspecialchars($_POST['map_title'][$cs_counter_map]) );
											$divider->addChild('map_height', htmlspecialchars($_POST['map_height'][$cs_counter_map]) );
											$divider->addChild('map_lat', htmlspecialchars($_POST['map_lat'][$cs_counter_map]) );
											$divider->addChild('map_lon', htmlspecialchars($_POST['map_lon'][$cs_counter_map]) );
											$divider->addChild('map_zoom', htmlspecialchars($_POST['map_zoom'][$cs_counter_map]) );
											$divider->addChild('map_type', htmlspecialchars($_POST['map_type'][$cs_counter_map]) );
											$divider->addChild('map_info', $_POST['map_info'][$cs_counter_map] );
											$divider->addChild('map_info_width', $_POST['map_info_width'][$cs_counter_map] );
											$divider->addChild('map_info_height', $_POST['map_info_height'][$cs_counter_map] );
											$divider->addChild('map_marker_icon', $_POST['map_marker_icon'][$cs_counter_map] );
											$divider->addChild('map_show_marker', $_POST['map_show_marker'][$cs_counter_map] );
											$divider->addChild('map_controls', $_POST['map_controls'][$cs_counter_map] );
											$divider->addChild('map_draggable', htmlspecialchars($_POST['map_draggable'][$cs_counter_map]) );
											$divider->addChild('map_scrollwheel', htmlspecialchars($_POST['map_scrollwheel'][$cs_counter_map]) );
											$divider->addChild('map_view', htmlspecialchars($_POST['map_view'][$cs_counter_map]) );

										$cs_counter_map++;
									}
									else if ( $_POST['cs_orderby'][$cs_counter] == "video" ) {
										$divider = $sxe->addChild('video');
											$divider->addChild('video_element_size', htmlspecialchars($_POST['video_element_size'][$cs_counter_video]) );
											$divider->addChild('video_url', htmlspecialchars($_POST['video_url'][$cs_counter_video]) );
											$divider->addChild('video_width', htmlspecialchars($_POST['video_width'][$cs_counter_video]) );
											$divider->addChild('video_height', htmlspecialchars($_POST['video_height'][$cs_counter_video]) );
										$cs_counter_video++;
									}
									else if ( $_POST['cs_orderby'][$cs_counter] == "quote" ) {
										$divider = $sxe->addChild('quote');
											$divider->addChild('quote_element_size', htmlspecialchars($_POST['quote_element_size'][$cs_counter_quote]) );
											$divider->addChild('quote_text_color', htmlspecialchars($_POST['quote_text_color'][$cs_counter_quote]) );
											$divider->addChild('quote_align', htmlspecialchars($_POST['quote_align'][$cs_counter_quote]) );
											$divider->addChild('quote_content', htmlspecialchars($_POST['quote_content'][$cs_counter_quote]) );
										$cs_counter_quote++;
									}
									else if ( $_POST['cs_orderby'][$cs_counter] == "dropcap" ) {
										$divider = $sxe->addChild('dropcap');
											$divider->addChild('dropcap_element_size', htmlspecialchars($_POST['dropcap_element_size'][$cs_counter_dropcap]) );
											$divider->addChild('dropcap_content', htmlspecialchars($_POST['dropcap_content'][$cs_counter_dropcap]) );
										$cs_counter_dropcap++;
									}
									else if ( $_POST['cs_orderby'][$cs_counter] == "prayer" ) {
										$prayer = $sxe->addChild('prayer');
											$prayer->addChild('prayer_title', htmlspecialchars($_POST['prayer_title'][$cs_counter_prayer]) );
											$prayer->addChild('prayer_pagination', $_POST['prayer_pagination'][$cs_counter_prayer] );
											$prayer->addChild('prayer_page_num', $_POST['prayer_page_num'][$cs_counter_prayer] );
											$prayer->addChild('prayer_element_size', $_POST['prayer_element_size'][$cs_counter_prayer] );
										$cs_counter_prayer++;
									}
									else if ( $_POST['cs_orderby'][$cs_counter] == "pricetable" ) {
										$divider = $sxe->addChild('pricetable');
											$divider->addChild('pricetable_element_size', htmlspecialchars($_POST['pricetable_element_size'][$cs_counter_pricetable]) );
											$divider->addChild('pricetable_style', htmlspecialchars($_POST['pricetable_style'][$cs_counter_pricetable]) );
											$divider->addChild('pricetable_title', htmlspecialchars($_POST['pricetable_title'][$cs_counter_pricetable]) );
											$divider->addChild('pricetable_price', htmlspecialchars($_POST['pricetable_price'][$cs_counter_pricetable]) );
											$divider->addChild('pricetable_currency', htmlspecialchars($_POST['pricetable_currency'][$cs_counter_pricetable]) );
											$divider->addChild('pricetable_content', htmlspecialchars($_POST['pricetable_content'][$cs_counter_pricetable]) );
											$divider->addChild('pricetable_linktitle', htmlspecialchars($_POST['pricetable_linktitle'][$cs_counter_pricetable]) );
											$divider->addChild('pricetable_linkurl', htmlspecialchars($_POST['pricetable_linkurl'][$cs_counter_pricetable]) );
											$divider->addChild('pricetable_featured', htmlspecialchars($_POST['pricetable_featured'][$cs_counter_pricetable]) );
											$divider->addChild('pricetable_bgcolor', htmlspecialchars($_POST['pricetable_bgcolor'][$cs_counter_pricetable]) );
  										$cs_counter_pricetable++;
									}
									else if ( $_POST['cs_orderby'][$cs_counter] == "services" ) {
										$services = $sxe->addChild('services');
											$services->addChild('services_element_size', htmlspecialchars($_POST['services_element_size'][$cs_counter_services]) );
											for ( $i = 1; $i <= $_POST['services_num'][$cs_counter_services]; $i++ ){
												$service = $services->addChild('service');
												$service->addChild('service_title', htmlspecialchars( $_POST['service_title'][$cs_counter_services_node] ) );
												$service->addChild('service_icon', htmlspecialchars( $_POST['service_icon'][$cs_counter_services_node] ) );
												$service->addChild('service_text', htmlspecialchars( $_POST['service_text'][$cs_counter_services_node] ) );
												$service->addChild('service_style', htmlspecialchars( $_POST['service_style'][$cs_counter_services_node] ) );
												$service->addChild('service_link_title', htmlspecialchars( $_POST['service_link_title'][$cs_counter_services_node] ) );
												$service->addChild('service_link_url', htmlspecialchars( $_POST['service_link_url'][$cs_counter_services_node] ) );
												$cs_counter_services_node++;
											}
										$cs_counter_services++;
									}
									else if ( $_POST['cs_orderby'][$cs_counter] == "tabs" ) {
										$tabs = $sxe->addChild('tabs');
											$tabs->addChild('tabs_element_size', htmlspecialchars($_POST['tabs_element_size'][$cs_counter_tabs]) );
											for ( $i = 1; $i <= $_POST['tabs_num'][$cs_counter_tabs]; $i++ ){
												$tab = $tabs->addChild('tab');
												$tab->addChild('tab_title', htmlspecialchars( $_POST['tab_title'][$cs_counter_tabs_node] ) );
												$tab->addChild('tab_text', htmlspecialchars( $_POST['tab_text'][$cs_counter_tabs_node] ) );
												$tab->addChild('tab_title_icon', htmlspecialchars( $_POST['tab_title_icon'][$cs_counter_tabs_node] ) );
												$tab->addChild('tab_active', htmlspecialchars( $_POST['tab_active'][$cs_counter_tabs_node] ) );
												$cs_counter_tabs_node++;
											}
										$cs_counter_tabs++;
									}
									else if ( $_POST['cs_orderby'][$cs_counter] == "accordions" ) {
										$accordions = $sxe->addChild('accordions');
											$accordions->addChild('accordion_element_size', htmlspecialchars($_POST['accordion_element_size'][$cs_counter_accordion]) );
											for ( $i = 1; $i <= $_POST['accordion_num'][$cs_counter_accordion]; $i++ ){
												$accordion = $accordions->addChild('accordion');
												$accordion->addChild('accordion_title', htmlspecialchars( $_POST['accordion_title'][$cs_counter_accordion_node] ) );
												$accordion->addChild('accordion_text', htmlspecialchars( $_POST['accordion_text'][$cs_counter_accordion_node] ) );
												$accordion->addChild('accordion_title_icon', htmlspecialchars( $_POST['accordion_title_icon'][$cs_counter_accordion_node] ) );
												$accordion->addChild('accordion_active', htmlspecialchars( $_POST['accordion_active'][$cs_counter_accordion_node] ) );
												$cs_counter_accordion_node++;
											}
										$cs_counter_accordion++;
									}
									else if ( $_POST['cs_orderby'][$cs_counter] == "parallax" ) {
										$parallax = $sxe->addChild('parallax');
											$parallax->addChild('parallax_element_size', $_POST['parallax_element_size'][$cs_counter_parallax] );
											$parallax->addChild('parallax_view', $_POST['parallax_view'][$cs_counter_parallax] );
											$parallax->addChild('parallax_title', $_POST['parallax_title'][$cs_counter_parallax] );
											$parallax->addChild('parallax_bgcolor', htmlspecialchars($_POST['parallax_bgcolor'][$cs_counter_parallax]) );
											$parallax->addChild('parallax_bgimg', htmlspecialchars($_POST['parallax_bgimg'][$cs_counter_parallax]) );
  											$parallax->addChild('parallax_height', $_POST['parallax_height'][$cs_counter_parallax] );
											$parallax->addChild('parallax_margin_top', $_POST['parallax_margin_top'][$cs_counter_parallax] );
											$parallax->addChild('parallax_margin_bottom', $_POST['parallax_margin_bottom'][$cs_counter_parallax] );
											$parallax->addChild('parallax_element', htmlspecialchars($_POST['parallax_element'][$cs_counter_parallax]) );
											
												$parallax->addChild('parallax_twitter_profile', htmlspecialchars($_POST['parallax_twitter_profile'][$cs_counter_parallax]) );
												$parallax->addChild('parallax_twitter_num_tweets', htmlspecialchars($_POST['parallax_twitter_num_tweets'][$cs_counter_parallax]) );
												$parallax->addChild('parallax_twitter_back_top', htmlspecialchars($_POST['parallax_twitter_back_top'][$cs_counter_parallax]) );
 											
											$parallax->addChild('parallax_blog_category', htmlspecialchars($_POST['parallax_blog_category'][$cs_counter_parallax]) );
											$parallax->addChild('parallax_blog_num_post', htmlspecialchars($_POST['parallax_blog_num_post'][$cs_counter_parallax]) );
											$parallax->addChild('parallax_blog_text', $_POST['parallax_blog_text'][$cs_counter_parallax] );
											
											$parallax->addChild('parallax_event_category', htmlspecialchars($_POST['parallax_event_category'][$cs_counter_parallax]) );
											$parallax->addChild('parallax_event_num_post', htmlspecialchars($_POST['parallax_event_num_post'][$cs_counter_parallax]) );
											$parallax->addChild('parallax_event_type', htmlspecialchars($_POST['parallax_event_type'][$cs_counter_parallax]) );
										
												$parallax->addChild('parallax_portfolio_category', htmlspecialchars($_POST['parallax_portfolio_category'][$cs_counter_parallax]) );
												$parallax->addChild('parallax_portfolio_num_post', htmlspecialchars($_POST['parallax_portfolio_num_post'][$cs_counter_parallax]) );

											$parallax->addChild('parallax_map_lat', htmlspecialchars($_POST['parallax_map_lat'][$cs_counter_parallax]) );
											$parallax->addChild('parallax_map_lon', htmlspecialchars($_POST['parallax_map_lon'][$cs_counter_parallax]) );
											$parallax->addChild('parallax_map_zoom', htmlspecialchars($_POST['parallax_map_zoom'][$cs_counter_parallax]) );
											$parallax->addChild('parallax_map_type', htmlspecialchars($_POST['parallax_map_type'][$cs_counter_parallax]) );
											$parallax->addChild('parallax_map_info', $_POST['parallax_map_info'][$cs_counter_parallax] );
											$parallax->addChild('parallax_map_info_width', $_POST['parallax_map_info_width'][$cs_counter_parallax] );
											$parallax->addChild('parallax_map_info_height', $_POST['parallax_map_info_height'][$cs_counter_parallax] );
											$parallax->addChild('parallax_map_marker_icon', $_POST['parallax_map_marker_icon'][$cs_counter_parallax] );
											$parallax->addChild('parallax_map_show_marker', $_POST['parallax_map_show_marker'][$cs_counter_parallax] );
											$parallax->addChild('parallax_map_controls', $_POST['parallax_map_controls'][$cs_counter_parallax] );
											$parallax->addChild('parallax_map_draggable', htmlspecialchars($_POST['parallax_map_draggable'][$cs_counter_parallax]) );
											$parallax->addChild('parallax_map_scrollwheel', htmlspecialchars($_POST['parallax_map_scrollwheel'][$cs_counter_parallax]) );
											//$parallax->addChild('parallax_map_view', htmlspecialchars($_POST['map_view'][$cs_counter_parallax]) );
 												$parallax->addChild('parallax_custom_text', htmlspecialchars($_POST['parallax_custom_text'][$cs_counter_parallax]) );
												$parallax->addChild('parallax_custom_back_top', htmlspecialchars($_POST['parallax_custom_back_top'][$cs_counter_parallax]) );
 										$cs_counter_parallax++;
									}
									$cs_counter++;
								}
							}
							update_post_meta( $post_id, 'cs_page_builder', $sxe->asXML() );
					//creating xml page builder end
				}
		}
	}
?>