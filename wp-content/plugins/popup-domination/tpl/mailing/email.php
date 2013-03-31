<div class="mainbox" id="popup_domination_tab_email">
	<div class="inside twodivs">
		<div class="popdom_contentbox the_help_box">
			<h3 class="help">Help</h3>
			<div class="popdom_contentbox_inside">
				<p>Please just enter the email address to which you want all opt-in data to be sent to.</p>
			</div>
			<div class="clear"></div>
		</div>
		<div class="popdom-inner-sidebar">
			<h3>Please Fill in the Following Details:</h3>
			<div class="nm">
				<span class="example">The Email Address You Wish to Send Opt-In Details to:</span>
				<input class="required" type="text" name="nm_emailadd" alt='nm' id="nm_emailadd" placeholder="Enter Your Email Address..." value="<?php if(!empty($apidata)){if($apidata['provider'] == 'nm'){ echo $apidata['apikey'];}else{ echo '';}}else{ echo '';} ?>" />
			</div>
			<span class="example">How Many Extra Fields Would You Like? (this is limited by the template)</span>
			<select id="nm_custom_select" class="custom_num" name="nm_custom_num">
			<option value="0" name="none">0</option>
			<option value="1" name="one" <?php if(isset($apidata['custom1']) && !empty($apidata['custom1'])){ echo 'selected="selected"';} ?>>1</option>
			<option value="2" name="two" <?php if(isset($apidata['custom2']) && !empty($apidata['custom2'])){ echo 'selected="selected"';} ?>>2</option>
			</select>
		</div>
	</div>
</div>