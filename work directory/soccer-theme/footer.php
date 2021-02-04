                </div>
            </div> 
        </div>
    	<!-- Inner Main -->
    </div>
    <!-- Twitter Widget -->
    <?php
		global $px_theme_option;
 		if(isset($px_theme_option['twitter_name'])){ $username = $px_theme_option['twitter_name']; }else{ $username =''; }
 		if(isset($px_theme_option['tweets_number'])){ $numoftweets = $px_theme_option['tweets_number']; }else{ $numoftweets =''; }
 	   	px_footer_tweets($px_theme_option['twitter_name'],$px_theme_option['tweets_number']); 
	?>
    <!-- Twitter Widget Close -->
    <!-- Our Partners -->
    <?php 
		echo px_show_partner();
 	?>
    <!-- Our Partners Close -->
    <footer id="footer">
        <p class="coptyright">
			<?php echo do_shortcode(htmlspecialchars_decode($px_theme_option['copyright'])); ?>  
			<?php echo do_shortcode(htmlspecialchars_decode($px_theme_option['powered_by'])); ?>
        </p>
        <?php
			if($px_theme_option['footer_social_icons'] == 'on'){
				px_social_network();
			}
		?>
     	<a href="" class="btn btngotop"><i class="fa fa-arrow-circle-o-up"></i></a>
    </footer>
</div>
<!-- Wrapper End -->
<?php 
px_footer_settings();
wp_footer();?>
</body>
</html>
