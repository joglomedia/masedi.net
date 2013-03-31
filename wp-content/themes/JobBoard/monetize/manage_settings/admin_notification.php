<?php
global $notification_email,$notification_msg;
include_once(TT_MANAGE_SETTINGS_MODULES_PATH . 'notification_options.php');
if($_GET['mod'] == 'notification'){
if($_POST) {	
	if($notification_email)	{
		foreach($notification_email as $notification)
		{
			$subject_name = stripslashes($notification['subject'][0]);
			$content_name = stripslashes($notification['content'][0]);
			
			update_option("$subject_name",$_POST["$subject_name"]);
			update_option("$content_name",$_POST["$content_name"]);
		}
		
	}

	if($notification_msg)
	{
		foreach($notification_msg as $notification)
		{
			$content_name = stripslashes($notification['content'][0]);
			update_option("$content_name",$_POST["$content_name"]);
		}
		
	}
	
	
		$location = site_url()."/wp-admin/admin.php";
		echo '<form action="'.$location.'#option_emails" method=get name="femail_success">
		<input type=hidden name="page" value="manage_settings"><input type=hidden name="msg" value="email_success"></form>';
		echo '<script>document.femail_success.submit();</script>';
		exit;
} }
?>
<form action="<?php echo site_url();?>/wp-admin/admin.php?page=manage_settings&mod=notification#option_emails" name="emails" method="post">
<input type="submit" name="submit" value="<?php _e('Save all changes','templatic');?>" class="button-framework-imp position_top">
<h4><?php _e('Notification emails &amp; messages','templatic');?></h4>
<p class="notes_spec"><?php _e('Notification e-mails are sent to administrators and users while relevant messages are displayed on the site at different times such as when a new user registers or a payment process completes successfully. You may customize these emails and messages here.','templatic');?></p>
<?php if($_REQUEST['msg']=='email_success'){?>
<div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;" >
<?php _e('Notifications updated successfully.','templatic'); ?>
</div>
<?php }?>
<?php if($notification_email){?>
<p style="background: #f4f4f4; padding:10px; margin-bottom:20px;"><b><?php _e('Email setup', 'templatic');?></b></p>
<table width="100%" cellpadding="0" cellspacing="0" class="widefat post fixed" >
<thead>
<tr>
<th width="120" align="left"><?php _e('Email Type','templatic'); ?></th>
<th width="120" align="left"><?php _e('Email Subject','templatic'); ?></th>
<th width="320" align="left"><?php _e('Email Description','templatic'); ?></th>
</tr>
</thead>
<?php
foreach($notification_email as $notification)
{
	if($notification)
	{
		$subject_name = stripslashes($notification['subject'][0]);
		$content_name = stripslashes($notification['content'][0]);
			
		$subject_val = stripslashes(get_option("$subject_name"));
		$content_val = stripslashes(get_option("$content_name"));
		if(!$subject_val){$subject_val = stripslashes($notification['subject'][1]);}
		if(!$content_val){$content_val = stripslashes($notification['content'][1]);}
		?>
		<tr>
		<td><?php echo $notification['title'];?></td>
		<td><textarea style="width:120px; height:150px;" name="<?php echo $subject_name;?>"><?php echo $subject_val;?></textarea></td>
		<td><textarea style="width:320px; height:150px;" name="<?php echo $content_name;?>"><?php echo $content_val;?></textarea></td>
		</tr>
    <?php
	}
}
?>
</table>
<?php }?>
<?php if($notification_msg){ ?>
<p style="background: #f4f4f4; padding:10px; margin-bottom:20px;"><b><?php _e('Messages setup','templatic');?></b></p>
<table width="100%" class="widefat post fixed" >
<thead>
<tr>
  <th width="138" align="left"><?php _e('Title','templatic'); ?></th>
  <th align="left" colspan="2"><?php _e('Description','templatic'); ?></th>
</tr>
</thead>
<?php
foreach($notification_msg as $notification)
{
	if($notification)
	{
		$infoarr = $notification;
		$content_name = stripslashes($notification['content'][0]);
		$content_val = stripslashes(get_option("$content_name"));
		if(!$content_val){$content_val = stripslashes($notification['content'][1]);}
		?>
		<tr>
		<td><?php echo $notification['title'];?></td>
		<td colspan="2"><textarea rows="5" name="<?php echo $content_name;?>"><?php echo $content_val;?></textarea></td>
		</tr>
	<?php
	}
}
?>
</table>
<?php }?>
<?php echo legend_notification();?>
<input type="submit" name="submit" value="<?php _e('Save all changes','templatic');?>" class="button-framework-imp position_bottom"><input type="hidden" name="notification_type" value="emails " > 
</form>
