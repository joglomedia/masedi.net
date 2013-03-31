<?php
session_start();
ob_start();
if(!$current_user->ID)
{
	wp_redirect(get_settings('home').'/index.php?page=login');
	exit;
}
global $wpdb;

if($_POST)
{
	if($_REQUEST['chagepw'])
	{
		$new_passwd = $_POST['new_passwd'];
		if($new_passwd)
		{
			$user_id = $current_user->ID;
			wp_set_password($new_passwd, $user_id);
			$message1 = PW_CHANGE_SUCCESS_MSG;
		}		
	}else
	{
		$user_id = $current_user->ID;
		//code to upload file
		if($user_web && !strstr($user_web,'http://'))
		{
			$user_web = 'http://'.$user_web;
		}
		if($user_twitter && !strstr($user_twitter,'http://'))
		{
			$user_twitter = 'http://'.$user_twitter;
		}
		$last_name = $_POST['user_lname'];
		$user_fname = $_POST['user_fname'];
		$description = $_POST['description'];
		$user_address_info = array(
							"last_name"		=> $last_name,
							"first_name"		=> $user_fname,
							"user_phone" 	=>	$_POST['user_phone'],
							"description"  => addslashes($description),
							);
	
		foreach($user_address_info as $key=>$val)
		{
			update_usermeta($user_id, $key, $val); // User Address Information Here
		}
		$userName = $_POST['user_fname'].' '.$_POST['user_lname'];

		$user_email = $_REQUEST['user_email'];
		$updateUsersql = "update $wpdb->users set user_url=\"$user_web\", display_name=\"$userName\" , user_email =\"$user_email\" where ID=\"$user_id\"";
		$wpdb->query($updateUsersql);
				global $upload_folder_path;
		global $form_fields_usermeta;
		$custom_metaboxes = templ_get_usermeta();

		foreach($form_fields_usermeta as $fkey=>$fval)
		{
			$fldkey = "$fkey";
			$$fldkey = $_POST["$fkey"];
			if($fval['type']=='upload')
			{	
				if($_FILES[$fkey]['name'] && $_FILES[$fkey]['size']>0) {
					$dirinfo = wp_upload_dir();
					$path = $dirinfo['path'];
					$url = $dirinfo['url'];
					$destination_path = $path."/";
					$destination_url = $url."/";
					
					$src = $_FILES[$fkey]['tmp_name'];
					$file_ame = date('Ymdhis')."_".$_FILES[$fkey]['name'];
					$target_file = $destination_path.$file_ame;
					if(move_uploaded_file($_FILES[$fkey]["tmp_name"],$target_file))
					{
						$image_path = $destination_url.$file_ame;
					}else
					{
						$image_path = '';	
					}					
					$_POST[$fkey] = $image_path;
					$fldkey = $image_path;	
					update_usermeta($user_id, $fkey, $fldkey);		
				}
				else{
					$_POST[$fkey]=$_POST['prev_upload'];
				}
			}
			else
				update_usermeta($user_id, $fkey, $$fldkey); // User Custom Metadata Here
		}

		$_SESSION['session_message'] = INFO_UPDATED_SUCCESS_MSG;
		wp_redirect(get_option( 'siteurl' ).'/?page=profile');
		exit;
	}
}

$user_address_info = $current_user;
$user_phone = $user_address_info->user_phone;
$display_name = $current_user->display_name;
$user_web = $current_user->user_url;
$display_name_arr = explode(' ',$display_name);
$user_fname = $display_name_arr[0];
unset($display_name_arr[0]);
if($display_name_arr)
{
	$user_lname = implode(' ',$display_name_arr);
}
?>
<?php
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
		"tag_end"	=>	'<span class="message_note msgcat">'.$admin_desc.'</span>',
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
		"tag_end"	=>	'<span class="message_note msgcat">'.$admin_desc.'</span></div>',
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
		"tag_end"	=>	'<span class="message_note msgcat">'.$admin_desc.'</span>',
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
		"tag_before"=>	'<div class="clearfix">',
		"tag_after"=>	'</div>',
		"tag_st"	=>	'',
		"tag_end"	=>	'<span class="message_note msgcat">'.$admin_desc.'</span>',
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
			"tag_end"	=>	'<span class="message_note msgcat">'.$admin_desc.'</span>',
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
			"tag_end"	=>	'<span class="message_note msgcat">'.$admin_desc.'</span>',
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
		"tag_st"	=>	'<img src="'.get_template_directory_uri().'/images/cal.gif" alt="Calendar"  onclick="displayCalendar(document.submissiion_form.'.$name.',\'yyyy-mm-dd\',this)" style="cursor: pointer;" align="absmiddle" border="0" class="calendar_img" />',
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
		"tag_end"	=>	'<span class="message_note msgcat">'.$admin_desc.'</span>',
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
?>
<?php get_header(); ?>
<div id="page">
	  <div id="content-wrap" class="clear <?php if(get_option("ptthemes_page_layout") == "Right Sidebar") { echo "right-side"; } else { echo "left-side"; } ?>" >
    	<div id="content">
        <div class="breadcrumbs"><ul class="page-nav"><li><?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') { yoast_breadcrumb('',' &raquo; '.EDIT_PROFILE_PAGE_TITLE); } ?></li></ul></div>
        	 <div class="title-container">
				<h1 class="title_green page_head"><span><?php echo EDIT_PROFILE_PAGE_TITLE;?></h1>
                <p class="note"> <span class="required">*</span> <?php echo INDICATES_MANDATORY_FIELDS_TEXT;?> </p>
                <div class="clearfix"></div>
              </div>

<?php 
if($_SESSION['session_message'])
{
	echo '<div class="sucess_msg">'.$_SESSION['session_message'].'</div>';
	$_SESSION['session_message'] = '';
}
?>
		
       
<div class="container-02">
	<div class="graybox">       
       <form name="registerform" id="registerform" action="<?php echo get_option( 'siteurl' ).'/?page=profile'; ?>" method="post" enctype="multipart/form-data" >
     <?php
		global $form_fields_usermeta;
        $validation_info = array();
        foreach($form_fields_usermeta as $key=>$val)
        {
		if($val['on_registration'] && $key != 'login_type'){
        $str = ''; $fval = '';
        $field_val = $key.'_val';
        if($$field_val){$fval = $$field_val;}else{$fval = $val['default'];}
        
        if($val['is_require'])
        {
            $validation_info[] = array(
                                       'name'	=> $key,
                                       'espan'	=> $key.'_error',
                                       'type'	=> $val['type'],
                                       'text'	=> $val['label'],
                                       );
        }
		if($key)
		{
			$fval = get_user_meta($current_user->ID,$key,true);
		}
		if($key == 'user_email')
		{
			$fval = $current_user->$key;
		}
		if( $key == 'user_fname')
		{
			$fval = get_user_meta($current_user->ID,'first_name',true);
		}
		if( $key == 'user_lname')
		{
			$fval = get_user_meta($current_user->ID,'last_name',true);
		}
		if( $key == 'user_web')
		{
			$fval = $current_user->user_url;
		}
        if($val['type']=='text')
        {
            $str = '<input name="'.$key.'" type="text" '.$val['extra'].' value="'.$fval.'" />';
            if($val['is_require'])
            {
                $str .= '<span id="'.$key.'_error"></span>';
            }
        }elseif($val['type']=='hidden')
        {
            $str = '<input name="'.$key.'" type="hidden" '.$val['extra'].' value="'.$fval.'" />';	
            if($val['is_require'])
            {
                $str .= '<span id="'.$key.'_error"></span>';	
            }
        }else
        if($val['type']=='textarea')
        {
            $str = '<textarea name="'.$key.'" '.$val['extra'].'>'.$fval.'</textarea>';	
            if($val['is_require'])
            {
                $str .= '<span id="'.$key.'_error"></span>';	
            }
        }else
        if($val['type']=='texteditor')
        {
            $str = $val['tag_before'].'<textarea name="'.$key.'" PLACEHOLDER="'.$val["default"].'" class="mce $val["extra_parameter"]">'.$fval.'</textarea>'.$val['tag_after'];
            if($val['is_require'])
            {
                $str .= '<span id="'.$key.'_error"></span>';	
            }
        }else
        if($val['type']=='file')
        {
            $str = '<input name="'.$key.'" type="file" '.$val['extra'].' value="'.$fval.'" />';
            if($val['is_require'])
            {
                $str .= '<span id="'.$key.'_error"></span>';	
            }
        }else
        if($val['type']=='include')
        {
            $str = @include_once($val['default']);
        }else
        if($val['type']=='head')
        {
            $str = '';
        }else
        if($val['type']=='date')
        {
            $str = '<input name="'.$key.'" type="text" '.$val['extra'].' value="'.$fval.'" />';	
            if($val['is_require'])
            {
                $str .= '<span id="'.$key.'_error"></span>';	
            }
        }else
        if($val['type']=='catselect')
        {
            $term = get_term( (int)$fval, CUSTOM_CATEGORY_TYPE1);
            $str = '<select name="'.$key.'" '.$val['extra'].'>';
            $args = array('taxonomy' => CUSTOM_CATEGORY_TYPE1);
            $all_categories = get_categories($args);
            foreach($all_categories as $key => $cat) 
            {
            
                $seled='';
                if($term->name==$cat->name){ $seled='selected="selected"';}
                $str .= '<option value="'.$cat->name.'" '.$seled.'>'.$cat->name.'</option>';	
            }
            $str .= '</select>';
            if($val['is_require'])
            {
                $str .= '<span id="'.$key.'_error"></span>';	
            }
        }else
        if($val['type']=='catdropdown')
        {
            $cat_args = array('name' => 'post_category', 'id' => 'post_category_0', 'selected' => $fval, 'class' => 'textfield', 'orderby' => 'name', 'echo' => '0', 'hierarchical' => 1, 'taxonomy'=>CUSTOM_CATEGORY_TYPE1);
            $cat_args['show_option_none'] = __('Select Category','templatic');
            $str .=wp_dropdown_categories(apply_filters('widget_categories_dropdown_args', $cat_args));
            if($val['is_require'])
            {
                $str .= '<span id="'.$key.'_error"></span>';	
            }
        }else
        if($val['type']=='select')
        {
            $str = '<select name="'.$key.'" '.$val['extra'].'>';
            $option_values_arr = explode(',', $val['options']);
            for($i=0;$i<count($option_values_arr);$i++)
            {
                $seled='';
                
                if($fval==$option_values_arr[$i]){ $seled='selected="selected"';}
                $str .= '<option value="'.$option_values_arr[$i].'" '.$seled.'>'.$option_values_arr[$i].'</option>';	
            }
            $str .= '</select>';
            if($val['is_require'])
            {
                $str .= '<span id="'.$key.'_error"></span>';	
            }
        }else
        if($val['type']=='catcheckbox')
        {
            $fval_arr = explode(',',$fval);
            $str .= $val['tag_before'].get_categories_checkboxes_form(CUSTOM_CATEGORY_TYPE1,$fval_arr).$oval.$val['tag_after'];
            if($val['is_require'])
            {
                $str .= '<span id="'.$key.'_error"></span>';	
            }
        }else
        if($val['type']=='catradio')
        {
            $args = array('taxonomy' => CUSTOM_CATEGORY_TYPE1);
            $all_categories = get_categories($args);
            foreach($all_categories as $key1 => $cat) 
            {
                
                
                    $seled='';
                    if($fval==$cat->term_id){ $seled='checked="checked"';}
                    $str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].' value="'.$cat->name.'" '.$seled.' /> '.$cat->name.$val['tag_after'];	
                
            }
            if($val['is_require'])
            {
                $str .= '<span id="'.$key.'_error"></span>';	
            }
        }else
        if($val['type']=='checkbox')
        {
            if($fval){ $seled='checked="checked"';}
            $str = '<input name="'.$key.'" type="checkbox" '.$val['extra'].' value="1" '.$seled.' />';
            if($val['is_require'])
            {
                $str .= '<span id="'.$key.'_error"></span>';	
            }
        }else
        if($val['type']=='upload')
        {
			
            $str = '<input name="'.$key.'" type="file" '.$val['extra'].' '.$uclass.' value="'.$fval.'" /> ';
            if($val['is_require'])
            {
                $str .= '<span id="'.$key.'_error"></span>';	
            }
        }
        else
        if($val['type']=='radio')
        {
            $options = $val['options'];
            if($options)
            {
                $option_values_arr = explode(',',$options);
                for($i=0;$i<count($option_values_arr);$i++)
                {
                    $seled='';
                    if($fval==$option_values_arr[$i]){$seled='checked="checked"';}
                    $str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].'  value="'.$option_values_arr[$i].'" '.$seled.' /> '.$option_values_arr[$i].$val['tag_after'];
                }
                if($val['is_require'])
                {
                    $str .= '<span id="'.$key.'_error"></span>';	
                }
            }
        }else
        if($val['type']=='multicheckbox')
        {
            $options = $val['options'];
            if($options)
            {  $chkcounter = 0;
                
                $option_values_arr = explode(',',$options);
                for($i=0;$i<count($option_values_arr);$i++)
                {
                    $chkcounter++;
                    $seled='';
                    $fval_arr = explode(',',$fval);
                    if(in_array($option_values_arr[$i],$fval_arr)){ $seled='checked="checked"';}
                    $str .= $val['tag_before'].'<input name="'.$key.'[]"  id="'.$key.'_'.$chkcounter.'" type="checkbox" '.$val['extra'].' value="'.$option_values_arr[$i].'" '.$seled.' /> '.$option_values_arr[$i].$val['tag_after'];
                }
                if($val['is_require'])
                {
                    $str .= '<span id="'.$key.'_error"></span>';	
                }
            }
        }
        else
        if($val['type']=='packageradio')
        {
            $options = $val['options'];
            foreach($options as $okey=>$oval)
            {
                $seled='';
                if($fval==$okey){$seled='checked="checked"';}
                $str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].' value="'.$okey.'" '.$seled.' /> '.$oval.$val['tag_after'];	
            }
            if($val['is_require'])
            {
                $str .= '<span id="'.$key.'_error"></span>';	
            }
        }else
        if($val['type']=='geo_map')
        {
            do_action('templ_submit_form_googlemap');	
        }else
        if($val['type']=='image_uploader')
        {
            do_action('templ_submit_form_image_uploader');	
        }
        if($val['is_require'])
        {
		    $label = '<label>'.__($val['label'],'templatic').' <span class="indicates">*</span> </label>';
        }else
        {
            $label = '<label>'.__($val['label'],'templatic').'</label>';
        }
        echo $val['outer_st'].$label.'<div class="form_cat_right">'.$val['tag_st'].$str.'</div>'.$val['tag_end'].$val['outer_end'];
        }
		}
		?>
   <input type="submit" name="Update" value="<?php echo EDIT_PROFILE_UPDATE_BUTTON;?>" class="btn_input_highlight btn_spacer" onclick="return chk_edit_profile();" />
   
   <input type="button" name="Cancel" value="Cancel" class="btn_input_normal" onclick="window.location.href='<?php echo get_author_link($echo = false, $current_user->ID);?>'" />
   
</form>
	</div>
</div>

<div id="change_pw">		 
    <div class="title-container">
			<h1 class="title_green"><span><?php echo CHANGE_PW_TEXT; ?></span></h1><p class="note"> <span class="required">*</span> <?php echo INDICATES_MANDATORY_FIELDS_TEXT;?> </p>
        	<div class="clearfix"></div>
        </div>
    </div>
<div class="clearfix"></div>
<div class="container-02">
	<div class="graybox"> 
        <form name="chngpwdform" id="chngpwdform" action="<?php echo get_option( 'siteurl' ).'/?page=profile&amp;chagepw=1'; ?>" method="post">
        <?php if($message1) { ?>
          <div class="sucess_msg"> <?php echo PW_CHANGE_SUCCESS_MSG; ?> </div>
          </td>
          <?php } ?>
         
                <div class="form_row clearfix">
                <label>
                <?php echo NEW_PW_TEXT; ?> <span class="indicates">*</span></label>   
                <input type="password" name="new_passwd" id="new_passwd"  class="textfield" />
                </div>
                <div class="form_row clearfix ">
                <label>
                <?php echo CONFIRM_NEW_PW_TEXT; ?> <span class="indicates">*</span></label>
                <input type="password" name="cnew_passwd" id="cnew_passwd"  class="textfield" />
                </div>
                 <input type="submit" name="Update" value="<?php echo EDIT_PROFILE_UPDATE_BUTTON; ?>" class="btn_input_highlight btn_spacer" onclick="return chk_form_pw();" />
                 <input type="button" name="Cancel" value="Cancel" class="btn_input_normal" onclick="window.location.href='<?php echo get_author_link($echo = false, $current_user->ID);?>'" />
                 <div class="clearfix"></div>
        </form>
    </div>
</div>
</div>
<script type="text/javascript">
	/* <![CDATA[ */
function chk_edit_profile()
{
	document.getElementById('user_fname').className = 'textfield';		
	document.getElementById('user_fname_span').innerHTML = '';
	if(document.getElementById('user_fname').value == '')
	{
		//alert("<?php _e('Please enter '.FIRST_NAME_TEXT) ?>");
		document.getElementById('user_fname').className = 'textfield error';		
		document.getElementById('user_fname_span').innerHTML = '<?php _e('Please enter '. FIRST_NAME_TEXT);?>';
		document.getElementById('user_fname').focus();
		return false;
	}
	return true;
}
function chk_form_pw()
{
	if(document.getElementById('new_passwd').value == '')
	{
		alert("<?php _e('Please enter '.NEW_PW_TEXT) ?>");
		document.getElementById('new_passwd').focus();
		return false;
	}
	if(document.getElementById('new_passwd').value.length < 4 )
	{
		alert("<?php _e('Please enter '.NEW_PW_TEXT.' minimum 5 chars') ?>");
		document.getElementById('new_passwd').focus();
		return false;
	}
	if(document.getElementById('cnew_passwd').value == '')
	{
		alert("<?php _e('Please enter '.CONFIRM_NEW_PW_TEXT) ?>");
		document.getElementById('cnew_passwd').focus();
		return false;
	}
	if(document.getElementById('cnew_passwd').value.length < 4 )
	{
		alert("<?php _e('Please enter '.CONFIRM_NEW_PW_TEXT.' minimum 5 chars') ?>");
		document.getElementById('cnew_passwd').focus();
		return false;
	}
	if(document.getElementById('new_passwd').value != document.getElementById('cnew_passwd').value)
	{
		alert("<?php _e(NEW_PW_TEXT.' and '.CONFIRM_NEW_PW_TEXT.' should be same') ?>");
		document.getElementById('cnew_passwd').focus();
		return false;
	}
}
/* ]]> */
</script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		editor_selector : "mce",
		mode : "textareas",
		theme : "advanced",
		plugins :"advimage,advlink,emotions,iespell,",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,bullist,numlist,blockquote,|,link,unlink,anchor,image,code",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		
		width:450,
		height:400,

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script><!-- /TinyMCE -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>