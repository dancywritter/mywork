			<?php global $cs_theme_option;  ?>
    		</div>
    	</div>
     </div>
     <!-- Content Section End -->
		<?php
        wp_reset_query();
		$post_type = ''; 
		$switch_footer_widgets = '';
		if(is_page() or is_single()){
			$post_type = cs_post_type($post->ID);
			  if($post_type == "albums"){
				 $post_type = "cs_album";
			 }
			$xml = get_post_meta($post->ID, $post_type, true);
			if($xml <> ''){
			$cs_xmlObject = new SimpleXMLElement($xml);
 				$switch_footer_widgets = $cs_xmlObject->switch_footer_widgets;
			}else{
				$switch_footer_widgets = '';
			}	
		}else{
			$switch_footer_widgets = "on";	
		}
 		if($switch_footer_widgets == "on"){?>
        <!-- Footer Widgets Start -->
        <div id="footer-widgets" class="fullwidth  parallax-fullwidth">
            <div class="container">
                <div class="row">
                    <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-widget')) : ?><?php endif; ?>
                    <!-- Footer Widgets End -->
                </div>
                <!-- Container End -->
            </div>
           </div>
            <!-- Footer Start -->
    <?php }?>
    
    <footer id="footer" class="fullwidth  parallax-fullwidth">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-7">
                        <p class="copyright">
                            <?php echo do_shortcode(htmlspecialchars_decode($cs_theme_option['copyright'])); ?>
                            <?php echo do_shortcode(htmlspecialchars_decode($cs_theme_option['powered_by'])); ?>
                        </p>
                    </div>
                    <div class="col-lg-5 col-md-5">
                        <div class="shareoption float-right">
                            <?php cs_social_network();?>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    
    <!-- Footer End -->
    <div class="clear"></div>
    
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title colr"><?php _e('Log In','Rocky');?></h4>
                </div>
                 
                  <form method="post" action="<?php echo home_url(); ?>/wp-login.php" class="webkit">
				<ul>
                    <li>
                        <span><i class="fa fa-user"></i></span>
                        <input type="text" value="<?php _e('Username','Rocky'); ?>" id="user_login" name="log">           
                    </li>
                    <li>
                        <span class="password"><i class="fa fa-key"></i></span>
			        	<input type="password" class="bar" onblur="if(this.value=='') {this.value='password';}" onfocus="if(this.value=='password') {this.value='';}" value="password" name="pwd">
                    </li>
                    <li>
                        <input type="hidden" name="redirect_to" value="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" />                                            
                        <label>
                        	<input name="rememberme" class="left" type="checkbox" id="rememberme" value="forever">
							<?php _e('Remember Me', 'Rocky'); ?>                        </label>
					</li>
                    <li>
                        <input type="submit" value="<?php _e('Log In','Rocky');?>" class="backcolr">
                    </li>
                </ul>
            </form>
                <div class="footer webkit">
           			<a href="<?php echo home_url() ; ?>/wp-login.php?action=lostpassword" class="colrhover"> <i class="fa fa-question"></i><?php _e('Lost Password','Rocky'); ?>?</a>
           
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>
  <div class="clear"></div>
<!-- /.modal -->
 </div>
<!-- Wrapper End --> 
<?php if (stripos($_SERVER['HTTP_USER_AGENT'], 'MSIE 10')) { ?>
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri();?>/css/ie.css"  />
<?php		}
	wp_footer();
 ?>
 </body>
</html>