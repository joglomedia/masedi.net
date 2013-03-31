<?php
define('TEMPL_MANAGE_SETTINGS_MODULE', __("Advanced settings",'templatic'));
define('TEMPL_MANAGE_SETTINGS_CURRENT_VERSION', '1.0.0');
define('TEMPL_MANAGE_SETTINGS_LOG_PATH','http://templatic.com/updates/monetize/manage_settings/manage_settings_change_log.txt');
define('TEMPL_MANAGE_SETTINGS_ZIP_FOLDER_PATH','http://templatic.com/updates/monetize/manage_settings/manage_settings.zip');
define('TT_MANAGE_SETTINGS_FOLDER','manage_settings');
define('TT_MANAGE_SETTINGS_MODULES_PATH',TT_MODULES_FOLDER_PATH . TT_MANAGE_SETTINGS_FOLDER.'/');
define ("PLUGIN_DIR_MANAGE_SETTINGS", basename(dirname(__FILE__)));
define ("PLUGIN_URL_MANAGE_SETTINGS", get_template_directory_uri().'/monetize/'.PLUGIN_DIR_MANAGE_SETTINGS.'/');
?>
<?php
function validation_type_cmb($validation_type = ''){
	$validation_type_display = '';
	$validation_type_array = array(" "=>"Select validation type","require"=>"Require","phone_no"=>"Phone No.","digit"=>"Digit","email"=>"Email");
	foreach($validation_type_array as $validationkey => $validationvalue){
		if($validation_type == $validationkey){
			$vselected = 'selected';
		} else {
			$vselected = '';
		}
		$validation_type_display .= '<option value="'.$validationkey.'" '.$vselected.'>'.__($validationvalue,'templatic').'</option>';
	}
	return $validation_type_display;
}

function position_cmb($position = ''){
	$position_array = array("1"=>"Symbol Before amount","2"=>"Space between Before amount and Symbol","3"=>"Symbol After amount","4"=>"Space between After amount and Symbol");
	$position_display = '';
	foreach($position_array as $pkey => $pvalue){
		if($pkey == $position){
			$pselect = "selected";
		} else {
			$pselect = "";
		}
		$position_display .= '<option value="'.$pkey.'" '.$pselect.'>'.__($pvalue,'templatic').'</option>';
	}
	return $position_display;
} 

function currency_cmb($currency_value = ''){
	global $wpdb;
	$currency_table = $wpdb->prefix . "currency";
	$curreny_sql = mysql_query("select * from $currency_table order by currency_name");
	$currency_display = '';
	$currency_select = "";
	while($currency_res = mysql_fetch_array($curreny_sql)){
		if($currency_res['currency_code'] == $currency_value){
			$currency_select = "selected";
		} else {
			$currency_select = "";
		}
		$currency_display .= '<option value="'.$currency_res['currency_code'].'" '.$currency_select.'>'.$currency_res['currency_name'].'</option>';
	}
	return $currency_display;
}

function legend_notification(){
	$legend_display = '<h4>Legend : </h4>';
	$legend_display .= '<p style="line-height:30px;width:100%;"><label style="float:left;width:180px;">[#to_name#]</label> : '.__('Name of the recipient.','templatic').'<br />
	<label style="float:left;width:180px;">[#site_name#]</label> : '.__('Site name as you provided in General Settings','templatic').'<br />
	<label style="float:left;width:180px;">[#site_login_url#]</label> : '.__('Site\'s login page URL','templatic').'<br />
	<label style="float:left;width:180px;">[#user_login#]</label> : '.__('Recipient\'s login ID','templatic').'<br />
	<label style="float:left;width:180px;">[#user_password#]</label> : '.__('Recepient\'s password','templatic').'<br />
	<label style="float:left;width:180px;">[#site_login_url_link#]</label> : '.__('Site login page link','templatic').'<br />
	<label style="float:left;width:180px;">[#post_date#]</label> : '.__('Date of post','templatic').'<br />
	<label style="float:left;width:180px;">[#information_details#]</label> : '.__('Information details of place/event.','templatic').'<br />
	<label style="float:left;width:180px;">[#transaction_details#]</label> : '.__('Transaction details of place/event.','templatic').'<br />
	<label style="float:left;width:180px;">[#frnd_subject#]</label> : '.__('Subject for the email to the recipient.','templatic').'<br />
	<label style="float:left;width:180px;">[#frnd_comments#]</label> : '.__('Comment for the email to the recipient.','templatic').'<br />
	<label style="float:left;width:180px;">[#your_name#]</label> : '.__('Sender\'s name','templatic').'<br />
	<label style="float:left;width:180px;">[#submited_information_link#]</label> : '.__('URL of the detail page','templatic').'<br />
	<label style="float:left;width:180px;">[#payable_amt#]</label> : '.__('Payable amount','templatic').'<br />
	<label style="float:left;width:180px;">[#bank_name#]</label> : '.__('Bank name','templatic').'<br />
	<label style="float:left;width:180px;">[#account_number#]</label> : '.__('Account number','templatic').'<br />
	<label style="float:left;width:180px;">[#submition_Id#]</label> : '.__('Submission ID','templatic').'</p>';
	return $legend_display;
}


function get_post_custom_fields_templ($post_types,$category_id='',$show_on_page = '',$is_search = '') {
	global $wpdb,$custom_post_meta_db_table_name;
	$post_query = "select * from $custom_post_meta_db_table_name where is_active=1";
	if(!strstr($post_types,',')){
		if($is_search != ''){
			$post_query .= " and (post_type = '".$post_types."' or post_type='both')";
		} else {
			$post_query .= " and (post_type = '".$post_types."' or post_type='both')";
		}
	
	}else{	
		if($is_search != ''){
			$post_query .= " and (post_type IN ($post_types) or post_type='both')";
		} else {
			$post_query .= " and (post_type IN ($post_types) or post_type='both')";
		}
	}
	if($show_on_page != '') {
		$post_query .= " and (show_on_page = '$show_on_page' or show_on_page = 'both_side')";
	} else {
		$post_query .= " and (show_on_page = 'admin_side' or show_on_page = 'both_side')";
	}if($is_search != ''){
		$post_query .= " and is_search = '1'";
	}
	//echo $post_query;
	if($category_id != '0' && $category_id != ''  ){
		$post_query .= " and (field_category LIKE '%,".$category_id.",%' or field_category LIKE '%,".$category_id."' or field_category LIKE '%".$category_id.",%' or field_category LIKE '%".$category_id."%' or field_category = '0')";
	} 
	$post_query .=  " order by sort_order asc,cid asc";
	$post_meta_info = $wpdb->get_results($post_query);
	$return_arr = array();
	if($post_meta_info){
		
		foreach($post_meta_info as $post_meta_info_obj){	
			if($post_meta_info_obj->ctype){
				$options = explode(',',$post_meta_info_obj->option_values);
			}
			$custom_fields = array(
					"name"		=> $post_meta_info_obj->htmlvar_name,
					"label" 	=> $post_meta_info_obj->clabels,
					"field_category" 	=> $post_meta_info_obj->field_category,
					"htmlvar_name" 	=> $post_meta_info_obj->htmlvar_name,
					"default" 	=> $post_meta_info_obj->default_value,
					"type" 		=> $post_meta_info_obj->ctype,
					"desc"      => $post_meta_info_obj->admin_desc,
					"option_values" => $post_meta_info_obj->option_values,
					"site_title"  => $post_meta_info_obj->site_title,
					"is_require"  => $post_meta_info_obj->is_require,
					"is_active"  => $post_meta_info_obj->is_active,
					"show_on_listing"  => $post_meta_info_obj->show_on_listing,
					"show_on_detail"  => $post_meta_info_obj->show_on_detail,
					"validation_type"  => $post_meta_info_obj->validation_type,
					"style_class"  => $post_meta_info_obj->style_class,
					"extra_parameter"  => $post_meta_info_obj->extra_parameter,
					);
			if($options)
			{
				$custom_fields["options"]=$options;
			}
			$return_arr[$post_meta_info_obj->htmlvar_name] = $custom_fields;
		}
	}
	return $return_arr;
}

include_once(TT_MODULES_FOLDER_PATH.'manage_settings/manage_post_custom_fields.php');
?>