<?php
function theme_option() {
	global $post;
	$px_theme_option = get_option('px_theme_option');
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
            <div class="main-nav">
                 <ul class="sub-menu categoryitems" style="display:block">
                    <li class="logo"><a href="#"><img src="<?php echo get_template_directory_uri()?>/images/admin/logo.png" /></a></li>
 	                <li><i class="fa fa-cogs"></i><a href="#tab-color" onClick="toggleDiv(this.hash);return false;">Gernal Settings</a></li>
                    <li><i class="fa fa-picture-o"></i><a href="#tab-logo" onClick="toggleDiv(this.hash);return false;">Logo / Fav Icon</a></li>
                    <li><i class="fa fa-tasks"></i><a href="#tab-head-scripts" onClick="toggleDiv(this.hash);return false;">Header Settings</a></li>
                     <li><i class="fa fa-tasks"></i><a href="#tab-other" onClick="toggleDiv(this.hash);return false;">Other Settings</a></li>
                    <li><i class="fa fa-home"></i><a href="#tab-manage-announcement" onClick="toggleDiv(this.hash);return false;">Home Page Settings</a></li>
                    <li><i class="fa fa-columns"></i><a href="#tab-manage-sidebars" onClick="toggleDiv(this.hash);return false;">Manage Sidebars</a></li>
                    <li><i class="fa fa-desktop"></i><a href="#tab-flex-slider" onClick="toggleDiv(this.hash);return false;">Flex Slider</a></li>
                    <li><i class="fa fa-users"></i><a href="#tab-social-sharing" onClick="toggleDiv(this.hash);return false;">Social Links</a></li>
                    <li><i class="fa fa-globe"></i><a href="#tab-upload-languages" onClick="toggleDiv(this.hash);return false;">Translations</a></li>
                    <li><i class="fa fa-archive"></i><a href="#tab-default-pages" onClick="toggleDiv(this.hash);return false;">Default Pages</a></li>
                    <li><i class="fa fa-floppy-o"></i> <a href="#tab-import-export" onClick="toggleDiv(this.hash);return false;">Theme Options Backup</a></li> 
                     <li class="to-field">
                     <i class="fa fa-paste"></i>
                        <input type="button" value="Restore Default" onclick="px_to_restore_default('<?php echo home_url()?>', '<?php echo get_template_directory_uri()?>')" />
                     </li>      
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
              <h4> > Color And Styles</h4>
            </div>
            <div class="opt-head">
              <h4>Theme color Settings</h4>
              <div class="clear"></div>
            </div>
            <ul class="form-elements">
              
              <li class="to-field">
              <label class="to-label">Theme Color Scheme</label>
                <input type="text" name="custom_color_scheme" value="<?php echo $px_theme_option['custom_color_scheme']?>" class="bg_color" />
              </li>
            </ul>
            <ul class="form-elements noborder">
              
              <li class="to-field">
              <label class="to-label">Element Color Scheme</label>
                <input type="text" name="element_color_scheme" value="<?php echo $px_theme_option['element_color_scheme']?>" class="bg_color" />
              </li>
            </ul>
             <ul class="form-elements noborder">
             
              <li class="to-field">
              	<label class="to-label">Background Color</label>
                <input type="text" name="bg_color" value="<?php echo $px_theme_option['bg_color']?>" class="bg_color" data-default-color="" />
              </li>
            </ul>
            
            
            <div class="opt-head">
              <h4>Split Options</h4>
              <div class="clear"></div>
            </div>
            <?php $varto_bg_option = $px_theme_option['varto_bg_option'];?>
              <ul class="form-elements  noborder">
                    <li class="to-label"><label>Background View</label></li>
                    <li class="to-field">
                        <select name="varto_bg_option" class="dropdown"  onchange="javascript:px_toggle_bg_options(this.value)">
                        	<option <?php if($varto_bg_option=='no-image') echo "selected";?> value="no-image"> No Image</option>
                        	<option <?php if($varto_bg_option=='custom-background-image') echo "selected";?> value="custom-background-image"> V1 Custom Background Image</option>
                        	<option <?php if($varto_bg_option=='big-image-zoom') echo "selected";?> value="big-image-zoom"> V2 Big Image Zoom</option>
                            <option <?php if($varto_bg_option=='fade-slider') echo "selected";?> value="fade-slider">V3 Fade Slider</option>
                            <option <?php if($varto_bg_option=='left-slider')echo "selected";?> value="left-slider">V4 Left Slide</option>
                            <option value="background_video" <?php if($varto_bg_option=='background_video')echo "selected";?> >V6 Video</option>
                        </select>
                        
                    </li>
                </ul>
                
                <div class="form-elements meta-body noborder" style=" <?php if($varto_bg_option == "background_video"){echo "display:block";}else echo "display:none";?>" id="home_v2" >
            	
                	<ul class="form-elements noborder">
                        <li class="to-label"><label>Video URL</label></li>
                        <li class="to-field">
                            <input type="text" name="px_home_v2_video_url" class="txtfield" value="<?php echo htmlspecialchars($px_theme_option['px_home_v2_video_url'])?>" />
                            <p>Please enter Vimeo/Youtube Video URL.</p>
                        </li>                    
                	</ul>
                    <ul class="form-elements noborder">
                        <li class="to-label"><label>Choose Mute</label></li>
                        <li class="to-field">
                            <select name="px_home_v2_video_mute" class="dropdown">
                                 <option value="Yes" <?php if($px_theme_option['px_home_v2_video_mute'] == "Yes"){ echo 'selected';}?>> Yes</option>
                                 <option value="No" <?php if($px_theme_option['px_home_v2_video_mute'] == "No"){ echo 'selected';}?>> No</option>
                            </select>
                        </li>                                        
                    </ul>
               	
            </div>
                <!-- end home v2--->	
                <div class="form-elements meta-body noborder" style=" <?php if($varto_bg_option == "custom-background-image"){echo "display:block";}else echo "display:none";?>" id="home_v3" >
                   
                    <ul class="form-elements noborder">
                            
                        <li class="to-label"><label>Background Image</label></li>
                        <li class="to-field">
                        	<input id="bg_image" name="bg_custom_image" value="<?php echo $px_theme_option['bg_custom_image']?>" type="text" class="small {validate:{accept:'jpg|jpeg|gif|png|bmp'}" />
                			<input id="bg_image" name="bg_image" type="button" class="uploadfile left" value="Browse" />
                        	 
                            <?php if ( $px_theme_option['bg_custom_image'] <> "" ) { ?>
                            <div class="thumb-preview" id="bg_image_img_div"> <img width="100%" height="100%" src="<?php echo $px_theme_option['bg_custom_image']?>" /> <a href="javascript:remove_image('bg_image')" class="del">&nbsp;</a> </div>
                            <?php } ?>
                             
                        </li>
                    </ul>
                   
                </div>
                <!-- end Custom image-->	
                <div class="form-elements meta-body noborder" style=" <?php if($px_theme_option['varto_bg_option'] == "big-image-zoom" || $px_theme_option['varto_bg_option'] == "fade-slider" ||  $px_theme_option['varto_bg_option'] == "left-slider"){echo "display:block";}else echo "display:none";?>" id="home_v4" >
                    
                            <ul class="form-elements noborder">
                            <li class="to-label"><label>Choose Slider/Gallery</label></li>
                            <li class="to-field">
                                <select name="px_home_v4_slider" class="dropdown">
                                     <?php
                                        $query = array( 'posts_per_page' => '-1', 'post_type' => 'px_gallery', 'orderby'=>'ID', 'post_status' => 'publish' );
                                        $wp_query = new WP_Query($query);
                                        while ($wp_query->have_posts()) : $wp_query->the_post();
                                    ?>
                                        <option <?php if($post->post_name==$px_theme_option['px_home_v4_slider'])echo "selected";?> value="<?php echo $post->post_name; ?>"><?php the_title()?></option>
                                    <?php
                                        endwhile;
                                    ?>
                                </select>
                                <p>Slider/Gallery images resolution should befull size. Create new Slider/Gallery from <a style="color:#06F; text-decoration:underline;" href="<?php echo get_site_url(); ?>/wp-admin/post-new.php?post_type=px_gallery">here</a></p>
                            </li>
                        </ul>
                    
                </div>
                <!-- end home v4 Big Image Zoom--->	
            
            <ul class="form-elements">
              <li class="to-label">
                <label>Analytics Code</label>
              </li>
              <li class="to-field">
                <textarea rows="" cols="" name="analytics"><?php echo $px_theme_option['analytics']?></textarea>
                <p>Paste your Google Analytics (or other) tracking code here.<br />
                  This will be added into the footer template of your theme.</p>
              </li>
            </ul>
          </div>
          <!-- Color And Style End --> 
          <!-- Logo Tabs -->
          <div id="tab-logo" style="display:none;">
            <div class="theme-header">
              <h1>General Settings</h1>
              <h4> > Logo / Fav Icon Settings</h4>
            </div>
            <div class="opt-head">
              <h4>Logo Settings</h4>
              <div class="clear"></div>
            </div>
            <ul class="form-elements">
              <li class="to-label">
                <label>Upload Logo</label>
              </li>
              <li class="to-field">
                <input id="logo" name="logo" value="<?php echo $px_theme_option['logo']?>" type="text" 
                class="small {validate:{accept:'jpg|jpeg|gif|png|bmp'}}"  />
                <input id="log" name="logo"   type="button" class="uploadfile left" value="Browse"/>
                <?php if ( $px_theme_option['logo'] <> "" ) { ?>
                    <div class="thumb-preview" id="logo-preview"> 
                    	<img width="<?php echo $px_theme_option['logo_width']?>" height="<?php echo $px_theme_option['logo_height']?>" 
                        src="<?php echo $px_theme_option['logo']?>" /> 
                    	<a href="javascript:remove_image('logo')" class="del">&nbsp;</a> 
                    </div>
                <?php } ?>
               </li>
            </ul>
            <ul class="form-elements noborder">
              <li class="to-label">
                <label>Width</label>
              </li>
              <li class="to-field">
                <input type="text" name="logo_width" id="width-value" value="<?php echo $px_theme_option['logo_width']?>" class="vsmall" />
                <span class="short">px</span>
                
              </li>
            </ul>
            <ul class="form-elements  noborder">
              <li class="to-label">
                <label>Height</label>
              </li>
              <li class="to-field">
                <input type="text" name="logo_height" id="height-value" value="<?php echo $px_theme_option['logo_height']?>" class="vsmall" />
                <span class="short">px</span>
                
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Upload Large Logo</label>
              </li>
              <li class="to-field">
                <input id="main_logo" name="main_logo" value="<?php echo $px_theme_option['main_logo']?>" type="text" 
                class="small {validate:{accept:'jpg|jpeg|gif|png|bmp'}}"  />
                <input id="main_logo" name="main_logo"   type="button" class="uploadfile left" value="Browse"/>
                <?php if ( $px_theme_option['main_logo'] <> "" ) { ?>
                    <div class="thumb-preview" id="main_logo-preview"> 
                    	<img width="<?php echo $px_theme_option['logo_width']?>" height="<?php echo $px_theme_option['logo_height']?>" 
                        src="<?php echo $px_theme_option['main_logo']?>" /> 
                    	<a href="javascript:remove_image('main_logo')" class="del">&nbsp;</a> 
                    </div>
                <?php } ?>
               </li>
            </ul>
            <div class="opt-head">
              <h4>FAV Icon Settings</h4>
              <div class="clear"></div>
            </div>
            
            <ul class="form-elements">
               <li class="to-label">
                <label>FAV Icon</label>
              </li>
              <li class="to-field">
                <input id="favicon" name="fav_icon" value="<?php echo $px_theme_option['fav_icon']?>" type="text" class="small {validate:{accept:'ico|png'}}" />
                <input id="fav_icon" name="favicon" type="button" class="uploadfile left" value="Browse" />
                <?php if ( $px_theme_option['fav_icon'] <> "" ) { ?>
                    <div class="thumb-preview" id="favicon-preview"> 
                    	<img width="32" height="32" src="<?php echo $px_theme_option['fav_icon']?>" /> 
                    	<a href="javascript:remove_image('favicon')" class="del">&nbsp;</a> 
                    </div>
                <?php } ?>                
                <p>Browse a small fav icon, only .ICO or .PNG format allowed.</p>
              </li>
            </ul>
          </div>
          
          <!-- Logo Tabs End --> 
          
          <!-- Header Styles --> 
          
          <!-- Header Script -->
          <div id="tab-head-scripts" style="display:none;">
            <div class="theme-header">
              <h1>General Settings</h1>
              <h4> > Header Settings</h4>
            </div>
            <div class="header-section" id="header_banner1">
              
               <ul class="form-elements">
              	
                <li class="to-field">
                <label class="to-label">Social Icons</label>
                  <input type="hidden" name="header_social_icons" value=""/>
                  <label class="cs-on-off">
                      <input type="checkbox" name="header_social_icons" <?php if ($px_theme_option['header_social_icons'] == "on") echo "checked" ?>/>
                      <span></span>
                  </label>
                </li>
              </ul>
              
              
             <?php if ( function_exists( 'is_woocommerce' ) ){ ?>  
             <ul class="form-elements">
              	
                <li class="to-field">
                <input type="hidden" name="header_cart" value=""/>
                <label class="to-label">Cart Count</label>
                  <label class="cs-on-off">
                      <input type="checkbox" name="header_cart" <?php if ($px_theme_option['header_cart'] == "on") echo "checked" ?>/>
                      <span></span>
                  </label>
                </li>
              </ul>
              <?php } else { ?>
              	<input type="hidden" name="header_cart" value=""/>
              <?php 
				}
			   $wpmlsettings=get_option('icl_sitepress_settings');
  			   if ( function_exists('icl_object_id') ) {
   			   ?>
              <ul class="form-elements">
                <li class="to-field">
                <input type="hidden" name="header_languages" value="" />
                <label class="to-label">Header Languages</label>
                  <label class="cs-on-off">
                      <input type="checkbox" class="myClass" name="header_languages" <?php if ($px_theme_option['header_languages'] == "on") echo "checked" ?> />
                      <span></span>
                  </label>
                </li>
              </ul>
		  <?php } else { ?>
          		<input type="hidden" name="header_languages" value="" />
          <?php }?>
           <div class="clear"></div>
            <div class="opt-head">
              <h4>Music Album</h4>
              <div class="clear"></div>
            </div>
            <ul class="form-elements">
              	
                <li class="to-field">
                <label class="to-label">Music AutoPlay</label>
                  <input type="hidden" name="px_music_autoplay" value=""/>
                  <label class="cs-on-off">
                      <input type="checkbox" name="px_music_autoplay" <?php if ($px_theme_option['px_music_autoplay'] == "on") echo "checked" ?>/>
                      <span></span>
                  </label>
                </li>
              </ul>
            <ul class="form-elements noborder">
              <li class="to-label">
                <label>Choose Album</label>
              </li>
              <li class="to-field">
                <select name="px_music_album" class="dropdown">
                  <option value="">-- Select Album --</option>
                  <?php
						query_posts( array('posts_per_page' => "-1", 'post_status' => 'publish', 'post_type' => 'albums') );
							while ( have_posts()) : the_post();
							?>
								<option <?php if($px_theme_option['px_music_album']==get_the_ID())echo "selected"?> value="<?php the_ID()?>"><?php the_title()?></option>
							<?php
							endwhile;
					?>
				
                </select>
              </li>
            </ul>
          <ul class="form-elements">
              <li class="to-label">
                <label>Copyright </label>
              </li>
              <li class="to-field">
                <textarea rows="3" cols="8" name="copyright"><?php echo $px_theme_option['copyright']?></textarea>
                
              </li>
            </ul>
          <ul class="form-elements">
              <li class="to-label">
                <label>Header Code</label>
              </li>
              <li class="to-field">
                <textarea rows="" cols="" name="header_code"><?php echo $px_theme_option['header_code']?></textarea>
                <p>Paste your Html or Css Code here.</p>
              </li>
            </ul>
            </div>
             
          </div>
          <!-- Header Script End --> 
          
          <!-- Other Settings Start -->
          <div id="tab-other" style="display:none;">
            <div class="theme-header">
              <h1>General Settings</h1>
              <h4> > Other Setting</h4>
            </div>
            
            <ul class="form-elements">
              
              <li class="to-field">
              	<label class="to-label">Responsive</label>
                <input type="hidden" name="responsive" value="" />
                <label class="cs-on-off">
                    <input type="checkbox" name="responsive" <?php if($px_theme_option['responsive']=="on") echo "checked" ?> />
                    <span></span>
                </label>
               
              </li>
            </ul>
            <ul class="form-elements">
              
              <li class="to-field">
              <label class="to-label">Nice Scroll</label>
                <label class="cs-on-off">
                    <input type="checkbox" name="site_nicescroll" <?php if (isset($px_theme_option['site_nicescroll']) &&  $px_theme_option['site_nicescroll'] == "on"){echo "checked";} ?> />
                    <span></span>
                </label>
                
              </li>
            </ul>
            <ul class="form-elements">
            
              <li class="to-field">
               <label class="to-label">Translation Switcher</label>
                <input type="hidden" name="trans_switcher" value="" />
                <label class="cs-on-off">
                    <input type="checkbox" name="trans_switcher" <?php if($px_theme_option['trans_switcher']=="on") echo "checked" ?> />
                    <span></span>
                </label>
               
              </li>
            </ul>
            <ul class="form-elements">
            
              <li class="to-field">
              <label class="to-label">RTL Switcher</label>
                <input type="hidden" name="rtl_switcher" value="" />
                <label class="cs-on-off">
                    <input type="checkbox" name="rtl_switcher" <?php if($px_theme_option['rtl_switcher']=="on") echo "checked" ?> />
                    <span></span>
                </label>
               
              </li>
            </ul>
          </div>
          <!-- Other Settings End --> 
          <!-- Home Page Announcement Start -->
          <div id="tab-manage-announcement" style="display:none;">
            <div class="theme-header">
              <h1>Home Page Settings</h1>
              <h4> >Banner</h4>
            </div>
            <div class="opt-head">
              <h4>Home Page Banner Settings</h4>
              <div class="clear"></div>
            </div>
            
            <ul class="form-elements noborder">
              <li class="to-label">
                <label>Choose Blog Category</label>
              </li>
              <li class="to-field">
                <select name="blog_banner_category" class="dropdown">
                  <option value="">-- Select Category --</option>
				  <?php show_all_cats('', '', $px_theme_option['blog_banner_category'], "category");?>
                </select>
              </li>
            </ul>
            <ul class="form-elements  noborder">
              <li class="to-label">
                <label>Show no of posts</label>
              </li>
              <li class="to-field">
                <input type="text" name="banner_no_posts" size="5" value="<?php echo $px_theme_option['banner_no_posts']?>" />
               
              </li>
            </ul>
           
            
            
          </div>
          <!-- Home Page Announcement End --> 
          <div id="tab-social-sharing" style="display:none;">
            <div class="theme-header">
            	<h1>Social Links</h1>
            </div>
            <div class="opt-head">
                <h4>Social Share</h4>
                <div class="clear"></div>
            </div>     
            
             <ul class="form-elements">
             <li class="to-field">
               <label class="to-label">Social share</label>
                <input type="hidden" name="social_share" value="" />
                <label class="cs-on-off">
                    <input type="checkbox" name="social_share" <?php if($px_theme_option['social_share']=="on") echo "checked" ?> />
                    <span></span>
                </label>
              </li>
            </ul>
            <div class="opt-head">
                <h4>Social Network</h4>
                <div class="clear"></div>
            </div>
            <ul class="form-elements">
              <li class="to-label">
                <label>Section Title</label>
              </li>
              <li class="to-field">
                <input type="text" name="social_net_title" value="<?php echo $px_theme_option['social_net_title']?>" />
              </li>
            </ul>
            <div class="share_message"></div>
            <ul class="form-elements poped-up" id="add_social_link">
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
                <input class="small" type="text" id="social_net_awesome_input" />
                
              </li>
              <li class="full">&nbsp;</li>
              <li class="to-label">
                <label>URL</label>
              </li>
              <li class="to-field">
                <input class="small" type="text" id="social_net_url_input" />
                
              </li>
              <li class="full">&nbsp;</li>
              <li class="to-label">
                <label>Title</label>
              </li>
              <li class="to-field">
                <input class="small" type="text" id="social_net_tooltip_input"/>
                
              </li>
              <li class="full">&nbsp;</li>
              <li class="to-label"></li>
              <li class="to-field">
                <input type="button" value="Add" onclick="javascript:px_add_social_icon('<?php echo home_url()?>')" />
              </li>
            </ul>
            
            <div class="opt-head">
              <h4>Already Added Items</h4>
              <a href="javascript:openpopedup_social('add_social_link')" class="button add_social_link">Add Social link</a>
              <a href="javascript:closepopedup_social('add_social_link')" style="display:none;" class="button close_social_link">Close</a>
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
					if ( isset($px_theme_option['social_net_url']) and count($px_theme_option['social_net_url']) > 0 ) {
						wp_enqueue_style('font-awesome_css', get_template_directory_uri() . '/css/font-awesome.css');
						// Register stylesheet
						wp_register_style( 'font-awesome-ie7_css', get_template_directory_uri() . '/css/font-awesome-ie7.css' );
						// Apply IE conditionals
						$GLOBALS['wp_styles']->add_data( 'font-awesome-ie7_css', 'conditional', 'lte IE 9' );
						// Enqueue stylesheet
						wp_enqueue_style( 'font-awesome-ie7_css' );
						$px_counter_social_network = rand(10000,20000);
						$i = 0;
						foreach ( $px_theme_option['social_net_url'] as $val ){
							$px_counter_social_network++;
							echo '<tr id="del_'.$px_counter_social_network.'">';
								if(isset($px_theme_option['social_net_awesome'][$i]) && $px_theme_option['social_net_awesome'][$i] <> ''){
									echo '<td><i style="color: green;" class="fa '.$px_theme_option['social_net_awesome'][$i].' 2x"></td>';
								} else {
									echo '<td><img width="50" src="'.$px_theme_option['social_net_icon_path'][$i].'"></td>';
								}
								echo '<td>'.$val.'</td>';
								echo '<td class="centr"> 
											<a onclick="javascript:return confirm(\'Are you sure! You want to delete this\')" href="javascript:social_icon_del('.$px_counter_social_network.')"><i class="fa fa fa-times"></i></a>
											| <a href="javascript:px_toggle('.$px_counter_social_network.')"><i class="fa fa-edit"></i></a>
										</td>';
							echo '</tr>';
							?>
                  <tr id="<?php echo $px_counter_social_network;?>" style="display:none">
                    <td colspan="3">
                    <span class="theme-wrap"><a onclick="px_toggle('<?php echo $px_counter_social_network?>')" ><img src="<?php echo get_template_directory_uri()?>/images/admin/close-red.png" /></a></span>
                    <ul class="form-elements">
                        <li class="to-label">
                          <label>Icon Path</label>
                        </li>
                        <li class="to-field">
                          <input id="social_net_icon_path<?php echo $px_counter_social_network?>" name="social_net_icon_path[]" value="<?php echo $px_theme_option['social_net_icon_path'][$i]?>" type="text" class="small" />
                        </li>
                        <li class="full">&nbsp;</li>
                        <li class="to-label">
                          <label>Awesome Font</label>
                        </li>
                        <li class="to-field">
                          <input class="small" type="text" id="social_net_awesome" name="social_net_awesome[]" value="<?php echo $px_theme_option['social_net_awesome'][$i]?>" />
                          
                        </li>
                        <li class="full">&nbsp;</li>
                        <li class="to-label">
                          <label>URL</label>
                        </li>
                        <li class="to-field">
                          <input class="small" type="text" id="social_net_url" name="social_net_url[]" value="<?php echo $val?>" />
                         
                        </li>
                        <li class="full">&nbsp;</li>
                        <li class="to-label">
                          <label>Title</label>
                        </li>
                        <li class="to-field">
                          <input class="small" type="text" id="social_net_tooltip" name="social_net_tooltip[]" value="<?php echo $px_theme_option['social_net_tooltip'][$i]?>" />
                          
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
           <div id="tab-flex-slider" style="display:none;">
            <div class="theme-header">
              <h1>Slider Setting</h1>
            </div>
            <div class="opt-head">
              <h4>Flex Slider Options</h4>
              <div class="clear"></div>
            </div>
            <ul class="form-elements noborder">
              <li class="to-label">
                <label>Slider Effects</label>
              </li>
              <li class="to-field">
                <select class="dropdown" name="flex_effect">
                  <option <?php if($px_theme_option['flex_effect']=="fade"){echo "selected";}?> value="fade" >Fade</option>
                  <option <?php if($px_theme_option['flex_effect']=="slide"){echo "selected";}?> value="slide" >Slide</option>
                </select>
              </li>
            </ul>
            <ul class="form-elements noborder">
              <li class="to-label">
                <label>Auto Play</label>
              </li>
              <li class="to-field">
                <input type="hidden" name="flex_auto_play" value="" />
                <label class="cs-on-off">
                    <input type="checkbox" name="flex_auto_play" <?php if ( $px_theme_option['flex_auto_play'] == "on" ){ echo "checked";}?> />
                    <span></span>
                </label>
              </li>
            </ul>
            <ul class="form-elements noborder">
              <li class="to-label">
                <label>Animation Speed</label>
              </li>
              <li class="to-field">
                <input type="text" name="flex_animation_speed" size="5" class="{validate:{required:true}} bar" value="<?php echo $px_theme_option['flex_animation_speed']?>" />
              </li>
            </ul>
            <ul class="form-elements noborder">
              <li class="to-label">
                <label>Pause Time</label>
              </li>
              <li class="to-field">
                <input type="text" name="flex_pause_time" size="5" class="{validate:{required:true}} bar" value="<?php echo $px_theme_option['flex_pause_time']?>" />
              </li>
            </ul>
          </div>
          <div id="tab-manage-sidebars" style="display:none;">
            <div class="theme-header">
              <h1>Manage Sidebars</h1>
              <h4>Manage Sidebars</h4>
            </div>
            <ul class="form-elements">
              <li class="to-label">
                <label>Sidebar Name</label>
              </li>
              <li class="to-field">
                <input class="small" type="text" name="sidebar_input" id="sidebar_input" />
                <input type="button" value="Add Sidebar" onclick="javascript:add_sidebar()" />
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
					if ( isset($px_theme_option['sidebar']) and count($px_theme_option['sidebar']) > 0 ) {
						$px_counter_sidebar = rand(10000,20000);
						foreach ( $px_theme_option['sidebar'] as $sidebar ){
							$px_counter_sidebar++;
							echo '<tr id="'.$px_counter_sidebar.'">';
								echo '<td><input type="hidden" name="sidebar[]" value="'.$sidebar.'" />'.$sidebar.'</td>';
								echo '<td class="centr"> <a onclick="javascript:return confirm(\'Are you sure! You want to delete this\')" href="javascript:px_div_remove('.$px_counter_sidebar.')">Del</a> </td>';
							echo '</tr>';
						}
					}
					?>
                </tbody>
              </table>
            </div>
          </div>
          <div id="tab-upload-languages" style="display:none;">
            <div class="theme-header">
              <h1>Translations</h1>
             </div>
             
             
            <div class="opt-head">
              <h4>Upload New Language</h4>
              <div class="clear"></div>
            </div>
            <div class="message-box">
                <div class="messagebox alert alert-info">
                    <button type="button" class="close" data-dismiss="alert"><em class="fa fa-times"></em></button>
                    <div class="masg-text">
                        <p>Please upload new language file (MO format only). It will be uploaded in your theme's languages folder. </p>
                        <p>Download MO files from <a target="_blank" href="http://translate.wordpress.org/projects/wp/">http://translate.wordpress.org/projects/wp/</a> </p>
                    </div>
                </div>
            </div>
            <ul class="form-elements noborder">
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
                
               
                <p>
                  <button type="button" id="upload_btn">Upload Files!</button>
                </p>
              </li>
            </ul>
            <ul id="image-list">
            </ul>
            <ul class="form-elements  noborder">
              <li class="to-label">
                <label>Already Uploaded Languages</label>
              </li>
              <li class="to-field"> <strong>
                <?php
					$px_counter = 0;
					foreach (glob(get_template_directory()."/languages/*.mo") as $filename) {
						$px_counter++;
						$val = str_replace(get_template_directory()."/languages/","",$filename);
						echo "<p>".$px_counter . ". " . str_replace(".mo","",$val)."</p>";
					}
				?>
                </strong>
                <p>Please copy the language name, open config.php file, find WPLANG constant and set its value by replacing the language name. </p>
              </li>
            </ul>
            <div class="opt-head">
              <h4>Translation</h4>
              <div class="clear"></div>
            </div>
            
             
            
            <ul class="form-elements noborder">
                <li class="to-label">
                  <label>Likes</label>
                </li>
                <li class="to-field">
                  <input type="text" name="trans_likes" value="<?php echo $px_theme_option['trans_likes']?>" />
                </li>
              </ul>
            <ul class="form-elements noborder">
                <li class="to-label">
                  <label>Released</label>
                </li>
                <li class="to-field">
                  <input type="text" name="trans_released" value="<?php echo $px_theme_option['trans_released']?>" />
                </li>
              </ul>
              <ul class="form-elements noborder">
                <li class="to-label">
                  <label>Gener</label>
                </li>
                <li class="to-field">
                  <input type="text" name="trans_gener" value="<?php echo $px_theme_option['trans_gener']?>" />
                </li>
              </ul>
            <ul class="form-elements noborder">
                <li class="to-label">
                  <label>Tracks</label>
                </li>
                <li class="to-field">
                  <input type="text" name="trans_tracks" value="<?php echo $px_theme_option['trans_tracks']?>" />
                </li>
              </ul>
          
           
            
            <ul class="form-elements noborder">
              <li class="to-label">
                <label>Subject</label>
              </li>
              <li class="to-field">
                <input type="text" name="trans_subject" value="<?php echo $px_theme_option['trans_subject']?>" />
              </li>
            </ul>
            <ul class="form-elements noborder">
              <li class="to-label">
                <label>Message</label>
              </li>
              <li class="to-field">
                <input type="text" name="trans_message" value="<?php echo $px_theme_option['trans_message']?>" />
              </li>
            </ul>
               <ul class="form-elements noborder">
              <li class="to-label">
                <label>Phone</label>
              </li>
              <li class="to-field">
                <input type="text" name="trans_other_phone" value="<?php echo $px_theme_option['trans_other_phone']?>" />
              </li>
            </ul>
            <ul class="form-elements noborder">
              <li class="to-label">
                <label>Fax</label>
              </li>
              <li class="to-field">
                <input type="text" name="trans_other_fax" value="<?php echo $px_theme_option['trans_other_fax']?>" />
              </li>
            </ul>
            <ul class="form-elements noborder">
              <li class="to-label">
                <label>Email Spam</label>
              </li>
              <li class="to-field">
                <input type="text" name="trans_email_published" value="<?php echo $px_theme_option['trans_email_published']?>" />
              </li>
            </ul>
              
            <ul class="form-elements noborder">
              <li class="to-label">
                <label>Navigation Title</label>
              </li>
              <li class="to-field">
              <input type="text" name="trans_menu_title" value="<?php echo $px_theme_option['trans_menu_title']?>" />
              </li>
            </ul>
            <ul class="form-elements noborder">
              <li class="to-label">
                <label>Current Page</label>
              </li>
              <li class="to-field">
              <input type="text" name="trans_current_page" value="<?php echo $px_theme_option['trans_current_page']?>" />
              </li>
            </ul>
            <ul class="form-elements noborder">
              <li class="to-label">
                <label>Share Now</label>
              </li>
              <li class="to-field">
                <input type="text" name="trans_share_this_post" value="<?php echo $px_theme_option['trans_share_this_post']?>" />
              </li>
            </ul>
            <ul class="form-elements noborder">
              <li class="to-label">
                <label>Posted on</label>
              </li>
              <li class="to-field">
                <input type="text" name="trans_posted_on" value="<?php echo $px_theme_option['trans_posted_on']?>" />
              </li>
            </ul>
            <ul class="form-elements noborder">
              <li class="to-label">
                <label>Listed in</label>
              </li>
              <li class="to-field">
                <input type="text" name="trans_listed_in" value="<?php echo $px_theme_option['trans_listed_in']?>" />
              </li>
            </ul>
            <ul class="form-elements noborder">
              <li class="to-label">
                <label>Featured</label>
              </li>
              <li class="to-field">
                <input type="text" name="trans_featured" value="<?php echo $px_theme_option['trans_featured']?>" />
              </li>
            </ul>
            <ul class="form-elements noborder">
              <li class="to-label">
                <label>Read More</label>
              </li>
              <li class="to-field">
                <input type="text" name="trans_read_more" value="<?php echo $px_theme_option['trans_read_more']?>" />
              </li>
            </ul>
          
            
            </div>
            
          <div id="tab-default-pages" style="display:none;">
            <div class="theme-header">
              <h1>Default Pages</h1>
              <h4> > Default Pages Settings</h4>
            </div>
            <ul class="form-elements">
              <li class="to-label">
                <label>Pagination</label>
              </li>
              <li class="to-field">
                <select name="pagination" class="dropdown" onchange="px_toggle('record_per_page')">
                  <option <?php if($px_theme_option['pagination']=="Show Pagination")echo "selected";?> >Show Pagination</option>
                  <option <?php if($px_theme_option['pagination']=="Single Page")echo "selected";?> >Single Page</option>
                </select>
              </li>
            </ul>
            <?php
				global $px_xmlObject;
				$px_xmlObject = new stdClass();
				$px_xmlObject->sidebar_layout = new stdClass();
				$px_xmlObject->sidebar_layout->px_layout = $px_theme_option['px_layout'];
				$px_xmlObject->sidebar_layout->px_sidebar_left = $px_theme_option['px_sidebar_left'];
				$px_xmlObject->sidebar_layout->px_sidebar_right = $px_theme_option['px_sidebar_right'];
				if ( $px_theme_option['px_layout'] == "none" ) {
					$px_xmlObject->sidebar_layout->px_sidebar_left = '';
					$px_xmlObject->sidebar_layout->px_sidebar_right = '';
				}
				else if ( $px_theme_option['px_layout'] == "left" ) {
					$px_xmlObject->sidebar_layout->px_sidebar_right = '';
				}
				else if ( $px_theme_option['px_layout'] == "right" ) {
					$px_xmlObject->sidebar_layout->px_sidebar_left = '';
				}
				meta_layout('default');
			?>
          </div>  
            
            
            
           <!-- import export Start -->
          <div id="tab-import-export" style="display:none;">
            <div class="theme-header">
              <h1>Backup Options</h1>
              <h4> > Theme Options Backup and restore settings</h4>
            </div>
             <?php /*?><ul class="form-elements">
              <li class="to-label">
                <label>Last Backup Taken on</label>
              </li>
              <li class="to-field"> <strong><span id="last_backup_taken">
                <?php 
						if ( get_option('px_theme_option_backup_time') ) {
							echo get_option('px_theme_option_backup_time');
						}
						else { echo "Not Taken Yet"; }
					?>
                </span></strong> </li>
              <li class="full">&nbsp;</li>
              <li class="to-label">
                <label>Take Backup</label>
              </li>
              <li class="to-field">
                <input type="button" value="Take Backup" onclick="px_to_backup('<?php echo home_url()?>', '<?php echo get_template_directory_uri()?>')" />
                <p>Take the Backup of your current theme options, it will replace the old backup if you have already taken.</p>
              </li>
              <li class="full">&nbsp;</li>
              <li class="to-label">
                <label>Restore Backup</label>
              </li>
              <li class="to-field">
                <input type="button" value="Restore Backup" onclick="px_to_backup_restore('<?php echo home_url()?>', '<?php echo get_template_directory_uri()?>')" />
                <p>Restore your last backup taken (It will be replaced on your curernt theme options).</p>
              </li>
            </ul><?php */?>
            <ul class="form-elements">
            <li class="to-label">
              <label>Current Theme Option Data</label>
            </li>
            <li class="to-field">
                <textarea id="theme_option_data"  readonly="readonly" onclick="this.select()"><?php echo base64_encode(serialize($px_theme_option)); ?></textarea>
              <p>You can copy your current theme data in a text file and import it later by replacing the above text.</p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Import Theme Option Data</label>
            </li>
            <li class="to-field">
                <textarea id="theme_option_data_import" name="theme_option_data_import"></textarea>
              <p>You can paste theme option backup data.</p>
              <p><input type="button" value="Import This Data" onclick="px_to_import_export('<?php echo home_url()?>', '<?php echo get_template_directory_uri()?>')" /></p>
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
<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/admin/bootstrap.min.css">
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/bootstrap-3.0.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/select.js"></script> 
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/functions.js"></script> 
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery.validate.metadata.js"></script> 
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery.validate.js"></script> 
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/ddaccordion.js"></script> 
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
            //jQuery(".categoryitems").hide();
            jQuery("."+link).addClass('active');
            jQuery("."+link) .parent("ul").show().prev().addClass("openheader");
      
  }
        jQuery(document).ready(function() {
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
               // jQuery(".menuheader.expandable") .removeClass('openheader');
                //jQuery(".categoryitems").hide();
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
                            <td class="centr"> <a onclick="javascript:return confirm(\'Are you sure! You want to delete this\')" href="javascript:px_div_remove('+counter_sidebar+')">Del</a> </td> \
                        </tr>');
                jQuery("#sidebar_input").val("");
            }
        }
		var counter_newsticker = 0;
		 function px_add_newsticker(){
            counter_newsticker++;
            var newsticker_input = jQuery("#newsticker_input").val();
            if ( newsticker_input != "" ) {
                jQuery("#newsticker_area").append('<tr id="'+counter_sidebar+'"> \
                            <td><input type="hidden" name="newsticker[]" value="'+newsticker_input+'" />'+newsticker_input+'</td> \
                            <td class="centr"> <a onclick="javascript:return confirm(\'Are you sure! You want to delete\')" href="javascript:px_div_remove('+counter_newsticker+')">Del</a> </td> \
                        </tr>');
                jQuery("#newsticker_input").val("");
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
