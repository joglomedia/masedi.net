<?php
/*
* page.php
*
* Main page which holds all the information for the Theme Uploader option
*/
?>
<div class="noscript">
	<span>You may have javascript disabled or have an ad blocker present. You must turn on javascript and disable the ad blocker to ensure the plugin works correctly.</span>
</div>
<div class="wrap with-sidebar" id="popup_domination">
	<?php
	$header_link = 'Back to Campaign Management';
	$header_url = 'admin.php?page=popup-domination/campaigns';
	include $this->plugin_path.'tpl/header.php';
	?>
	<div style="display:none" id="popup_domination_hdn_div"><?php echo $fields?></div>
	<div class="clear"></div>
	<div id="popup_domination_container" class="has-left-sidebar">
		<div style="display:none" id="popup_domination_hdn_div2"></div>
		
		<?php include $this->plugin_path.'tpl/theme_uploader/tabs.php'; ?>
		
		<div class="notices" style="display:none;">
			<p class="message"></p>
		</div>
		<div class="flotation-device">
			<div class="mainbox" id="popup_domination_tab_promote">
				<div class="inside twodivs">
					<div class="popdom_contentbox the_help_box">
						<h3 class="help">Help</h3>
						<div class="popdom_contentbox_inside">
							<p>Please make sure you have either "755" or "777" Premissions set on both the "Themes" folder and the "TMP" folder within the PopUp Domination plugin folder</p>
						</div>
						<div class="clear"></div>
					</div>
					<div class="popdom-inner-sidebar">
						<div class="postbox">
							<div class="popdom_contentbox the_content_box">
	                		<h3>Theme Uploader</h3>
	                		<div class="popdom_contentbox_inside">
								<div id="file-uploader-demo1">		
									<noscript>			
										<p>Please enable JavaScript to use file uploader.</p>
									</noscript>         
								</div>
							</div>
							<div class="clear"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	 </div>
	<?php
	include $this->plugin_path.'tpl/footer.php'; ?>
</div>