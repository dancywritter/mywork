<?php
	global $cs_node,$counter_node;
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
	if($cs_node->layout == "gallery-two-col-with-title"){
	?>
	<div class="cs-gallery lightbox element_size_<?php echo $cs_node->gallery_element_size; ?>">

	<?php if ($cs_node->header_title <>  '' ) { ?>
		<header class="heading">
			<h2 class="section-title cs-heading-color"><?php echo $cs_node->header_title; ?></h2>
		</header>
	<?php  } ?>
    <div class="gallerylist fullwidth">
    <?php if($cs_node->view_all <> ''){?>
        	<a class="btnviewall float-right" href="<?php if($cs_node->view_all_url <> ''){ echo $cs_node->view_all_url; }else{ echo '#'; };?>">													   				<em class="fa fa-reorder"></em>
                <?php echo $cs_node->view_all;?>
            </a>
        <?php } ?> 
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
			$image_url = cs_attachment_image_src($path, 570, 320);
			$image_url_full = cs_attachment_image_src($path, 0, 0);
			?>
			<article class="viewme">
				<figure class="viewme">
					<a data-title="<?php if ( $cs_node->desc == "On" ) { echo $description; }?>"  href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" target="<?php if($use_image_as==2) echo '_blank'; ?>" data-rel="<?php if($use_image_as==1)echo "prettyPhoto";  elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>"><?php echo "<img src='".$image_url."' data-alt='".$title."' alt='' />";  ?></a>
				</figure>
				<h2 class="post-title"><a class="colrhover" data-title="<?php if ( $cs_node->desc == "On" ) { echo $description; }?>"  href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" target="<?php if($use_image_as==2) echo '_blank'; ?>" data-rel="<?php if($use_image_as==1)echo "prettyPhoto";  elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>"><?php if($title <> '') echo substr($title, 0, 20); else echo "&nbsp;"; if ( strlen($title) > 20 ) echo " ..."; ?><?php echo "<img style='display:none' data-alt='".$title."' />";  ?></a></h2>
			</article>
			
	<?php
		}
	}
	?>
	</div>
    </div>
	<?php	
	}
	else{
 	?>
	<div class="cs-gallery element_size_<?php echo $cs_node->gallery_element_size; ?>">
    	<?php if ($cs_node->header_title <>  '' ) { ?>
    		<header class="heading">
        		<h2 class="section-title cs-heading-color"><?php echo $cs_node->header_title; ?></h2>
         	</header>
   	 	<?php  } ?>
			<?php if($cs_node->view_all <> ''){?>
        	<a class="btnviewall float-right" href="<?php if($cs_node->view_all_url <> ''){ echo $cs_node->view_all_url; }else{ echo '#'; };?>">													   				<em class="fa fa-reorder"></em>
                <?php echo $cs_node->view_all;?>
            </a>
        <?php } ?> 
     	
			<div class="<?php echo $cs_node->layout; ?> gallerylist gallery lightbox">
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
 					$image_url = cs_attachment_image_src($path, 570, 320);
                    $image_url_full = cs_attachment_image_src($path, 0, 0);
 					?>
					<article>
						<figure>
							<?php echo "<img src='".$image_url."' data-alt='".$title."' alt='' />";  ?>
							
							<?php 
							  if($use_image_as==1){
								  $btn_class = "btnarrow cs-video";
							  }elseif($use_image_as==2){
								  $btn_class = "btnarrow cs-link";	
							  }else{
								  $btn_class = "btnarrow cs-image";
							  }
							?>
							
							<a class="<?php echo $btn_class; ?>" data-title="<?php if ( $cs_node->desc == "On" ) { echo $description; }?>"  href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" target="<?php if($use_image_as==2) echo '_blank'; ?>" data-rel="<?php if($use_image_as==1)echo "prettyPhoto";  elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>"><?php echo "<img style='display:none' data-alt='".$title."' />";  ?></a>						  
							<?php
							if($description <> "" or $title <> ""){
							?>
							<figcaption>
								<h2 class="post-title"><a data-title="<?php if ( $cs_node->desc == "On" ) { echo $description; }?>"  href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" target="<?php if($use_image_as==2) echo '_blank'; ?>" data-rel="<?php if($use_image_as==1)echo "prettyPhoto";  elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>"><?php if($title <> '') echo substr($title, 0, 50); if ( strlen($title) > 50 ) echo " ..."; ?></a></h2>
								<?php
								if ( $cs_node->desc == "On" ){
									echo "<p>".substr($description, 0, 75); if ( strlen($description) > 75 ) echo " ...</p>";
								}
								?>
							</figcaption>
							<?php
							}
							?>
						</figure>
					</article>
					
                    <?php
                }
            } 
            ?>
            </div>
          </div>
		<?php
	}
         	// pagination start
       		$qrystr = '';
             if ( $cs_node->pagination == "Show Pagination" and $count_post > $cs_node->media_per_page and $cs_node->media_per_page > 0 ) {
                    $qrystr = '';
                    if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];						
                echo cs_pagination( $count_post, $cs_node->media_per_page,$qrystr );
            }
         	// pagination end
    	?>

 <div class="clear"></div>