<?php global $cs_node,$cs_counter_node,$cs_theme_option ; 
cs_enqueue_validation_script();

?>
	<script type="text/javascript">
        jQuery().ready(function($) {
            var container = $('');
            var validator = jQuery("#frm<?php echo $cs_counter_node?>").validate({
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
        function frm_submit<?php echo $cs_counter_node?>(){
            var $ = jQuery;
            $("#submit_btn<?php echo $cs_counter_node?>").hide();
            $("#loading_div<?php echo $cs_counter_node?>").html('<img src="<?php echo get_template_directory_uri()?>/images/ajax-loader.gif" alt="" />');
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
    	<header class="cs-heading-title">
            <h2 class="cs-section-title"><?php echo $cs_node->cs_form_title; ?></h2>
        </header>
        <div class="inputforms respond">
            <div class="textsection">
               <div class="succ_mess" id="succ_mess<?php echo $cs_counter_node?>"  style="display:none;"></div>
            </div>
            <div id="form_hide<?php echo $cs_counter_node;?>">
           		<div class="respond fullwidth" id="respond">
                
                <form id="frm<?php echo $cs_counter_node ?>" name="frm<?php echo $cs_counter_node ?>" method="post" action="javascript:<?php echo "frm_submit".$cs_counter_node. "()";
                ?>" novalidate>   
                	 <p class="comment-form-author">
                         <label class="form-icons"><i class="fa fa-user"></i></label>
                        <input type="text" name="contact_name" id="contact_name" class="nameinput {validate:{required:true}}" placeholder="<?php _e('Name', 'Faith'); ?>"  value="" />
                        <span><?php  _e('(required)','Faith'); ?></span>
                     </p>
                    <p class="comment-form-email">
                    	 <label class="form-icons"><i class="fa fa-envelope-o"></i></label>
                          <input type="text" name="contact_email" id="contact_email" class="emailinput {validate:{required:true ,email:true}}" placeholder="<?php _e('Email', 'Faith'); ?>"   value="" />
                       <span><?php  _e('(required)','Faith'); ?></span>
                     </p>
                    <p class="comment-form-contact">
                        <label class="form-icons"><i class="fa fa-list"></i></label>
                         <input type="text" name="subject" id="subject"  placeholder="<?php if($cs_theme_option['trans_switcher']== "on"){ _e('Subject','Faith');}else{ echo $cs_theme_option['trans_subject']; } ?>" class="subjectinput {validate:{required:true}}"   value="" />
                        
                        <span><?php   _e('(required)','Faith'); ?></span>
                         
                    </p>
                    <p class="comment-form-comment">
                   
                        <textarea name="contact_msg"   id="contact_msg" class="{validate:{required:true}}" /> <?php if($cs_theme_option['trans_switcher']== "on"){ _e('Message','Faith');}else{echo $cs_theme_option['trans_message'];} ?></textarea>
                    </p>
                 
                    <p class="form-submit">
                        <input type="hidden" value="<?php echo $cs_node->cs_contact_email ?>" name="cs_contact_email">
                        <input type="hidden" value="<?php echo $cs_node->cs_contact_succ_msg ?>" name="cs_contact_succ_msg">
                        <input type="hidden" name="bloginfo" value="<?php echo get_bloginfo() ?>" />
                        <input type="hidden" name="counter_node" value="<?php echo $cs_counter_node ?>" />
                        <input name="submit" type="submit" id="submit_btn<?php echo $cs_counter_node ?>" class="cs-submit" value="<?php _e('Submit', 'Faith'); ?>">
						
                        <div id="loading_div<?php echo $cs_counter_node ?>"></div>
                    </p>
                </form>
            </div>
            </div>
         </div>
    </div>
 