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
	global $xmlObject;
	if ( $portfolio_xml <> "" ) {
		$xmlObject = new SimpleXMLElement($portfolio_xml);
			$portfolio_view = $xmlObject->portfolio_view;
			$portfolio_thumb_view = $xmlObject->portfolio_thumb_view;
            $portfolio_thumb_gallery = $xmlObject->portfolio_thumb_gallery;
                        
			$inside_portfolio_thumb_view = $xmlObject->inside_portfolio_thumb_view;
			$inside_portfolio_thumb_slider = $xmlObject->inside_portfolio_thumb_slider;
			$inside_portfolio_thumb_slider_type = $xmlObject->inside_portfolio_thumb_slider_type;
			$inside_portfolio_thumb_gallery = $xmlObject->inside_portfolio_thumb_gallery;
			//$inside_portfolio_related_post_title = $xmlObject->inside_portfolio_related_post_titl
			$inside_post_thumb_audio = $xmlObject->inside_post_thumb_audio;
			$inside_post_thumb_video = $xmlObject->inside_post_thumb_video;
			$inside_post_featured_image_as_thumbnail = $xmlObject->inside_post_featured_image_as_thumbnail;
                        
			$portfolio_social_sharing = $xmlObject->portfolio_social_sharing;
			//$portfolio_related = $xmlObject->portfolio_related;
			$port_other_info_main_title = $xmlObject->port_other_info_main_title;
			$portfolio_post_desc = $xmlObject->portfolio_post_desc;
			$portfolio_post_desc_title = $xmlObject->portfolio_post_desc_title;
			$port_live_link_title = $xmlObject->port_live_link_title;
			$port_live_link_url = $xmlObject->port_live_link_url;
			
			$cs_blog_large_layout = $xmlObject->cs_blog_large_layout;
			$page_content_postion = $xmlObject->page_content_postion;
			
	}
	else {
		$portfolio_view = '';
		$portfolio_thumb_view = '';
		$portfolio_thumb_audio = '';
		$portfolio_thumb_video = '';
		$portfolio_thumb_slider = '';
		$portfolio_thumb_slider_type = '';
		$portfolio_thumb_gallery = '';
                 
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
		$portfolio_post_desc = '';
		$portfolio_post_desc_title = '';
		$inside_portfolio_related_post_title = '';
		$port_live_link_title = '';
		$port_live_link_url = '';
		$cs_blog_large_layout = '';
		$page_content_postion = '';
	}
?>
	<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/select.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/prettyCheckable.js"></script>
	<div class="page-wrap">
        <div class="option-sec row">
            <div class="opt-conts">
            	 <ul class="form-elements" style="display:none;">
                    <li class="to-label"><label>Views</label></li>
                    <li class="to-field">
                        <select name="portfolio_view" class="dropdown">
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
                            <option <?php if($inside_portfolio_thumb_view=="Audio")echo "selected";?> >Audio</option>
                            <option <?php if($inside_portfolio_thumb_view=="Video")echo "selected";?> value="Video">Video/Soundcloud</option>
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
                    <ul class="form-elements" id="inside_post_thumb_audio" style="display:<?php if($inside_portfolio_thumb_view=="Audio")echo 'inline"';else echo 'none';?>" >
                            <li class="to-label"><label>Audio URL</label></li>
                            <li class="to-field">
                                <input type="text" id="inside_post_thumb_audio2" name="inside_post_thumb_audio" value="<?php echo htmlspecialchars($inside_post_thumb_audio)?>" class="txtfield" />
                                <input type="button" id="inside_post_thumb_audio2" name="inside_post_thumb_audio2" class="uploadfile left" value="Browse"/>
                                <p>Enter Specific Audio URL (Youtube, Vimeo and all otheres wordpress supported)</p>
                            </li>
                        </ul>
                        <ul class="form-elements" id="inside_post_thumb_video" style="display:<?php if($inside_portfolio_thumb_view=="Video")echo 'inline"';else echo 'none';?>" >
                            <li class="to-label"><label>Use featured image as video thumbnail</label></li>
                            <li class="to-field">
                                <div class="on-off"><input type="checkbox" name="inside_post_featured_image_as_thumbnail" value="on" class="styled" <?php if($inside_post_featured_image_as_thumbnail=='on')echo "checked"?> /></div>
                                <p>It will work only for self hosted video</p>
                            </li>
                            <li class="full">&nbsp;</li>
                            <li class="to-label"><label>Thumbnail Video URL</label></li>
                            <li class="to-field">
                                <input id="inside_post_thumb_video2" name="inside_post_thumb_video" value="<?php echo $inside_post_thumb_video?>" type="text" class="small" />
                                <input id="inside_post_thumb_video2" name="inside_post_thumb_video2" type="button" class="uploadfile left" value="Browse"/>
                                <p>Enter Specific Video URL (Youtube, Vimeo and all otheres wordpress supported) OR you can select it from your media library</p>
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
                <ul class="form-elements" style="display:none;">
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
                        <p>Enter Page layout padding in percentage.</p>
                    </li>
                </ul>
				<!--<ul class="form-elements">
                    <li class="to-label"><label>Related Post</label></li>
                    <li class="to-field">
                        <div class="on-off"><input type="checkbox"  onchange="javascript:related_title_toggle_inside_post(this)" name="portfolio_related"   class="myClass"  <?php //if(empty($portfolio_related) || $portfolio_related == "on"){ echo "checked"; }?> /></div>
                        <p>Make Related Post On/Off</p>
                    </li>
                </ul>
                <ul class="form-elements" id="related_post"   style="display:<?php if(empty($portfolio_related) || $portfolio_related == 'on'){ echo 'inline'; }else{ echo 'none';} ?>">
                    <li class="to-label"><label>Related Post Title</label></li>
                    <li class="to-field">
                         <input id="inside_portfolio_related_post_title" name="inside_portfolio_related_post_title" value="<?php if($inside_portfolio_related_post_title <> '' ){ echo $inside_portfolio_related_post_title; }else{ echo "Related Post";} ?>" type="text" class="small" />
                         <p>Put Related Post Title</p>
                    </li>
                </ul>-->
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
                    
                    <ul class="form-elements noborder">
                        <li class="to-label"></li>
                        <li class="to-field"><input type="button" value="Add to List" onclick="cs_add_port_portfolio('<?php echo home_url()?>', '<?php echo get_template_directory_uri()?>')" /></li>
                    </ul>
                </div>
                <script>
					var count_port_portfolio_js = <?php echo count($xmlObject->other_info)?>;
                    jQuery(document).ready(function($) {
                        $("#total_port_portfolio").sortable({
                            cancel : 'td div.poped-up',
                        });
                    });
                </script>
                <div class="opt-head">
                    <h4 style="padding-top:12px;">Portfolio Other Info</h4>
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
                <div class="opt-head">
                    <a href="javascript:openpopedup('add_port_other')" class="button">Add</a>
                    <div class="clear"></div>
                </div>
                <table class="to-table" border="0" cellspacing="0">
                    <thead>
                        <?php
                            global $counter_track, $album_track_title;
                        ?>
                            <tr id="port_other_header">
                                <th style="width:80%;">Title Text</th>
                                <th style="width:80%;" class="centr">Actions</th>
                            </tr>
                    </thead>
                    <tbody id="total_port_portfolio">
                        <?php
							global $counter_port_portfolio, $port_other_info_title, $port_other_info_desc;
							$counter_port_portfolio = $post->ID;
							if ( $portfolio_xml <> "" ) {
								foreach ( $xmlObject as $track ){
									if ( $track->getName() == "other_info" ) {
										$port_other_info_title = $track->port_other_info_title;
										$port_other_info_desc = $track->port_other_info_desc;
										$counter_port_portfolio++;
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
					if ( empty($_POST['portfolio_thumb_view']) ) $_POST['portfolio_thumb_view'] = "";
					if ( empty($_POST['portfolio_thumb_audio']) ) $_POST['portfolio_thumb_audio'] = "";
					if ( empty($_POST['portfolio_thumb_video']) ) $_POST['portfolio_thumb_video'] = "";
					if ( empty($_POST['portfolio_thumb_slider']) ) $_POST['portfolio_thumb_slider'] = "";
					if ( empty($_POST['portfolio_thumb_slider_type']) ) $_POST['portfolio_thumb_slider_type'] = "";
					
					
					if ( empty($_POST['inside_portfolio_thumb_view']) ) $_POST['inside_portfolio_thumb_view'] = "";
					if ( empty($_POST['inside_portfolio_thumb_custom_image']) ) $_POST['inside_portfolio_thumb_custom_image'] = "";
					
					if ( empty($_POST['inside_portfolio_thumb_audio']) ) $_POST['inside_portfolio_thumb_audio'] = "";
					if ( empty($_POST['inside_post_thumb_video']) ) $_POST['inside_post_thumb_video'] = "";
					if ( empty($_POST['inside_portfolio_thumb_slider']) ) $_POST['inside_portfolio_thumb_slider'] = "";
					if ( empty($_POST['inside_portfolio_thumb_slider_type']) ) $_POST['inside_portfolio_thumb_slider_type'] = "";
					if ( empty($_POST['inside_portfolio_thumb_gallery']) ) $_POST['inside_portfolio_thumb_gallery'] = "";
					if ( empty($_POST['inside_post_featured_image_as_thumbnail']) ) $_POST['inside_post_featured_image_as_thumbnail'] = "";
					

					if ( empty($_POST['portfolio_launch_title']) ) $_POST['portfolio_launch_title'] = "";
					if ( empty($_POST['portfolio_post_desc']) ) $_POST['portfolio_post_desc'] = "";
					if ( empty($_POST['portfolio_post_desc_title']) ) $_POST['portfolio_post_desc_title'] = "";
					if ( empty($_POST['portfolio_social_sharing']) ) $_POST['portfolio_social_sharing'] = "";
					
					if ( empty($_POST['port_other_info_main_title']) ) $_POST['port_other_info_main_title'] = "";
					if ( empty($_POST['port_live_link_title']) ) $_POST['port_live_link_title'] = "";
					if ( empty($_POST['port_live_link_url']) ) $_POST['port_live_link_url'] = "";
					
					if (empty($_POST['cs_blog_large_layout']))$_POST['cs_blog_large_layout'] = "";
					if (empty($_POST["page_content_postion"])){ $_POST["page_content_postion"] = "";}
					

						$sxe = new SimpleXMLElement("<cs_meta_portfolio></cs_meta_portfolio>");
							$sxe->addChild('sub_title', $_POST['sub_title'] );
							$sxe->addChild('portfolio_view', $_POST['portfolio_view'] );

							$sxe->addChild('portfolio_thumb_view', $_POST['portfolio_thumb_view'] );
							$sxe->addChild('portfolio_thumb_audio', $_POST['portfolio_thumb_audio'] );
							$sxe->addChild('portfolio_thumb_video', $_POST['portfolio_thumb_video'] );
							$sxe->addChild('portfolio_thumb_slider', $_POST['portfolio_thumb_slider'] );
							$sxe->addChild('portfolio_thumb_slider_type', $_POST['portfolio_thumb_slider_type'] );

							$sxe->addChild('inside_portfolio_thumb_view', $_POST['inside_portfolio_thumb_view'] );
							$sxe->addChild('inside_portfolio_thumb_custom_image', $_POST['inside_portfolio_thumb_custom_image'] );
 							$sxe->addChild('inside_post_thumb_audio', $_POST['inside_post_thumb_audio'] );
							$sxe->addChild('inside_post_thumb_video', $_POST['inside_post_thumb_video'] );
							$sxe->addChild('inside_portfolio_thumb_slider', $_POST['inside_portfolio_thumb_slider'] );
							$sxe->addChild('inside_portfolio_thumb_slider_type', $_POST['inside_portfolio_thumb_slider_type'] );
                            $sxe->addChild('inside_portfolio_thumb_gallery', $_POST['inside_portfolio_thumb_gallery'] );
							
							$sxe->addChild('inside_post_featured_image_as_thumbnail', $_POST['inside_post_featured_image_as_thumbnail'] );

							$sxe->addChild('portfolio_social_sharing', $_POST['portfolio_social_sharing'] );

							$sxe->addChild('port_other_info_main_title', $_POST['port_other_info_main_title'] );
							$sxe->addChild('port_live_link_title', $_POST['port_live_link_title'] );
							$sxe->addChild('port_live_link_url', $_POST['port_live_link_url'] );
							$sxe->addChild('portfolio_post_desc', htmlspecialchars($_POST['portfolio_post_desc']));
							$sxe->addChild('portfolio_post_desc_title', htmlspecialchars($_POST['portfolio_post_desc_title']));
							$sxe->addChild('cs_blog_large_layout', $_POST['cs_blog_large_layout']);
							$sxe->addChild('page_content_postion', $_POST['page_content_postion']);
							
							$counter = 0;

							if ( isset($_POST['port_other_info_title']) ) {
								foreach ( $_POST['port_other_info_title'] as $count ){
									$other_info = $sxe->addChild('other_info');
										$other_info->addChild('port_other_info_title', htmlspecialchars($_POST['port_other_info_title'][$counter]) );
										$other_info->addChild('port_other_info_desc', htmlspecialchars($_POST['port_other_info_desc'][$counter]) );
										$counter++;
								}
							}
							//$sxe = save_layout_xml($sxe);
				update_post_meta( $post_id, 'portfolio', $sxe->asXML() );
			}
		}
	
	// meta box saving end

?>