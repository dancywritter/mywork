<?php
add_action( 'after_setup_theme', 'cs_theme_setup' );
function cs_theme_setup() {

	/* Add theme-supported features. */
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();
	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
 	load_theme_textdomain('Spikes', get_template_directory() . '/languages');
	
	if (!isset($content_width)){
		$content_width = 1170;
	}
	$args = array(
		'default-color' => '',
		'default-image' => '',
	);
	add_theme_support('custom-background', $args);
	add_theme_support('custom-header', $args);
	// This theme uses post thumbnails
	add_theme_support('post-thumbnails');

	// Add default posts and comments RSS feed links to head
	add_theme_support('automatic-feed-links');
	/* Add custom actions. */
	global $pagenow;

	if (is_admin() && isset($_GET['activated']) && $pagenow == 'themes.php'){
		add_action('admin_head', 'cs_activate_widget');
		add_action('init', 'cs_activation_data');
	}
	if (!session_id()){ 
		add_action('init', 'session_start');
	}
 	add_action( 'init', 'cs_register_my_menus' );
	add_action('admin_enqueue_scripts', 'cs_admin_scripts_enqueue');
	add_action('wp_enqueue_scripts', 'cs_front_scripts_enqueue');
	add_action('pre_get_posts', 'cs_get_search_results');
	/* Add custom filters. */
	add_filter('widget_text', 'do_shortcode');
	add_filter('user_contactmethods','cs_contact_options',10,1);
	add_filter('the_password_form', 'cs_password_form' );
	add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
	add_filter('wp_page_menu','cs_add_menuid');
	add_filter('wp_page_menu', 'cs_remove_div' );
	add_filter('nav_menu_css_class', 'cs_add_parent_css', 10, 2);
	add_filter('pre_get_posts', 'cs_change_query_vars');
}
/* adding custom images while uploading media */
	add_image_size('cs_media_1', 1080, 468, true);
	add_image_size('cs_media_2', 730, 350, true);
	add_image_size('cs_media_3', 420, 400, true);
	add_image_size('cs_media_4', 314, 314, true);
	add_image_size('cs_media_5', 380, 290, true);
	add_image_size('cs_media_6', 228, 205, true);
	add_image_size('cs_media_7', 230, 152, true);
	add_image_size('cs_media_8', 231, 172, true);
	add_image_size('cs_media_9', 492, 370, true);

if (!function_exists('cs_comment')) {
     /**
     * Template for comments and pingbacks.
     *
     * To override this walker in a child theme without modifying the comments template
     * simply create your own PixFill_comment(), and that function will be used instead.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     *
     */
	function cs_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	$args['reply_text'] = '<i class="fa fa-mail-reply-all"></i>';
 	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <div class="thumblist" id="comment-<?php comment_ID(); ?>">
            <ul>
                <li>
                    <figure>
                        <a><?php echo get_avatar( $comment, 50 ); ?></a>
                    </figure>
                    <div class="text">
                    	<div class="comment-data">
                            <header>
                                <?php $adm_says =  __( "%s", "Spikes" ); echo sprintf( '<h6><a class="colrhover">'.$adm_says.'</h6></a>', get_comment_author_link() ) ; ?>
                                <?php
                                    /* translators: 1: date, 2: time */
                                    printf( __( '<time>%1$s,%2$s</time>', 'Spikes' ), get_comment_date('l, d, m, Y'),get_comment_time('H:i A')); ?>
                                    <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                                    <?php edit_comment_link( __( '<i class="fa fa-pencil-square-o"></i>', 'Spikes' ), ' ' );?>
                           </header>
							<?php if ( $comment->comment_approved == '0' ) : ?>
                                    <div class="comment-awaiting-moderation colr"><?php _e( 'Your comment is awaiting moderation.', 'Spikes' ); ?></div>
                                
                                <?php else: 
                          comment_text();  
                          endif; ?>
                       </div>
                    </div>
                </li>
            </ul>
        </div>
	<?php
		break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'Spikes' ), ' ' ); ?></p>
	<?php
		break;
		endswitch;
	}
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
                <!--<ul class="form-elements">
                    <li class="to-label"><label>Image Description</label></li>
                    <li class="to-field"><textarea class="txtarea" name="description[]"><?php //echo htmlspecialchars($cs_node->description)?></textarea></li>
                </ul>-->
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
                            <option <?php if($cs_album_view=="home_view")echo "selected";?> value="home_view">Home page View</option>
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
                    <li class="to-label"><label>Choose Gallery Layout</label></li>
                    <li class="to-field">
                        <select name="cs_gal_layout[]" class="dropdown">
                            <option value="gallery-four-col" <?php if($cs_gal_layout_db=="gallery-four-col")echo "selected";?> >4 Column</option>
                            <option value="gallery-three-col" <?php if($cs_gal_layout_db=="gallery-three-col")echo "selected";?> >3 Column</option>
                            <option value="gallery-tow-col" <?php if($cs_gal_layout_db=="gallery-tow-col")echo "selected";?> >2 Column</option>
                        </select>
                        
                        <p>Select gallery layout, double column, three column or four column.</p>
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
                <!--<ul class="form-elements">
                    <li class="to-label"><label>Show Description</label></li>
                    <li class="to-field">
                        <select name="cs_gal_desc[]" class="dropdown">
                            <option <?php //if($cs_gal_desc_db=="On")echo "selected";?> >On</option>
                            <option <?php //if($cs_gal_desc_db=="Off")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>-->
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

// Sets gallery  html form for page builder start
function cs_pb_gallery_albums($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
			$name = $_POST['action'];
			$counter = $_POST['counter'];
			$gallery_element_size = '50';
			$cs_gal_header_title_db = '';
			$cs_gal_album_db = '';
 			$cs_gal_desc_db = '';
			$cs_gal_album_view_title = '';
			$cs_gal_album_view_url = '';
			$cs_gal_pagination_db = '';
			$cs_gal_media_per_page_db = get_option("posts_per_page");
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$gallery_element_size = $cs_node->cs_gallery_album_element_size;
			$cs_gal_header_title_db = $cs_node->cs_gal_album_header_title;
			$cs_gal_album_db = $cs_node->cs_gal_album;
			$cs_gal_album_view_title = $cs_node->cs_gal_album_view_title;
			$cs_gal_album_view_url = $cs_node->cs_gal_album_view_url;
			$cs_gal_pagination_db = $cs_node->cs_gal_album_pagination;
			$cs_gal_media_per_page_db = $cs_node->cs_gal_album_media_per_page;
				$counter = $post->ID.$count_node;
	}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $gallery_element_size?>" item="gallery" data="<?php echo element_size_data_array_index($gallery_element_size)?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="cs_gallery_album_element_size[]" class="item" value="<?php echo $gallery_element_size?>" >
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
                        <input type="text" name="cs_gal_album_header_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_gal_header_title_db)?>" />
                        <p>Please enter gallery header title.</p>
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>View All Title</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_gal_album_view_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_gal_album_view_title)?>" />
                        <p>Please enter gallery View All Title.</p>
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>View All URL</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_gal_album_view_url[]" class="txtfield" value="<?php echo htmlspecialchars($cs_gal_album_view_url)?>" />
                        <p>Please enter gallery View All URL.</p>
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Choose Gallery/Album</label></li>
                    <li class="to-field">
                        <select name="cs_gal_album[]" class="dropdown">
                        	<option value="0">-- Select Gallery --</option>
                            <?php
								$categories = get_categories( array('taxonomy' => 'cs_gallery-category', 'hide_empty' => 0) );
								foreach ($categories as $category) {
                            ?>
                                <option <?php if($category->slug==$cs_gal_album_db)echo "selected";?> value="<?php echo $category->slug; ?>"><?php echo $category->cat_name?></option>
                            <?php
								}
                            ?>
                        </select>
                        <p>Select gallery album to show images.</p>
                    </li>
                </ul>
                
                <ul class="form-elements">
                    <li class="to-label"><label>Pagination</label></li>
                    <li class="to-field">
                        <select name="cs_gal_album_pagination[]" class="dropdown" >
                            <option <?php if($cs_gal_pagination_db=="Show Pagination")echo "selected";?> >Show Pagination</option>
                            <option <?php if($cs_gal_pagination_db=="Single Page")echo "selected";?> >Single Page</option>
                        </select>
                    </li>
                </ul>
				<ul class="form-elements" >
                    <li class="to-label"><label>No. of Media Per Page</label></li>
                    <li class="to-field">
                    	<input type="text" name="cs_gal_album_media_per_page[]" class="txtfield" value="<?php echo $cs_gal_media_per_page_db; ?>" />
                        <p>To display all the records, leave this field blank.</p>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="gallery_albums" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_gallery_albums', 'cs_pb_gallery_albums');
// Sets gallery html form for page builder end
// slider html form for page builder start
function cs_pb_slider($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$slider_element_size = '50';
		$cs_slider_header_title_db = '';
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
		$cs_blog_cat_db = '';
		$cs_blog_excerpt_db = '255';
		$cs_blog_num_post_db = get_option("posts_per_page");
		$cs_blog_pagination_db = '';
		$cs_blog_pagination_db = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$blog_element_size = $cs_node->blog_element_size;
			$cs_blog_title_db = $cs_node->cs_blog_title;
			$cs_blog_view_db = $cs_node->cs_blog_view;
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
                    <li class="to-label"><label>Select View</label></li>
                    <li class="to-field">
                        <select name="cs_blog_view[]" class="dropdown">
                         	<option <?php if($cs_blog_view_db=="blog-large")echo "selected";?> value="blog-large">Blog Large Image</option>
                            <option <?php if($cs_blog_view_db=="blog-medium")echo "selected";?> value="blog-medium">Blog Medium Image</option>
                            <option <?php if($cs_blog_view_db=="blog-home")echo "selected";?> value="blog-home">Blog Home</option>
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
                            <option <?php if($cs_blog_pagination_db=="yes")echo "selected";?> value="yes">Yes</option>
                            <option <?php if($cs_blog_pagination_db=="no")echo "selected";?> value="no">No</option>
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
                            <option value="List View 1" <?php if($cs_event_view_db=="List View 1")echo "selected";?> >List View 1</option>
                            <option value="List View 2" <?php if($cs_event_view_db=="List View 2")echo "selected";?> >List View 2</option>
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
	if (empty($_POST["event_start_time"])){ $_POST["event_start_time"] = "";}
	if (empty($_POST["event_end_time"])){ $_POST["event_end_time"] = "";}
    if (empty($_POST["event_all_day"])){ $_POST["event_all_day"] = "";}
    if (empty($_POST["event_buy_now"])){ $_POST["event_buy_now"] = "";}
    if (empty($_POST["event_ticket_price"])){ $_POST["event_ticket_price"] = "";}
    if (empty($_POST["event_gallery"])){ $_POST["event_gallery"] = "";}
    if (empty($_POST["event_address"])){ $_POST["event_address"] = "";}
    if (empty($_POST["event_map"])){ $_POST["event_map"] = "";}
	if (empty($_POST["event_phone_no"])){ $_POST["event_phone_no"] = "";}
	if (empty($_POST["event_ticket_options"])){ $_POST["event_ticket_options"] = "";}
    	
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
 		$sxe->addChild('event_start_time', $_POST["event_start_time"]);
		$sxe->addChild('event_end_time', $_POST["event_end_time"]);
		$sxe->addChild('event_all_day', $_POST["event_all_day"]);
		$sxe->addChild('event_buy_now', $_POST["event_buy_now"]);
		$sxe->addChild('event_ticket_price', $_POST["event_ticket_price"]);
		$sxe->addChild('event_gallery', $_POST["event_gallery"]);
 		$sxe->addChild('event_address', $_POST["event_address"]);
		$sxe->addChild('event_map', $_POST["event_map"]);
		$sxe->addChild('event_phone_no', $_POST["event_phone_no"]);
		$sxe->addChild('event_ticket_options', $_POST["event_ticket_options"]);
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
	// Theme default widgets activation
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
		"showcount" => '2',
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
		"title"		=>	'Events',
		"get_post_slug" 	=> 'gigs',
		"showcount" => '3',
 		 );						
		$upcoming_events_widget['_multiwidget'] = '1';
		update_option('widget_cs_upcoming_events',$upcoming_events_widget);
		$upcoming_events_widget = get_option('widget_cs_upcoming_events');
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
			'title' => 'Soundcloud',
			'text' => '<iframe width="100%" height="470" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=http%3A%2F%2Fapi.soundcloud.com%2Fplaylists%2F1785700&amp;color=262626&amp;auto_play=false&amp;show_artwork=true"></iframe>',
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
		// --- text widget setting ---
		$text2 = array();
		$text2 = get_option('widget_text');
		$text2[2] = array(
			'title' => '',
			'text' => ' <figure><a href="'.site_url().'"><img src="'.get_template_directory_uri() . '/images/add1.jpg" alt=""></a></figure>',
		);						
		$text2['_multiwidget'] = '2';
		update_option('widget_text',$text2);
		$text = get_option('widget_text');
		krsort($text2);
		foreach($text2 as $key1=>$val1)
		{
			$text_key2 = $key1;
			if(is_int($text_key2))
			{
				break;
			}
		}
		//----text widget for contact info----------
		$text4 = array();
		$text4 = get_option('widget_text');
		$text4[4] = array(
			'title' => 'Contact Info',
			'text' => '<div class="text-info">
                        <div class="postel-text">
                        	<p>Practical Components, Inc. 10762 Noel Street,
                            City of Newyork,
                            United States of Amarica
                            </p>
                        </div>
                        <ul>
                        	<li>
                                <span>Phone</span>
                                <p>123.456.78910</p>
                            </li>
                            <li>
                            	<span>Mobile</span>
                                <p>(800) 123 4567 89</p>
                             </li>
                             <li>
                                <span>Email</span>
                                <p>resturant@resturant.com</p>
                             </li>
                             <li>   
                                <span>Timming</span>
                                <p class="small">Mon-Thu (09:00 to 17:30)</p>
                            </li>
                        </ul>
                    </div>',

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
		"fb_bg_color" =>"#000",
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
		$sidebars_widgets['Sidebar'] = array("cs_upcoming_events-$upcoming_events_widget_key", "categories-$categories_key","cs_recentposts-$recent_post_widget_key","cs_gallery-$cs_gallery_key","cs_facebook_module-$facebook_module_key","tag_cloud-$tag_cloud_key","calendar-$calendar_key");
		$sidebars_widgets['events'] = array("cs_gallery-$cs_gallery_key","cs_facebook_module-$facebook_module_key","tag_cloud-$tag_cloud_key","calendar-$calendar_key");
		$sidebars_widgets['Home'] = array("cs_upcoming_events-$upcoming_events_widget_key", "text-$text_key", "text-$text_key2");
		$sidebars_widgets['Blog Detail'] = array("categories-$categories_key", "cs_recentposts-$recent_post_widget_key", "text-$text_key", "text-$text_key2");
		$sidebars_widgets['footer-widget'] = array("text-$text_key4","categories-$categories_key","cs_gallery-$cs_gallery_key","cs_twitter_widget-$cs_twitter_widget_key");
		$sidebars_widgets['shopdetail'] = array();
		update_option('sidebars_widgets',$sidebars_widgets);  //save widget informations
	}
 	// Install data on theme activation
   	function cs_activation_data() {
		global $wpdb;
		$args = array(
			'style_sheet' => 'custom',
			'custom_color_scheme' => '#ff3f00',
			'heading_color_scheme' => '#FFFFFF',
			'color_option' => 'black',
			// footer Color Settigs
			'layout_option' => 'wrapper_boxed',
			'header_styles' => 'header1',
			'default_header' => 'header1',
			'bg_img' => '9',
			'bg_img_custom' => '',
			'bg_position' => 'center',
			'bg_repeat' => 'no-repeat',
			'bg_attach' => 'fixed',
			'pattern_img' => '0',
			'custome_pattern' => '',
			'bg_color' => '',

			'logo' => get_template_directory_uri().'/images/logo.png',
			'logo_width' => '164',
			'logo_height' => '52',
			'header_sticky_menu' => 'on',
			//'logo_sticky' => get_template_directory_uri().'/images/logo.png',
			'fav_icon' => get_template_directory_uri() . '/images/favicon.ico',
			'header_code' => '',
			'header_booking_phone_no' => 'For Booking : +420 224 2245',
			'header_languages' => '',
			'header_cart' => '',
			'footer_widget' => 'on',
			'copyright' =>  '&copy;'.gmdate("Y")." ".get_option("blogname")." WordPress All rights reserved.", 
			'powered_by' => 'Design by <a href="#">ChimpStudio</a>',
			'powered_icon' => '',
			'analytics' => '',
			'responsive' => 'on',
			'style_rtl' => '',
			// switchers
			'color_switcher' => '',
			'trans_switcher' => '',
			'search_switcher' => 'on',
			'login_switcher' => 'on',
			'show_slider' => '',
			'slider_name' => 'slider',
			'slider_type' => 'Flex Slider',
			'post_title' => '',
			'show_player' => '',
			'album_name' => 'music',
			'show_partners' => 'on',
			'partner_gallery_title' => 'Partner',
			'partner_gallery_name' => 'partners-gallery',
			'sidebar' => array( 'Sidebar', 'Home', 'Blog Detail', 'events', 'shopdetail'),
			
			// slider setting
			'flex_effect' => 'fade',
			'flex_auto_play' => 'on',
			'flex_animation_speed' => '7000',
			'flex_pause_time' => '600',
			'slider_id' => '[rev_slider rocky]',
			'slider_view' => '',
			'social_net_title' => '',
			'social_net_icon_path' => array('', '', '', '', '', '', '', '', '', ''),
			'social_net_awesome' => array( 'fa-facebook', 'fa-twitter', 'fa-google-plus', 'fa-dribbble', 'fa-linkedin', 'fa-youtube', 'fa-instagram', 'fa-pinterest', 'fa-tumblr', 'fa-flickr' ),
			'social_net_url' => array( 'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK', 
								'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK', 
								'YOUR_PROFILE_LINK'
								),
			'social_net_tooltip' => array( 'Facebook', 'Twitter', 'Google Plus', 'Dribble', 'LInked In', 'Youtube', 'Instagram', 'Pinterest', 'Tumblr', 'Flickr' ),
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
			'cs_other_share' => 'on',
			'mailchimp_key' => '90f86a57314446ddbe87c57acc930ce8-us2',
			// tranlations
			
			'trans_album_tracks' => 'Tracks',
			'trans_album_buynow' => 'Buy Now',
			'trans_album_play_now' => 'Play Now',
			'trans_album_release_date' => 'Release Date',
			'trans_album_label' => 'Label',
			'trans_album_available' => 'Avaialable on',
			
			'trans_event_free_entry' => 'Free Entry',
			'trans_event_sold_out' => 'Sold Out',
			'trans_event_cancelled' => 'Cancelled',
            'trans_event_buy_ticket' => 'Buy Ticket',
			'trans_event_from' => 'From:',

			'trans_event_days_to_go' => 'Days to go!',
			'trans_event_days_before' => 'Days before!',
			'trans_event_joining' => 'I am joining',
			'trans_event_coming' => 'Coming',
			'trans_event_thanks' => 'Thanks for joining',
			
            'trans_subject' => 'Subject',
			'trans_contact_no' => 'Phone',
            'trans_message' => 'Message',
            'trans_form_title' => 'Send us a Quick Message',
			'trans_form_email_published' => 'Your Email will never published.',
			
            'trans_follow_twitter' => 'Follow Us on Twitter',
			'trans_gallery_set' => 'View Set',
            'trans_share_this_post' => 'Share Now',
            'trans_content_404' => "It seems we can not find what you are looking for.",
			'trans_other_prev' => 'Previous',
			'trans_read_more' => 'read more',
			'trans_current_page' => 'Current Page',
			// translation end

           	'pagination' => 'Show Pagination',
			'record_per_page' => '5',
			'cs_layout' => 'right',
			'cs_sidebar_left' => '',
			'cs_sidebar_right' => 'Sidebar',
			'under-construction' => '',
			'showlogo' => 'on',
			'under_construction_text' => '<h4>OUR WEBSITE IS UNDERCONSTRUCTION</h1><h4>We\'ll be here soon with a new website, Estimated Time Remaining</h4>',
			'launch_date' => '2014-12-01',
			'screen_name' => 'envato',
			'consumer_key' => 'BUVzW5ThLW8Nbmk9rSFag',
			'consumer_secret' => 'J8LDM3SOSNuP2JrESm8ZE82dv9NtZzer091ZjlWI',
		);
		/* Merge Heaser styles
		*/
		update_option("cs_theme_option", $args );
		update_option("cs_theme_option_restore", $args );
		update_option("show_on_front", 'page' );
		update_option("TWITTER_BEARER_TOKEN", 'AAAAAAAAAAAAAAAAAAAAAGt%2FSAAAAAAAc7UCkKRfPuPoB6HE1TAQWmd%2FNmQ%3DNqMKXtYlXw7ELrLszYipiree7idpL4zDP53fSFxzYg' );
}
// Admin scripts enqueue
function cs_admin_scripts_enqueue() {
    $template_path = get_template_directory_uri() . '/scripts/admin/media_upload.js';
    wp_enqueue_script('my-upload', $template_path, array('jquery', 'media-upload', 'thickbox', 'jquery-ui-droppable', 'jquery-ui-datepicker', 'jquery-ui-slider', 'wp-color-picker'));
    wp_enqueue_script('custom_wp_admin_script', get_template_directory_uri() . '/scripts/admin/cs_functions.js');
    wp_enqueue_style('custom_wp_admin_style', get_template_directory_uri() . '/css/admin/admin-style.css', array('thickbox'));
	wp_enqueue_style('wp-color-picker');
}

// Inclue Template files
require_once (TEMPLATEPATH . '/include/album.php');
require_once (TEMPLATEPATH . '/include/event.php');
require_once (TEMPLATEPATH . '/include/slider.php');
require_once (TEMPLATEPATH . '/include/gallery.php');
require_once (TEMPLATEPATH . '/include/page_builder.php');
require_once (TEMPLATEPATH . '/include/post_meta.php');
require_once (TEMPLATEPATH . '/include/short_code.php');
require_once (TEMPLATEPATH . '/functions-theme.php');
require_once (TEMPLATEPATH . '/include/mailchimpapi/mailchimpapi.class.php');
require_once (TEMPLATEPATH . '/include/mailchimpapi/chimp_mc_plugin.class.php');
/////// Require Woocommerce///////
require_once (TEMPLATEPATH . '/include/config_woocommerce/config.php');
require_once (TEMPLATEPATH . '/include/config_woocommerce/product_meta.php');
/////////////////////////////////
if (current_user_can('administrator')) {
	// Addmin Menu CS Theme Option
	require_once (TEMPLATEPATH . '/include/theme_option.php');
	add_action('admin_menu', 'cs_theme');
	function cs_theme() {
		add_theme_page('CS Theme Option', 'CS Theme Option', 'read', 'cs_theme_options', 'theme_option');
	}
}
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
       for($i=1; $i<=3; $i++){?>
    		<option value="<?php echo 'header'.$i;?>" <?php if( $cs_theme_option['header_styles']=='header'.$i){ echo 'selected="selected"';}?>><?php echo 'Header '.$i;?></option>
		<?php }
}
// enque style and scripts
function cs_front_scripts_enqueue() {
	global $cs_theme_option;
     if (!is_admin()) {
		wp_enqueue_style('style_css', get_template_directory_uri() . '/style.css');
		wp_enqueue_style('widget_css', get_template_directory_uri() . '/css/widget.css');
		//wp_enqueue_style('color_css', get_template_directory_uri() . '/css/color.css');
  		if ( $cs_theme_option['color_switcher'] == "on" ) {
			wp_enqueue_style('color-switcher_css', get_template_directory_uri() . '/css/color-switcher.css');
		}
  		wp_enqueue_style('bootstrap_css', get_template_directory_uri() . '/css/bootstrap.css');
 		wp_enqueue_style('font-awesome_css', get_template_directory_uri() . '/css/font-awesome.css');
		// Register stylesheet
    	wp_enqueue_style( 'ie8_css', get_template_directory_uri() . '/css/ie8.css' );
		wp_enqueue_style( 'iegrid_css', get_template_directory_uri() . '/css/iegrid.css' );
		

    	// Apply IE conditionals
    	$GLOBALS['wp_styles']->add_data( 'ie8_css', 'conditional', 'lte IE 8' );
		$GLOBALS['wp_styles']->add_data( 'font-awesome-ie7_css', 'conditional', 'lte IE 9' );
    	// Enqueue stylesheet
    	wp_enqueue_style( 'ie8_css' );
		
		wp_enqueue_style( 'font-awesome-ie7_css' );
   		wp_enqueue_style( 'wp-mediaelement' );
 		    wp_enqueue_script('jquery');
			wp_enqueue_script( 'wp-mediaelement' );
			wp_enqueue_script('bootstrap_js', get_template_directory_uri() . '/scripts/frontend/bootstrap.js', '', '', true);
   			wp_enqueue_script('jquery.nicescroll_js', get_template_directory_uri() . '/scripts/frontend/jquery.nicescroll.js', '0', '', true);
			wp_enqueue_script('jquery.nicescrollpjus_js', get_template_directory_uri() . '/scripts/frontend/modernizr.js', '0', '', true);
			wp_enqueue_script('bscrolltofixed_js', get_template_directory_uri() . '/scripts/frontend/jquery-scrolltofixed.js', '', '', true);
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
// Gallery Script Enqueue
function cs_enqueue_gallery_style_script(){
	wp_enqueue_style('prettyPhoto_css', get_template_directory_uri() . '/css/prettyphoto.css');
	wp_enqueue_script('prettyPhoto_js', get_template_directory_uri() . '/scripts/frontend/jquery.prettyphoto.js', '', '', true);
}
// Masonry Style and Script enqueue
function cs_enqueue_masonry_style_script(){
 	wp_enqueue_script('jquery.masonry_js', get_template_directory_uri() . '/scripts/frontend/jquery.masonry.min.js', '', '', true);
	wp_enqueue_style('masonry_css', get_template_directory_uri() . '/css/masonry.css');
	
}

// infinite scroll and Script enqueue
function cs_enqueue_infinitescroll_script(){
 	wp_enqueue_script('manual-trigger_js', get_template_directory_uri() . '/scripts/frontend/infinite-scroll/behaviors/manual-trigger.js', '', '', true);
	wp_enqueue_script('jquery.infinitescroll_js', get_template_directory_uri() . '/scripts/frontend/infinite-scroll/jquery.infinitescroll.js', '', '', true);
	
}
// header Style enqueue
function cs_enqueue_header_style_script(){
	wp_enqueue_style('header_css', get_template_directory_uri() . '/css/header.css');
	
}
function cs_scrolltofixed_script(){
   	wp_enqueue_script('sticky_scrolltofixed_js', get_template_directory_uri() . '/scripts/frontend/jquery-scrolltofixed.js', '', '', true);
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
// Event Calendar enqueue Script
function cs_event_countdown_scripts() {
     wp_enqueue_script('event_countdown_js', get_template_directory_uri() . '/scripts/frontend/jquery.countdown.js', '', '', TRUE);
}
function cs_cycleslider_script(){
	wp_enqueue_script('jquerycycle2_js', get_template_directory_uri() . '/scripts/frontend/jquerycycle2.js', '', '', true);
	wp_enqueue_script('cycleslider_js', get_template_directory_uri() . '/scripts/frontend/cycle2carousel.js', '', '', true);
} 
function cs_addthis_script_init_method(){
	if( is_single()){
		wp_enqueue_script( 'cs_addthis', 'http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e4412d954dccc64', ",",'true');
	}
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

// Favicon and header code in head tag//
function cs_footer_settings() {
    global $cs_theme_option;
     echo htmlspecialchars_decode($cs_theme_option['analytics']);
}
// Get Header Name
function cs_get_header_name(){
	global $post, $cs_theme_option;
	if ( isset($_POST['header_styles']) ) {
			$_SESSION['spikes_sess_header_styles'] = $_POST['header_styles'];
			$header_styles = $_SESSION['spikes_sess_header_styles'];
	}
	else if ( !empty($_SESSION['spikes_sess_header_styles']) ) {
			$header_styles = $_SESSION['spikes_sess_header_styles'];
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

// Home page Slider //
function cs_get_home_slider(){
    global $cs_theme_option;
	if($cs_theme_option['show_slider'] =="on"){
		if($cs_theme_option['slider_type'] <> ""){
				$width = 1080;
				$height = 468;
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
								  _e("No results found.",'Spikes');
						  echo ' </h5></div>';
					  }
				  }
		}
	}
}
// Home page album
function cs_get_home_player(){
	global $cs_theme_option;
	if($cs_theme_option['album_name'] <> ''){
	$album_id='';
	$args=array(
		'name' => $cs_theme_option['album_name'],
		'post_type' => 'albums',
		'post_status' => 'publish',
		'showposts' => 1,
	  );
	  $get_posts = get_posts($args);
	  if($get_posts){
		  $album_id = $get_posts[0]->ID;
	  }
	$cs_album = get_post_meta($album_id, "cs_album", true);
	if ( $cs_album <> "" ) {
	?>
    <script type="text/javascript">
	   jQuery(document).ready(function() {
			cs_playlist_toggle();
		 });
    </script>
    <!-- Audio Plyer Strat -->
     <div class="audio-plyer webkit">
            <div class="container">
                <div id="player">
                    <div id="jquery_jplayer_n" class="jp-jplayer"></div>
                    <div id="jp_container_n" class="jp-audio">
                        <div class="jp-type-playlist">
                            <div class="jp-gui">
                                <div class="jp-interface">
                                    <div class="jp-controls-holder">
                                        <ul class="jp-controls audio-control">
                                            <li>
                                                <a href="javascript:;" class="jp-previous" tabindex="1"> <em class="fa fa-backward"></em>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" class="jp-play" tabindex="1"> <em class="fa fa-play"></em>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" class="jp-pause" tabindex="1">
                                                    <em class="fa fa-pause"></em>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" class="jp-next" tabindex="1">
                                                    <em class="fa fa-forward"></em>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="main-progress">
                                            
                                            <div class="jp-current-time"></div>
                                            <div class="jp-progress">
                                                <div class="jp-seek-bar">
                                                    <div class="jp-play-bar bgcolr"></div>
                                                </div>
                                            </div>
                                            <div class="jp-duration"></div>
                                            <div class="volume-wrap">
                                                <a title="mute" tabindex="1" class="jp-mute" href="javascript:;"><em class="fa fa-volume-down"></em></a>
                                                <a title="unmute" tabindex="1" class="jp-unmute" href="javascript:;" style="display: none;"><em class="fa fa-volume-off"></em></a>
                                                <div class="jp-volume-bar">
                                                    <div class="jp-volume-bar-value bgcolr" style="width: 80%;"></div>
                                                </div>
                                                <a title="max volume" tabindex="1" class="jp-volume-max" href="javascript:;"><em class="fa fa-volume-up"></em></a>
                                            </div>
                                            <a href="#playheader" class="jp-playlist-icon btntoggle webkit"><span><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Play Now','Spikes');}else{ echo $cs_theme_option['trans_album_play_now']; } ?></span><em class="fa fa-chevron-down"></em></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="jp-playlist " id="playheader">
                                <div class="wrapper-payerlsit">
                                <ul>
                                    <!-- The method Playlist.displayPlaylist() uses this unordered list -->                    
                                    <li></li>
                                </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   <!-- Audio Plyer End -->
    <?php
		
		 
		$cs_xmlObject = new SimpleXMLElement($cs_album);
			 $counter_load_tracks = count($cs_xmlObject->track);
			 if($counter_load_tracks >0){
			 $playtracks = '';
			 cs_enqueue_jplayer();
			 	 foreach ( $cs_xmlObject->track as $track ){
							$filetype = wp_check_filetype($track->album_track_mp3_url);
							if(isset($track->album_track_playable) && $track->album_track_playable == 'Yes' && $filetype['ext'] == 'mp3'){
								$counter_load_tracks++;
								$playtracks .= '{
											title:"'.$track->album_track_title.'",
											mp3:"'.$track->album_track_mp3_url.'"
										},';
							}
			 	}
			}
		
			?>
	<script>
        jQuery(document).ready(function($) {
            var myPlaylist = new jPlayerPlaylist({
            jPlayer: "#jquery_jplayer_n",
            cssSelectorAncestor: "#jp_container_n"
        }, [
            <?php echo $playtracks;?>
        ], {
            swfPath: "js",
            supplied: "mp3",
            wmode: "window",
            smoothPlayBar: true,
            keyEnabled: true
        });
        });
    </script>
   <?php
	}}
}
// Pages Subheader Section at front end //
function cs_get_subheader(){
 ?>
        <div class="breadcrumb fullwidth default-image">
            <!-- Container Start -->
           <div class="container">
        	<div class="breadcrumb-inner">
           	   <?php
                  // Page Subheader Title and subtitle
				  if(function_exists("is_shop") and is_shop()){
					$cs_shop_id = woocommerce_get_page_id( 'shop' );
					echo "<div class='subtitle float-left bgcolr'><h1 class=\"page-title\">".get_the_title($cs_shop_id)."</h1></div>";
					}else if(function_exists("is_shop") and !is_shop()){
						cs_get_subheader_title();
					}else{
						cs_get_subheader_title();
					}
					//cs_breadcrumbs();	  
			   ?>
            </div>
        </div>
    <!-- Container End -->
    </div>
    <?php

}
// Page Sub header title and subtitle //
function cs_get_subheader_title(){
	global $post;
  	?>
    <div class="subtitle float-left bgcolr">
		<?php 
			if (is_page() || is_single()) {

					echo '<h1 class="page-title">' . substr(get_the_title(), 0, 40) . '</h1>';
		  } else { ?>
             <h1 class="page-title"><?php cs_post_page_title(); ?></h1>
		 <?php }?> 
    </div>
    <?php
}

/*------Header Functions End------*/
// password protect post/page
if ( ! function_exists( 'cs_password_form' ) ) {
	function cs_password_form() {
		global $post,$cs_theme_option;
		$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
		$o = '<div class="password_protected">
				<div class="password-content">
                    <div class="protected-icon"><a href="#"><i class="fa fa-unlock-alt fa-4x"></i></a></div>
					<h3>' . __( "This post is password protected. To view it please enter your password below:",'Spikes' ) . '</h3>';
		$o .= '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
					<label><input name="post_password" id="' . $label . '" type="text" value="' . __( "Password",'Spikes' ) . '"/></label>
					<label class="before-icon"><input class="backcolr" type="submit" name="submit" value="" /></label>
				</form>
			  </div>
			</div>';
		return $o;
	}
}
//////////////// Header Cart ///////////////////
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	if ( class_exists( 'woocommerce' ) ){
		global $woocommerce;
		ob_start();
		?>
		<div class="cart-secc">
			<i class="fa fa-shopping-cart"></i><a class="amount backcolr" href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><?php echo $woocommerce->cart->cart_contents_count; ?></a>
		</div>
		<?php
		$fragments['div.cart-secc'] = ob_get_clean();
		return $fragments;
	}
}


function cs_woocommerce_header_cart() {
	if ( class_exists( 'woocommerce' ) ){
		global $woocommerce;
		?>
		<div class="cart-secc">
			<i class="fa fa-shopping-cart"></i><a class="amount backcolr" href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><?php echo $woocommerce->cart->cart_contents_count; ?></a>
		</div>
		<?php
	}
}
//////////////// Header Cart Ends ///////////////////
/* Add specific id in Menu */
function cs_add_menuid($ulid) {
	return preg_replace('/<ul>/', '<ul id="menus">', $ulid, 1);
}
/* remove specific div in Menu */
function cs_remove_div ( $menu ){
    return preg_replace( array( '#^<div[^>]*>#', '#</div>$#' ), '', $menu );
}
function cs_register_my_menus() {
  register_nav_menus(
	array(
		'main-menu'  => __('Main Menu','Spikes')
 	)
  );
}
/* add filter for parent css in Menu */
function cs_add_parent_css($classes, $item) {
    global $menu_children;
    if ($menu_children)
        $classes[] = 'parent';
    return $classes;
}
// search varibales start
function cs_get_search_results($query) {
	if ( !is_admin() and (is_search())) {
		$query->set( 'post_type', array('post', 'events' ) );
		remove_action( 'pre_get_posts', 'cs_get_search_results' );
	}
}
function cs_change_query_vars($query) {
    if (is_search()|| is_home()) {
        if (empty($_GET['page_id_all']))
            $_GET['page_id_all'] = 1;
       $query->query_vars['paged'] = $_GET['page_id_all'];
	   return $query;
	}
	 // Return modified query variables
}
// Filter shortcode in text areas
if ( ! function_exists( 'cs_textarea_filter' ) ) {
	function cs_textarea_filter($content=''){
		return do_shortcode($content);
	}
}
/* Display navigation to next/previous for single.php */
if ( ! function_exists( 'cs_next_prev_post' ) ) { 
	function cs_next_prev_post(){
	global $post;
	posts_nav_link();
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	if ( ! $next && ! $previous )
		return;
	?>
    	<div class="post-btn">
 			<?php 
				previous_post_link( '%link', '<i class="fa fa-angle-left fa-1x"></i>' ); 
				next_post_link( '%link','<i class="fa fa-angle-right fa-1x"></i>' );
			 ?>
		</div>
	<?php
	}
}
/*	Add Featured/sticky text/icon for sticky posts. */
if ( ! function_exists( 'cs_featured()' ) ) {
	function cs_featured(){
		if ( is_sticky() ){ ?>
			<ul><li class="featured"><i class="fa fa-thumb-tack"></i></li></ul>
		<?php
		}
	}
}
// Custom excerpt function 
function cs_get_the_excerpt($limit,$readmore = '') {
	global $cs_theme_option;
    $get_the_excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU', '', get_the_excerpt()));
    echo substr($get_the_excerpt, 0, "$limit");
    if (strlen($get_the_excerpt) > "$limit") {
		if($readmore == "true"){
        	echo '... <a href="' . get_permalink() . '" class="colr">' . $cs_theme_option['trans_read_more'] . '</a>';
		}
    }
}
/* register custom sidebar */
$cs_theme_option = get_option('cs_theme_option');
if ( isset($cs_theme_option['sidebar']) and !empty($cs_theme_option['sidebar'])) {
	foreach ( $cs_theme_option['sidebar'] as $sidebar ){
		register_sidebar(array(
			'name' => $sidebar,
			'id' => $sidebar,
			'description' => 'This widget will be displayed on side of the page.',
			'before_widget' => '<div class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<header class="cs-heading-title"><h2 class="cs-section-title cs-heading-color">',
			'after_title' => '</h2></header>'
		));
	}
}
/* register footer widget */
register_sidebar( array(
	'name' => 'Footer Widget',
	'id' => 'footer-widget',
	'description' => 'This Widget Show the Content in Footer Area.',
	'before_widget' => '<div class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<header class="cs-heading-title"><h2 class="cs-section-title cs-heading-color">',
	'after_title' => '</h2></header>'
) );
/* flexslider function */
if ( ! function_exists( 'cs_flex_slider' ) ) {
	function cs_flex_slider($width,$height,$slider_id){
		global $cs_node,$cs_theme_option,$counter_node;
		$counter_node++;
		if($slider_id == ''){
			$slider_id = $cs_node->slider;
		}
		if($cs_theme_option['flex_auto_play'] == 'on'){$auto_play = 'true';}
			else if($cs_theme_option['flex_auto_play'] == ''){$auto_play = 'false';}
			$cs_meta_slider_options = get_post_meta($slider_id, "cs_meta_slider_options", true); 
		?>
		<!-- Flex Slider -->
		<div id="flexslider<?php echo $counter_node; ?>">
		  <div class="flexslider">
			  <ul class="slides">
				<?php 
					$counter = 1;
					$cs_xmlObject_flex = new SimpleXMLElement($cs_meta_slider_options);
					foreach ( $cs_xmlObject_flex->children() as $as_node ){
						
 						$image_url = cs_attachment_image_src($as_node->path,$width,$height); 
						?>
						<li>
							<img src="<?php echo $image_url ?>" alt="" />
							<!-- Caption Start -->
							<?php 
								if($as_node->title != '' && $as_node->description != '' || $as_node->title != '' || $as_node->description != ''){ 
								$as_node->cs_slider_link ="";
								if($as_node->link <> ''){}
								
							?>
                            <div class="caption">
								<?php if($as_node->link <> ''){ 
                                             echo '<a href="'.$as_node->link.'" target="'.$as_node->link_target.'">';
                                        }
                                        ?>
                                   <h1><?php echo $as_node->title; ?></h1>
                                 <?php if($as_node->link <> ''){
                                            echo '</a>';
                                        }
									if($as_node->description <> ''){	
                                    ?>
                                		<p><?php echo $as_node->description;?></p>
                                <?php }?>
                        </div>
                        <!-- Caption End -->
                        <?php } ?>
						</li>
					<?php 
					$counter++;
					}
				?>
			  </ul>
		  </div>
		</div>
		<?php cs_enqueue_flexslider_script(); ?>
 		<!-- Flex Slider Javascript Files -->
		<script type="text/javascript">
			jQuery(window).load(function(){
				var speed = <?php echo $cs_theme_option['flex_animation_speed']; ?>; 
				var slidespeed = <?php echo $cs_theme_option['flex_pause_time']; ?>;
				jQuery('#flexslider<?php echo $counter_node; ?> .flexslider').flexslider({
					animation: "<?php echo $cs_theme_option['flex_effect']; ?>", // fade
					slideshow: <?php echo $auto_play;?>,
					slideshowSpeed:speed,
					animationSpeed:slidespeed
					
				});
			});
		</script>
	<?php
	}
}
/*  Social Share Function */
if ( ! function_exists( 'cs_social_share' ) ) {
	function cs_social_share($icon_type = '', $title='true') {
		global $cs_theme_option;
		$share = '';
		cs_addthis_script_init_method();
		if($icon_type=='small'){
			$icon = 'icon';
		} else {
			$icon = 'icon';
		}
		$html = '';
		$pageurl = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		$path = get_template_directory_uri() . "/images/admin/";
		$html ='<div class="social-network backcolr">';
			if (isset($cs_theme_option['cs_other_share']) && $cs_theme_option['cs_other_share'] == 'on') {
				$html .= '<h6>';
					if($cs_theme_option["trans_switcher"] == "on") { $share .= __("Share this post",'Spikes'); }else{  $share =  $cs_theme_option["trans_share_this_post"];}
					$html .='<a class="addthis_button_compact fa fa-share-square-o"><span>'.$share.'</span></a>';
				$html .= '</h6>';
			}
 			$html .='</div>';
			echo $html;
	}
}
/* Social network */
if ( ! function_exists( 'cs_social_network' ) ) {
	function cs_social_network($tooltip='', $icon=''){
		global $cs_theme_option;
		$tooltip_data='';
		echo '<div class="social-network">';
		if(isset($cs_theme_option['social_net_title']) && $cs_theme_option['social_net_title'] <> ''){
			echo '<h5>';
				echo $cs_theme_option['social_net_title'];
			echo '</h5>';
		}
				if(isset($tooltip) && $tooltip <> ''){
					$tooltip_data='data-placement-tooltip="tooltip"';
				}
				if ( isset($cs_theme_option['social_net_url']) and count($cs_theme_option['social_net_url']) > 0 ) {
						$i = 0;
						foreach ( $cs_theme_option['social_net_url'] as $val ){
							?>
					<?php if($val != ''){?><a title="" href="<?php echo $val;?>" data-original-title="<?php echo $cs_theme_option['social_net_tooltip'][$i];?>" data-placement="top" <?php echo $tooltip_data;?> class="colrhover"  target="_blank"><?php if($cs_theme_option['social_net_awesome'][$i] <> '' && isset($cs_theme_option['social_net_awesome'][$i])){?><i class="fa <?php echo $cs_theme_option['social_net_awesome'][$i];?> <?php echo $icon;?>"></i><?php } else {?><img src="<?php echo $cs_theme_option['social_net_icon_path'][$i];?>" alt="<?php echo $cs_theme_option['social_net_tooltip'][$i];?>" /><?php }?></a><?php }
							
						$i++;}
		}
		echo '</div>';
	}
}
/* breadcrumb function */
if ( ! function_exists( 'cs_breadcrumbs' ) ) { 
	function cs_breadcrumbs() {
		global $wp_query, $cs_theme_option;
		/* === OPTIONS === */
		$text['home']     = 'Home'; // text for the 'Home' link
		$text['category'] = '%s'; // text for a category page
		$text['search']   = '%s'; // text for a search results page
		$text['tag']      = '%s'; // text for a tag page
		$text['author']   = '%s'; // text for an author page
		$text['404']      = 'Error 404'; // text for the 404 page
	
		$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
		$showOnHome  = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$delimiter   = ''; // delimiter between crumbs
		$before      = '<li class="cs-active">'; // tag before the current crumb
		$after       = '</li>'; // tag after the current crumb
		/* === END OF OPTIONS === */
	
		global $post;
		$homeLink = home_url() . '/';
		$linkBefore = '<li>';
		$linkAfter = '</li>';
		$linkAttr = '';
		$link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;
		$linkhome = $linkBefore . '<a' . $linkAttr . ' href="%1$s"><i class="icon-home"></i>%2$s</a>' . $linkAfter;
		if($cs_theme_option['trans_switcher'] == "on"){ $current_page = __('Current Page','Spikes');}else{ $current_page = $cs_theme_option['trans_current_page']; }
		if (is_home() || is_front_page()) {
	
			if ($showOnHome == "1") echo '<div class="breadcrumbs"><ul>'.$before.'<a href="' . $homeLink . '"><i class="icon-home"></i>' . $text['home'] . '</a>'.$after.'</ul></div>';
	
		} else {
			echo '<div class="breadcrumbs"><ul>' . sprintf($linkhome, $homeLink, $text['home']) . $delimiter;
			if ( is_category() ) {
				$thisCat = get_category(get_query_var('cat'), false);
				if ($thisCat->parent != 0) {
					$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
					$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
					$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
					echo $cats;
				}
				echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;
			} elseif ( is_search() ) {
				echo $before . sprintf($text['search'], get_search_query()) . $after;
			} elseif ( is_day() ) {
				echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
				echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
				echo $before . get_the_time('d') . $after;
			} elseif ( is_month() ) {
				echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
				echo $before . get_the_time('F') . $after;
			} elseif ( is_year() ) {
				echo $before . get_the_time('Y') . $after;
			} elseif ( is_single() && !is_attachment() ) {
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
					if ($showCurrent == 1) echo $delimiter . $before . $current_page . $after;
				} else {
					$cat = get_the_category(); $cat = $cat[0];
					$cats = get_category_parents($cat, TRUE, $delimiter);
					if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
					$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
					$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
					echo $cats;
					if ($showCurrent == 1) echo $before .$current_page . $after;
				}
			} elseif ( !is_single() && !is_page() && get_post_type() <> '' && get_post_type() != 'post' && get_post_type() <> 'events' && get_post_type() <> 'cs_menu' && !is_404() ) {
					$post_type = get_post_type_object(get_post_type());
					echo $before . $post_type->labels->singular_name . $after;
			} elseif (isset($wp_query->query_vars['taxonomy']) && !empty($wp_query->query_vars['taxonomy'])){
				$taxonomy = $taxonomy_category = '';
				$taxonomy = $wp_query->query_vars['taxonomy'];
				echo $before . $wp_query->query_vars[$taxonomy] . $after;

			}elseif ( is_page() && !$post->post_parent ) {
				if ($showCurrent == 1) echo $before . get_the_title() . $after;
	
			} elseif ( is_page() && $post->post_parent ) {
				$parent_id  = $post->post_parent;
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
					$parent_id  = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				for ($i = 0; $i < count($breadcrumbs); $i++) {
					echo $breadcrumbs[$i];
					if ($i != count($breadcrumbs)-1) echo $delimiter;
				}
				if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
	
			} elseif ( is_tag() ) {
				echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
	
			} elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata($author);
				echo $before . sprintf($text['author'], $userdata->display_name) . $after;
	
			} elseif ( is_404() ) {
				echo $before . $text['404'] . $after;
			}
			
			//echo "<pre>"; print_r($wp_query->query_vars); echo "</pre>";
			if ( get_query_var('paged') ) {
				// if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
				// echo __('Page') . ' ' . get_query_var('paged');
				// if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
			}
			echo '</ul></div>';
	
		}
	}
}
// Front End Functions END