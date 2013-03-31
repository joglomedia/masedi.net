<?php
global $wpdb,$custom_post_meta_db_table_name,$current_user;
$field_id = $_REQUEST['field_id'];
$post_meta_info = $wpdb->get_results("select * from $custom_post_meta_db_table_name where cid= \"$field_id\"");
if($post_meta_info){
	$post_val = $post_meta_info[0];
}else
{
	$post_val->sort_order = $wpdb->get_var("select max(sort_order)+1 from  $custom_post_meta_db_table_name");
}
if($_POST)
{
	$ctype = $_POST['ctype'];
	$admin_title = $_POST['admin_title'];
	if($ctype == 'head')
	  {
		 $admin_title = $_POST['site_title'];
	  }
	$cat_array1 = implode(",",$_POST['category']) ; 
	$field_cat = $cat_array1 ;
	$site_title = $_POST['site_title'];
	$htmlvar_name = $_POST['htmlvar_name'];
	$admin_desc = $_POST['admin_desc'];
	$clabels = $_POST['clabels'];
	$default_value = $_POST['default_value'];
	$sort_order = $_POST['sort_order'];
	$is_active = $_POST['is_active'];
	$show_on_listing = $_POST['show_on_listing'];
	$show_on_detail = $_POST['show_on_detail'];
	$show_on_page = $_POST['show_on_page'];
	$is_delete = $_POST['is_delete'];
	$is_edit = $_POST['is_edit'];
	$is_search = $_POST['is_search'];
	$ptype = explode(',',$_POST['post_type']);
	$my_post_type = $ptype[0];
	$option_values = $_POST['option_values'];
	$is_require = $_POST['is_require'];
	$extra_parameter = $_POST['extra_parameter'];
	$validation_type = $_POST['validation_type'];
	$field_require_desc = stripslashes($_POST['field_require_desc']);
	$style_class = $_POST['style_class'];
	$custom_field_check = $wpdb->get_var("SHOW COLUMNS FROM $custom_post_meta_db_table_name LIKE 'field_category'");
	if('field_category' != $custom_field_check)	{
		$custom_dbuser_table_alter = $wpdb->query("ALTER TABLE $custom_post_meta_db_table_name  ADD `field_category` TEXT NOT NULL AFTER `admin_title`");
	}
	$custom_editfield_check = $wpdb->get_var("SHOW COLUMNS FROM $custom_post_meta_db_table_name LIKE 'is_edit'");
	if('is_edit' != $custom_editfield_check)	{
		$custom_editdbuser_table_alter = $wpdb->query("ALTER TABLE $custom_post_meta_db_table_name  ADD `is_edit` tinyint(4) NOT NULL AFTER `is_delete`");
	}
	$custom_editfield_check = $wpdb->get_var("SHOW COLUMNS FROM $custom_post_meta_db_table_name LIKE 'is_search'");
	if('is_search' != $custom_editfield_check)	{
		$custom_editdbuser_table_alter = $wpdb->query("ALTER TABLE $custom_post_meta_db_table_name  ADD `is_search` tinyint(2) NOT NULL AFTER `is_require`");
	}if('show_on_page' != $custom_onpagefield_check)	{
		$custom_onpagefield_check = $wpdb->query("ALTER TABLE $custom_post_meta_db_table_name  ADD `show_on_page` char(10) NOT NULL AFTER `is_require`");
	}
		
	if($_REQUEST['field_id'])
	{
		$field_id = $_REQUEST['field_id'];
		$sql = "update $custom_post_meta_db_table_name set admin_title=\"$admin_title\",field_category= \"$field_cat\",post_type=\"$my_post_type\",site_title=\"$site_title\" ,ctype=\"$ctype\" ,htmlvar_name=\"$htmlvar_name\",admin_desc=\"$admin_desc\" ,clabels=\"$clabels\" ,default_value=\"$default_value\" ,sort_order=\"$sort_order\",is_active=\"$is_active\",is_require=\"$is_require\",is_delete=\"$is_delete\",is_edit=\"$is_edit\",is_search=\"$is_search\",show_on_listing=\"$show_on_listing\",show_on_page=\"$show_on_page\",show_on_detail=\"$show_on_detail\", option_values=\"$option_values\",extra_parameter = '".$extra_parameter."',style_class = '".$style_class."',validation_type = '".$validation_type."',field_require_desc = '".addslashes($field_require_desc)."' where cid=\"$field_id\"";
		$wpdb->query($sql);
		$msgtype = 'edit';
	}else
	{
		$sql = "insert into $custom_post_meta_db_table_name (admin_title,field_category,post_type,site_title,ctype,htmlvar_name,admin_desc,clabels,default_value,sort_order,is_active,is_delete,is_edit,is_require,is_search,show_on_listing,show_on_detail,show_on_page,option_values,field_require_desc,style_class,extra_parameter,validation_type) values ('".$admin_title."','".$field_cat."','".$my_post_type."','".$site_title."','".$ctype."','".$htmlvar_name."','".$admin_desc."','".$clabels."','".$default_value."','".$sort_order."','".$is_active."','".$is_delete."','".$is_edit."','".$is_require."','".$is_search."','".$show_on_listing."','".$show_on_detail."','".$show_on_page."','".$option_values."','".addslashes($field_require_desc)."','".$style_class."','".$extra_parameter."','".$validation_type."')";

		$wpdb->query($sql);
		$field_id = $wpdb->get_var("select max(cid) from $custom_post_meta_db_table_name");
		$msgtype = 'add';
		
	}
	
	$location = site_url().'/wp-admin/admin.php';
	echo '<form action="'.$location.'#option_display_custom_fields" method="get" id="frm_edit_custom_fields" name="frm_edit_custom_fields">
				<input type="hidden" value="manage_settings" name="page"><input type="hidden" value="success" name="custom_field_msg"><input type="hidden" value="'.$msgtype.'" name="custom_msg_type">
		  </form>
		  <script>document.frm_edit_custom_fields.submit();</script>';
		  exit;
}
?>
<!-- Function to fetch categories -->
<form action="<?php echo site_url();?>/wp-admin/admin.php?page=manage_settings&mod=custom_fields&act=addedit#option_display_custom_fields" method="post" name="custom_fields_frm" onsubmit="return chk_field_form();">
<input type="submit" name="submit" value="<?php _e('Save all changes','templatic');?>" class="button-framework-imp right position_top" />
<h4><?php if($_REQUEST['field_id']){  _e('Edit - '.$post_val->admin_title,'templatic');
	$custom_msg = 'Here you can edit custom field detail.'; }else { _e('Add a new field','templatic'); $custom_msg = 'Here you can add a new custom field. Specify all details to ensure the custom field works as it should.';}?> 
    
    <a href="<?php echo site_url();?>/wp-admin/admin.php?page=manage_settings#option_display_custom_fields" name="btnviewlisting" class="l_back" title="<?php _e('Back to manage custom field list','templatic');?>"/><?php _e('&laquo; Back to manage custom field list','templatic'); ?></a>
    </h4>
    
    <p class="notes_spec"><?php _e($custom_msg,'templatic');?></p>
    
<input type="hidden" name="save" value="1" /> <input type="hidden" name="is_delete" value="<?php echo $post_val->is_delete;?>" />
<?php if($_REQUEST['field_id']){?>
<input type="hidden" name="field_id" value="<?php echo $_REQUEST['field_id'];?>" />
<?php }?>
<div class="option option-select" <?php if($post_val->is_edit == '0'){?> style="display:none;" <?php }else{?> style="display:block;" <?php }?>>
    <h3><?php _e('Show for post-type: ','templatic');?></h3>
    <div class="section">
      <div class="element">
	  <?php
			$custom_post_types_args = array();  
			$custom_post_types = get_post_types($custom_post_types_args,'objects');   
	  ?>
                 <select name="post_type" id="post_type">
				  <?php
					foreach ($custom_post_types as $content_type) {
                    if($content_type->name!='nav_menu_item' && $content_type->name!='attachment' && $content_type->name!='revision' && $content_type->name!='page' && $content_type->name!='post'){
                  ?>
                  	<option value="<?php echo $content_type->name.",".$content_type->taxonomies[0].",".$post_val->field_category; ?>" <?php if($post_val->post_type==$content_type->name){ echo 'selected=selected';}?>><?php echo $content_type->label;?></option>
                 <?php }}?>
				<option value="both"<?php if($post_val->post_type=='both') { echo 'selected="selected"'; }else{ if(!$post_val->post_type){ echo 'selected=selected'; } } ?>><?php _e('Both','templatic'); ?></option>
                  </select>
      	   </div>
      <div class="description"><?php _e('Select the post-type for which this field will be displayed.','templatic');?></div>
    </div>
  </div> <!-- #end -->

  <div class="option option-select" <?php if($post_val->is_edit == '0'){?> style="display:none;" <?php }else{?> style="display:block;" <?php }?>>
    <h3><?php _e('Field type: ','templatic');?></h3>
    <div class="section">
      <div class="element">
                   <select name="ctype" id="ctype" onchange="show_option_add(this.value)" <?php if($post_val->ctype=='geo_map'){ ?>style="pointer:none;" readonly=readonly<?php } ?>>
                      <option value="text" <?php if($post_val->ctype=='text'){ echo 'selected="selected"';}?>><?php _e('Text','templatic');?></option>
                      <option value="date" <?php if($post_val->ctype=='date'){ echo 'selected="selected"';}?>><?php _e('Date Picker','templatic');?></option>
                      <option value="multicheckbox" <?php if($post_val->ctype=='multicheckbox'){ echo 'selected="selected"';}?>><?php _e('Multi Checkbox','templatic');?></option>
                      <option value="radio" <?php if($post_val->ctype=='radio'){ echo 'selected="selected"';}?>><?php _e('Radio','templatic');?></option>
                      <option value="select" <?php if($post_val->ctype=='select'){ echo 'selected="selected"';}?>><?php _e('Select','templatic');?></option>
                      <option value="texteditor" <?php if($post_val->ctype=='texteditor'){ echo 'selected="selected"';}?>><?php _e('Text Editor','templatic');?></option>
                      <option value="textarea" <?php if($post_val->ctype=='textarea'){ echo 'selected="selected"';}?>><?php _e('Textarea','templatic');?></option>
                      <?php if($post_val->ctype=='image_uploader') { ?>
	                      <option value="image_uploader" <?php if($post_val->ctype=='image_uploader'){ echo 'selected="selected"';}?>><?php _e('Multy image uploader','templatic');?></option>
                      <?php } ?>
                     <?php if($post_val->ctype=='geo_map') { ?>
                       <option value="geo_map" <?php if($post_val->ctype=='geo_map'){ echo 'selected="selected"';}?>><?php _e('Geo Map','templatic');?></option>
                    <?php } ?> 
                  </select>
      	   </div>
      <div class="description"><?php _e('Select the type of this custom field.','templatic');?></div>
    </div>
  </div> <!-- #end -->


	<div class="option option-select" id="ctype_option_tr_id"  <?php if($post_val->ctype=='select' && $post_val->is_edit == '0'){?> style="display:block;" <?php }else{?> style="display:none;" <?php }?> >
    <h3><?php _e('Option values: ','templatic');?></h3>
		<div class="section">
		  <div class="element"><input type="text" name="option_values" id="option_values" value="<?php echo $post_val->option_values;?>" size="50"  /></div>
		  <div class="description"><?php _e('Seperate multiple option values with a comma. eg. Yes, No','templatic');?></div>
		</div>
	</div> <!-- #end -->
  
  
  <div class="option option-select" id="admin_title_id"  >
    <h3><?php _e('Title : ','templatic');?></h3>
    <div class="section">
      <div class="element"><input type="text" name="admin_title" id="admin_title" value="<?php echo $post_val->admin_title;?>" size="50" /></div>
      <div class="description"><?php _e('Custom field title which will appear in manage cutom fields area. ','templatic');?></div>
    </div>
  </div> <!-- #end -->
  
  
  <div class="option option-select" >
    <h3><?php _e('Field name (Front-end): ','templatic');?></h3>
    <div class="section">
      <div class="element">
                   <input type="text" name="site_title" id="site_title" value="<?php echo $post_val->site_title;?>" size="50" />
      	   </div>
      <div class="description"><?php _e('The name you provide here will be displayed as the field&rsquo;s name (label) in the front-end.','templatic');?></div>
    </div>
  </div> <!-- #end -->
  

  <div class="option option-select" >
    <h3><?php _e('Field label (for back-end): ','templatic');?></h3>
    <div class="section">
      <div class="element">
                   <input type="text" name="clabels" id="clabels" value="<?php echo $post_val->clabels;?>" size="50" />
      	   </div>
      <div class="description"><?php _e('The field label for the custom field displayed in the back-end.','templatic');?></div>
    </div>
  </div> <!-- #end -->
  
  
  <div class="option option-select" <?php if($post_val->is_edit == '0'){?> style="display:none;" <?php }else{?> style="display:block;" <?php }?> >
    <h3><?php _e('HTML variable name: ','templatic');?></h3>
    <div class="section">
      <div class="element">
                   <input type="text" name="htmlvar_name" id="htmlvar_name" value="<?php echo $post_val->htmlvar_name;?>" size="50"  <?php if($_REQUEST['field_id'] !="") { ?>readonly=readonly style="pointer-events: none;"<?php } ?>/>
      	   </div>
      <div class="description"><?php _e('The HTML variable name for the custom field. IMPORTANT: It should be a unique name and it will be not editable after once you entered.','templatic');?></div>
    </div>
  </div> <!-- #end -->
  
  
  <div class="option option-select" >
    <h3><?php _e('Description: ','templatic');?></h3>
    <div class="section">
      <div class="element">
                   <input type="text" name="admin_desc" id="admin_desc" value="<?php echo $post_val->admin_desc;?>" size="50" />
      	   </div>
      <div class="description"><?php _e('Describe this field in a few words. It will appear in beside the field.','templatic');?></div>
    </div>
  </div> <!-- #end -->
  
  
  <div class="option option-select"  <?php if($post_val->is_edit == '0'){?> style="display:none;" <?php }else{?> style="display:block;" <?php }?>>
    <h3><?php _e('Default value: ','templatic').$post_val->is_edit;?> </h3>
    <div class="section">
      <div class="element">
                   <input type="text" name="default_value" id="default_value" value="<?php echo $post_val->default_value;?>" size="50" />
      	   </div>
      <div class="description"><?php _e('Enter the default value of the custom field.','templatic');?></div>
    </div>
  </div> <!-- #end -->
  
  
  <div class="option option-select" <?php if($post_val->is_edit == '0'){?> style="display:none;" <?php }else{?> style="display:block;" <?php }?>>
    <h3><?php _e('Position (Display order): ','templatic');?></h3>
    <div class="section">
      <div class="element">
                   <input type="text" name="sort_order" id="sort_order"  value="<?php echo $post_val->sort_order;?>" size="50" />
      	   </div>
      <div class="description"><?php _e('This is a numeric value that determines the position of the custom field in the front-end and the back-end. e.g. 5','templatic');?></div>
    </div>
  </div> <!-- #end -->
  
  <div class="option option-select" >
    <h3><?php _e('Active?: ','templatic');?></h3>
    <div class="section">
      <div class="element">
                   <select name="is_active" id="is_active">
                  <option value="1" <?php if($post_val->is_active=='1'){ echo 'selected="selected"';}?>><?php _e('Yes','templatic');?></option>
                  <option value="0" <?php if($post_val->is_active=='0'){ echo 'selected="selected"';}?>><?php _e('No','templatic');?></option>
                  </select>
      	   </div>
      <div class="description"><?php _e('This setting activates/de-activates the custom field in the front-end and the back-end.','templatic');?></div>
    </div>
  </div> <!-- #end -->
  
  
   <div class="option option-select" <?php if($post_val->is_edit == '0'){?> style="display:none;" <?php }else{?> style="display:block;" <?php }?>>
    <h3><?php _e('Compulsory?: ','templatic');?></h3>
    <div class="section">
      <div class="element">
                    <select name="is_require" id="is_require" >
                  <option value="1" <?php if($post_val->is_require=='1'){ echo 'selected="selected"';}?>><?php _e('Yes','templatic');?></option>
                  <option value="0" <?php if($post_val->is_require=='0'){ echo 'selected="selected"';}?>><?php _e('No','templatic');?></option>
                  </select>
      	   </div>
      <div class="description"><?php _e('Specify whether or not this field is required to be filled in compulsarily by users.','templatic');?></div>
    </div>
  </div> <!-- #end -->
  
  <div class="option option-select" <?php if($post_val->is_edit == '0'){?> style="display:none;" <?php }else{?><?php }?> >
    <h3><?php _e('Display location: ','templatic');?></h3>
    <div class="section">
      <div class="element">
                    <select name="show_on_page" id="show_on_page" >
					  <option value="admin_side" <?php if($post_val->show_on_page=='admin_side'){ echo 'selected="selected"';}?>><?php _e('Admin side (Backend side) ','templatic');?></option>
					  <option value="user_side" <?php if($post_val->show_on_page=='user_side'){ echo 'selected="selected"';}?>><?php _e('User side (Frontend side)','templatic');?></option> 
					  <option value="both_side" <?php if($post_val->show_on_page=='both_side'){ echo 'selected="selected"';}?>><?php _e('Both','templatic');?></option>
                  </select>
      	   </div>
      <div class="description"><?php _e('Specify whether this field will display in the front-end, back-end or both.','templatic');?></div>
    </div>
  </div> <!-- #end -->
 
   <div class="option option-select" <?php if($post_val->is_edit == '0' && is_super_admin($current_user->ID) != '1'){?> style="display:none;" <?php }else{?> style="display:block;" <?php }?>>
    <h3><?php _e('Is editable?: ','templatic');?></h3>
    <div class="section">
      <div class="element">
                   <select name="is_edit" id="is_edit">
                  <option value="1" <?php if($post_val->is_edit=='1'){ echo 'selected="selected"';}?>><?php _e('Yes','templatic');?></option>
                  <option value="0" <?php if($post_val->is_edit=='0'){ echo 'selected="selected"';}?>><?php _e('No','templatic');?></option>
                  </select>
      	   </div>
      <div class="description"><?php _e('Specify whether or not this field is editable.','templatic');?></div>
    </div>
  </div> <!-- #end -->
 
 <div class="option option-select" <?php if($post_val->is_edit == '0' && is_super_admin($current_user->ID) != '1'){?> style="display:none;" <?php }else{?> style="display:block;" <?php }?>>
    <h3><?php _e('Is deletable? : ','templatic');?></h3>
    <div class="section">
      <div class="element">
                   <select name="is_delete" id="is_edit">
                  <option value="1" <?php if($post_val->is_delete=='1'){ echo 'selected="selected"';}?>><?php _e('Yes','templatic');?></option>
                  <option value="0" <?php if($post_val->is_delete=='0'){ echo 'selected="selected"';}?>><?php _e('No','templatic');?></option>
                  </select>
      	   </div>
      <div class="description"><?php _e('Specify whether or not this field is deletable.','templatic');?></div>
    </div>
  </div> <!-- #end -->
   <div class="option option-select" <?php if($post_val->is_edit == '0' && is_super_admin($current_user->ID) != '1'){?> style="display:none;" <?php }else{?> style="display:block;" <?php }?>>
    <h3><?php _e('Show in search form?: ','templatic');?></h3>
    <div class="section">
      <div class="element">
                   <select name="is_search" id="is_search">
                  <option value="1" <?php if($post_val->is_search=='1'){ echo 'selected="selected"';}?>><?php _e('Yes','templatic');?></option>
                  <option value="0" <?php if($post_val->is_search=='0'){ echo 'selected="selected"';}?>><?php _e('No','templatic');?></option>
                  </select>
      	   </div>
      <div class="description"><?php _e('Specify whether or not this field is in place in advanced search.','templatic');?></div>
    </div>
  </div> <!-- #end -->	
 <div class="option option-select" <?php if($post_val->is_edit == '0'){?> style="display:none;" <?php }else{?> style="display:block;" <?php }?> >
    <h3><?php _e('Show on detail page?: ','templatic');?></h3>
    <div class="section">
      <div class="element">
                    <select name="show_on_detail" id="show_on_detail">
                  <option value="1" <?php if($post_val->show_on_detail=='1'){ echo 'selected="selected"';}?>><?php _e('Yes','templatic');?></option>
                  <option value="0" <?php if($post_val->show_on_detail=='0'){ echo 'selected="selected"';}?>><?php _e('No','templatic');?></option>
                  </select>
      	   </div>
      <div class="description"><?php _e('Specify whether or not this field be shown on the &lsquo;Detail page&rsquo;','templatic');?></div>
    </div>
  </div>
  
 <div class="option option-select" <?php if($post_val->is_edit == '0'){?> style="display:none;" <?php }else{?> style="display:block;" <?php }?>>
    <h3><?php _e('Required field warning message: ','templatic');?></h3>
    <div class="section">
      <div class="element">
			<textarea name="field_require_desc" id="field_require_desc"><?php echo $post_val->field_require_desc;?></textarea></div>
      <div class="description"><?php _e('This message is displayed if this field is mandatory and the user leaves it un-filled.','templatic');?></div>
    </div>
  </div>
	<div class="option option-select" <?php if($post_val->is_edit == '0'){?> style="display:none;" <?php }else{?> style="display:block;" <?php }?>>
    <h3><?php _e('Validation type: ','templatic');?></h3>
    <div class="section">
      <div class="element">
			<select name="validation_type" id="validation_type"><?php echo validation_type_cmb($post_val->validation_type);?></select></div>
			<div class="description"><?php _e('Validation helps avoid invalid information entered by the user. Optional.<small><br/><br/><b>Require</b> means this field cannot be left blank.<br/><b>Phone No.</b> means this field requires numeric values in phone number format.<br/><b>Digit</b> means this field requires numeric values.<br/><b>Email</b> means this field is required in a valid email format.</small>','templatic');?></div>
		</div>
	</div>
	
	<div class="option option-select" <?php if($post_val->is_edit == '0'){?> style="display:none;" <?php }else{?> style="display:block;" <?php }?>>
    <h3><?php _e('CSS class : ','templatic');?></h3>
    <div class="section">
      <div class="element"><input type="text" name="style_class" id="style_class" value="<?php echo $post_val->style_class; ?>"></div>
			<div class="description"><?php _e('You might want to style this field differently. Mention a class name here and add its properties in your CSS files.','templatic');?></div>
		</div>
	</div>
	<div class="option option-select" <?php if($post_val->is_edit == '0'){?> style="display:none;" <?php }else{?> style="display:block;" <?php }?>>
    <h3><?php _e('Extra parameter : ','templatic');?></h3>
    <div class="section">
      <div class="element"><input type="text" name="extra_parameter" id="extra_parameter" value="<?php echo $post_val->extra_parameter; ?>"></div>
			<div class="description"><?php _e('You can pass an extra parameter with this field (like maxlength, onchange etc.) to enhance functionality. Optional.','templatic');?></p></div>
		</div>
	</div>
  
  
  <input type="submit" name="submit" value="<?php _e('Save all changes','templatic');?>" class="button-framework-imp right position_bottom"> 


</form>

<script type="text/javascript">
function show_option_add(htmltype){
	if(htmltype=='select' || htmltype=='multiselect' || htmltype=='radio' || htmltype=='multicheckbox')	{
		document.getElementById('ctype_option_tr_id').style.display='';		
	}else{
		document.getElementById('ctype_option_tr_id').style.display='none';	
	}
	if(htmltype=='head')	{
		document.getElementById('admin_title_id').style.display='none';	
		document.getElementById('default_value_id').style.display='none';	
		document.getElementById('show_on_detail_id').style.display='none';	
		document.getElementById('is_require_id').style.display='none';	
	}else{
		document.getElementById('admin_title_id').style.display='';			
		//document.getElementById('default_value_id').style.display='';		
		//document.getElementById('show_on_detail_id').style.display='';	
		//document.getElementById('is_require_id').style.display='';	
	}
}
if(document.getElementById('ctype').value){
	show_option_add(document.getElementById('ctype').value)	;
}
</script>