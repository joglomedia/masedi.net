<?php 
	if(isset($_POST['api_key'])){
	$lists = false;
	$var = 'Please enter all your details into the inputs above and please double check that they are correct';
	$apikey = $_POST['api_key'];

	if (!class_exists('MCAPI', true)){
		include_once('MCAPI.class.php');
	}
	
	
	$api = new MCAPI($apikey); 
	
	$lists = $api->lists();
	
	if($lists){
	
		$var = '<span class="mailing-list-small">Your MailChimp Mailing Lists</span><select name="listsid" class="mailing_lists" id="mc_lists">';
		foreach ($lists['data'] as $l){
			$var .= '<option name="mc_'.$l['name'].'" value="'.$l['id'].'">'.$l['name'].'</option>';
		}
		$var .= '</select>';

	};
	
    echo $var;                			
	}else{
		echo 'Please enter all your details into the inputs above and please double check that they are correct.';
	}
?>