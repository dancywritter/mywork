<form id="searchform" method="get" action="<?php echo home_url()?>"  role="search">
	<div>
	<input name="s" id="searchinput" value="<?php _e('Search for:', 'Bolster'); ?>"
    onFocus="if(this.value=='<?php _e('Search for:', 'Bolster'); ?>') {this.value='';}"
    onblur="if(this.value=='') {this.value='<?php _e('Search for:', 'Bolster'); ?>';}" type="text" />
    <button><em class="fa fa-search"></em></button>
	</div>
</form>
