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
			<span class="theme-wrap"><a onclick="px_toggle('. $_POST['counter_social_network'] .')"><i class="fa fa fa-times"></i></a></span>
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
                            <option value="gallery-masonry" <?php if($px_gal_layout_db=="gallery-masonry")echo "selected";?> >Masonry</option>
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
		$var_pb_blog_cat = '';
		$var_pb_blog_num_post = get_option("posts_per_page");
		$var_pb_blog_pagination = '';
		$var_pb_blog_sidebar = '';
	}
	else {
		$name = $px_node->getName();
			$px_count_node++;
			$blog_element_size = $px_node->blog_element_size;
			$var_pb_blog_title = $px_node->var_pb_blog_title;
			$var_pb_blog_cat = $px_node->var_pb_blog_cat;
			$var_pb_blog_num_post = $px_node->var_pb_blog_num_post;
			$var_pb_blog_pagination = $px_node->var_pb_blog_pagination;
			$var_pb_blog_sidebar = $px_node->var_pb_blog_sidebar;
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
                <ul class="form-elements">
                    <li class="to-label"><label>Sidebar</label></li>
                    <li class="to-field">
                        <select name="var_pb_blog_sidebar[]" class="dropdown" >
                            <option <?php if($var_pb_blog_sidebar=="no")echo "selected";?> value="no">No</option>
                            <option <?php if($var_pb_blog_sidebar=="yes")echo "selected";?> value="yes">Yes</option>
                        </select>
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
                            <option <?php if($var_pb_event_type=="All Events")echo "selected";?> >All Events</option>
                            <option <?php if($var_pb_event_type=="Upcoming Events")echo "selected";?> >Upcoming Events</option>
                            <option <?php if($var_pb_event_type=="Past Events")echo "selected";?> >Past Events</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Select Category</label></li>
                    <li class="to-field">
                        <select name="var_pb_event_category[]" class="dropdown">
                        	<option value="0">-- Select Categories --</option>
                        	<option value="All">-- All Categories --</option>
                            <?php show_all_cats('', '', $var_pb_event_category, "event-category");?>
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

// contact us html form for page builder start
function px_pb_contact($die = 0){
	global $px_node, $px_count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$px_counter = $_POST['counter'];
		$contact_element_size = '50';
 		$px_contact_email_db = '';
		$px_contact_title_db = '';
		$px_contact_address_db = '';
		$px_contact_phone_db = '';
		$px_contact_fax_db = '';
		$px_contact_emile_db = '';
		$px_contact_succ_msg_db = '';
	}
	else {
		$name = $px_node->getName();
			$px_count_node++;
			$contact_element_size = $px_node->contact_element_size;
 			$px_contact_email_db = $px_node->px_contact_email;
			$px_contact_title_db = $px_node->px_contact_title;
			$px_contact_address_db = $px_node->px_contact_address;
			$px_contact_phone_db = $px_node->px_contact_phone;
			$px_contact_fax_db = $px_node->px_contact_fax;
			$px_contact_emile_db = $px_node->px_contact_emile;
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
            	<ul class="form-elements">
                    <li class="to-label"><label>Contact Title</label></li>
                    <li class="to-field">
                        <input type="text" name="px_contact_title[]" class="txtfield" value="<?php echo $px_contact_title_db;?>" />
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Contact Address</label></li>
                    <li class="to-field">
                        <input type="text" name="px_contact_address[]" class="txtfield" value="<?php echo $px_contact_address_db;?>" />
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Contact Phone no.</label></li>
                    <li class="to-field">
                        <input type="text" name="px_contact_phone[]" class="txtfield" value="<?php echo $px_contact_phone_db;?>" />
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Contact Fax</label></li>
                    <li class="to-field">
                        <input type="text" name="px_contact_fax[]" class="txtfield" value="<?php echo $px_contact_fax_db;?>" />
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Contact Email</label></li>
                    <li class="to-field">
                        <input type="text" name="px_contact_emile[]" class="txtfield" value="<?php echo $px_contact_emile_db;?>" />
                    </li>                    
                </ul>
				<ul class="form-elements">
                    <li class="to-label"><label>Recipient Email</label></li>
                    <li class="to-field">
                        <input type="text" name="px_contact_email[]" class="txtfield" value="<?php if($px_contact_email_db=="") echo get_option("admin_email"); else echo $px_contact_email_db;?>" />
                    </li>                    
                </ul>
                <ul class="form-elements">
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


// Sermon page builder function
function px_pb_sermon($die = 0){
	global $px_node, $var_pb_sermon_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$var_pb_sermon_counter = $_POST['counter'];
		$sermon_element_size = '50';
		$var_pb_sermon_cat = '';
		$var_pb_sermon_title = '';
		$var_pb_sermon_filterable = '';
		$var_pb_sermon_pagination = '';
 		$var_pb_sermon_per_page = get_option("posts_per_page");
	}
	else {
		$name = $px_node->getName();
			$px_node++;
			$sermon_element_size = $px_node->sermon_element_size;
			$var_pb_sermon_title = $px_node->var_pb_sermon_title;
			$var_pb_sermon_cat = $px_node->var_pb_sermon_cat;
			$var_pb_sermon_filterable = $px_node->var_pb_sermon_filterable;
			$var_pb_sermon_pagination = $px_node->var_pb_sermon_pagination;
 			$var_pb_sermon_per_page = $px_node->var_pb_sermon_per_page;
			$var_pb_sermon_counter = $post->ID.$px_node;
	}
?> 
	<div id="<?php echo $name.$var_pb_sermon_counter?>_del" class="column parentdelete column_<?php echo $sermon_element_size?>" item="album" data="<?php echo element_size_data_array_index($sermon_element_size)?>" >
		<?php px_element_setting($name,$var_pb_sermon_counter,$sermon_element_size);?>
        <div class="poped-up" id="<?php echo $name.$var_pb_sermon_counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Sermon Options</h5>
                <a href="javascript:show_all('<?php echo $name.$var_pb_sermon_counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">	
            	<ul class="form-elements">
                    <li class="to-label"><label><p>Sermon Section Title</p></label></li>
                    <li class="to-field">
                        <input type="text" name="var_pb_sermon_title[]" class="txtfield" value="<?php echo htmlspecialchars($var_pb_sermon_title)?>" />
                    </li>                                            
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Choose category to show Sermon list</label></li>
                    <li class="to-field">
                        <select name="var_pb_sermon_cat[]" class="dropdown">
                        	<option value="">-- All Categories --</option>
                        	<?php show_all_cats('', '', $var_pb_sermon_cat, "sermon-category");?>
                        </select>
                        
                    </li>
                </ul>
                
                <ul class="form-elements">
                    <li class="to-label"><label>Filterable</label></li>
                    <li class="to-field">
                        <select name="var_pb_sermon_filterable[]" class="dropdown">
                            <option <?php if($var_pb_sermon_filterable=="Off")echo "selected";?> >Off</option>
                            <option <?php if($var_pb_sermon_filterable=="On")echo "selected";?> >On</option>
                        </select>
                    </li>
                </ul>
				
				<ul class="form-elements">
                    <li class="to-label"><label>Pagination</label></li>
                    <li class="to-field">
                        <select name="var_pb_sermon_pagination[]" class="dropdown" >
                            <option <?php if($var_pb_sermon_pagination=="Show Pagination")echo "selected";?> >Show Pagination</option>
                            <option <?php if($var_pb_sermon_pagination=="Single Page")echo "selected";?> >Single Page</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>No. of Sermons Per Page (Leave this field blank to show all posts.)</label></li>
                    <li class="to-field">
                        <input type="text" name="var_pb_sermon_per_page[]" class="txtfield" value="<?php echo $var_pb_sermon_per_page;?>" />
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label></label></li>
                    <li class="to-field">
                    	<input type="hidden" name="px_orderby[]" value="sermon" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$var_pb_sermon_counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_px_pb_sermon', 'px_pb_sermon');

// Team page element
function px_pb_team($die = 0){
	global $px_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$px_counter = $_POST['counter'];
		$team_element_size = '50';
		$team_title = '';
		$team_pagination = '';
		$team_page_num = '';
	}
	else {
		$name = $px_node->getName();
			$count_node++;
			$team_element_size = $px_node->team_element_size;
			$team_title = $px_node->team_title;
			$team_pagination = $px_node->team_pagination;
			$team_page_num = $px_node->team_page_num;
				$px_counter = $post->ID.$px_node;
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
            	<ul class="form-elements">
                    <li class="to-label"><label>Team Header Title</label></li>
                    <li class="to-field">
                        <input type="text" name="team_title[]" class="txtfield" value="<?php echo $team_title?>" />
                    </li>                    
                </ul>
                
                <ul class="form-elements">
                    <li class="to-label"><label>Pagination</label></li>
                    <li class="to-field">
                        <select name="team_pagination[]" class="dropdown" >
                            <option <?php if($team_pagination=="Show Pagination")echo "selected";?> >Show Pagination</option>
                            <option <?php if($team_pagination=="Single Page")echo "selected";?> >Single Page</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>No. of Records Per Page</label></li>
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
// page bulider items end

// side bar layout in pages, post and default page(theme options) start
function meta_layout($default_pages = ''){
	global $px_xmlObject, $post;
	$px_theme_option = get_option('px_theme_option');
	if ( empty($px_xmlObject->sub_title) ||  !isset($px_xmlObject->sub_title) ) $sub_title = ""; else $sub_title = $px_xmlObject->sub_title;
	if ( empty($px_xmlObject->var_post_bg_option) ||  !isset($px_xmlObject->var_post_bg_option) ) $var_post_bg_option = ""; else $var_post_bg_option = $px_xmlObject->var_post_bg_option;
	if ( empty($px_xmlObject->px_home_v2_video) ||  !isset($px_xmlObject->px_home_v2_video) ) $px_home_v2_video = ""; else $px_home_v2_video = $px_xmlObject->px_home_v2_video;
	if ( empty($px_xmlObject->px_home_v2_video_mute) ||  !isset($px_xmlObject->px_home_v2_video_mute) ) $px_home_v2_video_mute = ""; else $px_home_v2_video_mute = $px_xmlObject->px_home_v2_video_mute;
	if ( empty($px_xmlObject->bg_image) ||  !isset($px_xmlObject->bg_image) ) $bg_image = ""; else $bg_image = $px_xmlObject->bg_image;
	if ( empty($px_xmlObject->px_home_v4_slider) ||  !isset($px_xmlObject->px_home_v4_slider) ) $px_home_v4_slider = ""; else $px_home_v4_slider = $px_xmlObject->px_home_v4_slider;
	if ( empty($px_xmlObject->bg_color) ||  !isset($px_xmlObject->bg_color) ) $bg_color = $px_theme_option['bg_color']; else $bg_color = $px_xmlObject->bg_color;
	if ( empty($px_xmlObject->px_rotation_text) ||  !isset($px_xmlObject->px_rotation_text) ) $px_rotation_text = ""; else $px_rotation_text = $px_xmlObject->px_rotation_text;
  ?>
	<script type="text/javascript">
         jQuery(document).ready(function($){
            $('.bg_color').wpColorPicker(); 
        });
    </script>
   <div class="id_page_background">
  			<div class="opt-head">
              <h4>Split Options</h4>
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
                            <option <?php if($var_post_bg_option=='featured-image') echo "selected";?> value="featured-image"> Featured Image</option>
                        	<option <?php if($var_post_bg_option=='no-image') echo "selected";?> value="no-image"> No Image</option>
                        	<option <?php if($var_post_bg_option=='big-image-zoom') echo "selected";?> value="big-image-zoom"> Big Image Zoom</option>
                            <option <?php if($var_post_bg_option=='fade-slider') echo "selected";?> value="fade-slider">Fade Slider</option>
                            <option <?php if($var_post_bg_option=='left-slider')echo "selected";?> value="left-slider">Left Slide</option>
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
                <div class="form-elements meta-body noborder" style=" <?php if($var_post_bg_option == "big-image-zoom" || $var_post_bg_option == "fade-slider" ||  $var_post_bg_option == "left-slider"){echo "display:block";}else echo "display:none";?>" id="home_v4" >
                    
                            <ul class="form-elements">
                            <li class="to-field">
                                <select name="px_home_v4_slider" class="dropdown">
                                     <?php
                                        $query = array( 'posts_per_page' => '-1', 'post_type' => 'px_gallery', 'orderby'=>'ID', 'post_status' => 'publish' );
                                        $wp_query = new WP_Query($query);
                                        while ($wp_query->have_posts()) : $wp_query->the_post();
                                    ?>
                                        <option <?php if($post->post_name==$px_home_v4_slider)echo "selected";?> value="<?php echo $post->post_name; ?>"><?php the_title()?></option>
                                    <?php
                                        endwhile;
                                    ?>
                                </select>
                                <p>Choose Slider. Slider images resolution should befull size. Create new Slider from <a style="color:#06F; text-decoration:underline;" href="<?php echo get_site_url(); ?>/wp-admin/post-new.php?post_type=px_gallery">here</a></p>
                            </li>
                        </ul>
                    
                </div>
                <!-- end home v4 Big Image Zoom--->	
            <ul class="form-elements noborder">
                <li class="to-field">
                    <textarea name="sub_title" rows="5" cols="20"><?php echo $sub_title ?></textarea>
                    <p>Split area text rotator</p>
                </li>
            </ul>
            <ul class="form-elements noborder">
              <li class="to-field">
                <input type="text" name="bg_color" value="<?php echo $bg_color?>" class="bg_color" data-default-color="" />
                <p>Background Color</p>
              </li>
            </ul>
            <input type="hidden" name="px_orderby[]" value="meta_layout" />
            <div class="clear"></div>
        </div>   
       <?php 
}
// side bar layout in pages, post and default page(theme options) end

function element_size_data_array_index($size){
	if ( $size == "" or $size == 100 ) return 0;
	else if ( $size == 75 ) return 1;
	else if ( $size == 50 ) return 2;
	else if ( $size == 25 ) return 3;
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
    if (empty($_POST["event_social_sharing"])){ $_POST["event_social_sharing"] = "";}
	if (empty($_POST["event_buy_now"])){ $_POST["event_buy_now"] = "";}
	if (empty($_POST["event_start_time"])){ $_POST["event_start_time"] = "";}
	if (empty($_POST["event_end_time"])){ $_POST["event_end_time"] = "";}
    if (empty($_POST["event_all_day"])){ $_POST["event_all_day"] = "";}
    if (empty($_POST["event_address"])){ $_POST["event_address"] = "";}
    if (empty($_POST["event_map"])){ $_POST["event_map"] = "";}
	if (empty($_POST["event_ticket_options"])){ $_POST["event_ticket_options"] = "";}
	if (empty($_POST["var_pb_event_author"])){ $_POST["var_pb_event_author"] = "";}
	if (empty($_POST["event_ticket_color"])){ $_POST["event_ticket_color"] = "";}
    	
    $sxe = new SimpleXMLElement("<event></event>");
		$sxe->addChild('event_social_sharing', $_POST["event_social_sharing"]);
		$sxe->addChild('event_buy_now', $_POST["event_buy_now"]);
		$sxe->addChild('event_ticket_options', $_POST["event_ticket_options"]);
 		$sxe->addChild('event_start_time', $_POST["event_start_time"]);
		$sxe->addChild('event_end_time', $_POST["event_end_time"]);
		$sxe->addChild('event_all_day', $_POST["event_all_day"]);
 		$sxe->addChild('event_address', $_POST["event_address"]);
		$sxe->addChild('event_map', $_POST["event_map"]);
		$sxe->addChild('var_pb_event_author', $_POST["var_pb_event_author"]);
		$sxe->addChild('event_ticket_color', $_POST["event_ticket_color"]);
    $sxe = save_layout_xml($sxe);
    update_post_meta($post_id, 'px_event_meta', $sxe->asXML());
}

// Default xml data save
function save_layout_xml($sxe) {
	
	if (empty($_POST['sub_title']))
        $_POST['sub_title'] = "";
   

	
	if ( empty($_POST['var_post_bg_option']) ) $var_post_bg_option = ""; else $var_post_bg_option = $_POST['var_post_bg_option'];
	if ( empty($_POST['px_home_v2_video']) ) $_POST['px_home_v2_video'] = ""; else $_POST['px_home_v2_video'] = $_POST['px_home_v2_video'];
	if ( empty($_POST['px_home_v2_video_mute']) ) $_POST['px_home_v2_video_mute'] = ""; else $_POST['px_home_v2_video_mute'] = $_POST['px_home_v2_video_mute'];
	if ( empty($_POST['bg_image']) ) $_POST['bg_image'] = ""; else $_POST['bg_image'] = $_POST['bg_image'];
	if ( empty($_POST['px_home_v4_slider']) ) $_POST['px_home_v4_slider'] = ""; else $_POST['px_home_v4_slider'] = $_POST['px_home_v4_slider'];
	if ( empty($_POST['bg_color']) ) $_POST['bg_color'] = ""; else $_POST['bg_color'] = $_POST['bg_color'];
	if ( empty($_POST['sub_title']) ) $_POST['sub_title'] = ""; else $_POST['sub_title'] = $_POST['sub_title'];
		$sxe->addChild('sub_title', $_POST['sub_title'] );
		$sxe->addChild('var_post_bg_option', $var_post_bg_option);
		if($var_post_bg_option=='background_video'){
			$sxe->addChild('px_home_v2_video', $_POST['px_home_v2_video']);
			$sxe->addChild('px_home_v2_video_mute', $_POST['px_home_v2_video_mute']);
		
		} else if($var_post_bg_option == "big-image-zoom" || $var_post_bg_option == "fade-slider" ||  $var_post_bg_option == "left-slider"){
			$sxe->addChild('px_home_v4_slider', $_POST['px_home_v4_slider']);
		} 
		$sxe->addChild('bg_color', $_POST['bg_color']);
		
		
    return $sxe;
}

// add Album tracks function
function px_add_sermon_to_list(){
	global $counter_track, $var_pb_sermon_track_title, $var_pb_sermon_speaker, $var_pb_sermon_track_mp3_url , $var_pb_sermon_track_buy_mp3 ;
	foreach ($_POST as $keys=>$values) {
		$$keys = $values;
	}
?>
    <tr id="edit_track<?php echo $counter_track?>">
        <td id="album-title<?php echo $counter_track?>" style="width:80%;"><?php echo $var_pb_sermon_track_title?></td>
        <td class="centr" style="width:20%;">
            <a href="javascript:openpopedup('edit_track_form<?php echo $counter_track?>')" class="actions edit">&nbsp;</a>
            <a onclick="javascript:return confirm('Are you sure! You want to delete.')" href="javascript:px_div_remove('edit_track<?php echo $counter_track?>')" class="actions delete">&nbsp;</a>
            <div class="poped-up" id="edit_track_form<?php echo $counter_track?>">
                <div class="opt-head">
                    <h5>Track Settings</h5>
                    <a href="javascript:closepopedup('edit_track_form<?php echo $counter_track?>')" class="closeit">&nbsp;</a>
                    <div class="clear"></div>
                </div>
                <ul class="form-elements">
                    <li class="to-label"><label>Sermon Title</label></li>
                    <li class="to-field">
                        <input type="text" name="var_pb_sermon_track_title[]" value="<?php echo htmlspecialchars($var_pb_sermon_track_title)?>" id="var_pb_sermon_track_title<?php echo $counter_track?>" />
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Sermon Speaker</label></li>
                    <li class="to-field">
                        <input type="text" name="var_pb_sermon_speaker[]" value="<?php echo htmlspecialchars($var_pb_sermon_speaker)?>" id="var_pb_sermon_speaker<?php echo $counter_track?>" />
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Sermon MP3 URL</label></li>
                    <li class="to-field">
                        <input id="var_pb_sermon_track_mp3_url<?php echo $counter_track?>" name="var_pb_sermon_track_mp3_url[]" value="<?php echo htmlspecialchars($var_pb_sermon_track_mp3_url)?>" type="text" class="small" />
                        <input id="var_pb_sermon_track_playable<?php echo $counter_track?>" name="var_pb_sermon_track_playable<?php echo $counter_track?>" type="button" class="uploadfile left" value="Browse"/>
                    </li>
                </ul>
                
                <ul class="form-elements">
                    <li class="to-label"><label>Buy MP3 URL</label></li>
                    <li class="to-field">
                        <input type="text" name="var_pb_sermon_track_buy_mp3[]" value="<?php echo htmlspecialchars($var_pb_sermon_track_buy_mp3)?>" />
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label></label></li>
                    <li class="to-field"><input type="button" value="Update Sermon" onclick="update_title(<?php echo $counter_track?>); closepopedup('edit_track_form<?php echo $counter_track?>')" /></li>
                </ul>
            </div>
        </td>
    </tr>
<?php
	if ( isset($action) ) die();
}
add_action('wp_ajax_px_add_sermon_to_list', 'px_add_sermon_to_list');