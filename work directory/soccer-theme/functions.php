<?php
    /* add action filter and theme support on theme setup */
	add_action( 'after_setup_theme', 'px_theme_setup' );
	function px_theme_setup() {
		/* Add theme-supported features. */		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style();
		// Make theme available for translation
		// Translations can be filed in the /languages/ directory
		load_theme_textdomain('Soccer Club', get_template_directory() . '/languages');
		
		if (!isset($content_width)){
			$content_width = 1160;
		}

		$args = array('default-color' => '','default-image' => '',);
		add_theme_support('custom-background', $args);
		add_theme_support('custom-header', $args);
		// This theme uses post thumbnails
		add_theme_support('post-thumbnails');
		// Add default posts and comments RSS feed links to head
		add_theme_support('automatic-feed-links');
		// Post Formats
		add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	) );
		/* Add custom actions. */
		global $pagenow;
		
		if (is_admin() && isset($_GET['activated']) && $pagenow == 'themes.php'){
			add_action('init', 'px_activation_data');
		}

		if (!session_id()){
			add_action('init', 'session_start');
		}

		add_action( 'init', 'px_register_my_menus' );
		add_action('admin_enqueue_scripts', 'px_admin_scripts_enqueue');
		add_action('wp_enqueue_scripts', 'px_front_scripts_enqueue');
 		add_action('pre_get_posts', 'px_get_search_results');
		add_action('widgets_init', create_function('', 'return register_widget("px_widget_facebook");') );
		add_action('widgets_init', create_function('', 'return register_widget("px_gallery");'));
		add_action('widgets_init', create_function('', 'return register_widget("recentposts");') );
		add_action('widgets_init', create_function('', 'return register_widget("postsslider");') );
		/* Add custom filters. */
		add_filter('widget_text', 'do_shortcode');
		add_filter('the_password_form', 'px_password_form' );
		add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
		add_filter('wp_page_menu','px_add_menuid');
		add_filter('wp_page_menu', 'px_remove_div' );
		add_filter('nav_menu_css_class', 'px_add_parent_css', 10, 2);
		add_filter('pre_get_posts', 'px_change_query_vars');
		add_filter('user_contactmethods','px_contact_options',10,1);
	}

	/* adding custom images while uploading media start */
	add_image_size('px_media_1', 1100, 556, true);
	add_image_size('px_media_2', 1102, 376, true);
	add_image_size('px_media_3', 1098, 260, true);
	add_image_size('px_media_4', 793, 401, true);
	add_image_size('px_media_5', 752, 226, true);
	add_image_size('cs_media_6', 530, 398, true);
	add_image_size('px_media_7', 370, 184, true);
	add_image_size('px_media_8', 302, 362, true);
	add_image_size('px_media_9', 240, 180, true);
	add_image_size('px_media_10', 236, 158, true);
  	
	// Admin scripts enqueue
	function px_admin_scripts_enqueue() {
		$template_path = get_template_directory_uri() . '/scripts/admin/media_upload.js';
		wp_enqueue_script('my-upload', $template_path, 
		array('jquery', 'media-upload', 'thickbox', 'jquery-ui-droppable', 'jquery-ui-datepicker', 'jquery-ui-slider', 'wp-color-picker'));
		wp_enqueue_script('custom_wp_admin_script', get_template_directory_uri() . '/scripts/admin/px_functions.js');
		wp_enqueue_style('custom_wp_admin_style', get_template_directory_uri() . '/css/admin/admin-style.css', array('thickbox'));
		wp_enqueue_style('custom_wp_admin_fontawesome_style', get_template_directory_uri() . '/css/admin/font-awesome.css', array('thickbox'));
		wp_enqueue_style('wp-color-picker');

	}

	// Backend functionality files
	require_once (TEMPLATEPATH . '/include/theme_activation.php');
	require_once (TEMPLATEPATH . '/include/admin_functions.php');
	require_once (TEMPLATEPATH . '/include/theme_colors.php');
 	require_once (TEMPLATEPATH . '/include/player.php');
	require_once (TEMPLATEPATH . '/include/pointtable.php');
	require_once (TEMPLATEPATH . '/include/event.php');
	require_once (TEMPLATEPATH . '/include/gallery.php');
	require_once (TEMPLATEPATH . '/include/page_builder.php');
	require_once (TEMPLATEPATH . '/include/post_meta.php');
	require_once (TEMPLATEPATH . '/include/widgets.php');

	
	/* Require Woocommerce */
	require_once (TEMPLATEPATH . '/include/config_woocommerce/config.php');
	require_once (TEMPLATEPATH . '/include/config_woocommerce/product_meta.php');
	/* Addmin Menu PX Theme Option */
	
	if (current_user_can('administrator')) {
		require_once (TEMPLATEPATH . '/include/theme_option.php');
		add_action('admin_menu', 'px_theme');
		function px_theme() {
			add_theme_page('PX Theme Option', 'PX Theme Option', 'read', 'px_theme_options', 'theme_option');
		}

	}
	$image_url = apply_filters( 'taxonomy-images-queried-term-image-url', '', array(
    'image_size' => 'medium'
    ) );

	// Template redirect in single Gallery and Slider page
	function px_slider_gallery_template_redirect(){
		
		if ( get_post_type() == "px_gallery" ) {
			global $wp_query;
			$wp_query->set_404();
			status_header( 404 );
			get_template_part( 404 );
			exit();
		}
	}

	// enque style and scripts
	function px_front_scripts_enqueue() {
		global $px_theme_option;
		
		if (!is_admin()) {
			wp_enqueue_style('style_css', get_template_directory_uri() . '/style.css');
			wp_enqueue_style('prettyPhoto_css', get_template_directory_uri() . '/css/prettyphoto.css');
			wp_enqueue_style('bootstrap_css', get_template_directory_uri() . '/css/bootstrap.css');
			wp_enqueue_style('font-awesome_css', get_template_directory_uri() . '/css/font-awesome.css');

			// Enqueue stylesheet
			wp_enqueue_style( 'wp-mediaelement' );
			wp_enqueue_script('jquery');
			wp_enqueue_script( 'wp-mediaelement' );
			wp_enqueue_script('bootstrap_js', get_template_directory_uri() . '/scripts/frontend/bootstrap.min.js', '', '', true);
			wp_enqueue_script('modernizr_js', get_template_directory_uri() . '/scripts/frontend/modernizr.js', '', '', true);
			wp_enqueue_script('prettyPhoto_js', get_template_directory_uri() . '/scripts/frontend/jquery.prettyphoto.js', '', '', true);
			wp_enqueue_script('functions_js', get_template_directory_uri() . '/scripts/frontend/functions.js', '0', '', false);
			
			
			if ( $px_theme_option['rtl_switcher'] == "on"){
				wp_enqueue_style('rtl_css', get_template_directory_uri() . '/css/rtl.css');
			}

			if ($px_theme_option['responsive'] == "on") {
				echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">';
				wp_enqueue_style('responsive_css', get_template_directory_uri() . '/css/responsive.css');
			}
		}
	}
	function px_enqueue_flexslider_script(){
		wp_enqueue_style('flexslider_css', get_template_directory_uri() . '/css/flexslider.css');
		wp_enqueue_script('flexslider_js', get_template_directory_uri() . '/scripts/frontend/jquery.flexslider-min.js', '', '', true);
	}
	// Gallery Script Enqueue
	function px_enqueue_cycle_script(){
		wp_enqueue_script('jquery.cycle2_js', get_template_directory_uri() . '/scripts/frontend/cycle2.js', '', '', true);
		
	}
	// Validation Script Enqueue
	function px_enqueue_validation_script(){
		wp_enqueue_script('jquery.validate.metadata_js', get_template_directory_uri() . '/scripts/admin/jquery.validate.metadata.js', '', '', true);
		wp_enqueue_script('jquery.validate_js', get_template_directory_uri() . '/scripts/admin/jquery.validate.js', '', '', true);
	}
	/* countdown enqueue */	
	function px_enqueue_countdown_script(){
		wp_enqueue_script('jquery.countdown_js', get_template_directory_uri() . '/scripts/frontend/jquery.countdown.js', '', '', true);
	}
	// add this share enqueue
	function px_addthis_script_init_method(){
		
		if( is_single()){
			wp_enqueue_script( 'px_addthis', 'http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e4412d954dccc64', '', '', true);
		}

	}
	// content class
	  
	  if ( ! function_exists( 'px_meta_content_class' ) ) {
		  function px_meta_content_class(){
			  global $px_meta_page;
			  
			  if ( $px_meta_page->sidebar_layout->px_layout == '' or $px_meta_page->sidebar_layout->px_layout == 'none' ) {
				  $content_class = "col-md-12";
				  
			  } else
			  if ( $px_meta_page->sidebar_layout->px_layout <> '' and $px_meta_page->sidebar_layout->px_layout == 'right' ) {
				  $content_class = "col-md-9";
				  
			  } else
			  if ( $px_meta_page->sidebar_layout->px_layout <> '' and $px_meta_page->sidebar_layout->px_layout == 'left' ) {
				  $content_class = "col-md-9";
				  
			  } else
			  if ( $px_meta_page->sidebar_layout->px_layout <> '' and ($px_meta_page->sidebar_layout->px_layout == 'both' or $px_meta_page->sidebar_layout->px_layout == 'both_left' or $px_meta_page->sidebar_layout->px_layout == 'both_right')) {
				  $content_class = "col-md-6";
				 
			  } else {
				  $content_class = "col-md-12";
			  }

			  return $content_class;
		  }

	  }
	// Favicon and header code in head tag//
	function px_footer_settings() {
		global $px_theme_option;
		echo htmlspecialchars_decode($px_theme_option['analytics']);
	}

	/* Page Sub header title and subtitle */	
	function get_subheader_title(){
		global $post, $wp_query;
		$show_title=true;
  		$get_title = '';
		if (is_page() || is_single()) {
			
			if (is_page() ){
				$px_xmlObject = px_meta_page('px_page_builder');
				if (isset($px_xmlObject)) {
					if($px_xmlObject->page_title == "on"){
						echo '<h1 class="pix-page-title">' . get_the_title(). '</h1>';
					}
				}else{
					echo '<h1 class="pix-page-title">' . get_the_title(). '</h1>';
				}
			}elseif (is_single()) {
				
				$post_type = get_post_type($post->ID);
				if ($post_type == "events") {
					$post_type = "px_event_meta";
				} else if($post_type == "player"){
					$post_type = "player";
				} else {
					$post_type = "post";
				}
				$post_xml = get_post_meta($post->ID, $post_type, true);
				
				if ($post_xml <> "") {
					$px_xmlObject = new SimpleXMLElement($post_xml);
				}
				if (isset($px_xmlObject)) {
 					echo '<h1 class="pix-page-title px-single-page-title">' . get_the_title(). '</h1>';
				}else{
					echo '<h1 class="pix-page-title px-single-page-title">' . get_the_title(). '</h1>';
 				}
			}
			
		} else {
		?>
 			<h1 class="pix-page-title"><?php px_post_page_title(); ?></h1>
 		 <?php 
		}

	}



	// search varibales start
	function px_get_search_results($query) {
		
		if ( !is_admin() and (is_search())) {
			$query->set( 'post_type', array('post', 'events', 'player') );
			remove_action( 'pre_get_posts', 'px_get_search_results' );
		}

	}

	// Filter shortcode in text areas
	
	if ( ! function_exists( 'px_textarea_filter' ) ) {
		
		function px_textarea_filter($content=''){
			return do_shortcode($content);
		}

	}

	// woocommerce ajax add to Cart 
	function woocommerce_header_add_to_cart_fragment( $fragments ) {
		
		if ( class_exists( 'woocommerce' ) ){
			global $woocommerce;
			ob_start();
			?>
            <div class="cart-sec">
                <a href="<?php  echo $woocommerce->cart->get_cart_url(); ?>">
                    <i class="fa fa-basket"></i><span><?php  echo $woocommerce->cart->cart_contents_count; ?></span>
                </a>
            </div>
			<?php
			$fragments['div.cart-sec'] = ob_get_clean();
			return $fragments;
		}

	}
	// woocommerce default cart
	function px_woocommerce_header_cart() {
		
		if ( class_exists( 'woocommerce' ) ){
			global $woocommerce;
			?>
		<div class="cart-sec">
			<a href="<?php  echo $woocommerce->cart->get_cart_url(); ?>">
            	<i class="fa fa-shopping-cart"></i><span><?php  echo $woocommerce->cart->cart_contents_count; ?></span>
            </a>
		</div>
		<?php
		}

	}

	// Display navigation to next/previous for single posts
	
	if ( ! function_exists( 'px_next_prev_post' ) ) {
		
		function px_next_prev_post(){
 			global $post;
			posts_nav_link();
			// Don't print empty markup if there's nowhere to navigate.
			$previous = ( is_attachment() ) ? get_post( $post->post_parent ) :
			get_adjacent_post( false, '', true );
			$next     = get_adjacent_post( false, '', false );
			echo '<div class="prev-nex-btn">';
				previous_post_link( '%link', '<i class="fa fa-angle-double-left"></i>' );
				next_post_link( '%link','<i class="fa fa-angle-double-right"></i>' );
			echo '</div>';
      		}

	}
	function px_posts_link_next_class($format){
		 $format = str_replace('href=', 'class="post-next" href=', $format);
		 return $format;
	}
	add_filter('next_post_link', 'px_posts_link_next_class');
	
	function px_posts_link_prev_class($format) {
		 $format = str_replace('href=', 'class="post-prev" href=', $format);
		 return $format;
	}
	add_filter('previous_post_link', 'px_posts_link_prev_class');
 	//	Add Featured/sticky text/icon for sticky posts.
 	if ( ! function_exists( 'px_featured()' ) ) {
		function px_featured(){
			global $px_transwitch,$px_theme_option;
		
			if ( is_sticky() ){
				?>
		<span class="featured">
        	<?php 
				if(!isset($px_theme_option) || (!isset($px_theme_option['lotrans_featuredgo']))){
						_e('Featured','Soccer Club');
				} else {
					if($px_theme_option['trans_switcher'] == "on"){
						_e('Featured','Soccer Club');
					} else {
						echo $px_theme_option['trans_featured'];
					}
				}
			?>		         
         </span>
		<?php
			}

		}

	}

	/* display post page title */	
	function px_post_page_title(){
		
		if ( is_author() ) {
			global $author;
			$userdata = get_userdata($author);
			echo __('Author', 'Soccer Club') . " " . __('Archives', 'Soccer Club') . ": ".$userdata->display_name;
		}
 		elseif ( is_tag() || is_tax('event-tag') || is_tax('portfolio-tag') || is_tax('sermon-tag') ) {
			echo __('Tags', 'Soccer Club') . " " . __('Archives', 'Soccer Club') . ": " . single_cat_title( '', false );
		}
 		elseif ( is_category() || is_tax('event-category') || is_tax('portfolio-category')  || is_tax('season-category')  || 
		is_tax('sermon-series')  || is_tax('sermon-pastors') ) {
			echo __('Categories', 'Soccer Club') . " " . __('Archives', 'Soccer Club') . ": " . single_cat_title( '', false );
		}
 		elseif( is_search()){
			printf( __( 'Search Results %1$s %2$s', 'Soccer Club' ), ': ','<span>' . get_search_query() . '</span>' );
		}
 		elseif ( is_day() ) {
			printf( __( 'Daily Archives: %s', 'Soccer Club' ), '<span>' . get_the_date() . '</span>' );
		}
 		elseif ( is_month() ) {
			printf( __( 'Monthly Archives: %s', 'Soccer Club' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'Soccer Club' ) ) . '</span>' );
		}
 		elseif ( is_year() ) {
			printf( __( 'Yearly Archives: %s', 'Soccer Club' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'Soccer Club' ) ) . '</span>' );
		}
 		elseif ( is_404()){
			_e( 'Error 404', 'Soccer Club' );
		}
 		elseif(!is_page()){
			_e( 'Archives', 'Soccer Club' );
		}

	}

	// Custom excerpt function 
	function px_get_the_excerpt($limit,$readmore = '') {
		global $px_theme_option;
		if(!isset($limit) || $limit == ''){ $limit = '255';}
		$get_the_excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU', '', get_the_excerpt()));
		echo '<p>'.substr($get_the_excerpt, 0, "$limit").'</p>';
		
		if (strlen($get_the_excerpt) > "$limit") {
			
			if($readmore == "true"){
				echo '... <a href="' . get_permalink() . '" class="colr">' . $px_theme_option['trans_read_more'] . '</a>';
			}

		}

	}

	// change the default query variable start
	function px_change_query_vars($query) {
		
		if (is_search() || is_home()) {
			
			if (empty($_GET['page_id_all']))$_GET['page_id_all'] = 1;
			$query->query_vars['paged'] = $_GET['page_id_all'];
		}
 		return $query;
		// Return modified query variables
	}

	/* custom pagination start */
	
	if ( ! function_exists( 'px_pagination' ) ) {
		function px_pagination($total_records, $per_page, $qrystr = '') {
			$html = '';
			$dot_pre = '';
			$dot_more = '';
			$total_page = ceil($total_records / $per_page);
			$loop_start = $_GET['page_id_all'] - 2;
			$loop_end = $_GET['page_id_all'] + 2;
			
			if ($_GET['page_id_all'] < 3) {
				$loop_start = 1;
				
				if ($total_page < 5)$loop_end = $total_page; else $loop_end = 5;
			} else
			if ($_GET['page_id_all'] >= $total_page - 1) {
				
				if ($total_page < 5)$loop_start = 1; else $loop_start = $total_page - 4;
				$loop_end = $total_page;
			}

			
			if ($_GET['page_id_all'] > 1)$html .= "<li>
			<a class='prev' href='?page_id_all=" . ($_GET['page_id_all'] - 1) . "$qrystr' >&lt;&lt;</a></li>";
			
			if ($_GET['page_id_all'] > 3 and $total_page > 5)$html .= "<li><a href='?page_id_all=1$qrystr'>1</a></li>";
			
			if ($_GET['page_id_all'] > 4 and $total_page > 6)$html .= "<li> <a>. . .</a> </li>";
			
			if ($total_page > 1) {
				for ($i = $loop_start; $i <= $loop_end; $i++) {
					
					if ($i <> $_GET['page_id_all'])$html .= "<li><a href='?page_id_all=$i$qrystr'>" . $i . "</a></li>"; else $html .= "<li>
					<span class='active'>" . $i . "</span></li>";
				}

			}
 			
			if ($loop_end <> $total_page and $loop_end <> $total_page - 1)$html .= "<li> <a>. . .</a> </li>";
			
			if ($loop_end <> $total_page)$html .= "<li><a href='?page_id_all=$total_page$qrystr'>$total_page</a></li>";
			
			if ($_GET['page_id_all'] < $total_records / $per_page)$html .= "<li><a class='next' href='?page_id_all=" . ($_GET['page_id_all'] + 1) . "$qrystr' >&gt;&gt;</a></li>";
			return $html;
		}

	}
	// pagination end
	// Social Share Function
	
	if ( ! function_exists( 'px_social_share' ) ) {
		function px_social_share($icon_type = '', $title='true') {
			global $px_theme_option;
			px_addthis_script_init_method();
			if ($px_theme_option['social_share'] == "on"){
				if($px_theme_option["trans_switcher"] == "on") { $html1= __("Share this post",'Soccer Club'); }else{  $html1 =  $px_theme_option["trans_share_this_post"];}
				$html = '';
					
					$html .='<a class="addthis_button_compact btn share-now pix-bgcolr"><i class="fa fa-share-square-o"></i>'.$html1.'</a>';
					
					
					
					$html .='<ul class="social-network">';
					
						$html .='<li><a class="addthis_button_facebook  fa fa-facebook-square"></a></li>';
					
					
						$html .='<li><a class="addthis_button_twitter fa fa-twitter-square"></a></li>';
					
					
						$html .='<li><a class="addthis_button_google fa fa-google-plus-square"></a></li>';
					
					
						$html .='<li><a class="addthis_button_pinterest fa fa-pinterest-square"></a></li>';
				
					
						$html .='<li><a class="addthis_button_tumblr fa fa-tumblr-square"></a></li>';
				
					
						$html .='<li><a class="addthis_button_linkedin fa fa-linkedin-square"></a></li>';
					
					
					$html .='</ul>';
					echo $html;
				
				 
			}
		}

	}

	// Social network
	
	if ( ! function_exists( 'px_social_network' ) ) {
		function px_social_network($icon_type='',$tooltip = ''){
			global $px_theme_option;
			$tooltip_data='';
			if($icon_type=='large'){
				$icon = '2x';
			} else {
				$icon = 'icon';
			}
			echo '<div class="followus">';
			if(isset($tooltip) && $tooltip <> ''){
				$tooltip_data='data-placement-tooltip="tooltip"';
			}
  			if ( isset($px_theme_option['social_net_url']) and count($px_theme_option['social_net_url']) > 0 ) {
				$i = 0;
				foreach ( $px_theme_option['social_net_url'] as $val ){
					if($val != ''){ ?>
                    	<a title="" href="<?php  echo $val; ?>" data-original-title="<?php  echo $px_theme_option['social_net_tooltip'][$i]; ?>" data-placement="top" <?php  echo $tooltip_data; ?> class="colrhover"  target="_blank">
						<?php  if($px_theme_option['social_net_awesome'][$i] <> '' && isset($px_theme_option['social_net_awesome'][$i])){ ?> 
                    <i class="fa <?php  echo $px_theme_option['social_net_awesome'][$i]; ?> <?php  echo $icon; ?>"></i><?php  } else { ?>
                    <img src="<?php  echo $px_theme_option['social_net_icon_path'][$i]; ?>" alt="<?php  echo $px_theme_option['social_net_tooltip'][$i]; ?>" /><?php  } ?></a>
					<?php 
					}
					$i++;
				}
			}
 			echo '</div>';
		}
	}

	// Post image attachment function
	function px_attachment_image_src($attachment_id, $width, $height) {
		$image_url = wp_get_attachment_image_src($attachment_id, array($width, $height), true);
		
		if ($image_url[1] == $width and $image_url[2] == $height); else        
		$image_url = wp_get_attachment_image_src($attachment_id, "full", true);
		$parts = explode('/uploads/',$image_url[0]);
		
		if ( count($parts) > 1 ) return $image_url[0];
	}

	// Post image attachment source function
	function px_get_post_img_src($post_id, $width, $height) {
		
		if(has_post_thumbnail()){
			$image_id = get_post_thumbnail_id($post_id);
			$image_url = wp_get_attachment_image_src($image_id, array($width, $height), true);
			
			if ($image_url[1] == $width and $image_url[2] == $height) {
				return $image_url[0];
			} else {
				$image_url = wp_get_attachment_image_src($image_id, "full", true);
				return $image_url[0];
			}

		}

	}

	// Get Post image attachment
	function px_get_post_img($post_id, $width, $height) {
		$image_id = get_post_thumbnail_id($post_id);
		$image_url = wp_get_attachment_image_src($image_id, array($width, $height), true);
		if ($image_url[1] == $width and $image_url[2] == $height) {
			return get_the_post_thumbnail($post_id, array($width, $height));
		} else {
			return get_the_post_thumbnail($post_id, "full");
		}
	}
	// custom sidebar start
	$px_theme_option = get_option('px_theme_option');
	
	if ( isset($px_theme_option['sidebar']) and !empty($px_theme_option['sidebar'])) {
		foreach ( $px_theme_option['sidebar'] as $sidebar ){
			register_sidebar(
				array(
					'name' => $sidebar,
					'id' => $sidebar,
					'description' => 'This widget will be displayed on right side of the page.',
					'before_widget' => '<div class="widget %2$s pix-content-wrap">',
					'after_widget' => '</div>',
					'before_title' => '<header class="pix-heading-title"><h2 class="pix-section-title heading-color">',
					'after_title' => '</h2></header>'
				)
			);
		}

	}
	register_sidebar( 
		array(
			'name' => 'Sidebar Widget',
			'id' => 'sidebar-1',
			'description' => 'This Widget Show the Content in Blog Listing page.',
			'before_widget' => '<div class="widget %2$s pix-content-wrap">',
			'after_widget' => '</div>',
			'before_title' => '<header class="pix-heading-title"><h2 class="pix-section-title">',
			'after_title' => '</h2></header>'
		) 
	);
	function px_add_menuid($ulid) {
		return preg_replace('/<ul>/', '<ul id="menus">', $ulid, 1);
	}
	function px_remove_div ( $menu ){
		return preg_replace( array( '#^<div[^>]*>#', '#</div>$#' ), '', $menu );
	}

	
	function px_register_my_menus() {
		register_nav_menus(array('main-menu'  => __('Main Menu','Soccer Club') )  );
	}

	
	function px_add_parent_css($classes, $item) {
		global $px_menu_children;
		
		if ($px_menu_children)        $classes[] = 'parent';
		return $classes;
	}
	
	// map shortcode with various options
		if ( ! function_exists( 'px_map_page' ) ) {
			function px_map_page(){
				global $px_node, $px_counter_node;
				if ( !isset($px_node->map_lat) or $px_node->map_lat == "" ) { $px_node->map_lat = 0; }
				if ( !isset($px_node->map_lon) or $px_node->map_lon == "" ) { $px_node->map_lon = 0; }
				if ( !isset($px_node->map_zoom) or $px_node->map_zoom == "" ) { $px_node->map_zoom = 11; }
				if ( !isset($px_node->map_info_width) or $px_node->map_info_width == "" ) { $px_node->map_info_width = 200; }
				if ( !isset($px_node->map_info_height) or $px_node->map_info_height == "" ) { $px_node->map_info_height = 100; }
				if ( !isset($px_node->map_show_marker) or $px_node->map_show_marker == "" ) { $px_node->map_show_marker = 'true'; }
				if ( !isset($px_node->map_controls) or $px_node->map_controls == "" ) { $px_node->map_controls = 'false'; }
				if ( !isset($px_node->map_scrollwheel) or $px_node->map_scrollwheel == "" ) { $px_node->map_scrollwheel = 'true'; }
				if ( !isset($px_node->map_draggable) or $px_node->map_draggable == "" )  { $px_node->map_draggable = 'true'; }
				if ( !isset($px_node->map_type) or $px_node->map_type == "" ) { $px_node->map_type = 'ROADMAP'; }
				if ( !isset($px_node->map_info)) { $px_node->map_info = ''; }
				if( !isset($px_node->map_marker_icon)){ $px_node->map_marker_icon = ''; }
				if( !isset($px_node->map_title)){ $px_node->map_title ='';}
				if( !isset($px_node->map_element_size) or $px_node->map_element_size == ""){ $px_node->map_element_size ='default';}
				if( !isset($px_node->map_height) || empty($px_node->map_height)){ $px_node->map_height ='360';}
			 
				$map_show_marker = '';
				if ( $px_node->map_show_marker == "true" ) { 
					$map_show_marker = " var marker = new google.maps.Marker({
								position: myLatlng,
								map: map,
								title: '',
								icon: '".$px_node->map_marker_icon."',
								shadow:''
							});
					";
				}
				$html = '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>';
				$html .= '<div class="element_size_'.$px_node->map_element_size.' px-map">';
					$html .= '<div class="pix-content-wrap"><div class="contact-us rich_editor_text"><div class="map-sec">';
					
					$html .= '<div class="mapcode iframe mapsection gmapwrapp" id="map_canvas'.$px_counter_node.'" style="height:'.$px_node->map_height.'px;"> </div>';
				$html .= '</div>';
				
				if($px_node->map_title <> ''){$html .= '<h2 class="pix-post-title">'.$px_node->map_title.'</h2>'; }

                   $html .= '<p>'.$px_node->map_text.'</p>';
				   $html .= '</div></div>';
				$html .= '</div>';   
				//mapTypeId: google.maps.MapTypeId.".$px_node->map_type." ,
				$html .= "<script type='text/javascript'>
							function initialize() {
								var styles = [
									{
									  stylers: [
										{ hue: '#000000' },
										{ saturation: -100 }
									  ]
									},{
									  featureType: 'road',
									  elementType: 'geometry',
									  stylers: [
										{ lightness: -40 },
										{ visibility: 'simplified' }
									  ]
									},{
									  featureType: 'road',
									  elementType: 'labels',
									  stylers: [
										{ visibility: 'on' }
									  ]
									}
								  ];
				var styledMap = new google.maps.StyledMapType(styles,
				{name: 'Styled Map'});
								var myLatlng = new google.maps.LatLng(".$px_node->map_lat.", ".$px_node->map_lon.");
								var mapOptions = {
									zoom: ".$px_node->map_zoom.",
									panControl: false,
									scrollwheel: ".$px_node->map_scrollwheel.",
									draggable: ".$px_node->map_draggable.",
									center: myLatlng,
									disableDefaultUI: true,
									disableDefaultUI: ".$px_node->map_controls.",
									mapTypeControlOptions: {
									  mapTypeIds: [google.maps.MapTypeId.ROADMAP.".$px_node->map_type.", 'map_style']
									}
								}
								var map = new google.maps.Map(document.getElementById('map_canvas".$px_counter_node."'), mapOptions);
								map.mapTypes.set('map_style', styledMap);
								map.setMapTypeId('map_style');
								var infowindow = new google.maps.InfoWindow({
									content: '".$px_node->map_info."',
									maxWidth: ".$px_node->map_info_width.",
									maxHeight:".$px_node->map_info_height.",
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
	
	if (!function_exists('pixFill_comment')) :
	/**
     * Template for comments and pingbacks.
     *
     * To override this walker in a child theme without modifying the comments template
     * simply create your own pixFill_comment(), and that function will be used instead.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     *
     */
	function pixFill_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		$args['reply_text'] = '<i class="fa fa-share"></i> Reply';
		switch ( $comment->comment_type ) :
		case '' :
			?>
        <li  <?php  comment_class(); ?> id="li-comment-<?php  comment_ID(); ?>">
            <div class="thumblist" id="comment-<?php  comment_ID(); ?>">
                <ul>
                    <li>
                        <figure>
                            <a href="#"><?php  echo get_avatar( $comment, 65 ); ?></a>
                        </figure>
                         <div class="text">
                          <header>
                                <?php  printf( __( '%s', 'Soccer Club' ), sprintf( '<h5><a class="colrhover">%s</a></h5><br>', get_comment_author_link() ) ); 						/* translators: 1: date, 2: time */								printf( __( '<span>%1$s</span><br/>', 'Soccer Club' ), get_comment_date());
	 							?>
                          </header>
                          <div class="bottom-comment">
							  <?php  comment_text(); ?>
                              <?php  edit_comment_link( __( '(Edit)', 'GreenPeace' ), ' ' ); ?>
                                    <?php  comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );                                	if ( $comment->comment_approved == '0' ) : ?>
                                    <div class="comment-awaiting-moderation colr">
                                        <?php  _e( 'Your comment is awaiting moderation.', 'GreenPeace' ); ?>
                                    </div>
                            <?php  endif; ?>
                           </div>
                        </div>
                    </li>
                </ul>
            </div>
         </li>
	<?php
    	break;
			case 'pingback'  :
			case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php  comment_author_link(); ?><?php  edit_comment_link( __( '(Edit)', 'Soccer Club' ), ' ' ); ?></p>
		<?php
		break;
		endswitch;
		}
		endif;
			// password protect post/page
			
			if ( ! function_exists( 'px_password_form' ) ) {
				function px_password_form() {
					global $post,$px_theme_option;
					$label = 'pwbox-'.( empty( $post->ID ) ? rand() :
					$post->ID );
					$o = '<div class="password_protected single-password pix-content-wrap">
									<h5>' . __( "This post is password protected. To view it please enter your password below:",'Soccer Club' ) . '</h5>';
									$o .= '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
												<label><input name="post_password" id="' . $label . '" type="password" size="20" /></label>
												<input class="backcolr" type="submit" name="Submit" value="'.__("Submit", "Soccer Club").'" />
											</form></div>';
					return $o;
			}

		}

		// breadcrumb function
		
		if ( ! function_exists( 'px_breadcrumbs' ) ) {
			
			function px_breadcrumbs() {
				global $wp_query;
				/* === OPTIONS === */
				$text['home']     = 'Home';
				// text for the 'Home' link
				$text['category'] = '%s';
				// text for a category page
				$text['search']   = '%s';
				// text for a search results page
				$text['tag']      = '%s';
				// text for a tag page
				$text['author']   = '%s';
				// text for an author page
				$text['404']      = 'Error 404';
				// text for the 404 page
				$showCurrent = 1;
				// 1 - show current post/page title in breadcrumbs, 0 - don't show
				$showOnHome  = 1;
				// 1 - show breadcrumbs on the homepage, 0 - don't show
				$delimiter   = '';
				// delimiter between crumbs
				$before      = '<li class="pix-active">';
				// tag before the current crumb
				$after       = '</li>';
				// tag after the current crumb
				/* === END OF OPTIONS === */
				global $post;
				$homeLink = home_url() . '/';
				$linkBefore = '<li>';
				$linkAfter = '</li>';
				$linkAttr = '';
				$link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;
				$linkhome = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;
				
				if (is_home() || is_front_page()) {
					
					if ($showOnHome == "1") echo '<div class="breadcrumbs"><ul>'.$before.'<a href="' . $homeLink . '">' . $text['home'] . '</a>'.$after.'</ul></div>';
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
					}

					elseif ( is_search() ) {
						echo $before . sprintf($text['search'], get_search_query()) . $after;
					}

					elseif ( is_day() ) {
						echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
						echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
						echo $before . get_the_time('d') . $after;
					}

					elseif ( is_month() ) {
						echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
						echo $before . get_the_time('F') . $after;
					}

					elseif ( is_year() ) {
						echo $before . get_the_time('Y') . $after;
					}

					elseif ( is_single() && !is_attachment() ) {
						
						if ( get_post_type() != 'post' ) {
							$post_type = get_post_type_object(get_post_type());
							$slug = $post_type->rewrite;
							printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
							
							if ($showCurrent == 1) echo $delimiter . $before . 'Current Page' . $after;
						} else {
							$cat = get_the_category();
							$cat = $cat[0];
							$cats = get_category_parents($cat, TRUE, $delimiter);
							
							if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
							$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
							$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
							echo $cats;
							
							if ($showCurrent == 1) echo $before .'Current Page' . $after;
						}

					}

					elseif ( !is_single() && !is_page() && get_post_type() <> '' && get_post_type() != 'post' && get_post_type() <> 'events' && get_post_type() <> 'px_menu' && !is_404() ) {
						$post_type = get_post_type_object(get_post_type());
						echo $before . $post_type->labels->singular_name . $after;
					}

					elseif (isset($wp_query->query_vars['taxonomy']) && !empty($wp_query->query_vars['taxonomy'])){
						$taxonomy = $taxonomy_category = '';
						$taxonomy = $wp_query->query_vars['taxonomy'];
						echo $before . $wp_query->query_vars[$taxonomy] . $after;
					}

					elseif ( is_page() && !$post->post_parent ) {
						
						if ($showCurrent == 1) echo $before . get_the_title() . $after;
					}

					elseif ( is_page() && $post->post_parent ) {
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
					}

					elseif ( is_tag() ) {
						echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
					}

					elseif ( is_author() ) {
						global $author;
						$userdata = get_userdata($author);
						echo $before . sprintf($text['author'], $userdata->display_name) . $after;
					}

					elseif ( is_404() ) {
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
 		
		if ( ! function_exists( 'px_logo' ) ) {
			function px_logo($logo_url, $log_width, $logo_height){
			?>
				<a href="<?php  echo home_url(); ?>">
                	<img src="<?php  echo $logo_url; ?>"  style="width:<?php  echo $log_width; ?>px; height:<?php  echo $logo_height; ?>px" 
                    alt="<?php  echo bloginfo('name'); ?>" />
                </a>
	 		<?php
			}

		}
		/*Top and Main Navigation*/
		if ( ! function_exists( 'px_navigation' ) ) {
			function px_navigation($nav='', $menus = 'menus'){
				global $px_theme_option;
				// Menu parameters	
				$defaults = array('theme_location' => "$nav",'menu' => '','container' => '','container_class' => '','container_id' => '','menu_class' => '','menu_id' => "$menus",'echo' => false,'fallback_cb' => 'wp_page_menu','before' => '','after' => '','link_before' => '','link_after' => '','items_wrap' => '<ul id="%1$s">%3$s</ul>','depth' => 0,'walker' => '',);
				echo do_shortcode(wp_nav_menu($defaults));
			}

		}
	  // Column shortcode with 2/3/4 column option even you can use shortcode in column shortcode
	  
	  if ( ! function_exists( 'px_column_page' ) ) {
		  function px_column_page(){
			  global $px_node;
			  $html = '<div class="element_size_'.$px_node->column_element_size.' column">';
			  $html .= do_shortcode($px_node->column_text);
			  if($px_node->column_donate_text <> ""){
			  $html .='<a style=" cursor:pointer; color:#FFF ;" target="_blank" class="donate-btn square" href="'.$px_node->column_donate_url.'">'.$px_node->column_donate_text.'</a>';
			  }
			  $html .= '</div>';
			  echo $html;
		  }

	  }

  // Get post meta in xml form
  function px_meta_page($meta) {
	  global $px_meta_page;
	  $meta = get_post_meta(get_the_ID(), $meta, true);
	  if ($meta <> '') {
		  $px_meta_page = new SimpleXMLElement($meta);
		  return $px_meta_page;
	  }
	  
  }
  // woocommerce shop meta
  function px_meta_shop_page($meta, $id) {
	  global $px_meta_page;
	  $meta = get_post_meta($id, $meta, true);
		  if ($meta <> '') {
			  $px_meta_page = new SimpleXMLElement($meta);
			  return $px_meta_page;
		  }
	  }


// function check mobile version

function px_mobile_check(){


		// Check the server headers to see if they're mobile friendly
		if(isset($_SERVER["HTTP_X_WAP_PROFILE"])) {
			return 'Yes';
		}
		
		// If the http_accept header supports wap then it's a mobile too
		if(preg_match("/wap\.|\.wap/i",$_SERVER["HTTP_ACCEPT"])) {
			return 'Yes';
		}
		
		// Still no luck? Let's have a look at the user agent on the browser. If it contains
		// any of the following, it's probably a mobile device. Kappow!
		if(isset($_SERVER["HTTP_USER_AGENT"])){
			$user_agents = array("midp", "j2me", "avantg", "docomo", "novarra", "palmos", "palmsource", "240x320", "opwv", "chtml", "pda", "windows\ ce", "mmp\/", "blackberry", "mib\/", "symbian", "wireless", "nokia", "hand", "mobi", "phone", "cdm", "up\.b", "audio", "SIE\-", "SEC\-", "samsung", "HTC", "mot\-", "mitsu", "sagem", "sony", "alcatel", "lg", "erics", "vx", "NEC", "philips", "mmm", "xx", "panasonic", "sharp", "wap", "sch", "rover", "pocket", "benq", "java", "pt", "pg", "vox", "amoi", "bird", "compal", "kg", "voda", "sany", "kdd", "dbt", "sendo", "sgh", "gradi", "jb", "\d\d\di", "moto");
			foreach($user_agents as $user_string){
				if(preg_match("/".$user_string."/i",$_SERVER["HTTP_USER_AGENT"])) {
					return 'Yes';
				}
			}
		}
		
		// Let's NOT return "mobile" if it's an iPhone, because the iPhone can render normal pages quite well.
		if(preg_match("/iphone/i",$_SERVER["HTTP_USER_AGENT"])) {
			return 'No';
		}
		
		// None of the above? Then it's probably not a mobile device.
		return 'No';

}

// site background options

function px_background_options(){
	global $px_theme_option, $px_node, $post;
	$varto_bg_option = $px_xmlObject = '';
	$mobile_browser = px_mobile_check();
	if(is_page()){
		$px_page_bulider = get_post_meta($post->ID, "px_page_builder", true);
		if ( $px_page_bulider <> "" ) {
			$px_xmlObject = new stdClass();
			$px_xmlObject = new SimpleXMLElement($px_page_bulider);
			$varto_bg_option = $px_xmlObject->var_post_bg_option;
		}
	} else if(is_single()){
		$post_xml = get_post_meta($post->ID, "post", true);
		$post_type = get_post_type($post->ID);
		if ($post_type == "events") {
			$post_type = "px_event_meta";
		} else if($post_type == "player") {
			$post_type = "px_player";
		} else {
			$post_type = "post";
		}
 		$post_xml = get_post_meta($post->ID, $post_type, true);
		if ( $post_xml <> "" ) {
			$px_xmlObject = new SimpleXMLElement($post_xml);
			$varto_bg_option = $px_xmlObject->var_post_bg_option;
		}	
	}
	if(isset($varto_bg_option) && $varto_bg_option <> '' && $varto_bg_option <> 'default-options'){
		$px_node = new stdClass();
		if($varto_bg_option == "background_video" && $mobile_browser == 'No'){
			px_background_video($varto_bg_option, $px_xmlObject->px_home_v2_video, $px_xmlObject->px_home_v2_video_mute);
		} elseif($varto_bg_option == "custom-background-image"){
			echo '<div class="bg-img" id="px_background_img" style="background-image:url('.$px_xmlObject->bg_image.'); position:fixed; z-index:1; top:0; height: 100%; width: 100%;"></div>';
		
		} else {
			echo '<div class="bg-color" id="px_background_color" style="background-color:'.$px_xmlObject->bg_color.'; position:fixed; z-index:1; top:0; height: 100%; width: 100%;"></div>';
		}
	} else {
		$px_node = new stdClass();
		$varto_bg_option = $px_theme_option['varto_bg_option'];
		if($varto_bg_option == "background_video" && $mobile_browser == 'No'){
			px_background_video($varto_bg_option, $px_theme_option['px_home_v2_video'], $px_theme_option['px_home_v2_video_mute'], 'default_video_option');
		} elseif($varto_bg_option == "custom-background-image"){
			echo '<div class="bg-img" id="px_background_img" style="background-image:url('.$px_theme_option['bg_image'].'); position:fixed; z-index:1; top:0; height: 100%; width: 100%;"></div>';
		} else if($varto_bg_option == "no-image") {
			echo '<div class="bg-color" id="px_background_color" style="background-color:'.$px_theme_option['bg_color'].'; position:fixed; z-index:1; top:0; height: 100%; width: 100%;"></div>';
		}
	}
}
// parse vimeo url
function px_parse_vimeo($link){
 
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
  // parse youtube url
  function px_parse_yturl($url) 
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

  function px_videoType($url) {
    if (strpos($url, 'youtube') > 0) {
        return 'youtube';
    } elseif (strpos($url, 'vimeo') > 0) {
        return 'vimeo';
    } else {
        return 'unknown';
    }
}
// Background video option

function px_background_video($varto_bg_option, $px_home_v2_video, $px_home_v2_video_mute, $default_video_class=''){
	 	global $post,$px_theme_option; 
	$no_image ='';
	if($varto_bg_option=='background_video'){
		?>
		<div class="wrapper-banner-home-v2 wrapper-banner-home-main <?php echo $default_video_class;?>">
        <?php
		if(isset($px_home_v2_video) && $px_home_v2_video <> ''){
			
			if(px_videoType($px_home_v2_video)=='vimeo'){
				if($px_home_v2_video_mute == 'Yes'){
					$video_volume = '0';
				} else {
					$video_volume = '60';
				}
			?>
			<div id="videowrapper" style="opacity:0">
				<span class="pattrenbg"></span>
<iframe id="fullplayer" class="vimeo-player" src="http://player.vimeo.com/video/<?php echo px_parse_vimeo($px_home_v2_video);?>?api=1&amp;title=0&amp;byline=0&amp;portrait=0&amp;playbar=0&amp;amp;loop=1&amp;player_id=fullplayer" width="100%" height="100%" webkitAllowFullScreen mozallowfullscreen allowFullScreen="true"></iframe>
		</div>
 	
 	<script src="http://a.vimeocdn.com/js/froogaloop2.min.js"></script> 
		<script>

		jQuery(document).ready(function($) {
			jQuery(window).load(function() {
				jQuery('iframe.vimeo-player').each(function(){
					jQuery("#videowrapper").css({
						"opacity":"1"
					})
			$f(this).addEvent('ready', ready);

			});
			});
		// Enable the API on each Vimeo video

			resizevideo ();
			jQuery(window).resize(function() {
			resizevideo ();
			});
		});
		function ready(player_id){
		  $f(player_id).api('setVolume',<?php echo $video_volume;?>);
		    $f(player_id).api('play');
		}


		function resizevideo () {
				jQuery("#videowrapper").each(function(index, el) {
				var windowW = jQuery(window).width();
				var windowH = jQuery(window).height();
				var mediaAspect = 16/9;
				var vidEl  = jQuery(this).find("video")
				var embEl  = jQuery(this).find("iframe")
				var windowAspect = windowW/windowH;
				if (windowAspect < mediaAspect) {
                // taller
                     jQuery(this)
                        .width(windowH*mediaAspect)
                        .height(windowH);
                    jQuery(vidEl)
                        .css('top',0)
                        .css('left',-(windowH*mediaAspect-windowW)/2)
                        .css('height',windowH);
                        jQuery(embEl)
                        .css('top',0)
                        .css('left',-(windowH*mediaAspect-windowW)/2)
                        .css('height',windowH);
            	 } else {
                // wider
                     jQuery(this)
                        .width(windowW)
                        .height(windowW/mediaAspect);
                    jQuery(vidEl)
                        .css('top',-(windowW/mediaAspect-windowH)/2)
                        .css('left',0)
                        .css('height',windowW/mediaAspect);
                    jQuery(embEl)
                        .css('top',-(windowW/mediaAspect-windowH)/2)
                        .css('left',0)
                        .css('height',windowW/mediaAspect);    
                  
           			 }
                    });       
                 }
		</script>
        <?php } else if(px_videoType($px_home_v2_video)=='youtube'){
			if($px_home_v2_video_mute == 'Yes'){
					$video_volume = 'true';
				} else {
					$video_volume = 'false';
				}
			
			?>
			
			<div id="videowrapper" style="opacity:1">
				<video width="100%" height="100%" id="player1" preload="none" autoplay="true" loop="true" >
					<source type="video/youtube" src="http://www.youtube.com/watch?v=<?php echo px_parse_yturl($px_home_v2_video);?>"  />
				</video>
				<span class="pattrenbg"></span>
			</div>
			<script> 
		
				jQuery(document).ready(function($) {
			 		// declare object for video
					jQuery('#player1').mediaelementplayer({
					// shows debug errors on screen
						success: function (mediaElement, domObject) { 
							mediaElement.addEventListener('play', function (e) {
							mediaElement.setMuted(<?php echo $video_volume;?>)
						}, true);
						mediaElement.addEventListener('ended', function (e) {
							mediaElement.play()
						}, true);
						}
						
					});
			 		resizevideo ()
			 	});
			
			 function resizevideo () {
				jQuery("#videowrapper").each(function(index, el) {
				var windowW = jQuery(window).width();
				var windowH = jQuery(window).height();
				var mediaAspect = 16/9;
				var vidEl  = jQuery(this).find("video")
				var embEl  = jQuery(this).find("iframe")
				var windowAspect = windowW/windowH;
				if (windowAspect < mediaAspect) {
                // taller
                     jQuery(this)
                        .width(windowH*mediaAspect)
                        .height(windowH);
                    jQuery(vidEl)
                        .css('top',0)
                        .css('left',-(windowH*mediaAspect-windowW)/2)
                        .css('height',windowH);
                        jQuery(embEl)
                        .css('top',0)
                        .css('left',-(windowH*mediaAspect-windowW)/2)
                        .css('height',windowH);
            	 } else {
                // wider
                     jQuery(this)
                        .width(windowW)
                        .height(windowW/mediaAspect);
                    jQuery(vidEl)
                        .css('top',-(windowW/mediaAspect-windowH)/2)
                        .css('left',0)
                        .css('height',windowW/mediaAspect);
                    jQuery(embEl)
                        .css('top',-(windowW/mediaAspect-windowH)/2)
                        .css('left',0)
                        .css('height',windowW/mediaAspect);    
                  
           			 }
                    });       
                 }
			</script>
		<?php }?>
        <?php	} ?>	
        
    </div>
	<?php

	}	
}

function px_author_description(){
	if (get_the_author_meta('description')){ ?>
    	<!-- About Author -->
        <div class="pix-content-wrap">   
        	<div class="about-author">
                <!-- Thumbnail List Start -->
                <!-- Thumbnail List Item Start -->
                 <figure><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="float-left"><?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('PixFill_author_bio_avatar_size', 90)); ?></a></figure>
                 <div class="text">
                    <h2><a class="colrhover" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author_meta('nicename'); ?></a></h2>
                    <span></span>
                    <p><?php the_author_meta('description'); ?></p>
                    <div class="followus">
                        <?php if(get_the_author_meta('flicker') <> ''){?><a href="<?php the_author_meta('flicker'); ?>"><i class="fa fa-flickr-square"></i></a><?php }?>
                        <?php if(get_the_author_meta('twitter') <> ''){?><a href="<?php the_author_meta('twitter'); ?>"><i class="fa fa-twitter-square"></i></a><?php }?>
                        <?php if(get_the_author_meta('facebook') <> ''){?><a href="<?php the_author_meta('facebook'); ?>"><i class="fa fa-facebook-square"></i></a><?php }?>
                        <?php if(get_the_author_meta('googleplus') <> ''){?><a href="<?php the_author_meta('googleplus'); ?>"><i class="fa fa-google-plus-square"></i></a><?php }?>
                        <?php if(get_the_author_meta('linkedin') <> ''){?><a href="<?php the_author_meta('linkedin'); ?>"><i class="fa fa-linkedin-square"></i></a><?php }?>
            		</div>
                </div>
            </div>
        </div>    
       <!-- About Author End -->
    <?php	 
	} 
}

//
 function px_next_prev_custom_links($post_type = 'pointable'){
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
		if (isset($previd) &&  !empty($previd) && $previd >=0 ) {
		   ?>
		   <a href="<?php echo get_permalink($previd); ?>" class="pix-bgcolrhvr"><i class="fa fa-angle-double-left"></i></a>
            
            <?php
		}
		
		if (isset($nextid) &&   !empty($nextid) ) {
			?>
            <a href="<?php echo get_permalink($nextid); ?>" class="pix-bgcolrhvr"><i class="fa fa-angle-double-right"></i></a>
            
            <?php	
		}

	 wp_reset_query();
 }
 
// news announcement 
if ( ! function_exists( 'fnc_announcement' ) ) {
	function fnc_announcement(){
		global $post,$px_theme_option;
		$image_url = '';
			$blog_category = $px_theme_option['announcement_blog_category'];
        	$announcement_no_posts = $px_theme_option['announcement_no_posts'];
         	if(isset($blog_category) && $blog_category <> '0'){
				if (empty($announcement_no_posts)){ $announcement_no_posts  = 5;}
				$args = array('posts_per_page' => "$announcement_no_posts", 'category_name' => "$blog_category",'post_status' => 'publish');
				$custom_query = new WP_Query($args);
				if($custom_query->have_posts()):
				
			    px_enqueue_cycle_script();
	?>
     <div id="carouselarea">
     	<div class="container">
    		<div class="news-carousel">
             <header class="pix-heading-title">
                        <h2 class="pix-section-title"><?php echo $px_theme_option['announcement_title'];?></h2>
                    </header>
                    <div class="center">
                        <span class="cycle-prev" id="cycle-next"><i class="fa fa-angle-right"></i></span>
                        <span class="cycle-next" id="cycle-prev"><i class="fa fa-angle-left"></i></span>
                    </div>
                     <div class="cycle-slideshow news-section"
                    data-cycle-fx=carousel
                    data-cycle-next="#cycle-next"
                    data-cycle-prev="#cycle-prev"
                    data-cycle-slides=">article"
                    data-cycle-timeout=3000>
					<?php 
                        while ($custom_query->have_posts()) : $custom_query->the_post();
						$image_url = px_get_post_img_src($post->ID,240,180);
                        ?>
                        <article>
                        	<?php if($image_url <> ""){?>
                                        <figure><a href="<?php the_permalink(); ?>"><img src="<?php echo $image_url;?>" alt=""></a></figure>
                                    <?php }?>
                            <div class="text">
                                <h2> <a href="<?php the_permalink();?>"><?php echo px_title_lenght(get_the_title(),0,30);?></a></h2>
                            </div>
                           
                        </article>
                    <?php endwhile;?>
         		</div>
          	</div>
    	</div>
    </div>
    <?php endif; wp_reset_query(); 
	}
	}
}
// posts/pages title lenght limit
function px_title_lenght($str ='',$start =0,$length =30){
	return substr($str,$start,$length);
}
// Default pages listing article
function px_defautlt_artilce(){
	global $post,$px_theme_option;
	?>
         <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
            <div class="text">
                <h2 class="pix-post-title"><a href="<?php the_permalink(); ?>" class="pix-colrhvr"><?php the_title(); ?></a></h2>
                <p><?php echo px_get_the_excerpt(255,false); ?></p>
               <div class="blog-bottom">
			   <?php px_posted_on(true,false,false,false,true,false);?>
               <a href="<?php the_permalink(); ?>" class="btnreadmore btn pix-bgcolrhvr"><i class="fa fa-plus"></i><?php if(isset($px_theme_option['trans_read_more'])) echo $px_theme_option['trans_read_more'];?></a>
               </div>
            </div>
        </article>

    <?php
	
}
// header search function
function px_search(){
	?>
	<form id="searchform" method="get" action="<?php echo home_url()?>"  role="search">
		<button> <i class="fa fa-search"></i></button>
        <input name="s" id="searchinput" value="<?php _e('Search for:', 'Soccer Club'); ?>" type="text" />
    </form>
<?php

}
// post date/categories/tags
if ( ! function_exists( 'px_posted_on' ) ) {
	function px_posted_on($cat=true,$tag=true,$comment=true,$date=true,$author=true,$icon=true){
		global $px_theme_option;
		?>
 		<ul class="post-options">
        	<?php if($author == "true"){?>
                <li> 
                    <span><?php printf( __('By: %s','Soccer Club'), ''); ?> </span><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"> <?php echo get_the_author(); ?></a>,
                </li>
                <?php } ?>
                 <li>
                 	<?php if($icon==true){ echo '<i class="fa fa-calendar"></i>'; } ?>
                    <time datetime="<?php echo date('d-m-y',strtotime(get_the_date()));?>"><?php echo get_the_date();?></time>
                </li>
				<?php
				/* translators: used between list items, there is a space after the comma */
				$trans_in = "";
				if($cat==true){
					if($px_theme_option['trans_switcher'] == "on"){ $trans_in =__('in','Soccer Club');}else{ $trans_in = $px_theme_option['trans_listed_in']; }
					  $before_cat = "<li><span>".$trans_in."</span> ";
					$categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '</li>' );
					if ( $categories_list ){
						printf( __( '%1$s', 'Soccer Club'),$categories_list );
					}
				}
				/* translators: used between list items, there is a space after the comma */
				if($tag == true){
					$before_tag = "<li>".__( 'tags ','Soccer Club')."";
					$tags_list = get_the_term_list ( get_the_id(), 'post_tag', $before_tag, ', ', '</li>' );
					if ( $tags_list ){
						printf( __( '%1$s', 'Soccer Club'),$tags_list );
					} // End if categories 
				}
				if($comment == true){
					if ( comments_open() ) {  
						echo "<li>"; comments_popup_link( __( '0 Comment', 'Soccer Club' ) , __( '1 Comment', 'Soccer Club' ), __( '% Comments', 'Soccer Club' ) ); 
					}
				}
				echo '<li>';
					px_featured();
				echo '<li>';
				edit_post_link( __( 'Edit', 'Soccer Club'), '<li>', '</li>' ); 
			?>
		</ul>
	<?php
	}
}
// footer show partner
function px_show_partner(){
		global $px_theme_option;
		$gal_album_db =$px_theme_option['partners_gallery'];
		?>
        <?php if($gal_album_db <> "0" and $gal_album_db <> '' and $px_theme_option['partners_title'] <> ''){?>
        <div class="our-sponcers lightbox">
        	<div class="container">
            <?php  
				if($px_theme_option['partners_title'] <> ''){ ?>
            		<header>
                        <h3><?php  echo $px_theme_option['partners_title']; ?></h3>
                    </header>
            <?php  } 
				if($gal_album_db <> "0" and $gal_album_db <> ''){
			?>
           	<div class="flexslider">
            	<ul class="slides">
                <?php
                    // galery slug to id start
                    $args=array(
                    'name' => $gal_album_db,
                    'post_type' => 'px_gallery',
                    'post_status' => 'publish',
                    'showposts' => 2,
                    );
                    $get_posts = get_posts($args);
                    if($get_posts){
                    $gal_album_db = $get_posts[0]->ID;
                    }
                    // galery slug to id end	
                    $px_meta_gallery_options = get_post_meta($gal_album_db, "px_meta_gallery_options", true);
                    // pagination start
                    if ( $px_meta_gallery_options <> "" ) {
                    $xmlObject = new SimpleXMLElement($px_meta_gallery_options);
                    $limit_start = 0;
                    $limit_end = count($xmlObject);
                        for ( $i = $limit_start; $i < $limit_end; $i++ ) {
                            $path = $xmlObject->gallery[$i]->path;
                            $title = $xmlObject->gallery[$i]->title;
                            $description = $xmlObject->gallery[$i]->description;
                            $use_image_as = $xmlObject->gallery[$i]->use_image_as;
                            $video_code = $xmlObject->gallery[$i]->video_code;
                            $link_url = $xmlObject->gallery[$i]->link_url;
                            //$image_url = wp_get_attachment_image_src($path, array(438,288),false);
                            $image_url = px_attachment_image_src($path, 150, 150);
                            //$image_url_full = wp_get_attachment_image_src($path, 'full',false);
                            $image_url_full = px_attachment_image_src($path, 0, 0);
                            ?>
                            <li>
                                <a href="<?php if($use_image_as==1)echo $video_code; 
                                elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" 
                                target="<?php if($use_image_as==2) { echo '_blank'; } else {echo '_self'; }?>" 
                                data-rel="<?php  if($use_image_as==1)echo "prettyPhoto1";
                                elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery2]" ?>">
                                <?php  echo "<img src='".$image_url."' alt='".$title."' />"; ?>
                                </a>
                            </li>
                            <?php
                        }
                    } else {
                      echo '<h4 class="pix-heading-color">'.__( 'No results found.', 'Soccer Club' ).'</h4>';
                    }
                ?>
               	</ul>
        	</div>
         	<?php  px_enqueue_flexslider_script(); ?>
            	<script type="text/javascript">
                    jQuery(window).load(function(){
                        jQuery('.our-sponcers .flexslider').flexslider({
                        	animation: "slide",
							itemWidth: 154,
							itemMargin: 0,
							prevText: "",
							nextText: "",
							slideshowSpeed: 4000
                       });
                    });
                </script>
                
           <?php } ?>     
        </div>
    </div>
    	<?php }  ?>
 	<?php 
	}
//
function px_footer_tweets($username = '', $numoftweets = ''){
	global $px_theme_option;
	if($numoftweets == '' or !is_numeric($numoftweets)){$numoftweets = 1;}
		
		echo "<div class='twitter_sign'>";
			if(strlen($username) > 1){
				echo "<figure><i class='fa fa-twitter'></i></figure>";
				$text ='';
				$return = '';
				require_once "include/twitteroauth/twitteroauth.php"; //Path to twitteroauth library
				$consumerkey = $px_theme_option['consumer_key'];
				$consumersecret = $px_theme_option['consumer_secret'];
				$accesstoken = $px_theme_option['access_token'];
				$accesstokensecret = $px_theme_option['access_token_secret'];
				$connection = new TwitterOAuth($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
				$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$username."&count=".$numoftweets);
 				?>
                <?php  px_enqueue_flexslider_script(); ?>
				<script type="text/javascript">
					jQuery(document).ready(function() {
						jQuery(".twitter_sign .flexslider").flexslider({
							animation: "fade",
							prevText: "",
							nextText: "",
							slideshowSpeed: 3000
						});
					});
				</script>
                <?php
					if(!is_wp_error($tweets) and is_array($tweets)){
 						$return .= "<div class='flexslider'><ul class='slides'>";
						foreach($tweets as $tweet) {
							$text = $tweet->{'text'};
							foreach($tweet->{'user'} as $type => $userentity) {
							if($type == 'profile_image_url') {	
								$profile_image_url = $userentity;
							} else if($type == 'screen_name'){
								$screen_name = '<a href="https://twitter.com/' . $userentity . '" target="_blank" class="cs-colrhvr" title="' . $userentity . '">@' . $userentity . '</a>';
							}
						}
						foreach($tweet->{'entities'} as $type => $entity) {
						if($type == 'urls') {						
							foreach($entity as $j => $url) {
								$display_url = '<a href="' . $url->{'url'} . '" target="_blank" title="' . $url->{'expanded_url'} . '">' . $url->{'display_url'} . '</a>';
								$update_with = 'Read more at '.$display_url;
								$text = str_replace('Read more at '.$url->{'url'}, '', $text);
								$text = str_replace($url->{'url'}, '', $text);
							}
						} else if($type == 'hashtags') {
							foreach($entity as $j => $hashtag) {
								$update_with = '<a href="https://twitter.com/search?q=%23' . $hashtag->{'text'} . '&src=hash" target="_blank" title="' . $hashtag->{'text'} . '">#' . $hashtag->{'text'} . '</a>';
								$text = str_replace('#'.$hashtag->{'text'}, $update_with, $text);
							}
						} else if($type == 'user_mentions') {
							foreach($entity as $j => $user) {
								  $update_with = '<a href="https://twitter.com/' . $user->{'screen_name'} . '" target="_blank" title="' . $user->{'name'} . '">@' . $user->{'screen_name'} . '</a>';
								  $text = str_replace('@'.$user->{'screen_name'}, $update_with, $text);
							}
						}
					} 
					$large_ts = time();
					$n = $large_ts - strtotime($tweet->{'created_at'});
					if($n < (60)){ $posted = sprintf(__('%d seconds ago','Soccer Club'),$n); }
					elseif($n < (60*60)) { $minutes = round($n/60); $posted = sprintf(_n('About a Minute Ago','%d Minutes Ago',$minutes,'Soccer Club'),$minutes); }
					elseif($n < (60*60*16)) { $hours = round($n/(60*60)); $posted = sprintf(_n('About an Hour Ago','%d Hours Ago',$hours,'Soccer Club'),$hours); }
					elseif($n < (60*60*24)) { $hours = round($n/(60*60)); $posted = sprintf(_n('About an Hour Ago','%d Hours Ago',$hours,'Soccer Club'),$hours); }
					elseif($n < (60*60*24*6.5)) { $days = round($n/(60*60*24)); $posted = sprintf(_n('About a Day Ago','%d Days Ago',$days,'Soccer Club'),$days); }
					elseif($n < (60*60*24*7*3.5)) { $weeks = round($n/(60*60*24*7)); $posted = sprintf(_n('About a Week Ago','%d Weeks Ago',$weeks,'Soccer Club'),$weeks); } 
					elseif($n < (60*60*24*7*4*11.5)) { $months = round($n/(60*60*24*7*4)) ; $posted = sprintf(_n('About a Month Ago','%d Months Ago',$months,'Soccer Club'),$months);}
					elseif($n >= (60*60*24*7*4*12)){$years=round($n/(60*60*24*7*52)) ; $posted = sprintf(_n('About a year Ago','%d years Ago',$years,'Soccer Club'),$years);} 
					$user = $tweet->{'user'};
					$return .="<li><article><div class='text'>";
					$return .= " <h2 class='cs-post-title'>" . $text . "<time datetime='2011-01-12'> (" . $posted. ")</time></h2>";
					$return .="</div>";
  					$return .= " </article></li>";
					}
					echo $return;
						
						echo '</ul></div>';
 					
		}else{
			if(isset($tweets->errors[0]) && $tweets->errors[0] <> ""){
				echo '<div class="flexslider"><div class="messagebox alert alert-info align-left">'.$tweets->errors[0]->message.".Please enter valid Twitter API Keys".'</div></div><div class="clear"></div>';
			}else{
				px_no_result_found(false);
			}
		}
	}
	echo '</div>';
}	

// Player Detail Gallery

function px_player_gallery($px_gallery_id=''){
 	$args=array(
		'name' => (string)$px_gallery_id,
		'post_type' => 'px_gallery',
		'post_status' => 'publish',
		'showposts' => 1,
	);
	$get_posts = get_posts($args);
	if($get_posts){
		$gal_album_db = $get_posts[0]->ID;
	}
	$px_cause_gallery = get_post_meta((int)$gal_album_db, "px_meta_gallery_options", true);

	if ( $px_cause_gallery <> "" ) {
 		$px_image_per_gallery = '';
 		$px_xmlObject_gallery = new SimpleXMLElement($px_cause_gallery);
 			$limit_start = 0;
 			$limit_end = $limit_start+$px_image_per_gallery;
 			if($limit_end < 1){
 				$limit_end = count($px_xmlObject_gallery);
 			}
 			$count_post = count($px_xmlObject_gallery);
	?>
	 <header class="pix-heading-title">
        <h2 class="pix-section-title"><?php echo get_the_title((int)$gal_album_db);?></h2>
     </header>
	<div class="gallery">
      <ul class="lightbox">
		<?php for ( $i = 0; $i < $limit_end; $i++ ) {

                $path = $px_xmlObject_gallery->gallery[$i]->path;

                $title = $px_xmlObject_gallery->gallery[$i]->title;

                $social_network = $px_xmlObject_gallery->gallery[$i]->social_network;

                $use_image_as = $px_xmlObject_gallery->gallery[$i]->use_image_as;

                $video_code = $px_xmlObject_gallery->gallery[$i]->video_code;

                $link_url = $px_xmlObject_gallery->gallery[$i]->link_url;

                $gallery_image_url = px_attachment_image_src($path, 240, 180);

                if($gallery_image_url <> ''){

					$image_url_full = px_attachment_image_src($path, 0, 0);
	
					?>
					<li>
						<figure>
							<img src="<?php echo $gallery_image_url;?>" alt="#">
							<figcaption>
                            	  <a  data-rel="<?php if($use_image_as==1)echo "prettyPhoto";  elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>" href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" data-title="<?php if ( $title <> "" ) { echo $title; }?>" >
                            <?php 
							  if($use_image_as==1){
								  echo '<i class="fa fa-video-camera"></i>';
							  }elseif($use_image_as==2){
								  echo '<i class="fa fa-link"></i>';	
							  }else{
								  echo '<i class="fa fa-plus"></i>';
							  }
							?>
                            </a>
							
							</figcaption>
						</figure>
					</li>

        <?php 	}
		}?>
            
      </ul>
   </div>	
<?php   

	}

}
// Get object by slug
function px_get_term_object($var_pb_event_category = ''){
		global $wpdb;
		return $row_cat = $wpdb->get_row("SELECT * from ".$wpdb->prefix."terms WHERE slug = '" . $var_pb_event_category ."'" );	
	}
function px_fixtures_page(){
	global $px_node,$post, $px_theme_option,$px_counter_node;
	
	if($px_node->var_pb_fixtures_cat <> '' && $px_node->var_pb_fixtures_cat <> '0'){ 
	if($px_theme_option["trans_switcher"] == "on") {  $start_fixtures = __("Kick-off",'Soccer Club'); }else{  $start_fixtures = $px_theme_option["trans_event_start"];}
                                    
								
                                
	?>
    		<div class="element_size_<?php echo $px_node->fixtures_element_size;?>">
                        <div class="pix-content-wrap">
                        <?php if($px_node->var_pb_fixtures_view == 'countdown'){
								$featured_args = array(
                                            'posts_per_page'			=> "1",
                                       //     'paged'						=> $_GET['page_id_all'],
                                            'post_type'					=> 'events',
                                            'event-category' 			=> "$px_node->var_pb_fixtures_cat",
                                            'meta_key'					=> 'px_event_from_date',
                                            'meta_value'				=> date('m/d/Y'),
                                            'meta_compare'				=> ">=",
                                            'orderby'					=> 'meta_value',
                                            'post_status'				=> 'publish',
                                            'order'						=> 'ASC',
                                         );
                                $px_featured_post= new WP_Query($featured_args);
							while ($px_featured_post->have_posts()) : $px_featured_post->the_post();	
                                    $event_from_date = get_post_meta($post->ID, "px_event_from_date", true);
                                        $year_event = date("Y", strtotime($event_from_date));
                                        $month_event = date("m", strtotime($event_from_date));
                                        $date_event = date("d", strtotime($event_from_date));
									 $px_featured_meta = get_post_meta($post->ID, "px_event_meta", true);	
                                    if ( $px_featured_meta <> "" ) {
                                        $px_featured_event_meta = new SimpleXMLElement($px_featured_meta);
                                    }
									$image_url = px_get_post_img_src($post->ID, '530', '398');
                                    px_enqueue_countdown_script();
							
							
							?>
                        
                           			 <div class="widget widget_countdown">
                            <?php if($px_node->var_pb_fixtures_title <> ''){?>
                                <header class="pix-heading-title">
                                    <h2 class="pix-section-title"><a href="<?php the_permalink();?>"><?php echo $px_node->var_pb_fixtures_title;?></a></h2>
                                </header>
                              <?php }?>
                                <div class="countdown-section">
                                <?php if($image_url <> ''){?>
                                <figure>
                                    <img src="<?php echo $image_url;?>" alt="">
                                </figure>
                                <?php }?>
                                <div class="text">
                                    <div id="defaultCountdown"></div>
                                   	<script>
										jQuery(document).ready(function($) {
										   px_event_countdown('<?php echo $year_event;?>','<?php echo $month_event;?>','<?php echo $date_event;?>');
										});
									</script>
                                    <div class="pix-sc-team">
                                        <ul>
                                        	<?php if(isset($px_featured_event_meta->var_pb_event_team1) && $px_featured_event_meta->var_pb_event_team1 <> '' && $px_featured_event_meta->var_pb_event_team1 <> '0'){?>
                                            <li>
                                                <figure>
                                                    <?php
                                                    $team1_row = px_get_term_object($px_featured_event_meta->var_pb_event_team1);
                                                      $team_img1 = px_team_data_front($team1_row->term_id);
                                                    if($team_img1[0] <> ''){
                                                    ?>
                                                        <img alt="" src="<?php echo $team_img1[0];?>">
                                                    <?php }?>
                                                    
                                                    <figcaption>
                                                       <?php 
                                                            echo $team1_row->name;
                                                       ?>
                                                    </figcaption>
                                                </figure>
                                            </li>
                                            <?php }?>
                                                                            	<?php if(isset($px_featured_event_meta->var_pb_event_team2) && $px_featured_event_meta->var_pb_event_team2 <> '' && $px_featured_event_meta->var_pb_event_team2 <> '0'){?>
                                            <li><span class="vs"><?php if($px_theme_option["trans_switcher"] == "on") {  _e("VS",'Soccer Club'); }else{  echo $px_theme_option["trans_event_vs"];}?></span></li>
                                            
                                            <li>
                                                <figure>
                                                    <?php
                                                    $team2_row = px_get_term_object($px_featured_event_meta->var_pb_event_team2);
                                                    
                                                    $team_img2 = px_team_data_front($team2_row->term_id);
													
                                                    if($team_img2[0] <> ''){
                                                    ?>
                                                        <img alt="" src="<?php echo $team_img2[0];?>">
                                                    <?php }?>
                                                    
                                                    <figcaption>
                                                       <?php 
                                                            echo $team2_row->name;
                                                       ?>
                                                    </figcaption>
                                                </figure>
                                            </li>
                                            <?php }?>
                                        </ul>
                                    </div>
                                    <ul class="post-options">
                                        <li><i class="fa fa-calendar"></i><time><?php echo date_i18n(get_option('date_format'), strtotime($event_from_date));?></time></li>
                                        <li><i class="fa fa-clock-o"></i>
                                        <?php 
												if ( $px_featured_event_meta->event_all_day != "on" ) {
													echo '<li><i class="fa fa-clock-o"></i>'.$start_fixtures;
														echo $px_featured_event_meta->event_time;
													echo '</li>';
												}else{
													echo '<li><i class="fa fa-clock-o"></i>'.$start_fixtures;
														_e("All",'Soccer Club') . printf( __("%s day",'Soccer Club'), ' ');
													echo '</li>';
												}
                                        	?> 
                                        </li>
                                    </ul>
                                    <?php if($px_featured_event_meta->event_address <> ''){?><a href="" class="btn pix-bgcolr"><i class="fa fa-map-marker"></i><?php echo $px_featured_event_meta->event_address;?></a><?php }?>
                                </div>
                                </div>
                            </div>
                            
                            <?php 
								 endwhile; 
							 
							} else {
								$featured_args = array(
                                            'posts_per_page'			=> "$px_node->var_pb_fixtures_per_page",
                                       //     'paged'						=> $_GET['page_id_all'],
                                            'post_type'					=> 'events',
                                            'event-category' 			=> "$px_node->var_pb_fixtures_cat",
                                            'meta_key'					=> 'px_event_from_date',
                                            'meta_value'				=> date('m/d/Y'),
                                            'meta_compare'				=> ">=",
                                            'orderby'					=> 'meta_value',
                                            'post_status'				=> 'publish',
                                            'order'						=> 'ASC',
                                         );
                                $px_featured_post= new WP_Query($featured_args);
								
								?>
                            	<?php if($px_node->var_pb_fixtures_title <> ''){?> 
                                    <header class="pix-heading-title">
                                        <h2 class="pix-section-title">
                                            <?php echo $px_node->var_pb_fixtures_title;?>
                                        </h2>
                                    </header>
                                    
                                    <?php if ( $px_featured_post->have_posts() <> "" ) {?>
                                        <div class="event event-listing event-listing-v2">
                                        <?php
                                                while ( $px_featured_post->have_posts() ): $px_featured_post->the_post();
                                                $event_from_date = get_post_meta($post->ID, "px_event_from_date", true);
                                                
                                                $post_xml = get_post_meta($post->ID, "px_event_meta", true);	
                                                if ( $post_xml <> "" ) {
                                                    $px_event_meta = new SimpleXMLElement($post_xml);
                                                    $team1_row = px_get_term_object($px_event_meta->var_pb_event_team1);
                                                    $team2_row = px_get_term_object($px_event_meta->var_pb_event_team2);
                                                }
                                                ?>
                                        
                                            <article>
                                                <div class="text">
                                                    <div class="top-event">
                                                        <h2 class="pix-post-title">
                                                            <a href="<?php the_permalink();?>"><?php the_title(); ?></a>
                                                        </h2>
                                                    </div>
                                                     <?php 
														 if($px_event_meta->event_venue <> '' and $px_event_meta->event_venue  <> '0'){
														 echo '<span class="match-category cat-'.$px_event_meta->event_venue.'">'.substr($px_event_meta->event_venue,0,1).'</span>';
										  				 } ?>
													
                                                    
                                                    <ul class="post-options">
                                                        <li> <i class="fa fa-calendar"></i>
                                                            <?php echo date_i18n(get_option('date_format'), strtotime($event_from_date));?>
                                                        </li>
                                                        <li><i class="fa fa-clock-o"></i>
                                                         <?php 
                                                            if ( $px_event_meta->event_all_day != "on" ) {
                                                                echo $px_event_meta->event_time;
                                                            }else{
                                                                _e("All",'Soccer Club') . printf( __("%s day",'Soccer Club'), ' ');
                                                            }
                                                        ?>
                                                            </li>
                                                        <?php if($px_event_meta->event_ticket_options <> ''){?> <li><i class="fa fa-map-marker"></i><?php echo $px_event_meta->event_address;?></li><?php }?>
                                                    </ul>
                                                </div>
                                            </article>
                                            <?php endwhile;?>
                                            <?php if($px_node->var_pb_fixtures_viewall_title <> ''){?> <a href="<?php echo $px_node->var_pb_fixtures_viewall_link;?>" class="btn btn-viewall pix-bgcolrhvr"><i class="fa fa-calendar"></i><?php echo $px_node->var_pb_fixtures_viewall_title;?>l</a><?php }?>
                                        </div>
                        <?php }?>
                        	
                        
                        <?php }?>
                            <?php }?>
                        </div>
                    </div>
    
    <?php
	
	wp_reset_query();
	}
}


// team images
function px_team_data_front($team_id){
		$team_data = get_option("team_$team_id");
		if (isset($team_data)){
			$data[] = stripslashes($team_data['icon']);
		}
		return $data;
}// Front End Functions END