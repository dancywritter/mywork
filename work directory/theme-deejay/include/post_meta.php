<?php
add_action( 'add_meta_boxes', 'px_meta_post_add' );
function px_meta_post_add()
{  
	add_meta_box( 'px_meta_post', 'Post Options', 'px_meta_post', 'post', 'normal', 'high' );  
}
function px_meta_post( $post ) {
	$post_xml = get_post_meta($post->ID, "post", true);
	global $px_xmlObject;
	if ( $post_xml <> "" ) {
		$px_xmlObject = new SimpleXMLElement($post_xml);
			$sub_title = $px_xmlObject->sub_title;
			$var_pb_post_author = $px_xmlObject->var_pb_post_author;
 			$var_pb_post_social_sharing = $px_xmlObject->var_pb_post_social_sharing;
	}
	else {
		$sub_title = '';
 		$var_pb_post_social_sharing = '';
		$var_pb_post_author = 'on';
	}
?>
	<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/select.js"></script>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/admin/bootstrap.min.css">
    <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/bootstrap-3.0.js"></script>
	<div class="page-wrap event-meta-section">
        <div class="option-sec row">
            <div class="opt-conts">
            	
  				
                <ul class="form-elements  on-off-options">
                    <li class="to-label"><label>Social Sharing</label></li>
                    <li class="to-field">
                        <label class="cs-on-off">
                            <input type="checkbox" name="var_pb_post_social_sharing" value="on" class="myClass" <?php if($var_pb_post_social_sharing == 'on') echo "checked"?> />
                            <span></span>
                        </label>    
                    </li>

                    <li class="to-label"><label>Author Description</label></li>
                    <li class="to-field">
                        <label class="cs-on-off">
                            <input type="checkbox" name="var_pb_post_author" value="on" class="myClass" <?php if($var_pb_post_author=='on')echo "checked"?> />
                            <span></span>
                        </label>
                    </li>
                </ul>
                <?php meta_layout()?>
			</div>
		</div>
		<div class="clear"></div>
		
        <input type="hidden" name="post_meta_form" value="1" />
    </div>
<?php
}
		if ( isset($_POST['post_meta_form']) and $_POST['post_meta_form'] == 1 ) {
			add_action( 'save_post', 'px_meta_post_save' );
			function px_meta_post_save( $post_id ) {
				if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
					if (empty($_POST["var_pb_post_author"])){ $_POST["var_pb_post_author"] = "";}
 					if (empty($_POST["var_pb_post_social_sharing"])){ $_POST["var_pb_post_social_sharing"] = "";}
						$sxe = new SimpleXMLElement("<px_meta_post></px_meta_post>");
							$sxe->addChild('var_pb_post_author', $_POST['var_pb_post_author'] );
 							$sxe->addChild('var_pb_post_social_sharing', $_POST['var_pb_post_social_sharing'] );
 							$sxe = save_layout_xml($sxe);
				update_post_meta( $post_id, 'post', $sxe->asXML() );
			}
		}
?>