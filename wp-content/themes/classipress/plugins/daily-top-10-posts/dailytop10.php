<?php
/*
Plugin Name: Daily Top 10 Posts
Plugin URI: http://www.alleba.com/blog/2007/03/27/wordpress-plugin-daily-top-10-posts/
Description: Tracks the number of pageviews per blog post for the current day and cumulatively with options to display sidebar widgets for both.  Features dashboard widgets too.
Author: Andrew dela Serna
Author URI: http://www.alleba.com/blog/
Version: 0.6

  Copyright 2007 Andrew dela Serna (email andrew@alleba.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

INSTALLATION
------------
1. Download the plugin from http://www.alleba.com/blog/wp-downloads/dailytop10.zip
2. Extract and upload dailytop10.php to 'yourserver.com/wp-content/plugins/'
3. Login to your Wordpress admin panel and browse to the Plugins section.
4. Activate The Daily Top 10 Posts plugin.

INSTRUCTIONS
------------
1. Go to Admin Panel > Design > Theme Editor and click on Single Post (single.php).

	 #Find this line:
		
		<?php the_time('F jS, Y') ?> //date
		
	 #Right after it, insert this line:
		<br /><?php if (function_exists('todays_overall_count')) { todays_overall_count($post->ID, 'Visited', 'times', 'so far today', '0', 'show'); } ?>
		
   #The line will display something like "Visited 300 times, 25 so far today" while viewing an individual post.
   #You may edit the wording to suit your preference.
   #If you wish to leave a word/phrase empty, use two quotes '' instead of just leaving it completely blank.
   #Insert only one instance of this line to avoid double tracking.
   #Change '0' to '1' if you wish to track unique sessions.
   #Change 'show' to 'noshow' if you donot wish to display the post count information.

2. To display the number of views per post on the main index page, click on Main Index Template (index.php) in the Theme Editor panel.

   #Find this line:
   
    <?php the_time('F jS, Y') ?>
   
   #Right after it, insert this line:
		
		<br /><?php if (function_exists('todays_overall_main')) { todays_overall_main($post->ID, 'Viewed', 'times', 'so far today'); } ?>
	 
	 #The line will display something like "Visited 300 times, 25 so far today" under each post heading 
	 #while browsing your main page.
   #You may edit the wording to suit your preference.
   #If you wish to leave a word/phrase empty, use two quotes '' instead of just leaving it completely blank.
   
3. To add the sidebar widget, you may add it directly in the widgets panel of your theme (Design > Widgets).  If your theme is not widget-ready, click on sidebar.php in the Theme Editor panel and do the following:

	 #Add the following code:
	 
	  <h3>Top Posts for Today</h3>
    <?php if (function_exists('todays_count_widget')) { todays_count_widget('views', 'ul'); }?>
    
   #You may edit the word "views" to your liking (e.g. visits, pageviews or leave it empty '').
   #The list format defaults to an unordered list (ul).  If you would like an ordered list, change it to 'ol'.

4. To add the sidebar widget to show your most popular posts overall, you may add it directly in the widgets panel of your theme (Design > Widgets).  If your theme is not widget-ready, click on sidebar.php in the Theme Editor panel and do the following:
	 #Add the following code:
	 
	  <h3>Overall Top Posts</h3>
    <?php if (function_exists('todays_overall_count_widget')) { todays_overall_count_widget('views', 'ul'); } ?>
    
   #You may edit the word "views" to your liking (e.g. visits, pageviews or leave it empty '').
   #The list format defaults to an unordered list (ul).  If you would like an ordered list, change it to 'ol'.

CREDITS
-------
1. My family especially Mom and Dad.
2. My nieces Mavis and Maddi who inspire me.
3. My online friends from Avatar.ph, Dotastrategy.com and Plurk.com
*/

#SET NUMBER OF POSTS TO DISPLAY IN SIDEBAR WIDGETS.  Defaults to 10.
$SIDEBAR_WIDGET_COUNT = 10;
#SET NUMBER OF POSTS TO DISPLAY IN ADMIN WIDGET.  Defaults to 10.
$ADMIN_WIDGET_COUNT = 10;
#SET TIMEZONE OFFSET (UTC/GMT).  To know your timezone, visit http://www.timeanddate.com/worldclock/ and click on the appropriate city.  If you live in the Philippines, the offset is +8.
$OFFSET = 0;
#If you wish not to offset the date in which post views are recorded, leave it as is (0).

add_action('init', 'jal_install');

$table_name = $wpdb->prefix . "dailytopten";
$table_name_all = $wpdb->prefix . "dailytoptenall";
$table_posts = $wpdb->prefix . "posts";

function jal_install () {
   global $wpdb;
   global $table_name;
   global $table_name_all;
   
   if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
   	$sql = "CREATE TABLE " . $table_name . " (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  time date DEFAULT '0000-00-00' NOT NULL,
	  postnum int NOT NULL,
	  postcount int DEFAULT '0' NOT NULL,
	  UNIQUE KEY id (id)
	  )
	;";
	
	require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
      dbDelta($sql);
  }
    if($wpdb->get_var("SHOW TABLES LIKE '$table_name_all'") != $table_name_all) {
   	$sqall = "CREATE TABLE " . $table_name_all . " (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  postnum int NOT NULL,
	  postcount int DEFAULT '0' NOT NULL,
	  UNIQUE KEY id (id)
	  )
	;";
	require_once(ABSPATH . 'wp-admin/upgrade-functions.php');
      dbDelta($sqall);
   }
  }
function todays_date()
{
    global $OFFSET;
    $format = "Y-m-d";
    if ($offset) {
    $nowtime = gmdate($format, time() + 3600*$OFFSET);
    } else {
    $nowtime = date($format, time());
    }
    return $nowtime;
}
function has_viewed($postno, $all) {
	if ($all == 1) {
	$temp = explode("&", $_SESSION["a"]);
        if(!in_array($postno, $temp)){
        $_SESSION["a"] .= $postno."&";
        return 0;
        } else {
        return 1;	
   }
  } 
   else if ($all == 2) {
   $temp = explode("&", $_SESSION["n"]);
        if(!in_array($postno, $temp)){
        $_SESSION["n"] .= $postno."&";
        return 0;
        } else {
        return 1;
    }
   }
  }
  
function todays_count($postnum, $unique) {
	global $wpdb;
	global $table_name;
	if ($unique) {
	$viewed = has_viewed($postnum,2);	
	}
	$nowisnow = todays_date();
	$checkpost = $wpdb->get_row("SELECT id, postnum, time, postcount FROM $table_name WHERE postnum = '$postnum'");
	$postid = $checkpost->id;
	$postnumb = $checkpost->postnum;
	$posttime = $checkpost->time;
	$postcount = $checkpost->postcount;
	if (!$postid) {
	$wpdb->query("INSERT INTO $table_name (time, postnum, postcount) VALUES ('$nowisnow', $postnum, 1)");
	}
	else if ($posttime == $nowisnow) {
	if (!$viewed) {
	$wpdb->query("UPDATE $table_name SET postcount = postcount+1, time = '$nowisnow'	WHERE postnum = '$postnum'");
   }
	}
	else {
	if (!$viewed) {
	$wpdb->query("UPDATE $table_name SET postcount = 1, time = '$nowisnow'	WHERE postnum = '$postnum'");
	 }
	}
	$post_c = $wpdb->get_var("SELECT postcount FROM $table_name WHERE postnum = '$postnum'");
	return $post_c;
	}

function todays_count_widget($views,$list) {
	global $wpdb;
	global $table_name;
	global $table_posts;
	global $SIDEBAR_WIDGET_COUNT;
	$home_url = get_settings('home');
	$perma = get_settings('permalink_structure');
	$nowisnow = todays_date();
	$todays_widget_temp = "";
	trim($views)!='' ? ($views = " ".$views) : ($views = "");
	(($SIDEBAR_WIDGET_COUNT) && is_numeric($SIDEBAR_WIDGET_COUNT)) ? $limit = $SIDEBAR_WIDGET_COUNT : $limit = 10;
	((strtolower($list) == 'ul') || (strtolower($list) == 'ol')) ? $list = strtolower($list) : $list = 'ul';
	if ($list == 'ul') {$lbeg = '<ul>'; $lend = '</ul>';} else {$lbeg = '<ol>'; $lend = '</ol>';}
	$todays_widget = $lbeg."\n";;
	$widgets = $wpdb->get_results("SELECT * from $table_name inner join $table_posts on $table_posts.ID=$table_name.postnum WHERE time = '$nowisnow' and postcount > 0 and post_status = 'publish' ORDER BY postcount DESC LIMIT $limit");
	$widgets_num = $wpdb->get_var("SELECT COUNT(*) FROM $table_name inner join $table_posts on $table_posts.ID=$table_name.postnum WHERE time = '$nowisnow' and postcount > 0 and post_status = 'publish'");
	
	if ($widgets_num) {
	foreach ($widgets as $widget) {
	$postnum = $widget->postnum;
	$postcount = $widget->postcount;
  $id_post = $widget->ID;
  $title_post = $widget->post_title;
  if ($perma) {
  $home_url_perma = get_permalink($id_post);
  $todays_widget_temp .= "<li><a href=\"$home_url_perma\">$title_post</a> ($postcount views)</li>\n";
  } else {
  $todays_widget_temp .= "<li><a href=\"$home_url/?p=$id_post\" title=\"$text\">$title_post</a> ($postcount$views)</li>\n";
	  }
	 }
  }
	if (!$todays_widget_temp) {
	$todays_widget_temp .= "<li>No posts viewed yet.</li>";
	}
	$todays_widget .= $todays_widget_temp;
	$todays_widget .= $lend."\n";;
	echo $todays_widget;
  }
  
function todays_overall_main($postnum, $visited, $times, $sofar) {
	global $wpdb;
	global $table_name;
	global $table_name_all;
	$nowisnow = todays_date();
	$show_overall_main= "";
  $post_c = $wpdb->get_var("SELECT postcount FROM $table_name WHERE time = '$nowisnow' AND postnum = '$postnum'");
  $post_d = $wpdb->get_var("SELECT postcount FROM $table_name_all WHERE postnum = '$postnum'");
  if ($post_d>0) {
	$show_overall_main = "$visited $post_d $times";
	if ($post_c) {$show_overall_main .= ", $post_c $sofar";}
  }
	echo $show_overall_main;
	}
	
function todays_overall_count($postnum, $visited, $times, $sofar, $unique, $show) {
	global $wpdb;
	global $table_name_all;
	if ($unique) {
	$viewed = has_viewed($postnum,1);
	}
	$checkpost = $wpdb->get_row("SELECT id, postnum, postcount FROM $table_name_all WHERE postnum = '$postnum'");
	$postid = $checkpost->id;
	$postnumb = $checkpost->postnum;
	$postcount = $checkpost->postcount;
	if (!$postid) {
	$wpdb->query("INSERT INTO $table_name_all (postnum, postcount) VALUES ($postnum, 1)");
	$show_overall = "Visited 1 times";
	$show_today = todays_count($postnum, $unique);
	}
	else {
	if (!$viewed) {
	$wpdb->query("UPDATE $table_name_all SET postcount = postcount+1 WHERE postnum = '$postnum'");
	$postcount_ap = $postcount+1;
  } else {
  $postcount_ap = $postcount;
  }
	$show_today = todays_count($postnum, $unique);
	if ($postcount_ap>0) {
	$show_overall = "$visited $postcount_ap $times";
	if ($show_today) {$show_overall .= ", $show_today $sofar";}
	 }
  }
  if ($show != 'noshow') {
	echo $show_overall;
   }
	}
	
function todays_overall_count_widget($views,$list) {
	global $wpdb;
	global $table_name_all;
	global $table_posts;
	global $SIDEBAR_WIDGET_COUNT;
	$home_url = get_settings('home');
	$perma = get_settings('permalink_structure');
	$nowisnow = todays_date();
	$todays_overall_widget_temp = "";
	trim($views)!='' ? ($views = " ".$views) : ($views = "");
	(($SIDEBAR_WIDGET_COUNT) && is_numeric($SIDEBAR_WIDGET_COUNT)) ? $limit = $SIDEBAR_WIDGET_COUNT : $limit = 10;
	((strtolower($list) == 'ul') || (strtolower($list) == 'ol')) ? $list = strtolower($list) : $list = 'ul';
	if ($list == 'ul') {$lbeg = '<ul>'; $lend = '</ul>';} else {$lbeg = '<ol>'; $lend = '</ol>';}
	$todays_overall_widget = $lbeg."\n";
	$widgets = $wpdb->get_results("SELECT * from $table_name_all inner join $table_posts on $table_posts.ID=$table_name_all.postnum WHERE postcount > 0 and post_status = 'publish' ORDER BY postcount DESC LIMIT $limit");
	$widgets_num = $wpdb->get_var("SELECT COUNT(*) FROM $table_name_all inner join $table_posts on $table_posts.ID=$table_name_all.postnum WHERE postcount > 0 and post_status = 'publish'");
	
	if ($widgets_num) {
	foreach ($widgets as $widget) {
	$postnum = $widget->postnum;
	$postcount = $widget->postcount;
  $id_post = $widget->ID;
  $title_post = $widget->post_title;
  if ($perma) {
  $home_url_perma = get_permalink($id_post);
  $todays_overall_widget_temp .= "<li><a href=\"$home_url_perma\">$title_post</a> ($postcount views)</li>\n";
  } else {
  $todays_overall_widget_temp .= "<li><a href=\"$home_url/?p=$id_post\" title=\"$text\">$title_post</a> ($postcount$views)</li>\n";
	  }
	 }
  }
	if (!$todays_overall_widget_temp) {
	$todays_overall_widget_temp .= "<li>No posts viewed yet.</li>\n";
	}
	$todays_overall_widget .= $todays_overall_widget_temp;
	$todays_overall_widget .= $lend."\n";
	echo $todays_overall_widget;
  }

function admin_todays_count_widget() {
	global $wpdb;
	global $table_name;
	global $table_posts;
	global $ADMIN_WIDGET_COUNT;
	$home_url = get_settings('home');
	$perma = get_settings('permalink_structure');
	$nowisnow = todays_date();
	(($ADMIN_WIDGET_COUNT) && is_numeric($ADMIN_WIDGET_COUNT)) ? $limit = $ADMIN_WIDGET_COUNT : $limit = 10;
	$widgets = $wpdb->get_results("SELECT * FROM $table_name inner join $table_posts on $table_posts.ID=$table_name.postnum WHERE time = '$nowisnow' and postcount > 0 and post_status = 'publish' ORDER BY postcount DESC LIMIT $limit");
	$widgets_num = $wpdb->get_var("SELECT COUNT(*) FROM $table_name inner join $table_posts on $table_posts.ID=$table_name.postnum WHERE time = '$nowisnow' and postcount > 0 and post_status = 'publish'");
	if ($widgets_num) {
	$todays_widget_temp = "<ul>";
	foreach ($widgets as $widget) {
	$postnum = $widget->postnum;
	$postcount = $widget->postcount;
  $id_post = $widget->ID;
  $title_post = $widget->post_title;
  if ($perma) {
  $home_url_perma = get_permalink($id_post);
  $todays_widget_temp .= "<li><h4 style=\"font-size: 12px; display: inline; font-weight: normal;\"><a href=\"$home_url_perma\">$title_post</a></h4> <span style=\"font-size: 11px; color: #999999;\"> $postcount views</span></li>";
  } else {
  $todays_widget_temp .= "<li><h4 style=\"font-size: 12px; display: inline; font-weight: normal;\"><a href=\"$home_url/?p=$id_post\" title=\"$text\">$title_post</a></h4> <span style=\"font-size: 11px;\"> $postcount views</span></li>";
	  }
	 }
	 $todays_widget_temp .= "</ul>";
  }
	if (!$todays_widget_temp) {
	$todays_widget_temp .= "No posts viewed yet.";
	}
	$todays_widget .= $todays_widget_temp;
	echo $todays_widget;
  }

function admin_rightnow() {
	global $wpdb;
	global $table_name;
	global $table_posts;
	$home_url = get_settings('home');
	$perma = get_settings('permalink_structure');
	$nowisnow = todays_date();
	//$todays_widget = "<ul>";
	$rightnow_widget_temp = "";
	$widgets = $wpdb->get_results("SELECT * FROM $table_name inner join $table_posts on $table_posts.ID=$table_name.postnum WHERE time = '$nowisnow' and postcount > 0 and post_status = 'publish' ORDER BY postcount DESC LIMIT 1");
	$widgets_num = $wpdb->get_var("SELECT COUNT(*) FROM $table_name inner join $table_posts on $table_posts.ID=$table_name.postnum WHERE time = '$nowisnow' and postcount > 0 and post_status = 'publish'");
	if ($widgets_num) {
  $rightnow_widget_temp = "<h3>Top Post of the Day</h3><p>";
	foreach ($widgets as $widget) {
	$postnum = $widget->postnum;
	$postcount = $widget->postcount;
  $id_post = $widget->ID;
  $title_post = $widget->post_title;
  if ($perma) {
  $home_url_perma = get_permalink($id_post);
  $rightnow_widget_temp .= "The <a href=\"http://www.alleba.com/blog/2007/03/27/wordpress-plugin-daily-top-10-posts/\">most popular blog post</a> of the day is <a href=\"$home_url_perma\">$title_post</a>, viewed $postcount times so far. <a href=\"#topten\" class=\"rbutton\">more...</a></p>";
  } else {
  $rightnow_widget_temp .= "The <a href=\"http://www.alleba.com/blog/2007/03/27/wordpress-plugin-daily-top-10-posts/\">most popular blog post</a> of the day is <a href=\"$home_url/?p=$id_post\">$title_post</a>, viewed $postcount times so far. <a href=\"#topten\" class=\"rbutton\">more...</a></p>";
	  }
   }
  }
	if (!$rightnow_widget_temp) {
	$rightnow_widget_temp = "<h3>Top Post of the Day</h3><p>";
	$rightnow_widget_temp .= "No posts viewed yet today.</p>";
	}
	$rightnow_widget .= $rightnow_widget_temp;
	echo $rightnow_widget;
  }
add_action('activity_box_end', 'admin_rightnow');
add_action('wp_dashboard_setup', 'dailytopten_register_dashboard_widget');
function dailytopten_register_dashboard_widget() {
	wp_register_sidebar_widget('dashboard_dailytopten', __('<a name="topten"></a>Top Blog Posts of the Day', 'dailytopten'), 'dashboard_dailytopten',
		array(
		'width' => 'half',
		'height' => 'single',
		)
	);
}
 
add_filter('wp_dashboard_widgets', 'dailytopten_add_dashboard_widget');
function dailytopten_add_dashboard_widget($widgets) {
	global $wp_registered_widgets;
	if (!isset($wp_registered_widgets['dashboard_dailytopten'])) {
		return $widgets;
	}
	array_splice($widgets, sizeof($widgets)-1, 0, 'dashboard_dailytopten');
	return $widgets;
}

function dashboard_dailytopten() {
	global $wpdb;
	echo $before_widget;
	echo $before_title;
	echo $widget_name;
	echo $after_title;
	admin_todays_count_widget();
	echo $after_widget;
}

function widget_dailytopten_init() {
        if(!function_exists('register_sidebar_widget')) { return; }
        function widget_dailytopten($args) {
            extract($args);
            echo $before_widget . $before_title . "Top Posts of the Day" . $after_title;
            todays_count_widget('views', 'ul');
            echo $after_widget;
        }
        register_sidebar_widget('Daily Top 10 Posts','widget_dailytopten');
    }
add_action('plugins_loaded', 'widget_dailytopten_init');

function widget_dailytopten_overall_init() {
        if(!function_exists('register_sidebar_widget')) { return; }
        function widget_dailytopten_overall($args) {
            extract($args);
            echo $before_widget . $before_title . "Top Posts Overall" . $after_title;
            todays_overall_count_widget('views', 'ul');
            echo $after_widget;
        }
        register_sidebar_widget('Overall Top 10 Posts','widget_dailytopten_overall');
    }
add_action('plugins_loaded', 'widget_dailytopten_overall_init');

?>