<?php header("Content-type: text/css");?>
<?php
$strip_color = $_GET['strip'];
$preload_hide = $_GET['prehide'];
if ($preload_hide == 'yes') $preload_hide = 'display:none;';
else $preload_hide = '';
$font_color = '#FFFFFF';
if ($strip_color == "dark" || $strip_color == "hide") {
	$font_color = '#000000';
}
?>
.sharebutton{padding:5px 1px 5px <?php if ($_GET['stralign']=='left') echo '12px'; else echo '1px'; ?>;width:<?php print $_GET['w']; ?>px;float:left;z-index:250;list-style:none;}
.getsocial{width:<?php print $_GET['w']; ?>px;background:#<?php print $_GET['color']; ?> url(../images/sharetitle_<?php print $_GET['strip']; ?>.png) no-repeat bottom <?php print $_GET['stralign']; ?>;border:1px solid #<?php print $_GET['border']; ?>;position:absolute;top:200px;left:0px;z-index:200;<?php echo $preload_hide; ?><?php if ($_GET['rc'] == "yes") {echo 'border-radius: 3px 3px 3px 3px;-moz-border-radius: 3px 3px 3px 3px;-webkit-border-top-left-radius: 3px;-webkit-border-bottom-left-radius: 3px;-webkit-border-top-right-radius: 3px;-webkit-border-bottom-right-radius: 3px;border-top-left-radius: 3px 3px;border-bottom-left-radius: 3px 3px;border-top-right-radius: 3px 3px;border-bottom-right-radius: 3px 3px';} ?>}
.sharebutton.sharefooter{color:<?php echo $font_color; ?>;font-size:0.6em;padding:0px 2px 0 <?php if ($_GET['stralign']=='left') echo '12px'; else echo '2px'; ?>;margin:0px 1px 0px 2px;width:<?php print $_GET['w']; ?>px;float:left;z-index:250;list-style:none;}
.sharebutton.sharefooter a{text-decoration:none;color:<?php echo $font_color; ?>;}
.FBConnectButton_Small{background-position:-5px -232px !important;border-left:1px solid #1A356E}
.FBConnectButton_Text{margin-left:12px !important;padding:2px 3px 3px !important}
.suHostedBadge{list-style: none;}