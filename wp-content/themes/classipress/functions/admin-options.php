<?php

//classipress admin page


function cp_admin_info_box() { ?>

<div class="info">
	<div style="float: left; padding-top:4px;"><strong><?php _e('Need help with these options?','cp')?></strong> <a href="http://xmobile.yw.sk/docs/" target="blank"><?php _e('Visit our online documentation','cp')?></a>. <a href="http://xmobile.yw.sk/forum/" target="blank"><?php _e('Ask a question in our Support Forum','cp')?></a>.
<?php if (get_option("paypal_sandbox") == "1") { echo "<br /><br /><span style='color: #FF0000;'>" . __('** You are currently running in PayPal Sandbox mode. Uncheck the box when you are ready to start selling ads again. **','cp') . "</span>"; } ?>
	</div>
	<div style="float: right; margin:0; padding:0; " class="submit"><input name="save" type="submit" value="<?php _e('Save changes','cp')?>" /></div>
	<div style="clear:both;"></div>
</div>	 
					
<?php

}					


function classipress() {
    if(isset($_POST['submitted']) && $_POST['submitted'] == "yes"){
	
		$update_options = $_POST['adminArray']; 

		foreach($update_options as $key => $value){
			update_option( trim($key), trim($value) );
		}
		
		// damn those checkboxes
		$cp_468x60 = (int)trim($_POST['cp_adcode_468x60_checkbox']);
		$cp_336x280 = (int)trim($_POST['cp_adcode_336x280_checkbox']);
		update_option("cp_adcode_468x60_checkbox", $cp_468x60);
		update_option("cp_adcode_336x280_checkbox", $cp_336x280);
		

        echo "<div id=\"message\" class=\"updated fade\"><p><strong>Your settings have been saved.</strong></p></div>";
    }
?>

<div class="wrap">
<h2><?php _e('ClassiPress','cp')?></h2>
<form method="post" name="classipress" target="_self">

<?php cp_admin_info_box(); ?>

<table style="margin-bottom: 20px;"></table>
<h3 class="title"><?php _e('General Configuration','cp')?></h3>
     						
<table class="maintable">
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Color Scheme','cp')?></td>
		<td class="forminp">
				<select name="adminArray[stylesheet]" id="stylesheet" style="width: 400px;">
					<option <?php if (get_option("stylesheet") == "default.css") { echo ' selected="selected"'; } ?>>default.css</option>
					<option <?php if (get_option("stylesheet") == "blue.css") { echo ' selected="selected"'; } ?>>blue.css</option>
					<option <?php if (get_option("stylesheet") == "green.css") { echo ' selected="selected"'; } ?>>green.css</option>
					<option <?php if (get_option("stylesheet") == "pink.css") { echo ' selected="selected"'; } ?>>pink.css</option>
					<option <?php if (get_option("stylesheet") == "red.css") { echo ' selected="selected"'; } ?>>red.css</option>
				</select>
		</td>
	</tr>

	<tr class="mainrow">
		<td class="titledesc"><?php _e('Website Logo','cp')?></td>
		<td class="forminp">
			<input name="adminArray[cp_logo]" type="text" style="width: 600px;" value="<?php echo get_option("cp_logo"); ?>" /><br />
			<small><?php _e('Paste the URL of your website logo image here. It will replace the default ClassiPress header logo. <br /> (i.e. http://www.yoursite.com/logo.jpg)','cp')?></small>
		</td>
	</tr>

	<tr class="mainrow">
		<td class="titledesc"><?php _e('Ad Posting Permissions','cp')?></td>
		<td class="forminp">
			<select name="adminArray[permissions]" style="width: 100px;">
				<option value="no"<?php if (get_option("permissions") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','cp')?></option>
				<option value="yes"<?php if (get_option("permissions") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','cp')?></option>
			</select>
			<br /><small><?php _e('Can unregistered visitors post ads? If "no" then visitors must register before being able to post ads.','cp')?></small><br /><br />
			
			<input name="adminArray[permission_err]" type="text" style="width: 600px;" value="<?php if (get_option("permission_err") == "") { echo __('You have to be logged in to post a classified ad.','cp'); } else { echo get_option("permission_err"); } ?>" /><br />
			<small><?php _e('Enter a message unregistered visitors see when they try to post an ad.','cp')?></small>

			<?php if (!get_option('users_can_register')) : ?>
			<br /><small style="color: #FF0000;"><?php _e('User registration is not activated.','cp')?> <a href="options-general.php"><?php _e('Go and activate it.','cp')?></a></small>
			<?php endif; ?>
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Allow Ad Editing','cp')?></td>
		<td class="forminp">
			<select name="adminArray[cp_ad_edit]" style="width: 100px;">
				<option value="yes"<?php if (get_option("cp_ad_edit") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','cp')?></option>
				<option value="no"<?php if (get_option("cp_ad_edit") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','cp')?></option>
			</select><br />
			<small><?php _e('This enables registered visitors to make edits and republish their existing ads.','cp')?></small>
		</td>
	</tr>
	

	<tr class="mainrow">
		<td class="titledesc"><?php _e('Default New Ad Status','cp')?></td>
		<td class="forminp">
			<select name="adminArray[post_status]" style="width: 100px;">
				<option value="draft"<?php if (get_option("post_status") == "draft") { echo ' selected="selected"'; } ?>><?php _e('Draft','cp')?></option>
				<option value="publish"<?php if (get_option("post_status") == "publish") { echo ' selected="selected"'; } ?>><?php _e('Published','cp')?></option>
			</select><br />
			<small><?php _e('<i>Draft</i> - You have to manually approve and publish each ad','cp')?><br />
			<?php _e('<i>Published</i> - Ad goes live immediately without any approvals','cp')?><br />
			<?php _e('Note: If you have the "Activate Paypal?" option set to "Yes" then each ad will automatically be a draft until payment is made (regardless of the option above).','cp')?></small>
		</td>
	</tr>
	

	<tr class="mainrow">
		<td class="titledesc"><?php _e('Ad Pruning','cp')?></td>
		<td class="forminp">
			<select name="adminArray[post_prun]" style="width: 100px;">
				<option value="no"<?php if (get_option("post_prun") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','cp')?></option>
				<option value="yes"<?php if (get_option("post_prun") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','cp')?></option>
			</select><br />
			<small><?php _e('Removes the classified ads from your site after a certain number of days.','cp')?></small><br /><br />
			<input name="adminArray[prun_period]" type="text" style="width: 40px;" maxlength="3" value="<?php echo get_option("prun_period"); ?>" /> <?php _e('Days','cp')?> <br /><small><?php _e('Number of days until ads are purged and taken down from your site.','cp')?></small>
			</td>
	</tr>
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Prune Status','cp')?></td>
		<td class="forminp">
			<select name="adminArray[prun_status]" style="width: 100px;">
				<option value="1"<?php if (get_option("prun_status") == "1") { echo ' selected="selected"'; } ?>><?php _e('Draft','cp')?></option>
				<option value="2"<?php if (get_option("prun_status") == "2") { echo ' selected="selected"'; } ?>><?php _e('Delete','cp')?></option>
			</select>	
				<br />
			<small><?php _e('<i>Draft</i> - Changes the ad status back to draft. Good option if you want to keep a history of all your ads (recommended).','cp')?><br />
			<?php _e('<i>Delete</i> - Completely erases all expired ads.','cp')?></small>
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Exclude Pages from Nav','cp')?></td>
		<td class="forminp">
			<input name="adminArray[excluded_pages]" type="text" style="width: 200px;" value="<?php echo get_option("excluded_pages"); ?>" /><br />
			<small><?php _e('Enter a comma-separated list of your user "dashboard" and "edit-ad" page IDs so they are excluded from the navigation (i.e. 44,45). To find the Page ID, go to Pages->Edit and hover over the title of the page. The status bar of your browser will display a URL with a numeric ID at the end. This is the page ID.','cp')?></a></small>
				
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Ads Form Message','cp')?></td>
		<td class="forminp">
		<textarea name="adminArray[ads_form_note]" rows="5" cols="93"><?php echo stripslashes(get_option("ads_form_note")); ?></textarea><br />
		<small><?php _e('When someone clicks the "Post a Classified!" button this message will appear on that form page. HTML is allowed.','cp')?></small>
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Feedburner RSS URL','cp')?></td>
		<td class="forminp">
			<input name="adminArray[feedburner_url]" type="text" style="width: 600px;" value="<?php echo get_option("feedburner_url"); ?>" /><br />
			<small><?php _e('Redirects your default rss feed url to Feedburner. You must have a','cp')?> <a target="_blank" href="http://www.feedburner.com"><?php _e('Feedburner','cp')?></a> <?php _e('account setup first.','cp')?></small>
		</td>
	</tr>
</table>
	
<h3 class="title"><?php _e('Google Options','cp')?></h3>
     						
<table class="maintable">
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Google Maps','cp')?></td>
		<td class="forminp">
			<select name="adminArray[cp_gmaps]" style="width: 100px;">
				<option value="yes"<?php if (get_option("cp_gmaps") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','cp')?></option>
				<option value="no"<?php if (get_option("cp_gmaps") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','cp')?></option>
			</select><br />
			<small><?php _e('Enables an interactive Google map on your classified ads page. (Requires a Google Maps API key.)','cp')?></small><br /><br />
			<input name="adminArray[cp_gmaps_key]" type="text" style="width: 690px;" value="<?php echo get_option("cp_gmaps_key"); ?>" /><br />
			<small><?php _e('Generate a free','cp')?> <a target="_blank" href="http://code.google.com/apis/maps/signup.html"><?php _e('Google Maps API key','cp')?></a> <?php _e(' and then paste it above.','cp')?></small>
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Google Analytics','cp')?></td>
		<td class="forminp">
		<textarea name="adminArray[google_analytics_box]" rows="11" cols="93"><?php echo stripslashes(get_option("google_analytics_box")); ?></textarea><br />
			<small><?php _e('Start tracking your site visitors with ease. You must have a','cp')?> <a target="_blank" href="http://www.google.com/analytics/"><?php _e('Google Analytics','cp')?></a> <?php _e('account setup first <br /> This text box supports multiple analytic providers.','cp')?></small>
		</td>
	</tr>
	
</table>


<h3 class="title"><?php _e('Header Ad Spot (468x60)','cp')?></h3>
     						
<table class="maintable">
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Disable Ad Spot','cp')?></td>
		<td class="forminp">
			<input type="checkbox" class="checkbox" name="cp_adcode_468x60_checkbox" value="1" <?php if (get_option("cp_adcode_468x60_checkbox") == "1") { echo 'checked'; } ?> />
		</td>
	</tr>

	<tr class="mainrow">
		<td class="titledesc"><?php _e('Ad Code','cp')?></td>
		<td class="forminp">
		<textarea name="adminArray[cp_adcode_468x60]" rows="11" cols="93"><?php echo stripslashes(get_option("cp_adcode_468x60")); ?></textarea><br />
			<small><?php _e('Paste in your','cp')?> <a target="_blank" href="http://www.google.com/adsense"><?php _e('Google AdSense','cp')?></a> <?php _e('code here. This will show up in the header of your site.','cp')?></small>
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Ad Image URL','cp')?></td>
		<td class="forminp">
			<input name="adminArray[cp_adcode_468x60_url]" type="text" style="width: 600px;" value="<?php echo get_option("cp_adcode_468x60_url"); ?>" /><br />
			<small><?php _e('Paste the URL of your custom logo image here. It will replace the default ClassiPress header logo. <br /> (i.e. http://www.yoursite.com/logo.jpg)','cp')?></small>
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Ad Destination','cp')?></td>
		<td class="forminp">
			<input name="adminArray[cp_adcode_468x60_dest]" type="text" style="width: 600px;" value="<?php echo get_option("cp_adcode_468x60_dest"); ?>" /><br />
			<small><?php _e('Paste the URL of your custom logo image here. It will replace the default ClassiPress header logo. <br /> (i.e. http://www.yoursite.com/logo.jpg)','cp')?></small>
		</td>
	</tr>

</table>


<h3 class="title"><?php _e('Single Post Ad Spot (336x280)','cp')?></h3>
     						
<table class="maintable">
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Disable Ad Spot','cp')?></td>
		<td class="forminp">
			<input type="checkbox" class="checkbox" name="cp_adcode_336x280_checkbox" value="1" <?php if (get_option("cp_adcode_336x280_checkbox") == "1") { echo 'checked'; } ?> />
		</td>
	</tr>

	<tr class="mainrow">
		<td class="titledesc"><?php _e('Ad Code','cp')?></td>
		<td class="forminp">
		<textarea name="adminArray[adsense_box]" rows="11" cols="93"><?php echo stripslashes(get_option("adsense_box")); ?></textarea><br />
		<small><?php _e('Paste in your','cp')?> <a target="_blank" href="http://www.google.com/adsense"><?php _e('Google AdSense','cp')?></a> <?php _e('code here. This will show up at the bottom of each classified ad.','cp')?></small>
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Ad Image URL','cp')?></td>
		<td class="forminp">
			<input name="adminArray[cp_adcode_336x280_url]" type="text" style="width: 600px;" value="<?php echo get_option("cp_adcode_336x280_url"); ?>" /><br />
			<small><?php _e('Paste the URL of your custom logo image here. It will replace the default ClassiPress header logo. <br /> (i.e. http://www.yoursite.com/logo.jpg)','cp')?></small>
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Ad Destination','cp')?></td>
		<td class="forminp">
			<input name="adminArray[cp_adcode_336x280_dest]" type="text" style="width: 600px;" value="<?php echo get_option("cp_adcode_336x280_dest"); ?>" /><br />
			<small><?php _e('Paste the URL of your custom logo image here. It will replace the default ClassiPress header logo. <br /> (i.e. http://www.yoursite.com/logo.jpg)','cp')?></small>
		</td>
	</tr>

</table>


<p class="submit"><input name="submitted" type="hidden" value="yes" /><input type="submit" name="Submit" value="<?php _e('Save changes','cp')?>" /></p>

<div style="clear: both;"></div>

</div>

<?php  } 


function classi_payments() {
    if(isset($_POST['submitted']) && $_POST['submitted'] == "yes"){

		$update_options = $_POST['adminArray']; 
		foreach($update_options as $key => $value){
			update_option( trim($key), trim($value) );
		}
		
		$paypal_sandbox = (int)trim($_POST['paypal_sandbox']);
		update_option("paypal_sandbox", $paypal_sandbox);
		
		
		$new_options = $_POST['catarray']; 
		foreach($new_options as $key => $value) {
			update_option( trim($key), trim($value) );
		}
		
        echo "<div id=\"message\" class=\"updated fade\"><p><strong>" . __('Your settings have been saved.','cp') . "</strong></p></div>";
    }
	$delete_file = strip_tags($_GET['delete']);
	if ( $delete_file != "" ) {
		$delete_file = "../wp-content/uploads/classipress/".$delete_file;
		unlink($delete_file);
}
?>

<script language="javascript">
	var oldD="";
	function show(o){
		if(oldD!="") oldD.style.display='none';
		if(o.selectedIndex>0){
			var d=document.getElementById(o[o.selectedIndex].value);
			d.style.display='block';
			oldD=d;
		}
	}
</script>

<div class="wrap">
<h2><?php _e('ClassiPress','cp')?></h2>
<form method="post" name="classipress" target="_self">

<?php cp_admin_info_box(); ?>
	 
<table style="margin-bottom: 20px;"></table>
<h3 class="title"><?php _e('Payment Options','cp')?></h3>
     						
<table class="maintable">

	<tr class="mainrow">
		<td class="titledesc"><?php _e('Activate Paypal','cp')?></td>
		<td class="forminp">
			<select name="adminArray[activate_paypal]" style="width: 100px;">
				<option value="yes" <?php if (get_option("activate_paypal") == "yes") { echo 'selected'; } ?>><?php _e('Yes','cp')?></option>
				<option value="no" <?php if (get_option("activate_paypal") == "no") { echo 'selected'; } ?>><?php _e('No','cp')?></option>
			</select><br />
			<small><?php _e('Turn this on if you want to start selling classified ads on your site. <br />You must have a','cp')?> <a target="_blank" href="http://www.paypal.com"><?php _e('PayPal','cp')?></a> <?php _e('account setup before using this feature.','cp')?></small>
		</td>
	</tr>
	<tr class="mainrow">
		<td class="titledesc"><?php _e('PayPal Email','cp')?></td>
		<td class="forminp">
			<input name="adminArray[paypal_email]" type="text" style="width: 400px;" value="<?php echo get_option("paypal_email"); ?>" /><br />
			<small><?php _e('Enter your PayPal account email address. This is where your money gets sent.','cp')?></small>
			<?php if (!get_option('paypal_email')) : ?>
			<br /><small style="color: #FF0000;"><?php _e('You must enter a PayPal email address before you can accept payments.','cp')?></small>
			<?php endif; ?>
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('PayPal Sandbox Mode','cp')?></td>
		<td class="forminp">
			<input name="paypal_sandbox" type="checkbox" value="1" <?php if (get_option("paypal_sandbox") == "1") { echo 'checked'; } ?>/><br />
			<small><?php _e('By default PayPal is set to live mode. If you would like to test and see if payments are being processed, check this box to switch to sandbox mode. To use this option, you must have a','cp')?> <a target="_blank" href="https://developer.paypal.com/"><?php _e('PayPal Sandbox','cp')?></a> <?php _e('and test account setup first.','cp')?></small>
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Email Notification','cp')?></td>
		<td class="forminp">
			<select name="adminArray[notif_pay]" style="width: 100px;">
				<option value="yes"<?php if (get_option("notif_pay") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','cp')?></option>
				<option value="no"<?php if (get_option("notif_pay") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','cp')?></option>
			</select><br />
			<small><?php _e('Send an email when payment has been made. You should also get an email from PayPal to confirm.','cp')?></small> 
		</td>
	</tr>
</table>	


<?php if (get_option("activate_paypal") != "yes") { echo "<span style='color: #FF0000;padding-left:20px;'>" . __('** PayPal must be activated above in order for pricing options to work. **','cp') . "</span>"; } ?>
<h3 class="title"><?php _e('Pricing Options','cp')?></h3>
   
						
<table class="maintable">	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Currency Symbol','cp')?></td>
		<td class="forminp">
			<input name="adminArray[currency]" type="text" style="width: 50px;" value="<?php echo get_option("currency") ?>" /><br />
			<small><?php _e('Enter the currency symbol you want to appear next to prices on your classified ads (i.e. $, &euro;, &pound;, &yen;).','cp')?></small>
		</td>
	</tr>


<tr class="mainrow">
		<td class="titledesc"><?php _e('Currency','cp')?></td>
		<td class="forminp">
			
			<select name="adminArray[paypal_currency]" style="width: 200px;">
				<option value="USD"<?php if (get_option("paypal_currency") == "USD") { echo ' selected="selected"'; } ?>><?php _e('US Dollars','cp')?> (&#36;)</option>
				<option value="EUR"<?php if (get_option("paypal_currency") == "EUR") { echo ' selected="selected"'; } ?>><?php _e('Euros','cp')?> (&euro;)</option>
				<option value="GBP"<?php if (get_option("paypal_currency") == "GBP") { echo ' selected="selected"'; } ?>><?php _e('Pounds Sterling','cp')?> (&pound;)</option>
				<option value="AUD"<?php if (get_option("paypal_currency") == "AUD") { echo ' selected="selected"'; } ?>><?php _e('Australian Dollars','cp')?> (&#36;)</option>
				<option value="CAD"<?php if (get_option("paypal_currency") == "CAD") { echo ' selected="selected"'; } ?>><?php _e('Canadian Dollars','cp')?> (&#36;)</option>
				<option value="CZK"<?php if (get_option("paypal_currency") == "CZK") { echo ' selected="selected"'; } ?>><?php _e('Czech Koruna','cp')?></option>
				<option value="DKK"<?php if (get_option("paypal_currency") == "DKK") { echo ' selected="selected"'; } ?>><?php _e('Danish Krone','cp')?></option>
				<option value="HKD"<?php if (get_option("paypal_currency") == "HKD") { echo ' selected="selected"'; } ?>><?php _e('Hong Kong Dollar','cp')?> (&#36;)</option>
				<option value="HUF"<?php if (get_option("paypal_currency") == "HUF") { echo ' selected="selected"'; } ?>><?php _e('Hungarian Forint','cp')?></option>
				<option value="ILS"<?php if (get_option("paypal_currency") == "ILS") { echo ' selected="selected"'; } ?>><?php _e('Israeli Shekel','cp')?></option>
				<option value="JPY"<?php if (get_option("paypal_currency") == "JPY") { echo ' selected="selected"'; } ?>><?php _e('Japanese Yen','cp')?> (&yen;)</option>
				<option value="MXN"<?php if (get_option("paypal_currency") == "MXN") { echo ' selected="selected"'; } ?>><?php _e('Mexican Peso','cp')?></option>
				<option value="NZD"<?php if (get_option("paypal_currency") == "NZD") { echo ' selected="selected"'; } ?>><?php _e('New Zealand Dollar','cp')?> (&#36;)</option>
				<option value="NOK"<?php if (get_option("paypal_currency") == "NOK") { echo ' selected="selected"'; } ?>><?php _e('Norwegian Krone','cp')?></option>
				<option value="PLN"<?php if (get_option("paypal_currency") == "PLN") { echo ' selected="selected"'; } ?>><?php _e('Polish Zloty','cp')?></option>
				<option value="SGD"<?php if (get_option("paypal_currency") == "SGD") { echo ' selected="selected"'; } ?>><?php _e('Singapore Dollar','cp')?> (&#36;)</option>
				<option value="SEK"<?php if (get_option("paypal_currency") == "SEK") { echo ' selected="selected"'; } ?>><?php _e('Swedish Krona','cp')?></option>
				<option value="CHF"<?php if (get_option("paypal_currency") == "CHF") { echo ' selected="selected"'; } ?>><?php _e('Swiss Franc','cp')?></option>
			</select><br />
			
		</td>
	</tr>
	
	
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Featured Ad Price','cp')?></td>
		<td class="forminp">
			<input name="adminArray[cp_featured_ad]" type="text" style="width:50px;" value="<?php echo get_option("cp_featured_ad"); ?>" />&nbsp;<span style="color:#bbb;font-size:13px;"><?php echo get_option("paypal_currency"); ?></span>
			<br />
			<small><?php _e('This is the additional amount you will charge visitors to post a featured ad on your site. A featured ad appears at the top of the category.','cp')?></small>
		</td>
	</tr>
	
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Pricing Structure','cp')?></td>
		<td class="forminp">
			
			<select name="adminArray[cp_price_scheme]" style="width: 200px;" onchange="show(this)">
			<option value="single"><?php _e('Select One','cp')?></option>
				<option value="single"<?php if (get_option("cp_price_scheme") == "single") { echo ' selected="selected"'; } ?>><?php _e('Fixed Price Per Ad','cp')?></option>
				<option value="percentage"<?php if (get_option("cp_price_scheme") == "percentage") { echo ' selected="selected"'; } ?>><?php _e('% of Sellers Ad Price','cp')?></option>
				<option value="category"<?php if (get_option("cp_price_scheme") == "category") { echo ' selected="selected"'; } ?>><?php _e('Price Per Category','cp')?></option>
				
			</select><br />
			<small><?php _e('Select the way you want to charge people to place ads.','cp')?></small>
		</td>
	</tr>
	
<!--	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Per Category Price','cp')?></td>
		<td class="forminp">
			<select name="adminArray[cp_per_cat_fee]" style="width: 100px;">
				<option value="no"<?php if (get_option("cp_per_cat_fee") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','cp')?></option>
				<option value="yes"<?php if (get_option("cp_per_cat_fee") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','cp')?></option>
			</select><br />
			<small><?php _e('Turn this on if you want to charge different prices for each category.','cp')?></small> 
		</td>
	</tr> 
-->

</table>


<div id="single" <?php if (get_option("cp_price_scheme") == "single") { echo ' style="display:block;"'; } else { echo ' style="display:none;"'; } ?>>	
<h3 class="title"><?php _e('Set Fixed Price Per Ad','cp')?></h3>
<table class="maintable">
<tr class="mainrow">
		<td class="titledesc"><?php _e('Price Per Ad','cp')?></td>
		<td class="forminp">
			<input name="adminArray[ad_value]" type="text" style="width: 50px;" value="<?php echo get_option("ad_value"); ?>" />&nbsp;<span style="color:#bbb;font-size:13px;"><?php echo get_option("paypal_currency"); ?></span>
			<br />
			<small><?php _e('This is the amount you will charge visitors to post an ad on your site.','cp')?></small>
		</td>
	</tr>
</table>
</div>

<div id="percentage" <?php if (get_option("cp_price_scheme") == "percentage") { echo ' style="display:block;"'; } else { echo ' style="display:none;"'; } ?>>	
<h3 class="title"><?php _e('Set % of Sellers Ad Price','cp')?></h3>
<table class="maintable">
<tr class="mainrow">
		<td class="titledesc"><?php _e('Percentage','cp')?></td>
		<td class="forminp">
			<input name="adminArray[cp_ad_percent]" type="text" style="width: 50px;" value="<?php echo get_option("cp_ad_percent"); ?>" />&nbsp;<span style="color:#bbb;font-size:13px;">%</span>
			<br />
			<small><?php _e('This is the amount you will charge visitors to post an ad on your site.','cp')?></small>
		</td>
	</tr>
</table>
</div>

	
<div id="category" <?php if (get_option("cp_price_scheme") == "category") { echo ' style="display:block;"'; } else { echo ' style="display:none;"'; } ?>>	
<h3 class="title"><?php _e('Set Category Prices','cp')?></h3>
<table class="maintable">
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Individual Categories','cp')?></td>
		<td class="forminp">
		<small><?php _e('Enter the price you want to charge for each category listing. Setting it to "0" makes the category FREE. (use numeric values only)','cp')?></small> <br /><br />
		<?php cp_cat_fees(); ?></td>
	</tr>
</table>
</div>


<p class="submit"><input name="submitted" type="hidden" value="yes" /><input type="submit" name="Submit" value="<?php _e('Save changes','cp')?>" /></p>

</div>


<?php  } 



function classi_cats() {
    if(isset($_POST['submitted']) && $_POST['submitted'] == "yes"){

        $cat = wp_dropdown_categories('orderby=id&order=ASC&hide_empty=0&echo=0');
		$cat = str_replace("\n", "", $cat);
		$cat = str_replace("\t", "", $cat);
		$cat = str_replace("<select name='cat' id='cat' class='postform' ><option class=\"level-0\" value=\"", "", $cat);
		$cat = str_replace("</option><option class=\"level-0\" value=\"", "_", $cat); $cat = str_replace("</option><option class=\"level-1\" value=\"", "_", $cat); $cat = str_replace("</option><option class=\"level-2\" value=\"", "_", $cat); $cat = str_replace("</option><option class=\"level-3\" value=\"", "_", $cat); $cat = str_replace("</option><option class=\"level-4\" value=\"", "_", $cat);
		$cat = str_replace("\">", "-", $cat);
		$cat = str_replace("</option></select>", "", $cat);

		$cat = explode("_", $cat);
		foreach($cat as $category)
		{
			$category = explode("-", $category);
			$cat_number = $category[0];
			$cat_name = $category[1];
			update_option("cat$cat_number", $_POST["cat$cat_number"]);
		} //foreach

        echo "<div id=\"message\" class=\"updated fade\"><p><strong>" . __('Your settings have been saved.','cp') . "</strong></p></div>";		
    }
	$delete_file = strip_tags($_GET['delete']);
	if ( $delete_file != "" ) {
		$delete_file = "../wp-content/uploads/classipress/".$delete_file;
		unlink($delete_file);
}
?>


<div class="wrap">
<h2><?php _e('ClassiPress','cp')?></h2>
<form method="post" name="classipress" target="_self">

<?php cp_admin_info_box(); ?>
	 
<table style="margin-bottom: 20px;"></table>
<h3 class="title"><?php _e('Category Options','cp')?></h3>
<p>&nbsp;<?php _e('Below you can assign icons to each category. These only show up if you selected "No" for the','cp')?> "<a href="./admin.php?page=settings"><?php _e('Show Picture on Front Page','cp')?></a>" <?php _e('option. Make sure to click the "Save changes" button after your changes have been made.','cp')?></p>
     						
<table class="maintable">

	<tr class="mainrow">
		<td colspan="2">
			<?php echo cat_img(); ?>
		</td>
	</tr>
	
</table>

<p class="submit"><input name="submitted" type="hidden" value="yes" /><input type="submit" name="Submit" value="<?php _e('Save changes','cp')?>" /></p>

</div>


<?php  } 


// process new ads
function classi_settings() {
    if(isset($_POST['submitted']) && $_POST['submitted'] == "yes"){

		$update_options = $_POST['adminArray']; 

		foreach($update_options as $key => $value){
			update_option( trim($key), trim($value) );
		}

	echo "<div id=\"message\" class=\"updated fade\"><p><strong>" . __('Your settings have been saved.','cp') . "</strong></p></div>";

	}
?>


<div class="wrap">
<h2><?php _e('ClassiPress','cp')?></h2>
<form method="post" name="classipress" target="_self">

<?php cp_admin_info_box(); ?>
	 
<table style="margin-bottom: 20px;"></table>
<h3 class="title"><?php _e('Settings','cp')?></h3>
     						
<table class="maintable">
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Email Notifications','cp')?></td>
		<td class="forminp">
			
			<select name="adminArray[notif_ad]" style="width: 100px;">
				<option value="yes"<?php if (get_option("notif_ad") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','cp')?></option>
				<option value="no"<?php if (get_option("notif_ad") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','cp')?></option>
			</select><br />
			<small><?php _e('Send an email once a new ad is posted','cp')?></small> 
			
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Show Picture on Front Page','cp')?></td>
		<td class="forminp">
			<select name="adminArray[main_page_img]" style="width: 100px;">
				<option value="yes"<?php if (get_option("main_page_img") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','cp')?></option>
				<option value="no"<?php if (get_option("main_page_img") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','cp')?></option>
			</select><br />
			<small><?php _e('This will show the first uploaded picture from an ad on the front page instead of the category icon.','cp')?></small>
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Allow HTML Code','cp')?></td>
		<td class="forminp">
			<select name="adminArray[filter_html]" style="width: 100px;">
				<option value="no"<?php if (get_option("filter_html") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','cp')?></option>
				<option value="yes"<?php if (get_option("filter_html") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','cp')?></option>
			</select><br />
			<small><?php _e('Gives visitors the ability to use html code in their ads (not recommended).','cp')?></small>
		</td>
	</tr>

	<tr class="mainrow">
		<td class="titledesc"><?php _e('Login Form in Header','cp')?></td>
		<td class="forminp">
			<select name="adminArray[login_form]" style="width: 100px;">
				<option value="yes"<?php if (get_option("login_form") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','cp')?></option>
				<option value="no"<?php if (get_option("login_form") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','cp')?></option>
			</select><br />
			<small><?php _e('Shows a convenient login box in the header of your site','cp')?></small>
		</td>
	</tr>
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Show Report Button','cp')?></td>
		<td class="forminp">
			<select name="adminArray[report_button]" style="width: 100px;">
				<option value="yes"<?php if (get_option("report_button") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','cp')?></option>
				<option value="no"<?php if (get_option("report_button") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','cp')?></option>
			</select><br />
			<small><?php _e('Makes the red flag "Report" button visible in the sidebar on individual ads. Allows visitors to report inappropriate listings.','cp')?></small>
		</td>
	</tr>
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Allow Send Inquiry','cp')?></td>
		<td class="forminp">
			<select name="adminArray[email_form]" style="width: 100px;">
				<option value="yes"<?php if (get_option("email_form") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','cp')?></option>
				<option value="no"<?php if (get_option("email_form") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','cp')?></option>
			</select><br />
			<small><?php _e('This allows visitors to email the author of an ad via a simple sidebar email form.','cp')?></small>
		</td>
	</tr>
	
	<tr class="mainrow">
		<td class="titledesc"><?php _e('Expand Inquiry Form','cp')?></td>
		<td class="forminp">
			<select name="adminArray[expand_email_form]" style="width: 100px;">
				<option value="yes"<?php if (get_option("expand_email_form") == "yes") { echo ' selected="selected"'; } ?>><?php _e('Yes','cp')?></option>
				<option value="no"<?php if (get_option("expand_email_form") == "no") { echo ' selected="selected"'; } ?>><?php _e('No','cp')?></option>
			</select><br />
			<small><?php _e('This option lets you change the default state of the simple sidebar email form (only applies if "Allow Send Inquiry" is enabled). Setting to "No" will then require visitors to first click a link before seeing the form.','cp')?></small>
		</td>
	</tr>
	

</table>

<p class="submit"><input name="submitted" type="hidden" value="yes" /><input type="submit" name="Submit" value="<?php _e('Save changes','cp')?>" /></p>

</div>

<?php  } // process new ads
function classi_images() {
?>

<div class="wrap">
<h2><?php _e('ClassiPress','cp')?></h2>

<?php cp_admin_info_box(); ?>

<table style="margin-bottom: 20px;"></table>
<h3 class="title"><?php _e('Images','cp')?></h3> <p>&nbsp;<?php _e('Below you can view and delete the images users have uploaded.','cp')?></p>
     						
<table class="maintable">

	<?php 
	$delete_file = strip_tags($_GET['delete']);
	if ( $delete_file != "" ) {
		$delete_file = "../wp-content/uploads/classipress/".$delete_file;
		unlink($delete_file);
		echo "<div class='del_image'>" . __('The image has been deleted','cp') . "</div>";
	} ?>

<div class="classipress_images">
<?php
$image_url = get_bloginfo('template_url')."/includes/img_resize.php?width=100&height=100&url=";
$image_url2 = get_bloginfo('template_url');

if ($handle = opendir('../wp-content/uploads/classipress')) {
    // List all the files
    while (false !== ($file = readdir($handle))) {
        if ( $file == "." || $file == ".." ) {
        } else {
        	$size = filesize("../wp-content/uploads/classipress/".$file);
        	$size = $size / 1024;
        	$size = round($size)."Kb";
        ?>
        	<div class="oneimage-box">
        		<?php echo $file; ?><br />
        		<b><?php echo $size; ?></b>
        		<div class="oneimage" style="background: #EAF3FA url(<?php echo $image_url."$file"; ?>) center no-repeat;">
        			<a href="<?php echo "admin.php?page=images&delete=".$file; ?>#images"><img src="<?php bloginfo('template_url'); ?>/images/delete.png" align="right" title="<?php _e('Delete Image','cp')?>" alt="<?php _e('Delete Image','cp')?>" /></a>
        			<div style="clear: both; height: 5px;"></div>
					<a target="_blank" href="../wp-content/uploads/classipress/<?php echo $file; ?>"><img src="<?php bloginfo('template_url'); ?>/images/image.png" align="right" title="<?php _e('View Image','cp')?>" alt="<?php _e('View Image','cp')?>" /></a>
        		<div style="clear: both;"></div>
        		</div>
        	</div>
        	<?php
        }
    }

    closedir($handle);
}
?>
</div>

</table>


<?php  } ?>