<div class="popup_domination_top_left">
	<img class="logo" src="<?php echo $this->plugin_url?>css/img/popup-domination3-logo.png" alt="Popup Domination 3.0" title="Popup Domination 3.0" width="200" height="62" />
	<div id="popup_domination_active">
		<span class="wording">
					<?php
						$text = '<img src="'.$this->plugin_url.'css/images/off.png" alt="off" width="6" height="6" />'; $class = 'inactive'; $text2 = '<img src="'.$this->plugin_url.'css/images/on.png" alt="on" width="6" height="6" />'; $class2 = 'turn-on';$text3 = 'Inactive';$text4 = 'Active';$text5 = 'TURN ON';$text6 = 'TURN OFF';
						if($this->is_enabled()){
							$text = '<img src="'.$this->plugin_url.'css/images/on.png" alt="on" width="6" height="6" />';
							$text2 = '<img src="'.$this->plugin_url.'css/images/off.png" alt="off" width="6" height="6" />';
							$text3 = 'Active';
							$text4 = 'Inactive';
							$text5 = 'TURN OFF';
							$text6 = 'TURN ON';
							$class = 'active';
							$class2 = 'turn-off';
						}
					?>
					<span class="<?php echo $class ?>">
				<?php echo $text; ?> PopUp Domination is</span>  <?php echo $text3 ?></span>
			</span>
		</span>
		<div class="popup_domination_activate_button">
			<div class="border">
				<?php echo $text2 ?>
				<a href="#activation" class="<?php echo $class2 ?>"><?php echo $text5; ?></a>
			</div> 
			<img class="waiting" style="display:none;" src="images/wpspin_light.gif" alt="" />
		</div>
	</div>
	<?php if ((isset($header_link) && $header_link != '') &&  (isset($header_url) && $header_url != '')): ?>
	<p><a href="<?php echo $header_url; ?>"><?php echo $header_link; ?></a></p>
	<?php else: ?>
	<p><a href="#">&lt; Home</a></p>
	<?php endif; ?>
	<div class="clear"></div>
</div>