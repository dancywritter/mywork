
/*!
 * hoverIntent r7 // 2013.03.11 // jQuery 1.9.1+
 * http://cherne.net/brian/resources/jquery.hoverIntent.html
 *
 * You may use hoverIntent under the terms of the MIT license.
 * Copyright 2007, 2013 Brian Cherne
 */

/*
 SelectNav.js (v. 0.1)
 Converts your <ul>/<ol> navigation into a dropdown list for small screens
 https://github.com/lukaszfiszer/selectnav.js
*/
window.selectnav=function(){
 	return function(p,q){var a,h=function(b){var c;b||(b=window.event);b.target?c=b.target:b.srcElement&&(c=b.srcElement);3===c.nodeType&&(c=c.parentNode);c.value&&(window.location.href=c.value)},k=function(b){b=b.nodeName.toLowerCase();return"ul"===b||"ol"===b},l=function(b){for(var c=1;document.getElementById("selectnav"+c);c++);return b?"selectnav"+c:"selectnav"+(c-1)},n=function(b){g++;var c=b.children.length,a="",d="",f=g-1;if(c){if(f){for(;f--;)d+=r;d+=" "}for(f=0;f<
c;f++){var e=b.children[f].children[0];if("undefined"!==typeof e){var h=e.innerText||e.textContent,i="";j&&(i=-1!==e.className.search(j)||-1!==e.parentElement.className.search(j)?m:"");s&&!i&&(i=e.href===document.URL?m:"");a+='<option value="'+e.href+'" '+i+">"+d+h+"</option>";t&&(e=b.children[f].children[1])&&k(e)&&(a+=n(e))}}1===g&&o&&(a='<option value="">'+o+"</option>"+a);1===g&&(a='<select class="selectnav" id="'+l(!0)+'">'+a+"</select>");g--;return a}};if((a=document.getElementById(p))&&k(a)){document.documentElement.className+=
" js";var d=q||{},j=d.activeclass||"active",s="boolean"===typeof d.autoselect?d.autoselect:!0,t="boolean"===typeof d.nested?d.nested:!0,r=d.indent||"\u2192",o=d.label||"- Navigation -",g=0,m=" selected ";a.insertAdjacentHTML("afterend",n(a));a=document.getElementById(l());a.addEventListener&&a.addEventListener("change",h);a.attachEvent&&a.attachEvent("onchange",h)}}}();

// jQuery(document).ready(function(){ 
//    selectnav('menus', {
//     label: 'Menu',
//     nested: true,
//      indent: '-'
//    });
// });


(function(e){e.fn.hoverIntent=function(t,n,r){var i={interval:100,sensitivity:7,timeout:0};if(typeof t==="object"){i=e.extend(i,t)}else if(e.isFunction(n)){i=e.extend(i,{over:t,out:n,selector:r})}else{i=e.extend(i,{over:t,out:t,selector:n})}var s,o,u,a;var f=function(e){s=e.pageX;o=e.pageY};var l=function(t,n){n.hoverIntent_t=clearTimeout(n.hoverIntent_t);if(Math.abs(u-s)+Math.abs(a-o)<i.sensitivity){e(n).off("mousemove.hoverIntent",f);n.hoverIntent_s=1;return i.over.apply(n,[t])}else{u=s;a=o;n.hoverIntent_t=setTimeout(function(){l(t,n)},i.interval)}};var c=function(e,t){t.hoverIntent_t=clearTimeout(t.hoverIntent_t);t.hoverIntent_s=0;return i.out.apply(t,[e])};var h=function(t){var n=jQuery.extend({},t);var r=this;if(r.hoverIntent_t){r.hoverIntent_t=clearTimeout(r.hoverIntent_t)}if(t.type=="mouseenter"){u=n.pageX;a=n.pageY;e(r).on("mousemove.hoverIntent",f);if(r.hoverIntent_s!=1){r.hoverIntent_t=setTimeout(function(){l(n,r)},i.interval)}}else{e(r).off("mousemove.hoverIntent",f);if(r.hoverIntent_s==1){r.hoverIntent_t=setTimeout(function(){c(n,r)},i.timeout)}}};return this.on({"mouseenter.hoverIntent":h,"mouseleave.hoverIntent":h},i.selector)}})(jQuery)


var $ = jQuery;

jQuery.easing['easeInOutBack'] = function (x, t, b, c, d, s) {
    if (s == undefined) s = 1.70158;
    if ((t /= d / 2) < 1) return c / 2 * (t * t * (((s *= (1.525)) + 1) * t - s)) + b;
    return c / 2 * ((t -= 2) * t * (((s *= (1.525)) + 1) * t + s) + 2) + b;
};

jQuery(document).ready(function($) {
 	jQuery(".subheader-on.header-sticky-off #header").live("mouseover",function() {
    /* Stuff to do when the mouse enters the element */
    jQuery("#mp-pusher").addClass('mp-pushed').css({
      "-moz-transform": "translate3d(205px, 0px, 0px)",
      "-webkit-transform": "translate3d(205px, 0px, 0px)",
      "-o-transform": "translate3d(205px, 0px, 0px)",
      "transform": "translate3d(205px, 0px, 0px)"
    });
    jQuery(".mp-level:first").addClass("mp-level-open")
    jQuery("#wrappermain-pix").addClass('wrapper-menu-loaded')
    jQuery("#wrappermain-pix").addClass('mp-wrapper-main');
  }) ;
  jQuery(".subheader-on.header-sticky-off #header").live("mouseleave",function() {
     /* Stuff to do when the mouse leaves the element */
    jQuery("#mp-pusher").removeClass('mp-pushed').css({
      "-moz-transform": "translate3d(0, 0px, 0px)",
      "-webkit-transform": "translate3d(0, 0px, 0px)",
      "-o-transform": "translate3d(0, 0px, 0px)",
      "transform": "translate3d(0, 0px, 0px)"
    });
    jQuery("#wrappermain-pix").removeClass('wrapper-menu-loaded')
    jQuery("#wrappermain-pix").removeClass('mp-wrapper-main')
  });
 jQuery(".switch-heder-sticky") .live("click",function(event) {
	if($(this).is(':checked')){
	  jQuery("#wrappermain-pix") .removeClass("header-sticky-off");
	  jQuery("#wrappermain-pix") .addClass("header-sticky-on");
	  jQuery("#wrappermain-pix") .addClass("wrapper-menu-loaded");
	   jQuery(".mp-level:first").addClass("mp-level-open");
	jQuery("#mp-pusher") .addClass('mp-pushed') .css({
	"-moz-transform":"translate3d(205px, 0px, 0px)",
	"-webkit-transform":"translate3d(205px, 0px, 0px)",
	"-o-transform":"translate3d(205px, 0px, 0px)",
	"transform":"translate3d(205px, 0px, 0px)"
	});
	setTimeout(function(){
		jQuery("body").trigger('resize')},100)
	}else{
	  jQuery("#wrappermain-pix") .addClass("header-sticky-off");
	  jQuery("#wrappermain-pix") .removeClass("header-sticky-on");
	  jQuery("#wrappermain-pix") .removeClass("wrapper-menu-loaded");
	setTimeout(function(){jQuery("body").trigger('resize')},100)
	}
	});
	//
	jQuery(".switch-sub-header") .live("click",function(event) {
			if($(this).is(':checked')){
				jQuery("#wrappermain-pix") .removeClass("subheader-off");
				jQuery("#wrappermain-pix") .addClass("subheader-on");
         setTimeout(function(){jQuery("body").trigger('resize')},100)
			}else{
				jQuery("#wrappermain-pix") .addClass("subheader-off");
				jQuery("#wrappermain-pix") .removeClass("subheader-on");
         setTimeout(function(){jQuery("body").trigger('resize')},100)
			}
		});
		
		jQuery("ul.products li .text h3").remove();
 		jQuery(".mp-level:first").addClass("mp-level-open");
      	jQuery( "#main" ).one("mousemove",function( event ) {
        	var ab = jQuery("#wrappermain-pix").hasClass(' header-sticky-on')
  			/* Stuff to do when the mouse enters the element */
      if (ab) {
        return false
      }else
        jQuery("#wrappermain-pix").removeClass('wrapper-menu-loaded');
    jQuery("#mp-pusher") .removeClass('mp-pushed') .css({
    "-moz-transform":"translate3d(0, 0px, 0px)",
    "-webkit-transform":"translate3d(0, 0px, 0px)",
    "-o-transform":"translate3d(0, 0px, 0px)",
    "transform":"translate3d(0, 0px, 0px)"
  });
});

jQuery(".sub-menu").parents("li").addClass("parentIcon");

jQuery('p').each(function() {
	'use strict';
    var $this = $(this);
    if($this.html().replace(/\s|&nbsp;/g, '').length == 0)
        $this.remove();
});
jQuery("ul.products li div.text a").addClass("colrhvr");
jQuery('.blog .element_size_50:even(1)').addClass("listitem4");

// TextArea Javascript
  jQuery(' textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"]').focus(function() {
    if (!$(this).data("DefaultText")) $(this).data("DefaultText", $(this).val());
    if ($(this).val() != "" && $(this).val() == $(this).data("DefaultText")) $(this).val("");
  }).blur(function() {
    if ($(this).val() == "") $(this).val($(this).data("DefaultText"));
  });
// TextArea Javascript


jQuery('.services article:nth-child(4n+4), .team article:nth-child(5n+5), .price-table.price-style2:nth-child(4n+4)').addClass("listitem4");

cs_skills_shortcode_script();
});
// Wait for everything to be ready
function perfect_masonary_gallery(){
	'use strict';
	var opt = {
		  layoutMode: 'perfectMasonry',
		  perfectMasonry: {
			layout: 'vertical',
			liquid: true,
			columnWidth: 226, 
			rowHeight: 170 
		  }
		};
		// Set default isotope
		jQuery('#container-gallery').isotope(opt);
		jQuery(window).resize(function(){
		  jQuery('#container-gallery').isotope(opt);
		})
	
}

function portfolio_views(id,widthitem,itemheight) {
	'use strict';	
  	var id = jQuery("#"+id);
  	// cache container
  	var optGallery = {
    layoutMode: 'perfectMasonry',
    resizable:false,
    perfectMasonry: {
      layout: 'vertical',
      liquid: true,
      columnWidth: widthitem, 
      rowHeight: itemheight
    }
  };
  var $container = $(id);
  // initialize isotope
  $container.imagesLoaded(function(){
    $container.isotope(optGallery);
  });
  $(window).resize(function() {
    $container.isotope(optGallery);
  })

  // filter items when filter link is clicked
  jQuery('#filters a').click(function() {
    /* Act on the event */
    jQuery('#filters a').removeClass("selected");
    jQuery(this).addClass('selected');
    var selector = jQuery(this).attr('data-filter');
    $container.isotope({
      filter: selector
    });
    return false;
  });
}
function portfolio_views_mas(id) {
	'use strict';
  	var id = jQuery("#"+id);
  	// cache container
 	 var optGallery = {
    	layoutMode: 'masonry',
    	resizable:true,
   		masonry: {
    		columnWidth: 1
    	}
  };
  var $container = $(id);
  // initialize isotope

    $container.isotope(optGallery);

  // filter items when filter link is clicked
  jQuery('#filters a').click(function() {
    /* Act on the event */
    jQuery('#filters a').removeClass("selected");
    jQuery(this).addClass('selected');
    var selector = jQuery(this).attr('data-filter');
    $container.isotope({
      filter: selector
    });
    return false;
  });
}
function cs_skills_shortcode_script() {
	'use strict';
  jQuery("[data-loadbar]").each(function(index) {
    var d = jQuery(this).attr('data-loadbar');
    var e = jQuery(this).attr('data-loadbar-text');
    var ani = jQuery(this).find('div');
    jQuery(ani).animate({
      width: d + "%"
    }, 2000, "easeInOutBack").next().html(e);
  });
}
function default_mas_gallery(){
	'use strict';
  galleryMasonryPortresize()
		var optM = {
    resizable:true,
    itemSelector:'.box',
    layoutMode: 'masonry',
    masonry: {
      columnWidth: 1
    }
  };
	// Set default isotope
  jQuery('#default_mas_gallery').isotope(optM);
  jQuery(window).resize(function(event) {
    /* Act on the event */
    galleryMasonryPortresize ()
  });
  jQuery(window).load(function() {
	jQuery('#default_mas_gallery').isotope(optM);
    /* Act on the event */
  });

}


function gallery_mas(){
	'use strict';
  galleryMasonryPortresize()
		var optM = {
    resizable:true,
    itemSelector:'.box',
    layoutMode: 'masonry',
    masonry: {
      columnWidth: 1
    }
  };
	// Set default isotope
  jQuery('#gallery').isotope(optM);
  jQuery(window).resize(function(event) {
    /* Act on the event */
    galleryMasonryPortresize ()
  });
  jQuery(window).load(function() {
	jQuery('#gallery').isotope(optM);
    /* Act on the event */
  });

}

function portfolio_mas(){
		'use strict';
		var opt = {
		  layoutMode: 'perfectMasonry',
		  perfectMasonry: {
			layout: 'vertical',
			liquid: true,
			columnWidth: 226, 
			rowHeight: 170 
		  }
		};
		// Set default isotope
		jQuery('#container').isotope(opt);
		jQuery(window).resize(function(){
		   jQuery('#container').isotope(opt);
		})
	
}

// Resize Funciton
function resizegallery() {
	'use strict';
	  var b = 289; //Actual Width of the Function
	  var mb = jQuery("#gallery .box").css("margin-bottom").replace("px", "");
	  jQuery("#gallery").css({
		"padding-top": mb + "px",
		"padding-left": mb + "px"
	  })
	  parseInt(mb, 10);
	  var c = jQuery("#gallery .box").parent("#gallery").width();
	  var d = c / b;
	  var m = Math.round(d);
	  var f = c / m;
	  jQuery("#gallery .box").css({
		"width": (f - .5) - mb
	  });
}
// Resize Funciton

function cs_swipe_gallery() {
	'use strict';
	jQuery("#bannerwrapper").height(jQuery(window).height());
	jQuery(window).resize(function(event) {
		/* Act on the event */
		 jQuery("#bannerwrapper").height(jQuery(window).height());
	});
    jQuery("#bannerwrapper.cs_fullwidth_banner .banner-slides .swiper-slide").each(function(index, el) {
    	var a = jQuery(this).find("img").attr("src");
    jQuery(this) .css({"background":"url("+a+") no-repeat center center"});

});
  var isDragging = false;
  jQuery(".swiper-slide .gallery_stack_element .fa-play").live("mousedown", function() {
    jQuery(window).mousemove(function() {
      isDragging = true;
      jQuery(window).unbind("mousemove");

    });
  })
    .live("mouseup", function() {
      var wasDragging = isDragging;
      isDragging = false;
      jQuery(window).unbind("mousemove");
      if (!wasDragging) {

        jQuery(".original_size #slider.swiper-container").css("height", "100%");
        swiperbanner.resizeFix();
        jQuery(this).parents(".gallery_stack_element ").addClass("active");
        jQuery(this).hide();
         jQuery(this).next().show();
        jQuery(this).parents(".swiper-slide").find(".cs-gal-video").show();
        jQuery(".gallery_stack_element") .animate({"right":"100%"}, 400)
        jQuery(".swiper-thumb-container,.swipe-right,.swipe-left,.caption-area-slider,.slide-caption h2").animate({
          "opacity": "0",
          "visibility": "hidden"
        },400);
        return false;

      }
    });

  jQuery(".slide-caption").live("mousedown", function() {
    jQuery(window).mousemove(function() {
     isDragging = true;
      jQuery(window).unbind("mousemove");

    });
  }).live("mouseup", function() {
    return false;
  }); 
   jQuery(".swiper-slide .gallery_stack_element .fa-times-circle-o").live("mousedown", function() {
    jQuery(window).mousemove(function() {
      isDragging = true;
      jQuery(window).unbind("mousemove");

    });
  })
    .live("mouseup", function() {
      var wasDragging = isDragging;
      isDragging = false;
      jQuery(window).unbind("mousemove");
      if (!wasDragging) {
      jQuery(".original_size #slider.swiper-container").css("height", "calc(100% - 84px)");
      swiperbanner.resizeFix()
      jQuery(this).parents(".gallery_stack_element ").removeClass("active");
      var vidwrap = jQuery(this).parents(".gallery_stack_element").prev();
      vidwrap.html(vidwrap.html());
      jQuery(this).hide();
      jQuery(this).prev ().show();
      jQuery(this).parents(".swiper-slide").find(".cs-gal-video").hide();
      jQuery(".gallery_stack_element") .animate({"right":"-62px"}, 300)
      jQuery(".swiper-thumb-container,.swipe-right,.swipe-left,.caption-area-slider,.slide-caption h2").animate({
        "opacity": "1",
        "visibility": "visible"
      },600);
      return false;

      }
    });

    jQuery("#slider .swiper-slide img") .each(function(index, el) {
      jQuery(this).load(function(){
        jQuery(this).css({"opacity":"1","visibility":"visible"})
      })
    });
  jQuery(window).load(function($) {
    jQuery("#carousearea .swiper-slide:first-child").addClass("bgcolr");
  });
  var swiperbanner = jQuery('.banner-slides').swiper({
    mode: "horizontal",
    onlyExternal: false,
    loop: true,
    grabCursor: true,
    useCSS3Transforms: true,
    mousewheelControl: true,
    speed: 1000,
    onSlideChangeStart: function(swiper) {
      var c = jQuery("#carousearea").length;
      if (c > 0) {
        var index = swiperbanner.activeLoopIndex
        // swiperMControl.swipeTo (index);
        $('.mc-control .bgcolr').removeClass('active')
        $(".mc-control .swiper-slide:eq(" + index + ")").addClass('active');
        var a = jQuery("#carousearea .swiper-slide.active").hasClass("swiper-slide-visible")
        var b = jQuery("#carousearea .swiper-slide.active").index();

        if (!a) {
          swiperMControl.swipeTo(b);
        }
      }
    }
  });
  var allowMovieClick = true;
  var slide = jQuery("#carousearea").width();
  var swiperMControl = jQuery('.mc-control').swiper({
    mode: "horizontal",
    scrollContainer: false,
    grabCursor: true,
    momentumBounce: false,
    visibilityFullFit: true,
    slidesPerView: 'auto',
    onTouchMove: function() {
      allowMovieClick = true
    },
    onTouchEnd: function() {
      setTimeout(function() {
        allowMovieClick = true
      }, 100)
    }
  });
  var isDragging = false;
  jQuery(".mc-control .swiper-slide").live("mousedown", function() {
    jQuery(window).mousemove(function() {
      isDragging = true;
      jQuery(window).unbind("mousemove");

    });
  })
    .live("mouseup", function() {
      var wasDragging = isDragging;
      isDragging = false;
      jQuery(window).unbind("mousemove");
      if (!wasDragging) {
    var index = jQuery(this).index();
    swiperbanner.swipeTo(index)


      }
    });
  jQuery("#carousearea .swiper-slide-visible:last").live('click', function(e) {
    var a = jQuery(this).next().hasClass('swiper-slide')
    if (a) {
      swiperMControl.swipeNext()
    }
  });
  jQuery("#carousearea .swiper-slide-visible:first").live('click', function(e) {
    var a = jQuery(this).prev().hasClass('swiper-slide')
    if (a) {
      swiperMControl.swipePrev()
    }
  });
  jQuery(".swipe-right").live('click', function(e) {
    /* Act on the event */
    swiperbanner.swipeNext()

  });
  jQuery(".swipe-left").live('click', function(e) {
    swiperbanner.swipePrev()

  });
  jQuery(".swipe-right-thumb").live('click', function(e) {
    /* Act on the event */
    var s = jQuery("#carousearea .swiper-slide.swiper-slide-visible").length;
    var l = swiperMControl.activeIndex
    swiperMControl.swipeTo(l+s);

  });
  jQuery(".swipe-left-thumb").live('click', function(e) {
    var s = jQuery("#carousearea .swiper-slide.swiper-slide-visible").length;
    var l = swiperMControl.activeIndex
    if (s > l){
      swiperMControl.swipeTo(0);
    }else {
    swiperMControl.swipeTo(l-s);
    }

  });

}
function LazyLoad (parentname,itemname) {
	'use strict';		
	var $a = jQuery(parentname+" "+itemname)
     // Act on the event 
     if ($.browser.msie  && parseInt($.browser.version, 10) > 8) {
		$a.addClass("isLoaded");
	} else {
    $a.each(function(index) {
       setTimeout(function(el) {
            el.addClass("isLoaded");
        }, index * 40, $(this));
    });
	}
}

jQuery(document).ready(function($) {
	'use strict';
	var flag = jQuery( "#main div.aside" ).length;
	if(flag > 0){
		jQuery("#main").addClass("container-bg-color");
	}
 });


function portfolioFilter() {
	'use strict';
	var b = 258; //Actual Width of the Function
	var c = jQuery(".cs-thumb-gutter .element").parent("#container").width();
	var d = c / b;
	var m = Math.ceil(d);
	var f = c / m;
	jQuery(".cs-thumb-gutter .element").css({
    	"width": (f - .5),
    	"height": (f/1.325) - 0.5
  });
}
function galleryMasonryresize() {
 'use strict';	
  var b = 380; //Actual Width of the Function
  var c = jQuery(".portfolio-mas #container").width();
  var d = c / b;
  var m = Math.ceil(d);
  var f = c / m;
  jQuery(".portfolio-mas .element").css({
    "width": (f - .5)
  });
}
function galleryMasonryPortresize() {
  'use strict';		
  var b = 390; //Actual Width of the Function
  var c = jQuery("#gallery").width();
  var d = c / b;
  var m = Math.ceil(d);
  var f = c / m;
  jQuery("#gallery .box ").css({
    "width": (f - 1.5)
  });
}
function portfolioFilter_large() {
  'use strict';
  var b = 350; //Actual Width of the Function
  var c = jQuery(".cs-thumb-large .element").parent("#container").width();
  var d = c / b;
  var m = Math.ceil(d);
  var f = c / m;
  jQuery(".cs-thumb-large .element").css({
    "width": (f - .5),
   "height": (f/1.325) - 0.5
  });
}
function portfolioFilter_med() {
  'use strict';
  var b = 297; //Actual Width of the Function
  var c = jQuery(".cs-thumb-medium .element").parent("#container").width();
  var d = c / b;
  var m = Math.ceil(d);
  var f = c / m;
  jQuery(".cs-thumb-medium .element").css({
    "width": (f - .5),
     "height": (f/1.325) - 0.5
  });
}
function portfolioFilter_med_v1() {
  'use strict';
  var b = 297; //Actual Width of the Function
  var c = jQuery(".cs-thumb-medium .element").parent("#container").width();
  var d = c / b;
  var m = Math.ceil(d);
  var f = c / m;
  jQuery(".cs-thumb-medium .element").css({
    "width": (f - .5),
     "height": (f/0.999) - 0.5
  });
}
function portfolioFilter_med_v2() {
  'use strict';
  var b = 297; //Actual Width of the Function
  var c = jQuery(".cs-thumb-large .element").parent("#container").width();
  var d = c / b;
  var m = Math.ceil(d);
  var f = c / m;
  jQuery(".cs-thumb-large .element").css({
    "width": (f - .5),
     "height": (f/0.955) - 0.5
  });
}
function blogMaso_width() {
  'use strict';
  var b = 360; //Actual Width of the Function
  var c = jQuery(".postlist-mas-listing  .box").parent(".postlist-mas-listing").width();
  var d = c / b;
  var m = Math.ceil(d);
  var f = c / m;
  jQuery(".postlist-mas-listing  .box").css({
    "width": (f - .5)
  });
}



function loadArticle(pageNumber,home_url){
	'use strict';    
	jQuery('a.load-more').show('fast');
	jQuery.ajax({
		url: home_url+"/wp-admin/admin-ajax.php",
		type:'POST',
		data: "action=load_more_scroll&page_no="+ pageNumber + '&loop_file=loop', 
		success: function(html){
			jQuery('a.load-more').hide('1000');
			jQuery(".postlist").append(html);    // This will be the div where our content will be loaded
		}
	});
	return false;
}

jQuery('audio,video').not("#player1").mediaelementplayer({
	sfeatures: ['playpause']
	});
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

function resizevideo () {
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