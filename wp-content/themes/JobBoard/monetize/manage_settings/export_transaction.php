<?php
session_start();
header('Content-Description: File Transfer');
header("Content-type: application/force-download");
header('Content-Disposition: inline; filename="transaction.csv"');
$file = dirname(__FILE__);
$file = substr($file,0,stripos($file, "wp-content"));
require($file . "/wp-load.php");
global $wpdb,$current_user,$transection_db_table_name,$qry_string;
_e("Title,Pay Date,Billing name,Billing address,Pay Method,Amount\r\n","templatic");
$transinfo = $wpdb->get_results($_SESSION['query_string']);
$totamt=0;
if($transinfo)
{
	foreach($transinfo as $priceinfoObj)
	{
		$totamt = $totamt + $priceinfoObj->payable_amt;
		$post_title = str_replace(',',' ',$priceinfoObj->post_title);
		$billing_add = str_replace(array(',','<br />'),' ',$priceinfoObj->billing_add);
		echo "$post_title,".date('d/m/Y',strtotime($priceinfoObj->payment_date)).",$priceinfoObj->billing_name,$billing_add,$priceinfoObj->payment_method,".get_currency_sym().number_format($priceinfoObj->payable_amt,2)." \r";
 }
echo " , , , , , ,Total Amount :, ".display_amount_with_currency($totamt)."\r\n";

}else
{
_e("No record available","templatic");

}?>  