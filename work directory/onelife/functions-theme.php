<?php
// search varibales start

function cs_get_search_results($query) {
	if ( !is_admin() and (is_search())) {
		$query->set( 'post_type', array('post', 'events', 'portfolio') );
		remove_action( 'pre_get_posts', 'cs_get_search_results' );
	}
}
add_action('pre_get_posts', 'cs_get_search_results');
// Filter shortcode in text areas
if ( ! function_exists( 'cs_textarea_filter' ) ) { 
	function cs_textarea_filter($content=''){
		return do_shortcode($content);
	}
}
/* Display navigation to next/previous for single.php */
if ( ! function_exists( 'cs_next_prev_post' ) ) { 
	function cs_next_prev_post($post_sharing){
	global $post,$cs_theme_option;
	posts_nav_link();
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
    <div class="post_change_section">
         <!-- .nav-single -->
        <?php 	previous_post_link( '%link', '<span class="prev backcolrhover"><i class="icon-chevron-left"></i>'.__('Previous Post','OneLife').'</span>' ); ?>
         <div class="change_icons">
            <?php
             if ( $post_sharing== "on"){	
                echo '<a class="icon-share icon-2 backcolrhover"></a>';
             }
            if ( comments_open() ) { echo '<a href="#respond" class="icon-comment icon-2 backcolrhover" ></a>'; }
			?>
            <!-- Show Icons Start -->
            <div class="showicons">
                <div class="social-network webkit">
                    <?php cs_social_share(); ?>
                </div>
                <div class="share_link webkit">
                    <p><?php
                if ($cs_theme_option['trans_switcher'] == "on") {
                    _e('Share This Post', "OneLife");
                } else {
                    echo $cs_theme_option['trans_share_this_post'];
                }
                ?></p>
                    <form>
                        <input value="<?php the_permalink();?>" onfocus="this.select();">
                    </form>
                </div>
            </div>
            <!-- Show Icons End -->
        </div>
         <?php next_post_link( '%link','<span class="nexts backcolrhover">'.__('Next Post','OneLife').'<i class="icon-chevron-right"></i></span>' ); ?>
    </div>
  <?php
	}
}
// next and prev post end
//	Add Featured/sticky text/icon for sticky posts.
if ( ! function_exists( 'cs_featured()' ) ) {
	function cs_featured(){
		global $cs_transwitch,$cs_theme_option;
		if ( is_sticky() ){ ?>
		<span class="featured"><i class="icon-pushpin"></i></span>
		<?php
		}
	}
}

//Add classes according to diffrent view for blog post type
function cs_blog_classes($blog_view =""){
 	if($blog_view == 'blog-large'){ 
		echo 'postlist blog';
	}elseif($blog_view == 'blog-medium'){ 
		echo 'postlist  blog_smail';
	}
	elseif($blog_view == 'blog-masonry-four-col' or $blog_view == 'blog-masonry-three-col'){
		echo "postlist blog_tile";
	}else{ 
		echo 'blog'; 
	}
}
// rating function

// custom function start

/*	return current post type and page type */

function cs_post_type($current_id){
	$post_type = get_post_type($current_id);
	if($post_type == "events"){
		$post_type = "cs_event_meta";
	}elseif($post_type == "page"){
		$post_type = "cs_page_builder";
	}
	return $post_type;
}

// display post page title
function cs_post_page_title(){
	if ( is_author() ) {
		global $author;
		$userdata = get_userdata($author);
		echo __('Author', 'OneLife') . " " . __('Archives', 'OneLife') . ": ".$userdata->display_name;
	}elseif ( is_tag() || is_tax('event-tag') || is_tax('portfolio-tag') ) {
		echo __('Tags', 'OneLife') . " " . __('Archives', 'OneLife') . ": " . single_cat_title( '', false );
	}elseif ( is_category() || is_tax('event-category') || is_tax('portfolio-category') ) {
		echo __('Categories', 'OneLife') . " " . __('Archives', 'OneLife') . ": " . single_cat_title( '', false );
	}elseif( is_search()){
		printf( __( 'Search Results %1$s %2$s', 'OneLife' ), ': ','<span>' . get_search_query() . '</span>' ); 
	}elseif ( is_day() ) {
		printf( __( 'Daily Archives: %s', 'OneLife' ), '<span>' . get_the_date() . '</span>' );
	}elseif ( is_month() ) {
		printf( __( 'Monthly Archives: %s', 'OneLife' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'OneLife' ) ) . '</span>' );
	}elseif ( is_year() ) {
		printf( __( 'Yearly Archives: %s', 'OneLife' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'OneLife' ) ) . '</span>' );
	}elseif ( is_404()){
		_e( 'Error 404', 'OneLife' );
	}elseif(!is_page()){
		_e( 'Archives', 'OneLife' );
	}
}
// page elemect for pirce table
if ( ! function_exists( 'cs_pricetable_page' ) ) {
	function cs_pricetable_page(){
		global $cs_node;
		if(empty($cs_node->pricetable_featured)) $cs_node->pricetable_featured ='';
		$pricetable_featured ='';
		$price_wrapper = '';
		if($cs_node->pricetable_style == ''){
			$cs_node->pricetable_style = 'style1';
		}
		if($cs_node->pricetable_style == 'style1'){
			$price_wrapper = 'price-wrapper';
		}
		if($cs_node->pricetable_featured == "Yes") $pricetable_featured = " active";
		$html = '<div class="element_size_'.$cs_node->pricetable_element_size.' '.$price_wrapper.'"><div class="pricetable price-'.$cs_node->pricetable_style.'">';
		$html .= '<article class="'.$pricetable_featured.'">';
		if($cs_node->pricetable_style <> 'style2'){
		  $html .= '<h5 class="uppercase heading-color">'.$cs_node->pricetable_title.'</h5>';
		}
         $html .= '<h1 class="webkit" style="background:'.$cs_node->pricetable_bgcolor.'"><small>'.$cs_node->pricetable_currency.'</small>'.$cs_node ->pricetable_price.'<span class="uppercase"></span></h1>';
		 $html .= '<div class="text">';
			if($cs_node->pricetable_style == 'style2'){
				$html .= '<h5 class="uppercase">'.$cs_node->pricetable_title.'</h5>';
			}
        $html .= $cs_node->pricetable_content;
		$html .= '</div>';
              $html .= '<a href="'.$cs_node->pricetable_linkurl.'" class="readmore uppercase"  style="background:'.$cs_node->pricetable_bgcolor.'">'.$cs_node->pricetable_linktitle.'</a> </article></div></div>';
		echo $html;
	}
}

// Dropcap shortchode with first letter in caps
if ( ! function_exists( 'cs_dropcap_page' ) ) {
	function cs_dropcap_page(){
		global $cs_node;
		$html = '<div class="element_size_'.$cs_node->dropcap_element_size.'">';
			$html .= '<div class="dropcap">';
				$html .= $cs_node->dropcap_content;
			$html .= '</div>';
		$html .= '</div>';
		return $html;
	}
}

// block quote short code
if ( ! function_exists( 'cs_quote_page' ) ) {
	function cs_quote_page(){
		global $cs_node;
		$html = '<div class="element_size_'.$cs_node->quote_element_size.'">';
			$html .= '<blockquote class="'.$cs_node->quote_type.'" style=" text-align:' .$cs_node->quote_align. '; color:' . $cs_node->quote_text_color . '"><span>' . $cs_node->quote_content . '</span></blockquote>';
		$html .= '</div>';
		return $html . '<div class="clear"></div>';
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
// map shortcode with various options
if ( ! function_exists( 'cs_map_page' ) ) {
	function cs_map_page(){
		global $cs_node, $cs_counter_node;
		if ( !isset($cs_node->map_lat) or $cs_node->map_lat == "" ) { $cs_node->map_lat = 0; }
		if ( !isset($cs_node->map_lon) or $cs_node->map_lon == "" ) { $cs_node->map_lon = 0; }
		if ( !isset($cs_node->map_zoom) or $cs_node->map_zoom == "" ) { $cs_node->map_zoom = 11; }
		if ( !isset($cs_node->map_info_width) or $cs_node->map_info_width == "" ) { $cs_node->map_info_width = 200; }
		if ( !isset($cs_node->map_info_height) or $cs_node->map_info_height == "" ) { $cs_node->map_info_height = 100; }
		if ( !isset($cs_node->map_show_marker) or $cs_node->map_show_marker == "" ) { $cs_node->map_show_marker = 'true'; }
		if ( !isset($cs_node->map_controls) or $cs_node->map_controls == "" ) { $cs_node->map_controls = 'false'; }
		if ( !isset($cs_node->map_scrollwheel) or $cs_node->map_scrollwheel == "" ) { $cs_node->map_scrollwheel = 'true'; }
		if ( !isset($cs_node->map_draggable) or $cs_node->map_draggable == "" )  { $cs_node->map_draggable = 'true'; }
		if ( !isset($cs_node->map_type) or $cs_node->map_type == "" ) { $cs_node->map_type = 'ROADMAP'; }
		if ( !isset($cs_node->map_info)) { $cs_node->map_info = ''; }
		if( !isset($cs_node->map_marker_icon)){ $cs_node->map_marker_icon = ''; }
		if( !isset($cs_node->map_title)){ $cs_node->map_title ='';}
		if( !isset($cs_node->map_element_size)){ $cs_node->map_element_size ='default';}
		if( !isset($cs_node->map_height)){ $cs_node->map_height ='180';}
	 
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
		$html .= '<div class="element_size_'.$cs_node->map_element_size.'">';
			$html .= '<h1 class="color heading-color">'.$cs_node->map_title.'</h1>';
			$html .= '<div class="mapcode iframe mapsection gmapwrapp" id="map_canvas'.$cs_counter_node.'" style="height:'.$cs_node->map_height.'px;"> </div>';
		$html .= '</div>';
		$html .= "<script type='text/javascript'>
					function initialize() {
						var myLatlng = new google.maps.LatLng(".$cs_node->map_lat.", ".$cs_node->map_lon.");
						var mapOptions = {
							zoom: ".$cs_node->map_zoom.",
							scrollwheel: ".$cs_node->map_scrollwheel.",
							draggable: ".$cs_node->map_draggable.",
							center: myLatlng,
							mapTypeId: google.maps.MapTypeId.".$cs_node->map_type." ,
							disableDefaultUI: ".$cs_node->map_controls.",
						}
						var map = new google.maps.Map(document.getElementById('map_canvas".$cs_counter_node."'), mapOptions);
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
		if($cs_node->image_lightbox =="yes") $data_rel = 'data-rel="prettyPhoto"';
			else $data_rel = 'target="_blank"';
		
		if ( $cs_node->image_element_size <> "" ) { $html .= '<div class="element_size_'.$cs_node->image_element_size.'">'; }
			$html .= '<figure class="lightbox-single image-shortcode" style="float:left; width:'.$cs_node->image_width.'px; height:'.$cs_node->image_height.'px">';
				$html .= '<a class="'.$cs_node->image_style.'" href="'.$href.'" title="'.$cs_node->image_caption.'" '.$data_rel.'>';
					$html .= '<img src="'.$cs_node->image_source.'" style="float:left; width:'.$cs_node->image_width.'px; height:'.$cs_node->image_height.'px" alt="" />';
				$html .= '</a>';
				$html .= '<figcaption class="webkit">';
					$html .= '<h6>'.$cs_node->image_caption.'</h6>';
				$html .= '</figcaption>';
			$html .= '</figure>';
		if ( $cs_node->image_element_size <> "" ) { $html .= '</div>'; }
		return $html;
	}
}
// Message Box with various options and multiple styles
if ( ! function_exists( 'cs_message_box_page' ) ) {
	function cs_message_box_page(){
		global $cs_node;
		$html = '<div class="element_size_'.$cs_node->mb_element_size.'">';
		$html .= '<div class="messagebox alert alert-info" style="background:'.$cs_node->mb_bg_color.'">
				<button data-dismiss="alert" class="close" type="button">&#88;</button>';
		$html .= '<h4>'.$cs_node->mb_title.'</h4>';
		$html .= $cs_node->mb_content;
		$html .= '</div>';
		$html .= '</div>';
		echo $html;
	}
}
// Divider shortcode use for sepratiion of page elements
if ( ! function_exists( 'cs_divider_page' ) ) { 
	function cs_divider_page(){
		global $cs_node;
		wp_enqueue_script('scrolltopcontrol_js', get_template_directory_uri() . '/scripts/frontend/scrolltopcontrol.js', '', '', true);
		$html = '<div class="devider element_size_'.$cs_node->divider_element_size.'>">';
		$html .= '<div style="margin-top:'.$cs_node->divider_mrg_top.'px;margin-bottom:'.$cs_node->divider_mrg_bottom.'px; " class="' . $cs_node->divider_style . '">';
		if(isset($cs_node->divider_backtotop) && strtolower($cs_node->divider_backtotop)=='yes'){
			$html .= '<a href="#" class="gotop" id="back-top">'.__('Top','OneLife').'</a>';
		}
		$html .= '</div>';
		$html .= '</div>';
		return $html . '<div class="clear"></div>';
	}
}
// Services shortcode with multiple layout
if ( ! function_exists( 'cs_services_page' ) ) {
	function cs_services_page() {
    	global $cs_node, $post, $element_size_class, $cs_theme_option, $cs_counter_node;
    	?>
        <div class="element_size_<?php echo $cs_node->services_element_size; ?>">
            <!-- Prayer Submit Start -->
            <div class="our_services">
            <div class="wrappservice">
           	 <div class="services" id="centered<?php echo $cs_counter_node;?>">
             	<ul>
                <?php
                foreach ($cs_node->service as $service_info) {
					if ( $service_info->service_style == "service1" ) $service_style = "service-v1";
					elseif ( $service_info->service_style == "service2" ) $service_style = "service-v2";
					elseif ( $service_info->service_style == "service3" ) $service_style = "service-v3";
					elseif ( $service_info->service_style == "service4" ) $service_style = "service-v4";
                    ?>
                    <li  class="<?php echo $service_style?>"> 
                    	<?php if ($service_info->service_icon <> '') { ?><i class="<?php echo $service_info->service_icon; ?>"></i><?php } ?>
                      	<h2 class="heading-color"><?php echo $service_info->service_title; ?></h2>
                      	<p> <?php echo do_shortcode($service_info->service_text); ?></p>
                     	<?php if ($service_info->service_link_url <> '') { ?><a href="<?php echo $service_info->service_link_url; ?>"><?php echo $service_info->service_link_title; ?></a><?php } ?>
                    </li>
				<?php } ?>
                </ul>
            </div>
            <div class="clear"></div>
           
            <?php 
            
            if ( $service_info->service_style == "service4" ){
                cs_enqueue_sly_style_script();
            ?>
             <script type="application/javascript">
				jQuery(document).ready(function($){
					scroll_bar(<?php echo $cs_counter_node;?>);
				});
			</script>
                <div class="scrollbar">
                <div class="handle">
                    <div class="mousearea"></div>
                </div>
            </div>
            <?php }?>
            </div>
            </div>
                <!-- Prayer Submit End -->
              
            </div>
        <?php
    }
}	
// Gallery List and carusaul View
if ( ! function_exists( 'cs_client_page' ) ) {
	function cs_client_page(){
		global $cs_node,$post_id,$cs_theme_option;
		cs_enqueue_gallery_style_script();
		?> 
		<div class="element_size_<?php echo $cs_node->client_element_size; ?> ourclient lightbox">
			<?php 
				if($cs_node->client_header_title <> ''){echo ' <header class="tittle"><h4 class="uppercase heading-color">'.$cs_node->client_header_title.'</h4></header>';} 
					$client_gallery = $cs_node->client_gallery;	
					if($client_gallery <> ''){
					$args=array(
						'name' => $client_gallery,
						'post_type' => 'cs_gallery',
						'post_status' => 'publish',
						'showposts' => 1,
					);
					$get_gallery_id = get_posts($args);
					if($get_gallery_id){
						$get_gallery_id = $get_gallery_id[0]->ID;
					}
					$cs_meta_gallery_options = get_post_meta($get_gallery_id, "cs_meta_gallery_options", true);
					if ( $cs_meta_gallery_options <> "" ) {
						$cs_xmlObject = new SimpleXMLElement($cs_meta_gallery_options);
						$limit_start = 0;
						$limit_end = count($cs_xmlObject);
					}
					if ( $cs_node->client_view == 'List View'){
						if ( $cs_meta_gallery_options <> "" ) {
							echo '<ul>';
							for ( $i = $limit_start; $i < $limit_end; $i++ ) {
								$path = $cs_xmlObject->gallery[$i]->path;
								$title = $cs_xmlObject->gallery[$i]->title;
								$description = $cs_xmlObject->gallery[$i]->description;
								$use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;
								$video_code = $cs_xmlObject->gallery[$i]->video_code;
								$link_url = $cs_xmlObject->gallery[$i]->link_url;
								//$image_url = wp_get_attachment_image_src($path, array(438,288),false);
								$image_url = cs_attachment_image_src($path, 369, 208);
								echo "<li><figure><a href='".$image_url."' data-rel='prettyPhoto'><img src='".$image_url."' data-alt='".$title."' alt='' width='175'></a></figure></li>";
							}
							echo '</ul>';		
						} 
					}
					else if($cs_node->client_view == 'Carousel View'){
						
						$count=1;
						$cs_counter =1;
						$divider = 6;
						?>
						<div class="element_size_<?php echo $cs_node->client_element_size; ?> logo_slide">
							 <?php 
								  cs_enqueue_jcarousel_style_script();
								  cs_enqueue_gallery_style_script();
							  ?>
							  <script type="text/javascript">
								  jQuery(document).ready(function(){	
									  jQuery('#clientcrousel').jcarousel({
										  easing: 'easeOutCubic',
										  animation: 1000
									  });
								  });
							  </script>
							<!-- My Carousel Start -->
							<div id="clientcrousel" class="jcarousel-skin-tango">
								<!-- Carousel items -->
								<ul>
								<?php
									if ( $cs_meta_gallery_options <> "" ) {
										for ( $i = $limit_start; $i < $limit_end; $i++ ) {
											  $path = $cs_xmlObject->gallery[$i]->path;
											  $title = $cs_xmlObject->gallery[$i]->title;
											  $description = $cs_xmlObject->gallery[$i]->description;
											  $use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;
											  $video_code = $cs_xmlObject->gallery[$i]->video_code;
											  $link_url = $cs_xmlObject->gallery[$i]->link_url;
											  //$image_url = wp_get_attachment_image_src($path, array(438,288),false);
											 $image_url = cs_attachment_image_src($path, 369, 208);
											 $image_url_full = cs_attachment_image_src($path, 0, 0);
											 
											 ?>
											
											 <li>
												  <figure>
													  <a href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" target="<?php if($use_image_as==2) { echo '_blank'; }else{ echo '_self';}?>" data-rel="<?php if($use_image_as==1)echo "prettyPhoto1";  elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery2]"?>"><?php echo "<img src='".$image_url."' data-alt='".$title."' alt='' />"; ?></a>
												  </figure>
											  </li>
											 <?php
										 }
									} 
									?>
								  </ul>
							  </div>
							<!-- My Carousel End -->
						</div>
				<?php }
				}
				?>
			   </div>
	<?php
	}
}
// Column shortcode with 2/3/4 column option even you can use shortcode in column shortcode
if ( ! function_exists( 'cs_column_page' ) ) {
	function cs_column_page(){
		global $cs_node;
		$html = '<div class="element_size_'.$cs_node->column_element_size.' column">';
			$html .= do_shortcode($cs_node->column_text);
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
				$html .= '<li class="' . $tab_active . '"><a data-toggle="tab" href="#tab' . $tab_counter . $tabs_count . '"><i class="'.$val["icon"].'"></i> ' . $val["title"] . '</a></li>';
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
				$html .= '<div class="tab-pane fade in ' . $tab_active . '" id="tab' . $tab_counter . $tabs_count . '">' . $val . '</div>';
			}
			$html .= '</div>';
			$html = '<div class="tabs '.$cs_node->tabs_style.'">' . $html . '</div>';
		}
		else {
			$aaa = array();
			$tab_counter++;
			$tabs_count = 0;
				$html = '<ul class="nav nav-tabs" id="myTab">';
				foreach ( $cs_node->tab as $cs_node ){
					$aaa["$cs_node->tab_title"] = $cs_node->tab_text;
					$tabs_count++;
					if ($cs_node->tab_active == "yes")
						$tab_active = " active";
					else
						$tab_active = "";
					$html .= '<li class="' . $tab_active . '"><a data-toggle="tab" href="#tab' . $tab_counter . $tabs_count . '"><i class="'.$cs_node->tab_title_icon.'"></i>' . $cs_node->tab_title . '</a></li>';
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
				$html .= '</div>';
			$html = '<div class="tabs">' . $html . '</div>';
		}
		return do_shortcode($html) . '<div class="clear"></div>';
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
			$html .= '<div class="accordion" id="accordion-' . $acc_counter . '">';
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
				$html .= '<a class="accordion-toggle colorhover '.$class_active .'" data-toggle="collapse" data-parent="#accordion-' . $acc_counter . '" href="#accordion-' . str_replace(" ", "", $accordion_count . $acc_counter) . '"><i class="'.$cs_node["icon"].'"></i> ' . $cs_node["title"] . '</a>';
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
					$html .= '<a class="accordion-toggle colorhover" data-toggle="collapse" data-parent="#accordion-' . $acc_counter . '" href="#accordion-' . str_replace(" ", "", $accordion_count . $acc_counter) . '"><i class="'.$cs_node->accordion_title_icon.'"></i> ' . $cs_node->accordion_title . '</a>';
					$html .= '</div>';
					$html .= '<div id="accordion-' . str_replace(" ", "", $accordion_count . $acc_counter) . '" class="accordion-body collapse ' . $accordion_active . '">';
					$html .= '<div class="accordion-inner">' . $cs_node->accordion_text . '</div>';
					$html .= '</div>';
					$html .= '</div>';
				}
			$html .= '</div>';
			echo do_shortcode($html);	
		}
		return do_shortcode($html) . '<div class="clear"></div>';
	}
}
  
if ( ! function_exists( 'cs_contact_submit' ) ) {
	function cs_contact_submit(){
		foreach ($_REQUEST as $keys=>$values) {
			$$keys = $values;
		}
		$subject = "(" . $bloginfo . ") Contact Form Received";
		$cs_message = '
			<table width="100%" border="1">
			  <tr><td width="100"><strong>Name:</strong></td><td>'.$contact_name.'</td></tr>
			  <tr><td><strong>Email:</strong></td><td>'.$contact_email.'</td></tr>
			  <tr><td><strong>Contact No.</strong></td><td>'.$contact_no.'</td></tr>
			  <tr><td><strong>Message:</strong></td><td>'.$contact_msg.'</td></tr>
			  <tr><td><strong>IP Address:</strong></td><td>'.$_SERVER["REMOTE_ADDR"].'</td></tr>
			</table>
			';
		$headers = "From: " . $contact_name . "\r\n";
		$headers .= "Reply-To: " . $contact_email . "\r\n";
		$headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
		$headers .= "MIME-Version: 1.0" . "\r\n";
		$attachments = '';
		wp_mail( $cs_contact_email, $subject, $cs_message, $headers, $attachments );
		//mail($cs_contact_email, $subject, $cs_message, $headers);
		echo $cs_contact_succ_msg;
		die();
	}
 }
add_action('wp_ajax_contact_submit', 'contact_submit');
add_action('wp_ajax_contact_nopriv_submit', 'contact_submit');
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
			$_POST['layout_option'] = "";
			$_POST['custome_pattern'] = "";
			$_POST['bg_img'] = "";
			$_POST['style_sheet'] = "";
			$_POST['heading_color'] = "";
 		}
		
		if ( $_POST['patter_or_bg'] == 0 ){
			$_SESSION['sess_bg_img'] = '';
		}
		else if ( $_POST['patter_or_bg'] == 1 ){
			$_SESSION['sess_custome_pattern'] = '';
		}
		
		if ( isset($_POST['layout_option']) ) {
			$_SESSION['sess_layout_option'] = $_POST['layout_option'];
		}
		if ( isset($_POST['style_sheet']) ) {
			$_SESSION['sess_style_sheet'] = $_POST['style_sheet'];
		}
		if ( isset($_POST['heading_color']) ) {
			$_SESSION['sess_heading_color'] = $_POST['heading_color'];
		}
		if ( isset($_POST['custome_pattern']) ) {
			$_SESSION['sess_custome_pattern'] = $_POST['custome_pattern'];
		}
		if ( isset($_POST['bg_img']) ) {
			$_SESSION['sess_bg_img'] = $_POST['bg_img'];
		}

		if ( empty($_SESSION['sess_layout_option']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['sess_layout_option'] = "wrapper_boxed"; }
		if ( empty($_SESSION['sess_header_styles']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['sess_header_styles'] = ""; }
		if ( empty($_SESSION['sess_style_sheet']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['sess_style_sheet'] = "#E65069"; }
		if ( empty($_SESSION['sess_heading_color']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['sess_heading_color'] = "#666666"; }
		if ( empty($_SESSION['sess_custome_pattern']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['sess_custome_pattern'] = ""; }
		if ( empty($_SESSION['sess_bg_img']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['sess_bg_img'] = ""; }

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
    });
	var cf = ".colr,.colrhover:hover, .thumblist .text > header h5 a:hover, .shar_btn:hover i, .accordion-heading .accordion-toggle:hover, .accordion-heading .accordion-toggle.active,.portfolio article:hover .text h6 a, .filter_nav ul li.selected-1 a, .filter_nav ul li.selected-2 a, .filter_nav ul li.selected-0 a, .filter_nav ul li a:hover,.blog_admin article:hover, .pagenone .navigation ul li a:hover, .count a, .comment-edit-link, .comment-reply-link, .comment-reply-title, .comment-reply-title a, .post-edit-link,.prject_main_text h4, .headlines article .text h6 a, .alert-info h4, .widget_tag_cloud a:hover,.bolg_column article:hover figcaption h4 a,.post-options li a:hover, .event article .text .top p a:hover, .pricing-box .plan-inside li span, .services article:hover .icon-lightbulb, .services article:hover .icon-bar-chart, .services article:hover .icon-laptop, .services article:hover .icon-external-link, .services article:hover h2 a,.team-shortcode article:hover, .testimonial-author, .detail_info article p a:hover"; 
	var bc = "#submit-comment, .backcolr, .backcolrhover:hover, nav.navigation > ul > li.current-menu-item,nav.navigation > ul > li.current_page_item, .jcarousel-control a.active, \
.jcarousel-skin-tango .jcarousel-next-horizontal:hover, .jcarousel-skin-tango .jcarousel-prev-horizontal:hover, .upcoming_event article:hover .date, \
.widget_categories ul li:hover, .postlist article figure a img:before, .coursesarticle:hover .rating, #wp-calendar caption, #wp-calendar tbody td a, .table thead, \
.countdownit span.countdown_section, .typo p:first-letter, .widget_archive ul li:hover, .widget_nav_menu ul li a:hover, .widget_links ul li:hover, \
.widget_meta ul li:hover, .widget_pages ul li a:hover, .widget_recent_entries ul li:hover, .widget_recent_comments ul li:hover, .postlist .blog_text:before, \
.blog article #flexslider .flex-direction-nav a:hover,.audiobox ,#banner .flexslider .flex-control-nav li a.flex-active, \
.dropcap:first-letter, .vertical .nav-tabs li.active a, .wpcf7-submit, .show-nav-testimonial .flex-direction-nav a:hover, .widget_ns_mailchimp input[type='submit'], \
.services article.service-v2:hover a i";
	var boc = ".bordercolr, .bordercolrhover:hover, nav.navigation > ul > li.current-menu-item > a:before, #respond form p input:focus, #respond form p textarea:focus";
	var boc2 =".coursesarticle:hover .rating:before, .blog_admin article:hover .cuting_border, .team-shortcode article:hover .cuting_border";
	var styleheading = "#wrappermain-pix h1,#wrappermain-pix h2,#wrappermain-pix h3,#wrappermain-pix h4,#wrappermain-pix h5,#wrappermain-pix h6,#wrappermain-pix h1 a,#wrappermain-pix h2 a,#wrappermain-pix h3 a,#wrappermain-pix h4 a,#wrappermain-pix h5 a,#wrappermain-pix h6 a";
	$('#themecolor .bg_color').wpColorPicker({
		change:function(event,ui){
			var a = ui.color.toString();
			$("#stylecss") .remove();
			$("<style type='text/css' id='stylecss'>"+cf+"{color:"+a+" !important}"+bc+"{background-color:"+a+" !important}"+boc+"{border-color:"+a+" !important}"+boc2+"{border-color:transparent "+a+" !important}</style>").insertAfter("#wrappermain-pix");
			} 
    	}); 
 	$('#headingcolor .bg_color').wpColorPicker({
		change:function(event,ui){
			var a = ui.color.toString();
			$("#stylecsstwo") .remove();
			$("<style type='text/css' id='stylecsstwo'>"+styleheading+"{color:"+a+" !important}</style>").insertAfter("#wrappermain-pix");
			} 
    	}); 
	});
	function reset_color(){
		jQuery("#reset_color_txt").attr('value',"1")
		jQuery("#color_switcher").submit();
	}
        </script>
        <div id="sidebarmain">
            <span id="togglebutton">&nbsp;</span>
            <div id="sidebar">
                <form method="post" id="color_switcher" action="">
                	<aside class="rowside">
                    	<header><h4>Layout options</h4></header>
                        <h5>Choose Your Layout Style</h5>
                        <ul class="layoutoption selectradio">
                        	<li><label class="label_radio <?php if($_SESSION['sess_layout_option']=="wrapper")echo "active";?> "><img src="<?php echo $theme_path?>/images/admin/bg-btnwide.png" alt=""><input type="radio" name="layout_option" value="wrapper" ></label></li>
                        	<li><label class="label_radio <?php if($_SESSION['sess_layout_option']=="wrapper_boxed")echo "active";?> "><img src="<?php echo $theme_path?>/images/admin/bg-btnboxed.png" alt=""><input type="radio" name="layout_option" value="wrapper_boxed" ></label></li>
                        </ul>
      
                       <label for="bgcolor" id="themecolor" class="colorpicker-main">
                        <img src="<?php echo $theme_path?>/images/admin/img-colorpan.png" alt="">
                        <h5>Theme Color</h5>
                        <input id="bgcolor" name="style_sheet" type="text" class="bg_color" value="<?php echo $_SESSION['sess_style_sheet'];?>" /></label>
                        
                        <label for="headingcolorbg" id="headingcolor" class="colorpicker-main">
                        <img src="<?php echo $theme_path?>/images/admin/img-colorpan.png" alt="">
                        <h5>Heading Color</h5>
                        <input id="headingcolorbg" name="heading_color" type="text" class="bg_color" value="<?php echo $_SESSION['sess_heading_color'];?>" /></label>
                    
                    </aside>
                    <div class="accordion-sidepanel">
                    <aside class="rowside">
                      <header>  <h4>Pattren Styles</h4></header>
                      <div class="innertext">
                      
                        <div id="pattstyles" class="itemstyles selectradio">
                            <ul>
                                <li><label <?php if($_SESSION['sess_custome_pattern']=="1")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern1.png" alt=""><input type="radio" name="custome_pattern" value="1"></label></li>
                                <li><label <?php if($_SESSION['sess_custome_pattern']=="2")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern2.png" alt=""><input type="radio" name="custome_pattern" value="2"></label></li>
                                <li><label <?php if($_SESSION['sess_custome_pattern']=="3")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern3.png" alt=""><input type="radio" name="custome_pattern" value="3"></label></li>
                                <li><label <?php if($_SESSION['sess_custome_pattern']=="4")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern4.png" alt=""><input type="radio" name="custome_pattern" value="4"></label></li>
                                <li><label <?php if($_SESSION['sess_custome_pattern']=="5")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern5.png" alt=""><input type="radio" name="custome_pattern" value="5"></label></li>
                                <li><label <?php if($_SESSION['sess_custome_pattern']=="6")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern6.png" alt=""><input type="radio" name="custome_pattern" value="6"></label></li>
                                <li><label <?php if($_SESSION['sess_custome_pattern']=="7")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern7.png" alt=""><input type="radio" name="custome_pattern" value="7"></label></li>
                                <li><label <?php if($_SESSION['sess_custome_pattern']=="8")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern8.png" alt=""><input type="radio" name="custome_pattern" value="8"></label></li>
                                <li><label <?php if($_SESSION['sess_custome_pattern']=="9")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern9.png" alt=""><input type="radio" name="custome_pattern" value="9"></label></li>
                                <li><label <?php if($_SESSION['sess_custome_pattern']=="10")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern10.png" alt=""><input type="radio" name="custome_pattern" value="10"></label></li>
                                <li><label <?php if($_SESSION['sess_custome_pattern']=="11")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern11.png" alt=""><input type="radio" name="custome_pattern" value="11"></label></li>
                                <li><label <?php if($_SESSION['sess_custome_pattern']=="12")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern12.png" alt=""><input type="radio" name="custome_pattern" value="12"></label></li>
                                <li><label <?php if($_SESSION['sess_custome_pattern']=="13")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern13.png" alt=""><input type="radio" name="custome_pattern" value="13"></label></li>
                                <li><label <?php if($_SESSION['sess_custome_pattern']=="14")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern14.png" alt=""><input type="radio" name="custome_pattern" value="14"></label></li>
                                <li><label <?php if($_SESSION['sess_custome_pattern']=="15")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern15.png" alt=""><input type="radio" name="custome_pattern" value="15"></label></li>
                            </ul>
                        </div>
                        </div>
                    </aside>
                    <aside class="rowside">
                        <header><h4>Background Images</h4></header>
                        <div class="innertext">
                      
                        <div id="backgroundimages" class="selectradio">
                            <ul>
                            	<li><label <?php if($_SESSION['sess_bg_img']=="1")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background1.png" alt=""><input type="radio" name="bg_img" value="1"></label></li>
                                <li><label <?php if($_SESSION['sess_bg_img']=="2")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background2.png" alt=""><input type="radio" name="bg_img" value="2"></label></li>
                                <li><label <?php if($_SESSION['sess_bg_img']=="3")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background3.png" alt=""><input type="radio" name="bg_img" value="3"></label></li>
                                <li><label <?php if($_SESSION['sess_bg_img']=="4")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background4.png" alt=""><input type="radio" name="bg_img" value="4"></label></li>
                                <li><label <?php if($_SESSION['sess_bg_img']=="5")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background5.png" alt=""><input type="radio" name="bg_img" value="5"></label></li>
                                <li><label <?php if($_SESSION['sess_bg_img']=="6")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background6.png" alt=""><input type="radio" name="bg_img" value="6"></label></li>
                                <li><label <?php if($_SESSION['sess_bg_img']=="7")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background7.png" alt=""><input type="radio" name="bg_img" value="7"></label></li>
                                <li><label <?php if($_SESSION['sess_bg_img']=="8")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background8.png" alt=""><input type="radio" name="bg_img" value="8"></label></li>
                                <li><label <?php if($_SESSION['sess_bg_img']=="9")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background9.png" alt=""><input type="radio" name="bg_img" value="9"></label></li>
                                <li><label <?php if($_SESSION['sess_bg_img']=="10")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background10.png" alt=""><input type="radio" name="bg_img" value="10"></label></li>
                                <li><label <?php if($_SESSION['sess_bg_img']=="11")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background11.png" alt=""><input type="radio" name="bg_img" value="11"></label></li>
                                <li><label <?php if($_SESSION['sess_bg_img']=="12")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background12.png" alt=""><input type="radio" name="bg_img" value="12"></label></li>
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

// Custom excerpt function 
function cs_get_the_excerpt($limit,$readmore = '') {
	global $cs_theme_option;
    $get_the_excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU', '', get_the_excerpt()));
    echo substr($get_the_excerpt, 0, "$limit");
    if (strlen($get_the_excerpt) > "$limit") {
		if($readmore == "true"){
        	echo '... <a href="' . get_permalink() . '" class="colr">' . $cs_theme_option['trans_read_more'] . '</a>';
		}
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
		  <div class="flexslider">
			  <ul class="slides">
				<?php 
					$cs_counter = 1;
					$cs_xmlObject_flex = new SimpleXMLElement($cs_meta_slider_options);
					foreach ( $cs_xmlObject_flex->children() as $as_node ){
						
 						$image_url = cs_attachment_image_src($as_node->path,$width,$height); 
						?>
						<li>
							<img src="<?php echo $image_url ?>" alt="" />
							<!-- Caption Start -->
							<?php 
								if($as_node->title != '' && $as_node->description != '' || $as_node->title != '' || $as_node->description != ''){ 
								$as_node->cs_slider_link ="";
								if($as_node->link <> ''){}
								
							?>
                            	<div class="caption">
                                     <h1 class="colr uppercase"><?php echo $as_node->title; ?></h1>
 										<p>
											<?php
												echo substr($as_node->description, 0, 220);
												if ( strlen($as_node->description) > 220 ) echo "...";
											?>
										</p>
                                         <?php if($as_node->link <> ''){ 
										 echo '<a class="backcolr uppercase webkit" href="'.$as_node->link.'" target="'.$as_node->link_target.'">'.$cs_theme_option['trans_read_more'].'</a>';
									}
									?>
								
							</div>
							<!-- Caption End -->
							<?php } ?>
							  <div class="bannershadow"></div>
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
			jQuery(window).load(function(){
				var speed = <?php echo $cs_theme_option['flex_animation_speed']; ?>; 
				var slidespeed = <?php echo $cs_theme_option['flex_pause_time']; ?>;
				jQuery('.flexslider').flexslider({
					animation: "<?php echo $cs_theme_option['flex_effect']; ?>", // fade
					slideshow: true,
					slideshowSpeed:speed,
					animationSpeed:slidespeed,
					start: function(slider){
					 jQuery('body').removeClass('loading');
						jQuery('.duration .loader').stop() .animate({"width":"100%"},speed-slidespeed);
					},
					before: function(){jQuery('.duration .loader').stop() .animate({"width":"0%"}) ;},          
					after: function(){jQuery('.duration .loader').stop() .animate({"width":"100%"},speed-slidespeed) ;}
				});
			});
		</script>
	<?php
	}
}
// Portfolio Gallery 
if ( ! function_exists( 'cs_portfolio_gallery' ) ) {
	function cs_portfolio_gallery($width,$height,$gallery_id,$gallery_type){
		$cs_meta_gallery_options = get_post_meta($gallery_id, "cs_meta_gallery_options", true);
		if ( $cs_meta_gallery_options <> "" ) {
			$cs_xmlObject = new SimpleXMLElement($cs_meta_gallery_options);
			if($gallery_type == "Simple Gallery"){ ?>
 				<div class="staticmg">
					<?php
						for ( $i =0; $i < count($cs_xmlObject); $i++ ) {
						$path = $cs_xmlObject->gallery[$i]->path;
						 $image_url = cs_attachment_image_src($path, $width, $height);
						$image_url_full = cs_attachment_image_src($path, 0, 0);
					?>
					<img src="<?php echo $image_url; ?>" alt="">
					 <?php }?>
				</div>
 			<?php
			}else{
				 cs_enqueue_sly_style_script();	
			?>
				<!-- Scroll Page Start -->
				<div id="scroller">
					<div id="basic" class="frame">
						<ul>
							<?php
								for ( $i =0; $i < count($cs_xmlObject); $i++ ) {
								$path = $cs_xmlObject->gallery[$i]->path;
								$image_url = cs_attachment_image_src($path, $width, $height);
								$image_url_full = cs_attachment_image_src($path, 0, 0);
							?>
			
							<li>
								<figure><img src="<?php echo $image_url_full; ?>" alt=""></figure>
							</li>
							<?php }?>
						</ul>
					</div>
					<div class="scrollbar">
						<div class="handle">
							<div class="mousearea"></div>
						</div>
					</div>
				</div>
				<!-- Scroll Page End -->
				<script type="text/javascript">
					jQuery(window).load(function(){
						jQuery(function($){
							'use strict';
						
							// -------------------------------------------------------------
							//   Basic Navigation
							// -------------------------------------------------------------
							(function () {
								var $frame  = $('#basic');
								var $slidee = $frame.children('ul').eq(0);
								var $wrap   = $frame.parent();
						
								// Call Sly on frame
								$frame.sly({
									horizontal: 1,
									itemNav: 'basic',
									smart: 1,
									activateOn: 'click',
									mouseDragging: 1,
									touchDragging: 1,
									releaseSwing: 1,
									startAt: 3,
									scrollBar: $wrap.find('.scrollbar'),
									scrollBy: 1,
									activatePageOn: 'click',
									speed: 300,
									elasticBounds: 1,
									easing: 'easeOutCubic',
									dragHandle: 1,
									dynamicHandle: 1,
									clickBar: 1,
						
									// Buttons
									prev: $wrap.find('.prev'),
									next: $wrap.find('.next'),
								});
							}());
							jQuery(window).resize(function(event) {
								 var $frame = $('#basic');
								  $frame.stop();
									 $frame.sly('reload');
							});
						});
					});
				</script>
			<?php
				}
			}else{
		}
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
			$content_class = "span12";
			$cs_video_width = 1170;
		}
		else if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout == 'right' ) {
			$content_class = "span9";
			$cs_video_width = 870;
		}
		else if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout == 'left' ) {
			$content_class = "span9";
			$cs_video_width = 870;
		}
		else if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and ($cs_meta_page->sidebar_layout->cs_layout == 'both' or $cs_meta_page->sidebar_layout->cs_layout == 'both_left' or $cs_meta_page->sidebar_layout->cs_layout == 'both_right')) {
			$content_class = "span6";
			$cs_video_width = 570;
		}else{
			$content_class = "span12";
		}
		return $content_class;
	}
}
// sidebar class
if ( ! function_exists( 'cs_meta_sidebar_class' ) ) {
	function cs_meta_sidebar_class(){
		global $cs_meta_page;
		if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout == 'right' ) {
			echo "sidebar-right span3";
		}
		else if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout == 'left' ) {
			echo "sidebar-left span3";
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
			echo "content-left span9";
		}
		else if ( $layout <> '' and $layout == 'left' ) {
			echo "content-right span9";
		}
		else if ( $layout <> '' and $layout == 'both' ) {
			echo "span6";
		}
	}	
}
// Default pages sidebar class
if ( ! function_exists( 'cs_default_pages_sidebar_class' ) ) { 
	function cs_default_pages_sidebar_class($layout){
		if ( $layout <> '' and $layout == 'right' ) {
			echo "sidebar-right span3";
		}
		else if ( $layout <> '' and $layout == 'left' ) {
			echo "sidebar-left span3";
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

// change the default query variable start
function cs_change_query_vars($query) {
    if (is_search() || is_archive() || is_author() || is_tax() || is_tag() || is_category() || is_home()) {
        if (empty($_GET['page_id_all']))
            $_GET['page_id_all'] = 1;
       $query->query_vars['paged'] = $_GET['page_id_all'];
}
return $query; // Return modified query variables
}
add_filter('pre_get_posts', 'cs_change_query_vars'); // Hook our custom function onto the request filter
// change the default query variable end

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
		if ($_GET['page_id_all'] > 1)
			$html .= "<li class='prev'><a href='?page_id_all=" . ($_GET['page_id_all'] - 1) . "$qrystr' ><i class='icon-double-angle-left'></i><span>".__('Previous','OneLife')."</span></a></li>";
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
			$html .= "<li class='next'><a href='?page_id_all=" . ($_GET['page_id_all'] + 1) . "$qrystr' ><span>".__('Next','OneLife')."</span><i class='icon-double-angle-right'></i></a></li>";
		return $html;
	}
}

// pagination end
// Social Share Function
if ( ! function_exists( 'cs_social_share' ) ) {
	function cs_social_share($icon_type = '', $title='') {
		global $post, $cs_theme_option;
		if($icon_type=='small'){
			$icon = 'icon-2';
		} else {
			$icon = 'icon-2x';
		}
		
		$html = '';
		$pageurl = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		$pageurl = get_permalink($post->ID);;
		$path = get_template_directory_uri() . "/images/admin/";
		
		//$html ='<div class="social-network">';
			if(isset($title) && $title==true){
 				$html .= '<header class="heading"><h6 class="transform">';
				if($cs_theme_option["trans_switcher"] == "on") { $html .= _e("Share this post",'OneLife'); }else{  $html .=  $cs_theme_option["trans_share_this_post"];}
				$html .= '</h6></header>';
			}
			if (isset($cs_theme_option['twitter_share']) && $cs_theme_option['twitter_share'] == 'on') {
				$html .= '<a href="http://twitter.com/home?status=' . get_the_title() . ' - ' . $pageurl . '" target="_blank" data-original-title="Twitter" data-placement="top" class="icon-twitter-sign twitter  '.$icon.'"></a>';
			}
			if (isset($cs_theme_option['facebook_share']) && $cs_theme_option['facebook_share'] == 'on') {
				$html .= '<a href="http://www.facebook.com/share.php?u=' . $pageurl . '&t=' . get_the_title() . '" target="_blank" data-original-title="Facebook" data-placement="top" class="icon-facebook-sign facebook  '.$icon.'"></a>';
			}
			if (isset($cs_theme_option['linkedin_share']) && $cs_theme_option['linkedin_share'] == 'on') {
				$html .= '<a href="http://www.linkedin.com/shareArticle?mini=true&#038;url=' . $pageurl . '&#038;title=' . get_the_title() . '" target="_blank" data-original-title="Linkedin" data-placement="top" class="icon-linkedin-sign linkedin  '.$icon.'"></a>';
			}
			if (isset($cs_theme_option['pinterest_share']) && $cs_theme_option['pinterest_share'] == 'on') {
				$html .= '<a href="http://pinterest.com/pin/create/button/?url=' . $pageurl . '&#038;title=' . get_the_title() . '" target="_blank"  data-original-title="Pinterest" data-placement="top" class="icon-pinterest-sign  pinterest  '.$icon.'"></a>';
			}
			if (isset($cs_theme_option['google_plus_share']) && $cs_theme_option['google_plus_share'] == 'on') { 
				$html .= '<a href="https://plus.google.com/share?url='.get_permalink($post->ID).'" target="_blank" data-original-title="Google Plus" data-placement="top" class="icon-google-plus-sign google_plus  '.$icon.'"></a>'; 
			}
			if (isset($cs_theme_option['tumblr_share']) &&  $cs_theme_option['tumblr_share'] == 'on') { 
				$html .= '<a href="https://www.tumblr.com/share/link?url='.get_permalink($post->ID).'&name=' . get_the_title() . '" target="_blank" data-original-title="Tumbler" data-placement="top" class="icon-tumblr-sign tumbler  '.$icon.'"></a>'; 
			}
			
		//$html .='</div>';
		echo $html;
	}
}
// Social network
if ( ! function_exists( 'cs_social_network' ) ) {
	function cs_social_network($tooltip='', $icon = 'icon-2'){
		global $cs_theme_option;
		$tooltip_data='';
		echo '<div class="social-network">';
		if(isset($cs_theme_option['social_net_title']) && $cs_theme_option['social_net_title'] <> ''){
			echo '<h6>';
				echo $cs_theme_option['social_net_title'];
			echo '</h6>';
		}
				if(isset($tooltip) && $tooltip <> ''){
					$tooltip_data='data-placement-tooltip="tooltip"';
				}
				if ( isset($cs_theme_option['social_net_url']) and count($cs_theme_option['social_net_url']) > 0 ) {
						$i = 0;
						foreach ( $cs_theme_option['social_net_url'] as $val ){
							?>
					<?php if($val != ''){?><a title="" href="<?php echo $val;?>" data-original-title="<?php echo $cs_theme_option['social_net_tooltip'][$i];?>" data-placement="top" <?php echo $tooltip_data;?> class="colrhover"  target="_blank"><?php if($cs_theme_option['social_net_awesome'][$i] <> '' && isset($cs_theme_option['social_net_awesome'][$i])){?> <i class="<?php echo $cs_theme_option['social_net_awesome'][$i];?> <?php echo $icon;?>"></i><?php } else {?><img src="<?php echo $cs_theme_option['social_net_icon_path'][$i];?>" alt="<?php echo $cs_theme_option['social_net_tooltip'][$i];?>" /><?php }?></a><?php }
							
						$i++;}
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
// Get Main background
function cs_bg_image(){
	global $cs_theme_option;
	$bg_img = '';
	if ( isset($_POST['bg_img']) ) {
		$_SESSION['sess_bg_img'] = $_POST['bg_img'];
		$bg_img = get_template_directory_uri()."/images/background/bg".$_SESSION['sess_bg_img'].".png";
	}
	else if ( isset($_SESSION['sess_bg_img']) and !empty($_SESSION['sess_bg_img'])){
		$bg_img = get_template_directory_uri()."/images/background/bg".$_SESSION['sess_bg_img'].".png";
	}
	else {
		if ( $cs_theme_option['bg_img_custom'] == "" ) {
			if ( $cs_theme_option['bg_img'] <> 0 ){
				$bg_img = get_template_directory_uri()."/images/background/bg".$cs_theme_option['bg_img'].".png";
			}
		}
		else { 
			$bg_img = $cs_theme_option['bg_img_custom'];
		}
	}
	if ( $bg_img <> "" ) {
		echo ' style="background: url('.$bg_img.') ' . $cs_theme_option['bg_repeat'] . ' top ' . $cs_theme_option['bg_position'] . ' ' . $cs_theme_option['bg_attach'].'"';
	}
}
// Get Background color Pattren
function cs_bgcolor_pattern(){
	global $cs_theme_option;
	// pattern start
	$pattern = '';
	$bg_color = '';
	if ( isset($_POST['custome_pattern']) ) {
		$_SESSION['sess_custome_pattern'] = $_POST['custome_pattern'];
		$pattern = get_template_directory_uri()."/images/pattern/pattern".$_SESSION['sess_custome_pattern'].".png";
	}
	else if ( isset($_SESSION['sess_custome_pattern']) and !empty($_SESSION['sess_custome_pattern'])){
		$pattern = get_template_directory_uri()."/images/pattern/pattern".$_SESSION['sess_custome_pattern'].".png";
	}
	else {
		if ( $cs_theme_option['custome_pattern'] == "" ) {
			if ( $cs_theme_option['pattern_img'] <> 0 ){
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
		$_SESSION['sess_bg_color'] = $_POST['bg_color'];
		$bg_color = $_SESSION['sess_bg_color'];
	}
	else if ( isset($_SESSION['sess_bg_color']) ){
		$bg_color = $_SESSION['sess_bg_color'];
	}
	else {
		$bg_color = $cs_theme_option['bg_color'];
	}
	// bg color end
	echo ' style="background:'.$bg_color.' url('.$pattern.')" ';
}
// Main wrapper class function
function cs_wrapper_class(){
	//$cs_theme_option = get_option('cs_theme_option');
	
	global $cs_theme_option;
  	
	if ( isset($_POST['layout_option']) ) {
		echo $_SESSION['sess_layout_option'] = $_POST['layout_option'];
	}
	elseif ( isset($_SESSION['sess_layout_option']) and $_SESSION['sess_layout_option'] <> ''){
		echo $_SESSION['sess_layout_option'];
	}
	else {
		echo $cs_theme_option['layout_option'];
	}
}


/*
Dynamic Css styles changes by color switcher
*/
function cs_custom_styles() {
	$cs_theme_option = get_option('cs_theme_option');
	//global $cs_theme_option;
 
	if ( isset($_POST['heading_color']) ) {
		$_SESSION['sess_heading_color'] = $_POST['heading_color'];
		$heading_color_scheme = $_SESSION['sess_heading_color'];
	}
	elseif (isset($_SESSION['sess_heading_color']) and $_SESSION['sess_heading_color'] <> '') {
		 $heading_color_scheme = $_SESSION['sess_heading_color'];
	}
	else{
		$heading_color_scheme = $cs_theme_option['heading_color_scheme'];
	}

  	if ( isset($_POST['style_sheet']) ) {
		$_SESSION['sess_style_sheet'] = $_POST['style_sheet'];
		$cs_color_scheme = $_SESSION['sess_style_sheet'];
	}
	elseif (isset($_SESSION['sess_style_sheet']) and $_SESSION['sess_style_sheet'] <> '') {
		$cs_color_scheme = $_SESSION['sess_style_sheet'];
	}
	else{
		$cs_color_scheme = $cs_theme_option['custom_color_scheme'];
	}
	$cs_color_scheme = $cs_theme_option['custom_color_scheme'];
	//$cs_theme_option = get_option("cs_theme_option");
	//$cs_theme_option["custom_color_scheme"];
 ?>
	<style type="text/css">
	@charset "utf-8";
/* CSS Document */
.colr, .colrhover:hover, nav.navigation > ul > li:hover > a, .navigation > ul > li.current-menu-item > a, .our_services ul li.service-v3:hover i, .our_services ul li:hover h2,
.footnav ul li a:hover, .aboutus_page .team_info article:hover .text h4 a, .accordion-heading a.accordion-toggle.active,.accordion-heading a.accordion-toggle.active:before, .pagination ul li a.active, .our_services ul li.service-v4:hover i,
.pagination ul li:hover a, .widget_our_team .text .social-network a:hover, .text_widget .social-network > a:hover, .mainheaderseven .social-network > a:hover,
.blogdetail .element_size_25 p.bold, .for_o_for  h1, .share_btn:hover a, .share_btn:hover i, #main .text_widget .information, #main .text_widget .information a,
#main .text_widget ul li p, #main .text_widget ul li p i, .portfoliopage article:hover .text p, .portfoliopage article:hover .text p a, .portfoliopage article:hover .text span a,
.portfoliopage article:hover .text p i, .viewproject ul li p a:hover, .post-options li a:hover, .isotope-item article header h6 a:hover, .upcoming_event ul li a:hover,
.widget-twitter .tweets-wrapper a:hover, .post-media-attachments li:hover i, .prayer article:hover h4, .prayer .linking > a:hover, .prayer .linking > a:hover i,
.pray-this > div a:hover, .pray-this > div:hover i, .pray-this > div:hover a, .prayed:hover:hover, .prayed:hover:hover i, .comment-edit-link, .bolg_column article:hover header a,
.nav-tabs .active a, .team-shortcode article .social-network > a:hover, .team-shortcode article.team-v2:hover h6 a, .price-style3 article h1, .price-style3 article h1 small,
.pray-this div:hover, .mainheaderthree .login_nav ul li.current_page_item > a, .mainheaderthree .login_nav ul li a:hover, .mainheaderseven .top-nav ul li:hover > a, .mainheaderseven .login_nav ul li:hover > a,
.pagination li.next:hover span, .pagination li.prev:hover span {color:<?php echo $cs_color_scheme ?> !important;}

.pagination ul li:first-child:hover:after{ color:<?php echo $cs_color_scheme ?> !important; }
.pagination ul li:last-child:hover:after{ color:<?php echo $cs_color_scheme ?> !important; }

.backcolr, .backcolrhover:hover, .login_nav ul li a:hover, .navigation ul ul a:hover, .navigation ul ul ul a:hover, .navigation ul ul li:hover > a, .our_services ul li:hover a,
.filter_nav ul li a:hover, .tiny-green div, .price-style1 article.active h1, .price-style1 article.active .readmore, .story_text:after, .blog-large article:hover time, .blog-medium article:hover time,
.aboutus_page .team_info article:hover .social-network, .flex-direction-nav a:hover, .search-results article:hover time,
.widget_categories ul li:hover, .tagcloud a:hover, .archive article:hover time, blockquote:after, .gallerysec ul li figcaption, .circle_lock, .countdownit span.countdown_section, .eventlist article:before,
.eventdetail .eventcont ul li .countdownit, .portfoliopage article figure figcaption, .typo p:first-letter, .testimonial:after, .table-hover tbody tr:hover > td, .team-shortcode article.team-v2:hover .social-network,
.table-hover tbody tr:hover > th,.filter_nav ul li.active a,.widget_archive ul li:hover, #wp-calendar caption, #wp-calendar tbody td a, #wp-calendar tfoot a, .tables-code tr:hover td,
.widget_nav_menu ul li a:hover, .widget_pages ul li a:hover, .widget_links ul li:hover, .widget_meta ul li:hover, .widget_recent_entries ul li:hover, .dropcap:first-letter, .dropcap p:first-letter,
.widget_recent_comments ul li:hover, .footer_form p input[type="submit"], .form-submit input, .comment-reply-link, .login_nav ul li.current_page_item > a, .messagebox.simple i, .toggle-sectn a:after,
.eventdetail .countdownit, .post-media-attachments > li:before, .login_nav ul li.current-menu-item > a, .prayer_count div, .archive .blog_text .post-thumb time:hover, .search-results .blog_text .post-thumb time:hover,
.toggle-sectn .collapse.in:before, .our_services ul li.service-v1:hover i, .our_services ul li.service-v2:hover i, .price-style3 article.active h5, .price-style2 article.active h1,
.bolg_column article:hover .featured, .home .testimonial-shortcode:after, .wpcf7 form p input[type="submit"], .dropcap:first-letter, .dropcap p:first-letter
{background-color:<?php echo $cs_color_scheme ?> !important;}

.bordercolr, .bordercolrhover:hover, textarea:focus,input[type="text"]:focus,input[type="password"]:focus,input[type="datetime"]:focus, .prayer .linking > a:before, .pray-this > div:before,
input[type="datetime-local"]:focus,input[type="date"]:focus,input[type="month"]:focus,input[type="time"]:focus,input[type="week"]:focus,input[type="number"]:focus, .prayed:hover:before,
input[type="email"]:focus,input[type="url"]:focus,input[type="search"]:focus,input[type="tel"]:focus,input[type="color"]:focus,.uneditable-input:focus, .navigation ul li:after, .share_link input:focus,
.nav-tabs > .active > a:before, .mainheaderthree, .mainheaderseven .login_nav li a {border-color:<?php echo $cs_color_scheme ?> !important;}

.search-box:before
{border-color:transparent <?php echo $cs_color_scheme ?> !important;}
.copyright p,.footnav ul li a,.copyright p a{
	color:<?php echo $cs_theme_option['footer_text_color']; ?> !important;
}

#wrappermain-pix .heading-color,#myModal .heading-color{
	color:<?php  echo $heading_color_scheme;?> !important;
}

</style>
<?php 
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
			'before_title' => ' <header class="widget_tittle"><h2 class="section-title heading-color">',
			'after_title' => '</h2></header>'
		));
	}
}
// custom sidebar end
//footer widget
register_sidebar( array(
	'name' => 'Footer Widget',
	'id' => 'footer-widget',
	'description' => 'This Widget Show the Content in Footer Area.',
	'before_widget' => '<div class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => ' <header class="widget_tittle"><h2 class="section-title heading-color">',
	'after_title' => '</h2></header>'
) );

function cs_add_menuid($ulid) {
	return preg_replace('/<ul>/', '<ul id="menus">', $ulid, 1);
}
add_filter('wp_page_menu','cs_add_menuid');
function cs_remove_div ( $menu ){
    return preg_replace( array( '#^<div[^>]*>#', '#</div>$#' ), '', $menu );
}
add_filter( 'wp_page_menu', 'cs_remove_div' );
function cs_register_my_menus() {
  register_nav_menus(
	array(
		'main-menu'  => __('Main Menu','OneLife'),
		'top-menu'  => __('Top Menu','OneLife'),
		'footer-menu'  => __('Footer Menu','OneLife')
 	)
  );
}
add_action( 'init', 'cs_register_my_menus' );

add_filter('nav_menu_css_class', 'cs_add_parent_css', 10, 2);
function cs_add_parent_css($classes, $item) {
    global $cs_menu_children;
    if ($cs_menu_children)
        $classes[] = 'parent';
    return $classes;
}
// adding custom images while uploading media start
add_image_size('cs_media_1', 1170, 487, true);
add_image_size('cs_media_2', 870, 489, true);
add_image_size('cs_media_3', 570, 428, true);
add_image_size('cs_media_4', 301, 169, true);
add_image_size('cs_media_5', 370, 278, true);
// adding custom images while uploading media end

If (!function_exists('PixFill_comment')) :
     /**
     * Template for comments and pingbacks.
     *
     * To override this walker in a child theme without modifying the comments template
     * simply create your own PixFill_comment(), and that function will be used instead.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     *
     */
	function PixFill_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	$args['reply_text'] = __('', 'OneLife');
 	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <div class="thumblist" id="comment-<?php comment_ID(); ?>">
            <ul>
                <li>
                    <figure>
                        <a href="#"><?php echo get_avatar( $comment, 57 ); ?></a>
                    </figure>
                    <div class="text">
                         <header>
                            <?php printf( __( '%s', 'OneLife' ), sprintf( '<h6><a class="colrhover">%s</a></h6>', get_comment_author_link() ) ); ?>
                            <?php
                            	/* translators: 1: date, 2: time */
                                printf( __( '<time>%1$s</time>', 'OneLife' ), get_comment_date()); ?>
							<?php edit_comment_link( __( '(Edit)', 'OneLife' ), ' ' );?>
                            <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                            <?php if ( $comment->comment_approved == '0' ) : ?>
                                <div class="comment-awaiting-moderation colr"><?php _e( 'Your comment is awaiting moderation.', 'OneLife' ); ?></div>
                            <?php endif; ?>
                      </header>
                    
                      <?php comment_text(); ?>
                      
                     
                    </div>
                </li>
            </ul>
        </div>
	<?php
		break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'OneLife' ), ' ' ); ?></p>
	<?php
		break;
		endswitch;
	}
 	endif;
// password protect post/page
if ( ! function_exists( 'cs_password_form' ) ) {
	function cs_password_form() {
		global $post,$cs_theme_option;
		$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
		$o = '<div class="password_protected">
				<div class="passwor_outer">
					<div class="circle_lock">
						<i class="icon-lock">
						</i>
					</div>
				<div class="password_text">
				<p>' . __( "This post is password protected. To view it please enter your password below:",'OneLife' ) . '</p>';
		
		$o .= '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
						<input name="post_password" id="' . $label . '" type="password" size="20" placeholder="'.__("Password:", "OneLife").'" />
						<button class="btn" name="submit"><i class="icon-unlock-alt"></i></button>
					</form>
				</div>
				</div>
			</div>';
		return $o;
	}
}
add_filter( 'the_password_form', 'cs_password_form' );

// breadcrumb function
if ( ! function_exists( 'cs_breadcrumbs' ) ) { 
	function cs_breadcrumbs() {
		
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
	
		global $post,$wp_query;
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
					if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
				} else {
					$cat = get_the_category(); $cat = $cat[0];
					$cats = get_category_parents($cat, TRUE, $delimiter);
					if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
					$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
					$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
					echo $cats;
					if ($showCurrent == 1) echo $before . get_the_title() . $after;
				}
			} elseif ( !is_single() && !is_page() && get_post_type() <> '' && get_post_type() != 'post' && get_post_type() <> 'events' && get_post_type() <> 'portfolio' && !is_404() ) {
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
			if ( get_query_var('paged') ) {
				// if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
				// echo __('Page') . ' ' . get_query_var('paged');
				// if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
			}
			echo '</ul></div>';
	
		}
	}
} 
if ( ! function_exists( 'cs_logo' ) ) {
	function cs_logo($logo_url, $log_width, $logo_height){
	?>
		<a href="<?php echo home_url(); ?>"><img src="<?php echo $logo_url; ?>"  style="width:<?php echo $log_width; ?>px; height:<?php echo $logo_height; ?>px" alt="<?php echo bloginfo('name'); ?>" /></a>
	 <?php
	}
}

/*
Under Construction logo Function
*/
function cs_uc_logo(){
	global $cs_theme_option;
	?>
	<a href="<?php echo home_url(); ?>"><img src="<?php echo $cs_theme_option['logo']; ?>"  style="width:<?php echo $cs_theme_option['logo_width']; ?>px; height:<?php echo $cs_theme_option['logo_height']; ?>px" alt="<?php echo bloginfo('name'); ?>" /></a>
 <?php
}
/*
Top and Main Navigation
*/
if ( ! function_exists( 'cs_navigation' ) ) {
	function cs_navigation($nav='', $menus = 'menus'){
		global $cs_theme_option;
		// Menu parameters	
		$defaults = array(
			'theme_location' => "$nav",
			'menu' => '',
			'container' => '',
			'container_class' => '',
			'container_id' => '',
			'menu_class' => '',
			'menu_id' => "$menus",
			'echo' => false,
			'fallback_cb' => 'wp_page_menu',
			'before' => '',
			'after' => '',
			'link_before' => '',
			'link_after' => '',
			'items_wrap' => '<ul id="%1$s">%3$s</ul>',
			'depth' => 0,
			'walker' => '',);
		echo do_shortcode(wp_nav_menu($defaults));
	}
}

/*
 * Ccustom Header Styles Top Strip
 */
if ( ! function_exists( 'cs_header_top_strip' ) ) {
	function cs_header_top_strip($top_strip_menu='', $header_social_icons='', $header_styles, $user_login) {
				global $cs_theme_option;
				?>
		        <?php 
					if($header_social_icons=='on'){
                            cs_social_network();
                        }
					
					 if(isset($top_strip_menu) && !empty($top_strip_menu)){?>
                              <div class="top-nav">
                                  <?php 
                                      cs_navigation($top_strip_menu, 'top_strip_menus'); 
                                  ?>
                              </div>
                    <?php } 
						if($user_login=='on'){
                            cs_login('User Login', 'Logout');
                        }?>
		<?php
		
	}
}


 // Header simple, toggle and custom Search at front end//
function cs_header_search($type='simple'){ ?>
    <!-- Search Start -->
        <div class="search"> <a class="icon-search icon-2"></a> 
          <!-- Search Box Start -->
          <div class="search-box">
          <form action="<?php echo home_url() ?>" id="searchform" method="get" role="search">
            	<input type="text" name="s" class="backcolr" value="<?php _e('Search for:', "OneLife"); ?>" onFocus="if (this.value == '<?php _e('Search for:', "OneLife"); ?>') { this.value = ''; }"
                                           onblur="if (this.value == '') { this.value = '<?php _e('Search for:', "OneLife"); ?>'; }">
          </form>
          </div>
          <!-- Search Box End --> 
        </div>
        <!-- Search End -->
<?php
}
function cs_header_search_box($type='simple'){ ?>
    <!-- Search Start -->
        <div class="search"> <a class="icon-search icon-2"></a> 
          	<!-- Search Box Start -->
          	<div class="search-box">
	          	<form action="<?php echo home_url() ?>" id="searchform" method="get" role="search">
	            	<input type="text" name="s" value="<?php _e('Search for:', "OneLife"); ?>" onFocus="if (this.value == '<?php _e('Search for:', "OneLife"); ?>') { this.value = ''; }" onblur="if (this.value == '') { this.value = '<?php _e('Search for:', "OneLife"); ?>'; }">
	            	<label>
	            		<i class="icon-search"></i>
	            		<input type="submit" class="backcolr" value="<?php _e('Submit', "OneLife"); ?>" />
	            	</label>
	          	</form>
          	</div>
          	<!-- Search Box End --> 
        </div>
        <!-- Search End -->
<?php
}


/*
* Login Model Window function
*/
if ( ! function_exists( 'cs__box_login' ) ) {
	function cs_box_login($login='', $logout='', $header_style=''){ 
	?>
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!-- Modal Header Start -->
    <div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true" /><i class="icon-remove-sign"></i></button>
        <h2 id="myModalLabel" class="colr uppercase heading-color"><?php _e('Log In','OneLife');?></h2>
    </div>
    <!-- Modal Header End -->
    <!-- Modal Body Start -->
    <form class="webkit" action="<?php echo home_url(); ?>/wp-login.php" method="post">
    <div class="modal-body">
        <p>
        <input name="log" id="searchinput" value="<?php _e('Username','OneLife'); ?>" onfocus="if(this.value=='<?php _e('Username','OneLife'); ?>') {this.value='';}" onblur="if(this.value=='') {this.value='<?php _e('Username','OneLife'); ?>';}" type="text" />
		</p>
        <p class="password">
        <input name="pwd" id="searchinput" value="Password"
        onFocus="if(this.value=='Password') {this.value='';}"
        onblur="if(this.value=='') {this.value='Password';}" type="password" /></p>
        <input type="hidden" name="redirect_to" value="http://<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']?>" />                                        
        <a class="colrhover" href="<?php echo home_url() ; ?>/wp-login.php?action=lostpassword" > <label class="colrhover"><i class="icon-info-sign"></i><?php _e('Lost Password','OneLife'); ?>?</label></a>
    </div>
    <!-- Modal Body End -->
    <!-- Modal Footer Start -->
    <div class="modal-footer">
    	<input class="backcolr" type="submit" value="<?php _e('Log In','OneLife');?>" />
        <?php if ( get_option("users_can_register") == 1 and !is_user_logged_in() ) { ?>
        	<p class="uppercase"><a href="<?php echo home_url() ; ?>/wp-login.php?action=register" class="colrhover"><?php _e('Signup','OneLife');?></a></p>
        <?php }?>
    </div>
    <!-- Modal Footer End -->
</div>
<?php
	}
}
/*
* Login function
*/
if ( ! function_exists( 'cs_login' ) ) {
	function cs_login($login='', $logout='', $header_style=''){ 
 		?>
			<div class="login_nav login-section">
				<ul>
					<?php  
						if ( is_user_logged_in() ) { ?>
							<li><a class="logout" href="<?php echo wp_logout_url("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>">
								<?php 
                                if($logout == true && $header_style=='header6')
                                    {
                                        echo '<span>';
                                         _e('Log out', 'OneLife');
                                         echo '</span>';
                                    } else if($logout == true  && $header_style==''){
                                        _e('Log out', 'OneLife');
                                    }
                                ?>
	                            <i class="icon-signout"></i></a></li>
					<?php }else{?>
                   
							 <li><a href="#myModal" class="backcolrhover active" role="button" data-toggle="modal">
							 	<?php 
									if($login == true && $header_style=='header6')
										{
											echo '<span>';
											 _e('Log In', 'OneLife');
											 echo '</span>';
										} else if($login == true  && $header_style==''){
											_e('Log In', 'OneLife');
										}
								?>
							 	<i class="icon-user"></i></a>
                             </li>
					<?php } ?>
				</ul>
			</div>
	  
		<?php 
	}
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
		<div class="bottom_strip">
				<div class="container">
					<div class="logo">
						<?php if($cs_theme_option['showlogo'] == "on"){ cs_uc_logo(); } ?>
					</div>
				</div>
			</div>
		<div id="undercontruction">
            <div id="midarea">
                    <?php echo '<p>'.htmlspecialchars_decode($cs_theme_option['under_construction_text']).'</p>';
                         $launch_date = $cs_theme_option['launch_date'];
                         $year = date("Y", strtotime($launch_date));
                         $month = date("m", strtotime($launch_date));
                         $month_event_c = date("M", strtotime($launch_date));							
                         $day = date("d", strtotime($launch_date));
                         $time_left = date("H,i,s", strtotime($launch_date));
                         $current_gtm = get_option('gmt_offset');
                        
                    ?>
                    <link rel='stylesheet' href='<?php echo get_template_directory_uri(); ?>/css/contdown.css' type='text/css' media='all' />
                    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/frontend/jquery.countdown.js"></script>
                    <script type="text/javascript">
                            jQuery(function($) {
                                var austDay = new Date();
                                austDay = new Date(<?php echo $year; ?>, <?php echo $month; ?> - 1, <?php echo $day; ?>,<?php echo $time_left ?>);
                                console.log(austDay);
                                $('#defaultCountdown<?php echo get_the_id(); ?>').countdown({timezone: <?php echo $current_gtm; ?>, until: austDay});
                                $('#year').text(austDay.getFullYear());
                            });
                        </script>
                        <div class="countdownit">
                            <div id="defaultCountdown<?php echo get_the_id(); ?>"></div>
                        </div>
                    
                </div>
		</div>
		
		<!-- Footer Start -->
    <footer style=" <?php if(isset($cs_theme_option['footer_bg_img']) && $cs_theme_option['footer_bg_img'] <> ''){?>background: url(<?php echo $cs_theme_option['footer_bg_img'].') ';} if(isset($cs_theme_option['footer_bg_color']) && $cs_theme_option['footer_bg_color'] <> ''){?>background-color: <?php echo $cs_theme_option['footer_bg_color'].' !important;';}?>">
    <!-- Container Start -->
    <div class="container"> 
      <!-- Bottom Footer Start -->
      <div class="bottom-footer"> 
        <div class="copyright">
          <p><?php echo htmlspecialchars_decode($cs_theme_option['copyright']); ?> <?php echo htmlspecialchars_decode($cs_theme_option['powered_by']); ?></p>
        	<?php if($cs_theme_option['socialnetwork'] == "on"){  
					cs_social_network();
					
						} ?> 
        </div>
      </div>
      <!-- Bottom Footer End --> 
    </div>
    <!-- Container End --> 
  </footer>
		
		<!-- Footer End -->        

	 <?php die();
	 }
	}
} 
// widget start
// widget_facebook start
class facebook_module extends WP_Widget
{
  function facebook_module()
  {
		$widget_ops = array('classname' => 'facebok_widget', 'description' => 'Facebook widget like box total customized with theme.' );
		$this->WP_Widget('facebook_module', 'CS : Facebook', $widget_ops);
  }
  function form($instance)
  {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = $instance['title'];
		$pageurl = isset( $instance['pageurl'] ) ? esc_attr( $instance['pageurl'] ) : '';
		$showfaces = isset( $instance['showfaces'] ) ? esc_attr( $instance['showfaces'] ) : '';
		$showstream = isset( $instance['showstream'] ) ? esc_attr( $instance['showstream'] ) : '';
		$showheader = isset( $instance['showheader'] ) ? esc_attr( $instance['showheader'] ) : '';
		$fb_bg_color = isset( $instance['fb_bg_color'] ) ? esc_attr( $instance['fb_bg_color'] ) : '';
		//$likebox_width = isset( $instance['likebox_width'] ) ? esc_attr( $instance['likebox_width'] ) : '';
		$likebox_height = isset( $instance['likebox_height'] ) ? esc_attr( $instance['likebox_height'] ) : '';						
	?>
	  <p>
	  <label for="<?php echo $this->get_field_id('title'); ?>">
		  Title: 
		  <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size='40' name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
	  </label>
	  </p> 
	  <p>
	  <label for="<?php echo $this->get_field_id('pageurl'); ?>">
		  Page URL: 
		  <input class="upcoming" id="<?php echo $this->get_field_id('pageurl'); ?>" size='40' name="<?php echo $this->get_field_name('pageurl'); ?>" type="text" value="<?php echo esc_attr($pageurl); ?>" />
		<br />
		  <small>Please enter your page or User profile url example: http://www.facebook.com/profilename OR <br />
		  https://www.facebook.com/pages/wxyz/123456789101112
		</small><br />
		<!--<strong>Only People Will Be Shown Please Use Height to Manage Your View.</strong>-->
	  </label>
	  </p> 
	  <p>
 	  <label for="<?php echo $this->get_field_id('showfaces'); ?>">
		  Show Faces: 
		  <input class="upcoming" id="<?php echo $this->get_field_id('showfaces'); ?>" name="<?php echo $this->get_field_name('showfaces'); ?>" type="checkbox" <?php if(esc_attr($showfaces) != '' ){echo 'checked';}?> />
	  </label>
	  </p> 
	  <p>
	  <label for="<?php echo $this->get_field_id('showstream'); ?>">
		  Show Stream: 
		  <input class="upcoming" id="<?php echo $this->get_field_id('showstream'); ?>" name="<?php echo $this->get_field_name('showstream'); ?>" type="checkbox" <?php if(esc_attr($showstream) != '' ){echo 'checked';}?> />
	  </label>
	  </p> 
	  <!--<p>
	  <label for="<?php echo $this->get_field_id('likebox_width'); ?>">
		  Like Box Width:
		  <input class="upcoming" id="<?php echo $this->get_field_id('likebox_width'); ?>" size='5' name="<?php echo $this->get_field_name('likebox_width'); ?>" type="text" value="<?php echo esc_attr($likebox_width); ?>" />
	  </label>
	  </p>-->
	  <p>
	  <label for="<?php echo $this->get_field_id('likebox_height'); ?>">
		  Like Box Height:
		  <input class="upcoming" id="<?php echo $this->get_field_id('likebox_height'); ?>" size='2' name="<?php echo $this->get_field_name('likebox_height'); ?>" type="text" value="<?php echo esc_attr($likebox_height); ?>" />
	  </label>
	  </p>
      <p>		
     <label for="<?php echo $this->get_field_id('fb_bg_color'); ?>">
     	Background Color:
  		<input type="text" name="<?php echo $this->get_field_name('fb_bg_color'); ?>" size='4' id="<?php echo $this->get_field_id('fb_bg_color'); ?>"  value="<?php if(!empty($fb_bg_color)){ echo $fb_bg_color;}else{ echo "#fff";}; ?>" class="fb_bg_color upcoming"  />
    </label>
    </p>
	<?php
	  }
	  function update($new_instance, $old_instance)
	  {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['pageurl'] = $new_instance['pageurl'];
		$instance['showfaces'] = $new_instance['showfaces'];	
		$instance['showstream'] = $new_instance['showstream'];
		$instance['showheader'] = $new_instance['showheader'];
		$instance['fb_bg_color'] = $new_instance['fb_bg_color'];		
		//$instance['likebox_width'] = $new_instance['likebox_width'];
		$instance['likebox_height'] = $new_instance['likebox_height'];			
		return $instance;
	  }
		function widget($args, $instance)
		{
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
			$pageurl = empty($instance['pageurl']) ? ' ' : apply_filters('widget_title', $instance['pageurl']);
			$showfaces = empty($instance['showfaces']) ? ' ' : apply_filters('widget_title', $instance['showfaces']);
			$showstream = empty($instance['showstream']) ? ' ' : apply_filters('widget_title', $instance['showstream']);
			$showheader = empty($instance['showheader']) ? ' ' : apply_filters('widget_title', $instance['showheader']);
			$fb_bg_color = empty($instance['fb_bg_color']) ? ' ' : apply_filters('widget_title', $instance['fb_bg_color']);								
			//$likebox_width = empty($instance['likebox_width']) ? ' ' : apply_filters('widget_title', $instance['likebox_width']);								
			$likebox_height = empty($instance['likebox_height']) ? ' ' : apply_filters('widget_title', $instance['likebox_height']);													
			if(isset($showfaces) AND $showfaces == 'on'){$showfaces ='true';}else{$showfaces = 'false';}
			if(isset($showstream) AND $showstream == 'on'){$showstream ='true';}else{$showstream ='false';}
			
			echo $before_widget;	
			// WIDGET display CODE Start
			if (!empty($title) && $title <> ' '){
				echo $before_title;
				echo $title;
				echo $after_title;
			}
				global $wpdb, $post;?>
				<style type="text/css" scoped="scoped">
					.facebookOuter {
						background-color:<?php echo $fb_bg_color ?>; 
						width:100%; 
						padding:0;
						float:left;
					}
					.facebookInner {
						float: left;
						width: 100%;
					}
					.facebook_module, .fb_iframe_widget > span, .fb_iframe_widget > span > iframe {
					 width: 100% !important;
					}
					.fb_iframe_widget, .fb-like-box div span iframe {
					 width: 100% !important;
					 float: left;
					}
				</style>
				<div class="facebook">
					<div class="facebookOuter">
				 <div class="facebookInner">
				  <div class="fb-like-box" 
					  colorscheme="light" data-height="<?php echo $likebox_height;?>"  data-width="190" 
					  data-href="<?php echo $pageurl;?>" 
					  data-border-color="#fff" data-show-faces="<?php echo $showfaces;?>"  data-show-border="false"
					  data-stream="<?php echo $showstream;?>" data-header="false">
				  </div>          
				 </div>
				</div>
				</div>
 				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
				</script>
		<?php echo $after_widget;
			}
			
		}
	add_action( 'widgets_init', create_function('', 'return register_widget("facebook_module");') );
	// widget_facebook end
	
	// widget_gallery start
	class cs_gallery extends WP_Widget {
	
		function cs_gallery() {
			$widget_ops = array('classname' => 'widget_gallery', 'description' => 'Select any gallery to show in widget.');
			$this->WP_Widget('cs_gallery', 'CS : Gallery Widget', $widget_ops);
		}
	
		function form($instance) {
			$instance = wp_parse_args((array) $instance, array('title' => '', 'get_names_gallery' => 'new'));
			$title = $instance['title'];
			$get_names_gallery = isset($instance['get_names_gallery']) ? esc_attr($instance['get_names_gallery']) : '';
			$showcount = isset($instance['showcount']) ? esc_attr($instance['showcount']) : '';
			?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>">
					Title: 
					<input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
				</label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('get_names_gallery'); ?>">
					Select Gallery:
					<select id="<?php echo $this->get_field_id('get_names_gallery'); ?>" name="<?php echo $this->get_field_name('get_names_gallery'); ?>" style="width:225px;">
						<?php
						global $wpdb, $post;
						$newpost = 'posts_per_page=-1&post_type=cs_gallery&order=ASC&post_status=publish';
						$newquery = new WP_Query($newpost);
						while ($newquery->have_posts()): $newquery->the_post();
							?>
							<option <?php
							if (esc_attr($get_names_gallery) == $post->post_name) {
								echo 'selected';
							}
							?> value="<?php echo $post->post_name; ?>" >
							<?php echo substr(get_the_title($post->ID), 0, 20);
							if (strlen(get_the_title($post->ID)) > 20)
								echo "...";
							?>
							</option>						
						<?php endwhile; ?>
					</select>
				</label>
			</p>  
			 
			<p>
				<label for="<?php echo $this->get_field_id('showcount'); ?>">
					Number of Images: 
					<input class="upcoming" id="<?php echo $this->get_field_id('showcount'); ?>" size="2" name="<?php echo $this->get_field_name('showcount'); ?>" type="text" value="<?php echo esc_attr($showcount); ?>" />
				</label>
			</p>  
			<?php
		}
	
		function update($new_instance, $old_instance) {

			$instance = $old_instance;
			$instance['title'] = $new_instance['title'];
			$instance['get_names_gallery'] = $new_instance['get_names_gallery'];
			$instance['showcount'] = $new_instance['showcount'];
  			return $instance;
		}
	
		function widget($args, $instance) {
			extract($args, EXTR_SKIP);
			global $wpdb, $post;
			$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
			$get_names_gallery = isset($instance['get_names_gallery']) ? esc_attr($instance['get_names_gallery']) : '';
			$showcount = isset($instance['showcount']) ? esc_attr($instance['showcount']) : '';
			if (empty($showcount)) {
				 $showcount = '12';
			}
			
			// WIDGET display CODE Start
			echo $before_widget;
			if (strlen($get_names_gallery) <> 1 || strlen($get_names_gallery) <> 0) {
				echo $before_title . $title . $after_title;
			}
 			if ($get_names_gallery <> '') {
 				// galery slug to id start
				$get_gallery_id = '';
				$args=array(
					'name' => $get_names_gallery,
					'post_type' => 'cs_gallery',
					'post_status' => 'publish',
					'showposts' => 1,
				);
				$get_posts = get_posts($args);
 				if($get_posts){
					$get_gallery_id = $get_posts[0]->ID;
				}
				// galery slug to id end
				if($get_gallery_id <> ''){
				$cs_meta_gallery_options = get_post_meta($get_gallery_id, "cs_meta_gallery_options", true);
				if ($cs_meta_gallery_options <> "") {
					$cs_xmlObject = new SimpleXMLElement($cs_meta_gallery_options);
					if ($showcount > count($cs_xmlObject)) {
						$showcount = count($cs_xmlObject);
					}
				?>
				<ul class="gallery-list lightbox">
					<?php
						cs_enqueue_gallery_style_script();
 						for ($i = 0; $i < $showcount; $i++) {
							$path = $cs_xmlObject->gallery[$i]->path;
							$title = $cs_xmlObject->gallery[$i]->title;
							$description = $cs_xmlObject->gallery[$i]->description;
							$social_network = $cs_xmlObject->gallery[$i]->social_network;
							$use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;
							$video_code = $cs_xmlObject->gallery[$i]->video_code;
							$link_url = $cs_xmlObject->gallery[$i]->link_url;
							$image_url = cs_attachment_image_src($path, 60, 60);
							$image_url_full = cs_attachment_image_src($path, 0, 0);
						?>
						 <li>
							<?php echo "<img width='60' height='60' src='" . $image_url . "' data-alt='" . $title . "' alt='' />" ?><a <?php if ( $description <> '' ) { echo 'data-title="'.$description.'"'; }?> href="<?php if ($use_image_as == 1)echo $video_code;  elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" target="<?php if($use_image_as==2){ echo '_blank'; }else{ echo '_self'; }; ?>" class="link" data-rel="<?php if ($use_image_as == 1) echo "prettyPhoto"; elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>"><img src="" alt="" data-alt="<?php echo $title; ?>" /></a>
						</li>
				<?php } ?>
				</ul>
			 <?php }}else{
				 echo '<h4>'.__( 'No results found.', 'OneLife' ).'</h4>';
				 }}     // endif of Category Selection?>
				
			 <?php
 			echo $after_widget; // WIDGET display CODE End
		}
	
	}
	
	add_action('widgets_init', create_function('', 'return register_widget("cs_gallery");'));
	// widget_gallery end
	// widget_recent_post start
	class recentposts extends WP_Widget
	{
	  function recentposts()
	  {
		$widget_ops = array('classname' => 'recent_blog', 'description' => 'Recent Posts from category.' );
		$this->WP_Widget('recentposts', 'CS : Recent Posts', $widget_ops);
	  }
	 
	  function form($instance)
	  {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = $instance['title'];
		$select_category = isset( $instance['select_category'] ) ? esc_attr( $instance['select_category'] ) : '';
		$showcount = isset( $instance['showcount'] ) ? esc_attr( $instance['showcount'] ) : '';	
		
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">
				Title: 
				<input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</label>
		</p> 
		<p>
			<label for="<?php echo $this->get_field_id('select_category'); ?>">
			  Select Category:            
			  <select id="<?php echo $this->get_field_id('select_category'); ?>" name="<?php echo $this->get_field_name('select_category'); ?>" style="width:225px">
				<?php
				$categories = get_categories();
					if($categories <> ""){
						foreach ( $categories as $category ) {?>
							<option <?php if($select_category == $category->slug){echo 'selected';}?> value="<?php echo $category->slug;?>" ><?php echo $category->name;?></option>						
						<?php }?>
					<?php }?>            
			  </select>
			</label>
		</p>  
		<p>
			<label for="<?php echo $this->get_field_id('showcount'); ?>">
				Number of Posts To Display:
				<input class="upcoming" id="<?php echo $this->get_field_id('showcount'); ?>" size='2' name="<?php echo $this->get_field_name('showcount'); ?>" type="text" value="<?php echo esc_attr($showcount); ?>" />
			</label>
		</p>
		
	<?php
	  }
	 
	  function update($new_instance, $old_instance)
	  {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['select_category'] = $new_instance['select_category'];
		$instance['showcount'] = $new_instance['showcount'];
		return $instance;
	  }
	 
		function widget($args, $instance)
		{
			global $cs_node, $wpdb, $post;;
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
			$select_category = empty($instance['select_category']) ? ' ' : apply_filters('widget_title', $instance['select_category']);		
			$showcount = empty($instance['showcount']) ? ' ' : apply_filters('widget_title', $instance['showcount']);	
								
			$i=0;
			if($instance['showcount'] == ""){$instance['showcount'] = '-1';}
			echo $before_widget;	
			// WIDGET display CODE Start
			if (!empty($title) && $title <> ' '){
				echo $before_title;
				echo $title;
				echo $after_title;
			}?>
				<!-- Recent Posts Start -->
 						<?php
							wp_reset_query();
							$args = array( 'posts_per_page' => "$showcount",'post_type' => 'post','category_name' => "$select_category"); 
							$custom_query = new WP_Query($args);
							if ( $custom_query->have_posts() <> "" ) {
								while ( $custom_query->have_posts()) : $custom_query->the_post();
								$i++;
								$post_xml = get_post_meta($post->ID, "post", true);	
								$cs_xmlObject = new stdClass();
								if ( $post_xml <> "" ) {
									$cs_xmlObject = new SimpleXMLElement($post_xml);
									$post_view = '';
									$post_view = $cs_xmlObject->post_thumb_view;
									$post_image = $cs_xmlObject->post_thumb_image;
									$post_video = $cs_xmlObject->post_thumb_video;
									$post_audio = $cs_xmlObject->post_thumb_audio;
									$post_slider = $cs_xmlObject->post_thumb_slider;
									$post_slider_type = $cs_xmlObject->post_thumb_slider_type;
 									$width 	= 370;
									$height = 208;
 									$image_url = cs_get_post_img_src($post->ID, $width, $height);
 									}
								?>
                                <article>
                                	<?php if($image_url <> '' && $i=='1'){?>
                                    <figure>
                                    	<?php
										 if ($post_view == "Map" and $post_view <> ''){
											$cs_node = new stdClass();
											$cs_node->map_lat = $cs_xmlObject->post_thumb_map_lat;
											$cs_node->map_lon = $cs_xmlObject->post_thumb_map_lon;
											$cs_node->map_zoom = $cs_xmlObject->post_thumb_map_zoom;
											$cs_node->map_address = $cs_xmlObject->post_thumb_map_address;
											$cs_node->map_controls = $cs_xmlObject->post_thumb_map_controls;
											$cs_node->map_height = $height;
											echo cs_map_page();
											
										}elseif( $post_view == "Slider" and $post_slider <> '' and $post_view <> ''){
											$cs_node = '';
											 cs_flex_slider($width,$height,$post_slider);
										}elseif($post_view == "Single Image" and $post_view <> ''){
											echo "<a href='".get_permalink()."' ><img src='".$image_url."' alt=''></a>";
										}elseif($post_view == "Video" and $post_view <> ''){
											$url = parse_url($post_video);
											if($url['host'] == $_SERVER["SERVER_NAME"]){?>
												<video width="100%" class="mejs-wmp" height="370" src="<?php echo $post_video ?>" id="player1" poster="<?php echo $image_url; ?>" controls="controls" preload="none"></video>
										<?php
											}else{
												echo wp_oembed_get($post_video,array('width'=>360,'height' => 370));
											}
										}elseif($post_view == "Audio" and $post_audio <> ''){
											?>
											<audio style="width:100%;" src="<?php echo $post_audio; ?>" controls="controls"></audio>
											<?php
										}
									?>
                                    </figure>
                                    <?php }?>
                                    <h6><a href="<?php the_permalink();?>" class="colrhover"><?php echo substr(get_the_title(),0,74); if ( strlen(get_the_title()) > 74) echo "..."; ?></a></h6>
                                    <time datetime="<?php echo get_the_date();?>"><?php echo get_the_date();?></time>
                                </article>
									<!-- Upcoming Widget Start -->
								<?php endwhile; wp_reset_query(); ?>
							<?php
                            }
							else {
								echo '<h4>'.__( 'No results found.', 'OneLife' ).'</h4>';
							}?>
  				<!-- Recent Posts End -->     
				<?php
				echo $after_widget;
			}
		}
		add_action( 'widgets_init', create_function('', 'return register_widget("recentposts");') );
	// widget_recent_post end
	// widget_twitter start
 	class twitter_widget extends WP_Widget {
		function twitter_widget() {
			$widget_ops = array('classname' => 'widget widget_newslatter widget-twitter', 'description' => 'twitter widget');
			$this->WP_Widget('twitter_widget', 'CS : Twitter Widget', $widget_ops);
		}
		function form($instance) {
			$instance = wp_parse_args((array) $instance, array('title' => ''));
			$title = $instance['title'];
			$username = isset($instance['username']) ? esc_attr($instance['username']) : '';
			$numoftweets = isset($instance['numoftweets']) ? esc_attr($instance['numoftweets']) : '';
 		?>
          	<label for="<?php echo $this->get_field_id('title'); ?>">
				<span>Title: </span>
				<input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</label>
			<label for="screen_name">User Name<span class="required">(*)</span>: </label>
				<input class="upcoming" id="<?php echo $this->get_field_id('username'); ?>" size="40" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo esc_attr($username); ?>" />
            <label for="tweet_count">
			<span>Num of Tweets: </span>
			<input class="upcoming" id="<?php echo $this->get_field_id('numoftweets'); ?>" size="2" name="<?php echo $this->get_field_name('numoftweets'); ?>" type="text" value="<?php echo esc_attr($numoftweets); ?>" />
			<div class="clear"></div>
			</label>
  		<?php
		}
	
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = $new_instance['title'];
			$instance['username'] = $new_instance['username'];
			$instance['numoftweets'] = $new_instance['numoftweets'];
			
 			return $instance;
		}
  		function widget($args, $instance) {
			global $cs_theme_option;
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
			$username = $instance['username'];
 			$numoftweets = $instance['numoftweets'];		
	 		if($numoftweets == ''){$numoftweets = 2;}
			echo $before_widget;
  			// WIDGET display CODE Start
			if (!empty($title) && $title <> ' '){
				echo $before_title . $title . $after_title;
			}
				
				if(strlen($username) > 1){
 						$return = '';
						$response = '';
						$exclude_replies = '0';
 						$include_rts = '0';
						$token = get_option( 'TWITTER_BEARER_TOKEN' );
 				
						if($token && $username) {
						$args = array(
							'httpversion' => '1.1',
							'blocking' => true,
							'headers' => array( 
								'Authorization' => "Bearer $token"
							)
						);
						add_filter('https_ssl_verify', '__return_false');
						$api_url = "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=$username&count=$numoftweets&exclude_replies=$exclude_replies&include_rts=$include_rts";
						
						$response = wp_remote_get( $api_url, $args );
						if(!is_wp_error($response) and $response <> ""){
						
						$tweets = json_decode($response['body']);
						
						$return .= "<div class='twitter_sign webkit'>
							<div class='tweets-wrapper'>
 						
						";
						foreach($tweets as $i => $tweet) {
							$text = $tweet->{'text'}; 
						
							foreach($tweet->{'entities'} as $type => $entity) {
								if($type == 'urls') {						
									foreach($entity as $j => $url) {
										$update_with = '<a href="' . $url->{'url'} . '" target="_blank" title="' . $url->{'expanded_url'} . '">' . $url->{'display_url'} . '</a>';
										$text = str_replace($url->{'url'}, $update_with, $text);
									}
								} else if($type == 'hashtags') {
									foreach($entity as $j => $hashtag) {
										$update_with = '<a href="https://twitter.com/search?q=%23' . $hashtag->{'text'} . '&src=hash" target="_blank" title="' . $hashtag->{'text'} . '">#' . $hashtag->{'text'} . '</a>';
										$text = str_replace('#'.$hashtag->{'text'}, $update_with, $text);
									}
								} else if($type == 'user_mentions') {
									foreach($entity as $j => $user) {
										$update_with = '<a href="https://twitter.com/' . $user->{'screen_name'} . '" target="_blank" title="' . $user->{'name'} . '">@' . $user->{'screen_name'} . '</a>';
										$text = str_replace('@'.$user->{'screen_name'}, $update_with, $text);
									}
								}					
							}
							$large_ts = time();
							$n = $large_ts - strtotime($tweet->{'created_at'});
							if($n < (60)){ $posted = sprintf(__('%d seconds ago','OneLife'),$n); }
							elseif($n < (60*60)) { $minutes = round($n/60); $posted = sprintf(_n('About a Minute Ago','%d Minutes Ago',$minutes,'OneLife'),$minutes); }
							elseif($n < (60*60*16)) { $hours = round($n/(60*60)); $posted = sprintf(_n('About an Hour Ago','%d Hours Ago',$hours,'OneLife'),$hours); }
							elseif($n < (60*60*24)) { $hours = round($n/(60*60)); $posted = sprintf(_n('About an Hour Ago','%d Hours Ago',$hours,'OneLife'),$hours); }
							elseif($n < (60*60*24*6.5)) { $days = round($n/(60*60*24)); $posted = sprintf(_n('About a Day Ago','%d Days Ago',$days,'OneLife'),$days); }
							elseif($n < (60*60*24*7*3.5)) { $weeks = round($n/(60*60*24*7)); $posted = sprintf(_n('About a Week Ago','%d Weeks Ago',$weeks,'OneLife'),$weeks); } 
							elseif($n < (60*60*24*7*4*11.5)) { $months = round($n/(60*60*24*7*4)) ; $posted = sprintf(_n('About a Month Ago','%d Months Ago',$months,'OneLife'),$months);}
							elseif($n >= (60*60*24*7*4*12)){$years=round($n/(60*60*24*7*52)) ; $posted = sprintf(_n('About a year Ago','%d years Ago',$years,'OneLife'),$years);} 
							$user = $tweet->{'user'};
							$return .="<div id='tweet-1' class='tweet webkit'>";
							$return .= "<h6>" . $text . "</h6>";
 							$return .= "<p><a class='hour colrhover'>" . $posted. "</a></p>";
							$return .="</div>";
					}
 					$return .= "</div><a href='".$username."' class='colrhover'><i class='icon-twitter icon-2x'></i><p class='twitter-follow'>".$cs_theme_option['trans_follow_twitter']."</p></a><div class='clear'></div></div>";
					echo $return;
				}
			}else{
				if($response <> ""){
					echo $response->errors['http_failure'][0];
				}else{
					_e( 'No results found.', 'OneLife' );	
				}
			}
   	 	}else{ 				
			//echo '<h4>No User information given.</h4>';
		}
		echo $after_widget;
		// WIDGET display CODE End
		}
 	}
 	add_action('widgets_init', create_function('', 'return register_widget("twitter_widget");'));
	
	// widget_twitter end

// widget end
/**
 * Archives widget class
 */
class chimp_Widget_Archives extends WP_Widget {

    function chimp_Widget_Archives() {
        $widget_ops = array('classname' => 'widget_archive', 'description' =>'A monthly archive Widget');
        $this->WP_Widget('chimp_archives', 'Archives', $widget_ops);
    }

    function widget($args, $instance) {
        global $wpdb, $wp_locale;
        $output = $selectbox = '';

        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? 'Archives' : $instance['title']);
        $count = $instance['count'];
        $dropdown = $instance['dropdown'];

        echo $before_widget;
        if (!empty($title) && $title <> ' '){
            echo $before_title . $title . $after_title;
		}
        $post_types = array('post', 'events','portfolio');

        // 
        $where = apply_filters('getarchives_where', "WHERE (post_type='post'|| post_type='events' ||  post_type = 'portfolio') AND post_status = 'publish'", '');
        $join = apply_filters('getarchives_join', "", '');
        $query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC";
        $key = md5($query);
        $cache = wp_cache_get('wp_get_archives', 'general');
        if (!isset($cache[$key])) {
            $arcresults = $wpdb->get_results($query);
            $cache[$key] = $arcresults;
            wp_cache_add('wp_get_archives', $cache, 'general');
        } else {
            $arcresults = $cache[$key];
        }
        if ($arcresults) {
            //$afterafter = $after;
            foreach ((array) $arcresults as $arcresult) {
                $url = get_month_link($arcresult->year, $arcresult->month);
                $text = sprintf(__('%1$s %2$d','OneLife'), $wp_locale->get_month($arcresult->month), $arcresult->year);

                if (isset($count) && $count <> '')
                    $text .= '&nbsp;(' . $arcresult->posts . ')';


                $output .= get_archives_link($url, $text, '', '<li>', '</li>');
                if (isset($dropdown) && $dropdown <> '') {
                    $selectbox.='<option value="' . $url . '">' . $text . '</option>';
                }
            }
        }

        if (isset($dropdown) && $dropdown <> '') {
            ?>
            <ul>
            	<li>
                    <select name="archive-dropdown" onchange='document.location.href = this.options[this.selectedIndex].value;'>
                        <option value=""><?php echo _e('Select Month',CSDOMAIN); ?></option>
                        <?php echo $selectbox; ?>
                    </select>
                 </li>
            </ul>
            <?php
        } else {
            echo '<ul>' . $output . '</ul>';
        }
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $new_instance = wp_parse_args((array) $new_instance, array('title' => '', 'count' => 0, 'dropdown' => ''));
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['count'] = $new_instance['count'] ? 1 : 0;
        $instance['dropdown'] = $new_instance['dropdown'] ? 1 : 0;

        return $instance;
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => '', 'count' => 0, 'dropdown' => ''));
        $title = strip_tags($instance['title']);
        $count = $instance['count'] ? 'checked="checked"' : '';
        $dropdown = $instance['dropdown'] ? 'checked="checked"' : '';
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>">Title:</label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
        <p>
            <input class="checkbox" type="checkbox" <?php echo $count; ?> id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" /> <label for="<?php echo $this->get_field_id('count'); ?>">Show post counts</label>
            <br />
            <input class="checkbox" type="checkbox" <?php echo $dropdown; ?> id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>" /> <label for="<?php echo $this->get_field_id('dropdown'); ?>">Display as a drop down</label>
        </p>
        <?php
    }

}  
// Event Widget

class upcoming_events extends WP_Widget
{
  function upcoming_events()
  {
    $widget_ops = array('classname' => 'upcoming_event', 'description' => 'Select Event to show its countdown.' );
    $this->WP_Widget('upcoming_events', 'CS : Upcoming Events', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ,'widget_names_events' =>'new') );
    $title = $instance['title'];
	$get_post_slug = isset( $instance['get_post_slug'] ) ? esc_attr( $instance['get_post_slug'] ) : '';
	$showcount = isset( $instance['showcount'] ) ? esc_attr( $instance['showcount'] ) : '';	
?>
  <p>
  <label for="<?php echo $this->get_field_id('title'); ?>">
	  Title: 
	  <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
  </p>
  <p>
  <label for="<?php echo $this->get_field_id('get_post_slug'); ?>">
	  Select Event:
	  <select id="<?php echo $this->get_field_id('get_post_slug'); ?>" name="<?php echo $this->get_field_name('get_post_slug'); ?>" style="width:225px">
      	<option value=""> Select Category</option>
		<?php
        global $wpdb,$post;
		$categories = get_categories('taxonomy=event-category&child_of=0&hide_empty=0'); 
			if($categories != ''){}
				foreach ( $categories as $category){ ?>
                    <option <?php if(esc_attr($get_post_slug) == $category->slug){echo 'selected';}?> value="<?php echo $category->slug;?>" >
	                    <?php echo substr($category->name, 0, 20);	if ( strlen($category->name) > 20 ) echo "...";?>
                    </option>						
			<?php }?>
      </select>
  </label>
  </p>  
  <p>
  <label for="<?php echo $this->get_field_id('showcount'); ?>">
	  Number of Events: 
	  <input class="upcoming" id="<?php echo $this->get_field_id('showcount'); ?>" size="2" name="<?php echo $this->get_field_name('showcount'); ?>" type="text" value="<?php echo esc_attr($showcount); ?>" />
  </label>
  </p>  
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
	$instance['get_post_slug'] = $new_instance['get_post_slug'];	
	$instance['showcount'] = $new_instance['showcount'];		
	
	
    return $instance;
  }
 
	function widget($args, $instance)
	{
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$get_post_slug = isset( $instance['get_post_slug'] ) ? esc_attr( $instance['get_post_slug'] ) : '';
		$showcount = isset( $instance['showcount'] ) ? esc_attr( $instance['showcount'] ) : '';		
		if(empty($showcount)){$showcount = '4';}
		// WIDGET display CODE Start
		echo $before_widget;	
		wp_reset_query();	
		if (!empty($title) && $title <> ' '){
			echo $before_title . $title . $after_title;
		}
			global $wpdb, $post;
 			//$term = get_term( $get_names_events, 'event-category' );
 			if($get_post_slug <> ''){
				$newterm = get_term_by('slug', $get_post_slug, 'event-category'); 
					$args = array(
						'posts_per_page'			=> $showcount,
						'post_type'					=> 'events',
						'event-category'			=> "$get_post_slug",
                        'post_status'				=> 'publish',
                        'meta_key'					=> 'cs_event_from_date',
                        'meta_value'				=> date('Y-m-d'),
                        'meta_compare'				=> ">=",
                        'orderby'					=> 'meta_value',
                        'order'						=> 'ASC'
 					);
                    $custom_query = new WP_Query($args);
					if ( $custom_query->have_posts() <> "" ) {
						?><ul><?php
 						$cs_counter_events = 0;
                        while ( $custom_query->have_posts() ): $custom_query->the_post();
							$cs_counter_events++;
							$cs_event_from_date = get_post_meta($post->ID, "cs_event_from_date", true); 
							$year_event = date("Y", strtotime($cs_event_from_date));
							$month_event = date("M", strtotime($cs_event_from_date));
							$day_event = date("d", strtotime($cs_event_from_date));
							$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
							if ( $cs_event_meta <> "" ) {
								$cs_event_meta = new SimpleXMLElement($cs_event_meta);
								$event_start_time = $cs_event_meta->event_start_time;
							}
							$cs_event_loc = get_post_meta($cs_event_meta->event_address, "cs_event_loc_meta", true);
							if ( $cs_event_loc <> "" ) {
								$cs_xmlObject = new SimpleXMLElement($cs_event_loc);
								$loc_address = $cs_xmlObject->loc_address;
							}else{
								$loc_address = '';
							}
 						?>
                         <!-- Events Widget Start -->
                          <li>
                              <h6><a class="colrhover" href="<?php echo get_permalink(); ?>">
                                <?php
									echo substr(get_the_title(), 0, 56);
									if (strlen(get_the_title()) > 56)
										echo "...";
									?>
                                	</a>
                                </h6>
                              <time datetime="<?php echo $cs_event_from_date; ?>"><?php echo date("d M, Y", strtotime($cs_event_from_date)); ?></time>
                           </li>
                        <!-- Events Widget End -->		
 						<?php endwhile;?>
                        </ul>						
 					<?php }else{
							echo '<h3 class="heading-color">';_e( 'No results found.', 'OneLife' ); echo '</h3>';
						}
			}	// endif of Category Selection
			echo $after_widget;	// WIDGET display CODE End
		}
	}
//add_action( 'widgets_init', create_function('', 'return register_widget("upcoming_events");') );

//Event Countdown Widget

class upcomingevents_count extends WP_Widget {

	function upcomingevents_count() {
		$widget_ops = array('classname' => 'upcomingevents_count no-margin', 'description' => 'Select Event to show its countdown.');
		$this->WP_Widget('upcomingevents_count', 'ChimpS : Event Countdown', $widget_ops);
	}

	function form($instance) {
		$instance = wp_parse_args((array) $instance, array('title' => '', 'widget_names_events' => 'new'));
		$title = $instance['title'];
		//$img_url = isset( $instance['img_url'] ) ? esc_attr( $instance['img_url'] ) : '';
		$get_names_events = isset($instance['get_names_events']) ? esc_attr($instance['get_names_events']) : '';
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">
				Title: 
				<br />
				<input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</label>
		</p>
			  <!--<p>
					  <label for="<?php echo $this->get_field_id('img_url'); ?>">
								Background Image Url:
								<br />
								<input class="upcoming" id="<?php echo $this->get_field_id('img_url'); ?>" size="40" name="<?php echo $this->get_field_name('img_url'); ?>" type="text" value="<?php echo esc_attr($img_url); ?>" />
					  </label>
			  </p>-->  
		<p>
			<label for="<?php echo $this->get_field_id('get_names_events'); ?>">
				Select Event:
				<select id="<?php echo $this->get_field_id('get_names_events'); ?>" name="<?php echo $this->get_field_name('get_names_events'); ?>" style="width:225px;">
		<?php
		global $wpdb, $post;
		$newpost = 'posts_per_page=-1&post_type=events&order=ASC&post_status=publish';
		$newquery = new WP_Query($newpost);
		while ($newquery->have_posts()): $newquery->the_post();
			?>
						<option <?php
			if (esc_attr($get_names_events) == $post->post_name) {
				echo 'selected';
			}
			?> value="<?php echo $post->post_name; ?>" >
			<?php echo substr(get_the_title($post->ID), 0, 20);
			if (strlen(get_the_title($post->ID)) > 20)
				echo "...";
			?>
						</option>						
		<?php endwhile; ?>
				</select>
			</label>
		</p>  
		<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['get_names_events'] = $new_instance['get_names_events'];
		return $instance;
	}

	function widget($args, $instance) {
		global $cs_theme_option, $wpdb, $post;
		extract($args, EXTR_SKIP);

		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$get_names_events = isset($instance['get_names_events']) ? esc_attr($instance['get_names_events']) : '';
		if (!isset($get_names_events)) {
			$get_names_events = '4';
		}
		// WIDGET display CODE Start
		echo $before_widget;
		if (!empty($title) && $title <> ' '){
			echo $before_title . $title . $after_title;
		}
		$get_names_events_id = 0;
		if (!is_int($get_names_events)) {
			$args = array(
				'name' => $get_names_events,
				'post_type' => 'events',
				'post_status' => 'publish',
				'showposts' => 1,
			);
			//print_r($args);
			echo '<div class="widget contdown_widget">';
			$custom_query = new WP_Query($args);
			if ($custom_query->have_posts() <> "") {
            	while ( $custom_query->have_posts()) : $custom_query->the_post();
				$cs_event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
				$cs_event_to_date = get_post_meta($post->ID, "cs_event_to_date", true);
				$post_xml = get_post_meta($post->ID, "cs_event_meta", true);	
				if ( $post_xml <> "" ) {
					$cs_xmlObject = new SimpleXMLElement($post_xml);
				}
				$cs_event_loc = get_post_meta($cs_xmlObject->event_address, "cs_event_loc_meta", true);
				if ( $cs_event_loc <> "" ) {
					$cs_event_loc = new SimpleXMLElement($cs_event_loc);
						$loc_address = $cs_event_loc->loc_address;
				}
				else {
					$loc_address = '';
				}
				if (isset($cs_event_from_date) && $cs_event_from_date <> '') {
					cs_countdown_enqueue_scripts();
						$cs_event_from_date = get_post_meta(get_the_id(), "cs_event_from_date", true);
						if (strtotime($cs_event_from_date) > strtotime(date('Y-m-d'))) {
							
							?>
							<script type="text/javascript">
							jQuery(function ($) {
								var e = "<?php echo $cs_event_from_date; ?>";
								jQuery(".countdown.simple").countdown({
								date: e
							});
							jQuery(".countdown<?php echo $get_names_events;?>.styled").countdown({
								date: e,
								render: function (e) {
									$(this.el).html("<div><span class='in'>" + this.leadingZeros(e.days, 0) + "</span> <span class='out'>days</span></div><div><span class='in'>" + this.leadingZeros(e.hours, 2) + " </span><span class='out'>hrs</span></div><div><span class='in'>" + this.leadingZeros(e.min, 2) + " </span><span class='out'>min</span></div><div><span class='in'>" + this.leadingZeros(e.sec, 2) + " </span><span class='out'>sec</span></div>")
								}
							});
							jQuery(".countdown.callback").countdown({
								date: +(new Date) + 1e4,
								render: function (e) {
									$(this.el).text(this.leadingZeros(e.sec, 2) + " sec")
								},
								onEnd: function () {
									$(this.el).addClass("ended")
								}
								}).on("click", function () {
								$(this).removeClass("ended").data("countdown").update(+(new Date) + 1e4).start()
								})
							});
							</script>
							<div class="countdown<?php echo $get_names_events;?> styled"></div>
						<?php } }?>
							<ul>
                <?php if(isset($cs_event_from_date) && !empty($cs_event_from_date)){?>
                    <li> <i class="icon-calendar icon-2x"></i>
                    <div class="text">
                        <p>
                            <?php 
                            if ($cs_theme_option['trans_switcher'] == "on") {
                                _e('Event Date', "OneLife");
                            } else {
                                echo $cs_theme_option['trans_start_date'];
                            }
                            ?>
                        </p>
                        <p class="bold"><?php echo date('j, M Y', strtotime($cs_event_from_date)); echo " - ".date('j, M Y', strtotime($cs_event_to_date )); ?></p>
                    </div>
                    </li>
                <?php }?>
                <?php 
                if($cs_xmlObject->event_all_day=='on' || isset($event_start_time)){?>
                    <li> <i class="icon-time icon-2x"></i>
                    <div class="text">
                        <p>
                            <?php  _e('Start time','OneLife'); echo "-";  _e('End time','OneLife');?>
                        </p>
                        <p class="bold">
                         	 <?php
 								if ( $cs_xmlObject->event_all_day != "on" ) {
									echo strtoupper($event_start_time);
									if($event_end_time <> ''){
										echo " / ";
										echo strtoupper($event_end_time);
									}
								}
								else {
 									  _e('All','OneLife'); echo '&nbsp;'; _e('day','OneLife'); 
								}
                        	?>
                         </p>
                    </div>
                </li>
                <?php }?>
                <?php 
                $categories_list = get_the_term_list ( get_the_id(), 'event-category', '', '', '' );
                if($categories_list){
                ?>
                    <li> <i class="icon-reorder icon-2x"></i>
                    <div class="text">
                    	<p>
                            <?php   
							if ($cs_theme_option['trans_switcher'] == "on") {
                                _e('Listed in', "OneLife");
                            } else {
                                echo $cs_theme_option['trans_listed_in'];
                            }?>
                        </p>
                         <p class="bold">
                            <?php 
                            $before_cat = '';
                            $categories_list = get_the_term_list ( get_the_id(), 'event-category', $before_cat, ', ', '' );
                            if ( $categories_list ){ printf( __( '%1$s', 'OneLife' ),$categories_list ); }
                            ?>
                        </p>
                    </div>
                </li>
                <?php }?>
                <?php if(isset($loc_address) && !empty($loc_address)){?>
                    <li> <i class="icon-map-marker icon-2x"></i>
                    <div class="text">
                        <p>
                            <?php 
                            if ($cs_theme_option['trans_switcher'] == "on") {
                                _e('Event Location', "OneLife");
                            } else {
                                echo $cs_theme_option['trans_event_location'];
                            }
                            ?>
                        </p>
                        <p class="bold">
                            <?php
                            echo $loc_address;
                            ?>
                        </p>
                    </div>
                    </li>
                <?php }?>
                </ul>
						<?php
					
				endwhile;
			}
			echo '</div>';
			echo $after_widget; // WIDGET display CODE End
		}
	}

	}
//add_action('widgets_init', create_function('', 'return register_widget("upcomingevents_count");'));
// Event widgt End
// Tabs widget
class tabs_widget_show extends WP_Widget {

    function tabs_widget_show() {
        $widget_ops = array('classname' => 'tabs-widget tabs', 'description' => 'Select Widgets from options for tabs');
        $this->WP_Widget('tabs_widget_show', 'ChimpS : Tabs Widget', $widget_ops);
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => ''));
        $title = $instance['title'];
        $get_default_widget_one = isset($instance['get_default_widget_one']) ? esc_attr($instance['get_default_widget_one']) : '';

        $title_widget_two = isset($instance['title_widget_two']) ? esc_attr($instance['title_widget_two']) : '';
        $get_default_widget_two = isset($instance['get_default_widget_two']) ? esc_attr($instance['get_default_widget_two']) : '';

        $title_widget_three = isset($instance['title_widget_three']) ? esc_attr($instance['title_widget_three']) : '';

        $get_default_widget_three = isset($instance['get_default_widget_three']) ? esc_attr($instance['get_default_widget_three']) : '';
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                Title: 
                <input class="upcoming" size="40" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
            </label>
        </p>
        <br />    
        <p>
            <label for="<?php echo $this->get_field_id('get_default_widget_one'); ?>">
                Select Widget First Tab:
                <select id="<?php echo $this->get_field_id('get_default_widget_one'); ?>" name="<?php echo $this->get_field_name('get_default_widget_one'); ?>" style="width:225px">
                    <option <?php
                    if (esc_attr($get_default_widget_one) == 'WP_Widget_Archives') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Archives'>Archives</option>
                    <option <?php
                    if (esc_attr($get_default_widget_one) == 'WP_Widget_Calendar') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Calendar'>Calendar</option>
                    <option <?php
                    if (esc_attr($get_default_widget_one) == 'WP_Widget_Categories') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Categories'>Categories</option>
                    <option <?php
                    if (esc_attr($get_default_widget_one) == 'WP_Widget_Links') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Links'>Links</option>
                    <option <?php
                    if (esc_attr($get_default_widget_one) == 'WP_Widget_Meta') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Meta'>Meta</option>
                    <option <?php
                    if (esc_attr($get_default_widget_one) == 'WP_Widget_Pages') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Pages'>Pages</option>
                    <option <?php
                    if (esc_attr($get_default_widget_one) == 'WP_Widget_Recent_Comments') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Recent_Comments'>Recent_Comments</option>
                    <option <?php
                    if (esc_attr($get_default_widget_one) == 'WP_Widget_Recent_Posts') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Recent_Posts'>Recent_Posts</option>
                    <option <?php
                    if (esc_attr($get_default_widget_one) == 'WP_Widget_RSS') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_RSS'>RSS</option>
                    <option <?php
                    if (esc_attr($get_default_widget_one) == 'WP_Widget_Search') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Search'>Search</option>
                    <option <?php
                    if (esc_attr($get_default_widget_one) == 'WP_Widget_Tag_Cloud') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Tag_Cloud'>Tag_Cloud</option>
                    <option <?php
                    if (esc_attr($get_default_widget_one) == 'WP_Widget_Text') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Text'>Text</option>
                </select>
            </label>
        </p>     
        <br />
        <p>
            <label for="<?php echo $this->get_field_id('title_widget_two'); ?>">
                Title: 
                <input class="upcoming" size="40" id="<?php echo $this->get_field_id('title_widget_two'); ?>" name="<?php echo $this->get_field_name('title_widget_two'); ?>" type="text" value="<?php echo esc_attr($title_widget_two); ?>" />
            </label>
        </p>  
        <p>
            <label for="<?php echo $this->get_field_id('get_default_widget_two'); ?>">
                Select Widget Second Tab:
                <select id="<?php echo $this->get_field_id('get_default_widget_two'); ?>" name="<?php echo $this->get_field_name('get_default_widget_two'); ?>" style="width:225px">
                    <option <?php
                    if (esc_attr($get_default_widget_two) == 'WP_Widget_Archives') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Archives'>Archives</option>
                    <option <?php
                    if (esc_attr($get_default_widget_two) == 'WP_Widget_Calendar') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Calendar'>Calendar</option>
                    <option <?php
                    if (esc_attr($get_default_widget_two) == 'WP_Widget_Categories') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Categories'>Categories</option>
                    <option <?php
                    if (esc_attr($get_default_widget_two) == 'WP_Widget_Links') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Links'>Links</option>
                    <option <?php
                    if (esc_attr($get_default_widget_two) == 'WP_Widget_Meta') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Meta'>Meta</option>
                    <option <?php
                    if (esc_attr($get_default_widget_two) == 'WP_Widget_Pages') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Pages'>Pages</option>
                    <option <?php
                    if (esc_attr($get_default_widget_two) == 'WP_Widget_Recent_Comments') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Recent_Comments'>Recent_Comments</option>
                    <option <?php
                    if (esc_attr($get_default_widget_two) == 'WP_Widget_Recent_Posts') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Recent_Posts'>Recent_Posts</option>
                    <option <?php
                    if (esc_attr($get_default_widget_two) == 'WP_Widget_RSS') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_RSS'>RSS</option>
                    <option <?php
                    if (esc_attr($get_default_widget_two) == 'WP_Widget_Search') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Search'>Search</option>
                    <option <?php
                    if (esc_attr($get_default_widget_two) == 'WP_Widget_Tag_Cloud') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Tag_Cloud'>Tag_Cloud</option>
                    <option <?php
                    if (esc_attr($get_default_widget_two) == 'WP_Widget_Text') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Text'>Text</option>
                </select>
            </label>
        </p>   
        <p>
            <label for="<?php echo $this->get_field_id('title_widget_three'); ?>">
                Title: 
                <input class="upcoming" size="40" id="<?php echo $this->get_field_id('title_widget_three'); ?>" name="<?php echo $this->get_field_name('title_widget_three'); ?>" type="text" value="<?php echo esc_attr($title_widget_three); ?>" />
            </label>
        </p>  
        <p>
            <label for="<?php echo $this->get_field_id('get_default_widget_three'); ?>">
                Select Widget Third Tab:
                <select id="<?php echo $this->get_field_id('get_default_widget_three'); ?>" name="<?php echo $this->get_field_name('get_default_widget_three'); ?>" style="width:225px">
                    <option <?php
                    if (esc_attr($get_default_widget_three) == 'WP_Widget_Archives') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Archives'>Archives</option>
                    <option <?php
                    if (esc_attr($get_default_widget_three) == 'WP_Widget_Calendar') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Calendar'>Calendar</option>
                    <option <?php
                    if (esc_attr($get_default_widget_three) == 'WP_Widget_Categories') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Categories'>Categories</option>
                    <option <?php
                    if (esc_attr($get_default_widget_three) == 'WP_Widget_Links') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Links'>Links</option>
                    <option <?php
                    if (esc_attr($get_default_widget_three) == 'WP_Widget_Meta') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Meta'>Meta</option>
                    <option <?php
                    if (esc_attr($get_default_widget_three) == 'WP_Widget_Pages') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Pages'>Pages</option>
                    <option <?php
                    if (esc_attr($get_default_widget_three) == 'WP_Widget_Recent_Comments') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Recent_Comments'>Recent_Comments</option>
                    <option <?php
                    if (esc_attr($get_default_widget_three) == 'WP_Widget_Recent_Posts') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Recent_Posts'>Recent_Posts</option>
                    <option <?php
                    if (esc_attr($get_default_widget_three) == 'WP_Widget_RSS') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_RSS'>RSS</option>
                    <option <?php
                    if (esc_attr($get_default_widget_three) == 'WP_Widget_Search') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Search'>Search</option>
                    <option <?php
                    if (esc_attr($get_default_widget_three) == 'WP_Widget_Tag_Cloud') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Tag_Cloud'>Tag_Cloud</option>
                    <option <?php
                    if (esc_attr($get_default_widget_three) == 'WP_Widget_Text') {
                        echo 'selected';
                    }
                    ?> value='WP_Widget_Text'>Text</option>
                </select>
            </label>
        </p>          
        <?php
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['get_default_widget_one'] = $new_instance['get_default_widget_one'];
        $instance['title_widget_two'] = $new_instance['title_widget_two'];
        $instance['get_default_widget_two'] = $new_instance['get_default_widget_two'];
        $instance['title_widget_three'] = $new_instance['title_widget_three'];
        $instance['get_default_widget_three'] = $new_instance['get_default_widget_three'];
        return $instance;
    }

    function widget($args, $instance) {
		global $wpdb, $post;
        extract($args, EXTR_SKIP);
        $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
        $get_default_widget_one = isset($instance['get_default_widget_one']) ? esc_attr($instance['get_default_widget_one']) : '';

        $title_widget_two = isset($instance['title_widget_two']) ? esc_attr($instance['title_widget_two']) : '';
        $get_default_widget_two = isset($instance['get_default_widget_two']) ? esc_attr($instance['get_default_widget_two']) : '';
        $title_widget_three = isset($instance['title_widget_three']) ? esc_attr($instance['title_widget_three']) : '';
        $get_default_widget_three = isset($instance['get_default_widget_three']) ? esc_attr($instance['get_default_widget_three']) : '';
        echo $before_widget;
        // WIDGET display CODE Start
		$tab1 = cs_generate_random_string($length = 3);
		$tab2 = cs_generate_random_string($length = 4);
		$tab3 = cs_generate_random_string($length = 5);
        ?>
        <ul id="myTab" class="nav nav-tabs">
            <li class="active"><a href="#<?php echo $get_default_widget_one.'_'.$tab1; ?>"><?php echo $title; ?></a></li>
            <li class=""><a href="#<?php echo $get_default_widget_two.'_'.$tab2; ?>"><?php echo $title_widget_two; ?></a></li>
            <li class=""><a href="#<?php echo $get_default_widget_three.'_'.$tab3; ?>"><?php echo $title_widget_three; ?></a></li>
        </ul>	
        
        <div class="tab-content webkit">
            <div id="<?php echo $get_default_widget_one.'_'.$tab1; ?>" class="tab-pane active">
                <!-- Widget Recent Blog Start -->
                 <?php the_widget($get_default_widget_one); ?>
                <!-- Widget Recent Blog End -->
            </div>
            <div id="<?php echo $get_default_widget_two.'_'.$tab2; ?>" class="tab-pane">
                <!-- Widget Recent Blog Start -->
                <?php the_widget($get_default_widget_two); ?>
                <!-- Widget Recent Blog End -->
            </div>
            <div id="<?php echo $get_default_widget_three.'_'.$tab3; ?>" class="tab-pane">
                <!-- Widget Recent Blog Start -->
                <?php the_widget($get_default_widget_three); ?>
                
                <!-- Widget Recent Blog End -->
           </div>
        </div>
       <!-- Tabs Container End -->		
       <!-- Tabs Widget End -->
	
        <?php
        echo $after_widget;
    }

}

add_action('widgets_init', create_function('', 'return register_widget("tabs_widget_show");'));
// Tabs widget end


$args = array(
    'default-color' => '',
    'default-image' => '',
);
add_theme_support('custom-background', $args);
add_theme_support('custom-header', $args);

// This theme styles the visual editor with editor-style.css to match the theme style.
add_editor_style();

// This theme uses post thumbnails
add_theme_support('post-thumbnails');

// Add default posts and comments RSS feed links to head
add_theme_support('automatic-feed-links');

// Make theme available for translation
// Translations can be filed in the /languages/ directory
 load_theme_textdomain('OneLife', get_template_directory() . '/languages');


if (!isset($content_width)) $content_width = 1170;
// Functions will be moved in function.php
// 
// get random string
function cs_generate_random_string($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function cs_blog_avatar(){
	?>
    <div class="post-thumb">
    	<time><?php echo date('d',strtotime(get_the_date()));?><span><?php echo date('M',strtotime(get_the_date()));?></span></time>
        <!--<time datetime="<?php echo date('Y-m-d',strtotime(get_the_date()));?>"><?php echo get_the_date();?></time>-->
        <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('PixFill_author_bio_avatar_size', 61)); ?></a>
    </div>
<?php	
}
// get media attachement for posts
function cs_get_media_attachment(){ 
global $post;
?>
    <ul class="post-media-attachments gallery-list lightbox">
    <?php 
    $args = array(
    'post_type' => 'attachment',
    'numberposts' => -1,
    'post_status' => null,
    'post_parent' => $post->ID
    );
    $attachments = get_posts( $args );
    if ( $attachments ) {
     cs_enqueue_gallery_style_script();
    foreach ( $attachments as $attachment ) {
        $attachment_title = apply_filters( 'the_title', $attachment->post_title );
       $type = get_post_mime_type( $attachment->ID );
       if($type=='image/jpeg'){
           echo '<li>';
         ?>
           <a <?php if ( $attachment_title <> '' ) { echo 'data-title="'.$attachment_title.'"'; }?> href="<?php echo $attachment->guid; ?>" data-rel="<?php echo "prettyPhoto[gallery1]"?>"><?php echo wp_get_attachment_image( $attachment->ID, 'thumbnail' ) ?></a>
        <?php
            echo '</li>';
       } elseif($type=='audio/mpeg') {
           echo '<li>';
           ?>
           <!-- Button to trigger modal -->
            <a href="#audioattachment<?php echo $attachment->ID;?>" role="button" data-toggle="modal"><i class="icon-play-sign icon-5x"></i></a>
            <!-- Modal -->
            <div id="audioattachment<?php echo $attachment->ID;?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-body">
                    <audio style="width:100%;" src="<?php echo $attachment->guid; ?>" type="audio/mp3" controls="controls"></audio>
                </div>
            </div>
        <?php
            echo '</li>';
       } elseif($type=='video/mp4') {
           echo '<li>';
        ?>
            <a href="#videoattachment<?php echo $attachment->ID;?>" role="button" data-toggle="modal"><i class="icon-play-sign icon-5x"></i></a>
            <div id="videoattachment<?php echo $attachment->ID;?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-body">
                    <video width="100%" class="mejs-wmp" height="380" src="<?php echo $attachment->guid; ?>"  id="player1" poster="" controls="controls" preload="none"></video>
                </div>
            </div>
        <?php
            echo '</li>';
       }
      }
    }
    ?>
    </ul>
<?php
}
// porfolio addtionla information list on detail page
function cs_portfolio_other_info($cs_xmlObject){
	echo '<ul>';
	foreach ( $cs_xmlObject as $other_info ){
	  if ( $other_info->getName() == "other_info" ) {
		  $port_other_info_title = $other_info->port_other_info_title;
		  $port_other_info_desc = $other_info->port_other_info_desc;
		  $port_other_info_icon = $other_info->port_other_info_icon;
		  echo  '<li> <span class="icon-stack pull-left colr"><em class="icon-circle icon-stack-base"></em><em class="'.$other_info->port_other_info_icon.' icon-light"></em></span>
		  <div class="text">
			<span class="colr">'.$port_other_info_title.'</span>
			<p>'.$port_other_info_desc.'</p>
		</div></li>'; 
	  }
	}
	echo '</ul>';
	if($cs_xmlObject->port_live_link_title <> ''){
		echo '<a class="view" href="'.$cs_xmlObject->port_live_link_url.'" target="_blank">'.$cs_xmlObject->port_live_link_title.'</a>';
	}
}
