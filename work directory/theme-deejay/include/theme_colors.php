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
			$element_color_scheme = $px_theme_option['element_color_scheme'];
		}
		
		?>
		<style type="text/css">
		/*New Clasess*/
		.pix-colr, .pix-colrhvr:hover,#menus  a:hover,.postel-text,#comments .text a.comment-edit-link:hover,#comments .text a.comment-reply-link:hover,.logged-in-as a:hover,.post-tags a:hover,
		.widget a:hover
		{ color:<?php  echo $px_color_scheme; ?> !important;
		}
		 .backcolr,.pix-bgcolr,.pix-bgcolr-alt,.pix-bgcolrhvr:hover,div.woocommerce .button:hover,.woocommerce .button,.onsale,.pix-btnsidebar,.navigation ul > li:hover > a, .donate-btn,
			/*New Clasess*/
			#myToolbox a,.pix-bgcolr,.pix-bgcolrhvr:hover,#banner .pagination .swiper-pagination-switch.swiper-active-switch,.post-pannel li a:hover,.pagination > ul > li > a.active,
.pagination > ul > li > a:hover,.pagination > ul > li > a:focus,#wp-calendar caption,.wpcf7 form p input[type="submit"],.detail-inner .post-pannel li a:hover,
.woocommerce-pagination ul li a:hover,.woocommerce-pagination ul li span,input[type="submit"],p.stars span a.active,.followus a:hover{
			background-color:<?php  echo $px_color_scheme; ?> !important;
		}
		
		 .pix-bdrcolr,#filters li.pix-active a,.pix-bdrcolrm,blockquote,#banner .pagination .swiper-pagination-switch.swiper-active-switch,#menus a:hover:before{
			border-color:<?php  echo $px_color_scheme; ?> !important;
		}

		</style>
		<?php 
	}