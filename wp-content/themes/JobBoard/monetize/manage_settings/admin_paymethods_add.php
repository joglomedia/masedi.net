<?php
global $wpdb;
if($_POST)
{
	$paymentupdsql = "select option_value from $wpdb->options where option_id='".$_GET['id']."'";
	$paymentupdinfo = $wpdb->get_results($paymentupdsql);
	if($paymentupdinfo)
	{
		foreach($paymentupdinfo as $paymentupdinfoObj)
		{
			$option_value = unserialize($paymentupdinfoObj->option_value);
			$payment_method = trim($_POST['payment_method']);
			$display_order = trim($_POST['display_order']);
			$paymet_isactive = $_POST['paymet_isactive'];
			
			if($payment_method)
			{
				$option_value['name'] = $payment_method;
			}
			$option_value['display_order'] = $display_order;
			$option_value['isactive'] = $paymet_isactive;
			
			$paymentOpts = $option_value['payOpts'];
			for($o=0;$o<count($paymentOpts);$o++)
			{
				$paymentOpts[$o]['value'] = $_POST[$paymentOpts[$o]['fieldname']];
			}
			$option_value['payOpts'] = $paymentOpts;
			$option_value_str = serialize($option_value);
		}
	}
	
	$updatestatus = "update $wpdb->options set option_value= '$option_value_str' where option_id='".$_GET['id']."'";
	$wpdb->query($updatestatus);
	$location = site_url()."/wp-admin/admin.php";
	echo '<form method=get name="payment_setting_frm" acton="'.$location.'#option_payment">
	<input type="hidden" name="id" value="'.$_GET['id'].'"><input type="hidden" name="page" value="manage_settings"><input type="hidden" name="payact" value="setting"><input type="hidden" name="msg" value="success"></form>
	<script>document.payment_setting_frm.submit();</script>
	';
	
}
if($_GET['status']!= '')
{
	$option_value['isactive'] = $_GET['status'];
}
	$paymentupdsql = "select option_value from $wpdb->options where option_id='".$_GET['id']."'";
	$paymentupdinfo = $wpdb->get_results($paymentupdsql);
	if($paymentupdinfo)
	{
		foreach($paymentupdinfo as $paymentupdinfoObj)
		{
			$option_value = unserialize($paymentupdinfoObj->option_value);
			$paymentOpts = $option_value['payOpts'];
		}
	}
?>
<form action="<?php echo site_url();?>/wp-admin/admin.php?page=manage_settings&payact=setting&id=<?php echo $_GET['id'];?>#option_payment" method="post" name="payoptsetting_frm">
<input type="submit" name="submit" value="<?php _e('Save all changes','templatic'); ?>" onclick="return chk_form();" class="button-framework-imp right position_top" />
<h4><?php echo $option_value['name'];?> <?php _e('Settings','templatic'); ?> 

<a href="<?php echo site_url();?>/wp-admin/admin.php?page=manage_settings#option_payment" name="btnviewlisting" class="l_back" title="<?php _e('Back to Payment Options List','templatic');?>"/><?php _e('&laquo; Back to Payment Options List','templatic'); ?></a>
</h4>
<p class="notes_spec"><?php _e('Here you can edit the payment option settings. Double check the values you enter here to avoid payment related problems.','templatic');?></p>

  <?php if($_GET['msg']){?>
  <div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;" >
    <?php _e('Updated Succesfully','templatic'); ?>
  </div>
  <?php }?>
  
  <div class="option option-select"  >
    <h3><?php _e('Payment method name','templatic'); ?> :</h3>
    <div class="section">
      <div class="element">
         <input type="text" name="payment_method" id="payment_method" value="<?php echo $option_value['name'];?>" size="50" />
   		</div>
    </div>
  </div> <!-- #end -->
  
  
  <div class="option option-select"  >
    <h3><?php _e('Status','templatic'); ?> :</h3>
    <div class="section">
      <div class="element">
         <select name="paymet_isactive" id="paymet_isactive">
            <option value="1" <?php if($option_value['isactive']==1){?> selected="selected" <?php }?>><?php _e('Activate','templatic');?></option>
            <option value="0" <?php if($option_value['isactive']=='0' || $option_value['isactive']==''){?> selected="selected" <?php }?>><?php _e('Deactivate','templatic');?></option>
          </select>
   		</div>
    </div>
  </div> <!-- #end -->
  
  
  <div class="option option-select"  >
    <h3><?php _e('Position (Display order)','templatic'); ?> :</h3>
    <div class="section">
      <div class="element">
         <input type="text" name="display_order" id="display_order" value="<?php echo $option_value['display_order'];?>" size="50"  />
   		</div>
      <div class="description"><?php _e('This is a numeric value that determines the position of this payment option in the list. e.g. 5','templatic'); ?></div>
    </div>
  </div> <!-- #end -->
  
  
  
     
    
      <?php
	  
for($i=0;$i<count($paymentOpts);$i++)
{
	$payOpts = $paymentOpts[$i];
?>
	<div class="option option-select"  >
    <h3><?php echo $payOpts['title'];?></h3>
    <div class="section">
      <div class="element">
         <input type="text" name="<?php echo $payOpts['fieldname'];?>" id="<?php echo $payOpts['fieldname'];?>" value="<?php echo $payOpts['value'];?>" size="50"  />
   		</div>
      <div class="description"><?php echo $payOpts['description'];?></div>
    </div>
  </div> <!-- #end -->
      
      <?php
}
?>
<input type="submit" name="submit" value="<?php _e('Save all changes','templatic'); ?>" onclick="return chk_form();" class="button-framework-imp right position_bottom" />
		
</form>
<script>
function chk_form()
{
	if(document.getElementById('payment_method').value == '')
	{
		
		alert('<?php _e('Please enter Payment Method','templatic');?>');
		document.getElementById('payment_method').focus();
		return false;
	}
	return true;
}
</script>
