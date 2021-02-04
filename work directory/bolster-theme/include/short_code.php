<?php

// adding mce custom button for short codes start
class ShortcodesEditorSelector {

    var $buttonName = 'shortcode';

    function addSelector() {
        add_filter('mce_external_plugins', array($this, 'registerTmcePlugin'));
        add_filter('mce_buttons', array($this, 'registerButton'));
    }

    function registerButton($buttons) {
        array_push($buttons, "separator", $this->buttonName);
        return $buttons;
    }

    function registerTmcePlugin($plugin_array) {
        $plugin_array[$this->buttonName] = get_template_directory_uri() . '/include/mce_editor_plugin.js.php';
        //var_dump($plugin_array);
        return $plugin_array;
    }

}

if (!isset($shortcodesES)) {
    $shortcodesES = new ShortcodesEditorSelector();
    add_action('admin_head', array($shortcodesES, 'addSelector'));
}

// adding mce custom button for short codes end
//adding shortcode start 
// adding toggle start
function cs_shortcode_pb_toggle($atts, $content = "") {
    global $toggle_counter;
    $toggle_counter++;
	$active = "";
    if (!isset($atts['style'])){ $atts['style'] = '';}
    if (!isset($atts['title'])){ $atts['title'] = '';}
    if ( $atts["active"] == "yes" ){ $active = "in";}
    $html = '<a class="collapsed" data-toggle="collapse" data-target="#toggle' . $toggle_counter . '">' . $atts["title"] . '</a>';
    $html .= '<div class="togglebox '.$active.' collapse" id="toggle' . $toggle_counter . '">' . $content . '</div>';
    $html = '<div class="toggle-sectn">' . $html . '</div>';
    return do_shortcode($html) . '<div class="clear"></div>';
}

add_shortcode('toggle', 'cs_shortcode_pb_toggle');

// adding toggle end
// adding tabs start
function cs_shortcode_pb_tabs($atts, $content = "") {
    global $cs_node, $tab_counter;
    if (!isset($atts['style'])){ $atts['style'] = '';}
    $tab_counter++;
    $content = str_replace("&Acirc;&nbsp;", "", htmlentities($content));
	$content = html_entity_decode($content);
	$content = htmlspecialchars($content, ENT_NOQUOTES, "UTF-8");
    $content = str_replace("[tab_item", "<tab_item", $content);
    $content = str_replace("[/tab_item]", "</tab_item>", $content);
    $content = str_replace('tabs="tabs"]', ">", $content);
    $content = str_replace("<br />", "", $content);
    $content = str_replace("<p>", "", $content);
    $content = str_replace("</p>", "", $content);
    $content = "<tab>" . $content . "</tab>";

	$cs_node = new stdClass();
	$cs_node->tabs_element_size = "";
	$cs_node->tabs_content = $content;
	$cs_node->tabs_style = $atts['style'];
    return cs_tabs_page();
}
add_shortcode('tab', 'cs_shortcode_pb_tabs');

// adding tabs end
// adding accordion start
function cs_shortcode_pb_accordion($atts, $content = "") {
    global $cs_node, $acc_counter;
    $content = str_replace("&Acirc;&nbsp;", "", htmlentities($content));
	$content = html_entity_decode($content);
	$content = htmlspecialchars($content, ENT_NOQUOTES, "UTF-8");
    $content = str_replace("[accordion_item", "<accordion_item", $content);
    $content = str_replace("[/accordion_item]", "</accordion_item>", $content);
    $content = str_replace('accordion="accordion"]', ">", $content);
    $content = str_replace("<br />", "", $content);
    $content = str_replace("<p>", "", $content);
    $content = str_replace("</p>", "", $content);
    $content = "<accordion>" . $content . "</accordion>";
	if (!isset($atts['type'])){ $atts['type'] = 'simple';}

	$cs_node = new stdClass();
	$cs_node->accordion_element_size = "";
	$cs_node->accordion_content = $content;
	$cs_node->type = $atts['type'];
    return cs_accordions_page();
}
add_shortcode('accordion', 'cs_shortcode_pb_accordion');

// adding accordion end

// adding quote start
function cs_shortcode_pb_quote($atts, $content = "") {
	global $cs_node;
	if (!isset($atts['color'])){ $atts['color'] = '';}
	if (!isset($atts['align'])){ $atts['align'] = '';}
	$cs_node = new stdClass();
	$cs_node->quote_element_size = '';
	$cs_node->quote_text_color = $atts['color'];
	$cs_node->quote_align = $atts['align'];
	$cs_node->quote_content = $content;
    return cs_quote_page();
}

add_shortcode('quote', 'cs_shortcode_pb_quote');

// adding quote end
// adding button start
function cs_shortcode_pb_button($atts, $content = "") {
    if (!isset($atts['src'])){ $atts['src'] = '';}
    if (!isset($atts['color'])){ $atts['color'] = '';}
    if (!isset($atts['background'])){  $atts['background'] = '';}
    if (!isset($atts['style'])){  $atts['style'] = '';}
    if (!isset($atts['type'])){  $atts['type'] = '';}
    if (!isset($atts['target'])){  $atts['target'] = '';}else{ $atts['target'] = '_self'; }
    
    $html = '<a href="' . $atts['src'] . '" class="' . $atts['style']. '-btn ' . $atts['type'] . '" target="' . $atts['target'] . '" style=" cursor:pointer; color:' . $atts['color'] . ' ;background-color:' . $atts['background'] . '">' . $content . '</a>';
    $html = '<div class="button">'.$html.'</div>';
    return do_shortcode($html);
}

add_shortcode('button', 'cs_shortcode_pb_button');

// adding button end
// adding column start
function cs_shortcode_pb_column($atts, $content = "") {
    if (!isset($atts['size'])){ $atts['size'] = '';}
    list($top, $bottom) = explode('/', $atts['size']);
    $width = $top / $bottom * 100;
    $html = '<div class="shortgrid" style="width:' . $width . '%">'.$content.'</div>';
    return do_shortcode(htmlspecialchars_decode($html));
}

add_shortcode('column', 'cs_shortcode_pb_column');

// adding column end
// adding dropcap start
function cs_shortcode_pb_dropcap($atts, $content = "") {
	global $cs_node;
	$cs_node = new stdClass();
	$cs_node->dropcap_element_size = '';
	$cs_node->dropcap_content = $content;
    return cs_dropcap_page();
}

add_shortcode('dropcap', 'cs_shortcode_pb_dropcap');

// adding dropcap end
// adding message_box start

function cs_shortcode_pb_message_box($atts, $content = "") {
	if (!isset($atts['style'])){ $atts['style'] = '';}
	if (!isset($atts['type'])){ $atts['type'] = 'info';}
    if (!isset($atts['background'])){ $atts['background'] = '';}
    if (!isset($atts['color'])){ $atts['color'] = '';}
    if (!isset($atts['border_color'])){ $atts['border_color'] = '';}
	if (!isset($atts['box_shadow_color'])){ $atts['box_shadow_color'] = '';}
    if (!isset($atts['title'])){ $atts['title'] = '';}
    if (!isset($atts['align'])){ $atts['align'] = '';}
    if (!isset($atts['icon'])){ $atts['icon'] = '';}
    if (!isset($atts['close'])){ $atts['close'] = '';}
	$shadow_value = "";
	if(isset($atts['box_shadow_color']) and $atts['box_shadow_color'] <> ""){
		$shadow_value = "0px 0px 0px 5px " . $atts['box_shadow_color'] . " inset";
	}
    $html = "";
	$class = "";
	$round_class = "";
    $html .= '<div class="messagebox alert alert-info ' . $atts["type"] . '" style="text-align:' . $atts["align"] . '; background:' . $atts["background"] . '; color:' . $atts["color"] . '; border:1px solid ' . $atts["border_color"] . '; box-shadow:'.$shadow_value.';">';
    if (isset($atts['close']) && $atts['close']=='yes'){
        $html .= '<button type="button" class="close" data-dismiss="alert"><em class="fa fa-times-circle"></em></button>';
    }
	if (isset($atts['icon']) and $atts['icon'] <> ""){
		if(isset($atts['style']) and $atts['style'] <> "2"){
			$class = " round_smal";
		}else{
			$class = "";
		}
		if(isset($atts['style']) and $atts['style'] <> "3"){
			$round_class = " round";
		}else{
			$round_class = "";
		}
		$html .= '<em class="fa ' . $atts["icon"] . $round_class . $class . '"></em>';
	}
    if(isset($atts["title"]) && $atts["title"]<>''){
         $html .= '<div class="massegbox_text"><h4 class="colr">' . $atts["title"] . '</h4></div>';
    }
    if(isset($content) && $content<>''){
        $html .= $content;
    }
        $html .= '</div>';
    return do_shortcode($html) . '<div class="clear"></div>';
}
add_shortcode('message_box', 'cs_shortcode_pb_message_box');

// adding message_box end

// adding list start
function cs_shortcode_pb_list($atts, $content = "") {
    if (!isset($atts['type'])){ $atts['type'] = '';}
    if (!isset($atts['icon'])){ $atts['icon'] = '';}
    $content = "<ul class='".$atts["type"]."'>" . $content . "</ul>";
    if(isset($atts['icon']) && $atts['icon']<>''){
        $content = str_replace("[list_item]", "<li><em class='fa ".$atts['icon']."'></em>", $content);
    } else {
        $content = str_replace("[list_item]", "<li>", $content);
    }
    $content = str_replace("[/list_item]", "</li>", $content);
    $content = str_replace("<br />", "", $content);
    $html = '<div class="list_styles">' . $content . '</div>';
    return do_shortcode($html) . '<div class="clear"></div>';
}

add_shortcode('list', 'cs_shortcode_pb_list');

// adding list end
// adding divider start 
//[divider style="1" backtotop="yes/no"]
function cs_shortcode_pb_divider($atts) {
	global $cs_node;
	if (!isset($atts['style'])){ $atts['style'] = '';}
	if (!isset($atts['top_margin'])){ $atts['top_margin'] = '';}
	if (!isset($atts['bottom_margin'])){ $atts['bottom_margin'] = '';}
	$cs_node = new stdClass();
	$cs_node->divider_element_size = '';
	$cs_node->divider_style = $atts['style'];
	$cs_node->divider_mrg_top = $atts['top_margin'];
	$cs_node->divider_mrg_bottom = $atts['bottom_margin'];
    return cs_divider_page();
}

add_shortcode('divider', 'cs_shortcode_pb_divider');

// adding divider end
// adding table start
function cs_shortcode_pb_table($atts, $content = "") {
    if (!isset($atts['color'])){ $atts['color'] = '';}
    $table_class = "table_" . str_replace("#", "", $atts["color"]);
    $content = "<table class='table  table-condensed " . $table_class . "'>" . $content . "</table>";
    $content = str_replace("[thead]", "<thead>", $content);
    $content = str_replace("[/thead]", "</thead>", $content);
    $content = str_replace("[tr]", "<tr>", $content);
    $content = str_replace("[/tr]", "</tr>", $content);
    $content = str_replace("[th]", "<th>", $content);
    $content = str_replace("[/th]", "</th>", $content);
    $content = str_replace("[tbody]", "<tbody>", $content);
    $content = str_replace("[/tbody]", "</tbody>", $content);
    $content = str_replace("[td]", "<td>", $content);
    $content = str_replace("[/td]", "</td>", $content);
    $content = str_replace("<br />", "", $content);
    //$content = do_shortcode(htmlspecialchars_decode($content));
    $html = '
			<style>
			.' . $table_class . ' td {border: 1px solid ' . $atts["color"] . ';}
			.' . $table_class . ' th {border: 1px solid ' . $atts["color"] . ';}
			.' . $table_class . ' thead {background:' . $atts["color"] . ';}
			</style>
		';
    $html .= '<div class="tables-code">' . $content . '</div>';
    return do_shortcode(htmlspecialchars_decode($html)) . '<div class="clear"></div>';
}
add_shortcode('table', 'cs_shortcode_pb_table');

// adding table end

// adding hightlight start
function cs_shortcode_pb_hightlight($atts, $content = "") {
        if (!isset($atts['background'])){ $atts['background'] = '';}
        if (!isset($atts['color'])){ $atts['color'] = '';}
	$html = '<span style="background:'.$atts["background"].' !important; color:'.$atts["color"].';" class="highlights">'.$content.'</span>';
	return $html;
}
add_shortcode('hightlight', 'cs_shortcode_pb_hightlight');
// adding hightlight end

// adding heading start
function cs_shortcode_pb_heading($atts, $content = "") {
        if (!isset($atts['size'])){ $atts['size'] = '';}
        if (!isset($atts['color'])){ $atts['color'] = '';}
	$html = '<h'.$atts["size"].' style="color:'.$atts["color"].';">'.$content.'</h'.$atts["size"].'>';
	return $html;
}
add_shortcode('heading', 'cs_shortcode_pb_heading');
// adding heading end

// Coloumn Clear
function cs_shortcode_pb_coloumnclear($atts, $content = "") {
	return $html = '<div class="clearcolumn">&nbsp;</div>';
}
add_shortcode('coloumnclear', 'cs_shortcode_pb_coloumnclear');
// Coloumn Clear end

// adding image start
function cs_shortcode_pb_image($atts, $content = "") {
	global $cs_node;
	if (!isset($atts['style'])){ $atts['style'] = '';}
	if (!isset($atts['width'])){ $atts['width'] = '';}
	if (!isset($atts['height'])){ $atts['height'] = '';}
	if (!isset($atts['lightbox'])){ $atts['lightbox'] = '';}
	if (!isset($atts['source'])){ $atts['source'] = '';}
	if (!isset($atts['caption'])){ $atts['caption'] = '';}
	$cs_node = new stdClass();
	$cs_node->image_element_size = '';
	$cs_node->image_style = $atts['style'];
	$cs_node->image_width = $atts['width'];
	$cs_node->image_height = $atts['height'];
	$cs_node->image_lightbox = $atts['lightbox'];
	$cs_node->image_source = $atts['source'];
	$cs_node->image_caption = $atts['caption'];
	return cs_image_page();
}
add_shortcode('image-frame', 'cs_shortcode_pb_image');
// adding image end

// adding icon start
function cs_shortcode_pb_icon($atts, $content = "") {
        if (!isset($atts['border'])){ $atts['border'] = '';}
        if (!isset($atts['color'])){ $atts['color'] = '';}
        if (!isset($atts['bgcolor'])){ $atts['bgcolor'] = '';}
        if (!isset($atts['type'])){ $atts['type'] = '';}
        if (!isset($atts['class'])){ $atts['class'] = '';}
	$icon_border = "";
        if ( $atts["border"] == "yes" ){ $icon_border = "fa fa-border";}
	$html = '<em class="fa '.$atts["class"].' '.$atts["type"].' '.$atts["size"].' '.$icon_border.'" style="color:'.$atts["color"].'; background-color:'.$atts["bgcolor"].'"></em>';
	return $html;
}
add_shortcode('icon', 'cs_shortcode_pb_icon');
// adding icon end

// adding video start
function cs_shortcode_pb_video($atts, $content = "") {
	global $cs_node;
	if (!isset($atts['url'])){ $atts['url'] = '';}
	if (!isset($atts['width'])){ $atts['width'] = '';}
	if (!isset($atts['height'])){ $atts['height'] = '';}
	if (!isset($atts['name'])){ $atts['name'] = '';}
	$cs_node = new stdClass();
	$cs_node->video_element_size= '';
	$cs_node->video_url = $atts['url'];
	$cs_node->image_source = $atts['url'];
	$cs_node->video_width = $atts['width'];
	$cs_node->video_height = $atts['height'];
	$cs_node->video_name = $atts['name'];
    return cs_video_page();
}
add_shortcode('video-item', 'cs_shortcode_pb_video');
// adding video end
// adding map shortcode
function cs_shortcode_pb_map($atts, $content = "") {
	global $cs_node, $counter_node;
	$counter_node++;
	
	if ( !isset($atts['height']) ) $atts['height'] = '';
	if ( !isset($atts['latitude']) ) $atts['latitude'] = '';
	if ( !isset($atts['longitude']) ) $atts['longitude'] = '';
	if ( !isset($atts['zoom']) ) $atts['zoom'] = '';
	if ( !isset($atts['type']) ) $atts['type'] = '';
	if ( !isset($atts['info_text']) ) $atts['info_text'] = '';
	if ( !isset($atts['info_width']) ) $atts['info_width'] = '';
	if ( !isset($atts['info_height']) ) $atts['info_height'] = '';
	if ( !isset($atts['marker_icon_url']) ) $atts['marker_icon_url'] = '';
	if ( !isset($atts['marker']) ) $atts['marker'] = '';
	if ( !isset($atts['draggable']) ) $atts['draggable'] = '';
	if ( !isset($atts['disable_controls']) ) $atts['disable_controls'] = '';
	if ( !isset($atts['scrollwheel']) ) $atts['scrollwheel'] = '';
	if ( !isset($atts['map_view']) ) $atts['map_view'] = 'content';
	
	$cs_node = new stdClass();
	$cs_node->map_title = '';
	$cs_node->map_element_size = '';
	$cs_node->map_height = $atts['height'];
	$cs_node->map_lat = $atts['latitude'];
	$cs_node->map_lon = $atts['longitude'];
	$cs_node->map_zoom = $atts['zoom'];
	$cs_node->map_type = $atts['type'];
	$cs_node->map_info = $atts['info_text'];
	$cs_node->map_info_width = $atts['info_width'];
	$cs_node->map_info_height = $atts['info_height'];
	$cs_node->map_marker_icon = $atts['marker_icon_url'];
	$cs_node->map_show_marker = $atts['marker'];
	$cs_node->map_draggable = $atts['draggable'];
	$cs_node->map_controls = $atts['disable_controls'];
	$cs_node->map_scrollwheel = $atts['scrollwheel'];
	$cs_node->map_view = $atts['map_view'];
	return cs_map_page();
}
add_shortcode('map', 'cs_shortcode_pb_map');
// adding map end
// adding code start
function cs_shortcode_pb_code($atts, $content = "") {
    $content = str_replace("<br />", "", $content);
    if (!isset($atts['title']) and $atts['title'] == ""){ $title = '';}else{ $title ='<header class="widget_tittle"><h6 class="colr section-title cs-heading-color">'.$atts["title"].'</h6></header>';}
    $html = $title.'<div class="code-element"><pre>' . $content . '</pre></div>';
    return $html . '<div class="clear"></div>';
}
add_shortcode('code', 'cs_shortcode_pb_code');
// adding code end
//Testimonials Shortcode
function cs_shortcode_pb_testimonials($atts, $content = "") {
    global $testimonial_counter;
    $testimonial_counter++;
    if (!isset($atts['type'])){ $atts['type'] = '';}
    if (!isset($atts['show_nav'])){ $atts['show_nav'] = 'no';}
    if (!isset($atts["autoplay"])){ $atts['autoplay'] = 'false';}
    if (!isset($atts['delay'])){ $atts['delay'] = '800';}
    $content = str_replace("&Acirc;&nbsp;", "", htmlentities($content));
	$content = html_entity_decode($content);
	$content = htmlspecialchars($content, ENT_NOQUOTES, "UTF-8");
    $content = str_replace("[testimonial_item", "<testimonial_item", $content);
    $content = str_replace("[/testimonial_item]", "</testimonial_item>", $content);
    $content = str_replace('testimonial="testimonial"]', ">", $content);
    $content = str_replace("<br />", "", $content);
    $content = str_replace("<p>", "", $content);
    $content = str_replace("</p>", "", $content);
    $content = "<testimonials>" . $content . "</testimonials>";
    $autoplay=$atts["autoplay"];
    $delay=$atts["delay"];
    $show_nav_class='';
	$show_nav = 'false';
		if ( $atts['type'] == "avatar" ){
	        $show_nav_class='testimonial-slide';
		}
		else {
	        $show_nav_class='testimonial-slide  no-image';
		}
    if (isset($atts['show_nav']) && strtolower($atts['show_nav'])=='yes'){
        $show_nav = 'true';
        $nav_class=' show-nav-testimonial';
		$show_nav_class .=$nav_class;
    } else {
		$nav_class=' no-nav-testimonial';
		$show_nav_class .=$nav_class;
	}
    $html = "";

    $cs_xmlObject = simplexml_load_string($content);
    $testimonial_count = 0;
    foreach ($cs_xmlObject as $cs_node) {
        $testimonial_count++;
       if (!isset($cs_node["image"])){ $cs_node["image"] = '';}
       if (!isset($cs_node["name"])){ $cs_node["name"] = '';}
       if (!isset($cs_node["job"])){ $cs_node["job"] = '';}
       $html .= '<div class="testimonial-shortcode"><div class="testimonial-text"><span class="fa-stack fa-lg colr"> <em class="fa fa-circle fa-stack-2x"></em> <em class="fa fa-quote-left fa-stack-1x fa-inverse"></em></span>';
	   $html .= '<div class="desc"><p>'.html_entity_decode($cs_node).'</p></div></div>';
		$html .= '<div class="testimonial-author">';
		if(isset($cs_node["image"]) && $cs_node["image"]<>''){
          $html .= '<img src="' . $cs_node["image"]  . '" alt="' . $cs_node["name"]  . '" width="50">'; 
		}
		$html .= '<p>';
		if(isset($cs_node["name"]) && $cs_node["name"]<>''){
			$html .= '<strong>'.$cs_node["name"].'</strong><br>';
		}
		if(isset($cs_node["job"]) && $cs_node["job"]<>''){
			$html .= '<span>-'.$cs_node["job"].'</span>';
		}
		$html .= '</p></div></div>';
    }

    $html = '<div class="'.$show_nav_class.'">' . $html . '</div>';
    return do_shortcode($html) . '<div class="clear"></div>';
}
add_shortcode('testimonials', 'cs_shortcode_pb_testimonials');
//Testimonials Shortcode end