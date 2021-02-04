/*
 SelectNav.js (v. 0.1)
 Converts your <ul>/<ol> navigation into a dropdown list for small screens
 https://github.com/lukaszfiszer/selectnav.js
*/

window.selectnav=function(){return function(p,q){var a,h=function(b){var c;b||(b=window.event);b.target?c=b.target:b.srcElement&&(c=b.srcElement);3===c.nodeType&&(c=c.parentNode);c.value&&(window.location.href=c.value)},k=function(b){b=b.nodeName.toLowerCase();return"ul"===b||"ol"===b},l=function(b){for(var c=1;document.getElementById("selectnav"+c);c++);return b?"selectnav"+c:"selectnav"+(c-1)},n=function(b){g++;var c=b.children.length,a="",d="",f=g-1;if(c){if(f){for(;f--;)d+=r;d+=" "}for(f=0;f<
c;f++){var e=b.children[f].children[0];if("undefined"!==typeof e){var h=e.innerText||e.textContent,i="";j&&(i=-1!==e.className.search(j)||-1!==e.parentElement.className.search(j)?m:"");s&&!i&&(i=e.href===document.URL?m:"");a+='<option value="'+e.href+'" '+i+">"+d+h+"</option>";t&&(e=b.children[f].children[1])&&k(e)&&(a+=n(e))}}1===g&&o&&(a='<option value="">'+o+"</option>"+a);1===g&&(a='<select class="selectnav" id="'+l(!0)+'">'+a+"</select>");g--;return a}};if((a=document.getElementById(p))&&k(a)){document.documentElement.className+=
" js";var d=q||{},j=d.activeclass||"active",s="boolean"===typeof d.autoselect?d.autoselect:!0,t="boolean"===typeof d.nested?d.nested:!0,r=d.indent||"\u2192",o=d.label||"- Navigation -",g=0,m=" selected ";a.insertAdjacentHTML("afterend",n(a));a=document.getElementById(l());a.addEventListener&&a.addEventListener("change",h);a.attachEvent&&a.attachEvent("onchange",h)}}}();
(function(d){var p={},e,a,h=document,i=window,f=h.documentElement,j=d.expando;d.event.special.inview={add:function(a){p[a.guid+"-"+this[j]]={data:a,$element:d(this)}},remove:function(a){try{delete p[a.guid+"-"+this[j]]}catch(d){}}};d(i).bind("scroll resize",function(){e=a=null});!f.addEventListener&&f.attachEvent&&f.attachEvent("onfocusin",function(){a=null});setInterval(function(){var k=d(),j,n=0;d.each(p,function(a,b){var c=b.data.selector,d=b.$element;k=k.add(c?d.find(c):d)});if(j=k.length){var b;
if(!(b=e)){var g={height:i.innerHeight,width:i.innerWidth};if(!g.height&&((b=h.compatMode)||!d.support.boxModel))b="CSS1Compat"===b?f:h.body,g={height:b.clientHeight,width:b.clientWidth};b=g}e=b;for(a=a||{top:i.pageYOffset||f.scrollTop||h.body.scrollTop,left:i.pageXOffset||f.scrollLeft||h.body.scrollLeft};n<j;n++)if(d.contains(f,k[n])){b=d(k[n]);var l=b.height(),m=b.width(),c=b.offset(),g=b.data("inview");if(!a||!e)break;c.top+l>a.top&&c.top<a.top+e.height&&c.left+m>a.left&&c.left<a.left+e.width?
(m=a.left>c.left?"right":a.left+e.width<c.left+m?"left":"both",l=a.top>c.top?"bottom":a.top+e.height<c.top+l?"top":"both",c=m+"-"+l,(!g||g!==c)&&b.data("inview",c).trigger("inview",[!0,m,l])):g&&b.data("inview",!1).trigger("inview",[!1])}}},250)})(jQuery);
jQuery.easing['easeOutCubic'] = function (x, t, b, c, d) {
    return c*((t=t/d-1)*t*t + 1) + b;
}
jQuery.easing['easeInOutBack'] = function (x, t, b, c, d, s) {
    if (s == undefined) s = 1.70158;
    if ((t /= d / 2) < 1) return c / 2 * (t * t * (((s *= (1.525)) + 1) * t - s)) + b;
    return c / 2 * ((t -= 2) * t * (((s *= (1.525)) + 1) * t + s) + 2) + b;
};
jQuery('.modal').appendTo("body").modal('hide');

jQuery(document).ready(function(){	
	jQuery("#stickyarea").hide();
	selectnav('menus', {
	  label: 'Menu',
	  nested: true,
	  indent: '-'
	});
});


jQuery(document).ready(function(){
	jQuery('a.icon-comment').click(function() {

	jQuery('html,body').animate({ scrollTop: jQuery(this.hash).offset().top}, 2000);
	
	return false;
	
	e.preventDefault();
	
	});
	
	jQuery("html").niceScroll({styler:"fb",cursorcolor:"#000", horizrailenabled:false, cursorwidth:"10px"});
	
	jQuery(".portfolio article").hover(function(){jQuery(this).find(".active_pro").stop(true,true).slideDown(300)},function(){jQuery(this).find(".active_pro").stop(true,true).slideUp(300)});
	
	jQuery(".sub-menu").parent("li").addClass("parentIcon");
	jQuery("[data-placement-tooltip='tooltip']").tooltip();
	selectnav('menus', {
	  label: 'Menu',
	  nested: true,
	  indent: '-'
	});
	// fade in #back-top
	jQuery(function () {
		jQuery('#back-top, #scrolling-top').click(function () {
			jQuery('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
		
	});
/*	
	jQuery("figure").on("inview", function (e, t) {
        if (t) {
            jQuery(this).addClass("viewme")
        }
    });
	*/
	jQuery(".navig").scrollToFixed();
	
 	// Search Start
	jQuery("a.plus").click(function () {
        var e = jQuery(this).attr("href");
        jQuery(e).toggleClass("showit");
        return false
    });
	jQuery(".sorted-link").click(function(){
		jQuery(".sortby ul").toggle();
	});
	  jQuery('html').click(function() {
		jQuery(".sortby ul").hide();
	});
	jQuery('.sortby').click(function(event){
    	event.stopPropagation();
	});
	 
	// Search End
});
// sidebar fix on portfolio

// END sidebar fix on portfolio
function sticky_menu(){
	// js
	jQuery("#stickyarea") .appendTo("header.mainheader");
	var bgc = jQuery(".main-menu") .css('background-color');
	jQuery("#stickyarea") .css({"background":bgc});
	//jQuery(".logo a") .clone() .appendTo('#logobox-stick');
	jQuery("header.mainheader .navigation").clone().appendTo('#menubox-stick');
	jQuery(window).scroll(function() {
		// Act on the event 
		var h = jQuery("header.mainheader") .height();
		var ws = jQuery(window).scrollTop();
		if(ws > h){
			jQuery("#stickyarea").slideDown(200);
		}else {
			jQuery("#stickyarea").slideUp(200);
		}
	});
 	// js close	
}



// Ride the carousel...
jQuery(document).ready(function() {
	jQuery('audio,video').mediaelementplayer();
	// jQuery(".accordion .accordion-group:first-child") .find("a.accordion-toggle") .addClass("active");
	jQuery('.accordion').on('show', function (e) {
         jQuery(e.target).prev('.accordion-heading').find('.accordion-toggle').addClass('active');
    });
    
    jQuery('.accordion').on('hide', function (e)  {
        jQuery(this).find('.accordion-toggle').not(jQuery(e.target)).removeClass('active');
    });
	jQuery(window).resize(function(){
	jQuery(".parallaxbg").each(function(){
	var w = jQuery(window).width();
	var m = jQuery(this).parent("div").width();
	var e = w-m;
	jQuery(this).css({"position":"relative","left":-(e/2),"top":0,"width":w }) 
	}); 
	});
	para()
	jQuery(window).resize(function(){
	para()
	}); 
/*	function para() {
	 // jQuery(".parallax-full-width").each(function(){
	 //  var w = jQuery(window).width();
	 //  var m = jQuery(this).parent("div").width();
	 //  var e = w-m;
	 //  if(e > 0){
	 //   jQuery(this).css({"position":"relative","left":-(e/2),"top":0,"width":w });
	 //  }else {
	 //   jQuery(this).css({"position":"relative","left":0,"top":0,"width":"100%" });
	 //  }
	 // }); 
	}
	*/
});

// Credits: Robert Penners easing equations (http://www.robertpenner.com/easing/).
jQuery.easing['BounceEaseOut'] = function(p, t, b, c, d) {
	if ((t/=d) < (1/2.75)) {
		return c*(7.5625*t*t) + b;
	} else if (t < (2/2.75)) {
		return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
	} else if (t < (2.5/2.75)) {
		return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
	} else {
		return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
	}
};

jQuery(function ($) {
	// cache the id
	var navbox = $('.tabs');
	// activate tab on click
	navbox.find('#myTab a').click(function (event) {
	if ($(this).parent('li') .hasClass('active')){
	return false; 
	}
	// prevent the Default behavior
	event.preventDefault();
	// set the hash to the address bar
	window.location.hash = $(this).attr('href');
	// activate the clicked tab
	$(this).tab('show');
	})
	
	// if we have a hash in the address bar
	if(window.location.hash){
	// show right tab on load (read hash from address bar)
	navbox.find('a[href="'+window.location.hash+'"]').tab('show');
	}

	//$(".vertical .tab-content .tab-pane") .removeClass("in").not(".tab-pane.active");
});
jQuery(window).load(function(){
	$ = jQuery;
	$(".vertical .tab-content .tab-pane") .each(function(){
	 $(this).removeClass('in');
	 if($(this).hasClass("active")){$(this).addClass("in")}
	}); 
});

 function event_map(add,lat, long, zoom, counter){
	
 	var map;
		var myLatLng = new google.maps.LatLng(lat,long)
		//Initialize MAP
		var myOptions = {
		  zoom:zoom,
		  center: myLatLng,
		  disableDefaultUI: true,
		  zoomControl: true,
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map(document.getElementById('map_canvas'+counter),myOptions);
		//End Initialize MAP
		//Set Marker
		var marker = new google.maps.Marker({
		  position: map.getCenter(),
		  map: map
		});
		marker.getPosition();
		//End marker
		
		//Set info window
		var infowindow = new google.maps.InfoWindow({
			content: ""+add,
			position: myLatLng
		});
		google.maps.event.addListener(marker, 'click', function() {
    		infowindow.open(map,marker);
  		});
  }
// Form Default value reset
function cs_form_element(){
	jQuery(' textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"]').focus(function($) {
    	if (!jQuery(this).data("DefaultText")) jQuery(this).data("DefaultText", jQuery(this).val());
   		 if (jQuery(this).val() != "" && jQuery(this).val() == jQuery(this).data("DefaultText")) jQuery(this).val("");
			}).blur(function(){
				if (jQuery(this).val() == "") jQuery(this).val(jQuery(this).data("DefaultText"));
	});	
}

// skill short code 
function cs_skills_shortcode_script(){
		jQuery("[data-loadbar]").each(function(index){
			var d =jQuery(this) .attr('data-loadbar');
			var e =jQuery(this) .attr('data-loadbar-text');
			
			var ani = jQuery(this).find('div');
			jQuery(ani).animate({width:d+"%"},2000).next().html(e);
		}); 
}
function prayer_counter(theme_url, post_id){
   jQuery("#pray_this"+post_id).hide();
   jQuery("#loading_div"+post_id).show();
   var dataString = 'post_id=' + post_id;
            jQuery.ajax({
                type:"POST",
                url: theme_url+"/include/prayer_counter.php",
    data:dataString, 
                success:function(response){
     jQuery("#loading_div"+post_id).hide();
     jQuery("#you_prayed"+post_id).show();
     jQuery("#prayer_counter"+post_id).html(response);
                }
            });
            //return false;
        }
// portfolio carusual		



jQuery("a.open") .click(function(){
jQuery(this).toggleClass("active");
})
/*function show_map(id) {
	jQuery("div.post-"+id).toggleClass("show-map");
	
}*/

// Toggle functions search, share, tooltip, progressbar, add class view me in figure
jQuery(document).ready(function($){
	$(".search-box").hide();
		$('.search a').click(function() {
		$('.search-box').fadeToggle(800);
	});
	jQuery('html').click(function() {
	jQuery(".search-box").fadeOut();
	});
	jQuery('.search').click(function(event){
	    event.stopPropagation();
	});

	// Toggle functions everywhere click toggle off Start
	jQuery(".change_icons .icon-share").click(function(){
	 jQuery(".showicons").fadeToggle();
	});
	jQuery('html').click(function() {
	jQuery(".showicons").fadeOut();
	});
	jQuery('.eventadmin').click(function(event){
	    event.stopPropagation();
	});
	jQuery('.post_change_section').click(function(event){
	    event.stopPropagation();
	});
	
	
	
	jQuery('.progress_bar').bind('inview', function (event, visible) {
        if (visible == true) {
	jQuery("[data-loadbar]").each(function(index){
		var d =jQuery(this) .attr('data-loadbar');
		var ani = jQuery(this).find('div');
		jQuery(ani).animate({width:d+"%"},2000).html("<span>"+ d + "%&nbsp;</span>");
	}); 
 }
 
  });
});
// update js

function event_listing_share_toggle(id){
		jQuery('.showicons'+id).fadeToggle(800);
		return false;
}

jQuery(document).ready(function(){

	jQuery('#teaminfoslider .cycle-slideshow').on('cycle-before',function(event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag) {
	jQuery('.nexts').animate({"left":"60px"},200,'easeOutCubic');
	jQuery('.prevs').animate({"right":"60px"},200,'easeOutCubic');
	});
	 jQuery('#teaminfoslider .cycle-slideshow').on('cycle-after',function(event, optionHash, outgoingSlideEl, incomingSlideEl, forwardFlag) {
	jQuery('.nexts').animate({"left":"-99px"},500,'easeOutCubic');
	jQuery('.prevs').animate({"right":"-99px"},500,'easeOutCubic');
	
	});

});
function parabg () {
		jQuery(".parallaxbg").each(function(){
		var ab = jQuery("#wrappermain-pix").hasClass("wrapper_boxed");
		var bc = jQuery(this).hasClass("parallax-boxed-width");
		if(bc){
			return false;
		}
		if (ab) {
		
			var w = jQuery("#wrappermain-pix").width();
			var m = jQuery(this).parent("div").width();
			var e = w-m;
		jQuery(this).css({"position":"relative","left":-(e/2),"top":0,"width":w });
		} else {
	var w = jQuery(window).width();
	var m = jQuery(this).parent("div").width();
	var e = w-m;
	jQuery(this).css({"position":"relative","left":-(e/2),"top":0,"width":w });
	
		}
	}); 
}
function para() {
	 jQuery(".parallax-full-width").each(function(){
		var ab = jQuery("#wrappermain-pix").hasClass("wrapper_boxed");
		if (ab) {
		
			var w = jQuery("#wrappermain-pix").width();
			var m = jQuery(this).parent("div").width();
			var e = w-m;
		jQuery(this).css({"position":"relative","left":-(e/2),"top":0,"width":w });
		} else {
	var w = jQuery(window).width();
	var m = jQuery(this).parent("div").width();
	var e = w-m;
	jQuery(this).css({"position":"relative","left":-(e/2),"top":0,"width":w });
	
		}
	}); 
}
function scroll_bar(id) {

	'use strict';
(function () {
		var frame  = jQuery('#centered'+id);
		var wrap   = frame.parent();

		// Call Sly on frame
		frame.sly({
			horizontal: 1,
			itemNav: 'basic',
			smart: 1,
			activateOn: 'click',
			mouseDragging: 1,
			touchDragging: 1,
			releaseSwing: 1,
			startAt: 0,
			scrollBar: wrap.find('.scrollbar'),
			scrollBy: 1,
			activatePageOn: 'click',
			speed: 300,
			elasticBounds: 1,	
			easing: 'easeOutCubic',
			dragHandle: 1,
			dynamicHandle: 1,
			clickBar: 1
		});

	}());
}
