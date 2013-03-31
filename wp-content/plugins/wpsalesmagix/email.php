<?php require_once( '../../../wp-load.php' ); 

	$general = get_option('wpsmagix_general');
	echo stripslashes($general['email']);
?>