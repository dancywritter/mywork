<?php
	get_header(); 
 	global  $cs_theme_option; 
?>
<!-- 404 Page Strat -->
<div class="col-md-12">
    <div class="pagenone">
        <span class="icon-warning-sign icon-4"></span>
        <h1><?php _e('Error','Spikes')?>. <?php _e('Page not found','Spikes')?></h1>
        <h5><?php if($cs_theme_option['trans_switcher']== "on"){ echo _e('It seems we can not find what you are looking for.','Spikes');}else{ echo $cs_theme_option['trans_content_404']; } ?></h4>
        <div class="password_protected">
            <?php get_search_form(); ?>
        </div>
    </div>
<!-- 404 Page End -->
</div>
<?php get_footer(); ?>