<div class="mainbox" id="popup_domination_tab_icontact">
	<div class="inside twodivs">
		<div class="popdom_contentbox the_help_box">
			<h3 class="help">Help</h3>
			<div class="popdom_contentbox_inside">
				<p>Once Logged into your account, using your browser, navigate to: https://app.icontact.com/icp/core/externallogin</p>
				<p>Using the AppID (AJueEV2f4gWJmAKbXgG4SZVhLzISrijR), register the plugin to your account with a password to access it.</p>
				<p>Once the app is registered, you should have a screen like this:</p>
				<img src="<?php echo $this->plugin_url;?>css/img/apiconnect.jpg" alt="" />
				<p>Using the fields below, enter your Username, the chosen password, and the AppID.</p>
			</div>
			<div class="clear"></div>
		</div>
		<div class="popdom-inner-sidebar">
		<h3>Please Fill in the Following Details:</h3>
			<div class="ic">
    			<input type="hidden" name="ic_apikey" alt='ic' value="AJueEV2f4gWJmAKbXgG4SZVhLzISrijR" id="ic_apikey" />
    			<span class="example">iContact Username</span>
				<input class="required" type="text" name="ic_username" alt='ic' placeholder="Your Username..." value="<?php if(!empty($apidata)){if($apidata['provider'] == 'ic'){ echo $apidata['username'];}else{ echo '';}}else{ echo '';} ?>" id="ic_username" />
				<span class="example">iContact Application Password (Note: This is not the password you use to sign into iContact. Read above for more information.)</span>
    			<input class="required" type="text" name="ic_password" alt='ic' placeholder="Your Password…" value="<?php if(!empty($apidata)){if($apidata['provider'] == 'ic'){ echo $apidata['password'];}else{ echo '';}}else{ echo '';} ?>" id="ic_password" />
				<span class="example">iContact Application AppID</span>
				<input class="required" type="text" name="ic_apikey" alt='ic' placeholder="Your App-ID" value="<?php if(!empty($apidata)){if($apidata['provider'] == 'ic'){ echo $apidata['apikey'];}else{ echo '';}}else{ echo '';} ?>" id="ic_apikey" />
				<h3>Please Select a Mailing List</h3>
				<a href="#" alt='ic_apikey' class="ic_getlist getlist"><span>Grab Mailing List</span></a><span class="mailing-ajax-waiting">waiting</span>
				<div class="clear"></div>
				<h3>Custom Fields</h3>
				<span class="example">How Many Extra Fields Would You Like? (this is limited by the template)</span>
				<select id="ic_custom_select" class="custom_num" name="cc_custom_num">
    				<option value="0" name="none">0</option>
					<option value="1" name="one" <?php if(isset($apidata['custom1']) && !empty($apidata['custom1'])){ echo 'selected="selected"';} ?>>1</option>
					<option value="2" name="two" <?php if(isset($apidata['custom2']) && !empty($apidata['custom2'])){ echo 'selected="selected"';} ?>>2</option>
    			</select>

    		</div>
		</div>
	</div>
</div>