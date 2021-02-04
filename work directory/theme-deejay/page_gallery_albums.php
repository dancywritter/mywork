<?php
	global $px_node,$post,$px_theme_option,$px_counter_node,$wpdb;
	if ( !isset($px_node->px_gal_album_media_per_page) || empty($px_node->px_gal_album_media_per_page) ) { $px_node->px_gal_album_media_per_page = -1; }
	if (empty($_GET['page_id_all'])) $_GET['page_id_all'] = 1;
	$args = array('posts_per_page' => "-1", 'paged' => $_GET['page_id_all'], 'post_type' => 'px_gallery', 'category_name' => "$px_node->px_gal_album",'post_status' => 'publish');
	$custom_query = new WP_Query($args);
	$post_count = $custom_query->post_count;
	$args = array('posts_per_page' => "$px_node->px_gal_album_media_per_page", 'post_type' => 'px_gallery', 'paged' => $_GET['page_id_all'], 'px_gallery-category' => "$px_node->px_gal_album");
     $custom_query = new WP_Query($args);
	 
	 if($custom_query->have_posts()):
	 px_enqueue_cycle_script();
	 ?>
	 <div class=" element_size_<?php echo $px_node->gallery_albums_element_size;?>">
     
     	<div class="gallery gallery-listing ">
            <div class="gallery-desc">
            <?php if($px_node->px_gal_album_header_title <> ''){?>
                        <header class="pix-heading-title">
                            <h2 class="pix-page-title"><?php echo $px_node->px_gal_album_header_title;?></h2>
                        </header>
                <?php }?>
                <?php if($px_node->px_gal_album_text <> ''){?>
                	<p>
                    	<?php echo $px_node->px_gal_album_text;?>
                	</p>
                <?php }?>
                <div class="desc-bottom">
                    <a href="#" class="btn btn-prev pix-bgcolrhvr" id="btn-prev-cycle_<?php echo $px_counter_node;?>">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#" class="btn btn-next pix-bgcolrhvr" id="btn-next-cycle_<?php echo $px_counter_node;?>">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </div>
            <div class="gallery-content">
                <script>
					jQuery(document).ready(function($) {
							 galleryheight ()
							 jQuery(window) .resize(function() {
							 galleryheight ()
							 });
							  jQuery(window) .load(function() {
							 galleryheight ()
							 });
							
					});
                </script>
                <div class="cycle-slideshow"  
                    data-cycle-fx="carousel" 
                    data-cycle-slides=" >
                            article"
                    data-cycle-timeout=0
                    data-cycle-next="#btn-next-cycle_<?php echo $px_counter_node;?>"
                    data-cycle-prev="#btn-prev-cycle_<?php echo $px_counter_node;?>">
                    <?php 
                    $qrystr= "";
                    $width 	=318;
                    $height	=660;
                    
                    if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
                    while ($custom_query->have_posts()) : $custom_query->the_post();
                    $no_img = '';
                    $image_url = px_attachment_image_src(get_post_thumbnail_id($post->ID),$width,$height);
					$px_meta_gallery_options = get_post_meta($post->ID, "px_meta_gallery_options", true);
					if ( $px_meta_gallery_options <> "" ) {
						$px_xmlObject = new SimpleXMLElement($px_meta_gallery_options);
						$count_post_images = count($px_xmlObject->gallery);
						
					}
                    if($image_url == ''){ $no_img = 'no-img';}
                    ?>
                    
                    <article <?php post_class($no_img); ?>>
                        <figure>
                            <?php if($image_url <> ''){?><img src="<?php echo $image_url;?>" alt="#"><?php }?>
                         </figure>
                        <div class="text">
                            <?php if($count_post_images > 0){?><a href="<?php the_permalink();?>" class="cout-photo pix-bgcolrhvr"><?php echo $count_post_images;?> photos</a><?php }?>
                            <h2 class="pix-post-title">
                                <a href="<?php the_permalink();?>" class="pix-colrhvr"><?php the_title();?></a>
                            </h2>
                            <time><?php echo get_the_date();?></time>
                        </div>
                    </article>
                    <?php endwhile;?>
                </div>
            </div>
		 <?php
            // pagination start
            $qrystr = '';
             if ( $px_node->px_gal_album_pagination == "Show Pagination" and $post_count > $px_node->px_gal_album_media_per_page and $px_node->px_gal_album_media_per_page > 0 ) {
                    $qrystr = '';
                    if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];						
                echo px_pagination( $count_post, $px_node->px_gal_album_media_per_page,$qrystr );
            }
            // pagination end
            ?>
  </div>
  </div>
 <?php endif;?>

                  