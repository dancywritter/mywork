<?php
	get_header(); 
 	global  $cs_theme_option; 
 ?>
      	<!-- Page Contents Start -->
		<div class="span12">
        	<!-- PageNone Start -->
        	<div class="for_o_for">
                <h1 class="transform colr">404 <?php _e('Error','Bolster')?></h1>
                <h2><?php if($cs_theme_option['trans_switcher']== "on"){ echo _e('It seems we can not find what you are looking for.','Bolster');}else{ echo $cs_theme_option['trans_content_404']; } ?></h2>
                <div class="widget_search">
				<div>
                	<form id="searchform" method="get" action="<?php echo home_url()?>"  role="search">
						<input name="s" id="searchinput" value="<?php _e('Search for:', 'Bolster'); ?>"
						onFocus="if(this.value=='<?php _e('Search for:', 'Bolster'); ?>') {this.value='';}"
						onblur="if(this.value=='') {this.value='<?php _e('Search for:', 'Bolster'); ?>';}" type="text" />
						<button id="searchsubmit"><em class="fa fa-search"></em></button>
					</form>
				</div>
				</div>
            </div>
			<!-- PageNone End -->
  		</div>
		<!-- Page Contents End -->
<?php get_footer(); ?>