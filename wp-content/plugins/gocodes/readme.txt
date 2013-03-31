=== GoCodes ===
Contributors: redwall_hp
Plugin URI: http://www.webmaster-source.com/gocodes-redirection-plugin-wordpress/
Author URI: http://www.webmaster-source.com
Donate link: http://www.webmaster-source.com/donate/
Tags: redirection, tinyurl, 301, url shortener, url
Requires at least: 2.4
Tested up to: 2.8
Stable tag: 1.3.4

An URL redirection/shortener plugin. Great for podcasting and redirecting affiliate program URLs.


== Description ==

Have you ever had to give someone a shortened version of a URL? Maybe you're a podcaster, and you can't say "visit mydomain.com/2008/01/03/my-post-with-a-long-url/ for more info." Wouldn't it be useful if you could just say "go to mydomain.com/go/mycoolpost/ ?" Sure, you *could* use a service like tinyurl.com, but that's still not too great if you need the URL for a podcast. It's still awkward to read-out "tinyurl.com/27asr9," isn't it? It's less professional too. GoCodes let's you create shortcut URLs to anywhere on the internet, right from your Wordpress Admin. The plugin is also useful for masking affiliate program URLs.


== Installation ==

1. FTP the entire gocodes directory to your Wordpress blog's plugins folder (/wp-content/plugins/).

2. Activate the plugin on the "Plugins" tab of the administration panel.

3. Refer to the usage section of this guide.


== Upgrading ==
1. Deactivate plugin
2. Upload updated files
3. Reactivate plugin

Upgrade notes:
*  You may use the autmoated plugin updater in WordPress 2.5+ with this plugin, but make sure you read the upgrade notes of the latest version after upgrading.
*  If you are upgrading from GoCodes 1.1.1 or prior, remove the gocodes.php file, and upload the new gocodes directory. To ensure compatibility with WordPress 2.5, some changes were made that expect gocodes.php to reside in a /gocodes subdirectory
* If you are upgrading from a version prior to 1.2.1, you must update your .htaccess file again. Change the line `RewriteRule ^go/([A-Za-z0-9]+)/?$ /index.php?gocode=$1 [L,R]` to `RewriteRule ^go/([a-zA-Z0-9_-]*)/?$ /index.php?gocode=$1 [L,R]`.
* If you are upgrading from a version prior to 1.3.0, it is recommended that you remove the old .htaccess lines as they are no longer required, and may interfere with some functionality.



== Frequently Asked Questions ==

= How do I add a redirect? =
To manage your redirects, open your Wordpress admin, and go to the Manage -> GoCodes menu. From there you can remove redirects by clicking on the "Delete" button next to their entries, and you can add new ones using the form on the page. The "Key" field is where you enter the redirection string (e.g. "orange" in yourdomain.com/go/orange/). The URL field is where you enter the URL that users will be redirected to ("http://" is required). Note that the Key can only contain alphanumeric characters.

= Are the redirects search engine friendly? =
As of version 1.2.7, yes. 301 header redirects are used, as opposed to 302 redirects. This ensures that search engines will not rank the GoCode URL, and move on to the target URL, thus preventing duplicate content problems.

= I often create redirects to sites that I don't particularly trust. Can I automatically nofollow the redirects? =
Go to the GoCodes Settings page (Settings -> GoCodes) and tick the Nofollow checkbox. This will instruct GoCodes to send a "noindex, nofollow" message to search engines accessing a redirect.


== Screenshots ==
1. The GoCodes redirect management page in the WordPress Admin.


== Known Issues ==

= WP Super Cache =
There seems to be a conflict with the WP Super Cache plugin where a redirect will only work once before the cache is cleared. There are a couple of workarounds:

1. Add "index.php" on a new line in the "Rejected URLs" field of the WP Super Cache options page. yourdomain.com/ will be cached still, but /index.php won't.
2. Frederick of frederickding.com put together another method. Add this line to your .htaccess file above the WP Super Cache line: "RewriteCond %{QUERY_STRING} !.*gocode=.*" It should look something like this:

RewriteCond %{QUERY_STRING} !.*gocode=.*
RewriteRule ^(.*) /wp-content/cache/supercache/%{HTTP_HOST}/$1/index.html [L]


== Version history ==
* Version 1.0
* Version 1.1 - Adds hit count and uninstaller
* Version 1.1.1
* Version 1.2 - Ensures total WordPress 2.5 compatibility, adds the ability to edit redirect entries and reset hit counts. Some interface improvements introduced as well.
* Version 1.2.1 - Adds support for dashes and underscores in redirection keys. See upgrade notes if you are upgrading from an older version.
* Version 1.2.7 - 301 redirects are now used instead of 302. Some UI improvements, and a minor .htaccess change (thanks Terriann!).
* Version 1.3.0 - Automatically nofollow redirects, replace the `/go/` with your own text, sort the Manage GoCodes table, .htaccess is no longer required.
* Version 1.3.3 - Hopefully the PHP4 bug in the 1.3.x line has been fixed, finally.