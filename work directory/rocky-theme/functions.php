<?php
// tgm class for (internal and WordPress repository) plugin activation start
require_once dirname( __FILE__ ) . '/include/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'cs_register_required_plugins' );
function cs_register_required_plugins() {
	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		// This is an example of how to include a plugin pre-packaged with a theme
		 array(
			'name'     				=> 'Revolution Slider', // The plugin name
			'slug'     				=> 'revslider', // The plugin slug (typically the folder name)
			'source'   				=> get_stylesheet_directory() . '/include/plugins/revslider.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		// This is an example of how to include a plugin from the WordPress Plugin Repository
		array(
			'name' 		=> 'MailChimp Widget',
			'slug' 		=> 'mailchimp-widget',
			'required' 	=> false,
		),

	);
	// Change this to your theme text domain, used for internationalising strings
	$theme_text_domain = 'Rocky';
	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       		=> $theme_text_domain,         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', $theme_text_domain ),
			'menu_title'                       			=> __( 'Install Plugins', $theme_text_domain ),
			'installing'                       			=> __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', $theme_text_domain ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', $theme_text_domain ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', $theme_text_domain ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', $theme_text_domain ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);
	tgmpa( $plugins, $config );
}
// tgm class for (internal and WordPress repository) plugin activation end

// add short code in widget area
add_filter('widget_text', 'do_shortcode'); 

//Get user current role
function cs_get_user_role() {
	global $current_user;
	$user_roles = $current_user->roles;
	$user_role = array_shift($user_roles);
	return $user_role;
}

// Get date differance
function cs_dateDiff($start, $end) {
	  $start_ts = strtotime($start);
	  $end_ts = strtotime($end);
	  $diff = $end_ts - $start_ts;
	  return round($diff / 86400);
}

// Generate Random string
function cs_generate_random_string($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}	

// Add Social icons	
function cs_add_social_icon(){
    $template_path = get_template_directory_uri() . '/scripts/admin/media_upload.js';
    wp_enqueue_script('my-upload2', $template_path, array('jquery', 'media-upload', 'thickbox', 'jquery-ui-droppable', 'jquery-ui-datepicker', 'jquery-ui-slider', 'wp-color-picker'));

	//echo '<tr id="del_' .$_POST['counter_social_network'].'"> 
		echo '<tr id="del_' .$_POST['counter_social_network'].'"> ';
								if(isset($_POST['social_net_awesome']) && $_POST['social_net_awesome'] <> ''){
									echo '<td><i style="color: green;" class="fa '.$_POST['social_net_awesome'].' fa-2x"></td>';
								} else {
									echo '<td><img width="50" src="'.$_POST['social_net_icon_path'].'"></td>';
								}
		//echo '<td><img width="50" src="' .$_POST['social_net_icon_path']. '"></td> 
		echo '<td>' .$_POST['social_net_url']. '</td> 
		<td class="centr"> 
			<a onclick="javascript:return confirm(\'Are you sure! You want to delete this\')" href="javascript:social_icon_del('.$_POST['counter_social_network'].')">Del</a> 
			| <a href="javascript:cs_toggle('.$_POST['counter_social_network'].')">Edit</a>
		</td> 
	</tr> 
	<tr id="'.$_POST['counter_social_network'].'" style="display:none"> 
		<td colspan="3"> 
			<ul class="form-elements">
				<li class="to-label"><label>Icon Path</label></li>
				<li class="to-field">
				  <input id="social_net_icon_path'.$_POST['counter_social_network'].'" name="social_net_icon_path[]" value="'.$_POST['social_net_icon_path'].'" type="text" class="small" /> 
				</li>
				<li><a onclick="cs_toggle('. $_POST['counter_social_network'] .')"><img src="'.get_template_directory_uri().'/images/admin/close-red.png"></a></li>
				<li class="full">&nbsp;</li>
				<li class="to-label"><label>Awesome Font</label></li>
				<li class="to-field">
				  <input class="small" type="text" id="social_net_awesome" name="social_net_awesome[]" value="'.$_POST['social_net_awesome'].'" style="width:420px;" />
				  <p>Put Awesome Font Code like "fa-flag".</p>
				</li>
				<li class="full">&nbsp;</li>
				<li class="to-label"><label>URL</label></li>
				<li class="to-field">
				  <input class="small" type="text" id="social_net_url" name="social_net_url[]" value="'.$_POST['social_net_url'].'" style="width:420px;" />
				  <p>Please enter full URL.</p>
				</li>
				<li class="full">&nbsp;</li>
				<li class="to-label"><label>Title</label></li>
				<li class="to-field">
				  <input class="small" type="text" id="social_net_tooltip" name="social_net_tooltip[]" value="'.$_POST['social_net_tooltip'].'" style="width:420px;" />
				  <p>Please enter text for icon tooltip..</p>
				</li>
			</ul>
		</td> 
	</tr>';
	die;
}	

add_action('wp_ajax_cs_add_social_icon', 'cs_add_social_icon');

// media pagination for slider/gallery in admin side start
function cs_media_pagination(){
	foreach ( $_REQUEST as $keys=>$values) {
		$$keys = $values;
	}
	$records_per_page = 10;
	if ( empty($page_id) ) $page_id = 1;
	$offset = $records_per_page * ($page_id-1);
?>
	<ul class="gal-list">
      <?php
        $query_images_args = array('post_type' => 'attachment', 'post_mime_type' =>'image', 'post_status' => 'inherit', 'posts_per_page' => -1,);
        $query_images = new WP_Query( $query_images_args );
        if ( empty($total_pages) ) $total_pages = count( $query_images->posts );
		$query_images_args = array('post_type' => 'attachment', 'post_mime_type' =>'image', 'post_status' => 'inherit', 'posts_per_page' => $records_per_page, 'offset' => $offset,);
        $query_images = new WP_Query( $query_images_args );
        $images = array();
        foreach ( $query_images->posts as $image) {
        	$image_path = wp_get_attachment_image_src( $image->ID, array( get_option("thumbnail_size_w"),get_option("thumbnail_size_h") ) );
        ?>
        	<li style="cursor:pointer"><img src="<?php echo $image_path[0]?>" onclick="javascript:clone('<?php echo $image->ID?>')" alt="" /></li>
         <?php
         }
         ?>
      </ul>
      <br />
      <div class="pagination-cus">
        	<ul>
				<?php
                if ( $page_id > 1 ) echo "<li><a href='javascript:show_next(".($page_id-1).",$total_pages)'>Prev</a></li>";
                    for ( $i = 1; $i <= ceil($total_pages/$records_per_page); $i++ ) {
                        if ( $i <> $page_id ) echo "<li><a href='javascript:show_next($i,$total_pages)'>" . $i . "</a></li> ";
                        else echo "<li class='active'><a>" . $i . "</a></li>";
                    }
                if ( $page_id < $total_pages/$records_per_page ) echo "<li><a href='javascript:show_next(".($page_id+1).",$total_pages)'>Next</a></li>";
                ?>
			</ul>
        </div>
<?php
	if ( isset($_POST['action']) ) die();
}
add_action('wp_ajax_cs_media_pagination', 'cs_media_pagination');
// media pagination for slider/gallery in admin side end

// to make a copy of media image for slider start
function cs_slider_clone(){
	global $cs_node, $counter;
	if( isset($_POST['action']) ) {
		$cs_node = new stdClass();
		$cs_node->title = '';
		$cs_node->description = '';
		$cs_node->link = '';
		$cs_node->link_target = '';
		$cs_node->use_image_as = '';
		$cs_node->video_code = '';
	}
	if ( isset($_POST['counter']) ) $counter = $_POST['counter'];
	if ( isset($_POST['path']) ) $cs_node->path = $_POST['path'];
?>
    <li class="ui-state-default" id="<?php echo $counter?>">
        <div class="thumb-secs">
            <?php $image_path = wp_get_attachment_image_src( $cs_node->path, array( get_option("thumbnail_size_w"),get_option("thumbnail_size_h") ) );?>
            <img src="<?php echo $image_path[0]?>" alt="">
            <div class="gal-edit-opts">
                <!--<a href="#" class="resize"></a>-->
                <a href="javascript:slidedit(<?php echo $counter?>)" class="edit"></a>
                <a href="javascript:del_this(<?php echo $counter?>)" class="delete"></a>
            </div>
        </div>
        <div class="poped-up" id="edit_<?php echo $counter?>">
            <div class="opt-head">
                <h5>Edit Options</h5>
                <a href="javascript:slideclose(<?php echo $counter?>)" class="closeit">&nbsp;</a>
                <div class="clear"></div>
            </div>
            <div class="opt-conts">
                <ul class="form-elements">
                    <li class="to-label"><label>Image Title</label></li>
                    <li class="to-field"><input type="text" name="cs_slider_title[]" value="<?php echo htmlspecialchars($cs_node->title)?>" class="txtfield" /></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Image Description</label></li>
                    <li class="to-field"><textarea class="txtarea" name="cs_slider_description[]"><?php echo htmlspecialchars($cs_node->description)?></textarea></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Link</label></li>
                    <li class="to-field"><input type="text" name="cs_slider_link[]" value="<?php echo htmlspecialchars($cs_node->link)?>" class="txtfield" /></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Link Target</label></li>
                    <li class="to-field">
                        <select name="cs_slider_link_target[]" class="select_dropdown">
                            <option <?php if($cs_node->link_target=="_self")echo "selected";?> >_self</option>
                            <option <?php if($cs_node->link_target=="_blank")echo "selected";?> >_blank</option>
                        </select>
                        <p>Please select image target.</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"></li>
                    <li class="to-field">
                        <input type="hidden" name="path[]" value="<?php echo $cs_node->path?>" />
                        <input type="button" value="Submit" onclick="javascript:slideclose(<?php echo $counter?>)" class="close-submit" />
                    </li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
    </li>
<?php
	if ( isset($_POST['action']) ) die();
}
add_action('wp_ajax_slider_clone', 'cs_slider_clone');
// to make a copy of media image for slider end

// to make a copy of media image for gallery start
function cs_gallery_clone(){
	global $cs_node, $counter;
	if( isset($_POST['action']) ) {
		$cs_node = new stdClass();
		$cs_node->title = "";
		$cs_node->description = "";
		$cs_node->use_image_as = "";
		$cs_node->video_code = "";
		$cs_node->link_url = "";
		$cs_node->use_image_as_db = "";
		$cs_node->link_url_db = '';
	}
	if ( isset($_POST['counter']) ) $counter = $_POST['counter'];
	if ( isset($_POST['path']) ) $cs_node->path = $_POST['path'];
?>
    <li class="ui-state-default" id="<?php echo $counter?>">
        <div class="thumb-secs">
            <?php $image_path = wp_get_attachment_image_src( $cs_node->path, array( get_option("thumbnail_size_w"),get_option("thumbnail_size_h") ) );?>
            <img src="<?php echo $image_path[0]?>" alt="">
            <div class="gal-edit-opts">
                <!--<a href="#" class="resize"></a>-->
                <a href="javascript:galedit(<?php echo $counter?>)" class="edit"></a>
                <a href="javascript:del_this(<?php echo $counter?>)" class="delete"></a>
            </div>
        </div>
        <div class="poped-up" id="edit_<?php echo $counter?>">
            <div class="opt-head">
                <h5>Edit Options</h5>
                <a href="javascript:galclose(<?php echo $counter?>)" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
                <ul class="form-elements">
                    <li class="to-label"><label>Image Title</label></li>
                    <li class="to-field"><input type="text" name="title[]" value="<?php echo htmlspecialchars($cs_node->title)?>" class="txtfield" /></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Image Description</label></li>
                    <li class="to-field"><textarea class="txtarea" name="description[]"><?php echo htmlspecialchars($cs_node->description)?></textarea></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Use Image As</label></li>
                    <li class="to-field">
                        <select name="use_image_as[]" class="select_dropdown" onchange="cs_toggle_gal(this.value, <?php echo $counter?>)">
                            <option <?php if($cs_node->use_image_as=="0")echo "selected";?> value="0">LightBox to current thumbnail</option>
                            <option <?php if($cs_node->use_image_as=="1")echo "selected";?> value="1">LightBox to Video</option>
                            <option <?php if($cs_node->use_image_as=="2")echo "selected";?> value="2">Link URL</option>
                        </select>
                        <p>Please select Image link where it will go.</p>
                    </li>
                </ul>
                <ul class="form-elements" id="video_code<?php echo $counter?>" <?php if($cs_node->use_image_as=="0" or $cs_node->use_image_as=="" or $cs_node->use_image_as=="2")echo 'style="display:none"';?> >
                    <li class="to-label"><label>Video URL</label></li>
                    <li class="to-field">
                        <input type="text" name="video_code[]" value="<?php echo htmlspecialchars($cs_node->video_code)?>" class="txtfield" />
                        <p>(Enter Specific Video URL Youtube or Vimeo)</p>
                    </li>
                </ul>
                <ul class="form-elements" id="link_url<?php echo $counter?>" <?php if($cs_node->use_image_as=="0" or $cs_node->use_image_as=="" or $cs_node->use_image_as=="1")echo 'style="display:none"';?> >
                    <li class="to-label"><label>Link URL</label></li>
                    <li class="to-field">
                        <input type="text" name="link_url[]" value="<?php echo htmlspecialchars($cs_node->link_url)?>" class="txtfield" />
                        <p>(Enter Specific Link URL)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"></li>
                    <li class="to-field">
                        <input type="hidden" name="path[]" value="<?php echo $cs_node->path?>" />
                        <input type="button" onclick="javascript:galclose(<?php echo $counter?>)" value="Submit" class="close-submit" />
                    </li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
    </li>
<?php
	if ( isset($_POST['action']) ) die();
}
add_action('wp_ajax_gallery_clone', 'cs_gallery_clone');
// to make a copy of media image for gallery end

// stripslashes / htmlspecialchars for theme option save start
function cs_stripslashes_htmlspecialchars($value)
{
    $value = is_array($value) ? array_map('cs_stripslashes_htmlspecialchars', $value) : stripslashes(htmlspecialchars($value));
    return $value;
}
// stripslashes / htmlspecialchars for theme option save end

// twitter API authentication start
function cs_twitter_authenticate($force = false) {
		$cs_theme_option = get_option('cs_theme_option');
		$api_key =  $cs_theme_option['consumer_key'];
		$api_secret =  $cs_theme_option['consumer_secret'];
		$token =  get_option( 'TWITTER_BEARER_TOKEN' );
		
		if($api_key && $api_secret && ( !$token || $force )) {
			$bearer_token_credential = $api_key . ':' . $api_secret;
			$credentials = base64_encode($bearer_token_credential);
			
			$args = array(
				'method' => 'POST',
				'httpversion' => '1.1',
				'blocking' => true,
				'headers' => array( 
					'Authorization' => 'Basic ' . $credentials,
					'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
				),
				'body' => array( 'grant_type' => 'client_credentials' )
			);
			$keys = new stdClass();
			add_filter('https_ssl_verify', '__return_false');
			$response = wp_remote_post( 'https://api.twitter.com/oauth2/token', $args );
			if(!is_wp_error($response)){
				$keys = array();
				$keys = json_decode($response['body']);
				if($keys) {
					//global $message;
					if(!empty($keys->access_token)){
						update_option( 'TWITTER_BEARER_TOKEN', $keys->{'access_token'} );
						//echo $message = "<div class='form-msgs'><div class='to-notif success-box'><p>Twitter API Settings Successfully Saved</p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>";
					}else{
						 //$message = "<div class='form-msgs'><div class='to-notif error-box'> <p>".$keys->errors[0]->message."</p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>";
					}
					/*echo $message = "<script>slideout();</script>";*/
				}
			}else{
				//echo $message = "<div class='form-msgs'><div class='to-notif error-box'><p>".$response->errors['http_failure'][0]."</p><a class='close-it' onclick='tab_close()'>&nbsp;</a></div></div>";
				/*echo $message = "<script>slideout();</script>";*/
			}
		}
}
// twitter API authentication end

/* Theme option Fucntions Start */

// saving all the theme options start
function cs_theme_option_save() {
	if ( isset($_POST['logo']) ) {
		$_POST = cs_stripslashes_htmlspecialchars($_POST);
		if ( $_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['twitter_setting'])){
			update_option( "cs_theme_option", $_POST );
			echo "All Settings Saved";
			cs_twitter_authenticate(true);
		}else{
			update_option( "cs_theme_option", $_POST );
			echo "All Settings Saved";
			
		}
		// upating config file end
			
	}
	else {
		$target_path_mo = get_template_directory()."/languages/".$_FILES["mofile"]["name"][0];
		if ( move_uploaded_file($_FILES["mofile"]["tmp_name"][0], $target_path_mo) ) {
			chmod($target_path_mo,0777);
		}
		echo "New Language Uploaded Successfully";
	}
	die();
}
add_action('wp_ajax_cs_theme_option_save', 'cs_theme_option_save');
// saving all the theme options end

function cs_theme_option_import_export() {
	$a = unserialize(base64_decode($_POST['theme_option_data']));
	update_option( "cs_theme_option", $a );
	echo "Otions Imported";
	die();
}
add_action('wp_ajax_cs_theme_option_import_export', 'cs_theme_option_import_export');
// saving theme options import export end

// restoring default theme options start
function cs_theme_option_restore_default() {
	update_option( "cs_theme_option", get_option('cs_theme_option_restore') );
	echo "Default Theme Options Restored";
	die();
}
add_action('wp_ajax_cs_theme_option_restore_default', 'cs_theme_option_restore_default');
// restoring default theme options end

// saving theme options backup start
function cs_theme_option_backup() {
	update_option( "cs_theme_option_backup", get_option('cs_theme_option') );
	update_option( "cs_theme_option_backup_time", gmdate("Y-m-d H:i:s") );
	echo "Current Backup Taken @ " . gmdate("Y-m-d H:i:s");
	die();
}
add_action('wp_ajax_cs_theme_option_backup', 'cs_theme_option_backup');
// saving theme options backup end

// restore backup start
function cs_theme_option_backup_restore() {
	update_option( "cs_theme_option", get_option('cs_theme_option_backup') );
	echo "Backup Restored";
	die();
}
add_action('wp_ajax_cs_theme_option_backup_restore', 'cs_theme_option_backup_restore');
// restore backup end

/* Theme option Fucntions End  */

// page bulider items start

// Album page builder function
function cs_pb_album($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$album_element_size = '50';
		$cs_album_cat_db = '';
		$cs_album_view = '';
		$cs_album_title = '';
		$cs_album_filterable_db = '';
		$cs_album_cat_show_db = '';
		$cs_album_buynow_db = '';
		$cs_album_pagination_db = '';
 		$cs_album_per_page_db = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$album_element_size = $cs_node->album_element_size;
			$cs_album_title = $cs_node->cs_album_title;
			$cs_album_cat_db = $cs_node->cs_album_cat;
			$cs_album_view = $cs_node->cs_album_view;
			$cs_album_filterable_db = $cs_node->cs_album_filterable;
			$cs_album_cat_show_db = $cs_node->cs_album_cat_show;
			$cs_album_buynow_db = $cs_node->cs_album_buynow;
			$cs_album_pagination_db = $cs_node->cs_album_pagination;
 			$cs_album_per_page_db = $cs_node->cs_album_per_page;
				$counter = $post->ID.$count_node;
	}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column parentdelete column_<?php echo $album_element_size?>" item="album" data="<?php echo element_size_data_array_index($album_element_size)?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="album_element_size[]" class="item" value="<?php echo $album_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a>
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp; 
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
        <div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Album Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Album Title</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_album_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_album_title)?>" />
                        <p>Album Page Title</p>
                    </li>                                            
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Choose Category</label></li>
                    <li class="to-field">
                        <select name="cs_album_cat[]" class="dropdown">
                        	<option value="0">-- Select Category --</option>
                        	<?php show_all_cats('', '', $cs_album_cat_db, "album-category");?>
                        </select>
                        <p>Choose category to show albums list</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Select View</label></li>
                    <li class="to-field">
                        <select name="cs_album_view[]" class="dropdown">
                         	<option <?php if($cs_album_view=="List View")echo "selected";?>>List View</option>
                          	<option <?php if($cs_album_view=="Grid View")echo "selected";?>>Grid View</option>
                        </select>
                    </li>                                        
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Show Category</label></li>
                    <li class="to-field">
                        <select name="cs_album_cat_show[]" class="dropdown">
                            <option <?php if($cs_album_cat_show_db=="On")echo "selected";?> >On</option>
                            <option <?php if($cs_album_cat_show_db=="Off")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Buy Now</label></li>
                    <li class="to-field">
                        <select name="cs_album_buynow[]" class="dropdown">
                            <option <?php if($cs_album_buynow_db=="On")echo "selected";?> >On</option>
                            <option <?php if($cs_album_buynow_db=="Off")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Filterable</label></li>
                    <li class="to-field">
                        <select name="cs_album_filterable[]" class="dropdown">
                            <option <?php if($cs_album_filterable_db=="Off")echo "selected";?> >Off</option>
                            <option <?php if($cs_album_filterable_db=="On")echo "selected";?> >On</option>
                        </select>
                    </li>
                </ul>

				<ul class="form-elements">
                    <li class="to-label"><label>Pagination</label></li>
                    <li class="to-field">
                        <select name="cs_album_pagination[]" class="dropdown" >
                            <option <?php if($cs_album_pagination_db=="Show Pagination")echo "selected";?> >Show Pagination</option>
                            <option <?php if($cs_album_pagination_db=="Single Page")echo "selected";?> >Single Page</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>No. of Album Per Page</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_album_per_page[]" class="txtfield" value="<?php echo $cs_album_per_page_db;?>" />
                        <p>To display all the records, leave this field blank.</p>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label></label></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="album" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_album', 'cs_pb_album');

// Tracks Now playing page builder function
function cs_pb_now_playing($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$now_playing_element_size = '50';
 		$now_playing_title = '';
 		$now_playing_album = '';
		$now_playing_tracks = '';
		$now_playing_autoplay = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$now_playing_element_size = $cs_node->now_playing_element_size;
			$now_playing_title = $cs_node->now_playing_title;
			$now_playing_album = $cs_node->now_playing_album;
			$now_playing_tracks = $cs_node->now_playing_tracks;
			$now_playing_autoplay = $cs_node->now_playing_autoplay;
				$counter = $post->ID.$count_node;
	}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column parentdelete column_<?php echo $now_playing_element_size?>" item="now_playing" data="<?php echo element_size_data_array_index($now_playing_element_size)?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="now_playing_element_size[]" class="item" value="<?php echo $now_playing_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a>
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp; 
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
        <div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Now Playing Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Now Playing Title</label></li>
                    <li class="to-field">
                        <input type="text" name="now_playing_title[]" class="txtfield" value="<?php echo htmlspecialchars($now_playing_title)?>" />
                    </li>                                            
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Select Album</label></li>
                    <li class="to-field">
                        <select name="now_playing_album[]" class="dropdown">
                        	<option value="0">-- Select Album --</option>
							<?php
								wp_reset_query();
                                query_posts( array('posts_per_page' => "-1", 'post_status' => 'publish', 'post_type' => 'albums') );
                                    while ( have_posts()) : the_post();
                                    ?>
                                        <option <?php if($now_playing_album==get_the_ID())echo "selected"?> value="<?php the_ID()?>"><?php the_title()?></option>
                                    <?php
                                    endwhile;
                            ?>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                        <li class="to-label"><label>Auto Play</label></li>
                        <li class="to-field">
                            <select name="now_playing_autoplay[]" class="dropdown" >
                                <option value="true" <?php if($now_playing_autoplay=="true")echo "selected";?> >On</option>
                                <option value="false" <?php if($now_playing_autoplay=="false")echo "selected";?> >Off</option>
                            </select>
                        </li>
                    </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>No. of tracks</label></li>
                    <li class="to-field">
                        <input type="text" name="now_playing_tracks[]" class="txtfield" value="<?php echo htmlspecialchars($now_playing_tracks)?>" />
                        <p>To display all the records, leave this field blank.</p>
                    </li>                                            
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label></label></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="now_playing" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_now_playing', 'cs_pb_now_playing');

// add Album tracks function
function cs_add_track_to_list(){
	global $counter_track, $album_track_title, $album_track_mp3_url , $album_track_playable, $album_track_downloadable, $album_track_lyrics, $album_track_buy_mp3 ;
	foreach ($_POST as $keys=>$values) {
		$$keys = $values;
	}
?>
    <tr id="edit_track<?php echo $counter_track?>">
        <td id="album-title<?php echo $counter_track?>" style="width:80%;"><?php echo $album_track_title?></td>
        <td class="centr" style="width:20%;">
            <a href="javascript:openpopedup('edit_track_form<?php echo $counter_track?>')" class="actions edit">&nbsp;</a>
            <a onclick="javascript:return confirm('Are you sure! You want to delete this Track')" href="javascript:cs_div_remove('edit_track<?php echo $counter_track?>')" class="actions delete">&nbsp;</a>
            <div class="poped-up" id="edit_track_form<?php echo $counter_track?>">
                <div class="opt-head">
                    <h5>Track Settings</h5>
                    <a href="javascript:closepopedup('edit_track_form<?php echo $counter_track?>')" class="closeit">&nbsp;</a>
                    <div class="clear"></div>
                </div>
                <ul class="form-elements">
                    <li class="to-label"><label>Track Title</label></li>
                    <li class="to-field">
                        <input type="text" name="album_track_title[]" value="<?php echo htmlspecialchars($album_track_title)?>" id="album_track_title<?php echo $counter_track?>" />
                        <p>Put album track title</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Track MP3 URL</label></li>
                    <li class="to-field">
                        <input id="album_track_mp3_url<?php echo $counter_track?>" name="album_track_mp3_url[]" value="<?php echo htmlspecialchars($album_track_mp3_url)?>" type="text" class="small" />
                        <input id="album_track_mp3_url<?php echo $counter_track?>" name="album_track_mp3_url<?php echo $counter_track?>" type="button" class="uploadfile left" value="Browse"/>
                        <p>Put album track mp3 url</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Playable</label></li>
                    <li class="to-field">
                        <select name="album_track_playable[]" class="dropdown">
                            <option <?php if($album_track_playable=="Yes")echo "selected";?> >Yes</option>
                            <option <?php if($album_track_playable=="No")echo "selected";?> >No</option>
                        </select>
                        <p>Make Playable on/off</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Downloadable</label></li>
                    <li class="to-field">
                        <select name="album_track_downloadable[]" class="dropdown">
                            <option <?php if($album_track_downloadable=="Yes")echo "selected";?> >Yes</option>
                            <option <?php if($album_track_downloadable=="No")echo "selected";?> >No</option>
                        </select>
                        <p>Make Playable on/off</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Lyrics</label></li>
                    <li class="to-field">
                        <textarea name="album_track_lyrics[]"><?php echo htmlspecialchars($album_track_lyrics)?></textarea>
                        <p>Put album track mp3 url</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Buy MP3 URL</label></li>
                    <li class="to-field">
                        <input type="text" name="album_track_buy_mp3[]" value="<?php echo htmlspecialchars($album_track_buy_mp3)?>" />
                        <p>Put album track mp3 url</p>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label></label></li>
                    <li class="to-field"><input type="button" value="Update Track" onclick="update_title(<?php echo $counter_track?>); closepopedup('edit_track_form<?php echo $counter_track?>')" /></li>
                </ul>
            </div>
        </td>
    </tr>
<?php
	if ( isset($action) ) die();
}
add_action('wp_ajax_cs_add_track_to_list', 'cs_add_track_to_list');

// gallery html form for page builder start
function cs_pb_gallery($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
			$name = $_POST['action'];
			$counter = $_POST['counter'];
			$gallery_element_size = '50';
			$cs_gal_header_title_db = '';
			$cs_gal_view_all_db = '';
			$cs_gal_view_all_url_db = '';
			$cs_gal_layout_db = '';
			$cs_gal_album_db = '';
 			$cs_gal_desc_db = '';
			$cs_gal_pagination_db = '';
			$cs_gal_media_per_page_db = get_option("posts_per_page");
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$gallery_element_size = $cs_node->gallery_element_size;
			$cs_gal_header_title_db = $cs_node->header_title;
			$cs_gal_view_all_db = $cs_node->view_all;
			$cs_gal_view_all_url_db = $cs_node->view_all_url;
			$cs_gal_layout_db = $cs_node->layout;
			$cs_gal_album_db = $cs_node->album;
 			$cs_gal_desc_db = $cs_node->desc;
			$cs_gal_pagination_db = $cs_node->pagination;
			$cs_gal_media_per_page_db = $cs_node->media_per_page;
				$counter = $post->ID.$count_node;
	}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $gallery_element_size?>" item="gallery" data="<?php echo element_size_data_array_index($gallery_element_size)?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="gallery_element_size[]" class="item" value="<?php echo $gallery_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
        <div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Gallery Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Gallery Header Title</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_gal_header_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_gal_header_title_db)?>" />
                        <p>Please enter gallery header title.</p>
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>View All Title</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_gal_view_all[]" class="txtfield" value="<?php echo htmlspecialchars($cs_gal_view_all_db)?>" />
                        <p>Please enter the title.</p>
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>View All URL</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_gal_view_all_url[]" class="txtfield" value="<?php echo htmlspecialchars($cs_gal_view_all_url_db)?>" />
                        <p>Please enter the URL for view all.</p>
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Choose Gallery Layout</label></li>
                    <li class="to-field">
                        <select name="cs_gal_layout[]" class="dropdown">
                            <option value="gallery-4-col" <?php if($cs_gal_layout_db=="gallery-4-col")echo "selected";?> >4 Column</option>
                            <option value="gallery-3-col" <?php if($cs_gal_layout_db=="gallery-3-col")echo "selected";?> >3 Column</option>
                            <option value="gallery-2-col" <?php if($cs_gal_layout_db=="gallery-2-col")echo "selected";?> >2 Column</option>
                            <option value="gallery-two-col-with-title" <?php if($cs_gal_layout_db=="gallery-two-col-with-title")echo "selected";?> >2 Column - Gallery with title</option>
                        </select>
                        
                        <p>Select gallery layout, single column, double column, thriple column or four column.</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Choose Gallery/Album</label></li>
                    <li class="to-field">
                        <select name="cs_gal_album[]" class="dropdown">
                        	<option value="0">-- Select Gallery --</option>
                            <?php
                                $query = array( 'posts_per_page' => '-1', 'post_type' => 'cs_gallery', 'orderby'=>'ID', 'post_status' => 'publish' );
                                $wp_query = new WP_Query($query);
                                while ($wp_query->have_posts()) : $wp_query->the_post();
                            ?>
                                <option <?php if($post->post_name==$cs_gal_album_db)echo "selected";?> value="<?php echo $post->post_name; ?>"><?php echo get_the_title()?></option>
                            <?php
                                endwhile;
                            ?>
                        </select>
                        <p>Select gallery album to show images.</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Show Description</label></li>
                    <li class="to-field">
                        <select name="cs_gal_desc[]" class="dropdown">
                            <option <?php if($cs_gal_desc_db=="On")echo "selected";?> >On</option>
                            <option <?php if($cs_gal_desc_db=="Off")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Pagination</label></li>
                    <li class="to-field">
                        <select name="cs_gal_pagination[]" class="dropdown" >
                            <option <?php if($cs_gal_pagination_db=="Show Pagination")echo "selected";?> >Show Pagination</option>
                            <option <?php if($cs_gal_pagination_db=="Single Page")echo "selected";?> >Single Page</option>
                        </select>
                    </li>
                </ul>
				<ul class="form-elements" >
                    <li class="to-label"><label>No. of Media Per Page</label></li>
                    <li class="to-field">
                    	<input type="text" name="cs_gal_media_per_page[]" class="txtfield" value="<?php echo $cs_gal_media_per_page_db; ?>" />
                        <p>To display all the records, leave this field blank.</p>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="gallery" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_gallery', 'cs_pb_gallery');
// gallery html form for page builder end

// slider html form for page builder start
function cs_pb_slider($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$slider_element_size = '50';
		$cs_slider_header_title_db = '';
		$cs_slider_type_db = '';
		$cs_slider_db = '';
		$cs_slider_width_db = '';
		$cs_slider_height_db = '';
		$slider_view= '';
		$slider_id ='';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$slider_element_size = $cs_node->slider_element_size;
			$cs_slider_header_title_db = $cs_node->slider_header_title;
			$cs_slider_type_db = $cs_node->slider_type;
			$cs_slider_db = $cs_node->slider;
			$slider_view=  $cs_node->slider_view;
			$slider_id = $cs_node->slider_id;
			$cs_slider_width_db = $cs_node->width;
			$cs_slider_height_db = $cs_node->height;
				$counter = $post->ID.$count_node;
	}
?>
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $slider_element_size?>" item="slider" data="<?php echo element_size_data_array_index($slider_element_size)?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="slider_element_size[]" class="item" value="<?php echo $slider_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a>
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
        <div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Slider Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Slider Header Title</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_slider_header_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_slider_header_title_db)?>" />
                        <p>Please enter slider header title.</p>
                    </li>                    
                </ul>
            	<ul class="form-elements">
                    <li class="to-label"><label>Choose SliderType</label></li>
                    <li class="to-field">
                        <select name="cs_slider_type[]" class="dropdown" onchange="cs_toggle_height(this.value,'cs_slider_height<?php echo $name.$counter?>')">
                            <option <?php if($cs_slider_type_db=="Flex Slider"){echo "selected";}?> >Flex Slider</option>
                             <option <?php if($cs_slider_type_db=="Custom Slider"){echo "selected";}?> >Custom Slider</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements" id="choose_slider" style="display:<?php if($cs_slider_type_db == "Custom Slider")echo "none"; else echo "inline"; ?>">
                    <li class="to-label"><label>Choose Slider</label></li>
                    <li class="to-field">
                        <select name="cs_slider[]" class="dropdown">
                             <?php
                                $query = array( 'posts_per_page' => '-1', 'post_type' => 'cs_slider', 'orderby'=>'ID', 'post_status' => 'publish' );
                                $wp_query = new WP_Query($query);
                                while ($wp_query->have_posts()) : $wp_query->the_post();
                            ?>
                                <option <?php if($post->post_name==$cs_slider_db)echo "selected";?> value="<?php echo $post->post_name; ?>"><?php the_title()?></option>
                            <?php
                                endwhile;
                            ?>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements" >
                    <li class="to-label"><label>Slider View</label></li>
                    <li class="to-field">
                        <select name="slider_view[]" class="dropdown" >
                            <option <?php if($slider_view=="content")echo "selected";?> >content</option>
                            <option <?php if($slider_view=="header")echo "selected";?> >header</option>
                         </select>
                    </li>
                </ul>
                <ul class="form-elements" id="layer_slider" style="display:<?php if($cs_slider_type_db == "Custom Slider")echo "inline"; else echo "none"; ?>" >
                    <li class="to-label">
                        <label>Use Short Code</label>
                    </li>
                    <li class="to-field">
                        <input type="text" name="cs_slider_id[]" class="txtfield" value="<?php echo htmlspecialchars($slider_id);?>" />
                    </li>
                    <li class="to-label"></li>
                    <li class="to-field">
                        <p>Please enter the Revolution Slider Short Code like [rev_slider rocky]</p>
                    </li>                                            
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="slider" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_slider', 'cs_pb_slider');
// slider html form for page builder end

// blog html form for page builder start
function cs_pb_blog($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$blog_element_size = '50';
		$cs_blog_title_db = '';
		$cs_blog_view_db = '';
		$cs_blog_view_all_db = '';
		$cs_blog_view_all_url_db = '';
		$cs_blog_cat_db = '';
		$cs_blog_excerpt_db = '255';
		$cs_blog_num_post_db = get_option("posts_per_page");
		$cs_blog_pagination_db = '';
		$cs_post_description_db = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$blog_element_size = $cs_node->blog_element_size;
			$cs_blog_title_db = $cs_node->cs_blog_title;
			$cs_blog_view_db = $cs_node->cs_blog_view;
			$cs_blog_view_all_db = $cs_node->cs_blog_view_all;
			$cs_blog_view_all_url_db = $cs_node->cs_blog_view_all_url;
			$cs_blog_cat_db = $cs_node->cs_blog_cat;
			$cs_blog_excerpt_db = $cs_node->cs_blog_excerpt;
			$cs_blog_num_post_db = $cs_node->cs_blog_num_post;
			$cs_blog_pagination_db = $cs_node->cs_blog_pagination;
			$cs_blog_description_db = $cs_node->cs_blog_description;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $blog_element_size?>" item="blog" data="<?php echo element_size_data_array_index($blog_element_size)?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="blog_element_size[]" class="item" value="<?php echo $blog_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a>
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Blog Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Blog Header Title</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_blog_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_blog_title_db)?>" />
                        <p>Please enter Blog header title.</p>
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>View All Title</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_blog_view_all[]" class="txtfield" value="<?php echo htmlspecialchars($cs_blog_view_all_db)?>" />
                        <p>Please enter the title.</p>
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>View All URL</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_blog_view_all_url[]" class="txtfield" value="<?php echo htmlspecialchars($cs_blog_view_all_url_db)?>" />
                        <p>Please enter the URL for view all.</p>
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Select View</label></li>
                    <li class="to-field">
                        <select name="cs_blog_view[]" class="dropdown">
                         	<option <?php if($cs_blog_view_db=="blog-large")echo "selected";?> value="blog-large">Blog Large Image</option>
                            <option <?php if($cs_blog_view_db=="blog-small")echo "selected";?> value="blog-small">Blog Small Image</option>
                          	<option <?php if($cs_blog_view_db=="blog-masonry")echo "selected";?> value="blog-masonry">Blog Masonry</option>
                        </select>
                        <p>3 and 4 column with both sidebars will display 2 column</p>
                    </li>                                        
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Choose Category</label></li>
                    <li class="to-field">
                        <select name="cs_blog_cat[]" class="dropdown">
                        	<option value="0">-- Select Category --</option>
							<?php show_all_cats('', '', $cs_blog_cat_db, "category");?>
                        </select>
                        <p>Please select category to show posts.</p>
                    </li>                                        
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Post Description</label></li>
                    <li class="to-field">
                        <select name="cs_blog_description[]" class="dropdown" >
                            <option <?php if($cs_blog_description_db=="yes")echo "selected";?> value="yes">Yes</option>
                            <option <?php if($cs_blog_description_db=="no")echo "selected";?> value="no">No</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Length of Excerpt</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_blog_excerpt[]" class="txtfield" value="<?php echo $cs_blog_excerpt_db;?>" />
                        <p>Enter number of character for short description text.</p>
                    </li>                         
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Pagination</label></li>
                    <li class="to-field">
                        <select name="cs_blog_pagination[]" class="dropdown" >
                            <option <?php if($cs_blog_pagination_db=="Show Pagination")echo "selected";?> >Show Pagination</option>
                            <option <?php if($cs_blog_pagination_db=="Single Page")echo "selected";?> >Single Page</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>No. of Post Per Page</label></li>
                    <li class="to-field">
                    	<input type="text" name="cs_blog_num_post[]" class="txtfield" value="<?php echo $cs_blog_num_post_db; ?>" />
                        <p>To display all the records, leave this field blank.</p>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="blog" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_blog', 'cs_pb_blog');
// blog html form for page builder end

// event html form for page builder start
function cs_pb_event($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$event_element_size = '50';
		$cs_event_title_db = '';
		$cs_event_view_db = '';
		$cs_event_type_db = '';
		$cs_event_category_db = '';
		$cs_event_time_db = '';
		$cs_event_organizer_db = '';
 		$cs_event_filterables_db = '';
		$cs_event_pagination_db = '';
		$cs_event_per_page_db = get_option("posts_per_page");
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$event_element_size = $cs_node->event_element_size;
			$cs_event_title_db = $cs_node->cs_event_title;
			$cs_event_view_db = $cs_node->cs_event_view;
			$cs_event_type_db = $cs_node->cs_event_type;
			$cs_event_category_db = $cs_node->cs_event_category;
			$cs_event_time_db = $cs_node->cs_event_time;
			$cs_event_organizer_db = $cs_node->cs_event_organizer;
 			$cs_event_filterables_db = $cs_node->cs_event_filterables;
			$cs_event_pagination_db = $cs_node->cs_event_pagination;
			$cs_event_per_page_db = $cs_node->cs_event_per_page;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $event_element_size?>" item="event" data="<?php echo element_size_data_array_index($event_element_size)?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="event_element_size[]" class="item" value="<?php echo $event_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a>
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
        <div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Event Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Event Title</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_event_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_event_title_db)?>" />
                        <p>Event Page Title</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>View</label></li>
                    <li class="to-field">
                        <select name="cs_event_view[]" class="dropdown">
                            <option value="List View" <?php if($cs_event_view_db=="List View")echo "selected";?> >List View</option>
                            <option value="Grid View" <?php if($cs_event_view_db=="Grid View")echo "selected";?> >Grid View</option>
                            <option value="Calendar View" <?php if($cs_event_view_db=="Calendar View")echo "selected";?> >Calendar View</option>
                        </select>
                        <p>Select layout for Listing page, calender view contain all the dates of events in calender format. List view contain all the events with title and description in list.</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Event Types</label></li>
                    <li class="to-field">
                        <select name="cs_event_type[]" class="dropdown">
                            <option <?php if($cs_event_type_db=="All Events")echo "selected";?> >All Events</option>
                            <option <?php if($cs_event_type_db=="Upcoming Events")echo "selected";?> >Upcoming Events</option>
                            <option <?php if($cs_event_type_db=="Past Events")echo "selected";?> >Past Events</option>
                        </select>
                        <p>Select event type</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Select Category</label></li>
                    <li class="to-field">
                        <select name="cs_event_category[]" class="dropdown">
                        	<option value="0">-- Select Category --</option>
                            <?php show_all_cats('', '', $cs_event_category_db, "event-category");?>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Show Time</label></li>
                    <li class="to-field">
                        <select name="cs_event_time[]" class="dropdown">
                            <option value="Yes" <?php if($cs_event_time_db=="Yes")echo "selected";?> >Yes</option>
                            <option value="No" <?php if($cs_event_time_db=="No")echo "selected";?> >No</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements" style="display:none;">
                    <li class="to-label"><label>Show Organizer</label></li>
                    <li class="to-field">
                        <select name="cs_event_organizer[]" class="dropdown">
                            <option value="Yes" <?php if($cs_event_organizer_db=="Yes")echo "selected";?> >Yes</option>
                            <option value="No" <?php if($cs_event_organizer_db=="No")echo "selected";?> >No</option>
                        </select>
                    </li>
                </ul>
                 <ul class="form-elements">
                    <li class="to-label"><label>Filterables</label></li>
                    <li class="to-field">
                        <select name="cs_event_filterables[]" class="dropdown" >
                            <option value="No" <?php if($cs_event_filterables_db=="No")echo "selected";?> >No</option>
                            <option value="Yes" <?php if($cs_event_filterables_db=="Yes")echo "selected";?> >Yes</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Pagination</label></li>
                    <li class="to-field">
                        <select name="cs_event_pagination[]" class="dropdown" >
                            <option <?php if($cs_event_pagination_db=="Show Pagination")echo "selected";?> >Show Pagination</option>
                            <option <?php if($cs_event_pagination_db=="Single Page")echo "selected";?> >Single Page</option>
                        </select>
                        <p>Show navigation only at List View.</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>No. of Events Per Page</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_event_per_page[]" class="txtfield" value="<?php echo $cs_event_per_page_db; ?>" />
                        <p>To display all the records, leave this field blank.</p>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="event" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_event', 'cs_pb_event');
// event html form for page builder end

// contact us html form for page builder start
function cs_pb_contact($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$contact_element_size = '50';
 		$cs_contact_email_db = '';
		$cs_contact_succ_msg_db = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$contact_element_size = $cs_node->contact_element_size;
 			$cs_contact_email_db = $cs_node->cs_contact_email;
			$cs_contact_succ_msg_db = $cs_node->cs_contact_succ_msg;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $contact_element_size?>" item="contact" data="<?php echo element_size_data_array_index($contact_element_size)?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="contact_element_size[]" class="item" value="<?php echo $contact_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a>
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Contact Form</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
				<ul class="form-elements">
                    <li class="to-label"><label>Contact Email</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_contact_email[]" class="txtfield" value="<?php if($cs_contact_email_db=="") echo get_option("admin_email"); else echo $cs_contact_email_db;?>" />
                        <p>Please enter Contact email Address.</p>
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Successful Message</label></li>
                    <li class="to-field"><textarea name="cs_contact_succ_msg[]"><?php if($cs_contact_succ_msg_db=="")echo "Email Sent Successfully.\nThank you, your message has been submitted to us."; else echo $cs_contact_succ_msg_db;?></textarea></li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="contact" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_contact', 'cs_pb_contact');
// contact us html form for page builder end

// column html form for page builder start
function cs_pb_column($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$column_element_size = '25';
		$column_text = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$column_element_size = $cs_node->column_element_size;
			$column_text = $cs_node->column_text;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $column_element_size?>" item="column" data="<?php echo element_size_data_array_index($column_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="column_element_size[]" class="item" value="<?php echo $column_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Column Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Column Text</label></li>
                    <li class="to-field">
                    	<textarea name="column_text[]"><?php echo $column_text?></textarea>
                        <p>Shortcodes and HTML tags allowed.</p>
                    </li>                  
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="column" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_column', 'cs_pb_column');
// column html form for page builder end 

// divider html form for page builder start
function cs_pb_divider($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$divider_element_size = '25';
		$divider_style = '';
		$divider_backtotop = '';
		$divider_mrg_top = '20';
		$divider_mrg_bottom = '20';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$divider_element_size = $cs_node->divider_element_size;
			$divider_style = $cs_node->divider_style;
			$divider_backtotop = $cs_node->divider_backtotop;
			$divider_mrg_top = $cs_node->divider_mrg_top;
			$divider_mrg_bottom = $cs_node->divider_mrg_bottom;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $divider_element_size?>" item="divider" data="<?php echo element_size_data_array_index($divider_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="divider_element_size[]" class="item" value="<?php echo $divider_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Divider Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Style</label></li>
                    <li class="to-field">
                        <select name="divider_style[]" class="dropdown" >
                            <option <?php if($divider_style=="divider1")echo "selected";?> >divider1</option>
                            <option <?php if($divider_style=="divider2")echo "selected";?> >divider2</option>
                            <option <?php if($divider_style=="divider3")echo "selected";?> >divider3</option>
                            <option <?php if($divider_style=="divider4")echo "selected";?> >divider4</option>
                            <option <?php if($divider_style=="divider5")echo "selected";?> >divider5</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Back to Top</label></li>
                    <li class="to-field">
                        <select name="divider_backtotop[]" class="dropdown" >
                            <option value="yes" <?php if($divider_backtotop=="yes")echo "selected";?> >Yes</option>
                            <option value="no" <?php if($divider_backtotop=="no")echo "selected";?> >No</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Margin Top</label></li>
                    <li class="to-field">
                    	<input type="text" name="divider_mrg_top[]" value="<?php echo $divider_mrg_top ?>" />
                        <p>Set the top margin (In PX)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Margin Bottom</label></li>
                    <li class="to-field">
                    	<input type="text" name="divider_mrg_bottom[]" value="<?php echo $divider_mrg_bottom ?>" />
                        <p>Set the bottom margin (In PX)</p>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="divider" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_divider', 'cs_pb_divider');
// divider html form for page builder end

// image frame html form for page builder start
function cs_pb_image($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$image_element_size = '25';
		$image_width = '';
		$image_height = '';
		$image_lightbox = '';
		$image_source = '';
		$image_style = '';
		$image_caption = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$image_element_size = $cs_node->image_element_size;
			$image_width = $cs_node->image_width;
			$image_height = $cs_node->image_height;
			$image_lightbox = $cs_node->image_lightbox;
			$image_source = $cs_node->image_source;
			$image_style = $cs_node->image_style;
			$image_caption = $cs_node->image_caption;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $image_element_size?>" item="image_frame" data="<?php echo element_size_data_array_index($image_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="image_element_size[]" class="item" value="<?php echo $image_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Image Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Width</label></li>
                    <li class="to-field">
                    	<input type="text" name="image_width[]" class="txtfield" value="<?php echo $image_width?>" />
                        <p>Enter value in PX</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Height</label></li>
                    <li class="to-field">
                    	<input type="text" name="image_height[]" class="txtfield" value="<?php echo $image_height?>" />
                        Enter value in PX
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Lightbox</label></li>
                    <li class="to-field">
                    	<select name="image_lightbox[]">
                        	<option value="yes" <?php if($image_lightbox=="yes")echo "selected";?> >Yes</option>
                        	<option value="no" <?php if($image_lightbox=="no")echo "selected";?> >No</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Source</label></li>
                    <li class="to-field">
                    	<input type="text" name="image_source[]" class="txtfield" value="<?php echo $image_source?>" />
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Style</label></li>
                    <li class="to-field">
                    	<select name="image_style[]">
                        	<option <?php if($image_style=="frame1")echo "selected";?> >frame1</option>
                        	<option <?php if($image_style=="frame2")echo "selected";?> >frame2</option>
                        	<option <?php if($image_style=="frame3")echo "selected";?> >frame3</option>
                        	<option <?php if($image_style=="frame4")echo "selected";?> >frame4</option>
                        	<option <?php if($image_style=="frame5")echo "selected";?> >frame5</option>
                        	<option <?php if($image_style=="frame6")echo "selected";?> >frame6</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Caption</label></li>
                    <li class="to-field">
                    	<input type="text" name="image_caption[]" class="txtfield" value="<?php echo $image_caption?>" />
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="image" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_image', 'cs_pb_image');
// image frame html form for page builder end

// google map html form for page builder start
function cs_pb_map($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$map_element_size = '25';
		$map_title = '';
		$map_height = '';
		$map_lat = '';
		$map_lon = '';
		$map_zoom = '';
		$map_type = '';
		$map_info = '';
		$map_info_width = '';
		$map_info_height = '';
		$map_marker_icon = '';
		$map_show_marker = '';
		$map_controls = '';
		$map_draggable = '';
		$map_scrollwheel = '';
		$map_view= '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$map_element_size = $cs_node->map_element_size;
			$map_title 	= $cs_node->map_title;
			$map_height = $cs_node->map_height;
			$map_lat 	= $cs_node->map_lat;
			$map_lon 	= $cs_node->map_lon;
			$map_zoom 	= $cs_node->map_zoom;
			$map_type = $cs_node->map_type;
			$map_info = $cs_node->map_info;
			$map_info_width = $cs_node->map_info_width;
			$map_info_height = $cs_node->map_info_height;
			$map_marker_icon = $cs_node->map_marker_icon;
			$map_show_marker = $cs_node->map_show_marker;
			$map_controls = $cs_node->map_controls;
			$map_draggable = $cs_node->map_draggable;
			$map_scrollwheel = $cs_node->map_scrollwheel;
			$map_view 	= $cs_node->map_view;
			$counter 	= $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $map_element_size?>" item="map" data="<?php echo element_size_data_array_index($map_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="map_element_size[]" class="item" value="<?php echo $map_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Map Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Title</label></li>
                    <li class="to-field"><input type="text" name="map_title[]" class="txtfield" value="<?php echo $map_title?>" /></li>
                </ul>
				<ul class="form-elements">
                    <li class="to-label"><label>Map Height</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_height[]" class="txtfield" value="<?php echo $map_height?>" />
                        <p>Info Max Height in PX (Default is 200)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Latitude</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_lat[]" class="txtfield" value="<?php echo $map_lat?>" />
                        <p>Put Latitude (Default is 0)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Longitude</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_lon[]" class="txtfield" value="<?php echo $map_lon?>" />
                        <p>Put Longitude (Default is 0)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Zoom</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_zoom[]" class="txtfield" value="<?php echo $map_zoom?>" />
                        <p>Put Zoom Level (Default is 11)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Map Types</label></li>
                    <li class="to-field">
                        <select name="map_type[]" class="dropdown" >
                            <option <?php if($map_type=="ROADMAP")echo "selected";?> >ROADMAP</option>
                            <option <?php if($map_type=="HYBRID")echo "selected";?> >HYBRID</option>
                            <option <?php if($map_type=="SATELLITE")echo "selected";?> >SATELLITE</option>
                            <option <?php if($map_type=="TERRAIN")echo "selected";?> >TERRAIN</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Info Text</label></li>
                    <li class="to-field"><input type="text" name="map_info[]" class="txtfield" value="<?php echo $map_info?>" /></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Info Max Width</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_info_width[]" class="txtfield" value="<?php echo $map_info_width?>" />
                        <p>Info Max Width in PX (Default is 200)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Info Max Height</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_info_height[]" class="txtfield" value="<?php echo $map_info_height?>" />
                        <p>Info Max Height in PX (Default is 100)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Marker Icon Path</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_marker_icon[]" class="txtfield" value="<?php echo $map_marker_icon?>" />
                        <p>e.g. http://yourdomain.com/logo.png</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Show Marker</label></li>
                    <li class="to-field">
                        <select name="map_show_marker[]" class="dropdown" >
                            <option value="true" <?php if($map_show_marker=="true")echo "selected";?> >On</option>
                            <option value="false" <?php if($map_show_marker=="false")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Disable Map Controls</label></li>
                    <li class="to-field">
                        <select name="map_controls[]" class="dropdown" >
                            <option value="false" <?php if($map_controls=="false")echo "selected";?> >Off</option>
                            <option value="true" <?php if($map_controls=="true")echo "selected";?> >On</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Draggable</label></li>
                    <li class="to-field">
                        <select name="map_draggable[]" class="dropdown" >
                            <option value="true" <?php if($map_draggable=="true")echo "selected";?> >On</option>
                            <option value="false" <?php if($map_draggable=="false")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Scroll Wheel</label></li>
                    <li class="to-field">

                        <select name="map_scrollwheel[]" class="dropdown" >
                            <option value="true" <?php if($map_scrollwheel=="true")echo "selected";?> >On</option>
                            <option value="false" <?php if($map_scrollwheel=="false")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                 <ul class="form-elements">
                    <li class="to-label"><label>Map View</label></li>
                    <li class="to-field">
                        <select name="map_view[]" class="dropdown" >
                            <option <?php if($map_view=="content")echo "selected";?> >content</option>
                            <option <?php if($map_view=="header")echo "selected";?> >header</option>
                         </select>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="map" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>

       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_map', 'cs_pb_map');
// google map html form for page builder end

// video html form for page builder start
function cs_pb_video($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$video_element_size = '25';
		$video_url = '';
		$video_width = '';
		$video_height = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$video_element_size = $cs_node->video_element_size;
			$video_url = $cs_node->video_url;
			$video_width = $cs_node->video_width;
			$video_height = $cs_node->video_height;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $video_element_size?>" item="video" data="<?php echo element_size_data_array_index($video_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="video_element_size[]" class="item" value="<?php echo $video_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Video Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
                <ul class="form-elements">
                    <li class="to-label"><label>Video URL</label></li>
                    <li class="to-field">
                    	<input type="text" name="video_url[]" class="txtfield" value="<?php echo $video_url?>" />
                        <p>Enter Video URL (Youtube, Vimeo or any other supported by wordpress)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Width</label></li>
                    <li class="to-field"><input type="text" name="video_width[]" class="txtfield" value="<?php echo $video_width?>" /></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Height</label></li>
                    <li class="to-field"><input type="text" name="video_height[]" class="txtfield" value="<?php echo $video_height?>" /></li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="video" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_video', 'cs_pb_video');
// video html form for page builder end 

// quote html form for page builder start
function cs_pb_quote($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$quote_element_size = '25';
		$quote_text_color = '';
		$quote_align = '';
		$quote_content = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$quote_element_size = $cs_node->quote_element_size;
			$quote_text_color = $cs_node->quote_text_color;
			$quote_align = $cs_node->quote_align;
			$quote_content = $cs_node->quote_content;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $quote_element_size?>" item="quote" data="<?php echo element_size_data_array_index($quote_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="quote_element_size[]" class="item" value="<?php echo $quote_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Quote Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Text Color</label></li>
                    <li class="to-field">
                    	<input type="text" name="quote_text_color[]" class="txtfield" value="<?php echo $quote_text_color?>" />
                        <p>Enter the color code like #000000</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Align</label></li>
                    <li class="to-field">
                        <select name="quote_align[]" class="dropdown" >
                            <option <?php if($quote_align=="left")echo "selected";?> >left</option>
                            <option <?php if($quote_align=="right")echo "selected";?> >right</option>
                            <option <?php if($quote_align=="center")echo "selected";?> >center</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Quote Content</label></li>
                    <li class="to-field"><textarea name="quote_content[]"><?php echo $quote_content?></textarea></li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="quote" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_quote', 'cs_pb_quote');
// quote html form for page builder start

// dropcap html form for page builder start
function cs_pb_dropcap($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$dropcap_element_size = '25';
		$dropcap_content = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$dropcap_element_size = $cs_node->dropcap_element_size;
			$dropcap_content = $cs_node->dropcap_content;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $dropcap_element_size?>" item="dropcap" data="<?php echo element_size_data_array_index($dropcap_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="dropcap_element_size[]" class="item" value="<?php echo $dropcap_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Dropcap Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Content</label></li>
                    <li class="to-field"><textarea name="dropcap_content[]"><?php echo $dropcap_content?></textarea></li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="dropcap" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_dropcap', 'cs_pb_dropcap');
// dropcap html form for page builder end

// price table html form for page builder start
function cs_pb_pricetable($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$pricetable_element_size = '25';
		$pricetable_style= '';
		$pricetable_title = '';
		$pricetable_package = '';
		$pricetable_price = '';
		$pricetable_for_time = '';
		$pricetable_content= '';
		$pricetable_linktitle = '';
		$pricetable_linkurl = '';
		$pricetable_featured = '';
		$pricetable_bgcolor = '';
 	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$pricetable_element_size = $cs_node->pricetable_element_size;
			$pricetable_style = $cs_node->pricetable_style;
			$pricetable_package = $cs_node->pricetable_package;
			$pricetable_title = $cs_node->pricetable_title;
			$pricetable_price = $cs_node ->pricetable_price;
			$pricetable_for_time = $cs_node->pricetable_for_time;
			$pricetable_content = $cs_node->pricetable_content;
			$pricetable_linktitle = $cs_node->pricetable_linktitle;
			$pricetable_linkurl = $cs_node->pricetable_linkurl;
			$pricetable_featured = $cs_node->pricetable_featured;
			$pricetable_bgcolor = $cs_node->pricetable_bgcolor;
 			$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $pricetable_element_size?>" item="pricetable" data="<?php echo element_size_data_array_index($pricetable_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="pricetable_element_size[]" class="item" value="<?php echo $pricetable_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Price Table Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Price Table Style</label></li>
                    <li class="to-field">
                        <select name="pricetable_style[]" class="dropdown" onchange="javascript:toggle_pricetable_style(this.value)">
                            <option <?php if($pricetable_style=="style1")echo "selected";?> >style1</option>
                            <option <?php if($pricetable_style=="style2")echo "selected";?> >style2</option>
                            <option <?php if($pricetable_style=="style3")echo "selected";?> >style3</option>
                         </select>
                    </li>
                </ul>
				<ul class="form-elements" id="price_pakage" style="display:<?php if($pricetable_style == "style3")echo "inline"; else echo "none"; ?>">
                    <li class="to-label"><label>Package</label></li>
                    <li class="to-field"><input type="text" name="pricetable_package[]" class="txtfield" value="<?php echo $pricetable_package?>" /></li>
                </ul>
            	<ul class="form-elements">
                    <li class="to-label"><label>Title</label></li>
                    <li class="to-field"><input type="text" name="pricetable_title[]" class="txtfield" value="<?php echo $pricetable_title?>" /></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Price</label></li>
                    <li class="to-field"><input type="text" name="pricetable_price[]" class="txtfield" value="<?php echo $pricetable_price?>" /></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>For Time Period</label></li>
                    <li class="to-field"><input type="text" name="pricetable_for_time[]" class="txtfield" value="<?php echo $pricetable_for_time?>" /></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Content</label></li>
                    <li class="to-field"><textarea name="pricetable_content[]" class="txtfield" rows="20" cols="20"><?php echo $pricetable_content?></textarea></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Link Title</label></li>
                    <li class="to-field"><input type="text" name="pricetable_linktitle[]" class="txtfield" value="<?php echo $pricetable_linktitle?>" /></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Link</label></li>
                    <li class="to-field"><input type="text" name="pricetable_linkurl[]" class="txtfield" value="<?php echo $pricetable_linkurl?>" /></li>
                </ul>
               	<ul class="form-elements">
                    <li class="to-label"><label>Button Background Color</label></li>
					<li><input type="text"  name="pricetable_bgcolor[]" class="pricetable_bgcolor" value="<?php echo $pricetable_bgcolor?>" data-default-color=""  /></li>
                    <script type="text/javascript">
						jQuery(document).ready(function($){
							$('.pricetable_bgcolor').wpColorPicker(); 
						});
					</script>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Featured</label></li>
                    <li class="to-field">
                        <select name="pricetable_featured[]" class="dropdown" >
                            <option <?php if($pricetable_featured=="Yes")echo "selected";?> >Yes</option>
                            <option <?php if($pricetable_featured=="No")echo "selected";?> >No</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="pricetable" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_pricetable', 'cs_pb_pricetable');
// price table html form for page builder end

// our client html form for page builder start
function cs_pb_client($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
			$name = $_POST['action'];
			$counter = $_POST['counter'];
			$client_element_size = '50';
			$client_header_title = '';
			$client_gallery = '';
			$client_view = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$client_header_title = $cs_node->client_header_title;
			$client_gallery = $cs_node->client_gallery;
			$client_view = $cs_node->client_view;
			$client_element_size = $cs_node->client_element_size;
				$counter = $post->ID.$count_node;
	}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $client_element_size?>" item="client" data="<?php echo element_size_data_array_index($client_element_size)?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="client_element_size[]" class="item" value="<?php echo $client_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
        <div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Client's Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Header Title</label></li>
                    <li class="to-field">
                        <input type="text" name="client_header_title[]" class="txtfield" value="<?php echo htmlspecialchars($client_header_title)?>" />
                        <p>Please enter header title.</p>
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Choose Gallery/Album</label></li>
                    <li class="to-field">
                        <select name="client_gallery[]" class="dropdown">
                        	<option value="0">-- Select Gallery --</option>
                            <?php
                                $query = array( 'posts_per_page' => '-1', 'post_type' => 'cs_gallery', 'orderby'=>'ID', 'post_status' => 'publish' );
                                $wp_query = new WP_Query($query);
                                while ($wp_query->have_posts()) : $wp_query->the_post();
                            ?>
                                <option <?php if($post->post_name==$client_gallery)echo "selected";?> value="<?php echo $post->post_name; ?>"><?php echo get_the_title()?></option>
                            <?php
                                endwhile;
                            ?>
                        </select>
                        <p>Select gallery to show images.</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Select View</label></li>
                    <li class="to-field">
                        <select name="client_view[]" class="dropdown">
                            <option <?php if($client_view=="List View")echo "selected";?> >List View</option>
                            <option <?php if($client_view=="Carousel View")echo "selected";?> >Carousel View</option>
                        </select>
                    </li>                    
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="client" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_client', 'cs_pb_client');
// our client html form for page builder end 

// tabs html form for page builder start
function cs_pb_tabs($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$tabs_element_size = '50';
		$tab_title = '';
		$tab_text = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$tabs_element_size = $cs_node->tabs_element_size;
			$tab_title = $cs_node->tab_title;
			$tab_text = $cs_node->tab_text;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $tabs_element_size?>" item="tabs" data="<?php echo element_size_data_array_index($tabs_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="tabs_element_size[]" class="item" value="<?php echo $tabs_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Tabs Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
				<div class="wrapptabbox">
                    <div class="clone_append">
                        <?php
						$tabs_num = 0;
                        if ( isset($cs_node) ){
							$tabs_num = count($cs_node->tab);
                            foreach ( $cs_node->tab as $tab ){
								if ( $tab->tab_active == "yes" ) { $tab_active = "selected"; }
								else { $tab_active = ""; }
								echo "<div class='clone_form'>";
									echo "<a href='#' class='deleteit_node'>Delete it</a>";
									echo '<label>Tab Title:</label> <input class="txtfield" type="text" name="tab_title[]" value="'.$tab->tab_title.'" />';
									echo '<label>Tab Text:</label> <textarea class="txtfield" name="tab_text[]">'.$tab->tab_text.'</textarea>';
									echo '<label>Title Icon:</label> <input class="txtfield" type="text" name="tab_title_icon[]" value="'.$tab->tab_title_icon.'" />';
									echo '<label>Active:</label> <select name="tab_active[]"><option>no</option><option '.$tab_active.'>yes</option></select> ';
								echo "</div>";
                            }
                        }
                        ?>
                    </div>
                    <div class="opt-conts">
                        <ul class="form-elements">
                            <li class="to-label"><label></label></li>
                            <li class="to-field"><a href="#" class="addedtab">Add Tab</a></li>
                        </ul>
                        <ul class="form-elements noborder">
                            <li class="to-label"></li>
                            <li class="to-field">
                                <input type="hidden" name="tabs_num[]" value="<?php echo $tabs_num?>" class="fieldCounter"  />
                                <input type="hidden" name="cs_orderby[]" value="tabs" />
                                <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                            </li>
                        </ul>
                    </div>
            	</div>
                            
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_tabs', 'cs_pb_tabs');
// tabs html form for page builder end

// services html form for page builder start
function cs_pb_services($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$services_element_size = '50';
		$service_title = '';
		$service_text = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$services_element_size = $cs_node->services_element_size;
			$service_title = $cs_node->service_title;
			$service_text = $cs_node->service_text;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column parentdelete column_<?php echo $services_element_size?>" item="services" data="<?php echo element_size_data_array_index($services_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="services_element_size[]" class="item" value="<?php echo $services_element_size?>" >
           	<a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
        </div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Services Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
				<div class="wrapptabbox">
                    <div class="clone_append">
                        <?php
						$services_num = 0;
                        if ( isset($cs_node) ){
							$services_num = count($cs_node->service);
                            foreach ( $cs_node->service as $service ){
						?>
								<div class='clone_form'>
									<a href='#' class='deleteit_node'>Delete it</a>
									<label>Service Title:</label> <input class="txtfield" type="text" name="service_title[]" value="<?php echo $service->service_title ?>" />
									<label>Service Icon:</label> <input class="txtfield" type="text" name="service_icon[]" value="<?php echo $service->service_icon ?>" />
									<label>Link URL:</label> <input class="txtfield" type="text" name="service_url[]" value="<?php echo $service->service_url ?>" />
									<label>Service Text:</label> <textarea class="txtfield" name="service_text[]"><?php echo $service->service_text ?></textarea>
									<label>Style</label>
                                    <select name="service_style[]">
                                    	<option <?php if($service->service_style == "service1") echo "selected";?> >service1</option>
                                        <option <?php if($service->service_style == "service2") echo "selected";?> >service2</option>
                                        <option <?php if($service->service_style == "service3") echo "selected";?> >service3</option>
                                        <option <?php if($service->service_style == "service4") echo "selected";?> >service4</option>
                                    </select>
								</div>
                        
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="opt-conts">
                        <ul class="form-elements">
                            <li class="to-label"><label></label></li>
                            <li class="to-field"><a href="#" class="add_services">Add service</a></li>
                        </ul>
                        <ul class="form-elements noborder">
                            <li class="to-label"></li>
                            <li class="to-field">
                                <input type="hidden" name="services_num[]" value="<?php echo $services_num?>" class="fieldCounter"  />
                                <input type="hidden" name="cs_orderby[]" value="services" />
                                <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                            </li>
                        </ul>
                    </div>
            	</div>
                            
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_services', 'cs_pb_services');
// services html form for page builder end

// accordion html form for page builder start
function cs_pb_accordion($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$accordion_element_size = '50';
		$accordion_title = '';
		$accordion_text = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$accordion_element_size = $cs_node->accordion_element_size;
			$accordion_title = $cs_node->accordion_title;
			$accordion_text = $cs_node->accordion_text;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $accordion_element_size?>" item="accordion" data="<?php echo element_size_data_array_index($accordion_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="accordion_element_size[]" class="item" value="<?php echo $accordion_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Accordion Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
				<div class="wrapptabbox">
                    <div class="clone_append">
                        <?php
						$accordion_num = 0;
                        if ( isset($cs_node) ){
							$accordion_num = count($cs_node->accordion);
                            foreach ( $cs_node->accordion as $val ){
								if ( $val->accordion_active == "yes" ) { $tab_active = "selected"; }
								else { $tab_active = ""; }
								echo "<div class='clone_form'>";
									echo "<a href='#' class='deleteit_node'>Delete it</a>";
									echo '<label>Tab Title:</label> <input class="txtfield" type="text" name="accordion_title[]" value="'.$val->accordion_title.'" />';
									echo '<label>Tab Text:</label> <textarea class="txtfield" name="accordion_text[]">'.$val->accordion_text.'</textarea>';
									echo '<label>Title Icon:</label> <input class="txtfield" type="text" name="accordion_title_icon[]" value="'.$val->accordion_title_icon.'" />';
									echo '<label>Active:</label> <select name="accordion_active[]"><option>no</option><option '.$tab_active.'>yes</option></select> ';
								echo "</div>";
                            }
                        }
                        ?>
                    </div>
                    <div class="opt-conts">
                        <ul class="form-elements">
                            <li class="to-label"><label></label></li>
                            <li class="to-field"><a href="#" class="add_accordion">Add Tab</a></li>
                        </ul>
                        <ul class="form-elements noborder">
                            <li class="to-label"></li>
                            <li class="to-field">
                                <input type="hidden" name="accordion_num[]" value="<?php echo $accordion_num?>" class="fieldCounter"  />
                                <input type="hidden" name="cs_orderby[]" value="accordions" />
                                <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                            </li>
                        </ul>
                    </div>
            	</div>
                            
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_accordion', 'cs_pb_accordion');
// accordion html form for page builder end

// parallax html form for page builder start
function cs_pb_parallax($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$parallax_element_size = '100';
		$parallax_element = '';
		$parallax_view = '';
		$parallax_height = '';
		$parallax_margin_top = '20';
		$parallax_margin_bottom = '20';
			$parallax_twitter_profile = '';
			$parallax_twitter_num_tweets = '';
			$parallax_back_top = '';
			$parallax_twitter_bgcolor = '';
			$parallax_twitter_bgimg = '';
		$parallax_map_title = '';
		$parallax_map_lat = '';
		$parallax_map_lon = '';
		$parallax_map_zoom = '';
		$parallax_map_type = '';
		$parallax_map_info = '';
		$parallax_map_info_width = '';
		$parallax_map_info_height = '';
		$parallax_map_marker_icon = '';
		$parallax_map_show_marker = '';
		$parallax_map_controls = '';
		$parallax_map_draggable = '';
		$parallax_map_scrollwheel = '';
		$parallax_map_bgcolor = '';
			$parallax_custom_text = '';
			$parallax_custom_img = '';
 			$parallax_custom_bgcolor = '';
		$parallax_album = '';
		$parallax_album_autoplay = '';
		$parallax_album_bgcolor = '';
			$parallax_photo_album_bgcolor = '';
			$parallax_photo_album_title = '';
			$parallax_photo_album_post_per_page = '';
		$parallax_gallery_title = '';
		$parallax_gallery = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$parallax_element_size = $cs_node->parallax_element_size;
			$parallax_element = $cs_node->parallax_element;
			$parallax_view = $cs_node->parallax_view;
			$parallax_height = $cs_node->parallax_height;
			$parallax_margin_top = $cs_node->parallax_margin_top;
			$parallax_margin_bottom = $cs_node->parallax_margin_bottom;
				$parallax_twitter_profile = $cs_node->parallax_twitter_profile;
				$parallax_twitter_num_tweets = $cs_node->parallax_twitter_num_tweets;
 				$parallax_twitter_bgcolor = $cs_node->parallax_twitter_bgcolor;
				$parallax_twitter_bgimg = $cs_node->parallax_twitter_bgimg;
			$parallax_map_title= $cs_node->parallax_map_title;
			$parallax_map_lat= $cs_node->parallax_map_lat;
			$parallax_map_lon= $cs_node->parallax_map_lon;
			$parallax_map_zoom= $cs_node->parallax_map_zoom;
			$parallax_map_type = $cs_node->parallax_map_type;
			$parallax_map_info = $cs_node->parallax_map_info;
			$parallax_map_info_width = $cs_node->parallax_map_info_width;
			$parallax_map_info_height = $cs_node->parallax_map_info_height;
			$parallax_map_marker_icon = $cs_node->parallax_map_marker_icon;
			$parallax_map_show_marker = $cs_node->parallax_map_show_marker;
			$parallax_map_controls = $cs_node->parallax_map_controls;
			$parallax_map_draggable = $cs_node->parallax_map_draggable;
			$parallax_map_scrollwheel = $cs_node->parallax_map_scrollwheel;
			$parallax_map_bgcolor=$cs_node->parallax_map_bgcolor;
				$parallax_custom_text = $cs_node->parallax_custom_text;
				$parallax_custom_img = $cs_node->parallax_custom_img;
				$parallax_back_top = $cs_node->parallax_back_top;
				$parallax_custom_bgcolor = $cs_node->parallax_custom_bgcolor;
			$parallax_album=$cs_node->parallax_album;
			$parallax_album_bgcolor=$cs_node->parallax_album_bgcolor;
			$parallax_album_autoplay = $cs_node->parallax_album_autoplay;
				$parallax_photo_album_bgcolor=$cs_node->parallax_photo_album_bgcolor;
				$parallax_photo_album_title=$cs_node->parallax_photo_album_title;
				$parallax_photo_album_post_per_page=$cs_node->parallax_photo_album_post_per_page;
			$parallax_gallery_title=$cs_node->parallax_gallery_title;
			$parallax_gallery=$cs_node->parallax_gallery;
   			$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column parentdelete column_<?php echo $parallax_element_size?>" item="accordion" data="<?php echo element_size_data_array_index($parallax_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="parallax_element_size[]" class="item" value="<?php echo $parallax_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp; 
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Parallax Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Select View</label></li>
                    <li class="to-field">
                        <select name="parallax_view[]" class="dropdown">
                        	<option <?php if($parallax_view=="parallax-full")echo "selected";?> value="parallax-full">Full Width View</option>
                        	<option <?php if($parallax_view=="parallax-boxed")echo "selected";?> value="parallax-boxed" >Boxed View</option>
                        </select>
                        <p>Please select category to show posts.</p>
                    </li>                                        
                </ul>
                <ul class="form-elements">
                        <li class="to-label"><label>Height</label></li>
                        <li class="to-field"><input type="text" name="parallax_height[]" class="txtfield" value="<?php echo $parallax_height?>" /></li>
                    </ul>
                     <ul class="form-elements">
                        <li class="to-label"><label>Margin Top</label></li>
                        <li class="to-field"><input type="text" name="parallax_margin_top[]" class="txtfield" value="<?php echo $parallax_margin_top?>" />
                        <p>Set the top margin (In PX)</p>
                        </li>
                    </ul>
                     <ul class="form-elements">
                        <li class="to-label"><label>Margin Bottom</label></li>
                        <li class="to-field"><input type="text" name="parallax_margin_bottom[]" class="txtfield" value="<?php echo $parallax_margin_bottom?>" />
                        <p>Set the bottom margin (In PX)</p>
                        </li>
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label"><label>Show Back to Top</label></li>
                        <li class="to-field">
                            <select name="parallax_back_top[]" class="dropdown">
                                <option value="Yes" <?php if($parallax_back_top=="Yes")echo "selected";?> >Yes</option>
                                <option value="No" <?php if($parallax_back_top=="No")echo "selected";?> >No</option>
                            </select>
                        </li>
                    </ul>
            	<ul class="form-elements">
                    <li class="to-label"><label>Select Element</label></li>
                    <li class="to-field">
                    	<select class="dropdown" name="parallax_element[]" onchange="parallax_element(this.value,<?php echo $counter; ?>)">
                        	<option <?php if($parallax_element=="")echo 'selected';?> value="">--- Select One ---</option>
                        	<option <?php if($parallax_element=="album")echo 'selected';?> value="album">Album</option>
                        	<option <?php if($parallax_element=="photo_album")echo 'selected';?> value="photo_album">Photo Album</option>
                        	<option <?php if($parallax_element=="gallery")echo 'selected';?> value="gallery">Gallery</option>
                        	<option <?php if($parallax_element=="twitter")echo 'selected';?> value="twitter">Twitter</option>
                        	<option <?php if($parallax_element=="map")echo 'selected';?> value="map">Map</option>
                        	<option <?php if($parallax_element=="custom")echo 'selected';?> value="custom">Custom</option>
                        </select>
                    </li>
                </ul>
                
                <div id="twitter_form<?php echo $counter;?>" style="display:<?php if($parallax_element == "twitter"){ echo 'inline'; }else{ echo 'none'; }?>"  >
                    <ul class="form-elements">
                        <li class="to-label"><label>Profile</label></li>
                        <li class="to-field"><input type="text" name="parallax_twitter_profile[]" value="<?php echo $parallax_twitter_profile?>" /></li>
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label"><label>No. of tweets</label></li>
                        <li class="to-field"><input type="text" name="parallax_twitter_num_tweets[]" value="<?php echo $parallax_twitter_num_tweets?>" /></li>
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label"><label>Background Color</label></li>
                        <li><input type="text"  name="parallax_twitter_bgcolor[]" class="parallax_twitter_bgcolor" value="<?php echo $parallax_twitter_bgcolor?>" data-default-color=""  /></li>
                        <script type="text/javascript">
                            jQuery(document).ready(function($){
                                $('.parallax_twitter_bgcolor').wpColorPicker(); 
                            });
                        </script>
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label"><label>Background Image Path</label></li>
                        <li class="to-field">
                            <input type="text" name="parallax_twitter_bgimg[]" class="txtfield" value="<?php echo $parallax_twitter_bgimg?>" />
                            <p>e.g. http://yourdomain.com/image.png</p>
                        </li>
                    </ul>
                </div>
               
               <div id="map_form<?php echo $counter;?>" <?php if($parallax_element<>"map")echo 'style="display:none"';?> >
                <ul class="form-elements">
                    <li class="to-label"><label>Title</label></li>
                    <li class="to-field"><input type="text" name="parallax_map_title[]" class="txtfield" value="<?php echo $parallax_map_title?>" /></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Latitude</label></li>
                    <li class="to-field">
                    	<input type="text" name="parallax_map_lat[]" class="txtfield" value="<?php echo $parallax_map_lat?>" />
                        <p>Put Latitude (Default is 0)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Longitude</label></li>
                    <li class="to-field">
                    	<input type="text" name="parallax_map_lon[]" class="txtfield" value="<?php echo $parallax_map_lon?>" />
                        <p>Put Longitude (Default is 0)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Zoom</label></li>
                    <li class="to-field">
                    	<input type="text" name="parallax_map_zoom[]" class="txtfield" value="<?php echo $parallax_map_zoom?>" />
                        <p>Put Zoom Level (Default is 11)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Map Types</label></li>
                    <li class="to-field">
                        <select name="parallax_map_type[]" class="dropdown" >
                            <option <?php if($parallax_map_type=="ROADMAP")echo "selected";?> >ROADMAP</option>
                            <option <?php if($parallax_map_type=="HYBRID")echo "selected";?> >HYBRID</option>
                            <option <?php if($parallax_map_type=="SATELLITE")echo "selected";?> >SATELLITE</option>
                            <option <?php if($parallax_map_type=="TERRAIN")echo "selected";?> >TERRAIN</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Info Text</label></li>
                    <li class="to-field"><input type="text" name="parallax_map_info[]" class="txtfield" value="<?php echo $parallax_map_info?>" /></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Info Max Width</label></li>
                    <li class="to-field">
                    	<input type="text" name="parallax_map_info_width[]" class="txtfield" value="<?php echo $parallax_map_info_width?>" />
                        <p>Info Max Width in PX (Default is 200)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Info Max Height</label></li>
                    <li class="to-field">
                    	<input type="text" name="parallax_map_info_height[]" class="txtfield" value="<?php echo $parallax_map_info_height?>" />
                        <p>Info Max Height in PX (Default is 100)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Marker Icon Path</label></li>
                    <li class="to-field">
                    	<input type="text" name="parallax_map_marker_icon[]" class="txtfield" value="<?php echo $parallax_map_marker_icon?>" />
                        <p>e.g. http://yourdomain.com/logo.png</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Show Marker</label></li>
                    <li class="to-field">
                        <select name="parallax_map_show_marker[]" class="dropdown" >
                            <option value="true" <?php if($parallax_map_show_marker=="true")echo "selected";?> >On</option>
                            <option value="false" <?php if($parallax_map_show_marker=="false")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Disable Map Controls</label></li>
                    <li class="to-field">
                        <select name="parallax_map_controls[]" class="dropdown" >
                            <option value="false" <?php if($parallax_map_controls=="false")echo "selected";?> >Off</option>
                            <option value="true" <?php if($parallax_map_controls=="true")echo "selected";?> >On</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Draggable</label></li>
                    <li class="to-field">
                        <select name="parallax_map_draggable[]" class="dropdown" >
                            <option value="true" <?php if($parallax_map_draggable=="true")echo "selected";?> >On</option>
                            <option value="false" <?php if($parallax_map_draggable=="false")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Scroll Wheel</label></li>
                    <li class="to-field">
                        <select name="parallax_map_scrollwheel[]" class="dropdown" >
                            <option value="true" <?php if($parallax_map_scrollwheel=="true")echo "selected";?> >On</option>
                            <option value="false" <?php if($parallax_map_scrollwheel=="false")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                 
                <ul class="form-elements">
                        <li class="to-label"><label>Background Color</label></li>
                        <li><input type="text"  name="parallax_map_bgcolor[]" class="parallax_map_bgcolor" value="<?php echo $parallax_map_bgcolor?>" data-default-color=""  /></li>
                        <script type="text/javascript">
                            jQuery(document).ready(function($){
                                $('.parallax_map_bgcolor').wpColorPicker(); 
                            });
                        </script>
                    </ul>
                </div>

                <div id="custom_form<?php echo $counter;?>" <?php if($parallax_element<>"custom")echo 'style="display:none"';?> >
                    <ul class="form-elements">
                        <li class="to-label"><label>Text</label></li>
                        <li class="to-field"><textarea name="parallax_custom_text[]"><?php echo $parallax_custom_text?></textarea></li>
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label"><label>Image Path</label></li>
                        <li class="to-field">
                            <input type="text" name="parallax_custom_img[]" class="txtfield" value="<?php echo $parallax_custom_img?>" />
                            <p>e.g. http://yourdomain.com/logo.png</p>
                        </li>
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label"><label>Background Color</label></li>
                        <li><input type="text"  name="parallax_custom_bgcolor[]" class="parallax_custom_bgcolor" value="<?php echo $parallax_custom_bgcolor?>" data-default-color=""  /></li>
                        <script type="text/javascript">
                            jQuery(document).ready(function($){
                                $('.parallax_custom_bgcolor').wpColorPicker(); 
                            });
                        </script>
                    </ul>
                </div>
                
                <div id="album_form<?php echo $counter;?>" <?php if($parallax_element<>"album")echo 'style="display:none"';?> >
                    <ul class="form-elements">
                        <li class="to-label"><label>Select Album</label></li>
                        <li class="to-field">
                            <select name="parallax_album[]" class="dropdown">
                                <option value="0"></option>
                                <?php
                                    query_posts( array('posts_per_page' => "-1", 'post_status' => 'publish', 'post_type' => 'albums') );
                                        while ( have_posts()) : the_post();
                                        ?>
                                            <option <?php if($parallax_album==get_the_ID())echo "selected"?> value="<?php the_ID()?>"><?php the_title()?></option>
                                        <?php
                                        endwhile;
                                ?>
                            </select>
                        </li>
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label"><label>Auto Play</label></li>
                        <li class="to-field">
                            <select name="parallax_album_autoplay[]" class="dropdown" >
                                <option value="true" <?php if($parallax_album_autoplay=="true")echo "selected";?> >On</option>
                                <option value="false" <?php if($parallax_album_autoplay=="false")echo "selected";?> >Off</option>
                            </select>
                        </li>
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label"><label>Background Color</label></li>
                        <li><input type="text"  name="parallax_album_bgcolor[]" class="parallax_album_bgcolor" value="<?php echo $parallax_album_bgcolor?>" data-default-color=""  /></li>
                        <script type="text/javascript">
                            jQuery(document).ready(function($){
                                $('.parallax_album_bgcolor').wpColorPicker(); 
                            });
                        </script>
                    </ul>
                </div>
                
                <div id="photo_album_form<?php echo $counter;?>" <?php if($parallax_element<>"photo_album")echo 'style="display:none"';?> >
					<ul class="form-elements">
                        <li class="to-label"><label>Title</label></li>
                        <li class="to-field"><input type="text" name="parallax_photo_album_title[]" value="<?php echo $parallax_photo_album_title?>" /></li>
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label"><label>Post Per Page</label></li>
                        <li class="to-field">
                        	<input type="text" name="parallax_photo_album_post_per_page[]" value="<?php echo $parallax_photo_album_post_per_page?>" />
                            <p>To display all the records, leave this field blank.</p>
                        </li>
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label"><label>Background Color</label></li>
                        <li><input type="text"  name="parallax_photo_album_bgcolor[]" class="parallax_photo_album_bgcolor" value="<?php echo $parallax_photo_album_bgcolor?>" data-default-color=""  /></li>
                        <script type="text/javascript">
                            jQuery(document).ready(function($){
                                $('.parallax_photo_album_bgcolor').wpColorPicker();
                            });
                        </script>
                    </ul>
                </div>
                
                <div id="gallery_form<?php echo $counter;?>" <?php if($parallax_element<>"gallery")echo 'style="display:none"';?> >
                	<ul class="form-elements">
                        <li class="to-label"><label>Title</label></li>
                        <li class="to-field"><input type="text" name="parallax_gallery_title[]" value="<?php echo $parallax_gallery_title?>" /></li>
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label"><label>Select Gallery</label></li>
                        <li class="to-field">
                            <select name="parallax_gallery[]" class="dropdown">
                                <option value="0"></option>
                                <?php
                                    query_posts( array('posts_per_page' => "-1", 'post_status' => 'publish', 'post_type' => 'cs_gallery') );
                                        while ( have_posts()) : the_post();
                                        ?>
                                            <option <?php if($parallax_gallery==get_the_ID())echo "selected"?> value="<?php the_ID()?>"><?php the_title()?></option>
                                        <?php
                                        endwhile;
                                ?>
                            </select>
                        </li>
                    </ul>
                </div>
                
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="parallax" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_parallax', 'cs_pb_parallax');
// parallax html form for page builder end

// page bulider items end

// side bar layout in pages, post and default page(theme options) start
function cs_meta_layout(){
	global $cs_xmlObject;
	if ( empty($cs_xmlObject->sidebar_layout->cs_layout) ) $cs_layout = ""; else $cs_layout = $cs_xmlObject->sidebar_layout->cs_layout;
	if ( empty($cs_xmlObject->sidebar_layout->cs_sidebar_left) ) $cs_sidebar_left = ""; else $cs_sidebar_left = $cs_xmlObject->sidebar_layout->cs_sidebar_left;
	if ( empty($cs_xmlObject->sidebar_layout->cs_sidebar_right) ) $cs_sidebar_right = ""; else $cs_sidebar_right = $cs_xmlObject->sidebar_layout->cs_sidebar_right;
  ?>
	<div class="elementhidden">
        <div class="clear"></div>
    	<div class="opt-head">
            <h4>Layout Options</h4>
            <div class="clear"></div>
        </div>
        <ul class="form-elements">
            <li class="to-label">
                <label>Select Layout</label>
            </li>
            <li class="to-field">
                <div class="meta-input">
                    <div class='radio-image-wrapper'>
                        <input <?php if($cs_layout=="none")echo "checked"?> onclick="show_sidebar('none')" type="radio" name="cs_layout" class="radio" value="none" id="radio_1" />
                        <label for="radio_1">
                            <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/admin/1.gif"  alt="" /></span>
                            <span <?php if($cs_layout=="none")echo "class='check-list'"?> id="check-list"><img src="<?php echo get_template_directory_uri()?>/images/admin/1-hover.gif" alt="" /></span>
                        </label>
                    </div>
                    <div class='radio-image-wrapper'>
                        <input <?php if($cs_layout=="right")echo "checked"?> onclick="show_sidebar('right')" type="radio" name="cs_layout" class="radio" value="right" id="radio_2"  />
                        <label for="radio_2">
                            <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/admin/2.gif" alt="" /></span>
                            <span <?php if($cs_layout=="right")echo "class='check-list'"?> id="check-list"><img src="<?php echo get_template_directory_uri()?>/images/admin/2-hover.gif" alt="" /></span>
                        </label>
                    </div>
                    <div class='radio-image-wrapper'>
                        <input <?php if($cs_layout=="left")echo "checked"?> onclick="show_sidebar('left')" type="radio" name="cs_layout" class="radio" value="left" id="radio_3" />
                        <label for="radio_3">
                            <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/admin/3.gif" alt="" /></span>
                            <span <?php if($cs_layout=="left")echo "class='check-list'"?> id="check-list"><img src="<?php echo get_template_directory_uri()?>/images/admin/3-hover.gif" alt="" /></span>
                        </label>
                    </div>
                </div>
            </li>
        </ul>
        <ul class="form-elements meta-body" style=" <?php if($cs_sidebar_left == ""){echo "display:none";}else echo "display:block";?>" id="sidebar_left" >
            <li class="to-label">
                <label>Select Left Sidebar</label>
            </li>
            <li class="to-field">
                <select name="cs_sidebar_left" class="select_dropdown" id="page-option-choose-left-sidebar">
                    <?php
                    $cs_theme_option = get_option('cs_theme_option');
                    if ( isset($cs_theme_option['sidebar']) and count($cs_theme_option['sidebar']) > 0 ) {
                        foreach ( $cs_theme_option['sidebar'] as $sidebar ){
                        ?>
                            <option <?php if ($cs_sidebar_left==$sidebar)echo "selected";?> ><?php echo $sidebar;?></option>
                        <?php
                        }
                    }
                    ?>
                </select>
            </li>
        </ul>
        <ul class="form-elements meta-body" style=" <?php if($cs_sidebar_right == ""){echo "display:none";}else echo "display:block";?>" id="sidebar_right" >
            <li class="to-label">
                <label>Select Right Sidebar</label>
            </li>
            <li class="to-field">
                <select name="cs_sidebar_right" class="select_dropdown" id="page-option-choose-right-sidebar">
                    <?php
                    if ( isset($cs_theme_option['sidebar']) and count($cs_theme_option['sidebar']) > 0 ) {
                        foreach ( $cs_theme_option['sidebar'] as $sidebar ){
                        ?>
                            <option <?php if ($cs_sidebar_right==$sidebar)echo "selected";?> ><?php echo $sidebar;?></option>
                        <?php
                        }
                    }
                    ?>
                </select>
                <input type="hidden" name="cs_orderby[]" value="meta_layout" />
            </li>
        </ul>
	</div>
	<div class="clear"></div>
<?php	
}
// side bar layout in pages, post and default page(theme options) end

// get element size
function element_size_data_array_index($size){
	if ( $size == "" or $size == 100 ) return 0;
	else if ( $size == 75 ) return 1;
	else if ( $size == 50 ) return 2;
	else if ( $size == 25 ) return 3;
}
// Show all Categories
function show_all_cats($parent, $separator, $selected = "", $taxonomy) {
    if ($parent == "") {
        global $wpdb;
        $parent = 0;
    }
    else
        $separator .= " &ndash; ";
    $args = array(
        'parent' => $parent,
        'hide_empty' => 0,
        'taxonomy' => $taxonomy
    );
    $categories = get_categories($args);
    foreach ($categories as $category) {
        ?>
        <option <?php if ($selected == $category->slug) echo "selected"; ?> value="<?php echo $category->slug ?>"><?php echo $separator . $category->cat_name ?></option>
        <?php
        show_all_cats($category->term_id, $separator, $selected, $taxonomy);
    }
}
// Events Meta data save
function cs_events_meta_save($cs_post_id) {
    global $wpdb;
    if (empty($_POST["sub_title"])){ $_POST["sub_title"] = "";}
    if (empty($_POST["header_banner_options"])){ $_POST["header_banner_options"] = "";}
    if (empty($_POST["header_banner"])){ $_POST["header_banner"] = "";}
    if (empty($_POST["slider_id"])){ $_POST["slider_id"] = "";}
    if (empty($_POST["inside_event_thumb_view"])){ $_POST["inside_event_thumb_view"] = "";}
    if (empty($_POST["inside_event_featured_image_as_thumbnail"])){ $_POST["inside_event_featured_image_as_thumbnail"] = "";}
	if (empty($_POST["inside_event_thumb_audio"])){ $_POST["inside_event_thumb_audio"] = "";}
	if (empty($_POST["inside_event_thumb_video"])){ $_POST["inside_event_thumb_video"] = "";}
	if (empty($_POST["inside_event_thumb_slider"])){ $_POST["inside_event_thumb_slider"] = "";}
	if (empty($_POST["inside_event_thumb_slider_type"])){ $_POST["inside_event_thumb_slider_type"] = "";}
	if (empty($_POST["inside_event_thumb_map_lat"])){ $_POST["inside_event_thumb_map_lat"] = "";}
    if (empty($_POST["inside_event_thumb_map_lon"])){ $_POST["inside_event_thumb_map_lon"] = "";}
    if (empty($_POST["inside_event_thumb_map_zoom"])){ $_POST["inside_event_thumb_map_zoom"] = "";}
    if (empty($_POST["inside_event_thumb_map_address"])){ $_POST["inside_event_thumb_map_address"] = "";}
    if (empty($_POST["inside_event_thumb_map_controls"])){ $_POST["inside_event_thumb_map_controls"] = "";}
    if (empty($_POST["event_social_sharing"])){ $_POST["event_social_sharing"] = "";}
	if (empty($_POST["event_related"])){ $_POST["event_related"] = "";}
	if (empty($_POST["inside_event_related_post_title"])){ $_POST["inside_event_related_post_title"] = "";}
	if (empty($_POST["switch_footer_widgets"])){ $_POST["switch_footer_widgets"] = "";}
	if (empty($_POST["event_start_time"])){ $_POST["event_start_time"] = "";}
	if (empty($_POST["event_end_time"])){ $_POST["event_end_time"] = "";}
    if (empty($_POST["event_all_day"])){ $_POST["event_all_day"] = "";}
    if (empty($_POST["event_rating"])){ $_POST["event_rating"] = "";}
    if (empty($_POST["event_buy_now"])){ $_POST["event_buy_now"] = "";}
    if (empty($_POST["event_ticket_price"])){ $_POST["event_ticket_price"] = "";}
    if (empty($_POST["event_gallery"])){ $_POST["event_gallery"] = "";}
    if (empty($_POST["event_address"])){ $_POST["event_address"] = "";}
    if (empty($_POST["event_map"])){ $_POST["event_map"] = "";}
    if (empty($_POST["event_artists"])){ $_POST["event_artists"] = "";}
    	
    $sxe = new SimpleXMLElement("<event></event>");
		$sxe->addChild('sub_title', $_POST['sub_title'] );
		$sxe->addChild('header_banner_options', $_POST['header_banner_options'] );
		$sxe->addChild('header_banner', $_POST['header_banner'] );
		$sxe->addChild('slider_id', $_POST['slider_id'] );
		$sxe->addChild('inside_event_thumb_view', $_POST['inside_event_thumb_view'] );
		$sxe->addChild('inside_event_featured_image_as_thumbnail', $_POST['inside_event_featured_image_as_thumbnail'] );
		$sxe->addChild('inside_event_thumb_audio', $_POST['inside_event_thumb_audio'] );
		$sxe->addChild('inside_event_thumb_video', $_POST['inside_event_thumb_video'] );
		$sxe->addChild('inside_event_thumb_slider', $_POST['inside_event_thumb_slider'] );
		$sxe->addChild('inside_event_thumb_slider_type', $_POST['inside_event_thumb_slider_type'] );
		$sxe->addChild('inside_event_thumb_map_lat', $_POST['inside_event_thumb_map_lat'] );
		$sxe->addChild('inside_event_thumb_map_lon', $_POST['inside_event_thumb_map_lon'] );
		$sxe->addChild('inside_event_thumb_map_zoom', $_POST['inside_event_thumb_map_zoom'] );
		$sxe->addChild('inside_event_thumb_map_address', $_POST['inside_event_thumb_map_address'] );
		$sxe->addChild('inside_event_thumb_map_controls', $_POST['inside_event_thumb_map_controls'] );
		$sxe->addChild('event_social_sharing', $_POST["event_social_sharing"]);
		$sxe->addChild('event_related', $_POST["event_related"]);
		$sxe->addChild('inside_event_related_post_title', $_POST["inside_event_related_post_title"]);
		$sxe->addChild('switch_footer_widgets', $_POST["switch_footer_widgets"]);
 		$sxe->addChild('event_start_time', $_POST["event_start_time"]);
		$sxe->addChild('event_end_time', $_POST["event_end_time"]);
		$sxe->addChild('event_all_day', $_POST["event_all_day"]);
		$sxe->addChild('event_rating', $_POST["event_rating"]);
		$sxe->addChild('event_buy_now', $_POST["event_buy_now"]);
		$sxe->addChild('event_ticket_price', $_POST["event_ticket_price"]);
		$sxe->addChild('event_gallery', $_POST["event_gallery"]);
 		$sxe->addChild('event_address', $_POST["event_address"]);
		$sxe->addChild('event_map', $_POST["event_map"]);
			if ( $_POST['event_artists'] ) {
				$artists_list = $sxe->addChild('artists_list');
				foreach ( $_POST['event_artists'] as $key => $val ) {
					$artists_list->addChild('artists', $val );
				}
			}
    $sxe = save_layout_xml($sxe);
    update_post_meta($cs_post_id, 'cs_event_meta', $sxe->asXML());
}
// Get Google Fonts
function cs_get_google_fonts() {
    $fonts = array("Abel", "Aclonica", "Acme", "Actor", "Advent Pro", "Aldrich", "Allerta", "Allerta Stencil", "Amaranth", "Andika", "Anonymous Pro", "Antic", "Anton", "Arimo", "Armata", "Asap", "Asul",
        "Basic", "Belleza", "Cabin", "Cabin Condensed", "Cagliostro", "Candal", "Cantarell", "Carme", "Chau Philomene One", "Chivo", "Coda Caption", "Comfortaa", "Convergence", "Cousine", "Cuprum", "Days One",
        "Didact Gothic", "Doppio One", "Dorsa", "Dosis", "Droid Sans", "Droid Sans Mono", "Duru Sans", "Economica", "Electrolize", "Exo", "Federo", "Francois One", "Fresca", "Galdeano", "Geo", "Gudea",
        "Hammersmith One", "Homenaje", "Imprima", "Inconsolata", "Inder", "Istok Web", "Jockey One", "Josefin Sans", "Jura", "Karla", "Krona One", "Lato", "Lekton", "Magra", "Mako", "Marmelad", "Marvel",
        "Maven Pro", "Metrophobic", "Michroma", "Molengo", "Montserrat", "Muli", "News Cycle", "Nobile", "Numans", "Nunito", "Open Sans", "Open Sans Condensed", "Orbitron", "Oswald", "Oxygen", "PT Mono",
        "PT Sans", "PT Sans Caption", "PT Sans Narrow", "Paytone One", "Philosopher", "Play", "Pontano Sans", "Port Lligat Sans", "Puritan", "Quantico", "Quattrocento Sans", "Questrial", "Quicksand", "Rationale",
        "Ropa Sans", "Rosario", "Ruda", "Ruluko", "Russo One", "Shanti", "Sigmar One", "Signika", "Signika Negative", "Six Caps", "Snippet", "Spinnaker", "Syncopate", "Telex", "Tenor Sans", "Ubuntu",
        "Ubuntu Condensed", "Ubuntu Mono", "Varela", "Varela Round", "Viga", "Voltaire", "Wire One", "Yanone Kaffeesatz", "Adamina", "Alegreya", "Alegreya SC", "Alice", "Alike", "Alike Angular", "Almendra",
        "Almendra SC", "Amethysta", "Andada", "Antic Didone", "Antic Slab", "Arapey", "Artifika", "Arvo", "Average", "Balthazar", "Belgrano", "Bentham", "Bevan", "Bitter", "Brawler", "Bree Serif", "Buenard",
        "Cambo", "Cantata One", "Cardo", "Caudex", "Copse", "Coustard", "Crete Round", "Crimson Text", "Cutive", "Della Respira", "Droid Serif", "EB Garamond", "Enriqueta", "Esteban", "Fanwood Text", "Fjord One",
        "Gentium Basic", "Gentium Book Basic", "Glegoo", "Goudy Bookletter 1911", "Habibi", "Holtwood One SC", "IM Fell DW Pica", "IM Fell DW Pica SC", "IM Fell Double Pica", "IM Fell Double Pica SC",
        "IM Fell English", "IM Fell English SC", "IM Fell French Canon", "IM Fell French Canon SC", "IM Fell Great Primer", "IM Fell Great Primer SC", "Inika", "Italiana", "Josefin Slab", "Judson", "Junge",
        "Kameron", "Kotta One", "Kreon", "Ledger", "Linden Hill", "Lora", "Lusitana", "Lustria", "Marko One", "Mate", "Mate SC", "Merriweather", "Montaga", "Neuton", "Noticia Text", "Old Standard TT", "Ovo",
        "PT Serif", "PT Serif Caption", "Petrona", "Playfair Display", "Podkova", "Poly", "Port Lligat Slab", "Prata", "Prociono", "Quattrocento", "Radley", "Rokkitt", "Rosarivo", "Simonetta", "Sorts Mill Goudy",
        "Stoke", "Tienne", "Tinos", "Trocchi", "Trykker", "Ultra", "Unna", "Vidaloka", "Volkhov", "Vollkorn", "Abril Fatface", "Aguafina Script", "Aladin", "Alex Brush", "Alfa Slab One", "Allan", "Allura",
        "Amatic SC", "Annie Use Your Telescope", "Arbutus", "Architects Daughter", "Arizonia", "Asset", "Astloch", "Atomic Age", "Aubrey", "Audiowide", "Averia Gruesa Libre", "Averia Libre", "Averia Sans Libre",
        "Averia Serif Libre", "Bad Script", "Bangers", "Baumans", "Berkshire Swash", "Bigshot One", "Bilbo", "Bilbo Swash Caps", "Black Ops One", "Bonbon", "Boogaloo", "Bowlby One", "Bowlby One SC",
        "Bubblegum Sans", "Buda", "Butcherman", "Butterfly Kids", "Cabin Sketch", "Caesar Dressing", "Calligraffitti", "Carter One", "Cedarville Cursive", "Ceviche One", "Changa One", "Chango", "Chelsea Market",
        "Cherry Cream Soda", "Chewy", "Chicle", "Coda", "Codystar", "Coming Soon", "Concert One", "Condiment", "Contrail One", "Cookie", "Corben", "Covered By Your Grace", "Crafty Girls", "Creepster", "Crushed",
        "Damion", "Dancing Script", "Dawning of a New Day", "Delius", "Delius Swash Caps", "Delius Unicase", "Devonshire", "Diplomata", "Diplomata SC", "Dr Sugiyama", "Dynalight", "Eater", "Emblema One",
        "Emilys Candy", "Engagement", "Erica One", "Euphoria Script", "Ewert", "Expletus Sans", "Fascinate", "Fascinate Inline", "Federant", "Felipa", "Flamenco", "Flavors", "Fondamento", "Fontdiner Swanky",
        "Forum", "Fredericka the Great", "Fredoka One", "Frijole", "Fugaz One", "Geostar", "Geostar Fill", "Germania One", "Give You Glory", "Glass Antiqua", "Gloria Hallelujah", "Goblin One", "Gochi Hand",
        "Gorditas", "Graduate", "Gravitas One", "Great Vibes", "Gruppo", "Handlee", "Happy Monkey", "Henny Penny", "Herr Von Muellerhoff", "Homemade Apple", "Iceberg", "Iceland", "Indie Flower", "Irish Grover",
        "Italianno", "Jim Nightshade", "Jolly Lodger", "Julee", "Just Another Hand", "Just Me Again Down Here", "Kaushan Script", "Kelly Slab", "Kenia", "Knewave", "Kranky", "Kristi", "La Belle Aurore",
        "Lancelot", "League Script", "Leckerli One", "Lemon", "Lilita One", "Limelight", "Lobster", "Lobster Two", "Londrina Outline", "Londrina Shadow", "Londrina Sketch", "Londrina Solid",
        "Love Ya Like A Sister", "Loved by the King", "Lovers Quarrel", "Luckiest Guy", "Macondo", "Macondo Swash Caps", "Maiden Orange", "Marck Script", "Meddon", "MedievalSharp", "Medula One", "Megrim",
        "Merienda One", "Metamorphous", "Miltonian", "Miltonian Tattoo", "Miniver", "Miss Fajardose", "Modern Antiqua", "Monofett", "Monoton", "Monsieur La Doulaise", "Montez", "Mountains of Christmas",
        "Mr Bedfort", "Mr Dafoe", "Mr De Haviland", "Mrs Saint Delafield", "Mrs Sheppards", "Mystery Quest", "Neucha", "Niconne", "Nixie One", "Norican", "Nosifer", "Nothing You Could Do", "Nova Cut",
        "Nova Flat", "Nova Mono", "Nova Oval", "Nova Round", "Nova Script", "Nova Slim", "Nova Square", "Oldenburg", "Oleo Script", "Original Surfer", "Over the Rainbow", "Overlock", "Overlock SC", "Pacifico",
        "Parisienne", "Passero One", "Passion One", "Patrick Hand", "Patua One", "Permanent Marker", "Piedra", "Pinyon Script", "Plaster", "Playball", "Poiret One", "Poller One", "Pompiere", "Press Start 2P",
        "Princess Sofia", "Prosto One", "Qwigley", "Raleway", "Rammetto One", "Rancho", "Redressed", "Reenie Beanie", "Revalia", "Ribeye", "Ribeye Marrow", "Righteous", "Rochester", "Rock Salt", "Rouge Script",
        "Ruge Boogie", "Ruslan Display", "Ruthie", "Sail", "Salsa", "Sancreek", "Sansita One", "Sarina", "Satisfy", "Schoolbell", "Seaweed Script", "Sevillana", "Shadows Into Light", "Shadows Into Light Two",
        "Share", "Shojumaru", "Short Stack", "Sirin Stencil", "Slackey", "Smokum", "Smythe", "Sniglet", "Sofia", "Sonsie One", "Special Elite", "Spicy Rice", "Spirax", "Squada One", "Stardos Stencil",
        "Stint Ultra Condensed", "Stint Ultra Expanded", "Sue Ellen Francisco", "Sunshiney", "Supermercado One", "Swanky and Moo Moo", "Tangerine", "The Girl Next Door", "Titan One", "Trade Winds", "Trochut",
        "Tulpen One", "Uncial Antiqua", "UnifrakturCook", "UnifrakturMaguntia", "Unkempt", "Unlock", "VT323", "Vast Shadow", "Vibur", "Voces", "Waiting for the Sunrise", "Wallpoet", "Walter Turncoat",
        "Wellfleet", "Yellowtail", "Yeseva One", "Yesteryear", "Zeyada");
    return $fonts;
}

//Countries Array
function cs_get_countries() {
    $get_countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan",
        "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "British Virgin Islands",
        "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China",
        "Colombia", "Comoros", "Costa Rica", "Croatia", "Cuba", "Cyprus", "Czech Republic", "Democratic People's Republic of Korea", "Democratic Republic of the Congo", "Denmark", "Djibouti",
        "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "England", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Fiji", "Finland", "France", "French Polynesia",
        "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea Bissau", "Guyana", "Haiti", "Honduras", "Hong Kong",
        "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Kosovo", "Kuwait", "Kyrgyzstan",
        "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macao", "Macedonia", "Madagascar", "Malawi", "Malaysia",
        "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mauritius", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique",
        "Myanmar(Burma)", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Northern Ireland",
        "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Palestine", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Puerto Rico",
        "Qatar", "Republic of the Congo", "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa",
        "San Marino", "Saudi Arabia", "Scotland", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa",
        "South Korea", "Spain", "Sri Lanka", "Sudan", "Suriname", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Timor-Leste", "Togo", "Tonga",
        "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "US Virgin Islands", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay",
        "Uzbekistan", "Vanuatu", "Vatican", "Venezuela", "Vietnam", "Wales", "Yemen", "Zambia", "Zimbabwe");
    return $get_countries;
}

// Default xml data save
function save_layout_xml($sxe) {
	
	if (empty($_POST['page_title']))
        $_POST['page_title'] = "";
    if (empty($_POST['cs_layout']))
        $_POST['cs_layout'] = "";
    if (empty($_POST['cs_sidebar_left']))
        $_POST['cs_sidebar_left'] = "";
    if (empty($_POST['cs_sidebar_right']))
        $_POST['cs_sidebar_right'] = "";
	$sxe->addChild('page_title', $_POST['page_title']);
	$sidebar_layout = $sxe->addChild('sidebar_layout');
		$sidebar_layout->addChild('cs_layout', $_POST["cs_layout"]);
		if ($_POST["cs_layout"] == "left") {
			$sidebar_layout->addChild('cs_sidebar_left', $_POST['cs_sidebar_left']);
		} else if ($_POST["cs_layout"] == "right") {
			$sidebar_layout->addChild('cs_sidebar_right', $_POST['cs_sidebar_right']);
		}else if ($_POST["cs_layout"] == "both_right" or $_POST["cs_layout"] == "both_left" or $_POST["cs_layout"] == "both") {
			$sidebar_layout->addChild('cs_sidebar_left', $_POST['cs_sidebar_left']);
			$sidebar_layout->addChild('cs_sidebar_right', $_POST['cs_sidebar_right']);
		}
    return $sxe;
}

// Ddefine default headers array for theme activation
	global $pagenow, $header1_default_colors, $header2_default_colors, $header3_default_colors, $header4_default_colors, $header5_default_colors;
            $header1_default_colors = array(
             //Header 1 array
			'header_1_logo' => 'on',
			'header_1_social' => 'on',
            'header_1_login' => 'on',
            'header_1_bgcolor' => '#000000',
            'header_1_strip' => 'on',
            'header_1_top_strip_menu' => 'top-menu',
            'header_1_top_strip_right_area_text' => '(+00) 12 345 678 910, info@Rockyband.com',
            'header_1_top_strip_bg_color' => '#1D1D1D',
            'header_1_top_strip_color' => '#999999',
			
			'header_1_nav_bgcolr' => '',
			'header_1_nav_color' => '#bbbbbb',
			'header_1_nav_hover_color' => '#ef5d00',
			'header_1_nav_hover_bgcolor' => '',
			'header_1_nav_active_color' => '#ef5d00',
			'header_1_subnav_bgcolr' => '#DADADA',
			'header_1_subnav_color' => '#000000',
			'header_1_subnav_hover_color' => '#fff',
			'header_1_subnav_hover_bgcolor' => '#ef5d00',
			'header_1_subnav_active_color' => '#fff',
			'header_1_subnav_active_bgcolor' => '#ef5d00',
			// sub header
			'header_1_subheader_bgcolor' => '#ef5d00',
			'header_1_subheader_link_color' => '#8a8a8a',
			'header_1_subheader_title_color' => '#ffffff',
			'header_1_subheader_subtitle_color' => '#ffffff'
            );
            $header2_default_colors = array(
            //Header 2 array
            'header_2_strip' => 'on',
			'header_2_social' => 'on',
            'header_2_top_strip_menu' => 'top-menu',
            'header_2_top_strip_right_area_text' => '(+00) 12 345 678 910, info@Rockyband.com',
            'header_2_top_strip_bg_color' => '#0d0d0d',
            'header_2_top_strip_color' => '#999999',

			'header_2_bg_color' => '#191919',
			'header_2_login' => 'on',
			'header_2_logo' => 'on',
			'header_2_nav_bgcolr' => '#191919',
			'header_2_nav_color' => '#bbbbbb',
			'header_2_nav_hover_color' => '#ef5d00',
			'header_2_nav_active_color' => '#ef5d00',
			'header_2_subnav_bgcolr' => '#DADADA',
			'header_2_subnav_color' => '#000000',
			'header_2_subnav_hover_color' => '#fff',
			'header_2_subnav_hover_bgcolor' => '#ef5d00',
			'header_2_subnav_active_color' => '#fff',
			'header_2_subnav_active_bgcolor' => '#ef5d00',
			// sub header
			'header_2_subheader_bgcolor' => '#ef5d00',
			'header_2_subheader_link_color' => '#8a8a8a',
			'header_2_subheader_title_color' => '#ffffff'
            );
            $header3_default_colors = array(
                        //Header 3 array
			'header_3_bg_color' => '#191919',
			'header_3_login' => 'on',
			'header_3_logo' => 'on',
			'header_3_social_icons' => '',
			'header_3_nav_color' => '#bbbbbb',
			'header_3_nav_hover_color' => '#ef5d00',
			'header_3_nav_active_color' => '#ef5d00',
			'header_3_subnav_bgcolr' => '#DADADA',
			'header_3_subnav_color' => '#000000',
			'header_3_subnav_hover_color' => '#fff',
			'header_3_subnav_hover_bgcolor' => '#ef5d00',
			'header_3_subnav_active_color' => '#fff',
			'header_3_subnav_active_bgcolor' => '#ef5d00',
			// sub header
			'header_3_subheader_bgcolor' => '#ef5d00',
			'header_3_subheader_link_color' => '#8a8a8a',
			'header_3_subheader_title_color' => '#ffffff'
            );
            $header4_default_colors = array(
                        //Header 4 array
			'header_4_bg_color' => '#191919',
			'header_4_logo' => 'on',
			'header_4_login' => 'on',
			'header_4_nav_color' => '#bbbbbb',
			'header_4_nav_hover_color' => '#ef5d00',
			'header_4_nav_hover_bgcolor' => '',
			'header_4_nav_active_color' => '#ef5d00',
			'header_4_subnav_bgcolr' => '#DADADA',
			'header_4_subnav_color' => '#000000',
			'header_4_subnav_hover_color' => '#fff',
			'header_4_subnav_hover_bgcolor' => '#ef5d00',
			'header_4_subnav_active_color' => '#fff',
			'header_4_subnav_active_bgcolor' => '#ef5d00',
			// sub header
			'header_4_subheader_bgcolor' => '#ef5d00',
			'header_4_subheader_link_color' => '#8a8a8a',
			'header_4_subheader_title_color' => '#ffffff'
            );
            $header5_default_colors = array(
            //Header 5 array
			'header_5_bg_color' => '#191919',
			'header_5_adv' => get_template_directory_uri().'/images/img-bannertop.jpg',
			'header_5_adv_link' => '#',
			'header_5_logo' => 'on',
			'header_5_nav_bgcolr' => '#141414',
			'header_5_nav_color' => '#bbbbbb',
			'header_5_nav_hover_color' => '#ef5d00',
			'header_5_nav_hover_bgcolor' => '',
			'header_5_nav_active_color' => '#ef5d00',
			'header_5_subnav_bgcolr' => '#DADADA',
			'header_5_subnav_color' => '#000000',
			'header_5_subnav_hover_color' => '#fff',
			'header_5_subnav_hover_bgcolor' => '#ef5d00',
			'header_5_subnav_active_color' => '#fff',
			'header_5_subnav_active_bgcolor' => '#ef5d00',
			// sub header
			'header_5_subheader_bgcolor' => '#ef5d00',
			'header_5_subheader_link_color' => '#8a8a8a',
			'header_5_subheader_title_color' => '#ffffff'
            );
	if (is_admin() && isset($_GET['activated']) && $pagenow == 'themes.php'){
		
	// Theme default widgets activation
    add_action('admin_head', 'cs_activate_widget');
	function cs_activate_widget(){
		$sidebars_widgets = get_option('sidebars_widgets');  //collect widget informations
		// ---- calendar widget setting---
		$calendar = array();
		$calendar[1] = array(
		"title"		=>	'Calendar'
		);
						
		$calendar['_multiwidget'] = '1';
		update_option('widget_calendar',$calendar);
		$calendar = get_option('widget_calendar');
		krsort($calendar);
		foreach($calendar as $key1=>$val1)
		{
			$calendar_key = $key1;
			if(is_int($calendar_key))
			{
				break;
			}
		}
		//---Blog Categories
		$categories = array();
		$categories[1] = array(
		"title"		=>	'Blog Categories',
		"count" => ''
		);
						
		$calendar['_multiwidget'] = '1';
		update_option('widget_categories',$categories);
		$categories = get_option('widget_categories');
		krsort($categories);
		foreach($categories as $key1=>$val1)
		{
			$categories_key = $key1;
			if(is_int($categories_key))
			{
				break;
			}
		}
		// ----   recent post with thumbnail widget setting---
		$recent_post_widget = array();
		$recent_post_widget[1] = array(
		"title"		=>	'Featured Blogs',
		"select_category" 	=> 'blog',
		"showcount" => '4',
		"thumb" => 'true'
		 );						
		$recent_post_widget['_multiwidget'] = '1';
		update_option('widget_cs_recentposts',$recent_post_widget);
		$recent_post_widget = get_option('widget_cs_recentposts');
		krsort($recent_post_widget);
		foreach($recent_post_widget as $key1=>$val1)
		{
			$recent_post_widget_key = $key1;
			if(is_int($recent_post_widget_key))
			{
				break;
			}
		}
		// ----   recent post without thumbnail widget setting---
		$recent_post_widget2 = array();
		$recent_post_widget2 = get_option('widget_cs_recentposts');
		$recent_post_widget2[2] = array(
		"title"		=>	'Latest Posts',
		"select_category" 	=> 'blog',
		"showcount" => '2',
		"thumb" => 'false'
		 );						
		$recent_post_widget2['_multiwidget'] = '1';
		update_option('widget_cs_recentposts',$recent_post_widget2);
		$recent_post_widget2 = get_option('widget_cs_recentposts');
		krsort($recent_post_widget2);
		foreach($recent_post_widget2 as $key1=>$val1)
		{
			$recent_post_widget_key2 = $key1;
			if(is_int($recent_post_widget_key2))
			{
				break;
			}
		}
 		// ----   recent event widget setting---
		$upcoming_events_widget = array();
		$upcoming_events_widget[1] = array(
		"title"		=>	'Upcoming Events',
		"get_post_slug" 	=> 'our-events',
		"showcount" => '4',
 		 );						
		$upcoming_events_widget['_multiwidget'] = '1';
		update_option('widget_upcoming_events',$upcoming_events_widget);
		$upcoming_events_widget = get_option('widget_upcoming_events');
		krsort($upcoming_events_widget);
		foreach($upcoming_events_widget as $key1=>$val1)
		{
			$upcoming_events_widget_key = $key1;
			if(is_int($upcoming_events_widget_key))
			{
				break;
			}
		}
		// ---- tags widget setting---
		$tag_cloud = array();
		$tag_cloud[1] = array(
			"title" => 'Tags',
			"taxonomy" => 'album-category',
		);						
		$tag_cloud['_multiwidget'] = '1';
		update_option('widget_tag_cloud',$tag_cloud);
		$tag_cloud = get_option('widget_tag_cloud');
		krsort($tag_cloud);
		foreach($tag_cloud as $key1=>$val1)
		{
			$tag_cloud_key = $key1;
			if(is_int($tag_cloud_key))
			{
				break;
			}
		}
		// --- text widget setting ---
		$text = array();
		$text[1] = array(
			'title' => 'Teens club',
			'text' => '<address>254 Adelaide Terrace, 25 Rock Lane
                                <br>                
                                North Perth Western
                                <br>Australia, 6000</address>
								<ul>
                                <li> <em class="fa fa-long-arrow-right"></em>
                                    Phone : +618 9261 4600
                                </li>
                                <li> <em class="fa fa-long-arrow-right"></em>
                                    Fax: +618 9261 4699
                                </li>
                                <li>
                                    <em class="fa fa-long-arrow-right"></em>
                                    Email: info@cloonmore.com
                                </li>
                            </ul>',
		);						
		$text['_multiwidget'] = '1';
		update_option('widget_text',$text);
		$text = get_option('widget_text');
		krsort($text);
		foreach($text as $key1=>$val1)
		{
			$text_key = $key1;
			if(is_int($text_key))
			{
				break;
			}
		}
		// --- text widget About Our Team setting ---
		//----text widget for contact info----------
		$text4 = array();
		$text4 = get_option('widget_text');
		$text4[4] = array(
			'title' => 'Contact Info',
			'text' => '<h4>
                           25 Infinite Square, Red Street<br>
                           CA 123456, City name<br>
                           Canada, 
                        </h4>
                        <ul class="address-desc">
                            <li><span>Phone</span><strong>123.456.78910</strong></li>
                            <li><span>Mobile</span><strong>(800) 123 4567 89</strong></li>
                            <li><span>Email</span><strong>band@Company name.com</strong></li>
                            <li><span>Timing</span><time>Mon-Thu (09:00 to 17:30)</time></li>
                        </ul>',

		);						
		$text4['_multiwidget'] = '1';
		update_option('widget_text',$text4);
		$text4 = get_option('widget_text');
		krsort($text4);
		foreach($text4 as $key1=>$val1)
		{
			$text_key4 = $key1;
			if(is_int($text_key4))
			{
				break;
			}
		}
		// --- gallery widget setting ---
		$cs_gallery = array();
		$cs_gallery[1] = array(
			'title' => 'Featured Gallery',
			'get_names_gallery' => 'our-photos',
			'showcount' => '12'
		);						
		$cs_gallery['_multiwidget'] = '1';
		update_option('widget_cs_gallery',$cs_gallery);
		$cs_gallery = get_option('widget_cs_gallery');
		krsort($cs_gallery);
		foreach($cs_gallery as $key1=>$val1)
		{
			$cs_gallery_key = $key1;
			if(is_int($cs_gallery_key))
			{
				break;
			}
		}
		// ---- archive widget setting---
		$archives = array();
		$archives[1] = array(
		"title" => 'Archives',
		"count" => 'checked'
		);						
		$archives['_multiwidget'] = '1';
		update_option('widget_archives',$archives);
		$archives = get_option('widget_archives');
		krsort($archives);
		foreach($archives as $key1=>$val1)
		{
			$archives_key = $key1;
			if(is_int($archives_key))
			{
				break;
			}
		}
		
		// ---- Tabs widget setting---
		$tab_widget = array();
		$tab_widget[1] = array(
		"title" => 'Blogs',
		"title_widget_two" => 'Tags',
		"title_widget_three" => 'Comments',
		"get_default_widget_one" => 'WP_Widget_Recent_Posts',
		"get_default_widget_two" => 'WP_Widget_Tag_Cloud',
		"get_default_widget_three" => 'WP_Widget_Recent_Comments'
		);						
		$tab_widget['_multiwidget'] = '1';
		update_option('widget_cs_tabs_widget_show',$tab_widget);
		$tab_widget = get_option('widget_cs_tabs_widget_show');
		krsort($tab_widget);
		foreach($tab_widget as $key1=>$val1)
		{
			$tab_widget_key = $key1;
			if(is_int($tab_widget_key))
			{
				break;
			}
		}
		
		// ---- search widget setting---		
		$search = array();
		$search[1] = array(
			"title"		=>	'',
		);	
		$search['_multiwidget'] = '1';
		update_option('widget_search',$search);
		$search = get_option('widget_search');
		krsort($search);
		foreach($search as $key1=>$val1)
		{
			$search_key = $key1;
			if(is_int($search_key))
			{
				break;
			}
		}
		// ---- twitter widget setting---
		$cs_twitter_widget = array();
		$cs_twitter_widget[1] = array(
		"title"		=>	'Twitter',
		"username" 	=>	"envato",
		"numoftweets" => "2",
		 );						
		$cs_twitter_widget['_multiwidget'] = '1';
		update_option('widget_cs_twitter_widget',$cs_twitter_widget);
		$cs_twitter_widget = get_option('widget_cs_twitter_widget');
		krsort($cs_twitter_widget);
		foreach($cs_twitter_widget as $key1=>$val1)
		{
			$cs_twitter_widget_key = $key1;
			if(is_int($cs_twitter_widget_key))
			{
				break;
			}
		}
		// --- facebook widget setting-----
		$facebook_module = array();
		$facebook_module[1] = array(
		"title"		=>	'Facebook',
		"pageurl" 	=>	"https://www.facebook.com/envato",
		"showfaces" => "on",
		"likebox_height" => "285",
		"fb_bg_color" =>"#ffffff",
		);						
		$facebook_module['_multiwidget'] = '1';
		update_option('widget_cs_facebook_module',$facebook_module);
		$facebook_module = get_option('widget_cs_facebook_module');
		krsort($facebook_module);
		foreach($facebook_module as $key1=>$val1)
		{
			$facebook_module_key = $key1;
			if(is_int($facebook_module_key))
			{
				break;
			}
		}
 		//----text widget for contact info----------
		$text5 = array();
		$text5 = get_option('widget_text');
		$text5[5] = array(
			'title' => 'Accordion',
			'text' => '[accordion]
			[accordion_item active="yes" icon="" title="Qualified Full-time Professional" accordion="accordion"]Qualified Full-time Professional Master Photographer Andrew Gransden photographs weddings, portraits, wildlife and nature, commercial and businesses across Scotland from Aberdeen to Inverness..[/accordion_item]
			[accordion_item title="Commercial and businesses across" accordion="accordion"]Qualified Full-time Professional Master Photographer Andrew Gransden photographs weddings, portraits, wildlife and nature, commercial and businesses across Scotland from Aberdeen to Inverness..[/accordion_item]
			[accordion_item title="Businesses across Scotland from" accordion="accordion"]Qualified Full-time Professional Master Photographer Andrew Gransden photographs weddings, portraits, wildlife and nature, commercial and businesses across Scotland from Aberdeen to Inverness..[/accordion_item]
			[/accordion]',

		);	
							
		$text5['_multiwidget'] = '1';
		update_option('widget_text',$text5);
		$text5 = get_option('widget_text');
		krsort($text5);
		foreach($text5 as $key1=>$val1)
		{
			$text_key5 = $key1;
			if(is_int($text_key5))
			{
				break;
			}
		}
		//----text widget for contact info----------
		$text6 = array();
		$text6 = get_option('widget_text');
		$text6[6] = array(
			'title' => 'Toggle',
			'text' => '[toggle active="yes" title="Toggle Title 1"]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ac arcu aliquet sem varius interdum vel quis odio. Nulla adipiscing ipsum sit amet neque egestas sagittis.[/toggle]',

		);						
		$text6['_multiwidget'] = '1';
		update_option('widget_text',$text6);
		$text6 = get_option('widget_text');
		krsort($text6);
		foreach($text6 as $key1=>$val1)
		{
			$text_key6 = $key1;
			if(is_int($text_key6))
			{
				break;
			}
		}
		
		// ---- tags widget setting---
		$our_menu = array();
		$our_menu[1] = array(
			"title" => 'Our Menu',
			"nav_menu" => '2',
		);						
		$our_menu['_multiwidget'] = '1';
		update_option('widget_nav_menu',$our_menu);
		$our_menu = get_option('widget_nav_menu');
		krsort($our_menu);
		foreach($our_menu as $key1=>$val1)
		{
			$our_menu_key = $key1;
			if(is_int($our_menu_key))
			{
				break;
			}
		}
		
		// Add widgets in sidebars
		$sidebars_widgets['Sidebar'] = array("categories-$categories_key","cs_recentposts-$recent_post_widget_key","cs_gallery-$cs_gallery_key","cs_facebook_module-$facebook_module_key","tag_cloud-$tag_cloud_key","calendar-$calendar_key");
		$sidebars_widgets['Contact us'] = array("text-$text_key4","cs_facebook_module-$facebook_module_key");
		$sidebars_widgets['Event Detail'] = array("search-$search_key","text-$text_key5","tag_cloud-$tag_cloud_key","categories-$categories_key");
		$sidebars_widgets['footer-widget'] = array( "text-$text_key", "cs_gallery-$cs_gallery_key","categories-$categories_key");
		update_option('sidebars_widgets',$sidebars_widgets);  //save widget iformations
	}
	// installing tables on theme activating start
	// Install data on theme activation
    add_action('init', 'cs_install_tables');
	function cs_install_tables() {
		global $wpdb;
		global $header1_default_colors, $header2_default_colors, $header3_default_colors, $header4_default_colors, $header5_default_colors;
		$theme_mod_val = array();
		$term_exists = term_exists('top-menu', 'nav_menu');
 		if ( !$term_exists ) {
			$wpdb->query(" INSERT INTO `" . $wpdb->prefix . "terms` VALUES ('', 'Top Menu' , 'top-menu', '0'); ");
			$insert_id = mysql_insert_id();
			$theme_mod_val['top-menu'] = $insert_id;
			$wpdb->query(" INSERT INTO `" . $wpdb->prefix . "term_taxonomy` VALUES ('', '".$insert_id."' , 'nav_menu', '', '0', '0'); ");
		}
		else $theme_mod_val['top-menu'] = $term_exists['term_id'];
 		$term_exists = term_exists('main-menu', 'nav_menu');
		if ( !$term_exists ) {
			$wpdb->query(" INSERT INTO `" . $wpdb->prefix . "terms` VALUES ('', 'Main Menu' , 'main-menu', '0'); ");
			$insert_id = mysql_insert_id();
			$theme_mod_val['main-menu'] = $insert_id;
			$wpdb->query(" INSERT INTO `" . $wpdb->prefix . "term_taxonomy` VALUES ('', '".$insert_id."' , 'nav_menu', '', '0', '0'); ");
		}
		else $theme_mod_val['main-menu'] = $term_exists['term_id'];
  		set_theme_mod( 'nav_menu_locations', $theme_mod_val );
   		
		$args = array(
			'style_sheet' => 'custom',
			'custom_color_scheme' => '#ef5d00',
			'heading_color_scheme' => '#ef5d00',
			// Header Color Settings
 			'header_bg_color' => '#175977',
			'header_text_color' => '#fff',
			'header_link_color' => '#fff',
			'header_top_strip_color' => '#333333',
			'button_bg_color' => '#0B2C3B',
			'button_text_color' => '#fff',

			// footer Color Settigs
			'footer_bg_color' => '#000000',
			'footer_text_color' => '#bbbbbb',
			'copyright_bg_color' => '#505050',
			'layout_option' => 'wrapper_boxed',
			'header_styles' => 'header1',
			'default_header' => 'header1',
			
			'header_banner' => '',
			'header_text' => '',
			'bg_img' => '1',
			'bg_img_custom' => '',
			'bg_position' => 'center',
			'bg_repeat' => 'no-repeat',
			'bg_attach' => 'fixed',
			'pattern_img' => '0',
			'custome_pattern' => '',
			'bg_color' => '',

			'logo' => get_template_directory_uri().'/images/logo.png',
			'logo_width' => '167',
			'logo_height' => '26',
			
			'main_logo' => get_template_directory_uri().'/images/logo.png',
			'header_sticky_menu' => '',
			'logo_sticky' => get_template_directory_uri().'/images/sticky-logo.png',
			'main_logo_width' => '167',
			'main_logo_height' => '26',
			'fav_icon' => get_template_directory_uri() . '/images/favicon.ico',
			'header_code' => '',
			'header_link_title' => '',
			'header_link_url' => '',
			'footer_bg_img' => get_template_directory_uri().'/images/footer_bg.jpg',
			'copyright' =>  '&copy;'.gmdate("Y")." ".get_option("blogname")." WordPress All rights reserved.", 
			'powered_by' => 'Design by ChimpStudio',
			'powered_icon' => '',
			'analytics' => '',
			'responsive' => 'on',
			'style_rtl' => '',
			// switchers
			'color_switcher' => '',
			'trans_switcher' => '',
			'search_switcher' => 'on',
			'login_switcher' => 'on',
			'show_slider' => 'on',
			'slider_name' => 'slider',
			'slider_type' => 'Revolution Slider',
			'post_title' => '',
			'switch_footer_widgets' => 'on',
			'h1_size' => '24',
			'h2_size' => '20',
			'h3_size' => '18',
			'h4_size' => '17',
			'h5_size' => '16',
			'h6_size' => '14',
			'content_size' => '12',
			'h1_g_font' => '',
			'h2_g_font' => '',
			'h3_g_font' => '',
			'h4_g_font' => '',
			'h5_g_font' => '',
			'h6_g_font' => '',
			'content_size_g_font' => '',
			'sidebar' => array( 'Sidebar', 'Contact us', 'Event Detail'),
			
			// slider setting
			'flex_effect' => 'fade',
			'flex_auto_play' => 'on',
			'flex_animation_speed' => '7000',
			'flex_pause_time' => '600',
			'slider_id' => '[rev_slider rocky]',
			'slider_view' => '',

			'social_net_title' => '',
			'social_net_icon_path' => array( get_template_directory_uri().'/images/img-s1.png', get_template_directory_uri().'/images/img-s2.png'
										, get_template_directory_uri().'/images/img-s3.png', get_template_directory_uri().'/images/img-s4.png'
										, get_template_directory_uri().'/images/img-s5.png', get_template_directory_uri().'/images/img-s6.png'
										, get_template_directory_uri().'/images/img-s7.png', get_template_directory_uri().'/images/img-s8.png'
										, get_template_directory_uri().'/images/img-s9.png', get_template_directory_uri().'/images/img-s10.png'
									 ),
			'social_net_awesome' => array( '', '' , '' , '' , '' , '' , '' , '' , '' , '' ),
			'social_net_url' => array( 'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK', 
								'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK', 
								'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK'
								),
			'social_net_tooltip' => array( 'Facebook', 'Twitter', '', '', '', '', '', '', '', '' ),

			'facebook_share' => 'on',
			'twitter_share' => 'on',
			'linkedin_share' => 'on',
			'myspace_share' => 'on',
			'digg_share' => 'on',
			'stumbleupon_share' => 'on',
			'reddit_share' => 'on',
			'pinterest_share' => 'on',
			'tumblr_share' => 'on',
			'google_plus_share' => 'on',
			'blogger_share' => 'on',
			'amazon_share' => 'on',
			// tranlations
			'trans_album_tracks' => 'Tracks',
			'trans_album_buynow' => 'Buy Now',
			'trans_album_load_more' => 'Load More',
			'trans_album_play_now' => 'Play Now',

			'trans_event_location' => 'Event Location',
            'trans_event_time' => 'Event Time',
            'trans_event_ticket_price' => 'Ticket Price',
            'trans_event_buy_ticket' => 'Buy Ticket',
            'trans_event_time_left' => 'Time Left',
            'trans_event_artist_title' => 'Artist Title',
			'trans_event_from' => 'From:',
			'trans_event_tickets' => 'Tickets',
			'trans_event_days_to_go' => 'Days to go!',
			'trans_event_days_before' => 'Days before!',
			'trans_event_organizer' => 'Organizer',
			
            'trans_subject' => 'Subject',
            'trans_message' => 'Message',
            'trans_form_title' => 'Send us a Quick Message',
			
            'trans_follow_twitter' => 'Follow Us on Twitter',
			'trans_follow' => 'Follow Us',
            'trans_share_this_post' => 'Share Now',
            'trans_content_404' => "It seems we can not find what you are looking for.",
            'trans_posted_on' => 'Posted on',
			'trans_featured' => 'Featured',
			'trans_other_on' => 'on',
			'trans_other_prev' => 'Previous',
			'trans_listed_in' => 'Listed in',
			'trans_filter_by' => 'Filter by',
			'trans_read_more' => 'read more',
			'trans_view_more_blogs' => 'View More Blogs',
			// translation end

           	'pagination' => 'Show Pagination',
			'record_per_page' => '5',
			'cs_layout' => 'right',
			'cs_sidebar_left' => '',
			'cs_sidebar_right' => 'Sidebar',
			'under-construction' => '',
			'showlogo' => 'on',
			'socialnetwork' => 'on',
			'under_construction_text' => '<h1>OUR WEBSITE IS UNDERCONSTRUCTION</h1><h4>We\'ll be here soon with a new website, Estimated Time Remaining</h4>',
			'launch_date' => '2014-12-01',
			'screen_name' => 'envato',
			'consumer_key' => 'BUVzW5ThLW8Nbmk9rSFag',
			'consumer_secret' => 'J8LDM3SOSNuP2JrESm8ZE82dv9NtZzer091ZjlWI',
		);
		/* Merge Heaser styles
		*/
         $args = array_merge($args, $header1_default_colors, $header2_default_colors, $header3_default_colors, $header4_default_colors, $header5_default_colors);
		update_option("cs_theme_option", $args );
		update_option("cs_theme_option_restore", $args );
		update_option("show_on_front", 'page' );
		update_option("TWITTER_BEARER_TOKEN", 'AAAAAAAAAAAAAAAAAAAAAGt%2FSAAAAAAAc7UCkKRfPuPoB6HE1TAQWmd%2FNmQ%3DNqMKXtYlXw7ELrLszYipiree7idpL4zDP53fSFxzYg' );
	}
}

// adding font start
function cs_font_head() {
	$cs_fonts = get_option('cs_theme_option');
		if ( isset($cs_fonts['h1_size']) ) echo '<style> h1{ font-size:'.$cs_fonts['h1_size'].'px !important; } </style>';
		if ( isset($cs_fonts['h1_g_font']) and $cs_fonts['h1_g_font'] <> "" ) {
			echo '<style>';
				echo "@import url(http://fonts.googleapis.com/css?family=".$cs_fonts['h1_g_font'].");";
				echo "h1 { font-family: '".$cs_fonts['h1_g_font']."', sans-serif !important; }";
			echo '</style>';
		}
 		if ( isset($cs_fonts['h2_size']) ) echo '<style> h2{ font-size:'.$cs_fonts['h2_size'].'px !important; } </style>';
		if ( isset($cs_fonts['h2_g_font']) and $cs_fonts['h2_g_font'] <> "" ) {
			echo '<style>';
				echo "@import url(http://fonts.googleapis.com/css?family=".$cs_fonts['h2_g_font'].");";
				echo "h2 { font-family: '".$cs_fonts['h2_g_font']."', sans-serif !important; }";
			echo '</style>';
		}
 		if ( isset($cs_fonts['h3_size']) ) echo '<style> h3{ font-size:'.$cs_fonts['h3_size'].'px !important; } </style>';
		if ( isset($cs_fonts['h3_g_font']) and $cs_fonts['h3_g_font'] <> "" ) {
			echo '<style>';
				echo "@import url(http://fonts.googleapis.com/css?family=".$cs_fonts['h3_g_font'].");";
				echo "h3 { font-family: '".$cs_fonts['h3_g_font']."', sans-serif !important; }";
			echo '</style>';
		}
 		if ( isset($cs_fonts['h4_size']) ) echo '<style> h4{ font-size:'.$cs_fonts['h4_size'].'px !important; } </style>';
		if ( isset($cs_fonts['h4_g_font']) and $cs_fonts['h4_g_font'] <> "" ) {
			echo '<style>';
				echo "@import url(http://fonts.googleapis.com/css?family=".$cs_fonts['h4_g_font'].");";
				echo "h4 { font-family: '".$cs_fonts['h4_g_font']."', sans-serif !important; }";
			echo '</style>';
		}
 		if ( isset($cs_fonts['h5_size']) ) echo '<style> h5{ font-size:'.$cs_fonts['h5_size'].'px !important; } </style>';
		if ( isset($cs_fonts['h5_g_font']) and $cs_fonts['h5_g_font'] <> "" ) {
			echo '<style>';
				echo "@import url(http://fonts.googleapis.com/css?family=".$cs_fonts['h5_g_font'].");";
				echo "h5 { font-family: '".$cs_fonts['h5_g_font']."', sans-serif !important; }";
			echo '</style>';
		}
 		if ( isset($cs_fonts['h6_size']) ) echo '<style> h6{ font-size:'.$cs_fonts['h6_size'].'px !important; } </style>';
		if ( isset($cs_fonts['h6_g_font']) and $cs_fonts['h6_g_font'] <> "" ) {
			echo '<style>';
				echo "@import url(http://fonts.googleapis.com/css?family=".$cs_fonts['h6_g_font'].");";
				echo "h6 { font-family: '".$cs_fonts['h6_g_font']."', sans-serif !important; }";
			echo '</style>';
		}
 		if ( isset($cs_fonts['content_size']) ) echo '<style> body{ font-size:'.$cs_fonts['content_size'].'px !important; } </style>';
		if ( isset($cs_fonts['content_size_g_font']) and $cs_fonts['content_size_g_font'] <> "" ) {
			echo '<style>';
				echo "@import url(http://fonts.googleapis.com/css?family=".$cs_fonts['content_size_g_font'].");";
				echo "body { font-family: '".$cs_fonts['content_size_g_font']."', sans-serif !important; }";
			echo '</style>';
		}
 	}
	add_action( 'wp_head', 'cs_font_head' );

// Admin scripts enqueue
function cs_admin_scripts_enqueue() {
    $template_path = get_template_directory_uri() . '/scripts/admin/media_upload.js';
    wp_enqueue_script('my-upload', $template_path, array('jquery', 'media-upload', 'thickbox', 'jquery-ui-droppable', 'jquery-ui-datepicker', 'jquery-ui-slider', 'wp-color-picker'));
    wp_enqueue_script('custom_wp_admin_script', get_template_directory_uri() . '/scripts/admin/cs_functions.js');
    wp_enqueue_style('custom_wp_admin_style', get_template_directory_uri() . '/css/admin/admin-style.css', array('thickbox'));
	wp_enqueue_style('wp-color-picker');
}
add_action('admin_enqueue_scripts', 'cs_admin_scripts_enqueue');

// Inclue Template files
require_once (TEMPLATEPATH . '/include/album.php');
require_once (TEMPLATEPATH . '/include/event.php');
require_once (TEMPLATEPATH . '/include/slider.php');
require_once (TEMPLATEPATH . '/include/gallery.php');
require_once (TEMPLATEPATH . '/include/page_builder.php');
require_once (TEMPLATEPATH . '/include/post_meta.php');
require_once (TEMPLATEPATH . '/include/short_code.php');
require_once (TEMPLATEPATH . '/functions-theme.php');
require_once (TEMPLATEPATH . '/header_style.php');

if (current_user_can('administrator')) {
	// Addmin Menu CS Theme Option
	require_once (TEMPLATEPATH . '/include/theme_option.php');
	add_action('admin_menu', 'cs_theme');
	function cs_theme() {
		add_theme_page('CS Theme Option', 'CS Theme Option', 'read', 'cs_theme_options', 'theme_option');
	}
}




if (!session_id()) add_action('init', 'session_start');

// Use a static front page
$home = get_page_by_title( 'Home' );
if($home <> '' && get_option( 'page_on_front' ) == "0"){
	if(get_option( 'show_on_front' ) == "page"){
		update_option( 'page_on_front', $home->ID );
	}
}
// Front End Functions Start

// add twitter option in user profile
function cs_contact_options( $contactoptions ) {
	$contactoptions['twitter'] = 'Twitter';
	return $contactoptions;
}
add_filter('user_contactmethods','cs_contact_options',10,1);

// Template redirect in single Gallery and Slider page
function cs_slider_gallery_template_redirect(){
    if ( get_post_type() == "cs_gallery" or get_post_type() == "cs_slider" ) {
		global $wp_query;
		$wp_query->set_404();
		status_header( 404 );
		get_template_part( 404 ); exit();
    }
}
// Get header dropdown options
function cs_header_options(){
    global $cs_theme_option;
       for($i=1; $i<=5; $i++){?>
    		<option value="<?php echo 'header'.$i;?>" <?php if( $cs_theme_option['header_styles']=='header'.$i){ echo 'selected="selected"';}?>><?php echo 'Header '.$i;?></option>
		<?php }
}
// enque style and scripts
function cs_front_scripts_enqueue() {
	global $cs_theme_option;
     if (!is_admin()) {
		wp_enqueue_style('style_css', get_template_directory_uri() . '/style.css');
		wp_enqueue_style('widget_css', get_template_directory_uri() . '/css/widget.css');
  		if ( $cs_theme_option['color_switcher'] == "on" ) {
			wp_enqueue_style('color-switcher_css', get_template_directory_uri() . '/css/color-switcher.css');
		}
  		wp_enqueue_style('bootstrap_css', get_template_directory_uri() . '/css/bootstrap.min.css');
 		wp_enqueue_style('font-awesome_css', get_template_directory_uri() . '/css/font-awesome.css');
		// Register stylesheet
    	wp_register_style( 'ie6_css', get_template_directory_uri() . '/css/ie.css' );
    	// Apply IE conditionals
    	$GLOBALS['wp_styles']->add_data( 'ie6_css', 'conditional', 'lte IE 9' );
		$GLOBALS['wp_styles']->add_data( 'font-awesome-ie7_css', 'conditional', 'lte IE 9' );
    	// Enqueue stylesheet
    	wp_enqueue_style( 'ie6_css' );
		
		wp_enqueue_style( 'font-awesome-ie7_css' );
   		wp_enqueue_style( 'wp-mediaelement' );
 		    wp_enqueue_script('jquery');
			wp_enqueue_script( 'wp-mediaelement' );
			wp_enqueue_script('bootstrap_js', get_template_directory_uri() . '/scripts/frontend/bootstrap.min.js', '', '', true);
			wp_enqueue_script('bscrolltofixed_js', get_template_directory_uri() . '/scripts/frontend/jquery-scrolltofixed.js', '', '', true);
   			wp_enqueue_script('jquery.nicescroll_js', get_template_directory_uri() . '/scripts/frontend/jquery.nicescroll.js', '0', '', true);
			wp_enqueue_script('jquery.nicescrollpjus_js', get_template_directory_uri() . '/scripts/frontend/jquery.nicescroll.plus.js', '0', '', true);
			wp_enqueue_script('functions_js', get_template_directory_uri() . '/scripts/frontend/functions.js', '0', '', true);
 			if ( $cs_theme_option['style_rtl'] == "on"){
				wp_enqueue_style('rtl_css', get_template_directory_uri() . '/css/rtl.css');
 			}
			if 	($cs_theme_option['responsive'] == "on") {
				echo '<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">';
				wp_enqueue_style('responsive_css', get_template_directory_uri() . '/css/responsive.css');
			}
     }
}
add_action('wp_enqueue_scripts', 'cs_front_scripts_enqueue'); 
// Gallery Script Enqueue
function cs_enqueue_gallery_style_script(){
	wp_enqueue_style('prettyPhoto_css', get_template_directory_uri() . '/css/prettyphoto.css');
	wp_enqueue_script('prettyPhoto_js', get_template_directory_uri() . '/scripts/frontend/jquery.prettyphoto.js', '', '', true);
}
// Masonry Style and Script enqueue
function cs_enqueue_masonry_style_script(){
 	wp_enqueue_script('jquery.masonry_js', get_template_directory_uri() . '/scripts/frontend/jquery.masonry.min.js', '', '', true);
}
// jplayer script enqueue
function cs_enqueue_jplayer(){
	wp_enqueue_script('jplayer_js', get_template_directory_uri() . '/scripts/frontend/jquery.jplayer.min.js', '', '', true);
	wp_enqueue_script('jplayer.playlist.min_js', get_template_directory_uri() . '/scripts/frontend/jplayer.playlist.min.js', '0', '', true);
}
// Validation Script Enqueue
function cs_enqueue_validation_script(){
	wp_enqueue_script('jquery.validate.metadata_js', get_template_directory_uri() . '/scripts/admin/jquery.validate.metadata.js', '', '', true);
	wp_enqueue_script('jquery.validate_js', get_template_directory_uri() . '/scripts/admin/jquery.validate.js', '', '', true);
}
// Flexslider Script and style enqueue
function cs_enqueue_flexslider_script(){
   	wp_enqueue_script('jquery.flexslider-min_js', get_template_directory_uri() . '/scripts/frontend/jquery.flexslider-min.js', '', '', true);
    wp_enqueue_style('flexslider_css', get_template_directory_uri() . '/css/flexslider.css');
}
// Parallax Script enqueue
function cs_enqueue_parallax_script(){
   	wp_enqueue_script('parallax_js', get_template_directory_uri() . '/scripts/frontend/parallax.js', '', '', true);
} 
// Event Calendar enqueue Script
function cs_calender_enqueue_scripts() {
     wp_enqueue_script('calender_js', get_template_directory_uri() . '/scripts/frontend/fullcalendar.min.js', '', '', TRUE);
	 wp_enqueue_style('fullcalendar_css', get_template_directory_uri() . '/css/fullcalendar.css');
}
// Skills Circle Porgress bar script enqueue
function cs_circular_progress_script(){
   	wp_enqueue_script('circular_progress_js', get_template_directory_uri() . '/scripts/frontend/circular-progress.js', '', '', true);
} 

/*------Header Functions------*/

// Favicon and header code in head tag//
function cs_header_settings() {
    global $cs_theme_option;
    ?>
     <link rel="shortcut icon" href="<?php echo $cs_theme_option['fav_icon'] ?>" />
     <!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
     <?php  
}
add_action('wp_head','cs_header_settings');
// Favicon and header code in head tag//
function cs_footer_settings() {
    global $cs_theme_option;
     echo htmlspecialchars_decode($cs_theme_option['analytics']);
}
add_action('wp_footer','cs_footer_settings');
// Get Header Name
function cs_get_header_name(){
			global $post, $cs_theme_option;
			if ( isset($_POST['header_styles']) ) {
					$_SESSION['sess_header_styles'] = $_POST['header_styles'];
					$header_styles = $_SESSION['sess_header_styles'];
			}
			else if ( !empty($_SESSION['sess_header_styles']) ) {
					$header_styles = $_SESSION['sess_header_styles'];
			}
			else if(is_page()){
				$cs_page_builder = get_post_meta($post->ID, "cs_page_builder", true);
				if($cs_page_builder <> ''){
					$cs_xmlObject = new SimpleXMLElement($cs_page_builder);
					$header_styles = $cs_xmlObject->header_styles;
					if($header_styles == '' or $header_styles == 'default-header'){
						$header_styles = $cs_theme_option['default_header'];	
					}
				}else{
					$header_styles = $cs_theme_option['default_header'];
				}
			}else {
					$header_styles = $cs_theme_option['default_header'];
			}	
			return $header_styles;
}
// Header Section //
function cs_get_header(){
    global $post, $cs_theme_option, $cs_position;
    $cs_position ='relative';
        if(is_page()){
            global $cs_page_builder,$cs_meta_page,$cs_node;
            $cs_meta_page = cs_meta_page('cs_page_builder');
            if(!empty($cs_meta_page)){
                    foreach ( $cs_meta_page->children() as $cs_node ){ 
                            if($cs_node->getName() == "slider" and $cs_node->slider_view == "header"){
                                    $cs_position ='absolute';
                            }
                    }
            }
			$cs_xmlObject = cs_meta_page('cs_page_builder');
        	if (!empty($cs_xmlObject)) {
                 if($cs_xmlObject->header_banner_options =="Slider"){ 
                        $cs_position ='absolute';
                 }
             }
        } elseif (is_single()){
            if($cs_theme_option['default_header'] == 'header1' || $cs_theme_option['default_header'] == 'header2'){
                	$cs_position ='relative';
			}
        }
		
		cs_header_style();
		if ( isset($_POST['header_styles']) ) {
					$_SESSION['sess_header_styles'] = $_POST['header_styles'];
					$header_styles = $_SESSION['sess_header_styles'];
		} else if ( !empty($_SESSION['sess_header_styles']) ) {
					$header_styles = $_SESSION['sess_header_styles'];
		} else if(is_page()){
			$cs_xmlObject = cs_meta_page('cs_page_builder');
			if (!empty($cs_xmlObject)) {
					$header_styles = $cs_xmlObject->header_styles;
					if($header_styles == '' or $header_styles == "default-header"){
 						$header_styles = $cs_theme_option['default_header'];	
					}
			} else{
				$header_styles = $cs_theme_option['default_header'];
			}
		} else {
			$header_styles = $cs_theme_option['default_header'];
		}
		if(isset($header_styles) && !empty($header_styles)){
 			cs_custom_header_styles($header_styles);
		}
}

// Home page Slider //
function cs_get_home_slider(){
    global $cs_theme_option;
	if($cs_theme_option['show_slider'] =="on"){
		if($cs_theme_option['slider_type'] <> "Revolution Slider"){?>
		  <div id="banner" class="fullwidth">
			<div class="fullwidth" id="bannerwrapp">
			   <?php 
				  if($cs_theme_option['layout_option']== "wrapper"){
						  $width = 1270;
						  $height = 500;
				  } else {
						  $width = 1170;
						  $height = 430;
				  }
				  $slider_slug = $cs_theme_option['slider_name'];
				  if($slider_slug <> ''){
					  $args=array(
						'name' => $slider_slug,
						'post_type' => 'cs_slider',
						'post_status' => 'publish',
						'showposts' => 1,
					  );
					  $get_posts = get_posts($args);
					  if($get_posts){
						  $slider_id = $get_posts[0]->ID;
						  if($cs_theme_option['slider_type'] == 'Flex Slider'){
							cs_flex_slider($width,$height,$slider_id);
						  }
					  } else {
						  $slider_id = '';
						  echo '<div class="box-small no-results-found heading-color"> <h5>';
								  _e("No results found.",'Rocky');
						  echo ' </h5></div>';
					  }
				  }
 				?>
			</div>
		  </div>
		<?php 
		}else{
			echo do_shortcode(htmlspecialchars_decode($cs_theme_option['slider_id']));	
		}
	}
}
// Pages Subheader Section at front end //
function cs_get_subheader(){
    $image_url     = '';
    global $cs_page_builder, $cs_meta_page, $cs_node, $post, $cs_theme_option,$cs_xmlObject ;
    $default_image = "default-image";
    $cs_xmlObject     = new stdClass();
	$cs_xmlObject->header_banner_options = '';
    if (is_page()) {
      $cs_xmlObject = cs_meta_page('cs_page_builder');
		if($cs_meta_page <> ''){
 			$cs_meta_page = cs_meta_page('cs_page_builder');
		}
        if (!empty($cs_meta_page)) {
            foreach ($cs_meta_page->children() as $cs_node) {
                if ($cs_node->slider_view == "header" and $cs_node->slider_type == "Custom Slider") {
                     echo do_shortcode(htmlspecialchars_decode($cs_node->slider_id));
                }
            }
        }
		if (isset($cs_meta_page)) {
            if ($cs_meta_page->header_banner_options == "Custom Image" && $cs_meta_page->header_banner <> '') {
                $image_url = $cs_meta_page->header_banner;
            }
            elseif ($cs_meta_page->header_banner_options == "Default Image") {
                $image_url     = '';
                $default_image = "default-image";
            }
			elseif ($cs_meta_page->header_banner_options == "No Image") {
                $image_url     = '';
                $default_image = "no-image";
            }
        }
    } elseif (is_single()) {
  		   $post_type = get_post_type($post->ID);
			 if ($post_type == "events") {
				 $post_type = "cs_event_meta";
			 }
			 else {
				 $post_type = "post";
			 }
			 $post_xml = get_post_meta($post->ID, $post_type, true);
			 if ($post_xml <> "") {
			   $cs_xmlObject = new SimpleXMLElement($post_xml);
			 }
           if (isset($cs_xmlObject)) {
               if ($cs_xmlObject->header_banner_options == 'Custom Image'  && $cs_xmlObject->header_banner <> '') {
                  $image_url = $cs_xmlObject->header_banner;
               }
               elseif ($cs_xmlObject->header_banner_options == "Default Image") {
                   $image_url     = '';
                   $default_image = "default-image";
               }
           }
    }
    if ($cs_xmlObject->header_banner_options == "Slider") {
    	echo do_shortcode($cs_xmlObject->slider_id);
    } elseif ($cs_xmlObject->header_banner_options != "No Header") { ?>
        <div class="outerbreadcrumb fullwidth <?php cs_subheader_classes($cs_xmlObject->header_banner_options);  ?>">
            <!-- Container Start -->
                <?php
                if ($image_url <> '') {
                    echo '<div class="banner-image" ><img src="' . $image_url . '" alt="" /> </div>';
                }
                ?>  
           <div class="container">
        	<div class="breadcrumbinner">
           	   <?php
                  // Page Subheader Title and subtitle
               		cs_get_subheader_title(); 
					cs_breadcrumbs();	  
			   ?>
            </div>
        </div>
    <!-- Container End -->
    </div>
    <?php
    }
}
// Header sticky Menu //
function cs_header_sticky_menu(){
	global $cs_theme_option;
	$header_style=cs_get_header_name();
	?>
    <script type="text/javascript">
		jQuery(document).ready(function(){
			sticky_menu();
 		});
	</script>
    <div id="stickyarea">
        <div class="container">
            <div id="logobox-stick">
			<?php if(isset($cs_theme_option['logo_sticky']) && $cs_theme_option['logo_sticky']<>''){
						cs_logo($cs_theme_option['logo_sticky'], '', '', 'on');
					} else if(isset($cs_theme_option['main_logo']) && $cs_theme_option['main_logo']<>''){
						cs_logo($cs_theme_option['main_logo'], $cs_theme_option['main_logo_width'], $cs_theme_option['main_logo_height'], 'on');
					}
				?>
				</div>
            <div id="menubox-stick"></div>        	
        </div>
    </div>
   <?php
}

// Page Sub header title and subtitle //
function cs_get_subheader_title(){
	global $post;
	$show_title=true;
  	?>
    <div class="subtitle float-left bgcolr">
		<?php 
			if (is_page() || is_single()) {
				if (is_page() ){
					$cs_xmlObject = cs_meta_page('cs_page_builder');
				  	if (isset($cs_xmlObject) and $cs_xmlObject <> '') {
						if ($cs_xmlObject->page_title == "No") {
							$show_title = false;
					  	}
 				  	}
                }
 				if(isset($show_title) && $show_title==true){
					echo '<h1 class="page-title">' . substr(get_the_title(), 0, 40) . '</h1>';
				}
		  } else { ?>
             <h1 class="page-title"><?php cs_post_page_title(); ?></h1>
		 <?php }?> 
    </div>
    <?php
}
// sub header class selection
function cs_subheader_classes( $header_banner_selection = ''){
	if ($header_banner_selection == "No Image") {
    	echo 'cs-no-image';
    }elseif($header_banner_selection == 'Custom Image'){
		echo 'cs-custom-image';
	} elseif ($header_banner_selection == "Default Image") {
    	echo "default-image";
    } else {
    	echo "default-image";
    }
}
/*------Header Functions End------*/
// Front End Functions END