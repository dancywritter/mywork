			<?php global $cs_theme_option;  ?>
             </div>
            <!-- Row End -->
        </div>
        <!-- Container End -->
	</div>
    <!-- Content Section End -->
    <?php
		wp_reset_query();
		$post_type = ''; 
		$switch_footer_widgets = '';
		if(is_page() or is_single()){
			$post_type = cs_post_type($post->ID);
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
        	<div id="footer-widgets">
                <!-- Container Start -->
                <div class="container">
                    <!-- Footer Widgets Start -->
                    <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-widget')) : ?><?php endif; ?>
                    <!-- Footer Widgets End -->
                </div>
                <!-- Container End -->
            </div>
    <?php }?>
    <div class="clear"></div>
    <footer style=" <?php if(isset($cs_theme_option['footer_bg_img']) && $cs_theme_option['footer_bg_img'] <> ''){?>background: url(<?php echo $cs_theme_option['footer_bg_img'].') ';} if(isset($cs_theme_option['footer_bg_color']) && $cs_theme_option['footer_bg_color'] <> ''){?>background-color: <?php echo $cs_theme_option['footer_bg_color'].' !important;';}?>">
    <!-- Container Start -->
    <div class="container"> 

      <!-- Bottom Footer Start -->
      <div class="bottom-footer"> 
        <!-- Footer Head Start -->
        <div class="footer_head webkit"> 
          <!-- Logo Start -->
           <div class="logo"> <a href="<?php echo home_url(); ?>"><img src="<?php echo $cs_theme_option['footer_logo'];?>" alt=""></a> </div>
          <!-- Logo End --> 
          <!-- Footnav Start -->
          <nav class="footnav">
            <?php  cs_navigation('footer-menu', 'footer-menu');?>
          </nav>
          <!-- Footnav End --> 
        </div>
        <!-- Footer Head End -->
        <div class="copyright">
          <p><?php echo htmlspecialchars_decode($cs_theme_option['copyright']); ?> <?php echo htmlspecialchars_decode($cs_theme_option['powered_by']); ?></p>
          <?php cs_social_network();?>
        </div>
      </div>
      <!-- Bottom Footer End --> 
    </div>
    <!-- Container End --> 
  </footer>
    <!-- Footer End -->
	<div class="clear"></div>
 </div>
<!-- Wrapper End --> 

<?php 
cs_box_login();
wp_footer();
?>
</body>
</html>