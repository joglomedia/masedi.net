<?php
$url = $this->plugin_path;

if(isset($_POST['token_key']) && isset($_POST['token_secret'])){
if (!class_exists('AWeberAPI', true)){
	require_once('aweber_api.php');
}
$var = 'Please connect to Aweber using the button above before syncing your Mailing Lists.';
$token = $_POST['token_key'];

$tokensec = $_POST['token_secret'];
// Replace with the keys of your application
// NEVER SHARE OR DISTRIBUTE YOUR APPLICATIONS'S KEYS!
$consumerKey    = "AkMoKpqvLPBmaSDHXp1g4kiD";
$consumerSecret = "2Ee09eNTXTxcBkZrPsyBLZqsT2fEpPJbqnjRMhUf";

$aweber = new AWeberAPI($consumerKey, $consumerSecret);

//$account = $aweber->getAccount($_COOKIE['accessToken'], $_COOKIE['accessTokenSecret']);


$account = $aweber->getAccount($token, $tokensec);
$var = '<span class="mailing-list-small">Your Aweber Mailing Lists</span><select name="listsid" id="mc_lists" class="mailing_lists">';
foreach($account->lists as $offset => $list) {
		$var .= '<option name="mc_'.$list->data['name'].'" value="'.$list->data['name'].'">'.$list->data['name'].'</option>';
}
$var .= '</select>';

echo $var;

}else{
	echo 'Please connect to Aweber using the button above before syncing your Mailing Lists.';
}
?>