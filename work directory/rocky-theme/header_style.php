<?php
/*
Header Styes
*/
function cs_header_style() {
      global $cs_theme_option, $post,$cs_position;
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
		$header_top_strip_bg_color = $cs_theme_option['header_1_top_strip_bg_color'];
		$header_bg_color = $cs_theme_option['header_1_bgcolor'];
		$header_top_strip_color = $cs_theme_option['header_1_top_strip_color'];
        $header_nav_color = $cs_theme_option['header_1_nav_color'];
        $header_nav_hover_color = $cs_theme_option['header_1_nav_hover_color'];
        $header_nav_active_color = $cs_theme_option['header_1_nav_active_color'];
        $header_subnav_bgcolr = $cs_theme_option['header_1_subnav_bgcolr'];
        $header_subnav_color = $cs_theme_option['header_1_subnav_color'];
        $header_subnav_hover_color = $cs_theme_option['header_1_subnav_hover_color'];
        $header_subnav_hover_bgcolor = $cs_theme_option['header_1_subnav_hover_bgcolor'];
        $header_subnav_active_color = $cs_theme_option['header_1_subnav_active_color'];
        $header_subnav_active_bgcolor = $cs_theme_option['header_1_subnav_active_bgcolor'];
        $header_subheader_bgcolor = $cs_theme_option['header_1_subheader_bgcolor'];
        $header_subheader_link_color = $cs_theme_option['header_1_subheader_link_color'];
        $header_subheader_title_color = $cs_theme_option['header_1_subheader_title_color'];

    }
  
    elseif ( $header_styles == "header2" ) {
		$header_top_strip_bg_color = $cs_theme_option['header_2_top_strip_bg_color'];
		$header_bg_color = $cs_theme_option['header_2_nav_bgcolr'];
		$header_top_strip_color = $cs_theme_option['header_2_top_strip_color'];
        $header_nav_bgcolr = $cs_theme_option['header_2_nav_bgcolr'];
        $header_nav_color = $cs_theme_option['header_2_nav_color'];
        $header_nav_hover_color = $cs_theme_option['header_2_nav_hover_color'];
        $header_nav_active_color = $cs_theme_option['header_2_nav_active_color'];
        $header_subnav_bgcolr = $cs_theme_option['header_2_subnav_bgcolr'];
        $header_subnav_color = $cs_theme_option['header_2_subnav_color'];
        $header_subnav_hover_color = $cs_theme_option['header_2_subnav_hover_color'];
        $header_subnav_hover_bgcolor = $cs_theme_option['header_2_subnav_hover_bgcolor'];
        $header_subnav_active_color = $cs_theme_option['header_2_subnav_active_color'];
        $header_subnav_active_bgcolor = $cs_theme_option['header_2_subnav_active_bgcolor'];
        $header_subheader_bgcolor = $cs_theme_option['header_2_subheader_bgcolor'];
        $header_subheader_link_color = $cs_theme_option['header_2_subheader_link_color'];
        $header_subheader_title_color = $cs_theme_option['header_2_subheader_title_color'];

    }
    elseif ( $header_styles == "header3" ) {    
        $header_bg_color = $cs_theme_option['header_3_bg_color'];
        $header_nav_bgcolr = $cs_theme_option['header_3_bg_color'];
        $header_nav_color = $cs_theme_option['header_3_nav_color'];
        $header_nav_hover_color = $cs_theme_option['header_3_nav_hover_color'];
        $header_nav_active_color = $cs_theme_option['header_3_nav_active_color'];
        $header_subnav_bgcolr = $cs_theme_option['header_3_subnav_bgcolr'];
        $header_subnav_color = $cs_theme_option['header_3_subnav_color'];
        $header_subnav_hover_color = $cs_theme_option['header_3_subnav_hover_color'];
        $header_subnav_hover_bgcolor = $cs_theme_option['header_3_subnav_hover_bgcolor'];
        $header_subnav_active_color = $cs_theme_option['header_3_subnav_active_color'];
        $header_subnav_active_bgcolor = $cs_theme_option['header_3_subnav_active_bgcolor'];
        $header_subheader_bgcolor = $cs_theme_option['header_3_subheader_bgcolor'];
        $header_subheader_link_color = $cs_theme_option['header_3_subheader_link_color'];
        $header_subheader_title_color = $cs_theme_option['header_3_subheader_title_color'];
    }
    elseif ( $header_styles == "header4" ) {    
        $header_bg_color = $cs_theme_option['header_4_bg_color'];
        $header_nav_bgcolr = $cs_theme_option['header_4_bg_color'];
        $header_nav_color = $cs_theme_option['header_4_nav_color'];
        $header_nav_hover_color = $cs_theme_option['header_4_nav_hover_color'];
        $header_nav_active_color = $cs_theme_option['header_4_nav_active_color'];
        $header_subnav_bgcolr = $cs_theme_option['header_4_subnav_bgcolr'];
        $header_subnav_color = $cs_theme_option['header_4_subnav_color'];
        $header_subnav_hover_color = $cs_theme_option['header_4_subnav_hover_color'];
        $header_subnav_hover_bgcolor = $cs_theme_option['header_4_subnav_hover_bgcolor'];
        $header_subnav_active_color = $cs_theme_option['header_4_subnav_active_color'];
        $header_subnav_active_bgcolor = $cs_theme_option['header_4_subnav_active_bgcolor'];
        $header_subheader_bgcolor = $cs_theme_option['header_4_subheader_bgcolor'];
        $header_subheader_link_color = $cs_theme_option['header_4_subheader_link_color'];
        $header_subheader_title_color = $cs_theme_option['header_4_subheader_title_color'];
    }
    elseif ( $header_styles == "header5" ) {    
        $header_bg_color = $cs_theme_option['header_5_bg_color'];
		$header_nav_bgcolr = $cs_theme_option['header_5_nav_bgcolr'];
        $header_nav_color = $cs_theme_option['header_5_nav_color'];
        $header_nav_hover_color = $cs_theme_option['header_5_nav_hover_color'];
        $header_nav_active_color = $cs_theme_option['header_5_nav_active_color'];
        $header_subnav_bgcolr = $cs_theme_option['header_5_subnav_bgcolr'];
        $header_subnav_color = $cs_theme_option['header_5_subnav_color'];
        $header_subnav_hover_color = $cs_theme_option['header_5_subnav_hover_color'];
        $header_subnav_hover_bgcolor = $cs_theme_option['header_5_subnav_hover_bgcolor'];
        $header_subnav_active_color = $cs_theme_option['header_5_subnav_active_color'];
        $header_subnav_active_bgcolor = $cs_theme_option['header_5_subnav_active_bgcolor'];
        $header_subheader_bgcolor = $cs_theme_option['header_5_subheader_bgcolor'];
        $header_subheader_link_color = $cs_theme_option['header_5_subheader_link_color'];
        $header_subheader_title_color = $cs_theme_option['header_5_subheader_title_color'];
    }
 
    ?>
<style type="text/css">
/*
Header Start
----------------------------------*/
/*
======================================
	Top header
======================================
*/
#topheader {
	background: <?php echo $header_top_strip_bg_color;?>;
	padding: 8px 0;
	display: none;

}
#topheader.active-box {
	display: block;
	
}
.info-box {
	float: left;
	padding-top: 10px;
	font-size: 10px;
	line-height: 1.2;
	color: <?php echo $header_top_strip_color;?>;
	padding-left: 18px;
}
.topnav {
	padding-top: 8px;
	float: left;
}
.topnav li {
	position: relative;
	padding:0 15px;
	font-size: 11px;
	line-height: 16px;
	font-family: 'Roboto' sans-serif;
	color: <?php echo $header_top_strip_color;?>;
	font-weight: 300;
}
.topnav li:first-child {
	padding-left: 0;
}
.topnav li:before {
	content: '';
	position: absolute;
	left: -4px;
	top: 5px;
	width: 8px;
	height: 8px;
	background: #353535;
	background: rgba(53,53,53,0.3);
	border-radius: 8px;
	
}
.topnav li:first-child:before {
	display: none;
}
.topnav li a {
	color: #999;
}
.topnav li a:hover {
	color: <?php echo $header_nav_hover_color;?>;
}
/*
=========================================
	Share Options
=========================================
*/
.followus {
	float: left;
	padding-right: 20px;

}
.followus h5 {
	float: left;
	font-family: 'Roboto' sans-serif;
	font-weight: 300;
	color: <?php echo $header_top_strip_color;?>;
	font-size: 11px;
	line-height: 26px;
	padding-right: 15px;
	margin-bottom: 0;
}
.followus a {
	line-height: 26px;
	font-size: 18px;
	color: <?php echo $header_top_strip_color;?>;
}
.followus a:hover {
	color: #fff;
}
.btnsignin {
	float: left;
	width: 70px;
	height: 26px;
	color: #fff;
	line-height: 26px;
	border-radius: 2px;
	text-align: center;
}
/* Navigation
================================================== */
.navigation {
	float: left;
	padding-left: 30px;
	position:relative;
	padding-top: 15px;

}
nav.navigation > ul{
	width:100%;
	height:63px;
}
nav.navigation > ul > li{
	float:left;
	height:50px;
	position:relative;
}
nav.navigation > ul > li:before {
	content: '';
	position: absolute;
	left: -4px;
	top: 50%;
	width: 3px;
	height: 3px;
	margin-top: -2px;
	background: #333;
	
}
nav.navigation > ul > li:first-child:before {
	display: none;
}
nav.navigation > ul > li > a{
	float:left;
	height:35px;
	padding:15px 15px 0px 15px;
	font-size:12px;
	color: <?php echo $header_nav_color;?>;
	z-index:999;
	font-weight: 600;
	font-family: 'Roboto' sans-serif;
	position:relative;
}
.navigation ul ul {
	visibility: hidden;
	opacity: 0;
	float:left;
	position:absolute;
	top:50px;
	left:0;
	z-index:999999;
	background:<?php echo $header_subnav_bgcolr;?>;
	background: rgba(218,218,218,0.95);
	box-shadow: 4px 4px 8px rgba(0,0,0,0.1);
	border-radius: 4px;
	width:160px;
	padding-top: 4px;
	padding-bottom: 4px;
	-webkit-transition: opacity .400s ease-in-out 0.200s,visibility .400s ease-in-out 0.200s;
	   -moz-transition: opacity .400s ease-in-out 0.200s,visibility .400s ease-in-out 0.200s;
	    -ms-transition: opacity .400s ease-in-out 0.200s,visibility .400s ease-in-out 0.200s;
	     -o-transition: opacity .400s ease-in-out 0.200s,visibility .400s ease-in-out 0.200s;
	        transition: opacity .400s ease-in-out 0.200s,visibility .400s ease-in-out 0.200s;
}
.navigation ul ul li{
	float:left;
	width:100%;
	position:relative;
}
.navigation ul ul ul {
	left: 101%;
	top: 0;
}
.navigation ul ul a {
	width:100% !important;
	display:block;
	padding:6px 10px;
	margin:0;
	font-size:12px;
	color:<?php echo $header_subnav_color;?> !important;
	font-weight: 300;
	-webkit-box-sizing:border-box;
	-moz-box-sizing:border-box;
	box-sizing:border-box;
}
nav.navigation  ul  ul > li:hover > a {
	color:<?php echo $header_subnav_hover_color;?> !important;
}
.navigation ul li:hover > ul {
	visibility: visible;
	opacity: 1;
	-webkit-transition: opacity .350s ease-in-out;
	   -moz-transition: opacity .350s ease-in-out;
	    -ms-transition: opacity .350s ease-in-out;
	     -o-transition: opacity .350s ease-in-out;
	        transition: opacity .350s ease-in-out;
}
.navigation select {
    display: none;
	width:100%;
	float:left;
	color:<?php echo $header_nav_color;?>;
	padding: 5px;
	margin:0;
	background-color:<?php echo $header_nav_bgcolr;?>;
	border:#5b4427 solid 1px;
	-webkit-box-sizing:border-box;
	-moz-box-sizing:border-box;
	box-sizing:border-box;
}
.navigation select option {
    border-bottom: 1px solid #f2f2f2;
    cursor: pointer;
    color: #444;
    padding: 6px;
}
nav.navigation > select:focus {
	outline: none;
}
.topindex {
	position:relative;
	z-index:10;
}
.selectnav { 
	display: none;
}







/*
========================================
	Main Header
========================================
*/
#wrapperheader {
	background: <?php echo $header_bg_color;?>;
	border-top: 2px solid transparent;
	border-bottom: 2px solid rgba(255,255,255,0.10) !important;
	height: 78px;
	position: relative;
}
/*
	Logo Area
*/

#logo {
height: 74px;
border-right: 1px solid #1a1918;
padding-right: 20px;
padding-top: 28px;
background: #0f0f0f;
position: relative;
-webkit-box-sizing: border-box;
   -moz-box-sizing: border-box;
        box-sizing: border-box;
}
#logo a {
	float: left;
	position: relative;
	z-index: 10;
}
#logo:before {
	content: '';
	width: 99999px;
	height: 100%;
	position: absolute;
	right: 0;
	top: 0;
	background: #0f0f0f;
	z-index: 5;
	
}
.wrapper_boxed #logo:before {
	width: 235px;
}
/*
	Search Area
*/

.searcharea {
	height: 74px;
	padding-left: 22px;
	border-left: 1px solid #1a1918;
	position: relative;
	z-index: 9;
}
a.btnsearch {
	font-size: 18px;
	line-height: 76px;
	color: #808080;
}
#searchbox {
	display: none;
	position: absolute;
	right: 0;
	margin-right: -30px;
	top: 100%;
	width: 335px;
	background: #fff;
	background: rgba(255,255,255,0.95);
	border-radius: 4px;
	padding: 18px;
	box-shadow: 4px 4px  6px rgba(0,0,0,0.3);
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box;
	box-sizing: border-box;
	color: #8d8d8d;
	z-index: 99;
}
#searchbox.active-box {
	display: block;
}
#searchbox label {
	display: block;
	float: left;
	width: 225px;
	padding-top: 5px;

}
#searchbox label em {
	float: left;
	margin-top: 6px;
	font-size: 16px;
	margin-right: 8px;
}
#searchbox label input[type="text"] {
	float: left;
	height: 25px;
	border: none;
	width: 175px;
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
	background: none;
}
#searchbox  button {
	float: right;
	border: none;
	width: 70px;
	height: 36px;
	border-radius: 3px;
	font-size: 11px;
	color: #e9e6e4;
}
.home #header {
	position: relative;
	left: 0;
	top: 0;
}
.btntopmenu {
	position: absolute;
	right: 0px;
	top: 0;
	color: #fff;
	width: 25px;
	height: 25px;
	line-height: 25px;


}
.btntopmenu em {
	position: relative;
	z-index: 10;
}
.btntopmenu:before {
	content: "";
	position: absolute;
	right: 0;
	top: 0;
	z-index: 1;
	width: 0px;
	height: 0px;
	border-style: solid;
	border-width: 0 50px 50px 0;
	
}
nav.navigation ul li a{
	color:<?php echo $header_nav_color;?>;
}
nav.navigation ul li ul li a{
	color:<?php echo $header_subnav_color;?>;
	background-color:<?php echo $header_subnav_bgcolr;?>;
}
nav.navigation ul > li:hover > a{
	color:<?php echo $header_nav_hover_color;?> !important;
}
nav.navigation ul > li > ul > li:hover > a{
	color:<?php echo $header_subnav_hover_color;?> !important;
	background-color:<?php echo $header_subnav_hover_bgcolor;?> !important;
}
nav.navigation > ul > li.current-menu-ancestor > a, nav.navigation > ul > li.current-menu-item > a{
	color:<?php echo $header_nav_active_color;?> !important;
}
nav.navigation > ul > li > ul > li.current-menu-item > a{
	color:<?php echo $header_subnav_active_color;?> !important;
	background-color:<?php echo $header_subnav_active_bgcolor;?> !important;
}
/* Header 1 Start */
<?php if ( $header_styles == "header1" ){?>

.mainheader #wrapperheader {
    background: <?php echo $header_bg_color;?> !important;
}
#logo:before{
	background: <?php echo $header_bg_color;?>;
}
/* Header 1 End */
<?php } elseif ( $header_styles == "header2" ){?>
/* Header 2 Start */
/*
========================================
	Header 2
========================================
*/
#header.header-2 #topheader{
	display: block;
	background: <?php echo $header_top_strip_bg_color;?>;

}
#header.header-2 .info-box {
	padding-left: 0;
	padding-right: 15px;
}
#header.header-2 .btnsignin {
	width: auto;
	text-transform: uppercase;
	font-weight: 300;
	font-size: 11px;
}
#header.header-2 .btnsignin em {
	margin-right: 6px;
}
#header.header-2 #wrapperheader {
	border-top: 1px solid #252525;
	background: <?php echo $header_bg_color;?>;
}
#header.header-2 #logo {
border: none;
background: none;
}
#header.header-2 #logo:before {
	display: none;
	
}
#header.header-2 .navigation {
	float: right;
}
#header.header-2 .navigation > ul > li:before {
display: none;
}
/* Header 2 End 
======================================*/
<?php } elseif ( $header_styles == "header3" ){?>
/* Header 3 Start */
/*
=======================================
Header 3
=======================================
*/
#header.header-3 #wrapperheader {
	margin-top: 5px;
	border-top: 1px solid #252525;
	background: <?php echo $header_bg_color;?>;
	box-shadow: 0 -5px 0  #121212,0 4px 0  #121212;
	padding-top: 15px;
	height: 110px;
	border-bottom: 1px solid #000;
}
#header.header-3  #logo {
	border: none;
	background: none;
}
#header.header-3 #logo:before {
	content: '';
	display: none;
	
}
#header.header-3 .navigation {
	float: right;
	padding-left: 0;
}
#header.header-3 .navigation > ul > li:before {
	width: 1px;
	height: 9px;
	margin-top: -4px;
	border-right:2px dotted rgba(255,255,255,0.10) ;
}
#header.header-3 .navigation > ul > li  {
	padding: 0 8px;

}
#header.header-3 .navigation > ul > li:after {
	content: '';
	width: 100%;
	height: 5px;
	display: none;
	position: absolute;
	left: 0;
	bottom: -27px;
	background: #000;
}
#header.header-3 .navigation > ul > li:hover:after {
	display: block;
}
#header.header-3  a.btnsearch {
	width: 40px;
	height: 40px;
	display: inline-block;
	vertical-align: middle;
	margin-top: 18px;
	border: 1px solid #303030;
	border-radius: 50px;
	text-align: center;
	line-height: 35px;
}
/* Header 3 End */
/*=============================================*/
<?php } elseif ( $header_styles == "header4" ){?>
/*
========================================
Header 4
========================================
*/
#header.header-4 #wrapperheader {
	margin-top: 5px;
	border-top: 1px solid #252525;
	background: <?php echo $header_bg_color;?>;
	box-shadow: 0 -5px 0  #121212;
	padding-top: 0px;
	height: 155px;
	border-bottom: none;
}
#header.header-4  #logo {
	border: none;
	float: none;
	width: auto;
	text-align: center;
	background: none;
}
#header.header-4 #logo:before {
	content: '';
	display: none;
	
}
#header.header-4  #logo  a {
	float: none;
}
#header.header-4 a.btnsignin,#header.header-4 a.btnsearch {
	width: 40px;
	height: 40px;
	display: inline-block;
	vertical-align: middle;
	margin-top: 20px;
	border: 1px solid #303030;
	color: #8c8c8c;
	border-radius: 50px;
	text-align: center;
	line-height: 37px;
	position: relative;
	z-index: 999;
}
#header.header-4 a.btnsignin:hover,#header.header-4 a.btnsearch:hover {
	color: #fff;
}
.headerwrappbor {
	border-bottom: 1px solid rgba(255,255,255,0.10);
	padding-bottom: 6px;
	position: relative;
}
.headerwrappbor:before,.headerwrappbor:after {
	content: '';
	width: 4px;
	display: block;
	height: 4px;
	background: rgba(255,255,255,0.10);
	position: absolute;
	left: 0;
	bottom: -2px;
	border-radius: 4px;
}
.headerwrappbor:after {
	left: auto;
	right: 0;
}
#header.header-4 .navigation  {
	padding-top: 30px;
	padding-left: 0;
	width: 100%;
	text-align: center;
}
#header.header-4 .navigation > ul > li  {
	float: none;
	display: inline-block;
}
#header.header-4 .navigation > ul > li > ul {
	top: 36px;
	text-align: left;
}
#header.header-4 .navigation > ul > li > a {
	float: none;
}
#header.header-4 .navigation > ul > li:before {
width: 1px;
height: 9px;
top: 0;
margin-top: 4px;
border-right:2px dotted rgba(255,255,255,0.10) ;
}
#header.header-4 .navigation > ul > li:after {
content: '';
width: 100%;
height: 5px;
display: none;
position: absolute;
left: 0;
bottom: 2px;
background: #000;
}
#header.header-4 .navigation > ul > li:hover:after {
	display: block;
}
/* Header 4 End */
/*=============================================*/
<?php } elseif ( $header_styles == "header5" ){?>
/* Header 5 Start */
/*
========================================
Header 5
========================================
*/
#header.header-5 #wrapperheader {
	margin-top: 5px;
	border-top: 1px solid #252525;
	background: <?php echo $header_bg_color;?>;
	box-shadow: 0 -5px 0  #121212,0 5px 5px rgba(0,0,0,0.3);
	padding-top: 5px;
	padding-bottom: 5px;
	height: auto;
	border-bottom: 1px solid #070707 !important;
}
#header.header-5 #logo {
	background: none;
}
#header.header-5 #logo:before {
	content: '';
	display: none;
	
}
.menuwrapper {
	background: <?php echo $header_nav_bgcolr;?>;
}
#header.header-5 .navigation {
	padding-left: 0;
	padding-top: 0;
	background: <?php echo $header_nav_bgcolr;?>;
	position: relative;
	width: 80%;
	padding-top: 12px;
}
#header.header-5 .navigation:before {
	content: '';
	width: 9999em;
	font-size: 24px;
	height: 100%;
	right: 0;
	position: absolute;
	top: 0;
	background: <?php echo $header_nav_bgcolr;?>;
	
}
#header.header-5 .navigation ul {
	margin-bottom: 0;
}
#header.header-5 .navigation > ul > li:before {
width: 1px;
height: 9px;
margin-top: -4px;
border-right:2px dotted rgba(255,255,255,0.10) ;
}
#header.header-5 .navigation > ul > li  {
	padding: 0 10px;

}
#header.header-5 #searchbox {
	display: block;
	float: right;
	position: relative;
	top: 0;
	left: 0;
	padding: 15px 0;
	margin: 0;
	background: none;
	border-radius: 0;
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
	width: 210px;
}
#header.header-5 #searchbox  button {
	float: left;
	width: auto;
	border: none;
	font-size: 20px;
	color: #848484;
	background: none;
}
#header.header-5 #searchbox input[type="text"] {
	width: 190px;
	background: none;
	-webkit-box-shadow: none;
	-moz-box-shadow: none;
	box-shadow: none;
	border: none;
}
/* Header 5 End */
/*=============================================*/
<?php } ?>
/*
Sub Header Title
*/

.outerbreadcrumb .breadcrumbinner .subtitle:before{
    color: <?php echo $header_subheader_link_color;?> !important;
    background-color: <?php echo $header_subheader_bgcolor;?> !important;
}
.outerbreadcrumb .breadcrumbinner .subtitle h1.page-title{
    color: <?php echo $header_subheader_title_color;?> !important;
}

.breadcrumbinner .breadcrumbs ul li{
    color: <?php echo $header_subheader_title_color;?> !important;
}
.breadcrumbinner .breadcrumbs ul li a{
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
 * Ccustom Header Styles 1 -10
 */
function cs_custom_header_styles($header_styles) { global $cs_theme_option;
      if ( $header_styles == "header1" )
      { 

?>
  <!-- Header Start -->
        <header id="header" class="mainheader fullwidth">
        <?php if($cs_theme_option['header_1_strip']=='on'){?>
            <!-- Top header -->
            <div id="topheader" class="fullwidth">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                        	<?php if($cs_theme_option['header_1_top_strip_menu'] <> ''){ cs_navigation($cs_theme_option['header_1_top_strip_menu'], 'topnav');} ?>
                             <?php if($cs_theme_option['header_1_top_strip_right_area_text'] <> ''){?>
                                        <ul class="topnav">
                                            <li><?php echo $cs_theme_option['header_1_top_strip_right_area_text'];?></li>
                                        </ul>
                             <?php }?>
                                
                        </div>
                        <div class="col-lg-5">
                            <div class="float-right">
                                <?php 
								if($cs_theme_option['header_1_social']=='on'){
									cs_social_network();
								}
								 if($cs_theme_option['header_1_login']=='on'){?>
                                 	<?php if ( is_user_logged_in() ) { ?>
                                	<!-- Button Sigh in  -->
                                	<a href="<?php echo wp_logout_url("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>" data-toggle="modal" class="btnsignin bgcolrhover"><em class="fa fa-sign-out"></em> <?php echo _e('Log out', 'Rocky');?></a>
                                    <!-- Button Sigh in Close -->
                                    <?php } else {?>
                                    		<a href="#myModal" data-toggle="modal" class="btnsignin bgcolr"><em class="fa fa-user"></em> <?php echo _e('Log In', 'Rocky');?></a>
                                    <?php }?>
                             <?php }?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Top header Close -->
            <?php }?>
            <!-- Main Header Start -->
            <div id="wrapperheader" class="bdrcolr fullwidth">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Logo -->
                            <div id="logo" class="float-left">
                               <?php cs_logo($cs_theme_option['main_logo'], $cs_theme_option['main_logo_width'], $cs_theme_option['main_logo_height'], $cs_theme_option['header_1_logo']); ?>
                            </div>
                            <!--Logo Close  -->
                            <!-- Navigation -->
                            <nav class="navigation">
                                <?php cs_navigation('main-menu'); ?>
                            </nav>
                            <!-- Navigation Clsoe -->
                           <?php cs_header_search();?>
                        </div>
                    </div>
                </div>
                <?php if($cs_theme_option['header_1_strip']=='on'){?>
                    <a href="#topheader" class="btntopmenu btntoggle">
                    	<em class="fa fa-align-justify"></em>
                	</a>
                <?php } ?>
             </div>
            <!-- Main Header Close --> </header>
        <!-- Header End -->
     
<?php } elseif ( $header_styles == "header2" ){?>
    <!-- Header 2 Start -->
    <header id="header" class="header-2 fullwidth">
            <!-- Top header -->
            <div id="topheader" class="fullwidth">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            <?php if($cs_theme_option['header_2_top_strip_right_area_text'] <> ''){?><div class="info-box float-left"><?php echo $cs_theme_option['header_2_top_strip_right_area_text'];?></div><?php }?>
                            <?php if($cs_theme_option['header_2_top_strip_menu'] <> ''){ cs_navigation($cs_theme_option['header_2_top_strip_menu'], 'topnav');} ?>
                        </div>
                        <div class="col-lg-5">
                            <div class="float-right">
                             	<?php 
								if($cs_theme_option['header_2_social']=='on'){
									cs_social_network();
								}
								if($cs_theme_option['header_2_login']=='on'){
								?>
                                	<?php if ( is_user_logged_in() ) { ?>
                                	<!-- Button Sigh in  -->
                                	<a href="<?php echo wp_logout_url("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>" data-toggle="modal" class="btnsignin bgcolrhover"><em class="fa fa-sign-out"></em> <?php echo _e('Log out', 'Rocky');?></a>
                                    <!-- Button Sigh in Close -->
                                    <?php } else {?>
                                    		<a href="#myModal" data-toggle="modal" class="btnsignin"><em class="fa fa-user"></em> <?php echo _e('Log In', 'Rocky');?></a>
                                    <?php }?>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Top header Close -->
            <!-- Main Header Start -->
            <div id="wrapperheader" class="fullwidth">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Logo -->
                            <div id="logo" class="float-left">
                                 <?php cs_logo($cs_theme_option['main_logo'], $cs_theme_option['main_logo_width'], $cs_theme_option['main_logo_height'], $cs_theme_option['header_2_logo']); ?>
                            </div>
                            <!--Logo Close  -->
                             <!-- Search Area -->
                            <?php cs_header_search();?>
                            <!-- Search Area Close -->
                            <!-- Navigation -->
                            <nav class="navigation">
                                <?php cs_navigation('main-menu'); ?>
                            </nav>
                            <!-- Navigation Clsoe -->
                            </div>
                    </div>
                </div>
                
            </div>
            <!-- Main Header Close -->
          </header>
    <!-- Header 2 End -->            
<?php }elseif ( $header_styles == "header3" ){ 
?>
    
    <!-- Header 3 Start -->
    <header id="header" class="header-3 fullwidth">
            <!-- Main Header Start -->
            <div id="wrapperheader" class="fullwidth">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Logo -->
                            <div id="logo" class="float-left">
                                <?php cs_logo($cs_theme_option['main_logo'], $cs_theme_option['main_logo_width'], $cs_theme_option['main_logo_height'], $cs_theme_option['header_3_logo']); ?>
                            </div>
                            <!--Logo Close  -->
                             <!-- Search Area -->
                            <?php cs_header_search();?>
                            <!-- Search Area Close -->
                            <!-- Navigation -->
                            <nav class="navigation">
                                <?php cs_navigation('main-menu'); ?>
                            </nav>
                            <!-- Navigation Clsoe -->
                            </div>
                    </div>
                </div>
                
            </div>
            <!-- Main Header Close -->
         </header>
    
    <!-- Header End -->  
<?php } elseif ($header_styles == "header4") {
	?>
<!-- Header 4 Start -->
<header id="header" class="header-4 fullwidth">
            <!-- Main Header Start -->
            <div id="wrapperheader" class="fullwidth">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="headerwrappbor fullwidth">
                            
                            <?php if($cs_theme_option['header_4_login']=='on'){?>
                            		<?php if ( is_user_logged_in() ) { ?>
                                	<!-- Button Sigh in  -->
                                	<a href="<?php echo wp_logout_url("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>" data-toggle="modal" class="btnsignin bgcolrhover"><em class="fa fa-sign-out"></em> </a>
                                    <!-- Button Sigh in Close -->
                                    <?php } else {?>
                                    		<a href="#myModal" data-toggle="modal" class="btnsignin bgcolrhover"><em class="fa fa-user"></em> </a>
                                    <?php }?>
                             <?php }?>
                            
                            
                             <!-- Search Area -->
                            <?php cs_header_search();?>
                            <!-- Search Area Close -->
                            <!-- Logo -->
                            <div id="logo" >
                               <?php cs_logo($cs_theme_option['main_logo'], $cs_theme_option['main_logo_width'], $cs_theme_option['main_logo_height'], $cs_theme_option['header_4_logo']); ?>
                            </div>
                            <!--Logo Close  -->
                        </div>
                            <!-- Navigation -->
                            <nav class="navigation">
                                <?php cs_navigation('main-menu'); ?>
                            </nav>
                            <!-- Navigation Clsoe -->
                            </div>
                    </div>
                </div>
                
            </div>
            <!-- Main Header Close --> </header>

<!-- Header 4 End --> 
<?php } elseif ($header_styles == "header5") {
	?>
  <!-- Header 5 Start -->
  <header id="header" class="header-5 fullwidth">
            <!-- Main Header Start -->
            <div id="wrapperheader" class="fullwidth">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                          

                            <!-- Logo -->
                            <div id="logo" class="float-left">
                               <?php cs_logo($cs_theme_option['main_logo'], $cs_theme_option['main_logo_width'], $cs_theme_option['main_logo_height'], $cs_theme_option['header_5_logo']); ?>
                            </div>
                            <!--Logo Close  -->
                            <?php if($cs_theme_option['header_5_adv'] <> ''){?>
                                <!-- Top Banner -->
                                <div class="headertopbanner float-right">
                                    <a href="<?php echo $cs_theme_option['header_5_adv_link'];?>"><img src="<?php echo $cs_theme_option['header_5_adv'];?>" alt=""></a>
                                </div>
                                <!-- Top Banner Close -->
                     		<?php }?>
                           
                            </div>
                    </div>
                </div>
                
            </div>
            <!-- Navigation Header -->
            <div class="menuwrapper fullwidth">
                <div class="container">
                     <!-- Navigation -->
                            <nav class="navigation">
                                <?php cs_navigation('main-menu'); ?>
                            </nav>
                            <!-- Navigation Clsoe -->
                            <div id="searchbox">
                                 <form action="<?php echo home_url() ?>" id="searchform" method="get" role="search">
                                    <button class="btnsearch"><em class="fa fa-search"></em></button>
                                    <input type="text" name="s" value="<?php _e('Search for:', "Rocky"); ?>">
                                 </form>
                                    
                                </div>
                </div>
            </div>
            <!-- Navigation Header Close-->

            <!-- Main Header Close --> </header>
    
    <!-- Header 5 End -->   
<?php }
}

/*
 * Ccustom Header Styles  1 -7 End
 */

?>