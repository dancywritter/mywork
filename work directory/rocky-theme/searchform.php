<form id="searchform" method="get" action="<?php echo home_url()?>"  role="search">
	<input name="s" id="searchinput" value="<?php _e('Search for:', 'Rocky'); ?>"
    onFocus="if(this.value=='<?php _e('Search for:', 'Rocky'); ?>') {this.value='';}"
    onblur="if(this.value=='') {this.value='<?php _e('Search for:', 'Rocky'); ?>';}" type="text" />
    <input type="submit" id="searchsubmit"  value="<?php _e('Search', 'Rocky'); ?>" />
</form>
