<?php global $px_node,$px_counter_node,$px_theme_option ; 
px_enqueue_validation_script();

?>
	<script type="text/javascript">
        jQuery().ready(function($) {
            var container = $('');
            var validator = jQuery("#frm<?php echo $px_counter_node?>").validate({
                messages:{
                	contact_name: '',
                	contact_email:{
                		required: '',
                    	email:'',
                	},
                    subject: {
                        required:'',
                    },
                	contact_msg: '',
       	        },
                errorContainer: container,
                errorLabelContainer: jQuery(container),
                errorElement:'div',
                errorClass:'frm_error',
                meta: "validate"
            });
        });
        function frm_submit<?php echo $px_counter_node?>(){
            var $ = jQuery;
            $("#submit_btn<?php echo $px_counter_node?>").hide();
            $("#loading_div<?php echo $px_counter_node?>").html('<i class="fa fa-refresh fa-spin"></i>');
            $.ajax({
                type:'POST', 
                url: '<?php echo get_template_directory_uri()?>/page_contact_submit.php',
                data:$('#frm<?php echo $px_counter_node?>').serialize(), 
                success: function(response) {
                    //$('#frm').get(0).reset();
                    $("#loading_div<?php echo $px_counter_node?>").html('');
                    $("#form_hide<?php echo $px_counter_node?>").hide();
                    $("#succ_mess<?php echo $px_counter_node?>").show('');
                    $("#succ_mess<?php echo $px_counter_node?>").html(response);
                    //$('#frm_slide').find('.form_result').html(response);
                }
            });
        }
    </script>
    <?php if($px_node->px_contact_title <> "" or $px_node->px_contact_address <> "" or $px_node->px_contact_phone <> "" or $px_node->px_contact_fax <> "" or $px_node->px_contact_emile <> ""){ ?>
    <div class="contactus-shortcode">
        <article class="event-v1">
        	<?php if($px_node->px_contact_title <> ""){ ?>
            <h5 class="pix-bgcolr-alt"><?php echo $px_node->px_contact_title; ?></h5>
            <?php } ?>
            <?php if($px_node->px_contact_address <> ""){ ?>
            <h3 class="pix-colr-alt"><?php echo $px_node->px_contact_address; ?></h3>
            <?php } ?>
            <ul>
            	<?php if($px_node->px_contact_phone <> ""){ ?>
                <li>
                    <span><?php if($px_theme_option['trans_switcher']== "on"){ _e('Phone','Church Life');}else{ echo $px_theme_option['trans_other_phone']; } ?></span>
                    <?php echo $px_node->px_contact_phone; ?>
                </li>
                <?php 
				} 
				if($px_node->px_contact_fax <> ""){
				?>
                <li>
                    <span><?php if($px_theme_option['trans_switcher']== "on"){ _e('Fax','Church Life');}else{ echo $px_theme_option['trans_other_fax']; } ?></span>
                    <?php echo $px_node->px_contact_fax; ?>
                </li>
                <?php 
				} 
				if($px_node->px_contact_emile <> ""){
				?>
                <li>
                    <span><?php _e('Email','Church Life'); ?>:</span>
                    <a href="mailto:<?php echo $px_node->px_contact_emile; ?>"><?php echo $px_node->px_contact_emile; ?></a>
                </li>
                <?php 
				} 
				?>
            </ul>
        </article>
    </div>
    <?php } ?>
    <div class="element_size_<?php echo $px_node->contact_element_size; ?>">
        <div class="inputforms respond">
            <div class="textsection">
               <div class="succ_mess" id="succ_mess<?php echo $px_counter_node?>"  style="display:none;"></div>
            </div>
            <div id="form_hide<?php echo $px_counter_node;?>">
           		<div class="inquiry" id="respond">
                <form id="frm<?php echo $px_counter_node ?>" name="frm<?php echo $px_counter_node ?>" method="post" action="javascript:<?php echo "frm_submit".$px_counter_node. "()";
                ?>" novalidate>   
                    <p class="comment-form-author">
                        <input type="text" name="contact_name" id="contact_name" class="nameinput {validate:{required:true}}"   value="<?php _e('Name', 'Church Life'); ?>" />
                        <span class="form-icons"><em class="fa fa-user"></em></span>
                    </p>
                    <p class="comment-form-email">
                        <input type="text" name="contact_email" id="contact_email" class="emailinput {validate:{required:true ,email:true}}"   value="<?php _e('Email', 'Church Life'); ?>" />
                         <span class="form-icons"><em class="fa fa-envelope"></em></span>
                    </p>
                    <p class="comment-form-contact">
                        <input type="text" name="subject" id="subject" class="subjectinput {validate:{required:true}}"   value="<?php if($px_theme_option['trans_switcher']== "on"){ _e('Subject','Church Life');}else{ echo $px_theme_option['trans_subject']; } ?>" />
                        <span class="form-icons"><em class="fa fa-list"></em></span>
                    </p>
                    <p class="comment-form-comment">
                      <textarea name="contact_msg"   id="contact_msg" class="{validate:{required:true}}" ></textarea>    
                    </p>
                    <p class="form-submit">
                        <input type="hidden" value="<?php echo $px_node->px_contact_email ?>" name="px_contact_email">
                        <input type="hidden" value="<?php echo $px_node->px_contact_succ_msg ?>" name="px_contact_succ_msg">
                        <input type="hidden" name="bloginfo" value="<?php echo get_bloginfo() ?>" />
                        <input type="hidden" name="counter_node" value="<?php echo $px_counter_node ?>" />
                        <input type="submit" value="<?php _e('Submit', 'Church Life'); ?>" id="submit_btn<?php echo $px_counter_node ?>" class="backcolr">
						<span><?php if($px_theme_option['trans_switcher'] == "on"){ _e('*Your Email will never published.','Church Life');}else{ echo $px_theme_option['trans_email_published']; } ?></span>
                      </p>
                      <div id="loading_div<?php echo $px_counter_node ?>"></div>
                </form>
            </div>
            </div>
         </div>
    </div>
 