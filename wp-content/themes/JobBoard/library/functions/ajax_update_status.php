<?php
	$file = dirname(__FILE__);
	$file = substr($file,0,stripos($file, "wp-content"));
	require($file . "/wp-load.php");
	if($_REQUEST['post_id'] !=""){
	$my_post['ID'] = $_REQUEST['post_id'];
	$my_post['post_status'] = 'publish';
	wp_update_post( $my_post );
	echo "<span style='color:green;'>".PUBLISHED_TEXT."</span>";
	}
	if($_REQUEST['trans_id'] !=""){
	global $wpdb,$transection_db_table_name;
	$tid = $_REQUEST['trans_id'];
	$trans_status = $wpdb->query("update $transection_db_table_name SET status = 1 where trans_id = '".$tid."'");
	echo "<span style='color:green; font-weight:normal;'>Approved</span>";
	}
?>