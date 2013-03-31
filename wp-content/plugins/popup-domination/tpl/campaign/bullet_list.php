<div class="mainbox" id="popup_domination_tab_list_items">
	<div class="inside twomaindivs" id="popup_domination_listitems">
		<div class="popdom_contentbox the_help_box">
			<h3 class="help">Help</h3>
			<div class="popdom_contentbox_inside">
				<p>Use the bullets to the left to create a list of points which make your point, argument or product more convincing.</p>
				<p>We have outlined the recommended amount of bullet points per template. Any bullets over this amount, will not be shown on the template.</p>
				<p>Example:</p>
				<img src="<?php echo $this->plugin_url;?>css/images/bullets.png" height="193" width="383" alt="" />
				<p>Make sure to head over to you support area if you have any problems</p>
				<p><a href="https://popdom.assistly.com/">Click Here to get there</a></p>
				<p>You can also contact us directly there too.</p>
			</div>
			<div class="clear"></div>
		</div>
		<div class="popdom_contentbox the_content_box">
			<h3>What are your key points?</h3>
			<div class="popdom_contentbox_inside">
				<p id="list_allowed_size" class="msg">
					<strong>This theme has a limit of <span><?php echo $cur_theme['list_count'] ?></span> check boxes.</strong>
					<br />
					Why is there a limit? We want to help you get the best out of your lightbox. Imposing a limit means that the design will remain beautiful and result in high conversions.
				</p>
				<ul class="list_items">
					<?php echo $listitems?>
				</ul>
				<a href="#addnew" class="grey-btn addnew"><span>Add Another</span></a>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
</div>
