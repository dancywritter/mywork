<?php
	//adding columns start
    add_filter('manage_albums_posts_columns', 'album_columns_add');
		function album_columns_add($columns) {
			$columns['category'] = 'Category';
			$columns['author'] = 'Author';
			return $columns;
    }
    add_action('manage_albums_posts_custom_column', 'albums_columns');
		function albums_columns($name) {
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
	function px_album_register() {
		
		$labels = array(
			'name' => 'Albums',
			'add_new_item' => 'Add New Album',
			'edit_item' => 'Edit Album',
			'new_item' => 'New Album Item',
			'add_new' => 'Add New Album',
			'view_item' => 'View Album Item',
			'search_items' => 'Search Album',
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
			'menu_icon' => 'dashicons-calendar',
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'has_archive' => true,
			'supports' => array('title','editor','thumbnail', 'excerpt', 'comments')
		); 
        register_post_type( 'albums' , $args );  
		
		
	}
	add_action('init', 'px_album_register');

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
		add_action( 'add_meta_boxes', 'px_meta_album_add' );
		function px_meta_album_add()
		{  
			add_meta_box( 'px_meta_album', 'Albums Options', 'px_meta_album', 'albums', 'normal', 'high' );  
		}
		function px_meta_album( $post ) {
			$px_album = get_post_meta($post->ID, "px_album", true);
			global $px_xmlObject;
			if ( $px_album <> "" ) {
				$px_xmlObject = new SimpleXMLElement($px_album);
					$var_pb_album_social_share_db = $px_xmlObject->var_pb_album_social_share;
					$var_pb_album_sub_title = $px_xmlObject->var_pb_album_sub_title;
					$var_pb_album_author = $px_xmlObject->var_pb_album_author;
					$album_release_date = $px_xmlObject->album_release_date;
					$album_buynow = $px_xmlObject->album_buynow;
 			}
			else {
				$var_pb_album_social_share_db = '';
				$album_release_date = '';
				$var_pb_album_author ='';
				$album_buynow = '';

 			}
?>	
			 <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery.scrollTo-min.js"></script>
             <link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/admin/bootstrap.min.css">
             <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/bootstrap-3.0.js"></script>
			<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/select.js"></script>
            <div class="page-wrap page-opts left event-meta-section" style="overflow:hidden; position:relative;">
           
                 <div class="option-sec" style="margin-bottom:0;">
                    <div class="opt-conts">
                    	<ul class="form-elements noborder">
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
                                <input type="text" id="album_release_date" name="album_release_date" value="<?php if ($album_release_date=="") echo gmdate("Y-m-d"); else echo $album_release_date?>" />
                                <p>Put album release date</p>
                            </li>
                        </ul>
                        <ul class="form-elements noborder">
                            <li class="to-label">
                                <label>Buy Now URL</label>
                            </li>
                        	<li class="to-field">
                            	<input type="text" name="album_buynow" value="<?php echo $album_buynow ?>" />
                            </li>
                       </ul>
                    	<ul class="form-elements  on-off-options">
                            <li class="to-label"><label>Social Sharing</label></li>
                            <li class="to-field">
                                <label class="cs-on-off">
                                	<input type="checkbox" name="var_pb_album_social_share" value="on" class="myClass" <?php if($var_pb_album_social_share_db=='on')echo "checked"?> />
                                	<span></span>
                                </label>
                            </li>

                            <li class="to-label"><label>Author Description</label></li>
                            <li class="to-field">
                                <label class="cs-on-off">
                                    <input type="checkbox" name="var_pb_album_author" value="on" class="myClass" <?php if($var_pb_album_author=='on')echo "checked"?> />
                                    <span></span>
                                </label>
                            </li>
                        </ul>
                        <?php meta_layout()?> 
                    </div>
                    
					<div class="clear"></div>
                    
                </div>
                <div class="opt-head">
                    <h4 style="padding-top:12px;">Album Tracks</h4>
                    <a href="javascript:openpopedup('add_track')" class="button">Add Album</a>
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
                            <li class="to-label"><label>Album Title</label></li>
                            <li class="to-field">
                            	<input type="text" id="var_pb_album_track_title" name="var_pb_album_track_title" value="Album Title" />
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Album Speaker</label></li>
                            <li class="to-field">
                            	<input type="text" id="var_pb_album_speaker" name="var_pb_album_speaker" value="" />
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Album MP3 URL</label></li>
                            <li class="to-field">
								<input id="var_pb_album_track_mp3_url" name="var_pb_album_track_mp3_url" value="" type="text" class="small" />
								<input id="var_pb_album_track_mp3_url" name="var_pb_album_track_mp3_url" type="button" class="uploadfile left" value="Browse"/>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Buy MP3 URL</label></li>
                            <li class="to-field">
                            	<input type="text" name="var_pb_album_track_buy_mp3" id="var_pb_album_track_buy_mp3" value="" />
                            </li>
                        </ul>
                        <ul class="form-elements noborder">
                            <li class="to-label"></li>
                            <li class="to-field"><input type="button" value="Add Album to List" onclick="add_track_to_list('<?php echo home_url()?>', '<?php echo get_template_directory_uri()?>')" /></li>
                        </ul>
                       
                    </div>
                    <script>
						jQuery(document).ready(function($) {
							$("#total_tracks").sortable({
								cancel : 'td div.poped-up',
							});
						});
					</script>
                    
 
                    <table class="to-table px-album-table" border="0" cellspacing="0" <?php if($px_album <> "" && !isset($px_xmlObject) && count($px_xmlObject->track)<1){?>style="<?php echo 'display: none';?>" <?php }?>>
                        <thead>
                            <tr>
                                <th style="width:80%;">Album Title</th>
                                <th style="width:80%;" class="centr">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="total_tracks">
                            <?php
								global $counter_track, $var_pb_album_track_title, $var_pb_album_speaker, $var_pb_album_track_mp3_url, $var_pb_album_track_buy_mp3 ;
								$counter_track = $post->ID;
								if ( $px_album <> "" ) {
									foreach ( $px_xmlObject as $track ){
										if ( $track->getName() == "track" ) {
											$var_pb_album_track_title = $track->var_pb_album_track_title;
											$var_pb_album_speaker = $track->var_pb_album_speaker;
											$var_pb_album_track_mp3_url = $track->var_pb_album_track_mp3_url;
											$var_pb_album_track_buy_mp3 = $track->var_pb_album_track_buy_mp3;
											$counter_track++;
 											px_add_album_to_list();
										}
									}
								}
							?>
                        </tbody>
                    </table>
                </div>
                
                <input type="hidden" name="var_pb_album_meta_form" value="1" />
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
<?php
		}

		if ( isset($_POST['var_pb_album_meta_form']) and $_POST['var_pb_album_meta_form'] == 1 ) {
			if ( empty($_POST['px_layout']) ) $_POST['px_layout'] = 'none';
			add_action( 'save_post', 'px_meta_album_save' );  
			function px_meta_album_save( $px_post_id )
			{  
				$sxe = new SimpleXMLElement("<album></album>");
					if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
					if ( empty($_POST["album_release_date"]) ) $_POST["album_release_date"] = "";
					if ( empty($_POST["album_buynow"]) ) $_POST["album_buynow"] = "";
					if ( empty($_POST["var_pb_album_social_share"]) ) $_POST["var_pb_album_social_share"] = "";
					if ( empty($_POST["var_pb_album_author"]) ) $_POST["var_pb_album_author"] = "";
						$sxe = save_layout_xml($sxe);
							$sxe->addChild('album_release_date', $_POST['album_release_date'] );
							$sxe->addChild('album_buynow', $_POST['album_buynow'] );
							$sxe->addChild('var_pb_album_social_share', $_POST['var_pb_album_social_share'] );
							$sxe->addChild('var_pb_album_author', $_POST['var_pb_album_author'] );
							$counter = 0;
							if ( isset($_POST['var_pb_album_track_title']) ) {
								if(is_array($_POST['var_pb_album_track_title'])){
									foreach ( $_POST['var_pb_album_track_title'] as $count ){
										$track = $sxe->addChild('track');
											$track->addChild('var_pb_album_track_title', htmlspecialchars($_POST['var_pb_album_track_title'][$counter]) );
											$track->addChild('var_pb_album_speaker', htmlspecialchars($_POST['var_pb_album_speaker'][$counter]) );
											$track->addChild('var_pb_album_track_mp3_url', htmlspecialchars($_POST['var_pb_album_track_mp3_url'][$counter]) );
											$track->addChild('var_pb_album_track_buy_mp3', htmlspecialchars($_POST['var_pb_album_track_buy_mp3'][$counter]) );
											$counter++;
									}
								}
							}
				update_post_meta( $px_post_id, 'px_album', $sxe->asXML() );
			}
		}
		// adding album meta info end
?>