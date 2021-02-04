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
// to make a copy of media image for gallery start
function cs_gallery_clone(){
	global $cs_node, $counter;
	if( isset($_POST['action']) ) {
		$cs_node = new stdClass();
		$cs_node->title = "";
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
      <a href="javascript:galedit(<?php echo $counter?>)" class="edit"></a> <a href="javascript:del_this(<?php echo $counter?>)" class="delete"></a> </div>
  </div>
  <div class="poped-up" id="edit_<?php echo $counter?>">
    <div class="opt-head">
      <h5>Edit Options</h5>
      <a href="javascript:galclose(<?php echo $counter?>)" class="closeit">&nbsp;</a> </div>
    <div class="opt-conts">
      <ul class="form-elements">
        <li class="to-label">
          <label>Image Title</label>
        </li>
        <li class="to-field">
          <input type="text" name="title[]" value="<?php echo htmlspecialchars($cs_node->title)?>" class="txtfield" />
        </li>
      </ul>
      <ul class="form-elements">
        <li class="to-label">
          <label>Use Image As</label>
        </li>
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
        <li class="to-label">
          <label>Video URL</label>
        </li>
        <li class="to-field">
          <input type="text" name="video_code[]" value="<?php echo htmlspecialchars($cs_node->video_code)?>" class="txtfield" />
          <p>(Enter Specific Video URL Youtube or Vimeo)</p>
        </li>
      </ul>
      <ul class="form-elements" id="link_url<?php echo $counter?>" <?php if($cs_node->use_image_as=="0" or $cs_node->use_image_as=="" or $cs_node->use_image_as=="1")echo 'style="display:none"';?> >
        <li class="to-label">
          <label>Link URL</label>
        </li>
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
// page bulider items start
// portfolio other info html form start
function cs_add_port_portfolio(){
	global $counter_port_portfolio, $port_other_info_title, $port_other_info_desc;
	foreach ($_POST as $keys=>$values) {
		$$keys = stripslashes($values);
	}
?>
    <tr class="parentdelete" id="edit_track<?php echo $counter_port_portfolio?>">
        <td id="port-title<?php echo $counter_port_portfolio?>" style="width:80%;"><?php echo $port_other_info_title?></td>
        <td class="centr" style="width:20%;">
            <a href="javascript:openpopedup('edit_track_form<?php echo $counter_port_portfolio?>')" class="actions edit">&nbsp;</a>
            <a href="#" class="delete-it btndeleteit actions delete">&nbsp;</a>
            <div class="poped-up" id="edit_track_form<?php echo $counter_port_portfolio?>">
                <div class="opt-head">
                    <h5>Add Portfolio Other Info</h5>
                    <a href="javascript:closepopedup('edit_track_form<?php echo $counter_port_portfolio?>')" class="closeit">&nbsp;</a>
                    <div class="clear"></div>
                </div>
                <ul class="form-elements">
                    <li class="to-label"><label>Title Text</label></li>
                    <li class="to-field">
                        <input type="text" name="port_other_info_title[]" value="<?php echo htmlspecialchars($port_other_info_title)?>" id="port_other_info_title<?php echo $counter_port_portfolio?>" />
                        <p>Put Title Text</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Description</label></li>
                    <li class="to-field">
                        <textarea name="port_other_info_desc[]" id="port_other_info_desc<?php echo $counter_port_portfolio?>"><?php echo htmlspecialchars($port_other_info_desc)?></textarea>
                        <p>Put Description Text</p>
                    </li>
                </ul>
                
                <ul class="form-elements noborder">
                    <li class="to-label"><label></label></li>
                    <li class="to-field"><input type="button" value="Update" onclick="update_port_other(<?php echo $counter_port_portfolio?>); closepopedup('edit_track_form<?php echo $counter_port_portfolio?>')" /></li>
                </ul>
            </div>
        </td>
    </tr>
<?php
	if ( isset($action) ) die();
}
add_action('wp_ajax_cs_add_port_portfolio', 'cs_add_port_portfolio');
// portfolio other info html form end
// portfolio html form for page builder start
function cs_pb_portfolio($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$portfolio_element_size = '100';
		$portfolio_cat_db = '';
		$portfolio_title = '';
		$portfolio_filterable_db = '';
		$portfolio_post_title = '';
		$cs_portfolio_excerpt_db = '255';
		$portfolio_pagination_db = '';
		$portfolio_per_page_db = get_option("posts_per_page");
		$portfolio_view_db = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$portfolio_element_size = $cs_node->portfolio_element_size;
			$portfolio_title = $cs_node->portfolio_title;
			$portfolio_cat_db = $cs_node->portfolio_cat;
			$portfolio_filterable_db = $cs_node->portfolio_filterable;
			$portfolio_post_title = $cs_node->portfolio_post_title;
			$portfolio_pagination_db = $cs_node->portfolio_pagination;
			$portfolio_per_page_db = $cs_node->portfolio_per_page;
			$cs_portfolio_excerpt_db = $cs_node->cs_portfolio_excerpt;
			$portfolio_view_db = $cs_node->portfolio_view;
				$counter = $post->ID.$count_node;
	}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $portfolio_element_size?>" item="blog"  data="<?php echo cs_element_size_data_array_index($portfolio_element_size)?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="portfolio_element_size[]" class="item" value="<?php echo $portfolio_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a>
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;
            
		</div>
        <div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit portfolio Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Title</label></li>
                    <li class="to-field">
                        <input type="text" name="portfolio_title[]" class="txtfield" value="<?php echo htmlspecialchars($portfolio_title)?>" />
                        <p>Put Page Title</p>
                    </li>                                            
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Choose Category</label></li>
                    <li class="to-field">
                        <select name="portfolio_cat[]" class="dropdown">
                        	<option value="0">-- Select Category --</option>
                        	<?php cs_show_all_cats('', '', $portfolio_cat_db, "portfolio-category");?>
                        </select>
                        <p>Choose category to show list. If you choose no category it will show all posts.</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Select View</label></li>
                    <li class="to-field">
                        <select name="portfolio_view[]" class="dropdown">
                        	<option <?php if($portfolio_view_db=="portfolio-small")echo "selected";?> value="portfolio-small">Grid Small</option>
                            <option <?php if($portfolio_view_db=="portfolio-medium")echo "selected";?> value="portfolio-medium">Grid Medium</option>
                            <option <?php if($portfolio_view_db=="portfolio-large")echo "selected";?> value="portfolio-large">Grid Large</option>
                            <option <?php if($portfolio_view_db=="portfolio-title_v1")echo "selected";?> value="portfolio-title_v1">Grid with title v1 </option>
                            <option <?php if($portfolio_view_db=="portfolio-title_v2")echo "selected";?> value="portfolio-title_v2">Grid  with title v2</option>
                            <option <?php if($portfolio_view_db=="portfolio-mas")echo "selected";?> value="portfolio-mas" >Masonry Small</option>

                           </select>
                        <p>Please select view.</p>
                    </li>                                        
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Show Post Description</label></li>
                    <li class="to-field">
                        <select name="portfolio_post_title[]" class="dropdown">
                            <option <?php if($portfolio_post_title=="On")echo "selected";?> >On</option>
                            <option <?php if($portfolio_post_title=="Off")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Length of Excerpt</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_portfolio_excerpt[]" class="txtfield" value="<?php if($cs_portfolio_excerpt_db <> ''){ echo $cs_portfolio_excerpt_db; } else { echo '255';}?>" />
                        <p>Enter number of character for short description text.</p>
                    </li>                         
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Filterable</label></li>
                    <li class="to-field">
                        <select name="portfolio_filterable[]" class="dropdown" onchange="cs_toggle_tog('port_pagination<?php echo $name.$counter?>')">
                            <option <?php if($portfolio_filterable_db=="Off")echo "selected";?> >Off</option>
                            <option <?php if($portfolio_filterable_db=="On")echo "selected";?> >On</option>
                        </select>
                    </li>
                </ul>
                	<div id="port_pagination<?php echo $name.$counter?>" <?php if($portfolio_filterable_db=="On")echo 'style=" display:none"'?> >
                        <ul class="form-elements">
                            <li class="to-label"><label>Pagination</label></li>
                            <li class="to-field">
                                <select name="portfolio_pagination[]" class="dropdown">
                                    <option <?php if($portfolio_pagination_db=="Show Pagination")echo "selected";?> >Show Pagination</option>
                                    <option <?php if($portfolio_pagination_db=="Single Page")echo "selected";?> >Single Page</option>
                                </select>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>No. of record Per Page</label></li>
                            <li class="to-field">
                                <input type="text" name="portfolio_per_page[]" class="txtfield" value="<?php echo $portfolio_per_page_db; ?>" />
                                <p>To display all the records, leave this field blank.</p>
                            </li>
                        </ul>
					</div>
                <ul class="form-elements noborder">
                    <li class="to-label"><label></label></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="portfolio" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_portfolio', 'cs_pb_portfolio');
// portfolio html form for page builder end
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
			$cs_gal_desc_db = '';
			$cs_gal_pagination_db = '';
			$cs_gal_images_title_db = '';
			$cs_gal_media_per_page_db = get_option("posts_per_page");
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$gallery_element_size = $cs_node->gallery_element_size;
			$cs_gal_header_title_db = $cs_node->header_title;
			$cs_gal_layout_db = $cs_node->layout;
			$cs_gal_album_db = $cs_node->album;
			$cs_gal_images_title_db = $cs_node->cs_gal_images_title;
			$cs_gal_pagination_db = $cs_node->pagination;
			$cs_gal_media_per_page_db = $cs_node->media_per_page;
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
                    <li class="to-label"><label>Choose Gallery Layout</label></li>
                    <li class="to-field">
                        <select name="cs_gal_layout[]" class="dropdown">
                            <option value="cs-thumb-gallery" <?php if($cs_gal_layout_db=="cs-thumb-gallery")echo "selected";?> >Gallery Thumb</option>
                            <option value="cs-small-gallery" <?php if($cs_gal_layout_db=="cs-small-gallery")echo "selected";?> >Gallery Small</option>
                            <option value="cs-gutter-gallery" <?php if($cs_gal_layout_db=="cs-gutter-gallery")echo "selected";?> >Gallery Small with Gutter</option>
                            <option value="cs-mass-gallery" <?php if($cs_gal_layout_db=="cs-mass-gallery")echo "selected";?> >Gallery Masonry</option>
                            <option value="cs-banner-gallery" <?php if($cs_gal_layout_db=="cs-banner-gallery")echo "selected";?> >Gallery Full Screen</option>
                            <option value="cs-banner-thumb-gallery" <?php if($cs_gal_layout_db=="cs-banner-thumb-gallery")echo "selected";?> >Gallery Full Screen with Thumbs</option>
                        </select>
                        
                        <p>Select gallery layout.</p>
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
                <ul class="form-elements">
                    <li class="to-label"><label>Show Images Title</label></li>
                    <li class="to-field">
                        <select name="cs_gal_images_title[]" class="dropdown">
                            <option value="Yes" <?php if($cs_gal_images_title_db=="Yes")echo "selected";?> >Yes</option>
                            <option value="No" <?php if($cs_gal_images_title_db=="No")echo "selected";?> >No</option>
                        </select>
                        
                        <p>Select gallery images title on/off.</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Pagination</label></li>
                    <li class="to-field">
                        <select name="cs_gal_pagination[]" class="dropdown" >
                            <option <?php if($cs_gal_pagination_db=="Show Pagination")echo "selected";?> >Show Pagination</option>
                            <option <?php if($cs_gal_pagination_db=="Single Page")echo "selected";?> >Single Page</option>
                        </select>
                    </li>
                </ul>
				<ul class="form-elements" >
                    <li class="to-label"><label>No. of Media Per Page</label></li>
                    <li class="to-field">
                    	<input type="text" name="cs_gal_media_per_page[]" class="txtfield" value="<?php echo $cs_gal_media_per_page_db; ?>" />
                        <p>To display all the records, leave this field blank.</p>
                    </li>
                </ul>
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
function cs_pb_home($die = 0){
	
	global $cs_node, $count_node, $post, $cs_theme_option;
	//print_r($cs_node);
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$home_element_size = '100';
		$cs_home_view_option = '';
		$cs_home_blog_cat = '';
		$cs_home_blog_excerpt = $cs_home_blog_show_title = $cs_home_blog_description = '';
		$cs_home_v2_text = $cs_home_v2_video = $cs_home_v2_captions = $cs_home_v2_video_mute = '';
		$cs_home_v3_cat = $cs_home_v3_filterable = $cs_home_v3_num_post = '';
		$cs_home_v4_text = $cs_home_v4_slider = $cs_home_v4_captions = '';
		$cs_home_v5_text = $cs_home_v5_gallery = $cs_home_v5_captions = '';
		$cs_home_v4_text_rotator = $cs_home_v2_text_rotator = $cs_home_v5_text_rotator = $cs_home_v2_text_rotator_style = $cs_home_v4_text_rotator_style = $cs_home_v5_text_rotator_style = '';
		$cs_home_num_post = get_option("posts_per_page");
		$cs_home_blog_excerpt = '200';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$home_element_size = $cs_node->home_element_size;
			$cs_home_view_option = $cs_node->cs_home_view_option;
			
			$cs_home_blog_description = $cs_node->cs_home_blog_description;
			$cs_home_blog_show_title = $cs_node->cs_home_blog_show_title;
			$cs_home_blog_excerpt = $cs_node->cs_home_blog_excerpt;
			
			$cs_home_blog_cat = $cs_node->cs_home_blog_cat;
			$cs_home_num_post = $cs_node->cs_home_num_post;

			$cs_home_v2_text = $cs_node->cs_home_v2_text;
			$cs_home_v2_video = $cs_node->cs_home_v2_video;
			$cs_home_v2_captions = $cs_node->cs_home_v2_captions;
			$cs_home_v2_video_mute = $cs_node->cs_home_v2_video_mute;
			$cs_home_v2_text_rotator = $cs_node->cs_home_v2_text_rotator;
			$cs_home_v2_text_rotator_style = $cs_node->cs_home_v2_text_rotator_style;
			
			$cs_home_v3_num_post = $cs_node->cs_home_v3_num_post;
			$cs_home_v3_filterable = $cs_node->cs_home_v3_filterable;
			$cs_home_v3_cat = $cs_node->cs_home_v3_cat;
			
			$cs_home_v4_text = $cs_node->cs_home_v4_text;
			$cs_home_v4_slider = $cs_node->cs_home_v4_slider;
			$cs_home_v4_captions = $cs_node->cs_home_v4_captions;
			$cs_home_v4_text_rotator = $cs_node->cs_home_v4_text_rotator;
			$cs_home_v4_text_rotator_style = $cs_node->cs_home_v4_text_rotator_style;
			
			$cs_home_v5_text = $cs_node->cs_home_v5_text;
			$cs_home_v5_gallery = $cs_node->cs_home_v5_gallery;
			$cs_home_v5_captions = $cs_node->cs_home_v5_captions;
			$cs_home_v5_text_rotator = $cs_node->cs_home_v5_text_rotator;
			$cs_home_v5_text_rotator_style = $cs_node->cs_home_v5_text_rotator_style;

			$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $home_element_size?>" item="home" data="<?php echo cs_element_size_data_array_index($home_element_size)?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="home_element_size[]" class="item" value="<?php echo $home_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a>
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;
   		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Home Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            <ul class="form-elements">
                    <li class="to-label"><label>Home Page View</label></li>
                    <li class="to-field">
                        <select name="cs_home_view_option[]" class="dropdown"  onchange="javascript:cs_toggle_home_page_element(this.value,<?php echo $counter ?>)">
                        	<option value="home_blog_view" <?php if($cs_home_view_option=='home_blog_view')echo "selected";?> >Home V1 Blog </option>
                            <option value="home_portfolio_view" <?php if($cs_home_view_option=='home_portfolio_view')echo "selected";?> >Home V2 Portfolio</option>
                            <option value="home_video" <?php if($cs_home_view_option=='home_video')echo "selected";?> >Home V3 Video</option>
                            <option <?php if($cs_home_view_option=='big-image-zoom-home') echo "selected";?> value="big-image-zoom-home">Home V4 Big Image Zoom</option>
                            <option <?php if($cs_home_view_option=='fade-slider-home') echo "selected";?> value="fade-slider-home">Home V5 Fade Slider</option>
                            <option <?php if($cs_home_view_option=='half-layout-home')echo "selected";?> value="half-layout-home">Home V6 Half Layout</option>
                            <option <?php if($cs_home_view_option=='custom-home')echo "selected";?> value="custom-home">Home V7 Left Slide</option>
                            <option value="home_view_gallery" <?php if($cs_home_view_option=='home_view_gallery')echo "selected";?> >Home V8 Gallery</option>
                        	
                        </select>
                         <p>Please select home page options</p>
                        
                    </li>
                </ul>
            
            <ul class="form-elements meta-body" style=" <?php if($cs_home_view_option == "home_video"){echo "display:block";}else echo "display:none";?>" id="home_v2" >
            	<li>
                
                	<ul class="form-elements">
                        <li class="to-label"><label>Custom text</label></li>
                        <li class="to-field">
                        	<textarea rows="8" name="cs_home_v2_text[]"  cols="25" ><?php echo htmlspecialchars($cs_home_v2_text)?></textarea>
                            <p>Please enter Custom text.</p>
                        </li>                    
                	</ul>
                    <ul class="form-elements">
                        <li class="to-label"><label>Text Rotator</label></li>
                        <li class="to-field">
                        	<textarea rows="8" name="cs_home_v2_text_rotator[]"  cols="25" ><?php echo htmlspecialchars($cs_home_v2_text_rotator)?></textarea>
                            <p>Add a super simple rotating text to your website</p>
                            <p>Please enter Moving Text seperated with commas.</p>
                        </li>                    
                	</ul>
                    <ul class="form-elements">
                        <li class="to-label"><label>Text Rotator Style</label></li>
                        <li class="to-field">
                        	<select name="cs_home_v2_text_rotator_style[]" class="dropdown">
                        		<option value="fade" <?php if($cs_home_v2_text_rotator_style == "fade"){ echo 'selected';}?>> Fade</option>
                                <option value="flip" <?php if($cs_home_v2_text_rotator_style == "flip"){ echo 'selected';}?>> Flip</option>
                                <option value="flipCube" <?php if($cs_home_v2_text_rotator_style == "flipCube"){ echo 'selected';}?>> FlipCube</option>
                                <option value="flipUp" <?php if($cs_home_v2_text_rotator_style == "flipUp"){ echo 'selected';}?>> FlipUp</option>
                                <option value="spin" <?php if($cs_home_v2_text_rotator_style == "spin"){ echo 'selected';}?>> Spin</option>
                             </select>
                        </li>                    
                	</ul>
                	<ul class="form-elements">
                        <li class="to-label"><label>Video URL</label></li>
                        <li class="to-field">
                            <input type="text" name="cs_home_v2_video[]" class="txtfield" value="<?php echo htmlspecialchars($cs_home_v2_video)?>" />
                            <p>Please enter Video URL.</p>
                        </li>                    
                	</ul>
                    <ul class="form-elements">
                            <li class="to-label"><label>Choose Mute</label></li>
                            <li class="to-field">
                                <select name="cs_home_v2_video_mute[]" class="dropdown">
                                     <option value="Yes" <?php if($cs_home_v2_video_mute == "Yes"){ echo 'selected';}?>> Yes</option>
                                     <option value="No" <?php if($cs_home_v2_video_mute == "No"){ echo 'selected';}?>> No</option>
                                </select>
                                <p>Please select filterable On/off.</p>
                            </li>                                        
                        </ul>
                    <ul class="form-elements">
                            <li class="to-label"><label>Caption Settings</label></li>
                            <li class="to-field">
                                <select name="cs_home_v2_captions[]" class="dropdown">
                                	<option value="" >-- Select Caption Option --</option>
                                	<?php for($i=1; $i<=7; $i++){?>
                                    	<option value="<?php echo $i;?>" <?php if($cs_home_v2_captions==$i)echo "selected";?> >Caption Option <?php echo $i;?></option>
                                   	<?php }?>
                                </select>
                            </li>
                        </ul>

                </li>	
            </ul>
            <!-- end home v2--->	
            <ul class="form-elements meta-body" style=" <?php if($cs_home_view_option == "home_portfolio_view"){echo "display:block";}else echo "display:none";?>" id="home_v3" >
            	<li>
                        <ul class="form-elements">
                            <li class="to-label"><label>Choose Portfolio Category</label></li>
                            <li class="to-field">
                                <select name="cs_home_v3_cat[]" class="dropdown">
                                     <option value="all" <?php if($cs_home_v3_cat == "all"){ echo 'selected';}?>> All</option>
                                    <?php cs_show_all_cats('', '', $cs_home_v3_cat, "portfolio-category");?>
                                </select>
                                <p>Please select category to show posts.</p>
                            </li>                                        
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Choose Filterable</label></li>
                            <li class="to-field">
                                <select name="cs_home_v3_filterable[]" class="dropdown">
                                     <option value="Yes" <?php if($cs_home_v3_filterable == "Yes"){ echo 'selected';}?>> Yes</option>
                                     <option value="No" <?php if($cs_home_v3_filterable == "No"){ echo 'selected';}?>> No</option>
                                </select>
                                <p>Please select filterable On/off.</p>
                            </li>                                        
                        </ul>
                         <ul class="form-elements">
                            <li class="to-label"><label>No. of Post Per Page</label></li>
                            <li class="to-field">
                                <input type="text" name="cs_home_v3_num_post[]" class="txtfield" value="<?php echo $cs_home_v3_num_post; ?>" />
                                <p>To display all the records, leave this field blank.</p>
                            </li>
                        </ul>
            	</li>
            </ul>
            <!-- end home v3 Portfolio--->	
            <ul class="form-elements meta-body" style=" <?php if($cs_home_view_option == "big-image-zoom-home" || $cs_home_view_option == "fade-slider-home" || $cs_home_view_option == "half-layout-home" || $cs_home_view_option == "custom-home"){echo "display:block";}else echo "display:none";?>" id="home_v4" >
            	<li>
                		<ul class="form-elements">
                            <li class="to-label"><label>Custom text</label></li>
                            <li class="to-field">
                                <textarea rows="8" name="cs_home_v4_text[]"  cols="25" ><?php echo htmlspecialchars($cs_home_v4_text)?></textarea>
                                <p>Please enter Custom text.</p>
                            </li>                    
                        </ul>
                        <ul class="form-elements">
                        <li class="to-label"><label>Text Rotator</label></li>
                        <li class="to-field">
                        	<textarea rows="8" name="cs_home_v4_text_rotator[]"  cols="25" ><?php echo htmlspecialchars($cs_home_v4_text_rotator)?></textarea>
                            <p>Add a super simple rotating text to your website</p>
                            <p>Please enter Moving Text seperated with commas.</p>
                        </li>                    
                	</ul>
                    <ul class="form-elements">
                        <li class="to-label"><label>Choose Text Rotator Style</label></li>
                        <li class="to-field">
                        	<select name="cs_home_v4_text_rotator_style[]" class="dropdown">
                        		<option value="fade" <?php if($cs_home_v4_text_rotator_style == "fade"){ echo 'selected';}?>> Fade</option>
                                <option value="flip" <?php if($cs_home_v4_text_rotator_style == "flip"){ echo 'selected';}?>> Flip</option>
                                <option value="flipCube" <?php if($cs_home_v4_text_rotator_style == "flipCube"){ echo 'selected';}?>> FlipCube</option>
                                <option value="flipUp" <?php if($cs_home_v4_text_rotator_style == "flipUp"){ echo 'selected';}?>> FlipUp</option>
                                <option value="spin" <?php if($cs_home_v4_text_rotator_style == "spin"){ echo 'selected';}?>> Spin</option>
                             </select>
                        </li>                    
                	</ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Caption Settings</label></li>
                            <li class="to-field">
                                <select name="cs_home_v4_captions[]" class="dropdown">
                                	<option value="" >-- Select Caption Option --</option>
                                	<?php for($i=1; $i<=7; $i++){?>
                                    	<option value="<?php echo $i;?>" <?php if($cs_home_v4_captions==$i)echo "selected";?> >Caption Option <?php echo $i;?></option>
                                   	<?php }?>
                                </select>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Choose Slider</label></li>
                            <li class="to-field">
                                <select name="cs_home_v4_slider[]" class="dropdown">
                                     <?php
                                        $query = array( 'posts_per_page' => '-1', 'post_type' => 'cs_slider', 'orderby'=>'ID', 'post_status' => 'publish' );
                                        $wp_query = new WP_Query($query);
                                        while ($wp_query->have_posts()) : $wp_query->the_post();
                                    ?>
                                        <option <?php if($post->post_name==$cs_home_v4_slider)echo "selected";?> value="<?php echo $post->post_name; ?>"><?php the_title()?></option>
                                    <?php
                                        endwhile;
                                    ?>
                                </select>
                            </li>
                        </ul>
                        
            	</li>
            </ul>
            <!-- end home v4 Big Image Zoom--->	
            <ul class="form-elements meta-body" style=" <?php if($cs_home_view_option == "home_view_gallery"){echo "display:block";}else echo "display:none";?>" id="home_v5" >
            	<li>
                		<ul class="form-elements">
                            <li class="to-label"><label>Custom text</label></li>
                            <li class="to-field">
                                <textarea rows="8" name="cs_home_v5_text[]"  cols="25" ><?php echo htmlspecialchars($cs_home_v5_text)?></textarea>
                                <p>Please enter Custom text.</p>
                            </li>                    
                        </ul>
                        <ul class="form-elements">
                        <li class="to-label"><label>Text Rotator</label></li>
                        <li class="to-field">
                        	<textarea rows="8" name="cs_home_v5_text_rotator[]"  cols="25" ><?php echo htmlspecialchars($cs_home_v5_text_rotator)?></textarea>
                            <p>Add a super simple rotating text to your website</p>
                            <p>Please enter Moving Text seperated with commas.</p>
                        </li>                    
                	</ul>
                    <ul class="form-elements">
                        <li class="to-label"><label>Choose Text Rotator Style</label></li>
                        <li class="to-field">
                        	<select name="cs_home_v5_text_rotator_style[]" class="dropdown">
                        		<option value="fade" <?php if($cs_home_v5_text_rotator_style == "fade"){ echo 'selected';}?>> Fade</option>
                                <option value="flip" <?php if($cs_home_v5_text_rotator_style == "flip"){ echo 'selected';}?>> Flip</option>
                                <option value="flipCube" <?php if($cs_home_v5_text_rotator_style == "flipCube"){ echo 'selected';}?>> FlipCube</option>
                                <option value="flipUp" <?php if($cs_home_v5_text_rotator_style == "flipUp"){ echo 'selected';}?>> FlipUp</option>
                                <option value="spin" <?php if($cs_home_v5_text_rotator_style == "spin"){ echo 'selected';}?>> Spin</option>
                             </select>
                        </li>                    
                	</ul>
                        <ul class="form-elements">
                    <li class="to-label"><label>Choose Gallery/Album</label></li>
                    <li class="to-field">
                        <select name="cs_home_v5_gallery[]" class="dropdown">
                        	<option value="">-- Select Gallery/Album --</option>
                            <?php
                                $query = array( 'posts_per_page' => '-1', 'post_type' => 'cs_gallery', 'orderby'=>'ID', 'post_status' => 'publish' );
                                $wp_query = new WP_Query($query);
                                while ($wp_query->have_posts()) : $wp_query->the_post();
                            ?>
                                <option <?php if($post->post_name==$cs_home_v5_gallery)echo "selected";?> value="<?php echo $post->post_name; ?>"><?php echo get_the_title()?></option>
                            <?php
                                endwhile;
                            ?>
                        </select>
                        <p>Select Gallery/Album to show images.</p>
                    </li>
                </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Caption Settings</label></li>
                            <li class="to-field">
                                <select name="cs_home_v5_captions[]" class="dropdown">
                               	 <option value="" >-- Select Caption Option --</option>
                                	<?php for($i=1; $i<=7; $i++){?>
                                    	<option value="<?php echo $i;?>" <?php if($cs_home_v5_captions==$i)echo "selected";?> >Caption Option <?php echo $i;?></option>
                                   	<?php }?>
                                </select>
                            </li>
                        </ul>
                        
            	</li>
            </ul>
            <!-- end Home Page V7 -Small thumb Gallery--->	
            <ul class="form-elements meta-body" style=" <?php if($cs_home_view_option <> "home_portfolio_view" || $cs_home_view_option == ""){echo "display:block";}else echo "display:none";?>" id="home_v1" >
            	<li>
                        <ul class="form-elements">
                            <li class="to-label"><label>Choose Blog Category</label></li>
                            <li class="to-field">
                                <select name="cs_home_blog_cat[]" class="dropdown">
                                     <option value="" <?php if($cs_home_blog_cat == ""){ echo 'selected';}?>> -- Select Blog Category --</option>
                                    <?php cs_show_all_cats('', '', $cs_home_blog_cat, "category");?>
                                </select>
                                <p>Please select category to show posts.</p>
                            </li>                                        
                        </ul>
                         <ul class="form-elements">
                            <li class="to-label"><label>No. of Post Per Page</label></li>
                            <li class="to-field">
                                <input type="text" name="cs_home_num_post[]" class="txtfield" value="<?php echo $cs_home_num_post; ?>" />
                                <p>To display all the records, leave this field blank.</p>
                            </li>
                        </ul>
                        <ul class="form-elements meta-body" style=" <?php if($cs_home_view_option == "home_blog_view" || $cs_home_view_option == ""){echo "display:block";}else echo "display:none";?>" id="home_blog_detail_options" >
                        
                        <ul class="form-elements">
                            <li class="to-label"><label>Post Description</label></li>
                            <li class="to-field">
                                <select name="cs_home_blog_description[]" class="dropdown" >
                                    <option <?php if($cs_home_blog_description=="yes")echo "selected";?> value="yes">Yes</option>
                                    <option <?php if($cs_home_blog_description=="no")echo "selected";?> value="no">No</option>
                                </select>
                            </li>
                        </ul>
                        <ul class="form-elements meta-body">
                            <li class="to-label">
                                <label>Post Title</label>
                            </li>
                            <li class="to-field">
                                <select name="cs_home_blog_show_title[]" class="select_dropdown" id="page-option-choose-right-sidebar">
                                    <option <?php if($cs_home_blog_show_title=="yes")echo "selected";?> value="yes">Yes</option>
                                    <option <?php if($cs_home_blog_show_title=="no")echo "selected";?> value="no">No</option>
                                </select>
                            </li>
                        </ul>
                        
                        <ul class="form-elements">
                            <li class="to-label"><label>Length of Excerpt</label></li>
                            <li class="to-field">
                                <input type="text" name="cs_home_blog_excerpt[]" class="txtfield" value="<?php echo $cs_home_blog_excerpt;?>" />
                                <p>Enter number of character for short description text.</p>
                            </li>                         
                        </ul>
                        
                        </ul>
                
            	</li>
            
            </ul>
            <!-- end home v1--->	
            <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="snapture_home" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_home', 'cs_pb_home');
// blog html form for page builder end
// blog html form for page builder start
function cs_pb_blog($die = 0){
	
	global $cs_node, $count_node, $post, $cs_theme_option;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$blog_element_size = '100';
		$cs_blog_title_db = '';
		$cs_blog_cat_db = '';
		$cs_blog_left_space = '';
		$cs_blog_excerpt_db = '255';
		//$cs_blog_num_post_db = '20';
 		$cs_blog_description_db = '';
		$cs_blog_view = '';
		$cs_blog_pagination_db = '';
		$cs_featured_post = '';
		$cs_blog_show_title = '';
		$cs_blog_num_post_db = get_option("posts_per_page");
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
			$cs_blog_pagination_db = $cs_node->cs_blog_pagination;
			$cs_featured_post = $cs_node ->cs_featured_post;
			$cs_blog_show_title = $cs_node ->cs_blog_show_title;
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
                            <option value="large_view" <?php if($cs_blog_view=="large_view")echo "selected";?> >Large View</option>
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
                
                <ul class="form-elements">
                    <li class="to-label"><label>Post Description</label></li>
                    <li class="to-field">
                        <select name="cs_blog_description[]" class="dropdown" >
                            <option <?php if($cs_blog_description_db=="yes")echo "selected";?> value="yes">Yes</option>
                            <option <?php if($cs_blog_description_db=="no")echo "selected";?> value="no">No</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements meta-body" style=" <?php if($cs_blog_view <> "gird_view"){echo "display:none";}else echo "display:block";?>" id="cs_featured_post_<?php echo $counter; ?>" >
                    <li class="to-label">
                        <label>Post Title</label>
                    </li>
                    <li class="to-field">
                        <select name="cs_blog_show_title[]" class="select_dropdown" id="page-option-choose-right-sidebar">
                            <option <?php if($cs_blog_show_title=="yes")echo "selected";?> value="yes">Yes</option>
                            <option <?php if($cs_blog_show_title=="no")echo "selected";?> value="no">No</option>
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
                
                 <ul class="form-elements">
                    <li class="to-label"><label>No. of Post Per Page</label></li>
                    <li class="to-field">
                    	<input type="text" name="cs_blog_num_post[]" class="txtfield" value="<?php echo $cs_blog_num_post_db; ?>" />
                        <p>To display all the records, leave this field blank.</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Pagination</label></li>
                    <li class="to-field">
                        <select name="cs_blog_pagination[]" class="dropdown" >
                            <option <?php if($cs_blog_pagination_db=="Show Pagination")echo "selected";?> >Show Pagination</option>
                            <option <?php if($cs_blog_pagination_db=="Single Page")echo "selected";?> >Single Page</option>
                        </select>
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
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="map_view[]" value="content" />
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

// side bar layout in pages, post and default page(theme options) start
function cs_meta_layout(){
	global $cs_xmlObject;
	if ( empty($cs_xmlObject->sidebar_layout->cs_layout) ) $cs_layout = ""; else $cs_layout = $cs_xmlObject->sidebar_layout->cs_layout;
	if ( empty($cs_xmlObject->sidebar_layout->cs_sidebar_left) ) $cs_sidebar_left = ""; else $cs_sidebar_left = $cs_xmlObject->sidebar_layout->cs_sidebar_left;
	if ( empty($cs_xmlObject->sidebar_layout->cs_sidebar_right) ) $cs_sidebar_right = ""; else $cs_sidebar_right = $cs_xmlObject->sidebar_layout->cs_sidebar_right;
  ?>
	<div class="elementhidden">
        <div class="clear"></div>
    	<div class="opt-head">
            <h4>SideBar Layout Options</h4>
            <div class="clear"></div>
        </div>
        <ul class="form-elements">
            <li class="to-label">
                <label>Select Layout</label>
            </li>
            <li class="to-field">
                <div class="meta-input">
                    <div class='radio-image-wrapper'>
                        <input <?php if($cs_layout=="none")echo "checked"?> onclick="show_sidebar('none')" type="radio" name="cs_layout" class="radio" value="none" id="radio_1" />
                        <label for="radio_1">
                            <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/admin/1.gif"  alt="" /></span>
                            <span <?php if($cs_layout=="none")echo "class='check-list'"?> id="check-list"><img src="<?php echo get_template_directory_uri()?>/images/admin/1-hover.gif" alt="" /></span>
                        </label>
                    </div>
                    <div class='radio-image-wrapper'>
                        <input <?php if($cs_layout=="right")echo "checked"?> onclick="show_sidebar('right')" type="radio" name="cs_layout" class="radio" value="right" id="radio_2"  />
                        <label for="radio_2">
                            <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/admin/2.gif" alt="" /></span>
                            <span <?php if($cs_layout=="right")echo "class='check-list'"?> id="check-list"><img src="<?php echo get_template_directory_uri()?>/images/admin/2-hover.gif" alt="" /></span>
                        </label>
                    </div>
                    
                </div>
            </li>
        </ul>
        <ul class="form-elements meta-body" style=" <?php if($cs_sidebar_left == ""){echo "display:none";}else echo "display:block";?>" id="sidebar_left" >
            <li class="to-label">
                <label>Select Left Sidebar</label>
            </li>
            <li class="to-field">
                <select name="cs_sidebar_left" class="select_dropdown" id="page-option-choose-left-sidebar">
                    <?php
                    $cs_theme_option = get_option('cs_theme_option');
                    if ( isset($cs_theme_option['sidebar']) and count($cs_theme_option['sidebar']) > 0 ) {
                        foreach ( $cs_theme_option['sidebar'] as $sidebar ){
                        ?>
                            <option <?php if ($cs_sidebar_left==$sidebar)echo "selected";?> ><?php echo $sidebar;?></option>
                        <?php
                        }
                    }
                    ?>
                </select>
            </li>
        </ul>
        <ul class="form-elements meta-body" style=" <?php if($cs_sidebar_right == ""){echo "display:none";}else echo "display:block";?>" id="sidebar_right" >
            <li class="to-label">
                <label>Select Right Sidebar</label>
            </li>
            <li class="to-field">
                <select name="cs_sidebar_right" class="select_dropdown" id="page-option-choose-right-sidebar">
                    <?php
                    if ( isset($cs_theme_option['sidebar']) and count($cs_theme_option['sidebar']) > 0 ) {
                        foreach ( $cs_theme_option['sidebar'] as $sidebar ){
                        ?>
                            <option <?php if ($cs_sidebar_right==$sidebar)echo "selected";?> ><?php echo $sidebar;?></option>
                        <?php
                        }
                    }
                    ?>
                </select>
                <input type="hidden" name="cs_orderby[]" value="meta_layout" />
            </li>
        </ul>
	</div>
	<div class="clear"></div>
<?php	
}
// side bar layout in pages, post and default page(theme options) end

// Default xml data save
function save_layout_xml($sxe) {
	
	if (empty($_POST['page_title']))
        $_POST['page_title'] = "";
    if (empty($_POST['cs_layout']))
        $_POST['cs_layout'] = "";
    if (empty($_POST['cs_sidebar_left']))
        $_POST['cs_sidebar_left'] = "";
    if (empty($_POST['cs_sidebar_right']))
        $_POST['cs_sidebar_right'] = "";
	$sxe->addChild('page_title', $_POST['page_title']);
	$sidebar_layout = $sxe->addChild('sidebar_layout');
		$sidebar_layout->addChild('cs_layout', $_POST["cs_layout"]);
		if ($_POST["cs_layout"] == "left") {
			$sidebar_layout->addChild('cs_sidebar_left', $_POST['cs_sidebar_left']);
		} else if ($_POST["cs_layout"] == "right") {
			$sidebar_layout->addChild('cs_sidebar_right', $_POST['cs_sidebar_right']);
		}else if ($_POST["cs_layout"] == "both_right" or $_POST["cs_layout"] == "both_left" or $_POST["cs_layout"] == "both") {
			$sidebar_layout->addChild('cs_sidebar_left', $_POST['cs_sidebar_left']);
			$sidebar_layout->addChild('cs_sidebar_right', $_POST['cs_sidebar_right']);
		}
    return $sxe;
}
?>