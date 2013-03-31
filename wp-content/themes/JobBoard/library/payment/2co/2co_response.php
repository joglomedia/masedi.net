<?php
$paymentOpts = get_payment_optins($_REQUEST['paymentmethod']);
$merchantid = $paymentOpts['vendorid'];
if($merchantid == '')
{
	$merchantid = '1303908';
}
$ipnfilepath = $paymentOpts['ipnfilepath'];
if($ipnfilepath == '')
{
	$ipnfilepath = get_option('siteurl')."/?page=notifyurl&pmethod=2co";
}
global $payable_amount,$post_title,$last_postid,$current_user;
$currency_code = get_currency_type();
$display_name = $current_user->display_name;
$user_email = $current_user->user_email;
?>

<form method="post" action="https://www.2checkout.com/checkout/purchase" name="frm_payment_method">
<input type="hidden" value="73453" name="c_prod"/>
<input type="hidden" value="<?php echo $post_title;?>" name="c_name"/>
<input type="hidden" value="<?php echo $post_title;?>" name="c_description"/>
<input type="hidden" value="<?php echo $payable_amount;?>" name="c_price"/>
<input type="hidden" value="1" name="id_type"/>
<input type="hidden" value="<?php echo $last_postid;?>" name="cart_order_id"/>
<input type="hidden" value="<?php echo $payable_amount;?>" name="total"/>
<input type="hidden" value="<?php echo $merchantid;?>" name="sid"/>
<input type="hidden" name="c_tangible" value="N">
<input type='hidden' name='x_receipt_link_url' value='<?php echo $ipnfilepath;?>' />
<input type='hidden' name='x_amount' value='<?php echo $payable_amount;?>' />
<input type='hidden' name='x_login' value='<?php echo $merchantid;?>' />
<input type='hidden' name='x_invoice_num' value='<?php echo $last_postid;?>' />
<input type='hidden' name='x_first_name' value='<?php echo $display_name;?>' />
<input type='hidden' name='x_email' value='<?php echo $user_email;?>' />
<input type="hidden" name="tco_currency" value="<?php echo $currency_code;?>" />

<!--<input type="submit" value="Buy from 2CO" name="purchase" class="submit"/>-->
</form>

 <div class="wrapper" >
		<div class="clearfix container_message">
            	<center><h1 class="head2"><?php echo TWOCO_MSG;?></h1></center>
            </div>

<script>
setTimeout("document.frm_payment_method.submit()",50); 
</script>


        

 