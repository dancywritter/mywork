<?php
require_once '../../../../wp-load.php';

		$px_like_counter = get_post_meta( $_POST['post_id'] , "px_like_counter", true);
			if ( !isset($_COOKIE["px_like_counter".$_POST['post_id'] ]) ){
				setcookie("px_like_counter".$_POST['post_id'], 'true', time()+86400, '/');
				update_post_meta( $_POST['post_id'], 'px_like_counter', $px_like_counter+1 );
			}
		$px_like_counter = get_post_meta($_POST['post_id'], "px_like_counter", true);
		if ( !isset($px_like_counter) or empty($px_like_counter) ) $px_like_counter = 0;
	echo $px_like_counter;

?>