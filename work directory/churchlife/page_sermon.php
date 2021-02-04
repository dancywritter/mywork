<?php
	global $px_node, $px_theme_option, $px_counter_node;
	if ( !isset($px_node->var_pb_sermon_per_page) || empty($px_node->var_pb_sermon_per_page) ) { $px_node->var_pb_sermon_per_page = -1; }
	$filter_category = '';
	$row_cat = $wpdb->get_row("SELECT * from ".$wpdb->prefix."terms WHERE slug = '" . $px_node->var_pb_sermon_cat ."'" );
	        if ( isset($_GET['filter_category']) ) {$filter_category = $_GET['filter_category'];}
        else {
            if(isset($row_cat->slug)){
            $filter_category = $row_cat->slug;
            }
        }
		 if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
				$args = array(
					'posts_per_page'			=> "-1",
					'post_type'					=> 'sermons',
					'post_status'				=> 'publish',
					'order'						=> 'ASC',
				);
			if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
				$sermon_category_array = array('sermon-category' => "$filter_category");
				$args = array_merge($args, $sermon_category_array);
			}
			$custom_query = new WP_Query($args);
			$count_post = 0;
			$count_post = $custom_query->post_count;
?>
<div class="element_size_<?php echo $px_node->sermon_element_size;?>">
	
	<div class="sermons sermons-large">
    	<?php	if ($px_node->var_pb_sermon_title <> '') { ?>
                <header class="pix-heading-title">
                    <?php	if ($px_node->var_pb_sermon_title <> '') { ?>
                    <h2 class=" px-heading-color pix-section-title"><?php echo $px_node->var_pb_sermon_title; ?></h2>
					<?php  } ?>

                </header>
                <div class="clear"></div>
        <?php  } ?>
    	<?php if ($px_node->var_pb_sermon_filterable == "On") {
			$qrystr= "";
			if ( isset($_GET['page_id']) ) $qrystr = "page_id=".$_GET['page_id'];
		?>
			<div id="filters">
                <ul>
                    <?php  
						if((isset($px_node->var_pb_sermon_cat) &&  $px_node->var_pb_sermon_cat <> ''  && $px_node->var_pb_sermon_cat <> '0') &&  isset( $row_cat->term_id )){
							$categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'sermon-category', 'hide_empty' => 0) );
							?>
                            <li class="<?php if(($px_node->var_pb_sermon_cat==$filter_category)){echo 'pix-active';}?>">
                            	<a href="?<?php echo $qrystr."&amp;filter_category=".$row_cat->slug?>"><?php _e("All",'Statfort');?></a>
                            </li>
                            <?php
						} else {
							$categories = get_categories( array('taxonomy' => 'sermon-category', 'hide_empty' => 0) );
						}
						foreach ($categories as $category) {?>
							<li <?php if($category->slug==$filter_category){echo 'class="pix-active"';}?>>
								<a href="?<?php echo $qrystr."&amp;filter_category=".$category->slug?>"><?php echo $category->cat_name?></a>
							</li>
                    <?php }?>
                </ul>
            </div>
          <?php }?>
	      <?php
		   	$args = array(
				'posts_per_page'			=> "$px_node->var_pb_sermon_per_page",
				'paged'						=> $_GET['page_id_all'],
				'post_type'					=> 'sermons',
				'post_status'				=> 'publish',
				'order'						=> 'ASC',
			 );
			if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
				$sermon_category_array = array('sermon-category' => "$filter_category");
				$args = array_merge($args, $sermon_category_array);
			}
			$custom_query = new WP_Query($args);
			if ( $custom_query->have_posts() <> "" ):
				$width = 380; 
				$height = 200;
				$counter_album = $counter_count = 0;
				while ( $custom_query->have_posts() ): $custom_query->the_post();
				$px_sermon = get_post_meta($post->ID, "px_sermon", true);
				if ( $px_sermon <> "" ) {
					$counter_album_tracks = 0;
					$album_track_mp3_url_audio = '';
					$px_xmlObject = new SimpleXMLElement($px_sermon);
				}
				$image_url = px_attachment_image_src( get_post_thumbnail_id($post->ID),$width,$height ); 
				if($image_url == ''){
					$noimg = 'no-img';
				}else{
					$noimg  ='';
				}
		 ?>
                <article <?php post_class($noimg);?>>
                
                    <figure>
                        <?php if($image_url <> ''){?><img src="<?php echo $image_url;?>" alt=""> <?php }?>
                    </figure>
                    <div class="text">
                        <h2 class="pix-post-title"><a href="<?php the_permalink();?>" class="pix-colrhvr-alt"><?php echo substr(get_the_title(), 0, 33); if(strlen(get_the_title())>33) echo '...'; ?></a></h2>
                        <ul class="post-options">
                        	
                            <li><a><?php echo count($px_xmlObject->track);?> Sermons </a></li>
                            <li><time datetime="2020-02-14"><?php echo get_the_date();?></time></li>
                        </ul>
                    </div>
                </article>
                <?php endwhile; endif;?>
                
   </div>
 	<?php 
    //<!-- Pagination -->
    if ($px_node->var_pb_sermon_pagination == "Show Pagination") {
        $qrystr = '';
        if(px_pagination($count_post, $px_node->var_pb_sermon_per_page, $qrystr) <> ''){
            // pagination start
            if ( $px_node->var_pb_sermon_pagination == "Show Pagination" and $px_node->var_pb_sermon_per_page > 0 and $count_post > $px_node->var_pb_sermon_per_page) {
                echo "<nav class='pagination'><ul>";
                        if ( isset($_GET['page_id']) ) $qrystr = "&amp;page_id=".$_GET['page_id'];
                        if ( isset($_GET['filter_category']) ) $qrystr .= "&amp;filter_category=".$_GET['filter_category'];
                        echo px_pagination($count_post, $px_node->var_pb_sermon_per_page, $qrystr);
                    echo "</ul></nav>";
                }
     // pagination end
        }
    }
    ?>
 </div>