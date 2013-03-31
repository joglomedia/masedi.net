<?php
/*** Theme setup ***/
// This theme uses post thumbnails
add_theme_support( 'post-thumbnails' );

// Add default posts and comments RSS feed links to head
add_theme_support( 'automatic-feed-links' );

// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain( 'templatic', TEMPLATEPATH . '/languages' );

// This theme uses wp_nav_menu() in one location.
$nav_menu_arg = array();
$nav_menu_arg['primary'] = __( 'Menu region in header', 'templatic' );
if($nav_menu_arg){ register_nav_menus( $nav_menu_arg );}

global $blog_id;
if($blog_id){ $thumb_url = "&amp;bid=$blog_id";}

define('TT_ADMIN_FOLDER_URL',get_bloginfo( 'template_directory', 'display' ).'/'.TT_ADMIN_FOLDER_NAME.'/'); //css folder url
define('TT_THEME_OPTIONS_FOLDER_URL',get_bloginfo( 'template_directory', 'display' ).'/'.TT_ADMIN_FOLDER_NAME.'/theme_options/'); //css folder url
define('TT_WIDGETS_FOLDER_URL',get_bloginfo( 'template_directory', 'display' ).'/library/functions/widgets/'); //WIDGET folder url
define('TT_WIDGET_JS_FOLDER_URL',TT_WIDGETS_FOLDER_URL.'widget_js/'); //widget javascript folder url
define('TT_FUNCTIONS_FOLDER_URL',get_bloginfo( 'template_directory', 'display' ).'/library/functions/'); //theme functions folder url
define('TT_INCLUDES_FOLDER_URL',get_bloginfo( 'template_directory', 'display' ).'/library/includes/'); //theme includes folder url
define('TT_CSS_FOLDER_URL',get_bloginfo( 'template_directory', 'display' ).'/library/css/'); //theme css folder url
define('TT_MODULE_FOLDER_URL',get_bloginfo( 'template_directory', 'display' ).'/modules/'); //theme css folder url


if(file_exists(TEMPLATEPATH . '/ecommerce/'))
	define('TT_MODULES_FOLDER_PATH',TEMPLATEPATH.'/ecommerce/'); //addons folder path
else  if(file_exists(TEMPLATEPATH . '/monetize/'))
		define('TT_MODULES_FOLDER_PATH',TEMPLATEPATH.'/monetize/'); //addons folder path
		define('TT_LIBRARY_FOLDER_PATH',TEMPLATEPATH.'/library/'); //library folder path
define('TT_FUNCTIONS_FOLDER_PATH',TT_LIBRARY_FOLDER_PATH . 'functions/'); //functions folder path
define('TT_WIDGET_FOLDER_PATH',TT_FUNCTIONS_FOLDER_PATH.'widgets/'); //widget folder path
define('TT_JSCRIPT_FOLDER_PATH',TT_LIBRARY_FOLDER_PATH . 'js/'); //javascript folder path
define('TT_CSS_FOLDER_PATH',TT_LIBRARY_FOLDER_PATH . 'css/'); //css folder path
define('TT_INCLUDES_FOLDER_PATH',TT_LIBRARY_FOLDER_PATH . 'includes/'); //includes folder path
define('TT_ADMIN_TPL_PATH',TT_ADMIN_FOLDER_PATH.'tpl/');  //structure folder path
?>