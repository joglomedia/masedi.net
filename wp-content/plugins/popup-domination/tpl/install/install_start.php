<script type="text/javascript">
	jQuery(document).ready(function(){
		var height = jQuery(".the_content_box").outerHeight(true);
		jQuery(".the_content_box").parent().css("min-height",height);
	});
</script>
<div id="popup_domination_container" class="has-left-sidebar">
	<div class="mainbox" id="popup_domination_tab_look_and_feel" style="width:98%;">
		<h3 class="title topbar icon feel" style="margin-top:0px !important;"><span>Form Configuration</span></h3>
		<div class="inside twomaindivs">
			<div class="popdom_contentbox the_content_box" style="marhin-left:-50%;">
			<h3  style="margin-top:0px !important;">Enter Order Number</h3>
				<div class="popdom_contentbox_inside">
					<form action="http://popupdomination.com/activate/activate.php" method="post">
						<?php $protocol = ($_SERVER['HTTPS']=='on') ?'https':'http';
						$port = ($_SERVER['SERVER_PORT'] == '80')? '' : ':'.$_SERVER['SERVER_PORT'];
						$url = $protocol. '://' . $_SERVER['HTTP_HOST'] . $port . $_SERVER['REQUEST_URI']; ?>
						<input type="hidden" name="url" value="<?php echo $url; ?>" />
						<label for="receipt">Order Number: <input type="text" name="receipt_key" id="receipt" /></label>
						<input type="submit" name="submit" value="Submit" />
						<input type="hidden" name="action" value="check-receipt" /><?php echo wp_nonce_field('check-receipt', '_wpnonce', true , false); ?>
					</form>
				</div>
			</div>
			<div class="popdom_contentbox the_help_box">
    			<h3  style="margin-top:0px !important;">Help</h3>
    			<div class="popdom_contentbox_inside">
        			<p>To find your order number from clickbank, see the image below:</p><br/>
                   	<img src="http://f.cl.ly/items/0R2x1s3p3k3N1s213Y2g/Screen%20shot%202011-01-08%20at%2016.22.48.png" width="558" height="475" alt="" /><br/><br/>
                   	<p>If you are still having problems, head over to our help area where there are help articles:</p>
                   	<p><a href="https://popdom.assistly.com/">Click Here to get there</a></p>
                   	<p>You can also contact us directly there too</p>
    			</div>
    		</div>
   			<div class="clear"></div>
		</div>
	</div>
</div>