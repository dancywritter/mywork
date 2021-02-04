<?php cs_enqueue_parallax_script(); ?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery(".parallaxbg").each(function (index) {
		jQuery(this).parallax("50%", .1)
	});
});
</script>
<?php
 		global $cs_node, $post, $element_size_class, $cs_counter_node, $cs_theme_option;
		$parallax_element_size = $cs_node->parallax_element_size;
		$parallax_element = $cs_node->parallax_element;
		$parallax_view = $cs_node->parallax_view;
		$parallax_height = $cs_node->parallax_height;
		$parallax_margin_top = $cs_node->parallax_margin_top;
		$parallax_margin_bottom = $cs_node->parallax_margin_bottom;
		if ( !isset($cs_node->parallax_bgimg) or $cs_node->parallax_bgimg == "" ) { $cs_node->parallax_bgimg = ''; }
		if ( !isset($cs_node->parallax_bgcolor) or $cs_node->parallax_bgcolor == "" ) { $cs_node->paralla_bgcolor = ''; }
		if ( !isset($cs_node->parallax_title) or $cs_node->parallax_title == "" ) { $cs_node->parallax_title = ''; $parallax_title = ''; } else { $parallax_title = $cs_node->parallax_title;}
		echo '<div class="element_size_'.$cs_node->parallax_element_size.'" >';
		// $cs_counter = $post->ID . $cs_count_node;
		if ($parallax_element == 'twitter') {
			cs_enqueue_flexslider_script();
			if(isset($cs_node->parallax_twitter_profile) && !empty($cs_node->parallax_twitter_profile)){
				$parallax_twitter_profile = $cs_node->parallax_twitter_profile;
			} else {
				$parallax_twitter_profile = '';
			}
			if(isset($cs_node->parallax_twitter_back_top) && !empty($cs_node->parallax_twitter_back_top)){
				$parallax_twitter_back_top = $cs_node->parallax_twitter_back_top;
			} else {
				$parallax_twitter_back_top = '';
			}
			if(isset($cs_node->parallax_twitter_bgcolor) && !empty($cs_node->parallax_twitter_bgcolor)){
				$parallax_twitter_bgcolor = $cs_node->parallax_twitter_bgcolor;
			} else {
				$parallax_twitter_bgcolor = '';
			}
			if(isset($cs_node->parallax_twitter_num_tweets) && !empty($cs_node->parallax_twitter_num_tweets)){
				$parallax_twitter_num_tweets = $cs_node->parallax_twitter_num_tweets;
			} else {
				$parallax_twitter_num_tweets = '';
			}
			if(isset($cs_node->parallax_twitter_bgimg) && !empty($cs_node->parallax_twitter_bgimg)){
				$parallax_twitter_bgimg = $cs_node->parallax_twitter_bgimg;
			} else {
				$parallax_twitter_bgimg = '';
			}
			?>
                    <div class="qoute parallaxbg webkit <?php if(isset($parallax_view) && !empty($parallax_view)){ echo $parallax_view.'-width';} else { echo 'parallax-full-width';}?>" style=" <?php if($cs_node->parallax_bgimg <> '') { ?>background: url(<?php echo $cs_node->parallax_bgimg; ?>) no-repeat center top fixed  ;<?php } if(isset($parallax_height) && !empty($parallax_height)){ ?> height: <?php echo $parallax_height ?>px; <?php }?>  margin-bottom:<?php echo $parallax_margin_bottom?>px; margin-top:<?php echo $parallax_margin_top?>px; <?php if(isset($cs_node->parallax_bgcolor) && !empty($cs_node->parallax_bgcolor)){ ?> background-color:<?php echo $cs_node->parallax_bgcolor; ?>; <?php }?>">
                       <div class='container'>
                        <span class="pattren twitter-pattren" style="opacity: 0.8;"></span>
                        <span class="colorpatrn"></span>
                        <?php if($parallax_twitter_back_top=='Yes'){ echo '<a href="#" class="go-to-top gotop absolute bordercolr" id="back-top"></a>';}?>
                        
                        <!-- Container Start -->
                         <div id="flexslider<?php echo $cs_counter_node; ?>">
		  					<div class="flexslider">
			  					<ul class="slides">
                         <?php
                            if (strlen($parallax_twitter_profile) > 1) {
                                $return = '';
                                $response = '';
                                $exclude_replies = '0';
                                $include_rts = '0';
                               	$token = get_option('TWITTER_BEARER_TOKEN');
                                if ($token && $parallax_twitter_profile) {
                                    $args = array(
                                        'httpversion' => '1.1',
                                        'blocking' => true,
                                        'headers' => array(
                                            'Authorization' => "Bearer $token"
                                        )
                                    );
                                    add_filter('https_ssl_verify', '__return_false');
                                    $api_url = "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=$parallax_twitter_profile&count=$parallax_twitter_num_tweets&exclude_replies=$exclude_replies&include_rts=$include_rts";
									$response = wp_remote_get($api_url, $args);
                                     if (!is_wp_error($response) and $response <> "") {
                                        $tweets = json_decode($response['body']);
                                        foreach ($tweets as $i => $tweet) {
                                            $text = $tweet->{'text'};
                                            foreach ($tweet->{'entities'} as $type => $entity) {
                                                if ($type == 'urls') {
                                                    foreach ($entity as $j => $url) {
                                                        $update_with = '<a href="' . $url->{'url'} . '" target="_blank" title="' . $url->{'expanded_url'} . '">' . $url->{'display_url'} . '</a>';
                                                        $text = str_replace($url->{'url'}, $update_with, $text);
                                                    }
                                                } else if ($type == 'hashtags') {
                                                    foreach ($entity as $j => $hashtag) {
                                                        $update_with = '<a href="https://twitter.com/search?q=%23' . $hashtag->{'text'} . '&src=hash" target="_blank" title="' . $hashtag->{'text'} . '">#' . $hashtag->{'text'} . '</a>';
                                                        $text = str_replace('#' . $hashtag->{'text'}, $update_with, $text);
                                                    }
                                                } else if ($type == 'user_mentions') {
                                                    foreach ($entity as $j => $user) {
                                                        $update_with = '<a href="https://twitter.com/' . $user->{'screen_name'} . '" target="_blank" title="' . $user->{'name'} . '">@' . $user->{'screen_name'} . '</a>';
                                                        $text = str_replace('@' . $user->{'screen_name'}, $update_with, $text);
                                                    }
                                                }
                                            }
                                            $large_ts = time();
                                            $n = $large_ts - strtotime($tweet->{'created_at'});
                                            if ($n < (60)) {
                                                $posted = sprintf(__('%d seconds ago', 'rotatingtweets'), $n);
                                            } elseif ($n < (60 * 60)) {
                                                $minutes = round($n / 60);
                                                $posted = sprintf(_n('About a Minute Ago', '%d Minutes Ago', $minutes, 'rotatingtweets'), $minutes);
                                            } elseif ($n < (60 * 60 * 16)) {
                                                $hours = round($n / (60 * 60));
                                                $posted = sprintf(_n('About an Hour Ago', '%d Hours Ago', $hours, 'rotatingtweets'), $hours);
                                            } elseif ($n < (60 * 60 * 24)) {
                                                $hours = round($n / (60 * 60));
                                                $posted = sprintf(_n('About an Hour Ago', '%d Hours Ago', $hours, 'rotatingtweets'), $hours);
                                            } elseif ($n < (60 * 60 * 24 * 6.5)) {
                                                $days = round($n / (60 * 60 * 24));
                                                $posted = sprintf(_n('About a Day Ago', '%d Days Ago', $days, 'rotatingtweets'), $days);
                                            } elseif ($n < (60 * 60 * 24 * 7 * 3.5)) {
                                                $weeks = round($n / (60 * 60 * 24 * 7));
                                                $posted = sprintf(_n('About a Week Ago', '%d Weeks Ago', $weeks, 'rotatingtweets'), $weeks);
                                            } elseif ($n < (60 * 60 * 24 * 7 * 4 * 11.5)) {
                                                $months = round($n / (60 * 60 * 24 * 7 * 4));
                                                $posted = sprintf(_n('About a Month Ago', '%d Months Ago', $months, 'rotatingtweets'), $months);
                                            } elseif ($n >= (60 * 60 * 24 * 7 * 4 * 12)) {
                                                $years = round($n / (60 * 60 * 24 * 7 * 52));
                                                $posted = sprintf(_n('About a year Ago', '%d years Ago', $years, 'rotatingtweets'), $years);
                                            }
                                            $user = $tweet->{'user'};
                                            $return .= '<li><article class="twitter"><div class="twitter-inner"><i class="icon-twitter icon-3x"></i><div class="text">';
                                            $return .= "<h4>" . $text . "</h4>";
                                            $return .= '<a href="http://www.twitter.com/' . $parallax_twitter_profile . '" class="twitter-anker">' . $parallax_twitter_profile . '</a>';
                                            $return .= "<a class='twitter-anker'>" . $posted . "</a>";
                                            $return .= "</div><a class='tweet_btn' href='http://www.twitter.com/".$parallax_twitter_profile."'>Follow us on Twitter</a></div></article> </li>";
                                        }
                                        echo $return;
                                    }
                                } else {
                                    if ($response <> "") {
                                        echo $response->errors['http_failure'][0];
                                    } else {
                                        echo "'._e('No results found.', 'OneLife').'";
                                    }
                                }
                                ?>
                        <?php
                    } else {
                        echo '<h4 class="heading-color">No User information given.</h4>';
                    }
                    ?>
                    	</ul>
					</div>
                    </div>                 
                	</div>
                <?php
				} elseif ($parallax_element == 'blog') {
                    if ( !isset($cs_node->parallax_blog_category) or $cs_node->parallax_blog_category == "" ) { $cs_node->parallax_blog_category = ''; }
                    if ( !isset($cs_node->parallax_blog_num_post) or $cs_node->parallax_blog_num_post == "" ) { $cs_node->parallax_blog_num_post = ''; }
					if ( !isset($cs_node->parallax_blog_text) or $cs_node->parallax_blog_text == "" ) { $cs_node->parallax_blog_text = ''; }
					cs_enqueue_jcycle_script();
					cs_enqueue_custom_active_script();
                    if (empty($_GET['page_id_all']))
                            $_GET['page_id_all'] = 1;
                        $argss = array('posts_per_page' => "-1", 'paged' => $_GET['page_id_all'], 'cat' => "$cs_node->parallax_blog_category", 'post_status' => 'publish');
                        $custom_query = new WP_Query($argss);
                        $post_count = $custom_query->post_count;
						if(have_posts()):
                    ?>
                   
                
                   <div class="parallax parallaxbg align-center bolg_column <?php if(isset($parallax_view) && !empty($parallax_view)){ echo $parallax_view.'-width';} else { echo 'parallax-full-width';}?>" style="background-position: 50% -5px; <?php if ($cs_node->parallax_bgimg <> '') { ?>background: url(<?php echo $cs_node->parallax_bgimg; ?>) no-repeat center top fixed;<?php } if(isset($cs_node->parallax_height) && !empty($cs_node->parallax_height)){ ?> height: <?php echo $cs_node->parallax_height ?>px; <?php } ?> margin-bottom:<?php echo $parallax_margin_bottom?>px; margin-top:<?php echo $parallax_margin_top?>px; <?php  if(isset($cs_node->parallax_bgcolor) && !empty($cs_node->parallax_bgcolor)){ ?> background-color:<?php echo $cs_node->parallax_bgcolor; ?>; <?php }?>">
                   
                    <span class="pattren blog-pattren" style="opacity: 0.8;"></span>
                    <div class="container fullwidth"> 
      				<!-- Our Story Start -->
                          <div class="our_story webkit">
                          <?php if(isset($parallax_title) && $parallax_title <> ''){?>
                            <header class="tittle">
                              <h4 class="uppercase"><?php echo $parallax_title;?></h4>
                            </header>
                            <?php }?>
                            <?php if(isset($cs_node->parallax_blog_text) && $cs_node->parallax_blog_text <> ''){?><p><?php echo $cs_node->parallax_blog_text;?></p><?php }?>
                            <div id="sliderwrapp">
                              <div id="sliderwrappinner">
                                <div class="cycle-slideshow" id="slider" 
                             data-cycle-slides="> article"
                            data-cycle-timeout="0"
                            data-cycle-fx="carousel"
                            data-cycle-carousel-visible="1"
                            data-cycle-carousel-fluid=false
                            data-allow-wrap="false">
                            	 <article>
                                    <div class="text"><?php echo get_cat_name( $cs_node->parallax_blog_category );?></div>
                                  </article>
                                  <?php
								  $qYears = "SELECT DISTINCT YEAR(post_date) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_date DESC";
									$years = $wpdb->get_col($qYears);
									foreach($years as $year){?>
									 <article>
                                        <div class="numbring webkit"><?php echo $year;?></div>
                                      </article>
								  <?php
								  $args = array('posts_per_page' => "$cs_node->parallax_blog_num_post", 'cat' => "$cs_node->parallax_blog_category", 'year' => "$year", 'post_status' => 'publish','orderby' => 'date', 'order' => 'DESC');
									$custom_query = new WP_Query($args);
									$tip='tip';
										while ($custom_query->have_posts()) : $custom_query->the_post();
										$post_xml = get_post_meta($post->ID, "post", true);	
										if ( $post_xml <> "" ) {
											$cs_xmlObject = new SimpleXMLElement($post_xml);
											$post_view = $cs_xmlObject->post_thumb_view;
											$post_image = $cs_xmlObject->post_thumb_image;
											$post_audio = $cs_xmlObject->post_thumb_audio;
											$post_video = $cs_xmlObject->post_thumb_video;
											$post_slider = $cs_xmlObject->post_thumb_slider;
 											$custom_height = 150;
											$width 	= 301;
											$height	= 169;
											$image_url = cs_get_post_img_src($post->ID, $width, $height);
										}else{
											$post_view ='';
										}
									 ?>
                                  <article id="post-<?php the_ID(); ?>" <?php post_class($tip); ?>><span class="tipround">tip</span>
                                    <div class="curcltooltip">
                                      <h6><?php echo substr(get_the_title(),0,25); ?></h6>
                                      <span><?php echo get_the_date();?></span> </div>
                                    <!-- Story Text Start -->
                                    <div class="story_text webkit">
                                      <figure>
										  <?php
											 if ($post_view == "Map" and $post_view <> ''){
												$cs_node->map_lat = $cs_xmlObject->post_thumb_map_lat;
												$cs_node->map_lon = $cs_xmlObject->post_thumb_map_lon;
												$cs_node->map_zoom = $cs_xmlObject->post_thumb_map_zoom;
												$cs_node->map_address = $cs_xmlObject->post_thumb_map_address;
												$cs_node->map_controls = $cs_xmlObject->post_thumb_map_controls;
												$cs_node->map_height = $custom_height;
												echo cs_map_page();
											}elseif( $post_view == "Slider" and $post_slider <> '' and $post_view <> ''){
												 cs_flex_slider($width,$height,$post_slider);
											}elseif($post_view == "Single Image" and $post_view <> ''){
												cs_enqueue_gallery_style_script();
												echo "<a href=".get_permalink()."><img src='".$image_url."' alt=''></a>";
											}elseif($post_view == "Video" and $post_view <> ''){
												$url = parse_url($post_video);
												if($url['host'] == $_SERVER["SERVER_NAME"]){?>
													<video width="100%" class="mejs-wmp" height="<?php echo $custom_height; ?>" src="<?php echo $post_video ?>" id="player1" poster="<?php echo $image_url; ?>" controls="controls" preload="none"></video>
											<?php
												}else{
													echo wp_oembed_get($post_video,array('width'=>$width,'height' => $custom_height));
												}
											}elseif($post_view == "Audio" and $post_audio <> ''){
												?>
												<audio style="width:100%;" src="<?php echo $post_audio; ?>" controls="controls"></audio>
												<?php
											}
                                     	?>
                                 	</figure>
                                      <div class="left_text">
                                        <header><h2 class="heading-color post-title"><a href="<?php the_permalink(); ?>" class="colrhover"><?php echo substr(get_the_title(),0,30); ?></a></h2></header>
                                        <p><?php echo cs_get_the_excerpt('375',true) ?></p>
                                        <time datetime="<?php echo get_the_date();?>"><?php echo get_the_date();?></time>
                                      </div>
                                    </div>
                                    <!-- Story Text End --> 
                                  </article>
                                  <?php endwhile; } ?>
									 
                                </div>
                              </div>
                            </div>
                          </div>
                      <!-- Our Story End --> 
                    </div>
               <!-- Blog End -->
               </div>
                <?php
				endif; 
                } elseif ($parallax_element == 'portfolio') {
					if ( !isset($cs_node->parallax_portfolio_category) or $cs_node->parallax_portfolio_category == "" ) { $cs_node->parallax_portfolio_category = ''; }
                    if ( !isset($cs_node->parallax_portfolio_num_post) or $cs_node->parallax_portfolio_num_post == "" ) { $cs_node->parallax_portfolio_num_post = '-1'; }
					$filter_category = '';
					$row_cat = $wpdb->get_row("SELECT * from ".$wpdb->prefix."terms WHERE slug = '" . $cs_node->parallax_portfolio_category ."'" );
					if ( isset($_GET['filter_category']) ) {$filter_category = $_GET['filter_category'];}
					else {
						if(isset($row_cat->slug)){
							$filter_category = $row_cat->slug;
						}
					}
					cs_enqueue_gallery_style_script();
                  	cs_enqueue_filterable_style_script();
                  ?>
                    <script>
                    jQuery(document).ready(function($){
                       jQuery(' #list').mixitup({ effects :["blur","fade"]});
                        jQuery(".splitter li a") .click(function(event){
                            jQuery(".splitter li") .removeClass("active");
                            jQuery(this).parent() .addClass("active")
                       }); 
                      });
					 </script>
 					 <style>
                    	#list .mix{
							opacity: 0;
							display: none;
						}
                    </style>
				<div class="qoute1 parallaxbg1 webkit1 <?php if(isset($parallax_view) && !empty($parallax_view)){ echo $parallax_view.'-width';} else { echo 'parallax-full-width';}?> " style="background-position: 50% -5px; <?php if ($cs_node->parallax_bgimg <> '') { ?>background: url(<?php echo $cs_node->parallax_bgimg; ?>) no-repeat center top fixed;<?php } if(isset($cs_node->parallax_height) && !empty($cs_node->parallax_height)){ ?> height: <?php echo $cs_node->parallax_height ?>px; <?php } ?>  margin-bottom:<?php echo $parallax_margin_bottom?>px; margin-top:<?php echo $parallax_margin_top?>px; <?php  if(isset($cs_node->parallax_bgcolor) && !empty($cs_node->parallax_bgcolor)){ ?> background-color:<?php echo $cs_node->parallax_bgcolor; ?>; <?php }?>">
			      	<span class="pattren portfolio-pattren" style="opacity: 0.8;"></span>
                    <div class="container fullwidth"> 
                      <!-- Portfolio Start -->
                      <div class="portfolio">
                       		<div class="info">
								 <?php if(isset($parallax_title) && $parallax_title <> ''){?>
                                <header class="tittle">
                                  <h4 class="uppercase"><?php echo $parallax_title;?></h4>
                                </header>
                                <?php }?>
                            </div>
                        <!-- Filter Nav Start -->
                        <div class="filter_nav">
                            <ul class="splitter">
                                <li class="filter active" data-filter="mix">
                                 <a><?php _e("All",'Onelife'); ?></a>
                                </li>
                                <?php
                                    $categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'portfolio-category', 'hide_empty' => 0) );
                                    foreach ($categories as $category) {
                                    ?>
                                        <li class="filter" data-filter="<?php echo $category->term_id; ?>"><a><?php echo $category->cat_name?></a></li>
                                <?php
                                    }
                                ?>
                            </ul>
                        </div>
                        <!-- Filter Nav End --> 
                        <!-- Image Grid Start -->
                        <ul id="list" class="image-grid lightbox" >
                            <?php 
                                    if (empty($_GET['page_id_all']))
                                        $_GET['page_id_all'] = 1;
                                        
                                         $args = array(
                                            'posts_per_page' => "$cs_node->parallax_portfolio_num_post",
                                            'post_type' => 'Portfolio',
                                            'portfolio-category' => "$cs_node->parallax_portfolio_category",
                                            'post_status' => 'publish',
                                            'order' => 'ASC',
                                        );
                                        $custom_query = new WP_Query($args);
										//echo $custom_query->post_count;
                                        if(have_posts()):
                                        while ($custom_query->have_posts()) : $custom_query->the_post();
                                        $post_xml = get_post_meta($post->ID, "portfolio", true);
                                            if($post_xml <> ''){
                                                $cs_xmlObject = new SimpleXMLElement($post_xml);
                                                $custom_height = 240;
                                                $width = 570;
                                                $height = 428; 
                                                
                                            }
											$image_full_url = cs_get_post_img_src($post->ID,0,0);
                                            $image_url = cs_get_post_img_src($post->ID,570,428);
                                            $conter = 1;
                                            $categories_list = get_the_terms($post->ID,'portfolio-category');
                                            $conter = 1; 
                                            $cats = array();
                                            $cats[0] = 'mix box';
                                            foreach($categories_list as $cat){
                                                $cats[$conter] =' '.$cat->term_id;
                                                $conter++;
                                            }
                                        ?>
                                      <li  <?php post_class($cats); ?>> 
                                        <!-- Article Start -->
                                        <article <?php post_class(); ?>>
                                          <figure> <?php
                                             if($image_url <> ""){
                                                         echo '<a href="'.get_permalink().'"><img src="'.$image_url.'" ></a>';
														 ?>
                                                         <figcaption class="backcolr">
                                                          <div class="text webkit">
                                                           <h4><a href="<?php echo get_permalink(); ?>">
														   	<?php
																  echo substr(get_the_title(), 0, 34);
																  if (strlen(get_the_title()) > 34)
																	  echo "...";
															  ?></a></h4>
                                                             <p><?php echo cs_get_the_excerpt('151',true) ?></p>
                                                          </div>
                                                          <p class="icons"><a href="<?php echo $image_full_url;?>" data-rel="prettyPhoto" class="icon-zoom-in icon-2x webkit"></a><a href="<?php echo get_permalink(); ?>" class="icon-link icon-2x webkit"></a> </p>
                                                        </figcaption>
                                                    <?php
                                                        }
                                                    ?>
                                            </figure>
                                        </article>
                                        <!-- Article End --> 
                                      </li>
                                <?php endwhile; endif; ?>
                            </ul>
                        <!-- Image Grid End --> 
                        </div>
                      <!-- Portfolio End --> 
                    </div>
                <div class="clear"></div>
				   </div>
				   <?php 
				   } elseif ($parallax_element == 'map') {
				if ( !isset($cs_node->parallax_height) or $cs_node->parallax_height == "" ) { $cs_node->parallax_height = 200; }
                if ( !isset($cs_node->parallax_map_lat) or $cs_node->parallax_map_lat == "" ) { $cs_node->parallax_map_lat = 0; }
                if ( !isset($cs_node->parallax_map_lon) or $cs_node->parallax_map_lon == "" ) { $cs_node->parallax_map_lon = 0; }
                if ( !isset($cs_node->parallax_map_zoom) or $cs_node->parallax_map_zoom == "" ) { $cs_node->parallax_map_zoom = 11; }
                if ( !isset($cs_node->parallax_map_info_width) or $cs_node->parallax_map_info_width == "" ) { $cs_node->parallax_map_info_width = 200; }
                if ( !isset($cs_node->parallax_map_info_height) or $cs_node->parallax_map_info_height == "" ) { $cs_node->parallax_map_info_height = 100; }
                if ( !isset($cs_node->parallax_map_show_marker) or $cs_node->parallax_map_show_marker == "" ) { $cs_node->parallax_map_show_marker = 'true'; }
                if ( !isset($cs_node->parallax_map_controls) or $cs_node->parallax_map_controls == "" ) { $cs_node->parallax_map_controls = 'false'; }
                if ( !isset($cs_node->parallax_map_scrollwheel) or $cs_node->parallax_map_scrollwheel == "" ) { $cs_node->parallax_map_scrollwheel = 'true'; }
                if ( !isset($cs_node->parallax_map_draggable) or $cs_node->parallax_map_draggable == "" )  { $cs_node->parallax_map_draggable = 'true'; }
                if ( !isset($cs_node->parallax_map_type) or $cs_node->parallax_map_type == "" ) { $cs_node->parallax_map_type = 'ROADMAP'; }
                if ( !isset($cs_node->parallax_map_info)) { $cs_node->parallax_map_info = ''; }
                if( !isset($cs_node->parallax_map_marker_icon)){ $cs_node->parallax_map_marker_icon = ''; }
                //if( !isset($cs_node->parallax_map_title)){ $cs_node->parallax_map_title ='';}
                if( !isset($cs_node->parallax_map_element_size)){ $cs_node->parallax_map_element_size ='default';}
                     $map_show_marker = '';
                    ?>
                     <div class="qoute parallaxbg webkit <?php if(isset($parallax_view) && !empty($parallax_view)){ echo $parallax_view.'-width';} else { echo 'parallax-full-width';}?>" style=" <?php if(isset($cs_node->parallax_height) && !empty($cs_node->parallax_height)){ ?> height: <?php echo $cs_node->parallax_height ?>px; <?php } if(isset($cs_node->parallax_bgcolor) && !empty($cs_node->parallax_bgcolor)){ ?>background-color:<?php echo $cs_node->parallax_bgcolor; ?>; <?php }?> margin-bottom:<?php echo $parallax_margin_bottom?>px; margin-top:<?php echo $parallax_margin_top?>px; padding:0px;">
                     <?php if($parallax_view=='parallax-boxed'){?>
                            <div class='container'>
                        <?php }
                    if ( $cs_node->parallax_map_show_marker == "true" ) { 
                            $map_show_marker = " var marker = new google.maps.Marker({
								position: myLatlng,
								map: map,
								title: '',
								icon: '".$cs_node->parallax_map_marker_icon."',
								shadow:''
							});
                            ";
                    }
                    //wp_enqueue_script('googleapis', 'https://maps.googleapis.com/maps/api/js?sensor=true', '', '', true);
                    $html = '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>';
                    $html .= '<div class="webkit map_sec">';
					if(isset($parallax_title) && $parallax_title <> ''){
                       $html .= '<h1 class="color heading-color">'.$parallax_title.'</h1>';
					}
                     $html .= '<div class="mapcode mapcode'.$cs_counter_node.' iframe mapsection gmapwrapp" id="map_canvas'.$cs_counter_node.'" style="height:'.$cs_node->parallax_height.'px;"> </div>';
                    $html .= '</div>';
                    $html .= "<script type='text/javascript'>
						function initialize() {
								var myLatlng = new google.maps.LatLng(".$cs_node->parallax_map_lat.", ".$cs_node->parallax_map_lon.");
								var mapOptions = {
										zoom: ".$cs_node->parallax_map_zoom.",
										scrollwheel: ".$cs_node->parallax_map_scrollwheel.",
										draggable: ".$cs_node->parallax_map_draggable.",
										center: myLatlng,
										mapTypeId: google.maps.MapTypeId.".$cs_node->parallax_map_type." ,
										disableDefaultUI: ".$cs_node->parallax_map_controls.",
								}
								var map = new google.maps.Map(document.getElementById('map_canvas".$cs_counter_node."'), mapOptions);
								var infowindow = new google.maps.InfoWindow({
										content: '".$cs_node->parallax_map_info."',
										maxWidth: ".$cs_node->parallax_map_info_width.",
										maxHeight:".$cs_node->parallax_map_info_height.",
								});
								".$map_show_marker."
								//google.maps.event.addListener(marker, 'click', function() {
									if (infowindow.content != ''){
									  infowindow.open(map, marker);
									   map.panBy(1,-60);
									   google.maps.event.addListener(marker, 'click', function(event) {
										infowindow.open(map, marker);
									   });
									}
								//});
						}
				google.maps.event.addDomListener(window, 'load', initialize);
			</script>";
		echo $html;
		if($cs_node->parallax_view=='Boxed View'){
			echo '</div>';
		 }
		echo '</div>';
		} elseif ($parallax_element == 'custom') {
		if ( !isset($cs_node->parallax_custom_text) or $cs_node->parallax_custom_text == "" ) { $cs_node->parallax_custom_text = ''; }
		if ( !isset($cs_node->parallax_custom_back_top) or $cs_node->parallax_custom_back_top == "" ) { $cs_node->parallax_custom_back_top = ''; }
	?>
		<!-- Qoute Start -->
		<div class="qoute parallaxbg webkit <?php if(isset($parallax_view) && !empty($parallax_view)){ echo $parallax_view.'-width';} else { echo 'parallax-full-width';}?>" style=" <?php if ($cs_node->parallax_bgimg <> '') { ?> background: url(<?php echo $cs_node->parallax_bgimg; ?>) no-repeat center top fixed;<?php } if(isset($cs_node->parallax_height) && !empty($cs_node->parallax_height)){ ?> height: <?php echo $cs_node->parallax_height ?>px; <?php } ?>  margin-bottom:<?php echo $parallax_margin_bottom?>px; margin-top:<?php echo $parallax_margin_top?>px; <?php  if(isset($cs_node->parallax_bgcolor) && !empty($cs_node->parallax_bgcolor)){ ?>background-color:<?php echo $cs_node->parallax_bgcolor; ?>; <?php }?>">
            <div class='container'>
                    <?php if ($cs_node->parallax_custom_back_top == 'Yes'){ echo '<a id="back-top" class="go-to-top gotop absolute bordercolr" href="#"></a>';} ?>
                <div class="custom-text">
                      <?php if ($cs_node->parallax_custom_text <> ''){ echo cs_textarea_filter($cs_node->parallax_custom_text); }?>
                </div>
            </div>
		<!-- Qoute End -->
	</div>
	<?php
	}
echo '</div>';
?>