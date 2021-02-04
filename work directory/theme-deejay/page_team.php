<?php
	global $px_node,$post,$px_theme_option;
	$px_team_num_post_db = $px_node->team_page_num;
	if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
		$count_post = 0;
		$args = array( 'posts_per_page' => '-1', 'post_type' => 'team', 'post_status' => 'publish');
		$custom_query = new WP_Query($args);
		$post_count = $custom_query->post_count;
	?>
   	<div class="element_size_<?php echo $px_node->team_element_size; ?>"> 
    	<div class="team-section">
        	<?php	if ($px_node->team_title <> '') { ?>
                <header class="pix-heading-title">
                    <?php	if ($px_node->team_title <> '') { ?>
                    <h2 class="pix-page-title"><?php echo $px_node->team_title; ?></h2>
					<?php  } ?>
                </header>
        	<?php  } 
				
                if ( $px_node->team_pagination == "Single Page" ) $px_team_num_post_db = $px_node->team_page_num;
                $args = array( 'posts_per_page' => "$px_team_num_post_db", 'paged' => $_GET['page_id_all'], 'post_type' => 'team' ,'post_status' => 'publish');
                $custom_query = new WP_Query($args);
                $counter = 1;
				$count = 1;
                while ( $custom_query->have_posts()) : $custom_query->the_post();
				$team = get_post_meta($post->ID, 'px_team', true);
				$width = 197;
				$height = 257;
				$no_image = '';
				$image_url = px_get_post_img_src($post->ID, $width, $height);
				if($image_url == ''){ $no_image = 'no-image';}
				?>
                <article <?php post_class($no_image);?>>
                    <figure><?php if($image_url <> ''){?> <img src="<?php echo $image_url;?>" alt=""><?php }?></figure>
                    <div class="text">
                        <h3><?php the_title();?></h3>
                        <?php if(isset($team['designation']) && $team['designation'] <> ''){?><h6><?php echo $team['designation'];?></h6><?php }?>
                        <?php the_content(); ?>
                        <div class="followus">
                            <?php if(isset($team['twitter']) && $team['twitter'] <> ''){?><a href="<?php echo $team['twitter'];?>"><i class="fa fa-twitter"></i></a><?php }?>
                            <?php if(isset($team['facebook']) && $team['facebook'] <> ''){?><a href="<?php echo $team['facebook'];?>"><i class="fa fa-facebook"></i></a><?php }?>
                            <?php if(isset($team['google_plus']) && $team['google_plus'] <> ''){?><a href="<?php echo $team['google_plus'];?>"><i class="fa fa-google-plus"></i></a><?php }?>
                            <?php if(isset($team['linkedin']) && $team['linkedin'] <> ''){?><a href="<?php echo $team['linkedin'];?>"><i class="fa fa-linkedin"></i></a><?php }?>
                        </div>
                    </div>
                </article>
                <?php endwhile; ?>
            </div>
    	<?php
		$qrystr = '';
		if (px_pagination($post_count, $px_node->team_page_num,$qrystr) <> ''){
			if ( $px_node->team_pagination == "Show Pagination" and $px_node->team_page_num > 0 ) {
				echo "<nav class='pagination'><ul>";
					if ( isset($_GET['page_id']) ) $qrystr = "&amp;page_id=".$_GET['page_id'];
						echo px_pagination($post_count, $px_node->team_page_num,$qrystr);
				echo "</ul></nav>";
			}
		}
		// pagination end
		?>
    </div>
