<?php  $to = "me@masedi.net";
$subject = "Test mail";
$message = "Hello! This is a simple email message.";
$from = "someonelse@example.com";
$headers = "From: $from";
if(mail($to,$subject,$message,$headers)) {
echo "Email Sent Successful.";
}else{
echo "Email Sent Failed.";
}
?>
