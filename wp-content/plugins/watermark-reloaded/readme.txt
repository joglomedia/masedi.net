=== Watermark RELOADED ===
Contributors: sverde1
Donate link: http://eappz.eu/en/donate/
Tags: watermark, images, pictures, text watermark, image watermark, watermark reloaded, upload, Post, admin
Requires at least: 3.0
Tested up to: 3.5.1
Stable tag: 1.3.2

Add watermark to your uploaded images and customize your watermark appearance on a user friendly settings page.

== Description ==

This plugin allows you to watermark your uploaded images. You can create watermark with different fonts and apply
it to different image sizes (thumbnail, medium, large, fullsize) and positioning the watermark anywhere on the image.

<a href="http://eappz.eu/en/products/watermark-reloaded-pro/">**Upgrade to Watermark RELOADED Pro**</a> for more
watermarking features:

* watermark opacity
* image watermark
* watermark background color
* text watermark with outline
* text watermark with variables
* upload time option to turn off the watermarking
* many more amazing features

Requirements:

* PHP5
* GD extension for PHP
* FreeType Library

To-do:

* Watermark RELOADED Bug fixing (request by: all)
* Don't display watermark on images where watermark would overflow image (request by: alex)
* Watermark aditional image sizes added by other plugins (request by: twincascos)
* Watermark images that were uploaded before plugin was installed (request by: anchy-9, Blogging Junction, Ashkir, Mobile Ground, Nicolas)
* Image size aware watermark (request by: brohism)
* Watermark outside picture

== Installation ==

1. Upload `watermark-reloaded/` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to Watermark RELOADED settings and enable watermark on desired image sizes

You can upload additional fonts to `/wp-content/plugins/watermark-reloaded/fonts/` folder.

== Frequently Asked Questions ==

= Plugin doesn't work ... =

Please specify debug information like:

 * screenshot of Watermark RELOADED settings
 * any error message output (also check in php error.log file)
 * output of your phpinfo()

= Error message says that I don't have GD extension installed =

Contact your hosting provider and ask them to enable GD extension for your host, because without GD extension you
won't be able to watermark your images.

= Error message says that I don't have FreeType Library =

Contact your hosting provider and ask them to install FreeType Library on your host, without it you won't be able
to make text watermarks.

= Is there any way to watermark previously uploaded images? =

No there's no way to watermark previously uploaded images. I plan to implement this feature in
<a href="http://eappz.eu/en/products/watermark-reloaded-pro/">Watermark RELOADED Pro</a>.

== Screenshots ==

1. Screenshot of Watermark RELOADED settings page
2. Example of a picture watermarked with above settings
3. Teaser screenshot of Watermark RELOADED Pro settings page

== Changelog ==

= 1.0 =
* Initial release

= 1.0.1 =
* Fixed plugin URI
* Added some more fonts

= 1.0.2 =
* Added PHP 5 dependency check
* Added GD extension dependency check
* Added FreeType Library dependency check
* Rewritten error messages output
* Added donations link

= 1.2 =
* Added color picker for changing text watermark color
* Added watermark preview
* Added a little bit of a nagging for donation :)

= 1.2.1 =
* Fixed unicode chars bug

= 1.2.2 =
* Fixed "Enable watermark for" checkboxes save bug

= 1.2.3 = 
* Fixed "Could not find font" bug
* Updated donation nagging functionality

= 1.2.4 =
* Added auto-patch for font bug fixed in previous version

= 1.2.5 =
* Bugfix on upgrade to Wordpress 3.0

= 1.3 =
* Bugfixes and compatibility fixes

= 1.3.1 =
* Some bugfixes
* Plugin options page credentials update
* Added dashboard with current watermark settings and preview display

= 1.3.2 =
* Added file type check, because we need to process only image files
