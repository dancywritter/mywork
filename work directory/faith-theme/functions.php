<?php
add_action( 'after_setup_theme', 'cs_theme_setup' );
function cs_theme_setup() {

	/* Add theme-supported features. */
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();
	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
 	load_theme_textdomain('Faith', get_template_directory() . '/languages');
	
	if (!isset($content_width)){
		$content_width = 1130;
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

	if (is_admin() && isset($_GET['activated']) && $pagenow == 'themes.php'){
 		if(!get_option('cs_theme_option')){
			add_action('admin_head', 'cs_activate_widget');
			add_action('init', 'cs_activation_data');
		}
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
 	add_filter('the_password_form', 'cs_password_form' );
	add_filter('wp_page_menu','cs_add_menuid');
	add_filter('wp_page_menu', 'cs_remove_div' );
	add_filter('nav_menu_css_class', 'cs_add_parent_css', 10, 2);
	add_filter('pre_get_posts', 'cs_change_query_vars');
}
// adding custom images while uploading media start
add_image_size('cs_media_1', 1060, 418, true);
add_image_size('cs_media_2', 1058, 364, true);
add_image_size('cs_media_3', 786, 418, true);
add_image_size('cs_media_4', 530, 398, true);
add_image_size('cs_media_5', 330, 248, true);
add_image_size('cs_media_6', 325, 183, true);
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
    	<div class="cs-single-post-pagination">
 			<?php 
				if( $previous){
 				?>
					<div class="post-prev">
						 
                        <div class="text">
							<?php previous_post_link( '%link', '<span>Previous Post</span> <p>%title</p>',true ); ?>
                        </div>
					</div>
                    <?php
				}
				if($next){
 			 	?>
             	<div class="post-next">
                     <div class="text">
                        <?php next_post_link( '%link','<span>Next Post</span> <p>%title</p>',true ); ?>
                    </div>
                </div>
              <?php }?>          
		</div>
	<?php
	}
}
 // next prev post link
 if ( ! function_exists( 'cs_next_prev_custom_links' ) ) { 
	 function cs_next_prev_custom_links($post_type = ''){
			global $post;
			$previd = $nextid = '';
			$count_posts = wp_count_posts( "$post_type" )->publish;
			$cs_postlist_args = array(
			   'posts_per_page'  => -1,
			   'order'           => 'ASC',
			   'post_type'       => "$post_type",
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
			echo '<div class="cs-single-post-pagination">';
			if (isset($previd) &&  !empty($previd) && $previd >=0 ) {
			   ?>
				<div class="post-prev">
					<div class="text">
						<h2 class="cs-post-title">
							<a href="<?php echo get_permalink($previd); ?>"> 
								<span><?php _e('Prevoius Post','Faith'); ?></span>
								<p><?php echo substr(get_the_title($previd),0,26); if(strlen(get_the_title($previd))>26){ echo '...';}?></p>
							</a>
						</h2>
					</div>
				</div>
				<?php
				}
				if (isset($nextid) &&   !empty($nextid) ) {
				?>
				<div class="post-next">
					<div class="text">
						<h2 class="cs-post-title">
							<a href="<?php echo get_permalink($nextid); ?>">
								<span><?php _e('Next Post','Faith'); ?></span>
								<p><?php echo substr(get_the_title($nextid),0,26); if(strlen(get_the_title($nextid))>26){ echo '...';}?></p>
							</a>
						</h2>
					</div>
				</div>
			<?php	
			}
			echo '</div>';
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
        	<?php }else{ ?>
				<img src="<?php echo get_template_directory_uri();?>/images/logo.png" alt="<?php echo bloginfo('name'); ?>" /> 
			<?php }?>
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

function stripslashes_htmlspecialchars($value){

    $value = is_array($value) ? array_map('stripslashes_htmlspecialchars', $value) : stripslashes(htmlspecialchars($value));

    return $value;

}

// stripslashes / htmlspecialchars for theme option save end
 
//Home Page Services

function cs_services(){
	global $cs_theme_option;
	if($cs_theme_option['show_services'] == "on" and $cs_theme_option['varto_services_shortcode'] <> ""){ ?>
	<?php
		echo do_shortcode($cs_theme_option['varto_services_shortcode']);
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

		"title"		=>	'Recent Blogs',

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

 		// ----   recent event widget setting---

		$upcoming_events_widget = array();

		$upcoming_events_widget[1] = array(

		"title"		=>	'Upcoming Events',

		"get_post_slug" 	=> 'social-events',

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
	 	// text widget services
		$text = array();
		$text[1] = array(
			'title' => 'Service timing',
			'text' => '<p><time>Sundays @ 10 am</time> Beginning February 9th</p>
                                    <a class="btn" href="">Plan visit</a>',
		);						

		$text['_multiwidget'] = '1';
		update_option('widget_text',$text);
		$text = get_option('widget_text');
		krsort($text);
		foreach($text as $key=>$val1){
			$text_key = $key;
			if(is_int($text_key)){
				break;
			}
		}
		// text widget services
		$text1 = array();
		$text1 = get_option('widget_text');
		$text1[2] = array(
			'title' => 'Location',
			'text' => '<p><time>Sundays @ 10 am</time> Beginning February 9th</p>
                                    <a class="btn" href="">Plan visit</a>',
		);						

		$text1['_multiwidget'] = '1';
		update_option('widget_text',$text1);
		$text1 = get_option('widget_text');
		krsort($text1);
		foreach($text1 as $key1=>$val1){
			$text_key1 = $key1;
			if(is_int($text_key1)){
				break;
			}
		}
		//----First text widget for contact info----------

		$text2 = array();
		$text2 = get_option('widget_text');
		$text2[3] = array(
			'title' => 'Church Campus',
			'text' => '<p>You can always find us at our three campuses, Livermore, Brentwood and Walnut Creek. Below are the directions and phone numbers for each campus.You can always find us at our three campuses, Livermore, Brentwood and Walnut Creek. </p>',
		);						

		$text2['_multiwidget'] = '1';
		update_option('widget_text',$text2);
		$text2 = get_option('widget_text');
		krsort($text2);
		foreach($text2 as $key1=>$val1){
			$text_key2 = $key1;
			if(is_int($text_key2)){
				break;
			}
		}
		
		//----Second text widget for contact info----------
		$text3 = array();
		$text3 = get_option('widget_text');
		$text3[4] = array(
			'title' => 'Address',
			'text' => '<p>
                                Glory Community Church<br>
                                1350 Danvelly Boulevard of city<br>
                                Cityname, Ontario 12345
                                </p>
                                <ul>
                                	<li><span>Tel</span> : +44 (0) 20 7287 4167</li>
                                    <li><span>Fax</span> : +44 (0) 20 7287 4167</li>
                                    <li><span>Email</span> : mail@email.com</li>
                                </ul>
                               ',
		);						

		$text3['_multiwidget'] = '1';
		update_option('widget_text',$text3);
		$text3 = get_option('widget_text');
		krsort($text3);
		foreach($text3 as $key1=>$val1){
			$text_key3 = $key1;
			if(is_int($text_key3)){
				break;
			}
		}
		
		//----Third text widget for contact info----------
		$text4 = array();
		$text4 = get_option('widget_text');
		$text4[5] = array(
			'title' => 'Important Contacts',
			'text' => '<ul>
							<li><span>Prayer Requests:</span>info@churchname.org</li>
							<li><span>Give online:</span>webmaster@hurchname.org</li>
							<li><span>Volunteers:</span>prayer@hurchname.org</li>
						</ul>',
		);						

		$text4['_multiwidget'] = '1';
		update_option('widget_text',$text4);
		$text4 = get_option('widget_text');
		krsort($text4);
		foreach($text4 as $key1=>$val1){
			$text_key4 = $key1;
			if(is_int($text_key4)){
				break;
			}
		}


		// --- gallery widget setting ---

		$cs_gallery = array();

		$cs_gallery[1] = array(

			'title' => 'Our Photos',

			'get_names_gallery' => 'gallery',

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

		//----text widget for footer----------
		// Add widgets in sidebars

	$sidebars_widgets['Sidebar'] = array("categories-$categories_key","recentposts-$recent_post_widget_key", "upcoming_events-$upcoming_events_widget_key","facebook_module-$facebook_module_key", "cs_gallery-$cs_gallery_key");

	$sidebars_widgets['Contact'] = array("text-$text_key2", "text-$text_key3", "text-$text_key4");
	
	$sidebars_widgets['shop'] = "";	
	$sidebars_widgets['Services'] = array("text-$text_key", "text-$text_key1");	
	update_option('sidebars_widgets',$sidebars_widgets);  //save widget informations

	}

	// Install data on theme activation

 
	function cs_activation_data() {

		global $wpdb;

		$args = array(

			'style_sheet' => 'custom',

			'custom_color_scheme' => '#409F74',
   
			'layout_option' => 'wrapper_boxed',

			// Banner Backgorung Color

			'banner_bg_color' => '#29688a',

			// footer Color Settigs

			'header_styles' => 'header1',

			'default_header' => 'header1',

			// HEADER SETTINGS header_cart 

			'header_logo' => 'on',
			'header_slogan' => 'on',
			'header_search' => 'on',
			'header_languages' => 'on',
 			'header_cart' => 'off',

 
			'header_languages' => '',

			'header_social_icons' => 'on',
			'header_donation_btn' => '',
			'header_widget_btn' => '',
			'header_widget_title' => 'Service Times',

    
 
			'announcement_title' => 'Latest Update',

			'announcement_blog_category' => '',

			'announcement_no_posts' => '5',



			'bg_img' => '0',

			'bg_img_custom' => '',

			'bg_position' => 'center',

			'bg_repeat' => 'no-repeat',

			'bg_attach' => 'fixed',

			'pattern_img' => '0',

			'custome_pattern' => '',

			'bg_color' => '#444E58',

			'logo' => get_template_directory_uri().'/images/logo.png',

			'logo_width' => '175',

			'logo_height' => '60',

			'header_sticky_menu' => 'on',

			'fav_icon' => get_template_directory_uri() . '/images/favicon.png',

			'header_code' => '',
			
			'beadcrumbs_type' => 'breadcrumbs',

			'show_beadcrumbs' => 'on',

			'breadcrumb_text' => '[button color=\'#fff\' background=\'#29688a\' src=\'LINK_URL\' target=\'_blank\']Button 1[/button][button color=\'#fff\' background=\'#a46427\' src=\'LINK_URL\' target=\'_blank\']Button 2[/button][button color=\'#fff\' background=\'#80715c\' src=\'LINK_URL\' target=\'_blank\']Button 3[/button]',

 			
			'footer_logo' => get_template_directory_uri().'/images/footer-logo.png',
			'footer_socialicon' => 'on',
			'footer_mailchimp' => 'on',
			'footer_tweet_area' => '',
			'tweet_user_name' => '',
			'num_of_tweets' => '',

			'copyright' =>  '&copy;'.gmdate("Y")." ".get_option("blogname")." Wordpress All rights reserved.", 

			'powered_by' => '<a href="#">Design by ChimpStudio</a>',

			'powered_icon' => '',

			'analytics' => '',

			'responsive' => 'on',

			'style_rtl' => '',
 
			// switchers

			'color_switcher' => '',

			'trans_switcher' => '',

			'show_slider' => '',

			'slider_name' => 'slider',

			'slider_type' => '',

  
			'post_title' => '',

  
			'sidebar' => array('Sidebar','shop','Contact','Services'),

			// slider setting

			'flex_effect' => 'fade',

			'flex_auto_play' => 'on',

			'flex_animation_speed' => '7000',

			'flex_pause_time' => '600',

			'slider_id' => '',

			'slider_view' => '',

			'social_net_title' => '',

			'social_net_icon_path' => array( '', '', '', '', '', '', ),

			'social_net_awesome' => array( 'fa-facebook', 'fa-google-plus', 'fa-twitter', 'fa-linkedin', 'fa-flickr' ),

			//'social_net_color_input' => array( '#005992', '#2a99e1', '#927f46', '#d70d38', '#ff0000', '#009bff;', '#2a99e1', '#2a99e1', ' #2a99e1' ),

			'social_net_url' => array( 'Facebook URL', 'Google-plus URL', 'Twitter URL', 'Linkedin URL', 'Flickr URL' ),

			'social_net_tooltip' => array( 'Facebook', 'Google-plus', 'Twitter', 'Linkedin', 'Flickr' ),

			'facebook_share' => 'on',

			'twitter_share' => 'on',

			'linkedin_share' => 'on',

			'pinterest_share' => 'on',

			'tumblr_share' => 'on',

			'google_plus_share' => 'on',

			'cs_other_share' => 'on',

			'mailchimp_key' => '',

			// tranlations
			'trans_sermon_study' => 'Study Guide',
			'trans_sermon_download' => 'Download Mp3',
			'trans_sermon_buy' => 'Buy full Sermon',
			
			'trans_prayer_already_prayed' => 'You Already Prayed',
			'trans_prayer_you_prayed' => 'You Prayed',
			'trans_prayer_pray_this' => 'I Pray for this',
			'trans_prayer_encourage' => 'Encourage',
			
			'trans_view_all' => 'View All Posts',
			
			'trans_event_free_entry' => 'Free Entry',
			'trans_event_sold_out' => 'Sold Out',
			'trans_event_cancelled' => 'Cancelled',
            'trans_event_buy_ticket' => 'Buy Ticket',
			'trans_event_eventtime' => 'Event Time',
			'trans_event_location' => 'Location',
			'trans_event_speakers' => 'Speakers',
			

			'res_first_name' => 'First Name',

			'res_last_name' => 'Last Name',

            'trans_subject' => 'Subject',

            'trans_message' => 'Message',

            'trans_share_this_post' => 'Share Now',

            'trans_content_404' => "It seems we can not find what you are looking for.",

			'trans_featured' => 'Featured',

			'trans_read_more' => 'read more',
			
			'trans_posted_on' => 'Posted on',
			
			'trans_other_photos' => 'Photos',
			'trans_other_or' => 'or',
			'trans_other_in' => 'in',
			'trans_other_weekly_newsletter' => 'Weekly Newsletter',
			'trans_other_latest_tweet' => 'Latest Tweet',
 			'trans_other_donate' =>'Donate',
			'trans_other_donation_title' =>'I wish to make a donation',
			

			// translation end

           	'pagination' => 'Show Pagination',

			'record_per_page' => '5',

			'cs_layout' => 'right',

			'cs_sidebar_left' => 'sidebar-1',

			'cs_sidebar_right' => 'sidebar-1',

			'under-construction' => '',

			'showlogo' => 'on',

			'socialnetwork' => 'on',

			'under_construction_text' => '<h1 class="colr">OUR WEBSITE IS UNDERCONSTRUCTION</h1><p>We shall be here soon with a new website, Estimated Time Remaining</p>',

			'launch_date' => '2014-10-24',
			'paypal_email' => 'paypal@chimp.com',
			'paypal_ipn_url' => home_url().'/ipn-url/',
			'paypal_currency' => 'USD',
			'paypal_currency_sign' => '$',
 			'consumer_key' => '',
			'consumer_secret' => '',
			'access_token' => '',
			'access_token_secret' => '',
			'show_services' => '',
			'varto_services_shortcode' => '',
 		);
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

require_once (TEMPLATEPATH . '/include/slider.php');

require_once (TEMPLATEPATH . '/include/gallery.php');

require_once (TEMPLATEPATH . '/include/sermon.php');

require_once (TEMPLATEPATH . '/include/prayer.php');

require_once (TEMPLATEPATH . '/include/page_builder.php');

require_once (TEMPLATEPATH . '/include/post_meta.php');

require_once (TEMPLATEPATH . '/include/short_code.php');

require_once (TEMPLATEPATH . '/include/admin_functions.php');

require_once (TEMPLATEPATH . '/include/widgets.php');

require_once (TEMPLATEPATH . '/functions-theme.php');

require_once (TEMPLATEPATH . '/include/mailchimpapi/MailChimp.class.php');

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

		wp_enqueue_style('style_css', get_stylesheet_directory_uri(). '/style.css');
		wp_enqueue_style('prettyPhoto_css', get_template_directory_uri() . '/css/prettyphoto.css');
		wp_enqueue_style('flexslider_css', get_template_directory_uri() . '/css/flexslider.css');
 
  		if ( $cs_theme_option['color_switcher'] == "on" ) {

			wp_enqueue_style('color-switcher_css', get_template_directory_uri() . '/css/color-switcher.css');

		}

  		wp_enqueue_style('bootstrap_css', get_template_directory_uri() . '/css/bootstrap.css');

		wp_enqueue_style('font-awesome_css', get_template_directory_uri() . '/css/font-awesome.css');

 
		wp_enqueue_style('widget_css', get_template_directory_uri() . '/css/widget.css');
		
 		// Enqueue stylesheet
		   	wp_enqueue_style( 'wp-mediaelement' );

 		    wp_enqueue_script('jquery');

			wp_enqueue_script( 'wp-mediaelement' );
			wp_enqueue_script('bootstrap_js', get_template_directory_uri() . '/scripts/frontend/bootstrap.min.js', '', '', true);
			wp_enqueue_script('jquery.flexslider-min_js', get_template_directory_uri() . '/scripts/frontend/jquery.flexslider-min.js', '', '', true);
			wp_enqueue_script('modernizr_js', get_template_directory_uri() . '/scripts/frontend/modernizr.js', '', '', true);
			
			wp_enqueue_script('prettyPhoto_js', get_template_directory_uri() . '/scripts/frontend/jquery.prettyphoto.js', '', '', true);
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
// Masonry Style and Script enqueue

function cs_enqueue_masonry_style_script(){

	wp_enqueue_style('masonry_css', get_template_directory_uri() . '/css/masonry.css');

	wp_enqueue_script('jquery.masonry_js', get_template_directory_uri() . '/scripts/frontend/jquery.masonry.min.js', '', '', true);

}

// Validation Script Enqueue

function cs_enqueue_validation_script(){

	wp_enqueue_script('jquery.validate.metadata_js', get_template_directory_uri() . '/scripts/admin/jquery.validate.metadata.js', '', '', true);

	wp_enqueue_script('jquery.validate_js', get_template_directory_uri() . '/scripts/admin/jquery.validate.js', '', '', true);

}


// parallax script enqueue
function cs_enqueue_parallax_script(){
		wp_enqueue_script('jquery.parallax_js', get_template_directory_uri() . '/scripts/frontend/parallax.js', '', '', true);
}
function cs_cycleslider_script(){
	wp_enqueue_script('jquerycycle2_js', get_template_directory_uri() . '/scripts/frontend/cycle2.js', '', '', true);
	wp_enqueue_script('jquery.plugin_js', get_template_directory_uri() . '/scripts/frontend/jquery.plugin.min.js', '', '', true);
} 

// Flexslider Script and style enqueue

function cs_enqueue_countdown_script(){

   	wp_enqueue_script('jquery.countdown_js', get_template_directory_uri() . '/scripts/frontend/jquery.countdown.js', '', '', true);

}
// news ticker enqueue style and script
function cs_enqueue_newsticker(){

   	wp_enqueue_script('jquery.ticker_js', get_template_directory_uri() . '/scripts/frontend/jquery.ticker.js', '', '', true);
 
}

function cs_addthis_script_init_method(){
	if( is_single()){
		wp_enqueue_script( 'cs_addthis', 'http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e4412d954dccc64', ",",'true');
	}
}
// Favicon and header code in head tag//
if ( ! function_exists( 'cs_header_settings' ) ) {
	function cs_header_settings() {
	
		global $cs_theme_option;
	
		?>
		 <link rel="shortcut icon" href="<?php echo $cs_theme_option['fav_icon'] ?>" />
	
		 <!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		 <?php  
	
		 echo  htmlspecialchars_decode($cs_theme_option['header_code']); 
	
	}
}

// Favicon and header code in head tag//
if ( ! function_exists( 'cs_footer_settings' ) ) {
	function cs_footer_settings() {
		global $cs_theme_option;
		?>
		<!--[if lt IE 9]><link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/css/ie8.css" /><![endif]-->
		 <?php  
		if(isset($cs_theme_option['analytics'])){
			echo htmlspecialchars_decode($cs_theme_option['analytics']);
		}
	
	}
}
// Home page Slider //
if ( ! function_exists( 'cs_get_home_slider' ) ) {
	function cs_get_home_slider($width = '',$height = ''){
		 global $cs_theme_option;
		if($cs_theme_option['show_slider'] =="on"){
		?>
		   <div id="banner">
				<?php 
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
						cs_no_result_found();
					}
				  }
				?>
		   </div>
		 <?php 
		}
	}
}

// Page Sub header title and subtitle //
if ( ! function_exists( 'get_subheader_title' ) ) {
	function get_subheader_title(){
 		global $post, $wp_query;;
 		$show_title=true;
 		$show_subtitle=true;
 		$subtitle = '';
 		$get_title = '';
		if (is_page() || is_single()) {
			if (is_page() ){
			  $cs_xmlObject = cs_meta_page('cs_page_builder');
			  if (isset($cs_xmlObject)) {
				  if ($cs_xmlObject->page_title == "No") {
					  $show_title = false;
				  }
				  $subtitle = $cs_xmlObject->page_sub_title;
			  }
			  if(isset($show_title) && $show_title==true){
				$get_title = '<h1 class="cs-page-title">' . substr(get_the_title(), 0, 40) . '</h1>';
				}
			} elseif (is_single()) {
				$show_title=true;
				$show_subtitle=true;
				if(isset($show_title) && $show_title==true){
					$get_title = '<h1 class="cs-page-title">' . get_the_title() . '</h1>';
				}
			}
			if(isset($show_title) && $show_title==true){
				echo $get_title;
			}
			if(is_page()){
				if(isset($subtitle) && $subtitle <> ''){echo '<p>' . $subtitle . '</p>';}
			}else{
				 cs_posted_on();
			}
			} else { ?>
 				<h1 class="cs-page-title"><?php cs_post_page_title();?></h1>
			<?php 
			}
	}
}

// character limit 

function cs_character_limit($string = '',$start_limit ='',$end_limit=''){
	return substr($string,$start_limit,$end_limit)."...";
}

// hide figure tag on post list page
if ( ! function_exists( 'cs_post_type' ) ) {
	function cs_post_type($post_view,$image_url = ''){
		$cs_post_cls = '';
		if ( $post_view <> "" ) {
			if($post_view=="Audio"){
				$cs_post_cls ='cls-post-audio';
			}elseif($post_view == "Video"){
				$cs_post_cls ='cls-post-video';
			}elseif($post_view == "Slider"){
				$cs_post_cls ='cls-post-slider';
			}elseif($post_view == "Gallery"){
				$cs_post_cls ='cls-post-gallery';
			}elseif($image_url <> '' and $post_view == "Single Image"){
				$cs_post_cls ='cls-post-image';
			}else{
				$cs_post_cls ='cls-post-default cls-post-noimg';
			}
		}
		return $cs_post_cls;
	}
}
// Front End Functions END

// post date/categories/tags
if ( ! function_exists( 'cs_posted_on' ) ) {
	function cs_posted_on($cat=true,$tag=true,$comment=true){
		global $cs_theme_option;
		?>
		<ul class="post-options">
			<li>
				<?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Posted on','Faith'); }else{ echo $cs_theme_option['trans_posted_on']; } ?> 
                <time datetime="<?php echo date('d-m-y',strtotime(get_the_date()));?>"><?php echo get_the_date();?></time></li>
			<?php if(is_home() || is_front_page()){}else{?>
			<li> 
				<?php printf( __('By: %s','Faith'), ''); ?> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"> <?php echo get_the_author(); ?></a>
            </li>
			<?php } ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$trans_in = "";
				if($cat==true){
					if($cs_theme_option['trans_switcher'] == "on"){ $trans_in = __('in','Faith'); }else{ $trans_in = $cs_theme_option['trans_other_in']; }
					$before_cat = "<li> ".$trans_in." ";
					$categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '</li>' );
					if ( $categories_list ){
						printf( __( '%1$s', 'Faith'),$categories_list );
					}
				}
				/* translators: used between list items, there is a space after the comma */
				if($tag == true){
					$before_tag = "<li>".__( 'tags ','Faith')."";
					$tags_list = get_the_term_list ( get_the_id(), 'post_tag', $before_tag, ', ', '</li>' );
					if ( $tags_list ){
						printf( __( '%1$s', 'Faith'),$tags_list );
					} // End if categories 
				}
				if($comment == true){
					if ( comments_open() ) {  
						echo "<li>"; comments_popup_link( __( '0 Comment', 'Faith' ) , __( '1 Comment', 'Faith' ), __( '% Comments', 'Faith' ) ); 
					}
				}
				cs_featured();
				edit_post_link( __( 'Edit', 'Faith'), '<li>', '</li>' ); 
			?>
		</ul>
	<?php
	}
}
/*------Header Functions End------*/
// author description custom function
if ( ! function_exists( 'cs_author_description' ) ) {
	function cs_author_description() {
		global $cs_theme_option;
		?>
		<div class="about-author">
			<figure>
				<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
					<?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('PixFill_author_bio_avatar_size', 80)); ?>
				</a>
			</figure>
			<div class="text">
				<h2><?php echo get_the_author(); ?></h2>
				<p><?php the_author_meta('description'); ?></p>
				<a class="viewall" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
					<?php if($cs_theme_option['trans_switcher'] == "on"){ _e('View All','Faith'); }else{ echo $cs_theme_option['trans_view_all']; } ?>
				</a>
			</div>
		</div>
		<?php
	}
}
// register menu name on theme activation
if ( ! function_exists( 'cs_register_my_menus' ) ) {
	function cs_register_my_menus() {
 	  register_nav_menus(
 		array(
 			'main-menu'  => __('Main Menu','Faith'),
		)
 	  );
 	}
}
// search varibales start
if ( ! function_exists( 'cs_get_search_results' ) ) {
	function cs_get_search_results($query) {
		if ( !is_admin() and (is_search())) {
			$query->set( 'post_type', array('post', 'events', 'cs_cause') );
			remove_action( 'pre_get_posts', 'cs_get_search_results' );
		}
	}
}
// password protect post/page
 if ( ! function_exists( 'cs_password_form' ) ) {

	function cs_password_form() {

		global $post,$cs_theme_option;

		$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );

		$o = '<div class="password_protected">

				<div class="protected-icon"><a href="#"><i class="fa fa-unlock"></i></a></div>

				<h4>' . __( "This post is password protected. To view it please enter your password below:",'Faith' ) . '</h4>';

		$o .= '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">

					<label><input name="post_password" id="' . $label . '" type="password" size="20" /></label>

					<input class="cs-bgcolr btn" type="submit" name="Submit" value="'.__("Submit", "Statfort").'" />

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

//////////////// Header Cart Ends ///////////////////

//	Add Featured/sticky text/icon for sticky posts.

if ( ! function_exists( 'cs_featured()' ) ) {

	function cs_featured(){

		global $cs_transwitch,$cs_theme_option;

		if ( is_sticky() ){ ?>

		<li class="cs-featured"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Featured','Faith');}else{ echo $cs_theme_option['trans_featured']; } ?></li>
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
	
			echo __('Author', 'Faith') . " " . __('Archives', 'Faith') . ": ".$userdata->display_name;
	
		}elseif ( is_tag() || is_tax('event-tag') || is_tax('portfolio-tag') || is_tax('sermon-tag') ) {
	
			echo __('Tags', 'Faith') . " " . __('Archives', 'Faith') . ": " . single_cat_title( '', false );
	
		}elseif ( is_category() || is_tax('event-category') || is_tax('portfolio-category')  || is_tax('sermon-category')  || is_tax('sermon-series')  || is_tax('sermon-pastors') ) {
	
			echo __('Categories', 'Faith') . " " . __('Archives', 'Faith') . ": " . single_cat_title( '', false );
	
		}elseif( is_search()){
	
			printf( __( 'Search Results %1$s %2$s', 'Faith' ), ': ','<span>' . get_search_query() . '</span>' ); 
	
		}elseif ( is_day() ) {
	
			printf( __( 'Daily Archives: %s', 'Faith' ), '<span>' . get_the_date() . '</span>' );
	
		}elseif ( is_month() ) {
	
			printf( __( 'Monthly Archives: %s', 'Faith' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'Faith' ) ) . '</span>' );
	
		}elseif ( is_year() ) {
	
			printf( __( 'Yearly Archives: %s', 'Faith' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'Faith' ) ) . '</span>' );
	
		}elseif ( is_404()){
	
			_e( 'Error 404', 'Faith' );
	
		}elseif(!is_page()){
	
			_e( 'Archives', 'Faith' );
	
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
if ( ! function_exists( 'cs_no_result_found' ) ) {
	function cs_no_result_found($search = true){
		
		?>
        <div class="pagenone cls-noresult-found">
            <i class="fa fa-warning cs-colr"></i>
            <h1><?php _e( 'No results found.', 'Faith'); ?></h1>
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
// news announcement 
if ( ! function_exists( 'cs_announcement' ) ) {
	function cs_announcement(){
	?>
	<div class="outer-newsticker">
        <div class="container">
        <?php 
        global $cs_theme_option;
        $blog_category = $cs_theme_option['announcement_blog_category'];
        $announcement_no_posts = $cs_theme_option['announcement_no_posts'];
         if(isset($blog_category) && $blog_category <> '0'){
            if (empty($announcement_no_posts)){ $announcement_no_posts  = 5;}
            $args = array('posts_per_page' => "$announcement_no_posts", 'category_name' => "$blog_category",'post_status' => 'publish');
            $custom_query = new WP_Query($args);
            
            ?>
           
            <div class="announcement-ticker">
                <h5>
					<i class="fa fa-bell"></i>
					<?php echo $cs_theme_option['announcement_title'];?>
                    <i class="fa fa-angle-right"></i>
                 </h5>
                <?php 
					if($custom_query->have_posts()):
					cs_enqueue_newsticker();
				?>
                <script>
                	jQuery(document).ready(function(){
                	    cs_jsnewsticker('cls-news-ticker',50,80)
                	});
            	</script>
                <div class="ticker-wrapp">
                    <ul class="cls-news-ticker">
                      <?php 
                          while ($custom_query->have_posts()) : $custom_query->the_post();
                      ?>
                          <li>															
                              <a href="<?php the_permalink();?>"><?php the_title();?> &nbsp; <?php echo get_the_date(); ?></a>
                          </li>
                         <?php endwhile;?>
                    </ul>
                </div>
                <?php else: 
                   cs_no_result_found(false);
                  endif; ?>
            </div>
        <?php }?>
            </div>
        </div>
	<?php	
	}
}
// return mail chimp mailing list
if ( ! function_exists( 'cs_mailchimp_list' ) ) {
	function cs_mailchimp_list($apikey){
		global $cs_theme_option;
		$MailChimp = new MailChimp($apikey);
		$mailchimp_list = $MailChimp->call('lists/list');
		return $mailchimp_list;
	}
}
// custom mail chimp form
if ( ! function_exists( 'cs_custom_mailchimp' ) ) {
	function cs_custom_mailchimp(){
	global $cs_theme_option;
	$counter = 1;
 	?>
	<div class="widget widget_newsletter">
    	<header class="cs-heading-title">
      		<h2 class="cs-section-title"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Weekly Newsletter','Faith');}else{ if(isset($cs_theme_option['trans_other_weekly_newsletter']))echo $cs_theme_option['trans_other_weekly_newsletter']; } ?></h2>
    	</header>
  	  
        <form action="javascript:cs_mailchimp_submit('<?php echo get_template_directory_uri()?>','<?php echo $counter; ?>')" id="mcform_<?php echo $counter;?>" method="post">
        		<div id="newsletter_mess_<?php echo $counter;?>" style="display:none"></div>
            <label>
                <input id="cs_list_id" type="hidden" name="cs_list_id" value="<?php if(isset($cs_theme_option['cs-mc-list'])){ echo $cs_theme_option['cs-mc-list']; }?>" />
                <input id="mc_email" type="text" name="mc_email" value="" placeholder="Enter your valid email address" />
             </label>
            <input type="submit" id="btn_newsletter_<?php echo $counter;?>" name="submit" class="btn cs-submit" value="submit"  />
            <div id="process_newsletter_<?php echo $counter;?>"></div>
        </form>
        <p><i class="fa fa-envelope-o"></i>Dont't worry, we won't spam you. You will be able to unsubcribe with a sigle mouse click.</p>
        
     </div>
    <?php
	$counter++;
	}
}
// buynow button styles
if ( ! function_exists( 'cs_bynow_button' ) ) {
	function cs_bynow_button($cs_event_meta){
		global $cs_theme_option;
		$event_ticket_price = '';
		if($cs_event_meta->event_ticket_price <> ''){
		$event_ticket_price = $cs_event_meta->event_ticket_price.' | ';
		}
		?>
		<?php if($cs_event_meta->event_ticket_options == "Buy Now"){?> 
		<li><a class="btn cs-buynow cs-bgcolr bgcolr" href="<?php echo $cs_event_meta->event_buy_now;?>"><?php echo $event_ticket_price; if($cs_theme_option['trans_switcher'] == "on"){ _e('Buy Ticket','Statford');}else{ echo $cs_theme_option['trans_event_buy_ticket']; } ?></a></li>   
		<?php } ?>
		<?php if($cs_event_meta->event_ticket_options == "Free"){?> 
		<li><a class="cs-free btn cs-btnfree"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Free Entry','Statford');}else{ echo $cs_theme_option['trans_event_free_entry']; } ?></a></li>   
		<?php } ?>
		<?php if($cs_event_meta->event_ticket_options == "Cancelled"){?> 
		<li> <a class="cs-btncancel btn" ><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Cancelled','Statford');}else{ echo $cs_theme_option['trans_event_cancelled']; } ?></a></li>   
		<?php } ?>
		<?php if($cs_event_meta->event_ticket_options == "Full Booked"){?> 
		<li><?php echo $event_ticket_price;?><a class="cs-btnbook btn" ><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Sold Out','Statford');}else{ echo $cs_theme_option['trans_event_sold_out']; } ?></a></li>   
		<?php } 
	}
}
// show gallery on blog posts
if ( ! function_exists( 'cs_post_gallery' ) ) {
	function cs_post_gallery($gal_gallery = ''){
		$cs_meta_gallery_options = get_post_meta($gal_gallery, "cs_meta_gallery_options", true);
		$limit_start = 0;
		
		if ( $cs_meta_gallery_options <> "" ) {
			$cs_xmlObject = new SimpleXMLElement($cs_meta_gallery_options);
			$limit_end = count($cs_xmlObject);
			echo '<div class="gallerysec"><ul class="thumb-gallery">';
			for ( $i = $limit_start; $i < $limit_end; $i++ ) {
				$path = $cs_xmlObject->gallery[$i]->path;
				$title = $cs_xmlObject->gallery[$i]->title;
				$social_network = $cs_xmlObject->gallery[$i]->social_network;
				$use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;
				$video_code = $cs_xmlObject->gallery[$i]->video_code;
				$link_url = $cs_xmlObject->gallery[$i]->link_url;
				$image_url = cs_attachment_image_src($path, 150, 150);
				$image_url_full = cs_attachment_image_src($path, 0, 0);
				?>
				<li>
				<a data-title="<?php if ( $title <> "" ) { echo $title;}?>"  href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" target="<?php if($use_image_as==2) echo '_blank'; ?>" data-rel="<?php if($use_image_as==1)echo "prettyPhoto";  elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>">							  
							<figure>
								<?php echo "<img src='".$image_url."' data-alt='".$title."' alt='' />";  ?>
								<figcaption>
									 <span class="bghover"></span>
									 <div class="text">
									   <?php 
											  if($use_image_as==1){
												  echo '<i class="fa fa-video-camera"></i>';
											  }elseif($use_image_as==2){
												  echo '<i class="fa fa-link"></i>';	
											  }else{
												  echo '<i class="fa fa-picture-o"></i>';
											  }
										  ?>
									</div>
									</figcaption>
								
								</figure>
							</a>
						</li>
				<?php
			}
			  echo '</ul></div>';
		}
	
	}
}
// show gallery image count
if ( ! function_exists( 'cs_image_count' ) ) {
	function cs_image_count($gal_album = ''){
		$cs_meta_gallery_options = get_post_meta($gal_album, "cs_meta_gallery_options", true);
		if ( $cs_meta_gallery_options <> "" ) {
			$cs_xmlObject = new SimpleXMLElement($cs_meta_gallery_options);
			return count($cs_xmlObject);
		}
	}
}
// Paypal Button
if ( ! function_exists( 'cs_donate_button' ) ) {
	function cs_donate_button($cs_currency =''){
		global $post, $cs_theme_option;
		$cs_cause_paypal_email = $cs_theme_option['paypal_email'];
		if($cs_theme_option['trans_switcher'] == "on"){ $cause_donate = __('Donate','faith');}else{ $cause_donate = $cs_theme_option['trans_other_donate']; }
		
		$paypal_content_button = '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">  
			<input type="hidden" name="cmd" value="_xclick">  
			<input type="hidden" name="business" value="'.$cs_cause_paypal_email.'">
			<label ><span>'.$cs_currency.'</span><input type="text"  name="amount" value="" ></label>
			<input type="hidden" name="item_name" value="'.get_the_title().'"> 
			<input type="hidden" name="no_shipping" value="2">
			<input name = "cancel_return" value = "'.get_bloginfo('url').'" type = "hidden">  
			<input type="hidden" name="no_note" value="1">  
			<input type="hidden" name="currency_code" value="'.$cs_theme_option['paypal_currency'].'">  
			<input type="hidden" name="notify_url" value="'.$cs_theme_option['paypal_ipn_url'].'">
			<input type="hidden" name="lc" value="AU">  
			<input type="hidden" name="return" value="'.get_bloginfo('url').'">  
			<span class="donate-btn btn"><input type="submit" value="'.$cause_donate.'"> </span>
		</form> ';
		echo $paypal_content_button;
	}
}