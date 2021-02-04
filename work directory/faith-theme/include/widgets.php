<?php 
// widget start

// widget_facebook start

class facebook_module extends WP_Widget

{

  function facebook_module()

  {

		$widget_ops = array('classname' => 'facebok_widget', 'description' => 'Facebook widget like box total customized with theme.' );

		$this->WP_Widget('facebook_module', 'CS : Facebook', $widget_ops);

  }

  function form($instance)

  {

		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );

		$title = $instance['title'];

		$pageurl = isset( $instance['pageurl'] ) ? esc_attr( $instance['pageurl'] ) : '';

		$showfaces = isset( $instance['showfaces'] ) ? esc_attr( $instance['showfaces'] ) : '';

		$showstream = isset( $instance['showstream'] ) ? esc_attr( $instance['showstream'] ) : '';

		$showheader = isset( $instance['showheader'] ) ? esc_attr( $instance['showheader'] ) : '';

		$fb_bg_color = isset( $instance['fb_bg_color'] ) ? esc_attr( $instance['fb_bg_color'] ) : '';

		//$likebox_width = isset( $instance['likebox_width'] ) ? esc_attr( $instance['likebox_width'] ) : '';

		$likebox_height = isset( $instance['likebox_height'] ) ? esc_attr( $instance['likebox_height'] ) : '';						

	?>

	  <p>

	  <label for="<?php echo $this->get_field_id('title'); ?>">

		  Title: 

		  <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size='40' name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />

	  </label>

	  </p> 

	  <p>

	  <label for="<?php echo $this->get_field_id('pageurl'); ?>">

		  Page URL: 

		  <input class="upcoming" id="<?php echo $this->get_field_id('pageurl'); ?>" size='40' name="<?php echo $this->get_field_name('pageurl'); ?>" type="text" value="<?php echo esc_attr($pageurl); ?>" />

		<br />

		  <small>Please enter your page or User profile url example: http://www.facebook.com/profilename OR <br />

		  https://www.facebook.com/pages/wxyz/123456789101112

		</small><br />

		<!--<strong>Only People Will Be Shown Please Use Height to Manage Your View.</strong>-->

	  </label>

	  </p> 

	  <p>

 	  <label for="<?php echo $this->get_field_id('showfaces'); ?>">

		  Show Faces: 

		  <input class="upcoming" id="<?php echo $this->get_field_id('showfaces'); ?>" name="<?php echo $this->get_field_name('showfaces'); ?>" type="checkbox" <?php if(esc_attr($showfaces) != '' ){echo 'checked';}?> />

	  </label>

	  </p> 

	  <p>

	  <label for="<?php echo $this->get_field_id('showstream'); ?>">

		  Show Stream: 

		  <input class="upcoming" id="<?php echo $this->get_field_id('showstream'); ?>" name="<?php echo $this->get_field_name('showstream'); ?>" type="checkbox" <?php if(esc_attr($showstream) != '' ){echo 'checked';}?> />

	  </label>

	  </p> 

	  <!--<p>

	  <label for="<?php echo $this->get_field_id('likebox_width'); ?>">

		  Like Box Width:

		  <input class="upcoming" id="<?php echo $this->get_field_id('likebox_width'); ?>" size='5' name="<?php echo $this->get_field_name('likebox_width'); ?>" type="text" value="<?php echo esc_attr($likebox_width); ?>" />

	  </label>

	  </p>-->

	  <p>

	  <label for="<?php echo $this->get_field_id('likebox_height'); ?>">

		  Like Box Height:

		  <input class="upcoming" id="<?php echo $this->get_field_id('likebox_height'); ?>" size='2' name="<?php echo $this->get_field_name('likebox_height'); ?>" type="text" value="<?php echo esc_attr($likebox_height); ?>" />

	  </label>

	  </p>

      <p>		

     <label for="<?php echo $this->get_field_id('fb_bg_color'); ?>">

     	Background Color:

  		<input type="text" name="<?php echo $this->get_field_name('fb_bg_color'); ?>" size='4' id="<?php echo $this->get_field_id('fb_bg_color'); ?>"  value="<?php if(!empty($fb_bg_color)){ echo $fb_bg_color;}else{ echo "#fff";}; ?>" class="fb_bg_color upcoming"  />

    </label>

    </p>

	<?php

	  }

	  function update($new_instance, $old_instance)

	  {

		$instance = $old_instance;

		$instance['title'] = $new_instance['title'];

		$instance['pageurl'] = $new_instance['pageurl'];

		$instance['showfaces'] = $new_instance['showfaces'];	

		$instance['showstream'] = $new_instance['showstream'];

		$instance['showheader'] = $new_instance['showheader'];

		$instance['fb_bg_color'] = $new_instance['fb_bg_color'];		

		//$instance['likebox_width'] = $new_instance['likebox_width'];

		$instance['likebox_height'] = $new_instance['likebox_height'];			

		return $instance;

	  }

		function widget($args, $instance)

		{

			extract($args, EXTR_SKIP);

			$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

			$pageurl = empty($instance['pageurl']) ? ' ' : apply_filters('widget_title', $instance['pageurl']);

			$showfaces = empty($instance['showfaces']) ? ' ' : apply_filters('widget_title', $instance['showfaces']);

			$showstream = empty($instance['showstream']) ? ' ' : apply_filters('widget_title', $instance['showstream']);

			$showheader = empty($instance['showheader']) ? ' ' : apply_filters('widget_title', $instance['showheader']);

			$fb_bg_color = empty($instance['fb_bg_color']) ? ' ' : apply_filters('widget_title', $instance['fb_bg_color']);								

			//$likebox_width = empty($instance['likebox_width']) ? ' ' : apply_filters('widget_title', $instance['likebox_width']);								

			$likebox_height = empty($instance['likebox_height']) ? ' ' : apply_filters('widget_title', $instance['likebox_height']);													

			if(isset($showfaces) AND $showfaces == 'on'){$showfaces ='true';}else{$showfaces = 'false';}

			if(isset($showstream) AND $showstream == 'on'){$showstream ='true';}else{$showstream ='false';}

			

			echo $before_widget;	

			// WIDGET display CODE Start

			if (!empty($title) && $title <> ' '){

				echo $before_title;

				echo $title;

				echo $after_title;

			}

				global $wpdb, $post;?>

				<style type="text/css" >

					.facebookOuter {

						background-color:<?php echo $fb_bg_color ?>; 

						width:100%; 

						padding:0;

						float:left;

					}

					.facebookInner {

						float: left;

						width: 100%;

					}

					.facebook_module, .fb_iframe_widget > span, .fb_iframe_widget > span > iframe {

					 width: 100% !important;

					}

					.fb_iframe_widget, .fb-like-box div span iframe {

					 width: 100% !important;

					 float: left;

					}

				</style>

				<div class="facebook">

					<div class="facebookOuter">

				 <div class="facebookInner">

				  <div class="fb-like-box" 

					  colorscheme="light" data-height="<?php echo $likebox_height;?>"  data-width="190" 

					  data-href="<?php echo $pageurl;?>" 

					  data-border-color="#fff" data-show-faces="<?php echo $showfaces;?>"  data-show-border="false"

					  data-stream="<?php echo $showstream;?>" data-header="false">

				  </div>          

				 </div>

				</div>

				</div>

 				<script>(function(d, s, id) {

				  var js, fjs = d.getElementsByTagName(s)[0];

				  if (d.getElementById(id)) return;

				  js = d.createElement(s); js.id = id;

				  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";

				  fjs.parentNode.insertBefore(js, fjs);

				}(document, 'script', 'facebook-jssdk'));

				</script>

		<?php echo $after_widget;

			}

			

		}

	add_action( 'widgets_init', create_function('', 'return register_widget("facebook_module");') );

	// widget_facebook end

class cs_social_network_widget extends WP_Widget{

  function cs_social_network_widget()

  {

		$widget_ops = array('classname' => 'widget_text widget-socialnetwork', 'description' => 'Social Newtork widget.' );

		$this->WP_Widget('cs_social_network_widget', 'CS : Social Newtork', $widget_ops);

  }

  function form($instance)

  {

		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );

		$title = $instance['title'];

	?>

	  <p>

	  <label for="<?php echo $this->get_field_id('title'); ?>">

		  Title: 

		  <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size='40' name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />

	  </label>

	  </p> 


	<?php

	  }

	  function update($new_instance, $old_instance)

	  {

		$instance = $old_instance;

		$instance['title'] = $new_instance['title'];

		return $instance;

	  }

		function widget($args, $instance)

		{

			extract($args, EXTR_SKIP);

			$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
			

			echo $before_widget;	

			// WIDGET display CODE Start

			if (!empty($title) && $title <> ' '){

				echo $before_title;

				echo $title;

				echo $after_title;

			}

				global $wpdb, $post;
 					cs_social_network();
 
				echo $after_widget;

			}

			

		}

	add_action( 'widgets_init', create_function('', 'return register_widget("cs_social_network_widget");') );

	// widget_social network end

	// widget_gallery start

	class cs_gallery extends WP_Widget {

	

		function cs_gallery() {

			$widget_ops = array('classname' => 'widget_gallery', 'description' => 'Select any gallery to show in widget.');

			$this->WP_Widget('cs_gallery', 'CS : Gallery Widget', $widget_ops);

		}

	

		function form($instance) {

			$instance = wp_parse_args((array) $instance, array('title' => '', 'get_names_gallery' => 'new'));

			$title = $instance['title'];

			$get_names_gallery = isset($instance['get_names_gallery']) ? esc_attr($instance['get_names_gallery']) : '';

			$showcount = isset($instance['showcount']) ? esc_attr($instance['showcount']) : '';

			?>

			<p>

				<label for="<?php echo $this->get_field_id('title'); ?>">

					Title: 

					<input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />

				</label>

			</p>

			<p>

				<label for="<?php echo $this->get_field_id('get_names_gallery'); ?>">

					Select Gallery:

					<select id="<?php echo $this->get_field_id('get_names_gallery'); ?>" name="<?php echo $this->get_field_name('get_names_gallery'); ?>" style="width:225px;">

						<?php

						global $wpdb, $post;

						$newpost = 'posts_per_page=-1&post_type=cs_gallery&order=ASC&post_status=publish';

						$newquery = new WP_Query($newpost);

						while ($newquery->have_posts()): $newquery->the_post();

							?>

							<option <?php

							if (esc_attr($get_names_gallery) == $post->post_name) {

								echo 'selected';

							}

							?> value="<?php echo $post->post_name; ?>" >

							<?php echo substr(get_the_title($post->ID), 0, 20);

							if (strlen(get_the_title($post->ID)) > 20)

								echo "...";

							?>

							</option>						

						<?php endwhile; ?>

					</select>

				</label>

			</p>  

			 

			<p>

				<label for="<?php echo $this->get_field_id('showcount'); ?>">

					Number of Images: 

					<input class="upcoming" id="<?php echo $this->get_field_id('showcount'); ?>" size="2" name="<?php echo $this->get_field_name('showcount'); ?>" type="text" value="<?php echo esc_attr($showcount); ?>" />

				</label>

			</p>  

			<?php

		}

	

		function update($new_instance, $old_instance) {



			$instance = $old_instance;

			$instance['title'] = $new_instance['title'];

			$instance['get_names_gallery'] = $new_instance['get_names_gallery'];

			$instance['showcount'] = $new_instance['showcount'];

  			return $instance;

		}

	

		function widget($args, $instance) {

			extract($args, EXTR_SKIP);

			global $wpdb, $post;

			$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

			$get_names_gallery = isset($instance['get_names_gallery']) ? esc_attr($instance['get_names_gallery']) : '';

			$showcount = isset($instance['showcount']) ? esc_attr($instance['showcount']) : '';

			if (empty($showcount)) {

				 $showcount = '12';

			}

			

			// WIDGET display CODE Start

			echo $before_widget;

			if (strlen($get_names_gallery) <> 1 || strlen($get_names_gallery) <> 0) {

				echo $before_title . $title . $after_title;

			}

 			if ($get_names_gallery <> '') {

 				// galery slug to id start

				$get_gallery_id = '';

				$args=array(

					'name' => $get_names_gallery,

					'post_type' => 'cs_gallery',

					'post_status' => 'publish',

					'showposts' => 1,

				);

				$get_posts = get_posts($args);

 				if($get_posts){

					$get_gallery_id = $get_posts[0]->ID;

				}

				// galery slug to id end

				if($get_gallery_id <> ''){

				$cs_meta_gallery_options = get_post_meta($get_gallery_id, "cs_meta_gallery_options", true);

				if ($cs_meta_gallery_options <> "") {

					$cs_xmlObject = new SimpleXMLElement($cs_meta_gallery_options);

					if ($showcount > count($cs_xmlObject)) {

						$showcount = count($cs_xmlObject);

					}

				?>

				<ul class="gallery-list lightbox">

					<?php

 
 						for ($i = 0; $i < $showcount; $i++) {

							$path = $cs_xmlObject->gallery[$i]->path;

							$title = $cs_xmlObject->gallery[$i]->title;

							$social_network = $cs_xmlObject->gallery[$i]->social_network;

							$use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;

							$video_code = $cs_xmlObject->gallery[$i]->video_code;

							$link_url = $cs_xmlObject->gallery[$i]->link_url;

							$image_url = cs_attachment_image_src($path, 50, 50);

							$image_url_full = cs_attachment_image_src($path, 0, 0);

						?>

						 <li>

							<a <?php if ( $title <> '' ) { echo 'data-title="'.$title.'"'; }?> href="<?php if ($use_image_as == 1)echo $video_code;  elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" target="<?php if($use_image_as==2){ echo '_blank'; }else{ echo '_self'; }; ?>" data-rel="<?php if ($use_image_as == 1) echo "prettyPhoto"; elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>">
							<figure>
							<?php echo "<img width='60' height='60' src='" . $image_url . "' data-alt='" . $title . "' alt='' />" ?>
                                <figcaption>
                                     <span class="bghover"></span>
                                     <div class="text">
                                       <?php 
                                              if($use_image_as==1){
                                                  echo '<i class="fa fa-video-camera"></i>';
                                              }elseif($use_image_as==2){
                                                  echo '<i class="fa fa-link"></i>';	
                                              }else{
                                                  echo '<i class="fa fa-picture-o"></i>';
                                              }
                                          ?>
                                    </div>
                                </figcaption>
                            </figure>
                            
                            </a>

						</li>

				<?php } ?>

				</ul>

			 <?php }}else{

					cs_no_result_found(false);

				 }}     // endif of Category Selection?>

				

			 <?php

 			echo $after_widget; // WIDGET display CODE End

		}

	

	}

	

	add_action('widgets_init', create_function('', 'return register_widget("cs_gallery");'));

	// widget_gallery end

	// widget_recent_post start

	class recentposts extends WP_Widget

	{

	  function recentposts()

	  {

		$widget_ops = array('classname' => 'widget-recent-blog', 'description' => 'Recent Posts from category.' );

		$this->WP_Widget('recentposts', 'CS : Recent Posts', $widget_ops);

	  }

	 

	  function form($instance)

	  {

		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );

		$title = $instance['title'];

		$select_category = isset( $instance['select_category'] ) ? esc_attr( $instance['select_category'] ) : '';

		$showcount = isset( $instance['showcount'] ) ? esc_attr( $instance['showcount'] ) : '';	

		$thumb = isset( $instance['thumb'] ) ? esc_attr( $instance['thumb'] ) : '';

	?>

		<p>

			<label for="<?php echo $this->get_field_id('title'); ?>">

				Title: 

				<input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />

			</label>

		</p> 

		<p>

			<label for="<?php echo $this->get_field_id('select_category'); ?>">

			  Select Category:            

			  <select id="<?php echo $this->get_field_id('select_category'); ?>" name="<?php echo $this->get_field_name('select_category'); ?>" style="width:225px">

				<?php

				$categories = get_categories();

					if($categories <> ""){

						foreach ( $categories as $category ) {?>

							<option <?php if($select_category == $category->slug){echo 'selected';}?> value="<?php echo $category->slug;?>" ><?php echo $category->name;?></option>						

						<?php }?>

					<?php }?>            

			  </select>

			</label>

		</p>  

		<p>

			<label for="<?php echo $this->get_field_id('showcount'); ?>">

				Number of Posts To Display:

				<input class="upcoming" id="<?php echo $this->get_field_id('showcount'); ?>" size='2' name="<?php echo $this->get_field_name('showcount'); ?>" type="text" value="<?php echo esc_attr($showcount); ?>" />

			</label>

		</p>

		<p>

			<label for="<?php echo $this->get_field_id('thumb'); ?>">

				Display Thumbinals:

				<input class="upcoming" id="<?php echo $this->get_field_id('thumb'); ?>" size='2' name="<?php echo $this->get_field_name('thumb'); ?>" value="true" type="checkbox"  <?php if(isset($instance['thumb']) && $instance['thumb']=='true' ) echo 'checked="checked"'; ?> />

			</label>

		</p>

	<?php

	  }

	 

	  function update($new_instance, $old_instance)

	  {

		$instance = $old_instance;

		$instance['title'] = $new_instance['title'];

		$instance['select_category'] = $new_instance['select_category'];

		$instance['showcount'] = $new_instance['showcount'];

		$instance['thumb'] = $new_instance['thumb'];

		return $instance;

	  }

	 

		function widget($args, $instance)

		{

			global $cs_node;

			extract($args, EXTR_SKIP);

			$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

			$select_category = empty($instance['select_category']) ? ' ' : apply_filters('widget_title', $instance['select_category']);		

			$showcount = empty($instance['showcount']) ? ' ' : apply_filters('widget_title', $instance['showcount']);	

			$thumb = isset( $instance['thumb'] ) ? esc_attr( $instance['thumb'] ) : '';						

	

			if($instance['showcount'] == ""){$instance['showcount'] = '-1';}

			echo $before_widget;	

			// WIDGET display CODE Start

			if (!empty($title) && $title <> ' '){

				echo $before_title;

				echo $title;

				echo $after_title;

			}

				global $wpdb, $post,$cs_theme_option;?>

				<!-- Recent Posts Start -->

 						<?php

							wp_reset_query();

							$args = array( 'posts_per_page' => "$showcount",'post_type' => 'post','category_name' => "$select_category"); 

							$custom_query = new WP_Query($args);

							if ( $custom_query->have_posts() <> "" ) {

								while ( $custom_query->have_posts()) : $custom_query->the_post();

								$post_xml = get_post_meta($post->ID, "post", true);	

								$cs_xmlObject = new stdClass();

								if ( $post_xml <> "" ) {

									$cs_xmlObject = new SimpleXMLElement($post_xml);

									$post_view = '';

									$post_view = $cs_xmlObject->post_thumb_view;

									$post_image = $cs_xmlObject->post_thumb_image;

									$post_video = $cs_xmlObject->post_thumb_video;

									$post_audio = $cs_xmlObject->post_thumb_audio;

									$post_slider = $cs_xmlObject->post_thumb_slider;

									$post_slider_type = $cs_xmlObject->post_thumb_slider_type;

									$post_date = date("d F Y", strtotime(get_the_date()));

									$datetime = date("Y-d-m", strtotime(get_the_date()));

 									$width 	= 150;

									$height = 150;

 									$image_url = cs_get_post_img_src($post->ID, $width, $height);

 									}

								?>

									<!-- Upcoming Widget Start -->

									<article>

										<?php if($thumb == "true"){?>

											<figure>

												<?php

												if($post_view <> ''){

 
													echo "<a href='".get_permalink()."' ><img src='".$image_url."' alt='' width='45'></a>";												 

												}

												?>
												<figcaption>
                                                 	<a href="<?php the_permalink(); ?>"><i class="fa fa-plus-circle"></i></a>
                                                </figcaption>
                                             </figure>

                                            <div class="text">

                                            	<h6><a class="cs-colrhvr" href="<?php the_permalink();?>"><?php echo substr(get_the_title(),0,30); if ( strlen(get_the_title()) > 30) echo "..."; ?></a></h6>
                                                <ul class="post-options">
                                                    <li><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Posted on','Faith'); }else{ echo $cs_theme_option['trans_posted_on']; } ?> <time><?php echo get_the_date();?></time></li>
                                                </ul>
                                            </div>

											 

										<?php }else{ ?>

											 <div class="text">

                                            	<h6><a class="cs-colrhvr" href="<?php echo get_permalink();?>"><?php echo substr(get_the_title(),0,30);if ( strlen(get_the_title()) > 30) echo "..."; ?></a></h6>	
                                                <ul class="post-options">
                                                    <li><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Posted on','Faith'); }else{ echo $cs_theme_option['trans_posted_on']; } ?> <time><?php echo get_the_date();?></time></li>
                                                </ul>
                                            </div>

										<?php } ?>

									</article>                 

								<?php endwhile; ?>

							<?php

                            }

							else {

								cs_no_result_found(false);

							}?>

  				<!-- Recent Posts End -->     

				<?php

				echo $after_widget;

			}

		}

		add_action( 'widgets_init', create_function('', 'return register_widget("recentposts");') );

	// widget_recent_post end

	// widget_twitter start

 	class cs_twitter_widget extends WP_Widget {
		function cs_twitter_widget() {
			$widget_ops = array('classname' => 'widget widget-latestnews widget-twitter', 'description' => 'Twitter Widget');
			$this->WP_Widget('cs_twitter_widget', 'CS : Twitter Widget', $widget_ops);
		}
		function form($instance) {
			$instance = wp_parse_args((array) $instance, array('title' => ''));
			$title = $instance['title'];
			$username = isset($instance['username']) ? esc_attr($instance['username']) : '';
			$numoftweets = isset($instance['numoftweets']) ? esc_attr($instance['numoftweets']) : '';
 		?>
          	<label for="<?php echo $this->get_field_id('title'); ?>">
				<span>Title: </span>
				<input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</label>
			<label for="screen_name">User Name<span class="required">(*)</span>: </label>
				<input class="upcoming" id="<?php echo $this->get_field_id('username'); ?>" size="40" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo esc_attr($username); ?>" />
            <label for="tweet_count">
			<span>Num of Tweets: </span>
			<input class="upcoming" id="<?php echo $this->get_field_id('numoftweets'); ?>" size="2" name="<?php echo $this->get_field_name('numoftweets'); ?>" type="text" value="<?php echo esc_attr($numoftweets); ?>" />
			<div class="clear"></div>
			</label>
  		<?php
		}
	
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = $new_instance['title'];
			$instance['username'] = $new_instance['username'];
			$instance['numoftweets'] = $new_instance['numoftweets'];
			
 			return $instance;
		}
  		function widget($args, $instance) {
			global $cs_theme_option;
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
			$username = $instance['username'];
 			$numoftweets = $instance['numoftweets'];		
	 		if($numoftweets == ''){$numoftweets = 2;}
			echo $before_widget;
  			// WIDGET display CODE Start
			if (!empty($title) && $title <> ' '){
				echo $before_title . $title . $after_title;
			}
			if(strlen($username) > 1){
					$text ='';
					$return = '';
					require_once "twitteroauth/twitteroauth.php"; //Path to twitteroauth library
					$consumerkey = $cs_theme_option['consumer_key'];
					$consumersecret = $cs_theme_option['consumer_secret'];
					$accesstoken = $cs_theme_option['access_token'];
					$accesstokensecret = $cs_theme_option['access_token_secret'];
 					$connection = new TwitterOAuth($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
 					$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$username."&count=".$numoftweets);
  					if(!is_wp_error($tweets) and is_array($tweets)){
 						?>
                        
                        <?php
						$return .= "<div class='widget_slider'>
                            <div class='flexslider'>
                                <ul class='slides'>";
							foreach($tweets as $tweet) {
								$text = $tweet->{'text'};
								foreach($tweet->{'user'} as $type => $userentity) {
									if($type == 'profile_image_url') {	
										$profile_image_url = $userentity;
									} else if($type == 'screen_name'){
										$screen_name = '<a href="https://twitter.com/' . $userentity . '" target="_blank" class="cs-colrhvr" title="' . $userentity . '">@' . $userentity . '</a>';
									}
								}
								foreach($tweet->{'entities'} as $type => $entity) {
								if($type == 'urls') {						
									foreach($entity as $j => $url) {
										$display_url = '<a href="' . $url->{'url'} . '" target="_blank" title="' . $url->{'expanded_url'} . '">' . $url->{'display_url'} . '</a>';
										$update_with = 'Read more at '.$display_url;
										$text = str_replace('Read more at '.$url->{'url'}, '', $text);
										$text = str_replace($url->{'url'}, '', $text);
									}
								} else if($type == 'hashtags') {
									foreach($entity as $j => $hashtag) {
										$update_with = '<a href="https://twitter.com/search?q=%23' . $hashtag->{'text'} . '&src=hash" target="_blank" title="' . $hashtag->{'text'} . '">#' . $hashtag->{'text'} . '</a>';
										$text = str_replace('#'.$hashtag->{'text'}, $update_with, $text);
									}
								} else if($type == 'user_mentions') {
										foreach($entity as $j => $user) {
											  $update_with = '<a href="https://twitter.com/' . $user->{'screen_name'} . '" target="_blank" title="' . $user->{'name'} . '">@' . $user->{'screen_name'} . '</a>';
											  $text = str_replace('@'.$user->{'screen_name'}, $update_with, $text);
										}
									}
								} 
								$large_ts = time();
								$n = $large_ts - strtotime($tweet->{'created_at'});
								if($n < (60)){ $posted = sprintf(__('%d seconds ago','Faith'),$n); }
								elseif($n < (60*60)) { $minutes = round($n/60); $posted = sprintf(_n('About a Minute Ago','@%d Minutes Ago',$minutes,'Faith'),$minutes); }
								elseif($n < (60*60*16)) { $hours = round($n/(60*60)); $posted = sprintf(_n('About an Hour Ago','@%d Hours Ago',$hours,'Faith'),$hours); }
								elseif($n < (60*60*24)) { $hours = round($n/(60*60)); $posted = sprintf(_n('About an Hour Ago','@%d Hours Ago',$hours,'Faith'),$hours); }
								elseif($n < (60*60*24*6.5)) { $days = round($n/(60*60*24)); $posted = sprintf(_n('About a Day Ago','@%d Days Ago',$days,'Faith'),$days); }
								elseif($n < (60*60*24*7*3.5)) { $weeks = round($n/(60*60*24*7)); $posted = sprintf(_n('About a Week Ago','%d Weeks Ago',$weeks,'Faith'),$weeks); } 
								elseif($n < (60*60*24*7*4*11.5)) { $months = round($n/(60*60*24*7*4)) ; $posted = sprintf(_n('About a Month Ago','%d Months Ago',$months,'Faith'),$months);}
								elseif($n >= (60*60*24*7*4*12)){$years=round($n/(60*60*24*7*52)) ; $posted = sprintf(_n('About a year Ago','%d years Ago',$years,'Faith'),$years);}
								$return .="<li><div class='tweet'>";
								$return .= "<h6 class='heading-color'>" . $text . "</h6>";
 								$return .= "<time datetime='2011-01-12'>" . $posted. "</time>";
								$return .="</div></li>";
						}
				$return .= "</ul></div><em class='fa fa-twitter'></em></div>";
				echo $return;
				?>
				<script type="text/javascript">
					jQuery(document).ready(function($) {
						cs_twitter_slider();
					});
				</script>
				<?php
 		}else{
			if($tweets->errors[0] <> ""){
				echo $tweets->errors[0]->message.".<br> Please enter valid Twitter API Keys";
			}else{
				cs_no_result_found(false);
			}
		}
	}else{ 				
			cs_no_result_found(false);
		}
		echo $after_widget;
		// WIDGET display CODE End
		}
 	}
 	add_action('widgets_init', create_function('', 'return register_widget("cs_twitter_widget");'));
	
	

	// widget_twitter end



// widget end


// Event Widget



class upcoming_events extends WP_Widget

{

  function upcoming_events()

  {

    $widget_ops = array('classname' => 'widget-latest-event fullwidth', 'description' => 'Select Event to show its countdown.' );

    $this->WP_Widget('upcoming_events', 'CS : Upcoming Events', $widget_ops);

  }

 

  function form($instance)

  {

    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ,'widget_names_events' =>'new') );

    $title = $instance['title'];

	$get_post_slug = isset( $instance['get_post_slug'] ) ? esc_attr( $instance['get_post_slug'] ) : '';

	$showcount = isset( $instance['showcount'] ) ? esc_attr( $instance['showcount'] ) : '';	

?>

  <p>

  <label for="<?php echo $this->get_field_id('title'); ?>">

	  Title: 

	  <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />

  </label>

  </p>

  <p>

  <label for="<?php echo $this->get_field_id('get_post_slug'); ?>">

	  Select Event:

	  <select id="<?php echo $this->get_field_id('get_post_slug'); ?>" name="<?php echo $this->get_field_name('get_post_slug'); ?>" style="width:225px">

      	<option value=""> Select Category</option>

		<?php

        global $wpdb,$post;

		$categories = get_categories('taxonomy=event-category&child_of=0&hide_empty=0'); 

			if($categories != ''){}

				foreach ( $categories as $category){ ?>

                    <option <?php if(esc_attr($get_post_slug) == $category->slug){echo 'selected';}?> value="<?php echo $category->slug;?>" >

	                    <?php echo substr($category->name, 0, 20);	if ( strlen($category->name) > 20 ) echo "...";?>

                    </option>						

			<?php }?>

      </select>

  </label>

  </p>

  <p>

  <label for="<?php echo $this->get_field_id('showcount'); ?>">

	  Number of Events: 

	  <input class="upcoming" id="<?php echo $this->get_field_id('showcount'); ?>" size="2" name="<?php echo $this->get_field_name('showcount'); ?>" type="text" value="<?php echo esc_attr($showcount); ?>" />

  </label>

  </p>  

<?php

  }

 

  function update($new_instance, $old_instance)

  {

    $instance = $old_instance;

    $instance['title'] = $new_instance['title'];

	$instance['get_post_slug'] = $new_instance['get_post_slug'];	

	$instance['showcount'] = $new_instance['showcount'];		

	

	

    return $instance;

  }

 

	function widget($args, $instance)

	{

		extract($args, EXTR_SKIP);

		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

		$get_post_slug = isset( $instance['get_post_slug'] ) ? esc_attr( $instance['get_post_slug'] ) : '';

		$showcount = isset( $instance['showcount'] ) ? esc_attr( $instance['showcount'] ) : '';		

		if(empty($showcount)){$showcount = '4';}

		// WIDGET display CODE Start

		echo $before_widget;	

		wp_reset_query();	

		if (!empty($title) && $title <> ' '){

				echo $before_title . $title . $after_title;

			}

			global $wpdb, $post;

 			//$term = get_term( $get_names_events, 'event-category' );

 			if($get_post_slug <> ''){

				$newterm = get_term_by('slug', $get_post_slug, 'event-category'); 

					$args = array(

						'posts_per_page'			=> $showcount,

						'post_type'					=> 'events',

						'event-category'			=> "$get_post_slug",

                        'post_status'				=> 'publish',

                        'meta_key'					=> 'cs_event_from_date',

                        'meta_value'				=> date('Y-m-d'),

                        'meta_compare'				=> ">=",

                        'orderby'					=> 'meta_value',

                        'order'						=> 'ASC'

 					);

                    $custom_query = new WP_Query($args);

					if ( $custom_query->have_posts() <> "" ) {

						

 						$cs_counter_events = 0;

                        while ( $custom_query->have_posts() ): $custom_query->the_post();

							$cs_counter_events++;

							$cs_event_from_date = get_post_meta($post->ID, "cs_event_from_date", true); 

							$year_event = date("Y", strtotime($cs_event_from_date));

							$month_event = date("M", strtotime($cs_event_from_date));

							$day_event = date("d", strtotime($cs_event_from_date));

							$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);

							if ( $cs_event_meta <> "" ) {

								$cs_event_meta = new SimpleXMLElement($cs_event_meta);

								$event_start_time = $cs_event_meta->event_start_time;

								$event_end_time = $cs_event_meta->event_end_time;

							}

							$cs_event_loc = get_post_meta($cs_event_meta->event_address, "cs_event_loc_meta", true);

 						?>

                         <!-- Events Widget Start -->
						
                        <article>
                        	<div class="calendar-date">
                            	<span><?php echo date_i18n('M',strtotime($cs_event_from_date));?></span>
                            	<time datetime="2014-02-01"><?php echo date_i18n('d',strtotime($cs_event_from_date));?></time>
                   			 </div>
                            <div class="text">
                            	<h6><a href="<?php echo get_permalink(); ?>" class="cs-colrhvr"><?php

									echo substr(get_the_title(), 0, 20);

									if (strlen(get_the_title()) > 20)

										echo "...";

									?></a>
                                 </h6>
                                 <div class="post-options">
                                    <ul>
                                        <li><i class="fa fa-clock-o"></i>
                                        <?php 
                                            if ( $cs_event_meta->event_all_day != "on" ) {
                                                
                                                echo $event_start_time; if($cs_event_meta->event_end_time <> ''){ echo "-";  echo $cs_event_meta->event_end_time; }
                                                
                                            } else {
                                                   echo '<time>';
                                                        _e("All",'Statford') . printf( __("%s day",'Statford'), ' ');
                                                   echo '</time>';
                                            }
                                        
                                        ?>
                                        </li>
                                        <li><i class="fa fa-map-marker"></i><?php echo get_the_title((int) $cs_event_meta->event_address); ?>.</li>
                                    </ul>
                                </div>
                             </div>
                        </article>

                        <!-- Events Widget End -->		

 						<?php endwhile;?>

                        						

 					<?php }else{

							cs_no_result_found(false);

						}

			}	// endif of Category Selection

			echo $after_widget;	// WIDGET display CODE End

		}

	}

add_action( 'widgets_init', create_function('', 'return register_widget("upcoming_events");') );


?>