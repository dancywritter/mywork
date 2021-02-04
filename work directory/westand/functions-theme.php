<?php

// video short code

if ( ! function_exists( 'cs_video_page' ) ) {

	function cs_video_page(){

		global $cs_node;

		$html = '<div class="element_size_'.$cs_node->video_element_size.'">';

			$html .= wp_oembed_get( $cs_node->video_url, array('width'=>$cs_node->video_width, 'height'=>$cs_node->video_height) );

		$html .= '</div>';

		return $html;

	}

}



// image short code

if ( ! function_exists( 'cs_image_page' ) ) {

	function cs_image_page(){

		global $cs_node;

 
		$href = '';

		$html = '';

		if ($cs_node->image_lightbox == "yes") $href = $cs_node->image_source;

		if($cs_node->image_lightbox =="yes") $data_rel = 'data-rel="prettyPhoto"';

			else $data_rel = 'target="_blank"';

		

		if ( $cs_node->image_element_size <> "" ) { $html .= '<div class="element_size_'.$cs_node->image_element_size.'">'; }

			$html .= '<figure class="lightbox-single image-shortcode" style="float:left; width:'.$cs_node->image_width.'px; height:'.$cs_node->image_height.'px">';

				if ($cs_node->image_lightbox == "yes"){

				$html .= '<a class="'.$cs_node->image_style.'" href="'.$href.'" title="'.$cs_node->image_caption.'" '.$data_rel.'>';

				}

					$html .= '<img src="'.$cs_node->image_source.'" style="float:left; width:'.$cs_node->image_width.'px; height:'.$cs_node->image_height.'px" alt="" />';

				if ($cs_node->image_lightbox == "yes"){

				$html .= '</a>';

				}

				$html .= '<figcaption class="webkit">';

					$html .= '<h6>'.$cs_node->image_caption.'</h6>';

				$html .= '</figcaption>';

			$html .= '</figure>';

		if ( $cs_node->image_element_size <> "" ) { $html .= '</div>'; }

		return $html;

	}

}

// Divider shortcode use for sepratiion of page elements

if ( ! function_exists( 'cs_divider_page' ) ) { 

	function cs_divider_page(){

		global $cs_node;

		wp_enqueue_script('scrolltopcontrol_js', get_template_directory_uri() . '/scripts/frontend/scrolltopcontrol.js', '', '', true);

		$html = '<div class="devider element_size_'.$cs_node->divider_element_size.'>">';

		if($cs_node->divider_style <> "divider2"){

			$html .= '<div style="margin-top:'.$cs_node->divider_mrg_top.'px;margin-bottom:'.$cs_node->divider_mrg_bottom.'px; " class="' . $cs_node->divider_style . '">';

			if(isset($cs_node->divider_backtotop) && strtolower($cs_node->divider_backtotop)=='yes'){

				$html .= '<a href="#" class="gotop" id="back-top">'.__('Top','WeStand').'</a>';

			}

		}

		if($cs_node->divider_style == "divider2"){

			$html .= '<div style="margin-top:'.$cs_node->divider_mrg_top.'px;margin-bottom:'.$cs_node->divider_mrg_bottom.'px; " class="heading-seprator"><span class="heading-pattren"></span>';

			if(isset($cs_node->divider_backtotop) && strtolower($cs_node->divider_backtotop)=='yes'){

				$html .= '<a href="#" class="gotop" id="back-top">'.__('Top','WeStand').'</a>';

			}

		}



		$html .= '</div>';

		$html .= '</div>';

		return $html . '<div class="clear"></div>';

	}

}



// Column shortcode with 2/3/4 column option even you can use shortcode in column shortcode

if ( ! function_exists( 'cs_column_page' ) ) {

	function cs_column_page(){

		global $cs_node;

		$html = '<div class="element_size_'.$cs_node->column_element_size.' column">';

			$html .= do_shortcode(html_entity_decode($cs_node->column_text));

		$html .= '</div>';

		echo $html;

	}

}



// tabs shortcode

if ( ! function_exists( 'cs_tabs_page' ) ) {
	function cs_tabs_page(){
		global $cs_node, $tab_counter;
		$html = "";
		if ( $cs_node->tabs_element_size == "" ) {
			$html .= '<ul class="nav nav-tabs" id="myTab">';
			$xmlObject = simplexml_load_string($cs_node->tabs_content);
			$tabs_count = 0;
			foreach ($xmlObject as $val) {
				if (!isset($val["icon"])){ $val["icon"] = '';}
				if (!isset($val["title"])){ $val["title"] = '';}
				$tabs_count++;
				if ( $val["active"] == "yes")
					$tab_active = " active";
				else
					$tab_active = "";
				$html .= '<li class="' . $tab_active . '"><a data-toggle="tab" href="#tab' . $tab_counter . $tabs_count . '"><i class="fa '.$val["icon"].'"></i> ' . $val["title"] . '</a></li>';
			}
			$html .= '</ul>';
			$html .= '<div class="tab-content">';
			$tabs_count = 0;
			foreach ($xmlObject as $val) {
				$tabs_count++;
				if ( $val["active"] == "yes")
					$tab_active = " active";
				else
					$tab_active = "";
				$html .= '<div class="tab-pane fade in ' . $tab_active . '" id="tab' . $tab_counter . $tabs_count . '">' . $val . '</div>';
			}
			$html .= '</div>';
			$html = '<div class="tabs '.$cs_node->tabs_style.'">' . $html . '</div>';
		}
		else {
			$aaa = array();
			$tab_counter++;
			$tabs_count = 0;
				$html = '<div class="element_size_'.$cs_node->tabs_element_size.'"><div class="tabs horizontal">';
					$html .= '<ul class="nav nav-tabs" id="myTab">';
					foreach ( $cs_node->tab as $cs_node ){
						$aaa["$cs_node->tab_title"] = $cs_node->tab_text;
						$tabs_count++;
						if ($cs_node->tab_active == "yes")
							$tab_active = " active";
						else
							$tab_active = "";
						$html .= '<li class="' . $tab_active . '"><a data-toggle="tab" href="#tab' . $tab_counter . $tabs_count . '"><i class="fa '.$cs_node->tab_title_icon.'"></i>' . $cs_node->tab_title . '</a></li>';
					}
					$html .= '</ul>';
					$html .= '<div class="tab-content">';
					$tabs_count = 0;
					foreach( $aaa as $keys=>$vals ){
						$tabs_count++;
						if ($tabs_count == 1)
							$tab_active = " active";
						else
							$tab_active = "";
						$html .= '<div class="tab-pane fade in ' . $tab_active . '" id="tab' . $tab_counter . $tabs_count . '">' . $vals . '</div>';
					}
					$html .= '</div></div>';
			$html = $html ;
		}
		return do_shortcode($html) . '<div class="clear"></div>';
	}
}

// Accrodian shortcode
// Accrodian shortcode
if ( ! function_exists( 'cs_accordions_page' ) ) {
	function cs_accordions_page(){
		global $cs_node, $acc_counter;
		$acc_counter = rand(5, 15);
		$acc_counter++;
		$accordion_count = 0;
		$html = "";
		if ( $cs_node->accordion_element_size == "" ) {

			$html .= '<div class="panel-group" id="accordion-' . $acc_counter . '">';

			$cs_xmlObject = new SimpleXMLElement( $cs_node->accordion_content );

			foreach ($cs_xmlObject as $cs_node) {

			if (!isset($cs_node["icon"])){ $cs_node["icon"] = '';}

			if (!isset($cs_node["title"])){ $cs_node["title"] = '';}

		

				$accordion_count++;

				if ($accordion_count == 1 && $cs_node["active"] == "yes")

						$class_active = " active";

					else

						$class_active = "collapsed";

						

				if ( $cs_node["active"] == "yes"){

					

					$accordion_active = " in";

					 

				}else{

					$accordion_active = "";

					

				}

				$html .= '<div class="panel panel-default"><div class="panel-heading">';

				$html .= '<i class="fa fa-question-sign fa fa-2"></i>';

				$html .= '<h4 class="panel-title">';

				$html .= '<a class="accordion-toggle backcolorhover  '.$class_active .'" data-toggle="collapse" data-parent="#accordion-' . $acc_counter . '" href="#accordion-' . str_replace(" ", "", $accordion_count . $acc_counter) . '"><i class="fa '.$cs_node["icon"].'"></i> ' . $cs_node["title"] . '</a>';

				$html .= '</h4>';

				$html .= '</div>';

				$html .= '<div id="accordion-' . str_replace(" ", "", $accordion_count . $acc_counter) . '" class="accordion-body collapse ' . $accordion_active . '">';

				$html .= '<div class="panel-body"><p>' . $cs_node . '</p></div>';

				$html .= '</div>';

				$html .= '</div>';

			}

			$html .= '</div>';

		}
		else {
			$html = '<div class="element_size_'.$cs_node->accordion_element_size.'">';
				$html .= '<div class="panel-group" id="accordion-' . $acc_counter . '">';
					foreach ( $cs_node->accordion as $cs_node ){

						if (!isset($cs_node["icon"])){ $cs_node["icon"] = '';}
			
						if (!isset($cs_node["title"])){ $cs_node["title"] = '';}
			
							$accordion_count++;
							if ($accordion_count == 1 && $cs_node->accordion_active == "yes")
									$class_active = " active";
								else
									$class_active = "";
							if ($accordion_count == 1)
								$accordion_active = " ";
							else
								$accordion_active = "";
			
			
							$html .= '<div class="panel panel-default"><div class="panel-heading">';
			
							$html .= '<i class="fa fa-question-sign fa fa-2"></i>';
			
							$html .= '<h4 class="panel-title">';
			
							$html .= '<a class="accordion-toggle backcolorhover collapsed '.$class_active .'" data-toggle="collapse" data-parent="#accordion-' . $acc_counter . '" href="#accordion-' . str_replace(" ", "", $accordion_count . $acc_counter) . '"><i class="fa '.$cs_node->accordion_title_icon.'"></i> ' . $cs_node->accordion_title . '</a>';
			
							$html .= '</h4>';
			
							$html .= '</div>';
			
							$html .= '<div id="accordion-' . str_replace(" ", "", $accordion_count . $acc_counter) . '" class="accordion-body collapse ' . $accordion_active . '">';
			
							$html .= '<div class="panel-body"><p>' . $cs_node->accordion_text . '</p></div>';
			
							$html .= '</div>';
			
							$html .= '</div>';

			
					}
				$html .= '</div>';
			$html .= '</div>';
			echo do_shortcode($html);	
		}
		return do_shortcode($html) . '<div class="clear"></div>';
	}
}
// Services shortcode with multiple layout
if ( ! function_exists( 'cs_services_page' ) ) {
	function cs_services_page() {
    	global $cs_node, $post, $element_size_class, $cs_theme_option;
    	?>
        <div class="element_size_<?php echo $cs_node->services_element_size; ?>">
            <!-- Prayer Submit Start -->
            <div class="services border-bottom">
                <?php
                foreach ($cs_node->service as $service_info) {
					if ( $service_info->service_type == "type2" ) $service_style = "service-v1";
					else $service_style = "service-v3";
		
                    ?>
                    
                    <?php if ( $service_info->service_type == "type2" ){?>
                    	<article class="<?php echo $service_style?>">
                        <?php if ($service_info->service_bg_image <> '') { ?>
                            <figure>
                                <img src="<?php echo $service_info->service_bg_image;?>" alt="">
                            </figure>
                            <?php } ?>
                            <div class="text">
                                <h2><a href="<?php echo $service_info->service_link_url; ?>" class="cs-colrhvr"><?php echo $service_info->service_title; ?></a></h2>
                                <?php if ($service_info->service_icon <> '') { ?><i class="fa <?php echo $service_info->service_icon; ?>"></i><?php } ?>
                            </div>
                        </article>
                   	<?php } else {?> 
                        <article class="<?php echo $service_style?>">
                            <figure><?php if ($service_info->service_icon <> '') { ?><i class="fa <?php echo $service_info->service_icon; ?> fa-2x"></i><?php } ?></figure>
                            <div class="text">
                                <h5><a href="<?php echo $service_info->service_link_url; ?>" ><?php echo $service_info->service_title; ?></a></h5>
                                <p><?php echo do_shortcode($service_info->service_text); ?></p>
                            </div>
                        </article>
                    <?php } 
				}
					?>
                </div>
                <!-- Prayer Submit End -->
              <div class="clearfix"></div> 
            </div>
        <?php
    }
}

// video short code
if ( ! function_exists( 'cs_video_page' ) ) {
	function cs_video_page(){
		global $cs_node;
		$html = '<div class="element_size_'.$cs_node->video_element_size.'">';
			$html .= wp_oembed_get( $cs_node->video_url, array('width'=>$cs_node->video_width, 'height'=>$cs_node->video_height) );
		$html .= '</div>';
		return $html;
	}
}

// block quote short code
if ( ! function_exists( 'cs_quote_page' ) ) {
	function cs_quote_page(){
		global $cs_node;
		$html = '<div class="element_size_'.$cs_node->quote_element_size.'">';
			$html .= '<blockquote class="blockquote" style=" text-align:' .$cs_node->quote_align. '; color:' . $cs_node->quote_text_color . '"><span>' . $cs_node->quote_content . '</span><div class="quote"></div></blockquote>';
		$html .= '</div>';
		return $html . '<div class="clear"></div>';
	}
}




// Corlor Switcher for front end

function cs_color_switcher(){

	global $cs_theme_option;

 	if ( $cs_theme_option['color_switcher'] == "on" ) {



		if ( empty($_POST['patter_or_bg']) ){

			$_POST['patter_or_bg'] = '';

		}

		

		if ( empty($_POST['reset_color_txt']) ) { 

			$_POST['reset_color_txt'] = "";

		}

		else if ( $_POST['reset_color_txt'] == "1" ) {

			$_POST['layout_option'] = 'wrapper';

			$_POST['custome_pattern'] = "";

			$_POST['bg_img'] = "";

			$_POST['style_sheet'] = $cs_theme_option['custom_color_scheme'];

			$_POST['heading_color'] = $cs_theme_option['custom_color_scheme'];

 		}

		

		if ( $_POST['patter_or_bg'] == 0 ){

			$_SESSION['wssess_bg_img'] = '';

		}

		else if ( $_POST['patter_or_bg'] == 1 ){

			$_SESSION['wssess_custome_pattern'] = '';

		}

		

		if ( isset($_POST['layout_option']) ) {

			$_SESSION['wssess_layout_option'] = 'wrapper_boxed';

		}

		if ( isset($_POST['style_sheet']) ) {

			$_SESSION['wssess_style_sheet'] = $_POST['style_sheet'];

		}

		if ( isset($_POST['heading_color']) ) {

			$_SESSION['wssess_heading_color'] = $_POST['heading_color'];

		}

		if ( isset($_POST['custome_pattern']) ) {

			$_SESSION['wssess_custome_pattern'] = $_POST['custome_pattern'];

		}

		if ( isset($_POST['bg_img']) ) {

			$_SESSION['wssess_bg_img'] = $_POST['bg_img'];

		}



		if ( empty($_SESSION['wssess_layout_option']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['wssess_layout_option'] = ""; }

		if ( empty($_SESSION['wssess_header_styles']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['wssess_header_styles'] = ""; }

		if ( empty($_SESSION['wssess_style_sheet']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['wssess_style_sheet'] = ''; }

		if ( empty($_SESSION['wssess_custome_pattern']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['wssess_custome_pattern'] = ""; }

		if ( empty($_SESSION['wssess_bg_img']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['wssess_bg_img'] = ""; }



		$theme_path = get_template_directory_uri();	

		wp_enqueue_style( 'wp-color-picker' );

		

		wp_enqueue_script('iris',admin_url( 'js/iris.min.js' ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ),false, 1  );

		wp_enqueue_script('wp-color-picker',admin_url( 'js/color-picker.min.js' ),array( 'iris' ),false,1);

		$colorpicker_l10n = array(

			'clear' => 'Clear',

			'defaultString' => 'Default',

			'pick' => 'Select Color'

		);

		wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', $colorpicker_l10n );

?>



		<script type="text/javascript">

        jQuery(document) .ready(function($){

   			jQuery("#togglebutton").click(function(){

				jQuery("#sidebarmain").trigger('click')

				jQuery(this).toggleClass('btnclose');

				jQuery("#sidebarmain") .toggleClass('sidebarmain');

				return false; 

		   });

           jQuery("#pattstyles li label") .click(function(){
			   
			   var classname=jQuery("#wrappermain-cs") .hasClass("wrapper_boxed"); 
			   
			

				if(classname == false) { 

					alert("Please select Boxed View")

					return false; 

					

				} else {

					jQuery("#backgroundimages li label") .removeClass("active");	

					jQuery("#patter_or_bg") .attr("value","0");

					var ah = jQuery(this) .find('input[type="radio"]') .val();

					jQuery('body') .css({"background":"url(<?php echo $theme_path?>/images/pattern/pattern"+ah+".png)"});

				}

      });

      jQuery("#backgroundimages li label") .click(function(){
		  
		   var classname=jQuery("#wrappermain-cs") .hasClass("wrapper_boxed"); 
			   

		// var classname=$(".layoutoption li:first-child label") .hasClass("active"); 

			if(classname == false) { 

				alert("Please select Boxed View")

				return false; 

				

			} else {

				$("#patter_or_bg") .attr("value","1");

				$("#pattstyles li label") .removeClass("active");	

				var ah = $(this) .find('input[type="radio"]') .val();

				$('body') .css({"background":"url(<?php echo $theme_path?>/images/background/bg"+ah+".png) no-repeat center center / cover fixed"});

			}

	  

     });

   $("#backgroundimages li label,#pattstyles li label") .click(function(){

		var classname=$(".layoutoption li:first-child label") .hasClass("active"); 

		if(classname) {

			//alert("Please select Boxed View")

			return false; 

		}else {

		  $(this) .parents(".selectradio") .find("label") .removeClass("active");

		  $(this) .addClass("active");

	

		 }

    });

                jQuery(".layoutoption li label") .click(function(){

					//jQuery("#header").scrollToFixed();

    var th = $(this).find('input') .val();

    $("#wrappermain-cs") .attr('class','');

    $('#wrappermain-cs') .addClass(th);

                $(this) .parents(".selectradio") .find("label") .removeClass("active");

                $(this) .addClass("active");


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

		jQuery(".colorpicker-main").click(function(){

		jQuery(this).find('.wp-color-result').trigger('click'); 

    });

	<!-- Color-->

	var cf = '.cs-colr, .cs-colrhvr:hover,.followus a:hover, .tagclouds a:hover,.post-options li a:hover,.cs-timeline article:hover h2,.team-shortcode article:hover .text h3, .pagination ul li:hover a,div.woocommerce a:hover,p a:hover, .archive-page article p strong,#footer p a'; 

	<!-- Background Color-->

var bc ='.cs-bgcolr,.cs-bgcolrhvr:hover,.navigation ul ul li:hover > a,.cycle-pager-active,.pager-desc:before,.fc-header,.fc-event, .pagination ul li a:before, .navigation select,p.stars span a:hover,p.stars span a.active,.comment-form p input[type="submit"]:hover,.widget_newsletter .error,.rev_slider_wrapper, .mercy-style,.wpcf7 form p input[type="submit"]:hover, .password_protected form input[type="submit"],.widget_search input[type="submit"],.tagcloud a:hover,.dropcaptwo:first-letter,.onsale,.add_to_cart_button.button:hover,.woocommerce-pagination ul li span,.woocommerce-pagination ul li a:hover,.woocommerce-message:before,.woocommerce-error:before,.woocommerce-info:before,div.woocommerce .button:hover, .undercunst-box,.flexslider li figcaption h2';

	<!-- Border Color-->

	var boc =".cs-bdrcolr,.navigation > ul > li > a:before,.woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit,.woocommerce #content input.button,.woocommerce-page a.button,.woocommerce-page button.button,.woocommerce-page input.button,.woocommerce-page #respond input#submit,.woocommerce-page #content input.button,.woocommerce-info,.woocommerce-message, .woocommerce-error";

	<!-- Border Transparent Color-->

	var boc2 =".widget_newsletter .error:before";

 	jQuery("#colorpickerwrapp span.col-box") .live("click",function(event) {
			//alert('test');
			var a = jQuery(this).data('color');
			//alert(a);
			jQuery("#bgcolor").val(a);
			jQuery('.wp-color-result').css('background-color', a);
			$("#color_switcher_stylecss") .remove();
			$("<style type='text/css' id='color_switcher_stylecss'>"+cf+"{color:"+a+" !important}"+bc+"{background-color:"+a+" !important}"+boc+"{border-color:"+a+" !important}"+boc2+"{border-color:transparent "+a+" !important}</style>").insertAfter("#wrappermain-cs");
			
			
			
			jQuery("#colorpickerwrapp span.col-box") .removeClass('active');
			jQuery(this).addClass("active");
		});

	jQuery('#themecolor .bg_color').wpColorPicker({

		change:function(event,ui){
		

			var a = ui.color.toString();
			
			$("#color_switcher_stylecss") .remove();

			$("<style type='text/css' id='color_switcher_stylecss'>"+cf+"{color:"+a+" !important}"+bc+"{background-color:"+a+" !important}"+boc+"{border-color:"+a+" !important}"+boc2+"{border-color:transparent "+a+" !important}</style>").insertAfter("#wrappermain-cs");

			} 

    	}); 

 	});
	
	

	function reset_color(){

		jQuery("#reset_color_txt").attr('value',"1")

		jQuery("#bgcolor").attr('value',"<?php echo $cs_theme_option['custom_color_scheme'];?>")

		jQuery("#color_switcher").submit();

	}

        </script>

        <div id="sidebarmain">

            <span id="togglebutton">&nbsp;</span>

            <div id="sidebar">

                <form method="post" id="color_switcher" action="">

                	<aside class="rowside">

      					<header><h4>Layout options</h4></header>
                        <div class="switcher-inn">
                            <h5>Select Color Scheme</h5>
                            <div id="colorpickerwrapp">
                                <?php $cs_color_array= array('#45b363','#339a74', '#1d7f5b', '#3fb0c3', '#2293a6', '#137d8f', '#9374ae', '#775b8f', '#dca13a', '#c46d32', '#c44732', '#c44d55', '#425660', '#292f32');
                                foreach($cs_color_array as $colors){
                                    $active = '';
                                    if($colors == $cs_theme_option['custom_color_scheme']){$active = 'active';}
                                    echo '<span class="col-box '.$active.'" data-color="'.$colors.'" style="background: '.$colors.'"></span>';
                                }
                                ?>
                            </div>
                            <?php /*?><label for="bgcolor" id="themecolor" class="colorpicker-main">
    
                            <img src="<?php echo $theme_path?>/images/admin/img-colorpan.png" alt="">
    
                            <h5>Theme Color</h5>
    
                            <input id="bgcolor" name="style_sheet" type="text" class="bg_color" value="<?php echo $_SESSION['wssess_style_sheet'];?>" /></label><?php */?>
                            <h5>Choose Your Layout Style</h5>
    
                            <ul class="layoutoption selectradio">
                                <li><label class="label_radio <?php if($_SESSION['wssess_layout_option']=="wrapper_boxed")echo "active";?> ">
                                <span>Boxed</span>
                                <i class="fa fa-columns"></i><input type="radio" name="layout_option" value="wrapper_boxed" ></label></li>
    							
                                <li><label class="full-view <?php if($_SESSION['wssess_layout_option']=="wrapper")echo "active";?> ">
                                <span>Full</span>
                                <i class="fa fa-arrows-h"></i><input type="radio" name="layout_option" value="wrapper" ></label></li>
                            </ul>
						</div>
                    </aside>

                    <div class="accordion-sidepanel">

                    <aside class="rowside">

                      <header>  <h4>Pattren Styles</h4></header>

                      <div class="innertext">

                      

                        <div id="pattstyles" class="itemstyles selectradio">
							<span>Patterns are available in boxed mode</span>
                            <ul>

                                <li><label <?php if($_SESSION['wssess_custome_pattern']=="1")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern1.png" alt=""><input type="radio" name="custome_pattern" value="1"></label></li>

                                <li><label <?php if($_SESSION['wssess_custome_pattern']=="2")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern2.png" alt=""><input type="radio" name="custome_pattern" value="2"></label></li>

                                <li><label <?php if($_SESSION['wssess_custome_pattern']=="3")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern3.png" alt=""><input type="radio" name="custome_pattern" value="3"></label></li>

                                <li><label <?php if($_SESSION['wssess_custome_pattern']=="4")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern4.png" alt=""><input type="radio" name="custome_pattern" value="4"></label></li>

                                <li><label <?php if($_SESSION['wssess_custome_pattern']=="5")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern5.png" alt=""><input type="radio" name="custome_pattern" value="5"></label></li>

                                <li><label <?php if($_SESSION['wssess_custome_pattern']=="6")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern6.png" alt=""><input type="radio" name="custome_pattern" value="6"></label></li>

                                <li><label <?php if($_SESSION['wssess_custome_pattern']=="7")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern7.png" alt=""><input type="radio" name="custome_pattern" value="7"></label></li>

                                <li><label <?php if($_SESSION['wssess_custome_pattern']=="8")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern8.png" alt=""><input type="radio" name="custome_pattern" value="8"></label></li>

                                <li><label <?php if($_SESSION['wssess_custome_pattern']=="9")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern9.png" alt=""><input type="radio" name="custome_pattern" value="9"></label></li>

                                <li><label <?php if($_SESSION['wssess_custome_pattern']=="10")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern10.png" alt=""><input type="radio" name="custome_pattern" value="10"></label></li>
                                 <li><label <?php if($_SESSION['wssess_custome_pattern']=="11")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern11.png" alt=""><input type="radio" name="custome_pattern" value="11"></label></li>
                                  <li><label <?php if($_SESSION['wssess_custome_pattern']=="12")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern12.png" alt=""><input type="radio" name="custome_pattern" value="12"></label></li>
                                    <li><label <?php if($_SESSION['wssess_custome_pattern']=="13")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern13.png" alt=""><input type="radio" name="custome_pattern" value="13"></label></li>
                                      <li><label <?php if($_SESSION['wssess_custome_pattern']=="14")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern14.png" alt=""><input type="radio" name="custome_pattern" value="14"></label></li>
                                        <li><label <?php if($_SESSION['wssess_custome_pattern']=="15")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern15.png" alt=""><input type="radio" name="custome_pattern" value="15"></label></li>

                               

                            </ul>

                        </div>

                        </div>

                    </aside>

                    <aside class="rowside">

                        <header><h4>Background Images</h4></header>

                        <div class="innertext">

                      

                        <div id="backgroundimages" class="selectradio">

                            <ul>

                            	<li><label <?php if($_SESSION['wssess_bg_img']=="1")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background1.png" alt=""><input type="radio" name="bg_img" value="1"></label></li>

                                <li><label <?php if($_SESSION['wssess_bg_img']=="2")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background2.png" alt=""><input type="radio" name="bg_img" value="2"></label></li>

                                <li><label <?php if($_SESSION['wssess_bg_img']=="3")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background3.png" alt=""><input type="radio" name="bg_img" value="3"></label></li>

                                <li><label <?php if($_SESSION['wssess_bg_img']=="4")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background4.png" alt=""><input type="radio" name="bg_img" value="4"></label></li>

                                <li><label <?php if($_SESSION['wssess_bg_img']=="5")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background5.png" alt=""><input type="radio" name="bg_img" value="5"></label></li>

                                <li><label <?php if($_SESSION['wssess_bg_img']=="6")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background6.png" alt=""><input type="radio" name="bg_img" value="6"></label></li>

                                <li><label <?php if($_SESSION['wssess_bg_img']=="7")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background7.png" alt=""><input type="radio" name="bg_img" value="7"></label></li>


                            </ul>

                        </div>

                        </div>

                    </aside>

                    </div>

                	<div class="buttonarea">

                    	<input type="submit" value="Apply" class="btn" />

                        <input type="hidden" name="patter_or_bg" id="patter_or_bg" value="1" />

                        <input type="hidden" name="reset_color_txt" id="reset_color_txt" value="" />

                    	<input type="reset" value="Reset" class="btn" onclick="javascript:reset_color()" />

                    </div>

            </form>

            </div>

        </div>

<?php

	}

}

function cs_custom_styles() {

	global $cs_theme_option;
	$menu_bg_color = $menu_font_color = '';

 	if ( isset($_POST['style_sheet']) ) {

		$_SESSION['wssess_style_sheet'] = $_POST['style_sheet'];

		$cs_color_scheme = $_SESSION['wssess_style_sheet'];

	}

	elseif (isset($_SESSION['wssess_style_sheet']) and $_SESSION['wssess_style_sheet'] <> '') {

		$cs_color_scheme = $_SESSION['wssess_style_sheet'];

	}

	else{

		$cs_color_scheme = $cs_theme_option['custom_color_scheme'];
		

	}
	if(isset($cs_theme_option['menu_bg_color'])){
		$menu_bg_color = $cs_theme_option['menu_bg_color'];
	}
	if(isset($cs_theme_option['menu_font_color'])){
		$menu_font_color = $cs_theme_option['menu_font_color'];
	}
	

 ?>

	<style type="text/css" >

/* -- Theme Color -- */
.cs-colr, .cs-colrhvr:hover,.followus a:hover, .tagclouds a:hover,.post-options li a:hover,.cs-timeline article:hover h2,.team-shortcode article:hover .text h3, .pagination ul li:hover a,div.woocommerce a:hover,p a:hover, .archive-page article p strong,#footer p a {
	color:<?php echo $cs_color_scheme; ?> !important;
}

.cs-bgcolr,.cs-bgcolrhvr:hover,.navigation ul ul li:hover > a,.cycle-pager-active,.pager-desc:before,.fc-header,.fc-event, .pagination ul li a:before, .navigation select,p.stars span a:hover,p.stars span a.active,.comment-form p input[type="submit"]:hover,.widget_newsletter .error,.rev_slider_wrapper, .mercy-style,.wpcf7 form p input[type="submit"]:hover, .password_protected form input[type="submit"],.widget_search input[type="submit"],.tagcloud a:hover,.cart-sec span,.dropcaptwo:first-letter,.onsale,.add_to_cart_button.button:hover,.woocommerce-pagination ul li span,.woocommerce-pagination ul li a:hover,.woocommerce-message:before,.woocommerce-error:before,.woocommerce-info:before,div.woocommerce .button:hover, .undercunst-box,.flexslider li figcaption h2, btn{
	background-color:<?php echo $cs_color_scheme; ?> !important;
}
.cs-bdrcolr,.navigation > ul > li > a:before,.woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit,.woocommerce #content input.button,.woocommerce-page a.button,.woocommerce-page button.button,.woocommerce-page input.button,.woocommerce-page #respond input#submit,.woocommerce-page #content input.button,.woocommerce-info,.woocommerce-message, .woocommerce-error{
	border-color:<?php echo $cs_color_scheme; ?> !important;
}
.widget_newsletter .error:before{
	border-color: transparent <?php echo $cs_color_scheme; ?> !important;
}

#header{ 
	background-color: <?php echo $menu_bg_color; ?> !important;
	
}
.navigation > ul > li > a{
	 color:  <?php echo $menu_font_color; ?> !important;
}


</style>

<?php 

}

/*

 * Ccustom Header Styles 

 */
if ( ! function_exists( 'cs_get_header' ) ) { 
	function cs_get_header() {
		global $post, $cs_theme_option;
	?>
		<!-- Header Start -->
        <header id="header">
        <div class="container">
        	<!-- Left Header Start -->
        	<div class="left-header">
            	<div class="logo"><?php cs_logo();?></div>
                <!-- Navigation -->
                <nav class="navigation">
                	<a class="cs-click-menu"><i class="fa fa-bars"></i></a>                                                            
                    <?php cs_navigation('main-menu'); ?>
                </nav>
                <!-- Navigation Close -->
            </div>
            <!-- Left Header End -->
            <div class="right-header">
            <?php if(isset($cs_theme_option['header_donation_button']) && $cs_theme_option['header_donation_button'] == 'on'){?>
            <a href="#" class="btn cs-bgcolr" data-toggle="modal" data-target="#myModal"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Support us','WeStand');}else{ echo $cs_theme_option['donation_btn_title']; } ?></a>
            <?php }?>
            <?php if ( function_exists('icl_object_id') ) {?>
                    <div class="language-sec">
                        <!-- Wp Language Start -->
                         <?php 
                         if(isset($cs_theme_option['header_languages'])){
                             if(isset($cs_theme_option['header_languages']) && $cs_theme_option['header_languages'] == 'on'){
                                do_action('icl_language_selector');
                             }
                         }
                        ?>
                    </div>
                  <?php 
				}
				if ( function_exists( 'is_woocommerce' ) ){
					if(!isset($cs_theme_option['header_cart'])){ $cs_theme_option['header_cart'] = '';}

					if($cs_theme_option['header_cart'] == 'on'){ cs_woocommerce_header_cart(); }
				}
				?>
            </div>
            
        </div>
    </header>
	<!-- Header Close -->
	<?php
	}
}



// Custom excerpt function 
if ( ! function_exists( 'cs_get_the_excerpt' ) ) { 
	function cs_get_the_excerpt($limit,$readmore = '') {
	
		global $cs_theme_option;
	
		$get_the_excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU', '', get_the_excerpt()));
	
		echo substr($get_the_excerpt, 0, "$limit");
	
		if (strlen($get_the_excerpt) > "$limit") {
	
			if($readmore == "true"){
	
				echo '... <a href="' . get_permalink() . '" class="cs-read-more colr">' .$cs_theme_option['trans_read_more'] . '</a>';
	
			}
		}
	}
}
if ( ! function_exists( 'cs_post_slider' ) ) {

	function cs_post_slider($cs_slider_blog_cat,$blog_no_posts){
		global $post, $cs_theme_option;
		if (empty($_GET['page_id_all'])) $_GET['page_id_all'] = 1;
		$args = array('posts_per_page' => "$blog_no_posts", 'paged' => $_GET['page_id_all'], 'category_name' => "$cs_slider_blog_cat");
		$custom_query = new WP_Query($args);
		$post_count = $custom_query->post_count;
		if($custom_query->have_posts()):
		cs_cycleslider_script();
		$slider_pagination = array();
				echo '<div id="sliderbanner">';
					echo '<div class="cycle-slideshow" 
								data-cycle-fx=fade
								data-cycle-timeout=3000
								data-cycle-auto-height=container
								data-cycle-slides="article"
								data-cycle-loader=true
								data-cycle-pager="#banner-pager"
								data-cycle-pager-template="">';
							while ($custom_query->have_posts()) : $custom_query->the_post();
								$image_url_full = cs_get_post_img_src($post->ID, '' ,'');
								echo $slider_pagination[] = get_the_title();
								?>
									<article>
                                        <?php if($image_url_full <> ''){?><img src="<?php echo $image_url_full;?>" alt=""><?php }?>
                                               <div class="caption">
                                                	<h2><?php the_title();?></h2>
                                               		<p><?php  cs_get_the_excerpt('113',false);?></p>
                                                	<a href="<?php the_permalink();?>" class="btn cs-bgcolrhvr"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Continue Reading','WeStand');}else{ echo $cs_theme_option['trans_read_more']; }?></a>
                                               </div> 
                                    </article>
                                <?php
							endwhile;
				echo '</div>';
			echo '</div>';
			if(isset($cs_theme_option['show_slider_pagination']) && $cs_theme_option['show_slider_pagination'] == 'on'){
				$pagination_no = 0;
				echo '<div id="sliderpagination">
				<div class="container">
					<ul id="banner-pager">';
					foreach($slider_pagination as $slider){
						$pagination_no++;
						$slider_title = substr($slider,0,30); if ( strlen($slider) > 30) $slider_title .= "...";
						echo '<li>
								<div class="pager-desc">
									<span class="cs-number">'.str_pad($pagination_no, 2, "0", STR_PAD_LEFT).'</span>
									<span class="cs-desc">'.$slider_title.'</span>
								</div>
							</li>';
					}
					echo '</ul>
				</div>
			</div>';
			}
		endif;
		
	}
}


// Flexslider function

if ( ! function_exists( 'cs_flex_slider' ) ) {

	function cs_flex_slider($width,$height,$slider_id){

		global $cs_node,$cs_theme_option,$cs_counter_node;

		$cs_counter_node++;

		if($slider_id == ''){

			$slider_id = $cs_node->slider;

		}

		if($cs_theme_option['flex_auto_play'] == 'on'){$auto_play = 'true';}

			else if($cs_theme_option['flex_auto_play'] == ''){$auto_play = 'false';}

			$cs_meta_slider_options = get_post_meta($slider_id, "cs_meta_slider_options", true); 

		?>

		<!-- Flex Slider -->

		<div id="flexslider<?php echo $cs_counter_node; ?>">

		  <div class="flexslider" style="display: none;">

			  <ul class="slides">

				<?php 

					$cs_counter = 1;

					$cs_xmlObject_flex = new SimpleXMLElement($cs_meta_slider_options);

					foreach ( $cs_xmlObject_flex->children() as $as_node ){

						

 						$image_url = cs_attachment_image_src($as_node->path,$width,$height); 

						?>

                        <li>

                            <figure>

                                <img src="<?php echo $image_url ?>" alt="">   

                                <?php 

								if($as_node->title != '' && $as_node->description != '' || $as_node->title != '' || $as_node->description != ''){ 

								?>         

                                <figcaption>
                                	<div class="container">
                                    <?php if($as_node->title <> ''){?>
                                     	<h2 class="colr">
											<?php 
												if($as_node->link <> ''){ 
			
													 echo '<a href="'.$as_node->link.'" target="'.$as_node->link_target.'">' . $as_node->title . '</a>';
			
												} else {
			
													echo $as_node->title;
			
												}?>
											</h2>
                                            <?php }?>
                                            <?php if($as_node->description <> ''){?>
                                             <p>
        
                                                <?php
        
                                                    echo substr($as_node->description, 0, 220);
        
                                                    if ( strlen($as_node->description) > 220 ) echo "...";
        
                                                ?>
        
                                            </p>
                                           <?php }?>
									</div>

                                </figcaption>

                              <?php }?>

                            </figure>

        

                        </li>

					<?php 

					$cs_counter++;

					}

				?>

			  </ul>

		  </div>

		</div>

		<?php cs_enqueue_flexslider_script(); ?>

		<!-- Slider height and width -->

		<!-- Flex Slider Javascript Files -->

		<script type="text/javascript">

			jQuery(document).ready(function(){

				var speed = <?php echo $cs_theme_option['flex_animation_speed']; ?>; 

				var slidespeed = <?php echo $cs_theme_option['flex_pause_time']; ?>;

				jQuery('#flexslider<?php echo $cs_counter_node; ?> .flexslider').flexslider({

					animation: "<?php echo $cs_theme_option['flex_effect']; ?>", // fade
					slideshow: <?php echo $auto_play;?>,
					slideshowSpeed:speed,
					animationSpeed:slidespeed,
					prevText:"<em class='fa fa-long-arrow-left'></em>",
					nextText:"<em class='fa fa-long-arrow-right'></em>",
					start: function(slider) {
						jQuery('.flexslider').fadeIn();
					}
 
				});
  
			});

		</script>

	<?php

	}

}


// Get post meta in xml form

function cs_meta_page($meta) {

    global $cs_meta_page;

    $meta = get_post_meta(get_the_ID(), $meta, true);

    if ($meta <> '') {

        $cs_meta_page = new SimpleXMLElement($meta);

        return $cs_meta_page;

    }

}



function cs_meta_shop_page($meta, $id) {

    global $cs_meta_page;

    $meta = get_post_meta($id, $meta, true);

    if ($meta <> '') {

        $cs_meta_page = new SimpleXMLElement($meta);

        return $cs_meta_page;

    }

}



// pages sidebar

if ( ! function_exists( 'cs_meta_sidebar' ) ) { 

	function cs_meta_sidebar(){

		global $cs_meta_page;

		if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout == 'right') {

			 echo "<aside class='sidebar-right span3'><div class='column'>";

			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_meta_page->sidebar_layout->cs_sidebar_right) ) : endif;

			echo "</div></aside>";

		}

		else if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout == 'left'  ) {

			echo "<aside class='sidebar-left span3'><div class='column'>";

			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_meta_page->sidebar_layout->cs_sidebar_left) ) : endif;

			echo "</div></aside>";

		}

	}

}

// content class

if ( ! function_exists( 'cs_meta_content_class' ) ) {

	function cs_meta_content_class(){

		global $cs_meta_page,$cs_video_width;

		if ( $cs_meta_page->sidebar_layout->cs_layout == '' or $cs_meta_page->sidebar_layout->cs_layout == 'none' ) {

			$content_class = "col-md-12";

			$cs_video_width = 1170;

		}

		else if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout == 'right' ) {

			$content_class = "col-md-9";

			$cs_video_width = 870;

		}

		else if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout == 'left' ) {

			$content_class = "col-md-9";

			$cs_video_width = 870;

		}

		else if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and ($cs_meta_page->sidebar_layout->cs_layout == 'both' or $cs_meta_page->sidebar_layout->cs_layout == 'both_left' or $cs_meta_page->sidebar_layout->cs_layout == 'both_right')) {

			$content_class = "col-md-6";

			$cs_video_width = 570;

		}else{

			$content_class = "col-md-12";

		}

		return $content_class;

	}

}

// sidebar class

if ( ! function_exists( 'cs_meta_sidebar_class' ) ) {

	function cs_meta_sidebar_class(){

		global $cs_meta_page;

		if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout == 'right' ) {

			echo "sidebar-right col-md-3";

		}

		else if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout == 'left' ) {

			echo "sidebar-left col-md-3";

		}

	}

}

// Content pages Meta Class

if ( ! function_exists( 'cs_default_pages_meta_content_class' ) ) { 

	function cs_default_pages_meta_content_class($layout){

		if ( $layout == '' or $layout == 'none' ) {

			echo "span12";

		}

		else if ( $layout <> '' and $layout == 'right' ) {

			echo "content-left col-md-9";

		}

		else if ( $layout <> '' and $layout == 'left' ) {

			echo "content-right col-md-9";

		}

		else if ( $layout <> '' and $layout == 'both' ) {

			echo "content-right col-md-6";

		}

	}	

}

// Default pages sidebar class

if ( ! function_exists( 'cs_default_pages_sidebar_class' ) ) { 

	function cs_default_pages_sidebar_class($layout){

		if ( $layout <> '' and $layout == 'right' ) {

			echo "sidebar-right col-md-3";

		}

		else if ( $layout <> '' and $layout == 'left' ) {

			echo "sidebar-left col-md-3";

		}

	}

}

// Default page sidebar

function cs_default_pages_sidebar(){

	global $cs_theme_option;

  	if ( $cs_theme_option['cs_layout'] <> '' and $cs_theme_option['cs_layout'] == 'right' ) {

		if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_theme_option['cs_sidebar_right']) ) : endif;

	}

	else if ( $cs_theme_option['cs_layout'] <> '' and $cs_theme_option['cs_layout'] == 'left' ) {

		if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_theme_option['cs_sidebar_left']) ) : endif;

	}

 }
// custom pagination start

if ( ! function_exists( 'cs_pagination' ) ) {

	function cs_pagination($total_records, $per_page, $qrystr = '') {

		$html = '';

		$dot_pre = '';

		$dot_more = '';

		$total_page = ceil($total_records / $per_page);

		$loop_start = $_GET['page_id_all'] - 2;

		$loop_end = $_GET['page_id_all'] + 2;

		if ($_GET['page_id_all'] < 3) {

			$loop_start = 1;

			if ($total_page < 5)

				$loop_end = $total_page;

			else

				$loop_end = 5;

		}

		else if ($_GET['page_id_all'] >= $total_page - 1) {

			if ($total_page < 5)

				$loop_start = 1;

			else

				$loop_start = $total_page - 4;

			$loop_end = $total_page;

		}
		$html .= "<nav class='pagination'><ul>";
		if ($_GET['page_id_all'] > 1)

			$html .= "<li class='prev'><a href='?page_id_all=" . ($_GET['page_id_all'] - 1) . "$qrystr' >".__('&laquo; Previous', 'WeStand')."</a></li>";

		if ($_GET['page_id_all'] > 3 and $total_page > 5)

			$html .= "<li><a href='?page_id_all=1$qrystr'>1</a></li>";

		if ($_GET['page_id_all'] > 4 and $total_page > 6)

			$html .= "<li> <a>. . .</a> </li>";

		if ($total_page > 1) {

			for ($i = $loop_start; $i <= $loop_end; $i++) {

				if ($i <> $_GET['page_id_all'])

					$html .= "<li><a href='?page_id_all=$i$qrystr'>" . $i . "</a></li>";

				else

					$html .= "<li><a class='active'>" . $i . "</a></li>";

			}

		}

		if ($loop_end <> $total_page and $loop_end <> $total_page - 1)

			$html .= "<li> <a>. . .</a> </li>";

		if ($loop_end <> $total_page)

			$html .= "<li><a href='?page_id_all=$total_page$qrystr'>$total_page</a></li>";

		if ($_GET['page_id_all'] < $total_records / $per_page)

			$html .= "<li class='next'><a class='icon' href='?page_id_all=" . ($_GET['page_id_all'] + 1) . "$qrystr' >".__('Next &raquo;', 'WeStand')."</a></li>";
		$html .= "</ul></nav>";
		return $html;

	}

}

// pagination end


// Social network

if ( ! function_exists( 'cs_social_network' ) ) {

	function cs_social_network($icon_type='',$tooltip = ''){

		global $cs_theme_option;

		global $cs_theme_option;

		$tooltip_data='';

		if($icon_type=='large'){

			$icon = 'fa fa-2x';

		} else {

			$icon = 'icon';

		}

			if(isset($tooltip) && $tooltip <> ''){

				$tooltip_data='data-placement-tooltip="tooltip"';

			}

		if ( isset($cs_theme_option['social_net_url']) and count($cs_theme_option['social_net_url']) > 0 ) {

						$i = 0;

						foreach ( $cs_theme_option['social_net_url'] as $val ){

							?>

					<?php if($val != ''){?><a title="" href="<?php echo $val;?>" data-original-title="<?php echo $cs_theme_option['social_net_tooltip'][$i];?>" data-placement="top" <?php echo $tooltip_data;?> class="colrhover"  target="_blank"><?php if($cs_theme_option['social_net_awesome'][$i] <> '' && isset($cs_theme_option['social_net_awesome'][$i])){?> 

                    <span class="fa-stack fa-lg">

                        <em class="fa fa-square fa-stack-2x"></em>

                        <em class="<?php echo $cs_theme_option['social_net_awesome'][$i];?> <?php echo $icon;?> fa-stack-1x fa-inverse fa"></em>

                    </span>

					

					<?php } else {?><img src="<?php echo $cs_theme_option['social_net_icon_path'][$i];?>" alt="<?php echo $cs_theme_option['social_net_tooltip'][$i];?>" /><?php }?></a><?php }

							

						$i++;}

		}

		

	}

}

if ( ! function_exists( 'cs_social_network_widget' ) ) {

	function cs_social_network_widget($icon_type='',$tooltip = ''){

		global $cs_theme_option;

		global $cs_theme_option;

		$tooltip_data='';

		if($icon_type=='large'){

			$icon = 'fa fa-2x';

		} else {

			$icon = '';

		}

			if(isset($tooltip) && $tooltip <> ''){

				$tooltip_data='data-placement-tooltip="tooltip"';

			}

		if ( isset($cs_theme_option['social_net_url']) and count($cs_theme_option['social_net_url']) > 0 ) {

						$i = 0;

						foreach ( $cs_theme_option['social_net_url'] as $val ){

							?>

					<?php if($val != ''){?><a class="cs-colrhvr" title="" href="<?php echo $val;?>" data-original-title="<?php echo $cs_theme_option['social_net_tooltip'][$i];?>" data-placement="top" <?php echo $tooltip_data;?> target="_blank"><?php if($cs_theme_option['social_net_awesome'][$i] <> '' && isset($cs_theme_option['social_net_awesome'][$i])){?> 


                        <i class="fa <?php echo $cs_theme_option['social_net_awesome'][$i];?>"></i>


					

					<?php } else {?><img src="<?php echo $cs_theme_option['social_net_icon_path'][$i];?>" alt="<?php echo $cs_theme_option['social_net_tooltip'][$i];?>" /><?php }?>
					
				
                    
                     </a>
					 
					 <?php }

							

						$i++;}

		}

		

	}

}

// Post image attachment function

function cs_attachment_image_src($attachment_id, $width, $height) {

    $image_url = wp_get_attachment_image_src($attachment_id, array($width, $height), true);

     if ($image_url[1] == $width and $image_url[2] == $height)

        ;

    else

        $image_url = wp_get_attachment_image_src($attachment_id, "full", true);

    	$parts = explode('/uploads/',$image_url[0]);

		if ( count($parts) > 1 ) return $image_url[0];

}

// Post image attachment source function

function cs_get_post_img_src($post_id, $width, $height) {

    if(has_post_thumbnail()){

		$image_id = get_post_thumbnail_id($post_id);

		$image_url = wp_get_attachment_image_src($image_id, array($width, $height), true);

		if ($image_url[1] == $width and $image_url[2] == $height) {

			return $image_url[0];

		} else {

			$image_url = wp_get_attachment_image_src($image_id, "full", true);

			return $image_url[0];

		}

	}

}

// Get Post image attachment

function cs_get_post_img($post_id, $width, $height) {

    $image_id = get_post_thumbnail_id($post_id);

    $image_url = wp_get_attachment_image_src($image_id, array($width, $height), true);

    if ($image_url[1] == $width and $image_url[2] == $height) {

        return get_the_post_thumbnail($post_id, array($width, $height));

    } else {

        return get_the_post_thumbnail($post_id, "full");

    }

}

// Get Main background

function cs_bg_image(){

	global $cs_theme_option;

	$bg_img = '';

	if ( isset($_POST['bg_img']) ) {

		$_SESSION['wssess_bg_img'] = $_POST['bg_img'];

		$bg_img = get_template_directory_uri()."/images/background/bg".$_SESSION['wssess_bg_img'].".png";

	}

	else if ( isset($_SESSION['wssess_bg_img']) and !empty($_SESSION['wssess_bg_img'])){

		$bg_img = get_template_directory_uri()."/images/background/bg".$_SESSION['wssess_bg_img'].".png";

	}

	else {

		if (isset($cs_theme_option['bg_img_custom']) and $cs_theme_option['bg_img_custom'] == "" ) {

			if (isset($cs_theme_option['bg_img']) and $cs_theme_option['bg_img'] <> 0 ){

				$bg_img = get_template_directory_uri()."/images/background/bg".$cs_theme_option['bg_img'].".png";

			}

		}

		else { 

			$bg_img = $cs_theme_option['bg_img_custom'];

		}

	}

	if ( $bg_img <> "" ) {

		echo ' style="background:url('.$bg_img.') ' . $cs_theme_option['bg_repeat'] . ' top ' . $cs_theme_option['bg_position'] . ' ' . $cs_theme_option['bg_attach'].'"';

	}

}

// Main wrapper class function

function cs_wrapper_class(){

	global $cs_theme_option;

	if ( isset($_POST['layout_option']) ) {

		echo $_SESSION['wssess_layout_option'] = $_POST['layout_option'];

	}

	elseif ( isset($_SESSION['wssess_layout_option']) and !empty($_SESSION['wssess_layout_option'])){

		echo $_SESSION['wssess_layout_option'];

	}

	else {

		echo $cs_theme_option['layout_option'];

		$_SESSION['wssess_layout_option']='';

	}

}

// Get Background color Pattren

function cs_bgcolor_pattern(){

	global $cs_theme_option;

	// pattern start

	$pattern = '';

	$bg_color = '';

	if ( isset($_POST['custome_pattern']) ) {

		$_SESSION['wssess_custome_pattern'] = $_POST['custome_pattern'];

		$pattern = get_template_directory_uri()."/images/pattern/pattern".$_SESSION['wssess_custome_pattern'].".png";

	}

	else if ( isset($_SESSION['wssess_custome_pattern']) and !empty($_SESSION['wssess_custome_pattern'])){

		$pattern = get_template_directory_uri()."/images/pattern/pattern".$_SESSION['wssess_custome_pattern'].".png";

	}

	else {

		if (isset($cs_theme_option['custome_pattern']) and $cs_theme_option['custome_pattern'] == "" ) {

			if (isset($cs_theme_option['pattern_img']) and $cs_theme_option['pattern_img'] <> 0 ){

				$pattern = get_template_directory_uri()."/images/pattern/pattern".$cs_theme_option['pattern_img'].".png";

			}

		}

		else { 

			$pattern = $cs_theme_option['custome_pattern'];

		}

	}

	// pattern end

	// bg color start

	if ( isset($_POST['bg_color']) ) {

		$_SESSION['wssess_bg_color'] = $_POST['bg_color'];

		$bg_color = $_SESSION['wssess_bg_color'];

	}

	else if ( isset($_SESSION['wssess_bg_color']) ){

		$bg_color = $_SESSION['wssess_bg_color'];

	}

	else {

		$bg_color = $cs_theme_option['bg_color'];

	}

	// bg color end
	if($bg_color <> '' or $pattern <> ''){
		echo ' style="background:'.$bg_color.' url('.$pattern.')" ';
	}

}





// custom sidebar start

$cs_theme_option = get_option('cs_theme_option');

if ( isset($cs_theme_option['sidebar']) and !empty($cs_theme_option['sidebar'])) {

	foreach ( $cs_theme_option['sidebar'] as $sidebar ){

		//foreach ( $parts as $val ) {

		register_sidebar(array(

			'name' => $sidebar,

			'id' => $sidebar,

			'description' => 'This widget will be displayed on right side of the page.',

			'before_widget' => '<div class="widget %2$s">',

			'after_widget' => '</div>',

			'before_title' => '<header class="cs-heading-title"><h2 class="cs-section-title">',

			'after_title' => '</h2></header>'

		));

	}

}

// custom sidebar end

//footer widget

register_sidebar( array(

	'name' => 'Footer Widget 1',

	'id' => 'footer-widget-1',

	'description' => 'This Widget Show the Content in Footer Area.',

	'before_widget' => '<div class="widget %2$s">',

	'after_widget' => '</div>',

	'before_title' => '<header class="cs-heading-title"><h2 class="cs-section-title">',

	'after_title' => '</h2></header>'

) );

register_sidebar( array(

	'name' => 'Footer Widget 2',

	'id' => 'footer-widget-2',

	'description' => 'This Widget Show the Content in Footer Area.',

	'before_widget' => '<div class="widget %2$s">',

	'after_widget' => '</div>',

	'before_title' => '<header class="cs-heading-title"><h2 class="cs-section-title">',

	'after_title' => '</h2></header>'

) );
//primary widget
register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'Faith' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Main sidebar that appears on the right.', 'Faith' ),
  		'before_widget' => '<div class="widget %2$s">',
 		'after_widget' => '</div>',
 		'before_title' => '<header class="cs-heading-title"><h2 class="cs-section-title">',
 		'after_title' => '</h2></header>'
	) );

If (!function_exists('cs_comment')) :

     /**

     * Template for comments and pingbacks.

     *

     * To override this walker in a child theme without modifying the comments template

     * simply create your own cs_comment(), and that function will be used instead.

     *

     * Used as a callback by wp_list_comments() for displaying the comments.

     *

     */

	function cs_comment( $comment, $args, $depth ) {

	$GLOBALS['comment'] = $comment;

	$args['reply_text'] = 'reply';

 	switch ( $comment->comment_type ) :

		case '' :

	?>

	<li  <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

 		<div class="thumblist" id="comment-<?php comment_ID(); ?>">

        	<ul>

                <li>

                    <figure>

                        <a href="#"><?php echo get_avatar( $comment, 50 ); ?></a>

                    </figure>

                     <div class="text">

                      <header>

                            <?php printf( __( '%s', 'WeStand' ), sprintf( '<h5>%s</h5>', get_comment_author_link() ) ); ?>

                            <?php

                            	/* translators: 1: date, 2: time */

                                printf( __( '<time>%1$s</time>', 'WeStand' ), get_comment_date().' - '.get_comment_time()); ?>

                            <?php if ( $comment->comment_approved == '0' ) : ?>

                                <div class="comment-awaiting-moderation colr"><?php _e( 'Your comment is awaiting moderation.', 'WeStand' ); ?></div>

                            <?php endif; ?>

                      </header>

                      <?php comment_text(); ?>
                      <?php edit_comment_link( __( '(Edit)', 'WeStand' ), ' ' );?>

                            <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>

                    </div>

                </li>

            </ul>

        </div>

     </li>

	<?php

		break;

		case 'pingback'  :

		case 'trackback' :

	?>

	<li class="post pingback">

		<p><?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'WeStand' ), ' ' ); ?></p>

	<?php

		break;

		endswitch;

	}

 	endif;


 /* Under Construction Page */

if ( ! function_exists( 'cs_under_construction' ) ) {

	function cs_under_construction(){ 

		global $cs_theme_option, $post;

		if(isset($post)){ $post_name = $post->post_name;  }else{ $post_name = ''; }

		if ( ($cs_theme_option['under-construction'] == "on" and !(is_user_logged_in())) or $post_name == "pf-under-construction") { 

		?>

		<div id="wrappermain-pix" class="wrapper wrapper_boxed undercunst-box">		

		<div class="bottom_strip">

				<div class="container">

					<div class="logo">

						<?php if(isset($cs_theme_option['showlogo']) and $cs_theme_option['showlogo'] == "on"){ cs_logo(); }?>

					</div>

				</div>

			</div>

		<div id="undercontruction">
		<div id="midarea">

			<?php echo '<p>'.htmlspecialchars_decode($cs_theme_option['under_construction_text']).'</p>';
				 $launch_date = $cs_theme_option['launch_date'];

				 $year = date_i18n("Y", strtotime($launch_date));

				 $month = date_i18n("m", strtotime($launch_date));

				 $month_event_c = date_i18n("M", strtotime($launch_date));							

				 $day = date_i18n("d", strtotime($launch_date));

				 $time_left = date_i18n("H,i,s", strtotime($launch_date));

				

			?>

			<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/frontend/jquery.countdown.js"></script>

			 <script type="text/javascript">

				//Countdown callback function

				jQuery(function () {

					var austDay = new Date();

					austDay = new Date(<?php echo $year; ?>,<?php echo $month; ?>-1,<?php echo $day; ?>);

					jQuery('#defaultCountdown').countdown({until: austDay});
					
					jQuery('#year').text(austDay.getFullYear());

				});



				</script>

			<div class="countdown styled"></div>

			<div class="countdownit">

				<div id="defaultCountdown"></div>

			</div>
			

		</div>

		</div>

			

		<!-- Footer Widgets Start -->

		<footer>

			<!-- Container Start -->

				 <!-- Social Network Start -->

				<?php if($cs_theme_option['socialnetwork'] == "on"){  

					cs_social_network();

				} ?> 

				<!-- Social Network End -->

			<!-- Container End -->

		</footer>

		<!-- Footer Start -->

         <div class="clear"></div>

		</div>

	 <?php die();

	 }

	}
}

// breadcrumb function
if ( ! function_exists( 'cs_breadcrumbs' ) ) { 
	function cs_breadcrumbs() {
		global $wp_query, $cs_theme_option,$post;
		/* === OPTIONS === */
		$text['home']     = 'Home'; // text for the 'Home' link
		$text['category'] = '%s'; // text for a category page
		$text['search']   = '%s'; // text for a search results page
		$text['tag']      = '%s'; // text for a tag page
		$text['author']   = '%s'; // text for an author page
		$text['404']      = 'Error 404'; // text for the 404 page
	
		$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
		$showOnHome  = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$delimiter   = ''; // delimiter between crumbs
		$before      = '<li class="active">'; // tag before the current crumb
		$after       = '</li>'; // tag after the current crumb
		/* === END OF OPTIONS === */
		if($cs_theme_option['trans_switcher'] == "on"){ $current_page = __('Current Page','WeStand');}else{ $current_page = $cs_theme_option['trans_current']; }
		$homeLink = home_url() . '/';
		$linkBefore = '<li>';
		$linkAfter = '</li>';
		$linkAttr = '';
		$link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;
		$linkhome = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;
	
		if (is_home() || is_front_page()) {
	
			if ($showOnHome == "1") echo '<div class="breadcrumbs"><ul>'.$before.'<a href="' . $homeLink . '">' . $text['home'] . '</a>'.$after.'</ul></div>';
	
		} else {
			echo '<div class="breadcrumbs"><ul>' . sprintf($linkhome, $homeLink, $text['home']) . $delimiter;
			if ( is_category() ) {
				$thisCat = get_category(get_query_var('cat'), false);
				if ($thisCat->parent != 0) {
					$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
					$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
					$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
					echo $cats;
				}
				echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;
			} elseif ( is_search() ) {
				echo $before . sprintf($text['search'], get_search_query()) . $after;
			} elseif ( is_day() ) {
				echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
				echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
				echo $before . get_the_time('d') . $after;
			} elseif ( is_month() ) {
				echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
				echo $before . get_the_time('F') . $after;
			} elseif ( is_year() ) {
				echo $before . get_the_time('Y') . $after;
			} elseif ( is_single() && !is_attachment() ) {
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
					//if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
					if ($showCurrent == 1) echo $delimiter . $before . $current_page . $after;
				} else {
					$cat = get_the_category(); $cat = $cat[0];
					$cats = get_category_parents($cat, TRUE, $delimiter);
					if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
					$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
					$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
					echo $cats;
					
					//if ($showCurrent == 1) echo $before . substr(get_the_title(),0,35) . $after;
					if ($showCurrent == 1) echo $before . $current_page . $after;
				}
			} elseif ( !is_single() && !is_page() && get_post_type() <> '' && get_post_type() != 'post' && get_post_type() <> 'events' && !is_404() ) {
					$post_type = get_post_type_object(get_post_type());
					echo $before . $post_type->labels->singular_name . $after;
			} elseif (isset($wp_query->query_vars['taxonomy']) && !empty($wp_query->query_vars['taxonomy'])){
				$taxonomy = $taxonomy_category = '';
				$taxonomy = $wp_query->query_vars['taxonomy'];
				echo $before . $wp_query->query_vars[$taxonomy] . $after;

			}elseif ( is_page() && !$post->post_parent ) {
				if ($showCurrent == 1) echo $before . get_the_title() . $after;
	
			} elseif ( is_page() && $post->post_parent ) {
				$parent_id  = $post->post_parent;
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
					$parent_id  = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				for ($i = 0; $i < count($breadcrumbs); $i++) {
					echo $breadcrumbs[$i];
					if ($i != count($breadcrumbs)-1) echo $delimiter;
				}
				if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
	
			} elseif ( is_tag() ) {
				echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
	
			} elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata($author);
				echo $before . sprintf($text['author'], $userdata->display_name) . $after;
	
			} elseif ( is_404() ) {
				echo $before . $text['404'] . $after;
			}
			
			//echo "<pre>"; print_r($wp_query->query_vars); echo "</pre>";
			if ( get_query_var('paged') ) {
				// if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
				// echo __('Page') . ' ' . get_query_var('paged');
				// if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
			}
			echo '</ul></div>';
	
		}
	}
}