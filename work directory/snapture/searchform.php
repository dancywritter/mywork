<form id="searchform" method="get" action="<?php echo home_url()?>"  role="search">
    <label>
       <input name="s" id="searchinput" value="<?php _e('Search for:', 'Snapture'); ?>"
    onFocus="if(this.value=='<?php _e('Search for:', 'Snapture'); ?>') {this.value='';}"
    onblur="if(this.value=='') {this.value='<?php _e('Search for:', 'Snapture'); ?>';}" type="text" />
    </label>
    <label class="search-icon">
    	<input type="submit" id="searchsubmit" class="backcolr"  value="<?php _e('Search', 'Snapture'); ?>" />
    </label>
</form>