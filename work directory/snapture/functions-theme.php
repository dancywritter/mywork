<?php
// Filter shortcode in text areas
if ( ! function_exists( 'cs_textarea_filter' ) ) { 
	function cs_textarea_filter($content=''){
		return do_shortcode($content);
	}
}
// Date differance
function cs_dateDiff($start, $end) {
	  $start_ts = strtotime($start);
	  $end_ts = strtotime($end);
	  $diff = $end_ts - $start_ts;
	  return round($diff / 86400);
}
// porfolio addtionla information list on detail page
function cs_portfolio_other_info($cs_xmlObject){
	foreach ( $cs_xmlObject as $other_info ){
	  if ( $other_info->getName() == "other_info" ) {
		  $port_other_info_title = $other_info->port_other_info_title;
		  $port_other_info_desc = $other_info->port_other_info_desc;
		  $port_other_info_icon = $other_info->port_other_info_icon;
		  echo '<li><span>'.$port_other_info_title.'</span><p>'.do_shortcode($port_other_info_desc).'</p></li>';
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
			echo "col-md-9";
		}
		else if ( $layout <> '' and $layout == 'left' ) {
			echo "col-md-9";
		}
		else if ( $layout <> '' and $layout == 'both' ) {
			echo "col-md-6";
		}
		else {
			echo "col-md-12";
		}
	}	
}

// Portfolio Gallery 
if ( ! function_exists( 'cs_portfolio_gallery' ) ) {
	function cs_portfolio_gallery($width,$height,$gallery_id,$gallery_type){
		$cs_meta_gallery_options = get_post_meta($gallery_id, "cs_meta_gallery_options", true);
		if ( $cs_meta_gallery_options <> "" ) {
			$xmlObject = new SimpleXMLElement($cs_meta_gallery_options);
			if($gallery_type == "Simple Gallery"){ ?>
 				<div class="detail_images">
					<?php
						for ( $i =0; $i < count($xmlObject); $i++ ) {
						$path = $xmlObject->gallery[$i]->path;
						 $image_url = cs_attachment_image_src($path, $width, $height);
						$image_url_full = cs_attachment_image_src($path, 0, 0);
					?>
                    <figure>
						<img src="<?php echo $image_url; ?>" alt="">
                    </figure>
					 <?php }?>
				</div>
 			<?php
			}else{
			$cs_meta_slider_options = get_post_meta($gallery_id, "cs_meta_gallery_options", true); 
			$counter = 1;
			$cs_xmlObject_flex = new SimpleXMLElement($cs_meta_slider_options);
			?>
            <div class="detail_images">
                            <div class="device">
                                <div class="slide-arrow">
                                    <h3><?php echo get_the_title((int)$gallery_id); ?></h3>
                                    <div class="click-sec">
                                        <a class="arrow-left" href="#"><i class="fa fa-angle-left"></i></a> 
                                        <a class="arrow-right" href="#"><i class="fa fa-angle-right"></i></a>
                                    </div>
                                </div>
                                <div class="swiper-container">
                                      <div class="swiper-wrapper">
                                      <?php 
										foreach ( $cs_xmlObject_flex->children() as $as_node ){
											$image_url = cs_attachment_image_src($as_node->path,$width,$height); 
											if($image_url <> ''){
											?>
                                        <div class="swiper-slide">
                                            <article>
                                                <figure>
                                                    <a><img src="<?php echo $image_url;?>" alt=""></a>
                                                    <figcaption>
                                                        <a data-rel="prettyPhoto" href="<?php echo $image_url;?>" data-title="" rel="prettyPhoto"><i class="fa fa-plus hovicon effect-1 sub-b"></i></a>
                                                    </figcaption>
                                                </figure>
                                            </article>
                                        </div>
                                        <?php }}?>
                                      </div>
                                </div>
                                <div class="pagination"></div>
                          </div>
                          <?php cs_enqueue_swiper(); ?>
                            <script>
                              jQuery(document).ready(function($) {
                                  var mySwiper = new Swiper('.swiper-container', {
                                    loop: false,
                                    grabCursor: true
                                  })
                                  $('.arrow-left').on('click', function(e) {
                                    e.preventDefault()
                                    mySwiper.swipePrev()
                                  })
                                  $('.arrow-right').on('click', function(e) {
                                    e.preventDefault()
                                    mySwiper.swipeNext()
                                  })
                                });
                          </script>
                        </div>
				
			<?php
				}
			}else{
		}
	}
}

// content class
if ( ! function_exists( 'cs_meta_content_class' ) ) {
	function cs_meta_content_class(){
		global $cs_meta_page,$video_width;

		foreach ( $cs_meta_page->children() as $cs_node ) {
                    //if ( $cs_node->getName() == "blog" && $cs_node->cs_blog_view == 'large_view' ) {
						//return 'col-lg-12 col-md-12 col-sm-12';
					//}
				}
		if ( $cs_meta_page->sidebar_layout->cs_layout == '' or $cs_meta_page->sidebar_layout->cs_layout == 'none' ) {
			$content_class = "col-lg-12 col-md-12";
		}
		else if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout == 'right' ) {
			$content_class = "col-lg-9 col-md-9";
		}
		else if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout == 'left' ) {
			$content_class = "col-lg-9 col-md-9";
		}
		else{
			$content_class = "col-lg-12 col-md-12";
		}
		return $content_class;
	}
}
// custom pagination start
if ( ! function_exists( 'cs_pagination' ) ) {
	function cs_pagination($total_records, $per_page, $qrystr = '') {
		global $cs_theme_option;
		/////////// Trans for Prev /////////
		$cs_prev_page = "";
		//if($cs_theme_option['trans_switcher'] == "on"){ $cs_prev_page = __('Previous','Snapture');}else{ $cs_prev_page = $cs_theme_option['trans_other_prev']; }
		/////////// Trans for Prev end /////////
		
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
		$html .="<nav class='pagination'><ul>";
		if ($_GET['page_id_all'] > 1)
			
			$html .= "<li class='previs'><a href='?page_id_all=" . ($_GET['page_id_all'] - 1) . "$qrystr' ><i class='fa fa-angle-left'></i></a></li>";
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
			$html .= "<li class='next'><a href='?page_id_all=" . ($_GET['page_id_all'] + 1) . "$qrystr' >".__('Next','Snapture')."</a></li>";
			$html .="</ul></nav>";
		return $html;
	}
}
/* Display navigation to next/previous for single.php */
if ( ! function_exists( 'cs_next_prev_post' ) ) { 
	function cs_next_prev_post(){
	global $post;
	posts_nav_link();
	//wp_link_pages( $args );
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
    	<div class="post-sec"> 
 			<?php 
				previous_post_link( '%link', '<i class="fa fa-angle-left"></i>' ); 
			 	next_post_link( '%link','<i class="fa fa-angle-right"></i>' );
			?>
 
		</div>
	 
	<?php
	}
}
// next and prev post end

//	Add Featured/sticky text/icon for sticky posts.
if ( ! function_exists( 'cs_featured()' ) ) {
	function cs_featured(){
		global $cs_transwitch,$cs_theme_option, $post;
		if ( is_sticky() ){ ?>
       	 <li><i class="fa fa-thumb-tack"></i><a class="colrhvr"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Sticky Post','Snapture');}else{ echo $cs_theme_option['trans_featured']; }?></a></li>
		<?php
		}
	}
}

//Add classes according to diffrent view for blog post type
function cs_blog_classes($blog_view =""){
 	if($blog_view == 'blog-large'){ 
		echo 'postlist blog';
	}elseif($blog_view == 'blog-medium'){ 
		echo 'postlist blog';
	}
	else{ 
		echo 'blog'; 
	}
}
// rating function

// Dropcap shortchode with first letter in caps
if ( ! function_exists( 'cs_dropcap_page' ) ) {
	function cs_dropcap_page(){
		global $cs_node;
		$html = '';
			$html .= '<div class="dropcap">';
				$html .= $cs_node->dropcap_content;
			$html .= '</div>';
		return $html;
	}
}

// block quote short code
if ( ! function_exists( 'cs_quote_page' ) ) {
	function cs_quote_page(){
		global $cs_node;
 			$html ='<div class="qoute"><blockquote class="blockquote" style=" text-align:' .$cs_node->quote_align. '; color:' . $cs_node->quote_text_color . '">
			' . $cs_node->quote_content . '
			</blockquote></div>';
 		return $html;
	}
}

// video short code
if ( ! function_exists( 'cs_video_page' ) ) {
	function cs_video_page(){
		global $cs_node;
		$html = '';
		cs_enqueue_gallery_style_script();
		$href = '';
		$html = '';
		$data_rel = 'data-rel="prettyPhoto[gallery1]"';
		
		$html .= '<figure class="widget-box viewme">';
		$html .= '<a href="'.$cs_node->video_url.'" title="'.$cs_node->video_name.'" '.$data_rel.'>';
		$html .= '<em class="fa fa-play"  style="float:left; width:'.$cs_node->video_width.'px; height:'.$cs_node->video_height.'px"></em>';
			//$html .= '<img src="http://irfan/Snapture/wp-content/uploads/2013/11/img-f-gigs.jpg" style="float:left; width:'.$cs_node->video_width.'px; height:'.$cs_node->video_height.'px" alt="" />';
		$html .= '</a>';
			//$html .= wp_oembed_get( $cs_node->video_url, array('width'=>$cs_node->video_width, 'height'=>$cs_node->video_height) );
		//$html .= '<figcaption>'.$cs_node->video_name.'</figcaption>';
		$html .= '</figure>';
		return $html;
	}
}
// map shortcode with various options
if ( ! function_exists( 'cs_map_page' ) ) {
	function cs_map_page(){
		global $cs_node, $counter_node;
		if ( !isset($cs_node->map_lat) or $cs_node->map_lat == "" ) { $cs_node->map_lat = 0; }
		if ( !isset($cs_node->map_lon) or $cs_node->map_lon == "" ) { $cs_node->map_lon = 0; }
		if ( !isset($cs_node->map_zoom) or $cs_node->map_zoom == "" ) { $cs_node->map_zoom = 11; }
		if ( !isset($cs_node->map_info_width) or $cs_node->map_info_width == "" ) { $cs_node->map_info_width = 5000; }
		if ( !isset($cs_node->map_info_height) or $cs_node->map_info_height == "" ) { $cs_node->map_info_height = 100; }
		if ( !isset($cs_node->map_show_marker) or $cs_node->map_show_marker == "" ) { $cs_node->map_show_marker = 'true'; }
		if ( !isset($cs_node->map_controls) or $cs_node->map_controls == "" ) { $cs_node->map_controls = 'false'; }
		if ( !isset($cs_node->map_scrollwheel) or $cs_node->map_scrollwheel == "" ) { $cs_node->map_scrollwheel = 'true'; }
		if ( !isset($cs_node->map_draggable) or $cs_node->map_draggable == "" )  { $cs_node->map_draggable = 'true'; }
		if ( !isset($cs_node->map_type) or $cs_node->map_type == "" ) { $cs_node->map_type = 'ROADMAP'; }
		if ( !isset($cs_node->map_info)) { $cs_node->map_info = ''; }
		if( !isset($cs_node->map_marker_icon)){ $cs_node->map_marker_icon = ''; }
		if( !isset($cs_node->map_title)){ $cs_node->map_title ='';}
		if( !isset($cs_node->map_element_size) or $cs_node->map_element_size == ""){ $cs_node->map_element_size ='default';}
		if( !isset($cs_node->map_height) || trim($cs_node->map_height) <> '' || empty($cs_node->map_height)){ $cs_node->map_height ='450';}
	 
		$map_show_marker = '';
		if ( $cs_node->map_show_marker == "true" ) { 
			$map_show_marker = " var marker = new google.maps.Marker({
						position: myLatlng,
						map: map,
						title: '',
						icon: '".$cs_node->map_marker_icon."',
						shadow:''
					});
			";
		}
	
		//wp_enqueue_script('googleapis', 'https://maps.googleapis.com/maps/api/js?sensor=true', '', '', true);
		$html = '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>';
		$html .= '<div class="element_size_'.$cs_node->map_element_size.' cs-map cs-map-width  cs-full-width cs-map'.$counter_node.'" style=" height:0px; float: left; overflow:hidden">';
			if($cs_node->map_title <> ''){$html .= '<h2 class="cs-heading-color section-title">'.$cs_node->map_title.'</h2>'; }
			$html .= '<div class="mapcode iframe mapsection gmapwrapp" id="map_canvas'.$counter_node.'" style="height:'.$cs_node->map_height.'px; float: left; width: 100%;overflow:hidden"> </div>';
		$html .= '</div>';
		//mapTypeId: google.maps.MapTypeId.".$cs_node->map_type." ,
		$html .= "<script type='text/javascript'>
					jQuery(window).load(function(){
						setTimeout(function(){
						jQuery('.cs-map".$counter_node."').animate({
							'height':'".$cs_node->map_height."'
						},400)
						},400)
					})
					function initialize() {
						var styles = [
							{
							  stylers: [
								{ hue: '#000000' },
								{ saturation: -100 }
							  ]
							},{
							  featureType: 'road',
							  elementType: 'geometry',
							  stylers: [
								{ lightness: -40 },
								{ visibility: 'simplified' }
							  ]
							},{
							  featureType: 'road',
							  elementType: 'labels',
							  stylers: [
								{ visibility: 'on' }
							  ]
							}
						  ];
		var styledMap = new google.maps.StyledMapType(styles,
		{name: 'Styled Map'});
						var myLatlng = new google.maps.LatLng(".$cs_node->map_lat.", ".$cs_node->map_lon.");
						var mapOptions = {
							zoom: ".$cs_node->map_zoom.",
							scrollwheel: ".$cs_node->map_scrollwheel.",
							draggable: ".$cs_node->map_draggable.",
							center: myLatlng,
							
							disableDefaultUI: ".$cs_node->map_controls.",
							mapTypeControlOptions: {
							  mapTypeIds: [google.maps.MapTypeId.ROADMAP.".$cs_node->map_type.", 'map_style']
							}
						}
						var map = new google.maps.Map(document.getElementById('map_canvas".$counter_node."'), mapOptions);
						map.mapTypes.set('map_style', styledMap);
						map.setMapTypeId('map_style');
						var infowindow = new google.maps.InfoWindow({
							content: '".$cs_node->map_info."',
							maxWidth: ".$cs_node->map_info_width.",
							maxHeight:".$cs_node->map_info_height.",
						});
						".$map_show_marker."
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
				</script>";
		return $html;
	}
}

// image short code
if ( ! function_exists( 'cs_image_page' ) ) {
	function cs_image_page(){
		global $cs_node;
		cs_enqueue_gallery_style_script();
		$href = '';
		$html = '';
		if ($cs_node->image_lightbox == "yes") $href = $cs_node->image_source;
		if($cs_node->image_lightbox =="yes") $data_rel = 'data-rel="prettyPhoto[gallery1]"';
			else $data_rel = 'target="_blank"';
		
		if ( $cs_node->image_element_size <> "" ) { $html .= '<div class="column-wrapp-box"><div class="detail_text_wrapp col-counter">'; }
			$html .= '<figure class="lightbox-single image-shortcode" style="float:left; width:'.$cs_node->image_width.'px; height:'.$cs_node->image_height.'px">';
				if($cs_node->image_lightbox =="yes"){
				$html .= '<a href="'.$href.'" title="'.$cs_node->image_caption.'" '.$data_rel.'>';
				}
					$html .= '<img src="'.$cs_node->image_source.'" style="float:left; width:'.$cs_node->image_width.'px; height:'.$cs_node->image_height.'px" alt="" />';
				if($cs_node->image_lightbox =="yes"){
				$html .= '</a>';
				}
				if($cs_node->image_caption <> ''){
					$html .= '<figcaption class="webkit">';
						$html .= '<h2>'.$cs_node->image_caption.'</h2>';
					$html .= '</figcaption>';
				}
			$html .= '</figure>';
		if ( $cs_node->image_element_size <> "" ) { $html .= '</div></div>'; }
		return $html;
	}
}
// Message Box with various options and multiple styles
if ( ! function_exists( 'cs_message_box_page' ) ) {
	function cs_message_box_page(){
		global $cs_node;
		$html = '<div class="column-wrapp-box"><div class="detail_text_wrapp col-counter">';
		$html .= '<div class="messagebox alert alert-info" style="background:'.$cs_node->mb_bg_color.'">
				<button data-dismiss="alert" class="close" type="button">&#88;</button>';
		$html .= '<h4>'.$cs_node->mb_title.'</h4>';
		$html .= $cs_node->mb_content;
		$html .= '</div>';
		$html .= '</div></div>';
		echo $html;
	}
}
// Divider shortcode use for sepratiion of page elements
if ( ! function_exists( 'cs_divider_page' ) ) { 
	function cs_divider_page(){
		global $cs_node;
		$html = '';
		$html .= '<div style="margin-top:'.$cs_node->divider_mrg_top.'px;margin-bottom:'.$cs_node->divider_mrg_bottom.'px; " class="' . $cs_node->divider_style . '">';
		$html .= '</div>';
		$html .= '';
		return $html . '';
	}
}

// Column shortcode with 2/3/4 column option even you can use shortcode in column shortcode
if ( ! function_exists( 'cs_column_page' ) ) {
	function cs_column_page(){
		global $cs_node;
		$html = '<div class="column-wrapp-box heading-area"><div class="detail_text_wrapp col-counter"><div class="shortgrid">';
			$html .= do_shortcode($cs_node->column_text);
		$html .= '</div></div></div>';
		echo $html;
	}
}

// tabs shortcode
if ( ! function_exists( 'cs_tabs_page' ) ) {
	function cs_tabs_page(){
		global $cs_node, $tab_counter;
		$html = '';
	
		$html .= '<ul class="nav nav-tabs" id="myTab">';
		$cs_xmlObject = simplexml_load_string($cs_node->tabs_content);
		$tabs_count = 0;
		foreach ($cs_xmlObject as $val) {
			if (!isset($val["icon"])){ $val["icon"] = '';}
			if (!isset($val["title"])){ $val["title"] = '';}
			$tabs_count++;
			if ( $val["active"] == "yes")
				$tab_active = " active";
			else
				$tab_active = "";
			$html .= '<li class="' . $tab_active . '"><a data-toggle="tab" href="#tab' . $tab_counter . $tabs_count . '"><em class="fa '.$val["icon"].'"></em> ' . $val["title"] . '</a></li>';
		}
		$html .= '</ul>';
		$html .= '<div class="tab-content">';
		$tabs_count = 0;
		foreach ($cs_xmlObject as $val) {
			$tabs_count++;
			if ( $val["active"] == "yes")
				$tab_active = " active";
			else
				$tab_active = "";
			$html .= '<div class="tab-pane fade in ' . $tab_active . '" id="tab' . $tab_counter . $tabs_count . '"><p>' . $val . '</p></div>';
		}
		$html .= '<div class="clear"></div></div>';
		$html = '<div class="tabs-style"><div class="tabs '.$cs_node->tabs_style.'">' . $html . '</div></div>';
			
		return do_shortcode($html);
	}
}
// Accrodian shortcode
if ( ! function_exists( 'cs_accordions_page' ) ) {
	function cs_accordions_page(){
		global $cs_node, $acc_counter;
		$acc_counter = rand(5, 15);
		$acc_counter++;
		$accordion_count = 0;
		$html = "";
		if ( $cs_node->accordion_element_size == "" ) {
			$html .= '<div class="accordion ' . $cs_node->type . '" id="accordion-' . $acc_counter . '">';
			$cs_xmlObject = new SimpleXMLElement( $cs_node->accordion_content );
			foreach ($cs_xmlObject as $cs_node) {
			if (!isset($cs_node["icon"])){ $cs_node["icon"] = '';}
			if (!isset($cs_node["title"])){ $cs_node["title"] = '';}
				$accordion_count++;
				if ($accordion_count == 1 && $cs_node["active"] == "yes")
						$class_active = " active";
					else
						$class_active = "";
						
				if ( $cs_node["active"] == "yes"){
					
					$accordion_active = " in";
					 
				}else{
					$accordion_active = "";
					
				}
				$html .= '<div class="accordion-group ">';
				$html .= '<div class="accordion-heading">';
				$html .= '<a class="accordion-toggle backcolorhover '.$class_active .'" data-toggle="collapse" data-parent="#accordion-' . $acc_counter . '" href="#accordion-' . str_replace(" ", "", $accordion_count . $acc_counter) . '"><i class="'.$cs_node["icon"].'"></i> ' . $cs_node["title"] . '</a>';
				$html .= '</div>';
				$html .= '<div id="accordion-' . str_replace(" ", "", $accordion_count . $acc_counter) . '" class="accordion-body collapse ' . $accordion_active . '">';
				$html .= '<div class="accordion-inner">' . $cs_node . '</div>';
				$html .= '</div>';
				$html .= '</div>';
			}
			$html .= '</div>';
		}
		else {
			$html = '<div class="accordion" id="accordion-' . $acc_counter . '">';
				foreach ( $cs_node->accordion as $cs_node ){
					$accordion_count++;
					if ($accordion_count == 1)
						$accordion_active = " in";
					else
						$accordion_active = "";
					$html .= '<div class="accordion-group">';
					$html .= '<div class="accordion-heading">';
					$html .= '<a class="accordion-toggle backcolorhover" data-toggle="collapse" data-parent="#accordion-' . $acc_counter . '" href="#accordion-' . str_replace(" ", "", $accordion_count . $acc_counter) . '"><i class="'.$cs_node->accordion_title_icon.'"></i> ' . $cs_node->accordion_title . '</a>';
					$html .= '</div>';
					$html .= '<div id="accordion-' . str_replace(" ", "", $accordion_count . $acc_counter) . '" class="accordion-body collapse ' . $accordion_active . '">';
					$html .= '<div class="accordion-inner">' . $cs_node->accordion_text . '</div>';
					$html .= '</div>';
					$html .= '</div>';
				}
			$html .= '</div>';
			echo do_shortcode($html);	
		}
		return do_shortcode($html);
	}
}

// Corlor Switcher for front end
function cs_color_switcher(){
	global $cs_theme_option;
 	if ( $cs_theme_option['color_switcher'] == "on" ) {
			if ( isset($_POST['style_sheet'])){
				$_SESSION['sess_header'] = "1";
				if (  empty($_POST['header_1_sticky']) ) { 
					$_POST['header_1_sticky'] = '';
					$_SESSION['header_1_sticky'] = "";
				}
				if ( empty($_POST['header_1_sub_header'])) { 
					$_POST['header_1_sub_header'] = '';
					$_SESSION['header_1_sub_header'] = "";
				}
			} elseif(!isset($_SESSION['sess_header'])){
				$_SESSION['header_1_sticky'] = $cs_theme_option['header_1_sticky'];
				$_SESSION['header_1_sub_header'] = $cs_theme_option['header_1_sub_header'];
				
			}
			


		if ( empty($_POST['patter_or_bg']) ){
			$_POST['patter_or_bg'] = '';
		}
		if ( empty($_POST['reset_color_txt']) ) { 
			$_POST['reset_color_txt'] = "";
		}
		

		
		else if ( $_POST['reset_color_txt'] == "1" ) {
			$_POST['layout_option'] = "";
			$_POST['custome_pattern'] = "";
			$_POST['bg_img'] = "";
			$_POST['style_sheet'] = "";
			$_POST['nav_bg_colr'] = "";
 		}
		
		if ( $_POST['patter_or_bg'] == 0 ){
			$_SESSION['snap_sess_bg_img'] = '';
		}
		else if ( $_POST['patter_or_bg'] == 1 ){
			$_SESSION['snap_sess_custome_pattern'] = '';
		}
		
		if ( isset($_POST['layout_option']) ) {
			$_SESSION['snap_sess_layout_option'] = $_POST['layout_option'];
		}
		if ( isset($_POST['style_sheet']) ) {
			$_SESSION['snap_sess_style_sheet'] = $_POST['style_sheet'];
		}
		if ( isset($_POST['nav_bg_colr']) ) {
			$_SESSION['snap_sess_nav_bg_colr'] = $_POST['nav_bg_colr'];
		}
		if ( isset($_POST['custome_pattern']) ) {
			$_SESSION['snap_sess_custome_pattern'] = $_POST['custome_pattern'];
		}
		if ( isset($_POST['color_option']) ) {
			$_SESSION['snap_sess_color_option'] = $_POST['sess_color_option'];
		}
		if ( isset($_POST['bg_img']) ) {
			$_SESSION['snap_sess_bg_img'] = $_POST['bg_img'];
		}
		if ( isset($_POST['header_1_sticky']) &&  $_POST['header_1_sticky']=='on' ) {
			$_SESSION['header_1_sticky'] = $_POST['header_1_sticky'];
		}
		if ( isset($_POST['header_1_sub_header']) &&  $_POST['header_1_sub_header']=='on' ) {
			$_SESSION['header_1_sub_header'] = $_POST['header_1_sub_header'];
		}
		//print_r($_SESSION);
		//samll_logo button ends
		if ( empty($_SESSION['snap_sess_layout_option']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['snap_sess_layout_option'] = "wrapper"; }
		if ( empty($_SESSION['snap_sess_header_styles']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['snap_sess_header_styles'] = ""; }
		if ( empty($_SESSION['snap_sess_style_sheet']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['snap_sess_style_sheet'] = "#282828"; }
		if ( empty($_SESSION['snap_sess_nav_bg_colr']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['snap_sess_nav_bg_colr'] = "#282828"; }
		if ( empty($_SESSION['snap_sess_custome_pattern']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['snap_sess_custome_pattern'] = ""; }
		if ( empty($_SESSION['snap_sess_bg_img']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['snap_sess_bg_img'] = ""; }
		//if ( empty($_SESSION['header_1_sub_header']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['header_1_sub_header'] = "on"; }
		//if ( empty($_SESSION['header_1_sticky']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['header_1_sticky'] = $header_1_sticky_colrsw = ""; }

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
           $("#pattstyles li label") .click(function(){
				$("#backgroundimages li label") .removeClass("active");	
				$("#patter_or_bg") .attr("value","0");
      			var ah = $(this) .find('input[type="radio"]') .val();
      			$('body') .css({"background":"url(<?php echo $theme_path?>/images/pattern/pattern"+ah+".png)"});
      });
      $("#backgroundimages li label") .click(function(){
		  $("#patter_or_bg") .attr("value","1");
		$("#pattstyles li label") .removeClass("active");	
      var ah = $(this) .find('input[type="radio"]') .val();
      $('body') .css({"background":"url(<?php echo $theme_path?>/images/background/bg"+ah+".png) no-repeat center center / cover fixed"});
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
		//jQuery('#color_switcher input:checkbox').attr('checked', 'checked');
    });
	var cf = ".colr, .colrhvr:hover, #filters li a:hover, #filters li a.selected, .portfolio article:hover .text h6 a, .widget_categories ul li:hover, .widget_categories ul li:hover a, .widget-related-blog ul li:hover a, .pagination ul li a.active, .widget_categories ul li:hover a:before, .widget_archive ul li:hover, .widget_recent_entries ul li:hover,.widget_recent_entries ul li:hover,.widget_recent_comments ul li:hover,.widget_links ul li:hover, .widget_meta ul li:hover, .widget_archive ul li:hover a,.widget_recent_entries ul li:hover a,.widget_recent_entries ul li:hover a,.widget_recent_comments ul li:hover a, .widget_links ul li:hover a, .widget_meta ul li:hover a, .widget_pages ul li a:hover, .widget_nav_menu ul li a:hover, .widget ul li:hover a:before ,.woocommerce-tabs ul.tabs li.active a, #comments a, #respond a,.woocommerce .myaccount_user a, .woocommerce .addresses a, .blog-text ul.post-options li a:hover,.widget.woocommerce del,.widget.woocommerce ins,.widget.woocommerce .amount,.product-categories li:hover a,.rsswidget:hover";
	var bc = ".bgcolr, .bgcolrhvr:hover, .flex-control-paging li a.flex-active,  .gallery article:hover .hovicon.effect-1.sub-b, .mas-cont-sec .gallery-box figure:hover figcaption:before, .flex-direction-nav a:hover, .load-more a:hover, .cart-secc span.amount, .woocommerce-message:before, .woocommerce-error:before, .woocommerce-info:before,.woocommerce .button,.cart-sec span.amount,.cart-sec span.qnt, .portfolio article figcaption .mas-cont-sec .no-image figcaption:before, .mas-cont-sec .no-image figcaption:before";
	var boc = ".bdrcolr, #filters li a:hover, #filters li a.selected, .pagination ul li a.active:before, .pagination ul li a:hover:before,.woocommerce-pagination ul li .current, .woocommerce-message, .woocommerce-error, .woocommerce-info, .woocommerce-pagination ul li .current:before,#wp-calendar caption";
	var boc2 =".bdrcolr, #filters li a:hover, #filters li a.selected, .pagination ul li a.active:before, .pagination ul li a:hover:before,.woocommerce-pagination ul li .current, .woocommerce-message, .woocommerce-error, .woocommerce-info, .woocommerce-pagination ul li .current:before,#wp-calendar tfoot a:hover";
	var styleheading = "#header, nav.navigation.mp-menu ul.sub-menu,.header-sticky-off.subheader-off .sticky-btn, #cs-nav-v2 ul ul";
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
		
		
		 
	});
	function reset_color(){
		
		jQuery("#reset_color_txt").attr('value',"1")
		<?php if($cs_theme_option['header_1_sticky'] == 'on'){?>
				jQuery("#header_sticky_id").attr('checked',"checked")	
		<?php } else {?>
				jQuery("#header_sticky_id").removeAttr('checked')
		<?php }?>
		<?php if($cs_theme_option['header_1_sub_header'] == 'on'){?>
				jQuery("#sub_header_id").attr('checked',"checked")	
		<?php } else {?>
				jQuery("#sub_header_id").removeAttr('checked')
		<?php }?>
		//jQuery("#sub_header_id").attr('checked',"checked")#282828
		<?php if(isset($cs_theme_option['nav_bg_color_scheme'])){?>
			jQuery('.wp-color-result').css('background-color', '<?php echo $cs_theme_option['nav_bg_color_scheme'];?>');
			jQuery("#bgcolor").attr('value',"<?php echo $cs_theme_option['nav_bg_color_scheme'];?>")
		<?php } else {?>
			jQuery("#bgcolor").attr('value',"<?php echo $cs_theme_option['custom_color_scheme'];?>")
			jQuery('.wp-color-result').css('background-color', '<?php echo $cs_theme_option['custom_color_scheme'];?>');
		<?php }?>
		//jQuery("form").submit();
		jQuery( "#color_switcher" ).submit();
		//jQuery("#color_switcher").submit();
	}
        </script>
        <style>
        .cs-deactive-switch{
			display:none;
			position:absolute;
		}
        </style>
        <div id="sidebarmain">
            <span id="togglebutton">&nbsp;</span>
            <div id="sidebar">
                <form method="post" id="color_switcher" action="">
                	<aside class="rowside">
                         <header><h4>Options</h4></header>
                         <label>Select Color Scheme</label>
                        <div id="colorpickerwrapp">
                            <?php $cs_color_array= array('#45b363','#339a74', '#1d7f5b', '#3fb0c3', '#2293a6', '#137d8f', '#9374ae', '#775b8f', '#dca13a', '#c46d32', '#c44732',
                                                     '#c44d55', '#425660', '#292f32'
                                                    );
                            foreach($cs_color_array as $colors){
                                $active = '';
                                if($colors == $cs_theme_option['custom_color_scheme']){$active = 'active';}
                                echo '<span class="col-box '.$active.'" data-color="'.$colors.'" style="background: '.$colors.'"></span>';
                            }
                            ?>
                         </div>
                        <label for="bgcolor" id="themecolor" class="colorpicker-main">
                        <img src="<?php echo $theme_path?>/images/admin/img-colorpan.png" alt="">
                        <h5>Theme Color</h5>
                        <input id="bgcolor" name="style_sheet" type="text" class="bg_color" value="<?php echo $_SESSION['snap_sess_style_sheet'];?>" /></label>
                        
                         <ul class="cs-other-switch">
                         	
                             
                            <li class="to-label">
                              <p>Sticky</p>
                              <input type="hidden" name="header_1_sticky1" value="1" />
                              <label class="cs-on-off">
                            
                              <input type="checkbox" id="header_sticky_id" class="myClass switch-heder-sticky" name="header_1_sticky" <?php if (isset($_SESSION['header_1_sticky']) && $_SESSION['header_1_sticky'] == "on") echo "checked" ?> />
                              <span></span>
                              </label>
                            </li>
                            <li class="to-label">
                              <p>Sub Header</p>
                              <input type="hidden" name="header_1_sub_header1" value="1" />
                              <label class="cs-on-off">
                            
                              <input type="checkbox"  id="sub_header_id" class="myClass switch-sub-header" name="header_1_sub_header" <?php if (isset($_SESSION['header_1_sub_header']) && $_SESSION['header_1_sub_header'] == "on") echo "checked" ?> />
                              <span></span>
                              </label>
                            </li>
                            
                         </ul>
                         
                        <!--<label for="nav_bg_colr" id="headingcolor" class="colorpicker-main">
                        <img src="<?php //echo $theme_path?>/images/admin/img-colorpan.png" alt="">
                        <h5>Header Color</h5>
                        <input id="nav_bg_colr" name="nav_bg_colr" type="text" class="bg_color" value="<?php //echo $_SESSION['sess_nav_bg_colr'];?>" /></label>
                         -->
                        
                    </aside>
                    
                	<div class="buttonarea">
                    	<input type="hidden" name="color_switch_sess" value="on" />
                    	<input type="submit" value="Apply" class="btn" />
                        <input type="hidden" name="patter_or_bg" id="patter_or_bg" value="1" />
                        <input type="hidden" name="reset_color_txt" id="reset_color_txt" value="" />
                    	<input type="button" value="Reset" class="btn" onclick="javascript:reset_color()" />
                    </div>
            </form>
            </div>
        </div>
<?php
	}
}

// Custom excerpt function 
function cs_get_the_excerpt($limit='255',$readmore = '') {
	global $cs_theme_option;
    $get_the_excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU', '', get_the_excerpt()));
    echo substr($get_the_excerpt, 0, "$limit");
    if (strlen($get_the_excerpt) > "$limit") {
		echo '...';
    }
}
// Swiper Gallery function
if ( ! function_exists( 'cs_slideshowify_slider' ) ) {
	function cs_slideshowify_slider($width,$height,$slider_id,$cs_view=''){
		global $cs_node,$cs_theme_option,$counter_node;
		if($cs_theme_option['trans_switcher']== "on"){ $photos = __('Photos','Snapture');}else{ $photos = $cs_theme_option['trans_photos']; }
		$counter_node++;
		if($slider_id == ''){
			$slider_id = $cs_node->slider;
		}

			$cs_meta_slider_options = get_post_meta($slider_id, "cs_meta_gallery_options", true); 
			$counter = 1;
			$cs_xmlObject_slideshowify = new SimpleXMLElement($cs_meta_slider_options);
		?>
        	<div class="demo" style="float:left;width:100%;height:100%">
                <!-- markup for slideshow -->
                <div class="ss-slides" id="kenburn<?php echo $counter_node;?>" style="z-index: 9999;">
                <?php 
                    foreach ( $cs_xmlObject_slideshowify->children() as $as_node ){
                        $image_url = cs_attachment_image_src($as_node->path,$width,$height); 
                        if($image_url <> ''){
                        ?>
                    <img src="<?php echo $image_url;?>" alt="" />                                                    
				<?php }}?>                                                  
                </div>
            </div>
            <a class="gallery-link"><i class="fa fa-picture-o"></i><span><?php echo count($cs_xmlObject_slideshowify).' '.$photos;?></span> </a>
		<!-- Swiper Slider Javascript Files -->
        <?php cs_enqueue_slideshowify(); ?>
		 <script>
			jQuery(document).ready(function($) {
			   $('#kenburn<?php echo $counter_node;?> img').slideshowify({ parentEl:'#kenburn<?php echo $counter_node;?>' });
			});
		</script>
	<?php
	}
}

// Swiper Gallery function
if ( ! function_exists( 'cs_swiper_slider' ) ) {
	function cs_swiper_slider($width,$height,$slider_id,$postID='',$cs_view=''){
		global $cs_node,$cs_theme_option,$counter_node;
		$counter_node++;
		if($slider_id == ''){
			$slider_id = $cs_node->slider;
		}
			$cs_meta_slider_options = get_post_meta($slider_id, "cs_meta_slider_options", true); 
			$counter = 1;
			$cs_xmlObject_flex = new SimpleXMLElement($cs_meta_slider_options);
		?>
        	<div class="device">
            <?php if($cs_view <> ''){?>
				<div class="slide-arrow">
                    <div class="click-sec">
                        <a href="#" class="arrow-left gal-arrow-left<?php echo $postID;?>"><i class="fa fa-angle-left"></i></a> 
                        <a href="#" class="arrow-right gal-arrow-right<?php echo $postID;?>"><i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
			<?php } else {?>
            <ul class="gal-direction-nav ">
                    <li>
                        <a href="#" class="gal-arrow-left gal-arrow-left<?php echo $postID;?>"><em class="fa fa-long-arrow-left"></em></a>
                    </li>
                    <li class="total-slide-con">
                        <span class="current-slide current-slide<?php echo $postID;?>">1</span>
                        /<?php echo count($cs_xmlObject_flex);?>
                    </li>
                    <li>
                        <a href="#" class="gal-arrow-right gal-arrow-right<?php echo $postID;?>"><em class="fa fa-long-arrow-right"></em></a>
                    </li>
                </ul>
              <?php }?>
            <div class="swiper-container swiper-container<?php echo $postID;?>">
                  <div class="swiper-wrapper">
                  <?php 
                    
                    foreach ( $cs_xmlObject_flex->children() as $as_node ){
                        $image_url = cs_attachment_image_src($as_node->path,$width,$height); 
                        if($image_url <> ''){
                        ?>
                            <div class="swiper-slide">
                                
                                    <figure>
                                        <a href="<?php echo $as_node->link;?>"><img src="<?php echo $image_url ?>" alt=""></a>
                                    </figure>
                          
                            </div>
                    <?php }}?>
                    
                  </div>
            </div>
            <div class="pagination"></div>
      </div>
		<!-- Swiper Slider Javascript Files -->
        <?php cs_enqueue_swiper(); ?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				  var mySwiper = new Swiper('.swiper-container<?php echo $postID;?>', {
					loop: false,
					grabCursor: true,
					 onSlideChangeStart: function(swiper) {
						var a = mySwiper.activeLoopIndex;
						jQuery(".current-slide<?php echo $postID;?>").text(a+1)
					 }
				  })
				  $('.gal-arrow-left<?php echo $postID;?>').on('click', function(e) {
					e.preventDefault()
					mySwiper.swipePrev()
				  })
				  $('.gal-arrow-right<?php echo $postID;?>').on('click', function(e) {
					e.preventDefault()
					mySwiper.swipeNext()
				  })
				});
		</script>
	<?php
	}
}
// Flexslider function
if ( ! function_exists( 'cs_flex_slider' ) ) {
	function cs_flex_slider($width,$height,$slider_id,$cs_show_description){
		global $cs_node,$cs_theme_option,$counter_node;
		$counter_node++;
		if($slider_id == ''){
			$slider_id = $cs_node->slider;
		}
		if($cs_theme_option['flex_auto_play'] == 'on'){$auto_play = 'true';}
			else if($cs_theme_option['flex_auto_play'] == ''){$auto_play = 'false';}
			$cs_meta_slider_options = get_post_meta($slider_id, "cs_meta_slider_options", true); 
		?>
		<!-- Flex Slider -->
		  <div id="flexslider<?php echo $counter_node ?>" class="flexslider">
			  <ul class="slides">
				<?php 
					$counter = 1;
					$cs_xmlObject_flex = new SimpleXMLElement($cs_meta_slider_options);
					foreach ( $cs_xmlObject_flex->children() as $as_node ){
 						$image_url = cs_attachment_image_src($as_node->path,$width,$height); 
						if($image_url <> ''){
						?>
                        <li>
                            <img src="<?php echo $image_url ?>" />
                            <?php 
								if($as_node->title != '' && $as_node->description != ''){ 
							?>
                                <div class="caption">
                                    <h6>
									<?php if($as_node->link <> ''){?>
                                    <a href="<?php echo $as_node->link;?>" target="<?php echo $as_node->link_target;?>" ><?php echo $as_node->title;?></a>
                                    <?php } else {echo $as_node->title;}?>
                                    </h6>
                                    <?php if($cs_show_description == "ture"){?>
                                        <p>
                                        <?php
                                            echo substr($as_node->description, 0, 215);
                                            if ( strlen($as_node->description) > 215 ) echo "...";
                                        ?>
                                         </p>
                                    <?php }?>
                                </div>
                                <?php }?>
                        </li>
						
					<?php 
						}
					$counter++;
					}
				?>
			  </ul>
		  </div>
 		<!-- Slider height and width -->
        
		<!-- Flex Slider Javascript Files -->
        <?php cs_enqueue_flexslider(); ?>
		<script type="text/javascript">
			jQuery(window).load(function(){
				var speed = <?php echo $cs_theme_option['flex_animation_speed']; ?>; 
				var slidespeed = <?php echo $cs_theme_option['flex_pause_time']; ?>;
				jQuery('#flexslider<?php echo $counter_node ?>.flexslider').flexslider({
					animation: "<?php echo $cs_theme_option['flex_effect']; ?>", // fade
					slideshow: <?php echo $auto_play;?>,
					slideshowSpeed:speed,
					animationSpeed:slidespeed
				});
				jQuery("a.flex-prev").append("<em class='fa fa-angle-left' />");
     			jQuery("a.flex-next").append("<em class='fa fa-angle-right' />");
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

function cs_meta_shop_page($meta, $id){
    global $cs_meta_page;
    $meta = get_post_meta($id, $meta, true);
    if ($meta <> '') {
        $cs_meta_page = new SimpleXMLElement($meta);
        return $cs_meta_page;
    }
}



// Social Share Function
if ( ! function_exists( 'cs_social_share' ) ) {
	function cs_social_share($title='false', $icon_type = '') {
		global $cs_theme_option;
		if($icon_type=='small'){
			$icon = 'fa ';
		} else {
			$icon = 'fa ';
		}
		cs_addthis_script_init_method();
		$html = '';
		$pageurl = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		$path = get_template_directory_uri() . "/images/admin/";
		
		$html ='<div class="social-network">';
			if(isset($title) && $title=='true'){
 				$html .= '<h6>';
				if($cs_theme_option["trans_switcher"] == "on") { $html .= __("Share this post",'Snapture'); }else{  $html .=  $cs_theme_option["trans_share_this_post"];}
				$html .= '</h6>';
			}

			if (isset($cs_theme_option['facebook_share']) && $cs_theme_option['facebook_share'] == 'on') {
				$html .='<a class="addthis_button_facebook"><i class="fa fa-facebook"></i></a>';
			}
			if (isset($cs_theme_option['twitter_share']) && $cs_theme_option['twitter_share'] == 'on') {
				$html .='<a class="addthis_button_twitter"><i class="fa fa-twitter"></i></a>';
			}
			if (isset($cs_theme_option['google_plus_share']) && $cs_theme_option['google_plus_share'] == 'on') { 
				$html .='<a class="addthis_button_google"><i class="fa fa-google-plus"></i></a>';
			}
			if (isset($cs_theme_option['pinterest_share']) && $cs_theme_option['pinterest_share'] == 'on') { 
				$html .='<a class="addthis_button_pinterest fa fa-pinterest"></a>';
			}
			
			if (isset($cs_theme_option['tumblr_share']) &&  $cs_theme_option['tumblr_share'] == 'on') { 
				$html .='<a class="addthis_button_tumblr"><i class="fa fa-tumblr"></i></a>';
			}
			if (isset($cs_theme_option['linkedin_share']) && $cs_theme_option['linkedin_share'] == 'on') {
				$html .='<a class="addthis_button_linkedin"><i class="fa fa-linkedin"></i></a>';
			}
			if (isset($cs_theme_option['cs_other_share']) && $cs_theme_option['cs_other_share'] == 'on') {
				$html .='<a class="addthis_button_compact"><i class="fa fa-google-plus"></i></a>';
			}
			$html .='</div>';
			echo $html;
	}
}

// Social network
if ( ! function_exists( 'cs_social_network' ) ) {
	function cs_social_network($tooltip='',$icon_type=''){
		global $cs_theme_option;
		$cs_deactive_switch_clas = "";
		if(isset($_POST['header_1_social_icon1']) and $_SESSION['header_1_social_icon'] <> "on"){
			$cs_deactive_switch_clas = " cs-deactive-switch";
		}
		$tooltip_data='';
		echo '<div class="social-network'.$cs_deactive_switch_clas.'">';
		if($icon_type=='large'){
			$icon = 'fa-2x';
		}
		if(isset($tooltip) && $tooltip <> ''){
			$tooltip_data='data-placement-tooltip="tooltip"';
		}
		if ( isset($cs_theme_option['social_net_url']) and count($cs_theme_option['social_net_url']) > 0 ) {
				$i = 0;
				foreach ( $cs_theme_option['social_net_url'] as $val ){
					?>
			<?php if($val != ''){?><a title="" href="<?php echo $val;?>" data-original-title="<?php echo $cs_theme_option['social_net_tooltip'][$i];?>" data-placement="top" <?php echo $tooltip_data;?>  target="_blank"><?php if($cs_theme_option['social_net_awesome'][$i] <> '' && isset($cs_theme_option['social_net_awesome'][$i])){?> <em class="fa <?php echo $cs_theme_option['social_net_awesome'][$i];?> <?php echo $icon_type;?>">&nbsp;</em><?php } else {?><img src="<?php echo $cs_theme_option['social_net_icon_path'][$i];?>" alt="<?php echo $cs_theme_option['social_net_tooltip'][$i];?>" /><?php }?></a><?php }
				$i++;
		}
		}
		echo '</div>';
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

/*
Dynamic Css styles changes by color switcher
*/
function cs_custom_styles() {
	global $cs_theme_option;
 
	if ( isset($_POST['nav_bg_colr']) ) {
		$_SESSION['snap_sess_nav_bg_colr'] = $_POST['nav_bg_colr'];
		$header_color_scheme = $_SESSION['snap_sess_nav_bg_colr'];
	}
	elseif (isset($_SESSION['snap_sess_nav_bg_colr']) and $_SESSION['snap_sess_nav_bg_colr'] <> '') {
		$header_color_scheme = $_SESSION['snap_sess_nav_bg_colr'];
	}
	else if(isset($cs_theme_option['nav_bg_color_scheme']) and $cs_theme_option['nav_bg_color_scheme'] <> ""){
		$header_color_scheme = $cs_theme_option['nav_bg_color_scheme'];
	}
	else{
		$header_color_scheme = "#282828";
	}

  	if ( isset($_POST['style_sheet']) ) {
		$_SESSION['snap_sess_style_sheet'] = $_POST['style_sheet'];
		$cs_color_scheme = $_SESSION['snap_sess_style_sheet'];
		$header_color_scheme = $_SESSION['snap_sess_nav_bg_colr'] = $_SESSION['snap_sess_style_sheet'];
	}
	elseif (isset($_SESSION['snap_sess_style_sheet']) and $_SESSION['snap_sess_style_sheet'] <> '') {
		$cs_color_scheme =  $_SESSION['snap_sess_style_sheet'];
	}
	else{
		$cs_color_scheme = $cs_theme_option['custom_color_scheme'];
	}
	if(!isset($cs_color_scheme)){
		$cs_color_scheme = '#F94D51';	
	}
	if(!isset($header_color_scheme)){
		$header_color_scheme ='#282828';	
	}
 ?>
<style type="text/css" scoped="scoped">
@charset "utf-8";
/* CSS Document */
.colr, .colrhvr:hover, #filters li a:hover, #filters li a.selected,
.portfolio article:hover .text h6 a, .widget_categories ul li:hover, .widget_categories ul li:hover a, .widget-related-blog ul li:hover a, .pagination ul li a.active,
.widget_categories ul li:hover a:before, .widget_archive ul li:hover, .widget_recent_entries ul li:hover,.widget_recent_entries ul li:hover,.widget_recent_comments ul li:hover,.widget_links ul li:hover, .widget_meta ul li:hover,.widget.woocommerce del,.widget.woocommerce ins,.widget.woocommerce .amount, .product-categories li:hover a,
.widget_archive ul li:hover a,.widget_recent_entries ul li:hover a,.widget_recent_entries ul li:hover a,.widget_recent_comments ul li:hover a,
.widget_links ul li:hover a, .widget_meta ul li:hover a, .widget_pages ul li a:hover, .widget_nav_menu ul li a:hover, .widget ul li:hover a:before ,.woocommerce-tabs ul.tabs li.active a, #comments a, #respond a,.woocommerce .myaccount_user a, .woocommerce .addresses a, .blog-text ul.post-options li a:hover,.rsswidget:hover{
	color:<?php echo $cs_color_scheme ?> !important;
}
.bgcolr, .bgcolrhvr:hover, .flex-control-paging li a.flex-active,  .gallery article:hover .hovicon.effect-1.sub-b,
.mas-cont-sec .gallery-box figure:hover figcaption:before, .flex-direction-nav a:hover,
.load-more a:hover, .cart-secc span.amount,
.woocommerce-message:before,#wp-calendar tfoot a:hover,
.woocommerce-error:before,#wp-calendar caption,
.woocommerce-info:before,.woocommerce .button,.cart-sec span.amount,.cart-sec span.qnt, .portfolio article figcaption,.mas-cont-sec .no-image figcaption:before{
	background-color:<?php echo $cs_color_scheme ?> !important;
}
.bdrcolr, #filters li a:hover, #filters li a.selected, .pagination ul li a.active:before, .pagination ul li a:hover:before,.woocommerce-pagination ul li .current, .woocommerce-message, .woocommerce-error, .woocommerce-info, .woocommerce-pagination ul li .current:before
{ 
	border-color:<?php echo $cs_color_scheme ?> !important;
}

#header, nav.navigation.mp-menu ul.sub-menu,.header-sticky-off.subheader-off .sticky-btn, #cs-nav-v2 ul ul{
	background-color:<?php echo $header_color_scheme; ?> !important;
}

</style>
<?php
}
// Sub header class 
if ( ! function_exists( 'cs_header_views_set' ) ) { 
	function cs_header_views_set(){
		global $cs_theme_option, $header1_default_settings, $header2_default_settings;
		$header_view_clas = $cs_theme_option['default_header'];
		$sub_header = "subheader-off ";
		$header_sticky = " header-sticky-off ";	
		if($cs_theme_option['header_1_sticky'] == 'on'){
			$header_sticky = " header-sticky-on ";
		}
		if($cs_theme_option['header_1_sub_header'] == 'on'){
			$sub_header = " subheader-on ";
		}
		if(isset($_POST['submit']))
		{
			$sub_header = "subheader-off ";
			$header_sticky = " header-sticky-off ";	
		}
		
			$sub_header_clas = $header1_sticky = '';

		if(isset($_POST['header_1_sticky'])){
			$_SESSION['header_1_sticky'] = $_POST['header_1_sticky'];
			$header1_sticky = $_SESSION['header_1_sticky'];
		} else if(isset($_SESSION['header_1_sticky']) && $_SESSION['header_1_sticky'] <> ''){
			$header1_sticky = $_SESSION['header_1_sticky'];
		} 
		if(isset($_POST['header_1_sub_header'])){
			$_SESSION['header_1_sub_header'] = $_POST['header_1_sub_header'];
			$sub_header_clas = $_SESSION['header_1_sub_header'];
		} else if(isset($_SESSION['header_1_sub_header']) && $_SESSION['header_1_sub_header'] <> ''){
			$sub_header_clas = $_SESSION['header_1_sub_header'];
		} 
		if($header_view_clas == "header1" and $header1_sticky == "on"){
			$header_sticky = " header-sticky-on ";
		}
		if($header_view_clas == "header1" and $sub_header_clas == "on"){
			$sub_header = " subheader-on ";
		}
		echo $header_view_clas. " ".$sub_header.$header_sticky;
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
			'before_title' => '<header class="cs-heading-title"><h2 class="cs-section-title cs-heading-color">',
			'after_title' => '</h2></header>'
		));
	}
}
// custom sidebar end

if ( ! function_exists( 'cs_logo' ) ) {
	function cs_logo($logo_url, $log_width, $logo_height, $class=''){
	?>
		<a href="<?php echo home_url(); ?>">
        	<img src="<?php echo $logo_url; ?>"  style="width:<?php echo $log_width; ?>px; height:<?php echo $logo_height; ?>px" alt="<?php echo bloginfo('name'); ?>" class="<?php echo $class;?>" />
            </a>
	 <?php
	}
}

/*
Under Construction logo Function
*/
function cs_uc_logo(){
	global $cs_theme_option;
	?>
	<a href="<?php echo home_url(); ?>"><img src="<?php echo $cs_theme_option['uc_logo']; ?>" alt="<?php echo bloginfo('name'); ?>" /></a>
 <?php
}

/*
 * Ccustom Header Styles 
 */
function cs_custom_header_styles($header_styles='header1') { global $cs_theme_option, $post;
?>
    
    <!-- Header Start -->    
    <header id="header" class="headermain fullwidth">
    	<?php if(isset($cs_theme_option['default_header']) && $cs_theme_option['default_header'] <> "header2"){ ?>
            <div class="fullwidth"><p class="sticky-btn"><i class="fa fa-align-justify"></i></p><p class="sticky-btn" id="trigger2"><i class="fa fa-align-justify"></i></p></div>
            <?php }
			if(!isset($cs_theme_option['default_header'])){
				echo '<div class="fullwidth"><p class="sticky-btn"><i class="fa fa-align-justify"></i></p><p class="sticky-btn" id="trigger2"><i class="fa fa-align-justify"></i></p></div>';
				
			} ?>
            
        <div id="headermain">
        
        	<?php if(isset($cs_theme_option['default_header']) && $cs_theme_option['default_header'] == "header2"){ 
			
			if(isset($cs_theme_option['default_header']) && $cs_theme_option['default_header'] == "header2" and $cs_theme_option['header_2_small_logo'] == "on"){
			?>
            <div class="logo">
            <?php
			if(isset($cs_theme_option['small_logo'])){
        		cs_logo($cs_theme_option['small_logo'], $cs_theme_option['small_logo_width'], $cs_theme_option['small_logo_height'],'logosmall');
			} else {
				echo '<a href="'.home_url().'"><img alt="" style="width:30px; height:30px" src="'.get_template_directory_uri().'/images/img-logosm.png"></a>';
			}
			?>
            </div>
            <?php } ?>
            
            <div id="cs-nav-v2">
            <?php
			$header2_menu = $cs_theme_option['header_2_strip_menu'];
			?>
        	<?php cs_navigation($header2_menu); ?>
            </div>
			<?php } ?>
            <!-- Logo Start -->
            <?php if(isset($cs_theme_option['default_header']) && $cs_theme_option['default_header'] <> "header2"){ ?>
            <?php if(isset($cs_theme_option['logo']) && !empty($cs_theme_option['logo'])){ ?>
            <div class="logo">
                <?php 
				if(isset($cs_theme_option['header_1_small_logo']) && $cs_theme_option['header_1_small_logo'] == "on"){
				$logo_switch_class="";
				if(isset($_POST['header_1_small_logo1']) and $_SESSION['header_1_small_logo'] <> "on"){
					$logo_switch_class=" cs-deactive-switch";
				}
				if(isset($cs_theme_option['small_logo'])){
					cs_logo($cs_theme_option['small_logo'], $cs_theme_option['small_logo_width'], $cs_theme_option['small_logo_height'],'logosmall'.$logo_switch_class); 
				} else {
					echo '<a href="'.home_url().'"><img alt="" style="width:30px; height:30px" src="'.get_template_directory_uri().'/images/img-logosm.png"></a>';
				}
				}
				?>
                
                <?php
				if(isset($cs_theme_option['logo'])){
					 cs_logo($cs_theme_option['logo'], $cs_theme_option['logo_width'], $cs_theme_option['logo_height'],'logolarge');
				} else {
					echo '<a href="'.home_url().'"><img alt="" style="width:113px; height:73px" src="'.get_template_directory_uri().'/images/logo.png"></a>';
					
				}?>
            
            </div>
            <?php } ?>
            <?php } ?>
            <!-- Logo Close -->
            <!-- Bottom Header -->
            <div class="header-bottom">
				<?php 

			
                    if($cs_theme_option['default_header'] == "header1" and $cs_theme_option['header_1_social_icon']=='on'){
                        cs_social_network(); 
                    } 
					
					if($cs_theme_option['default_header'] == "header2"){
                        cs_social_network(); 
                    }
                	
					if($cs_theme_option['default_header'] == "header1" and $cs_theme_option['header_1_cart']=='on'){
						if ( class_exists( 'woocommerce' ) ){
							cs_woocommerce_header_cart(); 
						}
					}
					
					if($cs_theme_option['default_header'] == "header2" and $cs_theme_option['header_2_cart']=='on'){
						if ( class_exists( 'woocommerce' ) ){
							cs_woocommerce_header_cart();
						}
					}
				?>
            </div>
            <!-- Bottom Header Close -->
            
        <div class="clear"></div>
        </div>
        
        <div class="nav-sec">
        	<!-- Logo Start -->
            <?php if(isset($cs_theme_option['logo']) && !empty($cs_theme_option['logo'])){ ?>
            <div class="logo">
          		<?php if($cs_theme_option['header_1_small_logo'] == "on" || $_SESSION['header_1_small_logo'] == "on"){ ?>
                <?php 
				if(isset($cs_theme_option['small_logo'])){
					cs_logo($cs_theme_option['small_logo'], $cs_theme_option['small_logo_width'], $cs_theme_option['small_logo_height'],'logosmall');
				} 
				 ?>
                <?php } ?>
                <?php 
				if(isset($cs_theme_option['logo'])){
					cs_logo($cs_theme_option['logo'], $cs_theme_option['logo_width'], $cs_theme_option['logo_height'],'logolarge');
				} 
				 ?>
            </div>
           <?php } else {
				echo '<a href="'.home_url().'"><img alt="" style="width:113px; height:73px" src="'.get_template_directory_uri().'/images/logo.png"></a>';
				
				
			}?>
            <!-- Logo Close -->
            
        	<!-- Navigation Start -->
        	<div class="mp-pusher mp-pushed" id="mp-pusher" style="transform: -o-translate3d(205px, 0px, 0px);transform: translate3d(205px, 0px, 0px);-moz-transform: translate3d(205px, 0px, 0px);-webkit-transform: translate3d(205px, 0px, 0px);">
            <nav class="navigation mp-menu" id="mp-menu">
                <?php cs_navigation('main-menu'); ?>
            </nav>
            <script>
            	jQuery(document).ready(function($) {
				 selectnav('menus', {
					label: 'Menu',
					nested: true,
					indent: '-'
				  });
				
            	jQuery("#mp-menu ul") .wrap('<div class="mp-level" />').append("<a class='mp-back'><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Back to Menu','Snapture');}else{echo $cs_theme_option['trans_back_to_menu']; }?></a>");
            	new mlPushMenu( document.getElementById( 'mp-menu' ), document.getElementById( 'trigger2' ), {
				type : 'cover'
				});
            });
            </script>
        </div>
            <!-- Navigation Close -->
            <div class="header-bottom">
            	<!-- Wp Language Start -->
                     <?php 
                     if(isset($cs_theme_option['header_languages'])){
                         if(isset($cs_theme_option['header_languages']) && $cs_theme_option['header_languages'] == 'on'){
                            do_action('icl_language_selector');
                         }
                     }
                    ?>
                <!-- Language Section End -->
            	<?php if(isset($cs_theme_option['copyright']) && !empty($cs_theme_option['copyright'])){ ?>
                    <p><?php echo $cs_theme_option['copyright'];?></p>
                <?php } else { echo '&copy;'.gmdate("Y")." ".get_option("blogname")." WordPress All rights reserved.";}?>
            </div>
        </div>    
    </header>
    <!-- Header Close --> 
         
<?php 
}
/*
*Under Construction Page
*/
if ( ! function_exists( 'cs_under_construction' ) ) {
	function cs_under_construction(){ 
		global $cs_theme_option, $post;
		if(isset($post)){ $post_name = $post->post_name;  }else{ $post_name = ''; }
		if ( $cs_theme_option['under-construction'] == "on" or $post_name == "pf-under-construction" ) { 
		?>
        <style>
		#undercontruction{
			background-color:<?php echo $cs_theme_option['nav_bg_color_scheme']; ?>;
		}
        </style>
	<div class="wrapper wrapper_boxed" id="wrappermain-pix">
        
        <div id="undercontruction">
          <div class="bottom_strip">
            <div class="container">
              <div class="logo">
                  <?php if($cs_theme_option['showlogo'] == "on"){ cs_uc_logo(); } ?>
              </div>
            </div>
          </div>
          <div id="midarea">
              <?php
			  if($cs_theme_option['under_construction_text'] <> ""){
				  echo htmlspecialchars_decode($cs_theme_option['under_construction_text']);
			  }
			  ?>
            <script type="text/javascript" src="js/jquery.countdown.js"></script>
            <div class="countdownit"><div id="defaultCountdown3543"></div></div>
            </div>
            
                  <?php
                    $launch_date = $cs_theme_option['launch_date'];
                    $year = date("Y", strtotime($launch_date));
                    $month = date("m", strtotime($launch_date));
                    $month_event_c = date("M", strtotime($launch_date));							
                    $day = date("d", strtotime($launch_date));
                    $time_left = date("H,i,s", strtotime($launch_date));
                    
                    ?>
                    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/frontend/jquery.countdown.js"></script>
                    <script type="text/javascript">
                        //Countdown callback function
                        jQuery(function () {
                            var austDay = new Date();
                            austDay = new Date(<?php echo $year; ?>,<?php echo $month; ?>-1,<?php echo $day; ?>);
                            jQuery('#defaultCountdown3543').countdown({until: austDay});
                            jQuery('#year').text(austDay.getFullYear());
                        });
                    
                    </script>
        
        </div>
    <div class="clear"></div>
    </div>
<?php die();
	 }
	}
} 
?>