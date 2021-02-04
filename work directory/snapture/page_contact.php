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
            $("#loading_div<?php echo $counter_node?>").html('<icon class="fa fa-spin" ></i>');
            $.ajax({
                type:'POST', 
                url: '<?php echo get_template_directory_uri()?>/page_contact_submit.php',
                data:$('#frm<?php echo $counter_node?>').serialize(), 
                success: function(response) {
                    //$('#frm').get(0).reset();
                    $("#loading_div<?php echo $counter_node?>").html('');
                    $("#frm_hide<?php echo $counter_node?>").hide();
                    $("#succ_mess<?php echo $counter_node?>").show('');
                    $("#succ_mess<?php echo $counter_node?>").html(response);
                    //$('#frm_slide').find('.form_result').html(response);
                }
            });
        }
    </script>
    		<div class="contact-sec  cs-full-width">
                  <!-- Element Size Start -->
                <div class="element_size_50">
                	<div class="textsection">
                       <div class="succ_mess" id="succ_mess<?php echo $counter_node?>"  style="display:none;"></div>
                     </div>
                    <!-- User Submit Form Strat -->
                    <div id="respond" class="contact-form">
                        <div class="comment-respond" id="frm_hide<?php echo $counter_node ?>">
                            <header class="cs-heading-title"><h2 class="comment-reply-title cs-section-title cs-heading-color uppercase"><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Send us a Quick Message','Snapture');}else{ echo $cs_theme_option['trans_form_title'];}?></h2></header>
                            
                       <form id="frm<?php echo $counter_node ?>" name="frm<?php echo $counter_node ?>" method="post" action="javascript:<?php echo "frm_submit".$counter_node. "()";?>" novalidate>
                                <p class="comment-form-author"><label><i class="fa fa-user"></i></label><input type="text" title=" " class="nameinput {validate:{required:true}}" name="contact_name" id="contact_name" placeholder="<?php _e('Name', 'Snapture'); ?>" /></p>
                                <p class="comment-form-email"><label><i class="fa fa-envelope-o"></i></label><input type="text" name="contact_email" id="contact_email"  placeholder="<?php _e('email', 'Snapture'); ?>"  title=" "  class="emailinput {validate:{required:true ,email:true}}" /></p>
                                <p class="comment-form-website"><label><i class="fa fa-mobile"></i></label><input type="text" name="subject" id="subject"  placeholder="<?php _e('Subject', 'Snapture'); ?>"  title=" "  class="subjectinput {validate:{required:true}}" /></p>
                               <p class="comment-form-comment"><label><i class="fa fa-list-alt"></i></label><textarea  name="contact_msg"    id="contact_msg"  title=""  class="contact_msginput {validate:{required:true}}"> <?php if($cs_theme_option['trans_switcher']== "on"){ _e('Message','Snapture');}else{ echo $cs_theme_option['trans_message']; } ?></textarea></p>
                                <div class="form-submit">
                                    <p><input type="hidden" value="<?php echo $cs_node->cs_contact_email ?>" name="cs_contact_email" />
                                    <input type="hidden" value="<?php echo $cs_node->cs_contact_succ_msg ?>" name="cs_contact_succ_msg" />
                                    <input type="hidden" name="bloginfo" value="<?php echo get_bloginfo() ?>" />
                                    <input type="hidden" name="counter_node" value="<?php echo $counter_node ?>" />
                                    <span><i class="fa fa-envelope-o"></i>*Your email will never published</span>
                                    <input id="submit_btn<?php echo $counter_node ?>" type="submit" value="<?php _e('Submit','Snapture'); ?>" name="" /></p>
                                     <div id="loading_div<?php echo $counter_node ?>"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- User Submit Form End -->
                </div>
                <!-- Element Size End -->
                <div class="element_size_50">
                	<?php if($cs_node->cs_contact_form_text <> ''){echo do_shortcode($cs_node->cs_contact_form_text);}?>
                </div>
           </div>
    
    
 