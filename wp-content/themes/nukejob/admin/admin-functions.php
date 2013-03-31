<?php
/**
 * Custom function for admin
 */

/**
 * Restrict admin area, only administrator can access the WP dashboard
 * other user (job provider & job seeker) redirected to their custom dashboard
 */
function wpnuke_restrict_admin_area() {
    if (!wpnuke_check_user_role('administrator')) {
        //wp_redirect(site_url());
		//exit;
    }
}
add_action('admin_init', 'wpnuke_restrict_admin_area');

/**
 * Override Options Framework default options settings file location
 */
function wpnuke_of_location_override() {
	return WPNUKE_ADMIN_DIR . '/options-settings.php';
}
add_filter('options_framework_location', 'wpnuke_of_location_override');

?>
