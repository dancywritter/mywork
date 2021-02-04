<?php
	// Install data on theme activation
	function px_activation_data() {
		global $wpdb;
		$args = array(
		'style_sheet' => 'custom',
		'custom_color_scheme' => '#36394A',
		'header_languages' => '',
		'header_cart' => '',
		'header_languages' => '',
		'header_social_icons' => 'on',
		// Background options
		'varto_bg_option' => 'no-image',
		'px_home_v2_video' => '',
		'px_home_v2_video_mute' => '',
		'bg_image' => '',
		'px_home_v5_gallery' => '',
		'px_home_v4_slider' => '',
		'px_rotation_text' => '',
		// end Background options
		
		// home page announcements
		'announcement_title' => '',
		'announcement_blog_category' => '',
		'announcement_no_posts' => '',
		// end home page announcements

		'bg_color' => '',
		'logo' => get_template_directory_uri().'/images/logo.png',
		'logo_width' => '118',
		'logo_height' => '91',

		'fav_icon' => get_template_directory_uri() . '/images/favicon.ico',
		'header_code' => '', 'header_track_mp3_url' => '', 'header_track_mp3_autoplay' => '',
 		 'analytics' => '',
		 'responsive' => 'on',
		 'style_rtl' => '',
		 'rtl_switcher' => '',
		 'site_ajax' => '',
		 'site_nicescroll' => '',

		 'trans_switcher' => '',
		 //'sidebar' => array( 'Sidebar'),
		 'social_share' => 'on',
		'social_net_icon_path' => array( '', '', '', '', '', '', '', '', '' ),
		'social_net_awesome' => array( 'fa-facebook-square', 'fa-google-plus-square', 'fa-linkedin-square', 'fa-pinterest-square', 'fa-twitter-square', 'fa-tumblr-square', 'fa-instagram', 'fa-flickr' ),'social_net_url' => array( 'Facebook URL', 'Google-plus URL', 'Linked-in URL', 'Pinterest URL', 'Twitter URL', 'Tumblr URL', 'Instagram URL', 'Flickr URL' ),'social_net_tooltip' => array( 'Facebook', 'Google-plus', 'Linked-in', 'Pinterest', 'Twitter', 'Tumblr', 'Instagram', 'Flickr' ),'facebook_share' => 'on','twitter_share' => 'on','linkedin_share' => 'on','pinterest_share' => 'on','tumblr_share' => 'on','google_plus_share' => 'on','px_other_share' => 'on','trans_event_location' => 'Event Location','trans_sermons' => 'Sermons','trans_play_all' => 'Play All','trans_pause_all' => 'Pause All','trans_subject' => 'Subject','trans_message' => 'Message', 'trans_share_this_post' => 'Share Now','trans_featured' => 'Featured','trans_listed_in' => 'in','trans_posted_on' => 'Posted on','trans_read_more' => 'read more','trans_other_phone' => 'Phone:','trans_other_fax' => 'Fax:','trans_menu_title' => 'EXPLORE THIS SITE','trans_load_more' => 'Load More','trans_special_request' => 'Special Request','trans_email_published' => '*Your Email will never published.',

			'pagination' => 'Show Pagination',
			'record_per_page' => '5',
			'px_layout' => 'none',
			'px_sidebar_left' => '',
			'px_sidebar_right' => '',
			'showlogo' => 'on',
			'socialnetwork' => 'on',
			'launch_date' => '2015-10-24',
	);
		/* Merge Heaser styles	*/
		update_option("px_theme_option", $args );
		update_option("px_theme_option_restore", $args );
 	}