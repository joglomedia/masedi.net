<?php
/*
Plugin Name: Simple Spoiler Enhanced
Plugin URI: http://liberitas.com/2006/04/18/mi-plugin-simple-spoiler-enhanced/
Description: Add show/hide text enclosed within <spoiler></spoiler> or [spoiler][/spoiler] with a link. Original idea by <a href="http://www.waikay.net">Leong Wai Kay</a>.
Version: 1.6.2
Author: ]V[orlock Zernebock
Author URI: http://liberitas.com

Features:
  Displays a simple link instead of a button.
  Less code per tag use.
  Supports multiple spoiler tags on the same page.

Installation: Place this file in your plugins directory and activate it in your admin panel.
Usuage: Enclose spoiler text between <spoiler> </spoiler> or or [spoiler][/spoiler] in either blog entries or comments.

Change log:
1.6.2 - Added 'php' at the beggining of the file (no idea why it wasn't present).

1.6.1 - Modified yk_callback function to make it XHTML 1.0 compatible.

1.6 - Added the new [] syntax to make the plugin compatible with WYSIWYG editor.
	  [spoiler /show text/ /hide text/] :: show text and hide text will be used as the link.
	  [spoiler /tag/] :: tag will be used as the hide tag.
	  [spoiler]	:: the defaults as defined in the variables will be used.

1.5 - Made the show and hide text into a variable for intiutive editing
    - Added new syntax
      <spoiler 'show text' 'hide text'> :: show text and hide text will be used as the link.
      <spoiler 'tag'> :: tag will be used as the hide tag.
      <spoiler> :: the defaults as defined in the variables will be used.

1.4 - Added some newlines to output code so it will be XHTML valid when used with the Markdown plugin

1.3 - Multiple spoiler works within a single post. However wp formatting might make it XHTML invalid

1.2 - XHTML 1.0 Transitional Compliant

1.1 - Spelling error add_filrer fixed.
    - Does not reposition page when link is clicked.

1.0 - Initial release.

*/

// add filter hook
add_filter('the_content', 'yk_spoiler', 2);
add_filter('the_content', 'yk_spoiler2', 2);
add_filter('comment_text', 'yk_spoiler', 4);
add_filter('comment_text', 'yk_spoiler2', 4);

function yk_spoiler($content)
{
  srand((double) microtime()*100000);
  return preg_replace_callback(
    "%<spoiler.*(?:'([^']*)')?\s*(?:'([^']*)')?\s*>(.*)</spoiler>%isU",
    "yk_callback",
    $content);
} 

function yk_spoiler2($content)
{
  srand((double) microtime()*100000);
  return preg_replace_callback(
    "%\[spoiler.*(?:/([^'/]*)/)?\s*(?:/([^'/]*)/)?\s*\](.*)\[/spoiler\]%isU",
    "yk_callback",
    $content);
}

function yk_callback($m)
{
  // show and hide text
  $spoiler_show_text = ($m[1] ? $m[1]." &#9660;" : "Show &#9660;");
  $spoiler_hide_text = ($m[2] ? $m[2]." &#9650;" : "Hide &#9650;");
  $rand = "SID".rand();
  return "<a href=\"javascript:void(null);\" onclick=\"s_toggleDisplay(document.getElementById('".$rand."'), this, '$spoiler_show_text', '$spoiler_hide_text');\">$spoiler_show_text</a>\n<div id='$rand' style='display:none;'>\n".
    $m[3]."\n</div>";
}

function add_spoiler_header($text)
{
  echo "
    <script type='text/javascript' language='Javascript'>
      function s_toggleDisplay(his, me, show, hide) {
        if (his.style.display != 'none') {
          his.style.display = 'none';
          me.innerHTML = show;
        } else {
          his.style.display = 'block';
          me.innerHTML = hide;
        }
      }
      </script>";
  return $text;
}

add_action('wp_head', 'add_spoiler_header');
?>