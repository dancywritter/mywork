<?php 
	require_once '../../../../wp-load.php';
	require_once '../../../../wp-admin/includes/admin.php';
	do_action('admin_init');
	
	if ( ! is_user_logged_in() )
		die('You must be logged in to access this script.');
	
	if(!isset($shortcodesES))
		$shortcodesES = new ShortcodesEditorSelector();
	
	global $shortcode_tags;
	$ordered_sct = array_keys($shortcode_tags);
	$neworder = sort($ordered_sct);

?>
(function() {
	tinymce.create('tinymce.plugins.<?php echo $shortcodesES->buttonName; ?>', {
		init : function(ed, url) {
		},	
		createControl : function(n, cm) {
			if(n=='<?php echo $shortcodesES->buttonName; ?>'){
                var mlb = cm.createListBox('<?php echo $shortcodesES->buttonName; ?>', {
                     title : 'Shortcode',
                         onselect : function(v) { //Add shortcode data onClick
                             if(v == 'toogle'){
                                        tinyMCE.activeEditor.selection.setContent('[toggle active="yes" title="Toggle Title 1"]Toggle Content 1[/toggle]<br /><br />');
                                }
                             else if(v == 'tabs'){
                                        tinyMCE.activeEditor.selection.setContent('[tab style="horizontal"] <br />\
                                            [tab_item active="yes" icon="fa-twitter" title="Tab Title 1" tabs="tabs"]Tab Content 1[/tab_item]<br />\
                                            [tab_item icon="" title="Tab Title 2" tabs="tabs"]Tab Content 2[/tab_item]<br />\
                                            [tab_item icon="" title="Tab Title 3" tabs="tabs"]Tab Content 3[/tab_item]<br />\
                                            [/tab]<br /><br />');
                                }
                             else if(v == 'accordion'){
                                        tinyMCE.activeEditor.selection.setContent('[accordion type="faq/simple"] <br />\
                                            [accordion_item active="yes" icon="fa-twitter" title="Accordion Title 1" accordion="accordion"]Accordion Content 1[/accordion_item] <br />\
                                            [accordion_item title="Accordion Title 2" accordion="accordion"]Accordion Content 2[/accordion_item] <br />\
                                            [accordion_item title="Accordion Title 3" accordion="accordion"]Accordion Content 3[/accordion_item] <br />\
                                            [/accordion]');
                                }
                             else if(v == 'coloumclear'){
                                        tinyMCE.activeEditor.selection.setContent('[coloumnclear]');
                             }
                             else if(v == 'quote'){
                                        tinyMCE.activeEditor.selection.setContent('[quote align="center" color="#COLOR_CODE"]Quote Content[/quote]');
                                }
                             else if(v == 'button'){
                                        tinyMCE.activeEditor.selection.setContent('[button style="medium" type="rounded" color="#COLOR_CODE" background="#COLOR_CODE" src="LINK_URL" target="_blank"]Button Content[/button]<br /><br />');
                                }
                             else if(v == 'column'){
                                        tinyMCE.activeEditor.selection.setContent('[column size="1/2"]Column Content[/column]');
                                }
                             else if(v == 'dropcap'){
                                        tinyMCE.activeEditor.selection.setContent('[dropcap]Dropcap Content[/dropcap]');
                                }
                                else if(v == 'divider'){
                                        tinyMCE.activeEditor.selection.setContent('[divider style="divider1" top_margin="20" bottom_margin="20"]');
                                }
                             else if(v == 'message_box'){
                                        tinyMCE.activeEditor.selection.setContent('[message_box type="info/warning" align="left" icon="fa-check-circle" close="yes" color="#COLOR_CODE" background="#COLOR_CODE" border_color="#COLOR_CODE" box_shadow_color="#COLOR_CODE" title="Message Title"]Message Content[/message_box]');
                                }
                             else if(v == 'frame'){
                                        tinyMCE.activeEditor.selection.setContent('[frame src="IMAGE_SOURCE" width="IMAGE_WIDTH" height="IMAGE_HEIGHT" lightbox="on" title="Image Title"]');
                                }
                             else if(v == 'list'){
                                        tinyMCE.activeEditor.selection.setContent('[list type="decimal" icon="fa-ok"]<br />\
                                                [list_item]List Item 1[/list_item]<br />\
                                                [list_item]List Item 2[/list_item]<br />\
                                                [list_item]List Item 3[/list_item]<br />\
                                             [/list]<br /><br />');
                                }
                             else if(v == 'table'){
                                        tinyMCE.activeEditor.selection.setContent('[table color="#Color_Code"]<br />\
                                                [thead]<br />\
                                                  [tr]<br />\
                                                    [th]Column 1[/th]<br />\
                                                    [th]Column 2[/th]<br />\
                                                    [th]Column 3[/th]<br />\
                                                    [th]Column 4[/th]<br />\
                                                  [/tr]<br />\
                                                [/thead]<br />\
                                                [tbody]<br />\
                                                  [tr]<br />\
                                                    [td]Item 1[/td]<br />\
                                                    [td]Item 2[/td]<br />\
                                                    [td]Item 3[/td]<br />\
                                                    [td]Item 4[/td]<br />\
                                                  [/tr]<br />\
                                                  [tr]<br />\
                                                    [td]Item 11[/td]<br />\
                                                    [td]Item 22[/td]<br />\
                                                    [td]Item 33[/td]<br />\
                                                    [td]Item 44[/td]<br />\
                                                  [/tr]<br />\
                                                [/tbody]<br />\
                                         [/table]');
                                }
                             else if(v == 'heading'){
                                        tinyMCE.activeEditor.selection.setContent('[heading size="1" color="#fff000"]Heading Text[/heading]');
                                }
                             else if(v == 'highlight'){
                                        tinyMCE.activeEditor.selection.setContent('[hightlight background="#e32028" color="#fff"]Highlight text[/hightlight]');
                                }
                             
                             else if(v == 'video'){
                                        tinyMCE.activeEditor.selection.setContent('[video-item url="" name="video name" width="400" height="250"][/video-item]');
                                }
                             else if(v == 'image-frame'){
                                        tinyMCE.activeEditor.selection.setContent('[image-frame width="200" height="150" lightbox="yes" source="" caption="Image Caption"][/image-frame]');
                                }
                             else if(v == 'icon'){
                                        tinyMCE.activeEditor.selection.setContent('[icon class="fa-twitter" type="rounded" size="fa-4x" border="no" bgcolor="#000" color="#ff0000"][/icon]');
                                }
                             else if(v == 'code'){
                                        tinyMCE.activeEditor.selection.setContent('[code title="Insert Title Here"]Insert Code Here[/code]');
                             }
                             else if(v == 'skills'){
                                        tinyMCE.activeEditor.selection.setContent('[skills]<br />\
                                        [skill name="skill 1" percent="60" bg_color="#f94d51"]<br />\
                                        [skill name="skill 2" percent="70" bg_color="#f94d51"]<br />\
                                        [skill name="skill 3" percent="80" bg_color="#f94d51"]<br />\
                                        [skill name="skill 4" percent="70" bg_color="#f94d51"]<br />\
                                        [/skills]<br /><br />');
                             }
                             else if(v == 'team'){
                                        tinyMCE.activeEditor.selection.setContent('[team-sec]<br />\
                                        [team name="JOHN DOE" job="CEO" image=""]<br />\
                                        [social_links]<br />\
                                        [social link="#" target="_blank" icon="fa-facebook" tabs="tabs"]<br />\
                                        [social link="#" target="_blank" icon="fa-twitter" tabs="tabs"]<br />\
                                        [/social_links]<br />\
                                        [/team]<br />\
                                        [team name="JOHN DOE" job="CEO" image=""]<br />\
                                        [social_links]<br />\
                                        [social link="#" target="_blank" icon="fa-facebook" tabs="tabs"]<br />\
                                        [social link="#" target="_blank" icon="fa-twitter" tabs="tabs"]<br />\
                                        [/social_links]<br />\
                                        [/team]<br />\
                                        [/team-sec]<br /><br />');
                             }
                             else if(v == 'testimonials'){
                                        tinyMCE.activeEditor.selection.setContent('[testimonials job="Designer" image="image-url" name="John Deo" testimonial="testimonial"]Testimonial Content[/testimonials]');
                             }
                             else if(v == 'services'){
                                        tinyMCE.activeEditor.selection.setContent('[services]<br />\
                                        [service-item icon="fa-star" title="Service Title 1" link="service_url"]<br />\
                                        [content]Service Detail[/content]<br />\
                                        [/service-item]<br />\
                                        [service-item icon="fa-cog" title="Service Title 2" link="service_url"]<br />\
                                        [content]Service Detail[/content]<br />\
                                        [/service-item]<br />\
                                        [/services]<br /><br />');
                             }
                             else if(v == 'price_tables'){
                                        tinyMCE.activeEditor.selection.setContent('[price-tables]<br />\
                                        [price-item title="Basic" price="$49" pennies=".99" time_period="Per Month" button_text="Signup" button_url="button_url" background_color="#282828" featured="no"]<br />\
                                        [content]Price Table Detail[/content]<br />\
                                        [/price-item]<br />\
                                        [price-item title="Monthly" price="$149" pennies=".99" time_period="Per Month" button_text="Signup" button_url="button_url" background_color="#f94d51" featured="yes"]<br />\
                                        [content]Price Table Detail[/content]<br />\
                                        [/price-item]<br />\
                                        [price-item title="Advance" price="$249" pennies=".99" time_period="Per Month" button_text="Signup" button_url="button_url" background_color="#282828" featured="no"]<br />\
                                        [content]Price Table Detail[/content]<br />\
                                        [/price-item]<br />\
                                        [price-item title="Yearly" price="$649" pennies=".99" time_period="Per Month" button_text="Signup" button_url="button_url" background_color="#282828" featured="no"]<br />\
                                        [content]Price Table Detail[/content]<br />\
                                        [/price-item]<br />\
                                        [/price-tables]<br /><br />');
                             }
                             
                     }
                });
                // Add Elements for DropDown
                	//mlb.add('accordion','accordion');
                    //mlb.add('button','button');
                    mlb.add('column','column');
                    //mlb.add('code','code');
                    //mlb.add('coloumclear','coloumclear');
                	//mlb.add('dropcap','dropcap');
                    //mlb.add('divider','divider');
                	//mlb.add('heading','heading');
                	//mlb.add('highlight','highlight');
                    //mlb.add('image-frame','image-frame');
                	//mlb.add('icon','icon');
                    mlb.add('message_box','message_box');
                    mlb.add('quote','quote');
                    mlb.add('skills','skills');
                    mlb.add('team','team');
                    mlb.add('testimonials','testimonials');
                    mlb.add('services','services');
                    mlb.add('price_tables','price_tables');
                    //mlb.add('toogle','toogle');
                	mlb.add('tabs','tabs');
                	//mlb.add('table','table');
                	//mlb.add('video','video');
                	
                // Return the new listbox instance
                return mlb;
             }
             return null;
		},
	});
	// Register plugin
	tinymce.PluginManager.add('<?php echo $shortcodesES->buttonName; ?>', tinymce.plugins.<?php echo $shortcodesES->buttonName; ?>);
})();
