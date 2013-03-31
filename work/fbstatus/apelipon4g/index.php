<?php
//masukin facebook platform client-nya
require_once 'facebook.php';

// Ini api key dan app secret didapet pas kamu bikin aplikasi
// iPhone 4G, app ID: 109845085723089
$appapikey = '51bc46ad486ef080afbe6663ccdf8b1c';
$appsecret = 'e4a92cd9d97cfdcf07f08b988be45790';

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
	
	if($_POST['status'] != ''){
		
		$message = stripslashes( $_POST['status'] );
		
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
			<p style="width:340px;">Your current status: <br /><b><fb:user-status uid="<?=$user_id?>" linked="true"></fb:user-status></b></p>
    	<br />
	<h3>Update Your Status Here</h3>	
	</div>
</div>
    	<fb:editor action="?do-it" labelwidth="50">    
		<fb:editor-textarea label="Update Status" name="status" />  
		<fb:editor-buttonset>  
			<fb:editor-button value="Share via iPhone 4G" />  
		</fb:editor-buttonset>
	</fb:editor>

<div style="width:800px;margin:10px auto;">
</div>
<div><small>Advertisement:</small><br />
<a href="http://www.paid-to-promote.net/member/signup.php?r=masedi" target="_blank"><img src="http://www.paid-to-promote.net/images/ptp.gif" alt="Get Paid To Promote, Get Paid To Popup, Get Paid Display Banner" width="468" height="60" border="0" longdesc="http://www.paid-to-promote.net/" /></a>
</div>
<div>
<h3>Developer note:</h3>
<p>This is a simple Facebook apps created for iPhone 4 and iPhone 5 lover. Using this app you can update your Facebook status seemly look like via iPhone 5 gadget. iPhone 5 is the 5th generation of Apple iPhone. Join our <a href="http://www.facebook.com/apps/application.php?id=109845085723089">Fan Page</a> for the latest discussion and roundup.<br />
How cool is it? :D
</p>
<p>Created by <a href="http://masedi.net" title="Blog dan Berita Teknologi">MasEDI Networked Blogs</a></strong> hosted by <strong><a href="http://www.joglohosting.com" title="Affordable Web Hosting">JOGLOHosting</a></strong>. This apps supported by <strong><a href="http://www.mydailysoftwares.com" title="Free Software Download">Free Software Download</a></strong> and <strong><a href="http://www.webhostindeals.com" title="Web Hosting Review">Best Web Hosting Review</a></strong>
</p>
</div>

<?php
}
?>
