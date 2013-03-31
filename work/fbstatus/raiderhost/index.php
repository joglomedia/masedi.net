<?php
//masukin facebook platform client-nya
require_once 'facebook.php';

// Ini api key dan app secret didapet pas kamu bikin aplikasi
// Raiderhost, app ID: 115076368516435
$appapikey = '54f24bfdd7c46df9f9b4de66431362dd';
$appsecret = '3661454d9c09ae42c1e79a226793a29a';

//oke kita bikin object untuk class Facebook
$facebook = new Facebook($appapikey, $appsecret);
//user id orang yang login, kalo yang blom login pake aplikasi ini, maka disuruh login dulu ntarnya
$facebook->require_frame();

$is_tab = isset($_POST['fb_sig_in_profile_tab']);
if(!$is_tab) $user_id = $facebook->require_login();

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
//$is_tab = isset($_POST['fb_sig_in_profile_tab']);
if(!$is_tab){
$have_acc = $result[0]['publish_stream'];

if($have_acc == 0){
?>
    <p>This is just an experimental simple Facebook status Update. With this application you can update your status seemly look like via <b>iPhone 4G</b> gadget. Follow this step!
	<ol><li><fb:prompt-permission perms="publish_stream"><b>Click here to start using this application</b></fb:prompt-permission>.</li> 
    <li><b>Press Ctrl+F5</b>, and you will see your profile pictures and status update form.</li>
	</ol>
	</p>
<?php
}
}
?>
<?php
if($is_tab || ($have_acc == 1)){
?>
<div style="padding:10px;width:800px;">
<fb:profile-pic uid="<?=$user_id?>" size="normal" width="100" style="float:left;" />
	<div style="margin-left:124px;">
    		<h2>Hi, <fb:name uid="<?=$user_id?>" useyou="false" capitalize="true" />!</h2>
			<p style="width:340px;">your current status: <br /><b><fb:user-status uid="<?=$user_id?>" linked="true"></fb:user-status></b></p>
    	<br />
    	</div>
    		
</div>
    	<fb:editor action="?do-it" labelwidth="50" style="">    
		<fb:editor-textarea label="Update Status" name="status" />  
		<fb:editor-buttonset>  
			<fb:editor-button value="Share via iPhone 4G" />  
		</fb:editor-buttonset>
	</fb:editor>

<div style="width:800px;margin:10px auto;">
	<iframe src="http://masedi.net/work/fbstatus/iklan_468x60.html" scrolling="no" frameborder="0" width="478" height="68">
	<p>Your browser does not support iframes.</p>
	</iframe>	

		<iframe src="http://masedi.net/work/fbstatus/iklan_linkunit.html" scrolling="no" frameborder="0" width="124" height="100">
		<p>Your browser does not support iframes.</p>
		</iframe>	
</div>

<div>
<h3>Developer note:</h3>
<p>This is a simple Facebook apps created for update your status.
</p>
</div>

<?php
}
?>