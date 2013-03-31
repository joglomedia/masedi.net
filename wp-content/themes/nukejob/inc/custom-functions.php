<?php
/**
 * Custom functions
 *
 * These file handle all custom functions
 *
 * @author 		WPNuke
 * @category 	Admin
 * @package 	WPNuke/Includes/Functions
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* 
 * Function to list file with specified extension from directory 
 *
 * $dir_name = "/path/to/dir";
 * $allowed_exts = array( "jpg", "jpeg", "png", "ico" );
 */
if(!function_exists('wpnuke_readdir')) {
	function wpnuke_readdir($dir_name, $allowed_exts = array('all'), $return = 'array') {
		//$dir_name = dirname( __FILE__ );
		//$allowed_exts = array( "php" );

		$files = array();

		if (is_dir($dir_name)) {
			if ($handle = opendir($dir_name) ) {
			
				$i = 0;
				
				while (true == ($file = readdir($handle))) {
					if ($file != "." && $file != "..") {
						$exts = explode(".", $file);
						$count = count($exts);
						$ext = $exts[$count-1];
						
						if('all' != strtolower($allowed_exts[0])) {
							if(in_array($ext, $allowed_exts)) {
								$files[] = $file;
							}
						} else {
							$files[] = $file;
						}
					}
					
					++$i;
				}
			}
		}
		
		return $files;
	}
}

/**
 * Function to correct install directory path
 * convert separator to system path separator, Dos / *nix
 */
function wpnuke_correct_path($path='') {
	$os_name = substr(php_uname(),0,3);
	if (strtoupper($os_name) === "WIN"){
		$sys_ps = "\\"; //path separator difer it for Windows and *nix
		$new_path = str_replace(array("//", "/"), "\\", $path);
	}
	else {
		$sys_ps = "/";
		// remove double separator
		$new_path = str_replace("//", "/", $path);
	}
	return $new_path;
}

/**
 * Check URL format is valid
 * http://stackoverflow.com/questions/206059/php-validation-regex-for-url
 */
if(!function_exists('is_valid_url')) {
	function is_valid_url($url) {
		// Define REGEX
		$regex = "/";
		// SCHEME
		$regex .= "^(https?|ftp)\:\/\/";

		// USER AND PASS (optional)
		$regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?";

		// HOSTNAME OR IP
		//$regex .= "[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)*"; // http://x = allowed (ex. http://localhost, http://routerlogin)
		//$regex .= "[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)+"; // http://x.x = minimum
		$regex .= "([a-z0-9+\$_-]+\.)*[a-z0-9+\$_-]{2,3}"; // http://x.xx(x) = minimum
		//use only one of the above

		// PORT (optional)
		//$regex .= "(\:[0-9]{2,5})?";
		// PATH (optional)
		//$regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?";
		// GET Query (optional)
		//$regex .= "(\?[a-z+&\$_.-][a-z0-9;:@/&%=+\$_.-]*)?";
		// ANCHOR (optional)
		//$regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?\$";

		$regex .= "/i";
		
		// check
		return preg_match($regex, $url);
	}
}

/**
 * Validate email
 * This is copied directly from WPMU wp-includes/wpmu-functions.php
 */
if (!function_exists('validate_email')) :
	function validate_email( $email, $check_domain = true) {
		if (ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'.'@'.
			'[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'.
			'[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $email))
		{
			if ($check_domain && function_exists('checkdnsrr')) {
				list (, $domain)  = explode('@', $email);

				if (checkdnsrr($domain.'.', 'MX') || checkdnsrr($domain.'.', 'A')) {
					return true;
				}
				return false;
			}
			return true;
		}
		return false;
	} // End of validate_email() function definition
endif;

/**
 * Check email format is valid
 */
if (!function_exists('is_valid_email')) {
	function is_valid_email($email) {
		if (function_exists('validate_email')) {
			return validate_email($email);
		} else {
			/**
			 * regex
			 * http://regexlib.com/REDetails.aspx?regexp_id=541
			 */
			$regex = "/^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/i";
			
			// check
			return preg_match($regex, $email);
		}
	}
}

/**
 * Function to convert spaces to hyphens (turn string into slug)
 */
function wpnuke_convert_spaces($convert) {
	$converted = preg_replace("/\s/", "-", strtolower($convert));
	return $converted;
}

/**
 * WPNuke Simple Email Sender
 * Custom PHP mailer
 */
function wpnuke_mail($to, $subject, $message, $headers = '', $attachments = array()) {
	// create a boundary string. It must be unique
	// so we use the MD5 algorithm to generate a random hash
	$random_hash = md5(date('r', time()));
	
	// add boundary string and mime type specification
	$headers = $headers . "Content-Type: multipart/mixed; boundary=\"PHP-mixed-" . $random_hash. "\"" . "\r\n";
	
	// read the atachment file contents into a string,
	// encode it with MIME base64,
	// and split it into smaller chunks
	if ( !is_array($attachments) )
		$attachments = explode( "\n", str_replace( "\r\n", "\n", $attachments ) );

	foreach ($attachments as $attachment) {
		$attachment_content = chunk_split(base64_encode(file_get_contents($attachment)));
		$attachment_string .= "--PHP-mixed-" . $random_hash .  
		"Content-Type: application/zip; name=\"" . $attachment . "\"" .
		"Content-Transfer-Encoding: base64" . 
		"Content-Disposition: attachment"

		. $attachment_content . "\r\n";
	}
	//define the body of the message.
	//ob_start(); //Turn on output buffering
	
	$mail_body = "--PHP-mixed-" . $random_hash .
	"Content-Type: multipart/alternative; boundary=\"PHP-alt-" . $random_hash . "\"" .

	"--PHP-alt-" . $random_hash .
	"Content-Type: text/html; charset=\"iso-8859-1\"" . 
	"Content-Transfer-Encoding: 7bit "

	. $message .

	"--PHP-alt-" . $random_hash . "--"
	
	. $attachment_string .
	
	"--PHP-mixed-" . $random_hash . "--";

	//copy current buffer contents into $message variable and delete current output buffer
	//$message = ob_get_clean();
	$message = $mail_body;
	
	//send the email
	return @mail( $to, $subject, $message, $headers );
}
?>