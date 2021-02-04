<?php

// page bulider items start

// gallery html form for page builder start

function cs_pb_gallery($die = 0){

	global $cs_node, $cs_count_node, $post;

	if ( isset($_POST['action']) ) {

			$name = $_POST['action'];

			$cs_counter = $_POST['counter'];

			$gallery_element_size = '50';

			$cs_gal_header_title_db = '';

			$cs_gal_layout_db = '';

			$cs_gal_album_db = '';

			$cs_gal_pagination_db = '';

			$cs_gal_media_per_page_db = get_option("posts_per_page");

	}

	else {

		$name = $cs_node->getName();

			$cs_count_node++;

			$gallery_element_size = $cs_node->gallery_element_size;

			$cs_gal_header_title_db = $cs_node->header_title;

			$cs_gal_layout_db = $cs_node->layout;

			$cs_gal_album_db = $cs_node->album;

			$cs_gal_pagination_db = $cs_node->pagination;

			$cs_gal_media_per_page_db = $cs_node->media_per_page;

				$cs_counter = $post->ID.$cs_count_node;

	}

?> 

	<div id="<?php echo $name.$cs_counter?>_del" class="column  parentdelete column_<?php echo $gallery_element_size?>" item="gallery" data="<?php echo element_size_data_array_index($gallery_element_size)?>" >

		<div class="column-in">

            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>

            <input type="hidden" name="gallery_element_size[]" class="item" value="<?php echo $gallery_element_size?>" >

            <a href="javascript:hide_all('<?php echo $name.$cs_counter?>')" class="options">Options</a> &nbsp; 

            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  

            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 

            <a class="increment" onclick="javascript:increment(this)">Inc</a>

		</div>

        <div class="poped-up" id="<?php echo $name.$cs_counter?>" style="border:none; background:#f8f8f8;" >

            <div class="opt-head">

                <h5>Edit Gallery Options</h5>

                <a href="javascript:show_all('<?php echo $name.$cs_counter?>')" class="closeit">&nbsp;</a>

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

                            <option value="gallery-four-col" <?php if($cs_gal_layout_db=="gallery-four-col")echo "selected";?> >4 Column</option>

                            <option value="gallery-three-col" <?php if($cs_gal_layout_db=="gallery-three-col")echo "selected";?> >3 Column</option>

                            <option value="gallery-two-col" <?php if($cs_gal_layout_db=="gallery-two-col")echo "selected";?> >2 Column</option>

                            <option value="gallery-masonry" <?php if($cs_gal_layout_db=="gallery-masonry")echo "selected";?> >Masonry</option>

                        </select>

                        

                        <p>Select gallery layout, single column, double column, thriple column or four column.</p>

                    </li>

                </ul>

                <ul class="form-elements">

                    <li class="to-label"><label>Choose Gallery/Album</label></li>

                    <li class="to-field">

                        <select name="cs_gal_album[]" class="dropdown">

                        	<option value="0">-- Select Gallery --</option>

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

                        <p>Select gallery album to show images.</p>

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

                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$cs_counter?>')" />

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

// services html form for page builder start

function cs_pb_services($die = 0){

	global $cs_node, $cs_count_node, $post;

	if ( isset($_POST['action']) ) {

		$name = $_POST['action'];

		$cs_counter = $_POST['counter'];

		$services_element_size = '50';

		$service_title = '';

		$service_text = '';

		$service_link_url = '';

		$service_bg_image = '';

	}

	else {

		$name = $cs_node->getName();

			$cs_count_node++;

			$services_element_size = $cs_node->services_element_size;

			$service_title = $cs_node->service_title;
			
			$service_type = $cs_node->service_type;

			$service_text = $cs_node->service_text;

			$service_link_url = $cs_node->service_link_url;

			$service_text = $cs_node->service_bg_image;

				$cs_counter = $post->ID.$cs_count_node;

}

?> 

	<div id="<?php echo $name.$cs_counter?>_del" class="column parentdelete column_<?php echo $services_element_size?>" item="services" data="<?php echo element_size_data_array_index($services_element_size)?>" >

    	<div class="column-in">

            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>

            <input type="hidden" name="services_element_size[]" class="item" value="<?php echo $services_element_size?>" >

           	<a href="javascript:hide_all('<?php echo $name.$cs_counter?>')" class="options">Options</a> &nbsp; 

            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  

            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 

            <a class="increment" onclick="javascript:increment(this)">Inc</a>

        </div>

       	<div class="poped-up" id="<?php echo $name.$cs_counter?>" style="border:none; background:#f8f8f8;" >

            <div class="opt-head">

                <h5>Edit Services Options</h5>

                <a href="javascript:show_all('<?php echo $name.$cs_counter?>')" class="closeit">&nbsp;</a>

            </div>

				<div class="wrapptabbox">

                    <div class="clone_append">

                        <?php

						$services_num = 0;

                        if ( isset($cs_node) ){

							$services_num = count($cs_node->service);

                            foreach ( $cs_node->service as $service ){

						?>

								<div class='clone_form'>

									<a href='#' class='deleteit_node'>Delete it</a>

									<label>Service Title:</label> <input class="txtfield" type="text" name="service_title[]" value="<?php echo $service->service_title ?>" />
                                    
                                    <label>Service Type:</label> 
                                    <select name="service_type[]" class="dropdown">
                                    	<option value="type1" <?php if($service->service_type == 'type1'){echo 'selected="selected"'; }?>>Type 1</option>
                                    	<option value="type2" <?php if($service->service_type == 'type2'){echo 'selected="selected"'; }?>>Type 2</option>
                                    </select>
                                  

									<label>Service Fontawsome Icon:</label> <input class="txtfield" type="text" name="service_icon[]" value="<?php echo $service->service_icon ?>" />
                                    <p>You can get fontawsome icons from <a href="http://fortawesome.github.io/Font-Awesome/icons/">here</a></p>

									<label>Service Bg Image:</label> <input class="txtfield" type="text" name="service_bg_image[]" value="<?php echo $service->service_bg_image ?>" />

									<label>Service Link URL:</label> <input class="txtfield" type="text" name="service_link_url[]" value="<?php echo $service->service_link_url ?>" />

									<label>Service Text:</label> <textarea class="txtfield" name="service_text[]"><?php echo $service->service_text ?></textarea>

									

								</div>

                        

                        <?php

                            }

                        }

                        ?>

                    </div>

                    <div class="opt-conts">

                        <ul class="form-elements">

                            <li class="to-label"><label></label></li>

                            <li class="to-field"><a href="#" class="add_services">Add service</a></li>

                        </ul>

                        <ul class="form-elements noborder">

                            <li class="to-label"></li>

                            <li class="to-field">

                                <input type="hidden" name="services_num[]" value="<?php echo $services_num?>" class="fieldCounter"  />

                                <input type="hidden" name="cs_orderby[]" value="services" />

                                <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$cs_counter?>')" />

                            </li>

                        </ul>

                    </div>

            	</div>

                            

       </div>

    </div>

<?php

	if ( $die <> 1 ) die();

}

add_action('wp_ajax_cs_pb_services', 'cs_pb_services');

// services html form for page builder end

// slider html form for page builder start

function cs_pb_slider($die = 0){

	global $cs_node, $cs_count_node, $post;

	if ( isset($_POST['action']) ) {

		$name = $_POST['action'];

		$cs_counter = $_POST['counter'];

		$slider_element_size = '50';

		$cs_slider_header_title_db = '';

		$cs_slider_type_db = '';

		$cs_slider_db = '';

		$cs_slider_width_db = '';

		$cs_slider_height_db = '';

		$slider_view= '';

		$slider_id ='';

	}

	else {

		$name = $cs_node->getName();

			$cs_count_node++;

			$slider_element_size = $cs_node->slider_element_size;

			$cs_slider_header_title_db = $cs_node->slider_header_title;

			$cs_slider_type_db = $cs_node->slider_type;

			$cs_slider_db = $cs_node->slider;

			$slider_view=  $cs_node->slider_view;

			$slider_id = $cs_node->slider_id;

			$cs_slider_width_db = $cs_node->width;

			$cs_slider_height_db = $cs_node->height;

				$cs_counter = $post->ID.$cs_count_node;

	}

?>

	<div id="<?php echo $name.$cs_counter?>_del" class="column  parentdelete column_<?php echo $slider_element_size?>" item="slider" data="<?php echo element_size_data_array_index($slider_element_size)?>" >

		<div class="column-in">

            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>

            <input type="hidden" name="slider_element_size[]" class="item" value="<?php echo $slider_element_size?>" >

            <a href="javascript:hide_all('<?php echo $name.$cs_counter?>')" class="options">Options</a>

            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;

            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 

            <a class="increment" onclick="javascript:increment(this)">Inc</a>

		</div>

        <div class="poped-up" id="<?php echo $name.$cs_counter?>" style="border:none; background:#f8f8f8;" >

            <div class="opt-head">

                <h5>Edit Slider Options</h5>

                <a href="javascript:show_all('<?php echo $name.$cs_counter?>')" class="closeit">&nbsp;</a>

            </div>

            <div class="opt-conts">

            	<ul class="form-elements">

                    <li class="to-label"><label>Slider Header Title</label></li>

                    <li class="to-field">

                        <input type="text" name="cs_slider_header_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_slider_header_title_db)?>" />

                        <p>Please enter slider header title.</p>

                    </li>                    

                </ul>

            	<ul class="form-elements">

                    <li class="to-label"><label>Choose SliderType</label></li>

                    <li class="to-field">

                        <select name="cs_slider_type[]" class="dropdown" onchange="cs_toggle_height(this.value,'cs_slider_height<?php echo $name.$cs_counter?>')">

                             <option <?php if($cs_slider_type_db=="Flex Slider"){echo "selected";}?> >Flex Slider</option>

                             <option <?php if($cs_slider_type_db=="Custom Slider"){echo "selected";}?> >Custom Slider</option>

                        </select>

                    </li>

                </ul>

                <ul class="form-elements" id="choose_slider" style="display:<?php if($cs_slider_type_db == "Custom Slider")echo "none"; else echo "inline"; ?>">

                    <li class="to-label"><label>Choose Slider</label></li>

                    <li class="to-field">

                        <select name="cs_slider[]" class="dropdown">

                             <?php

                                $query = array( 'posts_per_page' => '-1', 'post_type' => 'cs_slider', 'orderby'=>'ID', 'post_status' => 'publish' );

                                $wp_query = new WP_Query($query);

                                while ($wp_query->have_posts()) : $wp_query->the_post();

                            ?>

                                <option <?php if($post->post_name==$cs_slider_db)echo "selected";?> value="<?php echo $post->post_name; ?>"><?php the_title()?></option>

                            <?php

                                endwhile;

                            ?>

                        </select>

                    </li>

                </ul>

                <ul class="form-elements" >

                    <li class="to-label"><label>Slider View</label></li>

                    <li class="to-field">

                        <select name="slider_view[]" class="dropdown" >

                            <option <?php if($slider_view=="content")echo "selected";?> >content</option>

                            <option <?php if($slider_view=="header")echo "selected";?> >header</option>

                         </select>

                    </li>

                </ul>

                <ul class="form-elements" id="layer_slider" style="display:<?php if($cs_slider_type_db == "Custom Slider")echo "inline"; else echo "none"; ?>" >

                    <li class="to-label">

                        <label>Use Short Code</label>

                    </li>


                    <li class="to-field">

                        <input type="text" name="cs_slider_id[]" class="txtfield" value="<?php echo htmlspecialchars($slider_id);?>" />

                    </li>

                    <li class="to-label"></li>

                    <li class="to-field">

                        <p>Please enter the Revolution/Other Slider Short Code like [rev_slider WeStand]</p>

                    </li>                                            

                </ul>

                <ul class="form-elements noborder">

                    <li class="to-label"></li>

                    <li class="to-field">

                    	<input type="hidden" name="cs_orderby[]" value="slider" />

                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$cs_counter?>')" />

                    </li>

                </ul>

            </div>

       </div>

    </div>

<?php

	if ( $die <> 1 ) die();

}

add_action('wp_ajax_cs_pb_slider', 'cs_pb_slider');

// slider html form for page builder end

add_action('wp_ajax_add_gradiants_to_list', 'add_gradiants_to_list');



function add_gradiants_to_list(){

	global $counter_track, $address_name, $payer_email, $payment_gross, $txn_id, $payment_date;

	foreach ($_POST as $keys=>$values) {

		$$keys = $values;

	}

	

?>

    <tr id="edit_track<?php echo $counter_track?>">

        <td id="address_name<?php echo $counter_track?>" style="width:20%;"><?php echo $address_name?></td>

        <td id="payer_email<?php echo $counter_track?>" style="width:20%;"><?php echo $payer_email?></td>

        <td id="payment_gross<?php echo $counter_track?>" style="width:20%;"><?php echo $payment_gross?></td>

        <td id="txn_id<?php echo $counter_track?>" style="width:20%;"><?php echo $txn_id?></td>

        <td id="payment_date<?php echo $counter_track?>" style="width:20%;"><?php echo $payment_date?></td>

        <td class="centr" style="width:20%;">

            <a href="javascript:openpopedup('edit_track_form<?php echo $counter_track?>')" class="actions edit">&nbsp;</a>

            <a onclick="javascript:return confirm('Are you sure! You want to delete this Transaction')" href="javascript:cs_div_remove('edit_track<?php echo $counter_track?>')" class="actions delete">&nbsp;</a>

            <div class="poped-up" id="edit_track_form<?php echo $counter_track?>" style="position:absolute;">

                <div class="opt-head">

                    <h5>Edit Donation</h5>

                    <a href="javascript:closepopedup('edit_track_form<?php echo $counter_track?>')" class="closeit">&nbsp;</a>

                    <div class="clear"></div>

                </div>

                <ul class="form-elements">

                    <li class="to-label"><label>Donar Name</label></li>

                    <li class="to-field"><input type="text" name="address_name[]" value="<?php echo htmlspecialchars($address_name)?>" id="address_name<?php echo $counter_track?>" /><p>Put Donar Name</p></li>

                    

                </ul>

                <ul class="form-elements">

                    <li class="to-label"><label>Email</label></li>

                    <li class="to-field"><input type="text" name="payer_email[]" value="<?php echo htmlspecialchars($payer_email)?>" id="payer_email<?php echo $counter_track?>" /><p>Put Donor Email</p></li>

                    

                </ul>

                <ul class="form-elements">

                    <li class="to-label"><label>Amount</label></li>

                    <li class="to-field"><input type="text" name="payment_gross[]" value="<?php echo htmlspecialchars($payment_gross)?>" id="payment_gross<?php echo $counter_track?>" /><p>Put Donor Raised Amount</p></li>

                    

                </ul>

                <ul class="form-elements">

                    <li class="to-label"><label>Transaction ID</label></li>

                    <li class="to-field"><input type="text" name="txn_id[]" value="<?php echo htmlspecialchars($txn_id)?>" id="txn_id<?php echo $counter_track?>" /><p>Put Donor Trasaction id</p></li>

                    

                </ul>

                <ul class="form-elements">

                    <li class="to-label"><label>Donation Date</label></li>

                    <li class="to-field"><input type="text" name="payment_date[]" value="<?php echo htmlspecialchars($payment_date)?>" id="payment_date<?php echo $counter_track?>" /><p>Put Donation Date</p></li>

                    

                </ul>

                <ul class="form-elements noborder">

                    <li class="to-label"><label></label></li>

                    <li class="to-field"><input type="button" value="Update Donation" onclick="update_title(<?php echo $counter_track?>); closepopedup('edit_track_form<?php echo $counter_track?>')" /></li>

                </ul>

            </div>

        </td>

    </tr>

<?php

}


	if ( isset($action) ) die();

// blog html form for page builder start

function cs_pb_blog($die = 0){

	global $cs_node, $cs_count_node, $post;

	if ( isset($_POST['action']) ) {

		$name = $_POST['action'];

		$cs_counter = $_POST['counter'];

		$blog_element_size = '50';

		$cs_blog_title_db = '';

		$cs_blog_description_db = '';

		$cs_blog_view_db = '';

		$cs_blog_cat_db = '';

		$cs_blog_excerpt_db = '255';

		$cs_blog_num_post_db = get_option("posts_per_page");

		$cs_blog_pagination_db = '';

		$cs_post_description_db = '';
		
		$var_pb_blog_view_all = '';
		
		$cs_blog_orderby_db = 'DESC';
  
 
	}

	else {

		$name = $cs_node->getName();

			$cs_count_node++;

			$blog_element_size = $cs_node->blog_element_size;

			$cs_blog_title_db = $cs_node->cs_blog_title;

			$cs_blog_description_db = $cs_node->cs_blog_description;

			$cs_blog_view_db = $cs_node->cs_blog_view;

			$cs_blog_cat_db = $cs_node->cs_blog_cat;

			$cs_blog_excerpt_db = $cs_node->cs_blog_excerpt;

			$cs_blog_num_post_db = $cs_node->cs_blog_num_post;

			$cs_blog_pagination_db = $cs_node->cs_blog_pagination;

			$cs_blog_description_db = $cs_node->cs_blog_description;
			
			$cs_blog_orderby_db = $cs_node->cs_blog_orderby;
			
			$var_pb_blog_view_all = $cs_node->var_pb_blog_view_all;
			
 				$cs_counter = $post->ID.$cs_count_node;
}

?> 

	<div id="<?php echo $name.$cs_counter?>_del" class="column  parentdelete column_<?php echo $blog_element_size?>" item="blog" data="<?php echo element_size_data_array_index($blog_element_size)?>" >

		<div class="column-in">

            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>

            <input type="hidden" name="blog_element_size[]" class="item" value="<?php echo $blog_element_size?>" >

            <a href="javascript:hide_all('<?php echo $name.$cs_counter?>')" class="options">Options</a>

            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;

            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 

            <a class="increment" onclick="javascript:increment(this)">Inc</a>

		</div>

       	<div class="poped-up" id="<?php echo $name.$cs_counter?>" style="border:none; background:#f8f8f8;" >

            <div class="opt-head">

                <h5>Edit Blog Options</h5>

                <a href="javascript:show_all('<?php echo $name.$cs_counter?>')" class="closeit">&nbsp;</a>

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

                    <li class="to-label"><label>Select View</label></li>

                    <li class="to-field">

                        <select name="cs_blog_view[]" class="dropdown"  onchange="javascript:blog_toggle(this.value,<?php echo $cs_counter?>)">

                         	<option <?php if($cs_blog_view_db=="blog-large")echo "selected";?> value="blog-large">Large</option>

                            <option <?php if($cs_blog_view_db=="blog-medium")echo "selected";?> value="blog-medium">Medium</option>

                         	<option <?php if($cs_blog_view_db=="blog-grid")echo "selected";?> value="blog-grid">Grid</option>
                            
                            <option <?php if($cs_blog_view_db=="blog-carousel-view")echo "selected";?> value="blog-carousel-view">Carousal</option>

                        </select>

 
                    </li>                                        

                </ul>
				<ul class="form-elements">

                    <li class="to-label"><label>Choose Category</label></li>

                    <li class="to-field">

                        <select name="cs_blog_cat[]" class="dropdown">

                        	<option value="0">-- Select Category --</option>

							<?php show_all_cats('', '', $cs_blog_cat_db, "category");?>

                        </select>

                        <p>Please select category to show posts. If you dont select category it will display all posts.</p>

                    </li>                                        

                </ul>
			<div id="Blog-listing<?php echo $cs_counter?>" <?php if($cs_blog_view_db=="blog-carousel-view")echo 'style="display:none"'?>>
                <ul class="form-elements">
                    <li class="to-label"><label>Post Order</label></li>
                    <li class="to-field">
                        <select name="cs_blog_orderby[]" class="dropdown" >
                            <option <?php if($cs_blog_orderby_db=="ASC")echo "selected";?> value="ASC">ASC</option>
                            <option <?php if($cs_blog_orderby_db=="DESC")echo "selected";?> value="DESC">DESC</option>
                        </select>
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

                <ul class="form-elements">

                    <li class="to-label"><label>Pagination</label></li>

                    <li class="to-field">

                        <select name="cs_blog_pagination[]" class="dropdown" >

                            <option <?php if($cs_blog_pagination_db=="Show Pagination")echo "selected";?> >Show Pagination</option>

                            <option <?php if($cs_blog_pagination_db=="Single Page")echo "selected";?> >Single Page</option>

                            <!--<option <?php //if($cs_blog_pagination_db=="Load More")echo "selected";?> >Load More</option>-->

                        </select>

                    </li>

                </ul>
			</div>
                <ul class="form-elements">

                    <li class="to-label"><label>No. of Post Per Page</label></li>

                    <li class="to-field">

                    	<input type="text" name="cs_blog_num_post[]" class="txtfield" value="<?php echo $cs_blog_num_post_db; ?>" />

                        <p>To display all the records, leave this field blank.</p>

                    </li>

                </ul>

                <ul class="form-elements noborder">

                    <li class="to-label"></li>

                    <li class="to-field">

                    	<input type="hidden" name="cs_orderby[]" value="blog" />

                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$cs_counter?>')" />

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
// Team page builder function
function cs_pb_team($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$var_pb_team_element_size = '50';
		$var_pb_team_title = '';
		$var_pb_team_cat = '';
		$var_pb_team_view = '';
		$var_pb_team_filterable = '';
		$var_pb_team_pagination = '';
		$cs_team_excerpt = '255';
		$cs_team_orderby = 'DESC';
		$var_pb_team_per_page = get_option("posts_per_page");
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$var_pb_team_element_size = $cs_node->var_pb_team_element_size;
			$var_pb_team_title = $cs_node->var_pb_team_title;
			$var_pb_team_cat = $cs_node->var_pb_team_cat;
			$var_pb_team_view = $cs_node->var_pb_team_view;
			$var_pb_team_filterable = $cs_node->var_pb_team_filterable;
			$var_pb_team_pagination = $cs_node->var_pb_team_pagination;
 			$var_pb_team_per_page = $cs_node->var_pb_team_per_page;
			$cs_team_excerpt = $cs_node->cs_team_excerpt;
			$cs_team_orderby = $cs_node->cs_team_orderby;
				$counter = $post->ID.$count_node;
	}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column parentdelete column_<?php echo $var_pb_team_element_size?>" item="blog" data="<?php echo element_size_data_array_index($var_pb_team_element_size)?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="var_pb_team_element_size[]" class="item" value="<?php echo $var_pb_team_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a>
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp; 
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
        <div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Album Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Team Title</label></li>
                    <li class="to-field">
                        <input type="text" name="var_pb_team_title[]" class="txtfield" value="<?php echo htmlspecialchars($var_pb_team_title)?>" />
                        <p>Team Page Title</p>
                    </li>                                            
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Choose Category</label></li>
                    <li class="to-field">
                        <select name="var_pb_team_cat[]" class="dropdown">
                        	<option value="0">-- All Categories --</option>
                        	<?php show_all_cats('', '', $var_pb_team_cat, "team-category");?>
                        </select>
                        <p>Choose category to show Team list</p>
                    </li>
                </ul>
                <ul class="form-elements">

                    <li class="to-label"><label>Select View</label></li>

                    <li class="to-field">

                        <select name="var_pb_team_view[]" class="dropdown">

                         	<option <?php if($var_pb_team_view=="listing")echo "selected";?> value="listing">Listing View</option>
                         	<option <?php if($var_pb_team_view=="grid")echo "selected";?> value="grid">Large Grid View</option>
                            <option <?php if($var_pb_team_view=="small")echo "selected";?> value="small">Small Grid View</option>

                        </select>

                        

                    </li>                                        

                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Post Order</label></li>
                    <li class="to-field">
                        <select name="cs_team_orderby[]" class="dropdown" >
                            <option <?php if($cs_team_orderby=="ASC")echo "selected";?> value="ASC">ASC</option>
                            <option <?php if($cs_team_orderby=="DESC")echo "selected";?> value="DESC">DESC</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">

                    <li class="to-label"><label>Length of Excerpt</label></li>

                    <li class="to-field">

                        <input type="text" name="cs_team_excerpt[]" class="txtfield" value="<?php echo $cs_team_excerpt;?>" />

                        <p>Enter number of character for short description text.</p>

                    </li>                         

                </ul>
                
				<ul class="form-elements">
                    <li class="to-label"><label>Pagination</label></li>
                    <li class="to-field">
                        <select name="var_pb_team_pagination[]" class="dropdown" >
                            <option <?php if($var_pb_team_pagination=="Show Pagination")echo "selected";?> >Show Pagination</option>
                            <option <?php if($var_pb_team_pagination=="Single Page")echo "selected";?> >Single Page</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>No. of Team Per Page</label></li>
                    <li class="to-field">
                        <input type="text" name="var_pb_team_per_page[]" class="txtfield" value="<?php echo $var_pb_team_per_page;?>" />
                        <p>To display all the records, leave this field blank.</p>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label></label></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="staff" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_team', 'cs_pb_team');

// event html form for page builder start

// Events Meta data save

function events_meta_save($post_id) {

    global $wpdb;
	
	//event_calendar, event_pagination, event_tags

    if (empty($_POST["sub_title"])){ $_POST["sub_title"] = "";}
	
	if (empty($_POST["event_thumb_view"])){ $_POST["event_thumb_view"] = "";}

    if (empty($_POST["event_social_sharing"])){ $_POST["event_social_sharing"] = "";}

	if (empty($_POST["event_buy_now"])){ $_POST["event_buy_now"] = "";}

	if (empty($_POST["event_start_time"])){ $_POST["event_start_time"] = "";}

	if (empty($_POST["event_end_time"])){ $_POST["event_end_time"] = "";}

    if (empty($_POST["event_all_day"])){ $_POST["event_all_day"] = "";}

    if (empty($_POST["event_address"])){ $_POST["event_address"] = "";}
	
	 if (empty($_POST["event_ticket_options"])){ $_POST["event_ticket_options"] = "";}

    if (empty($_POST["event_map"])){ $_POST["event_map"] = "";}
	
	if (empty($_POST["event_ticket_price"])){ $_POST["event_ticket_price"] = "";}
	
	if (empty($_POST["event_ticket_color"])){ $_POST["event_ticket_color"] = "";}
	
    if (empty($_POST["post_author_info_show"])){ $_POST["post_author_info_show"] = "";}
	
	if (empty($_POST["event_calendar"])){ $_POST["event_calendar"] = "";}
	if (empty($_POST["event_pagination"])){ $_POST["event_pagination"] = "";}
	if (empty($_POST["event_tags"])){ $_POST["event_tags"] = "";}
	if (empty($_POST["event_like"])){ $_POST["event_like"] = "";}

    $sxe = new SimpleXMLElement("<event></event>");

		$sxe->addChild('event_thumb_view', $_POST['event_thumb_view'] );

		$sxe->addChild('event_social_sharing', $_POST["event_social_sharing"]);

		$sxe->addChild('event_buy_now', $_POST["event_buy_now"]);

 		$sxe->addChild('event_start_time', $_POST["event_start_time"]);

		$sxe->addChild('event_end_time', $_POST["event_end_time"]);
		$sxe->addChild('event_ticket_color', $_POST["event_ticket_color"]);

		$sxe->addChild('event_all_day', $_POST["event_all_day"]);
		
		$sxe->addChild('event_ticket_options', $_POST["event_ticket_options"]);
		$sxe->addChild('event_ticket_color', $_POST["event_ticket_color"]);

 		$sxe->addChild('event_address', $_POST["event_address"]);

		$sxe->addChild('event_map', $_POST["event_map"]);
		$sxe->addChild('event_calendar', $_POST["event_calendar"]);
		$sxe->addChild('event_like', $_POST["event_like"]);
		$sxe->addChild('event_pagination', $_POST["event_pagination"]);
		$sxe->addChild('event_tags', $_POST["event_tags"]);
		
		
		
		$sxe->addChild('post_author_info_show', $_POST["post_author_info_show"]);
	

    $sxe = save_layout_xml($sxe);

    update_post_meta($post_id, 'cs_event_meta', $sxe->asXML());

}



// parallax html form for page builder start
function cs_pb_parallax($die = 0){
	global $cs_node, $cs_count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$cs_counter = $_POST['counter'];
		$parallax_element_size = '100';
		$parallax_title = '';
		$parallax_height = '';
		$parallax_margin_top = '20';
		$parallax_margin_bottom = '20';
		$parallax_padding_top = '20';
		$parallax_padding_bottom = '20';
	
	
			$parallax_custom_text = '';
			$parallax_custom_img = '';
 			$parallax_custom_bgcolor = '';

	}
	else {
		$name = $cs_node->getName();
			$cs_count_node++;
			$parallax_element_size = $cs_node->parallax_element_size;
			$parallax_title = $cs_node->parallax_title;
			$parallax_height = $cs_node->parallax_height;
			$parallax_margin_top = $cs_node->parallax_margin_top;
			$parallax_margin_bottom = $cs_node->parallax_margin_bottom;
			$parallax_padding_top = $cs_node->parallax_padding_top;
			$parallax_padding_bottom = $cs_node->parallax_padding_bottom;
			
				$parallax_custom_text = $cs_node->parallax_custom_text;
				$parallax_custom_img = $cs_node->parallax_custom_img;
				$parallax_back_top = $cs_node->parallax_back_top;
				$parallax_custom_bgcolor = $cs_node->parallax_custom_bgcolor;

   			$cs_counter = $post->ID.$cs_count_node;
}
?> 


	<div id="<?php echo $name.$cs_counter?>_del" class="column  parentdelete column_<?php echo $parallax_element_size?>" item="event" data="<?php echo element_size_data_array_index($parallax_element_size)?>" >

		<div class="column-in">

            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>

            <input type="hidden" name="parallax_element_size[]" class="item" value="<?php echo $parallax_element_size?>" >

            <a href="javascript:hide_all('<?php echo $name.$cs_counter?>')" class="options">Options</a>

            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;

            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 

            <a class="increment" onclick="javascript:increment(this)">Inc</a>

		</div>


       	<div class="poped-up" id="<?php echo $name.$cs_counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Parallax Options</h5>
                <a href="javascript:show_all('<?php echo $name.$cs_counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            		<ul class="form-elements">
                        <li class="to-label"><label>Title</label></li>
                        <li class="to-field"><input type="text" name="parallax_title[]" class="txtfield" value="<?php echo $parallax_title?>" /></li>
                    </ul>
                	<ul class="form-elements">
                        <li class="to-label"><label>Height</label></li>
                        <li class="to-field"><input type="text" name="parallax_height[]" class="txtfield" value="<?php echo $parallax_height?>" /></li>
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label"><label>Paddding Top</label></li>
                        <li class="to-field"><input type="text" name="parallax_padding_top[]" class="txtfield" value="<?php echo $parallax_padding_top?>" />
                        <p>Set the top paddding (In PX)</p>
                        </li>
                    </ul>
                    <ul class="form-elements">
                        <li class="to-label"><label>Paddding Bottom</label></li>
                        <li class="to-field"><input type="text" name="parallax_padding_bottom[]" class="txtfield" value="<?php echo $parallax_padding_bottom?>" />
                        <p>Set the bottom Paddding (In PX)</p>
                        </li>
                    </ul>
                     <ul class="form-elements">
                        <li class="to-label"><label>Margin Top</label></li>
                        <li class="to-field"><input type="text" name="parallax_margin_top[]" class="txtfield" value="<?php echo $parallax_margin_top?>" />
                        <p>Set the top margin (In PX)</p>
                        </li>
                    </ul>
                     <ul class="form-elements">
                        <li class="to-label"><label>Margin Bottom</label></li>
                        <li class="to-field"><input type="text" name="parallax_margin_bottom[]" class="txtfield" value="<?php echo $parallax_margin_bottom?>" />
                        <p>Set the bottom margin (In PX)</p>
                        </li>
                    </ul>
                
            
                        <ul class="form-elements">
                            <li class="to-label"><label>Text</label></li>
                            <li class="to-field"><textarea name="parallax_custom_text[]"><?php echo $parallax_custom_text?></textarea></li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Image Path</label></li>
                            <li class="to-field">
                                <input type="text" name="parallax_custom_img[]" class="txtfield" value="<?php echo $parallax_custom_img?>" />
                                <p>e.g. http://yourdomain.com/logo.png</p>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Background Color</label></li>
                            <li><input type="text"  name="parallax_custom_bgcolor[]" class="parallax_custom_bgcolor" value="<?php echo $parallax_custom_bgcolor?>" data-default-color=""  /></li>
                            <script type="text/javascript">
                                jQuery(document).ready(function($){
                                    $('.parallax_custom_bgcolor').wpColorPicker(); 
                                });
                            </script>
                        </ul>
                
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="parallax" />

                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$cs_counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_parallax', 'cs_pb_parallax');
// parallax html form for page builder end




function cs_pb_event($die = 0){

	global $cs_node, $cs_count_node, $post;

	if ( isset($_POST['action']) ) {

		$name = $_POST['action'];

		$cs_counter = $_POST['counter'];

		$event_element_size = '50';

		$cs_event_title_db = '';

 		$cs_event_type_db = '';
		
		$cs_event_view_db = '';

		$cs_event_category_db = '';
		
		$cs_event_featured_category_db = '';

		$cs_event_time_db = '';

		$cs_event_organizer_db = '';

 		$cs_event_filterables_db = '';

		$cs_event_pagination_db = '';
		
		$cs_event_view_all_link = '';
		
		$cs_event_excerpt = '150';
		
		$cs_event_thumbnail = '';
		
		$cs_event_featured_category = '';

		$cs_event_per_page_db = get_option("posts_per_page");

	}

	else {

		$name = $cs_node->getName();

			$cs_count_node++;

			$event_element_size = $cs_node->event_element_size;

			$cs_event_title_db = $cs_node->cs_event_title;

 			$cs_event_type_db = $cs_node->cs_event_type;

			$cs_event_category_db = $cs_node->cs_event_category;
			
			$cs_event_view_db = $cs_node->cs_event_view;

			$cs_event_time_db = $cs_node->cs_event_time;

 			$cs_event_filterables_db = $cs_node->cs_event_filterables;

			$cs_event_pagination_db = $cs_node->cs_event_pagination;

			$cs_event_per_page_db = $cs_node->cs_event_per_page;
			
			$cs_event_excerpt = $cs_node->cs_event_excerpt;
			
			$cs_event_view_all_link = $cs_node->cs_event_view_all_link;
			
			$cs_event_featured_category = $cs_node->cs_event_featured_category;
			
			$cs_event_thumbnail = $cs_node->cs_event_thumbnail;

			$cs_counter = $post->ID.$cs_count_node;

}

?> 

	<div id="<?php echo $name.$cs_counter?>_del" class="column  parentdelete column_<?php echo $event_element_size?>" item="event" data="<?php echo element_size_data_array_index($event_element_size)?>" >

		<div class="column-in">

            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>

            <input type="hidden" name="event_element_size[]" class="item" value="<?php echo $event_element_size?>" >

            <a href="javascript:hide_all('<?php echo $name.$cs_counter?>')" class="options">Options</a>

            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;

            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 

            <a class="increment" onclick="javascript:increment(this)">Inc</a>

		</div>

        <div class="poped-up" id="<?php echo $name.$cs_counter?>" style="border:none; background:#f8f8f8;" >

            <div class="opt-head">

                <h5>Edit Event Options</h5>

                <a href="javascript:show_all('<?php echo $name.$cs_counter?>')" class="closeit">&nbsp;</a>

            </div>

            <div class="opt-conts">

            	<ul class="form-elements">

                    <li class="to-label"><label>Event Title</label></li>

                    <li class="to-field">

                        <input type="text" name="cs_event_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_event_title_db)?>" />

                        <p>Event Page Title</p>

                    </li>

                </ul>

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

                        	<option value="0">-- All Categories Posts --</option>

                            <?php show_all_cats('', '', $cs_event_category_db, "event-category");?>

                        </select>

                    </li>

                </ul>
				<ul class="form-elements">

                    <li class="to-label"><label>Select View</label></li>

                    <li class="to-field">

                        <select name="cs_event_view[]" class="dropdown" onchange="javascript:event_toggle(this.value,'<?php echo $cs_counter;?>')">

                         	<option <?php if($cs_event_view_db=="eventlisting")echo "selected";?> value="eventlisting">Listing View</option>
                         	<option <?php if($cs_event_view_db=="event-gridview")echo "selected";?> value="event-gridview">Grid View</option>
                            <option <?php if($cs_event_view_db=="event-calendarview")echo "selected";?> value="event-calendarview">Calendar View</option>
                            <option <?php if($cs_event_view_db=="event-timeline")echo "selected";?> value="event-timeline">Timeline Listing</option>

                        </select>

                        

                    </li>                                        

                </ul>
                <div id="featured_timeline_event<?php echo $cs_counter;?>" <?php if($cs_event_view_db <> "event-timeline")echo 'style="display:none"'?>>
                <ul class="form-elements">

                    <li class="to-label"><label>Featured Event Category</label></li>

                    <li class="to-field">

                        <select name="cs_event_featured_category[]" class="dropdown">

                        	<option value="0">-- Select Category --</option>

                            <?php show_all_cats('', '', $cs_event_featured_category, "event-category");?>

                        </select>

                    </li>

                </ul>
                <ul class="form-elements">

                    <li class="to-label"><label>Show Thumbnail</label></li>

                    <li class="to-field">

                        <select name="cs_event_thumbnail[]" class="dropdown">

                            <option value="Yes" <?php if($cs_event_thumbnail=="Yes")echo "selected";?> >Yes</option>

                            <option value="No" <?php if($cs_event_thumbnail=="No")echo "selected";?> >No</option>

                        </select>

                    </li>

                </ul>
                
                </div>
                <div id="event-lising<?php echo $cs_counter;?>"  <?php if($cs_event_view_db == "event-calendarview")echo 'style="display:none"'?>>
                <ul class="form-elements">

                    <li class="to-label"><label>Show Time</label></li>

                    <li class="to-field">

                        <select name="cs_event_time[]" class="dropdown">

                            <option value="Yes" <?php if($cs_event_time_db=="Yes")echo "selected";?> >Yes</option>

                            <option value="No" <?php if($cs_event_time_db=="No")echo "selected";?> >No</option>

                        </select>

                    </li>

                </ul>
				<ul class="form-elements">
    
                    <li class="to-label"><label>View All Events Link</label></li>

                    <li class="to-field">

                        <input type="text" name="cs_event_view_all_link[]" class="txtfield" value="<?php echo $cs_event_view_all_link;?>" />


                    </li>                         

                </ul>
                    
                
                    <ul class="form-elements">
    
                        <li class="to-label"><label>Length of Excerpt</label></li>
    
                        <li class="to-field">
    
                            <input type="text" name="cs_event_excerpt[]" class="txtfield" value="<?php echo $cs_event_excerpt;?>" />
    
                            <p>Enter number of character for short description text.</p>
    
                        </li>                         
    
                    </ul>

                     <ul class="form-elements">
    
                        <li class="to-label"><label>Filterables</label></li>
    
                        <li class="to-field">
    
                            <select name="cs_event_filterables[]" class="dropdown" >
    
                                <option value="No" <?php if($cs_event_filterables_db=="No")echo "selected";?> >No</option>
    
                                <option value="Yes" <?php if($cs_event_filterables_db=="Yes")echo "selected";?> >Yes</option>
    
                            </select>
    
                        </li>
    
                    </ul>

                    <ul class="form-elements">
    
                        <li class="to-label"><label>Pagination</label></li>
    
                        <li class="to-field">
    
                            <select name="cs_event_pagination[]" class="dropdown" >
    
                                <option <?php if($cs_event_pagination_db=="Show Pagination")echo "selected";?> >Show Pagination</option>
    
                                <!--<option <?php //if($cs_event_pagination_db=="Load More")echo "selected";?> >Load More</option>-->
    
                                <option <?php if($cs_event_pagination_db=="Single Page")echo "selected";?> >Single Page</option>
    
                            </select>
    
                            <p>Show navigation only at List View.</p>
    
                        </li>
    
                    </ul>

			</div>
                <ul class="form-elements">

                    <li class="to-label"><label>No. of Events Per Page</label></li>

                    <li class="to-field">

                        <input type="text" name="cs_event_per_page[]" class="txtfield" value="<?php echo $cs_event_per_page_db; ?>" />

                        <p>To display all the records, leave this field blank.</p>

                    </li>

                </ul>

                <ul class="form-elements noborder">

                    <li class="to-label"></li>

                    <li class="to-field">

                    	<input type="hidden" name="cs_orderby[]" value="event" />

                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$cs_counter?>')" />

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


// Cause form for page builder start

function cs_pb_cause($die = 0){

	global $cs_node, $cs_count_node, $post;

	if ( isset($_POST['action']) ) {

		$name = $_POST['action'];

		$cs_counter = $_POST['counter'];

		$cause_element_size = '50';

		$cause_cat = '';

		$cause_title = '';

		$cause_pagination = '';

		$cause_per_page = get_option("posts_per_page");

		$cs_cause_excerpt = '140';
		
		$cause_type = '';
		
		$cause_view = '';
		
		$cs_cause_last_miles_percentage = '';

	}

	else {

		$name = $cs_node->getName();

			$cs_count_node++;

			$cause_element_size = $cs_node->cause_element_size;

			$cause_title = $cs_node->cause_title;

			$cause_cat = $cs_node->cause_cat;

			$cause_pagination = $cs_node->cause_pagination;

			$cause_per_page = $cs_node->cause_per_page;

			$cs_counter = $post->ID.$cs_count_node;

			$cs_cause_excerpt = $cs_node->cs_cause_excerpt;

			if($cs_cause_excerpt == ''){ $cs_cause_excerpt = 140;}

			
			$cause_type = $cs_node->cause_type;
			
			$cause_view = $cs_node->cause_view;
			
			$cs_cause_last_miles_percentage = '';
			
			$cs_cause_last_miles_percentage = $cs_node->cs_cause_last_miles_percentage;

	}

?> 

	<div id="<?php echo $name.$cs_counter?>_del" class="column  parentdelete column_<?php echo $cause_element_size?>" item="blog" data="<?php echo element_size_data_array_index($cause_element_size)?>" >

		<div class="column-in">

            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>

            <input type="hidden" name="cause_element_size[]" class="item" value="<?php echo $cause_element_size?>" >

            <a href="javascript:hide_all('<?php echo $name.$cs_counter?>')" class="options">Options</a>

            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;

            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 

            <a class="increment" onclick="javascript:increment(this)">Inc</a>

		</div>

        <div class="poped-up" id="<?php echo $name.$cs_counter?>" style="border:none; background:#f8f8f8;" >

            <div class="opt-head">

                <h5>Edit Menu Options</h5>

                <a href="javascript:show_all('<?php echo $name.$cs_counter?>')" class="closeit">&nbsp;</a>

            </div>

            <div class="opt-conts">

            	<ul class="form-elements">

                    <li class="to-label"><label>Cause Title</label></li>

                    <li class="to-field">

                        <input type="text" name="cause_title[]" class="txtfield" value="<?php echo htmlspecialchars($cause_title)?>" />

                        <p>Cause Section Title</p>

                    </li>                                            

                </ul>

                <ul class="form-elements">

                    <li class="to-label"><label>Choose Category</label></li>

                    <li class="to-field">

                        <select name="cause_cat[]" class="dropdown">

                        	<option value="">-- All Categories Posts --</option>

                             <?php show_all_cats('', '', $cause_cat, "cs_cause-category");?>

                        </select>

                        <p>Choose category to show Cause list</p>

                    </li>

                </ul>
			<ul class="form-elements">

                    <li class="to-label"><label>Select View</label></li>

                    <li class="to-field">

                        <select name="cause_view[]" class="dropdown">

                         	<option <?php if($cause_view=="listing")echo "selected";?> value="listing">Listing View</option>
                         	<option <?php if($cause_view=="small")echo "selected";?> value="small">Grid View</option>
                            

                        </select>

                        

                    </li>                                        

                </ul>
                
                <ul class="form-elements">

                        <li class="to-label"><label>Cause Types</label></li>

                        <li class="to-field">

                            <select name="cause_type[]" class="dropdown" onchange="cs_toggle_cause_last_miles(this.value, '<?php echo $cs_counter?>')">

                                <option <?php if($cause_type=="All")echo "selected";?> >All</option>

                                <option <?php if($cause_type=="Upcoming Causes")echo "selected";?> >Upcoming Causes</option>
                                
                                <option <?php if($cause_type=="Past Causes")echo "selected";?> >Past Causes</option>
                                
                                <option <?php if($cause_type=="cause-succesfully")echo "selected";?> value="cause-succesfully" >Successfully Funded</option>
                                
                                <option value="cause-last-miles" <?php if($cause_type == 'cause-last-miles'){echo 'selected="selected"'; }?>>Last Miles</option>

                            </select>

                        </li>

                    </ul>
				
                <div id="port_last<?php echo $cs_counter?>" <?php if($cause_type<>"cause-last-miles")echo 'style=" display:none"'?> >

                    <ul class="form-elements  noborder">

                        <li class="to-label"><label>Percentage for last miles</label></li>

                        <li class="to-field">

                            <input type="text" name="cs_cause_last_miles_percentage[]" class="txtfield" value="<?php echo $cs_cause_last_miles_percentage; ?>" />

                        </li>

                    </ul>

                    

                </div>
                 
                	<div id="port_pagination<?php echo $name.$cs_counter?>">

                        <ul class="form-elements">

                            <li class="to-label"><label>Pagination</label></li>

                            <li class="to-field">

                                <select name="cause_pagination[]" class="dropdown">

                                    <option <?php if($cause_pagination=="Show Pagination")echo "selected";?> >Show Pagination</option>

                                    <option <?php if($cause_pagination=="Single Page")echo "selected";?> >Single Page</option>

                                </select>

                            </li>

                        </ul>
						
                        

					</div>
                <ul class="form-elements">

                    <li class="to-label"><label>Length of Excerpt</label></li>

                    <li class="to-field">

                        <input type="text" name="cs_cause_excerpt[]" class="txtfield" value="<?php echo $cs_cause_excerpt; ?>" />

                        <p>Enter number of character for short description text.</p>

                    </li>

                </ul>
                
				<ul class="form-elements">

                        <li class="to-label"><label>No. of record Per Page</label></li>
    
                        <li class="to-field">
    
                            <input type="text" name="cause_per_page[]" class="txtfield" value="<?php echo $cause_per_page; ?>" />
    
                            <p>To display all the records, leave this field blank.</p>
    
                        </li>
    
                    </ul>
                <ul class="form-elements noborder">

                    <li class="to-label"><label></label></li>

                    <li class="to-field">

                    	<input type="hidden" name="cs_orderby[]" value="cause" />

                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$cs_counter?>')" />

                    </li>

                </ul>

            </div>

       </div>

    </div>


<?php

	if ( $die <> 1 ) die();

}

add_action('wp_ajax_cs_pb_cause', 'cs_pb_cause');

// contact us html form for page builder start

function cs_pb_contact($die = 0){

	global $cs_node, $cs_count_node, $post;

	if ( isset($_POST['action']) ) {

		$name = $_POST['action'];

		$cs_counter = $_POST['counter'];

		$contact_element_size = '50';

 		$cs_contact_email_db = '';

		$cs_contact_succ_msg_db = '';

	}

	else {

		$name = $cs_node->getName();

			$cs_count_node++;

			$contact_element_size = $cs_node->contact_element_size;

 			$cs_contact_email_db = $cs_node->cs_contact_email;

			$cs_contact_succ_msg_db = $cs_node->cs_contact_succ_msg;

				$cs_counter = $post->ID.$cs_count_node;

}

?> 

	<div id="<?php echo $name.$cs_counter?>_del" class="column  parentdelete column_<?php echo $contact_element_size?>" item="contact" data="<?php echo element_size_data_array_index($contact_element_size)?>" >

		<div class="column-in">

            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>

            <input type="hidden" name="contact_element_size[]" class="item" value="<?php echo $contact_element_size?>" >

            <a href="javascript:hide_all('<?php echo $name.$cs_counter?>')" class="options">Options</a>

            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;

            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 

            <a class="increment" onclick="javascript:increment(this)">Inc</a>

		</div>

       	<div class="poped-up" id="<?php echo $name.$cs_counter?>" style="border:none; background:#f8f8f8;" >

            <div class="opt-head">

                <h5>Edit Contact Form</h5>

                <a href="javascript:show_all('<?php echo $name.$cs_counter?>')" class="closeit">&nbsp;</a>

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

                <ul class="form-elements noborder">

                    <li class="to-label"></li>

                    <li class="to-field">

                    	<input type="hidden" name="cs_orderby[]" value="contact" />

                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$cs_counter?>')" />

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

	global $cs_node, $cs_count_node, $post;

	if ( isset($_POST['action']) ) {

		$name = $_POST['action'];

		$cs_counter = $_POST['counter'];

		$column_element_size = '25';

		$column_text = '';

	}

	else {

		$name = $cs_node->getName();

			$cs_count_node++;

			$column_element_size = $cs_node->column_element_size;

			$column_text = $cs_node->column_text;

				$cs_counter = $post->ID.$cs_count_node;

}

?> 

	<div id="<?php echo $name.$cs_counter?>_del" class="column  parentdelete column_<?php echo $column_element_size?>" item="column" data="<?php echo element_size_data_array_index($column_element_size)?>" >

    	<div class="column-in">

            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>

            <input type="hidden" name="column_element_size[]" class="item" value="<?php echo $column_element_size?>" >

            <a href="javascript:hide_all('<?php echo $name.$cs_counter?>')" class="options">Options</a> &nbsp; 

            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  

            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 

            <a class="increment" onclick="javascript:increment(this)">Inc</a>

		</div>

       	<div class="poped-up" id="<?php echo $name.$cs_counter?>" style="border:none; background:#f8f8f8;" >

            <div class="opt-head">

                <h5>Edit Column Options</h5>

                <a href="javascript:show_all('<?php echo $name.$cs_counter?>')" class="closeit">&nbsp;</a>

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

                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$cs_counter?>')" />

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

// video html form for page builder start
function cs_pb_video($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$video_element_size = '25';
		$video_url = '';
		$video_width = '';
		$video_height = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$video_element_size = $cs_node->video_element_size;
			$video_url = $cs_node->video_url;
			$video_width = $cs_node->video_width;
			$video_height = $cs_node->video_height;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $video_element_size?>" item="video" data="<?php echo element_size_data_array_index($video_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="video_element_size[]" class="item" value="<?php echo $video_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Video Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
                <ul class="form-elements">
                    <li class="to-label"><label>Video URL</label></li>
                    <li class="to-field">
                    	<input type="text" name="video_url[]" class="txtfield" value="<?php echo $video_url?>" />
                        <p>Enter Video URL (Youtube, Vimeo or any other supported by wordpress)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Width</label></li>
                    <li class="to-field"><input type="text" name="video_width[]" class="txtfield" value="<?php echo $video_width?>" /></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Height</label></li>
                    <li class="to-field"><input type="text" name="video_height[]" class="txtfield" value="<?php echo $video_height?>" /></li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="video" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_video', 'cs_pb_video');
// video html form for page builder end 



// google map html form for page builder start

function cs_pb_map($die = 0){

	global $cs_node, $cs_count_node, $post;

	if ( isset($_POST['action']) ) {

		$name = $_POST['action'];

		$cs_counter = $_POST['counter'];

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

		$map_view= '';

		$map_conactus_content = '<a href="'.home_url().'" class="logo"><img src="'.get_template_directory_uri().'/images/logo.png" alt=""></a>

                            <p>25 Infinite Square,</br> Red StreetCA 123456,</br> City name Canada,</p>

                            <ul>

                                <li><span>Phonee</span>123.456.78910</li>

                                <li><span>Mobile</span>(800) 123 4567 89</li>

                                <li><span>Emailx</span><a class="colrhover" href="#">resturant@resturant.com</a></li>

                                <li><span>Timing</span>Mon-Thu (09:00 to 17:30)</li>

                            </ul>';

	}

	else {

		$name = $cs_node->getName();

			$cs_count_node++;

			$map_element_size = $cs_node->map_element_size;

			$map_title 	= $cs_node->map_title;

			$map_height = $cs_node->map_height;

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

			$map_conactus_content = $cs_node->map_conactus_content;

			$cs_counter 	= $post->ID.$cs_count_node;

}

?> 

	<div id="<?php echo $name.$cs_counter?>_del" class="column  parentdelete column_<?php echo $map_element_size?>" item="map" data="<?php echo element_size_data_array_index($map_element_size)?>" >

    	<div class="column-in">

            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>

            <input type="hidden" name="map_element_size[]" class="item" value="<?php echo $map_element_size?>" >

            <a href="javascript:hide_all('<?php echo $name.$cs_counter?>')" class="options">Options</a> &nbsp; 

            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  

            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 

            <a class="increment" onclick="javascript:increment(this)">Inc</a>

		</div>

       	<div class="poped-up" id="<?php echo $name.$cs_counter?>" style="border:none; background:#f8f8f8;" >

            <div class="opt-head">

                <h5>Edit Map Options</h5>

                <a href="javascript:show_all('<?php echo $name.$cs_counter?>')" class="closeit">&nbsp;</a>

            </div>

            <div class="opt-conts">

            	<ul class="form-elements">

                    <li class="to-label"><label>Title</label></li>

                    <li class="to-field"><input type="text" name="map_title[]" class="txtfield" value="<?php echo $map_title?>" /></li>

                </ul>

				<ul class="form-elements">

                    <li class="to-label"><label>Map Height</label></li>

                    <li class="to-field">

                    	<input type="text" name="map_height[]" class="txtfield" value="<?php echo $map_height?>" />

                        <p>Info Max Height in PX (Default is 200)</p>

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

                        <select name="map_view[]" class="dropdown"  onchange="map_contactus_element(this.value,<?php echo $cs_counter; ?>)">

                            <option <?php if($map_view=="content")echo "selected";?> value="content" >Boxed View</option>

                            <option <?php if($map_view=="header")echo "selected";?> value="header" >Full View</option>

                         </select>

                    </li>

                </ul>

                <ul class="form-elements noborder">

                    <li class="to-label"></li>

                    <li class="to-field">

                    	<input type="hidden" name="cs_orderby[]" value="map" />

                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$cs_counter?>')" />

                    </li>

                </ul>

            </div>



       </div>

    </div>

<?php

	if ( $die <> 1 ) die();

}

add_action('wp_ajax_cs_pb_map', 'cs_pb_map');

// accordion html form for page builder start
function cs_pb_accordion($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$accordion_element_size = '50';
		$accordion_title = '';
		$accordion_text = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$accordion_element_size = $cs_node->accordion_element_size;
			$accordion_title = $cs_node->accordion_title;
			$accordion_text = $cs_node->accordion_text;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $accordion_element_size?>" item="accordion" data="<?php echo element_size_data_array_index($accordion_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="accordion_element_size[]" class="item" value="<?php echo $accordion_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Accordion Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
				<div class="wrapptabbox">
                    <div class="clone_append">
                        <?php
						$accordion_num = 0;
                        if ( isset($cs_node) ){
							$accordion_num = count($cs_node->accordion);
                            foreach ( $cs_node->accordion as $val ){
								if ( $val->accordion_active == "yes" ) { $tab_active = "selected"; }
								else { $tab_active = ""; }
								echo "<div class='clone_form'>";
									echo "<a href='#' class='deleteit_node'>Delete it</a>";
									echo '<label>Tab Title:</label> <input class="txtfield" type="text" name="accordion_title[]" value="'.$val->accordion_title.'" />';
									echo '<label>Tab Text:</label> <textarea class="txtfield" name="accordion_text[]">'.$val->accordion_text.'</textarea>';
									echo '<label>Title Icon:</label> <input class="txtfield" type="text" name="accordion_title_icon[]" value="'.$val->accordion_title_icon.'" />';
									echo '<label>Active:</label> <select name="accordion_active[]"><option>no</option><option '.$tab_active.'>yes</option></select> ';
								echo "</div>";
                            }
                        }
                        ?>
                    </div>
                    <div class="opt-conts">
                        <ul class="form-elements">
                            <li class="to-label"><label></label></li>
                            <li class="to-field"><a href="#" class="add_accordion">Add Tab</a></li>
                        </ul>
                        <ul class="form-elements noborder">
                            <li class="to-label"></li>
                            <li class="to-field">
                                <input type="hidden" name="accordion_num[]" value="<?php echo $accordion_num?>" class="fieldCounter"  />
                                <input type="hidden" name="cs_orderby[]" value="accordions" />
                                <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                            </li>
                        </ul>
                    </div>
            	</div>
                            
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_accordion', 'cs_pb_accordion');
// accordion html form for page builder end

// tabs html form for page builder start
function cs_pb_tabs($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$tabs_element_size = '50';
		$tab_title = '';
		$tab_text = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$tabs_element_size = $cs_node->tabs_element_size;
			$tab_title = $cs_node->tab_title;
			$tab_text = $cs_node->tab_text;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $tabs_element_size?>" item="tabs" data="<?php echo element_size_data_array_index($tabs_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="tabs_element_size[]" class="item" value="<?php echo $tabs_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Tabs Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
				<div class="wrapptabbox">
                    <div class="clone_append">
                        <?php
						$tabs_num = 0;
                        if ( isset($cs_node) ){
							$tabs_num = count($cs_node->tab);
                            foreach ( $cs_node->tab as $tab ){
								if ( $tab->tab_active == "yes" ) { $tab_active = "selected"; }
								else { $tab_active = ""; }
								echo "<div class='clone_form'>";
									echo "<a href='#' class='deleteit_node'>Delete it</a>";
									echo '<label>Tab Title:</label> <input class="txtfield" type="text" name="tab_title[]" value="'.$tab->tab_title.'" />';
									echo '<label>Tab Text:</label> <textarea class="txtfield" name="tab_text[]">'.$tab->tab_text.'</textarea>';
									echo '<label>Title Icon:</label> <input class="txtfield" type="text" name="tab_title_icon[]" value="'.$tab->tab_title_icon.'" />';
									echo '<label>Active:</label> <select name="tab_active[]"><option>no</option><option '.$tab_active.'>yes</option></select> ';
								echo "</div>";
                            }
                        }
                        ?>
                    </div>
                    <div class="opt-conts">
                        <ul class="form-elements">
                            <li class="to-label"><label></label></li>
                            <li class="to-field"><a href="#" class="addedtab">Add Tab</a></li>
                        </ul>
                        <ul class="form-elements noborder">
                            <li class="to-label"></li>
                            <li class="to-field">
                                <input type="hidden" name="tabs_num[]" value="<?php echo $tabs_num?>" class="fieldCounter"  />
                                <input type="hidden" name="cs_orderby[]" value="tabs" />
                                <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                            </li>
                        </ul>
                    </div>
            	</div>
                            
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_tabs', 'cs_pb_tabs');
// tabs html form for page builder end
// quote html form for page builder start
function cs_pb_quote($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$quote_element_size = '25';
		$quote_text_color = '';
		$quote_align = '';
		$quote_content = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$quote_element_size = $cs_node->quote_element_size;
			$quote_text_color = $cs_node->quote_text_color;
			$quote_align = $cs_node->quote_align;
			$quote_content = $cs_node->quote_content;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $quote_element_size?>" item="quote" data="<?php echo element_size_data_array_index($quote_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="quote_element_size[]" class="item" value="<?php echo $quote_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Quote Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Text Color</label></li>
                    <li class="to-field">
                    	<input type="text" name="quote_text_color[]" class="txtfield" value="<?php echo $quote_text_color?>" />
                        <p>Enter the color code like #000000</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Align</label></li>
                    <li class="to-field">
                        <select name="quote_align[]" class="dropdown" >
                            <option <?php if($quote_align=="left")echo "selected";?> >left</option>
                            <option <?php if($quote_align=="right")echo "selected";?> >right</option>
                            <option <?php if($quote_align=="center")echo "selected";?> >center</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Quote Content</label></li>
                    <li class="to-field"><textarea name="quote_content[]"><?php echo $quote_content?></textarea></li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="quote" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_quote', 'cs_pb_quote');
// quote html form for page builder start

// google map html form for page builder end


// page bulider items end

// saving all the theme options start

function theme_option_save() {

	if ( isset($_POST['logo']) ) {

		$_POST = stripslashes_htmlspecialchars($_POST);

		if ( $_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['twitter_setting'])){

			update_option( "cs_theme_option", $_POST );

			echo "All Settings Saved";

 
		}else{

			update_option( "cs_theme_option", $_POST );

			echo "All Settings Saved";

			

		}

			//$_POST = array_map( 'htmlspecialchars' ,$_POST);

			//$a = array_map( 'stripslashes' ,$a);

			//$cs_theme_option = get_option('cs_theme_option');

				// upating config file start

					/*

					$fname = ABSPATH."wp-config.php";

					$fhandle = fopen($fname,"r");

					$content = fread($fhandle,filesize($fname));

					$content = str_replace("define('WPLANG', '".$cs_theme_option['lang_theme']."')", "define('WPLANG', '".$_POST['lang_theme']."')", $content);

					$fhandle = fopen($fname,"w");

					fwrite($fhandle,$content);

					fclose($fhandle);

					*/

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

add_action('wp_ajax_theme_option_save', 'theme_option_save');

// saving all the theme options end



// saving theme options import export start


function theme_option_import_export() {
 	if($_POST['theme_option_data'] and $_POST['theme_option_data'] <> ''){
		$a = unserialize(base64_decode(trim($_POST['theme_option_data'])));
		update_option( "cs_theme_option", $a );
		echo "OPtions Imported";
		die();
	}else{
		echo "Import failed<br>Textarea is empty.";
		die();
	}
}
add_action('wp_ajax_theme_option_import_export', 'theme_option_import_export');
// saving theme options import export end



// restoring default theme options start
function theme_option_restore_default() {

	update_option( "cs_theme_option", get_option('cs_theme_option_restore') );
	echo "Default Theme Options Restored";

	die();

}

add_action('wp_ajax_theme_option_restore_default', 'theme_option_restore_default');

// restoring default theme options end



// saving theme options backup start

function theme_option_backup() {

	update_option( "cs_theme_option_backup", get_option('cs_theme_option') );

	update_option( "cs_theme_option_backup_time", gmdate("Y-m-d H:i:s") );

	echo "Current Backup Taken @ " . gmdate("Y-m-d H:i:s");

	die();

}

add_action('wp_ajax_theme_option_backup', 'theme_option_backup');

// saving theme options backup end



// restore backup start

function theme_option_backup_restore() {

	update_option( "cs_theme_option", get_option('cs_theme_option_backup') );

	echo "Backup Restored";

	die();

}

add_action('wp_ajax_theme_option_backup_restore', 'theme_option_backup_restore');

// restore backup end





function add_social_icon(){

    $template_path = get_template_directory_uri() . '/scripts/admin/media_upload.js';

    wp_enqueue_script('my-upload2', $template_path, array('jquery', 'media-upload', 'thickbox', 'jquery-ui-droppable', 'jquery-ui-datepicker', 'jquery-ui-slider', 'wp-color-picker'));



	echo '<tr id="del_' .$_POST['counter_social_network'].'"> 

		<td><img width="50" src="' .$_POST['social_net_icon_path']. '"></td> 

		<td>' .$_POST['social_net_url']. '</td> 

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

				  <p>Put Awesome Font Code like "icon-flag".</p>

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



// to make a copy of media image for slider start

function cs_slider_clone(){

	global $cs_node, $cs_counter;

	if( isset($_POST['action']) ) {

		$cs_node = new stdClass();

		$cs_node->title = '';

		$cs_node->description = '';

		$cs_node->link = '';

		$cs_node->link_target = '';

		$cs_node->use_image_as = '';

		$cs_node->video_code = '';

	}

	if ( isset($_POST['counter']) ) $cs_counter = $_POST['counter'];

	if ( isset($_POST['path']) ) $cs_node->path = $_POST['path'];

?>

    <li class="ui-state-default" id="<?php echo $cs_counter?>">

        <div class="thumb-secs">

            <?php $image_path = wp_get_attachment_image_src( $cs_node->path, array( get_option("thumbnail_size_w"),get_option("thumbnail_size_h") ) );?>

            <img src="<?php echo $image_path[0]?>" alt="">

            <div class="gal-edit-opts">

                <!--<a href="#" class="resize"></a>-->

                <a href="javascript:slidedit(<?php echo $cs_counter?>)" class="edit"></a>

                <a href="javascript:del_this(<?php echo $cs_counter?>)" class="delete"></a>

            </div>

        </div>

        <div class="poped-up" id="edit_<?php echo $cs_counter?>">

            <div class="opt-head">

                <h5>Edit Options</h5>

                <a href="javascript:slideclose(<?php echo $cs_counter?>)" class="closeit">&nbsp;</a>

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

                        <input type="button" value="Submit" onclick="javascript:slideclose(<?php echo $cs_counter?>)" class="close-submit" />

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

	global $cs_node, $cs_counter;

	if( isset($_POST['action']) ) {

		$cs_node = new stdClass();

		$cs_node->title = "";

		$cs_node->use_image_as = "";

		$cs_node->video_code = "";

		$cs_node->link_url = "";

		$cs_node->use_image_as_db = "";

		$cs_node->link_url_db = '';

	}

	if ( isset($_POST['counter']) ) $cs_counter = $_POST['counter'];

	if ( isset($_POST['path']) ) $cs_node->path = $_POST['path'];

?>

    <li class="ui-state-default" id="<?php echo $cs_counter?>">

        <div class="thumb-secs">

            <?php $image_path = wp_get_attachment_image_src( $cs_node->path, array( get_option("thumbnail_size_w"),get_option("thumbnail_size_h") ) );?>

            <img src="<?php echo $image_path[0]?>" alt="">

            <div class="gal-edit-opts">

                <!--<a href="#" class="resize"></a>-->

                <a href="javascript:galedit(<?php echo $cs_counter?>)" class="edit"></a>

                <a href="javascript:del_this(<?php echo $cs_counter?>)" class="delete"></a>

            </div>

        </div>

        <div class="poped-up" id="edit_<?php echo $cs_counter?>">

            <div class="opt-head">

                <h5>Edit Options</h5>

                <a href="javascript:galclose(<?php echo $cs_counter?>)" class="closeit">&nbsp;</a>

            </div>

            <div class="opt-conts">

                <ul class="form-elements">

                    <li class="to-label"><label>Image Title</label></li>

                    <li class="to-field"><input type="text" name="title[]" value="<?php echo htmlspecialchars($cs_node->title)?>" class="txtfield" /></li>

                </ul>

                <ul class="form-elements">

                    <li class="to-label"><label>Use Image As</label></li>

                    <li class="to-field">

                        <select name="use_image_as[]" class="select_dropdown" onchange="cs_toggle_gal(this.value, <?php echo $cs_counter?>)">

                            <option <?php if($cs_node->use_image_as=="0")echo "selected";?> value="0">LightBox to current thumbnail</option>

                            <option <?php if($cs_node->use_image_as=="1")echo "selected";?> value="1">LightBox to Video</option>

                            <option <?php if($cs_node->use_image_as=="2")echo "selected";?> value="2">Link URL</option>

                        </select>

                        <p>Please select Image link where it will go.</p>

                    </li>

                </ul>

                <ul class="form-elements" id="video_code<?php echo $cs_counter?>" <?php if($cs_node->use_image_as=="0" or $cs_node->use_image_as=="" or $cs_node->use_image_as=="2")echo 'style="display:none"';?> >

                    <li class="to-label"><label>Video URL</label></li>

                    <li class="to-field">

                        <input type="text" name="video_code[]" value="<?php echo htmlspecialchars($cs_node->video_code)?>" class="txtfield" />

                        <p>(Enter Specific Video URL Youtube or Vimeo)</p>

                    </li>

                </ul>

                <ul class="form-elements" id="link_url<?php echo $cs_counter?>" <?php if($cs_node->use_image_as=="0" or $cs_node->use_image_as=="" or $cs_node->use_image_as=="1")echo 'style="display:none"';?> >

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

                        <input type="button" onclick="javascript:galclose(<?php echo $cs_counter?>)" value="Submit" class="close-submit" />

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


// add Team Scoial function
function cs_add_social_to_list(){
	global $counter_social, $var_cp_title, $var_cp_image_url , $var_cp_team_text;
	foreach ($_POST as $keys=>$values) {
		$$keys = $values;
	}
?>
    <tr id="edit_track<?php echo $counter_social?>">
        <td id="album-title<?php echo $counter_social?>" style="width:80%;"><?php echo $var_cp_title?></td>
        <td class="centr" style="width:20%;">
            <a href="javascript:openpopedup('edit_track_form<?php echo $counter_social?>')" class="actions edit">&nbsp;</a>
            <a onclick="javascript:return confirm('Are you sure! You want to delete this social icon')" href="javascript:cs_div_remove('edit_track<?php echo $counter_social?>')" class="actions delete">&nbsp;</a>
            <div class="poped-up" id="edit_track_form<?php echo $counter_social?>">
                <div class="opt-head">
                    <h5>Settings</h5>
                    <a href="javascript:closepopedup('edit_track_form<?php echo $counter_social?>')" class="closeit">&nbsp;</a>
                    <div class="clear"></div>
                </div>
                <ul class="form-elements">
                    <li class="to-label"><label>Title</label></li>
                    <li class="to-field">
                        <input type="text" name="var_cp_title[]" value="<?php echo htmlspecialchars($var_cp_title)?>" id="var_cp_title<?php echo $counter_social?>" />
                        
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>icon/image URL</label></li>
                    <li class="to-field">
                        <input id="var_cp_image_url<?php echo $counter_social?>" name="var_cp_image_url[]" value="<?php echo htmlspecialchars($var_cp_image_url)?>" type="text" class="small" />
                        <input id="var_cp_image_url<?php echo $counter_social?>" name="var_cp_image_url<?php echo $counter_track?>" type="button" class="uploadfile left" value="Browse"/>
                        <p>Put Fontawsome icon/image url. You can get fontawsome icons from <a href="http://fortawesome.github.io/Font-Awesome/icons/">here</a></p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Text</label></li>
                    <li class="to-field">
                   
                        <textarea name="var_cp_team_text[]" rows="5" cols="20"><?php echo htmlspecialchars($var_cp_team_text)?></textarea>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label></label></li>
                    <li class="to-field"><input type="button" value="Update Personal Information" onclick="update_title(<?php echo $counter_social?>); closepopedup('edit_track_form<?php echo $counter_social?>')" /></li>
                </ul>
            </div>
        </td>
    </tr>
<?php
	if ( isset($action) ) die();
}
add_action('wp_ajax_cs_add_social_to_list', 'cs_add_social_to_list');


// side bar layout in pages, post and default page(theme options) start

function subheader_meta_layout($default_theme_options_check = ''){
	global $cs_xmlObject, $post;

	$page_subheader_color = '';
	if ( empty($cs_xmlObject->header_banner_style) ) $header_banner_style = ""; else $header_banner_style = $cs_xmlObject->header_banner_style;
	
	if ( empty($cs_xmlObject->page_subheader_color) ) $page_subheader_color = "#0e1f33"; else $page_subheader_color = $cs_xmlObject->page_subheader_color;
	
	if ( empty($cs_xmlObject->header_banner_image) ) $header_banner_image = ""; else $header_banner_image = $cs_xmlObject->header_banner_image;
	
	if ( empty($cs_xmlObject->header_banner_flex_slider) ) $header_banner_flex_slider = ""; else $header_banner_flex_slider = $cs_xmlObject->header_banner_flex_slider;
	
	if ( empty($cs_xmlObject->custom_slider_id) ) $custom_slider_id = ""; else $custom_slider_id = htmlspecialchars($cs_xmlObject->custom_slider_id);
	
	if ( isset($cs_xmlObject->page_title) ){ $page_title = $cs_xmlObject->page_title;} else {$page_title = '';}
	
	if ( isset($cs_xmlObject->page_sub_title) ){ $page_sub_title = $cs_xmlObject->page_sub_title;} else {$page_sub_title = '';}
	?>
    
    <div class="clear"></div>

    	<div class="theme-help">

            <h4 style="padding-bottom:0px;">Subheader Options</h4>

            <div class="clear"></div>

        </div>
        <ul class="form-elements noborder">
            <li class="to-label"><label>Sub Header Style</label></li>
            <li class="to-field">
                <select name="header_banner_style" class="dropdown" onchange="javascript:home_slider_header_toggle(this.value)">
                	<option <?php if(isset($header_banner_style) and $header_banner_style=="default_header"){echo "selected";}?> value="default_header" >Default Header Style</option>
                	<option <?php if(isset($header_banner_style) and $header_banner_style=="breadcrumbs"){echo "selected";}?> value="breadcrumbs" >Breadcrumbs</option>
                    <option <?php if(isset($header_banner_style) and $header_banner_style=="no-header"){echo "selected";}?> value="no-header" >No Subheader</option>
                     <option <?php if(isset($header_banner_style) and $header_banner_style=="flex_slider"){echo "selected";}?> value="flex_slider" >Flex Slider</option>
                     <option <?php if(isset($header_banner_style) and $header_banner_style=="custom_slider"){echo "selected";}?> value="custom_slider" >Custom Slider</option>
                </select>
                <p>Default header Style settings <a href="<?php echo admin_url();?>/themes.php?page=cs_theme_options#tab-head-scripts-show" target="_blank">Here</a></p>
            </li>
        </ul>
        <div id="header_custom_image" style="display:<?php if($header_banner_style=="breadcrumbs" || $header_banner_style=="")echo 'inline"';else echo 'none';?>"  >
        <ul class="form-elements  noborder">
            <li class="to-label"><label>Sub-Header Background</label></li>
            <li class="to-field">
                <input id="header_banner_image" name="header_banner_image" value="<?php echo $header_banner_image?>" type="text" class="small" />
                <input id="header_banner_image" name="header_banner_image" type="button" class="uploadfile left" value="Browse"/>
                <p>Default background can be changed by uploading(image size 1600*900)</p>
            </li>
        </ul>
        <ul class="form-elements">
            <li class="to-label"><label>Page Sub Header Color</label></li>
            <li class="to-field">
                <input type="text" name="page_subheader_color"  class="bg_color" value="<?php echo $page_subheader_color ?>" />
            </li>
        </ul>
        <ul class="form-elements  noborder">
            <li class="to-label"><label>Page Sub Title</label></li>
            <li class="to-field">
                <input type="text" name="page_sub_title" value="<?php echo $page_sub_title ?>" />
            </li>
        </ul>
        </div>
        <div class="slider_options" id="ws_slider_options" style="display:<?php if($header_banner_style=="flex_slider")echo 'inline"';else echo 'none';?>" >
        	<ul class="form-elements noborder">
                <li class="to-label"><label>Select Slider</label></li>
                <li class="to-field">
                <select name="header_banner_flex_slider" class="dropdown">
					 <?php
                        $query = array( 'posts_per_page' => '-1', 'post_type' => 'cs_slider', 'orderby'=>'ID', 'post_status' => 'publish' );
                        $wp_query = new WP_Query($query);
                        while ($wp_query->have_posts()) : $wp_query->the_post();
                    ?>
                        <option <?php if($post->post_name==$header_banner_flex_slider)echo "selected";?> value="<?php echo $post->post_name; ?>"><?php the_title()?></option>
                    <?php
                        endwhile;
                    ?>
                </select>
                 <p>You can use already created slider OR create new slider <a href="<?php echo admin_url();?>/post-new.php?post_type=cs_slider" target="_blank">Click Here</a>.</p>
                </li>
             </ul>
        </div>
        <ul class="form-elements  noborder" id="header_custom_slider" style=" <?php if(isset($header_banner_style) and $header_banner_style <> "custom_slider")echo "display:none"; else "display:inline"; ?>" >
            <li class="to-label">
                <label>Custom Slider Short Code</label>
            </li>
            <li class="to-field">
                <input type="text" name="custom_slider_id" class="txtfield" value="<?php if(isset( $custom_slider_id))echo $custom_slider_id;?>" />
                <p>Please enter the short code for Layer Slider OR Revolution Slider if already included in package. Otherwise buy Sliders from <a href="http://codecanyon.net/" target="_blank">Codecanyon</a>. But its optional</p>
            </li>
        </ul>
        
<?php	
}


function meta_layout($default_theme_options_check = ''){

	global $cs_xmlObject, $post;

	if ( empty($cs_xmlObject->sidebar_layout->cs_layout) ) $cs_layout = ""; else $cs_layout = $cs_xmlObject->sidebar_layout->cs_layout;

	if ( empty($cs_xmlObject->sidebar_layout->cs_sidebar_left) ) $cs_sidebar_left = ""; else $cs_sidebar_left = $cs_xmlObject->sidebar_layout->cs_sidebar_left;

	if ( empty($cs_xmlObject->sidebar_layout->cs_sidebar_right) ) $cs_sidebar_right = ""; else $cs_sidebar_right = $cs_xmlObject->sidebar_layout->cs_sidebar_right;
	
	if ( empty($cs_xmlObject->header_banner_style) ) $header_banner_style = ""; else $header_banner_style = $cs_xmlObject->header_banner_style;
	
	if ( empty($cs_xmlObject->header_banner_image) ) $header_banner_image = ""; else $header_banner_image = $cs_xmlObject->header_banner_image;
	
	if ( empty($cs_xmlObject->header_banner_flex_slider) ) $header_banner_flex_slider = ""; else $header_banner_flex_slider = $cs_xmlObject->header_banner_flex_slider;
	
	if ( empty($cs_xmlObject->custom_slider_id) ) $custom_slider_id = ""; else $custom_slider_id = htmlspecialchars($cs_xmlObject->custom_slider_id);
	
	if ( isset($cs_xmlObject->page_title) ){ $page_title = $cs_xmlObject->page_title;} else {$page_title = '';}
	
	if ( isset($cs_xmlObject->page_sub_title) ){ $page_sub_title = $cs_xmlObject->page_sub_title;} else {$page_sub_title = '';}

  ?>
<div class="clear"></div>
	<div class="elementhidden">
		<div class="clear"></div>
		<div class="theme-help">

            <h4 style="padding-bottom:0px;">Post/Page Sidebar Settings</h4>

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

                    <div class='radio-image-wrapper'>

                        <input <?php if($cs_layout=="left")echo "checked"?> onclick="show_sidebar('left')" type="radio" name="cs_layout" class="radio" value="left" id="radio_3" />

                        <label for="radio_3">

                            <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/admin/3.gif" alt="" /></span>

                            <span <?php if($cs_layout=="left")echo "class='check-list'"?> id="check-list"><img src="<?php echo get_template_directory_uri()?>/images/admin/3-hover.gif" alt="" /></span>

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
				<p> Add New Sidebar. <a href="<?php echo admin_url();?>themes.php?page=cs_theme_options#tab-manage-sidebars-show" target="_blank">Click Here</a></p>
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
				<p> Add New Sidebar. <a href="<?php echo admin_url();?>themes.php?page=cs_theme_options#tab-manage-sidebars-show" target="_blank">Click Here</a></p>
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

	
//
	if (empty($_POST['page_title']))

        $_POST['page_title'] = "";

    if (empty($_POST['cs_layout']))

        $_POST['cs_layout'] = "";

    if (empty($_POST['cs_sidebar_left']))

        $_POST['cs_sidebar_left'] = "";

    if (empty($_POST['cs_sidebar_right']))

        $_POST['cs_sidebar_right'] = "";
	
	if (empty($_POST['header_banner_style'])){ $_POST['header_banner_style'] = "";}
	if (empty($_POST['page_subheader_color'])){ $_POST['page_subheader_color'] = "";}
	if (empty($_POST['header_banner_image'])){ $_POST['header_banner_image'] = "";}
	if (empty($_POST['header_banner_flex_slider'])){ $_POST['header_banner_flex_slider'] = "";}
	if (empty($_POST['custom_slider_id'])){ $_POST['custom_slider_id'] = "";}
		

		$sxe->addChild('page_title', $_POST['page_title']);
		$sxe->addChild('page_sub_title', $_POST['page_sub_title']);
		$sxe->addChild('page_subheader_color', $_POST['page_subheader_color']);
		
		$sxe->addChild('header_banner_style', $_POST["header_banner_style"]);
		
		$sxe->addChild('header_banner_image', $_POST["header_banner_image"]);
		
		$sxe->addChild('header_banner_flex_slider', $_POST["header_banner_flex_slider"]);
		
		$sxe->addChild('custom_slider_id', htmlspecialchars($_POST["custom_slider_id"]));

	
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

// import demo xml file

function cs_demo_importer(){
	?>
    <div class="cs-demo-data">
        <h2>Import Demo Data</h2>
        <div class="inn-text">
            <p>Importing demo data helps to build site like the demo site by all means. It is the quickest way to setup theme. Following things happen when dummy data is imported;</p>
            <ul class="import-data">
                <li>• All wordpress settings will remain same and intact.</li>
                <li>• Posts, pages and dummy images shown in demo will be imported.</li>
                <li>• Only dummy images will be imported as all demo images have copy right restriction.</li>
                <li>• No existing posts, pages, categories, custom post types or any other data will be deleted or modified.</li>
                <li>• To proceed, please click "Import Demo Data" and wait for a while.</li>
            </ul>
        </div>
        <form method="post">
            <input name="reset"  type="submit" value="Import Demo Data" id="submit_btn" />
            <input type="hidden" name="demo" value="demo-data" />
        </form>
       </div>
   <?php
	if(isset($_REQUEST['demo']) && $_REQUEST['demo']=='demo-data'){
		require_once ABSPATH . 'wp-admin/includes/import.php';
 		if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);
		$cs_demoimport_error = false;
		
		if ( !class_exists( 'WP_Importer' ) ) {
				$cs_import_class = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
				if ( file_exists( $cs_import_class ) ){
					require_once($cs_import_class);
				}
				else{
					$cs_demoimport_error = true;
				}
			}
		
		if ( !class_exists( 'WP_Import' ) ) {
			$cs_import_class = get_template_directory() . '/include/importer/wordpress-importer.php';
			if ( file_exists( $cs_import_class ) )
				require_once($cs_import_class);
			else
				$cs_demoimport_error = true;
		}
		
		if($cs_demoimport_error){
 			echo __( 'Error.', 'wordpress-importer' ) . '</p>';
			die();
		}else{
 			if(!is_file( get_template_directory() . '/include/importer/demo.xml')){
				echo '<p><strong>' . __( 'Sorry, there has been an error.', 'wordpress-importer' ) . '</strong><br />';
				echo __( 'The file does not exist, please try again.', 'wordpress-importer' ) . '</p>';
			}
			else{
				
				global $wpdb;
				$theme_mod_val = array();
				$term_exists = term_exists('main-menu', 'nav_menu');
				if ( !$term_exists ) {
					$wpdb->query(" INSERT INTO `" . $wpdb->prefix . "terms` VALUES ('', 'Main Menu' , 'main-menu', '0'); ");
					$insert_id = mysql_insert_id();
					$theme_mod_val['main-menu'] = $insert_id;
					$wpdb->query(" INSERT INTO `" . $wpdb->prefix . "term_taxonomy` VALUES ('', '".$insert_id."' , 'nav_menu', '', '0', '0'); ");
				}
				else $theme_mod_val['main-menu'] = $term_exists['term_id'];
				
				set_theme_mod( 'nav_menu_locations', $theme_mod_val );
				
				$home = get_page_by_title( 'Home' );
				if($home <> '' && get_option( 'page_on_front' ) == "0"){
					update_option( 'page_on_front', $home->ID );
					update_option( 'show_on_front', 'page' );
				}
				
				$cs_demo_import = new WP_Import();
				$cs_demo_import->fetch_attachments = true;
				$cs_demo_import->import( get_template_directory() . '/include/importer/demo.xml');
				
				// Menu Location
			
				
				
				
		  	}
		}
   }
}