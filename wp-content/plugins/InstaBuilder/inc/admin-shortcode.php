<?php if ( !defined('ABSPATH') ) die('No direct access');
add_action('init', 'opl_addbuttons');
function opl_addbuttons() {
	// Don't bother doing this stuff if the current user lacks permissions
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
		return;
 
	// Add only in Rich Editor mode
	if ( get_user_option('rich_editing') == 'true') {
		add_filter("mce_external_plugins", "add_opl_tinymce_plugin");
		if ( defined('PT_REL_SCRIPTS') || defined('PVM_PATH') )
			add_filter('mce_buttons_4', 'register_opl_button');
		else
			add_filter('mce_buttons_3', 'register_opl_button');
	}
}
 
function register_opl_button($buttons) {
	array_unshift($buttons, "optinlite");
	return $buttons;
}
 
function add_opl_tinymce_plugin($plugin_array) {
	$plugin_array['optinlite'] = OPL_URL . 'js/tinymce/editor_plugin.js';
	return $plugin_array;
}

/*
add_action('admin_footer', 'opl_media_shortcodes');
function opl_media_shortcodes() {
	echo '<div id="opl-shortcodes" style="display:none">';
	?>
	<ul id="opl-meta" style="margin-top:20px;">
	<li class="opl-property">
		<label for="opl_insert_sc"><?php _e('What Do You Want To Insert?', 'opl'); ?></label>
		<select name="opl_insert_sc" id="opl_insert_sc" class="widefat">
			<option value="">[ -- Select Shortcode -- ]</option>
			<optgroup label="Videos">
				<option value="opl-sc-video">MP4 Video</option>
				<option value="opl-sc-youtube">YouTube Video</option>
				<option value="opl-sc-vimeo">Vimeo Video</option>
			</optgroup>
			<optgroup label="Buttons">
				<option value="opl-sc-button">Standard Button</option>
				<option value="opl-sc-big-button">Big Button</option>
			</optgroup>
		</select>
		<div class="opl-desc"><?php _e('Select one of the shortcode you want to insert, set the parameters, and then click the "Insert To Post" button.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	</ul>
	
	<ul id="opl-meta" class="opl-sc-video opl-sc-property" style="display:none">
	<li class="opl-property"><strong>Video Parameters</strong></li>
	<li class="opl-property">
		<label for="oplsc_video_url" style="font-weight:normal !important;"><?php _e('MP4/H.264 Video URL', 'opl'); ?></label>
		<input class="widefat" type="text" name="oplsc_video_url" id="oplsc_video_url" />
		<div class="opl-desc"><?php _e('Please enter a valid video URL (must include http://). We recommend you to use a MP4/H.264 video, instead of Flash or FLV video, as it can be played on PC/Mac, and also supported by iPad, iPhone, and Android. You can use <a href="http://handbrake.fr/downloads.php" target="_blank">Handbrake</a> or <a href="http://www.mirovideoconverter.com/" target="_blank">Miro</a> to convert your video into MP4/H.264 video.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label for="oplsc_ivideo_url" style="font-weight:normal !important;"><?php _e('WebM Video URL (optional)', 'opl'); ?></label>
		<input class="widefat" type="text" name="oplsc_ivideo_url" id="oplsc_ivideo_url" />
		<div class="opl-desc"><?php _e('Please enter a valid WebM video URL (must include http://). This is an optional option but recommended to include a WebM version of your video to increase compatibility with more browsers and mobile devices. You can use <a href="http://firefogg.org/" target="_blank">Firefogg</a> (Firefox users only) or <a href="http://www.mirovideoconverter.com/" target="_blank">Miro</a> to convert your video into WebM video.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<?php $jw_disable = ( !function_exists('jwplayer_plugin_menu') ) ? ' disabled="disabled"' : ''; ?>
	<li class="opl-property">
		<label for="oplsc_video_player" style="font-weight:normal !important;"><?php _e('Video Player', 'opl'); ?></label>
		<select name="oplsc_video_player" id="oplsc_video_player" class="widefat">
			<option value="flow">Flowplayer</option>
			<option value="jw"<?php echo $jw_disable; ?>>JW Player</option>
		</select>
		<div class="opl-desc"><?php printf(__('Choose a video player to playback your video. You have to install and activate <a href="%s" target="_blank">JW Player for WordPress</a> by <a href="http://www.longtailvideo.com" target="_blank">LongTail Video, Inc</a> if you want to use JW Player.', 'opl'), admin_url('plugin-install.php?tab=search&type=term&s=JW+Player&plugin-search-input=Search+Plugins') ); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label for="oplsc_video_scr" style="font-weight:normal !important;"><?php _e('Video Splash Image URL (optional)', 'opl'); ?></label>
		<input type="text" name="oplsc_video_scr" id="oplsc_video_scr" class="widefat uploaded_url" />
		<div class="opl-desc"><?php _e('Enter a valid URL of your video splash image.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label style="font-weight:normal !important;"><?php _e('Video Options', 'opl'); ?></label>
		<label for="oplsc_video_autoplay" style="display:inline;font-weight:normal"><input type="checkbox" name="oplsc_video_autoplay" id="oplsc_video_autoplay" value="1" /> <span class="opl-desc"><code><?php _e('Autoplay Video', 'opl'); ?></code></span></label><br />
		<label for="oplsc_video_autohide" style="display:inline;font-weight:normal"><input type="checkbox" name="oplsc_video_autohide" id="oplsc_video_autoplay" value="1" /> <span class="opl-desc"><code><?php _e('Auto Hide Video Control', 'opl'); ?></code></span></label><br />
		<label for="oplsc_disable_control" style="display:inline;font-weight:normal"><input type="checkbox" name="oplsc_disable_control" id="oplsc_disable_control" value="1" /> <span class="opl-desc"><code><?php _e('Disable Video Control', 'opl'); ?></code></span></label><br />
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label for="oplsc_video_width" style="font-weight:normal !important;"><?php _e('Video Size', 'opl'); ?></label>
		Width: <input type="text" name="oplsc_video_width" id="opl_video_width" value="640" />
		Height: <input type="text" name="oplsc_video_height" id="opl_video_height" value="360" />
		<div class="opl-desc"><?php _e('Please enter the exact width of your video so it can be displayed correctly.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	</ul>
	
	<ul id="opl-meta" class="opl-sc-youtube opl-sc-property" style="display:none">
	<li class="opl-property"><strong>YouTube Video Parameters</strong></li>
	<li class="opl-property">
		<label for="oplsc_yt_url" style="font-weight:normal !important;"><?php _e('YouTube Video URL', 'opl'); ?></label>
		<input class="widefat" type="text" name="oplsc_yt_url" id="oplsc_yt_url" />
		<div class="opl-desc"><?php _e('Please enter a valid YouTube video URL (e.g. <code>http://youtu.be/A2CdeFg3ij4</code> or <code>http://www.youtube.com/watch?v=A2CdeFg3ij4</code>).', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label style="font-weight:normal !important;"><?php _e('Video Options', 'opl'); ?></label>
		<label for="oplsc_yt_autoplay" style="display:inline;font-weight:normal"><input type="checkbox" name="oplsc_yt_autoplay" id="oplsc_yt_autoplay" value="1" /> <span class="opl-desc"><code><?php _e('Autoplay Video', 'opl'); ?></code></span></label><br />
		<label for="oplsc_yt_autohide" style="display:inline;font-weight:normal"><input type="checkbox" name="oplsc_yt_autohide" id="oplsc_yt_autohide" value="1" /> <span class="opl-desc"><code><?php _e('Auto Hide Video Control', 'opl'); ?></code></span></label><br />
		<label for="oplsc_yt_disable_ctrl" style="display:inline;font-weight:normal"><input type="checkbox" name="oplsc_yt_disable_ctrl" id="oplsc_yt_disable_ctrl" value="1" /> <span class="opl-desc"><code><?php _e('Disable Video Control', 'opl'); ?></code></span></label><br />
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label for="oplsc_yt_width" style="font-weight:normal !important;"><?php _e('Video Size', 'opl'); ?></label>
		Width: <input type="text" name="oplsc_yt_width" id="opl_yt_width" value="640" />
		Height: <input type="text" name="oplsc_yt_height" id="opl_yt_height" value="360" />
		<div class="opl-desc"><?php _e('Please enter the exact width of your video so it can be displayed correctly.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	</ul>
	
	<ul id="opl-meta" class="opl-sc-vimeo opl-sc-property" style="display:none">
	<li class="opl-property"><strong>Vimeo Video Parameters</strong></li>
	<li class="opl-property">
		<label for="oplsc_vm_url" style="font-weight:normal !important;"><?php _e('Vimeo Video URL', 'opl'); ?></label>
		<input class="widefat" type="text" name="oplsc_vm_url" id="oplsc_vm_url" />
		<div class="opl-desc"><?php _e('Please enter a valid Vimeo video URL (e.g. <code>http://vimeo.com/123456789</code>).', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label style="font-weight:normal !important;"><?php _e('Video Options', 'opl'); ?></label>
		<label for="oplsc_vm_autoplay" style="display:inline;font-weight:normal"><input type="checkbox" name="oplsc_vm_autoplay" id="oplsc_vm_autoplay" value="1" /> <span class="opl-desc"><code><?php _e('Autoplay Video', 'opl'); ?></code></span></label><br />
		<label for="oplsc_vm_portrait" style="display:inline;font-weight:normal"><input type="checkbox" name="oplsc_vm_portrait" id="oplsc_vm_portrait" value="1" /> <span class="opl-desc"><code><?php _e('Show Thumbnail', 'opl'); ?></code></span></label><br />
		<label for="oplsc_vm_title" style="display:inline;font-weight:normal"><input type="checkbox" name="oplsc_vm_title" id="oplsc_vm_title" value="1" /> <span class="opl-desc"><code><?php _e('Show Title', 'opl'); ?></code></span></label><br />
		<label for="oplsc_vm_byline" style="display:inline;font-weight:normal"><input type="checkbox" name="oplsc_vm_byline" id="oplsc_vm_byline" value="1" /> <span class="opl-desc"><code><?php _e('Show ByLine', 'opl'); ?></code></span></label><br />
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label for="oplsc_vm_width" style="font-weight:normal !important;"><?php _e('Video Size', 'opl'); ?></label>
		Width: <input type="text" name="oplsc_vm_width" id="opl_vm_width" value="640" />
		Height: <input type="text" name="oplsc_vm_height" id="opl_vm_height" value="360" />
		<div class="opl-desc"><?php _e('Please enter the exact width of your video so it can be displayed correctly.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	</ul>
	
	<ul id="opl-meta" class="opl-sc-button opl-sc-property" style="display:none">
	<li class="opl-property"><strong>Standard Button Parameters</strong></li>
	<li class="opl-property">
		<label for="oplsc_btn_color" style="font-weight:normal !important;"><?php _e('Button Color', 'opl'); ?></label>
		<select name="oplsc_btn_color" id="oplsc_btn_color" class="widefat">
			<option value="blue">Blue</option>
			<option value="green">Green</option>
			<option value="grey">Grey</option>
			<option value="orange">Orange</option>
			<option value="red">Red</option>
			<option value="yellow">Yellow</option>
		</select>
		<div class="opl-desc"><?php _e('Please select the button\'s color.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label for="oplsc_btn_txt" style="font-weight:normal !important;"><?php _e('Button Label', 'opl'); ?></label>
		<input class="widefat" type="text" name="oplsc_btn_txt" id="oplsc_btn_txt" />
		<div class="opl-desc"><?php _e('Please enter a text label for the button.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label for="oplsc_btn_url" style="font-weight:normal !important;"><?php _e('Button URL', 'opl'); ?></label>
		<input class="widefat" type="text" name="oplsc_btn_url" id="oplsc_btn_url" />
		<div class="opl-desc"><?php _e('Please enter a destination URL (must include http://).', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label for="oplsc_btn_target" style="font-weight:normal !important;"><?php _e('Target', 'opl'); ?></label>
		<select name="oplsc_btn_target" id="oplsc_btn_target" class="widefat">
			<option value="_self">Open in current window</option>
			<option value="_blank">Open in new window</option>
		</select>
		<div class="opl-desc"><?php _e('Please select the destination URL target.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	</ul>
	
	<ul id="opl-meta" class="opl-sc-big-button opl-sc-property" style="display:none">
	<li class="opl-property"><strong>Big Button Parameters</strong></li>
	<li class="opl-property">
		<label for="oplsc_bbtn_color" style="font-weight:normal !important;"><?php _e('Button Color', 'opl'); ?></label>
		<select name="oplsc_bbtn_color" id="oplsc_bbtn_color" class="widefat">
			<option value="blue">Blue</option>
			<option value="green">Green</option>
			<option value="grey">Grey</option>
			<option value="orange">Orange</option>
			<option value="red">Red</option>
			<option value="yellow">Yellow</option>
		</select>
		<div class="opl-desc"><?php _e('Please select the button\'s color.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label for="oplsc_bbtn_txt" style="font-weight:normal !important;"><?php _e('Button Label', 'opl'); ?></label>
		<input class="widefat" type="text" name="oplsc_bbtn_txt" id="oplsc_bbtn_txt" />
		<div class="opl-desc"><?php _e('Please enter a text label for the button.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label for="oplsc_bbtn_url" style="font-weight:normal !important;"><?php _e('Button URL', 'opl'); ?></label>
		<input class="widefat" type="text" name="oplsc_bbtn_url" id="oplsc_bbtn_url" />
		<div class="opl-desc"><?php _e('Please enter a destination URL (must include http://).', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label for="oplsc_bbtn_target" style="font-weight:normal !important;"><?php _e('Target', 'opl'); ?></label>
		<select name="oplsc_bbtn_target" id="oplsc_bbtn_target" class="widefat">
			<option value="_self">Open in current window</option>
			<option value="_blank">Open in new window</option>
		</select>
		<div class="opl-desc"><?php _e('Please select the destination URL target.', 'opl'); ?></div>
		<div class="opl-hr"></div>
	</li>
	<li class="opl-property">
		<label><?php _e('Button Circle', 'opl'); ?></label>
		<label for="oplsc_bbtn_circle" style="display:inline;font-weight:normal"><input type="checkbox" name="oplsc_bbtn_circle" id="oplsc_bbtn_circle" value="1" /> <span class="opl-desc"><code><?php _e('Display a circle around the button', 'opl'); ?></code></span></label><br />
		<div class="opl-hr"></div>
	</li>
	</ul>
	
	<ul id="opl-meta" class="opl-sc-btn" style="display:none">
	<li style="text-align:right">
	<button id="opl_sc_button" class="button">Insert To Post</button>
	</li>
	</ul>
<?php		
}

add_action( 'media_buttons', 'opl_add_media_shortcodes', 100 );
function opl_add_media_shortcodes() {
	echo '<a href="#TB_inline?width=640&height=480&inlineId=opl-shortcodes" class="thickbox" title="' . __( 'Insert OptinLite Shortcode', 'opl' ) . '"><img src="' . OPL_URL . '/images/sc.png" border="0" alt="Insert OptinLite Shortcode" title="Insert OptinLite Shortcode" /></a>';
}
*/