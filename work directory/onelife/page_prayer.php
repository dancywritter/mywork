<?php
global $cs_node, $post, $cs_theme_option, $cs_counter_node;
cs_enqueue_jcycle_script();
if ( !isset($cs_node->prayer_page_num) || empty($cs_node->prayer_page_num) ) { $cs_node->prayer_page_num = -1; }
?>
<div class="element_size_<?php echo $cs_node->prayer_element_size;?>">
	<?php
	if ($cs_node->prayer_title <> '') {
	?>
        <header class="heading"><h2 class="transform section-title heading-color"><?php echo $cs_node->prayer_title; ?></h2></header>
	<?php } ?>
    <div class="clearfix"></div>
	<div class="prayer">
        <?php
		wp_reset_query();
		if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
		$post_count = 0;
		$args = array( 'posts_per_page' => "-1", 'post_type' => 'prayers', 'post_status' => 'publish', 'order' => 'ASC' );
		$custom_query = new WP_Query($args);
			$post_count = $custom_query->post_count;
		$args = array( 'posts_per_page' => "$cs_node->prayer_page_num", 'paged' => $_GET['page_id_all'], 'post_type' => 'prayers', 'post_status' => 'publish', 'order' => 'ASC' );
		$custom_query = new WP_Query($args);
		while ( $custom_query->have_posts()) : $custom_query->the_post();
		?>
            <article>
                <!-- Prayer Container Start -->
                <div class="prayer-container">
                    <header>
                        <h4><?php the_title(); ?></h4>
                        <time><?php echo get_the_date(); ?></time>
                    </header>
                    <p><?php the_content(); ?></p>
                </div>
                <!-- Prayer Container End -->
                <!-- Linking Start -->
                <div class="linking relative">
                    <?php
                    $prayer_counter = get_post_meta(get_the_id(), "prayer_counter", true);
                    ?>
                    <div class="prayer_counter">
                        <a class="prayer_count">
                            <div id="prayer_counter<?php echo get_the_id()?>"><?php echo $prayer_counter?></div><span><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Times Prayed','OneLife');}else{ echo $cs_theme_option['trans_times_prayed']; } ?></span>
                        </a>
                    </div>
                    <div class="prayer-links">
                    <?php
                    $cs_prayer = get_post_meta( get_the_id(), 'cs_prayer', true);
					?>
                    <?php if ( isset($cs_prayer['email']) and !empty($cs_prayer['email']) ) { ?>
                    	<a href="mailto:<?php echo $cs_prayer['email']; ?>" class="colrhover"><i class="icon-envelope"></i><?php if($cs_theme_option['trans_switcher']== "on"){ _e('ENCOURAGE','OneLife');}else{ echo $cs_theme_option['trans_encourage']; } ?></a>
                    <?php } ?>
                    <?php if ( isset($_COOKIE["prayer_counter".get_the_id()]) ) { ?>
                        <span class="prayed"><i class="icon-heart-empty"></i><?php if($cs_theme_option['trans_switcher']== "on"){ _e('You Already Prayed','OneLife');}else{ echo $cs_theme_option['trans_already_prayed']; } ?></span>
                    <?php
                    }
                    else {
                    ?>
                        <div class="pray-this">
                            <div id="pray_this<?php echo get_the_id()?>"><i class="icon-heart-empty"></i><a class="colrhover" href="javascript:prayer_counter('<?php echo get_template_directory_uri()?>',<?php echo get_the_id()?>)"><?php if($cs_theme_option['trans_switcher']== "on"){ _e('I PRAYED FOR THIS','OneLife');}else{ echo $cs_theme_option['trans_prayed_for_this']; } ?></a></div>
                            <div id="loading_div<?php echo get_the_id()?>" style="display:none"><img src="<?php echo get_template_directory_uri()?>/images/ajax_loading.gif" alt="" /></div>
                            <div id="you_prayed<?php echo get_the_id()?>" style="display:none;"><i class="icon-heart-empty"></i><?php if($cs_theme_option['trans_switcher']== "on"){ _e('You Prayed','OneLife');}else{ echo $cs_theme_option['trans_you_prayed']; } ?></div>
                        </div>
                    <?php }?>
                </div>
                </div>
                <!-- Linking End -->
            </article>
			
		<?php endwhile;  ?>
	</div>
    <?php
	// pagination start
	$qrystr = '';
	if(cs_pagination($post_count, $cs_node->prayer_page_num, $qrystr) <> ''){
		if ( $cs_node->prayer_pagination == "Show Pagination" and $cs_node->prayer_page_num > 0 ) {
			echo "<nav class='pagination'><ul>";
				if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
				if ( isset($_GET['filter_category']) ) $qrystr .= "&filter_category=".$_GET['filter_category'];
				echo cs_pagination($post_count, $cs_node->prayer_page_num, $qrystr);
			echo "</ul></nav>";
			}
	}
	// pagination end
	?>
</div>
<div class="clear"></div>