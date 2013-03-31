<?php


if (!class_exists('AWeberAPI', true) && !class_exists('AWeberServiceProvider', true)){
	require_once('aweber_api/aweber_api.php');
}


// Replace with the keys of your application
// NEVER SHARE OR DISTRIBUTE YOUR APPLICATIONS'S KEYS!
$consumerKey    = "AkMoKpqvLPBmaSDHXp1g4kiD";
$consumerSecret = "2Ee09eNTXTxcBkZrPsyBLZqsT2fEpPJbqnjRMhUf";
$aweber = new AWeberAPI($consumerKey, $consumerSecret);

//print_r($aweber);

if (empty($_COOKIE['accessToken'])) {
    if (empty($_GET['oauth_token'])) {
        $callbackUrl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        list($requestToken, $requestTokenSecret) = $aweber->getRequestToken($callbackUrl);
        setcookie('requestTokenSecret', $requestTokenSecret);
        setcookie('callbackUrl', $callbackUrl);
        header("Location: {$aweber->getAuthorizeUrl()}");
       	exit();
    }

    $aweber->user->tokenSecret = $_COOKIE['requestTokenSecret'];
    $aweber->user->requestToken = $_GET['oauth_token'];
    $aweber->user->verifier = $_GET['oauth_verifier'];
    list($accessToken, $accessTokenSecret) = $aweber->getAccessToken();
    setcookie('accessToken', $accessToken);
    setcookie('accessTokenSecret', $accessTokenSecret);
    header('Location: '.$_COOKIE['callbackUrl']);
    exit();
    
}
$account = false;

$account = $aweber->getAccount($_COOKIE['accessToken'], $_COOKIE['accessTokenSecret']);

if(isset($account)){
	setcookie("aw_getlists", 'Y', time()+3600, '/');
	setcookie("awToken", $_COOKIE['accessToken'], time()+3600, '/');
	setcookie("awTokenSecret", $_COOKIE['accessTokenSecret'], time()+3600, '/');
	?>
	<html>
	<head>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	<!--
	function delayer(){
	    window.location.href = "<?php echo $_GET['url']; ?>";
	}
	//-->
	</script>
	</head>
	<body onLoad="setTimeout('delayer()', 5000)">
	<?php
	echo '<style>body{font-family: "Helvetica Neue",Helvetica,Arial,Sans-Serif;font-size:12pt;}</style>';
	echo 'You have connected to Aweber, you will be re-direct back to your PopUp Domination. If you are not re-directed, please <a href="'.$_GET['url'].'">click here</a>.';
	echo '</body></html>';
}

?>
