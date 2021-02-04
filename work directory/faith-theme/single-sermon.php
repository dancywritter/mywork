<?php
global $cs_node, $header_banner, $cs_theme_option, $counter_node, $element_size_class;
get_header();
$cs_layout = '';
$post_xml = get_post_meta($post->ID, "cs_sermon", true);
if ( $post_xml <> "" ) {
	$cs_xmlObject = new SimpleXMLElement($post_xml);
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
}else{
	$cs_layout = "col-md-12";
}
?>

    <!--Left Sidebar Starts-->
    <?php if ($cs_layout == 'content-right col-md-9'){ ?>
    <div class="col-lg-3 col-md-3 col-sm-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_left) ) : ?><?php endif; ?></div>
    <?php } ?>
    <!--Left Sidebar End-->
    <!-- Sermon Detail Start -->
    <div class="<?php echo $cs_layout; ?>">
        <div class="sermons sermons-detail">
            <!-- Sermons Inn Start -->
            <?php
            if (have_posts()):
                while (have_posts()) : the_post();
                    $post_xml = get_post_meta($post->ID, "cs_sermon", true);
                    if ($post_xml <> "") {
                        $cs_xmlObject = new SimpleXMLElement($post_xml);
                        
                        $image_url = cs_get_post_img_src($post->ID, 1058, 364);
                    }
                    ?>
                    <article>
                    	<?php if($image_url <> "" or $cs_xmlObject->sermon_audio_url <> ""){ ?>
                        <div class="detail-figure">
                        	<?php if($image_url <> ""){ ?>
                            <figure>
                                <img alt="" src="<?php echo $image_url; ?>">
                            </figure>
                            <?php 
							} 
							if($cs_xmlObject->sermon_audio_url <> ""){
							?>
                            <div class="post-player fullwidth">
                                <audio width="101%" src="<?php echo $cs_xmlObject->sermon_audio_url; ?>"></audio>
                            </div>
                            <?php } ?>
                        </div>
                        <?php } ?>
                        
                        <?php if($cs_xmlObject->sermon_script_url <> "" or $cs_xmlObject->sermon_download_url <> ""){ ?>
                        <div class="cs-options-panel">
                        	<?php if($cs_xmlObject->sermon_script_url <> ""){ ?>
                            <a href="<?php echo $cs_xmlObject->sermon_script_url; ?>"> <i class="fa fa-book"></i> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Study Guide','Faith'); }else{ echo $cs_theme_option['trans_sermon_study']; } ?></a>
                            <?php 
							}
							if($cs_xmlObject->sermon_download_url <> ""){ 
							?>
                            <a href="<?php echo $cs_xmlObject->sermon_download_url; ?>"> <i class="fa fa-download"></i> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Download Mp3','Faith'); }else{ echo $cs_theme_option['trans_sermon_download']; } ?></a>
                            <?php } ?>
                            <?php if($cs_xmlObject->sermon_price_amount <> ""){  ?>
                                 <?php if($cs_xmlObject->sermon_buy_url <> ""){  ?>
                                         <a class="cs-bgcolr float-right cs-buysermon" href="<?php echo $cs_xmlObject->sermon_buy_url; ?>" target="_blank"><i class="fa fa-shopping-cart"></i>
										 <strong><?php echo $cs_xmlObject->sermon_price_amount; ?></strong>
										  <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Buy full Sermon','Faith'); }else{ echo $cs_theme_option['trans_sermon_buy']; } ?></a> 
                                        <?php } ?>
                                 <?php } ?>
                        </div>
                        <?php } ?>
                        <div class="detail-text rich_editor_text">
                            <?php the_content(); ?>
                        </div>
                    </article>
                    
                    <div class="share-post">
                        <div class="cs-post-top-section">
                        	<div class="cs-share-comment-link">
							   <?php 
                                if ($cs_xmlObject->sermon_social_sharing == "on"){
                                    cs_addthis_script_init_method();
                                ?>
                                <a class="addthis_button_compact backcolrhover" href="#">
                                    <i class="fa fa-share-square-o"></i>
                                    <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Share post','Faith');}else{ echo $cs_theme_option['trans_share_this_post']; } ?> </a>
                                <?php
                                }
                                if ( comments_open() ) {
                                ?>
                                <a href="#respond"><i class="fa fa-comments"></i><?php _e('Leave a Reply','Faith'); ?></a>
                                <?php
                                }
                                ?>
                                </div>
                        </div>
                    </div>
                    
                    <?php 
					echo cs_next_prev_post();
					
					if ($cs_xmlObject->sermon_author_description == "on"){
						cs_author_description();
					}
					
                    comments_template('', true);
            endwhile;
        endif;
		wp_reset_query();
        ?>
        </div>
    </div>
    
    <!--Right Sidebar Starts-->
    <?php if ( $cs_layout  == 'content-left col-md-9'){ ?>
        <div class="col-lg-3 col-md-3 col-sm-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_right) ) : ?><?php endif; ?></div>
    <?php } ?>
    <!---------Right Sidebar End----------->
<?php get_footer(); ?>