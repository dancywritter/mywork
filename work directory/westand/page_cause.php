<?php

global $cs_node,$post,$cs_theme_option,$cs_counter_node,$wpdb;

$cs_xmlObject_transaction = new stdclass();
$cause_status = '';
	  $meta_compare = '';
	  
        if ( $cs_node->cause_type == "Upcoming Causes" ) $meta_compare = ">=";

        else if ( $cs_node->cause_type == "Past Causes" ) $meta_compare = "<";
		
if($cs_node->cs_cause_excerpt == ''){ $cs_node->cs_cause_excerpt = 100;}

if ( !isset($cs_node->cause_per_page) || empty($cs_node->cause_per_page)) { $cs_node->cause_per_page = -1; }

	$filter_category = '';

	$row_cat = $wpdb->get_row("SELECT * from ".$wpdb->prefix."terms WHERE slug = '" . $cs_node->cause_cat ."'" );

	if ( isset($_GET['filter_category']) ) {$filter_category = $_GET['filter_category'];}

	else {

		if(isset($row_cat->slug)){

			$filter_category = $row_cat->slug;

		}

	}

	if (empty($_GET['page_id_all'])) $_GET['page_id_all'] = 1;

		 if( isset($cs_node->cause_type) && $cs_node->cause_type == "Upcoming Causes" ){
			
			$args = array(

                    'posts_per_page'			=> "-1",

                    'post_type'					=> 'cs_cause',

                  //  'event-category'			=> "$filter_category",

                    'post_status'				=> 'publish',

                    'meta_key'					=> 'cause_end_date',

                    'meta_value'				=> date('m/d/Y'),

                    'meta_compare'				=> $meta_compare,

                    'orderby'					=> 'meta_value',

                    'order'						=> 'ASC',

                );
			
		} else if($cs_node->cause_type == "cause-last-miles"){
			
			$args = array(

                'posts_per_page'		=> "-1",

                'paged'					=> $_GET['page_id_all'],

                'post_type'				=> 'cs_cause',

                'post_status'			=> 'publish',
				
				'meta_key'				=> 'cs_cause_percentage_amount',
				'meta_value'			=> "$cs_node->cs_cause_last_miles_percentage",
				'meta_compare'			=> ">=",
				'orderby'				=> 'meta_value',

                'order'					=> 'ASC',

            );
		} else if($cs_node->cause_type == "cause-succesfully"){
			
			$args = array(

                'posts_per_page'		=> "-1",

                'paged'					=> $_GET['page_id_all'],

                'post_type'				=> 'cs_cause',

                'post_status'			=> 'publish',
				
				'meta_key'				=> 'cs_cause_percentage_amount',
				'meta_value'			=> "100",
				'meta_compare'			=> "=<",
				'orderby'				=> 'meta_value',

                'order'					=> 'ASC',

            );
			
			 
		} else if( isset($cs_node->cause_type) && $cs_node->cause_type == "Past Causes" ){
			
			$args = array(

                    'posts_per_page'			=> "-1",

                    'post_type'					=> 'cs_cause',

                  //  'event-category'			=> "$filter_category",

                    'post_status'				=> 'publish',

                    'meta_key'					=> 'cause_end_date',

                    'meta_value'				=> date('m/d/Y'),

                    'meta_compare'				=> $meta_compare,

                    'orderby'					=> 'meta_value',

                    'order'						=> 'ASC',

                );
			 
			 
		 } else {
			 
			 $args = array(

				'posts_per_page'			=> "-1",
		
				'post_type'					=> 'cs_cause',
		
				'post_status'				=> 'publish',
		
				'order'						=> 'ASC',
		
			);
			 
		 }

	

	if(isset($cs_node->cause_cat) && $cs_node->cause_cat <> '' && $cs_node->cause_cat <> '0'){

		$menu_category_array = array('cs_cause-category' => "$filter_category");

		$args = array_merge($args, $menu_category_array);

	}

	$custom_query = new WP_Query($args);

	$post_count = 0;

	$post_count = $custom_query->post_count;



?>

<div class="element_size_<?php echo $cs_node->cause_element_size; ?>">

    	<?php if ($cs_node->cause_title <> '') { ?>
			<header class="cs-heading-title">
            	<h2 class="cs-section-title"><?php echo $cs_node->cause_title;?></h2>
			</header>
         <?php }?>

<div class="causes causes-medium <?php  if( isset($cs_node->cause_view) && $cs_node->cause_view == "small" ){ echo ' causes-grid';}?>">

    <?php 
if($cs_theme_option['trans_switcher'] == "on"){ $cause_status_trans = __('Closed','WeStand');}else{ $cause_status_trans = $cs_theme_option['cause_status']; }
		 if( isset($cs_node->cause_type) && $cs_node->cause_type == "Upcoming Causes" ){
			
			$args = array(

                    'posts_per_page'			=> "$cs_node->cause_per_page",

                    'post_type'					=> 'cs_cause',

                  //  'event-category'			=> "$filter_category",

                    'post_status'				=> 'publish',

                    'meta_key'					=> 'cause_end_date',

                    'meta_value'				=> date('m/d/Y'),

                    'meta_compare'				=> $meta_compare,

                    'orderby'					=> 'meta_value',

                    'order'						=> 'ASC',

                );
			
		} else if($cs_node->cause_type == "cause-last-miles"){
			
			$args = array(

                'posts_per_page'		=> "$cs_node->cause_per_page",

                'paged'					=> $_GET['page_id_all'],

                'post_type'				=> 'cs_cause',

                'post_status'			=> 'publish',
				
				'meta_key'				=> 'cs_cause_percentage_amount',
				'meta_value'			=> "$cs_node->cs_cause_last_miles_percentage",
				'meta_compare'			=> ">=",
				'orderby'				=> 'meta_value',

                'order'					=> 'ASC',

            );	 
			
		} else if($cs_node->cause_type == "cause-succesfully"){
			
			$args = array(

                'posts_per_page'		=> "$cs_node->cause_per_page",

                'paged'					=> $_GET['page_id_all'],

                'post_type'				=> 'cs_cause',

                'post_status'			=> 'publish',
				
				'meta_key'				=> 'cs_cause_percentage_amount',
				'meta_value'			=> "100",
				'meta_compare'			=> "=<",
				'orderby'				=> 'meta_value',

                'order'					=> 'ASC',

            ); 
		} else if(isset($cs_node->cause_type) && $cs_node->cause_type == "Past Causes" ){
			
			$args = array(

                    'posts_per_page'			=> "$cs_node->cause_per_page",

                    'post_type'					=> 'cs_cause',

                  //  'event-category'			=> "$filter_category",

                    'post_status'				=> 'publish',

                    'meta_key'					=> 'cause_end_date',

                    'meta_value'				=> date('m/d/Y'),

                    'meta_compare'				=> $meta_compare,

                    'orderby'					=> 'meta_value',

                    'order'						=> 'ASC',

                );
			 
			 
		 } else {
			 
			  $args = array(
	
					'posts_per_page'		=> "$cs_node->cause_per_page",
	
					'paged'					=> $_GET['page_id_all'],
	
					'post_type'				=> 'cs_cause',
	
					'post_status'			=> 'publish',
	
					'order'					=> 'ASC',
	
				);
			 
		 }

            if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){

                $cause_category_array = array('cs_cause-category' => "$filter_category");

                $args = array_merge($args, $cause_category_array);

            }
			
            $custom_query = new WP_Query($args);

	        while ( $custom_query->have_posts() ): $custom_query->the_post(); 
			$cause_status = '';
            $post_xml = get_post_meta($post->ID, "cs_cause_meta", true);

            if($post_xml <> ''){

                $cs_xmlObject = new SimpleXMLElement($post_xml);

            }

			$payment_gross = 0;

			$percentage_amount = 0;

			$cs_tr = get_post_meta($post->ID, "cs_cause_transaction_meta", true);

			if($cs_tr <> ''){

                $cs_xmlObject_transaction = new SimpleXMLElement($cs_tr);

				if(count($cs_xmlObject_transaction->transaction)>0){

				foreach ( $cs_xmlObject_transaction->transaction as $transct ){

						$payment_gross = $payment_gross+$transct->payment_gross;

				}

				if($payment_gross<>'0' && $cs_xmlObject->cause_goal_amount <> '0'){

					$percentage_amount = (($payment_gross/$cs_xmlObject->cause_goal_amount)*100);

					if($percentage_amount>100){

						$percentage_amount = 100;
						
						$cause_status = $cause_status_trans;

					}

				}

			 }

            }

            $image_url = cs_attachment_image_src(get_post_thumbnail_id($post->ID), 342, 193);

			$no_image = '';

            if($image_url == ""){

                    $no_image .= ' no-image';

            }
			
			if(isset($cs_node->cs_cause_excerpt) && $cs_node->cs_cause_excerpt > 0 && get_the_content() <> ''){
				
					$no_image .= ' article-desc-show';
					
			}

        ?>
        
		<article <?php post_class($no_image); ?>>
        <?php if( isset($cs_node->cause_view) && $cs_node->cause_view == "small" ){?>
        		<figure>
                	<?php if($image_url <> ""){?><img src="<?php echo $image_url;?>" alt=""><?php }?>
               </figure>
        
        <?php } else {?>
        	<?php if($image_url <> ""){?>
                    <figure>
                        <img src="<?php echo $image_url;?>" alt="">
                            <figcaption>
                            	<?php if(isset($cause_status) && $cause_status <> ''){
											echo '<span class="btn cs-btn-donate cs-bgcolrhvr">'.$cause_status.' </span>';	
									} else {?>
									<a href="#" class="btn cs-btn-donate cs-bgcolrhvr" data-toggle="modal" data-target="#CausemyModal2<?php echo $post->ID;?>"><?php if($cs_theme_option['trans_switcher'] == "on"){ $trans_featured = _e('Donate Now','WeStand');}else{ echo $cs_theme_option['cause_donate']; }?></a>
								 <?php }?>
                            </figcaption>
                    </figure>
            <?php }?>
         <?php }?>
            <div class="text">
            	<h2 class="cs-post-title"><a href="<?php the_permalink();?>" class="cs-colrhvr"><?php echo substr(get_the_title(), 0, 43); if(strlen(get_the_title())>43) echo '...'; ?></a></h2>
            	<?php if(isset($cs_node->cs_cause_excerpt) && $cs_node->cs_cause_excerpt > 0){?>
                	<p><?php  cs_get_the_excerpt($cs_node->cs_cause_excerpt,false);?></p>
                 <?php }?>
                <div class="progress-wrap">
                    <div class="progress-bar-charity" data-loadbar="<?php echo round($percentage_amount);?>" data-loadbar-text="<?php echo round($percentage_amount);?>%">
                        <div class="cs-bgcolr"></div>
                    </div>
                </div>
                <div class="progress-desc">
                    <span class="progress-box-left"> <?php if($cs_theme_option['trans_switcher'] == "on"){ $trans_featured = _e('Goal','WeStand');}else{ echo $cs_theme_option['cause_goal']; }?> <?php echo $cs_theme_option['paypal_currency_sign'];?><?php echo number_format((float)$cs_xmlObject->cause_goal_amount);?> </span>
                    <span class="progress-box-right"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Raised','WeStand');}else{ echo $cs_theme_option['cause_raised']; }?> <?php echo $cs_theme_option['paypal_currency_sign'];?><?php echo number_format($payment_gross);?></span>
                </div>
                <?php if( isset($cs_node->cause_view) && $cs_node->cause_view == "small" ){?>
                	<?php if(isset($cause_status) && $cause_status <> ''){
								echo '<span class="btn cs-btn-donate cs-bgcolrhvr">'.$cause_status.' </span>';	
						} else {?>
						<a href="#" class="btn cs-btn-donate cs-bgcolrhvr" data-toggle="modal" data-target="#CausemyModal2<?php echo $post->ID;?>"><?php if($cs_theme_option['trans_switcher'] == "on"){ $trans_featured = _e('Donate Now','WeStand');}else{ echo $cs_theme_option['cause_donate']; }?></a>
					 <?php }?>
                <?php }?>
            </div>
            
        </article>
         <?php 
			if(isset($cause_status) && $cause_status == ''){
				if(isset($cs_xmlObject->cause_paypal_email) && $cs_xmlObject->cause_paypal_email <> ''){
					cs_donate_button($cs_xmlObject->cause_paypal_email);
				} else {
					cs_donate_button();
				}
			}
			?>
      <?php endwhile;?>

    </div>

	 <?php 

         $qrystr = '';

         if ( $cs_node->cause_pagination == "Show Pagination" and $post_count > $cs_node->cause_per_page and $cs_node->cause_per_page > 0 ) {

                if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];

                    echo cs_pagination($post_count, $cs_node->cause_per_page,$qrystr);

        }

    ?>

</div>