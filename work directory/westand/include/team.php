<?php
		//adding columns start
		add_filter('manage_team_posts_columns', 'team_columns_add');
			function team_columns_add($columns) {
				$columns['category'] = 'Category';
				$columns['author'] = 'Author';
				return $columns;
		}
		add_action('manage_team_posts_custom_column', 'team_columns');
			function team_columns($name) {
				global $post;
				switch ($name) {
					case 'category':
						$categories = get_the_terms( $post->ID, 'team-category' );
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
	
		function cs_team_register() {
			// adding Team start
			$labels = array(
				'name' => 'Team',
				'all_items' => 'All Team Members',
				'add_new_item' => 'Add New Member',
				'edit_item' => 'Edit Member',
				'new_item' => 'New Member',
				'add_new' => 'Add New Member',
				'view_item' => 'View Member',
				'search_items' => 'Search Member',
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
				'menu_icon' => 'dashicons-admin-post',
				//'show_in_menu' => 'edit.php?post_type=albums',
				'show_in_nav_menus'=>true,
				'rewrite' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => null,
				'supports' => array('title', 'thumbnail', 'editor')
			); 
			register_post_type( 'teams' , $args );  
		}
			// adding Team end
		add_action('init', 'cs_team_register');
		
		
		  	function cs_team_categories() 
			{
				  $labels = array(
					'name' => 'Team Categories',
					'search_items' => 'Search Team Categories',
					'edit_item' => 'Edit Team Category',
					'update_item' => 'Update Team Category',
					'add_new_item' => 'Add New Category',
					'menu_name' => 'Team Categories',
				  ); 	
				  register_taxonomy('team-category',array('teams'), array(
					'hierarchical' => true,
					'labels' => $labels,
					'show_ui' => true,
					'query_var' => true,
					'rewrite' => array( 'slug' => 'team-category' ),
				  ));
			}
			add_action( 'init', 'cs_team_categories');
		// adding tag end
		// adding Team meta info start
		add_action( 'add_meta_boxes', 'cs_meta_team_add' );
		function cs_meta_team_add()
		{  
			add_meta_box( 'cs_meta_team', 'Team Options', 'cs_meta_team', 'teams', 'normal', 'high' );  
		}
		function cs_meta_team( $post ) {
			$cs_team = get_post_meta($post->ID, "cs_team", true);
			global $cs_xmlObject;
			if ( $cs_team <> "" ) {
				$cs_xmlObject = new SimpleXMLElement($cs_team);
					$var_cp_expertise = $cs_xmlObject->var_cp_expertise;
					$var_cp_email = $cs_xmlObject->var_cp_email;
					$facebook = $cs_xmlObject->facebook;
					$twitter = $cs_xmlObject->twitter;
					$linkedin = $cs_xmlObject->linkedin;
					$google_plus = $cs_xmlObject->google_plus;
					$team_social_sharing = $cs_xmlObject->team_social_sharing;
 			}
			else {
				$var_cp_expertise ='';
				$var_cp_about = '';
				$var_cp_email = '';
				$facebook = '';
				$twitter = '';
				$linkedin = '';
				$google_plus = '';
				$team_social_sharing = 'on';
 			}
		?>
            <div class="page-wrap page-opts left" style="overflow:hidden; position:relative;">
            	<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery.scrollTo-min.js"></script>
				<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/select.js"></script>
                <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/prettyCheckable.js"></script>
                <div class="option-sec" style="margin-bottom:0;">
                	<?php subheader_meta_layout();?>
                    <div class="opt-conts">
                    	<div class="clear"></div>
                    	<div class="theme-help">
                            <h4 style="padding-bottom:0px;">About</h4>
                            <div class="clear"></div>
                        </div>
				        <ul class="form-elements noborder">
                            <li class="to-label"><label>Expertise</label></li>
                            <li class="to-field">
                                <input type="text" name="var_cp_expertise" value="<?php echo htmlspecialchars($var_cp_expertise)?>"/>
                            </li>
                        </ul>
                        
                        <ul class="form-elements noborder">
                            <li class="to-label"><label>Email</label></li>
                            <li class="to-field">
                                <input type="text" name="var_cp_email" value="<?php echo htmlspecialchars($var_cp_email)?>"/>
                            </li>
                        </ul>
                       
                    
                    </div>
					<div class="clear"></div>
                </div>
                <div class="boxes tracklists">
                	<div id="add_track" class="poped-up">
                        <div class="opt-head">
                            <h5>Peronal Information</h5>
                            <a href="javascript:closepopedup('add_track')" class="closeit">&nbsp;</a>
                            <div class="clear"></div>
                        </div>
                        <ul class="form-elements">
                            <li class="to-label"><label>Title</label></li>
                            <li class="to-field">
                            	<input type="text" id="var_cp_title" name="var_cp_title" value="Title" />
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>FontAwsome Icon</label></li>
                            <li class="to-field">
								<input id="var_cp_image_url" name="var_cp_image_url" value="" type="text" class="small" />
								<input id="var_cp_image_url" name="var_cp_image_url" type="button" class="uploadfile left" value="Browse"/>
                                <p>Put Fontsome Icon. You can get fontawsome icons from <a href="http://fortawesome.github.io/Font-Awesome/icons/">here</a></p>
                            </li>
                        </ul>
                        
                        
                        <ul class="form-elements">
                            <li class="to-label"><label>Text</label></li>
                            <li class="to-field">
                            	<textarea name="var_cp_team_text" rows="5" cols="20"></textarea>
                            </li>
                        </ul>
                        
                        <ul class="form-elements noborder">
                            <li class="to-label"></li>
                            <li class="to-field"><input type="button" value="Add Personal Information to List" onclick="add_social_to_list('<?php echo home_url()?>', '<?php echo get_template_directory_uri()?>')" /></li>
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
                        <h4 style="padding-top:12px;">Peronal Information listings</h4>
                        <a href="javascript:openpopedup('add_track')" class="button">Add Peronal Information</a>
                        <div class="clear"></div>
                    </div>
                    <table class="to-table" border="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:80%;">Title</th>
                                <th style="width:80%;" class="centr">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="total_tracks">
                            <?php
								global $counter_social, $var_cp_title, $var_cp_image_url , $var_cp_team_text;
								$counter_social = $post->ID;
								if ( $cs_team <> "" ) {
									foreach ( $cs_xmlObject as $social ){
										if ( $social->getName() == "social" ) {
											$var_cp_title = $social->var_cp_title;
											$var_cp_image_url = $social->var_cp_image_url;
											$var_cp_team_text = $social->var_cp_team_text;
											$counter_social++;
 											cs_add_social_to_list();
										}
									}
								}
							?>
                        </tbody>
                    </table>
                </div>
                	<div class="clear"></div>
                 		<div class="theme-help">
                          <h4 style="padding-bottom:0px;">Social Links</h4>
                          <div class="clear"></div>
                        </div>
                        <ul class="form-elements noborder">
                            <li class="to-label"><label>Facebook URL</label></li>
                            <li class="to-field">
                            	<input type="text" name="facebook" value="<?php if ( isset($facebook) ) echo $facebook ?>" />
                               
                            </li>
                        </ul>
                        <ul class="form-elements noborder">
                            <li class="to-label"><label>Twitter URL</label></li>
                            <li class="to-field">
                            	<input type="text" name="twitter" value="<?php if ( isset($twitter) ) echo $twitter ?>" />
                               
                            </li>
                        </ul>
                        <ul class="form-elements noborder">
                            <li class="to-label"><label>Google Plus</label></li>
                            <li class="to-field">
                            	<input type="text" name="google_plus" value="<?php if ( isset($google_plus) ) echo $google_plus ?>" />
                               
                            </li>
                        </ul>
                        <ul class="form-elements noborder">
                            <li class="to-label"><label>linkedin URL</label></li>
                            <li class="to-field">
                            	<input type="text" name="linkedin" value="<?php if ( isset($linkedin) ) echo $linkedin ?>" />
                               
                            </li>
                        </ul>
                        <div class="opt-head">
                          <h4>Other Option</h4>
                          <div class="clear"></div>
                        </div>
                        <ul class="form-elements">
                            <li class="to-label"><label>Social Sharing</label></li>
                            <li class="to-field">
                                <div class="on-off"><input type="checkbox" name="team_social_sharing" value="on" class="myClass" <?php if($team_social_sharing=='on')echo "checked"?> /></div>
                           
                            </li>
                        </ul>
				<?php meta_layout() ?>
                <input type="hidden" name="team_meta_form" value="1" />
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
	<?php
		}
		if ( isset($_POST['team_meta_form']) and $_POST['team_meta_form'] == 1 ) {
			if ( empty($_POST['cs_layout']) ) $_POST['cs_layout'] = 'none';
			add_action( 'save_post', 'cs_meta_team_save' );  
			function cs_meta_team_save( $cs_post_id )
			{  
				$sxe = new SimpleXMLElement("<team></team>");
					if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
					if (empty($_POST["var_cp_expertise"])){ $_POST["var_cp_expertise"] = "";}
					if (empty($_POST["var_cp_email"])){ $_POST["var_cp_email"] = "";}
					if (empty($_POST["facebook"])){ $_POST["facebook"] = "";}
					if (empty($_POST["twitter"])){ $_POST["twitter"] = "";}
					if (empty($_POST["linkedin"])){ $_POST["linkedin"] = "";}
					if (empty($_POST["google_plus"])){ $_POST["google_plus"] = "";}
					if (empty($_POST["team_social_sharing"])){ $_POST["team_social_sharing"] = "";}
					
						$sxe = save_layout_xml($sxe);
						$sxe->addChild('var_cp_expertise', $_POST['var_cp_expertise'] );
						$sxe->addChild('var_cp_email', $_POST['var_cp_email'] );
						$sxe->addChild('facebook', $_POST['facebook'] );
						$sxe->addChild('twitter', $_POST['twitter'] );
						$sxe->addChild('linkedin', $_POST['linkedin'] );
						$sxe->addChild('google_plus', $_POST['google_plus'] );
						$sxe->addChild('team_social_sharing', $_POST['team_social_sharing'] );
						$counter = 0;
						if ( isset($_POST['var_cp_title']) ) {
							foreach ( $_POST['var_cp_title'] as $count ){
								$track = $sxe->addChild('social');
									$track->addChild('var_cp_title', htmlspecialchars($_POST['var_cp_title'][$counter]) );
									$track->addChild('var_cp_image_url', htmlspecialchars($_POST['var_cp_image_url'][$counter]) );
									$track->addChild('var_cp_team_text', $_POST['var_cp_team_text'][$counter] );
									$counter++;
							}
						}
				update_post_meta( $cs_post_id, 'cs_team', $sxe->asXML() );
			}
		}
		// adding Team meta info end
	?>