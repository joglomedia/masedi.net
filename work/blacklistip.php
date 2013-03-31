<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
/*filter bot grabber based on IP*/
$handle = fopen("ip.blacklist.txt", "rb");
if ($handle) {
while (!feof($handle) ) {
$content = fgets($handle, 4096);
$iplist = explode('\n', $content);
}
fclose($handle);
}

$visitor = $_SERVER['REMOTE_ADDR'];
if (in_array($_SERVER['REMOTE_ADDR'],$iplist)) {
	header("location: http://google.com/");
	//exit();
}
?>
