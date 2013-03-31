<?php
$file = dirname(__FILE__);
$file = substr($file,0,stripos($file, "wp-content"));
require($file . "/wp-load.php");	

$packid = $_REQUEST['package_id'];
if($packid != "")
{	
	global $wpdb;
	$ptable = $wpdb->prefix."price";
	$wpdb->query("delete from $ptable where pid = '".$packid."'");
	if(mysql_affected_rows() >0){ ?>
		<div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;" >
		<?php		_e('Price package has been deleted successfully.','templatic'); ?>
		</div>
<?php		include_once('ajax_list_price_package.php');
	}
}
$ptype = $_REQUEST['ptype'];
if($ptype !=""){
	update_option('post_type_export',$ptype);
	return $ptype;
}
?>