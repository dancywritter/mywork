<?php
	get_header(); 
 	global  $cs_theme_option; 
	
 ?>
<!-- Columns Start - fullwidth -->
    <!-- Page Contents Start -->
    <div class="col-md-12">
        <div class="pagenone">
            <i class="fa fa-warning colr"></i>
            <h1 class="colr"><?php _e('Page not found','WeStand')?></h1>
            <h4>
			<?php 
				if(isset($cs_theme_option['trans_switcher']) and $cs_theme_option['trans_switcher']== "on"){ 
					echo _e('It seems we can not find what you are looking for.','WeStand');
				}elseif(isset($cs_theme_option['trans_content_404'])){ 
					echo $cs_theme_option['trans_content_404']; 
				}else{ 
					echo _e('It seems we can not find what you are looking for.','WeStand');
				} ?>
            </h4>
            <!-- Password Protected Strat -->
            <div class="password_protected">   
               <?php get_search_form(); ?>
            </div>
            <!-- Password Protected End -->
        </div>
    </div>
    <!-- Page Contents End -->
<?php get_footer(); ?>