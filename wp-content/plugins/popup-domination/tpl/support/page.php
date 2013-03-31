<?php
/*
* page.php
*
* Page which holds all the information required for the Support options
*/
?>
<div class="noscript">
	<span>You may have javascript disabled or have an ad blocker present. You must turn on javascript and disable the ad blocker to ensure the plugin works correctly.</span>
</div>
<?php if($this->success): ?>
<div id="message" class="updated"><p>Your email has been <strong>Sent</strong>. Our support team will be in contact within the next 24 hours.</p></div>
<?php endif; ?>
<div class="wrap with-sidebar" id="popup_domination">
	<?php $header_link = 'Support'; $header_url = 'http://popdom.desk.com/';
	include $this->plugin_path.'tpl/header.php'; ?>
	<form action="<?php echo $this->opts_url?>" method="post" id="popup_domination_form">
		<div style="display:none" id="popup_domination_hdn_div"><?php echo $fields?></div>
		<div class="clear"></div>
		<div id="popup_domination_container" class="has-left-sidebar">
			<div style="display:none" id="popup_domination_hdn_div2"></div>
			<?php include $this->plugin_path.'tpl/support/tabs.php'; ?>
				<div class="flotation-device">
					<?php include $this->plugin_path.'tpl/support/support.php'; ?>
					<?php include $this->plugin_path.'tpl/support/themes.php'; ?>
					<?php include $this->plugin_path.'tpl/support/upgrade.php'; ?>
				</div>
				<div class="clearfix"></div>
			</div>
		<div class="clear"></div>
		<?php
		$save_button = '<input class="save-btn" type="submit" name="send-email" value="'.__("Send Email", "popup_domination").'" />';
		$page_javascript = "";
		include $this->plugin_path.'tpl/footer.php'; ?>
	</form>	
</div>

	