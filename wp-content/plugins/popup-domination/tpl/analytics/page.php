<?php

/**
* page.php
*
* Template - This template is used to display all the analytic data for a campaign.
*/

?>
<div class="noscript">
	<span>You may have javascript disabled or have an ad blocker present. You must turn on javascript and disable the ad blocker to ensure the plugin works correctly.</span>
</div>
<div class="wrap wider" id="popup_domination">
	<?php 
	$header_link = 'Back to Analytics Menu';
	$header_url = 'admin.php?page=popup-domination/analytics';
	include $this->plugin_path.'tpl/header.php';
	?>
	<form action="<?php echo $this->opts_url?>" method="post" id="popup_domination_form">
	<div style="display:none" id="popup_domination_hdn_div"><?php echo $fields?></div>
	<div class="clear"></div>
	<div id="popup_domination_container" class="has-left-sidebar">
		<div style="display:none" id="popup_domination_hdn_div2"></div>
		<?php foreach($data as $d):
			$campname =  $d->campname;
			$views =  $d->views;
			$conversions = $d->conversions;
			$prevdata = $d->previousdata;
		endforeach; ?>
		<div id="graph-wrapper">
			<div class="chart">
			<br/><br/>
				<h2>Current Month's Analytic Data for Campaign : <?php echo $campname; ?></h2>
				<br/>
				<table style="display:none" id="data-table" border="1" cellpadding="10" cellspacing="0" summary="Current Month's Analytic Data for Campaign :">
					<tbody>
						<tr>
							<th scope="row">Views</th>
							<td><?php echo intval($views); ?></td>
						</tr>
						<tr>
							<th scope="row">Conversions</th>
							<td><?php echo intval($conversions); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<?php if(!empty($prevdata)): ?>
				<?php $monthsviews = 0; $monthsconv = 0 ?>
				<div class="charttwo">
				<br/><br/>
					<h2>Last 5 Month's Analytic Data for Campaign : <?php echo $campname; ?></h2>
					<br/>
					<table id="data-table-two" style="display:none;" border="1" cellpadding="10" cellspacing="0" summary="Current Month's Analytic Data for Campaign :">
						<thead>
							<tr>
								<th></th>
							<?php $prevdata = unserialize($prevdata); foreach($prevdata as $k => $p): ?>
								<th scope="col"><?php echo $k; ?></th>
							<?php endforeach; ?>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th scope="row">Views</th>
								<?php foreach($prevdata as $p): ?>
									<td><?php echo intval($p['views']); ?></td>
								<?php endforeach; ?>
							</tr>
							<tr>
								<th scope="row">Conversions</th>
								<?php $avg = 0; $c = 0; foreach($prevdata as $p): ?>
									<td><?php echo intval($p['conversions']); ?></td>
									<?php $monthsconv = $monthsconv + intval($p['conversions']);
									$monthsviews = $monthsviews + intval($p['views']);
									if (intval($monthsviews) != 0) {
										$lstavg = round((intval($monthsconv) / intval($monthsviews)) * 100);
									}else {
										$lstavg = 0;
									}
									$avg = $avg + $lstavg; $c++;
									endforeach; ?>
							</tr>
						</tbody>
					</table>
				</div>
			<?php endif; ?>
			<div class="averages">
				<div class="percent">
					<?php 
						if(intval($conversions) == 0 || intval($views) == 0){ $math = 0;}else{
							$math = round((intval($conversions) / intval($views)) * 100);
						}
					 ?>
					<h2>Conversion Percentage:</h2>
					<?php if($math <= 0){ ?>
						<h1 class="red"><?php echo $math.'%'; ?></h1>
					<?php }else{ ?>
						<h1 class="green"><?php echo $math.'%'; ?></h1>
					<?php } ?>
					
				</div>
				<?php if(isset($avg) && !empty($avg) && isset($c) && !empty($c)) :?>
					<div class="lst-average">
						<h2>Last Month's Conversion Percentage</h2>
						<center><h1><?php echo round($lstavg).'%';?></h1></center>
					</div>
					<div class="average-percent">
						<h2>Last 5 Months Average Conversion</h2>
						<center><h1><?php echo round($avg/$c).'%';?></h1></center>
					</div>
				<?php endif; ?>
			</div>
			</div>
	<?php include $this->plugin_path . 'tpl/footer.php'; ?>
</div>