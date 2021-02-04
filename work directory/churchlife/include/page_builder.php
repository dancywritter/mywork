<?php
global $px_node, $px_count_node, $px_xmlObject,$px_theme_option;
add_action( 'add_meta_boxes', 'px_page_bulider_add' );
add_action( 'add_meta_boxes', 'px_page_options_add' );
function px_page_options_add() {
	add_meta_box( 'id_page_options', 'Page Options', 'px_page_options', 'page', 'normal', 'high' );  
}
function px_page_bulider_add() {
	add_meta_box( 'id_page_builder', 'Page Builder', 'px_page_bulider', 'page', 'normal', 'high' );  
}  

function px_page_bulider( $post ) {
?>
     
     <div class="page-wrap page-opts event-meta-section" style="overflow:hidden; position:relative; height: 705px;">
    	<div class="add-widget">
            <div class="widgets-list">
                
                <a href="javascript:ajaxSubmit('px_pb_blog')">Blog</a>
                <a href="javascript:ajaxSubmit('px_pb_sermon')">Sermons</a>
                <a href="javascript:ajaxSubmit('px_pb_column')">Column</a>
                <a href="javascript:ajaxSubmit('px_pb_contact')">Contact</a>
                <a href="javascript:ajaxSubmit('px_pb_event')">Events</a>
                <a href="javascript:ajaxSubmit('px_pb_gallery')">Gallery</a>
                 <a href="javascript:ajaxSubmit('px_pb_team')">Team</a>
             </div>
        </div>
        <div class="clear"></div>
        <div id="add_page_builder_item">
          <div class="page-show-items">
            <?php
				global $px_node,$px_xmlObject,$px_theme_option; 
				$px_count_node = 0;
				$count_widget = 0;
				$page_title = 'on';
				$header_styles = '';
				$switch_footer_widgets = '';               
                $px_page_bulider = get_post_meta($post->ID, "px_page_builder", true);
				if ( $px_page_bulider <> "" ) {
                   	$px_xmlObject = new stdClass();
					$px_xmlObject = new SimpleXMLElement($px_page_bulider);
						$count_widget = count($px_xmlObject->children())-10;
                        foreach ( $px_xmlObject->children() as $px_node ){
 							if ( $px_node->getName() == "gallery" ) { px_pb_gallery(1); }
							else if ( $px_node->getName() == "sermon" ) { px_pb_sermon(1); }
							else if ( $px_node->getName() == "blog" ) { px_pb_blog(1); }
 							else if ( $px_node->getName() == "event" ) { px_pb_event(1); }
 							else if ( $px_node->getName() == "contact" ) { px_pb_contact(1); }
							else if ( $px_node->getName() == "column" ) { px_pb_column(1); }
							else if ( $px_node->getName() == "team" ) { px_pb_team(1); }
                         }
                }
 				if($count_widget<0){ $count_widget = 0;}
			?>
            </div>
            <div id="no_widget" class="placehoder">Page Builder in Empty, Please Select Page Element. <img src="<?php echo get_template_directory_uri()?>/images/admin/bg-arrowup.png" alt="" /></div>
        </div>
		<div id="loading" class="builderload"></div>
         <div class="clear"></div>

        <div class="clear"></div>
    </div>
<div class="clear"></div>
	
    <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery.scrollTo-min.js"></script>
    <script>
		jQuery(function() {
			jQuery( ".page-show-items" ).sortable({
				cancel : 'div div.poped-up'
			});
			//jQuery( "#add_page_builder_item" ).disableSelection();
		});
    </script>
	<script type="text/javascript">
		var count_widget = <?php echo $count_widget; ?>;
        function ajaxSubmit(action){
  			counter++;
			count_widget++;
            var newCustomerForm = "action=" + action + '&counter=' + counter;
            jQuery.ajax({
                type:"POST",
                url: "<?php echo home_url()?>/wp-admin/admin-ajax.php",
                data: newCustomerForm,
                success:function(data){
                    jQuery(".page-show-items").append(data);
					if (count_widget > 0) jQuery("#add_page_builder_item").addClass('hasclass');
					//alert(count_widget);
                }
            });
            //return false;
        }
    </script>
<?php  
}
 
function px_page_options( $post ) {
	global $px_xmlObject,$px_theme_option;
	$page_title = 'on';
	$page_content = 'on';
 	$px_page_bulider = get_post_meta($post->ID, "px_page_builder", true);
	if ( $px_page_bulider <> "" ) {
		$px_xmlObject = new stdClass();
		$px_xmlObject = new SimpleXMLElement($px_page_bulider);
		if ( isset($px_xmlObject->page_title) ) $page_title = $px_xmlObject->page_title;
		if ( isset($px_xmlObject->page_content) ) $page_content = $px_xmlObject->page_content;
	
	}
	?>
    <div class="page-wrap page-opts event-meta-section" style="overflow:hidden; position:relative; height: 705px;">
    <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/bootstrap-3.0.js"></script>
	
         <div class="clear"></div>
           <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/select.js"></script>
           <link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/admin/bootstrap.min.css">
           <div class="option-sec" style="margin-bottom:0;">
             <div class="opt-conts">
            <div class="elementhidden">
            	<ul class="form-elements  on-off-options noborder">
                	<li class="to-label"><label>Page Title</label></li>
                    <li class="to-field">
                    	<label class="cs-on-off">
                            <input type="checkbox" name="page_title" value="on" class="myClass" <?php if($page_title=='on')echo "checked"?> />
                            <span></span>
                        </label>
                    </li>
                    <li class="to-label"><label>Rich editor description</label></li>
                    <li class="to-field">
                    	<label class="cs-on-off">
                            <input type="checkbox" name="page_content" value="on" class="myClass" <?php if($page_content=='on')echo "checked"?> />
                            <span></span>
                        </label>
                    </li>
                </ul>
                
            </div>
		<?php meta_layout() ?>
        <input type="hidden" name="page_builder_form" value="1" />
        <div class="clear"></div>
    </div>
<div class="clear"></div>
</div>
</div>
<?php  
}
	if ( isset($_POST['page_builder_form']) and $_POST['page_builder_form'] == 1 ) {
		add_action( 'save_post', 'save_page_builder' );
		function save_page_builder( $post_id ) {
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
				if ( isset($_POST['px_orderby']) ) {
					//creating xml page builder start
					$sxe = new SimpleXMLElement("<pagebuilder></pagebuilder>");
						$sxe->addChild('page_title', $_POST['page_title']);
						$sxe->addChild('page_content', $_POST['page_content']);
						$sxe = save_layout_xml($sxe);
							if ( isset($_POST['px_orderby']) ) {
								$px_counter = 0;
								$px_counter_gal = 0;
								$px_counter_event = 0;
								$px_counter_blog = 0;
								$px_counter_contact = 0;
 								$px_counter_column = 0;
								$px_counter_team = 0;
								$px_counter_team_node = 0;
								$px_counter_sermon = 0;
 								foreach ( $_POST['px_orderby'] as $count ){
									if ( $_POST['px_orderby'][$px_counter] == "gallery" ) {
										$gallery = $sxe->addChild('gallery');
										$gallery->addChild('header_title', $_POST['px_gal_header_title'][$px_counter_gal] );
										$gallery->addChild('layout', $_POST['px_gal_layout'][$px_counter_gal] );
										$gallery->addChild('album', $_POST['px_gal_album'][$px_counter_gal] );
										$gallery->addChild('pagination', $_POST['px_gal_pagination'][$px_counter_gal] );
										$gallery->addChild('media_per_page', $_POST['px_gal_media_per_page'][$px_counter_gal] );
										$gallery->addChild('gallery_element_size', $_POST['gallery_element_size'][$px_counter_gal] );
										$px_counter_gal++;
									}else if ( $_POST['px_orderby'][$px_counter] == "sermon" ) {
										$sermon = $sxe->addChild('sermon');
										$sermon->addChild('var_pb_sermon_title', htmlspecialchars($_POST['var_pb_sermon_title'][$px_counter_sermon]) );
										$sermon->addChild('var_pb_sermon_cat', $_POST['var_pb_sermon_cat'][$px_counter_sermon] );
 										$sermon->addChild('var_pb_sermon_filterable', $_POST['var_pb_sermon_filterable'][$px_counter_sermon] );
 										$sermon->addChild('var_pb_sermon_pagination', $_POST['var_pb_sermon_pagination'][$px_counter_sermon] );
										$sermon->addChild('var_pb_sermon_per_page', $_POST['var_pb_sermon_per_page'][$px_counter_sermon] );
										$sermon->addChild('sermon_element_size', $_POST['sermon_element_size'][$px_counter_sermon] );
										$px_counter_sermon++;
									
									}else if ( $_POST['px_orderby'][$px_counter] == "blog" ) {
										$blog = $sxe->addChild('blog');
										$blog->addChild('var_pb_blog_title', htmlspecialchars($_POST['var_pb_blog_title'][$px_counter_blog]) );
										$blog->addChild('var_pb_blog_cat', $_POST['var_pb_blog_cat'][$px_counter_blog] );
										$blog->addChild('var_pb_blog_num_post', $_POST['var_pb_blog_num_post'][$px_counter_blog] );
										$blog->addChild('var_pb_blog_pagination', $_POST['var_pb_blog_pagination'][$px_counter_blog] );
										$blog->addChild('var_pb_blog_sidebar', $_POST['var_pb_blog_sidebar'][$px_counter_blog] );
										$blog->addChild('blog_element_size', $_POST['blog_element_size'][$px_counter_blog] );
										$px_counter_blog++;
									
									}else if ( $_POST['px_orderby'][$px_counter] == "event" ) {
										$event = $sxe->addChild('event');
										$event->addChild('var_pb_event_title', htmlspecialchars($_POST['var_pb_event_title'][$px_counter_event]) );
										$event->addChild('var_pb_featured_post', $_POST['var_pb_featured_post'][$px_counter_event] );
										$event->addChild('var_pb_featuredevent_title', $_POST['var_pb_featuredevent_title'][$px_counter_event] );
										$event->addChild('var_pb_event_type', $_POST['var_pb_event_type'][$px_counter_event] );
										$event->addChild('var_pb_event_category', $_POST['var_pb_event_category'][$px_counter_event] );
										$event->addChild('var_pb_event_pagination', $_POST['var_pb_event_pagination'][$px_counter_event] );
										$event->addChild('event_element_size', $_POST['event_element_size'][$px_counter_event] );
										$event->addChild('var_pb_event_per_page', $_POST['var_pb_event_per_page'][$px_counter_event] );
										$px_counter_event++;
									}else if ( $_POST['px_orderby'][$px_counter] == "contact" ) {
										$contact = $sxe->addChild('contact');
 										$contact->addChild('px_contact_email', $_POST['px_contact_email'][$px_counter_contact] );
										$contact->addChild('px_contact_title', $_POST['px_contact_title'][$px_counter_contact] );
										$contact->addChild('px_contact_address', $_POST['px_contact_address'][$px_counter_contact] );
										$contact->addChild('px_contact_phone', $_POST['px_contact_phone'][$px_counter_contact] );
										$contact->addChild('px_contact_fax', $_POST['px_contact_fax'][$px_counter_contact] );
										$contact->addChild('px_contact_emile', $_POST['px_contact_emile'][$px_counter_contact] );
										$contact->addChild('px_contact_succ_msg', $_POST['px_contact_succ_msg'][$px_counter_contact] );
										$contact->addChild('contact_element_size', $_POST['contact_element_size'][$px_counter_contact] );
										$px_counter_contact++;
									
									}else if ( $_POST['px_orderby'][$px_counter] == "column" ) {
										$column = $sxe->addChild('column');
										$column->addChild('column_element_size', htmlspecialchars($_POST['column_element_size'][$px_counter_column]) );
										$column->addChild('column_text', $_POST['column_text'][$px_counter_column] );
										$column->addChild('column_donate_text', $_POST['column_donate_text'][$px_counter_column] );
										$column->addChild('column_donate_url', $_POST['column_donate_url'][$px_counter_column] );
										$px_counter_column++;
									
									}else if ( $_POST['px_orderby'][$px_counter] == "team" ) {
										$team = $sxe->addChild('team');
											$team->addChild('team_title', htmlspecialchars($_POST['team_title'][$px_counter_team]) );
											$team->addChild('team_pagination', $_POST['team_pagination'][$px_counter_team] );
											$team->addChild('team_page_num', $_POST['team_page_num'][$px_counter_team] );
											$team->addChild('team_element_size', $_POST['team_element_size'][$px_counter_team] );
										$px_counter_team++;
									}
									$px_counter++;
								}
							}
							update_post_meta( $post_id, 'px_page_builder', $sxe->asXML() );
					//creating xml page builder end
				}
		}
	}
?>