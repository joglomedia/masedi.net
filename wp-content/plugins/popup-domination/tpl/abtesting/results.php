<div class="mainbox" id="popup_domination_tab_results">
	<?php if(!empty($split['results'])): ?>
    <div class="holdall">
		<div id="graph-wrapper">
			<div class="line-chart chart-one">
				<h2>Analytic Data for Split Campaign : <?php echo $name; ?> (Conversions)</h2>
				<br/>
				<table id="data-table-two" style="display:none;" border="1" cellpadding="10" cellspacing="0" summary="Analytic Data for Split Campaign : ">
					<caption>&nbsp;</caption>
					<thead>
						<tr>
							<th></th>
							<?php $c = 0; ?>
							<?php foreach($split['results'] as $k => $rr): ?>
								<?php if(count($rr) > $c){
									$max = $k;
									$c = count($rr);
								}?>
							<?php endforeach; ?>
							<?php foreach($split['results'][$max] as $k => $rr): ?>
								<th scope="col"><?php echo $k; ?></th>
							<?php endforeach; ?>
						</tr>
					</thead>
					<tbody>
						<?php $i= 0; foreach($split['results'] as $r): ?>
						<tr>
							<th scope="row"><?php echo $campname[$i][0]->campaign; ?></th>
							<?php foreach($r as $k=> $rr): ?>
								<td><?php echo intval($rr['optin']); ?></td>
							<?php endforeach; ?>
						</tr>
						<?php $i++; endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php else: ?>
		<h2>There is No Analytic Data Yet.</h2>
	<?php endif; ?>
</div>