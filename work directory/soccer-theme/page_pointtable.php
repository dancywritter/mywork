<?php
	global $px_node, $px_theme_option, $px_counter_node;
	if ( !isset($px_node->var_pb_pointtable_per_page) || empty($px_node->var_pb_pointtable_per_page) ) { $px_node->var_pb_pointtable_per_page = -1; }
	$filter_category = '';
	$row_cat = $wpdb->get_row("SELECT * from ".$wpdb->prefix."terms WHERE slug = '" . $px_node->var_pb_pointtable_cat ."'" );
	        if ( isset($_GET['filter_category']) ) {$filter_category = $_GET['filter_category'];}
        else {
            if(isset($row_cat->slug)){
            $filter_category = $row_cat->slug;
            }
        }
		 if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
				$args = array(
					'posts_per_page'			=> "-1",
					'post_type'					=> 'pointtable',
					'post_status'				=> 'publish',
					'order'						=> 'ASC',
				);
			if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
				$season_category_array = array('season-category' => "$filter_category");
				$args = array_merge($args, $season_category_array);
			}
			$custom_query = new WP_Query($args);
 		?>
        <div class="element_size_<?php echo $px_node->pointtable_element_size;?>">
            <div class="pix-content-wrap">
                <?php	
					if ($px_node->var_pb_pointtable_title <> '') { ?>
                        <header class="pix-heading-title">
                            <?php	if ($px_node->var_pb_pointtable_title <> '') { ?>
                            <h2 class="pix-section-title"><?php echo $px_node->var_pb_pointtable_title; ?></h2>
                            <?php  } ?>
        
                        </header>
                <?php  } ?>
                <?php if ($px_node->var_pb_pointtable_filterable == "On") {
                    $qrystr= "";
                    if ( isset($_GET['page_id']) ) $qrystr = "page_id=".$_GET['page_id'];
                ?>
                <div class="tabs horizontal">
                     <div class="fluid-tab-horizontal">
						<ul id="myTab" class="nav nav-tabs">
                             <?php  
                                if((isset($px_node->var_pb_pointtable_cat) &&  $px_node->var_pb_pointtable_cat <> ''  && $px_node->var_pb_pointtable_cat <> '0') &&  isset( $row_cat->term_id )){
                                    $categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'season-category', 'hide_empty' => 0) );
                                    ?>
                                    <li class="<?php if(($px_node->var_pb_pointtable_cat==$filter_category)){echo 'pix-active';}?>">
                                        <a href="?<?php echo $qrystr."&amp;filter_category=".$row_cat->slug?>"><?php _e("All",'Soccer Club');?></a>
                                    </li>
                                    <?php
                                } else {
                                    $categories = get_categories( array('taxonomy' => 'season-category', 'hide_empty' => 0) );
                                }
                                foreach ($categories as $category) {?>
                                    <li <?php if($category->slug==$filter_category){echo 'class="pix-active"';}?>>
                                        <a href="?<?php echo $qrystr."&amp;filter_category=".$category->slug?>"><?php echo $category->cat_name?></a>
                                    </li>
                            <?php }?>
                        </ul>
                    </div>
                    </div>
                  <?php }?>
                  <?php
                        $args = array(
                            'posts_per_page'			=> "$px_node->var_pb_pointtable_per_page",
                            'paged'						=> $_GET['page_id_all'],
                            'post_type'					=> 'pointtable',
                            'post_status'				=> 'publish',
                            'order'						=> 'ASC',
                         );
                        if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
                            $season_category_array = array('season-category' => "$filter_category");
                            $args = array_merge($args, $season_category_array);
                        }
                        $custom_query = new WP_Query($args);
                        if ( $custom_query->have_posts() <> "" ):
                        
                        while ( $custom_query->have_posts() ): $custom_query->the_post();
                            $pointtable_counter=1;
							$px_pointtable = get_post_meta($post->ID, "px_pointtable", true);
                            if ( $px_pointtable <> "" ) {
                                $px_xmlObject = new SimpleXMLElement($px_pointtable);
								$var_pb_record_per_post =$px_xmlObject->var_pb_record_per_post;
                            }else{
								$var_pb_record_per_post= '';
							}
                         ?> 
                        <div class="points-table fullwidth">
                        	<table class="table table-condensed table_D3D3D3">
                            	<thead>
                                    <tr>
                                    <th>
                                    	<span class="box1">
                            				<?php if($px_theme_option["trans_switcher"] == "on") { _e("Pos",'Soccer Club'); }else{  echo $px_theme_option["trans_pos"];} ?>
                            			</span>
                            		</th>
                                     <th>
                                    	<span class="box2">
                            				<?php if($px_theme_option["trans_switcher"] == "on") { _e("Team",'Soccer Club'); }else{  echo $px_theme_option["trans_team"];} ?>
                           				 </span>
                            		</th>
                                    <th>
                                    	<span class="box3">
                            				<?php if($px_theme_option["trans_switcher"] == "on") { _e("Play",'Soccer Club'); }else{  echo $px_theme_option["trans_play"];} ?>
                            			</span>
                            		</th>
                                    <th>
                                    	<span class="box4">
                             				<?php if($px_theme_option["trans_switcher"] == "on") { _e(" +/-",'Soccer Club'); }else{  echo $px_theme_option["trans_plusminus"];} ?>
                            			</span>
                            		</th>
                                    <th>
                                    	<span class="box5">
                            				<?php if($px_theme_option["trans_switcher"] == "on") { _e("Points",'Soccer Club'); }else{  echo $px_theme_option["trans_totalpoints"];} ?>  			 	</span>
                            		</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                          	 
                          <?php
						  if($px_xmlObject->var_pb_record_per_post <> '' and $px_xmlObject->var_pb_record_per_post > 0){

							foreach ( $px_xmlObject->track as $track ){
                             	if(($pointtable_counter-1) < $px_xmlObject->var_pb_record_per_post){
							   	echo '<tr>
                                      <td>'.$pointtable_counter.'</td>
                                      <td>'.$track->var_pb_pointtable_team.'</td>
                                      <td>'.$track->var_pb_match_played.'</td>
                                      <td>'.$track->var_pb_pointtable_plusminus_points.'</td>
                                      <td>'.$track->var_pb_pointtable_totalpoints.'</td>
                                </tr>';
							   }
                                  $pointtable_counter++;
                              }
						  }else{
							  foreach ( $px_xmlObject->track as $track ){
 							   	echo '<tr>
                                      <td>'.$pointtable_counter.'</td>
                                      <td>'.$track->var_pb_pointtable_team.'</td>
                                      <td>'.$track->var_pb_match_played.'</td>
                                      <td>'.$track->var_pb_pointtable_plusminus_points.'</td>
                                      <td>'.$track->var_pb_pointtable_totalpoints.'</td>
                                </tr>';
							   }
                                  $pointtable_counter++;
 						  }
							  
                         ?>
                         
                  		</tbody>
                     <tfoot>
                     <tr>
                         	<td colspan="5"> <?php if($px_xmlObject->var_pb_pointtable_viewall <> ''){?>
                  			<a href="<?php  echo $px_xmlObject->var_pb_pointtable_viewall; ?>" class="btn">
                   				<?php if($px_theme_option["trans_switcher"] == "on") { _e("View All",'Soccer Club'); }else{  echo $px_theme_option["trans_viewall"];} ?>
                  			</a>
                  		<?php } ?></td>
                        </tr>
                         </tfoot>
                     </table>
                     
                      </div>
                    <?php endwhile; endif;?>  
				 </div>
          </div>