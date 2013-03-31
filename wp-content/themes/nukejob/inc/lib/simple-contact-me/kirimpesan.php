<?php
/**
 * @param: $contact_email = your email address;
 *
 * CopyLeft (c) 2010 me[at]masedi[dot]net - http://www.masedi.net/contactme
 * License: GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

// initiate session first for captcha security code
session_start();

// parameters
$contact_email = "me@masedi.net";
$mail_type = "html"; //options: text/plain, html

// email validation
function is_valid_email($str) {
	$valid = (! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? false : true;
	
	return $valid;
}

// processing contact form
if (isset($_POST['submit'])) {
	//error_reporting (E_ALL ^ E_NOTICE);
		
	$redirecturl = $_SERVER['HTTP_REFERER'];
	
	// Let's validate required data first!
	if ($_POST['name']=='' || $_POST['email']=='' || !is_valid_email($_POST['email']) || empty($_POST['comment'])) {
	
		$c_errcode = 3;
		$_SESSION['c_errorcode'] = $c_errcode;
		header("Location: " .$redirecturl);
		
	} elseif ($_POST['captchacode'] == $_SESSION['capcay']) {

		//$to = preg_replace("([\r\n])", "", $_POST['receiver']);
		$to = $contact_email;
		$sender_email = preg_replace("([\r\n])", "", $_POST['email']);
		$sender_name = preg_replace("([\r\n])", "", $_POST['name']);
		$subject = "ContactME Form sent by: " .$sender_name;
		$footer = "<div style=\"border-top:#999 1px solid; font-size:10px; text-align:center;\">" . 
		"<p>This message was sent using <a href=\"http://masedi.net/contact-me\"><strong>Simple ContactME</strong></a>, " . 
		"a contact form by <a href=\"http://masedi.net/\">MasEDI Network</a>.</p></div>";
		$message = stripslashes($_POST['comment']);
		
		$match = "/(bcc:|cc:|content\-type:)/i";
		
		if (preg_match($match, $to) || preg_match($match, $sender_email) || preg_match($match, $message)) {
	
			$c_errcode = 4;
			$_SESSION['c_errorcode'] = $c_errcode;
			header("Location: " .$redirecturl);
		}
		
		//$headers = "From: ".$from."\r\n";
		//$headers .= "Reply-to: ".$from."\r\n";
		
		$headers  = "From: \"$sender_name\" <$sender_email>\r\n";
		$headers .= "Return-Path: <" . $sender_email . ">\r\n";
		$headers .= "Reply-To: \"" . $sender_name . "\" <" . $sender_email . ">\r\n";
		//$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
		$headers .= "X-Mailer: Simple ContactMe by MasEDI.Net\r\n";
		
		if ('html' == $mail_type) {
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-Type: text/html; charset=\"UTF-8\"\n";
			$mailtext = "<html><head><title>" . $subject . "</title></head><body>" . $message ." " . $footer . "</body></html>";
		} else {
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-Type: text/plain; charset=\"UTF-8\"\n";
			$message = preg_replace('|&[^a][^m][^p].{0,3};|', '', $message);
			$message = preg_replace('|&amp;|', '&', $message);
			$mailtext = wordwrap(strip_tags($message), 80, "\n");
		}
		
        if (mail($to, $subject, $mailtext, $headers)) {
			$c_errcode = 1;
			$_SESSION['c_errorcode'] = $c_errcode;
			header("Location: " .$redirecturl);
		} else {
			$c_errcode = 2;
			$_SESSION['c_errorcode'] = $c_errcode;
			header("Location: " .$redirecturl);
		}
	}else{
		$c_errcode = 5;
		$_SESSION['c_errorcode'] = $c_errcode;
		header("Location: " .$redirecturl);
	}
		
} elseif (isset($_GET["captcha"]) && ($_GET["captcha"] == "generateimage")){

	/**
	 * generate image captcha code for security question
	 * just to check, wether you are a human or robot
	 * this section is part of Simple Contact ME Form
	 * contributor: deka.web.id
	 */
	
	// initiate session first before any html echoin out!
	session_start();
	
	// processing generate image captcha
	$img = "images/captcha.jpg"; 
	$red = "0"; 
	$green = "0"; 
	$blue = "0";
	$rand1 = mt_rand(3,10); 
	$rand2 = mt_rand(6,20); 
	$displaytext = $rand1." + ".$rand2;
	$result = $rand1 + $rand2;
	
	$createimg =imagecreatefromjpeg($img);
	$text = imagecolorallocate($createimg, $red, $green, $blue);
	imagestring($createimg, 5, 20, 10, $displaytext, $text);
	
	$_SESSION['capcay'] = $result;
	
	header("Content-type: image/jpeg");
	
	imagejpeg($createimg);

} else {
	die("Sorry, Direct access not allowed!");
}
?>