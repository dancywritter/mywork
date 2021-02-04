<?php global $cs_theme_option;  
 if($cs_theme_option['show_partners'] == "on" && (is_home() || is_front_page())){
	  				cs_cycleslider_script();
	  				$gal_album_db = '';
					if($cs_theme_option['partner_gallery_name'] <> ''){
						$args=array(
								'name' => $cs_theme_option['partner_gallery_name'],
								'post_type' => 'cs_gallery',
								'post_status' => 'publish',
								'showposts' => 1,
							);
							$get_posts = get_posts($args);
							if($get_posts){
								$gal_album_db = $get_posts[0]->ID;
						
						// galery slug to id end
						$cs_meta_gallery_options = get_post_meta($gal_album_db, "cs_meta_gallery_options", true);
						if($gal_album_db <> '' && $cs_meta_gallery_options <> ''){
						// pagination start
							$cs_xmlObject = new SimpleXMLElement($cs_meta_gallery_options);
								$limit_start = 0;
								$limit_end = count($cs_xmlObject->gallery);
								$count_post = count($cs_xmlObject->gallery);
								if($count_post>0){
								?>
									<div class="clear"></div>
									<div class="col-md-12">
									<!-- Partners Start -->
										<div class="partners">
											<div class="left-area">
											   <?php if($cs_theme_option['partner_gallery_title'] <> ''){?> <header><h2 class="cs-section-title cs-heading-color"><?php echo $cs_theme_option['partner_gallery_title']; ?></h2></header><?php }?>
												<div class="center">
													<a id="prev588" href="#" class="prev-btn bordercolr colr backcolrhover"><i class="fa fa-angle-left fa-1x"></i></a>
													<a id="next588" href="#" class="next-btn bordercolr colr backcolrhover"><i class="fa fa-angle-right fa-1x"></i></a>
												</div>
											</div>
											<div class="right-area">
												<div class="cycle-slideshow"
												data-cycle-timeout=4000
												data-cycle-fx=carousel
												data-cycle-slides="article"
												
												data-cycle-carousel-fluid="false"
												data-allow-wrap="true"
													data-cycle-next="#next588"
													data-cycle-prev="#prev588">
													<?php
													if ( $cs_meta_gallery_options <> "" ) {
														for ( $i = $limit_start; $i < $limit_end; $i++ ) {
															$path = $cs_xmlObject->gallery[$i]->path;
															$title = $cs_xmlObject->gallery[$i]->title;
															$description = $cs_xmlObject->gallery[$i]->description;
															$social_network = $cs_xmlObject->gallery[$i]->social_network;
															$use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;
															$video_code = $cs_xmlObject->gallery[$i]->video_code;
															$link_url = $cs_xmlObject->gallery[$i]->link_url;
															$image_url = cs_attachment_image_src($path, 0, 0);
															if($image_url <> ''){
															?>
															<article>
																<figure><a href="#"><img src="<?php echo $image_url;?>" alt=""></a></figure>
															</article>
												 <?php }}}?>
											</div>  
										</div>
									  </div>
								 <!-- Partners End -->
							<div class="clear"></div>
							</div>
				<?php }}}}}?>
        	<!-- Col Md 12 End -->
           
        </div>
        <!-- Row End -->
    </div>
    <!-- Container End -->
 </div>
<!-- Content Section End -->
	<?php if(isset($cs_theme_option['footer_widget']) && $cs_theme_option['footer_widget'] == 'on'){?>
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
    <!-- Footer Start -->
<footer>
    <!-- Copyright Start -->
    <div class="copyright">
        <!-- Container Start -->
        <div class="container">
            <p><?php echo do_shortcode(htmlspecialchars_decode($cs_theme_option['copyright'])); ?> <?php echo do_shortcode(htmlspecialchars_decode($cs_theme_option['powered_by'])); ?></p>
            <?php cs_social_network();?>
            <a id="back-top" class="gotop" href="#"><i class="fa fa-angle-up fa-2x"></i></a>
        </div>
        <!-- Container End -->
    </div>
    <!-- Copyright End -->
</footer>
    <!-- Footer End -->
        <!-- Footer End -->
<div class="clear"></div>
</div>
<!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h4 class="modal-title colr"><?php _e('Log In','Spikes');?></h4>
                </div>
                 
                  <form method="post" action="<?php echo home_url(); ?>/wp-login.php" class="webkit">
				<ul>
                    <li>
                        <span><i class="fa fa-user"></i></span>
                        <input type="text" value="<?php _e('Username','Spikes'); ?>" id="user_login" name="log">           
                    </li>
                    <li>
                        <span class="password"><i class="fa fa-key"></i></span>
			        	<input type="password" class="bar" onblur="if(this.value=='') {this.value='password';}" onfocus="if(this.value=='password') {this.value='';}" value="password" name="pwd">
                    </li>
                    <li>
                        <input type="hidden" name="redirect_to" value="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" />                                            
                        <label>
                        	<input name="rememberme" class="left" type="checkbox" id="rememberme" value="forever">
							<?php _e('Remember Me', 'Spikes'); ?>                        </label>
					</li>
                    <li>
                        <input type="submit" value="<?php _e('Log In','Spikes');?>" class="backcolr">
                    </li>
                </ul>
            </form>
                <div class="footer webkit">
           			<a href="<?php echo home_url() ; ?>/wp-login.php?action=lostpassword" class="colrhover"> <i class="fa fa-question"></i><?php _e('Lost Password','Spikes'); ?>?</a>
           
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>
  <div class="clear"></div>
<!-- /.modal -->
 </div>
<!-- Wrapper End --> 
<?php
	cs_footer_settings();
	wp_footer();
 ?>
</body>
</html>