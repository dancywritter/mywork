			   
             </div>
            <!-- Row End -->
        </div>
            <div class="clear"></div>
        <!-- Container End -->
	</div>
    <!-- Content Section End -->
    <div class="clear"></div>
    
		<?php global $cs_theme_option;
			if($cs_theme_option['show_partners'] == "all"){
				echo cs_show_partner();
			}elseif($cs_theme_option['show_partners'] == "home"){
				if(is_home() || is_front_page()){
					echo cs_show_partner();
				}
			} 
		?>   
        <div class="clear"></div>
            <!-- Footer Widgets Start -->
             <div id="footer-widgets" class="fullwidth">
                <!-- Container Start -->
                <div class="container">
                    <!-- Footer Widgets Start -->
                    <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-widget')) : ?><?php endif; ?>
                    <!-- Footer Widgets End -->
                </div>
                <!-- Container End -->
                <footer id="footer">
                	<div class="container">
                        <p class="copright float-left">
                            <?php echo do_shortcode(htmlspecialchars_decode($cs_theme_option['copyright'])); ?> <?php echo do_shortcode(htmlspecialchars_decode($cs_theme_option['powered_by'])); ?>
                        </p>
                        <div class="followus float-right">
                            <h3>Follow Us</h3>
                            <?php cs_social_network(); ?>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- Footer Start -->
<div class="clear"></div>
    <!-- Login Inn Start -->
    <div class="modal hide fade login_inn webkit " id="loginbox" role="dialog">
    	<button type="button" class="close backcolorhover" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>
		<div class="header webkit">
            <header>
                <h3 class="heading-color"><?php _e('Log In','AidReforms');?></h3>
            </header>
             <form class="webkit" action="<?php echo home_url(); ?>/wp-login.php" method="post">
				<ul>
                    <li>
                        <span><i class="icon-user"></i></span>
                        <input name="log" id="user_login" value="<?php _e('Username','AidReforms'); ?>" onfocus="if(this.value=='<?php _e('Username','AidReforms'); ?>') {this.value='';}" onblur="if(this.value=='') {this.value='<?php _e('Username','Lovepray'); ?>';}" type="text" />           
                    </li>
                    <li>
                        <span class="password"><i class="icon-key"></i></span>
			        	<input name="pwd" value="password" onfocus="if(this.value=='password') {this.value='';}" onblur="if(this.value=='') {this.value='password';}" type="password" class="bar" />
                    </li>
                    <li>
                        <input type="hidden" name="redirect_to" value="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" />                                        
                        <label>
                        	<input name="rememberme" value="forever" id="rememberme" type="checkbox" class="left" />
							<?php _e('Remember Me', 'AidReforms'); ?>
                        </label>
					</li>
                    <li>
                        <span class="log"><i class="icon-signin"></i></span>
                        <input class="backcolr" type="submit" value="<?php _e('Log In','AidReforms');?>">
                    </li>
                </ul>
            </form>
        </div>
        <div class="footer webkit">
           <a class="colrhover" href="<?php echo home_url() ; ?>/wp-login.php?action=lostpassword"> <i class="icon-question-sign"></i><?php _e('Lost Password','AidReforms'); ?>?</a>
            <div class="sign">
            	  <?php 	
				  	if ( get_option("users_can_register") == 1 and !is_user_logged_in() ) { ?>
						<form action="<?php echo home_url() ; ?>/wp-login.php?action=register">
                            <label><?php _e('Register', 'AidReforms')?></label>
                            <button class="texttransform backcolrhover transition"><?php echo _e('Signup','AidReforms'); ?></button>
                        </form>
					<?php }?>	
                  
              </div>
        </div>
    </div>
    <!-- Login Inn End -->
    <div class="clear"></div>
</div>
<!-- Wrapper End -->
<?php 
	cs_footer_settings();
	wp_footer();	
?>
</body>
</html>