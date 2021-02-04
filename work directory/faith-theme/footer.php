			<?php 
                global $cs_theme_option;
            ?>  
               <!-- Twitter Widget -->
             <?php
                  if(is_home() || is_front_page()){
                      if(isset($cs_theme_option['footer_tweet_area']) and $cs_theme_option['footer_tweet_area'] == "on"){
                          echo '<div class="col-md-12">';
                           cs_footer_tweets();
                          echo '</div>';
                      }
                  }
              ?>
              <!-- Twitter Widget Close -->
              </div>
            <!-- Row End -->
        </div>
	</div>
    <!-- Content Section End -->
    <div class="clear"></div>
               <!-- Footer Widgets Start -->
             <div id="footer-widgets">
                <!-- Container Start -->
                <div class="container">
                	<div class="row">
                        <div class="col-md-12">
                            <?php  
								if(isset($cs_theme_option['footer_socialicon']) and $cs_theme_option['footer_socialicon'] == 'on')
								{ 
									cs_social_network();
								}
								if(isset($cs_theme_option['footer_mailchimp']) and $cs_theme_option['footer_mailchimp'] == 'on')
								{ 
									echo cs_custom_mailchimp();
								}  
							?>
                            <a class="back-to-top" id="btngotop" href="">
                			<span class="cs-bgcolr"><i class="fa fa-long-arrow-up"></i>Top</span>
           				 </a>
                         </div>
                    </div>
                </div>
                <!-- Container End -->
                <footer id="footer">
                    <div class="container">
                    	<p class="copright">
						<?php if(isset($cs_theme_option['footer_logo']) and $cs_theme_option['footer_logo'] <> ''){?>
 	                            <a href="<?php echo home_url(); ?>">
    	                            <img src="<?php echo $cs_theme_option['footer_logo']; ?>" alt="<?php echo bloginfo('name'); ?>">        
        	                    </a>
                         <?php }elseif(!isset($cs_theme_option)){ 
   						?>
 	                            <a href="<?php echo home_url(); ?>">
    	                            <img src="<?php echo get_template_directory_uri();?>/images/footer-logo.png" alt="<?php echo bloginfo('name'); ?>">        
        	                    </a>
 						<?php }?>
                        
                            <?php 
								if(isset($cs_theme_option['copyright']) and $cs_theme_option['copyright'] <> ''){
									echo do_shortcode(htmlspecialchars_decode($cs_theme_option['copyright'])); 
								}else{ 
									 echo "&copy;".gmdate("Y");
								?>
                            		<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'Faith' ) ); ?>">
										<?php echo get_option('blogname');  ?>
                                    </a>
                                     Wordpress All rights reserved
                            <?php }?> 
							<?php if(isset($cs_theme_option['powered_by'])){ echo do_shortcode(htmlspecialchars_decode($cs_theme_option['powered_by'])); } ?>
                         
                         </p>
                         
                     </div>
                </footer>
              </div>
            <!-- Footer Start -->
      <div class="clear"></div>
</div>
<!-- Wrapper End -->
<!-- Modal -->
<div class="modal fade cs-donation-form" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
     <?php if(isset($cs_theme_option['paypal_currency_sign'])){$cs_currency=$cs_theme_option['paypal_currency_sign'];}else{ $cs_currenc = '$';}?>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <h2><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('I wish to make a donation','Faith'); }else{ echo $cs_theme_option['trans_other_donation_title']; } ?></h2>
        <ul>
            <li><label><?php echo $cs_currency;?>5 <input type="radio" name="donate"></label></li>
            <li><label><?php echo $cs_currency;?>10 <input type="radio" name="donate"></label></li>
            <li><label><?php echo $cs_currency;?>15 <input type="radio" name="donate"></label></li>
            <li><label><?php echo $cs_currency;?>50 <input type="radio" name="donate"></label></li>
            <li><label><?php echo $cs_currency;?>100 <input type="radio" name="donate"></label></li>
        </ul>
        <script>
        jQuery(document).ready(function($) {
            jQuery(".cs-donation-form ul li label") .click(function(event) {
                /* Act on the event */
                var a = jQuery(this).text().substring(1);
                  jQuery(".cs-donation-form .modal-footer label input") .val(a)
                 jQuery(".cs-donation-form ul li label").removeClass("cs-active");
                 jQuery(this).addClass('cs-active');
                 return false;
            });
        });
        </script>
      </div>
      <div class="modal-footer">
        <span class="opt-or"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('or','Faith'); }else{ echo $cs_theme_option['trans_other_or']; } ?></span>
          <?php cs_donate_button($cs_currency); ?>
      </div>
    </div>
  </div>
</div>
<?php 
	cs_footer_settings();
	wp_footer();	
?>
</body>
</html>