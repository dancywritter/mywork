<?php
	global $cs_node, $cs_theme_option, $counter_node;
	if ( !isset($cs_node->cs_album_per_page) || empty($cs_node->cs_album_per_page) ) { $cs_node->cs_album_per_page = -1; }
	$filter_category = '';
	$row_cat = $wpdb->get_row("SELECT * from ".$wpdb->prefix."terms WHERE slug = '" . $cs_node->cs_album_cat ."'" );
	        if ( isset($_GET['filter_category']) ) {$filter_category = $_GET['filter_category'];}
        else {
            if(isset($row_cat->slug)){
            $filter_category = $row_cat->slug;
            }
        }
		 if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
				$args = array(
					'posts_per_page'			=> "-1",
					'post_type'					=> 'albums',
					'post_status'				=> 'publish',
					'order'						=> 'ASC',
				);
			if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
				$event_category_array = array('album-category' => "$filter_category");
				$args = array_merge($args, $event_category_array);
			}
			$custom_query = new WP_Query($args);
			$count_post = 0;
			$count_post = $custom_query->post_count;
?>
 <script type="text/javascript">
    jQuery(document).ready(function($){
        jQuery('.icon-btn').tooltip();
    });
</script>

<div class="element_size_<?php echo $cs_node->album_element_size;?>">
 <div class="<?php if($cs_node->cs_album_view == 'Grid View'){ echo 'new-releases releases-four-coll';} else if($cs_node->cs_album_view == 'List View') { echo 'event albums-list';} else { echo 'new-releases';}?>">
 <?php if ($cs_node->cs_album_title <> '' || $cs_node->cs_album_filterable == "On") {?>
     <header class="cs-heading-title">
        <?php if ($cs_node->cs_album_title <> '') { ?><h2 class="cs-section-title cs-heading-color"><?php echo $cs_node->cs_album_title;?></h2>
        <?php if($cs_node->cs_album_filterable == "On" && $cs_node->cs_album_view == 'List View'){
                            $qrystr= "";
                            if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
                        ?>  
                        <div class="sortby">
                            <ul>
                                <li><a href="<?php the_permalink();?>"><?php _e('All', 'Spikes');?></a></li>
                                <?php  if($cs_node->cs_album_cat <> ''  && $cs_node->cs_album_cat <> '0'){
									$categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'album-category', 'hide_empty' => 0) );
								} else {
									$categories = get_categories( array('taxonomy' => 'album-category', 'hide_empty' => 0) );
								}
								foreach ($categories as $category) {?>
								<li <?php if($category->slug==$filter_category){echo 'class="active"';}?>><a href="?<?php echo $qrystr."&filter_category=".$category->slug?>"><?php echo $category->cat_name?></a></li>
                                <?php }?>
							</ul>
                	</div>
                    <?php }?>
        
    </header>
 
 <?php 
	}}
 if($cs_node->cs_album_view == 'Grid View'){
 	$args = array(
				'posts_per_page'			=> "$cs_node->cs_album_per_page",
				'paged'						=> $_GET['page_id_all'],
				'post_type'					=> 'albums',
				'post_status'				=> 'publish',
				'order'						=> 'ASC',
			 );
			if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
				$event_category_array = array('album-category' => "$filter_category");
				$args = array_merge($args, $event_category_array);
			}
			$custom_query = new WP_Query($args);
			if ( $custom_query->have_posts() <> "" ):
 	  	$width = 228; 
		$height = 205;
		$counter_album = $counter_count = 0;
		while ( $custom_query->have_posts() ): $custom_query->the_post();
		$cs_album = get_post_meta($post->ID, "cs_album", true);
		if ( $cs_album <> "" ) {
			$counter_album_tracks = 0;
			$album_track_mp3_url_audio = '';
			$cs_xmlObject = new SimpleXMLElement($cs_album);
				$album_release_date_db = $cs_xmlObject->album_release_date;
				$album_buynow = $cs_xmlObject->album_buynow;
		}
		$image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID),$width,$height ); 
		if($image_url == ''){
			$noimg = 'no-img';
		}else{
			$noimg  ='';
		}
 ?>
        <article <?php post_class($noimg);?>>
            <figure>
                <a href="<?php the_permalink();?>"><img src="<?php echo $image_url;?>" alt=""></a>
                <figcaption>
                    <a href="<?php the_permalink();?>"><i class="fa fa-headphones fa-3x"></i></a>
                </figcaption>
            </figure>
            <div class="text webkit">
            	
                <h2 class="cs-post-title cs-heading-color"><a href="<?php the_permalink();?>"><?php echo substr(get_the_title(), 0, 33); if(strlen(get_the_title())>33) echo '...'; ?></a></h2>
                <div class="album_heading">
                <?php
                /* translators: used between list items, there is a space after the comma */
                $before_cat = '<div class="cs-event-catgories">';
                $categories_list = get_the_term_list ( get_the_id(), 'album-category', $before_cat, ', ', '</div>' );
                if ( $categories_list ){
                printf( __( '%1$s', 'Spikes'),$categories_list );
                }
                
                ?>
                
                <div class="social-area">
                    <div class="social-network">
                        <?php if($cs_xmlObject->album_buy_amazon <> ''){?><a title="" data-placement="top" data-toggle="tooltip" data-original-title="Itunes" href="<?php echo $cs_xmlObject->album_buy_amazon;?>" class="icon-btn icon1"></a><?php }?>
                        <?php if($cs_xmlObject->album_buy_apple <> ''){?><a title="" data-placement="top" data-toggle="tooltip" data-original-title="Itunes" href="<?php echo $cs_xmlObject->album_buy_apple;?>" class="icon-btn icon2"></a><?php }?>
                        <?php if($cs_xmlObject->album_buy_groov <> ''){?><a title="" data-placement="top" data-toggle="tooltip" data-original-title="Itunes" href="<?php echo $cs_xmlObject->album_buy_groov;?>" class="icon-btn icon3"></a><?php }?>
                        <?php if($cs_xmlObject->album_buy_cloud <> ''){?><a title="" data-placement="top" data-toggle="tooltip" data-original-title="Itunes" href="<?php echo $cs_xmlObject->album_buy_cloud;?>" class="icon-btn icon4"></a><?php }?>
                    </div>
                    <?php if($album_buynow <> ''){?><a href="<?php echo $album_buynow;?>" class="bay-btn uppercase"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Buy Now','Spikes');}else{ echo $cs_theme_option['trans_album_buynow']; } ?></a><?php }?>
                </div>
                </div>
            </div>
        </article>
        <?php endwhile; endif;
 } else if($cs_node->cs_album_view == 'home_view') {
	 cs_cycleslider_script();
	 ?>
        <div class="center">
            <a id="prev<?php echo $counter_node;?>" href="#" class="prev-btn bordercolr colr backcolrhover"><i class="fa fa-angle-left fa-1x"></i></a>
            <a id="next<?php echo $counter_node;?>" href="#" class="next-btn bordercolr colr backcolrhover"><i class="fa fa-angle-right fa-1x"></i></a>
        </div>
        <div class="cycle-slideshow"
        data-cycle-timeout=40000
        data-cycle-fx=carousel
        data-cycle-slides="article"
        data-cycle-carousel-fluid="false"
        data-allow-wrap="true"
            data-cycle-next="#next<?php echo $counter_node;?>"
            data-cycle-prev="#prev<?php echo $counter_node;?>">
    <?php    $args = array(
				'posts_per_page'			=> "$cs_node->cs_album_per_page",
				'paged'						=> $_GET['page_id_all'],
				'post_type'					=> 'albums',
				'post_status'				=> 'publish',
				'order'						=> 'ASC',
			 );
			if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
				$event_category_array = array('album-category' => "$filter_category");
				$args = array_merge($args, $event_category_array);
			}
			$custom_query = new WP_Query($args);
			if ( $custom_query->have_posts() <> "" ):
 	  	$width = 228; 
		$height = 205;
		$counter_album = $counter_count = 0;
		while ( $custom_query->have_posts() ): $custom_query->the_post();
		$cs_album = get_post_meta($post->ID, "cs_album", true);
		if ( $cs_album <> "" ) {
			$counter_album_tracks = 0;
			$album_track_mp3_url_audio = '';
			$cs_xmlObject = new SimpleXMLElement($cs_album);
				$album_release_date_db = $cs_xmlObject->album_release_date;
				$album_buynow = $cs_xmlObject->album_buynow;
		}
		$image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID),$width,$height ); 
		if($image_url == ''){
			$noimg = 'no-img';
		}else{
			$noimg  ='';
		}
 ?>
        <article <?php post_class($noimg);?> style="position:relative;">
            <figure>
                <a href="<?php the_permalink();?>"><?php if($image_url <> ''){?><img src="<?php echo $image_url;?>" alt=""><?php }?></a>
            </figure>
            <div class="text webkit">
                <h2 class="cs-post-title cs-heading-color"><a href="<?php the_permalink();?>"><?php echo substr(get_the_title(), 0, 33); if(strlen(get_the_title())>33) echo '...'; ?></a></h2>
                <div class="album_heading">
                <?php
                /* translators: used between list items, there is a space after the comma */
                $before_cat = '<div class="cs-event-catgories">';
                $categories_list = get_the_term_list ( get_the_id(), 'album-category', $before_cat, ', ', '</div>' );
                if ( $categories_list ){
                printf( __( '%1$s', 'Spikes'),$categories_list );
                }
                
                ?>
                <div class="social-area">
                    <div class="social-network">
                          <?php if($cs_xmlObject->album_buy_amazon <> ''){?><a title="" data-placement="top" data-toggle="tooltip" data-original-title="Itunes" href="<?php echo $cs_xmlObject->album_buy_amazon;?>" class="icon-btn icon1"></a><?php }?>
                        <?php if($cs_xmlObject->album_buy_apple <> ''){?><a title="" data-placement="top" data-toggle="tooltip" data-original-title="Itunes" href="<?php echo $cs_xmlObject->album_buy_apple;?>" class="icon-btn icon2"></a><?php }?>
                        <?php if($cs_xmlObject->album_buy_groov <> ''){?><a title="" data-placement="top" data-toggle="tooltip" data-original-title="Itunes" href="<?php echo $cs_xmlObject->album_buy_groov;?>" class="icon-btn icon3"></a><?php }?>
                        <?php if($cs_xmlObject->album_buy_cloud <> ''){?><a title="" data-placement="top" data-toggle="tooltip" data-original-title="Itunes" href="<?php echo $cs_xmlObject->album_buy_cloud;?>" class="icon-btn icon4"></a><?php }?>
                    </div>
                    <?php if($album_buynow <> ''){?><a href="<?php echo $album_buynow;?>" class="bay-btn uppercase"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Buy Now','Spikes');}else{ echo $cs_theme_option['trans_album_buynow']; } ?></a><?php }?>
                </div>
                </div>
            </div>
        </article>
        <?php endwhile; endif;?>
    </div>
 	
 <?php } else {
	$args = array(
				'posts_per_page'			=> "$cs_node->cs_album_per_page",
				'paged'						=> $_GET['page_id_all'],
				'post_type'					=> 'albums',
				'post_status'				=> 'publish',
				'order'						=> 'ASC',
			 );
			if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
				$event_category_array = array('album-category' => "$filter_category");
				$args = array_merge($args, $event_category_array);
			}
			$custom_query = new WP_Query($args);
		if ( $custom_query->have_posts() <> "" ):
 	  	$width = 150; 
		$height = 150;
		$counter_album = $counter_count = 0;
		while ( $custom_query->have_posts() ): $custom_query->the_post();
		$cs_album = get_post_meta($post->ID, "cs_album", true);
		if ( $cs_album <> "" ) {
			$counter_album_tracks = 0;
			$album_track_mp3_url_audio = '';
			$cs_xmlObject = new SimpleXMLElement($cs_album);
				$album_release_date_db = $cs_xmlObject->album_release_date;
				$album_buynow = $cs_xmlObject->album_buynow;
		}
		$image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID),$width,$height ); 
		if($image_url == ''){
			$noimg = 'no-img';
		}else{
			$noimg  ='';
		}
	 ?>
 	<article <?php post_class($noimg);?>>
        <div class="event-inn">
            <figure><a href="<?php the_permalink();?>"><img src="<?php echo $image_url;?>" alt=""></a><figcaption><i class="fa fa-headphones fa-3x"></i></figcaption></figure>
            <div class="text">
               <h2 class="cs-post-title cs-heading-color"><a class="colrhover" href="<?php the_permalink();?>"><?php echo substr(get_the_title(), 0, 33); if(strlen(get_the_title())>33) echo '...'; ?></a></h2>
                <ul>
                    <?php if($album_release_date_db <> ''){?><li><span><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Released Date','Spikes');}else{ echo $cs_theme_option['trans_album_release_date']; } ?> :</span> <?php echo date('d.m.Y', strtotime($cs_xmlObject->album_release_date));?></li><?php }?>
                    <li><span><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Available on','Spikes');}else{ echo $cs_theme_option['trans_album_available']; } ?> :</span> 
                        <?php if($cs_xmlObject->album_buy_amazon <> ''){?><a title="" data-placement="top" data-toggle="tooltip" data-original-title="Itunes" class="icon-btn" href="<?php echo $cs_xmlObject->album_buy_amazon;?>"></a><?php }?>
                        <?php if($cs_xmlObject->album_buy_apple <> ''){?><a title="" data-placement="top" data-toggle="tooltip" data-original-title="Itunes" class="icon-btn icon-btn-2" href="<?php echo $cs_xmlObject->album_buy_apple;?>"></a><?php }?>
                        <?php if($cs_xmlObject->album_buy_groov <> ''){?><a title="" data-placement="top" data-toggle="tooltip" data-original-title="Itunes" class="icon-btn icon-btn-3" href="<?php echo $cs_xmlObject->album_buy_groov;?>"></a><?php }?>
                        <?php if($cs_xmlObject->album_buy_cloud <> ''){?><a title="" data-placement="top" data-toggle="tooltip" data-original-title="Itunes" class="icon-btn icon-btn-4" href="<?php echo $cs_xmlObject->album_buy_cloud;?>"></a><?php }?>
                    </li>
                </ul>
               <?php if($album_buynow <> ''){?> <a href="<?php echo $album_buynow;?>" class="bay-btn uppercase"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Buy Now','Spikes');}else{ echo $cs_theme_option['trans_album_buynow']; } ?></a><?php }?>
                <a class="play-icon" href="<?php the_permalink();?>"><i class="fa fa-play fa-2x"></i></a>
            </div>
        </div>
    </article>
<?php 
 endwhile; endif;
}?>
</div>
<?php 
	//<!-- Pagination -->
	if ($cs_node->cs_album_pagination == "Show Pagination" && $cs_node->cs_album_view <> 'home_view' ) {
		$qrystr = '';
		if(cs_pagination($count_post, $cs_node->cs_album_per_page, $qrystr) <> ''){
			// pagination start
			if ( $cs_node->cs_album_pagination == "Show Pagination" and $cs_node->cs_album_per_page > 0 ) {
					if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
					if ( isset($_GET['filter_category']) ) $qrystr .= "&filter_category=".$_GET['filter_category'];
					echo cs_pagination($count_post, $cs_node->cs_album_per_page, $qrystr);
				}
	 // pagination end
		}
	}
	?>
</div>	