<?php
session_start();
ob_start();
?>

 <div class="wrapper" >
		<div class="clearfix container_message">
            	<h1 class="head2"><?php echo AUTHORISE_NET_MSG;?></h1>
            </div>

<?php
/*  Demonstration on using authorizenet.class.php.  This just sets up a
*  little test transaction to the authorize.net payment gateway.  You
*  should read through the AIM documentation at authorize.net to get
*  some familiarity with what's going on here.  You will also need to have
*  a login and password for an authorize.net AIM account and PHP with SSL and
*  curl support.
*
*  Reference http://www.authorize.net/support/AIM_guide.pdf for details on
*  the AIM API.
*/
$paymentOpts = get_payment_optins($_REQUEST['paymentmethod']);
global $payable_amount,$post_title,$last_postid,$current_user;
$display_name = $current_user->display_name;
$user_email = $current_user->user_email;
$user_phone = $current_user->user_phone;


$payable_amt = $payable_amount;

require_once(TEMPLATEPATH . '/library/payment/authorizenet/authorizenet.class.php');

$a = new authorizenet_class;

// You login using your login, login and tran_key, or login and password.  It
// varies depending on how your account is setup.
// I believe the currently reccomended method is to use a tran_key and not
// your account password.  See the AIM documentation for additional information.

$a->add_field('x_login', $paymentOpts['loginid']);
$a->add_field('x_tran_key', $paymentOpts['transkey']);
//$a->add_field('x_password', 'CHANGE THIS TO YOUR PASSWORD');

$a->add_field('x_version', '3.1');
$a->add_field('x_type', 'AUTH_CAPTURE');
//$a->add_field('x_test_request', 'TRUE');    // Just a test transaction
$a->add_field('x_relay_response', 'FALSE');

// You *MUST* specify '|' as the delim char due to the way I wrote the class.
// I will change this in future versions should I have time.  But for now, just
// make sure you include the following 3 lines of code when using this class.

$a->add_field('x_delim_data', 'TRUE');
$a->add_field('x_delim_char', '|');     
$a->add_field('x_encap_char', '');


// Setup fields for customer information.  This would typically come from an
// array of POST values froma secure HTTPS form.

$a->add_field('x_first_name', $display_name);
$a->add_field('x_last_name', '');
//$a->add_field('x_address', $address);
//$a->add_field('x_city', $userInfo['user_city']);
//$a->add_field('x_state', $userInfo['user_state']);
//$a->add_field('x_zip', $userInfo['user_postalcode']);
//$a->add_field('x_country', 'US');
//$a->add_field('x_country',  $userInfo['user_country']);
$a->add_field('x_email', $user_email);
$a->add_field('x_phone', $user_phone);

// Using credit card number '4007000000027' performs a successful test.  This
// allows you to test the behavior of your script should the transaction be
// successful.  If you want to test various failures, use '4222222222222' as
// the credit card number and set the x_amount field to the value of the
// Response Reason Code you want to test. 
//
// For example, if you are checking for an invalid expiration date on the
// card, you would have a condition such as:
// if ($a->response['Response Reason Code'] == 7) ... (do something)
//
// Now, in order to cause the gateway to induce that error, you would have to
// set x_card_num = '4222222222222' and x_amount = '7.00'

//  Setup fields for payment information
$a->add_field('x_method', $_REQUEST['cc_type']);
$a->add_field('x_card_num', $_REQUEST['cc_number']);
//$a->add_field('x_card_num', '4007000000027');   // test successful visa
//$a->add_field('x_card_num', '370000000000002');   // test successful american express
//$a->add_field('x_card_num', '6011000000000012');  // test successful discover
//$a->add_field('x_card_num', '5424000000000015');  // test successful mastercard
// $a->add_field('x_card_num', '4222222222222');    // test failure card number
$a->add_field('x_amount', $payable_amt);
$a->add_field('x_invoice_num', $last_postid);
$a->add_field('x_exp_date', $_REQUEST['cc_month'].substr($_REQUEST['cc_year'],2,strlen($_REQUEST['cc_year'])));    // march of 2008
$a->add_field('x_card_code', $_REQUEST['cv2']);    // Card CAVV Security code
$paymentFlag = 1;
// Process the payment and output the results
switch ($a->process()) {

   case 1:  // Successs
      //echo "<b>Success:</b><br>";
      //echo $a->get_response_reason_text();
      //echo "<br><br>Details of the transaction are shown below...<br><br>";
     //payment_success
	// $_SESSION['display_message'] = $a->get_response_reason_text();
	//$paymentFlag = 1;
	$redirectUrl = get_option('siteurl')."/?page=payment_success&pid=".$last_postid;
	wp_redirect($redirectUrl);
	 break;
     
   case 2:  // Declined
      
	  //echo "<b>Payment Declined:</b><br>";
     // echo $a->get_response_reason_text();
     // echo "<br><br>Details of the transaction are shown below...<br><br>";
	$_SESSION['display_message'] = $a->get_response_reason_text();
	  break;
     
   case 3:  // Error
       $paymentFlag = 0;
	  //echo "<b>Error with Transaction:</b><br>";
     // echo $a->get_response_reason_text();
     // echo "<br><br>Details of the transaction are shown below...<br><br>";
     $_SESSION['display_message'] = $a->get_response_reason_text();
	  break;
}
if($paymentFlag == 0)
{
	if($_REQUEST['pid']){ $sublink = '&pid='.$_REQUEST['pid'];}
	 wp_redirect(get_option('siteurl')."/?page=postajob&backandedit=1$sublink");
	 exit;
}

// The following two functions are for debugging and learning the behavior
// of authorize.net's response codes.  They output nice tables containing
// the data passed to and recieved from the gateway.

//$a->dump_fields();      // outputs all the fields that we set
//$a->dump_response();    // outputs the response from the payment gateway
//if(!$paymentFlag)
//{
	//wp_redirect(get_option('siteurl').'/?page=preview&paymentmethod='. $_REQUEST['paymentmethod'].'&shippingmethod='.$_REQUEST['shippingmethod']);
	//exit;
//}
?>