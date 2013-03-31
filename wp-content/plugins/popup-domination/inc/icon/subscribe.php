<?php
if (!class_exists('Icontact', true)){
	require_once( 'icontact.php' );
}


$icontact = new Icontact(
	'https://app.icontact.com/icp',
	$mailingapi['username'],
	$mailingapi['password'],
	$mailingapi['apikey']
);
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
 
try {
	$account_id = $icontact->LookUpAccountId();
	$client_folder_id = $icontact->LookUpClientFolderId();
	$contact_id = $icontact->AddContact( array(
		'firstName' => $name,
		'email' => $_POST['email'],
		$cfield1 => $custom1,
		$cfield2 => $custom2
	));
	
	$contact_add_to_list = $icontact->SubscribeContactToList($contact_id, $_POST['listid']);
	echo 'true';
} catch ( IcontactException $ex ) {	
	print_r( $ex->GetErrorData() );
}
?>