<?php
	global $cs_node, $cs_theme_option, $counter_node;
	if ( !isset($cs_node->cs_album_per_page) || empty($cs_node->cs_album_per_page) ) { $cs_node->cs_album_per_page = -1; }
	$filter_category = '';
	$row_cat = $wpdb->get_row("SELECT * from ".$wpdb->prefix."terms WHERE slug = '" . $cs_node->cs_album_cat ."'" );
	        if ( isset($_GET['filter_category']) ) {$filter_category = $_GET['filter_category'];}
        else {
            if(isset($row_cat->slug)){
            $filter_category = $row_cat->slug;
            }
        }
?>
<div class="album element_size_<?php echo $cs_node->album_element_size;?>">
    <div class="albumsec fullwidth">
        <div class="album-descarea fullwidth">
                <div class="fullwidth title-album <?php if($cs_node->cs_album_filterable != "On"){ echo 'cs_filterable_hide'; }?>">
                    <?php if ($cs_node->cs_album_title <> '') { ?>
                    <header class="heading-2">
                        <h2 class="section-title colr  cs-heading-color"><?php echo $cs_node->cs_album_title;?></h2>
                    </header>
                    <?php }
 					?>
                    
                    <?php if($cs_node->cs_album_filterable == "On"){
                            $qrystr= "";
                            if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
                        ?>  
                        <script>
                            function reload(form){
                                var val=filterable_album.album_category.options[filterable_album.album_category.options.selectedIndex].value; 
                                if(val){
                                    self.location = val;
                                }
                            }
                        </script>
                        <form id="filterable_album" name="filterable_album" method="get" action="">
                           <select class="float-right" name="album_category"  onChange="javascript:reload();">
                               <option value="">----  
                                   <?php   
                                    if ($cs_theme_option['trans_switcher'] == "on") {
                                        _e('Filter by', "Rocky");
                                    } else {
                                        echo $cs_theme_option['trans_filter_by'];
                                    }?>
                                 -----</option>
                                 <?php if(isset($cs_node->cs_album_cat) && $cs_node->cs_album_cat <> '' && $row_cat->slug <> ''){?>
                                    <option value="?<?php echo $qrystr."&filter_category=".$row_cat->slug?>" <?php if($cs_node->cs_album_cat==$filter_category){echo 'selected="selected"';}?>><?php echo $row_cat->name;?></option>
                               <?php
                                 }	
                                    if($cs_node->cs_album_cat <> ''){
                                        $categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'album-category', 'hide_empty' => 0) );
                                    } else {
                                        $categories = get_categories( array('taxonomy' => 'album-category', 'hide_empty' => 0) );
                                    }
                                    foreach ($categories as $category) {
                                ?>
                                     <option value="?<?php echo $qrystr."&filter_category=".$category->slug?>" <?php if($category->slug==$filter_category){echo 'selected="selected"';}?>><?php echo $category->cat_name?></option>
                                  <?php 
                                    } 
                                ?>
                           </select>
                           </form>
                          <?php }?>
                    </div>
                <p><?php if(isset($cs_node->cs_album_cat) && $cs_node->cs_album_cat <> ''){echo (get_term_by('slug', "$filter_category", 'album-category')->description);}?> </p>
         </div>
                <!-- Album Listing -->
                 <?php
                        if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
                                $args = array(
                                    'posts_per_page'			=> "-1",
                                    'post_type'					=> 'albums',
                                    'post_status'				=> 'publish',
                                    'order'						=> 'ASC',
                                );
                            if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
                                $event_category_array = array('album-category' => "$filter_category");
                                $args = array_merge($args, $event_category_array);
                            }
                            $custom_query = new WP_Query($args);
                            $count_post = 0;
                           	$count_post = $custom_query->post_count;
                            if ( $cs_node->cs_event_pagination == "Single Page") { $cs_node->cs_event_per_page = $cs_node->cs_event_per_page; }?>
                                
                    <div class="album-listing <?php if($cs_node->cs_album_view == 'List View'){?>album-view-3 <?php } else { echo ' album-view-2'; }?> fullwidth">
                        <?php 
                            $args = array(
                                'posts_per_page'			=> "$cs_node->cs_album_per_page",
                                'paged'						=> $_GET['page_id_all'],
                                'post_type'					=> 'albums',
                                'post_status'				=> 'publish',
                                'order'						=> 'ASC',
                             );
                            if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
                                $event_category_array = array('album-category' => "$filter_category");
                                $args = array_merge($args, $event_category_array);
                            }
                            $custom_query = new WP_Query($args);
                            if ( $custom_query->have_posts() <> "" ) {
                                if($cs_node->cs_album_view == 'List View'){
                                            $width = 270; 
                                            $height = 270;
                                            $counter_album = 0;
                                            while ( $custom_query->have_posts() ): $custom_query->the_post();
                                            $cs_album = get_post_meta($post->ID, "cs_album", true);
                                            if ( $cs_album <> "" ) {
                                                $counter_album_tracks = 0;
                                                $cs_xmlObject = new SimpleXMLElement($cs_album);
                                                    $album_release_date_db = $cs_xmlObject->album_release_date;
                                                    $album_social_share_db = $cs_xmlObject->album_social_share;
                                                    $album_artist = (int) $album_artist = $cs_xmlObject->album_artist;
                                                    $album_buynow = $cs_xmlObject->album_buynow;
                                                    $counter_album_tracks = count($cs_xmlObject->track);
                                            }
                                            $image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID),$width,$height ); 
                                                if($image_url == ''){
                                                    $noimg = 'no-img';
                                                }else{
                                                    $noimg  ='';
                                                }
                                            ?>
                                             <article <?php post_class($noimg); ?>>
                                        <?php if($image_url <> ''){?><figure><a href="<?php the_permalink();?>"><img src="<?php echo $image_url;?>" alt=""></a></figure><?php }?>
                                        <div class="text">
                                            <h2 class="post-title"><a href="<?php the_permalink();?>" class="colrhover"><?php the_title();?></a></h2>
                                            <div class="postpanel">
                                                
                                                <ul class="post-options">
                                                <?php if(isset($cs_xmlObject->cs_album_rating) && $cs_xmlObject->cs_album_rating <> ''){?>
                                                    <li>
                                                        <div class="ratingbox">
                                                            <?php for($i=1; $i<=5; $i++){?>
                                                                    <a> <em class="<?php if($i<=$cs_xmlObject->cs_album_rating){ echo 'fa fa-star';} else { echo 'fa fa-star-o';}?>"></em></a>
                                                             <?php }?>
                                                       </div>
                                                   </li>
                                               <?php }?>
                                                    <li>
                                                        <em><?php printf(__('By: %s','Rocky'), " "); ?></em><?php echo get_the_title("$album_artist");?>
                                                        <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('on','Rocky');}else{ echo $cs_theme_option['trans_other_on']; } ?>
                                                        <time datetime="<?php echo date('j, M Y', strtotime($cs_xmlObject->album_release_date));?>"><?php echo date('d.m.Y', strtotime($cs_xmlObject->album_release_date));?></time>
                                                    </li>
                                                     <?php 
                                                        if($cs_node->cs_album_cat_show == 'On'){
                                                            $before_cat = '<li>';
                                                            $categories_list = get_the_term_list ( get_the_id(), 'album-category', $before_cat, ', ', '</li>' );
                                                            if ( $categories_list ){ printf( __( '%1$s', 'Rocky' ),$categories_list ); }
                                                        }
                                                    ?>
                                                </ul>
                                            </div>
                                           <p><?php echo cs_get_the_excerpt('289',true) ?></p>
                                            <div class="panel-button">
                                                <div class="left-pan-album">
                                                    <div class="wrapper-panel">
                                                    <a href="<?php the_permalink();?>" class="bgcolrhover"><em class="fa fa-play"></em><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Play Now','Rocky');}else{ echo $cs_theme_option['trans_album_play_now']; } ?></a>
                                                    <?php if($cs_node->cs_album_buynow == 'On'){?><a href="<?php echo $cs_xmlObject->album_buynow;?>" class="bgcolrhover"><em class="fa fa-shopping-cart"></em><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Buy Now','Rocky');}else{ echo $cs_theme_option['trans_album_buynow']; } ?></a><?php }?>
                                                    </div>
                                                </div>
                                                <a class="btn"><em class="fa fa-music"></em> <?php echo $counter_album_tracks;?> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Tracks','Rocky');}else{ echo $cs_theme_option['trans_album_tracks']; } ?></a>
                                            </div>
                                        </div>
                                    </article>
                                <?php endwhile;
                                        } else {
											cs_enqueue_jplayer();
                                            // Grid View
                                            $width = 270; 
                                            $height = 270;
                                            $counter_album = $counter_count = 0;
                                            while ( $custom_query->have_posts() ): $custom_query->the_post();
                                            $cs_album = get_post_meta($post->ID, "cs_album", true);
                                            if ( $cs_album <> "" ) {
                                                $counter_album_tracks = 0;
												$album_track_mp3_url_audio = '';
                                                $cs_xmlObject = new SimpleXMLElement($cs_album);
                                                    $album_release_date_db = $cs_xmlObject->album_release_date;
                                                    $album_social_share_db = $cs_xmlObject->album_social_share;
                                                    $album_artist = (int) $album_artist = $cs_xmlObject->album_artist;
                                                    $album_buynow = $cs_xmlObject->album_buynow;
                                                    $counter_album_tracks = count($cs_xmlObject->track);
                                                    foreach ( $cs_xmlObject->track as $track ){
                                                        if(isset($track->album_track_playable) && $track->album_track_playable == 'Yes' && $track->album_track_mp3_url <> '' && $counter_count <> '1'){
                                                            $album_track_mp3_url_audio = $track->album_track_mp3_url;
															$filetype = wp_check_filetype($album_track_mp3_url_audio);
															if($filetype['ext'] == 'mp3'){
																$counter_album_tracks++;
																break;
															}
                                                        }
                                                    }
                                            }
                                            $image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID),$width,$height ); 
                                            if($image_url == ''){
                                                $noimg = 'no-img';
                                            }else{
                                                $noimg  ='';
                                            }
                                            ?>
                                             <article <?php post_class($noimg); ?>>
                                                  <figure><?php if($image_url <> ''){?><a href="<?php the_permalink();?>"><img src="<?php echo $image_url;?>" alt=""></a><?php }?>
                                                            <figcaption>
                                                            <?php if($album_track_mp3_url_audio <> ''){?>
                                                                    <ul>
                                                                        <li>
                                                                        <div  id="jquery_jplayer_<?php echo $post->ID;?>" class="jp-jplayer"></div>
                                                                        <div  id="jp_container_<?php echo $post->ID;?>" class="jp-audio"> <a href="javascript:;" class="jp-play" tabindex="1"> <em class="fa fa-play"></em> </a> <a href="javascript:;" class="jp-pause" tabindex="1"> <em class="fa fa-pause"></em> </a> </div>
                                                                        <script type="text/javascript">
																		   //<![CDATA[
																				jQuery(document).ready(function($){
																					 album_detail_playlist('<?php echo $post->ID;?>', '<?php echo $album_track_mp3_url_audio;?>');
																				 });
																			 //]]> 
                                                                     </script> 
                                                                      </li>
                                                                    </ul>
                                                             <?php }?>
                                                             <?php if($cs_xmlObject->album_buynow <> ''){?><a href="<?php echo $cs_xmlObject->album_buynow;?>" class=""><em class="fa fa-shopping-cart"></em></a><?php }?>
                                                            </figcaption>
                                                    </figure>
                                                    <div class="text">
                                                        <h2 class="post-title"><a href="<?php the_permalink();?>" class="colrhover"><?php the_title();?></a></h2>
                                                        <p><?php printf(__('By: %s','Rocky'), " "); ?> <strong><?php echo get_the_title($album_artist);?></strong></p>
                                                         <?php 
															if($cs_node->cs_album_cat_show == 'On'){
																$before_cat = '<p>';
																$categories_list = get_the_term_list ( get_the_id(), 'album-category', $before_cat, ', ', '</p>' );
																if ( $categories_list ){ printf( __( '%1$s', 'Rocky' ),$categories_list ); }
															}
                                                    	?>
                                                        <div class="ratingbox">
                                                            <span class="stars">
                                                                <span style="width:<?php echo $cs_xmlObject->cs_album_rating*20;?>%;"></span>
                                                            </span>
                                                        </div>
                                                    </div>
                                            </article>
                                <?php
                                        endwhile;
                                        }
                                     }
                    wp_reset_query();
                ?>
                    </div>
                <!-- Album Listing Close -->
                <?php 
                //<!-- Pagination -->
                if ($cs_node->cs_album_pagination == "Show Pagination" ) {
                    $qrystr = '';
                    if(cs_pagination($count_post, $cs_node->cs_album_per_page, $qrystr) <> ''){
                        // pagination start
                        if ( $cs_node->cs_album_pagination == "Show Pagination" and $cs_node->cs_album_per_page > 0 ) {
                                if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
                                if ( isset($_GET['filter_category']) ) $qrystr .= "&filter_category=".$_GET['filter_category'];
                                echo cs_pagination($count_post, $cs_node->cs_album_per_page, $qrystr);
                            }
                 // pagination end
                    }
                }
                ?>
       </div>
</div>