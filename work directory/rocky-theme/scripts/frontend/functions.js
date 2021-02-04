window.selectnav=function(){return function(p,q){var a,h=function(b){var c;b||(b=window.event);b.target?c=b.target:b.srcElement&&(c=b.srcElement);3===c.nodeType&&(c=c.parentNode);c.value&&(window.location.href=c.value)},k=function(b){b=b.nodeName.toLowerCase();return"ul"===b||"ol"===b},l=function(b){for(var c=1;document.getElementById("selectnav"+c);c++);return b?"selectnav"+c:"selectnav"+(c-1)},n=function(b){g++;var c=b.children.length,a="",d="",f=g-1;if(c){if(f){for(;f--;)d+=r;d+=" "}for(f=0;f<
c;f++){var e=b.children[f].children[0];if("undefined"!==typeof e){var h=e.innerText||e.textContent,i="";j&&(i=-1!==e.className.search(j)||-1!==e.parentElement.className.search(j)?m:"");s&&!i&&(i=e.href===document.URL?m:"");a+='<option value="'+e.href+'" '+i+">"+d+h+"</option>";t&&(e=b.children[f].children[1])&&k(e)&&(a+=n(e))}}1===g&&o&&(a='<option value="">'+o+"</option>"+a);1===g&&(a='<select class="selectnav" id="'+l(!0)+'">'+a+"</select>");g--;return a}};if((a=document.getElementById(p))&&k(a)){document.documentElement.className+=
" js";var d=q||{},j=d.activeclass||"active",s="boolean"===typeof d.autoselect?d.autoselect:!0,t="boolean"===typeof d.nested?d.nested:!0,r=d.indent||"\u2192",o=d.label||"- Navigation -",g=0,m=" selected ";a.insertAdjacentHTML("afterend",n(a));a=document.getElementById(l());a.addEventListener&&a.addEventListener("change",h);a.attachEvent&&a.attachEvent("onchange",h)}}}();

//Easing Animations
jQuery.easing['easeOutCubic'] = function(x, t, b, c, d) {
  return c * ((t = t / d - 1) * t * t + 1) + b;
}

jQuery("a.music-btn").click(function() {
    jQuery(".player-audio").toggle();
})

jQuery.easing['easeInOutBack'] = function(x, t, b, c, d, s) {
  if (s == undefined) s = 1.70158;
  if ((t /= d / 2) < 1) return c / 2 * (t * t * (((s *= (1.525)) + 1) * t - s)) + b;
  return c / 2 * ((t -= 2) * t * (((s *= (1.525)) + 1) * t + s) + 2) + b;
};
jQuery(document).ready(function() {
jQuery(window).resize(function(event) {
  /* Act on the event */
   parallaxfullwidth ()
 
});
});
jQuery(window).load(function() {
    /* Act on the event */
   jQuery(".mejs-time-rail") .each(function(index, el) {
    var a = jQuery(this).width();
    jQuery(this).css({"width":a-2});
  });
   parallaxfullwidth ();
});
jQuery(document).ready(function($) {
 jQuery('a.gotop').click(function() {
	jQuery("html, body").animate({ scrollTop: 0 }, "3000");
	  return false;
});
jQuery('a.btngotop').click(function() {
	jQuery("html, body").animate({ scrollTop: 0 }, "3000");
	  return false;
});
	jQuery('audio,video').mediaelementplayer();
 	jQuery('input#submit-comment').addClass('bgcolr');
  	jQuery("[data-loadbar]").each(function(index){
      var d =jQuery(this) .attr('data-loadbar');
      var e =jQuery(this) .attr('data-loadbar-text');
      var ani = jQuery(this).find('div');
      jQuery(ani).animate({width:d+"%"},2000).next().html(e);
    }); 
  jQuery("a.iconticker").click(function(event) {
    /* Act on the event */
    jQuery(this).toggleClass("active");
    jQuery(this).parents("article").find(".mapareawrapper").toggleClass("active-box");
 
    return false
  });
   jQuery("html") .click(function(event) {
   /* Act on the event */
   jQuery("#searchbox") .removeClass('active-box');
  jQuery(".btnsearch").removeClass('active');
 });
  jQuery('.searcharea').click(function(event){
    event.stopPropagation();
});
jQuery("#testmonial-code-slider .testimonial-shortcode:first").show();
jQuery("#testimonial-thumb-wrapp a").click(function(event) {
  jQuery("#testmonial-code-slider .testimonial-shortcode").hide();
  jQuery("#testimonial-thumb-wrapp a") .removeClass('active-slide');
  jQuery(this).addClass("active-slide");
  var a = jQuery(this).attr("href");
  jQuery(a).fadeIn();
  return false;

  /* Act on the event */
});
  
  selectnav('menus', {
    label: 'Menu',
    nested: true,
    indent: '-'
  }); 
/*    var $container = jQuery('#containergallery');
  $container.isotope({
    itemSelector: 'figure',
 layoutMode: 'masonryHorizontal',
    masonryHorizontal: {
        rowHeight: 8
    },
    resizesContainer: true


  });*/

/*  */
 
  jQuery(".btntoggle").click(function(event) {
    /* Act on the event */
    var a = jQuery(this).attr('href');
    jQuery(this).toggleClass('active');
    jQuery(a).toggleClass("active-box");
    return false;
  });
  jQuery(".close-playlist").click(function() {
    jQuery(".jp-playlist").removeClass("active-box");
    return false;
  });
  
  // Foucs Blur function for input field 
  jQuery(' textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="search"], input[type="tel"], input[type="color"]').focus(function() {
    if (!$(this).data("DefaultText")) $(this).data("DefaultText", $(this).val());
    if ($(this).val() != "" && $(this).val() == $(this).data("DefaultText")) $(this).val("");
  }).blur(function() {
    if ($(this).val() == "") $(this).val($(this).data("DefaultText"));
  });

  //Active Class for Accordion
  jQuery('#accordion').on('show', function(e) {
    $(e.target).prev('.accordion-heading').find('.accordion-toggle').addClass('active');
    $(e.target).parents(".accordion-group").addClass('active-parent');
  });

  $('#accordion').on('hide', function(e) {
    $(this).find('.accordion-toggle').not($(e.target)).removeClass('active');
    $(this).parents('.accordion-group').not($(e.target).parents(".accordion-group")).removeClass('active');
  });
  // Calling the Tabs
  $('.tabs a').click(function(e) {
    e.preventDefault();
    $(this).tab('show');
  });


   jQuery(".masnscroll").niceScroll({enablemousewheel:false, cursordragontouch:true, cursorborderradius :0, cursorwidth : "0px",cursorborder :"none", touchbehavior :true,cursorcolor :"#ef5d00", autohidemode: false}).resize();
});

function parallaxfullwidth () {
  jQuery(".parallax-fullwidth").each(function(){
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
//Social Sharing Buttons in post Detail
jQuery(document).ready(function($) {

	jQuery('#main .shareoption').hide();
    jQuery(".btnsharenow").click(function(){
      jQuery("#main .shareoption").fadeToggle('slow');
    });
    jQuery("html").click(function(event) {
        jQuery("#main .shareoption").fadeOut('slow');
    });
    jQuery("#main .btnsharenow, #main .shareoption").click(function(event){
      event.stopPropagation();
    });
	jQuery(".btnloadmore").click(function(){
		jQuery(".tracklist").show( "slow" );
		//jQuery(".tracklist").fadeToggle('slow');
     // jQuery(".tracklist").fadeToggle('slow');
	  jQuery(".btnloadmore").hide();
    });
});

 function event_map(contentdesc,lat, long, zoom, counter){
	 function initialize() {
			var myLatlng = new google.maps.LatLng(lat,long);
			var mapOptions = {
				zoom: zoom,
				scrollwheel: true,
				draggable: true,
				center: myLatlng,
				mapTypeId: google.maps.MapTypeId.ROADMAP ,
				disableDefaultUI: true,
			}
  			var map = new google.maps.Map(document.getElementById('map_canvas'+counter), mapOptions);
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
     google.maps.event.addDomListener(window, 'load', initialize);
  }
  
function sticky_menu(){
	// js
	jQuery("#stickyarea") .appendTo("header[class^='header-']");
	var bgc = jQuery(".main-menu") .css('backgroundColor');
	jQuery("#stickyarea") .css({"background":bgc});
	//jQuery(".logo a") .clone() .appendTo('#logobox-stick');
	jQuery("header[class^='header-'] .navigation") .clone() .appendTo('#menubox-stick');

	jQuery(window).scroll(function() {
		/* Act on the event */
			var h = jQuery("header[class^='header-']") .height();
			var ws = jQuery(window).scrollTop();
			if(ws > h){
				jQuery("#stickyarea").slideDown(200);
			}else {
				jQuery("#stickyarea").slideUp(200);
			}
	});
 	// js close	
}
function cs_skills_shortcode_script(){
		jQuery("[data-loadbar]").each(function(index){
			var d =jQuery(this) .attr('data-loadbar');
			var e =jQuery(this) .attr('data-loadbar-text');
			var ani = jQuery(this).find('div');
			jQuery(ani).animate({width:d+"%"},2000).next().html(e);
		}); 
}
// skill short code
// cs_skills_shortcode_script();
// masonry script
function  cs_mas_script(id){
	var $container = jQuery('#'+id);
  	$container.isotope({
    itemSelector: 'article',
	layoutMode: 'masonry',
    resizesContainer: true
  });
}
 
//Social Sharing Buttons in post Detail
jQuery(document).ready(function($) {
    jQuery(".btnsharenow").click(function(){
      jQuery(".share-now").fadeToggle('slow');
    });
    jQuery("html").click(function(event) {
        jQuery(".share-now").fadeOut('slow');
    });
    jQuery(".btnsharenow, .share-now").click(function(event){
      event.stopPropagation();
    });
});


function cs_mas_gallery_script(id){
	var $container = jQuery('#'+id);
  	$container.isotope({
   	itemSelector: 'figure',
 	layoutMode: 'masonryHorizontal',
   	masonryHorizontal: {
   		rowHeight: 8
   	},
   	resizesContainer: true
	});
}
 function album_detail_playlist(id, url){
    jQuery("#jquery_jplayer_"+id).jPlayer({
        ready: function () {
          jQuery(this).jPlayer("setMedia", {
          mp3: url
        });
        },
        play: function() { // To avoid multiple jPlayers playing together.
          jQuery(this).jPlayer("pauseOthers");
        },
        swfPath: "js",
        supplied: "mp3",
        cssSelectorAncestor: "#jp_container_"+id,
        wmode: "window",
        smoothPlayBar: true,
        keyEnabled: true,
        loop: true
    }); 
} 



// NiceScroll Javascript
var seq = 0;

  jQuery(document).ready(function($) {
	$("html").niceScroll({styler:"fb",cursorcolor:"#000", horizrailenabled:false, cursorwidth:"10px"});
	
	$("#mainlogo img").eq(1).hide();
	function goSeq() {
	  var nxt = (seq+1)%2;
	  $("#mainlogo img").eq(seq).fadeIn(2000);
	  $("#mainlogo img").eq(nxt).fadeOut(2000);
	  seq = nxt;
	  setTimeout(goSeq,2500);
	};
	goSeq();
	
	$(window).load(function(){
	  setTimeout(function(){
	    $("#gmbox div").animate({'top':60},1500,"easeOutElastic");
	  },1500);
	});
	
	
	
	$('[rel="outbound"]').click(function(e){	  
	  try {
		_gaq.push(['_trackEvent','outbound','click',this.href]);
	  }catch(err){}
	});
	
  });
// NiceScroll Javascript
function nomargin(c,ch) {

    var all_blocks = jQuery(c).find(ch);
    jQuery.each(all_blocks, function(i, obj){
      var a = jQuery(c) .offset().left;
      var b = jQuery(c +" "+ch+':last') .css("margin-left");
         var d = parseInt(b);
		     var posLeft = jQuery(obj).offset().left;
			
      if ( posLeft == (a+d) ) {
        jQuery(this).addClass("no-margin-left");     
      }       
        
    });
}