<?php
	global $cs_node,$post,$cs_theme_option,$cs_counter_node,$wpdb;
	cs_enqueue_gallery_style_script();
   if ( !isset($cs_node->portfolio_per_page) || empty($cs_node->portfolio_per_page) ) { $cs_node->portfolio_per_page = -1; }
   	?>
	<div class="element_size_<?php echo $cs_node->portfolio_element_size;?> <?php if($cs_node->portfolio_title == ''){  echo "no-heading";} if($cs_node->portfolio_view == "portfolio-slider-view"){ echo ' portfolio-slider ';} ?> portfoliopage lightbox">
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
           	$args = array(
                    'posts_per_page'			=> "-1",
                    'post_type'					=> 'portfolio',
                    'portfolio-category'			=> "$filter_category",
                    'post_status'				=> 'publish',
                    'order'						=> 'ASC',
            );
            $custom_query = new WP_Query($args);
            $post_count = 0;
            $post_count = $custom_query->post_count;	
            ?>
                <?php if($cs_node->portfolio_filterable == "On" and $cs_node->portfolio_view != "portfolio-slider-view"){
					$cs_node->portfolio_per_page = -1;
					cs_enqueue_filterable_style_script();
					
					if($cs_node->portfolio_view == "portfolio-four-col" || $cs_node->portfolio_view == "portfolio-three-col" || $cs_node->portfolio_view == "portfolio-two-col"){
				?>
					<script>
                        jQuery(document).ready(function(){
                            jQuery(".splitter li") .click(function(event){
                            jQuery(".splitter li") .removeClass("active");
                            jQuery(this).addClass("active");
                            var selector = jQuery(this).attr('data-filter');
                            var container = jQuery('#container<?php echo $cs_counter_node; ?>');
                            jQuery(container).isotope({ filter: selector });
                            event.preventDefault(); 
                            });	
                        });
                    </script>
                    <!-- Filter Nav Start -->       
                    <div class="filter_nav">
                        <ul class="splitter">
                            <li class="filter active" data-filter="*">
                              <a><?php if(isset($row_cat->name)){   _e("All",'OneLife'); } ?></a></li>
                            <?php
                                $categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'portfolio-category', 'hide_empty' => 0) );
                                foreach ($categories as $category) {
                                ?>
                                    <li class="filter" data-filter=".<?php echo $category->slug; ?>"><a><?php echo $category->cat_name?></a></li>
                                <?php 
                                } 
                            ?>
                        </ul>
                    </div>
                    <!-- Filter Nav End -->
                	<?php }else{
					?>
					<script>
						jQuery(document).ready(function($){
							$('#list').mixitup({ });
							$(".splitter li a") .click(function(event){
							$(".splitter li") .removeClass("active");
							$(this).parent() .addClass("active")
							event.preventDefault(); 
							});	
						});
					</script>
                    <style>
                    	#list .mix{
							opacity: 0;
							display: none;
						}
                    </style>
					<!-- Filter Nav Start -->       
                    <div class="filter_nav">
                        <ul class="splitter">
                            <li class="filter active" data-filter="all">
                              <a><?php if(isset($row_cat->name)){   _e("All",'OneLife'); }?></a></li>
                            <?php
                                $categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'portfolio-category', 'hide_empty' => 0) );
                                foreach ($categories as $category) {
                                ?>
                                    <li class="filter" data-filter="<?php echo $category->slug; ?>"><a><?php echo $category->cat_name?></a></li>
                                <?php 
                                } 
                            ?>
                        </ul>
                    </div>
                    <!-- Filter Nav End -->
                    <?php
				}
				?>
                <?php 
				}
  				$args = array(
					'posts_per_page'		=> "$cs_node->portfolio_per_page",
					'paged'					=> $_GET['page_id_all'],
					'post_type'				=> 'portfolio',
					'portfolio-category'	=> "$filter_category",
					'post_status'			=> 'publish',
					'order'					=> 'ASC',
				);
				if($cs_node->portfolio_view == "portfolio-slider-view"){
					$cs_node->portfolio_pagination = 'Single Page';
					cs_enqueue_jcycle_script(); 
					$custom_query = new WP_Query($args);
					if ( $custom_query->have_posts() <> "" ) {
					?>
                    <!-- Recent Work Start -->
                       <div class="recent-work">
                        <div class="cycle-slideshow"
                                        data-cycle-timeout=0
                                        data-cycle-slides="article"
                                        data-cycle-fx="fade">
                          <div class="cycle-pager"></div>
                          <?php
						  while ( $custom_query->have_posts() ): $custom_query->the_post();
 								$post_xml = get_post_meta($post->ID, "portfolio", true);
								if($post_xml <> ''){
									$cs_xmlObject = new SimpleXMLElement($post_xml);
 									$width = 570;
									$height = 428; 
									
								}else{
									
								}
								$image_url = cs_get_post_img_src($post->ID,570,428);
								?>
                          <article>
                            <figure>
							<?php
                                 if($image_url <> ""){
                                   echo '<a href="'.get_permalink().'"><img src="'.$image_url.'" alt="" ></a>';
                                 }
                            ?>
                        </figure>	
                            <div class="text">
                               	<h2 class="colr post-title"><?php the_title(); ?></h2>
                                <p><?php $limit = $cs_node->cs_portfolio_excerpt; echo substr(get_the_content(),0,"$limit");  ?></p>
                                <a href="<?php the_permalink();?>" class="backcolr uppercase"><?php if ($cs_theme_option['trans_switcher'] == "on") {_e('View Project', "OneLife");} else {echo $cs_theme_option['trans_view_project'];}?></a> 
                            </div>
                          </article>
                          <?php endwhile; ?>
                        </div>
                      </div>
                      <!-- Recent Work End -->
                    <?php
					}
				}
 				elseif($cs_node->portfolio_view == "portfolio-four-col" || $cs_node->portfolio_view == "portfolio-three-col" || $cs_node->portfolio_view == "portfolio-two-col"){
					cs_enqueue_masonry_style_script();
				?>
                 	<script type="text/javascript">
              		jQuery(document).ready(function(){ 
 						var container = jQuery('#container<?php echo $cs_counter_node; ?>');
						jQuery(container).isotope({
						 	layoutMode: 'masonry',
    						resizesContainer: true,
							itemSelector: '.box'
 						
					});
 					jQuery(window).load(function(){
						jQuery(container).isotope();
					});
				});
               </script>
				<?php
					echo "<div class='mas-con' id='container".$cs_counter_node."'>";
					$custom_query = new WP_Query($args);
					if ( $custom_query->have_posts() <> "" ) {
					?>
                   	<ul id="list" class="portfolio-mas <?php echo $cs_node->portfolio_view;  echo " "; if($cs_node->portfolio_post_title != "On"){ echo "no-title";}?>" >
                    <?php
 						while ( $custom_query->have_posts() ): $custom_query->the_post();
 								$post_xml = get_post_meta($post->ID, "portfolio", true);
								if($post_xml <> ''){
									$cs_xmlObject = new SimpleXMLElement($post_xml);
									$width = 570;
									$height = 428; 
									
								}
								$image_url = cs_attachment_image_src(get_post_thumbnail_id($post->ID),'','');
								$categories_list = get_the_terms($post->ID,'portfolio-category');
								$conter = 1;
 								foreach($categories_list as $cat){
									$cats[0] = 'mix box';
									$cats[$conter] =$cat->slug;
									$conter++;
								}
 							?>
                                <li data-id="id-<?php the_ID(); ?>" <?php post_class($cats); ?>>
                                    <!-- Article Start -->
                                    <article class="<?php if($image_url == ''){ echo "no-img"; }?>">
                                    	<figure>
											<?php
                                                if($image_url <> ""){
                                                   echo '<a href="'.get_permalink().'"><img src="'.$image_url.'" alt="" ></a>
                                                    <figcaption class="bordercolr webkit">
                                                        <div class="portfolio-effect">
                                                            <a href="'.$image_url.'" class="icon-style" rel="prettyPhoto[gallery1]" data-rel="prettyPhoto[gallery1]"><i class="icon-zoom-in"></i></a>
                                                            <a href="'.get_permalink().'" class="icon-style"><i class="icon-link"></i></a>
                                                        </div>	
                                                    </figcaption>';
                                                 }
                                            ?>
                                        </figure>	
 										<!-- Text Start -->
                                        <?php if($cs_node->portfolio_post_title == "On"){?>
                                             <div class="text">
                                                <span><a href="<?php the_permalink();?>"><?php echo substr(get_the_title(),0,30); if(strlen(get_the_title()) > 30 ) echo '...'; ?></a></span>
                                                 <?php
                                                	$before_cat = '<p><i class="icon-plus"></i>';
													$categories_list = get_the_term_list ( get_the_id(), 'portfolio-category', $before_cat, ' ', '</p>' );
                                                    if ( $categories_list ){ printf( __( '%1$s', 'OneLife' ),$categories_list ); } 
												?>
                                                <?php // cs_get_media_attachment(); ?>
                                             </div>
                                         <?php }?>   
                                        <!-- Text End -->
                                    </article>
                                    <!-- Article End -->
                                </li>
                            <?php
						endwhile;
						?>
                        </ul>
                    
                    <?php
					echo '</div>';
					wp_reset_query();						
					}
				
				}else{ 
				$custom_query = new WP_Query($args);
				if ( $custom_query->have_posts() <> "" ) {
					?>
                   	<ul id="list" class="image-grid <?php echo $cs_node->portfolio_view;  echo " "; if($cs_node->portfolio_post_title != "On"){ echo "no-title";}?>" >
                    <?php
 						while ( $custom_query->have_posts() ): $custom_query->the_post(); ?>
							<?php 
 								$post_xml = get_post_meta($post->ID, "portfolio", true);
								if($post_xml <> ''){
									$cs_xmlObject = new SimpleXMLElement($post_xml);
 									$width = 570;
									$height = 428; 
									
								}else{
 								}
								$image_url = cs_get_post_img_src($post->ID,570,428);
								$categories_list = get_the_terms($post->ID,'portfolio-category');
								$conter = 1;
 								foreach($categories_list as $cat){
									$cats[0] = 'mix';
									$cats[$conter] =$cat->slug;
									$conter++;
								}
 							?>
                                <li data-id="id-<?php the_ID(); ?>" <?php post_class($cats); ?>>
                                    <!-- Article Start -->
                                    <article class="<?php if($image_url == ''){ echo "no-img"; }?>">
                                    	<figure>
                                    	<?php
											if($image_url <> ""){
												 echo '<a href="'.get_permalink().'"><img src="'.$image_url.'" alt="" ></a>
 												<figcaption class="bordercolr webkit">
													<div class="portfolio-effect">
														<a href="'.$image_url.'" class="icon-style" rel="prettyPhoto[gallery1]" data-rel="prettyPhoto[gallery1]"><i class="icon-zoom-in"></i></a>
														<a href="'.get_permalink().'" class="icon-style"><i class="icon-link"></i></a>
 													</div>	
												</figcaption>';
                                              }
                                        ?>
                                        </figure>	
 										<!-- Text Start -->
                                         <?php if($cs_node->portfolio_post_title == "On"){?>
                                            <div class="text">
                                                <span><a href="<?php the_permalink();?>"><?php echo substr(get_the_title(),0,15); if(strlen(get_the_title()) > 15 ) echo '...'; ?></a></span>
                                                 <?php
                                                	$before_cat = '<p><i class="icon-plus"></i>';
													$categories_list = get_the_term_list ( get_the_id(), 'portfolio-category', $before_cat, ' ', '</p>' );
                                                    if ( $categories_list ){ printf( __( '%1$s', 'OneLife' ),$categories_list ); } 
												?>
                                                <div class="activeimg">
                                                    <?php cs_get_media_attachment(); ?>
                                                </div>
                                            </div>
                                         <?php } ?>
                                        <!-- Text End -->
                                    </article>
                                    <!-- Article End -->
                                </li>
                            <?php
							endwhile;
							wp_reset_query();
						?>
                        </ul>
                    <?php
										
					}else{ ?>
						<h2 class="section-title"><?php _e( 'No results found.', 'OneLife' )?></h2>
					<?php 
					}
                }
				echo '</div>';
			   $qrystr = '';
                     if ( $cs_node->portfolio_pagination == "Show Pagination" and $post_count > $cs_node->portfolio_per_page and $cs_node->portfolio_per_page > 0 and $cs_node->portfolio_filterable != "On" ) {
                        echo "<nav class='pagination'><ul>";
                            if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
                                echo cs_pagination($post_count, $cs_node->portfolio_per_page,$qrystr);
                        echo "</ul></nav>";
                    }
                    // pagination end
			   ?> 
   		
  