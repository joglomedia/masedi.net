<?php
global $wpdb;	
if($_REQUEST['pagetype'] == 'deletecoupon' && $_REQUEST['code'] != '')
{
	$couponsql = "select option_value from $wpdb->options where option_name='discount_coupons'";
	$couponinfo = $wpdb->get_results($couponsql);
	if($couponinfo)
	{
		foreach($couponinfo as $couponinfoObj)
		{
			$option_value = unserialize($couponinfoObj->option_value);
			unset($option_value[$_REQUEST['code']]);
			$option_value_str = serialize($option_value);
			$updatestatus = "update $wpdb->options set option_value= '$option_value_str' where option_name='discount_coupons'";
			$wpdb->query($updatestatus);
		}
	}
	$location = site_url()."/wp-admin/admin.php";
	echo '<form action="'.$location.'#option_display_coupon" method=get name="coupon_success">
	<input type=hidden name="page" value="manage_settings"><input type=hidden name="msg" value="delsuccess"></form>';
	echo '<script>document.coupon_success.submit();</script>';
	exit;
} ?>
<h4><?php _e('Enable coupon option on &lsquo;Add Job&rsquo; page','templatic');?></h4> 
<?php if($_POST['save_allow_coupon_opt'])	{ ?>
	<div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;" >
		<?php _e('Coupon option updated successfully.','templatic'); ?>
	</div>
<?php update_option('is_allow_coupon_code',$_REQUEST['is_allow_coupon_code']);
 }	?>
<form method="post" action="#option_display_coupon" name="allow_coupon_frm">
	<input type="hidden" name="save_allow_coupon_opt" value="1" />
	<input type="radio" name="is_allow_coupon_code" id="is_allow_coupon_code" <?php if(get_option('is_allow_coupon_code')==1){ echo 'checked="checked"';}?>  value="1" />
	<label><?php _e('Yes','templatic');?></label>&nbsp;&nbsp;&nbsp;<input type="radio" name="is_allow_coupon_code" id="is_allow_coupon_code" value="0" <?php if(get_option('is_allow_coupon_code')==0){ echo 'checked="checked"';}?> />
	<label><?php _e('No','templatic');?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input type="submit" name="submit" value="<?php _e('Save','templatic'); ?>" class="button-framework-imp" />
</form><br /><br />




<h4><?php _e('Manage Coupon','templatic');?>

 <a href="<?php echo site_url().'/wp-admin/admin.php?page=manage_settings&mod=coupon#option_display_coupon';?>" title="<?php _e('Add New Coupon','templatic');?>" name="btnviewlisting" class="l_add_new" /><?php _e('Add New Coupon','templatic'); ?></a>
</h4>
 <p class="notes_spec"><?php _e('Add/Edit/Delete Coupon codes from here. Click on "Add New Coupon" to add a new coupon code','templatic');?></p>

  
<?php if($_REQUEST['msg']=='success'){?><br />
	<div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;" >
	 <?php if($_REQUEST['msg_type'] == 'update'){
	 	 _e('Coupon updated successfully.','templatic'); } else{
		 _e('Coupon created successfully.','templatic');
		 }?>
	</div>
<?php }?>
<?php if($_REQUEST['msg']=='delsuccess'){?>
	<div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;" >
  <?php _e('Coupon deleted successfully.','templatic'); ?>
	</div>
<?php }?>	
<table width="100%" cellpadding="5" class="widefat post fixed" >
	<thead>						
		<tr>
		  <th align="left"><?php _e('Coupon Code','templatic'); ?></th>
		  <th align="left"><?php _e('Discount type','templatic'); ?></th>
		  <th align="left"><?php _e('Discount amount','templatic'); ?></th>
		  <th align="left" width="50"><?php _e('Action','templatic'); ?></th>
		</tr>
		<?php
		$couponsql = "select option_value from $wpdb->options where option_name='discount_coupons'";
		$couponinfo = $wpdb->get_results($couponsql);
		if($couponinfo)
		{
		foreach($couponinfo as $couponinfoObj)
		{
			$option_value = unserialize($couponinfoObj->option_value);
			foreach($option_value as $key=>$value)
			{
		?>
		<tr>
		  <td><?php echo $value['couponcode'];?></td>
		  <td><?php echo $value['dis_per'];?></td>
		  <td><?php echo $value['dis_amt'];?></td>
		  <td><a href="<?php echo site_url().'/wp-admin/admin.php?page=manage_settings&mod=coupon&code='.$key.'&#option_display_coupon';?>" title="<?php _e('Edit Coupon','templatic');?>"><img src="<?php echo get_template_directory_uri(); ?>/images/edit.png" alt="<?php _e('Edit Coupon','templatic');?>" border="0" /></a> &nbsp;&nbsp;<a href="<?php echo site_url().'/wp-admin/admin.php?page=manage_settings&pagetype=deletecoupon&code='.$key;?>" title="<?php _e('Delete Coupon','templatic');?>" onclick="return confirmSubmit();"><img src="<?php echo get_template_directory_uri(); ?>/images/delete.png" alt="<?php _e('Delete Coupon','templatic');?>" border="0" /></a></td>
		</tr>
<?php		}
		}
	}else{
	echo "<td colspan='4'>No coupons available</td>";
	}
?>
	</thead>					
</table>
<div class="legend_section">
<h5><?php _e('Legend','templatic');?> :</h5>
<ul>
<li><img src="<?php echo get_template_directory_uri(); ?>/images/edit.png" alt="<?php _e('Edit Coupon','templatic');?>" border="0" /> <?php _e('Edit Coupon','templatic');?></li>
<li><img src="<?php echo get_template_directory_uri(); ?>/images/delete.png" alt="<?php _e('Delete Coupon','templatic');?>" border="0" /> <?php _e('Delete Coupon','templatic');?></li>
</ul>
</div>