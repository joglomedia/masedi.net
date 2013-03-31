<?php 
global $post,$wpdb;
if($_POST['submit_ip'] != "" || isset($_POST['submit_ip']))
{	$countip = explode(",",$_POST['block_ip']);
	$countoldips = explode(",",$_POST['ipaddress2']);
	$new_array= array_diff($countoldips,$countip);
	// show array difference and update field
		if($new_array != "")
		{
			for($i=0 ; $i <=count($new_array) ; $i++)
			{
			foreach($new_array as $nip)
			{
				if($nip != ""){
				$ipres1 = $wpdb->get_results("select * from $wpdb->postmeta where meta_key='remote_ip' and meta_value = '".$nip."'");
				
				if(mysql_affected_rows() > 0)
				{
					foreach($ipres1 as $ipobj1)
					{ 
					update_post_meta($ipobj1->post_id,'ip_status',0);
					}
				}
				global $ip_db_table_name;
				$wpdb->query("update $ip_db_table_name set ipstatus='0' where ipaddress= '".$nip."'");
				}
			}}
		}
	$new_insert_array= array_diff($countip,$countoldips);
	
	// show array difference and insert field
		if($new_insert_array != "")
		{	
			global $ip_db_table_name;
			for($i=0 ; $i <=count($new_insert_array) ; $i++)
			{	
			foreach($new_insert_array as $nip)
			{	
		
				if($nip!= ""){
				$ipres1 = $wpdb->get_results("select * from $wpdb->postmeta where meta_key='remote_ip' and meta_value = '".$nip."'");
				$ipstatus = $wpdb->get_row("select * from $ip_db_table_name where ipaddress='".$nip."'");
				if($ipstatus != ""){
				$ipupdate = $wpdb->query("UPDATE $ip_db_table_name set ipstatus='1' where ipaddress = '".$nip."'");
				}else{
				$ipinsert = $wpdb->query("INSERT INTO $ip_db_table_name(`ipid`, `ipaddress`, `ipstatus`) VALUES (NULL,'".$nip."', '1')");
				}
				if(mysql_affected_rows() > 0)
				{
					foreach($ipres1 as $ipobj1)
					{ 
					update_post_meta($ipobj1->post_id,'ip_status',0);
					}
				}
				global $ip_db_table_name;
				$wpdb->query("update $ip_db_table_name set ipstatus='1' where ipaddress= '".$nip."'");
				}
			}}
		}
		
	global $ip_db_table_name;
	for($i =0; $i <= count($countip); $i++)
	{
		$countip[$i];
		if($countip[$i] != "")
		{
			$ipres = $wpdb->get_results("select * from $wpdb->postmeta where meta_value = '".$countip[$i]."'");
			
			if(mysql_affected_rows() > 0)
			{
				foreach($ipres as $ipobj)
				{ 
					update_post_meta($ipobj->post_id,'ip_status',1);
				}			
			}				
		}

		/* global $ip_db_table_name;
		
		$ipres1 = $wpdb->get_row("select * from $ip_db_table_name where ipaddress != '".$countip[$i]."'");
		if(mysql_affected_rows() >0)
		{		
		$wpdb->query("update $ip_db_table_name set ipstatus = '0' where ipaddress != '".$ipres1->ipaddress."'"); 
		} */
	}
 ?>
 <script>location.href = <?php echo site_url().'wp-admin/admin.php?page=manage_settings&mod=ipsettings&updated=1#option_ip_settings'; ?></script>

<?php }
if($_REQUEST['updated'] != "")
{ ?>
	 <div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;" >
 <?php _e('Record has been updated successfully.','templatic');?>
 </div>
<?php }
?>
<form action="<?php echo site_url().'/wp-admin/admin.php?page=manage_settings&mod=ipsettings&updated=1#option_ip_settings'; ?>" method="post" name="frmip">
<input type="submit" name="submit_ip" class="button-framework-imp right position_top" value="<?php _e('Save all changes','templatic');?>">		

<h4><?php _e('IP settings','templatic'); ?></h4>
<p><?php _e('The IP addresses you have blocked previously appear here. Once you remove them from the list below, they will be unblocked. Suspicious IP addresses should be added to the list below in order to prevent listings done from that IP.','templatic'); ?></p>
 <div class="option option-select"  >
	<h3><?php _e('Blocked IP addresses: ','templatic');?></h3>
		<div class="section">
			<div class="element">
				<textarea name="block_ip" id= "block_ip"><?php 
						global $ip_db_table_name;
						$parray = $wpdb->get_results("select * from $ip_db_table_name where ipstatus='1'");
						$mvalue = "";
						foreach($parray as $pay)
						{	
							$ip = $pay->ipaddress;
							$val = $pay->ipaddress;
							if($val != "")
							{	
								$mvalue .= $val.","; 
							}
						}echo trim($mvalue);
					?></textarea>
		<input type="hidden" name="ipaddress2" id="ipaddress2" value="<?php echo trim($mvalue); ?>"/>
		</div>
    </div>
  </div>
<input type="submit" name="submit_ip" class="button-framework-imp right position_bottom" value="<?php _e('Save all changes','templatic');?>">		
</form>