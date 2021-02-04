<?php
	function register_post_type_prayer(){
		$post_type_name = 'Prayer';
		// adding post type start
			$labels = array(
				'name' => 'Prayer',
				'add_new_item' => 'Add New '.$post_type_name,
				'edit_item' => 'Edit '.$post_type_name,
				'new_item' => 'New '.$post_type_name.' Item',
				'add_new' => 'Add New '.$post_type_name,
				'view_item' => 'View '.$post_type_name.' Item',
				'search_items' => 'Search '.$post_type_name,
				'not_found' =>  'No '.$post_type_name.' Found',
				'not_found_in_trash' => 'No '.$post_type_name.' Found in Trash'
			);
			$args = array(
				'labels' => $labels,
				'public' => true,
				'has_archive' => true,
				'menu_icon' => get_stylesheet_directory_uri() . '/images/admin/prayer-icon.png',
				'supports' => array('title','editor')
			); 
			register_post_type( 'prayers' , $args );
		// adding post type end
	}
	add_action('init', 'register_post_type_prayer');

	// meta box start
	function meta_box_prayer(){
		global $post_id;
		$cs_prayer = get_post_meta($post_id, 'cs_prayer', true);
		?>
		<div class="page-wrap">
            <div class="option-sec" style="margin-bottom:0;">
                <div class="opt-conts">
                    <ul class="form-elements noborder">
                        <li class="to-label"><label>Email</label></li>
                        <li class="to-field">
                        	<input type="text" name="email" value="<?php if ( isset($cs_prayer['email']) ) echo $cs_prayer['email'] ?>" />
                            <p>Put Email Address</p>
                        </li>
                    </ul>
                    <ul class="form-elements noborder">
                        <li class="to-label"><label>Address</label></li>
                        <li class="to-field">
                        	<input type="text" name="address" value="<?php if ( isset($cs_prayer['address']) ) echo $cs_prayer['address'] ?>" />
                            <p>Put your complete address</p>
                        </li>
                    </ul>
                </div>
            </div>
            <input type="hidden" name="prayer_meta_form" value="1" />
			<div class="clear"></div>
		</div>
	    <?php
	}
    function add_meta_box_prayer(){
        add_meta_box( 'event_meta', 'Prayer Options', 'meta_box_prayer', 'prayers', 'normal', 'high' );
    }
	add_action( 'add_meta_boxes', 'add_meta_box_prayer' );  
	// meta box end

	// meta box saving start
		if ( isset($_POST['prayer_meta_form']) and $_POST['prayer_meta_form'] == 1 ) {
			function meta_save_prayer($post_id){
				update_post_meta( $post_id, 'cs_prayer', array( 'email' => $_POST['email'], 'address' => $_POST['address'] ) );
			}		
			add_action( 'save_post', 'meta_save_prayer' );
		}
	
	// meta box saving end

?>