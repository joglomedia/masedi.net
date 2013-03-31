<!--xxx-->
<?php
//masukin facebook platform client-nya
require_once 'facebook.php';

// Ini api key dan app secret didapet pas kamu bikin aplikasi
$appapikey 	= '07a3a59c7fa24ba22bec2524268279e1';
$appsecret 	= '67c4ad7ff901a6f5064a2c768f623cc7';

//oke kita bikin object untuk class Facebook
$facebook 	= new Facebook($appapikey, $appsecret);
//user id orang yang login, kalo yang blom login pake aplikasi ini, maka disuruh login dulu ntarnya
$user_id 	= $facebook->require_login();

// ini yang saya suka dari facebook, selain pake method-method yang ada untuk mendapatkan
// nilai dari sebuah attribut, bisa juga menggunakan query yang namanya FQL
$query 		= "SELECT publish_stream FROM permissions WHERE uid='$user_id'";
$result 	= $facebook->api_client->fql_query($query);
$have_acc	= $result[0]['publish_stream'];

if(isset($_GET['do-it'])){
	
	if($_POST['status']!=""){
		
		$message = $_POST['status'];
		
		$ret = $facebook->api_client->stream_publish($message);
		
		switch($ret) {
			case 1 :
				echo "<fb:error>  <fb:message>Wiih ada error cuy!</fb:message>  An unknown error occurred.</fb:error><br />";
			break;
			case 100:
				echo "<fb:error>  <fb:message>Wiih ada error cuy!</fb:message>  Invalid parameter.</fb:error><br />";
			break;
			case 102:	
				echo "<fb:error>  <fb:message>Wiih ada error cuy!</fb:message>  Session key invalid or no longer valid (if it's a desktop application and the session is missing).</fb:error><br />";
			break;
			case 200:
				echo "<fb:error>  <fb:message>Wiih ada error cuy!</fb:message>  Permissions error. The application does not have permission to perform this action.</fb:error><br />";
			break;
			case 210:	
				echo "<fb:error>  <fb:message>Wiih ada error cuy!</fb:message>  User not visible. The user doesn't have permission to act on that object.</fb:error><br />";
			break;
			case 340:	
				echo "<fb:error>  <fb:message>Wiih ada error cuy!</fb:message>  Feed action request limit reached.</fb:error><br />";
			break;
			default:
				echo "<fb:success>  <fb:message>Stream Kamu Sukses TerPublish</fb:message><em>\"".$_POST['status']."\"</em></fb:success><br />";
		}
		

	}
	
}
?>
<?php
if($have_acc==0){
?>
    <p>This is just an experimental simple Facebook status Update. With this application you can update your status seemly look like via Samsung Galaxy S i9000 <fb:prompt-permission perms="publish_stream">Click this link</fb:prompt-permission>. 
    Press Ctr+F5, you'll see your profile pictures and status update form. </p> 
<?php
}
?>
<?php
if($have_acc==1){
?> 
    Hi, <br style="clear:both;"/>
    <fb:profile-pic uid="<?=$user_id?>" size="normal" width="100" /><br style="clear:both;"/>
    your current status: <b><fb:user-status uid="<?=$user_id?>" linked="true"></fb:user-status></b>

    <div align="left">
    <fb:editor action="?do-it" labelwidth="100">    
	    <fb:editor-textarea label="Update Status" name="status"/>  
	    <fb:editor-buttonset>  
		    <fb:editor-button value="Share"/>  
	    </fb:editor-buttonset> 
    </fb:editor>
    </div>
<?php
}
?>