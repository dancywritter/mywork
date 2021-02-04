<?php
	//adding columns start
    add_filter('manage_artists_posts_columns', 'artists_columns_add' );
		function artists_columns_add($columns) {
			$columns['category'] = 'Categories';
			$columns['author'] = 'Author';
			return $columns;
	    }
    add_action('manage_artists_posts_custom_column', 'artists_columns');
		function artists_columns($name) {
			global $post;
			switch ($name) {
				case 'category':
					$categories = get_the_terms( $post->ID, 'artists-category' );
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
	function register_post_type_artist(){
		$post_type_name = 'Artist';
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
				'menu_icon' => get_stylesheet_directory_uri() . '/images/admin/artist-icon.png',
				'supports' => array('title','editor','thumbnail', 'excerpt', 'comments')
			); 
			register_post_type( 'artists' , $args );
		// adding post type end
				$args = array(
					'labels' => $labels,
					'public' => true,
					'publicly_queryable' => true,
					'show_ui' => true,
					'query_var' => true,
					'menu_icon' => get_stylesheet_directory_uri() . '/images/calendar.png',
					'show_in_menu' => 'edit.php?post_type=artists',
					'show_in_nav_menus'=>true,
					'rewrite' => true,
					'capability_type' => 'post',
					'hierarchical' => false,
					'menu_position' => null,
					'supports' => array('title')
				); 

	}
	add_action('init', 'register_post_type_artist');
	function cs_artist_categories() 
	{
		  $labels = array(
			'name' => 'Artist Categories',
			'search_items' => 'Search Artist Categories',
			'edit_item' => 'Edit Artist Category',
			'update_item' => 'Update Artist Category',
			'add_new_item' => 'Add New Category',
			'menu_name' => 'Artist Categories',
		  ); 	
		  register_taxonomy('artists-category',array('artists'), array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'artists-category' ),
		  ));
	}
	add_action( 'init', 'cs_artist_categories');
	 
	
	// artist custom fields start
	add_action( 'add_meta_boxes', 'cs_artists_meta' );  
    function cs_artists_meta()
    {
        add_meta_box( 'artists_meta', 'Artists Options', 'cs_artist_meta_data', 'artists', 'normal', 'high' );
    }
	function cs_artist_meta_data($post) {
		$cs_artist_meta = get_post_meta($post->ID, "cs_artist_meta", true);
		global $cs_xmlObject;
		$inside_artist_artists = array();
		if ( $cs_artist_meta <> "" ) {
			$cs_xmlObject = new SimpleXMLElement($cs_artist_meta);
				if (empty($_POST["artist_live_url"])){ $_POST["artist_live_url"] = "";}
				$inside_artist_gallery = $cs_xmlObject->inside_artist_gallery;
				$cs_images_per_gallery = $cs_xmlObject->cs_images_per_gallery;
				$artist_social_sharing = $cs_xmlObject->artist_social_sharing;
				$artist_related = $cs_xmlObject->artist_related;
				$artist_start_date = $cs_xmlObject->artist_start_date;
				$artist_live_url = $cs_xmlObject->artist_live_url;
				$artist_address = $cs_xmlObject->artist_address;
				$inside_artist_twitter_title = $cs_xmlObject->inside_artist_twitter_title;
				$artist_twitter_no_tweets = $cs_xmlObject->artist_twitter_no_tweets;
				$artist_twitter_url = $cs_xmlObject->artist_twitter_url;
				$cs_artist_albums = $cs_xmlObject->cs_artist_albums;
				if(isset($cs_xmlObject->cs_artist_albums) && $cs_xmlObject->cs_artist_albums <> ''){
					$cs_artist_albums = $cs_xmlObject->cs_artist_albums;
					if ($cs_artist_albums)
					{
						$cs_artist_albums = explode(",", $cs_artist_albums);
	
					}
				} else {
					$cs_artist_albums = array();
				}
		}
		else {
			$artist_rating = '';
			$inside_artist_artists = '';
			$artist_social_sharing = '';
			$artist_related = '';
			$artist_twitter_no_tweets = '';
			$inside_artist_twitter_title = '';
			$artist_live_url = '';
			$artist_address = '';
			$artist_start_date = '';
			$inside_artist_gallery = '';
			$cs_images_per_gallery = '';
			$artist_twitter_url = '';
			$cs_artist_albums =  array();
 		}
	?>
		<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/select.js"></script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/prettyCheckable.js"></script>
		<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery.timepicker.js"></script>
        <link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/admin/jquery.ui.datepicker.css">
        <link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/admin/jquery.ui.datepicker.theme.css">
        <script>
            jQuery(function($) {
                $( "#from_date" ).datepicker({
                    defaultDate: "+1w",
					dateFormat: "yy-mm-dd",
                    changeMonth: true,
                    numberOfMonths: 1,
                    onSelect: function( selectedDate ) {
                        $( "#to_date" ).datepicker( "option", "minDate", selectedDate );
                    }
                });
            });
        </script>

    	<div class="page-wrap">
            <div class="option-sec" style="margin-bottom:0;">
                <div class="opt-conts">
                    <ul class="form-elements">
                        <li class="to-label"><label>Social Sharing</label></li>
                        <li class="to-field">
                        	<div class="on-off"><input type="checkbox" name="artist_social_sharing" value="on" class="myClass" <?php if($artist_social_sharing=='on')echo "checked"?> /></div>
                            <p>Enable/Disbale social sharing</p>
                        </li>
                    </ul>
                    <ul class="form-elements noborder">
                        <li class="to-label"><label>Location / Address</label></li>
                        <li class="to-field">
							<input type="text" id="artist_address" name="artist_address" value="<?php echo $artist_address?>" />
                            <p>Put artist address / lcoation</p>
                        </li>
                    </ul>
                </div>
                <div class="option-sec row" style="margin-bottom:0;">

            <div class="opt-conts">
            <ul class="form-elements">
                <li class="to-label"><label>Artist Start Date</label></li>
                <li class="to-field">
                    <input type="text" id="from_date" name="artist_start_date" value="<?php if($artist_start_date=='') echo gmdate("Y-m-d"); else echo $artist_start_date?>" />
                    <p>Put artist start date</p>
                </li>
            </ul>
            <ul class="form-elements">
                <li class="to-label"><label>Select Albums</label></li>
                    <li class="to-field1" style=" height:auto; width:72%;">
                        <select name="cs_artist_albums[]" multiple="multiple" style="height:auto;width:72%;">
                            <option value="0">-- Select Albums --</option>
                            <?php
                                $query = array( 'posts_per_page' => '-1', 'post_type' => 'albums', 'orderby'=>'ID', 'post_status' => 'publish' );
                                $wp_query = new WP_Query($query);
                                while ($wp_query->have_posts()) : $wp_query->the_post();
                            ?>
                                <option value="<?php the_ID()?>" <?php if (in_array(get_the_ID(), $cs_artist_albums)) { echo 'selected="selected"';}?>><?php the_title()?></option>
                            <?php
                                endwhile;
                            ?>
                        </select>
                        <p>Press ctrl to add multiple albums</p>
                    </li>
            </ul>
            <ul class="form-elements">
           		<li class="to-label"><label>Select Gallery</label></li>
                <li class="to-field">
                    <select name="inside_artist_gallery" class="dropdown">
                        <option value="0">-- Select Gallery --</option>
                        <?php	
                            $query = array( 'posts_per_page' => '-1', 'post_type' => 'cs_gallery', 'orderby'=>'ID', 'post_status' => 'publish' );
                            $wp_query = new WP_Query($query);
                            while ($wp_query->have_posts()) : $wp_query->the_post();
                        ?>
                            <option <?php if(get_the_ID()==$inside_artist_gallery)echo "selected";?> value="<?php the_ID()?>"><?php the_title()?></option>
                        <?php
                            endwhile;
                        ?>
                    </select>
                </li>
             </ul>
             <ul class="form-elements" id="cs_images_per_gallery">
                <li class="to-label">
                    <label>No. of Images </label>
                </li>
                <li class="to-field">
                    <input type="text" id="cs_images_per_gallery" name="cs_images_per_gallery" value="<?php echo $cs_images_per_gallery;?>" />
                     <p>Leave empty field mean show all images.</p>
                    </li>
         
            </ul>
           	<ul class="form-elements">
                    <li class="to-label">
                        <label>Live URL </label>
                    </li>
                    <li class="to-field">
                        <input type="text" name="artist_live_url" value="<?php if($artist_live_url <> ''){echo htmlspecialchars($artist_live_url); }?>" />
                    </li>
                    
                </ul>

            </div>
            <div class="clear"></div>
        </div>
            </div>
            <input type="hidden" name="artists_meta_form" value="1" />
			<div class="clear"></div>
		</div>
    <?php
	}
	// meta box saving start
		if ( isset($_POST['artists_meta_form']) and $_POST['artists_meta_form'] == 1 ) {
			add_action( 'save_post', 'cs_meta_post_save' );
					function cs_meta_post_save( $post_id ) {
						if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
						global $wpdb;
						if (empty($_POST["artist_social_sharing"])){ $_POST["artist_social_sharing"] = "";}
						if (empty($_POST["inside_artist_gallery"])){ $_POST["inside_artist_gallery"] = "";}
						if (empty($_POST["cs_images_per_gallery"])){ $_POST["cs_images_per_gallery"] = "";}						
						if (empty($_POST["artist_live_url"])){ $_POST["artist_live_url"] = "";}
						if (empty($_POST["artist_address"])){ $_POST["artist_address"] = "";}
						if (empty($_POST["artist_start_date"])){ $_POST["artist_start_date"] = "";}
						if (empty($_POST["cs_artist_albums"])){ $cs_artist_albums = "";} else {
							$cs_artist_albums = implode(",", $_POST["cs_artist_albums"]);
						 }
						if (empty($_POST["cs_artist_albums"])){ $_POST["cs_artist_albums"] = "";}
						$sxe = new SimpleXMLElement("<artist></artist>");
							$sxe->addChild('artist_social_sharing', $_POST["artist_social_sharing"]);
							$sxe->addChild('inside_artist_gallery', $_POST["inside_artist_gallery"]);
							$sxe->addChild('cs_images_per_gallery', $_POST["cs_images_per_gallery"]);
 							$sxe->addChild('artist_live_url', $_POST["artist_live_url"]);
							$sxe->addChild('artist_start_date', $_POST["artist_start_date"]);
							$sxe->addChild('artist_address', $_POST["artist_address"]);
							$sxe->addChild('cs_artist_albums', $cs_artist_albums);
						update_post_meta($post_id, 'cs_artist_meta', $sxe->asXML());
								}
		}
	
	// meta box saving end
?>