<?php
$paymentOpts = get_payment_optins($_REQUEST['paymentmethod']);
$instId = $paymentOpts['instId'];
$accId1 = $paymentOpts['accId1'];
$currency_code = get_currency_type();
global $payable_amount,$post_title,$last_postid,$current_user;
$display_name = $current_user->display_name;
$user_email = $current_user->user_email;
?>
<form action="https://select.worldpay.com/wcc/purchase" method="post" target="_top" name="frm_payment_method">	
<input type="hidden" value="<?php echo $payable_amount;?>" name="amount"/>
<input type="hidden" value="<?php echo $instId;?>" name="instId"/>
<input type="hidden" value="<?php echo $accId1;?>" name="accId1"/>
<input type="hidden" value="<?php echo $orderNumber;?>" name="cartId"/>
<input type="hidden" value="<?php echo $post_title;?>" name="desc"/>
<input type="hidden" value="<?php echo $currency_code;?>" name="currency"/>
<input type="hidden" value="" name="testMode"/>
</form>
 
 
  <div class="wrapper" >
    <div class="clearfix container_message">
            <h1 class="head2"><?php echo WORLD_PAY_MSG;?></h1>
    </div>

<script>
setTimeout("document.frm_payment_method.submit()",50);
</script>