<?php
get_header();
	global $cs_node,$cs_theme_option;
	$post_slider = $inside_post_thumb_gallery = $image_url = $post_audio = $post_video = '';
	$cs_layout = '';
	 if (have_posts()):
	while (have_posts()) : the_post();
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
			$post_audio = $cs_xmlObject->inside_post_thumb_audio;
			$post_video = $cs_xmlObject->inside_post_thumb_video;
			$inside_post_featured_image_as_thumbnail = $cs_xmlObject->inside_post_featured_image_as_thumbnail;
			if ( $cs_layout == "left") {
					$cs_layout = "content-left col-md-9 col-sm-9";
				}
				else if ( $cs_layout == "right" ) {
					$cs_layout = "content-right col-md-9 col-sm-9";
				}
				else {
					$cs_layout = "col-md-12";
					
				}
			$width = 1170;
			$height =  487;
	}
	else {
		$post_view = '';
		$cs_layout = '';
 		$post_slider = '';
		$portfolio_thumb_slider_type = '';
 		$post_slider_type = '';
		$portfolio_social_sharing = '';
		$related_post = '';
 		$post_gallery  = '';
		$portfolio_post_desc_title = '';
		$portfolio_related = '';
		$cs_blog_large_layout = '';
	}
	$port_class = '';
	$port_class = "right";
	$custom_height = 500;
	$custom_width = 890;
	$width = 890;
	$height = 468;
	$image_url = cs_get_post_img_src($post->ID, $width,$height);
    ?>
    <div class="col-lg-12 col-md-12 col-sm-12 ">
    	<?php
                    if ( $post_view == "Slider" && $post_slider <> ''){
						echo '<figure>';
                        cs_flex_slider($width, $height,$post_slider, 'true');
						echo '</figure>';
                    }elseif ( $post_view == "Dragable Gallery" && $post_gallery <> ''){
                        $width = 529;
                        $height = 400;
                        	cs_portfolio_gallery($width,$height,$post_gallery,$post_view);
                    }elseif($post_view == "Simple Gallery" && $post_gallery <> ''){
                          echo cs_portfolio_gallery($width,$height,$post_gallery,$post_view);
					 }elseif($post_view == "Video" && $post_video <> ''){
						 	$custom_height = 433;
							$custom_width = '100%';
							$url = parse_url($post_video);
							 echo "<figure class='call-frame'>";
							if($url['host'] == $_SERVER["SERVER_NAME"]){
							?>
							
								<video width="100%" class="mejs-wmp" height="<?php echo $custom_height;?>" src="<?php echo $post_video ?>" poster="<?php if($inside_post_featured_image_as_thumbnail == "on"){ echo $image_url; } ?>" controls="controls" preload="none"></video>
							<?php
							}else{
								echo wp_oembed_get($post_video,array('height'=>$custom_height));
							}
							echo "</figure>";
					 }elseif($post_view == "Use Featured Image" && $image_url <> ''){
						//echo '<div class="detail-figure">';
						echo '<figure class="detail_images call-frame">';
                       	echo '<img src="'.$image_url.'" alt="" />';
						echo '</figure>';
						//echo '</div>';
					 }elseif($post_view == "Audio" and $post_audio <> ''){
						 $custom_height = 50;
							echo "<figure class='call-frame'>";
						?>
						<div class="audiowrapp fullwidth">
							<audio style="width:100%; height:<?php echo $custom_height;?>" src="<?php echo $post_audio; ?>" type="audio/mp3" controls="controls"></audio>
						</div>    
						<?php
						echo "</figure>";
						}
                ?>	
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12  ">
                        <div class="detail-text portfolio-sec port-<?php echo $port_class;?>">
                            <div class="inner-sec">
                                <h2><?php the_title();?></h2>
                                <?php the_content();
								wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Snapture' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
                                <?php comments_template('', true); ?>
                            </div>
                        </div>
                        <div class="aside table-cell-<?php echo $port_class;?>">
                        <!-- Post Number Start -->
                        <div class="number-of-post">
                        	<?php cs_next_prev_custom_links();?>
                        </div>
                        <!-- Post Number End -->
                        <div class="progress-widget">
                        	
                            <?php if($cs_xmlObject->port_other_info_main_title <> ''){ ?>
                            <header class="cs-heading-title"><h6><?php echo $cs_xmlObject->port_other_info_main_title?></h6></header>
                            <?php } 
                              $port_other_info_title = '';
                              $port_other_info_desc = '';
                              $port_other_info_icon = '';
                              ?>
                            <ul>
                                <?php 
									if ( $post_xml <> "" ) {
									  cs_portfolio_other_info($cs_xmlObject);
								   	}
									  /* translators: used between list items, there is a space after the comma */
									  $before_cat = '<li><span>Categories</span><p>';
									  $categories_list = get_the_term_list ( get_the_id(), 'portfolio-category', $before_cat, ', ', '</p></li>' );
									  if ( $categories_list ){
										  printf( __( '%1$s', 'Snapture'),$categories_list );
									  }
                                      if($cs_xmlObject->port_live_link_title <> '' || $cs_xmlObject->port_live_link_url <> ''){
										echo '<li><span>'.$cs_xmlObject->port_live_link_title.'</span><p><a class="colrhvr" href="'.cs_add_http($cs_xmlObject->port_live_link_url).'" target="_blank">'.preg_replace('#^https?://#', '', $cs_xmlObject->port_live_link_url);'</a></p></li>';
										}
										?>
                                <?php if($cs_xmlObject->portfolio_social_sharing == 'on'){
											cs_addthis_script_init_method();
									?><li><a class="addthis_button_compact share-btn"><i class="fa fa-plus-circle">&nbsp;<?php if($cs_theme_option["trans_switcher"] == "on") { _e("Share this post",'Snapture'); }else{  echo $cs_theme_option["trans_share_this_post"];}?></i></a></li><?php }?>
                            </ul>
                        </div>
                    <div class="clear"></div>
                    </div>
                    </div>

            <?php endwhile;   endif;?>
     
    <!-- Span9 End --> 
<?php get_footer(); ?>