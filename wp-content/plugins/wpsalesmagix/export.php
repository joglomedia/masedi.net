<?php
    require_once( '../../../wp-load.php' );
    //require_once('wpsmagix.php');
	$wpsp = new wpsmagix();
	$csv_output = "";

	global $wpdb;
	
	$csv_output = 'Reg ID,Email,Timestamp';
	$csv_output .= "\n";
	
	$table_name = $wpsp->tablemail;
			
	$rowdata = $wpdb -> get_results("SELECT * FROM $table_name");
	
	foreach ($rowdata as $row) {
		$csv_output .= $row -> id .','. $row -> email . ','. $row -> timestamp;
		$csv_output .= "\n";
	}
	
	$filename = "wpshareme_".date("Y-m-d_H-i",time());
	
	header("Content-type: application/csv");
	header("Content-Disposition: attachment; filename=$filename.csv");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	print $csv_output;
	
	exit;
?>