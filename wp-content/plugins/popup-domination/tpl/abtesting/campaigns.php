<div class="mainbox" id="popup_domination_tab_look_and_feel">
    <h3 class="title topbar icon feel"><span>Select Campaigns</span></h3>
    <div class="inside">
        <table>
            <?php foreach ($campdata as $offset => $c): ?>
            	
    		<tr>
    			<?php
    				if($split['campaigns']){
        				foreach ($split['campaigns'] as $s){
        					$s = stripslashes($s);
            				if($s == $c->campaign){
            					$tick[$s] = 'checked = "yes"';	 
            				}else{
            					$tick[$s] = '';
            				}
        				}
        				if (array_key_exists($c->campaign, $tick)) {
							echo '';
						}else{
							$tick[$c->campaign] = '';
						}
					}
    			?>
    			<td><input <?php if(isset($tick)){ echo $tick[$c->campaign];} ?> type="checkbox" name="campaign[]" value="<?php echo $c->campaign; ?>" /><?php echo $c->campaign; ?></td>
    		</tr>
    		<?php endforeach; ?>
    	</table>
    </div>
    <div class="clear"></div>
</div>