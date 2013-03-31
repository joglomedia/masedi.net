<?php
/*
* page.php
*
* 
*/
?>
<div class="noscript">
	<span>You may have javascript disabled or have an ad blocker present. You must turn on javascript and disable the ad blocker to ensure the plugin works correctly.</span>
</div>
<?php if($this->success): ?>
<div id="message" class="updated"><p>Your Settings have been <strong>Saved</strong></p></div>
<?php endif; ?>
<div class="wrap with-sidebar" id="popup_domination">
	<?php
	$header_link = 'Back to Campaign Management';
	$header_url = 'admin.php?page=popup-domination/campaigns';
	include $this->plugin_path.'tpl/header.php';
	?>
	<div style="display:none" id="popup_domination_hdn_div"><?php echo $fields?></div>
	<div class="clear"></div>
	
	<form id="form" name="apidata" id="apiformdata" action="<?php echo $this->opts_url; ?>" method="post">
	<div id="popup_domination_container" class="has-left-sidebar">
		<div style="display:none" id="popup_domination_hdn_div2"></div>
		<div id="popup_domination_tabs" class="campaign-details">
			<div class="campaign-name-box">
				<label for="landingpage">Re-direct user after Opt In?</label>
				<input id="landingpage" name="landingpagecheck" type="checkbox" <?php if($redirectcheck == "Y"){ echo 'checked="checked"';}else{echo '';} ?> />
				<div class="clear"></div>
				<p class="microcopy">Leave un-ticked to not re-direct after opt in.</p>
			</div>
			<div class="campaign-description">
				<label for="campdesc">Re-direct URL: </label>
				<input id="landingurl" type="text" name="landingurldata" <?php if($redirectcheck == "Y"){ echo '';}else{ echo 'disabled="disabled"';} ?> value="<?php if($redirectcheck == "Y"){ echo $redirecturl;}else{echo '';} ?>" />
				<p class="microcopy">e.g. http://www.yourwebsite.com/thank-you.html</p>
			</div>
			<div class="clear"></div>
		</div>
		<?php include $this->plugin_path.'tpl/mailing/tabs.php'; ?>
		<div class="notices" style="display:none;">
			<p class="message"></p>
		</div>
		<div class="flotation-device">
			<?php include $this->plugin_path.'tpl/mailing/mailchimp.php'; ?>
			<?php include $this->plugin_path.'tpl/mailing/aweber.php'; ?>
			<?php include $this->plugin_path.'tpl/mailing/icontact.php'; ?>
			<?php include $this->plugin_path.'tpl/mailing/constantcontact.php'; ?>
			<?php include $this->plugin_path.'tpl/mailing/campaignmonitor.php'; ?>
			<?php include $this->plugin_path.'tpl/mailing/getresponse.php'; ?>
			<?php include $this->plugin_path.'tpl/mailing/email.php'; ?>
			<?php include $this->plugin_path.'tpl/mailing/htmlform.php'; ?>
			
			<div class="clear"></div>
			<div class="mainbox" id="popup_domination_tab_api">
				<div class="inside twodivs">
					<div class="popdom-inner-sidebar">                 
						
							<div class="mailingfeedback"></div>
							<p <?php if($apidata['provider'] == 'aw'){echo 'style="display:none;"';} ?>>Disable the Name Input?</p>
							<input type="checkbox" name="disablename" class="disablename" <?php if($apidata['provider'] == 'aw'){echo 'style="display:none;"';} if(!empty($apidata['disablename']) && $apidata['disablename'] == 'Y'){ echo 'checked = "checked"';}else{echo '';} ?> />
							<input type="hidden" name="oldlistid" class="oldlistid" value="<?php if(!empty($apidata)){ echo $apidata['listsid'];}else{echo '';} ?>"/>
							<input type="hidden" name="provider" class="provider" value="<?php if(!empty($apidata)){ echo $apidata['provider'];}else{echo '';} ?>"/>
							<input type="hidden" name="apikey" class="apikey" value="<?php if(!empty($apidata)){ echo $apidata['apikey'];}else{echo '';} ?>"/>
							<input type="hidden" name="username" class="username" value="<?php if(!empty($apidata)){ echo $apidata['username'];}else{echo '';} ?>"/>
							<input type="hidden" name="password" class="password" value="<?php if(!empty($apidata)){ echo $apidata['password'];}else{echo '';} ?>"/>
							<input type="hidden" name="apiextra" class="apiextra" value="<?php if(!empty($apidata)){ echo $apidata['apiextra'];}else{echo '';} ?>"/>
							<input type="hidden" name="redirecturl" class="redirecturl" value="<?php if(!empty($redirecturl)){ echo $redirecturl;}else{echo '';} ?>"/>
							<input type="hidden" name="listname" class="listname" value="<?php if(!empty($apidata)){ echo $apidata['listname'];}else{echo '';} ?>" />
							<input type="hidden" name="customf" class="customf" value="<?php if(!empty($apidata)){ echo $apidata['customf'];}else{echo '';} ?>"/>
							<span class="example custom1" style="<?php if(isset($apidata['custom1']) && !empty($apidata['custom1'])){echo 'display:block;';}else{   echo 'display:none;';} ?>">What is Your 1st Custom Field Name? (Need Help? <a target="_blank"; href="http://popdom.desk.com/customer/portal/articles/367583-extra-custom-fields">Click Here</a>)</span>
							<input type="text" style="<?php if(isset($apidata['custom1']) && !empty($apidata['custom1'])){echo 'display:block;';}else{   echo 'display:none;';} ?>" name="custom1" class="custom1" value="<?php if(!empty($apidata)){ echo $apidata['custom1'];}else{echo '';} ?>"/>
							<span class="example custom2" style="<?php if(isset($apidata['custom2']) && !empty($apidata['custom2'])){echo 'display:block;';}else{   echo 'display:none;';} ?>">What is Your 2nd Custom Field Name? (Need Help? <a target="_blank"; href="http://popdom.desk.com/customer/portal/articles/367583-extra-custom-fields">Click Here</a>)</span>
							<input type="text" style="<?php if(isset($apidata['custom2']) && !empty($apidata['custom2'])){echo 'display:block;';}else{   echo 'display:none;';} ?>" name="custom2" class="custom2" value="<?php if(!empty($apidata)){ echo $apidata['custom2'];}else{echo '';} ?>"/>
							<?php if(!empty($apidata)): ?> 
							<h3>Currently Connected</h3>
							<div class="current-connect">
								<p class="currently-connected">You are currently connected to:</p>
								<?php 
									if($apidata['provider'] == 'mc'){
										$logo = '<img src="'.$this->plugin_url.'css/img/mailchimp.png" />';
									}else if($apidata['provider'] == 'aw'){
										$logo = '<img src="'.$this->plugin_url.'css/img/aweber.png" style="margin-left:-13px;" />';
									}else if($apidata['provider'] == 'ic'){
										$logo = '<img src="'.$this->plugin_url.'css/img/icontact.png" />';
									}else if($apidata['provider'] == 'cc'){
										$logo = '<img src="'.$this->plugin_url.'css/img/constant.png" />';
									}else if($apidata['provider'] == 'cm'){
										$logo = '<img src="'.$this->plugin_url.'css/img/campaign.png" />';
									}else if($apidata['provider'] == 'gr'){
										$logo = '<img src="'.$this->plugin_url.'css/img/response.png" />';
									}else if($apidata['provider'] == 'nm'){
										$logo = 'Send to Email';
									}else{
										$logo = '';
									}
								?>
								<p class="mailing-provider"><?php echo $logo; ?></p>
								<p class="connect-mailing-list">Mailing List you are currently using:</p>
								<p class="mailing-list"><?php echo $apidata['listname']; ?></p>
							</div>
							<?php endif; ?>
						</form>
					</div>
				</div>
			</div>
		</div>
	<?php
	$save_button = '<input class="savecamp save-btn apisubmit" type="submit" value="Save Changes" name="update" style="display: inline;">';
	$footer_fields = '<input type="hidden" name="campaignid" value="'.$campaignid.'" />';
	$provider = "provider = '".((isset($apidata['provider']) && !empty($apidata['provider'])) ? $apidata['provider']: "form")."'";
	$page_javascript = "var $provider, website_url = '".site_url()."', numfields = $number;";
	include $this->plugin_path.'tpl/footer.php'; ?>
	</form>
	</div>
</div>