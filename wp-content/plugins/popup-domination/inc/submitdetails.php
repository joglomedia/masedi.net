<?php 
	$provider = $_POST['provider'];
	$mailingapi = unserialize(base64_decode($this->option('formapi')));
	//print_r($mailingapi);
	$provider  = $mailingapi['provider'];
	$api = $mailingapi['apikey'];
	if($provider == 'mc'){
		include_once 'mc/subscribe.php';
	}else if($provider == 'cm'){
		include_once 'campmon/subscribe.php';
	}else if($provider == 'aw'){
		include_once 'aweber_api/subscribe.php';
	}else if($provider == 'cc'){
		include_once 'concon/subscribe.php';
	}else if($provider == 'ic'){
		include_once 'icon/subscribe.php';
	}else if($provider == 'gr'){
		include_once 'getre/subscribe.php';
	}else if($provider == 'nm'){
		include_once 'email.php';
	}
	
	die();
?>