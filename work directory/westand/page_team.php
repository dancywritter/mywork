<?php
	global $cs_node, $cs_theme_option, $counter_node, $post;
	if ( !isset($cs_node->var_pb_team_per_page) || empty($cs_node->var_pb_team_per_page) ) { $cs_node->var_pb_team_per_page = -1; }
	 if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
	 if ( !isset($cs_node->cs_team_orderby) || empty($cs_node->cs_team_orderby) ) { $cs_node->cs_team_orderby = 'DESC'; }
	?>
	<div class="element_size_<?php echo $cs_node->var_pb_team_element_size;?>">
    	<?php if ($cs_node->var_pb_team_title <> '') { ?>
            <header class="cs-heading-title">
                <h2 class="cs-section-title"><?php echo $cs_node->var_pb_team_title; ?></h2>
            </header>
        <?php  } 
            $args = array(
						'posts_per_page'			=> "-1",
						'paged'						=> $_GET['page_id_all'],
						'post_type'					=> 'teams',
						'post_status'				=> 'publish',
						'order'						=> 'ASC',
					 );
					if(isset($cs_node->var_pb_team_cat) && $cs_node->var_pb_team_cat <> '' &&  $cs_node->var_pb_team_cat <> '0'){
						$event_category_array = array('team-category' => "$cs_node->var_pb_team_cat");
						$args = array_merge($args, $event_category_array);
					}
					$custom_query = new WP_Query($args);
					$post_count = $custom_query->post_count;
					$args = array(
							'posts_per_page'			=> "$cs_node->var_pb_team_per_page",
							'paged'						=> $_GET['page_id_all'],
							'post_type'					=> 'teams',
							'post_status'				=> 'publish',
							'order'						=> "$cs_node->cs_team_orderby",
						 );
						 if(isset($cs_node->var_pb_team_cat) && $cs_node->var_pb_team_cat <> '' &&  $cs_node->var_pb_team_cat <> '0'){
								$team_category_array = array('team-category' => "$cs_node->var_pb_team_cat");
								$args = array_merge($args, $team_category_array);
						}
						$custom_query = new WP_Query($args);
						if ( $custom_query->have_posts() <> "" ){
							cs_addthis_script_init_method();
						?>
                        <div class="team-shortcode">
                        
                        <?php 
							$width = 250; 
							$height = 250;
						if($cs_node->var_pb_team_view == 'listing'){
							$post_class = 'team-shortcode-v1';
							
						} else if($cs_node->var_pb_team_view == 'grid'){
							$post_class = 'team-shortcode-v2';
						} else {
							$post_class = '';
						}
							
						
					
                    		while ( $custom_query->have_posts() ): $custom_query->the_post();
								$cs_team = get_post_meta($post->ID, "cs_team", true);
								if ( $cs_team <> "" ) {
									$cs_xmlObject_team = new SimpleXMLElement($cs_team);
										$facebook = $cs_xmlObject_team->facebook;
										$twitter = $cs_xmlObject_team->twitter;
										$linkedin = $cs_xmlObject_team->linkedin;
										$google_plus = $cs_xmlObject_team->google_plus;
								}
								$noimg = '';
								$image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID),$width,$height ); 
								if($image_url == ''){
									$post_class .= ' no-img';
								}
								
							?>
                            <article class="<?php echo $post_class;?>">
                                <figure>
                                    <?php if($image_url <> ''){?><img src="<?php echo $image_url;?>" alt=""><?php }?>
                                    <figcaption>
                                        <a href="<?php the_permalink();?>" class="readmore"><i class="fa fa-plus"></i></a>
                                    </figcaption>
                                </figure>
                                <div class="text">
                                        <h3><a href="<?php the_permalink();?>" class="cs-colrhvr"><?php the_title();?></a></h3>
                                        <?php
                                         if($cs_xmlObject_team->var_cp_expertise <> ''){
                                              echo '<span class="cs-designation">'.$cs_xmlObject_team->var_cp_expertise.'</span>';
                                         }
                                        ?>
                                        
                                            <p><?php  cs_get_the_excerpt($cs_node->cs_team_excerpt,false);?></p>
                                    
                                        <div class="followus">
                                            <?php if($cs_xmlObject_team->facebook <> ''){?><a href="<?php echo $cs_xmlObject_team->facebook;?>" target="_blank"><i class="fa fa-facebook-square"></i></a><?php }?>
                                            <?php if($cs_xmlObject_team->twitter <> ''){?><a href="<?php echo $cs_xmlObject_team->twitter;?>" target="_blank"><i class="fa fa-twitter"></i></a><?php }?>
                                            <?php if($cs_xmlObject_team->linkedin <> ''){?><a href="<?php echo $cs_xmlObject_team->linkedin;?>" target="_blank"><i class="fa fa-instagram"></i></a><?php }?>
                                            <?php if($cs_xmlObject_team->google_plus <> ''){?><a href="<?php echo $cs_xmlObject_team->google_plus;?>" target="_blank"><i class="fa fa-google-plus"></i></a><?php }?>
                                            
                                       <?php
										if($cs_node->var_pb_team_view == 'listing'){
											 if($cs_xmlObject_team->var_cp_email <> ''){
												  echo '<p><a href="mailto:'.$cs_xmlObject_team->var_cp_email.'">'.$cs_xmlObject_team->var_cp_email.'</p>';
											 }
											?>
                                           <div class="share"><a class=" addthis_button_compact"><i class="fa fa-share-square-o"></i></a></div>
                                       <?php }?>
                                        </div>    
                                </div>
                            </article>
                                
						<?php endwhile;	
						
					?>
                    </div> 
                    
                    
                <?php
				 $qrystr = '';
				   if ( $cs_node->var_pb_team_pagination == "Show Pagination" and $post_count > $cs_node->var_pb_team_per_page and $cs_node->var_pb_team_per_page > 0 ) {
				
						if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
							echo cs_pagination($post_count, $cs_node->var_pb_team_per_page,$qrystr);
					}
				
				
				}?>
                  <!-- Our Classes Close -->
				
            
</div>