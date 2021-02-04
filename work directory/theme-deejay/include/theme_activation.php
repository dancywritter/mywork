<?php
	// Install data on theme activation
	function px_activation_data() {
		global $wpdb;
		$args = array(
		'style_sheet' => 'custom',
		'custom_color_scheme' => '#94ae46',
		'element_color_scheme' => '#94ae46',
		'header_languages' => '',
		'header_cart' => '',
		'header_languages' => '',
		'header_social_icons' => 'on',
		// Background options
		'varto_bg_option' => 'no-image',
		'bg_image' => '',
		'px_home_v2_video' => '',
		'px_home_v2_video_mute' => '',
		'bg_custom_image' => '',
		'bg_image' => '',
		'px_home_v5_gallery' => '',
		'px_home_v4_slider' => '',
		// end Background options
		
		// home page settings
		
		'blog_banner_category' => '',
		'banner_no_posts' => '',
		'px_music_autoplay' => 'on',
		'px_music_album' => '',
		// end home page announcements
		'bg_color' => '',
		'main_logo' => get_template_directory_uri().'/images/logo-large.png',
		'logo' => get_template_directory_uri().'/images/logo.png',
		'logo_width' => '122',
		'logo_height' => '67',
		'fav_icon' => get_template_directory_uri() . '/images/favicon.ico',
		'header_code' => '',
		'copyright' =>  '&copy;'.gmdate("Y")." ".get_option("blogname")." Wordpress All rights reserved.", 
 		 'analytics' => '',
		 'responsive' => 'on',
		 'rtl_switcher' => '',
		 'site_nicescroll' => '',
		 'trans_switcher' => '',
		 'flex_effect' => 'fade','flex_auto_play' => 'on','flex_animation_speed' => '7000','flex_pause_time' => '600','slider_id' => '','slider_view' => '',
		 'sidebar' => array( 'sidebar-1'),
		 'social_share' => 'on',
		 'social_net_title' => 'Follow Us',
		'social_net_icon_path' => array( '', '', '', '', '', '', '', '', '' ),
		'social_net_awesome' => array( 'fa-facebook-square', 'fa-google-plus-square', 'fa-linkedin-square', 'fa-pinterest-square', 'fa-twitter-square' ),'social_net_url' => array( 'Facebook URL', 'Google-plus URL', 'Linked-in URL', 'Pinterest URL', 'Twitter URL' ),'social_net_tooltip' => array( 'Facebook', 'Google-plus', 'Linked-in', 'Pinterest', 'Twitter'),'facebook_share' => 'on','twitter_share' => 'on','linkedin_share' => 'on','pinterest_share' => 'on','tumblr_share' => 'on','google_plus_share' => 'on','px_other_share' => 'on','trans_subject' => 'Subject','trans_message' => 'Message', 'trans_share_this_post' => 'Share Now','trans_featured' => 'Featured','trans_listed_in' => 'in','trans_posted_on' => 'Posted on','trans_read_more' => 'read more','trans_other_phone' => 'Phone:','trans_other_fax' => 'Fax:','trans_menu_title' => 'Back','trans_email_published' => '*Your Email will never published.',
			'trans_current_page' => 'Current Page',
			'trans_likes' => 'Likes',
			'trans_released' => 'Released',
			'trans_gener' => 'Gener',
			'trans_tracks' => 'Tracks',
			
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