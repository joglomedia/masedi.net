<?php
/*
Plugin Name: WordPress Authenticated Login
Plugin URI: http://masedi.net/
Description: This plugin allows you to make your WordPress site accessible to logged in users only. In other words to view your site users must have 
an account in your site and be logged in. No need any plugin configurations. Simply activate the plugin from your dashboard, it all is what you 
need. Thanks to Angsuman Chakraborty and Taragana for the great idea. Source <a href="http://blog.taragana.com/index.php/archive/angsumans-authenticated-wordpress-plugin-password-protection-for-your-wordpress-blog/">here</a>.
Author: Edi Septriyanto
Version: 1.0
Author URI: http://masedi.net/
License: Free for non-commercial use.
Warranties: None.
*/
function ac_auth_redirect() {
// Checks if a user is logged in, if not redirects them to the login page
	global $user_ID;
	if (!$user_ID) {
		nocache_headers();
		header("HTTP/1.1 302 Moved Temporarily");
		header('Location: ' . get_settings('siteurl') . '/wp-login.php?redirect_to=' . urlencode($_SERVER['REQUEST_URI']));
		header("Status: 302 Moved Temporarily");
		exit();
	}
}

if('wp-login.php' != $pagenow && 'wp-register.php' != $pagenow) add_action('template_redirect', 'ac_auth_redirect');
?>
