
<?php

if (!class_exists('ConstantContact', true)){
	include_once('ConstantContactz.php');
}


$username = $mailingapi['username'];
$password = $mailingapi['password'];
$api = str_replace(' ', '', $api);
$cc = new ConstantContact($api, $username, $password);
 if(isset($_POST['name'])){
 	$name = $_POST['name'];
 }else{
 	$name = '';
 }
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

$result = $cc->addContactToMailingList($_POST['email'], $name, $custom1, $custom2, $cfield1, $cfield2, $_POST['listid']);
$find = strstr($result, 'Error');
if($find){
	echo $result;
}else{
	echo '';
}
?>