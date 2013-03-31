<?Php
include "ovi-functions.php";

/* default parameter */
$username = "masedi.net";
$password = "AW#edc";
$ovicookie = "./.ovikukis";

/* GET Parameter */
$submit = $_POST['submit'];
$invitedemail = $_POST['email'];
$invitedphone = $_POST['phone'];
$hiddencaptcha = $_POST['captcha'];
$captchacode = $_POST['captchacode'];
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
						<li><a rel="nofollow" href="http://www.masedi.net/ovi/index.php">Undang Berburu Genk OVI</a></li>
<li><a rel="nofollow" href="http://www.masedi.net/ovi/index.php">Tutorial Cara Mendaftar Berburu Genk OVI</a></li>
                    </ul>
                </div>
                <div class="clear"></div>
                <div class="title"> 
                    <h1>Undangan Berburu Genk Ovi</h1> 
                </div>
               <p>Ayo gabung di Berburu Genk Ovi dan raih kesempatan memenangkan Grand Prize Honda Jazz!
               </p><p>Kamu cukup memiliki akun Ovi Mail dan ajak sebanyak mungkin teman-teman, keluarga atau tetanggamu untuk ikut bergabung dalam program ini.
               </p><p>Tunggu apa lagi? Makin banyak buruanmu, makin banyak poinnya, makin gede kesempatan memenangkan hadiahnya!
               </p>
<?Php
/* do login and get captcha code */
$loginURL = "http://www.berburugenkovi.com/login/act/";
$loginRef = "http://www.berburugenkovi.com/login/";
$loginPostdata = "ovimail_address=$username&password=$password";

$loginResponse = create_curl_query("POST", $loginURL, $loginRef, $ovicookie, $loginPostdata, false, true);
if(isResponse("body", "Undang", $loginResponse)) {
	$invite = true;
}else{
	$invite = false;
	echo "<p class=\"errmsg\">Gagal menyambungkan dengan server Ovi Mail.</p>";
}
$captcha_code = get_xml_element("p", "", $loginResponse);
$captcha_code = str_replace('<input type="text" name="captcha" id="id_captcha" />', '<input type="text" name="captchacode" id="id_captcha" />', $captcha_code);

/* invite then logout */
if(isset($submit) && $invite) {
	if(!empty($invitedemail) and is_validemail($invitedemail)) {
		$inviteURL = "http://www.berburugenkovi.com/ref/act/";
		$inviteRef = "http://www.berburugenkovi.com/ref";
		$invitePostdata = "invited_email=$invitedemail&invited_phone=$invitedphone&captcha=$hiddencaptcha&captcha=$captchacode";
		//if($invite) {
			$inviteResponse = create_curl_query("POST", $inviteURL, $inviteRef, $ovicookie, $invitePostdata, true, true);
			if(isResponse("body", "Undanganmu telah dikirimkan. Silakan mengirimkan undangan baru.", $inviteResponse)) {
				echo "<p class=\"infomsg\">Undanganmu telah dikirimkan. Silakan cek inbox email atau SMS kamu! Lanjutkan pendaftaran Berburu Genk Ovi dengan mengunjungi link undangan yang tersedia.</p>";
			}elseif(isResponse("body", "Kamu tidak memasukkan undangan sama sekali. Silakan mencoba lagi.", $inviteResponse)) {
				echo "<p class=\"errmsg\">Masukkan alamat email anda.</p>";
			}elseif(isResponse("body", "Kamu salah memasukkan kode rahasia. Silakan mencoba lagi.", $inviteResponse)) {
				echo "<p class=\"errmsg\">Kamu salah memasukkan kode rahasia. Silakan mencoba lagi.</p>";
			}else{
				echo "<p class=\"errmsg\">Unknown.</p>";
			}
		//}
	}else{
		echo "<p class=\"errmsg\">Alamat email dan kode captcha harus diisi dengan benar.</p>";
	}
}
?>
<div>
<p>Masukkan alamat email dan atau nomor telepon kamu, keluarga atau tetangga kamu.</p>

<form action="<?PHP echo $PHP_SELF; ?>" method="post" enctype="application/x-www-form-urlencoded">
<p>
<strong>Alamat Email</strong> :
<br /><input name="email" size="14" type="text" value="<?Php echo $invitedemail; ?>" /> atau
<br /><br />
<strong>Nomor Telepon</strong> :
<br />
<input maxlength="14" name="phone" size="14" type="text" disabled="disabled" />
<br />
Format nomor telepon (masukkan kode negara), ex: 628xxxxxx
<br />
</p>
<p>
<?Php echo $captcha_code; ?>
</p>
<p>
<input name="submit" type="submit" value="Undang saya untuk Berburu Genk Ovi!" />
</p>
</form>
</div>

    <div class="footerz">
    Halaman aplikasi undangan berburu genk ovi ini dibuat oleh <a href="http://www.masedi.net">MasEDI Belajar Ngeblog</a> untuk mempermudah kamu mendaftar Ovi Mail dan bergabung dengan Berburu Genk Ovi. Konten halaman ini tidak berasosiasi dan diluar tanggung jawab Nokia maupun Ovi Mail.
    <br />&copy; 2010 Konten halaman ini sepenuhnya hasil kreatifitas MasEDI.net. Logo, Background, dan Design &copy; www.berburugenkovi.com
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
	//$uagent = getenv("HTTP_USER_AGENT");
	$uagent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6";
	
	$ch = @curl_init();
	curl_setopt ($ch, CURLOPT_URL, $url);
	//curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt ($ch, CURLOPT_USERAGENT, $uagent);
	curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
	//curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1); //not activated when safe_mode or open_basedir enabled
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
	
	if($clearcookies) { unlink($ovicookie); }
	
	exit;
}

/*
if (stristr("", $_SERVER['HTTP_REFERER'])) {
	header("Location: http://www.example.com/"); //redirect back to post page.
}
*/
?>
