<?php
// media pagination for slider/gallery in admin side start
function cs_media_pagination(){
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
add_action('wp_ajax_cs_media_pagination', 'cs_media_pagination');
// media pagination for slider/gallery in admin side end

// to make a copy of media image for slider start
function cs_slider_clone(){
	global $cs_node, $counter;
	if( isset($_POST['action']) ) {
		$cs_node = new stdClass();
		$cs_node->title = '';
		$cs_node->description = '';
		$cs_node->link = '';
		$cs_node->link_target = '';
		$cs_node->use_image_as = '';
		$cs_node->video_code = '';
	}
	if ( isset($_POST['counter']) ) $counter = $_POST['counter'];
	if ( isset($_POST['path']) ) $cs_node->path = $_POST['path'];
?>
    <li class="ui-state-default" id="<?php echo $counter?>">
        <div class="thumb-secs">
            <?php $image_path = wp_get_attachment_image_src( $cs_node->path, array( get_option("thumbnail_size_w"),get_option("thumbnail_size_h") ) );?>
            <img src="<?php echo $image_path[0]?>" alt="">
            <div class="gal-edit-opts">
                <!--<a href="#" class="resize"></a>-->
                <a href="javascript:slidedit(<?php echo $counter?>)" class="edit"></a>
                <a href="javascript:del_this(<?php echo $counter?>)" class="delete"></a>
            </div>
        </div>
        <div class="poped-up" id="edit_<?php echo $counter?>">
            <div class="opt-head">
                <h5>Edit Options</h5>
                <a href="javascript:slideclose(<?php echo $counter?>)" class="closeit">&nbsp;</a>
                <div class="clear"></div>
            </div>
            <div class="opt-conts">
                <ul class="form-elements">
                    <li class="to-label"><label>Image Title</label></li>
                    <li class="to-field"><input type="text" name="cs_slider_title[]" value="<?php echo htmlspecialchars($cs_node->title)?>" class="txtfield" /></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Image Description</label></li>
                    <li class="to-field"><textarea class="txtarea" name="cs_slider_description[]"><?php echo htmlspecialchars($cs_node->description)?></textarea></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Link</label></li>
                    <li class="to-field"><input type="text" name="cs_slider_link[]" value="<?php echo htmlspecialchars($cs_node->link)?>" class="txtfield" /></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Link Target</label></li>
                    <li class="to-field">
                        <select name="cs_slider_link_target[]" class="select_dropdown">
                            <option <?php if($cs_node->link_target=="_self")echo "selected";?> >_self</option>
                            <option <?php if($cs_node->link_target=="_blank")echo "selected";?> >_blank</option>
                        </select>
                        <p>Please select image target.</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"></li>
                    <li class="to-field">
                        <input type="hidden" name="path[]" value="<?php echo $cs_node->path?>" />
                        <input type="button" value="Submit" onclick="javascript:slideclose(<?php echo $counter?>)" class="close-submit" />
                    </li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
    </li>
<?php
	if ( isset($_POST['action']) ) die();
}
add_action('wp_ajax_slider_clone', 'cs_slider_clone');
// to make a copy of media image for slider end

// to make a copy of media image for gallery start
function cs_gallery_clone(){
	global $cs_node, $counter;
	if( isset($_POST['action']) ) {
		$cs_node = new stdClass();
		$cs_node->title = "";
		$cs_node->description = "";
		$cs_node->use_image_as = "";
		$cs_node->video_code = "";
		$cs_node->link_url = "";
		$cs_node->use_image_as_db = "";
		$cs_node->link_url_db = '';
	}
	if ( isset($_POST['counter']) ) $counter = $_POST['counter'];
	if ( isset($_POST['path']) ) $cs_node->path = $_POST['path'];
?>
    <li class="ui-state-default" id="<?php echo $counter?>">
        <div class="thumb-secs">
            <?php $image_path = wp_get_attachment_image_src( $cs_node->path, array( get_option("thumbnail_size_w"),get_option("thumbnail_size_h") ) );?>
            <img src="<?php echo $image_path[0]?>" alt="">
            <div class="gal-edit-opts">
                <!--<a href="#" class="resize"></a>-->
                <a href="javascript:galedit(<?php echo $counter?>)" class="edit"></a>
                <a href="javascript:del_this(<?php echo $counter?>)" class="delete"></a>
            </div>
        </div>
        <div class="poped-up" id="edit_<?php echo $counter?>">
            <div class="opt-head">
                <h5>Edit Options</h5>
                <a href="javascript:galclose(<?php echo $counter?>)" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
                <ul class="form-elements">
                    <li class="to-label"><label>Image Title</label></li>
                    <li class="to-field"><input type="text" name="title[]" value="<?php echo htmlspecialchars($cs_node->title)?>" class="txtfield" /></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Use Image As</label></li>
                    <li class="to-field">
                        <select name="use_image_as[]" class="select_dropdown" onchange="cs_toggle_gal(this.value, <?php echo $counter?>)">
                            <option <?php if($cs_node->use_image_as=="0")echo "selected";?> value="0">LightBox to current thumbnail</option>
                            <option <?php if($cs_node->use_image_as=="1")echo "selected";?> value="1">LightBox to Video</option>
                            <option <?php if($cs_node->use_image_as=="2")echo "selected";?> value="2">Link URL</option>
                        </select>
                        <p>Please select Image link where it will go.</p>
                    </li>
                </ul>
                <ul class="form-elements" id="video_code<?php echo $counter?>" <?php if($cs_node->use_image_as=="0" or $cs_node->use_image_as=="" or $cs_node->use_image_as=="2")echo 'style="display:none"';?> >
                    <li class="to-label"><label>Video URL</label></li>
                    <li class="to-field">
                        <input type="text" name="video_code[]" value="<?php echo htmlspecialchars($cs_node->video_code)?>" class="txtfield" />
                        <p>(Enter Specific Video URL Youtube or Vimeo)</p>
                    </li>
                </ul>
                <ul class="form-elements" id="link_url<?php echo $counter?>" <?php if($cs_node->use_image_as=="0" or $cs_node->use_image_as=="" or $cs_node->use_image_as=="1")echo 'style="display:none"';?> >
                    <li class="to-label"><label>Link URL</label></li>
                    <li class="to-field">
                        <input type="text" name="link_url[]" value="<?php echo htmlspecialchars($cs_node->link_url)?>" class="txtfield" />
                        <p>(Enter Specific Link URL)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"></li>
                    <li class="to-field">
                        <input type="hidden" name="path[]" value="<?php echo $cs_node->path?>" />
                        <input type="button" onclick="javascript:galclose(<?php echo $counter?>)" value="Submit" class="close-submit" />
                    </li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
    </li>
<?php
	if ( isset($_POST['action']) ) die();
}
add_action('wp_ajax_gallery_clone', 'cs_gallery_clone');
// to make a copy of media image for gallery end

// Add social network icons
function cs_add_social_icon(){
    $template_path = get_template_directory_uri() . '/scripts/admin/media_upload.js';
    wp_enqueue_script('my-upload2', $template_path, array('jquery', 'media-upload', 'thickbox', 'jquery-ui-droppable', 'jquery-ui-datepicker', 'jquery-ui-slider', 'wp-color-picker'));
	//echo '<tr id="del_' .$_POST['counter_social_network'].'"> 
		echo '<tr id="del_' .$_POST['counter_social_network'].'"> ';
			if(isset($_POST['social_net_awesome']) && $_POST['social_net_awesome'] <> ''){
				echo '<td><i style="color: green;" class="fa '.$_POST['social_net_awesome'].' fa-2x"></td>';
			} else {
				echo '<td><img width="50" src="'.$_POST['social_net_icon_path'].'"></td>';
			}
		//echo '<td><img width="50" src="' .$_POST['social_net_icon_path']. '"></td> 
		echo '<td>' .$_POST['social_net_url']. '</td> 
		<td class="centr"> 
			<a onclick="javascript:return confirm(\'Are you sure! You want to delete this\')" href="javascript:social_icon_del('.$_POST['counter_social_network'].')">Del</a> 
			| <a href="javascript:cs_toggle('.$_POST['counter_social_network'].')">Edit</a>
		</td> 
	</tr> 
	<tr id="'.$_POST['counter_social_network'].'" style="display:none"> 
		<td colspan="3"> 
			<ul class="form-elements">
				<li class="to-label"><label>Icon Path</label></li>
				<li class="to-field">
				  <input id="social_net_icon_path'.$_POST['counter_social_network'].'" name="social_net_icon_path[]" value="'.$_POST['social_net_icon_path'].'" type="text" class="small" /> 
				</li>
				<li><a onclick="cs_toggle('. $_POST['counter_social_network'] .')"><img src="'.get_template_directory_uri().'/images/admin/close-red.png"></a></li>
				<li class="full">&nbsp;</li>
				<li class="to-label"><label>Awesome Font</label></li>
				<li class="to-field">
				  <input class="small" type="text" id="social_net_awesome" name="social_net_awesome[]" value="'.$_POST['social_net_awesome'].'" style="width:420px;" />
				  <p>Put Awesome Font Code like "fa-flag".</p>
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
add_action('wp_ajax_cs_add_social_icon', 'cs_add_social_icon');


function cs_stripslashes_htmlspecialchars($value)
{
    $value = is_array($value) ? array_map('cs_stripslashes_htmlspecialchars', $value) : stripslashes(htmlspecialchars($value));
    return $value;
}
// stripslashes / htmlspecialchars for theme option save end
/* Theme Options Functions */
// saving all the theme options start
function cs_theme_option_save() {
	if ( isset($_POST['logo']) ) {
		$_POST = cs_stripslashes_htmlspecialchars($_POST);
		if ( $_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['twitter_setting'])){
			update_option( "cs_theme_option", $_POST );
			echo "All Settings Saved";
 		}else{
			update_option( "cs_theme_option", $_POST );
			echo "All Settings Saved";
		}
				// upating config file end
	}
	else {
		//echo $_FILES["mofile"]["tmp_name"][0];
		//echo $_FILES["mofile"]["name"][0];
		$target_path_mo = get_template_directory()."/languages/".$_FILES["mofile"]["name"][0];
		if ( move_uploaded_file($_FILES["mofile"]["tmp_name"][0], $target_path_mo) ) {
			chmod($target_path_mo,0777);
		}
		echo "New Language Uploaded Successfully";
	}
	die();
}
add_action('wp_ajax_cs_theme_option_save', 'cs_theme_option_save');
// saving all the theme options end

function cs_theme_option_import_export() {
	$a = unserialize(base64_decode($_POST['theme_option_data']));
	update_option( "cs_theme_option", $a );
	echo "Otions Imported";
	die();
}
add_action('wp_ajax_cs_theme_option_import_export', 'cs_theme_option_import_export');
// saving theme options import export end

// restoring default theme options start
function cs_theme_option_restore_default() {
	update_option( "cs_theme_option", get_option('cs_theme_option_restore') );
	echo "Default Theme Options Restored";
	die();
}
add_action('wp_ajax_cs_theme_option_restore_default', 'cs_theme_option_restore_default');
// restoring default theme options end

// saving theme options backup start
function cs_theme_option_backup() {
	update_option( "cs_theme_option_backup", get_option('cs_theme_option') );
	update_option( "cs_theme_option_backup_time", gmdate("Y-m-d H:i:s") );
	echo "Current Backup Taken @ " . gmdate("Y-m-d H:i:s");
	die();
}
add_action('wp_ajax_cs_theme_option_backup', 'cs_theme_option_backup');
// saving theme options backup end

// restore backup start
function cs_theme_option_backup_restore() {
	update_option( "cs_theme_option", get_option('cs_theme_option_backup') );
	echo "Backup Restored";
	die();
}
add_action('wp_ajax_cs_theme_option_backup_restore', 'cs_theme_option_backup_restore');
// restore backup end

/* Theme Options Functions */

// page bulider items start

// gallery html form for page builder start
function cs_pb_gallery($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
			$name = $_POST['action'];
			$counter = $_POST['counter'];
			$gallery_element_size = '100';
			$cs_gal_header_title_db = '';
			$cs_gal_layout_db = '';
			$cs_gal_album_db = '';
 			$cs_gal_margin_left = '';
			$cs_gal_thumb_space = '';
			$cs_gal_show_pagination_db = '';
			$cs_gal_show_thumbnail_db = '';
			$cs_gal_image_size_db = '';
 			$cs_gal_media_per_page_db = '40';
			$cs_images_per_gallery= '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$gallery_element_size = $cs_node->gallery_element_size;
			$cs_gal_header_title_db = $cs_node->header_title;
			$cs_gal_layout_db = $cs_node->layout;
			$cs_gal_album_db = $cs_node->album;
 			$cs_gal_margin_left = $cs_node->margin_left;
			$cs_gal_thumb_space = $cs_node->thumb_space;
 			$cs_gal_media_per_page_db = $cs_node->media_per_page;
			$cs_gal_show_pagination_db = $cs_node->cs_gal_show_pagination;
			$cs_gal_show_thumbnail_db = $cs_node->cs_gal_show_thumbnail;
			$cs_gal_image_size_db = $cs_node->cs_gal_image_size;
			$cs_images_per_gallery = $cs_node->cs_images_per_gallery;
				$counter = $post->ID.$count_node;
	}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $gallery_element_size?>" item="gallery" data="<?php echo cs_element_size_data_array_index($gallery_element_size)?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="gallery_element_size[]" class="item" value="<?php echo $gallery_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
  		</div>
        <div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Gallery Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Gallery Header Title</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_gal_header_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_gal_header_title_db)?>" />
                        <p>Please enter gallery header title.</p>
                    </li>                    
                </ul>
				<ul class="form-elements">
                    <li class="to-label"><label>Left Padding</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_gal_margin_left[]" class="txtfield" value="<?php if(isset($cs_gal_margin_left) and $cs_gal_margin_left <> "") {echo $cs_gal_margin_left;}else{ echo "30";} ?>" />
                        <p>Set Left Padding for Gallery. Default is 30px</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Thumb Space</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_gal_thumb_space[]" class="txtfield" value="<?php if(isset($cs_gal_thumb_space) and $cs_gal_thumb_space <> "") {echo $cs_gal_thumb_space;}else{ echo "1";} ?>" />
                        <p>Set thumbnail space of gallery. Default is 1px</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Choose Gallery Layout</label></li>
                    <li class="to-field">
                        <select name="cs_gal_layout[]" class="dropdown" onchange="gallery_view_element(this.value,'<?php echo $counter?>')">
                            <option value="gallery_masonry_view" <?php if($cs_gal_layout_db=="gallery_masonry_view")echo "selected";?> >Gallery Masonry View</option>
                            <option value="gallery_grid_view" <?php if($cs_gal_layout_db=="gallery_grid_view")echo "selected";?> >Gallery Grid View</option>
                            <option value="gallery_squre_view" <?php if($cs_gal_layout_db=="gallery_squre_view")echo "selected";?> >Gallery Square</option>
                            <option value="gallery_full_page" <?php if($cs_gal_layout_db=="gallery_full_page")echo "selected";?> >Full Page Gallery</option>
                        </select>
                        
                        <p>Select gallery layout.</p>
                    </li>
                </ul>
                 
                <ul id="cs_gallery_view<?php echo $counter?>" style="display:<?php if($cs_gal_layout_db <> "gallery_full_page")echo "none"; else echo "inline"; ?>">
                	<li>
                    	<ul class="form-elements">
                         	<li class="to-label"><label>Gallery Image Size</label></li>
                            <li class="to-field">
                                <select name="cs_gal_image_size[]" class="dropdown">
                                    <option value="full_width" <?php if($cs_gal_image_size_db=="full_width")echo "selected";?> >Full Width</option>
                                    <option value="original_size" <?php if($cs_gal_image_size_db=="original_size")echo "selected";?> >Original Size</option>
                                </select>
                            </li>
                        </ul>
                        <ul class="form-elements">
                         	<li class="to-label"><label>No. of Images</label></li>
                            <li class="to-field">
                                <input type="text" id="cs_images_per_gallery" name="cs_images_per_gallery[]" value="<?php echo $cs_images_per_gallery;?>" />                             <p>Leave empty field mean show all images.</p>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Show Thumbnail</label></li>
                            <li class="to-field">
                                <select name="cs_gal_show_thumbnail[]" class="dropdown">
                                    <option <?php if($cs_gal_show_thumbnail_db=="On")echo "selected";?> >On</option>
                                    <option <?php if($cs_gal_show_thumbnail_db=="Off")echo "selected";?> >Off</option>
                                </select>
                            </li>
                        </ul>
                    	<ul class="form-elements">
                         	<li class="to-label"><label>Show Navigation</label></li>
                            <li class="to-field">
                                <select name="cs_gal_show_pagination[]" class="dropdown">
                                    <option <?php if($cs_gal_show_pagination_db=="On")echo "selected";?> >On</option>
                                    <option <?php if($cs_gal_show_pagination_db=="Off")echo "selected";?> >Off</option>
                                </select>
                            </li>
                        </ul>
                        
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Choose Gallery/Album</label></li>
                    <li class="to-field">
                        <select name="cs_gal_album[]" class="dropdown">
                        	<option value="0">-- Select Gallery/Album --</option>
                            <?php
                                $query = array( 'posts_per_page' => '-1', 'post_type' => 'cs_gallery', 'orderby'=>'ID', 'post_status' => 'publish' );
                                $wp_query = new WP_Query($query);
                                while ($wp_query->have_posts()) : $wp_query->the_post();
                            ?>
                                <option <?php if($post->post_name==$cs_gal_album_db)echo "selected";?> value="<?php echo $post->post_name; ?>"><?php echo get_the_title()?></option>
                            <?php
                                endwhile;
                            ?>
                        </select>
                        <p>Select Gallery/Album to show images.</p>
                    </li>
                </ul>
                <input type="hidden" name="cs_gal_media_per_page[]" class="txtfield" value="<?php echo $cs_gal_media_per_page_db; ?>" />
				<!--<ul class="form-elements" >
                    <li class="to-label"><label>No. of Media Per Page</label></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_gal_media_per_page[]" class="txtfield" value="<?php echo $cs_gal_media_per_page_db; ?>" />
                        <p>To display all the records, leave this field blank.</p>
						<p>For best view of page Enter more then 32 Records per page</p>
                    </li>
                </ul>-->
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="gallery" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_gallery', 'cs_pb_gallery');
// gallery html form for page builder end

// blog html form for page builder start
function cs_pb_blog($die = 0){
	
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$blog_element_size = '100';
		$cs_blog_title_db = '';
		$cs_blog_cat_db = '';
		$cs_blog_left_space = '';
		$cs_blog_excerpt_db = '255';
		$cs_blog_num_post_db = '40';
 		$cs_blog_description_db = '';
		$cs_blog_view = '';
		$cs_blog_sidebar = '';
		$cs_featured_post = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$blog_element_size = $cs_node->blog_element_size;
			$cs_blog_title_db = $cs_node->cs_blog_title;
			$cs_blog_view = $cs_node->cs_blog_view;
			$cs_blog_cat_db = $cs_node->cs_blog_cat;
			$cs_blog_excerpt_db = $cs_node->cs_blog_excerpt;
			$cs_blog_left_space = $cs_node->cs_blog_left_space;
			$cs_blog_num_post_db = $cs_node->cs_blog_num_post;
 			$cs_blog_description_db = $cs_node->cs_blog_description;
			$cs_blog_sidebar = $cs_node->cs_blog_sidebar;
			$cs_featured_post = $cs_node ->cs_featured_post;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $blog_element_size?>" item="blog" data="<?php echo cs_element_size_data_array_index($blog_element_size)?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="blog_element_size[]" class="item" value="<?php echo $blog_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a>
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;
   		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Blog Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Blog Header Title</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_blog_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_blog_title_db)?>" />
                        <p>Please enter Blog header title.</p>
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Blog View</label></li>
                    <li class="to-field">
                        <select name="cs_blog_view[]" class="dropdown"  onchange="javascript:cs_toggle_featured_post(this.value,<?php echo $counter ?>)">
                            <option value="gird_view" <?php if($cs_blog_view=="gird_view")echo "selected";?> >Grid View</option>
                            <option value="masonry_view" <?php if($cs_blog_view=="masonry_view")echo "selected";?> >Masonary View</option>
                        </select>
                         <p>Grid view will show only posts which contain  featured image.</p>
                        
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Choose Category</label></li>
                    <li class="to-field">
                        <select name="cs_blog_cat[]" class="dropdown">
                             <option value="all" <?php if($cs_blog_cat_db == "all"){ echo 'selected';}?>> All</option>
							<?php cs_show_all_cats('', '', $cs_blog_cat_db, "category");?>
                        </select>
                        <p>Please select category to show posts.</p>
                    </li>                                        
                </ul>
                <ul class="form-elements" id="cs_featured_post_<?php echo $counter; ?>" style="display:<?php if($cs_blog_view=="gird_view") echo 'inline';else echo 'none';?>">
                    <li class="to-label"><label>Choose Featured Post</label></li>
                    <li class="to-field">
                        <select name="cs_featured_post[]" class="dropdown">
                            <?php 
							$args = array('posts_per_page' => "-1", 'post_type' => 'post');
							$custom_query = new WP_Query($args);
							  while ($custom_query->have_posts()) : $custom_query->the_post();	
 							?>
                             <option value="<?php echo $post->ID?>" <?php if($cs_featured_post == $post->ID){ echo 'selected';}?>> <?php the_title(); ?></option><?php endwhile; ?>                 </select>
                        <p>Please select featured posts.</p>
                    </li>                                        
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Left Space</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_blog_left_space[]" class="txtfield" value="<?php if(isset($cs_blog_left_space) and $cs_blog_left_space <> ""){ echo $cs_blog_left_space; }else{ echo '0';} ?>" />
                        <p>Set Left Spae in PX. Default is 0px.</p>
                    </li>                         
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Post Description</label></li>
                    <li class="to-field">
                        <select name="cs_blog_description[]" class="dropdown" >
                            <option <?php if($cs_blog_description_db=="yes")echo "selected";?> value="yes">Yes</option>
                            <option <?php if($cs_blog_description_db=="no")echo "selected";?> value="no">No</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Length of Excerpt</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_blog_excerpt[]" class="txtfield" value="<?php echo $cs_blog_excerpt_db;?>" />
                        <p>Enter number of character for short description text.</p>
                    </li>                         
                </ul>
                <input type="hidden" name="cs_blog_num_post[]" class="txtfield" value="<?php echo $cs_blog_num_post_db; ?>" />
                 <!--<ul class="form-elements">
                    <li class="to-label"><label>No. of Post Per Page</label></li>
                    <li class="to-field">
                    	<input type="text" name="cs_blog_num_post[]" class="txtfield" value="<?php echo $cs_blog_num_post_db; ?>" />
                        <p>To display all the records, leave this field blank.</p>
						<p>For best view of page Enter more then 20 Records per page</p>
                    </li>
                </ul>-->
                <ul class="form-elements">
                    <li class="to-label"><label>Choose Sidebar</label></li>
                    <li class="to-field">
                    	
                        <select name="cs_blog_sidebar[]" class="dropdown">
                        <option value="" >--Select Sidebar--</option>
                            <?php
                            $cs_theme_option = get_option('cs_theme_option');
                            if ( isset($cs_theme_option['sidebar']) and count($cs_theme_option['sidebar']) > 0 ) {
                                foreach ( $cs_theme_option['sidebar'] as $sidebar ){
                                ?>
                                    <option value="<?php echo $sidebar;?>" <?php if($cs_blog_sidebar==$sidebar)echo "selected";?>><?php echo $sidebar;?></option>
                                <?php
                                }
                            }
                            ?>
                        </select>
                        <p>Please select Sidebar to show sidbar at left on your page.</p>
                    </li>                                        
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="blog" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_blog', 'cs_pb_blog');
// blog html form for page builder end

// event html form for page builder start
function cs_pb_event($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$cs_event_title_db = '';
		$cs_event_view_db = '';
		$cs_event_type_db = '';
		$cs_event_category_db = '';
		$cs_event_showmap = '';
		$cs_event_map_width = '';
		$cs_event_map_type = '';
		$cs_event_map_controls = '';
		$cs_event_map_draggable = '';
		$cs_event_map_scrollwheel = '';
 		$cs_event_filterables_db = '';
		$cs_event_map_zoom = '';
		$cs_event_per_page_db = '40';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$cs_event_title_db = $cs_node->cs_event_title;
			$cs_event_view_db = $cs_node->cs_event_view;
			$cs_event_type_db = $cs_node->cs_event_type;
			$cs_event_category_db = $cs_node->cs_event_category;
			$cs_event_showmap = $cs_node->cs_event_showmap;
			$cs_event_map_width = $cs_node->cs_event_map_width;
			$cs_event_map_zoom = $cs_node->cs_event_map_zoom;
 			$cs_event_map_type = $cs_node->cs_event_map_type;
			$cs_event_map_controls = $cs_node->cs_event_map_controls;
			$cs_event_map_draggable = $cs_node->cs_event_map_draggable;
			$cs_event_map_scrollwheel = $cs_node->cs_event_map_scrollwheel;
 			$cs_event_filterables_db = $cs_node->cs_event_filterables;
			$cs_event_per_page_db = $cs_node->cs_event_per_page;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_100" item="event" data="<?php echo cs_element_size_data_array_index('100')?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a>
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;
  		</div>
        <div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Gigs Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Event Title</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_event_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_event_title_db)?>" />
                        <p>Event Page Title</p>
                    </li>
                </ul>
                <input type="hidden" name="cs_event_view[]" class="txtfield" value="List View" />
                
                <ul class="form-elements">
                    <li class="to-label"><label>Event Types</label></li>
                    <li class="to-field">
                        <select name="cs_event_type[]" class="dropdown">
                            <option <?php if($cs_event_type_db=="All Events")echo "selected";?> >All Events</option>
                            <option <?php if($cs_event_type_db=="Upcoming Events")echo "selected";?> >Upcoming Events</option>
                            <option <?php if($cs_event_type_db=="Past Events")echo "selected";?> >Past Events</option>
                        </select>
                        <p>Select event type</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Select Category</label></li>
                    <li class="to-field">
                        <select name="cs_event_category[]" class="dropdown">
                              <option value="all" <?php if($cs_event_category_db == "all"){ echo 'selected';}?>> All</option>
                            <?php cs_show_all_cats('', '', $cs_event_category_db, "event-category");?>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Show Map</label></li>
                    <li class="to-field">
                        <select name="cs_event_showmap[]" class="dropdown" onchange="cs_toggle_tog('pagination<?php echo $name.$counter?>')">
                            <option value="Yes" <?php if($cs_event_showmap=="Yes")echo "selected";?> >Yes</option>
                            <option value="No" <?php if($cs_event_showmap=="No")echo "selected";?> >No</option>
                        </select>
                    </li>
                </ul>
                <div id="pagination<?php echo $name.$counter?>" <?php if($cs_event_showmap=="No")echo 'class="no-display" style="display: none;"'?> >
                    <ul class="form-elements">
                        <li class="to-label"><label>Map Width</label></li>
                        <li class="to-field">
                            <input type="text" name="cs_event_map_width[]" class="txtfield" value="<?php echo $cs_event_map_width; ?>" />
                        </li>
                    </ul>
                     <ul class="form-elements">
                        <li class="to-label"><label>Map Zoom</label></li>
                        <li class="to-field">
                            <input type="text" name="cs_event_map_zoom[]" class="txtfield" value="<?php echo $cs_event_map_zoom; ?>" />
                        </li>
                    </ul>
                     <ul class="form-elements">
                        <li class="to-label"><label>Map Types</label></li>
                        <li class="to-field">
                            <select name="cs_event_map_type[]" class="dropdown" >
                                <option <?php if($cs_event_map_type=="ROADMAP")echo "selected";?> >ROADMAP</option>
                                <option <?php if($cs_event_map_type=="HYBRID")echo "selected";?> >HYBRID</option>
                                <option <?php if($cs_event_map_type=="SATELLITE")echo "selected";?> >SATELLITE</option>
                                <option <?php if($cs_event_map_type=="TERRAIN")echo "selected";?> >TERRAIN</option>
                            </select>
                        </li>
                    </ul>
                     <ul class="form-elements">
                        <li class="to-label"><label>Disable Map Controls</label></li>
                        <li class="to-field">
                            <select name="cs_event_map_controls[]" class="dropdown" >
                                <option value="false" <?php if($cs_event_map_controls=="false")echo "selected";?> >Off</option>
                                <option value="true" <?php if($cs_event_map_controls=="true")echo "selected";?> >On</option>
                            </select>
                        </li>
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label"><label>Draggable</label></li>
                        <li class="to-field">
                            <select name="cs_event_map_draggable[]" class="dropdown" >
                                <option value="true" <?php if($cs_event_map_draggable=="true")echo "selected";?> >On</option>
                                <option value="false" <?php if($cs_event_map_draggable=="false")echo "selected";?> >Off</option>
                            </select>
                        </li>
                    </ul>
                     <ul class="form-elements">
                    <li class="to-label"><label>Scroll Wheel</label></li>
                    <li class="to-field">

                        <select name="cs_event_map_scrollwheel[]" class="dropdown" >
                            <option value="true" <?php if($cs_event_map_scrollwheel=="true")echo "selected";?> >On</option>
                            <option value="false" <?php if($cs_event_map_scrollwheel=="false")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                </div>
                 <ul class="form-elements">
                    <li class="to-label"><label>Filterables</label></li>
                    <li class="to-field">
                        <select name="cs_event_filterables[]" class="dropdown" >
                            <option value="No" <?php if($cs_event_filterables_db=="No")echo "selected";?> >No</option>
                            <option value="Yes" <?php if($cs_event_filterables_db=="Yes")echo "selected";?> >Yes</option>
                        </select>
                    </li>
                </ul>
                <input type="hidden" name="cs_event_per_page[]" class="txtfield" value="<?php echo $cs_event_per_page_db; ?>" />
                <!--<ul class="form-elements">
                    <li class="to-label"><label>No. of Events Per Page</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_event_per_page[]" class="txtfield" value="<?php echo $cs_event_per_page_db; ?>" />
                        <p>To display all the records, leave this field blank.</p>
						<p>For best view of page Enter more then 20 Records per page</p>
                    </li>
                </ul>-->
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="event" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_event', 'cs_pb_event');
// event html form for page builder end


// Artist html form for page builder start
function cs_pb_artists($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$cs_artist_title_db = '';
		$cs_artist_view_db = '';
		$cs_artist_category_db = '';
		$cs_artist_filterables_db = '';
		$cs_artist_per_page_db = '40';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$cs_artist_title_db = $cs_node->cs_artist_title;
			$cs_artist_view_db = $cs_node->cs_artist_view;
			$cs_artist_category_db = $cs_node->cs_artist_category;
			$cs_artist_per_page_db = $cs_node->cs_artist_per_page;
			$cs_artist_filterables_db = $cs_node->cs_artist_filterables;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_100" item="artist" data="<?php echo cs_element_size_data_array_index('100')?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a>
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;
 		</div>
        <div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Artist Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Artist Title</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_artist_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_artist_title_db)?>" />
                        <p>Event Page Title</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>View</label></li>
                    <li class="to-field">
                        <select name="cs_artist_view[]" class="dropdown"  onchange="cs_toggle_tog('pagination<?php echo $name.$counter?>')">
                            <option value="gird_view" <?php if($cs_artist_view_db=="gird_view")echo "selected";?> >Artists View 1</option>
                            <option value="list_view" <?php if($cs_artist_view_db=="list_view")echo "selected";?> >Artists View 2</option>
                        </select>
                        <p>Select layout for page</p>
                    </li>
                </ul>
                <div id="pagination<?php echo $name.$counter?>" <?php if($cs_artist_view_db=="list_view")echo 'class="no-display" style="display: none;"'?> >
                    <ul class="form-elements">
                        <li class="to-label"><label>Filterables</label></li>
                        <li class="to-field">
                            <select name="cs_artist_filterables[]" class="dropdown" >
                                <option value="No" <?php if($cs_artist_filterables_db=="No")echo "selected";?> >No</option>
                                <option value="Yes" <?php if($cs_artist_filterables_db=="Yes")echo "selected";?> >Yes</option>
                            </select>
                        </li>
                    </ul>
                </div>
                <ul class="form-elements">
                    <li class="to-label"><label>Select Category</label></li>
                    <li class="to-field">
                        <select name="cs_artist_category[]" class="dropdown">
                             <option value="all" <?php if($cs_artist_category_db == "all"){ echo 'selected';}?>> All</option>
                            <?php cs_show_all_cats('', '', $cs_artist_category_db, "artists-category");?>
                        </select>
                    </li>
                </ul>
               <input type="hidden" name="cs_artist_per_page[]" class="txtfield" value="<?php echo $cs_artist_per_page_db; ?>" />
                <!--<ul class="form-elements">
                    <li class="to-label"><label>No. of Artists Per Page</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_artist_per_page[]" class="txtfield" value="<?php echo $cs_artist_per_page_db; ?>" />
                        <p>To display all the records, leave this field blank.</p>
						<p>For best view of page Enter more then 20 Records per page</p>
                    </li>
                </ul>-->
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="artists" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_artists', 'cs_pb_artists');
// Artist html form for page builder end
// Artist html form for page builder start
function cs_pb_album($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$album_element_size = '100';
		$cs_album_cat_db = '';
		$cs_album_title = '';
		$cs_album_filterable_db = '';
		$cs_album_cat_show_db = '';
		$cs_album_buynow_db = '';
 		$cs_album_per_page_db = '40';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$album_element_size = $cs_node->album_element_size;
			$cs_album_title = $cs_node->cs_album_title;
			$cs_album_cat_db = $cs_node->cs_album_cat;
			$cs_album_filterable_db = $cs_node->cs_album_filterable;
			$cs_album_cat_show_db = $cs_node->cs_album_cat_show;
			$cs_album_buynow_db = $cs_node->cs_album_buynow;
 			$cs_album_per_page_db = $cs_node->cs_album_per_page;
				$counter = $post->ID.$count_node;
	}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column column_<?php echo $album_element_size?>" item="album" data="<?php echo cs_element_size_data_array_index($album_element_size)?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="album_element_size[]" class="item" value="<?php echo $album_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a>
            <a href="javascript:delete_this('<?php echo $name.$counter?>')" class="delete-it" onclick="return confirm('Are you sure, you want to delete this?')">Del</a>
 		</div>
        <div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Album Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Album Title</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_album_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_album_title)?>" />
                        <p>Album Page Title</p>
                    </li>                                            
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Choose Category</label></li>
                    <li class="to-field">
                        <select name="cs_album_cat[]" class="dropdown">
                             <option value="all" <?php if($cs_album_cat_db == "all"){ echo 'selected';}?>> All</option>
                        	<?php cs_show_all_cats('', '', $cs_album_cat_db, "album-category");?>
                        </select>
                        <p>Choose category to show albums list</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Show Category</label></li>
                    <li class="to-field">
                        <select name="cs_album_cat_show[]" class="dropdown">
                            <option <?php if($cs_album_cat_show_db=="On")echo "selected";?> >On</option>
                            <option <?php if($cs_album_cat_show_db=="Off")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Buy Now</label></li>
                    <li class="to-field">
                        <select name="cs_album_buynow[]" class="dropdown">
                            <option <?php if($cs_album_buynow_db=="On")echo "selected";?> >On</option>
                            <option <?php if($cs_album_buynow_db=="Off")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Filterable</label></li>
                    <li class="to-field">
                        <select name="cs_album_filterable[]" class="dropdown" onchange="cs_toggle_tog('pagination<?php echo $name.$counter?>')">
                            <option <?php if($cs_album_filterable_db=="Off")echo "selected";?> >Off</option>
                            <option <?php if($cs_album_filterable_db=="On")echo "selected";?> >On</option>
                        </select>
                    </li>
                </ul>
                <input type="text" name="cs_album_per_page[]" class="txtfield" value="<?php if($cs_album_per_page_db=="")echo "40"; else echo $cs_album_per_page_db;?>" />
                	<!--<div id="pagination<?php echo $name.$counter?>" <?php if($cs_album_filterable_db=="On")echo 'class="no-display"'?> >
                        
                        <ul class="form-elements">
                            <li class="to-label"><label>No. of Album Per Page</label></li>
                            <li class="to-field">
                                <input type="text" name="cs_album_per_page[]" class="txtfield" value="<?php if($cs_album_per_page_db=="")echo "5"; else echo $cs_album_per_page_db;?>" />
                            	<p>For best view of page Enter more then 20 Records per page</p>
							</li>
							
                        </ul>
						
					</div>-->
                <ul class="form-elements noborder">
                    <li class="to-label"><label></label></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="album" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_album', 'cs_pb_album');

/* Add Albums tracks */
function cs_add_track_to_list(){
	global $counter_track, $album_track_title, $album_track_mp3_url , $album_track_playable, $album_track_downloadable, $album_track_lyrics, $album_track_buy_mp3 ;
	foreach ($_POST as $keys=>$values) {
		$$keys = $values;
	}
?>
    <tr id="edit_track<?php echo $counter_track?>">
        <td id="album-title<?php echo $counter_track?>" style="width:80%;"><?php echo $album_track_title?></td>
        <td class="centr" style="width:20%;">
            <a href="javascript:openpopedup('edit_track_form<?php echo $counter_track?>')" class="actions edit">&nbsp;</a>
            <a onclick="javascript:return confirm('Are you sure! You want to delete this Track')" href="javascript:cs_div_remove('edit_track<?php echo $counter_track?>')" class="actions delete">&nbsp;</a>
            <div class="poped-up" id="edit_track_form<?php echo $counter_track?>">
                <div class="opt-head">
                    <h5>Track Settings</h5>
                    <a href="javascript:closepopedup('edit_track_form<?php echo $counter_track?>')" class="closeit">&nbsp;</a>
                    <div class="clear"></div>
                </div>
                <ul class="form-elements">
                    <li class="to-label"><label>Track Title</label></li>
                    <li class="to-field">
                        <input type="text" name="album_track_title[]" value="<?php echo htmlspecialchars($album_track_title)?>" id="album_track_title<?php echo $counter_track?>" />
                        <p>Put album track title</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Track MP3 URL</label></li>
                    <li class="to-field">
                        <input id="album_track_mp3_url<?php echo $counter_track?>" name="album_track_mp3_url[]" value="<?php echo htmlspecialchars($album_track_mp3_url)?>" type="text" class="small" />
                        <input id="album_track_mp3_url<?php echo $counter_track?>" name="album_track_mp3_url<?php echo $counter_track?>" type="button" class="uploadfile left" value="Browse"/>
                        <p>Put album track mp3 url</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Playable</label></li>
                    <li class="to-field">
                        <select name="album_track_playable[]" class="dropdown">
                            <option <?php if($album_track_playable=="Yes")echo "selected";?> >Yes</option>
                            <option <?php if($album_track_playable=="No")echo "selected";?> >No</option>
                        </select>
                        <p>Make Playable on/off</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Downloadable</label></li>
                    <li class="to-field">
                        <select name="album_track_downloadable[]" class="dropdown">
                            <option <?php if($album_track_downloadable=="Yes")echo "selected";?> >Yes</option>
                            <option <?php if($album_track_downloadable=="No")echo "selected";?> >No</option>
                        </select>
                        <p>Make Playable on/off</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Lyrics</label></li>
                    <li class="to-field">
                        <textarea name="album_track_lyrics[]"><?php echo htmlspecialchars($album_track_lyrics)?></textarea>
                        <p>Put album track mp3 url</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Buy MP3 URL</label></li>
                    <li class="to-field">
                        <input type="text" name="album_track_buy_mp3[]" value="<?php echo htmlspecialchars($album_track_buy_mp3)?>" />
                        <p>Put album track mp3 url</p>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label></label></li>
                    <li class="to-field"><input type="button" value="Update Track" onclick="update_title(<?php echo $counter_track?>); closepopedup('edit_track_form<?php echo $counter_track?>')" /></li>
                </ul>
            </div>
        </td>
    </tr>
<?php
	if ( isset($action) ) die();
}
add_action('wp_ajax_cs_add_track_to_list', 'cs_add_track_to_list');
// contact us html form for page builder start
function cs_pb_contact($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$contact_element_size = '100';
 		$cs_contact_email_db = '';
		$cs_contact_form_text_db = '';
		$cs_contact_succ_msg_db = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$contact_element_size = $cs_node->contact_element_size;
 			$cs_contact_email_db = $cs_node->cs_contact_email;
			$cs_contact_form_text_db = $cs_node->cs_contact_form_text;
			$cs_contact_succ_msg_db = $cs_node->cs_contact_succ_msg;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $contact_element_size?>" item="contact" data="<?php echo cs_element_size_data_array_index($contact_element_size)?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="contact_element_size[]" class="item" value="<?php echo $contact_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a>
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;
 		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Contact Form</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
				<ul class="form-elements">
                    <li class="to-label"><label>Contact Email</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_contact_email[]" class="txtfield" value="<?php if($cs_contact_email_db=="") echo get_option("admin_email"); else echo $cs_contact_email_db;?>" />
                        <p>Please enter Contact email Address.</p>
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Successful Message</label></li>
                    <li class="to-field"><textarea name="cs_contact_succ_msg[]"><?php if($cs_contact_succ_msg_db=="")echo "Email Sent Successfully.\nThank you, your message has been submitted to us."; else echo $cs_contact_succ_msg_db;?></textarea></li>
                </ul>
				<ul class="form-elements">
                    <li class="to-label"><label>Conatact Text</label></li>
                    <li class="to-field"><textarea name="cs_contact_form_text[]"><?php if($cs_contact_form_text_db=="")echo ""; else echo $cs_contact_form_text_db;?></textarea></li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="contact" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_contact', 'cs_pb_contact');
// contact us html form for page builder end

// column html form for page builder start
function cs_pb_column($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$column_element_size = '100';
		$column_text = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$column_element_size = $cs_node->column_element_size;
			$column_text = $cs_node->column_text;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $column_element_size?>" item="column" data="<?php echo cs_element_size_data_array_index($column_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="column_element_size[]" class="item" value="<?php echo $column_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
 		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Column Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Column Text</label></li>
                    <li class="to-field">
                    	<textarea name="column_text[]"><?php echo $column_text?></textarea>
                        <p>Shortcodes and HTML tags allowed.</p>
                    </li>                  
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="column" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_column', 'cs_pb_column');
// column html form for page builder end 

// google map html form for page builder start
function cs_pb_map($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$map_element_size = '100';
		$map_title = '';
		$map_height = '';
		$map_width = '';
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
		$map_view= '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$map_element_size = $cs_node->map_element_size;
			$map_title 	= $cs_node->map_title;
			$map_height = $cs_node->map_height;
			$map_width = $cs_node->map_width;
			$map_lat 	= $cs_node->map_lat;
			$map_lon 	= $cs_node->map_lon;
			$map_zoom 	= $cs_node->map_zoom;
			$map_type = $cs_node->map_type;
			$map_info = $cs_node->map_info;
			$map_info_width = $cs_node->map_info_width;
			$map_info_height = $cs_node->map_info_height;
			$map_marker_icon = $cs_node->map_marker_icon;
			$map_show_marker = $cs_node->map_show_marker;
			$map_controls = $cs_node->map_controls;
			$map_draggable = $cs_node->map_draggable;
			$map_scrollwheel = $cs_node->map_scrollwheel;
			$map_view 	= $cs_node->map_view;
			$counter 	= $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $map_element_size?>" item="map" data="<?php echo cs_element_size_data_array_index($map_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="map_element_size[]" class="item" value="<?php echo $map_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
 		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Map Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Title</label></li>
                    <li class="to-field"><input type="text" name="map_title[]" class="txtfield" value="<?php echo $map_title?>" /></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Map Width</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_width[]" class="txtfield" value="<?php echo $map_width?>" />
                        <p>Max Width in PX (Default is 200)</p>
                    </li>
                </ul>
				<ul class="form-elements">
                    <li class="to-label"><label>Map Height</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_height[]" class="txtfield" value="<?php echo $map_height?>" />
                        <p>Max Height in % (Default is 100)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Latitude</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_lat[]" class="txtfield" value="<?php echo $map_lat?>" />
                        <p>Put Latitude (Default is 0)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Longitude</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_lon[]" class="txtfield" value="<?php echo $map_lon?>" />
                        <p>Put Longitude (Default is 0)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Zoom</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_zoom[]" class="txtfield" value="<?php echo $map_zoom?>" />
                        <p>Put Zoom Level (Default is 11)</p>
                    </li>
                </ul>
                <ul class="form-elements">
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
                <ul class="form-elements">
                    <li class="to-label"><label>Info Text</label></li>
                    <li class="to-field"><input type="text" name="map_info[]" class="txtfield" value="<?php echo $map_info?>" /></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Info Max Width</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_info_width[]" class="txtfield" value="<?php echo $map_info_width?>" />
                        <p>Info Max Width in PX (Default is 200)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Info Max Height</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_info_height[]" class="txtfield" value="<?php echo $map_info_height?>" />
                        <p>Info Max Height in PX (Default is 100)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Marker Icon Path</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_marker_icon[]" class="txtfield" value="<?php echo $map_marker_icon?>" />
                        <p>e.g. http://yourdomain.com/logo.png</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Show Marker</label></li>
                    <li class="to-field">
                        <select name="map_show_marker[]" class="dropdown" >
                            <option value="true" <?php if($map_show_marker=="true")echo "selected";?> >On</option>
                            <option value="false" <?php if($map_show_marker=="false")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Disable Map Controls</label></li>
                    <li class="to-field">
                        <select name="map_controls[]" class="dropdown" >
                            <option value="false" <?php if($map_controls=="false")echo "selected";?> >Off</option>
                            <option value="true" <?php if($map_controls=="true")echo "selected";?> >On</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Draggable</label></li>
                    <li class="to-field">
                        <select name="map_draggable[]" class="dropdown" >
                            <option value="true" <?php if($map_draggable=="true")echo "selected";?> >On</option>
                            <option value="false" <?php if($map_draggable=="false")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Scroll Wheel</label></li>
                    <li class="to-field">

                        <select name="map_scrollwheel[]" class="dropdown" >
                            <option value="true" <?php if($map_scrollwheel=="true")echo "selected";?> >On</option>
                            <option value="false" <?php if($map_scrollwheel=="false")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                 <ul class="form-elements">
                    <li class="to-label"><label>Map View</label></li>
                    <li class="to-field">
                        <select name="map_view[]" class="dropdown" >
                            <option <?php if($map_view=="content")echo "selected";?> >content</option>
                            <option <?php if($map_view=="header")echo "selected";?> >header</option>
                         </select>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="map" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>

       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_map', 'cs_pb_map');
// google map html form for page builder end


// page bulider items end


function cs_element_size_data_array_index($size){
	if ( $size == "" or $size == 100 ) return 0;
	else if ( $size == 75 ) return 1;
	else if ( $size == 50 ) return 2;
	else if ( $size == 25 ) return 3;
}
// Show all Categories
function cs_show_all_cats($parent, $separator, $selected = "", $taxonomy) {
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
        cs_show_all_cats($category->term_id, $separator, $selected, $taxonomy);
    }
}
// Events Meta data save
function cs_events_meta_save($post_id) {
    global $wpdb;
	$inside_event_artists = '';
	if (empty($_POST["inside_event_gallery"])){ $_POST["inside_event_gallery"] = "";}
	if (empty($_POST["cs_images_per_gallery"])){ $_POST["cs_images_per_gallery"] = "";}
    if (empty($_POST["event_social_sharing"])){ $_POST["event_social_sharing"] = "";}
	if (empty($_POST["event_start_time"])){ $_POST["event_start_time"] = "";}
	if (empty($_POST["event_end_time"])){ $_POST["event_end_time"] = "";}
    if (empty($_POST["event_all_day"])){ $_POST["event_all_day"] = "";}
	if (empty($_POST["event_ticket_price"])){ $_POST["event_ticket_price"] = "";}
	if (empty($_POST["event_ticket_url"])){ $_POST["event_ticket_url"] = "";}
    if (empty($_POST["event_address"])){ $_POST["event_address"] = "";}
    if (empty($_POST["event_map"])){ $_POST["event_map"] = "";}
	if (empty($_POST["inside_event_artists"])){ $inside_event_artists = "";} else {
		$inside_event_artists = implode(",", $_POST["inside_event_artists"]);
	 }
	 if (empty($_POST["event_rating"])){ $_POST["event_rating"] = "";}

    $sxe = new SimpleXMLElement("<event></event>");
		$sxe->addChild('inside_event_gallery', $_POST["inside_event_gallery"]);
		$sxe->addChild('cs_images_per_gallery', $_POST["cs_images_per_gallery"]);
 		$sxe->addChild('event_social_sharing', $_POST["event_social_sharing"]);
 		$sxe->addChild('event_start_time', $_POST["event_start_time"]);
		$sxe->addChild('event_end_time', $_POST["event_end_time"]);
		$sxe->addChild('event_all_day', $_POST["event_all_day"]);
		$sxe->addChild('event_ticket_price', $_POST["event_ticket_price"]);
		$sxe->addChild('event_ticket_url', $_POST["event_ticket_url"]);
 		$sxe->addChild('event_address', $_POST["event_address"]);
		$sxe->addChild('event_map', $_POST["event_map"]);
		$sxe->addChild('event_rating', $_POST["event_rating"]);
		$sxe->addChild('inside_event_artists', $inside_event_artists);
    update_post_meta($post_id, 'cs_event_meta', $sxe->asXML());
}
// Get Google Fonts
function cs_get_google_fonts() {
    $fonts = array("Abel", "Aclonica", "Acme", "Actor", "Advent Pro", "Aldrich", "Allerta", "Allerta Stencil", "Amaranth", "Andika", "Anonymous Pro", "Antic", "Anton", "Arimo", "Armata", "Asap", "Asul",
        "Basic", "Belleza", "Cabin", "Cabin Condensed", "Cagliostro", "Candal", "Cantarell", "Carme", "Chau Philomene One", "Chivo", "Coda Caption", "Comfortaa", "Convergence", "Cousine", "Cuprum", "Days One",
        "Didact Gothic", "Doppio One", "Dorsa", "Dosis", "Droid Sans", "Droid Sans Mono", "Duru Sans", "Economica", "Electrolize", "Exo", "Federo", "Francois One", "Fresca", "Galdeano", "Geo", "Gudea",
        "Hammersmith One", "Homenaje", "Imprima", "Inconsolata", "Inder", "Istok Web", "Jockey One", "Josefin Sans", "Jura", "Karla", "Krona One", "Lato", "Lekton", "Magra", "Mako", "Marmelad", "Marvel",
        "Maven Pro", "Metrophobic", "Michroma", "Molengo", "Montserrat", "Muli", "News Cycle", "Nobile", "Numans", "Nunito", "Open Sans", "Open Sans Condensed", "Orbitron", "Oswald", "Oxygen", "PT Mono",
        "PT Sans", "PT Sans Caption", "PT Sans Narrow", "Paytone One", "Philosopher", "Play", "Pontano Sans", "Port Lligat Sans", "Puritan", "Quantico", "Quattrocento Sans", "Questrial", "Quicksand", "Rationale",
        "Ropa Sans", "Rosario", "Ruda", "Ruluko", "Russo One", "Shanti", "Sigmar One", "Signika", "Signika Negative", "Six Caps", "Snippet", "Spinnaker", "Syncopate", "Telex", "Tenor Sans", "Ubuntu",
        "Ubuntu Condensed", "Ubuntu Mono", "Varela", "Varela Round", "Viga", "Voltaire", "Wire One", "Yanone Kaffeesatz", "Adamina", "Alegreya", "Alegreya SC", "Alice", "Alike", "Alike Angular", "Almendra",
        "Almendra SC", "Amethysta", "Andada", "Antic Didone", "Antic Slab", "Arapey", "Artifika", "Arvo", "Average", "Balthazar", "Belgrano", "Bentham", "Bevan", "Bitter", "Brawler", "Bree Serif", "Buenard",
        "Cambo", "Cantata One", "Cardo", "Caudex", "Copse", "Coustard", "Crete Round", "Crimson Text", "Cutive", "Della Respira", "Droid Serif", "EB Garamond", "Enriqueta", "Esteban", "Fanwood Text", "Fjord One",
        "Gentium Basic", "Gentium Book Basic", "Glegoo", "Goudy Bookletter 1911", "Habibi", "Holtwood One SC", "IM Fell DW Pica", "IM Fell DW Pica SC", "IM Fell Double Pica", "IM Fell Double Pica SC",
        "IM Fell English", "IM Fell English SC", "IM Fell French Canon", "IM Fell French Canon SC", "IM Fell Great Primer", "IM Fell Great Primer SC", "Inika", "Italiana", "Josefin Slab", "Judson", "Junge",
        "Kameron", "Kotta One", "Kreon", "Ledger", "Linden Hill", "Lora", "Lusitana", "Lustria", "Marko One", "Mate", "Mate SC", "Merriweather", "Montaga", "Neuton", "Noticia Text", "Old Standard TT", "Ovo",
        "PT Serif", "PT Serif Caption", "Petrona", "Playfair Display", "Podkova", "Poly", "Port Lligat Slab", "Prata", "Prociono", "Quattrocento", "Radley", "Rokkitt", "Rosarivo", "Simonetta", "Sorts Mill Goudy",
        "Stoke", "Tienne", "Tinos", "Trocchi", "Trykker", "Ultra", "Unna", "Vidaloka", "Volkhov", "Vollkorn", "Abril Fatface", "Aguafina Script", "Aladin", "Alex Brush", "Alfa Slab One", "Allan", "Allura",
        "Amatic SC", "Annie Use Your Telescope", "Arbutus", "Architects Daughter", "Arizonia", "Asset", "Astloch", "Atomic Age", "Aubrey", "Audiowide", "Averia Gruesa Libre", "Averia Libre", "Averia Sans Libre",
        "Averia Serif Libre", "Bad Script", "Bangers", "Baumans", "Berkshire Swash", "Bigshot One", "Bilbo", "Bilbo Swash Caps", "Black Ops One", "Bonbon", "Boogaloo", "Bowlby One", "Bowlby One SC",
        "Bubblegum Sans", "Buda", "Butcherman", "Butterfly Kids", "Cabin Sketch", "Caesar Dressing", "Calligraffitti", "Carter One", "Cedarville Cursive", "Ceviche One", "Changa One", "Chango", "Chelsea Market",
        "Cherry Cream Soda", "Chewy", "Chicle", "Coda", "Codystar", "Coming Soon", "Concert One", "Condiment", "Contrail One", "Cookie", "Corben", "Covered By Your Grace", "Crafty Girls", "Creepster", "Crushed",
        "Damion", "Dancing Script", "Dawning of a New Day", "Delius", "Delius Swash Caps", "Delius Unicase", "Devonshire", "Diplomata", "Diplomata SC", "Dr Sugiyama", "Dynalight", "Eater", "Emblema One",
        "Emilys Candy", "Engagement", "Erica One", "Euphoria Script", "Ewert", "Expletus Sans", "Fascinate", "Fascinate Inline", "Federant", "Felipa", "Flamenco", "Flavors", "Fondamento", "Fontdiner Swanky",
        "Forum", "Fredericka the Great", "Fredoka One", "Frijole", "Fugaz One", "Geostar", "Geostar Fill", "Germania One", "Give You Glory", "Glass Antiqua", "Gloria Hallelujah", "Goblin One", "Gochi Hand",
        "Gorditas", "Graduate", "Gravitas One", "Great Vibes", "Gruppo", "Handlee", "Happy Monkey", "Henny Penny", "Herr Von Muellerhoff", "Homemade Apple", "Iceberg", "Iceland", "Indie Flower", "Irish Grover",
        "Italianno", "Jim Nightshade", "Jolly Lodger", "Julee", "Just Another Hand", "Just Me Again Down Here", "Kaushan Script", "Kelly Slab", "Kenia", "Knewave", "Kranky", "Kristi", "La Belle Aurore",
        "Lancelot", "League Script", "Leckerli One", "Lemon", "Lilita One", "Limelight", "Lobster", "Lobster Two", "Londrina Outline", "Londrina Shadow", "Londrina Sketch", "Londrina Solid",
        "Love Ya Like A Sister", "Loved by the King", "Lovers Quarrel", "Luckiest Guy", "Macondo", "Macondo Swash Caps", "Maiden Orange", "Marck Script", "Meddon", "MedievalSharp", "Medula One", "Megrim",
        "Merienda One", "Metamorphous", "Miltonian", "Miltonian Tattoo", "Miniver", "Miss Fajardose", "Modern Antiqua", "Monofett", "Monoton", "Monsieur La Doulaise", "Montez", "Mountains of Christmas",
        "Mr Bedfort", "Mr Dafoe", "Mr De Haviland", "Mrs Saint Delafield", "Mrs Sheppards", "Mystery Quest", "Neucha", "Niconne", "Nixie One", "Norican", "Nosifer", "Nothing You Could Do", "Nova Cut",
        "Nova Flat", "Nova Mono", "Nova Oval", "Nova Round", "Nova Script", "Nova Slim", "Nova Square", "Oldenburg", "Oleo Script", "Original Surfer", "Over the Rainbow", "Overlock", "Overlock SC", "Pacifico",
        "Parisienne", "Passero One", "Passion One", "Patrick Hand", "Patua One", "Permanent Marker", "Piedra", "Pinyon Script", "Plaster", "Playball", "Poiret One", "Poller One", "Pompiere", "Press Start 2P",
        "Princess Sofia", "Prosto One", "Qwigley", "Raleway", "Rammetto One", "Rancho", "Redressed", "Reenie Beanie", "Revalia", "Ribeye", "Ribeye Marrow", "Righteous", "Rochester", "Rock Salt", "Rouge Script",
        "Ruge Boogie", "Ruslan Display", "Ruthie", "Sail", "Salsa", "Sancreek", "Sansita One", "Sarina", "Satisfy", "Schoolbell", "Seaweed Script", "Sevillana", "Shadows Into Light", "Shadows Into Light Two",
        "Share", "Shojumaru", "Short Stack", "Sirin Stencil", "Slackey", "Smokum", "Smythe", "Sniglet", "Sofia", "Sonsie One", "Special Elite", "Spicy Rice", "Spirax", "Squada One", "Stardos Stencil",
        "Stint Ultra Condensed", "Stint Ultra Expanded", "Sue Ellen Francisco", "Sunshiney", "Supermercado One", "Swanky and Moo Moo", "Tangerine", "The Girl Next Door", "Titan One", "Trade Winds", "Trochut",
        "Tulpen One", "Uncial Antiqua", "UnifrakturCook", "UnifrakturMaguntia", "Unkempt", "Unlock", "VT323", "Vast Shadow", "Vibur", "Voces", "Waiting for the Sunrise", "Wallpoet", "Walter Turncoat",
        "Wellfleet", "Yellowtail", "Yeseva One", "Yesteryear", "Zeyada");
    return $fonts;
}
//Countries Array
function cs_get_countries() {
    $get_countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan",
        "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "British Virgin Islands",
        "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China",
        "Colombia", "Comoros", "Costa Rica", "Croatia", "Cuba", "Cyprus", "Czech Republic", "Democratic People's Republic of Korea", "Democratic Republic of the Congo", "Denmark", "Djibouti",
        "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "England", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Fiji", "Finland", "France", "French Polynesia",
        "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea Bissau", "Guyana", "Haiti", "Honduras", "Hong Kong",
        "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Kosovo", "Kuwait", "Kyrgyzstan",
        "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macao", "Macedonia", "Madagascar", "Malawi", "Malaysia",
        "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mauritius", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique",
        "Myanmar(Burma)", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Northern Ireland",
        "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Palestine", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Puerto Rico",
        "Qatar", "Republic of the Congo", "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa",
        "San Marino", "Saudi Arabia", "Scotland", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa",
        "South Korea", "Spain", "Sri Lanka", "Sudan", "Suriname", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Timor-Leste", "Togo", "Tonga",
        "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "US Virgin Islands", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay",
        "Uzbekistan", "Vanuatu", "Vatican", "Venezuela", "Vietnam", "Wales", "Yemen", "Zambia", "Zimbabwe");
    return $get_countries;
}
// Default xml data save
function cs_save_layout_xml($sxe) {}
// installing tables on theme activating start
	global $pagenow, $header1_default_colors;
            $header1_default_colors = array(
            //Header 1 array
				'header_1_bg_color' => '#303030',
			   	'header_1_logo' => 'on',
			   	'header_1_social_icons' => 'on',
 			   	'header_1_nav_color' => '#ffffff',
			   	'header_1_nav_hover_color' => '',
			   	'header_1_nav_hover_bgcolor' => '',
			   	'header_1_nav_active_color' => '',
			   	'header_1_nav_active_bgcolor' => '',
			   	'header_1_subnav_bgcolr' => '',
			   	'header_1_subnav_color' => '#999999',
			   	'header_1_subnav_hover_color' => '',
			   	'header_1_subnav_hover_bgcolor' => '',
			   	'header_1_subnav_active_color' => '',
			   	'header_1_subnav_active_bgcolor' => ''
			
            );

if (is_admin() && isset($_GET['activated']) && $pagenow == 'themes.php'){
	// Theme default widgets activation
    add_action('admin_head', 'cs_activate_widget');
	function cs_activate_widget(){
		$sidebars_widgets = get_option('sidebars_widgets');  //collect widget informations
		//---Blog Categories
		$categories = array();
		$categories[1] = array(
		"title"		=>	'Featured Categories',
		"count" => ''
		);
						
		$calendar['_multiwidget'] = '1';
		update_option('widget_categories',$categories);
		$categories = get_option('widget_categories');
		krsort($categories);
		foreach($categories as $key1=>$val1)
		{
			$categories_key = $key1;
			if(is_int($categories_key))
			{
				break;
			}
		}
		// ----   recent post with thumbnail widget setting---
		$recent_post_widget = array();
		$recent_post_widget[1] = array(
		"title"		=>	'Featured Blogs',
		"select_category" 	=> 'blog',
		"showcount" => '3',
		"thumb" => 'true'
		 );						
		$recent_post_widget['_multiwidget'] = '1';
		update_option('widget_cs_recentposts',$recent_post_widget);
		$recent_post_widget = get_option('widget_cs_recentposts');
		krsort($recent_post_widget);
		foreach($recent_post_widget as $key1=>$val1)
		{
			$recent_post_widget_key = $key1;
			if(is_int($recent_post_widget_key))
			{
				break;
			}
		}
		// --- text widget setting ---
  		$text['_multiwidget'] = '1';
		update_option('widget_text',$text);
		$text = get_option('widget_text');
		krsort($text);
		foreach($text as $key1=>$val1)
		{
			$text_key = $key1;
			if(is_int($text_key))
			{
				break;
			}
		}
		// --- gallery widget setting ---
		$cs_gallery = array();
		$cs_gallery[1] = array(
			'title' => 'Our Photos',
			'get_names_gallery' => 'gallery',
			'showcount' => '12'
		);						
		$cs_gallery['_multiwidget'] = '1';
		update_option('widget_cs_gallery',$cs_gallery);
		$cs_gallery = get_option('widget_cs_gallery');
		krsort($cs_gallery);
		foreach($cs_gallery as $key1=>$val1)
		{
			$cs_gallery_key = $key1;
			if(is_int($cs_gallery_key))
			{
				break;
			}
		}
		// --- facebook widget setting-----
		$facebook_module = array();
		$facebook_module[1] = array(
		"title"		=>	'facebook widget',
		"pageurl" 	=>	"https://www.facebook.com/envato",
		"showfaces" => "on",
		"likebox_height" => "265",
		"fb_bg_color" =>"#fff",
		);						
		$facebook_module['_multiwidget'] = '1';
		update_option('widget_cs_facebook_module',$facebook_module);
		$facebook_module = get_option('widget_cs_facebook_module');
		krsort($facebook_module);
		foreach($facebook_module as $key1=>$val1)
		{
			$facebook_module_key = $key1;
			if(is_int($facebook_module_key))
			{
				break;
			}
		}
		// Add widgets in sidebars
		$sidebars_widgets['Sidebar'] = array("categories-$categories_key","cs_gallery-$cs_gallery_key","cs_recentposts-$recent_post_widget_key");
		update_option('sidebars_widgets',$sidebars_widgets);  //save widget iformations
	}
	// Install data on theme activation
    add_action('init', 'cs_install_tables');
	
	function cs_install_tables() {
		global $wpdb, $header1_default_colors;
    		
		$args = array(
			'style_sheet' => 'custom',
			'custom_color_scheme' => '#242423',
			'custom_color_style' => '#242423',
			// Header Color Settings
 			'header_bg_color' => '#303030',

			'header_styles' => 'header1',
			'default_header' => 'header1',
			
			
			'logo' => get_template_directory_uri().'/images/logo.png',
			'logo_width' => '140',
			'logo_height' => '43',
			'fav_icon' => get_template_directory_uri() . '/images/favicon.png',
			'header_code' => '',
			'header_link_title' => '',
			'header_link_url' => '',
			'analytics' => '',
			'copyright' =>  'Copyrights &copy;'.gmdate("Y")." ".get_option("blogname")." Wordpress All rights reserved.", 
 			// switchers
			'color_switcher' => '',
			'trans_switcher' => '',
			'show_slider' => '',
			'slider_name' => 'home-slider',
			'slider_type' => 'Flex Slider',
			'show_album' => '',
			'album_title' => 'Release Notes',
			'album_description' => 'Tempor odio vitae metus vestibulum viverra. Cras non placerat sem. Donec purus felis, pharetra quis fermentum et, placerat non leo. Mauris vel bibendum sapien. Sed at cursus qupharetra quis fermentum et, placerat non leo. am. Sed cursus ut nibh id blandit..',
			'cs_album_category' => 'music',
			'all_cat' => array(),
 			'h1_g_font' => '',
			'h2_g_font' => '',
			'h3_g_font' => '',
			'h4_g_font' => '',
			'h5_g_font' => '',
			'h6_g_font' => '',
			'page_title_g_font' => '',
			'widget_heading_size_g_font' => '',
			'content_size_g_font' => '',
			'sidebar' => array( 'Sidebar'),
			// slider setting
			'flex_effect' => 'fade',
			'flex_auto_play' => 'on',
			'flex_animation_speed' => '7000',
			'flex_pause_time' => '600',
			'slider_id' => '',
			'slider_view' => '',
			'social_net_title' => 'Follow US',
			'social_net_icon_path' => array('', '', '', '', '', '', '', '', '', ''),
			'social_net_awesome' => array( 'fa-facebook', 'fa-twitter', 'fa-google-plus', 'fa-dribbble', 'fa-linkedin', 'fa-youtube', 'fa-instagram', 'fa-pinterest', 'fa-tumblr', 'fa-flickr' ),
			'social_net_url' => array( 'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK', 
								'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK', 
								'YOUR_PROFILE_LINK'
								),
			'social_net_tooltip' => array( 'Facebook', 'Twitter', 'Google Plus', 'Dribble', 'Linked In', 'Youtube', 'Instagram', 'Pinterest', 'Tumblr', 'Flickr' ),
			'facebook_share' => 'on',
			'twitter_share' => 'on',
			'linkedin_share' => 'on',
			'myspace_share' => '',
			'digg_share' => 'on',
			'stumbleupon_share' => 'on',
			'reddit_share' => 'on',
			'pinterest_share' => 'on',
			'tumblr_share' => 'on',
			'google_plus_share' => 'on',
			'blogger_share' => 'on',
			'amazon_share' => 'on',
			// tranlations
			
			'trans_start_date' => 'Event Date',
			'trans_days_to_go' => 'Days to go!',
            'trans_buy_ticket' => 'Buy Ticket',
            'trans_ticket' => 'Ticket',
            'trans_featured_artist' => 'Featured Artist',
            'trans_event_from' => 'From:',
			'trans_sponcers' => 'Sponcers',
			'trans_days_before' => 'Days Past',
			
			'trans_release_date' => 'Release Date',
			'trans_track' => 'Tracks',
			'trans_buy_now' => 'Buy Now',
			
			'trans_albums' => 'Albums',
			'trans_featured_story' => 'Featured Story',
			'trans_genre' => 'Genre',
			'trans_hometown' => 'Hometown',
			'trans_started' => 'Started',
			'trans_live_link' => 'Live Link',
			'trans_discography' => 'Discography',
			
            'trans_subject' => 'Subject',
            'trans_message' => 'Message',
            'trans_form_title' => 'Send us a Quick Message',
			
			'trans_follow' => 'Follow Us',
            'trans_share_this_post' => 'Share',
            'trans_content_404' => "It seems we can not find what you are looking for.",
            'trans_full_album' => 'Full Album',
			'trans_featured' => 'Featured',
			'trans_listed_in' => 'Listed in',
			'trans_filter_by' => 'Featured Categories',
			'trans_read_more' => 'read more',
			'trans_likes' => 'Likes',
			'trans_like' => 'Like',
			'trans_load_more' => 'Load More',
			'trans_sign_in' => 'Sign In',
			
			// translation end
           	//'pagination' => 'Show Pagination',
			'record_per_page' => '25',
			'uc_logo' => get_template_directory_uri().'/images/logo.png',
			'uc_logo_width' => '167',
			'uc_logo_height' => '26',
			'under-construction' => '',
			'showlogo' => 'on',
			'socialnetwork' => 'on',
			'under_construction_text' => '<h1>OUR WEBSITE IS UNDERCONSTRUCTION</h1><h4>We\'ll be here soon with a new website, Estimated Time Remaining</h4>',
			'launch_date' => '2014-12-01',
 			'consumer_key' => '',
			'consumer_secret' => '',
			'access_token' => '',
			'access_token_secret' => '',
			'cs_posts_per_page' => '8',
		);
		/* Merge Heaser styles
		*/
        $args = array_merge($args, $header1_default_colors);
		update_option("cs_theme_option", $args );
		update_option("cs_theme_option_restore", $args );
		update_option("show_on_front", 'page' );
	}
}

// Admin scripts enqueue
function cs_admin_scripts_enqueue() {
    $template_path = get_template_directory_uri() . '/scripts/admin/media_upload.js';
    wp_enqueue_script('my-upload', $template_path, array('jquery', 'media-upload', 'thickbox', 'jquery-ui-droppable', 'jquery-ui-datepicker', 'jquery-ui-slider', 'wp-color-picker'));
    wp_enqueue_script('custom_wp_admin_script', get_template_directory_uri() . '/scripts/admin/cs_functions.js');
    wp_enqueue_style('custom_wp_admin_style', get_template_directory_uri() . '/css/admin/admin-style.css', array('thickbox'));
	wp_enqueue_style('wp-color-picker');
}
add_action('admin_enqueue_scripts', 'cs_admin_scripts_enqueue');
// Backend functionality files

require_once (TEMPLATEPATH . '/include/event.php');
require_once (TEMPLATEPATH . '/include/slider.php');
require_once (TEMPLATEPATH . '/include/gallery.php');
require_once (TEMPLATEPATH . '/include/theme_option.php');
require_once (TEMPLATEPATH . '/include/page_builder.php');
require_once (TEMPLATEPATH . '/include/post_meta.php');
require_once (TEMPLATEPATH . '/include/short_code.php');
require_once (TEMPLATEPATH . '/include/artist.php');
require_once (TEMPLATEPATH . '/include/album.php');
require_once (TEMPLATEPATH . '/functions-theme.php');

// Addmin Menu CS Theme Option
add_action('admin_menu', 'cs_theme');
function cs_theme() {
	add_theme_page('CS Theme Option', 'CS Theme Option', 'read', 'cs_theme_options', 'theme_option');
}

// add short code in widget area
add_filter('widget_text', 'do_shortcode'); 


if (!session_id()) add_action('init', 'session_start');


// add twitter option in user profile
function cs_contact_options( $contactoptions ) {
	$contactoptions['twitter'] = 'Twitter';
	return $contactoptions;
}
add_filter('user_contactmethods','cs_contact_options',10,1);

// Template redirect in single Gallery and Slider page
function cs_slider_gallery_template_redirect(){
    if ( get_post_type() == "cs_gallery" or get_post_type() == "cs_slider" ) {
		global $wp_query;
		$wp_query->set_404();
		status_header( 404 );
		get_template_part( 404 ); exit();
    }
}

// Get header dropdown options
function cs_header_options(){
    global $cs_theme_option;
       for($i=1; $i<=4; $i++){?>
    <option value="<?php echo 'header'.$i;?>" <?php if( $cs_theme_option['header_styles']=='header'.$i){ echo 'selected="selected"';}?>><?php echo 'Header '.$i;?></option>
	<?php }
}
// enque style and scripts
function cs_front_scripts_enqueue() {
	global $cs_theme_option;
     if (!is_admin()) {
		wp_enqueue_style('style_css', get_template_directory_uri() . '/style.css');
		wp_enqueue_style('widget_css', get_template_directory_uri() . '/css/widget.css');
		wp_enqueue_style('bootstrap_css', get_template_directory_uri() . '/css/bootstrap.css');
  		wp_enqueue_style('bootsrapgrid_css', get_template_directory_uri() . '/css/bootsrapgrid.css');
   		if ( $cs_theme_option['color_switcher'] == "on" ) {
			wp_enqueue_style('color-switcher_css', get_template_directory_uri() . '/css/color-switcher.css');
		}
  		wp_enqueue_style('font-awesome_css', get_template_directory_uri() . '/css/font-awesome.css');
   		wp_enqueue_style( 'wp-mediaelement' );
 		    wp_enqueue_script('jquery');
			wp_enqueue_script( 'wp-mediaelement' );
			wp_enqueue_script('bootstrap_js', get_template_directory_uri() . '/scripts/frontend/bootstrap.min.js', '', '', true);
			wp_enqueue_script('modernizr_js', get_template_directory_uri() . '/scripts/frontend/modernizr.js', '', '', true);
			wp_enqueue_script('jquery.nicescroll_js', get_template_directory_uri() . '/scripts/frontend/jquery.nicescroll.js', '0', '', true);
			//wp_enqueue_script('mg.min_js', get_template_directory_uri() . '/scripts/frontend/mg.min.js', '0', '', true);
			wp_enqueue_script('functions_js', get_template_directory_uri() . '/scripts/frontend/functions.js', '0', '', true);
					

    }
}
add_action('wp_enqueue_scripts', 'cs_front_scripts_enqueue'); 
// Gallery Script Enqueue
function cs_enqueue_gallery_style_script(){
	wp_enqueue_style('prettyphoto_css', get_template_directory_uri() . '/css/prettyphoto.css');
	wp_enqueue_script('prettyphoto_js', get_template_directory_uri() . '/scripts/frontend/jquery.prettyphoto.js', '', '', true);
}
// Masonry Style and Script enqueue
function cs_enqueue_masonry_style_script(){
	wp_enqueue_style('masonry_css', get_template_directory_uri() . '/css/masonry.css');
	wp_enqueue_script('jquery.masonry_js', get_template_directory_uri() . '/scripts/frontend/jquery.masonry.min.js', '', '', true);

}
// Validation Script Enqueue
function cs_enqueue_validation_script(){
	wp_enqueue_script('jquery.validate.metadata_js', get_template_directory_uri() . '/scripts/admin/jquery.validate.metadata.js', '', '', true);
	wp_enqueue_script('jquery.validate_js', get_template_directory_uri() . '/scripts/admin/jquery.validate.js', '', '', true);
}
// flexslider script enqueue
function cs_enqueue_flexslider(){
	wp_enqueue_script('jquery.flexslider-min_js', get_template_directory_uri() . '/scripts/frontend/jquery.flexslider-min.js', '1', '', true);
}
// jplayer script enqueue
function cs_enqueue_jplayer(){
	wp_enqueue_script('jquery.jplayer.min_js', get_template_directory_uri() . '/scripts/frontend/jquery.jplayer.min.js', '0', '', true);
	wp_enqueue_script('jplayer.playlist.min_js', get_template_directory_uri() . '/scripts/frontend/jplayer.playlist.min.js', '0', '', true);
}
// parallax script enqueue
function cs_enqueue_parallax(){
	wp_enqueue_script('parallax_js', get_template_directory_uri() . '/scripts/frontend/parallax.js', '', '', true);
}
function cs_enqueue_swiper_script(){
   wp_enqueue_script('jquery.jswiper_js', get_template_directory_uri() . '/scripts/frontend/jswiper.js', '', '', true);
 }
 
// Favicon and header code in head tag//
function cs_favicon() {
    global $cs_theme_option;
    ?>
     <link rel="shortcut icon" href="<?php echo $cs_theme_option['fav_icon'] ?>" />
     <!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
     
   <?php 
}
 // Favicon and header code in head tag//
function cs_footer_settings() {
    global $cs_theme_option;
     echo htmlspecialchars_decode($cs_theme_option['analytics']);
}
function cs_home_sliders(){
	global $cs_theme_option,$post;
	if($cs_theme_option['show_album'] == 'on' || $cs_theme_option['show_slider'] == 'on'){
		?>
		<script type="text/javascript">
        	jQuery(document).ready(function(){
  				cs_home_flex_callback();
			});
        </script>
		<?php
		if($cs_theme_option['show_album'] == 'on'){
			$cs_class = "home-gallery-v3";
			$cs_show_album = true;
			$cs_show_description = false;		 	
		}elseif($cs_theme_option['show_slider'] == 'on'){
			$cs_class = "home-gallery-v2";
			$cs_show_album = false;
			$cs_show_description = true;
		}else{
			$cs_class = "home-gallery-v2";
			$cs_show_album = false;
			$cs_show_description = true;
		}
 ?> 
 <!-- Home Gallery -->
        <div class="<?php echo $cs_class; ?>">
        <?php 
		if(!empty($cs_theme_option['show_slider']) && $cs_theme_option['show_slider'] == 'on'){?>
            <div id="flexslider-home">
            	<?php 
				// slider slug to id start
					$args=array(
					  'name' => $cs_theme_option['slider_name'],'post_type' => 'cs_slider',
					  'post_status' => 'publish',
					  'showposts' => 1,
					);
					$get_posts = get_posts($args);
					if($get_posts){
						$slider_id = $get_posts[0]->ID;
						$width 	= 1600;
						$height	= 900;
						cs_flex_slider($width, $height,$slider_id,$cs_show_description);
					}
				?>
            </div>
            <?php  }
			if($cs_show_album == "true"){
				$album_category = $cs_theme_option['cs_album_category'];
				$cs_posts_per_page = $cs_theme_option['cs_posts_per_page'];
				if(empty($cs_posts_per_page)){ $cs_posts_per_page = "-1";}
				$args = array(
							'posts_per_page'			=> $cs_posts_per_page,
							'post_type'					=> 'albums',
							'album-category'			=> "$album_category",
							'post_status'				=> 'publish',
							'order'						=> 'ASC',
					);
					$custom_query = new WP_Query($args);
					if ( $custom_query->have_posts() <> "" ):
					$post_count = $cs_tracks_count = 0;
					$post_count = $custom_query->post_count;
			?>
            	<div class="wrapper-release">
                    <div class="desc-wrapper-release">
                        <h2 class="section-title cs-heading-color"><?php echo $cs_theme_option['album_title'];?></h2>
                        <p><?php echo $cs_theme_option['album_description'];?></p>
                        <div class="carousel-release-control"></div>
                    </div>
                    <div class="carousel-area-release">
                        <div class="album-gallery">
                            <div class="flexslider">
                                <ul class="slides">
                                	<?php 
										while ( $custom_query->have_posts()) : $custom_query->the_post();
											 $cs_album = get_post_meta($post->ID, "cs_album", true);
											 if ( $cs_album <> "" ) {
												  $cs_xmlObject = new SimpleXMLElement($cs_album);
												  $cs_tracks_count = count($cs_xmlObject->track);
											 }
											 $width = 270;
											$height	= 270;
											$image_url = cs_get_post_img_src($post->ID, $width, $height);
											$cs_album_artists = get_post_meta($post->ID, "cs_album_artists", true); 
										?>
                              <li>
                                <!-- Album Post -->                                    
                                <article>
                                	
                                    <figure>
                                        <!-- Album Image -->   
                                        <?php 
											if($image_url <> ''){echo "<img src=".$image_url." alt=''  style='display:block !important;' >";} else {echo '<img src="' . get_template_directory_uri() . '/images/Dummy.jpg" alt="" style="display:block !important;" />';}
										?>                                 
                                        <figcaption>
                                            <a href="<?php the_permalink();?>" class="btnplay"> <em class="fa fa-play"></em>
                                            </a>
                                            <p>
                                                <a href="<?php the_permalink();?>" class="track-con"> <em class="fa fa-music"></em>
                                                    <?php echo $cs_tracks_count;?> <?php if($cs_theme_option['trans_switcher']== "on"){ _e('Tracks','Bolster');}else{ echo $cs_theme_option['trans_track']; }?>
                                                </a>
                                            </p>
                                        </figcaption>
                                        <!-- Album Image Close --> 
                                        </figure>
                                     
                                    <!-- Album Post Description -->                                    
                                    <div class="desc">
                                        <h2 class="post-title">
                                            <a href="<?php the_permalink();?>" class="colrhover"><?php the_title();?></a>
                                        </h2>
                                        <?php if($cs_album_artists <> "0" ){
												$cs_album_artists = get_post_meta($post->ID, "cs_album_artists", true);
												if($cs_album_artists <> ''){
												$args=array('name' => $cs_album_artists,'post_type' => 'artists', 'post_status' => 'publish', 'showposts' => 1,);
														$get_posts = get_posts($args);
														if($get_posts){
															echo '<h5>'. $get_posts[0]->post_title . '</h5>';
														}
												}
											}?>
                                        <div class="buy-now">
                                            <h5><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Buy Now','Bolster');}else{ echo $cs_theme_option['trans_buy_now']; }?></h5>
                                            <?php if($cs_xmlObject->album_buy_amazon <> ''){?>
                                            	<a href="<?php echo $cs_xmlObject->album_buy_amazon;?>"><img src="<?php echo get_template_directory_uri();?>/images/img-bn1.png" alt=""></a>
											<?php }?>
                                            <?php if($cs_xmlObject->album_buy_apple <> ''){?>
                                            	<a href="<?php echo $cs_xmlObject->album_buy_apple;?>"><img src="<?php echo get_template_directory_uri();?>/images/img-bn2.png" alt=""></a>
											<?php }?>
                                            <?php if($cs_xmlObject->album_buy_groov <> ''){?>
                                            	<a href="<?php echo $cs_xmlObject->album_buy_groov;?>"><img src="<?php echo get_template_directory_uri();?>/images/img-bn3.png" alt=""></a>
											<?php }?>
                                            <?php if($cs_xmlObject->album_buy_cloud <> ''){?>
                                            	<a href="<?php echo $cs_xmlObject->album_buy_cloud;?>"><img src="<?php echo get_template_directory_uri();?>/images/img-bn4.png" alt=""></a>
											<?php }?>
                                             <?php if($cs_xmlObject->album_buy_url <> ''){?>
                                            	<a href="<?php echo $cs_xmlObject->album_buy_url;?>"><img src="<?php echo get_template_directory_uri();?>/images/img-bn5.png" alt=""></a>
											<?php }?>
                                        </div>
                                    </div>
                                  </article>
                                <!-- Album Post Close --> 
                                </li>
                                <?php endwhile; endif; wp_reset_query(); ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            	<!-- Carousel Area Close -->
                <?php }?>
        </div>
 	 <?php }  
	
}
 // Front End Functions END