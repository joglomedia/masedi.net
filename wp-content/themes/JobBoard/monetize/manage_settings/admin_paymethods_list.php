<?php 
global $wpdb;

if($_GET['status']!='' && $_GET['id']!='')
{
	$paymentupdsql = "select option_value from $wpdb->options where option_id='".$_GET['id']."'";
	$paymentupdinfo = $wpdb->get_results($paymentupdsql);
	if($paymentupdinfo)
	{
		foreach($paymentupdinfo as $paymentupdinfoObj)
		{
			$option_value = unserialize($paymentupdinfoObj->option_value);
			$option_value['isactive'] = $_GET['status'];
			$option_value_str = serialize($option_value);
			$message = "Status updated successfully.";
		}
	}
	
	$updatestatus = "update $wpdb->options set option_value= '$option_value_str' where option_id='".$_GET['id']."'";
	$wpdb->query($updatestatus);
}


$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_%'";
$paymentinfo = $wpdb->get_results($paymentsql);
?>
<h4><?php _e('Manage payment options','templatic');?></h4>

<p class="notes_spec"> <?php _e('Activate/deactivate and manage payment gateway options here.','templatic');?></p>

<?php if($message){?>
<div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;" >
  <?php _e($message,'templatic');?>
</div>
<?php }?>
<table style=" width:50%"  class="widefat post fixed" >
  <thead>
    <tr>
      <th width="210"><?php _e('Payment method','templatic');?></th>
      <th width="140"><?php _e('Active?','templatic');?></th>
      <th width="140" align="center"><?php _e('Display order','templatic');?></th>
      <th width="60" align="center"><?php _e('Action','templatic');?></th>
    </tr>
    <?php
if($paymentinfo)
{
	foreach($paymentinfo as $paymentinfoObj)
	{
		$paymentInfo = unserialize($paymentinfoObj->option_value);
		$option_id = $paymentinfoObj->option_id;
		$paymentInfo['option_id'] = $option_id;
		$paymentOptionArray[$paymentInfo['display_order']][] = $paymentInfo;
	}
	ksort($paymentOptionArray);
	foreach($paymentOptionArray as $key=>$paymentInfoval)
	{
		for($i=0;$i<count($paymentInfoval);$i++)
		{
			$paymentInfo = $paymentInfoval[$i];
			$option_id = $paymentInfo['option_id'];
		?>
	<tr>
      <td><?php echo $paymentInfo['name'];?></td>
      <td><?php if($paymentInfo['isactive']){ _e("Yes",'templatic');}else{	_e("No",'templatic');}?></td>
      <td><?php echo $paymentInfo['display_order'];?></td>
      <td><?php if($paymentInfo['isactive']==1)
	{
		echo '<a title="Click to de-activate" href="'.site_url().'/wp-admin/admin.php?page=manage_settings&status=0&id='.$option_id.'#option_payment"><img style="width:11px; height:11px; margin-bottom:2px;" src="'.get_template_directory_uri().'/images/online.png" alt="Active payment option"></a>';
	}else
	{
		echo '<a title="'.__('Click to activate','templatic').'" href="'.site_url().'/wp-admin/admin.php?page=manage_settings&status=1&id='.$option_id.'#option_payment"><img style="width:11px; height:11px; margin-bottom:2px; opacity: 0.6;" src="'.get_template_directory_uri().'/images/offline.png" alt="'.__('Inactive payment option','templatic').'"></a>';
	}
	?>&nbsp;&nbsp;<?php
    echo '<a href="'.site_url().'/wp-admin/admin.php?page=manage_settings&payact=setting&id='.$option_id.'#option_payment"><img src="'.get_template_directory_uri().'/images/edit.png" alt="Edit payment option"></a>';
	?></td>
      <td>&nbsp;</td>
    </tr>
	
	
    <?php
		}
	}
}
?>
  </thead>
</table>
<div class="legend_section">
<h5><?php _e('Legend','templatic');?> :</h5>
<ul>
<li><img style="height: 11px; margin-left: 2px; margin-right: 13px; margin-top: 3px; width: 11px;" src="<?php echo get_template_directory_uri(); ?>/images/online.png" alt="<?php _e('Active payment option','templatic');?>" border="0" /> <?php _e('Active payment option','templatic');?></li>
<li><img style="height: 11px; margin-left: 2px; margin-right: 13px; margin-top: 3px; opacity: 0.6; width: 11px;" src="<?php echo get_template_directory_uri(); ?>/images/offline.png" alt="<?php _e('Inactive payment option','templatic');?>" border="0" /> <?php _e('Inactive payment option','templatic');?></li>
<li><img src="<?php echo get_template_directory_uri(); ?>/images/edit.png" alt="<?php _e('Edit payment option','templatic');?>" border="0" /> <?php _e('Edit payment option','templatic');?></li>
</ul>
</div>