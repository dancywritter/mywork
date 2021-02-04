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
                    	<a href="javascript:ajaxSubmit('cs_pb_home')">Home</a>
                        <a href="javascript:ajaxSubmit('cs_pb_blog')">Blog</a>
                        <a href="javascript:ajaxSubmit('cs_pb_portfolio')">Portfolio</a>
                        <a href="javascript:ajaxSubmit('cs_pb_column')">Column</a>
                        <a href="javascript:ajaxSubmit('cs_pb_contact')">Contact</a>
                        <a href="javascript:ajaxSubmit('cs_pb_gallery')">Gallery</a>
                        <a href="javascript:ajaxSubmit('cs_pb_map')">Map</a>
                        
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
				$counter_snapture_home = '';
				$page_content_postion = '';
				$cs_blog_large_layout = '';
				$page_headline_text = '';
                $cs_page_bulider = get_post_meta($post->ID, "cs_page_builder", true);
 				if ( $cs_page_bulider <> "" ) {
                   	$cs_xmlObject = new stdClass();
					$cs_xmlObject = new SimpleXMLElement($cs_page_bulider);
 						$count_widget = count($cs_xmlObject->children())-10;
                        foreach ( $cs_xmlObject->children() as $cs_node ){
							if ( $cs_node->getName() == "snapture_home" ) { cs_pb_home(1); }
							if ( $cs_node->getName() == "gallery" ) { cs_pb_gallery(1); }
							else if ( $cs_node->getName() == "blog" ) { cs_pb_blog(1); }
							else if ( $cs_node->getName() == "portfolio" ) { cs_pb_portfolio(1); }
 							else if ( $cs_node->getName() == "contact" ) { cs_pb_contact(1); }
							else if ( $cs_node->getName() == "column" ) { cs_pb_column(1); }
							else if ( $cs_node->getName() == "map" ) { cs_pb_map(1); }
                          }
                }
 				if ( $cs_page_bulider <> "" ) {
					if ( isset($cs_xmlObject->page_title) ) $page_title = $cs_xmlObject->page_title;
					if ( isset($cs_xmlObject->cs_blog_large_layout) ){ $cs_blog_large_layout = $cs_xmlObject->cs_blog_large_layout;} else { $cs_blog_large_layout = '';}
					if ( isset($cs_xmlObject->page_headline_text) ){ $page_headline_text = $cs_xmlObject->page_headline_text;} else { $page_headline_text = '';}
					if ( isset($cs_xmlObject->page_content_postion) ){ $page_content_postion = $cs_xmlObject->page_content_postion;} else { $page_content_postion = '';}
					if ( isset($cs_xmlObject->page_content) ) $page_content = $cs_xmlObject->page_content;
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
                    <li class="to-label"><label> Page Title</label></li>
                    <li class="to-field">
                        <select name="page_title" class="dropdown">
                            <option value="Yes" <?php if($page_title=="Yes")echo "selected";?> >Yes</option>
                            <option value="No" <?php if($page_title=="No")echo "selected";?> >No</option>
                        </select>
                        <p>Show the title of the page.</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Page Sub-heading</label></li>
                    <li class="to-field">
                    	<input type="text" name="page_headline_text" value="<?php echo $page_headline_text;?>" />
                        <p>Enter Page Sub-heading text.</p>
                    </li>
                </ul>
                
                <ul class="form-elements">
                    <li class="to-label"><label>Page Description</label></li>
                    <li class="to-field">
                        <select name="page_content" class="dropdown">
                            <option value="Yes" <?php if($page_content=="Yes")echo "selected";?> >Yes</option>
                            <option value="No" <?php if($page_content=="No")echo "selected";?> >No</option>
                        </select>
                        <p>Show the description of the page.</p>
                    </li>
                </ul>
                <ul class="form-elements meta-body" >
                    <li class="to-label">
                        <label>Page layout view</label>
                    </li>
                    <li class="to-field">
                        <select name="cs_blog_large_layout" class="select_dropdown" id="page-option-choose-right-sidebar">
                            <option value="cs_full_width" <?php if ($cs_blog_large_layout=='cs_full_width')echo "selected";?>>Wide Layout</option>
                            <option value="cs_boxed_layout" <?php if ($cs_blog_large_layout=='cs_boxed_layout')echo "selected";?>>Boxed View</option>
                        </select>
                    </li>
                </ul>
                
                <ul class="form-elements meta-body" >
                    <li class="to-label">
                        <label>Page layout Position Center</label>
                    </li>
                    <li class="to-field">
                        <select name="page_content_postion" class="dropdown">
                            <option value="Yes" <?php if($page_content_postion=="Yes")echo "selected";?> >Yes</option>
                            <option value="No" <?php if($page_content_postion=="No")echo "selected";?> >No</option>
                        </select>
                        <p>Select Page layout padding.</p>
                    </li>
                </ul>
                
                
            </div>
          <?php cs_meta_layout() ?>   
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
						if (empty($_POST['page_headline_text']))$_POST['page_headline_text'] = "";
						if (empty($_POST['cs_blog_large_layout']))$_POST['cs_blog_large_layout'] = "";
						if (empty($_POST['page_content_postion']))$_POST['page_content_postion'] = "";
						
						$sxe->addChild('page_title', $_POST['page_title']);
						$sxe->addChild('cs_blog_large_layout', $_POST['cs_blog_large_layout']);
						$sxe->addChild('page_headline_text', $_POST['page_headline_text']);
						$sxe->addChild('page_content', $_POST['page_content']);
						$sxe->addChild('page_content_postion', $_POST['page_content_postion']);
						$sxe = save_layout_xml($sxe);
							if ( isset($_POST['cs_orderby']) ) {
								$counter = 0;
								$counter_gal = 0;
								$counter_portfolio = 0;
								$counter_blog = 0;
								$counter_contact = 0;
 								$counter_column = 0;
								$counter_snapture_home = 0;
								$counter_map = 0;

 								foreach ( $_POST['cs_orderby'] as $count ){
									if ( $_POST['cs_orderby'][$counter] == "gallery" ) {
										$gallery = $sxe->addChild('gallery');
											$gallery->addChild('header_title', $_POST['cs_gal_header_title'][$counter_gal] );
											$gallery->addChild('layout', $_POST['cs_gal_layout'][$counter_gal] );
											$gallery->addChild('cs_gal_images_title', $_POST['cs_gal_images_title'][$counter_gal] );
											$gallery->addChild('album', $_POST['cs_gal_album'][$counter_gal] );
											$gallery->addChild('pagination', $_POST['cs_gal_pagination'][$counter_gal] );
											$gallery->addChild('media_per_page', $_POST['cs_gal_media_per_page'][$counter_gal] );
 											$gallery->addChild('gallery_element_size', $_POST['gallery_element_size'][$counter_gal] );
										$counter_gal++;
									}
									else if ( $_POST['cs_orderby'][$counter] == "snapture_home" ) {
											$sn_home = $sxe->addChild('snapture_home');
											$sn_home->addChild('cs_home_view_option', htmlspecialchars($_POST['cs_home_view_option'][$counter_snapture_home]) );
											
											$sn_home->addChild('cs_home_num_post', htmlspecialchars($_POST['cs_home_num_post'][$counter_snapture_home]) );
											$sn_home->addChild('cs_home_blog_cat', htmlspecialchars($_POST['cs_home_blog_cat'][$counter_snapture_home]) );
											
											$sn_home->addChild('cs_home_blog_description', htmlspecialchars($_POST['cs_home_blog_description'][$counter_snapture_home]) );
											$sn_home->addChild('cs_home_blog_show_title', htmlspecialchars($_POST['cs_home_blog_show_title'][$counter_snapture_home]) );
											$sn_home->addChild('cs_home_blog_excerpt', htmlspecialchars($_POST['cs_home_blog_excerpt'][$counter_snapture_home]) );
											
											$sn_home->addChild('cs_home_v2_text', htmlspecialchars($_POST['cs_home_v2_text'][$counter_snapture_home]) );
											$sn_home->addChild('cs_home_v2_video', htmlspecialchars($_POST['cs_home_v2_video'][$counter_snapture_home]) );
											$sn_home->addChild('cs_home_v2_video_mute', htmlspecialchars($_POST['cs_home_v2_video_mute'][$counter_snapture_home]) );
											$sn_home->addChild('cs_home_v2_captions', htmlspecialchars($_POST['cs_home_v2_captions'][$counter_snapture_home]) );
											$sn_home->addChild('cs_home_v2_text_rotator', htmlspecialchars($_POST['cs_home_v2_text_rotator'][$counter_snapture_home]) );
											$sn_home->addChild('cs_home_v2_text_rotator_style', htmlspecialchars($_POST['cs_home_v2_text_rotator_style'][$counter_snapture_home]) );
											
											$sn_home->addChild('cs_home_v3_num_post', htmlspecialchars($_POST['cs_home_v3_num_post'][$counter_snapture_home]) );
											$sn_home->addChild('cs_home_v3_filterable', htmlspecialchars($_POST['cs_home_v3_filterable'][$counter_snapture_home]) );
											$sn_home->addChild('cs_home_v3_cat', htmlspecialchars($_POST['cs_home_v3_cat'][$counter_snapture_home]) );
											
											$sn_home->addChild('cs_home_v4_text', htmlspecialchars($_POST['cs_home_v4_text'][$counter_snapture_home]) );
											$sn_home->addChild('cs_home_v4_slider', htmlspecialchars($_POST['cs_home_v4_slider'][$counter_snapture_home]) );
											$sn_home->addChild('cs_home_v4_captions', htmlspecialchars($_POST['cs_home_v4_captions'][$counter_snapture_home]) );
											$sn_home->addChild('cs_home_v4_text_rotator', htmlspecialchars($_POST['cs_home_v4_text_rotator'][$counter_snapture_home]) );
											$sn_home->addChild('cs_home_v4_text_rotator_style', htmlspecialchars($_POST['cs_home_v4_text_rotator_style'][$counter_snapture_home]) );
											
											$sn_home->addChild('cs_home_v5_text', htmlspecialchars($_POST['cs_home_v5_text'][$counter_snapture_home]) );
											$sn_home->addChild('cs_home_v5_gallery', htmlspecialchars($_POST['cs_home_v5_gallery'][$counter_snapture_home]) );
											$sn_home->addChild('cs_home_v5_captions', htmlspecialchars($_POST['cs_home_v5_captions'][$counter_snapture_home]) );
											$sn_home->addChild('cs_home_v5_text_rotator', htmlspecialchars($_POST['cs_home_v5_text_rotator'][$counter_snapture_home]) );
											$sn_home->addChild('cs_home_v5_text_rotator_style', htmlspecialchars($_POST['cs_home_v5_text_rotator_style'][$counter_snapture_home]) );

											$sn_home->addChild('home_element_size', $_POST['home_element_size'][$counter_snapture_home] );
											
										$counter_snapture_home++;
									}
									else if ( $_POST['cs_orderby'][$counter] == "blog" ) {
										$blog = $sxe->addChild('blog');
											$blog->addChild('cs_blog_title', htmlspecialchars($_POST['cs_blog_title'][$counter_blog]) );
											$blog->addChild('cs_blog_cat', $_POST['cs_blog_cat'][$counter_blog] );
											$blog->addChild('cs_blog_view', $_POST['cs_blog_view'][$counter_blog] );
											$blog->addChild('cs_blog_excerpt', $_POST['cs_blog_excerpt'][$counter_blog] );
											$blog->addChild('cs_blog_pagination', $_POST['cs_blog_pagination'][$counter_blog] );
 											$blog->addChild('cs_blog_num_post', $_POST['cs_blog_num_post'][$counter_blog] );
											$blog->addChild('cs_blog_show_title', $_POST['cs_blog_show_title'][$counter_blog] );
 											$blog->addChild('cs_blog_description', $_POST['cs_blog_description'][$counter_blog] );
											$blog->addChild('blog_element_size', $_POST['blog_element_size'][$counter_blog] );
											
										$counter_blog++;
									}
									else if ( $_POST['cs_orderby'][$counter] == "portfolio" ) {
										$portfolio = $sxe->addChild('portfolio');
											$portfolio->addChild('portfolio_title', htmlspecialchars($_POST['portfolio_title'][$counter_portfolio]) );
											$portfolio->addChild('portfolio_cat', $_POST['portfolio_cat'][$counter_portfolio] );
											$portfolio->addChild('portfolio_view', $_POST['portfolio_view'][$counter_portfolio] );
											$portfolio->addChild('portfolio_filterable', $_POST['portfolio_filterable'][$counter_portfolio] );
											$portfolio->addChild('portfolio_post_title', $_POST['portfolio_post_title'][$counter_portfolio] );
											$portfolio->addChild('portfolio_pagination', $_POST['portfolio_pagination'][$counter_portfolio] );
											$portfolio->addChild('portfolio_per_page', $_POST['portfolio_per_page'][$counter_portfolio] );
											$portfolio->addChild('cs_portfolio_excerpt', $_POST['cs_portfolio_excerpt'][$counter_portfolio] );
											$portfolio->addChild('portfolio_element_size', $_POST['portfolio_element_size'][$counter_portfolio] );
										$counter_portfolio++;
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