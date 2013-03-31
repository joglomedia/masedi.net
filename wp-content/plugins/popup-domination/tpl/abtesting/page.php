<?php

/**
* page.php
*
* Template - This displays all the settings, details and stats for a/b campaign, this is also the template that is used for creating a new a/b split campaign. 
*/

?>
<div class="noscript">
	<span>You may have javascript disabled or have an ad blocker present. You must turn on javascript and disable the ad blocker to ensure the plugin works correctly.</span>
</div>
<?php if($success): ?>
<div id="message" class="updated"><p>Your Settings have been <strong>Saved</strong></p></div>
<?php endif; ?>
<div class="wrap with-sidebar" id="popup_domination">
	<?php
	$header_link = 'Back to A/B Management';
	$header_url = $this->plugin_url.'tpl/ab_panel.php';
	include $this->plugin_path.'tpl/header.php'; ?>			
	<form action="<?php echo $this->opts_url?>" method="post" id="popup_domination_form">
		<div style="display:none" id="popup_domination_hdn_div"><?php echo $fields?></div>
		<div class="clear"></div>
		<div id="popup_domination_container" class="has-left-sidebar">
		<div style="display:none" id="popup_domination_hdn_div2"></div>
		<?php include $this->plugin_path.'tpl/abtesting/header.php'; ?>
		<?php include $this->plugin_path.'tpl/abtesting/tabs.php'; ?>
		<div class="notices" style="display:none;">
			<p class="message"><?php if(!isset($this->update_msg)){$this->update_msg = ' ';}else{ echo $this->update_msg;} ?></p>
		</div>
		<div class="flotation-device">
	    	<?php include $this->plugin_path.'tpl/abtesting/campaigns.php'; ?>
			<?php include $this->plugin_path.'tpl/abtesting/schedule.php'; ?>
	    	<?php include $this->plugin_path.'tpl/abtesting/results.php'; ?>
		</div>
			<div class="clear"></div>
			<?php
			$footer_fields = '<input type="hidden" class="extra_fields" name="extra_fields" value="0" />
								<input type="hidden" class="campaigncookieid" name="campaignid" value="'.$camp_id.'" />';
			$save_button = '<input class="savecamp save-btn" type="submit" name="update" value="'.__("Save Changes", "popup_domination").'" />';
			$page_javascript = isset($camp_id) ? "popup_domination_campaign_id = ".$camp_id.";" : "";
			include $this->plugin_path.'tpl/footer.php'; ?>
	</form>
</div>