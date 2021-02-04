<?php
	function register_post_type_team(){
		$post_type_name = 'Team';
		// adding post type start
			$labels = array(
				'name' => $post_type_name,
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
				'menu_icon' => 'dashicons-groups',
				'supports' => array('title','editor','thumbnail', 'comments')
			); 
			register_post_type( 'team' , $args );
		// adding post type end
	}
	add_action('init', 'register_post_type_team');

	// meta box start
	function meta_box_team(){
		global $post_id;
		$px_team = get_post_meta($post_id, 'px_team', true);
		?>
        <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/select.js"></script>
		<div class="page-wrap">
            <div class="option-sec" style="margin-bottom:0;">
                <div class="opt-conts">
                    <ul class="form-elements ">
                        <li class="to-field">
                        	<input type="text" name="designation" value="<?php if ( isset($px_team['designation']) ) echo $px_team['designation'] ?>" />
                            <p>Designation</p>
                        </li>
                    </ul>
                    <div class="opt-head">
                      <h4>Social Network</h4>
                      <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                    <ul class="form-elements">
                        <li class="to-field">
                        	<input type="text" name="facebook" value="<?php if ( isset($px_team['facebook']) ) echo $px_team['facebook'] ?>" />
                            <p>Facebook URL</p>
                        </li>
                    </ul>
                    <ul class="form-elements noborder">
                        <li class="to-field">
                        	<input type="text" name="twitter" value="<?php if ( isset($px_team['twitter']) ) echo $px_team['twitter'] ?>" />
                            <p>Twitter URL</p>
                        </li>
                    </ul>
                    <ul class="form-elements noborder">
                        <li class="to-field">
                        	<input type="text" name="google_plus" value="<?php if ( isset($px_team['google_plus']) ) echo $px_team['google_plus'] ?>" />
                            <p>Google Plus URL</p>
                        </li>
                    </ul>
                    <ul class="form-elements noborder">
                        <li class="to-field">
                        	<input type="text" name="linkedin" value="<?php if ( isset($px_team['linkedin']) ) echo $px_team['linkedin'] ?>" />
                            <p>linkedin URL</p>
                        </li>
                    </ul>
                    
                    
                </div>
            </div>
            <input type="hidden" name="team_meta_form" value="1" />
			<div class="clear"></div>
		</div>
	    <?php
	}
    function add_meta_box_team(){
        add_meta_box( 'event_meta', 'Team Options', 'meta_box_team', 'team', 'normal', 'high' );
    }
	add_action( 'add_meta_boxes', 'add_meta_box_team' );
	// meta box end

	// meta box saving start
		if ( isset($_POST['team_meta_form']) and $_POST['team_meta_form'] == 1 ) {
			function meta_save_team($post_id){
				$meta_values = array(
								'designation' => $_POST['designation'],
								'facebook' => $_POST['facebook'],
								'twitter' => $_POST['twitter'],
								'linkedin' => $_POST['linkedin'],
								'google_plus' => $_POST['google_plus'],
								);
				update_post_meta( $post_id, 'px_team', $meta_values );
			}		
			add_action( 'save_post', 'meta_save_team' );
		}
	
	// meta box saving end

?>