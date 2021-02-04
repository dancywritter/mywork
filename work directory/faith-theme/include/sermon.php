<?php
	//adding columns start
    add_filter('manage_sermon_posts_columns', 'sermon_columns_add');
		function sermon_columns_add($columns) {
			$columns['category'] = 'Category';
			$columns['tag'] = 'Tags';
			$columns['author'] = 'Author';
			return $columns;
    }
    add_action('manage_sermon_posts_custom_column', 'sermon_columns');
		function sermon_columns($name) {
			global $post;
			switch ($name) {
				case 'category':
					$categories = get_the_terms( $post->ID, 'sermon-category' );
						if($categories <> ""){
							$couter_comma = 0;
							foreach ( $categories as $category ) {
								echo $category->name;
								$couter_comma++;
								if ( $couter_comma < count($categories) ) {
									echo ", ";
								}
							}
						}
					break;
				case 'tag':
					$categories = get_the_terms( $post->ID, 'sermon-tag' );
						if($categories <> ""){
							$couter_comma = 0;
							foreach ( $categories as $category ) {
								echo $category->name;
								$couter_comma++;
								if ( $couter_comma < count($categories) ) {
									echo ", ";
								}
							}
						}
					break;
				case 'author':
					echo get_the_author();
					break;
			}
		}
	//adding columns end

	function register_post_type_sermon(){
		$post_type_name = 'Sermon';
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
				'has_archive' => true,
				'menu_icon' => get_stylesheet_directory_uri() . '/images/admin/sermon-icon.png',
				'supports' => array('title','editor','thumbnail', 'comments')
			); 
			register_post_type( 'sermon' , $args );
		// adding post type end
	}
	add_action('init', 'register_post_type_sermon');

		// adding category start
		  $labels = array(
			'name' => 'Sermon Categories',
			'search_items' => 'Search Sermon Categories',
			'edit_item' => 'Edit Sermon Category',
			'update_item' => 'Update Sermon Category',
			'add_new_item' => 'Add New Category',
			'menu_name' => 'Sermon Categories',
		  );
		  register_taxonomy('sermon-category',array('sermon'), array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'sermon-category' ),
		  ));
		// adding category end
		// adding tag start
			$labels = array(
				'name' => 'Sermon Tags',
				'search_items' =>  'Search Sermon Tags',
				'edit_item' => 'Edit Sermon Tag', 
				'update_item' => 'Update Sermon Tag',
				'add_new_item' => 'Add Sermon Tag',
				'menu_name' => 'Sermon Tags'
			); 	
			register_taxonomy('sermon-tag',array('sermon'), array(
				'hierarchical' => false,
				'labels' => $labels,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array( 'slug' => 'sermon-tag' ),
			));
		// adding tag end

	// meta box start
	function meta_box_sermon($post){
	$sermon_xml = get_post_meta($post->ID, "cs_sermon", true);
	global $cs_xmlObject;
	if ( $sermon_xml <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($sermon_xml);
			$sermon_social_sharing = $cs_xmlObject->sermon_social_sharing;
			$sermon_audio_url = $cs_xmlObject->sermon_audio_url;
			$sermon_download_url = $cs_xmlObject->sermon_download_url;
			$sermon_script_url = $cs_xmlObject->sermon_script_url;
			$sermon_buy_url = $cs_xmlObject->sermon_buy_url;
			$sermon_price_amount = $cs_xmlObject->sermon_price_amount;
			$sermon_author_description = $cs_xmlObject->sermon_author_description;
	}
	else {
		$sermon_social_sharing = '';
		$sermon_audio_url = '';
		$sermon_download_url = '';
		$sermon_script_url = '';
		$sermon_buy_url = '';
		$sermon_price_amount = '';
		$sermon_author_description = '';
	}
?>
	<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/prettyCheckable.js"></script>
	<div class="page-wrap">
        <div class="option-sec row">
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Social Sharing</label></li>
                    <li class="to-field">
                        <input type="checkbox" name="sermon_social_sharing" value="on" class="myClass" <?php if($sermon_social_sharing=='on')echo "checked"?> />
                        <p>Make Social Sharing On/Off</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Audio URL</label></li>
                    <li class="to-field">
                        <div class="on-off"><input type="text" name="sermon_audio_url" value="<?php echo $sermon_audio_url?>" /></div>
                        <p>Put the audio URL</p>
                    </li>
                </ul>
                
                <ul class="form-elements">
                    <li class="to-label"><label>Download URL</label></li>
                    <li class="to-field">
                        <div class="on-off"><input type="text" name="sermon_download_url" value="<?php echo $sermon_download_url?>" /></div>
                        <p>Put the download URL</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Script URL</label></li>
                    <li class="to-field">
                        <div class="on-off"><input type="text" name="sermon_script_url" value="<?php echo $sermon_script_url?>" /></div>
                        <p>Put the pdf URL</p>
                    </li>
                </ul>
                
                <ul class="form-elements">
                    <li class="to-label"><label>Sermon Price</label></li>
                    <li class="to-field">
                        <div class="on-off"><input type="text" name="sermon_price_amount" value="<?php echo $sermon_price_amount?>" /></div>
                        <p>Put Sermon Price i.e. $24</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Buy URL</label></li>
                    <li class="to-field">
                        <div class="on-off"><input type="text" name="sermon_buy_url" value="<?php echo $sermon_buy_url?>" /></div>
                        <p>Put the Sermon Buy URL</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Author Description</label></li>
                    <li class="to-field">
                        <input type="checkbox" name="sermon_author_description" value="on" class="myClass" <?php if($sermon_author_description=='on')echo "checked"?> />
                        <p>Make Author Description On/Off</p>
                    </li>
                </ul>
			</div>
		</div>
		<div class="clear"></div>
		<?php meta_layout()?>
        <input type="hidden" name="sermon_meta_form" value="1" />
    </div>
<?php
}
    function add_meta_box_sermon(){
        add_meta_box( 'sermon_meta', 'Sermon Options', 'meta_box_sermon', 'sermon', 'normal', 'high' );
    }
	add_action( 'add_meta_boxes', 'add_meta_box_sermon' );
	// meta box end

	// meta box saving start
		if ( isset($_POST['sermon_meta_form']) and $_POST['sermon_meta_form'] == 1 ) {
			add_action( 'save_post', 'cs_meta_post_save' );
			function cs_meta_post_save( $post_id ) {
				if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
					if ( empty($_POST['sermon_audio_url']) ) $_POST['sermon_audio_url'] = "";
					if ( empty($_POST['sermon_download_url']) ) $_POST['sermon_download_url'] = "";
					if ( empty($_POST['sermon_script_url']) ) $_POST['sermon_script_url'] = "";
					if ( empty($_POST['sermon_social_sharing']) ) $_POST['sermon_social_sharing'] = "";
					if ( empty($_POST['sermon_buy_url']) ) $_POST['sermon_buy_url'] = "";
					if ( empty($_POST['sermon_price_amount']) ) $_POST['sermon_price_amount'] = "";
					if ( empty($_POST['sermon_author_description']) ) $_POST['sermon_author_description'] = "";
						$sxe = new SimpleXMLElement("<cs_meta_sermon></cs_meta_sermon>");
							$sxe->addChild('sermon_audio_url', $_POST['sermon_audio_url'] );
							$sxe->addChild('sermon_download_url', $_POST['sermon_download_url'] );
							$sxe->addChild('sermon_script_url', $_POST['sermon_script_url'] );
							$sxe->addChild('sermon_social_sharing', $_POST['sermon_social_sharing'] );
							$sxe->addChild('sermon_buy_url', $_POST['sermon_buy_url'] );
							$sxe->addChild('sermon_price_amount', $_POST['sermon_price_amount'] );
							$sxe->addChild('sermon_author_description', $_POST['sermon_author_description'] );
							$sxe = save_layout_xml($sxe);
				update_post_meta( $post_id, 'cs_sermon', $sxe->asXML() );
			}
		}
	
	// meta box saving end

?>