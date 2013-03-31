<?php
global $Cart,$General;
foreach ($_POST as $field=>$value)
{
	$ipnData["$field"] = $value;
}

$postid    = intval($ipnData['x_invoice_num']);
$pnref      = $ipnData['x_trans_id'];
$amount     = doubleval($ipnData['x_amount']);
$result     = intval($ipnData['x_response_code']);
$respmsg    = $ipnData['x_response_reason_text'];
$customer_email    = $ipnData['x_email'];
$customer_name = $ipnData['x_first_name'];

$fromEmail = get_site_emailId();
$fromEmailName = get_site_emailName();
$subject = __("Acknowledge for Place Listing ID #$postid payment","templatic");

if ($result == '1')
{
	// Valid IPN transaction.
	$post_default_status = get_default_status();
	if($post_default_status=='')
	{
		$post_default_status = 'publish';
	}
	set_property_status($postid,$post_default_status);
	$productinfosql = "select ID,post_title,guid,post_author from $wpdb->posts where ID = $postid";
	$productinfo = $wpdb->get_results($productinfosql);
	foreach($productinfo as $productinfoObj)
	{
		$post_title = '<a href="'.$productinfoObj->guid.'">'.$productinfoObj->post_title.'</a>'; 
		$aid = $productinfoObj->post_author;
		$userInfo = get_author_info($aid);
		$to_name = $userInfo->user_nicename;
		$to_email = $userInfo->user_email;
	}
	$message = __("
			<p>
			payment for Place Listing ID #$postid confirmation.<br>
			</p>
			<p>
			<b>You may find detail below:</b>
			</p>
			<p>----</p>
			<p>Place Listing Id : '.$postid.'</p>
			<p>Place Listing Title : '.$post_title.'</p>
			<p>User Name : '.$to_name.'</p>
			<p>User Email : '.$to_email.'</p>
			<p>Paid Amount :       '.number_format($amount,2).'</p>
			<p>Transaction ID :       '.$pnref.'</p>
			<p>Result Code : '.$result.'</p>
			<p>Response Message : '.$respmsg.'</p>
			<p>----</p><br><br>
			<p>Thank you.</p>
			'");
	$subject = get_option('post_payment_success_admin_email_subject');
	if(!$subject)
	{
		$subject = __("Place Listing Submitted and Payment Success Confirmation Email","templatic");
	}
	$content = get_option('post_payment_success_admin_email_content');
	$store_name = get_option('blogname');
	$fromEmail = 'Admin';
	$search_array = array('[#to_name#]','[#information_details#]','[#site_name#]');
	$replace_array = array($fromEmail,$message,$store_name);
	$message = str_replace($search_array,$replace_array,$content);
	@mail($fromEmail,$subject,$message,$headerarr); // email to admin
	return true;
}
else if ($result != '1')
{
	$message = __("
			<p>
			payment for Place Listing ID #$postid incompleted.<br>
			because of $respmsg
			</p>
			<p>
			<b>You may find detail below:</b>
			</p>
			<p>----</p>
			<p>Place Listing Id : '.$postid.'</p>
			<p>Place Listing Title : '.$post_title.'</p>
			<p>User Name : '.$to_name.'</p>
			<p>User Email : '.$to_email.'</p>
			<p>Paid Amount :       '.number_format($amount,2).'</p>
			<p>Transaction ID :       '.$pnref.'</p>
			<p>Result Code : '.$result.'</p>
			<p>Response Message : '.$respmsg.'</p>
			<p>----</p><br><br>
			<p>Thank you.</p>
			'");
	$subject = get_option('post_payment_success_client_email_subject');
	if(!$subject)
	{
		$subject = __("Place Listing Submitted and Payment Success Confirmation Email","templatic");
	}
	$content = get_option('post_payment_success_client_email_content');
	$store_name = get_option('blogname');
	$search_array = array('[#to_name#]','[#information_details#]','[#site_name#]');
	$replace_array = array($to_name,$message,$store_name);
	$message = str_replace($search_array,$replace_array,$content);
	
	@mail($to_email,$subject,$message,$headerarr); // email to client
	return false;
}
?>