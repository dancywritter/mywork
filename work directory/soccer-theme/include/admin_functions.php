<?php

// element setting options
function px_element_setting($name,$px_counter,$element_size){
  	?>
    <div class="column-in">
       	<h5>
            <?php 
                 $element_title = str_replace("px_pb_","",$name);
                echo ucfirst($element_title);
            ?>
        </h5>
        <input type="hidden" name="<?php echo $element_title; ?>_element_size[]" class="item" value="<?php echo $element_size; ?>" >
        <a class="decrement fa fa-minus" onclick="javascript:decrement(this)"></a> &nbsp; 
        <a class="increment fa fa-plus" onclick="javascript:increment(this)"></a> &nbsp;
        <a href="#" class="delete-it btndeleteit fa fa-trash-o"></a> &nbsp; 
        <a href="javascript:hide_all('<?php echo $name.$px_counter?>')" class="options fa fa-pencil"></a>
    </div>
   <?php
}

// add twitter option in user profile

function px_contact_options( $contactoptions ) {

 $contactoptions['twitter'] = 'Twitter';
 $contactoptions['facebook'] = 'Facebook';
 $contactoptions['googleplus'] = 'Google Plus';
 $contactoptions['linkedin'] = 'Linked in';
 $contactoptions['flicker'] = 'Flicker';

 return $contactoptions;

}
/* add social icons*/
function add_social_icon(){
    $template_path = get_template_directory_uri() . '/scripts/admin/media_upload.js';
    wp_enqueue_script('my-upload2', $template_path, array('jquery', 'media-upload', 'thickbox', 'jquery-ui-droppable', 'jquery-ui-datepicker', 'jquery-ui-slider', 'wp-color-picker'));
	if($_POST['social_net_awesome'] <> ''){
		$fontimg = '<td><i class="fa ' .$_POST['social_net_awesome']. '"></i></td> ';
		
	} else {
		$fontimg = '<td><img width="50" src="' .$_POST['social_net_icon_path']. '"></td> ';
	}

	echo '<tr id="del_' .$_POST['counter_social_network'].'"> 
	
		'.$fontimg.' 
		<td>' .$_POST['social_net_url']. '</td> 
		<td class="centr"> 
			<a onclick="javascript:return confirm(\'Are you sure! You want to delete this\')" href="javascript:social_icon_del('.$_POST['counter_social_network'].')"><i class="fa fa fa-times"></i></a> 
			| <a href="javascript:px_toggle('.$_POST['counter_social_network'].')"><i class="fa fa-edit"></i></a>
		</td> 
	</tr> 
	<tr id="'.$_POST['counter_social_network'].'" style="display:none"> 
		<td colspan="3"> 
			<span class="theme-wrap"><a onclick="px_toggle('. $_POST['counter_social_network'] .')"><img src="'.get_template_directory_uri().'/images/admin/close-red.png"></a></span>
			<ul class="form-elements">
				<li class="to-label"><label>Icon Path</label></li>
				<li class="to-field">
				  <input id="social_net_icon_path'.$_POST['counter_social_network'].'" name="social_net_icon_path[]" value="'.$_POST['social_net_icon_path'].'" type="text" class="small" /> 
				</li>
				
				<li class="full">&nbsp;</li>
				<li class="to-label"><label>Awesome Font</label></li>
				<li class="to-field">
				  <input class="small" type="text" id="social_net_awesome" name="social_net_awesome[]" value="'.$_POST['social_net_awesome'].'" style="width:420px;" />
				  <p>Put Awesome Font Code like "flag".</p>
				</li>
				<li class="full">&nbsp;</li>
				<li class="to-label"><label>URL</label></li>
				<li class="to-field">
				  <input class="small" type="text" id="social_net_url" name="social_net_url[]" value="'.$_POST['social_net_url'].'" style="width:420px;" />
				  <p>Please enter full URL.</p>
				</li>
				<li class="full">&nbsp;</li>
				<li class="to-label"><label>Title</label></li>
				<li class="to-field">
				  <input class="small" type="text" id="social_net_tooltip" name="social_net_tooltip[]" value="'.$_POST['social_net_tooltip'].'" style="width:420px;" />
				  <p>Please enter text for icon tooltip..</p>
				</li>
			</ul>
		</td> 
	</tr>';
	die;
}
add_action('wp_ajax_add_social_icon', 'add_social_icon');
// media pagination for slider/gallery in admin side start
function media_pagination(){
	foreach ( $_REQUEST as $keys=>$values) {
		$$keys = $values;
	}
	$records_per_page = 10;
	if ( empty($page_id) ) $page_id = 1;
	$offset = $records_per_page * ($page_id-1);
?>
	<ul class="gal-list">
      <?php
        $query_images_args = array('post_type' => 'attachment', 'post_mime_type' =>'image', 'post_status' => 'inherit', 'posts_per_page' => -1,);
        $query_images = new WP_Query( $query_images_args );
        if ( empty($total_pages) ) $total_pages = count( $query_images->posts );
		$query_images_args = array('post_type' => 'attachment', 'post_mime_type' =>'image', 'post_status' => 'inherit', 'posts_per_page' => $records_per_page, 'offset' => $offset,);
        $query_images = new WP_Query( $query_images_args );
        $images = array();
        foreach ( $query_images->posts as $image) {
        	$image_path = wp_get_attachment_image_src( $image->ID, array( get_option("thumbnail_size_w"),get_option("thumbnail_size_h") ) );
        ?>
        	<li style="cursor:pointer"><img src="<?php echo $image_path[0]?>" onclick="javascript:clone('<?php echo $image->ID?>')" alt="" /></li>
         <?php
         }
         ?>
      </ul>
      <br />
      <div class="pagination-cus">
        	<ul>
				<?php
                if ( $page_id > 1 ) echo "<li><a href='javascript:show_next(".($page_id-1).",$total_pages)'>Prev</a></li>";
                    for ( $i = 1; $i <= ceil($total_pages/$records_per_page); $i++ ) {
                        if ( $i <> $page_id ) echo "<li><a href='javascript:show_next($i,$total_pages)'>" . $i . "</a></li> ";
                        else echo "<li class='active'><a>" . $i . "</a></li>";
                    }
                if ( $page_id < $total_pages/$records_per_page ) echo "<li><a href='javascript:show_next(".($page_id+1).",$total_pages)'>Next</a></li>";
                ?>
			</ul>
        </div>
<?php
	if ( isset($_POST['action']) ) die();
}
add_action('wp_ajax_media_pagination', 'media_pagination');
// media pagination for slider/gallery in admin side end


// to make a copy of media image for gallery start
function px_gallery_caption(){
	global $px_node, $px_counter;
	if( isset($_POST['action']) ) {
		$px_node = new stdClass();
		$px_node->title = "";
		$px_node->use_image_as = "";
		$px_node->video_code = "";
		$px_node->link_url = "";
		$px_node->use_image_as_db = "";
		$px_node->link_url_db = '';
	}
	if ( isset($_POST['counter']) ) $px_counter = $_POST['counter'];
	if ( isset($_POST['path']) ) $px_node->path = $_POST['path'];
?>
    <li class="ui-state-default" id="<?php echo $px_counter?>">
        <div class="thumb-secs">
            <?php $image_path = wp_get_attachment_image_src( $px_node->path, array( get_option("thumbnail_size_w"),get_option("thumbnail_size_h") ) );?>
            <img src="<?php echo $image_path[0]?>" alt="">
            <div class="gal-edit-opts">
                <!--<a href="#" class="resize"></a>-->
                <a href="javascript:galedit(<?php echo $px_counter?>)" class="edit"></a>
                <a href="javascript:del_this(<?php echo $px_counter?>)" class="delete"></a>
            </div>
        </div>
        <div class="poped-up" id="edit_<?php echo $px_counter?>">
            <div class="opt-head">
                <h5>Edit Options</h5>
                <a href="javascript:galclose(<?php echo $px_counter?>)" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
                <ul class="form-elements">
                    <li class="to-label"><label>Image Title</label></li>
                    <li class="to-field"><input type="text" name="title[]" value="<?php echo htmlspecialchars($px_node->title)?>" class="txtfield" /></li>
                </ul>
                
                <ul class="form-elements">
                    <li class="to-label"><label>Use Image As</label></li>
                    <li class="to-field">
                        <select name="use_image_as[]" class="select_dropdown" onchange="px_toggle_gal(this.value, <?php echo $px_counter?>)">
                            <option <?php if($px_node->use_image_as=="0")echo "selected";?> value="0">LightBox to current thumbnail</option>
                            <option <?php if($px_node->use_image_as=="1")echo "selected";?> value="1">LightBox to Video</option>
                            <option <?php if($px_node->use_image_as=="2")echo "selected";?> value="2">Link URL</option>
                        </select>
                        <p>Please select Image link where it will go.</p>
                    </li>
                </ul>
                <ul class="form-elements" id="video_code<?php echo $px_counter?>" <?php if($px_node->use_image_as=="0" or $px_node->use_image_as=="" or $px_node->use_image_as=="2")echo 'style="display:none"';?> >
                    <li class="to-label"><label>Video URL</label></li>
                    <li class="to-field">
                        <input type="text" name="video_code[]" value="<?php echo htmlspecialchars($px_node->video_code)?>" class="txtfield" />
                        <p>(Enter Specific Video URL Youtube or Vimeo)</p>
                    </li>
                </ul>
                <ul class="form-elements" id="link_url<?php echo $px_counter?>" <?php if($px_node->use_image_as=="0" or $px_node->use_image_as=="" or $px_node->use_image_as=="1")echo 'style="display:none"';?> >
                    <li class="to-label"><label>Link URL</label></li>
                    <li class="to-field">
                        <input type="text" name="link_url[]" value="<?php echo htmlspecialchars($px_node->link_url)?>" class="txtfield" />
                        <p>(Enter Specific Link URL)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"></li>
                    <li class="to-field">
                        <input type="hidden" name="path[]" value="<?php echo $px_node->path?>" />
                        <input type="button" onclick="javascript:galclose(<?php echo $px_counter?>)" value="Submit" class="close-submit" />
                    </li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
    </li>
<?php
	if ( isset($_POST['action']) ) die();
}
add_action('wp_ajax_px_gallery_caption', 'px_gallery_caption');
// to make a copy of media image for gallery end
// stripslashes / htmlspecialchars for theme option save start
function stripslashes_htmlspecialchars($value){
    $value = is_array($value) ? array_map('stripslashes_htmlspecialchars', $value) : stripslashes(htmlspecialchars($value));
    return $value;
}
// stripslashes / htmlspecialchars for theme option save end

// saving all the theme options start
function theme_option_save() {
	if ( isset($_POST['logo']) ) {
		$_POST = stripslashes_htmlspecialchars($_POST);
		
		if ( $_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['twitter_setting'])){
			update_option( "px_theme_option", $_POST );
			echo "All Settings Saved";
 		}else{
			update_option( "px_theme_option", $_POST );
			echo "All Settings Saved";
			
		}
	}
	else {
		$target_path_mo = get_template_directory()."/languages/".$_FILES["mofile"]["name"][0];
		if ( move_uploaded_file($_FILES["mofile"]["tmp_name"][0], $target_path_mo) ) {
			chmod($target_path_mo,0777);
		}
		echo "New Language Uploaded Successfully";
	}
	die();
}
add_action('wp_ajax_theme_option_save', 'theme_option_save');
// saving theme options import export start
function theme_option_import_export() {
 	if($_POST['theme_option_data'] and $_POST['theme_option_data'] <> ''){
		$a = unserialize(base64_decode(trim($_POST['theme_option_data'])));
		update_option( "px_theme_option", $a );
		echo "OPtions Imported";
		die();
	}else{
		echo "Import failed<br>Textarea is empty.";
		die();
	}
}
add_action('wp_ajax_theme_option_import_export', 'theme_option_import_export');
// restoring default theme options start
function theme_option_restore_default() {
	update_option( "px_theme_option", get_option('px_theme_option_restore') );
	echo "Default Theme Options Restored";
	die();
}
add_action('wp_ajax_theme_option_restore_default', 'theme_option_restore_default');
// saving theme options backup start
function theme_option_backup() {
	update_option( "px_theme_option_backup", get_option('px_theme_option') );
	update_option( "px_theme_option_backup_time", gmdate("Y-m-d H:i:s") );
	echo "Current Backup Taken @ " . gmdate("Y-m-d H:i:s");
	die();
}
add_action('wp_ajax_theme_option_backup', 'theme_option_backup');
// restore backup start
function theme_option_backup_restore() {
	update_option( "px_theme_option", get_option('px_theme_option_backup') );
	echo "Backup Restored";
	die();
}
add_action('wp_ajax_theme_option_backup_restore', 'theme_option_backup_restore');
/* page bulider items start
   gallery html form for page builder start */
function px_pb_gallery($die = 0){
	global $px_node, $px_count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$px_counter = $_POST['counter'];
		$gallery_element_size = '50';
		$px_gal_header_title_db = '';
		$px_gal_layout_db = '';
		$px_gal_album_db = '';
		$px_gal_pagination_db = '';
		$px_gal_media_per_page_db = get_option("posts_per_page");
	}
	else {
		$name = $px_node->getName();
		$px_count_node++;
		$gallery_element_size = $px_node->gallery_element_size;
		$px_gal_header_title_db = $px_node->header_title;
		$px_gal_layout_db = $px_node->layout;
		$px_gal_album_db = $px_node->album;
		$px_gal_pagination_db = $px_node->pagination;
		$px_gal_media_per_page_db = $px_node->media_per_page;
		$px_counter = $post->ID.$px_count_node;
	}
?> 
	<div id="<?php echo $name.$px_counter?>_del" class="column  parentdelete column_<?php echo $gallery_element_size?>" item="gallery" data="<?php echo element_size_data_array_index($gallery_element_size)?>" >
         <?php px_element_setting($name,$px_counter,$gallery_element_size);?>
         <div class="poped-up" id="<?php echo $name.$px_counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Gallery Options</h5>
                <a href="javascript:show_all('<?php echo $name.$px_counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Gallery Header Title</label></li>
                    <li class="to-field">
                        <input type="text" name="px_gal_header_title[]" class="txtfield" value="<?php echo htmlspecialchars($px_gal_header_title_db)?>" />
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Choose Gallery Layout</label></li>
                    <li class="to-field">
                        <select name="px_gal_layout[]" class="dropdown">
                            <option value="gallery-four-col" <?php if($px_gal_layout_db=="gallery-four-col")echo "selected";?> >4 Column</option>
                            <option value="gallery-three-col" <?php if($px_gal_layout_db=="gallery-three-col")echo "selected";?> >3 Column</option>
                            <option value="gallery-two-col" <?php if($px_gal_layout_db=="gallery-two-col")echo "selected";?> >2 Column</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Choose Gallery/Album</label></li>
                    <li class="to-field">
                        <select name="px_gal_album[]" class="dropdown">
                        	<option value="0">-- Select Gallery --</option>
                            <?php
                                $query = array( 'posts_per_page' => '-1', 'post_type' => 'px_gallery', 'orderby'=>'ID', 'post_status' => 'publish' );
                                $wp_query = new WP_Query($query);
                                while ($wp_query->have_posts()) : $wp_query->the_post();
                            ?>
                                <option <?php if($post->post_name==$px_gal_album_db)echo "selected";?> value="<?php echo $post->post_name; ?>"><?php echo get_the_title()?></option>
                            <?php
                                endwhile;
                            ?>
                        </select>
                    </li>
                </ul>
                
                <ul class="form-elements">
                    <li class="to-label"><label>Pagination</label></li>
                    <li class="to-field">
                        <select name="px_gal_pagination[]" class="dropdown" >
                            <option <?php if($px_gal_pagination_db=="Show Pagination")echo "selected";?> >Show Pagination</option>
                            <option <?php if($px_gal_pagination_db=="Single Page")echo "selected";?> >Single Page</option>
                        </select>
                    </li>
                </ul>
				<ul class="form-elements" >
                    <li class="to-label"><label>No. of Media Per Page</label></li>
                    <li class="to-field">
                    	<input type="text" name="px_gal_media_per_page[]" class="txtfield" value="<?php echo $px_gal_media_per_page_db; ?>" />
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="px_orderby[]" value="gallery" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$px_counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_px_pb_gallery', 'px_pb_gallery');
// gallery html form for page builder end

// Menu html form for page builder end
	if ( isset($action) ) die();
// blog html form for page builder start
function px_pb_blog($die = 0){
	global $px_node, $px_count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$px_counter = $_POST['counter'];
		$blog_element_size = '50';
		$var_pb_blog_title = '';
		$var_pb_featured_cat = '';
		$var_pb_blog_view = '';
		$var_pb_blog_excerpt = '255';
		$var_pb_blog_cat = '';
		$var_pb_blog_num_post = get_option("posts_per_page");
		$var_pb_blog_pagination = '';
 	}
	else {
		$name = $px_node->getName();
			$px_count_node++;
			$blog_element_size = $px_node->blog_element_size;
		    $var_pb_blog_title = $px_node->var_pb_blog_title;
			$var_pb_blog_view = $px_node->var_pb_blog_view;
			$var_pb_featured_cat = $px_node->var_pb_featured_cat;
			$var_pb_blog_cat = $px_node->var_pb_blog_cat;
 			$var_pb_blog_excerpt = $px_node->var_pb_blog_excerpt;
 			$var_pb_blog_num_post = $px_node->var_pb_blog_num_post;
			$var_pb_blog_pagination = $px_node->var_pb_blog_pagination;
 				$px_counter = $post->ID.$px_count_node;
}
?> 

	<div id="<?php echo $name.$px_counter?>_del" class="column  parentdelete column_<?php echo $blog_element_size?>" item="blog" data="<?php echo element_size_data_array_index($blog_element_size)?>" >
		<?php px_element_setting($name,$px_counter,$blog_element_size);?>
		<div class="poped-up" id="<?php echo $name.$px_counter?>" style="border:none; background:#f8f8f8;" >
        
            <div class="opt-head">
                <h5>Edit Blog Options</h5>
                <a href="javascript:show_all('<?php echo $name.$px_counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Blog Section Title </label></li>
                    <li class="to-field">
                        <input type="text" name="var_pb_blog_title[]" class="txtfield" value="<?php echo htmlspecialchars($var_pb_blog_title)?>" />
                    </li>                    
                </ul>
               	<ul class="form-elements noborder">
                  <li class="to-label"><label>Blog View</label></li>
                  <li class="to-field">
                      <select name="var_pb_blog_view[]" class="dropdown" >
                          <option <?php if($var_pb_blog_view=='blog-large')echo "selected"?> value="blog-large">Large</option>
                          <option <?php if($var_pb_blog_view=='blog-medium')echo "selected"?> value="blog-medium">Medium</option>
                          <option <?php if($var_pb_blog_view=='blog-grid')echo "selected"?> value="blog-grid">Grid</option>
                          <option <?php if($var_pb_blog_view=='blog-carousel')echo "selected"?> value="blog-carousel">Slider</option>
                      </select>
                  </li>
              	</ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Choose Category</label></li>
                    <li class="to-field">
                        <select name="var_pb_blog_cat[]" class="dropdown">
                        	<option value="0">-- All Categories --</option>
							<?php show_all_cats('', '', $var_pb_blog_cat, "category");?>
                        </select>
                    </li>                                        
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Length of Excerpt</label></li>
                    <li class="to-field">
                        <input type="text" name="var_pb_blog_excerpt[]" class="txtfield" value="<?php echo $var_pb_blog_excerpt;?>" />
                        <p>Enter number of character for short description text.</p>
                    </li>                         
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Choose Featured Category</label></li>
                    <li class="to-field">
                        <select name="var_pb_featured_cat[]" class="dropdown">
                        	<option value="">-- Select Category --</option>
							<?php show_all_cats('', '', $var_pb_featured_cat, "category");?>
                        </select>
                         <p>Latest 3 posts will be shown in slider form.</p>
                    </li>                                        
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Pagination</label></li>
                    <li class="to-field">
                        <select name="var_pb_blog_pagination[]" class="dropdown" >
                            <option <?php if($var_pb_blog_pagination=="Show Pagination")echo "selected";?> >Show Pagination</option>
                            <option <?php if($var_pb_blog_pagination=="Single Page")echo "selected";?> >Single Page</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>No. of Post Per Page (leave blank To display all) </label></li>
                    <li class="to-field">
                    	<input type="text" name="var_pb_blog_num_post[]" class="txtfield" value="<?php echo $var_pb_blog_num_post; ?>" />
                    </li>
                </ul>
                 <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="px_orderby[]" value="blog" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$px_counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_px_pb_blog', 'px_pb_blog');
// blog html form for page builder end

// event html form for page builder start
function px_pb_event($die = 0){
	global $px_node, $px_count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$px_counter = $_POST['counter'];
		$event_element_size = '50';
		$var_pb_event_title = '';
 		$var_pb_event_type = '';
		$var_pb_event_category = '';
		$var_pb_event_pagination = '';
		$var_pb_event_per_page = get_option("posts_per_page");
		$var_pb_featured_post = '';
		$var_pb_featuredevent_title ='';
		$var_pb_event_filterable = '';
	}
	else {
		$name = $px_node->getName();
			$px_count_node++;
			$event_element_size = $px_node->event_element_size;
			$var_pb_event_title = $px_node->var_pb_event_title;
 			$var_pb_event_type = $px_node->var_pb_event_type;
			$var_pb_event_category = $px_node->var_pb_event_category;
			$var_pb_event_pagination = $px_node->var_pb_event_pagination;
			$var_pb_event_per_page = $px_node->var_pb_event_per_page;
			$px_counter = $post->ID.$px_count_node;
			$var_pb_featured_post = $px_node ->var_pb_featured_post;
			$var_pb_featuredevent_title = $px_node ->var_pb_featuredevent_title;
			$var_pb_event_filterable = $px_node->var_pb_event_filterable;
}
?> 
	<div id="<?php echo $name.$px_counter?>_del" class="column  parentdelete column_<?php echo $event_element_size?>" item="event" data="<?php echo element_size_data_array_index($event_element_size)?>" >
		<?php px_element_setting($name,$px_counter,$event_element_size);?>
		<div class="poped-up" id="<?php echo $name.$px_counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Event Options</h5>
                <a href="javascript:show_all('<?php echo $name.$px_counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Event Section Title</label></li>
                    <li class="to-field">
                        <input type="text" name="var_pb_event_title[]" class="txtfield" value="<?php echo htmlspecialchars($var_pb_event_title)?>" />
                    </li>
                </ul>
                <ul class="form-elements" id="px_featured_post">
                    <li class="to-label"><label>Featured Event Category</label></li>
                    <li class="to-field">
                    	<select name="var_pb_featured_post[]" class="dropdown">
                        	<option value="0">-- Select Categories--</option>
                            <?php show_all_cats('', '', $var_pb_featured_post, "event-category");?>
                        </select>
                    </li>                                        
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Featured Event Title</label></li>
                    <li class="to-field">
                        <input type="text" name="var_pb_featuredevent_title[]" class="txtfield" value="<?php echo htmlspecialchars($var_pb_featuredevent_title)?>" />
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Select event type</label></li>
                    <li class="to-field">
                        <select name="var_pb_event_type[]" class="dropdown">
                            <option <?php if($var_pb_event_type=="All")echo "selected";?> >All</option>
                            <option <?php if($var_pb_event_type=="Fixtures")echo "selected";?> >Fixtures</option>
                            <option <?php if($var_pb_event_type=="Results")echo "selected";?> >Results</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Select Category</label></li>
                    <li class="to-field">
                        <select name="var_pb_event_category[]" class="dropdown">
                        	<option value="0" <?php if($var_pb_event_category=="0")echo "selected";?>>-- Select Categories --</option>
                        	<option value="All" <?php if($var_pb_event_category=="All")echo "selected";?>>-- All Categories --</option>
                            <?php show_all_cats('', '', $var_pb_event_category, "event-category");?>
                        </select>
                    </li>
                </ul>
                 <ul class="form-elements">
                    <li class="to-label"><label>Filterable</label></li>
                    <li class="to-field">
                        <select name="var_pb_event_filterable[]" class="dropdown" >
                            <option <?php if($var_pb_event_filterable=="Yes")echo "selected";?> >Yes</option>
                            <option <?php if($var_pb_event_filterable=="No")echo "selected";?> >No</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Pagination</label></li>
                    <li class="to-field">
                        <select name="var_pb_event_pagination[]" class="dropdown" >
                            <option <?php if($var_pb_event_pagination=="Show Pagination")echo "selected";?> >Show Pagination</option>
                            <option <?php if($var_pb_event_pagination=="Single Page")echo "selected";?> >Single Page</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>No. of Events Per Page (Leave this field blank To display all records, ) </label></li>
                    <li class="to-field">
                        <input type="text" name="var_pb_event_per_page[]" class="txtfield" value="<?php echo $var_pb_event_per_page; ?>" />
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="px_orderby[]" value="event" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$px_counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_px_pb_event', 'px_pb_event');
// event html form for page builder end

// fixtures html form for page builder start
function px_pb_fixtures($die = 0){
	global $px_node, $px_count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$px_counter = $_POST['counter'];
		$upcoming_fixtures_element_size = '33';
		$var_pb_fixtures_cat = '';
		$var_pb_fixtures_view = '';
		$var_pb_fixtures_title ='';
		$var_pb_fixtures_viewall_title = 'View All';
		$var_pb_fixtures_viewall_link = '#';
		$var_pb_fixtures_per_page = '';
	}
	else {
		$name = $px_node->getName();
			$px_count_node++;
			$upcoming_fixtures_element_size = $px_node->fixtures_element_size;
			$var_pb_fixtures_title = $px_node->var_pb_fixtures_title;
			$var_pb_fixtures_view = $px_node->var_pb_fixtures_view;
 			$var_pb_fixtures_cat = $px_node ->var_pb_fixtures_cat;
			$var_pb_fixtures_per_page = $px_node->var_pb_fixtures_per_page;
			$var_pb_fixtures_viewall_title = $px_node ->var_pb_fixtures_viewall_title;
			$var_pb_fixtures_viewall_link = $px_node ->var_pb_fixtures_viewall_link;
			$px_counter = $post->ID.$px_count_node;
			if(empty($upcoming_fixtures_element_size)){$upcoming_fixtures_element_size = 33;}
			
}
?> 
	<div id="<?php echo $name.$px_counter?>_del" class="column  parentdelete column_<?php echo $upcoming_fixtures_element_size?>" item="fixtures" data="<?php echo element_size_data_array_index($upcoming_fixtures_element_size)?>" >
		<?php px_element_setting($name,$px_counter,$upcoming_fixtures_element_size);?>
		<div class="poped-up" id="<?php echo $name.$px_counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Fixtures Options</h5>
                <a href="javascript:show_all('<?php echo $name.$px_counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Featured Title</label></li>
                    <li class="to-field">
                        <input type="text" name="var_pb_fixtures_title[]" class="txtfield" value="<?php echo htmlspecialchars($var_pb_fixtures_title)?>" />
                    </li>
                </ul>
                 <ul class="form-elements" id="var_pb_fixtures_view">
                    <li class="to-label"><label>Feature View</label></li>
                    <li class="to-field">
                    	<select name="var_pb_fixtures_view[]" class="dropdown" onchange="px_upcomingfixture_toggle(this.value, '<?php echo $px_counter?>')">
                            <option <?php if($var_pb_fixtures_view=='list')echo "selected"?> value="list">List Fixture</option>
                            <option <?php if($var_pb_fixtures_view=='countdown')echo "selected"?> value="countdown">Countdown Fixture</option>

                         </select>
                    </li>                                        
                </ul>
                 <ul class="form-elements">
                  <li class="to-label"><label>Featured Category</label></li>
                    <li class="to-field">
                    	<select name="var_pb_fixtures_cat[]" class="dropdown">
                        	<option value="0">-- Select Categories--</option>
                            <?php show_all_cats('', '', $var_pb_fixtures_cat, "event-category");?>
                        </select>
                    </li>  
                 </ul>
                <ul class="form-elements" id="upcomingfixtures_<?php echo $px_counter; ?>" style="display:<?php if($var_pb_fixtures_view == "list"){echo 'inline-block';}else{ echo 'none';}?>" >
                    
                     <li class="to-label"><label>No. of Events Per Page (Leave this field blank To display all records, ) </label></li>
                    <li class="to-field">
                        <input type="text" name="var_pb_fixtures_per_page[]" class="txtfield" value="<?php echo $var_pb_fixtures_per_page; ?>" />
                    </li>
                 
                    <li class="to-label"><label>View All Title</label></li>
                    <li class="to-field">
                        <input type="text" name="var_pb_fixtures_viewall_title[]" class="txtfield" value="<?php echo htmlspecialchars($var_pb_fixtures_viewall_title)?>" />
                    </li>
                 
                    <li class="to-label"><label>View All link</label></li>
                    <li class="to-field">
                        <input type="text" name="var_pb_fixtures_viewall_link[]" class="txtfield" value="<?php echo htmlspecialchars($var_pb_fixtures_viewall_link)?>" />
                    </li>
                </ul>
                
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="px_orderby[]" value="fixtures" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$px_counter?>')" />
                    </li>
                </ul>
                
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_px_pb_fixtures', 'px_pb_fixtures');
// fixtures html form for page builder end

// event html form for page builder end
// contact us html form for page builder start
function px_pb_contact($die = 0){
	global $px_node, $px_count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$px_counter = $_POST['counter'];
		$contact_element_size = '50';
 		$px_contact_email_db = '';
		$px_contact_succ_msg_db = '';
		$px_contact_form_title = '';
		
	}
	else {
		$name = $px_node->getName();
			$px_count_node++;
			$contact_element_size = $px_node->contact_element_size;
 			$px_contact_email_db = $px_node->px_contact_email;
			$px_contact_form_title = $px_node->px_contact_form_title;
			$px_contact_succ_msg_db = $px_node->px_contact_succ_msg;
			$px_counter = $post->ID.$px_count_node;
}
?> 
	<div id="<?php echo $name.$px_counter?>_del" class="column  parentdelete column_<?php echo $contact_element_size?>" item="contact" data="<?php echo element_size_data_array_index($contact_element_size)?>" >
		<?php px_element_setting($name,$px_counter,$contact_element_size);?>
		<div class="poped-up" id="<?php echo $name.$px_counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Contact Form</h5>
                <a href="javascript:show_all('<?php echo $name.$px_counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	
               	<ul class="form-elements noborder">
                    <li class="to-label"><label>Contact Title</label></li>
                    <li class="to-field">
                        <input type="text" name="px_contact_form_title[]" class="txtfield" value="<?php echo $px_contact_form_title;?>" />
                    </li>                    
                </ul>
				<ul class="form-elements noborder">
                    <li class="to-label"><label>Recipient Email</label></li>
                    <li class="to-field">
                        <input type="text" name="px_contact_email[]" class="txtfield" value="<?php if($px_contact_email_db=="") echo get_option("admin_email"); else echo $px_contact_email_db;?>" />
                    </li>                    
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label>Successful Message</label></li>
                    <li class="to-field"><textarea name="px_contact_succ_msg[]"><?php if($px_contact_succ_msg_db=="")echo "Email Sent Successfully.\nThank you, your message has been submitted to us."; else echo $px_contact_succ_msg_db;?></textarea></li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="px_orderby[]" value="contact" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$px_counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_px_pb_contact', 'px_pb_contact');
// contact us html form for page builder end
// column html form for page builder start
function px_pb_column($die = 0){
	global $px_node, $px_count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$px_counter = $_POST['counter'];
		$column_element_size = '25';
		$column_text = '';
		$column_donate_text = '';
		$column_donate_url = '';
	}
	else {
		$name = $px_node->getName();
			$px_count_node++;
			$column_element_size = $px_node->column_element_size;
			$column_text = $px_node->column_text;
			$column_donate_text = $px_node->column_donate_text;
			$column_donate_url = $px_node->column_donate_url;
				$px_counter = $post->ID.$px_count_node;
}
?> 
	<div id="<?php echo $name.$px_counter?>_del" class="column  parentdelete column_<?php echo $column_element_size?>" item="column" data="<?php echo element_size_data_array_index($column_element_size)?>" >
    	<?php px_element_setting($name,$px_counter,$column_element_size);?>
		<div class="poped-up" id="<?php echo $name.$px_counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Column Options</h5>
                <a href="javascript:show_all('<?php echo $name.$px_counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Column Text</label></li>
                    <li class="to-field">
                    	<textarea name="column_text[]"><?php echo $column_text?></textarea>
                        <p>Shortcodes and HTML tags allowed.</p>
                    </li>                  
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Donate Button Text</label></li>
                    <li class="to-field">
                        <input type="text" name="column_donate_text[]" class="txtfield" value="<?php echo $column_donate_text;?>" />
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Donate Button Link</label></li>
                    <li class="to-field">
                        <input type="text" name="column_donate_url[]" class="txtfield" value="<?php echo $column_donate_url;?>" />
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="px_orderby[]" value="column" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$px_counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_px_pb_column', 'px_pb_column');
// column html form for page builder end 
// Team page element
function px_pb_team($die = 0){
	global $px_node, $px_count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$px_counter = $_POST['counter'];
		$team_element_size = '75';
		$team_title = '';
		$var_pb_team_cat = array();
		$var_pb_team_multicat = '';
		$team_pagination = '';
		$team_page_num = '';
		$team_view = '';
		$team_orderby = '';
	}
	else {
		$name = $px_node->getName();
			//$count_node++;
			$px_count_node++;
			$team_element_size = $px_node->team_element_size;
			$team_title = $px_node->team_title;
			$var_pb_team_cat = $px_node->var_pb_team_cat;
			 $var_pb_team_multicat = $px_node->var_pb_team_cat;
			if(isset($var_pb_team_cat) && $var_pb_team_cat <> ''){
				$var_pb_team_cat = explode(',', $var_pb_team_cat);
			} else {
				$var_pb_team_cat = array();
			}
			$team_view = $px_node->team_view;
			$team_pagination = $px_node->team_pagination;
			$team_page_num = $px_node->team_page_num;
			$team_orderby = $px_node->team_orderby;
			$px_counter = $post->ID.$px_count_node;
}
?> 
	<div id="<?php echo $name.$px_counter?>_del" class="column parentdelete column_<?php echo $team_element_size?>" item="team" data="<?php echo element_size_data_array_index($team_element_size)?>" >
    	<?php px_element_setting($name,$px_counter,$team_element_size);?>
       	<div class="poped-up" id="<?php echo $name.$px_counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit team Options</h5>
                <a href="javascript:show_all('<?php echo $name.$px_counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements  noborder">
                    <li class="to-label"><label>Team Header Title</label></li>
                    <li class="to-field">
                        <input type="text" name="team_title[]" class="txtfield" value="<?php echo $team_title?>" />
                    </li>                    
                </ul>
                 <ul class="form-elements noborder">
                    <li class="to-label"><label>Choose category</label></li>
                    <li class="to-field">
                         <select id="var_pb_select_team<?php echo $px_counter; ?>" name="var_pb_team_cat[]" multiple="multiple" style="min-height:100px;">
                        	<option value="">-- Select Teams --</option>
                        	 <?php
								$categories = get_categories( array('taxonomy' => 'team-category', 'hide_empty' => 0) );
									foreach ($categories as $category) {
									?>
									<option <?php if (in_array($category->term_id, $var_pb_team_cat)){echo 'selected="selected"';} ?> value="<?php echo $category->term_id ?>">
										<?php echo $category->cat_name?>
                                    </option>
									<?php
									}
								?> 
                        </select>
                        
                        <script>
						jQuery(document).ready(function($) {
                        	jQuery("#var_pb_select_team<?php echo $px_counter; ?>").change(function () {
						  		jQuery("#var_pb_team_multicat<?php echo $px_counter; ?> ").val(jQuery(this).val());
 							});
						});
                        </script>
                        <input type="hidden" value="<?php echo $var_pb_team_multicat; ?>" id="var_pb_team_multicat<?php echo $px_counter; ?>" name="var_pb_team_multicat[]" />
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label>Team View</label></li>
                    <li class="to-field">
                        <select name="team_view[]" class="dropdown" onchange="px_team_toggle(this.value, '<?php echo $px_counter?>')">
                            <option <?php if($team_view=="Grid View")echo "selected";?> >Grid View</option>
                            <option <?php if($team_view=="Carousal View")echo "selected";?> >Carousal View</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements noborder" id="department<?php echo $px_counter?>" style="display:<?php if($team_view == "Carousal View"){echo 'none;';}?>" >
                    <li class="to-label"><label>OrderBy Department</label></li>
                    <li class="to-field">
                        <select name="team_orderby[]" class="dropdown"  >
                            <option <?php if($team_orderby=="Yes")echo "selected";?> >Yes</option>
                            <option <?php if($team_orderby=="No")echo "selected";?> >No</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements noborder" >
                    <li class="to-label"><label>Pagination</label></li>
                    <li class="to-field">
                        <select name="team_pagination[]" class="dropdown" >
                            <option <?php if($team_pagination=="Show Pagination")echo "selected";?> >Show Pagination</option>
                            <option <?php if($team_pagination=="Single Page")echo "selected";?> >Single Page</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label>Records Per Page</label></li>
                    <li class="to-field"><input type="text" name="team_page_num[]" class="txtfield" value="<?php if($team_page_num=="")echo "5"; else echo $team_page_num;?>" /></li>
                </ul>
                
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="px_orderby[]" value="team" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$px_counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_px_pb_team', 'px_pb_team');
// portfolio html form for page builder end

// google map html form for page builder start
function px_pb_map($die = 0){
	global $px_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$px_counter = $_POST['counter'];
		$map_element_size = '25';
		$map_title = '';
		$map_height = '';
		$map_lat = '';
		$map_lon = '';
		$map_zoom = '';
		$map_type = '';
		$map_info = '';
		$map_info_width = '';
		$map_info_height = '';
		$map_marker_icon = '';
		$map_show_marker = '';
		$map_controls = '';
		$map_draggable = '';
		$map_scrollwheel = '';
		$map_text= '';
	}
	else {
		$name = $px_node->getName();
			$count_node++;
			$map_element_size = $px_node->map_element_size;
			$map_title 	= $px_node->map_title;
			$map_height = $px_node->map_height;
			$map_lat 	= $px_node->map_lat;
			$map_lon 	= $px_node->map_lon;
			$map_zoom 	= $px_node->map_zoom;
			$map_type = $px_node->map_type;
			$map_info = $px_node->map_info;
			$map_info_width = $px_node->map_info_width;
			$map_info_height = $px_node->map_info_height;
			$map_marker_icon = $px_node->map_marker_icon;
			$map_show_marker = $px_node->map_show_marker;
			$map_controls = $px_node->map_controls;
			$map_draggable = $px_node->map_draggable;
			$map_scrollwheel = $px_node->map_scrollwheel;
			$map_text 	= $px_node->map_text;
			$px_counter 	= $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$px_counter?>_del" class="column  parentdelete column_<?php echo $map_element_size?>" item="map" data="<?php echo element_size_data_array_index($map_element_size)?>" >
    	<?php px_element_setting($name,$px_counter,$map_element_size);?>
    	
       	<div class="poped-up" id="<?php echo $name.$px_counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Map Options</h5>
                <a href="javascript:show_all('<?php echo $name.$px_counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements noborder">
                    <li class="to-label"><label>Title</label></li>
                    <li class="to-field"><input type="text" name="map_title[]" class="txtfield" value="<?php echo $map_title?>" /></li>
                </ul>
				<ul class="form-elements noborder">
                    <li class="to-label"><label>Map Height</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_height[]" class="txtfield" value="<?php echo $map_height?>" />
                        <p>Info Max Height in PX (Default is 200)</p>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label>Latitude</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_lat[]" class="txtfield" value="<?php echo $map_lat?>" />
                        <p>Put Latitude (Default is 0)</p>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label>Longitude</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_lon[]" class="txtfield" value="<?php echo $map_lon?>" />
                        <p>Put Longitude (Default is 0)</p>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label>Zoom</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_zoom[]" class="txtfield" value="<?php echo $map_zoom?>" />
                        <p>Put Zoom Level (Default is 11)</p>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label>Map Types</label></li>
                    <li class="to-field">
                        <select name="map_type[]" class="dropdown" >
                            <option <?php if($map_type=="ROADMAP")echo "selected";?> >ROADMAP</option>
                            <option <?php if($map_type=="HYBRID")echo "selected";?> >HYBRID</option>
                            <option <?php if($map_type=="SATELLITE")echo "selected";?> >SATELLITE</option>
                            <option <?php if($map_type=="TERRAIN")echo "selected";?> >TERRAIN</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label>Info Text</label></li>
                    <li class="to-field"><input type="text" name="map_info[]" class="txtfield" value="<?php echo $map_info?>" /></li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label>Info Max Width</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_info_width[]" class="txtfield" value="<?php echo $map_info_width?>" />
                        <p>Info Max Width in PX (Default is 200)</p>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label>Info Max Height</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_info_height[]" class="txtfield" value="<?php echo $map_info_height?>" />
                        <p>Info Max Height in PX (Default is 100)</p>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label>Marker Icon Path</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_marker_icon[]" class="txtfield" value="<?php echo $map_marker_icon?>" />
                        <p>e.g. http://yourdomain.com/logo.png</p>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label>Show Marker</label></li>
                    <li class="to-field">
                        <select name="map_show_marker[]" class="dropdown" >
                            <option value="true" <?php if($map_show_marker=="true")echo "selected";?> >On</option>
                            <option value="false" <?php if($map_show_marker=="false")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label>Disable Map Controls</label></li>
                    <li class="to-field">
                        <select name="map_controls[]" class="dropdown" >
                            <option value="false" <?php if($map_controls=="false")echo "selected";?> >Off</option>
                            <option value="true" <?php if($map_controls=="true")echo "selected";?> >On</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label>Draggable</label></li>
                    <li class="to-field">
                        <select name="map_draggable[]" class="dropdown" >
                            <option value="true" <?php if($map_draggable=="true")echo "selected";?> >On</option>
                            <option value="false" <?php if($map_draggable=="false")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label>Scroll Wheel</label></li>
                    <li class="to-field">

                        <select name="map_scrollwheel[]" class="dropdown" >
                            <option value="true" <?php if($map_scrollwheel=="true")echo "selected";?> >On</option>
                            <option value="false" <?php if($map_scrollwheel=="false")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                 <ul class="form-elements noborder">
                    <li class="to-label"><label>Map Text</label></li>
                    <li class="to-field">
                    	<textarea name="map_text[]" rows="4" cols="15"><?php echo $map_text;?></textarea>
                        
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="px_orderby[]" value="map" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$px_counter?>')" />
                    </li>
                </ul>
            </div>

       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_px_pb_map', 'px_pb_map');

// page bulider items end

// side bar layout in pages, post and default page(theme options) start
function meta_layout($default_pages = ''){
	global $px_xmlObject, $post;
	if ( empty($px_xmlObject->sidebar_layout->px_layout) ) $px_layout = ""; else $px_layout = $px_xmlObject->sidebar_layout->px_layout;
	if ( empty($px_xmlObject->sidebar_layout->px_sidebar_left) ) $px_sidebar_left = ""; else $px_sidebar_left = $px_xmlObject->sidebar_layout->px_sidebar_left;
	if ( empty($px_xmlObject->sidebar_layout->px_sidebar_right) ) $px_sidebar_right = ""; else $px_sidebar_right = $px_xmlObject->sidebar_layout->px_sidebar_right;
	$px_theme_option = get_option('px_theme_option');
	
	if($default_pages == ''){
	
	if ( empty($px_xmlObject->var_post_bg_option) ||  !isset($px_xmlObject->var_post_bg_option) ) $var_post_bg_option = ""; else $var_post_bg_option = $px_xmlObject->var_post_bg_option;
	if ( empty($px_xmlObject->px_home_v2_video) ||  !isset($px_xmlObject->px_home_v2_video) ) $px_home_v2_video = ""; else $px_home_v2_video = $px_xmlObject->px_home_v2_video;
	if ( empty($px_xmlObject->px_home_v2_video_mute) ||  !isset($px_xmlObject->px_home_v2_video_mute) ) $px_home_v2_video_mute = ""; else $px_home_v2_video_mute = $px_xmlObject->px_home_v2_video_mute;
	if ( empty($px_xmlObject->bg_image) ||  !isset($px_xmlObject->bg_image) ) $bg_image = ""; else $bg_image = $px_xmlObject->bg_image;
	if ( empty($px_xmlObject->bg_color) ||  !isset($px_xmlObject->bg_color) ) $bg_color = $px_theme_option['bg_color']; else $bg_color = $px_xmlObject->bg_color;
  ?>
	<script type="text/javascript">
         jQuery(document).ready(function($){
            $('.bg_color').wpColorPicker(); 
        });
    </script>
   <div class="id_page_background">
  			<div class="opt-head">
              <h4>Background Options</h4>
              <div class="clear"></div>
            </div>
            <div class="clear"></div>
            <div class="message-box">
                <div class="messagebox alert alert-info">
                    <button type="button" class="close" data-dismiss="alert"><em class="fa fa-times"></em></button>
                    <div class="masg-text">
                        <p>User can select page background in this area, also if "Default Theme options Background" is selected then the Theme options Background settings will apply for page background. These default options can be set here Theme options > General Settings.</p>
                    </div>
                </div>
            </div>
              <ul class="form-elements">
                    <li class="to-field  noborder">
                        <select name="var_post_bg_option" class="dropdown"  onchange="javascript:px_toggle_bg_options(this.value)">
                        	<option <?php if($var_post_bg_option=='default-options') echo "selected";?> value="default-options"> Default Theme options background</option>
                            <option <?php if($var_post_bg_option=='custom-background-image') echo "selected";?> value="custom-background-image"> Custom Background Image</option>
                        	<option <?php if($var_post_bg_option=='no-image') echo "selected";?> value="no-image"> No Image</option>
                            <option value="background_video" <?php if($var_post_bg_option=='background_video')echo "selected";?> >Video</option>
                        </select>
                         <p>Please select Background options</p>
                    </li>
                </ul>
                <div class="form-elements meta-body  noborder" style=" <?php if($var_post_bg_option == "background_video"){echo "display:block";}else echo "display:none";?>" id="home_v2" >
            	
                	<ul class="form-elements noborder">
                        <li class="to-field">
                            <input type="text" name="px_home_v2_video" class="txtfield" value="<?php echo htmlspecialchars($px_home_v2_video)?>" />
                            <p>Please enter Video URL.</p>
                        </li>                    
                	</ul>
                	<ul class="form-elements noborder">
                        <li class="to-field">
                            <select name="px_home_v2_video_mute" class="dropdown">
                                 <option value="Yes" <?php if($px_home_v2_video_mute == "Yes"){ echo 'selected';}?>> Yes</option>
                                 <option value="No" <?php if($px_home_v2_video_mute == "No"){ echo 'selected';}?>> No</option>
                            </select>
                            <p>Choose Mute</p>
                        </li>                                        
                    </ul>
                	
            </div>
                <!-- end home v2--->	
                <div class="form-elements meta-body noborder" style=" <?php if($var_post_bg_option == "custom-background-image"){echo "display:block";}else echo "display:none";?>" id="home_v3" >
                    
                     <ul class="form-elements">
                        <li class="to-field">
                        	<input id="bg_image" name="bg_image" value="<?php echo $bg_image;?>" type="text" class="small" />
                			<input id="bg_image" name="bg_image" type="button" class="uploadfile left" value="Browse" />
                            <?php if ( $bg_image <> "" ) { ?>
                            <div class="thumb-preview" id="bg_image_img_div"> <img width="400" height="200" src="<?php echo $bg_image?>" /> <a href="javascript:remove_image('bg_image')" class="del">&nbsp;</a> </div>
                            <?php } ?>
                             <p>Background Image</p>
                        </li>
                    </ul>
                  
                </div>
                <!-- end Custom image-->	
        
            <ul class="form-elements noborder">
              <li class="to-field">
                <input type="text" name="bg_color" value="<?php echo $bg_color?>" class="bg_color" data-default-color="" />
                <p>Background Color</p>
              </li>
            </ul>
            <input type="hidden" name="px_orderby[]" value="meta_layout" />
            <div class="clear"></div>
        </div>  
      <?php }else{ ?>
		<input type="hidden" name="theme_default_pages_option" value="1" />	  
	 <?php } ?>  
        <div class="elementhidden">
        <div class="clear"></div>
    	<div class="opt-head">
            <h4>Layout Options</h4>
            <div class="clear"></div>
        </div>
        <ul class="form-elements">
            <li class="to-label">
                <label>Select Layout</label>
            </li>
            <li class="to-field">
                <div class="meta-input">
                    <div class='radio-image-wrapper'>
                        <input <?php if($px_layout=="none")echo "checked"?> onclick="show_sidebar('none')" type="radio" name="px_layout" class="radio" value="none" id="radio_1" />
                        <label for="radio_1">
                            <span class="ss"><span class="cs-sidebar-none"></span></span>
                            <span <?php if($px_layout=="none")echo "class='check-list'"?> id="check-list"></span>
                        </label>
                    </div>
                    <div class='radio-image-wrapper'>
                        <input <?php if($px_layout=="right")echo "checked"?> onclick="show_sidebar('right')" type="radio" name="px_layout" class="radio" value="right" id="radio_2"  />
                        <label for="radio_2">
                            <span class="ss"><span class="cs-sidebar-right"></span></span>
                            <span <?php if($px_layout=="right")echo "class='check-list'"?> id="check-list"></span>
                        </label>
                    </div>
                    <div class='radio-image-wrapper'>
                        <input <?php if($px_layout=="left")echo "checked"?> onclick="show_sidebar('left')" type="radio" name="px_layout" class="radio" value="left" id="radio_3" />
                        <label for="radio_3">
                            <span class="ss"><span class="cs-sidebar-left"></span></span>
                            <span <?php if($px_layout=="left")echo "class='check-list'"?> id="check-list"></span>
                        </label>
                    </div>
                 </div>
            </li>
        </ul>
        <ul class="form-elements meta-body" style=" <?php if($px_sidebar_left == ""){echo "display:none";}else echo "display:block";?>" id="sidebar_left" >
            <li class="to-label">
                <label>Select Left Sidebar</label>
            </li>
            <li class="to-field">
                <select name="px_sidebar_left" class="select_dropdown" id="page-option-choose-left-sidebar">
                    <?php
                    $px_theme_option = get_option('px_theme_option');
                    if ( isset($px_theme_option['sidebar']) and count($px_theme_option['sidebar']) > 0 ) {
                        foreach ( $px_theme_option['sidebar'] as $sidebar ){
                        ?>
                            <option <?php if ($px_sidebar_left==$sidebar)echo "selected";?> ><?php echo $sidebar;?></option>
                        <?php
                        }
                    }
                    ?>
                </select>
            </li>
        </ul>
        <ul class="form-elements meta-body" style=" <?php if($px_sidebar_right == ""){echo "display:none";}else echo "display:block";?>" id="sidebar_right" >
            <li class="to-label">
                <label>Select Right Sidebar</label>
            </li>
            <li class="to-field">
                <select name="px_sidebar_right" class="select_dropdown" id="page-option-choose-right-sidebar">
                    <?php
                    if ( isset($px_theme_option['sidebar']) and count($px_theme_option['sidebar']) > 0 ) {
                        foreach ( $px_theme_option['sidebar'] as $sidebar ){
                        ?>
                            <option <?php if ($px_sidebar_right==$sidebar)echo "selected";?> ><?php echo $sidebar;?></option>
                        <?php
                        }
                    }
                    ?>
                </select>
                <input type="hidden" name="px_orderby[]" value="meta_layout" />
            </li>
        </ul>
	</div> 
       <?php 
}
// side bar layout in pages, post and default page(theme options) end

function element_size_data_array_index($size){
	if ( $size == "" or $size == 100 ) return 0;
	else if ( $size == 75 ) return 1;
	else if ( $size == 67 ) return 2;
	else if ( $size == 50 ) return 3;
	else if ( $size == 33 ) return 4;
	else if ( $size == 25 ) return 5;
}
// Show all Categories
function show_all_cats($parent, $separator, $selected = "", $taxonomy) {
    if ($parent == "") {
        global $wpdb;
        $parent = 0;
    }
    else
        $separator .= " &ndash; ";
    $args = array(
        'parent' => $parent,
        'hide_empty' => 0,
        'taxonomy' => $taxonomy
    );
    $categories = get_categories($args);
    foreach ($categories as $category) {
        ?>
        <option <?php if ($selected == $category->slug) echo "selected"; ?> value="<?php echo $category->slug ?>"><?php echo $separator . $category->cat_name ?></option>
        <?php
        show_all_cats($category->term_id, $separator, $selected, $taxonomy);
    }
}
// Events Meta data save
function events_meta_save($post_id) {
    global $wpdb;
    if (empty($_POST["var_pb_event_team1"])){ $_POST["var_pb_event_team1"] = "";}
	if (empty($_POST["var_pb_event_team2"])){ $_POST["var_pb_event_team2"] = "";}
	if (empty($_POST["event_social_sharing"])){ $_POST["event_social_sharing"] = "";}
	if (empty($_POST["event_buy_now"])){ $_POST["event_buy_now"] = "";}
	if (empty($_POST["event_time"])){ $_POST["event_time"] = "";}
     if (empty($_POST["event_all_day"])){ $_POST["event_all_day"] = "";}
    if (empty($_POST["event_address"])){ $_POST["event_address"] = "";}
	if (empty($_POST["event_gallery"])){ $_POST["event_gallery"] = "";}
	if (empty($_POST["event_score"])){ $_POST["event_score"] = "";}
	if (empty($_POST["event_summary"])){ $_POST["event_summary"] = "";}
 	if (empty($_POST["event_ticket_options"])){ $_POST["event_ticket_options"] = "";}
	if (empty($_POST["var_pb_event_author"])){ $_POST["var_pb_event_author"] = "";}
	if (empty($_POST["event_ticket_color"])){ $_POST["event_ticket_color"] = "";}
	if (empty($_POST["event_venue"])){ $_POST["event_venue"] = "";}
	if (empty($_POST["event_result"])){ $_POST["event_result"] = "";}
    	
    $sxe = new SimpleXMLElement("<event></event>");
		$sxe->addChild('var_pb_event_team1', $_POST["var_pb_event_team1"]);
		$sxe->addChild('var_pb_event_team2', $_POST["var_pb_event_team2"]);
		$sxe->addChild('event_social_sharing', $_POST["event_social_sharing"]);
		$sxe->addChild('event_buy_now', $_POST["event_buy_now"]);
		$sxe->addChild('event_ticket_options', $_POST["event_ticket_options"]);
 		$sxe->addChild('event_time', $_POST["event_time"]);
 		$sxe->addChild('event_all_day', $_POST["event_all_day"]);
 		$sxe->addChild('event_address', $_POST["event_address"]);
		$sxe->addChild('event_gallery', $_POST["event_gallery"]);
		$sxe->addChild('event_result', $_POST["event_result"]);
		$sxe->addChild('event_score', $_POST["event_score"]);
		$sxe->addChild('event_summary', $_POST["event_summary"]);
		$sxe->addChild('event_venue', $_POST["event_venue"]);
 		$sxe->addChild('var_pb_event_author', $_POST["var_pb_event_author"]);
		$sxe->addChild('event_ticket_color', $_POST["event_ticket_color"]);
    $sxe = save_layout_xml($sxe);
    update_post_meta($post_id, 'px_event_meta', $sxe->asXML());
}

// Default xml data save
function save_layout_xml($sxe) {
     
	if (empty($_POST['page_title']))
        $_POST['page_title'] = "";
    if (empty($_POST['px_layout']))
        $_POST['px_layout'] = "";
    if (empty($_POST['px_sidebar_left']))
        $_POST['px_sidebar_left'] = "";
    if (empty($_POST['px_sidebar_right']))
        $_POST['px_sidebar_right'] = "";
	if(!isset($_POST['theme_default_pages_option'])){
		if ( empty($_POST['var_post_bg_option']) ) $var_post_bg_option = ""; else $var_post_bg_option = $_POST['var_post_bg_option'];
		if ( empty($_POST['px_home_v2_video']) ) $_POST['px_home_v2_video'] = ""; else $_POST['px_home_v2_video'] = $_POST['px_home_v2_video'];
		if ( empty($_POST['px_home_v2_video_mute']) ) $_POST['px_home_v2_video_mute'] = ""; else $_POST['px_home_v2_video_mute'] = $_POST['px_home_v2_video_mute'];
		if ( empty($_POST['bg_image']) ) $_POST['bg_image'] = ""; else $_POST['bg_image'] = $_POST['bg_image'];

		if ( empty($_POST['bg_color']) ) $_POST['bg_color'] = ""; else $_POST['bg_color'] = $_POST['bg_color'];
			$sxe->addChild('var_post_bg_option', $var_post_bg_option);
			if($var_post_bg_option=='background_video'){
				$sxe->addChild('px_home_v2_video', $_POST['px_home_v2_video']);
				$sxe->addChild('px_home_v2_video_mute', $_POST['px_home_v2_video_mute']);
			}  else if($var_post_bg_option=='custom-background-image'){
				$sxe->addChild('bg_image', $_POST['bg_image']);
			}
			$sxe->addChild('bg_color', $_POST['bg_color']);
	}
		
	$sidebar_layout = $sxe->addChild('sidebar_layout');
		$sidebar_layout->addChild('px_layout', $_POST["px_layout"]);
		if ($_POST["px_layout"] == "left") {
			$sidebar_layout->addChild('px_sidebar_left', $_POST['px_sidebar_left']);
		} else if ($_POST["px_layout"] == "right") {
			$sidebar_layout->addChild('px_sidebar_right', $_POST['px_sidebar_right']);
		}else if ($_POST["px_layout"] == "both_right" or $_POST["px_layout"] == "both_left" or $_POST["px_layout"] == "both") {
			$sidebar_layout->addChild('px_sidebar_left', $_POST['px_sidebar_left']);
			$sidebar_layout->addChild('px_sidebar_right', $_POST['px_sidebar_right']);
		}	
    return $sxe;
}
// Sermon page builder function
function px_pb_pointtable($die = 0){
	global $px_node, $var_pb_pointtable_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$var_pb_sermon_counter = $_POST['counter'];
		$pointtable_element_size = '50';
		$var_pb_pointtable_cat = '';
		$var_pb_pointtable_title = '';
		$var_pb_pointtable_viewall ='';
		$var_pb_pointtable_filterable = '';
  		$var_pb_pointtable_per_page = get_option("posts_per_page");
	}
	else {
		$name = $px_node->getName();
			$px_node++;
			$pointtable_element_size = $px_node->pointtable_element_size;
			$var_pb_pointtable_title = $px_node->var_pb_pointtable_title;
			$var_pb_pointtable_cat = $px_node->var_pb_pointtable_cat;
 			$var_pb_pointtable_filterable = $px_node->var_pb_pointtable_filterable;
  			$var_pb_pointtable_per_page = $px_node->var_pb_pointtable_per_page;
			$var_pb_sermon_counter = $post->ID.$px_node;
	}
?> 
	<div id="<?php echo $name.$var_pb_sermon_counter?>_del" class="column parentdelete column_<?php echo $pointtable_element_size?>" item="album" data="<?php echo element_size_data_array_index($pointtable_element_size)?>" >
		<?php px_element_setting($name,$var_pb_sermon_counter,$pointtable_element_size);?>
        <div class="poped-up" id="<?php echo $name.$var_pb_sermon_counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Point Table Options</h5>
                <a href="javascript:show_all('<?php echo $name.$var_pb_sermon_counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">	
            	<ul class="form-elements">
                    <li class="to-label"><label><p>Point Table Section Title</p></label></li>
                    <li class="to-field">
                        <input type="text" name="var_pb_pointtable_title[]" class="txtfield" value="<?php echo htmlspecialchars($var_pb_pointtable_title)?>" />
                    </li>                                            
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Choose category to show Point Table</label></li>
                    <li class="to-field">
                        <select name="var_pb_pointtable_cat[]" class="dropdown">
                        	<option value="">-- All Categories --</option>
                        	<?php show_all_cats('', '', $var_pb_pointtable_cat, "season-category");?>
                        </select>
                        
                    </li>
                </ul>
                
                <ul class="form-elements">
                    <li class="to-label"><label>Filterable</label></li>
                    <li class="to-field">
                        <select name="var_pb_pointtable_filterable[]" class="dropdown">
                            <option <?php if($var_pb_pointtable_filterable=="Off")echo "selected";?> >Off</option>
                            <option <?php if($var_pb_pointtable_filterable=="On")echo "selected";?> >On</option>
                        </select>
                    </li>
                </ul>
                 <ul class="form-elements">
                    <li class="to-label"><label>No. of Tables Per Page</label></li>
                    <li class="to-field">
                        <input type="text" name="var_pb_pointtable_per_page[]" class="txtfield" value="<?php echo $var_pb_pointtable_per_page;?>" />
                         <p>Leave empty to show all tables</p>
                    </li>
                   
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label></label></li>
                    <li class="to-field">
                    	<input type="hidden" name="px_orderby[]" value="pointtable" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$var_pb_sermon_counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_px_pb_pointtable', 'px_pb_pointtable');
// add Album tracks function
function px_add_pointtable_to_list(){
	global $counter_track, $var_pb_pointtable_team, $var_pb_match_played, $var_pb_pointtable_plusminus_points , $var_pb_pointtable_totalpoints ;
	foreach ($_POST as $keys=>$values) {
		$$keys = $values;
	}
?>
    <tr id="edit_track<?php echo $counter_track?>">
        <td id="album-title<?php echo $counter_track?>" style="width:80%;"><?php echo $var_pb_pointtable_team?></td>
        <td class="centr" style="width:20%;">
            <a href="javascript:openpopedup('edit_track_form<?php echo $counter_track?>')" class="actions edit">&nbsp;</a>
            <a onclick="javascript:return confirm('Are you sure! You want to delete.')" href="javascript:px_div_remove('edit_track<?php echo $counter_track?>')" class="actions delete">&nbsp;</a>
            <div class="poped-up" id="edit_track_form<?php echo $counter_track?>">
                <div class="opt-head">
                    <h5>Table Settings</h5>
                    <a href="javascript:closepopedup('edit_track_form<?php echo $counter_track?>')" class="closeit">&nbsp;</a>
                    <div class="clear"></div>
                </div>
                <ul class="form-elements">
                    <li class="to-label"><label>Team Name</label></li>
                    <li class="to-field">
                    	<select name="var_pb_pointtable_team[]" class="dropdown"  id="var_pb_pointtable_team<?php echo $counter_track?>">
                    		<option>-- Select Team--</option>
                           	<?php show_all_cats('', '', $var_pb_pointtable_team, "team-category");?>
                    	</select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Match Played</label></li>
                    <li class="to-field">
                        <input type="text" name="var_pb_match_played[]" value="<?php echo htmlspecialchars($var_pb_match_played)?>" id="var_pb_match_played<?php echo $counter_track?>" />
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Plus/Minus Points</label></li>
                    <li class="to-field">
                        <input id="var_pb_pointtable_plusminus_points<?php echo $counter_track?>" name="var_pb_pointtable_plusminus_points[]" value="<?php echo htmlspecialchars($var_pb_pointtable_plusminus_points)?>" type="text" class="small" />
                        
                    </li>
                </ul>
                
                <ul class="form-elements">
                    <li class="to-label"><label>Total Points</label></li>
                    <li class="to-field">
                        <input type="text" name="var_pb_pointtable_totalpoints[]" value="<?php echo htmlspecialchars($var_pb_pointtable_totalpoints)?>" />
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label></label></li>
                    <li class="to-field"><input type="button" value="Update Table" onclick="update_title(<?php echo $counter_track?>); closepopedup('edit_track_form<?php echo $counter_track?>')" /></li>
                </ul>
            </div>
        </td>
    </tr>
<?php
	if ( isset($action) ) die();
}
add_action('wp_ajax_px_add_pointtable_to_list', 'px_add_pointtable_to_list');