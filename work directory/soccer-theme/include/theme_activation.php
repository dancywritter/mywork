<?php
	// Install data on theme activation
	function px_activation_data() {
		global $wpdb;
		$args = array(
		'style_sheet' => 'custom',
		'custom_color_scheme' => '#C00E00',
		'header_languages' => '',
		'header_cart' => '',
		'header_languages' => '',
		'header_search' => 'on',
		// Background options
		'varto_bg_option' => 'no-image',
		'px_home_v2_video' => '',
		'px_home_v2_video_mute' => '',
		'bg_image' => '',
		'px_home_v5_gallery' => '',
		// end Background options
		
		// home page announcements
		'announcement_title' => '',
		'announcement_blog_category' => '',
		'announcement_no_posts' => '',
		'slider_blog_category' => '',
		'slider_no_posts' =>'',
		// end home page announcements

		'bg_color' => '',
		'logo' => get_template_directory_uri().'/images/logo.png',
		'logo_width' => '80',
		'logo_height' => '96',
		
		'fav_icon' => get_template_directory_uri() . '/images/favicon.ico',
		'header_code' => '',
 		 'analytics' => '',
		 'responsive' => 'on',
		 'style_rtl' => '',
		 'rtl_switcher' => '',
		 // fotter setting
		 'footer_social_icons' => 'on',	
		 'partners_title' => '',
		 'partners_gallery' => '',
		 'twitter_name' => '',
		 'tweets_number' =>'',	
		 'trans_switcher' => '',
		 'sidebar' => array( 'sidebar-1'),
		 'social_share' => 'on',
		'social_net_icon_path' => array( '', '', '', '', '', '', '', '', '' ),
		'social_net_awesome' => array( 'fa-facebook-square', 'fa-google-plus-square', 'fa-linkedin-square', 'fa-pinterest-square', 'fa-twitter-square', 'fa-tumblr-square', 'fa-instagram', 'fa-flickr' ),'social_net_url' => array( 'Facebook URL', 'Google-plus URL', 'Linked-in URL', 'Pinterest URL', 'Twitter URL', 'Tumblr URL', 'Instagram URL', 'Flickr URL' ),'social_net_tooltip' => array( 'Facebook', 'Google-plus', 'Linked-in', 'Pinterest', 'Twitter', 'Tumblr', 'Instagram', 'Flickr' ),'facebook_share' => 'on','twitter_share' => 'on','linkedin_share' => 'on','pinterest_share' => 'on','tumblr_share' => 'on','google_plus_share' => 'on','px_other_share' => 'on',
		
		'trans_event_start' => 'Kick-of',
		'trans_event_vs' => 'VS',
		'trans_event_goals' => 'Match Goals',
		'trans_player_born' => 'Born (age)',
		'trans_player_location' => 'Location',
		'trans_player_postion' => 'Position',
		'trans_player_squad' => 'Squad Number',
		'trans_player_debut_date' => 'Debut date',
		'trans_player_location' => 'Location',
		'trans_viewall' => 'View All',
		'trans_pos' => 'Pos',
		'trans_team' => 'Team',
		'trans_play' => 'Play',
		'trans_plusminus' => '+/-',
		'trans_totalpoints' => 'Points',
		
		'trans_subject' => 'Subject','trans_message' => 'Message', 'trans_share_this_post' => 'Share Now','trans_featured' => 'Featured','trans_listed_in' => 'in','trans_posted_on' => 'Posted on','trans_read_more' => 'read more','trans_other_phone' => 'Phone:','trans_other_fax' => 'Fax:','trans_special_request' => 'Special Request','trans_email_published' => '*Your Email will never published.',
			'pagination' => 'Show Pagination',
			'record_per_page' => '5',
			'px_layout' => 'none',
			'px_sidebar_left' => '',
			'px_sidebar_right' => '',
			'showlogo' => 'on',
			'socialnetwork' => 'on',
			'launch_date' => '2015-10-24',
			'copyright' =>  '&copy;'.gmdate("Y")." ".get_option("blogname")." Wordpress All rights reserved.", 
			'powered_by' => '<a href="#">Design by Pixfill</a>',
			'consumer_key' => '',
			'consumer_secret' => '',
			'access_token' => '',
			'access_token_secret' => '',
	);
		/* Merge Heaser styles	*/
		update_option("px_theme_option", $args );
		update_option("px_theme_option_restore", $args );
 	}