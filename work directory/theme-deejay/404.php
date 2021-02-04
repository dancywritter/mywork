<?php
	get_header(); 
 	global  $px_theme_option; 
	
 ?>
<!-- Columns Start - fullwidth -->
    <!-- Page Contents Start -->
    <div class="col-md-12">
        <div class="pagenone">
            <i class="fa fa-warning-sign 4 colr"></i>
            <h1 class="colr"><?php _e('Page not found','Deejay')?></h1>
            
            <h4><?php echo _e('It looks like nothing was found at this location. Maybe try a search?','Deejay'); ?></h4>
            <!-- Password Protected Strat -->
            <div class="password_protected page-404">   
                <form id="searchform" method="get" action="<?php echo home_url()?>"  role="search">
                    <input name="s" id="searchinput" value="<?php _e('Search for:', 'Deejay'); ?>"
                    onFocus="if(this.value=='<?php _e('Search for:', 'Deejay'); ?>') {this.value='';}"
                    onblur="if(this.value=='') {this.value='<?php _e('Search for:', 'Deejay'); ?>';}" type="text" />
                    <input type="submit" id="searchsubmit" class="backcolr" value="<?php _e('Search', 'Deejay'); ?>" />
                </form>            
                
            </div>
            <!-- Password Protected End -->
        </div>
    </div>
    <!-- Page Contents End -->
<?php get_footer(); ?>