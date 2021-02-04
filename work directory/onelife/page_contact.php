<?php global $cs_node,$cs_counter_node,$cs_theme_option ; 
cs_enqueue_validation_script();

?>
	<script type="text/javascript">
        jQuery().ready(function($) {
            cs_form_element();
            var container = $('');
            var validator = jQuery("#frm<?php echo $cs_counter_node?>").validate({
                messages:{
                	contact_name: '<?php if($cs_theme_option['trans_switcher']== "on"){ _e('Name field is invalid or empty','OneLife');}else{ echo $cs_theme_option['trans_name_error']; } ?>',
                	contact_email:{
                		required: '<?php if($cs_theme_option['trans_switcher']== "on"){ _e('Email field is invalid or empty','OneLife');}else{ echo $cs_theme_option['trans_email_error']; } ?>',
                    	email:'<?php if($cs_theme_option['trans_switcher']== "on"){ _e('Email field is invalid or empty','OneLife');}else{ echo $cs_theme_option['trans_email_error']; } ?>',
                	},
                    subject: {
                        required:'<?php if($cs_theme_option['trans_switcher']== "on"){ _e('Subject field is invalid or empty','OneLife');}else{ echo $cs_theme_option['trans_subject_error']; } ?>',
                    },
                	contact_msg: '<?php if($cs_theme_option['trans_switcher']== "on"){ _e('Message field is invalid or empty','OneLife');}else{ echo $cs_theme_option['trans_message_error']; } ?>',
       	        },
                errorContainer: container,
                errorLabelContainer: jQuery(container),
                errorElement:'div',
                errorClass:'frm_error',
                meta: "validate"
            });
        });
        function frm_submit<?php echo $cs_counter_node?>(){
            var $ = jQuery;
            $("#submit_btn<?php echo $cs_counter_node?>").hide();
            $("#loading_div<?php echo $cs_counter_node?>").html('<img src="<?php echo get_template_directory_uri()?>/images/ajax_loading.gif" />');
            $.ajax({
                type:'POST', 
                url: '<?php echo get_template_directory_uri()?>/page_contact_submit.php',
                data:$('#frm<?php echo $cs_counter_node?>').serialize(), 
                success: function(response) {
                    //$('#frm').get(0).reset();
                    $("#loading_div<?php echo $cs_counter_node?>").html('');
                    $("#form_hide<?php echo $cs_counter_node?>").hide();
                    $("#succ_mess<?php echo $cs_counter_node?>").show('');
                    $("#succ_mess<?php echo $cs_counter_node?>").html(response);
                    //$('#frm_slide').find('.form_result').html(response);
                }
            });
        }
    </script>
    <div class="element_size_<?php echo $cs_node->contact_element_size; ?>">
        <div class="inputforms respond">
            <div class="textsection">
               <div class="succ_mess" id="succ_mess<?php echo $cs_counter_node?>"></div>
            </div>
            <div id="form_hide<?php echo $cs_counter_node;?>">
           		<div class="inquiry" id="respond">
                <header class="heading">
                    <h2 class="heading-color section-title"><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Send us a Quick Message','OneLife');}else{ echo $cs_theme_option['trans_form_title'];}?></h2>
                </header>
                <form id="frm<?php echo $cs_counter_node ?>" name="frm<?php echo $cs_counter_node ?>" method="post" action="javascript:<?php echo "frm_submit".$cs_counter_node. "()";
                ?>" novalidate>   
                	<p class="comment-notes">
                    	Your email is <em>never</em> published nor shared. Required fields are marked <span class="required">*</span>
                    </p>             
                    <p class="comment-form-author">
                        <input type="text" name="contact_name" id="contact_name" class="nameinput {validate:{required:true}}"   value="<?php _e('Name', 'OneLife'); ?>" />
                    </p>
                    <p class="comment-form-email">
                         <input type="text" name="contact_email" id="contact_email" class="emailinput {validate:{required:true ,email:true}}"   value="<?php _e('Email', 'OneLife'); ?>" />
                         
                    </p>
                    <p class="comment-form-contact">
                        <input type="text" name="subject" id="subject" class="subjectinput {validate:{required:true}}"   value="<?php if($cs_theme_option['trans_switcher']== "on"){ _e('Subject','OneLife');}else{ echo $cs_theme_option['trans_subject']; } ?>" />
                        
                    </p>
                    <p class="comment-form-comment">
                        <textarea name="contact_msg"   id="contact_msg" class="{validate:{required:true}}" /><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Message','OneLife');}else{echo $cs_theme_option['trans_message'];} ?></textarea>
                        
                    </p>
                 
                    <p class="form-submit">
                        <input type="hidden" value="<?php echo $cs_node->cs_contact_email ?>" name="cs_contact_email">
                        <input type="hidden" value="<?php echo $cs_node->cs_contact_succ_msg ?>" name="cs_contact_succ_msg">
                        <input type="hidden" name="bloginfo" value="<?php echo get_bloginfo() ?>" />
                        <input type="hidden" name="counter_node" value="<?php echo $cs_counter_node ?>" />
                        <input type="submit" value="<?php _e('Submit', 'OneLife'); ?>" id="submit_btn<?php echo $cs_counter_node ?>" class="backcolr">
                        <div id="loading_div<?php echo $cs_counter_node ?>"></div>
                    </p>
                </form>
            </div>
            </div>
         </div>
    </div>
 