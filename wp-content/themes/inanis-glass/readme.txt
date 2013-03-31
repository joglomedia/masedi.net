Inanis Glass Notes and Errata

The following are a list of tips, tricks, notes and hints about the Inanis
Glass WordPress Theme. More stuff will find it's way here as relevant.

Credits
  Assembled by Inanis <http://www.inanis.net>.
  Translation assistance from Zarek Jenkinson <http://zarek.net84.net/>.
  German (de_DE) by Zarek Jenkinson <http://zarek.net84.net/>.
  Dutch (nl_NL) by Adri Huizing <adri at adrihuizing dot nl>
  Polish (pl_PL) by Artur Szulc <szulcu at gmail dot com>
  Brazilian Portugese (pt_BR) by Rubem Neco <rubemneco at hotmail dot com>
  Turkish (tr_TR) by <winxpfe at hotmail dot com>
  Argentinian Spanish (es_AR) by Soctimer < soctimer at gmail dot com>
  Korean (ko_KR) by Jong-In Kim <soulofpure at hotmail dot com>
  XSS Bug in versions 1.2 and prior found and correction suggested by Soroush Dalili <http://Soroush.SecProject.com>

Changes/Fixes
  Version 1.3.5
    # [ADDED] – Create a “No Fixed Center Column” page template for those who have said need.
    # [DONE] – Add ability to have center column posts have fluid width (redesign graphics and entire “post container” layout)
    # [OKAY] - Check for issues in Internet Explorer 8
    # [DONE] – Allow for 24 hour time variable in useroptions.php to set 24 hour time on post display, too (both in top right and status area)
    # [DONE] – Edit link at top of pages/posts is not translated properly
    # [DONE] – If “Navigation” bar does not contain links, do not display it.
    # [DONE] – Remove unneeded “Plugins” and “attachment” templates
    # [DONE *requires re-translation by contributors*] – Translations Missed: “comments off” on the footer of the post when you do a search and “Please note: Comment moderation is enabled and may delay your comment. There is no need to resubmit your comment.”  When comment moderation is enabled. (thanks to Rubem)
    # [OKAY] - Blog “counter” counts all of the spam messages as well, and shouldn’t.
    # [DONE] – Add support for paginated pages/posts [add <?php wp_link_pages(); ?> after the $content = apply_filters('the_content', $content); echo $content; and/or in the nav bar]
    # [FIXED] – Search Widget flows outside it’s container.
    # [FIXED] – “easy-adsenser” ads don’t display on pages other than front page.
    # [FIXED] – image pages show stuff on sidebar that they shouldn’t? (rss feeds, links to comments…)
    # [REMOVED] – Fluid center column templates suck – horribly broken on IE8.

  Version 1.3
    # [FIXED] - XSS vulnerability fixed and other security measures taken.
    # [FIXED] - Logout button does not work in WordPress 2.7 (now checks for version and gives right logout button)
    # [FIXED] - Check IFrame positioning for Firefox2/Win - Seems Okay.
    # [FIXED] - Sidebar reported not to work in FF 3.1 - Broken Graphic
    # [FIXED] - WP2.7 only - using $MenuOption = 2 doesn’t work correctly on the home page: the taskbar is empty.  It does, however, work on archive pages.
    # [ADDED] - Make Clock 24hr time compatible via option
    # [ADDED] - Lighten up the color of the text on the sidebar - hard to read?
    # [ADDED] - Add Parent Name to page/cat-button hovers and show a different popup for those with no children?
    # [ADDED] - Check comments features for 2.7 - 2.7 Threaded Comments features in place.
    # [FIXED] - page not found code in index.php not working properly - 404.php created to catch this.
    # [FIXED] - Pages Widget: if you are on a specific page, the widget shows Inanis Glass Taskbar background under the link.
    # [ADDED] - Multiple Language Support

  Version 1.2
    # [FIXED] - Taskbar and hovers float UNDER Flash on some circumstances. 
    # [FIXED] - If blog has no Blog Title set in the settings, the banner bubble can have a nasty separation problem.
    # [FIXED] - User Info flyout shows dead information if not logged in.
    # [FIXED] - Change the way the LI hovers work on the sidebar. (no Graphics?)
    # [FIXED] - Fix a bug where an error occurs if the blog has no pages. (Line 216 bug)
    # [FIXED] - If you have an item marked “no comments”, then the “leave a comment” screen will still show up.
    # [FIXED] - Fix the Categories menu on OM for when there are multiple category children.
    # [FIXED] - Categories menu on OM has a width problem, causing it to overrun the containing DIV
    # [FIXED] - change vertical bar to bullet on Page template. [Email | Permalink]
    # [FIXED] - Changed the way onload event is handled by functions.js
    # [ADDED] - Option to show QuickLaunch buttons
    # [ADDED] - Option to turn off the child page popups.
    # [ADDED] - Option to show Categories instead of Pages at bottom
    # [ADDED] - Allow setting of default theme in an easier manner.
    # [ADDED] - Have the Theme Menu show which theme is this blogs default.
    # [ADDED] - Option to Show “roll off” pages with a button at the right of the taskbar: blogs with LOTS of pages can still have all pages listed.
    # [ADDED] - Option to show/not show disclaimer and change disclaimer text.
    # [ADDED] - Scroll feature on post content window in case it’s too wide for the frame.
    # [DONE] - Optimize “offscreen” placement of pagelink hovers.
    # [DONE] - Re-Optimize graphics, CSS and HTML for size (shaved about 50k using PNGMonster)

  Version 1.1.01
    # [FIXED] - Use of self-referenced arrays causes issues on hosts using PHP4 or earlier.
    # [ADDED] - Optimized Javascript code a little.

  Version 1.1 
    # [ADDED] - Better IE6 support.
    # [ADDED] - Style text elements (blockquote, pre, code, etc.)
    # [ADDED] - make page children pop above taskbar buttons (think “Taskbar Preview”)
    # [ADDED] - Better description of theme/features for next WordPress Extend posting.
    # [ADDED] - Add a Readme File to the theme, and urge people to read it first.
    # [ADDED] - ability to click on post title and go to full post
    # [ADDED] - Add “last edited date” on post footer
    # [ADDED] - make the “Change Theme” options more apparent/obvious
    # [ADDED] - Support for the “wrapper” element id.
    # [FIXED] - Sidebar glitch with UL in Lightweight theme.
    # [FIXED] - “About This Post” links don’t all work.
    # [FIXED] - Proper, complete and final fix for the “clear:both” bug.
    
  Version 1.0.01
      # Initial Release

Notes
  1. Theme is Bandwidth Heavy
    I know. It's emulating a well known GUI from a neat looking operating
    system, also known for it's heaviness. What did you expect? :) If this is
    really a problem for you, either don't use the theme or take a look below
    at "Tips and Tricks" to find out how to force the default sub-theme to
    be the "Lightweight" theme.
    
  2. Some things aren't in the right place
    I know, I may have bucked WordPress theme tradition and placed things in
    weird places, or changed the way some "holy" things display information, 
    but I disagreed with the way they were doing things, and I'm not one to
    follow the rules if the rules are stupid. If you disagree, feel free to 
    modify the theme to your liking.
  
Tips and Tricks
  1. User Changed Sub-Themes
    Don't forget, there are multiple Sub-Themes, not just the default black/blue
    "Void" theme. If your viewers change this theme, that change only appears
    for them, and reappears each time they visit, that is if they allow cookies.
    
  2. User Options
  By editing useroptions.php using the Theme Editor, you can make some really cool
  modifications to the theme. Here's the rundown:
    # Option to Display Pages or Categories along TaskBar
    # Option to show/not show Child Page/Category Popups
    # Option to set the default sub-theme.
    # Option to give visitors a random theme on first visit
    # Option to show QuickLaunch area. See useroptions.php for more info.
    # Option to "Roll Off" the Task Bar buttons if you have too many pages to fit.
    # Option to change clock to 24 hour (military) format
      
    