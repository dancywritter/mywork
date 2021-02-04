jQuery(document).ready(function(){	
	jQuery('#slider').cycle('goto','3');
	//jQuery('#slider').hide();
	
	 jQuery('#slider').on('cycle-before',function(event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag) {
	jQuery(this) .find('.story_text').animate({"top":"50px","opacity":"0"},300).fadeOut(300);
	});
	 jQuery('#slider').on('cycle-after',function(event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag) {
		 
	jQuery(incomingSlideEl).find(".story_text").show().animate({"top":"90px",opacity:"1"},300);
	});
	jQuery('#slider article.tip').click(function(e, opts){
		var index = jQuery('#slider').data('cycle.API').getSlideIndex(this);
	
		  jQuery('#slider').cycle(index);
	});
});