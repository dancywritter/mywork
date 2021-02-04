<?php global $cs_theme_option;?>			   
             </div>
            <!-- Row End -->
        </div>
	</div>
    <!-- Content Section End -->
 
    <?php $sidebarr = wp_get_sidebars_widgets();
			if(count($sidebarr['footer-widget-1'])>0 || count($sidebarr['footer-widget-2'])>0){
				?>
        <div id="footer-widgets" <?php if(isset($cs_theme_option['footer_widgetarea_bg_color']) and $cs_theme_option['footer_widgetarea_bg_color'] <> ''){?> style="background-color:<?php echo $cs_theme_option['footer_widgetarea_bg_color'];?>;"<?php }?>>
            <div class="container">
                <div class="row">
                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-widget-1') ) : endif; ?>
                <!-- Bottom Widget  -->
                
                 <?php $sidebarr = wp_get_sidebars_widgets();
                        
                    if(count($sidebarr['footer-widget-2'])>0){
                    ?>
                    <div id="footer-widgets-bottom" <?php if(isset($cs_theme_option['footer_bg_color']) and $cs_theme_option['footer_bg_color'] <> ''){?> style="background-color:<?php echo $cs_theme_option['footer_bg_color'];?>;"<?php }?>>
    
                        <div class="cs-bottom-wrapp">
                                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-widget-2') ) : endif; ?>
                            </div></div>
                <!-- Bottom Widget  Close -->
                <?php }?>
                </div>
            </div>
        </div>
    <?php }?>
    
    
    
    <footer id="footer" <?php if(isset($cs_theme_option['footer_bg_color']) and $cs_theme_option['footer_bg_color'] <> ''){?> style="background-color:<?php echo $cs_theme_option['footer_bg_color'];?>;"<?php }?>>
        <div class="container">
        	<p class="cs-copyright">
				<?php 
                    if(isset($cs_theme_option['copyright']) and $cs_theme_option['copyright'] <> ''){
                        echo do_shortcode(htmlspecialchars_decode($cs_theme_option['copyright'])); 
                    } else {echo '&copy;'.gmdate("Y")." ".get_option("blogname")." Wordpress All rights reserved.";}?> 
                <?php if(isset($cs_theme_option['powered_by'])){ echo do_shortcode(htmlspecialchars_decode($cs_theme_option['powered_by'])); } ?>
             
             </p>
        </div>
    </footer> 
    <div class="clear"></div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
               <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button"><i class="fa fa-times-circle"></i></button>
                <h2><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Donate Now','WeStand');}else{ echo $cs_theme_option['cause_donate']; } ?></h2>
              </div>
              <div class="modal-body">
                <ul>
                    <?php  if(isset($cs_theme_option['header_support_button_url3']) and $cs_theme_option['header_support_button_url3'] <> ''){
							// slider slug to id start
								$args=array(
								  'name' => (string)$cs_theme_option['header_support_button_url3'],
								  'post_type' => 'cs_cause',
								  'post_status' => 'publish',
								  'showposts' => 1,
								);
								$get_posts = get_posts($args);
								if($get_posts){
									$cause_id = (int)$get_posts[0]->ID;
								}
							if(isset($cause_id) and $cause_id <> ''){	
								$cs_cause_metainfo = get_post_meta($cause_id, "cs_cause_meta", true);
								if ( $cs_cause_metainfo <> "" ) {
									$cs_xmlObject_metainfo = new SimpleXMLElement($cs_cause_metainfo);
								}
								
						?>
                            <li>
                                <i class="fa <?php echo $cs_theme_option['header_support_button_icon3'];?> cs-colr"></i>
                                <h4 class="cs-colrhvr"><?php echo $cs_theme_option['header_support_button_title3'];?></h4>
                              	<a href="#" class="btn cs-btn-donate cs-bgcolrhvr" data-toggle="modal" data-target="#myModal2"><?php echo $cs_theme_option['header_support_button_text3'];?></a>
                            </li>
					<?php }
					
					}?>
                    <?php  if(isset($cs_theme_option['header_support_button_url1']) and $cs_theme_option['header_support_button_url1'] <> ''){?>
                    <li>
                        <i class="fa <?php echo $cs_theme_option['header_support_button_icon1'];?> cs-colr"></i>
                        <h4 class="cs-colrhvr"><?php echo $cs_theme_option['header_support_button_title1'];?></h4>
                        <a href="<?php echo $cs_theme_option['header_support_button_url1'];?>" class="btn cs-btn-donate cs-bgcolrhvr"><?php echo $cs_theme_option['header_support_button_text1'];?></a>
                    </li>
					<?php }?>
                     <?php  if(isset($cs_theme_option['header_support_button_url2']) and $cs_theme_option['header_support_button_url2'] <> ''){?>
                    <li>
                        <i class="fa <?php echo $cs_theme_option['header_support_button_icon2'];?> cs-colr"></i>
                        <h4 class="cs-colrhvr"><?php echo $cs_theme_option['header_support_button_title2'];?></h4>
                        <a href="<?php echo $cs_theme_option['header_support_button_url2'];?>" class="btn cs-btn-donate cs-bgcolrhvr"><?php echo $cs_theme_option['header_support_button_text2'];?></a>
                    </li>
					<?php }?>
                   
                </ul>
              </div>
        </div>
    </div>
</div>
<!-- Modal Close -->
<!-- Modal Box-2 -->
<?php if(isset($cs_xmlObject_metainfo->cause_paypal_email) && $cs_xmlObject_metainfo->cause_paypal_email <> ''){
		cs_custom_donate_button($cs_xmlObject_metainfo->cause_paypal_email);
	} else {
		cs_custom_donate_button();
	}?>
<!-- Modal Box-2 Close -->
<!-- Wrapper End -->
<?php 
	cs_footer_settings();
	wp_footer();	
?>
</body>
</html>