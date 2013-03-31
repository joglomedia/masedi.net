<?php
/** 
 * Validate plugin options.
 */ 
function login_radius_validate_options($loginRadiusSettings){
	$loginRadiusSettings['LoginRadius_apikey'] = $loginRadiusSettings['LoginRadius_apikey'];
	$loginRadiusSettings['LoginRadius_secret'] = $loginRadiusSettings['LoginRadius_secret'];
	$loginRadiusSettings['LoginRadius_useapi'] = ((isset($loginRadiusSettings['LoginRadius_useapi']) && in_array($loginRadiusSettings['LoginRadius_useapi'], array('curl', 'fsockopen'))) ? $loginRadiusSettings['LoginRadius_useapi'] : 'curl');
	$loginRadiusSettings['LoginRadius_sendemail'] = ((isset($loginRadiusSettings['LoginRadius_sendemail']) && in_array($loginRadiusSettings['LoginRadius_sendemail'], array('sendemail', 'notsendemail'))) ? $loginRadiusSettings['LoginRadius_sendemail'] : 'sendemail');
	$loginRadiusSettings['LoginRadius_socialavatar'] = ((isset($loginRadiusSettings['LoginRadius_socialavatar']) && in_array($loginRadiusSettings['LoginRadius_socialavatar'], array('socialavatar', 'defaultavatar'))) ? $loginRadiusSettings['LoginRadius_socialavatar'] : 'socialavatar');
	$loginRadiusSettings['LoginRadius_dummyemail'] = ((isset($loginRadiusSettings['LoginRadius_dummyemail']) && in_array($loginRadiusSettings['LoginRadius_dummyemail'], array('notdummyemail', 'dummyemail'))) ? $loginRadiusSettings['LoginRadius_dummyemail'] : 'notdummyemail');
	$loginRadiusSettings['LoginRadius_redirect'] = ((isset($loginRadiusSettings['LoginRadius_redirect']) && in_array($loginRadiusSettings['LoginRadius_redirect'], array('samepage', 'homepage', 'dashboard', 'bp', 'custom'))) ? $loginRadiusSettings['LoginRadius_redirect'] : 'samepage');
	$loginRadiusSettings['LoginRadius_loutRedirect'] = ((isset($loginRadiusSettings['LoginRadius_loutRedirect']) && in_array($loginRadiusSettings['LoginRadius_loutRedirect'], array('homepage', 'custom'))) ? $loginRadiusSettings['LoginRadius_loutRedirect'] : 'homepage');
	$loginRadiusSettings['LoginRadius_loginformPosition'] = ((isset($loginRadiusSettings['LoginRadius_loginformPosition']) && in_array($loginRadiusSettings['LoginRadius_loginformPosition'], array('embed', 'beside'))) ? $loginRadiusSettings['LoginRadius_loginformPosition'] : 'embed');
	$loginRadiusSettings['LoginRadius_regformPosition'] = ((isset($loginRadiusSettings['LoginRadius_regformPosition']) && in_array($loginRadiusSettings['LoginRadius_regformPosition'], array('embed', 'beside'))) ? $loginRadiusSettings['LoginRadius_regformPosition'] : 'embed');
	$loginRadiusSettings['LoginRadius_commentform'] = ((isset($loginRadiusSettings['LoginRadius_commentform']) && in_array($loginRadiusSettings['LoginRadius_commentform'], array('old', 'new'))) ? $loginRadiusSettings['LoginRadius_commentform'] : 'new');
	$loginRadiusSettings['LoginRadius_title'] = $loginRadiusSettings['LoginRadius_title'];
	$loginRadiusSettings['msg_email'] = $loginRadiusSettings['msg_email'];
	$loginRadiusSettings['msg_existemail'] = $loginRadiusSettings['msg_existemail'];
	$loginRadiusSettings['LoginRadius_sharingTitle'] = $loginRadiusSettings['LoginRadius_sharingTitle'];
	$loginRadiusSettings['LoginRadius_counterTitle'] = $loginRadiusSettings['LoginRadius_counterTitle'];
	foreach(array('LoginRadius_loginform', 'LoginRadius_regform', 'LoginRadius_socialLinking', 'LoginRadius_autoapprove', 'LoginRadius_commentEnable', 'LoginRadius_shareEnable', 'LoginRadius_counterEnable', 'LoginRadius_sharetop', 'LoginRadius_sharebottom', 'LoginRadius_sharehome', 'LoginRadius_sharepost', 'LoginRadius_sharepage','LoginRadius_sharearchive', 'LoginRadius_sharefeed', 'LoginRadius_shareexcerpt', 'LoginRadius_countertop', 'LoginRadius_counterbottom', 'LoginRadius_counterhome', 'LoginRadius_counterpost', 'LoginRadius_counterpage','LoginRadius_counterarchive', 'LoginRadius_counterfeed', 'LoginRadius_counterexcerpt') as $val){
		//if(isset($loginRadiusSettings[$val]) && $loginRadiusSettings[$val]){
		//	$val = (isset($loginRadiusSettings[$val]) &&  $loginRadiusSettings[$val] == '1') ? '1' : '0';
		//}
	}
	$loginRadiusSettings['custom_redirect'] = $loginRadiusSettings['custom_redirect'];
	$loginRadiusSettings['custom_loutRedirect'] = $loginRadiusSettings['custom_loutRedirect'];
	return $loginRadiusSettings;
}

/** 
 * Display options page.
 */ 
function login_radius_option_page(){
	$loginRadiusSettings = get_option('LoginRadius_settings');
	?>
  	<script src="http://code.jquery.com/ui/1.10.0/jquery-ui.js"></script>
	<script type="text/javascript">
	if(typeof String.prototype.trim !== 'function'){
		String.prototype.trim = function(){
			return this.replace(/^\s+|\s+$/g, '');
		}
	}
	function loginRadiusDetectApi(){
		jQuery('#login_radius_response').html('<img width="20" height="20" src="<?php echo plugins_url('images/loading_icon.gif', __FILE__); ?>" style="float:left;margin-right: 5px;" /><span style="color:blue; width:auto"><?php _e('Please wait. This may take a few minutes', 'LoginRadius') ?>...</span>');
		jQuery.ajax({
		  type: 'POST',
		  url: '<?php echo get_admin_url() ?>admin-ajax.php',
		  data: {  
			  action: 'login_radius_api_connection'
		  },
		  success: function(data, textStatus, XMLHttpRequest){
			if(data == 'curl'){
				jQuery('#login_radius_response').html('<span style="color:green; width:auto"><?php _e('Detected CURL. Please save changes', 'LoginRadius'); ?></span>');
				jQuery('#login_radius_curl').attr('checked', 'checked');
			}else if(data == 'fsock'){
				jQuery('#login_radius_response').html('<span style="color:green; width:auto"><?php _e('Detected FSOCKOPEN. Please save changes', 'LoginRadius') ?></span>');
				jQuery('#login_radius_fsock').attr('checked', 'checked');
			}else if(data == 'lrerror'){
				jQuery('#login_radius_response').html('<span style="color:red; width:auto"><?php _e('Please check your php.ini settings to enable CURL or FSOCKOPEN', 'LoginRadius')  ?></span>');
			}else if(data == 'connection error'){
				jQuery('#login_radius_response').html('<span style="color:red; width:auto"><?php _e('Problem in communicating LoginRadius API. Please check if one of the API Connection method mentioned above is working.', 'LoginRadius') ?></span>');
			}else if(data == 'service connection timeout' || data == 'timeout'){
				jQuery('#login_radius_response').html('<span style="color:red; width:auto"><?php _e('Uh oh, looks like something went wrong. Try again in a sec!', 'LoginRadius') ?></span>');
			}
		  }
		});
	}
	function loginRadiusVerifyKeys(){
		jQuery('#login_radius_api_response').html('<img width="20" height="20" src="<?php echo plugins_url('images/loading_icon.gif', __FILE__); ?>" style="float:left;margin-right: 5px;" /><span style="color:blue; width:auto"><?php _e('Please wait. This may take a few minutes', 'LoginRadius') ?>...</span>');
		jQuery.ajax({
		  type: 'POST',
		  url: '<?php echo get_admin_url() ?>admin-ajax.php',
		  data: {  
			  action: 'login_radius_verify_keys',
			  key: jQuery('#login_radius_api_key').val().trim(),
			  secret: jQuery('#login_radius_api_secret').val().trim()
		  },
		  success: function(data, textStatus, XMLHttpRequest){
			if(data == 'key'){
				jQuery('#login_radius_api_response').html('<span style="color:red; width:auto"><?php _e('Your API Key is invalid. Please paste the correct API Key from your LoginRadius Account.', 'LoginRadius') ?></span>');
			}else if(data == 'secret'){
				jQuery('#login_radius_api_response').html('<span style="color:red; width:auto"><?php _e('Your API Secret is invalid. Please paste the correct API Secret from your LoginRadius Account', 'LoginRadius') ?></span>');
			}else if(data == 'working'){
				jQuery('#login_radius_api_response').html('<span style="color:green; width:auto"><?php _e('Your API Key and Secret are valid. Please save the changes.', 'LoginRadius') ?></span>');
			}
		  }
		});
	}
	jQuery(function(){
		jQuery('#login_radius_detect_api').click(function(){
			loginRadiusDetectApi();
		});
		jQuery('#login_radius_validate_keys').click(function(){
			loginRadiusVerifyKeys();
		});
	});
	</script>
	<div class="wrapper">
	<form action="options.php" method="post">
		<?php settings_fields('LoginRadius_setting_options'); ?>
		<div class="header_div">
		<h2>LoginRadius <?php _e('Social Plugin Settings', 'LoginRadius') ?></h2>
		<div id="loginRadiusError" style="background-color: #FFFFE0; border:1px solid #E6DB55; padding:5px; margin-bottom:5px; width: 1050px;">
			 <?php _e('Please clear your browser cache, if you have trouble loading the plugin interface. For more information', 'LoginRadius') ?> <a target="_blank" href="http://www.wikihow.com/Clear-Your-Browser's-Cache" >  <?php _e('click here', 'LoginRadius') ?> </a>.
		</div>
		<fieldset style="margin-right:13px; background-color:#EAF7FF; border-color:rgb(195, 239, 250); padding-bottom:10px; width:751px">
		<h4 style="color:#000"><strong><?php _e('Thank you for installing the LoginRadius Social Plugin!', 'LoginRadius') ?></strong></h4>
		<p><?php _e('To activate the plugin, you will need to first configure it (manage your desired social networks, etc.) from your LoginRadius account. If you do not have an account, click', 'LoginRadius') ?> <a target="_blank" href="http://www.loginradius.com/"><?php _e('here', 'LoginRadius') ?></a> <?php _e('and create one for FREE!', 'LoginRadius'); ?></p>
		<p>
		<?php _e('We also offer Social Plugins for ', 'LoginRadius') ?><a href="http://www.loginradius.com/addons/joomla" target="_blank">Joomla</a>, <a href="http://www.loginradius.com/addons/drupal" target="_blank">Drupal</a>, <a href="http://www.loginradius.com/addons/vbulletin" target="_blank">vBulletin</a>, <a href="http://www.loginradius.com/addons/vanilla" target="_blank">VanillaForum</a>, <a href="http://www.loginradius.com/addons/magento" target="_blank">Magento</a>, <a href="http://www.loginradius.com/addons/oscommerce" target="_blank">OSCommerce</a>, <a href="http://www.loginradius.com/addons/prestashop" target="_blank">PrestaShop</a>, <a href="http://www.loginradius.com/addons/Xcart" target="_blank">X-Cart</a>, <a href="http://www.loginradius.com/addons/zencart" target="_blank">Zen-Cart</a>, <a href="http://www.loginradius.com/addons/dotnetnuke" target="_blank">DotNetNuke</a> <?php _e('and', 'LoginRadius') ?> <a href="http://www.loginradius.com/addons/blogengine" target="_blank">BlogEngine</a>!
		</p>
		<a style="text-decoration:none;" href="https://www.loginradius.com/" target="_blank">
			<input style="margin-top:10px" class="button" type="button" value="<?php _e('Set up my FREE account!', 'LoginRadius'); ?>" />
		</a>
		<a class="loginRadiusHow" target="_blank" href="http://support.loginradius.com/customer/portal/articles/593954">(<?php _e('How to set up an account', 'LoginRadius') ?>?)</a>
		</fieldset>
		
		<fieldset style="width:25%; background-color: rgb(231, 255, 224); border: 1px solid rgb(191, 231, 176); padding-bottom:6px; height:173px; width:255px">
		<h4 style="border-bottom:#d7d7d7 1px solid;"><strong><?php _e('Get Updates', 'LoginRadius') ?></strong></h4>
		<p><?php _e('To receive updates on new features, future releases, etc, please connect with us via Facebook and Twitter', 'LoginRadius') ?>-</p>
		<div>
			<div style="float:left">
				<iframe rel="tooltip" scrolling="no" frameborder="0" allowtransparency="true" style="border: none; overflow: hidden; width: 46px;
							height: 61px; margin-right:10px" src="//www.facebook.com/plugins/like.php?app_id=194112853990900&amp;href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FLoginRadius%2F119745918110130&amp;send=false&amp;layout=box_count&amp;width=90&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=90" data-original-title="Like us on Facebook"></iframe>
				</div>
		<div>
		<div class="twitter_box"><span id="followers"></span></div>
		<a href="https://twitter.com/LoginRadius" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false"></a>
		</div>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

		</div>
		</fieldset>
		
		<fieldset class="help_div" style="margin-right:13px; height:145px; width:751px">
		<h4 style="border-bottom:#d7d7d7 1px solid;"><strong><?php _e('Help & Documentations', 'LoginRadius') ?></strong></h4>
		<ul style="float:left; margin-right:43px">
			<li><a target="_blank" href="http://support.loginradius.com/customer/portal/articles/971398-wordpress-plugin-installation-configuration-and-troubleshooting"><?php _e('Plugin Installation, Configuration and Troubleshooting', 'LoginRadius') ?></a></li>
			<li><a target="_blank" href="http://support.loginradius.com/customer/portal/articles/677100-how-to-get-loginradius-api-key-and-secret"><?php _e('How to get LoginRadius API Key & Secret', 'LoginRadius') ?></a></li>
			<li><a target="_blank" href="http://support.loginradius.com/customer/portal/articles/687407"><?php _e('WP Multisite Feature', 'LoginRadius') ?></a></li>
		</ul>
		<ul style="float:left; margin-right:43px">
			<li><a target="_blank" href="http://support.loginradius.com/customer/portal/topics/272884-wordpress-plugin/articles"><?php _e('Support Documentations', 'LoginRadius') ?></a></li>
			<li><a target="_blank" href="http://community.loginradius.com/"><?php _e('Discussion Forum', 'LoginRadius') ?></a></li>
			<li><a target="_blank" href="http://www.loginradius.com/loginradius/about"><?php _e('About LoginRadius', 'LoginRadius') ?></a></li>
		</ul>
		<ul style="float:left">
			<li><a target="_blank" href="http://www.loginradius.com/product/sociallogin"><?php _e('LoginRadius Products', 'LoginRadius') ?></a></li>
			<li><a target="_blank" href="http://www.loginradius.com/addons"><?php _e('Social Plugins', 'LoginRadius') ?></a></li>
			<li><a target="_blank" href="http://www.loginradius.com/sdks/loginradiussdk"><?php _e('Social SDKs', 'LoginRadius') ?></a></li>
		</ul>
		</fieldset>
		
		<fieldset style="margin-right:5px; background-color: rgb(231, 255, 224); border: 1px solid rgb(191, 231, 176); width:255px">
		<h4 style="border-bottom:#d7d7d7 1px solid;"><strong><?php _e('Support Us', 'LoginRadius') ?></strong></h4>
		<p>
		<?php _e('If you liked our FREE open-source plugin, please send your feedback/testimonial to ', 'LoginRadius') ?><a href="mailto:feedback@loginradius.com">feedback@loginradius.com</a> !
		<?php _e('Please help us to ', 'LoginRadius') ?><a target="_blank" href="http://docs.loginradius.com/wordpress.htm"><?php _e('translate', 'LoginRadius') ?> </a><?php _e('the plugin content in your language.', 'LoginRadius') ?>
		</p>
		</fieldset>
		
		</div>
		<div class="clr"></div>
		<div class="metabox-holder columns-2" id="post-body">
				<div class="menu_div" id="tabs">
					<h2 class="nav-tab-wrapper" style="height:36px">
					<ul>
						<li style="margin-left:9px"><a style="margin:0" class="nav-tab" href="#tabs-1"><?php _e('API Settings', 'LoginRadius') ?></a></li>
						<li><a style="margin:0" class="nav-tab" href="#tabs-2"><?php _e('Social Login', 'LoginRadius') ?></a></li>
						<li><a style="margin:0" class="nav-tab" href="#tabs-3"><?php _e('Social Commenting', 'LoginRadius') ?></a></li>
						<li><a style="margin:0" class="nav-tab" href="#tabs-4"><?php _e('Social Sharing', 'LoginRadius') ?></a></li>
						<li><a style="margin:0" class="nav-tab" href="#tabs-5"><?php _e('Social Counter', 'LoginRadius') ?></a></li>
						<li style="float:right; margin-right:8px"><a style="margin:0" class="nav-tab" href="#tabs-6"><?php _e('Help', 'LoginRadius') ?></a></li>
					</ul>
					</h2>
				
					<div class="menu_containt_div" id="tabs-1">
						<div class="stuffbox">
							<h3><label><?php _e('What API Connection Method do you prefer to use to enable API communication?', 'LoginRadius');?></label></h3>
							<div class="inside">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
									<?php   
									$curl = "";
									$fsockopen = "";
									if($loginRadiusSettings["LoginRadius_useapi"] == "curl") $curl = "checked='checked'";
									elseif($loginRadiusSettings["LoginRadius_useapi"] == "fsockopen") $fsockopen = "checked='checked'";
									else $curl = "checked='checked'";?>
									<tr>
									<td><input name="LoginRadius_settings[LoginRadius_useapi]" type="radio" id="login_radius_curl" <?php echo $curl;?> value="curl" /><?php _e("Use CURL", 'LoginRadius'); ?><br />
										<span><?php _e('This is the recommended API connection method, but sometimes this is disabled on hosting server', 'LoginRadius') ?></span>									</td>
									</tr>
								<tr>	
									<td>
									<input name="LoginRadius_settings[LoginRadius_useapi]" type="radio" id="login_radius_fsock" <?php echo $fsockopen;?> value="fsockopen" /><?php _e("Use FSOCKOPEN", 'LoginRadius'); ?><br />
									<span><?php _e('Choose this option if cURL is disabled on your hosting server', 'LoginRadius') ?></span>
									<input type="button" style="font-weight:bold; float:left; margin-top:10px;" class="button" id="login_radius_detect_api" value="<?php _e('Auto-detect Connection Method', 'LoginRadius') ?>" />
									<div id="login_radius_response" style="float:left; margin:13px 0 0 10px; width:400px"></div>	
									</td>
								</tr>
							</table>
							</div>
						</div>
						<div class="stuffbox">
						<h3><label><?php _e('To activate the plugin, insert the LoginRadius API Key & Secret', 'LoginRadius');?>
						<a style="text-decoration:none" target="_blank" href="http://support.loginradius.com/customer/portal/articles/677100-how-to-get-loginradius-api-key-and-secret"><?php _e('(How to get it?)', 'LoginRadius') ?></a>
						</label></h3>
						<div class="inside">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
							<tr>
							<td><label style="float:left; width:100px; margin-top:2px; font-weight:bold"><?php _e('API Key', 'LoginRadius');?></label>
							<input type="text" id="login_radius_api_key" name="LoginRadius_settings[LoginRadius_apikey]" value="<?php echo (isset($loginRadiusSettings['LoginRadius_apikey']) ? htmlspecialchars ($loginRadiusSettings['LoginRadius_apikey']) : ''); ?>" autofill='off' autocomplete='off'  />										
							</td>
							</tr>
							<tr>
							<td><label style="float:left; width:100px; margin-top:2px; font-weight:bold"><?php _e('API Secret', 'LoginRadius');?></label>
							<input type="text" id="login_radius_api_secret" name="LoginRadius_settings[LoginRadius_secret]" value="<?php echo (isset($loginRadiusSettings['LoginRadius_secret']) ? htmlspecialchars ($loginRadiusSettings['LoginRadius_secret']) : ''); ?>" autofill='off' autocomplete='off'  />
							<div style="clear:both"></div>
							<input style="font-weight:bold; float:left; margin-top:10px" class="button" type="button" id="login_radius_validate_keys" value="<?php _e('Verify API Settings', 'LoginRadius') ?>" />
							<div id="login_radius_api_response" style="float:left; margin:13px 0 0 10px; width:400px"></div>
							</td>
							</tr>
							</table>
						</div>
						</div>
					</div>
	
					<div class="menu_containt_div" id="tabs-2">
						<div class="stuffbox">
						<h3><label><?php _e('Social Login Interface Settings', 'LoginRadius'); ?></label></h3>
						<div class="inside">
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
							<tr>
							<td width="35%"><div class="loginRadiusQuestion"><?php _e('What text should be displayed above the Social Login interface? Leave blank if you do not want any text to be displayed', 'LoginRadius'); ?></div>
							<input type="text" name="LoginRadius_settings[LoginRadius_title]" size="60" value="<?php if($loginRadiusSettings['LoginRadius_title']){ echo htmlspecialchars ($loginRadiusSettings['LoginRadius_title']); }else { _e('Login with Social ID', 'LoginRadius');} ?>" />
							<div class="loginRadiusBorder"></div>
							</td>
							</tr>
							<tr>
							<tr>
							<td><div class="loginRadiusQuestion"><?php _e("Do you want to show the Social Login interface on your WordPress login page?", 'LoginRadius'); ?></div>
							<div class="loginRadiusYesRadio">
							<input type="radio" id="login_radius_show_on_login" name="LoginRadius_settings[LoginRadius_loginform]" value="1" <?php echo isset($loginRadiusSettings['LoginRadius_loginform']) && $loginRadiusSettings['LoginRadius_loginform'] == 1? "checked" : ""; ?>/> <label><?php _e ('Yes', 'LoginRadius'); ?></label>
							</div>
							<div>
							<input type="radio" id="login_radius_show_on_login" name="LoginRadius_settings[LoginRadius_loginform]" value="0" <?php echo isset($loginRadiusSettings['LoginRadius_loginform']) && $loginRadiusSettings['LoginRadius_loginform'] == 0? "checked" : ""; ?>/> <label><?php _e ('No', 'LoginRadius'); ?></label>
							</div>
							<div class="loginRadiusBorder"></div>
							</td>
							</tr>
							<tr>
							<td>
							<div class="loginRadiusQuestion">
							<?php _e ('Do you want to show Social Login interface on your WordPress registration page?', 'LoginRadius'); ?>
							</div>
							<div class="loginRadiusYesRadio">
							<input type="radio" id="login_radius_show_on_register" name="LoginRadius_settings[LoginRadius_regform]" value="1" <?php echo isset($loginRadiusSettings['LoginRadius_regform']) && $loginRadiusSettings['LoginRadius_regform'] == 1 ? "checked" : ""; ?>/><?php _e ('Yes', 'LoginRadius'); ?> 
							</div>
							<input type="radio" id="login_radius_show_on_register" name="LoginRadius_settings[LoginRadius_regform]" value="0" <?php echo isset($loginRadiusSettings['LoginRadius_regform']) && $loginRadiusSettings['LoginRadius_regform'] == 0 ? "checked" : ""; ?>/><?php _e ('No', 'LoginRadius'); ?>
							
							<div class="loginRadiusBorder"></div>
							</td>
							</tr>
							<tr>
							<td>
							<div class="loginRadiusQuestion">
							<?php _e ('If Yes, how do you want the Social Login interface to be shown on your wordpress registration page?', 'LoginRadius'); ?>
							</div>
							<input type="radio" name="LoginRadius_settings[LoginRadius_regformPosition]" value="embed" <?php echo (isset($loginRadiusSettings['LoginRadius_regform']) && $loginRadiusSettings['LoginRadius_regform']== 1 && isset($loginRadiusSettings['LoginRadius_regformPosition']) && $loginRadiusSettings['LoginRadius_regformPosition'] == "embed")? "checked" : ""; ?>/> <?php _e ('Show it below the registration form', 'LoginRadius'); ?><br />
							<input type="radio" name="LoginRadius_settings[LoginRadius_regformPosition]" value="beside" <?php echo (isset($loginRadiusSettings['LoginRadius_regform']) && $loginRadiusSettings['LoginRadius_regform']== 1 && isset($loginRadiusSettings['LoginRadius_regformPosition']) && $loginRadiusSettings['LoginRadius_regformPosition'] == "beside")? "checked" : "" ?>/> <?php _e ('Show it beside the registration form', 'LoginRadius'); ?> 
							</td>
							</tr>
							</table>
						</div>
						</div>
							
						<div class="stuffbox">
						<h3><label><?php _e('User Email Settings', 'LoginRadius'); ?></label></h3>
						<div class="inside">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
						<tr>
						<td>
						<div class="loginRadiusQuestion">
						<?php _e('Do you want to send emails to users with their username and password post-registration?', 'LoginRadius'); ?>
						</div>
						<?php
						$sendemail = "";
						$notsendemail = "";
						if($loginRadiusSettings["LoginRadius_sendemail"] == "sendemail") $sendemail = "checked='checked'";
						elseif($loginRadiusSettings["LoginRadius_sendemail"] == "notsendemail") $notsendemail = "checked='checked'";
						else $sendemail = "checked='checked'";
						?>
						<?php _e("YES, send an email to users after registration", 'LoginRadius'); ?> <input name="LoginRadius_settings[LoginRadius_sendemail]" type="radio"  value="sendemail" <?php echo $sendemail;?> /><br />
						<?php _e("NO, do not send email to users after registration", 'LoginRadius'); ?> <input name="LoginRadius_settings[LoginRadius_sendemail]" type="radio" value="notsendemail" <?php echo $notsendemail;?> />
						<div class="loginRadiusBorder"></div>
						</td>
						</tr>
						<tr>
						<td>
						<div class="loginRadiusQuestion">
						<?php _e("A few ID Providers do not supply users' e-mail IDs as part of the user profile data they provide. Do you want to prompt users to provide their email IDs before completing registration process if it is not provided by the ID Provider?", 'LoginRadius'); ?>
						</div>
						<?php
						$dummyemail = "";
						$notdummyemail = "";
						if($loginRadiusSettings["LoginRadius_dummyemail"] == "notdummyemail") $notdummyemail = "checked='checked'";
						elseif($loginRadiusSettings["LoginRadius_dummyemail"] == "dummyemail") $dummyemail = "checked='checked'";
						else $dummyemail = "checked='checked'";
						?>
						<?php _e("YES, ask users to enter their email address in a pop-up", 'LoginRadius'); ?> <input name="LoginRadius_settings[LoginRadius_dummyemail]" type="radio" value"notdummyemail" <?php echo $notdummyemail;?> onchange = "if(this.checked){ document.getElementById('loginRadiusPopupMessage').style.display = 'table-row'; document.getElementById('loginRadiusPopupErrorMessage').style.display = 'table-row';}" /><br />
						<?php _e("NO, just auto-generate random email IDs for users", 'LoginRadius'); ?> <input name="LoginRadius_settings[LoginRadius_dummyemail]" type="radio" value="dummyemail" <?php echo $dummyemail;?> onchange = "if(this.checked){ document.getElementById('loginRadiusPopupMessage').style.display = 'none'; document.getElementById('loginRadiusPopupErrorMessage').style.display = 'none';}" />
						<div class="loginRadiusBorder"></div>
						</td>
						</tr>
						<tr id="loginRadiusPopupMessage">
						<td>
						<div class="loginRadiusQuestion">
						<?php
						_e('Please enter the message to be displayed to the user in the pop-up asking for their email address', 'LoginRadius'); ?>
						</div>
						<input style="width: 45%;" type="text" name="LoginRadius_settings[msg_email]"  value="<?php if($loginRadiusSettings['msg_email']){ echo htmlspecialchars ($loginRadiusSettings['msg_email']); }else { _e('Unfortunately, the ID Provider did not provided your email address. Please enter your email to proceed', 'LoginRadius'); } ?>" />
						<div class="loginRadiusBorder"></div>
						</td>
						</tr>
						<tr id="loginRadiusPopupErrorMessage">
						<td>
						<div class="loginRadiusQuestion">
						<?php _e('Please enter the message to be shown to the user in case of an invalid or already registered email', 'LoginRadius'); ?>
						</div>
						<input style="width: 45%;" type="text" name="LoginRadius_settings[msg_existemail]"  value="<?php if($loginRadiusSettings['msg_existemail']){ echo htmlspecialchars ($loginRadiusSettings['msg_existemail']); }else { _e('The email you have entered is either already registered or invalid. Please enter a valid email address.', 'LoginRadius');} ?>" />
						</td>
						</tr>
						</table>
						</div>
						</div>
						
						<div class="stuffbox">
						<h3><label><?php _e('Redirection Settings', 'LoginRadius');?></label></h3>
						<div class="inside">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
						<tr>
						<td>
						<div class="loginRadiusQuestion">
						<?php _e('Where do you want to redirect your users after successfully logging in?', 'LoginRadius');?>
						</div>
						<?php 
						$samepage = "";
						$homepage = "";
						$dashboard = "";
						$custom = "";
						$bp = "";
						if ($loginRadiusSettings["LoginRadius_redirect"] == "samepage") $samepage = "checked='checked'";
						elseif($loginRadiusSettings["LoginRadius_redirect"] == "homepage") $homepage = "checked='checked'";
						elseif($loginRadiusSettings["LoginRadius_redirect"] == "dashboard") $dashboard = "checked='checked'";
						elseif($loginRadiusSettings["LoginRadius_redirect"] == "bp") $bp = "checked='checked'";
						elseif($loginRadiusSettings["LoginRadius_redirect"] == "custom") $custom = "checked='checked'";
						else $samepage = "checked='checked'";
						?>
						<input type="radio" name="LoginRadius_settings[LoginRadius_redirect]" onclick="if(this.checked){ document.getElementById('loginRadiusCustomLoginUrl').style.display = 'none' }" value="samepage" <?php echo $samepage;?>/> <?php _e ('Redirect to the same page where the user logged in', 'LoginRadius');?> <strong>(<?php _e ('Default', 'LoginRadius') ?>)</strong><br />
						<input type="radio" name="LoginRadius_settings[LoginRadius_redirect]" onclick="if(this.checked){ document.getElementById('loginRadiusCustomLoginUrl').style.display = 'none' }" value="homepage" <?php echo $homepage;?> /> <?php _e ('Redirect to homepage of your WP site', 'LoginRadius'); ?> 
						<br />
						<input type="radio" name="LoginRadius_settings[LoginRadius_redirect]" onclick="if(this.checked){ document.getElementById('loginRadiusCustomLoginUrl').style.display = 'none' }" value="dashboard" <?php echo $dashboard;?>/> <?php _e ('Redirect to account dashboard', 'LoginRadius'); ?>
						<br />
						<?php
						if(login_radius_is_bp_active()){
							?>
							<input type="radio" name="LoginRadius_settings[LoginRadius_redirect]" value="bp" onclick="if(this.checked){ document.getElementById('loginRadiusCustomLoginUrl').style.display = 'none' }" <?php echo $bp;?>/> <?php _e ('Redirect to Buddypress profile page', 'LoginRadius');?>
							<br />
							<?php
						}
						?>
						<input type="radio" name="LoginRadius_settings[LoginRadius_redirect]" value="custom" <?php echo $custom;?> onclick="if(this.checked){ document.getElementById('loginRadiusCustomLoginUrl').style.display = 'block' }" /> <?php _e ('Redirect to Custom URL:', 'LoginRadius');?>
						<br />
						<input type="text" id="loginRadiusCustomLoginUrl" name="LoginRadius_settings[custom_redirect]" size="60" value="<?php if($loginRadiusSettings["LoginRadius_redirect"]=='custom'){echo htmlspecialchars($loginRadiusSettings["custom_redirect"]);} ?>" />
						<div class="loginRadiusBorder"></div>
						</td>
						</tr>
						<tr>
						<td>
						<div class="loginRadiusQuestion">
						<?php _e ('Where do you want to redirect your users after successfully logging out?', 'LoginRadius') ?>
						</div>
						<strong><?php _e("Note: Logout function works only when clicking 'logout' in the social login widget area. In all other cases, WordPress's default logout function will be applied.", 'LoginRadius'); ?></strong>
						<br />
						<?php      
						$homepage = "";
						$custom = ""; 
						if($loginRadiusSettings["LoginRadius_loutRedirect"] == "custom" && $loginRadiusSettings["custom_loutRedirect"] != ""){
							$custom = "checked='checked'";
						}else{
							$homepage = "checked='checked'";
						}
						?>
						<input type="radio" name="LoginRadius_settings[LoginRadius_loutRedirect]" value="homepage" <?php echo $homepage;?> onclick="if(this.checked){ document.getElementById('loginRadiusCustomLogoutUrl').style.display = 'none' }" /> <?php _e ('Redirect to the homepage', 'LoginRadius');?> <strong>(<?php _e ('Default', 'LoginRadius') ?>)</strong>
						<br /> 
						<input type="radio" name="LoginRadius_settings[LoginRadius_loutRedirect]" onclick="if(this.checked){ document.getElementById('loginRadiusCustomLogoutUrl').style.display = 'block' }" value="custom" <?php echo $custom;?>/> <?php _e ('Redirect to Custom URL:', 'LoginRadius');?> 
						<br /> 
						<input type="text" id="loginRadiusCustomLogoutUrl" name="LoginRadius_settings[custom_loutRedirect]" size="60" value="<?php if($loginRadiusSettings["LoginRadius_loutRedirect"]=='custom'){echo htmlspecialchars($loginRadiusSettings["custom_loutRedirect"]);}else{} ?>" />
						</td>
						</tr>
						</table>
						</div>
						</div>
						
						<div class="stuffbox">
						<h3><label><?php _e('User Settings', 'LoginRadius');?></label></h3>
						<div class="inside">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
						<tr>
						<td>
						<div class="loginRadiusQuestion">
						<?php _e('Do you want to allow new users to register through Social Login?', 'LoginRadius'); ?>
						</div>
						<input onchange="document.getElementById('login_radius_register_disable').style.display = 'none';" type="radio" name="LoginRadius_settings[LoginRadius_disableRegistration]" value="0" <?php echo((isset($loginRadiusSettings['LoginRadius_disableRegistration']) && $loginRadiusSettings['LoginRadius_disableRegistration'] == 0) || !isset($loginRadiusSettings['LoginRadius_disableRegistration']))? "checked" : ""; ?>/> <?php _e('YES, allow new users to register through Social Login', 'LoginRadius'); ?><br />
						<input onchange="document.getElementById('login_radius_register_disable').style.display = 'block';" type="radio" name="LoginRadius_settings[LoginRadius_disableRegistration]" value="1" <?php echo(isset($loginRadiusSettings['LoginRadius_disableRegistration']) && $loginRadiusSettings['LoginRadius_disableRegistration'] == 1)? "checked" : ""; ?>/> <?php _e('NO, do not allow new users to register through Social Login', 'LoginRadius'); ?><br />
						<span id="login_radius_register_disable" style="color:red; display:none; width:auto"><?php _e ('New users will not be able to login through Social Login', 'LoginRadius'); ?></span>
						<div class="loginRadiusBorder"></div>
						</td>
						</tr>
						<tr>
						<td>
						<div class="loginRadiusQuestion">
						<?php _e ('Do you want to display the social network that the user connected with, in the user list', 'LoginRadius'); ?>?
						</div>
						<input type="radio" name="LoginRadius_settings[LoginRadius_noProvider]" value="0" <?php echo((isset($loginRadiusSettings['LoginRadius_noProvider']) && $loginRadiusSettings['LoginRadius_noProvider'] == 0) || !isset($loginRadiusSettings['LoginRadius_noProvider']))? "checked" : ""; ?>/> <?php _e ('YES, display the social network that the user connected with, in the user list', 'LoginRadius'); ?><br />
						<input type="radio" name="LoginRadius_settings[LoginRadius_noProvider]" value="1" <?php checked('1', @$loginRadiusSettings['LoginRadius_noProvider']); ?>/> <?php _e ('NO, do not display the social network that the user connected with, in the user list', 'LoginRadius'); ?> 
						<div class="loginRadiusBorder"></div>
						</td>
						</tr>
						<tr>
						<td>
						<div class="loginRadiusQuestion">
						<?php _e("Do you want to automatically link your existing users' accounts to their social accounts if their WP account email address matches the email address associated with their social account?", 'LoginRadius'); ?>
						</div>
						<input type="radio" name="LoginRadius_settings[LoginRadius_socialLinking]" value="1" <?php echo((isset($loginRadiusSettings['LoginRadius_socialLinking']) && $loginRadiusSettings['LoginRadius_socialLinking'] == 1) || !isset($loginRadiusSettings['LoginRadius_socialLinking']))? "checked" : ""; ?>/> <?php _e ('YES, automatically link social accounts to WP accounts', 'LoginRadius'); ?> 
						<br />
						<input type="radio" name="LoginRadius_settings[LoginRadius_socialLinking]" value="0" <?php checked('0', @$loginRadiusSettings['LoginRadius_socialLinking']); ?>/> <?php _e ('NO, I want my existing users to continue using the native WP login', 'LoginRadius'); ?> 
						<div class="loginRadiusBorder"></div>
						</td>
						</tr>
						<?php
							if(is_multisite() && is_main_site()){
								?>
								<tr>
								<td>
								<div class="loginRadiusQuestion">
								<?php _e('Do you want to apply the same changes when you update plugin settings in the main blog of multisite network?', 'LoginRadius'); ?></div>
								<input type="radio" name="LoginRadius_settings[multisite_config]" value="1" <?php checked('1', @$loginRadiusSettings['multisite_config']); ?>/> <?php _e ('YES, apply the same changes to plugin settings of each blog in the multisite network when I update plugin settings.', 'LoginRadius'); ?> <br />
								<input type="radio" name="LoginRadius_settings[multisite_config]" value="0" <?php echo((isset($loginRadiusSettings['multisite_config']) && $loginRadiusSettings['multisite_config'] == 0) || !isset($loginRadiusSettings['multisite_config']))? "checked" : ""; ?>/> <?php _e ('NO, do not apply the changes to other blogs when I update plugin settings.', 'LoginRadius'); ?> 
								<div class="loginRadiusBorder"></div>
								</td>
								</tr>
								<?php
							}
						?>
						<tr>
						<td>
						<?php
						$socialavatar = "";
						$defaultavatar = "";
						if($loginRadiusSettings["LoginRadius_socialavatar"] == "socialavatar" ) $socialavatar = "checked='checked'";
						elseif($loginRadiusSettings["LoginRadius_socialavatar"] == "defaultavatar") $defaultavatar = "checked='checked'";
						else $socialavatar = "checked='checked'";
						?>
						<div class="loginRadiusQuestion">
						<?php _e("Do you want to let users use their social profile picture as an avatar on your website?", 'LoginRadius'); ?></div>
						<input name="LoginRadius_settings[LoginRadius_socialavatar]" type="radio"  <?php echo $socialavatar;?> value="socialavatar"/><?php _e("YES, let users use their social profile picture as an avatar", 'LoginRadius'); ?> <br />
						<input name="LoginRadius_settings[LoginRadius_socialavatar]" type="radio" <?php echo $defaultavatar;?> value="defaultavatar" /><?php _e("NO, use default avatars", 'LoginRadius'); ?>
						</td>
						</tr>
						</table>
						</div>
						</div>
					</div>
					
					<div class="menu_containt_div" id="tabs-3">
					<div class="stuffbox">
						<h3><label><?php _e('Social Commenting Settings', 'LoginRadius') ?></label></h3>
						<div class="inside">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
						<tr>
						<td>
						<div class="loginRadiusQuestion">
						<?php _e('Do you want to enable Social Commenting for your website'); ?>?
						</div>
						<div class="loginRadiusYesRadio">
						<input type="radio" name="LoginRadius_settings[LoginRadius_commentEnable]" value="1" <?php echo ((isset($loginRadiusSettings['LoginRadius_commentEnable']) && $loginRadiusSettings['LoginRadius_commentEnable'] == 1) || !isset($loginRadiusSettings['LoginRadius_commentEnable'])) ? 'checked' : '' ?>/> <?php _e ('Yes', 'LoginRadius'); ?>
						</div>
						<input type="radio" name="LoginRadius_settings[LoginRadius_commentEnable]" value="0" <?php checked('0', @$loginRadiusSettings['LoginRadius_commentEnable']); ?>/> <?php _e ('No', 'LoginRadius'); ?>
						<div class="loginRadiusBorder"></div>
						</td>
						</tr>
						<tr>
						<td>
						<div class="loginRadiusQuestion">
						<?php _e('Where do you want to the Social login interface on the commenting form?', 'LoginRadius'); ?>
						</div>
					<select name="LoginRadius_settings[LoginRadius_commentInterfacePosition]">
						<option value="very_top" <?php echo (isset($loginRadiusSettings['LoginRadius_commentInterfacePosition']) && $loginRadiusSettings['LoginRadius_commentInterfacePosition'] == 'very_top') ? 'selected="selected"' : '' ?> ><?php _e('At the very top of the comment form', 'LoginRadius') ?></option>
						<option value="after_leave_reply" <?php echo ((isset($loginRadiusSettings['LoginRadius_commentInterfacePosition']) && $loginRadiusSettings['LoginRadius_commentInterfacePosition'] == 'after_leave_reply') || !isset($loginRadiusSettings['LoginRadius_commentInterfacePosition'])) ? 'selected="selected"' : '' ?> ><?php _e("After the 'Leave a Reply' caption", 'LoginRadius') ?></option>
						<option value="before_fields" <?php echo isset($loginRadiusSettings['LoginRadius_commentInterfacePosition']) && $loginRadiusSettings['LoginRadius_commentInterfacePosition'] == 'before_fields' ? 'selected="selected"' : '' ?> ><?php _e('Before the comment form input fields', 'LoginRadius') ?></option>
						<option value="after_fields" <?php echo isset($loginRadiusSettings['LoginRadius_commentInterfacePosition']) && $loginRadiusSettings['LoginRadius_commentInterfacePosition'] == 'after_fields' ? 'selected="selected"' : '' ?> ><?php _e('Before the comment box' ,'LoginRadius') ?></option>
					</select>
					<div class="loginRadiusBorder"></div>
						</td>
						</tr>
						<tr>
						<td>
						<div class="loginRadiusQuestion">
						<?php _e('Do you want to automatically approve comments posted via Social Login?', 'LoginRadius'); ?>
						</div>
						<input type="radio" name="LoginRadius_settings[LoginRadius_autoapprove]" value="1" <?php echo ((isset($loginRadiusSettings['LoginRadius_autoapprove']) && $loginRadiusSettings['LoginRadius_autoapprove'] == '1') || !isset($loginRadiusSettings['LoginRadius_autoapprove'])) ? 'checked' : '' ?> /> <?php _e ('YES', 'LoginRadius'); ?><br />
						<input type="radio" name="LoginRadius_settings[LoginRadius_autoapprove]" value="0" <?php checked('0', @$loginRadiusSettings['LoginRadius_autoapprove']); ?>/> <?php _e ('NO, I want to approve the comments per my discretion', 'LoginRadius'); ?>
						</td>
						</tr>
						</table>
						</div>
					</div>
					</div>
					
					<div class="menu_containt_div" id="tabs-4">
						<div class="stuffbox">
						<h3><label><?php _e('Basic Social Sharing Settings', 'LoginRadius'); ?></label></h3>
						<div class="inside">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
					<tr>
					<td>
					<div class="loginRadiusQuestion">
					<?php _e("Do you want to enable Social Sharing for your website", 'LoginRadius'); ?>?
					</div>
					<div class="loginRadiusYesRadio">
					<input type="radio" name="LoginRadius_settings[LoginRadius_shareEnable]" value="1" <?php echo isset($loginRadiusSettings['LoginRadius_shareEnable']) && $loginRadiusSettings['LoginRadius_shareEnable'] == 1 ? 'checked' : ''; ?>/> <?php _e("Yes", 'LoginRadius') ?>
					</div>
					<input type="radio" name="LoginRadius_settings[LoginRadius_shareEnable]" value="0" <?php echo isset($loginRadiusSettings['LoginRadius_shareEnable']) && $loginRadiusSettings['LoginRadius_shareEnable'] == 0 ? 'checked' : ''; ?>/> <?php _e("No", 'LoginRadius') ?> 
					<div class="loginRadiusBorder"></div>
					</td>
					</tr>
					<tr>
					<td>
					<div class="loginRadiusQuestion">
					<?php _e("Enter the text that you wish to be displayed above the Social Sharing Interface. Leave the field blank if you don't want any text to be displayed.", 'LoginRadius'); ?>
					</div>
					<input type="text" name="LoginRadius_settings[LoginRadius_sharingTitle]" size="60" value="<?php if(isset($loginRadiusSettings['LoginRadius_sharingTitle'])){ echo htmlspecialchars ($loginRadiusSettings['LoginRadius_sharingTitle']); }else { _e('Share it now!', 'LoginRadius');} ?>" />
					</td>
					</tr>
					</table>
					</div>
					</div>
					
					<div class="stuffbox">
					<h3><label><?php _e('Social Sharing Theme Selection', 'LoginRadius'); ?></label></h3>
					<div class="inside">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
					<tr>
					<td>
					<div class="loginRadiusQuestion">
					<?php _e("What Social Sharing widget theme would you like to use across your website?", 'LoginRadius'); ?>
					</div>
						<input type="hidden" name="LoginRadius_settings[LoginRadius_sharingTheme]" id="login_radius_sharing_theme" value="<?php echo isset($loginRadiusSettings['LoginRadius_sharingTheme']) ? $loginRadiusSettings['LoginRadius_sharingTheme'] : '' ?>" />
					<br />
					<a href="javascript:void(0)" style="text-decoration:none" onclick="loginRadiusToggleShareTheme('horizontal')">Horizontal</a> | <a href="javascript:void(0)" style="text-decoration:none" onclick="loginRadiusToggleShareTheme('vertical')">Vertical</a>
					</td>
					</tr>
					<tr id="login_radius_horizontal_top">
					<td>
					<span class="lrsharing_spanwhite"></span>
					<span class="lrsharing_spangrey"></span>
					<div style="border:1px solid #ccc; padding:10px; border-radius:5px">
						<div class="loginRadiusQuestion">
						<?php _e('Select Social Sharing widget theme to be shown at the top of the content', 'LoginRadius'); ?>
						</div>
						<div class="login_radius_select_row" style="opacity: 1;">
							<span class="radio">
								<input style="margin-top:12px" <?php echo (isset($loginRadiusSettings['topSharing_theme']) && $loginRadiusSettings['topSharing_theme'] == '32') || !isset($loginRadiusSettings['topSharing_theme']) ? 'checked="checked"' : '' ?> type="radio" checked="checked" id="login_radius_sharing_top_32" name="LoginRadius_settings[topSharing_theme]" value="32" />
							</span>
							<label for="login_radius_sharing_top_32">
								<img src="<?php echo plugins_url('images/sharing/horizonSharing32.png', __FILE__); ?>" align="left" />
							</label>
							<div class="clear"></div>
						</div>
						<div class="login_radius_select_row" style="opacity: 1;">
							<span class="radio">
								<input <?php echo isset($loginRadiusSettings['topSharing_theme']) && $loginRadiusSettings['topSharing_theme'] == '16' ? 'checked="checked"' : '' ?> type="radio" name="LoginRadius_settings[topSharing_theme]" id="login_radius_sharing_top_16" value="16" />
							</span>
							<label for="login_radius_sharing_top_16">
								<img src="<?php echo plugins_url('images/sharing/horizonSharing16.png', __FILE__); ?>" />
							</label>
							<div class="clear"></div>
						</div>
						<div class="login_radius_select_row" style="opacity: 1;">
							<span class="radio">
								<input style="margin-top:6px" <?php echo isset($loginRadiusSettings['topSharing_theme']) && $loginRadiusSettings['topSharing_theme'] == 'single_large' ? 'checked="checked"' : '' ?> type="radio" name="LoginRadius_settings[topSharing_theme]" value="single_large" id="login_radius_sharing_top_slarge" />
							</span>
							<label for="login_radius_sharing_top_slarge">
								<img src="<?php echo plugins_url('images/sharing/single-image-theme-large.png', __FILE__); ?>" />
							</label>
							<div class="clear"></div>
						</div>
						<div class="login_radius_select_row" style="opacity: 1;">
							<span class="radio">
								<input <?php echo isset($loginRadiusSettings['topSharing_theme']) && $loginRadiusSettings['topSharing_theme'] == 'single_small' ? 'checked="checked"' : '' ?> type="radio" name="LoginRadius_settings[topSharing_theme]" id="login_radius_sharing_top_ssmall" value="single_small" />
							</span>
							<label for="login_radius_sharing_top_ssmall">
								<img src="<?php echo plugins_url('images/sharing/single-image-theme-small.png', __FILE__); ?>" />
							</label>
							<div class="clear"></div>
						</div>
					
					<div class="loginRadiusQuestion" style="margin-top:10px">
					<?php _e('Select Social Sharing widget theme to be shown at the bottom of the content', 'LoginRadius'); ?>
					</div>
						<div class="login_radius_select_row" style="opacity: 1;">
							<span class="radio">
								<input style="margin-top:12px" <?php echo (isset($loginRadiusSettings['bottomSharing_theme']) && $loginRadiusSettings['bottomSharing_theme'] == '32') || !isset($loginRadiusSettings['bottomSharing_theme']) ? 'checked="checked"' : '' ?>  type="radio" checked="checked" id="login_radius_sharing_bottom_32" name="LoginRadius_settings[bottomSharing_theme]" value="32" />
							</span>
							<label for="login_radius_sharing_bottom_32">
								<img src="<?php echo plugins_url('images/sharing/horizonSharing32.png', __FILE__); ?>" align="left" />
							</label>
							<div class="clear"></div>
						</div>
						<div class="login_radius_select_row" style="opacity: 1;">
							<span class="radio">
								<input <?php echo isset($loginRadiusSettings['bottomSharing_theme']) && $loginRadiusSettings['bottomSharing_theme'] == '16' ? 'checked="checked"' : '' ?> type="radio" name="LoginRadius_settings[bottomSharing_theme]" id="login_radius_sharing_bottom_16" value="16" />
							</span>
							<label for="login_radius_sharing_bottom_16">
								<img src="<?php echo plugins_url('images/sharing/horizonSharing16.png', __FILE__); ?>" />
							</label>
							<div class="clear"></div>
						</div>
						<div class="login_radius_select_row" style="opacity: 1;">
							<span class="radio">
								<input style="margin-top:6px" <?php echo isset($loginRadiusSettings['bottomSharing_theme']) && $loginRadiusSettings['bottomSharing_theme'] == 'single_large' ? 'checked="checked"' : '' ?> type="radio" name="LoginRadius_settings[bottomSharing_theme]" value="single_large" id="login_radius_sharing_bottom_slarge" />
							</span>
							<label for="login_radius_sharing_bottom_slarge">
								<img src="<?php echo plugins_url('images/sharing/single-image-theme-large.png', __FILE__); ?>" />
							</label>
							<div class="clear"></div>
						</div>
						<div class="login_radius_select_row" style="opacity: 1;">
							<span class="radio">
								<input <?php echo isset($loginRadiusSettings['bottomSharing_theme']) && $loginRadiusSettings['bottomSharing_theme'] == 'single_small' ? 'checked="checked"' : '' ?> type="radio" name="LoginRadius_settings[bottomSharing_theme]" id="login_radius_sharing_bottom_ssmall" value="single_small" />
							</span>
							<label for="login_radius_sharing_bottom_ssmall">
								<img src="<?php echo plugins_url('images/sharing/single-image-theme-small.png', __FILE__); ?>" />
							</label>
							<div class="clear"></div>
						</div>
					</div>
					</td>
					</tr>
					<tr id="login_radius_horizontal_bottom">
					<td>

					</td>
					</tr>
					<tr id="login_radius_vertical" style="display:none">
					<td>
					<span class="lrsharing_spanwhite" style="margin-left:77px"></span>
					<span class="lrsharing_spangrey" style="margin-left:77px"></span>
					<div style="border:1px solid #ccc; padding:10px; border-radius:5px">
						<div class="loginRadiusQuestion">
						<?php _e("Choose a sharing theme", 'LoginRadius'); ?>
						</div>
						<div style="opacity: 1; float:left; width:100px">
							<span class="radio">
								<input <?php echo (isset($loginRadiusSettings['verticalSharing_theme']) && $loginRadiusSettings['verticalSharing_theme'] == '32') || !isset($loginRadiusSettings['verticalSharing_theme']) ? 'checked="checked"' : '' ?> type="radio" id="login_radius_sharing_vertical_32" name="LoginRadius_settings[verticalSharing_theme]" value="32" />
							</span>
							<label for="login_radius_sharing_vertical_32">
								<img src="<?php echo plugins_url('images/sharing/vertical/32VerticlewithBox.png', __FILE__); ?>" align="left" />
							</label>
							<div class="clear"></div>
						</div>
						<div style="opacity: 1;">
							<span class="radio">
								<input <?php echo isset($loginRadiusSettings['verticalSharing_theme']) && $loginRadiusSettings['verticalSharing_theme'] == '16' ? 'checked="checked"' : '' ?> style="float:left" type="radio" name="LoginRadius_settings[verticalSharing_theme]" id="login_radius_sharing_vertical_16" value="16" />
							</span>
							<label for="login_radius_sharing_vertical_16">
								<img src="<?php echo plugins_url('images/sharing/vertical/16VerticlewithBox.png', __FILE__); ?>" />
							</label>
							<div class="clear"></div>
						</div>
					</div>
					</td>
					</tr>
					<tr>
					<td width>
						<div class="loginRadiusQuestion">
						<?php _e("What Sharing Networks do you want to show in the sharing widget? (All other sharing networks  will be shown as part of LoginRadius sharing icon)", 'LoginRadius') ?>
						</div>
						<div id="loginRadiusSharingLimit" style="color:red; display:none; margin-bottom: 5px;">You can select only 9 providers.</div>
						<div style="width:420px">
						<div class="loginRadiusProviders">
							<input type="checkbox" onchange="loginRadiusSharingLimit(this); loginRadiusRearrangeProviderList(this)" <?php echo !isset($loginRadiusSettings['sharing_providers']) || in_array('facebook', $loginRadiusSettings['sharing_providers']) ? 'checked="checked"' : '' ?> name="LoginRadius_settings[sharing_providers][]" value="facebook" /> <label>Facebook</label>
						</div>
						<div class="loginRadiusProviders">
							<input type="checkbox" onchange="loginRadiusSharingLimit(this); loginRadiusRearrangeProviderList(this)" <?php echo !isset($loginRadiusSettings['sharing_providers']) || in_array('googleplus', $loginRadiusSettings['sharing_providers']) ? 'checked="checked"' : '' ?> name="LoginRadius_settings[sharing_providers][]" value="googleplus" /> <label>GooglePlus</label>
						</div>
						<div class="loginRadiusProviders">
							<input type="checkbox" onchange="loginRadiusSharingLimit(this); loginRadiusRearrangeProviderList(this)" <?php echo !isset($loginRadiusSettings['sharing_providers']) || in_array('twitter', $loginRadiusSettings['sharing_providers']) ? 'checked="checked"' : '' ?> name="LoginRadius_settings[sharing_providers][]" value="twitter" /> <label>Twitter</label>
						</div>
						<div class="loginRadiusProviders">
							<input type="checkbox" onchange="loginRadiusSharingLimit(this); loginRadiusRearrangeProviderList(this)" <?php echo isset($loginRadiusSettings['sharing_providers']) && in_array('google', $loginRadiusSettings['sharing_providers']) ? 'checked="checked"' : '' ?> name="LoginRadius_settings[sharing_providers][]" value="google" /> <label>Google</label>
						</div>
						<div class="loginRadiusProviders">
							<input type="checkbox" onchange="loginRadiusSharingLimit(this); loginRadiusRearrangeProviderList(this)" <?php echo isset($loginRadiusSettings['sharing_providers']) && in_array('yahoo', $loginRadiusSettings['sharing_providers']) ? 'checked="checked"' : '' ?> name="LoginRadius_settings[sharing_providers][]" value="yahoo" /> <label>Yahoo</label>
						</div>
						<div class="loginRadiusProviders">
							<input type="checkbox" onchange="loginRadiusSharingLimit(this); loginRadiusRearrangeProviderList(this)" <?php echo isset($loginRadiusSettings['sharing_providers']) && in_array('reddit', $loginRadiusSettings['sharing_providers']) ? 'checked="checked"' : '' ?> name="LoginRadius_settings[sharing_providers][]" value="reddit" /> <label>Reddit</label>
						</div>
						<div class="loginRadiusProviders">
							<input type="checkbox" onchange="loginRadiusSharingLimit(this); loginRadiusRearrangeProviderList(this)" <?php echo !isset($loginRadiusSettings['sharing_providers']) || in_array('email', $loginRadiusSettings['sharing_providers']) ? 'checked="checked"' : '' ?> name="LoginRadius_settings[sharing_providers][]" value="email" /> <label>Email</label>
						</div>
						<div class="loginRadiusProviders">
							<input type="checkbox" onchange="loginRadiusSharingLimit(this); loginRadiusRearrangeProviderList(this)" <?php echo !isset($loginRadiusSettings['sharing_providers']) || in_array('print', $loginRadiusSettings['sharing_providers']) ? 'checked="checked"' : '' ?> name="LoginRadius_settings[sharing_providers][]" value="print" /> <label>Print</label>
						</div>
						<div class="loginRadiusProviders">
							<input type="checkbox" onchange="loginRadiusSharingLimit(this); loginRadiusRearrangeProviderList(this)" <?php echo isset($loginRadiusSettings['sharing_providers']) && in_array('tumblr', $loginRadiusSettings['sharing_providers']) ? 'checked="checked"' : '' ?> name="LoginRadius_settings[sharing_providers][]" value="tumblr" /> <label>Tumblr</label>
						</div>
						<div class="loginRadiusProviders">
							<input type="checkbox" onchange="loginRadiusSharingLimit(this); loginRadiusRearrangeProviderList(this)" <?php echo isset($loginRadiusSettings['sharing_providers']) && in_array('linkedin', $loginRadiusSettings['sharing_providers']) ? 'checked="checked"' : '' ?> name="LoginRadius_settings[sharing_providers][]" value="linkedin" /> <label>LinkedIn</label>
						</div>
						<div class="loginRadiusProviders">
							<input type="checkbox" onchange="loginRadiusSharingLimit(this); loginRadiusRearrangeProviderList(this)" <?php echo isset($loginRadiusSettings['sharing_providers']) && in_array('live', $loginRadiusSettings['sharing_providers']) ? 'checked="checked"' : '' ?> name="LoginRadius_settings[sharing_providers][]" value="live" /> <label>Live</label>
						</div>
						<div class="loginRadiusProviders">
							<input type="checkbox" onchange="loginRadiusSharingLimit(this); loginRadiusRearrangeProviderList(this)" <?php echo isset($loginRadiusSettings['sharing_providers']) && in_array('vkontakte', $loginRadiusSettings['sharing_providers']) ? 'checked="checked"' : '' ?> name="LoginRadius_settings[sharing_providers][]" value="vkontakte" /> <label>Vkontakte</label>
						</div>
						<div class="loginRadiusProviders">
							<input type="checkbox" onchange="loginRadiusSharingLimit(this); loginRadiusRearrangeProviderList(this)" <?php echo isset($loginRadiusSettings['sharing_providers']) && in_array('digg', $loginRadiusSettings['sharing_providers']) ? 'checked="checked"' : '' ?> name="LoginRadius_settings[sharing_providers][]" value="digg" /> <label>Digg</label>
						</div>
						<div class="loginRadiusProviders">
							<input type="checkbox" onchange="loginRadiusSharingLimit(this); loginRadiusRearrangeProviderList(this)" <?php echo isset($loginRadiusSettings['sharing_providers']) && in_array('myspace', $loginRadiusSettings['sharing_providers']) ? 'checked="checked"' : '' ?> name="LoginRadius_settings[sharing_providers][]" value="myspace" /> <label>MySpace</label>
						</div>
						<div class="loginRadiusProviders">
							<input type="checkbox" onchange="loginRadiusSharingLimit(this); loginRadiusRearrangeProviderList(this)" <?php echo isset($loginRadiusSettings['sharing_providers']) && in_array('delicious', $loginRadiusSettings['sharing_providers']) ? 'checked="checked"' : '' ?> name="LoginRadius_settings[sharing_providers][]" value="delicious" /> <label>Delicious</label>
						</div>
						<div class="loginRadiusProviders">
							<input type="checkbox" onchange="loginRadiusSharingLimit(this); loginRadiusRearrangeProviderList(this)" <?php echo isset($loginRadiusSettings['sharing_providers']) && in_array('hyves', $loginRadiusSettings['sharing_providers']) ? 'checked="checked"' : '' ?> name="LoginRadius_settings[sharing_providers][]" value="hyves" /> <label>Hyves</label>
						</div>
						<div class="loginRadiusProviders">
							<input type="checkbox" onchange="loginRadiusSharingLimit(this); loginRadiusRearrangeProviderList(this)" <?php echo isset($loginRadiusSettings['sharing_providers']) && in_array('dotnetkicks', $loginRadiusSettings['sharing_providers']) ? 'checked="checked"' : '' ?> name="LoginRadius_settings[sharing_providers][]" value="dotnetkicks" /> <label>DotNetKicks</label>
						</div>
						</div>
					<div class="loginRadiusBorder"></div>
					</td>
					</tr>
					<tr>
					<td>
					<div class="loginRadiusQuestion">
					<?php _e('In what order do you want your sharing networks listed?', 'LoginRadius') ?>
					</div>
					<ul id="loginRadiusSortable">
						<?php
						if(isset($loginRadiusSettings['rearrange_providers']) && count($loginRadiusSettings['rearrange_providers']) > 0){
							foreach($loginRadiusSettings['rearrange_providers'] as $provider){
								?>
								<li title="<?php echo $provider ?>" id="loginRadiusLI<?php echo $provider ?>" class="lrshare_iconsprite32 lrshare_<?php echo $provider ?>">
								<input type="hidden" name="LoginRadius_settings[rearrange_providers][]" value="<?php echo $provider ?>" />
								</li>
								<?php
							}
						}
						?>
					</ul>
					</td>
					</tr>
					</table>
					</div>
					</div>
					
					<div class="stuffbox">
					<h3><label><?php _e('Social Sharing Widget Position', 'LoginRadius'); ?></label></h3>
					<div class="inside">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
					<tr id="login_radius_vertical_position" style="display:none">
					<td>
					<div class="loginRadiusQuestion">
					<?php _e("Select the position of the Social Sharing widget", 'LoginRadius'); ?>
					</div>
						<div class="loginRadiusProviders">
							<input <?php echo (isset($loginRadiusSettings['sharing_verticalPosition']) && $loginRadiusSettings['sharing_verticalPosition'] == 'top_left') || !isset($loginRadiusSettings['sharing_verticalPosition']) ? 'checked="checked"' : '' ?> type="radio" name="LoginRadius_settings[sharing_verticalPosition]" value="top_left" /> <label>Top Left</label>
						</div>
						<div class="loginRadiusProviders">
							<input  <?php echo (isset($loginRadiusSettings['sharing_verticalPosition']) && $loginRadiusSettings['sharing_verticalPosition'] == 'top_right') ? 'checked="checked"' : '' ?> type="radio" name="LoginRadius_settings[sharing_verticalPosition]" value="top_right" /> <label>Top Right</label>
						</div>
						<div class="loginRadiusProviders">
							<input <?php echo (isset($loginRadiusSettings['sharing_verticalPosition']) && $loginRadiusSettings['sharing_verticalPosition'] == 'bottom_left') ? 'checked="checked"' : '' ?> type="radio" name="LoginRadius_settings[sharing_verticalPosition]" value="bottom_left" /> <label>Bottom Left</label>
						</div>
						<div class="loginRadiusProviders">
							<input <?php echo (isset($loginRadiusSettings['sharing_verticalPosition']) && $loginRadiusSettings['sharing_verticalPosition'] == 'bottom_right') ? 'checked="checked"' : '' ?> type="radio" name="LoginRadius_settings[sharing_verticalPosition]" value="bottom_right" /> <label>Bottom Right</label>
						</div>
					<div class="loginRadiusBorder"></div>
					</td>
					</tr>
					<tr id="login_radius_sharing_offset">
					<td>
					<div class="loginRadiusQuestion">
					<?php _e('Specify distance of vertical sharing interface from top (Leave empty for default behaviour)', 'LoginRadius'); ?>
						<a style="text-decoration:none" href="javascript:void(0)" title="Enter a number (For example - 200). It will set the 'top' CSS attribute of the interface to the value specified. Increase in the number pushes interface towards bottom.">(?)</a>
					</div>
					<input style="width:100px" type="text" name="LoginRadius_settings[sharing_offset]" value="<?php echo (isset($loginRadiusSettings['sharing_offset']) && $loginRadiusSettings['sharing_offset'] != '') ? $loginRadiusSettings['sharing_offset'] : '' ?>" />
					<div class="loginRadiusBorder"></div>
					</td>
					</tr>
					<tr>
					<td>
					<div class="loginRadiusQuestion">
					<?php _e('Select the position of the Social sharing interface', 'LoginRadius'); ?> 
					</div>
					<input type="checkbox" name="LoginRadius_settings[LoginRadius_sharetop]" value="1" <?php echo isset($loginRadiusSettings['LoginRadius_sharetop']) && $loginRadiusSettings['LoginRadius_sharetop'] == 1 ? 'checked' : '' ?>/> <?php _e ('Show at the top of content', 'LoginRadius'); ?> <br /> 
					<input type="checkbox" name="LoginRadius_settings[LoginRadius_sharebottom]" value="1" <?php echo isset($loginRadiusSettings['LoginRadius_sharebottom']) && $loginRadiusSettings['LoginRadius_sharebottom'] == 1 ? 'checked' : '' ?>/> <?php _e ('Show at the bottom of content', 'LoginRadius'); ?> 					<div class="loginRadiusBorder"></div>
					</td>
					</tr>
					<tr>		
					<td>
					<div class="loginRadiusQuestion">
					<?php _e("What area(s) do you want to show the social sharing widget?", 'LoginRadius'); ?>
					</div>
					<input type="checkbox" name="LoginRadius_settings[LoginRadius_sharehome]" value="1" <?php echo isset($loginRadiusSettings['LoginRadius_sharehome']) && $loginRadiusSettings['LoginRadius_sharehome'] == 1 ? 'checked' : '' ?>/> <?php _e ('Show on homepage', 'LoginRadius'); ?> <br /> 
					<input type="checkbox" name="LoginRadius_settings[LoginRadius_sharepost]" value="1" <?php echo isset($loginRadiusSettings['LoginRadius_sharepost']) && $loginRadiusSettings['LoginRadius_sharepost'] == 1 ? 'checked' : '' ?>/> <?php _e ('Show on posts', 'LoginRadius'); ?> 
					<br />
					<input type="checkbox" name="LoginRadius_settings[LoginRadius_sharepage]" value="1" <?php echo isset($loginRadiusSettings['LoginRadius_sharepage']) && $loginRadiusSettings['LoginRadius_sharepage'] == 1 ? 'checked' : '' ?>/> <?php _e ('Show on pages', 'LoginRadius'); ?> <br /> 
					<input type="checkbox" name="LoginRadius_settings[LoginRadius_shareexcerpt]" value="1" <?php checked('1', @$loginRadiusSettings['LoginRadius_shareexcerpt']); ?>/> <?php _e ('Show on post excerpts ', 'LoginRadius'); ?> <br /> 
					<input type="checkbox" name="LoginRadius_settings[LoginRadius_sharearchive]" value="1" <?php checked('1', @$loginRadiusSettings['LoginRadius_sharearchive']); ?>/> <?php _e ('Show on archive pages', 'LoginRadius'); ?> 
					<br />
					<input type="checkbox" name="LoginRadius_settings[LoginRadius_sharefeed]" value="1" <?php checked('1', @$loginRadiusSettings['LoginRadius_sharefeed']); ?>/> <?php _e ('Show on feed', 'LoginRadius'); ?> 
					</td>
					</tr>
					</table>
						</div>
						</div>
					</div>
					
					<div class="menu_containt_div" id="tabs-5">
						<div class="stuffbox">
						<h3><label><?php _e('Basic Social Counter Settings', 'LoginRadius'); ?></label></h3>
						<div class="inside">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
						<tr>
						<td>
						<div class="loginRadiusQuestion">
						<?php _e("Do you want to enable Social Counter for your website?", 'LoginRadius'); ?>
						</div>
						<div class="loginRadiusYesRadio">
						<input type="radio" name="LoginRadius_settings[LoginRadius_counterEnable]" value="1" <?php echo isset($loginRadiusSettings['LoginRadius_counterEnable']) && $loginRadiusSettings['LoginRadius_counterEnable'] == 1 ? 'checked' : '' ?>/> <?php _e("Yes", 'LoginRadius'); ?>
						</div>
						<input type="radio" name="LoginRadius_settings[LoginRadius_counterEnable]" value="0" <?php echo isset($loginRadiusSettings['LoginRadius_counterEnable']) && $loginRadiusSettings['LoginRadius_counterEnable'] == 0 ? 'checked' : '' ?>/> <?php _e("No", 'LoginRadius'); ?>
						<div class="loginRadiusBorder"></div>
						</td>
						</tr>
						<tr>
						<td>
						<div class="loginRadiusQuestion">
						<?php _e("Enter the text that you wish to be displayed above the Social Counter Interface. Leave the field blank if you don't want any text to be displayed", 'LoginRadius'); ?>
						</div>
						<input type="text" name="LoginRadius_settings[LoginRadius_counterTitle]" size="60" value="<?php if(isset($loginRadiusSettings['LoginRadius_counterTitle'])){ echo htmlspecialchars ($loginRadiusSettings['LoginRadius_counterTitle']); }else { _e('Be a fan', 'LoginRadius');} ?>" />
						</td>
						</tr>
						</table>
						</div>
						</div>
						
						<div class="stuffbox">
						<h3><label><?php _e('Social Counter Theme Selection', 'LoginRadius'); ?></label></h3>
						<div class="inside">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
						<tr>
						<td>
						<div class="loginRadiusQuestion">
						<?php _e('What Social Counter widget theme would you like to use across your website?', 'LoginRadius') ?>
						</div>
						<input type="hidden" name="LoginRadius_settings[LoginRadius_counterTheme]" value="<?php echo isset($loginRadiusSettings['LoginRadius_counterTheme']) ? $loginRadiusSettings['LoginRadius_counterTheme'] : '' ?>" />
						<br />
						<a href="javascript:void(0)" style="text-decoration:none" onclick="loginRadiusToggleCounterTheme('horizontal')">Horizontal</a> | <a href="javascript:void(0)" style="text-decoration:none" onclick="loginRadiusToggleCounterTheme('vertical')">Vertical</a>
						</td>
						</tr>
						<tr id="login_radius_horizontal_top_counter">
						<td>
						<span class="lrsharing_spanwhite"></span>
						<span class="lrsharing_spangrey"></span>
						<div style="border:1px solid #ccc; padding:10px; border-radius:5px">
						<div class="loginRadiusQuestion">
						<?php _e('Select Social Counter widget theme to be shown at the top of the content', 'LoginRadius'); ?>
						</div>
							<div class="login_radius_select_row" style="opacity: 1;">
								<span class="radio">
									<input <?php echo (isset($loginRadiusSettings['topCounter_theme']) && $loginRadiusSettings['topCounter_theme'] == '32') || !isset($loginRadiusSettings['topCounter_theme']) ? 'checked="checked"' : '' ?> type="radio" checked="checked" id="login_radius_counter_top_32" name="LoginRadius_settings[topCounter_theme]" value="32" />
								</span>
								<label for="login_radius_counter_top_32">
									<img src="<?php echo plugins_url('images/counter/lrshare_iconsprite32.png', __FILE__); ?>" align="left" />
								</label>
								<div class="clear"></div>
							</div>
							<div class="login_radius_select_row" style="opacity: 1;">
								<span class="radio">
									<input <?php echo isset($loginRadiusSettings['topCounter_theme']) && $loginRadiusSettings['topCounter_theme'] == '16' ? 'checked="checked"' : '' ?> type="radio" name="LoginRadius_settings[topCounter_theme]" id="login_radius_counter_top_16" value="16" />
								</span>
								<label for="login_radius_counter_top_16">
									<img src="<?php echo plugins_url('images/counter/horizontal.png', __FILE__); ?>" />
								</label>
								<div class="clear"></div>
							</div>
						
						<div class="loginRadiusQuestion" style="margin-top:10px">
						<?php _e('Select Social Counter widget theme to be shown at the bottom of the content', 'LoginRadius'); ?>
						</div>
						<div class="login_radius_select_row" style="opacity: 1;">
								<span class="radio">
									<input <?php echo (isset($loginRadiusSettings['bottomCounter_theme']) && $loginRadiusSettings['bottomCounter_theme'] == '32') || !isset($loginRadiusSettings['bottomCounter_theme']) ? 'checked="checked"' : '' ?> type="radio" checked="checked" id="login_radius_counter_bottom_32" name="LoginRadius_settings[bottomCounter_theme]" value="32" />
								</span>
								<label for="login_radius_counter_bottom_32">
									<img src="<?php echo plugins_url('images/counter/lrshare_iconsprite32.png', __FILE__); ?>" align="left" />
								</label>
								<div class="clear"></div>
							</div>
							<div class="login_radius_select_row" style="opacity: 1;">
								<span class="radio">
									<input <?php echo isset($loginRadiusSettings['bottomCounter_theme']) && $loginRadiusSettings['bottomCounter_theme'] == '16' ? 'checked="checked"' : '' ?> type="radio" name="LoginRadius_settings[bottomCounter_theme]" id="login_radius_counter_bottom_16" value="16" />
								</span>
								<label for="login_radius_counter_bottom_16">
									<img src="<?php echo plugins_url('images/counter/horizontal.png', __FILE__); ?>" />
								</label>
						</div>
						</div>
						</td>
						</tr>
						<tr id="login_radius_horizontal_bottom_counter">
						</th>
						<td>
						</td>
						</tr>
						<tr id="login_radius_vertical_counter">
						<td>
						<span class="lrsharing_spanwhite" style="margin-left:77px"></span>
						<span class="lrsharing_spangrey" style="margin-left:77px"></span>
						<div style="border:1px solid #ccc; padding:10px; border-radius:5px">
							<div class="loginRadiusQuestion">
							<?php _e("Choose a counter theme", 'LoginRadius'); ?>
							</div>
							<div style="opacity: 1; float:left; width:100px">
								<span class="radio">
									<input <?php echo (isset($loginRadiusSettings['verticalCounter_theme']) && $loginRadiusSettings['verticalCounter_theme'] == '32') || !isset($loginRadiusSettings['verticalCounter_theme']) ? 'checked="checked"' : '' ?> checked="checked" type="radio" id="login_radius_counter_vertical_32" name="LoginRadius_settings[verticalCounter_theme]" value="32" />
								</span>
								<label for="login_radius_counter_vertical_32">
									<img src="<?php echo plugins_url('images/counter/verticalvertical.png', __FILE__); ?>" align="left" />
								</label>
								<div class="clear"></div>
							</div>
							<div style="opacity: 1;">
								<span class="radio">
									<input <?php echo isset($loginRadiusSettings['verticalCounter_theme']) && $loginRadiusSettings['verticalCounter_theme'] == '16' ? 'checked="checked"' : '' ?> style="float:left" type="radio" name="LoginRadius_settings[verticalCounter_theme]" id="login_radius_counter_vertical_16" value="16" />
								</span>
								<label for="login_radius_counter_vertical_16">
									<img src="<?php echo plugins_url('images/counter/verticalhorizontal.png', __FILE__); ?>" />
								</label>
								<div class="clear"></div>
							</div>
						</div>
						</td>
						</tr>
						<tr>
						<td>
						<div class="loginRadiusQuestion">
							<?php _e("What Counter Networks do you want to show in the counter widget?", 'LoginRadius'); ?>
							</div>
							<div style="width:490px">
							<div class="loginRadiusCounterProviders">
								<input <?php echo !isset($loginRadiusSettings['counter_providers']) || in_array('Facebook Like', $loginRadiusSettings['counter_providers']) ? 'checked="checked"' : '' ?> type="checkbox" value="Facebook Like" name="LoginRadius_settings[counter_providers][]" /><label>Facebook Like</label>
							</div>
						
							<div class="loginRadiusCounterProviders">
								<input <?php echo isset($loginRadiusSettings['counter_providers']) && in_array('Facebook Recommend', $loginRadiusSettings['counter_providers']) ? 'checked="checked"' : '' ?> type="checkbox" name="LoginRadius_settings[counter_providers][]" value="Facebook Recommend" /> <label>Facebook Recommend</label>
							</div>
							<div class="loginRadiusCounterProviders">
								<input <?php echo isset($loginRadiusSettings['counter_providers']) && in_array('Facebook Send', $loginRadiusSettings['counter_providers']) ? 'checked="checked"' : '' ?> type="checkbox" name="LoginRadius_settings[counter_providers][]" value="Facebook Send" /> <label>Facebook Send</label>
							</div>
							<div class="loginRadiusCounterProviders">
								<input <?php echo !isset($loginRadiusSettings['counter_providers']) || in_array('Google+ +1', $loginRadiusSettings['counter_providers']) ? 'checked="checked"' : '' ?> type="checkbox" name="LoginRadius_settings[counter_providers][]" value="Google+ +1" /> <label>Google+ +1</label>
							</div>
							<div class="loginRadiusCounterProviders">
								<input <?php echo isset($loginRadiusSettings['counter_providers']) && in_array('Google+ Share', $loginRadiusSettings['counter_providers']) ? 'checked="checked"' : '' ?> type="checkbox" name="LoginRadius_settings[counter_providers][]" value="Google+ Share" /> <label>Google+ Share</label>
							</div>
							<div class="loginRadiusCounterProviders">
								<input <?php echo !isset($loginRadiusSettings['counter_providers']) || in_array('LinkedIn Share', $loginRadiusSettings['counter_providers']) ? 'checked="checked"' : '' ?> type="checkbox" name="LoginRadius_settings[counter_providers][]" value="LinkedIn Share" /> <label>LinkedIn Share</label>
							</div>
							<div class="loginRadiusCounterProviders">
								<input <?php echo !isset($loginRadiusSettings['counter_providers']) || in_array('Twitter Tweet', $loginRadiusSettings['counter_providers']) ? 'checked="checked"' : '' ?> type="checkbox" name="LoginRadius_settings[counter_providers][]" value="Twitter Tweet" /> <label>Twitter Tweet</label>
							</div>
							<div class="loginRadiusCounterProviders">
								<input <?php echo isset($loginRadiusSettings['counter_providers']) && in_array('StumbleUpon Badge', $loginRadiusSettings['counter_providers']) ? 'checked="checked"' : '' ?> type="checkbox" name="LoginRadius_settings[counter_providers][]" value="StumbleUpon Badge" /> <label>StumbleUpon Badge</label>
							</div>
							<div class="loginRadiusCounterProviders">
								<input <?php echo isset($loginRadiusSettings['counter_providers']) && in_array('Reddit', $loginRadiusSettings['counter_providers']) ? 'checked="checked"' : '' ?> type="checkbox" name="LoginRadius_settings[counter_providers][]" value="Reddit" /> <label>Reddit</label>
							</div>
							</div>
						</td>
						</tr>
						</table>
						</div>
						</div>
						
						<div class="stuffbox">
						<h3><label><?php _e('Social Counter Widget Position', 'LoginRadius'); ?></label></h3>
						<div class="inside">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
						<tr id="login_radius_vertical_position_counter" style="display:none">
						<td>
						<div class="loginRadiusQuestion">
						<?php _e("Select the position of the Social Counter widget", 'LoginRadius'); ?>
						</div>
							<div class="loginRadiusProviders">
								<input <?php echo (isset($loginRadiusSettings['counter_verticalPosition']) && $loginRadiusSettings['counter_verticalPosition'] == 'top_left') || !isset($loginRadiusSettings['counter_verticalPosition']) ? 'checked="checked"' : '' ?>  type="radio" name="LoginRadius_settings[counter_verticalPosition]" value="top_left" /> <label>Top Left</label>
							</div>
							<div class="loginRadiusProviders">
								<input <?php echo (isset($loginRadiusSettings['counter_verticalPosition']) && $loginRadiusSettings['counter_verticalPosition'] == 'top_right') ? 'checked="checked"' : '' ?>  type="radio" name="LoginRadius_settings[counter_verticalPosition]" value="top_right" /> <label>Top Right</label>
							</div>
							<div class="loginRadiusProviders">
								<input <?php echo (isset($loginRadiusSettings['counter_verticalPosition']) && $loginRadiusSettings['counter_verticalPosition'] == 'bottom_left') ? 'checked="checked"' : '' ?> type="radio" name="LoginRadius_settings[counter_verticalPosition]" value="bottom_left" /> <label>Bottom Left</label>
							</div>
							<div class="loginRadiusProviders">
								<input <?php echo (isset($loginRadiusSettings['counter_verticalPosition']) && $loginRadiusSettings['counter_verticalPosition'] == 'bottom_right') ? 'checked="checked"' : '' ?> type="radio" name="LoginRadius_settings[counter_verticalPosition]" value="bottom_right" /> <label>Bottom Right</label>
							</div>
						<div class="loginRadiusBorder"></div>
						</td>
						</tr>
						<tr id="login_radius_counter_offset">
						<td>
						<div class="loginRadiusQuestion">
						<?php _e('Specify distance of vertical counter interface from top (Leave empty for default behaviour)', 'LoginRadius'); ?>
						<a style="text-decoration:none" href="javascript:void(0)" title="Enter a number (For example - 200). It will set the 'top' CSS attribute of the interface to the value specified. Increase in the number pushes interface towards bottom.">(?)</a>
						</div>
						<input style="width:100px" type="text" name="LoginRadius_settings[counter_offset]" value="<?php echo (isset($loginRadiusSettings['counter_offset']) && $loginRadiusSettings['counter_offset'] != '') ? $loginRadiusSettings['counter_offset'] : '' ?>" />
						<div class="loginRadiusBorder"></div>
						</td>
						</tr>
						<tr>
						<td>
						<div class="loginRadiusQuestion">
						<?php _e('Select the position of Social counter interface', 'LoginRadius'); ?> 
						</div>
						<input type="checkbox" name="LoginRadius_settings[LoginRadius_countertop]" value="1" <?php echo isset($loginRadiusSettings['LoginRadius_countertop']) && $loginRadiusSettings['LoginRadius_countertop'] == 1 ? 'checked' : '' ?>/> <?php _e ('Show at the top of content', 'LoginRadius'); ?> <br /> 
						<input type="checkbox" name="LoginRadius_settings[LoginRadius_counterbottom]" value="1" <?php echo isset($loginRadiusSettings['LoginRadius_counterbottom']) && $loginRadiusSettings['LoginRadius_counterbottom'] == 1 ? 'checked' : '' ?>/> <?php _e ('Show at the bottom of content', 'LoginRadius'); ?> 
						<div class="loginRadiusBorder"></div>
						</td>
						</tr>
						<tr>		
						<td>
						<div class="loginRadiusQuestion">
						<?php _e("What area(s) do you want to show the social counter widget?", 'LoginRadius'); ?>
						</div>
						<input type="checkbox" name="LoginRadius_settings[LoginRadius_counterhome]" value="1" <?php echo isset($loginRadiusSettings['LoginRadius_counterhome']) && $loginRadiusSettings['LoginRadius_counterhome'] == 1 ? 'checked' : '' ?>/> <?php _e ('Show on homepage', 'LoginRadius'); ?> <br /> 
						<input type="checkbox" name="LoginRadius_settings[LoginRadius_counterpost]" value="1" <?php echo isset($loginRadiusSettings['LoginRadius_counterpost']) && $loginRadiusSettings['LoginRadius_counterpost'] == 1 ? 'checked' : '' ?>/> <?php _e ('Show on posts', 'LoginRadius'); ?> 
						<br />
						<input type="checkbox" name="LoginRadius_settings[LoginRadius_counterpage]" value="1" <?php echo isset($loginRadiusSettings['LoginRadius_counterpage']) && $loginRadiusSettings['LoginRadius_counterpage'] == 1 ? 'checked' : '' ?>/> <?php _e ('Show on pages', 'LoginRadius'); ?> <br /> 
						<input type="checkbox" name="LoginRadius_settings[LoginRadius_counterexcerpt]" value="1" <?php checked('1', @$loginRadiusSettings['LoginRadius_counterexcerpt']); ?>/> <?php _e ('Show on post excerpts ', 'LoginRadius'); ?> <br /> 
						<input type="checkbox" name="LoginRadius_settings[LoginRadius_counterarchive]" value="1" <?php checked('1', @$loginRadiusSettings['LoginRadius_counterarchive']); ?>/> <?php _e ('Show on archive pages', 'LoginRadius'); ?> 
						<br />
						<input type="checkbox" name="LoginRadius_settings[LoginRadius_counterfeed]" value="1" <?php checked('1', @$loginRadiusSettings['LoginRadius_counterfeed']); ?>/> <?php _e ('Show on feed', 'LoginRadius'); ?> 
						</td>
						</tr>
						</table>
						</div>
						</div>
					</div>
					
					<div class="menu_containt_div" id="tabs-6">
						<div class="stuffbox">
						<h3><label><?php _e('Help & Documentations', 'LoginRadius'); ?></label></h3>
						<div class="inside">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="form-table editcomment menu_content_table">
						<tr id="login_radius_vertical_position_counter">
						<td>
							<ul style="float:left; margin-right:86px">
								<li><a target="_blank" href="http://support.loginradius.com/customer/portal/articles/971398-wordpress-plugin-installation-configuration-and-troubleshooting"><?php _e('Plugin Installation, Configuration and Troubleshooting', 'LoginRadius') ?></a></li>
								<li><a target="_blank" href="http://support.loginradius.com/customer/portal/articles/677100-how-to-get-loginradius-api-key-and-secret"><?php _e('How to get LoginRadius API Key & Secret', 'LoginRadius') ?></a></li>
								<li><a target="_blank" href="http://support.loginradius.com/customer/portal/articles/687407"><?php _e('WP Multisite Feature', 'LoginRadius') ?></a></li>
								<li><a target="_blank" href="http://support.loginradius.com/customer/portal/topics/272884-wordpress-plugin/articles"><?php _e('Support Documentations', 'LoginRadius') ?></a></li>
								<li><a target="_blank" href="http://community.loginradius.com/"><?php _e('Discussion Forum', 'LoginRadius') ?></a></li>
							</ul>
							<ul style="float:left">
								<li><a target="_blank" href="http://www.loginradius.com/loginradius/about"><?php _e('About LoginRadius', 'LoginRadius') ?></a></li>
								<li><a target="_blank" href="http://www.loginradius.com/product/sociallogin"><?php _e('LoginRadius Products', 'LoginRadius') ?></a></li>
								<li><a target="_blank" href="http://www.loginradius.com/addons"><?php _e('Social Plugins', 'LoginRadius') ?></a></li>
								<li><a target="_blank" href="http://www.loginradius.com/sdks/loginradiussdk"><?php _e('Social SDKs', 'LoginRadius') ?></a></li>
							</ul>
						</td>
						</tr>
						</table>
						</div>
						</div>
					</div>
				</div>
		</div>
		<p class="submit">   
			<?php   
			// Build Preview Link   
			$preview_link = esc_url(get_option('home' ) . '/' );   
			if(is_ssl()){ 
				$preview_link = str_replace('http://', 'https://', $preview_link ); 
			} 
			$stylesheet = get_option('stylesheet');   
			$template = get_option('template');   
			$preview_link = htmlspecialchars(add_query_arg(array('preview' => 1, 'template' => $template, 'stylesheet' => $stylesheet, 'preview_iframe' => true, 'TB_iframe' => 'true' ), $preview_link ) );   
			?>
			<input style="margin-left:8px" type="submit" name="save" class="button button-primary" value="<?php _e("Save Changes", 'LoginRadius'); ?>" />   
			<a href="<?php echo $preview_link; ?>" class="thickbox thickbox-preview" id="preview" ><?php _e('Preview', 'LoginRadius'); ?></a>   
		</p>
	</form>
	</div>
	<?php
}
?>