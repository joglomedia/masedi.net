
<?php if($success): ?>
	<div id="message" class="updated"><p>Your Settings have been <strong>Saved</strong></p></div>
<?php endif; ?>
	<div class="wrap with-sidebar" id="popup_domination">
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
				<p><a href="<?php echo 'admin.php?page='.$this->menu_url.'campaigns'; ?>">Mailing List Manager</a></p>
				<div class="clear"></div>
				</div>
			<div style="display:none" id="popup_domination_hdn_div"><?php echo $fields?></div>
			<div class="clear"></div>
			<div id="popup_domination_container" class="has-left-sidebar">
			<div style="display:none" id="popup_domination_hdn_div2"></div>
			<div id="popup_domination_tabs" class="campaign-details">
				<div class="campaign-name-box">
					<label for="landingpage">Re-direct user after Opt In?</label>
					<input id="landingpage" name="landingpagecheck" type="checkbox" <?php if($redirectcheck == "Y"){ echo 'checked="checked"';}else{echo '';} ?>/>
					<div class="clear"></div>
					<p class="microcopy">Leave un-ticked to not re-direct after opt in.</p>
				</div>
				<div class="campaign-description">
					<label for="campdesc">Re-direct URL: </label>
					<input id="landingurl" type="text" name="landingurldata" <?php if($redirectcheck == "Y"){ echo '';}else{ echo 'disabled="disabled"';} ?> value="<?php if($redirectcheck == "Y"){ echo $redirecturl;}else{echo '';} ?>" />
					<p class="microcopy">e.g. http://www.yourwebsite.com/thank-you.html</p>
				</div>
				<div class="clear"></div>
			</div>
			<div id="popup_domination_tabs" class="tab-menu">
				<a class="icon mailchimp selected" alt="mc" href="#mailchimp">Mailchimp</a>
				<a class="icon aweber" alt="aw" href="#aweber">Aweber</a>
				<a class="icon icontact" alt="ic" href="#icontact">iContact</a>
				<a class="icon constantc" alt="cc" href="#constantcontact">Constant Contact</a>
				<a class="icon campmon" alt="cm" href="#campaignmonitor">Campaign Monitor</a>
				<a class="icon getresp" alt="gr" href="#getresponce">Get Response</a>
				<a class="icon email" alt="nm" href="#email">Opt-ins to Email</a>
				<a class="icon htmlform" alt="other" href="#htmlform">HTML Form Code</a>
			</div>
			<div class="notices" style="display:none;">
				<p class="message"></p>
			</div>
			<div class="flotation-device">
				<div class="mainbox" id="popup_domination_tab_aweber">
						<div class="inside twodivs">
							<div class="popdom_contentbox the_help_box">
								<h3 class="help">Help</h3>
								<div class="popdom_contentbox_inside">
									<p>Click on the "Connect" Button, enter your login details and follow the steps on screen. Once Completed and returned to this screen, click the Get Mailing List link to get your mailing lists.</p>
									<br/>
								<p>If you receive an error message when attempting to connect to Aweber or attempting to collect your mailing lists, please use the button below to clear your cookies and try again.</p>
								<p>If you want to re-connect to Aweber, please use the clear cookies button and then refresh your page.</p>
								<p><a href="#clear" class="button aweber_cookieclear">Clear my Aweber cookies</a> <img class="waiting" style="display:none;" src="<?php echo $this->plugin_url; ?>css/img/ajax-loader.gif" alt="" /></p>
								</div>
								<div class="clear"></div>
							</div>
							<div class="popdom-inner-sidebar">
                    			<div class="provider_divs">
                    				<h3>Please Fill in the Following Details:</h3>
                    				<div class="aw">
                    					<input type="hidden" name="aw_clientid" alt='aw' value="<?php 
                    					
                    					if(!empty($apidata)){
                    						if($apidata['provider'] == 'aw'){ 
                    							echo $apidata['apiextra'];
                    						}else{ 
                    							if(isset($_COOKIE['awTokenSecret'])){ 
                    								echo $_COOKIE['awTokenSecret'];
                    							}else{ echo 'Token..';}
                    						}
                    					}else{
                    						if(isset($_COOKIE['awTokenSecret'])){ 
                    							echo $_COOKIE['awTokenSecret'];
                							}else{ 
                								echo 'Token..';
                							}
                						}
                    					 ?>" id="aw_clientid" />
		                    			<input type="hidden" name="aw_apikey" alt='aw' value="<?php 
		                    			
		                    			if(!empty($apidata)){
                    						if($apidata['provider'] == 'aw'){ 
                    							echo $apidata['apikey'];
                    						}else{ 
                    							if(isset($_COOKIE['awToken'])){ 
                    								echo $_COOKIE['awToken'];
                    							}else{ echo 'Token..';}
                    						}
                    					}else{
                    						if(isset($_COOKIE['awToken'])){ 
                    							echo $_COOKIE['awToken'];
                							}else{ 
                								echo 'Token..';
                							}
                						}
		                    			?>" id="aw_apikey" />
		                    			<?php if(!isset($_COOKIE['aw_getlists']) && $_COOKIE['aw_getlists'] != 'Y'): ?>
                    						<a href="<?php echo $this->plugin_url."inc/aweber.php?path=".$this->plugin_path.'&url='.$_SERVER['REQUEST_URI']; ?>" alt='aw_apikey' class="connect-to getlist"><span>Connect to Aweber</span></a>
                    					<?php else: ?>
		                    				<a href="#" alt='aw_apikey' class="aw_getlist getlist"><span>Grab Mailing List</span></a><span class="mailing-ajax-waiting">waiting</span>
		                    			<?php endif; ?>
		                    			<div class="clear"></div>
			                    		<h3>Custom Fields</h3>
	                    				<span class="example">How Many Extra Fields Would You Like?</span>
		                    			<select id="aw_custom_select" class="custom_num" name="aw_custom_num">
	                						<option value="0" name="none">0</option>
	                						<option value="1" name="one" <?php if(isset($apidata['custom1']) && !empty($apidata['custom1'])){ echo 'selected="selected"';} ?>>1</option>
	        								<option value="2" name="two" <?php if(isset($apidata['custom2']) && !empty($apidata['custom2'])){ echo 'selected="selected"';} ?>>2</option>
	                					</select>
	                					<div class="aw_custom_fields">
										</div>
                    				</div>
                    			</div>
                    		</div>
                    	</div>
                    </div>
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
                    			<span class="example">iContact Application Password</span>
                    			<input type="text" name="ic_password" alt='ic' value="<?php if(!empty($apidata)){if($apidata['provider'] == 'ic'){ echo $apidata['password'];}else{ echo 'Your Password';}}else{ echo 'Your Password';} ?>" id="ic_password" />
                    			<span class="example">iContact Username</span>
            					<input type="text" name="ic_username" alt='ic' value="<?php if(!empty($apidata)){if($apidata['provider'] == 'ic'){ echo $apidata['username'];}else{ echo 'Your Username';}}else{ echo 'Your Username';} ?>" id="ic_username" />
            					<span class="example">iContact Application AppID</span>
            					<input type="text" name="ic_apikey" alt='ic' value="<?php if(!empty($apidata)){if($apidata['provider'] == 'ic'){ echo $apidata['apikey'];}else{ echo 'Your App-ID';}}else{ echo 'Your App-ID';} ?>" id="ic_apikey" />
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
            					<input type="text" name="cm_clientid" alt='cm' value="<?php if(!empty($apidata)){if($apidata['provider'] == 'cm'){ echo $apidata['apiextra'];}else{ echo 'Enter Your Client Id..';}}else{ echo 'Enter Your Client Id..';} ?>" id="cm_clientid" />
            					<span class="example">Campaign Monitor API key</span>
                    			<input type="text" name="cm_apikey" alt='cm' value="<?php if(!empty($apidata)){if($apidata['provider'] == 'cm'){ echo $apidata['apikey'];}else{ echo 'Enter Your Api key';}}else{ echo 'Enter Your Api key';} ?>" id="cm_apikey" />
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
            					<input type="text" name="gr_apikey" alt='gr' value="<?php if(!empty($apidata)){if($apidata['provider'] == 'gr'){ echo $apidata['apikey'];}else{ echo 'Enter Your Api key';}}else{ echo 'Enter Your Api key';} ?>" id="gr_apikey" />
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
                    			<input type="text" name="mc_apikey" alt='mc' id="mc_apikey" value="<?php if(!empty($apidata)){if($apidata['provider'] == 'mc'){ echo $apidata['apikey'];}else{ echo 'Enter Your Api key';}}else{ echo 'Enter Your Api key';} ?>" />
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
                <div class="mainbox" id="popup_domination_tab_email">
					<div class="inside twodivs">
						<div class="popdom_contentbox the_help_box">
							<h3 class="help">Help</h3>
							<div class="popdom_contentbox_inside">
								<p>Please just enter the email address to which you want all optin data to be sent to.</p>
							</div>
							<div class="clear"></div>
						</div>
						<div class="popdom-inner-sidebar">
						<h3>Please Fill in the Following Details:</h3>
                			<div class="nm">
                    			<span class="example">The Email Address You Wish to Send Opt-In Details to:</span>
                    			<input type="text" name="nm_emailadd" alt='nm' id="nm_emailadd" value="<?php if(!empty($apidata)){if($apidata['provider'] == 'nm'){ echo $apidata['apikey'];}else{ echo 'Enter Your Email Address';}}else{ echo 'Enter Your Email Address';} ?>" />
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
                 <div class="mainbox" id="popup_domination_tab_htmlform">
					<div class="inside twodivs">
						<div class="popdom-inner-sidebar">  
                			<div class="other">
                				<form action="<?php echo $this->opts_url?>" method="post">
                					<h3>Please Fill in the Following Details:</h3>
			                        <div class="col">
			                            <p class="msg">Enter your html opt-in code below and we'll hook up your form to the template:</p>
			                            <p><textarea cols="60" rows="10" id="popup_domination_formhtml" name="popup_domination[formhtml]"><?php echo $formhtml?></textarea></p>
			                    		<p><input type="checkbox" name="popup_domination[new_window]" id="popup_domination_new_window" value="Y"<?php 
										$new_window = $this->option('new_window'); 
										echo ($new_window && $new_window=='Y')?' checked="checked"':''; ?> /> <label for="popup_domination_new_window">Submit the form to a new window</label></p>
			                            <p><input type="checkbox" name="popup_domination[disable_name]" id="popup_domination_disable_name" value="Y"<?php 
										$disable_name = $this->option('disable_name'); 
										echo ($disable_name && $disable_name=='Y')?' checked="checked"':''; ?> /> <label for="popup_domination_disable_name">Disable name box?</label></p>
			                            <p>
			                                <label for="popup_domination_name_box"><strong>Name:</strong></label>
			                                <select id="popup_domination_name_box" name="popup_domination[name_box]"<?php echo ($disable_name && $disable_name=='Y')?' disabled="disabled"':''; ?>></select>
			                                <input type="hidden" id="popup_domination_name_box_selected" value="<?php echo $name_box?>"<?php echo ($disable_name && $disable_name=='Y')?' disabled="disabled"':''; ?> />
			                            </p>
			                            <p>
			                                <label for="popup_domination_email_box"><strong>Email:</strong></label>
			                                <select id="popup_domination_email_box" name="popup_domination[email_box]"></select>
			                                <input type="hidden" id="popup_domination_email_box_selected" value="<?php echo $email_box?>" />
			                            </p>
			                            <p><textarea style="display:none" name="popup_domination[hidden_fields]" class="hidden_fields"></textarea></p>
			                            <div class="popup_domination_custom_inputs">
			                            <?php $number = $this->option('custom_fields'); ?>
			                            <?php if(isset($number) && $number != 0): ?>
			                            <input type="hidden" id="popup_domination_inputs_num" name="popup_domination[custom_fields]" value="<?php echo $number; ?>" />
			                            
			                            	<?php for($i=1;$i<=$number;$i++): ?>
			                      
			                            	<?php $str = 'custom'.$i.'_box'; ?>
					                            <p>
					                                <label for="popup_domination_custom<?php echo $i; ?>_box"><strong>Custom Field <?php echo $i; ?>:</strong></label>
					                                <select id="popup_domination_custom<?php echo $i; ?>_box" name="popup_domination[custom<?php echo $i; ?>_box]"></select>
					                                <input type="hidden" id="popup_domination_custom<?php echo $i; ?>_box_selected" value="<?php echo $$str; ?>"/>
					                            </p>
				                            <?php endfor; ?>
			                            <?php endif; ?>
			                            </div>
			                            <p>
			                                <label for="popup_domination_action"><strong>Form URL:</strong></label>
			                                <input size="60" type="text" id="popup_domination_action" name="popup_domination[action]" value="<?php echo $this->input_val($this->option('action'))?>" />
			                            </p>
			                        </div>
			                        <div class="clear"></div>
			                        <?php wp_nonce_field('update-options'); ?>
									<input class="savecamp form-save-btn" type="submit" name="customformsubmit" value="<?php _e('Save Changes', 'popup_domination'); ?>" />	
			                    </form>
			                </div>
		                   	<div class="clear"></div>
   						</div>	
					</div>
				</div>
                 <div class="clear"></div>
                 <div class="mainbox" id="popup_domination_tab_api">
					<div class="inside twodivs">
						<div class="popdom-inner-sidebar">                 
                 			<form id="form" name="apidata" id="apiformdata" action="<?php echo $this->opts_url?>" method="post">
                 				<div class="mailingfeedback"></div>
    	            			<div class="disable-name" <?php echo (empty($apidata) && !empty($form)) ? 'style="display:none;"' : ''; ?> >
	    	            			<p class="disablename" >Disable the Name Input?</p>
		                			<input type="checkbox" name="disable_name" class="disablename" <?php echo (!empty($apidata['disable_name']) && $apidata['disable_name'] == 'Y') ? 'checked = "checked"' : ''; ?> />
	                			</div>
                				<input type="hidden" name="oldlistid" class="oldlistid" value="<?php if(!empty($apidata)){ echo $apidata['listsid'];}else{echo '';} ?>"/>
                				<input type="hidden" name="provider" class="provider" value="<?php if(!empty($apidata)){ echo $apidata['provider'];}else{echo '';} ?>"/>
                				<input type="hidden" name="apikey" class="apikey" value="<?php if(!empty($apidata)){ echo $apidata['apikey'];}else{echo '';} ?>"/>
                				<input type="hidden" name="username" class="username" value="<?php if(!empty($apidata)){ echo $apidata['username'];}else{echo '';} ?>"/>
                				<input type="hidden" name="password" class="password" value="<?php if(!empty($apidata)){ echo $apidata['password'];}else{echo '';} ?>"/>
                				<input type="hidden" name="apiextra" class="apiextra" value="<?php if(!empty($apidata)){ echo $apidata['apiextra'];}else{echo '';} ?>"/>
                				<input type="hidden" name="redirecturl" class="redirecturl" value="<?php if(!empty($redirecturl)){ echo $redirecturl;}else{echo '';} ?>"/>
                				<input type="hidden" name="listname" class="listname" value="<?php if(!empty($apidata)){ echo $apidata['listname'];}else{echo '';} ?>" />
                				<input type="hidden" name="customf" class="customf" value="<?php if(!empty($apidata)){ echo $apidata['customf'];}else{echo '';} ?>"/>
                				<span class="example custom1" style="<?php if(isset($apidata['custom1']) && !empty($apidata['custom1'])){echo 'display:block;';}else{   echo 'display:none;';} ?>">What is Your 1st Custom Field Name? (Need Help? <a target="_blank"; href="http://popdom.desk.com/customer/portal/articles/367583-extra-custom-fields">Click Here</a>)</span>
                				<input type="text" style="<?php if(isset($apidata['custom1']) && !empty($apidata['custom1'])){echo 'display:block;';}else{   echo 'display:none;';} ?>" name="custom1" class="custom1" value="<?php if(!empty($apidata)){ echo $apidata['custom1'];}else{echo '';} ?>"/>
                				<span class="example custom2" style="<?php if(isset($apidata['custom2']) && !empty($apidata['custom2'])){echo 'display:block;';}else{   echo 'display:none;';} ?>">What is Your 2nd Custom Field Name? (Need Help? <a target="_blank"; href="http://popdom.desk.com/customer/portal/articles/367583-extra-custom-fields">Click Here</a>)</span>
                				<input type="text" style="<?php if(isset($apidata['custom2']) && !empty($apidata['custom2'])){echo 'display:block;';}else{   echo 'display:none;';} ?>" name="custom2" class="custom2" value="<?php if(!empty($apidata)){ echo $apidata['custom2'];}else{echo '';} ?>"/>
                				 
                				<h3>Currently Connected</h3>
                				<div class="current-connect">
	                				<p class="currently-connected">You are currently connected to:</p>
	                				<?php 
	                					if($apidata['provider'] == 'mc'){
	                						$logo = '<img src="'.$this->plugin_url.'css/img/mailchimp.png" />';
	                					}else if($apidata['provider'] == 'aw'){
	                						$logo = '<img src="'.$this->plugin_url.'css/img/aweber.png" />';
	                					}else if($apidata['provider'] == 'ic'){
	                						$logo = '<img src="'.$this->plugin_url.'css/img/icontact.png" />';
	                					}else if($apidata['provider'] == 'cc'){
	                						$logo = '<img src="'.$this->plugin_url.'css/img/constant.png" />';
	                					}else if($apidata['provider'] == 'cm'){
	                						$logo = '<img src="'.$this->plugin_url.'css/img/campaign.png" />';
	                					}else if($apidata['provider'] == 'gr'){
	                						$logo = '<img src="'.$this->plugin_url.'css/img/response.png" />';
	                					}else if($apidata['provider'] == 'nm'){
	                						$logo = 'Send to Email';
	                					}else{
	                						$logo = 'HTML Form Code';
	                					}
	                				?>
	                				<p class="mailing-provider"><?php echo $logo; ?></p>
	                				<div class="mailinglist" <?php echo (empty($apidata) && !empty($form)) ? 'style="display:none;"' : ''; ?> >
		                				<p class="connect-mailing-list">Mailing List you are currently using:</p>
		                				<p class="mailing-list"><?php echo $apidata['listname']; ?></p>
	                				</div>
                				</div>                  		
                		</div>
                	</div>
                </div>
			</div>
			</div>
			<div class="clear"></div>
			<div id="popup_domination_form_submit">
				<p class="submit">
					<input type="text" name="campaignid" value="<?php echo $campaignid; ?>" style="display:none" />
					<?php wp_nonce_field('update-options'); ?>
					<input class="savecamp save-btn apisubmit" type="submit" name="update" value="<?php _e('Save Changes', 'popup_domination'); ?>" />												
				</p>
				</form>				
				<p><strong>Note:</strong> Only click "Save Changes" if you have changed your mailing list.</p>
				
				<div id="popup_domination_current_version">
					<p>You are currently running <strong>version <?php echo $this->version; ?></strong></p>
				</div>
			</div>
			<div class="clear"></div>
         <script type="text/javascript">
		var popup_domination_admin_ajax = '<?php echo admin_url('admin-ajax.php') ?>', popup_domination_theme_url = '<?php echo $this->theme_url ?>', popup_domination_form_url = '<?php echo $this->opts_url ?>', popup_domination_url = '<?php echo $this->plugin_url ?>', <?php if(isset($apidata['provider']) && !empty($apidata['provider'])){ echo 'provider = "'.$apidata['provider'].'",';}else{ echo 'provider = "other",';} ?> website_url = '<?php echo site_url(); ?>', numfields = '<?php echo $number; ?>';
		</script>