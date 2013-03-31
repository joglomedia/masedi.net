<?php
	require_once('MCAPI.class.php');
	// grab an API Key from http://admin.mailchimp.com/account/api/
	$api = new MCAPI($api);
	
	// grab your List's Unique Id by going to http://admin.mailchimp.com/lists/
	// Click the "settings" link for the list - the Unique Id is at the bottom of that page. 
	$list_id = $_POST['listid'];
		
	if(isset($_POST['name']) && !empty($_POST['name'])){
		$name = $_POST['name'];
	}else{
		$name = '';
	}
	if(isset($_POST['custom1']) && !empty($_POST['custom1']) && $_POST['custom1'] != 'undefined'){
		$custom1 = $_POST['custom1'];
	}else{
		$custom1 = '';
	}
	if(isset($_POST['custom2']) && !empty($_POST['custom2']) && $_POST['custom2'] != 'undefined'){
		$custom2 = $_POST['custom2'];
	}else{
		$custom2 = '';
	}
	//echo $_POST['email'].$_POST['name'].$_POST['listid'];
	
	if($api->listSubscribe($list_id, $_POST['email'], array('FNAME' => $name, 'MERGE2' => $custom1, 'MERGE3' => $custom2)) === true) {
		// It worked!	
		echo 'True';
	}else{
		// An error ocurred, return error message	
		echo 'Error: ' . $api->errorMessage;
	}
?>