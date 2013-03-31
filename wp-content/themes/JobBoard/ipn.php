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
		$to = get_option('site_email_id');
		
		// yes valid, f.e. change payment status
		$postid = $_POST['custom'];
		$item_name = $_POST['item_name'];
		$txn_id = $_POST['txn_id'];
		$payment_status       = $_POST['payment_status'];
		$payment_type         = $_POST['payment_type'];
		$payment_date         = $_POST['payment_date'];
		$txn_type             = $_POST['txn_type'];
		
		$jobpost_default_status = get_option('jobpost_default_status');
		$my_post = array();
		$my_post['post_status'] = $jobpost_default_status;
		$my_post['ID'] = $postid;
		$last_postid = wp_update_post($my_post);
		
		$transaction_details .= "<p>--------------------------------------------------</p>";
		$transaction_details .= "<p>Payment Details for Job Post ID #$postid</p>";
		$transaction_details .= "<p>--------------------------------------------------</p>";
		$transaction_details .= " <p>Job Title: $item_name </p>";
		$transaction_details .= "<p>--------------------------------------------------</p>";
		$transaction_details .= "<p>Trans ID: $txn_id</p>";
		$transaction_details .= " <p> Status: $payment_status</p>";
		$transaction_details .= " <p>  Type: $payment_type</p>";
		$transaction_details .= " <p> Date: $payment_date</p>";
		$transaction_details .= " <p> Method: $txn_type</p>";
		$transaction_details .= "<p>--------------------------------------------------</p>";
		$subject = "Job Post Payment Confirmation Email";
		$company_email =get_post_meta($postid,'company_email',true);
		$company_name =get_post_meta($postid,'company_name',true);
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		$headers .= 'From: '.$company_name.' <'.$company_email.'>' . "\r\n";
		mail($to,$subject,$transaction_details,$headers);
		
		if($company_email)
		{
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			$headers .= 'From: '.$to.' <'.$to.'>' . "\r\n";
			mail($company_email,$subject,$transaction_details,$headers);
		}
	}
	else
	{
		// invalid, log error or something
	}
}
?>