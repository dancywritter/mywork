 <?php
  	global $px_node,$post,$px_theme_option,$px_counter_node,$px_meta_page; 
  	if ( !isset($px_node->var_pb_blog_num_post) || empty($px_node->var_pb_blog_num_post) ) { $px_node->var_pb_blog_num_post = -1; }
	$filter_category = '';
	$row_cat = $wpdb->get_row("SELECT * from ".$wpdb->prefix."terms WHERE slug = '" . $px_node->var_pb_blog_cat ."'" );
	if ( isset($_GET['filter_category']) ) {$filter_category = $_GET['filter_category'];}
	else {
		if(isset($row_cat->slug)){
			$filter_category = $row_cat->slug;
		}
	}
	?>
	<div class=" element_size_<?php echo $px_node->blog_element_size; ?>">

    	<div class="blog blog-medium">
	
                    <header class="pix-heading-title" style="padding:0 15px">
            
                    <?php if ($px_node->var_pb_blog_title <> '') { ?>
            
                        	<h2 class="pix-page-title"><?php echo $px_node->var_pb_blog_title;?></h2>
            
                     <?php }?>
            
            
                     <?php //if($px_node->cause_filterable == "On"){
            
                        $qrystr= "";
            			$subcat = '';
                        if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
                        if( $px_node->var_pb_blog_cat <> "" && $px_node->var_pb_blog_cat <> "0"){
							$categories = get_categories( array('child_of' => "$row_cat->term_id", 'hide_empty' => 0) );
							$subcat = 'yes';
						}else{
                        	$categories = get_categories( array('hide_empty' => 0) );
                        }
                    if(count($categories) >0 ){
            
                    ?>  
                    <label class="pix-cateselect">
                    	<form action="" method="get">
                        <input type="hidden" name="page_id" value="<?php if (isset($_GET['page_id'])) echo $_GET['page_id']?>" />
                        <select  name="filter_category" onchange="this.form.submit()">
                        	<?php if($subcat == 'yes'){?><option value="<?php echo $px_node->px_album_cat;?>"><?php _e("All",'Mercycorp');?></option><?php }?>
                            <?php foreach ($categories as $category) {?>
                                    <option value="<?php echo $category->slug?>" <?php if($category->slug==$filter_category){echo 'selected="selected"';}?>><?php echo $category->cat_name?></option>
                             <?php }?>
                           
                        </select>
                        </form>
                    </label>
                    
                    <!-- Sortby Start -->
                    <?php }?>
                    
            
            
                </header>
     	<!-- Blog Start -->
		<?php
            if (empty($_GET['page_id_all'])) $_GET['page_id_all'] = 1;
            $args = array('posts_per_page' => "-1", 'paged' => $_GET['page_id_all'], 'post_status' => 'publish');
			if(isset($px_node->var_pb_blog_cat) && $px_node->var_pb_blog_cat <> '' && $px_node->var_pb_blog_cat <> '0' && $filter_category <> ''){
				$post_category_array = array('category_name' => "$filter_category");
				$args = array_merge($args, $post_category_array);
			}
            $custom_query = new WP_Query($args);
            $post_count = $custom_query->post_count;
            $count_post = 0;
            $args = array('posts_per_page' => "$px_node->var_pb_blog_num_post", 'paged' => $_GET['page_id_all'], 'post_status' => 'publish');
			if(isset($px_node->var_pb_blog_cat) && $px_node->var_pb_blog_cat <> '' && $px_node->var_pb_blog_cat <> '0' && $filter_category <> ''){
				$post_category_array = array('category_name' => "$filter_category");
				$args = array_merge($args, $post_category_array);
			}
            $custom_query = new WP_Query($args);
            $px_counter = 0;
            	while ($custom_query->have_posts()) : $custom_query->the_post();
					$post_xml = get_post_meta($post->ID, "post", true);	
					$blog_classes = array();
 					if ( $post_xml <> "" ) {
						$px_xmlObject = new SimpleXMLElement($post_xml);
 						$no_image = '';
						$width = 270;
						$height = 203;
						$image_url = px_get_post_img_src($post->ID, $width, $height);
						$image_url_full = px_get_post_img_src($post->ID, '' ,'');
						if($image_url == ""){
							$blog_classes[] = 'no-image';
						}
					}else{
						$post_view = '';
						$no_image = '';	
						$image_url_full = '';
					}	
					//$format = get_post_format( $post->ID );
					$format = get_post_format( $post->ID );
					?>
                    <!-- Blog Post Start -->
                    <article <?php post_class($blog_classes); ?>>
                	<?php if($image_url <> ""){?>
						<figure><a href="<?php the_permalink(); ?>"><img src="<?php echo $image_url;?>" alt=""></a></figure>
                     <?php }?>
                    <div class="text">
                    	<h2 class="pix-post-title"><a href="<?php the_permalink(); ?>" class="pix-colrhvr"><?php the_title(); ?>.</a></h2>
                        <ul class="pix-post-options">
                        	<li><?php px_featured();?>
                            <?php if(get_post_format( $post->ID ) <> ''){?>
                                <span class="post-format">
                                    <a class="entry-format" href="<?php echo esc_url( get_post_format_link( get_post_format( $post->ID ) ) ); ?>"><?php echo get_post_format( $post->ID ); ?></a>
                                </span>
                            <?php }?>
                            <span><?php if($px_theme_option['trans_switcher'] == "on"){ _e('Posted on','Deejay');}else{ echo $px_theme_option['trans_posted_on']; } ?></span> <time datetime="2020-08-02"><?php echo get_the_date();?></time> <?php if($px_theme_option['trans_switcher'] == "on"){ _e('in','Deejay');}else{ echo $px_theme_option['trans_listed_in']; } ?>
							<?php
                              $before_cat = " ";
                              $categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '' );
                              if ( $categories_list ){
                                  printf( __( '%1$s', 'Deejay'),$categories_list );
                              }
                            ?>
                           </li>
                        </ul>
                       			 <?php 
									 global $more;
								 	$more = 0;
									the_content(' ::'.$px_theme_option['trans_read_more']);
									wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Deejay' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
								   ?>
                    </div>
                </article>
                    <!-- Blog Post End -->
               <?php endwhile;  ?>
                 	<!-- Blog End -->
                    <div class="clear"></div>
    			</div>   
                <?php
                $qrystr = '';
               if ( $px_node->var_pb_blog_pagination == "Show Pagination" and $post_count > $px_node->var_pb_blog_num_post and $px_node->var_pb_blog_num_post > 0 ) {
                	echo "<nav class='pagination'><ul>";
                    	if ( isset($_GET['page_id']) ) $qrystr = "&amp;page_id=".$_GET['page_id'];
                        	echo px_pagination($post_count, $px_node->var_pb_blog_num_post,$qrystr);
                    echo "</ul></nav>";
                }
                 // pagination end
             ?>
           </div>