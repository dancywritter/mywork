<?php
	get_header(); 
 	global  $cs_theme_option; 
 ?>
     	<!-- Page Contents Start -->
<div class="span12">
        	<!-- for_o_for Start -->
        	<div class="for_o_for">
                <h1 class="heading-color">404</h1>
				<div class="navigation_right">
					<header class="heading_top">
						<h6 class="colr"><?php _e('Page not found','OneLife')?>&nbsp;</h6>
						<h6><?php if($cs_theme_option['trans_switcher']== "on"){ echo _e('It seems we can not find what you are looking for.','OneLife');}else{ echo $cs_theme_option['trans_content_404']; } ?></h6>
					</header>
					<div class="widget_search">
                	<form id="searchform" method="get" action="<?php echo home_url()?>"  role="search">
						<input name="s" id="searchinput" value="<?php _e('Search for:', 'OneLife'); ?>"
						onFocus="if(this.value=='<?php _e('Search for:', 'OneLife'); ?>') {this.value='';}"
						onblur="if(this.value=='') {this.value='<?php _e('Search for:', 'OneLife'); ?>';}" type="text" />
						<input type="submit" id="searchsubmit"  value="" />
					</form>
                	</div>
                    <nav class="navigation">
						<?php //cs_navigation('main-menu', '404'); ?>
                    </nav>
				</div>
			</div>
			<!-- for_o_for End -->
  		</div>
		<!-- Page Contents End -->
<?php get_footer(); ?>