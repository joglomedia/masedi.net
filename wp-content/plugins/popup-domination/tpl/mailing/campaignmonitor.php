<div class="mainbox" id="popup_domination_tab_campaignmonitor">
	<div class="inside twodivs">
		<div class="popdom_contentbox the_help_box">
			<h3 class="help">Help</h3>
			<div class="popdom_contentbox_inside">
				<p>You will first need to locate your API Key which can be found under account settings.</p>
				<img src="<?php echo $this->plugin_url;?>css/img/apikey.jpg" alt="" />
				<p>The you will need to get the ClientId of the client you want to collect the list from. This can be found under Client Settings in the client's overview area.</p>
				<img src="<?php echo $this->plugin_url;?>css/img/clientid.jpg" alt="" />
				<p>Once you have these, just enter them into the fields below.</p>
			</div>
			<div class="clear"></div>
		</div>
		<div class="popdom-inner-sidebar">
		<h3>Please Fill in the Following Details:</h3>
			<div class="cm">
				<span class="example">Campaign Monitor ClientId</span>
				<input class="required" type="text" name="cm_clientid" alt='cm' placeholder="Enter Your Client Id…" value="<?php if(!empty($apidata)){if($apidata['provider'] == 'cm'){ echo $apidata['apiextra'];}else{ echo '';}}else{ echo '';} ?>" id="cm_clientid" />
				<span class="example">Campaign Monitor API key</span>
    			<input class="required" type="text" name="cm_apikey" alt='cm' placeholder="Enter Your Api key…" value="<?php if(!empty($apidata)){if($apidata['provider'] == 'cm'){ echo $apidata['apikey'];}else{ echo '';}}else{ echo '';} ?>" id="cm_apikey" />
    			<h3>Please Select a Mailing List:</h3>
    			<a href="#" alt='cm_apikey' class="cm_getlist getlist"><span>Grab Mailing List</span></a><span class="mailing-ajax-waiting">waiting</span>
    			<div class="clear"></div>
    			<h3>Custom Fields</h3>
    			<span class="example">How Many Extra Fields Would You Like? (this is limited by the template)</span>
    			<select id="cm_custom_select" class="custom_num" name="cm_custom_num">
    				<option value="0" name="none">0</option>
    				<option value="1" name="one" <?php if(isset($apidata['custom1']) && !empty($apidata['custom1'])){ echo 'selected="selected"';} ?>>1</option>
					<option value="2" name="two" <?php if(isset($apidata['custom2']) && !empty($apidata['custom2'])){ echo 'selected="selected"';} ?>>2</option>
    			</select>
    			<div class="cm_custom_fields">
    			</div>
			</div>
		</div>
	</div>
</div>
