<?php /*?><?php
global $General, $Cart;
$paymentOpts = $General->get_payment_optins($_POST['paymentmethod']);
$instId = $paymentOpts['instId'];
$accId1 = $paymentOpts['accId1'];
$currency_code = $General->get_currency_code();
$cartInfo = $Cart->getcartInfo();
$amount = $Cart->getCartAmt();
$itemArr = array();
for($i=0;$i<count($cartInfo);$i++)
{
	$product_att = preg_replace('/([(])([+-])([0-9]*)([)])/','',$cartInfo[$i]['product_att']);
	$itemArr[] = $cartInfo[$i]['product_qty'].' X '.$cartInfo[$i]['product_name']."($product_att)";
}
$item_name = implode(', ',$itemArr);
?>
<form action="https://select.worldpay.com/wcc/purchase" method="post" target="_top" name="frm_payment_method">	
<input type="hidden" value="<?php echo $amount;?>" name="amount"/>
<input type="hidden" value="<?php echo $instId;?>" name="instId"/>
<input type="hidden" value="<?php echo $accId1;?>" name="accId1"/>
<input type="hidden" value="<?php echo $orderNumber;?>" name="cartId"/>
<input type="hidden" value="<?php echo $item_name;?>" name="desc"/>
<input type="hidden" value="<?php echo $currency_code;?>" name="currency"/>
<input type="hidden" value="" name="testMode"/>
</form><?php */?>