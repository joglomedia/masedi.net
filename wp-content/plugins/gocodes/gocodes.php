<?php
/*
Plugin Name: GoCodes
Plugin URI: http://www.webmaster-source.com/gocodes-redirection-plugin-wordpress/
Description: Create shortcut URLs to anywhere on the internet, right from your Wordpress Admin. When upgrading, be sure to read the <a href="http://wordpress.org/extend/plugins/gocodes/other_notes/">upgrade notes.</a>
Author: Matt Harzewski (redwall_hp)
Author URI: http://www.webmaster-source.com
Version: 1.3.4
*/

//***** What version of WordPress is this? *****
if ($wp_version < "2.7") {
	define("GOCODES_URL", "edit.php?page=gocodes/gocodes.php");
}
else {
	define("GOCODES_URL", "tools.php?page=gocodes/gocodes.php");
}



//***** Hooks *****
register_activation_hook(__FILE__,'wsc_gocodes_install'); //Install
add_action('init', 'wsc_gocodes_query'); //Redirect
add_action('admin_menu', 'wsc_gocodes_add_pages'); //Admin pages
//***** End Hooks *****



//***** Installer *****
if (is_admin()) {
	include "installer.php";
}



//***** Redirection *****
function wsc_gocodes_query() {
	global $wpdb, $table_prefix;
	$request = $_SERVER['REQUEST_URI'];
	if (!isset($_SERVER['REQUEST_URI'])) {
		$request = substr($_SERVER['PHP_SELF'], 1);
		if (isset($_SERVER['QUERY_STRING']) AND $_SERVER['QUERY_STRING'] != '') { $request.='?'.$_SERVER['QUERY_STRING']; }
	}
	if (isset($_GET['gocode'])) {
		$request = '/go/'.$_GET['gocode'].'/';
	}
	$url_trigger = get_option("wsc_gocodes_url_trigger");
	$nofollow = get_option("wsc_gocodes_nofollow");
	if ($url_trigger=='') {
		$url_trigger = 'go';
	}
	if ( strpos('/'.$request, '/'.$url_trigger.'/') ) {
		$gocode_key = explode($url_trigger.'/', $request);
		$gocode_key = $gocode_key[1];
		$gocode_key = str_replace('/', '', $gocode_key);
		$table_name = $wpdb->prefix . "wsc_gocodes";
		$gocode_key = $wpdb->escape($gocode_key);
		$gocode_db = $wpdb->get_row("SELECT id, target, key1, docount FROM $table_name WHERE key1 = '$gocode_key'", OBJECT);
		$gocode_target = $gocode_db->target;
		if ($gocode_target!="") {
			if ($gocode_db->docount == 1) {
				$update = "UPDATE ". $table_name ." SET hitcount=hitcount+1 WHERE id='$gocode_db->id'";
				$results = $wpdb->query( $update );
			}
			if ($nofollow != '') { header("X-Robots-Tag: noindex, nofollow", true); }
			wp_redirect($gocode_target, 301);
			exit;
		} else { $badgckey = get_option('siteurl'); wp_redirect($badgckey, 301); exit; }
	}
}
//***** End Redirection *****



//Just a boring function to insert the menus
function wsc_gocodes_add_pages() {
	add_management_page("GoCodes", "GoCodes", "manage_categories", __FILE__, "wsc_gocodes_managemenu");
	add_options_page("GoCodes Settings", "GoCodes", "manage_options", __FILE__, "wsc_gocodes_optionsmenu");
}



//***** Menu *****
if (is_admin()) {
	include "menus.php";
}



//***** Text Truncation Helper Function *****
function wsc_gocodes_truncate($text) {
	if ( strlen($text) > 79 ) {
		$text = $text." ";
		$text = substr($text,0,80);
		$text = $text."...";
		return $text;
	} else { return $text; }
}



//***** Get Plugin Location *****
function wsc_gocodes_get_plugin_dir($type) {
	if ( !defined('WP_CONTENT_URL') )
		define( 'WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
	if ( !defined('WP_CONTENT_DIR') )
		define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
	if ($type=='path') { return WP_CONTENT_DIR.'/plugins/'.plugin_basename(dirname(__FILE__)); }
	else { return WP_CONTENT_URL.'/plugins/'.plugin_basename(dirname(__FILE__)); }
}



//***** Add Item to Favorites Menu *****
function wsc_gocodes_add_menu_favorite($actions) {
	$actions[GOCODES_URL] = array('GoCodes', 'manage_options');
	return $actions;
}
add_filter('favorite_actions', 'wsc_gocodes_add_menu_favorite'); //Favorites Menu



/*
Copyright 2008 Matt Harzewski

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

?>