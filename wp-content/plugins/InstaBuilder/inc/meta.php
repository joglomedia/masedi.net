<?php if ( !defined('ABSPATH') ) die('No direct access');
add_action( 'admin_menu', 'opl_add_meta_box' );
function opl_add_meta_box() {
	if ( !function_exists( 'add_meta_box' ) )
		return;

	add_meta_box( 'opl-meta-box-page', 'InstaBuilder Settings', 'opl_meta_settings', 'page', 'normal', 'high' );
}

function opl_default_order() {
$default_buy = '
	<h2 style="text-align: center;"><span class="opl-shadow-dark" style="font-family: Ubuntu,sans-serif; color: #cc0000;">Yes, I Want Instant Access</span></h2>
	<p style="text-align: center;"><span style="font-family: Ubuntu,sans-serif;"><strong>Regular Price <del>$197</del> $97</strong></span></p>
	<p style="text-align: center;"><img src="' . OPL_URL . '/images/buttons/big-yellow-addtocart.png" alt="" border="0" /></p>
	<p style="text-align: center;"><small>All Major Credit Cards and Paypal Are Accepted</small></p>
 ';
 
 return $default_buy;
}

function opl_default_viral_content() {
$default_content = '
	<h2 style="text-align: center;"><span class="opl-shadow-dark" style="font-family: Ubuntu,sans-serif; color: #990000;">Special Unadvertised Bonus</span></h2>
	<p style="text-align: center;"><span style="font-family: Ubuntu,sans-serif; color: #808080;"><strong>Get FREE access to my VIP Video Training (<span style="padding: 0pt 4px; background-color: #fdf957;">$97 value</span>). Other people have to pay $197 to access this product, but you can get it FREE!"</strong></span></p>
	<p style="text-align: center;"><span style="font-family: Ubuntu,sans-serif;">All you have to do is to share my site on Facebook or Twitter, and the download link below will be unlocked.</span></p>
 ';
 
 return $default_content;
}

function opl_meta_launch( $post ) {
	$value = get_post_meta($post->ID, 'opl_settings', true);
	$launch = opl_isset($value['launch']);
	$items = opl_isset($launch['items']);
	$item_num = ( is_array($items) ) ? count($items) : 2;
	//opl_dump($items);
?>
	<ul id="opl-meta">
		<li class="opl-property">
			<label for="opl_launchbar_pos"><?php _e('Launch Nav Position', 'opl'); ?></label>
			<select name="opl_launchbar_pos" id="opl_launchbar_pos" class="widefat">
				<option value="top"<?php if ( opl_isset($launch['launchbar_pos']) == 'top' ) echo ' selected="selected" '; ?>>Top (side-by-side with video)</option>
				<option value="bottom"<?php if ( opl_isset($launch['launchbar_pos']) == 'bottom' ) echo ' selected="selected" '; ?>>Bottom (side-by-side with content)</option>
			</select>
			<div class="opl-desc"><?php _e('Choose where you want to display the launch sidebar navigation.', 'opl'); ?></div>
			<div class="opl-hr"></div>
		</li>
		<li>
			<h2 class="opl-tab-title" style="margin-right:0;margin-left:0;">Launch Navigation Items</h2>
			<div id="opl-launch-items">
			<?php if ( is_array($items) ) { $i = 0; ?>
			<?php foreach ( $items as $item ) : $i++; ?>
				<ul id="opl-meta" style="margin:0;padding:0">
				<li class="opl-property">
					<?php if ( $i > 1 ) : ?><div style="float:right"><a href="#" class="remove-launch-item" title="Remove this item"><img src="<?php echo OPL_URL; ?>images/delete.png" border="0" title="Remove this item" /></a></div><?php endif; ?>
					<label for="opl_launch_text"><?php printf(__('Title #%s', 'opl'), $i); ?></label>
					<input class="widefat" type="text" name="opl_launch_item[<?php echo $i; ?>][title]" id="opl_launch_text" value="<?php echo stripslashes(opl_isset($item['title'])); ?>" />
				</li>
				<li class="opl-property">
					<label for="opl_launch_thumb"><?php printf(__('Thumb/Image URL #%s', 'opl'), $i); ?></label>
					<input type="text" name="opl_launch_item[<?php echo $i; ?>][thumb]" id="opl_launch_thumb" value="<?php echo stripslashes(opl_isset($item['thumb'])); ?>" class="widefat uploaded_url" style="width:75%;" />
					<span id="opl_<?php echo $i; ?>_upload-btn" class="opl_upload_button button">Upload Image</span>
				</li>
				<li class="opl-property">
					<label for="opl_launch_page"><?php printf(__('Link To Page #%s', 'opl'), $i); ?></label>
					<select name="opl_launch_item[<?php echo $i; ?>][page]" id="opl_launch_page" class="widefat">
						<option value=''>[ -- Select Page -- ]</option>
						<option value='unreleased'<?php if ( opl_isset($item['page']) == 'unreleased' ) echo ' selected="selected"'; ?>>-- UNRELEASED --</option>
						<?php if ( get_pages() ) :
							foreach ( get_pages() as $page ) :
								$selected = ( opl_isset($item['page']) == $page->ID ) ? ' selected="selected" ' : '';
								echo '<option value="' . $page->ID . '"' . $selected . '>' . $page->post_title . '</option>';
							endforeach; endif;
						?>
					</select>
					<div class="opl-desc"><?php _e('Set the launch item\'s title, image/thumb, and choose the destination page. If the next launch sequence isn\'t ready or unreleased, then simply choose "UNRELEASED" in the page option above.', 'opl'); ?></div>
					<div class="opl-hr"></div>
				</li>
			</ul>
			<?php endforeach; ?>
			<?php } else { ?>
			<ul id="opl-meta" style="margin:0;padding:0">
				<li class="opl-property">
					<label for="opl_launch_text"><?php _e('Title #1', 'opl'); ?></label>
					<input class="widefat" type="text" name="opl_launch_item[1][title]" id="opl_launch_text" value="" />
				</li>
				<li class="opl-property">
					<label for="opl_launch_thumb"><?php _e('Thumb/Image URL #1', 'opl'); ?></label>
					<input type="text" name="opl_launch_item[1][thumb]" id="opl_launch_thumb" value="" class="widefat uploaded_url" style="width:75%;" />
					<span id="opl_1_upload-btn" class="opl_upload_button button">Upload Image</span>
				</li>
				<li class="opl-property">
					<label for="opl_launch_page"><?php _e('Link To Page #2', 'opl'); ?></label>
					<select name="opl_launch_item[1][page]" id="opl_launch_page" class="widefat">
						<option value=''>[ -- Select Page -- ]</option>
						<option value='unreleased'>-- UNRELEASED --</option>
						<?php if ( get_pages() ) :
							foreach ( get_pages() as $page ) :
								//$selected = ( opl_isset($optin['smart_page']) == $page->ID ) ? ' selected="selected" ' : '';
								echo '<option value="' . $page->ID . '"' . $selected . '>' . $page->post_title . '</option>';
							endforeach; endif;
						?>
					</select>
					<div class="opl-desc"><?php _e('Set the launch item\'s title, image/thumb, and choose the destination page. If the next launch sequence isn\'t ready or unreleased, then simply choose "UNRELEASED" in the page option above.', 'opl'); ?></div>
					<div class="opl-hr"></div>
				</li>
			</ul>
			<?php } ?>
			</div>
			<input type="hidden" id="opl-launch-num" value="<?php echo $item_num; ?>" />
			<p style="text-align:right"><input type="button" class="button-primary opl-add-launch" value="Add New Item" /> <img src="<?php echo OPL_URL; ?>images/ajax-loader.gif" border="0" class="launch-item-loader" style="vertical-align:middle; display:none" /></p>
		</li>
	</ul>
<?php
}

function opl_meta_mobile( $post ) {
	$value = get_post_meta($post->ID, 'opl_settings', true);
	$mobile = opl_isset($value['mobile']);
?>
	<ul id="opl-meta">
		<li>
			<label for="opl_mobilesw" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_mobilesw" id="opl_mobilesw" value="1"<?php if ( opl_isset($mobile['mobilesw']) == 1 ) echo ' checked="checked" '; ?> /> <span class="opl-desc"><code><?php _e('Enable Mobile Page Redirection', 'opl'); ?></code></span></label><br />
			<div class="opl-desc"><?php _e('You can enable this option if you want visitors who view this page using mobile devices to be redirected to a special page.', 'opl'); ?></div>
			<div class="opl-hr"></div>
		</li>
		<li>
			<label for="opl_mobilesw_dest"><?php _e('Mobile Destination Page', 'opl'); ?></label>
			<select name="opl_mobilesw_dest" id="opl_mobilesw_dest" class="widefat">
				<option value=''>[ -- Select Destination Page -- ]</option>
				<?php if ( get_pages() ) :
					foreach ( get_pages() as $page ) :
						$selected = ( opl_isset($mobile['mobilesw_dest']) == $page->ID ) ? ' selected="selected" ' : '';
						echo '<option value="' . $page->ID . '"' . $selected . '>' . $page->post_title . '</option>';
					endforeach; endif;
				?>
			</select>
			<div class="opl-desc"><?php _e('Please choose a page where you want to redirect the visitors who are using mobile devices.', 'opl'); ?></div>
			<div class="opl-hr"></div>
		</li>
		<li>
			<label for="opl_mobilesw_notablet" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_mobilesw_notablet" id="opl_mobilesw_notablet" value="1"<?php if ( opl_isset($mobile['mobilesw_notablet']) == 1 ) echo ' checked="checked" '; ?> /> <span class="opl-desc"><code><?php _e('Do NOT redirect visitors who are using tablet devices (e.g. iPad, Playbook, etc)', 'opl'); ?></code></span></label><br />
			<div class="opl-hr"></div>
		</li>
	</ul>
<?php
}
	
function opl_meta_viral( $post ) {
	$value = get_post_meta($post->ID, 'opl_settings', true);
	$viral = opl_isset($value['viral']);
?>
	<ul id="opl-meta">
	<li class="opt-property">
		<label for="oplviralcontent"><?php _e('Viral Download Content', 'opl'); ?></label>
		<?php if ( post_type_supports('page', 'editor') ) : ?>
			<?php $viral_content = ( isset($viral['content']) ) ? $viral['content'] : opl_default_viral_content(); ?>
        	<?php wp_editor($viral_content, 'oplviralcontent', array('textarea_name' => 'opl_viral_content') ); ?>
		<?php endif; ?>
		<div class="opl-desc"><?php _e('Enter a compelling content for your Viral Download section to entice your audience to share your site/offer.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label><?php _e('Viral Sharing Options', 'opl'); ?></label>
		<label for="opl_viral_fb" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_viral_fb" id="opl_viral_fb" value="1"<?php if ( opl_isset($viral['viral_fb']) == 1 ) echo ' checked="checked" '; ?><?php if ( !isset($viral['viral_fb']) ) echo ' checked="checked" '; ?> /> <span class="opl-desc"><code><?php _e('Facebook', 'opl'); ?></code></span></label><br />
		<label for="opl_viral_tw" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_viral_tw" id="opl_viral_tw" value="1"<?php if ( opl_isset($viral['viral_tw']) == 1 ) echo ' checked="checked" '; ?><?php if ( !isset($viral['viral_tw']) ) echo ' checked="checked" '; ?> /> <span class="opl-desc"><code><?php _e('Twitter', 'opl'); ?></code></span></label><br />
		<div class="opl-desc"><?php printf(__('<strong>Note</strong>: Make sure you already set the Facebook and Twitter integration in <a href="%s" target="_blank">InstaBuilder -> Settings</a>.', 'opl'), admin_url('admin.php?page=opl-settings')); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-fb-viral">
		<label for="opl_viral_fburl"><?php _e('Facebook Share :: URL To Share', 'opl'); ?></label>
		<input class="widefat" type="text" name="opl_viral_fburl" id="opl_viral_fburl" value="<?php if ( isset($viral['viral_fburl']) ) echo stripslashes(opl_isset($viral['viral_fburl'])); else echo get_permalink($post->ID); ?>" />
		<div class="opl-desc"><?php _e('Enter a URL that you want to share on Facebook when someone click the share button.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-fb-viral">
		<label for="opl_viral_fbtitle"><?php _e('Facebook Share :: Share Title', 'opl'); ?></label>
		<input class="widefat" type="text" name="opl_viral_fbtitle" id="opl_viral_fbtitle" value="<?php if ( isset($viral['viral_fbtitle']) ) echo stripslashes(opl_isset($viral['viral_fbtitle'])); else echo $post->post_title; ?>" />
		<div class="opl-desc"><?php _e('Enter a title about the URL that is going to be shared on Facebook.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-fb-viral">
		<label for="opl_viral_fbdesc"><?php _e('Facebook Share :: Short Description', 'opl'); ?></label>
		<textarea name="opl_viral_fbdesc" id="opl_viral_fbdesc" class="widefat" style="height:60px"><?php echo stripslashes(opl_isset($viral['viral_fbdesc'])); ?></textarea>
		<div class="opl-desc"><?php _e('Enter a short description about the URL that is going to be shared on Facebook.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-fb-viral">
		<label for="opl_viral_fbimg"><?php _e('Facebook Share :: Image URL (optional)', 'opl'); ?></label>
		<input type="text" name="opl_viral_fbimg" id="opl_viral_fbimg" value="<?php echo opl_isset($viral['viral_fbimg']); ?>" class="widefat uploaded_url" style="width:75%;" />
		<span id="opl_fbimg_upload-btn" class="opl_upload_button button">Upload Image</span>
		<div class="opl-desc"><?php _e('Optionally, you can include a small image to be shared on Facebook, along with the URL. Enter the URL of the image, or click "Upload Image" to upload.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-tw-viral">
		<label for="opl_viral_tweet"><?php _e('Twitter Share :: Tweet Message', 'opl'); ?></label>
		<textarea name="opl_viral_tweet" id="opl_viral_tweet" class="widefat" style="height:60px"><?php echo stripslashes(opl_isset($viral['viral_tweet'])); ?></textarea>
		<div class="opl-desc"><?php _e('Enter a message that will be twitted when someone click the share button.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label for="opl_viral_download"><?php _e('Download URL', 'opl'); ?></label>
		<input class="widefat" type="text" name="opl_viral_download" id="opl_viral_download" value="<?php echo stripslashes(opl_isset($viral['viral_download'])); ?>" />
		<div class="opl-desc"><?php _e('Please enter a valid download URL (must include http://). This can be a direct link to the file or to a download page, which contain the actual download link to the file.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label for="opl_viral_btnclr"><?php _e('Download Button Color', 'opl'); ?></label>
		<select name="opl_viral_btnclr" id="opl_viral_btnclr" class="widefat">
			<option value="yellow"<?php if ( stripslashes(opl_isset($viral['viral_btnclr'])) == 'yellow' ) echo ' selected="selected" '; ?>>Yellow</option>
			<option value="orange"<?php if ( stripslashes(opl_isset($viral['viral_btnclr'])) == 'orange' ) echo ' selected="selected" '; ?>>Orange</option>
			<option value="red"<?php if ( stripslashes(opl_isset($viral['viral_btnclr'])) == 'red' ) echo ' selected="selected" '; ?>>Red</option>
			<option value="green"<?php if ( stripslashes(opl_isset($viral['viral_btnclr'])) == 'green' ) echo ' selected="selected" '; ?>>Green</option>
			<option value="blue"<?php if ( stripslashes(opl_isset($viral['viral_btnclr'])) == 'blue' ) echo ' selected="selected" '; ?>>Blue</option>
		</select>
		<div class="opl-desc"><?php _e('Select a color for the download button.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label for="opl_viral_btntxt"><?php _e('Download Button Label', 'opl'); ?></label>
		<input class="widefat" type="text" name="opl_viral_btntxt" id="opl_viral_btntxt" value="<?php if ( isset($viral['viral_btntxt']) ) echo stripslashes($viral['viral_btntxt']); else echo 'Click Here To Download'; ?>" />
		<div class="opl-desc"><?php _e('Enter a text label for the download button (e.g. Download Now!).', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property"><strong>Instruction:</strong> After you finished setting up the Viral Download, please insert the <code>[ez_viral_download]</code> shortcode into the page content above.</li>
	</ul>
<?php
}

function opl_meta_exit( $post ) {
	$value = get_post_meta($post->ID, 'opl_settings', true);
	$exit = opl_isset($value['exit_settings']);
?>
	<ul id="opl-meta">
	<li class="opl-property">
		<label><?php _e('Enable Exit Redirect', 'opl'); ?></label>
		<label for="opl_exit" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_exit" id="opl_exit" value="1"<?php if ( opl_isset($exit['opl_exit']) == 1 ) echo ' checked="checked" '; ?>/> <span class="opl-desc"><code><?php _e('Prevent visitors from leaving this page.', 'opl'); ?></code></span></label><br />
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label for="opl_viral_download"><?php _e('Exit Redirect URL', 'opl'); ?></label>
		<input class="widefat" type="text" name="opl_exit_url" id="opl_exit_url" value="<?php echo stripslashes(opl_isset($exit['exit_url'])); ?>" />
		<div class="opl-desc"><?php _e('Please enter a valid exit URL (must include http://). People who are trying to leave your site, will be given an option whether to leave your site or visit this exit URL.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label for="opl_body_code"><?php _e('Exit Message', 'opl'); ?></label>
		<textarea name="opl_exit_msg" id="opl_exit_msg" class="widefat" style="height:80px"><?php if ( isset($exit['exit_msg']) ) echo stripslashes(addslashes(opl_isset($exit['exit_msg']))); else echo "WAIT!!!\n\nClick \"Stay on page\" or \"Cancel\" button because I have something very special for you."; ?></textarea>
		<div class="opl-desc"><?php _e('Enter a message that will be displayed when visitors try to leave the page.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	</ul>		
<?php
}

function opl_meta_social( $post ) {
	$value = get_post_meta($post->ID, 'opl_settings', true);
	$social = opl_isset($value['social_settings']);
?>
	<ul id="opl-meta">
	<li class="opl-property">
		<label><?php _e('Social Sharing Options', 'opl'); ?></label>
		<label for="opl_fb_like" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_fb_like" id="opl_fb_like" value="1"<?php if ( opl_isset($social['fb_like']) == 1 ) echo ' checked="checked" '; ?>/> <span class="opl-desc"><code><?php _e('Facebook', 'opl'); ?></code></span></label><br />
		<label for="opl_tw_share" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_tw_share" id="opl_tw_share" value="1"<?php if ( opl_isset($social['tw_share']) == 1 ) echo ' checked="checked" '; ?>/> <span class="opl-desc"><code><?php _e('Twitter', 'opl'); ?></code></span></label><br />
		<label for="opl_g1_share" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_g1_share" id="opl_g1_share" value="1"<?php if ( opl_isset($social['g1_share']) == 1 ) echo ' checked="checked" '; ?>/> <span class="opl-desc"><code><?php _e('Google +1', 'opl'); ?></code></span></label><br />
		<label for="opl_pin_share" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_pin_share" id="opl_pin_share" value="1"<?php if ( opl_isset($social['pin_share']) == 1 ) echo ' checked="checked" '; ?>/> <span class="opl-desc"><code><?php _e('Pinterest', 'opl'); ?></code></span></label><br />
		<label for="opl_lin_share" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_lin_share" id="opl_lin_share" value="1"<?php if ( opl_isset($social['lin_share']) == 1 ) echo ' checked="checked" '; ?>/> <span class="opl-desc"><code><?php _e('LinkedIn', 'opl'); ?></code></span></label><br />
		<label for="opl_su_share" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_su_share" id="opl_su_share" value="1"<?php if ( opl_isset($social['su_share']) == 1 ) echo ' checked="checked" '; ?>/> <span class="opl-desc"><code><?php _e('Stumble Upon', 'opl'); ?></code></span></label><br />
		<div class="opl-desc"><?php printf(__('<strong>Note</strong>: To enable Facebook Like button, you have to integrate a Facebook Application with InstaBuilder in <a href="%s" target="_blank">InstaBuilder -> Settings</a>.', 'opl'), admin_url('admin.php?page=opl-settings')); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label for="opl_social_pos"><?php _e('Share Bar Position', 'opl'); ?></label>
		<select name="opl_social_pos" id="opl_social_pos" class="widefat">
			<option value="left"<?php if ( opl_isset($social['social_pos']) == 'left' ) echo ' selected="selected" '; ?>>Left Side</option>
			<option value="right"<?php if ( opl_isset($social['social_pos']) == 'right' ) echo ' selected="selected" '; ?>>Right Side</option>
		</select>
		<div class="opl-desc"><?php _e('Select where you want to display the social share bar.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	</ul>		
<?php
}

function opl_meta_script( $post ) {
	$value = get_post_meta($post->ID, 'opl_settings', true);
?>
	<ul id="opl-meta">
	<li class="opl-property">
		<label for="opl_head_code"><?php _e('Additional Header Code/Script', 'opl'); ?></label>
		<textarea name="opl_head_code" id="opl_head_code" class="widefat" style="height:80px"><?php echo stripslashes(addslashes(opl_isset($value['head_code']))); ?></textarea>
		<div class="opl-desc"><?php _e('You can enter any additional code/script to be added into the <code>&lt;head&gt;&lt;/head&gt;</code> section. Please use the php opening tag <code>&lt;?php</code> and closing tag <code>?&gt;</code> when adding a php code.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label for="opl_body_code"><?php _e('Additional Body Code/Script', 'opl'); ?></label>
		<textarea name="opl_body_code" id="opl_body_code" class="widefat" style="height:80px"><?php echo stripslashes(addslashes(opl_isset($value['body_code']))); ?></textarea>
		<div class="opl-desc"><?php _e('You can enter any additional code/script to be added at the beginning of the HTML body, just after the opening <code>&lt;body&gt;</code> tag. Please use the php opening tag <code>&lt;?php</code> and closing tag <code>?&gt;</code> when adding a php code.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label for="opl_footer_code"><?php _e('Additional Footer Code/Script', 'opl'); ?></label>
		<textarea name="opl_footer_code" id="opl_footer_code" class="widefat" style="height:80px"><?php echo stripslashes(addslashes(opl_isset($value['footer_code']))); ?></textarea>
		<div class="opl-desc"><?php _e('You can enter any additional code/script to be added into the footer section, just before the closing <code>&lt;/body&gt;</code> tag. Please use the php opening tag <code>&lt;?php</code> and closing tag <code>?&gt;</code> when adding a php code.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	</ul>
<?php
}
function opl_meta_video( $post ) {
	$value = get_post_meta($post->ID, 'opl_settings', true);
	$video = opl_isset($value['video_settings']);
	$buy = opl_isset($value['buy_settings']);
?>
	<ul id="opl-meta">
	<li class="opl-property">
		<label for="opl_video_insert"><?php _e('Video Insertion Mode', 'opl'); ?></label>
		<select name="opl_video_insert" id="opl_video_insert" class="widefat">
			<option value="hosted"<?php if ( opl_isset($video['insertion']) == 'hosted' ) echo ' selected="selected" '; ?>>Hosted Video (I have the video URL)</option>
			<option value="embed"<?php if ( opl_isset($video['insertion']) == 'embed' ) echo ' selected="selected" '; ?>>Embed, Iframe, or Script (I have the video code)</option>
		</select>
		<div class="opl-desc"><?php _e('Choose how you want to insert the video into your video sales page.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-video opl-vidurl">
		<label for="opl_video_url"><?php _e('MP4/H.264 Video URL', 'opl'); ?></label>
		<input class="widefat" type="text" name="opl_video_url" id="opl_video_url" value="<?php echo stripslashes(opl_isset($video['video_url'])); ?>" />
		<div class="opl-desc"><?php _e('Please enter a valid video URL (must include http://). We recommend you to use a MP4/H.264 video, instead of Flash or FLV video, as it can be played on PC/Mac, and also supported by iPad, iPhone, and Android. You can use <a href="http://handbrake.fr/downloads.php" target="_blank">Handbrake</a> or <a href="http://www.mirovideoconverter.com/" target="_blank">Miro</a> to convert your video into MP4/H.264 video.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-video opl-vidurl">
		<label for="opl_ivideo_url"><?php _e('WebM Video URL (optional)', 'opl'); ?></label>
		<input class="widefat" type="text" name="opl_ivideo_url" id="opl_ivideo_url" value="<?php echo stripslashes(opl_isset($video['ivideo_url'])); ?>" />
		<div class="opl-desc"><?php _e('Please enter a valid WebM video URL (must include http://). This is an optional option but recommended to include a WebM version of your video to increase compatibility with more browsers and mobile devices. You can use <a href="http://firefogg.org/" target="_blank">Firefogg</a> (Firefox users only) or <a href="http://www.mirovideoconverter.com/" target="_blank">Miro</a> to convert your video into WebM video.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<?php $jw_disable = ( !function_exists('jwplayer_plugin_menu') ) ? ' disabled="disabled"' : ''; ?>
	<li class="opl-property opl-video opl-vidurl">
		<label for="opl_video_player"><?php _e('Video Player', 'opl'); ?></label>
		<select name="opl_video_player" id="opl_video_player" class="widefat">
			<option value="flow"<?php if ( opl_isset($video['video_player']) == 'flow' ) echo ' selected="selected" '; ?>>Flowplayer</option>
			<option value="jw"<?php if ( opl_isset($video['video_player']) == 'jw' ) echo ' selected="selected" '; ?><?php echo $jw_disable; ?>>JW Player</option>
		</select>
		<div class="opl-desc"><?php printf(__('Choose a video player to playback your video. You have to install and activate <a href="%s" target="_blank">JW Player for WordPress</a> by <a href="http://www.longtailvideo.com" target="_blank">LongTail Video, Inc</a> if you want to use JW Player.', 'opl'), admin_url('plugin-install.php?tab=search&type=term&s=JW+Player&plugin-search-input=Search+Plugins') ); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-video opl-vidurl">
		<label for="opl_video_scr"><?php _e('Video Splash Image URL (optional)', 'opl'); ?></label>
		<input type="text" name="opl_video_scr" id="opl_video_scr" value="<?php echo opl_isset($video['video_scr']); ?>" class="widefat uploaded_url" style="width:75%;" />
		<span id="opl_scr_upload-btn" class="opl_upload_button button">Upload Image</span>
		<div class="opl-desc"><?php _e('Enter the URL of your video splash image, or click "Upload Image" to upload.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-video opl-vidurl">
		<label><?php _e('Video Options', 'opl'); ?></label>
		<label for="opl_video_autoplay" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_video_autoplay" id="opl_video_autoplay" value="1"<?php if ( opl_isset($video['autoplay']) == 1 ) echo ' checked="checked" '; ?>/> <span class="opl-desc"><code><?php _e('Autoplay Video', 'opl'); ?></code></span></label><br />
		<label for="opl_video_autohide" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_video_autohide" id="opl_video_autohide" value="1"<?php if ( opl_isset($video['autohide']) == 1 ) echo ' checked="checked" '; ?>/> <span class="opl-desc"><code><?php _e('Auto Hide Video Control', 'opl'); ?></code></span></label><br />
		<label for="opl_disable_control" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_disable_control" id="opl_disable_control" value="1"<?php if ( opl_isset($video['disable_control']) == 1 ) echo ' checked="checked" '; ?>/> <span class="opl-desc"><code><?php _e('Disable Video Control', 'opl'); ?></code></span></label><br />
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-video opl-embed">
		<label for="opl_video_code"><?php _e('Video Code', 'opl'); ?></label>
		<textarea name="opl_video_code" id="opl_video_code" class="widefat" style="height:60px"><?php echo stripslashes(opl_isset($video['video_code'])); ?></textarea>
		<div class="opl-desc"><?php _e('Please enter the video code/script. This can be a video from video sharing sites (e.g. YouTube, Vimeo, etc or video player like EVP and EZS3).', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-video">
		<label for="opl_video_width"><?php _e('Video Size', 'opl'); ?></label>
		Width: <input type="text" name="opl_video_width" id="opl_video_width" value="<?php if ( isset($video['video_width']) ) echo stripslashes($video['video_width']); else echo '640'; ?>" />
		Height: <input type="text" name="opl_video_height" id="opl_video_height" value="<?php if ( isset($video['video_height']) ) echo stripslashes($video['video_height']); else echo '360'; ?>" />
		<div class="opl-desc"><?php _e('Please enter the exact width of your video so it can be displayed correctly, and fit with InstaBuilder\'s video frame. Recommended video width for <strong>Squeeze Page</strong>: <code>640</code> (maximum width), <code>560</code> or <code>480</code> pixels. Recommended video width for <strong>Single Column</strong> and <strong>Video Page</strong>: <code>720</code>, <code>640</code>, or <code>560</code> pixels.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-video-page">
		<label for="opl_under_content"><?php _e('What Do You Want To Display Below The Video?', 'opl'); ?></label>
		<select name="opl_under_content" id="opl_under_content" class="widefat">
			<option value="order"<?php if ( opl_isset($buy['under_content']) == 'order' ) echo ' selected="selected" '; ?>>Buy Now Area</option>
			<option value="optin"<?php if ( opl_isset($buy['under_content']) == 'optin' ) echo ' selected="selected" '; ?>>Optin Form</option>
			<option value="content"<?php if ( opl_isset($buy['under_content']) == 'content' ) echo ' selected="selected" '; ?>>Page Content</option>
			<option value="combo1"<?php if ( opl_isset($buy['under_content']) == 'combo1' ) echo ' selected="selected" '; ?>>Buy Now Area and then Page Content</option>
			<option value="combo2"<?php if ( opl_isset($buy['under_content']) == 'combo2' ) echo ' selected="selected" '; ?>>Optin Form and then Page Content</option>
			<option value="nothing"<?php if ( opl_isset($buy['under_content']) == 'nothing' ) echo ' selected="selected" '; ?>>Show Nothing</option>
		</select>
		<div class="opl-desc"><?php _e('Choose what you want to display below the video.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opt-property opl-under-buy opl-video-page">
		<label for="opl_buy_cta"><?php _e('Buy Now Area', 'opl'); ?></label>
		<?php if ( post_type_supports('page', 'editor') ) : ?>
			<?php $order_val = ( isset($buy['order_area']) ) ? $buy['order_area'] : opl_default_order(); ?>
        	<?php wp_editor($order_val, 'oplbuyarea', array('textarea_name' => 'opl_buy_area' ) ); ?>
		<?php endif; ?>
		<div class="opl-desc"><?php _e('Feel free to design your own buy now area using the visual editor above. You can also use shortcodes here.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opt-property opl-under-optin opl-video-page">
		<p><strong>For Optin Form:</strong> Please open the "Optin Form" tab to configure your optin form.</span></p>
		<div class="opl-hr"></div>
	</li>
	<li class="opt-property opl-under-content opl-video-page">
		<p><strong>For Page Content:</strong> Please use the main WordPress visual editor above to enter your page content.</span></p>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-under opl-video-page">
		<label><?php _e('Delay', 'opl'); ?></label>
		Show Content After:
		<select name="opl_delay_hour" id="opl_delay_hour" style="width:80px">
			<option value="0"<?php if ( opl_isset($buy['delay_hour']) == '0' ) echo ' selected="selected" '; ?>>00</option>
			<option value="1"<?php if ( opl_isset($buy['delay_hour']) == '1' ) echo ' selected="selected" '; ?>>01</option>
			<option value="2"<?php if ( opl_isset($buy['delay_hour']) == '2' ) echo ' selected="selected" '; ?>>02</option>
			<option value="3"<?php if ( opl_isset($buy['delay_hour']) == '3' ) echo ' selected="selected" '; ?>>03</option>
			<option value="4"<?php if ( opl_isset($buy['delay_hour']) == '4' ) echo ' selected="selected" '; ?>>04</option>
			<option value="5"<?php if ( opl_isset($buy['delay_hour']) == '5' ) echo ' selected="selected" '; ?>>05</option>
		</select>
		hour(s)
		<select name="opl_delay_min" id="opl_delay_min" style="width:80px">
			<?php for ( $i=0; $i<60; $i++ ) :
			$selected = ( opl_isset($buy['delay_min']) == $i ) ? ' selected="selected"' : '';
			echo '<option value="' . $i . '"' . $selected . '>' . str_pad($i, 2, '0', STR_PAD_LEFT) . '</option>';
			endfor; ?>
		</select>
		minute(s)
		<select name="opl_delay_sec" id="opl_delay_sec" style="width:80px">
			<?php for ( $i=0; $i<60; $i++ ) :
			$selected = ( opl_isset($buy['delay_sec']) == $i ) ? ' selected="selected"' : '';
			echo '<option value="' . $i . '"' . $selected . '>' . str_pad($i, 2, '0', STR_PAD_LEFT) . '</option>';
			endfor; ?>
		</select>
		second(s)
		<div class="opl-desc"><?php _e('You can hide any content you choose to show below the video for a specific amount of time.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	</ul>
<?php
}

function opl_meta_comments( $post ) {
	$value = get_post_meta($post->ID, 'opl_settings', true);
?>
	<ul id="opl-meta">
	<li class="opl-property">
		<label><?php _e('Display Comments', 'opl'); ?></label>
		<label for="opl_fb_comment" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_fb_comment" id="opl_fb_comment" value="1"<?php if ( opl_isset($value['fb_comment']) == 1 ) echo ' checked="checked" '; ?>/> <span class="opl-desc"><code><?php _e('Display Facebook comment', 'opl'); ?></code></span></label><br />
		<label for="opl_dq_comment" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_dq_comment" id="opl_dq_comment" value="1"<?php if ( opl_isset($value['dq_comment']) == 1 ) echo ' checked="checked" '; ?>/> <span class="opl-desc"><code><?php _e('Display Disqus comment', 'opl'); ?></code></span></label>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label for="opl_comment_title"><?php _e('Comment Title', 'opl'); ?></label>
		<input class="widefat" type="text" name="opl_comment_title" id="opl_comment_title" value="<?php if ( isset($value['comment_title']) ) echo stripslashes($value['comment_title']); else echo 'Share Your Thoughts'; ?>" />
		<div class="opl-desc"><?php _e('Enter a title that will be displayed above Facebook and/or Disqus form. Accepted HTML tag: <code>&lt;span&gt;</code>, <code>&lt;a&gt;</code>, <code>&lt;strong&gt;</code>, <code>&lt;b&gt;</code>, <code>&lt;u&gt;</code>, <code>&lt;em&gt;</code>, <code>&lt;i&gt;</code>, <code>&lt;br&gt;</code>', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label for="opl_comment_color"><?php _e('Comment Title Style', 'opl'); ?></label>
		#<input class="color" type="text" name="opl_comment_color" id="opl_comment_color" value="<?php if ( opl_isset($value['comment_color']) != '' ) echo stripslashes($value['comment_color']); else echo 'CC0000'; ?>" />
		<select name="opl_comment_font" id="opl_comment_font" style="width:160px">
			<optgroup label="Standard Fonts">
				<option value='standard|Arial, "Helvetica Neue", Helvetica, sans-serif'<?php if ( stripslashes(opl_isset($value['comment_font'])) == 'standard|Arial, "Helvetica Neue", Helvetica, sans-serif' ) echo ' selected="selected" '; ?>>Arial</option>
				<option value='standard|"Arial Black", "Arial Bold", Arial, sans-serif'<?php if ( stripslashes(opl_isset($value['comment_font'])) == 'standard|"Arial Black", "Arial Bold", Arial, sans-serif' ) echo ' selected="selected" '; ?>>Arial Black</option>
				<option value='standard|"Arial Narrow", Arial, "Helvetica Neue", Helvetica, sans-serif'<?php if ( stripslashes(opl_isset($value['comment_font'])) == 'standard|"Arial Narrow", Arial, "Helvetica Neue", Helvetica, sans-serif' ) echo ' selected="selected" '; ?>>Arial Narrow</option>
				<option value='standard|Georgia, "Times New Roman", Times, serif'<?php if ( stripslashes(opl_isset($value['comment_font'])) == 'standard|Georgia, "Times New Roman", Times, serif' ) echo ' selected="selected" '; ?>>Georgia</option>
				<option value='standard|Impact, Charcoal, sans-serif'<?php if ( stripslashes(opl_isset($value['comment_font'])) == 'standard|Impact, Charcoal, sans-serif' ) echo ' selected="selected" '; ?>>Impact</option>
				<option value='standard|"Lucida Grande", "Lucida Sans Unicode", sans-serif'<?php if ( stripslashes(opl_isset($value['comment_font'])) == 'standard|"Lucida Grande", "Lucida Sans Unicode", sans-serif' ) echo ' selected="selected" '; ?>>Lucida</option>
				<option value='standard|Tahoma, Geneva, sans-serif'<?php if ( stripslashes(opl_isset($value['comment_font'])) == 'standard|Tahoma, Geneva, sans-serif' ) echo ' selected="selected" '; ?>>Tahoma</option>
				<option value='standard|"Times New Roman", Times, Georgia, serif'<?php if ( stripslashes(opl_isset($value['comment_font'])) == 'standard|"Times New Roman", Times, Georgia, serif' ) echo ' selected="selected" '; ?>>Times New Roman</option>
				<option value='standard|"Trebuchet MS", "Lucida Grande", "Lucida Sans", Arial, sans-serif'<?php if ( stripslashes(opl_isset($value['comment_font'])) == 'standard|"Trebuchet MS", "Lucida Grande", "Lucida Sans", Arial, sans-serif' ) echo ' selected="selected" '; ?>>Trebuchet MS</option>
				<option value='standard|Verdana, sans-serif'<?php if ( stripslashes(opl_isset($value['comment_font'])) == 'standard|Verdana, sans-serif' ) echo ' selected="selected" '; ?>>Verdana</option>
			</optgroup>
			<optgroup label="Google Web Fonts">
				<option value='google|"Arvo", serif|Arvo'<?php if ( stripslashes(opl_isset($value['comment_font'])) == 'google|"Arvo", serif|Arvo' ) echo ' selected="selected" '; ?><?php if ( !isset($value['logo_font']) ) echo ' selected="selected" '; ?>>Arvo</option>
				<option value='google|"Cabin", sans-serif|Cabin'<?php if ( stripslashes(opl_isset($value['comment_font'])) == 'google|"Cabin", sans-serif|Cabin' ) echo ' selected="selected" '; ?>>Cabin</option>
				<option value='google|"Covered By Your Grace", cursive|Covered+By+Your+Grace|handwriting'<?php if ( stripslashes(opl_isset($value['comment_font'])) == 'google|"Covered By Your Grace", cursive|Covered+By+Your+Grace|handwriting' ) echo ' selected="selected" '; ?>>Covered By Your Grace</option>
				<option value='google|"Droid Sans", sans-serif|Droid+Sans'<?php if ( stripslashes(opl_isset($value['comment_font'])) == 'google|"Droid Sans", sans-serif|Droid+Sans' ) echo ' selected="selected" '; ?>>Droid Sans</option>
				<option value='google|"Droid Serif", serif|Droid+Serif'<?php if ( stripslashes(opl_isset($value['comment_font'])) == 'google|"Droid Serif", serif|Droid+Serif' ) echo ' selected="selected" '; ?>>Droid Serif</option>
				<option value='google|"Open Sans", sans-serif|Open+Sans'<?php if ( stripslashes(opl_isset($value['comment_font'])) == 'google|"Open Sans", sans-serif|Open+Sans' ) echo ' selected="selected" '; ?>>Open Sans</option>
                <option value='google|"PT Sans", sans-serif|PT+Sans'<?php if ( stripslashes(opl_isset($value['comment_font'])) == 'google|"PT Sans", sans-serif|PT+Sans' ) echo ' selected="selected" '; ?>>PT Sans</option>
				<option value='google|"Rock Salt", cursive|Rock+Salt|handwriting'<?php if ( stripslashes(opl_isset($value['comment_font'])) == 'google|"Rock Salt", cursive|Rock+Salt|handwriting' ) echo ' selected="selected" '; ?>>Rock Salt</option>
				<option value='google|"Ubuntu", sans-serif|Ubuntu'<?php if ( stripslashes(opl_isset($value['comment_font'])) == 'google|"Ubuntu", sans-serif|Ubuntu' ) echo ' selected="selected" '; ?>>Ubuntu</option>
				<option value='google|"Vollkorn", serif|Vollkorn'<?php if ( stripslashes(opl_isset($value['comment_font'])) == 'google|"Vollkorn", serif|Vollkorn' ) echo ' selected="selected" '; ?>>Vollkorn</option>
			</optgroup>
		</select>
		<select name="opl_comment_size" id="opl_comment_size" style="width:80px">
			<?php for ( $i=14; $i<73; $i++ ) {
				$selected = '';
				if ( opl_isset($value['comment_size']) == $i )
					$selected = ' selected="selected"';
				else if ( opl_isset($value['comment_size']) == '' ) {
					if ( $i == 18 )
						$selected = ' selected="selected"';
				}
				echo '<option value="' . $i . '"' . $selected . '>' . $i . 'pt</option>';
			} ?>
		</select>
		<div class="opl-desc"><?php _e('Set comment title\'s font face, color, and the size.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	</ul>
<?php
}

function opl_meta_background( $post ) {
	$value = get_post_meta($post->ID, 'opl_settings', true);
	$bg = opl_isset($value['bg']);
?>
	<ul id="opl-meta">
		<li class="opl-property">
			<label><?php _e('Custom Body Background', 'opl'); ?></label>
			<label for="opl_bodybg" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_bodybg" id="opl_bodybg" value="1"<?php if ( opl_isset($bg['opl_bodybg']) == 1 ) echo ' checked="checked" '; ?>/> <span class="opl-desc"><code><?php _e('Use Custom Body Background', 'opl'); ?></code></span></label>
			<div class="opl-hr"></div>
		</li>
		<li class="opl-property body-bg-property">
			<label for="opl_bodybg_color"><?php _e('Body Background Color', 'opl'); ?></label>
			#<input class="color" type="text" name="opl_bodybg_color" id="opl_bodybg_color" value="<?php if ( opl_isset($bg['bodybg_color']) != '' ) echo stripslashes($bg['bodybg_color']); else echo 'FFFFFF'; ?>" />
			<div class="opl-desc"><?php _e('Choose a custom body background color from the picker (click the field to show the color picker).', 'opl'); ?></div>
			<div class="opl-hr"></div>
		</li>
		<li class="opl-property body-bg-property">
			<label for="opl_bodybg_url"><?php _e('Body Background Image URL', 'opl'); ?></label>
			<input type="text" name="opl_bodybg_url" id="opl_bodybg_url" value="<?php echo opl_isset($bg['bodybg_url']); ?>" class="widefat uploaded_url" style="width:75%;" />
			<span id="opl_bbg_upload-btn" class="opl_upload_button button">Upload Background</span>
			<div class="opl-desc"><?php _e('Enter the URL of your body background image, or click the "Upload Background" button to upload. Leave this blank if you don\'t want to use a background image.<br /><br />For A Full background image without a repeat, please use an image sized <code>1920 x 768</code>', 'opl'); ?></div>
			<div class="opl-hr"></div>
		</li>
		<li class="opl-property body-bg-property">
			<label for="opl_bodybg_pos"><?php _e('Body Background Image Position', 'opl'); ?></label>
			<select name="opl_bodybg_pos" id="opl_bodybg_pos" class="widefat">
				<option value="left top"<?php if ( opl_isset($bg['bodybg_pos']) == 'left top' ) echo ' selected="selected" '; ?>>Left Top</option>
				<option value="center top"<?php if ( opl_isset($bg['bodybg_pos']) == 'center top' ) echo ' selected="selected" '; ?>>Center Top</option>
				<option value="right top"<?php if ( opl_isset($bg['bodybg_pos']) == 'right top' ) echo ' selected="selected" '; ?>>Right Top</option>
				<option value="left center"<?php if ( opl_isset($bg['bodybg_pos']) == 'left center' ) echo ' selected="selected" '; ?>>Left Center</option>
				<option value="center center"<?php if ( opl_isset($bg['bodybg_pos']) == 'center center' ) echo ' selected="selected" '; ?>>Center Center</option>
				<option value="right center"<?php if ( opl_isset($bg['bodybg_pos']) == 'right center' ) echo ' selected="selected" '; ?>>Right Center</option>
				<option value="left bottom"<?php if ( opl_isset($bg['bodybg_pos']) == 'left bottom' ) echo ' selected="selected" '; ?>>Left Bottom</option>
				<option value="center bottom"<?php if ( opl_isset($bg['bodybg_pos']) == 'center bottom' ) echo ' selected="selected" '; ?>>Center Bottom</option>
				<option value="right bottom"<?php if ( opl_isset($bg['bodybg_pos']) == 'right bottom' ) echo ' selected="selected" '; ?>>Right Bottom</option>
			</select>
			<div class="opl-desc"><?php _e('Choose the body background position and alignment.', 'opl'); ?></div>
			<div class="opl-hr"></div>
		</li>
		<li class="opl-property body-bg-property">
			<label for="opl_bodybg_repeat"><?php _e('Body Background Image Repeat', 'opl'); ?></label>
			<select name="opl_bodybg_repeat" id="opl_bodybg_repeat" class="widefat">
				<option value="no-repeat"<?php if ( opl_isset($bg['bodybg_repeat']) == 'no-repeat' ) echo ' selected="selected" '; ?>>No Repeat</option>
				<option value="repeat-x"<?php if ( opl_isset($bg['bodybg_repeat']) == 'repeat-x' ) echo ' selected="selected" '; ?>>Repeat X (horizontally)</option>
				<option value="repeat-y"<?php if ( opl_isset($bg['bodybg_repeat']) == 'repeat-y' ) echo ' selected="selected" '; ?>>Repeat Y (vertically)</option>
				<option value="repeat"<?php if ( opl_isset($bg['bodybg_repeat']) == 'repeat' ) echo ' selected="selected" '; ?>>Repeat (horizontally &amp; Vertically)</option>
			</select>
			<div style="margin:5px 0" id="opl-bodybg-size"><label for="opl_bodybg_size" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_bodybg_size" id="opl_bodybg_size" value="1"<?php if ( opl_isset($bg['bodybg_size']) == 1 ) echo ' checked="checked" '; ?>/> <span class="opl-desc"><code><?php _e('Enlarge background image to fill up entire area.', 'opl'); ?></code></span></label></div>
			<div class="opl-desc"><?php _e('Choose whether you want the image to be repeated to fill the empty space on the body, or not.', 'opl'); ?></div>
			<div class="opl-hr"></div>
		</li>
		<li class="opl-property body-bg-property">
			<label for="opl_bodybg_att"><?php _e('Body Background Image Attachment', 'opl'); ?></label>
			<select name="opl_bodybg_att" id="opl_bodybg_att" class="widefat">
				<option value="scroll"<?php if ( opl_isset($bg['bodybg_att']) == 'scroll' ) echo ' selected="selected" '; ?>>Scroll</option>
				<option value="fixed"<?php if ( opl_isset($bg['bodybg_att']) == 'fixed' ) echo ' selected="selected" '; ?>>Fixed</option>
			</select>
			<div class="opl-desc"><?php _e('If you choose "scroll" the body background image will scrolls with the rest of the page. Otherwise, if you choose "fixed," then the body background image position will stay on your screen.', 'opl'); ?></div>
			<div class="opl-hr"></div>
		</li>
	</ul>
	
	<ul id="opl-meta">
		<li class="opl-property">
			<label><?php _e('Custom Header Background', 'opl'); ?></label>
			<label for="opl_headerbg" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_headerbg" id="opl_headerbg" value="1"<?php if ( opl_isset($bg['opl_headerbg']) == 1 ) echo ' checked="checked" '; ?>/> <span class="opl-desc"><code><?php _e('Use Custom Header Background', 'opl'); ?></code></span></label>
			<div class="opl-hr"></div>
		</li>
		<li class="opl-property header-bg-property">
			<label for="opl_headerbg_color"><?php _e('Header Background Color', 'opl'); ?></label>
			#<input class="color" type="text" name="opl_headerbg_color" id="opl_headerbg_color" value="<?php if ( opl_isset($bg['headerbg_color']) != '' ) echo stripslashes($bg['headerbg_color']); else echo 'FFFFFF'; ?>" />
			<div class="opl-desc"><?php _e('Choose a custom header background color from the picker (click the field to show the color picker).', 'opl'); ?></div>
			<div class="opl-hr"></div>
		</li>
		<li class="opl-property header-bg-property">
			<label for="opl_headerbg_url"><?php _e('Header Background Image URL', 'opl'); ?></label>
			<input type="text" name="opl_headerbg_url" id="opl_headerbg_url" value="<?php echo opl_isset($bg['headerbg_url']); ?>" class="widefat uploaded_url" style="width:75%;" />
			<span id="opl_hbg_upload-btn" class="opl_upload_button button">Upload Background</span>
			<div class="opl-desc"><?php _e('Enter the URL of your header background image, or click the "Upload Background" button to upload.<br /><br />For A Full header image, please use a <code>980px</code> wide image with any height.', 'opl'); ?></div>
			<div class="opl-hr"></div>
		</li>
		<li class="opl-property header-bg-property">
			<label for="opl_headerbg_pos"><?php _e('Header Background Image Position', 'opl'); ?></label>
			<select name="opl_headerbg_pos" id="opl_headerbg_pos" class="widefat">
				<option value="left top"<?php if ( opl_isset($bg['headerbg_pos']) == 'left top' ) echo ' selected="selected" '; ?>>Left Top</option>
				<option value="center top"<?php if ( opl_isset($bg['headerbg_pos']) == 'center top' ) echo ' selected="selected" '; ?>>Center Top</option>
				<option value="right top"<?php if ( opl_isset($bg['headerbg_pos']) == 'right top' ) echo ' selected="selected" '; ?>>Right Top</option>
				<option value="left center"<?php if ( opl_isset($bg['headerbg_pos']) == 'left center' ) echo ' selected="selected" '; ?>>Left Center</option>
				<option value="center center"<?php if ( opl_isset($bg['headerbg_pos']) == 'center center' ) echo ' selected="selected" '; ?>>Center Center</option>
				<option value="right center"<?php if ( opl_isset($bg['headerbg_pos']) == 'right center' ) echo ' selected="selected" '; ?>>Right Center</option>
				<option value="left bottom"<?php if ( opl_isset($bg['headerbg_pos']) == 'left bottom' ) echo ' selected="selected" '; ?>>Left Bottom</option>
				<option value="center bottom"<?php if ( opl_isset($bg['headerbg_pos']) == 'center bottom' ) echo ' selected="selected" '; ?>>Center Bottom</option>
				<option value="right bottom"<?php if ( opl_isset($bg['headerbg_pos']) == 'right bottom' ) echo ' selected="selected" '; ?>>Right Bottom</option>
			</select>
			<div class="opl-desc"><?php _e('Choose the header background position and alignment.', 'opl'); ?></div>
			<div class="opl-hr"></div>
		</li>
		<li class="opl-property header-bg-property">
			<label for="opl_headerbg_repeat"><?php _e('Header Background Image Repeat', 'opl'); ?></label>
			<select name="opl_headerbg_repeat" id="opl_headerbg_repeat" class="widefat">
				<option value="no-repeat"<?php if ( opl_isset($bg['headerbg_repeat']) == 'no-repeat' ) echo ' selected="selected" '; ?>>No Repeat</option>
				<option value="repeat-x"<?php if ( opl_isset($bg['headerbg_repeat']) == 'repeat-x' ) echo ' selected="selected" '; ?>>Repeat X (horizontally)</option>
				<option value="repeat-y"<?php if ( opl_isset($bg['headerbg_repeat']) == 'repeat-y' ) echo ' selected="selected" '; ?>>Repeat Y (vertically)</option>
				<option value="repeat"<?php if ( opl_isset($bg['headerbg_repeat']) == 'repeat' ) echo ' selected="selected" '; ?>>Repeat (horizontally &amp; Vertically)</option>
			</select>
			<div class="opl-desc"><?php _e('Choose whether you want the image to be repeated to fill the empty space on the header, or not.', 'opl'); ?></div>
			<div class="opl-hr"></div>
		</li>
		<li class="opl-property header-bg-property">
			<label for="opl_headerbg_height"><?php _e('Header Height', 'opl'); ?></label>
			<input class="widefat" type="text" name="opl_headerbg_height" id="opl_headerbg_height" value="<?php if ( isset($bg['headerbg_height']) ) echo stripslashes($bg['headerbg_height']); else echo '120'; ?>" style="width:80px" /> px
			<div class="opl-desc"><?php _e('Enter the height (in pixels) of your header background image.', 'opl'); ?></div>
			<div class="opl-hr"></div>
		</li>
		<li class="opl-property header-bg-property">
			<label for="opl_headerbg_wide" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_headerbg_wide" id="opl_headerbg_wide" value="1"<?php if ( opl_isset($bg['headerbg_wide']) == 1 ) echo ' checked="checked" '; ?>/> <span class="opl-desc"><code><?php _e('Enable Wide Header', 'opl'); ?></code></span></label>
			<div class="opl-desc"><?php _e('If you check this option, the header start position will be the edge of your monitor screen. Otherwise, the header will be aligned with the main content area.', 'opl'); ?></div>
			<div class="opl-hr"></div>
		</li>
	</ul>
<?php	
}

function opl_meta_headers( $post ) {
	$header = get_post_meta($post->ID, 'opl_headers', true);
	$menus = opl_get_menus();
?>
	<ul id="opl-meta">
		<li class="opl-property">
			<label><?php _e('Display Logo', 'opl'); ?></label>
			<label for="opl_header" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_header" id="opl_header" value="1"<?php if ( opl_isset($header['opl_header']) == 1 ) echo ' checked="checked" '; ?>/> <span class="opl-desc"><code><?php _e('Display my logo on this page\'s header', 'opl'); ?></code></span></label>
			<div class="opl-hr"></div>
		</li>
		<li class="opl-property">
			<label for="opl_logo_type"><?php _e('Logo Type', 'opl'); ?></label>
			<select name="opl_logo_type" id="opl_logo_type" class="widefat">
				<option value="text"<?php if ( opl_isset($header['logo_type']) == 'text' ) echo ' selected="selected" '; ?>>Text-Based Logo</option>
				<option value="image"<?php if ( opl_isset($header['logo_type']) == 'image' ) echo ' selected="selected" '; ?>>Image-Based Logo</option>
			</select>
			<div class="opl-desc"><?php _e('Select whether you want to display a text-based or image-base logo on the header.', 'opl'); ?></div>
			<div class="opl-hr"></div>
		</li>
		<li class="opl-property opl-image-logo">
			<label for="opl_logo_url"><?php _e('Logo URL', 'opl'); ?></label>
			<input type="text" name="opl_logo_url" id="opl_logo_url" value="<?php echo opl_isset($header['logo_url']); ?>" class="widefat uploaded_url" style="width:75%;" />
			<span id="opl_logo_upload-btn" class="opl_upload_button button">Upload Logo</span>
			<div class="opl-desc"><?php _e('Enter the URL of your image logo, or click "Upload Logo" to upload.', 'opl'); ?></div>
			<div class="opl-hr"></div>
		</li>
		<li class="opl-property opl-text-logo">
			<label for="opl_text_logo"><?php _e('Text Logo', 'opl'); ?></label>
			<input class="widefat" type="text" name="opl_text_logo" id="opl_text_logo" value="<?php if ( isset($header['text_logo']) ) echo stripslashes($header['text_logo']); else echo get_bloginfo('name'); ?>" />
			<div class="opl-desc"><?php _e('Please enter your site name or product/service name to be displayed on the header.', 'opl'); ?></div>
			<div class="opl-hr"></div>
		</li>
		<li class="opl-property opl-text-logo">
			<label for="opl_logo_color"><?php _e('Text Logo Style', 'opl'); ?></label>
			#<input class="color" type="text" name="opl_logo_color" id="opl_logo_color" value="<?php if ( opl_isset($header['logo_color']) != '' ) echo stripslashes($header['logo_color']); else echo '595959'; ?>" />
			<select name="opl_logo_font" id="opl_logo_font" style="width:160px">
				<optgroup label="Standard Fonts">
					<option value='standard|Arial, "Helvetica Neue", Helvetica, sans-serif'<?php if ( stripslashes(opl_isset($header['logo_font'])) == 'standard|Arial, "Helvetica Neue", Helvetica, sans-serif' ) echo ' selected="selected" '; ?>>Arial</option>
					<option value='standard|"Arial Black", "Arial Bold", Arial, sans-serif'<?php if ( stripslashes(opl_isset($header['logo_font'])) == 'standard|"Arial Black", "Arial Bold", Arial, sans-serif' ) echo ' selected="selected" '; ?>>Arial Black</option>
					<option value='standard|"Arial Narrow", Arial, "Helvetica Neue", Helvetica, sans-serif'<?php if ( stripslashes(opl_isset($header['logo_font'])) == 'standard|"Arial Narrow", Arial, "Helvetica Neue", Helvetica, sans-serif' ) echo ' selected="selected" '; ?>>Arial Narrow</option>
					<option value='standard|Georgia, "Times New Roman", Times, serif'<?php if ( stripslashes(opl_isset($header['logo_font'])) == 'standard|Georgia, "Times New Roman", Times, serif' ) echo ' selected="selected" '; ?>>Georgia</option>
					<option value='standard|Impact, Charcoal, sans-serif'<?php if ( stripslashes(opl_isset($header['logo_font'])) == 'standard|Impact, Charcoal, sans-serif' ) echo ' selected="selected" '; ?>>Impact</option>
					<option value='standard|"Lucida Grande", "Lucida Sans Unicode", sans-serif'<?php if ( stripslashes(opl_isset($header['logo_font'])) == 'standard|"Lucida Grande", "Lucida Sans Unicode", sans-serif' ) echo ' selected="selected" '; ?>>Lucida</option>
					<option value='standard|Tahoma, Geneva, sans-serif'<?php if ( stripslashes(opl_isset($header['logo_font'])) == 'standard|Tahoma, Geneva, sans-serif' ) echo ' selected="selected" '; ?>>Tahoma</option>
					<option value='standard|"Times New Roman", Times, Georgia, serif'<?php if ( stripslashes(opl_isset($header['logo_font'])) == 'standard|"Times New Roman", Times, Georgia, serif' ) echo ' selected="selected" '; ?>>Times New Roman</option>
					<option value='standard|"Trebuchet MS", "Lucida Grande", "Lucida Sans", Arial, sans-serif'<?php if ( stripslashes(opl_isset($header['logo_font'])) == 'standard|"Trebuchet MS", "Lucida Grande", "Lucida Sans", Arial, sans-serif' ) echo ' selected="selected" '; ?>>Trebuchet MS</option>
					<option value='standard|Verdana, sans-serif'<?php if ( stripslashes(opl_isset($header['logo_font'])) == 'standard|Verdana, sans-serif' ) echo ' selected="selected" '; ?>>Verdana</option>
				</optgroup>
				<optgroup label="Google Web Fonts">
					<option value='google|"Arvo", serif|Arvo'<?php if ( stripslashes(opl_isset($header['logo_font'])) == 'google|"Arvo", serif|Arvo' ) echo ' selected="selected" '; ?><?php if ( !isset($header['logo_font']) ) echo ' selected="selected" '; ?>>Arvo</option>
					<option value='google|"Cabin", sans-serif|Cabin'<?php if ( stripslashes(opl_isset($header['logo_font'])) == 'google|"Cabin", sans-serif|Cabin' ) echo ' selected="selected" '; ?>>Cabin</option>
					<option value='google|"Covered By Your Grace", cursive|Covered+By+Your+Grace|handwriting'<?php if ( stripslashes(opl_isset($header['logo_font'])) == 'google|"Covered By Your Grace", cursive|Covered+By+Your+Grace|handwriting' ) echo ' selected="selected" '; ?>>Covered By Your Grace</option>
					<option value='google|"Droid Sans", sans-serif|Droid+Sans'<?php if ( stripslashes(opl_isset($header['logo_font'])) == 'google|"Droid Sans", sans-serif|Droid+Sans' ) echo ' selected="selected" '; ?>>Droid Sans</option>
					<option value='google|"Droid Serif", serif|Droid+Serif'<?php if ( stripslashes(opl_isset($header['logo_font'])) == 'google|"Droid Serif", serif|Droid+Serif' ) echo ' selected="selected" '; ?>>Droid Serif</option>
					<option value='google|"Open Sans", sans-serif|Open+Sans'<?php if ( stripslashes(opl_isset($header['logo_font'])) == 'google|"Open Sans", sans-serif|Open+Sans' ) echo ' selected="selected" '; ?>>Open Sans</option>
	                <option value='google|"PT Sans", sans-serif|PT+Sans'<?php if ( stripslashes(opl_isset($header['logo_font'])) == 'google|"PT Sans", sans-serif|PT+Sans' ) echo ' selected="selected" '; ?>>PT Sans</option>
					<option value='google|"Rock Salt", cursive|Rock+Salt|handwriting'<?php if ( stripslashes(opl_isset($header['logo_font'])) == 'google|"Rock Salt", cursive|Rock+Salt|handwriting' ) echo ' selected="selected" '; ?>>Rock Salt</option>
					<option value='google|"Ubuntu", sans-serif|Ubuntu'<?php if ( stripslashes(opl_isset($header['logo_font'])) == 'google|"Ubuntu", sans-serif|Ubuntu' ) echo ' selected="selected" '; ?>>Ubuntu</option>
					<option value='google|"Vollkorn", serif|Vollkorn'<?php if ( stripslashes(opl_isset($header['logo_font'])) == 'google|"Vollkorn", serif|Vollkorn' ) echo ' selected="selected" '; ?>>Vollkorn</option>
				</optgroup>
			</select>
			<select name="opl_logo_size" id="opl_logo_size" style="width:80px">
				<?php for ( $i=14; $i<73; $i++ ) {
					$selected = '';
					if ( opl_isset($header['logo_size']) == $i )
						$selected = ' selected="selected"';
					else if ( opl_isset($header['logo_size']) == '' ) {
						if ( $i == 26 )
							$selected = ' selected="selected"';
					}
					echo '<option value="' . $i . '"' . $selected . '>' . $i . 'pt</option>';
				} ?>
			</select>
			<div class="opl-desc"><?php _e('Set the text logo font face, color, and the size.', 'opl'); ?></div>
			<div class="opl-hr"></div>
		</li>
		<li class="opl-property">
			<label for="opl_logo_align"><?php _e('Logo Alignment', 'opl'); ?></label>
			<select name="opl_logo_align" id="opl_logo_align" class="widefat">
				<option value="left"<?php if ( opl_isset($header['logo_align']) == 'left' ) echo ' selected="selected" '; ?>>Left</option>
				<option value="center"<?php if ( opl_isset($header['logo_align']) == 'center' ) echo ' selected="selected" '; ?>>Center</option>
				<option value="right"<?php if ( opl_isset($header['logo_align']) == 'right' ) echo ' selected="selected" '; ?>>Right</option>
			</select>
			<div class="opl-desc"><?php _e('Select whether you want to display a text-based or image-base logo on the header.', 'opl'); ?></div>
			<div class="opl-hr"></div>
		</li>
	</ul>
<?php	
}

function opl_meta_optin( $post ) {
	$value = get_post_meta($post->ID, 'opl_settings', true);
	$optin = opl_isset($value['optin']);
	$adv_fields = ( is_array(opl_isset($optin['adv_fields'])) ) ? $optin['adv_fields'] : opl_advfields_default();
	//$adv_fields = opl_advfields_default();
?>
	<ul id="opl-meta">
	<li class="opl-property opl-optin-property">
		<label for="opl_arcode"><?php _e('Autoresponder Code', 'opl'); ?></label>
		<textarea name="opl_arcode" id="opl_arcode" class="widefat" style="height:190px"><?php echo stripslashes(opl_isset($value['ar_code'])); ?></textarea>
		<div class="opl-desc"><?php _e('Simply copy the raw HTML autoresponder code, and paste it here (do NOT use the javascript snippet or it won\'t work).', 'opl'); ?></div>
		<div class="opl-hr"></div>	
	</li>
	<li class="opl-property opl-optin-property">
		<label><?php _e('Subscribe Method', 'opl'); ?></label>
		<label for="opl_subs_method_manual" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_subs_method_manual" id="opl_subs_method_manual" value="1"<?php if ( opl_isset($optin['subs_method_manual']) == 1 ) echo ' checked="checked" '; ?> <?php if ( !isset($value['type']) ) echo ' checked="checked" '; ?> /> <span class="opl-desc"><code><?php _e('Manual Form Submission', 'opl'); ?></code></span></label><br />
		<label for="opl_subs_method_fb" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_subs_method_fb" id="opl_subs_method_fb" value="1"<?php if ( opl_isset($optin['subs_method_fb']) == 1 ) echo ' checked="checked" '; ?>/> <span class="opl-desc"><code><?php _e('Facebook Connect', 'opl'); ?></code></span></label><br />
		<div class="opl-desc"><?php printf(__('Select how visitors can to subscribe to your list. <strong>Important:</strong> To use Facebook Connect feature, make sure you already enter your Facebook App detail in <a href="%s" target="_blank">InstaBuilder -> Settings</a>.', 'opl'), admin_url('admin.php?page=opl-settings')); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-optin-property">
		<label for="opl_optin_title"><?php _e('Optin Form Title', 'opl'); ?></label>
		<input class="widefat" type="text" name="opl_optin_title" id="opl_optin_title" value="<?php if ( isset($optin['title']) ) echo stripslashes($optin['title']); else echo 'Get FREE Stuff Now!'; ?>" />
		<div class="opl-desc"><?php _e('Enter a title that will be displayed above the optin form. Accepted HTML tag: <code>&lt;span&gt;</code>, <code>&lt;u&gt;</code>, <code>&lt;em&gt;</code>, <code>&lt;i&gt;</code>, <code>&lt;br&gt;</code>', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-optin-property">
		<label for="opl_optin_text"><?php _e('Optin Form Text', 'opl'); ?></label>
		<textarea name="opl_optin_text" id="opl_optin_text" class="widefat" style="height:60px"><?php if ( isset($optin['text']) ) echo stripslashes($optin['text']); else echo 'Simply enter your information below to get INSTANT ACCESS today!'; ?></textarea>
		<div class="opl-desc"><?php _e('Enter a short text that will be displayed above the optin form (after the Optin Form Title). Accepted HTML tag: <code>&lt;span&gt;</code>, <code>&lt;a&gt;</code>, <code>&lt;strong&gt;</code>, <code>&lt;b&gt;</code>, <code>&lt;u&gt;</code>, <code>&lt;em&gt;</code>, <code>&lt;i&gt;</code>, <code>&lt;br&gt;</code>', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-optin-property opl-manual">
		<label for="opl_fields_mode"><?php _e('Form Integration Mode', 'opl'); ?></label>
		<select name="opl_fields_mode" id="opl_fields_mode" class="widefat">
			<option value="simple"<?php if ( opl_isset($optin['form_mode']) == 'simple' ) echo ' selected="selected" '; ?>>Simple Form Integration</option>
			<option value="advanced"<?php if ( opl_isset($optin['form_mode']) == 'advanced' ) echo ' selected="selected" '; ?>>Advanced Form Integration</option>
		</select>
		<div class="opl-desc"><?php _e('Select <code>Simple Form Integration</code> if you want to display \'name\' and \'email\' fields or \'email\' field only. Select <code>Advanced Form Integration</code> if you want to display more than two fields.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-optin-property opl-manual opl-advanced-form">
		<label for="opl_fields_mode"><?php _e('Advanced Optin Form Fields Integration', 'opl'); ?></label>
		<p><strong>Instruction:</strong> Tick the checkbox on each field if you want to display it on the optin form. Drag n drop to arrange the order of each field. When generating HTML code in your autoresponder account, all the displayed fields below must be included or exists in the generated code. Furthermore, the fields' order must be exactly the same as below.</p>
		<table class="form-table">
			<tr valign="top">
				<th scope="row" style="width:10%"><span class="opl-desc"><strong>Display</strong></span></th>
				<th scope="row" style="width:30%"><span class="opl-desc"><strong>Field Name</strong></span></th>
				<th scope="row"><span class="opl-desc"><strong>Label</strong></span></th>
			</tr>
		</table>
		<ul id="opl-fields-sortable">
			<?php
			if ( is_array($adv_fields) ) {
				$i = 0;
				foreach( $adv_fields as $field ) {
					$i++;
					$checked = ( $field['show'] == 1 ) ? ' checked="checked"' : '';
					$readonly = ( $field['type'] == 'email' ) ? ' disabled=disabled' : '';
					$class = ( $i > 6 ) ? ' class="opl-more-fields" style="display:none"' : '';
					?>
					<li<?php echo $class; ?>>
						<table class="form-table">
						<tr valign="top">
							<td style="width:10%"><input type="checkbox" name="opl_adv_fields[<?php echo $field['type']; ?>][show]" value="1"<?php echo $checked; ?><?php echo $readonly; ?> /></td>
							<td style="width:30%"><?php echo $field['title']; ?> <input type="hidden" name="opl_adv_fields[<?php echo $field['type']; ?>][title]" value="<?php echo $field['title']; ?>" /></td>
							<td><input class="widefat" type="text" name="opl_adv_fields[<?php echo $field['type']; ?>][label]" value="<?php echo $field['label']; ?>" style="width:50%"/></td>
						</tr>
						</table>
					</li>
					<?php
				}
			}
			?>
		</ul>
		<div style="margin:7px 0; text-align:right"><a href="#" class="show-more-fields">+ Show more fields</a><a href="#" class="hide-some-fields" style="display:none">- Hide some fields</a></div>
		<script>
		jQuery(function($) {
			$( "#opl-fields-sortable" ).sortable({
				placeholder: "opl-state-highlight",
			});
			
			$('.show-more-fields').click(function(e){
				$('.opl-more-fields').show("medium");
				$(this).hide();
				$('.hide-some-fields').show();
				e.preventDefault();
			});
			
			$('.hide-some-fields').click(function(e){
				$('.opl-more-fields').hide("medium");
				$(this).hide();
				$('.show-more-fields').show();
				e.preventDefault();
			});
		});
		</script>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-optin-property opl-manual opl-simple-form">
		<label for="opl_name_field"><?php _e('Name Field Label', 'opl'); ?></label>
		<input class="widefat" type="text" name="opl_name_field" id="opl_name_field" value="<?php if ( isset($optin['name_field']) ) echo stripslashes($optin['name_field']); else echo 'Enter your first name'; ?>" />
		<div class="opl-desc"><?php _e('Please enter a label for the name field (e.g. Enter your first name).', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	
	<li class="opl-property opl-optin-property opl-manual opl-simple-form">
		<label for="opl_email_field"><?php _e('Email Field Label', 'opl'); ?></label>
		<input class="widefat" type="text" name="opl_email_field" id="opl_email_field" value="<?php if ( isset($optin['email_field']) ) echo stripslashes($optin['email_field']); else echo 'Enter your email address'; ?>" />
		<div class="opl-desc"><?php _e('Please enter a label for the email address field (e.g. Enter your email address).', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-optin-property opl-manual opl-optin-btn">
		<label><?php _e('Button Type', 'opl'); ?></label>
		<label for="opl_btn_type1" style="display:inline;font-weight:normal"><input type="radio" name="opl_btn_type" id="opl_btn_type1" value="premade"<?php if ( opl_isset($optin['btn_type']) == 'premade' ) echo ' checked="checked" '; ?><?php if ( !isset($optin['btn_type']) ) echo ' checked="checked" '; ?>/> <span class="opl-desc"><code><?php _e('Pre-Made Image Button', 'opl'); ?></code></span></label><br />
		<label for="opl_btn_type2" style="display:inline;font-weight:normal"><input type="radio" name="opl_btn_type" id="opl_btn_type2" value="text"<?php if ( opl_isset($optin['btn_type']) == 'text' ) echo ' checked="checked" '; ?>/> <span class="opl-desc"><code><?php _e('Text/CSS Button', 'opl'); ?></code></span></label><br />
		<label for="opl_btn_type3" style="display:inline;font-weight:normal"><input type="radio" name="opl_btn_type" id="opl_btn_type3" value="upload"<?php if ( opl_isset($optin['btn_type']) == 'upload' ) echo ' checked="checked" '; ?>/> <span class="opl-desc"><code><?php _e('My Own Image Button', 'opl'); ?></code></span></label>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-optin-property opl-manual opl-premade-btn">
		<label for="opl_button_premade"><?php _e('Choose Pre-Made Button', 'opl'); ?></label>
		<select name="opl_button_premade" id="opl_button_premade" class="widefat">
			<optgroup label="Yellow Button">
				<option value="yellow-access-now.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'yellow-access-now.png' ) echo ' selected="selected" '; ?>>Get Access Now! (yellow)</option>
				<option value="yellow-continue.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'yellow-continue.png' ) echo ' selected="selected" '; ?>>Continue... (yellow)</option>
				<option value="yellow-download-now.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'yellow-download-now.png' ) echo ' selected="selected" '; ?>>Download Now (yellow)</option>
				<option value="yellow-early.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'yellow-early.png' ) echo ' selected="selected" '; ?>>YES! Let Me In Early (yellow)</option>
				<option value="yellow-free-report.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'yellow-free-report.png' ) echo ' selected="selected" '; ?>>Get The FREE Report! (yellow)</option>
				<option value="yellow-instant-access.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'yellow-instant-access.png' ) echo ' selected="selected" '; ?>>Get Instant Access (yellow)</option>
				<option value="yellow-next-step.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'yellow-next-step.png' ) echo ' selected="selected" '; ?>>Next Step... (yellow)</option>
				<option value="yellow-register.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'yellow-register.png' ) echo ' selected="selected" '; ?>>Register Now! (yellow)</option>
				<option value="yellow-send-video.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'yellow-send-video.png' ) echo ' selected="selected" '; ?>>Send Me The Video (yellow)</option>
				<option value="yellow-sign-up.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'yellow-sign-up.png' ) echo ' selected="selected" '; ?>>Sign Up Now! (yellow)</option>
				<option value="yellow-waiting-list.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'yellow-waiting-list.png' ) echo ' selected="selected" '; ?>>Get On The Waiting List (yellow)</option>
			</optgroup>
			<optgroup label="Orange Button">
				<option value="orange-access-now.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'orange-access-now.png' ) echo ' selected="selected" '; ?>>Get Access Now! (orange)</option>
				<option value="orange-continue.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'orange-continue.png' ) echo ' selected="selected" '; ?>>Continue... (orange)</option>
				<option value="orange-download-now.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'orange-download-now.png' ) echo ' selected="selected" '; ?>>Download Now (orange)</option>
				<option value="orange-early.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'orange-early.png' ) echo ' selected="selected" '; ?>>YES! Let Me In Early (orange)</option>
				<option value="orange-free-report.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'orange-free-report.png' ) echo ' selected="selected" '; ?>>Get The FREE Report! (orange)</option>
				<option value="orange-instant-access.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'orange-instant-access.png' ) echo ' selected="selected" '; ?>>Get Instant Access (orange)</option>
				<option value="orange-next-step.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'orange-next-step.png' ) echo ' selected="selected" '; ?>>Next Step... (orange)</option>
				<option value="orange-register.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'orange-register.png' ) echo ' selected="selected" '; ?>>Register Now! (orange)</option>
				<option value="orange-send-video.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'orange-send-video.png' ) echo ' selected="selected" '; ?>>Send Me The Video (orange)</option>
				<option value="orange-sign-up.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'orange-sign-up.png' ) echo ' selected="selected" '; ?>>Sign Up Now! (orange)</option>
				<option value="orange-waiting-list.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'orange-waiting-list.png' ) echo ' selected="selected" '; ?>>Get On The Waiting List (orange)</option>
			</optgroup>
			<optgroup label="Red Button">
				<option value="red-access-now.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'red-access-now.png' ) echo ' selected="selected" '; ?>>Get Access Now! (red)</option>
				<option value="red-continue.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'red-continue.png' ) echo ' selected="selected" '; ?>>Continue... (red)</option>
				<option value="red-download-now.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'red-download-now.png' ) echo ' selected="selected" '; ?>>Download Now (red)</option>
				<option value="red-early.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'red-early.png' ) echo ' selected="selected" '; ?>>YES! Let Me In Early (red)</option>
				<option value="red-free-report.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'red-free-report.png' ) echo ' selected="selected" '; ?>>Get The FREE Report! (red)</option>
				<option value="red-instant-access.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'red-instant-access.png' ) echo ' selected="selected" '; ?>>Get Instant Access (red)</option>
				<option value="red-next-step.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'red-next-step.png' ) echo ' selected="selected" '; ?>>Next Step... (red)</option>
				<option value="red-register.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'red-register.png' ) echo ' selected="selected" '; ?>>Register Now! (red)</option>
				<option value="red-send-video.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'red-send-video.png' ) echo ' selected="selected" '; ?>>Send Me The Video (red)</option>
				<option value="red-sign-up.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'red-sign-up.png' ) echo ' selected="selected" '; ?>>Sign Up Now! (red)</option>
				<option value="red-waiting-list.png"<?php if ( stripslashes(opl_isset($optin['button_premade'])) == 'red-waiting-list.png' ) echo ' selected="selected" '; ?>>Get On The Waiting List (red)</option>
			</optgroup>
		</select>
		<div class="opl-desc"><?php _e('Please select a pre-made image button for the optin form.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-optin-property opl-manual opl-text-btn">
		<label for="opl_button_color"><?php _e('Text/CSS Button Color', 'opl'); ?></label>
		<select name="opl_button_color" id="opl_button_color" class="widefat">
			<option value="yellow"<?php if ( stripslashes(opl_isset($optin['button_color'])) == 'yellow' ) echo ' selected="selected" '; ?>>Yellow</option>
			<option value="orange"<?php if ( stripslashes(opl_isset($optin['button_color'])) == 'orange' ) echo ' selected="selected" '; ?>>Orange</option>
			<option value="red"<?php if ( stripslashes(opl_isset($optin['button_color'])) == 'red' ) echo ' selected="selected" '; ?>>Red</option>
			<option value="green"<?php if ( stripslashes(opl_isset($optin['button_color'])) == 'green' ) echo ' selected="selected" '; ?>>Green</option>
			<option value="blue"<?php if ( stripslashes(opl_isset($optin['button_color'])) == 'blue' ) echo ' selected="selected" '; ?>>Blue</option>
		</select>
		<div class="opl-desc"><?php _e('Select a color for the submit button.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-optin-property opl-manual opl-text-btn">
		<label for="opl_button_label"><?php _e('Text/CSS Button Label', 'opl'); ?></label>
		<input class="widefat" type="text" name="opl_button_label" id="opl_button_label" value="<?php if ( isset($optin['button_label']) ) echo stripslashes($optin['button_label']); else echo 'Subscribe Now!'; ?>" />
		<div class="opl-desc"><?php _e('Enter a text label for the submit button (e.g. Subscribe Now!).', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-optin-property opl-manual opl-custom-btn">
		<label for="opl_button_custom"><?php _e('Custom Image Button URL', 'opl'); ?></label>
		<input type="text" name="opl_button_custom" id="opl_button_custom" value="<?php echo opl_isset($optin['button_custom']); ?>" class="widefat uploaded_url" style="width:75%;" />
		<span id="button_custom_upload-btn" class="opl_upload_button button">Upload Button</span>
		<div class="opl-desc"><?php _e('Enter the URL of your custom button image, or click "Upload Button" to upload.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-fb-property">
		<label for="opl_fb_msg"><?php _e('Facebook Wall Message', 'opl'); ?></label>
		<textarea name="opl_fb_msg" id="opl_fb_msg" class="widefat" style="height:60px"><?php if ( isset($optin['fb_msg']) ) echo stripslashes(opl_isset($optin['fb_msg'])); else printf(__('Check out this amazing site', 'opl'), get_permalink($post->ID)); ?></textarea>
		<label for="opl_fb_msg_disable" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_fb_msg_disable" id="opl_fb_msg_disable" value="1"<?php if ( opl_isset($optin['fb_msg_disable']) == 1 ) echo ' checked="checked" '; ?>/> <span class="opl-desc"><code><?php _e('Disable auto-post to subscriber\'s Facebook wall', 'opl'); ?></code></span></label><br />
		<div class="opl-desc"><?php _e('Enter a message that you want to appear in your subscriber\'s Facebook wall. There\'s no need to enter this page URL into the message because InstaBuilder will automatically post the URL. If you want to disable auto-post to subscriber\'s Facebook wall, then you can check the disable option above.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-optin-property opl-fb-property">
		<label for="opl_fb_text"><?php _e('Facebook Connect Text (optional)', 'opl'); ?></label>
		<input class="widefat" type="text" name="opl_fb_text" id="opl_fb_text" value="<?php if ( isset($optin['fb_text']) ) echo stripslashes($optin['fb_text']); else _e('Have a Facebook account?', 'opl'); ?>" />
		<div class="opl-desc"><?php _e('Enter a text that will be displayed above the Facebook connect button. Accepted HTML tag: <code>&lt;span&gt;</code>, <code>&lt;u&gt;</code>, <code>&lt;em&gt;</code>, <code>&lt;i&gt;</code>, <code>&lt;br&gt;</code>', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-optin-property opl-fb-property">
		<label for="opl_fb_label"><?php _e('Facebook Button Label', 'opl'); ?></label>
		<input class="widefat" type="text" name="opl_fb_label" id="opl_fb_label" value="<?php if ( isset($optin['fb_label']) ) echo stripslashes($optin['fb_label']); else _e('Connect With Facebook', 'opl'); ?>" />
		<div class="opl-desc"><?php _e('Enter a text label for the Facebook Connect button (e.g. Connect With Facebook).', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-optin-property">
		<label for="opl_optin_privacy"><?php _e('Short Privacy Notice Text', 'opl'); ?></label>
		<textarea name="opl_optin_privacy" id="opl_optin_privacy" class="widefat" style="height:60px"><?php if ( isset($optin['privacy_text']) ) echo stripslashes($optin['privacy_text']); else echo 'Your privacy is SAFE'; ?></textarea>
		<div class="opl-desc"><?php _e('Enter a short privacy/disclaimer text that will be displayed under the optin form.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-optin-property opl-squeeze">
		<label><?php _e('Smart Optin', 'opl'); ?></label>
		<label for="opl_smart_optin" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_smart_optin" id="opl_smart_optin" value="1"<?php if ( opl_isset($optin['smart_optin']) == 1 ) echo ' checked="checked" '; ?> /> <span class="opl-desc"><code><?php _e('Enable Smart Optin', 'opl'); ?></code></span></label><br />
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-optin-property opl-squeeze opl-smart-optin">
		<label for="opl_smart_page"><?php _e('Optin\'s Thank You Page', 'opl'); ?></label>
		<select name="opl_smart_page" id="opl_smart_page" class="widefat">
			<option value=''>[ -- Select Thank You Page -- ]</option>
			<?php if ( get_pages() ) :
				foreach ( get_pages() as $page ) :
					$selected = ( opl_isset($optin['smart_page']) == $page->ID ) ? ' selected="selected" ' : '';
					echo '<option value="' . $page->ID . '"' . $selected . '>' . $page->post_title . '</option>';
				endforeach; endif;
			?>
		</select>
		<div class="opl-desc"><?php printf(__('Select your optin\'s thank you page so people who already subscribed will be automatically redirected to this thank you page if they visit your squeeze page.', 'opl'), admin_url('nav-menus.php')); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property opl-optin-property opl-squeeze opl-smart-optin">
		<label for="opl_smart_redir"><?php _e('Smart Thank You Page URL', 'opl'); ?></label>
		<input class="widefat" type="text" name="opl_smart_redir" id="opl_smart_redir" value="<?php if ( isset($optin['smart_redir']) ) echo stripslashes($optin['smart_redir']); else _e('Please choose a thank you page first to view the URL', 'opl'); ?>" readonly />
		<div class="opl-desc"><?php _e('Please use this URL when setting up a thank you page URL in your autoresponder account.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	</ul>
<?php
}

function opl_meta_settings( $post ) {
	$value = get_post_meta($post->ID, 'opl_settings', true);
	$header = get_post_meta($post->ID, 'opl_headers', true);
	$optin = opl_isset($value['optin']);
	$headline = opl_isset($value['headline']);
	$templates = opl_get_templates();
	$colors = ( opl_isset($value['template']) != '' ) ? opl_get_template_color($value['template']) : opl_default_template_color();
	$menus = opl_get_menus();
	
	echo '<input type="hidden" name="opl_meta_nonce" id="opl_meta_nonce" value="' . wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	echo '<input type="hidden" name="opl_post_id" id="opl_post_id" value="' . $post->ID . '" />';
?>

	<ul id="opl-meta" class="opl-page-enable">
	<li>
		<label><?php _e('Enable InstaBuilder', 'opl'); ?></label>
		<label for="enable_opl" style="display:inline;font-weight:normal"><input type="checkbox" name="enable_opl" id="enable_opl" value="1"<?php if ( opl_isset($value['enable_opl']) == 1 ) echo ' checked="checked" '; ?>/> <span class="opl-desc"><code><?php _e('Turn this page into a landing page', 'opl'); ?></code></span></label>
		<div class="opl-hr"></div>
	</li>
	</ul>
	
	<div id="opl-set-tabs">
		<div id="opl-set-left" class="opl-set-col" style="float:left; width:22%;">
		<ul id="opl-admin-tabs">
			<li><a href="#" rel="opl-tab-main" class="opl-tab-link opl-tab-selected opl-tab-link-main">Main</a></li>
			<li><a href="#" rel="opl-tab-background" class="opl-tab-link opl-tab-link-background">Custom Background</a></li>
			<li><a href="#" rel="opl-tab-logo" class="opl-tab-link opl-tab-link-logo">Logo</a></li>
			<li><a href="#" rel="opl-tab-optin" class="opl-tab-link opl-tab-link-optin">Opt-In</a></li>
			<li><a href="#" rel="opl-tab-video" class="opl-tab-link opl-tab-link-video">Video</a></li>
			<li class="opl-launch-navi-tab"><a href="#" rel="opl-tab-launch" class="opl-tab-link opl-tab-link-launch">Launch Navigation</a></li>
			<li><a href="#" rel="opl-tab-comment" class="opl-tab-link opl-tab-link-comment">Comment</a></li>
			<li><a href="#" rel="opl-tab-share" class="opl-tab-link opl-tab-link-share">Sharing</a></li>
			<li><a href="#" rel="opl-tab-exit" class="opl-tab-link opl-tab-link-exit">Exit Redirect</a></li>
			<li><a href="#" rel="opl-tab-viral" class="opl-tab-link opl-tab-link-viral">Viral Download</a></li>
			<li><a href="#" rel="opl-tab-scripts" class="opl-tab-link opl-tab-link-scripts">Scripts</a></li>
			<li><a href="#" rel="opl-tab-mobile" class="opl-tab-link opl-tab-link-mobile">Mobile Switcher</a></li>
		</ul>
		</div>
		<div id="opl-set-right" class="opl-set-col" style="float:left; width:78%; background-color:#FFF; min-height:400px;">
			<div id="opl-tab-main" style="padding:0 15px">
				<h2 class="opl-tab-title">Main Settings</h2>
				<ul id="opl-meta">
					<li class="opl-property">
						<label for="opl_type"><?php _e('Page Type', 'opl'); ?></label>
						<select name="opl_type" id="opl_type" class="widefat">
							<option value="front"<?php if ( opl_isset($value['type']) == 'front' ) echo ' selected="selected" '; ?>>Squeeze Page</option>
							<option value="optin"<?php if ( opl_isset($value['type']) == 'optin' ) echo ' selected="selected" '; ?>>Mini Squeeze Page</option>
							<option value="single"<?php if ( opl_isset($value['type']) == 'single' ) echo ' selected="selected" '; ?>>Single Column Page (for sales page, optin confirmation, thank you/download page, etc)</option>
							<option value="video"<?php if ( opl_isset($value['type']) == 'video' ) echo ' selected="selected" '; ?>>Video Page (for video sales page, launch page, etc)</option>
							<option value="launch"<?php if ( opl_isset($value['type']) == 'launch' ) echo ' selected="selected" '; ?>>Product Launch Page</option>
						</select>
						<div class="opl-desc"><?php _e('Select the type of landing page you want to create.', 'opl'); ?></div>
						<div class="opl-hr"></div>
					</li>
					<li class="opl-property opl-single-property">
						<label for="opl_width"><?php _e('Page Width', 'opl'); ?></label>
						<select name="opl_width" id="opl_width" class="widefat">
							<option value="700"<?php if ( opl_isset($value['width']) == '700' ) echo ' selected="selected" '; ?>>700px</option>
							<option value="720"<?php if ( opl_isset($value['width']) == '720' ) echo ' selected="selected" '; ?>>720px</option>
							<option value="760"<?php if ( opl_isset($value['width']) == '760' ) echo ' selected="selected" '; ?>>760px</option>
							<option value="780"<?php if ( opl_isset($value['width']) == '780' ) echo ' selected="selected" '; ?>>780px</option>
							<option value="800"<?php if ( opl_isset($value['width']) == '800' ) echo ' selected="selected" '; ?>>800px</option>
							<option value="820"<?php if ( opl_isset($value['width']) == '820' ) echo ' selected="selected" '; ?>>820px</option>
							<option value="860"<?php if ( opl_isset($value['width']) == '860' ) echo ' selected="selected" '; ?><?php if ( !isset($value['width']) ) echo ' selected="selected" '; ?>>860px</option>
							<option value="880"<?php if ( opl_isset($value['width']) == '880' ) echo ' selected="selected" '; ?>>880px</option>
							<option value="900"<?php if ( opl_isset($value['width']) == '900' ) echo ' selected="selected" '; ?>>900px</option>
							<option value="920"<?php if ( opl_isset($value['width']) == '920' ) echo ' selected="selected" '; ?>>920px</option>
							<option value="960"<?php if ( opl_isset($value['width']) == '960' ) echo ' selected="selected" '; ?>>960px</option>
							<option value="980"<?php if ( opl_isset($value['width']) == '980' ) echo ' selected="selected" '; ?>>980px</option>
						</select>
						<div class="opl-desc"><?php _e('Choose the page width for the single column page.', 'opl'); ?></div>
						<div class="opl-hr"></div>
					</li>
					<li class="opl-property">
						<label for="opl_template"><?php _e('Page Design', 'opl'); ?></label>
						<select name="opl_template" id="opl_template" class="widefat">
						<?php if ( $templates ) : foreach ( $templates as $k => $v ) :
							$selected = ( $k == opl_isset($value['template']) ) ? ' selected="selected"' : '';
							echo '<option value="' . $k . '"' . $selected . '>' . opl_isset($v['name']) . '</option>';
						endforeach; endif; ?>
						</select>
						<div class="opl-desc"><?php _e('Select a cool template for your squeeze page.', 'opl'); ?></div>
						<div class="opl-hr"></div>
					</li>
					<li class="opl-property">
						<label for="opl_color"><?php _e('Page Design Color', 'opl'); ?></label>
						<select name="opl_color" id="opl_color" class="widefat">
						<?php $color = explode(",", $colors);
							if ( count($color) > 0 ) :
								for ( $i=0; $i<count($color); $i++ ) :
									$selected = ( $color[$i] == opl_isset($value['color']) ) ? ' selected="selected"' : '';
									echo '<option value="' . $color[$i] . '"' . $selected . '>' . ucwords($color[$i]) . '</option>';
								endfor;
							endif;
						 ?>
						</select>
						<div class="opl-desc"><?php _e('Select one of the template\'s color theme that you\'d like to use.', 'opl'); ?></div>
						<div class="opl-hr"></div>
					</li>
					<li class="opl-property">
						<label for="opl_headline"><?php _e('Headline Area', 'opl'); ?></label>
						<?php if ( post_type_supports('page', 'editor') ) : ?>
						<?php $headline_val = ( isset($headline['text']) ) ? stripslashes($headline['text']) : '<h1 style="text-align:center; color:#cc0000">Your Headline Goes Here</h1>'; ?>
        				<?php wp_editor($headline_val, 'oplheadline', array('textarea_name' => 'opl_headline' ) ); ?>
						<?php endif; ?>
						<div class="opl-desc"><?php _e('You can enter a headline for this page.', 'opl'); ?></div>
						<div class="opl-hr"></div>
					</li>
					<li class="opl-property">
						<label for="opl_top_nav"><?php _e('Top Navigation', 'opl'); ?></label>
						<select name="opl_top_nav" id="opl_top_nav" class="widefat">
							<option value=""<?php if ( opl_isset($value['top_nav']) == '' ) echo ' selected="selected" '; ?>>-- Do NOT show menu --</option>
							<?php if ( $menus ) :
								foreach ( $menus as $menu ) :
									$selected = ( opl_isset($value['top_nav']) == $menu->name ) ? ' selected="selected" ' : '';
									echo '<option value="' . $menu->name . '"' . $selected . '>' . $menu->name . '</option>';
								endforeach; endif; 
							?>
						</select>
						<div class="opl-desc"><?php printf(__('Select a menu that you want to display on the header. If you don\'t have a menu, you can create it first on <a href="%s" target="_blank">Appearance -> Menus</a>.', 'opl'), admin_url('nav-menus.php')); ?></div>
						<div class="opl-hr"></div>
					</li>
					
					<li class="opl-property">
						<label for="opl_footer_nav"><?php _e('Footer Navigation', 'opl'); ?></label>
						<select name="opl_footer_nav" id="opl_footer_nav" class="widefat">
							<option value=""<?php if ( opl_isset($value['footer_nav']) == '' ) echo ' selected="selected" '; ?>>-- Do NOT show menu --</option>
							<?php if ( $menus ) :
								foreach ( $menus as $menu ) :
									$selected = ( opl_isset($value['footer_nav']) == $menu->name ) ? ' selected="selected" ' : '';
									echo '<option value="' . $menu->name . '"' . $selected . '>' . $menu->name . '</option>';
								endforeach; endif; 
							?>
						</select>
						<div class="opl-desc"><?php printf(__('Select a menu that you want to display on the footer. If you don\'t have a menu, you can create it first on <a href="%s" target="_blank">Appearance -> Menus</a>.', 'opl'), admin_url('nav-menus.php')); ?></div>
						<div class="opl-hr"></div>
					</li>
					<li class="opl-property">
						<label for="opl_footer_text"><?php _e('Additional Text On Footer', 'opl'); ?></label>
						<textarea name="opl_footer_text" id="opl_footer_text" class="widefat" style="height:60px"><?php if ( isset($value['footer_text']) ) echo stripslashes($value['footer_text']); else echo 'Copyright &copy; ' . date("Y", time()) . ' ' . get_bloginfo('title') . '. All rights reserved.'; ?></textarea>
						<div class="opl-desc"><?php _e('You can enter any additional text for the footer. Accepted HTML tag: <code>&lt;p&gt;</code>, <code>&lt;span&gt;</code>, <code>&lt;a&gt;</code>, <code>&lt;img&gt;</code>, <code>&lt;strong&gt;</code>, <code>&lt;b&gt;</code>, <code>&lt;u&gt;</code>, <code>&lt;em&gt;</code>, <code>&lt;i&gt;</code>, <code>&lt;br&gt;</code>', 'opl'); ?></div>
						<div class="opl-hr"></div>
					</li>
					<li class="opl-property opl-oto">
						<label><?php _e('One Time Offer', 'opl'); ?></label>
						<label for="opl_oto" style="display:inline;font-weight:normal"><input type="checkbox" name="opl_oto" id="opl_oto" value="1"<?php if ( opl_isset($value['opl_oto']) == 1 ) echo ' checked="checked" '; ?> /> <span class="opl-desc"><code><?php _e('Enable One Time Offer', 'opl'); ?></code></span></label><br />
						<div class="opl-desc"><?php _e('If you enable this feature, then this landing page can only be viewed once by your visitors.', 'opl'); ?></div>
						<div class="opl-hr"></div>
					</li>
					<li class="opl-property opl-oto opl-oto-property">
						<label for="opl_oto_redir"><?php _e('OTO Redirect Page', 'opl'); ?></label>
						<select name="opl_oto_redir" id="opl_oto_redir" class="widefat">
							<option value=''>[ -- Select OTO Redirect Page -- ]</option>
							<?php if ( get_pages() ) :
								foreach ( get_pages() as $page ) :
									$selected = ( opl_isset($value['oto_redir']) == $page->ID ) ? ' selected="selected" ' : '';
									echo '<option value="' . $page->ID . '"' . $selected . '>' . $page->post_title . '</option>';
								endforeach; endif;
							?>
						</select>
						<div class="opl-desc"><?php _e('Please select an OTO redirect page. Visitors who already viewed or skipped your OTO will be redirected to this page if they are trying to access your OTO for the second time.', 'opl'); ?></div>
						<div class="opl-hr"></div>
					</li>
				</ul>
			</div>
			
			<div id="opl-tab-background" style="padding:0 15px; display:none;">
				<h2 class="opl-tab-title">Custom Background Settings</h2>
				<?php opl_meta_background( $post ); ?>
			</div>
			
			<div id="opl-tab-logo" style="padding:0 15px; display:none;">
				<h2 class="opl-tab-title">Logo Settings</h2>
				<?php opl_meta_headers( $post ); ?>
			</div>
			
			<div id="opl-tab-optin" style="padding:0 15px; display:none;">
				<h2 class="opl-tab-title">Optin Form Settings</h2>
				<?php opl_meta_optin( $post ); ?>
			</div>
			
			<div id="opl-tab-video" style="padding:0 15px; display:none;">
				<h2 class="opl-tab-title">Video Settings</h2>
				<?php opl_meta_video( $post ); ?>
			</div>
			
			<div id="opl-tab-launch" style="padding:0 15px; display:none;">
				<h2 class="opl-tab-title">Launch Navigation</h2>
				<?php opl_meta_launch( $post ); ?>
			</div>
			
			<div id="opl-tab-comment" style="padding:0 15px; display:none;">
				<h2 class="opl-tab-title">Social Comments Settings</h2>
				<?php opl_meta_comments( $post ); ?>
			</div>
			
			<div id="opl-tab-share" style="padding:0 15px; display:none;">
				<h2 class="opl-tab-title">Social Sharing Settings</h2>
				<?php opl_meta_social( $post ); ?>
			</div>
			
			<div id="opl-tab-exit" style="padding:0 15px; display:none;">
				<h2 class="opl-tab-title">Exit Redirect Settings</h2>
				<?php opl_meta_exit( $post ); ?>
			</div>
			
			<div id="opl-tab-viral" style="padding:0 15px; display:none;">
				<h2 class="opl-tab-title">Viral Download Lock Settings</h2>
				<?php opl_meta_viral( $post ); ?>
			</div>
			
			<div id="opl-tab-scripts" style="padding:0 15px; display:none;">
				<h2 class="opl-tab-title">Additional Scripts/Code Settings</h2>
				<?php opl_meta_script( $post ); ?>
			</div>
			
			<div id="opl-tab-mobile" style="padding:0 15px; display:none;">
				<h2 class="opl-tab-title">Mobile Page Switcher</h2>
				<?php opl_meta_mobile( $post ); ?>
			</div>
		</div>
		<div style="clear:left"></div>
	</div>
	<script>
		jQuery(document).ready(function($){
			//var highestCol = Math.max($('#opl-set-left').height(),$('#opl-set-right').height());
			//if ( highestCol < 5 )
				//highestCol = 1200;
				
			//$('.opl-set-col').height(highestCol);
			$('.opl-tab-link').each(function(){
				var $this = $(this);
				$this.click(function(e){
					var oldRel = $this.parent().parent().find('.opl-tab-selected').attr('rel');
					var newRel = $this.attr('rel');
					$this.parent().parent().find('.opl-tab-selected').removeClass('opl-tab-selected');
					$this.addClass('opl-tab-selected');
					$('#' + oldRel).hide();
					$('#' + newRel).fadeIn("medium");
					//var newheight = $('#' + newRel).height();
					//$('.opl-set-col').height(newheight + 100);
					e.preventDefault();
				});
			});
		});
	</script>

<?php
}

add_action( 'save_post', 'opl_save_meta' );
function opl_save_meta( $post_id ) {
	$opl_meta_nonce = opl_isset($_POST['opl_meta_nonce']);
	if ( !wp_verify_nonce( $opl_meta_nonce, plugin_basename(__FILE__) ) ) { 
		return $post_id;
	}
    
	if ( 'page' == $_POST['post_type']  ) {
    	if ( !current_user_can( 'edit_page', $post_id ) ) return $post_id;
    } else {
      	if ( !current_user_can( 'edit_post', $post_id ) ) return $post_id;
    }

	$adv_fields = opl_isset($_POST['opl_adv_fields']);
	$fields = '';
	if ( is_array($adv_fields) ) {
		$fields = array();
		foreach ( $adv_fields as $k => $v ) {
			$fields[] = array(
									'type' => $k,
									'label' => strip_tags($v['label']),
									'show' => ( $k == 'email' ) ? 1 : (( opl_isset($v['show']) == 1 ) ? 1 : 0),
									'title' => $v['title']
								); 
		}
	}
	
	$fb_like = ( isset($_POST['opl_fb_like']) ) ? 1 : 0;
	$fb_connect = ( isset($_POST['opl_subs_method_fb']) ) ? 1 : 0;
	$fb_comment = ( isset($_POST['opl_fb_comment']) ) ? 1 : 0;
	$smart_optin = ( isset($_POST['opl_smart_optin']) ) ? 1 : 0;
	
	$meta = array(
		'enable_opl' => ( isset($_POST['enable_opl']) ) ? 1 : 0,
		'edit_mode' => $_POST['opl_edit_mode'],
		'type' => $_POST['opl_type'],
		'width' => $_POST['opl_width'],
		'template' => $_POST['opl_template'],
		'color' => $_POST['opl_color'],
		'mobile' => array(
					'mobilesw' => ( isset($_POST['opl_mobilesw']) ) ? 1 : 0,
					'mobilesw_dest' => $_POST['opl_mobilesw_dest'],
					'mobilesw_notablet' => ( isset($_POST['opl_mobilesw_notablet']) ) ? 1 : 0,
			),
		'headline' => array(
				'text' => trim($_POST['opl_headline']),
			),
		'ar_code' => $_POST['opl_arcode'],
		'optin' => array(
				'title' => trim(strip_tags($_POST['opl_optin_title'], '<i><em><u><span><br>')),
				'text' => trim(strip_tags($_POST['opl_optin_text'], '<i><a><b><strong><em><u><span><br>')),
				'subs_method_manual' => ( isset($_POST['opl_subs_method_manual']) ) ? 1 : 0,
				'subs_method_fb' => $fb_connect,
				'name_field' => trim(strip_tags($_POST['opl_name_field'])),
				'email_field' => trim(strip_tags($_POST['opl_email_field'])),
				'btn_type' => $_POST['opl_btn_type'],
				'button_premade' => $_POST['opl_button_premade'],
				'button_color' => $_POST['opl_button_color'],
				'button_label' => trim(strip_tags($_POST['opl_button_label'])),
				'button_custom' => trim(strip_tags($_POST['opl_button_custom'])),
				'privacy_text' => trim(strip_tags($_POST['opl_optin_privacy'])),
				'fb_text' => trim(strip_tags($_POST['opl_fb_text'], '<i><em><u><span><br>')),
				'fb_label' => trim(strip_tags($_POST['opl_fb_label'])),
				'fb_msg' => trim(strip_tags($_POST['opl_fb_msg'])),
				'fb_msg_disable' => ( isset($_POST['opl_fb_msg_disable']) ) ? 1 : 0,
				'subs_method_fb' => $fb_connect,
				'smart_optin' => $smart_optin,
				'smart_page' => $_POST['opl_smart_page'],
				'smart_redir' => $_POST['opl_smart_redir'],
				'form_mode' => $_POST['opl_fields_mode'],
				'adv_fields' => $fields
			),
		'top_nav' => $_POST['opl_top_nav'],
		'footer_nav' => $_POST['opl_footer_nav'],
		'footer_text' => trim(strip_tags($_POST['opl_footer_text'], '<p><img><i><a><b><strong><em><u><span><br>')),
		'fb_comment' => $fb_comment,
		'dq_comment' => ( isset($_POST['opl_dq_comment']) ) ? 1 : 0,
		'comment_title' => trim(strip_tags($_POST['opl_comment_title'], '<i><a><b><strong><em><u><span><br>')),
		'comment_color' => $_POST['opl_comment_color'],
		'comment_font' => $_POST['opl_comment_font'],
		'comment_size' => $_POST['opl_comment_size'],
		'opl_oto' => ( isset($_POST['opl_oto']) ) ? 1 : 0,
		'oto_redir' => $_POST['opl_oto_redir'],
		'head_code' => trim($_POST['opl_head_code']),
		'body_code' => trim($_POST['opl_body_code']),
		'footer_code' => trim($_POST['opl_footer_code']),
		'video_settings' => array(
				'insertion' => $_POST['opl_video_insert'],
				'video_url' => trim(strip_tags($_POST['opl_video_url'])),
				'ivideo_url' => trim(strip_tags($_POST['opl_ivideo_url'])),
				'video_player' => $_POST['opl_video_player'],
				'video_scr' => trim(strip_tags($_POST['opl_video_scr'])),
				'video_code' => trim($_POST['opl_video_code']),
				'autoplay' => ( isset($_POST['opl_video_autoplay']) ) ? 1 : 0,
				'autohide' => ( isset($_POST['opl_video_autohide']) ) ? 1 : 0,
				'disable_control' => ( isset($_POST['opl_disable_control']) ) ? 1 : 0,
				'video_width' => trim(strip_tags($_POST['opl_video_width'])),
				'video_height' => trim(strip_tags($_POST['opl_video_height']))
			),
		'buy_settings' => array(
				'under_content' => $_POST['opl_under_content'],
				'order_area' => trim($_POST['opl_buy_area']),
				'delay_hour' => $_POST['opl_delay_hour'],
				'delay_min' => $_POST['opl_delay_min'],
				'delay_sec' => $_POST['opl_delay_sec']
			),
		'social_settings' => array(
				'fb_like' => $fb_like,
				'tw_share' => ( isset($_POST['opl_tw_share']) ) ? 1 : 0,
				'pin_share' => ( isset($_POST['opl_pin_share']) ) ? 1 : 0,
				'g1_share' => ( isset($_POST['opl_g1_share']) ) ? 1 : 0,
				'lin_share' => ( isset($_POST['opl_lin_share']) ) ? 1 : 0,
				'su_share' => ( isset($_POST['opl_su_share']) ) ? 1 : 0,
				'social_pos' => $_POST['opl_social_pos']
			),
		'exit_settings' => array(
				'opl_exit' => ( isset($_POST['opl_exit']) ) ? 1 : 0,
				'exit_url' => trim(strip_tags($_POST['opl_exit_url'])),
				'exit_msg' => trim(strip_tags($_POST['opl_exit_msg']))
			),
		'use_facebook' => ( opl_use_facebook( $fb_connect, $fb_comment, $fb_like ) ) ? 1 : 0,
		'viral' => array(
				'content' => trim($_POST['opl_viral_content']),
				'viral_fb' => ( isset($_POST['opl_viral_fb']) ) ? 1 : 0,
				'viral_tw' => ( isset($_POST['opl_viral_tw']) ) ? 1 : 0,
				'viral_fburl' => trim(strip_tags($_POST['opl_viral_fburl'])),
				'viral_fbtitle' => trim(strip_tags($_POST['opl_viral_fbtitle'])),
				'viral_fbdesc' => trim(strip_tags($_POST['opl_viral_fbdesc'])),
				'viral_fbimg' => trim(strip_tags($_POST['opl_viral_fbimg'])),
				'viral_tweet' => trim(strip_tags($_POST['opl_viral_tweet'])),
				'viral_download' => trim(strip_tags($_POST['opl_viral_download'])),
				'viral_btnclr' => trim(strip_tags($_POST['opl_viral_btnclr'])),
				'viral_btntxt' => trim(strip_tags($_POST['opl_viral_btntxt']))
			),
		'launch' => array(
				'launchbar_pos' => $_POST['opl_launchbar_pos'],
				'items' => $_POST['opl_launch_item']
			),
		'bg' => array(
				'opl_bodybg' => ( isset($_POST['opl_bodybg']) ) ? 1 : 0,
				'bodybg_color' => trim($_POST['opl_bodybg_color']),
				'bodybg_url' => trim($_POST['opl_bodybg_url']),
				'bodybg_pos' => trim($_POST['opl_bodybg_pos']),
				'bodybg_repeat' => trim($_POST['opl_bodybg_repeat']),
				'bodybg_size' => ( isset($_POST['opl_bodybg_size']) ) ? 1 : 0,
				'bodybg_pos' => trim($_POST['opl_bodybg_pos']),
				'bodybg_att' => trim($_POST['opl_bodybg_att']),
				'opl_headerbg' => ( isset($_POST['opl_headerbg']) ) ? 1 : 0,
				'headerbg_url' => trim($_POST['opl_headerbg_url']),
				'headerbg_pos' => trim($_POST['opl_headerbg_pos']),
				'headerbg_repeat' => trim($_POST['opl_headerbg_repeat']),
				'headerbg_pos' => trim($_POST['opl_headerbg_pos']),
				'headerbg_height' => trim(strip_tags($_POST['opl_headerbg_height'])),
				'headerbg_wide' => ( isset($_POST['opl_headerbg_wide']) ) ? 1 : 0,
			)
	);
	
	$headers = array(
		'opl_header' => ( isset($_POST['opl_header']) ) ? 1 : 0,
		'logo_type' => $_POST['opl_logo_type'],
		'logo_url' => $_POST['opl_logo_url'],
		'text_logo' => trim($_POST['opl_text_logo']),
		'logo_color' => $_POST['opl_logo_color'],
		'logo_font' => $_POST['opl_logo_font'],
		'logo_size' => $_POST['opl_logo_size'],
		'logo_align' => $_POST['opl_logo_align']
	);

	
	update_post_meta( $post_id, 'opl_settings', $meta );
	update_post_meta( $post_id, 'opl_headers', $headers );
	
	if ( $smart_optin == 1 ) {
		$ty_id = (int) $_POST['opl_smart_page'];
		$opl_smart = array(
				'smart_page' => 1,
				'squeeze_id' => $post_id
		);
		
		update_post_meta( $ty_id, 'opl_smart_settings', $opl_smart);
	}
}

function opl_use_facebook( $connect, $comment, $like ) {
	if ( $connect == 1 )
		return true;
	
	if ( $comment == 1 )
		return true;
	
	if ( $like == 1 )
		return true;
	
	return false;
}

function opl_advfields_default() {
	$fields = array();
	$fields[] = array(
					'type' => 'email',
					'label' => 'Your email address...',
					'show' => 1,
					'title' => 'Email Address'
			);
	$fields[] = array(
					'type' => 'first_name',
					'label' => 'Your first name...',
					'show' => 1,
					'title' => 'First Name'
			);
	$fields[] = array(
					'type' => 'last_name',
					'label' => 'Your last name...',
					'show' => 0,
					'title' => 'Last Name'
			);
	$fields[] = array(
					'type' => 'addr',
					'label' => 'Your address...',
					'show' => 0,
					'title' => 'Address'
			);
	$fields[] = array(
					'type' => 'city',
					'label' => 'Your city...',
					'show' => 0,
					'title' => 'City'
			);
	$fields[] = array(
					'type' => 'state',
					'label' => 'Your state...',
					'show' => 0,
					'title' => 'State'
			);
	$fields[] = array(
					'type' => 'zip',
					'label' => 'Your zip...',
					'show' => 0,
					'title' => 'Zip'
			);
	$fields[] = array(
					'type' => 'phone',
					'label' => 'Your phone #...',
					'show' => 0,
					'title' => 'Phone'
			);
	$fields[] = array(
					'type' => 'fax',
					'label' => 'Your fax #...',
					'show' => 0,
					'title' => 'Fax'
			);
	$fields[] = array(
					'type' => 'custom1',
					'label' => 'Custom Field #1...',
					'show' => 0,
					'title' => 'Custom Field #1'
			);
	$fields[] = array(
					'type' => 'custom2',
					'label' => 'Custom Field #2...',
					'show' => 0,
					'title' => 'Custom Field #2'
			);
	$fields[] = array(
					'type' => 'custom3',
					'label' => 'Custom Field #3...',
					'show' => 0,
					'title' => 'Custom Field #3'
			);
	$fields[] = array(
					'type' => 'custom4',
					'label' => 'Custom Field #4...',
					'show' => 0,
					'title' => 'Custom Field #4'
			);
	$fields[] = array(
					'type' => 'custom5',
					'label' => 'Custom Field #5...',
					'show' => 0,
					'title' => 'Custom Field #5'
			);
			
	return $fields;
}
