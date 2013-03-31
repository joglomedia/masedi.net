=== Blogroll Links Page  ===Contributors: mrallen1Tags: blogroll, links, seoRequires at least: 2.0.2Tested up to: 2.3Stable tag: 2.1Outputs your blogroll links organized by categories into a post or page.== Description ==Outputs your blogroll links as a page or a post. Add the text `<!--blogroll-page-->` to a page or post and it will output your blogroll links organized by category heading. 

In v2.1, two additional configuration options are available from the options page.  These are:

* Suppress the category display. You may find this useful if you want to move your links to their own page, but you the blogroll categories at your site aren't meaningful to visitors (or search engines.)

* Change the display order of links. You can choose a primary and secondary order. Options here include Link ID (this id is internal the wordpress database and generally corresponds to the order the link was added into wordpress), Name (alphabetical), Address (the site URL), or rating.

N.B.: This plugin doesn't deal well with categories with parent links. 

It's based heavily on Dominic Foster's original plugin which no longer works as of WordPress 2.3. [The original plugin is available here.](http://www.websitehostingiq.net/blogroll-page-plugin/)== Installation ==1. Download the archive file and uncompress it.2. Choose the appropriate version, and plop it in wp-content/plugins3. Enable in WordPress by visiting the "Plugin" menu and activating it.

This file contains two plugins, one for use with Wordpress 2.3 and one for use with WordPress 2.0.x-2.2.x (labeled as "wp22.") Don't use the 2.3 version on 2.0-2.2 installations - it's not catastrophic but
it won't work at all. (Same goes for the 2.2 version on a 2.3 installation.)
== Important Note ==For a fancier version of the same plugin, check out [Rajiv Pant's version.](http://wordpress.org/extend/plugins/blogroll-links)

== Changes ==

* 2.1 - Incorporated additional configuration options using a patch supplied by Mark A. Belcher.

* 2.0 - Initial release
== License ==
Copyright (C) 2007 Dominic Foster

Copyright (C) 2008 Mark R. Allen

All rights reserved.

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.