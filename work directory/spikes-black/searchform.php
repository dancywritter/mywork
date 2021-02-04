<form id="searchform" method="get" action="<?php echo home_url()?>"  role="search">
    <label>
       <input name="s" id="searchinput" value="<?php _e('Search for:', 'Spikes'); ?>"
    onFocus="if(this.value=='<?php _e('Search for:', 'Spikes'); ?>') {this.value='';}"
    onblur="if(this.value=='') {this.value='<?php _e('Search for:', 'Spikes'); ?>';}" type="text" />
    </label>
    <label class="search-icon">
    	<input type="submit" id="searchsubmit" class="backcolr"  value="<?php _e('Search', 'Spikes'); ?>" />
    </label>
</form>

