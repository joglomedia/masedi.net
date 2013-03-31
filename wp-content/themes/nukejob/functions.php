<?php
/**
 * WPNuke Theme
 *
 * Main theme file which loads all functions, definitions and settings.
 *
 * @author 		WPNuke
 * @category 	Theme Core
 * @package 	WPNuke
 * @version     1.0
 */

/**
 * WPNuke require file
 * Use WP locate_template to load required template file
 */
if (! function_exists('wpnuke_require')) {
	function wpnuke_require($file) {
		locate_template($file, true);
		//require_once($file);
	}
}

// Define WPNuke theme options and meta keys prefix
if (! defined('WPNUKE_PREFIX')) {
	define('WPNUKE_PREFIX', '');
}

// Define WPNuke Template Directory URI
if (! defined('WPNUKE_BASE_URL')) {
	define('WPNUKE_BASE_URL', get_template_directory_uri());
}

// Define WPNuke Template Directory Path
// update: use wp locate_template, so no need to redefine the base directory path
if (! defined('WPNUKE_BASE_DIR')) {
	//define('WPNUKE_BASE_DIR', get_template_directory());
	define('WPNUKE_BASE_DIR', '');
}

// Define WPNuke Admin Directory URI
if (! defined('WPNUKE_ADMIN_URL')) {
	define('WPNUKE_ADMIN_URL', WPNUKE_BASE_URL . '/admin');
}

// Define WPNuke Admin Directory Path
if (! defined('WPNUKE_ADMIN_DIR')) {
	define('WPNUKE_ADMIN_DIR', WPNUKE_BASE_DIR . '/admin');
}

// Define WPNuke Includes Directory URI
if (! defined('WPNUKE_INCLUDES_URL')) {
	define('WPNUKE_INCLUDES_URL', WPNUKE_BASE_URL . '/inc');
}

// Define WPNuke Includes Directory Path
if (! defined('WPNUKE_INCLUDES_DIR')) {
	define('WPNUKE_INCLUDES_DIR', WPNUKE_BASE_DIR . '/inc');
}

// Load Theme Functions
wpnuke_require(WPNUKE_INCLUDES_DIR . '/custom-functions.php');
wpnuke_require(WPNUKE_INCLUDES_DIR . '/theme-functions.php');

// Load Library Functions
wpnuke_require(WPNUKE_INCLUDES_DIR . '/lib/smtp-mailer/smtp-mailer.php');
wpnuke_require(WPNUKE_INCLUDES_DIR . '/lib/job/job-functions.php');

// Load Theme Admin Functions
wpnuke_require(WPNUKE_ADMIN_DIR . '/wpnuke-admin-init.php');

// Load Theme Widgets
wpnuke_require(WPNUKE_INCLUDES_DIR . '/theme-widgets.php');

// Load Theme Custom Shortcodes
wpnuke_require(WPNUKE_INCLUDES_DIR . '/shortcode.php');

// Load TinyMCE Plugin
wpnuke_require(WPNUKE_INCLUDES_DIR . '/wpnuke-tinymce/tinymce.php');

// Load Pagenavi
wpnuke_require(WPNUKE_INCLUDES_DIR . '/pagenavi.php');

// Load Breadcrumbs
locate_template('/inc/functions/breadcrumbs.php', true);

/**
 * Sets up theme defaults and registers the various WordPress features that
 * Nuke Job supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_theme_support() To add support for post thumbnails, etc
 * @uses register_nav_menus() To add support for custom menu
 * @uses add_role() To add support for new user role
 *
 * @since	NukeJob 1.0
 */
function wpnuke_theme_setup() {
	/*
	 * Makes WPNuke available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on WPNuke, use a find and replace
	 * to change 'wpnuke' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('wpnuke', get_template_directory() . '/languages');

	// First we check to see if our default theme settings have been applied.
	$the_theme_status = get_option( WPNUKE_PREFIX . 'vacancy_theme_setup_status' );
	// If the theme has not yet been used we want to run our default settings.
	if ( $the_theme_status !== '1' ) {
		// Delete dummy post, page and comment.
		wp_delete_post( 1, true );
		wp_delete_post( 2, true );
		wp_delete_comment( 1 );
	
		// Add theme supports
		if (function_exists('add_theme_support')) {
			// Adds RSS feed links to <head> for posts and comments.
			add_theme_support('automatic-feed-links');

			// Add thumbnail sizes.
			add_theme_support('post-thumbnails');
			//set_post_thumbnail_size(624, 9999); // Unlimited height, soft crop
			
			// Add image sizes. This theme uses a custom image size for slide images, logo, thumbnail, etc
			add_image_size('slide', 940, 330, true); // slide thumbnail
			add_image_size('archive-post', 220, 150, true); // blog posts thumbnail
			add_image_size('company-logo', 100, 100, true); // job company thumbnail logo used by frontend theme
			add_image_size('company-logo-medium', 60, 60, true); // job company taxonomy thumbnail used by admin dashboard
			add_image_size('company-logo-small', 32, 32, true); // job company taxonomy thumbnail used by admin dashboard and frontend theme
		}

		// Add custom menu. This theme uses wp_nav_menu() in one location
		if (function_exists('register_nav_menus')) {
			register_nav_menus(
				array(
					'main_navigation' => __('Main Navigation', 'wpnuke'),
					'footer_navigation' => __('Footer Navigation', 'wpnuke')
				)
			);
		}

		// Add new user role
		if (function_exists('add_role')) {
			/* // Remove old deprecated user roles
			remove_role('Job Provider');
			remove_role('Job Seeker');
			remove_role('jobprovider');
			remove_role('jobseeker');
			// */
			
			// add new role job_provider
			add_role('job_provider', 'Job Provider', 
				array(
					'read' => true, // True allows that capability
					'edit_posts' => true,
					'delete_posts' => true,
					'upload_files' => true,
					'edit_files' => true,
					'edit_jobs' => true
				)
			);
			
			// add new role job_seeker
			add_role('job_seeker', 'Job Seeker', 
				array(
					'read' => true, // True allows that capability
					'edit_posts' => true,
					'delete_posts' => true,
					'upload_files' => true,
					'edit_files' => true,
					'edit_jobs' => false
				)
			);
		}
		
		// Init wpnuke theme install
		if (file_exists(TEMPLATEPATH . '/admin/wpnuke-admin-install.php')) {
			locate_template( '/admin/wpnuke-admin-install.php', true );
			
			// Create user pages
			wpnuke_create_pages();
			
			// Create database tables
			wpnuke_tables_install();
		}
		
		// Once done, we register our setting to make sure we don't duplicate everytime we activate.
		update_option( WPNUKE_PREFIX . 'vacancy_theme_setup_status', '1' );
		
		// Lets let the admin know whats going on.
		$msg = '
		<div class="error">
			<p>The ' . get_option( 'current_theme' ) . 'theme has changed your WordPress default <a href="' . admin_url( 'options-general.php' ) . '" title="See Settings">settings</a> and deleted default posts & comments.</p>
		</div>';
		add_action( 'admin_notices', $c = create_function( '', 'echo "' . addcslashes( $msg, '"' ) . '";' ) );
	}
	// Else if we are re-activing the theme
	elseif ( $the_theme_status === '1' and isset( $_GET['activated'] ) ) {
		$msg = '
		<div class="updated">
			<p>The ' . get_option( 'current_theme' ) . ' theme was successfully re-activated.</p>
		</div>';
		add_action( 'admin_notices', $c = create_function( '', 'echo "' . addcslashes( $msg, '"' ) . '";' ) );
	}
}
/**
 * Tell WordPress to run wpnuke_theme_setup() when the 'after_setup_theme' hook is run.
 */
add_action('after_setup_theme', 'wpnuke_theme_setup');

/**
 * Flushing rewrite rules on activation
 * To get custom permalinks to work when the theme activated
 * Useful to flush rewrite rule if it has changed (custom post type use custom rewrite rule)
 *
 * Load it one time only when after_switch_theme hook called
 */
function wpnuke_rewrite_flush() {
	flush_rewrite_rules();
}
/**
 * Tell WordPress to run flush_rewrite_rules() when the 'after_switch_theme' hook is run.
 */
add_action('after_switch_theme', 'wpnuke_rewrite_flush');

/**
 * Tell Wordpress to redirect To Theme Options Page after activation
 */
if ($_GET['activated']) {
	wp_redirect(admin_url("themes.php?page=options-framework"));
}

?>
<?php
/**
 * dumb fix for _checkactive_widgets worm/malwares
 * http://museumthemes.com/wordpress/fixed-redeclare-checkactivewidgets-error-wordpress-child-themes/
 */
if (!function_exists('_checkactive_widgets')) {
	// do nothing
}
?>
