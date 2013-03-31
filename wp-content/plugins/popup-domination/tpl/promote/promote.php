<div class="mainbox" id="popup_domination_tab_promote">
	<div class="inside twodivs">
		<div class="popdom-inner-sidebar">
			<div class="postbox">
				<h3>Promote PopUp Domination</h3>
				<div class="popdom_contentbox_inside">
					<?php $promote = $this->option('promote'); ?>
					<p><input type="checkbox" name="popup_domination[promote]" id="popup_domination_promote" value="Y"<?php echo ($promote && $promote=='Y')?' checked="checked"':''; ?> />
					<label for="popup_domination_promote">Promote PopUp Domination?</label></p>
					<span class="example">Enter your Clickbank User to become an Affiliate</span>
					<input type="text" name="popup_domination[clickbank]" id="popup_domination_clickbank" value="<?php echo $this->input_val($this->option('clickbank')) ?>"<?php echo ($promote && $promote=='Y')?'':' disabled="disabled"'; ?> />
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
</div>