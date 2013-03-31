<div class="mainbox" id="popup_domination_tab_getresponce">
	<div class="inside twodivs">
		<div class="popdom_contentbox the_help_box">
			<h3 class="help">Help</h3>
			<div class="popdom_contentbox_inside">
				<p>You will need to collect your API Key from you account. You can find the page to do so under the My Account link. You may have to create an API Key. </p>
				<img src="<?php echo $this->plugin_url;?>css/img/grkeys.png" alt="" />
			</div>
			<div class="clear"></div>
		</div>
		<div class="popdom-inner-sidebar">
		<h3>Please Fill in the Following Details:</h3>
			<div class="gr">
			<span class="example">GetResponse API Key</span>
				<input class="required" type="text" name="gr_apikey" alt='gr' placeholder="Enter Your Api key…" value="<?php if(!empty($apidata)){if($apidata['provider'] == 'gr'){ echo $apidata['apikey'];}else{ echo '';}}else{ echo '';} ?>" id="gr_apikey" />
				<h3>Please Select a Mailing List:</h3>
				<a href="#" alt='gr_apikey' class="gr_getlist getlist"><span>Grab Mailing List</span></a><span class="mailing-ajax-waiting">waiting</span>
    			<div class="clear"></div>
    			<h3>Custom Fields</h3>
    			<span class="example">How Many Extra Fields Would You Like? (this is limited by the template)</span>
    			<select id="gr_custom_select" class="custom_num" name="gr_custom_num">
    				<option value="0" name="none">0</option>
    				<option value="1" name="one" <?php if(isset($apidata['custom1']) && !empty($apidata['custom1'])){ echo 'selected="selected"';} ?>>1</option>
					<option value="2" name="two" <?php if(isset($apidata['custom2']) && !empty($apidata['custom2'])){ echo 'selected="selected"';} ?>>2</option>
    			</select>
			</div>
		</div>
	</div>
</div>