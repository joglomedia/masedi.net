<?Php
include "ovi-functions.php";

/* default parameter */
$username = "masedi.net";
$password = "AW#edc";
$ovicookie = "./.ovikukis";

/* GET Parameter */
$inviteemail = $_POST['email'];
$invitephone = $_POST['phone'];
$submit = $_POST['submit'];

$loginURL = "http://www.berburugenkovi.com/login/act/";
$loginRef = "http://www.berburugenkovi.com/login/";
$loginPostdata = "ovimail_address=$username&password=$password";

$inviteURL = "http://www.berburugenkovi.com/ref/act/";
$inviteRef = "http://www.berburugenkovi.com/ref";
$invitePostdata = "invited_email=$inviteemail&invited_phone=$invitephone";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en-us" xml:lang="en-us"> 
<head> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Undangan Berburu Genk Ovi</title>
    <script type="text/javascript" src="http://www.berburugenkovi.com/ovi-media/jquery-ui-1.7.2/jquery-1.3.2.js"></script>
    <link rel="stylesheet" type="text/css" href="http://www.berburugenkovi.com/ovi-media/css/base.css"/>
    <style>
		#top-logo-{ margin-top: 60px; }
		.footerz{ font-size:10px; margin-top:30px;}
	</style>
</head>
<body>
<div id="main-container">
<div id="top-logo-"></div>
<div id="middle-container">
<div id="middle-container-right">
<div id="menu-box">
                    <ul class="menu">
                        <li><a rel="nofollow" href="http://www.berburugenkovi.com/home">Home</a>&nbsp;|&nbsp;</li>
                        <li><a rel="nofollow" href="http://www.berburugenkovi.com/about">Tentang Berburu Genk OVI</a>&nbsp;|&nbsp;</li>

                        <li><a rel="nofollow" href="http://www.berburugenkovi.com/event">Event</a>&nbsp;|&nbsp;</li>
                        
                            <li><a rel="nofollow" href="http://www.berburugenkovi.com/login">Login</a>&nbsp;|&nbsp;</li>
                            <li><a href="http://www.masedi.net">Masedi.net</a>&nbsp;|&nbsp;</li>
                            <li><a href="http://www.masedi.net/ovi/index.php">Undang Berburu Genk OVI</a></li>
                        
                    </ul>
                </div>
              
                <div class="clear"></div>

                
                <div class="title"> 
                    <h1>Undangan Berburu Genk Ovi</h1> 
                </div> 
                <p>Masukkan alamat email dan atau nomor telepon anda, keluarga atau tetangga anda.</p>
<?Php
/* do Login */
if(!empty($submit)) {

$loginResponse = create_curl_query("POST", $loginURL, $loginRef, $ovicookie, $loginPostdata, false, true);
if(isResponse("body", "Undang", $loginResponse)) {
	$invite = true;
}else{
	$invite = false;
	echo '<p class="ierrmsg">Gagal menyambungkan dengan server Ovi Mail.</p>';
}

/* invite then logout */
if($invite) {
	$inviteResponse = create_curl_query("POST", $inviteURL, $inviteRef, $ovicookie, $invitePostdata, true, true);
	if(isResponse("body", "Undanganmu telah dikirimkan. Silakan mengirimkan undangan baru.", $inviteResponse)) {
		echo '<p class="infomsg">Undanganmu telah dikirimkan. Silakan cek inbox email atau SMS kamu! Lanjutkan pendaftaran Berburu Genk Ovi dengan mengunjungi link undangan yang tersedia.</p>';
	}elseif(isResponse("body", "Kamu tidak memasukkan undangan sama sekali. Silakan mencoba lagi.", $inviteResponse)) {
	}else{
		echo '<p class="ierrmsg">Unknown.</p>';
	}
}

}
?>
<p>
<form action="<?PHP echo $PHP_SELF; ?>" method="post" enctype="application/x-www-form-urlencoded">

<strong>Alamat Email</strong> :
<br /><input name="email" size="14" type="text" /> atau
<br /><br />
<strong>Nomor Telepon</strong> :
<br /><input maxlength="14" name="phone" size="14" type="text" />
<br />
Format nomor telepon (masukkan kode negara), ex: 628xxxxxx
<br />
<br /><input name="submit" type="submit" value="Undang saya untuk Berburu Genk Ovi!" />
</form>
</p>

    <div class="footerz">
    Halaman aplikasi undangan berburu genk ovi ini dibuat oleh MasEDI.net untuk mempermudah anda mendaftar Ovi Mail dan bergabung Berburu Genk Ovi. Konten halaman ini tidak berasosiasi dan diluar tanggung jawab Nokia maupun Ovi Mail.
    <br />&copy; 2010 Konten halaman ini sepenuhnya hasil kreatifitas MasEDI.net. Logo, Background, dan Design &copy; berburugenkovi.com
    </div>
</div>
</div>
</div>
</body>
</html>
<?

/* buat koneksi */
function create_curl_query($method="POST", $url="", $referer="", $ovicookie="", $postdata="", $clearcookies=true, $return=true) {
	//get user agent
	$uagent = urlencode(getenv("HTTP_USER_AGENT"));
	
	$ch = curl_init();
	curl_setopt ($ch, CURLOPT_URL, $url);
	//curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt ($ch, CURLOPT_USERAGENT, $uagent);
	curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
	//curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 0); // CURLOPT_FOLLOWLOCATION cannot be activated when safe_mode is enabled or an open_basedir is set
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch, CURLOPT_COOKIEJAR, $ovicookie);
	curl_setopt ($ch, CURLOPT_COOKIEFILE, $ovicookie);
	curl_setopt ($ch, CURLOPT_REFERER, $referer);
	curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata);
	curl_setopt ($ch, CURLOPT_POST, 1);
	$ovi_result = curl_exec ($ch);
	curl_close($ch);
	
	if($return) {
		return $ovi_result;
	}else{
		echo $ovi_result;
	}
	
	if($clearcookies) unlink($ovicookie);
	
	exit;
}

/*
if (stristr("", $_SERVER['HTTP_REFERER'])) {
	header("Location: http://www.example.com/"); //redirect back to post page.
}
*/
?>
