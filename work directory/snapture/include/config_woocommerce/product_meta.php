<?php

add_action( 'add_meta_boxes', 'cs_meta_woo_prod_add' );
function cs_meta_woo_prod_add()
{  
	add_meta_box( 'cs_meta_woo_prod', 'Product Layout Options', 'cs_meta_woo_prod', 'product', 'normal', 'low' );  
}
function cs_meta_woo_prod( $post ) {
	$post_xml = get_post_meta($post->ID, "product", true);
	global $cs_xmlObject;
	if ( $post_xml <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($post_xml);
		$cs_blog_large_layout = $cs_xmlObject->cs_blog_large_layout;
		$page_content_postion = $cs_xmlObject->page_content_postion;
	}else{
		$cs_blog_large_layout = $page_content_postion = '';
	}
	?>
    <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/select.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/prettyCheckable.js"></script>
	<div class="page-wrap">
        <div class="option-sec row">
            <div class="opt-conts">
                <ul class="form-elements meta-body" >
                    <li class="to-label">
                        <label>Page layout view</label>
                    </li>
                    <li class="to-field">
                        <select name="cs_blog_large_layout" class="select_dropdown" id="page-option-choose-right-sidebar">
                            <option value="cs_full_width" <?php if ($cs_blog_large_layout=='cs_full_width')echo "selected";?>>Wide Layout</option>
                            <option value="cs_boxed_layout" <?php if ($cs_blog_large_layout=='cs_boxed_layout')echo "selected";?>>Boxed View</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements meta-body" >
                    <li class="to-label">
                        <label>Page layout Position Center</label>
                    </li>
                    <li class="to-field">
                        <select name="page_content_postion" class="dropdown">
                            <option value="Yes" <?php if($page_content_postion=="Yes")echo "selected";?> >Yes</option>
                            <option value="No" <?php if($page_content_postion=="No")echo "selected";?> >No</option>
                        </select>
                        <p>Enter Page layout padding in percentage.</p>
                    </li>
                </ul>
			</div>
		</div>
		<div class="clear"></div>
		<?php cs_meta_layout()?>
        <input type="hidden" name="post_woo_meta_form" value="1" />
    </div>
    <?php
}

	if ( isset($_POST['post_woo_meta_form']) and $_POST['post_woo_meta_form'] == 1 ) {
		add_action( 'save_post', 'cs_meta_woo_post_save' );
		function cs_meta_woo_post_save( $post_id ) {
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
				if (empty($_POST["cs_blog_large_layout"])){ $_POST["cs_blog_large_layout"] = "";}
				if (empty($_POST["page_content_postion"])){ $_POST["page_content_postion"] = "";}
					$sxe = new SimpleXMLElement("<cs_meta_post></cs_meta_post>");
						$sxe->addChild('cs_blog_large_layout', $_POST['cs_blog_large_layout'] );
						$sxe->addChild('page_content_postion', $_POST['page_content_postion'] );
						$sxe = save_layout_xml($sxe);
						
			update_post_meta( $post_id, 'product', $sxe->asXML() );
		}
	}


?>