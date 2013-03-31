<?php
/*
Library Name: SMTP-Mailer
Version: 0.9.1
Library URI: 
Description: Reconfigures the wp_mail() function to use SMTP instead of mail() for WPNuke Theme Framework adapted from WP-Mail-SMTP plugin by Callum Macdonald.
Author: Edi Septr
Author URI: http://www.masedi.net/
*/

/** This code copied and modified from WP-Mail-SMTP **/

/**
 * @author Callum Macdonald
 * @copyright Callum Macdonald, 2007-11, All Rights Reserved
 * This code is released under the GPL licence version 3 or later, available here
 * http://www.gnu.org/licenses/gpl.txt
 */

/**
 * Setting options in wp-config.php
 * 
 * Specifically aimed at WPMU users, you can set the options for this plugin as
 * constants in wp-config.php. This disables the plugin's admin page and may
 * improve performance very slightly. Copy the code below into wp-config.php.
 */

/*
define('WPNUKE_SMTP_ON', true);
define('WPNUKE_SMTP_MAIL_FROM', 'From Email');
define('WPNUKE_SMTP_MAIL_FROM_NAME', 'From Name');
define('WPNUKE_SMTP_MAILER', 'smtp'); // Possible values 'smtp', 'mail', or 'sendmail'
define('WPNUKE_SMTP_SET_RETURN_PATH', 'false'); // Sets $phpmailer->Sender if true
define('WPNUKE_SMTP_HOST', 'localhost'); // The SMTP mail host
define('WPNUKE_SMTP_PORT', 25); // The SMTP server port number
define('WPNUKE_SMTP_SSL', ''); // Possible values '', 'ssl', 'tls' - note TLS is not STARTTLS
define('WPNUKE_SMTP_AUTH', true); // True turns on SMTP authentication, false turns it off
define('WPNUKE_SMTP_USER', 'username'); // SMTP authentication username, only used if WPNUKE_SMTP_AUTH is true
define('WPNUKE_SMTP_PASS', 'password'); // SMTP authentication password, only used if WPNUKE_SMTP_AUTH is true
*/

// To avoid any (very unlikely) clashes, check if the function alredy exists
if (!function_exists('phpmailer_init_smtp')) :
// This code is copied, from wp-includes/pluggable.php as at version 2.2.2
function phpmailer_init_smtp($phpmailer) {
	
	// If constants are defined, apply those options
	if (defined('WPNUKE_SMTP_ON') && WPNUKE_SMTP_ON) {
		
		$phpmailer->Mailer = WPNUKE_SMTP_MAILER;
		
		if (WPNUKE_SMTP_SET_RETURN_PATH)
			$phpmailer->Sender = $phpmailer->From;
		
		if (WPNUKE_SMTP_MAILER == 'smtp') {
			$phpmailer->SMTPSecure = WPNUKE_SMTP_SSL;
			$phpmailer->Host = WPNUKE_SMTP_HOST;
			$phpmailer->Port = WPNUKE_SMTP_PORT;
			if (WPNUKE_SMTP_AUTH) {
				$phpmailer->SMTPAuth = true;
				$phpmailer->Username = WPNUKE_SMTP_USER;
				$phpmailer->Password = WPNUKE_SMTP_PASS;
			}
		}
		
		// If you're using contstants, set any custom options here
		
	}
	else {
		
		// Check that mailer is not blank, if mailer=smtp, and host is not blank
		if ( ! wpnuke_get_option(WPNUKE_PREFIX . 'mailer') || ( wpnuke_get_option(WPNUKE_PREFIX . 'mailer') == 'smtp' && ! wpnuke_get_option(WPNUKE_PREFIX . 'smtp_host') ) ) {
			return;
		}
		
		// Set the mailer type as per config above, this overrides the already called isMail method
		$phpmailer->Mailer = wpnuke_get_option(WPNUKE_PREFIX . 'mailer');
		
		// Set the Sender (return-path) if required
		if (wpnuke_get_option(WPNUKE_PREFIX . 'mail_set_return_path'))
			$phpmailer->Sender = $phpmailer->From;
		
		// Set the SMTPSecure value, if set to none, leave this blank
		$phpmailer->SMTPSecure = wpnuke_get_option(WPNUKE_PREFIX . 'smtp_secure') == 'none' ? '' : wpnuke_get_option(WPNUKE_PREFIX . 'smtp_secure');
		
		// If we're sending via SMTP, set the host
		if (wpnuke_get_option(WPNUKE_PREFIX . 'mailer') == "smtp") {
			
			// Set the SMTPSecure value, if set to none, leave this blank
			$phpmailer->SMTPSecure = wpnuke_get_option(WPNUKE_PREFIX . 'smtp_secure') == 'none' ? '' : wpnuke_get_option(WPNUKE_PREFIX . 'smtp_secure');
			
			// Set the other options
			$phpmailer->Host = wpnuke_get_option(WPNUKE_PREFIX . 'smtp_host');
			$phpmailer->Port = wpnuke_get_option(WPNUKE_PREFIX . 'smtp_port');
			
			// If we're using smtp auth, set the username & password
			if (wpnuke_get_option(WPNUKE_PREFIX . 'smtp_auth') == "true") {
				$phpmailer->SMTPAuth = true;
				$phpmailer->Username = wpnuke_get_option(WPNUKE_PREFIX . 'smtp_user');
				$phpmailer->Password = wpnuke_get_option(WPNUKE_PREFIX . 'smtp_pass');
			}
		}
		
		// You can add your own options here, see the phpmailer documentation for more info:		
		
		// STOP adding options here.
		
	}
	
} // End of phpmailer_init_smtp() function definition
endif;

/**
 * This function sets the from email value
 */
if (!function_exists('wp_mail_smtp_mail_from')) :
function wp_mail_smtp_mail_from ($orig) {
	
	// This is copied from pluggable.php lines 348-354 as at revision 10150
	// http://trac.wordpress.org/browser/branches/2.7/wp-includes/pluggable.php#L348
	
	// Get the site domain and get rid of www.
	$sitename = strtolower( $_SERVER['SERVER_NAME'] );
	if ( substr( $sitename, 0, 4 ) == 'www.' ) {
		$sitename = substr( $sitename, 4 );
	}

	// modify this line
	//$default_from = 'wordpress@' . $sitename;
	$default_from = 'no-reply@' . $sitename;
	// End of copied code
	
	// If the from email is not the default, return it unchanged
	if ( $orig != $default_from ) {
		return $orig;
	}
	
	if (defined('WPNUKE_SMTP_ON') && WPNUKE_SMTP_ON)
		return WPNUKE_SMTP_MAIL_FROM;
	elseif (validate_email(wpnuke_get_option(WPNUKE_PREFIX . 'mail_from'), false))
		return wpnuke_get_option(WPNUKE_PREFIX . 'mail_from');
	
	// If in doubt, return the original value
	return $orig;
	
} // End of wp_mail_smtp_mail_from() function definition
endif;

/**
 * This function sets the from name value
 */
if (!function_exists('wp_mail_smtp_mail_from_name')) :
function wp_mail_smtp_mail_from_name ($orig) {
	// get mail from name setting
	$mail_from_name = wpnuke_get_option(WPNUKE_PREFIX . 'mail_from_name');
	
	// Only filter if the from name is the default
	if ($orig == 'WordPress') {
		if (defined('WPNUKE_SMTP_ON') && WPNUKE_SMTP_ON)
			return WPNUKE_SMTP_MAIL_FROM_NAME;
		elseif ( $mail_from_name != "" && is_string($mail_from_name) )
			return $mail_from_name;
	}
	
	// If in doubt, return the original value
	return $orig;
	
} // End of wp_mail_smtp_mail_from_name() function definition
endif;

// Add an action on phpmailer_init
add_action('phpmailer_init','phpmailer_init_smtp');

// Add filters to replace the mail from name and emailaddress
add_filter('wp_mail_from','wp_mail_smtp_mail_from');
add_filter('wp_mail_from_name','wp_mail_smtp_mail_from_name');

/** End copied code **/
?>
