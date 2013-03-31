<?php

if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['apikey'])){
if (!class_exists('Icontact', true)){
	require_once( 'icontact.php' );
}

$icontact = new Icontact(
	'https://app.icontact.com/icp',
	$_POST['username'],
	$_POST['password'],
	$_POST['apikey']
);

$account_id = $icontact->LookUpAccountId();
$client_folder_id = $icontact->LookUpClientFolderId();
$lists = $icontact->GetLists();
$var = '';

$var = '<span class="mailing-list-small">Your iContact Mailing Lists</span><select name="listsid" class="mailing_lists"  id="ic_lists">'; 
foreach($lists as $l){
	$var .= '<option name="mc_'.$l['name'].'" value="'.$l['listId'].'">'.$l['name'].'</option>';
}
$var .= '</select>';

echo $var;
}else{
	echo 'Please enter all your details into the inputs above and please double check that they are correct.';
}

?>