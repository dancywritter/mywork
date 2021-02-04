<?php
require_once '../../../../wp-load.php';

	$cs_prayer = get_post_meta( $_POST['post_id'] , 'cs_prayer', true);
		$prayer_counter = get_post_meta( $_POST['post_id'] , "prayer_counter", true);
			if ( !isset($_COOKIE["prayer_counter".$_POST['post_id'] ]) ){
				setcookie("prayer_counter".$_POST['post_id'], 'true', time()+86400, '/');
				update_post_meta( $_POST['post_id'], 'prayer_counter', $prayer_counter+1 );
			}
		$prayer_counter = get_post_meta($_POST['post_id'], "prayer_counter", true);
		if ( !isset($prayer_counter) or empty($prayer_counter) ) $prayer_counter = 0;
	echo $prayer_counter;

?>