<div class="mainbox" id="popup_domination_tab_constantcontact">
	<div class="inside twodivs">
		<div class="popdom_contentbox the_help_box">
			<h3 class="help">Help</h3>
			<div class="popdom_contentbox_inside">
				<p>Click on the "Connect" Button, enter your login details and follow the steps on screen. Once Completed and returned to this screen, click the Get Mailing List link to get your mailing lists.</p>
			</div>
			<div class="clear"></div>
		</div>
		<div class="popdom-inner-sidebar">
		<h3>Please Fill in the Following Details:</h3>
			<div class="cc">
			    <h3>Please Select a Mailing List</h3>
			    <input type="hidden" name="username" value="<?php if(!empty($apidata)){if($apidata['provider'] == 'cc'){ echo $apidata['username'];}else{ echo '';}}else{ echo '';} ?>" class="cc_username" />
				<input type="hidden" name="password" value="<?php if(!empty($apidata)){if($apidata['provider'] == 'cc'){ echo $apidata['password'];}else{ echo '';}}else{ echo '';} ?>" class="cc_password" />
				<input type="hidden" name="apikey" value="<?php if(!empty($apidata)){if($apidata['provider'] == 'cc'){ echo $apidata['apiextra'];}else{ echo '';}}else{ echo '';} ?>" class="cc_apikey" />
				<input type="hidden" name="usersecret" value="<?php if(!empty($apidata)){if($apidata['provider'] == 'cc'){ echo $apidata['apikey'];}else{ echo '';}}else{ echo '';} ?>" class="cc_usersecret" />
				<a href="<?php echo $this->plugin_url."inc/concon/constantcon.php"; ?>" alt='cc_apikey' class="connect-to getlist fancybox"><span>Connect to Constant Contact</span></a>
            	<a href="#" alt='cc_apikey' class="cc_getlist getlist" style="display:none;"><span>Grab Mailing List</span></a><span class="mailing-ajax-waiting">waiting</span>
    			<div class="clear"></div>
			   	<h3>Custom Fields</h3>
			   	<span class="example">How Many Extra Fields Would You Like? (this is limited by the template)</span>
    			<select id="cc_custom_select" class="custom_num" name="cc_custom_num">
    				<option value="0" name="none">0</option>
    				<option value="1" name="one" <?php if(isset($apidata['custom1']) && !empty($apidata['custom1'])){ echo 'selected="selected"';} ?>>1</option>
					<option value="2" name="two" <?php if(isset($apidata['custom2']) && !empty($apidata['custom2'])){ echo 'selected="selected"';} ?>>2</option>
    			</select><br/>
    			<select style="display:none" id="cc_custom1" name="cc_custom1">
    				<option value="0" name="none">Please Select...</option>
    				<option value="MiddleName" name="MiddleName" <?php if($apidata['custom1'] == 'MiddleName'){ echo 'selected="selected"';} ?> >Middle Name</option>
					<option value="LastName" name="LastName" <?php if($apidata['custom1'] == 'LastName'){ echo 'selected="selected"';} ?>>Last Name</option>
					<option value="HomePhone" name="HomePhone" <?php if($apidata['custom1'] == 'HomePhone'){ echo 'selected="selected"';} ?>>Home Phone</option>
					<option value="Addr1" name="Addr1" <?php if($apidata['custom1'] == 'Addr1'){ echo 'selected="selected"';} ?>>Address</option>
					<option value="City" name="City" <?php if($apidata['custom1'] == 'City'){ echo 'selected="selected"';} ?>>City</option>
					<option value="StateName" name="StateName" <?php if($apidata['custom1'] == 'StateName'){ echo 'selected="selected"';} ?>>State/Province</option>
					<option value="PostalCode" name="PostalCode" <?php if($apidata['custom1'] == 'PostalCode'){ echo 'selected="selected"';} ?>>Zip/Postal Code</option>
    			</select><br/>
    			<select  style="display:none" id="cc_custom2" name="cc_custom2">
    				<option value="0" name="none">Please Select...</option>
               		<option value="MiddleName" name="MiddleName" <?php if($apidata['custom2'] == 'MiddleName'){ echo 'selected="selected"';} ?> >Middle Name</option>
					<option value="LastName" name="LastName" <?php if($apidata['custom2'] == 'LastName'){ echo 'selected="selected"';} ?>>Last Name</option>
					<option value="HomePhone" name="HomePhone" <?php if($apidata['custom2'] == 'HomePhone'){ echo 'selected="selected"';} ?>>Home Phone</option>
					<option value="Addr1" name="Addr1" <?php if($apidata['custom2'] == 'Addr1'){ echo 'selected="selected"';} ?>>Address</option>
					<option value="City" name="City" <?php if($apidata['custom2'] == 'City'){ echo 'selected="selected"';} ?>>City</option>
					<option value="StateName" name="StateName" <?php if($apidata['custom2'] == 'StateName'){ echo 'selected="selected"';} ?>>State/Province</option>
					<option value="PostalCode" name="PostalCode" <?php if($apidata['custom2'] == 'PostalCode'){ echo 'selected="selected"';} ?>>Zip/Postal Code</option>
    			</select>
    			<div class="clear"></div>
			</div>
		</div>
	</div>
</div>
