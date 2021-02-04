<?php
	//adding columns start
    add_filter('manage_pointtables_posts_columns', 'pointtable_columns_add');
		function pointtable_columns_add($columns) {
			$columns['category'] = 'Category';
			$columns['author'] = 'Author';
			return $columns;
    }
    add_action('manage_pointtables_posts_custom_column', 'pointtables_columns');
		function pointtables_columns($name) {
			global $post;
			switch ($name) {
				case 'category':
					$categories = get_the_terms( $post->ID, 'season-category' );
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
	function px_pointtable_register() {
		$labels = array(
			'name' => 'Point Tables',
			'add_new_item' => 'Add New Table',
			'edit_item' => 'Edit Table',
			'new_item' => 'New Table Item',
			'add_new' => 'Add New Table',
			'view_item' => 'View Table Item',
			'search_items' => 'Search Table',
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
			'supports' => array('title')
		); 
        register_post_type( 'pointtable' , $args );
	}
	add_action('init', 'px_pointtable_register');

		// adding cat start
		  $labels = array(
			'name' => 'Season Categories',
			'search_items' => 'Search Season Categories',
			'edit_item' => 'Edit Season Category',
			'update_item' => 'Update Season Category',
			'add_new_item' => 'Add New Category',
			'menu_name' => 'Season Categories',
		  ); 	
		  register_taxonomy('season-category',array('pointtable'), array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'season-category' ),
		  ));
		// adding cat end
		
	// adding point table meta info start
		add_action( 'add_meta_boxes', 'px_meta_pointtable_add' );
		function px_meta_pointtable_add()
		{  
			add_meta_box( 'px_meta_pointtable', 'Point Tables Options', 'px_meta_pointtable', 'pointtable', 'normal', 'high' );  
		}
		function px_meta_pointtable( $post ) {
			$px_pointtable = get_post_meta($post->ID, "px_pointtable", true);
			global $px_xmlObject;
			if ( $px_pointtable <> "" ) {
				$px_xmlObject = new SimpleXMLElement($px_pointtable);
				$var_pb_record_per_post=$px_xmlObject->var_pb_record_per_post;
				$var_pb_pointtable_viewall = $px_xmlObject->var_pb_pointtable_viewall;
    		}else {
   				$var_pb_record_per_post ='';
				$var_pb_pointtable_viewall ='';
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
                             <li class="to-field">
                            	<input type="text" id="var_pb_record_per_post" name="var_pb_record_per_post" value="<?php echo $var_pb_record_per_post;?>" />
                                <p>Record Per Post</p>
                            </li>
                            
                            <li class="to-field">
                            	<input type="text" id="var_pb_pointtable_viewall" name="var_pb_pointtable_viewall" value="<?php echo $var_pb_pointtable_viewall;?>" />
                                <p><label>View All URL</label></p>
                            </li>
                        </ul>
                     </div>
                    
					<div class="clear"></div>
                    
                </div>
                  <div class="opt-head">
                        <h4 style="padding-top:12px;">Point Tables</h4>
                        <a href="javascript:openpopedup('add_track')" class="button">Add Table</a>
                        <div class="clear"></div>
                    </div>
                <div class="boxes tracklists">
                	<div id="add_track" class="poped-up">
                        <div class="opt-head">
                            <h5>Point Table Settings</h5>
                            <a href="javascript:closepopedup('add_track')" class="closeit">&nbsp;</a>
                            <div class="clear"></div>
                        </div>
                        <ul class="form-elements">
                            <li class="to-label"><label>Team Name</label></li>
                            <li class="to-field">
                            	<select name="var_pb_pointtable_team" id="var_pb_pointtable_team" class="dropdown">
                        			<option>-- Select Team--</option>
                            		<?php show_all_cats('', '', $var_pb_pointtable_team, "team-category");?>
                        		</select>
                             </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Match Played</label></li>
                            <li class="to-field">
                            	<input type="text" id="var_pb_match_played" name="var_pb_match_played" value="" />
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Plus/Minus Points</label></li>
                            <li class="to-field">
								<input id="var_pb_pointtable_plusminus_points" name="var_pb_pointtable_plusminus_points" value="" type="text" class="small" />
                             </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Total Points</label></li>
                            <li class="to-field">
                            	<input type="text" name="var_pb_pointtable_totalpoints" id="var_pb_pointtable_totalpoints" value="" />
                            </li>
                        </ul>
                        <ul class="form-elements noborder">
                            <li class="to-label"></li>
                            <li class="to-field"><input type="button" value="Add Table to List" onclick="add_track_to_list('<?php echo home_url()?>', '<?php echo get_template_directory_uri()?>')" /></li>
                        </ul>
                       
                    </div>
                    <script>
						jQuery(document).ready(function($) {
							$("#total_tracks").sortable({
								cancel : 'td div.poped-up',
							});
						});
					</script>
                    
 
                    <table class="to-table px-sermon-table px-pointable" border="0" cellspacing="0" <?php if($px_pointtable <> "" && !isset($px_xmlObject) && count($px_xmlObject->track)<1){?>style="<?php echo 'display: none';?>" <?php }?>>
                        <thead>
                            <tr>
                                <th style="width:80%;">Team</th>
                                <th style="width:80%;" class="centr">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="total_tracks">
                            <?php
								global $counter_track, $var_pb_pointtable_team, $var_pb_match_played, $var_pb_pointtable_plusminus_points, $var_pb_pointtable_totalpoints ;
								$counter_track = $post->ID;
								if ( $px_pointtable <> "" ) {
									foreach ( $px_xmlObject as $track ){
										if ( $track->getName() == "track" ) {
											$var_pb_pointtable_team = $track->var_pb_pointtable_team;
											$var_pb_match_played = $track->var_pb_match_played;
											$var_pb_pointtable_plusminus_points = $track->var_pb_pointtable_plusminus_points;
											$var_pb_pointtable_totalpoints = $track->var_pb_pointtable_totalpoints;
											$counter_track++;
 											px_add_pointtable_to_list();
										}
									}
								}
							?>
                        </tbody>
                    </table>
                </div>
                <div class="option-sec" style="margin-bottom:0;">
                    <div class="opt-conts">
                        <?php meta_layout()?> 
                    </div>
                    
					<div class="clear"></div>
                    
                </div>
                <input type="hidden" name="var_pb_pointtable_meta_form" value="1" />
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
<?php
		}

		if ( isset($_POST['var_pb_pointtable_meta_form']) and $_POST['var_pb_pointtable_meta_form'] == 1 ) {
			if ( empty($_POST['px_layout']) ) $_POST['px_layout'] = 'none';
			add_action( 'save_post', 'px_meta_pointtable_save' );  
			function px_meta_pointtable_save( $px_post_id )
			{  
				$sxe = new SimpleXMLElement("<pointtable></pointtable>");
					if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
 						if ( empty($_POST["var_pb_record_per_post"]) ) $_POST["var_pb_record_per_post"] = "";
						if ( empty($_POST["var_pb_pointtable_viewall"]) ) $_POST["var_pb_pointtable_viewall"] = "";
						$sxe = save_layout_xml($sxe);
							$sxe->addChild('var_pb_record_per_post', $_POST['var_pb_record_per_post'] );
							$sxe->addChild('var_pb_pointtable_viewall', $_POST['var_pb_pointtable_viewall'] );
 							$counter = 0;
							if ( isset($_POST['var_pb_pointtable_team']) ) {
								if(is_array($_POST['var_pb_pointtable_team'])){
									foreach ( $_POST['var_pb_pointtable_team'] as $count ){
										$track = $sxe->addChild('track');
											$track->addChild('var_pb_pointtable_team', htmlspecialchars($_POST['var_pb_pointtable_team'][$counter]) );
											$track->addChild('var_pb_match_played', htmlspecialchars($_POST['var_pb_match_played'][$counter]) );
											$track->addChild('var_pb_pointtable_plusminus_points', htmlspecialchars($_POST['var_pb_pointtable_plusminus_points'][$counter]) );
  											$track->addChild('var_pb_pointtable_totalpoints', htmlspecialchars($_POST['var_pb_pointtable_totalpoints'][$counter]) );
											$counter++;
									}
								}
							}
				update_post_meta( $px_post_id, 'px_pointtable', $sxe->asXML() );
			}
		}
		// adding poin table meta info end
?>