<?php
$provider = 'none';

$provider = $_POST['provider'];

if($provider == 'mc'){
	include 'mc/get_lists.php';
}else if($provider == 'cm'){
	include 'campmon/get_lists.php';
}else if($provider == 'aw'){
	include 'aweber_api/get_lists.php';
}else if($provider == 'cc'){
	include 'concon/get_lists.php';
}else if($provider == 'ic'){
	include 'icon/get_lists.php';
}else if($provider == 'gr'){
	include 'getre/get_lists.php';
}

?>