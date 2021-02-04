<?php global $cs_node,$counter_node,$cs_theme_option ; 
cs_enqueue_validation_script();
?>
	<script type="text/javascript">
        jQuery().ready(function($) {
            var container = $('');
            var validator = jQuery("#frm<?php echo $counter_node?>").validate({
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
        function frm_submit<?php echo $counter_node?>(){
            var $ = jQuery;
            $("#submit_btn<?php echo $counter_node?>").hide();
            $("#loading_div<?php echo $counter_node?>").html('<img src="<?php echo get_template_directory_uri()?>/images/ajax_loading.gif" alt="" />');
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
    <div class="right-content">
    <div class="element_size_<?php echo $cs_node->contact_element_size; ?> gigs-wrapp">
        <div class="contact-area scroll-box">
            <div class="textsection">
               <div class="succ_mess" id="succ_mess<?php echo $counter_node?>"></div>
             </div>
            <div id="form_hide<?php echo $counter_node;?>" class="contactform">
                 <header class="section-header">
                    <h2 class="section-title cs-heading-color"><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Send us a Quick Message','Bolster');}else{ echo $cs_theme_option['trans_form_title'];}?></h2>
                </header>
				<?php
				if(isset($cs_node->cs_contact_form_text) and $cs_node->cs_contact_form_text <> ""){
					echo "<p class='cs_form_txt'>".do_shortcode($cs_node->cs_contact_form_text)."</p>";
				}
				?>
                <form id="frm<?php echo $counter_node ?>" name="frm<?php echo $counter_node ?>" method="post" action="javascript:<?php echo "frm_submit".$counter_node. "()";
                ?>" novalidate>   
                	<p class="comment-form-author">
                        <label><?php _e('Name', 'Bolster'); ?></label>
                        <span><input type="text" name="contact_name" id="contact_name" class="nameinput {validate:{required:true}}"   value="" /><em class="fa fa-user">&nbsp;</em></span>
                    </p>
                    <p class="comment-form-email">
                        <label><?php _e('Email', 'Bolster'); ?></label>
                         <span><input type="text" name="contact_email" id="contact_email" class="emailinput {validate:{required:true ,email:true}}"   value="" /><em class="fa fa-envelope">&nbsp;</em></span>
                         
                    </p>
                    <p class="comment-form-contact comment-form-website">
                        <label><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Subject','Bolster');}else{ echo $cs_theme_option['trans_subject']; } ?></label>
                        <span><input type="text" name="subject" id="subject" class="subjectinput {validate:{required:true}} websiteinput"   value="" /><em class="fa fa-link">&nbsp;</em></span>
                        
                    </p>
                     <p class="comment-form-comment fullwidth">
                        <label><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Message','Bolster');}else{echo $cs_theme_option['trans_message']; } ?></label>
                        <textarea name="contact_msg"   id="contact_msg" class="{validate:{required:true}}" /></textarea>
                        
                    </p>
                 
                    <p class="form-submit">
                        <input type="hidden" value="<?php echo $cs_node->cs_contact_email ?>" name="cs_contact_email">
                        <input type="hidden" value="<?php echo $cs_node->cs_contact_succ_msg ?>" name="cs_contact_succ_msg">
                        <input type="hidden" name="bloginfo" value="<?php echo get_bloginfo() ?>" />
                        <input type="hidden" name="counter_node" value="<?php echo $counter_node ?>" />
                        <button id="submit_btn<?php echo $counter_node ?>" class="backcolr"><em class="fa fa-thumbs-o-up">&nbsp;</em> <?php _e('Submit','Bolster'); ?></button>
                         <div id="loading_div<?php echo $counter_node ?>"></div>
                    </p>
                </form>
             </div>
         </div>
    </div>
    </div>
    
    
 