
/*
 SelectNav.js (v. 0.1)
 Converts your <ul>/<ol> navigation into a dropdown list for small screens
 https://github.com/lukaszfiszer/selectnav.js
*/
window.selectnav=function(){return function(p,q){var a,h=function(b){var c;b||(b=window.event);b.target?c=b.target:b.srcElement&&(c=b.srcElement);3===c.nodeType&&(c=c.parentNode);c.value&&(window.location.href=c.value)},k=function(b){b=b.nodeName.toLowerCase();return"ul"===b||"ol"===b},l=function(b){for(var c=1;document.getElementById("selectnav"+c);c++);return b?"selectnav"+c:"selectnav"+(c-1)},n=function(b){g++;var c=b.children.length,a="",d="",f=g-1;if(c){if(f){for(;f--;)d+=r;d+=" "}for(f=0;f<
c;f++){var e=b.children[f].children[0];if("undefined"!==typeof e){var h=e.innerText||e.textContent,i="";j&&(i=-1!==e.className.search(j)||-1!==e.parentElement.className.search(j)?m:"");s&&!i&&(i=e.href===document.URL?m:"");a+='<option value="'+e.href+'" '+i+">"+d+h+"</option>";t&&(e=b.children[f].children[1])&&k(e)&&(a+=n(e))}}1===g&&o&&(a='<option value="">'+o+"</option>"+a);1===g&&(a='<select class="selectnav" id="'+l(!0)+'">'+a+"</select>");g--;return a}};if((a=document.getElementById(p))&&k(a)){document.documentElement.className+=
" js";var d=q||{},j=d.activeclass||"active",s="boolean"===typeof d.autoselect?d.autoselect:!0,t="boolean"===typeof d.nested?d.nested:!0,r=d.indent||"\u2192",o=d.label||"- Navigation -",g=0,m=" selected ";a.insertAdjacentHTML("afterend",n(a));a=document.getElementById(l());a.addEventListener&&a.addEventListener("change",h);a.attachEvent&&a.attachEvent("onchange",h)}}}();
// JQuery Easing Plugin 1.3
jQuery.easing.jswing=jQuery.easing.swing,jQuery.extend(jQuery.easing,{def:"easeOutQuad",swing:function(a,b,c,d,e){return jQuery.easing[jQuery.easing.def](a,b,c,d,e)},easeInQuad:function(a,b,c,d,e){return d*(b/=e)*b+c},easeOutQuad:function(a,b,c,d,e){return-d*(b/=e)*(b-2)+c},easeInOutQuad:function(a,b,c,d,e){return(b/=e/2)<1?d/2*b*b+c:-d/2*(--b*(b-2)-1)+c},easeInCubic:function(a,b,c,d,e){return d*(b/=e)*b*b+c},easeOutCubic:function(a,b,c,d,e){return d*((b=b/e-1)*b*b+1)+c},easeInOutCubic:function(a,b,c,d,e){return(b/=e/2)<1?d/2*b*b*b+c:d/2*((b-=2)*b*b+2)+c},easeInQuart:function(a,b,c,d,e){return d*(b/=e)*b*b*b+c},easeOutQuart:function(a,b,c,d,e){return-d*((b=b/e-1)*b*b*b-1)+c},easeInOutQuart:function(a,b,c,d,e){return(b/=e/2)<1?d/2*b*b*b*b+c:-d/2*((b-=2)*b*b*b-2)+c},easeInQuint:function(a,b,c,d,e){return d*(b/=e)*b*b*b*b+c},easeOutQuint:function(a,b,c,d,e){return d*((b=b/e-1)*b*b*b*b+1)+c},easeInOutQuint:function(a,b,c,d,e){return(b/=e/2)<1?d/2*b*b*b*b*b+c:d/2*((b-=2)*b*b*b*b+2)+c},easeInSine:function(a,b,c,d,e){return-d*Math.cos(b/e*(Math.PI/2))+d+c},easeOutSine:function(a,b,c,d,e){return d*Math.sin(b/e*(Math.PI/2))+c},easeInOutSine:function(a,b,c,d,e){return-d/2*(Math.cos(Math.PI*b/e)-1)+c},easeInExpo:function(a,b,c,d,e){return 0==b?c:d*Math.pow(2,10*(b/e-1))+c},easeOutExpo:function(a,b,c,d,e){return b==e?c+d:d*(-Math.pow(2,-10*b/e)+1)+c},easeInOutExpo:function(a,b,c,d,e){return 0==b?c:b==e?c+d:(b/=e/2)<1?d/2*Math.pow(2,10*(b-1))+c:d/2*(-Math.pow(2,-10*--b)+2)+c},easeInCirc:function(a,b,c,d,e){return-d*(Math.sqrt(1-(b/=e)*b)-1)+c},easeOutCirc:function(a,b,c,d,e){return d*Math.sqrt(1-(b=b/e-1)*b)+c},easeInOutCirc:function(a,b,c,d,e){return(b/=e/2)<1?-d/2*(Math.sqrt(1-b*b)-1)+c:d/2*(Math.sqrt(1-(b-=2)*b)+1)+c},easeInElastic:function(a,b,c,d,e){var f=1.70158,g=0,h=d;if(0==b)return c;if(1==(b/=e))return c+d;if(g||(g=.3*e),h<Math.abs(d)){h=d;var f=g/4}else var f=g/(2*Math.PI)*Math.asin(d/h);return-(h*Math.pow(2,10*(b-=1))*Math.sin((b*e-f)*2*Math.PI/g))+c},easeOutElastic:function(a,b,c,d,e){var f=1.70158,g=0,h=d;if(0==b)return c;if(1==(b/=e))return c+d;if(g||(g=.3*e),h<Math.abs(d)){h=d;var f=g/4}else var f=g/(2*Math.PI)*Math.asin(d/h);return h*Math.pow(2,-10*b)*Math.sin((b*e-f)*2*Math.PI/g)+d+c},easeInOutElastic:function(a,b,c,d,e){var f=1.70158,g=0,h=d;if(0==b)return c;if(2==(b/=e/2))return c+d;if(g||(g=e*.3*1.5),h<Math.abs(d)){h=d;var f=g/4}else var f=g/(2*Math.PI)*Math.asin(d/h);return 1>b?-.5*h*Math.pow(2,10*(b-=1))*Math.sin((b*e-f)*2*Math.PI/g)+c:.5*h*Math.pow(2,-10*(b-=1))*Math.sin((b*e-f)*2*Math.PI/g)+d+c},easeInBack:function(a,b,c,d,e,f){return void 0==f&&(f=1.70158),d*(b/=e)*b*((f+1)*b-f)+c},easeOutBack:function(a,b,c,d,e,f){return void 0==f&&(f=1.70158),d*((b=b/e-1)*b*((f+1)*b+f)+1)+c},easeInOutBack:function(a,b,c,d,e,f){return void 0==f&&(f=1.70158),(b/=e/2)<1?d/2*b*b*(((f*=1.525)+1)*b-f)+c:d/2*((b-=2)*b*(((f*=1.525)+1)*b+f)+2)+c},easeInBounce:function(a,b,c,d,e){return d-jQuery.easing.easeOutBounce(a,e-b,0,d,e)+c},easeOutBounce:function(a,b,c,d,e){return(b/=e)<1/2.75?d*7.5625*b*b+c:2/2.75>b?d*(7.5625*(b-=1.5/2.75)*b+.75)+c:2.5/2.75>b?d*(7.5625*(b-=2.25/2.75)*b+.9375)+c:d*(7.5625*(b-=2.625/2.75)*b+.984375)+c},easeInOutBounce:function(a,b,c,d,e){return e/2>b?.5*jQuery.easing.easeInBounce(a,2*b,0,d,e)+c:.5*jQuery.easing.easeOutBounce(a,2*b-e,0,d,e)+.5*d+c}});


//Normal Call Back Functions
jQuery(document).ready(function($) {
  //jQuery('[data-toggle="tooltip"]').tooltip()
    selectnav('menus', {
    label: 'Menu',
    nested: true,
    indent: '-->'
  });
jQuery("#menus-wrapper") .css({"opacity":1})
jQuery("#selectnav1") .insertAfter('#menus-wrapper')
jQuery("#header").height(jQuery(window).height());


// ReSize Function

jQuery(window).resize(function() {
  jQuery("#header").height(jQuery(window).height());
});

jQuery("a.btnheadertoggle") .click(function(event) {
	/* Act on the event */
	jQuery("#wrappermain-pix") .toggleClass("pix-active");
	jQuery("#playlistarea").removeClass("pix-active-playlist");
    setTimeout(function(){
      jQuery(window).trigger('resize')
},300)
	return false;
});
// click menu
jQuery(".jp-menu,.btnclose-playlist") .click(function(event) {
	/* Act on the event */
	jQuery("#playlistarea").toggleClass("pix-active-playlist");
	return false;
});
jQuery("#header") .click(function(event) {
  /* Act on the event */
  event.stopPropagation();
});
jQuery("body") .click(function(event) {
  /* Act on the event */
  var a = jQuery("#wrappermain-pix") .hasClass("pix-sticky-header");
  if (!a){
  jQuery("#wrappermain-pix") .addClass("pix-active");
  jQuery("#playlistarea").removeClass("pix-active-playlist");
  } 
});
  });

function px_parrallax_callback(){
  "use strict";
  jQuery("#banner") .css({
    "opacity" : 1
  })

      parallaxfullwidth () 
      parallaxelementheight()
       jQuery.stellar({
      horizontalScrolling: false,
      positionProperty: 'transform',
      verticalOffset: 100
      });
     jQuery(window).resize(function(event) {
    /* Act on the event */
  
      parallaxfullwidth () 
      parallaxelementheight()
     });

}
function parallaxelementheight () {
  "use strict";
 jQuery(".pix-parrallax") .each(function(index, el) {
   var a = jQuery(window).height() ;
   jQuery(this).css("min-height",a);

  });
}
function galleryheight () {
  "use strict";
   resizeGalleryArt()
 jQuery(".gallery.gallery-listing,.gallery.gallery-listing .cycle-slideshow article") .each(function(index, el) {
   var a = jQuery(window).height() ;
   jQuery(this).css("height",a);

  });

 jQuery(".gallery.gallery-listing .cycle-slideshow article") .each(function(index, el) {
  

  var a = jQuery(this).find('img') .attr('src') ;
  jQuery(this).find('figure').css({
    "background-image":"url("+a+")"
  }) 
 });

}

function resizeGalleryArt () {
  var defaultwidth = 320;
  var windowwidth = jQuery(".cycle-slideshow").width();
  var d = windowwidth / defaultwidth;
  var m = Math.round(d);
  var f = windowwidth / m;
  jQuery('#gallery-css').remove()
  jQuery('body') .append("<style id='gallery-css'>.gallery.gallery-listing .cycle-slideshow article{width:"+f+"px}</style>")
  jQuery('.cycle-slideshow').cycle('reinit');
}
function parallaxfullwidth () {
  "use strict";
  jQuery(".parrallax-bg,.parallaxfullwidth").each(function(){
      var w = jQuery("#main").width();
      var m = jQuery(this).parents(".container").width();
      var e = w-m;
      if (e <= 0) {
          jQuery(this).css({"left":0,"top":0,"width":w });
          setTimeout(function(){
          jQuery(".parrallax-bg") .css({"opacity":1})
          },600)
      } else {

      jQuery(this).css({"left":-(e/2),"top":0,"width":w });
       setTimeout(function(){
        jQuery(".parrallax-bg") .css({"opacity":1})
       },600)
      }
    
  });
}

function galleryMain (){
changeSize()

     var gallery = jQuery('#banner-container .swiper-container').swiper({
        slidesPerView:3,
        speed:750,
        watchActiveIndex: false,
        centeredSlides: true,
        simulateTouch:false,
        pagination:'.pagination',
        paginationClickable: true,
        onSlideClick: function(gallery,event){

            var a =jQuery(gallery.clickedSlide).hasClass("swiper-slide-active") ;
          if (!a) {
            var b = jQuery(".pagination span") .length;
               var c = gallery.clickedSlideIndex - 3 ;
                if(b == c) {
                    jQuery(".pagination span:eq(0)").trigger('click')                        
                }else {
                    jQuery(".pagination span:eq("+c+")").trigger('click')
           }
          }
        },
        resizeReInit: true,
        grabCursor: false,
        loop:true,
        initialSlide:1,
        onSlideChangeStart:function(){
            changeSize();
            var a = gallery.activeLoopIndex;
            gallerybg.swipeTo(a)
            gallery.resizeFix(true) 
        },
        onImagesReady: function(){
            changeSize();
            gallery.resizeFix(true) 
        }
});
     var gallerybg = jQuery('#banner-background .swiper-container').swiper({
    slidesPerView:1,
    speed:750,
    simulateTouch:false,
    resizeReInit: true,
    grabCursor: false,
    loop:true,
    initialSlide:1,
    onImagesReady: function(){
         gallerybg.resizeFix(true) 
    }
});
function changeSize() {
    //Unset Width
     var h = jQuery(window).height();
    var w = jQuery("#main").width();
      jQuery('#banner').height(h)
        jQuery("#banner-container") .height(w/3);
          jQuery("#banner-container") .css({
            "top":((h-(w/3))/2)/2,
            "padding-top" :((h-(w/3))/2),
            "padding-bottom" :((h-(w/3))/2)
          })
        jQuery("#banner-container article,#banner-container .inner") .css({
            "width" : w/3,
            "height" : w/3
        })
    jQuery('#banner-container .swiper-slide').css('width','')
    //Get Size
    var imgWidth = jQuery('#banner-container .swiper-slide .inner').width();
    if (imgWidth+40>jQuery("#main").width()) 
    imgWidth = jQuery("#main").width();
    //Set Width
    jQuery('#banner-container .swiper-slide').css('width', imgWidth);
}

//Smart resize
jQuery(window).resize(function(){
    changeSize()
    gallery.resizeFix(true) 
    gallerybg.resizeFix(true) 
});
jQuery(window).load(function(){
    changeSize()
    gallery.resizeFix(true) 
    gallerybg.resizeFix(true) 
});
jQuery("#banner-container") .css({
  "opacity":1
})
 gallerybg.resizeFix(true) 
}

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
				maxWidth: 200,
                maxHeight:100,
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

jQuery(document).ready(function($) {
  //  Textarea Functions
  jQuery(' textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"]').focus(function() {
    if (!jQuery(this).data("DefaultText")) jQuery(this).data("DefaultText", jQuery(this).val());
    if (jQuery(this).val() != "" && jQuery(this).val() == $(this).data("DefaultText")) jQuery(this).val("");
    }).blur(function() {
      if (jQuery(this).val() == "") jQuery(this).val(jQuery(this).data("DefaultText"));
    });
  //  Textarea Functions End
});
// countdown 
function px_event_countdown(year_event,month_event,date_event){
	"use strict";
	var austDay = new Date();
	austDay = new Date(year_event,month_event-1,date_event);
	jQuery('#defaultCountdown').countdown({until: austDay,
	layout: '&lt;span&gt;{dn} &lt;small&gt;days&lt;/small&gt;&lt;/span&gt;  &lt;span&gt;{hn} &lt;small&gt;Hours&lt;/small&gt;&lt;/span&gt;  &lt;span&gt;{mn} &lt;small&gt;mins&lt;/small&gt;&lt;/span&gt; &lt;span&gt;{sn} &lt;small&gt;secs&lt;/small&gt;&lt;/span&gt; '});
}

// Like Counter
function px_like_counter(theme_url, post_id){
   jQuery("#like_this"+post_id).hide();
   jQuery("#loading_div"+post_id).show();
   var dataString = 'post_id=' + post_id;
            jQuery.ajax({
                type:"POST",
                url: theme_url+"/include/like_counter.php",
    data:dataString, 
                success:function(response){
     jQuery("#loading_div"+post_id).hide();
     jQuery("#you_liked"+post_id).show();
     jQuery("#like_counter"+post_id).html(response);
	 jQuery(".like_counter"+post_id).html(response);
                }
            });
            //return false;
}

function px_rtl_menu(){
	jQuery( '#menus-wrapper' ).multilevelpushmenu({
		mode: 'cover',
		direction: 'rtl',
		preventItemClick: false
	  });	
}
// left to right
function px_ltr_menu(){
	jQuery( '#menus-wrapper' ).multilevelpushmenu({
		mode: 'cover',
		preventItemClick: false
	  });	
}

// map load by ajax
function show_mapp(id, add,lat, long, zoom, home_url, get_template_directory_uri) {
	"use strict";					
	var a = jQuery("div.post-"+id).find("[id^=map]").length;
	if (a > 1) {
		if(jQuery(".event-map-load").hasClass('open-map')){
			jQuery(".event-map-load").removeClass('open-map');
		} else {
			jQuery(".event-map-load div.post-"+id).addClass('open-map');
		}
		if(jQuery(".event-detail") .find("a.map-marker").hasClass('open-marker')){
			jQuery(".event-detail") .find("a.map-marker").removeClass('open-marker');
		} else {
			jQuery(".event-detail") .find("a.map-marker").addClass('open-marker');
		}
		jQuery("div.post-"+id).toggleClass("event-map");
		} else {
			jQuery(".event-detail") .find("a.map-marker i").hide();
			jQuery(".event-detail") .find("a.map-marker").append('<i class="fa fa-spinner fa-spin"></i>');
			var dataString = 'post_id=' + id + '&add=' + add + '&lat=' + lat + '&long=' + long + '&zoom='+ zoom + '&get_template_directory_uri='+ get_template_directory_uri;
			jQuery.ajax({
				type:"POST",
				url: get_template_directory_uri+"/include/map_load.php",
				data:dataString, 
				success:function(response){
					jQuery(".event-detail") .find("a.map-marker").addClass('open-marker');
					jQuery(".event-detail") .find("a.map-marker i").show();
					jQuery(".event-detail") .find("a.map-marker .fa-spin").hide();
					jQuery("div.post-"+id).toggleClass("event-map");
					
					jQuery(".event-map-load").toggleClass("open-map");
					
					jQuery("div.post-"+id).show();
					jQuery("#map_canvas"+id).html(response);
					//jQuery(".map-marker"+id).hide();
				
				}
			});
		}
}

