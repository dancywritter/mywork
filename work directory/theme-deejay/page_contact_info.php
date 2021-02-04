<?php global $px_node,$px_counter_node,$px_theme_option ; ?>
<div class="element_size_<?php echo $px_node->contact_info_element_size; ?>">
    <div class="contact-us">
    	<?php if($px_node->px_contact_title <> "" or $px_node->px_contact_address <> "" or $px_node->px_contact_phone <> "" or $px_node->px_contact_fax <> "" or $px_node->px_contact_email <> ""){ ?>
    		<div class="text-widget rich_editor_text">
            	<div class="contact-info">
             <?php if($px_node->px_contact_title <> ""){ ?>
             <header class="pix-heading-title">
                <h2 class="pix-section-title"><?php echo $px_node->px_contact_title; ?></h2>
             </header>

                
                <?php } ?>
                <?php if($px_node->px_contact_address <> ""){ ?>
                <div class="postel-text">
                    <i class="fa fa-location-arrow"></i>
                    <p><?php echo $px_node->px_contact_address; ?></p>
                </div>
                <?php }?>
                <ul>
                    <?php if($px_node->px_contact_phone <> ""){ ?>
                    <li>
                    	<i class="fa fa-phone"></i>
                        <span><?php if($px_theme_option['trans_switcher']== "on"){ _e('Phone','Deejay');}else{ echo $px_theme_option['trans_other_phone']; } ?></span>
                        <?php echo $px_node->px_contact_phone; ?>
                    </li>
                    <?php 
                    } 
                    if($px_node->px_contact_fax <> ""){
                    ?>
                    <li>
                    	<i class="fa fa-print"></i>
                        <span><?php if($px_theme_option['trans_switcher']== "on"){ _e('Fax','Deejay');}else{ echo $px_theme_option['trans_other_fax']; } ?></span>
                        <?php echo $px_node->px_contact_fax; ?>
                    </li>
                    <?php 
                    } 
                    if($px_node->px_contact_info_email <> ""){
                    ?>
                    <li>
                    	<i class="fa fa-envelope"></i>
                        <span><?php _e('Email','Deejay'); ?>:</span>
                        <a href="mailto:<?php echo $px_node->px_contact_info_email; ?>"><?php echo $px_node->px_contact_info_email; ?></a>
                    </li>
                    <?php 
                    } 
                    if($px_node->px_contact_info_email <> ""){
                    ?>
                    <li>
                    	<i class="fa fa-bookmark"></i>
                        <span><?php _e('Booking','Deejay'); ?>:</span>
                        <a href="mailto:<?php echo $px_node->px_contact_info_email; ?>"><?php echo $px_node->px_contact_info_email; ?></a>
                    </li>
                    <?php 
                    } 
                    ?>
                </ul>
                <?php px_social_network();?>
                </div>
        </div>
			 <?php } ?>
     </div>
  </div>  
 