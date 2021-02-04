<?php
	global $cs_node,$post,$cs_theme_option,$counter_node,$wpdb;
	if ( !isset($cs_node->sermon_per_page) || empty($cs_node->sermon_per_page) ) { $cs_node->sermon_per_page = -1; }
?>
 	<div class="element_size_<?php echo $cs_node->sermon_element_size;?>">

    <?php
        $meta_compare = '';
        $filter_category = '';
        $row_cat = $wpdb->get_row("SELECT * from ".$wpdb->prefix."terms WHERE slug = '" . $cs_node->sermon_cat ."'" );
        if ( isset($_GET['filter_category']) ) {$filter_category = $_GET['filter_category'];}
        else {
            if(isset($row_cat->slug)){
            $filter_category = $row_cat->slug;
            }
        }
        if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
                $args = array(
                    'posts_per_page'			=> "-1",
                    'post_type'					=> 'sermon',
                    'sermon-category'			=> "$filter_category",
                    'post_status'				=> 'publish',
                    'order'						=> 'ASC',
                );
            $custom_query = new WP_Query($args);
            $count_post = 0;
			$count_post = $custom_query->post_count;
            wp_reset_query();	
            if ( $cs_node->sermon_pagination == "Single Page") { $cs_node->sermon_per_page = $cs_node->sermon_per_page; }?>
                <?php if($cs_node->sermon_filterable == "On"){
					$cs_node->sermon_per_page = '-1';
				?> 
					
                  	<!-- Filter Nav Start -->                           	
                         <ul class="sortby cs-filter">
                         
							<?php 
                                $qrystr= "";
                                if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
                            ?>   
                         	<li class="filter <?php if($filter_category==$row_cat->slug || empty($filter_category)) echo "active"; ?>" >
                            <a href="?<?php echo $qrystr."&filter_category=".$row_cat->slug?>"><?php _e("All",'Faith'); ?></a></li>
                           	<?php
                            	$categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'sermon-category', 'hide_empty' => 0) );
                                foreach ($categories as $category) {
							?>
                            	<li class="filter <?php if($filter_category==$category->slug) echo "active"; ?>" ><a href="?<?php echo $qrystr."&filter_category=".$category->slug?>" onclick="this.form.submit()" ><?php echo $category->cat_name?></a></li>
                            <?php 
							   	} 
							?>
                    	</ul>
                    <!-- Filter Nav End -->
                <?php } ?>
				<div class="sermons sermons-listing">
					<?php
 						$args = array(
							'posts_per_page'			=> "$cs_node->sermon_per_page",
							'paged'						=> $_GET['page_id_all'],
							'post_type'					=> 'sermon',
							'sermon-category'			=> "$filter_category",
							'post_status'				=> 'publish',
							'order'						=> 'ASC',
						 );
                        $sermons_counter=0;
  						$custom_query = new WP_Query($args);
                       	if ( $custom_query->have_posts() <> "" ) {
							while ( $custom_query->have_posts() ): $custom_query->the_post();
							$sermons_counter++;
							$sermon_xml = get_post_meta(get_the_ID(), "cs_sermon", true);
							if ($sermon_xml <> "") {
								$cs_xmlObject = new SimpleXMLElement($sermon_xml);
								$sermon_audio_url = $cs_xmlObject->sermon_audio_url;
								$sermon_download_url = $cs_xmlObject->sermon_download_url;
								$sermon_script_url = $cs_xmlObject->sermon_script_url;
							}
							$no_audio = "";
							if($sermon_audio_url == '') {
								$no_audio = 'class="no-audio"';
							}
 								?>
                                <article <?php echo $no_audio; ?>>
									<?php if ($sermon_audio_url <> '') { ?>
                                	<figure>
                                   
                                     <audio style="width:100%;" src="<?php echo $sermon_audio_url; ?>" type="audio/mp3" controls="controls"></audio>
                                    	
                                    </figure>
                                    <?php }?>
                                    <div class="text">
                                        <h2 class="cs-post-title">
                                        <a href="<?php the_permalink() ?>" class="cs-colrhvr"><?php the_title(); ?></a>
                                        </h2>
                                        <ul class="post-options">
                                        	<?php if ($sermon_script_url <> '' or $sermon_download_url <> '' or $sermon_audio_url <> '') { ?>
                                            <li>
                                                <div class="cs-options-panel">
                                                	<?php if ($sermon_script_url <> '') { ?>
                                                    <a href="<?php echo $sermon_script_url; ?>"><i class="fa fa-book"></i></a>
                                                    <?php
													}
													if ($sermon_download_url <> '') {
													?>
                                                    <a href="<?php echo $sermon_download_url; ?>"><i class="fa fa-share-square-o"></i></a>
                                                    <?php 
													}
													if ($sermon_audio_url <> '') { ?>
                                                    <a href="<?php echo $sermon_audio_url; ?>"><i class="fa fa-download"></i></a>
                                                    <?php
													}
													?>
                                                </div>
                                            </li>
                                            <?php } ?>
                                            <li>
                                            <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Posted on','Faith'); }else{ echo $cs_theme_option['trans_posted_on']; } ?> <time datetime="<?php echo date('d-m-y',strtotime(get_the_date()));?>"> <?php echo get_the_date(); ?></time>
                                            </li>
                                            <li><?php printf( __('By: %s','Faith'), ''); ?> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_the_author(); ?></a></li>
                                        </ul>
                                    </div>
                              </article>
							<?php 
                            endwhile;	wp_reset_query();						
                            }
					?>		
				</div>
                <?php
					 if($cs_node->sermon_filterable == "Off"){ 
						$qrystr = '';
						if(cs_pagination($count_post, $cs_node->sermon_per_page, $qrystr) <> ''){
							// pagination start
							if ( $cs_node->sermon_pagination == "Show Pagination" and $cs_node->sermon_per_page > 0 ) {
									if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
									if ( isset($_GET['filter_category']) ) $qrystr .= "&filter_category=".$_GET['filter_category'];
									echo cs_pagination($count_post, $cs_node->sermon_per_page, $qrystr);
								}
							// pagination end
						}
					 }
					?>

<div class="clear"></div>         
</div>