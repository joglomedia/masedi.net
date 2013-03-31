<div class="wrap" id="popup_domination">
	<?php
	$header_link = 'Go To Campaigns';
	$header_url = 'admin.php?page=popup-domination/campaigns';
	require $this->plugin_path.'tpl/header.php';
	?>
	<div style="display:none" id="popup_domination_hdn_div"><?php echo $fields?></div>
	<div class="clear"></div>
	<div id="popup_domination_container" class="has-left-sidebar">
	<div style="display:none" id="popup_domination_hdn_div2"></div>
	<div class="mainbox" id="popup_domination_campaign_list">
		<div class="clear"></div>
		<?php foreach ($data as $c):?>
		<div class="camprow">
			<div class="tmppreview">
				<div class="preview_crop">
					<div class="spacing">
						<div class="slider"><h2><?php echo $temppreview; ?></h2></div>
						<img src="<?php echo $previewurl[$c->id]; ?>" height="<?php echo $height[$c->id]; ?>" width="<?php echo $width[$c->id]; ?>" />
					</div>
				</div>
			</div>
			<div class="namedesc">
				<a href="<?php echo 'admin.php?page='.$this->menu_url.'analytics&id='.$c->campaign; ?>"><?php echo $c->campaign; ?></a><br/>
				<p class="description"><?php echo $c->desc; ?></p>
			</div>
			<div class="current_analytics">
				<?php 
				$stats = $anay[$c->campaign];
				$arr = 20;
				$div = 100/5;
				$percent = array();
				if($stats[0]->conversions != 0 && $stats[0]->views != 0){
					$percent = round((intval($stats[0]->conversions) / intval($stats[0]->views)) * 100).'%';
				}else{
					$percent = '0%';
				}
				?>
				<span class="percent_converse"><?php echo $percent;?><br/><span class="smaller">Conversion rate Today</span></span>
			</div>
			<div class="actions">
		       	<?php
				$prevdata = unserialize($stats[0]->previousdata);
				if(!empty($prevdata)){
					$keys = array_keys($prevdata);
					$num = count($prevdata)-1;
					$premonth = $prevdata[$keys[$num]];
					$prevamount =  round((intval($premonth['conversions']) / intval($premonth['views'])) * 100).'%';
					$prevpercent =  abs(round($percent - ((intval($premonth['conversions']) / intval($premonth['views'])) * 100))).'%';
					if(($percent - $prevamount) > 0){
						echo '<span class="green">'.$prevpercent;
						echo '&uarr;</span>';
					}else{
						echo '<span class="red">'.$prevpercent;
						echo '&darr;</span>';
					}
					echo '<br/><br/><span class="smaller">Compared to previous months average</span>';
				}else{
					echo '<span class="smaller">No Previous Data</span>';
				}
				?>
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