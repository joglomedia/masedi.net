<?php if ( !defined('ABSPATH') ) die('No direct access');
$opl = get_option('opl_settings');
?>
<div class="wrap">
	<div id="optinlite-admin-header">InstaBuilder</div>
	<div id="optinline-links-holder">
		<ul id="optinlite_links">
			<li><a href="http://instabuilder.com/faq" target="_blank">F.A.Q</a></li>
			<li><a href="http://instabuilder.com/trainingvideos" target="_blank">Training Videos</a></li>
			<li><a href="http://asksuzannatheresia.com" target="_blank">Support</a></li>
			<li><a href="http://instabuilder.com/affiliates" target="_blank">Make Money Now!</a></li>
		</ul>
		<div style="clear:left"></div>
	</div>

	<?php if ( opl_isset($_GET['saved']) == 'true' ) echo '<div class="updated fade"><p><strong>InstaBuilder Settings Updated.</strong></p></div>'; ?>
	<form method="post" action="<?php echo admin_url('admin.php?page=opl-settings'); ?>">
	<h3>General Settings</h3>
	<table class="form-table">
	<tr valign="top">
		<th scope="row">Powered Link</th>
		<td><label for="disable_powered">
		<input name="disable_powered" type="checkbox" id="disable_powered" value="1" <?php if ( opl_isset($opl['disable_powered']) == 1 ) echo 'checked="checked"'; ?> />
		Disable "Powered By InstaBuilder" link on the footer</label>
		</td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="aff_url">InstaBuilder Affiliate URL</label></th>
		<td><input name="aff_url" type="text" id="aff_url" value="<?php echo stripslashes(opl_isset($opl['aff_url'])); ?>" class="regular-text" />
		<p><span class="description">If you choose to display the "Powered By" link, then you can replace<br />the default URL with your InstaBuilder Affiliate's URL (so you can earn some cash too!).</span></p></td>
	</tr>
	</table>

	<h3>Facebook Settings</h3>
	<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="fb_appid">Facebook App ID</label></th>
		<td><input name="fb_appid" type="text" id="fb_appid" value="<?php echo stripslashes(opl_isset($opl['fb_appid'])); ?>" class="regular-text" />
		<p><span class="description">If you want to use the Facebook integration feature in InstaBuilder, please enter your <a href="https://developers.facebook.com/apps" target="_blank">Facebook Application ID</a> here. If you don't have one,<br />you can create it <a href="https://developers.facebook.com/apps" target="_blank">here</a> (please refer to video training for more information).</span></p></td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="fb_secret">Facebook App Secret</label></th>
		<td><input name="fb_secret" type="text" id="fb_secret" value="<?php echo stripslashes(opl_isset($opl['fb_secret'])); ?>" class="regular-text" />
		<p><span class="description">If you want to use the Facebook Page Tab integration feature in InstaBuilder, please enter your <a href="https://developers.facebook.com/apps" target="_blank">Facebook Secret Key</a> here. If you don't have one,<br />you can create it <a href="https://developers.facebook.com/apps" target="_blank">here</a> (please refer to video training for more information).</span></p></td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="fb_tab_url">Facebook Page Tab URL</label></th>
		<td><input type="text" id="fb_tab_url" value="<?php echo opl_format_url(get_bloginfo('siteurl'), 'mode=facebook_tab'); ?>" class="regular-text" readonly />
		<p><span class="description">Use the URL above when setting up a Facebook Page Tab application.</span></p></td>
	</tr>
	<?php if ( opl_isset($opl['fb_appid']) != '' ) : ?>
	<tr valign="top">
		<th scope="row"></th>
		<td><a href="https://www.facebook.com/dialog/pagetab?app_id=<?php echo $opl['fb_appid']; ?>&next=<?php echo opl_format_url(get_bloginfo('siteurl'), 'mode=facebook_tab'); ?>" class="button" target="_blank">Add Facebook Tab</a>
		</td>
	</tr>
	<?php endif; ?>
	</table>
	
	<h3>Disqus Settings</h3>
	<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="dq_short">Your Disqus Shortname</label></th>
		<td><input name="dq_short" type="text" id="dq_short" value="<?php echo stripslashes(opl_isset($opl['dq_short'])); ?>" class="regular-text" />
		<p><span class="description">If you want to use Disqus comments feature in InstaBuilder, please enter your <a href="http://disqus.com" target="_blank">Disqus</a> shortname here.</span></p></td>
	</tr>
	</table>

	<h3>Twitter Settings</h3>
	<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="tw_consumer_key">Twitter Consumer Key</label></th>
		<td><input name="tw_consumer_key" type="text" id="tw_consumer_key" value="<?php echo stripslashes(opl_isset($opl['tw_consumer_key'])); ?>" class="regular-text" />
		<p><span class="description">If you want to use the Twitter integration feature in InstaBuilder, please enter your <a href="https://dev.twitter.com/apps" target="_blank">Twitter Application</a> Consumer Key here. If you don't have one,<br />you can create it <a href="https://dev.twitter.com/apps" target="_blank">here</a> (please refer to video training for more information).</span></p></td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="tw_consumer_secret">Twitter Consumer Secret</label></th>
		<td><input name="tw_consumer_secret" type="text" id="tw_consumer_secret" value="<?php echo stripslashes(opl_isset($opl['tw_consumer_secret'])); ?>" class="regular-text" />
		<p><span class="description">If you want to use the Twitter integration feature in InstaBuilder, please enter your <a href="https://dev.twitter.com/apps" target="_blank">Twitter Application</a> Consumer Secret here. If you don't have one,<br />you can create it <a href="https://dev.twitter.com/apps" target="_blank">here</a> (please refer to video training for more information).</span></p></td>
	</tr>
	</table>
	<p class="submit">
		<input type="submit" name="submit" id="submit" class="button-primary" value="Update Settings" />
		<input type="hidden" name="action" value="save_opl_settings" />
	</p>
	</form>
</div><!-- wrap -->