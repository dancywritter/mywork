<script type="text/javascript">
        jQuery(document) .ready(function($){
   			jQuery("#togglebutton").click(function(){
				jQuery("#sidebarmain").trigger('click')
				jQuery(this).toggleClass('btnclose');
				jQuery("#sidebarmain") .toggleClass('sidebarmain');
				return false; 
		   });
           $("#pattstyles li label") .click(function(){
				$("#backgroundimages li label") .removeClass("active");	
				$("#patter_or_bg") .attr("value","0");
      			var ah = $(this) .find('input[type="radio"]') .val();
      			$('body') .css({"background":"url(<?php echo get_template_directory_uri()?>/images/pattern/pattern"+ah+".png)"});
      });
      $("#backgroundimages li label") .click(function(){
		  $("#patter_or_bg") .attr("value","1");
		$("#pattstyles li label") .removeClass("active");	
      var ah = $(this) .find('input[type="radio"]') .val();
      $('body') .css({"background":"url(<?php echo get_template_directory_uri()?>/images/background/bg"+ah+".png) no-repeat center center / cover fixed"});
     });
   $("#backgroundimages li label,#pattstyles li label") .click(function(){
    var classname=$(".layoutoption li:first-child label") .hasClass("active"); 
    if(classname) {
    alert("Please select Boxed View")
    return false; 
    }else {
      $(this) .parents(".selectradio") .find("label") .removeClass("active");
      $(this) .addClass("active"); 

     }
    });
                $(".layoutoption li label") .click(function(){
					
    var th = $(this).find('input') .val();
    $("#wrappermain-pix") .attr('class','');
    $('#wrappermain-pix') .addClass(th);
                $(this) .parents(".selectradio") .find("label") .removeClass("active");
                $(this) .addClass("active");
     		jQuery(".top_strip").trigger('resize');
				para();
	 			parabg ();
                });
    
    $(".accordion-sidepanel .innertext") .hide();
    $(".accordion-sidepanel header") .click(function(){
     if ($(this) .next() .is(":visible")){
       $(".accordion-sidepanel .innertext") .slideUp(300);
       $(".accordion-sidepanel header") .removeClass("active");
       return false;
      }
    $(".accordion-sidepanel .innertext") .slideUp(300);
    $(".accordion-sidepanel header") .removeClass("active");
    $(this) .addClass("active");
    $(this).next() .slideDown(300);
     
    
    });
    
        });

	jQuery(document).ready(function($){
		$(".colorpicker-main").click(function(){
		$(this).find('.wp-color-result').trigger('click'); 
		jQuery('#color_switcher input:checkbox').attr('checked', 'checked');
    });
	var cf = ".colr, .colrhvr:hover, #filters li a:hover, #filters li a.selected, .portfolio article:hover .text h6 a, .widget_categories ul li:hover, .widget_categories ul li:hover a, .widget-related-blog ul li:hover a, .pagination ul li a.active, .widget_categories ul li:hover a:before, .widget_archive ul li:hover, .widget_recent_entries ul li:hover,.widget_recent_entries ul li:hover,.widget_recent_comments ul li:hover,.widget_links ul li:hover, .widget_meta ul li:hover, .widget_archive ul li:hover a,.widget_recent_entries ul li:hover a,.widget_recent_entries ul li:hover a,.widget_recent_comments ul li:hover a, .widget_links ul li:hover a, .widget_meta ul li:hover a, .widget_pages ul li a:hover, .widget_nav_menu ul li a:hover, .widget ul li:hover a:before ,.woocommerce-tabs ul.tabs li.active a, #comments a, #respond a,.woocommerce .myaccount_user a, .woocommerce .addresses a, .blog-text ul.post-options li a:hover";
	var bc = ".bgcolr, .bgcolrhvr:hover, .flex-control-paging li a.flex-active,  .gallery article:hover .hovicon.effect-1.sub-b, .mas-cont-sec .gallery-box figure:hover figcaption:before, .flex-direction-nav a:hover, .load-more a:hover, .cart-secc span.amount, .woocommerce-message:before, .woocommerce-error:before, .woocommerce-info:before,.woocommerce .button,.cart-sec span.amount,.cart-sec span.qnt, .portfolio article figcaption .mas-cont-sec .no-image figcaption:before, .mas-cont-sec .no-image figcaption:before";
	var boc = ".bdrcolr, #filters li a:hover, #filters li a.selected, .pagination ul li a.active:before, .pagination ul li a:hover:before,.woocommerce-pagination ul li .current, .woocommerce-message, .woocommerce-error, .woocommerce-info, .woocommerce-pagination ul li .current:before";
	var boc2 =".bdrcolr, #filters li a:hover, #filters li a.selected, .pagination ul li a.active:before, .pagination ul li a:hover:before,.woocommerce-pagination ul li .current, .woocommerce-message, .woocommerce-error, .woocommerce-info, .woocommerce-pagination ul li .current:before";
	var styleheading = "#header, nav.navigation.mp-menu ul.sub-menu";
	$('#themecolor .bg_color').wpColorPicker({
		change:function(event,ui){
			var a = ui.color.toString();
			$("#stylecss") .remove();
			$("#stylecsstwo") .remove();
			$("<style type='text/css' id='stylecss'>"+cf+"{color:"+a+" !important}"+bc+", "+styleheading+"{background-color:"+a+" !important}"+boc+"{border-color:"+a+" !important}"+boc2+"{border-color:transparent "+a+" !important}</style>").insertAfter("body");
			} 
    	}); 
 	$('#headingcolor .bg_color').wpColorPicker({
		change:function(event,ui){
			var a = ui.color.toString();
			$("#stylecsstwo") .remove();
			$("<style type='text/css' id='stylecsstwo'>"+styleheading+"{background-color:"+a+" !important}</style>").insertAfter("body");
			} 
    	});
		
		jQuery("#colorpickerwrapp span.col-box") .live("click",function(event) {
			//alert('test');
			var a = jQuery(this).data('color');
			//alert(a);
			jQuery("#bgcolor").val(a);
			jQuery('.wp-color-result').css('background-color', a);
			$("#stylecss") .remove();
			$("#stylecsstwo") .remove();
			$("<style type='text/css' id='stylecsstwo'>"+styleheading+"{background-color:"+a+" !important}"+cf+"{color:"+a+" !important}"+bc+"{background-color:"+a+" !important}"+boc+"{border-color:"+a+" !important}</style>").insertAfter("body");
			
			
			
			jQuery("#colorpickerwrapp span.col-box") .removeClass('active');
			jQuery(this).addClass("active");
		});
		
		//
		jQuery(".social-switch") .live("click",function(event) {
			if($(this).is(':checked')){
				jQuery(".social-network") .removeClass("cs-deactive-switch");
			}else{
				jQuery(".social-network") .addClass("cs-deactive-switch");
			}
		});
		
		//
		jQuery(".cart-switch") .live("click",function(event) {
			if($(this).is(':checked')){
				jQuery("#header-bottom .cart-sec") .removeClass("cs-deactive-switch");
			}else{
				jQuery("#header-bottom .cart-sec") .addClass("cs-deactive-switch");
			}
		});
		
		//
		jQuery(".switch-heder-sticky") .live("click",function(event) {
			if($(this).is(':checked')){
				jQuery("#wrappermain-pix") .removeClass("header-sticky-off");
				jQuery("#wrappermain-pix") .addClass("header-sticky-on");
				jQuery("#wrappermain-pix") .addClass("wrapper-menu-loaded");
				 //jQuery(".mp-level:first").addClass("mp-level-open");
			}else{
				jQuery("#wrappermain-pix") .addClass("header-sticky-off");
				jQuery("#wrappermain-pix") .removeClass("header-sticky-on");
				jQuery("#wrappermain-pix") .removeClass("wrapper-menu-loaded");
			}
		});
		
		//
		jQuery(".switch-sub-header") .live("click",function(event) {
			if($(this).is(':checked')){
				jQuery("#wrappermain-pix") .removeClass("subheader-off");
				jQuery("#wrappermain-pix") .addClass("subheader-on");
			}else{
				jQuery("#wrappermain-pix") .addClass("subheader-off");
				jQuery("#wrappermain-pix") .removeClass("subheader-on");
			}
		});
		
		//
		jQuery(".switch-small-logo") .live("click",function(event) {
			if($(this).is(':checked')){
				jQuery("#logo .logosmall") .removeClass("cs-deactive-switch");
			}else{
				jQuery("#logo .logosmall") .addClass("cs-deactive-switch");
			}
		});
		 
	});
	function reset_color(){
		jQuery("#reset_color_txt").attr('value',"1")
		jQuery("#bgcolor").attr('value',"#282828")
		jQuery("#color_switcher").submit();
	}
        </script>