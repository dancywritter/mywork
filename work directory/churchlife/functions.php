<?php
    /* add action filter and theme support on theme setup */
	add_action( 'after_setup_theme', 'px_theme_setup' );
	function px_theme_setup() {
		/* Add theme-supported features. */		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style();
		// Make theme available for translation
		// Translations can be filed in the /languages/ directory
		load_theme_textdomain('Church Life', get_template_directory() . '/languages');
		
		if (!isset($content_width)){
			$content_width = 1170;
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
		add_action('wp_enqueue_scripts', 'px_mediaelement_load_js');
		add_action('pre_get_posts', 'px_get_search_results');
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
	add_image_size('px_media_1', 742, 378, true);
	add_image_size('px_media_2', 742, 224, true);
	add_image_size('px_media_3', 742, 170, true);
	add_image_size('px_media_4', 380, 200, true);
	
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
	require_once (TEMPLATEPATH . '/include/sermon.php');
	require_once (TEMPLATEPATH . '/include/team.php');
	require_once (TEMPLATEPATH . '/include/event.php');
	require_once (TEMPLATEPATH . '/include/gallery.php');
	require_once (TEMPLATEPATH . '/include/page_builder.php');
	require_once (TEMPLATEPATH . '/include/post_meta.php');
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
			wp_enqueue_style('bootstrap_css', get_template_directory_uri() . '/css/bootstrap.css');
			wp_enqueue_style('font-awesome_css', get_template_directory_uri() . '/css/font-awesome.css');

			// Enqueue stylesheet
			wp_enqueue_style( 'wp-mediaelement' );
			wp_enqueue_script('jquery');
			wp_enqueue_script( 'wp-mediaelement' );
			wp_enqueue_script('bootstrap_js', get_template_directory_uri() . '/scripts/frontend/bootstrap.min.js', '', '', true);
			wp_enqueue_script('modernizr_js', get_template_directory_uri() . '/scripts/frontend/modernizr.js', '', '', true);
			if (isset($px_theme_option['site_nicescroll']) &&  $px_theme_option['site_nicescroll'] == "on"){
				wp_enqueue_script('nicescroll_js', get_template_directory_uri() . '/scripts/frontend/jquery.nicescroll.min.js', '', '', true);
			}
			wp_enqueue_script('functions_js', get_template_directory_uri() . '/scripts/frontend/functions.js', '0', '', false);
			
			if (isset($px_theme_option['site_ajax']) &&  $px_theme_option['site_ajax'] == "on"){
				wp_enqueue_script('jquery.validate.metadata_js', get_template_directory_uri() . '/scripts/admin/jquery.validate.metadata.js', '', '', true);
				wp_enqueue_script('bgndGallery_js', get_template_directory_uri() . '/scripts/frontend/mb.bgndGallery.js', '', '', true);
				wp_enqueue_script('jquery.validate_js', get_template_directory_uri() . '/scripts/admin/jquery.validate.js', '', '', true);
				wp_enqueue_script('jplayer_js', get_template_directory_uri() . '/scripts/frontend/jquery.jplayer.min.js', '', '', true);
				wp_enqueue_script('playerplaylist_js', get_template_directory_uri() . '/scripts/frontend/jplayer.playlist.min.js', '', '', true);
				wp_enqueue_script('prettyPhoto_js', get_template_directory_uri() . '/scripts/frontend/jquery.prettyphoto.js', '', '', true);
				wp_enqueue_script('wordrotator-rotator_js', get_template_directory_uri() . '/scripts/frontend/jquery.wordrotator.js', '', '', true);
				wp_enqueue_style('wordrotator_css', get_template_directory_uri() . '/css/jquery.wordrotator.css');
				wp_enqueue_style('prettyPhoto_css', get_template_directory_uri() . '/css/prettyphoto.css');
				wp_enqueue_script('jquery.countdown_js', get_template_directory_uri() . '/scripts/frontend/jquery.countdown.js', '', '', true);
				wp_enqueue_script( 'px_addthis', 'http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e4412d954dccc64', '', '', true);
			}
			if ( $px_theme_option['rtl_switcher'] == "on"){
				wp_enqueue_style('rtl_css', get_template_directory_uri() . '/css/rtl.css');
			}

			if ($px_theme_option['responsive'] == "on") {
				echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">';
				wp_enqueue_style('responsive_css', get_template_directory_uri() . '/css/responsive.css');
			}
		}
	}
	function px_mediaelement_load_js() {
	   wp_deregister_script('mediaelement');
	   wp_enqueue_script('mediaelement',get_template_directory_uri() .  '/scripts/frontend/mediaelement-and-player.min.js', array( 'jquery' ), '' ,true);
	}
	// Gallery Script Enqueue
	function px_enqueue_gallery_style_script(){
		wp_enqueue_style('prettyPhoto_css', get_template_directory_uri() . '/css/prettyphoto.css');
		wp_enqueue_script('prettyPhoto_js', get_template_directory_uri() . '/scripts/frontend/jquery.prettyphoto.js', '', '', true);
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
	// Background page slider Enqueue
	function px_enqueue_bnggallery_script(){
		wp_enqueue_script('bgndGallery_js', get_template_directory_uri() . '/scripts/frontend/mb.bgndGallery.js', '', '', true);
	}
	// text rotator Enqueue
	function px_enqueue_text_rotator_script(){
		wp_enqueue_script('wordrotator-rotator_js', get_template_directory_uri() . '/scripts/frontend/jquery.wordrotator.js', '', '', true);
		wp_enqueue_style('wordrotator_css', get_template_directory_uri() . '/css/jquery.wordrotator.css');
	}
	// jplayer Enqueue
	function px_enqueue_jplayer_script(){
		wp_enqueue_script('jplayer_js', get_template_directory_uri() . '/scripts/frontend/jquery.jplayer.min.js', '', '', true);
		wp_enqueue_script('playerplaylist_js', get_template_directory_uri() . '/scripts/frontend/jplayer.playlist.min.js', '', '', true);
	}
	// add this share enqueue
	function px_addthis_script_init_method(){
		
		if( is_single()){
			wp_enqueue_script( 'px_addthis', 'http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e4412d954dccc64', '', '', true);
		}

	}
	// news ticker enqueue style and script
	function px_enqueue_newsticker(){
		wp_enqueue_script('jquery.newsticker_js', get_template_directory_uri() . '/scripts/frontend/jquery.ticker.js', '', '', true);
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
		$show_subtitle=true;
		$subtitle = '';
		$get_title = '';
		if (is_page() || is_single()) {
			
			if (is_page() ){
				$px_xmlObject = px_meta_page('px_page_builder');
				if (isset($px_xmlObject) && $px_xmlObject->sub_title <> "") {
					$rotation_title = explode(',', $px_xmlObject->sub_title);
					$roation_string = '';
					foreach($rotation_title as $rotation){
						if($rotation){
							$rotation_a ="'".trim($rotation)."'";
							$roation_string .= $rotation_a.',';
						}
					}
					px_enqueue_text_rotator_script();
					?>
                    <script type="text/javascript">
						 <?php if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'on'){?>
								jQuery("#myWords").wordsrotator({
										words: [<?php echo $roation_string;?>] //Array of words, it may contain HTML values
									});
						 <?php } else {?>
								jQuery(document).ready(function($) {
									jQuery("#myWords").wordsrotator({
										words: [<?php echo $roation_string;?>] //Array of words, it may contain HTML values
									});
								}); 
						<?php }?>    
					</script>
					<h1 class="pix-page-title px-single-page-title"><span class="rotate" id="myWords"><?php //echo $px_xmlObject->sub_title;?></span></h1>
                	<?php
				} else {
					if (isset($px_xmlObject)) {
						if($px_xmlObject->page_title == "on"){
							echo '<h1 class="pix-page-title">' . substr(get_the_title(), 0, 40) . '</h1>';
						}
					}
					
				}
				
			}elseif (is_single()) {
				
				$post_type = get_post_type($post->ID);
				if ($post_type == "events") {
					$post_type = "px_event_meta";
				} else if($post_type == "sermons"){
					$post_type = "px_sermon";
				} else {
					$post_type = "post";
				}
				$post_xml = get_post_meta($post->ID, $post_type, true);
				
				if ($post_xml <> "") {
					$px_xmlObject = new SimpleXMLElement($post_xml);
				}
				if (isset($px_xmlObject) && $px_xmlObject->sub_title <> "") {
					$rotation_title = explode(',', $px_xmlObject->sub_title);
					$roation_string = '';
					foreach($rotation_title as $rotation){
						if($rotation){
							$rotation_a ="'".trim($rotation)."'";
							$roation_string .= $rotation_a.',';
						}
					}
					px_enqueue_text_rotator_script();
					?>
                    <script type="text/javascript">
						 <?php if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'on'){?>
								jQuery("#myWords").wordsrotator({
										words: [<?php echo $roation_string;?>] //Array of words, it may contain HTML values
									});
						 <?php } else {?>
								jQuery(document).ready(function($) {
									jQuery("#myWords").wordsrotator({
										words: [<?php echo $roation_string;?>] //Array of words, it may contain HTML values
									});
								}); 
						<?php }?>    
					</script>

					<h1 class="pix-page-title px-single-page-title"><span class="rotate" id="myWords"></span></h1>
                	<?php
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
			$query->set( 'post_type', array('post', 'events', 'sermons') );
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
                    <i class="fa fa-shopping-cart"></i><span><?php  echo $woocommerce->cart->cart_contents_count; ?></span>
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
			echo '<div class="post-wrapper">';
				previous_post_link( '%link', '<i class="fa fa-long-arrow-left"></i>' );
				if(function_exists("is_shop") && is_product() && isset($_SESSION["px_page_back_shop"]) && $_SESSION["px_page_back_shop"] <> ''){
					echo '<a class="post-link" href="'.get_permalink((int)$_SESSION["px_page_back_shop"]).'"></a>';
				} elseif(isset($_SESSION["px_page_back"]) && $_SESSION["px_page_back"] <> ''){
					echo '<a class="post-link" href="'.get_permalink((int)$_SESSION["px_page_back"]).'"></a>';
				}
				next_post_link( '%link','<i class="fa fa-long-arrow-right"></i>' );
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
						_e('Featured','Church Life');
				} else {
					if($px_theme_option['trans_switcher'] == "on"){
						_e('Featured','Church Life');
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
			echo __('Author', 'Church Life') . " " . __('Archives', 'Church Life') . ": ".$userdata->display_name;
		}
 		elseif ( is_tag() || is_tax('event-tag') || is_tax('portfolio-tag') || is_tax('sermon-tag') ) {
			echo __('Tags', 'Church Life') . " " . __('Archives', 'Church Life') . ": " . single_cat_title( '', false );
		}
 		elseif ( is_category() || is_tax('event-category') || is_tax('portfolio-category')  || is_tax('sermon-category')  || 
		is_tax('sermon-series')  || is_tax('sermon-pastors') ) {
			echo __('Categories', 'Church Life') . " " . __('Archives', 'Church Life') . ": " . single_cat_title( '', false );
		}
 		elseif( is_search()){
			printf( __( 'Search Results %1$s %2$s', 'Church Life' ), ': ','<span>' . get_search_query() . '</span>' );
		}
 		elseif ( is_day() ) {
			printf( __( 'Daily Archives: %s', 'Church Life' ), '<span>' . get_the_date() . '</span>' );
		}
 		elseif ( is_month() ) {
			printf( __( 'Monthly Archives: %s', 'Church Life' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'Church Life' ) ) . '</span>' );
		}
 		elseif ( is_year() ) {
			printf( __( 'Yearly Archives: %s', 'Church Life' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'Church Life' ) ) . '</span>' );
		}
 		elseif ( is_404()){
			_e( 'Error 404', 'Church Life' );
		}
 		elseif(!is_page()){
			_e( 'Archives', 'Church Life' );
		}

	}

	// Custom excerpt function 
	function px_get_the_excerpt($limit,$readmore = '') {
		global $px_theme_option;
		if(!isset($limit) || $limit == ''){ $limit = '255';}
		$get_the_excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU', '', get_the_excerpt()));
		echo substr($get_the_excerpt, 0, "$limit");
		
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
				if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'on'){
					if($px_theme_option['trans_switcher'] == "on"){ $share_text = __('Sahre','Church Life');}else{ $share_text =$px_theme_option['trans_share_this_post']; } 
					$html = '';
					$html ='<div id="myToolbox">';
					$html .='<a class="addthis_button_compact"><i class="fa fa-share-square-o"></i>'.$share_text.'</a>
					</div>';
					echo $html;
					?>
						<script type="text/javascript">
							addthis.toolbox('#myToolbox');
							
						</script>
				<?php } else { ?>
				<div id="myToolbox">
				 <a href="#" class="addthis_button_compact pix-btnshare"><i class="fa fa-share-square-o"></i><?php if($px_theme_option['trans_switcher'] == "on"){ _e('Sahre','Church Life');}else{ echo $px_theme_option['trans_share_this_post']; } ?></a>
				 </div>
				<?php } 
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
			//foreach ( $parts as $val ) {
			register_sidebar(array('name' => $sidebar,'id' => $sidebar,'description' => 'This widget will be displayed on right side of the page.','before_widget' => '<div class="widget %2$s">','after_widget' => '</div>','before_title' => '<header class="heading"><h2 class="section-title heading-color">','after_title' => '</h2></header>'));
		}

	}



	
	
	register_sidebar( array('name' => 'Sidebar Widget','id' => 'sidebar-1','description' => 'This Widget Show the Content in Blog Listing page.','before_widget' => '<div class="widget %2$s">','after_widget' => '</div>','before_title' => '<header class="heading"><h2 class="section-title">','after_title' => '</h2></header>') );
	function px_add_menuid($ulid) {
		return preg_replace('/<ul>/', '<ul id="menus">', $ulid, 1);
	}

	
	function px_remove_div ( $menu ){
		return preg_replace( array( '#^<div[^>]*>#', '#</div>$#' ), '', $menu );
	}

	
	function px_register_my_menus() {
		register_nav_menus(array('main-menu'  => __('Main Menu','Church Life') )  );
	}

	
	function px_add_parent_css($classes, $item) {
		global $px_menu_children;
		
		if ($px_menu_children)        $classes[] = 'parent';
		return $classes;
	}

	
	if (!function_exists('PixFill_comment')) :
	/**
     * Template for comments and pingbacks.
     *
     * To override this walker in a child theme without modifying the comments template
     * simply create your own PixFill_comment(), and that function will be used instead.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     *
     */
	function PixFill_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		$args['reply_text'] = 'Reply';
		switch ( $comment->comment_type ) :
		case '' :
			?>
        <li  <?php  comment_class(); ?> id="li-comment-<?php  comment_ID(); ?>">
            <div class="thumblist" id="comment-<?php  comment_ID(); ?>">
                <ul>
                    <li>
                        <figure>
                            <a href="#"><?php  echo get_avatar( $comment, 50 ); ?></a>
                        </figure>
                         <div class="text">
                          <header>
                                <?php  printf( __( '%s', 'Church Life' ), sprintf( '<h6><a class="colrhover">%s</a></h6>', get_comment_author_link() ) ); 						/* translators: 1: date, 2: time */
	 							printf( __( '<time>%1$s</time>', 'Church Life' ), get_comment_date()); ?>
                                <?php  edit_comment_link( __( '(Edit)', 'Church Life' ), ' ' ); ?>
                                <?php  comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );                                	if ( $comment->comment_approved == '0' ) : ?>
                                    <div class="comment-awaiting-moderation colr">
										<?php  _e( 'Your comment is awaiting moderation.', 'Church Life' ); ?>
                                    </div>
                                <?php  endif; ?>
                          </header>
                          <?php  comment_text(); ?>
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
		<p><?php  comment_author_link(); ?><?php  edit_comment_link( __( '(Edit)', 'Church Life' ), ' ' ); ?></p>
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
					$o = '<div class="password_protected single-password">
									<h5>' . __( "This post is password protected. To view it please enter your password below:",'Church Life' ) . '</h5>';
									$o .= '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
												<label><input name="post_password" id="' . $label . '" type="password" size="20" /></label>
												<input class="backcolr" type="submit" name="Submit" value="'.__("Submit", "Church Life").'" />
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
				$before      = '<li class="cs-active">';
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
				$linkhome = $linkBefore . '<a' . $linkAttr . ' href="%1$s"><i class="fa fa-home"></i>%2$s</a>' . $linkAfter;
				
				if (is_home() || is_front_page()) {
					
					if ($showOnHome == "1") echo '<div class="breadcrumbs"><ul>'.$before.'<a href="' . $homeLink . '"><i class="fa fa-home"></i>' . $text['home'] . '</a>'.$after.'</ul></div>';
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

		/*Under Construction logo Function*/		
		function px_uc_logo(){
			global $px_theme_option;
			?>
			<a href="<?php  echo home_url(); ?>">
            	<img src="<?php  echo $px_theme_option['logo']; ?>"  style="width:<?php  echo $px_theme_option['logo_width']; ?>px; 
                height:<?php  echo $px_theme_option['logo_height']; ?>px" alt="<?php  echo bloginfo('name'); ?>" />
            </a>
	 	<?php
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
	  // block quote short code
	  
	  if ( ! function_exists( 'px_quote_page' ) ) {
		  function px_quote_page(){
			  global $px_quote_page;
			  $html = '<div class="element_size_'.$px_quote_page->quote_element_size.'">';
			  $html .= '<blockquote style=" text-align:' .$px_quote_page->quote_align. '; color:' . $px_quote_page->quote_text_color . '"><span>' . $px_quote_page->quote_content . '</span></blockquote>';
			  $html .= '</div>';
			  return $html . '<div class="clear"></div>';
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
function px_ajaxComment($comment_ID, $comment_status) {
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
		if($comment_status=='1'){
			$commentdata =& get_comment($comment_ID, ARRAY_A);
			$post =& get_post($commentdata['comment_post_ID']);
			wp_notify_postauthor($comment_ID, $commentdata['comment_type']);
		}
	}
}
add_action('comment_post', 'px_ajaxComment', 20, 2);

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
		} else if($post_type == "sermons") {
			$post_type = "px_sermon";
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
		if($varto_bg_option == "big-image-zoom" || $varto_bg_option == "fade-slider" || $varto_bg_option == "half-layout" || $varto_bg_option == "left-slider"){
			px_background_slider($varto_bg_option, $px_xmlObject->px_home_v4_slider);
		}
		elseif($varto_bg_option == "background_video" && $mobile_browser == 'No'){
			px_background_video($varto_bg_option, $px_xmlObject->px_home_v2_video, $px_xmlObject->px_home_v2_video_mute);
		} elseif($varto_bg_option == "custom-background-image"){
			echo '<div class="bg-img" id="px_background_img" style="background-image:url('.$px_xmlObject->bg_image.'); position:fixed; z-index:1; top:0; height: 100%; width: 100%;"></div>';
		} elseif($varto_bg_option == "featured-image"){
			$image_url_full = px_get_post_img_src($post->ID, '0' ,'0');
			if($image_url_full <> ''){
				echo '<div class="bg-img" id="px_background_img" style="background-image:url('.$image_url_full.'); position:fixed; z-index:1; top:0; height: 100%; width: 100%;"></div>';
			} else {
				echo '<div class="bg-color" id="px_background_color" style="background-color:'.$px_xmlObject->bg_color.'; position:fixed; z-index:1; top:0; height: 100%; width: 100%;"></div>';
			}
		} else {
			echo '<div class="bg-color" id="px_background_color" style="background-color:'.$px_xmlObject->bg_color.'; position:fixed; z-index:1; top:0; height: 100%; width: 100%;"></div>';
		}
	} else {
		$px_node = new stdClass();
		$varto_bg_option = $px_theme_option['varto_bg_option'];
		if($varto_bg_option == "big-image-zoom" || $varto_bg_option == "fade-slider" || $varto_bg_option == "half-layout" || $varto_bg_option == "left-slider"){
			px_background_slider($varto_bg_option, $px_theme_option['px_home_v4_slider']);
		}
		elseif($varto_bg_option == "background_video" && $mobile_browser == 'No'){
			
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
// background slider 
function px_background_slider($varto_bg_option, $px_home_v4_slider){
		global $post,$px_theme_option;
		px_enqueue_bnggallery_script();
		$slider_layout = '';
		if($varto_bg_option == 'big-image-zoom-home'){
			$slider_layout = 'zoomBlur';
		} elseif($varto_bg_option == 'fade-slider'){
			$slider_layout = 'blur';
		} elseif($varto_bg_option == 'left-slider'){
			$slider_layout = 'slideRight';
		} else {
			$slider_layout = 'blur';
		}
		$imaages_array = array();
		$imaages_string = '';
		if(!empty($px_home_v4_slider)){
			
			// slider slug to id start
				$args=array(
				  'name' => $px_home_v4_slider,
				  'post_type' => 'px_gallery',
				  'post_status' => 'publish',
				  'showposts' => 1,
				);
				$get_posts = get_posts($args);
				if($get_posts){
					$slider_id = $get_posts[0]->ID;
					$px_meta_slider_options = get_post_meta($slider_id, "px_meta_gallery_options", true); 
						$px_xmlObject_flex = new SimpleXMLElement($px_meta_slider_options);
					foreach ( $px_xmlObject_flex->children() as $as_node ){
 						$image_url = px_attachment_image_src($as_node->path,0,0); 
						if($image_url <> ''){
							$imaages_string .='"'.$image_url.'",';
						}
					}
				}
		} else {
			echo "Please Select Slider";
		}
		?>
       <script type="text/javascript">
			<?php if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'on'){?>
			 var myGallery = new mbBgndGallery({
					containment:"body",
					timer:3000,
					effTimer:1000,
					grayScale:false,
					shuffle:true,
					preserveWidth:false,
					effect:"<?php echo $slider_layout;?>",
					images:[
						<?php echo $imaages_string;?>
					]
				});
			<?php } else {?>
				jQuery(document).ready(function($){
				 var myGallery = new mbBgndGallery({
					containment:"body",
					timer:3000,
					effTimer:1000,
					grayScale:false,
					shuffle:true,
					preserveWidth:false,
					effect:"<?php echo $slider_layout;?>",
					images:[
						<?php echo $imaages_string;?>
					]
				});
			});
			<?php }?>
	</script> 
			 	<?php

	
		
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
	<?php if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'on'){?>
				
				jQuery('iframe.vimeo-player').each(function(){
					jQuery("#videowrapper").css({
						"opacity":"1"
					})
					$f(this).addEvent('ready', ready);
		
					});
			
		// Enable the API on each Vimeo video

			resizevideo ();
			jQuery(window).resize(function() {
			resizevideo ();
			});
			function ready(player_id){
			  $f(player_id).api('setVolume',<?php echo $video_volume;?>);
				$f(player_id).api('play');
			}
	<?php } else {?>
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

<?php } ?>
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
			<?php if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'on'){?>
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
			
			<?php } else {?>
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
			<?php } ?>
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
            <div class="about-author">
                <!-- Thumbnail List Start -->
                <!-- Thumbnail List Item Start -->
                 <figure><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="float-left"><?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('PixFill_author_bio_avatar_size', 140)); ?></a></figure>
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
            <!-- About Author End -->
    <?php	 } 
}

function px_event_options(){
	global $px_theme_option, $px_event_meta;
	?>
            <address>
            <time datetime="2011-01-12">
            <?php 
                if ( $px_event_meta->event_all_day != "on" ) {
                    echo $px_event_meta->event_start_time; if($px_event_meta->event_end_time <> ''){ echo "- ";  echo $px_event_meta->event_end_time; }
                }else{
                    _e("All",'Church Life') . printf( __("%s day",'Church Life'), ' ');
                }
            ?>
             </time>
           <?php if($px_event_meta->event_address <> ''){echo '@ '.get_the_title((int) $px_event_meta->event_address);}?>
        </address>
       <?php if($px_event_meta->event_ticket_options <> ''){?> 
            <a <?php if(isset($px_event_meta->event_ticket_color) && $px_event_meta->event_ticket_color <> ''){?>style=" background-color: <?php echo $px_event_meta->event_ticket_color;?>"<?php }?> class="btn pix-btn-open" href="<?php echo $px_event_meta->event_buy_now;?>"> <?php if(isset($px_event_meta->event_ticket_options) && $px_event_meta->event_ticket_options <> ''){echo $px_event_meta->event_ticket_options;}?></a>
        <?php }
}

// default playerin header area
function px_background_music($header_track_mp3_url){
	global $px_theme_option;
	if(isset($header_track_mp3_url) && $header_track_mp3_url <> ''){
		$autoplay = '';
		if (isset($px_theme_option['header_track_mp3_autoplay']) && $px_theme_option['header_track_mp3_autoplay'] == "on"){
			$autoplay = 'autoplay="true"';
		} 
		if(function_exists("is_shop") and is_shop()){
			$autoplay = '';
		}
		if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'on'){
			$autoplay = '';
		}
		?>
        <script>
			jQuery(document).ready(function($) {
				px_mediaelement();
			});
		</script>
        <li class="audio-play-music">
            <audio class="audio" preload="none" <?php echo $autoplay;?>  loop="false" src="<?php echo $header_track_mp3_url; ?>"></audio>
        </li>
    <?php 	
	}
}

//
 function px_next_prev_custom_links($post_type = 'sermons'){
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
		echo '<div class="post-wrapper">';
		if (isset($previd) &&  !empty($previd) && $previd >=0 ) {
		   ?>
		   <a href="<?php echo get_permalink($previd); ?>" class="post-prev"><i class="fa fa-long-arrow-left"></i></a>
            
            <?php
		}
		if($post_type == 'sermons'){
			if(isset($_SESSION["px_page_back_sermon"]) && $_SESSION["px_page_back_sermon"] <> ''){
				echo '<a class="post-link" href="'.get_permalink((int)$_SESSION["px_page_back_sermon"]).'"></a>';
			}
			
		} elseif($post_type == 'events'){
			if(isset($_SESSION["px_page_back_event"]) && $_SESSION["px_page_back_event"] <> ''){
				echo '<a class="post-link" href="'.get_permalink((int)$_SESSION["px_page_back_event"]).'"></a>';
			}
		}
		
		
		if (isset($nextid) &&   !empty($nextid) ) {
			?>
            <a href="<?php echo get_permalink($nextid); ?>" class="post-next"><i class="fa fa-long-arrow-right"></i></a>
            
            <?php	
		}
		echo '</div>';
	 wp_reset_query();
 }
 
// news announcement 
if ( ! function_exists( 'fnc_announcement' ) ) {
	function fnc_announcement(){
		global $px_theme_option;
		$blog_category = $px_theme_option['announcement_blog_category'];
        	$announcement_no_posts = $px_theme_option['announcement_no_posts'];
         	if(isset($blog_category) && $blog_category <> '0'){
				if (empty($announcement_no_posts)){ $announcement_no_posts  = 5;}
				$args = array('posts_per_page' => "$announcement_no_posts", 'category_name' => "$blog_category",'post_status' => 'publish');
				$custom_query = new WP_Query($args);
				if($custom_query->have_posts()):
					px_enqueue_newsticker();
	?>
    
    <div class="news-ticker-wrapp">
        <ul id="js-news" class="js-hidden">
        	<?php 
	        
            while ($custom_query->have_posts()) : $custom_query->the_post();
            	?>
                <li class="news-item">
                	<a href="<?php the_permalink();?>"><?php the_title();?> - <?php echo get_the_date().' '.get_the_time(); ?></a>
                </li>
                <?php endwhile;?>

        </ul>
        <script>
        jQuery(document).ready(function($) {
                jQuery('#js-news').ticker();
        });
        </script>
    </div>
    <?php endif; wp_reset_query(); }
	}
}

// Default pages listing article
function px_defautlt_artilce(){
	global $post,$px_theme_option;
	?>
         <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
            <div class="text">
                <h2 class="pix-post-title"><a href="<?php the_permalink(); ?>" class="pix-colrhvr"><?php the_title(); ?></a></h2>
                <ul class="post-options">
                
                    <li><?php px_featured();?><span><?php if($px_theme_option['trans_switcher'] == "on"){ _e('Posted on','Church Life');}else{ echo $px_theme_option['trans_posted_on']; } ?></span> <time><?php echo get_the_date();?></time></li>
                    <?php
                        if ( comments_open() ) {  
                            echo "<li>"; comments_popup_link( __( '0 Comment', 'Church Life' ) , __( '1 Comment', 'Church Life' ), __( '% Comment', 'Church Life' ) ).'</li>'; 
                        }
                    ?>
                  <?php edit_post_link( __( 'Edit', 'Church Life'), '<li><span class="edit-link">', '</span></li>' ); ?>
                </ul>
               <p><?php echo px_get_the_excerpt(255,true); ?></p>
            </div>
        </article>

    <?php
	
}
// Front End Functions END