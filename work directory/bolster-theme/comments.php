<?php
if ( comments_open() ) {
	if ( post_password_required() ) return;
?>
<div id="comments">
				 <header>
					<h3 class="float-left section-title cs-heading-color"><?php echo comments_number(__('No Comments', 'Bolster'), __('1 Comment', 'Bolster'), __('% Comments', 'Bolster') );?></h3>
                    <a href="#leavecomment" class="btn float-right btn-toggle" ><?php _e('Leave a Reply', 'Bolster'); ?></a> 
				</header>
                 <div id="leavecomment" class="contactform"> 
					<?php 
						global $post_id;
						$you_may_use = __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'Bolster');
						$must_login = __( 'You must be <a href="%s">logged in</a> to post a comment.', 'Bolster');
						$logged_in_as = __('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'Bolster');
						$required_fields_mark = ' ' . __('%s', 'Bolster');
						$required_text = sprintf($required_fields_mark , '' );
				
						$defaults = array( 'fields' => apply_filters( 'comment_form_default_fields', 
                        array(
							'notes' => '<p class="comment-notes">
										'.__('Your email address will not be published.', 'Bolster').'
									</p>',
							'author' => '<p class="comment-form-author fullwidth"> <span>'.
							'<input id="author" name="author" class="nameinput" type="text" value="' . __( 'Name', 'Bolster') . '"  size="30" tabindex="1"  />' .
							'<em class="fa fa-user">&nbsp;</em></span></p><!-- #form-section-author .form-section -->',
							
							'email'  => '<p class="comment-form-email fullwidth"><span>' .
							'<input id="email" name="email" class="emailinput" type="text"  value="' . 
							__( 'Email', 'Bolster') . '" size="30" tabindex="2"/>' .
							'<em class="fa fa-envelope">&nbsp;</em></span></p><!-- #form-section-email .form-section -->',
							
							'url'    => '<p class="comment-form-website fullwidth"><span>' .
							'<input id="url" name="url" type="text" class="websiteinput"  value="' . __( 'Website', 'Bolster') . '" size="30" tabindex="3" />' .
							'<em class="fa fa-link">&nbsp;</em></span></p><!-- #<span class="hiddenSpellError" pre="">form-section-url</span> .form-section -->' ) ),
							
							'comment_field' => '<p class="comment-form-comment fullwidth"><span>'.
							'<textarea id="comment" name="comment"  class="commenttextarea" rows="4" cols="39"></textarea>' .
							'</span></p><!-- #form-section-comment .form-section -->',
							
							'must_log_in' => '<p class="must-log-in">' .  sprintf( $must_login,	wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
							'logged_in_as' => '<p class="logged-in-as">' . sprintf( $logged_in_as, admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ),
							'comment_notes_before' => '',
							'comment_notes_after' =>  '',
							'id_form' => 'commentform',
							'id_submit' => 'submit-comment',
							'title_reply' => __( 'Leave a Reply', 'Bolster' ),
							'title_reply_to' => __( 'Leave a Reply to %s', 'Bolster' ),
							'cancel_reply_link' => __( 'Cancel reply', 'Bolster' ),
							'label_submit' => __( 'Submit', 'Bolster' ),); 
							comment_form($defaults, $post_id); 
						?>
        		 </div>
                  <div class="commentscroll">
                 <ul>
                    <?php wp_list_comments( array( 'callback' => 'cs_comment' ) );	?>
                </ul>
                </div>
				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
					<div class="navigation">
						<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'Bolster') ); ?></div>
						<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'Bolster') ); ?></div>
					</div> <!-- .navigation -->
				<?php endif; // check for comment navigation ?>
                
				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
                    <div class="navigation">
                        <div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'Bolster') ); ?></div>
                        <div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'Bolster') ); ?></div>
                    </div><!-- .navigation -->
                <?php endif; ?>
			</div>
<?php }?>
