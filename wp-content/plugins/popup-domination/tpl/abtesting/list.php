<?php
/*
* list.php
*
* PHP file used to display all current A/B campaigns
*/
?>
<div class="noscript">
	<span>You may have javascript disabled or have an ad blocker present. You must turn on javascript and disable the ad blocker to ensure the plugin works correctly.</span>
</div>
<div class="wrap" id="popup_domination">
	<?php
	$header_link = 'A/B Campaign Management';
	$header_url = '#';
	include $this->plugin_path.'tpl/header.php';
	?>
			
			
	<div style="display:none" id="popup_domination_hdn_div"><?php echo $fields?></div>
	<div class="clear"></div>
	<div id="popup_domination_container" class="has-left-sidebar">
	<div style="display:none" id="popup_domination_hdn_div2"></div>
	<div class="mainbox" id="popup_domination_campaign_list">				
		<div class="newcampaign">
			<a class="green-btn" href="<?php echo 'admin.php?page='.$this->menu_url.'a-btesting&action=create'; ?>"><span>Create A/B Campaign</span></a>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
		<?php foreach($this->abcamp as $c): ?>
		<div class="camprow" id="camprow_<?php echo $c->id; ?>">
			<div class="tmppreview">
				<div class="preview_crop">
					<div class="spacing">
						<?php $name =''; foreach($tempname[$c->id] as $t){
        					$tmpname[] = $t;
        					$name .= $t.' ';
        				} ?>
						<div class="slider"><h2><?php echo $name; ?></h2></div>
						<?php
    						foreach($previewurl[$c->id] as $p){
    							$img[] = '<img class="img" id="test" src="'.$p.'">';
    						}
    						$output = array_rand($img, 1);
    						echo $img[$output];
    					?>
					</div>
				</div>
			</div>
			<div class="namedesc">
				<a href="<?php echo 'admin.php?page='.$this->menu_url.'a-btesting&action=edit&id='.$c->id; ?>"><?php echo $c->name; ?></a><br/>
				<p class="description"><?php echo $c->description; ?></p>
			</div>
			<div class="actions">
				<a id="<?php echo $c->id; ?>" class="deletecamp thedeletebutton" href="#deletecamp">Delete</a>
			</div>
			<?php if(!empty($stats) || !empty($stats[0])): ?>
				<?php $stats = unserialize($c->astats); 
    			$arr = 20;
    			$div = 100/5;
    			$percent = array();
        		foreach($stats as $k => $s){
        			if($s[date('m')]['optin'] == 0 || $s[date('m')]['show'] == 0){
    					$percent[$k]['percent'] = '0%';
    				}else{
        				$percent[$k]['percent'] = round((intval($s[date('m')]['optin']) / intval($s[date('m')]['show'])) * 100).'%';
        			}
    			}
    		?>
    		<div class="percentages">
    			<p class="sectitle">Template Conversion Percentage</p>                			
    			<?php $i = 0; foreach($percent as $k => $p): ?>
    				<div class="percent"><?php echo $tmpname[$i].' - <span class="numberper">'.$p['percent'].'</span>'; ?></div>
    			<?php $i++; endforeach; ?>
    		</div>
    		<?php endif; ?>
			<div class="clear"></div>
		</div>
		<?php endforeach; ?>
	</div>
	<?php
	$page_javascript = "var popup_domination_delete_table = 'ab';";
	include $this->plugin_path.'tpl/footer.php'; ?>
</div>