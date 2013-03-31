<?php
global $wpdb;
$url = 'https://www.paypal.com/cgi-bin/webscr';
$postdata = '';
foreach($_POST as $i => $v) 
{
	$postdata .= $i.'='.urlencode($v).'&amp;';
}
$postdata .= 'cmd=_notify-validate';
 
$web = parse_url($url);
if ($web['scheme'] == 'https') 
{
	$web['port'] = 443;
	$ssl = 'ssl://';
} 
else 
{
	$web['port'] = 80;
	$ssl = '';
}
$fp = @fsockopen($ssl.$web['host'], $web['port'], $errnum, $errstr, 30);
 
if (!$fp) 
{
	echo $errnum.': '.$errstr;
}
else
{
	fputs($fp, "POST ".$web['path']." HTTP/1.1\r\n");
	fputs($fp, "Host: ".$web['host']."\r\n");
	fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
	fputs($fp, "Content-length: ".strlen($postdata)."\r\n");
	fputs($fp, "Connection: close\r\n\r\n");
	fputs($fp, $postdata . "\r\n\r\n");
 
	while(!feof($fp)) 
	{
		$info[] = @fgets($fp, 1024);
	}
	fclose($fp);
	$info = implode(',', $info);
	if (eregi('VERIFIED', $info)) 
	{
		$to = get_site_emailId();
		
		// yes valid, f.e. change payment status
		$postid = $_POST['custom'];
		$item_name = $_POST['item_name'];
		$txn_id = $_POST['txn_id'];
		$payment_status       = $_POST['payment_status'];
		$payment_type         = $_POST['payment_type'];
		$payment_date         = $_POST['payment_date'];
		$txn_type             = $_POST['txn_type'];
		
		$post_default_status = get_default_status();
		if($post_default_status=='')
		{
			$post_default_status = 'publish';
		}
		set_property_status($postid,$post_default_status);
		
		$transaction_details .= "--------------------------------------------------\r";
		$transaction_details .= "Payment Details for Place Listing ID #$postid\r";
		$transaction_details .= "--------------------------------------------------\r";
		$transaction_details .= " Place Listing Title: $item_name \r";
		$transaction_details .= "--------------------------------------------------\r";
		$transaction_details .= "Trans ID: $txn_id\r";
		$transaction_details .= "  Status: $payment_status\r";
		$transaction_details .= "    Type: $payment_type\r";
		$transaction_details .= "  Date: $payment_date\r";
		$transaction_details .= "  Method: $txn_type\r";
		$transaction_details .= "--------------------------------------------------\r";
		$transaction_details = __($transaction_details,'templatic');
		$subject = get_option('post_payment_success_admin_email_subject');
		if(!$subject)
		{
			$subject = __("Place Listing Submitted and Payment Success Confirmation Email","templatic");
		}
		$content = get_option('post_payment_success_admin_email_content');
		$store_name = get_option('blogname');
		$fromEmail = 'Admin';
		$search_array = array('[#to_name#]','[#information_details#]','[#site_name#]');
		$replace_array = array($fromEmail,$transaction_details,$store_name);
		$filecontent = str_replace($search_array,$replace_array,$content);
		@mail($to,$subject,$filecontent,$headerarr); // email to admin
		
		$productinfosql = "select ID,post_title,guid,post_author from $wpdb->posts where ID = $postid";
		$productinfo = $wpdb->get_results($productinfosql);
		foreach($productinfo as $productinfoObj)
		{
			$post_link = site_url().'/?ptype=preview&alook=1&pid='.$postid;
			$post_title = '<a href="'.$post_link.'">'.$productinfoObj->post_title.'</a>'; 
			$aid = $productinfoObj->post_author;
			$userInfo = get_author_info($aid);
			$to_name = $userInfo->user_nicename;
			$to_email = $userInfo->user_email;
			$user_email = $userInfo->user_email;
		}
		$transaction_details .= "Information Submitted URL\r";
		$transaction_details .= "--------------------------------------------------\r";
		$transaction_details .= "  $post_title\r";
		$transaction_details = __($transaction_details,'templatic');
		
		$subject = get_option('post_payment_success_client_email_subject');
		if(!$subject)
		{
			$subject = __("Place Listing Submitted and Payment Success Confirmation Email","templatic");
		}
		$content = get_option('post_payment_success_client_email_content');
		$store_name = get_option('blogname');
		$search_array = array('[#to_name#]','[#information_details#]','[#site_name#]');
		$replace_array = array($to_name,$transaction_details,$store_name);
		$content = str_replace($search_array,$replace_array,$content);
		
		@mail($user_email,$subject,$content,$headerarr);// email to client
	}
	else
	{
		// invalid, log error or something
	}
}
?>