<?php
function theme_option() {
	global $post, $header1_default_colors, $header2_default_colors, $header3_default_colors, $header4_default_colors, $header5_default_colors, $header6_default_colors, $header7_default_colors;
	$g_fonts = get_google_fonts();
	$cs_theme_option = get_option('cs_theme_option');
	
	if(!isset($cs_theme_option['default_header'])){
		$cs_theme_option['default_header'] = "header1";
	}
                                          
?>
<link href="<?php echo get_template_directory_uri()?>/css/admin/datePicker.css" rel="stylesheet" type="text/css" />
<form id="frm" method="post" action="javascript:theme_option_save('<?php echo home_url()?>', '<?php echo get_template_directory_uri()?>');">
  <div class="theme-wrap fullwidth">
    <div class="loading_div"></div>
    <div class="form-msg"></div>
    <div class="inner">
      <div class="row"> 
        <!-- Left Column Start -->
        <div class="col1">
          <div class="logo"><a href="#"><img src="<?php echo get_template_directory_uri()?>/images/admin/logo.png" alt="" /></a></div>
          <div class="arrowlistmenu" id="paginate-slider2">
            <h3 class="menuheader expandable"><a href="#"><span class="nav-icon g-setting">&nbsp;</span>General Settings</a></h3>
            <ul class="categoryitems">
              <li class="tab-color active"><a href="#tab-color" onClick="toggleDiv(this.hash);return false;">Color and Style</a></li>
              <li class="tab-logo"><a href="#tab-logo" onClick="toggleDiv(this.hash);return false;">Logo / Fav Icon</a></li>
              <li class="tab-head-scripts"><a href="#tab-head-scripts" onClick="toggleDiv(this.hash);return false;">Header Settings</a></li>
              <li class="tab-foot-setting"><a href="#tab-foot-setting" onClick="toggleDiv(this.hash);return false;">Footer Settings</a></li>
              <li class="tab-under-consturction"><a href="#tab-under-consturction" onClick="toggleDiv(this.hash);return false;">Under Constrution</a></li>
              <li class="tab-other"><a href="#tab-other" onClick="toggleDiv(this.hash);return false;">Other Settings</a></li>
              <li class="tab-api-key"><a href="#tab-api-key" onClick="toggleDiv(this.hash);return false;">API Settings</a></li>
            </ul>
            <h3 class="menuheader expandable"><a href="#"><span class="nav-icon h-setting">&nbsp;</span>Home Page Settings</a></h3>
            <ul class="categoryitems">
              <li class="tab-slider"><a href="#tab-slider" onClick="toggleDiv(this.hash);return false;">Home Page Slider</a></li>
            </ul>
            <h3 class="menuheader expandable"><a href="#"><span class="nav-icon h-setting">&nbsp;</span>Default Header Settings</a></h3>
            <ul class="categoryitems">
              <li class="tab-default_headers"><a href="#tab-default_headers" onClick="toggleDiv(this.hash);return false;">Default Headers</a></li>
              <li class="tab-head-styles"><a href="#tab-head-styles" onClick="toggleDiv(this.hash);return false;">Header Styles</a></li>
            </ul>
            <h3 class="menuheader expandable"><a href="#"><span class="nav-icon fonts">&nbsp;</span>Fonts</a></h3>
            <ul class="categoryitems">
              <li class="tab-font-settings"><a href="#tab-font-settings" onClick="toggleDiv(this.hash);return false;">Fonts Settings</a></li>
            </ul>
            <h3 class="menuheader expandable"><a href="#"><span class="nav-icon side-bar">&nbsp;</span>Side Bars</a></h3>
            <ul class="categoryitems">
              <li class="tab-manage-sidebars"><a href="#tab-manage-sidebars" onClick="toggleDiv(this.hash);return false;">Manage Sidebars</a></li>
            </ul>
            <h3 class="menuheader expandable"><a href="#"><span class="nav-icon slider-setting">&nbsp;</span>Slider Setting</a></h3>
            <ul class="categoryitems">
               <li class="tab-flex-slider"><a href="#tab-flex-slider" onClick="toggleDiv(this.hash);return false;">Flex Slider</a></li>
            </ul>
            <h3 class="menuheader expandable"><a href="#"><span class="nav-icon s-network">&nbsp;</span>Social Settings</a></h3>
            <ul class="categoryitems">
              <li class="tab-social-network"><a href="#tab-social-network" onClick="toggleDiv(this.hash);return false;">Social Network</a></li>
              <li class="tab-social-sharing"><a href="#tab-social-sharing" onClick="toggleDiv(this.hash);return false;">Social Sharing</a></li>
            </ul>
            <h3 class="menuheader expandable"><a href="#"><span class="nav-icon languages">&nbsp;</span>Language</a></h3>
            <ul class="categoryitems">
              <li class="tab-upload-languages"><a href="#tab-upload-languages" onClick="toggleDiv(this.hash);return false;">Upload New Languages</a></li>
            </ul>
            <h3 class="menuheader expandable"><a href="#"><span class="nav-icon translation">&nbsp;</span>Translation</a></h3>
            <ul class="categoryitems">
			  <li class="tab-prayer-translation"><a href="#tab-prayer-translation" onClick="toggleDiv(this.hash);return false;">Prayers</a></li>
              <li class="tab-event-translation"><a href="#tab-event-translation" onClick="toggleDiv(this.hash);return false;">Events</a></li>
              <li class="tab-contact-translation"><a href="#tab-contact-translation" onClick="toggleDiv(this.hash);return false;">Contact</a></li>
              <li class="tab-other-translation"><a href="#tab-other-translation" onClick="toggleDiv(this.hash);return false;">Others</a></li>
            </ul>
            <h3 class="menuheader expandable"><a href="#"><span class="nav-icon default-pages">&nbsp;</span>Default Pages</a></h3>
            <ul class="categoryitems">
              <li class="tab-default-pages"><a href="#tab-default-pages" onClick="toggleDiv(this.hash);return false;">Default Pages</a></li>
            </ul>
            <h3 class="menuheader expandable"><a href="#"><span class="nav-icon default-pages">&nbsp;</span>Backup Options</a></h3>
            <ul class="categoryitems">
              <li class="tab-import-export"><a href="#tab-import-export" onClick="toggleDiv(this.hash);return false;">Theme Options Backup and restore settings</a></li>
            </ul>
          </div>
          <div class="clear"></div>
        </div>
        <!-- Left Column End -->
        <div class="col2">
          <input type="submit" id="submit_btn" name="submit_btn" class="topbtn" value="Save All Settings" />
          <!-- Color And Style Start -->
          <div id="tab-color">
            <div class="theme-header">
              <h1>General Settings</h1>
            </div>
            <div class="theme-help">
              <h4>Color And Styles</h4>
              <p>Theme color scheme and styling setting.</p>
            </div>
            <ul class="form-elements">
              <li class="to-label">
                <label>Custom Color Scheme</label>
              </li>
              <li class="to-field">
                <input type="text" name="custom_color_scheme" value="<?php echo $cs_theme_option['custom_color_scheme']?>" class="bg_color" />
                <p>Pick a custom color for Scheme of the theme e.g. #697e09</p>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Heading Color Scheme</label>
              </li>
              <li class="to-field">
                <input type="text" name="heading_color_scheme" value="<?php echo $cs_theme_option['heading_color_scheme']?>" class="bg_color" />
                <p>Pick a custom color for Scheme of the headings e.g. #333</p>
              </li>
            </ul>
            <div class="opt-head">
              <h4>Layout Options</h4>
              <div class="clear"></div>
            </div>
            <ul class="form-elements">
              <li class="to-label">
                <label>Footer Background Color</label>
              </li>
              <li class="to-field">
                <input type="text" name="footer_bg_color" value="<?php echo $cs_theme_option['footer_bg_color']?>" class="bg_color"  />
              </li>
              <li class="full">&nbsp;</li>
              <li class="to-label">
                <label>Footer Text Color</label>
              </li>
              <li class="to-field">
                <input type="text" name="footer_text_color" value="<?php echo $cs_theme_option['footer_text_color']?>" class="bg_color"  />
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Layout Option</label>
              </li>
              <li class="to-field">
                <input type="radio" name="layout_option" value="wrapper_boxed" <?php if($cs_theme_option['layout_option']=="wrapper_boxed")echo "checked"?> class="styled" />
                <label>Boxed</label>
                <input type="radio" name="layout_option" value="wrapper" <?php if($cs_theme_option['layout_option']=="wrapper")echo "checked"?> class="styled" />
                <label>Wide</label>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Background Image</label>
              </li>
              <li class="to-field">
                <div class="meta-input pattern">
                  <?php
										for ( $i = 0; $i < 13; $i++ ) {
										?>
                  <div class='radio-image-wrapper'>
                    <input <?php if($cs_theme_option['bg_img']==$i)echo "checked"?> onclick="select_bg()" type="radio" name="bg_img" class="radio" value="<?php echo $i?>" />
                    <label for="radio_<?php echo $i?>"> <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/background/background<?php echo $i?>.png" alt="" /></span> <span <?php if($cs_theme_option['bg_img']==$i)echo "class='check-list'"?> id="check-list">&nbsp;</span> </label>
                  </div>
                  <?php }?>
                </div>
              </li>
              <li class="full">&nbsp;</li>
              <li class="to-label">
                <label>Background Image</label>
              </li>
              <li class="to-field">
                <input id="bg_img_custom" name="bg_img_custom" value="<?php echo $cs_theme_option['bg_img_custom'] ?>" type="text" class="small" />
                <input id="bg_img_custom" name="bg_img_custom" type="button" class="uploadfile left" value="Browse"/>
                <?php if ( $cs_theme_option['bg_img_custom'] <> "" ) { ?>
                <div class="thumb-preview" id="bg_img_custom_img_div"> <img src="<?php echo $cs_theme_option['bg_img_custom']?>" alt="" /> <a href="javascript:remove_image('bg_img_custom')" class="del">&nbsp;</a> </div>
                <?php } ?>
              </li>
              <li class="full">&nbsp;</li>
              <li class="to-label">
                <label>Position</label>
              </li>
              <li class="to-field">
                <input type="radio" name="bg_position" value="left" <?php if($cs_theme_option['bg_position']=="left")echo "checked"?> class="styled" />
                <label>Left</label>
                <input type="radio" name="bg_position" value="center" <?php if($cs_theme_option['bg_position']=="center")echo "checked"?> class="styled" />
                <label>Center</label>
                <input type="radio" name="bg_position" value="right" <?php if($cs_theme_option['bg_position']=="right")echo "checked"?> class="styled" />
                <label>Right</label>
              </li>
              <li class="full">&nbsp;</li>
              <li class="to-label">
                <label>Repeat</label>
              </li>
              <li class="to-field">
                <input type="radio" name="bg_repeat" value="no-repeat" <?php if($cs_theme_option['bg_repeat']=="no-repeat")echo "checked"?> class="styled" />
                <label>No Repeat</label>
                <input type="radio" name="bg_repeat" value="repeat" <?php if($cs_theme_option['bg_repeat']=="repeat")echo "checked"?> class="styled" />
                <label>Tile</label>
                <input type="radio" name="bg_repeat" value="repeat-x" <?php if($cs_theme_option['bg_repeat']=="repeat-x")echo "checked"?> class="styled" />
                <label>Tile Horizontally</label>
                <input type="radio" name="bg_repeat" value="repeat-y" <?php if($cs_theme_option['bg_repeat']=="repeat-y")echo "checked"?> class="styled" />
                <label>Tile Vertically</label>
              </li>
              <li class="full">&nbsp;</li>
              <li class="to-label">
                <label>Attachment</label>
              </li>
              <li class="to-field">
                <input type="radio" name="bg_attach" value="scroll" <?php if($cs_theme_option['bg_attach']=="scroll")echo "checked"?> class="styled" />
                <label>Scroll</label>
                <input type="radio" name="bg_attach" value="fixed" <?php if($cs_theme_option['bg_attach']=="fixed")echo "checked"?> class="styled" />
                <label>Fixed</label>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Background Pattern</label>
              </li>
              <li class="to-field">
                <div class="meta-input pattern">
                  <?php
										for ( $i = 0; $i < 15; $i++ ) {
										?>
                  <div class='radio-image-wrapper'>
                    <input <?php if($cs_theme_option['pattern_img']==$i)echo "checked"?> onclick="select_pattern()" type="radio" name="pattern_img" class="radio" value="<?php echo $i?>" />
                    <label for="radio_<?php echo $i?>"> <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/pattern/pattern<?php echo $i?>.png" alt="" /></span> <span <?php if($cs_theme_option['pattern_img']==$i)echo "class='check-list'"?> id="check-list">&nbsp;</span> </label>
                  </div>
                  <?php }?>
                </div>
              </li>
              <li class="full">&nbsp;</li>
              <li class="to-label">
                <label>Background Pattern</label>
              </li>
              <li class="to-field">
                <input id="custome_pattern" name="custome_pattern" value="<?php echo $cs_theme_option['custome_pattern']; ?>" type="text" class="small" />
                <input id="custome_pattern" name="custome_pattern" type="button" class="uploadfile left" value="Browse"/>
                <?php if ( $cs_theme_option['custome_pattern'] <> "" ) { ?>
                <div class="thumb-preview" id="custome_pattern_img_div"> <img src="<?php echo $cs_theme_option['custome_pattern'];?>" alt="" /> <a href="javascript:remove_image('custome_pattern')" class="del">&nbsp;</a> </div>
                <?php }?>
              </li>
              <li class="full">&nbsp;</li>
              <li class="to-label">
                <label>Background Color</label>
              </li>
              <li class="to-field">
                <input type="text" name="bg_color" value="<?php echo $cs_theme_option['bg_color']?>" class="bg_color" data-default-color="" />
              </li>
            </ul>
          </div>
          <!-- Color And Style End --> 
          <!-- Logo Tabs -->
          <div id="tab-logo" style="display:none;">
            <div class="theme-header">
              <h1>Logo / Fav Icon Settings</h1>
            </div>
            <div class="theme-help">
              <h4>Logo / Fav Icon Settings</h4>
              <p>Add your logo and fav icon.</p>
            </div>
            <ul class="form-elements">
              <li class="to-label">
                <label>Upload Logo</label>
              </li>
              <li class="to-field">
                <input id="logo" name="logo" value="<?php echo $cs_theme_option['logo']?>" type="text" class="small {validate:{accept:'jpg|jpeg|gif|png|bmp'}}" />
                <input id="log" name="logo" type="button" class="uploadfile left" value="Browse"/>
                <?php if ( $cs_theme_option['logo'] <> "" ) { ?>
                <div class="thumb-preview" id="logo_img_div"> <img width="<?php echo $cs_theme_option['logo_width']?>" height="<?php echo $cs_theme_option['logo_height']?>" src="<?php echo $cs_theme_option['logo']?>" alt="" /> <a href="javascript:remove_image('logo')" class="del">&nbsp;</a> </div>
                <?php } ?>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Width</label>
              </li>
              <li class="to-field">
                <input type="text" name="logo_width" id="width-value" value="<?php echo $cs_theme_option['logo_width']?>" class="vsmall" />
                <span class="short">px</span>
                <p>Please enter the required size.</p>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Height</label>
              </li>
              <li class="to-field">
                <input type="text" name="logo_height" id="height-value" value="<?php echo $cs_theme_option['logo_height']?>" class="vsmall" />
                <span class="short">px</span>
                <p>Please enter the required size.</p>
              </li>
            </ul>
            <ul class="form-elements">
                                            <li class="to-label"><label>Sticky Logo</label></li>
                                            <li class="to-field">
                                                <input id="logo_sticky" name="logo_sticky" value="<?php echo $cs_theme_option['logo_sticky']?>" type="text" class="small {validate:{accept:'jpg|jpeg|gif|png|bmp'}}" />
                                                <input id="logo_sticky" name="logo_sticky" type="button" class="uploadfile left" value="Browse" />
                                                <p>Browse a logo, only jpg|jpeg|gif|png|bmp formats are allowed.</p>
                                            </li>
                                        </ul>
            <ul class="form-elements">
                                            <li class="to-label"><label>Sticky Menu</label></li>
                                            <li class="to-field">
                                              <input type="hidden" name="header_sticky_menu" value="" />
                  <input type="checkbox" class="myClass" name="header_sticky_menu" <?php if ($cs_theme_option['header_sticky_menu'] == "on") echo "checked" ?> />
                                            </li>
                                        </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>FAV Icon</label>
              </li>
              <li class="to-field">
                <input id="fav_icon" name="fav_icon" value="<?php echo $cs_theme_option['fav_icon']?>" type="text" class="small {validate:{accept:'ico|png'}}" />
                <input id="fav_icon" name="fav_icon" type="button" class="uploadfile left" value="Browse" />
                <p>Browse a small fav icon, only .ICO or .PNG format allowed.</p>
              </li>
            </ul>
          </div>

          <!-- Logo Tabs End --> 
          
          <div id="tab-default_headers" style="display:none;">
            <div class="theme-header">
              <h1>Header Settings</h1>
            </div>
            <div class="theme-help">
              <h4>Default Header Settings</h4>
              <p>Select your Default Header  </p>
            </div>
            <ul class="form-elements header-design">
              <li class="full">&nbsp;</li>
                <li class="full">
                  <p class="header-notification">
                    <strong>Note:</strong>  Default Header will be applied for only that pages Where headers settings Selected as default header, you can select your choice of header for page.
                  </p></li>
              <li class="to-label">
             
                <label>Default Header</label>
              </li>
			  <li class="to-field default-headers">
              	<div class="meta-input pattern">
                    <div class="radio-image-wrapper">
                        <input <?php if ($cs_theme_option['default_header'] == "header1" || $cs_theme_option['default_header'] == "") echo "checked" ?> type="radio" name="default_header" class="radio" value="header1" onclick="select_bg2()" />
                        <label for="radio_1"> <span class="ss"><img width="100" src="<?php echo get_template_directory_uri() ?>/images/admin/header1.png" /></span>  <span <?php if($cs_theme_option['default_header'] == "header1" )echo "class='check-list'"?> id="check-list">&nbsp;</span>  </label>
                        <span class="title-header">Header 1</span>
                    </div>
                </div>
                <div class="meta-input pattern">
                    <div class="radio-image-wrapper">
                        <input <?php if ($cs_theme_option['default_header'] == "header2") echo "checked" ?> type="radio" name="default_header" class="radio" value="header2" onclick="select_bg2()" />
                        <label for="radio_2"> <span class="ss"><img width="100" src="<?php echo get_template_directory_uri() ?>/images/admin/header2.png" /></span> <span <?php if($cs_theme_option['default_header'] == "header2" )echo "class='check-list'"?> id="check-list">&nbsp;</span></label>
	                	<span class="title-header">Header 2</span>
                    </div>
                </div>
                <div class="meta-input pattern">
                    <div class="radio-image-wrapper">
                    	<input <?php if ($cs_theme_option['default_header'] == "header3") echo "checked" ?> type="radio" name="default_header" class="radio" value="header3" onclick="select_bg2()" />
                      	<label for="radio_3"> <span class="ss"><img width="100" src="<?php echo get_template_directory_uri() ?>/images/admin/header3.png" /></span> <span <?php if($cs_theme_option['default_header'] == "header3" )echo "class='check-list'"?> id="check-list">&nbsp;</span> </label>
                    	<span class="title-header">Header 3</span>
                    </div>
                </div>
                <div class="meta-input pattern">
                    <div class="radio-image-wrapper">
                		<input <?php if ($cs_theme_option['default_header'] == "header4") echo "checked" ?> type="radio" name="default_header" class="radio" value="header4" onclick="select_bg2()" />
                  		<label for="radio_4"> <span class="ss"><img width="100" src="<?php echo get_template_directory_uri() ?>/images/admin/header4.png" /></span>  <span <?php if($cs_theme_option['default_header'] == "header4" )echo "class='check-list'"?> id="check-list">&nbsp;</span></label>
                		<span class="title-header">Header 4</span>
                    </div>
                </div>
                <div class="meta-input pattern">
                    <div class="radio-image-wrapper">
                		<input <?php if ($cs_theme_option['default_header'] == "header5") echo "checked" ?> type="radio" name="default_header" class="radio" value="header5" onclick="select_bg2()" />
                  		<label for="radio_5"> <span class="ss"><img width="100" src="<?php echo get_template_directory_uri() ?>/images/admin/header5.png" /></span> <span <?php if($cs_theme_option['default_header'] == "header5" )echo "class='check-list'"?> id="check-list">&nbsp;</span> </label>
                		<span class="title-header">Header 5</span>
                    </div>
                </div>
                <div class="meta-input pattern">
                    <div class="radio-image-wrapper">
                		<input <?php if ($cs_theme_option['default_header'] == "header6") echo "checked" ?> type="radio" name="default_header" class="radio" value="header6" onclick="select_bg2()" />
                  		<label for="radio_6"> <span class="ss"><img width="100" src="<?php echo get_template_directory_uri() ?>/images/admin/header6.png" /></span> <span <?php if($cs_theme_option['default_header'] == "header6" )echo "class='check-list'"?> id="check-list">&nbsp;</span> </label>
                		<span class="title-header">Header 6</span>
                    </div>
                </div>
                <div class="meta-input pattern">
                    <div class="radio-image-wrapper">
                		<input <?php if ($cs_theme_option['default_header'] == "header7") echo "checked" ?> type="radio" name="default_header" class="radio" value="header7" onclick="select_bg2()" />
                  		<label for="radio_6"> <span class="ss"><img width="100" src="<?php echo get_template_directory_uri() ?>/images/admin/header7.png" /></span> <span <?php if($cs_theme_option['default_header'] == "header7" )echo "class='check-list'"?> id="check-list">&nbsp;</span> </label>
	                	<span class="title-header">Header 7</span>
                    </div>
                </div>
              </li>
              
            </ul>
         </div>
             
          <!-- Header Styles -->
          <div id="tab-head-styles" style="display:none;">
            <div class="theme-header">
              <h1>Header Styles</h1>
            </div>
            <div class="theme-help">
              <h4>Header Styles</h4>
              <p>Add your Header styles.</p>
            </div>
            <ul class="form-elements header-design">
              <li class="full">&nbsp;</li>
              <li class="to-label">
                <label>Header Styles</label>
              </li>
              <li class="to-field">
                <select name="header_styles" onchange="fun_header_styles(this.value, '<?php echo get_template_directory_uri(); ?>')">
                  <?php cs_header_options(); ?>
                </select>
              </li>
              <li class="full">&nbsp;</li>
              <li class="to-label">&nbsp;</li>
              <li class="to-field">
                <div id="header_preview_img">
                  <?php $img_url = get_template_directory_uri() . '/images/admin/' . $cs_theme_option['header_styles'] . '.png'; ?>
                  <img src="<?php echo $img_url; ?>" alt="" /> </div>
              </li>
              </li>
            </ul>
            <?php
                        if ($cs_theme_option['header_styles'] == "header1") {
                           $display = 'block';
                        } else {
                           $display = 'none';
                        }
                        ?>
            <div class="header-section" id="header_banner1" style="display: <?php echo $display; ?>;" >
              <div class="opt-head">
                <h4>Settings</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Header bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_1_bg_color" value="<?php echo $cs_theme_option['header_1_bg_color'] ?>" class="bg_color" data-default-color="<?php echo $header1_default_colors['header_1_bg_color']; ?>" />
                </li>
                 <li class="full">&nbsp;</li>
                   <li class="to-label">
                  <label>Logo</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="header_1_logo" value=""  data-default-header="<?php echo $header1_default_colors['header_1_logo']; ?>"/>
                  <input type="checkbox" class="myClass" name="header_1_logo" <?php if ($cs_theme_option['header_1_logo'] == "on") echo "checked" ?>  data-default-header="<?php echo $header1_default_colors['header_1_logo']; ?>"/>
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Background Image</label>
                </li>
                <li class="to-field">
                  <input id="header_1_bg_image" name="header_1_bg_image" value="<?php echo $cs_theme_option['header_1_bg_image'] ?>" type="text" class="small {validate:{accept:'jpg|jpeg|gif|png|bmp'}}" data-default-header="<?php echo $header1_default_colors['header_1_bg_image']; ?>" />
                  <input id="log" name="header_1_bg_image" type="button" class="uploadfile left" value="Browse"/>
                  <?php if ($cs_theme_option['header_1_bg_image'] <> "") { ?>
                  <div class="thumb-preview" id="header_1_bg_image_img_div"> <img  src="<?php echo $cs_theme_option['header_1_bg_image'] ?>" alt="" /> <a href="javascript:remove_image('header_1_bg_image')" class="del">&nbsp;</a> </div>
                  <?php } ?>
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Top Menu</label>
                </li>
                <li class="to-field">
                  <?php
					 $menus = get_nav_menu_locations();
					 ?>
                  <select name="header_1_top_strip_menu" data-default-header="<?php echo $header1_default_colors['header_1_top_strip_menu']; ?>">
                    <option value="">Select Menu</option>
                    <?php
                                    foreach ($menus as $key => $value) {
                                       ?>
                    <option value="<?php echo $key; ?>" <?php if ($cs_theme_option['header_1_top_strip_menu'] == $key) echo "selected='selected'" ?>><?php echo $key; ?></option>
                    <?php } ?>
                  </select>
                </li>
                 <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Header Login on/off</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="header_1_login" value="" data-default-header="<?php echo $header1_default_colors['header_1_login']; ?>" />
                  <input type="checkbox" class="myClass" name="header_1_login" <?php if ($cs_theme_option['header_1_login'] == "on") echo "checked" ?> data-default-header="<?php echo $header1_default_colors['header_1_login']; ?>" />
                </li>
              </ul>
              <div class="opt-head">
                <h4>Navigation Colors</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_1_nav_bgcolr" value="<?php echo $cs_theme_option['header_1_nav_bgcolr'] ?>" class="bg_color" data-default-color="<?php echo $header1_default_colors['header_1_nav_bgcolr']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_1_nav_color" value="<?php echo $cs_theme_option['header_1_nav_color'] ?>" class="bg_color" data-default-color="<?php echo $header1_default_colors['header_1_nav_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Hover Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_1_nav_hover_color" value="<?php echo $cs_theme_option['header_1_nav_hover_color'] ?>" class="bg_color" data-default-color="<?php echo $header1_default_colors['header_1_nav_hover_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Hover bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_1_nav_hover_bgcolor" value="<?php echo $cs_theme_option['header_1_nav_hover_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header1_default_colors['header_1_nav_hover_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Active Text color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_1_nav_active_color" value="<?php echo $cs_theme_option['header_1_nav_active_color'] ?>" class="bg_color" data-default-color="<?php echo $header1_default_colors['header_1_nav_active_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Active bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_1_nav_active_bgcolor" value="<?php echo $cs_theme_option['header_1_nav_active_bgcolor'] ?>" class="bg_color" data-default-color="<?php
                                 if (isset($header1_default_colors['header_1_nav_active_bgcolor']) && !empty($header1_default_colors['header_1_nav_active_bgcolor'])) {
                                    echo $header1_default_colors['header_1_nav_active_bgcolor'];
                                 } else {
                                    echo ' ';
                                 }
                                 ?>" />
                </li>
              </ul>
              <div class="opt-head">
                <h4>Sub Navigation Colors</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation border color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_1_subnav_border_colr" value="<?php echo $cs_theme_option['header_1_subnav_border_colr'] ?>" class="bg_color" data-default-color="<?php echo $header1_default_colors['header_1_subnav_border_colr']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_1_subnav_bgcolr" value="<?php echo $cs_theme_option['header_1_subnav_bgcolr'] ?>" class="bg_color" data-default-color="<?php echo $header1_default_colors['header_1_subnav_bgcolr']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_1_subnav_color" value="<?php echo $cs_theme_option['header_1_subnav_color'] ?>" class="bg_color" data-default-color="<?php echo $header1_default_colors['header_1_subnav_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Hover Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_1_subnav_hover_color" value="<?php echo $cs_theme_option['header_1_subnav_hover_color'] ?>" class="bg_color" data-default-color="<?php echo $header1_default_colors['header_1_subnav_hover_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Hover bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_1_subnav_hover_bgcolor" value="<?php echo $cs_theme_option['header_1_subnav_hover_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header1_default_colors['header_1_subnav_hover_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Active Text color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_1_subnav_active_color" value="<?php echo $cs_theme_option['header_1_subnav_active_color'] ?>" class="bg_color" data-default-color="<?php echo $header1_default_colors['header_1_subnav_active_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Active bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_1_subnav_active_bgcolor" value="<?php echo $cs_theme_option['header_1_subnav_active_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header1_default_colors['header_1_subnav_active_bgcolor']; ?>" />
                </li>
              </ul>
              <div class="opt-head">
                <h4>Sub Header Colors</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_1_subheader_bgcolor" value="<?php echo $cs_theme_option['header_1_subheader_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header1_default_colors['header_1_subheader_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header Link Text Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_1_subheader_link_color" value="<?php echo $cs_theme_option['header_1_subheader_link_color'] ?>" class="bg_color" data-default-color="<?php echo $header1_default_colors['header_1_subheader_link_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header Title Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_1_subheader_title_color" value="<?php echo $cs_theme_option['header_1_subheader_title_color'] ?>" class="bg_color" data-default-color="<?php echo $header1_default_colors['header_1_subheader_title_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header Sub title Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_1_subheader_subtitle_color" value="<?php echo $cs_theme_option['header_1_subheader_subtitle_color'] ?>" class="bg_color" data-default-color="<?php echo $header1_default_colors['header_1_subheader_subtitle_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
              </ul>
              
            </div>
            <div class="header-section" id="header_banner2" style=" <?php
                        if ($cs_theme_option['header_styles'] == "header2")
                           echo 'display:block';
                        else
                           echo 'display:none'
                           ?>" >
              <div class="opt-head">
                <h4>Settings</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Header bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_2_bg_color" value="<?php echo $cs_theme_option['header_2_bg_color'] ?>" class="bg_color" data-default-color="<?php echo $header2_default_colors['header_2_bg_color']; ?>" />
                </li>
                 <li class="full">&nbsp;</li>
                   <li class="to-label">
                  <label>Logo</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="header_2_logo" value=""  data-default-header="<?php echo $header2_default_colors['header_2_logo']; ?>"/>
                  <input type="checkbox" class="myClass" name="header_2_logo" <?php if ($cs_theme_option['header_2_logo'] == "on") echo "checked" ?>  data-default-header="<?php echo $header2_default_colors['header_2_logo']; ?>"/>
                </li>
              </ul>
              <div class="opt-head">
                <h4>Navigation Colors</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_2_nav_bgcolr" value="<?php echo $cs_theme_option['header_2_nav_bgcolr'] ?>" class="bg_color" data-default-color="<?php echo $header2_default_colors['header_2_nav_bgcolr']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_2_nav_color" value="<?php echo $cs_theme_option['header_2_nav_color'] ?>" class="bg_color" data-default-color="<?php echo $header2_default_colors['header_2_nav_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Hover Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_2_nav_hover_color" value="<?php echo $cs_theme_option['header_2_nav_hover_color'] ?>" class="bg_color" data-default-color="<?php
                                 if (isset($header2_default_colors['header_2_nav_hover_bgcolor']) && $header2_default_colors['header_2_nav_hover_bgcolor'] <> '') {
                                    echo $header2_default_colors['header_2_nav_hover_bgcolor'];
                                 } else {
                                    echo ' ';
                                 }
                                 ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Hover bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_2_nav_hover_bgcolor" value="<?php echo $cs_theme_option['header_2_nav_hover_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header2_default_colors['header_2_nav_hover_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Active Text color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_2_nav_active_color" value="<?php echo $cs_theme_option['header_2_nav_active_color'] ?>" class="bg_color" data-default-color="<?php echo $header2_default_colors['header_2_nav_active_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Active bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_2_nav_active_bgcolor" value="<?php echo $cs_theme_option['header_2_nav_active_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header2_default_colors['header_2_nav_active_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
              </ul>
              <div class="opt-head">
                <h4>Sub Navigation Colors</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="to-label">
                  <label>Sub Navigation border color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_2_subnav_border_colr" value="<?php echo $cs_theme_option['header_2_subnav_border_colr'] ?>" class="bg_color" data-default-color="<?php echo $header2_default_colors['header_2_subnav_border_colr']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_2_subnav_bgcolr" value="<?php echo $cs_theme_option['header_2_subnav_bgcolr'] ?>" class="bg_color" data-default-color="<?php echo $header2_default_colors['header_2_subnav_bgcolr']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_2_subnav_color" value="<?php echo $cs_theme_option['header_2_subnav_color'] ?>" class="bg_color" data-default-color="<?php echo $header2_default_colors['header_2_subnav_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Hover Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_2_subnav_hover_color" value="<?php echo $cs_theme_option['header_2_subnav_hover_color'] ?>" class="bg_color" data-default-color="<?php echo $header2_default_colors['header_2_subnav_hover_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Hover bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_2_subnav_hover_bgcolor" value="<?php echo $cs_theme_option['header_2_subnav_hover_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header2_default_colors['header_2_subnav_hover_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Active Text color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_2_subnav_active_color" value="<?php echo $cs_theme_option['header_2_subnav_active_color'] ?>" class="bg_color" data-default-color="<?php echo $header2_default_colors['header_2_subnav_active_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Active bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_2_subnav_active_bgcolor" value="<?php echo $cs_theme_option['header_2_subnav_active_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header2_default_colors['header_2_subnav_active_bgcolor']; ?>" />
                </li>
              </ul>
              <div class="opt-head">
                <h4>Sub Header Colors</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_2_subheader_bgcolor" value="<?php echo $cs_theme_option['header_2_subheader_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header2_default_colors['header_2_subheader_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header Link Text Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_2_subheader_link_color" value="<?php echo $cs_theme_option['header_2_subheader_link_color'] ?>" class="bg_color" data-default-color="<?php echo $header2_default_colors['header_2_subheader_link_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header Title Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_2_subheader_title_color" value="<?php echo $cs_theme_option['header_2_subheader_title_color'] ?>" class="bg_color" data-default-color="<?php echo $header2_default_colors['header_2_subheader_title_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header Sub title Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_2_subheader_subtitle_color" value="<?php echo $cs_theme_option['header_2_subheader_subtitle_color'] ?>" class="bg_color" data-default-color="<?php echo $header2_default_colors['header_2_subheader_subtitle_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
              </ul>
            </div>
            <div class="header-section" id="header_banner3" style=" <?php
                        if ($cs_theme_option['header_styles'] == "header3")
                           echo 'display:block';
                        else
                           echo 'display:none'
                           ?>" >
              <div class="opt-head">
                <h4>Settings</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Header bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_3_bg_color" value="<?php echo $cs_theme_option['header_3_bg_color'] ?>" class="bg_color" data-default-color="<?php echo $header3_default_colors['header_3_bg_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                   <li class="to-label">
                  <label>Logo</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="header_3_logo" value=""  data-default-header="<?php echo $header3_default_colors['header_3_logo']; ?>"/>
                  <input type="checkbox" class="myClass" name="header_3_logo" <?php if ($cs_theme_option['header_3_logo'] == "on") echo "checked" ?>  data-default-header="<?php echo $header3_default_colors['header_3_logo']; ?>"/>
                </li>
                 <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Top Menu</label>
                </li>
                <li class="to-field">
                  <?php
					 $menus = get_nav_menu_locations();
					 ?>
                  <select name="header_3_top_strip_menu" data-default-header="<?php echo $header3_default_colors['header_3_top_strip_menu']; ?>">
                    <option value="">Select Menu</option>
                    <?php
                                    foreach ($menus as $key => $value) {
                                       ?>
                    <option value="<?php echo $key; ?>" <?php if ($cs_theme_option['header_3_top_strip_menu'] == $key) echo "selected='selected'" ?>><?php echo $key; ?></option>
                    <?php } ?>
                  </select>
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Header Login on/off</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="header_3_login" value="" data-default-header="<?php echo $header3_default_colors['header_3_login']; ?>" />
                  <input type="checkbox" class="myClass" name="header_3_login" <?php if ($cs_theme_option['header_3_login'] == "on") echo "checked" ?> data-default-header="<?php echo $header3_default_colors['header_3_login']; ?>" />
                </li>
               
              </ul>
              
              
              <div class="opt-head">
                <h4>Navigation Colors</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_3_nav_bgcolr" value="<?php echo $cs_theme_option['header_3_nav_bgcolr'] ?>" class="bg_color" data-default-color="<?php echo $header3_default_colors['header_3_nav_bgcolr']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_3_nav_color" value="<?php echo $cs_theme_option['header_3_nav_color'] ?>" class="bg_color" data-default-color="<?php echo $header3_default_colors['header_3_nav_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Hover Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_3_nav_hover_color" value="<?php echo $cs_theme_option['header_3_nav_hover_color'] ?>" class="bg_color" data-default-color="<?php echo $header3_default_colors['header_3_nav_hover_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Hover bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_3_nav_hover_bgcolor" value="<?php echo $cs_theme_option['header_3_nav_hover_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header3_default_colors['header_3_nav_hover_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Active Text color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_3_nav_active_color" value="<?php echo $cs_theme_option['header_3_nav_active_color'] ?>" class="bg_color" data-default-color="<?php echo $header3_default_colors['header_3_nav_active_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Active bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_3_nav_active_bgcolor" value="<?php echo $cs_theme_option['header_3_nav_active_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header3_default_colors['header_3_nav_active_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
              </ul>
              <div class="opt-head">
                <h4>Sub Navigation Colors</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="to-label">
                  <label>Sub Navigation border color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_3_subnav_border_colr" value="<?php echo $cs_theme_option['header_3_subnav_border_colr'] ?>" class="bg_color" data-default-color="<?php echo $header3_default_colors['header_3_subnav_border_colr']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_3_subnav_bgcolr" value="<?php echo $cs_theme_option['header_3_subnav_bgcolr'] ?>" class="bg_color" data-default-color="<?php echo $header3_default_colors['header_3_subnav_bgcolr']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_3_subnav_color" value="<?php echo $cs_theme_option['header_3_subnav_color'] ?>" class="bg_color" data-default-color="<?php echo $header3_default_colors['header_3_subnav_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Hover Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_3_subnav_hover_color" value="<?php echo $cs_theme_option['header_3_subnav_hover_color'] ?>" class="bg_color" data-default-color="<?php echo $header3_default_colors['header_3_subnav_hover_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Hover bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_3_subnav_hover_bgcolor" value="<?php echo $cs_theme_option['header_3_subnav_hover_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header3_default_colors['header_3_subnav_hover_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Active Text color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_3_subnav_active_color" value="<?php echo $cs_theme_option['header_3_subnav_active_color'] ?>" class="bg_color" data-default-color="<?php echo $header3_default_colors['header_3_subnav_active_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Active bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_3_subnav_active_bgcolor" value="<?php echo $cs_theme_option['header_3_subnav_active_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header3_default_colors['header_3_subnav_active_bgcolor']; ?>" />
                </li>
              </ul>
              <div class="opt-head">
                <h4>Sub Header Colors</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_3_subheader_bgcolor" value="<?php echo $cs_theme_option['header_3_subheader_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header3_default_colors['header_3_subheader_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header Link Text Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_3_subheader_link_color" value="<?php echo $cs_theme_option['header_3_subheader_link_color'] ?>" class="bg_color" data-default-color="<?php echo $header3_default_colors['header_3_subheader_link_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header Title Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_3_subheader_title_color" value="<?php echo $cs_theme_option['header_3_subheader_title_color'] ?>" class="bg_color" data-default-color="<?php echo $header3_default_colors['header_3_subheader_title_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header Sub title Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_3_subheader_subtitle_color" value="<?php echo $cs_theme_option['header_3_subheader_subtitle_color'] ?>" class="bg_color" data-default-color="<?php echo $header3_default_colors['header_3_subheader_subtitle_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
              </ul>
            </div>
            <div class="header-section" id="header_banner4" style=" <?php
                        if ($cs_theme_option['header_styles'] == "header4")
                           echo 'display:block';
                        else
                           echo 'display:none'
                           ?>" >
              <div class="opt-head">
                <h4>Settings</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Header bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_4_bg_color" value="<?php echo $cs_theme_option['header_4_bg_color'] ?>" class="bg_color" data-default-color="<?php echo $header4_default_colors['header_4_bg_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                   <li class="to-label">
                  <label>Logo</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="header_4_logo" value=""  data-default-header="<?php echo $header4_default_colors['header_4_logo']; ?>"/>
                  <input type="checkbox" class="myClass" name="header_4_logo" <?php if ($cs_theme_option['header_4_logo'] == "on") echo "checked" ?>  data-default-header="<?php echo $header4_default_colors['header_4_logo']; ?>"/>
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Top Menu</label>
                </li>
                <li class="to-field">
                  <?php
					 $menus = get_nav_menu_locations();
					 ?>
                  <select name="header_4_top_strip_menu" data-default-header="<?php echo $header1_default_colors['header_4_top_strip_menu']; ?>">
                    <option value="">Select Menu</option>
                    <?php
                                    foreach ($menus as $key => $value) {
                                       ?>
                    <option value="<?php echo $key; ?>" <?php if ($cs_theme_option['header_4_top_strip_menu'] == $key) echo "selected='selected'" ?>><?php echo $key; ?></option>
                    <?php } ?>
                  </select>
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Header Login on/off</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="header_4_login" value="" data-default-header="<?php echo $header4_default_colors['header_4_login']; ?>" />
                  <input type="checkbox" class="myClass" name="header_4_login" <?php if ($cs_theme_option['header_4_login'] == "on") echo "checked" ?> data-default-header="<?php echo $header4_default_colors['header_4_login']; ?>" />
                </li>
              </ul>
              
              
              <div class="opt-head">
                <h4>Navigation Colors</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_4_nav_bgcolr" value="<?php echo $cs_theme_option['header_4_nav_bgcolr'] ?>" class="bg_color" data-default-color="<?php echo $header4_default_colors['header_4_nav_bgcolr']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_4_nav_color" value="<?php echo $cs_theme_option['header_4_nav_color'] ?>" class="bg_color" data-default-color="<?php echo $header4_default_colors['header_4_nav_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Hover Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_4_nav_hover_color" value="<?php echo $cs_theme_option['header_4_nav_hover_color'] ?>" class="bg_color" data-default-color="<?php
                                 if (isset($header4_default_colors['header_4_nav_hover_bgcolor']) && $header4_default_colors['header_4_nav_hover_bgcolor'] <> '') {
                                    echo $header4_default_colors['header_4_nav_hover_bgcolor'];
                                 } else {
                                    echo ' ';
                                 }
                                 ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Hover bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_4_nav_hover_bgcolor" value="<?php echo $cs_theme_option['header_4_nav_hover_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header4_default_colors['header_4_nav_hover_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Active Text color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_4_nav_active_color" value="<?php echo $cs_theme_option['header_4_nav_active_color'] ?>" class="bg_color" data-default-color="<?php echo $header4_default_colors['header_4_nav_active_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Active bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_4_nav_active_bgcolor" value="<?php echo $cs_theme_option['header_4_nav_active_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header4_default_colors['header_4_nav_active_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
              </ul>
              <div class="opt-head">
                <h4>Sub Navigation Colors</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="to-label">
                  <label>Sub Navigation border color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_4_subnav_border_colr" value="<?php echo $cs_theme_option['header_4_subnav_border_colr'] ?>" class="bg_color" data-default-color="<?php echo $header4_default_colors['header_4_subnav_border_colr']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_4_subnav_bgcolr" value="<?php echo $cs_theme_option['header_4_subnav_bgcolr'] ?>" class="bg_color" data-default-color="<?php echo $header4_default_colors['header_4_subnav_bgcolr']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_4_subnav_color" value="<?php echo $cs_theme_option['header_4_subnav_color'] ?>" class="bg_color" data-default-color="<?php echo $header4_default_colors['header_4_subnav_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Hover Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_4_subnav_hover_color" value="<?php echo $cs_theme_option['header_4_subnav_hover_color'] ?>" class="bg_color" data-default-color="<?php echo $header4_default_colors['header_4_subnav_hover_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Hover bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_4_subnav_hover_bgcolor" value="<?php echo $cs_theme_option['header_4_subnav_hover_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header4_default_colors['header_4_subnav_hover_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Active Text color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_4_subnav_active_color" value="<?php echo $cs_theme_option['header_4_subnav_active_color'] ?>" class="bg_color" data-default-color="<?php echo $header4_default_colors['header_4_subnav_active_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Active bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_4_subnav_active_bgcolor" value="<?php echo $cs_theme_option['header_4_subnav_active_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header4_default_colors['header_4_subnav_active_bgcolor']; ?>" />
                </li>
              </ul>
              <div class="opt-head">
                <h4>Sub Header Colors</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_4_subheader_bgcolor" value="<?php echo $cs_theme_option['header_4_subheader_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header4_default_colors['header_4_subheader_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header Link Text Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_4_subheader_link_color" value="<?php echo $cs_theme_option['header_4_subheader_link_color'] ?>" class="bg_color" data-default-color="<?php echo $header4_default_colors['header_4_subheader_link_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header Title Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_4_subheader_title_color" value="<?php echo $cs_theme_option['header_4_subheader_title_color'] ?>" class="bg_color" data-default-color="<?php echo $header4_default_colors['header_4_subheader_title_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header Sub title Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_4_subheader_subtitle_color" value="<?php echo $cs_theme_option['header_4_subheader_subtitle_color'] ?>" class="bg_color" data-default-color="<?php echo $header4_default_colors['header_4_subheader_subtitle_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
              </ul>
            </div>
              <div id="header_banner5" style=" <?php
                        if ($cs_theme_option['header_styles'] == "header5")
                           echo 'display:block';
                        else
                           echo 'display:none'
                           ?>" >
              <div class="opt-head">
                <h4>Settings</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Header bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_5_bg_color" value="<?php echo $cs_theme_option['header_5_bg_color'] ?>" class="bg_color" data-default-color="<?php echo $header5_default_colors['header_5_bg_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                   <li class="to-label">
                  <label>Logo</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="header_5_logo" value=""  data-default-header="<?php echo $header5_default_colors['header_5_logo']; ?>"/>
                  <input type="checkbox" class="myClass" name="header_5_logo" <?php if ($cs_theme_option['header_5_logo'] == "on") echo "checked" ?>  data-default-header="<?php echo $header5_default_colors['header_5_logo']; ?>"/>
                </li>
              </ul>
             
              <div class="opt-head">
                <h4>Navigation Colors</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_5_nav_bgcolr" value="<?php echo $cs_theme_option['header_5_nav_bgcolr'] ?>" class="bg_color" data-default-color="<?php echo $header5_default_colors['header_5_nav_bgcolr']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_5_nav_color" value="<?php echo $cs_theme_option['header_5_nav_color'] ?>" class="bg_color" data-default-color="<?php echo $header5_default_colors['header_5_nav_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Hover Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_5_nav_hover_color" value="<?php echo $cs_theme_option['header_5_nav_hover_color'] ?>" class="bg_color" data-default-color="<?php echo $header5_default_colors['header_5_nav_hover_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Hover bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_5_nav_hover_bgcolor" value="<?php echo $cs_theme_option['header_5_nav_hover_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header5_default_colors['header_5_nav_hover_bgcolor']; ?>" />
                </li>
               
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Active Text color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_5_nav_active_color" value="<?php echo $cs_theme_option['header_5_nav_active_color'] ?>" class="bg_color" data-default-color="<?php echo $header5_default_colors['header_5_nav_active_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Active bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_5_nav_active_bgcolor" value="<?php echo $cs_theme_option['header_5_nav_active_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header5_default_colors['header_5_nav_active_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
              </ul>
              <div class="opt-head">
                <h4>Sub Navigation Colors</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="to-label">
                  <label>Sub Navigation border color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_5_subnav_border_colr" value="<?php echo $cs_theme_option['header_5_subnav_border_colr'] ?>" class="bg_color" data-default-color="<?php echo $header5_default_colors['header_5_subnav_border_colr']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_5_subnav_bgcolr" value="<?php echo $cs_theme_option['header_5_subnav_bgcolr'] ?>" class="bg_color" data-default-color="<?php echo $header5_default_colors['header_5_subnav_bgcolr']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_5_subnav_color" value="<?php echo $cs_theme_option['header_5_subnav_color'] ?>" class="bg_color" data-default-color="<?php echo $header5_default_colors['header_5_subnav_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Hover Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_5_subnav_hover_color" value="<?php echo $cs_theme_option['header_5_subnav_hover_color'] ?>" class="bg_color" data-default-color="<?php echo $header5_default_colors['header_5_subnav_hover_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Hover bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_5_subnav_hover_bgcolor" value="<?php echo $cs_theme_option['header_5_subnav_hover_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header5_default_colors['header_5_subnav_hover_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Active Text color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_5_subnav_active_color" value="<?php echo $cs_theme_option['header_5_subnav_active_color'] ?>" class="bg_color" data-default-color="<?php echo $header5_default_colors['header_5_subnav_active_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Active bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_5_subnav_active_bgcolor" value="<?php echo $cs_theme_option['header_5_subnav_active_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header5_default_colors['header_5_subnav_active_bgcolor']; ?>" />
                </li>
              </ul>
              <div class="opt-head">
                <h4>Sub Header Colors</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_5_subheader_bgcolor" value="<?php echo $cs_theme_option['header_5_subheader_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header5_default_colors['header_5_subheader_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header Link Text Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_5_subheader_link_color" value="<?php echo $cs_theme_option['header_5_subheader_link_color'] ?>" class="bg_color" data-default-color="<?php echo $header5_default_colors['header_5_subheader_link_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header Title Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_5_subheader_title_color" value="<?php echo $cs_theme_option['header_5_subheader_title_color'] ?>" class="bg_color" data-default-color="<?php echo $header5_default_colors['header_5_subheader_title_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header Sub title Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_5_subheader_subtitle_color" value="<?php echo $cs_theme_option['header_5_subheader_subtitle_color'] ?>" class="bg_color" data-default-color="<?php echo $header5_default_colors['header_5_subheader_subtitle_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
              </ul>
            </div>
            <div id="header_banner6" style=" <?php
                        if ($cs_theme_option['header_styles'] == "header6")
                           echo 'display:block';
                        else
                           echo 'display:none'
                           ?>" >
              <div class="opt-head">
                <h4>Settings</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Header bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_6_bg_color" value="<?php echo $cs_theme_option['header_6_bg_color'] ?>" class="bg_color" data-default-color="<?php echo $header6_default_colors['header_6_bg_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                   <li class="to-label">
                  <label>Logo</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="header_6_logo" value=""  data-default-header="<?php echo $header6_default_colors['header_6_logo']; ?>"/>
                  <input type="checkbox" class="myClass" name="header_6_logo" <?php if ($cs_theme_option['header_6_logo'] == "on") echo "checked" ?>  data-default-header="<?php echo $header6_default_colors['header_6_logo']; ?>"/>
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Top Menu</label>
                </li>
                <li class="to-field">
                  <?php
					 $menus = get_nav_menu_locations();
					 ?>
                  <select name="header_6_top_strip_menu" data-default-header="<?php echo $header6_default_colors['header_6_top_strip_menu']; ?>">
                    <option value="">Select Menu</option>
                    <?php
                                    foreach ($menus as $key => $value) {
                                       ?>
                    <option value="<?php echo $key; ?>" <?php if ($cs_theme_option['header_6_top_strip_menu'] == $key) echo "selected='selected'" ?>><?php echo $key; ?></option>
                    <?php } ?>
                  </select>
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Header Login on/off</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="header_6_login" value="" data-default-header="<?php echo $header6_default_colors['header_6_login']; ?>" />
                  <input type="checkbox" class="myClass" name="header_6_login" <?php if ($cs_theme_option['header_6_login'] == "on") echo "checked" ?> data-default-header="<?php echo $header6_default_colors['header_6_login']; ?>" />
                </li>
                
              </ul>
              
              
              <div class="opt-head">
                <h4>Navigation Colors</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_6_nav_bgcolr" value="<?php echo $cs_theme_option['header_6_nav_bgcolr'] ?>" class="bg_color" data-default-color="<?php echo $header6_default_colors['header_6_nav_bgcolr']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_6_nav_color" value="<?php echo $cs_theme_option['header_6_nav_color'] ?>" class="bg_color" data-default-color="<?php echo $header6_default_colors['header_6_nav_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Hover Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_6_nav_hover_color" value="<?php echo $cs_theme_option['header_6_nav_hover_color'] ?>" class="bg_color" data-default-color="<?php echo $header6_default_colors['header_6_nav_hover_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Hover bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_6_nav_hover_bgcolor" value="<?php echo $cs_theme_option['header_6_nav_hover_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header6_default_colors['header_6_nav_hover_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Active Text color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_6_nav_active_color" value="<?php echo $cs_theme_option['header_6_nav_active_color'] ?>" class="bg_color" data-default-color="<?php echo $header6_default_colors['header_6_nav_active_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Active bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_6_nav_active_bgcolor" value="<?php echo $cs_theme_option['header_6_nav_active_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header6_default_colors['header_6_nav_active_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
              </ul>
              <div class="opt-head">
                <h4>Sub Navigation Colors</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="to-label">
                  <label>Sub Navigation border color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_6_subnav_border_colr" value="<?php echo $cs_theme_option['header_6_subnav_border_colr'] ?>" class="bg_color" data-default-color="<?php echo $header6_default_colors['header_6_subnav_border_colr']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_6_subnav_bgcolr" value="<?php echo $cs_theme_option['header_6_subnav_bgcolr'] ?>" class="bg_color" data-default-color="<?php echo $header6_default_colors['header_6_subnav_bgcolr']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_6_subnav_color" value="<?php echo $cs_theme_option['header_6_subnav_color'] ?>" class="bg_color" data-default-color="<?php echo $header6_default_colors['header_6_subnav_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Hover Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_6_subnav_hover_color" value="<?php echo $cs_theme_option['header_6_subnav_hover_color'] ?>" class="bg_color" data-default-color="<?php echo $header6_default_colors['header_6_subnav_hover_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Hover bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_6_subnav_hover_bgcolor" value="<?php echo $cs_theme_option['header_6_subnav_hover_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header6_default_colors['header_6_subnav_hover_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Active Text color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_6_subnav_active_color" value="<?php echo $cs_theme_option['header_6_subnav_active_color'] ?>" class="bg_color" data-default-color="<?php echo $header6_default_colors['header_6_subnav_active_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Active bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_6_subnav_active_bgcolor" value="<?php echo $cs_theme_option['header_6_subnav_active_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header6_default_colors['header_6_subnav_active_bgcolor']; ?>" />
                </li>
              </ul>
              <div class="opt-head">
                <h4>Sub Header Colors</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_6_subheader_bgcolor" value="<?php echo $cs_theme_option['header_6_subheader_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header6_default_colors['header_6_subheader_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header Link Text Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_6_subheader_link_color" value="<?php echo $cs_theme_option['header_6_subheader_link_color'] ?>" class="bg_color" data-default-color="<?php echo $header6_default_colors['header_6_subheader_link_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header Title Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_6_subheader_title_color" value="<?php echo $cs_theme_option['header_6_subheader_title_color'] ?>" class="bg_color" data-default-color="<?php echo $header6_default_colors['header_6_subheader_title_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header Sub title Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_6_subheader_subtitle_color" value="<?php echo $cs_theme_option['header_6_subheader_subtitle_color'] ?>" class="bg_color" data-default-color="<?php echo $header6_default_colors['header_6_subheader_subtitle_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
              </ul>
            </div>
            <div id="header_banner7" style=" <?php
                        if ($cs_theme_option['header_styles'] == "header7")
                           echo 'display:block';
                        else
                           echo 'display:none'
                           ?>" >
              <div class="opt-head">
                <h4>Settings</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Header bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_7_bg_color" value="<?php echo $cs_theme_option['header_7_bg_color'] ?>" class="bg_color" data-default-color="<?php echo $header7_default_colors['header_7_bg_color']; ?>" />
                  </li>
                  <li class="full">&nbsp;</li>
                   <li class="to-label">
                  <label>Logo</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="header_7_logo" value=""  data-default-header="<?php echo $header7_default_colors['header_7_logo']; ?>"/>
                  <input type="checkbox" class="myClass" name="header_7_logo" <?php if ($cs_theme_option['header_7_logo'] == "on") echo "checked" ?>  data-default-header="<?php echo $header7_default_colors['header_7_logo']; ?>"/>
                </li>
              </ul>
              <div class="opt-head">
                <h4>Header Top Strip</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Top Strip</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="header_7_strip" value="" data-default-header="<?php echo $header7_default_colors['header_7_strip']; ?>"/>
                  <input type="checkbox" class="myClass" name="header_7_strip" <?php if ($cs_theme_option['header_7_strip'] == "on") echo "checked" ?> />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Header Login on/off</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="header_7_login" value=""  data-default-header="<?php echo $header7_default_colors['header_7_login']; ?>"/>
                  <input type="checkbox" class="myClass" name="header_7_login" <?php if ($cs_theme_option['header_7_login'] == "on") echo "checked" ?> data-default-header="<?php echo $header7_default_colors['header_7_login']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Strip Menu</label>
                </li>
                <li class="to-field">
                  <?php $menus = get_nav_menu_locations(); ?>
                  <select name="header_7_top_strip_menu" data-default-header="<?php echo $header5_default_colors['header_5_top_strip_menu']; ?>">
                    <option value="">Select Menu</option>
                    <?php foreach ($menus as $key => $value) {?>
                    <option value="<?php echo $key; ?>" <?php if ($cs_theme_option['header_7_top_strip_menu'] == $key) echo "selected='selected'" ?>><?php echo $key; ?></option>
                    <?php } ?>
                  </select>
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Social Icons</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="header_7_social_icons" value="" data-default-header="<?php echo $header7_default_colors['header_7_social_icons']; ?>" />
                  <input type="checkbox" class="myClass" name="header_7_social_icons" data-default-header="<?php echo $header7_default_colors['header_7_social_icons']; ?>" <?php if ($cs_theme_option['header_7_social_icons'] == "on") echo "checked" ?> />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Strip bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_7_top_strip_bg_color" value="<?php echo $cs_theme_option['header_7_top_strip_bg_color'] ?>" class="bg_color" data-default-color="<?php echo $header7_default_colors['header_7_top_strip_bg_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Strip Text Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_7_top_strip_color" value="<?php echo $cs_theme_option['header_7_top_strip_color'] ?>" class="bg_color" data-default-color="<?php echo $header7_default_colors['header_7_top_strip_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
              </ul>
              <div class="opt-head">
                <h4>Navigation Colors</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_7_nav_bgcolr" value="<?php echo $cs_theme_option['header_7_nav_bgcolr'] ?>" class="bg_color" data-default-color="<?php echo $header7_default_colors['header_7_nav_bgcolr']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_7_nav_color" value="<?php echo $cs_theme_option['header_7_nav_color'] ?>" class="bg_color" data-default-color="<?php echo $header7_default_colors['header_7_nav_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Hover Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_7_nav_hover_color" value="<?php echo $cs_theme_option['header_7_nav_hover_color'] ?>" class="bg_color" data-default-color="<?php echo $header7_default_colors['header_7_nav_hover_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Hover bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_7_nav_hover_bgcolor" value="<?php echo $cs_theme_option['header_7_nav_hover_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header7_default_colors['header_7_nav_hover_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Active Text color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_7_nav_active_color" value="<?php echo $cs_theme_option['header_7_nav_active_color'] ?>" class="bg_color" data-default-color="<?php echo $header7_default_colors['header_7_nav_active_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Navigation Active bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_7_nav_active_bgcolor" value="<?php echo $cs_theme_option['header_7_nav_active_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header7_default_colors['header_7_nav_active_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
              </ul>
              <div class="opt-head">
                <h4>Sub Navigation Colors</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="to-label">
                  <label>Sub Navigation border color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_7_subnav_border_colr" value="<?php echo $cs_theme_option['header_7_subnav_border_colr'] ?>" class="bg_color" data-default-color="<?php echo $header7_default_colors['header_7_subnav_border_colr']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_7_subnav_bgcolr" value="<?php echo $cs_theme_option['header_7_subnav_bgcolr'] ?>" class="bg_color" data-default-color="<?php echo $header7_default_colors['header_7_subnav_bgcolr']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_7_subnav_color" value="<?php echo $cs_theme_option['header_7_subnav_color'] ?>" class="bg_color" data-default-color="<?php echo $header7_default_colors['header_7_subnav_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Hover Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_7_subnav_hover_color" value="<?php echo $cs_theme_option['header_7_subnav_hover_color'] ?>" class="bg_color" data-default-color="<?php echo $header7_default_colors['header_7_subnav_hover_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Hover bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_7_subnav_hover_bgcolor" value="<?php echo $cs_theme_option['header_7_subnav_hover_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header7_default_colors['header_7_subnav_hover_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Active Text color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_7_subnav_active_color" value="<?php echo $cs_theme_option['header_7_subnav_active_color'] ?>" class="bg_color" data-default-color="<?php echo $header7_default_colors['header_7_subnav_active_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Navigation Active bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_7_subnav_active_bgcolor" value="<?php echo $cs_theme_option['header_7_subnav_active_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header7_default_colors['header_7_subnav_active_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
              </ul>
              <div class="opt-head">
                <h4>Sub Header Colors</h4>
                <div class="clear"></div>
              </div>
              <ul class="form-elements">
                <li class="to-label">
                  <label>Sub Header bgcolor</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_7_subheader_bgcolor" value="<?php echo $cs_theme_option['header_7_subheader_bgcolor'] ?>" class="bg_color" data-default-color="<?php echo $header7_default_colors['header_7_subheader_bgcolor']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header Link Text Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_7_subheader_link_color" value="<?php echo $cs_theme_option['header_7_subheader_link_color'] ?>" class="bg_color" data-default-color="<?php echo $header7_default_colors['header_7_subheader_link_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header Title Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_7_subheader_title_color" value="<?php echo $cs_theme_option['header_7_subheader_title_color'] ?>" class="bg_color" data-default-color="<?php echo $header7_default_colors['header_7_subheader_title_color']; ?>" />
                </li>
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Sub Header Sub title Color</label>
                </li>
                <li class="to-field">
                  <input type="text" name="header_7_subheader_subtitle_color" value="<?php echo $cs_theme_option['header_7_subheader_subtitle_color'] ?>" class="bg_color" data-default-color="<?php echo $header7_default_colors['header_7_subheader_subtitle_color']; ?>" />
                </li>
              </ul>
            </div>
          </div>
         
        <!-- Header Styles end--> 
        <!-- Header Script -->
        <div id="tab-head-scripts" style="display:none;">
          <div class="theme-header">
            <h1>Header Settings</h1>
          </div>
          <div class="theme-help">
            <h4>Header Settings</h4>
            <p>Modify your header settings</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>Header Code</label>
            </li>
            <li class="to-field">
              <textarea rows="" cols="" name="header_code"><?php echo $cs_theme_option['header_code']?></textarea>
              <p>Paste your Html or Css Code here.</p>
            </li>
          </ul>
        </div>
        <!-- Header Script End --> 
        <!-- Footer Settings -->
        <div id="tab-foot-setting" style="display:none;">
          <div class="theme-header">
            <h1>Footer Settings</h1>
          </div>
          <div class="theme-help">
            <h4>Footer Settings</h4>
            <p>Add footer setting detail.</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>Footer Logo</label>
            </li>
            <li class="to-field">
              <input id="footer_logo" name="footer_logo" value="<?php echo $cs_theme_option['footer_logo'] ?>" type="text" class="small {validate:{accept:'jpg|jpeg|gif|png|bmp'}}" />
              <input id="log" name="footer_logo" type="button" class="uploadfile left" value="Browse"/>
              <?php if ($cs_theme_option['footer_logo'] <> "") { ?>
              <div class="thumb-preview" id="footer_logo_img_div"> <img  src="<?php echo $cs_theme_option['footer_logo'] ?>" alt="" height="150"/> <a href="javascript:remove_image('footer_logo')" class="del">&nbsp;</a> </div>
              <?php } ?>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Footer Background Image</label>
            </li>
            <li class="to-field">
              <input id="footer_bg_img" name="footer_bg_img" value="<?php echo $cs_theme_option['footer_bg_img'] ?>" type="text" class="small {validate:{accept:'jpg|jpeg|gif|png|bmp'}}" />
              <input id="log" name="footer_bg_img" type="button" class="uploadfile left" value="Browse"/>
              <?php if ($cs_theme_option['footer_bg_img'] <> "") { ?>
              <div class="thumb-preview" id="footer_bg_img_img_div"> <img  src="<?php echo $cs_theme_option['footer_bg_img'] ?>" alt="" height="150"/> <a href="javascript:remove_image('footer_bg_img')" class="del">&nbsp;</a> </div>
              <?php } ?>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Custom Copyright</label>
            </li>
            <li class="to-field">
              <textarea rows="2" cols="4" name="copyright"><?php echo $cs_theme_option['copyright']?></textarea>
              <p>Write Custom Copyright text.</p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Powered By Text</label>
            </li>
            <li class="to-field">
            <textarea rows="2" cols="4" name="powered_by"><?php echo $cs_theme_option['powered_by']?></textarea>
              <p>Please enter powered by text.</p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Analytics Code</label>
            </li>
            <li class="to-field">
              <textarea rows="" cols="" name="analytics"><?php echo $cs_theme_option['analytics']?></textarea>
              <p>Paste your Google Analytics (or other) tracking code here.<br />
                This will be added into the footer template of your theme.</p>
            </li>
          </ul>
        </div>
        <!-- Footer Settings End --> 
        <!-- Maintenance Page Settings start -->
        <div id="tab-under-consturction" style="display:none;">
          <div class="theme-header">
            <h1>Maintenance Page Settings</h1>
          </div>
          <div class="theme-help">
            <h4>Maintenance Page Settings</h4>
            <p>Add maintenance page setting detail.</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>Maintenance Page</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="under-construction" value="" />
              <input type="checkbox" class="myClass" name="under-construction" <?php if($cs_theme_option['under-construction']=="on") echo "checked" ?> />
              <p>Set the maintenance page On/Off</p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Show Logo</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="showlogo" value="" />
              <input type="checkbox" class="myClass" name="showlogo" <?php if($cs_theme_option['showlogo']=="on") echo "checked" ?> />
              <p>Set show logo On/Off</p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Maintenance Text</label>
            </li>
            <li class="to-field">
              <textarea rows="2" cols="4" name="under_construction_text"><?php echo $cs_theme_option['under_construction_text']?></textarea>
              <p>Write Maintenance.</p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Launch Date</label>
            </li>
            <li class="to-field">
              <input type="text" id="launch_date" name="launch_date" value="<?php if($cs_theme_option['launch_date'] == ''){ echo gmdate("Y-m-d"); }else{ echo $cs_theme_option['launch_date']; } ?>" />
              <p>Select the site launch date</p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Social Network</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="socialnetwork" value="" />
              <input type="checkbox" class="myClass" name="socialnetwork" <?php if($cs_theme_option['socialnetwork']=="on") echo "checked" ?> />
              <p>Set social network On/Off</p>
            </li>
          </ul>
        </div>
        <!-- Maintenance Page Settings end --> 
        <!-- Other Settings Start -->
        <div id="tab-other" style="display:none;">
          <div class="theme-header">
            <h1>Other Setting</h1>
          </div>
          <div class="theme-help">
            <h4>Other Setting</h4>
            <p>Other Setting</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>Responsive</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="responsive" value="" />
              <input type="checkbox" class="myClass" name="responsive" <?php if($cs_theme_option['responsive']=="on") echo "checked" ?> />
              <p>Set the responsive On/Off</p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Right to Left (RTL)</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="style_rtl" value="" />
              <input type="checkbox" class="myClass" name="style_rtl" <?php if($cs_theme_option['style_rtl']=="on") echo "checked" ?> />
              <p>Set the theme style "Right to Left (RTL)" </p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Color Switcher</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="color_switcher" value="" />
              <input type="checkbox" class="myClass" name="color_switcher" <?php if($cs_theme_option['color_switcher']=="on") echo "checked" ?> />
              <p>Set the color switcher for user demo</p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Translation Switcher</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="trans_switcher" value="" />
              <input type="checkbox" class="myClass" name="trans_switcher" <?php if($cs_theme_option['trans_switcher']=="on") echo "checked" ?> />
              <p>Set the translation switcher for user demo</p>
            </li>
          </ul>
        </div>
        <!-- Other Settings End --> 
        <!-- API Settings Start -->
        <div id="tab-api-key" style="display:none;">
          <div class="theme-header">
            <h1>API Setting</h1>
          </div>
          <div class="theme-help">
            <h4>Twitter API Setting</h4>
            <p>Twitter API Setting</p>
          </div>
          <div class="opt-head">
            <h4>Twitter API Setting</h4>
            <div class="clear"></div>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>Twitter User Name</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="consumer_key" value="" />
              <input type="text" id="screen_name" name="screen_name" value="<?php  echo $cs_theme_option['screen_name'];  ?>"  class="{validate:{required:true}}"/>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Twitter API Consumer Key</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="consumer_key" value="" />
              <input type="text" id="consumer_key" name="consumer_key" value="<?php  echo $cs_theme_option['consumer_key'];  ?>"  class="{validate:{required:true}}"/>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Twitter API Consumer Secret</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="consumer_secret" value="" />
              <input type="text" id="consumer_secret" name="consumer_secret" value="<?php echo $cs_theme_option['consumer_secret']; ?>" class="{validate:{required:true}}"/>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Twitter Bearer Token:</label>
            </li>
            <li class="to-field">
              <input type="text" disabled value="<?php echo get_option( 'TWITTER_BEARER_TOKEN', '' ); ?>" size="50">
            </li>
          </ul>
          <input type="hidden" id="submit_btn" name="twitter_setting" class="botbtn" value="Generate Bearer Token"  />
        </div>
        <!-- API Settings end -->
        <div id="tab-slider" style="display:none;">
          <div class="theme-header">
            <h1>Home Page Slider</h1>
          </div>
          <div class="theme-help">
            <h4>Home Page Slider</h4>
            <p>Edit home page slider settings</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>Show Slider</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="show_slider" value="" />
              <input type="checkbox" class="myClass" name="show_slider" <?php if($cs_theme_option['show_slider']=="on") echo "checked" ?> />
              <p>Switch it on if you want to show slider at home page. If you switch it off it will not show slider at home page</p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Choose SliderType</label>
            </li>
            <li class="to-field">
              <select name="slider_type" class="dropdown" onchange="javascript:home_slider_toggle(this.value)">
                 <option <?php if($cs_theme_option['slider_type']=="Flex Slider"){echo "selected";}?> >Flex Slider</option>
                <option <?php if($cs_theme_option['slider_type']=="Layer Slider"){echo "selected";}?> >Layer Slider</option>
              </select>
            </li>
          </ul>
          <ul class="form-elements" id="other_sliders" style=" <?php if($cs_theme_option['slider_type']=="" or $cs_theme_option['slider_type']=="Layer Slider")echo "display:none"; else "display:inline"; ?>">
            <li class="to-label">
              <label>Select Slider</label>
            </li>
            <li class="to-field">
              <select name="slider_name" class="dropdown">
                <option value="">-- Select Slider --</option>
                <?php
                                                    query_posts("posts_per_page=-1&post_type=cs_slider");
                                                    while ( have_posts()) : the_post();
                                                ?>
                <option <?php if($post->post_name==$cs_theme_option['slider_name'])echo "selected";?> value="<?php echo $post->post_name; ?>">
                <?php the_title()?>
                </option>
                <?php
                                                    endwhile;
                                                ?>
              </select>
              <p>Slider images resolution should be (1900 x 532). Create new Slider from <a style="color:#06F; text-decoration:underline;" href="<?php echo get_site_url(); ?>/wp-admin/post-new.php?post_type=cs_slider">here</a></p>
            </li>
          </ul>
          <ul class="form-elements" id="layer_slider" style=" <?php if($cs_theme_option['slider_type'] =="" or $cs_theme_option['slider_type'] <> "Layer Slider")echo "display:none"; else "display:inline"; ?>" >
            <li class="to-label">
              <label>Layer Slider Short Code</label>
            </li>
            <li class="to-field">
              <input type="text" name="slider_id" class="txtfield" value="<?php echo $cs_theme_option['slider_id'];?>" />
              <p>Please enter the Layer Slider Short Code like [layerslider id="1"]</p>
            </li>
          </ul>
        </div>
        <div id="tab-font-settings" style="display:none;">
          <div class="theme-header">
            <h1>Fonts Settings</h1>
          </div>
          <div class="theme-help">
            <h4>Fonts Settings</h4>
            <p>Edit Fonts Settings</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>H1 Size</label>
            </li>
            <li class="to-field">
              <input type="text" name="h1_size" value="<?php echo $cs_theme_option['h1_size']?>" class="vsmall" />
              <span class="short">px</span>
              <p>Please enter the required size.</p>
            </li>
            <li class="full">&nbsp;</li>
            <li class="to-label">&nbsp;</li>
            <li class="to-field">
              <select name="h1_g_font">
                <option value="">-- Default Font --</option>
                <?php foreach( $g_fonts as $key => $font ): ?>
                <option <?php if($cs_theme_option['h1_g_font']==$font){echo "selected";}?>><?php echo $font; ?></option>
                <?php endforeach; ?>
              </select>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>H2 Size</label>
            </li>
            <li class="to-field">
              <input type="text" name="h2_size" value="<?php echo $cs_theme_option['h2_size']?>" class="vsmall" />
              <span class="short">px</span>
              <p>Please enter the required size.</p>
            </li>
            <li class="full">&nbsp;</li>
            <li class="to-label">&nbsp;</li>
            <li class="to-field">
              <select name="h2_g_font">
                <option value="">-- Default Font --</option>
                <?php foreach( $g_fonts as $key => $font ): ?>
                <option <?php if($cs_theme_option['h2_g_font']==$font){echo "selected";}?>><?php echo $font; ?></option>
                <?php endforeach; ?>
              </select>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>H3 Size</label>
            </li>
            <li class="to-field">
              <input type="text" name="h3_size" value="<?php echo $cs_theme_option['h3_size']?>" class="vsmall" />
              <span class="short">px</span>
              <p>Please enter the required size.</p>
            </li>
            <li class="full">&nbsp;</li>
            <li class="to-label">&nbsp;</li>
            <li class="to-field">
              <select name="h3_g_font">
                <option value="">-- Default Font --</option>
                <?php foreach( $g_fonts as $key => $font ): ?>
                <option <?php if($cs_theme_option['h3_g_font']==$font){echo "selected";}?>><?php echo $font; ?></option>
                <?php endforeach; ?>
              </select>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>H4 Size</label>
            </li>
            <li class="to-field">
              <input type="text" name="h4_size" value="<?php echo $cs_theme_option['h4_size']?>" class="vsmall" />
              <span class="short">px</span>
              <p>Please enter the required size.</p>
            </li>
            <li class="full">&nbsp;</li>
            <li class="to-label">&nbsp;</li>
            <li class="to-field">
              <select name="h4_g_font">
                <option value="">-- Default Font --</option>
                <?php foreach( $g_fonts as $key => $font ): ?>
                <option <?php if($cs_theme_option['h4_g_font']==$font){echo "selected";}?>><?php echo $font; ?></option>
                <?php endforeach; ?>
              </select>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>H5 Size</label>
            </li>
            <li class="to-field">
              <input type="text" name="h5_size" value="<?php echo $cs_theme_option['h5_size']?>" class="vsmall" />
              <span class="short">px</span>
              <p>Please enter the required size.</p>
            </li>
            <li class="full">&nbsp;</li>
            <li class="to-label">&nbsp;</li>
            <li class="to-field">
              <select name="h5_g_font">
                <option value="">-- Default Font --</option>
                <?php foreach( $g_fonts as $key => $font ): ?>
                <option <?php if($cs_theme_option['h5_g_font']==$font){echo "selected";}?>><?php echo $font; ?></option>
                <?php endforeach; ?>
              </select>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>H6 Size</label>
            </li>
            <li class="to-field">
              <input type="text" name="h6_size" value="<?php echo $cs_theme_option['h6_size']?>" class="vsmall" />
              <span class="short">px</span>
              <p>Please enter the required size.</p>
            </li>
            <li class="full">&nbsp;</li>
            <li class="to-label">&nbsp;</li>
            <li class="to-field">
              <select name="h6_g_font">
                <option value="">-- Default Font --</option>
                <?php foreach( $g_fonts as $key => $font ): ?>
                <option <?php if($cs_theme_option['h6_g_font']==$font){echo "selected";}?>><?php echo $font; ?></option>
                <?php endforeach; ?>
              </select>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Content Text Size</label>
            </li>
            <li class="to-field">
              <input type="text" name="content_size" value="<?php echo $cs_theme_option['content_size']?>" class="vsmall" />
              <span class="short">px</span>
              <p>Please enter the required size.</p>
            </li>
            <li class="full">&nbsp;</li>
            <li class="to-label">&nbsp;</li>
            <li class="to-field">
              <select name="content_size_g_font">
                <option value="">-- Default Font --</option>
                <?php foreach( $g_fonts as $key => $font ): ?>
                <option <?php if($cs_theme_option['content_size_g_font']==$font){echo "selected";}?>><?php echo $font; ?></option>
                <?php endforeach; ?>
              </select>
            </li>
          </ul>
        </div>
        <div id="tab-manage-sidebars" style="display:none;">
          <div class="theme-header">
            <h1>Manage Sidebars</h1>
          </div>
          <div class="theme-help">
            <h4>Manage Sidebars</h4>
            <p>Manage Sidebars</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>Sidebar Name</label>
            </li>
            <li class="to-field">
              <input class="small" type="text" name="sidebar_input" id="sidebar_input" style="width:420px;" />
              <input type="button" value="Add Sidebar" onclick="javascript:add_sidebar()" />
              <p>Please enter the desired title of sidebar.</p>
            </li>
          </ul>
          <div class="opt-head">
            <h4>Already Added Sidebars</h4>
            <div class="clear"></div>
          </div>
          <div class="boxes">
            <table class="to-table" border="0" cellspacing="0">
              <thead>
                <tr>
                  <th>Sider Bar Name</th>
                  <th class="centr">Actions</th>
                </tr>
              </thead>
              <tbody id="sidebar_area">
                <?php
													if ( isset($cs_theme_option['sidebar']) and count($cs_theme_option['sidebar']) > 0 ) {
														$cs_counter_sidebar = rand(10000,20000);
														foreach ( $cs_theme_option['sidebar'] as $sidebar ){
															$cs_counter_sidebar++;
															echo '<tr id="'.$cs_counter_sidebar.'">';
																echo '<td><input type="hidden" name="sidebar[]" value="'.$sidebar.'" />'.$sidebar.'</td>';
																echo '<td class="centr"> <a onclick="javascript:return confirm(\'Are you sure! You want to delete this\')" href="javascript:cs_div_remove('.$cs_counter_sidebar.')">Del</a> </td>';
															echo '</tr>';
														}
													}
													?>
              </tbody>
            </table>
          </div>
        </div>
        
        <div id="tab-flex-slider" style="display:none;">
          <div class="theme-header">
            <h1>Flex Slider</h1>
          </div>
          <div class="theme-help">
            <h4>Flex Slider Options</h4>
            <p>Configure Flex Slider setting</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>Effects</label>
            </li>
            <li class="to-field">
              <select class="dropdown" name="flex_effect">
                <option <?php if($cs_theme_option['flex_effect']=="fade"){echo "selected";}?> value="fade" >Fade</option>
                <option <?php if($cs_theme_option['flex_effect']=="slide"){echo "selected";}?> value="slide" >Slide</option>
              </select>
              <p>Please select Effect for flex Slider.</p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Auto Play</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="flex_auto_play" value="" />
              <input type="checkbox" name="flex_auto_play" <?php if ( $cs_theme_option['flex_auto_play'] == "on" ){ echo "checked";}?> class="myClass" />
              <p>If true, the slideshow will start running on page load</p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Animation Speed</label>
            </li>
            <li class="to-field">
              <input type="text" name="flex_animation_speed" size="5" class="{validate:{required:true}} bar" value="<?php echo $cs_theme_option['flex_animation_speed']?>" />
              <p>How long the slideshow transition takes (in milliseconds)</p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Pause Time</label>
            </li>
            <li class="to-field">
              <input type="text" name="flex_pause_time" size="5" class="{validate:{required:true}} bar" value="<?php echo $cs_theme_option['flex_pause_time']?>" />
              <p>Resume slideshow after user interaction (in milliseconds)</p>
            </li>
          </ul>
        </div>
         <div id="tab-social-network" style="display:none;">
          <div class="theme-header">
            <h1>Social Settings</h1>
          </div>
          <div class="theme-help">
            <h4>Social Network</h4>
            <p>Edit Social Network</p>
          </div>
          <!--<ul class="form-elements">
            <li class="to-label">
              <label>Section Title</label>
            </li>
            <li class="to-field">
              <input type="text" name="social_net_title" value="<?php echo $cs_theme_option['social_net_title']?>" />
            </li>
          </ul>-->
          <ul class="form-elements">
            <li class="to-label">
              <label>Icon Path</label>
            </li>
            <li class="to-field">
		      <input id="social_net_icon_path_input" type="text" class="small" onblur="javascript:update_image('social_net_icon_path_input_img_div')" />
              <input id="social_net_icon_path_input" name="social_net_icon_path_input" type="button" class="uploadfile left" value="Browse"/>
            </li>
            <li class="full">&nbsp;</li>
            <li class="to-label">
              <label>Awesome Font</label>
            </li>
            <li class="to-field">
              <input class="small" type="text" id="social_net_awesome_input" style="width:420px;" />
              <p>Put Awesome Font Code like "icon-flag".</p>
            </li>
            <li class="full">&nbsp;</li>
            <li class="to-label">
              <label>URL</label>
            </li>
            <li class="to-field">
              <input class="small" type="text" id="social_net_url_input" style="width:420px;" />
              <p>Please enter full URL.</p>
            </li>
            <li class="full">&nbsp;</li>
            <li class="to-label">
              <label>Title</label>
            </li>
            <li class="to-field">
              <input class="small" type="text" id="social_net_tooltip_input" style="width:420px;" />
              <p>Please enter text for icon tooltip.</p>
            </li>
            <li class="full">&nbsp;</li>
            <li class="to-label"></li>
            <li class="to-field"><input type="button" value="Add" onclick="javascript:cs_add_social_icon('<?php echo home_url()?>')" /></li>
          </ul>
          <div class="opt-head">
            <h4>Already Added Items</h4>
            <div class="clear"></div>
          </div>
          <div class="boxes">
            <table class="to-table" border="0" cellspacing="0">
              <thead>
                <tr>
                  <th>Icon Path</th>
                  <th>URL</th>
                  <th class="centr">Actions</th>
                </tr>
              </thead>
              <tbody id="social_network_area">
                <?php
					if ( isset($cs_theme_option['social_net_url']) and count($cs_theme_option['social_net_url']) > 0 ) {
						wp_enqueue_style('font-awesome_css', get_template_directory_uri() . '/css/font-awesome.css');
						// Register stylesheet
						wp_register_style( 'font-awesome-ie7_css', get_template_directory_uri() . '/css/font-awesome-ie7.css' );
						// Apply IE conditionals
						$GLOBALS['wp_styles']->add_data( 'font-awesome-ie7_css', 'conditional', 'lte IE 9' );
						// Enqueue stylesheet
						wp_enqueue_style( 'font-awesome-ie7_css' );
						$cs_counter_social_network = rand(10000,20000);
						$i = 0;
						foreach ( $cs_theme_option['social_net_url'] as $val ){
							$cs_counter_social_network++;
							echo '<tr id="del_'.$cs_counter_social_network.'">';
								if(isset($cs_theme_option['social_net_awesome'][$i]) && $cs_theme_option['social_net_awesome'][$i] <> ''){
									echo '<td><i style="color: green;" class="'.$cs_theme_option['social_net_awesome'][$i].' icon-2x"></td>';
								} else {
									echo '<td><img width="50" src="'.$cs_theme_option['social_net_icon_path'][$i].'"></td>';
								}
								echo '<td>'.$val.'</td>';
								echo '<td class="centr"> 
											<a onclick="javascript:return confirm(\'Are you sure! You want to delete this\')" href="javascript:social_icon_del('.$cs_counter_social_network.')">Del</a>
											| <a href="javascript:cs_toggle('.$cs_counter_social_network.')">Edit</a>
										</td>';
							echo '</tr>';
							?>
                            	<tr id="<?php echo $cs_counter_social_network;?>" style="display:none">
                                <td colspan="3">
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Icon Path</label></li>
                                        <li class="to-field">
                                          <input id="social_net_icon_path<?php echo $cs_counter_social_network?>" name="social_net_icon_path[]" value="<?php echo $cs_theme_option['social_net_icon_path'][$i]?>" type="text" class="small" />
                                        </li>
                                        <li><a onclick="cs_toggle('<?php echo $cs_counter_social_network?>')"><img src="<?php echo get_template_directory_uri()?>/images/admin/close-red.png" /></a></li>
                                        <li class="full">&nbsp;</li>
                                        <li class="to-label"><label>Awesome Font</label></li>	
                                        <li class="to-field">
                                          <input class="small" type="text" id="social_net_awesome" name="social_net_awesome[]" value="<?php echo $cs_theme_option['social_net_awesome'][$i]?>" style="width:420px;" />
                                          <p>Put Awesome Font Code like "icon-flag".</p>
                                        </li>
                                        <li class="full">&nbsp;</li>
                                        <li class="to-label"><label>URL</label></li>	
                                        <li class="to-field">
                                          <input class="small" type="text" id="social_net_url" name="social_net_url[]" value="<?php echo $val?>" style="width:420px;" />
                                          <p>Please enter full URL.</p>
                                        </li>
                                        <li class="full">&nbsp;</li>
                                        <li class="to-label"><label>Title</label></li>
                                        <li class="to-field">
                                          <input class="small" type="text" id="social_net_tooltip" name="social_net_tooltip[]" value="<?php echo $cs_theme_option['social_net_tooltip'][$i]?>" style="width:420px;" />
                                          <p>Please enter text for icon tooltip.</p>
                                        </li>
                                    </ul>
                                </td>
                                </tr>
							<?php
							$i++;
						}
					}
				?>
              </tbody>
            </table>
          </div>
        </div>
        
        <div id="tab-social-sharing" style="display:none;">
          <div class="theme-header">
            <h1>Social Settings</h1>
          </div>
          <div class="theme-help">
            <h4>Social Network / Sharing</h4>
            <p>Edit Social Network / Sharing</p>
          </div>
          <div class="social-head">
            <ul>
              <li>Social Sharing</li>
            </ul>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>Facebook</label>
            </li>
            <li class="to-field social-share">
              <input type="hidden" name="facebook_share" value="" />
              <input type="checkbox" class="myClass" name="facebook_share" <?php if($cs_theme_option['facebook_share']=="on") echo "checked" ?> />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Twitter</label>
            </li>
            <li class="to-field social-share">
              <input type="hidden" name="twitter_share" value="" />
              <input type="checkbox" class="myClass" name="twitter_share" <?php if($cs_theme_option['twitter_share']=="on") echo "checked" ?> />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Linkedin</label>
            </li>
            <li class="to-field social-share">
              <input type="hidden" name="linkedin_share" value="" />
              <input type="checkbox" class="myClass" name="linkedin_share" <?php if($cs_theme_option['linkedin_share']=="on") echo "checked" ?> />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Pinterest</label>
            </li>
            <li class="to-field social-share">
              <input type="hidden" name="pinterest_share" value="" />
              <input type="checkbox" class="myClass" name="pinterest_share" <?php if($cs_theme_option['pinterest_share']=="on") echo "checked" ?> />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Tumblr</label>
            </li>
            <li class="to-field social-share">
              <input type="hidden" name="tumblr_share" value="" />
              <input type="checkbox" class="myClass" name="tumblr_share" <?php if($cs_theme_option['tumblr_share']=="on") echo "checked" ?> />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Google+</label>
            </li>
            <li class="to-field social-share">
              <input type="hidden" name="google_plus_share" value="" />
              <input type="checkbox" class="myClass" name="google_plus_share" <?php if($cs_theme_option['google_plus_share']=="on") echo "checked" ?> />
            </li>
          </ul>
        </div>
        <div id="tab-default-pages" style="display:none;">
          <div class="theme-header">
            <h1>Default Pages</h1>
          </div>
          <div class="theme-help">
            <h4>Default Pages Settings</h4>
            <p>Manage Default Pages (Archive, Search, Categories, Tags and Author Pages)</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>Pagination</label>
            </li>
            <li class="to-field">
              <select name="pagination" class="dropdown" onchange="cs_toggle('record_per_page')">
                <option <?php if($cs_theme_option['pagination']=="Show Pagination")echo "selected";?> >Show Pagination</option>
                <option <?php if($cs_theme_option['pagination']=="Single Page")echo "selected";?> >Single Page</option>
              </select>
            </li>
          </ul>
          <?php
										global $cs_xmlObject;
										$cs_xmlObject = new stdClass();
										$cs_xmlObject->sidebar_layout = new stdClass();
										$cs_xmlObject->sidebar_layout->cs_layout = $cs_theme_option['cs_layout'];
										$cs_xmlObject->sidebar_layout->cs_sidebar_left = $cs_theme_option['cs_sidebar_left'];
										$cs_xmlObject->sidebar_layout->cs_sidebar_right = $cs_theme_option['cs_sidebar_right'];
										if ( $cs_theme_option['cs_layout'] == "none" ) {
											$cs_xmlObject->sidebar_layout->cs_sidebar_left = '';
											$cs_xmlObject->sidebar_layout->cs_sidebar_right = '';
										}
										else if ( $cs_theme_option['cs_layout'] == "left" ) {
											$cs_xmlObject->sidebar_layout->cs_sidebar_right = '';
										}
										else if ( $cs_theme_option['cs_layout'] == "right" ) {
											$cs_xmlObject->sidebar_layout->cs_sidebar_left = '';
										}
										meta_layout();
										?>
        </div>
        <div id="tab-upload-languages" style="display:none;">
          <div class="theme-header">
            <h1>Upload New Language</h1>
          </div>
          <div class="theme-help">
            <h4>Upload New Language</h4>
            <p>Upload New Language</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>Upload Language (MO File)</label>
            </li>
            <li class="to-field">
              <div class="fileinputs">
                <input type="file" class="file" size="78" name="mofile" id="mofile" />
                <div class="fakefile">
                  <input type="text" />
                  <button>Browse</button>
                </div>
              </div>
              <p>Please upload new language file (MO format only). It will be uploaded in your theme's languages folder. </p>
              <p>Download MO files from <a target="_blank" href="http://translate.wordpress.org/projects/wp/">http://translate.wordpress.org/projects/wp/</a> </p>
              <p>
                <button type="button" id="upload_btn">Upload Files!</button>
              </p>
            </li>
          </ul>
          <ul id="image-list">
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Already Uploaded Languages</label>
            </li>
            <li class="to-field"> <strong>
				<?php
				$cs_counter = 0;
				foreach (glob(get_template_directory()."/languages/*.mo") as $filename) {
					$cs_counter++;
					$val = str_replace(get_template_directory()."/languages/","",$filename);
					echo "<p>".$cs_counter . ". " . str_replace(".mo","",$val)."</p>";
				}
				?>
              </strong>
              <p>Please copy the language name, open config.php file, find WPLANG constant and set its value by replacing the language name. </p>
            </li>
          </ul>
        </div>
        <div id="tab-upload-languages" style="display:none;">
          <div class="theme-header">
            <h1>Manage Languages</h1>
          </div>
          <div class="theme-help">
            <h4>Upload Languages</h4>
            <p>Upload new language.</p>
          </div>
        </div>
		
				<div id="tab-prayer-translation" style="display:none;">
          <div class="theme-header">
            <h1>Prayers Translation</h1>
          </div>
          <div class="theme-help">
            <h4>Prayers Translation</h4>
            <p>Prayers Translation</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>You Already Prayed</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_already_prayed" value="<?php echo $cs_theme_option['trans_already_prayed']?>" />
            </li>
          </ul>
		  
		  <ul class="form-elements">
            <li class="to-label">
              <label>I Prayed for this</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_prayed_for_this" value="<?php echo $cs_theme_option['trans_prayed_for_this']?>" />
            </li>
          </ul>
		  
		  <ul class="form-elements">
            <li class="to-label">
              <label>Encourage</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_encourage" value="<?php echo $cs_theme_option['trans_encourage']?>" />
            </li>
          </ul>
		  
		  <ul class="form-elements">
            <li class="to-label">
              <label>Times Prayed</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_times_prayed" value="<?php echo $cs_theme_option['trans_times_prayed']?>" />
            </li>
          </ul>
		  
		  <ul class="form-elements">
            <li class="to-label">
              <label>You Prayed</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_you_prayed" value="<?php echo $cs_theme_option['trans_you_prayed']?>" />
            </li>
          </ul>
          
        </div>
				
        <div id="tab-event-translation" style="display:none;">
          <div class="theme-header">
            <h1>Events Translation</h1>
          </div>
          <div class="theme-help">
            <h4>Events Translation</h4>
            <p>Events Translation</p>
          </div>
                    
          <ul class="form-elements">
            <li class="to-label">
              <label>Event Location</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_event_location" value="<?php echo $cs_theme_option['trans_event_location']?>" />
            </li>
          </ul>
		  
		  <ul class="form-elements">
            <li class="to-label">
              <label>Organizer</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_event_organizer" value="<?php echo $cs_theme_option['trans_event_organizer']?>" />
            </li>
          </ul>
		  
		  <ul class="form-elements">
            <li class="to-label">
              <label>Event Countdown</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_event_countdown" value="<?php echo $cs_theme_option['trans_event_countdown']?>" />
            </li>
          </ul>
		  
		  <ul class="form-elements">
            <li class="to-label">
              <label>Event Date</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_event_date" value="<?php echo $cs_theme_option['trans_event_date']?>" />
            </li>
          </ul>
		  
		  <ul class="form-elements">
            <li class="to-label">
              <label>Days</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_event_days" value="<?php echo $cs_theme_option['trans_event_days']?>" />
            </li>
          </ul>
		  
		  <ul class="form-elements">
            <li class="to-label">
              <label>Hrs</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_event_hrs" value="<?php echo $cs_theme_option['trans_event_hrs']?>" />
            </li>
          </ul>
		  
		  <ul class="form-elements">
            <li class="to-label">
              <label>Min</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_event_min" value="<?php echo $cs_theme_option['trans_event_min']?>" />
            </li>
          </ul>
		  
		  <ul class="form-elements">
            <li class="to-label">
              <label>Sec</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_event_sec" value="<?php echo $cs_theme_option['trans_event_sec']?>" />
            </li>
          </ul>
          
        </div>
        <div id="tab-contact-translation" style="display:none;">
          <div class="theme-header">
            <h1>Contact Translation</h1>
          </div>
          <div class="theme-help">
            <h4>Contact Translation</h4>
            <p>Contact Translation</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>Form Title</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_form_title" value="<?php echo $cs_theme_option['trans_form_title']?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Subject</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_subject" value="<?php echo $cs_theme_option['trans_subject']?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Message</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_message" value="<?php echo $cs_theme_option['trans_message']?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Name (Error)</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_name_error" value="<?php echo $cs_theme_option['trans_name_error']?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Email (Error)</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_email_error" value="<?php echo $cs_theme_option['trans_email_error']?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Subject (Error)</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_subject_error" value="<?php echo $cs_theme_option['trans_subject_error']?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Message (Error)</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_message_error" value="<?php echo $cs_theme_option['trans_message_error']?>" />
            </li>
          </ul>
        </div>
        <div id="tab-other-translation" style="display:none;">
          <div class="theme-header">
            <h1>Other Translation</h1>
          </div>
          <div class="theme-help">
            <h4>Other Translation</h4>
            <p>Other Translation</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>404 Content</label>
            </li>
            <li class="to-field">
              <textarea name="trans_content_404"><?php echo $cs_theme_option['trans_content_404']?></textarea>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Share Now</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_share_this_post" value="<?php echo $cs_theme_option['trans_share_this_post']?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Follow Us on Twitter</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_follow_twitter" value="<?php echo $cs_theme_option['trans_follow_twitter']?>" />
            </li>
          </ul>
		  
		  <ul class="form-elements">
            <li class="to-label">
              <label>Follow Us</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_follow" value="<?php echo $cs_theme_option['trans_follow']?>" />
            </li>
          </ul>
          
          <ul class="form-elements">
            <li class="to-label">
              <label>Posted on</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_posted_on" value="<?php echo $cs_theme_option['trans_posted_on']?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Listed in</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_listed_in" value="<?php echo $cs_theme_option['trans_listed_in']?>" />
            </li>
          </ul>
          
          <ul class="form-elements">
            <li class="to-label">
              <label>Featured</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_featured" value="<?php echo $cs_theme_option['trans_featured']?>" />
            </li>
          </ul>
		  
		  <ul class="form-elements">
            <li class="to-label">
              <label>Filter by</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_filter_by" value="<?php echo $cs_theme_option['trans_filter_by']?>" />
            </li>
          </ul>
		  
		  <ul class="form-elements">
            <li class="to-label">
              <label>Read More</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_read_more" value="<?php echo $cs_theme_option['trans_read_more']?>" />
            </li>
          </ul>
		  
		  <ul class="form-elements">
            <li class="to-label">
              <label>View Project</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_view_project" value="<?php echo $cs_theme_option['trans_view_project']?>" />
            </li>
          </ul>
          
        </div>
        <!-- import export Start -->
        <div id="tab-import-export" style="display:none;">
          <div class="theme-header">
            <h1>Theme Options Backup and restore settings</h1>
          </div>
          <div class="theme-help">
            <h4>Theme Options Backup and restore settings</h4>
            <p>Theme Options backup, restore backup, restore default and import / export current settings</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>Restore Default Options</label>
            </li>
            <li class="to-field">
              <input type="button" value="Restore Default" onclick="cs_to_restore_default('<?php echo home_url()?>', '<?php echo get_template_directory_uri()?>')" />
              <p>You current theme options will be replaced with the default theme activation options .</p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Last Backup Taken on</label>
            </li>
            <li class="to-field">
            	<strong><span id="last_backup_taken">
					<?php 
						if ( get_option('cs_theme_option_backup_time') ) {
							echo get_option('cs_theme_option_backup_time');
						}
						else { echo "Not Taken Yet"; }
					?>
                </span></strong>
            </li>
            <li class="full">&nbsp;</li>
            <li class="to-label">
              <label>Take Backup</label>
            </li>
            <li class="to-field">
              <input type="button" value="Take Backup" onclick="cs_to_backup('<?php echo home_url()?>', '<?php echo get_template_directory_uri()?>')" />
              <p>Take the Backup of your current theme options, it will replace the old backup if you have already taken.</p>
            </li>
            <li class="full">&nbsp;</li>
            <li class="to-label">
              <label>Restore Backup</label>
            </li>
            <li class="to-field">
              <input type="button" value="Restore Backup" onclick="cs_to_backup_restore('<?php echo home_url()?>', '<?php echo get_template_directory_uri()?>')" />
              <p>Restore your last backup taken (It will be replaced on your curernt theme options).</p>
            </li>
          </ul>
        </div>
        <!-- import / export end -->
      </div>
      <div class="clear"></div>
      <!-- Right Column End --> 
    </div>
    <div class="footer">
      <input type="submit" id="submit_btn" name="submit_btn" class="botbtn" value="Save All Settings" />
      <input type="hidden" name="action" value="theme_option_save" />
    </div>
  </div>
  </div>
</form>
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/select.js"></script> 
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/functions.js"></script> 
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery.validate.metadata.js"></script> 
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery.validate.js"></script> 
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/ddaccordion.js"></script> 
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/prettyCheckable.js"></script> 
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery.timepicker.js"></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/admin/jquery.ui.datepicker.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/admin/jquery.ui.datepicker.theme.css">
<script type="text/javascript">
        jQuery(document).ready(function($){
            $('.bg_color').wpColorPicker(); 
        });
    </script> 
<script type="text/javascript">
		jQuery(function($) {
			$( "#launch_date" ).datepicker({
            	defaultDate: "+1w",
				dateFormat: "yy-mm-dd",
                changeMonth: true,
                numberOfMonths: 1,
                onSelect: function( selectedDate ) {
                	$( "#launch_date" ).datepicker( "option", "minDate", selectedDate );
                }
            });
		});
		  function toggleDiv(id)
  {
   jQuery('.col2').children().hide();
   jQuery(id).show();
            location.hash = id+"-show";
            var link = id.replace('#', '');
            jQuery('.categoryitems li').removeClass('active');
            jQuery(".menuheader.expandable") .removeClass('openheader');
            jQuery(".categoryitems").hide();
            jQuery("."+link).addClass('active');
            jQuery("."+link) .parent("ul").show().prev().addClass("openheader");
      
  }
        jQuery(document).ready(function() {
                jQuery(".categoryitems").hide();
                jQuery(".categoryitems:first").show();
                jQuery(".menuheader:first").addClass("openheader");
                jQuery(".menuheader").live('click', function(event) {
                    if (jQuery(this).hasClass('openheader')){
                        jQuery(".menuheader").removeClass("openheader");
                        jQuery(this).next().slideUp(200);
                        return false;
                    }
                    jQuery(".menuheader").removeClass("openheader");
                    jQuery(this).addClass("openheader");
                    jQuery(".categoryitems").slideUp(200);
                    jQuery(this).next().slideDown(200); 
                    return false;
             });
            var hash = window.location.hash.substring(1);
            var id = hash.split("-show")[0];
            if (id){
                jQuery('.col2').children().hide();
                jQuery("#"+id).show();
                jQuery('.categoryitems li').removeClass('active');
                jQuery(".menuheader.expandable") .removeClass('openheader');
                jQuery(".categoryitems").hide();
                jQuery("."+id).addClass('active');
                jQuery("."+id) .parent("ul").slideDown(300).prev().addClass("openheader");

           } 
        });

        var counter_sidebar = 0;
        function add_sidebar(){
            counter_sidebar++;
            var sidebar_input = jQuery("#sidebar_input").val();
            if ( sidebar_input != "" ) {
                jQuery("#sidebar_area").append('<tr id="'+counter_sidebar+'"> \
                            <td><input type="hidden" name="sidebar[]" value="'+sidebar_input+'" />'+sidebar_input+'</td> \
                            <td class="centr"> <a onclick="javascript:return confirm(\'Are you sure! You want to delete this\')" href="javascript:cs_div_remove('+counter_sidebar+')">Del</a> </td> \
                        </tr>');
                jQuery("#sidebar_input").val("");
            }
        }
		jQuery().ready(function($) {
			var container = $('div.container');
			// validate the form when it is submitted
			var validator = $("#frm").validate({
				errorContainer: container,
				errorLabelContainer: $(container),
				errorElement:'span',
				errorClass:'ele-error',				
				meta: "validate"
			});
		});
        jQuery(document).ready( function($) {
            var consoleTimeout;
            $('.minicolors').each( function() {
                $(this).minicolors({
                    change: function(hex, opacity) {
                        // Generate text to show in console
                        text = hex ? hex : 'transparent';
                        if( opacity ) text += ', ' + opacity;
                        text += ' / ' + $(this).minicolors('rgbaString');
                    }
                });
            });
        });
		(function () {
			var input = document.getElementById("mofile")
			var upload_btn = document.getElementById("upload_btn"), 
			formdata = false;
			if (window.FormData) {
				formdata = new FormData();
			}
			upload_btn.addEventListener("click", function (evt) {
				var i = 0, len = input.files.length, txt, reader, file;
			
				for ( ; i < len; i++ ) {
					file = input.files[i];
						if (formdata) {
							formdata.append("mofile[]", file);
						}
				}
				if (formdata) {
					jQuery.ajax({
						url: '<?php echo get_template_directory_uri()?>/include/lang_upload.php',
						type: "POST",
						data: formdata,
						processData: false,
						contentType: false,
						success: function (res) {
							jQuery("#mofile").val("");
		                    jQuery(".form-msg").show();
							jQuery(".form-msg").html(res);
						}
					});
				}
			}, false);
		}());
    </script>
<?php }?>
