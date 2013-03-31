

<?
error_reporting(0);
if(isset($_POST['submit'])){
	session_start();
	if (!class_exists('ConstantContact', true)){
		include_once('ConstantContact.php');
	}
	$username = $_POST['username'];
	$apiKey = $_POST['apikey'];
	$consumerSecret = $_POST['usersecret'];
	$Datastore = new CTCTDataStore();
	$DatastoreUser = $Datastore->lookupUser($username);
	
	if($DatastoreUser){
	
		echo '
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js" type="text/javascript"></script>
		<script>
		$(document).ready(function(){
			$(".cc_username", window.parent.document).val("'.$_POST['username'].'");
			$(".cc_apikey", window.parent.document).val("'.$_POST['apikey'].'");
			$(".cc_usersecret", window.parent.document).val("'.$_POST['usersecret'].'");
			$(".cc_password", window.parent.document).val("'.$_POST['password'].'");
			$(".cc a", window.parent.document).attr("href", "#");
			$(".cc a", window.parent.document).fadeOut();
			$(".cc_getlist", window.parent.document).fadeIn();
		});
		</script>';
		echo '<style>
		
		body{font-family: "Helvetica Neue", Helvetica , Arial , Sans-Serif; font-size:12pt;}
		

		
		
		</style>';
	
		echo "You're connected , please close this window";
	
	} else {
	//echo $apiKey.$consumerSecret;
	echo ' Click <a href="example_verification.php?apiKey='.$apiKey.'&secret='.$consumerSecret.'&return='.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'">here</a> to authorize';
	
	
	}
	
}else{ ?>

<style>
	body{font-family: "Helvetica Neue", Helvetica , Arial , Sans-Serif; font-size:12pt;}
	h3 {
	    -moz-border-bottom-colors: none;
	    -moz-border-image: none;
	    -moz-border-left-colors: none;
	    -moz-border-right-colors: none;
	    -moz-border-top-colors: none;
	    background: none repeat scroll 0 0 transparent;
	    border-color: -moz-use-text-color -moz-use-text-color #DDDDDD;
	    border-style: none none solid;
	    border-width: medium medium 1px;
	    color: #5D5D5D;
	    font-size: 18px;
	    margin: 10px 0;
	    padding-bottom: 10px;
	}
</style>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" />
	<h3>Your Constant Contact Username</h3>
	<input type="text" name="username" value="your user name" class="cc_username" />
	<input type="hidden" name="apikey" value="ccae03b3-ac24-438d-b385-45e4bcdda55d" class="cc_apikey" />
	<input type="hidden" name="usersecret" value="fffbd2c0b659446ea266b74a1bd1fc29" class="cc_usersecret" />
	<h3>Your Constant Contact Password</h3>
	<input type="password" name="password" value="password" class="cc_password" /><br/><br/>
	<input type="submit" name="submit" />
	 
</form>
<?php }
?>