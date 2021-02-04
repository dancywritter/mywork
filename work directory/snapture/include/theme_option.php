<?php
function theme_option() {
	global $post, $header1_default_settings;
	$cs_theme_option = get_option('cs_theme_option');
	                         	
                                          
?>
<link href="<?php echo get_template_directory_uri()?>/css/admin/datePicker.css" rel="stylesheet" type="text/css" />
<form id="frm" method="post" action="javascript:cs_theme_option_save('<?php echo home_url()?>', '<?php echo get_template_directory_uri()?>');">
  <div class="theme-wrap fullwidth">
    <div class="loading_div"></div>
    <div class="form-msg"></div>
    <div class="inner">
      <div class="row"> 
        <!-- Left Column Start -->
        <div class="col1">
          <div class="logo"><a href="#"><img src="<?php echo get_template_directory_uri()?>/images/admin/logo.png" /></a></div>
          <div class="arrowlistmenu" id="paginate-slider2">
            <h3 class="menuheader expandable"><a href="#"><span class="nav-icon g-setting">&nbsp;</span>General Settings</a></h3>
            <ul class="categoryitems">
              <li class="tab-color active"><a href="#tab-color" onClick="toggleDiv(this.hash);return false;">Logo and Style</a></li>
               <li class="tab-foot-setting"><a href="#tab-foot-setting" onClick="toggleDiv(this.hash);return false;">Footer Settings</a></li>
              <li class="tab-under-consturction"><a href="#tab-under-consturction" onClick="toggleDiv(this.hash);return false;">Under Constrution</a></li>
              <li class="tab-other"><a href="#tab-other" onClick="toggleDiv(this.hash);return false;">Other Settings</a></li>
            </ul>
           
            <ul class="categoryitems">
              <li class="tab-font-settings"><a href="#tab-font-settings" onClick="toggleDiv(this.hash);return false;">Fonts Settings</a></li>
            </ul>
            <h3 class="menuheader expandable"><a href="#"><span class="nav-icon h-setting">&nbsp;</span>Header Settings</a></h3>
            <ul class="categoryitems">
              <li class="tab-head-styles"><a href="#tab-head-styles" onClick="toggleDiv(this.hash);return false;">Header Styles</a></li>
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

              <li class="tab-contact-translation"><a href="#tab-contact-translation" onClick="toggleDiv(this.hash);return false;">Contact</a></li>
              <li class="tab-other-translation"><a href="#tab-other-translation" onClick="toggleDiv(this.hash);return false;">Others</a></li>
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
              <h4>Logo And Styles</h4>
              <p>Theme color scheme and styling setting.</p>
            </div>
            <ul class="form-elements">
              <li class="to-label">
                <label>Custom Color Scheme</label>
              </li>
              <li class="to-field">
                <input type="text" name="custom_color_scheme" id="cs_custom_color_style" value="<?php echo $cs_theme_option['custom_color_scheme']?>" class="bg_color" />
                <p>Pick a custom color for Scheme of the theme e.g. #697e09</p>
              </li>
            </ul>
            
            <ul class="form-elements">
              <li class="to-label">
                <label>Select Color Scheme</label>
              </li>
              <li class="to-field">
                    <div id="colorpickerwrapp">
                    <?php $cs_color_array= array('#45b363','#339a74', '#1d7f5b', '#3fb0c3', '#2293a6', '#137d8f', '#9374ae', '#775b8f', '#dca13a', '#c46d32', '#c44732',
					 '#c44d55', '#425660', '#292f32'
					);
					foreach($cs_color_array as $colors){
						$active = '';
						if($colors == $cs_theme_option['custom_color_scheme']){$active = 'active';}
						echo '<span class="col-box '.$active.'" data-color="'.$colors.'" style="background: '.$colors.'"></span>';
					}
					?>

                   </div>
				   <script type="text/javascript">
                      jQuery(document).ready(function($) {
                        jQuery("#colorpickerwrapp span.col-box") .live("click",function(event) {
                          	var a = jQuery(this).data('color');
                          	jQuery("#cs_custom_color_style").val(a);
							jQuery("#nav_bg_color_scheme").val(a);
							jQuery('.wp-color-result').css('background-color', a);
                           	jQuery("#colorpickerwrapp span.col-box") .removeClass('active');
                           	jQuery(this).addClass("active");
                        });
                      });
                   </script>
              </li>
            </ul>
            
            <ul class="form-elements">
              <li class="to-label">
                <label>Navigation Background Color</label>
              </li>
              <li class="to-field">
                <input type="text" name="nav_bg_color_scheme" id="nav_bg_color_scheme" value="<?php echo $cs_theme_option['nav_bg_color_scheme']?>" class="bg_color" />
                <p>Pick a custom color for Navigation Background Color e.g. #697e09</p>
              </li>
            </ul>
            
            <ul class="form-elements">
              <li class="to-label">
                <label>Upload Logo</label>
              </li>
              <li class="to-field">
                <input class="logo" name="logo" value="<?php echo $cs_theme_option['logo']?>" type="text" class="small {validate:{accept:'jpg|jpeg|gif|png|bmp'}}" />
                <input id="log" name="logo" type="button" class="uploadfile left" value="Browse"/>
                <?php if ( $cs_theme_option['logo'] <> "" ) { ?>
                <div class="thumb-preview" id="logo_img_div"> <img width="<?php echo $cs_theme_option['logo_width']?>" height="<?php echo $cs_theme_option['logo_height']?>" src="<?php echo $cs_theme_option['logo']?>" /> <a href="javascript:remove_image('logo')" class="del">&nbsp;</a> </div>
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
              <li class="to-label">
                <label>Upload Small Logo</label>
              </li>
              <li class="to-field">
                <input id="small_logo" name="small_logo" value="<?php echo $cs_theme_option['small_logo']?>" type="text" class="small {validate:{accept:'jpg|jpeg|gif|png|bmp'}}" />
                <input id="small_log" name="small_logo" type="button" class="uploadfile left" value="Browse"/>
                <?php if ( $cs_theme_option['logo'] <> "" ) { ?>
                <div class="thumb-preview" id="small_logo_img_div"> <img width="<?php echo $cs_theme_option['small_logo_width']?>" height="<?php echo $cs_theme_option['small_logo_height']?>" src="<?php echo $cs_theme_option['small_logo']?>" /> <a href="javascript:remove_image('small_logo')" class="del">&nbsp;</a> </div>
                <?php } ?>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Small Logo Width</label>
              </li>
              <li class="to-field">
                <input type="text" name="small_logo_width" id="width-value" value="<?php echo $cs_theme_option['small_logo_width']?>" class="vsmall" />
                <span class="short">px</span>
                <p>Please enter the required size.</p>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Small Logo Height</label>
              </li>
              <li class="to-field">
                <input type="text" name="small_logo_height" id="height-value" value="<?php echo $cs_theme_option['small_logo_height']?>" class="vsmall" />
                <span class="short">px</span>
                <p>Please enter the required size.</p>
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
            <ul class="form-elements">
                <li class="to-label">
                  <label>Copyright Text</label>
                </li>
                <li class="to-field">
                  <textarea rows="2" cols="4" name="copyright"><?php echo $cs_theme_option['copyright']?></textarea>
                  <p>Write Custom Copyright text.</p>
                </li>
              </ul>
              
           </div>
          <!-- Color And Style End --> 
          <!-- Logo Tabs -->
          

          <!-- Logo Tabs End --> 
          <!-- Menu Styles -->
          
         
        <!-- Header Styles end--> 
        
        
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
              <label> HTML, CSS or JS Code </label>
            </li>
            <li class="to-field">
              <textarea rows="" cols="" name="analytics"><?php echo $cs_theme_option['analytics']?></textarea>
              <p>Put any HTML, CSS or JS Code like Google Analytics tracking code here..<br />
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
                <label>Under Construction Logo</label>
              </li>
              <li class="to-field">
                <input id="uc_logo" name="uc_logo" value="<?php echo $cs_theme_option['uc_logo']?>" type="text" class="small {validate:{accept:'jpg|jpeg|gif|png|bmp'}}" />
                <input id="uc_logo" name="uc_logo" type="button" class="uploadfile left" value="Browse"/>
                <?php if ( $cs_theme_option['uc_logo'] <> "" ) { ?>
                <div class="thumb-preview" id="uc_logo_img_div"> <img width="<?php echo $cs_theme_option['uc_logo_width']?>" height="<?php echo $cs_theme_option['uc_logo_height']?>" src="<?php echo $cs_theme_option['uc_logo']?>" /> <a href="javascript:remove_image('uc_logo')" class="del">&nbsp;</a> </div>
                <?php } ?>
              </li>
            </ul>
          <ul class="form-elements">
              <li class="to-label">
                <label>Width</label>
              </li>
              <li class="to-field">
                <input type="text" name="uc_logo_width" id="width-value" value="<?php echo $cs_theme_option['uc_logo_width']?>" class="vsmall" />
                <span class="short">px</span>
                <p>Please enter the required size.</p>
              </li>
            </ul>
          <ul class="form-elements">
              <li class="to-label">
                <label>Height</label>
              </li>
              <li class="to-field">
                <input type="text" name="uc_logo_height" id="height-value" value="<?php echo $cs_theme_option['uc_logo_height']?>" class="vsmall" />
                <span class="short">px</span>
                <p>Please enter the required size.</p>
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
              <p> Put event start date</p>
            </li>
          </ul>
          <!--<ul class="form-elements">
            <li class="to-label">
              <label>Social Network</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="socialnetwork" value="" />
              <input type="checkbox" class="myClass" name="socialnetwork" <?php //if($cs_theme_option['socialnetwork']=="on") echo "checked" ?> />
              <p>Set social network On/Off</p>
            </li>
          </ul>-->
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
          
            <?php 
			   $wpmlsettings=get_option('icl_sitepress_settings');
 
 			   if ( function_exists('icl_object_id') ) {
   			   ?>
              <ul class="form-elements">
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Header Languages</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="header_languages" value="" />
                  <input type="checkbox" class="myClass" name="header_languages" <?php if ($cs_theme_option['header_languages'] == "on") echo "checked" ?> />
                </li>
              </ul>
		  <?php } ?>
        </div>
        <!-- Other Settings End --> 

        
        
          
          <div id="tab-head-styles" style="display:none;">
            <div class="theme-header">
              <h1>Header Styles</h1>
            </div>
            <div class="theme-help">
              <h4>Logo & Header Settings</h4>
            </div>
            <ul class="form-elements">
              <li class="to-label">
                <label>Default Header</label>
              </li>
              <li class="to-field">
                <select class="dropdown" name="default_header">
                  <option <?php if($cs_theme_option['default_header']=="header1"){echo "selected";}?> value="header1" >Header 1</option>
                  <option <?php if($cs_theme_option['default_header']=="header2"){echo "selected";}?> value="header2" >Header 2</option>
                </select>
                        
              </li>
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
                  <label>Sticky</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="header_1_sticky" value=""  data-default-header="<?php echo $cs_theme_option['header_1_sticky']; ?>"/>
                  <input type="checkbox" class="myClass" name="header_1_sticky" <?php if ($cs_theme_option['header_1_sticky'] == "on") echo "checked" ?>  data-default-header="<?php echo $cs_theme_option['header_1_sticky']; ?>"/>
                </li>
              	<li class="full">&nbsp;</li>
                
                <li class="to-label">
                  <label>Sub Header</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="header_1_sub_header" value=""  data-default-header="<?php echo $cs_theme_option['header_1_sub_header']; ?>"/>
                  <input type="checkbox" class="myClass" name="header_1_sub_header" <?php if ($cs_theme_option['header_1_sub_header'] == "on") echo "checked" ?>  data-default-header="<?php echo $cs_theme_option['header_1_sub_header']; ?>"/>
                </li>
              	<li class="full">&nbsp;</li>
                
                <li class="to-label">
                  <label>Social Icon</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="header_1_social_icon" value=""  data-default-header="<?php echo $cs_theme_option['header_1_social_icon']; ?>"/>
                  <input type="checkbox" class="myClass" name="header_1_social_icon" <?php if ($cs_theme_option['header_1_social_icon'] == "on") echo "checked" ?>  data-default-header="<?php echo $cs_theme_option['header_1_social_icon']; ?>"/>
                </li>
              	<li class="full">&nbsp;</li>
                
                <li class="to-label">
                  <label>Small Logo</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="header_1_small_logo" value=""  data-default-header="<?php echo $cs_theme_option['header_1_small_logo']; ?>"/>
                  <input type="checkbox" class="myClass" name="header_1_small_logo" <?php if ($cs_theme_option['header_1_small_logo'] == "on") echo "checked" ?>  data-default-header="<?php echo $cs_theme_option['header_1_small_logo']; ?>"/>
                </li>
              	<li class="full">&nbsp;</li>
                <?php if ( function_exists( 'is_woocommerce' ) ){ ?> 
                <li class="to-label">
                  <label>Cart</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="header_1_cart" value=""  data-default-header="<?php echo $cs_theme_option['header_1_cart']; ?>"/>
                  <input type="checkbox" class="myClass" name="header_1_cart" <?php if ($cs_theme_option['header_1_cart'] == "on") echo "checked" ?>  data-default-header="<?php echo $cs_theme_option['header_1_cart']; ?>"/>
                </li>
              	<li class="full">&nbsp;</li>
                <?php } ?>
                
                
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
                
                <li class="to-label">
                  <label>Small Logo</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="header_2_small_logo" value=""  data-default-header="<?php echo $cs_theme_option['header_2_small_logo']; ?>"/>
                  <input type="checkbox" class="myClass" name="header_2_small_logo" <?php if ($cs_theme_option['header_2_small_logo'] == "on") echo "checked" ?>  data-default-header="<?php echo $cs_theme_option['header_2_small_logo']; ?>"/>
                </li>
              	<li class="full">&nbsp;</li>
                
                  <li class="to-label"><label>Select Menu</label></li>
                  <li class="to-field">
                  
                     <?php
                     $menus = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
                     ?>
                     <select name="header_2_strip_menu" data-default-header="<?php echo $cs_theme_option['header_2_strip_menu']; ?>" >
                        <option value="">Select Menu</option>
                        <?php
                        foreach ($menus as $menu) {
                           ?>
                           <option value="<?php echo $menu->slug; ?>" <?php if ($cs_theme_option['header_2_strip_menu'] == $menu->slug) echo "selected='selected'" ?>><?php echo $menu->name; ?></option>
                        <?php } ?>
                     </select>
                  </li>
                <li class="full">&nbsp;</li>
                <?php if ( function_exists( 'is_woocommerce' ) ){ ?> 
                <li class="to-label">
                  <label>Cart</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="header_2_cart" value=""  data-default-header="<?php echo $cs_theme_option['header_2_cart']; ?>"/>
                  <input type="checkbox" class="myClass" name="header_2_cart" <?php if ($cs_theme_option['header_2_cart'] == "on") echo "checked" ?>  data-default-header="<?php echo $cs_theme_option['header_2_cart']; ?>"/>
                </li>
              	<li class="full">&nbsp;</li>
                <?php } ?>
                
              </ul>
            </div>
              
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
														$counter_sidebar = rand(10000,20000);
														foreach ( $cs_theme_option['sidebar'] as $sidebar ){
															$counter_sidebar++;
															echo '<tr id="'.$counter_sidebar.'">';
																echo '<td><input type="hidden" name="sidebar[]" value="'.$sidebar.'" />'.$sidebar.'</td>';
																echo '<td class="centr"> <a onclick="javascript:return confirm(\'Are you sure! You want to delete this\')" href="javascript:cs_div_remove('.$counter_sidebar.')">Del</a> </td>';
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
          <ul class="form-elements">
            <li class="to-label">
              <label>Section Title</label>
            </li>
            <li class="to-field">
              <input type="text" name="social_net_title" value="<?php echo $cs_theme_option['social_net_title']?>" />
            </li>
          </ul>
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
              <p>Put Awesome Font Code like "fa-flag".</p>
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
						$counter_social_network = rand(10000,20000);
						$i = 0;
						foreach ( $cs_theme_option['social_net_url'] as $val ){
							$counter_social_network++;
							echo '<tr id="del_'.$counter_social_network.'">';
								if(isset($cs_theme_option['social_net_awesome'][$i]) && $cs_theme_option['social_net_awesome'][$i] <> ''){
									echo '<td><i style="color: green;" class="fa '.$cs_theme_option['social_net_awesome'][$i].'"></td>';
								} else {
									echo '<td><img width="50" src="'.$cs_theme_option['social_net_icon_path'][$i].'"></td>';
								}
								echo '<td>'.$val.'</td>';
								echo '<td class="centr"> 
											<a onclick="javascript:return confirm(\'Are you sure! You want to delete this\')" href="javascript:social_icon_del('.$counter_social_network.')">Del</a>
											| <a href="javascript:cs_toggle('.$counter_social_network.')">Edit</a>
										</td>';
							echo '</tr>';
							?>
                            	<tr id="<?php echo $counter_social_network;?>" style="display:none">
                                <td colspan="3">
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Icon Path</label></li>
                                        <li class="to-field">
                                          <input id="social_net_icon_path<?php echo $counter_social_network?>" name="social_net_icon_path[]" value="<?php echo $cs_theme_option['social_net_icon_path'][$i]?>" type="text" class="small" />
                                        </li>
                                        <li><a onclick="cs_toggle('<?php echo $counter_social_network?>')"><img src="<?php echo get_template_directory_uri()?>/images/admin/close-red.png" /></a></li>
                                        <li class="full">&nbsp;</li>
                                        <li class="to-label"><label>Awesome Font</label></li>	
                                        <li class="to-field">
                                          <input class="small" type="text" id="social_net_awesome" name="social_net_awesome[]" value="<?php echo $cs_theme_option['social_net_awesome'][$i]?>" style="width:420px;" />
                                          <p>Put Awesome Font Code like "fa-flag".</p>
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
					$counter = 0;
					foreach (glob(get_template_directory()."/languages/*.mo") as $filename) {
						$counter++;
						$val = str_replace(get_template_directory()."/languages/","",$filename);
						echo "<p>".$counter . ". " . str_replace(".mo","",$val)."</p>";
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
              <label>Sticky Post</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_featured" value="<?php echo $cs_theme_option['trans_featured']?>" />
            </li>
          </ul>
          
          <ul class="form-elements">
            <li class="to-label">
              <label>Back to Menu</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_back_to_menu" value="<?php echo $cs_theme_option['trans_back_to_menu']?>" />
            </li>
          </ul>
          
          <ul class="form-elements">
            <li class="to-label">
              <label>Facebook</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_facebook" value="<?php echo $cs_theme_option['trans_facebook']?>" />
            </li>
          </ul>
		  
          <ul class="form-elements">
            <li class="to-label">
              <label>Twitter</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_twitter" value="<?php echo $cs_theme_option['trans_twitter']?>" />
            </li>
          </ul>
          
          <ul class="form-elements">
            <li class="to-label">
              <label>Photos</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_photos" value="<?php echo $cs_theme_option['trans_photos']?>" />
            </li>
          </ul>
          
		   <ul class="form-elements">
            <li class="to-label">
              <label>Load More</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_load_more" value="<?php echo $cs_theme_option['trans_load_more']?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Sign In</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_sign_in" value="<?php echo $cs_theme_option['trans_sign_in']?>" />
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
      <input type="hidden" name="action" value="cs_theme_option_save" />
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
