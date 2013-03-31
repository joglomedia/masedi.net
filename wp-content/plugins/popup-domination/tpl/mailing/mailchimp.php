<div class="mainbox" id="popup_domination_tab_mailchimp">
	<div class="inside twodivs">
		<div class="popdom_contentbox the_help_box">
			<h3 class="help">Help</h3>
			<div class="popdom_contentbox_inside">
				<p>You can find your API Key under the Account link->API Keys. You may have to create a new API Key.</p>
				<img src="<?php echo $this->plugin_url;?>css/img/keys.jpg" width="450" height="99" alt="" />
			</div>
			<div class="clear"></div>
		</div>
		<div class="popdom-inner-sidebar">
			<h3>Please Fill in the Following Details:</h3>
			<div class="mc">
    			<span class="example">Mailchimp API Key:</span>
    			<input type="text" class="required" name="mc_apikey" alt='mc' id="mc_apikey" placeholder="Enter Your Api key…" value="<?php if(!empty($apidata)){if($apidata['provider'] == 'mc'){ echo $apidata['apikey'];}else{ echo '';}}else{ echo '';} ?>" />
    			<h3>Please Select a Mailing List:</h3>
    			<a href="#" alt='mc_apikey' class="mc_getlist getlist"><span>Grab Mailing List</span></a><span class="mailing-ajax-waiting">waiting</span>
    			<div class="clear"></div>
			</div>
			<span class="example">How Many Extra Fields Would You Like? (this is limited by the template)</span>
			<select id="mc_custom_select" class="custom_num" name="mc_custom_num">
				<option value="0" name="none">0</option>
    			<option value="1" name="one" <?php if(isset($apidata['custom1']) && !empty($apidata['custom1'])){ echo 'selected="selected"';} ?>>1</option>
				<option value="2" name="two" <?php if(isset($apidata['custom2']) && !empty($apidata['custom2'])){ echo 'selected="selected"';} ?>>2</option>
			</select>
    	</div>
    </div>
</div>