<?php get_header();  
            wp_reset_query();
            if (post_password_required()) { 
                echo '<div class="rich_editor_text">'.cs_password_form().'</div>';
            }else{
            $cs_meta_page = cs_meta_page('cs_page_builder');
            if (count($cs_meta_page) > 0) {
                wp_reset_query();
				
				echo '<div class="'.cs_meta_content_class().'">';
                if($cs_meta_page->page_title == "Yes"){
                    echo '<div class="info-text no-image"><div class="cs-info-txt">';
                    if($cs_meta_page->page_title == "Yes"){ echo '<h1 class="cs-page-title">'.get_the_title().'</h1>'; }
                    if($cs_meta_page->page_headline_text <> ""){ echo '<p>'.$cs_meta_page->page_headline_text.'</p>';}
					echo '</div></div>';
                }
				$width = 890;
				$height = 468;
				$image_url = cs_get_post_img_src($post->ID, $width, $height);
				if($image_url <> ''){ echo '<figure class="detail-figure featured-image"><a><img class="wp-post-image" src="'.$image_url.'" alt=""></a></figure>';}
				if($cs_meta_page->page_content == "Yes" && get_the_content()<>''){
					echo '<div class="rich_editor_text">';
								the_content();
								wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Snapture' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
					echo '</div>';	
				}
                global $counter_node;
                foreach ( $cs_meta_page->children() as $cs_node ) {
                    if ( $cs_node->getName() == "blog" ) {
                        $counter_node++;
                        $layout = $cs_meta_page->sidebar_layout->cs_layout;
                        if ( $cs_node->cs_blog_cat <> "" and $cs_node->cs_blog_cat <> "0" ) 
                        get_template_part( 'page_blog', 'page' );
                    }
                    else if ( $cs_node->getName() == "gallery" ) {
                        $counter_node++;
                        if ( $cs_node->album <> "" and $cs_node->album <> "0" ) {
                            get_template_part( 'page_gallery', 'page' );
                        }
                    }
                    elseif($cs_node->getName() == "contact"){
                       $counter_node++;
                       get_template_part('page_contact','page');
                    }
                    
					elseif($cs_node->getName() == "snapture_home" and $cs_node->cs_home_view_option == "home_view_gallery"){
						$cs_node->cs_gal_images_title = 'Yes';
						$cs_node->layout = 'cs-thumb-gallery';
						$cs_node->album = $cs_node->cs_home_v5_gallery;
						$cs_node->media_per_page = '-1';
						$cs_node->pagination = 'Single Page';
						$counter_node++;
						echo '<div class="home-gallery-page-v5"><span class="pattrenbg"></span>';
						get_template_part( 'page_gallery', 'page' );
						get_template_part( 'page_home', 'page' );
						echo '</div>';
						
					}
					elseif($cs_node->getName() == "snapture_home" and $cs_node->cs_home_view_option == "home_blog_view"){
						
						$cs_node->cs_blog_show_title = $cs_node->cs_home_blog_show_title;
						$cs_node->cs_blog_description = $cs_node->cs_home_blog_description;
						$cs_node->cs_blog_view = 'gird_view';
						$cs_node->cs_blog_excerpt = $cs_node->cs_home_blog_excerpt;
						if($cs_node->cs_home_blog_cat == ''){
							$cs_node->cs_blog_cat = 'all';
						} else {
							$cs_node->cs_blog_cat = $cs_node->cs_home_blog_cat;
						}
						$cs_node->cs_blog_num_post = $cs_node->cs_home_num_post;
						$counter_node++;
						 get_template_part( 'page_blog', 'page' );
						
					}
					elseif($cs_node->getName() == "snapture_home" and $cs_node->cs_home_view_option == "home_portfolio_view"){
						if($cs_node->cs_home_v3_filterable == 'Yes'){
							$cs_node->portfolio_filterable = 'On';
						} else {
							$cs_node->portfolio_filterable = '';
						}
						$cs_node->portfolio_title = '';
						$cs_node->portfolio_view = 'portfolio-large';
						if($cs_node->cs_home_v3_cat == 'All'){
							$cs_node->portfolio_cat = $cs_node->cs_home_v3_cat;
						} else {
							$cs_node->portfolio_cat = '0';
						}
						
						$cs_node->portfolio_per_page = $cs_node->cs_home_v3_num_post;
						$counter_node++;
						get_template_part( 'page_portfolio', 'page' );
						
					}
                    elseif($cs_node->getName() == "snapture_home" && ($cs_node->cs_home_view_option == "home_video" || $cs_node->cs_home_view_option == "big-image-zoom-home" || $cs_node->cs_home_view_option == "fade-slider-home" || $cs_node->cs_home_view_option == "half-layout-home" || $cs_node->cs_home_view_option == "custom-home")){
                       $counter_node++;
                        get_template_part( 'page_home', 'page' );
                    }
					elseif($cs_node->getName() == "portfolio"){
                       $counter_node++;
                        get_template_part( 'page_portfolio', 'page' );
                    }
                    elseif($cs_node->getName() == "client"){
                        $counter_node++;
                        cs_client_page();
                    }
                    elseif($cs_node->getName() == "column"){
                        $counter_node++;
                        cs_column_page();
                    }
                    elseif($cs_node->getName() == "divider"){
                        $counter_node++;
                        echo cs_divider_page();
                    }
                    elseif($cs_node->getName() == "message_box"){
                        $counter_node++;
                        cs_message_box_page();
                    }
                    elseif($cs_node->getName() == "image"){
                        $counter_node++;
                        echo cs_image_page();
                    }
                    elseif($cs_node->getName() == "map" and $cs_node->map_view == "content"){
                        $counter_node++;
                        echo cs_map_page();
                    }
                    elseif($cs_node->getName() == "video"){
                        $counter_node++;
                        echo cs_video_page();
                    }
                    elseif($cs_node->getName() == "quote"){
                        $counter_node++;
                        echo cs_quote_page();
                    }
                    elseif($cs_node->getName() == "dropcap"){
                        $counter_node++;
                        echo cs_dropcap_page();
                    }
                    elseif($cs_node->getName() == "pricetable"){
                        $counter_node++;
                        cs_pricetable_page();
                    }
                    elseif ($cs_node->getName() == "services") {
                        $counter_node++;
                        cs_services_page();
                    }
                    elseif($cs_node->getName() == "tabs"){
                        $counter_node++;
                        echo cs_tabs_page();
                    }
                    elseif($cs_node->getName() == "accordions"){
                        $counter_node++;
                        cs_accordions_page();
                    }
                }
				wp_reset_query();
				if ( comments_open() ){
                    comments_template('', true); 
                }
				?>
                <div class="clear"></div>
                </div>
                <?php if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout <> "none" and $cs_meta_page->sidebar_layout->cs_layout == 'right' or $cs_meta_page->sidebar_layout->cs_layout == 'both') : ?>
                    <div class="aside table-cell-right col-md-3">
                          <div class="cs-right-widgets">
                            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_meta_page->sidebar_layout->cs_sidebar_right) ) : endif; ?>
                            </div>
                     </div>
                  <?php endif; ?>
                <?php
                wp_reset_query(); 
                }else{ 
				?>
            <div class="bg-color webkt">
			<?php
                while (have_posts()) : the_post();
					echo '<h1 class="cs-page-title">'.get_the_title().'</h1>';
                    the_content();
                    wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Snapture' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                endwhile; 
            ?>
            </div>
            <?php 
                 if ( comments_open() ) { 
                    comments_template('', true);
                }
            wp_reset_query();
      }
    } 
    ?>
<!-- main End --> 
<?php get_footer();?>
<!-- Columns End -->