<?php
require_once('../../../wp-config.php');

check_admin_referer('preview_smilies');

$smilies = new smilies_package($_GET['smilies_themer_package']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $smilies->name; ?> Preview</title>
	<style type="text/css">
		body {background:#eee; font-size:.8em; padding:1px 1em; margin:0; font-family:sans-serif;}
		img {border:none; margin:.5em;}
		h2 {font-size:1em; margin:1em 0; color:#2b6fb6;}
		h1 {font-size:.9em; color:#999; text-align:center; font-weight:normal;}
		.change {font-size:.9em; text-align:right; padding-top:1.5em;}
		.change a {color: #c00;}
		input {
			font: 13px Verdana, Arial, Helvetica, sans-serif;
			height: auto;
			width: auto;
			background-color: transparent;
			background-image: url(../../../../../wp-admin/images/fade-butt.png);
			background-repeat: repeat;
			border: 3px double;
			border-right-color: rgb(153, 153, 153);
			border-bottom-color: rgb(153, 153, 153);
			border-left-color: rgb(204, 204, 204);
			border-top-color: rgb(204, 204, 204);
			color: rgb(51, 51, 51);
			padding: 0.25em 0.75em;
		}
		input:active {
			background: #f4f4f4;
			border-left-color: #999;
			border-top-color: #999;
		}
	</style>

</head>
<body>
<form onsubmit="return false;">
	<h1><?php echo $smilies->name; ?></h1>

	<table cellspacing="2" cellpadding="5" width="40%">
		<tr class="alternate">
		<th><?php _e('Text', 'smilies-themer'); ?></th>
		<th><?php _e('Smiley', 'smilies-themer');?></th>
		</tr>
	
	<?php
	$style = 'alternate';
	foreach ($smilies->smilies as $smiley => $img) {
		$style = ('alternate' == $style) ? '' : 'alternate';
		echo '<tr class="'. $style .'"><td> '. $smiley .' </td><td> <img src="'. $smilies->url_path .'/'. $img .'" /></td></tr>';
	}
	?>
	
	</table>
	
	<p class="change">
		<input type="button" name="Close" value="<?php _e('Close', 'smilies-themer') ?>" onclick="window.close();" /> &nbsp;
	</p>
</form>
</body>
</html>

