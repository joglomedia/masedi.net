<?php
$custom_usermeta_db_table_name = $table_prefix . "templatic_custom_usermeta";
global $wpdb,$custom_usermeta_db_table_name;
if($_REQUEST['user_pagetype']=='delete')
{
	$cid = $_REQUEST['cf'];
	$wpdb->query("delete from $custom_usermeta_db_table_name where cid=\"$cid\"");
	$url = site_url().'/wp-admin/admin.php';
	echo '<form action="'.$url.'#option_display_custom_usermeta" method="get" id="frm_user_emta" name="frm_user_emta">
	<input type="hidden" value="manage_settings" name="page"><input type="hidden" value="delsuccess" name="usermetamsg">
	</form>
	<script>document.frm_user_emta.submit();</script>
	';exit;	
}
?>

<h4><?php _e('Manage user profile fields','templatic');?>  
<a href="<?php echo site_url().'/wp-admin/admin.php?page=manage_settings&mod=user_meta#option_display_custom_usermeta';?>" title="<?php _e('Add a field for users&rsquo; profile','templatic');?>" name="btnviewlisting" class="l_add_new" /><?php _e('Add a new field','templatic'); ?></a>
</h4>

 <p class="notes_spec"><?php _e('The fields you add/edit here will be displayed in user&rsquo;s dashboard and profile area. Using these fields, you can make users fill in custom information about themselves.','templatic');?></p>

<?php
if($_REQUEST['usermetamsg']=='delsuccess')
{
	$message = __('Information Deleted successfully.','templatic');	
} if($_REQUEST['usermetamsg']=='usersuccess'){
	if($_REQUEST['msgtype']=='add') {
			$message = __('Custom user info field created successfully.','templatic');
		} else {
			$message = __('Custom user info field updated successfully.','templatic');
		}
}
?>
<?php if($message){?>
<div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;" >
  <?php echo $message;?>
</div>
<?php }?>
<table width="100%"  class="widefat post" >
  <thead>
    <tr>
      <th width="150"><?php _e('Title','templatic');?></th>
      <th align="center"><?php _e('Type','templatic');?></th>
      <th align="center" width="110"><?php _e('Active?','templatic');?></th>
      <th width="100"><?php _e('Display order','templatic');?></th>
      <th><?php _e('Action','templatic');?></th>
    </tr>
<?php

$post_meta_info_user = $wpdb->get_results("select * from $custom_usermeta_db_table_name order by sort_order asc,site_title asc");
if($post_meta_info_user){

	foreach($post_meta_info_user as $post_meta_info_obj){
	?>
     <tr>
      <td><?php echo $post_meta_info_obj->site_title;?></td>
      <td><?php echo $post_meta_info_obj->ctype;?></td>
      <td><?php if($post_meta_info_obj->is_active) _e('Yes','templatic'); else _e('No','templatic');?></td>
      <td><?php echo $post_meta_info_obj->sort_order;?></td>
      <td>
	 
	   <a href="javascript:void(0);user_showdetail('<?php echo $post_meta_info_obj->cid;?>');"><img src="<?php echo get_template_directory_uri(); ?>/images/details.png" alt="<?php _e('Detail','templatic');?>" title="<?php _e('Detail','templatic');?>" border="0" /></a> &nbsp;&nbsp; 
     <a href="<?php echo site_url().'/wp-admin/admin.php?page=manage_settings&mod=user_meta&cf='.$post_meta_info_obj->cid.'#option_display_custom_usermeta';?>" title="<?php _e('Edit field','templatic');?>"><img src="<?php echo get_template_directory_uri(); ?>/images/edit.png" alt="<?php _e('Edit field','templatic');?>" border="0" /></a> <?php if($post_meta_info_obj->is_delete=='0'){?>&nbsp;&nbsp; 
	  <a href="<?php echo site_url().'/wp-admin/admin.php?page=manage_settings&user_pagetype=delete&cf='.$post_meta_info_obj->cid;?>#option_display_custom_usermeta" onclick="return confirmSubmit();" title="<?php _e('Delete Field','templatic');?>"><img src="<?php echo get_template_directory_uri(); ?>/images/delete.png" alt="<?php _e('Delete field','templatic');?>" border="0" /></a><?php }?>
	  
      </td>
      </tr>
      <tr id="userdetail_<?php echo $post_meta_info_obj->cid;?>" style="display:none;">
      <td colspan="5">
      <table style="background-color:#eee;" width="100%">
      <tr>
        <td><?php _e('Title','templatic')?> :  <strong><?php echo $post_meta_info_obj->site_title;?><strong></td>
		<td><?php _e('HTML variable name','templatic')?> :  <strong><?php echo $post_meta_info_obj->htmlvar_name;?><strong></td>
		<td><?php _e('Display order','templatic')?> :  <strong><?php echo $post_meta_info_obj->sort_order;?><strong></td>
      </tr>
	  <tr>
		<td><?php _e('Type','templatic')?> :  <strong><?php echo $post_meta_info_obj->ctype;?><strong></td>
		<td><?php _e('Compulsary?','templatic')?> :  <strong><?php echo $post_meta_info_obj->is_require;?><strong></td>
        

		<td><?php _e('Active?','templatic')?> :  <strong><?php if($post_meta_info_obj->is_active) _e('Yes','templatic'); else _e('No','templatic');?><strong></td>
	  </tr>
		<tr>

			<td><?php _e('Display on registration page?','templatic')?> :  <strong><?php if($post_meta_info_obj->show_on_listing) _e('Yes','templatic'); else _e('No','templatic');?><strong></td>
			<td colspan="2"><?php _e('Display On Profile page?','templatic')?> :  <strong><?php if($post_meta_info_obj->show_on_detail) _e('Yes','templatic'); else _e('No','templatic');?><strong></td>
		</tr>
       <tr>        
        
      	
         <td colspan="3"><?php _e('Use at front end','templatic')?> :  <strong><?php if($post_meta_info_obj->is_delete=='0'){ echo $post_meta_info_obj->htmlvar_name;}elseif($post_meta_info_obj->is_delete=='1'){_e('Theme default field','templatic');}elseif($post_meta_info_obj->ctype=='head'){_e('Heading','templatic');}?><strong></td>
      </tr>
      </table>
      </td>
      </tr>
    <?php
	}
}else
{
?>

     <tr><td colspan="9"><?php _e('No custom fields available.','templatic');?></td></tr>
<?php		
}
?>
  </thead>
</table>
<script type="text/javascript">
function user_showdetail(custom_id)
{
	if(document.getElementById('userdetail_'+custom_id).style.display=='none')
	{
		document.getElementById('userdetail_'+custom_id).style.display='';
	}else
	{
		document.getElementById('userdetail_'+custom_id).style.display='none';	
	}
}
</script>
<div class="legend_section">
<h5><?php _e('Legend','templatic');?> :</h5>
<ul>
<li><img src="<?php echo get_template_directory_uri(); ?>/images/details.png" alt="<?php _e('Detail field','templatic');?>" border="0" />  <?php _e('Field details','templatic');?></li>
<li><img src="<?php echo get_template_directory_uri(); ?>/images/edit.png" alt="<?php _e('Edit field','templatic');?>" border="0" /> <?php _e('Edit field','templatic');?> </li>
<li><img src="<?php echo get_template_directory_uri(); ?>/images/delete.png" alt="<?php _e('Delete field','templatic');?>" border="0" /> <?php _e('Delete field','templatic');?></li>
</ul>
</div>