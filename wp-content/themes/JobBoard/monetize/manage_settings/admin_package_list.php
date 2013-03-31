<?php
global $wpdb,$price_db_table_name;
if($_REQUEST['pagetype'] == 'deleteprice' && $_REQUEST['price_id'] != '')
{
	$price_id = $_REQUEST['price_id'];
	$wpdb->query("delete from $price_db_table_name where pid=\"$price_id\"");
	$location = site_url()."/wp-admin/admin.php";
	echo '<form action="'.$location.'#option_display_price" method=get name="price_success">
	<input type=hidden name="page" value="manage_settings"><input type=hidden name="msg" value="delpricesuccess"></form>';
	echo '<script>document.price_success.submit();</script>';
	exit;
}
?>
<script>
function delete_pack(packid)
{ 
	var answer = confirm("<?php echo DELETE_CONFIRM_ALERT; ?>");
	if (answer){
	if (packid=="")
	  {
	  document.getElementById("package_list").innerHTML="";
	  return;
	  }else{
	  document.getElementById("package_list").innerHTML="";
	  document.getElementById("package_list1").style.display ="";
	  }
		if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
		else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		xmlhttp.onreadystatechange=function()
	  {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		document.getElementById("package_list1").style.display ="none";
		//document.getElementById("message").style.display ="none";
		document.getElementById("package_list").innerHTML=xmlhttp.responseText;
		}
	  } 
	  url = "<?php echo get_template_directory_uri(); ?>/monetize/manage_settings/ajax_manage_settings.php?package_id="+packid
	  xmlhttp.open("GET",url,true);
	  xmlhttp.send();
	  }else{
		alert("<?php echo NO_ACTION; ?>");
	}
} 
</script>
<h4><?php _e('Manage price packages','templatic');?>
<a href="<?php echo site_url().'/wp-admin/admin.php?page=manage_settings&mod=price#option_display_price';?>" title="<?php _e('Add new price','templatic');?>" name="btnviewlisting" class="l_add_new" ><?php _e('Add new price package','templatic'); ?></a>
</h4>
<p class="notes_spec"><?php _e('Add, edit and manage price packages from here. To create a new package, click &lsquo;Add new price package&rsquo; link above.','templatic');?></p>

<?php if($_REQUEST['msg']=='pricesuccess'){?>
<div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;" >
  <?php if($_REQUEST['msgtype'] == 'add_price') {
		_e('Price package added successfully.','templatic'); 
	} else {
		_e('Price package has been updated successfully.','templatic'); 
	}?>
</div>
<?php }?>
<?php if($_REQUEST['msg']=='delpricesuccess'){?>
<div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;" >
  <?php _e('Price package has been deleted successfully.','templatic'); ?>
</div>
<?php }?>
<div id="package_list">
<?php
	include("ajax_list_price_package.php");
?> 
</div>	
<div id="package_list1" style="display:none">
<?php
	include("ajax_list_price_package.php");
?> 
</div>
<div class="legend_section">
    <h5><?php _e('Legend','templatic');?> :</h5>
    <ul>
        <li><img border="0" title="Detail" alt="Detail" src="<?php echo get_template_directory_uri(); ?>/images/details.png"><?php _e('View price package details','templatic');?></li>
        <li><img src="<?php echo get_template_directory_uri(); ?>/images/edit.png" alt="<?php _e('Edit price package','templatic');?>" border="0" /> <?php _e('Edit price package','templatic');?></li>
        <li><img src="<?php echo get_template_directory_uri(); ?>/images/delete.png" alt="<?php _e('Delete price package','templatic');?>" border="0" /> <?php _e('Delete price package','templatic');?> </li>
    <ul>
</div>