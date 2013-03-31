<?php

/**
* page.php
*
* Template - This loads and displays all the fields and setup options for creating and editing campaigns.
*
* This holds the basic structure of the Campaign page
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
	<form action="<?php echo $this->opts_url?>" method="post" id="popup_domination_form">
		<div style="display:none" id="popup_domination_hdn_div"><?php echo $fields?></div>
		<div class="clear"></div>
		<div id="popup_domination_container" class="has-left-sidebar">
			<div style="display:none" id="popup_domination_hdn_div2"></div>
			<?php include $this->plugin_path.'tpl/campaign/header.php'; ?>
			<?php include $this->plugin_path.'tpl/campaign/tabs.php'; ?>
			
			
			<div class="notices" style="display:none;">
				<p class="message"></p>
			</div>
			<div class="flotation-device">
					<?php include $this->plugin_path.'tpl/campaign/look_and_feel.php'; ?>
					<?php include $this->plugin_path.'tpl/campaign/content.php'; ?>
					<?php include $this->plugin_path.'tpl/campaign/bullet_list.php'; ?>
					<?php include $this->plugin_path.'tpl/campaign/display_settings.php'; ?>
					<?php include $this->plugin_path.'tpl/campaign/submissions.php'; ?>
			</div>
		</div>
		
		<?php
		$footer_fields = '<input type="hidden" class="extra_fields" name="extra_fields" value="0" />
							<input type="hidden" class="campaigncookieid" name="campaignid" value="'.$campaignid.'" />';
		$save_button = '<input class="savecamp save-btn" type="submit" name="update" value="'.__("Save Changes", "popup_domination").'" />';
		$page_javascript = isset($camp_id) ? "popup_domination_campaign_id = ".$camp_id.";" : "popup_domination_campaign_id = 0;";
		include $this->plugin_path.'tpl/footer.php'; ?>
	</form>
</div>
