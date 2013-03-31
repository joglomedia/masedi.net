<?php
$mailto = $_GET['mailto'];
$referalurl = getenv(HTTP_REFERER);
if(empty($referalurl)) {$referalurl = 'http://www.mydailysoftwares.com';}
if(empty($mailto)) {$mailto = 'me@masedi.net';}

/*get ip info */
include('ip2locationlite/ip2locationlite.class.php');

if (getenv(HTTP_X_FORWARDED_FOR)) {
$pipaddress = getenv(HTTP_X_FORWARDED_FOR);
$ipaddress = getenv(REMOTE_ADDR);
$message = "<p>Your Visitor Proxy IP address is : <a href=\"http://network-tools.com/default.asp?prog=express&host=$pipaddress\" title=\"Trace IP\">$pipaddress</a> (via origin IP address <a href=\"http://network-tools.com/default.asp?prog=express&host=$ipaddress\" title=\"Trace IP\">$ipaddress</a>).<br /></p>";

$pipLite = new ip2location_lite;
$pipLite->setKey('8bbbd84435a8be921b94fcb9d33fd08707c959645db0cd678f0c18cc7aa77773');

//Get errors and locations
$locations = $pipLite->getCity($pipaddress);
//$errors = $pipLite->getError();

//Getting the Proxy result
$message .= "<p><b>Proxy IP Address Information :</b><br />\n";
if (!empty($locations) && is_array($locations)) {
  foreach ($locations as $field => $val) {
    $message .= $field . ' : ' . $val . "<br />\n";
  }
}
$message .= "</p>\n";

//Getting the IP result
//Load the class
$ipLite = new ip2location_lite;
$ipLite->setKey('8bbbd84435a8be921b94fcb9d33fd08707c959645db0cd678f0c18cc7aa77773');

//Get errors and locations
$locations = $ipLite->getCity($ipaddress);
//$errors = $ipLite->getError();

//Getting the result
$message .= "<p><b>Origin IP Address Information :</b><br />\n";
if (!empty($locations) && is_array($locations)) {
  foreach ($locations as $field => $val) {
    $message .= $field . ' : ' . $val . "<br />\n";
  }
}
$message .= "</p>\n";

} else {
$ipaddress = getenv(REMOTE_ADDR);
$message = "<p>Your Visitor IP address is : <a href=\"http://network-tools.com/default.asp?prog=express&host=$ipaddress\" title=\"Trace IP\">$ipaddress</p></a>";

//Getting the IP result
//Load the class
$ipLite = new ip2location_lite;
$ipLite->setKey('8bbbd84435a8be921b94fcb9d33fd08707c959645db0cd678f0c18cc7aa77773');

//Get errors and locations
$locations = $ipLite->getCity($ipaddress);
//$errors = $ipLite->getError();

//Getting the result
$message .= "<p><b>Origin IP Address Information :</b><br />\n";
if (!empty($locations) && is_array($locations)) {
  foreach ($locations as $field => $val) {
    $message .= $field . ' : ' . $val . "<br />\n";
  }
}
$message .= "</p>\n";
}

/*send ip information to email*/
//$to = "me@masedi.net";
$infooter = "<div style=\"border-top:#999 1px solid; font-size:10px; text-align:center;\"><p>This message was sent using <a href=\"http://www.joglohosting.com\"><strong>Simple IP2Location</strong></a>, an IP locator by <a href=\"http://www.masedi.net/\">MasEDI Networks</a>.</p></div>";
$message = "<html><head><title>" . $subject . "</title></head><body>" . $message ." " . $infooter . "</body></html>";
$subject = "Visitor IP Info";
$from = "ip2mail@masedi.net";
$headers = "From: $from\n";
$headers .= "MIME-Version: 1.0\n";
$headers .= "Content-Type: text/html; charset=\"UTF-8\"\n";
$headers .= "X-Mailer: ip2location MasEDI.Net\n";
$headers .= "Reply-To: \"" . $sender_name . "\" <" . $sender_email . ">\n";

if(mail($mailto,$subject,$message,$headers)) {
//echo "Email Sent Successful.";
header("Location: $referalurl");
}else{
//echo "Email Sent Failed.";
header("Location: http://www.joglohosting.com/");
}
?>
