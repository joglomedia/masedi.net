<?php
/*
* list.php
*
* PHP file used to display all current campaigns
*/
?>
<div class="noscript">
	<span>You may have javascript disabled or have an ad blocker present. You must turn on javascript and disable the ad blocker to ensure the plugin works correctly.</span>
</div>
<div class="wrap" id="popup_domination">
	<?php
	$header_link = 'Campaign Management';
	$header_url = '#';
	include $this->plugin_path.'tpl/header.php';
	?>
	<div style="display:none" id="popup_domination_hdn_div"><?php echo $fields?></div>
	<div class="clear"></div>
	<div id="popup_domination_container" class="has-left-sidebar">
	<div style="display:none" id="popup_domination_hdn_div2"></div>
	<div class="mainbox" id="popup_domination_campaign_list">
		<div class="newcampaign">
			<a class="green-btn" href="<?php echo 'admin.php?page='.$this->menu_url.'campaigns&action=create'; ?>"><span>Create New Popup</span></a>
			<p class="campaign-notice">You have <?php echo $count; ?> Popups.</p>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
		<?php foreach ($this->campaigns as $c): ?>
			<div class="camprow" id="camprow_<?php echo $c->id; ?>" title="<?php echo $name[$c->id]; ?>">
				<div class="tmppreview">
					<div class="preview_crop">
						<div class="spacing">
							<div class="slider"><h2><?php echo $tempname[$c->id]; ?></h2></div>
							<img class="img" id="test" src="<?php echo $previewurl[$c->id]; ?>" height="<?php echo $height[$c->id]; ?>" width="<?php echo $width[$c->id]; ?>" />
						</div>
					</div>
				</div>
				<div class="namedesc">
					<a href="<?php echo 'admin.php?page='.$this->menu_url.'campaigns&action=edit&id='.$c->id; ?>"><?php echo $c->campaign; ?></a><br/>
					<p class="description"><?php echo $c->desc; ?></p>
				</div>
				<div class="actions">
					<a id="<?php echo $c->id; ?>" title="<?php echo $name[$c->id]; ?>" class="deletecamp thedeletebutton" href="#deletecamp">Delete</a>
				</div>
				<div class="clear"></div>
			</div>
		<?php endforeach; ?>
		</div>
	<div class="clearfix"></div>
	<?php
	$page_javascript = '';
	$page_javascript = 'var popup_domination_delete_table = "campaigns", popup_domination_delete_stats = "analytics";';
	include $this->plugin_path.'tpl/footer.php'; ?>
</div>
