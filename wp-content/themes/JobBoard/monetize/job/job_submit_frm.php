<?php get_header(); ?>
<?php
session_start();
global $current_user;
$cat_display=get_option('ptthemes_category_dislay');
$post_category = CUSTOM_CATEGORY_TYPE1;
if(isset($_REQUEST['backandedit']))
{
}else
{
	$_SESSION['job_info'] = array();
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
	$job_add_coupon = $post_meta['job_add_coupon'][0];
	$proprty_location = $post_meta['location'][0];
	$cat_array = array();
	if(isset($_REQUEST['pid'])) {
		$cat_array = wp_get_post_terms($_REQUEST['pid'],CUSTOM_CATEGORY_TYPE1);
	}
	$thumb_img_arr = bdw_get_images_with_info($_REQUEST['pid'],'thumb');
}
if($_SESSION['job_info'] && $_REQUEST['backandedit'])
{ 
	$user_fname = $_SESSION['job_info']['user_fname'];
	$user_phone = $_SESSION['job_info']['user_phone'];
	$user_email = $_SESSION['job_info']['user_email'];
	$user_web = $_SESSION['job_info']['user_web'];
	$user_photo = $_SESSION['job_info']['user_photo'];
	$job_add_coupon = $_SESSION['job_info']['job_add_coupon'];
	$user_email = $_SESSION['job_info']['user_email'];
	$user_login_or_not = $_SESSION['job_info']['user_login_or_not'];
	$featured_h = $_SESSION['job_info']['featured_h']; 
	$featured_c = $_SESSION['job_info']['featured_c']; 
	$zooming_factor = $_SESSION['job_info']['zooming_factor'];
	if(($cat_display == 'checkbox' || $cat_display == '') && $_SESSION['job_info']['category'] != ''){ 
		$cat_array1 = implode("-",$_SESSION['job_info']['category']);
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
		$cat_array = $_SESSION['job_info']['category'];
	}
	$job_add_coupon = $_SESSION['job_info']['job_add_coupon'];
	$price_select = $_SESSION['job_info']['price_select'];
	global $price_db_table_name;
	$pricesql = $wpdb->get_row("select * from $price_db_table_name where pid='".$price_select."'"); 
	if($_SESSION['job_info']['featured_h']!= "" && $_SESSION['job_info']['featured_h']==""){
		$fprice = $pricesql->feature_amount;
		$hprice = $pricesql->feature_amount;
	}else if($_SESSION['job_info']['featured_h']== "" && $_SESSION['job_info']['featured_h']!=""){
		$fprice = $pricesql->feature_cat_amount;
		$cprice = $pricesql->feature_cat_amount;
	}else if($_SESSION['job_info']['featured_h']!= "" && $_SESSION['job_info']['featured_h']!=""){
		$fprice = $pricesql->feature_cat_amount + $pricesql->feature_amount;
	}
	$packprice = $pricesql->package_cost;
	$is_feature = $pricesql->is_featured;
	$cat_price = $_SESSION['job_info']['all_cat_price'];
	$total_price = $_SESSION['job_info']['total_price'];
	$none = 0;
}
if(isset($_REQUEST['category']) && $_REQUEST['category'] != ''){
	$user_fname = $_REQUEST['user_fname'];
	$user_phone = $_REQUEST['user_phone'];
	$user_email = $_REQUEST['user_email'];
	$user_login_or_not = $_REQUEST['user_login_or_not'];
}
if(isset($proprty_desc)=='')
{
	$proprty_desc = __("Enter description for your listing.");
}
$cat_display=get_option('ptthemes_category_dislay');
if(get_option('pt_show_postajoblink') == 'Yes'){
global $ip_db_table_name;
$ip = $wpdb->get_row("select * from $ip_db_table_name where ipaddress = '".getenv("REMOTE_ADDR")."' and ipstatus=1");
if($ip == ""){
if($cat_display==''){$cat_display='checkbox';}
?>
<!-- TinyMCE -->
<script type="text/javascript">var rootfolderpath = '<?php echo bloginfo('template_directory');?>/images/';</script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/library/js/dhtmlgoodies_calendar.js"></script>
<link href="<?php echo get_template_directory_uri() ?>/library/css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/monetize/job/job.js"></script>
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
<script type="text/javascript">
function show_featuredprice(pkid)
{
	if (pkid=="")
	  {
	  document.getElementById("featured_h").innerHTML="";
	  return;
	  }else{
	  //document.getElementById("featured_h").innerHTML="";
	  document.getElementById("process").style.display ="block";
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
		document.getElementById("process").style.display ="none";
		var myString =xmlhttp.responseText;
		var myStringArray = myString.split("###RAWR###");  
		document.getElementById('alive_days').value = myStringArray[6];
		if(myStringArray[5] == 1){
		if(document.getElementById('is_featured').style.display == "none")
		{
			document.getElementById('is_featured').style.display="";
		}
			document.getElementById('featured_h').value = myStringArray[0];
			document.getElementById('ftrhome').innerHTML = "("+myStringArray[0]+"<?php echo fetch_currency(get_option('ptttheme_currency_symbol'),'currency_symbol');?>)";
			document.getElementById('featured_c').value = myStringArray[1];
			document.getElementById('ftrcat').innerHTML = "("+myStringArray[1]+"<?php echo fetch_currency(get_option('ptttheme_currency_symbol'),'currency_symbol');?>)";
			document.getElementById('pkg_price').innerHTML = myStringArray[4];   
		}else{
			document.getElementById('pkg_price').innerHTML = myStringArray[4];  
			document.getElementById('featured_c').value=0;
			document.getElementById('ftrcat').innerHTML	=0+"<?php echo fetch_currency(get_option('ptttheme_currency_symbol'),'currency_symbol');?>";		
			document.getElementById('featured_h').value=0;
			document.getElementById('ftrhome').innerHTML = 0+"<?php echo fetch_currency(get_option('ptttheme_currency_symbol'),'currency_symbol');?>";		
			document.getElementById('is_featured').style.display = "none"; 
		 	document.getElementById('total_price').value = parseFloat(myStringArray[0]) + parseFloat(myStringArray[1]) + parseFloat(myStringArray[4]);
			document.getElementById('result_price').innerHTML = parseFloat(myStringArray[0]) + parseFloat(myStringArray[1]) + parseFloat(myStringArray[4]);
		
		}
		if((document.getElementById('featured_h').checked== true) && (document.getElementById('featured_c').checked== true))
		{	
			
			document.getElementById('feture_price').innerHTML = parseFloat(myStringArray[0]) + parseFloat(myStringArray[1]) ;
			
			document.getElementById('total_price').value = parseFloat(myStringArray[0]) + parseFloat(myStringArray[1]) + parseFloat(myStringArray[4]);
			
			document.getElementById('result_price').innerHTML = parseFloat(myStringArray[0]) + parseFloat(myStringArray[1]) + parseFloat(myStringArray[4]);
			
		}else if((document.getElementById('featured_h').checked == true) && (document.getElementById('featured_c').checked == false)){
			
			document.getElementById('feture_price').innerHTML = parseFloat(myStringArray[0]);
			
			document.getElementById('total_price').value = parseFloat(myStringArray[0]) + parseFloat(document.getElementById('feture_price').innerHTML) + parseFloat(myStringArray[4]);
			
			document.getElementById('result_price').innerHTML = parseFloat(myStringArray[0]) + parseFloat(document.getElementById('feture_price').innerHTML) + parseFloat(myStringArray[4]);
		}else if((document.getElementById('featured_h').checked == false) && (document.getElementById('featured_c').checked == true)){
			document.getElementById('feture_price').innerHTML = parseFloat(myStringArray[1]);
			document.getElementById('total_price').value = parseFloat(myStringArray[1]) + parseFloat(document.getElementById('feture_price').innerHTML) + parseFloat(myStringArray[4]);
			
			document.getElementById('result_price').innerHTML = parseFloat(myStringArray[1]) + parseFloat(document.getElementById('feture_price').innerHTML) + parseFloat(myStringArray[4]);
		}else{
			document.getElementById('total_price').value = parseFloat(document.getElementById('feture_price').innerHTML) + parseFloat(myStringArray[4]);
			
			document.getElementById('result_price').innerHTML =parseFloat(document.getElementById('feture_price').innerHTML) + parseFloat(myStringArray[4]);
		}
	  } 
	  }
	  url = "<?php echo get_template_directory_uri(); ?>/monetize/job/ajax_price.php?pkid="+pkid
	  xmlhttp.open("GET",url,true);
	  xmlhttp.send();
	 
}


function allplaces_packages(cp_price) {
	var total = 0;
	var t=0;
	//var c= form['category[]'];
	var dml = document.forms['jobform'];
	var c = dml.elements['category[]'];
	var selectall = dml.elements['selectall'];
	if(selectall.checked == false){
		cp_price = 0;
	} else {
		cp_price = cp_price;
	}
	var cats = document.getElementById('all_cat').value;
	document.getElementById('all_cat').value = "";
	document.getElementById('all_cat_price').value = 0;
	
		for(var i=0 ;i < c.length;i++){
		c[i].checked?t++:null;
		if(c[i].checked){	
			var a = c[i].value.split(",");
			if(i ==  (c.length - 1) ){
				document.getElementById('all_cat').value += a[0]+"|";
			} else {
				document.getElementById('all_cat').value += a[0]+"|";
			}
		}
	}

	document.getElementById('all_cat_price').value = parseFloat(cp_price);
	document.getElementById('total_price').value =  parseFloat(document.getElementById('all_cat_price').value) + parseFloat(document.getElementById('feture_price').innerHTML) +  parseFloat(document.getElementById('pkg_price').innerHTML);
	document.getElementById('result_price').innerHTML =  parseFloat(document.getElementById('all_cat_price').value) + parseFloat(document.getElementById('feture_price').innerHTML) +  parseFloat(document.getElementById('pkg_price').innerHTML);
	
	var cats = document.getElementById('all_cat').value ;
	
	  document.getElementById("packages_checkbox").innerHTML="";
	  document.getElementById("process2").style.display ="";
	}
</script>

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
		$page_title = RENEW_JOB_TEXT;
	}else
	{
		$page_title = EDIT_JOB_TEXT;
	}
}else
{
	$page_title = SUBMIT_JOB_TEXT;
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
?>
  
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
                    <label class="lab2"><?php _e(LOGIN_TEXT);?><span class="required">*</span></label>
                    <input type="text" class="textfield slog_prop " id="user_login" name="log" />
                  </div>
                  
                   <div class="learfix lab2_cont">
                    <label class="lab2"><?php _e(PASSWORD_TEXT);?><span class="required">*</span> </label>
                    <input type="password" class="textfield slog_prop" id="user_pass" name="pwd" />
                  </div>
                  
                  <div class="form_row clearfix">
                  <input name="submit" type="submit" value="<?php _e(SUBMIT_BUTTON);?>" class="button_green submit" />
                  </div>
                
                  <?php	$login_redirect_link = get_settings('home').'/?page=postajob';?>
                  <input type="hidden" name="redirect_to" value="<?php echo $login_redirect_link; ?>" />
                  <input type="hidden" name="testcookie" value="1" />
                  <input type="hidden" name="pagetype" value="<?php echo $login_redirect_link; ?>" />
                  <?php
					if(strtolower(get_option('ptttheme_fb_opt')) == strtolower('Yes'))
					{
				  ?>		
                  <span class="text-or">
				  	<?php _e('OR','templatic'); ?>
                  </span>
                  <div id="fbc_login" class="fbc_hide_on_login fbc_connect_button_area">
						<span><small>Connect with your Facebook Account</small></span>
                    	<br>
	                    <div class="dark">
    		               <?php do_action('login_form'); ?>
                  		</div>
                  </div>
				<?php } ?>
                  </form>
              </div>
             <?php }?>
			
			  <?php 
			 if(isset($_REQUEST['pid']) || isset($_POST['renew'])){
				$form_action_url = site_url().'/?page=preview';
			 }else
			 {
				 $reqPid  = '';
				 if(isset($_REQUEST['pid']))
				   {
					  $reqPid = $_REQUEST['pid']; 
				   }
				 $form_action_url = get_ssl_normal_url(site_url().'/?page=preview',$reqPid);
			 }
			 $post_sql = $wpdb->get_row("select post_author,ID from $wpdb->posts where post_author = '".$current_user->data->ID."' and ID = '".$_REQUEST['pid']."'");
				if((count($post_sql) <= 0) && ($current_user->data->ID != '') && ($current_user->data->ID != 1) && (isset($_REQUEST['pid']))){ 
				echo "ERROR: Sorry, you are not allowed to edit this post.";  } else {  ?>
           	<form name="jobform" id="jobform" class="submit_job_form" action="<?php echo $form_action_url; ?>" method="post" enctype="multipart/form-data">
 			 <?php
             /*--When going to renew the package ---*/
			 if(isset($_REQUEST['renew']) && $_REQUEST['renew'] != ''): ?>
			 <input type="hidden" name="renew" id="renew" value="1"/>
			 <?php endif; ?> 

			 <?php 
			  /*----Package information for edit-----------*/
			 if(isset($_REQUEST['pid']) !="" && !isset($_REQUEST['renew'])): ?>
				<?php /*?><input type="hidden" name="price_select" id="price_select" value="<?php echo get_post_meta($_REQUEST['pid'],'pkg_id',true); ?>"/><?php */?>
                <input type="hidden" name="total_price" id="total_price" value="<?php echo get_post_meta($_REQUEST['pid'],'paid_amount',true); ?>"/>
                <input type="hidden" name="featured_type" id="featured_type" value="<?php echo get_post_meta($_REQUEST['pid'],'featured_type',true); ?>"/>
			<?php endif; ?>

            <?php if(!isset($_REQUEST['backandedit'])): ?>
	            <input type="hidden" name="total_price" id="total_price" value="<?php echo get_post_meta($_REQUEST['pid'],'paid_amount',true); ?>"/>
            <?php endif; ?>    
			<input type="hidden" name="alive_days" id="alive_days" value="<?php echo get_post_meta($_REQUEST['pid'],'alive_days',true); ?>"/>
		    <input type="hidden" name="all_cat" id="all_cat" value=""/>
			<input type="hidden" name="all_cat_price" id="all_cat_price" value="<?php if($_REQUEST['category'] !=""){ $cat = explode(",",$_REQUEST['category']); echo $cat[2]; }else{ echo "0";}?>"/>
            <input type="hidden" name="pid" id="pid" value="<?php echo $_REQUEST['pid'];?>" />
            <?php
		if(isset($_REQUEST['pid']) && $_REQUEST['pid'] != '') {  ?>
			<input type="hidden" name="category" value="<?php echo $cat_array[0]->term_taxonomy_id;?>" />
			<input type="hidden" name="post_city_id" value="<?php echo $post_city_id;?>" />
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
									$field_val = $_SESSION['job_info'][$key];
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
            <h4 class="sub_head"><?php _e('Company Information');?></h4> 
	<?php } else { 
			if($_REQUEST['category'] != "" && isset($_REQUEST['category'])){
			$cat = explode(",",$_REQUEST['category']);
			}
			?>
				<input type="hidden" name="renew" value="<?php echo $_REQUEST['renew'];?>" />
                <input type="hidden" name="user_fname" id="user_fname_hidden" value="<?php echo $_REQUEST['user_fname'];?>" />
				<input type="hidden" name="user_phone" id="user_phone_hidden" value="<?php echo $_REQUEST['user_phone'];?>" />
				<input type="hidden" name="user_email" id="user_email_hidden" value="<?php echo $_REQUEST['user_email'];?>" />
				<input type="hidden" name="post_city_id" value="<?php echo $_REQUEST['post_city_id'];?>" />
				<input type="hidden" name="category" value="<?php if(isset($_SESSION['job_info']['category']) && $_SESSION['job_info']['category'] != '') { echo $_SESSION['job_info']['category'];} else { echo $cat[0]; }?>" />
<?php 		} 
		}
			if(!isset($geo_longitude)){$geo_longitude = '';	}
			if(!isset($geo_latitude)){$geo_latitude = '';	}
			if(!isset($geo_address)){$geo_address = '';	}
				$default_custom_metaboxes = get_post_custom_fields_templ(CUSTOM_POST_TYPE1,'0','user_side');
				display_custom_post_field($default_custom_metaboxes,'job_info',$geo_latitude,$geo_longitude,$geo_address,CUSTOM_POST_TYPE1);
			?> 
			<input name="remote_ip" id="remote_ip" value="<?php echo getenv("REMOTE_ADDR"); ?>" type="hidden" class="textfield medium" />
			<input name="ip_status" id="ip_status" value="<?php if($ip_status != ""){ echo $ip_status; }else{ echo "0"; }?>" type="hidden" class="textfield medium" />
			<?php 	
			global $current_user;
	
			if($_REQUEST['pid']=='' || $_REQUEST['renew']=='1'){
			 	 $place_price_info = get_job_price_info();
			 	 if($place_price_info && is_more_alive_days($current_user->ID))
				  { ?>
					 <h5 class="form_title" style="padding-top:20px;"> <?php echo SELECT_PACKAGE_TEXT;?> <span class="required">*</span></h5>
					 <div class="form_row_pkg clearfix" id="packages_checkbox">
					<?php
					if(isset($_REQUEST['pid']) && isset($_REQUEST['renew']))
					  {
						$cat_array = wp_get_post_terms($_REQUEST['pid'],CUSTOM_CATEGORY_TYPE1);
						foreach($cat_array as $_cat_array)
						 {
							$taxtId .= $_cat_array->term_taxonomy_id."|";
						 }
						get_price_info($price_select,$taxtId,CUSTOM_POST_TYPE1);
					  }
					if(!$_REQUEST['pid'])
					  {
						get_price_info($price_select,$catid,CUSTOM_POST_TYPE1); 
					?>
					<span class="message_error2" id="price_package_error"></span>
					<?php } ?>
                    </div>
				<div class="form_row clearfix" id="is_featured" <?php if($is_feature == '0'){ echo "style=display:none;"; } ?>>
						<label><?php echo FEATURED_TEXT;?> </label>
						<div class="feature_label">
						<label style="clear:both;width:430px;"><input type="checkbox" name="featured_h" id="featured_h" value="0" onclick="featured_list(this.id)" <?php if($featured_h !=""){ echo "checked=checked"; } ?>/><?php _e(FEATURED_H,'templatic'); ?> <span id="ftrhome"><?php if($featured_h !=""){ echo "(".display_amount_with_currency($featured_h).")"; }else{ echo "(".display_amount_with_currency('0').")"; } ?></span></label>
						<label style="clear:both;width:430px;"><input type="checkbox" name="featured_c" id="featured_c" value="0" onclick="featured_list(this.id)" <?php if($featured_c !=""){ echo "checked=checked"; } ?>/><?php _e(FEATURED_C,'templatic'); ?><span id="ftrcat"><?php if($featured_c !=""){ echo "(".display_amount_with_currency($featured_c).")"; }else{ echo "(".display_amount_with_currency('0').")"; } ?></span></label>
						
						<input type="hidden" name="featured_type" id="featured_type" value="none"/>
						<span id='process' style='display:none;'><img src="<?php echo get_template_directory_uri()."/images/process.gif"; ?>" alt='Processing..' /></span> 
						</div>
				</div>
                <span class="message_note"><?php echo FEATURED_MSG;?></span>
                <span id="category_span" class="message_error2"></span>
				  <div class="form_row clearfix">
					<label><?php echo TOTAL_TEXT;?> </label>
					<div class="form_row clearfix total-price">
					<?php 
						if(!isset($total_price)){ $total_price = ''; }
						if(!isset($fprice)){ $fprice = ''; }
					?>
					<?php 
						$currency = fetch_currency(get_option('ptttheme_currency_symbol'),'currency_symbol');
						$position = get_option('ptttheme_currency_position');
					?>
					 <?php if($position == 'Symbol Before amount'){ echo $currency; }else if($position == 'Space between Before amount and Symbol'){ echo $currency.' '; } ?>
					 <span id="pkg_price"><?php if(isset($price_select) && $price_select !=""){ echo $packprice; } else{ echo "0";}?></span>
					 <?php if($position == 'Symbol After amount'){ echo $currency; }else if($position != "Symbol Before amount" && $position != "Space between Before amount and Symbol" && $position !="Symbol After amount"){ echo ' '.$currency; } ?>
					 + 
					 <?php if($position == 'Symbol Before amount'){ echo $currency; }else if($position == 'Space between Before amount and Symbol'){ echo $currency.' '; } ?>
					 <span id="feture_price"><?php if($fprice !=""){ echo $fprice ; }else{ echo "0"; }?></span>
					  <?php if($position == 'Symbol After amount'){ echo $currency; }else if($position != "Symbol Before amount" && $position != "Space between Before amount and Symbol" && $position !="Symbol After amount"){ echo ' '.$currency; } ?>
					 = 
					 <?php if($position == 'Symbol Before amount'){ echo $currency; }else if($position == 'Space between Before amount and Symbol'){ echo $currency.' '; } ?>
					 <span id="result_price"><?php if($total_price != ""){ echo $total_price; }else if($catid != ""){  echo $catprice->term_price; }else{ echo "0";} ?></span>
					  <?php if($position == 'Symbol After amount'){ echo $currency; }else if($position != "Symbol Before amount" && $position != "Space between Before amount and Symbol" && $position !="Symbol After amount"){ echo ' '.$currency; } ?>
					<?php if(isset($_REQUEST['backandedit'])): ?>
						<input type="hidden" name="total_price" id="total_price" value="<?php if($total_price != ""){ echo $total_price; }else if($catid != ""){  echo $catprice->term_price; }else{ echo "0";} ?>"/>
					<?php endif; ?>    
					</div>
					<span class="message_note"> </span>
					<span id="category_span" class="message_error2"></span>
				</div>
				 <?php if(get_option('is_allow_coupon_code')){?>
				 <div class="form_row clearfix"><h5 class="form_title"><?php echo COUPON_CODE_TITLE_TEXT;?></h5></div>
				  <div class="form_row clearfix">
					<label><?php echo PRO_ADD_COUPON_TEXT;?> </label>
					<input type="text" name="job_add_coupon" id="job_add_coupon" class="textfield" value="<?php echo esc_attr(stripslashes($job_add_coupon)); ?>" />
					 <span class="message_note"><?php echo COUPON_NOTE_TEXT; ?></span>				
				 </div>
				 <?php }?>
				 <?php }?>
             <?php }?>
			 <script type="text/javascript">
			 function show_value_hide(val)
			 {
			 	document.getElementById('property_submit_price_id').innerHTML = document.getElementById('span_'+val).innerHTML;
			 }
			 </script>
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
		
		  <?php $pcd = explode(',',get_option('ptthemes_captcha_dislay'));
		  include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		  if((in_array('Post a Job page',$pcd) || in_array('Both',$pcd)) && is_plugin_active('wp-recaptcha/wp-recaptcha.php')){
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
			     <input type="submit" name="Update" value="<?php _e('Preview This Job Post');?>" class="normal_button" />
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
$extra_field_sql = mysql_query("select * from $custom_post_meta_db_table_name where is_require = '1' and (post_type ='".CUSTOM_POST_TYPE1."' or  post_type ='both') and (show_on_page = 'user_side' or show_on_page = 'both_side') order by sort_order");
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
include_once(TT_MODULES_FOLDER_PATH.'job/submition_validation.php'); 
?>
<div id="sidebar">
	<?php dynamic_sidebar("post-job-sidebar"); ?>
</div>
<?php 
}else{ ?>
<div class="error_msg">
<?php echo IP_BLOCK; ?>
</div>
<?php } 
  }else{ ?>
	<div class="error_msg">
<?php _e('Invalid token','templatic'); ?>
</div>
<?php
 } get_footer();  ?>