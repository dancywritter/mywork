<?php
	//adding columns start
    add_filter('manage_portfolio_posts_columns', 'portfolio_columns_add');
		function portfolio_columns_add($columns) {
			$columns['category'] = 'Category';
			$columns['tag'] = 'Tags';
			$columns['author'] = 'Author';
			return $columns;
    }
    add_action('manage_portfolio_posts_custom_column', 'portfolio_columns');
		function portfolio_columns($name) {
			global $post;
			switch ($name) {
				case 'category':
					$categories = get_the_terms( $post->ID, 'portfolio-category' );
						if($categories <> ""){
							$couter_comma = 0;
							foreach ( $categories as $category ) {
								echo $category->name;
								$couter_comma++;
								if ( $couter_comma < count($categories) ) {
									echo ", ";
								}
							}
						}
					break;
				case 'tag':
					$categories = get_the_terms( $post->ID, 'portfolio-tag' );
						if($categories <> ""){
							$couter_comma = 0;
							foreach ( $categories as $category ) {
								echo $category->name;
								$couter_comma++;
								if ( $couter_comma < count($categories) ) {
									echo ", ";
								}
							}
						}
					break;
				case 'author':
					echo get_the_author();
					break;
			}
		}
	//adding columns end

	function register_post_type_portfolio(){
		$post_type_name = 'Portfolio';
		// adding post type start
			$labels = array(
				'name' => $post_type_name,
				'add_new_item' => 'Add New '.$post_type_name,
				'edit_item' => 'Edit '.$post_type_name,
				'new_item' => 'New '.$post_type_name.' Item',
				'add_new' => 'Add New '.$post_type_name,
				'view_item' => 'View '.$post_type_name.' Item',
				'search_items' => 'Search '.$post_type_name,
				'not_found' =>  'No '.$post_type_name.' Found',
				'not_found_in_trash' => 'No '.$post_type_name.' Found in Trash'
			);
			$args = array(
				'labels' => $labels,
				'public' => true,
				'menu_icon' => get_stylesheet_directory_uri() . '/images/admin/portfolio-icon.png',
				'supports' => array('title','editor','thumbnail','comments')
			); 
			register_post_type( 'portfolio' , $args );
		// adding post type end
	}
	add_action('init', 'register_post_type_portfolio');

		// adding category start
		  $labels = array(
			'name' => 'Portfolio Categories',
			'search_items' => 'Search Portfolio Categories',
			'edit_item' => 'Edit Portfolio Category', 
			'update_item' => 'Update Portfolio Category',
			'add_new_item' => 'Add New Category',
			'menu_name' => 'Portfolio Categories',
		  );
		  register_taxonomy('portfolio-category',array('portfolio'), array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'portfolio-category' ),
		  ));
		// adding category end
		// adding tag start
			$labels = array(
				'name' => 'Portfolio Tags',
				'search_items' =>  'Search Portfolio Tags',
				'edit_item' => 'Edit Portfolio Tag', 
				'update_item' => 'Update Portfolio Tag',
				'add_new_item' => 'Add Portfolio Tag',
				'menu_name' => 'Portfolio Tags'
			); 	
			register_taxonomy('portfolio-tag',array('portfolio'), array(
				'hierarchical' => false,
				'labels' => $labels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'portfolio-tag' ),
			));
		// adding tag end

	// meta box start
	function meta_box_portfolio($post){
	$portfolio_xml = get_post_meta($post->ID, "portfolio", true);
	global $cs_xmlObject;
	if ( $portfolio_xml <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($portfolio_xml);
			$sub_title = $cs_xmlObject->sub_title;
			$portfolio_view = $cs_xmlObject->portfolio_view;
			$header_banner_options = $cs_xmlObject->header_banner_options;
			$header_banner = $cs_xmlObject->header_banner;
			$slider_id = htmlspecialchars($cs_xmlObject->slider_id);
			$portfolio_thumb_view = $cs_xmlObject->portfolio_thumb_view;
            $portfolio_thumb_gallery = $cs_xmlObject->portfolio_thumb_gallery;
                        
			$inside_portfolio_thumb_view = $cs_xmlObject->inside_portfolio_thumb_view;
			$inside_portfolio_thumb_slider = $cs_xmlObject->inside_portfolio_thumb_slider;
			$inside_portfolio_thumb_slider_type = $cs_xmlObject->inside_portfolio_thumb_slider_type;
			$inside_portfolio_thumb_gallery = $cs_xmlObject->inside_portfolio_thumb_gallery;
			$inside_portfolio_related_post_title = $cs_xmlObject->inside_portfolio_related_post_title;
                        
			$portfolio_social_sharing = $cs_xmlObject->portfolio_social_sharing;
			$portfolio_related = $cs_xmlObject->portfolio_related;
			$port_other_info_main_title = $cs_xmlObject->port_other_info_main_title;
			$switch_footer_widgets = $cs_xmlObject->switch_footer_widgets;
			$portfolio_post_desc = $cs_xmlObject->portfolio_post_desc;
			$portfolio_post_desc_title = $cs_xmlObject->portfolio_post_desc_title;
			$port_live_link_title = $cs_xmlObject->port_live_link_title;
			$port_live_link_url = $cs_xmlObject->port_live_link_url;
	}
	else {
		$sub_title = '';
		$portfolio_view = '';
		$header_banner_options = '';
		$header_banner = '';
		         
		$inside_portfolio_thumb_view = '';
		$inside_portfolio_thumb_custom_image = '';
		$inside_portfolio_thumb_audio = '';
		$inside_portfolio_thumb_video = '';
		$inside_portfolio_thumb_slider = '';
		$inside_portfolio_thumb_slider_type = '';
 		$inside_portfolio_thumb_gallery = '';
                
                
		$portfolio_social_sharing = '';
		$portfolio_related = '';
		$port_other_info_main_title = '';
		$switch_footer_widgets = '';
		$portfolio_post_desc = '';
		$portfolio_post_desc_title = '';
		$inside_portfolio_related_post_title = '';
		$port_live_link_title = '';
		$port_live_link_url = '';
	}
?>
	<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/select.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/prettyCheckable.js"></script>
	<div class="page-wrap">
        <div class="option-sec row">
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Sub Title</label></li>
                    <li class="to-field">
                    	<input type="text" name="sub_title" value="<?php echo $sub_title ?>" />
                        <p>Put the sub title.</p>
                    </li>
                </ul>
            	<ul class="form-elements">
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
					<ul class="form-elements noborder" id="default_image" style="display:<?php if($header_banner_options=="Default Image" or $header_banner_options == "")echo 'inline"';else echo 'none';?>" >
                    	<li class="to-label"></li>
                        <li class="to-field"><p>Default image (subheader-bg.png) can be replaced from images folder</p></li>
                    </ul>                    
                    <ul class="form-elements noborder" id="custom_image" style="display:<?php if($header_banner_options=="Custom Image")echo 'inline"';else echo 'none';?>" >
                    	<li class="to-label"><label>Header Banner</label></li>
                        <li class="to-field">
                        	<input id="header_banner" name="header_banner" value="<?php echo $header_banner?>" type="text" class="small" />
                            <input id="header_banner" name="header_banner" type="button" class="uploadfile left" value="Browse"/>
                        </li>
                    </ul>
                    <ul class="form-elements noborder" id="layer_slider" style="display:<?php if($header_banner_options == "Slider")echo "inline"; else echo "none"; ?>" >
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
                 </ul>
                 <ul class="form-elements">
                    <li class="to-label"><label>Views</label></li>
                    <li class="to-field">
                        <select name="portfolio_view" class="dropdown">
                        	<option <?php if($portfolio_view=="Full")echo "selected";?> >Full</option>
                        	<option <?php if($portfolio_view=="Side Right")echo "selected";?> >Side Right</option>
                        	<option <?php if($portfolio_view=="Side Left")echo "selected";?> >Side Left</option>
                        </select>
                        <p></p>
                    </li>
				</ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label>Inside Post Thumbnail View</label></li>
                    <li class="to-field">
                        <select name="inside_portfolio_thumb_view" class="dropdown" onchange="javascript:toggle_inside_portfolio(this.value)">
                            <option <?php if($inside_portfolio_thumb_view=="Use Featured Image")echo "selected";?> >Use Featured Image</option>
                            <option <?php if($inside_portfolio_thumb_view=="Slider")echo "selected";?> value="Slider">Slideshow</option>
                            <option <?php if($inside_portfolio_thumb_view=="Simple Gallery")echo "selected";?> >Simple Gallery</option>
                            <option <?php if($inside_portfolio_thumb_view=="Dragable Gallery")echo "selected";?> >Dragable Gallery</option>
                        </select>
                        <p></p>
                    </li>
                        <ul class="form-elements" id="inside_post_thumb_image" style="display:<?php if($inside_portfolio_thumb_view=="Use Featured Image")echo 'inline"';else echo 'none';?>" >
                            <li class="to-label"><label>Thumbnail Image URL</label></li>
                            <li class="to-field"></li>
                            <li class="to-field"><p>Use Featured Image as Thumbnail</p></li>
                        </ul>
                        <ul class="form-elements" id="inside_post_thumb_slider" style="display:<?php if($inside_portfolio_thumb_view=="Slider")echo 'inline"';else echo 'none';?>" >
                            <li class="to-label"><label>Select Slider</label></li>
                            <li class="to-field">
                                <select name="inside_portfolio_thumb_slider" class="dropdown">
                                    <option value="0">-- Select Slider --</option>
                                    <?php
                                        $query = array( 'posts_per_page' => '-1', 'post_type' => 'cs_slider', 'orderby'=>'ID', 'post_status' => 'publish' );
                                        $wp_query = new WP_Query($query);
                                        while ($wp_query->have_posts()) : $wp_query->the_post();
                                    ?>
                                        <option <?php if(get_the_ID()==$inside_portfolio_thumb_slider)echo "selected";?> value="<?php the_ID()?>"><?php the_title()?></option>
                                    <?php
                                        endwhile;
                                    ?>
                                </select>
                            </li>
                            <input type="hidden" name="portfolio_thumb_slider_type" value="Flex Slider">
                            	
                        </ul>
                    	<ul class="form-elements" id="inside_post_thumb_gallery" style="display:<?php if($inside_portfolio_thumb_view=="Simple Gallery" || $inside_portfolio_thumb_view=="Dragable Gallery")echo 'inline"';else echo 'none';?>" >
                            <li class="to-label"><label>Select Gallery</label></li>
                            <li class="to-field">
                                <select name="inside_portfolio_thumb_gallery" class="dropdown">
                                    <option value="0">-- Select Gallery --</option>
                                    <?php
                                        $query = array( 'posts_per_page' => '-1', 'post_type' => 'cs_gallery', 'orderby'=>'ID', 'post_status' => 'publish' );
                                        $wp_query = new WP_Query($query);
                                        while ($wp_query->have_posts()) : $wp_query->the_post();
                                    ?>
                                        <option <?php if(get_the_ID()==$inside_portfolio_thumb_gallery)echo "selected";?> value="<?php the_ID()?>"><?php the_title()?></option>
                                    <?php
                                        endwhile;
                                    ?>
                                </select>
                            </li>
                    </ul>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Description Title</label></li>
                    <li class="to-field">
                        <input id="portfolio_post_desc_title" type="text" class="txtfield" name="portfolio_post_desc_title" value="<?php echo $portfolio_post_desc_title;  ?>" />
                        <p>Put Description Title</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Description</label></li>
                    <li class="to-field">
                        <textarea id="portfolio_post_desc" name="portfolio_post_desc"><?php echo $portfolio_post_desc;  ?></textarea>
                        <p>Put Description Text</p>
                    </li>
                </ul>
                 <ul class="form-elements">
                    <li class="to-label"><label>Social Sharing</label></li>
                    <li class="to-field">
                        <div class="on-off"><input type="checkbox" name="portfolio_social_sharing" value="on" class="myClass" <?php if($portfolio_social_sharing=='on')echo "checked"?> /></div>
                        <p>Make Social Sharing On/Off</p>
                    </li>
                </ul>
				<ul class="form-elements">
                    <li class="to-label"><label>Related Post</label></li>
                    <li class="to-field">
                        <div class="on-off"><input type="checkbox"  onchange="javascript:related_title_toggle_inside_post(this)" name="portfolio_related"   class="myClass"  <?php if(empty($portfolio_related) || $portfolio_related == "on"){ echo "checked"; }?> /></div>
                        <p>Make Related Post On/Off</p>
                    </li>
                </ul>
                <ul class="form-elements" id="related_post"   style="display:<?php if(empty($portfolio_related) || $portfolio_related == 'on'){ echo 'inline'; }else{ echo 'none';} ?>">
                    <li class="to-label"><label>Related Post Title</label></li>
                    <li class="to-field">
                         <input id="inside_portfolio_related_post_title" name="inside_portfolio_related_post_title" value="<?php if($inside_portfolio_related_post_title <> '' ){ echo $inside_portfolio_related_post_title; }else{ echo "Related Post";} ?>" type="text" class="small" />
                         <p>Put Related Post Title</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Footer Widgets</label></li>
                    <li class="to-field">
                        <div class="on-off"><input type="checkbox" name="switch_footer_widgets" class="myClass" <?php if(empty($switch_footer_widgets) || $switch_footer_widgets == "on"){ echo "checked"; } ?> /></div>
                        <p>Make footer widgets On/Off</p>
                    </li>
                </ul>
			</div>
		</div>
		<div class="clear"></div>
        
	        <div class="boxes tracklists">
                <div id="add_port_other" class="poped-up">
                    <div class="opt-head">
                        <h5>Add Portfolio Other Info</h5>
                        <a href="javascript:closepopedup('add_port_other')" class="closeit">&nbsp;</a>
                        <div class="clear"></div>
                    </div>
                    <ul class="form-elements">
                        <li class="to-label"><label>Title Text</label></li>
                        <li class="to-field">
                            <input type="text" id="port_other_info_title_dummy" name="port_other_info_title_dummy" value="" />
                            <p>Put Title Text</p>
                        </li>
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label"><label>Description</label></li>
                        <li class="to-field">
                            <textarea id="port_other_info_desc" name="port_other_info_desc"></textarea>
                            <p>Put Description Text</p>
                        </li>
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label"><label>Icon</label></li>
                        <li class="to-field">
                            <input type="text" id="port_other_info_icon" name="port_other_info_icon" value="" />
                            <p>
                            	Put Awesome Font Code like "icon-flag". You can get others from 
                            	<a target="_blank" href="http://fortawesome.github.io/Font-Awesome/cheatsheet/">http://fortawesome.github.io/Font-Awesome/cheatsheet/</a>
                            </p>
                        </li>
                    </ul>
                    <ul class="form-elements noborder">
                        <li class="to-label"></li>
                        <li class="to-field"><input type="button" value="Add to List" onclick="cs_add_port_portfolio('<?php echo home_url()?>', '<?php echo get_template_directory_uri()?>')" /></li>
                    </ul>
                </div>
                <script>
					var count_port_portfolio_js = <?php echo count($cs_xmlObject->other_info)?>;
                    jQuery(document).ready(function($) {
                        $("#total_port_portfolio").sortable({
                            cancel : 'td div.poped-up',
                        });
                    });
                </script>
                <div class="opt-head">
                    <h4 style="padding-top:12px;">Portfolio Other Info</h4>
                    <a href="javascript:openpopedup('add_port_other')" class="button">Add</a>
                    <div class="clear"></div>
                </div>
                <ul class="form-elements">
                    <li class="to-label"><label>Other Info Title</label></li>
                    <li class="to-field">
                        <input style="background-color:#FFF; border:1px solid #D8D8D8" type="text" name="port_other_info_main_title" value="<?php echo $port_other_info_main_title?>" />
                        <p>Put the title for other info</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Project Live Title</label></li>
                    <li class="to-field">
                        <input style="background-color:#FFF; border:1px solid #D8D8D8" type="text" name="port_live_link_title" value="<?php echo $port_live_link_title?>" />
                        <p>Put the title for project live link</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Project Live Link</label></li>
                    <li class="to-field">
                        <input style="background-color:#FFF; border:1px solid #D8D8D8" type="text" name="port_live_link_url" value="<?php echo $port_live_link_url?>" />
                        <p>Put the url for project live link</p>
                    </li>
                </ul>
                <table class="to-table" border="0" cellspacing="0">
                    <thead>
                        <?php
                            global $cs_counter_track, $album_track_title;
                        ?>
                            <tr id="port_other_header">
                                <th style="width:80%;">Title Text</th>
                                <th style="width:80%;" class="centr">Actions</th>
                            </tr>
                    </thead>
                    <tbody id="total_port_portfolio">
                        <?php
							global $cs_counter_port_portfolio, $port_other_info_title, $port_other_info_desc, $port_other_info_icon;
							$cs_counter_port_portfolio = $post->ID;
							if ( $portfolio_xml <> "" ) {
								foreach ( $cs_xmlObject as $track ){
									if ( $track->getName() == "other_info" ) {
										$port_other_info_title = $track->port_other_info_title;
										$port_other_info_desc = $track->port_other_info_desc;
										$port_other_info_icon = $track->port_other_info_icon;
										$cs_counter_port_portfolio++;
										//include(TEMPLATEPATH."/include/album_track.php");
										cs_add_port_portfolio();
									}
								}
							}
                        ?>
                    </tbody>
                </table>
            </div>
                
		<?php //meta_layout()?>
        <input type="hidden" name="portfolio_meta_form" value="1" />
    </div>
<?php
}
    function cs_add_meta_box_portfolio(){
        add_meta_box( 'portfolio_meta', 'Portfolio Options', 'meta_box_portfolio', 'portfolio', 'normal', 'high' );
    }
	add_action( 'add_meta_boxes', 'cs_add_meta_box_portfolio' );
	// meta box end

	// meta box saving start
		if ( isset($_POST['portfolio_meta_form']) and $_POST['portfolio_meta_form'] == 1 ) {
			add_action( 'save_post', 'cs_meta_post_save' );
			function cs_meta_post_save( $post_id ) {
				if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
					if ( empty($_POST['portfolio_social_sharing']) ) $_POST['portfolio_social_sharing'] = "";
					if ( empty($_POST['sub_title']) ) $_POST['sub_title'] = "";
					if ( empty($_POST['portfolio_view']) ) $_POST['portfolio_view'] = "";
					if ( empty($_POST['header_banner_options']) ) $_POST['header_banner_options'] = "";
					if ( empty($_POST['header_banner']) ) $_POST['header_banner'] = "";
					if ( empty($_POST['slider_id']) ) $_POST['slider_id'] = "";
					if ( empty($_POST['portfolio_thumb_view']) ) $_POST['portfolio_thumb_view'] = "";
					if ( empty($_POST['portfolio_thumb_audio']) ) $_POST['portfolio_thumb_audio'] = "";
					if ( empty($_POST['portfolio_thumb_video']) ) $_POST['portfolio_thumb_video'] = "";
					
					if ( empty($_POST['portfolio_thumb_slider_type']) ) $_POST['portfolio_thumb_slider_type'] = "";
					if ( empty($_POST['inside_portfolio_thumb_view']) ) $_POST['inside_portfolio_thumb_view'] = "";
					if ( empty($_POST['inside_portfolio_thumb_custom_image']) ) $_POST['inside_portfolio_thumb_custom_image'] = "";
					
					if ( empty($_POST['inside_portfolio_thumb_audio']) ) $_POST['inside_portfolio_thumb_audio'] = "";
					if ( empty($_POST['inside_portfolio_thumb_video']) ) $_POST['inside_portfolio_thumb_video'] = "";
					if ( empty($_POST['inside_portfolio_thumb_slider']) ) $_POST['inside_portfolio_thumb_slider'] = "";
					if ( empty($_POST['inside_portfolio_thumb_slider_type']) ) $_POST['inside_portfolio_thumb_slider_type'] = "";
					if ( empty($_POST['inside_portfolio_thumb_gallery']) ) $_POST['inside_portfolio_thumb_gallery'] = "";
					if ( empty($_POST['inside_portfolio_related_post_title']) ) $_POST['inside_portfolio_related_post_title'] = "";
					
					if ( empty($_POST['portfolio_related']) ) $_POST['portfolio_related'] = "";
					if ( empty($_POST['portfolio_launch_title']) ) $_POST['portfolio_launch_title'] = "";
					if ( empty($_POST['portfolio_launch_link']) ) $_POST['portfolio_launch_link'] = "";
					if ( empty($_POST['switch_footer_widgets']) ) $_POST['switch_footer_widgets'] = "";
					if ( empty($_POST['portfolio_post_desc']) ) $_POST['portfolio_post_desc'] = "";
					if ( empty($_POST['portfolio_post_desc_title']) ) $_POST['portfolio_post_desc_title'] = "";
					if ( empty($_POST['portfolio_social_sharing']) ) $_POST['portfolio_social_sharing'] = "";
					if ( empty($_POST['portfolio_social_sharing']) ) $_POST['portfolio_social_sharing'] = "";
					if ( empty($_POST['portfolio_social_sharing']) ) $_POST['portfolio_social_sharing'] = "";
						$sxe = new SimpleXMLElement("<cs_meta_portfolio></cs_meta_portfolio>");
							$sxe->addChild('sub_title', $_POST['sub_title'] );
							$sxe->addChild('portfolio_view', $_POST['portfolio_view'] );
							$sxe->addChild('header_banner_options', $_POST['header_banner_options'] );
							$sxe->addChild('header_banner', $_POST['header_banner'] );
							$sxe->addChild('inside_portfolio_thumb_view', $_POST['inside_portfolio_thumb_view'] );
							$sxe->addChild('inside_portfolio_thumb_custom_image', $_POST['inside_portfolio_thumb_custom_image'] );
 							$sxe->addChild('inside_portfolio_thumb_audio', $_POST['inside_portfolio_thumb_audio'] );
							$sxe->addChild('inside_portfolio_thumb_video', $_POST['inside_portfolio_thumb_video'] );
							$sxe->addChild('inside_portfolio_thumb_slider', $_POST['inside_portfolio_thumb_slider'] );
							$sxe->addChild('inside_portfolio_thumb_slider_type', $_POST['inside_portfolio_thumb_slider_type'] );
                            $sxe->addChild('inside_portfolio_thumb_gallery', $_POST['inside_portfolio_thumb_gallery'] );
							$sxe->addChild('inside_portfolio_related_post_title', $_POST['inside_portfolio_related_post_title'] );
							$sxe->addChild('portfolio_social_sharing', $_POST['portfolio_social_sharing'] );
							$sxe->addChild('portfolio_related', $_POST['portfolio_related'] );
							$sxe->addChild('port_other_info_main_title', $_POST['port_other_info_main_title'] );
							$sxe->addChild('port_live_link_title', $_POST['port_live_link_title'] );
							$sxe->addChild('port_live_link_url', $_POST['port_live_link_url'] );
							$sxe->addChild('switch_footer_widgets', $_POST['switch_footer_widgets'] );
							$sxe->addChild('portfolio_post_desc', htmlspecialchars($_POST['portfolio_post_desc']));
							$sxe->addChild('portfolio_post_desc_title', htmlspecialchars($_POST['portfolio_post_desc_title']));
							
							
							$cs_counter = 0;

							if ( isset($_POST['port_other_info_title']) ) {
								foreach ( $_POST['port_other_info_title'] as $count ){
									$other_info = $sxe->addChild('other_info');
										$other_info->addChild('port_other_info_title', htmlspecialchars($_POST['port_other_info_title'][$cs_counter]) );
										$other_info->addChild('port_other_info_desc', htmlspecialchars($_POST['port_other_info_desc'][$cs_counter]) );
										$other_info->addChild('port_other_info_icon', htmlspecialchars($_POST['port_other_info_icon'][$cs_counter]) );
										$cs_counter++;
								}
							}
							//$sxe = save_layout_xml($sxe);
							
				update_post_meta( $post_id, 'portfolio', $sxe->asXML() );
			}
		}
	
	// meta box saving end

?>