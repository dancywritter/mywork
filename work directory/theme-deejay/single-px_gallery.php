<?php
	global $px_node,$px_theme_option,$px_counter_node;
	$px_node = new stdClass();
	$px_node->media_per_page = -1;
  	get_header();
	if (have_posts()):
	while (have_posts()) : the_post();
 	$count_post =0;
	px_enqueue_gallery_style_script();
	// galery slug to id start

	// galery slug to id end
	$px_meta_gallery_options = get_post_meta($post->ID, "px_meta_gallery_options", true);
	if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
	// pagination start
	if ( $px_meta_gallery_options <> "" ) {
		$px_xmlObject = new SimpleXMLElement($px_meta_gallery_options);
			$limit_start = 0;
			$limit_end = count($px_xmlObject->gallery);
			$count_post = count($px_xmlObject->gallery);
	}
	?>
 <div class="col-sm-12 col-md-12">

    <h1 class="pix-page-title"><?php the_title();?></h1>
         <div class="gallerysec gallery">
            <ul class="<?php echo $px_node->layout;?> lightbox clearfix">
             <?php
                if ( $px_meta_gallery_options <> "" ) {
                    for ( $i = $limit_start; $i < $limit_end; $i++ ) {
                        $path = $px_xmlObject->gallery[$i]->path;
                        $title = $px_xmlObject->gallery[$i]->title;
                        $use_image_as = $px_xmlObject->gallery[$i]->use_image_as;
                        $video_code = $px_xmlObject->gallery[$i]->video_code;
                        $link_url = $px_xmlObject->gallery[$i]->link_url;
                        $image_url = px_attachment_image_src($path, 456, 344);
                        $image_url_full = px_attachment_image_src($path, 0, 0);
                        $link_target = '';
                        if($use_image_as==2){
                            $link_target = 	'target="_blank"';
                        }
                        ?>
                <li <?php if($use_image_as==1){ echo 'class="video-gallery-img"'; }?>>
                    <figure>
                        <img src="<?php echo $image_url;?>" alt="">
                        <figcaption>
                                <a  data-rel="<?php if($use_image_as==1)echo "prettyPhoto";  elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>" href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" <?php echo $link_target;?> data-title="<?php if ( $title <> "" ) { echo $title; }?>" >
                                <?php 
                                  if($use_image_as==1){
                                      echo '<i class="fa fa-video-camera"></i>';
                                  }elseif($use_image_as==2){
                                      echo '<i class="fa fa-link"></i>';	
                                  }else{
                                      echo '<i class="fa fa-plus"></i>';
                                  }
                                ?>
                                </a>
                        </figcaption>
                    </figure>
                </li>
       <?php }}?>
            </ul>
       </div>
       
   </div>
     
<?php endwhile;   endif;?>
<!--Footer-->
<?php get_footer(); ?>
