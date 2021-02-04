<?php
	global $cs_node,$cs_counter_node;
 	$count_post =0;
	cs_enqueue_gallery_style_script();
	$gal_album_db = $cs_node->album;
	// galery slug to id start
		$args=array(
			'name' => $gal_album_db,
			'post_type' => 'cs_gallery',
			'post_status' => 'publish',
			'showposts' => 1,
		);
 		$get_posts = get_posts($args);
		if($get_posts){
			$gal_album_db = $get_posts[0]->ID;
		}
	// galery slug to id end
	$cs_meta_gallery_options = get_post_meta($gal_album_db, "cs_meta_gallery_options", true);
	if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
	// pagination start
	if ( $cs_meta_gallery_options <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($cs_meta_gallery_options);
		if ($cs_node->media_per_page > 0 ) {
			$limit_start = $cs_node->media_per_page * ($_GET['page_id_all']-1);
			$limit_end = $limit_start + $cs_node->media_per_page;
			$count_post = count($cs_xmlObject);
				if ( $limit_end > count($cs_xmlObject) ) 
					$limit_end = count($cs_xmlObject);
		}
		else {
			$limit_start = 0;
			$limit_end = count($cs_xmlObject);
			$count_post = count($cs_xmlObject);
		}
	}
	cs_enqueue_jcycle_script();
 	?>
	<div class="element_size_<?php echo $cs_node->gallery_element_size; ?>">
    	<?php if ($cs_node->header_title <>  '' ) { ?>
    		<header class="heading">
        		<h2 class="section-title heading-color"><?php echo $cs_node->header_title; ?></h2>
        	</header>
   	 	<?php  } 
			if($cs_node->layout == 'gallery-masonry'){ 
			 	cs_enqueue_masonry_style_script();
			?>
 			  <script type="text/javascript">
              		jQuery(document).ready(function(){ 
 						var container = jQuery('#container<?php echo $cs_counter_node; ?>');
						jQuery(container).imagesLoaded( function(){
						jQuery(container).isotope({
						columnWidth: 10,
						itemSelector: '.box'
 						});
					});
					if (jQuery.browser.msie && navigator.userAgent.indexOf('Trident')!==-1){
						jQuery(container).isotope({
						columnWidth: 10,
						itemSelector: '.box'
 					});
				}	
 				});
               </script>
			  <div class="gallerysec gallery mas-con" id="container<?php echo $cs_counter_node; ?>">
             	<ul  class="<?php echo $cs_node->layout; ?> lightbox clearfix">
				<?php
     				if ( $cs_meta_gallery_options <> "" ) {
						for ( $i = $limit_start; $i < $limit_end; $i++ ) {
						$path = $cs_xmlObject->gallery[$i]->path;
						$title = $cs_xmlObject->gallery[$i]->title;
						$description = $cs_xmlObject->gallery[$i]->description;
						$social_network = $cs_xmlObject->gallery[$i]->social_network;
						$use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;
						$video_code = $cs_xmlObject->gallery[$i]->video_code;
						$link_url = $cs_xmlObject->gallery[$i]->link_url;
						$image_url = cs_attachment_image_src($path, 570, 428);
						$image_url_full = cs_attachment_image_src($path, 0, 0);
  						?>
						<li class="box photo">
                        	<!-- Gallery Listing Item Start -->
								
								<figure class="viewme">
								<a class="link" data-title="<?php if ( $cs_node->desc == "On" ) { echo $description;}?>"  href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" target="<?php if($use_image_as==2) echo '_blank'; ?>" data-rel="<?php if($use_image_as==1)echo "prettyPhoto";  elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>">
                                <?php echo "<img src='".$image_url_full."' data-alt='".$title."' alt='' />"; ?>
                                
								<figcaption>
								 <span class="absolute"></span>
								 <div class="figinner">
									 <?php 
											if($use_image_as==1){
												echo '<i class="icon-play-sign icon-2x"></i>';
											}elseif($use_image_as==2){
												echo '<i class="icon-link icon-2x"></i>';	
											}else{
												echo '<i class="icon-zoom-in icon-2x"></i>';
											}
											if($title <> ''){
												echo "<h6>".$title."</h6>";
											}
											if ( $cs_node->desc == "On" ){
												 echo "<p>".substr($description, 0, 75); if ( strlen($description) > 75 ) echo " ...</p>";
											}
										?>
									 </div>
								</figcaption>
								</a>
								</figure>
							<span class="active_bg"></span>
                         </li>
						<?php
					}
				}
			?>
            </ul>
            </div>
            <?php
		 
			}else{
			?>
			<div class="gallerysec gallery">
	            <ul class="<?php echo $cs_node->layout; ?> lightbox clearfix">
            	<?php
            	if ( $cs_meta_gallery_options <> "" ) {
					$asa = 0;
					for ( $i = $limit_start; $i < $limit_end; $i++ ) {
						$path = $cs_xmlObject->gallery[$i]->path;
						$title = $cs_xmlObject->gallery[$i]->title;
						$description = $cs_xmlObject->gallery[$i]->description;
						$social_network = $cs_xmlObject->gallery[$i]->social_network;
						$use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;
						$video_code = $cs_xmlObject->gallery[$i]->video_code;
						$link_url = $cs_xmlObject->gallery[$i]->link_url;
						$image_url = cs_attachment_image_src($path, 570, 428);
						$image_url_full = cs_attachment_image_src($path, 0, 0);
						
						?>
                    	<li>
                      	<figure>
                            <?php echo "<img src='".$image_url."' data-alt='".$title."' alt='' />";  ?>
							<a class="link" data-title="<?php if ( $cs_node->desc == "On" ) { echo $description; }?>"  href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" target="<?php if($use_image_as==2) echo '_blank'; ?>" data-rel="<?php if($use_image_as==1)echo "prettyPhoto";  elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>">
                            <figcaption>
                                 <span class="absolute"></span>
                                 <div class="figinner">
									   <?php 
                                              if($use_image_as==1){
                                                  echo '<i class="icon-play-sign icon-2x"></i>';
                                              }elseif($use_image_as==2){
                                                  echo '<i class="icon-link icon-2x"></i>';	
                                              }else{
                                                  echo '<i class="icon-zoom-in icon-2x"></i>';
                                              }
                                              if($title <> ''){
                                                  echo "<h6>".$title."</h6>";
                                              }
                                              //if ( $cs_node->desc == "On" ){
                                                   //echo "<p>".substr($description, 0, 75); if ( strlen($description) > 75 ) echo " ...</p>";
                                              //}
                                          ?>
								</div>
							</figcaption>
						</a>
						</figure>
                        
						<span class="active_bg"></span>
                    </li>
                    <?php
                	}
           	 	} 
            	?>
            	</ul>
            </div>
         <?php } ?>
         <?php
         	// pagination start
       		$qrystr = '';
             if ( $cs_node->pagination == "Show Pagination" and $count_post > $cs_node->media_per_page and $cs_node->media_per_page > 0 ) {
                echo "<nav class='pagination'><ul>";
                    $qrystr = '';
                    if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];						
                echo cs_pagination( $count_post, $cs_node->media_per_page,$qrystr );
                echo "</ul></nav>";
            }
         	// pagination end
    	?>
 </div>
