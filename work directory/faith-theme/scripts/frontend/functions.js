/*
 SelectNav.js (v. 0.1)
 Converts your <ul>/<ol> navigation into a dropdown list for small screens
 https://github.com/lukaszfiszer/selectnav.js
*/
window.selectnav=function(){return function(p,q){var a,h=function(b){var c;b||(b=window.event);b.target?c=b.target:b.srcElement&&(c=b.srcElement);3===c.nodeType&&(c=c.parentNode);c.value&&(window.location.href=c.value)},k=function(b){b=b.nodeName.toLowerCase();return"ul"===b||"ol"===b},l=function(b){for(var c=1;document.getElementById("selectnav"+c);c++);return b?"selectnav"+c:"selectnav"+(c-1)},n=function(b){g++;var c=b.children.length,a="",d="",f=g-1;if(c){if(f){for(;f--;)d+=r;d+=" "}for(f=0;f<
c;f++){var e=b.children[f].children[0];if("undefined"!==typeof e){var h=e.innerText||e.textContent,i="";j&&(i=-1!==e.className.search(j)||-1!==e.parentElement.className.search(j)?m:"");s&&!i&&(i=e.href===document.URL?m:"");a+='<option value="'+e.href+'" '+i+">"+d+h+"</option>";t&&(e=b.children[f].children[1])&&k(e)&&(a+=n(e))}}1===g&&o&&(a='<option value="">'+o+"</option>"+a);1===g&&(a='<select class="selectnav" id="'+l(!0)+'">'+a+"</select>");g--;return a}};if((a=document.getElementById(p))&&k(a)){document.documentElement.className+=
" js";var d=q||{},j=d.activeclass||"active",s="boolean"===typeof d.autoselect?d.autoselect:!0,t="boolean"===typeof d.nested?d.nested:!0,r=d.indent||"\u2192",o=d.label||"- Navigation -",g=0,m=" selected ";a.insertAdjacentHTML("afterend",n(a));a=document.getElementById(l());a.addEventListener&&a.addEventListener("change",h);a.attachEvent&&a.attachEvent("onchange",h)}}}();

jQuery(document).ready(function($) {
	selectnav('menus', {
	  label: 'Menu',
	  nested: true,
	  indent: '-'
	});
});
// JQuery Easing Plugin 1.3
jQuery.easing.jswing=jQuery.easing.swing,jQuery.extend(jQuery.easing,{def:"easeOutQuad",swing:function(a,b,c,d,e){return jQuery.easing[jQuery.easing.def](a,b,c,d,e)},easeInQuad:function(a,b,c,d,e){return d*(b/=e)*b+c},easeOutQuad:function(a,b,c,d,e){return-d*(b/=e)*(b-2)+c},easeInOutQuad:function(a,b,c,d,e){return(b/=e/2)<1?d/2*b*b+c:-d/2*(--b*(b-2)-1)+c},easeInCubic:function(a,b,c,d,e){return d*(b/=e)*b*b+c},easeOutCubic:function(a,b,c,d,e){return d*((b=b/e-1)*b*b+1)+c},easeInOutCubic:function(a,b,c,d,e){return(b/=e/2)<1?d/2*b*b*b+c:d/2*((b-=2)*b*b+2)+c},easeInQuart:function(a,b,c,d,e){return d*(b/=e)*b*b*b+c},easeOutQuart:function(a,b,c,d,e){return-d*((b=b/e-1)*b*b*b-1)+c},easeInOutQuart:function(a,b,c,d,e){return(b/=e/2)<1?d/2*b*b*b*b+c:-d/2*((b-=2)*b*b*b-2)+c},easeInQuint:function(a,b,c,d,e){return d*(b/=e)*b*b*b*b+c},easeOutQuint:function(a,b,c,d,e){return d*((b=b/e-1)*b*b*b*b+1)+c},easeInOutQuint:function(a,b,c,d,e){return(b/=e/2)<1?d/2*b*b*b*b*b+c:d/2*((b-=2)*b*b*b*b+2)+c},easeInSine:function(a,b,c,d,e){return-d*Math.cos(b/e*(Math.PI/2))+d+c},easeOutSine:function(a,b,c,d,e){return d*Math.sin(b/e*(Math.PI/2))+c},easeInOutSine:function(a,b,c,d,e){return-d/2*(Math.cos(Math.PI*b/e)-1)+c},easeInExpo:function(a,b,c,d,e){return 0==b?c:d*Math.pow(2,10*(b/e-1))+c},easeOutExpo:function(a,b,c,d,e){return b==e?c+d:d*(-Math.pow(2,-10*b/e)+1)+c},easeInOutExpo:function(a,b,c,d,e){return 0==b?c:b==e?c+d:(b/=e/2)<1?d/2*Math.pow(2,10*(b-1))+c:d/2*(-Math.pow(2,-10*--b)+2)+c},easeInCirc:function(a,b,c,d,e){return-d*(Math.sqrt(1-(b/=e)*b)-1)+c},easeOutCirc:function(a,b,c,d,e){return d*Math.sqrt(1-(b=b/e-1)*b)+c},easeInOutCirc:function(a,b,c,d,e){return(b/=e/2)<1?-d/2*(Math.sqrt(1-b*b)-1)+c:d/2*(Math.sqrt(1-(b-=2)*b)+1)+c},easeInElastic:function(a,b,c,d,e){var f=1.70158,g=0,h=d;if(0==b)return c;if(1==(b/=e))return c+d;if(g||(g=.3*e),h<Math.abs(d)){h=d;var f=g/4}else var f=g/(2*Math.PI)*Math.asin(d/h);return-(h*Math.pow(2,10*(b-=1))*Math.sin((b*e-f)*2*Math.PI/g))+c},easeOutElastic:function(a,b,c,d,e){var f=1.70158,g=0,h=d;if(0==b)return c;if(1==(b/=e))return c+d;if(g||(g=.3*e),h<Math.abs(d)){h=d;var f=g/4}else var f=g/(2*Math.PI)*Math.asin(d/h);return h*Math.pow(2,-10*b)*Math.sin((b*e-f)*2*Math.PI/g)+d+c},easeInOutElastic:function(a,b,c,d,e){var f=1.70158,g=0,h=d;if(0==b)return c;if(2==(b/=e/2))return c+d;if(g||(g=e*.3*1.5),h<Math.abs(d)){h=d;var f=g/4}else var f=g/(2*Math.PI)*Math.asin(d/h);return 1>b?-.5*h*Math.pow(2,10*(b-=1))*Math.sin((b*e-f)*2*Math.PI/g)+c:.5*h*Math.pow(2,-10*(b-=1))*Math.sin((b*e-f)*2*Math.PI/g)+d+c},easeInBack:function(a,b,c,d,e,f){return void 0==f&&(f=1.70158),d*(b/=e)*b*((f+1)*b-f)+c},easeOutBack:function(a,b,c,d,e,f){return void 0==f&&(f=1.70158),d*((b=b/e-1)*b*((f+1)*b+f)+1)+c},easeInOutBack:function(a,b,c,d,e,f){return void 0==f&&(f=1.70158),(b/=e/2)<1?d/2*b*b*(((f*=1.525)+1)*b-f)+c:d/2*((b-=2)*b*(((f*=1.525)+1)*b+f)+2)+c},easeInBounce:function(a,b,c,d,e){return d-jQuery.easing.easeOutBounce(a,e-b,0,d,e)+c},easeOutBounce:function(a,b,c,d,e){return(b/=e)<1/2.75?d*7.5625*b*b+c:2/2.75>b?d*(7.5625*(b-=1.5/2.75)*b+.75)+c:2.5/2.75>b?d*(7.5625*(b-=2.25/2.75)*b+.9375)+c:d*(7.5625*(b-=2.625/2.75)*b+.984375)+c},easeInOutBounce:function(a,b,c,d,e){return e/2>b?.5*jQuery.easing.easeInBounce(a,2*b,0,d,e)+c:.5*jQuery.easing.easeOutBounce(a,2*b-e,0,d,e)+.5*d+c}});
//Normal Call Back Functions
jQuery(document).ready(function($) {
	
  
    jQuery(' textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"]').focus(function() {
    if (!jQuery(this).data("DefaultText")) jQuery(this).data("DefaultText", jQuery(this).val());
    if (jQuery(this).val() != "" && jQuery(this).val() == jQuery(this).data("DefaultText")) $(this).val("");
  }).blur(function() {
    if (jQuery(this).val() == "") jQuery(this).val($(this).data("DefaultText"));
  });
   parallaxfullwidth ()
  jQuery(".cs-btnselect").click(function(event) {
    /* Act on the event */
     jQuery("#searchbox").fadeOut(600,"easeOutQuart")
    jQuery(this).next().fadeToggle(600,"easeOutQuart")
    return false;
  });
    jQuery(".btnsearch").click(function(event) {
    /* Act on the event */
     jQuery(".service-dropdown").fadeOut(600,"easeOutQuart")
    jQuery(this).next().fadeToggle(600,"easeOutQuart")
    return false;
  });
  jQuery("html").click(function(event) {
    /* Act on the event */
   jQuery("#searchbox,.service-dropdown").fadeOut(600,"easeOutQuart")
  });
  jQuery(".searcharea,.cs-service-mega") .click(function(event) {
    /* Act on the event */
    event.stopPropagation();
  });

 



  jQuery('.back-to-top').click(function(event) {
    event.preventDefault();
    jQuery('html, body').animate({scrollTop: 0}, 1000);
    return false;
})
  jQuery('.cs-post-top-section a').click(function(event) {
    event.preventDefault();
    var a = jQuery(this).attr('href')
    jQuery('html, body').animate({scrollTop: (jQuery(a).offset().top)-60}, 1000);
    return false;
})
});
// for parallex
function parallaxfullwidth () {
	"use strict";	
  	jQuery(".parallax-fullwidth").each(function(){
    var ab = jQuery("#wrappermain-pix").hasClass("wrapper_boxed");
    	if (ab) {

        var w = jQuery("#wrappermain-pix").width();
        var m = jQuery(this).parent("#main").width();
        var e = w-m;
    jQuery(this).css({"position":"relative","left":-(e/2),"top":0,"width":w });
    } else {
      var w = jQuery("#main").width();
      var m = jQuery(this).parent("div").width();
      var e = w-m;
      jQuery(this).css({"position":"relative","left":-(e/2),"top":0,"width":w });

    }
  });
}
// for sticky menu
function cs_menu_sticky(){
	"use strict";
	jQuery("#menuwrapper").scrollToFixed();
}
// mail chimp funtion for ajax submit
function cs_mailchimp_submit(theme_url,counter){
	'use strict';
 	$ = jQuery;

	$('#btn_newsletter_'+counter).hide();

	$('#process_newsletter_'+counter).html('<i class="fa fa-refresh fa-spin"></i>');

	$.ajax({

		type:'POST', 

		url: theme_url+'/include/mailchimp_load.php',

		data:$('#mcform_'+counter).serialize(), 

		success: function(response) {

			$('#mcform_'+counter).get(0).reset();

			$('#newsletter_mess_'+counter).fadeIn(600);

			$('#newsletter_mess_'+counter).html(response);

			$('#btn_newsletter_'+counter).fadeIn(600);

			$('#process_newsletter_'+counter).html('');

 
			//$('#frm_slide').find('.form_result').html(response);

		}

	});

}
// load post custom video using ajax in model window
function cs_video_load(theme_url, post_id, post_video,poster){
	'use strict';
   	//var dataString = 'post_video=' + post_video;
   	var dataString = {post_video:post_video,poster:poster};
	jQuery.ajax({
		type:"POST",
		url: theme_url+"/include/video_load.php",
			 data:dataString, 
		success:function(response){
	//jQuery("#myModal"+post_id).hide();
	jQuery("a[data-target='#myModal"+post_id+"']").removeAttr('onclick')
	jQuery("#myModal"+post_id).html(response);
		jQuery('audio,video').mediaelementplayer({
			sfeatures: ['playpause']
		});
	}
	});
//return false;
}
// js fucntion for news ticker
function cs_jsnewsticker(cls,startDelay,tickerRate){
	'use strict';
	var options = {
		newsList: "."+cls,
		startDelay: startDelay,
		tickerRate: tickerRate,
		controls: true,
		ownControls: false,
		stopOnHover: false,
		resumeOffHover: true
	}
	jQuery().newsTicker(options);
}
// for event map
function event_map(add,lat, long, zoom, counter){
	"use strict";
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
// Twitter js function
function cs_twitter_slider(){
	"use strict";
	jQuery('.widget_slider .flexslider').flexslider({
		animation: "slide",
		prevText:"<i class='fa fa-angle-left'></i>",
		nextText:"<i class='fa fa-angle-left'></i>",
		start: function(slider) {
		jQuery('.widget_slider').css("opacity",1);
		}
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
jQuery(document).ready(function(){
     jQuery('.sermons.sermons-listing,.blog').css('opacity',"1");
     jQuery('audio,video').mediaelementplayer({

     });

});