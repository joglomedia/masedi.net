<?php
$paymentOpts = get_payment_optins($_REQUEST['paymentmethod']);
$merchantid = $paymentOpts['merchantid'];
$returnUrl = $paymentOpts['returnUrl'];
$cancel_return = $paymentOpts['cancel_return'];
$notify_url = $paymentOpts['notify_url'];
$currency_code = get_currency_type();
global $payable_amount,$post_title,$last_postid;

$post = get_posts($last_postid);
//print_r($post);
$user_info = get_userdata($last_postid);
$address1 = get_post_meta($last_postid,'address');
$address2 = get_post_meta($last_postid,'area');
$country = get_post_meta($last_postid,'add_country');
$state = get_post_meta($last_postid,'add_state');
$city = get_post_meta($last_postid,'add_city');
?>
<form name="frm_payment_method" action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="business" value="<?php echo $user_info->user_login; ?>">
<input type="hidden" name="item_name" value="<?php echo $user_info->first_name; ?>">
<input type="hidden" value="<?php echo $payable_amount;?>" name="amount"/>
<input name="address1" value="<?php echo $address1[0]; ?>" type="hidden">
<input name="address2" value="<?php echo $address2[0]; ?>" type="hidden">
<input name="first_name" value="<?php if($user_info->first_name){ echo $user_info->first_name; }else{ echo $user_info->user_login; } ?>" type="hidden">
<input name="middle_name" value="<?php echo $user_info->middle_name;; ?>" type="hidden">
<input name="last_name" value="<?php echo $user_info->last_name;; ?>" type="hidden">
<input name="lc" value="<?php echo ""; ?>" type="hidden">
<input name="country" value="<?php echo $country[0]; ?>" type="hidden">
<input name="state" value="<?php echo $state[0]; ?>" type="hidden">
<input name="city" value="<?php echo $city[0]; ?>" type="hidden">
<input name="on0" value="" type="hidden">
<input type="hidden" value="<?php echo $returnUrl;?>&pid=<?php echo $last_postid;?>" name="return"/>
<input type="hidden" value="<?php echo $cancel_return;?>&pid=<?php echo $last_postid;?>" name="cancel_return"/>
<input type="hidden" value="<?php echo $notify_url;?>" name="notify_url"/>
<input type="hidden" value="_xclick" name="cmd"/>
<input type="hidden" value="<?php echo $post_title;?>" name="item_name"/>
<input type="hidden" value="<?php echo $merchantid;?>" name="business"/>
<input type="hidden" value="<?php echo $currency_code;?>" name="currency_code"/>
<input type="hidden" value="<?php echo $last_postid;?>" name="custom" />
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="no_shipping" value="1">
</form>

<div class="wrapper" >
		<div class="clearfix container_message">
            	<center><h1 class="head2"><?php echo PAYPAL_MSG;?></h1></center>
         </div>
</div>
<script>
setTimeout("document.frm_payment_method.submit()",50); 
</script> 