<?php
	cs_enqueue_masonry_style_script();
	global $cs_node,$post,$cs_theme_option,$wpdb;
	if ( !isset($cs_node->cs_artist_per_page) || empty($cs_node->cs_artist_per_page) || $cs_node->cs_artist_per_page<0  ) { $cs_node->cs_artist_per_page = -1; } else if($cs_node->cs_artist_per_page>0 && $cs_node->cs_artist_per_page<40){ $cs_node->cs_artist_per_page = 40;}
	$cs_fullheight = '';
	if ($cs_node->cs_artist_title ==  '' ) {
		$cs_fullheight = 'cs_fullheight';
	} 
		cs_enqueue_masonry_style_script();
        if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
			$args = array(
				'posts_per_page'			=> "-1",
				'post_type'					=> 'artists',
				'artists-category'			=> "$cs_node->cs_artist_category",
				'post_status'				=> 'publish',
				'order'						=> 'ASC',
			);
            $custom_query = new WP_Query($args);
            $count_post = 0;
			$count_post = $custom_query->post_count;
			if($cs_node->cs_artist_category == "all"){
				$args = array(
					'posts_per_page'			=> "$cs_node->cs_artist_per_page",
					'paged'						=> $_GET['page_id_all'],
					'post_type'					=> 'artists',
 					'post_status'				=> 'publish',
					'order'						=> 'DESC',
				 );
			}else{
				$args = array(
					'posts_per_page'			=> "$cs_node->cs_artist_per_page",
					'paged'						=> $_GET['page_id_all'],
					'post_type'					=> 'artists',
					'artists-category'			=> "$cs_node->cs_artist_category",
					'post_status'				=> 'publish',
					'order'						=> 'DESC',
				 );
			}
		$custom_query = new WP_Query($args);
    ?>
    <?php if($cs_node->cs_artist_per_page <> "-1" && $cs_node->cs_artist_per_page < $count_post){?>
		<script type="text/javascript">
		// Load more artist js
             jQuery(document).ready(function() {
                     artist_load_more_js(<?php echo $cs_node->cs_artist_per_page; ?>, '<?php echo $cs_node->cs_artist_view; ?>', '<?php echo $count_post;?>', '<?php echo $cs_node->cs_artist_category; ?>', '<?php echo home_url() ?>','<?php echo get_template_directory_uri() ?>');
                });
         </script>
         <?php } ?>
	<?php if ($cs_node->cs_artist_view == "gird_view") {?>
            <div class="artist-area inline-item">
            <?php if($cs_node->cs_artist_filterables == 'Yes'){?>
            <script type="text/javascript">
				jQuery(document).ready(function() {
 					cs_filters_callback('cs-filterable');
				});
			</script>
                <div class="category-filter inline-item">
                    <ul id="filters">
                            <li class="bgcolr"><a data-filter="*"><?php _e("All",'Bolster'); ?></a></li>
                             <?php
                                $row_cat = $wpdb->get_row("SELECT * from ".$wpdb->prefix."terms WHERE slug = '" . $cs_node->cs_artist_category ."'" );
                                $categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'artists-category', 'hide_empty' => 0) );
                                foreach ($categories as $category) {
                                ?>
                                    <li><a data-filter=".<?php echo $category->slug; ?>" href="#"><?php echo $category->cat_name?></a></li>
                                <?php }?>
                     </ul>
                </div>
            <?php }?>
           	 	<script type="text/javascript">
					jQuery(document).ready(function() {
 						LoadedItem ("gallerymas article");
						cs_masonary_callback('gallerymas');
					});
				</script>
                <div class="artist-gallery-wrapper inline-item">
                <?php if($cs_node->cs_artist_title <> ''){?>
                		<header class="section-header">
                                <h2 class="section-title cs-heading-color"><?php echo $cs_node->cs_artist_title;?></h2>
                        </header>
                     <?php }?>
                    <div class="artist-gallery-sec album-masonry-gallery gallerymas cs-filterable <?php echo $cs_fullheight.' '.$cs_node->cs_artist_view; ?>">
                                 <!-- Album Post -->
                               <?php
						$count_first = 0;
						$cats = array();
                       	if ( $custom_query->have_posts() <> "" ) {
							while ( $custom_query->have_posts() ): $custom_query->the_post();
									$img_class =  array();
									$cats = array();
									$image_url = cs_get_post_img_src($post->ID, 270, 270);
									if($image_url == ''){ $img_class[]='no-image';}
									$categories_list = get_the_terms($post->ID,'artists-category');
									$conter = 1;
									foreach($categories_list as $cat){
										$cats[0] = 'mix';
										$cats[$conter] =$cat->slug;
										$conter++;
									}
                                ?>
                            <!-- Album Post -->
                                <article <?php post_class($cats); ?>>
                                    <figure>
                                     <!-- Album Image -->
                                     <a href="<?php the_permalink();?>" >
                                         <?php 
											if($image_url <> ''){echo "<img src=".$image_url." alt='' >";} else {echo '<img src="' . get_template_directory_uri() . '/images/artist_default.jpg" alt="" />';}
											?>
                                     <!-- Album Image Close -->
                                     <i class="fa fa-circle fa-stack-2x"></i> <i class="fa fa-link fa-stack-1x fa-inverse"></i>
                                     </a>
                                     
                                    </figure>
                                     <!-- Album Post Description -->    
                                        <div class="desc">
                                        	<h2 class="post-title"><a href="<?php the_permalink();?>" ><?php the_title();?></a></h2>
                                            
                                            <div class="tags-area">
                                             <?php 
												$before_cat = '';
												$categories_list = get_the_term_list ( get_the_id(), 'artists-category', $before_cat, ', ', '' );
												if ( $categories_list ){ printf( __( '%1$s', 'Bolster' ),$categories_list ); }
											?> 
                                            <a class="btnlikes"><em class="fa fa-heart"></em>&nbsp;
                                            <span>
                                            <?php
												$cs_like_counter = get_post_meta(get_the_id(), "cs_like_counter", true);
												if ( !isset($cs_like_counter) or empty($cs_like_counter) ) $cs_like_counter = 0;
												echo $cs_like_counter;
												
											?>
                                            </span>
                                            <?php if($cs_theme_option['trans_switcher']== "on"){ _e('Likes','Bolster');}else{ echo $cs_theme_option['trans_likes']; }?>
                                            </a>
                                            </div>
                                        </div>
                                   <!-- Album Post Description Close -->     
                                </article>
                            <!-- Album Post Close -->
                             <?php 
							 endwhile; } ?>
                </div>
            </div>
            </div>
	<?php } else {?>
       		<div class="main-wrapp inline-item">
        	<?php if($cs_node->cs_artist_title <> ''){ ?>
                <header class="section-header">
                        <h2 class="section-title cs-heading-color"><?php echo $cs_node->cs_artist_title;?></h2>
                </header>
         	<?php }?>
            <script type="text/javascript">
					jQuery(document).ready(function() {
						LoadedItem ("artist-gallery article");
						cs_masonary_callback('gallerymas')
						artist_grid_view()
					});
					jQuery(window).load(function() {
						jQuery("body").trigger('resize')
						artist_grid_view()
					});
						jQuery(window).resize(function() {
						artist_grid_view()
					});
				</script>    
           <div class="artist-gallery cs-filterable gallerymas <?php echo $cs_fullheight.' '.$cs_node->cs_artist_view; ?>">
           
                <!-- Artist Gallery -->
                <?php 
                    if ( $custom_query->have_posts() <> "" ) {
                    while ( $custom_query->have_posts() ): $custom_query->the_post();
                        $img_class =  array();
                        $image_url = cs_get_post_img_src($post->ID, 270, 270);
                        if($image_url == ''){ $img_class[]='no-image';}
                ?>
                    <article <?php post_class($img_class);?>>
                            <figure>
                               <?php 
                                if($image_url <> ''){echo "<img src=".$image_url." alt='' >";} else {echo '<img src="' . get_template_directory_uri() . '/images/artist_default.jpg" alt="" />';}
                                ?>
                                <figcaption>
                                    <h2 class="post-title"><a href="<?php the_permalink();?>" ><?php the_title();?></a></h2>
                                    <div class="bottompanel">
                                        <?php 
                                            $before_cat = '<h5>';
                                            $categories_list = get_the_term_list ( get_the_id(), 'artists-category', $before_cat, ' / ', '</h5>' );
                                            if ( $categories_list ){ printf( __( '%1$s', 'Bolster' ),$categories_list ); }
                                        ?> 
                                    </div>
                                    <p><?php  cs_get_the_excerpt('89',true);
									wp_link_pages();
									?></p>
                                    <?php 
                                $args = array(
                                            'post_type' => 'albums',
                                            'meta_key' => 'cs_album_artists',
                                            'meta_query' => array(
                                                array(
                                                    'key' => 'cs_album_artists',
                                                    'value' => $post->post_name,
                                                    'compare' => '=',
                                                )),
                                            'orderby' => 'ID',
                                            'order' => 'ASC',
                                        );
                                    $myposts = get_posts($args);
                                    $total_count = count($myposts);
                                    if ( !isset($total_count) or empty($total_count) ) $total_count = 0;
                            ?>
                                    <p class="artist-albums"><em class="fa fa-music">&nbsp;</em> <?php echo $total_count;?> <?php if($cs_theme_option['trans_switcher']== "on"){ _e('Albums','Bolster');}else{ echo $cs_theme_option['trans_albums']; } ?></p>
                                </figcaption>
                            </figure>
                        </article>
                <?php 
                    endwhile; } 
                ?>
                <!-- Artist Gallery Close -->
          </div>
    </div>
     <?php }?>
