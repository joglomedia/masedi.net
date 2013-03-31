<script>var rootfolderpath = '<?php echo bloginfo('template_directory');?>/images/';</script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/dhtmlgoodies_calendar.js"></script>
<!-- TinyMCE -->
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		editor_selector : "mce",
		mode : "textareas",
		theme : "advanced",
		plugins :"advimage,advlink,emotions,iespell,",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,bullist,numlist,|,link,unlink,image",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		content_css : "css/word.css",

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
</script>
<!-- /TinyMCE -->
<?php if ( get_option('users_can_register') ) { ?>
<div id="sign_up">
  <div class="registration_form_box">
    <div class="title-container">
        <h1 class="title_green">
          	<span><?php  include(TEMPLATEPATH."/monetize/registration/registration_language.php");
                 if($_REQUEST['page']=='login' && $_REQUEST['page1']=='sign_up')
                {
                    echo REGISTRATION_NOW_TEXT;
                }else
                {
                    echo REGISTRATION_NOW_TEXT;
                }
                 ?>
            </span>
        </h1>
        <div class="clearfix"></div>
    </div>
    <div class="login_content"> <?php echo stripslashes(get_option('ptthemes_reg_page_content'));?> </div>
	<?php  if(isset($_REQUEST['ecptcha']) == 'captch') {
	$a = get_option("recaptcha_options");
	$blank_field = $a['no_response_error'];
	$incorrect_field = $a['incorrect_response_error'];
	echo '<div class="error_msg">'.$incorrect_field.'</div>';
	}?>
    <?php
if ( $_REQUEST['emsg']==1)
{
	echo "<p class=\"error_msg\"> ".EMAIL_USERNAME_EXIST_MSG." </p>";
}elseif($_REQUEST['emsg']=='regnewusr')
{
	echo "<p class=\"error_msg\"> ".REGISTRATION_DESABLED_MSG." </p>";
}elseif($_REQUEST['reg'] == 1)
{
	echo "<p class=\"success_msg\"> ".REGISTRATION_SUCCESS_MSG."</p>";
}
?>
   <?php $a = get_option('recaptcha_options'); ?>
  <script type="text/javascript">
				 var RecaptchaOptions = {
					theme : '<?php echo $a['registration_theme']; ?>'
				 };
				 </script>
				 
<div class="container-02">
	<div class="graybox">    
    <form name="registerform" id="registerform" action="<?php echo get_option( 'siteurl' ).'/?page=login&amp;action=register'; ?>" method="post" enctype="multipart/form-data" >  
      <input type="hidden" name="reg_redirect_link" value="<?php echo $_SERVER['HTTP_REFERER'];?>" />
      <?php do_action('templ_registration_form_start');?>
		<?php
		
		global $form_fields_usermeta;
        $validation_info = array();
        foreach($form_fields_usermeta as $key=>$val)
        {
		if($val['on_registration']){
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
        if($val['type']=='text')
        {
            $str = '<input name="'.$key.'" type="text" '.$val['extra'].' value="'.$fval.'">';
            if($val['is_require'])
            {
                $str .= '<span id="'.$key.'_error"></span>';
            }
        }elseif($val['type']=='hidden')
        {
            $str = '<input name="'.$key.'" type="hidden" '.$val['extra'].' value="'.$fval.'">';	
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
            $str = '<input name="'.$key.'" type="file" '.$val['extra'].' value="'.$fval.'">';
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
            $str = '<input name="'.$key.'" type="text" '.$val['extra'].' value="'.$fval.'">';	
			$str .= '<img src="'.get_template_directory_uri().'/images/cal.gif" alt="Calendar"  onclick="displayCalendar(document.registerform.'.$key.',\'yyyy-mm-dd\',this)" style="cursor: pointer;" align="absmiddle" border="0" class="calendar_img" />';
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
                    $str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].' value="'.$cat->name.'" '.$seled.'> '.$cat->name.$val['tag_after'];	
                
            }
            if($val['is_require'])
            {
                $str .= '<span id="'.$key.'_error"></span>';	
            }
        }else
        if($val['type']=='checkbox')
        {
            if($fval){ $seled='checked="checked"';}
            $str = '<input name="'.$key.'" type="checkbox" '.$val['extra'].' value="1" '.$seled.'>';
            if($val['is_require'])
            {
                $str .= '<span id="'.$key.'_error"></span>';	
            }
        }else
        if($val['type']=='upload')
        {
			
            $str = '<input name="'.$key.'" type="file" '.$val['extra'].' '.$uclass.' value="'.$fval.'" > ';
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
                { //$option_values_arr[$i];
                    $seled='';
                    if($fval==$option_values_arr[$i]){$seled='checked="checked"';}
					if($i ==0){
					  $str = $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].'  value="'.$option_values_arr[$i].'" '.$seled.'> '.$option_values_arr[$i].$val['tag_after'];
					}else{
                    $str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].'  value="'.$option_values_arr[$i].'" '.$seled.'> '.$option_values_arr[$i].$val['tag_after'];
					}
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
                    $str .= $val['tag_before'].'<input name="'.$key.'[]"  id="'.$key.'_'.$chkcounter.'" type="checkbox" '.$val['extra'].' value="'.$option_values_arr[$i].'" '.$seled.'> '.$option_values_arr[$i].$val['tag_after'];
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
                $str .= $val['tag_before'].'<input name="'.$key.'" type="radio" '.$val['extra'].' value="'.$okey.'" '.$seled.'> '.$oval.$val['tag_after'];	
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
            $label = '<label>'.$val['label'].' <span class="indicates">*</span> </label>';
        }else
        {
            $label = '<label>'.$val['label'].'</label>';
        }
        echo $val['outer_st'].$label.$val['tag_st'].$str.$val['tag_end'].$val['outer_end'];
        }
		}
		 $pcd = explode(',',get_option('ptthemes_captcha_dislay'));	
	
		if(in_array('User registration page',$pcd) || in_array('Both',$pcd) ){
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			$a = get_option("recaptcha_options");
			if( file_exists(ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php') && is_plugin_active('wp-recaptcha/wp-recaptcha.php')){
				echo '<label class="word-verification">'.WORD_VERIFICATION.'</label>';
				$publickey = $a['public_key']; // you got this from the signup page
				echo recaptcha_get_html($publickey); 
			}
		}
		do_action('templ_registration_form_end');?>
      <input type="submit" name="registernow" value="<?php echo REGISTER_NOW_TEXT;?>" class="b_registernow" />
    </form>
   	</div>
</div>
  </div>
</div>
<?php include_once(TT_REGISTRATION_FOLDER_PATH . 'registration_validation.php');?>
<?php } else { echo 'New user registration is disabled';} ?>