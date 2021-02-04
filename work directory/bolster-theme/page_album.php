<?php
	cs_enqueue_masonry_style_script();
	global $cs_node,$cs_theme_option;
	if ( !isset($cs_node->cs_album_per_page) || empty($cs_node->cs_album_per_page) || $cs_node->cs_album_per_page<0 ) { $cs_node->cs_album_per_page = -1; } else if($cs_node->cs_album_per_page>0 && $cs_node->cs_album_per_page<40){ $cs_node->cs_album_per_page = 40;}
	$cs_album_layout_db = $cs_node->cs_album_layout;
	$cs_album_title = $cs_node->cs_album_title;
	$cs_album_cat_db = $cs_node->cs_album_cat;
	$cs_album_cat_show_db = $cs_node->cs_album_cat_show;
	$cs_album_filterable_db = $cs_node->cs_album_filterable;
	$cs_album_title_db = $cs_node->cs_album_title;
	$cs_album_buynow_db = $cs_node->cs_album_buynow;
 	$cs_album_per_page_db = $cs_node->cs_album_per_page;
	$filter_category = '';
	if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
    $row_cat = $wpdb->get_row("SELECT * from ".$wpdb->prefix."terms WHERE slug = '" . $cs_album_cat_db ."'" );
	if ( isset($_GET['filter_category']) ) {$filter_category = $_GET['filter_category'];}
	else {
		if(isset($row_cat->slug)){
			$filter_category = $row_cat->slug;
		}
	}
    $args = array(
			'posts_per_page'			=> "-1",
			'post_type'					=> 'albums',
			'album-category'			=> "$filter_category",
			'post_status'				=> 'publish',
			'order'						=> 'ASC',
	);
	$custom_query = new WP_Query($args);
	$post_count = 0;
	$post_count = $custom_query->post_count;
     if($cs_album_filterable_db == "On"){?>
        <!-- Aside Section -->
        <script type="text/javascript">
			jQuery(document).ready(function() {
				cs_filters_callback('album-gallery');
			});
		</script>
        <aside class="left-content">
                <div class="filter-albums">
                     <ul id="filters">
                        <li class="bgcolr"><a data-filter="*"><?php if(isset($row_cat->name)){ _e("All",'Bolster'); } ?></a></li>
                        <?php
                            $categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'album-category', 'hide_empty' => 0) );
                            foreach ($categories as $category) {
                            ?>
                             <li><a  data-filter=".<?php echo $category->slug; ?>"><?php echo $category->cat_name?></a></li>
                            <?php 
                            } 
                    	?>
                     </ul>
                </div>
            </aside>
            <!-- Aside Section Close -->
     <?php } ?>
     <?php if($cs_album_per_page_db <> "-1" && $cs_album_per_page_db < $post_count){?>
      <script type="text/javascript">
				 jQuery(document).ready(function() {
					 album_load_more_js(<?php echo $cs_node->cs_album_per_page; ?>, '<?php echo $cs_node->cs_album_buynow; ?>', '<?php echo $post_count;?>', '<?php echo $cs_album_cat_db; ?>', '<?php echo home_url() ?>','<?php echo get_template_directory_uri() ?>');
			   });
			 </script>
        <?php } ?>
         <script type="text/javascript">
			jQuery(document).ready(function() {
				cs_masonary_callback('album-masonry-gallery');
			});
		</script>
 		<div class="cs-album-gallery inline-item cs-white-space">   
                 <!-- Container Album Gallery -->
              <?php if ($cs_node->cs_album_title <>  '' ) {
				  $cs_fullheight = '';
				   ?>
    		<header class="section-header">
        		<h2 class="section-title cs-heading-color"><?php echo $cs_node->cs_album_title; ?></h2>
        	</header>
   	 	<?php  }else{
			$cs_fullheight = 'cs_fullheight';
			} ?>
                <div class="album-gallery album-masonry-gallery <?php echo $cs_fullheight; ?>">
                <?php
                    if($cs_node->cs_album_cat == "all"){
                        $args = array( 'posts_per_page' => "$cs_album_per_page_db", 'paged' => $_GET['page_id_all'], 'post_type' => 'albums' );
                    }else{
                        $args = array( 'posts_per_page' => "$cs_album_per_page_db", 'paged' => $_GET['page_id_all'], 'post_type' => 'albums', 'album-category' => "$row_cat->name");
                      
                    }
               	 	$counter_album_db = 0;
                	 $custom_query = new WP_Query($args);
					while ( $custom_query->have_posts()) : $custom_query->the_post();
						 $cs_album = get_post_meta($post->ID, "cs_album", true);
						 if ( $cs_album <> "" ) {
							  $cs_xmlObject = new SimpleXMLElement($cs_album);
							  	$album_buy_amazon = $cs_xmlObject->album_buy_amazon;
								$album_buy_apple = $cs_xmlObject->album_buy_apple;
								$album_buy_groov = $cs_xmlObject->album_buy_groov;
								$album_buy_cloud = $cs_xmlObject->album_buy_cloud;
								$album_buy_url = $cs_xmlObject->album_buy_url;
						 }
                		$counter_album_db++;
						$width 	= 270;
                    	$height	= 270;
						$cats = array();
                     	$image_url = cs_get_post_img_src($post->ID, $width, $height);
						$categories_list = get_the_terms($post->ID,'album-category');
						$conter = 1;
						if($image_url == ''){ $img_class[]='no-image';}
						foreach($categories_list as $cat){
							$cats[0] = 'mix box';
							$cats[$conter] =$cat->slug;
							$conter++;
						}
                	?>
                    <!-- Album Post -->
                    <article <?php post_class($cats); ?>>
                        <figure>
                         <!-- Album Image -->
                            <?php 
                                if($image_url <> ''){echo "<img src=".$image_url." alt='' >";} else {echo '<img src="' . get_template_directory_uri() . '/images/Dummy.jpg" alt="" />';}
                            ?>
                            <figcaption>
                                <a href="<?php the_permalink(); ?>" class="btnplay"><em class="fa fa-play"></em></a>
                                <p>
                                    <a href="<?php the_permalink(); ?>" class="track-con"><em class="fa fa-music"></em> <?php echo count($cs_xmlObject->track);?>  <?php if($cs_theme_option['trans_switcher']== "on"){ _e('Tracks','Bolster');}else{ echo $cs_theme_option['trans_track']; }?> </a>
                                </p>
                            </figcaption>
                         <!-- Album Image Close -->
                        </figure>
                        <!-- Album Post Description -->    
                        	<div class="desc">
                                            <h2 class="post-title"><a href="<?php the_permalink(); ?>" class="colrhover"><?php echo substr(get_the_title(),0,32); if(strlen(get_the_title()) > 32) echo "..."; ?></a></h2>
                                            <h5><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Release Date','Bolster');}else{ echo $cs_theme_option['trans_release_date']; }?>: <?php echo $cs_xmlObject->album_release_date;?></h5>
                                             <?php if ($cs_node->cs_album_buynow == 'On' && ($album_buy_amazon != '' or $album_buy_apple != '' or $album_buy_groov != '' or $album_buy_cloud != '')) {?>
                                                    <div class="buy-now">
                                                    	<h5><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Buy Now','Bolster');}else{ echo $cs_theme_option['trans_buy_now']; }?></h5>
                                                         <?php 
                                                            if ($album_buy_apple <> "")
                                                                echo ' <a target="_blank" href="' . $album_buy_apple . '" ><img src="' . get_template_directory_uri() . '/images/img-bn1.png" alt="" /></a> ';
                                                            if ($album_buy_amazon <> "")
                                                                echo ' <a target="_blank" href="' . $album_buy_amazon . '" ><img src="' . get_template_directory_uri() . '/images/img-bn2.png" alt="" /></a> ';
                                                            if ($album_buy_cloud <> "")
                                                                echo ' <a target="_blank" href="' . $album_buy_cloud . '" ><img src="' . get_template_directory_uri() . '/images/img-bn4.png" alt="" /></a> ';
                                                            if ($album_buy_groov <> "")
                                                                echo ' <a target="_blank" href="' . $album_buy_groov . '" ><img src="' . get_template_directory_uri() . '/images/img-bn3.png" alt="" /></a> ';	
                                                            if ($album_buy_url <> "")
                                                                echo ' <a target="_blank" href="' . $album_buy_url . '" ><img src="' . get_template_directory_uri() . '/images/img-bn5.png" alt="" /></a> ';				
                                                         ?>
                                                    </div>
                                            <?php }?>
                                        </div>
                        <!-- Album Post Description Close -->     
                    </article>
                    <!-- Album Post Close -->  
				<?php endwhile; ?>                              
                          
                </div>
                <!-- Container Gallery Close -->
             <!-- Album Container Close -->    
 </div>