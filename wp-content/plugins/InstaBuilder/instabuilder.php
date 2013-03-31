<?php
/*
Plugin Name: InstaBuilder
Plugin URI: http://www.instabuilder.com
Description: Quickly and Easily Beautiful Landing Pages. Compatible with Iphone, Ipad, Android, Blackberry, and other mobile devices.
Version: 1.0.0
Author: Suzanna Theresia
Author URI: http://www.instabuilder.com
*/

@ini_set('pcre.backtrack_limit', 500000);

define( 'OPL_URL', plugin_dir_url(__FILE__) );
define( 'OPL_PATH', plugin_dir_path(__FILE__) );
define( 'OPL_BASENAME', plugin_basename( __FILE__ ) );

define( 'OPL_VERSION', '1.10' );
define( 'OPL_DB_VERSION', '0.09' );

if ( is_admin() ) {
	require_once( OPL_PATH . 'inc/admin.php' );
	require_once( OPL_PATH . 'inc/meta.php' );
} else {
	require_once( OPL_PATH . 'inc/functions.php');
	require_once( OPL_PATH . 'inc/shortcodes.php' );
	require_once( OPL_PATH . 'inc/share.php' );
	require_once( OPL_PATH . 'inc/tracker.php' );
}

require_once( OPL_PATH . 'inc/widget.php' );

register_activation_hook( __FILE__, 'opl_activation');
function opl_activation() {
	$installed_ver = get_option( 'opl_db_version' );
	if ( $installed_ver != OPL_DB_VERSION ) {
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		$table = "{$wpdb->prefix}opl_facebook_tab";
		$sql = "CREATE TABLE {$table} (
					`ID` bigint(20) NOT NULL AUTO_INCREMENT,
					`fb_page_id` varchar(100) NOT NULL,
					`reveal` int(11) NOT NULL,
					`post_id` bigint(20) NOT NULL,
					`post_id2` bigint(20) NOT NULL,
				UNIQUE KEY id (ID)
    			) DEFAULT CHARSET=utf8";
				dbDelta($sql);
				
		$table = "{$wpdb->prefix}opl_links";
		$sql = "CREATE TABLE {$table} (
					`ID` bigint(20) NOT NULL AUTO_INCREMENT,
					`name` varchar(100) NOT NULL,
					`slug` varchar(255) NOT NULL,
					`redir_type` varchar(10) NOT NULL,
					`conversion_id` bigint(20) NOT NULL,
					`data` longtext NOT NULL,
					`created` int(11) NOT NULL,
				UNIQUE KEY id (ID)
		    	) DEFAULT CHARSET=utf8";
				dbDelta($sql);

		$table = "{$wpdb->prefix}opl_stats";
		$sql = "CREATE TABLE {$table} (
					`ID` bigint(20) NOT NULL AUTO_INCREMENT,
					`link_id` bigint(20) NOT NULL,
					`split_id` bigint(20) NOT NULL,
					`ip_addr` varchar(100) NOT NULL,
					`referrer` varchar(255) NOT NULL,
					`visitor_id` varchar(100) NOT NULL,
					`browser` varchar(50) NOT NULL,
					`tracking_url` varchar(255) NOT NULL,
					`date` int(11) NOT NULL,
				UNIQUE KEY id (ID)
		    	) DEFAULT CHARSET=utf8";
				dbDelta($sql);

		$table = "{$wpdb->prefix}opl_conversions";
		$sql = "CREATE TABLE {$table} (
					`ID` bigint(20) NOT NULL AUTO_INCREMENT,
					`link_id` bigint(20) NOT NULL,
					`split_id` bigint(20) NOT NULL,
					`ip_addr` varchar(100) NOT NULL,
					`referrer` varchar(255) NOT NULL,
					`visitor_id` varchar(100) NOT NULL,
					`revenue` decimal(5,2) NOT NULL,
					`tracking_url` varchar(255) NOT NULL,
					`date` int(11) NOT NULL,
				UNIQUE KEY id (ID)
		    	) DEFAULT CHARSET=utf8";
				dbDelta($sql);

		$table = "{$wpdb->prefix}opl_splits";
		$sql = "CREATE TABLE {$table} (
					`ID` bigint(20) NOT NULL AUTO_INCREMENT,
					`link_id` bigint(20) NOT NULL,
					`post_id` bigint(20) NOT NULL,
					`weight` int(11) NOT NULL,
					`count` int(11) NOT NULL,
					`next` tinyint NOT NULL,
				UNIQUE KEY id (ID)
		    	) DEFAULT CHARSET=utf8";
		dbDelta($sql);
		update_option('opl_db_version', OPL_DB_VERSION);
	}
	
	if ( ($opl = get_option('opl_settings')) === FALSE ) {
		// set default options
		$options = array(
			'fb_appid' => '',
    		'disable_powered' => 0,
    		'aff_url' => '',
    		'dq_short' => '',
    		'tw_consumer_key' => '',
    		'tw_consumer_secret' => ''
		);
		update_option('opl_settings', $options);
	}
}

add_action('plugins_loaded', 'opl_update_db_check');
function opl_update_db_check() {
	if ( get_option( 'opl_db_version' ) != OPL_DB_VERSION ) {
		opl_activation();
	}
}

add_action('template_redirect', 'opl_squeeze');
function opl_squeeze() {
	global $post;

	if ( !is_page() )
		return;

	$meta = get_post_meta($post->ID, 'opl_settings', true);

	if ( opl_isset($meta['enable_opl']) != 1 )
		return;

	$header = get_post_meta($post->ID, 'opl_headers', true);
	
	$headline = opl_isset($meta['headline']);
	$optin = opl_isset($meta['optin']);
	$video = opl_isset($meta['video_settings']);
	$buy = opl_isset($meta['buy_settings']);
	$bg = opl_isset($meta['bg']);
	$social = opl_isset($meta['social_settings']);
	$launch = opl_isset($meta['launch']);
	$type = opl_isset($meta['type']);
	$theme = opl_isset($meta['template']);
	$color = opl_isset($meta['color']);
	$ar_code = stripslashes(opl_isset($meta['ar_code']));
	$name_label = stripslashes(opl_isset($optin['name_field']));
	$email_label = stripslashes(opl_isset($optin['email_field']));
	$btn_color = stripslashes(opl_isset($optin['button_color']));
	$btn_text = stripslashes(opl_isset($optin['button_label']));
	$comment_title = stripslashes(opl_isset($meta['comment_title']));
	$delay_hour = (int) opl_isset($buy['delay_hour']);
	$delay_min = (int) opl_isset($buy['delay_min']);
	$delay_sec = (int) opl_isset($buy['delay_sec']);
	$oto = (int) opl_isset($meta['opl_oto']);
	$oto_redir = get_permalink(opl_isset($meta['oto_redir']));
	$form_mode = opl_isset($optin['form_mode']);
	
	$opl_facebook_width = '780';
	switch ( $type ) {
		case 'single':
			$template = 'single.php';
			opl_oto_check($oto, $oto_redir);
			break;
		case 'launch':
			$template = 'launch.php';
			break;
		case 'video':
			$template = 'video.php';
			opl_oto_check($oto, $oto_redir);
			break;
		case 'optin':
			$template = 'optin.php';
			break;
		case 'front':
		default:
			$template = 'index.php';
			$opl_facebook_width = '640';
	}

	$resp = ( $optin['form_mode'] == 'advanced' ) ? opl_extract_adv_fields($ar_code) : opl_extract_fields($ar_code, $name_label, $email_label);

	// THEME API
	$opl_manual_subs = opl_isset($optin['subs_method_manual']);
	$opl_single_width = opl_isset($meta['width']);
	$opl_single_width_2 = $opl_single_width - 30;
	$opl_fb_subs = opl_isset($optin['subs_method_fb']);
	$opl_optin_form = opl_optin_form($resp, $opl_manual_subs, $optin, $form_mode);
	$opl_path = OPL_PATH;	
	$opl_theme_path = OPL_PATH . "templates/{$theme}/";
	$opl_theme_url = OPL_URL . "templates/{$theme}/";
	$opl_theme = $theme;
	$opl_color = $color;
	$opl_headline = stripslashes(opl_webtreats_formatter(do_shortcode($headline['text'])));
	$opl_optin_title = stripslashes(opl_isset($optin['title']));
	$opl_optin_text = stripslashes(opl_isset($optin['text']));
	$opl_privacy_text = stripslashes(esc_attr(opl_isset($optin['privacy_text'])));
	$opl_top_nav = opl_top_nav( opl_isset($meta['top_nav']) );
	$opl_footer_nav = opl_footer_nav( opl_isset($meta['footer_nav']) );
	$opl_footer_text = stripslashes(opl_isset($meta['footer_text']));
	
	// VIDEO PAGE API
	$opl_video_mode = opl_isset($video['insertion']);
	$opl_video_url = trim(opl_isset($video['video_url']));
	$opl_show_video = opl_show_video( $video );
	$opl_video_width = ( opl_isset($video['video_width']) != '' ) ? $video['video_width'] : '640';
	$opl_video_height = ( opl_isset($video['video_height']) != '' ) ? $video['video_height'] : '360';
	$opl_buy_area_width = ( $opl_video_width > 600 ) ? $opl_video_width - 40 : '600';
	$opl_under_video = opl_isset($buy['under_content']);
	$opl_buy_area = opl_isset($buy['order_area']);
	$opl_delay = ( ($delay_hour * 3600) + ($delay_min * 60) ) + $delay_sec;
	$opl_after_video = ( $opl_under_video == 'order' || $opl_under_video == 'combo1' ) ? opl_buy_area($opl_buy_area) : ( ($opl_under_video == 'optin' || $opl_under_video == 'combo2') ? opl_video_optin($opl_optin_form, $optin) : '');
	$opl_under_style = ( $opl_delay > 0 ) ? 'display:none; ': '';
	$opl_under_width = 'max-width: ' . $opl_buy_area_width . 'px;';
	$opl_delay_script = opl_delay_script( $opl_delay );
	$opl_display_video = opl_check_video( $video );
	
	// LAUCH
	$opl_launchnav_pos = opl_isset($launch['launchbar_pos']);
	$opl_launchnav_items = opl_isset($launch['items']);
	$opl_launch_bar = opl_launch_bar($opl_launchnav_items, $opl_launchnav_pos);
	
	require_once( OPL_PATH . 'inc/Mobile_Detect.php');
	$detect = new Mobile_Detect;
	$ratio = $opl_video_height / $opl_video_width;
	if ( $detect->isMobile() && $opl_video_width > 256 ) {
		$opl_video_width = '256';
		$opl_video_height = $opl_video_width * $ratio;
		$opl_buy_area_width = ( $opl_video_width > 240 ) ? $opl_video_width : '240';
		$opl_under_width = 'max-width: ' . $opl_buy_area_width . 'px;';
	} else if ( $detect->isTablet() && $opl_video_width > 640 ) {
		$width = '640';
		$opl_video_height = $opl_video_width * $ratio;
	}
	
	// SOCIAL API
	$opl_facebook_text = stripslashes(opl_isset($optin['fb_text']));
	$opl_facebook_label = stripslashes(opl_isset($optin['fb_label']));
	$opl_facebook_msg = stripslashes(opl_isset($optin['fb_msg']));
	$opl_show_comments = opl_show_comments( opl_isset($meta['fb_comment']), opl_isset($meta['dq_comment']) );
	$opl_comment_title = ( $opl_show_comments ) ? opl_comment_title( $comment_title ) : '';
	$opl_facebook_width = ( $detect->isMobile() ) ? '300' : ( ($detect->isTablet()) ? $opl_facebook_width - 150 : $opl_facebook_width);
	$opl_facebook_width = ( $type == 'video' && $opl_under_video == 'order' || $type == 'video' && $opl_under_video == 'optin' ) ? $opl_buy_area_width : $opl_facebook_width;
	$opl_facebook_comment = ( opl_isset($meta['fb_comment']) == 1 ) ? opl_facebook_comment( $opl_facebook_width ) : '';
	$opl_disqus_comment = ( opl_isset($meta['dq_comment']) == 1 ) ? opl_disqust_comment() : '';
	$opl_social_share = opl_social_share($social);
	
	// HEADER API
	$opl_header = opl_isset($header['opl_header']);
	$opl_logo_type = opl_isset($header['logo_type']);
	$opl_logo_url = opl_isset($header['logo_url']);
	$opl_text_logo = stripslashes(esc_attr(opl_isset($header['text_logo'])));
	$opl_logo_color = opl_isset($header['logo_color']);
	$opl_logo_font = opl_isset($header['logo_font']);
	$opl_logo_size = opl_isset($header['logo_size']);
	$opl_logo_align = opl_isset($header['logo_align']);
	$opl_display_header = opl_display_header( $opl_header, $opl_top_nav, opl_isset($bg['opl_headerbg']) );
	$opl_headerbg = opl_isset($meta['bg']);
	
	//$opl_main_vid_size = ( $opl_video_mode == 'hosted' ) ? 'style="width:' . $opl_video_width . 'px; height:' . $opl_video_height . 'px";' : 'style="max-width:' . $opl_video_width . 'px;"';
	$opl_main_vid_size = 'style="max-width:' . $opl_video_width . 'px; max-height:' . $opl_video_height . '"';
	
	if ( have_posts() ) {	
		include( $opl_theme_path . $template );
		die();
	}
}

add_action('template_redirect', 'opl_mobile_switcher', 2);
function opl_mobile_switcher() {
	global $post;

	if ( !is_page() )
		return;

	$meta = get_post_meta($post->ID, 'opl_settings', true);

	if ( opl_isset($meta['enable_opl']) != 1 )
		return;
	
	$mobile = opl_isset($meta['mobile']);
	if ( opl_isset($mobile['mobilesw']) == 1 ) {
		require_once( OPL_PATH . 'inc/Mobile_Detect.php');
		$detect = new Mobile_Detect;
		
		if ( !$detect->isMobile() )
			return;
		
		if ( opl_isset($mobile['mobilesw_notablet']) == 1 && $detect->isTablet() )
			return;
		
		$url = get_permalink(opl_isset($mobile['mobilesw_dest']));
		if ( empty($url) )
			return;
		
		wp_redirect($url);
		exit;
	}
}

function opl_check_video( $video ) {
	if ( opl_isset($video['insertion']) == 'embed' && opl_isset($video['video_code']) == '' ) return false;
	if ( opl_isset($video['insertion']) == 'hosted' && opl_isset($video['video_url']) == '' ) return false;
	
	return true;
}

function opl_dump( $var ) {
	echo '<pre>' . print_r($var, true) . '</pre>';
}

function opl_isset( &$val, $default = NULL ) {
	if ( isset($val) )
		$tmp = $val;
	else
		$tmp = $default;
	return $tmp;
}

function opl_format_url( $page_id, $query_str, $notrail = 'no' ) {
	$query_string = '';
	$link = '';
	$url = ( is_numeric($page_id) && $page_id > 0 ) ? get_permalink($page_id) : $page_id;

	if ( get_option('show_on_front') == 'page') {
		// this mean the page is on the front... so the format is
		if ( get_option('page_on_front') == $page_id ) {
			$query_string = '?' . $query_str;
			if ( $notrail == 'yes' )
				$link = $url . $query_string;
			else
				$link = trailingslashit($url) . $query_string;
		} else if ( get_option('page_for_front') != $page_id ) {
			if ( get_option('permalink_structure') == '' ) {
				if (strpos($url, '?'))
					$query_string = '&' . $query_str;
				else
					$query_string = '?' . $query_str;
					
				$link = $url . $query_string;
			} else {
				$query_string = '?' . $query_str;

				if ( $notrail == 'yes' )
					$link = $url . $query_string;
				else
					$link = trailingslashit($url) . $query_string;
			}
		}
	} else {
		// this mean the page is NOT on the front... so the format is
		if ( get_option('permalink_structure') == '' ) {
			if (strpos($url, '?'))
				$query_string = '&' . $query_str;
			else
				$query_string = '?' . $query_str;
					
			$link = $url . $query_string;
		} else {
			$query_string = '?' . $query_str;
			if ( $notrail == 'yes' )
				$link = $url . $query_string;
			else
				$link = trailingslashit($url) . $query_string;
		}
	}

	return $link;
}

function opl_webtreats_formatter($content) {
	$new_content = '';

	/* Matches the contents and the open and closing tags */
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';

	/* Matches just the contents */
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';

	/* Divide content into pieces */
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

	/* Loop over pieces */
	foreach ( $pieces as $piece ) {
		/* Look for presence of the shortcode */
		if ( preg_match($pattern_contents, $piece, $matches) ) {
			/* Append to content (no formatting) */
			$new_content .= $matches[1];
		} else {
			/* Format and append to content */
			$new_content .= wptexturize(wpautop($piece));
		}
	}

	return $new_content;
}

add_action('template_redirect', 'opl_formatter', 1);
function opl_formatter() {
	if ( !is_page() )
		return;
	
	global $post;
	
	//$meta = get_post_meta($post->ID, 'opl_settings', true);
	//if ( opl_isset($meta['enable_opl']) != 1 )
		//return;
	
	remove_filter('the_content', 'wpautop');
	remove_filter('the_content', 'wptexturize');

	add_filter('the_content', 'opl_webtreats_formatter', 99);
	add_filter('widget_text', 'opl_webtreats_formatter', 99);
}

// Fix conflict with the 'Social Essentials' Plugin
if ( !is_admin() ) add_action( 'wp_print_scripts', 'opl_se_fix', 100 );
function opl_se_fix() {
	if ( !is_page() )
		return;
	
	global $post;
	$meta = get_post_meta($post->ID, 'opl_settings', true);
	if ( opl_isset($meta['enable_opl']) != 1 )
		return;
	
	wp_deregister_script( 'se-facebook' );
}

add_theme_support( 'post-thumbnails' );

// SPLIT TEST FUNCTIONS
function opl_get_split( $link_id ) {
	global $wpdb;
	
	if ( empty($link_id) )
		return false;

	$id = intval($link_id);

	// grab link data from cache
	$value = wp_cache_get($id, 'opl_splits');
	if ( !$value ) {
		// grab campaign data from database
		$value = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}opl_links` WHERE `ID` = %d", $id));
		
		if ( !$value )
			return false;

		// add $value to cache
		wp_cache_add($id, $value, 'opl_splits');
	}

	return $value;	
}

function opl_get_split_urls($link_id) {
	global $wpdb;
	
	if ( empty($link_id) )
		return false;

	$id = intval($link_id);

	// grab urls data from cache
	$value = wp_cache_get($id, 'opl_split_urls');
	if ( !$value ) {
		// grab campaign data from database
		$value = $wpdb->get_results($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}opl_splits` WHERE `link_id` = %d ORDER BY `ID` ASC", $id));
		
		if ( !$value )
			return false;

		// add $value to cache
		wp_cache_add($id, $value, 'opl_split_urls');
	}

	return $value;	
}

function opl_check_split_url($url, $link_id) {
	global $wpdb;
	
	$exist = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM `{$wpdb->prefix}opl_splits` WHERE `link_id` = %d AND `url` = %s", $link_id, $url));
	if ( $exist < 1 )
		return false;
	else
		return true;
}