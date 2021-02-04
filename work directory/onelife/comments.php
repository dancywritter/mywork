<script type="text/javascript">
		jQuery(document).ready(function(){
			cs_form_element();
 		});
</script>
<?php
if ( comments_open() ) {
	if ( post_password_required() ) return;
?>
		<?php if ( have_comments() ) : ?>
			<div id="comments">
				 <header class="heading">
					<h2 class="heading-color section-title"><?php echo comments_number(__('No Comments', 'OneLife'), __('1 Comment', 'OneLife'), __('% Comments', 'OneLife') );?></h2>
				</header>
                 <ul>
                    <?php wp_list_comments( array( 'callback' => 'PixFill_comment' ) );	?>
                </ul>
				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
					<div class="navigation">
						<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'OneLife') ); ?></div>
						<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'OneLife') ); ?></div>
					</div> <!-- .navigation -->
				<?php endif; // check for comment navigation ?>
                
				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
                    <div class="navigation">
                        <div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'OneLife') ); ?></div>
                        <div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'OneLife') ); ?></div>
                    </div><!-- .navigation -->
                <?php endif; ?>
			</div>
		<?php endif; // end have_comments() ?>
	
	<div id="respond">
			<?php 
			global $post_id;
			$you_may_use = __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'OneLife');
			$must_login = __( 'You must be <a href="%s">logged in</a> to post a comment.', 'OneLife');
			$logged_in_as = __('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'OneLife');
			$required_fields_mark = ' ' . __('Required fields are marked %s', 'OneLife');
			$required_text = sprintf($required_fields_mark , '<span class="required">*</span>' );
	
			$defaults = array( 'fields' => apply_filters( 'comment_form_default_fields', 
				array(
					'notes' => '<p class="comment-notes">
                                Your email is <em>never</em> published nor shared. Required fields are marked <span class="required">(Required)</span>
                            </p>',
					'author' => '<p class="comment-form-author">'.
					'<input id="author" name="author" class="nameinput" type="text" value="' . __( 'Name', 'OneLife') . '"  size="30" tabindex="1"  /><label for="author">'.( $req ? '*' : '' ) .'</label>' .
					'</p><!-- #form-section-author .form-section -->',
					
					'email'  => '<p class="comment-form-email">' .
					'<input id="email" name="email" class="emailinput" type="text"  value="' . 
					__( 'Email', 'OneLife') . '" size="30" tabindex="2"/><label for="email">'.( $req ? '*' : '' ) .'</label>' .
					'</p><!-- #form-section-email .form-section -->',
					
					'url'    => '<p class="comment-form-website">' .
					'<input id="url" name="url" type="text" class="websiteinput"  value="' . __( 'Website', 'OneLife') . '" size="30" tabindex="3" /><label for="url">'.( $req ? '*' : '' ) .'</label>' .
					'</p><!-- #<span class="hiddenSpellError" pre="">form-section-url</span> -->' ) ),
					
					'comment_field' => '<p class="comment-form-comment fullwidth">'.
					'<textarea id="comment" name="comment"  class="commenttextarea" rows="4" cols="39">'.__( 'Comment: ', 'OneLife'). '</textarea><label for="comment">'.( $req ? '*' : '' ) .'</label>' .
					'</p><!-- #form-section-comment .form-section -->',
					
					'must_log_in' => '<p class="must-log-in">' .  sprintf( $must_login,	wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
					'logged_in_as' => '<p class="logged-in-as">' . sprintf( $logged_in_as, admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ),
					'comment_notes_before' => '',
					'comment_notes_after' =>  '',
					'id_form' => 'commentform',
					'id_submit' => 'submit-comment',
					'title_reply' => __( 'Leave a Reply', 'OneLife' ),
					'title_reply_to' => __( 'Leave a Reply to %s', 'OneLife' ),
					'cancel_reply_link' => __( 'Cancel reply', 'OneLife' ),
					'label_submit' => __( 'Post Comment', 'OneLife' ),); 
					comment_form($defaults, $post_id); 
				?>
	 </div>
<?php }?>