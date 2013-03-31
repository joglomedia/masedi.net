<div class="mainbox" id="popup_domination_tab_schedule">
	<div class="popdom_contentbox the_help_box">
		<h3 class="help">Help</h3>
		<div class="popdom_contentbox_inside">
			<p><strong>Reset Your Cookies to test the popup on your live website again.</strong></p>
			<p><a href="#clear" class="button">Clear my cookie</a> <img class="waiting" style="display:none;" src="images/wpspin_light.gif" alt="" /></p>
			<p><strong>On Website Load:</strong> The popup will appear as soon as the webpage has been fully loaded by the user's browser.</p>
			<p><strong>When mouse leaves the browser viewport:</strong> The popup will appear when the user's mouse enters the address back area. This option in great for when you want the popup to appear when the user tried to leave your website, but won't appear when they click on links on your website.</p>
			<p style="margin-right:15px;"><strong>When the user tries to leave the page:</strong> The popup will appear when ever the user clicks on a link or attempts to leave the page. If you have many links to different parts of your site, we don't recommend this setting.
			This setting also makes an alert box appear before the popup appears. The user will have to click the "Stay On Page" option in the alert box <strong>before</strong> the popup will appear.
			</p>
			<p><strong>Example:</strong></p>
			<img src="<?php echo $this->plugin_url;?>css/images/alert.png" height="178" width="582" alt="" />
			<p>If you are experiencing problems with your popup, please have a look at our help articles at:</p>
			<p><a href="https://popdom.assistly.com/">our Assistly Help Area.</a></p>
		</div>
	</div>
	<div class="inside twomaindivs">
		<div class="the_content_box">
			<div class="popdom_contentbox" style="margin-left:0px;">
				<div class="popdom_contentbox_inside schedule_tab">
					<h3>When the close button is clicked, how long should it be before the lightbox is shown again?</h3>
					<span class="exmaple">Please specify in days - e.g. 7. The minimal amount is 1, entering 0 will not make the popup work correctly.</span>
					<input type="text" name="popup_domination[cookie_time]" value="<?php if(isset($campaign['schedule']['cookie_time'])){echo intval($campaign['schedule']['cookie_time']);}else{echo '7';} ?>" /> 
					<h3>How many times must site page(s) be visited before the popup appears?</h3>
					<span class="exmaple">Note: 1 and 0 will both make the PopUp appear on the first visit.</span>
					<input type="text" name="popup_domination[impression_count]" value="<?php if(isset($campaign['schedule']['impression_count'])){echo $campaign['schedule']['impression_count'];}else{ echo '0';}?>" />
					<ul >
					<li class="show_opts opt_open">
					<h3>What should trigger the popup to display?</h3>
					<p><input type="radio" name="popup_domination[show_opt]" value="open" id="show_opt_open" <?php echo $show_opt == 'open' ? ' checked="checked"':'';?> /> <label for="show_opt_open">On Website page load</label></p>
					<p class="show_opt_open toggle" style="margin-left:25px;<?php echo ($show_opt != 'open') ? 'display:none;' : ''; ?>" >
						How Long should the delay be before the popup appears? (This is in seconds)
						<input type="text" class="open_delay" name="popup_domination[delay]" value="<?php echo floatval($campaign['schedule']['delay']) ?>"<?php echo $show_opt == 'open' ? '':' disabled="disabled"';?> />
					</p>
					</li>
					<li class="show_opts opt_mouselave">
					<p><input type="radio" name="popup_domination[show_opt]" value="mouseleave" id="show_opt_mouseleave" <?php echo $show_opt == 'mouseleave' ? ' checked="checked"':'';?> /> <label for="show_opt_mouseleave">When mouse leaves the browser viewport. (up towards the address bar)</label></p>
					</li>
					<li class="show_opts opt_unload">
					<p><input type="radio" name="popup_domination[show_opt]" value="unload" id="show_opt_unload"<?php echo $show_opt == 'unload' ? ' checked="checked"':'';?> /> <label for="show_opt_unload">When the user tries to leave the page (This option requires a javascript alert box).</label></p>
					<p style="margin-left:25px; <?php echo $show_opt == 'unload' ? '':'display:none';?>" class="show_opt_unload toggle">Javascript alert box text <input type="text" name="popup_domination[unload_msg]" id="popup_domination_unload_msg" value="<?php echo $this->input_val($this->option('unload_msg')) ?>"<?php echo $show_opt == 'unload' ? '' : ' disabled="disabled"';?> disabled="disabled" /></p>
					</li>
					</ul>
					<ul>
						<h3>Do you wish to disable the option to close the popup?</h3>
						<p><input class="close_options close_option_true" type="radio" name="popup_domination[close_option]" value="true" id="close_option_true" <?php echo $campaign['schedule']['close_option'] != 'false' ? ' checked="checked"':'';?> /> <label for="close_option_true">No, user's should be able to exit the popup.</label></p>
						<p><input class="close_options close_options_false" type="radio" name="popup_domination[close_option]" value="false" id="close_option_false" <?php echo $campaign['schedule']['close_option'] == 'false' ? ' checked="checked"':'';?> /> <label for="close_option_false">Yes, user's should be required to opt-in to view the requested page.</label></p>
					</ul>
				</div>
			</div>
			<div class="popdom_contentbox" style="margin-top:20px; margin-left:0px;">
				<h3>What pages do you wish to display PopUp Domination?</h3>
				<div class="popdom_contentbox_inside">
					<?php echo $this->page_list() ?>
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
</div>
