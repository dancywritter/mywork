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
		$px_layout = $px_xmlObject->sidebar_layout->px_layout;
		if ( $px_layout == "left") {
			$px_layout = "col-md-9";
 		}
		else if ( $px_layout == "right" ) {
			$px_layout = "col-md-9";
 		}
		else {
			$px_layout = "col-md-12";
		}
 	}else{
		$px_layout = "col-md-12";
		$image_url = '';
		$px_xmlObject = new stdClass();
		$px_xmlObject->var_pb_post_social_sharing = '';
	}
	$width = 700;
	$height = 280;
	$image_url = px_get_post_img_src($post->ID, $width, $height);							
?>
		<?php if ( isset($px_xmlObject->sidebar_layout->px_layout) && $px_xmlObject->sidebar_layout->px_layout <> '' and $px_xmlObject->sidebar_layout->px_layout <> "none" and $px_xmlObject->sidebar_layout->px_layout == 'left') : ?>
                <aside class="col-md-3">
                        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($px_xmlObject->sidebar_layout->px_sidebar_left) ) : endif; ?>
                 </aside>
        <?php wp_reset_query(); endif; ?>
            <div class="<?php echo $px_layout;?>">
                    <div class="blog blog-detail sing-page-area">
                    	<div class="breadcrumbs">
                        <article class="detail-figure">
                            <?php if($image_url <> ''){?>
                                <figure>
                                    <img src="<?php echo $image_url;?>" alt="<?php the_title();?>">
                                </figure>
                            <?php }?>
                            <h1 class="pix-page-title"><?php the_title();?></h1>
                            <ul class="post-pannel">
								<?php
								 if ($px_xmlObject->var_pb_post_social_sharing == "on"){
									 px_social_share();
								 }
								  $px_like_counter = '';
									$px_like_counter = get_post_meta(get_the_id(), "px_like_counter", true);
									if ( !isset($px_like_counter) or empty($px_like_counter) ) $px_like_counter = 0;
									if ( isset($_COOKIE["px_like_counter".get_the_id()]) ) { 
									?>
									   <li><a href="#" class="likethis"><i class="fa fa-heart-o"></i><?php echo $px_like_counter;?>&nbsp;<?php if($px_theme_option['trans_switcher']== "on"){ _e('Likes','Atom Music');}else{ echo $px_theme_option['trans_likes']; } ?></a></li>
								<?php	
									} else {?>
									  <li><a  class="likethis" href="javascript:px_like_counter('<?php echo get_template_directory_uri()?>',<?php echo get_the_id()?>)" id="like_this<?php echo get_the_id()?>" ><i class="fa fa-heart-o"></i> <span class="count-numbers like_counter<?php echo get_the_id()?>"><?php echo $px_like_counter; ?></span> <?php if($px_theme_option['trans_switcher']== "on"){ _e('Likes','Atom Music');}else{ echo $px_theme_option['trans_likes']; } ?></a>
										<a class="likes likethis" id="you_liked<?php echo get_the_id()?>" style="display:none;"><i class="fa fa-heart-o"></i><span class="count-numbers like_counter<?php echo get_the_id()?>"><?php echo $px_like_counter; ?></span> <?php if($px_theme_option['trans_switcher']== "on"){ _e('Likes','Atom Music');}else{ echo $px_theme_option['trans_likes']; } ?></a>
										<div id="loading_div<?php echo get_the_id()?>" style="display:none;"><i class="fa fa-spin"></i></div>
                                 </li>
								<?php }?>
                               <?php if ( comments_open($post->ID) ) { ?>
                                				<li><a href="#comments"><i class="fa fa-comments"></i></a></li>
                               <?php }?>
                            </ul>
                           <div class="post-wrapper">
                                <ul class="pix-post-options">
                                	<li>
                                    	<span><?php if($px_theme_option['trans_switcher'] == "on"){ _e('Posted on','Deejay');}else{ echo $px_theme_option['trans_posted_on']; } ?></span> <time datetime="2020-02-14"><?php echo get_the_date();?></time>
                                    </li>
                                    <li> <span><?php if($px_theme_option['trans_switcher'] == "on"){ _e('in','Deejay');}else{ echo $px_theme_option['trans_listed_in']; } ?></span>
                                    <?php
                                          $before_cat = " ".__( '','Deejay')."";
                                          $categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '' );
                                          if ( $categories_list ){
                                              printf( __( '%1$s', 'Deejay'),$categories_list );
                                          }
                                      ?>
                                      </li>
                                </ul>
                                <?php px_next_prev_post();?>
                            </div>
                           </article>
                           </div>
                           <div class="detail-text rich_editor_text">
                               <?php 
                                the_content();
                                wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Deejay' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
                               ?>
                            </div>
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
							printf( __( '%1$s', 'Deejay'),$tags_list ); 
						} // End if tags 
						 ?>
                    </div>
                    <!-- Share Post Close -->
                    <?php 
                    if(isset($px_xmlObject->var_pb_post_author) && $px_xmlObject->var_pb_post_author <> ''){
                        px_author_description();
                    }
                    comments_template('', true); 
                    
                    ?>
            </div>
            <?php
			if ( isset($px_xmlObject->sidebar_layout->px_layout) && $px_xmlObject->sidebar_layout->px_layout <> '' and $px_xmlObject->sidebar_layout->px_layout <> "none" and $px_xmlObject->sidebar_layout->px_layout == 'right') : ?>
                <aside class="col-md-3">
                        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($px_xmlObject->sidebar_layout->px_sidebar_right) ) : endif; ?>
                 </aside>
            <?php 
			wp_reset_query();
			endif;
			
		 endwhile;   endif;
	get_footer();