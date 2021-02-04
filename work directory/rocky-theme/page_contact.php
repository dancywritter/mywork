<?php global $cs_node,$counter_node,$cs_theme_option ; 
cs_enqueue_validation_script();

?>
	<script type="text/javascript">
        jQuery().ready(function($) {
            var container = $('');
            var validator = jQuery("#frm<?php echo $counter_node?>").validate({
                messages:{},
                errorContainer: container,
                errorLabelContainer: jQuery(container),
                errorElement:'div',
                errorClass:'frm_error',
                meta: "validate"
            });
        });
        function frm_submit<?php echo $counter_node?>(){
            var $ = jQuery;
            $("#submit_btn<?php echo $counter_node?>").hide();
            $("#loading_div<?php echo $counter_node?>").html('<img src="<?php echo get_template_directory_uri()?>/images/ajax-loader.gif" alt="" />');
            $.ajax({
                type:'POST', 
                url: '<?php echo get_template_directory_uri()?>/page_contact_submit.php',
                data:$('#frm<?php echo $counter_node?>').serialize(), 
                success: function(response) {
                    //$('#frm').get(0).reset();
                    $("#loading_div<?php echo $counter_node?>").html('');
                    $("#form_hide<?php echo $counter_node?>").hide();
                    $("#succ_mess<?php echo $counter_node?>").show('');
                    $("#succ_mess<?php echo $counter_node?>").html(response);
                    //$('#frm_slide').find('.form_result').html(response);
                }
            });
        }
    </script>
    <div class="element_size_<?php echo $cs_node->contact_element_size; ?>">
        <div class="inputforms respond">
            <div class="textsection">
               <div class="succ_mess" id="succ_mess<?php echo $counter_node?>" style="display:none;"></div>
            </div>
            <div id="form_hide<?php echo $counter_node;?>">
           		<div class="inquiry" id="respond">
                <header class="heading">
                    <h2 class="cs-heading-color section-title"><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Send us a Quick Message','Rocky');}else{ echo $cs_theme_option['trans_form_title'];}?></h2>
                </header>
                <form id="frm<?php echo $counter_node ?>" name="frm<?php echo $counter_node ?>" method="post" action="javascript:<?php echo "frm_submit".$counter_node. "()";
                ?>" novalidate>   
                	 
					<p class="comment-notes">
                    	Your email is <em>never</em> published nor shared. Required fields are marked <span class="required">*</span>
                    </p>           
                    <p class="comment-form-author">
                        <label><?php _e('Name', 'Rocky'); ?></label>

                        <input type="text" name="contact_name" id="contact_name" title="*" class="nameinput {validate:{required:true}}" value="" />
						<span class="starfill">*</span>
                    </p>
                    <p class="comment-form-email">
                        <label><?php _e('Email', 'Rocky'); ?></label>
                         <input type="text" name="contact_email" id="contact_email" title="*"  class="emailinput {validate:{required:true ,email:true}}"   value="" />
                         <span class="starfill">*</span>
                    </p>
                    <p class="comment-form-contact">
                        <label><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Subject','Rocky');}else{ echo $cs_theme_option['trans_subject']; } ?></label>
                        <input type="text" name="subject" id="subject" title="*"  class="subjectinput {validate:{required:true}}"   value="" />
                        <span class="starfill">*</span>
                    </p>
                    <p class="comment-form-comment">
                        <label><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Message','Rocky');}else{echo $cs_theme_option['trans_message']; } ?></label>
                        <textarea name="contact_msg"   id="contact_msg" title="*" class="{validate:{required:true}}" /></textarea>
                    </p>
                 
                    <p class="form-submit">
                        <input type="hidden" value="<?php echo $cs_node->cs_contact_email ?>" name="cs_contact_email">
                        <input type="hidden" value="<?php echo $cs_node->cs_contact_succ_msg ?>" name="cs_contact_succ_msg">
                        <input type="hidden" name="bloginfo" value="<?php echo get_bloginfo() ?>" />
                        <input type="hidden" name="counter_node" value="<?php echo $counter_node ?>" />
                        <button id="submit_btn<?php echo $counter_node ?>" name="submit_btn<?php echo $counter_node ?>" class="bgcolr"><?php _e('Submit', 'Rocky'); ?></button>
                        <div id="loading_div<?php echo $counter_node ?>"></div>
                    </p>
                </form>
            </div>
            </div>
         </div>
    </div>
 