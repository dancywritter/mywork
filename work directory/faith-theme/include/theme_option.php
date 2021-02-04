<?php
function theme_option() {
	global $post;
 	$cs_theme_option ='';
	$cs_theme_option = get_option('cs_theme_option');
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
          <div class="logo"><a href="#"><img src="<?php echo get_template_directory_uri()?>/images/admin/logo.png" /></a></div>
          <div class="arrowlistmenu" id="paginate-slider2">
            <h3 class="menuheader expandable"><a href="#"><span class="nav-icon g-setting">&nbsp;</span>General Settings</a></h3>
            <ul class="categoryitems">
              <li class="tab-color active"><a href="#tab-color" onClick="toggleDiv(this.hash);return false;">Color and Style</a></li>
              <li class="tab-logo"><a href="#tab-logo" onClick="toggleDiv(this.hash);return false;">Logo / Fav Icon</a></li>
              <li class="tab-head-scripts"><a href="#tab-head-scripts" onClick="toggleDiv(this.hash);return false;">Header Settings</a></li>
              <li class="tab-foot-setting"><a href="#tab-foot-setting" onClick="toggleDiv(this.hash);return false;">Footer Settings</a></li>
              <li class="tab-under-consturction"><a href="#tab-under-consturction" onClick="toggleDiv(this.hash);return false;">Under Constrution</a></li>
              <li class="tab-other"><a href="#tab-other" onClick="toggleDiv(this.hash);return false;">Other Settings</a></li>
              <li class="tab-mailchimp-key"><a href="#tab-mailchimp-key" onClick="toggleDiv(this.hash);return false;">MailChimp Settings</a></li>
              <li class="tab-api-key"><a href="#tab-paypalapi-key" onClick="toggleDiv(this.hash);return false;">Paypal API Settings</a></li>
              <li class="tab-api-key"><a href="#tab-api-key" onClick="toggleDiv(this.hash);return false;">API Settings</a></li>
              
            </ul>
            <h3 class="menuheader expandable"><a href="#"><span class="nav-icon h-setting">&nbsp;</span>Home Page Settings</a></h3>
            <ul class="categoryitems">
              <li class="tab-slider"><a href="#tab-slider" onClick="toggleDiv(this.hash);return false;">Slider</a></li>
              <li class="tab-Announcement"><a href="#tab-Announcement" onClick="toggleDiv(this.hash);return false;">Announcement</a></li>
              <li class="tab-services"><a href="#tab-services" onClick="toggleDiv(this.hash);return false;">Services</a></li>
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
              <li class="tab-event-translation"><a href="#tab-event-translation" onClick="toggleDiv(this.hash);return false;">Events</a></li>
              <li class="tab-sermon-translation"><a href="#tab-sermon-translation" onClick="toggleDiv(this.hash);return false;">Sermons</a></li>
              <li class="tab-prayer-translation"><a href="#tab-prayer-translation" onClick="toggleDiv(this.hash);return false;">Prayers</a></li>
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
        <input type="button" value="Reset Option" class="top_btn_reset" onclick="cs_to_restore_default('<?php echo home_url()?>', '<?php echo get_template_directory_uri()?>')" />
          <input type="submit" id="submit_btn" name="submit_btn" class="top_btn_save" value="Save All Settings" />
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
				   
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Custom Color Scheme</label>
              </li>
              <li class="to-field">
                <input type="text" id="cs_custom_color_style" name="custom_color_scheme" value="<?php if(isset($cs_theme_option['custom_color_scheme'])){ echo $cs_theme_option['custom_color_scheme']; }?>" class="bg_color"  />
                <p>Pick a custom color for Scheme of the theme e.g. #697e09</p>
              </li>
            </ul>
             <!--<ul class="form-elements">
              <li class="to-label">
                <label>Layout Option</label>
              </li>
              <li class="to-field">
                <input type="radio" name="layout_option" value="wrapper_boxed" <?php //if($cs_theme_option['layout_option']=="wrapper_boxed")echo "checked"?> class="styled" />
                <label>Boxed</label>
                <input type="radio" name="layout_option" value="wrapper" <?php //if($cs_theme_option['layout_option']=="wrapper")echo "checked"?> class="styled" />
                <label>Wide</label>
              </li>
            </ul>-->
            <div class="opt-head">
              <h4>Layout Options</h4>
              <div class="clear"></div>
            </div>
            <ul class="form-elements">
              <li class="to-label">
                <label>Background Image</label>
              </li>
              <li class="to-field">
                <div class="meta-input pattern">
                  <?php
					for ( $i = 0; $i < 11; $i++ ) {
					?>
                  <div class='radio-image-wrapper'>
                    <input <?php if($cs_theme_option['bg_img']==$i)echo "checked"?> onclick="select_bg()" type="radio" name="bg_img" class="radio" value="<?php echo $i?>" />
                    <label for="radio_<?php echo $i?>"> <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/background/background<?php echo $i?>.png" /></span> <span <?php if($cs_theme_option['bg_img']==$i)echo "class='check-list'"?> id="check-list">&nbsp;</span> </label>
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
                <div class="thumb-preview" id="bg_img_custom_img_div"> <img src="<?php echo $cs_theme_option['bg_img_custom']?>" /> <a href="javascript:remove_image('bg_img_custom')" class="del">&nbsp;</a> </div>
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
					for ( $i = 0; $i < 16; $i++ ) {
					?>
                  <div class='radio-image-wrapper'>
                    <input <?php if($cs_theme_option['pattern_img']==$i)echo "checked"?> onclick="select_pattern()" type="radio" name="pattern_img" class="radio" value="<?php echo $i?>" />
                    <label for="radio_<?php echo $i?>"> <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/pattern/pattern<?php echo $i?>.png" /></span> <span <?php if($cs_theme_option['pattern_img']==$i)echo "class='check-list'"?> id="check-list">&nbsp;</span> </label>
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
                <div class="thumb-preview" id="custome_pattern_img_div"> <img src="<?php echo $cs_theme_option['custome_pattern'];?>" /> <a href="javascript:remove_image('custome_pattern')" class="del">&nbsp;</a> </div>
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
          
          <!-- Header Styles --> 
          
          <!-- Header Script -->
          <div id="tab-head-scripts" style="display:none;">
            <div class="theme-header">
              <h1>Header Settings</h1>
            </div>
            <div class="theme-help">
              <h4>Header Settings</h4>
              <p>Modify your header settings</p>
            </div>
            <div class="header-section" id="header_banner1">
             <ul class="form-elements">
              <li class="full">&nbsp;</li>
              <li class="to-label">
                  <label>Logo</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="header_logo" value=""  />
                  <input type="checkbox" class="myClass" name="header_logo" <?php if ($cs_theme_option['header_logo'] == "on") echo "checked" ?> />
                </li>
              </ul>
             <ul class="form-elements">
             	<li class="full">&nbsp;</li>
                <li class="to-label">
                	<label>Slogan</label>
             	</li>
                <li class="to-field">
                  <input type="hidden" name="header_slogan" value="" >
                  <input type="checkbox" class="myClass" name="header_slogan" <?php if (isset($cs_theme_option['header_slogan']) and $cs_theme_option['header_slogan'] == "on") echo "checked" ?> />
                </li>
             </ul>
             <ul class="form-elements">
              <li class="full">&nbsp;</li>
              <li class="to-label">
                  <label>Search</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="header_search" value=""  />
                  <input type="checkbox" class="myClass" name="header_search" <?php if ($cs_theme_option['header_search'] == "on") echo "checked" ?> />
                </li>
              </ul>
             <ul class="form-elements">
               <li class="to-label">
                <label>Sticky Menu</label>
               </li>
               <li class="to-field">
                <input type="hidden" name="header_sticky_menu" value="" />
                <input type="checkbox" class="myClass" name="header_sticky_menu" <?php if ($cs_theme_option['header_sticky_menu'] == "on") echo "checked" ?> />
               </li>
              </ul>
              <?php 
			   $wpmlsettings=get_option('icl_sitepress_settings');
 
 				if ( function_exists('icl_object_id') ) {
					if(!isset($cs_theme_option['header_languages'])){$cs_theme_option['header_languages'] = 'on';}
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
              <?php if ( function_exists( 'is_woocommerce' ) ){
						if(!isset($cs_theme_option['header_cart'])){$cs_theme_option['header_cart'] = 'on';}
				 ?> 
                <ul class="form-elements">
                    <li class="full">&nbsp;</li>
                    <li class="to-label">
                       <label>Cart Count</label>
                    </li>
                    <li class="to-field">
                      <input type="hidden" name="header_cart" value=""/>
                      <input type="checkbox" class="myClass" name="header_cart" <?php if ($cs_theme_option['header_cart'] == "on") echo "checked" ?>/>
                    </li>
                  </ul>
            <?php } ?>
            	<ul class="form-elements">
                    <li class="full">&nbsp;</li>
                    <li class="to-label">
                      <label>Social Icons</label>
                    </li>
                    <li class="to-field">
                      <input type="hidden" name="header_social_icons" value=""/>
                      <input type="checkbox" class="myClass" name="header_social_icons" <?php if (isset($cs_theme_option['header_social_icons']) and $cs_theme_option['header_social_icons'] == "on") echo "checked" ?>/>
                    </li>
              </ul>  
                
              <ul class="form-elements">
                    <li class="full">&nbsp;</li>
                    <li class="to-label">
                      <label>Donations</label>
                    </li>
                    <li class="to-field">
                      <input type="hidden" name="header_donation_btn" value=""/>
                      <input type="checkbox" class="myClass" name="header_donation_btn" <?php if (isset($cs_theme_option['header_donation_btn']) and $cs_theme_option['header_donation_btn'] == "on") echo "checked" ?>/>
                      <p>set donation button on/off</p>
                    </li>
              </ul> 
              <ul class="form-elements">
              <li class="to-label">
                <label>Choose BreadCrumbsType</label>
              </li>
              <li class="to-field">
                <select name="beadcrumbs_type" class="dropdown" onchange="javascript:home_breadcrumb_toggle(this.value)">
                  <option <?php if($cs_theme_option['beadcrumbs_type']=="breadcrumbs"){echo "selected";}?> value="breadcrumbs" >BreadCrumbs</option>
                  <option <?php if($cs_theme_option['beadcrumbs_type']=="custome_style"){echo "selected";}?> value="custome_style" >Custom Style</option>
                </select>
              </li>
            </ul>
            <ul class="form-elements" id="cs_breadcrumbs" style=" <?php if($cs_theme_option['beadcrumbs_type']<>"breadcrumbs")echo "display:none"; else "display:inline"; ?>">
             <li class="to-label">
                <label>Show BreadCrumbs</label>
              </li>
              <li class="to-field">
                <input type="hidden" name="show_beadcrumbs" value="" />
                <input type="checkbox" class="myClass" name="show_beadcrumbs" <?php if($cs_theme_option['show_beadcrumbs']=="on") echo "checked" ?> />
                <p>Switch it on if you want to show BreadCrumbs. If you switch it off it will not show beadcrumbs</p>
              </li>
            </ul>
            <ul class="form-elements" id="cs_custome_style" style=" <?php if($cs_theme_option['beadcrumbs_type'] =="" or $cs_theme_option['beadcrumbs_type'] <> "custome_style")echo "display:none"; else "display:inline"; ?>" >
              <li class="to-label">
                <label>Breadcrumb Text</label>
              </li>
              <li class="to-field">
              	<textarea name="breadcrumb_text" cols="20" rows="8"><?php echo $cs_theme_option['breadcrumb_text'];?></textarea>
                <p>If you want to show custom text instead of breadcurmbs. Use Button shortcode like this <br /> [button color='#fff' background='#ff0000' src='LINK_URL' target='_blank']Button 1[/button]</p>
              </li>
            </ul>  
              <ul class="form-elements">
                    <li class="full">&nbsp;</li>
                    <li class="to-label">
                      <label>Header Widget</label>
                    </li>
                    <li class="to-field">
                      <input type="hidden" name="header_widget_btn" value=""/>
                      <input type="checkbox" class="myClass" name="header_widget_btn" <?php if (isset($cs_theme_option['header_widget_btn']) and $cs_theme_option['header_widget_btn'] == "on") echo "checked" ?>/>
                      <p>set header widget button on/off</p>
                    </li>
               </ul>
              <ul class="form-elements">
            <li class="to-label">
              <label>Header Widget Title</label>
            </li>
            <li class="to-field">
              <input type="text" id="header_widget_title" name="header_widget_title" value="<?php if(isset($cs_theme_option['header_widget_title'])) echo $cs_theme_option['header_widget_title']; ?>" />
              <p> Put Header Widget Title</p>
            </li>
          </ul>
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
                  <div class="thumb-preview" id="footer_logo_img_div"> 
                  	<img  src="<?php echo $cs_theme_option['footer_logo'] ?>" height="150"/> 
                  	<a href="javascript:remove_image('footer_logo')" class="del">&nbsp;</a> 
                  </div>
                  <?php } ?>
                </li>
              </ul>
              <ul class="form-elements">
            <li class="to-label">
              <label>Footer Tweets</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="footer_tweet_area" value="" />
              <input type="checkbox" class="myClass" name="footer_tweet_area" <?php if($cs_theme_option['footer_tweet_area']=="on") echo "checked" ?> />
              <p>Set Footer Widget tweets On/Off</p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Twitter Username</label>
            </li>
            <li class="to-field">
              <input type="text" id="tweet_user_name" name="tweet_user_name" value="<?php echo $cs_theme_option['tweet_user_name']; ?>" />
              <p> Put Twitter Username</p>
            </li>
          </ul>
       	  <ul class="form-elements">
            <li class="to-label">
              <label>No. of Tweets</label>
            </li>
            <li class="to-field">
              <input type="text" id="num_of_tweets" name="num_of_tweets" value="<?php echo $cs_theme_option['num_of_tweets']; ?>" />
              <p> Put No. of Tweets</p>
            </li>
          </ul>
              <ul class="form-elements">
              <li class="full">&nbsp;</li>
              <li class="to-label">
                  <label>Social Icon</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="footer_socialicon" value=""  />
                  <input type="checkbox" class="myClass" name="footer_socialicon" <?php if (isset($cs_theme_option['footer_socialicon']) and $cs_theme_option['footer_socialicon']== "on") echo "checked" ?> />
                </li>
              </ul>
             <ul class="form-elements">
             	<li class="full">&nbsp;</li>
                <li class="to-label">
                	<label>Mail Chimp</label>
             	</li>
                <li class="to-field">
                  <input type="hidden" name="footer_mailchimp" value="" >
                  <input type="checkbox" class="myClass" name="footer_mailchimp" <?php if (isset($cs_theme_option['footer_mailchimp']) and $cs_theme_option['footer_mailchimp'] == "on") echo "checked" ?> />
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
                <p> Put event start date</p>
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
          <div id="tab-paypalapi-key" style="display:none;">
            <div class="theme-header">
              <h1>Paypal API Setting</h1>
            </div>
            <div class="theme-help">
              <h4>Paypal API Setting</h4>
              <p>Paypal API Setting</p>
            </div>
            <div class="opt-head">
              <h4>Paypal API Setting</h4>
              <div class="clear"></div>
            </div>
            <ul class="form-elements">
              <li class="to-label">
                <label>Paypal Email</label>
              </li>
              <li class="to-field">
                <input type="text" id="paypal_email" name="paypal_email" value="<?php  echo $cs_theme_option['paypal_email'];  ?>" />
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Paypal Ipn URL</label>
              </li>
              <li class="to-field">
                <input type="text" id="paypal_ipn_url" name="paypal_ipn_url" value="<?php  echo $cs_theme_option['paypal_ipn_url'];  ?>"/>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Currency</label>
              </li>
              <li class="to-field">
             <?php $currency_array = array('U.S. Dollar'=>'USD','Australian Dollar'=>'AUD','Brazilian Real'=>'BRL','Canadian Dollar'=>'CAD','Czech Koruna'=>'CZK','Danish Krone'=>'DKK','Euro'=>'EUR','Hong Kong Dollar'=>'HKD','Hungarian Forint'=>'HUF','Israeli New Sheqel'=>'ILS','Japanese Yen'=>'JPY','Malaysian Ringgit'=>'MYR','Mexican Peso'=>'MXN','Norwegian Krone'=>'NOK','New Zealand Dollar'=>'NZD','Philippine Peso'=>'PHP','Polish Zloty'=>'PLN','Pound Sterling'=>'GBP','Singapore Dollar'=>'SGD','Swedish Krona'=>'SEK','Swiss Franc'=>'CHF','Taiwan New Dollar'=>'TWD','Thai Baht'=>'THB','Turkish Lira'=>'TRY');?>
              <select name="paypal_currency">
              <?php foreach($currency_array as $key=>$val){?>
              	   <option value="<?php echo $val;?>" <?php if($cs_theme_option['paypal_currency'] == $val){echo ' selected="selected"';}?>><?php echo $key;?></option>
                <?php }?>
                </select>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Currency Sign</label>
              </li>
              <li class="to-field">
                <input type="text" id="paypal_currency_sign" name="paypal_currency_sign" value="<?php if($cs_theme_option['paypal_currency_sign']==''){echo '$';} else { echo $cs_theme_option['paypal_currency_sign'];} ?>"/>
                <p>Use Currency Sign </p>
              </li>
            </ul>
          </div>
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
              <label>Consumer Key</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="consumer_key" value="" />
              <input type="text" id="consumer_key" name="consumer_key" value="<?php  echo $cs_theme_option['consumer_key'];  ?>"  class="{validate:{required:true}}"/>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Consumer Secret</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="consumer_secret" value="" />
              <input type="text" id="consumer_secret" name="consumer_secret" value="<?php echo $cs_theme_option['consumer_secret']; ?>" class="{validate:{required:true}}"/>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Access Token</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="access_token" value="" />
              <input type="text" id="access_token" name="access_token" value="<?php echo $cs_theme_option['access_token']; ?>" class="{validate:{required:true}}"/>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Access Token Secret</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="access_token_secret" value="" />
              <input type="text" id="access_token_secret" name="access_token_secret" value="<?php echo $cs_theme_option['access_token_secret']; ?>" class="{validate:{required:true}}"/>
            </li>
          </ul>
         </div>
          
          <div id="tab-mailchimp-key" style="display:none;">
            <div class="theme-header">
              <h1>MailChimp Setting</h1>
            </div>
            <div class="theme-help">
              <h4>MailChimp Setting</h4>
              <p>MailChimp Setting</p>
            </div>
            <div class="opt-head">
              <h4>MailChimp Setting</h4>
              <div class="clear"></div>
            </div>
            <ul class="form-elements">
              <li class="to-label">
                <label>MailChimp Key</label>
              </li>
              <li class="to-field">
                <input type="text" id="mailchimp_key" name="mailchimp_key" value="<?php if(isset($cs_theme_option['mailchimp_key'])){ echo $cs_theme_option['mailchimp_key'];}else{ $cs_theme_option['mailchimp_key'] = '';}   ?>" />
                <p><?php echo __('Enter a valid MailChimp API key here to get started. Once you\'ve done that, you can use the MailChimp Widget from the Widgets menu. You will need to have at least MailChimp list set up before the using the widget.', 'mailchimp-widget'). __(' You can get your mailchimp activation key', 'Faith') . ' <u><a href="' . get_admin_url() . 'https://login.mailchimp.com/">' . __('here', 'Faith') . '</a></u>' ?> 				
			</p>
              </li>
            </ul>
            <ul id="other_sliders" class="form-elements">
            <li class="to-label">
              <label>MailChimp List</label>
            </li>
            <li class="to-field">
                <select class="dropdown valid" name="cs-mc-list">
                    <option value="">-- MailChimp List --</option>
						<?php 
						if($cs_theme_option['mailchimp_key'] <> ''){
						$mc_list = cs_mailchimp_list($cs_theme_option['mailchimp_key']); 
                          if($mc_list <> ''){
                              foreach($mc_list['data'] as $list){
                                   if($list['id']==$cs_theme_option['cs-mc-list']){ $selected ="selected"; }else{$selected = '';}
                                  echo '<option value="'.$list['id'].'" selected="'.$selected.'">'.$list['name'].'</option>';
                              }
                          
                          }
						}
                        ?>
                </select>
              
            </li>
          </ul>
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
            
            <ul class="form-elements" id="other_sliders">
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
                <p>Slider images resolution should be (1080 x 506). Create new Slider from <a style="color:#06F; text-decoration:underline;" href="<?php echo get_site_url(); ?>/wp-admin/post-new.php?post_type=cs_slider">here</a></p>
              </li>
            </ul>
            
            
            
          </div>
          <div id="tab-Announcement" style="display:none;">
            <div class="theme-header">
              <h1>Home Page Announcement</h1>
            </div>
            <div class="theme-help">
              <h4>Home Page Announcement</h4>
              <p>Edit home page Announcement settings</p>
            </div>
            <ul class="form-elements">
              <li class="to-label">
                <label>Announcement Title</label>
              </li>
              <li class="to-field">
                <input type="text" name="announcement_title" size="5" value="<?php echo $cs_theme_option['announcement_title']?>" />
                <p>Enter Announcements Title.</p>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Choose Announcements Category</label>
              </li>
              <li class="to-field">
                <select name="announcement_blog_category" class="dropdown">
                  <option value="">-- Select Category --</option>
							<?php show_all_cats('', '', $cs_theme_option['announcement_blog_category'], "category");?>
                </select>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Show no of posts</label>
              </li>
              <li class="to-field">
                <input type="text" name="announcement_no_posts" size="5" value="<?php echo $cs_theme_option['announcement_no_posts']?>" />
                <p>Enter no of announcements to show.</p>
              </li>
            </ul>
          </div>
          <div id="tab-services" style="display:none;">
            <div class="theme-header">
              <h1>Home Page Services</h1>
            </div>
            <div class="theme-help">
              <h4>Home Page Services</h4>
              <p>Edit home page Services settings</p>
            </div>
            <ul class="form-elements">
              <li class="to-label">
                <label>Show Services</label>
              </li>
              <li class="to-field">
                <input type="hidden" name="show_services" value="" />
                <input type="checkbox" class="myClass" name="show_services" <?php if($cs_theme_option['show_services']=="on") echo "checked" ?> />
                <p>Switch it on if you want to show services at home page. If you switch it off it will not show services at home page</p>
              </li>
            </ul>
             <ul class="form-elements">
              <li class="to-label">
                <label>Services Shortcode</label>
              </li>
              <li class="to-field">
                <textarea rows="2" cols="4" name="varto_services_shortcode"><?php echo $cs_theme_option['varto_services_shortcode'];?></textarea>
                <p>Add services shortcode here.</p>
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
                <p>Put Entypo Font Code like "fa-facebook".</p>
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
              <li class="to-field">
                <input type="button" value="Add" onclick="javascript:cs_add_social_icon('<?php echo home_url()?>')" />
              </li>
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
						//print_r($cs_theme_option['social_net_url']);
						foreach ( $cs_theme_option['social_net_url'] as $val ){
							//print_r($cs_theme_option['social_net_color_input'][$i]);
							$cs_counter_social_network++;
							echo '<tr id="del_'.$cs_counter_social_network.'">';
								if(isset($cs_theme_option['social_net_awesome'][$i]) && $cs_theme_option['social_net_awesome'][$i] <> ''){
									echo '<td><i class="fa '.$cs_theme_option['social_net_awesome'][$i].' fa-2x"></td>';
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
                    <td colspan="3"><ul class="form-elements">
                        <li class="to-label">
                          <label>Icon Path</label>
                        </li>
                        <li class="to-field">
                          <input id="social_net_icon_path<?php echo $cs_counter_social_network?>" name="social_net_icon_path[]" value="<?php echo $cs_theme_option['social_net_icon_path'][$i]?>" type="text" class="small" />
                        </li>
                        <li><a onclick="cs_toggle('<?php echo $cs_counter_social_network?>')"><img src="<?php echo get_template_directory_uri()?>/images/admin/close-red.png" /></a></li>
                        <li class="full">&nbsp;</li>
                        <li class="to-label">
                          <label>Awesome Font</label>
                        </li>
                        <li class="to-field">
                          <input class="small" type="text" id="social_net_awesome" name="social_net_awesome[]" value="<?php echo $cs_theme_option['social_net_awesome'][$i]?>" style="width:420px;" />
                          <p>Put Awesome Font Code like "icon-flag".</p>
                        </li>
                        <li class="full">&nbsp;</li>
                        <li class="to-label">
                          <label>URL</label>
                        </li>
                        <li class="to-field">
                          <input class="small" type="text" id="social_net_url" name="social_net_url[]" value="<?php echo $val?>" style="width:420px;" />
                          <p>Please enter full URL.</p>
                        </li>
                        <li class="full">&nbsp;</li>
                        <li class="to-label">
                          <label>Title</label>
                        </li>
                        <li class="to-field">
                          <input class="small" type="text" id="social_net_tooltip" name="social_net_tooltip[]" value="<?php echo $cs_theme_option['social_net_tooltip'][$i]?>" style="width:420px;" />
                          <p>Please enter text for icon tooltip.</p>
                        </li>
                      </ul></td>
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
            <ul class="form-elements">
              <li class="to-label">
                <label>Others</label>
              </li>
              <li class="to-field social-share">
                <input type="hidden" name="cs_other_share" value="" />
                <input type="checkbox" class="myClass" name="cs_other_share" <?php if($cs_theme_option['cs_other_share']=="on") echo "checked" ?> />
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
              <label>Buy Ticket</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_event_buy_ticket" value="<?php echo $cs_theme_option['trans_event_buy_ticket']?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Free Entry</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_event_free_entry" value="<?php echo $cs_theme_option['trans_event_free_entry']?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Sold Out</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_event_sold_out" value="<?php echo $cs_theme_option['trans_event_sold_out']?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Cancelled</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_event_cancelled" value="<?php echo $cs_theme_option['trans_event_cancelled']?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Event Time</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_event_eventtime" value="<?php echo $cs_theme_option['trans_event_eventtime']?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Location</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_event_location" value="<?php echo $cs_theme_option['trans_event_location']?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Speakers</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_event_speakers" value="<?php echo $cs_theme_option['trans_event_speakers']?>" />
            </li>
          </ul>
          
          </div>
          
          <div id="tab-sermon-translation" style="display:none;">
            <div class="theme-header">
              <h1>Sermons Translation</h1>
            </div>
            <div class="theme-help">
              <h4>Sermons Translation</h4>
              <p>Sermons Translation</p>
            </div>
            
          <ul class="form-elements">
            <li class="to-label">
              <label>Study Guide</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_sermon_study" value="<?php echo $cs_theme_option['trans_sermon_study']?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Download Mp3</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_sermon_download" value="<?php echo $cs_theme_option['trans_sermon_download']?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Buy full Sermon</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_sermon_buy" value="<?php echo $cs_theme_option['trans_sermon_buy']?>" />
            </li>
          </ul>
          
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
              <input type="text" name="trans_prayer_already_prayed" value="<?php echo $cs_theme_option['trans_prayer_already_prayed']?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>You Prayed</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_prayer_you_prayed" value="<?php echo $cs_theme_option['trans_prayer_you_prayed']?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>I Pray for this</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_prayer_pray_this" value="<?php echo $cs_theme_option['trans_prayer_pray_this']?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Encourage</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_prayer_encourage" value="<?php echo $cs_theme_option['trans_prayer_encourage']?>" />
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
                <label>First Name</label>
              </li>
              <li class="to-field">
                <input type="text" name="res_first_name" value="<?php echo $cs_theme_option['res_first_name']?>" />
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Last Name</label>
              </li>
              <li class="to-field">
                <input type="text" name="res_last_name" value="<?php echo $cs_theme_option['res_last_name']?>" />
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
                <label>Featured</label>
              </li>
              <li class="to-field">
                <input type="text" name="trans_featured" value="<?php echo $cs_theme_option['trans_featured']?>" />
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
                <label>View All</label>
              </li>
              <li class="to-field">
                <input type="text" name="trans_view_all" value="<?php echo $cs_theme_option['trans_view_all']?>" />
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
                <label>in</label>
              </li>
              <li class="to-field">
                <input type="text" name="trans_other_in" value="<?php echo $cs_theme_option['trans_other_in']?>" />
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>or</label>
              </li>
              <li class="to-field">
                <input type="text" name="trans_other_or" value="<?php echo $cs_theme_option['trans_other_or']?>" />
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Weekly Newsletter</label>
              </li>
              <li class="to-field">
                <input type="text" name="trans_other_weekly_newsletter" value="<?php echo $cs_theme_option['trans_other_weekly_newsletter']?>" />
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Latest Tweet</label>
              </li>
              <li class="to-field">
                <input type="text" name="trans_other_latest_tweet" value="<?php echo $cs_theme_option['trans_other_latest_tweet']?>" />
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Donate</label>
              </li>
              <li class="to-field">
                <input type="text" name="trans_other_donate" value="<?php echo $cs_theme_option['trans_other_donate']?>" />
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Donation Title</label>
              </li>
              <li class="to-field">
                <input type="text" name="trans_other_donation_title" value="<?php echo $cs_theme_option['trans_other_donation_title']?>" />
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Photos</label>
              </li>
              <li class="to-field">
                <input type="text" name="trans_other_photos" value="<?php echo $cs_theme_option['trans_other_photos']?>" />
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
                <label>Last Backup Taken on</label>
              </li>
              <li class="to-field"> <strong><span id="last_backup_taken">
                <?php 
						if ( get_option('cs_theme_option_backup_time') ) {
							echo get_option('cs_theme_option_backup_time');
						}
						else { echo "Not Taken Yet"; }
					?>
                </span></strong> </li>
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
       <input type="button" value="Reset Option" class="bottom_btn_reset" onclick="cs_to_restore_default('<?php echo home_url()?>', '<?php echo get_template_directory_uri()?>')" />
         
        <input type="submit" id="submit_btn" name="submit_btn" class="bottom_btn_save" value="Save All Settings" />
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
		 function load_default_settings(id) {
           jQuery("#" + id + " input.button.wp-picker-default").trigger('click');
           jQuery("#" + id + " input[type='checkbox'].myClass").each(function(index) {
             var da = jQuery(this).data('default-header');
             var ch = jQuery(this).next().hasClass("checked")
             if ((da == 'on') && (!ch)) {
               jQuery(this).next().trigger('click');
             }
             if ((da == 'off') && (ch)) {
               jQuery(this).next().trigger('click');
             }
           });
           jQuery("#" + id + " input[type='text'].vsmall").each(function(index) {
             var da = jQuery(this).data('default-header');
             jQuery(this).val(da);

           });
           jQuery("#" + id + " .to-field input.small").each(function(index) {
             var da = jQuery(this).data('default-header');
             jQuery(this).val(da);
             jQuery(this).parent().find(".thumb-preview").find('img').attr("src", da)
           });
           jQuery("#" + id + " textarea").each(function(index) {
             var da = jQuery(this).data('default-header');
             jQuery(this).val(da);

           });
           jQuery("#" + id + " select").each(function(index) {

             var da = jQuery(this).data('default-header');
             jQuery(this).find("option[value='" + da + "']").attr("selected", "selected");

           });

         }
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
     <script type="text/javascript">
			  jQuery(document).ready(function($) {
				jQuery("#colorpickerwrapp span.col-box").live("click",function(event) {
					var a = jQuery(this).data('color');
					jQuery("#cs_custom_color_style").val(a);
					jQuery('.wp-color-result').css('background-color', a);
					jQuery("#colorpickerwrapp span.col-box") .removeClass('active');
					jQuery(this).addClass("active");
				});
			  });
		   </script>
<?php }?>
