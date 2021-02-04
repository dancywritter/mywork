function px_select_nav(){
/*
 SelectNav.js (v. 0.1)
 Converts your <ul>/<ol> navigation into a dropdown list for small screens
 https://github.com/lukaszfiszer/selectnav.js
*/
window.selectnav=function(){return function(p,q){var a,h=function(b){var c;b||(b=window.event);b.target?c=b.target:b.srcElement&&(c=b.srcElement);3===c.nodeType&&(c=c.parentNode);c.value&&(window.location.href=c.value)},k=function(b){b=b.nodeName.toLowerCase();return"ul"===b||"ol"===b},l=function(b){for(var c=1;document.getElementById("selectnav"+c);c++);return b?"selectnav"+c:"selectnav"+(c-1)},n=function(b){g++;var c=b.children.length,a="",d="",f=g-1;if(c){if(f){for(;f--;)d+=r;d+=" "}for(f=0;f<
c;f++){var e=b.children[f].children[0];if("undefined"!==typeof e){var h=e.innerText||e.textContent,i="";j&&(i=-1!==e.className.search(j)||-1!==e.parentElement.className.search(j)?m:"");s&&!i&&(i=e.href===document.URL?m:"");a+='<option value="'+e.href+'" '+i+">"+d+h+"</option>";t&&(e=b.children[f].children[1])&&k(e)&&(a+=n(e))}}1===g&&o&&(a='<option value="">'+o+"</option>"+a);1===g&&(a='<select class="selectnav" id="'+l(!0)+'">'+a+"</select>");g--;return a}};if((a=document.getElementById(p))&&k(a)){document.documentElement.className+=
" js";var d=q||{},j=d.activeclass||"active",s="boolean"===typeof d.autoselect?d.autoselect:!0,t="boolean"===typeof d.nested?d.nested:!0,r=d.indent||"\u2192",o=d.label||"- Navigation -",g=0,m=" selected ";a.insertAdjacentHTML("afterend",n(a));a=document.getElementById(l());a.addEventListener&&a.addEventListener("change",h);a.attachEvent&&a.attachEvent("onchange",h)}}}();

}
// JQuery Easing Plugin 1.3
jQuery.easing.jswing=jQuery.easing.swing,jQuery.extend(jQuery.easing,{def:"easeOutQuad",swing:function(a,b,c,d,e){return jQuery.easing[jQuery.easing.def](a,b,c,d,e)},easeInQuad:function(a,b,c,d,e){return d*(b/=e)*b+c},easeOutQuad:function(a,b,c,d,e){return-d*(b/=e)*(b-2)+c},easeInOutQuad:function(a,b,c,d,e){return(b/=e/2)<1?d/2*b*b+c:-d/2*(--b*(b-2)-1)+c},easeInCubic:function(a,b,c,d,e){return d*(b/=e)*b*b+c},easeOutCubic:function(a,b,c,d,e){return d*((b=b/e-1)*b*b+1)+c},easeInOutCubic:function(a,b,c,d,e){return(b/=e/2)<1?d/2*b*b*b+c:d/2*((b-=2)*b*b+2)+c},easeInQuart:function(a,b,c,d,e){return d*(b/=e)*b*b*b+c},easeOutQuart:function(a,b,c,d,e){return-d*((b=b/e-1)*b*b*b-1)+c},easeInOutQuart:function(a,b,c,d,e){return(b/=e/2)<1?d/2*b*b*b*b+c:-d/2*((b-=2)*b*b*b-2)+c},easeInQuint:function(a,b,c,d,e){return d*(b/=e)*b*b*b*b+c},easeOutQuint:function(a,b,c,d,e){return d*((b=b/e-1)*b*b*b*b+1)+c},easeInOutQuint:function(a,b,c,d,e){return(b/=e/2)<1?d/2*b*b*b*b*b+c:d/2*((b-=2)*b*b*b*b+2)+c},easeInSine:function(a,b,c,d,e){return-d*Math.cos(b/e*(Math.PI/2))+d+c},easeOutSine:function(a,b,c,d,e){return d*Math.sin(b/e*(Math.PI/2))+c},easeInOutSine:function(a,b,c,d,e){return-d/2*(Math.cos(Math.PI*b/e)-1)+c},easeInExpo:function(a,b,c,d,e){return 0==b?c:d*Math.pow(2,10*(b/e-1))+c},easeOutExpo:function(a,b,c,d,e){return b==e?c+d:d*(-Math.pow(2,-10*b/e)+1)+c},easeInOutExpo:function(a,b,c,d,e){return 0==b?c:b==e?c+d:(b/=e/2)<1?d/2*Math.pow(2,10*(b-1))+c:d/2*(-Math.pow(2,-10*--b)+2)+c},easeInCirc:function(a,b,c,d,e){return-d*(Math.sqrt(1-(b/=e)*b)-1)+c},easeOutCirc:function(a,b,c,d,e){return d*Math.sqrt(1-(b=b/e-1)*b)+c},easeInOutCirc:function(a,b,c,d,e){return(b/=e/2)<1?-d/2*(Math.sqrt(1-b*b)-1)+c:d/2*(Math.sqrt(1-(b-=2)*b)+1)+c},easeInElastic:function(a,b,c,d,e){var f=1.70158,g=0,h=d;if(0==b)return c;if(1==(b/=e))return c+d;if(g||(g=.3*e),h<Math.abs(d)){h=d;var f=g/4}else var f=g/(2*Math.PI)*Math.asin(d/h);return-(h*Math.pow(2,10*(b-=1))*Math.sin((b*e-f)*2*Math.PI/g))+c},easeOutElastic:function(a,b,c,d,e){var f=1.70158,g=0,h=d;if(0==b)return c;if(1==(b/=e))return c+d;if(g||(g=.3*e),h<Math.abs(d)){h=d;var f=g/4}else var f=g/(2*Math.PI)*Math.asin(d/h);return h*Math.pow(2,-10*b)*Math.sin((b*e-f)*2*Math.PI/g)+d+c},easeInOutElastic:function(a,b,c,d,e){var f=1.70158,g=0,h=d;if(0==b)return c;if(2==(b/=e/2))return c+d;if(g||(g=e*.3*1.5),h<Math.abs(d)){h=d;var f=g/4}else var f=g/(2*Math.PI)*Math.asin(d/h);return 1>b?-.5*h*Math.pow(2,10*(b-=1))*Math.sin((b*e-f)*2*Math.PI/g)+c:.5*h*Math.pow(2,-10*(b-=1))*Math.sin((b*e-f)*2*Math.PI/g)+d+c},easeInBack:function(a,b,c,d,e,f){return void 0==f&&(f=1.70158),d*(b/=e)*b*((f+1)*b-f)+c},easeOutBack:function(a,b,c,d,e,f){return void 0==f&&(f=1.70158),d*((b=b/e-1)*b*((f+1)*b+f)+1)+c},easeInOutBack:function(a,b,c,d,e,f){return void 0==f&&(f=1.70158),(b/=e/2)<1?d/2*b*b*(((f*=1.525)+1)*b-f)+c:d/2*((b-=2)*b*(((f*=1.525)+1)*b+f)+2)+c},easeInBounce:function(a,b,c,d,e){return d-jQuery.easing.easeOutBounce(a,e-b,0,d,e)+c},easeOutBounce:function(a,b,c,d,e){return(b/=e)<1/2.75?d*7.5625*b*b+c:2/2.75>b?d*(7.5625*(b-=1.5/2.75)*b+.75)+c:2.5/2.75>b?d*(7.5625*(b-=2.25/2.75)*b+.9375)+c:d*(7.5625*(b-=2.625/2.75)*b+.984375)+c},easeInOutBounce:function(a,b,c,d,e){return e/2>b?.5*jQuery.easing.easeInBounce(a,2*b,0,d,e)+c:.5*jQuery.easing.easeOutBounce(a,2*b-e,0,d,e)+.5*d+c}});


//Normal Call Back Functions
jQuery(document).ready(function($) {
	px_select_nav();
    selectnav('menus', {
    label: 'Menu',
    nested: true,
    indent: '-->'
  });

  jQuery("#menus ul").parent("li").addClass("menu-parent");


  
  jQuery(".pix-btnmenu") .click(function(event) {
    /* Act on the event */
    jQuery("#left-content").toggleClass('pix-active');
    jQuery(".page-background").toggleClass('blurry');
    return false;
  });
  jQuery(".pix-btnsidebar") .click(function(event) {
    /* Act on the event */
	if(jQuery("#right-content").hasClass('pix-active')){
		jQuery(".blog-sidebar").hide();
	} else {
		jQuery(".blog-sidebar").slideDown();
	}
    jQuery("#right-content").toggleClass('pix-active');
    return false;
  });
    jQuery(' textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"]').focus(function() {
    if (!jQuery(this).data("DefaultText")) jQuery(this).data("DefaultText", jQuery(this).val());
    if (jQuery(this).val() != "" && jQuery(this).val() == $(this).data("DefaultText")) jQuery(this).val("");
  }).blur(function() {
    if (jQuery(this).val() == "") jQuery(this).val(jQuery(this).data("DefaultText"));
  });
 // jQuery("body").niceScroll({
 //  horizrailenabled:false
 // })
jQuery(".btnsearch").click(function(event) {
    /* Act on the event */
    $(this).next().fadeToggle(600,"easeOutQuart")
    return false;
  });
  jQuery("html").click(function(event) {
    /* Act on the event */
   jQuery("#searchbox").fadeOut(600,"easeOutQuart")
  });
  jQuery(".searcharea") .click(function(event) {
    /* Act on the event */
    event.stopPropagation();
  });

resizeVideo()
  jQuery(window) .resize(function(){
resizeVideo()
 //       jQuery("body").niceScroll({
 //  horizrailenabled:false
 // }).resize();

  })
 });
 
 // nice scroll
 function px_nicescroll(){
	 // NiceScroll Javascript
	jQuery("html").niceScroll({styler:"fb",cursorcolor:"#000", horizrailenabled:false, autohidemode: false, cursorwidth:"10px"});
	// NiceScroll Javascript
	 
 }
 
function resizevideo() {
  'use strict';
  jQuery("#videowrapper").each(function(index, el) {
  var windowW = jQuery(window).width();
  var windowH = jQuery(window).height();
  var mediaAspect = 16/9;
  var vidEl  = jQuery(this).find("video")
  var embEl  = jQuery(this).find("iframe")
  var windowAspect = windowW/windowH;
  if (windowAspect < mediaAspect) {
    // taller
    jQuery(this)
      .width(windowH*mediaAspect)
      .height(windowH);
    jQuery(vidEl)
      .css('top',0)
      .css('left',-(windowH*mediaAspect-windowW)/2)
      .css('height',windowH);
    jQuery(embEl)
      .css('top',0)
      .css('left',-(windowH*mediaAspect-windowW)/2)
      .css('height',windowH);
      
  } else {
    // wider
      jQuery(this)
        .width(windowW)
        .height(windowW/mediaAspect);
      jQuery(vidEl)
        .css('top',-(windowW/mediaAspect-windowH)/2)
        .css('left',0)
        .css('height',windowW/mediaAspect);
      jQuery(embEl)
        .css('top',-(windowW/mediaAspect-windowH)/2)
        .css('left',0)
        .css('height',windowW/mediaAspect);    
      
       
     
  }
});       
}
// event map location
function event_map(contentdesc,lat, long, zoom, counter){
	
				var styles = [
    {
      stylers: [
        { hue: "#000000" },
        { saturation: -100 }
      ]
    },{
      featureType: "road",
      elementType: "geometry",
      stylers: [
        { lightness: -40 },
        { visibility: "simplified" }
      ]
    },{
      featureType: "road",
      elementType: "labels",
      stylers: [
        { visibility: "on" }
      ]
    }
  ];
		var styledMap = new google.maps.StyledMapType(styles,
		{name: "Styled Map"});
			var myLatlng = new google.maps.LatLng(lat,long);
			directionsDisplay = new google.maps.DirectionsRenderer({
				polylineOptions: {
				  strokeColor: "red"
				}
			  });
			var mapOptions = {
				zoom: zoom,
				backgroundColor: '#cccccc',
				scrollwheel: true,
				draggable: true,
				center: myLatlng,
				//mapTypeId: google.maps.MapTypeId.ROADMAP ,
				disableDefaultUI: true,
				mapTypeControlOptions: {
				  mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
				}
			}
  			var map = new google.maps.Map(document.getElementById('map_canvas'+counter), mapOptions);
			map.mapTypes.set('map_style', styledMap);
			map.setMapTypeId('map_style');
			var infowindow = new google.maps.InfoWindow({
				content: "<div class='info-gmap-tool'>"+contentdesc+"</div>",
				//position: myLatLng,
				maxWidth: 500,
				maxHeight:250,
			});
			var marker = new google.maps.Marker({
			position: myLatlng,
			map: map,
			title: '',
			// icon: 'images/map-marker.png',
			shadow:''
		});
			//google.maps.event.addListener(marker, 'click', function() {
				if (infowindow.content != ''){
				  infowindow.open(map, marker);
				   map.panBy(1,-60);
				   google.maps.event.addListener(marker, 'click', function(event) {
					infowindow.open(map, marker);

				   });
				}
			//});
		

  }

function event_mapp(contentdesc,lat, long, zoom, counter){
	"use strict";
	
				var styles = [
    {
      stylers: [
        { hue: "#000000" },
        { saturation: -100 }
      ]
    },{
      featureType: "road",
      elementType: "geometry",
      stylers: [
        { lightness: -40 },
        { visibility: "simplified" }
      ]
    },{
      featureType: "road",
      elementType: "labels",
      stylers: [
        { visibility: "on" }
      ]
    }
  ];
		var styledMap = new google.maps.StyledMapType(styles,
		{name: "Styled Map"});
			var myLatlng = new google.maps.LatLng(lat,long);
			directionsDisplay = new google.maps.DirectionsRenderer({
				polylineOptions: {
				  strokeColor: "red"
				}
			  });
			var mapOptions = {
				zoom: zoom,
				backgroundColor: '#cccccc',
				scrollwheel: true,
				draggable: true,
				center: myLatlng,
				//mapTypeId: google.maps.MapTypeId.ROADMAP ,
				disableDefaultUI: true,
				mapTypeControlOptions: {
				  mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
				}
			}
  			var map = new google.maps.Map(document.getElementById('map_canvas'+counter), mapOptions);
			map.mapTypes.set('map_style', styledMap);
			map.setMapTypeId('map_style');
			var infowindow = new google.maps.InfoWindow({
				content: "<div class='info-gmap-tool'>"+contentdesc+"</div>",
				//position: myLatLng,
				maxWidth: 500,
				maxHeight:350,
			});
			var marker = new google.maps.Marker({
			position: myLatlng,
			map: map,
			title: '',
			// icon: 'images/map-marker.png',
			shadow:''
		});
			//google.maps.event.addListener(marker, 'click', function() {
				if (infowindow.content != ''){
				  infowindow.open(map, marker);
				   map.panBy(1,-60);
				   google.maps.event.addListener(marker, 'click', function(event) {
					infowindow.open(map, marker);

				   });
				}
			//});
	
}
// event countdown
function px_event_countdown(year_event,month_event,date_event){
	"use strict";
	var austDay = new Date();
	austDay = new Date(year_event,month_event-1,date_event);
	jQuery('#textLayout').countdown({until: austDay,
	layout: '{dn} {dl}, {hn} {hl}, {mn} {ml} , {sn} {sl} '});
}

// media element 
function px_mediaelement(){
	"use strict";
	jQuery(".audio-play-music audio") .mediaelementplayer();	
}

//
function px_text_rotaion_single(){
	"use strict";
	jQuery(".pix-page-title .rotate").wordsrotator({
		autoLoop: true,             //auto rotate words
		randomize: false,               //show random entries from the words array
		stopOnHover: false,             //stop animation on hover
		changeOnClick: false,           //force animation run on click
		animationIn: "flipInY",         //css class for entrace animation
		animationOut: "flipOutY",           //css class for exit animation
		speed: 2000,                //delay in milliseconds between two words
		words: ['apple', 'apricot', 'avocado']  //Array of words, it may contain HTML values
	});
	
}

// dropdown menu ajax funtion
function px_dropdown_menu_ajax(theme_url){

	jQuery("#selectnav1").live("change",function($){
				pageurl = jQuery(this).attr('href');
				if(pageurl == '' || pageurl == '#'){
					return false;	
				}
				jQuery("html").addClass('itemloading');
				jQuery("#main").html('');
				jQuery('.post-wrapper').html('');
				jQuery('#main').removeClass('pix-animation');
				jQuery('#main').append('<div class="loadermain"><i class="fa fa-refresh fa-spin"></i></div>');
				 jQuery('html, body').animate({scrollTop: 0}, 800);
				jQuery.ajax({url:pageurl, data: {ajax:'on'}, cache: false, success: function(data){
					resizeVideo();
						rsponse = jQuery(data);
						jQuery(".loadermain").remove();
						var response_maintitle = rsponse.filter('title').text();
						jQuery('title').html(response_maintitle);
						jQuery('#main').html('');
						if(jQuery('.mbBgndGallery').length){
							jQuery('.mbBgndGallery').remove();
						}
						if(jQuery('.default_video_option').length){
							var response_background_default_video = rsponse.find(".default_video_option").html();
							if(typeof rsponse.find(".default_video_option").html() != 'undefined'){
							} else {
								
								jQuery('#background_section').html('');
									var response_background = rsponse.find("#background_section_view").html();
									jQuery('#background_section').html(response_background);
								
								
							}
						} else {
							var response_background = rsponse.find("#background_section_view").html();
							jQuery('#background_section').html(response_background);
						}
						
						if(((typeof rsponse.find(".page_element_area").html() != 'undefined') && (jQuery.trim(rsponse.find(".page_element_area").html()) != '')) || (jQuery.trim(rsponse.find(".sing-page-area").html()) != '' &&  (typeof rsponse.find(".sing-page-area").html() != 'undefined') )){
							jQuery("#right-content").css("display","block");
							jQuery("#left-content").css("width","");
							var response_value = rsponse.find("#main").html();
							jQuery('#main').html(response_value);
							jQuery('#main').addClass('pix-animation');
						
						} else {
							jQuery("#right-content").css("display","none");
							jQuery("#left-content").css("width","100%");
						}
							jQuery('#left-content').removeClass('pix-active');
							var response_titlee = rsponse.find(".pix-heading-area").html();
							jQuery('.pix-heading-area').html('');
							jQuery('.pix-heading-area').append(response_titlee);
						
							var post_wrapper = rsponse.find(".nex-prev-paginate").html();
							jQuery('.post-wrapper').html('');
							jQuery('.nex-prev-paginate').append(post_wrapper);
							
							
						return false;
					},
					error: function(xhr, status, error) {
						rsponse = jQuery(xhr.responseText);
						var response = rsponse.find("#main").html();
						if(response){
							jQuery('#main').html(response);
							var response_titlee = rsponse.find(".pix-heading-area").html();
							jQuery('.pix-heading-area').html('');
							jQuery('.pix-heading-area').append(response_titlee);
							jQuery("html").removeClass('itemloading')
						} else {
							jQuery('#main').html('<h2>Page Not Found</h2>');
							var response = rsponse.find("body").html();
							jQuery('#main').html(response);
							jQuery("html").removeClass('itemloading')
						}
					}
				});
				if(pageurl!=window.location){
					window.history.pushState({path:pageurl},'',pageurl);
				}
				//stop refreshing to the page given in
				return false;
			});	
	
}

// dropdown menu ajax funtion
function px_default_menu_ajax(theme_url){

	jQuery("#menus a, article h2 a, article figure figcaption a:first-child, article .ajax-link, .post-wrapper a.post-link, .post-wrapper a.post-prev, .post-wrapper a.post-next, .post-btn a, a.read-more, .widget a, #filters ul li a, read-more.a, .post-btn a, .tagcloud a, .post-options a, .post-tags a").live("click",function($){
			jQuery("#right-content").removeClass('pix-active');
				pageurl = jQuery(this).attr('href');
				if(pageurl == '' || pageurl == '#'){
					return false;	
				}
				jQuery("html").addClass('itemloading');
				jQuery("#main").html('');
				jQuery('.post-wrapper').html('');
				jQuery('#main').removeClass('pix-animation');
				jQuery('#main').append('<div class="loadermain"><i class="fa fa-refresh fa-spin"></i></div>');
				 jQuery('html, body').animate({scrollTop: 0}, 800);
				jQuery.ajax({url:pageurl, data: {ajax:'on'}, cache: false, success: function(data){
					resizeVideo();
						rsponse = jQuery(data);
						jQuery(".loadermain").remove();
						var response_maintitle = rsponse.filter('title').text();
						jQuery('title').html(response_maintitle);
						jQuery('#main').html('');
						if(jQuery('.mbBgndGallery').length){
							jQuery('.mbBgndGallery').remove();
						}
						if(jQuery('.default_video_option').length){
							var response_background_default_video = rsponse.find(".default_video_option").html();
							if(typeof rsponse.find(".default_video_option").html() != 'undefined'){
							} else {
								
									jQuery('#background_section').html('');
									var response_background = rsponse.find("#background_section_view").html();
									jQuery('#background_section').html(response_background);
								
							}
						} else {
							var response_background = rsponse.find("#background_section_view").html();
							jQuery('#background_section').html(response_background);
						}
						if(((typeof rsponse.find(".woocommerce").html() != 'undefined') && (jQuery.trim(rsponse.find(".woocommerce").html()) != ''))){
							
								jQuery("#right-content").css("display","block");
								jQuery("#left-content").css("width","");
								var response_value = rsponse.find("#main").html();
								jQuery('#main').html(response_value);
								jQuery('#main').addClass('pix-animation');
						} else {
						
							if(((typeof rsponse.find(".page_element_area").html() != 'undefined') && (jQuery.trim(rsponse.find(".page_element_area").html()) != '')) || (jQuery.trim(rsponse.find(".sing-page-area").html()) != '' &&  (typeof rsponse.find(".sing-page-area").html() != 'undefined') )){
								jQuery("#right-content").css("display","block");
								jQuery("#left-content").css("width","");
								var response_value = rsponse.find("#main").html();
								jQuery('#main').html(response_value);
								jQuery('#main').addClass('pix-animation');
							
							} else {
								
								jQuery("#right-content").css("display","none");
								jQuery("#left-content").css("width","100%");
								
							}
						}
							
							jQuery('#left-content').removeClass('pix-active');
							var response_titlee = rsponse.find(".pix-heading-area").html();
							jQuery('.pix-heading-area').html('');
							jQuery('.pix-heading-area').append(response_titlee);
						
							var post_wrapper = rsponse.find(".nex-prev-paginate").html();
							//jQuery('.post-wrapper').html('');
							jQuery('.nex-prev-paginate').remove();
							if(post_wrapper){
								var nex_prev = '<div class="nex-prev-paginate">'+post_wrapper+'</div>';
								jQuery('.pix-heading-area').after(nex_prev);
							}
							
						return false;
					},
					error: function(xhr, status, error) {
						rsponse = jQuery(xhr.responseText);
						var response = rsponse.find("#main").html();
						if(response){
							jQuery('#main').html(response);
							var response_titlee = rsponse.find(".pix-heading-area").html();
							jQuery('.pix-heading-area').html('');
							jQuery('.pix-heading-area').append(response_titlee);
							jQuery("html").removeClass('itemloading')
						} else {
							jQuery('#main').html('<h2>Page Not Found</h2>');
							var response = rsponse.find("body").html();
							jQuery('#main').html(response);
							jQuery("html").removeClass('itemloading')
						}
					}
				});
				if(pageurl!=window.location){
					window.history.pushState({path:pageurl},'',pageurl);
				}
				//stop refreshing to the page given in
				return false;
			});
}
// ajax search
function px_search_result_ajax(theme_url){
	
	jQuery("#searchsubmit").live("click",function($){
				jQuery("#right-content").removeClass('pix-active');
				var pageurl = jQuery('#searchform').attr('action');
				var search_val=jQuery("#searchinput").val();
				jQuery("html").addClass('itemloading');
				jQuery("#main").html('');
				jQuery('#main').removeClass('pix-animation');
				jQuery('#main').append('<div class="loadermain"><i class="fa fa-refresh fa-spin"></i></div>');
				 jQuery('html, body').animate({scrollTop: 0}, 800);
				jQuery.ajax({url:pageurl, data: {ajax:'on',s:search_val}, cache: false, success: function(data){
					resizeVideo();
						rsponse = jQuery(data);
						jQuery(".loadermain").remove();
						var response_maintitle = rsponse.filter('title').text();
						jQuery('title').html(response_maintitle);
						jQuery('#main').html('');
						jQuery('#left-content').removeClass('pix-active');
						var response_value = rsponse.find("#main").html();
						jQuery('#main').html(response_value);
						jQuery('#main').addClass('pix-animation');
						jQuery('#left-content').removeClass('pix-active');
						var response_titlee = rsponse.find(".pix-heading-area").html();
						jQuery('.pix-heading-area').html('');
						jQuery('.pix-heading-area').append(response_titlee);
						return false;
					},
					error: function(xhr, status, error) {
						rsponse = jQuery(xhr.responseText);
						var response = rsponse.find("#main").html();
						if(response){
							jQuery('#main').html(response);
							var response_titlee = rsponse.find(".pix-heading-area").html();
							jQuery('.pix-heading-area').html('');
							jQuery('.pix-heading-area').append(response_titlee);
							jQuery("html").removeClass('itemloading')
						} else {
							jQuery('#main').html('<h2>Page Not Found</h2>');
							var response = rsponse.find("body").html();
							jQuery('#main').html(response);
							jQuery("html").removeClass('itemloading')
						}
					}
				});
				if(pageurl!=window.location){
					window.history.pushState({path:pageurl},'',pageurl);
				}
				//stop refreshing to the page given in
				return false;
			});	
	
}

// ajax pagination
function px_pagination_ajax(theme_url){
	
	jQuery(".pagination a").live("click",function($){
		
				jQuery("#right-content").removeClass('pix-active');
				pageurl = jQuery(this).attr('href');
				jQuery("html").addClass('itemloading');
				jQuery("#main").html('');
				jQuery('#main').removeClass('pix-animation');
				jQuery('#main').append('<div class="loadermain"><i class="fa fa-refresh fa-spin"></i></div>');
				 jQuery('html, body').animate({scrollTop: 0}, 800);
				jQuery.ajax({url:pageurl, data: {ajax:'on'}, cache: false, success: function(data){
					resizeVideo();
						rsponse = jQuery(data);
						jQuery(".loadermain").remove();
						jQuery('#main').html('');
						jQuery('#left-content').removeClass('pix-active');
						var response_value = rsponse.find("#main").html();
						jQuery('#main').html(response_value);
						jQuery('#main').addClass('pix-animation');
						return false;
					},
					error: function(xhr, status, error) {
						rsponse = jQuery(xhr.responseText);
						var response = rsponse.find("#main").html();
						if(response){
							jQuery('#main').html(response);
							var response_titlee = rsponse.find(".pix-heading-area").html();
							jQuery('.pix-heading-area').html('');
							jQuery('.pix-heading-area').append(response_titlee);
							jQuery("html").removeClass('itemloading')
						} else {
							jQuery('#main').html('<h2>Page Not Found</h2>');
							var response = rsponse.find("body").html();
							jQuery('#main').html(response);
							jQuery("html").removeClass('itemloading')
						}
					}
				});
				
				//stop refreshing to the page given in
				return false;
			});	
}

function resizeVideo() {
      var a = jQuery(window) .width();
    var b = jQuery(window) .height();
      jQuery("#left-content") .height(b)
      jQuery("#right-content") .css("min-height",b)
}

// comments js function 

function px_comments_js(){
	var commentform=jQuery('#commentform');
	commentform.prepend('<div id="comment-status" ></div>');
	var statusdiv=jQuery('#comment-status');
	commentform.live("submit", function(){
		var commnent_post_id = jQuery('#comment_post_ID').val();
		var commnent_post_parent = jQuery('#comment_parent').val();	
	  var formdata=commentform.serialize();
	  statusdiv.html('<p>Processing...</p>');
	  var formurl=commentform.attr('action');
	  jQuery.ajax({
		type: 'post',
		url: formurl,
		data: formdata,
		error: function(XMLHttpRequest, textStatus, errorThrown){
		  statusdiv.html('<p class="ajax-error" >You might have left one of the fields blank, or be posting too quickly</p>');
		},
		success: function(data, textStatus){
		  if(textStatus=="success"){
			statusdiv.html('<p class="ajax-success" >Thanks for your comment. We appreciate your response.</p>');
			commentsrsponse = jQuery(data);
			var response2 = commentsrsponse.find("#comments").html();
			jQuery('#comments').html(response2);
		  } else
			statusdiv.html('<p class="ajax-error" >Please wait a while before posting your next comment</p>');
		  commentform.find('textarea[name=comment]').val('');
		}
	  });
	  return false;
	});
}

