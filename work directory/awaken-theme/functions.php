<?php
remove_filter( 'the_title_rss', 'strip_tags');

add_action( 'after_setup_theme', 'cs_theme_setup' );
function cs_theme_setup() {
	global $wpdb;
	/* Add theme-supported features. */
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();
	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
 	load_theme_textdomain('Awaken', get_template_directory() . '/languages');
	
	if (!isset($content_width)){
		$content_width = 1170;
	}
	
	$args = array(
		'default-color' => '',
		'flex-width' => true,
		'flex-height' => true,
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
	if (!session_id()){ 
		add_action('init', 'session_start');
	}
	if(!get_option('cs_theme_options')){
		cs_get_google_init_arrays();
	}
	if (is_admin() && isset($_GET['activated']) && $pagenow == 'themes.php'){
		
		if(!get_option('cs_theme_options')){
			
			add_action('init', 'cs_activation_data');
		}
		add_action('admin_head', 'cs_activate_widget');
		if(!get_option('cs_theme_options')){
			wp_redirect( admin_url( 'themes.php?page=cs_demo_importer' ) );
		}
		//wp_redirect( admin_url( 'themes.php?page=cs_demo_importer' ) );
	}
 	add_action('admin_enqueue_scripts', 'cs_admin_scripts_enqueue');
	//wp_enqueue_scripts
	add_action('wp_enqueue_scripts', 'cs_front_scripts_enqueue');
	add_action('pre_get_posts', 'cs_get_search_results');

	/* Add custom filters. */
	add_filter('widget_text', 'do_shortcode');
 	
	if( class_exists( 'wp_causes' ) ){ 
		add_filter('edit_user_profile','cs_contact_options',10,1);
		add_filter('show_user_profile','cs_contact_options',10,1);
	}
	add_action('edit_user_profile_update', 'cs_contact_options_save' );
	add_action('personal_options_update', 'cs_contact_options_save' );
	add_filter('user_contactmethods','cs_profile_fields',10,1);
	add_action('wp_login', 'cs_user_login', 10, 2 );
	add_filter('login_message','cs_user_login_message');
	add_filter('the_password_form', 'cs_password_form');
	add_filter('wp_page_menu','cs_add_menuid');
	add_filter('wp_page_menu', 'cs_remove_div');
	add_filter('nav_menu_css_class', 'cs_add_parent_css', 10, 2);
	add_filter('pre_get_posts', 'cs_change_query_vars');
	add_action('init','add_oembed_soundcloud');
	add_filter( 'show_admin_bar', '__return_false' );
	
}
// tgm class for (internal and WordPress repository) plugin activation start
require_once dirname( __FILE__ ) . '/include/theme-components/cs-activation-plugins/tgm_plugin_activation.php';
add_action( 'tgmpa_register', 'cs_register_required_plugins' );


function cs_register_required_plugins() {
	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		// This is an example of how to include a plugin from the WordPress Plugin Repository
		array(
			'name'     				=> 'Revolution Slider',
			'slug'     				=> 'revslider',
			'source'   				=> get_stylesheet_directory() . '/include/theme-components/cs-activation-plugins/revslider.zip', 
			'required' 				=> false, 
			'version' 				=> '',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> '',
		),
		
		array(
			'name' 		=> 'Contact Form 7',
			'slug' 		=> 'contact-form-7',
			'required' 	=> false,
		)
		,
		array(
			'name' 		=> 'CodeStyling Localization',
			'slug' 		=> 'codestyling-localization',
			'required' 	=> false,
		),

		array(
			'name'			=> 'Envato Wordpress Toolkit',
			'slug'			=> 'envato-wordpress-toolkit',
			'source'		=> 'https://github.com/envato/envato-wordpress-toolkit/archive/master.zip',
			'external_url'	=> '',
			'required'		=> false,
		)
	);
	
	
	$plugins = array(
		// This is an example of how to include a plugin from the WordPress Plugin Repository
		array(
			'name'     				=> 'Revolution Slider',
			'slug'     				=> 'revslider',
			'source'   				=> get_stylesheet_directory() . '/include/theme-components/cs-activation-plugins/revslider.zip', 
			'required' 				=> false, 
			'version' 				=> '',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> '',
		),
		array(
			'name'     				=> 'Causes',
			'slug'     				=> 'wp-causes',
			'source'   				=> get_stylesheet_directory() . '/include/theme-components/cs-activation-plugins/wp-causes.zip', 
			'required' 				=> false, 
			'version' 				=> '',
			'force_activation' 		=> false,
			'force_deactivation' 	=> false,
			'external_url' 			=> '',
		),
		array(
			'name'			=> ' Better WordPress Minify',
			'slug'			=> 'bwp-minify',
			//'source'		=> 'https://downloads.wordpress.org/plugin/bwp-minify.zip',
			'required'		=> false,
		),
		array(
			'name' 		=> 'Contact Form 7',
			'slug' 		=> 'contact-form-7',
			'required' 	=> false,
		),
		array(
			'name' 		=> 'CodeStyling Localization',
			'slug' 		=> 'codestyling-localization',
			'required' 	=> false,
		),
		array(
			'name' 		=> 'Woocommerce',
			'slug' 		=> 'woocommerce',
			'required' 	=> false,
		),
		array(
			'name'			=> 'Envato Wordpress Toolkit',
			'slug'			=> 'envato-wordpress-toolkit',
			'source'		=> 'https://github.com/envato/envato-wordpress-toolkit/archive/master.zip',
			'required'		=> false,
		),
		array(
			'name'			=> 'Quick Cache',
			'slug'			=> 'quick-cache',
			//'source'		=> 'https://downloads.wordpress.org/plugin/quick-cache.zip',
			'required'		=> false,
		),
		array(
			'name'			=> 'Force Regenerate Thumbnails',
			'slug'			=> 'force-regenerate-thumbnails',
			//'source'		=> 'https://downloads.wordpress.org/plugin/force-regenerate-thumbnails.zip',
			'required'		=> false,
		),
		array(
			'name'			=> 'Post Duplicator',
			'slug'			=> 'post-duplicator',
			//'source'		=> 'https://downloads.wordpress.org/plugin/post-duplicator.zip',
			'required'		=> false,
		)
	);
	// Change this to your theme text domain, used for internationalising strings
	$theme_text_domain = 'Awaken';
	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       		=> 'Awaken',         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', 'Awaken' ),
			'menu_title'                       			=> __( 'Install Plugins', 'Awaken' ),
			'installing'                       			=> __( 'Installing Plugin: %s', 'Awaken' ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', 'Awaken' ),
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
			'return'                           			=> __( 'Return to Required Plugins Installer', 'Awaken' ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'Awaken' ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'Awaken' ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);
	tgmpa( $plugins, $config );
}
// tgm class for (internal and WordPress repository) plugin activation end

//Blog Large,Causes,Causes Detail,Blog Detail ( Resize From 840 x 473 Cropping issue)
add_image_size('cs_media_1', 844, 475, true);

//Project Detail    ======4 x 3======(842 x 632) ( Resize From 840 x 630 Cropping issue)
add_image_size('cs_media_2', 842, 632, true);

//Blog Simple,blog Elite,blog Classic ( Resize From 840 x 473 Cropping issue)
add_image_size('cs_media_3', 840, 333, true);

//blog Medium, blog Medium,blog Small, Blog TimeLine, Blog Simple, Sermons Detail, Sermon listing, cause Medium, Cause Grid, Projects Grid   4 x 3(370 x 278)
add_image_size('cs_media_4', 372, 279, true);

//Blog Grid, Sermon grid, Events, Projects, Fancy   ======16 x 9======(370 x 208)
add_image_size('cs_media_5', 370, 208, true);

//Event Detail, Widgets,blog Clean, Event Timline   100 x 100 use  ======default 300 x 300====== (270 x 270)
add_image_size('cs_media_6', 300, 300, true);

// Function Title
function cs_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'Awaken' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'cs_wp_title', 10, 2 );

//Single files paths
function get_custom_post_type_template($single_template) {
     global $post;
	 $single_path = dirname( __FILE__ );
     if ($post->post_type == 'events') {
          $single_template = $single_path.'/cs-templates/event-styles/single-events.php';
     }
	 
	 if ($post->post_type == 'project') {
          $single_template = $single_path.'/cs-templates/project-styles/single-project.php';
     }
	 
	 if ($post->post_type == 'sermons') {
          $single_template = $single_path.'/cs-templates/sermon-styles/single-sermons.php';
     }
     return $single_template;
}
add_filter( 'single_template', 'get_custom_post_type_template' );

/// Next post link class
function cs_posts_link_next_class($format){
  $format = str_replace('href=', 'class="pix-nextpost" href=', $format);
  return $format;
}
add_filter('next_post_link', 'cs_posts_link_next_class');
/// prev post link class
function cs_posts_link_prev_class($format) {
 $format = str_replace('href=', 'class="pix-prevpost" href=', $format);
  return $format;
}
add_filter('previous_post_link', 'cs_posts_link_prev_class');

// author description custom function
if ( ! function_exists( 'cs_author_description' ) ) {
	function cs_author_description( $type = '' ) {
		global $cs_theme_options;
		?>
<div class="cs-about-author">
  <div class="icon-auther"> <i class="fa fa-user"></i> </div>
  <div class="inner">
    <figure>
    <?php
		$current_user = wp_get_current_user();
		$custom_image_url = get_user_meta(get_the_author_meta('ID'), 'user_avatar_display', true);
		$size = 70;
		if(isset($custom_image_url) && $custom_image_url <> '') {
			echo '<img src="'.$custom_image_url.'" class="avatar photo" id="upload_media" width="'.$size.'" height="'.$size.'" alt="'.$current_user->display_name .'" />';
		} else {
		?>
			<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"> <?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('PixFill_author_bio_avatar_size', 70)); ?> </a>
		<?php 
		}
	?>
    </figure>
    <div class="text">
      <header>
        <h6><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author(); ?></a></h6>
      </header>
      <p> 
	  <?php 	
		$author_meta = get_the_author_meta('description');
		if(strlen($author_meta)>200){
			echo substr($author_meta, 0, 200).'...';
		} else {
			echo cs_allow_special_char($author_meta);
		}
		?>
      </p>
      <?php
		if ( $type == 'show' ){?>
      		<a class="btn-post-view cs-bg-color" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php _e('View All Posts','Awaken');?></a> </div>
     <?php }?>
  </div>
</div>

<?php
	}
}

// tgm class for (internal and WordPress repository) plugin activation end
// stripslashes / htmlspecialchars for theme option save start
function stripslashes_htmlspecialchars($value){
    $value = is_array($value) ? array_map('stripslashes_htmlspecialchars', $value) : stripslashes(htmlspecialchars($value));
    return $value;
}
// stripslashes / htmlspecialchars for theme option save end
//Home Page Services
function cs_services(){
	global $cs_theme_option;
	if(isset($cs_theme_option['varto_services_shortcode']) and $cs_theme_option['varto_services_shortcode'] <> ""){ ?>
<div class="parallax-fullwidth services-container">
  <div class="container">
    <?php if($cs_theme_option['varto_sevices_title'] <> ""){ ?>
    <header class="cs-heading-title">
      <h2 class="cs-section-title"><?php echo cs_allow_special_char($cs_theme_option['varto_sevices_title']); ?></h2>
    </header>
    <?php }
			echo do_shortcode($cs_theme_option['varto_services_shortcode']);
	?>
  </div>
</div>
<div class="clear"></div>
<?php
    }
	 
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

// installing tables on theme activating start
	global $pagenow;

// Admin scripts enqueue

function cs_admin_scripts_enqueue() {
	if (is_admin()) {
    $template_path = get_template_directory_uri().'/include/assets/scripts/media_upload.js';
		wp_enqueue_media();
		wp_enqueue_script('my-upload', $template_path, array('jquery', 'media-upload', 'thickbox', 'jquery-ui-droppable', 'jquery-ui-datepicker', 'jquery-ui-slider', 'wp-color-picker'));
		wp_enqueue_script('datetimepicker1_js', get_template_directory_uri() . '/include/assets/scripts/jquery_datetimepicker.js', '', '', true);
		wp_enqueue_script('admin_theme-option-fucntion_js', get_template_directory_uri() . '/include/assets/scripts/theme_option_fucntion.js', '', '', true);
		
		wp_enqueue_style('fontawesome_iconpicker_min', get_template_directory_uri() . '/include/assets/css/fontawesome.css');

		wp_enqueue_style('fontawesome_iconpicker', get_template_directory_uri() . '/include/assets/css/fontawesome_iconpicker.css');
		wp_enqueue_script('iconpicker_min_awesome', get_template_directory_uri() . '/include/assets/scripts/fontawesome_iconpicker_min.js');
		
		wp_enqueue_style('custom_wp_admin_style', get_template_directory_uri() . '/include/assets/css/admin_style.css');
		wp_enqueue_script('custom_wp_admin_script', get_template_directory_uri() . '/include/assets/scripts/cs_functions.js');
		
		wp_enqueue_script('custom_page_builder_wp_admin_script', get_template_directory_uri() . '/include/assets/scripts/cs_page_builder_functions.js');
		wp_enqueue_script('bootstrap.min_script', get_template_directory_uri() . '/include/assets/scripts/bootstrap.min.js');
		wp_enqueue_style('wp-color-picker');
	}
}

// Backend functionality files
require_once (get_template_directory()  . '/functions-theme.php');
require_once (get_template_directory()  . '/include/page_builder.php');
require_once (get_template_directory()  . '/include/post_meta.php');
require_once (get_template_directory()  . '/include/page_options.php');
require_once (get_template_directory()  . '/include/admin_functions.php');
require_once (get_template_directory()  . '/include/theme-components/cs-importer/theme_importer.php');
//require_once (get_template_directory()  . '/include/theme-components/cs-social-login/cs_social_login.php');
//require_once (get_template_directory()  . '/include/theme-components/cs-social-login/google/cs-google-connect.php');
/* include files for post types*/
require_once (get_template_directory().'/include/theme-components/cs-posttypes/pt_events.php');
require_once (get_template_directory().'/include/theme-components/cs-posttypes/pt_portfolios.php');
require_once (get_template_directory().'/include/theme-components/cs-posttypes/pt_sermons.php');
// Result/Reports listing for Instructors


require_once (get_template_directory()  . '/cs-templates/blog-styles/blog_element.php');
require_once (get_template_directory()  . '/cs-templates/blog-styles/blog_functions.php');
require_once (get_template_directory()  . '/cs-templates/blog-styles/blog_templates.php');

require_once (get_template_directory()  . '/cs-templates/event-styles/event_element.php');
require_once (get_template_directory()  . '/cs-templates/event-styles/event_functions.php');
require_once (get_template_directory()  . '/cs-templates/event-styles/event_templates.php');

require_once (get_template_directory()  . '/include/theme-components/cs-mega-menu/custom_walker.php');
require_once (get_template_directory()  . '/include/theme-components/cs-mega-menu/edit_custom_walker.php');
require_once (get_template_directory()  . '/include/theme-components/cs-mega-menu/menu_functions.php');

require_once (get_template_directory()  . '/include/theme-components/cs-widgets/widgets.php');
require_once (TEMPLATEPATH . '/include/theme-components/cs-widgets/widgets_keys.php');
require_once (get_template_directory()  . '/include/theme-components/cs-header/header_functions.php');

require_once (get_template_directory()  . '/include/shortcodes/shortcode_elements.php');
require_once (get_template_directory()  . '/include/shortcodes/shortcode_functions.php');
require_once (get_template_directory()  . '/include/shortcodes/typography_elements.php');
require_once (get_template_directory()  . '/include/shortcodes/typography_function.php');
require_once (get_template_directory()  . '/include/shortcodes/common_elements.php');
require_once (get_template_directory()  . '/include/shortcodes/common_function.php');
require_once (get_template_directory()  . '/include/shortcodes/media_elements.php');
require_once (get_template_directory()  . '/include/shortcodes/media_function.php');
require_once (get_template_directory()  . '/include/shortcodes/contentblock_elements.php');
require_once (get_template_directory()  . '/include/shortcodes/contentblock_function.php');
require_once (get_template_directory()  . '/include/shortcodes/loops_elements.php');
require_once (get_template_directory()  . '/include/shortcodes/loops_function.php');
require_once (get_template_directory()  . '/cs-templates/project-styles/project_elements.php');
require_once (get_template_directory()  . '/cs-templates/project-styles/project_function.php');
require_once (get_template_directory()  . '/cs-templates/project-styles/project_templates.php');

require_once (get_template_directory()  . '/cs-templates/sermon-styles/sermon_element.php');
require_once (get_template_directory()  . '/cs-templates/sermon-styles/sermon_functions.php');
require_once (get_template_directory()  . '/cs-templates/sermon-styles/sermon_templates.php');
 

require_once (get_template_directory()  . '/include/theme-components/cs-mailchimp/mailchimp.class.php');
require_once (get_template_directory()  . '/include/theme-components/cs-mailchimp/mailchimp_functions.php');
require_once (get_template_directory()  . '/include/theme-components/cs-googlefont/fonts.php');
require_once (get_template_directory()  . '/include/theme-components/cs-googlefont/google_fonts.php');
require_once (get_template_directory()  . '/include/theme_colors.php');
require_once (get_template_directory()  . '/include/shortcodes/class_parse.php');
require_once (get_template_directory()  . '/include/theme-options/theme_options.php');
require_once (get_template_directory()  . '/include/theme-options/theme_options_fields.php');
require_once (get_template_directory()  . '/include/theme-options/theme_options_functions.php');
require_once (get_template_directory()  . '/include/theme-options/theme_options_arrays.php');


/////////////////////////////////

if (current_user_can('administrator')) {
	// Addmin Menu CS Theme Option
	
	if (current_user_can('administrator')) {
		 // Addmin Menu CS Theme Option
		 add_action('admin_menu', 'cs_theme');
		 function cs_theme() {
		  add_theme_page('CS Theme Option', 'CS Theme Option', 'read', 'cs_options_page', 'cs_options_page');
		  add_theme_page( "Import Demo Data" , "Import Demo Data" ,'read', 'cs_demo_importer' , 'cs_demo_importer');
		 }
	}
}
 
 /* save user profile fields*/
function cs_user_login( $user_login, $user ) {
		// Get user meta
		$disabled = get_user_meta( $user->ID, 'user_switch', true );
		// Is the use logging in disabled?
		if ( $disabled == '1' ) {
			// Clear cookies, a.k.a log user out
			wp_clear_auth_cookie();
 			// Build login URL and then redirect
			$login_url = site_url( 'wp-login.php', 'login' );
			$login_url = add_query_arg( 'disabled', '1', $login_url );
			wp_redirect( $login_url );
			exit;
	}
}

/* show error message*/
function cs_user_login_message( $message ) {
 	// Show the error message if it seems to be a disabled user
	if ( isset( $_GET['disabled'] ) && $_GET['disabled'] == 1 ) 
		$message =  '<div id="cs_login_error">Account Disable</div>';
	return $message;
}

/* Slider Gallery Redirect */
if ( ! function_exists( 'cs_slider_gallery_template_redirect' ) ) {
	function cs_slider_gallery_template_redirect(){
	
		if ( get_post_type() == "cs_gallery" or get_post_type() == "cs_slider" ) {
	
			global $wp_query;
	
			$wp_query->set_404();
	
			status_header( 404 );
	
			get_template_part( 404 ); exit();
	
		}
	
	}
}

// Enqueue frontend style and scripts
if ( ! function_exists( 'cs_front_scripts_enqueue' ) ) {	
	function cs_front_scripts_enqueue() {
		global $cs_theme_options;
		 if (!is_admin()) {
			wp_enqueue_script('jquery');
			wp_enqueue_script( 'wp-mediaelement','','','',true);
			wp_enqueue_script( 'wp-playlist' );
			wp_enqueue_style('bootstrap_css', get_template_directory_uri() . '/assets/css/bootstrap.css');
			if 	(isset($cs_theme_options['cs_responsive']) && $cs_theme_options['cs_responsive'] == "on") {
				echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">';
				wp_enqueue_style('responsive_css', get_template_directory_uri() . '/assets/css/responsive.css');
			}
			wp_enqueue_style('style_css', get_stylesheet_directory_uri() . '/style.css');
			wp_enqueue_style('widget_css', get_template_directory_uri() . '/assets/css/widget.css');
			wp_enqueue_style('font-awesome_css', get_template_directory_uri() . '/assets/css/font-awesome.css');
			wp_enqueue_script('bootstrap.min_script', get_template_directory_uri() . '/assets/scripts/bootstrap.min.js');
			wp_enqueue_style('flexslider_css', get_template_directory_uri() . '/assets/css/flexslider.css');
			wp_enqueue_style('mediaelementplayer.min_css', get_template_directory_uri() . '/assets/css/mediaelementplayer.min.css');
			wp_enqueue_style('prettyPhoto_css', get_template_directory_uri() . '/assets/css/prettyphoto.css');
			if(isset($cs_theme_options['cs_smooth_scroll']) and $cs_theme_options['cs_smooth_scroll'] == 'on'){
				wp_enqueue_script('jquery_nicescroll', get_template_directory_uri() . '/assets/scripts/jquery.nicescroll.min.js', '', '', true);
			}
 			wp_enqueue_script('functions_js', get_template_directory_uri() . '/assets/scripts/functions.js', '', '', true);
			if ( isset($cs_theme_options['cs_style_rtl']) and $cs_theme_options['cs_style_rtl'] == "on"){
				cs_rtl();
			}
		 }
	}
}

// Media element 
if ( ! function_exists( 'cs_media_element' ) ) {
	function cs_media_element(){
		wp_enqueue_style( 'wp-mediaelement','','','',true);
	} 
}

// Portfolio Filters
if ( ! function_exists( 'cs_filterable' ) ) {
	function cs_filterable(){
		wp_enqueue_script('filterable_js', get_template_directory_uri() . '/assets/scripts/filterable.js', '', '', true);
	} 
}

// jplayer script enqueue
function cs_enqueue_jplayer(){
	wp_enqueue_script('jplayer_js', get_template_directory_uri() . '/assets/scripts/jquery.jplayer.min.js', '', '', false);
	wp_enqueue_script('jplayer.playlist.min_js', get_template_directory_uri() . '/assets/scripts/jplayer.playlist.min.js', '0', '', false);
}

//RTL stylesheet enqueue
if ( ! function_exists('cs_rtl') ) {
	function cs_rtl(){
		wp_enqueue_style('rtl_css', get_template_directory_uri() . '/assets/css/rtl.css');	
	}
 }
 if ( ! function_exists('cs_mediaelementplayer_css') ) {
	function cs_mediaelementplayer_css(){
		//wp_enqueue_style('mediaelementplayer.min_css', get_template_directory_uri() . '/assets/css/mediaelementplayer.min.css');	
	}
 }
 

// scroll to fix
function cs_scrolltofix(){
		wp_enqueue_script('sticky_header_js', get_template_directory_uri() . '/assets/scripts/sticky_header.js', '', '', true);
}

// Event Calendar Script
if ( ! function_exists( 'cs_eventcalendar_enqueue' ) ) {
	function cs_eventcalendar_enqueue(){
		wp_enqueue_script('eventcalendarFancy_js', get_template_directory_uri() . '/assets/scripts/jquery.eventCalendar.js', '', '', true);
		wp_enqueue_style('eventcalendarFancy_css', get_template_directory_uri() . '/assets/css/eventCalendar.css');
	}
}
 // Prettyphoto
if ( ! function_exists( 'cs_prettyphoto_enqueue' ) ) {
	function cs_prettyphoto_enqueue(){
		wp_enqueue_script('prettyPhoto_js', get_template_directory_uri() . '/assets/scripts/jquery.prettyphoto.js', '', '', true);
		
	}
}

if ( ! function_exists( 'cs_social_connect' ) ) :
function cs_social_connect(){
	//wp_enqueue_script('socialconnect_js', get_template_directory_uri() . '/include/theme-components/cs-social-login/media/js/cs-connect.js', '', '', true);
	
}
endif;

if ( ! function_exists( 'cs_enqueue_validation_script' ) ) {			
	function cs_enqueue_validation_script(){
		wp_enqueue_script('jquery.validate.metadata_js', get_template_directory_uri() . '/include/assets/scripts/jquery_validate_metadata.js', '', '', true);
		wp_enqueue_script('jquery.validate_js', get_template_directory_uri() . '/include/assets/scripts/jquery_validate.js', '', '', true);
	}
}
// Location Search Google map
if ( ! function_exists( 'cs_enqueue_location_gmap_script' ) ) {
	function cs_enqueue_location_gmap_script(){
		wp_enqueue_script('jquery.googleapis_js', 'http://maps.googleapis.com/maps/api/js?sensor=false', '', '', true);
		wp_enqueue_script('jquery.gmaps-latlon-picker_js', get_template_directory_uri() . '/include/assets/scripts/jquery_gmaps_latlon_picker.js', '', '', true);
	}
}
// Flexslider Script
if ( ! function_exists( 'cs_enqueue_flexslider_script' ) ) {
	function cs_enqueue_flexslider_script(){
		wp_enqueue_script('jquery.flexslider-min_js', get_template_directory_uri() . '/assets/scripts/jquery.flexslider.js', '', '', true);
		//wp_enqueue_style('flexslider_css', get_template_directory_uri() . '/assets/css/flexslider.css');
	}
}
// Count Numbers
if ( ! function_exists( 'cs_count_numbers_script' ) ) {
	function cs_count_numbers_script(){
		wp_enqueue_script('waypoints_js', get_template_directory_uri() . '/assets/scripts/waypoints_min.js', '', '', true);
	} 
}
// Skillbar
if ( ! function_exists( 'cs_skillbar_script' ) ) {
	function cs_skillbar_script(){
		wp_enqueue_script('waypoints_js', get_template_directory_uri() . '/assets/scripts/waypoints_min.js', '', '', true);
		wp_enqueue_script('circliful_js', get_template_directory_uri() . '/assets/scripts/jquery_circliful.js', '', '', true);
	} 
}

// Add this enqueue Script
if ( ! function_exists( 'cs_addthis_script_init_method' ) ) {
	function cs_addthis_script_init_method(){
		wp_enqueue_script( 'cs_addthis', 'http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e4412d954dccc64', '', '', true);
	}
}

// carousel script for related posts
if ( ! function_exists( 'cs_owl_carousel' ) ) {
	function cs_owl_carousel(){
		wp_enqueue_script('owl.carousel_js', get_template_directory_uri() . '/assets/scripts/owl_carousel_min.js', '', '', true);
		wp_enqueue_style('owl.carousel_css', get_template_directory_uri() . '/assets/css/owl.carousel.css');	
	}
}

// Favicon and header code in head tag//
if ( ! function_exists( 'cs_header_settings' ) ) {
	function cs_header_settings() {
		global $cs_theme_options;
		?>
<link rel="shortcut icon" href="<?php echo trim($cs_theme_options['cs_custom_favicon']) ? $cs_theme_options['cs_custom_favicon'] : '#' ; ?>">
<?php  
	}
}

// Favicon and header code in head tag//
if ( ! function_exists( 'cs_footer_settings' ) ) {
	function cs_footer_settings() {
		global $cs_theme_options;
		?>
<!--[if lt IE 9]><link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/ie8.css" /><![endif]-->
<?php  
		if(isset($cs_theme_options['analytics'])){
			echo htmlspecialchars_decode($cs_theme_options['cs_custom_js']);
		}
	}
}

// search varibales start

function cs_get_search_results($query) {

	if ( !is_admin() and (is_search())) {

		$query->set( 'post_type', array('post', 'cs-events') );

		remove_action( 'pre_get_posts', 'cs_get_search_results' );

	}

}
// password protect post/page

if ( ! function_exists( 'cs_password_form' ) ) {

	function cs_password_form() {

		global $post,$cs_theme_option;

		$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );

		$o = '<div class="password_protected">

				<div class="protected-icon"><a href="#"><i class="fa fa-unlock-alt fa-4x"></i></a></div>

				<h3>' . __( "This post is password protected. To view it please enter your password below:",'Awaken' ) . '</h3>';

		$o .= '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">

					<label><input name="post_password" id="' . $label . '" type="password" size="20" /></label>

					<input class="bgcolr" type="submit" name="Submit" value="'.__("Submit", "Awaken").'" />

				</form>

			</div>';

		return $o;
	}
}
// add menu id
if ( ! function_exists( 'cs_add_menuid' ) ) {
	function cs_add_menuid($ulid) {
	
		return preg_replace('/<ul>/', '<ul id="menus">', $ulid, 1);
	
	}
}
// remove additional div from menu
if ( ! function_exists( 'cs_remove_div' ) ) {
	function cs_remove_div ( $menu ){
	
		return preg_replace( array( '#^<div[^>]*>#', '#</div>$#' ), '', $menu );
	}
}
// add parent class
if ( ! function_exists( 'cs_add_parent_css' ) ) {
	function cs_add_parent_css($classes, $item) {
		global $cs_menu_children;
		if ($cs_menu_children)
			$classes[] = 'parent';
		return $classes;
	}
}
// change the default query variable start
if ( ! function_exists( 'cs_change_query_vars' ) ) {
	function cs_change_query_vars($query) {
	
		if (is_search() || is_home()) {
	
			if (empty($_GET['page_id_all']))
	
				$_GET['page_id_all'] = 1;
	
		   $query->query_vars['paged'] = $_GET['page_id_all'];
	
		   return $query;
	
		}
	}
}
// Filter shortcode in text areas

if ( ! function_exists( 'cs_textarea_filter' ) ) { 

	function cs_textarea_filter($content=''){

		return do_shortcode($content);

	}
}

//	Add Featured/sticky text/icon for sticky posts.

if ( ! function_exists( 'cs_featured' ) ) {

	function cs_featured(){

		if ( is_sticky() ){ ?>
        <span class="featured-post">
          <?php _e('Featured', 'Awaken');?>
        </span>
        <?php

		}
	}
}

// display post page title
if ( ! function_exists( 'cs_post_page_title' ) ) {
	function cs_post_page_title(){
	
		if ( is_author() ) {
	
			global $author;
	
			$userdata = get_userdata($author);
	
			echo __('Author', 'Awaken') . " " . __('Archives', 'Awaken') . ": ".$userdata->display_name;
	
		}elseif ( is_tag() || is_tax('event-tag')) {
	
			echo __('Tags', 'Awaken') . " " . __('Archives', 'Awaken') . ": " . single_cat_title( '', false );
	
		}elseif( is_search()){
	
			printf( __( 'Search Results %1$s %2$s', 'Awaken' ), ': ','<span>' . get_search_query() . '</span>' ); 
	
		}elseif ( is_day() ) {
	
			printf( __( 'Daily Archives: %s', 'Awaken' ), '<span>' . get_the_date() . '</span>' );
	
		}elseif ( is_month() ) {
	
			printf( __( 'Monthly Archives: %s', 'Awaken' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'Awaken' ) ) . '</span>' );
	
		}elseif ( is_year() ) {
	
			printf( __( 'Yearly Archives: %s', 'Awaken' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'Awaken' ) ) . '</span>' );
	
		}elseif ( is_404()){
	
			_e( 'Error 404', 'Awaken' );
	
		}elseif(!is_page()){
	
			_e( 'Archives', 'Awaken' );
	
		}
	}
}
// If no content, include the "No posts found" function
if ( ! function_exists( 'fnc_no_result_found' ) ) {
		function fnc_no_result_found(){
		$is_search	= '';
		global $cs_theme_options;
		?>
        <div class="page-no-search">
          <?php
          if( ! is_search() ) :
          ?>
          <header>
            <h5>
             <?php _e('No results found.','Awaken');?>
            </h5>
          </header>
          <aside class="cs-icon"> <i class="fa fa-frown-o"></i> </aside>
          <?php
		  endif;
		  
		  if ( is_home() && current_user_can( 'publish_posts' ) ) : 
			  printf( __( '<p>Ready to publish your first post? <a href="%1$s">Get Started Here</a>.</p>', 'Awaken' ), admin_url( 'post-new.php' ) ); 
			  
		   elseif ( is_search() ) :
			  ?>
              <h1><?php _e('No pages were found containing "'.get_search_query().'"','Awaken'); ?></h1>
			  <div class="suggestions">
				  <h5><?php _e('Suggestions:', 'Awaken'); ?></h5>
				  <ul>
					  <li><?php _e('Make sure all words are spelled correctly', 'Awaken'); ?></li>
					  <li><?php _e('Wildcard searches (using the asterisk *) are not supported', 'Awaken'); ?></li>
					  <li><?php _e('Try more general keywords, especially if you are attempting a name', 'Awaken'); ?></li>
				  </ul>
			  </div>
			  <?php
		   else : 
			  _e( '<p>It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.</p>', 'Awaken' ); 
			  
		  endif; 
            
          if ( is_search() ) : 
              get_search_form();
          endif;
		  
		  ?>
        </div>
	<?php
	}
}
function wps_highlight_results($text){
     if(is_search()){
     $sr = get_query_var('s');
     $keys = explode(" ",$sr);
     $text = preg_replace('/('.implode('|', $keys) .')/iu', ''.$sr.'', $text);
     }
     return $text;
}
add_filter('get_the_excerpt', 'wps_highlight_results');
//add_filter('the_title', 'wps_highlight_results');

// Custom function for next previous posts
if ( ! function_exists( 'px_next_prev_custom_links' ) ) {
	 function px_next_prev_custom_links($post_type = 'events'){
			global $post,$wpdb,$cs_theme_options, $cs_xmlObject;
			$previd = $nextid = '';
			$post_type = get_post_type($post->ID);
			$count_posts = wp_count_posts( "$post_type" )->publish;
			$px_postlist_args = array(
			   'posts_per_page'  => -1,
			   'order'           => 'ASC',
			   'post_type'       => "$post_type",
			); 
			$px_postlist = get_posts( $px_postlist_args );
			$ids = array();
			foreach ($px_postlist as $px_thepost) {
			   $ids[] = $px_thepost->ID;
			}
			$thisindex = array_search($post->ID, $ids);
			if(isset($ids[$thisindex-1])){
				$previd = $ids[$thisindex-1];
			} 
			if(isset($ids[$thisindex+1])){
				$nextid = $ids[$thisindex+1];
			} 
			
			echo '<div class="prev-next-post"><div class="row">';
			if (isset($previd) && !empty($previd) && $previd >=0 ) {
			   ?>
			   <div class="col-md-6">
				<article class="prev">
					 <figure><?php  echo  get_the_post_thumbnail($previd, array(70,70) );?></figure>
					 <div class="text">
					   <h2><a href="<?php echo get_permalink($previd); ?>"><?php echo get_the_title($previd);?></a></h2>
						<a class="fa fa-arrow-circle-left" href="<?php echo get_permalink($previd);?>"></a>
					 </div>
				</article>
			  </div>
		   <?php
			}
	
			if (isset($nextid) && !empty($nextid) ) {
				if (isset($previd) && !empty($previd) && $previd >=0 ) {
					$nextClass	= 'right-btn';
				} else {
					$nextClass	= 'right-btn cs-single-post';
				}
				?>
				<div class="col-md-6">
				  <article class="next">
					<figure> <?php   echo get_the_post_thumbnail($nextid, array(70,70) );?></figure>
					<div class="text">
						<h2> <a href="<?php echo get_permalink($nextid); ?>"><?php echo get_the_title($nextid);?></a></h2>
						<a class="fa fa-arrow-circle-right" href="<?php echo get_permalink($nextid); ?>"></a>
					</div>
				  </article>
			   </div>
			<?php	
			}
			echo '</div></div>';
		 wp_reset_query();
	 }
}

/*	Function to get the events info on calander -- START	*/
add_action('get_header', 'my_filter_head');

  function my_filter_head() {
    remove_action('wp_head', '_admin_bar_bump_cb');
  }

// Get User ID
if ( ! function_exists( 'cs_get_user_id' ) ) {
	function cs_get_user_id() {
		global $current_user;
		get_currentuserinfo();
		return $current_user->ID;
	}
}

// get object array
function cs_ObjecttoArray($obj)
{
	if (is_object($obj)) $obj = (array)$obj;
	if (is_array($obj)) {
		$new = array();
		foreach ($obj as $key => $val) {
			$new[$key] = cs_ObjecttoArray($val);
		}
	} else {
		$new = $obj;
	}

	return $new;
}



// Get Google Fonts
function cs_get_google_fonts() {
    $fonts = array("Abel", "Aclonica", "Acme", "Actor", "Advent Pro", "Aldrich", "Allerta", "Allerta Stencil", "Amaranth", "Andika", "Anonymous Pro", "Antic", "Anton", "Arimo", "Armata", "Asap", "Asul",
        "Basic", "Belleza", "Cabin", "Cabin Condensed", "Cagliostro", "Candal", "Cantarell", "Carme", "Chau Philomene One", "Chivo", "Coda Caption", "Comfortaa", "Convergence", "Cousine", "Cuprum", "Days One",
        "Didact Gothic", "Doppio One", "Dorsa", "Dosis", "Droid Sans", "Droid Sans Mono", "Duru Sans", "Economica", "Electrolize", "Exo", "Federo", "Francois One", "Fresca", "Galdeano", "Geo", "Gudea",
        "Hammersmith One", "Homenaje", "Imprima", "Inconsolata", "Inder", "Istok Web", "Jockey One", "Josefin Sans", "Jura", "Karla", "Krona One", "Lato", "Lekton", "Magra", "Mako", "Marmelad", "Marvel",
        "Maven Pro", "Metrophobic", "Michroma", "Molengo", "Montserrat", "Muli", "News Cycle", "Nobile", "Numans", "Nunito", "Open Sans", "Open Sans Condensed", "Orbitron", "Oswald", "Oxygen", "PT Mono",
        "PT Sans", "PT Sans Caption", "PT Sans Narrow", "Paytone One", "Philosopher", "Play", "Pontano Sans", "Port Lligat Sans", "Puritan", "Quantico", "Quattrocento Sans", "Questrial", "Quicksand", "Rationale",
        "Roboto","Ropa Sans", "Rosario", "Ruda", "Ruluko", "Russo One", "Shanti", "Sigmar One", "Signika", "Signika Negative", "Six Caps", "Snippet", "Spinnaker", "Syncopate", "Telex", "Tenor Sans", "Ubuntu",
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

// enqueue timepicker scripts

function cs_enqueue_timepicker_script(){
	//if(is_admin()){
		wp_enqueue_script('datetimepicker1_js', get_template_directory_uri() . '/include/assets/scripts/jquery_datetimepicker.js', '', '', true);
		wp_enqueue_style('datetimepicker1_css', get_template_directory_uri() . '/include/assets/css/jquery_datetimepicker.css');

	//}
}
add_action('admin_enqueue_scripts', 'my_admin_scripts');

// enqueue admin scripts
function my_admin_scripts() {
    if (isset($_GET['page']) && $_GET['page'] == 'my_plugin_page') {
        wp_enqueue_media();
        wp_register_script('my-admin-js', WP_PLUGIN_URL.'/my-plugin/my-admin.js', array('jquery'));
        wp_enqueue_script('my-admin-js');
    }
}

// register theme menu
function cs_register_my_menus() {
  register_nav_menus(
	array(
		'main-menu'  => __('Main Menu','Awaken'),
		'footer-menu'  => __('Footer Menu','Awaken'),
		'top-menu'  => __('Top Menu','Awaken')
		
 	)
  );
}
add_action( 'init', 'cs_register_my_menus' );

//  Set Post Veiws Start
if(!function_exists('cs_set_post_views')){
		function cs_set_post_views($postID) {
		 //   $visited = get_transient($key); //get transient and store in variable
			if ( !isset($_COOKIE["cs_count_views".$postID]) ){
				setcookie("cs_count_views".$postID, 'post_view_count', time()+86400);
			   //  set_transient( $key, $value, 60*60*12);
				$count_key = 'cs_count_views';
				$count = get_post_meta($postID, $count_key, true);
				if($count==''){
					$count = 0;
					delete_post_meta($postID, $count_key);
					add_post_meta($postID, $count_key, '0');
				}else{
					$count++;
					update_post_meta($postID, $count_key, $count);
				}
			}
		}
}
//  Set Post Veiws End

//  Get Post Veiws Start
if(!function_exists('cs_get_post_views')){
		function cs_get_post_views($postID){
			$count_key = 'cs_count_views';
			$count = get_post_meta($postID, $count_key, true);
			if($count==''){
				delete_post_meta($postID, $count_key);
				add_post_meta($postID, $count_key, '0');
				return "0 ";
			}
		 return number_format($count);
		}
}

//  Get Post Veiws End

//  Excerpt Default Length 
function cs_custom_excerpt_length( $length ) {
	return 200;
}
add_filter( 'excerpt_length', 'cs_custom_excerpt_length' );
// Custom excerpt function 
if ( ! function_exists( 'cs_get_the_excerpt' ) ) { 
	function cs_get_the_excerpt($charlength='255', $readmore = 'true', $readmore_text='Read More') {
		global $post,$cs_theme_option;
		$excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU', '', get_the_excerpt()));
		if ( strlen( $excerpt ) > $charlength ) {
/*			$subex = mb_substr( $excerpt, 0, $charlength - 5 );
			$exwords = explode( ' ', $subex );
			$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );*/
			if ( $charlength > 0 ) {
				$excerpt	=  substr( $excerpt, 0, $charlength );
			} else {
				$excerpt	=   $excerpt;
			}
			if( $readmore == 'true'){
				$more	= '... <a href="' . get_permalink() . '" class="cs-read-more colr"><i class="fa fa-caret-right"></i>' .$readmore_text . '</a>';
			} else {
				$more	= '...';
			}
			return $excerpt.$more;
			
		} else {
			return $excerpt;
		}
	}
}
/* Excerpt Read More  */
function cs_excerpt_more( $more='...' ) {
 	return '....';
}
add_filter( 'excerpt_more', 'cs_excerpt_more' );

// get events tags list
if ( ! function_exists( 'cs_get_event_tags_list' ) ) { 
		function cs_get_event_tags_list($filter_category = '',$filter_tag  ='',$organizer_filter=''){
			global $post;
			$args = array('posts_per_page'=>-1,'post_type' => 'events','event-category' => $filter_category);
			$project_query = new WP_Query($args);
			$count_post = $project_query->post_count;
			$all_tags_arr	= array();
			while ($project_query->have_posts()) : $project_query->the_post();
				$posttags = get_the_terms($post->ID,'event-tag');
				if ($posttags) {
					foreach($posttags as $tag) {
						$all_tags_arr[] = $tag->name; //USING JUST $tag MAKING $all_tags_arr A MULTI-DIMENSIONAL ARRAY, WHICH DOES WORK WITH array_unique
					}
				}
			endwhile;

			if ( is_array($all_tags_arr) && count($all_tags_arr) > 0 ){ 
				$tags_arr = array_unique($all_tags_arr); //REMOVES DUPLICATES
				foreach( $tags_arr as $tag ):
					$active_class = '';
					$el = get_term_by('name', $tag, 'event-tag');
					$arr[] = '"tag-'.$el->slug.'"';
					if($filter_tag==$el->slug){
						$active_class = "class='active'";
					}
					echo '<a href="?organizer='.$organizer_filter.'&amp;?filter_category='.$filter_category.'&amp;filter-tag='.$el->slug.'" id="taglink-tag-'.$el->slug.'" title="tag-'.$el->slug.'" '.$active_class.' >'.$el->name.'</a>';
				endforeach; 
			}else{
				 _e('<a>No Tags Found.</a>','Awaken');
			}
		}
}

//=====================================================================
// Sermons Tags methods
//=====================================================================
if ( ! function_exists( 'cs_get_sermon_tags_list' ) ) { 
		function cs_get_sermon_tags_list($filter_category = '',$filter_tag  =''){
			global $post;
			$args = array('posts_per_page'=>-1,'post_type' => 'sermons','sermon-category' => $filter_category);
			$project_query = new WP_Query($args);
			$count_post = $project_query->post_count;
			$all_tags_arr	= array();
			while ($project_query->have_posts()) : $project_query->the_post();
				$posttags = get_the_terms($post->ID,'sermon-tag');
				if ($posttags) {
					foreach($posttags as $tag) {
						$all_tags_arr[] = $tag->name; //USING JUST $tag MAKING $all_tags_arr A MULTI-DIMENSIONAL ARRAY, WHICH DOES WORK WITH array_unique
					}
				}
			endwhile;

			if ( is_array($all_tags_arr) && count($all_tags_arr) > 0 ){ 
				$tags_arr = array_unique($all_tags_arr); //REMOVES DUPLICATES
				foreach( $tags_arr as $tag ):
					$active_class = '';
					$el = get_term_by('name', $tag, 'sermon-tag');
					$arr[] = '"tag-'.$el->slug.'"';
					if($filter_tag==$el->slug){
						$active_class = "class='active'";
					}
					echo '<a href="?filter_category='.$filter_category.'&amp;filter-tag='.$el->slug.'" id="taglink-tag-'.$el->slug.'" title="tag-'.$el->slug.'" '.$active_class.' >'.$el->name.'</a>';
				endforeach; 
			}else{
				 _e('<a>No Tags Found.</a>','Awaken');
			}
		}
}

//=====================================================================
// Events filtering methods
//=====================================================================
function cs_get_event_filters($cs_filter_category,$cs_filter_switch,$filter_category,$filter_tag,$userArray,$organizer_filter,$cs_custom_animation){
	 global $post,$cs_theme_options,$cs_counter_node,$wpdb;
	 $nav_count = rand(40, 9999999);
	 if ( isset( $cs_filter_switch ) && $cs_filter_switch == 'Yes') { 
	 ?>
		<!--Sorting Navigation-->
        <div class="col-md-12">
          <nav class="wow filter-nav <?php echo cs_allow_special_char($cs_custom_animation);?>">
            <ul class="cs-filter-menu pull-left">
              <li> <a href="#pager-1<?php echo cs_allow_special_char($nav_count);?>"> <i class="fa fa-search"></i><?php 
               _e('Filter By','Awaken'); ?>  
               </a> </li>
              <li><a href="#pager-2<?php echo cs_allow_special_char($nav_count);?>"><i class="fa fa-list"></i><?php 
                   _e('Categories','Awaken');  
              ?></a></li>
              <li><a href="#pager-3<?php echo cs_allow_special_char($nav_count);?>"><i class="fa fa-tags"></i><?php 
                 _e('Tags','Awaken'); 
              ?></a></li>
              <li><a href="#pager-4<?php echo cs_allow_special_char($nav_count);?>"><i class="fa fa-user"></i><?php 
                 _e('Organizers','Awaken'); 
              ?></a></li>
            </ul>
            <a href="<?php the_permalink();?>" class="pull-right cs-btnshowall"> <i class="fa fa-check-circle-o"></i>
                <?php   _e('Show All','Awaken'); ?>  
            </a>
            <div id="pager-1<?php echo cs_allow_special_char($nav_count);?>" class="filter-pager" style="display: none;"> <a class="<?php if(isset($_GET['sort']) and $_GET['sort']=='asc') { echo 'active';}?>" href="?<?php echo 'organizer='.$organizer_filter.'&amp;sort=asc&amp;filter_category='.$filter_category.'&amp;filter-tag='.$filter_tag; ?>"> <?php    _e('Date Published','Awaken'); ?> </a> <a class="<?php if(isset($_GET['sort']) and $_GET['sort']=='alphabetical') { echo 'active';}?>" href="?<?php echo 'organizer='.$organizer_filter.'&amp;sort=alphabetical&amp;filter_category='.$filter_category.'&amp;filter_tag='.$filter_tag; ?>"> <?php echo _e('Alphabetical','Awaken');?></a></div>
            <div id="pager-2<?php echo cs_allow_special_char($nav_count);?>" class="filter-pager" style="display: none;">
              <?php
                $row_cat = $wpdb->get_row($wpdb->prepare("SELECT * from $wpdb->terms WHERE slug = %s", $cs_filter_category ));
                if( isset($cs_filter_category) && ($cs_filter_category <> "" && $cs_filter_category <> "0")   && isset( $row_cat->term_id )){	
                  $categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'event-category', 'hide_empty' => 0));
                ?>
              <a href="?<?php echo 'organizer='.$organizer_filter.'&amp;filter_category='.$filter_category; ?>" class="<?php if(($cs_filter_category == $filter_category)){ echo 'bgcolr';}?>"><?php  _e('All Categories','Awaken');?></a>
              <?php
                }else{
                    $categories = get_categories( array('taxonomy' => 'event-category', 'hide_empty' => 0) );
                }
                foreach ($categories as $category) {
                ?>
              <a href="?<?php echo "organizer=".$organizer_filter."&amp;filter_category=".$category->slug?>" 
                          <?php if($category->slug==$filter_category){echo 'class="active"';}?>> <?php echo cs_allow_special_char($category->cat_name); ?> </a>
              <?php }?>
            </div>
            <div id="pager-3<?php echo cs_allow_special_char($nav_count);?>" class="filter-pager" style="display: none;">
              <?php cs_get_event_tags_list ($filter_category,$filter_tag,$organizer_filter); ?>
            </div>
            <div id="pager-4<?php echo cs_allow_special_char($nav_count);?>" class="filter-pager" style="display: none;">
              <?php 
                $eventusers = get_users('orderby=nicename');
                if ( isset( $userArray ) && $userArray !='' && is_array( $userArray ) ) {
                    foreach ($eventusers as $user) {
                        if ( in_array( $user->ID,$userArray )) {
                         ?>
                  <a <?php if(isset($_GET['organizer']) && $user->ID ==$_GET['organizer']){echo 'class="active"';}?> href="?<?php echo 'organizer='.$user->ID.'&amp;filter_category='.$filter_category.'&amp;filter_tag='.$filter_tag; ?>"> <?php echo cs_allow_special_char($user->display_name); ?> </a>
                  <?php } }
                    } else {?>
                  <a><?php _e('No Organizer Found.','Awaken'); ?> </a>
                  <?php }?>
            </div>
          </nav>
        </div>
	<!--Sorting Navigation End-->
	<?php 
	} 		
}


//=====================================================================
// Events filtering methods
//=====================================================================
function cs_get_sermon_filters($cs_filter_category,$cs_filter_switch,$filter_category,$filter_tag,$cs_custom_animation){
	 global $post,$cs_theme_options,$cs_counter_node,$wpdb;
	 $nav_count = rand(40, 9999999);
	 if ( isset( $cs_filter_switch ) && $cs_filter_switch == 'yes') { 
	 ?>
		<!--Sorting Navigation-->
        <div class="col-md-12">
          <nav class="wow filter-nav <?php echo cs_allow_special_char($cs_custom_animation);?>">
            <ul class="cs-filter-menu pull-left">
              <li> <a href="#pager-1<?php echo cs_allow_special_char($nav_count);?>"> <i class="fa fa-search"></i><?php 
               _e('Filter By','Awaken'); ?>  
               </a> </li>
              <li><a href="#pager-2<?php echo cs_allow_special_char($nav_count);?>"><i class="fa fa-list"></i><?php 
                   _e('Categories','Awaken');  
              ?></a></li>
              <li><a href="#pager-3<?php echo cs_allow_special_char($nav_count);?>"><i class="fa fa-tags"></i><?php 
                 _e('Tags','Awaken'); 
              ?></a></li>
            </ul>
            <a href="<?php the_permalink();?>" class="pull-right cs-btnshowall"> <i class="fa fa-check-circle-o"></i>
                <?php   _e('Show All','Awaken'); ?>  
            </a>
            <div id="pager-1<?php echo cs_allow_special_char($nav_count);?>" class="filter-pager" style="display: none;"> <a class="<?php if(isset($_GET['sort']) and $_GET['sort']=='asc') { echo 'active';}?>" href="?<?php echo 'sort=asc&amp;filter_category='.$filter_category.'&amp;filter-tag='.$filter_tag; ?>"> <?php    _e('Date Published','Awaken'); ?> </a> <a class="<?php if(isset($_GET['sort']) and $_GET['sort']=='alphabetical') { echo 'active';}?>" href="?<?php echo 'sort=alphabetical&amp;filter_category='.$filter_category.'&amp;filter_tag='.$filter_tag; ?>"> <?php echo _e('Alphabetical','Awaken');?></a></div>
            <div id="pager-2<?php echo cs_allow_special_char($nav_count);?>" class="filter-pager" style="display: none;">
              <?php
                $row_cat = $wpdb->get_row($wpdb->prepare("SELECT * from $wpdb->terms WHERE slug = %s", $cs_filter_category ));
                if( isset($cs_filter_category) && ($cs_filter_category <> "" && $cs_filter_category <> "0")   && isset( $row_cat->term_id )){	
                  $categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'sermon-category', 'hide_empty' => 0));
                ?>
              <a href="?<?php echo 'filter_category='.$filter_category; ?>" class="<?php if(($cs_filter_category == $filter_category)){ echo 'bgcolr';}?>"><?php  _e('All Categories','Awaken'); ?></a>
              <?php
                }else{
                    $categories = get_categories( array('taxonomy' => 'sermon-category', 'hide_empty' => 0) );
                }
                foreach ($categories as $category) {
                ?>
              <a href="?<?php echo "filter_category=".$category->slug?>" 
                          <?php if($category->slug==$filter_category){echo 'class="active"';}?>> <?php echo cs_allow_special_char($category->cat_name); ?> </a>
              <?php }?>
            </div>
            <div id="pager-3<?php echo cs_allow_special_char($nav_count);?>" class="filter-pager" style="display: none;">
              <?php cs_get_sermon_tags_list ($filter_category,$filter_tag); ?>
            </div>
          </nav>
        </div>
	<!--Sorting Navigation End-->
	<?php 
	} 		
}

//=====================================================================
// Blog filtering methods
//=====================================================================
function cs_get_blog_filters($cs_blog_cat,$author_filter,$filter_category,$filter_tag,$cs_blog_filterable,$cs_custom_animation){
	 global $post,$cs_theme_options,$cs_counter_node,$wpdb;
	 $nav_count = rand(40, 9999999);
	 if ( isset( $cs_blog_filterable ) && $cs_blog_filterable == 'yes') { 
	 ?>
		<!--Sorting Navigation-->
        <div class="col-md-12">
          <nav class="wow filter-nav <?php echo cs_allow_special_char($cs_custom_animation);?>">
            <ul class="cs-filter-menu pull-left">
              <li> <a href="#pager-1<?php echo cs_allow_special_char($nav_count);?>"> <i class="fa fa-search"></i><?php
               _e('Filter By','Awaken'); ?>  
               </a> </li>
              <li><a href="#pager-2<?php echo cs_allow_special_char($nav_count);?>"><i class="fa fa-list"></i><?php 
                   _e('Categories','Awaken');  
              ?></a></li>
              <li><a href="#pager-3<?php echo cs_allow_special_char($nav_count);?>"><i class="fa fa-tags"></i><?php 
                 _e('Tags','Awaken'); 
              ?></a></li>
              <li><a href="#pager-4<?php echo cs_allow_special_char($nav_count);?>"><i class="fa fa-user"></i><?php
                 _e('Author','Awaken'); 
              ?></a></li>
            </ul>
            <a href="<?php the_permalink();?>" class="pull-right cs-btnshowall"> <i class="fa fa-check-circle-o"></i> 
                <?php   _e('Show All','Awaken'); ?>  
            </a>
            <div id="pager-1<?php echo cs_allow_special_char($nav_count);?>" class="filter-pager" style="display: none;"> 
            <a class="<?php if(isset($_GET['sort']) and $_GET['sort']=='asc') { echo 'active';}?>" href="?<?php echo 'by_author='.$author_filter.'&amp;sort=asc&amp;filter_category='.$filter_category.'&amp;filter-tag='.$filter_tag; ?>"> <?php    _e('Date Published','Awaken'); ?> </a>
            <a class="<?php if(isset($_GET['sort']) and $_GET['sort']=='alphabetical') { echo 'active';}?>" href="?<?php echo 'by_author='.$author_filter.'&amp;sort=alphabetical&amp;filter_category='.$filter_category.'&amp;filter_tag='.$filter_tag; ?>"> <?php echo _e('Alphabetical','Awaken');?> </a> </div>
            <div id="pager-2<?php echo cs_allow_special_char($nav_count);?>" class="filter-pager" style="display: none;">
              <?php
				$row_cat = $wpdb->get_row($wpdb->prepare("SELECT * from $wpdb->terms WHERE slug = %s", $cs_blog_cat ));
                if( isset($cs_blog_cat) && ($cs_blog_cat <> "" && $cs_blog_cat <> "0")   && isset( $row_cat->term_id )){	
                  $categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'category', 'hide_empty' => 1));
                ?>
              <a href="?<?php echo 'by_author='.$author_filter.'&amp;filter_category='.$filter_category; ?>" class="<?php if(($cs_blog_cat == $filter_category)){ echo 'bgcolr';}?>"><?php  _e('All Categories','Awaken'); ?></a>
              <?php
                }else{
                    $categories = get_categories( array('taxonomy' => 'category', 'hide_empty' => 1) );
                }
                foreach ($categories as $category) {
                ?>
              <a href="?<?php echo "by_author=".$author_filter."&amp;filter_category=".$category->slug?>" 
                          <?php if($category->slug==$filter_category){echo 'class="active"';}?>> <?php echo cs_allow_special_char($category->cat_name); ?> </a>
              <?php }?>
            </div>
            <div id="pager-3<?php echo cs_allow_special_char($nav_count);?>" class="filter-pager" style="display: none;">
              <?php cs_get_post_tags_list ($filter_category,$filter_tag,$author_filter); ?>
            </div>
            <div id="pager-4<?php echo cs_allow_special_char($nav_count);?>" class="filter-pager" style="display: none;">
              <?php 
			  			$user_ids = get_users( array(
							'fields'  => 'all',
							'orderby' => 'post_count',
							'order'   => 'DESC',
							'who'     => 'authors',
						) );
						foreach ( $user_ids as $user ) {
							$post_count = count_user_posts( $user->ID );
							// Move on if user has not published a post (yet).
							if ( $post_count ) {?>
                            	<a <?php if(isset($_GET['by_author']) && $user->ID == $_GET['by_author']){echo 'class="active"';}?> href="?<?php echo 'by_author='.$user->ID.'&amp;filter_category='.$filter_category.'&amp;filter_tag='.$filter_tag; ?>"> <?php echo cs_allow_special_char($user->display_name);?> </a>
					  <?php }
						}
			  		 ?> 
            </div>
          </nav>
        </div>
	<!--Sorting Navigation End-->
	<?php 
	} 		
}


//=====================================================================
// Get Post tags list
//=====================================================================
function cs_get_post_tags_list($filter_category = '',$filter_tag  ='',$author_filter=''){
	global $post;
	$args = array('posts_per_page'=>-1,'post_type' => 'post','catgory' => $filter_category);
	$project_query = new WP_Query($args);
    while ($project_query->have_posts()) : $project_query->the_post();
    	$posttags = get_the_terms($post->ID,'post_tag');
		if ($posttags) {
        	foreach($posttags as $tag) {
            	$all_tags_arr[] = $tag->name; //USING JUST $tag MAKING $all_tags_arr A MULTI-DIMENSIONAL ARRAY, WHICH DOES WORK WITH array_unique
            }
        }
    endwhile;
    if ( is_array($all_tags_arr) && count($all_tags_arr) > 0 ): 
 		$tags_arr = array_unique($all_tags_arr); //REMOVES DUPLICATES
 	 	foreach( $tags_arr as $tag ):
			$active_class = '';
       		$el = get_term_by('name', $tag, 'post_tag');
			$arr[] = '"tag-'.$el->slug.'"';
			if($filter_tag==$el->slug){
				$active_class = "class='active'";
			}
   			
			echo '<a href="?by_author='.$author_filter.'&amp;filter_category='.$filter_category.'&amp;filter-tag='.$el->slug.'" id="taglink-tag-'.$el->slug.'" title="tag-'.$el->slug.'" '.$active_class.' >'.$el->name.'</a>';
	 	endforeach; 
 	endif;
}

function remove_menu_ids () {
   add_filter( 'nav_menu_item_id', '__return_null' );
}
add_action( 'init', 'remove_menu_ids' );
  
// Return Seleced
if(!function_exists('cs_selected')){
	function cs_selected($current,$orignal){
		if($current == $orignal){
			echo 'selected=selected';
		}
	}
}

// page builder element size
if(!function_exists('cs_pb_element_sizes')){
		function cs_pb_element_sizes($size= '100'){
			$element_size = 'element-size-100';
			if(isset($size) && $size == ''){
				$element_size = 'element-size-100';
			} else {
				$element_size = 'element-size-'.$size;
			}
			return $element_size;
		}
}


if ( ! function_exists( 'enable_more_buttons' ) ) {	
	function enable_more_buttons($buttons) {
	
		$buttons[] = 'fontselect';
		$buttons[] = 'fontsizeselect';
		$buttons[] = 'styleselect';
		$buttons[] = 'backcolor';
		$buttons[] = 'newdocument';
		$buttons[] = 'cut';
		$buttons[] = 'copy';
		$buttons[] = 'charmap';
		$buttons[] = 'hr';
		$buttons[] = 'visualaid';
		
		return $buttons;
	}
	add_filter("mce_buttons_3", "enable_more_buttons");
}
add_action( 'init', 'my_deregister_heartbeat', 1 );

function my_deregister_heartbeat() {
	global $pagenow;

	if ( 'post.php' != $pagenow && 'post-new.php' != $pagenow )
		wp_deregister_script('heartbeat');
}

// Like Counter
if ( ! function_exists( 'cs_like_counter' ) ) {
		function cs_like_counter($cs_likes_title=''){
		$cs_like_counter = '';
			  $cs_like_counter = get_post_meta(get_the_id(), "cs_like_counter", true);
			  if ( !isset($cs_like_counter) or empty($cs_like_counter) ) $cs_like_counter = 0;
				  if ( isset($_COOKIE["cs_like_counter".get_the_id()]) ) { ?>
					   <a> <i class="fa fa-heart liked-post"></i><span><?php echo cs_allow_special_char($cs_like_counter.' '.$cs_likes_title); ?></span></a> 
			  <?php 	} else {?>
				<a class="likethis<?php echo get_the_id()?> cs-btnheart cs-btnpopover" id="like_this<?php echo get_the_id()?>"  href="javascript:cs_like_counter('<?php echo get_template_directory_uri()?>',<?php echo get_the_id()?>,'<?php echo cs_allow_special_char($cs_likes_title);?>','<?php echo admin_url('admin-ajax.php');?>')" data-container="body" data-toggle="tooltip" data-placement="top" title="<?php _e('Like This','Awaken'); ?>"><i class="fa fa-heart-o"></i><span><?php echo cs_allow_special_char($cs_like_counter.' '.$cs_likes_title);?></span></a>
				   
				   <a class="likes likethis" id="you_liked<?php echo get_the_id()?>" style="display:none;"><i class="fa fa-heart  liked-post"></i><span class="count-numbers like_counter<?php echo get_the_id()?>"><?php echo cs_allow_special_char($cs_like_counter.' '.$cs_likes_title); ?></span> </a>
				 
				  <div id="loading_div<?php echo get_the_id()?>" style="display:none;"><i class="fa fa-spinner fa-spin"></i></div>
			   <?php }
		}

	//likes counter
	add_action( 'wp_ajax_nopriv_cs_likes_count', 'cs_likes_count' );
	add_action( 'wp_ajax_cs_likes_count', 'cs_likes_count' );
}
// Post like counter
if ( ! function_exists( 'cs_likes_count' ) ) {
		function cs_likes_count() {
			
			$cs_like_counter = get_post_meta( $_POST['post_id'] , "cs_like_counter", true);
					if ( !isset($_COOKIE["cs_like_counter".$_POST['post_id'] ]) ){
						setcookie("cs_like_counter".$_POST['post_id'], 'true', time()+(10 * 365 * 24 * 60 * 60), '/');
						update_post_meta( $_POST['post_id'], 'cs_like_counter', $cs_like_counter+1 );
					}
				$cs_like_counter = get_post_meta($_POST['post_id'], "cs_like_counter", true);
				if ( !isset($cs_like_counter) or empty($cs_like_counter) ) $cs_like_counter = 0;
				echo cs_allow_special_char($cs_like_counter);
				die();
		}
}
//Mailchimp
add_action( 'wp_ajax_nopriv_cs_mailchimp', 'cs_mailchimp' );
add_action( 'wp_ajax_cs_mailchimp', 'cs_mailchimp' );

function cs_mailchimp() {
	
	  global $cs_theme_options,$counter;
	  $mailchimp_key = '';
	  if(isset($cs_theme_options['cs_mailchimp_key'])){ $mailchimp_key= $cs_theme_options['cs_mailchimp_key'];}
	  if(isset($_POST) and !empty($_POST['cs_list_id']) and $mailchimp_key !=''){
		  if($mailchimp_key <> ''){
				$MailChimp = new MailChimp($mailchimp_key);
			}
		$email = $_POST['mc_email'];
		$list_id = $_POST['cs_list_id'];
		$result = $MailChimp->call('lists/subscribe', array(
			'id'                => $list_id,
			'email'             => array('email'=>$email),
			'merge_vars'        => array(),
			'double_optin'      => false,
			'update_existing'   => false,
			'replace_interests' => false,
			'send_welcome'      => true,
		));
		if($result <> ''){
			if(isset($result['status']) and $result['status'] == 'error'){
				echo cs_allow_special_char($result['error']);
			}else{
				echo 'subscribe successfully';
			}
		}
	  }else{
		echo 'please set API key';	 
	  }
	  die();
}
// Add SoundCloud oEmbed
function add_oembed_soundcloud(){
wp_oembed_add_provider( 'http://soundcloud.com/*', 'http://api.soundcloud.com/' );
}
//Mailchimp
/**
 * Add TinyMCE to multiple Textareas (usually in backend).
 */

function cs_wp_editor($id='') {
	?>
	<script type="text/javascript">
		 var fullId	= "<?php echo cs_allow_special_char($id);?>";
		 
		//tinymce.execCommand('mceAddEditor', false, fullId);
		// use wordpress settings
		tinymce.init({
		selector: fullId,
		theme:"modern",
		skin:"lightgray",
		language:"en",
		selector:"#" + fullId,
		resize:"vertical",
		menubar:false,
		wpautop:true,
		indent:false,
		quicktags : "em,strong,link",
		toolbar1:"bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink",
		//toolbar2:"formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help",
		tabfocus_elements:":prev,:next",
		body_class:"id post-type-post post-status-publish post-format-standard",
		
		});
		
		//quicktags({id : fullId});
		settings = {
			id : fullId,
			// buttons: 'strong,em,link' 
		}

    	quicktags(settings);
            //init tinymce
         //tinymce.init(tinyMCEPreInit.mceInit[fullId]);
			
		//quicktags({id : fullId});
		/*tinymce.execCommand('mceRemoveEditor', true, fullId);
		var init = tinymce.extend( {}, tinyMCEPreInit.mceInit[ fullId ] );
		try { tinymce.init( init ); } catch(e){}
		
		 tinymce.execCommand( 'mceRemoveEditor', false, fullId );
		 tinymce.execCommand( 'mceAddEditor', false, fullId );
		 
		 quicktags({id : fullId});*/
    </script><?php

}

add_action( 'wp_ajax_cs_select_editor', 'cs_wp_editor' );


//Submit Form
add_action( 'wp_ajax_nopriv_cs_contact_form_submit', 'cs_contact_form_submit' );
add_action( 'wp_ajax_cs_contact_form_submit', 'cs_contact_form_submit' );

//Get attachment id
function cs_get_attachment_id_from_url( $attachment_url = '' ) {
 
	global $wpdb;
	$attachment_id = false;
 
	// If there is no url, return.
	if ( '' == $attachment_url )
		return;
 
	// Get the upload directory paths
	$upload_dir_paths = wp_upload_dir();
 
	if ( false !== strpos( $attachment_url, $upload_dir_paths['baseurl'] ) ) {
 
		// If this is the URL of an auto-generated thumbnail, get the URL of the original image
		$attachment_url = preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url );
 
		// Remove the upload path base directory from the attachment URL
		$attachment_url = str_replace( $upload_dir_paths['baseurl'] . '/', '', $attachment_url );
 
		$attachment_id = $wpdb->get_var( $wpdb->prepare( "SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url ) );
 
	}
 
	return $attachment_id;
}

// Custom File types allowed
add_filter('upload_mimes', 'custom_upload_mimes');

function custom_upload_mimes ( $existing_mimes=array() ) {

	// add the file extension to the array

	$existing_mimes['woff'] = 'mime/type';
	$existing_mimes['ttf']  = 'mime/type';
	$existing_mimes['svg']  = 'mime/type';
	$existing_mimes['eot']  = 'mime/type';

	return $existing_mimes;

}

// Contact form submit ajax
if ( ! function_exists( 'cs_contact_form_submit' ) ) :
	function cs_contact_form_submit() {
		define('WP_USE_THEMES', false);
		$subject = '';
		$cs_contact_error_msg = '';
		$cs_contact_email = '';
		$subject_name = 'Subject';
		foreach ($_REQUEST as $keys=>$values) {
			$$keys = esc_attr($values);
		}
		if(isset($phone) && $phone <> ''){
			$subject_name = 'Phone';
			 $subject = $phone;
		}
		$bloginfo 	= get_bloginfo();
			$subjecteEmail = "(" . $bloginfo . ") Contact Form Received";
			$message = '
				<table width="100%" border="1">
				  <tr>
					<td width="100"><strong>Name:</strong></td>
					<td>'.esc_attr($contact_name).'</td>
				  </tr>
				  <tr>
					<td><strong>Email:</strong></td>
					<td>'.sanitize_email($contact_email).'</td>
				  </tr>
				  <tr>
					<td><strong>'.$subject_name.':</strong></td>
					<td>'.esc_attr($subject).'</td>
				  </tr>
				  <tr>
					<td><strong>Message:</strong></td>
					<td>'.balanceTags($contact_msg, true).'</td>
				  </tr>
				  <tr>
					<td><strong>IP Address:</strong></td>
					<td>'.$_SERVER["REMOTE_ADDR"].'</td>
				  </tr>
				</table>';
			$headers = "From: " . esc_attr($contact_name) . "\r\n";
			$headers .= "Reply-To: " . sanitize_email($contact_email) . "\r\n";
			$headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
			$headers .= "MIME-Version: 1.0" . "\r\n";
			$attachments = '';
			
			if(	wp_mail( sanitize_email($cs_contact_email), $subjecteEmail, $message, $headers, $attachments ) ) {
				$json	= array();
				$json['type']    = "success";
				$json['message'] = '<p>'.cs_textarea_filter($cs_contact_succ_msg).'</p>';
			} else {
				$json['type']    = "error";
				$json['message'] = '<p>'.cs_textarea_filter($cs_contact_error_msg).'</p>';
			};
			
		echo json_encode( $json );
		die();	
	}
endif; 
 
// Get user profile picture 
if ( ! function_exists( 'cs_admin_user_profile_picture_ajax' ) ) {
	function cs_admin_user_profile_picture_ajax() {
		$picture_class = $user_id = '';
		if(isset($_POST['picture_class']))  $picture_class = $_POST['picture_class'];
		if(isset($_POST['user_id']))  $user_id = $_POST['user_id'];
		
		$update_meta = update_user_meta($user_id, 'user_avatar_display', '');
		if($update_meta){
			echo get_avatar(get_the_author_meta('user_email',$user_id), apply_filters('PixFill_author_bio_avatar_size', 134));	
		} else {
			echo 'error';	
		}
		exit;
	}
	add_action('wp_ajax_cs_admin_user_profile_picture_ajax', 'cs_admin_user_profile_picture_ajax');
}

// Enqueue Player list js
if( ! function_exists('cs_sermon_audio_player')){
	function cs_sermon_audio_player($playlist=false){
			cs_mediaelementplayer_css();
			//add_action( 'wp_enqueue_scripts', 'cs_mediaelementplayer_css' );
		//wp_enqueue_style('mediaelementplayer.min_css', get_template_directory_uri() . '/assets/css/mediaelementplayer.min.css');
 	?>
		<script>
			/* ---------------------------------------------------------------------------
		   * Video,Audio Function
		   * --------------------------------------------------------------------------- */
		  jQuery(function(){
			jQuery('video,audio').mediaelementplayer({
			  loop: true,
			  shuffle: true,
			  playlist: true,
			  audioHeight: 30,
			  playlistposition: 'bottom',
			  features: ['playlistfeature','playpause', 'current', 'progress', 'duration', 'volume'],
			  keyActions: []
			});
		  });
		</script>
	<?php
	}
}

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
    <aside class="cs-post-sharebtn">
      <?php 
        previous_posts_link( '%link', '<i class="fa fa-angle-left"></i>' );
        next_posts_link( '%link','<i class="fa fa-angle-right"></i>' );
        ?>
    </aside>
    <?php
	}
}
/**
*
*@ Header Positions
*
**/
if ( ! function_exists( 'cs_header_position_settings' ) ) :
	function cs_header_position_settings(){
		 global $cs_xmlObject,$cs_theme_options;
			// header setting start
			if(is_page() || is_single()){
				$header_bg_options		= (isset($cs_xmlObject) and $cs_xmlObject->header_bg_options<>'') ? $cs_xmlObject->header_bg_options: '';
				$cs_rev_slider_id		= (isset($cs_xmlObject) and $cs_xmlObject->cs_rev_slider_id<>'') ? $cs_xmlObject->cs_rev_slider_id: '';
				$cs_header_bg_image		= (isset($cs_xmlObject) and $cs_xmlObject->cs_headerbg_image<>'') ? $cs_xmlObject->cs_headerbg_image: '';
				$cs_header_bg_color		= (isset($cs_xmlObject) and $cs_xmlObject->cs_headerbg_color<>'') ? $cs_xmlObject->cs_headerbg_color: '';
			}else{
				$header_bg_options		= (isset($cs_theme_options['cs_headerbg_options']) and $cs_theme_options['cs_headerbg_options']<>'') ? $cs_theme_options['cs_headerbg_options']: '';
				$cs_rev_slider_id		= (isset($cs_theme_options['cs_headerbg_slider']) and $cs_theme_options['cs_headerbg_slider']<>'') ? $cs_theme_options['cs_headerbg_slider']: '';
				$cs_header_bg_image		= (isset($cs_theme_options['cs_headerbg_image']) and $cs_theme_options['cs_headerbg_image']<>'') ? $cs_theme_options['cs_headerbg_image']: '';
				$cs_header_bg_color		= (isset($cs_theme_options['cs_headerbg_color']) and $cs_theme_options['cs_headerbg_color']<>'') ? $cs_theme_options['cs_headerbg_color']: '';
				
			}
			// header setting end
			if($cs_theme_options['cs_header_position'] =='absolute' and (isset($header_bg_options) and $header_bg_options <> '' and $header_bg_options !='none')){
		?>
		<div class="extra">
		<?php if($header_bg_options == 'cs_bg_image_color'){?>
			<style scoped="scoped">
				#main-header{
					background-image:url('<?php echo esc_url($cs_header_bg_image); ?>');
					background-color:<?php echo esc_attr($cs_header_bg_color); ?>;
					min-height:250px;
				}
			</style>
		<?php }elseif($header_bg_options == 'cs_rev_slider'){
				echo do_shortcode('[rev_slider '.$cs_rev_slider_id.']');
			} 
		?>
		</div>
		<?php }       
	}
endif;
if(class_exists('RevSlider')) {
	class cs_RevSlider extends RevSlider{
		public function getAllSliderAliases(){
			$where = "";
			$response = $this->db->fetch(GlobalsRevSlider::$table_sliders,$where,"id");
			$arrAliases = array();
			$slider_array = array();
			foreach($response as $arrSlider){
				$arrAliases['id'] = $arrSlider["id"];
				$arrAliases['title'] = $arrSlider["title"];
				$arrAliases['alias'] = $arrSlider["alias"];
				$slider_array[] = $arrAliases;
			}
			return($slider_array);
		}	
	}
}