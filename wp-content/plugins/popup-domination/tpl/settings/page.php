<?php
/*
* page.php
*
* Page which holds all the information required for the settings tab
* This was designed with the intention of making debugging easier and possibly providing backdoor entry? (secret door to PopDom debug functionality) - NOT IMPLEMENTED
*/
?>
<div class="noscript">
	<span>You may have javascript disabled or have an ad blocker present. You must turn on javascript and disable the ad blocker to ensure the plugin works correctly.</span>
</div>
<div class="wrap" id="popup_domination">
	<?php $header_link = 'Support', $header_url = $this->plugin_url.'http://popdom.desk.com/';
	include $this->plugin_url.'tpl/header.php'; ?>
	</div>
	<form action="<?php echo $this->opts_url?>" method="post" id="popup_domination_form">
	<div style="display:none" id="popup_domination_hdn_div"><?php echo $fields?></div>
	<div class="clear"></div>
	<div id="popup_domination_container" class="has-left-sidebar">
	<div style="display:none" id="popup_domination_hdn_div2"></div>
	<div class="mainbox" id="popup_domination_campaign_list">				
		<div class="newcampaign">
			<a class="green-btn" href="<?php echo 'admin.php?page='.$this->menu_url.'#'; ?>"><span>Submit New Request</span></a>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
		
	</div>
	<div class="clearfix"></div>
</div>
<div id="popup_domination_form_submit">
	<div id="popup_domination_current_version">
		<p>You are currently running <strong>version <?php echo $this->version; ?></strong></p>
	</div>
        <?php wp_nonce_field('update-options'); ?>
	</form>
</div>
<script type="text/javascript">
var popup_domination_admin_ajax = '<?php echo admin_url('admin-ajax.php') ?>', popup_domination_theme_url = '<?php echo $this->theme_url ?>', popup_domination_form_url = '<?php echo $this->opts_url ?>', popup_domination_url = '<?php echo $this->plugin_url ?>', popup_domination_delete_table = 'ab';
</script>