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
		.pix-colr, .pix-colrhvr:hover,.pix-colrhvr-alt:hover,.blockquote,.post-options li a:hover,#filters li.pix-active a,.jp-playlist li.jp-playlist-current span.title-song,.jp-playlist li.jp-playlist-current .jp-playpause,.jp-playlist-current .jp-social-option a.jp-playpause:before,div.woocommerce a:hover, .more-link,.team-section .followus a:hover{ color:<?php  echo $px_color_scheme; ?> !important;
		}
		 .backcolr,.pix-bgcolr,.pix-bgcolr-alt,.pix-bgcolrhvr:hover,#footer #lang_sel_list ul li a.lang_sel_sel,.cart-sec span,div.woocommerce .button:hover,.woocommerce .button,.onsale,.pix-btnsidebar,.navigation ul > li:hover > a, .donate-btn{
			background-color:<?php  echo $px_color_scheme; ?> !important;
		}
		{
			background:<?php  echo $px_color_scheme; ?> !important;
		}
		 .pix-bdrcolr,#filters li.pix-active a{
			border-color:<?php  echo $px_color_scheme; ?> !important;
		}
		 {
			border-color: transparent <?php  echo $px_color_scheme; ?> transparent transparent;
		}
		{
		  border-color: transparent <?php  echo $px_color_scheme; ?>;
		}
		.donate-btn:before {
		   border-color: transparent transparent transparent <?php  echo $px_color_scheme; ?> !important;
		}
		</style>
		<?php 
	}