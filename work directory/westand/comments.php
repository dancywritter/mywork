<?php
global $cs_theme_option;
if ( comments_open() ) {
	if ( post_password_required() ) return;
?>
		<?php if ( have_comments() ) : ?>
			<div id="comments">
				 <header class="cs-heading-title">
					<h2 class="cs-section-title"><?php echo comments_number(__('No Comments', 'WeStand'), __('1 Comment', 'WeStand'), __('% Comments', 'WeStand') );?></h2>
				</header>
                 <ul>
                    <?php wp_list_comments( array( 'callback' => 'cs_comment' ) );	?>
                </ul>
				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
					<div class="navigation">
						<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'WeStand') ); ?></div>
						<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'WeStand') ); ?></div>
					</div> <!-- .navigation -->
				<?php endif; // check for comment navigation ?>
                
				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
                    <div class="navigation">
                        <div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'WeStand') ); ?></div>
                        <div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'WeStand') ); ?></div>
                    </div><!-- .navigation -->
                <?php endif; ?>
			</div>
		<?php endif; // end have_comments() ?>
	
 			<?php 
			global $post_id;
			$you_may_use = __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'WeStand');
			$must_login = __( 'You must be <a href="%s">logged in</a> to post a comment.', 'WeStand');
			$logged_in_as = __('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'WeStand');
			$required_fields_mark = ' ' . __('Required fields are marked %s', 'WeStand');
			$required_text = sprintf($required_fields_mark , '<span class="required">*</span>' );
	
			$defaults = array( 'fields' => apply_filters( 'comment_form_default_fields', 
				array(
					'notes' => '<p class="comment-notes">
                            </p>',
					'author' => '<p class="comment-form-author">'.
					'<span class="icon-input" for="author">' . __( '', 'WeStand').
					''.( $req ? __( '', 'WeStand') : '' ) .'<input id="author" name="author" class="nameinput" type="text" value="Name"' .
					esc_attr( $commenter['comment_author'] ) . '" size="30" tabindex="1"  />' .
					'<i class="fa fa-user"></i></span></p><!-- #form-section-author .form-section -->',
					
					'email'  => '<p class="comment-form-email">' .
					'<span class="icon-input" for="email">'. __( '', 'WeStand').
					''.( $req ? __( '', 'WeStand') : '' ) .''.
					'<input id="email" name="email" class="emailinput" type="text"  value="Email"' . 
					esc_attr(  $commenter['comment_author_email'] ) . '" size="30" tabindex="2"/>' .
					'<i class="fa fa-phone"></i></span></p><!-- #form-section-email .form-section -->',
					
					'url'    => '<p class="comment-form-website">' .
					'<span class="icon-input" for="url">' . __( '', 'WeStand') . '' .
					'<input id="url" name="url" type="text" class="websiteinput"  value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" tabindex="3" />' .
					'<i class="fa fa-envelope-o"></i></span></p><!-- #<span class="hiddenSpellError" pre="">form-section-url</span> .form-section -->' ) ),
					
					'comment_field' => '<p class="comment-form-comment fullwidth">'.
					''.__( '', 'WeStand'). ''.( $req ? __( '', 'WeStand') : '' ) .'' .
					'<textarea id="comment" name="comment"  class="commenttextarea" rows="4" cols="39">message</textarea>' .
					'</p><!-- #form-section-comment .form-section -->',
					
					'must_log_in' => '<p class="must-log-in">' .  sprintf( $must_login,	wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
					'logged_in_as' => '<p class="logged-in-as">' . sprintf( $logged_in_as, admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ),
					'comment_notes_before' => '',
					'comment_notes_after' =>  '',
					'class_form' => 'comform',
					'id_form' => 'commentform',
					'id_submit' => 'submit-comment',
					'title_reply' => __( 'Leave a Comment', 'WeStand' ),
					'title_reply_to' => __( 'Leave a Reply to %s', 'WeStand' ),
					'cancel_reply_link' => __( 'Cancel reply', 'WeStand' ),
					'label_submit' => __( 'Submit', 'WeStand' ),); 
					comment_form($defaults, $post_id); 
				?>
				
 <?php }?>