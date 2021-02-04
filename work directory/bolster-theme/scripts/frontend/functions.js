//Jquery Plugin for Calculating Columns
(function(e){jQuery.fn.pixCol=function(e){return this.each(function(){$this=jQuery(this).append('<span class="dummyspan"></span>');var e=$this.find("span.dummyspan").position().left;var t;if(jQuery.browser.webkit)t="-webkit-";else if(jQuery.browser.opera)t="";else if(jQuery.browser.mozilla)t="-moz-";else if(jQuery.browser.msie)t="";e+=parseInt($this.css(t+"column-width"),10);e-=parseInt($this.css(t+"column-gap"),10);jQuery(this).parent(".column-wrapp-box").css("width",e);if(jQuery.browser.msie&&parseInt(jQuery.browser.version,10)<=10){jQuery(this).parent(".column-wrapp-box").css("width",e+30)}jQuery(this).find("span.dummyspan").remove();return e})}})(jQuery)
//Easing Animations
jQuery.easing['easeOutCubic'] = function(x, t, b, c, d) {
  return c * ((t = t / d - 1) * t * t + 1) + b;
}
jQuery.easing['easeInOutBack'] = function(x, t, b, c, d, s) {
  if (s == undefined) s = 1.70158;
  if ((t /= d / 2) < 1) return c / 2 * (t * t * (((s *= (1.525)) + 1) * t - s)) + b;
  return c / 2 * ((t -= 2) * t * (((s *= (1.525)) + 1) * t + s) + 2) + b;
};

jQuery(document).ready(function() {
  jQuery('#myModal,#myshare').appendTo("body").modal('hide');
  heightMenu();
// InView Call Back 
  jQuery('.rich_editor_text p').each(function() {
    var $this = jQuery(this);
    if ($this.html().replace(/\s|&nbsp;/g, '').length == 0)
      $this.remove();
  });
heightMenu()
clearColumn ()

jQuery('audio,video').mediaelementplayer();
  // Menu Btn Toggle----
  jQuery("#header .menu-btn").click(function(event) {
    /* Act on the event */
    jQuery("#mainmenu").toggle()
  });
  // Navigation Hover
  jQuery(".navigation > ul > li").hover(function() {
    jQuery(this).find("ul").stop(true, true).delay(300).slideDown(600, 'easeInOutBack',function(){
      
    });
  
  }, function() {
    jQuery(this).find("ul").stop(true, true).delay(300).slideUp(600, 'easeInOutBack',function(){

    });
  });
  // Artist Gallery Hover
  jQuery(".artist-gallery article").hover(function() {
    jQuery(this).find("p").stop(true, true).slideDown(150)
  }, function() {
    jQuery(this).find("p").stop(true, true).slideUp(150)
  });
  

  jQuery('.img-icon-box').tooltip()
  jQuery("#flexslider-home .flexslider .slides li").each(function(index, el) {
    var a = jQuery(this).find("img").attr('src');
    // jQuery(this).find("img").hide();
    jQuery(this).find("figure").css("background", "url(" + a + ") no-repeat center top")

  });
  jQuery("#filters li").click(function(event) {
    /* Act on the event */
    jQuery("#filters li") .removeClass('bgcolr');
    jQuery(this).addClass("bgcolr");
  });
  
  jQuery(".home-gallery article") .hover(function() {
    jQuery(this) .find("p").stop(true,true) .slideDown(300)
  }, function() {
    jQuery(this) .find("p").stop(true,true) .slideUp(300)
  });
    jQuery(".home-gallery article") .hover(function() {
    jQuery(this) .find(".post-panel").stop(true,true) .slideDown(300)
  }, function() {
    jQuery(this) .find(".post-panel").stop(true,true) .slideUp(300)
  });

jQuery(".btnalbumpan,.sidebottom").click(function(event) {
  /* Act on the event */
  jQuery(this).toggleClass("active");
  jQuery(this).next() .fadeToggle();
  return false;
});

jQuery(".social-network .social_close").click(function() {
  jQuery("#myshare").modal('hide');
});

   jQuery("#map-gigs .btnexpand-d").click(function(event) {
   /* Act on the event */

   jQuery("#map-gigs") .animate({"width":"0px",opacity:0},300,function () {
     // body...
     google.map.event.trigger(map, "resize");
    resizescroll();
    
   });
   return false; 
   });
    jQuery(".location-info p a").click(function(event) {
   /* Act on the event */
   jQuery("#map-gigs") .animate({"width":"345px",opacity:1},300,function () {
     // body...
     google.maps.event.trigger(map, "resize");
    resizescroll();
  
   });
     return false; 
   });

    
 jQuery(".btndetail-g").toggle(function(event) {
   /* Act on the event */
   var a = jQuery(window).width();
   jQuery(this).find('em').attr('class','fa fa-compress');
  jQuery('html, body').animate({scrollLeft: jQuery(".gigs-area-map").offset().left}, 800);
   jQuery("#gigs-area-map") .animate({"width":a},300,function () {

     // body...concert-area 
    google.maps.event.trigger(map, "resize");
    resizescroll() 
   });
    
   return false;
 },function(){
  jQuery(this).find('em').attr('class','fa fa-arrows-alt');
   var a = jQuery(window).width();
    if (a <= 1000) {
         jQuery("#gigs-area-map").width(845);
          resizescroll();
      } else {
   jQuery("#gigs-area-map") .animate({"width":a - 800},300,function(){
    google.maps.event.trigger(map, "resize");
  resizescroll();
   });
    }

   return false;
 });

  jQuery(".btn-toggle").click(function() {
    var h = jQuery(this).attr('href');
    jQuery(this).toggleClass("active")
    jQuery(h).toggleClass('show');
    return false;
  });
  var fa = jQuery(".select-area .minict_wrapper ul li:first").text();
  jQuery(".inputholver").text(fa);
  jQuery(".select-area .minict_wrapper ul li") .click(function(){
    var fa = jQuery(this).text();
     jQuery(".inputholver").text(fa);
  })
 jQuery(".minict_wrapper .inputholver").live('click',function(){
        jQuery(this).next().slideToggle(0);
       });
jQuery('#mainmenu,#playerwrapp,#signin .span5,.searcharea').click(function(event){
    event.stopPropagation();
});
  jQuery("#menu ul").each(function() {
    jQuery(this).parent().append('<em class="fa fa-plus"></em>');
  });
  imageHeight()
  //Main Body

  // Foucs Blur function for input field 
  jQuery(' textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="search"], input[type="tel"], input[type="color"]').focus(function() {
    if (!jQuery(this).data("DefaultText")) jQuery(this).data("DefaultText", jQuery(this).val());
    if (jQuery(this).val() != "" && jQuery(this).val() == jQuery(this).data("DefaultText")) jQuery(this).val("");
  }).blur(function() {
    if (jQuery(this).val() == "") jQuery(this).val(jQuery(this).data("DefaultText"));
  });
  // 
jQuery('.mejs-horizontal-volume-slider').each(function(index, el) {
    var a = jQuery(this).prev();
    jQuery(this).appendTo(a).wrap('<div class="volume-control" />');
  });
  //jQuery("#player .mejs-playlist.mejs-layer").appendTo('#albumarea');
  jQuery("a.btnalbum").click(function(event) {
    /* Act on the event */
    jQuery("#player .mejs-playlist").slideToggle(300);
    return false;
  });
    jQuery(".mejs-time-rail") .append('<div class="title-song" />');
  jQuery("#player li:first").clone().appendTo('.title-song');


  //Active Class for Accordion
  jQuery('.accordion').on('show', function(e) {
    jQuery(e.target).prev('.accordion-heading').find('.accordion-toggle').addClass('active');
  });

  jQuery('.accordion').on('hide', function(e) {
    jQuery(this).find('.accordion-toggle').not(jQuery(e.target)).removeClass('active');
  });

  // Calling the Tabs
  jQuery('.tabs a').click(function(e) {
    e.preventDefault();
    jQuery(this).tab('show');
  });



});

// Flex slider for home page
function cs_home_flex_callback(){
  jQuery('#flexslider-home .flexslider').flexslider({
    after: function(slider) {
      curSlide = slider.slides[slider.currentSlide];
      jQuery(curSlide).find('figcaption').fadeIn(500);
    },
    before: function(slider) {
      curSlide = slider.slides[slider.currentSlide];
      jQuery("#flexslider-home .flexslider li").find('figcaption').fadeOut(500);
    }
  });

  jQuery('.carousel-area-release .flexslider').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: true,
    slideshow: false,
    itemWidth: 200,
    itemMargin: 10,
    controlsContainer: ".carousel-release-control"
  });
  jQuery('.flexslider').flexslider({
    animation: "fade",
    start: function(slider) {
      jQuery('body').removeClass('loading');
    }
  });
   // The slider being synced must be initialized first
     jQuery("a.flex-prev").append("<em class='fa fa-angle-left' />");
     jQuery("a.flex-next").append("<em class='fa fa-angle-right' />");
}
jQuery(window).load(function() {
  imageHeight();

});
function blog_grid_view () {
  var b = 270; //Actual Width of the Function
  var c = jQuery(".home-gallery").height();
  var d = c / b;
  var ma = Math.round(d);
  var f = c / ma;
  jQuery(".home-gallery article").css({
    "width": f - 0.5,
    "height": f - 0.5
  });
   jQuery(".home-gallery article.featured").css({
    "width": c - 0.5,
    "height": c - 0.5
  });
}
function artist_grid_view () {
  var b = 270; //Actual Width of the Function
  var c = jQuery(".artist-gallery").height();
  var d = c / b;
  var m = Math.round(d);
  var f = c / m;
  jQuery(".artist-gallery article").css({
    "width": f - 1.5,
    "height": f - 1.5
  });
   jQuery(".artist-gallery article.featured").css({
    "width": c - 1.5,
    "height": c - 1.5
  });
}
function imageHeight() {

  jQuery(".col-counter").pixCol();
  var mh = jQuery('#main').height();

  // jQuery('.wideimg').css({
  //   width: mh+200
  // });

  var he = jQuery(window).outerHeight();
  //jQuery('#main').css({"height":he-59}); 
  var widthc = jQuery(window).width();
  var ap = jQuery(".albumpanel").width();
  var cd = jQuery('.album-masonry-gallery').height();
  var aga = jQuery('.gallerymas').height();

  jQuery('.album-masonry-gallery article').css({
    width: (cd / 3) - 95,
    height: (cd / 3) - 30
  });
  if (cd <= 700) {
    jQuery('.album-masonry-gallery article').css({
      width: (cd / 2) - 95,
      height: (cd / 2) - 30
    });
  }
  if (cd <= 500) {
    jQuery('.album-masonry-gallery article').css({
      width: (cd / 1) - 120,
      height: (cd / 1)
    });
  }
  // for gallery

  resizescroll();
}


function resizescroll() {
  if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
 // some code..

jQuery(".left-content,.scroll-box,#playheader ul,#header #mainmenu").niceScroll({
  touchbehavior:true,
  cursorborder:"0px solid #333",
  horizrailenabled:false
});

} else {
    jQuery(".left-content,.scroll-box,#playheader ul,#header #mainmenu").niceScroll({
    cursorcolor: "#b1b1b1",
    // autohidemode: true,
    zindex: "999",
    styler:"fb"
    }).resize();
    jQuery("body").niceScroll({classname:"showscrollbar", cursoropacitymax: 1,styler:"fb", autohidemode: false,background: "#afafaf",cursorcolor: "#d7d7d7",cursorwidth:"7px",cursorborder: "5px solid #afafaf",}).resize();
    // jQuery("body,.left-content,#comments,.scroll-box,#playheader ul").getNiceScroll().resize();
    nice = jQuery("body").niceScroll({ styler:"fb", autohidemode: false}).resize();
  
    var _super = nice.getContentSize;
    nice.getContentSize = function() {      
      var page = _super.call(nice);
      page.h = nice.win.height();
      return page;
    }
  }
}
// Artists Likes Counter
function cs_like_counter(theme_url, post_id){
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
                }
            });
            //return false;
}
function cs_filters_callback(filter_page_class){
  var $container = jQuery('.'+filter_page_class);
  jQuery('#filters li').click(function(){
      var selector = jQuery(this) .find("a").data('filter');
      $container.isotope({ filter: selector });
      resizescroll();
      return false;
  });
}
function cs_masonary_callback(mas_page_class){
  var $container = jQuery('.'+mas_page_class);
  $container.imagesLoaded( function(){
    var $items = jQuery('article');
    $container.isotope({
      itemSelector: 'article',
      layoutMode: 'fitColumns',
      masonryHorizontal: {
      rowHeight: 1
    },
    resizesContainer: true
    });
    }); 

}
function filteable_onchange(){
  jQuery('.heading-area select').change(function(){
       var selector = jQuery(this).val();
      jQuery('#event_filteabale_articles').isotope({ filter: selector });
      resizescroll();
      return false;
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
  keyEnabled: true
  }); 
}
// Gallery load more ajax
function gallery_load_more_js(media_per_page, layout, total_count, gallery_name, desc, home_url, get_template_directory_uri,cs_thumb_space){
      var currentOffset = media_per_page;
       var no_post_perpage = media_per_page;
       var page_id_all = 2;
       var cs_gallery_view = layout;
       var total = total_count;
       var cs_artist_per_page = media_per_page;
       var categoryId = gallery_name;
       var cs_thumb_space = cs_thumb_space;
       ajaxFinished = 1;
       jQuery(window).scroll(function() {
        var d = jQuery("."+layout).offset().left;
        if (jQuery(window).scrollLeft()   >  d-400) {
            if (ajaxFinished == 1) {
               ajaxFinished = 0;
             if (no_post_perpage < total) {
                 var npage = no_post_perpage + media_per_page;
                 jQuery.ajax({
                  type: "post",
                  cache: false,
                  dataType: "html",
                  url: home_url+'/wp-admin/admin-ajax.php',
                  data: {action: "cs_load_more_gallery", offset: currentOffset,
                   cs_gallery_num_post: media_per_page,
                   page_id_all: page_id_all,
                   total_posts: total,
                   show_description: desc,
                   no_post_perpage_post: npage,
                   gallery_view: cs_gallery_view,
                   cs_thumb_space: cs_thumb_space,
                   catid: categoryId},
                  success: function(response) {
                    var $newItems = jQuery(response);
                   jQuery('.'+layout+' #container').append($newItems);
                   jQuery(".gallerymas").isotope('insert', $newItems);
                    jQuery("article figure") .css({"opacity":"1"});
                   jQuery("body").trigger('resize');
                   currentOffset = currentOffset + 10;
                   no_post_perpage = npage;
                   if (no_post_perpage >= total) {
                    jQuery('.load').hide();
                   }
                   page_id_all++;
                   Gallery_pretty_photo();
                   ajaxFinished = 1;
                   jQuery('.loading_img > img').remove();
                  }
                 });
           }
        }
      }
      });
  
}
// Load more Event js
function event_load_more_js(cs_event_per_page, cs_event_view, cs_event_type, total_count, filter_category, home_url, get_template_directory_uri){
  
   var currentOffset = cs_event_per_page;
   var no_post_perpage = cs_event_per_page;
   var page_id_all = 2;
   var event_type = cs_event_type;
   var cs_event_view = cs_event_view;
   var total = total_count;
   var cs_event_per_page = cs_event_per_page;
   var categoryId = filter_category;
   ajaxFinished = 1;
    jQuery(".concert-area").scroll(function() {
      //if (jQuery(window).scrollLeft() + jQuery(window).width() == jQuery(document).width()) {
      if (jQuery(".concert-area").scrollTop() + jQuery(".concert-area").height() == jQuery("#main").height()) {
      
        if (ajaxFinished == 1) {
           ajaxFinished = 0;
         if (no_post_perpage < total) {
            var npage = no_post_perpage + cs_event_per_page;
             jQuery.ajax({
              type: "post",
              cache: false,
              dataType: "html",
              url: home_url+'/wp-admin/admin-ajax.php',
              data: {action: "cs_load_more_posts", offset: currentOffset,
               cs_blog_num_post: cs_event_per_page,
               page_id_all: page_id_all,
               total_posts: total,
               event_type: event_type,
               no_post_perpage_post: npage,
               blog_view: cs_event_view,
               catid: categoryId},
              success: function(response) {
                var $newItems = jQuery(response);
                jQuery('.event_more_articles').append($newItems).isotope('insert', $newItems);
               currentOffset = currentOffset + 10;
               no_post_perpage = npage;
               if (no_post_perpage >= total) {
                jQuery('.load').hide();
               }
               page_id_all++;
               //jQuery("#container").isotope('destroy');
               ajaxFinished = 1;
                jQuery('body').trigger('resize');
               jQuery('.loading_img > img').remove();
               resizescroll();
              }
             });
       }
    }
      }
    
  });
  
}

// Load more artist js
function artist_load_more_js(cs_artist_per_page, cs_artist_view, total_count, cs_artist_category, home_url, get_template_directory_uri){
  var currentOffset = cs_artist_per_page;
   var no_post_perpage = cs_artist_per_page;
   var page_id_all = 2;
   var cs_artist_view = cs_artist_view;
   var total = total_count;
   var cs_artist_per_page = cs_artist_per_page;
   var categoryId = cs_artist_category;
   ajaxFinished = 1;
    jQuery(window).scroll(function() {
      var d = jQuery('.'+cs_artist_view).offset().left;
      if (jQuery(window).scrollLeft()   >  d-400) {
        if (ajaxFinished == 1) {
           ajaxFinished = 0;
         if (no_post_perpage < total) {
             var npage = no_post_perpage + cs_artist_per_page;
             jQuery.ajax({
              type: "post",
              cache: false,
              dataType: "html",
              url: home_url+'/wp-admin/admin-ajax.php',
              data: {action: "cs_load_more_artists", offset: currentOffset,
               cs_blog_num_post: cs_artist_per_page,
               page_id_all: page_id_all,
               total_posts: total,
               no_post_perpage_post: npage,
               blog_view: cs_artist_view,
               catid: categoryId},
              success: function(response) {
                      var $newItems = jQuery(response);
               jQuery('.'+cs_artist_view).append($newItems).isotope('insert', $newItems);
               currentOffset = currentOffset + 10;
               no_post_perpage = npage;
               if (no_post_perpage >= total) {
                jQuery('.load').hide();
               }
               page_id_all++;
               //jQuery('.'+cs_artist_view).isotope('destroy');
                 ajaxFinished = 1;
                  jQuery("article figure") .css({"opacity":"1"});
               jQuery('body').trigger('resize');
               jQuery('.loading_img > img').remove();
              }
             });
       }
    }
    }
  });
}

// Load more Blog js 
function blog_load_more_js(cs_blog_num_post, cs_blog_view, cs_blog_excerpt, total_count, cs_blog_cat, home_url, get_template_directory_uri,cs_blog_description){
   var currentOffset = cs_blog_num_post;
   var no_post_perpage = cs_blog_num_post;
   var page_id_all = 2;
   var total = total_count;
   var cs_artist_per_page = cs_blog_num_post;
   var categoryId = cs_blog_cat;
   ajaxFinished = 1;
  var d = jQuery('.'+cs_blog_view).offset().left;
    jQuery(window).scroll(function() {
      if (jQuery(window).scrollLeft()   >  d-400) {
        if (ajaxFinished == 1) {
           ajaxFinished = 0;
         if (no_post_perpage < total) {
             var npage = no_post_perpage + cs_blog_num_post;
             jQuery.ajax({
              type: "post",
              cache: false,
              dataType: "html",
              url: home_url+'/wp-admin/admin-ajax.php',
              data: {action: "cs_load_more_blog", offset: currentOffset,
               cs_blog_num_post: cs_blog_num_post,
               cs_blog_view: cs_blog_view,
               cs_blog_excerpt: cs_blog_excerpt,
               page_id_all: page_id_all,
               total_posts: total,
               no_post_perpage_post: npage,
               catid: categoryId,
         cs_blog_description:cs_blog_description 
         },
              success: function(response) {
                 var $newItems = jQuery(response);
              jQuery('.'+cs_blog_view).append($newItems).isotope('insert', $newItems);
               currentOffset = currentOffset + 10;
               no_post_perpage = npage;
               if (no_post_perpage >= total) {
                jQuery('.load').hide();
               }
               page_id_all++;
               ajaxFinished = 1;

            jQuery("article figure") .css({"opacity":"1"});
            jQuery('body').trigger('resize');
               jQuery('.loading_img > img').remove();
              }
             });

       }
    }
  }
  });
}
// Album load more js function
function album_load_more_js(cs_album_per_page, cs_album_buynow, total_count, cs_album_cat_db, home_url, get_template_directory_uri){
  var currentOffset = cs_album_per_page;
   var no_post_perpage = cs_album_per_page;
   var page_id_all = 2;
   var total = total_count;
   var cs_artist_per_page = cs_album_per_page;
   var categoryId = cs_album_cat_db;
   ajaxFinished = 1;
    jQuery(window).scroll(function() {
      var d = jQuery(".album-gallery").offset().left;
      if (jQuery(window).scrollLeft()   >  d-400) {
        if (ajaxFinished == 1) {
           ajaxFinished = 0;
         if (no_post_perpage < total) {
             var npage = no_post_perpage + cs_album_per_page;
             jQuery.ajax({
              type: "post",
              cache: false,
              dataType: "html",
              url: home_url+'/wp-admin/admin-ajax.php',
              data: {action: "cs_load_more_album", offset: currentOffset,
               cs_blog_num_post: cs_album_per_page,
               cs_album_buynow: cs_album_buynow,
               page_id_all: page_id_all,
               total_posts: total,
               no_post_perpage_post: npage,
               catid: categoryId},
              success: function(response) {
                var $newItems = jQuery(response);
              jQuery('.album-gallery').append($newItems).isotope('insert', $newItems);
              imageHeight();
              currentOffset = currentOffset + cs_album_per_page;
              no_post_perpage = npage;
              if (no_post_perpage >= total) {
                jQuery('.load').hide();
              }
               page_id_all++;
               //jQuery(".album-gallery").isotope('destroy');
                ajaxFinished = 1;
               jQuery('body').trigger('resize');
               jQuery('.loading_img > img').remove();
               return false;
              }
             });
       }
    }
    }
  });
}

// Search load more js function
function search_load_more_js(cs_no_post_per_page, total_count, cs_search_db, home_url, get_template_directory_uri){
  var currentOffset = cs_no_post_per_page;
   var no_post_perpage = cs_no_post_per_page;
   var page_id_all = 2;
   var total = total_count;
   var cs_artist_per_page = cs_no_post_per_page;
   var categoryId = cs_search_db;
   ajaxFinished = 1;
    jQuery(window).scroll(function() {
      var d = jQuery(".cs-blog .blog-gallery").offset().left;
      if (jQuery(window).scrollLeft()   >  d-400) {
        if (ajaxFinished == 1) {
           ajaxFinished = 0;
         if (no_post_perpage < total) {
             var npage = parseInt(no_post_perpage) + parseInt(cs_no_post_per_page);
             jQuery.ajax({
              type: "post",
              cache: false,
              dataType: "html",
              url: home_url+'/wp-admin/admin-ajax.php',
              data: {action: "cs_load_more_search", offset: currentOffset,
               cs_blog_num_post: cs_no_post_per_page,
               page_id_all: page_id_all,
               total_posts: total,
               no_post_perpage_post: npage,
               catid: categoryId},
              success: function(response) {
                var $newItems = jQuery(response);
              jQuery('.cs-blog .blog-gallery').append($newItems).isotope('insert', $newItems);
                imageHeight();
               currentOffset = currentOffset + 10;
               no_post_perpage = npage;
               if (no_post_perpage >= total) {
                jQuery('.load').hide();
               }
               page_id_all++;
              // jQuery(".blog-gallery").isotope('destroy');
               resizescroll();
               ajaxFinished = 1;
               jQuery('.loading_img > img').remove();
              }
             });
       }
    }
  }
  });
}
// index posts load more js function
function cs_load_more_index_posts(cs_posts_per_page, total_count, cs_search_db, home_url, get_template_directory_uri){
  var currentOffset = cs_posts_per_page;
   var no_post_perpage = cs_posts_per_page;
   var page_id_all = 2;
   var total = total_count;
    var categoryId = cs_search_db;
   ajaxFinished = 1;
    jQuery(window).scroll(function() {
      var d = jQuery(".cs-blog .blog-gallery").offset().left;
    if (jQuery(window).scrollLeft()   >  d-400) {
        if (ajaxFinished == 1) {
           ajaxFinished = 0;
         if (no_post_perpage < total) {
             var npage = parseInt(cs_posts_per_page) + parseInt(cs_posts_per_page);
             jQuery.ajax({
              type: "post",
              cache: false,
              dataType: "html",
              url: home_url+'/wp-admin/admin-ajax.php',
              data: {action: "cs_load_more_index_posts", offset: currentOffset,
               cs_blog_num_post: cs_posts_per_page,
               page_id_all: page_id_all,
               total_posts: total,
               no_post_perpage_post: npage,
               catid: categoryId},
              success: function(response) {
                var $newItems = jQuery(response);
              jQuery('.cs-blog .blog-gallery').append($newItems).isotope('insert', $newItems);
                imageHeight();
               currentOffset = currentOffset + 10;
               no_post_perpage = npage;
               if (no_post_perpage >= total) {
                jQuery('.load').hide();
               }
               page_id_all++;
              // jQuery(".blog-gallery").isotope('destroy');
               resizescroll();
               ajaxFinished = 1;
               jQuery('.loading_img > img').remove();
              }
             });
       }
    }
  }
  });
}

// Archive load more js function
function archive_load_more_js(cs_no_post_per_page, total_count, author_archive, author, calendar_archive, m, m, hour, day, minute, second, taxonomy, taxonomy_category, events_archive, album_archive, artists_archive, blog_cat_archive, cat, blog_tag_archive, tag, home_url, get_template_directory_uri){
  var currentOffset = cs_no_post_per_page;
   var no_post_perpage = cs_no_post_per_page;
   var page_id_all = 2;
   var total = total_count;
   var cs_artist_per_page = cs_no_post_per_page;
   ajaxFinished = 1;
    jQuery(window).scroll(function() {
      var d = jQuery(".cs-blog .blog-gallery").offset().left;
      if (jQuery(window).scrollLeft()   >  d-400) {
        if (ajaxFinished == 1) {
           ajaxFinished = 0;
         if (no_post_perpage < total) {
             var npage = parseInt(no_post_perpage) + parseInt(cs_no_post_per_page);
             jQuery.ajax({
              type: "post",
              cache: false,
              dataType: "html",
              url: home_url+'/wp-admin/admin-ajax.php',
              data: {action: "cs_load_more_archive", offset: currentOffset,
                author_archive: author_archive,author: author,calendar_archive: calendar_archive,m: m,day: day,minute: minute,second: second,taxonomy: taxonomy,taxonomy_category: taxonomy_category,events_archive: events_archive,album_archive: album_archive,artists_archive: artists_archive,blog_cat_archive: blog_cat_archive,cat: cat,blog_tag_archive: blog_tag_archive,tag: tag,
               cs_blog_num_post: cs_no_post_per_page,
               page_id_all: page_id_all,
               total_posts: total,
               no_post_perpage_post: npage},
              success: function(response) {
                var $newItems = jQuery(response);
               jQuery('.cs-blog .blog-gallery').append($newItems).isotope('insert', $newItems);
                imageHeight();
               currentOffset = currentOffset + 10;
               no_post_perpage = npage;
               if (no_post_perpage >= total) {
                jQuery('.load').hide();
               }
               page_id_all++;
               //jQuery(".blog-gallery").isotope('destroy');
                ajaxFinished = 1;
                jQuery('body').trigger('resize');
               jQuery('.loading_img > img').remove();
              }
             });
       }
    }
  }
  });
}

// PrettyPhoto Callback 
//
function Gallery_pretty_photo() {
  jQuery("a[rel^='prettyPhoto']").prettyPhoto(); // initiate prettyphoto
};

// Map Events Callback
//

function cs_event_map(add, lat, long, zoom, counter) {
  var map;
  var myLatLng = new google.maps.LatLng(lat, long)
  //Initialize MAP
  var myOptions = {
    zoom: zoom,
    center: myLatLng,
    disableDefaultUI: true,
    scrollwheel: false,
    zoomControl: true,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  map = new google.maps.Map(document.getElementById('map_canvas' + counter), myOptions);
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
    content: "" + add,
    position: myLatLng
  });
  google.maps.event.addListener(marker, 'click', function() {
    infowindow.open(map, marker);
  });
}




// Map Width Gigs Area
//
function mapwidtharea () {
  jQuery(".cs-full-map").each(function(index, el) {
    var a = jQuery(window) .width();
    var b = jQuery(".featured-img-wrapper") .width();
    var c = jQuery(".concert-area") .width();
    var d = a - (b+c);
    if ( d > 300) {
      jQuery("#gigs-area-map") .width(d-60).css({"margin":"0"});
  }

  });
}
jQuery(window).load(function() {
  mapwidtharea()
  jQuery("#followingBallsG").fadeOut(300, function() {
    jQuery("#main").animate({
      "margin-left": "0",
      "opacity": 1
    }, 900, function() {
      resizescroll();
        showbodyscroll()
    });
  });
});

jQuery(document).ready(function($) {

  jQuery(window).load(function() {
    // Slider Function
    jQuery("#slider ul.slides li").each(function(index, el) {
      jQuery("body").getNiceScroll().hide();
      var a = jQuery(this).find("img").attr("src");
      jQuery(this).css({
        "background": "url(" + a + ") no-repeat center center fixed"
      });
    });
  });
});



/* Resize image */
function resizeimg() {
  var a = jQuery("#container").width();
  if (a <= 2000) {
    jQuery(".events-photo .box").width(a / 16)
  }
  if (a <= 1800) {
    jQuery(".events-photo .box").width(a / 14)
  }
  if (a <= 1600) {
    jQuery(".events-photo .box").width(a / 9)
  }
  if (a <= 1500) {
    jQuery(".events-photo .box").width(a / 7)
  }
  if (a <= 1000) {
    jQuery(".events-photo .box").width(a / 6)
  }
  if (a <= 800) {
    jQuery(".events-photo .box").width(a / 5)
  }
  if (a <= 700) {
    jQuery(".events-photo .box").width(a / 4)
  }
  if (a <= 400) {
    jQuery(".events-photo .box").width(a / 3)
  }
  if (a <= 300) {
    jQuery(".events-photo .box").width(a / 1)
  }
}




// Gallery Square View Resize function 
//
function resizegallery() {
  var b = 240; //Actual Width of the Function
  var mb = jQuery(".gallery_squre_view article").css("margin-bottom").replace("px", "");
  jQuery(".gallery_squre_view").css({
    "padding-top": mb + "px",
    "padding-left": mb + "px"
  })
  parseInt(mb, 10);
  var c = jQuery(".gallery_squre_view article").parents(".gallery_squre_view .events-photo").height();
  var d = c / b;
  var m = Math.round(d);
  var f = c / m;
  jQuery(".gallery_squre_view article").css({
    "width": (f - .5) - mb,
    "height": (f - .5) - mb
  });
}
// Alternative GAllery
function resize_inner_gallery() {
  var b = 200; //Actual Width of the Function
  var mb = jQuery(".gallery_squre_view article").css("margin-bottom").replace("px", "");
  jQuery(".gallery_squre_view").css({
    "padding-top": mb + "px",
    "padding-left": mb + "px"
  })
  parseInt(mb, 10);
  var c = jQuery(".gallery_squre_view article").parents(".gallery_squre_view .events-photo").height();
  var d = c / b;
  var m = Math.round(d);
  var f = c / m;
  jQuery(".gallery_squre_view article").css({
    "width": (f - .5) - mb,
    "height": (f - .5) - mb
  });
}
// Gallery Grid View Resize function 
//
function resizegallerygrid() {

    var b  = 191;
    var w = 340;
    var mb  = jQuery(".gallery_grid_view article") .css("margin-bottom").replace("px", "");
    jQuery(".gallery_grid_view").css({"padding-top":mb+"px","padding-left":mb+"px"})
    parseInt(mb,10)
    var c  = jQuery(".gallery_grid_view article").parents(".gallery_grid_view .events-photo") .height();
    var d = c/b;
    var m = Math.round(d);
    var f = c/m;
  jQuery(".gallery_grid_view article").css({"width":((f*(w/b))- mb)-.5,"height":(f - .5)-mb});
}

jQuery(document).ready(function($) {
  // Slider Fullwidth Image

  // Animation Effect For Loading
  //
  jQuery("#menu a").click(function(event) {
    var a = jQuery(this).attr("href")
    if (a == "" || a == "#") {} else {
      setTimeout(function() {
        window.location = a;
      }, 800);
      jQuery("#main").animate({
        "margin-left": "-80%",
        "opacity": 0
      }, 900, function() {
        jQuery("#followingBallsG").fadeIn(300);
        resizescroll()
      });

      return false;
    }
  });

});


// If scroll is present
//
function showbodyscroll() {
  var a = jQuery(".showscrollbar").is(":visible");
  if (a) {
    jQuery("body").addClass("scrollbody");
  } else {
    jQuery("body").removeClass("scrollbody");

  }
}

// Parallax Callback 
//
function cs_parallax() {
  jQuery('.parallaxbg').parallax("50%", 0.1);
  jQuery(".parallaxbg") .each(function(index, el) {
    jQuery(this).find('img').hide();
      var a =  jQuery(this).find('img.wp-post-image').attr('src');
      jQuery(this).css("background","url("+a+") no-repeat -12px 50% ")
      var a = jQuery(this) .height() ;
    jQuery(this) .width(a);
    jQuery(".cs-featured-image").css({"margin-left":a-30}) 
  });
}
// Idangerous sWiper CallBack 
//
function cs_swipe_gallery() {
    jQuery("#gallertwowrapp.fullwidth-slider #slider .swiper-slide").each(function(index, el) {
    var a = jQuery(this).find("img").attr("src");
    jQuery(this).css({
      "background": "url(" + a + ") no-repeat center center"
    });
  });
  var isDragging = false;
  jQuery(".swiper-slide .gallery_stack_element .fa-play-circle-o").live("mousedown", function() {
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
        swiperMovies.resizeFix()
        jQuery(this).parents(".gallery_stack_element ").addClass("active");
        jQuery(this).hide();
        jQuery(this).next().show();
        jQuery(this).parents(".gallery_stack_element ").prev().css({
          "opacity": "1",
          "visibility": "visible"
        });
        jQuery(".swiper-thumb-container,.swipe-right,.swipe-left,.caption-area-slider").css({
          "opacity": "0",
          "visibility": "hidden"
        });
        return false;

      }
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
      swiperMovies.resizeFix()
      jQuery(this).parents(".gallery_stack_element ").removeClass("active");
      var vidwrap = jQuery(this).parents(".gallery_stack_element ").prev()
      vidwrap.html(vidwrap.html());
      jQuery(this).hide();
      jQuery(this).prev().show();
      jQuery(this).parents(".gallery_stack_element ").prev().css({
        "opacity": "0",
        "visibility": "hidden"
      });
      jQuery(".swiper-thumb-container,.swipe-right,.swipe-left,.caption-area-slider").css({
        "opacity": "1",
        "visibility": "visible"
      });
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
  var swiperMovies = jQuery('.mc-posters').swiper({
    mode: "horizontal",
    onlyExternal: false,
    loop: true,
    grabCursor: true,
    useCSS3Transforms: true,
    mousewheelControl: true,
    speed: 1000,

    onSlideChangeStart: function(swiper) {
      var a = swiperMovies.activeLoopIndex;
      jQuery("#current-slide-number").text(a + 1)
      var index = swiperMovies.activeLoopIndex
      // swiperMControl.swipeTo (index);
      jQuery('.mc-control .bgcolr').removeClass('bgcolr')
      jQuery(".mc-control .swiper-slide:eq(" + index + ")").addClass('bgcolr');
      var a = jQuery("#carousearea .swiper-slide.bgcolr").hasClass("swiper-slide-visible")
      var b = jQuery("#carousearea .swiper-slide.bgcolr").index();
      if (!a) {
        swiperMControl.swipeTo(b);
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
    swiperMovies.swipeTo(index)


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
    swiperMovies.swipeNext()

  });
  jQuery(".swipe-left").live('click', function(e) {
    swiperMovies.swipePrev()

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
  jQuery(window).load(function() {
    /* Act on the event */
   jQuery("body").getNiceScroll().hide();
    setTimeout(function(){swiperMovies.resizeFix()},100)
  });

}
jQuery(window).resize(function() {
  mapwidtharea()
  showbodyscroll()
  imageHeight()
  heightMenu();
  clearColumn ();
 
});


function heightMenu() {
  var h = jQuery("#header") .height();
  var b = jQuery("#header .logo") .height();
  var c = h - 340
  jQuery("#header nav.navigation") .css({"min-height":c})
 

}

function clearColumn () {
  jQuery(".clearcolumn") .each(function(index, el) {
    var a = jQuery(this) .parent(".detail_text_wrapp") .outerHeight();
    var b = jQuery(this) .offset().top;
    jQuery(this) .css("margin-bottom",a-(b+21));
  });
}

function LoadedItem (a) {
  jQuery("."+a).each(function(index, val) {
     /* iterate through array or object */
  
     jQuery(this).find("img").load(function() {
     
       jQuery(this).parents("figure").animate({"opacity":"1"},index*10)
     });
  });
}

function resize_blog_template () {
  var w = jQuery(".cs-blog-list-view") .height()
  var b = 225;
  var d = w/b;
    var m = Math.round(d);
    var f = w/m;
  jQuery(".cs-blog-list-view article").css({"width":(f*3)- 15.5,"height":f - 15.5});
  jQuery(".cs-blog-list-view article figure").css({"height":f - 15.5});
  
}