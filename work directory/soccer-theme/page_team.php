<?php
	global $px_node,$post,$px_theme_option,$px_counter_node;
	$px_team_num_post_db = $px_node->team_page_num;
 	$var_pb_team_cat =$px_node->var_pb_team_cat;
	$var_pb_team_cat1 =explode(',',$px_node->var_pb_team_cat);
 	if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
	
	if ( isset($_GET['filter_category'])) { 
		$filter_category = $_GET['filter_category'];
	}else if(isset($var_pb_team_cat1[0]) && $var_pb_team_cat1[0] <> ''){
		 $filter_category = '';
		 $term = get_term($var_pb_team_cat1[0],'team-category');
		 $filter_category=$term->slug;
	 }
	$count_post = 0;
	$args = array( 'posts_per_page' => '-1', 'post_type' => 'player', 'post_status' => 'publish');
	if(isset($var_pb_team_cat1) && $var_pb_team_cat1['0'] <> '' && !$var_pb_team_cat1){
		$team_category_array = array('team-category' => "$var_pb_team_cat1[0]");
		$args = array_merge($args, $team_category_array);
	}
	$custom_query = new WP_Query($args);
	$post_count = $custom_query->post_count;
	?>
   	<div class="element_size_<?php echo $px_node->team_element_size; ?>"> 
    	<?php if ($px_node->team_view=="Carousal View") { px_enqueue_cycle_script();?>
    				<div class="pix-content-wrap">
                    		 	
                        <header class="pix-heading-title">
                            <?php if ($px_node->team_title <> ''){?><h2 class="pix-section-title"><?php echo $px_node->team_title; ?></h2><?php }?>
                            <div class="carousel-default-button">
                                <span class="cycle-prev btn pix-bgcolrhvr" id="cycle-prev-<?php echo $px_counter_node;?>"> <i class="fa fa-long-arrow-left"></i></span>
                                <span class="cycle-next btn pix-bgcolrhvr" id="cycle-next-<?php echo $px_counter_node;?>"> <i class="fa fa-long-arrow-right"></i></span>
                            </div>
                        </header>
                          <?php 
 								$args = array(
                                'posts_per_page'			=> "$px_node->team_page_num",
                                'post_type'					=> 'player',
                                'post_status'				=> 'publish',
                                'order'						=> 'ASC',
                             );
                    
								if(isset($filter_category) &&  $filter_category <> ''){
									$team_category_array = array('team-category' => "$filter_category");
									$args = array_merge($args, $team_category_array);
								}
 								$custom_query = new WP_Query($args);
								$counter = 1;
								$count = 1;
								if($custom_query->have_posts()){
							?>              
                        <div class="our-team-sec our-team-carousel">
                        	<div class="cycle-slideshow"
                                data-cycle-fx=carousel
                                data-cycle-next="#cycle-next-<?php echo $px_counter_node;?>"
                                data-cycle-prev="#cycle-prev-<?php echo $px_counter_node;?>"
                                data-cycle-slides=">article"
                                data-cycle-timeout=3000>
                                    <?php 
                                 while ( $custom_query->have_posts()) : $custom_query->the_post();
                                    $player_xml = get_post_meta($post->ID, 'px_player', true);
                                    if ( $player_xml <> "" ) {
                                        $player_xmlObject = new SimpleXMLElement($player_xml);
                                    }
                                    $width = 302;
                                    $height = 362;
                                    $image_url = px_get_post_img_src($post->ID, $width, $height);
                                    $no_img = '';
                                    if($image_url == ''){ $no_img = 'no-image';}
                                    ?>
                                         <article <?php post_class($no_img);?>>
                                             <figure>
                                                 <?php if($image_url <> ''){?><a href="<?php the_permalink();?>"><img src="<?php echo $image_url;?>" alt=""></a><?php }?>
                                                 <figcaption>
                                                     <h2 class="pix-post-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                                                     <?php if($player_xmlObject->player_spciality <> ''){?><h6><a><?php echo $player_xmlObject->player_spciality;?></a></h6><?php }?>
                                                 </figcaption>
                                             </figure>
                                         </article>
                                    
                                    <?php endwhile;?>
                            </div>
                    </div>
                    <?php }?>
                 </div>
    	<?php } else {?>
	    	<div class="tabs horizontal">
           <div class="fluid-tab-horizontal">
           	<?php if ($px_node->team_title <> '') { ?>
                <header class="pix-heading-title">
                    <h2 class="pix-section-title"><?php echo $px_node->team_title; ?></h2>
                </header>
                <div class="clear"></div>
	        <?php }?>
            	<?php if(count($var_pb_team_cat1)>1){?>
                	<div class=" fluid-tab-horizontal">
                        <ul id="myTab" class="nav nav-tabs">
                            <?php
                                $qrystr= "";
                                $count=0;
                              if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
                              $categories = get_categories( array('taxonomy' => 'team-category','include'=>"$var_pb_team_cat", 'hide_empty' => 0) );
                              foreach ($categories as $category) {
                              ?>
                                <li <?php if($category->slug==$filter_category){echo 'class="active"';}?>><a href="?<?php echo $qrystr."&filter_category=".$category->slug?>"><?php echo $category->cat_name?></a></li>
                             <?php $count++;
                             }?>
                        </ul>
                   </div>
                 <?php }?>
           </div>
           <div class="tab-content pix-content-wrap">
             <div id="tab1" class="tab-pane fade in  active"> 
            <?php  
			if(isset($px_node->team_orderby) && $px_node->team_orderby <> 'Yes' && $px_node->team_view <> "Carousal View"){
				$args = array(
						'posts_per_page'			=> "$px_node->team_page_num",
						'post_type'					=> 'player',
						'post_status'				=> 'publish',
						'order'						=> 'ASC',
					 );
					   if(isset($var_pb_team_cat1) && $filter_category <> ''){
                        $team_category_array = array('team-category' => "$filter_category");
                        $args = array_merge($args, $team_category_array);
                    }
                    $custom_query = new WP_Query($args);
                    $counter = 1;
                    $count = 1;
                    if($custom_query->have_posts()){
                         ?>
                     <div class="our-team-sec">
                        <?php 
                             while ( $custom_query->have_posts()) : $custom_query->the_post();
                                $player_xml = get_post_meta($post->ID, 'px_player', true);
                                if ( $player_xml <> "" ) {
                                    $player_xmlObject = new SimpleXMLElement($player_xml);
                                }
                                $width = 302;
                                $height = 362;
                                $image_url = px_get_post_img_src($post->ID, $width, $height);
								$no_img = '';
								if($image_url == ''){ $no_img = 'no-image';}
                                ?>
                                     <article <?php post_class($no_img);?>>
                                         <figure>
                                             <?php if($image_url <> ''){?><a href="<?php the_permalink();?>"><img src="<?php echo $image_url;?>" alt=""></a><?php }?>
                                             <figcaption>
                                                 <h2 class="pix-post-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                                                 <?php if($player_xmlObject->player_spciality <> ''){?><h6><a><?php echo $player_xmlObject->player_spciality;?></a></h6><?php }?>
                                             <?php if($player_xmlObject->player_shirtnumber <> ''){?><span class="pix-player-no pix-bgcolr"><?php echo $player_xmlObject->player_shirtnumber;?></span><?php }?>
                                             </figcaption>
                                         </figure>
                                     </article>
                               <?php endwhile;?>
                        </div>
                      <?php }
                      
                   
					 
				} else {
                $departments = get_categories( array('taxonomy' => 'player-department', 'hide_empty' => 0) );
                foreach ($departments as $department) {
                    $args = array(
                                'posts_per_page'			=> "$px_node->team_page_num",
                                'post_type'					=> 'player',
                                'post_status'				=> 'publish',
                                'meta_key'					=> 'px_player_dept',
                                'meta_value'				=> $department->term_id,
                                'meta_compare'				=> '=',
                                'orderby'					=> 'meta_value',
                                'order'						=> 'ASC',
                             );
				
                    if(isset($filter_category) && $filter_category <> ''){
                        $team_category_array = array('team-category' => "$filter_category");
                        $args = array_merge($args, $team_category_array);
                    }
                     $custom_query = new WP_Query($args);
                    $counter = 1;
                    $count = 1;
                    if($custom_query->have_posts()){
                         if ($department->cat_name <> '') { ?>
                            <header class="pix-heading-title">
                                <h2 class="pix-section-title"><?php echo $department->cat_name?></h2>
                            </header>
                        <?php }?>
                     <div class="our-team-sec">
                        <?php 
                             while ( $custom_query->have_posts()) : $custom_query->the_post();
                                $player_xml = get_post_meta($post->ID, 'px_player', true);
                                if ( $player_xml <> "" ) {
                                    $player_xmlObject = new SimpleXMLElement($player_xml);
                                }
                                $width = 302;
                                $height = 362;
                                $image_url = px_get_post_img_src($post->ID, $width, $height);
								$no_img = '';
								if($image_url == ''){ $no_img = 'no-image';}
                                ?>
                                     <article <?php post_class($no_img);?>>
                                         <figure>
                                             <?php if($image_url <> ''){?><a href="<?php the_permalink();?>"><img src="<?php echo $image_url;?>" alt=""></a><?php }?>
                                             <figcaption>
                                                 <h2 class="pix-post-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                                                 <?php if($player_xmlObject->player_spciality <> ''){?><h6><a><?php echo $player_xmlObject->player_spciality;?></a></h6><?php }?>
                                             <?php if($player_xmlObject->player_shirtnumber <> ''){?><span class="pix-player-no pix-bgcolr"><?php echo $player_xmlObject->player_shirtnumber;?></span><?php }?>
                                             </figcaption>
                                         </figure>
                                     </article>
                               <?php endwhile;?>
                        </div>
                      <?php }
                        }
				}
                    ?>              
                </div>
            </div>
    <!-- Our team Close -->
	</div>
		<?php }?>
	<?php
    $qrystr = '';
        if ( $px_node->team_pagination == "Show Pagination" and $px_node->team_page_num > 0 and $count_post > $px_node->team_page_num) {
            echo "<nav class='pagination'><ul>";
                if ( isset($_GET['page_id']) ) $qrystr = "&amp;page_id=".$_GET['page_id'];
                    echo px_pagination($count_post, $px_node->team_page_num,$qrystr);
            echo "</ul></nav>";
        }
    // pagination end
    ?>
</div>
