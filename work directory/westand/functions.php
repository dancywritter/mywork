<?php
add_action( 'after_setup_theme', 'cs_theme_setup' );
function cs_theme_setup() {
	global $wpdb;
	/* Add theme-supported features. */
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();
	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
 	load_theme_textdomain('WeStand', get_template_directory() . '/languages');
	
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
	add_action( 'init', 'cs_register_my_menus' );
	if (is_admin() && isset($_GET['activated']) && $pagenow == 'themes.php'){
		
		if(!get_option('cs_theme_option')){
			add_action('admin_head', 'cs_activate_widget');
			add_action('init', 'cs_activation_data');
			 wp_redirect( admin_url( 'admin.php?page=cs_demo_importer' ) );
  			 exit;
			//main-menu
				/*$theme_mod_val = array();
				$term_exists = term_exists('main-menu', 'nav_menu');
				if ( !$term_exists ) {
					$wpdb->query(" INSERT INTO `" . $wpdb->prefix . "terms` VALUES ('', 'Main Menu' , 'main-menu', '0'); ");
					$insert_id = mysql_insert_id();
					$theme_mod_val['main-menu'] = $insert_id;
					$wpdb->query(" INSERT INTO `" . $wpdb->prefix . "term_taxonomy` VALUES ('', '".$insert_id."' , 'nav_menu', '', '0', '0'); ");
				}
				else $theme_mod_val['main-menu'] = $term_exists['term_id'];
				
				set_theme_mod( 'nav_menu_locations', $theme_mod_val );
				
				$home = get_page_by_title( 'Home' );
				if($home <> '' && get_option( 'page_on_front' ) == "0"){
					update_option( 'page_on_front', $home->ID );
					update_option( 'show_on_front', 'page' );
				}*/
	
			
		}
		//add_action('admin_head', 'cs_activate_widget');
		//add_action('init', 'cs_activation_data');
	}
	if (!session_id()){ 
		add_action('init', 'session_start');
	}
 	
	add_action('admin_enqueue_scripts', 'cs_admin_scripts_enqueue');
	add_action('wp_enqueue_scripts', 'cs_front_scripts_enqueue');
	add_action('pre_get_posts', 'cs_get_search_results');
	/* Add custom filters. */
	add_filter('widget_text', 'do_shortcode');
	add_filter('user_contactmethods','cs_contact_options',10,1);
	add_filter('the_password_form', 'cs_password_form' );
	add_filter('wp_page_menu','cs_add_menuid');
	add_filter('wp_page_menu', 'cs_remove_div' );
	add_filter('nav_menu_css_class', 'cs_add_parent_css', 10, 2);
	add_filter('pre_get_posts', 'cs_change_query_vars');
}

// tgm class for (internal and WordPress repository) plugin activation start
require_once dirname( __FILE__ ) . '/include/class-tgm-plugin-activation.php';
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
			'source'   				=> get_stylesheet_directory() . '/include/plugins/revslider.zip', 
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
		),
		array(
			'name' 		=> 'Woocommerce',
			'slug' 		=> 'woocommerce',
			'required' 	=> false,
		),
		

	);
	// Change this to your theme text domain, used for internationalising strings
	$theme_text_domain = 'WeStand';
	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       		=> 'WeStand',         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', 'WeStand' ),
			'menu_title'                       			=> __( 'Install Plugins', 'WeStand' ),
			'installing'                       			=> __( 'Installing Plugin: %s', 'WeStand' ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', 'WeStand' ),
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
			'return'                           			=> __( 'Return to Required Plugins Installer', 'WeStand' ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'WeStand' ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'WeStand' ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);
	tgmpa( $plugins, $config );
}
// tgm class for (internal and WordPress repository) plugin activation end




// adding custom images while uploading media start
// Blog Large, detail, Cause Detail
add_image_size('cs_media_1', 716, 393, true);
// Blog Carousal First image
add_image_size('cs_media_2', 406, 202, true);
// sidbar gallery
add_image_size('cs_media_3', 343, 228, true);
// compaign trail
add_image_size('cs_media_4', 259, 142, true);
//Team Page
add_image_size('cs_media_5', 250, 250, true);
// Cause list view
add_image_size('cs_media_6', 251, 188, true);
//Blog Grid, Event Grid
add_image_size('cs_media_7', 342, 193, true);
//Event List view
add_image_size('cs_media_8', 230, 186, true);
// adding custom images while uploading media end

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
    	<div class="prevnext-post">
 			<?php 
				previous_post_link( '%link', '<i class="fa fa-chevron-left"></i>' ); 
				next_post_link( '%link','<i class="fa fa-chevron-right"></i>' );
			 ?>
		</div>
	<?php
	}
}
/*

Top and Main Navigation

*/

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
if ( ! function_exists( 'cs_logo' ) ) {
	function cs_logo(){
		global $cs_theme_option;	
	?>
		<a href="<?php echo home_url(); ?>">
        	<?php  if(isset($cs_theme_option['logo'])){ ?>
        	<img src="<?php echo $cs_theme_option['logo']; ?>" width="<?php echo $cs_theme_option['logo_width']; ?>" height="<?php echo $cs_theme_option['logo_height']; ?>" alt="<?php echo bloginfo('name'); ?>" />
        	
			<?php } else {echo bloginfo('name');} ?>
        </a>

	 <?php

	}

}

/*

Add http to URL
*/
function cs_addhttp($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}
/*
Remove http from URL
*/
function cs_remove_http($url) {
   $disallowed = array('http://', 'https://');
   foreach($disallowed as $d) {
      if(strpos($url, $d) === 0) {
         return str_replace($d, '', $url);
      }
   }
   return $url;
}


// tgm class for (internal and WordPress repository) plugin activation end


// stripslashes / htmlspecialchars for theme option save start

function stripslashes_htmlspecialchars($value)

{

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
                    <h2 class="cs-section-title"><?php echo $cs_theme_option['varto_sevices_title']; ?></h2>
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

		"title"		=>	'Categories',

		"count" => 'checked'

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

		"title"		=>	'Latest Blogs',

		"select_category" 	=> 'blog',

		"showcount" => '3',

		"thumb" => 'true'

		 );						

		$recent_post_widget['_multiwidget'] = '1';

		update_option('widget_recentposts',$recent_post_widget);

		$recent_post_widget = get_option('widget_recentposts');

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

		$recent_post_widget2 = get_option('widget_recentposts');

		$recent_post_widget2[2] = array(

		"title"		=>	'Latest Posts',

		"select_category" 	=> 'blog',

		"showcount" => '2',

		"thumb" => 'true'

		 );						

		$recent_post_widget2['_multiwidget'] = '1';

		update_option('widget_recentposts',$recent_post_widget2);

		$recent_post_widget2 = get_option('widget_recentposts');

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

		"get_post_slug" 	=> 'event',

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

		// ----   recent event countdown widget setting---

		$upcoming_events_countdown_widget = array();

		$upcoming_events_countdown_widget[1] = array(

		"title"		=>	'Upcoming Events',

		"get_post_slug" 	=> 'event',

		"showcount" => '1',

 		 );						

		$upcoming_events_countdown_widget['_multiwidget'] = '1';

		update_option('widget_cs_upcomingevents_count',$upcoming_events_countdown_widget);

		$upcoming_events_countdown_widget = get_option('widget_cs_upcomingevents_count');

		krsort($upcoming_events_countdown_widget);

		foreach($upcoming_events_countdown_widget as $key1=>$val1)

		{

			$upcoming_events_countdown_widget = $key1;

			if(is_int($upcoming_events_countdown_widget))

			{

				break;

			}

		}
  
		// --- text widget setting ---

		$text = array();

		$text[1] = array(

			'title' => '',

			'text' => '<a href="'.site_url().'/"><img src="'.get_template_directory_uri().'/images/img-wi1.jpg" alt="" /></a>',

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

	 	//----text widget for contact info----------

		$text2 = array();

		$text2 = get_option('widget_text');

		$text2[2] = array(
			'title' => ' Contact Us',
			'text' => ' <div class="home-info">
                <a href=""><img src="'.get_template_directory_uri() . '/images/logo.png" alt=""></a>
                <h5>WeStand <br>Eaton Square 489, London, <br>United Kingdom</h5>
                <ul>
                    <li><i class="fa fa-phone"></i>Phone: (800) 123.456.7890</li>
                    <li><i class="fa fa-mobile"></i>Mobile: 123.456.7890</li>
                    <li><i class="fa fa-print"></i>Fax: (800) 123.456.7890</li>
                    <li><i class="fa fa-envelope"></i>Email: info@parlament.com</li>
                </ul>
                </div>',
		);						

		$text2['_multiwidget'] = '1';

		update_option('widget_text',$text2);

		$text2 = get_option('widget_text');

		krsort($text2);

		foreach($text2 as $key1=>$val1)

		{

			$text_key2 = $key1;

			if(is_int($text_key2))

			{

				break;

			}

		}

		// --- gallery widget setting ---

		$cs_gallery = array();

		$cs_gallery[1] = array(

			'title' => 'Our Photos',

			'get_names_gallery' => 'photo-gallery',

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
		
		// ---- Custom Menu widget setting---		

		$nav_menu = array();

		$nav_menu[1] = array(

			"title"		=>	'',
			"nav_menu"		=>	'shortcodes',
			

		);	

		$nav_menu['_multiwidget'] = '1';

		update_option('widget_nav_menu',$nav_menu);

		$nav_menu = get_option('widget_nav_menu');

		krsort($nav_menu);

		foreach($nav_menu as $key1=>$val1)

		{

			$nav_menu_key = $key1;

			if(is_int($nav_menu_key))

			{

				break;

			}

		}
		
		
		// --- facebook widget setting-----

		$facebook_module = array();

		$facebook_module[1] = array(

		"title"		=>	'facebook',

		"pageurl" 	=>	"https://www.facebook.com/envato",

		"showfaces" => "on",

		"likebox_height" => "265",

		"fb_bg_color" =>"#F5F2F2",

		);						

		$facebook_module['_multiwidget'] = '1';

		update_option('widget_facebook_module',$facebook_module);

		$facebook_module = get_option('widget_facebook_module');

		krsort($facebook_module);

		foreach($facebook_module as $key1=>$val1)

		{

			$facebook_module_key = $key1;

			if(is_int($facebook_module_key))

			{

				break;

			}

		}
		
		// --- Mail chimp widget setting-----

		$chimp_MailChimp_Widget = array();

		$chimp_MailChimp_Widget [1] = array(

		"title"		=>	'Sign up for our mailing list.',
		"description"		=>	'Enter Your email',

		);						

		$chimp_MailChimp_Widget['_multiwidget'] = '1';

		update_option('widget_chimp_MailChimp_Widget',$chimp_MailChimp_Widget);

		$chimp_MailChimp_Widget = get_option('widget_chimp_MailChimp_Widget');

		krsort($chimp_MailChimp_Widget);

		foreach($chimp_MailChimp_Widget as $key1=>$val1)

		{

			$chimp_MailChimp_Widget_key = $key1;

			if(is_int($chimp_MailChimp_Widget_key))

			{

				break;

			}

		}
		
		// --- Social Network widget setting-----

		$cs_social_network_widget = array();

		$cs_social_network_widget [1] = array(

		"title"		=>	'Follow Us',

		);						

		$cs_social_network_widget['_multiwidget'] = '4';

		update_option('widget_cs_social_network_widget',$cs_social_network_widget);

		$cs_social_network_widget = get_option('widget_cs_social_network_widget');

		krsort($cs_social_network_widget);

		foreach($cs_social_network_widget as $key1=>$val1)

		{

			$cs_social_network_widget = $key1;

			if(is_int($cs_social_network_widget))

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
		

		//----text widget for footer----------
		// Add widgets in sidebars

	$sidebars_widgets['Sidebar'] = array("categories-$categories_key", "upcoming_events-$upcoming_events_widget_key","facebook_module-$facebook_module_key", "cs_gallery-$cs_gallery_key");

	$sidebars_widgets['footer-widget-1'] = array("text-$text_key2", "recentposts-$recent_post_widget_key", "categories-$categories_key", "cs_twitter_widget-$cs_twitter_widget_key");
	$sidebars_widgets['footer-widget-2'] = array("chimp_mailchimp_widget-$chimp_MailChimp_Widget_key", "cs_social_network_widget-$cs_social_network_widget");
	$sidebars_widgets['shop'] = "";	
	$sidebars_widgets['shortcodes'] = array("nav_menu-$nav_menu_key");
	

	update_option('sidebars_widgets',$sidebars_widgets);  //save widget informations

	}

	// Install data on theme activation

 
	function cs_activation_data() {

		global $wpdb;

		$args = array(

			'style_sheet' => 'custom',
			
			'layout_option' => 'wrapper',

			'custom_color_scheme' => '#ce1a37',
   
			'layout_option' => 'wrapper',

			// Banner Backgorung Color

			'banner_bg_color' => '#ce1a37',
			

			// footer Color Settigs

			'header_styles' => 'header1',

			'default_header' => 'header1',

			// HEADER SETTINGS header_cart 

			'header_search' => 'on',
			'header_logo' => 'on',

 			'header_languages' => 'on',

			'header_cart' => 'off',
			'donation_btn_title' => 'Support us',
			
			'menu_bg_color' => '#000000',
			'menu_font_color' => '#FFFFFF',
 			
			'header_languages' => '',

			'header_social_icons' => 'on',

			'header_next_event' => 'our-event',
   
			'bg_img' => '0',

			'bg_img_custom' => '',

			'bg_position' => 'center',

			'bg_repeat' => 'no-repeat',

			'bg_attach' => 'fixed',

			'pattern_img' => '0',

			'custome_pattern' => '',

			'bg_color' => '#FFFFFF',
			
			'footer_widgetarea_bg_color' => '#141414',
			
			'footer_bg_color' => '#000',

			'logo' => get_template_directory_uri().'/images/logo.png',

			'logo_width' => '165',

			'logo_height' => '23',

			'header_sticky_menu' => 'on',
			
			'header_donation_button' => 'on',

			'fav_icon' => get_template_directory_uri() . '/images/favicon.png',

			'header_code' => '',
			
			'header_sticky_menu' => '',
			
			'header_support_button_title3' => 'make donations',
			'header_support_button_icon3' => 'fa-money',
			'header_support_button_text3' => 'Donate Now',
			'header_support_button_url3' => 'workforce-development',
			'header_support_button_text_heading3' => 'Donation via paypal from your visitors',
			
			'header_support_button_title1' => 'Join Our Movement',
			'header_support_button_icon1' => 'fa-flag',
			'header_support_button_text1' => 'Join Now',
			'header_support_button_url1' => '#',
			
			'header_support_button_title2' => 'Become Volunteer',
			'header_support_button_icon2' => 'fa-user',
			'header_support_button_text2' => 'Join Now',
			'header_support_button_url2' => '#',
			

			'copyright' =>  '&copy;'.gmdate("Y")." ".get_option("blogname")." Wordpress All rights reserved.", 

			'powered_by' => '<a href="#">Design by ChimpStudio</a>',


			'analytics' => '',

			'responsive' => 'on',

			'style_rtl' => '',
 
			// switchers

			'color_switcher' => '',

			'trans_switcher' => '',

			'post_title' => '',

  
			'sidebar' => array( 'Sidebar', 'footer-widget','shortcodes','shop'),

			// slider setting
			
			'show_slider' => 'on',

			'slider_name' => 'slider',

			'slider_type' => 'post_slider',

			'flex_effect' => 'fade',

			'flex_auto_play' => 'on',

			'flex_animation_speed' => '7000',

			'flex_pause_time' => '600',

			'slider_id' => '',

			'slider_view' => '',
			
			'cs_slider_blog_cat' => 'blog',
			
			'slider_no_posts' => '5',
			
			'show_slider_pagination' => 'on',

			'social_net_title' => '',

			'social_net_icon_path' => array( '', '', '', '', '', '', ),

			'social_net_awesome' => array( 'fa-facebook-square', 'fa-google-plus-square', 'fa fa-twitter-square', 'fa-youtube-square', 'fa-skype', 'fa-instagram', ' fa-foursquare' ),

			//'social_net_color_input' => array( '#005992', '#2a99e1', '#927f46', '#d70d38', '#ff0000', '#009bff;', '#2a99e1', '#2a99e1', ' #2a99e1' ),

			'social_net_url' => array( 'Facebook URL', 'Google-plus URL', 'Twitter URL', 'Youtube URL', 'Skype URL', 'Instagram URL', 'Foursquare URL' ),

			'social_net_tooltip' => array( 'Facebook', 'Google-plus', 'Twitter', 'Youtube', 'Skype', 'Instagram', 'Foursquare' ),

			'mailchimp_key' => '90f86a57314446ddbe87c57acc930ce8-us2',
			
			'paypal_email' => 'paypal@chimp.com',
			'paypal_ipn_url' => home_url().'/ipn-url/',
			'paypal_currency' => 'USD',
			'paypal_currency_sign' => '$',
			'paypal_payments' => '50,100,200,500,1000',

			// tranlations
			'trans_view_all' => 'View All',
			
			'trans_current' => 'Current Page',
			
			'trans_likes' => 'I am going',
			'trans_sortby' => 'Sort By',
						
			'cause_raised' => 'Raised',
			'cause_end_date' => 'End Date',
			'cause_goal' => 'Goal',
			'cause_donors' => 'Donors',
			'cause_donate' => 'Donate Now',
			'cause_donation' => 'Donation',
			'cause_status' => 'Closed',

		
			'res_first_name' => 'First Name',

			'res_last_name' => 'Last Name',

            'trans_subject' => 'Subject',

            'trans_message' => 'Message',

            'trans_share_this_post' => 'Share Now',

            'trans_content_404' => "It seems we can not find what you are looking for.",

			'trans_featured' => 'Featured',

			'trans_read_more' => 'read more',

			// translation end 

           	'pagination' => 'Show Pagination',
			'default_excerpt_length' => '255',
			'record_per_page' => '10',
			
			
			'default_pages_subheader' => 'on',
			
			'default_pages_subheader_style' => get_template_directory_uri().'/images/bg-map.png',
			
			'page_title' => 'Yes',
			'page_sub_title' => '',
			'page_subheader_color' => '#0e1f33',
			'header_banner_style' => 'breadcrumbs',
			'header_banner_image' => '',
			'header_banner_flex_slider' => '',
			'custom_slider_id' => '',
			
			'header_banner_style_default' => 'breadcrumbs',
			'header_banner_image_default' => '',
			'page_sub_title_default' => '',
			'page_subheader_color_default' => '#0e1f33',
			'header_banner_flex_slider_default' => '',
			'custom_slider_id_default' => '',
			

			'cs_layout' => 'none',

			'cs_sidebar_left' => '',

			'cs_sidebar_right' => '',

			'under-construction' => '',

			'showlogo' => 'on',

			'socialnetwork' => 'on',

			'under_construction_text' => '<h1 class="colr">OUR WEBSITE IS UNDERCONSTRUCTION</h1><p>We shall be here soon with a new website, Estimated Time Remaining</p>',

			'launch_date' => '2015-10-24',

 			'consumer_key' => 'BUVzW5ThLW8Nbmk9rSFag',
			'consumer_secret' => 'J8LDM3SOSNuP2JrESm8ZE82dv9NtZzer091ZjlWI',
			'access_token' => '1584785251-sTO1qbjZFwicbIe04fIByGifvfKIeewfOpSVsJq',
			'access_token_secret' => 'FpHZH50brTiiztx0G0LNp37c1rUjjwQ4rNHbEWjABw',
			'varto_sevices_title' => '',
			'varto_services_shortcode' => '',
		);

		/* Merge Heaser styles

		*/

		update_option("cs_theme_option", $args );
 		update_option("cs_theme_option_restore", $args );
 
	}






// Admin scripts enqueue

function cs_admin_scripts_enqueue() {

    $template_path = get_template_directory_uri() . '/scripts/admin/media_upload.js';

    wp_enqueue_script('my-upload', $template_path, array('jquery', 'media-upload', 'thickbox', 'jquery-ui-droppable', 'jquery-ui-datepicker', 'jquery-ui-slider', 'wp-color-picker'));

    wp_enqueue_script('custom_wp_admin_script', get_template_directory_uri() . '/scripts/admin/cs_functions.js');

    wp_enqueue_style('custom_wp_admin_style', get_template_directory_uri() . '/css/admin/admin-style.css', array('thickbox'));

	wp_enqueue_style('wp-color-picker');

}

// Backend functionality files



require_once (TEMPLATEPATH . '/include/event.php');

require_once (TEMPLATEPATH . '/include/cs_cause.php');

require_once (TEMPLATEPATH . '/include/team.php');

require_once (TEMPLATEPATH . '/include/slider.php');

require_once (TEMPLATEPATH . '/include/gallery.php');

require_once (TEMPLATEPATH . '/include/page_builder.php');

require_once (TEMPLATEPATH . '/include/post_meta.php');

require_once (TEMPLATEPATH . '/include/short_code.php');

require_once (TEMPLATEPATH . '/include/admin_functions.php');



require_once (TEMPLATEPATH . '/include/widgets.php');

require_once (TEMPLATEPATH . '/functions-theme.php');

require_once (TEMPLATEPATH . '/include/ical/iCalcreator.class.php');

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
		add_theme_page( "Import Demo Data" , "Import Demo Data" ,'read', 'cs_demo_importer' , 'cs_demo_importer');
	

	}

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

// enque style and scripts front end

function cs_front_scripts_enqueue() {

	global $cs_theme_option;

     if (!is_admin()) {

		wp_enqueue_style('style_css', get_stylesheet_directory_uri() . '/style.css');
		if ( function_exists( 'is_woocommerce' ) ){
			wp_enqueue_style('shp_css', get_template_directory_uri() . '/css/shop.css');
		}
		wp_enqueue_style('prettyPhoto_css', get_template_directory_uri() . '/css/prettyphoto.css');
  		if ( $cs_theme_option['color_switcher'] == "on" ) {

			wp_enqueue_style('color-switcher_css', get_template_directory_uri() . '/css/color-switcher.css');

		}

  		wp_enqueue_style('bootstrap_css', get_template_directory_uri() . '/css/bootstrap.css');

		wp_enqueue_style('font-awesome_css', get_template_directory_uri() . '/css/font-awesome.css');

 
		wp_enqueue_style('widget_css', get_template_directory_uri() . '/css/widget.css');
  
		// Register stylesheet

    	// Enqueue stylesheet

 
		   	wp_enqueue_style( 'wp-mediaelement' );

 		    wp_enqueue_script('jquery');

			wp_enqueue_script( 'wp-mediaelement' );

			wp_enqueue_script('bootstrap_js', get_template_directory_uri() . '/scripts/frontend/bootstrap.min.js', '', '', true);
			wp_enqueue_script('modernizr_js', get_template_directory_uri() . '/scripts/frontend/modernizr.js', '', '', true);
			wp_enqueue_script('prettyPhoto_js', get_template_directory_uri() . '/scripts/frontend/jquery.prettyphoto.js', '', '', true);
			
			wp_enqueue_script('countTo_js', get_template_directory_uri() . '/scripts/frontend/jquery.countTo.js', '', '', true);
			wp_enqueue_script('inview_js', get_template_directory_uri() . '/scripts/frontend/jquery.inview.min.js', '', '', true);
			
			wp_enqueue_script('functions_js', get_template_directory_uri() . '/scripts/frontend/functions.js', '0', '', true);
			
			if (isset($cs_theme_option['header_sticky_menu']) and $cs_theme_option['header_sticky_menu'] == "on"){
				wp_enqueue_script('bscrolltofixed_js', get_template_directory_uri() . '/scripts/frontend/jquery-scrolltofixed.js', '', '', true);
			}

 			if ( $cs_theme_option['style_rtl'] == "on"){

				wp_enqueue_style('rtl_css', get_template_directory_uri() . '/css/rtl.css');

 			}

			if 	($cs_theme_option['responsive'] == "on") {

				echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">';

				wp_enqueue_style('responsive_css', get_template_directory_uri() . '/css/responsive.css');

			}

     }

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

function cs_cycleslider_script(){
	wp_enqueue_script('jquerycycle2_js', get_template_directory_uri() . '/scripts/frontend/cycle2.js', '', '', true);
} 

// Flexslider Script and style enqueue

function cs_enqueue_countdown_script(){

   	wp_enqueue_script('jquery.countdown_js', get_template_directory_uri() . '/scripts/frontend/jquery.countdown.js', '', '', true);

}


function cs_enqueue_swiper_script(){

   	wp_enqueue_script('jquery.swiper_js', get_template_directory_uri() . '/scripts/frontend/idangerous.swiper-2.1.min.js', '', '', true);

}
// Masonry Style and Script enqueue

function cs_enqueue_masonry_style_script(){

	wp_enqueue_style('masonry_css', get_template_directory_uri() . '/css/masonry.css');

	wp_enqueue_script('jquery.masonry_js', get_template_directory_uri() . '/scripts/frontend/jquery.masonry.min.js', '', '', true);

}

function cs_addthis_script_init_method(){
		wp_enqueue_script( 'cs_addthis', 'http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e4412d954dccc64', '', '', true);
}

function cs_calender_enqueue_scripts(){
	wp_enqueue_style('fullcalendar_css', get_template_directory_uri() . '/css/fullcalendar.css');
	wp_enqueue_script('jquery.fullcalendar_js', get_template_directory_uri() . '/scripts/frontend/fullcalendar.min.js', '', '', true);
}



// Favicon and header code in head tag//

function cs_header_settings() {

    global $cs_theme_option;

    ?>

     <link rel="shortcut icon" href="<?php echo $cs_theme_option['fav_icon'] ?>" />

     <!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->

     

     <?php  

     echo  htmlspecialchars_decode($cs_theme_option['header_code']); 

}

// Favicon and header code in head tag//

function cs_footer_settings() {

    global $cs_theme_option;

    ?>

      <!--[if lt IE 9]><link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/ie8.css" /><![endif]-->

     <?php  
	if(isset($cs_theme_option['analytics'])){
     	echo htmlspecialchars_decode($cs_theme_option['analytics']);
	}

}

// Home page Slider //

function cs_get_home_slider(){

    global $cs_theme_option;

	if($cs_theme_option['show_slider'] =="on"){
?>
	
      <div id="banner">

           <?php 
            if(isset($cs_theme_option['slider_type']) and $cs_theme_option['slider_type'] == "flex"){
			
			 $width = 1600;
             $height = 610;
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
                                      cs_flex_slider($width,$height,$slider_id);
                      } else {
                              $slider_id = '';
                              echo '<div class="box-small no-results-found heading-color"> <h5>';
                                      _e("No results found.",'WeStand');
                              echo ' </h5></div>';
                      }
              }
			 
			 }else if(isset($cs_theme_option['slider_type']) and $cs_theme_option['slider_type'] == "post_slider" && $cs_theme_option['cs_slider_blog_cat']){
				 if(isset($cs_theme_option['cs_slider_blog_cat']) && $cs_theme_option['cs_slider_blog_cat'] <> ''){
					 $cs_slider_blog_cat = $cs_theme_option['cs_slider_blog_cat'];
					 if(isset($cs_theme_option['slider_no_posts']) && $cs_theme_option['slider_no_posts'] <> ''){$blog_no_posts = $cs_theme_option['slider_no_posts'];} else {$blog_no_posts = 5;}
					 cs_post_slider($cs_theme_option['cs_slider_blog_cat'],$blog_no_posts);
				 }
			}else if(isset($cs_theme_option['slider_type']) and $cs_theme_option['slider_type'] == "custom"){
				
            	echo do_shortcode(htmlspecialchars_decode($cs_theme_option['slider_id']));	
    		}

      		?>

      </div>

    <?php 


	}

}

// Page Sub header title and subtitle //

function get_subheader_title(){

	global $post, $wp_query, $cs_theme_option;

	$get_title = '';
	$header_banner_style  = '';
		if (is_page() || is_single()) {
				if (is_page() ){
				  $cs_xmlObject = cs_meta_page('cs_page_builder');
				  $header_banner_style = $cs_xmlObject->header_banner_style;
				  if (isset($cs_xmlObject)) {
					  $subtitle = $cs_xmlObject->page_sub_title;
				  }
					$get_title = '<h1 class="cs-page-title">' . substr(get_the_title(), 0, 40) . '</h1>';
                } elseif (is_single()) {
						$post_type = get_post_type($post->ID);
						 if ($post_type == "events") {
							 $post_type = "cs_event_meta";
						 }else if ($post_type == "cs_cause") {
							 $post_type = "cs_cause_meta";
						}else if ($post_type == "teams") {
							 $post_type = "cs_team";
						 }else {
							 $post_type = "post";
						 }
						 $post_xml = get_post_meta($post->ID, $post_type, true);
						 if ($post_xml <> "") {
						   $cs_xmlObject = new SimpleXMLElement($post_xml);
						 }
						$header_banner_style = $cs_xmlObject->header_banner_style;
					   if (isset($cs_xmlObject) && $cs_xmlObject->page_sub_title <> "") {
						  $subtitle = $cs_xmlObject->page_sub_title;
					   }
						$get_title = '<h1 class="cs-page-title">' . get_the_title() . '</h1>';
				}
				
				echo $get_title;
				
				if(isset($header_banner_style) && $header_banner_style == 'default_header'){
					if(isset($cs_theme_option['page_sub_title_default'])) 
				  		$subtitle  =   $cs_theme_option['page_sub_title_default'];
					if(isset($subtitle) && $subtitle <> ''){echo '<p>' . $subtitle . '</p>';}
					
				} else {
					if(isset($subtitle) && $subtitle <> ''){echo '<p>' . $subtitle . '</p>';}
				}
				
                
		  } else {
			if(isset($cs_theme_option['page_sub_title']) && $cs_theme_option['page_sub_title'] <> ''){$page_sub_title = $cs_theme_option['page_sub_title'];} else {$page_sub_title = '';}   
			   ?>
				<h1 class="cs-page-title"><?php cs_post_page_title();?></h1>
            <?php 
				if(isset($page_sub_title) && $page_sub_title <> ''){echo '<p>' . $page_sub_title . '</p>';}
 		  }

}

// character limit 

function cs_character_limit($string = '',$start_limit ='',$end_limit=''){

	return substr($string,$start_limit,$end_limit)."...";

	

}

// hide figure tag on post list page
if ( ! function_exists( 'fnc_post_type' ) ) {
	function fnc_post_type($post_view,$image_url = ''){
		$cs_post_cls = '';
		if ( $post_view <> "" ) {
			
			if($post_view=="Audio"){
				$cs_post_cls ='cls-post-audio';
				
			}elseif($post_view == "Video"){
	
				$cs_post_cls ='cls-post-video';
	
			}elseif($post_view == "Slider"){
	
				$cs_post_cls ='cls-post-slider';
	
			}elseif($image_url <> '' and $post_view == "Single Image"){
	
				$cs_post_cls ='cls-post-image';
	
			}else{
	
				$cs_post_cls ='cls-post-default cls-post-noimg  no-image';
	
			}
			
			if($image_url == ''){
				$cs_post_cls .= ' no-image';
			}
	
		}
	
		return $cs_post_cls;
	}
}
// Get post meta in xml format at front end //



// Front End Functions END

// post date/categories/tags
if ( ! function_exists( 'cs_posted_on' ) ) {
	function cs_posted_on(){
		?>
		<ul class="post-options">
			<li><i class="fa fa-calendar"></i><time datetime="<?php echo date('d-m-y',strtotime(get_the_date()));?>"><?php echo get_the_date();?></time></li>
			<li><i class="fa fa-user"></i><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"> <?php echo get_the_author(); ?></a></li>
			<?php
					/* translators: used between list items, there is a space after the comma */
					$before_cat = "<li><i class='fa fa-list'></i>".__( '','WeStand')."";
					$categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '</li>' );
					if ( $categories_list ){
						printf( __( '%1$s', 'WeStand'),$categories_list );
					}
					if ( comments_open() ) {  
						echo "<li>
						<i class='fa fa-comment'></i>"; comments_popup_link( __( '0 Comment', 'WeStand' ) , __( '1 Comment', 'WeStand' ), __( '% Comment', 'WeStand' ) ); 
					}
			?>
            <li>
            <?php
				edit_post_link( __( '<i class="fa fa-pencil-square-o"></i>Edit', 'WeStand'), '', '' ); 
			 ?></li>
		</ul>
	<?php
	}
}
/*------Header Functions End------*/
function cs_register_my_menus() {

  register_nav_menus(

	array(

		'main-menu'  => __('Main Menu','WeStand')

 	)

  );

}
// search varibales start

function cs_get_search_results($query) {

	if ( !is_admin() and (is_search())) {

		$query->set( 'post_type', array('post', 'events', 'cs_cause') );

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

				<h3>' . __( "This post is password protected. To view it please enter your password below:",'WeStand' ) . '</h3>';

		$o .= '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">

					<label><input name="post_password" id="' . $label . '" type="password" size="20" /></label>

					<input class="bgcolr" type="submit" name="Submit" value="'.__("Submit", "WeStand").'" />

				</form>

			</div>';

		return $o;

	}

}
// add menu id
function cs_add_menuid($ulid) {

	return preg_replace('/<ul>/', '<ul id="menus">', $ulid, 1);

}
// remove additional div from menu
function cs_remove_div ( $menu ){

    return preg_replace( array( '#^<div[^>]*>#', '#</div>$#' ), '', $menu );

}
// add parent class
function cs_add_parent_css($classes, $item) {

    global $cs_menu_children;

    if ($cs_menu_children)

        $classes[] = 'parent';

    return $classes;

}
// change the default query variable start

function cs_change_query_vars($query) {

    if (is_search() || is_home()) {

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

//////////////// Header Cart ///////////////////

add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

function woocommerce_header_add_to_cart_fragment( $fragments ) {

	if ( class_exists( 'woocommerce' ) ){

		global $woocommerce;

		ob_start();

		?>

		<div class="cart-sec">

			<a href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><i class="fa fa-shopping-cart"></i><span class="amount"><?php echo $woocommerce->cart->cart_contents_count; ?></span></a>

		</div>

		<?php

		$fragments['div.cart-sec'] = ob_get_clean();

		return $fragments;

	}

}
if ( ! function_exists( 'cs_woocommerce_header_cart' ) ) {
	function cs_woocommerce_header_cart() {

	if ( class_exists( 'woocommerce' ) ){

		global $woocommerce;

		?>

		<div class="cart-sec">

			<a href="<?php echo $woocommerce->cart->get_cart_url(); ?>">
            <i class="fa fa-shopping-cart"></i><span class="amount"><?php echo $woocommerce->cart->cart_contents_count; ?></span></a>

		</div>

		<?php

		}
	}
}

//////////////// Header Cart Ends ///////////////////

//	Add Featured/sticky text/icon for sticky posts.

if ( ! function_exists( 'cs_featured' ) ) {

	function cs_featured(){

		global $cs_transwitch,$cs_theme_option;

		if ( is_sticky() ){ ?>

		<li class="featured"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Featured','WeStand');}else{ echo $cs_theme_option['trans_featured']; } ?></li>
        <?php

		}

	}

}
// custom function start


// display post page title
if ( ! function_exists( 'cs_post_page_title' ) ) {
	function cs_post_page_title(){
	
		if ( is_author() ) {
	
			global $author;
	
			$userdata = get_userdata($author);
	
			echo __('Author', 'WeStand') . " " . __('Archives', 'WeStand') . ": ".$userdata->display_name;
	
		}elseif ( is_tag() || is_tax('event-tag') || is_tax('cs_cause-tag') ) {
	
			echo __('Tags', 'WeStand') . " " . __('Archives', 'WeStand') . ": " . single_cat_title( '', false );
	
		}elseif ( is_category() || is_tax('event-category') || is_tax('cs_cause-category') ) {
	
			echo __('Categories', 'WeStand') . " " . __('Archives', 'WeStand') . ": " . single_cat_title( '', false );
	
		}elseif( is_search()){
	
			printf( __( 'Search Results %1$s %2$s', 'WeStand' ), ': ','<span>' . get_search_query() . '</span>' ); 
	
		}elseif ( is_day() ) {
	
			printf( __( 'Daily Archives: %s', 'WeStand' ), '<span>' . get_the_date() . '</span>' );
	
		}elseif ( is_month() ) {
	
			printf( __( 'Monthly Archives: %s', 'WeStand' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'WeStand' ) ) . '</span>' );
	
		}elseif ( is_year() ) {
	
			printf( __( 'Yearly Archives: %s', 'WeStand' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'WeStand' ) ) . '</span>' );
	
		}elseif ( is_404()){
	
			_e( 'Error 404', 'WeStand' );
	
		}elseif(!is_page()){
	
			_e( 'Archives', 'WeStand' );
	
		}
	}
}



// Dropcap shortchode with first letter in caps

if ( ! function_exists( 'cs_dropcap_page' ) ) {

	function cs_dropcap_page(){

		global $cs_node;

		$class = $cs_node->dropcap_class;

		$html = '<div class="element_size_'.$cs_node->dropcap_element_size.'">';

			$html .= '<div class="'.$class.'">';

				$html .= $cs_node->dropcap_content;

			$html .= '</div>';

		$html .= '</div>';

		return $html;

	}

}



// block quote short code

if ( ! function_exists( 'cs_quote_page' ) ) {

	function cs_quote_page(){

		global $cs_node;

		$html = '<div class="element_size_'.$cs_node->quote_element_size.'">';

			$html .= '<blockquote style=" text-align:' .$cs_node->quote_align. '; color:' . $cs_node->quote_text_color . '"><span>' . $cs_node->quote_content . '</span></blockquote>';

		$html .= '</div>';

		return $html . '<div class="clear"></div>';

	}

}
// map shortcode with various options

if ( ! function_exists( 'cs_map_page' ) ) {

	function cs_map_page(){

		global $cs_node, $cs_counter_node;

		if ( !isset($cs_node->map_lat) or $cs_node->map_lat == "" ) { $cs_node->map_lat = 0; }

		if ( !isset($cs_node->map_lon) or $cs_node->map_lon == "" ) { $cs_node->map_lon = 0; }

		if ( !isset($cs_node->map_zoom) or $cs_node->map_zoom == "" ) { $cs_node->map_zoom = 11; }

		if ( !isset($cs_node->map_info_width) or $cs_node->map_info_width == "" ) { $cs_node->map_info_width = 200; }

		if ( !isset($cs_node->map_info_height) or $cs_node->map_info_height == "" ) { $cs_node->map_info_height = 100; }

		if ( !isset($cs_node->map_show_marker) or $cs_node->map_show_marker == "" ) { $cs_node->map_show_marker = 'true'; }

		if ( !isset($cs_node->map_controls) or $cs_node->map_controls == "" ) { $cs_node->map_controls = 'false'; }

		if ( !isset($cs_node->map_scrollwheel) or $cs_node->map_scrollwheel == "" ) { $cs_node->map_scrollwheel = 'true'; }

		if ( !isset($cs_node->map_draggable) or $cs_node->map_draggable == "" )  { $cs_node->map_draggable = 'true'; }

		if ( !isset($cs_node->map_type) or $cs_node->map_type == "" ) { $cs_node->map_type = 'ROADMAP'; }

		if ( !isset($cs_node->map_info)) { $cs_node->map_info = ''; }

		if( !isset($cs_node->map_marker_icon)){ $cs_node->map_marker_icon = ''; }

		if( !isset($cs_node->map_title)){ $cs_node->map_title ='';}

		if( !isset($cs_node->map_element_size)){ $cs_node->map_element_size ='default';}

		if( !isset($cs_node->map_height)){ $cs_node->map_height ='180';}

		if ( !isset($cs_node->map_view)) { $cs_node->map_view = ''; }

		if ( !isset($cs_node->map_conactus_content)) { $cs_node->map_conactus_content = ''; }

		$map_show_marker = '';

		if ( $cs_node->map_show_marker == "true" ) { 

			$map_show_marker = " var marker = new google.maps.Marker({

						position: myLatlng,

						map: map,

						title: '',

						icon: '".$cs_node->map_marker_icon."',

						shadow:''

					});

			";

		}

	

		//wp_enqueue_script('googleapis', 'https://maps.googleapis.com/maps/api/js?sensor=true', '', '', true);

		$html = '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>';

		$html .= '<div class="element_size_'.$cs_node->map_element_size. ' cs-map-'.$cs_counter_node.'">';

		$html .= '<div class="mapcode iframe mapsection gmapwrapp" id="map_canvas'.$cs_counter_node.'" style="height:'.$cs_node->map_height.'px;"> </div>';

		$html .= '</div>';

		

		$html .= "<script type='text/javascript'>
					jQuery(window).load(function(){
						setTimeout(function(){
						jQuery('.cs-map-".$cs_counter_node."').animate({
							'height':'".$cs_node->map_height."'
						},400)
						},400)
					})
					function initialize() {

						var myLatlng = new google.maps.LatLng(".$cs_node->map_lat.", ".$cs_node->map_lon.");

						var mapOptions = {

							zoom: ".$cs_node->map_zoom.",

							scrollwheel: ".$cs_node->map_scrollwheel.",

							draggable: ".$cs_node->map_draggable.",

							center: myLatlng,

							mapTypeId: google.maps.MapTypeId.".$cs_node->map_type." ,

							disableDefaultUI: ".$cs_node->map_controls.",

						}

						var map = new google.maps.Map(document.getElementById('map_canvas".$cs_counter_node."'), mapOptions);

						var infowindow = new google.maps.InfoWindow({

							content: '".$cs_node->map_info."',

							maxWidth: ".$cs_node->map_info_width.",

							maxHeight:".$cs_node->map_info_height.",

						});

						".$map_show_marker."

						//google.maps.event.addListener(marker, 'click', function() {

	

							if (infowindow.content != ''){

							  infowindow.open(map, marker);

							   map.panBy(1,-60);

							   google.maps.event.addListener(marker, 'click', function(event) {

								infowindow.open(map, marker);

	

							   });

							}

						//});

					}

				

				google.maps.event.addDomListener(window, 'load', initialize);

				</script>";

		return $html;

	}

}
// If no content, include the "No posts found" function
if ( ! function_exists( 'fnc_no_result_found' ) ) {
	function fnc_no_result_found($search = true){
		
		?>
        <div class="pagenone cls-noresult-found">
            <i class="fa fa-warning colr"></i>
            <h5><?php _e( 'No results found.', 'WeStand'); ?></h5>
            <?php if($search == true){?>
                <div class="password_protected">
                    <?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
                    
                    <p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'twentyfourteen' ), admin_url( 'post-new.php' ) ); ?></p>
                    
                    <?php elseif ( is_search() ) : ?>
                    
                    <p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'twentyfourteen' ); ?></p>
                    <?php get_search_form(); ?>
                    
                    <?php else : ?>
                         <p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'twentyfourteen' ); ?></p>
                    <?php get_search_form(); ?>
                     
                    <?php endif; ?> 
               </div>
             <?php }?>
        </div>

	<?php
	}
}
function wps_highlight_results($text){
     if(is_search()){
     $sr = get_query_var('s');
     $keys = explode(" ",$sr);
     $text = preg_replace('/('.implode('|', $keys) .')/iu', '<strong class="">'.$sr.'</strong>', $text);
     }
     return $text;
}
add_filter('get_the_excerpt', 'wps_highlight_results');
//add_filter('the_title', 'wps_highlight_results');
// Paypal Button

function cs_donate_button($cause_paypal_email = ''){

	global $post, $cs_theme_option;
	
	if(isset($cause_paypal_email) && $cause_paypal_email <> ''){
		$cs_cause_paypal_email = $cause_paypal_email;
	} else {
		$cs_cause_paypal_email = $cs_theme_option['paypal_email'];
	}
	$cause_id = '';
	$post_type = get_post_type($post->ID);
	if($post_type == 'cs_cause'){
		$cause_id = $post->ID;
	}
	if($cs_theme_option['trans_switcher'] == "on"){ $cause_donate = __('Donate Now','WeStand');}else{ $cause_donate = $cs_theme_option['cause_donate']; }
	?>
        <div class="modal fade cs-donation-form" id="CausemyModal2<?php echo $cause_id;?>" tabindex="-1" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times-circle"></i> </button>
                    <i class="fa fa-money"></i>
                    <h2><?php echo $cause_donate;?></h2>
                </div>
                <div class="modal-body">
                    <h4><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Donation via paypal from your visitors','WeStand');}else{ echo $cs_theme_option['header_support_button_text_heading3']; }?></h4>
                    <ul>
                       <?php 
						if(isset($cs_theme_option['paypal_payments']) && $cs_theme_option['paypal_payments'] <> ''){
							$paypal_payments = $cs_theme_option['paypal_payments'];
							$paypal_payments = explode(',',$cs_theme_option['paypal_payments']);
						} else {
							$paypal_payments = array('50','100','200','500','1000');
						}
							foreach($paypal_payments as $paypal_payments_value){
						?>
                        	<li><label class="cs-bgcolrhvr"><?php echo $cs_theme_option['paypal_currency_sign'].$paypal_payments_value;?> <input type="radio" name="donate" value="<?php echo trim($paypal_payments_value);?>"></label></li>
                         <?php }?>
                    </ul>
                    <script>
                    jQuery(document).ready(function($) {
                        jQuery(".cs-donation-form ul li label") .click(function(event) {
                            /* Act on the event */
                            var a = jQuery(this).text().substring(1);
                              jQuery(".cs-donation-form .modal-footer label .cause-amount") .val(a)
                             jQuery(".cs-donation-form ul li label").removeClass("cs-active");
                             jQuery(this).addClass('cs-active');
                             return false;
                        });
                    });
                    </script>
                    <div class="other-options">
                        <span class="opt-or">or</span>
                    </div>
                </div>
                <div class="modal-footer">
                	<?php 
                		
						$paypal_content_button = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">  

							<input type="hidden" name="cmd" value="_xclick">  
					
							<input type="hidden" name="business" value="'.$cs_cause_paypal_email.'">
					
							<label><span>'.$cs_theme_option['paypal_currency_sign'].'</span><input type="text" class="cause-amount" type="text" name="amount"></label> 
					
							<input type="hidden" name="item_name" value="'.get_the_title().'"> 
					
							<input type="hidden" name="no_shipping" value="2">
					
							<input type="hidden" name="item_number" value="'.$post->ID.'">  
					
							<input name = "cancel_return" value = "'.get_permalink($post->ID).'" type = "hidden">  
					
							<input type="hidden" name="no_note" value="1">  
					
							<input type="hidden" name="currency_code" value="'.$cs_theme_option['paypal_currency'].'">  
					
							<input type="hidden" name="notify_url" value="'.$cs_theme_option['paypal_ipn_url'].'">
					
							<input type="hidden" name="lc" value="AU">  
					
							<input type="hidden" name="return" value="'.get_permalink($post->ID).'">  
					
							<span class="donate-btn btn"><input class="bgcolr" type="submit" value="'.$cause_donate.'"> </span>
					
						</form> ';
					
						echo $paypal_content_button;
                

                
                	?>
                          
                </div>
            </div>
          </div>
    </div>
<?php

}


function cs_custom_donate_button($cause_paypal_email = ''){

	global $post, $cs_theme_option;
	
	if(isset($cause_paypal_email) && $cause_paypal_email <> ''){
		$cs_cause_paypal_email = $cause_paypal_email;
	} else {
		$cs_cause_paypal_email = $cs_theme_option['paypal_email'];
	}
	
	if($cs_theme_option['trans_switcher'] == "on"){ $cause_donate = __('Donate Now','WeStand');}else{ $cause_donate = $cs_theme_option['cause_donate']; }
	?>
        <div class="modal fade cs-donation-form" id="myModal2" tabindex="-1" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times-circle"></i></button>
                    <i class="fa fa-money"></i>
                    <h2><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Make Donations','WeStand');}else{ echo $cs_theme_option['cause_donation']; } ?></h2>
                </div>
                <div class="modal-body">
                    <h4><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Donation via paypal from your visitors','WeStand');}else{ echo $cs_theme_option['header_support_button_text_heading3']; }?></h4>
                    <ul>
                    	<?php 
						if(isset($cs_theme_option['paypal_payments']) && $cs_theme_option['paypal_payments'] <> ''){
							$paypal_payments = $cs_theme_option['paypal_payments'];
							$paypal_payments = explode(',',$cs_theme_option['paypal_payments']);
						} else {
							//$paypal_payments = array('50','100','200','500','1000');
							$paypal_payments = array();
							
						}
							foreach($paypal_payments as $paypal_payments_value){
						?>
                        	<li><label class="cs-bgcolrhvr"><?php echo $cs_theme_option['paypal_currency_sign'].$paypal_payments_value;?> <input type="radio" name="donate" value="<?php echo trim($paypal_payments_value);?>"></label></li>
                         <?php }?>
                     
                    </ul>
                    <script>
                    jQuery(document).ready(function($) {
                        jQuery(".cs-donation-form ul li label") .click(function(event) {
                            /* Act on the event */
                            var a = jQuery(this).text().substring(1);
                              jQuery(".cs-donation-form .modal-footer label .cause-amount") .val(a)
                             jQuery(".cs-donation-form ul li label").removeClass("cs-active");
                             jQuery(this).addClass('cs-active');
                             return false;
                        });
                    });
                    </script>
                    <div class="other-options">
                        <span class="opt-or">or</span>
                    </div>
                </div>
                <div class="modal-footer">
                	<?php 
                		
						$paypal_content_button = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">  

							<input type="hidden" name="cmd" value="_xclick">  
					
							<input type="hidden" name="business" value="'.$cs_cause_paypal_email.'">
					
							<label><span>'.$cs_theme_option['paypal_currency_sign'].'</span><input type="text" class="cause-amount" name="amount"></label> 
					
							<input type="hidden" name="item_name" value="'.get_the_title().'"> 
					
							<input type="hidden" name="no_shipping" value="2">
					
							<input type="hidden" name="item_number" value="'.$post->ID.'">  
					
							<input name = "cancel_return" value = "'.get_permalink($post->ID).'" type = "hidden">  
					
							<input type="hidden" name="no_note" value="1">  
					
							<input type="hidden" name="currency_code" value="'.$cs_theme_option['paypal_currency'].'">  
					
							<input type="hidden" name="notify_url" value="'.$cs_theme_option['paypal_ipn_url'].'">
					
							<input type="hidden" name="lc" value="AU">  
					
							<input type="hidden" name="return" value="'.get_permalink($post->ID).'">  
					
							<span class="donate-btn btn"><input class="bgcolr" type="submit" value="'.$cause_donate.'"> </span>
					
						</form> ';
					
						echo $paypal_content_button;
                
                
                	?>
                          
                </div>
            </div>
          </div>
    </div>
<?php

}

function cs_add_transaction_detail(){

	if ( isset($_POST['item_number']) && isset($_POST['txn_id']) ) {

		$trnx_exit =0;

		$item_number = $_POST['item_number'];

		$cs_cause = get_post_meta($item_number, "cs_cause_transaction", true);

			//global $cs_xmlObject;

			$sxe = new SimpleXMLElement("<cause></cause>");

			$cs_counter = 0;

			if ( isset($_POST['txn_id']) ) {

				if ( $cs_cause <> "" ) {

				$cs_xmlObject = new SimpleXMLElement($cs_cause);

			}

				if(isset($cs_xmlObject->transaction) && count($cs_xmlObject->transaction)>0){

					foreach ( $cs_xmlObject->transaction as $trans ){

						$track = $sxe->addChild('transaction');

						if($trans->txn_id == $_POST['txn_id']){

							$trnx_exit =1;

						}

						$track->addChild('txn_id', $trans->txn_id );

						$track->addChild('item_number', $trans->item_number );

						$track->addChild('payer_id', $trans->payer_id );

						$track->addChild('payment_date', $trans->payment_date );

						$track->addChild('payer_email', $trans->payer_email );

						$track->addChild('payment_gross', $trans->payment_gross );

						$track->addChild('address_name', $trans->address_name  );

					}

				}

				if($trnx_exit <> '1'){

					$track = $sxe->addChild('transaction');

					$track->addChild('txn_id', htmlspecialchars($_POST['txn_id']) );

					$track->addChild('item_number', htmlspecialchars($_POST['item_number']) );

					$track->addChild('payer_id', htmlspecialchars($_POST['payer_id']) );

					$track->addChild('item_number', htmlspecialchars($_POST['item_number']) );

					$track->addChild('payment_date', htmlspecialchars($_POST['payment_date']) );

					$track->addChild('payer_email', htmlspecialchars($_POST['payer_email']) );

					$track->addChild('payment_gross', htmlspecialchars($_POST['payment_gross']) );

					$track->addChild('address_name', htmlspecialchars($_POST['address_name']) );

				}

			



			}

			update_post_meta($item_number, 'cs_cause_transaction', $sxe->asXML());

	}

}


function cs_paypal_ipn(){

	if($_REQUEST['ipn_request'] == 'true'){
	
			// read the post from PayPal system and add 'cmd'
	
			$req = 'cmd=_notify-validate';
	
			foreach ($_POST as $key => $value) {
	
				$value = urlencode(stripslashes($value));
		
				$req .= "&$key=$value";
	
			}
	
			update_post_meta($_POST['item_number'], 'cs_cause_transaction_txn', $_POST['txn_id']);
	
			// post back to PayPal system to validate
	
			$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
	
			$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	
			$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
	
			$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
	
			
	
			// assign posted variables to local variables
	
			$item_name = $_POST['item_name'];
	
			$item_number = $_POST['item_number'];
	
			$payment_status = $_POST['payment_status'];
	
			$payment_amount = $_POST['mc_gross'];
	
			$payment_currency = $_POST['mc_currency'];
	
			$txn_id = $_POST['txn_id'];
	
			$receiver_email = $_POST['receiver_email'];
	
			$payer_email = $_POST['payer_email'];
	
			
	
			if (!$fp) {
	
			// HTTP ERROR
	
			} else {
	
			fputs ($fp, $header . $req);
	
			while (!feof($fp)) {
	
			$res = fgets ($fp, 1024);
	
			if (strcmp ($res, "VERIFIED") == 0) {
	
				$trnx_exit =0;
	
					$item_number = $_POST['item_number'];
	
					$cs_cause = get_post_meta($item_number, "cs_cause_transaction_ipn", true);
	
						//global $cs_xmlObject;
	
						$sxe = new SimpleXMLElement("<cause></cause>");
	
						$cs_counter = 0;
	
						if ( isset($_POST['txn_id']) ) {
	
							if ( $cs_cause <> "" ) {
	
							$cs_xmlObject = new SimpleXMLElement($cs_cause);
	
						}
	
							if(isset($cs_xmlObject->transaction) && count($cs_xmlObject->transaction)>0){
	
								foreach ( $cs_xmlObject->transaction as $trans ){
	
									$track = $sxe->addChild('transaction');
	
									if($trans->txn_id == $_POST['txn_id']){
	
										$trnx_exit =1;
	
									}
	
									$track->addChild('txn_id', $trans->txn_id );
	
									$track->addChild('item_number', $trans->item_number );
	
									$track->addChild('payer_id', $trans->payer_id );
	
									$track->addChild('payment_date', $trans->payment_date );
	
									$track->addChild('payer_email', $trans->payer_email );
	
									$track->addChild('payment_gross', $trans->payment_gross );
	
									$track->addChild('address_name', $trans->address_name  );
	
								}
	
							}
	
							if($trnx_exit <> '1'){
	
								$track = $sxe->addChild('transaction');
	
								$track->addChild('txn_id', htmlspecialchars($_POST['txn_id']) );
	
								$track->addChild('item_number', htmlspecialchars($_POST['item_number']) );
	
								$track->addChild('payer_id', htmlspecialchars($_POST['payer_id']) );
	
								$track->addChild('item_number', htmlspecialchars($_POST['item_number']) );
	
								$track->addChild('payment_date', htmlspecialchars($_POST['payment_date']) );
	
								$track->addChild('payer_email', htmlspecialchars($_POST['payer_email']) );
	
								$track->addChild('payment_gross', htmlspecialchars($_POST['payment_gross']) );
	
								$track->addChild('address_name', htmlspecialchars($_POST['address_name']) );
	
							}
	
						
	
			
	
						}
	
						update_post_meta($_POST['item_number'], 'cs_cause_transaction_ipn', $sxe->asXML());
	
				
	
				
	
					// check the payment_status is Completed
	
					// check that txn_id has not been previously processed
	
					// check that receiver_email is your Primary PayPal email
	
					// check that payment_amount/payment_currency are correct
	
					// process payment
	
					}
	
					else if (strcmp ($res, "INVALID") == 0) {
	
					// log for manual investigation
	
					}
	
					}
	
					fclose ($fp);
	
					}
	
		}

}

// Custom function for next previous posts
 function px_next_prev_custom_links($post_type = 'events'){
	 	global $post;
		$previd = $nextid = '';
		
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
		echo '<div class="prevnext-post">';
		if (isset($previd) &&  !empty($previd) && $previd >=0 ) {
		   ?>
		   <a href="<?php echo get_permalink($previd); ?>"><i class="fa fa-chevron-left"></i></a>
            
            <?php
		}
		
		if (isset($nextid) &&   !empty($nextid) ) {
			?>
            <a href="<?php echo get_permalink($nextid); ?>"><i class="fa fa-chevron-right"></i></a>
            
            <?php	
		}
		echo '</div>';
	 wp_reset_query();
 }

// 
function cs_indent($text,$n){ 
    if(is_string($text) && is_int($n)){ 
        $indent = ""; 
        $i = 0; 
        while($i < $n){ 
            $i++; 
            $indent.= "\t"; 
        } 
        return str_replace("\n", "\n".$indent, str_replace(array("\r\n","\r"), "\n", $text)); 
    } 
} 

// Calendar time
function calender_time($event_time) {

	//$event_time = str_replace(':', '', $event_time).'00';

	  $event_time = str_replace('am', '', $event_time);

	  $event_time = str_replace('pm', '', $event_time);

	  if(strlen($event_time)<6){

		  $event_time = '0'.$event_time;

	  }

   return $event_time; // Removes special chars.

}

function get_formated_date($date)

{

	return mysql2date(get_option('date_format'), $date);

}

function get_formated_time($time)

{

	return mysql2date(get_option('time_format'), $time, $translate=true);;

}

// Calendar

function add_to_calender()

{	global $post;

	$cs_theme_option = get_option('cs_theme_option');

	$calendar_args=array('outlook'=>1,'google_calender'=>1,'yahoo_calender'=>1,'ical_cal'=>1);

	if($calendar_args)

	{

		$calendar_url = cs_event_calendar($post->ID);

			?>

    <div class="add-calender"><a class="bgcolrhvr add_calendar_toggle<?php echo $post->ID;?> btn-toggle_cal" href="#inline-<?php echo $post->ID;?>"> <em class="fa fa-calendar"></em> add</a>

      <ul class="add_calendar add_calendar<?php echo $post->ID;?>" id="inline-<?php echo $post->ID;?>" >

        <?php if($calendar_args['outlook']){?>

        <li class="i_calendar">

        <a href="<?php echo $calendar_url['ical']; ?>"> 

          <img src="<?php echo get_template_directory_uri(); ?>/images/calendar-icon.png" alt="" width="24" />

        </a> 

        </li>

        <?php }?>

        <?php if($calendar_args['google_calender']){?>

        <li class="i_google"><a href="<?php echo $calendar_url['google']; ?>" target="_blank"> 

          <img src="<?php echo get_template_directory_uri(); ?>/images/google-icon.png" alt="" width="25" />

        </a> 

        </li>

        <?php }?>

        <?php if($calendar_args['yahoo_calender']){?>

        <li class="i_yahoo"><a href="<?php echo $calendar_url['yahoo']; ?>" target="_blank">

          <img src="<?php echo get_template_directory_uri(); ?>/images/yahoo-icon.png" alt="" width="24" />

        </a> 

        </li>

        <?php }?>

      </ul>

    </div>

<?php

	}

}



/*	Function to get the events info on calander -- START	*/

function cs_event_calendar($post_id = '') {

	

	if(!isset($post_id) && $post_id == ''){

		global $post;

		$post_id = $post->ID;

	}

	$cal_post = get_post($post_id);

	if ($cal_post) {

		$event_from_date = get_post_meta($post_id, "cs_event_from_date", true);

		$cs_event_to_date = get_post_meta($post_id, "cs_event_to_date", true);

		$cs_event_meta = get_post_meta($post_id, "cs_event_meta", true);

			if ( $cs_event_meta <> "" ) {

				$cs_event_meta = new SimpleXMLElement($cs_event_meta);

				if($cs_event_meta->event_address <> ''){

					$address_map = get_the_title("$cs_event_meta->event_address");	

				}else{

					$address_map = '';

				}

			}

			$cs_event_loc = get_post_meta($cs_event_meta->event_address, "cs_event_loc_meta", true);

			if ( $cs_event_loc <> "" ) {

				$cs_xmlObject = new SimpleXMLElement($cs_event_loc);

				$loc_address = $cs_xmlObject->loc_address;

				$event_loc_lat = $cs_xmlObject->event_loc_lat;

				$event_loc_long = $cs_xmlObject->event_loc_long;

				$event_loc_zoom = $cs_xmlObject->event_loc_zoom;

				$loc_city = $cs_xmlObject->loc_city;

				$loc_postcode = $cs_xmlObject->loc_postcode;

				$loc_country = $cs_xmlObject->loc_country;

				$location = $loc_address.', '.$loc_city.', '.$loc_postcode.', '.$loc_country;

			}

			else {

				$loc_address = '';

				$event_loc_lat = '';

				$event_loc_long = '';

				$event_loc_zoom = '';

				$loc_city = '';

				$loc_postcode = '';

				$loc_country = '';

				$location = '';

			}

			

		

		$start_year = date('Y',strtotime($event_from_date));

		$start_month = date('m',strtotime($event_from_date));

		$start_day = date('d',strtotime($event_from_date));

		

		$end_year = date('Y',strtotime($cs_event_to_date));

		$end_month = date('m',strtotime($cs_event_to_date));

		$end_day = date('d',strtotime($cs_event_to_date));

		if ( $cs_event_meta->event_all_day != "on" ) {

			$start_time = calender_time($cs_event_meta->event_start_time);

			$end_time = calender_time($cs_event_meta->event_end_time);

		} else {

			$start_time = $end_time = '';

		}

		if (($start_time != '') && ($start_time != ':')) { $event_start_time = explode(":",$start_time); }

		if (($end_time != '') && ($end_time != ':')) { $event_end_time = explode(":",$end_time); }

		

		$post_title = get_the_title($post_id);

		$cs_vcalendar = new vcalendar();                          

		$cs_vevent = new vevent();  

		$site_info = get_bloginfo('name').'Events';

		$cs_vevent->setProperty( 'categories' , $site_info );                   

		

		if (isset( $event_start_time)) { @$cs_vevent->setProperty( 'dtstart' 	,  @$start_year, @$start_month, @$start_day, @$event_start_time[0], @$event_start_time[1], 00 ); } else { $cs_vevent->setProperty( 'dtstart' ,  $start_year, $start_month, $start_day ); } // YY MM dd hh mm ss

		if (isset($event_end_time)) { @$cs_vevent->setProperty( 'dtend'   	,  $end_year, $end_month, $end_day, $event_end_time[0], $event_end_time[1], 00 );  } else { $cs_vevent->setProperty( 'dtend' , $end_year, $end_month, $end_day );  } // YY MM dd hh mm ss

		$cs_vevent->setProperty( 'description' 	, strip_tags($cal_post->post_excerpt)); 

		if (isset($location)) { $cs_vevent->setProperty( 'location'	, $location ); } 

		$cs_vevent->setProperty( 'summary'	, $post_title );                 

		$cs_vcalendar->addComponent( $cs_vevent );                        

		$templateurl = get_template_directory_uri().'/cache/';

		//makeDir(get_bloginfo('template_directory').'/cache/');

		$home = home_url();

		$dir = str_replace($home,'',$templateurl);

		$dir = str_replace('/wp-content/','wp-content/',$dir);
		
		
		$directory_url =  get_template_directory_uri();
		$directorypath = explode('/', $directory_url);
		$themefolderName = $directorypath[count($directorypath)-1];

		$cs_vcalendar->setConfig( 'directory', ABSPATH .'wp-content/themes/'.$themefolderName.'/cache' ); 

		$cs_vcalendar->setConfig( 'filename', 'event-'.$post_id.'.ics' ); 

		$cs_vcalendar->saveCalendar(); 

		////OUT LOOK & iCAL URL//

		$output_calendar_url['ical'] = $templateurl.'event-'.$post_id.'.ics';

		////GOOGLE URL//

		$google_url = "http://www.google.com/calendar/event?action=TEMPLATE";

		$google_url .= "&text=".urlencode($post_title);

		if (isset($event_start_time) && isset($event_end_time)) { 

			$google_url .= "&dates=".@$start_year.@$start_month.@$start_day."T".str_replace('.','',@$event_start_time[0]).str_replace('.','',@$event_start_time[1])."00/".@$end_year.@$end_month.@$end_day."T".str_replace('.','',@$event_end_time[0]).str_replace('.','',@$event_end_time[1])."00"; 



		} else { 

			$google_url .= "&dates=".$start_year.$start_month.$start_day."/".$end_year.$end_month.$end_day; 

		}

		$google_url .= "&sprop=website:".get_permalink($post_id);

		$google_url .= "&details=".strip_tags($cal_post->post_excerpt);

		if (isset($location)) { $google_url .= "&location=".$location; } else { $google_url .= "&location=Unknown"; }

		$google_url .= "&trp=true";

		$output_calendar_url['google'] = $google_url;

		////YAHOO CALENDAR URL///

		$yahoo_url = "http://calendar.yahoo.com/?v=60&view=d&type=20";

		$yahoo_url .= "&title=".str_replace(' ','+',$post_title);

		if (isset($event_start_time)) 

		{ 

			$yahoo_url .= "&st=".@$start_year.@$start_month.@$start_day."T".@$event_start_time[0].@$event_start_time[1]."00"; 

		}

		else

		{ 

			$yahoo_url .= "&st=".$start_year.$start_month.$start_day;

		}

		if(isset($event_end_time))

		{

			//$yahoo_url .= "&dur=".$event_start_time[0].$event_start_time[1];

		}

		$yahoo_url .= "&desc=".str_replace(' ','+',strip_tags($cal_post->post_excerpt)).' -- '.get_permalink($post_id);

		$yahoo_url .= "&in_loc=".str_replace(' ','+',$location);

		$output_calendar_url['yahoo'] = $yahoo_url;

	}

	return $output_calendar_url;

} 

add_action('get_header', 'my_filter_head');

  function my_filter_head() {
    remove_action('wp_head', '_admin_bar_bump_cb');
  }

