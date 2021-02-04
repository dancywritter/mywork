<?php
// search varibales start
function cs_get_search_results($query) {
	if ( !is_admin() and (is_search())) {
		$query->set( 'post_type', array('post', 'events' ) );
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
	function cs_next_prev_post(){
	global $post;
	posts_nav_link();
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
    	<div class="prevnext-post">
 			<?php 
			 __('Next Post','Rocky');
			previous_post_link( '%link', '<em class="fa fa-chevron-left"></em>' ); ?>
			<?php next_post_link( '%link','<em class="fa fa-chevron-right"></em>' ); ?>
 
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
		<li class="featured"><i class="fa fa-thumb-tack"></i></li>
		<?php
		}
	}
}

//Add classes according to diffrent view for blog post type
function cs_blog_classes($blog_view =""){
 	if($blog_view == 'blog-large'){ 
		echo 'postlist blog '.$blog_view;
	}elseif($blog_view == 'blog-small'){ 
		echo 'widget latest_blog cs-blog '.$blog_view;
	}
	elseif($blog_view == 'blog-masonry'){  
		echo 'postlist blog blog-masonry-four-col '.$blog_view; 
	}
	else{
		echo 'postlist blog';
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
		echo __('Author', 'Rocky') . " " . __('Archives', 'Rocky') . ": ".$userdata->display_name;
	}elseif ( is_tag() || is_tax('event-tag') ) {
		echo __('Tags', 'Rocky') . " " . __('Archives', 'Rocky') . ": " . single_cat_title( '', false );
	}elseif ( is_category() || is_tax('event-category') ) {
		echo __('Categories', 'Rocky') . " " . __('Archives', 'Rocky') . ": " . single_cat_title( '', false );
	}elseif( is_search()){
		printf( __( 'Search Results %1$s %2$s', 'Rocky' ), ': ','<span>' . get_search_query() . '</span>' ); 
	}elseif ( is_day() ) {
		printf( __( 'Daily Archives: %s', 'Rocky' ), '<span>' . get_the_date() . '</span>' );
	}elseif ( is_month() ) {
		printf( __( 'Monthly Archives: %s', 'Rocky' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'Rocky' ) ) . '</span>' );
	}elseif ( is_year() ) {
		printf( __( 'Yearly Archives: %s', 'Rocky' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'Rocky' ) ) . '</span>' );
	}elseif ( is_404()){
		_e( 'Error 404', 'Rocky' );
	}elseif(!is_page()){
		_e( 'Archives', 'Rocky' );
	}
}
// page elemect for pirce table
if ( ! function_exists( 'cs_pricetable_page' ) ) {
	function cs_pricetable_page(){
		global $cs_node;
		if(empty($cs_node->pricetable_featured)) $cs_node->pricetable_featured ='';
		$pricetable_featured ='';
		if($cs_node->pricetable_style == ''){
			$cs_node->pricetable_style = 'style1';
		}
		if($cs_node->pricetable_featured == "Yes") $pricetable_featured = " price_featured";
		$html = '<div class="price-table price-'.$cs_node->pricetable_style.$pricetable_featured.'">';
		
		if($cs_node->pricetable_style <> '' && $cs_node->pricetable_style == 'style3') {
		$html .= '<header>
					<h3 class="bgcolr">'.$cs_node->pricetable_package.'</h3>
					<span class="icon-pricetable">
					<em class="fa fa-microphone"></em>
					</span>
				  </header>';
		}
		$html .= '<div class="pricing-box">';
		if($cs_node->pricetable_style <> '' && $cs_node->pricetable_style=='style3'){
		$html .= '<div class="plan-header">';
		}else{
		$html .= '<div class="plan-header" style="background:'.$cs_node->pricetable_bgcolor.'">';
		}
		if($cs_node->pricetable_style <> '' && $cs_node->pricetable_style=='style1'){
			$html .= '<span class="fa fa-stack colr">
						<em class="fa fa-circle fa-stack-2x"></em>
						<em class="fa fa-microphone fa-stack-1x fa-inverse"></em>
					  </span>';			
		}
		$html .= '<div class="pricing-heading">';
		$html .= '<h6>'.$cs_node->pricetable_title.'</h6>';
		$html .= '</div>';
		$html .= '<div class="price"><h1 class="webkit cs-heading-color">'.$cs_node ->pricetable_price.' <small>'.$cs_node->pricetable_for_time.'</small></h1></div>';
		
		$html .= '</div>';
		$html .= '<div class="plan-inside">'.$cs_node ->pricetable_content.'</div>';
		if($cs_node->pricetable_style <> '' && $cs_node->pricetable_style <> 'style2') {
		$html .= '<div class="period"><center><a href="'.$cs_node->pricetable_linkurl.'" class="button_large bgcolrhover" style="background:'.$cs_node->pricetable_bgcolor.'">'.$cs_node->pricetable_linktitle.'</a></center></div>';
		}
		else if($cs_node->pricetable_style <> '' && $cs_node->pricetable_style=='style2') {
		$html .= '<div class="period"><center><a href="'.$cs_node->pricetable_linkurl.'" class="button_large">'.$cs_node->pricetable_linktitle.'</a></center></div>';
		}
		else {
		$html .= '<div class="period"><center><a href="'.$cs_node->pricetable_linkurl.'" class="button_large bgcolrhover">'.$cs_node->pricetable_linktitle.'</a></center></div>';
		}
		$html .= '</div>';
		$html .= '</div>';
		echo $html;
	}
}

// Dropcap shortchode with first letter in caps
if ( ! function_exists( 'cs_dropcap_page' ) ) {
	function cs_dropcap_page(){
		global $cs_node;
		$html = '<div class="element_size_'.$cs_node->dropcap_element_size.'">';
			if($cs_node->dropcap_style == "2"){
			$html .= '<div class="dropcaptwo">';
			}else{
			$html .= '<div class="dropcap">';
			}
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
			$html .= '<div class="blockquote styleicon">
						<span class="cate-icon">
							<span class="fa-stack fa-lg">
							<em class="fa fa-square fa-stack-2x"></em>
							<em class="fa fa-quote-left fa-stack-1x fa-inverse"></em>
							</span>
						</span>';
			$html .= '<blockquote style=" text-align:' .$cs_node->quote_align. '; color:' . $cs_node->quote_text_color . '"><span>' . $cs_node->quote_content . '</span><div class="quote"></div></blockquote>';
		$html .= '</div></div>';
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
		global $cs_node, $counter_node;
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
		if( !isset($cs_node->map_element_size) or $cs_node->map_element_size == ""){ $cs_node->map_element_size ='default';}
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
		$html .= '<div class="element_size_'.$cs_node->map_element_size.' cs-map">';
			if($cs_node->map_title <> ''){$html .= '<h2 class="cs-heading-color section-title">'.$cs_node->map_title.'</h2>'; }
			$html .= '<div class="mapcode iframe mapsection gmapwrapp" id="map_canvas'.$counter_node.'" style="height:'.$cs_node->map_height.'px;"> </div>';
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
						var map = new google.maps.Map(document.getElementById('map_canvas".$counter_node."'), mapOptions);
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
				if(isset($cs_node->image_lightbox) and $cs_node->image_lightbox == "yes"){
				$html .= '<a class="'.$cs_node->image_style.'" href="'.$href.'" title="'.$cs_node->image_caption.'" '.$data_rel.'>';
				}
					$html .= '<img src="'.$cs_node->image_source.'" alt="" />';
				if(isset($cs_node->image_lightbox) and $cs_node->image_lightbox == "yes"){
				$html .= '</a>';
				}
				if(isset($cs_node->image_caption) and $cs_node->image_caption <> ""){
				$html .= '<figcaption class="webkit">';
					$html .= '<h6>'.$cs_node->image_caption.'</h6>';
				$html .= '</figcaption>';
				}
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
			$html .= '<a href="#" class="gotop" id="back-top">'.__('Top','Rocky').'</a>';
		}
		$html .= '</div>';
		$html .= '</div>';
		return $html . '<div class="clear"></div>';
	}
}
// Services shortcode with multiple layout
if ( ! function_exists( 'cs_services_page' ) ) {
	function cs_services_page() {
    	global $cs_node, $post, $element_size_class, $cs_theme_option;
    	?>
        <div class="element_size_<?php echo $cs_node->services_element_size; ?>">
            <!-- Prayer Submit Start -->
            <div class="our_services fullwidth">
                <?php
                foreach ($cs_node->service as $service_info) {
					if ( $service_info->service_style == "service1" ) $service_style = "service-v1";
					elseif ( $service_info->service_style == "service2" ) $service_style = "service-v2";
					elseif ( $service_info->service_style == "service3" ) $service_style = "service-v3";
					elseif ( $service_info->service_style == "service4" ) $service_style = "service-v4";
					?>
					
					<article class="<?php echo $service_style?> viewme">
					<?php
					if ( $service_info->service_style == "service2" ){
                    ?>
					<figure class="viewme">
				   		<?php if ($service_info->service_icon <> '') { ?>
						<span class="icon-stack">
						 <span class="colrhover" onclick="<?php echo $service_info->service_url; ?>"><em class="fa fa-circle fa-stack-base"></em> <em class="fa <?php echo $service_info->service_icon; ?> fa-light"></em></span>
						</span>      
					    <?php } ?>
					</figure>
					<div class="text">
						<header class="heading">
							<h2 class="post-title">
								<a class="colrhover" href="<?php echo $service_info->service_url; ?>"><?php echo $service_info->service_title; ?></a>
							</h2>
						</header>
						<p>
							<?php echo do_shortcode($service_info->service_text); ?>
						</p>
					</div>
                    
					<?php
					}else if($service_info->service_style == "service3"){
					?>
						<?php if ($service_info->service_icon <> '') { ?>
						<figure class="viewme">
							<em class="fa <?php echo $service_info->service_icon; ?>"></em>
						</figure>
						<?php } ?>
						<div class="text">
							<header class="heading">
								<h2 class="post-title">
									<a class="colrhover" href="<?php echo $service_info->service_url; ?>"><?php echo $service_info->service_title; ?></a>
								</h2>
							</header>
							<p>
								<?php echo do_shortcode($service_info->service_text); ?>
							</p>
						</div>
					
				<?php
					}else if($service_info->service_style == "service4"){
					?>
					
						<figure class="viewme">
							<?php if ($service_info->service_icon <> '') { ?>
							<span class="icon-stack">
							 <em class="fa fa-sign-blank fa-stack-base"></em> <em class="fa <?php echo $service_info->service_icon; ?> fa-light"></em>
							</span>
							<?php } ?>
							<header class="heading">
								<h2 class="post-title">
									<a class="colrhover" href="<?php echo $service_info->service_url; ?>"><?php echo $service_info->service_title; ?></a>
								</h2>
							</header>
						</figure>
						<div class="text">
							<p>
								<?php echo do_shortcode($service_info->service_text); ?>
							</p>
						</div>
				<?php
					}else{
					?>	
						<?php if ($service_info->service_icon <> '') { ?>
						<figure class="viewme">
							<a class="bgcolrhover" href="<?php echo $service_info->service_url; ?>">
								<em class="fa fa-light <?php echo $service_info->service_icon; ?>"></em>
							</a>
						</figure>
						<?php } ?>
						<div class="text">
							<header class="heading">
								<h2 class="post-title">
									<a class="colrhover" href="<?php echo $service_info->service_url; ?>"><?php echo $service_info->service_title; ?></a>
								</h2>
							</header>
							<p>
								<?php echo do_shortcode($service_info->service_text); ?>
							</p>
						</div>
				<?php
					}
				?>
				</article>
				
				<?php
				}
				?>
                </div>
                <!-- Prayer Submit End -->
              <div class="clearfix"></div> 
            </div>
			
			
			
        <?php
    }
}	
// Gallery List and carusaul View
if ( ! function_exists( 'cs_client_page' ) ) {
	function cs_client_page(){
		global $cs_node,$cs_post_id,$cs_theme_option;
		cs_enqueue_gallery_style_script();
		?> 
		<div class="element_size_<?php echo $cs_node->client_element_size; ?> ourclient lightbox">
			<?php 
				if($cs_node->client_header_title <> ''){echo ' <header class="heading"><h2 class="cs-heading-color section-title">'.$cs_node->client_header_title.'</h2></header>';} 
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
						$counter =1;
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
				$html .= '<li class="' . $tab_active . '"><a data-toggle="tab" href="#tab' . $tab_counter . $tabs_count . '"><i class="fa '.$val["icon"].'"></i> ' . $val["title"] . '</a></li>';
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
			$html = '<div class="tabs">' . $html . '</div>';
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
					$html .= '</div></div>';
			$html = $html ;
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
		
		$html .= '<div class="panel-group fullwidth" id="accordion-' . $acc_counter . '">';
		$cs_xmlObject = new SimpleXMLElement( $cs_node->accordion_content );
		foreach ($cs_xmlObject as $cs_node) {
			if (!isset($cs_node["icon"])){ $cs_node["icon"] = '';}
			if (!isset($cs_node["title"])){ $cs_node["title"] = '';}
	
			$accordion_count++;
			if ($accordion_count == 1 && $cs_node["active"] == "yes")
					$class_active = "";
				else
					$class_active = " collapsed";
					
			if ( $cs_node["active"] == "yes"){
				
				$accordion_active = " in";
				 
			}else{
				$accordion_active = "";
				
			}
			$html .= '<div class="panel panel-default">';
			$html .= '<div class="panel-heading">';
			$html .= '<h4 class="panel-title"><a class="accordion-toggle '.$class_active .'" data-toggle="collapse" data-parent="#accordion-' . $acc_counter . '" href="#accordion-' . str_replace(" ", "", $accordion_count . $acc_counter) . '"><i class="fa '.$cs_node["icon"].'"></i> ' . $cs_node["title"] . '</a></h4>';
			$html .= '</div>';
			$html .= '<div id="accordion-' . str_replace(" ", "", $accordion_count . $acc_counter) . '" class="panel-collapse collapse ' . $accordion_active . '">';
			$html .= '<div class="panel-body">' . $cs_node . '</div>';
			$html .= '</div>';
			$html .= '</div>';
		}
		$html .= '</div>';
		
		return do_shortcode($html) . '<div class="clear"></div>';
	}
}
  
if ( ! function_exists( 'cs_contact_submit' ) ) {
	function cs_contact_submit(){
		foreach ($_REQUEST as $keys=>$values) {
			$$keys = $values;
		}
		$subject = "(" . $bloginfo . ") Contact Form Received";
		$message = '
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
		wp_mail( $cs_contact_email, $subject, $message, $headers, $attachments );
		//mail($cs_contact_email, $subject, $message, $headers);
		echo $cs_contact_succ_msg;
		die();
	}
 }
add_action('wp_ajax_cs_contact_submit', 'cs_contact_submit');
add_action('wp_ajax_nopriv_cs_contact_submit', 'cs_contact_submit');
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
			$_SESSION['sess_custome_pattern'] = '';
			$_SESSION['sess_bg_img'] = "";
			$_SESSION['sess_style_sheet'] = "#ef5d00";
			$_SESSION['sess_heading_color'] = "#ef5d00";
			$_SESSION['sess_layout_option'] = "wrapper_boxed";
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
		if ( empty($_SESSION['sess_style_sheet']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['sess_style_sheet'] = "#ef5d00"; }
		if ( empty($_SESSION['sess_heading_color']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['sess_heading_color'] = "#ef5d00"; }
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
     				parallaxfullwidth ()
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
	var cf = ".colr,.colrhover:hover, .thumblist .text > header h5 a:hover, .shar_btn:hover i, .accordion-heading .accordion-toggle:hover, .accordion-heading .accordion-toggle.active,.portfolio article:hover .text h6 a, .filter_nav ul li.selected-1 a, .filter_nav ul li.selected-2 a, .filter_nav ul li.selected-0 a, .filter_nav ul li a:hover,.blog_admin article:hover, .pagenone .navigation ul li a:hover, .count a, .comment-edit-link, .comment-reply-link, .comment-reply-title, .comment-reply-title a, .post-edit-link,.prject_main_text h4, .headlines article .text h6 a, .alert-info h4, .widget_tag_cloud a:hover,.bolg_column article:hover figcaption h4 a,.post-options li a:hover, .event article .text .top p a:hover, .pricing-box .plan-inside li span, .services article:hover .icon-lightbulb, .services article:hover .icon-bar-chart, .services article:hover .icon-laptop, .services article:hover .icon-external-link, .services article:hover h2 a,.team-shortcode article:hover, .testimonial-author, .detail_info article p a:hover,.widget_categories ul li a:hover, .widget_categories > ul > li:hover,.widget_categories > ul > li:hover > a,.widget_categories > ul > li:hover,.widget_categories > ul > li > a:hover, .widget_recent_comments ul li a:hover, .widget_recent_entries ul li a:hover, .widget_meta ul li a:hover, .widget_links ul li a:hover, .featured_categories > ul > li > a:hover, .widget_nav_menu ul li a:hover, .widget_pages ul li a:hover, #comments .text .comment-reply-link i:hover,#wp-calendar tbody td a,.pagination ul li a.active,.pagination ul li a:hover"; 
	var bc = ".bgcolr,.bgcolrhover:hover,nav.navigation  ul  ul > li:hover > a,.ourmusicsec article figure:after,.jp-play-bar:before,.wrapper-payerlsit li a.jp-playlist-item.jp-playlist-current ,.flex-control-paging li a:hover,.flex-control-paging li a.flex-active,.subtitle:before,#main .flex-direction-nav li a:hover,.nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus,.nav-tabs>li>a:hover,.nav-tabs>li.active>a:before,.events-grid article:hover a.btnbuytickets,.dropcap:first-letter, .dropcap p:first-letter,.dropcaptwo:first-letter,#header.header-3 .navigation > ul > li:after,#header.header-4 .navigation > ul > li:after,#header.header-6 .navigation > ul > li:after ,.team-shortcode article.team-v4:after,.our_services article.service-v3:hover figure,.price-table.price-style2.price_featured .plan-header .price,.price-table.price-style3.price_featured .period a, .widget_tag_cloud .tagcloud a:hover, .widget_search input[type='submit'], #wp-calendar caption, #wp-calendar tfoot a, #formcontainer button.btn, .wpcf7-submit,.widget_ns_mailchimp input[type='submit'], .password_protected form input[type='submit'],.album-listing article figure figcaption a:hover, .tp-rightarrow.default, .tp-leftarrow.default,.outerbreadcrumb .breadcrumbinner .subtitle:before,.gotop";
	var boc = ".bordercolr,.bordercolrhover:hover, nav.navigation > ul > li.current-menu-item > a:before, #respond form p input:focus, #respond form p textarea:focus,.widget_categories ul li a,blockquote,#wrapperheader, #containergallery figure figcaption";
	var boc2 =".btntopmenu:before,.our_services article.service-v3:hover figure";
	var styleheading = ".pagenone h3, .cs-heading-color, .comment-reply-title,#wrappermain-pix h1,#wrappermain-pix h2,#wrappermain-pix h3,#wrappermain-pix h4,#wrappermain-pix h5,#wrappermain-pix h6,#wrappermain-pix h1 a,#wrappermain-pix h2 a,#wrappermain-pix h3 a,#wrappermain-pix h4 a,#wrappermain-pix h5 a,#wrappermain-pix h6 a";
	$('#themecolor .bg_color').wpColorPicker({
		change:function(event,ui){
			var a = ui.color.toString();
			$("#stylecss") .remove();
			$("<style type='text/css' id='stylecss'>"+cf+"{color:"+a+" !important}"+bc+"{background:"+a+" !important}"+boc+"{border-color:"+a+" !important}"+boc2+"{border-color:transparent "+a+" !important}</style>").insertAfter("#wrappermain-pix");
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
		jQuery("#bgcolor").attr('value',"#ef5d00")
		jQuery("#headingcolorbg").attr('value',"#ef5d00")
		jQuery('input:radio[name=layout_option][value=wrapper_boxed]').attr('checked', true);
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
/*
Dynamic Css styles changes by color switcher
*/
function cs_custom_styles() {
	global $cs_theme_option;
 
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
 ?>
	<style type="text/css" >
@charset "utf-8";
/* Colors Css File */
.colr,.colrhover:hover,nav.navigation > ul > li:hover > a,.pagination ul li a:hover ,.pagination ul li a.active,.ratingbox .fa-star,.panel-title>a ,.our_services article.service-v2:hover figure,.our_services article.service-v4:hover figure span.icon-stack,.our_services article.service-v4:hover figure .heading  a , .widget_categories > ul > li:hover > a, .widget_categories > ul > li:hover, .widget_categories > ul > li > a:hover, .widget_recent_comments ul li a:hover, .widget_recent_entries ul li a:hover, .widget_meta ul li a:hover, .widget_links ul li a:hover, .featured_categories > ul > li > a:hover, .widget_nav_menu ul li a:hover, .widget_pages ul li a:hover, #comments .text .comment-reply-link i:hover,#wp-calendar tbody td a{
	color:<?php echo $cs_color_scheme;?> !important;
}
.bgcolr,.bgcolrhover:hover,nav.navigation  ul  ul > li:hover > a,.ourmusicsec article figure:after,.jp-play-bar:before,.wrapper-payerlsit li a.jp-playlist-item.jp-playlist-current ,.flex-control-paging li a:hover,.flex-control-paging li a.flex-active,.subtitle:before,#main .flex-direction-nav li a:hover,.nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus,.nav-tabs>li>a:hover,.nav-tabs>li.active>a:before,.events-grid article:hover a.btnbuytickets,.dropcap:first-letter, .dropcap p:first-letter,.dropcaptwo:first-letter,#header.header-3 .navigation > ul > li:after,#header.header-4 .navigation > ul > li:after,#header.header-6 .navigation > ul > li:after ,.team-shortcode article.team-v4:after,.our_services article.service-v3:hover figure,.price-table.price-style2.price_featured .plan-header .price,.price-table.price-style3.price_featured .period a, .widget_tag_cloud .tagcloud a:hover, .widget_search input[type="submit"], #wp-calendar caption, #wp-calendar tfoot a, #formcontainer button.btn, .wpcf7-submit,.widget_ns_mailchimp input[type="submit"], .password_protected form input[type="submit"],.album-listing article figure figcaption a:hover, .tp-rightarrow.default, .tp-leftarrow.default,.outerbreadcrumb .breadcrumbinner .subtitle:before,.gotop {
	background:<?php echo $cs_color_scheme;?> !important;
}
.bdrcolr  ,#containergallery figure figcaption,blockquote,.featured_categories > ul > li > a,.qoute-author ,.event-panel a.btnlocation:hover , .widget_categories > ul > li > a{
	border-color:<?php echo $cs_color_scheme;?> !important;
}
.nav-tabs>li.active>a:after{
	border-color:<?php echo $cs_color_scheme;?> transparent !important;
}
.btntopmenu:before  {
	border-color:transparent <?php echo $cs_color_scheme;?> !important;
}
.trans {
	-webkit-transition:all 0.3s linear;
	-moz-transition:all 0.3s linear;
	-o-transition:all 0.3s linear;
	transition:all 0.3s linear;
}
.border-box {
	-webkit-box-sizing:border-box;
	-moz-box-sizing:border-box;
	box-sizing:border-box;
}

.pagenone h3, .cs-heading-color, .comment-reply-title{
	color:<?php echo $heading_color_scheme;?> !important;
}
#footer-widgets{
	background:<?php echo $cs_theme_option['footer_bg_color'] ?>  !important;
}
#footer-widgets,#footer-widgets a,#footer-widgets p,p.copyright {
	color:<?php echo $cs_theme_option['footer_text_color'] ?>  !important;
}
footer#footer{
	background:<?php echo $cs_theme_option['copyright_bg_color'] ?>  !important;
}

</style>
<?php 
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
		<div id="flexslider<?php echo $counter_node; ?>">
		  <div class="flexslider">
			  <ul class="slides">
				<?php 
					$counter = 1;
					$cs_xmlObject_flex = new SimpleXMLElement($cs_meta_slider_options);
					foreach ( $cs_xmlObject_flex->children() as $as_node ){
						
 						$image_url = cs_attachment_image_src($as_node->path,$width,$height); 
						?>
						<li>
                        	<figure class="viewme">
							<img src="<?php echo $image_url ?>" alt="" />
							<!-- Caption Start -->
							<?php 
								if($as_node->title != '' && $as_node->description != '' || $as_node->title != '' || $as_node->description != ''){ 
								$as_node->cs_slider_link ="";
								if($as_node->link <> ''){}
								
							?>
								<figcaption>
                                	
  									<?php if($as_node->link <> ''){ 
										 echo '<a href="'.$as_node->link.'" target="'.$as_node->link_target.'">';
									}
									?>
										<h2 class="colr"><?php echo $as_node->title; ?></h2>
 										<p>
											<?php
												echo substr($as_node->description, 0, 220);
												if ( strlen($as_node->description) > 220 ) echo "...";
											?>
										</p>
										<div class="duration backcolr"><div class="loader"></div></div>
									<?php if($as_node->link <> ''){
										echo '</a>';
									}
								?>
								
							</figcaption>
                            
							<!-- Caption End -->
							<?php } ?>
                            </figure>
							  <div class="bannershadow"></div>
						</li>
					<?php 
					$counter++;
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
				jQuery('#flexslider<?php echo $counter_node; ?> .flexslider').flexslider({
					animation: "<?php echo $cs_theme_option['flex_effect']; ?>", // fade
					slideshow: <?php echo $auto_play;?>,
					slideshowSpeed:speed,
					animationSpeed:slidespeed
					
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
		global $cs_meta_page,$video_width;
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
			echo "col-lg-12 col-md-12";
		}
		else if ( $layout <> '' and $layout == 'right' ) {
			echo "col-lg-9 col-md-9";
		}
		else if ( $layout <> '' and $layout == 'left' ) {
			echo "col-lg-9 col-md-9";
		}
	}	
}
// Default pages sidebar class
if ( ! function_exists( 'cs_default_pages_sidebar_class' ) ) { 
	function cs_default_pages_sidebar_class($layout){
		if ( $layout <> '' and $layout == 'right' ) {
			echo "col-lg-3 col-md-3";
		}
		else if ( $layout <> '' and $layout == 'left' ) {
			echo "col-lg-3 col-md-3";
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
		global $cs_theme_option;
		/////////// Trans for Prev /////////
		$cs_prev_page = "";
		if($cs_theme_option['trans_switcher'] == "on"){ $cs_prev_page = __('Previous','Rocky');}else{ $cs_prev_page = $cs_theme_option['trans_other_prev']; }
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
		$html .="<nav class='pagination fullwidth'><ul>";
		if ($_GET['page_id_all'] > 1)
			
			$html .= "<li class='prev'><a href='?page_id_all=" . ($_GET['page_id_all'] - 1) . "$qrystr' >".$cs_prev_page."</a></li>";
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
			$html .= "<li class='next'><a href='?page_id_all=" . ($_GET['page_id_all'] + 1) . "$qrystr' >".__('Next','Rocky')."</a></li>";
			$html .="</ul></nav>";
		return $html;
	}
}

// pagination end
// Social Share Function
if ( ! function_exists( 'cs_social_share' ) ) {
	function cs_social_share() {
		global $cs_theme_option;
		$html = '';
		$icon = '';
		$pageurl = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		$path = get_template_directory_uri() . "/images/admin/";
		                       
		$html ='<div class="share-now">
                <div class="social-network">';
  				$html .= '<h5>';
				if($cs_theme_option["trans_switcher"] == "on") { $html .= _e("Share this post",'Rocky'); }else{  $html .=  $cs_theme_option["trans_share_this_post"];}
				$html .= '</h5>';
 			if (isset($cs_theme_option['twitter_share']) && $cs_theme_option['twitter_share'] == 'on') {
				$html .= ' <a href="http://twitter.com/home?status=' . get_the_title() . ' - ' . $pageurl . '" target="_blank" data-original-title="Twitter" data-placement="top" class="fa fa-twitter-sign twitter  '.$icon.'"><img src="'.get_template_directory_uri().'/images/img-s2.png" /></a> ';
			}
			if (isset($cs_theme_option['facebook_share']) && $cs_theme_option['facebook_share'] == 'on') {
				$html .= '<a href="http://www.facebook.com/share.php?u=' . $pageurl . '&t=' . get_the_title() . '" target="_blank" data-original-title="Facebook" data-placement="top" class="fa fa-facebook-sign facebook  '.$icon.'"><img src="'.get_template_directory_uri().'/images/img-s1.png" /></a> ';
			}
			if (isset($cs_theme_option['linkedin_share']) && $cs_theme_option['linkedin_share'] == 'on') {
				$html .= '<a href="http://www.linkedin.com/shareArticle?mini=true&#038;url=' . $pageurl . '&#038;title=' . get_the_title() . '" target="_blank" data-original-title="Linkedin" data-placement="top" class="fa fa-linkedin-sign linkedin  '.$icon.'"><img src="'.get_template_directory_uri().'/images/img-s4.png" /></a> ';
			}
			if (isset($cs_theme_option['pinterest_share']) && $cs_theme_option['pinterest_share'] == 'on') {
				$html .= '<a href="http://pinterest.com/pin/create/button/?url=' . $pageurl . '&#038;title=' . get_the_title() . '" target="_blank"  data-original-title="Pinterest" data-placement="top" class="fa fa-pinterest-sign  pinterest  '.$icon.'"><img src="'.get_template_directory_uri().'/images/pinterest.png" /></a> ';
			}
			if (isset($cs_theme_option['google_plus_share']) && $cs_theme_option['google_plus_share'] == 'on') { 
				$html .= '<a href="https://plus.google.com/share?url='.get_permalink().'" target="_blank" data-original-title="Google Plus" data-placement="top" class="fa fa-google-plus-sign google_plus  '.$icon.'"><img src="'.get_template_directory_uri().'/images/img-s8.png" /></a> '; 
			}
			if (isset($cs_theme_option['tumblr_share']) &&  $cs_theme_option['tumblr_share'] == 'on') { 
				$html .= '<a href="https://www.tumblr.com/share/link?url='.get_permalink().'&name=' . get_the_title() . '" target="_blank" data-original-title="Tumbler" data-placement="top" class="fa fa-tumblr-sign tumbler  '.$icon.'"><img src="'.get_template_directory_uri().'/images/tumbler.png" /></a> '; 
			}
			
		$html .='</div><form><input type="url" value="'.get_permalink().'" onfocus="this.select();"></form></div>';
		echo $html;
	}
}
// Social network
if ( ! function_exists( 'cs_social_network' ) ) {
	function cs_social_network($tooltip=''){
		global $cs_theme_option;
		$tooltip_data='';
		echo '<div class="followus">';
		if(isset($cs_theme_option['social_net_title']) && $cs_theme_option['social_net_title'] <> ''){
			echo '<h5>';
				echo $cs_theme_option['social_net_title'];
			echo '</h5>';
		}
				if(isset($tooltip) && $tooltip <> ''){
					$tooltip_data='data-placement-tooltip="tooltip"';
				}
				if ( isset($cs_theme_option['social_net_url']) and count($cs_theme_option['social_net_url']) > 0 ) {
						$i = 0;
						foreach ( $cs_theme_option['social_net_url'] as $val ){
							?>
					<?php if($val != ''){?><a title="" href="<?php echo $val;?>" data-original-title="<?php echo $cs_theme_option['social_net_tooltip'][$i];?>" data-placement="top" <?php echo $tooltip_data;?> class="colrhover"  target="_blank"><?php if($cs_theme_option['social_net_awesome'][$i] <> '' && isset($cs_theme_option['social_net_awesome'][$i])){?> <em class="<?php echo $cs_theme_option['social_net_awesome'][$i];?> <?php echo $icon;?>"></em><?php } else {?><img src="<?php echo $cs_theme_option['social_net_icon_path'][$i];?>" alt="<?php echo $cs_theme_option['social_net_tooltip'][$i];?>" /><?php }?></a><?php }
							
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
function cs_get_post_img_src($cs_post_id, $width, $height) {
    if(has_post_thumbnail()){
		$image_id = get_post_thumbnail_id($cs_post_id);
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
function cs_get_post_img($cs_post_id, $width, $height) {
    $image_id = get_post_thumbnail_id($cs_post_id);
    $image_url = wp_get_attachment_image_src($image_id, array($width, $height), true);
    if ($image_url[1] == $width and $image_url[2] == $height) {
        return get_the_post_thumbnail($cs_post_id, array($width, $height));
    } else {
        return get_the_post_thumbnail($cs_post_id, "full");
    }
}
// Get Main background
function cs_bg_image(){
	global $cs_theme_option;
	$bg_img = '';
	if($cs_theme_option['layout_option'] == "wrapper_boxed" or $_POST['layout_option'] == "wrapper_boxed"){
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
	global $cs_theme_option;
 	
	if ( isset($_POST['layout_option']) ) {
		echo $_SESSION['sess_layout_option'] = $_POST['layout_option'];
	}
	elseif ( isset($_SESSION['sess_layout_option']) and !empty($_SESSION['sess_layout_option'])){
		echo $_SESSION['sess_layout_option'];
	}
	else {
		echo $cs_theme_option['layout_option'];
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
			'before_title' => '<header class="heading"><h2 class="section-title cs-heading-color">',
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
	'before_title' => '<header class="heading"><h2 class="section-title cs-heading-color">',
	'after_title' => '</h2></header>'
) );
/* Add specific id in Menu */
function cs_add_menuid($ulid) {
	return preg_replace('/<ul>/', '<ul id="menus">', $ulid, 1);
}
add_filter('wp_page_menu','cs_add_menuid');
/* remove specific div in Menu */
function cs_remove_div ( $menu ){
    return preg_replace( array( '#^<div[^>]*>#', '#</div>$#' ), '', $menu );
}
add_filter( 'wp_page_menu', 'cs_remove_div' );
function cs_register_my_menus() {
  register_nav_menus(
	array(
		'main-menu'  => __('Main Menu','Rocky'),
		'top-menu'  => __('Top Menu','Rocky')
 	)
  );
}
add_action( 'init', 'cs_register_my_menus' );
/* add filter for parent css in Menu */
add_filter('nav_menu_css_class', 'cs_add_parent_css', 10, 2);
function cs_add_parent_css($classes, $item) {
    global $menu_children;
    if ($menu_children)
        $classes[] = 'parent';
    return $classes;
}
// adding custom images while uploading media start

add_image_size('cs_media_1', 1270, 500, true);
add_image_size('cs_media_2', 1170, 430, true);
add_image_size('cs_media_3', 870, 320, true);
add_image_size('cs_media_4', 570, 320, true);
add_image_size('cs_media_5', 288, 203, true);
add_image_size('cs_media_6', 270, 270, true);
add_image_size('cs_media_7', 270, 152, true);
add_image_size('cs_media_8', 69, 53, true);

// adding custom images while uploading media end

If (!function_exists('cs_comment')) :
     /**
     * Template for comments and pingbacks.
     *
     * To override this walker in a child theme without modifying the comments template
     * simply create your own PixFill_comment(), and that function will be used instead.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     *
     */
	function cs_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	$args['reply_text'] = '<i class="fa fa-mail-reply-all"></i>';
 	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <div class="thumblist" id="comment-<?php comment_ID(); ?>">
            <ul>
                <li>
                    <figure>
                        <a href="#"><?php echo get_avatar( $comment, 60 ); ?></a>
                    </figure>
                    <div class="text">
                    	<header>
                            <?php $adm_says =  __( "%s <span class=\"says\">says:</span>", "Rocky" ); echo sprintf( '<h5>'.$adm_says.'</h5>', get_comment_author_link() ) ; ?>
                            <?php
                            	/* translators: 1: date, 2: time */
                                printf( __( '<time>%1$s,%2$s</time>', 'Rocky' ), get_comment_date(),get_comment_time('H:i A')); ?>
                                <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
							<?php edit_comment_link( __( '(Edit)', 'Rocky' ), ' ' );?>
                            
                       </header>
                        <?php if ( $comment->comment_approved == '0' ) : ?>
                                <div class="comment-awaiting-moderation colr"><?php _e( 'Your comment is awaiting moderation.', 'Rocky' ); ?></div>
                            
							<?php else: 
                      comment_text();  
                      endif; ?>
                      
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
		<p><?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'Rocky' ), ' ' ); ?></p>
	<?php
		break;
		endswitch;
	}
 	endif;
// password protect post/page
if ( ! function_exists( 'cs_password_form' ) ) {
	function cs_password_form() {
		global $post,$cs_theme_option;
		//<p>' . __( "This post is password protected. To view it please enter your password below:",'Rocky' ) . '</p>';
		$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
		$o = '<div class="pagenone">
				<em class="fa fa-unlock-o"></em>
				<h3>' . __( "This post is password protected. To view it please enter your password below:",'Rocky' ) . '</h3>
				<div class="password_protected">';
		$o .= '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
					<label><em class="fa fa-unlock-o"></em><input name="post_password" id="' . $label . '" type="password" value="' . __( "Password",'Rocky' ) . '" size="20" /></label>
					<input class="backcolr" type="submit" name="submit" value="" />
					<em class="fa fa-angle-right"></em>
				</form>
			  </div>
			</div>';
		return $o;
	}
}
add_filter( 'the_password_form', 'cs_password_form' );

// breadcrumb function
if ( ! function_exists( 'cs_breadcrumbs' ) ) { 
	function cs_breadcrumbs() {
		global $wp_query;
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
	
		global $post;
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
					if ($showCurrent == 1) echo $before . substr(get_the_title(),0,35) . $after;
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
/* Logo Function */
if ( ! function_exists( 'cs_logo' ) ) {
	function cs_logo($logo_url, $log_width, $logo_height, $show_logo='off'){
	 if(isset($show_logo) && !empty($show_logo) && isset($logo_url) && !empty($logo_url) && $show_logo == 'on'){ ?>
            	<!-- Logo Start -->
                    <a href="<?php echo home_url(); ?>"><img src="<?php echo $logo_url; ?>" <?php if( $log_width <> '' || $logo_height <> '' ){?>style="width:<?php echo $log_width; ?>px; height:<?php echo $logo_height; ?>px" <?php }?> alt="<?php echo bloginfo('name'); ?>" /></a>
                <!-- Logo End -->
           <?php }
	}
}

/* Under Construction logo Function */
function cs_uc_logo(){
	global $cs_theme_option;
	?>
	<a href="<?php echo home_url(); ?>"><img src="<?php echo $cs_theme_option['main_logo']; ?>"  style="width:<?php echo $cs_theme_option['main_logo_width']; ?>px; height:<?php echo $cs_theme_option['main_logo_height']; ?>px" alt="<?php echo bloginfo('name'); ?>" /></a>
 <?php
}
/* Top and Main Navigation */
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
			'menu_class' => "$menus",
			'menu_id' => "$menus",
			'echo' => false,
			'fallback_cb' => 'wp_page_menu',
			'before' => '',
			'after' => '',
			'link_before' => '',
			'link_after' => '',
			'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth' => 0,
			'walker' => '',);
		echo do_shortcode(wp_nav_menu($defaults));
	}
}


 // Header simple, toggle and custom Search at front end//
function cs_header_search($type='simple'){ ?>
    
<!-- Search Start -->
    <div class="searcharea float-right">
                    <!-- Search Button -->
                    <a href="#searchbox" class="btnsearch btntoggle <?php if($type == "header6"){ ?> bgcolrhover <?php } ?>">
                        <em class="fa fa-search"></em>
                    </a>
                    <!-- Search Box -->
                    <div id="searchbox">
                        <form action="<?php echo home_url() ?>" id="searchform" method="get" role="search">
                            <label>
                                <em class="fa fa-search"></em>
                                <input type="text" name="s" value="<?php _e('Search for:', "Rocky"); ?>"></label>
                            <button type="submit" class="btnsearch bgcolr"><?php _e('Search', "Rocky");?></button>
                        </form>
                    </div>
                </div>
    <!-- Search End -->
<?php
}

/*
* Login function
*/
if ( ! function_exists( 'cs_login' ) ) {
	function cs_login($login='', $logout='', $header_style=''){ 
 		?>
			<nav class="topnav">
				<ul>
					<?php if ( is_user_logged_in() ) { ?>
							<li><a class="logout" href="<?php echo wp_logout_url("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>">
								<?php 
                                if($logout == true && $header_style=='header6')
                                    {
                                        echo '<span>';
                                         _e('Log out', 'Rocky');
                                         echo '</span>';
                                    } else if($logout == true  && $header_style==''){
                                        _e('Log out', 'Rocky');
                                    }
                                ?>
	                            <i class="icon-signout"></i></a></li>
					<?php }else{?>
							 <li><a href="#loginbox" class="login" role="button" data-toggle="modal">
							 	<?php 
									if($login == true && $header_style=='header6')
										{
											echo '<span>';
											 _e('Log In', 'Rocky');
											 echo '</span>';
										} else if($login == true  && $header_style==''){
											_e('Log In', 'Rocky');
										}
								?>
							 	<i class="icon-user"></i></a>
                             </li>
					<?php } ?>
				</ul>
			</nav>
	  
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
		
		<div id="undercontruction">
          <header><?php if($cs_theme_option['showlogo'] == "on"){ cs_uc_logo(); } ?></header>
          <div class="bgcolr" id="midarea">
            <div class="container">
			  <?php echo '<p>'.htmlspecialchars_decode($cs_theme_option['under_construction_text']).'</p>';?>
              
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
						jQuery('#defaultCountdown').countdown({until: austDay});
						jQuery('#year').text(austDay.getFullYear());
					});
				
				</script>
				<div class="countdown styled"></div>
				<div class="countdownit">
					<div id="defaultCountdown"></div>
				</div>
				
              <!--<div id="outerformfld">
                <div class="col-lg-7" id="formcontainer">
                  <label>
                    <input type="text" class="col-lg-4" placeholder="Enter your Email to Subscribe">
                  </label>
                  <button class="btn">SUBMIT</button>
                  <div class="clearfix"></div>
                </div>
              </div>-->
            </div>
          </div>
          <footer>
            <div class="social-network">
                <?php cs_social_network();?>
            </div>
          </footer>
        </div>

	 
	 <?php die();
	 }
	}
} 
/* Widget Section Start */
// widget_facebook start
class cs_facebook_module extends WP_Widget
{
  function cs_facebook_module()
  {
		$widget_ops = array('classname' => 'facebok_widget', 'description' => 'Facebook widget like box total customized with theme.' );
		$this->WP_Widget('cs_facebook_module', 'CS : Facebook', $widget_ops);
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
				<style type="text/css" >
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
add_action( 'widgets_init', create_function('', 'return register_widget("cs_facebook_module");') );
	// widget_facebook end

// Tabs widget
class cs_tabs_widget_show extends WP_Widget {

    function cs_tabs_widget_show() {
        $widget_ops = array('classname' => 'tabs-widget tabs', 'description' => 'Select Widgets from options for tabs');
        $this->WP_Widget('cs_tabs_widget_show', 'ChimpS : Tabs Widget', $widget_ops);
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

add_action('widgets_init', create_function('', 'return register_widget("cs_tabs_widget_show");'));
// Tabs widget end

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
							$image_url = cs_attachment_image_src($path, 150, 150);
							$image_url_full = cs_attachment_image_src($path, 0, 0);
						?>
						 <li>
							<a <?php if ( $description <> '' ) { echo 'data-title="'.$description.'"'; }?> href="<?php if ($use_image_as == 1)echo $video_code;  elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" target="<?php if($use_image_as==2){ echo '_blank'; }else{ echo '_self'; }; ?>" class="link" data-rel="<?php if ($use_image_as == 1) echo "prettyPhoto"; elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>"><?php echo "<img width='60' height='60' src='" . $image_url . "' data-alt='" . $title . "' alt='' />" ?></a>
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
class cs_recentposts extends WP_Widget {
	  function cs_recentposts()
	  {
		$widget_ops = array('classname' => 'widget_latest_news', 'description' => 'Recent Posts from category.' );
		$this->WP_Widget('cs_recentposts', 'CS : Recent Posts', $widget_ops);
	  }
	 
	  function form($instance)
	  {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = $instance['title'];
		$select_category = isset( $instance['select_category'] ) ? esc_attr( $instance['select_category'] ) : '';
		$showcount = isset( $instance['showcount'] ) ? esc_attr( $instance['showcount'] ) : '';	
		$thumb = isset( $instance['thumb'] ) ? esc_attr( $instance['thumb'] ) : '';
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
		<p>
			<label for="<?php echo $this->get_field_id('thumb'); ?>">
				Display Thumbinals:
				<input class="upcoming" id="<?php echo $this->get_field_id('thumb'); ?>" size='2' name="<?php echo $this->get_field_name('thumb'); ?>" value="true" type="checkbox"  <?php if(isset($instance['thumb']) && $instance['thumb']=='true' ) echo 'checked="checked"'; ?> />
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
		$instance['thumb'] = $new_instance['thumb'];
		return $instance;
	  }
	 
		function widget($args, $instance)
		{
			global $cs_node;
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
			$select_category = empty($instance['select_category']) ? ' ' : apply_filters('widget_title', $instance['select_category']);		
			$showcount = empty($instance['showcount']) ? ' ' : apply_filters('widget_title', $instance['showcount']);	
			$thumb = isset( $instance['thumb'] ) ? esc_attr( $instance['thumb'] ) : '';						
	
			if($instance['showcount'] == ""){$instance['showcount'] = '-1';}
			echo $before_widget;	
			// WIDGET display CODE Start
			if (!empty($title) && $title <> ' '){
				echo $before_title;
				echo $title;
				echo $after_title;
			}	$cs_theme_option = get_option('cs_theme_option');
				global $wpdb, $post, $cs_theme_options;?>
				<!-- Recent Posts Start -->
					<ul class="featured_blog">
 						<?php
							wp_reset_query();
							$args = array( 'posts_per_page' => "$showcount",'post_type' => 'post','category_name' => "$select_category"); 
							$custom_query = new WP_Query($args);
							if ( $custom_query->have_posts() <> "" ) {
								while ( $custom_query->have_posts()) : $custom_query->the_post();
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
 									$width 	= 69;
									$height = 53;
 									$image_url = cs_get_post_img_src($post->ID, $width, $height);
 									}
								?>
									<!-- Upcoming Widget Start -->
									
										<?php if($thumb == "true"){?>
											
											<?php
											$no_image = "";
											if($image_url == ""){
											$no_image = 'class="no-image"';
											}
											?>
											<li <?php echo $no_image; ?>>
												<?php
												$no_image = "";
												if(isset($image_url) and $image_url <> ""){
												$no_image = " no-image";
												?>
												<a href="<?php echo get_permalink(); ?>"><img src="<?php echo $image_url; ?>" alt="" class="float-left"></a>
												<?php
												}
												?>
												<?php
												$byadmin_by = __('By: %s','Rocky');
												?>
												<div class="text">
													<h2 class="post-title"><a href="<?php the_permalink();?>" class="colrhover"><?php echo substr(get_the_title(),0,30); if ( strlen(get_the_title()) > 30) echo "..."; ?></a></h2>
													<p class="panel-info"><?php printf($byadmin_by, " "); ?><?php printf( __('%s','Rocky'), '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="colrhover">'.get_the_author().'</a>' );?> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('on','Rocky');}else{ echo $cs_theme_option['trans_other_on']; } echo ' '. get_the_date();?> </p>												
												</div>
											</li>
                                             
											 
										<?php }else{ ?>
										
											<li <?php echo $no_image; ?>>
												<?php
												$byadmin_by = __('By: %s','Rocky');
												?>
												<div class="text">
													<h2 class="post-title"><a href="<?php the_permalink();?>" class="colrhover"><?php echo substr(get_the_title(),0,30); if ( strlen(get_the_title()) > 30) echo "..."; ?></a></h2>
													<p class="panel-info"><?php printf($byadmin_by, " "); ?><?php printf( __('%s','Rocky'), '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="colrhover">'.get_the_author().'</a>' );?> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('on','Rocky');}else{ echo $cs_theme_option['trans_other_on']; } echo ' '. get_the_date();?> </p>												
												</div>
											</li>

										<?php } ?>
									
																		       
								<?php endwhile; ?>
							<?php
                            }
							else {
								echo '<h4>'.__( 'No results found.', 'Rocky' ).'</h4>';
							}?>
  				<!-- Recent Posts End -->    
						</ul> 
				<?php
				echo $after_widget;
			}
		}
		add_action( 'widgets_init', create_function('', 'return register_widget("cs_recentposts");') );
	// widget_recent_post end
	// widget_twitter start
 	class cs_twitter_widget extends WP_Widget {
		function cs_twitter_widget() {
			$widget_ops = array('classname' => 'widget widget_newslatter widget-twitter', 'description' => 'twitter widget');
			$this->WP_Widget('cs_twitter_widget', 'CS : Twitter Widget', $widget_ops);
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
										$update_with = '<a  class="colrhover" href="' . $url->{'url'} . '" target="_blank" title="' . $url->{'expanded_url'} . '">' . $url->{'display_url'} . '</a>';
										$text = str_replace($url->{'url'}, $update_with, $text);
									}
								} else if($type == 'hashtags') {
									foreach($entity as $j => $hashtag) {
										$update_with = '<a  class="colrhover" href="https://twitter.com/search?q=%23' . $hashtag->{'text'} . '&src=hash" target="_blank" title="' . $hashtag->{'text'} . '">#' . $hashtag->{'text'} . '</a>';
										$text = str_replace('#'.$hashtag->{'text'}, $update_with, $text);
									}
								} else if($type == 'user_mentions') {
									foreach($entity as $j => $user) {
										$update_with = '<a  class="colrhover" href="https://twitter.com/' . $user->{'screen_name'} . '" target="_blank" title="' . $user->{'name'} . '">@' . $user->{'screen_name'} . '</a>';
										$text = str_replace('@'.$user->{'screen_name'}, $update_with, $text);
									}
								}					
							}
							$large_ts = time();
							$n = $large_ts - strtotime($tweet->{'created_at'});
							if($n < (60)){ $posted = sprintf(__('%d seconds ago','Rocky'),$n); }
							elseif($n < (60*60)) { $minutes = round($n/60); $posted = sprintf(_n('About a Minute Ago','%d Minutes Ago',$minutes,'Rocky'),$minutes); }
							elseif($n < (60*60*16)) { $hours = round($n/(60*60)); $posted = sprintf(_n('About an Hour Ago','%d Hours Ago',$hours,'Rocky'),$hours); }
							elseif($n < (60*60*24)) { $hours = round($n/(60*60)); $posted = sprintf(_n('About an Hour Ago','%d Hours Ago',$hours,'Rocky'),$hours); }
							elseif($n < (60*60*24*6.5)) { $days = round($n/(60*60*24)); $posted = sprintf(_n('About a Day Ago','%d Days Ago',$days,'Rocky'),$days); }
							elseif($n < (60*60*24*7*3.5)) { $weeks = round($n/(60*60*24*7)); $posted = sprintf(_n('About a Week Ago','%d Weeks Ago',$weeks,'Rocky'),$weeks); } 
							elseif($n < (60*60*24*7*4*11.5)) { $months = round($n/(60*60*24*7*4)) ; $posted = sprintf(_n('About a Month Ago','%d Months Ago',$months,'Rocky'),$months);}
							elseif($n >= (60*60*24*7*4*12)){$years=round($n/(60*60*24*7*52)) ; $posted = sprintf(_n('About a year Ago','%d years Ago',$years,'Rocky'),$years);} 
							$user = $tweet->{'user'};
							$return .="<div id='tweet-1' class='tweet webkit'>";
							$return .= "<h6 class='heading-color'>" . $text . "</h6>";
 							$return .= "<p><a class='hour colrhover'>" . $posted. "</a></p>";
							$return .="</div>";
					}
 					$return .= "</div><i class='fa fa-twitter'></i><p class='twitter-follow'><a href='http://www.twitter.com/".$username."' target='_blank' class='colrhover'>".$cs_theme_option['trans_follow_twitter']."</a></p><div class='clear'></div></div>";
					echo $return;
				}
			}else{
				if($response <> ""){
					echo $response->errors['http_failure'][0];
				}else{
					_e( 'No results found.', 'Rocky' );	
				}
			}
   	 	}else{ 				
			//echo '<h4>No User information given.</h4>';
		}
		echo $after_widget;
		// WIDGET display CODE End
		}
 	}
 	add_action('widgets_init', create_function('', 'return register_widget("cs_twitter_widget");'));
	
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
        $post_types = array('post', 'events' );

        // 
        $where = apply_filters('getarchives_where', "WHERE (post_type='post' || post_type='events' ) AND post_status = 'publish'", '');
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
                $text = sprintf(__('%1$s %2$d','Rocky'), $wp_locale->get_month($arcresult->month), $arcresult->year);

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
 load_theme_textdomain('Rocky', get_template_directory() . '/languages');


if (!isset($content_width)) $content_width = 1170; ?>