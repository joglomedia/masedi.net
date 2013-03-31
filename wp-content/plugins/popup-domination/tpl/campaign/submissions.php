<div class="mainbox" id="popup_domination_tab_submissions" style="display:none;">
	<div class="popdom_contentbox the_help_box">
		<h3 class="help">Help</h3>
		<div class="popdom_contentbox_inside">
			<p><strong>Set up your campaign with alternative mailing lists.</strong></p>
			<p>If you are experiencing problems with your popup, please have a look at our help articles at:</p>
			<p><a href="https://popdom.assistly.com/">our Assistly Help Area.</a></p>
		</div>
	</div>
	<div class="inside twomaindivs">
		<div class="the_content_box">
			<div class="popdom_contentbox" style="margin-left:0px;">
				<div class="popdom_contentbox_inside submissions_tab">
					<h3>Please select the Mailing List you would like to configure the pop up with</h3>
					<span class="note">You will need to select a mailing list before you can start receiving opt-ins.</span><br />
					<?php echo $this->get_mailing_lists(); ?>
					
					<ul>
						<h3>Would you like this to submit to a new window or tab?</h3>
						<li><p><input type="radio" id="submit_new_window" name="popup_domination[mailing_option][new_window]" value="true" <?php echo ($mailing['new_window'] == 'true') ? 'checked="checked"': ''; ?> /><label for="submit_new_window">Yes</label></p></li>
						<li><p><input type="radio" id="submit_same_window" name="popup_domination[mailing_option][new_window]" value="false" <?php echo ($mailing['new_window'] == 'false') ? '': 'checked="checked"'; ?> /><label for="submit_new_window">No</label></p></li>
					</ul>
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
