<?php
	px_slider_gallery_template_redirect();
	global $px_theme_option;
  	get_header();
	$px_layout = '';
if (have_posts()):
	while (have_posts()) : the_post();
	$post_xml = get_post_meta($post->ID, "post", true);	
	if ( $post_xml <> "" ) {
		$px_xmlObject = new SimpleXMLElement($post_xml);
		
 	}else{
		$px_layout = "col-md-12";
		$image_url = '';
		$px_xmlObject = new stdClass();
		$px_xmlObject->var_pb_post_social_sharing = '';
	}

	$width = 742;
	$height = 378;
	$image_url = px_get_post_img_src($post->ID, $width, $height);							
?>
            
            <div class="blog blog-detail sing-page-area">
                <article class="detail-figure">
                	<?php if($image_url <> ''){?>
                    <figure>
                        <img src="<?php echo $image_url;?>" alt="<?php the_title();?>">
                    </figure>
                    <?php }?>
                    <header class="pix-heading-title">
                        <h2 class="pix-section-title"><?php the_title();?></h2>
                    </header>
                    <ul class="post-options">
                        <li><span><?php if($px_theme_option['trans_switcher'] == "on"){ _e('Posted on','Church Life');}else{ echo $px_theme_option['trans_posted_on']; } ?></span> <time datetime="2020-02-14"><?php echo get_the_date();?></time>, <span><?php if($px_theme_option['trans_switcher'] == "on"){ _e('in','Church Life');}else{ echo $px_theme_option['trans_listed_in']; } ?></span>
                        <?php
                              $before_cat = " ".__( '','Church Life')."";
                              $categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '' );
                              if ( $categories_list ){
                                  printf( __( '%1$s', 'Church Life'),$categories_list );
                              }
                          ?>
                          </li>
                    </ul>
                    <div class="detail-text rich_editor_text">
                    <?php if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'on'){?>
							<script type="text/javascript" charset="utf-8">
                                jQuery("audio, video") .mediaelementplayer();
                            </script>
                    <?php }?>
                       <?php 
                        the_content();
                        wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Church Life' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                       ?>
                    </div>
                   </article>
            </div>
            <?php 
			$args = array(
			   'post_type' => 'attachment',
			   'numberposts' => -1,
			   'post_status' => null,
			   'post_parent' => $post->ID
			  );
			  $attachments = get_posts( $args );
				 if ( $attachments ) {
					 ?>
            <div class="pix-media-attachment mediaelements-post fullwidth lightbox">
							<?php 
                                     px_enqueue_gallery_style_script();
                                    foreach ( $attachments as $attachment ) {
                                        $attachment_title = apply_filters( 'the_title', $attachment->post_title );
                                       $type = get_post_mime_type( $attachment->ID );
                                       if($type=='image/jpeg'){
                                          ?>
                                           <a <?php if ( $attachment_title <> '' ) { echo 'data-title="'.$attachment_title.'"'; }?> href="<?php echo $attachment->guid; ?>" data-rel="<?php echo "prettyPhoto[gallery1]"?>" class="me-imgbox"><?php echo wp_get_attachment_image( $attachment->ID, array(270,152),true ) ?></a>
                                        <?php
										
                                        } elseif($type=='audio/mpeg') {
                                            ?>
                                           <!-- Button to trigger modal -->
                                            <a href="#audioattachment<?php echo $attachment->ID;?>" role="button" data-toggle="modal" class="iconbox"><i class="fa fa-microphone"></i></a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="audioattachment<?php echo $attachment->ID;?>" tabindex="-1" role="dialog" aria-hidden="true">
                                            	<div class="modal-dialog">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                      </div>
                                                      <div class="modal-body">
                                                       <audio style="width:100%;" src="<?php echo $attachment->guid; ?>" type="audio/mp3" controls="controls"></audio>
                                                        
                                                      </div>
                                                      
                                                    </div><!-- /.modal-content -->
                                                  </div>
                                            
                                            </div>
                                        
                                        <?php
                                        } elseif($type=='video/mp4') {
                                         ?>
                                            <a href="#videoattachment<?php echo $attachment->ID;?>" role="button" data-toggle="modal" class="iconbox"><i class="fa fa-video-camera"></i></a>
                                            <div class="modal fade" id="videoattachment<?php echo $attachment->ID;?>" tabindex="-1" role="dialog" aria-hidden="true">
                                            	<div class="modal-dialog">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                      </div>
                                                      <div class="modal-body">
                                                        <video width="100%" height="360" poster="">
                                                                <source src="<?php echo $attachment->guid; ?>" type="video/mp4" title="mp4">
                                                        </video>
                                                        
                                                      </div>
                                                      
                                                    </div><!-- /.modal-content -->
                                                  </div>
                                            
                                            </div>
                                            
                                            
                                        <?php
                                        }
                                      }
                                 
                              ?>
                            </div>
                      <?php  }?>
             <!-- Share Post -->
            <div class="share-post">
            	<?php
						$before_tag = '<div class="post-tags"><i class="fa fa-tag"></i>';
						$tags_list = get_the_term_list ( get_the_id(), 'post_tag',$before_tag, ', ', '</div>' );
						if ( $tags_list){
							printf( __( '%1$s', 'Church Life'),$tags_list ); 
						} // End if tags 
				 if ($px_xmlObject->var_pb_post_social_sharing == "on"){
					 px_social_share();
				 }?>
            </div>
            <!-- Share Post Close -->
            <?php 
			if(isset($px_xmlObject->var_pb_post_author) && $px_xmlObject->var_pb_post_author <> ''){
				px_author_description();
			}
            comments_template('', true); 
		 endwhile;   endif;
	get_footer();