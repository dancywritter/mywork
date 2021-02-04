<?php
	global $px_node, $px_theme_option, $px_counter_node;
	if ( !isset($px_node->px_album_per_page) || empty($px_node->px_album_per_page) ) { $px_node->px_album_per_page = -1; }
	$filter_category = '';
	$row_cat = $wpdb->get_row("SELECT * from ".$wpdb->prefix."terms WHERE slug = '" . $px_node->px_album_cat ."'" );
	        if ( isset($_GET['filter_category']) ) {$filter_category = $_GET['filter_category'];}
        else {
            if(isset($row_cat->slug)){
            	 $filter_category = $row_cat->slug;
            }
        }
		 if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
		 	 $argss = array(
                    'posts_per_page'			=> "-1",
                    'post_type'					=> 'albums',
                    'post_status'				=> 'publish',
                    'order'						=> 'ASC',
                );
				
			if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
				$album_category_array = array('album-category' => "$filter_category");
				$argss = array_merge($argss, $album_category_array);
			}
			$custom_queryy = new WP_Query($argss);
			$count_post = 0;
			$subcat = '';
			$count_post = $custom_queryy->post_count;
?>
<div class="element_size_<?php echo $px_node->album_element_size;?>">
	<header class="pix-heading-title">
		<?php if ($px_node->px_album_title <> '') { ?>
                <h2 class="pix-page-title"><?php echo $px_node->px_album_title;?></h2>
         <?php }?>
         <?php if($px_node->px_album_filterable == "On"){
					$qrystr= "";
					if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
					if( $px_node->px_album_cat <> "" && $px_node->px_album_cat <> "0"){
						$categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'album-category', 'hide_empty' => 0) );
						$subcat = 'yes';
					}else{
						$categories = get_categories( array('hide_empty' => 0,'taxonomy' => 'album-category') );
					}
				if(count($categories) >0 ){
				?>  
				<label class="pix-cateselect">
					<form action="" method="get">
					<input type="hidden" name="page_id" value="<?php if (isset($_GET['page_id'])) echo $_GET['page_id']?>" />
					<select  name="filter_category" onchange="this.form.submit()">
						<?php if($subcat == 'yes'){?><option value="<?php echo $px_node->px_album_cat;?>"><?php _e("All",'Deejay');?></option><?php }?>
						<?php foreach ($categories as $category) {?>
								<option value="<?php echo $category->slug?>" <?php if($category->slug==$filter_category){echo 'selected="selected"';}?>><?php echo $category->cat_name?></option>
						 <?php }?>
					</select>
					</form>
				</label>
        		<?php }?>
        <!-- Sortby Start -->
        <?php }?>
    </header>
<?php
	$args = array(
		'posts_per_page'			=> "$px_node->px_album_per_page",
		'paged'						=> $_GET['page_id_all'],
		'post_type'					=> 'albums',
		'post_status'				=> 'publish',
		'order'						=> 'ASC',
	 );
	if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
		$album_category_array = array('album-category' => "$filter_category");
		$args = array_merge($args, $album_category_array);
	}
	$custom_query = new WP_Query($args);
	if ( $custom_query->have_posts() <> "" ):
	?>
    <div class="discography">
    <?php 
		$width = 272; 
		$height = 272;
		while ( $custom_query->have_posts() ): $custom_query->the_post();
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
                
                <figcaption>
                    <a href="<?php the_permalink();?>" class="icon-play">
                        <i class="fa fa-play"></i>
                    </a>
                    <h2 class="pix-post-title">
                    	 <a href="<?php the_permalink();?>"><?php echo substr(get_the_title(), 0, 33); if(strlen(get_the_title())>33) echo '...'; ?></a>
                    </h2>
                    <span class="pix-artist">by <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author_meta('nicename'); ?></a></span>
                </figcaption>
            </figure>
        </article>
        <?php endwhile;?>
       
    </div>
     <?php 
		//<!-- Pagination -->
			$qrystr = '';
			if(px_pagination($count_post, $px_node->px_album_per_page, $qrystr) <> ''){
				// pagination start
				if ( $px_node->px_album_pagination == "Show Pagination" and $px_node->px_album_per_page > 0 and $count_post > $px_node->px_album_per_page) {
					echo "<nav class='pagination'><ul>";
							if ( isset($_GET['page_id']) ) $qrystr = "&amp;page_id=".$_GET['page_id'];
							if ( isset($_GET['filter_category']) ) $qrystr .= "&amp;filter_category=".$_GET['filter_category'];
							echo px_pagination($count_post, $px_node->px_album_per_page, $qrystr);
						echo "</ul></nav>";
					}
		 // pagination end
			}
		?>
<?php endif;?>

 </div>