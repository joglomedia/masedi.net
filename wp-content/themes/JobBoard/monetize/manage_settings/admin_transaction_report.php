<?php 
global $wpdb,$transection_db_table_name;
$transrecordsperpage = 30;
$pagination = $_REQUEST['pagination'];
if($pagination == '')
{
	$pagination = 1;
}
$strtlimit = ($pagination-1)*$transrecordsperpage;
$endlimit = $strtlimit+$transrecordsperpage;
//----------------------------------------------------
$transsql_select = "select * ";
$transsql_count = "select count(t.trans_id) ";
$transsql_from= " from $transection_db_table_name as t ";
$transsql_conditions= " where (t.status=1 OR  t.status=0) ";
if($_REQUEST['id'])
{
	$id = $_REQUEST['id'];
	$transsql_conditions .= " and t.post_id = $id";
}
if($_REQUEST['srch_orderno'])
{
	$srch_orderno = $_REQUEST['srch_orderno'];
	$transsql_conditions .= " and t.trans_id = $srch_orderno";
}
if($_REQUEST['srch_name'])
{
	$srch_name = $_REQUEST['srch_name'];
	$transsql_conditions .= " and (t.billing_name like '%$srch_name%' OR t.pay_email like '%$srch_name%')";
}
if($_REQUEST['srch_payment'])
{
	$srch_payment = $_REQUEST['srch_payment'];
	$transsql_conditions .= " and t.payment_method like \"$srch_payment\"";
}

if($_REQUEST['srch_payid'])
{
	$srch_payid = $_REQUEST['srch_payid'];
	$transsql_conditions .= " and t.paypal_transection_id like '%$srch_payid%'";
}
$transsql_limit=" order by t.trans_id desc limit $strtlimit,$transrecordsperpage";

$_SESSION['query_string'] = $transsql_select.$transsql_from.$transsql_conditions;
$transsql_select.$transsql_from.$transsql_conditions;
$transinfo_count = $wpdb->get_results($transsql_select.$transsql_from.$transsql_conditions);

$transinfo = $wpdb->get_results($transsql_select.$transsql_from.$transsql_conditions.$transsql_limit);
$trans_total_pages = count($transinfo_count);


?>
<script>
function change_transstatus(tid){
		if (tid=="")
	  {
	  document.getElementById("p_status_"+tid).innerHTML="";
	  return;
	  }
	  if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }else{// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		xmlhttp.onreadystatechange=function()
	  {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("p_status_"+tid).innerHTML=xmlhttp.responseText;
		}
	  }
	  url = "<?php echo get_template_directory_uri(); ?>/library/functions/ajax_update_status.php?trans_id="+tid
	  xmlhttp.open("GET",url,true);
	  xmlhttp.send();
}
</script>
<h4><?php _e('Transaction Report','templatic');?></h4>
<div class="divright"><a href="<?php echo get_template_directory_uri().'/monetize/manage_settings/export_transaction.php';?>" title="Export To CSV" class="i_export"><?php _e('Export To CSV','templatic');?></a></div>
    <form method="post" action="<?php echo site_url('/wp-admin/admin.php?page=manage_settings#option_transaction_settings');?>" name="ordersearch_frm">
        <table cellspacing="1" cellpadding="4" border="0" width="100%" style="padding:5px;">
            <tr>
				<td valign="top"><strong><?php _e('Search by transaction ID','templatic'); ?> :</strong></td>
				<td valign="top"><input type="text" value="" name="srch_orderno" id="srch_orderno" style="width:100px;" /><br /></td>
				<td valign="top"><strong><?php _e('Payment Type','templatic'); ?> :</strong></td>
				
				<td valign="top">
				<?php
					$targetpage = site_url("/wp-admin/admin.php?page=manage_settings");
					$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_%' order by option_id";
					$paymentinfo = $wpdb->get_results($paymentsql);
					if($paymentinfo)
					{
						foreach($paymentinfo as $paymentinfoObj)
						{
							$paymentInfo = unserialize($paymentinfoObj->option_value);
							$paymethodKeyarray[$paymentInfo['key']] = $paymentInfo['key'];
							ksort($paymethodKeyarray);
						}
					} ?>
					<select name="srch_payment" style="width:150px;">
						<option value=""> <?php _e('Select Payment Type','templatic'); ?> </option>
						<?php foreach($paymethodKeyarray as $key=>$value) {
							if($value) { ?>
						<option value="<?php echo $value;?>" <?php if($value==$_REQUEST['srch_payment']){?> selected<?php }?>><?php echo $value;?></option>
						<?php }
						}?>
					</select></td>
			</tr>
			<tr>
				<td  valign="top"><strong><?php _e('Name/Email','templatic'); ?> :</strong></td>
				<td valign="top" colspan="3"><input type="text" value="" name="srch_name" id="srch_name"  style="width:120px;" /><br /></td>
				
			</tr>
			<tr>			
				<td  valign="top"><strong><?php _e('Payment Transaction ID','templatic'); ?> :</strong></td>
				<td valign="top" colspan="2"> <input type="text" value="" name="srch_payid" id="srch_payid"  style="width:200px;"/><br /></td>
				<td valign="top" >&nbsp;&nbsp;<input type="submit" name="Search" value="<?php _e('Search'); ?>" class="button-secondary action"  />&nbsp;<input type="reset" name="Default Reset" value="<?php _e('Reset'); ?>" onclick="window.location.href='<?php echo $targetpage;?>'" class="button-secondary action" /></td>
				
        </tr>
    </table>
    </form><br />
  <?php
if($trans_total_pages>0)
{ 

if($transinfo)
{ ?>
<table style="100%" cellpadding="5" class="widefat post fixed" >
  <thead>
    <tr>
    <th width="20" align="left"><?php _e('ID','templatic'); ?></th>
    <th align="left"><?php _e('Title','templatic'); ?></th>
    <th align="left"><?php _e('Name','templatic'); ?></th>
    <th align="left" width="150"><?php _e('Email','templatic'); ?></th>
    <th align="left"><?php _e('Payment method','templatic'); ?></th>
    <th align="left"><?php _e('Status','templatic');?></th>    
	<th align="left" width="40"><?php _e('Action','templatic');?></th>
    </tr>
	<?php foreach($transinfo as $transinfoObj)
	{
?>
    <tr>  
	  <td><?php echo $transinfoObj->trans_id;?></td>
      <td><?php echo $transinfoObj->post_title;?></td>
      <td><?php echo $transinfoObj->billing_name;?></td>
      <td><?php echo $transinfoObj->pay_email;?></td>
      <td><?php echo $transinfoObj->payment_method;?></td>
	  <td><?php get_transaction_status($transinfoObj->trans_id); ?></td>
      <td> <a href="javascript:void(0);reportshowdetail('<?php echo $transinfoObj->trans_id;?>');"><img src="<?php echo get_template_directory_uri(); ?>/images/details.png" alt="<?php _e('View details','templatic');?>" border="0" /></a></td>
    </tr>
	<tr id="reprtdetail_<?php echo $transinfoObj->trans_id;?>" style="display:none;">
		<td colspan="6">
			<table style="background-color:#eee;" width="100%">
				<tr>
					<td><?php _e('Title','templatic')?> : <strong><?php echo $transinfoObj->post_title;?></strong></td>
					<td><?php _e('Payment method','templatic')?> : <strong><?php echo $transinfoObj->payment_method;?></strong></td>
					<td><?php _e('Pay Date','templatic')?> : <strong><?php echo date('d/m/Y',strtotime($transinfoObj->payment_date));?></strong></td>
				</tr> 
				<tr>
					<td><?php _e('Billing name','templatic')?> : <strong><?php echo $transinfoObj->billing_name;?></strong></td>
					<td colspan="2"><?php _e('Billing address','templatic')?> : <strong><?php echo $transinfoObj->billing_add;?></strong></td>
				</tr> 
				
				<tr>
					<td colspan="3"><?php _e('Amount','templatic')?> : <strong><?php echo display_amount_with_currency(number_format($transinfoObj->payable_amt,2));?></strong></td>
					
				</tr>
			</table>
		</td>
      </tr>
    <?php
	}
}
if($trans_total_pages>$transrecordsperpage)
			{
?>
<tr><td colspan="6" align="center">
<?php echo get_pagination_of($targetpage,$trans_total_pages,$transrecordsperpage,$pagination,'#option_transaction_settings'); ?>
</td></tr>
<?php } ?>
  </thead>
</table>
 <?php
}else
{
?>
<strong><?php _e('No Transaction Available'); ?></strong>
      <?php
}
?>
<script>
function reportshowdetail(custom_id)
{
	if(document.getElementById('reprtdetail_'+custom_id).style.display=='none')
	{
		document.getElementById('reprtdetail_'+custom_id).style.display='';
	}else
	{
		document.getElementById('reprtdetail_'+custom_id).style.display='none';	
	}
}

</script>