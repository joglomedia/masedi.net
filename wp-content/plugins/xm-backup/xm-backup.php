<?php
/*
Plugin Name: XM Backup
Plugin URI: http://www.xaviermedia.com/wordpress/plugins/xm-backup.php
Description: Backup your blog database and files to Dropbox, FTP, Online File Folder or email
Author: Xavier Media
Version: 0.9.1
Author URI: http://www.xaviermedia.com/
*/

include 'dropbox/autoload.php';

register_activation_hook(__FILE__, 'xmbackup_DoMyBackup');
add_action( 'xmbackup_DoMyBackup', 'xmbackup_DoBackup' );

/* creates a compressed zip file */
function create_zip($files = array(),$destination = '',$overwrite = false) 
{
	// Function from David Walsh:
	// http://davidwalsh.name/create-zip-php

	//if the zip file already exists and overwrite is false, return false
	if(file_exists($destination) && !$overwrite) { return false; }
	//vars
	$valid_files = array();
	//if files were passed in...
	if(is_array($files)) {
		//cycle through each file
		foreach($files as $file) {
			//make sure the file exists
			if(file_exists($file)) {
				$valid_files[] = $file;
			}
		}
	}
	//if we have good files...
	if(count($valid_files)) {
		//create the archive
		$zip = new ZipArchive();
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			return false;
		}
		//add the files
		foreach($valid_files as $file) {
			$zip->addFile($file,$file);
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
		
		//close the zip -- done!
		$zip->close();
		
		//check to make sure the file exists
		return file_exists($destination);
	}
	else
	{
		return false;
	}
}


function xmbackup_backup_tables()
{ 
	global $wpdb;

	//get all of the tables
	$tables = array();
	$tables = $wpdb->get_results('SHOW TABLES', ARRAY_N);

	//cycle through
	foreach($tables as $table)
	{
		$result = $wpdb->get_results('SELECT * FROM '.$table[0] .'', ARRAY_N);
		$num_fields = $wpdb->num_rows;
    
		// Drop the table
		$return.= 'DROP TABLE '.$table[0].';';

		// Get the structure and create the table
		$row2 = $wpdb->get_results('SHOW CREATE TABLE '.$table[0], ARRAY_N);
		$return.= "\n\n".$row2[0][1].";\n\n";

		for ($i = 0; $i < $num_fields; $i++)
		{
			$return.= 'INSERT INTO '.$table[0].' VALUES(';
			$num_cols = count($result[$i]);

			for($j=0; $j<$num_cols; $j++) 
			{
				$result[$i][$j] = addslashes($result[$i][$j]);
				$result[$i][$j] = ereg_replace("\n","\\n",$result[$i][$j]);
				if (isset($result[$i][$j])) { $return.= '"'.$result[$i][$j].'"' ; } else { $return.= '""'; }
				if ($j<($num_cols-1)) { $return.= ','; }
			}
			$return.= ");\n";
		}
	}

	$return.="\n\n\n";
  
 	//save file

	$filename = ABSPATH .'wp-content/uploads/db-backup-'. time() .'-'. md5(time()) .'.sql';

	$handle = fopen($filename,'w+');
	fwrite($handle,$return);
	fclose($handle);

 	// return an array with the file, to be used in the ZIP function
	$files = array($filename);

	return $files;
}

function directoryToArray($directory, $recursive, $onlydirectories) 
{
	// Function from David Walsh:
	// http://davidwalsh.name/create-zip-php
	// and modified by Xavier Media

	$array_items = array();
	if ($handle = opendir($directory)) 
	{
		while (false !== ($file = readdir($handle))) 
		{
			if ($file != "." && $file != ".." && $file != "Thumbs.db") 
			{
				if (is_dir($directory. "/" . $file)) 
				{
					if($recursive) 
					{
						$array_items = array_merge($array_items, directoryToArray($directory. "/" . $file, $recursive, $onlydirectories));
					}
					$file = $directory . "/" . $file;
					$array_items[] = preg_replace("/\/\//si", "/", $file);
				} 
				else if (!$onlydirectories) 
				{
					$file = $directory . "/" . $file;
					$array_items[] = preg_replace("/\/\//si", "/", $file);
				}
			}
		}
		closedir($handle);
	}
	return $array_items;
}

function xmbackup_DoBackup()
{
	$opt  = get_option('xmbackupoptions');
	$options = unserialize($opt);


	$backupfiles = array();

	if ($options[dbbackup] == "db")
	{
		$backupfiles = xmbackup_backup_tables();
		$temporary_db_file = $backupfiles[0];
	}

	$num = count($options[backupdirectories]);

	for ($i = 0; $i < $num; $i++)
	{
		$backupfiles = array_merge(directoryToArray($options[backupdirectories][$i], true, false), $backupfiles);
	}	


	//if true, good; if false, zip creation failed
	$result = create_zip($backupfiles, ABSPATH .'wp-content/uploads/backuparchive.zip');
	if ($result === false)
	{


	}

	//////////////// DROPBOX ///////////////////

	if ($options[backupdropbox] == "yes")
	{
		session_start();

		$oauth = new Dropbox_OAuth_PEAR($options[dropboxck], $options[dropboxsecret]);

		// If the PHP OAuth extension is not available, you can try
		// PEAR's HTTP_OAUTH instead.
		// $oauth = new Dropbox_OAuth_PEAR($options[dropboxck], $options[dropboxsecret]);

		$dropbox = new Dropbox_API($oauth);

		$oauth->setToken($options[dropboxtokens]);

		// Now you can use the API

		$dropbox->putFile('Backups/'. str_replace('YYMMDD', date('Ymd'), $options[backupname]) , ABSPATH .'wp-content/uploads/backuparchive.zip');
	}

	//////////////// EMAIL ///////////////////
	// This function is from Code Walkers: http://www.codewalkers.com/seecode/98.html

	if ($options[backupemail] == "yes")
	{
		$fileatt = ABSPATH .'wp-content/uploads/backuparchive.zip'; // Path to the file                 
		$fileatt_type = "application/octet-stream"; // File Type
		$fileatt_name = str_replace('YYMMDD', date('Ymd'), $options[backupname]); // Filename that will be used for the file as the attachment

		$email_from = $options[emailaddress]; // Who the email is from
		$email_subject = $options[emailsubject]. " ". date('Y-m-d'); // The Subject of the email
		$email_txt = "This is the blog backup for ". date('Y-m-d'); // Message that the email has in it

		$email_to = $options[emailaddress]; // Who the email is too

		$headers = "From: ".$email_from;

		$file = fopen($fileatt,'rb');
		$data = fread($file,filesize($fileatt));
		fclose($file);

		$semi_rand = md5(time());
		$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
   
		$headers .= "\nMIME-Version: 1.0\n" .
		            "Content-Type: multipart/mixed;\n" .
		            " boundary=\"{$mime_boundary}\"";

		$email_message .= "This is a multi-part message in MIME format.\n\n" .
		                "--{$mime_boundary}\n" .
		                "Content-Type:text/html; charset=\"iso-8859-1\"\n" .
		               "Content-Transfer-Encoding: 7bit\n\n" .
		$email_message . "\n\n";

		$data = chunk_split(base64_encode($data));

		$email_message .= "--{$mime_boundary}\n" .
		                  "Content-Type: {$fileatt_type};\n" .
		                  " name=\"{$fileatt_name}\"\n" .
		                  //"Content-Disposition: attachment;\n" .
		                  //" filename=\"{$fileatt_name}\"\n" .
		                  "Content-Transfer-Encoding: base64\n\n" .
		                 $data . "\n\n" .
		                  "--{$mime_boundary}--\n";
	
		$ok = @mail($email_to, $email_subject, $email_message, $headers);

		if($ok) 
		{
//			echo "<font face=verdana size=2>The file was successfully sent!</font>";
		} 
		else 
		{
			die("Sorry but the email could not be sent. Please go back and try again!");
		} 
	}

	//////////////// FTP ///////////////////


	if ($options[backupftp] == "yes")
	{
		$ch = curl_init();
		$fp = fopen(ABSPATH .'wp-content/uploads/backuparchive.zip', 'r');
		curl_setopt($ch, CURLOPT_URL, 'ftp://'. $options[ftplogin] .':'. $options[ftppwd] .'@'. $options[ftpserver] .'/'. str_replace('YYMMDD', date('Ymd'), $options[backupname]));
		curl_setopt($ch, CURLOPT_UPLOAD, 1);
		curl_setopt($ch, CURLOPT_INFILE, $fp);
		curl_setopt($ch, CURLOPT_INFILESIZE, filesize(ABSPATH .'wp-content/uploads/backuparchive.zip'));
		curl_exec ($ch);
		$error_no = curl_errno($ch);
		curl_close ($ch);
	  	if ($error_no == 0) 
		{
			$error = 'File uploaded succesfully.';
		} 
		else 
		{
			$error = 'File upload error.';
		}

	}

	//////////////// Online File Folder ///////////////////


	if ($options[backuponlinefilefolder] == "yes")
	{
		$ch = curl_init();
		$fp = fopen(ABSPATH .'wp-content/uploads/backuparchive.zip', 'r');
		curl_setopt($ch, CURLOPT_URL, 'ftp://'. $options[offlogin] .':'. $options[offpwd] .'@www.onlinefilefolder.com/'. str_replace('YYMMDD', date('Ymd'), $options[backupname]));
		curl_setopt($ch, CURLOPT_UPLOAD, 1);
		curl_setopt($ch, CURLOPT_INFILE, $fp);
		curl_setopt($ch, CURLOPT_INFILESIZE, filesize(ABSPATH .'wp-content/uploads/backuparchive.zip'));
		curl_exec ($ch);
		$error_no = curl_errno($ch);
		curl_close ($ch);
	  	if ($error_no == 0) 
		{
			$error = 'File uploaded succesfully.';
		} 
		else 
		{
			$error = 'File upload error.';
		}

	}

	unlink(ABSPATH .'wp-content/uploads/backuparchive.zip');
	unlink($temporary_db_file);


}


function xmbackup_options()
{

      	if ( 'save' == $_REQUEST['action'] ) 
		{


			if ($_REQUEST[backupdropbox] == "yes")
			{
				$dropboxck = $_REQUEST[dropboxck];
				$dropboxsecret = $_REQUEST[dropboxsecret];
				$dropboxemail = $_REQUEST[dropboxemail];

				$dropboxpwd = $_REQUEST[dropboxpwd];

				if ($dropboxpwd != "")
				{

					session_start();

					$oauth = new Dropbox_OAuth_PEAR($dropboxck, $dropboxsecret);

					// If the PHP OAuth extension is not available, you can try
					// PEAR's HTTP_OAUTH instead.
					// $oauth = new Dropbox_OAuth_PEAR($dropboxck, $dropboxsecret);

					$dropbox = new Dropbox_API($oauth);

					$dropboxtokens = $dropbox->getToken($dropboxemail, $dropboxpwd);
				}
				else
				{
					$opt  = get_option('xmbackupoptions');
					$options = unserialize($opt);
					$dropboxtokens = $options[dropboxtokens];
				}

			}

			if ($_REQUEST[backuponlinefilefolder] == "yes")
			{
				$offlogin = $_REQUEST[offlogin];
				$offpwd = $_REQUEST[offpwd];
			}

			if ($_REQUEST[backupftp] == "yes")
			{
				$ftplogin = $_REQUEST[ftplogin];
				$ftppwd = $_REQUEST[ftppwd];
				$ftpserver = $_REQUEST[ftpserver];
			}

			if ($_REQUEST[backupemail] == "yes")
			{
				$emailaddress = $_REQUEST[emailaddress];
				$emailsubject = $_REQUEST[emailsubject];
			}

			$options = array(
				"backupdropbox" => $_REQUEST[backupdropbox],
				"dropboxck" => $dropboxck,
				"dropboxsecret" => $dropboxsecret,
				"dropboxemail" => $dropboxemail,
				"dropboxtokens" => $dropboxtokens,
				"backuponlinefilefolder" => $_REQUEST[backuponlinefilefolder],
				"offlogin" => $offlogin,
				"offpwd" => $offpwd,
				"backupftp" => $_REQUEST[backupftp],
				"ftplogin" => $ftplogin,
				"ftppwd" => $ftppwd,
				"ftpserver" => $ftpserver,
				"backupemail" => $_REQUEST[backupemail],
				"emailaddress" => $emailaddress,
				"emailsubject" => $emailsubject,
				"dbbackup" => $_REQUEST[dbbackup],
				"backupdirectories" => $_REQUEST[backupdirectories],
				"frequency" => $_REQUEST[frequency],
				"backupname" => $_REQUEST[backupname],
				);

			if (wp_get_schedule('xmbackup_DoMyBackup') != $options[frequency])
			{
				wp_clear_scheduled_hook('xmbackup_DoMyBackup');
			}

			if ($options[frequency] == "manually")
			{
				wp_clear_scheduled_hook('xmbackup_DoMyBackup');
			}
			else if (!wp_next_scheduled('xmbackup_DoMyBackup')) 
			{
				wp_schedule_event( time()+3600, $options[frequency], 'xmbackup_DoMyBackup' );
			}

			$opt = serialize($options);
			update_option('xmbackupoptions', $opt);

			if ($_REQUEST[dobackupnow] == "yes")
			{
				xmbackup_DoBackup();
			}

	}
	else
	{
		$opt  = get_option('xmbackupoptions');
		$options = unserialize($opt);
	}
	?>
	<STYLE>
	.hiddenfield 
	{
		display:none;
	}
	.nothiddenfield 
	{
	}
	</STYLE>

	<div class="updated fade-ff0000"><p><strong>Need web hosting for your blog?</strong> Get 10 Gb web space and unlimited bandwidth for only $3.40/month at <a href="http://2ve.org/xMY3/" target="_blank">eXavier.com</a>, or get the Ultimate Plan with unlimited space and bandwidth for only $14.99/month.</p></div>


	<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" name=pf>
	<input type="hidden" name="action" value="save" />
	<h1>XM Backup Options</h1>
	If you get stuck on any of these options, please have a look at the <a href="http://www.xaviermedia.com/wordpress/plugins/xm-backup.php">XM Backup plugin page</a> or visit the <a href="http://www.xavierforum.com/php-&-cgi-scripts-f3.html">support forum</a>.
	<h2>Where to save the backups</h2>
	<p>Select where you want to save the backups. The email option is only recommended for very small blogs. If you like you can have your backup saved to multiple locations, just select as many options you like.</p>
	<p>
	<?php
	$db = array(
		"0" => "http://db.tt/2nFGm1W",
		"1" => "http://db.tt/V7ygm5Zx",
		"2" => "http://db.tt/GyqgQDJo"
		);

	$dropboxlink = $db[rand(1,2)];

	?>

	<INPUT TYPE=checkbox NAME=backupdropbox VALUE="yes" <?php	if ($options[backupdropbox] == "yes") { echo ' CHECKED'; } ?> onClick="javascript:if(document.pf.backupdropbox.checked==true) { document.getElementById('dropboxinfo').className = 'nothiddenfield'; } else { document.getElementById('dropboxinfo').className = 'hiddenfield'; };"> <img src="../wp-content/plugins/xm-backup/dropbox.png" ALT="Dropbox" BORDER=0 /> <a href="<?php echo $dropboxlink; ?>" target="_blank">Dropbox</a> (sign up now and get 250 Mb extra disk space)<BR />
	<div id=dropboxinfo class=<?php if($options[backupdropbox] == "yes") { echo 'nothiddenfield'; } else { echo 'hiddenfield'; } ?>>
		<p>To use Dropbox as the storage for your backups you need to first setup an App with Dropbox. Visit their <a href="<?php echo $dropboxlink; ?>" target="_blank">web site</a> to register your blog as an App and click on <i>Developers</i> &gt; 
		<i>My Apps</i> &gt; <i>Create an App</i>. You can chose any of the access alternatives (app folder or full Dropbox). Then fill in the app key and the app secret you get 
		from Dropbox in the fields below.</p>

		&nbsp; &nbsp; App key: <input type=<?php if ($options[dropboxck] == "") { echo 'text'; } else { echo 'password'; } ?> size=30 NAME=dropboxck VALUE="<?php echo $options[dropboxck] ?>" /><br />
		&nbsp; &nbsp; App secret: <input type=<?php if ($options[dropboxsecret] == "") { echo 'text'; } else { echo 'password'; } ?> size=30 NAME=dropboxsecret VALUE="<?php echo $options[dropboxsecret] ?>" /><br /><br />

		&nbsp; &nbsp; Dropbox email: <input type=text size=30 NAME=dropboxemail VALUE="<?php echo $options[dropboxemail] ?>" /><br />
		&nbsp; &nbsp; Dropbox password: <input type=password size=30 NAME=dropboxpwd VALUE="<?php if ($options[dropboxemail] != "") { echo 'secret password ;-)'; } ?>" <?php if ($options[dropboxemail] != "") { echo 'disabled'; } ?> /><br />
	</div>

	<br />

	<INPUT TYPE=checkbox NAME=backuponlinefilefolder VALUE="yes" <?php	if ($options[backuponlinefilefolder] == "yes") { echo ' CHECKED'; } ?> onClick="javascript:if(document.pf.backuponlinefilefolder.checked==true) { document.getElementById('offinfo').className = 'nothiddenfield'; } else { document.getElementById('offinfo').className = 'hiddenfield'; };" > <img src="../wp-content/plugins/xm-backup/onlinefilefolder.png" ALT="Online File Folder" BORDER=0 /> <a href="http://www.securepaynet.net/email/online-file-storage.aspx?ci=1796&prog_id=xaviermedia&isc=xmbackup" target="_blank">Online Storage</a> (Get 100 Gb space for less than a Dropbox account)<BR />
	<div id=offinfo class=<?php if($options[backuponlinefilefolder] == "yes") { echo 'nothiddenfield'; } else { echo 'hiddenfield'; } ?>>
		<p>Fill in your Online Storage login information.</p>

		&nbsp; &nbsp; Online Storage login: <input type=text size=30 NAME=offlogin VALUE="<?php echo $options[offlogin] ?>" /><br />
		&nbsp; &nbsp; Online Storage password: <input type=password size=30 NAME=offpwd VALUE="<?php echo $options[offpwd] ?>" /><br />
	</div>

	<br />

	<INPUT TYPE=checkbox NAME=backupftp VALUE="yes" <?php	if ($options[backupftp] == "yes") { echo ' CHECKED'; } ?>  onClick="javascript:if(document.pf.backupftp.checked==true) { document.getElementById('ftpinfo').className = 'nothiddenfield'; } else { document.getElementById('ftpinfo').className = 'hiddenfield'; };"> <img src="../wp-content/plugins/xm-backup/ftp.png" ALT="FTP" BORDER=0 /> <a href="http://www.securepaynet.net/email/online-file-storage.aspx?ci=1796&prog_id=xaviermedia&isc=xmbackup" target="_blank">FTP</a> (Get a FTP account with 100 Gb space for only $1.93/month)<BR />
	<div id=ftpinfo class=<?php if($options[backupftp] == "yes") { echo 'nothiddenfield'; } else { echo 'hiddenfield'; } ?>>
		<p>Fill in your FTP login information. Make sure it's not on the same server as your blog! If you need an external FTP account please <a href="http://www.securepaynet.net/email/online-file-storage.aspx?ci=1796&prog_id=xaviermedia&isc=xmbackup" target="_blank">have a look at this option</a>.</p>

		&nbsp; &nbsp; FTP login: <input type=text size=30 NAME=ftplogin VALUE="<?php echo $options[ftplogin] ?>" /><br />
		&nbsp; &nbsp; FTP password: <input type=password size=30 NAME=ftppwd VALUE="<?php echo $options[ftppwd] ?>" /><br /><br />

		&nbsp; &nbsp; FTP server: ftp://<input type=text size=30 NAME=ftpserver VALUE="<?php echo $options[ftpserver] ?>" /><br />
	</div>

	<br />

	<INPUT TYPE=checkbox NAME=backupemail VALUE="yes" <?php	if ($options[backupemail] == "yes") { echo ' CHECKED'; } ?>  onClick="javascript:if(document.pf.backupemail.checked==true) { document.getElementById('emailinfo').className = 'nothiddenfield'; } else { document.getElementById('emailinfo').className = 'hiddenfield'; };"> <img src="../wp-content/plugins/xm-backup/mail.png" ALT="Email" BORDER=0 /> Email<BR />
	<div id=emailinfo class=<?php if($options[backupemail] == "yes") { echo 'nothiddenfield'; } else { echo 'hiddenfield'; } ?>>
		<p>Fill in the email address where you want to have the backups emailed. Please note that this isn't a good option for big blogs! This could fill up the email account pretty fast and you need to make sure there's enough space for the emails.</p>

		&nbsp; &nbsp; Email Address: <input type=text size=30 NAME=emailaddress VALUE="<?php echo $options[emailaddress] ?>" /><br /><br />

		&nbsp; &nbsp; Email Subject: <input type=text size=30 NAME=emailsubject VALUE="<?php if ($options[emailsubject] == "") { echo "Backup for ". get_bloginfo('name'); } else  { echo $options[emailsubject]; } ?>" /><br />
	</div>


	<h2>What to backup</h2>
	<p>Select what to backup. If you have yearly folders in your upload folder you may perhaps not have to backup all your files everytime. Do a onetime backup of your older uploads and then only include 
	the latest folder in the daily backups (to save disk space, server CPU and server memory).</p>

	<p><input type=checkbox name=dbbackup value="db" <?php if ($options[dbbackup] == "db") { echo ' CHECKED'; } ?>> <img src="../wp-content/plugins/xm-backup/database.png" ALT="Database" BORDER=0 /> Database</p>
	<p>
	<?php
	$directories = directoryToArray(ABSPATH ."wp-content/uploads/", false, true);
	$num = count($directories);

	echo '<input type=checkbox name=backupdirectories[] value="'. ABSPATH .'wp-content/uploads" onClick="javascript:CheckFolders();" id=dirmain';
	if (in_array(ABSPATH .'wp-content/uploads', $options[backupdirectories])) 
	{
		echo ' CHECKED';
		$checkboxdisabled = " disabled";
	}
	echo '> <img src="../wp-content/plugins/xm-backup/folder.png" ALT="Folder" BORDER=0 /> '. ABSPATH .'wp-content/uploads<br />';

	for ($i = 0; $i < $num; $i++)
	{
		echo '<input type=checkbox name=backupdirectories[] value="'. $directories[$i] .'" id=dir'. $i;
		if (in_array($directories[$i], $options[backupdirectories]) || 	$checkboxdisabled) 
		{
			echo ' CHECKED';
		}
		echo 	$checkboxdisabled .'> <img src="../wp-content/plugins/xm-backup/folder.png" ALT="Folder" BORDER=0 /> '. $directories[$i] .'<br />';
	}

	echo '<script type="text/javascript">';
	echo 'function CheckFolders() {';
	echo 'if (document.getElementById(\'dirmain\').checked == true) {';
	echo '	var varchecked = true;';
	echo '	var vardisabled = true;';
	echo '} else {';
	echo '	var varchecked = false;';
	echo '	var vardisabled = false;';
	echo '}';

	for ($i = 0; $i < $num; $i++)
	{
		echo '	document.getElementById(\'dir'. $i .'\').checked = varchecked;';
		echo '	document.getElementById(\'dir'. $i .'\').disabled = vardisabled;';
	}

	echo '}';
	echo '</script>';



	?>
	</p>

	<h2>When to backup</h2>
	<p>Select if you want the backups to be done daily or only when you manually select to create a backup.</p>

	<input type=radio name=frequency value=daily <?php if ($options[frequency] == "daily" || $options[frequency] == "") { echo ' CHECKED'; } ?> /> Daily <br />
	<input type=radio name=frequency value=twicedaily <?php if ($options[frequency] == "twicedaily") { echo ' CHECKED'; } ?> /> Twice daily <br />
	<input type=radio name=frequency value=hourly <?php if ($options[frequency] == "hourly") { echo ' CHECKED'; } ?> /> Hourly<br />
	<input type=radio name=frequency value=manually <?php if ($options[frequency] == "manually") { echo ' CHECKED'; } ?> onClick="javascript:document.pf.dobackupnow.checked=true;" /> Manually (check the box below "<a href="#manualbackup" onClick="javascript:document.pf.dobackupnow.checked=true;">Do a manual backup now</a>" and save the options whenever you want to create your backup)<br />

	<?php 

		$nextbackup = wp_next_scheduled( xmbackup_DoMyBackup ); 
		if ($nextbackup)
		{
			echo '<P>Next backup is scheduled to happen at <b>'. date(get_option('date_format') .' '. get_option('time_format'), $nextbackup) .'</b> and the current server time right now is <b>'. date(get_option('date_format') .' '. get_option('time_format')) .'</b>.</p>';
		}
	?>

	<h2>What to name the backup</h2>
	<p>Select how you want the file name of your backups to be. If you select to have the date included in the name you may have to manually delete old backups every now and then to free up disk space.</p>

	<?php
	$bloglink = parse_url(home_url());
	?>

	<input type=radio name=backupname <?php if ($options[backupname] == "Backup_". $bloglink[host] ."_YYMMDD.zip" || $options[backupname] == "") { echo ' CHECKED'; } ?> value="Backup_<?php echo $bloglink[host]; ?>_YYMMDD.zip" /> Backup_<?php echo $bloglink[host]; ?>_<i>YYMMDD</i>.zip <br />
	<input type=radio name=backupname <?php if ($options[backupname] == "Backup_". $bloglink[host] .".zip") { echo ' CHECKED'; } ?> value="Backup_<?php echo $bloglink[host]; ?>.zip" /> Backup_<?php echo $bloglink[host]; ?>.zip <br />
	<input type=radio name=backupname <?php if ($options[backupname] == "Backup_YYMMDD.zip") { echo ' CHECKED'; } ?> value="Backup_YYMMDD.zip" /> Backup_<i>YYMMDD</i>.zip <br />
	<input type=radio name=backupname <?php if ($options[backupname] == "Backup.zip") { echo ' CHECKED'; } ?> value="Backup.zip" /> Backup.zip <br />


	<a name="manualbackup"></a><h2>Do a manual backup now</h2>
	<p><input type=checkbox name=dobackupnow VALUE=yes> Check this checkbox to do a manual backup now (good for testing your settings above).</p>


	<div class="submit"><input type="submit" name="info_update" value="Update Options" class="button-primary"  /></div></form>
	<a target="_blank" href="http://feed.xaviermedia.com/xm-wordpress-stuff/"><img src="http://feeds.feedburner.com/xm-wordpress-stuff.1.gif" alt="XavierMedia.com - Wordpress Stuff" style="border:0"></a><BR/>

	<h2>Wordpress plugins from Xavier Media&reg;</h2>
	<UL>
	<li><a href="http://wordpress.org/extend/plugins/wp-statusnet/" TARGET="_blank">WP-Status.net</a> - Posts your blog posts to one or multiple Status.net servers and even to Twitter 
	<li><a href="http://wordpress.org/extend/plugins/wp-email-to-facebook/" TARGET="_blank">WP Email-to-Facebook</a> - Posts your blog posts to one or multiple Facebook pages from your WordPress blog 
	<li><a href="http://wordpress.org/extend/plugins/wp-check-spammers/" TARGET="_blank">WP-Check Spammers</a> - Check comment against the SpamBot Search Tool using the IP address, the email and the name of the poster as search criteria 
	<li><a href="http://wordpress.org/extend/plugins/xm-backup/" TARGET="_blank">XM Backup</a> - Do backups of your Wordpress database and files in the uploads folder. Backups can be saved to Dropbox, FTP accounts or emailed
	</UL>
	

	<?php

}

function xmbackup_addoption()
{
	if (function_exists('add_options_page')) 
	{
		add_options_page('XM Backup', 'XM Backup', 0, basename(__FILE__), 'xmbackup_options');
    	}	
}

add_action('admin_menu', 'xmbackup_addoption');

?>
