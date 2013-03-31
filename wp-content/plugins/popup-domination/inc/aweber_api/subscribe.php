<?php
/*
$default = array();
$class = array();
$class[0] = 'name';
$class[1] = 'email';
$default[0] = $_POST['named'];
$default[1] = $_POST['emaild'];

require_once('aweber_api.php');

$token = $mailingapi['apikey'];

$tokensec = $mailingapi['apiextra'];

$consumerKey    = "AkMoKpqvLPBmaSDHXp1g4kiD";
$consumerSecret = "2Ee09eNTXTxcBkZrPsyBLZqsT2fEpPJbqnjRMhUf";

$aweber = new AWeberAPI($consumerKey, $consumerSecret);

$account = $aweber->getAccount($token, $tokensec);

foreach($account->lists as $offset => $list){
	foreach($list->web_forms as $offset => $forms){
		$url = $forms->data['html_source_link'];
		$var = file_get_contents($url);
	}
}


$action = explode('<body>', $var);
$action2 = explode('<div style="display: none;">', $action[1]);
$hidden = explode('<div style="display: none;">', $var);
$hidden2 = explode('</div>', $hidden[1]);


require_once('form_fields.php');

$form = new form_fields();

$ff = array();

$ff = $form->form_to_data($var);


$i = 0;
$field = array();
while($i < 2){

	$field[$i] = '<input type="text" tabindex="500" value="'.$default[$i].'" class="text '.$class[$i].'" name="'.$ff['data'][$i]['name'].'" id="'.$ff['data'][$i]['id'].'">';
	
		
	$i++;
}


echo $action2[0].$hidden2[0].$field[0].$field[1];*/

?>


