<?php
	// Corlor Styles for front end
	function px_custom_styles() {
		global $px_theme_option;
		
		if ( isset($_POST['style_sheet']) ) {
			$_SESSION['sess_style_sheet'] = $_POST['style_sheet'];
			$px_color_scheme = $_SESSION['sess_style_sheet'];
		}
		
		elseif (isset($_SESSION['sess_style_sheet']) and $_SESSION['sess_style_sheet'] <> '') {
			$px_color_scheme = $_SESSION['sess_style_sheet'];
		} else {
			$px_color_scheme = $px_theme_option['custom_color_scheme'];
		}
		
		?>
		<style type="text/css">
		.pix-colr, .pix-colrhvr:hover,.price-table article:hover h3, .post-options li a:hover,.breadcrumbs ul li.pix-active{ color:<?php  echo $px_color_scheme; ?> !important;
		}
		.pix-bgcolr,.pix-bgcolrhvr:hover,nav.navigation > ul > li > a:before,.cart-sec span,.navigation ul ul li:hover > a,.navigation ul ul li.current-menu-item > a,.news-section article:hover,.news-section article:hover .text,.price-table article:hover .pix-price-box,.featured-event .post-options, .event.evevt-listing article:hover .text .btn-boobked ,.event.evevt-listing article:hover .calendar-date, .match-result.match-lost p,.event.event-listing.event-listing-v2 article:hover,.bottom-event-panel,.cycle-pager-active,.widget .tagcloud a:hover,.event.event-listing article:hover .calendar-date, .event.event-listing article:hover .text .btn-boobked, .flex-direction-nav li a:hover /**/, .our-team-sec article:hover figure figcaption .pix-post-title a,
#respond form input[type="submit"],#wp-calendar caption,.gallery ul li figure figcaption a,.pagination > ul > li > a:hover,.pagination > ul > li > span:hover,.pagination > ul > li > a:focus,.pagination > ul > li > span:focus,.woocommerce-pagination ul li a:hover,.woocommerce-pagination ul li span,.woocommerce-tabs .tabs .active a, span.match-category.cat-neutral, .event.event-listing article:hover .text .btn,.widget_search form input[type="submit"],.woocommerce .button{
			background-color:<?php  echo $px_color_scheme; ?> !important;
		}
		
		.pix-bdrcolr ,.tabs.horizontal .nav-tabs li.active,.address-info .text,.subtitle h1,.about-us article .text,blockquote{
			border-color:<?php  echo $px_color_scheme; ?> !important;
		}
		
		#banner .flexslider figcaption .pix-desc h2 a ,#banner .flexslider figcaption .pix-desc h3 span {
		   box-shadow: -10px  0 0 <?php  echo $px_color_scheme; ?>,10px  0 0 <?php  echo $px_color_scheme; ?> !important; 
 		}
		</style>
		<?php 
	}