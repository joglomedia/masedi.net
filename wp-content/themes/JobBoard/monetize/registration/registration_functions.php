<?php
define('TT_CUSTOM_USERMETA_FOLDER_PATH',TT_MODULES_FOLDER_PATH.'registration/custom_usermeta/');
define('TT_REGISTRATION_FOLDER_PATH',TT_MODULES_FOLDER_PATH.'registration/');
//include_once(TT_MODULES_FOLDER_PATH.'db_table_creation.php');
//include_once(TT_REGISTRATION_FOLDER_PATH.'registration_main.php');

$form_fields_usermeta_usermeta = array();

$form_fields_usermeta['user_email'] = array(
	"label"		=> USERNAME_EMAIL_TEXT,
	"type"		=>	'text',
	"default"	=>	'',
	"extra"		=>	'id="user_email" size="25" class="textfield"',
	"is_require"	=>	'1',
	"outer_st"	=>	'<div class="form_row clearfix">',
	"outer_end"	=>	'</div>',
	"tag_st"	=>	'',
	"tag_end"	=>	'',
	"on_registration"	=>	'1',
	"on_profile"	=>	'1',
	);

$form_fields_usermeta['user_fname'] = array(
	"label"		=> USERNAME_TEXT,
	"type"		=>	'text',
	"default"	=>	'',
	"extra"		=>	'id="user_fname" size="25" class="textfield"',
	"is_require"	=>	'1',
	"outer_st"	=>	'<div class="form_row clearfix">',
	"outer_end"	=>	'</div>',
	"tag_st"	=>	'',
	"tag_end"	=>	'',
	"on_registration"	=>	'1',
	"on_profile"	=>	'1',
	);


$custom_metaboxes = templ_get_usermeta();

foreach($custom_metaboxes as $key=>$val)
{
	$name = $val['name'];
	$site_title = $val['site_title'];
	$type = $val['type'];
	$default_value = $val['default'];
	$is_require = $val['is_require'];
	$admin_desc = $val['desc'];
	$option_values = $val['option_values'];
	$on_registration = $val['on_registration'];
	$on_profile = $val['on_profile'];
	if($type=='text'){
		$form_fields_usermeta[$name] = array(
		"label"		=> $site_title,
		"type"		=>	'text',
		"default"	=>	$default_value,
		"extra"		=>	'id="'.$name.'" size="25" class="textfield"',
		"is_require"	=>	$is_require,
		"outer_st"	=>	'<div class="form_row clearfix">',
		"outer_end"	=>	'</div>',
		"tag_st"	=>	'',
		"tag_end"	=>	'<span class="message_note">'.$admin_desc.'</span>',
		"on_registration"	=>	$on_registration,
		"on_profile"	=>	$on_profile,
		);
	}elseif($type=='checkbox'){
		$form_fields_usermeta[$name] = array(
		"label"		=> $site_title,
		"type"		=>	'checkbox',
		"default"	=>	$default_value,
		"extra"		=>	'id="'.$name.'" size="25" class="checkbox"',
		"is_require"	=>	$is_require,
		"outer_st"	=>	'<div class="form_row clearfix checkbox_field">',
		"outer_end"	=>	'',
		"tag_st"	=>	'',
		"tag_end"	=>	'<span class="message_note">'.$admin_desc.'</span></div>',
		"on_registration"	=>	$on_registration,
		"on_profile"	=>	$on_profile,
		);
	}elseif($type=='textarea'){
		$form_fields_usermeta[$name] = array(
		"label"		=> $site_title,
		"type"		=>	'textarea',
		"default"	=>	$default_value,
		"extra"		=>	'id="'.$name.'" size="25" class="textarea"',
		"is_require"	=>	$is_require,
		"outer_st"	=>	'<div class="form_row clearfix">',
		"outer_end"	=>	'</div>',
		"tag_st"	=>	'',
		"tag_end"	=>	'<span class="message_note">'.$admin_desc.'</span>',
		"on_registration"	=>	$on_registration,
		"on_profile"	=>	$on_profile,
		);
		
	}elseif($type=='texteditor'){
		$form_fields_usermeta[$name] = array(
		"label"		=> $site_title,
		"type"		=>	'texteditor',
		"default"	=>	$default_value,
		"extra"		=>	'id="'.$name.'" size="25" class="textarea mceEditor"',
		"is_require"	=>	$is_require,
		"outer_st"	=>	'<div class="form_row clearfix">',
		"outer_end"	=>	'</div>',
		"tag_before"=>	'<div class="form_row clearfix">',
		"tag_after"=>	'</div>',
		"tag_st"	=>	'',
		"tag_end"	=>	'<span class="message_note">'.$admin_desc.'</span>',
		"on_registration"	=>	$on_registration,
		"on_profile"	=>	$on_profile,
		);
	}elseif($type=='select'){
		//$option_values=explode(",",$option_values );
		$form_fields_usermeta[$name] = array(
		"label"		=> $site_title,
		"type"		=>	'select',
		"default"	=>	$default_value,
		"extra"		=>	'id="'.$name.'" class="select xl"',
		"options"	=> 	$option_values,
		"is_require"	=>	$is_require,
		"outer_st"	=>	'<div class="form_row clearfix">',
		"outer_end"	=>	'</div>',
		"tag_st"	=>	'',
		"tag_end"	=>	'',
		"on_registration"	=>	$on_registration,
		"on_profile"	=>	$on_profile,
		);
	}elseif($type=='radio'){
		//$option_values=explode(",",$option_values );
		$form_fields_usermeta[$name] = array(
			"label"		=> $site_title,
			"type"		=>	'radio',
			"default"	=>	$default_value,
			"extra"		=>	'',
			"options"	=> 	$option_values,
			"is_require"	=>	$is_require,
			"outer_st"	=>	'<div class="form_row clearfix">',
			"outer_end"	=>	'</div>',
			"tag_before"=>	'<div class="form_cat">',
			"tag_after"=>	'</div>',
			"tag_st"	=>	'',
			"tag_end"	=>	'<span class="message_note">'.$admin_desc.'</span>',
			"on_registration"	=>	$on_registration,
			"on_profile"	=>	$on_profile,
			);
	}elseif($type=='multicheckbox'){
		//$option_values=explode(",",$option_values );
		$form_fields_usermeta[$name] = array(
			"label"		=> $site_title,
			"type"		=>	'multicheckbox',
			"default"	=>	$default_value,
			"extra"		=>	'',
			"options"	=> 	$option_values,
			"is_require"	=>	$is_require,
			"outer_st"	=>	'<div class="form_row clearfix">',
			"outer_end"	=>	'</div>',
			"tag_before"=>	'<div class="form_cat">',
			"tag_after"=>	'</div>',
			"tag_st"	=>	'',
			"tag_end"	=>	'<span class="message_note">'.$admin_desc.'</span>',
			"on_registration"	=>	$on_registration,
			"on_profile"	=>	$on_profile,
			);
	
	}elseif($type=='date'){
		$form_fields_usermeta[$name] = array(
		"label"		=> $site_title,
		"type"		=>	'date',
		"default"	=>	$default_value,
		"extra"		=>	'id="'.$name.'" size="25" class="textfield_date"',
		"is_require"	=>	$is_require,
		"outer_st"	=>	'<div class="form_row clearfix">',
		"outer_end"	=>	'</div>',
		//"tag_st"	=>	'<img src="'.get_template_directory_uri().'/images/cal.gif" alt="Calendar"  onclick="displayCalendar(document.userform.'.$name.',\'yyyy-mm-dd\',this)" style="cursor: pointer;" align="absmiddle" border="0" class="calendar_img" />',
		"tag_end"	=>	'<span class="message_note">'.$admin_desc.'</span>',
		"on_registration"	=>	$on_registration,
		"on_profile"	=>	$on_profile,
		);
		
	}elseif($type=='upload'){
	$form_fields_usermeta[$name] = array(
		"label"		=> $site_title,
		"type"		=>	'upload',
		"default"	=>	$default_value,
		"extra"		=>	'id="'.$name.'" class="textfield"',
		"is_require"	=>	$is_require,
		"outer_st"	=>	'<div class="form_row clearfix upload_img">',
		"outer_end"	=>	'</div>',
		"tag_st"	=>	'',
		"tag_end"	=>	'<span class="message_note">'.$admin_desc.'</span>',
		"on_registration"	=>	$on_registration,
		"on_profile"	=>	$on_profile,
		);
	}elseif($type=='head'){
	$form_fields_usermeta[$name] = array(
		"label"		=> $site_title,
		"type"		=>	'head',
		"outer_st"	=>	'<h5 class="form_title">',
		"outer_end"	=>	'</h5>',
		);
	}elseif($type=='geo_map'){
	$form_fields_usermeta[$name] = array(
		"label"		=> '',
		"type"		=>	'geo_map',
		"default"	=>	$default_value,
		"extra"		=>	'',
		"is_require"	=>	$is_require,
		"outer_st"	=>	'',
		"outer_end"	=>	'',
		"tag_st"	=>	'',
		"tag_end"	=>	'',
		"on_registration"	=>	$on_registration,
		"on_profile"	=>	$on_profile,
		);		
	}elseif($type=='image_uploader'){
	$form_fields_usermeta[$name] = array(
		"label"		=> '',
		"type"		=>	'image_uploader',
		"default"	=>	$default_value,
		"extra"		=>	'',
		"is_require"	=>	$is_require,
		"outer_st"	=>	'',
		"outer_end"	=>	'',
		"tag_st"	=>	'',
		"tag_end"	=>	'',
		"on_registration"	=>	$on_registration,
		"on_profile"	=>	$on_profile,
		);		
	}
}

add_action('templ_page_title_below','get_usermeta_author_page');
function get_usermeta_author_page()
{
	$custom_usermeta_db_table_name = $table_prefix . "templatic_custom_usermeta";
	global $wpdb,$custom_usermeta_db_table_name;
	$return_str = '';
	$paten_str = '<div class="{#CSS#}"> {#TITLE#} - {#VALUE#}</div>';
	global $current_user;
	if(isset($_GET['author_name'])) :
		$curauth = get_userdatabylogin($author_name);
	else :
		$curauth = get_userdata(intval($_GET['author']));
	endif;
	$uid = $curauth->ID;
	if($curauth->user_description){
		$return_str = '<p>'.$curauth->user_description.'</p>';
	}
	$sql = "select * from $custom_usermeta_db_table_name where is_active=1 and show_on_detail=1 ";
	if($fields_name)
	{
		$fields_name = '"'.str_replace(',','","',$fields_name).'"';
		$sql .= " and htmlvar_name in ($fields_name) ";
	}
	$sql .=  " order by sort_order asc";
	
	$post_meta_info = $wpdb->get_results($sql);

	$search_arr = array('{#TITLE#}','{#VALUE#}','{#CSS#}');
	$replace_arr = array();
	if($post_meta_info){
		foreach($post_meta_info as $post_meta_info_obj){
			if($post_meta_info_obj->site_title)
			{
				$replace_arr[] = $post_meta_info_obj->site_title;	
			}
			$htmlvar = $post_meta_info_obj->htmlvar_name;
			if($htmlvar)
			{
				$replace_arr = array($post_meta_info_obj->site_title,$curauth->$htmlvar,$post_meta_info_obj->htmlvar_name);
				if($curauth->$htmlvar)
				{
					$return_str .= str_replace($search_arr,$replace_arr,$paten_str);
				}
			}
		}	
	}
	
	echo $return_str;
}
?>