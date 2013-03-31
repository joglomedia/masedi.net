<?php
/*
Plugin Name: WP ZonGrabbing
Plugin URI: http://magicprofitmachine.com
Version: 1.1
Author: Arnold Gee
Author URI: http://magicprofitmachine.com
Description: Grab and post Amazon products based on ASINs. WP ZonGrabbing is the plugin version of MPM ZonPoster.
*/

require_once 'include.php';
require_once 'functions.php';

register_activation_hook(__FILE__, 'cmt_activate');
register_deactivation_hook(__FILE__, 'cmt_deactivate');

?>