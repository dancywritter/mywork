<?php
	get_header(); 
 	global  $cs_theme_option; 
	
?>
<div class="col-md-12">
<!-- 404 Page Strat -->
<div class="pagenone">
      <span class="fa-stack fa-lg">
  <i class="fa fa-circle fa-stack-2x"></i>
  <i class="fa fa-exclamation-triangle fa-stack-1x fa-inverse"></i>
</span>
	<h3>404 <?php _e('Error','Rocky')?>. <?php _e('Page not found','Rocky')?></h3>
	<h4><?php if($cs_theme_option['trans_switcher']== "on"){ echo _e('It seems we can not find what you are looking for.','Rocky');}else{ echo $cs_theme_option['trans_content_404']; } ?></h4>
	<!-- Password Protected Strat -->
	<div class="password_protected">               
		<?php get_search_form(); ?>
	</div>
	<!-- Password Protected End -->
</div>
<!-- 404 Page End -->
</div>
					
<?php get_footer(); ?>