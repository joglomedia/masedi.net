=== XM-Backup ===
Contributors: Xavier Media
Tags: Backup, database, files, Dropbox, FTP, email, Online File Folder, Online Storage
Requires at least: 2.7.0
Tested up to: 3.3.2
Stable tag: 0.9.1

Does a backup of your Wordpress database and, or your files in wp-content/uploads and saves it in a safe location.

== Description ==

This plugin will do a backup of your Wordpress database and, or your files in wp-content/uploads and saves
it somewhere safe. You can have the backup saved in your [Dropbox account](http://db.tt/9Jo39Xy), a FTP account of your choise, your
account with [Online File Folder](http://www.securepaynet.net/email/online-file-storage.aspx?ci=1796&amp;prog_id=xaviermedia&amp;isc=xmbackup), or have the backup emailed to you (not recommended for large files). You can 
select to have the backups named the same every day or to have a date added to each file name.

This plugin requires PHP, cURL, PHP compiled with ZIP support, and Oauth (for Dropbox).

** NO WARRANTY SUPPLIED! ** 

** Make sure you test your Backups! **

== Installation ==

1. Upload `xm-backup/xm-backup.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the 'XM-Backup' menu option under 'Settings' to specify the the backup options like where the backup should 
be saved, which files to backup and if it should be done on an automated basis.

== Frequently Asked Questions ==

= The backups aren't emailed to me? =

Switch to FTP delivery instead of using the email option. FTP is the best way to deliver large files and the 
email options should really only be used for small new blogs, or if you ONLY backup a small Wordpress database
(less than 1 Mb in size).

= I get errors creating the ZIP file? =

You need of course to have PHP compiled with ZIP. Ask your web hoting provider to compile PHP with ZIP for you
or check out this blog post from [Xavier Media&reg;](http://www.xaviermedia.com/webbing/) where it's showed how you can do it on your own server using
cPanel.

= I get maximum memory allocated error! Why? =

You have too little memory in your server to do a backup of that many/large files. This is usually a problem for people
hosting on a shared hosting account where the hosting company is using a cheap server with little memory. Select fewer 
files to backup, or switch to only backup the database.

= My mailbox gets full! =

Yes, this is a problem if you have large files emailed to you. Try cleaning up the old backups, or switch to FTP
delivery of the backups.

= How can I suggest a new feature or report a bug? =

Visit our support forum at http://www.xavierforum.com/php-&-cgi-scripts-f3.html

== Changelog ==

= 0.9.1 =
* Updated Online File Folder to Online Storage

= 0.9.0 =
* The first version

== Upgrade Notice ==

= 0.9.0 =
* The first version

`<?php code(); // goes in backticks ?>`