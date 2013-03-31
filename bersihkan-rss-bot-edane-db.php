<?php
// maintenance script to clear the default WP Options cache
/*
 * Plugin Name: iPaymu for WooCommerce
 * Plugin URI: http://masedi.net/wordpress/plugins/clear-wp-option-cache.html
 * Description: Delete feed option table caused by STT2 RSS, RSS and Search engine bot stored in wo-options
 * 
 * Installation: install/upload this file clear-wp-option-cache.php on root of your wordpress installation
 * Usage: access this file from your browser and it will automatically DELETE table row with option_name like this:
 * %_transient_timeout_feed_mod_%
 * %_transient_timeout_feed_%
 * %_transient_feed_mod_%
 * %_transient_feed_%
 *
 * Author: MasEDI
 * Author URI: http://masedi.net/
*/

require( 'wp-config.php' );

global $wpdb;
$query = "DELETE FROM $wpdb->options WHERE option_name LIKE '%_transient_timeout_feed_%' OR option_name LIKE '%_transient_feed_%'";
$result = $wpdb->query($query);

if (!$result) {
	echo "This query: ' $query ' failed to execute <br />";
	$wpdb->print_error();
    exit();
}else{
	echo "This query: ' $query ' has been executed succesfully. <br />
	All value like %_transient_timeout_feed_% and %_transient_feed_% row in ".$wpdb->prefix."options has been deleted";
}
?>