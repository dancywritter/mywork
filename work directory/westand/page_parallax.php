<?php
 		global $cs_node, $post, $cs_counter_node, $cs_theme_option;
		$parallax_element_size = $cs_node->parallax_element_size;
		$parallax_height = $cs_node->parallax_height;


 		// $counter = $post->ID . $count_node;

		if ( !isset($cs_node->parallax_custom_text) or $cs_node->parallax_custom_text == "" ) { $cs_node->parallax_custom_text = ''; }
		if ( !isset($cs_node->parallax_custom_img) or $cs_node->parallax_custom_img == "" ) { $cs_node->parallax_custom_img = ''; }
		if ( !isset($cs_node->parallax_height) or $cs_node->parallax_height == "" ) { $cs_node->parallax_height = ''; }
		if ( !isset($cs_node->parallax_element_size) or $cs_node->parallax_element_size == "" ) { $cs_node->parallax_element_size = ''; }
 		if ( !isset($cs_node->parallax_custom_bgcolor) or $cs_node->parallax_custom_bgcolor == "" ) { $cs_node->parallax_custom_bgcolor = ''; }
		
		if ( !isset($cs_node->parallax_margin_top) or $cs_node->parallax_margin_top == "" ) { $parallax_margin_top = ''; } else { $parallax_margin_top = $cs_node->parallax_margin_top;}
		if ( !isset($cs_node->parallax_margin_bottom) or $cs_node->parallax_margin_bottom == "" ) { $parallax_margin_bottom = ''; } else { $parallax_margin_bottom = $cs_node->parallax_margin_bottom;}
		
		if ( !isset($cs_node->parallax_padding_top) or $cs_node->parallax_padding_top == "" ) { $parallax_padding_top = ''; } else { $parallax_padding_top = $cs_node->parallax_padding_top;}
		if ( !isset($cs_node->parallax_padding_bottom) or $cs_node->parallax_padding_bottom == "" ) { $parallax_padding_bottom = ''; } else { $parallax_padding_bottom = $cs_node->parallax_padding_bottom;}
		
	?>
    <?php if(isset($cs_node->parallax_custom_bgcolor) && $cs_node->parallax_custom_bgcolor <> ''){?>
		<style>
            .service-parallax<?php echo $cs_counter_node;?>:before{
                background: none repeat scroll 0 0 <?php echo $cs_node->parallax_custom_bgcolor; ?>;
            
            }
        </style>
    <?php }?>
	<div class="parallaxbg parallax-fullwidth fullwidth bannerarea element_size_100 service-parallax service-parallax<?php echo $cs_counter_node;?>"  style=" <?php if ($cs_node->parallax_custom_img <> '') { ?> background: url(<?php echo $cs_node->parallax_custom_img; ?>) no-repeat center top;<?php } if(isset($cs_node->parallax_height) && !empty($cs_node->parallax_height)){ ?> height: <?php echo $cs_node->parallax_height ?>px; <?php } ?>  margin-bottom:<?php echo $parallax_margin_bottom?>px; margin-top:<?php echo $parallax_margin_top?>px; padding-top:<?php echo $parallax_padding_top?>px; padding-bottom:<?php echo $parallax_padding_bottom?>px; ">
        	<div class="container">
            	 <?php if ($cs_node->parallax_title <> ''){ echo '<h2>'.cs_textarea_filter($cs_node->parallax_title).'</h2>'; }?>
				 <?php if ($cs_node->parallax_custom_text <> ''){ echo cs_textarea_filter($cs_node->parallax_custom_text); }?>
                 <div class="clear"></div>
            </div>
  </div>
		<!-- Qoute Start -->
	