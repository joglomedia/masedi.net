<?php
/*
Allows readers to receive notifications of new comments that are posted to an entry.
 Version: 1.1.2
 Author: wokamoto (http://dogmap.jp/)

License:
 Released under the GPL license
  http://www.gnu.org/copyleft/gpl.html

  Copyright 2008 wokamoto (email : wokamoto1973@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (class_exists('NotifyCommentAuthorController'))
	return false;

if (!class_exists('wokController') || !class_exists('wokScriptManager'))
	require(dirname(__FILE__).'/includes/common-controller.php');

if (!defined('QC_NOTIFY_EMAIL'))       define('QC_NOTIFY_EMAIL', '_qc_notify_email');
if (!defined('QC_NOTIFY_TWITTER'))     define('QC_NOTIFY_TWITTER', '_qc_notify_twitter');
if (!defined('QC_TWITTER_LOGIN_URL'))  define('QC_TWITTER_LOGIN_URL', 'http://twitter.com/account/verify_credentials');
if (!defined('QC_TWITTER_LOGOUT_URL')) define('QC_TWITTER_LOGOUT_URL', 'http://twitter.com/account/end_session');
if (!defined('QC_TWITTER_SENT_URL'))   define('QC_TWITTER_SENT_URL', 'http://twitter.com/statuses/update.json');
if (!defined('QC_TWITTER_MAX'))        define('QC_TWITTER_MAX', 140);
if (!defined('QC_TWITTER_TIMEOUT'))    define('QC_TWITTER_TIMEOUT', 30);
if (!defined('QC_TINYURL_URL'))        define('QC_TINYURL_URL', 'http://tinyurl.com/api-create.php?url=');

class NotifyCommentAuthorController extends wokController {
	var $plugin_name = 'notify-comment-author';
	var $plugin_ver  = '1.1.2';

	var $twitter_client_name = 'NotifyCommentAuthor';
	var $twitter_client_version = '1.1.2';
	var $twitter_client_url = 'http://wppluginsj.sourceforge.jp/notify-comment-author/';

	var $_options_default;

	/**********************************************************
	* Constructor
	***********************************************************/
	function NotifyCommentAuthorController() {
		$this->__construct();
	}
	function __construct() {
		global $quick_comments;

		$this->init(__FILE__);
		$this->options = $this->_initOptions($this->getOptions());

		if (isset($quick_comments) && $quick_comments->getOption('notifyCommentAuthor')) {
			if ($this->options['notify_email'] && !empty($this->options['site_email'])) {
				global $comment_notify_email;
				$comment_notify_email = (isset($_COOKIE['comment_notify_email_' . COOKIEHASH]) ? $_COOKIE['comment_notify_email_' . COOKIEHASH] == 'true' : false);
			}
			if ($this->options['notify_twitter'] && !empty($this->options['twitter_usr']) && !empty($this->options['twitter_pwd'])) {
				global $comment_author_twitter_ID;
				$comment_author_twitter_ID = (isset($_COOKIE['comment_author_twitter_' . COOKIEHASH]) ? $_COOKIE['comment_author_twitter_' . COOKIEHASH] : '');
			}
		}
	}

	/**********************************************************
	* Init Options
	***********************************************************/
	function _initOptions($options = '') {
		$this->_options_default = array(
			 'notify_email' => (get_option('comments_notify') ? true: false)
			,'notify_twitter' => (get_option('comments_notify') ? true: false)
			,'site_name' => get_bloginfo('name')
			,'site_email' => get_bloginfo('admin_email')
			,'twitter_usr' => (defined('TWITTER_USR') ? TWITTER_USR : '')
			,'twitter_pwd' => (defined('TWITTER_PWD') ? TWITTER_PWD : '')
			,'notify_twitter_usr' => (defined('NOTIFY_TWITTER_USR') ? NOTIFY_TWITTER_USR : '')
			,'tweet_txt' => sprintf(
				 __('[%1$s] New comment! #%2$s "%3$s": %4$s', $this->textdomain_name)
				,'%SITE_NAME%'
				,'%POST_NO%'
				,'%POST_TITLE%'
				,'%COMMENT%'
				)
			,'tweet_collectively' => false
			);

		$wk_options = get_option(' Options');
		if (is_array($wk_options)) {
			foreach ($this->_options_default as $key => $val) {
				$this->_options_default[$key] = (isset($wk_options[$key]) ? $wk_options[$key] : $val);
			}
		}

		if (!is_array($options)) $options = array();
		foreach ($this->_options_default as $key => $val) {
			$options[$key] = (isset($options[$key]) ? $options[$key] : $val);
		}
		return $options;
	}

	/**********************************************************
	* Custom Field
	***********************************************************/
	function setMetaData($comment_id, $comment_approved = '') {
		global $wpdb, $comment_notify_email, $comment_author_twitter_ID;

		if (empty($comment_approved)) $comment_approved = '1';
		if ('1' != $comment_approved) return;

		$comment = get_comment($comment_id);
		$post_id = $comment->comment_post_ID;

		if ($this->options['notify_email'] && isset($_POST['notify_email'])) {
			$comment_author_email = $comment->comment_author_email;
			$comment_notify_email = true;
			$meta_value = unserialize(get_post_meta($post_id, QC_NOTIFY_EMAIL, true));
			setcookie('comment_notify_email_' . COOKIEHASH, 'true', time() + 30000000, COOKIEPATH, COOKIE_DOMAIN);
			if (!is_array($meta_value)) $meta_value = array();
			if (!isset($meta_value[$comment_author_email])) {
				$meta_value[$comment_author_email] = array($comment_id);
			} else {
				$meta_value[$comment_author_email][] = $comment_id;
			}
			add_post_meta($post_id, QC_NOTIFY_EMAIL, serialize($meta_value), true) or
			 update_post_meta($post_id, QC_NOTIFY_EMAIL, serialize($meta_value));
			unset($meta_value);
		} elseif($this->options['notify_email']) {
			$comment_notify_email = false;
			setcookie('comment_notify_email_' . COOKIEHASH, 'false', time() + 30000000, COOKIEPATH, COOKIE_DOMAIN);
		}

		if ($this->options['notify_twitter'] && isset($_POST['twitterID'])) {
			$comment_author_twitter_ID = $wpdb->escape(trim($_POST['twitterID']));
			if (!empty($comment_author_twitter_ID)) {
				$meta_value = unserialize(get_post_meta($post_id, QC_NOTIFY_TWITTER, true));
				setcookie('comment_author_twitter_' . COOKIEHASH, $comment_author_twitter_ID, time() + 30000000, COOKIEPATH, COOKIE_DOMAIN);
				if (!is_array($meta_value)) $meta_value = array();
				if (!isset($meta_value[$comment_author_twitter_ID])) {
					$meta_value[$comment_author_twitter_ID] = array($comment_id);
				} else {
					$meta_value[$comment_author_twitter_ID][] = $comment_id;
				}
				add_post_meta($post_id, QC_NOTIFY_TWITTER, serialize($meta_value), true) or
				 update_post_meta($post_id, QC_NOTIFY_TWITTER, serialize($meta_value));
				unset($meta_value);
			}
		} else {
			$comment_author_twitter_ID = '';
		}
	}

	function deleteMetaData($comment_id) {
		$comment = get_comment($comment_id);
		$post_id = $comment->comment_post_ID;

		$meta_value = get_post_meta($post_id, QC_NOTIFY_EMAIL, true);
		if (!empty($meta_value) && is_array(unserialize($meta_value))) {
			$new_meta_value = array();
			foreach ((array) unserialize($meta_value) as $key => $val) {
				$new_val = array();
				foreach ((array) $val as $id) {
					if ($id != $comment_id) $new_val[] = $id;
				}
				if (count($new_val) > 0) $new_meta_value[$key] = $new_val;
				unset($new_val);
			}
			if (count($new_meta_value) > 0) {
				update_post_meta($post_id, QC_NOTIFY_EMAIL, serialize($new_meta_value));
			} else {
				delete_post_meta($post_id, QC_NOTIFY_EMAIL);
			}
			unset($new_meta_value);
		}
		$meta_value = '';

		$meta_value = get_post_meta($post_id, QC_NOTIFY_TWITTER, true);
		if (!empty($meta_value) && is_array(unserialize($meta_value))) {
			$new_meta_value = array();
			foreach ((array) unserialize($meta_value) as $key => $val) {
				$new_val = array();
				foreach ((array) $val as $id) {
					if ($id != $comment_id) $new_val[] = $id;
				}
				if (count($new_val) > 0) $new_meta_value[$key] = $new_val;
				unset($new_val);
			}
			if (count($new_meta_value) > 0) {
				update_post_meta($post_id, QC_NOTIFY_TWITTER, serialize($new_meta_value));
			} else {
				delete_post_meta($post_id, QC_NOTIFY_TWITTER);
			}
			unset($new_meta_value);
		}
		$meta_value = '';
	}

	/**********************************************************
	* Notify Comment Author
	***********************************************************/
	function notifyComment($comment_id, $comment_approved = '') {
		if (empty($comment_approved)) $comment_approved = '1';
		if ('1' == $comment_approved) {
			if ($this->options['notify_email'])
				$this->_doEmail($comment_id);
			if ($this->options['notify_twitter'])
				$this->_doTweet($comment_id);
		}
	}

	/**********************************************************
	* Notify Comment Author (EMail)
	***********************************************************/
	function _doEmail($comment_id, $comment_type='') {
		global $current_user;

		if (!$this->options['notify_email']) return false;

		$comment = get_comment($comment_id);
		$comment_type = (!empty($comment_type) ? $comment_type : (!empty($comment->comment_type) ? $comment->comment_type : 'comment'));
		if ('comment' != $comment_type) return;

		$post_id = $comment->comment_post_ID;
		$post = get_post($post_id);
		$user = get_userdata($post->post_author);
		$post_author_email = (!empty($user->user_email) ? $user->user_email : '');
		$meta_value = get_post_meta($post_id, QC_NOTIFY_EMAIL, true);

		$notify_users = array();
		if (empty($current_user->ID) && is_email($post_author_email) && !get_option('comments_notify'))
			$notify_users[] = $post_author_email;
		if (!empty($meta_value) && is_array(unserialize($meta_value))) {
			foreach ((array) unserialize($meta_value) as $key => $val) {
				if (is_email($key) && $key != $post_author_email && !in_array($key, $notify_users, false) && !in_array($comment_id, $val, false))
					$notify_users[] = $key;
			}
		}
		if (count($notify_users) > 0) {
			$message  = sprintf(__('There is a new comment on the post "%s"', $this->textdomain_name), $post->post_title) . "\n"
				. get_permalink($post_id) . "\n\n"
				. sprintf(__('Author: %s', $this->textdomain_name), $comment->comment_author) . "\n"
				. __('Comment:', $this->textdomain_name) . "\n"
				. strip_tags($comment->comment_content) . "\n\n"
				. __('See all comments on this post here:', $this->textdomain_name) . "\n"
				. get_permalink($post_id) . "#comments\n\n";

			$subject = sprintf(
				 __('[%1$s] New Comment On: %2$s', $this->textdomain_name)
				,$this->options['site_name']
				,$post->post_title
				);

			$headers = "From: \"{$this->options['site_name']}\" {$this->options['site_email']}\n"
				. "Content-Type: text/plain; charset=\"{$this->charset}\"\n";

			$message = apply_filters('comment_notification_text', $message, $comment_id);
			$subject = apply_filters('comment_notification_subject', $subject, $comment_id);
			$headers = apply_filters('comment_notification_headers', $headers, $comment_id);

			foreach ($notify_users as $email) {
				if ( $email != $comment->comment_author_email && is_email($email) ) {
					$this->_emailSend($email, $subject, $message, $headers);
				}
			}

		}
		unset($notify_users);

		$meta_value = '';
		unset($user);
		unset($post);
		unset($comment);
	}

	/**********************************************************
	* Notify Comment Author (Twitter)
	***********************************************************/
	function _doTweet($comment_id, $comment_type='') {
		global $current_user;

		if (!$this->options['notify_twitter']) return false;

		$comment = get_comment($comment_id);
		$comment_type = (!empty($comment_type) ? $comment_type : (!empty($comment->comment_type) ? $comment->comment_type : 'comment'));
		if ('comment' != $comment_type) return;

		$post_id = $comment->comment_post_ID;
		$post = get_post($post_id);
		$meta_value = get_post_meta($post_id, QC_NOTIFY_TWITTER, true);

		$notify_users = array();
		if (!empty($meta_value) && is_array(unserialize($meta_value))) {
			foreach ((array) unserialize($meta_value) as $key => $val) {
				if (!empty($key) && !in_array($key, $notify_users, false) && !in_array($comment_id, $val, false))
					$notify_users[] = $key;
			}
		}
		if (empty($current_user->ID)) {
			if (!empty($this->options['notify_twitter_usr']) && !in_array($this->options['notify_twitter_usr'], $notify_users, false))
				$notify_users[] = $this->options['notify_twitter_usr'];
		}
		$reply = '';
		foreach ($notify_users as $val) {
			$reply .= '@'.$val.' ';
		}

		if (!empty($reply)) {
			$message = str_replace(
				 array(
					 '%SITE_NAME%'
					,'%POST_NO%'
					,'%POST_TITLE%'
					,'%COMMENT_NO%'
					,'%COMMENT%'
					)
				,array(
					 $this->options['site_name']
					,$post_id
					,$post->post_title
					,$comment_id
					,preg_replace('/[\r\n ]+/', '', strip_tags($comment->comment_content))
					)
				,$this->options['tweet_txt']
				);
			$message = apply_filters('comment_notification_text', $message, $comment_id);
			$url = $this->_getTinyURL(get_permalink($post_id))."#comment-{$comment_id}";

			if ($this->options['tweet_collectively']) {
				$notify_msg = $reply.$message.$url;
				if (mb_strlen($notify_msg, $this->charset) >= QC_TWITTER_MAX)
					$notify_msg = $reply . mb_substr($message, 0, QC_TWITTER_MAX - (mb_strlen($reply.$url, $this->charset) + 4), $this->charset).'...' . $url;
				$this->_twitterPost($notify_msg, $this->options['twitter_usr'], $this->options['twitter_pwd']);
			} else {
				foreach ($notify_users as $val) {
					$reply = '@'.$val.' ';
					$notify_msg = $reply.$message.$url;
					if (mb_strlen($notify_msg, $this->charset) >= QC_TWITTER_MAX)
						$notify_msg = $reply . mb_substr($message, 0, QC_TWITTER_MAX - (mb_strlen($reply.$url, $this->charset) + 4), $this->charset).'...' . $url;
					$this->_twitterPost($notify_msg, $this->options['twitter_usr'], $this->options['twitter_pwd']);
				}
			}
		}

		$meta_value = '';
		unset($notify_users);
		unset($post);
		unset($comment);
	}

	/**********************************************************
	* Send E-Mail
	***********************************************************/
	function _emailSend($to, $subject, $message, $headers = '') {
		if (empty($to) || empty($subject) || empty($message))
			return false;

		if (empty($headers)) {
			// strip out some chars that might cause issues, and assemble vars
			$site_name = str_replace('"', "'", $this->options['site_name']);
			$site_email = str_replace(array('<', '>'), array('', ''), $this->options['site_email']);

			$headers = "From: \"{$site_name}\" <{$site_email}>\n"
				. "MIME-Version: 1.0\n"
				. "Content-Type: text/plain; charset=\"{$this->charset}\"\n";
		}

		return @wp_mail($to, $subject, $message, $headers);
	}

	/**********************************************************
	* Twitter Password Check
	***********************************************************/
	function chkTwitterPwd($username, $password) {
		if (empty($username) || empty($password)) return false;

		if (!class_exists('Snoopy'))
			require_once(dirname(__FILE__).'/includes/Snoopy.class.php');
		$snoop = new Snoopy;
		$snoop->agent = $this->twitter_client_name.' '.$this->twitter_client_url;
		$snoop->rawheaders = array(
			 'X-Twitter-Client' => $this->twitter_client_name
			,'X-Twitter-Client-Version' => $this->twitter_client_version
			,'X-Twitter-Client-URL' => $this->twitter_client_url
			);
		$snoop->user = $username;
		$snoop->pass = $password;
		$snoop->read_timeout = QC_TWITTER_TIMEOUT;
		$snoop->timed_out = true;
		$snoop->submit(QC_TWITTER_LOGIN_URL);
		$result = (strpos($snoop->results, 'Authorized') !== FALSE);
		if ($result)
			$snoop->submit(QC_TWITTER_LOGOUT_URL);
		unset($snoop);

		return ($result);
	}

	/**********************************************************
	* Post to Twitter!
	***********************************************************/
	function _twitterPost($tweet, $username, $password) {
		if (empty($tweet) || empty($username) || empty($password)) return false;

		if (!class_exists('Snoopy'))
			require_once(dirname(__FILE__).'/includes/Snoopy.class.php');
		$snoop = new Snoopy;
		$snoop->agent = $this->twitter_client_name.' '.$this->twitter_client_url;
		$snoop->rawheaders = array(
			 'X-Twitter-Client' => $this->twitter_client_name
			,'X-Twitter-Client-Version' => $this->twitter_client_version
			,'X-Twitter-Client-URL' => $this->twitter_client_url
			);
		$snoop->user = $username;
		$snoop->pass = $password;
		$snoop->read_timeout = QC_TWITTER_TIMEOUT;
		$snoop->timed_out = true;
		$snoop->submit(
			 QC_TWITTER_SENT_URL
			,array(
				 'status' => $tweet
				,'source' => $this->twitter_client_name
				)
			);
		$result = (strpos($snoop->response_code, '200') !== FALSE);
		unset($snoop);

		if (!$result) {
			$params = '?status=' . rawurlencode($tweet)
				. '&source=' . $this->twitter_client_name;
			$result = @file_get_contents(QC_TWITTER_SENT_URL.$params , false, stream_context_create(array(
				 "http" => array(
					"method" => "POST",
					"header" => "Authorization: Basic ". base64_encode($username. ":". $password)
					)
				))
			);
		}

		return ($result !== FALSE);
	}

	/**********************************************************
	* Get Tiny URL
	***********************************************************/
	function _getTinyURL($url = '') {
		if (empty($url)) return '';

		$buff = '';
		$url  = QC_TINYURL_URL . $url;
		if(function_exists('file_get_contents')) {
			$buff = @file_get_contents( $url );
		} else {
			$fp = @fopen($url, 'r');
			if($fp === FALSE) return '';
			while(!feof($fp)) {$buff .= fread( $fp, 1024 );}
			fclose($fp);
		}
		return $buff;
	}

	/**********************************************************
	* Add Admin Menu
	***********************************************************/
	function addAdminMenu() {
		$this->addOptionPage( __('Notify Comment Author', $this->textdomain_name), array($this,'optionPage'));
	}
	function optionPage() {
		global $quick_comments;

		if (isset($quick_comments) && !$quick_comments->getOption('notifyCommentAuthor')) {
			$this->note .= "<strong>".__('&quot;Notify Comment Author&quot; is not Enable!', $this->textdomain_name)."</strong>";
			$this->error++;

		} elseif (isset($_POST['ap_options_update'])) {
			// strip slashes array
			$_POST = $this->stripArray($_POST);

			$this->options['notify_email']       = (isset($_POST['ap_notify_email']) && $_POST['ap_notify_email'] == 'on' ? true : false);
			$this->options['notify_twitter']     = (isset($_POST['ap_notify_twitter']) && $_POST['ap_notify_twitter'] == 'on' ? true : false);
			$this->options['site_name']          = $_POST['ap_site_name'];
			$this->options['site_email']         = $_POST['ap_site_email'];
			$this->options['twitter_usr']        = $_POST['ap_twitter_usr'];
			$this->options['twitter_pwd']        = (!empty($_POST['ap_twitter_pwd']) ? $_POST['ap_twitter_pwd'] : $this->options['twitter_pwd']);
			$this->options['notify_twitter_usr'] = $_POST['ap_notify_twitter_usr'];
			$this->options['tweet_txt']          = $_POST['ap_tweet_txt'];
			$this->options['tweet_collectively'] = (isset($_POST['ap_tweet_collectively']) && $_POST['ap_tweet_collectively'] == 'on' ? true : false);

			// options update
			$this->updateOptions();
			// Done!
			$this->note .= "<strong>".__('Done!', $this->textdomain_name)."</strong>";

//			if ($this->options['notify_twitter'] ? $this->chkTwitterPwd($this->options['twitter_usr'], $this->options['twitter_pwd']) : true) {
//				// options update
//				$this->updateOptions();
//				// Done!
//				$this->note .= "<strong>".__('Done!', $this->textdomain_name)."</strong>";
//			} else {
//				// Username/Password incorrect!
//				$this->note .= "<strong>".sprintf(__('Username/Password incorrect for %s'), $this->options['twitter_usr'])."</strong>";
//			}

		} elseif(isset($_POST['ap_options_delete'])) {
			if ($this->wp25) check_admin_referer("delete_options", "_wpnonce_delete_options");

			// options delete
			$this->deleteSettings();

			// Done!
			$this->note .= "<strong>".__('Done!', $this->textdomain_name)."</strong>";
			$this->error++;
		}

		$out  = '';

		// Add Options
		$out .= "<div class=\"wrap\">\n";
		$out .= "<div>\n";
		$out .= "<h2>".__('Notify Comment Author Options', $this->textdomain_name)."</h2><br />\n";
		$out .= "<form method=\"post\" id=\"update_options\" action=\"".$this->admin_action."\">\n";
		if ($this->wp25) $out .= $this->makeNonceField("update_options", "_wpnonce_update_options", true, false);

		$out .= "<table class=\"optiontable form-table\" style=\"margin-top:0;\"><tbody>\n";

		$out .= "<tr>";
		$out .= "<th></th>";
		$out .= "<td>";
		$out .= "<input type=\"checkbox\" name=\"ap_notify_email\" id=\"ap_notify_email\" value=\"on\" style=\"margin-right:0.5em;\" ".($this->options['notify_email'] === true ? " checked=\"true\"" : "")." />";
		$out .= __('Notify the comment author with Email.', $this->textdomain_name);
		$out .= "</td>";
		$out .= "</tr>\n";

		$out .= "<tr>";
		$out .= "<th></th>";
		$out .= "<td>";
		$out .= "<input type=\"checkbox\" name=\"ap_notify_twitter\" id=\"ap_notify_twitter\" value=\"on\" style=\"margin-right:0.5em;\" ".($this->options['notify_twitter'] === true ? " checked=\"true\"" : "")." />";
		$out .= __('Notify the comment author with Twitter.', $this->textdomain_name)."<br />";
		$out .= "<input type=\"checkbox\" name=\"ap_tweet_collectively\" id=\"ap_tweet_collectively\" value=\"on\" style=\"margin-right:0.5em;\" ".($this->options['tweet_collectively'] === true ? " checked=\"true\"" : "")." />";
		$out .= __('The notification is collectively tweeted.', $this->textdomain_name);
		$out .= "</td>";
		$out .= "</tr>\n";

		$out .= "<tr>";
		$out .= "<th>".__('Site Name', $this->textdomain_name)."</th>";
		$out .= "<td><input type=\"text\" name=\"ap_site_name\" id=\"ap_site_name\" size=\"50\" value=\"{$this->options['site_name']}\" /></td>";
		$out .= "</tr>\n";

		$out .= "<tr>";
		$out .= "<th>".__('Site Email Address', $this->textdomain_name)."</th>";
		$out .= "<td><input type=\"text\" name=\"ap_site_email\" id=\"ap_site_email\" size=\"50\" value=\"{$this->options['site_email']}\" /></td>";
		$out .= "</tr>\n";

		$out .= "<tr>";
		$out .= "<th>".__('Twitter ID', $this->textdomain_name)."</th>";
		$out .= "<td><input type=\"text\" name=\"ap_twitter_usr\" id=\"ap_twitter_usr\" size=\"50\" value=\"{$this->options['twitter_usr']}\" /></td>";
		$out .= "</tr>\n";

		$out .= "<tr>";
		$out .= "<th>".__('Twitter Password', $this->textdomain_name)."</th>";
		$out .= "<td><input type=\"password\" name=\"ap_twitter_pwd\" id=\"ap_twitter_pwd\" size=\"50\" value=\"\" /></td>";
		$out .= "</tr>\n";

		$out .= "<tr>";
		$out .= "<th>".__('"Twitter ID" who notifies without fail', $this->textdomain_name)."</th>";
		$out .= "<td><input type=\"text\" name=\"ap_notify_twitter_usr\" id=\"ap_notify_twitter_usr\" size=\"50\" value=\"{$this->options['notify_twitter_usr']}\" /></td>";
		$out .= "</tr>\n";

		$out .= "<tr>";
		$out .= "<th>".__('Tweet text', $this->textdomain_name)."</th>";
		$out .= "<td>";
		$out .= "<input type=\"text\" name=\"ap_tweet_txt\" id=\"ap_tweet_txt\" size=\"50\" value=\"".htmlspecialchars($this->options['tweet_txt'])."\" /><br />";
		$out .= __('The following characters are converted respectively.', $this->textdomain_name).'<br />';
		$out .= '%SITE_NAME% - '.__('Site Name', $this->textdomain_name).'<br />';
		$out .= '%POST_NO% - '.__('Post No.', $this->textdomain_name).'<br />';
		$out .= '%POST_TITLE% - '.__('Post Title', $this->textdomain_name).'<br />';
		$out .= '%COMMENT_NO% - '.__('Comment No.', $this->textdomain_name).'<br />';
		$out .= '%COMMENT% - '.__('Excerpt of content of comment', $this->textdomain_name).'<br />';
		$out .= "</td>";
		$out .= "</tr>\n";

		$out .= "</tbody></table>";

		// Add Update Button
		$out .= "<p style=\"margin-top:1em\"><input type=\"submit\" name=\"ap_options_update\" class=\"button-primary\" value=\"".__('Update Options', $this->textdomain_name)." &raquo;\" class=\"button\" /></p>";
		$out .= "</form></div>\n";

		// Add Options
		$out .= "<div style=\"margin-top:2em;\">\n";
		$out .= "<h2>".__('Uninstall', $this->textdomain_name)."</h2><br />\n";
		$out .= "<form method=\"post\" id=\"delete_options\" action=\"".$this->admin_action."\">\n";

		if ($this->wp25) $out .= $this->makeNonceField("delete_options", "_wpnonce_delete_options", true, false);

		// Delete Button
		$out .= "<input type=\"submit\" name=\"ap_options_delete\" class=\"button-primary\" value=\"".__('Delete Options', $this->textdomain_name)." &raquo;\" class=\"button\" />";
		$out .= "</form></div>\n";

		// How To Use
		$out .= "<div style=\"margin-top:2em;margin-bottom:2em;\">\n";
		$out .= "<h2>".__('To use it by your theme', $this->textdomain_name)."</h2><br />\n";
		$out .= "<p>".__('You need to insert the following code snippet into the comments template.', $this->textdomain_name)."<br />";
		$out .= "wp-content/themes/&lt;name of theme&gt;/comments.php</p>";

		$out .= '<p><strong>'.__('Notify the comment author with Email.', $this->textdomain_name).'</strong></p>';
		$out .= '<pre style="margin-top:-1em;background:#F5F5F5 none repeat scroll 0 0;border:1px solid #DADADA;"><code>';
		$out .= '&lt;?php global $comment_notify_email; if (isset($comment_notify_email)) : ?&gt;<br />';
		$out .= ' &lt;p&gt;<br />';
		$out .= '  &lt;input type=&quot;checkbox&quot; name=&quot;notify_email&quot; id=&quot;notify_email&quot; value=&quot;on&quot; &lt;?php  echo $comment_notify_email ? \'checked=&quot;true&quot; \' : \'\'; ?&gt;/&gt;<br />';
		$out .= '  &lt;label for=&quot;notify_email&quot;&gt;'.__('When the comment is added to this post, the notification is received with mail.', $this->textdomain_name).'&lt;/label&gt;<br />';
		$out .= ' &lt;/p&gt;<br />';
		$out .= '&lt;?php endif; ?&gt;';
		$out .= '</code></pre>';

		$out .= '<p><strong>'.__('Notify the comment author with Twitter.', $this->textdomain_name).'</strong></p>';
		$out .= '<pre style="margin-top:-1em;background:#F5F5F5 none repeat scroll 0 0;border:1px solid #DADADA;"><code>';
		$out .= '&lt;?php global $comment_author_twitter_ID; if (isset($comment_author_twitter_ID)) : ?&gt;<br />';
		$out .= ' &lt;p&gt;<br />';
		$out .= '  &lt;input type=&quot;text&quot; name=&quot;twitterID&quot; id=&quot;twitterID&quot; value=&quot;&lt;?php echo $comment_author_twitter_ID; ?&gt;&quot; /&gt;<br />';
		$out .= '  &lt;label for=&quot;twitterID&quot;&gt;'.__('Twitter ID', $this->textdomain_name).'&lt;/label&gt;<br />';
		$out .= ' &lt;/p&gt;<br />';
		$out .= '&lt;?php endif; ?&gt;<br />';
		$out .= '</code></pre></div>'."\n";

		$out .= '</div>'."\n";

		// Output
		echo (!empty($this->note) ? "<div id=\"message\" class=\"updated fade\"><p>{$this->note}</p></div>\n" : '')."\n";
		echo ($this->error == 0 ? $out : '')."\n";
	}

	/**********************************************************
	* Delete Settings
	***********************************************************/
	function deleteSettings() {
		global $wpdb;

		$wpdb->query($wpdb->prepare(
			  "DELETE"
			 ." FROM $wpdb->postmeta"
			 ." WHERE meta_key in (%s, %s)"
			, $wpdb->escape(QC_NOTIFY_EMAIL)
			, $wpdb->escape(QC_NOTIFY_TWITTER)
			)
		);

		$this->deleteOptions();
		$this->options = $this->_initOptions();
	}
}

global $quick_comments, $notify_comment_author;

if (!isset($notify_comment_author)) {
	$notify_comment_author = new NotifyCommentAuthorController();
	add_action('admin_menu',     array(&$notify_comment_author, 'addAdminMenu'));
	if (isset($quick_comments) && $quick_comments->getOption('notifyCommentAuthor')) {
		add_action('comment_post',   array(&$notify_comment_author, 'setMetaData'), 10, 2);
		add_action('delete_comment', array(&$notify_comment_author, 'deleteMetaData'));
		add_action('comment_post',   array(&$notify_comment_author, 'notifyComment'), 10, 2);
	}
}
?>