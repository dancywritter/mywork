<?php
// search varibales start
function cs_get_search_results($query) {
	if ( !is_admin() and (is_search() || is_archive())) {
		$query->set( 'posts_per_page', '40' );
		$query->set( 'post_type', array('post', 'events', 'albums' ,'artists') );
		remove_action( 'pre_get_posts', 'cs_get_search_results' );
	}
}
add_action('pre_get_posts', 'cs_get_search_results');

// Filter shortcode in text areas
if ( ! function_exists( 'cs_textarea_filter' ) ) { 
	function cs_textarea_filter($content=''){
		return do_shortcode($content);
	}
}
// Date differance
function cs_dateDiff($start, $end) {
	  $start_ts = strtotime($start);
	  $end_ts = strtotime($end);
	  $diff = $end_ts - $start_ts;
	  return round($diff / 86400);
}
/* Display navigation to next/previous for single.php */
if ( ! function_exists( 'cs_next_prev_post' ) ) { 
	function cs_next_prev_post(){
	global $post;
	posts_nav_link();
	wp_link_pages( $args );
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
    	<div class="detail_post webkit">
 			<?php 
			 __('Next Post','Bolster');
			previous_post_link( '%link', '<i class="fa fa-angle-left fa-2"></i><span class="prev">'.__('Previous Post','Bolster').'</span>' ); ?>
			<?php next_post_link( '%link','<span class="nexts">'.__('Next Post','Bolster').'</span><i class="fa fa-angle-right fa-2"></i>' ); ?>
 
		</div>
	 
	<?php
	}
}
// next and prev post end

//	Add Featured/sticky text/icon for sticky posts.
if ( ! function_exists( 'cs_featured()' ) ) {
	function cs_featured(){
		global $cs_transwitch,$cs_theme_option;
		if ( is_sticky() ){ ?>
		<span class="featured"><i class="icon-pushpin"></i></span>
		<?php
		}
	}
}
// Artist Tweets
function cs_artist_twitter_feeds($username, $numoftweets='', $heading_title=''){
	global $cs_theme_option;
	if($numoftweets == ''){$numoftweets = 5;}
	if(strlen($username) > 1){
		$text ='';
		$return = '';
		require_once "include/twitteroauth/twitteroauth.php"; //Path to twitteroauth library
		$consumerkey = $cs_theme_option['consumer_key'];
		$consumersecret = $cs_theme_option['consumer_secret'];
		$accesstoken = $cs_theme_option['access_token'];
		$accesstokensecret = $cs_theme_option['access_token_secret'];
		$connection = new TwitterOAuth($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
		$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$username."&count=".$numoftweets);
		$display_url =  '';
 		if(!is_wp_error($tweets) and is_array($tweets)){
				$return .= '<div class="twittersection">
				<div class="col-counter">';
				if(isset($heading_title) && $heading_title <> ''){
					 $return .= '<h2 class="section-title cs-heading-color">'.$heading_title.'</h2>';
				}
				$return .= '<ul>';
					foreach($tweets as $tweet) {
 						$text = $tweet->text;
						$reaply_to_screen_name = $tweet->in_reply_to_screen_name; 
						foreach($tweet->{'user'} as $type => $userentity) {
							if($type == 'profile_image_url') {	
								$profile_image_url = $userentity;
							} else if($type == 'screen_name'){
								$screen_name = '<a href="https://twitter.com/' . $userentity . '" target="_blank" class="colrhover" title="' . $userentity . '">@' . $userentity . '</a>';
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
						if($n < (60)){ $posted = sprintf(__('%d seconds ago','Spikes'),$n); }
						elseif($n < (60*60)) { $minutes = round($n/60); $posted = sprintf(_n('About a Minute Ago','@%d Minutes Ago',$minutes,'Spikes'),$minutes); }
						elseif($n < (60*60*16)) { $hours = round($n/(60*60)); $posted = sprintf(_n('About an Hour Ago','@%d Hours Ago',$hours,'Spikes'),$hours); }
						elseif($n < (60*60*24)) { $hours = round($n/(60*60)); $posted = sprintf(_n('About an Hour Ago','@%d Hours Ago',$hours,'Spikes'),$hours); }
						elseif($n < (60*60*24*6.5)) { $days = round($n/(60*60*24)); $posted = sprintf(_n('About a Day Ago','@%d Days Ago',$days,'Spikes'),$days); }
						elseif($n < (60*60*24*7*3.5)) { $weeks = round($n/(60*60*24*7)); $posted = sprintf(_n('About a Week Ago','%d Weeks Ago',$weeks,'Spikes'),$weeks); } 
						elseif($n < (60*60*24*7*4*11.5)) { $months = round($n/(60*60*24*7*4)) ; $posted = sprintf(_n('About a Month Ago','%d Months Ago',$months,'Spikes'),$months);}
						elseif($n >= (60*60*24*7*4*12)){$years=round($n/(60*60*24*7*52)) ; $posted = sprintf(_n('About a year Ago','%d years Ago',$years,'Spikes'),$years);}
						$return .= '<li>
							<div class="panel-twitter"></div>
							<div class="twitter-top">
								<img src="'.$profile_image_url.'" alt="">                        
								<div class="right-twitter">
									<h5>' . $screen_name. '</h5>
								</div>
							</div>
							<p>' . $text . '<br>'.$display_url.'</p>
							<p class="tweet-time">
										<em class="fa fa-twitter"></em>
										' . $posted. '
									</p>
						</li>';
					}
					$return .= " </ul>
					</div>
				 </div> ";
		echo $return;
		}else{
			if($tweets->errors[0] <> ""){
				echo $tweets->errors[0]->message.".<br> Please enter valid Twitter API Keys";
			}else{
			_e( 'No results found.', 'Spikes' );	
			}
		}
	}
}
// Load more Archive posts
add_action("wp_ajax_cs_load_more_archive", "cs_load_more_archive");
add_action("wp_ajax_nopriv_cs_load_more_archive", "cs_load_more_archive");

function cs_load_more_archive() {
   		global $cs_node, $post,$wp_query;
		$author_archive = $calendar_archive = $calendar_archive = $events_archive  = $album_archive = $artists_archive = $blog_cat_archive = $blog_tag_archive = 0;
				$author = '';
				$taxonomy = 'category';
				$taxonomy_tag = 'post_tag';
				$taxonomy_category='';
				$args_cat = array();
				if(isset($_REQUEST['year'])){$arch_year = $_REQUEST['year'];} else{$arch_year = "";}
				if(isset($_REQUEST['hour'])){$arch_hour = $_REQUEST['hour'];} else{$arch_hour = "";}
				
    	$cs_node = new stdClass;
        $offset = $_REQUEST['offset'];
        $page_id_all = $_REQUEST['page_id_all'];
        $cs_blog_num_post = $_REQUEST['cs_blog_num_post'];
		if(isset($_REQUEST['author_archive']) && $_REQUEST['author'] == '1'){
			$args_cat = array('author' => $_REQUEST['author_archive']);
					$post_type = array( 'post', 'events', 'albums', 'artists' );
			
		} else if(isset($_REQUEST['calendar_archive']) && $_REQUEST['calendar_archive'] == '1'){
			$args_cat = array('m' => $_REQUEST['m'],'year' => $arch_year,'day' => $_REQUEST['day'],'hour' => $arch_hour, 'minute' => $_REQUEST['minute'], 'second' => $_REQUEST['second']);
			$post_type = array( 'post');
			
		} else if(isset($_REQUEST['taxonomy']) && $_REQUEST['taxonomy'] <> '' && $_REQUEST['taxonomy_category'] <> '' && isset($_REQUEST['taxonomy_category'])){
					$taxonomy = $_REQUEST['taxonomy'];
					$taxonomy_category='';
						$taxonomy_category=$_REQUEST['taxonomy_category'];
					if( $_REQUEST['taxonomy']=='album-category' || $_REQUEST['taxonomy']=='album-tag') {
						$album_archive = 1;
					  $args_cat = array( $taxonomy => "$taxonomy_category");
					  $post_type='albums';
				  } else if( $_REQUEST['taxonomy']=='event-category' || $_REQUEST['taxonomy']=='event-tag') {
					  $args_cat = array( $taxonomy => "$taxonomy_category");
					  $post_type='events';
						$events_archive = 1;						  
					} else if( $_REQUEST['taxonomy']=='artists-category') {
						$args_cat = array( $taxonomy => "$taxonomy_category");
						$post_type='artists';
						$artists_archive = 1;
						
					}
				} else if(isset($_REQUEST['blog_cat_archive']) && $_REQUEST['blog_cat_archive'] == '1'){
					$taxonomy = 'category';
					$args_cat = array();
					$category_blog = $_REQUEST['cat'];
					$blog_cat_archive = 1;
					$post_type='post';
					$args_cat = array( 'cat' => "$category_blog");
				} else if(isset($_REQUEST['blog_tag_archive']) && $_REQUEST['blog_tag_archive'] == '1'){
					$taxonomy = 'category';
					$args_cat = array();
					$blog_tag_archive = 1;
					$tag_blog = $_REQUEST['tag'];
					$post_type='post';
					$args_cat = array( 'tag' => "$tag_blog");
					
				} else {
					$taxonomy = 'category';
					$args_cat = array();
					$post_type='post';
					
				}
		 	$offset = $_REQUEST['offset'];
			$args = array( 
				'post_type'		 => $post_type, 
				'posts_per_page' => "$cs_blog_num_post",
				'paged'			 => $page_id_all,
				'post_status'	 => 'publish', 
				'order'			 => 'ASC',
			);
			$args = array_merge($args_cat,$args);
			$custom_query = new WP_Query($args);
                       	if ( $custom_query->have_posts() <> "" ) {
							while ($custom_query->have_posts()) : $custom_query->the_post();
							 	?>
							<article  class="post">
							<!-- News List Start -->
								 <div class="article-wrapp">
						 
								 <div class="desc">
									<h2 class="post-title">
										<a href="<?php the_permalink(); ?>" class="colrhover"><?php echo substr(get_the_title(),0,32); if(strlen(get_the_title()) > 32) echo "..."; ?></a>
									</h2>
									<p>
										<?php 
											cs_get_the_excerpt(255,true);
											wp_link_pages();
										?>
									</p>
									<div class="bottom-post">
										<a class="img-icon-box" title="" data-toggle="tooltip" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" data-original-title="<?php echo get_the_author(); ?>"><?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('cs_author_bio_avatar_size', 50)); ?></a>
										<div class="text">
											<p class="panel">
												<time><?php echo get_the_date();?></time>
											</p>
											
										</div>
									</div>
								</div>
								
							</div>
						</article>
					<?php 
					 endwhile; } 
    exit;
}
// Load more Search posts
add_action("wp_ajax_cs_load_more_search", "cs_load_more_search");
add_action("wp_ajax_nopriv_cs_load_more_search", "cs_load_more_search");

function cs_load_more_search() {
   		global $cs_node, $post;
    	$cs_node = new stdClass;
        $offset = $_REQUEST['offset'];
        $cs_blog_category = $_REQUEST['catid'];
        $page_id_all = $_REQUEST['page_id_all'];
        $cs_blog_num_post = $_REQUEST['cs_blog_num_post'];

					$args = array(
                                'posts_per_page'			=> "$cs_blog_num_post",
								'paged'						=> $page_id_all,
                                'post_type'					=> array( 'post', 'artists', 'events', 'albums' ),
                                's'			=> "$cs_blog_category",
                               // 'post_status'				=> 'publish',
								//'order'						=> 'DESC',
                             );
  							$custom_query = new WP_Query($args);
                       	if ( $custom_query->have_posts() <> "" ) {
							while ($custom_query->have_posts()) : $custom_query->the_post();
							 	?>
                                <article  class="post">
							<!-- News List Start -->
							 <div class="article-wrapp">
						 
								 <div class="desc">
									<h2 class="post-title">
										<a href="<?php the_permalink(); ?>" class="colrhover"><?php echo substr(get_the_title(),0,32); if(strlen(get_the_title()) > 32) echo "..."; ?></a>
									</h2>
									<p>
										<?php 
											cs_get_the_excerpt(255,true);
											wp_link_pages();
										?>
									</p>
									<div class="bottom-post">
											<a class="img-icon-box" title="" data-toggle="tooltip" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" data-original-title="<?php echo get_the_author(); ?>"><?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('cs_author_bio_avatar_size', 50)); ?></a>
										<div class="text">
											<p class="panel">
												<time><?php echo get_the_date();?></time>
											</p>
											
										</div>
									</div>
								</div>
								
							</div>
						</article>
                                <?php 
								 endwhile; } 
    exit;
}
// Load more index posts
add_action("wp_ajax_cs_load_more_index_posts", "cs_load_more_index_posts");
add_action("wp_ajax_nopriv_cs_load_more_index_posts", "cs_load_more_index_posts");

function cs_load_more_index_posts() {
   		global $cs_node, $post;
    	$cs_node = new stdClass;
        $offset = $_REQUEST['offset'];
        $page_id_all = $_REQUEST['page_id_all'];
        $cs_blog_num_post = $_REQUEST['cs_blog_num_post'];
		$args = array(
			'posts_per_page'			=> "$cs_blog_num_post",
			'paged'						=> $page_id_all,
  		   // 'post_status'				=> 'publish',
			//'order'						=> 'DESC',
		 );
		$custom_query = new WP_Query($args);
		if ( $custom_query->have_posts() <> "" ) {
			while ($custom_query->have_posts()) : $custom_query->the_post();
				?>
				<article  class="post">
					<!-- News List Start -->
					 <div class="article-wrapp">
						<div class="desc">
							<h2 class="post-title">
								<a href="<?php the_permalink(); ?>" class="colrhover"><?php echo substr(get_the_title(),0,32); if(strlen(get_the_title()) > 32) echo "..."; ?></a>
							</h2>
							<p>
								<?php 
									cs_get_the_excerpt(255,true);
									wp_link_pages();
								?>
							 </p>
							<div class="bottom-post">
								<a class="img-icon-box" title="" data-toggle="tooltip" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" data-original-title="<?php echo get_the_author(); ?>"><?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('cs_author_bio_avatar_size', 50)); ?></a>
								<div class="text">
									<p class="panel">
										<time><?php echo get_the_date();?></time>
									</p>
								 </div>
							</div>
						</div>
					</div>
				</article>
			<?php 
			endwhile; 
		} 
    exit;
}
// Load more Album
add_action("wp_ajax_cs_load_more_gallery", "cs_load_more_gallery");
add_action("wp_ajax_nopriv_cs_load_more_gallery", "cs_load_more_gallery");

function cs_load_more_gallery() {
    global $cs_node, $post, $cs_theme_option;
    $cs_node = new stdClass;

        $offset = $_REQUEST['offset'];
        $gal_album_db = $_REQUEST['catid'];
		$gallery_view = $_REQUEST['gallery_view'];
        $page_id_all = $_REQUEST['page_id_all'];
		$show_description = $_REQUEST['show_description'];
        $cs_gallery_num_post = $_REQUEST['cs_gallery_num_post'];
		$cs_thumb_space =  $_REQUEST['cs_thumb_space'];
		$args=array(
			'name' => $gal_album_db,
			'post_type' => 'cs_gallery',
			'post_status' => 'publish',
			'showposts' => 1,
		);
 		$get_posts = get_posts($args);
		if($get_posts){
			$gal_album_db = $get_posts[0]->ID;
		}
	// galery slug to id end
	$cs_meta_gallery_options = get_post_meta($gal_album_db, "cs_meta_gallery_options", true);
	if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
	// pagination start
	if ( $cs_meta_gallery_options <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($cs_meta_gallery_options);
		if ($cs_gallery_num_post > 0 ) {
			$limit_start = $cs_gallery_num_post * ($page_id_all-1);
			$limit_end = $limit_start + $cs_gallery_num_post;
			$count_post = count($cs_xmlObject);
				if ( $limit_end > count($cs_xmlObject) ) 
					$limit_end = count($cs_xmlObject);
		}
		else {
			$limit_start = 0;
			$limit_end = count($cs_xmlObject);
			$count_post = count($cs_xmlObject);
		}
	}
	$counter_album_db = 0;
	if($gallery_view == 'gallery_masonry_view'){	
            if ( $cs_meta_gallery_options <> "" ) {
                for ( $i = $limit_start; $i < $limit_end; $i++ ) {
                    $path = $cs_xmlObject->gallery[$i]->path;
                    $title = $cs_xmlObject->gallery[$i]->title;
                    $description = $cs_xmlObject->gallery[$i]->description;
                    $social_network = $cs_xmlObject->gallery[$i]->social_network;
                    $use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;
                    $video_code = $cs_xmlObject->gallery[$i]->video_code;
                    $link_url = $cs_xmlObject->gallery[$i]->link_url;
 					$image_url = cs_attachment_image_src($path, 0, 0);
 					?>
					<article style="margin:0 <?php echo $cs_thumb_space; ?>px <?php echo $cs_thumb_space;?>px 0;">
						<figure>
							<img src="<?php echo $image_url; ?>" alt="<?php echo $title; ?>" data-alt="<?php echo $title; ?>">
							<span class="gallery_stack_element fa fa-stack ">
 								<?php 
                                      if($use_image_as==1){
                                          echo '<i class="fa fa-circle fa-stack-2x"></i> <i class="fa fa-play fa-stack-1x fa-inverse"></i>';
                                      }elseif($use_image_as==2){
                                          echo '<i class="fa fa-circle fa-stack-2x"></i> <i class="fa fa-link fa-stack-1x fa-inverse"></i>';	
                                      }
                                  ?>
                                </span>
							<figcaption>
								<a href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_url;?>" class="fa fa-stack btnhover" target="<?php if($use_image_as==2) echo '_blank'; ?>" data-rel="<?php if($use_image_as==1)echo "prettyPhoto";  elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>" >
									<span class="plus-icon"></span>
								</a>
							</figcaption>
						</figure>
					</article>
                    <?php
                }
            }
	}else if($gallery_view == 'gallery_squre_view'){
		if ( $cs_meta_gallery_options <> "" ) {
			for ( $i = $limit_start; $i < $limit_end; $i++ ) {
				$path = $cs_xmlObject->gallery[$i]->path;
				$title = $cs_xmlObject->gallery[$i]->title;
				$description = $cs_xmlObject->gallery[$i]->description;
				$social_network = $cs_xmlObject->gallery[$i]->social_network;
				$use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;
				$video_code = $cs_xmlObject->gallery[$i]->video_code;
				$link_url = $cs_xmlObject->gallery[$i]->link_url;
				$image_url = cs_attachment_image_src($path,270,270);
				$image_url_full = cs_attachment_image_src($path, 0, 0);
				if($image_url <> ''){
			?>
				<article style="margin:0 <?php echo $cs_thumb_space; ?>px <?php echo $cs_thumb_space;?>px 0;">
                	<figure>
                        <img src="<?php echo $image_url; ?>" alt="<?php echo $title; ?>" data-alt="<?php echo $title; ?>">
                         <span class="gallery_stack_element fa fa-stack ">
 													<?php 
														  if($use_image_as==1){
															  echo '<i class="fa fa-circle fa-stack-2x"></i> <i class="fa fa-play fa-stack-1x fa-inverse"></i>';
														  }elseif($use_image_as==2){
															  echo '<i class="fa fa-circle fa-stack-2x"></i> <i class="fa fa-link fa-stack-1x fa-inverse"></i>';	
														  }
													  ?>
                                                    </span>
                                        <figcaption>
                                        	<a data-title="<?php if ( $cs_node->desc == "On" ) { echo $description;}?>" href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" target="<?php if($use_image_as==2) echo '_blank'; ?>" class="fa fa-stack btnhover"  data-rel="<?php if($use_image_as==1)echo "prettyPhoto";  elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>" >
                                               <span class="plus-icon"></span>
                                            </a>
                                        </figcaption>
                    </figure>
				</article>
			<?php }}}
	}else{
		if ( $cs_meta_gallery_options <> "" ) {
			for ( $i = $limit_start; $i < $limit_end; $i++ ) {
				$path = $cs_xmlObject->gallery[$i]->path;
				$title = $cs_xmlObject->gallery[$i]->title;
				$description = $cs_xmlObject->gallery[$i]->description;
				$social_network = $cs_xmlObject->gallery[$i]->social_network;
				$use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;
				$video_code = $cs_xmlObject->gallery[$i]->video_code;
				$link_url = $cs_xmlObject->gallery[$i]->link_url;
				$image_url = cs_attachment_image_src($path, 0, 0);
				$image_url_full = cs_attachment_image_src($path, 0, 0);
				?>
				<article style="margin:0 <?php echo $cs_thumb_space; ?>px <?php echo $cs_thumb_space;?>px 0;">
					<figure>
						<img src="<?php echo $image_url; ?>" alt="<?php echo $title; ?>" data-alt="<?php echo $title; ?>">
						<span class="gallery_stack_element fa fa-stack ">
							<?php 
                                  if($use_image_as==1){
                                      echo '<i class="fa fa-circle fa-stack-2x"></i> <i class="fa fa-play fa-stack-1x fa-inverse"></i>';
                                  }elseif($use_image_as==2){
                                      echo '<i class="fa fa-circle fa-stack-2x"></i> <i class="fa fa-link fa-stack-1x fa-inverse"></i>';	
                                  }
                              ?>
                            
                           </span>
                        <figcaption>
                            <a  href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" class="fa fa-stack btnhover" target="<?php if($use_image_as==2) echo '_blank'; ?>" data-rel="<?php if($use_image_as==1)echo "prettyPhoto";  elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>" >
                                 <span class="plus-icon"></span>
                            </a>
                        </figcaption>
					</figure>
				</article>
				<?php
					}
				}
	
	}
	exit;
}

// Load more Album
add_action("wp_ajax_cs_load_more_album", "cs_load_more_album");
add_action("wp_ajax_nopriv_cs_load_more_album", "cs_load_more_album");

function cs_load_more_album() {
    global $cs_node, $post, $cs_theme_option;
    $cs_node = new stdClass;
        $offset = $_REQUEST['offset'];
        $cs_album_category = $_REQUEST['catid'];
        $page_id_all = $_REQUEST['page_id_all'];
        $cs_album_num_post = $_REQUEST['cs_blog_num_post'];
		$cs_node->cs_album_buynow = $_REQUEST['cs_album_buynow'];
		$args = array( 'posts_per_page' => "$cs_album_num_post", 'paged' => $page_id_all, 'post_type' => 'albums', 'album-category' => "$cs_album_category" );
  		$custom_query = new WP_Query($args);
		$counter_album_db = 0;
                	while ( $custom_query->have_posts()) : $custom_query->the_post();
						 $cs_album = get_post_meta($post->ID, "cs_album", true);
						 if ( $cs_album <> "" ) {
							  $cs_xmlObject = new SimpleXMLElement($cs_album);
							  $album_buy_amazon = $cs_xmlObject->album_buy_amazon;
								$album_buy_apple = $cs_xmlObject->album_buy_apple;
								$album_buy_groov = $cs_xmlObject->album_buy_groov;
								$album_buy_cloud = $cs_xmlObject->album_buy_cloud;
								$album_buy_url = $cs_xmlObject->album_buy_url;
						 }
                		$counter_album_db++;
						$width 	= 270;
                    	$height	= 270;
                     	$image_url = cs_get_post_img_src($post->ID, $width, $height);
						$categories_list = get_the_terms($post->ID,'album-category');
						$conter = 1;
						$cats = array();
						foreach($categories_list as $cat){
							$cats[0] = 'mix box';
							$cats[$conter] =$cat->slug;
							$conter++;
						}
                	?>
                    <!-- Album Post -->
                    <article <?php post_class($cats); ?>>
                                    <figure>
                                     <!-- Album Image -->
                                        <?php 
											if($image_url <> ''){echo "<img src=".$image_url." alt='' >";} else {echo '<img src="' . get_template_directory_uri() . '/images/Dummy.jpg" alt="" />';}
										?>
                                        <figcaption>
                                            <a href="<?php the_permalink(); ?>" class="btnplay"><em class="fa fa-play"></em></a>
                                            <p>
                                                <a href="<?php the_permalink(); ?>" class="track-con"><em class="fa fa-music"></em> <?php echo count($cs_xmlObject->track);?>  <?php if($cs_theme_option['trans_switcher']== "on"){ _e('Tracks','Bolster');}else{ echo $cs_theme_option['trans_track']; } ?> </a>
                                            </p>
                                        </figcaption>
                                     <!-- Album Image Close -->
                                    </figure>
                                     <!-- Album Post Description -->    
                                        <div class="desc">
                                            <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                            <h5><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Release Date','Bolster');}else{ echo $cs_theme_option['trans_release_date']; }?>: <?php echo $album__track_count->album_release_date;?></h5>
                                             <?php if ($cs_node->cs_album_buynow == 'On' && ($album_buy_amazon != '' or $album_buy_apple != '' or $album_buy_groov != '' or $album_buy_cloud != '' or $album_buy_url <> "")) {?>
                                                    <div class="buy-now">
                                                    <h5><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Buy Now','Bolster');}else{ echo $cs_theme_option['trans_buy_now']; }?></h5>
                                                         <?php 
                                                            if ($album_buy_apple <> "")
                                                                echo ' <a target="_blank" href="' . $album_buy_apple . '" ><img src="' . get_template_directory_uri() . '/images/img-bn1.png" alt="" /></a> ';
                                                            if ($album_buy_amazon <> "")
                                                                echo ' <a target="_blank" href="' . $album_buy_amazon . '" ><img src="' . get_template_directory_uri() . '/images/img-bn2.png" alt="" /></a> ';
                                                            if ($album_buy_cloud <> "")
                                                                echo ' <a target="_blank" href="' . $album_buy_cloud . '" ><img src="' . get_template_directory_uri() . '/images/img-bn3.png" alt="" /></a> ';
                                                            if ($album_buy_groov <> "")
                                                                echo ' <a target="_blank" href="' . $album_buy_groov . '" ><img src="' . get_template_directory_uri() . '/images/img-bn4.png" alt="" /></a> ';	
                                                            if ($album_buy_url <> "")
                                                                echo ' <a target="_blank" href="' . $album_buy_url . '" ><img src="' . get_template_directory_uri() . '/images/img-bn5.png" alt="" /></a> ';				
                                                         ?>
                                                    </div>
                                            <?php }?>
                                        </div>
                                   <!-- Album Post Description Close -->     
                                </article>
                    <!-- Album Post Close -->  
				<?php endwhile; 
    exit;
}
// Load more blog posts
add_action("wp_ajax_cs_load_more_blog", "cs_load_more_blog");
add_action("wp_ajax_nopriv_cs_load_more_blog", "cs_load_more_blog");

function cs_load_more_blog() {
   		global $cs_node, $post;
     	$cs_node = new stdClass;
        $offset = $_REQUEST['offset'];
        $cs_blog_category = $_REQUEST['catid'];
        $page_id_all = $_REQUEST['page_id_all'];
        $cs_blog_num_post = $_REQUEST['cs_blog_num_post'];
		$cs_node->cs_blog_view  = $_REQUEST['cs_blog_view'];
		$cs_node->cs_blog_excerpt = $_REQUEST['cs_blog_excerpt'];
		$cs_node->cs_blog_description = $_REQUEST['cs_blog_description'];
					$args = array(
                                'posts_per_page'			=> "$cs_blog_num_post",
								'paged'						=> $page_id_all,
                                'category_name'			=> "$cs_blog_category",
                                'post_status'				=> 'publish',
								'order'						=> 'DESC',
                             );
  							$custom_query = new WP_Query($args);
                       	if ( $custom_query->have_posts() <> "" ) {
							$custom_width = 270; 
							$custom_height = 270;	
							if($cs_node->cs_blog_view == 'gird_view'){
								while ($custom_query->have_posts()) : $custom_query->the_post();
							  $post_xml = get_post_meta($post->ID, "post", true);	
							  if ( $post_xml <> "" ) {
								  $cs_xmlObject = new SimpleXMLElement($post_xml);
								  $post_view = $cs_xmlObject->post_thumb_view;
								  $post_image = $cs_xmlObject->post_thumb_image;
								  $post_featured_image = $cs_xmlObject->post_featured_image_as_thumbnail;
								  $no_image = '';
								  $width= 270;
                        		  $height = 270;
								  $image_url = cs_get_post_img_src($post->ID, $width, $height);
								  $image_url_full = cs_get_post_img_src($post->ID,'' ,'');
								  if($image_url == "" and $post_view == "Single Image"){
									  $no_image = 'no-image';
								  }
							  }else{
								  $post_view = '';
								  $no_image = '';	
							  }
							  if($post_view == "Single Image" and $image_url <> ''){
								
							   ?>
                                    <article class="album">
                                        <figure>
                                            <img src="<?php echo $image_url;?>" alt="">
                                            <figcaption>
                                                <h2 class="post-title"><a href="<?php the_permalink(); ?>" class="colrhover"><?php echo substr(get_the_title(),0,55); if(strlen(get_the_title()) > 55) echo "..."; ?></a></h2>
                                                <div class="bottompanel">
                                                     <span class="post-panel float-right">
                                                      <p class="date-event"><time datetime="<?php echo date('d/m/Y',strtotime(get_the_date()));?>"><em class="fa fa-time">&nbsp;</em><?php echo date('d/m/Y',strtotime(get_the_date()));?></time></p>
                                                    <?php 
                                                    if ( comments_open() ) {  comments_popup_link( __( '<em class="fa fa-comment">&nbsp;</em> 0', 'Rocky' ) , __( '<em class="fa fa-comment">&nbsp;</em> 1', 'Rocky' ), __( '<em class="fa fa-comment">&nbsp;</em> %', 'Rocky' ) ); } ?>
                                                   
                                                    <a href="<?php the_permalink(); ?>"><em class="fa fa-heart">&nbsp;</em><?php echo $cs_like_counter;?></a></span>
                                                </div>
                                                <p><?php cs_get_the_excerpt($cs_node->cs_blog_excerpt,true);
												wp_link_pages();
												?></p>
                                                
                                            </figcaption>
                                        </figure>
                                    </article>
                                  <!-- Blog Post Close -->
                                 <?php
							  }
							  endwhile;
							} else {
							while ($custom_query->have_posts()) : $custom_query->the_post();
							  $post_xml = get_post_meta($post->ID, "post", true);	
							  if ( $post_xml <> "" ) {
								  $cs_xmlObject = new SimpleXMLElement($post_xml);
								  $post_view = $cs_xmlObject->post_thumb_view;
								  $post_image = $cs_xmlObject->post_thumb_image;
								  $post_featured_image = $cs_xmlObject->post_featured_image_as_thumbnail;
								  $post_audio_featured_image_as_thumbnail =$cs_xmlObject->post_audio_featured_image_as_thumbnail;
								  $post_video = $cs_xmlObject->post_thumb_video;
								  $post_audio = $cs_xmlObject->post_thumb_audio;
								  $post_slider = $cs_xmlObject->post_thumb_slider;
								  $post_slider_type = $cs_xmlObject->post_thumb_slider_type;
								  $no_image = '';
								  $width 	= 300;
                        		  $height	= 169;
								  $image_url = cs_get_post_img_src($post->ID, $width, $height);
								  $image_url_full = cs_get_post_img_src($post->ID,'' ,'');
								  if($image_url == "" and $post_view == "Single Image"){
									  $no_image = 'no-image';
								  }
							  }else{
								  $post_view = '';
								  $no_image = '';	
							  }	
							  $cs_like_counter = get_post_meta($post->ID, "cs_like_counter", true);
								if ( !isset($cs_like_counter) or empty($cs_like_counter) ) $cs_like_counter = 0;
							  ?>
					   <article class="post lightbox">
                    	<div class="article-wrapp">
                        	<figure>
                        	<?php 
                            if ( $post_view == "Slider" and $post_slider_type == "Flex Slider" ){
 									cs_flex_slider($width, $height,$post_slider,false);
                             }elseif($post_view == "Video" and $post_video <> ''){
								$url = parse_url($post_video);
								if($url['host'] == $_SERVER["SERVER_NAME"]){?>
								<video width="100%" height="100%" class="mejs-wmp" src="<?php echo $post_video ?>" poster="<?php echo $image_url; ?>"  controls="controls" preload="none"></video>
							<?php
								}else{
									echo wp_oembed_get($post_video, array('width'=>$custom_width));
								}
							}elseif($post_view == "Audio" and $post_audio <> ''){
 							?>
                            	<audio style="width:100%; height:100%" src="<?php echo $post_audio; ?>" type="audio/mp3" poster="<?php if($post_audio_featured_image_as_thumbnail =="on"){ echo $image_url; } ?>" controls="controls"></audio>
							 <?php
                              }elseif($post_view == "Map"){
 									$cs_node->map_lat = $cs_xmlObject->post_thumb_map_lat;
									$cs_node->map_lon = $cs_xmlObject->post_thumb_map_lon;
									$cs_node->map_zoom = $cs_xmlObject->post_thumb_map_zoom;
									$cs_node->map_address = $cs_xmlObject->post_thumb_map_address;
									$cs_node->map_controls = $cs_xmlObject->post_thumb_map_controls;
									$cs_node->map_height = 180;
									echo cs_blog_thum_map();
 							  ?>
							  <?php
                             }elseif($post_view == "Single Image" and $image_url <> ''){
                                
  									echo "<a href=".get_permalink()." >	<img src=".$image_url." alt='' ></a>";
                               } 
							 ?>
                             </figure>
							  <div class="cs-text">
                                <h2 class="post-title"><a href="<?php the_permalink(); ?>" class="colrhover"><?php the_title(); ?></a></h2>
                                <p><?php  if($cs_node->cs_blog_description == "yes" ){ cs_get_the_excerpt($cs_node->cs_blog_excerpt,true); }
								wp_link_pages();
								?></p>
                                <div class="bottompanel">
                                     <span class="post-panel float-right">
                                      <p class="date-event"><time datetime="<?php echo date('d/m/Y',strtotime(get_the_date()));?>"><em class="fa fa-time">&nbsp;</em><?php echo get_the_date();?></time></p>
                                    <?php 
									if ( comments_open() ) {  comments_popup_link( __( '<em class="fa fa-comment">&nbsp;</em> 0', 'Rocky' ) , __( '<em class="fa fa-comment">&nbsp;</em> 1', 'Rocky' ), __( '<em class="fa fa-comment">&nbsp;</em> %', 'Rocky' ) ); } ?>
                                   
                                    <a href="<?php the_permalink(); ?>"><em class="fa fa-heart">&nbsp;</em><?php echo $cs_like_counter;?></a></span>
                                </div>
                             </div>
                             
                          </div>
                      </article>
		<?php 
         endwhile; }} 
    exit;
}

// Load more artists
add_action("wp_ajax_cs_load_more_artists", "cs_load_more_artists");
add_action("wp_ajax_nopriv_cs_load_more_artists", "cs_load_more_artists");

function cs_load_more_artists() {
    global $cs_node, $post, $cs_theme_option;
    $cs_node = new stdClass;
	
    if (isset($_REQUEST['blog_view'])) {
        $blog_view = $_REQUEST['blog_view'];
    }
	if(!isset($blog_view) && empty($blog_view)){
		$blog_view = 'list_view';
	}
         $offset = $_REQUEST['offset'];
        $cs_artist_category = $_REQUEST['catid'];
        $page_id_all = $_REQUEST['page_id_all'];
        $cs_blog_num_post = $_REQUEST['cs_blog_num_post'];
		//$cs_blog_num_post = 13;
		$args = array(
					'showposts'			=> $cs_blog_num_post,
					'paged'						=> $page_id_all,
					'post_type'					=> 'artists',
					'artists-category'			=> "$cs_artist_category",
					'post_status'				=> 'publish',
					'order'						=> 'DESC',
				 );
		wp_reset_query();
  		$custom_query = new WP_Query($args);
		$count_post = $custom_query->post_count;
		if ($blog_view == "gird_view") {
                       	if ( $custom_query->have_posts() <> "" ) {
							while ( $custom_query->have_posts() ): $custom_query->the_post();
									$img_class =  array();
									$cats = array();
									$image_url = cs_get_post_img_src($post->ID, 0, 0);
									if($image_url == ''){ $img_class[]='no-image';}
									$categories_list = get_the_terms($post->ID,'artists-category');
									$conter = 1;
									foreach($categories_list as $cat){
										$cats[0] = 'mix';
										$cats[$conter] =$cat->slug;
										$conter++;
									}
                                ?>
                                <article <?php post_class($cats); ?>>
                                    <figure>
                                     <!-- Album Image -->
                                        <img src="<?php echo $image_url;?>" alt="">
                                     <!-- Album Image Close -->
                                    </figure>
                                     <!-- Album Post Description -->    
                                        <div class="desc">
                                        	<h2 class="post-title"><a href="<?php the_permalink();?>" ><?php the_title();?></a></h2>
                                            
                                            <div class="tags-area">
                                             <?php 
												$before_cat = '';
												$categories_list = get_the_term_list ( get_the_id(), 'artists-category', $before_cat, ' / ', '' );
												if ( $categories_list ){ printf( __( '%1$s', 'Bolster' ),$categories_list ); }
											?> 
                                            <a class="btnlikes"><em class="fa fa-heart"></em>&nbsp;
                                            <?php
												$cs_like_counter = get_post_meta(get_the_id(), "cs_like_counter", true);
												if ( !isset($cs_like_counter) or empty($cs_like_counter) ) $cs_like_counter = 0;
												echo $cs_like_counter;
											?>
                                            </a>
                                            </div>
                                        </div>
                                   <!-- Album Post Description Close -->     
                                </article>
                                <?php 
								 endwhile; } ?>
                    </div>
                    </div>
                    <?php } else {?>
                        	<?php 
								if ( $custom_query->have_posts() <> "" ) {
								while ( $custom_query->have_posts() ): $custom_query->the_post();
									$img_class =  array();
									$image_url = cs_get_post_img_src($post->ID, 270, 270);
									if($image_url == ''){ $img_class[]='no-image';}
							
							?>
                            <article <?php post_class($img_class);?>>
                                        <figure>
                                            <img src="<?php echo $image_url;?>" alt="">
                                            <figcaption>
                                            	<h2 class="post-title"><a href="<?php the_permalink();?>" class="colrhover"><?php the_title();?></a></h2>
                                                <div class="bottompanel">
                                                	<?php 
														$before_cat = '<h5>';
														$categories_list = get_the_term_list ( get_the_id(), 'artists-category', $before_cat, ' / ', '</h5>' );
														if ( $categories_list ){ printf( __( '%1$s', 'Bolster' ),$categories_list ); }
													?> 
                                                </div>
                                                <p><?php  cs_get_the_excerpt('89',true);?></p>
                                                <?php 
											$args = array(
														'post_type' => 'albums',
														'meta_key' => 'cs_album_artists',
														'meta_query' => array(
															array(
																'key' => 'cs_album_artists',
																'value' => $post->post_name,
																'compare' => '=',
															)),
														'orderby' => 'ID',
														'order' => 'ASC',
													);
												$myposts = get_posts($args);
												$total_count = count($myposts);
												if ( !isset($total_count) or empty($total_count) ) $total_count = 0;
                                        ?>
                                                <p class="artist-albums"><em class="fa fa-music">&nbsp;</em> <?php echo $total_count;?> <?php if($cs_theme_option['trans_switcher']== "on"){ _e('Albums','Bolster');}else{ echo $cs_theme_option['trans_albums']; } ?></p>
                                            </figcaption>
                                        </figure>
                                    </article>
                            
    <?php endwhile; } }
    exit;
}

// Load more Events
add_action("wp_ajax_cs_load_more_posts", "cs_load_more_posts");
add_action("wp_ajax_nopriv_cs_load_more_posts", "cs_load_more_posts");

function cs_load_more_posts() {
    global $cs_node, $post, $cs_theme_option;
    $cs_node = new stdClass;
    if (isset($_REQUEST['blog_view'])) {
        $blog_view = $_REQUEST['blog_view'];
    }
    if ($blog_view == "List View") {
        $offset = $_REQUEST['offset'];
        $filter_category = $_REQUEST['catid'];
		$event_type = $_REQUEST['event_type'];
        $page_id_all = $_REQUEST['page_id_all'];
        $cs_blog_num_post = $_REQUEST['cs_blog_num_post'];
		if ( $event_type == "Upcoming Events") {
        $args = array(
                                'posts_per_page'			=> "$cs_blog_num_post",
								'paged'						=> $page_id_all,
                                'post_type'					=> 'events',
                                'event-category'			=> "$filter_category",
                                'post_status'				=> 'publish',
                                'meta_key'					=> 'cs_event_from_date',
                                'meta_value'				=> date('Y-m-d'),
                                'meta_compare'				=> ">=",
                                'orderby'					=> 'meta_value',
                                'order'						=> 'ASC',
                             );
						}else if ( $event_type == "All Events" ) {
                            $args = array(
                                'posts_per_page'			=> "$cs_blog_num_post",
                                'paged'						=> $page_id_all,
                                'post_type'					=> 'events',
                                'event-category'			=> "$filter_category",
								'meta_key'					=> 'cs_event_from_date',
                                'meta_value'				=> '',
                                'post_status'				=> 'publish',
 								'orderby'					=> 'meta_value',
                                'order'						=> 'DESC',
                            );
                        }
                        else {
                            $args = array(
                                'posts_per_page'			=> "$cs_blog_num_post",
                                'paged'						=> $page_id_all,
                                'post_type'					=> 'events',
                                'event-category'			=> "$filter_category",
                                'post_status'				=> 'publish',
                                'meta_key'					=> 'cs_event_from_date',
                                'meta_value'				=> date('Y-m-d'),
                                'meta_compare'				=> $meta_compare,
                                'orderby'					=> 'meta_value',
                                'order'						=> 'ASC',
                             );
                        }
						$count_first = 0;
						$map_list = '';
        $custom_query = new WP_Query($args);
        if ($custom_query->have_posts()):
            while ($custom_query->have_posts()) : $custom_query->the_post();
                $cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
                                if ( $cs_event_meta <> "" ) {
                                	$cs_event_meta = new SimpleXMLElement($cs_event_meta);
 									if($cs_event_meta->event_address <> ''){
 										$address_map = get_the_title("$cs_event_meta->event_address");	
									}else{
										$address_map = '';
									}
                                }
								$cs_event_loc = get_post_meta($cs_event_meta->event_address, "cs_event_loc_meta", true);
								if ( $cs_event_loc <> "" ) {
									$cs_xmlObject = new SimpleXMLElement($cs_event_loc);
									$loc_address = $cs_xmlObject->loc_address;
									$event_loc_lat = $cs_xmlObject->event_loc_lat;
									$event_loc_long = $cs_xmlObject->event_loc_long;
									$event_loc_zoom = $cs_xmlObject->event_loc_zoom;
									$loc_city = $cs_xmlObject->loc_city;
									$loc_postcode = $cs_xmlObject->loc_postcode;
									$loc_country = $cs_xmlObject->loc_country;
									if($count_first == '0' && $event_loc_lat <> '' && $event_loc_long <> ''){
										$event_loc_lat_first = $cs_xmlObject->event_loc_lat;
										$event_loc_long_first = $cs_xmlObject->event_loc_long;
										$count_first++;
										$map_list .= "{pos:{lat:".$event_loc_lat.",lng:".$event_loc_long."},address:'".addslashes($loc_address)."',title:'".$address_map."',type:'".$address_map."'},";
									}
									
 								}
								else {
									$loc_address = '';
									$event_loc_lat = '';
									$event_loc_long = '';
									$event_loc_zoom = '';
							 	}
								
											
   								$event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
                
?>
                    <article>
                        <div class="date-box"><big><?php echo date('d',strtotime($event_from_date));  ?></big><small><?php echo date('F',strtotime($event_from_date));  ?></small></div>
                        <div class="text">
                            <h2 class="post-title"><a href="<?php the_permalink();?>" class="colrhover"><?php the_title(); ?></a></h2>
                            <p class="panel"><time><?php echo date('M d, Y',strtotime($event_from_date));  ?></time><?php if ( $cs_event_loc <> "" ) {?><a><em class="fa fa-map-marker"></em><?php echo $loc_address.' '.$loc_city.' '.$loc_country;?></a><?php }?></p>        
                        </div>
                    </article>
                    <?php

            endwhile;
        endif;
    }
    exit;
}
//Add classes according to diffrent view for blog post type
function cs_blog_classes($blog_view =""){
 	if($blog_view == 'blog-large'){ 
		echo 'postlist blog';
	}elseif($blog_view == 'blog-medium'){ 
		echo 'postlist blog';
	}
	else{ 
		echo 'blog'; 
	}
}
// rating function

// custom function start

/*	return current post type and page type */

function cs_post_type($current_id){
	$post_type = get_post_type($current_id);
	if($post_type == "gigs"){
		$post_type = "cs_event_meta";
	}elseif($post_type == "page"){
		$post_type = "cs_page_builder";
	}
	return $post_type;
}

// Dropcap shortchode with first letter in caps
if ( ! function_exists( 'cs_dropcap_page' ) ) {
	function cs_dropcap_page(){
		global $cs_node;
		$html = '';
			$html .= '<div class="dropcap">';
				$html .= $cs_node->dropcap_content;
			$html .= '</div>';
		return $html;
	}
}

// block quote short code
if ( ! function_exists( 'cs_quote_page' ) ) {
	function cs_quote_page(){
		global $cs_node;
 			$html ='<blockquote class="blockquote" style=" text-align:' .$cs_node->quote_align. '; color:' . $cs_node->quote_text_color . '">' . $cs_node->quote_content . '<span class="fa-stack fa-lg colr"> <em class="fa fa-circle fa-stack-2x"></em> <em class="fa fa-quote-left fa-stack-1x fa-inverse"></em></span></blockquote>';
 		return $html;
	}
}

// video short code
if ( ! function_exists( 'cs_video_page' ) ) {
	function cs_video_page(){
		global $cs_node;
		$html = '';
		cs_enqueue_gallery_style_script();
		$href = '';
		$html = '';
		$data_rel = 'data-rel="prettyPhoto[gallery1]"';
		
		$html .= '<figure class="widget-box viewme">';
		$html .= '<a href="'.$cs_node->video_url.'" title="'.$cs_node->video_name.'" '.$data_rel.'>';
		$html .= '<em class="fa fa-play"  style="float:left; width:'.$cs_node->video_width.'px; height:'.$cs_node->video_height.'px"></em>';
			//$html .= '<img src="http://irfan/evilution/wp-content/uploads/2013/11/img-f-gigs.jpg" style="float:left; width:'.$cs_node->video_width.'px; height:'.$cs_node->video_height.'px" alt="" />';
		$html .= '</a>';
			//$html .= wp_oembed_get( $cs_node->video_url, array('width'=>$cs_node->video_width, 'height'=>$cs_node->video_height) );
		//$html .= '<figcaption>'.$cs_node->video_name.'</figcaption>';
		$html .= '</figure>';
		return $html;
	}
}
// map shortcode with various options
if ( ! function_exists( 'cs_map_page' ) ) {
	function cs_map_page(){
		global $cs_node, $counter_node;
		if ( !isset($cs_node->map_lat) or $cs_node->map_lat == "" ) { $cs_node->map_lat = 0; }
		if ( !isset($cs_node->map_lon) or $cs_node->map_lon == "" ) { $cs_node->map_lon = 0; }
		if ( !isset($cs_node->map_zoom) or $cs_node->map_zoom == "" ) { $cs_node->map_zoom = 11; }
		if ( !isset($cs_node->map_info_width) or $cs_node->map_info_width == "" ) { $cs_node->map_info_width = 200; }
		if ( !isset($cs_node->map_info_height) or $cs_node->map_info_height == "" ) { $cs_node->map_info_height = 100; }
		if ( !isset($cs_node->map_show_marker) or $cs_node->map_show_marker == "" ) { $cs_node->map_show_marker = 'true'; }
		if ( !isset($cs_node->map_controls) or $cs_node->map_controls == "" ) { $cs_node->map_controls = 'false'; }
		if ( !isset($cs_node->map_scrollwheel) or $cs_node->map_scrollwheel == "" ) { $cs_node->map_scrollwheel = 'true'; }
		if ( !isset($cs_node->map_draggable) or $cs_node->map_draggable == "" )  { $cs_node->map_draggable = 'true'; }
		if ( !isset($cs_node->map_type) or $cs_node->map_type == "" ) { $cs_node->map_type = 'ROADMAP'; }
		if ( !isset($cs_node->map_info)) { $cs_node->map_info = ''; }
		if( !isset($cs_node->map_marker_icon)){ $cs_node->map_marker_icon = ''; }
		if( !isset($cs_node->map_title)){ $cs_node->map_title ='';}
		if( !isset($cs_node->map_element_size)){ $cs_node->map_element_size ='default';}
		if( !isset($cs_node->map_height)){ $cs_node->map_height ='100';}
		if( !isset($cs_node->map_width)){ $cs_node->map_width ='200';}
		$info_content= '"info_content"';	 
		$style = 'style="height:'.$cs_node->map_info_height.'px"';
		$map_show_marker = '';
		if ( $cs_node->map_show_marker == "true" ) { 
			$map_show_marker = " var marker = new google.maps.Marker({
						position: myLatlng,
						map: map,
						title: '',
						icon: '".$cs_node->map_marker_icon."',
						shadow:''
					});
			";
		}
	
		//wp_enqueue_script('googleapis', 'https://maps.googleapis.com/maps/api/js?sensor=true', '', '', true);
		$html = '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>';
		$html .= '<div class="element_size_'.$cs_node->map_element_size.' contactus-map">';
			if($cs_node->map_title <> ""){
			$html .= '<h1 class="color heading-color">'.$cs_node->map_title.'</h1>';
			}
			$html .= '<div class="mapcode iframe mapsection gmapwrapp" id="map_canvas'.$counter_node.'" style=" white-space:normal; height:'.$cs_node->map_height.'%; width:'.$cs_node->map_width.'px;"> </div>';
		$html .= '</div>';
		$html .= "<script type='text/javascript'>
					function initialize() {
						var myLatlng = new google.maps.LatLng(".$cs_node->map_lat.", ".$cs_node->map_lon.");
						var mapOptions = {
							zoom: ".$cs_node->map_zoom.",
							scrollwheel: ".$cs_node->map_scrollwheel.",
							draggable: ".$cs_node->map_draggable.",
							center: myLatlng,
							mapTypeId: google.maps.MapTypeId.".$cs_node->map_type." ,
							disableDefaultUI: ".$cs_node->map_controls.",
						}
						var map = new google.maps.Map(document.getElementById('map_canvas".$counter_node."'), mapOptions);
						 var infoWindowContent = '<div class=".$info_content." ".$style.">".$cs_node->map_info."</div>';
						var infowindow = new google.maps.InfoWindow({
							content: infoWindowContent,
							maxWidth: ".$cs_node->map_info_width.",
							maxHeight:".$cs_node->map_info_height.",
							
						});
						".$map_show_marker."
					//	google.maps.event.addListener(marker, 'click', function() {
	
							if (infowindow.content != ''){
							  infowindow.open(map, marker);
							 //  map.panBy(1,-60);
							   google.maps.event.addListener(marker, 'click', function(event) {
								infowindow.open(map, marker);
	
							   });
							}
					//	});
					}
				
				google.maps.event.addDomListener(window, 'load', initialize);
				</script>";
		return $html;
	}
}

// map shortcode with various options
if ( ! function_exists( 'cs_blog_thum_map' ) ) {
	function cs_blog_thum_map(){
		global $cs_node, $counter_node;
		if ( !isset($cs_node->map_lat) or $cs_node->map_lat == "" ) { $cs_node->map_lat = 0; }
		if ( !isset($cs_node->map_lon) or $cs_node->map_lon == "" ) { $cs_node->map_lon = 0; }
		if ( !isset($cs_node->map_zoom) or $cs_node->map_zoom == "" ) { $cs_node->map_zoom = 11; }
		if ( !isset($cs_node->map_info_width) or $cs_node->map_info_width == "" ) { $cs_node->map_info_width = 200; }
		if ( !isset($cs_node->map_info_height) or $cs_node->map_info_height == "" ) { $cs_node->map_info_height = 100; }
		if ( !isset($cs_node->map_show_marker) or $cs_node->map_show_marker == "" ) { $cs_node->map_show_marker = 'true'; }
		if ( !isset($cs_node->map_controls) or $cs_node->map_controls == "" ) { $cs_node->map_controls = 'false'; }
		if ( !isset($cs_node->map_scrollwheel) or $cs_node->map_scrollwheel == "" ) { $cs_node->map_scrollwheel = 'true'; }
		if ( !isset($cs_node->map_draggable) or $cs_node->map_draggable == "" )  { $cs_node->map_draggable = 'true'; }
		if ( !isset($cs_node->map_type) or $cs_node->map_type == "" ) { $cs_node->map_type = 'ROADMAP'; }
		if ( !isset($cs_node->map_info)) { $cs_node->map_info = ''; }
		if( !isset($cs_node->map_marker_icon)){ $cs_node->map_marker_icon = ''; }
		if( !isset($cs_node->map_title)){ $cs_node->map_title ='';}
		if( !isset($cs_node->map_element_size)){ $cs_node->map_element_size ='default';}
		if( !isset($cs_node->map_height)){ $cs_node->map_height ='180';}
	 
		$map_show_marker = '';
		if ( $cs_node->map_show_marker == "true" ) { 
			$map_show_marker = " var marker = new google.maps.Marker({
						position: myLatlng,
						map: map,
						title: '',
						icon: '".$cs_node->map_marker_icon."',
						shadow:''
					});
			";
		}
	
		//wp_enqueue_script('googleapis', 'https://maps.googleapis.com/maps/api/js?sensor=true', '', '', true);
		$html = '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>';
		$html .= '<div class="element_size_'.$cs_node->map_element_size.'" style="width:270px;">';
			$html .= '<div class="mapcode iframe mapsection gmapwrapp" id="map_canvas'.$counter_node.'" style="height:'.$cs_node->map_height.'px;"> </div>';
		$html .= '</div>';
		$html .= "<script type='text/javascript'>
					function initialize() {
						var myLatlng = new google.maps.LatLng(".$cs_node->map_lat.", ".$cs_node->map_lon.");
						var mapOptions = {
							zoom: ".$cs_node->map_zoom.",
							scrollwheel: ".$cs_node->map_scrollwheel.",
							draggable: ".$cs_node->map_draggable.",
							center: myLatlng,
							mapTypeId: google.maps.MapTypeId.".$cs_node->map_type." ,
							disableDefaultUI: ".$cs_node->map_controls.",
						}
						var map = new google.maps.Map(document.getElementById('map_canvas".$counter_node."'), mapOptions);
						var infowindow = new google.maps.InfoWindow({
							content: '".$cs_node->map_info."',
							maxWidth: ".$cs_node->map_info_width.",
							maxHeight:".$cs_node->map_info_height.",
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
		return $html;
	}
}

// image short code
if ( ! function_exists( 'cs_image_page' ) ) {
	function cs_image_page(){
		global $cs_node;
		cs_enqueue_gallery_style_script();
		$href = '';
		$html = '';
		if ($cs_node->image_lightbox == "yes") $href = $cs_node->image_source;
		if($cs_node->image_lightbox =="yes") $data_rel = 'data-rel="prettyPhoto[gallery1]"';
			else $data_rel = 'target="_blank"';
		
		if ( $cs_node->image_element_size <> "" ) { $html .= '<div class="column-wrapp-box"><div class="detail_text_wrapp col-counter">'; }
			$html .= '<figure class="lightbox-single image-shortcode" style="float:left; width:'.$cs_node->image_width.'px; height:'.$cs_node->image_height.'px">';
				if($cs_node->image_lightbox =="yes"){
				$html .= '<a href="'.$href.'" title="'.$cs_node->image_caption.'" '.$data_rel.'>';
				}
					$html .= '<img src="'.$cs_node->image_source.'" style="float:left; width:'.$cs_node->image_width.'px; height:'.$cs_node->image_height.'px" alt="" />';
				if($cs_node->image_lightbox =="yes"){
				$html .= '</a>';
				}
				if($cs_node->image_caption <> ''){
					$html .= '<figcaption class="webkit">';
						$html .= '<h2>'.$cs_node->image_caption.'</h2>';
					$html .= '</figcaption>';
				}
			$html .= '</figure>';
		if ( $cs_node->image_element_size <> "" ) { $html .= '</div></div>'; }
		return $html;
	}
}
// Message Box with various options and multiple styles
if ( ! function_exists( 'cs_message_box_page' ) ) {
	function cs_message_box_page(){
		global $cs_node;
		$html = '<div class="column-wrapp-box"><div class="detail_text_wrapp col-counter">';
		$html .= '<div class="messagebox alert alert-info" style="background:'.$cs_node->mb_bg_color.'">
				<button data-dismiss="alert" class="close" type="button">&#88;</button>';
		$html .= '<h4>'.$cs_node->mb_title.'</h4>';
		$html .= $cs_node->mb_content;
		$html .= '</div>';
		$html .= '</div></div>';
		echo $html;
	}
}
// Divider shortcode use for sepratiion of page elements
if ( ! function_exists( 'cs_divider_page' ) ) { 
	function cs_divider_page(){
		global $cs_node;
		$html = '';
		$html .= '<div style="margin-top:'.$cs_node->divider_mrg_top.'px;margin-bottom:'.$cs_node->divider_mrg_bottom.'px; " class="' . $cs_node->divider_style . '">';
		$html .= '</div>';
		$html .= '';
		return $html . '';
	}
}

// Column shortcode with 2/3/4 column option even you can use shortcode in column shortcode
if ( ! function_exists( 'cs_column_page' ) ) {
	function cs_column_page(){
		global $cs_node;
		$html = '<div class="column-wrapp-box heading-area"><div class="detail_text_wrapp col-counter"><div class="shortgrid">';
			$html .= do_shortcode($cs_node->column_text);
		$html .= '</div></div></div>';
		echo $html;
	}
}

// tabs shortcode
if ( ! function_exists( 'cs_tabs_page' ) ) {
	function cs_tabs_page(){
		global $cs_node, $tab_counter;
		$html = '';
	
		if ( $cs_node->tabs_element_size == "" ) {
			$html .= '<ul class="nav nav-tabs" id="myTab">';
			$cs_xmlObject = simplexml_load_string($cs_node->tabs_content);
			$tabs_count = 0;
			foreach ($cs_xmlObject as $val) {
				if (!isset($val["icon"])){ $val["icon"] = '';}
				if (!isset($val["title"])){ $val["title"] = '';}
				$tabs_count++;
				if ( $val["active"] == "yes")
					$tab_active = " active";
				else
					$tab_active = "";
				$html .= '<li class="' . $tab_active . '"><a data-toggle="tab" href="#tab' . $tab_counter . $tabs_count . '"><i class="'.$val["icon"].'"></i> ' . $val["title"] . '</a></li>';
			}
			$html .= '</ul>';
			$html .= '<div class="tab-content">';
			$tabs_count = 0;
			foreach ($cs_xmlObject as $val) {
				$tabs_count++;
				if ( $val["active"] == "yes")
					$tab_active = " active";
				else
					$tab_active = "";
				$html .= '<div class="tab-pane fade in ' . $tab_active . '" id="tab' . $tab_counter . $tabs_count . '">' . $val . '</div>';
			}
			$html .= '</div>';
			$html = '<div class="tabs column-wrapp-box'.$cs_node->tabs_style.'">' . $html . '</div>';
		}
		else {
			$aaa = array();
			$tab_counter++;
			$tabs_count = 0;
				$html = '<ul class="nav nav-tabs" id="myTab">';
				foreach ( $cs_node->tab as $cs_node ){
					$aaa["$cs_node->tab_title"] = $cs_node->tab_text;
					$tabs_count++;
					if ($cs_node->tab_active == "yes")
						$tab_active = " active";
					else
						$tab_active = "";
					$html .= '<li class="' . $tab_active . '"><a data-toggle="tab" href="#tab' . $tab_counter . $tabs_count . '"><i class="'.$cs_node->tab_title_icon.'"></i>' . $cs_node->tab_title . '</a></li>';
				}
				$html .= '</ul>';
				$html .= '<div class="tab-content">';
				$tabs_count = 0;
				foreach( $aaa as $keys=>$vals ){
					$tabs_count++;
					if ($tabs_count == 1)
						$tab_active = " active";
					else
						$tab_active = "";
					$html .= '<div class="tab-pane fade in ' . $tab_active . '" id="tab' . $tab_counter . $tabs_count . '">' . $vals . '</div>';
				}
				$html .= '</div>';
			$html = '<div class="tabs">' . $html . '</div>';
		}
		return do_shortcode($html);
	}
}
// Accrodian shortcode
if ( ! function_exists( 'cs_accordions_page' ) ) {
	function cs_accordions_page(){
		global $cs_node, $acc_counter;
		$acc_counter = rand(5, 15);
		$acc_counter++;
		$accordion_count = 0;
		$html = "";
		if ( $cs_node->accordion_element_size == "" ) {
			$html .= '<div class="accordion ' . $cs_node->type . '" id="accordion-' . $acc_counter . '">';
			$cs_xmlObject = new SimpleXMLElement( $cs_node->accordion_content );
			foreach ($cs_xmlObject as $cs_node) {
			if (!isset($cs_node["icon"])){ $cs_node["icon"] = '';}
			if (!isset($cs_node["title"])){ $cs_node["title"] = '';}
				$accordion_count++;
				if ($accordion_count == 1 && $cs_node["active"] == "yes")
						$class_active = " active";
					else
						$class_active = "";
						
				if ( $cs_node["active"] == "yes"){
					
					$accordion_active = " in";
					 
				}else{
					$accordion_active = "";
					
				}
				$html .= '<div class="accordion-group ">';
				$html .= '<div class="accordion-heading">';
				$html .= '<a class="accordion-toggle backcolorhover '.$class_active .'" data-toggle="collapse" data-parent="#accordion-' . $acc_counter . '" href="#accordion-' . str_replace(" ", "", $accordion_count . $acc_counter) . '"><i class="'.$cs_node["icon"].'"></i> ' . $cs_node["title"] . '</a>';
				$html .= '</div>';
				$html .= '<div id="accordion-' . str_replace(" ", "", $accordion_count . $acc_counter) . '" class="accordion-body collapse ' . $accordion_active . '">';
				$html .= '<div class="accordion-inner">' . $cs_node . '</div>';
				$html .= '</div>';
				$html .= '</div>';
			}
			$html .= '</div>';
		}
		else {
			$html = '<div class="accordion" id="accordion-' . $acc_counter . '">';
				foreach ( $cs_node->accordion as $cs_node ){
					$accordion_count++;
					if ($accordion_count == 1)
						$accordion_active = " in";
					else
						$accordion_active = "";
					$html .= '<div class="accordion-group">';
					$html .= '<div class="accordion-heading">';
					$html .= '<a class="accordion-toggle backcolorhover" data-toggle="collapse" data-parent="#accordion-' . $acc_counter . '" href="#accordion-' . str_replace(" ", "", $accordion_count . $acc_counter) . '"><i class="'.$cs_node->accordion_title_icon.'"></i> ' . $cs_node->accordion_title . '</a>';
					$html .= '</div>';
					$html .= '<div id="accordion-' . str_replace(" ", "", $accordion_count . $acc_counter) . '" class="accordion-body collapse ' . $accordion_active . '">';
					$html .= '<div class="accordion-inner">' . $cs_node->accordion_text . '</div>';
					$html .= '</div>';
					$html .= '</div>';
				}
			$html .= '</div>';
			echo do_shortcode($html);	
		}
		return do_shortcode($html);
	}
}
  
if ( ! function_exists( 'cs_contact_submit' ) ) {
	function cs_contact_submit(){
		foreach ($_REQUEST as $keys=>$values) {
			$$keys = $values;
		}
		$subject = "(" . $bloginfo . ") Contact Form Received";
		$message = '
			<table width="100%" border="1">
			  <tr><td width="100"><strong>Name:</strong></td><td>'.$contact_name.'</td></tr>
			  <tr><td><strong>Email:</strong></td><td>'.$contact_email.'</td></tr>
			  <tr><td><strong>Contact No.</strong></td><td>'.$contact_no.'</td></tr>
			  <tr><td><strong>Message:</strong></td><td>'.$contact_msg.'</td></tr>
			  <tr><td><strong>IP Address:</strong></td><td>'.$_SERVER["REMOTE_ADDR"].'</td></tr>
			</table>
			';
		$headers = "From: " . $contact_name . "\r\n";
		$headers .= "Reply-To: " . $contact_email . "\r\n";
		$headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
		$headers .= "MIME-Version: 1.0" . "\r\n";
		$attachments = '';
		wp_mail( $cs_contact_email, $subject, $message, $headers, $attachments );
		//mail($cs_contact_email, $subject, $message, $headers);
		echo $cs_contact_succ_msg;
		die();
	}
 }
add_action('wp_ajax_contact_submit', 'contact_submit');
add_action('wp_ajax_contact_nopriv_submit', 'contact_submit');
// Corlor Switcher for front end
function cs_color_switcher(){
	global $cs_theme_option;
 	if ( $cs_theme_option['color_switcher'] == "on" ) {

		if ( empty($_POST['patter_or_bg']) ){
			$_POST['patter_or_bg'] = '';
		}
		
		if ( empty($_POST['reset_color_txt']) ) { 
			$_POST['reset_color_txt'] = "";
		}
		else if ( $_POST['reset_color_txt'] == "1" ) {
			$_POST['layout_option'] = "";
			$_POST['custome_pattern'] = "";
			$_POST['bg_img'] = "";
			$_POST['style_sheet'] = "";
			$_POST['heading_color'] = "";
 		}
		
		if ( $_POST['patter_or_bg'] == 0 ){
			$_SESSION['sess_bg_img'] = '';
		}
		else if ( $_POST['patter_or_bg'] == 1 ){
			$_SESSION['sess_custome_pattern'] = '';
		}
		
		if ( isset($_POST['layout_option']) ) {
			$_SESSION['sess_layout_option'] = $_POST['layout_option'];
		}
		if ( isset($_POST['style_sheet']) ) {
			$_SESSION['sess_style_sheet'] = $_POST['style_sheet'];
		}
		if ( isset($_POST['heading_color']) ) {
			$_SESSION['sess_heading_color'] = $_POST['heading_color'];
		}
		if ( isset($_POST['custome_pattern']) ) {
			$_SESSION['sess_custome_pattern'] = $_POST['custome_pattern'];
		}
		if ( isset($_POST['bg_img']) ) {
			$_SESSION['sess_bg_img'] = $_POST['bg_img'];
		}

		if ( empty($_SESSION['sess_layout_option']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['sess_layout_option'] = "wrapper"; }
		if ( empty($_SESSION['sess_header_styles']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['sess_header_styles'] = ""; }
		if ( empty($_SESSION['sess_style_sheet']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['sess_style_sheet'] = "#242423"; }
		if ( empty($_SESSION['sess_heading_color']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['sess_heading_color'] = "#242423"; }
		if ( empty($_SESSION['sess_custome_pattern']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['sess_custome_pattern'] = ""; }
		if ( empty($_SESSION['sess_bg_img']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['sess_bg_img'] = ""; }

		$theme_path = get_template_directory_uri();	
		wp_enqueue_style( 'wp-color-picker' );
		
		wp_enqueue_script('iris',admin_url( 'js/iris.min.js' ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ),false, 1  );
		wp_enqueue_script('wp-color-picker',admin_url( 'js/color-picker.min.js' ),array( 'iris' ),false,1);
		$colorpicker_l10n = array(
			'clear' => 'Clear',
			'defaultString' => 'Default',
			'pick' => 'Select Color'
		);
		wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', $colorpicker_l10n );
?>

		<script type="text/javascript">
        jQuery(document) .ready(function($){
   			jQuery("#togglebutton").click(function(){
				jQuery("#sidebarmain").trigger('click')
				jQuery(this).toggleClass('btnclose');
				jQuery("#sidebarmain") .toggleClass('sidebarmain');
				return false; 
		   });
           $("#pattstyles li label") .click(function(){
				$("#backgroundimages li label") .removeClass("active");	
				$("#patter_or_bg") .attr("value","0");
      			var ah = $(this) .find('input[type="radio"]') .val();
      			$('body') .css({"background":"url(<?php echo $theme_path?>/images/pattern/pattern"+ah+".png)"});
      });
      $("#backgroundimages li label") .click(function(){
		  $("#patter_or_bg") .attr("value","1");
		$("#pattstyles li label") .removeClass("active");	
      var ah = $(this) .find('input[type="radio"]') .val();
      $('body') .css({"background":"url(<?php echo $theme_path?>/images/background/bg"+ah+".png) no-repeat center center / cover fixed"});
     });
   $("#backgroundimages li label,#pattstyles li label") .click(function(){
    var classname=$(".layoutoption li:first-child label") .hasClass("active"); 
    if(classname) {
    alert("Please select Boxed View")
    return false; 
    }else {
      $(this) .parents(".selectradio") .find("label") .removeClass("active");
      $(this) .addClass("active"); 

     }
    });
                $(".layoutoption li label") .click(function(){
					
    var th = $(this).find('input') .val();
    $("#wrappermain-pix") .attr('class','');
    $('#wrappermain-pix') .addClass(th);
                $(this) .parents(".selectradio") .find("label") .removeClass("active");
                $(this) .addClass("active");
     		jQuery(".top_strip").trigger('resize');
				para();
	 			parabg ();
                });
    
    $(".accordion-sidepanel .innertext") .hide();
    $(".accordion-sidepanel header") .click(function(){
     if ($(this) .next() .is(":visible")){
       $(".accordion-sidepanel .innertext") .slideUp(300);
       $(".accordion-sidepanel header") .removeClass("active");
       return false;
      }
    $(".accordion-sidepanel .innertext") .slideUp(300);
    $(".accordion-sidepanel header") .removeClass("active");
    $(this) .addClass("active");
    $(this).next() .slideDown(300);
     
    
    });
    
        });

	jQuery(document).ready(function($){
		$(".colorpicker-main").click(function(){
		$(this).find('.wp-color-result').trigger('click'); 
    });
	var cf = ".colr,#wp-calendar tbody td a,.for_o_for .navigation ul li a:hover, .alumbpanwrapp a.btnalbumpan:hover, #signin h5, .text a:hover, .blockquote .icon-stack em.icon-circle,.blog-tags a:hover,.album-list figure figcaption .tracklist:hover li a,.album-list figure figcaption .tracklist:hover li p,.widget-box:hover figcaption,.contactform p span input:focus ~ em ,.title-song li,.accordion-heading .accordion-toggle.active,.accordion-heading .accordion-toggle:hover,.accordion-inner:before, .header-1 .alumbpanwrapp a.btnalbumpan.active,.concert-list article:hover .date-box, .gallery_grid_view article:hover .gallery_stack_element .fa-stack-2x,.jp-playlist li:hover a, .jp-playlist li.jp-playlist-current a "; 
	var bc = "#header, .events-photo article figure,.events-photo li figure, #wrappermain-pix .woocommerce .button:hover ,.widget_tag_cloud a:hover, p.form-submit input#submit-comment,.bgcolr, .password_protected form input[type='submit'], #signin li button.button, .flex-control-paging li a:hover, .flex-control-paging li a.flex-active, .blog-gallery figure figcaption a:hover, .detail_text h6 strong ,.widget_categories > ul > li:hover,.form-submit button,#player .jp-playlist:before ,.album-footer .rating,.album .album-footer a.album-counter,.main-progress .jp-progress .jp-play-bar,.jp-volume-bar-value,#header.header-light .playersocial a.btnalbum,.dropcap:first-letter,.dropcap p:first-letter,.highlights,.blog .blog-gallery .flex-direction-nav a:hover ,.album-playlist .tracklist:hover,.concert-list article:hover .text:before,#wp-calendar caption,#wp-calendar tfoot a, .widget_nav_menu ul li:hover, .widget_pages ul li:hover, .widget_links ul li:hover, .widget_meta ul li:hover, .widget_archive ul li:hover, .widget_recent_comments ul li:hover, .widget_recent_entries ul li:hover, .widget_categories_list ul li:hover,.widget_tag_cloud a:hover,.artist-gallery-sec article figure,.blog-gallery article:hover .article-wrapp figure,#header .menu-btn";
	var boc = ".bordercolr, .albumpanel li a:hover,.nav-tabs > .active > a:before, nav.navigation > ul > li:hover > a, nav.navigation > ul > li > a:hover, .nav-tabs > li > a:hover:before ,.header-1 .navigation > ul > li > a:hover, nav.navigation ul > li.current-menu-item, nav.navigation > ul > li.current-menu-ancestor";
	var boc2 =".coursesarticle:hover .rating:before, .blog_admin article:hover .cuting_border, .team-shortcode article:hover .cuting_border";
	var styleheading = "";
	$('#themecolor .bg_color').wpColorPicker({
		change:function(event,ui){
			var a = ui.color.toString();
			$("#stylecss") .remove();
			$("<style type='text/css' id='stylecss'>"+cf+"{color:"+a+" !important}"+bc+"{background-color:"+a+" !important}"+boc+"{border-color:"+a+" !important}"+boc2+"{border-color:transparent "+a+" !important}</style>").insertAfter("body");
			} 
    	}); 
 	$('#headingcolor .bg_color').wpColorPicker({
		change:function(event,ui){
			var a = ui.color.toString();
			$("#stylecsstwo") .remove();
			$("<style type='text/css' id='stylecsstwo'>"+styleheading+"{color:"+a+" !important}</style>").insertAfter("body");
			} 
    	});
		
		jQuery("#colorpickerwrapp span.col-box") .live("click",function(event) {
			var a = jQuery(this).data('color');
			jQuery("#bgcolor").val(a);
			jQuery('.wp-color-result').css('background-color', a);
			jQuery("#stylecss") .remove();
			jQuery("<style type='text/css' id='stylecss'>"+cf+"{color:"+a+" !important}"+bc+"{background-color:"+a+" !important}"+boc+"{border-color:"+a+" !important}"+boc2+"{border-color:transparent "+a+" !important}</style>").insertAfter("body");
			
			
			jQuery("#colorpickerwrapp span.col-box") .removeClass('active');
			jQuery(this).addClass("active");
		});
		 
	});
	function reset_color(){
		jQuery("#reset_color_txt").attr('value',"1")
		jQuery("#bgcolor").attr('value',"#242423")
		jQuery("#color_switcher").submit();
	}
        </script>
        <div id="sidebarmain">
            <span id="togglebutton">&nbsp;</span>
            <div id="sidebar">
                <form method="post" id="color_switcher" action="">
                	<aside class="rowside">
                         <header><h4>Layout options</h4></header>
                         <label>Select Color Scheme</label>
                        <div id="colorpickerwrapp">
                            <?php $cs_color_array= array('#45b363','#339a74', '#1d7f5b', '#3fb0c3', '#2293a6', '#137d8f', '#9374ae', '#775b8f', '#dca13a', '#c46d32', '#c44732',
                                                     '#c44d55', '#425660', '#292f32'
                                                    );
                            foreach($cs_color_array as $colors){
                                $active = '';
                                if($colors == $cs_theme_option['custom_color_scheme']){$active = 'active';}
                                echo '<span class="col-box '.$active.'" data-color="'.$colors.'" style="background: '.$colors.'"></span>';
                            }
                            ?>
                         </div>
                        <label for="bgcolor" id="themecolor" class="colorpicker-main">
                        <img src="<?php echo $theme_path?>/images/admin/img-colorpan.png" alt="">
                        <h5>Theme Color</h5>
                        <input id="bgcolor" name="style_sheet" type="text" class="bg_color" value="<?php echo $_SESSION['sess_style_sheet'];?>" /></label>
                        
                    </aside>
                	<div class="buttonarea">
                    	<input type="submit" value="Apply" class="btn" />
                        <input type="hidden" name="patter_or_bg" id="patter_or_bg" value="1" />
                        <input type="hidden" name="reset_color_txt" id="reset_color_txt" value="" />
                    	<input type="reset" value="Reset" class="btn" onclick="javascript:reset_color()" />
                    </div>
            </form>
            </div>
        </div>
<?php
	}
}

// Custom excerpt function 
function cs_get_the_excerpt($limit,$readmore = '') {
	global $cs_theme_option;
    $get_the_excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU', '', get_the_excerpt()));
    echo substr($get_the_excerpt, 0, "$limit");
    if (strlen($get_the_excerpt) > "$limit") {
		echo '...';
    }
}

// Flexslider function
if ( ! function_exists( 'cs_flex_slider' ) ) {
	function cs_flex_slider($width,$height,$slider_id,$cs_show_description){
		global $cs_node,$cs_theme_option,$counter_node;
		$counter_node++;
		if($slider_id == ''){
			$slider_id = $cs_node->slider;
		}
		if($cs_theme_option['flex_auto_play'] == 'on'){$auto_play = 'true';}
			else if($cs_theme_option['flex_auto_play'] == ''){$auto_play = 'false';}
			$cs_meta_slider_options = get_post_meta($slider_id, "cs_meta_slider_options", true); 
		?>
		<!-- Flex Slider -->
		  <div id="flexslider<?php echo $counter_node ?>" class="flexslider">
			  <ul class="slides">
				<?php 
					$counter = 1;
					$cs_xmlObject_flex = new SimpleXMLElement($cs_meta_slider_options);
					foreach ( $cs_xmlObject_flex->children() as $as_node ){
 						$image_url = cs_attachment_image_src($as_node->path,$width,$height); 
						if($image_url <> ''){
						?>
						<li>
                            <figure>
							<img src="<?php echo $image_url ?>" alt="" />
							<!-- Caption Start -->
                            
							<?php 
								if($as_node->title != '' && $as_node->description != '' || $as_node->title != '' || $as_node->description != ''){ 
								$as_node->cs_slider_link ="";
								if($as_node->link <> ''){}
							?>
                            <figcaption>
                                <div class="row">
                                <div class="span5">
                                    <?php if($as_node->title <> ''){?>
                                    <h2 class="post-title"> <a href="<?php echo $as_node->link;?>" target="<?php echo $as_node->link_target;?>" > <?php echo $as_node->title;?> </a> </h2>
                                    <?php }?>
                                    <!--<h5>Justine Timberlake</h5>-->
                                    <?php if($cs_show_description == "ture"){?>
                                        <p>
                                        <?php
                                            echo substr($as_node->description, 0, 215);
                                            if ( strlen($as_node->description) > 215 ) echo "...";
                                        ?>
                                         </p>
                                    <?php }?>
                                 
                                  </div>
                              </div>
                              </figcaption>
							<!-- Caption End -->
							<?php } ?>
                            </figure>
						</li>
					<?php 
						}
					$counter++;
					}
				?>
			  </ul>
		  </div>
 		<!-- Slider height and width -->
        
		<!-- Flex Slider Javascript Files -->
        <?php cs_enqueue_flexslider(); ?>
		<script type="text/javascript">
			jQuery(window).load(function(){
				var speed = <?php echo $cs_theme_option['flex_animation_speed']; ?>; 
				var slidespeed = <?php echo $cs_theme_option['flex_pause_time']; ?>;
				jQuery('#flexslider<?php echo $counter_node ?>.flexslider').flexslider({
					animation: "<?php echo $cs_theme_option['flex_effect']; ?>", // fade
					slideshow: <?php echo $auto_play;?>,
					slideshowSpeed:speed,
					animationSpeed:slidespeed
				});
				jQuery("a.flex-prev").append("<em class='fa fa-angle-left' />");
     			jQuery("a.flex-next").append("<em class='fa fa-angle-right' />");
 			});
		</script>
	<?php
	}
}

// Get post meta in xml form
function cs_meta_page($meta) {
    global $cs_meta_page;
    $meta = get_post_meta(get_the_ID(), $meta, true);
    if ($meta <> '') {
        $cs_meta_page = new SimpleXMLElement($meta);
        return $cs_meta_page;
    }
}

// change the default query variable start
function cs_change_query_vars($query) {
    if (is_search() || is_archive() || is_author() || is_tax() || is_tag() || is_category() || is_home()) {
        if (empty($_GET['page_id_all']))
            $_GET['page_id_all'] = 1;
       $query->query_vars['paged'] = $_GET['page_id_all'];
}
return $query; // Return modified query variables
}
add_filter('pre_get_posts', 'cs_change_query_vars'); // Hook our custom function onto the request filter
// change the default query variable end


// Social Share Function
if ( ! function_exists( 'cs_social_share' ) ) {
	function cs_social_share($icon_type = '', $title='') {
		global $post, $cs_theme_option;
		if($icon_type=='small'){
			$icon = ' fa-2';
		} else {
			$icon = ' fa-2x';
		}
		$html = '';
		$pageurl = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		if(isset($post->ID) && $post->ID <> ''){
			$pageurl = get_permalink($post->ID);
		}
		$path = get_template_directory_uri() . "/images/admin/";
		$html .='<div id="myshare" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myshareLabel" aria-hidden="true">
				<div class="showicons">';
		$html .='<div class="social-network"><em class="fa fa-times-circle fa-2x social_close"></em>';
 				$html .= '<h3>';
				if($cs_theme_option["trans_switcher"] == "on") { $html .= _e("Share this post",'Bolster'); }else{  $html .=  $cs_theme_option["trans_share_this_post"];}
				$html .= '</h3>';
			if (isset($cs_theme_option['facebook_share']) && $cs_theme_option['facebook_share'] == 'on') {
				$html .= '<a href="http://www.facebook.com/share.php?u=' . $pageurl . '&t=' . get_the_title() . '" target="_blank" data-original-title="Facebook" data-placement="top" class="fa fa-facebook-square facebook  '.$icon.'" style="color:#2b3c8e;"></a>';
			}
			if (isset($cs_theme_option['twitter_share']) && $cs_theme_option['twitter_share'] == 'on') {
				$html .= '<a href="http://twitter.com/home?status=' . get_the_title() . ' - ' . $pageurl . '" target="_blank" data-original-title="Twitter" data-placement="top" class="fa fa-twitter-square twitter  '.$icon.'" style="color:#43adf7;"></a>';
			}
			if (isset($cs_theme_option['google_plus_share']) && $cs_theme_option['google_plus_share'] == 'on') { 
				$html .= '<a href="https://plus.google.com/share?url='.get_permalink().'" target="_blank" data-original-title="Google Plus" data-placement="top" class="fa fa-google-plus-square google_plus  '.$icon.'" style="color:#e94f51;"></a>'; 
			}
			if (isset($cs_theme_option['linkedin_share']) && $cs_theme_option['linkedin_share'] == 'on') {
				$html .= '<a href="http://www.linkedin.com/shareArticle?mini=true&#038;url=' . $pageurl . '&#038;title=' . get_the_title() . '" target="_blank" data-original-title="Linkedin" data-placement="top" class="fa fa-linkedin-square linkedin  '.$icon.'" style="color:#262f56;"></a>';
			}
			if (isset($cs_theme_option['pinterest_share']) && $cs_theme_option['pinterest_share'] == 'on') {
				$html .= '<a href="http://pinterest.com/pin/create/button/?url=' . $pageurl . '&#038;title=' . get_the_title() . '" target="_blank"  data-original-title="Pinterest" data-placement="top" class="fa fa-pinterest-square  pinterest  '.$icon.'" style="color:#ea4e4f;"></a>';
			}
			if (isset($cs_theme_option['tumblr_share']) &&  $cs_theme_option['tumblr_share'] == 'on') { 
				$html .= '<a href="https://www.tumblr.com/share/link?url='.get_permalink().'&name=' . get_the_title() . '" target="_blank" data-original-title="Tumbler" data-placement="top" class="fa fa-tumblr-square tumbler  '.$icon.'" style="color:#262e55;"></a>'; 
			}
			$html .='</div><div class="share_link webkit">
			<form>
			<div class="cs_socil_link">Share Link</div>
			<input type="url" value="'.get_permalink().'" onfocus="this.select();" style="width: 80%	"></form>';
			
		$html .='</div></div></div>';
		echo $html;
	}
}

// Social network
if ( ! function_exists( 'cs_social_network' ) ) {
	function cs_social_network($tooltip='',$icon_type=''){
		global $cs_theme_option;
		$tooltip_data='';
		echo '<div class="shareoption">';
		if(isset($cs_theme_option['social_net_title']) && $cs_theme_option['social_net_title'] <> ''){
			echo '<h5>';
				echo $cs_theme_option['social_net_title'];
			echo '</h5>';
		}
		if($icon_type=='large'){
			$icon = 'fa-2x';
		}
		if(isset($tooltip) && $tooltip <> ''){
			$tooltip_data='data-placement-tooltip="tooltip"';
		}
		if ( isset($cs_theme_option['social_net_url']) and count($cs_theme_option['social_net_url']) > 0 ) {
				$i = 0;
				foreach ( $cs_theme_option['social_net_url'] as $val ){
					?>
			<?php if($val != ''){?><a title="" href="<?php echo $val;?>" data-original-title="<?php echo $cs_theme_option['social_net_tooltip'][$i];?>" data-placement="top" <?php echo $tooltip_data;?>  target="_blank"><?php if($cs_theme_option['social_net_awesome'][$i] <> '' && isset($cs_theme_option['social_net_awesome'][$i])){?> <em class="fa <?php echo $cs_theme_option['social_net_awesome'][$i];?> <?php echo $icon_type;?>">&nbsp;</em><?php } else {?><img src="<?php echo $cs_theme_option['social_net_icon_path'][$i];?>" alt="<?php echo $cs_theme_option['social_net_tooltip'][$i];?>" /><?php }?></a><?php }
				$i++;
		}
		}
		echo '</div>';
	}
}

// Post image attachment function
function cs_attachment_image_src($attachment_id, $width, $height) {
    $image_url = wp_get_attachment_image_src($attachment_id, array($width, $height), true);
     if ($image_url[1] == $width and $image_url[2] == $height)
        ;
    else
        $image_url = wp_get_attachment_image_src($attachment_id, "full", true);
    	$parts = explode('/uploads/',$image_url[0]);
		if ( count($parts) > 1 ) return $image_url[0];
}
// Post image attachment source function
function cs_get_post_img_src($post_id, $width, $height) {
    if(has_post_thumbnail()){
		$image_id = get_post_thumbnail_id($post_id);
		$image_url = wp_get_attachment_image_src($image_id, array($width, $height), true);
		if ($image_url[1] == $width and $image_url[2] == $height) {
			return $image_url[0];
		} else {
			$image_url = wp_get_attachment_image_src($image_id, "full", true);
			return $image_url[0];
		}
	}
}
// Get Post image attachment
function cs_get_post_img($post_id, $width, $height) {
    $image_id = get_post_thumbnail_id($post_id);
    $image_url = wp_get_attachment_image_src($image_id, array($width, $height), true);
    if ($image_url[1] == $width and $image_url[2] == $height) {
        return get_the_post_thumbnail($post_id, array($width, $height));
    } else {
        return get_the_post_thumbnail($post_id, "full");
    }
}

/*
Dynamic Css styles changes by color switcher
*/
function cs_custom_styles() {
	global $cs_theme_option;
 
	if ( isset($_POST['heading_color']) ) {
		$_SESSION['sess_heading_color'] = $_POST['heading_color'];
		$heading_color_scheme = $_SESSION['sess_heading_color'];
	}
	elseif (isset($_SESSION['sess_heading_color']) and $_SESSION['sess_heading_color'] <> '') {
		 $heading_color_scheme = $_SESSION['sess_heading_color'];
	}
	else{
		$heading_color_scheme = '#000';
	}

  	if ( isset($_POST['style_sheet']) ) {
		$_SESSION['sess_style_sheet'] = $_POST['style_sheet'];
		$cs_color_scheme = $_SESSION['sess_style_sheet'];
	}
	elseif (isset($_SESSION['sess_style_sheet']) and $_SESSION['sess_style_sheet'] <> '') {
		$cs_color_scheme = $_SESSION['sess_style_sheet'];
	}
	else{
		$cs_color_scheme = $cs_theme_option['custom_color_scheme'];
	}
 ?>
<style type="text/css" >
@charset "utf-8";
/* CSS Document */
.colr,#wp-calendar tbody td a,.for_o_for .navigation ul li a:hover, .alumbpanwrapp a.btnalbumpan:hover, #signin h5, .text a:hover, .blockquote .icon-stack em.icon-circle,.blog-tags a:hover,.album-list figure figcaption .tracklist:hover li a,.album-list figure figcaption .tracklist:hover li p,.widget-box:hover figcaption,.contactform p span input:focus ~ em ,.title-song li,.accordion-heading .accordion-toggle.active,.accordion-heading .accordion-toggle:hover,.accordion-inner:before, .header-1 .alumbpanwrapp a.btnalbumpan.active,.concert-list article:hover .date-box, .gallery_grid_view article:hover .gallery_stack_element .fa-stack-2x,.jp-playlist li:hover a, .jp-playlist li.jp-playlist-current a {
	color:<?php echo $cs_color_scheme ?> !important;
}
#header,.tags-box a, .events-photo article:hover figure,.events-photo li figure, #wrappermain-pix .woocommerce .button:hover ,.widget_tag_cloud a:hover, p.form-submit input#submit-comment,.bgcolr, .password_protected form input[type='submit'], #signin li button.button, .flex-control-paging li a:hover, .flex-control-paging li a.flex-active, .blog-gallery figure figcaption a:hover, .detail_text h6 strong ,.widget_categories > ul > li:hover,.form-submit button,#player .jp-playlist:before ,.album-footer .rating,.album .album-footer a.album-counter,.main-progress .jp-progress .jp-play-bar,.jp-volume-bar-value,#header.header-light .playersocial a.btnalbum,.dropcap:first-letter,.dropcap p:first-letter,.highlights,.blog .blog-gallery .flex-direction-nav a:hover ,.album-playlist .tracklist:hover,.concert-list article:hover .text:before,#wp-calendar caption,#wp-calendar tfoot a, .widget_nav_menu ul li:hover, .widget_pages ul li:hover, .widget_links ul li:hover, .widget_meta ul li:hover, .widget_archive ul li:hover, .widget_recent_comments ul li:hover, .widget_recent_entries ul li:hover, .widget_categories_list ul li:hover,.widget_tag_cloud a:hover,.artist-gallery-sec article figure,.blog-gallery article:hover .article-wrapp figure,#header .menu-btn{
	background-color:<?php echo $cs_color_scheme ?> !important;}
.bordercolr, .albumpanel li a:hover,.nav-tabs > .active > a:before, nav.navigation > ul > li:hover > a, nav.navigation > ul > li > a:hover, .nav-tabs > li > a:hover:before ,.header-1 .navigation > ul > li > a:hover, nav.navigation ul > li.current-menu-item, nav.navigation > ul > li.current-menu-ancestor {
	border-color:<?php echo $cs_color_scheme ?> !important;}



</style>
<?php 
}

// custom sidebar start
$cs_theme_option = get_option('cs_theme_option');
if ( isset($cs_theme_option['sidebar']) and !empty($cs_theme_option['sidebar'])) {
	foreach ( $cs_theme_option['sidebar'] as $sidebar ){
		//foreach ( $parts as $val ) {
		register_sidebar(array(
			'name' => $sidebar,
			'id' => $sidebar,
			'description' => 'This widget will be displayed on right side of the page.',
			'before_widget' => '<div class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<header class="heading"><h2 class="section-title cs-heading-color">',
			'after_title' => '</h2></header>'
		));
	}
}
// custom sidebar end
function cs_add_menuid($ulid) {
	return preg_replace('/<ul>/', '<ul id="menus">', $ulid, 1);
}
add_filter('wp_page_menu','cs_add_menuid');
function cs_remove_div ( $menu ){
    return preg_replace( array( '#^<div[^>]*>#', '#</div>$#' ), '', $menu );
}
add_filter( 'wp_page_menu', 'cs_remove_div' );
function cs_register_my_menus() {
  register_nav_menus(
	array(
		'main-menu'  => __('Main Menu','Bolster'),
  	)
  );
}
add_action( 'init', 'cs_register_my_menus' );

add_filter('nav_menu_css_class', 'cs_add_parent_css', 10, 2);
function cs_add_parent_css($classes, $item) {
    global $menu_children;
    if ($menu_children)
        $classes[] = 'parent';
    return $classes;
}
// adding custom images while uploading media start
add_image_size('cs_media_1', 1600, 900, true);
add_image_size('cs_media_2', 800, 800, true);
add_image_size('cs_media_3', 550, 550, true);
add_image_size('cs_media_4', 270, 270, true);
add_image_size('cs_media_5', 210, 112, true);
add_image_size('cs_media_6', 800, 450, true);
add_image_size('cs_media_7', 300, 169, true);


// adding custom images while uploading media end

If (!function_exists('cs_comment')) :
     /**
     * Template for comments and pingbacks.
     *
     * To override this walker in a child theme without modifying the comments template
     * simply create your own cs_comment(), and that function will be used instead.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     *
     */
	function cs_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	$args['reply_text'] = __('Reply', 'Bolster');
 	switch ( $comment->comment_type ) :
		case '' :
	?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <div class="thumblist" id="comment-<?php comment_ID(); ?>">
            <ul>
                <li>
                    <a><?php echo get_avatar( $comment, 30 ); ?></a>
                     <div class="text">
                             <?php printf( __( '%s', 'Bolster' ), sprintf( '<h5>%s</h5>', get_comment_author_link() ) ); ?>
                             <?php comment_text(); ?>
                             <p class="panel">
                            <?php
                            	/* translators: 1: date, 2: time */
                                printf( __( '<time>%1$s</time>', 'Bolster' ), get_comment_date()); ?>
                             <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                            
                            <?php edit_comment_link( __( '(Edit)', 'Bolster' ), ' ' );?>
							<?php if ( $comment->comment_approved == '0' ) : ?>
                                <div class="comment-awaiting-moderation colr"><?php _e( 'Your comment is awaiting moderation.', 'Bolster' ); ?></div>
                            <?php endif; ?>
                            </p>
                       
                    </div>
                </li>
            </ul>
        </div>
	<?php
		break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'Bolster' ), ' ' ); ?></p>
	<?php
		break;
		endswitch;
	}
 	endif;
// password protect post/page
if ( ! function_exists( 'cs_password_form' ) ) {
	function cs_password_form() {
		global $post,$cs_theme_option;
		$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
		$o = '<div class="span12"><div class="for_o_for"><div class="password_protected">
				<h1 class="transform colr">' . __( "Password Protected","Evilution" ) . '</h1>
				<h2>' . __( "This post is password protected. To view it please enter your password below:",'Bolster' ) . '</h2>';
		$o .= '<div>
					<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
						<label><input name="post_password" id="' . $label . '" type="password" size="20" /></label>
						<input class="backcolr" type="submit" name="Submit" value="Submit" />
					</form>
				</div>
			</div></div></div>';
		return $o;
	}
}
add_filter( 'the_password_form', 'cs_password_form' );

if ( ! function_exists( 'cs_logo' ) ) {
	function cs_logo($logo_url, $log_width, $logo_height){
	?>
		<a href="<?php echo home_url(); ?>"><img src="<?php echo $logo_url; ?>"  style="width:<?php echo $log_width; ?>px; height:<?php echo $logo_height; ?>px" alt="<?php echo bloginfo('name'); ?>" /></a>
	 <?php
	}
}

/*
Under Construction logo Function
*/
function cs_uc_logo(){
	global $cs_theme_option;
	?>
	<a href="<?php echo home_url(); ?>"><img src="<?php echo $cs_theme_option['uc_logo']; ?>"  style="width:<?php echo $cs_theme_option['uc_logo_width']; ?>px; height:<?php echo $cs_theme_option['uc_logo_height']; ?>px" alt="<?php echo bloginfo('name'); ?>" /></a>
 <?php
}
/*
Top and Main Navigation
*/
if ( ! function_exists( 'cs_navigation' ) ) {
	function cs_navigation($nav='', $menus = 'menu'){
		global $cs_theme_option;
		// Menu parameters	
		$defaults = array(
			'theme_location' => "$nav",
			'menu' => '',
			'container' => '',
			'container_class' => '',
			'container_id' => '',
			'menu_class' => '',
			'menu_id' => "$menus",
			'echo' => false,
			'fallback_cb' => 'wp_page_menu',
			'before' => '',
			'after' => '',
			'link_before' => '',
			'link_after' => '',
			'items_wrap' => '<ul id="%1$s">%3$s</ul>',
			'depth' => 0,
			'walker' => '',);
		echo do_shortcode(wp_nav_menu($defaults));
	}
}

/*
 * CS media attachment 
 */
function cs_media_attachment($post_id,$width, $height){
	$attachment = get_children( array( 'post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
	foreach($attachment as $image){
		echo '<a href="'.$image->guid.'" data-rel="prettyPhoto[gallery1] rel="prettyPhoto[gallery1]"><img src="'.$image->guid.'" width="'.$width.'" height="'.$height.'"></a>';
	}
}

/*
 * Ccustom Header Styles 1 -10
 */
function cs_custom_header_styles($header_styles='header1') { global $cs_theme_option, $post;
?>
<header id="header" class="fullwidth mainheader">
            <!-- Menu Area -->
            <a href="#" class="menu-btn"><i class="fa fa-align-justify"></i></a>
            <div id="mainmenu">
                <div id="togglemenu">
                <!-- Logo Area -->
                 <?php if(isset($cs_theme_option['logo']) && !empty($cs_theme_option['logo'])){ ?>
                <!-- Logo Area -->
                <div class="logo">
                    <?php cs_logo($cs_theme_option['logo'], $cs_theme_option['logo_width'], $cs_theme_option['logo_height']); ?>
                </div>
                <!-- Logo Area Close -->
            	<?php } ?>
                <!-- Logo Area Close -->
                <!-- Navigation -->
                <nav class="navigation">
                   <?php cs_navigation('main-menu'); ?>
                </nav>
                <!-- Navigation Close -->
                <div class="bottom">
                       <!--Share Option -->
                    <?php 
					if($cs_theme_option['header_1_social_icons']=='on'){
						cs_social_network(); 
					} ?>
                    <!-- Share Option Close -->
                    <?php if(isset($cs_theme_option['copyright']) && !empty($cs_theme_option['copyright'])){ ?>
                         <div class="copyrights">
                            <p><?php echo $cs_theme_option['copyright'];?></p>
                        </div>
                    <?php } ?>
                </div>
                </div>  
            </div>
            <!-- Menu Aare Close -->
        </header>
    <!-- Header  End -->          
<?php 
}

/*
 * Ccustom Header Styles  1 -10 End
 */
 

 
 // Header simple, toggle and custom Search at front end//
function cs_header_search($type='simple'){ ?>
    <!-- Search Start -->
    <div class="searcharea">
        <a href="#" class="btn-search shabox"><em class="fa fa-search fa-2x">&nbsp;</em></a>
		<form action="<?php echo home_url() ?>" method="get" role="search">
         <input  class="input-search" type="search" name="s" value="<?php _e('Search for:', "Evilution"); ?>"
                                           onFocus="if (this.value == '<?php _e('Search for:', "Evilution"); ?>') {
                                                       this.value = '';
                                                   }"
                                           onblur="if (this.value == '') {
                                                       this.value = '<?php _e('Search for:', "Evilution"); ?>';
                                                   }"  />
        </form>                                       
    </div>
    <!-- Search End -->
<?php
}
/*
* Login function
*/
if ( ! function_exists( 'cs_login' ) ) {
	function cs_login($login='', $logout='', $header_style=''){
		global $cs_theme_option; 
 		?>
			
					<?php  
						if ( is_user_logged_in() ) { ?>
                        <a href="<?php echo wp_logout_url("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); ?>" class="btn-signin btn-toggle"><em class="icon-user">&nbsp;</em> <?php _e('Log out', 'Bolster');?> </a>
					<?php }else{?>
                    <a href="#signin" class="btn-signin btn-toggle"><em class="fa fa-user">&nbsp;</em> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Sign In','Bolster');}else{ echo $cs_theme_option['trans_sign_in']; } ?> </a>
							 
					<?php }
	}
}
/*
*Under Construction Page
*/
if ( ! function_exists( 'cs_under_construction' ) ) {
	function cs_under_construction(){ 
		global $cs_theme_option, $post;
		if(isset($post)){ $post_name = $post->post_name;  }else{ $post_name = ''; }
		if ( $cs_theme_option['under-construction'] == "on" or $post_name == "pf-under-construction" ) { 
		?>
		<div class="wrapper fullwidth">
		<header id="header" class="fullwidth mainheader">
			<div class="logo">
				<?php if($cs_theme_option['showlogo'] == "on"){ cs_uc_logo(); } ?>
			</div>
		</header>
			
		<div id="midarea" style="background-color:#DF5803;">
			<div class="container">
				<?php echo '<p>'.htmlspecialchars_decode($cs_theme_option['under_construction_text']).'</p>';?>      
				<?php
					 $launch_date = $cs_theme_option['launch_date'];
					 $year = date("Y", strtotime($launch_date));
					 $month = date("m", strtotime($launch_date));
					 $month_event_c = date("M", strtotime($launch_date));							
					 $day = date("d", strtotime($launch_date));
					 $time_left = date("H,i,s", strtotime($launch_date));
					
				?>
                <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
				<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/frontend/jquery.countdown.js"></script>
                 <script type="text/javascript">
                    $(function () {
						var austDay = new Date();
						austDay = new Date(<?php echo $year; ?>, <?php echo $month; ?> - 1, <?php echo $day; ?>);
						$('#defaultCountdown').countdown({until: austDay});
						$('#year').text(austDay.getFullYear());
					});
                    </script>
				<div class="countdown styled"></div>
				<div class="countdownit">
					<div id="defaultCountdown"></div>
				</div>
				
			</div>
			
		 </div>
	 </div>
	 <?php die();
	 }
	}
} 
// widget start
// widget_facebook start
class cs_facebook_module extends WP_Widget
{
  function cs_facebook_module()
  {
		$widget_ops = array('classname' => 'facebok_widget', 'description' => 'Facebook widget like box total customized with theme.' );
		$this->WP_Widget('cs_facebook_module', 'CS : Facebook', $widget_ops);
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
	add_action( 'widgets_init', create_function('', 'return register_widget("cs_facebook_module");') );
	// widget_facebook end
	
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
						cs_enqueue_gallery_style_script();
 						for ($i = 0; $i < $showcount; $i++) {
							$path = $cs_xmlObject->gallery[$i]->path;
							$title = $cs_xmlObject->gallery[$i]->title;
							$description = $cs_xmlObject->gallery[$i]->description;
							$social_network = $cs_xmlObject->gallery[$i]->social_network;
							$use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;
							$video_code = $cs_xmlObject->gallery[$i]->video_code;
							$link_url = $cs_xmlObject->gallery[$i]->link_url;
							$image_url = cs_attachment_image_src($path, 60, 60);
							$image_url_full = cs_attachment_image_src($path, 0, 0);
						?>
						 <li>
							<a <?php if ( $description <> '' ) { echo 'data-title="'.$description.'"'; }?> href="<?php if ($use_image_as == 1)echo $video_code;  elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" target="<?php if($use_image_as==2){ echo '_blank'; }else{ echo '_self'; }; ?>" data-rel="<?php if ($use_image_as == 1) echo "prettyPhoto"; elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>"><?php echo "<img width='60' height='60' src='" . $image_url . "' data-alt='" . $title . "' alt='' />" ?></a>
						</li>
				<?php } ?>
				</ul>
			 <?php }}else{
				 echo '<h4>'.__( 'No results found.', 'Bolster' ).'</h4>';
				 }}     // endif of Category Selection?>
				
			 <?php
 			echo $after_widget; // WIDGET display CODE End
		}
	
	}
	
	add_action('widgets_init', create_function('', 'return register_widget("cs_gallery");'));
	// widget_gallery end
	// widget_recent_post start
	class cs_recentposts extends WP_Widget
	{
	  function cs_recentposts()
	  {
		$widget_ops = array('classname' => 'widget_latest_news', 'description' => 'Recent Posts from category.' );
		$this->WP_Widget('cs_recentposts', 'CS : Recent Posts', $widget_ops);
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
				global $wpdb, $post;?>
				<!-- Recent Posts Start -->
							<ul class="featured_blog">
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
 									$width 	= 150;
									$height = 150;
 									$image_url = cs_get_post_img_src($post->ID, $width, $height);
 									}
									$no_image="";
									if($image_url == ""){
										$no_image="class=\"no-image\"";
									}
								?>
									<!-- Upcoming Widget Start -->
										<?php
										if($thumb == "true"){
										?>
										<li <?php echo $no_image; ?>>
												<?php
												if($image_url <> ""){
												?>
												<a href='<?php echo get_permalink(); ?>' ><img src='<?php echo $image_url ?>' alt='' class='pull-left' width='50'></a>
                                             <?php
												}
											 $before_cat = "<em class='fa fa-circle'>&nbsp;</em>".__( '','Bolster')."";
											 $categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '' );
											 ?>
                                            <div class="text">
                                            	<h2 class="post-title"><a href="<?php the_permalink();?>" class="colrhover"><?php echo substr(get_the_title(),0,30); if ( strlen(get_the_title()) > 30) echo "..."; ?></a></h2>	
                                                <p class="panel"><time><?php echo get_the_date();?></time> <?php if ( $categories_list ) printf( __( '%1$s', 'Bolster'),$categories_list ); ?></p><span class="post-panel"><a href="<?php echo get_permalink(); ?>"><em class="fa fa-comment">&nbsp;</em><?php  if ( comments_open() ) { comments_popup_link( __( '0', 'Bolster' ) , __( '1', 'Bolster' ), __( '%', 'Bolster' ) ); echo ' <a href="'.get_permalink().'#respond">' . __( '', 'Bolster' ).'</a>'; } ?></a>
                                                <?php
													$cs_like_counter = get_post_meta(get_the_id(), "cs_like_counter", true);
													if ( !isset($cs_like_counter) or empty($cs_like_counter) ) $cs_like_counter = 0;
													
														echo '<a><em class="fa fa-heart">&nbsp;</em>'.$cs_like_counter.'</a>';
													?>
                                                    </span>
                                            </div>
											 
										</li>
										<?php
										}else{
										?>
										
										<li <?php echo $no_image; ?>>
                                             <?php
											 $before_cat = "<em class='fa fa-circle'>&nbsp;</em>".__( '','Bolster')."";
											 $categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '' );
											 ?>
                                            <div class="text">
                                            	<h2 class="post-title"><a href="<?php the_permalink();?>" class="colrhover"><?php echo substr(get_the_title(),0,30); if ( strlen(get_the_title()) > 30) echo "..."; ?></a></h2>	
                                                <p class="panel"><time><?php echo get_the_date();?></time> <?php if ( $categories_list ) printf( __( '%1$s', 'Bolster'),$categories_list ); ?></p><span class="post-panel"><a href="<?php echo get_permalink(); ?>"><em class="fa fa-comment">&nbsp;</em><?php  if ( comments_open() ) { comments_popup_link( __( '0', 'Bolster' ) , __( '1', 'Bolster' ), __( '%', 'Bolster' ) ); echo ' <a href="'.get_permalink().'#respond">' . __( '', 'Bolster' ).'</a>'; } ?></a>
                                                <?php
													$cs_like_counter = get_post_meta(get_the_id(), "cs_like_counter", true);
													if ( !isset($cs_like_counter) or empty($cs_like_counter) ) $cs_like_counter = 0;
													
														echo '<a><em class="fa fa-heart">&nbsp;</em>'.$cs_like_counter.'</a>';
													?>
                                                    </span>
                                            </div>
											 
										</li>
										<?php
										}
										?>
								<?php endwhile; ?>
									</ul>
							<?php
                            }
							else {
								echo '<h4>'.__( 'No results found.', 'Bolster' ).'</h4>';
							}?>
  				<!-- Recent Posts End -->     
				<?php
				echo $after_widget;
			}
		}
		add_action( 'widgets_init', create_function('', 'return register_widget("cs_recentposts");') );
	// widget_recent_post end
	
	
	// widget post slider start
	class cs_widget_post_slider extends WP_Widget
	{
	  function cs_widget_post_slider()
	  {
		$widget_ops = array('classname' => 'widget_image_desc', 'description' => 'Select category for post slider.' );
		$this->WP_Widget('cs_widget_post_slider', 'CS : Post slider', $widget_ops);
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
				global $wpdb, $post;
				
				?>
				<!-- Recent Posts Start -->
						<script type="text/javascript" src="<?php echo get_template_directory_uri() . '/scripts/frontend/'; ?>jquerycycle2.js"></script>
						<div class="widget-pager"></div>
						<div data-cycle-slides="article" data-cycle-carousel-visible="1" data-cycle-fx="scrollHorz" data-cycle-timeout="0" class="cycle-slideshow" data-cycle-pager=".widget-pager">
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
									$post_image = $cs_xmlObject->post_thumb_image;
 									$width 	= 210;
									$height = 112;
 									$image_url = cs_get_post_img_src($post->ID, $width, $height);
 									}
									$no_image="";
									if($image_url == ""){
										$no_image="class=\"no-image\"";
									}
								
									if($thumb == "true"){
								?>
									
									<article <?php echo $no_image; ?>>
										<figure>
											<?php
											if($image_url <> ""){
											?>
											<a href='<?php echo get_permalink(); ?>' ><img src="<?php echo $image_url ?>" alt=""></a>
											<?php
											}
											?>
											<figcaption>
												<h2 class="post-title"><a href="<?php the_permalink();?>" class="colrhover"><?php echo substr(get_the_title(),0,30); if ( strlen(get_the_title()) > 30) echo "..."; ?></a></h2>
												<time><?php echo date('l', strtotime(get_the_date())).", ".get_the_time(); ?></time>
												<p><?php echo substr(get_the_excerpt(),0,200); if ( strlen(get_the_excerpt()) > 200) echo "..."; ?></p>
											</figcaption>
										</figure>
									</article>
								<?php
									}else{
								?>
								
									<article <?php echo $no_image; ?>>
										<figure>
											<figcaption>
												<h2 class="post-title"><a href="<?php the_permalink();?>" class="colrhover"><?php echo substr(get_the_title(),0,30); if ( strlen(get_the_title()) > 30) echo "..."; ?></a></h2>
												<time><?php echo date('l', strtotime(get_the_date())).", ".get_the_time(); ?></time>
												<p><?php echo substr(get_the_excerpt(),0,200); if ( strlen(get_the_excerpt()) > 200) echo "..."; ?></p>
											</figcaption>
										</figure>
									</article>
								<?php
									}
								?>	
								<?php endwhile; ?>
								</div>
							<?php
                            }
							else {
								echo '<h4>'.__( 'No results found.', 'Bolster' ).'</h4>';
							}?>
  				<!-- Recent Posts End -->     
				<?php
				echo $after_widget;
			}
		}
		add_action( 'widgets_init', create_function('', 'return register_widget("cs_widget_post_slider");') );
	// widget post slider end

	
	
	// widget_twitter start
 	class cs_twitter_widget extends WP_Widget {
		function cs_twitter_widget() {
			$widget_ops = array('classname' => 'widget widget_newslatter widget-twitter', 'description' => 'Twitter Widget');
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
 			if(isset($username) && $username <> ''){
				cs_artist_twitter_feeds($username,$numoftweets);
			}
		echo $after_widget;
		// WIDGET display CODE End
		}
 	}
 	add_action('widgets_init', create_function('', 'return register_widget("cs_twitter_widget");'));
	
	// widget_twitter end

// Event Widget

class cs_upcoming_events extends WP_Widget
{
  function cs_upcoming_events()
  {
    $widget_ops = array('classname' => 'upcoming_event', 'description' => 'Select Event category to show its posts.' );
    $this->WP_Widget('cs_upcoming_events', 'CS : Upcoming Events', $widget_ops);
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
						'post_type'					=> 'gigs',
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
						?><ul class="featured_blog"><?php
 						$counter_events = 0;
                        while ( $custom_query->have_posts() ): $custom_query->the_post();
							$counter_events++;
							$cs_event_from_date = get_post_meta($post->ID, "cs_event_from_date", true); 
							$year_event = date("Y", strtotime($cs_event_from_date));
							$month_event = date("M", strtotime($cs_event_from_date));
							$day_event = date("d", strtotime($cs_event_from_date));
							$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
							if ( $cs_event_meta <> "" ) {
								$cs_event_meta = new SimpleXMLElement($cs_event_meta);
								$event_start_time = $cs_event_meta->event_start_time;
							}
							$cs_event_loc = get_post_meta($cs_event_meta->event_address, "cs_event_loc_meta", true);
							if ( $cs_event_loc <> "" ) {
								$cs_xmlObject = new SimpleXMLElement($cs_event_loc);
								$loc_address = $cs_xmlObject->loc_address;
							}else{
								$loc_address = '';
							}
 						?>
                         <!-- Events Widget Start -->
						 <li>
                        	<div class="date-box"><big><?php echo date("d", strtotime($cs_event_from_date)); ?></big><small><?php echo date("M", strtotime($cs_event_from_date)); ?></small></div>
                            <div class="text">
                            	<h2 class="post-title"><a class="colrhover" href="<?php echo get_permalink(); ?>">
                                <?php
									echo substr(get_the_title(), 0, 24);
									if (strlen(get_the_title()) > 24)
										echo "...";
									?>
                                	</a></h2>
                                <p class="panel"><time><?php echo date("M d, Y", strtotime($cs_event_from_date)); ?></time></p>
								<?php
								if($loc_address <> ""){
								?>
                                <span class="post-panel"><a href="<?php echo get_permalink(); ?>"><em class="fa fa-map-marker">&nbsp;</em><?php echo $loc_address; ?></a></span>
                            	<?php
								}
								?>
							</div>
                         </li>
                          
                        <!-- Events Widget End -->		
 						<?php endwhile;?>
                        </ul>						
 					<?php }else{
							echo '<h3 class="heading-color">';_e( 'No results found.', 'Bolster' ); echo '</h3>';
						}
			}	// endif of Category Selection
			echo $after_widget;	// WIDGET display CODE End
		}
	}
add_action( 'widgets_init', create_function('', 'return register_widget("cs_upcoming_events");') );

// Event widgt End


// Album Widget

class cs_widget_albums extends WP_Widget
{
  function cs_widget_albums()
  {
    $widget_ops = array('classname' => 'widget_album', 'description' => 'Select Album category to show its posts.' );
    $this->WP_Widget('cs_widget_albums', 'CS : Upcoming Albums', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ,'widget_names_albums' =>'new') );
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
	  Select Album Category:
	  <select id="<?php echo $this->get_field_id('get_post_slug'); ?>" name="<?php echo $this->get_field_name('get_post_slug'); ?>" style="width:225px">
      	<option value=""> Select Category</option>
		<?php
        global $wpdb,$post;
		$categories = get_categories('taxonomy=album-category&child_of=0&hide_empty=0'); 
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
	  Number of Albums: 
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
				$newterm = get_term_by('slug', $get_post_slug, 'album-category'); 
					$args = array(
						'posts_per_page'			=> $showcount,
						'post_type'					=> 'albums',
						'album-category'			=> "$get_post_slug",
                        'post_status'				=> 'publish',
                        
 					);
                    $custom_query = new WP_Query($args);
					if ( $custom_query->have_posts() <> "" ) {
						?><ul class="featured_blog"><?php
 						$counter_albums = 0;
                        while ( $custom_query->have_posts() ): $custom_query->the_post();
							$counter_albums++;
							$post_xml = get_post_meta($post->ID, "cs_album", true);	
							$cs_xmlObject = new SimpleXMLElement($post_xml);
							
							$counter_track = 0;
							foreach ($cs_xmlObject as $track) {
								if ($track->getName() == "track") { 
								$counter_track++;
							}
							$width 	= 150;
							$height = 150;
							$image_url = cs_get_post_img_src($post->ID, $width, $height);
							
						}
						
						$no_image="";
						if($image_url == ""){
							$no_image="class=\"no-image\"";
						}
						$cs_album_artists = get_post_meta($post->ID, "cs_album_artists", true);
 						?>
                         <!-- Albums Widget Start -->
						 <li <?php echo $no_image; ?>>
                            <a href="<?php echo get_permalink(); ?>">
                            <?php 
								if($image_url <> ''){echo "<img class='pull-left' src=".$image_url." alt='' width='50'>";} else {echo '<img class="pull-left" src="' . get_template_directory_uri() . '/images/Dummy.jpg" alt="" width="50" />';}
							?>
                            </a>
                            <div class="text">
                                <h2 class="post-title"><a class="colrhover" href="<?php echo get_permalink(); ?>"><?php echo substr(get_the_title(), 0, 24); if (strlen(get_the_title()) > 24) echo "..."; ?></a></h2>
                                <span class="post-panel"><a><em class="fa fa-user">&nbsp;</em><?php echo $cs_album_artists; ?></a><a><em class="fa fa-music">&nbsp;</em><?php if($counter_track <> 0){ echo $counter_track; } ?></a></span>
                            </div>
                        </li>
						
                        <!-- Albums Widget End -->		
 						<?php endwhile;?>
                        </ul>						
 					<?php }else{
							echo '<h3 class="heading-color">';_e( 'No results found.', 'Bolster' ); echo '</h3>';
						}
			}	// endif of Category Selection
			echo $after_widget;	// WIDGET display CODE End
		}
	}
add_action( 'widgets_init', create_function('', 'return register_widget("cs_widget_albums");') );

// Album widgt End



$args = array(
    'default-color' => '',
    'default-image' => '',
);
add_theme_support('custom-background', $args);
add_theme_support('custom-header', $args);

// This theme styles the visual editor with editor-style.css to match the theme style.
add_editor_style();

// This theme uses post thumbnails
add_theme_support('post-thumbnails');

// Add default posts and comments RSS feed links to head
add_theme_support('automatic-feed-links');

// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain('Bolster', get_template_directory() . '/languages');
if (!isset($content_width)) $content_width = 1170; ?>