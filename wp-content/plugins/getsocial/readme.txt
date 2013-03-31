=== GetSocial ===
Contributors: riyaznet
Donate link: http://www.riyaz.net/
Tags: social, social media,  social networks, social media sharing, social bookmarking, twitter, official twitter tweet button, new tweet button, retweet, facebook, google +1, google plus one, google plusone, buffer, bufferapp, pinterest, linkedin, stumbleupon, digg, floating sharebox, floating buttons, social media sharing buttons, sharebox, sharebar
Requires at least: 3.5
Tested up to: 3.5.1
Stable tag: trunk

GetSocial adds an intelligent, lightweight, quick to setup floating social media sharing box on your blog posts.

== Description ==

GetSocial adds a lightweight and intelligent floating social media sharing box on your blog posts.

**Features:**

*   Floating social share box compatible with leading web browsers
*   Out-of-the-box functionality like 
	- Twitter Tweet Button
	- Facebook Like and Send button
	- Google +1 Button
	- Buffer Button
	- Pinterest Button
	- LinkedIn Button
	- Stumbleupon Submit button
	- Digg Submit button
	- Your Own Button
*   Easily add any number of additional social media sharing buttons
*   Re-order buttons with simple drag-and-drop
*   Hide individual share counts if desired
*   Resize GetSocial share bar width (useful for non-English blogs)
*   Always visible and accessible even if the user scrolls down the page
*   Auto-adjusts itself to all screen resolutions and window sizes
*   Automatically hides itself partially to the left of the screen if window is resized to smaller than defined width
*   Hovering over a partially hidden GetSocial box displays the full box
*   For higher screen resolutions, displays full by default
*   Easy-to-use Color Picker to customize the look and feel to match your blog theme
*   Lightweight plugin with minimal settings
*   Scripts are loaded in footer to improve page-load time

Be sure to check out: [Social Metrics](http://wordpress.org/extend/plugins/social-metrics/ "Social Metrics Plugin") - Helps you track how your posts are shared in the social media.

== Installation ==

Upload the Getsocial plugin folder to your plugins directory, activate it and it should work out of the box. Detailed instructions follow:

1. Extract and upload the 'getsocial' folder to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to GetSocial Settings page and adjust the options as described there.
4. Review and Save Changes.
5. GetSocial box will now appear on all blog posts.

== Frequently Asked Questions ==

= How to add additional social media sharing buttons to the GetSocial box? =

Simply add the HTML code for the additional buttons under the 'Additional buttons' options in the settings page.
Enclose each button within `<div class="sharebutton">` and `</div>` tags. For example:

`<div class="sharebutton">`
`   <!-- Code for additional button 1 -->`
`</div> `

`<div class="sharebutton">`
`   <!-- Code for additional button 2 -->`
`</div> `

= Nothing happens when I hover over partially hidden GetSocial box. What should I do? =
Set the Browser Width option in the GetSocial settings page to suit the maximum width of your theme. For example, if your theme's width is 1000px, you may set the browser width to 1140px (1000 + 140) or slighly higher. Try out different values of browser width and set the one that gives desired behaviour.

= I have activated the GetSocial plugin but the GetSocial box does not show up. What could be wrong? =
Make sure that you have selected the desired Display options on the GetSocial Settings page and saved the changes. 
If the GetSocial box still does not appear, it could be because your theme does not use the standard WordPress function wp_footer(). You can try one of the following options:

Add following code to your theme's template (possibly in footer.php) just before the `</body>` tag:

<code>&lt;?php wp_footer(); ?&gt;</code>
OR
Add following code to footer.php just before the `</body>` tag:

<code>&lt;?php </code>
<code>if (function_exists('add_getsocial_scripts')) {</code>
<code>	add_getsocial_scripts();</code>
<code>	if (function_exists('add_getsocial_box')) {</code>
<code>		add_getsocial_box();</code>
<code>	}</code>
<code>}</code>
<code>?&gt;</code>

= How do I add the email and more buttons from Addthis.com? =
Please refer to [How to Customize GetSocial with CSS3 Buttons](http://www.riyaz.net/blog/customize-getsocial-with-css3/wordpress/1677/ "How to Customize GetSocial with CSS3 Buttons").

= Where can I report a bug or submit feature requests? =
Please reach me through [Contact Options](http://www.riyaz.net/contact/ "Contact riyaz.net").

== Screenshots ==
1. GetSocial plugin in action (Default Behaviour).
2. When user scrolls down, GetSocial is displayed at the top-left corner of the browser window.
3. Smartly hides partially to the left on resizing the window or if the screen resolution is small.
4. Hovering over a hidden GetSocial box will display the full box.

== Changelog ==
= 1.7.5 =
* Fixed issue with Facebook share button not displying properly intermittently on some browsers.

= 1.7.4 =
* Fixed compatibility issues with older versions of Premise plugin
* Standardized jQuery inclusion on admin pages using wp_enqueue_script
* Pinterest button will now use a default image if no image was attached
* Corrected textarea behavior which affected some themes

= 1.7.3 =
* Fixed: Pinterest button had issue with picking up images. Pin it button now picks up featured image on the post. If there is no featured image, first image on the post will be used. Pin it button will silently hide itself if no image could be found.

= 1.7.2 =
* Updated Facebook button to support send button and option to post to Facebook after like

= 1.7.1 =
* Updated Pinterest button code with changed requirements

= 1.7 =
* Added out-of-the-box support for Pinterest, LlinkedIn and Buffer App
* Discontinued support for TweetMeme and Blend
* Improved and user-friendly settings page
* Added ability to re-order buttons with simple drag-and-drop
* Added option to resize GetSocial share bar width (useful for non-English blogs)
* Added option to display GetSocial on homepage
* Added options to hide individual share counts wherever possible
* Added options to show rounded corners
* Options to align or hide the share title

= 1.6 =
* Quick Fix: The post URL could not be retrieved correctly in some themes. This update fixes the issue.

= 1.5 =
* Upgrade recommended
* Added Facebook Like Button as Facebook Share Button will soon be deprecated

= 1.4 =
* Added out-of-the-box option to display Google +1 Button
* Added options to change colors of the GetSocial box. 
* Added easy-to-use Color Picker to allow users can quickly customize GetSocial box colors to suit their blog theme

= 1.3.1 =
* Fixed: Permalink issue for some themes
* Fixed: Issue with anchor tags when the scripts are explicitely loaded in header

= 1.3 =
* New Tweet Button from Twitter is now supported in getSocial. Users can also use the existing Tweetmeme retweet button if desired.
* Added options to load scripts in header. Some themes dont use wp_footer function by default due to which the GetSocial box does not appear. Loading scripts in header fixes this issue.
* Fixed: Some users using themes with custom post mets reported fatal error during activation. This has been fixed in this release by renaming some functions.

= 1.2 =
* Added functionality to add GetSocial box on pages
* Added Out-of-the-box functionality for Digg and Blend buttons
* Updated FAQs

= 1.1 =
* Fixed: Some themes do not use JQuery, so plugin does not show up by default. Now, if the JQuery library isn't already loaded, it will be loaded during initialization and hence render the plugin correctly.

= 1.0 =
* First Release.

== Upgrade Notice ==

* Upgrade to version 1.7 for improved functionality and benefits.
