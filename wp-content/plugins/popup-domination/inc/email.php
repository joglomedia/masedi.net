<?php

if(strstr($_POST['email'],'@')) {

	$to = $_POST['master'];
	$subject = "PopUp Domination Sign Up";
	if(isset($_POST['name']) && !empty($_POST['name'])){
		$name_field = $_POST['name'];
	}else{
		$name_field = '';
	}
	$email_field = $_POST['email'];
	
	$custom1 = $_POST['custom1_default'];
	$custom2 = $_POST['custom2_default'];
	
	$body = "Name: $name_field\nE-Mail: $email_field\nCustom Input1: $custom1\nCustom Input2: $custom2\n";
	
	$headers = 'From: You have a new sign up!' . "\r\n" .
    "Reply-To: $email_field" . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    
    
	mail($to, $subject, $body, $headers);
	$url= $_POST['redirect'];
	echo "<meta http-equiv=\"refresh\" content=\"1;URL=$url\" />";
} else {

	echo "Failed";

}
?> 