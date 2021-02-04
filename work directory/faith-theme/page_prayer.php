<?php
global $cs_node, $post, $cs_theme_option, $counter_node;
if ( !isset($cs_node->prayer_page_num) || empty($cs_node->prayer_page_num) ) { $cs_node->prayer_page_num = -1; }
?>
<div class="element_size_<?php echo $cs_node->prayer_element_size;?>">
	
	<?php if ($cs_node->prayer_title <> '') { ?>
    <header class="cs-heading-title">
       <h2 class="cs-section-title float-left"><?php echo $cs_node->prayer_title;?></h2>
    </header>
    <?php }?>
	<div class="cs-prayer">
        <?php
		wp_reset_query();
		if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
		$post_count = 0;
		$args = array( 'posts_per_page' => "-1", 'post_type' => 'prayers', 'post_status' => 'publish', 'order' => 'DESC' );
		$custom_query = new WP_Query($args);
			$post_count = $custom_query->post_count;
		$args = array( 'posts_per_page' => "$cs_node->prayer_page_num", 'paged' => $_GET['page_id_all'], 'post_type' => 'prayers', 'post_status' => 'publish', 'order' => 'DESC' );
		$custom_query = new WP_Query($args);
		while ( $custom_query->have_posts()) : $custom_query->the_post();
		?>
            <article>
            	<div class="cs-prayer-post">
                <header>
                    <h4><?php the_title(); ?></h4>
                    <time><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Posted on','Faith'); }else{ echo $cs_theme_option['trans_posted_on']; } ?> <?php echo get_the_date(); ?></time>
                </header>
               <?php the_content(); ?>
                <!-- Linking Start -->
                <div class="linking relative">
					<?php if ( isset($_COOKIE["prayer_counter".get_the_id()]) ) { ?>
                        <span class="prayed"><i class="fa fa-thumbs-up "></i><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('You Already Prayed','Faith'); }else{ echo $cs_theme_option['trans_prayer_already_prayed']; } ?></span>
                    <?php
                    }
                    else {
                    ?>
                        <div class="pray-this">
                        	<i class="fa fa-thumbs-up "></i>
                            <div id="pray_this<?php echo get_the_id()?>"><a class="cs-colrhvr cs-likes" href="javascript:prayer_counter('<?php echo get_template_directory_uri()?>',<?php echo get_the_id()?>)"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('I Pray for this','Faith'); }else{ echo $cs_theme_option['trans_prayer_pray_this']; } ?></a></div>
                            <div id="loading_div<?php echo get_the_id()?>" style="display:none"><img src="<?php echo get_template_directory_uri()?>/images/ajax-loader.gif" /></div>
                        	<div id="you_prayed<?php echo get_the_id()?>" style="display:none;"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('You Prayed','Faith'); }else{ echo $cs_theme_option['trans_prayer_you_prayed']; } ?></div>
                        </div>
                    <?php }?>
					
                    <?php
                    $prayer_counter = get_post_meta(get_the_id(), "prayer_counter", true);
					if($prayer_counter == ""){ $prayer_counter = 0; }
					?>
                    <div class="prayer_counter">
                    	<a class="prayer_count colr costum_font">
                        	<div id="prayer_counter<?php echo get_the_id()?>"><?php echo $prayer_counter?></div>
                        </a>
                    </div>
                    
                    <?php
                    $cs_prayer = get_post_meta( get_the_id(), 'cs_prayer', true);
					?>
                    <?php if ( isset($cs_prayer['email']) and !empty($cs_prayer['email']) ) { ?>
                    	<a href="mailto:<?php echo $cs_prayer['email']; ?>" class="cs-colrhvr cs-encourage"><i class="fa fa-envelope-o"></i><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Encourage','Faith'); }else{ echo $cs_theme_option['trans_prayer_encourage']; } ?></a>
                    <?php } ?>
                    
                </div>
                <!-- Linking End -->
                </div>
            </article>
			
		<?php endwhile;  ?>
	</div>
    <?php
	// pagination start
	$qrystr = '';
	if(cs_pagination($post_count, $cs_node->prayer_page_num, $qrystr) <> ''){
		if ( $cs_node->prayer_pagination == "Show Pagination" and $cs_node->prayer_page_num > 0 ) {
			if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
			if ( isset($_GET['filter_category']) ) $qrystr .= "&filter_category=".$_GET['filter_category'];
			echo cs_pagination($post_count, $cs_node->prayer_page_num, $qrystr);
		}
	}
	// pagination end
	?>
</div>
<div class="clear"></div>