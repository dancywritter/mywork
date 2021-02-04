<?php
	//adding columns start
    add_filter('manage_sermons_posts_columns', 'sermon_columns_add');
		function sermon_columns_add($columns) {
			$columns['category'] = 'Category';
			$columns['author'] = 'Author';
			return $columns;
    }
    add_action('manage_sermons_posts_custom_column', 'sermons_columns');
		function sermons_columns($name) {
			global $post;
			switch ($name) {
				case 'category':
					$categories = get_the_terms( $post->ID, 'sermon-category' );
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
	function px_sermon_register() {
		$labels = array(
			'name' => 'Sermons',
			'add_new_item' => 'Add New Sermon',
			'edit_item' => 'Edit Sermon',
			'new_item' => 'New Sermon Item',
			'add_new' => 'Add New Sermon',
			'view_item' => 'View Sermon Item',
			'search_items' => 'Search Sermon',
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
			'menu_icon' => 'dashicons-admin-media',
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title','editor','thumbnail', 'comments' )
		); 
        register_post_type( 'sermons' , $args );
	}
	add_action('init', 'px_sermon_register');

		// adding cat start
		  $labels = array(
			'name' => 'Sermon Categories',
			'search_items' => 'Search Sermon Categories',
			'edit_item' => 'Edit Sermon Category',
			'update_item' => 'Update Sermon Category',
			'add_new_item' => 'Add New Category',
			'menu_name' => 'Sermon Categories',
		  ); 	
		  register_taxonomy('sermon-category',array('sermons'), array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'sermon-category' ),
		  ));
		// adding cat end
		// adding tag start
		  $labels = array(
			'name' => 'Sermon Tags',
			'singular_name' => 'sermon-tag',
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
			'menu_name' => 'Sermon Tags',
		  ); 
		  register_taxonomy('sermon-tag','sermons',array(
			'hierarchical' => false,
			'labels' => $labels,
			'show_ui' => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var' => true,
			'rewrite' => array( 'slug' => 'sermon-tag' ),
		  ));
		// adding tag end

	// adding sermon meta info start
		add_action( 'add_meta_boxes', 'px_meta_sermon_add' );
		function px_meta_sermon_add()
		{  
			add_meta_box( 'px_meta_sermon', 'Sermons Options', 'px_meta_sermon', 'sermons', 'normal', 'high' );  
		}
		function px_meta_sermon( $post ) {
			$px_sermon = get_post_meta($post->ID, "px_sermon", true);
			global $px_xmlObject;
			if ( $px_sermon <> "" ) {
				$px_xmlObject = new SimpleXMLElement($px_sermon);
					$sub_title = $px_xmlObject->sub_title;
					$small_desc = $px_xmlObject->small_desc;
					$var_pb_sermon_social_share_db = $px_xmlObject->var_pb_sermon_social_share;
					$var_pb_sermon_sub_title = $px_xmlObject->var_pb_sermon_sub_title;
					$var_pb_sermon_author = $px_xmlObject->var_pb_sermon_author;
 			}
			else {
				$sub_title = '';
				$small_desc = '';
				$var_pb_sermon_social_share_db = '';
				$var_pb_sermon_author ='';

 			}
?>	
			 <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery.scrollTo-min.js"></script>
             <link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/admin/bootstrap.min.css">
             <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/bootstrap-3.0.js"></script>
			<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/select.js"></script>
            <div class="page-wrap page-opts left event-meta-section" style="overflow:hidden; position:relative;">
           
                 <div class="option-sec" style="margin-bottom:0;">
                    <div class="opt-conts">
                    	
                        <ul class="form-elements">
                            <li class="to-label"><label>Sermon Small Description</label></li>
                            <li class="to-field">
                            	<textarea id="small_desc" name="small_desc"><?php echo $small_desc;?></textarea>
                            </li>
                        </ul>
                    	<ul class="form-elements  on-off-options">
                            <li class="to-label"><label>Social Sharing</label></li>
                            <li class="to-field">
                                <label class="cs-on-off">
                                	<input type="checkbox" name="var_pb_sermon_social_share" value="on" class="myClass" <?php if($var_pb_sermon_social_share_db=='on')echo "checked"?> />
                                	<span></span>
                                </label>
                            </li>

                            <li class="to-label"><label>Author Description</label></li>
                            <li class="to-field">
                                <label class="cs-on-off">
                                    <input type="checkbox" name="var_pb_sermon_author" value="on" class="myClass" <?php if($var_pb_sermon_author=='on')echo "checked"?> />
                                    <span></span>
                                </label>
                            </li>
                        </ul>
                        <?php meta_layout()?> 
                    </div>
                    
					<div class="clear"></div>
                    
                </div>
                <div class="opt-head">
                        <h4 style="padding-top:12px;">Sermon Tracks</h4>
                        <a href="javascript:openpopedup('add_track')" class="button">Add Sermon</a>
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
                            <li class="to-label"><label>Sermon Title</label></li>
                            <li class="to-field">
                            	<input type="text" id="var_pb_sermon_track_title" name="var_pb_sermon_track_title" value="Sermon Title" />
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Sermon Speaker</label></li>
                            <li class="to-field">
                            	<input type="text" id="var_pb_sermon_speaker" name="var_pb_sermon_speaker" value="" />
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Sermon MP3 URL</label></li>
                            <li class="to-field">
								<input id="var_pb_sermon_track_mp3_url" name="var_pb_sermon_track_mp3_url" value="" type="text" class="small" />
								<input id="var_pb_sermon_track_mp3_url" name="var_pb_sermon_track_mp3_url" type="button" class="uploadfile left" value="Browse"/>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Buy MP3 URL</label></li>
                            <li class="to-field">
                            	<input type="text" name="var_pb_sermon_track_buy_mp3" id="var_pb_sermon_track_buy_mp3" value="" />
                            </li>
                        </ul>
                        <ul class="form-elements noborder">
                            <li class="to-label"></li>
                            <li class="to-field"><input type="button" value="Add Sermon to List" onclick="add_track_to_list('<?php echo home_url()?>', '<?php echo get_template_directory_uri()?>')" /></li>
                        </ul>
                       
                    </div>
                    <script>
						jQuery(document).ready(function($) {
							$("#total_tracks").sortable({
								cancel : 'td div.poped-up',
							});
						});
					</script>
                    
 
                    <table class="to-table px-sermon-table" border="0" cellspacing="0" <?php if($px_sermon <> "" && !isset($px_xmlObject) && count($px_xmlObject->track)<1){?>style="<?php echo 'display: none';?>" <?php }?>>
                        <thead>
                            <tr>
                                <th style="width:80%;">Sermon Title</th>
                                <th style="width:80%;" class="centr">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="total_tracks">
                            <?php
								global $counter_track, $var_pb_sermon_track_title, $var_pb_sermon_speaker, $var_pb_sermon_track_mp3_url, $var_pb_sermon_track_buy_mp3 ;
								$counter_track = $post->ID;
								if ( $px_sermon <> "" ) {
									foreach ( $px_xmlObject as $track ){
										if ( $track->getName() == "track" ) {
											$var_pb_sermon_track_title = $track->var_pb_sermon_track_title;
											$var_pb_sermon_speaker = $track->var_pb_sermon_speaker;
											$var_pb_sermon_track_mp3_url = $track->var_pb_sermon_track_mp3_url;
											$var_pb_sermon_track_buy_mp3 = $track->var_pb_sermon_track_buy_mp3;
											$counter_track++;
 											px_add_sermon_to_list();
										}
									}
								}
							?>
                        </tbody>
                    </table>
                </div>
                
                <input type="hidden" name="var_pb_sermon_meta_form" value="1" />
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
<?php
		}

		if ( isset($_POST['var_pb_sermon_meta_form']) and $_POST['var_pb_sermon_meta_form'] == 1 ) {
			if ( empty($_POST['px_layout']) ) $_POST['px_layout'] = 'none';
			add_action( 'save_post', 'px_meta_sermon_save' );  
			function px_meta_sermon_save( $px_post_id )
			{  
				$sxe = new SimpleXMLElement("<sermon></sermon>");
					if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
					if ( empty($_POST["small_desc"]) ) $_POST["small_desc"] = "";
					if ( empty($_POST["var_pb_sermon_social_share"]) ) $_POST["var_pb_sermon_social_share"] = "";
					if ( empty($_POST["var_pb_sermon_author"]) ) $_POST["var_pb_sermon_author"] = "";
						$sxe = save_layout_xml($sxe);
								$sxe->addChild('small_desc', $_POST['small_desc'] );
								$sxe->addChild('var_pb_sermon_social_share', $_POST['var_pb_sermon_social_share'] );
								$sxe->addChild('var_pb_sermon_author', $_POST['var_pb_sermon_author'] );
							$counter = 0;
							if ( isset($_POST['var_pb_sermon_track_title']) ) {
								if(is_array($_POST['var_pb_sermon_track_title'])){
									foreach ( $_POST['var_pb_sermon_track_title'] as $count ){
										$track = $sxe->addChild('track');
											$track->addChild('var_pb_sermon_track_title', htmlspecialchars($_POST['var_pb_sermon_track_title'][$counter]) );
											$track->addChild('var_pb_sermon_speaker', htmlspecialchars($_POST['var_pb_sermon_speaker'][$counter]) );
											$track->addChild('var_pb_sermon_track_mp3_url', htmlspecialchars($_POST['var_pb_sermon_track_mp3_url'][$counter]) );
											$track->addChild('var_pb_sermon_track_playable', $_POST['var_pb_sermon_track_playable'][$counter] );
											$track->addChild('var_pb_sermon_track_downloadable', $_POST['var_pb_sermon_track_downloadable'][$counter] );
											$track->addChild('var_pb_sermon_track_buy_mp3', htmlspecialchars($_POST['var_pb_sermon_track_buy_mp3'][$counter]) );
											$counter++;
									}
								}
							}
				update_post_meta( $px_post_id, 'px_sermon', $sxe->asXML() );
			}
		}
		// adding sermon meta info end
?>