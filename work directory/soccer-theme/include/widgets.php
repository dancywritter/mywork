<?php
/* widget_facebook start */
class px_widget_facebook extends WP_Widget{
	function px_widget_facebook()  {
		$widget_ops = array('classname' => 'facebok_widget', 'description' => 'Facebook widget like box total customized with theme.' );
		$this->WP_Widget('px_widget_facebook', 'PX: Facebook', $widget_ops);
  	}
  	function form($instance){
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = $instance['title'];
		$pageurl = isset( $instance['pageurl'] ) ? esc_attr( $instance['pageurl'] ) : '';
		$showfaces = isset( $instance['showfaces'] ) ? esc_attr( $instance['showfaces'] ) : '';
		$showstream = isset( $instance['showstream'] ) ? esc_attr( $instance['showstream'] ) : '';
		$showheader = isset( $instance['showheader'] ) ? esc_attr( $instance['showheader'] ) : '';
		$fb_bg_color = isset( $instance['fb_bg_color'] ) ? esc_attr( $instance['fb_bg_color'] ) : '';
		$likebox_height = isset( $instance['likebox_height'] ) ? esc_attr( $instance['likebox_height'] ) : '';						
	?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"> Title:
                <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size='40' 
                name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('pageurl'); ?>"> Page URL:
                <input class="upcoming" id="<?php echo $this->get_field_id('pageurl'); ?>" size='40' 
                name="<?php echo $this->get_field_name('pageurl'); ?>" type="text" value="<?php echo esc_attr($pageurl); ?>" />
                <br />
                <small>Please enter your page or User profile url example: http://www.facebook.com/profilename OR <br />
                https://www.facebook.com/pages/wxyz/123456789101112 </small><br />
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('showfaces'); ?>"> Show Faces:
                <input class="upcoming" id="<?php echo $this->get_field_id('showfaces'); ?>" 
                name="<?php echo $this->get_field_name('showfaces'); ?>" type="checkbox" <?php if(esc_attr($showfaces) != '' ){echo 'checked';}?> />
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('showstream'); ?>"> Show Stream:
                <input class="upcoming" id="<?php echo $this->get_field_id('showstream'); ?>" 
                name="<?php echo $this->get_field_name('showstream'); ?>" type="checkbox" <?php if(esc_attr($showstream) != '' ){echo 'checked';}?> />
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('likebox_height'); ?>"> Like Box Height:
                <input class="upcoming" id="<?php echo $this->get_field_id('likebox_height'); ?>" size='2' 
                name="<?php echo $this->get_field_name('likebox_height'); ?>" type="text" value="<?php echo esc_attr($likebox_height); ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('fb_bg_color'); ?>"> Background Color:
                <input type="text" size='4' id="<?php echo $this->get_field_id('fb_bg_color'); ?>" 
                name="<?php echo $this->get_field_name('fb_bg_color'); ?>" value="<?php if(!empty($fb_bg_color)){ echo $fb_bg_color;}else{ echo "#fff";}; ?>" class="fb_bg_color upcoming"  />
            </label>
        </p>
	<?php
	}
	function update($new_instance, $old_instance){
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
	function widget($args, $instance){
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
		global $wpdb, $post;
	?>
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
                          data-stream="<?php echo $showstream;?>" data-header="false"> </div>
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
	<?php 
	echo $after_widget;
	}
}
// widget_gallery start
class px_gallery extends WP_Widget {
	function px_gallery() {
		$widget_ops = array('classname' => 'widget-gallery', 'description' => 'Select any gallery to show in widget.');
		$this->WP_Widget('px_gallery', 'PX : Gallery Widget', $widget_ops);
	}
	function form($instance) {
		$instance = wp_parse_args((array) $instance, array('title' => '', 'get_names_gallery' => 'new'));
		$title = $instance['title'];
		$get_names_gallery = isset($instance['get_names_gallery']) ? esc_attr($instance['get_names_gallery']) : '';
		$showcount = isset($instance['showcount']) ? esc_attr($instance['showcount']) : '';
		?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"> Title:
                <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" 
                name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
            </label>
        </p>
        <p>
        	<label for="<?php echo $this->get_field_id('get_names_gallery'); ?>"> Select Gallery:
            	<select id="<?php echo $this->get_field_id('get_names_gallery'); ?>" 
                name="<?php echo $this->get_field_name('get_names_gallery'); ?>" style="width:225px;">
			<?php
				global $wpdb, $post;
				$newpost = 'posts_per_page=-1&post_type=px_gallery&order=ASC&post_status=publish';
				$newquery = new WP_Query($newpost);
				while ($newquery->have_posts()): $newquery->the_post();
				?>
                    <option <?php
                        if (esc_attr($get_names_gallery) == $post->post_name) {
                            echo 'selected';
                        }
                        ?> value="<?php echo $post->post_name; ?>" > <?php echo substr(get_the_title($post->ID), 0, 20);
                                if (strlen(get_the_title($post->ID)) > 20)
                                    echo "...";
                                ?> 
                   </option>
				<?php endwhile; ?>
			</select>
		</label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('showcount'); ?>"> Number of Images:
			<input class="upcoming" id="<?php echo $this->get_field_id('showcount'); ?>" size="2" 
            name="<?php echo $this->get_field_name('showcount'); ?>" type="text" value="<?php echo esc_attr($showcount); ?>" />
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
		echo $before_widget;
		if (strlen($get_names_gallery) <> 1 || strlen($get_names_gallery) <> 0) {
			echo $before_title . $title . $after_title;
		}
 		if ($get_names_gallery <> '') {
 			// galery slug to id start
			$get_gallery_id = '';
			$args=array(
				'name' => $get_names_gallery,
				'post_type' => 'px_gallery',
				'post_status' => 'publish',
				'showposts' => 1,
			);
			$get_posts = get_posts($args);
 			if($get_posts){
				$get_gallery_id = $get_posts[0]->ID;
			}
			// galery slug to id end
			if($get_gallery_id <> ''){
				$px_meta_gallery_options = get_post_meta($get_gallery_id, "px_meta_gallery_options", true);
				if ($px_meta_gallery_options <> "") {
					$cs_xmlObject = new SimpleXMLElement($px_meta_gallery_options);
					if ($showcount > count($cs_xmlObject)) {
						$showcount = count($cs_xmlObject);
					}
				?>
                <div  class="gallery lightbox">
					<ul>
					<?php
                         for ($i = 0; $i < $showcount; $i++) {
                            $path = $cs_xmlObject->gallery[$i]->path;
                            $title = $cs_xmlObject->gallery[$i]->title;
                            $description = $cs_xmlObject->gallery[$i]->description;
                            $social_network = $cs_xmlObject->gallery[$i]->social_network;
                            $use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;
                            $video_code = $cs_xmlObject->gallery[$i]->video_code;
                            $link_url = $cs_xmlObject->gallery[$i]->link_url;
                            $image_url = px_attachment_image_src($path, 64, 64);
                            $image_url_full = px_attachment_image_src($path, 0, 0);
                    ?>
                    <li> 
                    	<figure>
                        <?php echo "<img  src='" . $image_url . "' data-alt='" . $title . "' alt='' />" ?>
                       <figcaption>
                        <a href="<?php if ($use_image_as == 1)echo $video_code;  elseif($use_image_as==2) 
							echo $link_url; else echo $image_url_full;?>"	        
                            target="<?php if($use_image_as==2){ echo '_blank'; }else{ echo '_self'; }; ?>" data-rel="<?php if ($use_image_as == 1) 
                            echo "prettyPhoto"; elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>">
                            <i class="fa fa-plus"></i>	
                        </a> 
                          </figcaption>
                        </figure>
                    </li>
            <?php } ?>
			</ul>
        </div>
	<?php }
	}else{
			echo '<h4>'.__( 'No results found.', 'Soccer Club' ).'</h4>';
		}
	} 
	echo $after_widget; // WIDGET display CODE End
	}
}
// widget_recent_post start
class recentposts extends WP_Widget{
	function recentposts()	{
		$widget_ops = array('classname' => 'widget-recent-blog', 'description' => 'Recent Posts from category.' );
		$this->WP_Widget('recentposts', 'PX : Recent Posts', $widget_ops);
	}
	function form($instance){
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = $instance['title'];
		$select_category = isset( $instance['select_category'] ) ? esc_attr( $instance['select_category'] ) : '';
		$showcount = isset( $instance['showcount'] ) ? esc_attr( $instance['showcount'] ) : '';	
 	?>
	<p>
        <label for="<?php echo $this->get_field_id('title'); ?>"> Title:
            <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" 
            name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </label>
    </p>
	<p>
		<label for="<?php echo $this->get_field_id('select_category'); ?>"> Select Category:
			<select id="<?php echo $this->get_field_id('select_category'); ?>" 
            	name="<?php echo $this->get_field_name('select_category'); ?>" style="width:225px">
				<?php
				$categories = get_categories();
					if($categories <> ""){
						foreach ( $categories as $category ) {
						?>
							<option <?php if($select_category == $category->slug){echo 'selected';}?> 
                            	value="<?php echo $category->slug;?>" ><?php echo $category->name;?>
                            </option>
                    	<?php } 
					}
				?>
			</select>
		</label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('showcount'); ?>"> Number of Posts To Display:
			<input class="upcoming" id="<?php echo $this->get_field_id('showcount'); ?>" size='2' 
            name="<?php echo $this->get_field_name('showcount'); ?>" type="text" value="<?php echo esc_attr($showcount); ?>" />
		</label>
     </p>
	 
	<?php
	}
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['select_category'] = $new_instance['select_category'];
		$instance['showcount'] = $new_instance['showcount'];
 		return $instance;
	}
	function widget($args, $instance){
		global $px_node;
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$select_category = empty($instance['select_category']) ? ' ' : apply_filters('widget_title', $instance['select_category']);		
		$showcount = empty($instance['showcount']) ? ' ' : apply_filters('widget_title', $instance['showcount']);	
 		
		if($instance['showcount'] == ""){$instance['showcount'] = '-1';}
		echo $before_widget;	
		// WIDGET display CODE Start
		if (!empty($title) && $title <> ' '){
			echo $before_title;
			echo $title;
			echo $after_title;
		}
		global $wpdb, $post;
		wp_reset_query();
		$args = array( 'posts_per_page' => "$showcount",'post_type' => 'post','category_name' => "$select_category"); 
		$custom_query = new WP_Query($args);
		if ( $custom_query->have_posts() <> "" ) {
			while ( $custom_query->have_posts()) : $custom_query->the_post();
			$post_xml = get_post_meta($post->ID, "post", true);	
			$cs_xmlObject = new stdClass();
			if ( $post_xml <> "" ) {
				$cs_xmlObject = new SimpleXMLElement($post_xml);
				$width 	= 240;
				$height = 180;
				$image_url = px_get_post_img_src($post->ID, $width, $height);
				}
			?>
			<article>
			<?php 
				if($image_url <> ''){
  					echo " <figure><a class='pix-colrhvr' href='".get_permalink()."' ><img src='".$image_url."' alt=''></a></figure>";					
				} ?>
                <div class="text">
                    <h6>
                        <a href="<?php the_permalink();?>"  class='pix-colrhvr'>
                            <?php echo substr(get_the_title(),0,30); if ( strlen(get_the_title()) > 30) echo ".."; ?>
                        </a>
                    </h6>
                     <?php px_posted_on(false,false,false,true,false,true);?>
				</div>
    		</article>
	    <?php endwhile; 
	}else {
		echo '<h4>'.__( 'No results found.', 'Soccer Club' ).'</h4>';
	}
	echo $after_widget;
	}
}
// widget_recent_post start
class postsslider extends WP_Widget{
	function postsslider()	{
		$widget_ops = array('classname' => 'widget-slider', 'description' => 'Posts Slider from category.' );
		$this->WP_Widget('postsslider', 'PX : Posts Slider', $widget_ops);
	}
	function form($instance){
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = $instance['title'];
		$select_category = isset( $instance['select_category'] ) ? esc_attr( $instance['select_category'] ) : '';
		$showcount = isset( $instance['showcount'] ) ? esc_attr( $instance['showcount'] ) : '';	
 	?>
	<p>
        <label for="<?php echo $this->get_field_id('title'); ?>"> Title:
            <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" 
            name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </label>
    </p>
	<p>
		<label for="<?php echo $this->get_field_id('select_category'); ?>"> Select Category:
			<select id="<?php echo $this->get_field_id('select_category'); ?>" 
            	name="<?php echo $this->get_field_name('select_category'); ?>" style="width:225px">
				<?php
				$categories = get_categories();
					if($categories <> ""){
						foreach ( $categories as $category ) {
						?>
							<option <?php if($select_category == $category->slug){echo 'selected';}?> 
                            	value="<?php echo $category->slug;?>" ><?php echo $category->name;?>
                            </option>
                    	<?php } 
					}
				?>
			</select>
		</label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('showcount'); ?>"> Number of Posts To Display:
			<input class="upcoming" id="<?php echo $this->get_field_id('showcount'); ?>" size='2' 
            name="<?php echo $this->get_field_name('showcount'); ?>" type="text" value="<?php echo esc_attr($showcount); ?>" />
		</label>
     </p>
	 
	<?php
	}
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['select_category'] = $new_instance['select_category'];
		$instance['showcount'] = $new_instance['showcount'];
 		return $instance;
	}
	function widget($args, $instance){
		global $px_node;
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$select_category = empty($instance['select_category']) ? ' ' : apply_filters('widget_title', $instance['select_category']);		
		$showcount = empty($instance['showcount']) ? ' ' : apply_filters('widget_title', $instance['showcount']);	
 		
		if($instance['showcount'] == ""){$instance['showcount'] = '-1';}
		echo $before_widget;	
		// WIDGET display CODE Start
		if (!empty($title) && $title <> ' '){
			echo $before_title;
			echo $title;
			echo $after_title;
		}
		global $wpdb, $post;
		wp_reset_query();
		$args = array( 'posts_per_page' => "$showcount",'post_type' => 'post','category_name' => "$select_category"); 
		$custom_query = new WP_Query($args);
		if ( $custom_query->have_posts() <> "" ) {
			?>
			<div class="flexslider">
             <?php  px_enqueue_flexslider_script(); ?>
             <script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery('#main .flexslider').flexslider({
						animation: "slide",
					  	prevText: "<i class='fa fa-angle-left'></i>",
					 	nextText: "<i class='fa fa-angle-right'></i>",
					 	slideshowSpeed: 4000
				  });
				});
             </script>
             <ul class="slides">
			<?php
			while ( $custom_query->have_posts()) : $custom_query->the_post();
			$post_xml = get_post_meta($post->ID, "post", true);	
			$cs_xmlObject = new stdClass();
			if ( $post_xml <> "" ) {
				$cs_xmlObject = new SimpleXMLElement($post_xml);
				$width 	= 240;
				$height = 180;
				$image_url = px_get_post_img_src($post->ID, $width, $height);
				}
			?>
 			<?php 
				if($image_url <> ''){
  					echo "<li><img src='".$image_url."' alt=''></a></li>";					
				} ?>
                
 	    <?php endwhile; 
		echo '</ul></div>';
	}else {
		echo '<h4>'.__( 'No results found.', 'Soccer Club' ).'</h4>';
	}
	echo $after_widget;
	}
}
?>