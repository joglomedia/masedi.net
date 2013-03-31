<?php get_header(); ?>
<?php 
session_start();
global $current_user;
$post_category = CUSTOM_CATEGORY_TYPE2;
if(isset($_REQUEST['backandedit']))
{
}else
{
	$_SESSION['resume_info'] = array();
	$_SESSION['file_info'] = '';
}

if(isset($_REQUEST['pid']))
{
	if(!$current_user->ID)
	{
		wp_redirect(get_settings('home').'/?page=login');
		exit;
	}
	$proprty_type = $catid_info_arr['type']['id'];
	$post_info = get_post_info($_REQUEST['pid']);
	$proprty_name = $post_info['post_title'];
	$proprty_desc = $post_info['post_content'];
	$post_meta = get_post_meta($_REQUEST['pid'], '',false);
	$proprty_type = $post_meta['property_type'][0];
	$proprty_address = $post_meta['address'][0];
	$geo_latitude = $post_meta['geo_latitude'][0];
	$geo_longitude = $post_meta['geo_longitude'][0];	
	$proprty_city = $post_meta['property_city'][0];
	$proprty_state = $post_meta['property_state'][0];
	$proprty_country = $post_meta['property_country'][0];
	$proprty_zip = $post_meta['property_zip'][0];
	$proprty_bedroom = $post_meta['bedrooms'][0];
	$proprty_bathroom = $post_meta['bathrooms'][0];
	$proprty_price = $post_meta['price'][0];
	$rentperiod = $post_meta['rentperiod'][0];
	$proprty_add_feature = $post_meta['additional_features'][0];
	$proprty_sqft = $post_meta['area'][0];
	$proprty_mlsno = $post_meta['mls_no'][0];
	$proprty_language = $post_meta['language'][0];
	$resume_add_coupon = $post_meta['resume_add_coupon'][0];
	$proprty_location = $post_meta['location'][0];
	$cat_array = array();
	if(isset($_REQUEST['pid'])) {
		$cat_array = wp_get_post_terms($_REQUEST['pid'],CUSTOM_CATEGORY_TYPE2);
	}
	$thumb_img_arr = bdw_get_images_with_info($_REQUEST['pid'],'thumb');
}
if($_SESSION['resume_info'] && $_REQUEST['backandedit'])
{ 
	$user_web = $_SESSION['resume_info']['user_web'];
	$user_photo = $_SESSION['resume_info']['user_photo'];
	$resume_add_coupon = $_SESSION['resume_info']['resume_add_coupon'];
	$user_login_or_not = $_SESSION['resume_info']['user_login_or_not'];
	$user_fname = $_SESSION['resume_info']['user_fname'];
	$user_phone = $_SESSION['resume_info']['user_phone'];
	$user_email = $_SESSION['resume_info']['user_email'];
	$featured_h = $_SESSION['resume_info']['featured_h']; 
	$featured_c = $_SESSION['resume_info']['featured_c']; 
	$zooming_factor = $_SESSION['resume_info']['zooming_factor'];
	if($_SESSION['resume_info']['category'] != ''){ 
		$cat_array1 = implode("-",$_SESSION['resume_info']['category']);
		$cat_array2 = explode("-",$cat_array1) ;
		$tc= count($cat_array2 );
		$allcat ="";
		for($i=0; $i<=$tc; $i++ ){
			$allc = explode(',',$cat_array2[$i]);
			if($allc[0] != ""){
				$allc1 .= $allc[0].","; 
			}
		}
		$cat_array = explode(',',$allc1);
	}else{
		$cat_array = $_SESSION['resume_info']['category'];
	}
}
if(isset($_REQUEST['category']) && $_REQUEST['category'] != ''){
	$user_fname = $_REQUEST['user_fname'];
	$user_phone = $_REQUEST['user_phone'];
	$user_email = $_REQUEST['user_email'];
	$user_login_or_not = $_REQUEST['user_login_or_not'];
}

if(get_option('pt_show_postaresumelink') == 'Yes'){
global $ip_db_table_name;
$ip = $wpdb->get_row("select * from $ip_db_table_name where ipaddress = '".getenv("REMOTE_ADDR")."' and ipstatus=1");
if($ip == ""){
?>
<!-- TinyMCE -->
<script type="text/javascript">var rootfolderpath = '<?php echo bloginfo('template_directory');?>/images/';</script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/dhtmlgoodies_calendar.js"></script>
<link href="<?php echo get_template_directory_uri() ?>/library/css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css" />
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
<?php $a = get_option('recaptcha_options'); ?>
  <script type="text/javascript">
				 var RecaptchaOptions = {
					theme : '<?php echo $a['registration_theme']; ?>'
				 };
				 </script>
<?php if($_REQUEST['pid'])
{
	if($_REQUEST['renew'])
	{
		$page_title = RENEW_RESUME_TEXT;
	}else
	{
		$page_title = EDIT_RESUME_TEXT;
	}
}else
{
	$page_title = SUBMIT_RESUME_TEXT;
} ?>
<div id="page">
<div id="content-wrap" class="clear <?php if(get_option("ptthemes_page_layout") == "Right Sidebar") { echo "right-side"; } else { echo "left-side"; } ?>" >
    <div id="content" class="content">
        <div class="breadcums">
	        <ul class="page-nav"><li><?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') { yoast_breadcrumb('',' &raquo; '.__($page_title)); } ?></li></ul>
        </div>
	 <div class="title-container">
		<h1 class="title_green"><span><?php _e($page_title);?></span></h1>
        <p class="note fr"> <span class="required">*</span> <?php _e(INDICATES_MANDATORY_FIELDS_TEXT);?> </p>
	    <div class="clearfix"></div>
     </div>
 <?php  if(isset($_REQUEST['ecptcha']) == 'captch') {
	$a = get_option("recaptcha_options");
	$blank_field = $a['no_response_error'];
	$incorrect_field = $a['incorrect_response_error'];
	echo '<div class="error_msg">'.$incorrect_field.'</div>';
}
 if(is_allow_user_register()){?>
  
            <?php if(isset($_REQUEST['usererror'])==1)

			{
				if(isset($_SESSION['userinset_error']))
				{
					for($i=0;$i<count($_SESSION['userinset_error']);$i++)
					{
						echo '<div class="error_msg">'.$_SESSION['userinset_error'][$i].'</div>';
					}
					echo "<br>";
				}
			}
			?>   
			<?php
            if($current_user->ID=='') {	 ?>
              <div class="login_submit clearfix" id="loginform">
                  <h5 class="form_title spacer_none"><?php _e(LOGINORREGISTER);?>  </h5>
                  <hr>
				  <?php if(isset($_REQUEST['emsg'])==1): ?>
                    <div class="error_msg"><?php echo INVALID_USER_PW_MSG;?></div>
                  <?php endif; ?>
                  <div class="clearfix">
                    <label class="lab1"><?php _e(IAM_TEXT);?> </label>
                     <span class=" user_define"> <label class="radio_lbl"><input name="user_login_or_not" type="radio" value="existing_user" <?php if($user_login_or_not=='existing_user'){ echo 'checked="checked"';}else{ echo 'checked="checked"'; }?> onclick="set_login_registration_frm('existing_user');" /> <?php _e(EXISTING_USER_TEXT);?> </label></span>
                    <?php if ( get_option('users_can_register') ) { ?>				 
                     <span class="user_define"> <label class="radio_lbl"><input name="user_login_or_not" type="radio" value="new_user" <?php if($user_login_or_not=='new_user'){ echo 'checked="checked"';}?> onclick="set_login_registration_frm('new_user');" /> <?php _e(NEW_USER_TEXT);?> </label></span>
                     <?php } ?>
                  </div>
                  <form name="loginform" class="sublog_prop prop_sub_login" id="login_user_frm_id" action="<?php echo get_ssl_normal_url(get_settings('home').'/index.php?page=login&page1='.$_REQUEST['page']); ?>" method="post" >
                  <div class="clearfix lab2_cont">
                    <label class="lab2"><?php _e(LOGIN_TEXT);?>*</label>
                    <input type="text" class="textfield slog_prop " id="user_login" name="log" />
                  </div>
                  
                   <div class="learfix lab2_cont">
                    <label class="lab2"><?php _e(PASSWORD_TEXT);?>* </label>
                    <input type="password" class="textfield slog_prop" id="user_pass" name="pwd" />
                  </div>
                  
                  <div class="form_row clearfix">
                  <input name="submit" type="submit" value="<?php _e(SUBMIT_BUTTON);?>" class="button_green submit" />
                  </div>
                
                  <?php	$login_redirect_link = get_settings('home').'/?page=postaresume';?>
                  <input type="hidden" name="redirect_to" value="<?php echo $login_redirect_link; ?>" />
                  <input type="hidden" name="testcookie" value="1" />
                  <input type="hidden" name="pagetype" value="<?php echo $login_redirect_link; ?>" />
                  </form>
				  <?php
				if(strtolower(get_option('ptttheme_fb_opt')) == strtolower('Yes')){
				_e('OR','templatic');
				do_action('fbc_display_login_button');
				}
				?>
              </div>
             <?php }?>
             <?php }?>
			
			  <?php 
			 if(isset($_REQUEST['pid']) || isset($_POST['renew'])){
				$form_action_url = site_url().'/?page=previews';
			 }else
			 {
				 $reqPid  = '';
				 if(isset($_REQUEST['pid']))
				   {
					  $reqPid = $_REQUEST['pid']; 
				   }
				 $form_action_url = get_ssl_normal_url(site_url().'/?page=previews',$reqPid);
			 }
			 $post_sql = $wpdb->get_row("select post_author,ID from $wpdb->posts where post_author = '".$current_user->data->ID."' and ID = '".$_REQUEST['pid']."'");
				if((count($post_sql) <= 0) && ($current_user->data->ID != '') && ($current_user->data->ID != 1) && (isset($_REQUEST['pid']))){ 
				echo "ERROR: Sorry, you are not allowed to edit this post.";  } else { ?>
           	<form name="resumeform" id="resumeform" class="submit_resume_form" action="<?php echo $form_action_url; ?>" method="post" enctype="multipart/form-data">
 			 <?php
             /*--When going to renew the package ---*/
			 if(isset($_REQUEST['renew']) && $_REQUEST['renew'] != ''): ?>
			 <input type="hidden" name="renew" id="renew" value="1"/>
			 <?php endif; ?> 
		    <input type="hidden" name="all_cat" id="all_cat" value=""/>
            <input type="hidden" name="pid" id="pid" value="<?php echo $_REQUEST['pid'];?>" />
            <?php
		if(isset($_REQUEST['pid']) && $_REQUEST['pid'] != '') {  ?>
			<input type="hidden" name="category" value="<?php echo $cat_array[0]->term_taxonomy_id;?>" />
<?php	} else { 
			if(!isset($_REQUEST['category'])){ ?>
<?php			if($current_user->ID=='')	{ 	 ?>
					<input type="hidden" name="user_login_or_not" id="user_login_or_not" value="<?php if($user_login_or_not != '') {echo $user_login_or_not; } else { echo "new_user";}?>" />				
					<div id="contact_detail_id" style="display:none; padding-bottom:25px;"> 
                    <?php 		
						global $form_fields_usermeta;
						$validation_info = array();
						foreach($form_fields_usermeta as $key=>$val)
						{
							if($val['on_registration'])
								{
									$str = ''; $fval = '';
									$field_val = $_SESSION['resume_info'][$key];
									if($field_val){$fval = $field_val;}else{$fval = $val['default'];}
									if($key == "user_email" || $key == "user_fname" || $key == "user_phone"):
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
										if($val['type']=='include')
										{
											$str = @include_once($val['default']);
										}else
										if($val['type']=='head')
										{
											$str = '';
										}
										if($val['is_require'])
										{
											$label = '<label>'.$val['label'].' <span class="indicates">*</span> </label>';
										}else
										{
											$label = '<label>'.$val['label'].'</label>';
										}
									
									echo $val['outer_st'].$label.$val['tag_st'].$str.$val['tag_end'].$val['outer_end'];
									endif;
								}
						  }
				 ?>
					</div>
			<?php } else { ?>
                        <input type="hidden" name="user_login_or_not" id="user_login_or_not" value="<?php if($user_login_or_not != '') {echo $user_login_or_not; } else { echo "existing_user";}?>" />
    		<?php } ?> 
            <h4 class="sub_head"><?php _e('Personal Information');?></h4> 
	<?php } else { 
			if($_REQUEST['category'] != "" && isset($_REQUEST['category'])){
			$cat = explode(",",$_REQUEST['category']);
			}
			?>
				<input type="hidden" name="renew" value="<?php echo $_REQUEST['renew'];?>" />
                <input type="hidden" name="user_fname" id="user_fname_hidden" value="<?php echo $_REQUEST['user_fname'];?>" />
				<input type="hidden" name="user_phone" id="user_phone_hidden" value="<?php echo $_REQUEST['user_phone'];?>" />
				<input type="hidden" name="user_email" id="user_email_hidden" value="<?php echo $_REQUEST['user_email'];?>" />
				<input type="hidden" name="category" value="<?php if(isset($_SESSION['resume_info']['category']) && $_SESSION['resume_info']['category'] != '') { echo $_SESSION['resume_info']['category'];} else { echo $cat[0]; }?>" />
<?php 		} 
		}
			if(!isset($geo_longitude)){$geo_longitude = '';	}
			if(!isset($geo_latitude)){$geo_latitude = '';	}
			if(!isset($geo_address)){$geo_address = '';	}
				$default_custom_metaboxes = get_post_custom_fields_templ(CUSTOM_POST_TYPE2,'0','user_side');
				display_custom_post_field($default_custom_metaboxes,'resume_info',$geo_latitude,$geo_longitude,$geo_address,CUSTOM_POST_TYPE2);
			?> 
			<input name="remote_ip" id="remote_ip" value="<?php echo getenv("REMOTE_ADDR"); ?>" type="hidden" class="textfield medium" />
			<input name="ip_status" id="ip_status" value="<?php if($ip_status != ""){ echo $ip_status; }else{ echo "0"; }?>" type="hidden" class="textfield medium" />
		<?php if(get_option('accept_term_condition') && get_option('accept_term_condition') == 'yes'){	?>
        <div class="form_row clearfix">
             	<label>&nbsp;</label>
             	 <input name="term_and_condition" id="term_and_condition" value="" type="checkbox" class="chexkbox" />
                 <?php echo stripslashes(get_option('term_condition_content'));?>
              </div>
              <script type="text/javascript">
              function check_term_condition()
			  {
				if(eval(document.getElementById('term_and_condition')))  
				{
					if(document.getElementById('term_and_condition').checked)
					{	
						return true;
					}else
					{
						alert('<?php _e('Please accept Term and Conditions');?>');
						return false;
					}
				}
			  }
              </script>
        <?php 
		$submit_button = 'onclick="return check_term_condition();"';
		}?>
		
		  <?php $pcd = get_option('ptthemes_captcha_dislay_resume');
		  include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		  if($pcd == 'Yes' && is_plugin_active('wp-recaptcha/wp-recaptcha.php')){
						echo '<div class="form_row clearfix">';
						$a = get_option("recaptcha_options");
						echo '<label>'.WORD_VERIFICATION.'</label>';
						$publickey = $a['public_key']; // you got this from the signup page
						echo recaptcha_get_html($publickey); 
						
						 echo '</div>';
						 }
					?> 
              <?php if(!isset($submit_button)){ $submit_button = ''; }?>
              <div class="breviewyourlist">
			     <input type="submit" name="Update" value="<?php _e('Preview This Resume Post');?>" class="normal_button" />
			  </div>

			  <div class="form_row clear_both">
			  	 <span class="message_note nextprev"> <?php _e('Note: You will be able to see a preview in the next page');?>  </span>
			  </div>
              <input type="hidden" name="zooming_factor" id="zooming_factor" value="<?php echo $zooming_factor;?>">
           </form>
		   <?php } ?>
</div> <!-- content #end -->
<script type="text/javascript">

function set_login_registration_frm(val)
{

	if(val=='existing_user')
	{
		document.getElementById('contact_detail_id').style.display = 'none';
		document.getElementById('login_user_frm_id').style.display = '';
		document.getElementById('user_login_or_not').value = val;
	}else  //new_user
	{
		document.getElementById('contact_detail_id').style.display = 'block';
		document.getElementById('login_user_frm_id').style.display = 'none';
		document.getElementById('user_login_or_not').value = val;
	}
}
<?php if($user_login_or_not)
{
?>
set_login_registration_frm('<?php echo $user_login_or_not;?>');
<?php
}
?>
</script>
<?php 
$form_fields = array();

$form_fields['category'] = array(
				   'name'	=> 'category',
				   'espan'	=> 'category_span',
				   'type'	=> 'checkbox',
				   'text'	=> 'Please select Category',
				   'validation_type' => 'require');
global $custom_post_meta_db_table_name;
$extra_field_sql = mysql_query("select * from $custom_post_meta_db_table_name where is_require = '1' and (post_type ='".CUSTOM_POST_TYPE2."' or  post_type ='both') and (show_on_page = 'user_side' or show_on_page = 'both_side') order by sort_order");
while($res = mysql_fetch_array($extra_field_sql)){
	$title = $res['site_title'];
	$name = $res['htmlvar_name'];
	$type = $res['ctype'];
	$require_msg = $res['field_require_desc'];
	$validation_type = $res['validation_type'];
	$form_fields[$name] = array(
				   'title'	=> $title,
				   'name'	=> $name,
				   'espan'	=> $name.'_error',
				   'type'	=> $type,
				   'text'	=> $require_msg,
				   'validation_type' => $validation_type);	
	
}
$validation_info = array();
 foreach($form_fields as $key=>$val)
			{			
				$str = ''; $fval = '';
				$field_val = $key.'_val';
				if(!isset($val['title']))
				   {
					 $val['title'] = '';   
				   }	
				$validation_info[] = array(
											   'title'	=> $val['title'],
											   'name'	=> $key,
											   'espan'	=> $key.'_error',
											   'type'	=> $val['type'],
											   'text'	=> $val['text'],
											   'validation_type'	=> $val['validation_type']);
			}	
include_once(TT_MODULES_FOLDER_PATH.'resume/submition_validation.php'); 
}else{ ?>
<div class="error_msg">
<?php _e(IP_BLOCK,'templatic'); ?>
</div>
<?php } 
  }else{ ?>
	<div class="error_msg">
<?php _e('Invalid token','templatic'); ?>
</div>
<?php
 } ?>
 
<div id="sidebar">
	<?php dynamic_sidebar("post-resume-sidebar"); ?>
</div>
<?php get_footer(); ?>