<?php
require_once '../../../../wp-load.php';
	//echo $_COOKIE["cs_menu_active" ];
	if ( !isset($_COOKIE["cs_menu_active" ]) ||  $_COOKIE["cs_menu_active" ]=='false'){
		setcookie("cs_menu_active", 'true', time()+3600, '/');
		echo 'mp-wrapper-main';
		
	} else {
		//setcookie('cs_menu_active', '', time()-360000);
		//setcookie("cs_menu_active", 'abc', time()+3600, '/');
		setcookie("cs_menu_active", 'false', time()+3600, '/');
		//setcookie("cs_menu_active", 'false', -1, '/');
		//$_COOKIE["cs_menu_active" ] = '';
	}
	
	
?>