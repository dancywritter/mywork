<form id="searchform" method="get" action="<?php echo home_url()?>"  role="search">
	<input name="s" id="searchinput" value="<?php _e('Search for:', 'OneLife'); ?>"
    onFocus="if(this.value=='<?php _e('Search for:', 'OneLife'); ?>') {this.value='';}"
    onblur="if(this.value=='') {this.value='<?php _e('Search for:', 'OneLife'); ?>';}" type="text" />
    <input type="submit" id="searchsubmit"  value="" />
</form>
