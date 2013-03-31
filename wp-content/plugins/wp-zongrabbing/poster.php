<?php
/*
 * Encoded script is not really secure, Just give us your code and we'll appreciate your great job! :D
 */
?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br /></div>
<h2>WP ZonGrabbing Poster</h2>
<div class="updated">
<p><strong>WARNING! You're using NULLED version of WP ZonGrabbing v1.1. Use this work at your own risk!!!</strong><br />
<strong>DISCLAIMER:</strong> I Cracked this plugin just for fun - Not for commercial use :D. I'd highly recommend you to BUY the FULL Version to support the plugin development!</p>
<p>WP ZonGrabbing v1.1 NULL3D by Street.Walker<br /><strong>Need help to decode your encoded PHP script/plugin/theme file? Just drop me a message at escendolijo (at) yahoo (dot) com</strong></p>
</div>
<?php
	// settings_errors();
	if (get_option('cmt_message')) echo get_option('cmt_message');
	$ready = 1;
	$errorMessage = '';
	if (!get_option('cmt_amazon_access_key')) {
		$errorMessage .= '<p>Amazon Access Key is not found. Please input your Amazon Access Key on the <strong>WP ZonGrabbing Settings</strong> menu.</p>';
	}
	if (!get_option('cmt_amazon_secret_key')) {
		$errorMessage .= '<p>Amazon Secret Key is not found. Please input your Amazon Secret Key on the <strong>WP ZonGrabbing Settings</strong> menu.</p>';
	}
	if (!get_option('cmt_amazon_associate_tag')) {
		$errorMessage .= '<p>Amazon Associate Tag is not found. Please input your Amazon Associate Tag on the <strong>WP ZonGrabbing Settings</strong> menu.</p>';
	}
	if ($errorMessage) {
		echo '<div class="error">'.$errorMessage.'</div>';
		$ready = 0;
	}

	$asins = cmt_remove_duplicate(get_option('cmt_asins'));
	update_option('cmt_asins', $asins);
	$usedAsins = cmt_remove_duplicate(get_option('cmt_used_asins'));
	update_option('cmt_used_asins', $usedAsins);
	$failedAsins = cmt_remove_duplicate(get_option('cmt_failed_asins'));
	update_option('cmt_failed_asins', $failedAsins);

?>
<form method="post" action="options.php">
	<?php settings_fields( 'cmt-poster-group' ); ?>
	<table class="form-table">
		<tr valign="top">
			<th scope="row"><label for="startDate">Start date ( <span class="description">yyyy-mm-dd</span> )</label></th>
			<td>
				<input type="text" class="code" id="startDate" name="startDate" value="<?php echo date('Y-m-d'); ?>" style="text-align:center;" />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="cmt_max_posts">How many posts</label></th>
			<td>
				<input type="text" class="small-text code" id="cmt_max_posts" name="cmt_max_posts" value="<?php echo get_option('cmt_max_posts'); ?>" style="text-align:center;" />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><label for="cmt_min_posts_per_day">Posts / day</label></th>
			<td>
				<input type="text" class="small-text code" id="cmt_min_posts_per_day" name="cmt_min_posts_per_day" value="<?php echo get_option('cmt_min_posts_per_day'); ?>" style="text-align:center;" /> -
				<input type="text" class="small-text code" id="cmt_max_posts_per_day" name="cmt_max_posts_per_day" value="<?php echo get_option('cmt_max_posts_per_day'); ?>" style="text-align:center;" />
			</td>
		</tr>
		<tr>
			<th class="th-full" colspan="2" scope="row">
				<label for="cmt_post_again"><input type="checkbox" id="cmt_post_again" name="cmt_post_again"<?php if(get_option('cmt_post_again') == 'on') echo ' checked'; ?>> Post again already used ASINs</label>
			</th>
		</tr>
		<tr>
			<th class="th-full" colspan="2" scope="row">
				<label for="cmt_save_as_draft"><input type="checkbox" id="cmt_save_as_draft" name="cmt_save_as_draft"<?php if(get_option('cmt_save_as_draft') == 'on') echo ' checked'; ?>> Save as draft</label>
			</th>
		</tr>
		<tr>
			<th class="th-full" colspan="2" scope="row">
				<label for="cmt_upload_images"><input type="checkbox" id="cmt_upload_images" name="cmt_upload_images"<?php if(get_option('cmt_upload_images') == 'on') echo ' checked'; ?>> Upload images</label>
			</th>
		</tr>
	</table>
	<table class="form-table">
		<tr>
			<td>
				<h3><label for="cmt_asins">Input ASINs</label></h3>
				<textarea class="large-text code" id="cmt_asins" name="cmt_asins" rows="15"><?php echo $asins; ?></textarea>
			</td>
			<td>
				<h3><label for="cmt_used_asins">Used ASINs</label></h3>
				<textarea class="large-text code" id="cmt_used_asins" name="cmt_used_asins" rows="15"><?php echo $usedAsins; ?></textarea>
			</td>
			<td>
				<h3><label for="cmt_failed_asins">Failed ASINs</label></h3>
				<textarea class="large-text code" id="cmt_failed_asins" name="cmt_failed_asins" rows="15"><?php echo $failedAsins; ?></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="3"><p class="description">One ASIN per line.</p></td>
		</tr>
	</table>
	<p class="submit">
		<input type="submit" class="button-primary" name="submit" value="Update ASINs" />
		<?php if ($ready == 1) echo '<input type="submit" class="button-primary" name="submit" value="Grab and Post" />'; ?>
	</p>
</form>
</div>
<?php
	update_option('cmt_message', '');
?>