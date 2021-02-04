<?php
/**
 * File Type: Events Page Builder Element
 */


//======================================================================
// events html form for page builder start
//======================================================================
if ( ! function_exists( 'cs_pb_events' ) ) {
	function cs_pb_events($die = 0){
		global $cs_node, $post;
		$shortcode_element = '';
		$filter_element = 'filterdrag';
		$shortcode_view = '';
		$output = array();
		$counter = $_POST['counter'];
		$cs_counter = $_POST['counter'];
		if ( isset($_POST['action']) && !isset($_POST['shortcode_element_id']) ) {
			$POSTID = '';
			$shortcode_element_id = '';
		} else {
			$POSTID = $_POST['POSTID'];
			$shortcode_element_id = $_POST['shortcode_element_id'];
			$shortcode_str = stripslashes ($shortcode_element_id);
			$PREFIX = 'cs_events';
			$parseObject 	= new ShortcodeParse();
			$output = $parseObject->cs_shortcodes( $output, $shortcode_str , true , $PREFIX );
		}
		$defaults = array('column_size' => '1/1','cs_events_section_title'=>'','cs_events_view'=>'','cs_events_cat'=>'','cs_events_orderby'=>'DESC','cs_events_listing_type'=>'','orderby'=>'ID','cs_events_excerpt'=>'255','cs_events_num_post'=>'10','cs_events_filterable'=>'','events_pagination'=>'','cs_evnts_post_time'=>'','cs_events_class' => '','cs_events_animation' => '');
			if(isset($output['0']['atts']))
				$atts = $output['0']['atts'];
			else 
				$atts = array();
			$events_element_size = '50';
			foreach($defaults as $key=>$values){
				if(isset($atts[$key]))
					$$key = $atts[$key];
				else 
					$$key =$values;
			 }
			$name = 'cs_pb_events';
			$coloumn_class = 'column_'.$events_element_size;
		if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){
			$shortcode_element = 'shortcode_element_class';
			$shortcode_view = 'cs-pbwp-shortcode';
			$filter_element = 'ajax-drag';
			$coloumn_class = '';
		}
	?>
    <div id="<?php echo esc_attr( $name.$cs_counter );?>_del" class="column  parentdelete <?php echo esc_attr( $coloumn_class );?> <?php echo esc_attr( $shortcode_view );?>" item="blog" data="<?php echo element_size_data_array_index($events_element_size)?>">
      <?php cs_element_setting($name,$cs_counter,$events_element_size);?>
      <div class="cs-wrapp-class-<?php echo intval( $cs_counter );?> <?php echo esc_attr( $shortcode_element );?>" id="<?php echo esc_attr( $name.$cs_counter );?>" data-shortcode-template="[cs_events {{attributes}}]"  style="display: none;">
        <div class="cs-heading-area">
          <h5>Edit Events Options</h5>
          <a href="javascript:removeoverlay('<?php echo esc_attr($name.$cs_counter)?>','<?php echo esc_attr($filter_element);?>')" class="cs-btnclose"><i class="fa fa-times"></i></a> </div>
        <div class="cs-pbwp-content">
          <div class="cs-wrapp-clone cs-shortcode-wrapp">
            <?php
             if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){cs_shortcode_element_size();}?>
            <ul class="form-elements">
                <li class="to-label"><label>Section Title</label></li>
                <li class="to-field">
                    <input  name="cs_events_section_title[]" type="text"  value="<?php echo esc_attr( $cs_events_section_title );?>"   />
                </li>                  
             </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Events Design Views</label>
              </li>
              <li class="to-field">
                <div class="input-sec">
                  <div class="select-style">
				    <select name="cs_events_view[]" class="dropdown">
                      <option value="events-listing" <?php if($cs_events_view == 'events-listing'){echo 'selected="selected"';}?>>Events Listing</option>
                      <option value="events-timeline" <?php if($cs_events_view == 'events-timeline'){echo 'selected="selected"';}?>>Events Timeline</option>
                      <option value="events-classic" <?php if($cs_events_view == 'events-classic'){echo 'selected="selected"';}?>>Events Classic</option>
                      <option value="events-minimal" <?php if($cs_events_view == 'events-minimal'){echo 'selected="selected"';}?>>Events  Minimal</option>
                    </select>
                  </div>
                </div>
                <div class="left-info">
                  <p>Please select category to show posts. If you dont select category it will display all posts.</p>
                </div>
              </li>
            </ul>
            <ul class="form-elements noborder">
              <li class="to-label">
                <label>Events Listing Types</label>
              </li>
              <li class="to-field">
                <div class="input-sec">
                  <div class="select-style">
                    <select class="dropdown" name="cs_events_listing_type[]">
                      <option value="all-events" <?php if($cs_events_listing_type == 'all-events'){echo 'selected="selected"';}?>>All Events</option>
                      <option value="upcoming-events" <?php if($cs_events_listing_type == 'upcoming-events'){echo 'selected="selected"';}?>>Upcoming Events</option>
                      <option value="past-events" <?php if($cs_events_listing_type == 'past-events'){echo 'selected="selected"';}?>>Past Events</option>
                    </select>
                  </div>
                </div>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Choose Category</label>
              </li>
              <li class="to-field">
                <div class="input-sec">
                  <div class="select-style">
                    <select name="cs_events_cat[]" class="dropdown">
                      <option value="0">-- Select Category --</option>
                      <?php show_all_cats('', '', $cs_events_cat, "event-category");?>
                    </select>
                  </div>
                </div>
                <div class="left-info">
                  <p>Please select category to show posts. If you dont select category it will display all posts.</p>
                </div>
              </li>
            </ul>
            <div id="Event-listing<?php echo intval( $cs_counter );?>" >
              <ul class="form-elements">
                <li class="to-label">
                  <label>Post Order</label>
                </li>
                <li class="to-field">
                  <div class="input-sec">
                    <div class="select-style">
                      <select name="cs_events_orderby[]" class="dropdown" >
                        <option <?php if($cs_events_orderby=="ASC")echo "selected";?> value="ASC">ASC</option>
                        <option <?php if($cs_events_orderby=="DESC")echo "selected";?> value="DESC">DESC</option>
                      </select>
                    </div>
                  </div>
                </li>
              </ul>
              <ul class="form-elements noborder">
              <li class="to-label">
                <label> Show Time</label>
              </li>
              <li class="to-field">
                <div class="input-sec">
                  <div class="select-style">
                    <select class="dropdown" name="cs_evnts_post_time[]">
                      <option <?php if($cs_evnts_post_time=="Yes")echo "selected";?> value="Yes">Yes</option>
                      <option value="No" <?php if($cs_evnts_post_time=="No")echo "selected";?>> No</option>
                    </select>
                  </div>
                </div>
              </li>
            </ul>
              <ul class="form-elements">
                <li class="to-label">
                  <label>Length of Excerpt</label>
                </li>
                <li class="to-field">
                  <div class="input-sec">
                    <input type="text" name="cs_events_excerpt[]" class="txtfield" value="<?php echo esc_attr($cs_events_excerpt);?>" />
                  </div>
                  <div class="left-info">
                    <p>Enter number of character for short description text.</p>
                  </div>
                </li>
              </ul>
            </div>
            <ul class="form-elements">
              <li class="to-label">
                <label>No. of Post Per Page</label>
              </li>
              <li class="to-field">
                <div class="input-sec">
                  <input type="text" name="cs_events_num_post[]" class="txtfield" value="<?php echo esc_attr( $cs_events_num_post ); ?>" />
                </div>
                <div class="left-info">
                  <p>To display all the records, leave this field blank.</p>
                </div>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Filterable</label>
              </li>
              <li class="to-field select-style">
                <select name="cs_events_filterable[]" class="dropdown">
                  <option <?php if($cs_events_filterable=="Yes")echo "selected";?> value="Yes">Yes</option>
                  <option <?php if($cs_events_filterable=="No")echo "selected";?> value="No" >No</option>
                </select>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Pagination</label>
              </li>
              <li class="to-field select-style">
                <select name="events_pagination[]" class="dropdown">
                  <option <?php if($events_pagination=="Show Pagination")echo "selected";?> >Show Pagination</option>
                  <option <?php if($events_pagination=="Single Page")echo "selected";?> >Single Page</option>
                </select>
              </li>
            </ul>
            
            <?php 
                if ( function_exists( 'cs_shortcode_custom_classes' ) ) {
                    cs_shortcode_custom_dynamic_classes($cs_events_class,$cs_events_animation,'','cs_events');
                }
            ?>
            <?php if(isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode'){?>
            <ul class="form-elements insert-bg">
              <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:Shortcode_tab_insert_editor('<?php echo esc_js( str_replace( 'cs_pb_','',$name ) );?>','<?php echo esc_js( $name.$cs_counter );?>','<?php echo esc_js( $filter_element );?>')" >Insert</a> </li>
            </ul>
            <div id="results-shortocde"></div>
            <?php } else {?>
            <ul class="form-elements">
              <li class="to-label"></li>
              <li class="to-field">
                <input type="hidden" name="cs_orderby[]" value="events" />
                <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:_removerlay(jQuery(this))" />
              </li>
            </ul>
            <?php }?>
          </div>
        </div>
      </div>
    </div>
<?php
		if ( $die <> 1 ) die();
	}
	add_action('wp_ajax_cs_pb_events', 'cs_pb_events');
}