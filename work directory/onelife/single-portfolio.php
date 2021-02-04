<?php
get_header();
	global $cs_node,$cs_theme_option;
	$cs_layout = '';
 	 
	$post_xml = get_post_meta($post->ID, "portfolio", true);
	if ( $post_xml <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($post_xml);
  			$post_view = $cs_xmlObject->inside_portfolio_thumb_view;
			$post_slider = $cs_xmlObject->inside_portfolio_thumb_slider;
			$post_slider_type = $cs_xmlObject->inside_portfolio_thumb_slider_type;
			$portfolio_social_sharing = $cs_xmlObject->portfolio_social_sharing;
			$related_post = $cs_xmlObject->related_post;
			$post_gallery = $cs_xmlObject->inside_portfolio_thumb_gallery;
			$portfolio_post_desc = $cs_xmlObject->portfolio_post_desc;
			$portfolio_post_desc_title = $cs_xmlObject->portfolio_post_desc_title;
			$portfolio_related = $cs_xmlObject->portfolio_related;
			$width = 1170;
			$height =  487;
 			 
	}
	else {
		$post_view = '';
 		$post_slider = '';
		$portfolio_thumb_slider_type = '';
 		$post_slider_type = '';
		$portfolio_social_sharing = '';
		$related_post = '';
 		$post_gallery  = '';
		$portfolio_post_desc_title = '';
		$portfolio_related = '';
		
	}
	$port_class = '';
	if($cs_xmlObject->portfolio_view == "Full"){
		$port_class = "full";
	}elseif($cs_xmlObject->portfolio_view == "Side Left"){
		$port_class = "left";
	}
	elseif($cs_xmlObject->portfolio_view == "Side Right"){
		$port_class = "right";
	}
   	?>
	<?php
        if (have_posts()):
            while (have_posts()) : the_post();
            $width = 1170;
            $height = 487;
            $image_url = cs_get_post_img_src($post->ID, $width,$height);
    ?>
    <div class="portfolio-<?php echo $port_class; ?> portfoliodetail">	
     <?php if ( $cs_xmlObject->portfolio_view == "Full" ) { ?>
            <div class="span12">
                <figure class="detail_figure <?php if ($image_url == '') echo 'no-image'; ?>  fullimg" >
                <?php
                    if ( $post_view == "Slider" and $post_slider <> ''){
                        cs_flex_slider($width, $height,$post_slider);
                    }elseif ( $post_view == "Dragable Gallery"){
                        $width = 570;
                        $height = 428;
                        echo cs_portfolio_gallery($width,$height,$post_gallery,$post_view);
                    
                    }elseif($post_view == "Simple Gallery"){
                          echo cs_portfolio_gallery($width,$height,$post_gallery,$post_view);
                    }
                    elseif($post_view == "Use Featured Image"){
                        echo '<a><img src="'.$image_url.'" alt="" /></a>
                        <span></span>';
                    }
                ?>	
            </figure>
            </div>
            <div class="span3"> 
                <div class="portfolio-detail-sidebar viewproject">
					<?php if($portfolio_post_desc_title <> '' ){ echo '<header class="heading"><h2 class="heading-color section-title">'.$portfolio_post_desc_title.'</h1></header>'; } ?>
                    <?php if($portfolio_post_desc <> '' ){ echo '<p>'.$portfolio_post_desc.'</p>'; } ?>
                    <?php if($cs_xmlObject->port_other_info_main_title <> ''){ ?>
                    <header class="heading">
                        <h2 class="heading-color section-title"><?php echo $cs_xmlObject->port_other_info_main_title?></h2>
                    </header>
                    <?php } ?>
                 <?php
                      $port_other_info_title = '';
                      $port_other_info_desc = '';
                      $port_other_info_icon = '';
                      
                      if ( $post_xml <> "" ) {
						  cs_portfolio_other_info($cs_xmlObject);
                       }
                ?>
         </div>
            </div>
            <div class="span9">
                <!-- Portfolio Detail Text -->
                <div class="portfolio-detail-text detail_text">
                    <?php the_content(); ?>
                </div>
                <!-- Portfolio Detail Text -->
            </div>
      <?php }else{
        if($cs_xmlObject->portfolio_view == "Side Left"){  ?>
                 <!-- Portfolio Detail Text --> 
                 <div class="span3">  
                    <div class="portfolio-detail-sidebar viewproject">
						 <?php if($portfolio_post_desc_title <> '' ){ echo '<header class="heading"><h2 class="heading-color section-title">'.$portfolio_post_desc_title.'</h1></header>'; } ?>
                        <?php if($portfolio_post_desc <> '' ){ echo '<p>'.$portfolio_post_desc.'</p>'; } ?>
                        <?php if($cs_xmlObject->port_other_info_main_title <> ''){ ?>
                        <header class="heading">
                            <h2 class="heading-color section-title"><?php echo $cs_xmlObject->port_other_info_main_title?></h2>
                        </header>
                        <?php } ?>
                         <?php
                              $port_other_info_title = '';
                              $port_other_info_desc = '';
                              $port_other_info_icon = '';
                              
                              if ( $post_xml <> "" ) {
                                 cs_portfolio_other_info($cs_xmlObject);
                              }
                          ?>
                 </div>
                </div>
        <?php
            }
        ?>
            <div class="span9">
                <figure class="detail_figure <?php if ($image_url == '') echo 'no-image'; ?> fullimg" >
                    <?php
                        if ( $post_view == "Slider" and $post_slider <> ''){
                            cs_flex_slider($width, $height,$post_slider);
                        }elseif ( $post_view == "Dragable Gallery"){
                            $width = 570;
                            $height = 428;
                            echo cs_portfolio_gallery($width,$height,$post_gallery,$post_view);
                        
                        }elseif($post_view == "Simple Gallery"){
                              echo cs_portfolio_gallery($width,$height,$post_gallery,$post_view);
                        }elseif($post_view == "Use Featured Image"){
                            echo '<a><img src="'.$image_url.'" alt="" /></a>
                            <span></span>';
                        }
                    ?>	
                </figure>
            </div>
          <?php if($cs_xmlObject->portfolio_view == "Side Right"){ ?>
                    <div class="span3">	
                        <div class="portfolio-detail-sidebar viewproject">
                        <?php if($portfolio_post_desc_title <> '' ){ echo '<header class="heading"><h2 class="heading-color section-title">'.$portfolio_post_desc_title.'</h1></header>'; } ?>
						<?php if($portfolio_post_desc <> '' ){ echo '<p>'.$portfolio_post_desc.'</p>'; } ?>
                        <?php if($cs_xmlObject->port_other_info_main_title <> ''){ ?>
                        <header class="heading">
                            <h2 class="heading-color section-title"><?php echo $cs_xmlObject->port_other_info_main_title?></h2>
                        </header>
                        <?php } ?>
                         <?php
                              $port_other_info_title = '';
                              $port_other_info_desc = '';
                              $port_other_info_icon = '';
                              
                              if ( $post_xml <> "" ) {
                                  cs_portfolio_other_info($cs_xmlObject);
                              }
                          ?>
                  </div>
                </div>
                <?php
                }
                ?>
                <div class="span12">
                    <!-- Portfolio Detail Text -->
                    <div class="portfolio-detail-text">
                         <?php the_content(); ?>
                    </div>
                    <!-- Portfolio Detail Text -->
                </div>
                <?php
            }
            ?>
            <!-- Post Change Section Start -->
			<?php cs_next_prev_post($cs_xmlObject->portfolio_social_sharing); ?>
            <!-- Post Change Section End -->
            </div>
            <!-- Related Posts Starts -->
			<?php if ($portfolio_related == "on") { ?>
            	<div class="detailcarousel portfoliopage related-posts span12">
                    <header class="heading">
                        <h2 class="heading-color section-title"><?php  echo $cs_xmlObject->inside_portfolio_related_post_title; ?></h2>
                    </header>
                    <div class="cycle-slideshow"
                    data-cycle-timeout=0
                    data-cycle-fx=carousel
                    data-cycle-carousel-visible=5
                    data-cycle-slides="article"
                        data-cycle-next="#next"
                        data-cycle-prev="#prev">
                        <?php
							$custom_taxterms='';
							$custom_taxterms = wp_get_object_terms( $post->ID, array('portfolio-category','portfolio-tag'), array('fields' => 'ids') );
							// arguments
							$args = array(
								'post_type' => 'portfolio',
								'post_status' => 'publish',
								'posts_per_page' => -1, // you may edit this number
								'orderby' => 'DESC',
								'tax_query' => array(
								'relation' => 'OR',
								array(
								'taxonomy' => 'portfolio-tag',
								'field' => 'id',
								'terms' => $custom_taxterms
								),
								array(
								'taxonomy' => 'portfolio-category',
								'field' => 'id',
								'terms' => $custom_taxterms
								)
								),
								'post__not_in' => array ($post->ID),
							); 
                        $custom_query = new WP_Query($args);
                        if($custom_query->have_posts()):
                        cs_enqueue_jcycle_script(); 
                         
                        while ($custom_query->have_posts()) : $custom_query->the_post();
                        $post_xml = get_post_meta($post->ID, "portfolio", true);	
                        if ( $post_xml <> "" ) {
                            $cs_xmlObject = new SimpleXMLElement($post_xml);
                             $width 	= 370;
                            $height = 278;
                            $image_url = cs_get_post_img_src($post->ID, $width, $height);
                        }else{
                        	$post_view = '';
                        }
                        ?>
                        <!-- List Post Start -->
                        <article <?php post_class(); ?> >
                        <!-- Blog Post Thumbnail Start -->
                            <figure>
                            <?php
                                $custom_height = 195;
                              if($image_url <> ''){
                                  cs_enqueue_gallery_style_script();
                                  echo "<a href='".get_permalink()."' ><img src='".$image_url."' alt=''></a>";
                                }
                            ?>
                            </figure>
                            <!-- Text Start -->
                            <div class="text">
                                <span><a href="<?php the_permalink(); ?>"><?php echo substr(get_the_title(),0,30); ?></a></span>
                                <?php
                                    $before_cat = '<p><i class="icon-plus"></i>';
                                    $categories_list = get_the_term_list ( get_the_id(), 'portfolio-category', $before_cat, ', ', '</p>' );
                                    if ( $categories_list ){ printf( __( '%1$s', 'OneLife' ),$categories_list ); } 
                                ?>
                            </div>
                            <!-- Text End -->                            
                        </article>
                        <!-- Blog Post End -->
                        <?php
                        endwhile; endif;
                        wp_reset_query();
                        ?>
                     
                        </div>
                        <div class=center>
                            <a href="#" id="prev"><i class="icon-chevron-left"></i></a>
                            <a href="#" id="next"><i class="icon-chevron-right"></i></a>
                        </div>
                </div>
            <?php }?>
            
              <?php comments_template('', true); ?>
            <?php endwhile;   endif;?>
     
    <!-- Span9 End --> 
<?php get_footer(); ?>