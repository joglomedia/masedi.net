<?php
//masukin facebook platform client-nya
require_once 'facebook.php';

// Ini api key dan app secret didapet pas kamu bikin aplikasi
// Stasiun Tugu, app ID: 114941688531199
$appapikey = '94d588bdf6fb75130f3e1a8a676ceee7';
$appsecret = '8c3ed1d1f5864b0b9a959c344d45310c';

//oke kita bikin object untuk class Facebook
$facebook = new Facebook($appapikey, $appsecret);
//user id orang yang login, kalo yang blom login pake aplikasi ini, maka disuruh login dulu ntarnya
$facebook->require_frame();
$user_id = $facebook->require_login();

// ini yang saya suka dari facebook, selain pake method-method yang ada untuk mendapatkan
// nilai dari sebuah attribut, bisa juga menggunakan query yang namanya FQL
$query 	= "SELECT publish_stream FROM permissions WHERE uid='$user_id'";
$result = $facebook->api_client->fql_query($query);

if(isset($_GET['do-it'])){
	
	if($_POST['status'] != ""){
		
		$message = $_POST['status'];
		
		$ret = $facebook->api_client->stream_publish($message);
		
		switch($ret) {
			case 1 :
				$error = "<fb:error>  <fb:message>Error:</fb:message>  An unknown error occurred.</fb:error><br />";
			break;
			case 100:
				$error = "<fb:error>  <fb:message>Error:</fb:message>  Invalid parameter.</fb:error><br />";
			break;
			case 102:	
				$error = "<fb:error>  <fb:message>Error:</fb:message>  Session key invalid or no longer valid (if it's a desktop application and the session is missing).</fb:error><br />";
			break;
			case 200:
				$error = "<fb:error>  <fb:message>Error:</fb:message>  Permissions error. The application does not have permission to perform this action.</fb:error><br />";
			break;
			case 210:	
				$error = "<fb:error>  <fb:message>Error:</fb:message>  User not visible. The user doesn't have permission to act on that object.</fb:error><br />";
			break;
			case 340:	
				$error = "<fb:error>  <fb:message>Error:</fb:message>  Feed action request limit reached.</fb:error><br />";
			break;
			default:
				$error = "<fb:success>  <fb:message>Your stream has been published successfully.</fb:message><em>\"".$_POST['status']."\"</em></fb:success><br />";
		}
		
		echo $error;
		
	}
	
}
?>
<?php
$have_acc = $result[0]['publish_stream'];

if($have_acc == 0){
?>
    <p>Aplikasi ini akan menyulap kamu untuk update status Facebook via <b>Stasiun Tugu Yogyakarta</b>. Follow this step!
	<ol><li><fb:prompt-permission perms="publish_stream"><b>Klik disini untuk mengijinkan aplikasi meng-update status</b></fb:prompt-permission>.</li> 
    <li><b>Press Ctrl+F5</b>, and you'll see your profile pictures and status update form.</li>
	</ol>
	</p>
<?php
}
?>
<?php
if($have_acc == 1){
?> 
<div style="padding: 10px;">
	
    <fb:profile-pic uid="<?=$user_id?>" size="normal" width="100" />
	
	<div style="float:right; margin-left:15px;">
	<h2>Hi, <fb:name uid="<?=$user_id?>" useyou="false" capitalize="true" />!</h2><br />
		<p style="width:360px;">your current status: <br /><b><fb:user-status uid="<?=$user_id?>" linked="true"></fb:user-status></b></p>
	<br />

    <fb:editor action="?do-it" labelwidth="100">    
	    <fb:editor-textarea label="Update Status" name="status" />  
	    <fb:editor-buttonset>  
		    <fb:editor-button value="Share via iPhone 4G" />  
	    </fb:editor-buttonset>
    </fb:editor>
    </div>
	<div style="clear:both;">&nbsp;</div>
</div>
<?php
}
?>