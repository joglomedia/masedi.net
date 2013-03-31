<script type="text/javascript">
	jQuery(document).ready(function(){
		var height = jQuery(".the_content_box").outerHeight(true);
		jQuery(".the_content_box").parent().css("min-height",height);
	});
</script>
<div id="popup_domination_container" class="has-left-sidebar">
	<div class="mainbox" id="popup_domination_tab_look_and_feel" style="width:98%;">
		<h3 class="title topbar icon feel" style="margin-top:0px !important;"><span>Installation Complete</span></h3>
		<div class="inside twomaindivs">
			<div class="popdom_contentbox the_content_box" style="marhin-left:-50%;">
			<h3  style="margin-top:0px !important;">Next Step</h3>
				<div class="popdom_contentbox_inside">
					<a href="<?php echo $this->install_fin; ?>">Click here to finish setting up.</a>
				</div>
			</div>
			<div class="popdom_contentbox the_help_box">
				<br/>
    			<h3  style="margin-top:0px !important;">Help</h3>
    			<div class="popdom_contentbox_inside">
    				<p>With the new update of Wordpress to version 3.2, we recommend making sure you browser is up-to-date. To do this, head over to: <a hrfe="http://browsehappy.com/">http://browsehappy.com/</a> to make sure your browser is the latest version.</p>
        			<p>Make sure to head over to you support area if you have any problems</p>
       				<p><a href="https://popdom.assistly.com/">Click Here to get there</a></p>
       				<p>You can also contact us directly there too.</p>
    			</div>
    		</div>
   			<div class="clear"></div>
		</div>
	</div>
</div>