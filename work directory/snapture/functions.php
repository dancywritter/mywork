<?php
add_action( 'after_setup_theme', 'cs_theme_setup' );
function cs_theme_setup() {

	/* Add theme-supported features. */
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();
	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
 	load_theme_textdomain('Snapture', get_template_directory() . '/languages');
	
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
		add_action('init', 'cs_activation_data');
	}
	if (!session_id()){ 
		add_action('init', 'session_start');
	}
 	add_action( 'init', 'cs_register_my_menus' );
	add_action('admin_enqueue_scripts', 'cs_admin_enqueue_scripts');
	add_action('wp_enqueue_scripts', 'cs_front_enqueue_scripts');
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

	// adding custom images while uploading media start
	add_image_size('cs_media_1', 890, 468, true);
	add_image_size('cs_media_2', 529, 400, true);
	add_image_size('cs_media_3', 297, 224, true);
	add_image_size('cs_media_4', 230, 173, true);
	add_image_size('cs_media_5', 250, 380, true);
	add_image_size('cs_media_6', 500, 186, true);

If (!function_exists('cs_comment')) :
     /**
     * Template for comments and pingbacks.
     *
     * To override this walker in a child theme without modifying the comments template
     * simply create your own cs_comment(), and that function will be used instead.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     *
     */
	function cs_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	$args['reply_text'] = __('Reply', 'Snapture');
 	switch ( $comment->comment_type ) :
		case '' :
	?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <div class="thumblist" id="comment-<?php comment_ID(); ?>">
            <ul>
                <li>
                	<figure>
                        <a><?php echo get_avatar( $comment, 48 ); ?></a>
                    </figure>
                    
                    <div class="text">
                    	<header>
						<?php printf( __( '%s', 'Snapture' ), sprintf( '<h6><a class="colrhvr">%s</a></h6>', get_comment_author_link() ) ); ?>
                        
                        <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                        
                        <?php edit_comment_link( __( '(Edit)', 'Snapture' ), ' ' );?>
                        <?php if ( $comment->comment_approved == '0' ) : ?>
                            <div class="comment-awaiting-moderation colr"><?php _e( 'Your comment is awaiting moderation.', 'Snapture' ); ?></div>
                        <?php endif; ?>
                        </header>
                        
                        <?php comment_text(); ?>
                        <?php
                            /* translators: 1: date, 2: time */
							$d = "m F, Y, h:i A";
                            printf( __( '<time>%1$s</time>', 'Snapture' ), get_comment_date($d)); 
						?>
                       
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
		<p><?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'Snapture' ), ' ' ); ?></p>
	<?php
		break;
		endswitch;
	}
 	endif;

// Top and Main Navigation
if ( ! function_exists( 'cs_navigation' ) ) {
	function cs_navigation($nav='', $menus = 'menus'){
		global $cs_theme_option;
		// Menu parameters	
		$defaults = array(
			'theme_location' => "$nav",
			'menu' => '',
			'container' => '',
			'container_class' => '',
			'container_id' => '',
			'menu_class' => '',
			'menu_id' => "$menus",
			'echo' => false,
			'fallback_cb' => 'wp_page_menu',
			'before' => '',
			'after' => '',
			'link_before' => '',
			'link_after' => '',
			'items_wrap' => '<ul id="%1$s">%3$s</ul>',
			'depth' => 0,
			'walker' => '',);
		echo do_shortcode(wp_nav_menu($defaults));
	}
}
// search varibales start
function cs_get_search_results($query) {
	if ( !is_admin() and (is_search())) {
		$query->set( 'post_type', array('post', 'portfolio','product' ) );
		remove_action( 'pre_get_posts', 'cs_get_search_results' );
	}
}
// change query variable on search and home front page
function cs_change_query_vars($query) {
    if (is_search()|| is_home()) {
        if (empty($_GET['page_id_all']))
            $_GET['page_id_all'] = 1;
       $query->query_vars['paged'] = $_GET['page_id_all'];
	   return $query;
	}
	 // Return modified query variables
}
// add http to URL
function cs_add_http($url){
	 if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}


// Add social network icons
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


function cs_stripslashes_htmlspecialchars($value)
{
    $value = is_array($value) ? array_map('cs_stripslashes_htmlspecialchars', $value) : stripslashes(htmlspecialchars($value));
    return $value;
}
// stripslashes / htmlspecialchars for theme option save end


/* Theme Options Functions */
// saving all the theme options start
function cs_theme_option_save() {
	if ( isset($_POST['logo']) ) {
		$_POST = cs_stripslashes_htmlspecialchars($_POST);
		if ( $_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['twitter_setting'])){
			update_option( "cs_theme_option", $_POST );
			echo "All Settings Saved";
		}else{
			update_option( "cs_theme_option", $_POST );
			echo "All Settings Saved";
		}
				// upating config file end
	}
	else {
		//echo $_FILES["mofile"]["tmp_name"][0];
		//echo $_FILES["mofile"]["name"][0];
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

/* Theme Options Functions */
// page bulider items end



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

// installing tables on theme activating start
	global $pagenow, $header1_default_settings, $header2_default_settings;
            $header1_default_settings = array(
            //Header 1 array
				'header_1_sticky' => '',
			   	'header_1_sub_header' => 'on',
			   	'header_1_social_icon' => 'on',
 			   	'header_1_small_logo' => 'on',
			   	'header_1_cart' => 'on'
			
            );
			
			$header2_default_settings = array(
            //Header 2 array
				'header_2_small_logo' => 'on',
			   	'header_2_strip_menu' => '',
			   	'header_2_cart' => 'on',
			
            );

	// Install data on theme activation
 	function cs_activation_data() {
		global $wpdb, $header1_default_settings, $header2_default_settings;
    		
		$args = array(
			'style_sheet' => 'custom',
			'custom_color_scheme' => '#F94D51',
			'custom_color_style' => '#F94D51',
			'nav_bg_color_scheme' => '#282828',
			// Header Color Settings
 			'header_bg_color' => '#F94D51',

			'sub_header_strip' => 'Yes',
			'default_header' => 'header1',
			'header_languages' => 'on',
			
			
			'logo' => get_template_directory_uri() . '/images/logo.png',
			'logo_width' => '113',
			'logo_height' => '73',
			'small_logo' => get_template_directory_uri().'/images/img-logosm.png',
			'small_logo_width' => '30',
			'small_logo_height' => '30',
			'fav_icon' => get_template_directory_uri() . '/images/favicon.ico',
			'header_code' => '',
			'header_link_title' => '',
			'header_link_url' => '',
			'analytics' => '',
			'copyright' =>  'Copyrights &copy;'.gmdate("Y")." ".get_option("blogname")." Wordpress All rights reserved.", 
			//Headers
			'header_styles' => 'header1',
			'default_header' => 'header1',
			
 			// switchers
			'color_switcher' => '',
			'style_rtl' => '',
			'responsive' => 'on',
			'trans_switcher' => 'on',
			'show_slider' => '',
			'slider_name' => 'home-slider',
			'slider_type' => 'Flex Slider',
			'show_album' => '',
			'album_title' => 'Release Notes',
			'album_description' => 'Tempor odio vitae metus vestibulum viverra. Cras non placerat sem. Donec purus felis, pharetra quis fermentum et, placerat non leo. Mauris vel bibendum sapien. Sed at cursus qupharetra quis fermentum et, placerat non leo. am. Sed cursus ut nibh id blandit..',
			'cs_album_category' => 'music',
			'all_cat' => array(),
 			'h1_g_font' => '',
			'h2_g_font' => '',
			'h3_g_font' => '',
			'h4_g_font' => '',
			'h5_g_font' => '',
			'h6_g_font' => '',
			'page_title_g_font' => '',
			'widget_heading_size_g_font' => '',
			'content_size_g_font' => '',
			'sidebar' => array( 'Sidebar', 'Shop'),
			// slider setting
			'flex_effect' => 'fade',
			'flex_auto_play' => 'on',
			'flex_animation_speed' => '7000',
			'flex_pause_time' => '600',
			'slider_id' => '',
			'slider_view' => '',
			'social_net_title' => 'Follow US',
			'social_net_icon_path' => array('', '', '', '', '', '', '', '', '', ''),
			'social_net_awesome' => array( 'fa-facebook', 'fa-twitter', 'fa-google-plus' ),
			'social_net_url' => array( 'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK'),
			'social_net_tooltip' => array( 'Facebook', 'Twitter', 'Google Plus' ),
			'facebook_share' => 'on',
			'twitter_share' => 'on',
			'linkedin_share' => '',
			'myspace_share' => '',
			'digg_share' => '',
			'stumbleupon_share' => '',
			'reddit_share' => '',
			'pinterest_share' => '',
			'tumblr_share' => '',
			'google_plus_share' => 'on',
			'blogger_share' => '',
			'amazon_share' => '',
			// tranlations
						
            'trans_subject' => 'Subject',
            'trans_message' => 'Message',
            'trans_form_title' => 'Send us a Quick Message',
			
			'trans_back_to_menu' => 'Back to Menu',
            'trans_share_this_post' => 'Share',
            'trans_content_404' => "It seems we can not find what you are looking for.",
            'trans_full_album' => 'Full Album',
			'trans_featured' => 'Sticky Post',
			'trans_load_more' => 'Load More',
			'trans_sign_in' => 'Sign In',
			'trans_twitter' => 'Twitter',
			'trans_facebook' => 'Facebook',
			'trans_photos' => 'Photos',
			
			// translation end
           	//'pagination' => 'Show Pagination',
			'pagination' => 'Show Pagination',
			'record_per_page' => '5',
			'cs_layout' => 'none',
			'cs_sidebar_left' => '',
			'cs_sidebar_right' => '',
			'uc_logo' => get_template_directory_uri().'/images/logo.png',
			'uc_logo_width' => '167',
			'uc_logo_height' => '26',
			'under-construction' => '',
			'showlogo' => 'on',
			'socialnetwork' => 'on',
			'under_construction_text' => '<h1>OUR WEBSITE IS UNDERCONSTRUCTION</h1><h4>We\'ll be here soon with a new website, Estimated Time Remaining</h4>',
			'launch_date' => '2014-12-01',
			'cs_posts_per_page' => '8',
		);
		/* Merge Heaser styles
		*/
        $args = array_merge($args, $header1_default_settings, $header2_default_settings);
		update_option("cs_theme_option", $args );
		update_option("cs_theme_option_restore", $args );
}

// Admin scripts enqueue
function cs_admin_enqueue_scripts() {
    $template_path = get_template_directory_uri() . '/scripts/admin/media_upload.js';
    wp_enqueue_script('my-upload', $template_path, array('jquery', 'media-upload', 'thickbox', 'jquery-ui-droppable', 'jquery-ui-datepicker', 'jquery-ui-slider', 'wp-color-picker'));
    wp_enqueue_script('custom_wp_admin_script', get_template_directory_uri() . '/scripts/admin/cs_functions.js');
    wp_enqueue_style('custom_wp_admin_style', get_template_directory_uri() . '/css/admin/admin-style.css', array('thickbox'));
	wp_enqueue_style('wp-color-picker');
}
// Backend functionality files
require_once (TEMPLATEPATH . '/include/admin_functions.php');
require_once (TEMPLATEPATH . '/include/slider.php');
require_once (TEMPLATEPATH . '/include/gallery.php');
require_once (TEMPLATEPATH . '/include/theme_option.php');
require_once (TEMPLATEPATH . '/include/page_builder.php');
require_once (TEMPLATEPATH . '/include/post_meta.php');
require_once (TEMPLATEPATH . '/include/short_code.php');
require_once (TEMPLATEPATH . '/include/portfolio.php');
require_once (TEMPLATEPATH . '/functions-theme.php');
require_once (TEMPLATEPATH . '/include/widgets.php');
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
// enqeue style and scripts for front end
function cs_front_enqueue_scripts() {
	global $cs_theme_option;
     if (!is_admin()) {
		wp_enqueue_style('style_css', get_template_directory_uri() . '/style.css');
		wp_enqueue_style('bootstrap_css', get_template_directory_uri() . '/css/bootstrap.css');
		wp_enqueue_style('font-awesome_css', get_template_directory_uri() . '/css/font-awesome.css');
		
   		if ( $cs_theme_option['color_switcher'] == "on" ) {
			wp_enqueue_style('color-switcher_css', get_template_directory_uri() . '/css/color-switcher.css');
		}
		if ( $cs_theme_option['style_rtl'] == "on" ) {
			wp_enqueue_style('style_rtl_css', get_template_directory_uri() . '/css/rtl.css');
		}
		if 	($cs_theme_option['responsive'] == "on") {
				echo '<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">';
				wp_enqueue_style('responsive_css', get_template_directory_uri() . '/css/responsive.css');
			}
  		wp_enqueue_style('font-awesome_css', get_template_directory_uri() . '/css/font-awesome.css');
   		wp_enqueue_style( 'wp-mediaelement' );
 		    wp_enqueue_script('jquery');
			wp_enqueue_script( 'wp-mediaelement' );
			wp_enqueue_script('bootstrap_js', get_template_directory_uri() . '/scripts/frontend/bootstrap.min.js', '', '', true);
			wp_enqueue_script('modernizr_js', get_template_directory_uri() . '/scripts/frontend/modernizr.js', '', '', true);
			wp_enqueue_script('jquery.isotope_js', get_template_directory_uri() . '/scripts/frontend/jquery.isotope.min.js', '', '', true);
			wp_enqueue_script('mlpushmenu_js', get_template_directory_uri() . '/scripts/frontend/mlpushmenu.js', '', '', true);
			wp_enqueue_script('functions_js', get_template_directory_uri() . '/scripts/frontend/functions.js', '0', '', true);
					
    }
}
// Gallery Script Enqueue
function cs_enqueue_gallery_style_script(){
	wp_enqueue_style('prettyphoto_css', get_template_directory_uri() . '/css/prettyphoto.css');
	wp_enqueue_script('prettyphoto_js', get_template_directory_uri() . '/scripts/frontend/jquery.prettyphoto.js', '', '', true);
}
// Masonry Style and Script enqueue
function cs_enqueue_masonry_style_script(){
	wp_enqueue_script('jquery.isotope_js', get_template_directory_uri() . '/scripts/frontend/jquery.isotope.min.js', '', '', true);
	wp_enqueue_script('perfectmasonry_js', get_template_directory_uri() . '/scripts/frontend/jquery.isotope.perfectmasonry.js', '1', '', true);
	wp_enqueue_style('masonry_css', get_template_directory_uri() . '/css/masonry.css');
	wp_enqueue_style('smoothslides_css', get_template_directory_uri() . '/css/smoothslides.css');

}

function cs_enqueue_masonry_blog_style_script(){
	wp_enqueue_script('jquery.isotope_js', get_template_directory_uri() . '/scripts/frontend/jquery.isotope.min.js', '', '', true);
	wp_enqueue_style('masonry_css', get_template_directory_uri() . '/css/masonry.css');
	wp_enqueue_style('smoothslides_css', get_template_directory_uri() . '/css/smoothslides.css');

}
// Validation Script Enqueue
function cs_enqueue_validation_script(){
	wp_enqueue_script('jquery.validate.metadata_js', get_template_directory_uri() . '/scripts/admin/jquery.validate.metadata.js', '', '', true);
	wp_enqueue_script('jquery.validate_js', get_template_directory_uri() . '/scripts/admin/jquery.validate.js', '', '', true);
}
// flexslider script enqueue
function cs_enqueue_flexslider(){
	wp_enqueue_script('jquery.flexslider-min_js', get_template_directory_uri() . '/scripts/frontend/jquery.flexslider-min.js', '1', '', true);
	wp_enqueue_style('flexslider_css', get_template_directory_uri() . '/css/flexslider.css');
}
// Swiper script enqueue
function cs_enqueue_swiper(){
	wp_enqueue_script('idangerous.swiper-2.1_js', get_template_directory_uri() . '/scripts/frontend/idangerous.swiper-2.1.min.js', '1', '', true);
	wp_enqueue_style('idangerous_swiper_css', get_template_directory_uri() . '/css/idangerous.swiper.css');
}
// smoothslides script enqueue
function cs_enqueue_slideshowify(){
	wp_enqueue_script('slideshowify1_js', get_template_directory_uri() . '/scripts/frontend/jquery.slideshowify.min.js', '1', '', true);
	wp_enqueue_style('smoothslides_css', get_template_directory_uri() . '/css/smoothslides.css');
}
// masonary script enqueue
function cs_addthis_script_init_method(){
	if( is_single()){
		wp_enqueue_script( 'cs_addthis', 'http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e4412d954dccc64', '','',true);
	}
}
// Home page slider Enqueue
function cs_enqueue_bnggallery_script(){
	wp_enqueue_script('bgndGallery_js', get_template_directory_uri() . '/scripts/frontend/mb.bgndGallery.js', '', '', true);
	wp_enqueue_script('bgndGallery_effects_js', get_template_directory_uri() . '/scripts/frontend/mb.bgndGallery.effects.js', '', '', true);
}
// Home page text rotator Enqueue
function cs_enqueue_text_rotator_script(){
	wp_enqueue_script('text-rotator_js', get_template_directory_uri() . '/scripts/frontend/jquery.simple-text-rotator.min.js', '', '', true);
}
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
       for($i=1; $i<=2; $i++){?>
    <option value="<?php echo 'header'.$i;?>" <?php if( $cs_theme_option['header_styles']=='header'.$i){ echo 'selected="selected"';}?>><?php echo 'Header '.$i;?></option>
	<?php }
} 
  
 function cs_footer_settings() {
    global $cs_theme_option;
     echo htmlspecialchars_decode($cs_theme_option['analytics']);
}
// next prev post link
 
 function cs_next_prev_custom_links(){
	 	global $post;
		$previd = $nextid = '';
		$count_posts = wp_count_posts( 'portfolio' )->publish;
		$cs_postlist_args = array(
		   'posts_per_page'  => -1,
		   'order'           => 'ASC',
		   'post_type'       => 'portfolio',
		); 
		$cs_postlist = get_posts( $cs_postlist_args );

		$ids = array();
		foreach ($cs_postlist as $cs_thepost) {
		   $ids[] = $cs_thepost->ID;
		}
		$thisindex = array_search($post->ID, $ids);
		if(isset($ids[$thisindex-1])){
			$previd = $ids[$thisindex-1];
		} 
		if(isset($ids[$thisindex+1])){
			$nextid = $ids[$thisindex+1];
		} 
		
		if (isset($previd) &&  !empty($previd) && $previd >=0 ) {
		   echo '<a rel="prev" href="' . get_permalink($previd). '"><i class="fa fa-angle-left fa-4x"></i></a>';
		}
		?>
        <p><?php echo $thisindex+1;?><span>/<?php echo $count_posts;?></span></p>
        <?php
		if (isset($nextid) &&   !empty($nextid) ) {
		   		echo '<a rel="next" href="' . get_permalink($nextid). '"><i class="fa fa-angle-right fa-4x"></i></a>';
		}
	 
 }

function cs_parse_vimeo($link){
 
        $regexstr = '~
            # Match Vimeo link and embed code
            (?:<iframe [^>]*src=")?       # If iframe match up to first quote of src
            (?:                         # Group vimeo url
                https?:\/\/             # Either http or https
                (?:[\w]+\.)*            # Optional subdomains
                vimeo\.com              # Match vimeo.com
                (?:[\/\w]*\/videos?)?   # Optional video sub directory this handles groups links also
                \/                      # Slash before Id
                ([0-9]+)                # $1: VIDEO_ID is numeric
                [^\s]*                  # Not a space
            )                           # End group
            "?                          # Match end quote if part of src
            (?:[^>]*></iframe>)?        # Match the end of the iframe
            (?:<p>.*</p>)?              # Match any title information stuff
            ~ix';
 
        preg_match($regexstr, $link, $matches);
 
        return $matches[1];
 
  }
  function cs_parse_yturl($url) 
{
    $pattern = '#^(?:https?://)?';    # Optional URL scheme. Either http or https.
    $pattern .= '(?:www\.)?';         #  Optional www subdomain.
    $pattern .= '(?:';                #  Group host alternatives:
    $pattern .=   'youtu\.be/';       #    Either youtu.be,
    $pattern .=   '|youtube\.com';    #    or youtube.com
    $pattern .=   '(?:';              #    Group path alternatives:
    $pattern .=     '/embed/';        #      Either /embed/,
    $pattern .=     '|/v/';           #      or /v/,
    $pattern .=     '|/watch\?v=';    #      or /watch?v=,    
    $pattern .=     '|/watch\?.+&v='; #      or /watch?other_param&v=
    $pattern .=   ')';                #    End path alternatives.
    $pattern .= ')';                  #  End host alternatives.
    $pattern .= '([\w-]{11})';        # 11 characters (Length of Youtube video ids).
    $pattern .= '(?:.+)?$#x';         # Optional other ending URL parameters.
    preg_match($pattern, $url, $matches);
    return (isset($matches[1])) ? $matches[1] : false;
}

  function cs_videoType($url) {
    if (strpos($url, 'youtube') > 0) {
        return 'youtube';
    } elseif (strpos($url, 'vimeo') > 0) {
        return 'vimeo';
    } else {
        return 'unknown';
    }
}
// register menu name on theme activation
function cs_register_my_menus() {
  register_nav_menus(
	array(
		'main-menu'  => __('Main Menu','Snapture'),
		'icon-menu'  => __('Icon Menu','Snapture'),
  	)
  );
}

// add id on default menu
function cs_add_menuid($ulid) {
	return preg_replace('/<ul>/', '<ul id="menus">', $ulid, 1);
}

function cs_remove_div ( $menu ){
    return preg_replace( array( '#^<div[^>]*>#', '#</div>$#' ), '', $menu );
}

function cs_add_parent_css($classes, $item) {
    global $menu_children;
    if ($menu_children)
        $classes[] = 'parent';
    return $classes;
}

// password protect post/page
if ( ! function_exists( 'cs_password_form' ) ) {
	function cs_password_form() {
		global $post,$cs_theme_option;
		$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
		$o = '<div class="col-md-12"><div class="pagenone">
				<h1>' . __( "Password Protected","Snapture" ) . '</h1>
				<h5>' . __( "This post is password protected. To view it please enter your password below:",'Snapture' ) . '</h5>';
		$o .= '<div class="password_protected"><form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
				<label>
				   <input name="post_password" id="' . $label . '" type="password" value="'.__('Password', 'Snapture').'" />
				</label>
				<label class="search-icon">
					<input type="submit" name="Submit" class="backcolr"  value="'.__('Submit', 'Snapture').'" />
				</label>
			</form>
			</div></div></div>';
		return $o;
	}
}  
//////////////// Header Cart ///////////////////
 function woocommerce_header_add_to_cart_fragment( $fragments ) {
	if ( class_exists( 'woocommerce' ) ){
		$cart_deactive_clas = "";
		if(isset($_POST['header_1_cart1']) and $_SESSION['header_1_cart'] <> "on"){
		$cart_deactive_clas = " cs-deactive-switch";
		}
		global $woocommerce;
		ob_start();
		?>
		<div class="cart-sec<?php echo $cart_deactive_clas; ?>">
			<a href="<?php echo $woocommerce->cart->get_cart_url(); ?>">
            	<i class="fa fa-shopping-cart"></i><span class="qnt"><?php echo $woocommerce->cart->cart_contents_count; ?></span>
            </a>
		</div>
		<?php
		$fragments['div.cart-sec'] = ob_get_clean();
		return $fragments;
	}
}

function cs_woocommerce_header_cart() {
	if ( class_exists( 'woocommerce' ) ){
		$cart_deactive_clas = "";
		if(isset($_POST['header_1_cart1']) and $_SESSION['header_1_cart'] <> "on"){
		$cart_deactive_clas = " cs-deactive-switch";
		}
		global $woocommerce;
		?>
		<div class="cart-sec<?php echo $cart_deactive_clas; ?>">
			<a href="<?php echo $woocommerce->cart->get_cart_url(); ?>">
            	<i class="fa fa-shopping-cart"></i><span class="qnt"><?php echo $woocommerce->cart->cart_contents_count; ?></span>
            </a>
		</div>
		<?php
	}
}
//////////////// Header Cart Ends ///////////////////
// Front End Functions END