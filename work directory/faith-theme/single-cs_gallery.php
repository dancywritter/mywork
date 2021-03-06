<?php
	global $cs_node,$cs_theme_option,$counter_node,$video_width;
	$cs_node = new stdClass();
	$cs_node->media_per_page = -1;
 	
  	get_header();
	if (have_posts()):
	while (have_posts()) : the_post();
 	$count_post =0;
 	// galery slug to id start

	// galery slug to id end
	$cs_meta_gallery_options = get_post_meta($post->ID, "cs_meta_gallery_options", true);
	if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
	// pagination start
	if ( $cs_meta_gallery_options <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($cs_meta_gallery_options);
		if ($cs_node->media_per_page > 0 ) {
			$limit_start = $cs_node->media_per_page * ($_GET['page_id_all']-1);
			$limit_end = $limit_start + $cs_node->media_per_page;
			$count_post = count($cs_xmlObject->gallery);
				if ( $limit_end > count($cs_xmlObject->gallery) ) 
					$limit_end = count($cs_xmlObject->gallery);
		}
		else {
			$limit_start = 0;
			$limit_end = count($cs_xmlObject->gallery);
			$count_post = count($cs_xmlObject->gallery);
		}
	}
	?>
  <div class="col-sm-12 col-md-12">
     <div class="gallerysec gallery">
        <ul class="gallery-four-col lightbox clearfix">
         <?php
		
            if ( $cs_meta_gallery_options <> "" and $count_post > 0) {
				
                for ( $i = $limit_start; $i < $limit_end; $i++ ) {
                    $path = $cs_xmlObject->gallery[$i]->path;
                    $title = $cs_xmlObject->gallery[$i]->title;
                    $description = $cs_xmlObject->gallery[$i]->description;
                    $social_network = $cs_xmlObject->gallery[$i]->social_network;
                    $use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;
                    $video_code = $cs_xmlObject->gallery[$i]->video_code;
                    $link_url = $cs_xmlObject->gallery[$i]->link_url;
 					$image_url = cs_attachment_image_src($path, 330, 248);
                    $image_url_full = cs_attachment_image_src($path, 0, 0);
 					?>
            <li>
            	<a  data-rel="<?php if($use_image_as==1)echo "prettyPhoto";  elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>" href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" target="<?php if($use_image_as==2) echo '_blank'; ?>" data-title=" rel="prettyPhoto">
                            <figure>
                            <?php echo "<img src='".$image_url."' data-alt='".$title."' alt='' />";  ?>
                            <figcaption>
                                 <span class="bghover"></span>
                                 <div class="text">
								   <?php 
										  if($use_image_as==1){
											  echo '<i class="fa fa-video-camera"></i>';
										  }elseif($use_image_as==2){
											  echo '<i class="fa fa-link"></i>';	
										  }else{
											  echo '<i class="fa fa-picture-o"></i>';
										  }
									  ?>
								</div>
                                </figcaption>
                        	</figure>
                   </a>
            </li>
   <?php } ?>
   
   		</ul>
	<?php	}else{
 			echo cs_no_result_found();
		}?>
   </div>
</div>      
<?php endwhile;   endif;?>
<!--Footer-->
<?php get_footer(); ?>
