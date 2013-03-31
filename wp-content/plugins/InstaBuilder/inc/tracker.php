<?php if ( !defined('ABSPATH') ) die('No direct access');
add_action('init', 'opl_tracker', 2);
function opl_tracker() {
	if ( !defined('DOING_CRON') )
		define('DOING_CRON', true);

	global $wpdb;
	
	$site_url = get_bloginfo('url');
	$wp_dir = explode('/', str_replace(array('http://', 'https://'), '', $site_url));
	$start = count($wp_dir);

	$dir  = dirname( $_SERVER['PHP_SELF'] );
	$file = explode('/', $_SERVER['REQUEST_URI']);

	$slug = array();
	for ( $i=$start; $i<count($file); $i++ ) {
		$slug[] = $file[$i];
	}

	if ( count($slug) < 1 )
		return;

	$slug = implode('/', $slug);
	
	$no_query = explode("?", $slug);
	$_slug = opl_isset($no_query[0]);

	$sid = ( isset($_GET['sid']) ) ? $_GET['sid'] : '';

	$link = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}opl_links` WHERE slug = %s", $_slug));
	if ( !$link )
		return;

	$link_id = opl_isset($link->ID);
	$metadata = maybe_unserialize(opl_isset($link->data));
	$user_agent = opl_isset($_SERVER['HTTP_USER_AGENT']);
	$referrer = opl_isset($_SERVER['HTTP_REFERER']);
	$browser = opl_get_browser($user_agent);

	if ( isset($_COOKIE['__utmbwstl' . $link_id]) ) {
		$post_id = (int) $_COOKIE['__utmbwstl' . $link_id];
		$target_url = get_permalink($post_id);
	} else {
		$post_id = opl_get_next_url($link_id);
		$target_url = get_permalink($post_id);
		@setcookie('__utmbwstl' . $link_id, $post_id, time() + 60*60*24*30, SITECOOKIEPATH);
	}

	if ( !opl_is_bot($user_agent) && !is_opl_admin() ) {
		if ( !isset($_COOKIE['__utmbwsta' . $link_id]) ) {
			$visitor_id = opl_generate_visitorid();
			@setcookie('__utmbwsta' . $link_id, $visitor_id, time() + 60*60*24*365, SITECOOKIEPATH);
		} else {
			$visitor_id = opl_isset($_COOKIE['__utmbwsta' . $link_id]);
		}
	
		$split_id = opl_get_split_id($post_id, $link_id);
		$tracking_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		
		$data = array(
			'link_id' => $link_id,
			'split_id' => $split_id,
			'ip_addr' => opl_get_ip(),
			'referrer' => $referrer,
			'visitor_id' => $visitor_id,
			'browser' => $browser,
			'tracking_url' => $tracking_url,
			'date' => time()
		);

		$wpdb->insert("{$wpdb->prefix}opl_stats", $data);
		$stat_id = $wpdb->insert_id;

		$dc_value = ( isset($metadata['conversion_value']) ) ? $metadata['conversion_value'] : '0.00';
		$adv_data = "{$tracking_url}|{$dc_value}|{$referrer}";
		@setcookie('__utmbwstv' . $link_id, $adv_data, 0, SITECOOKIEPATH);

		if ( !isset($_COOKIE['__utmbwstx' . $link_id]) )
			@setcookie('__utmbwstx' . $link_id, $visitor_id . '.' . $stat_id , time() + 3600*24*30, SITECOOKIEPATH);
	}
	
	
	if ( opl_isset($link->redir_type) == '301' ) {
		@header('HTTP/1.1 301 Moved Permanently');
		@header('location:' . $target_url);
	} else {
		wp_redirect($target_url);
	}
	exit;
}

function opl_get_next_url($link_id) {
	global $wpdb;

	$link_id = (int) $link_id;
	$split = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}opl_splits` WHERE link_id = %d AND next = %d", $link_id, 1));

	if ( !$split ) {
		$urls = $wpdb->get_results($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}opl_splits` WHERE link_id = %d ORDER BY ID ASC LIMIT 1", $link_id));
		if ( $urls ) {
			foreach ( $urls as $url ) {
				$split = $url;
			}
		}
	}

	$count = ( $split->weight == $split->count ) ? 0 : $split->count + 1;
	$update = $wpdb->query("UPDATE `{$wpdb->prefix}opl_splits` SET count = {$count}, next = 1 WHERE ID = {$split->ID}");

	$redirect = opl_isset($split->post_id);
	$url = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}opl_splits` WHERE ID = %d", opl_isset($split->ID)));
	if ( $url ) {
		if ( $url->count == $url->weight ) {
			$wpdb->query($wpdb->prepare("UPDATE `{$wpdb->prefix}opl_splits` SET count = %d, next = %d WHERE ID = %d", 0, 0, $url->ID));
			$next = $wpdb->get_results($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}opl_splits` WHERE link_id = %d AND ID > %d ORDER BY ID ASC LIMIT 1", $link_id, $url->ID));
			if ( !$next )
				$next = $wpdb->get_results($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}opl_splits` WHERE link_id = %d ORDER BY ID ASC LIMIT 1", $link_id));

			if ( $next ) {
				foreach ( $next as $n ) {
					$wpdb->query($wpdb->prepare("UPDATE `{$wpdb->prefix}opl_splits` SET next = %d WHERE ID = %d", 1, $n->ID));
				}
			}
		}
	}

	return $redirect;
}

function opl_get_ip() {
	// Retrieve unique identifier for this user.
	$unique_ip = trim(getenv('HTTP_X_FORWARDED_FOR'));
	$uv_id = $unique_ip;

	if ( !preg_match("/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/", $unique_ip) ) {
    		$unique_ip = $_SERVER['REMOTE_ADDR'];
    		$uv_id = $unique_ip;
	}

	if ( !preg_match("/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/", $unique_ip) ) {
    		@$uv_id = gethostbyaddr($unique_ip);
	}

	return $uv_id;
}

function opl_generate_visitorid() {
	return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        	// 32 bits for "time_low"
        	mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        	// 16 bits for "time_mid"
        	mt_rand( 0, 0xffff ),
        	// 16 bits for "time_hi_and_version",
        	// four most significant bits holds version number 4
        	mt_rand( 0, 0x0fff ) | 0x4000,
        	// 16 bits, 8 bits for "clk_seq_hi_res",
        	// 8 bits for "clk_seq_low",
        	// two most significant bits holds zero and one for variant DCE1.1
        	mt_rand( 0, 0x3fff ) | 0x8000,
        	// 48 bits for "node"
        	mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    	);
}

function opl_get_browser($user_agent) {
	$user_agent = strtolower($user_agent);
	$browsers = array("firefox", "msie", "opera", "chrome", "safari",
                            "mozilla", "seamonkey", "konqueror", "netscape",
                            "gecko", "navigator", "mosaic", "lynx", "amaya",
                            "omniweb", "avant", "camino", "flock", "aol"
			);

	$browser_name = 'Unknown';
	foreach ( $browsers as $browser ) {
		if ( preg_match("#($browser)[/ ]?([0-9.]*)#", $user_agent) ) {
			$browser_name = $browser;
			break;
		}
	}

	return $browser_name;
}

function opl_bot_strings() {
	return array("google", "bot", "yahoo", "spider", "archiver", "curl", "python", "nambu",
          	"twitt", "perl", "sphere", "PEAR", "java", "wordpress", "radian", "crawl", "yandex",
			"eventbox", "monitor", "mechanize", "facebookexternal");
}

function opl_is_bot($user_agent) {
	if ( $user_agent == '' )
    		return true;

	$bot_strings = opl_bot_strings();
	foreach( $bot_strings as $bot ) {
		if ( strpos($user_agent, $bot) !== FALSE )
			return true;
  	}
  
  	return false;
}

function opl_get_split_id( $post_id, $link_id ) {
	global $wpdb;

	$link_id = (int) $link_id;
	$split = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}opl_splits` WHERE `post_id` = %d AND `link_id` = %d", $post_id, $link_id));
	if ( !$split )
		return '0';

	return $split->ID;
}

add_action('template_redirect', 'opl_conversion_track');
function opl_conversion_track() {
	global $wpdb, $post;
	
	if ( !is_page() )
		return;
	
	$meta = get_post_meta($post->ID, 'opl_split_conversion', true);
	if ( opl_isset($meta['conversion']) != 'true' ) return;
	
	$link_id = opl_isset($meta['link_id']);
	$visitor_id = opl_isset($_COOKIE['__utmbwsta' . $link_id]);
	$user_agent = opl_isset($_SERVER['HTTP_USER_AGENT']);

	if ( opl_is_bot($user_agent) || is_opl_admin() ) return;
	if ( !isset($_COOKIE['__utmbwstx' . $link_id]) ) return;
	if ( isset($_COOKIE['__utmbwstc' . $link_id]) ) return;
		
	@setcookie('__utmbwstc' . $link_id, $visitor_id, time() + 60*60*24*365, SITECOOKIEPATH);

	$chk = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM `{$wpdb->prefix}opl_conversions` WHERE `visitor_id` = %s AND `link_id` = %d", $visitor_id, $link_id));
	if ( $chk > 0 )
		return;
	
	$adv_data = explode("|", $_COOKIE['__utmbwstv']);
	$tracking_url = opl_isset($adv_data[0]);
	$dc_value = opl_isset($adv_data[1]);
	$referrer = opl_isset($adv_data[2]);
	$revenue = ( isset($_GET['value']) ) ? number_format($_GET['value'], 2, '.', '') : number_format($dc_value, 2, '.', '');
	
	$split_id = 0;
	if ( isset($_COOKIE['__utmbwstl' . $link_id]) )
		$split_id = opl_get_split_id( $_COOKIE['__utmbwstl' . $link_id], $link_id );

	$data = array(
			'link_id' => $link_id,
			'split_id' => $split_id,
			'ip_addr' => opl_get_ip(),
			'referrer' => $referrer,
			'visitor_id' => $visitor_id,
			'revenue' => $revenue,
			'tracking_url' => $tracking_url,
			'date' => time()
		);

	$wpdb->insert("{$wpdb->prefix}opl_conversions", $data);
	
	return true;
}