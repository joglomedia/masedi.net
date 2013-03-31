<?php
/**
 * Main admin functions
 *
 * Loads all admin options panels, sets up and registers the various Wordpress admin features
 * that WPNuke support
 *
 * @author 		WPNuke
 * @category 	Admin
 * @package 	WPNuke/Admin
 * @version     1.0
 */

if (! defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Load custom admin functions if exists
 */
wpnuke_require(WPNUKE_ADMIN_DIR . '/admin-functions.php');

/**
 * Load all functions for handling custom post type, post status, taxonomies
 * registration and admin interface
 */
wpnuke_require(WPNUKE_ADMIN_DIR . '/custom-post.php');
wpnuke_require(WPNUKE_ADMIN_DIR . '/custom-taxonomy.php');
wpnuke_require(WPNUKE_ADMIN_DIR . '/custom-admin-post.php');
wpnuke_require(WPNUKE_ADMIN_DIR . '/custom-admin-taxonomy.php');

/**
 * Load all functions for handling custom admin dashboard widgets and metaboxes interface
 */
wpnuke_require(WPNUKE_ADMIN_DIR . '/custom-admin-dashboard.php');
wpnuke_require(WPNUKE_ADMIN_DIR . '/custom-admin-metabox.php');

/**
 * Load all functions for handling custom profile fields
 */
wpnuke_require(WPNUKE_ADMIN_DIR . '/custom-profile-fields.php');

/**
 * Load and sets up custom post meta boxes
 * Utilize meta-box framework
 */
if (! defined('WPNUKE_METABOX_DIR')) {
	define('WPNUKE_METABOX_DIR', wpnuke_correct_path(WPNUKE_ADMIN_DIR . '/meta-box'));
}
wpnuke_require(WPNUKE_METABOX_DIR . '/meta-box.php');
wpnuke_require(WPNUKE_ADMIN_DIR . '/meta-box-settings.php');

/**
 * Load and sets up theme options
 * Utilize options framework
 */
if (!function_exists('optionsframework_init')) {
	define('OPTIONS_FRAMEWORK_URL', WPNUKE_ADMIN_URL . '/options-framework');
	define('OPTIONS_FRAMEWORK_DIRECTORY', WPNUKE_ADMIN_DIR . '/options-framework');
	
	wpnuke_require(OPTIONS_FRAMEWORK_DIRECTORY . '/options-framework.php');
	
	// Little modification for theme customizer setting, adopted for WPNuke Framework (Milestone, future update)
	//wpnuke_require(OPTIONS_FRAMEWORK_DIRECTORY . '/options-customizer.php');
}

?>
