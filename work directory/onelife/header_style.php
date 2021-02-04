<?php 
/*
Header Styes
*/
function cs_header_style() {
      global $cs_theme_option, $post,$cs_position;
	  if(!isset($cs_theme_option['default_header'])){
		  $cs_theme_option['default_header'] = "header1";
	  }
 	    if ( isset($_POST['header_styles']) ) {
					$_SESSION['sess_header_styles'] = $_POST['header_styles'];
					$header_styles = $_SESSION['sess_header_styles'];
			}
			else if ( !empty($_SESSION['sess_header_styles']) ) {
					$header_styles = $_SESSION['sess_header_styles'];
			}
			else if(is_page()){
				$cs_page_builder = get_post_meta($post->ID, "cs_page_builder", true);
				if($cs_page_builder <> ''){
					$cs_xmlObject = new SimpleXMLElement($cs_page_builder);
					$header_styles = $cs_xmlObject->header_styles;
					if($header_styles == '' or $header_styles == 'default-header'){
						$header_styles = $cs_theme_option['default_header'];	
					}
				}else{
					$header_styles = $cs_theme_option['default_header'];
				}
			}else {
					$header_styles = $cs_theme_option['default_header'];
			}
			//echo $header_styles;
    if(isset($header_styles) && $header_styles<>''){
    $header_bg_color = $header_top_strip_bg_color = $header_top_strip_color = $header_nav_bgcolr = $header_nav_color = $header_nav_hover_color = $header_nav_hover_bgcolor = $header_nav_active_color = $header_nav_active_bgcolor =
    $header_subnav_bgcolr = $header_subnav_color = $header_subnav_hover_color = $header_subnav_hover_bgcolor = $header_subnav_active_color = $header_subnav_active_bgcolor = '';
    if ( $header_styles == "header1" ){

        $header_bg_color = $cs_theme_option['header_1_bg_color'];
        $header_bg_image = $cs_theme_option['header_1_bg_image'];
        $header_nav_bgcolr = $cs_theme_option['header_1_nav_bgcolr'];
        $header_nav_color = $cs_theme_option['header_1_nav_color'];
        $header_nav_hover_color = $cs_theme_option['header_1_nav_hover_color'];
        $header_nav_hover_bgcolor = $cs_theme_option['header_1_nav_hover_bgcolor'];
        $header_nav_active_color = $cs_theme_option['header_1_nav_active_color'];
        $header_nav_active_bgcolor = $cs_theme_option['header_1_nav_active_bgcolor'];
        $header_subnav_border_colr = $cs_theme_option['header_1_subnav_border_colr'];
        $header_subnav_bgcolr = $cs_theme_option['header_1_subnav_bgcolr'];
        $header_subnav_color = $cs_theme_option['header_1_subnav_color'];
        $header_subnav_hover_color = $cs_theme_option['header_1_subnav_hover_color'];
        $header_subnav_hover_bgcolor = $cs_theme_option['header_1_subnav_hover_bgcolor'];
        $header_subnav_active_color = $cs_theme_option['header_1_subnav_active_color'];
        $header_subnav_active_bgcolor = $cs_theme_option['header_1_subnav_active_bgcolor'];
        $header_subheader_bgcolor = $cs_theme_option['header_1_subheader_bgcolor'];
        $header_subheader_link_color = $cs_theme_option['header_1_subheader_link_color'];
        $header_subheader_title_color = $cs_theme_option['header_1_subheader_title_color'];
        $header_subheader_subtitle_color = $cs_theme_option['header_1_subheader_subtitle_color'];
    }
  
    elseif ( $header_styles == "header2" ) {
        $header_bg_color = $cs_theme_option['header_2_bg_color'];
        $header_nav_bgcolr = $cs_theme_option['header_2_nav_bgcolr'];
        $header_nav_color = $cs_theme_option['header_2_nav_color'];
        $header_nav_hover_color = $cs_theme_option['header_2_nav_hover_color'];
        $header_nav_hover_bgcolor = $cs_theme_option['header_2_nav_hover_bgcolor'];
        $header_nav_active_color = $cs_theme_option['header_2_nav_active_color'];
        $header_subnav_border_colr = $cs_theme_option['header_2_subnav_border_colr'];
        $header_nav_active_bgcolor = $cs_theme_option['header_2_nav_active_bgcolor'];
        $header_subnav_bgcolr = $cs_theme_option['header_2_subnav_bgcolr'];
        $header_subnav_color = $cs_theme_option['header_2_subnav_color'];
        $header_subnav_hover_color = $cs_theme_option['header_2_subnav_hover_color'];
        $header_subnav_hover_bgcolor = $cs_theme_option['header_2_subnav_hover_bgcolor'];
        $header_subnav_active_color = $cs_theme_option['header_2_subnav_active_color'];
        $header_subnav_active_bgcolor = $cs_theme_option['header_2_subnav_active_bgcolor'];
        $header_subheader_bgcolor = $cs_theme_option['header_2_subheader_bgcolor'];
        $header_subheader_link_color = $cs_theme_option['header_2_subheader_link_color'];
        $header_subheader_title_color = $cs_theme_option['header_2_subheader_title_color'];
        $header_subheader_subtitle_color = $cs_theme_option['header_2_subheader_subtitle_color'];
        
    }
    elseif ( $header_styles == "header3" ) {    
        $header_bg_color = $cs_theme_option['header_3_bg_color'];
        $header_nav_bgcolr = $cs_theme_option['header_3_nav_bgcolr'];
        $header_nav_color = $cs_theme_option['header_3_nav_color'];
        $header_nav_hover_color = $cs_theme_option['header_3_nav_hover_color'];
        $header_nav_hover_bgcolor = $cs_theme_option['header_3_nav_hover_bgcolor'];
        $header_nav_active_color = $cs_theme_option['header_3_nav_active_color'];
        $header_nav_active_bgcolor = $cs_theme_option['header_3_nav_active_bgcolor'];
        $header_subnav_border_colr = $cs_theme_option['header_3_subnav_border_colr'];
        $header_subnav_bgcolr = $cs_theme_option['header_3_subnav_bgcolr'];
        $header_subnav_color = $cs_theme_option['header_3_subnav_color'];
        $header_subnav_hover_color = $cs_theme_option['header_3_subnav_hover_color'];
        $header_subnav_hover_bgcolor = $cs_theme_option['header_3_subnav_hover_bgcolor'];
        $header_subnav_active_color = $cs_theme_option['header_3_subnav_active_color'];
        $header_subnav_active_bgcolor = $cs_theme_option['header_3_subnav_active_bgcolor'];
        $header_subheader_bgcolor = $cs_theme_option['header_3_subheader_bgcolor'];
        $header_subheader_link_color = $cs_theme_option['header_3_subheader_link_color'];
        $header_subheader_title_color = $cs_theme_option['header_3_subheader_title_color'];
        $header_subheader_subtitle_color = $cs_theme_option['header_3_subheader_subtitle_color'];
    }
    elseif ( $header_styles == "header4" ) {    
        $header_bg_color = $cs_theme_option['header_4_bg_color'];
        $header_nav_bgcolr = $cs_theme_option['header_4_nav_bgcolr'];
        $header_nav_color = $cs_theme_option['header_4_nav_color'];
        $header_nav_hover_color = $cs_theme_option['header_4_nav_hover_color'];
        $header_nav_hover_bgcolor = $cs_theme_option['header_4_nav_hover_bgcolor'];
        $header_nav_active_color = $cs_theme_option['header_4_nav_active_color'];
        $header_nav_active_bgcolor = $cs_theme_option['header_4_nav_active_bgcolor'];
        $header_subnav_border_colr = $cs_theme_option['header_4_subnav_border_colr'];
        $header_subnav_bgcolr = $cs_theme_option['header_4_subnav_bgcolr'];
        $header_subnav_color = $cs_theme_option['header_4_subnav_color'];
        $header_subnav_hover_color = $cs_theme_option['header_4_subnav_hover_color'];
        $header_subnav_hover_bgcolor = $cs_theme_option['header_4_subnav_hover_bgcolor'];
        $header_subnav_active_color = $cs_theme_option['header_4_subnav_active_color'];
        $header_subnav_active_bgcolor = $cs_theme_option['header_4_subnav_active_bgcolor'];
        $header_subheader_bgcolor = $cs_theme_option['header_4_subheader_bgcolor'];
        $header_subheader_link_color = $cs_theme_option['header_4_subheader_link_color'];
        $header_subheader_title_color = $cs_theme_option['header_4_subheader_title_color'];
        $header_subheader_subtitle_color = $cs_theme_option['header_4_subheader_subtitle_color'];
    }
    elseif ( $header_styles == "header5" ) {    
        $header_bg_color = $cs_theme_option['header_5_bg_color'];
        $header_nav_bgcolr = $cs_theme_option['header_5_nav_bgcolr'];
        $header_nav_color = $cs_theme_option['header_5_nav_color'];
        $header_nav_hover_color = $cs_theme_option['header_5_nav_hover_color'];
        $header_nav_hover_bgcolor = $cs_theme_option['header_5_nav_hover_bgcolor'];
        $header_nav_active_color = $cs_theme_option['header_5_nav_active_color'];
        $header_nav_active_bgcolor = $cs_theme_option['header_5_nav_active_bgcolor'];
        $header_subnav_border_colr = $cs_theme_option['header_5_subnav_border_colr'];
        $header_subnav_bgcolr = $cs_theme_option['header_5_subnav_bgcolr'];
        $header_subnav_color = $cs_theme_option['header_5_subnav_color'];
        $header_subnav_hover_color = $cs_theme_option['header_5_subnav_hover_color'];
        $header_subnav_hover_bgcolor = $cs_theme_option['header_5_subnav_hover_bgcolor'];
        $header_subnav_active_color = $cs_theme_option['header_5_subnav_active_color'];
        $header_subnav_active_bgcolor = $cs_theme_option['header_5_subnav_active_bgcolor'];
        $header_subheader_bgcolor = $cs_theme_option['header_5_subheader_bgcolor'];
        $header_subheader_link_color = $cs_theme_option['header_5_subheader_link_color'];
        $header_subheader_title_color = $cs_theme_option['header_5_subheader_title_color'];
        $header_subheader_subtitle_color = $cs_theme_option['header_5_subheader_subtitle_color'];
    }
    elseif ( $header_styles == "header6" ) {    
        $header_bg_color = $cs_theme_option['header_6_bg_color'];
        $header_nav_bgcolr = $cs_theme_option['header_6_nav_bgcolr'];
        $header_nav_color = $cs_theme_option['header_6_nav_color'];
        $header_nav_hover_color = $cs_theme_option['header_6_nav_hover_color'];
        $header_nav_hover_bgcolor = $cs_theme_option['header_6_nav_hover_bgcolor'];
        $header_nav_active_color = $cs_theme_option['header_6_nav_active_color'];
        $header_nav_active_bgcolor = $cs_theme_option['header_6_nav_active_bgcolor'];
        $header_subnav_border_colr = $cs_theme_option['header_6_subnav_border_colr'];
        $header_subnav_bgcolr = $cs_theme_option['header_6_subnav_bgcolr'];
        $header_subnav_color = $cs_theme_option['header_6_subnav_color'];
        $header_subnav_hover_color = $cs_theme_option['header_6_subnav_hover_color'];
        $header_subnav_hover_bgcolor = $cs_theme_option['header_6_subnav_hover_bgcolor'];
        $header_subnav_active_color = $cs_theme_option['header_6_subnav_active_color'];
        $header_subnav_active_bgcolor = $cs_theme_option['header_6_subnav_active_bgcolor'];
        $header_subheader_bgcolor = $cs_theme_option['header_6_subheader_bgcolor'];
        $header_subheader_link_color = $cs_theme_option['header_6_subheader_link_color'];
        $header_subheader_title_color = $cs_theme_option['header_6_subheader_title_color'];
        $header_subheader_subtitle_color = $cs_theme_option['header_6_subheader_subtitle_color'];

    }
    elseif ( $header_styles == "header7" ) {
    	$header_top_strip_bg_color = $cs_theme_option['header_7_top_strip_bg_color'];
    	$header_top_strip_color = $cs_theme_option['header_7_top_strip_color'];
        $header_bg_color = $cs_theme_option['header_7_bg_color'];
        $header_nav_bgcolr = $cs_theme_option['header_7_nav_bgcolr'];
        $header_nav_color = $cs_theme_option['header_7_nav_color'];
        $header_nav_hover_color = $cs_theme_option['header_7_nav_hover_color'];
        $header_nav_hover_bgcolor = $cs_theme_option['header_7_nav_hover_bgcolor'];
        $header_nav_active_color = $cs_theme_option['header_7_nav_active_color'];
        $header_nav_active_bgcolor = $cs_theme_option['header_7_nav_active_bgcolor'];
        $header_subnav_border_colr = $cs_theme_option['header_7_subnav_border_colr'];
        $header_subnav_bgcolr = $cs_theme_option['header_7_subnav_bgcolr'];
        $header_subnav_color = $cs_theme_option['header_7_subnav_color'];
        $header_subnav_hover_color = $cs_theme_option['header_7_subnav_hover_color'];
        $header_subnav_hover_bgcolor = $cs_theme_option['header_7_subnav_hover_bgcolor'];
        $header_subnav_active_color = $cs_theme_option['header_7_subnav_active_color'];
        $header_subnav_active_bgcolor = $cs_theme_option['header_7_subnav_active_bgcolor'];
        $header_subheader_bgcolor = $cs_theme_option['header_7_subheader_bgcolor'];
        $header_subheader_link_color = $cs_theme_option['header_7_subheader_link_color'];
        $header_subheader_title_color = $cs_theme_option['header_7_subheader_title_color'];
        $header_subheader_subtitle_color = $cs_theme_option['header_7_subheader_subtitle_color'];
    }
    ?>
<style type="text/css">
/*
Header Start
----------------------------------*/
.logo {
	float: left;
    padding-bottom: 45px;
}
.mainheaderthree .logo {
    margin-top: 15px;
    padding-bottom: 0;
}
.nav_search {
	float: right;
	margin-top: 18px;
}
.ls-inner {
    z-index: 0 !important;
}
.mainheader .scroll-to-fixed-fixed .search {
    background: none;
}
.main_nav.scroll-to-fixed-fixed{
    top: 0px !important;
    border-bottom: 1px solid #DCDCDC;
}
/*
Navigation Start
----------------------------------*/
/*	Navigation Start
==========================*/
.navigation {
	position:relative;
	float:left;
}
.banner{
	margin-bottom:57px;
}
.main_nav{
	background-color:rgba(0,0,0,0.5);
	position:absolute;
    top: 117px !important;
}
.main_nav:before {
	background-color: <?php echo $header_nav_bgcolr; ?>;
	position: absolute;
	content: '';
	left: 0px;
	-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";
	filter: alpha(opacity=50);
	opacity: 0.5;
	top: 0px;
	width: 100%;
	height: 100%;
}
nav.navigation > ul{
	width:100%;
	height:64px;
}
nav.navigation > ul > li:hover{
    background-color: <?php echo $header_nav_hover_bgcolor; ?> !important;
}
nav.navigation > ul > li.current-menu-item,
nav.navigation ul > li.current-menu-ancestor,
nav.navigation > ul > li{
	float:left;
	height:50px;
	position:relative;
}
nav.navigation ul ul li:hover a{
	color: <?php echo $header_subnav_hover_color;?> !important;
}
nav.navigation > ul > li:hover > a{
	color: <?php echo $header_nav_hover_color;?> !important;
}
nav.navigation > ul > li > a{
	float:left;
	height:55px;
	padding:24px 25px 0px 25px;
	font-size:16px;
	color: <?php echo $header_nav_color;?>;
	z-index:999;
	position:relative;
	font-weight:300;
	text-transform:uppercase;
}
nav.navigation > ul > li.current-menu-item:after,
nav.navigation ul > li:after{
	content:"";
	border-top: 3px solid <?php echo $header_nav_hover_color;?> !important;
	position:absolute;
	left:0px;
	display:block;
	top:-2px;
	width:0%;
}
nav.navigation ul > li:hover:after,
nav.navigation > ul > li.current-menu-item:after,
nav.navigation ul > li.current-menu-ancestor:after{
	width:100%;
}
nav.navigation ul > li.current-menu-item > a,
nav.navigation ul > li.current-menu-ancestor > a{
	color:<?php echo $header_nav_active_color;?> !important;
    background:<?php echo $header_nav_active_bgcolor;?>;
}
nav.navigation ul ul > li.current-menu-item > a,
nav.navigation ul ul > li.current-menu-ancestor > a{
	color:<?php echo $header_subnav_active_color;?> !important;
    background:<?php echo $header_subnav_active_bgcolor;?>;
}
nav.navigation ul ul {
	float:left;
	position:absolute;
	top: 74px;
	left:50%;
	z-index:9999999999;
	background-color: <?php echo $header_subnav_bgcolr;?>;
	width:205px;
	padding: 0px;
	border: 5px solid <?php echo $header_subnav_border_colr;?>;
	border-radius:4px;
	-moz-border-radius:4px;
	-webkit-border-radius:4px;
	-webkit-transition:opacity .3s ease-in-out, margin .3s ease-in-out;
	-moz-transition:opacity .3s ease-in-out, margin .3s ease-in-out;
	-ms-transition:opacity .3s ease-in-out, margin .3s ease-in-out;
	-o-transition:opacity .3s ease-in-out, margin .3s ease-in-out;
	transition:opacity .3s ease-in-out, margin .3s ease-in-out;
	opacity:0;
	visibility:hidden;
	filter: alpha(opacity=0);
	margin-bottom:-25px;
	margin-left:-110px !important;
}
nav.navigation ul ul:after {
    border-color: transparent <?php echo $header_subnav_border_colr; ?>;
    border-style: solid;
    border-width: 11px 10px 11px 0;
    content: "";
    left: 50%;
    margin-left: -5px;
    position: absolute;
    top: -17px;
    -webkit-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    transform: rotate(90deg);
}
nav.navigation ul ul ul:after{
	border: none;
}
nav.navigation ul > li:hover > ul {
	opacity:1;
	filter: alpha(opacity=100);
	margin:0px 0px 0px 0px;
	visibility:visible;
}
nav.navigation ul ul li{
	float:left;
	width:100%;
	position:relative;
    height: auto !important;
}
nav.navigation ul ul ul {
	left:100%;
	top: 0;
	margin-left:0px !important;
}
nav.navigation ul ul a {
	width:100% !important;
	display:block;
	padding:9px 10px;
	margin:0;
	font-size:14px;
	color: <?php echo $header_subnav_color;?> !important;
	-webkit-box-sizing:border-box;
	-moz-box-sizing:border-box;
	box-sizing:border-box;
	text-transform:uppercase;
}
nav.navigation ul ul li:hover a{
    background-color: <?php echo $header_subnav_hover_bgcolor;?>
    color: <?php echo $header_subnav_hover_color;?>;
}
nav.navigation ul ul li:after, nav.navigation ul ul ul:before{display:none;}
nav.navigation ul ul ul a:hover {
	color:<?php echo $header_subnav_hover_color;?>;
}
nav.navigation select {
    display: none;
	width:100%;
	float:left;
	color: #999;
	padding:4px;
	margin:7px 0px 0px 0px;
	background-color: rgba(0,0,0,0.4);
	border:#5b4427 solid 1px;
	-webkit-box-sizing:border-box;
	-moz-box-sizing:border-box;
	box-sizing:border-box;
}
.topindex {
	position:relative;
	z-index:10;
}
.selectnav { 
	display: none;
}

/* Sticky Menu
===================================*/
.wrapper_boxed #stickyarea {
}
#stickyarea:before{
    background-color: <?php echo $header_nav_bgcolr ?>;
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";
    filter: alpha(opacity=70);
    opacity: 0.7;
}
#menubox-stick nav.navigation{
    margin-left: 50px;
    float: left;
}
#menubox-stick nav.navigation > ul > li {
    margin: 0px;
}
#menubox-stick nav.navigation > ul > li {
    height: 60px;
}
#menubox-stick .navigation ul ul{
	top: 75px;
}
#menubox-stick .navigation ul ul ul{
	top: 0px;
}
#stickyarea .navigation{
    margin-left: 50px;
}
#stickyarea #menubox-stick nav.navigation > ul > li > a{
    padding: 24px 15px 0;
}

/* Top Strip Start
=========================== */

.top-nav {
    float: left;
}
.top-nav > ul {
    margin: 0px;
	padding:0px;
}
.top-nav li {
    display: inline-block;
    list-style: none;
}
.top-nav a {
    color: #e4e4e4;
    float: left;
    font-size: 11px;
    padding: 5px 10px;
	position:relative;
	text-transform:uppercase;
}
.top-nav a:hover {
    color: #c1c1c1 !important;
}
.top-nav ul li a:active
.top-nav ul li a:focus {
	color: #e4e4e4;
	text-decoration:none;
	outline: none !important;
}
.top-strip ul li a:before{
	background-color: rgba(255,255,255,0.2);
	border-radius: 20px;
	position:absolute;
	content:"";
	top: 16px;
	left: -3px;
	width: 5px;
	height: 5px;
}
.top-strip ul li:first-child a:before {
    display: none;
}
.top-strip .info-box {
    float: right;
}
.top-strip .info-box p {
    color: #e4e4e4;
	display: inline-block;
    font-size: 10px;
    font-weight: 600;
	margin: 0;
    padding: 5px 0;
}
.top-strip .info-box p a{
	color:<?php echo $header_top_strip_color;?>;
	font-weight:600;
}
.header-section {
    background-color: <?php echo $header_bg_color;?>;
}
/*	Header Start
======================*/
.mainheader{
    background-color: rgba(0, 0, 0, 0.2);
	position:relative;
	z-index:2;
	padding: 0px 0px 0px 0px;
    min-height: 182px;
}
.mainheader:before{
    background-color: <?php echo $header_bg_color;?>;
    content: "";
    height: 100%;
    left: 0;
    position: absolute;
    top: 0;
    width: 100%;
    z-index: 1;
    -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=40)";
    filter: alpha(opacity=40);
    opacity: 0.4;
}
.our_story:before{
    background-color: rgba(0, 0, 0, 0.5);
    content: "";
    height: 100%;
    left: 0;
    position: absolute;
    top: 0;
    width: 100%;
    z-index: -1;
}
.mainheader .container{
	position:relative;
	z-index:4;
}
.logo{
	float:left;
	padding-bottom: 5px;
}
.login_nav{
	float:right;
	margin:12px 0px 0px 0px;
}
.login_nav ul li {
	margin:0px 0px 0px 13px;
}
.login_nav ul li:first-child{
	margin:0px 0px 0px 0px;
}
.login_nav ul li a {
	color:#828180;
	padding:5px 13px;
	border-radius:4px;
	-moz-border-radius:4px;
	-webkit-border-radius:4px;
}
.login_nav ul li.current_page_item > a, .login_nav ul li a:hover{
 	color:#e796a2;
}

/*====================================
    Header 1 Start
======================================*/

<?php if ( $header_styles == "header1" ){?>

.mainheader.mainheaderone{
    min-height: 146px;
}

#stickyarea:before {
    background-color: <?php echo $header_bg_color; ?>;
    position: absolute;
    content: '';
    left: 0px;
    -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";
    filter: alpha(opacity=50);
    opacity: 0.5;
    top: 0px;
    width: 100%;
    height: 100%;
}
#menubox-stick nav.navigation > ul > li > a{
    padding: 24px 15px 0;
}
.mainheaderone{
    background-image: url(<?php echo $header_bg_image ?>);
    padding-top: 35px;
    position:<?php echo $cs_position ?> !important;
}
.wrapper_boxed .mainheader.mainheaderone {
    width: 1270px;
}
.header1_slider_height{
    height: 415px;
}
.header1_slider_height.mainheaderone{
    background-image: none !important;
}
.header1_slider_height .main_nav {
    position: absolute;
    bottom: 0px;
    top: auto !important;
}
.mainheaderone nav.navigation > ul > li.current-menu-item,
.mainheaderone nav.navigation ul > li.current-menu-ancestor,
.mainheaderone nav.navigation > ul > li {
    float: left;
    height: 64px;
    position: relative;
}
.mainheaderone .login_nav ul li a{
    color: #fff;
}
.mainheaderone .main_nav:before {
    background-color: <?php echo $header_nav_bgcolr ?>;
    position: absolute;
    content: '';
    left: 0px;
    -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";
    filter: alpha(opacity=50);
    opacity: 0.5;
    top: 0px;
    width: 100%;
    height: 100%;
}
.mainheaderone .logo {
    padding-bottom: 25px;
}

/*====================================
    Header 1 End 
======================================*/

<?php } elseif ( $header_styles == "header2" ) {?>

/*====================================
    Header 2 Start 
======================================*/

.mainheadertwo #menubox-stick nav.navigation > ul > li > a{
    padding: 24px 15px 0;
}
.mainheader.mainheadertwo {
    padding: 0;
}
.mainheadertwo{
    background: <?php echo $header_bg_color;?>;
	float:left;
	width:100%;
	padding:0px;
}
.mainheadertwo:before{
    background: none;
}
.mainheadertwo .banner{
	margin-bottom:50px;
	position:relative;
	z-index:2;
}
.mainheadertwo .main_nav{
	background: <?php echo $header_nav_bgcolr;?>
}
.mainheadertwo .main_stripe {
	float:left;
	width:100%;
	padding:23px 0px 0px 0px;
}
.mainheadertwo .login_nav{
	margin-top:21px;
}
.mainheadertwo .logo{
	float: none;
	text-align: center;
}
.mainheadertwo .navigation {
    display: inline-block;
    float: none;
    text-align: center;
    width: 100%;
}
.mainheadertwo nav.navigation > ul {
	border-top: 1px solid #e4e4e4;
	text-align: center;
	float: none;
}
.mainheadertwo nav.navigation > ul li{
	float: none;
	display: inline-block;
}
.mainheadertwo nav.navigation > ul > li > a:before {
    background: none repeat scroll 0 0 #E2E2E2;
    border-radius: 10px 10px 10px 10px;
    content: "";
    height: 4px;
    position: absolute;
    right: -3px;
    top: 32px;
    width: 4px;
}
.mainheadertwo nav.navigation > ul > li:last-child > a:before{
    background: none;
}
.mainheadertwo nav.navigation > ul > li.current-menu-item:after,
.mainheadertwo nav.navigation ul > li.current-menu-ancestor:before,
.mainheadertwo nav.navigation ul > li:after{
	content:"";
	border-top: 1px solid <?php echo $header_nav_active_color;?> !important;
	position:absolute;
	left:0px;
	display:block;
	top:-1px;
	width:0%;
}
.mainheadertwo nav.navigation > ul > li:hover:before,
.mainheadertwo nav.navigation > ul > li:hover:after{
	width:100%;
}
.mainheadertwo nav.navigation > ul > li:before,
.mainheadertwo nav.navigation > ul > li.current-menu-ancestor:before,
.mainheadertwo nav.navigation > ul > li.current-menu-item:before{
	content:"";
	border-bottom: 3px solid <?php echo $header_nav_active_color;?> !important;
	position:absolute;
	left:0px;
	display:block;
	bottom: -4px;
	width:0%;
}
.mainheadertwo nav.navigation > ul > li.current-menu-item,
.mainheadertwo nav.navigation ul > li.current-menu-ancestor,
.mainheadertwo nav.navigation > ul > li{
	height: 60px;
}
.mainheadertwo nav.navigation > ul > li.current-menu-item:before,
.mainheadertwo nav.navigation > ul > li.current-menu-ancestor:before,
.mainheadertwo nav.navigation > ul > li.current-menu-item:after,
.mainheadertwo nav.navigation > ul > li.current-menu-ancestor:after{
	width: 100%;
}
.mainheadertwo nav.navigation > ul ul li{
	text-align: left;
}
.mainheadertwo nav.navigation > ul > li > a{
	padding: 24px 20px 0;
}
.mainheadertwo .search {
    border: 1px solid #c5c5c5;
    background-color: #fff;
    border-radius: 50px;
    height: 32px;
    padding: 0;
    position: absolute;
    right: 0;
    top: -19px;
    width: 32px;
    text-align: center;
}
.mainheadertwo .search a {
    color: #D2D1CF;
    line-height: 31px;
    margin: 0;
}
.mainheadertwo .search-box {
    background-color: #E0E0E0;
    border-radius: 5px;
    -webkit-box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    -moz-box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    bottom: -72px;
    height: 41px;
    padding: 8px;
    position: absolute;
    right: -15px;
    top: auto;
    z-index: 999;
	width: 368px;
}
.mainheadertwo .search-box:before {
    border-color: transparent #E0E0E0 !important;
	border-style: solid;
	border-width: 10px 10px 0 0;
	content: "";
	position: absolute;
	right: 24px;
	top: -6px;
	bottom: auto;
	-webkit-transform: rotate(225deg);
	-moz-transform: rotate(225deg);
	-o-transform: rotate(225deg);
	-ms-transform: rotate(225deg);
	transform: rotate(225deg);
}
.mainheadertwo .search input[type="text"] {
    border-radius: 3px;
    -webkit-box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
    -moz-box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
    color: #8e8e8e;
    float: left;
    height: 40px;
    padding: 5px 10px;
    width: 279px;
}
.search-box > form {
    float: left;
}
.mainheadertwo .search input[type="submit"] {
    border: none;
    border-radius: 3px;
    color: #fff;
    float: left;
    height: 40px;
    margin-left: 5px;
    padding: 5px 10px 5px 25px;
}
.mainheadertwo .search-box label {
    float: left;
    position: relative;
}
.mainheadertwo .search-box label i {
    color: #FFFFFF;
    font-size: 14px;
    left: 13px;
    position: absolute;
    top: 13px;
    z-index: 9;
}
/*====================================
	Header 2 End 
======================================*/

<?php } elseif ( $header_styles == "header3" ){?>

/*====================================
 	Header 3 Start 
======================================*/

.mainheaderthree {
    border-top: 4px solid <?php echo $header_nav_hover_color;?>;
    min-height: 177px;
}
.mainheaderthree .nav_bar{
	min-height: 113px;
	background-color: <?php echo $header_bg_color;?>;
    width: 100%;
}

.mainheaderthree nav.navigation > ul > li.current-menu-item,
.mainheaderthree nav.navigation ul > li.current-menu-ancestor,
.mainheaderthree nav.navigation > ul > li{
    float:left;
    height:64px;
    position:relative;
}
.mainheaderthree .search input[type="text"] {
	border: 1px solid #dbdbdb;
    border-radius: 3px;
    color: #8e8e8e;
    float: left;
    height: 40px;
    padding: 5px 10px;
    width: 279px;
}
.mainheaderthree .search input[type="submit"] {
    border: none;
    border-radius: 3px;
    color: #fff;
    float: left;
    height: 40px;
    margin-left: 5px;
    padding: 5px 10px 5px 25px;
    position: relative;
}
.mainheaderthree .search-box label {
    float: left;
    position: relative;
}
.mainheaderthree .search-box label i {
    color: #FFFFFF;
    font-size: 14px;
    left: 13px;
    position: absolute;
    top: 13px;
    z-index: 9;
}
.mainheaderthree .search-box{
	height: 40px;
    position: relative;
    top: 0;
    width: 368px;
}
.mainheaderthree .search-box:before{
	border: none;
}
.mainheaderthree .search a {
    display: none;
}
.mainheaderthree .search{
	height: 40px;
	margin-left: 20px;
	padding: 0px;
}
.mainheaderthree .sidelogin {
    float: right;
    position: relative;
    top: 35px;
    width: auto;
}
.mainheaderthree .login_nav ul li.current_page_item > a,
.mainheaderthree .login_nav ul li a:hover {
    background: none !important;
    border-bottom: 1px solid <?php echo $header_nav_active_color;?>;
}
.mainheaderthree .login_nav ul li{
	position: relative;
	padding: 0px 13px;
}
.mainheaderthree .login_nav ul li a{
	border-radius: 0px;
	padding: 5px 0;
}
.mainheaderthree .login_nav ul li::before {
	content: '/';
	position: absolute;
	right: -8px;
	top: 0px;
	color: #d6d6d6;
}
.mainheaderthree .login_nav:first-child:before{
	content: '';
}
.mainheaderthree .login_nav ul li:first-child{
	margin: 0 0 0 13px;
}
.mainheaderthree .main_nav {
    float: left;
    width: 100%;
    position: relative;.
    background: none;
    top: 0px !important;
}
.mainheaderthree .main_nav:before{
	background-color: <?php echo $header_nav_bgcolr; ?> !important;
	-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=85)";
	filter: alpha(opacity=85);
	opacity: 0.85;
	content: "";
    left: 0;
    position: absolute;
    top: 0;
    width: 100%;
}
.mainheaderthree nav.navigation > ul > li > a{
	padding: 24px 25px 0px;
}
.mainheaderthree .login_nav.login-section ul li:before {
    content: "";
}
/*====================================
 	Header 3 End 
======================================*/

<?php } elseif ( $header_styles == "header4" ){?>

/*====================================
 	Header 4 Start 
======================================*/

.mainheaderfour nav.navigation > ul > li.current-menu-item:after,
.mainheaderfour nav.navigation ul > li:after{
	top: auto;
	bottom: -3px;
}
.mainheaderfour nav.navigation > ul > li.current-menu-item,
.mainheaderfour nav.navigation ul > li.current-menu-ancestor,
.mainheaderfour nav.navigation > ul > li{
	height: 64px;
}
.mainheaderfour nav.navigation ul > ul{
	top:  78px;
}
.mainheaderfour .main_stripe {
    -webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	-ms-box-sizing: border-box;
	box-sizing: border-box;
	min-height: 130px;
	padding-top: 35px;
	background-color: <?php echo $header_bg_color; ?>;
}
.mainheaderfour .main_nav{
	background-color: <?php echo $header_nav_bgcolr; ?>;
}
.mainheaderfour .search input[type="text"] {
	border: 1px solid #dbdbdb;
    border-radius: 3px;
    color: #8e8e8e;
    float: left;
    height: 40px;
    padding: 5px 10px;
    width: 279px;
}
.mainheaderfour .search input[type="submit"] {
    border: none;
    border-radius: 3px;
    color: #fff;
    float: left;
    height: 40px;
    margin-left: 5px;
    padding: 5px 10px 5px 25px;
    position: relative;
}
.mainheaderfour .search-box label {
    float: left;
    position: relative;
}
.mainheaderfour .search-box label i {
    color: #FFFFFF;
    font-size: 14px;
    left: 13px;
    position: absolute;
    top: 13px;
    z-index: 9;
}
.mainheaderfour .search a {
    color: #fff;
}
.mainheaderfour .search-box {
    background-color: #E0E0E0;
    border-radius: 5px;
    -webkit-box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    -moz-box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    bottom: -72px;
    height: 41px;
    padding: 8px;
    position: absolute;
    right: -5px;
    top: auto;
    z-index: 999;
	width: 368px;
}
.mainheaderfour .search-box:before {
    border-color: transparent #E0E0E0 !important;
	border-style: solid;
	border-width: 10px 10px 0 0;
	content: "";
	position: absolute;
	right: 24px;
	top: -5px;
	bottom: auto;
	-webkit-transform: rotate(225deg);
	-moz-transform: rotate(225deg);
	-o-transform: rotate(225deg);
	-ms-transform: rotate(225deg);
	transform: rotate(225deg);
}

/*====================================
 	Header 4 End 
======================================*/

<?php } elseif ( $header_styles == "header5" ){?>

/*====================================
 	Header 5 Start 
======================================*/

.mainheaderfive .search {
    border: 1px solid #c5c5c5;
    background-color: #fff;
    border-radius: 50px;
    height: 32px;
    padding: 0;
    position: relative;
    right: 0;
    top: 0px;
    width: 32px;
    text-align: center;
}
.mainheaderfive {
    min-height: 112px;
}
.mainheaderfive .search a {
    color: #D2D1CF;
    line-height: 31px;
    margin: 0;
}
.mainheaderfive .search-box {
    background-color: #E0E0E0;
    border-radius: 5px;
    -webkit-box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    -moz-box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    bottom: -72px;
    height: 41px;
    padding: 8px;
    position: absolute;
    right: -15px;
    top: auto;
    z-index: 9999;
	width: 368px;
}
.mainheaderfive .search-box:before {
    border-color: transparent #E0E0E0 !important;
	border-style: solid;
	border-width: 10px 10px 0 0;
	content: "";
	position: absolute;
	right: 24px;
	top: -6px;
	bottom: auto;
	-webkit-transform: rotate(225deg);
	-moz-transform: rotate(225deg);
	-o-transform: rotate(225deg);
	-ms-transform: rotate(225deg);
	transform: rotate(225deg);
}
.mainheaderfive .search input[type="text"] {
    border-radius: 3px;
    -webkit-box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
    -moz-box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
    color: #8e8e8e;
    float: left;
    height: 40px;
    padding: 5px 10px;
    width: 279px;
}
.mainheaderfive .search input[type="submit"] {
    border: none;
    border-radius: 3px;
    color: #fff;
    float: left;
    height: 40px;
    margin-left: 5px;
    padding: 5px 10px 5px 25px;
    position: relative;
}
.mainheaderfive .search-box label {
    float: left;
    position: relative;
}
.mainheaderfive .search-box label i {
    color: #FFFFFF;
    font-size: 14px;
    left: 13px;
    position: absolute;
    top: 13px;
    z-index: 9;
}
.mainheaderfive .main_stripe {
    -webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	-ms-box-sizing: border-box;
	box-sizing: border-box;
    border-top: 3px solid <?php echo $header_nav_hover_color;?>;
	min-height: 112px;
	background-color: <?php echo $header_bg_color; ?>;
}
.mainheaderfive .logo{
    padding-top: 29px;
}
.mainheaderfive #stickyarea #menubox-stick nav.navigation > ul > li > a:before,
.mainheaderfive #stickyarea #menubox-stick nav.navigation > ul > li > a {
    color: #f7f7f7;
}
.mainheaderfive #menubox-stick nav.navigation > ul > li{
    height: 67px;
}
.mainheaderfive #stickyarea #menubox-stick nav.navigation > ul > li > a{
    padding: 24px 20px 0;
}
.mainheaderfive .top-icons {
    float: right;
    margin-left: 15px;
    position: relative;
    top: 10px;
    padding-top: 29px;
}
.mainheaderfive nav.navigation {
    float: right;
}
.mainheaderfive nav.navigation > ul > li.current-menu-item,
.mainheaderfive nav.navigation ul > li.current-menu-ancestor,
.mainheaderfive nav.navigation > ul > li{
	height: 109px;
}
.mainheaderfive nav.navigation > ul > li > a{
	height: 85px;
	padding: 44px 20px 0px;
	position: relative;
}
.mainheaderfive nav.navigation > ul > li > a:before {
	content: '//';
	position: absolute;
	right: -5px;
	color: rgba(142,142,142,0.3);
}
.mainheaderfive nav.navigation > ul > li:last-child > a:before {
    content: "";
}
.mainheaderfive nav.navigation ul ul{
	top: 120px;
}
.mainheaderfive nav.navigation ul ul ul {
    top: 0;
}
.mainheaderfive nav.navigation > ul > li.current-menu-item:after,
.mainheaderfive nav.navigation ul > li:after{
	top: auto;
	bottom: 0px;
}


/*====================================
 	Header 5 End 
======================================*/

<?php } elseif ( $header_styles == "header6" ){?>

/*====================================
 	Header 6 Start 
======================================*/

.mainheadersix {
    background: <?php echo $header_bg_color; ?>;
    float: none;
    left: 50%;
    margin: 28px auto 0 -575px;
    position:<?php echo $cs_position ?> !important;
    width: 1172px;
    height: 181px;
}
.mainheadersix #menubox-stick nav.navigation > ul > li{
    height: 67px;
}
.wrapper_boxed .mainheadersix{
    margin: 28px auto 0 -635px;
    width: 1270px;
}
.wrapper_boxed .mainheadersix .main_stripe{
    padding: 25px 50px 0;
}
.mainheadersix::before {
    content: '';
    background: none;
}
.mainheadersix .search {
    border: 1px solid #c5c5c5;
    background-color: #fff;
    border-radius: 50px;
    height: 32px;
    padding: 0;
    position: relative;
    right: 0;
    top: 0px;
    width: 32px;
    text-align: center;
}
.mainheadersix #menubox-stick nav.navigation > ul > li{
    height: 67px;
}
.mainheadersix .search a {
    color: #D2D1CF;
    line-height: 31px;
    margin: 0;
}
.mainheadersix .search-box {
    background-color: #E0E0E0;
    border-radius: 5px;
    -webkit-box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    -moz-box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    bottom: -72px;
    height: 41px;
    padding: 8px;
    position: absolute;
    right: -15px;
    top: auto;
    z-index: 9999;
	width: 368px;
}
.mainheadersix .search-box:before {
    border-color: transparent #E0E0E0 !important;
	border-style: solid;
	border-width: 10px 10px 0 0;
	content: "";
	position: absolute;
	right: 24px;
	top: -6px;
	bottom: auto;
	-webkit-transform: rotate(225deg);
	-moz-transform: rotate(225deg);
	-o-transform: rotate(225deg);
	-ms-transform: rotate(225deg);
	transform: rotate(225deg);
}
.mainheadersix .search input[type="text"] {
    border-radius: 3px;
    -webkit-box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
    -moz-box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
    color: #8e8e8e;
    float: left;
    height: 40px;
    padding: 5px 10px;
    width: 279px;
}
.mainheadersix .search input[type="submit"] {
    border: none;
    border-radius: 3px;
    color: #fff;
    float: left;
    height: 40px;
    margin-left: 5px;
    padding: 5px 10px 5px 25px;
    position: relative;
}
.mainheadersix .search-box label {
    float: left;
    position: relative;
}
.mainheadersix .search-box label i {
    color: #FFFFFF;
    font-size: 14px;
    left: 13px;
    position: absolute;
    top: 13px;
    z-index: 9;
}
.mainheadersix .sidelogin {
    float: right;
    position: relative;
    top: 35px;
    width: auto;
}
.mainheadersix .login_nav ul li.current_page_item > a,
.mainheadersix .login_nav ul li a:hover {
    background: none !important;
    border-bottom: 1px solid <?php echo $header_nav_active_color;?>;
}
.mainheadersix .login_nav ul li{
	position: relative;
	padding: 0px 13px;
}
.mainheadersix .login_nav ul li a{
	border-radius: 0px;
	padding: 5px 0;
}
.mainheadersix .login_nav ul li::before {
	content: '/';
	position: absolute;
	right: -8px;
	top: 0px;
	color: #d6d6d6;
}
.mainheadersix .login_nav:first-child:before{
	content: '';
}
.mainheadersix .login_nav ul li:first-child{
	margin: 0 0 0 13px;
}
.mainheadersix .login-section ul li:before {
    content: "" !important;
}
.mainheadersix .main_stripe {
    -webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	-ms-box-sizing: border-box;
	box-sizing: border-box;
    border-top: 3px solid <?php echo $header_nav_hover_color;?>;
	min-height: 93px;
	padding: 25px 25px 0;
}
.mainheadersix .main_nav{
	background: none;
}
.mainheadersix nav.navigation > ul > li:before {
    content: "//";
    margin-top: -8px;
    position: absolute;
    right: -3px;
    top: 50%;
    color: rgba(142,142,142,0.3);
}
.mainheadersix nav.navigation > ul > li:last-child:before {
    content: "";
}
.mainheadersix nav.navigation > ul > li.current-menu-item:after,
.mainheadersix nav.navigation ul > li:after{
	top: auto;
	bottom: 0px;
	border-top: 2px solid <?php echo $header_nav_hover_color;?>;
}
.mainheadersix nav.navigation > ul > li.current-menu-item,
.mainheadersix nav.navigation ul > li.current-menu-ancestor,
.mainheadersix nav.navigation > ul > li{
	height: 64px;
}
.mainheadersix nav.navigation > ul{
	margin-left: 20px;
}
.mainheadersix .top-icons {
    float: right;
    position: relative;
    z-index: 2;
}
.mainheadersix .login_nav {
    margin-top: 6px;
}

/*====================================
 	Header 6 End 
======================================*/

<?php } elseif ( $header_styles == "header7" ){?>

/*====================================
 	Header 7 Start 
======================================*/

.mainheaderseven {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    -ms-box-sizing: border-box;
    box-sizing: border-box;
    min-height: 217px;
    background: <?php echo $header_bg_color; ?>;
}
.mainheaderseven .main_nav{
    top: 154px !important;
}
.mainheaderseven .top-strip{
    background: <?php echo $header_top_strip_bg_color; ?>;
    border-bottom: 1px solid #dcdcdc;
}
.mainheaderseven .top-strip .top-nav,
.mainheaderseven .top-strip .login_nav{
    margin-top: 0px;
}
.mainheaderseven .top-icons {
    float: right;
}
.mainheaderseven .login_nav li {
    border-left: 1px solid #dcdcdc;
    border-right: 1px solid #dcdcdc;
    height: 35px;
}
.mainheaderseven .top-nav ul li{
    border-left: 1px solid #dcdcdc;
    height: 35px;
}
.mainheaderseven .top-nav ul li a,
.mainheaderseven .login_nav ul li a{
    color: #666;
    float: left;
    padding: 8px 20px 8px 20px;
}
.mainheaderseven .top-nav ul li:hover > a,
.mainheaderseven .login_nav ul li:hover > a{
    background: #fff !important;
    border-radius: 0px;
    border-bottom: 2px solid <?php echo $header_nav_hover_color;?>;
}
.mainheaderseven .main_stripe{
    padding-top: 35px;
    padding-bottom: 35px;
}
.mainheaderseven::before {
    content: '';
    background: none;
}
.mainheaderseven .search:before {
    color: #848484;
    content: "Search";
    font-size: 16px;
    left: -70px;
    position: absolute;
    top: 8px;
    cursor: default;
}
.mainheaderseven .search input[type="text"] {
    border: 1px solid #dbdbdb;
    border-radius: 3px;
    color: #8e8e8e;
    float: left;
    height: 40px;
    padding: 5px 10px;
    width: 279px;
}
.mainheaderseven .search input[type="submit"] {
    border: none;
    border-radius: 3px;
    color: #fff;
    float: left;
    height: 40px;
    margin-left: 5px;
    padding: 5px 10px 5px 25px;
    position: relative;
}
.mainheaderseven .search input[type="submit"]:before {
    content: '\f002';
    position: absolute;
    color: #fff;
    left: 5px;
    top: 5px;
    width: 15px;
    height: 15px;
}
.mainheaderseven .search-box{
    height: 40px;
    position: relative;
    top: 0;
    width: 368px;
    display: inline !important;
}
.mainheaderseven .main_nav.scroll-to-fixed-fixed{
    top: 0px !important;
}
.mainheaderseven .search-box:before{
    border: none;
}
.mainheaderseven .search a {
    display: none;
}
.mainheaderseven .search{
    height: 40px;
    margin-left: 20px;
    padding: 0px;
}
.mainheaderseven .social-network {
    float: right;
    position: relative;
    top: 7px;
    right: 10px;
}
.mainheaderseven .social-network > a {
    color: #ccc;
    font-size: 16px;
    margin : 0 6px;
}
.mainheaderseven .social-network > a:hover{
    color: <?php echo $header_nav_hover_color;?>;
}
.mainheaderseven .social-network .icon-2 {
    font-size: 16px;
}
.mainheaderseven .search-box label {
    float: left;
    position: relative;
}
.mainheaderseven .search-box label i {
    color: #FFFFFF;
    font-size: 14px;
    left: 13px;
    position: absolute;
    top: 13px;
    z-index: 9;
}
.mainheaderseven nav.navigation > ul > li > a:before {
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 10px 10px 10px 10px;
    content: "";
    height: 5px;
    position: absolute;
    right: -2px;
    top: 32px;
    width: 5px;
}
.mainheaderseven nav.navigation > ul > li:last-child > a:before{
    background: none;
}
.mainheaderseven nav.navigation > ul > li.current-menu-item,
.mainheaderseven nav.navigation ul > li.current-menu-ancestor,
.mainheaderseven nav.navigation > ul > li {
    float: left;
    height: 64px;
    position: relative;
}

/*====================================
 	Header 7 End 
======================================*/

<?php }?>
/*
Sub Header Title
*/

.breadcrumb{
    color: <?php echo $header_subheader_link_color;?> !important;
    background-color: <?php echo $header_subheader_bgcolor;?> !important;
}
.breadcrumb .breadcrumb-inner .text h1{
    color: <?php echo $header_subheader_title_color;?> !important;
}
.breadcrumb .breadcrumb-inner .text p{
    color: <?php echo $header_subheader_subtitle_color;?> !important;
}
.breadcrumb .breadcrumb-inner .breadcrumbs ul li a{
    color: <?php echo $header_subheader_link_color;?> !important;
}
/* Header styles */
</style>
   <?php
    } 
 
}
/*
Header Styes End
*/
/*
 * Ccustom Header Styles 1 -4
 */
function cs_custom_header_styles($header_styles) {
    global $cs_theme_option, $header1_slider_height;
      if ( $header_styles == "header1" )
      { 
?>
   <!-- Header 1 Start -->
     <header class="header-1 mainheader mainheaderone  <?php echo $header1_slider_height ?>">
        <!-- Header Section Start -->
         	<!-- Container Start -->
        	<div class="container">
            	<?php if(isset($cs_theme_option['header_1_logo']) && !empty($cs_theme_option['header_1_logo']) && $cs_theme_option['header_1_logo'] == 'on' && isset($cs_theme_option['logo']) && !empty($cs_theme_option['logo'])){ ?>
                <!-- Logo Start -->
                <div class="logo">
                    <?php cs_logo($cs_theme_option['logo'], $cs_theme_option['logo_width'], $cs_theme_option['logo_height']); ?>
                </div>
                <!-- Logo End -->
            <?php }?>
                 <!-- Login Nav Start -->
                 	<?php if($cs_theme_option['header_1_login']=='on'){	cs_login('Login', 'Logout'); }?>
                 	<div class="login_nav">
                 	<?php cs_navigation($cs_theme_option['header_1_top_strip_menu'], 'top_strip_menus'); ?>
                    </div>
                      <!-- Login Nav End --> 
                      
               	</div>
				<!-- Container End --> 
                <!-- Main Nav Start -->
                <div class="main_nav"> 
                  <!-- Container Start -->
                  <div class="container"> 
                  	<!-- Navigation Start -->  
			        <nav class="navigation">
                    	<?php cs_navigation('main-menu'); ?>
                	</nav>
                	<!-- Navigation End -->
                	<!-- Search Start -->
                <?php cs_header_search(); ?>
                <!-- Search End -->
              	</div>
      			<!-- Container End --> 
   			 </div>
    	<!-- Main Nav End --> 
    </header>
	<!-- Header Section End -->
    <!-- Header 1 End -->          
<?php }elseif ( $header_styles == "header2" ){ ?>
    <!-- Header 2 Start -->
    <header class="mainheader mainheadertwo header-2">
        <!-- Main Strip Start -->
		<div class="main_stripe">
        	<!-- Container Start -->
        	<div class="container">
            <?php if(isset($cs_theme_option['header_2_logo']) && !empty($cs_theme_option['header_2_logo']) && $cs_theme_option['header_2_logo'] == 'on' && isset($cs_theme_option['logo']) && !empty($cs_theme_option['logo'])){ ?>
                <!-- Logo Start -->
                <div class="logo">
                    <?php cs_logo($cs_theme_option['logo'], $cs_theme_option['logo_width'], $cs_theme_option['logo_height']); ?>
                </div>
                <!-- Logo End -->
            <?php }?>
                <!-- Login Nav Start -->
                	<?php //if($cs_theme_option['header_2_login']=='on'){	cs_login('Login', 'Logout'); }?>
                 	<div class="login_nav">
                 	<?php //cs_navigation($cs_theme_option['header_2_top_strip_menu'], 'top_strip_menus'); ?>
                    </div>
                <!-- Login Nav End -->
            </div>
            <!-- Container End -->
        </div>
        <!-- Main Strip End -->
        <!-- Main Nav Start -->
        <div class="main_nav">
        	<!-- Container Start -->
            <div class="container">
                <!-- Navigation Start -->
                <nav class="navigation">
                    <?php cs_navigation('main-menu'); ?>
                </nav>
                <!-- Navigation End -->
                <!-- Search Start -->
				<?php cs_header_search_box(); ?>
                <!-- Search End -->
            </div>
            <!-- Container End -->
        </div>
        <!-- Main Nav End -->
    
	</header>
    
    <!-- Header 2 End -->            
<?php }elseif ( $header_styles == "header3" ){ ?>
    
    <!-- Header 3 Start -->
    <header class="mainheader mainheaderthree header-3">
        <!-- Main Nav Start -->
        <div class="nav_bar">
        	<!-- Container Start -->
            <div class="container">
            	<?php if(isset($cs_theme_option['header_3_logo']) && !empty($cs_theme_option['header_3_logo']) && $cs_theme_option['header_3_logo'] == 'on' && isset($cs_theme_option['logo']) && !empty($cs_theme_option['logo'])){ ?>
                <!-- Logo Start -->
                <div class="logo">
                    <?php cs_logo($cs_theme_option['logo'], $cs_theme_option['logo_width'], $cs_theme_option['logo_height']); ?>
                </div>
                <!-- Logo End -->
            <?php }?>
                <!-- Main Strip Start -->
				<div class="sidelogin">
		            <!-- Search Start -->
		            <?php cs_header_search_box(); ?>
		            <!-- Search End -->
	                <!-- Login Nav Start -->
	                <?php if($cs_theme_option['header_3_login']=='on'){	cs_login('Login', 'Logout'); }?>
	                <div class="login_nav">
	                <?php cs_navigation($cs_theme_option['header_3_top_strip_menu'], 'top_strip_menus'); ?>
	                </div>
	                <!-- Login Nav End -->
		        </div>
		        <!-- Main Strip End -->
            </div>
            <!-- Container End -->
        </div>
        <!-- Main Nav End -->
        <!-- Nav Baar Satart -->
        <div class="main_nav">
        	<!-- Container Start -->
            <div class="container">
	        	<!-- Navigation Start -->
	            <nav class="navigation">
	                <?php cs_navigation('main-menu'); ?>
	            </nav>
	            <!-- Navigation End -->
            </div>
            <!-- Container End -->
        </div>
        <!-- Nav Baar End -->
            
	</header>
    <!-- Header End -->  
<?php } elseif ($header_styles == "header4") {?>
<!-- Header 4 Start -->
<header class="mainheader mainheaderfour header-4">
        <!-- Main Strip Start -->
		<div class="main_stripe">
        	<!-- Container Start -->
        	<div class="container">
            <?php if(isset($cs_theme_option['header_4_logo']) && !empty($cs_theme_option['header_4_logo']) && $cs_theme_option['header_4_logo'] == 'on' && isset($cs_theme_option['logo']) && !empty($cs_theme_option['logo'])){ ?>
                <!-- Logo Start -->
                <div class="logo">
                    <?php cs_logo($cs_theme_option['logo'], $cs_theme_option['logo_width'], $cs_theme_option['logo_height']); ?>
                </div>
                <!-- Logo End -->
            <?php }?>
            	
                <!-- Login Nav Start -->
                	<?php if($cs_theme_option['header_4_login']=='on'){	cs_login('Login', 'Logout'); }?>
                 	<div class="login_nav">
                 	<?php cs_navigation($cs_theme_option['header_4_top_strip_menu'], 'top_strip_menus'); ?>
                    </div>
                <!-- Login Nav End -->
            </div>
            <!-- Container End -->
        </div>
        <!-- Main Strip End -->
        <!-- Main Nav Start -->
        <div class="main_nav">
        	<!-- Container Start -->
            <div class="container">
                <!-- Navigation Start -->
                <nav class="navigation">
                    <?php cs_navigation('main-menu'); ?>
                </nav>
                <!-- Navigation End -->
                <!-- Search Start -->
				<?php cs_header_search_box(); ?>
                <!-- Search End -->
            </div>
            <!-- Container End -->
        </div>
        <!-- Main Nav End -->
 
	</header>
<!-- Header 4 End --> 
<?php } elseif ($header_styles == "header5") {?>
<!-- Header 5 Start -->

<header class="mainheader mainheaderfive header-5">
        <!-- Header Section Start -->
        <div class="main_stripe">
        	<!-- Container Start -->
        	<div class="container">
            	<?php if(isset($cs_theme_option['header_5_logo']) && !empty($cs_theme_option['header_5_logo']) && $cs_theme_option['header_5_logo'] == 'on' && isset($cs_theme_option['logo']) && !empty($cs_theme_option['logo'])){ ?>
                <!-- Logo Start -->
                <div class="logo">
                    <?php cs_logo($cs_theme_option['logo'], $cs_theme_option['logo_width'], $cs_theme_option['logo_height']); ?>
                </div>
                <!-- Logo End -->
            <?php }?>
                <div class="top-icons">
                    <!-- Search Start -->
                    <?php cs_header_search_box();?>
                    <!-- Search End -->
                </div>
                <!-- Navigation Start -->
                <nav class="navigation">
                     <?php cs_navigation('main-menu'); ?>
                </nav>
                <!-- Navigation End -->
            </div>
            <!-- Container End -->
        </div>
        <!-- Header Section End -->
    </header>
<!-- Header 5 End --> 
<?php } elseif ($header_styles == "header6") {?>
<!-- Header 6 Start -->
<header class="mainheader mainheadersix header-6">
        <!-- Header Section Start -->
        <div class="main_stripe">
			<?php if(isset($cs_theme_option['header_6_logo']) && !empty($cs_theme_option['header_6_logo']) && $cs_theme_option['header_6_logo'] == 'on' && isset($cs_theme_option['logo']) && !empty($cs_theme_option['logo'])){ ?>
                <!-- Logo Start -->
                <div class="logo">
                    <?php cs_logo($cs_theme_option['logo'], $cs_theme_option['logo_width'], $cs_theme_option['logo_height']); ?>
                </div>
                <!-- Logo End -->
            <?php }?>
            <div class="top-icons">
             	<?php cs_header_search_box();?>
             	<?php if($cs_theme_option['header_6_login']=='on'){	cs_login('Login', 'Logout'); }?>
             	<div class="login_nav">
             	<?php cs_navigation($cs_theme_option['header_6_top_strip_menu'], 'top_strip_menus'); ?>
                </div>
                  <!-- Login Nav End -->
            </div>
        </div>
        <!-- Header Section End -->
        <!-- Main Menu Start -->
        <div class="main_nav">
            <!-- Container Start -->
            <div class="container">
                <!-- Navigation Start -->
                <nav class="navigation">
                   <?php cs_navigation('main-menu'); ?>
                </nav>
                <!-- Navigation End -->
            </div>
            <!-- Container End -->
        </div>
        <!-- Main Menu End -->
    </header>
<!-- Header 6 End --> 
<?php } elseif ($header_styles == "header7") {?>
<!-- Header 7 Start -->
<header class="mainheader mainheaderseven header-7">
    <div class="top-strip">
        	<!-- Container Start -->
        	<div class="container">
            	<div class="top-icons">
            		<!-- Top Nav Start -->
					<?php if(isset($cs_theme_option['header_7_strip']) && $cs_theme_option['header_7_strip']=='on'){
						cs_header_top_strip($cs_theme_option['header_7_top_strip_menu'], '', $header_styles, $cs_theme_option['header_7_login']);
					}?>
                </div>   
                <?php 
                if($cs_theme_option['header_7_social_icons']=='on'){
                    cs_social_network(); 
                } ?>
            </div>
            <!-- Container End -->
        </div>
     <!-- Header Section Start -->
    <div class="main_stripe">
        <!-- Container Start -->
        <div class="container">
            <?php if(isset($cs_theme_option['header_7_logo']) && !empty($cs_theme_option['header_7_logo']) && $cs_theme_option['header_7_logo'] == 'on' && isset($cs_theme_option['logo']) && !empty($cs_theme_option['logo'])){ ?>
                <!-- Logo Start -->
                <div class="logo">
                    <?php cs_logo($cs_theme_option['logo'], $cs_theme_option['logo_width'], $cs_theme_option['logo_height']); ?>
                </div>
                <!-- Logo End -->
            <?php }?>
           <?php cs_header_search_box();?>
        </div>
    </div>
    <!-- Container End -->      
    <!-- Main Menu Start -->
    <div class="main_nav">
        <!-- Container Start -->
        <div class="container">
            <!-- Navigation Start -->
            <nav class="navigation">
               <?php cs_navigation('main-menu'); ?>
            </nav>
            <!-- Navigation End -->
        </div>
        <!-- Container End -->
    </div>
    <!-- Main Menu End -->
</header>
<!-- Header 7 End --> 

<?php }
}
/*
 * Ccustom Header Styles  1 -7 End
*/
?>