<?php
/*
Plugin Name: Syntax Highlighter ComPress
Plugin URI: http://www.phodana.de/wordpress/wp-plugin-syntax-highlighter-compress/
Description: Syntax Highlighter ComPress is a simple Wordpress plugin for syntax highlighting on your blog. This plugin uses the latest <a href="http://alexgorbatchev.com/wiki/SyntaxHighlighter">Alex Gorbatchev's SyntaxHighlighter Script</a>.
Version: 3.0.83.3
Author: Andre G&auml;rtner
Author URI: http://www.phodana.de
*/

class wp_shc {
	function wp_shc() {
		global $wp_version;
		
		// Load Language files
        if (function_exists('load_plugin_textdomain')) {
            if ( !defined('WP_PLUGIN_DIR') ) {
                load_plugin_textdomain('SHC', str_replace( ABSPATH, '', dirname(__FILE__) ) . '/languages');
            } else {
                load_plugin_textdomain('SHC', false, dirname(plugin_basename(__FILE__)) . '/languages');
            }
        }
		
		// The current version
		define('shc_VERSION', '1.0');
		
		// Check for WP2.6 installation
		if (!defined ('IS_WP26'))
			define('IS_WP26', version_compare($wp_version, '2.6', '>=') );
		
		//This works only in WP2.6 or higher
		if ( IS_WP26 == FALSE) {
			add_action('admin_notices', create_function('', 'echo \'<div id="message" class="error fade"><p><strong>' . __('Sorry, Syntax Highlighter ComPress works only under WordPress 2.6 or higher',"SHC") . '</strong></p></div>\';'));
			return;
		} else {
      // define URL
      define('shc_ABSPATH', WP_PLUGIN_DIR.'/'.plugin_basename( dirname(__FILE__) ).'/' );
      define('shc_URLPATH', WP_PLUGIN_URL.'/'.plugin_basename( dirname(__FILE__) ).'/' );
      
      include_once (dirname (__FILE__)."/tinymce/tinymce.php");

		}
	}
}

/**
 * Add action link(s) to plugins page
 * Thanks Dion Hulse -- http://dd32.id.au/wordpress-plugins/?configure-link
 */
function shc_filter_plugin_actions($links, $file){
	static $this_plugin;

	if( !$this_plugin ) $this_plugin = plugin_basename(__FILE__);

	if( $file == $this_plugin ){
		$settings_link = '<a href="options-general.php?page=syntax-highlighter-compress.php">' . __('Settings') . '</a>';
		$links = array_merge( array($settings_link), $links); // before other links
	}
	return $links;
}

/**
 * settings in plugin-admin-page
 */
function shc_add_settings_page() {
	global $wp_version;
	if ( function_exists('add_submenu_page') && current_user_can('manage_options') && is_admin() ) {

		$menutitle = '';
		if ( version_compare( $wp_version, '2.6.999', '>' ) ) {
			// $menutitle = '<img src="' . get_resource_url('shc.gif') . '" alt="" />' . ' ';
		}
		$menutitle .= __('Syntax Highlighter ComPress', 'SHC');

		add_submenu_page('options-general.php', __('Syntax Highlighter ComPress Options', 'SHC'), $menutitle, 8, basename(__FILE__), 'shc_options_subpanel');
		add_filter('plugin_action_links', 'shc_filter_plugin_actions', 10, 2);
	}
}

/**
 * Options Panel
 */
function shc_options_subpanel() {
	global $wp_version;

	$message_export = '';
	
	if ( isset($_POST['stage']) && ('update' == $_POST['stage']) ) {
		shc_update();
		$message_export = '<br class="clear"><div class="updated"><p>';
		$message_export.= __('Syntax Highlighter ComPress settings updated!', 'SHC');
		$message_export.= '</p></div>';
	}

	if ( /*(isset($_POST['shc_deinstall_yes'])) && */(isset($_POST['stage']) && $_POST['stage'] == 'uninstall') ) {
		shc_uninstall();
		$message_export = '<br class="clear"><div class="updated"><p>';
		$message_export.= __('Syntax Highlighter ComPress settings deinstalled!', 'SHC');
		$message_export.= '</p></div>';
	}

	//Options
	$shc_theme          = stripslashes(shc_getOptionValue('shc_theme'));
	$shc_autolinks      = stripslashes(shc_getOptionValue('shc_autolinks'));
	$shc_collapse       = stripslashes(shc_getOptionValue('shc_collapse'));
	$shc_gutter         = stripslashes(shc_getOptionValue('shc_gutter'));
	$shc_smarttabs      = stripslashes(shc_getOptionValue('shc_smarttabs'));
	$shc_tabsize        = stripslashes(shc_getOptionValue('shc_tabsize'));
	$shc_toolbar        = stripslashes(shc_getOptionValue('shc_toolbar'));
		
?>

<div class="wrap">
	<h2><?php _e('Syntax Highlighter ComPress Options', 'SHC') ?></h2>
	<?php echo $message_export; ?>
	<br class="clear" />
		<div id="poststuff" class="ui-sortable meta-box-sortables">
			<div class="postbox">
				<div class="handlediv" title="Click to toggle"><br /></div>
                <h3><?php _e('Settings', 'SHC') ?></h3>
				<div class="inside">
					<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=syntax-highlighter-compress.php">
						<?php wp_nonce_field('shc_nonce') ?>
						<table summary="shcoptions" class="form-table">
							<tr valign="top">
								<th scope="row" style="font-weight: bold"><?php _e('Stylesheet:', 'SHC') ?></th>
								<td>
								<select name="shc_theme" id="shc_theme" size="1">
                                  <option value="Default" <?php echo ($shc_theme=="Default") ? 'selected' : ''; ?>>Default</option>
                                  <option value="Django" <?php echo ($shc_theme=="Django") ? 'selected' : ''; ?>>Django</option>
                                  <option value="Eclipse" <?php echo ($shc_theme=="Eclipse") ? 'selected' : ''; ?>>Eclipse</option>
                                  <option value="Emacs" <?php echo ($shc_theme=="Emacs") ? 'selected' : ''; ?>>Emacs</option>
                                  <option value="FadeToGrey" <?php echo ($shc_theme=="FadeToGrey") ? 'selected' : ''; ?>>FadeToGrey</option>
                                  <option value="MDUltra" <?php echo ($shc_theme=="MDUltra") ? 'selected' : ''; ?>>MDUltra</option>
                                  <option value="Midnight" <?php echo ($shc_theme=="Midnight") ? 'selected' : ''; ?>>Midnight</option>
                                  <option value="RDark" <?php echo ($shc_theme=="RDark") ? 'selected' : ''; ?>>RDark</option>
                                </select>
								<?php _e('Allows you to choose the stylesheet. <a target="_blank" href="http://alexgorbatchev.com/SyntaxHighlighter/manual/themes/">Click here</a> for a demo.', 'SHC') ?></td> 
							</tr>
							<tr valign="top">
								<th scope="row" style="font-weight: bold"><?php _e('Auto-Links:', 'SHC') ?></th>
								<td><input type="checkbox" name="shc_autolinks" id="shc_autolinks" value="1" <?php checked('1', shc_getOptionValue('shc_autolinks')); ?> />
								&nbsp;<?php _e('Allows you to turn detection of links in the highlighted element on and off. If the option is turned off, URLs will not be clickable. <a target="_blank" href="http://alexgorbatchev.com/SyntaxHighlighter/manual/demo/auto-links.html">Click here</a> for a demo.', 'SHC') ?></td> 
							</tr>
							<tr valign="top">
								<th scope="row" style="font-weight: bold"><?php _e('Collapse:', 'SHC') ?></th>
								<td><input type="checkbox" name="shc_collapse" id="shc_collapse" value="1" <?php checked('1', shc_getOptionValue('shc_collapse')); ?> />
								&nbsp;<?php _e('Allows you to force highlighted elements on the page to be collapsed by default. <a target="_blank" href="http://alexgorbatchev.com/SyntaxHighlighter/manual/demo/collapse.html">Click here</a> for a demo.', 'SHC') ?></td> 
							</tr>
							<tr valign="top">
								<th scope="row" style="font-weight: bold"><?php _e('Gutter:', 'SHC') ?></th>
								<td><input type="checkbox" name="shc_gutter" id="shc_gutter" value="1" <?php checked('1', shc_getOptionValue('shc_gutter')); ?> />
								&nbsp;<?php _e('Allows you to turn gutter with line numbers on and off. <a target="_blank" href="http://alexgorbatchev.com/SyntaxHighlighter/manual/demo/gutter.html">Click here</a> for a demo.', 'SHC') ?></td> 
							</tr>
							<tr valign="top">
								<th scope="row" style="font-weight: bold"><?php _e('Smart-Tabs:', 'SHC') ?></th>
								<td><input type="checkbox" name="shc_smarttabs" id="shc_smarttabs" value="1" <?php checked('1', shc_getOptionValue('shc_smarttabs')); ?> />
								&nbsp;<?php _e('Allows you to turn smart tabs feature on and off. <a target="_blank" href="http://alexgorbatchev.com/SyntaxHighlighter/manual/demo/smart-tabs.html">Click here</a> for a demo.', 'SHC') ?></td> 
							</tr>
							<tr valign="top">
								<th scope="row" style="font-weight: bold"><?php _e('Tab-size:', 'SHC') ?></th>
								<td><input name="shc_tabsize" type="text" id="shc_tabsize" value="<?php echo $shc_tabsize; ?>" size="2" />
								<?php _e('Allows you to adjust tab size. <a target="_blank" href="http://alexgorbatchev.com/SyntaxHighlighter/manual/demo/tab-size.html">Click here</a> for a demo.', 'SHC') ?></td> 
							</tr>
							<tr valign="top">
								<th scope="row" style="font-weight: bold"><?php _e('Toolbar:', 'SHC') ?></th>
								<td><input type="checkbox" name="shc_toolbar" id="shc_toolbar" value="1" <?php checked('1', shc_getOptionValue('shc_toolbar')); ?> />
								&nbsp;<?php _e('Toggles toolbar on/off. <a target="_blank" href="http://alexgorbatchev.com/SyntaxHighlighter/manual/demo/toolbar.html">Click here</a> for a demo.', 'SHC') ?></td> 
							</tr>
						</table>

						<p class="submit">
							<input class="button-primary" type="submit" name="Submit" value="<?php _e('Update settings', 'SHC') ?> &raquo;" />
							<input type="hidden" name="stage" value="update" />
						</p>
					</form>
				</div>
			</div>
		</div>
		
		<div id="poststuff" class="ui-sortable meta-box-sortables">
			<div class="postbox closed">
				<div class="handlediv" title="Click to toggle"><br /></div>
                <h3><?php _e('Delete settings', 'SHC') ?></h3>
				<div class="inside">
					<form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=syntax-highlighter-compress.php">
						<?php wp_nonce_field('shc_nonce') ?>
						<p><?php echo _e('This button deletes all settings of the plugin. Please use it <strong>before</strong> deactivating the plugin.<br /><strong>Attention: </strong>This action can not be redone!', 'SHC'); ?></p>
						<p id="submitbutton">
							<input type="submit" name="Submit_uninstall" value="<?php _e('Delete settings &raquo;', 'SHC') ?>" class="button-secondary" />
							<!--<input type="checkbox" name="shc_deinstall_yes" value="shc_deinstall" />-->
							<input type="hidden" name="stage" value="uninstall" />
						</p>
					</form>
				</div>
			</div>
		</div>
		
		<div id="poststuff" class="ui-sortable meta-box-sortables">
			<div class="postbox closed">
				<div class="handlediv" title="Click to toggle"><br /></div>
                <h3><?php _e('Information zum Plugin', 'SHC') ?></h3>
				<div class="inside">
					<p><?php echo _e('This wordpress plugin is developed by <a href="http://www.phodana.de">Andre G&auml;rtner</a>. The highlighting script itself is developed by <a href="http://alexgorbatchev.com/wiki/SyntaxHighlighter">Alex Gorbatchev</a>.', 'SHC'); ?></p>
					<p><?php _e('Visit the <a href="http://www.phodana.de/wordpress/wp-plugin-syntax-highlighter-compress/">author\'s website</a> or the <a href="http://wordpress.org/extend/plugins/syntax-highlighter-compress/">plugin\'s website</a> for more information. Please vote <a href="http://wordpress.org/extend/plugins/syntax-highlighter-compress/">here</a> if you like the plugin.', 'SHC'); ?><br />Copyright &copy; <?php echo date("Y"); ?> <a href="http://www.phodana.de">Andre G&auml;rtner</a></p>
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_donations" />
                    <input type="hidden" name="business" value="info@phodana.de" />
                    <input type="hidden" name="lc" value="DE" />
                    <input type="hidden" name="item_name" value="Phodana media" />
                    <input type="hidden" name="no_note" value="0" />
                    <input type="hidden" name="currency_code" value="EUR" />
                    <input type="hidden" name="bn" value="PP-DonationsBF:btn_donate_LG.gif:NonHostedGuest" />
                    <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!" />
                    <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
                    </form>

				</div>
			</div>
		</div>

		<script type="text/javascript">
		<!--
		<?php if ( version_compare( substr($wp_version, 0, 3), '2.7', '<' ) ) { ?>
		jQuery('.postbox h3').prepend('<a class="togbox">+</a> ');
		<?php } ?>
		jQuery('.postbox h3').click( function() { jQuery(jQuery(this).parent().get(0)).toggleClass('closed'); } );
		jQuery('.postbox.close-me').each(function(){
			jQuery(this).addClass("closed");
		});
		//-->
		</script>

</div>
<?php
}

/**
 * read options
 */
function shc_getOptionValue($key) {
	global $shc_opt;
	
	$shc_opt = get_option('shc_opt');
	return ($shc_opt[$key]);
}


/**
 * install default options
 */
function shc_install() {
	
	$shc_opt = array();
	
	//Options
	$shc_opt['shc_theme'] = 'Default';
	$shc_opt['shc_autolinks'] = 1;
	$shc_opt['shc_collapse'] = 0;
	$shc_opt['shc_gutter'] = 1;
	$shc_opt['shc_smarttabs'] = 1;
    $shc_opt['shc_tabsize'] = 4;
    $shc_opt['shc_toolbar'] = 1;
	
	add_option('shc_opt', $shc_opt);
}

/**
 * update options
 */
function shc_update() {
	if ( function_exists('current_user_can') && current_user_can('manage_options') ) {

		check_admin_referer('shc_nonce');

		// Options
		if (isset($_POST['shc_theme'])) {
			$shc_opt['shc_theme'] = strip_tags(stripslashes($_POST['shc_theme']));
		} else {
			$shc_opt['shc_theme'] = 0;
		}
		
		if (isset($_POST['shc_autolinks'])) {
			$shc_opt['shc_autolinks'] = (int) strip_tags(stripslashes($_POST['shc_autolinks']));
		} else {
			$shc_opt['shc_autolinks'] = 0;
		}
		
		if (isset($_POST['shc_collapse'])) {
			$shc_opt['shc_collapse'] = (int) strip_tags(stripslashes($_POST['shc_collapse']));
		} else {
			$shc_opt['shc_collapse'] = 0;
		}
		
		if (isset($_POST['shc_gutter'])) {
			$shc_opt['shc_gutter'] = (int) strip_tags(stripslashes($_POST['shc_gutter']));
		} else {
			$shc_opt['shc_gutter'] = 0;
		}
		
		if (isset($_POST['shc_smarttabs'])) {
			$shc_opt['shc_smarttabs'] = (int) strip_tags(stripslashes($_POST['shc_smarttabs']));
		} else {
			$shc_opt['shc_smarttabs'] = 0;
		}
		
		if (isset($_POST['shc_tabsize'])) {
			$shc_opt['shc_tabsize'] = (int) strip_tags(stripslashes($_POST['shc_tabsize']));
		} else {
			$shc_opt['shc_tabsize'] = 0;
		}
		
		if (isset($_POST['shc_toolbar'])) {
			$shc_opt['shc_toolbar'] = (int) strip_tags(stripslashes($_POST['shc_toolbar']));
		} else {
			$shc_opt['shc_toolbar'] = 0;
		}

		update_option('shc_opt', $shc_opt);
	
	} else {
		wp_die('<p>'.__('You do not have the rights to change the settings.', 'SHC').'</p>');
	}
}


// Uninstall options
function shc_uninstall() {
	if ( function_exists('current_user_can') && current_user_can('edit_plugins') ) {
			
		check_admin_referer('shc_nonce');
		
		delete_option('shc_opt');
		
		// from a older version
		delete_option('shc_theme');
		delete_option('shc_autolinks');
		delete_option('shc_collapse');
		delete_option('shc_gutter');
		delete_option('shc_smarttabs');
		delete_option('shc_tabsize');
		delete_option('shc_toolbar');
			
	} else {
		wp_die('<p>'.__('You do not have the rights to change the settings.', 'SHC').'</p>');
	}
}


/**
 * Header Hook
 */
function wp_shc_head() {
	$current_path = get_option('siteurl') .'/wp-content/plugins/' . basename(dirname(__FILE__)) .'/'; 
	?>
	
<!-- START: Syntax Highlighter ComPress -->
<script type="text/javascript" src="<?php echo $current_path; ?>scripts/shCore.js"></script>
<script type="text/javascript" src="<?php echo $current_path; ?>scripts/shAutoloader.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo $current_path; ?>styles/shCore<?php echo shc_getOptionValue('shc_theme'); ?>.css"/>
<!-- END: Syntax Highlighter ComPress -->

  <?php
}

/**
 * Footer Hook
 */
function wp_shc_footer() {
	$current_path = get_option('siteurl') .'/wp-content/plugins/' . basename(dirname(__FILE__)) .'/'; 
	?>
	
<!-- START: Syntax Highlighter ComPress -->
<script type="text/javascript">
    SyntaxHighlighter.autoloader(
        'applescript			<?php echo $current_path; ?>scripts/shBrushAppleScript.js',
        'actionscript3 as3		<?php echo $current_path; ?>scripts/shBrushAS3.js',
        'bash shell				<?php echo $current_path; ?>scripts/shBrushBash.js',
        'coldfusion cf			<?php echo $current_path; ?>scripts/shBrushColdFusion.js',
        'cpp c					<?php echo $current_path; ?>scripts/shBrushCpp.js',
        'c# c-sharp csharp		<?php echo $current_path; ?>scripts/shBrushCSharp.js',
        'css					<?php echo $current_path; ?>scripts/shBrushCss.js',
        'delphi pascal pas		<?php echo $current_path; ?>scripts/shBrushDelphi.js',
        'diff patch			    <?php echo $current_path; ?>scripts/shBrushDiff.js',
        'erl erlang				<?php echo $current_path; ?>scripts/shBrushErlang.js',
        'groovy					<?php echo $current_path; ?>scripts/shBrushGroovy.js',
        'java					<?php echo $current_path; ?>scripts/shBrushJava.js',
        'jfx javafx				<?php echo $current_path; ?>scripts/shBrushJavaFX.js',
        'js jscript javascript	<?php echo $current_path; ?>scripts/shBrushJScript.js',
        'perl pl				<?php echo $current_path; ?>scripts/shBrushPerl.js',
        'php					<?php echo $current_path; ?>scripts/shBrushPhp.js',
        'text plain				<?php echo $current_path; ?>scripts/shBrushPlain.js',
        'powershell ps          <?php echo $current_path; ?>scripts/shBrushPowerShell.js',
        'py python				<?php echo $current_path; ?>scripts/shBrushPython.js',
        'ruby rails ror rb		<?php echo $current_path; ?>scripts/shBrushRuby.js',
        'sass scss              <?php echo $current_path; ?>scripts/shBrushSass.js',
        'scala					<?php echo $current_path; ?>scripts/shBrushScala.js',
        'sql					<?php echo $current_path; ?>scripts/shBrushSql.js',
        'vb vbnet				<?php echo $current_path; ?>scripts/shBrushVb.js',
        'xml xhtml xslt html	<?php echo $current_path; ?>scripts/shBrushXml.js'
    );
    <?php if (shc_getOptionValue('shc_autolinks') != 1) { ?>SyntaxHighlighter.defaults['auto-links'] = false; <?php } ?>
    <?php if (shc_getOptionValue('shc_collapse') == 1) { ?>SyntaxHighlighter.defaults['collapse'] = true; <?php } ?>
    <?php if (shc_getOptionValue('shc_smarttabs') != 1) { ?>SyntaxHighlighter.defaults['smart-tabs'] = false; <?php } ?>
    <?php if (shc_getOptionValue('shc_gutter') != 1) { ?>SyntaxHighlighter.defaults['gutter'] = false; <?php } ?>
    <?php if (shc_getOptionValue('shc_toolbar') != 1) { ?>SyntaxHighlighter.defaults['toolbar'] = false; <?php } ?>
    SyntaxHighlighter.defaults['tab-size'] = <?php echo shc_getOptionValue('shc_tabsize'); ?>;
    SyntaxHighlighter.all();
</script>
<!-- END: Syntax Highlighter ComPress -->

	<?php
}

/**
 * Actions
 */
add_action('plugins_loaded', create_function( '', 'global $wp_shc; $wp_shc = new wp_shc();' ) );

if (is_admin() ) { add_action('admin_menu', 'shc_add_settings_page'); }
register_activation_hook(__FILE__, 'shc_install');

add_action('wp_head','wp_shc_head');
add_action('wp_footer','wp_shc_footer');

?>