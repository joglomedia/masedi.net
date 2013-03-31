<?php if ( !defined('ABSPATH') ) die('No direct access');

add_action('wp_footer', 'opl_fb_viral_share');
function opl_fb_viral_share(){
	global $post;
	
	$meta = get_post_meta($post->ID, 'opl_settings', true);
	
	if ( opl_isset($meta['enable_opl']) != 1 )
		return;
	
	$viral = opl_isset($meta['viral']);
	$script = '';
	if ( opl_isset($viral['viral_fb']) == 1 ) {
		$fb_link = ( opl_isset($viral['viral_fburl']) != '' ) ? 'link: "' . trim($viral['viral_fburl']) . '",' : 'link: "' . get_permalink($post->ID) . '",';
		$fb_title = ( opl_isset($viral['viral_fbtitle']) != '' ) ? 'name: "' . trim($viral['viral_fbtitle']) . '",' : 'name: "' . $post->post_title . '",';
		$fb_image = ( opl_isset($viral['viral_fbimg']) != '' ) ? 'picture: "' . trim($viral['viral_fbimg']) . '",' : '';
		$fb_desc = ( opl_isset($viral['viral_fbdesc']) != '' ) ? 'description: "' . trim($viral['viral_fbdesc']) . '"' : '';
		
		$script .= "
			<script type='text/javascript'>
			jQuery(document).ready(function(){
				jQuery('.opl-fb-lock').click(function(e){
					FB.getLoginStatus(function(response) {
						if ( response.status == 'connected' ) {
							opl_fb_viral_share(jQuery);
						} else {
							opl_fb_viral_login(jQuery);
						}
						e.preventDefault();
					});
				});
			});
			
			function opl_fb_viral_login($) {
				FB.login(function(response) {
					if ( response.authResponse ) {
						if ( response.status == 'connected' ) {	
							opl_fb_viral_share($);
						}
					}
				}, {scope: 'email,publish_stream'});
			}

			function opl_fb_viral_share($) {
				FB.api('/me/feed', 'post', {
					{$fb_link}
					{$fb_image}
					{$fb_title}
					caption : '',
					{$fb_desc}
				}, function(response) {
					$.cookie('__opl_unlock_{$post->ID}', 1, { expires: 365, path: '" . SITECOOKIEPATH . "' });
					location.reload();
				});
			}
			</script>
		";
	}
	
	echo $script;
}

add_action('init', 'opl_tw_viral_share');
function opl_tw_viral_share(){
	if ( isset($_GET['opl_ID']) && opl_isset($_GET['share']) == 'twitter' && opl_isset($_GET['action']) == 'tweet' ) {
		require_once OPL_PATH . 'inc/twitteroauth/twitteroauth.php';
		
		$opl = get_option('opl_settings');
		$tw_consumer = trim(opl_isset($opl['tw_consumer_key']));
		$tw_secret = trim(opl_isset($opl['tw_consumer_secret']));
		$post_id = (int) $_GET['opl_ID'];
		$permalink = get_permalink($post_id);
		
		if ( !($_COOKIE['__opl_twitter_id']) || ( $access_token = get_transient('access_token_' . opl_isset($_COOKIE['__opl_twitter_id'])) ) === FALSE ) {
			wp_redirect(opl_format_url($post_id, "opl_ID={$post_id}&share=twitter&action=oauth"));
			exit;
		}
		
		$connection = new TwitterOAuth($tw_consumer, $tw_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);
		$content = $connection->get('account/rate_limit_status');

		if ( $content->remaining_hits < 1 ) {
			echo "<script>alert('Could not connect to Twitter (reach limit). Please try again later.');\nwindow.location.href='{$permalink}';</script>";
			die;
		}
		
		$meta = get_post_meta($post_id, 'opl_settings', true);
		$viral = opl_isset($meta['viral']);
		$message = trim(stripslashes(strip_tags(opl_isset($viral['viral_tweet']))));
		
		$parameters = array('status' => $message);
		$status = $connection->post('statuses/update', $parameters);
		@setcookie('__opl_unlock_' . $post_id, 1, time()+60*60*24*365, SITECOOKIEPATH);
		wp_redirect($permalink . '#opl_viral_' . $post_id);
		exit;
	}
}

add_action('init', 'opl_tw_viral_oauth');
function opl_tw_viral_oauth(){
	if ( isset($_GET['opl_ID']) && opl_isset($_GET['share']) == 'twitter' && opl_isset($_GET['action']) == 'oauth' ) {
		
		// delete all cookies
		@setcookie('__opl_oauth_token', '', time()-60*60*24*2, SITECOOKIEPATH);
		@setcookie('__opl_oauth_token_secret', '', time()-60*60*24*2, SITECOOKIEPATH);
		
		// set unique id
		if ( !isset($_COOKIE['__opl_twitter_id']) )
			@setcookie('__opl_twitter_id', opl_tw_viral_id(), time()+60*60*24*365, SITECOOKIEPATH);
		
		require_once OPL_PATH . 'inc/twitteroauth/twitteroauth.php';
		
		$opl = get_option('opl_settings');
		$tw_consumer = trim(opl_isset($opl['tw_consumer_key']));
		$tw_secret = trim(opl_isset($opl['tw_consumer_secret']));
		$post_id = (int) $_GET['opl_ID'];
		
		$permalink = get_permalink($post_id);
		$callback_url = opl_format_url($post_id, "opl_ID={$post_id}&share=twitter&action=callback");
		
		$connection = new TwitterOAuth($tw_consumer, $tw_secret);
		$request_token = $connection->getRequestToken($callback_url);
		
		$oauth_token = $request_token['oauth_token'];
		$oauth_token_secret = $request_token['oauth_token_secret'];
		
		@setcookie('__opl_oauth_token', $oauth_token, 0, SITECOOKIEPATH);
		@setcookie('__opl_oauth_token_secret', $oauth_token_secret, 0, SITECOOKIEPATH);
		
		switch ( $connection->http_code ) {
  			case 200:
    			$auth_url = $connection->getAuthorizeURL($oauth_token);
    			wp_redirect($auth_url);
    			break;
  			default:
    			echo "<script>alert('Could not connect to Twitter. Refresh the page or try again later.');\nwindow.location.href='{$permalink}';</script>";
		}
		exit;
	}
}

add_action('init', 'opl_tw_viral_callback');
function opl_tw_viral_callback(){
	if ( isset($_GET['opl_ID']) && opl_isset($_GET['share']) == 'twitter' && opl_isset($_GET['action']) == 'callback' ) {
		require_once OPL_PATH . 'inc/twitteroauth/twitteroauth.php';
		
		$opl = get_option('opl_settings');
		$tw_consumer = trim(opl_isset($opl['tw_consumer_key']));
		$tw_secret = trim(opl_isset($opl['tw_consumer_secret']));
		$post_id = (int) $_GET['opl_ID'];
		$oauth_token = opl_isset($_COOKIE['__opl_oauth_token']);
		$oauth_token_secret = opl_isset($_COOKIE['__opl_oauth_token_secret']);
		
		$tweet_url = opl_format_url($post_id, "opl_ID={$post_id}&share=twitter&action=tweet");
		$auth_url = opl_format_url($post_id, "opl_ID={$post_id}&share=twitter&action=oauth");
		
		if ( isset($_GET['oauth_token']) && $oauth_token !== $_GET['oauth_token'] || !isset($_COOKIE['__opl_twitter_id']) ) {
  			wp_redirect($auth_url);
			exit;
		}
		
		$connection = new TwitterOAuth($tw_consumer, $tw_secret, $oauth_token, $oauth_token_secret);
		$access_token = $connection->getAccessToken($_GET['oauth_verifier']);

		set_transient( 'access_token_' . $_COOKIE['__opl_twitter_id'], $access_token, 60*60*24 );
		@setcookie('__opl_oauth_token', '', time()-60*60*24*2, SITECOOKIEPATH);
		@setcookie('__opl_oauth_token_secret', '', time()-60*60*24*2, SITECOOKIEPATH);
		
		if ( 200 == $connection->http_code ) {
  			wp_redirect($tweet_url);
		} else {
  			wp_redirect($auth_url);
		}
		exit;
	}
}

function opl_tw_viral_id(){
	$host = $_SERVER['HTTP_HOST'];
	$ip = $_SERVER['REMOTE_ADDR'];
	$rand = md5($host . $ip . time());
	
	return $rand;
}
