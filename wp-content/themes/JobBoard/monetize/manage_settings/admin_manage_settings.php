<?php
include 'tab_header.php';
?>
<!-- Add /Edit Form For Custom Fields BOF -->
<link rel="stylesheet" href="<?php echo PLUGIN_URL_MANAGE_SETTINGS;?>css/style.css">
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="<?php echo PLUGIN_URL_MANAGE_SETTINGS;?>js/manage_settings.js"></script>

<div class="block" id="option_emails">
	<?php include_once('admin_notification.php');?>
</div>
<div class="block" id="option_display_custom_fields">
<?php if($_REQUEST['mod'] == 'custom_fields'){
		include_once('admin_manage_custom_fields_edit.php');
	} else {
		include( 'admin_manage_custom_fields_list.php' ); 
	} ?>
</div>
<div class="block" id="option_display_custom_usermeta">
<?php if($_REQUEST['mod'] == 'user_meta'){
		include_once('admin_custom_usermeta_edit.php');
	} else {
		include( 'admin_custom_usermeta_list.php' ); 
	} ?>
</div>
<div class="block" id="option_display_price">
<?php if($_REQUEST['mod'] == 'price'){
		include_once('admin_price_add.php');
	} else {
		include( 'admin_package_list.php' ); 
	} ?>
</div>
<div class="block" id="option_display_coupon">
	<?php if($_GET['mod']=='coupon')
	{
		include_once('admin_coupon.php');
	} else {
		include('admin_manage_coupon.php' ); 
	} ?>
</div>
<div class="block" id="option_bulk_upload">	
	<?php include_once('admin_bulk_upload.php');?>
</div>
<div class="block" id="option_payment">	
<?php if($_GET['payact']=='setting' && $_GET['id']!='')
	{
		include_once('admin_paymethods_add.php');
	} else {
		include( 'admin_paymethods_list.php' ); 
	} ?>
</div>

<div class="block" id="option_transaction_settings">	
	<?php include_once('admin_transaction_report.php');?>
</div>
<div class="block" id="option_ip_settings">	
	<?php include_once('admin_ip_settings.php');?>
</div>
<?php include TT_ADMIN_TPL_PATH.'footer.php';?>