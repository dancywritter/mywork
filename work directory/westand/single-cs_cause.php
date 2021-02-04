<?php

	cs_slider_gallery_template_redirect();

	global $cs_node,$cs_theme_option,$cs_counter_node,$cs_video_width;

	$cs_node = new stdClass();

  	get_header();

	$cs_layout = '';
	$cause_status = '';
	$cause_end_date = '';

	if (have_posts()):

		while (have_posts()) : the_post();

			$cs_xmlObject_transaction = new stdclass();

			$cs_menu = get_post_meta($post->ID, "cs_cause_meta", true);
			$cause_end_date = get_post_meta($post->ID, "cause_end_date", true);

			$percentage_amount = 0;

			$payment_gross = 0;

			if ( $cs_menu <> "" ) {

				$cs_xmlObject = new SimpleXMLElement($cs_menu);

				$cs_layout = $cs_xmlObject->sidebar_layout->cs_layout;

				$cs_sidebar_left = $cs_xmlObject->sidebar_layout->cs_sidebar_left;

				$cs_sidebar_right = $cs_xmlObject->sidebar_layout->cs_sidebar_right;

				if ( $cs_layout == "left") {

					$cs_layout = "content-right col-md-9";

				}

				else if ( $cs_layout == "right" ) {

					$cs_layout = "content-left col-md-9";

				}

				else {

					$cs_layout = "col-md-12";

				}

					$sub_title = $cs_xmlObject->sub_title;

					$cause_social_share = $cs_xmlObject->cause_social_share;

					$cause_goal_amount = $cs_xmlObject->cause_goal_amount;

					$payment_gross_total = 0;

					$cause_related = $cs_xmlObject->cause_related;

					$cause_related_post_title = $cs_xmlObject->cause_related_post_title;

					

				 $cause_raised_amount = $payment_gross_total;

 			}

			else {

				$sub_title = '';

				$cause_social_share = '';

				$cause_related = '';

				$cause_related_post_title = '';

				$cause_goal_amount = '0';

				$cause_raised_amount = '0';

				$cs_layout = "col-md-12";

		

 			}		

			$cs_cause = get_post_meta($post->ID, "cs_cause_transaction_meta", true);

			if ( $cs_cause <> "" ) {

				$cs_xmlObject_transaction = new SimpleXMLElement($cs_cause);

				$payment_gross = get_post_meta( $post->ID, 'cs_cause_raised_amount', true );

				$payment_gross = 0;

				$percentage_amount = 0;

				if(count($cs_xmlObject_transaction->transaction)>0){

						foreach ( $cs_xmlObject_transaction->transaction as $transct ){

								$payment_gross = $payment_gross+$transct->payment_gross;

						}

				 }
				$percentage_amount = '200';
				if($payment_gross<>'0' && $cs_xmlObject->cause_goal_amount <> '0'){

						$percentage_amount = (($payment_gross/$cs_xmlObject->cause_goal_amount)*100);

						if($percentage_amount>100 || $percentage_amount == '100'){

							$percentage_amount = 100;
							if($cs_theme_option['trans_switcher'] == "on"){ $cause_status = __('Closed','WeStand');}else{ $cause_status = $cs_theme_option['cause_status']; }

						}

					}
			if(strtotime($cause_end_date) < strtotime(date('m/d/Y'))){
				if($cs_theme_option['trans_switcher'] == "on"){ $cause_status = __('Closed','WeStand');}else{ $cause_status = $cs_theme_option['cause_status']; }
				
			}

			} else {

				$percentage_amount = 0;

				$payment_gross = 0;

			}

			$image_url = cs_attachment_image_src(get_post_thumbnail_id($post->ID), 716, 393);		

			?>

                        <?php if ($cs_layout == 'content-right col-md-9'){ ?>

                            <aside class="sidebar-left col-md-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_left) ) : ?><?php endif; ?></aside>

                        <?php } ?>

                        <!--Left Sidebar End-->

                        <!-- Blog Detail Start -->

                        <div class="<?php echo $cs_layout; ?>">

                        
                            <div class="element_size_100">
                                <div class="causes causes-detail">
                                    <article class="detail-figure">
                                    	<?php if($image_url <> ""){?><figure><img src="<?php echo $image_url;?>" alt=""></figure><?php }?>
                                        <div class="bottom-cause">
                                            <div class="cause-left"><span class="cs-colr"><?php echo $cs_theme_option['paypal_currency_sign'];?><?php echo number_format($payment_gross);?></span> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Raised','WeStand');}else{ echo $cs_theme_option['cause_raised']; }?></div>
                                            <div class="cause-right">
                                                <div class="progress-wrap">
                                                    <div class="progress-bar-charity" data-loadbar="<?php echo round($percentage_amount);?>" data-loadbar-text="<?php echo round($percentage_amount);?>%">
                                                        <div class="cs-bgcolr"></div>
                                                    </div>
                                                </div>
                                                <div class="progress-desc">
                                                    <span class="progress-box-left"> <?php if($cs_theme_option['trans_switcher'] == "on"){ $trans_featured = _e('Goal','WeStand');}else{ echo $cs_theme_option['cause_goal']; }?> <?php echo $cs_theme_option['paypal_currency_sign'];?><?php echo number_format((float)$cs_xmlObject->cause_goal_amount);?> </span>
                                                    <?php if($percentage_amount <> ''){?><span class="progress-box-right"><?php echo  round($percentage_amount);?>% Funded</span><?php }?>
                                                </div>
                                             <?php if(isset($cause_status) && $cause_status <> ''){
												 		echo '<span class="btn cs-btn-donate cs-bgcolrhvr">'.$cause_status.' </span>';	
											 	} else {?>
                                                <a href="#" class="btn cs-btn-donate cs-bgcolrhvr" data-toggle="modal" data-target="#CausemyModal2<?php echo $post->ID;?>"><?php if($cs_theme_option['trans_switcher'] == "on"){ $trans_featured = _e('Donate Now','WeStand');}else{ echo $cs_theme_option['cause_donate']; }?></a>
                                             <?php }?>
                                            </div>
                                        </div>
                                         <?php 
											if(isset($cause_status) && $cause_status == ''){
												if(isset($cs_xmlObject->cause_paypal_email) && $cs_xmlObject->cause_paypal_email <> ''){
													cs_donate_button($cs_xmlObject->cause_paypal_email);
												} else {
													cs_donate_button();
												}
											}
											?>
                                        <div class="detail-text rich_editor_text">
                                           <?php 
										   the_content();
											wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'WeStand' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
											if ( $cs_cause <> "" ) {
									if(isset($cs_xmlObject->cs_donations_show) &&  $cs_xmlObject->cs_donations_show == 'on'){
									if(count($cs_xmlObject_transaction->transaction)>0){

							 		?>

                                    <div class="donar-table">

                                        <h2 class="cs-section-title"><?php if($cs_theme_option['trans_switcher'] == "on"){ $trans_featured = _e('Donors','WeStand');}else{ echo $cs_theme_option['cause_donors']; }?></h2>

                                        <ul>

                                        	<?php 

											$cause_cout=1;

											foreach ( $cs_xmlObject_transaction->transaction as $transct ){

											?>

                                            <li><span class="counter"><?php echo $cause_cout;?></span><a><?php echo $transct->address_name;?></a><p><span><?php echo $transct->payment_gross;?> <?php echo $cs_theme_option['paypal_currency'];?></span><a><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Donation','WeStand');}else{ echo $cs_theme_option['cause_donation']; }?></a></p></li>

                                            <?php $cause_cout++;}?>

                                        </ul>

                                    </div>

                                    <?php }
									}}?>
                                        </div>
                                    </article>
                                </div>
                             <?php 
							 	if(isset($cs_xmlObject->post_tags_show) &&  $cs_xmlObject->post_tags_show == 'on'){
                                    /* translators: used between list items, there is a space after the comma */
									$before_cat = "<div class='post-tags'><h6><i class='fa fa-tags'></i>".__('Tags','WeStand')."</h6>";
                                   // $before_cat = "<i class='fa fa-tags'></i>";
                                    $categories_list = get_the_term_list ( get_the_id(), 'cs_cause-tag', $before_cat, ' ', '</div>' );
                                    if ( $categories_list ){
                                        printf( __( '%1$s', 'WeStand'),$categories_list );
                                    } // End if categories 
								}
                                ?>
                            
                            <div class="share-post">
                            	<?php 
								if ($cs_xmlObject->cause_social_share == "on"){
									cs_addthis_script_init_method();
								?>
                                <a class="addthis_button_compact btnshare"><i class="fa fa-share-square-o"></i><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Sahre','WeStand');}else{ echo $cs_theme_option['trans_share_this_post']; } ?> </a>
                                <?php
								}
								?>
                                <?php if(isset($cs_xmlObject->post_pagination_show) &&  $cs_xmlObject->post_pagination_show == 'on'){px_next_prev_custom_links('cs_cause'); }?>
                            </div>
                            <?php if (isset($cs_xmlObject->post_author_info_show) && $cs_xmlObject->post_author_info_show == "on"){?>
                            	<!-- About Author Section -->
                                <div class="about-author">
                                    <figure><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('PixFill_author_bio_avatar_size', 59)); ?></a></figure>
                                    <div class="text">
                                        <h4><?php echo get_the_author(); ?></h4>
                                        <p><?php the_author_meta('description'); ?></p>
                                        <?php if(get_the_author_meta('twitter') <> ''){?><a class="follow-tweet" href="http://twitter.com/<?php the_author_meta('twitter'); ?>"><i class="fa fa-twitter"></i>@<?php the_author_meta('twitter'); ?></a><?php }?>
                                    </div>
                                </div>
                            <!-- About Author Section Close -->
                          <?php }?>
                          <?php comments_template('', true); ?>  
                           
                        </div>
                         	
				</div>
                <!--Content Area End-->
                <!--Right Sidebar Starts-->

                <?php if ( $cs_layout  == 'content-left col-md-9'){ ?>

                    <aside class="sidebar-right col-md-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_right) ) : ?><?php endif; ?></aside>

                <?php } ?>

		  		<?php endwhile;   endif;?>

         

			<!-- Columns End -->

<!--Footer-->

<?php get_footer(); ?>

