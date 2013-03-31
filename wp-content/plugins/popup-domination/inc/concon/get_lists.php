<?php
session_start();
if(isset($_POST['username']) && isset($_POST['token_key']) && isset($_POST['user_secret'])){
if (!class_exists('ConstantContact', true)){
	include_once('ConstantContact.php');
}
$username = $_POST['username'];
$apiKey = $_POST['token_key'];
$consumerSecret = $_POST['user_secret'];
$Datastore = new CTCTDataStore();
$DatastoreUser = $Datastore->lookupUser($username);
$var = 'Please connect to Constant Contact using the button above before syncing your Mailing Lists.';
if($DatastoreUser){
    $ConstantContact = new ConstantContact('oauth', $apiKey, $DatastoreUser['username'], $consumerSecret);
    $ContactLists = $ConstantContact->getLists();
	$var .= '<span class="mailing-list-small">Your Constant Contact Mailing Lists</span><select class="mailing_lists" name="listsid" >';
    foreach($ContactLists['lists'] as $list){
       $var .= '<option name="'.$list->name.'" value="'.$list->id.'"> '.$list->name.'<br />';
    }
	$var .= '</select>';
} else {echo 'You are not connected, please try again';}

echo $var;

}else{
	echo 'Please connect to Constant Contact using the button above before syncing your Mailing Lists.';
}
?>