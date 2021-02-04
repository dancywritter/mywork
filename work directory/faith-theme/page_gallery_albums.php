<?php
cs_cycleslider_script();
	global $cs_node,$post,$cs_theme_option,$cs_counter_node,$wpdb;
	if ( !isset($cs_node->cs_gal_album_media_per_page) || empty($cs_node->cs_gal_album_media_per_page) ) { $cs_node->cs_gal_album_media_per_page = -1; }
	if (empty($_GET['page_id_all'])) $_GET['page_id_all'] = 1;
	$args = array('posts_per_page' => "-1", 'paged' => $_GET['page_id_all'], 'post_type' => 'cs_gallery', 'category_name' => "$cs_node->cs_gal_album",'post_status' => 'publish');
	$custom_query = new WP_Query($args);
	$post_count = $custom_query->post_count;
	$args = array('posts_per_page' => "$cs_node->cs_gal_album_media_per_page", 'post_type' => 'cs_gallery', 'paged' => $_GET['page_id_all'], 'cs_gallery-category' => "$cs_node->cs_gal_album");
     $custom_query = new WP_Query($args);
	 ?>
	 <div class=" element_size_<?php echo $cs_node->cs_gallery_album_element_size;?>">
       <!-- Latest Video Start -->
        <div class="gallery gallery-list">
        	 <header class="cs-heading-title">
             <?php if($cs_node->cs_gal_album_header_title <> ''){?>
             <h2 class="cs-section-title cs-heading-color"><?php echo $cs_node->cs_gal_album_header_title;?></h2>
             <?php }?>
             <?php if($cs_node->cs_gal_ablum_view == "galleryablum-slider"){?>
                 <div class="center">
                      <a href="" class="cs-btnprev" id="btn-prev-cycle"><i class="fa fa-angle-left"></i></a>
                      <a href="" class="cs-btnnext" id="btn-next-cycle"><i class="fa fa-angle-right"></i></a>
                  </div>
              <?php } ?>
             </header>
            <!-- Minus Column Start -->
            <?php 
				if($custom_query->have_posts()):
				$qrystr= "";
				$width 	=325;
				$height	=183;
				$image_url = '';
			?>
          	<?php if($cs_node->cs_gal_ablum_view =="galleryablum-slider") {?>
             <div style="display:none" class="cycle-slideshow fullwidth"  
                                data-cycle-fx="carousel" 
                                data-cycle-slides=" > article"
                                data-cycle-timeout=0
                                data-cycle-next="#btn-next-cycle"
                                data-cycle-prev="#btn-prev-cycle">
               <?php }else{
				   echo '<div class="cs-galleryablum-grid">';
				}?>
            
				<?php
                if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
				while ($custom_query->have_posts()) : $custom_query->the_post();
				
				$image_url = cs_attachment_image_src(get_post_thumbnail_id($post->ID),$width,$height);
				if($image_url == ''){$image_url = get_template_directory_uri().'/images/default-album.jpg';}
				?>
                <article <?php post_class(); ?>>
                    <figure >
                    	<a href="<?php the_permalink();?>"><img src="<?php echo $image_url;?>" alt=""></a>
                         <figcaption>
                          	<a href="<?php the_permalink(); ?>"><i class="fa fa-plus-circle"></i></a>
                          </figcaption>
                    </figure>
                    <div class="text">
                      <h2 class="cs-post-title cs-heading-color"><a class="cs-colrhvr" href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                      <ul class="post-options">
                          <li><a href="<?php the_permalink();?>"><?php echo cs_image_count($post->ID); 
						  if($cs_theme_option['trans_switcher'] == "on"){ _e('Photos','Faith');}else{ if(isset($cs_theme_option['trans_other_photos'])) echo $cs_theme_option['trans_other_photos']; }
						 ?></a></li>
                          <li><time datetime="2008-02-14"><?php echo get_the_date();?></time></li>
                      </ul>
                  </div>
                </article>
                <?php endwhile; ?>
            </div>
             <?php endif;?>
        </div>
         <?php
		// pagination start
		$qrystr = '';
		 if ( $cs_node->cs_gal_album_pagination == "Show Pagination" and $post_count > $cs_node->cs_gal_album_media_per_page and $cs_node->cs_gal_album_media_per_page > 0 ) {
				$qrystr = '';
				if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];						
			echo cs_pagination( $count_post, $cs_node->cs_gal_album_media_per_page,$qrystr );
		}
		// pagination end
		?>
      <!-- Latest Video End -->
      <div class="clear"></div>
	</div>      
                  