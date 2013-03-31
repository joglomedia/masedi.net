<?php
/*
Plugin Name: Watermark RELOADED
Plugin URI: http://eappz.eu/en/products/watermark-reloaded/
Description: Add watermark to your uploaded images and customize your watermark appearance in user friendly settings page.
Version: 1.3.2
Author: Sandi Verdev
Author URI: http://eAppz.eu/
*/

register_activation_hook(__FILE__, 'watermark_reloaded_activate');

// display error message to users
if (array_key_exists('action', $_GET) && $_GET['action'] == 'error_scrape') {
    die("Sorry, Watermark RELOADED requires PHP 5.0 or higher. Please deactivate Watermark RELOADED.");
}

function watermark_reloaded_activate() {
	if ( version_compare( phpversion(), '5.0', '<' ) ) {
		trigger_error('', E_USER_ERROR);
	}
}

// require Watermark RELOADED if PHP 5 installed and if we're in admin,
// as we do not need the plugin in frontend
if ( version_compare( phpversion(), '5.0', '>=') && is_admin() ) {
	define('WR_LOADER', __FILE__);

	require_once(dirname(__FILE__) . '/watermark-reloaded.php');
}
?>