<?php
global $wpdb,$custom_post_meta_db_table_name;
if($_REQUEST['pagetype']=='delete')
{
	$cid = $_REQUEST['field_id'];
	$wpdb->query("delete from $custom_post_meta_db_table_name where cid=\"$cid\"");
	$url = site_url().'/wp-admin/admin.php';
	echo '<form action="'.$url.'#option_display_custom_fields" method="get" id="frm_custom_field" name="frm_custom_field">
	<input type="hidden" value="manage_settings" name="page"><input type="hidden" value="delsuccess" name="custom_field_msg">
	</form>
	<script>document.frm_custom_field.submit();</script>
	';exit;	
}
?>
	<h4><?php _e('Manage custom fields','templatic');?> <a href="<?php echo site_url().'/wp-admin/admin.php?page=manage_settings&mod=custom_fields#option_display_custom_fields';?>" title="<?php _e('Add custom field','templatic');?>" name="btnviewlisting" class="l_add_new" /><?php _e('Add a  custom field','templatic'); ?></a> </h4>
    
    <p class="notes_spec"><?php _e('Custom fields help you ask additional information from listing adders. You can setup these fields as per category basis, which means a field meant for &lsquo;Food&rsquo; category won&rsquo;t appear in &lsquo;Art&rsquo; category. ','templatic');?></p>


<?php if(isset($_REQUEST['custom_field_msg'])) {?>
<div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;" >
<?php if($_REQUEST['custom_field_msg']=='delsuccess'){
		_e('Custom field deleted successfully.','templatic');	
	} if($_REQUEST['custom_field_msg']=='success'){
		if($_REQUEST['custom_msg_type']=='add') {
			_e('Custom field created successfully.','templatic');
		} else {
			_e('Custom field updated successfully.','templatic');
		}
	}
?></div>
<?php } ?>
<table width="100%"  class="widefat post" >
  <thead>
    <tr>
      <th><?php _e('Field name','templatic');?></th>
      <th><?php _e('Shown in post-type','templatic');?></th>
      <th align="center"><?php _e('Type','templatic');?></th>
      <th align="center"><?php _e('Active?','templatic');?></th>
      <th><?php _e('Action','templatic');?></th>
    </tr>
<?php
$post_meta_info = $wpdb->get_results("select * from $custom_post_meta_db_table_name order by sort_order asc,admin_title asc");
if($post_meta_info){
	foreach($post_meta_info as $post_meta_info_obj){
	?>
     <tr>
      <td><?php echo $post_meta_info_obj->admin_title;?></td>
      <td><?php echo $post_meta_info_obj->post_type;?></td>
      <td><?php echo $post_meta_info_obj->ctype;?></td>
      <td><?php if($post_meta_info_obj->is_active) _e('Yes','templatic'); else _e('No','templatic');?></td>
      <td>
	 <a href="javascript:void(0);showdetail('<?php echo $post_meta_info_obj->cid;?>');"><img src="<?php echo get_template_directory_uri(); ?>/images/details.png" alt="<?php _e('Detail','templatic');?>" title="<?php _e('Detail','templatic');?>" border="0" /></a> &nbsp;&nbsp; 
	 <a href="<?php echo site_url().'/wp-admin/admin.php?page=manage_settings&mod=custom_fields&field_id='.$post_meta_info_obj->cid.'#option_display_custom_fields';?>" title="<?php _e('Edit Field','templatic');?>">
	 <img src="<?php echo get_template_directory_uri(); ?>/images/edit.png" alt="<?php _e('Edit Field','templatic');?>" border="0" /></a> <?php if($post_meta_info_obj->is_delete=='1'){?>&nbsp;&nbsp;
	  <a href="<?php echo site_url().'/wp-admin/admin.php?page=manage_settings&pagetype=delete&field_id='.$post_meta_info_obj->cid;?>#option_display_custom_fields" onclick="return confirmSubmit();" title="<?php _e('Delete field','templatic');?>"><img src="<?php echo get_template_directory_uri(); ?>/images/delete.png" alt="<?php _e('Delete Field','templatic');?>" border="0" /></a><?php }else{ ?>
	  <img title="<?php _e("This field is undeletable (locked). To unlock it, click 'Edit' and set 'Is deletable?' to 'Yes'",'templatic');?>" src="<?php echo get_template_directory_uri(); ?>/images/lock.gif" alt="<?php _e('Locked','templatic');?>" border="0" style="margin:0px 0px 0px 9px;"/>
	  <?php } ?>
      </td>
      </tr>
      <tr id="detail_<?php echo $post_meta_info_obj->cid;?>" style="display:none;">
      <td colspan="5">
      <table style="background-color:#eee;" width="100%">
      <tr>
        <td><?php _e('Field name','templatic')?> : <strong><?php echo $post_meta_info_obj->admin_title;?></strong></td>
        <td><?php _e('Category ','templatic')?> : <strong><?php get_categoty_name($post_meta_info_obj->field_category);?></strong></td>
        <td><?php _e('Shown in post-type','templatic')?> : <strong><?php echo $post_meta_info_obj->post_type;?></strong></td>

     </tr> 
	<tr>
		<td><?php _e('Display order','templatic')?> : <strong><?php echo $post_meta_info_obj->sort_order;?></strong></td>
		<td><?php _e('Field type','templatic')?> : <strong><?php echo $post_meta_info_obj->ctype;?></strong></td>
		<td><?php _e('Default value','templatic')?> : <strong><?php echo $post_meta_info_obj->default_value;?></strong></td>
	</tr>
	<tr>    
		<td><?php _e('Shown on Details page?','templatic')?> : <strong><?php if($post_meta_info_obj->show_on_detail) _e('Yes','templatic'); else _e('No','templatic');?></strong></td>
		<td><?php _e('Field name (Front-end)','templatic')?> : <strong><?php echo $post_meta_info_obj->site_title;?></strong></td>
        <td><?php _e('Active?','templatic')?> : <strong><?php if($post_meta_info_obj->is_active) _e('Yes','templatic'); else _e('No','templatic');?></strong></td>
		
	</tr>
      
       <tr>   
		<td><?php _e('Shown on &lsquo;Add place&rsquo; page?','templatic')?> : <strong><?php if($post_meta_info_obj->show_on_listing) _e('Yes','templatic'); else _e('No','templatic');?></strong></td>	   
      	<td><?php _e('HTML variable name','templatic')?> : <strong><?php echo $post_meta_info_obj->htmlvar_name;?></strong></td>
		
         <td><?php  _e('CSS class','templatic'); if($post_meta_info_obj->style_class != "") { ?> : <strong><?php echo $post_meta_info_obj->style_class;?></strong><?php }else{ echo " - ";} ?></td>
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
function showdetail(custom_id)
{
	if(document.getElementById('detail_'+custom_id).style.display=='none')
	{
		document.getElementById('detail_'+custom_id).style.display='';
	}else
	{
		document.getElementById('detail_'+custom_id).style.display='none';	
	}
}
</script>
<div class="legend_section">
<h5><?php _e('Legend','templatic');?> :</h5>
<ul>
<li><img src="<?php echo get_template_directory_uri(); ?>/images/details.png" alt="<?php _e('Detail field','templatic');?>" border="0" /> <?php _e('Field details','templatic');?></li>
<li><img src="<?php echo get_template_directory_uri(); ?>/images/edit.png" alt="<?php _e('Edit field','templatic');?>" border="0" />  <?php _e('Edit field','templatic');?></li>
<li><img src="<?php echo get_template_directory_uri(); ?>/images/delete.png" alt="<?php _e('Delete field','templatic');?>" border="0" /> <?php _e('Delete field','templatic');?></li>
<li> <img title="<?php _e('Locked');?>" src="<?php echo get_template_directory_uri(); ?>/images/lock.gif" alt="<?php _e('Locked');?>" border="0" /><?php _e('This field is undeletable (locked). To unlock it, click &lsquo;Edit&rsquo; and set &lsquo;Is deletable?&rsquo; to &lsquo;Yes&rsquo;','templatic');?></li>
</ul>
</div>