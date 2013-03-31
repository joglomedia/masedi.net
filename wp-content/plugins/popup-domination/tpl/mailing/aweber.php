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
					<?php
					$value = '';
					if(!empty($apidata)){
						if($apidata['provider'] == 'aw'){ 
							$value = $apidata['apiextra'];
						}else{ 
							if(isset($_COOKIE['awTokenSecret'])){ 
								$value = $_COOKIE['awTokenSecret'];
							}else{ echo 'Token..';}
						}
					}else{
						if(isset($_COOKIE['awTokenSecret'])){ 
							$value = $_COOKIE['awTokenSecret'];
						}else{ 
							$value = 'Token..';
						}
					}
					 ?>
				
					<input type="hidden" name="aw_clientid" alt='aw' value="<?php echo $value; ?>" id="aw_clientid" />
					<?php 
        			$value = '';
        			if(!empty($apidata)){
						if($apidata['provider'] == 'aw'){ 
							$value = $apidata['apikey'];
						}else{ 
							if(isset($_COOKIE['awToken'])){ 
								$value = $_COOKIE['awToken'];
							}else{ echo 'Token..';}
						}
					}else{
						if(isset($_COOKIE['awToken'])){ 
							$value = $_COOKIE['awToken'];
						}else{ 
							$value = 'Token..';
						}
					}
        			?>
        			<input type="hidden" name="aw_apikey" alt='aw' value="<?php echo $value; ?>" id="aw_apikey" />
        			<?php if(!isset($_COOKIE['aw_getlists']) && $_COOKIE['aw_getlists'] != 'Y'): ?>
						<a href="<?php echo $this->plugin_url."inc/aweber.php?path=".$this->plugin_path.'&url='.$_SERVER['REQUEST_URI']; ?>" alt='aw_apikey' class="connect-to getlist"><span>Connect to Aweber</span></a>
					<?php else: ?>
        				<a href="#" alt='aw_apikey' class="aw_getlist getlist"><span>Grab Mailing List</span></a><span class="mailing-ajax-waiting">waiting</span>
        			<?php endif; ?>
        			<div class="clear"></div>
            		<h3>Custom Fields</h3>
    				<span class="example">How Many Extra Fields Would You Like? (this is limited by the template)</span>
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
