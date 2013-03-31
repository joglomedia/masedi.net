<?php
/*
Plugin Name: replyMail
Plugin URI: http://wanwp.com/plugins/replymail/
Description: Enhance the threaded comments system of WordPress 2.7. When someone reply to one's comment, send a email to him/her. &lt;<a href="options-general.php?page=replymail/settingPanel.php"><strong style="color:blue">Go to Setting Page</strong></a>&gt;
Author: 冰古
Version: 1.2.0
Author URI: http://bingu.net
License: GNU General Public License 2.0 http://www.gnu.org/licenses/gpl.html
*/

define('REPLYMAIL_VERSION', '1.2.0');
define('REPLYMAIL_BASEFOLDER', plugin_basename(dirname(__FILE__)));
if (defined('WP_INC_URL')) {
    define('WP_INC_URL', get_option('siteurl') . '/' . WPINC);
}

/**
 * check WordPress version, must 2.7+
 */
global $wp_version;
if (substr($wp_version, 0, 3) < 2.7){
    function rmWarning() {
        echo '<div class="updated fade"><p>'.__('replyMail can\'t work with this WordPress version, upgrade to the latest version!', 'replymail').'</p></div>';
    }
    add_action('admin_notices', 'rmWarning');
}else{
    /**
     * get replyMail plugin absolute dir.
     */
    $pluginDir = WP_PLUGIN_DIR . '/' . REPLYMAIL_BASEFOLDER;

    /**
     * get replyMail plugin url
     */
    $pluginUrl = WP_PLUGIN_URL . '/' . REPLYMAIL_BASEFOLDER;
    
    /**
     * open debug mode?
     */
    $rmDebug = FALSE;

    /**
     * load replyMail general functions.
     */
    require_once($pluginDir . '/replyMailFunctions.php');

    /**
     * init replyMail options
     */
    register_activation_hook(__FILE__, 'rmInitOptions');

    /**
     * Sent reply mail after one comment have been saved.
     */
    add_action('comment_post', 'rmReplyMail', 500);

    /**
     * If at wp-admin, load setting panel.
     */
    if (is_admin()) {
        require_once($pluginDir . '/settingPanel.php');
        // add a replyMail setting page.
        add_action('admin_menu', 'rmAddSettingPage');
        // add some extra style for replyMail setting page.
        add_action('admin_head', 'rmSettingCSS');
    }
}

/* EOF replyMail.php */
/* ./wp-content/plugins/replymail/replyMail.php */