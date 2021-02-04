<?php
	//adding columns start
    add_filter('manage_albums_posts_columns', 'album_columns_add');
		function album_columns_add($columns) {
			$columns['category'] = 'Category';
			$columns['author'] = 'Author';
			return $columns;
    }
    add_action('manage_albums_posts_custom_column', 'album_columns');
		function album_columns($name) {
			global $post;
			switch ($name) {
				case 'category':
					$categories = get_the_terms( $post->ID, 'album-category' );
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

	function cs_album_register() {
		$labels = array(
			'name' => 'Albums',
			'add_new_item' => 'Add New Album',
			'edit_item' => 'Edit Album',
			'new_item' => 'New Album Item',
			'add_new' => 'Add New Album',
			'view_item' => 'View Album Item',
			'search_items' => 'Search Album',
			'not_found' =>  'Nothing found',
			'not_found_in_trash' => 'Nothing found in Trash',
			'parent_item_colon' => ''
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon' => get_stylesheet_directory_uri() . '/images/admin/album-icon.png',
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title','editor','thumbnail', 'comments' )
		); 
        register_post_type( 'albums' , $args );
	}

			// adding Artist start
				$labels = array(
					'name' => 'Artists',
					'add_new_item' => 'Add New Artist',
					'edit_item' => 'Edit Artist',
					'new_item' => 'New Artist',
					'add_new' => 'Add New Artist',
					'view_item' => 'View Artist',
					'search_items' => 'Search Artist',
					'not_found' => 'Nothing found',
					'not_found_in_trash' => 'Nothing found in Trash',
					'parent_item_colon' => ''
				);
				$args = array(
					'labels' => $labels,
					'public' => true,
					'publicly_queryable' => true,
					'show_ui' => true,
					'query_var' => true,
					'menu_icon' => get_stylesheet_directory_uri() . '/images/admin/album-icon.png',
					//'show_in_menu' => 'edit.php?post_type=albums',
					'show_in_nav_menus'=>true,
					'rewrite' => true,
					'capability_type' => 'post',
					'hierarchical' => false,
					'menu_position' => null,
					'supports' => array('title', 'thumbnail')
				); 
				register_post_type( 'artists' , $args );  
			// adding Artist end


	add_action('init', 'cs_album_register');

		// adding cat start
		  $labels = array(
			'name' => 'Album Categories',
			'search_items' => 'Search Album Categories',
			'edit_item' => 'Edit Album Category',
			'update_item' => 'Update Album Category',
			'add_new_item' => 'Add New Category',
			'menu_name' => 'Album Categories',
		  ); 	
		  register_taxonomy('album-category',array('albums'), array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'album-category' ),
		  ));
		// adding cat end
		// adding tag start
		  $labels = array(
			'name' => 'Album Tags',
			'singular_name' => 'album-tag',
			'search_items' => 'Search Tags',
			'popular_items' => 'Popular Tags',
			'all_items' => 'All Tags',
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => 'Edit Tag', 
			'update_item' => 'Update Tag',
			'add_new_item' => 'Add New Tag',
			'new_item_name' => 'New Tag Name',
			'separate_items_with_commas' => 'Separate tags with commas',
			'add_or_remove_items' => 'Add or remove tags',
			'choose_from_most_used' => 'Choose from the most used tags',
			'menu_name' => 'Album Tags',
		  ); 
		  register_taxonomy('album-tag','albums',array(
			'hierarchical' => false,
			'labels' => $labels,
			'show_ui' => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var' => true,
			'rewrite' => array( 'slug' => 'album-tag' ),
		  ));
		// adding tag end

	// adding album meta info start
		add_action( 'add_meta_boxes', 'cs_meta_album_add' );
		function cs_meta_album_add()
		{  
			add_meta_box( 'cs_meta_album', 'Album Options', 'cs_meta_album', 'albums', 'normal', 'high' );  
		}
		function cs_meta_album( $post ) {
			$cs_album = get_post_meta($post->ID, "cs_album", true);
			global $cs_xmlObject;
			if ( $cs_album <> "" ) {
				$cs_xmlObject = new SimpleXMLElement($cs_album);
					$header_banner_options = $cs_xmlObject->header_banner_options;
					$header_banner = $cs_xmlObject->header_banner;
					$slider_id = htmlspecialchars($cs_xmlObject->slider_id);
					$album_release_date_db = $cs_xmlObject->album_release_date;
					$album_social_share_db = $cs_xmlObject->album_social_share;
					$switch_footer_widgets = $cs_xmlObject->switch_footer_widgets;
					$cs_album_rating = $cs_xmlObject->cs_album_rating;
					$album_artist = $cs_xmlObject->album_artist;
					$album_buynow = $cs_xmlObject->album_buynow;
 			}
			else {
				$header_banner_options ='';
				$header_banner = '';
				$slider_id = '';
				$album_release_date_db = '';
				$album_social_share_db = '';
				$switch_footer_widgets = '';
				$cs_album_rating = '';
				$album_artist = '';
				$album_buynow = '';
 			}
			//$album_artist = get_post_meta($post->ID, "album_artist", true);
?>
            <div class="page-wrap page-opts left" style="overflow:hidden; position:relative;">
            <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery.scrollTo-min.js"></script>
			<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/select.js"></script>
            <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/prettyCheckable.js"></script>
                <div class="option-sec" style="margin-bottom:0;">
                    <div class="opt-conts">
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
                             <ul class="form-elements noborder" id="layer_slider" style="display:<?php if($header_banner_options =="Slider")echo "inline"; else echo "none"; ?>" >
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
                            <li class="to-label"><label>Release Date</label></li>
                            <li class="to-field">
                                    <!--date picker start-->
                                        <link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/admin/jquery.ui.datepicker.css">
                                        <link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/admin/jquery.ui.datepicker.theme.css">
                                        <script>
                                        jQuery(function($) {
                                            $( "#album_release_date" ).datepicker({
                                                defaultDate: "+1w",
                                                dateFormat: "yy-mm-dd",
												changeMonth: true,
                                                numberOfMonths: 1,
                                                //onSelect: function( selectedDate ) {
                                                    //$( "#cs_event_to_date" ).datepicker( "option", "minDate", selectedDate );
                                                //}
                                            });
                                        });
                                        </script>
                                    <!--date picker end-->
                                <input type="text" id="album_release_date" name="album_release_date" value="<?php if ($album_release_date_db=="") echo gmdate("Y-m-d"); else echo $album_release_date_db?>" />
                                <p>Put album release date</p>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Social Sharing</label></li>
                            <li class="to-field">
                                <div class="on-off"><input type="checkbox" name="album_social_share" value="on" class="myClass" <?php if($album_social_share_db=='on')echo "checked"?> /></div>
                                <p>Make Social Sharing On/Off</p>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Footer Widgets</label></li>
                            <li class="to-field">
                                <div class="on-off"><input type="checkbox" name="switch_footer_widgets"  class="myClass" <?php if(empty($switch_footer_widgets) || $switch_footer_widgets == "on"){ echo "checked"; } ?> /></div>
                                <p>Make footer widgets On/Off</p>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label">
                                <label>Rating </label>
                            </li>
                        	<li class="to-field">
                            	<select name="cs_album_rating" class="dropdown">
                                	<?php for ( $i = 1; $i <= 5; $i++ ) {?>
                                    	<option value="<?php echo $i?>" <?php if($cs_album_rating == $i){ echo 'selected="selected"';}?>><?php echo $i?></option>
                                    <?php }?>
                                </select>
                            </li>
                       </ul>
						<ul class="form-elements">
                            <li class="to-label"><label>Artist</label></li>
                            <li class="to-field">
                                <select name="album_artist" class="dropdown">
                                    <option value="0"></option>
                                    <?php
                                        query_posts( array('posts_per_page' => "-1", 'post_status' => 'publish', 'post_type' => 'artists') );
                                            while ( have_posts()) : the_post();
                                            ?>
                                                <option <?php if($album_artist==get_the_ID())echo "selected"?> value="<?php the_ID()?>"><?php the_title()?></option>
                                            <?php
                                            endwhile;
                                    ?>
                                </select>
                            </li>
                        </ul>
                       <ul class="form-elements">
                            <li class="to-label">
                                <label>Buy Now URL</label>
                            </li>
                        	<li class="to-field">
                            	<input type="text" name="album_buynow" value="<?php echo $album_buynow ?>" />
                            </li>
                       </ul>
                    </div>
					<div class="clear"></div>
                </div>
                <div class="boxes tracklists">
                	<div id="add_track" class="poped-up">
                        <div class="opt-head">
                            <h5>Track Settings</h5>
                            <a href="javascript:closepopedup('add_track')" class="closeit">&nbsp;</a>
                            <div class="clear"></div>
                        </div>
                        <ul class="form-elements">
                            <li class="to-label"><label>Track Title</label></li>
                            <li class="to-field">
                            	<input type="text" id="album_track_title_dummy" name="album_track_title_dummy" value="Track Title" />
                                <p>Put album track title</p>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Track MP3 URL</label></li>
                            <li class="to-field">
								<input id="album_track_mp3_url" name="album_track_mp3_url" value="" type="text" class="small" />
								<input id="album_track_mp3_url" name="album_track_mp3_url" type="button" class="uploadfile left" value="Browse"/>
                                <p>Put album track mp3 url</p>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Playable</label></li>
                            <li class="to-field">
                                <select name="album_track_playable" id="album_track_playable" class="dropdown">
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                                <p>Make Playable on/off</p>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Downloadable</label></li>
                            <li class="to-field">
                                <select name="album_track_downloadable" id="album_track_downloadable" class="dropdown">
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                                <p>Make Downloadable on/off</p>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Lyrics</label></li>
                            <li class="to-field">
                            	<textarea name="album_track_lyrics" id="album_track_lyrics" ></textarea>
                                <p>Put Lyrics</p>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Buy MP3 URL</label></li>
                            <li class="to-field">
                            	<input type="text" name="album_track_buy_mp3" id="album_track_buy_mp3" value="" />
                                <p>Put mp3 url to buy</p>
                            </li>
                        </ul>
                        <ul class="form-elements noborder">
                            <li class="to-label"></li>
                            <li class="to-field"><input type="button" value="Add Track to List" onclick="add_track_to_list('<?php echo home_url()?>', '<?php echo get_template_directory_uri()?>')" /></li>
                        </ul>
                    </div>
                    <script>
						jQuery(document).ready(function($) {
							$("#total_tracks").sortable({
								cancel : 'td div.poped-up',
							});
						});
					</script>
                    <div class="opt-head">
                        <h4 style="padding-top:12px;">Album Tracks</h4>
                        <a href="javascript:openpopedup('add_track')" class="button">Add Track</a>
                        <div class="clear"></div>
                    </div>
                    <table class="to-table" border="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:80%;">Track Title</th>
                                <th style="width:80%;" class="centr">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="total_tracks">
                            <?php
								global $counter_track, $album_track_title, $album_track_mp3_url , $album_track_playable, $album_track_downloadable, $album_track_lyrics, $album_track_buy_mp3 ;
								$counter_track = $post->ID;
								if ( $cs_album <> "" ) {
									foreach ( $cs_xmlObject as $track ){
										if ( $track->getName() == "track" ) {
											$album_track_title = $track->album_track_title;
											$album_track_mp3_url = $track->album_track_mp3_url;
											$album_track_playable = $track->album_track_playable;
											$album_track_downloadable = $track->album_track_downloadable;
											$album_track_lyrics = $track->album_track_lyrics;
											$album_track_buy_mp3 = $track->album_track_buy_mp3;
											$counter_track++;
 											cs_add_track_to_list();
										}
									}
								}
							?>
                        </tbody>
                    </table>
                </div>
				<?php cs_meta_layout() ?>
                <input type="hidden" name="album_meta_form" value="1" />
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
<?php
		}

		if ( isset($_POST['album_meta_form']) and $_POST['album_meta_form'] == 1 ) {
			if ( empty($_POST['cs_layout']) ) $_POST['cs_layout'] = 'none';
			add_action( 'save_post', 'cs_meta_album_save' );  
			function cs_meta_album_save( $cs_post_id )
			{  
				$sxe = new SimpleXMLElement("<album></album>");
					if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
					if (empty($_POST["header_banner_options"])){ $_POST["header_banner_options"] = "";}
					if (empty($_POST["header_banner"])){ $_POST["header_banner"] = "";}
					if (empty($_POST["slider_id"])){ $_POST["slider_id"] = "";}
					if ( empty($_POST["album_release_date"]) ) $_POST["album_release_date"] = "";
					if ( empty($_POST["album_social_share"]) ) $_POST["album_social_share"] = "";
					if (empty($_POST["switch_footer_widgets"])){ $_POST["switch_footer_widgets"] = "";}
					if ( empty($_POST["cs_album_rating"]) ) $_POST["cs_album_rating"] = "";
					if ( empty($_POST["album_artist"]) ) $_POST["album_artist"] = "";
					if ( empty($_POST["album_buynow"]) ) $_POST["album_buynow"] = "";
						$sxe = save_layout_xml($sxe);
								$sxe->addChild('header_banner_options', $_POST['header_banner_options'] );
								$sxe->addChild('header_banner', $_POST['header_banner'] );
								$sxe->addChild('slider_id', $_POST['slider_id'] );
								$sxe->addChild('album_release_date', $_POST['album_release_date'] );
								$sxe->addChild('album_social_share', $_POST['album_social_share'] );
								$sxe->addChild('switch_footer_widgets', $_POST['switch_footer_widgets'] );
								$sxe->addChild('cs_album_rating', $_POST['cs_album_rating'] );
								$sxe->addChild('album_artist', $_POST['album_artist'] );
 								$sxe->addChild('album_buynow', htmlspecialchars($_POST['album_buynow']) );
							$counter = 0;
							if ( isset($_POST['album_track_title']) ) {
								foreach ( $_POST['album_track_title'] as $count ){
									$track = $sxe->addChild('track');
										$track->addChild('album_track_title', htmlspecialchars($_POST['album_track_title'][$counter]) );
										$track->addChild('album_track_mp3_url', htmlspecialchars($_POST['album_track_mp3_url'][$counter]) );
										$track->addChild('album_track_playable', $_POST['album_track_playable'][$counter] );
										$track->addChild('album_track_downloadable', $_POST['album_track_downloadable'][$counter] );
										$track->addChild('album_track_lyrics', htmlspecialchars($_POST['album_track_lyrics'][$counter]) );
										$track->addChild('album_track_buy_mp3', htmlspecialchars($_POST['album_track_buy_mp3'][$counter]) );
										$counter++;
								}
							}
				update_post_meta( $cs_post_id, 'cs_album', $sxe->asXML() );
				//update_post_meta( $cs_post_id, 'album_artist', $_POST["album_artist"] );
			}
		}
		// adding album meta info end
?>