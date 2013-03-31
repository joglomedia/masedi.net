<?php

if (!class_exists('jsonRPCClient', true)){
	require_once 'jsonRPCClient.php';
}

$api_key = $mailingapi['apikey'];
$api_url = 'http://api2.getresponse.com';
$client = new jsonRPCClient($api_url);
$result = NULL;
if(isset($_POST['custom1'])){
 	$custom1 = $_POST['custom1'];
 	$cfield1 = $_POST['customf1'];
}else{
 	$custom1 = '';
 	$cfield1 = '';
}
if(isset($_POST['custom2'])){
 	$custom2 = $_POST['custom2'];
 	$cfield2 = $_POST['customf2'];
}else{
	$custom2 = '';
 	$cfield2 = '';
}
if(isset($_POST['name'])){
 	$name = $_POST['name'];
}else{
	$name = '';
}


try {
	if(!isset($cfield1) || !isset($cfield2)){
		$result = $client->add_contact(
		$api_key,
		    array (
		        'campaign' => $_POST['listid'],
		        'name' => $name,
		        'email' => $_POST['email'],
		        'cycle_day' => '0'
		    )
		);
	}else if(empty($cfield1) || empty($cfield2)){
		$result = $client->add_contact(
		$api_key,
		    array (
		        'campaign' => $_POST['listid'],
		        'name' => $name,
		        'email' => $_POST['email'],
		        'cycle_day' => '0'
		    )
		);
	}else{
		$result = $client->add_contact(
		    $api_key,
		    array (
		        'campaign' => $_POST['listid'],
		        'name' => $name,
		        'email' => $_POST['email'],
		        'customs' => array(
		        	array( 'name' => $cfield1, 'content' => $custom1),
		        	array( 'name' => $cfield2, 'content' => $custom2)
		        ),
		        'cycle_day' => '0',
		    )
		);
	}
	
	if(is_array($result)){
		echo '';
	}else{
		echo $results;
	}
}
catch (Exception $e) {

    die($e->getMessage());
}

?>