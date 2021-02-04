<?php
	global $cs_node,$post,$cs_theme_option,$counter_node,$wpdb;
	
	cs_enqueue_masonry_style_script();
	cs_enqueue_swiper();
	cs_enqueue_slideshowify();
	if ( !isset($cs_node->portfolio_per_page) || empty($cs_node->portfolio_per_page) ) { $cs_node->portfolio_per_page = -1; }

   	?>
    	<?php if($cs_node->portfolio_title <> ''){?>
        	<header class="heading">
        		<h2 class="section-title heading-color"><?php echo $cs_node->portfolio_title?></h2>
        	</header>
        <?php } ?>
     	<?php
			$filter_category = '';
			$row_cat = $wpdb->get_row("SELECT * from ".$wpdb->prefix."terms WHERE slug = '" . $cs_node->portfolio_cat ."'" );
			if ( isset($_GET['filter_category']) ) {$filter_category = $_GET['filter_category'];}
			else {
				if(isset($row_cat->slug)){
					$filter_category = $row_cat->slug;
 				}
			}
			if (empty($_GET['page_id_all'])) $_GET['page_id_all'] = 1;
			
           	$argss = array(
                    'posts_per_page'			=> "-1",
                    'post_type'					=> 'portfolio',
                  //'portfolio-category'			=> "$filter_category",
                    'post_status'				=> 'publish',
                    'order'						=> 'ASC',
            );
			if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
				$port_category_array = array('portfolio-category' => "$filter_category");
				$argss = array_merge($argss, $port_category_array);
			}
            $custom_query = new WP_Query($argss);
            $post_count = 0;
            $post_count = $custom_query->post_count;	
			if($cs_node->portfolio_view == "portfolio-small"){ $main_class = 'cs-thumb-gutter';
				$porfolio_ms_js = 'portfolioFilter()';
			}
			else if($cs_node->portfolio_view == "portfolio-large"){ $main_class = 'cs-thumb-large';
				$porfolio_ms_js = "portfolio_views('container','297')";
				
			}
			else if($cs_node->portfolio_view == "portfolio-title_v1"){ $main_class = 'cs-thumb-large portfolio-title_v1';
				$porfolio_ms_js = 'portfolioFilter_med_v2()';
			}
			else if($cs_node->portfolio_view == "portfolio-title_v2"){ $main_class = 'portfolio-title_v2 cs-thumb-medium';
				$porfolio_ms_js = 'portfolioFilter_med_v1()';
			}
			else if($cs_node->portfolio_view == "portfolio-mas"){ $main_class = 'portfolio-mas';
				
			}
			else if($cs_node->portfolio_view == "portfolio-medium"){ $main_class = 'cs-thumb-medium';
				$porfolio_ms_js = 'portfolioFilter_med()';
			} else {
				$main_class = 'cs-thumb-small';
				$porfolio_ms_js = "";
				
			}
			
            ?>
                    <script>
                        jQuery(document).ready(function($) {
							LazyLoad(".portfolio","article");
                            
														
							<?php if($cs_node->portfolio_view == "portfolio-title_v1"){?>
							
									portfolioFilter_med_v2();
									portfolio_views_mas('container');
									jQuery(window).resize(function() {
										portfolioFilter_med_v2();
									}); 
							
							<?php }else if($cs_node->portfolio_view == "portfolio-title_v2"){?>
							
									portfolioFilter_med_v1();
									portfolio_views_mas('container');
									jQuery(window).resize(function() {
										portfolioFilter_med_v1();
									}); 
							
							<?php }else if($cs_node->portfolio_view == "portfolio-large"){?>
							
									portfolioFilter_large();
									portfolio_views_mas('container');
									jQuery(window).resize(function() {
										portfolioFilter_large();
									}); 
									
							<?php } elseif($cs_node->portfolio_view == "portfolio-medium"){?>
							        portfolioFilter_med();
									portfolio_views_mas('container');
									jQuery(window).resize(function() {
										portfolioFilter_med();
									}); 
							<?php } elseif($cs_node->portfolio_view == "portfolio-mas"){?>
									galleryMasonryresize();
    								portfolio_views_mas("container");
									jQuery(window).resize(function() {
										galleryMasonryresize();
									}); 
									//portfolio_views('container','297');
							<?php } else {?>
									<?php echo $porfolio_ms_js;?>;
                            		portfolio_views_mas('container');
									jQuery(window).resize(function() {
									<?php echo $porfolio_ms_js;?>;
									});
									
							<?php } ?>
							
							 
                            
                        });
                    </script>
                        <!-- Portfoilio Start -->
                        
                        <div class="portfolio <?php echo $main_class;?> da-thumbs" id="da-thumbs">
                        	<?php if($cs_node->portfolio_filterable == "On"){?>
                            <ul id="filters">
                              <li><a href="#" data-filter="*" class="selected"><?php _e("All",'Snapture');?></a></li>
                              <?php
							  	if(isset($cs_node->portfolio_cat) && $cs_node->portfolio_cat <> '' && $cs_node->portfolio_cat <> '0'){
									$categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'portfolio-category', 'hide_empty' => 0) );
								} else {
									$categories = get_categories( array('taxonomy' => 'portfolio-category', 'hide_empty' => 0) );
								}
								foreach ($categories as $category) {
								?>
                             	 	<li><a href="#" data-filter=".<?php echo $category->slug; ?>"><?php echo $category->name; ?></a></li>
							<?php }?>
                            </ul>
                            <?php }
							$args = array(
									'posts_per_page'		=> "$cs_node->portfolio_per_page",
									'paged'					=> $_GET['page_id_all'],
									'post_type'				=> 'portfolio',
									//'portfolio-category'	=> "$filter_category",
									'post_status'			=> 'publish',
									'order'					=> 'ASC',
								);
								if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
									$port_category_array = array('portfolio-category' => "$filter_category");
									$args = array_merge($args, $port_category_array);
								}
								if($cs_node->portfolio_view == "portfolio-mas"){
									
									$width = '0';
									$height = '0'; 
									
								} else {
									
									$width = 529;
									$height = 400; 
								}
							
							
							?>
                            <div id="container" class="portfolio-listing">
                            <?php 
							$custom_query = new WP_Query($args);
							while ( $custom_query->have_posts() ): $custom_query->the_post();
 								$post_xml = get_post_meta($post->ID, "portfolio", true);
								if($post_xml <> ''){
									$xmlObject = new SimpleXMLElement($post_xml);
								}else{
									$post_view = '';
								}
								$image_url = cs_get_post_img_src($post->ID,$width,$height);
								$categories_list = get_the_terms($post->ID,'portfolio-category');
								$conter = 1;
 								foreach($categories_list as $cat){
									$cats[0] = 'element';
									$cats[$conter] =$cat->slug;
									$conter++;
								}
								?>
                              <div <?php post_class($cats); ?>>
                                <article>
                                    <figure>
                                        <a href="<?php the_permalink();?>"><img src="<?php echo $image_url;?>" alt=""></a>
                                        <figcaption>
                                            <div class="caption-inner">
                                                <h6><a href="<?php the_permalink();?>"><?php echo substr(get_the_title(), 0, 20); if(strlen(get_the_title())>20) echo '...'; ?></a></h6>
                                                <a href="<?php the_permalink();?>" class="cs-plus"><i class="fa fa-plus"></i></a>
                                                <?php
													  $before_cat = "<p>";
													  $categories_list = get_the_term_list ( get_the_id(), 'portfolio-category', $before_cat, ', ', '</p>' );
													  if ( $categories_list ){
														  printf( __( '%1$s', 'Snapture'),$categories_list );
													  }
												?>
                                                
                                            </div>
                                        </figcaption>
                                    </figure>
                                    <?php if($cs_node->portfolio_view == "portfolio-title_v1" || $cs_node->portfolio_view == "portfolio-title_v2"){?>
                                    <div class="text"> 
                                        <h6><a href="<?php the_permalink();?>"><?php echo substr(get_the_title(), 0, 20); if(strlen(get_the_title())>20) echo '...'; ?></a></h6>
                                        <?php
											  $before_cat = "<p>";
											  $categories_list = get_the_term_list ( get_the_id(), 'portfolio-category', $before_cat, ', ', '</p>' );
											  if ( $categories_list ){
												  printf( __( '%1$s', 'Snapture'),$categories_list );
											  }
										?>
                                    </div>
                                    <?php }?>
                                </article>
                              </div>
                               <?php endwhile;?>
                               <?php
								$qrystr = '';
								if ( $cs_node->portfolio_pagination == "Show Pagination" and $cs_node->portfolio_filterable <> "On"  and $post_count > $cs_node->portfolio_per_page and $cs_node->portfolio_per_page > 0 ) {
									if ( isset($_GET['page_id']) )  $qrystr = "&page_id=".$_GET['page_id'];
										echo cs_pagination($post_count, $cs_node->portfolio_per_page,$qrystr);
								}?>
								<!-- Pagination End -->
                            </div>
                           
                        </div>
                        <!-- Portfoilio End -->
