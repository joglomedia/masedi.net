<?php
/*
Plugin Name: Quick Comments
Version: 0.7.2
Plugin URI: http://wppluginsj.sourceforge.jp/quick-comments/
Description: Post comments quickly without leaving or refreshing the page.
Author: wokamoto
Author URI: http://dogmap.jp/

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

Includes:
 jQuery 1.2.6 - New Wave Javascript
  Copyright (c) 2008 John Resig (jquery.com)
  Dual licensed under the MIT and GPL licenses.

 jQuery blockUI plugin (http://malsup.com/jquery/block/)
  Version 2.08 (06/11/2008)
  Copyright (c) 2007-2008 M. Alsup
  Dual licensed under the MIT and GPL licenses:

 jQuery.ScrollTo http://flesler.blogspot.com
  Version 1.4 (09/11/2008)
  Copyright (c) 2007-2008 Ariel Flesler - aflesler(at)gmail(dot)com | 
  Dual licensed under MIT and GPL.

*/

if (!class_exists('wokController') || !class_exists('wokScriptManager'))
	require(dirname(__FILE__).'/includes/common-controller.php');

class QuickCommentsController extends wokController {
	var $plugin_name  = 'quick-comments';
	var $plugin_ver   = '0.7.2';

	var $plugin_js    = 'js/quick-comments-0.7.0.min.js';

	var $blockUI_js   = 'js/jquery.blockUI.min.js';
	var $blockUI_ver  = '2.08';

	var $scrollto_js  = 'js/jquery.scrollTo-min.js';
	var $scrollto_ver = '1.4.2';

	var $_options_default;
	var $_effects, $_effect_speeds, $_editor_chk_mode;

	var $_isAddScripts;

	var $comment_ID, $_comments, $_comment_count;

	/*
	* Constructor
	*/
	function QuickCommentsController() {
		$this->__construct();
	}
	function __construct() {
		$this->init(__FILE__);

		$this->_effects = array(
			 "0" => __('Default', $this->textdomain_name)
			,"1" => __('Slide Down', $this->textdomain_name)
			,"2" => __('Fade In', $this->textdomain_name)
			);
		$this->_effect_speeds = array(
			 "fast"   => __('Fast', $this->textdomain_name)
			,"normal" => __('Normal', $this->textdomain_name)
			,"slow"   => __('Slow', $this->textdomain_name)
			);

		$this->_editor_chk_mode = array(
			 "1" => __('Simple check', $this->textdomain_name)
			,"2" => __('Severe check', $this->textdomain_name)
			);

		$this->options = $this->_initOptions($this->getOptions());
		$this->_isAddScripts = '';
		$this->comment_ID = false;
	}

	// Init Options
	function _initOptions($wk_options = '') {
		$update_options = false;

		$template = get_settings('template');
		if (!is_array($wk_options))
			$wk_options = array();
		if (!isset($wk_options['template']))
			$wk_options['template'] = $template;

		$this->_options_default = array(
			 'form' => 'form#commentform'
			,'list' => 'ol.commentlist:first'
			,'message' => __('Please wait', $this->textdomain_name).'...'
			,'message2'=> __('Loading', $this->textdomain_name).'...'
			,'loader' => $this->plugin_url.'images/ajax-loader.gif'
			,'messageCSS' => "border:1px solid #8C8C8C; font:normal 12px Arial;"
			,'overlayCSS' => "backgroundColor:#FFF; opacity:0.6;"
			,'effect' => 0
			,'speed' => "fast"
			,'editMode'=> false
			,'editMin' => 30
			,'editName' => false
			,'editEmail' => false
			,'editUrl' => false
			,'editIcon' => '<span style="float:right;"><img src="'.$this->plugin_url.'images/edit.png" title="'.__('Edit comment').'" alt="'.__('Edit comment').'" style="float:left;margin:0 .25em;border:none;" />'.__('Edit comment').'</span>'
			,'editReturn' => '#edit-comment-%ID%'
			,'editorChk' => 1
			,'editButton' => __('Update Comment', $this->textdomain_name)
			,'setEditIcon' => true
			,'notifyUpdate' => false
			,'rejectSpamIP' => false
			,'notifyCommentAuthor' => false
			,'sendToGzip' => true
			,'lastCommentOnly' => true
			);

		if ( preg_match('/^(default|clockworkmint)/i', $template) ) {
			$this->_options_default['form'] = 'form#commentform';
			$this->_options_default['list'] = 'ol.commentlist:first';
			$this->_options_default['editReturn'] = '#comment-%ID%';
			$update_options = ($wk_options['template'] != $template);
		} elseif ( preg_match('/^(classic|easyall|k2)/i', $template) ) {
			$this->_options_default['form'] = 'form#commentform';
			$this->_options_default['list'] = 'ol#commentlist';
			$this->_options_default['editReturn'] = '#comment-%ID%';
			$update_options = ($wk_options['template'] != $template);
		} elseif ( preg_match('/^wp.vicuna/i', $template) ) {
			$this->_options_default['form'] = 'form#commentsForm';
			$this->_options_default['list'] = 'dl.log:first';
			$this->_options_default['editReturn'] = '#comment%ID%';
			$this->_options_default['lastCommentOnly'] = false;
			$update_options = ($wk_options['template'] != $template);
		} elseif ( preg_match('/^sandbox/i', $template) ) {
			$this->_options_default['form'] = 'form#commentform';
			$this->_options_default['list'] = 'div#comments-list ol:first';
			$this->_options_default['editReturn'] = '#comment-%ID%';
			$update_options = ($wk_options['template'] != $template);
		} elseif ( preg_match('/^inove/i', $template) ) {
			$this->_options_default['form'] = 'form#commentform';
			$this->_options_default['list'] = 'ol#thecomments';
			$this->_options_default['editReturn'] = '#comment-%ID%';
			$update_options = ($wk_options['template'] != $template);
		} else {
			$this->_options_default['form'] = 'form#commentform';
			$this->_options_default['list'] = 'ol.commentlist:first';
			$this->_options_default['editReturn'] = '#comment-%ID%';
			$update_options = false;
		}

		if (!isset($wk_options['form']))        $wk_options['form']        = $this->_options_default['form'];
		if (!isset($wk_options['list']))        $wk_options['list']        = $this->_options_default['list'];
		if (!isset($wk_options['message']))     $wk_options['message']     = $this->_options_default['message'];
		if (!isset($wk_options['message2']))    $wk_options['message2']    = $this->_options_default['message2'];
		if (!isset($wk_options['loader']))      $wk_options['loader']      = $this->_options_default['loader'];
		if (!isset($wk_options['messageCSS']))  $wk_options['messageCSS']  = $this->_options_default['messageCSS'];
		if (!isset($wk_options['overlayCSS']))  $wk_options['overlayCSS']  = $this->_options_default['overlayCSS'];
		if (!isset($wk_options['effect']))      $wk_options['effect']      = $this->_options_default['effect'];
		if (!isset($wk_options['speed']))       $wk_options['speed']       = $this->_options_default['speed'];
		if (!isset($wk_options['editMode']))    $wk_options['editMode']    = $this->_options_default['editMode'];
		if (!isset($wk_options['editMin']))     $wk_options['editMin']     = $this->_options_default['editMin'];
		if (!isset($wk_options['editName']))    $wk_options['editName']    = $this->_options_default['editName'];
		if (!isset($wk_options['editEmail']))   $wk_options['editEmail']   = $this->_options_default['editEmail'];
		if (!isset($wk_options['editUrl']))     $wk_options['editUrl']     = $this->_options_default['editUrl'];
		if (!isset($wk_options['editIcon']))    $wk_options['editIcon']    = $this->_options_default['editIcon'];
		if (!isset($wk_options['editReturn']))  $wk_options['editReturn']  = $this->_options_default['editReturn'];
		if (!isset($wk_options['editorChk']))   $wk_options['editorChk']   = $this->_options_default['editorChk'];
		if (!isset($wk_options['editButton']))  $wk_options['editButton']  = $this->_options_default['editButton'];
		if (!isset($wk_options['setEditIcon'])) $wk_options['setEditIcon'] = $this->_options_default['setEditIcon'];
		if (!isset($wk_options['notifyUpdate']))$wk_options['notifyUpdate']= $this->_options_default['notifyUpdate'];
		if (!isset($wk_options['rejectSpamIP']))$wk_options['rejectSpamIP']= $this->_options_default['rejectSpamIP'];
		if (!isset($wk_options['notifyCommentAuthor']))$wk_options['notifyCommentAuthor']= $this->_options_default['notifyCommentAuthor'];
		if (!isset($wk_options['lastCommentOnly']))$wk_options['lastCommentOnly']= $this->_options_default['lastCommentOnly'];
		if (!isset($wk_options['template']))	$wk_options['template']= $template;

		// options update
		if ($update_options) {
			$wk_options['form']        = $this->_options_default['form'];
			$wk_options['list']        = $this->_options_default['list'];
			$wk_options['editReturn']  = $this->_options_default['editReturn'];
			$wk_options['lastCommentOnly'] = $this->_options_default['lastCommentOnly'];
			$wk_options['template']    = $template;
			$this->options = $wk_options;
			$this->updateOptions();
		}

		return $wk_options;
	}

	// Get Options for Javascript
	function _getJsOptions() {
		global $user_ID;

		$out  = "var quickCommentsL10n = {";
		$out .= "form:'{$this->options['form']}'";
		$out .= ",list:'{$this->options['list']}'";
		$out .= ",message:'{$this->options['message']}'";
		$out .= ",loader:'{$this->options['loader']}'";
		if ( get_settings('require_name_email') && !$user_ID ) {
			$out .= ",requireNameEmail:true";
			$out .= ",errMsgNameEmail:'".__('Error: please fill the required fields (name, email).')."'";
		}
		$out .= ",errMsgEmail:'".__('Error: please enter a valid email address.')."'";
		$out .= ",errMsgCommentNone:'".__('Error: please type a comment.')."'";

		if ($this->options['messageCSS'] != $this->_options_default['messageCSS']) {
			$messageCSS = preg_split('/[,;]/', $this->options['messageCSS'], -1, PREG_SPLIT_NO_EMPTY);
			if (is_array($messageCSS) && count($messageCSS) > 0) {
				$out .= ",messageCSS:{";
				$count = 0;
				foreach ($messageCSS as $value) {
					if ($count++ >= 1) $out .= ',';
					$out .= preg_replace("/^([^:]*)[ \t]*:[ \t]*(.*)$/", "$1:'$2'", trim($value));
				}
				$out .= "}";
			}
		}

		if ($this->options['overlayCSS'] != $this->_options_default['overlayCSS']) {
			$overlayCSS = preg_split('/[,;]/', $this->options['overlayCSS'], -1, PREG_SPLIT_NO_EMPTY);
			if (is_array($overlayCSS) && count($overlayCSS) > 0) {
				$out .= ",overlayCSS:{";
				$count = 0;
				foreach ($overlayCSS as $value) {
					if ($count++ >= 1) $out .= ',';
					$out .= preg_replace("/^([^:]*)[ \t]*:[ \t]*(.*)$/", "$1:'$2'", trim($value));
				}
				$out .= "}";
			}
		}

		if ($this->options['effect'] != $this->_options_default['effect']) $out .= ",effect:".(int)$this->options['effect'];
		if ($this->options['speed'] != $this->_options_default['speed']) $out .= ",speed:'{$this->options['speed']}'";
		if ($this->options['editMode']) {
			$out .= ",message2:'{$this->options['message2']}'";
			$out .= ",update:'{$this->plugin_url}{$this->plugin_file}'";
			$out .= ",editReturn:'{$this->options['editReturn']}'";
			$out .= ",editButtonLabel:'{$this->options['editButton']}'";
			$out .= ",editDisabled:{";
			$out .= "author:".($this->options['editName'] ? 'false' : 'true');
			$out .= ",email:".($this->options['editEmail'] ? 'false' : 'true');
			$out .= ",url:".($this->options['editUrl'] ? 'false' : 'true');
			$out .= "}";
		}

		$out .= "};\n";

		return $out;
	}

	// Remove k2.comment
	function removeK2Comments($args) {
		$k2comments_pos = array_search('k2comments', $args);
		if(false !== $k2comments_pos) {
			array_splice($args, $k2comments_pos, 1);
		}
		return $args;
	}

	// Add Scripts ? (single or page, comments open, and not mobile access)
	function _isAddScripts() {
		if ('' === $this->_isAddScripts)
			$this->_isAddScripts = (is_single() || is_page()) && comments_open() && !$this->isKtai();
		return ($this->_isAddScripts === true);
	}

	// Regist Javascript
	function addScripts() {
		if ($this->_isAddScripts()) {
			$this->addjQuery();	// regist jQuery
			wp_enqueue_script('jquery.blockUI',  $this->plugin_url.$this->blockUI_js,   array('jquery'), $this->blockUI_ver);
			wp_enqueue_script('jquery.scrollTo', $this->plugin_url.$this->scrollto_js,  array('jquery'), $this->scrollto_ver);
		}
	}

	// Regist Javascript (for WordPress 2.0.x)
	function addHeadScripts() {
		if ($this->_isAddScripts()) {
			$out  = "<script type=\"text/javascript\" src=\"{$this->plugin_url}{$this->jquery_js}\"></script>\n";
			if (eregi("chrome", $_SERVER['HTTP_USER_AGENT']))
				$out .= "<script type=\"text/javascript\" src=\"{$this->plugin_url}{$this->forChrome_js}\"></script>\n";
			$out .= "<script type=\"text/javascript\" src=\"{$this->plugin_url}{$this->blockUI_js}\"></script>\n";
			$out .= "<script type=\"text/javascript\" src=\"{$this->plugin_url}{$this->scrollto_js}\"></script>\n";
			echo $out;
			$this->addHead();
		}
	}

	// Add Header Javascript
	function addHead() {
		if ($this->_isAddScripts()) {
			$this->writeScript($this->_getJsOptions(), 'head');
			add_action('wp_footer', array(&$this,'addFooter'));
		}
	}

	// Add Footer Javascript
	function addFooter() {
		if ($this->_isAddScripts()) {
			$out  = "<script type=\"text/javascript\" src=\"".$this->plugin_url.$this->plugin_js."\" charset=\"UTF-8\"></script>\n";
			echo $out;
		}
	}

	// Add Admin Menu
	function addAdminMenu() {
		$this->addOptionPage( __('Quick Comments', $this->textdomain_name), array($this,'optionPage'));
		add_action('admin_print_scripts-'.$this->admin_hook['option'], array($this,'addAdminScripts'));
		add_action('admin_head-'.$this->admin_hook['option'], array($this,'addAdminHead'));
	}

	function addAdminScripts() {
		$this->addjQuery();	// regist jQuery
	}

	function addAdminHead() {
		$out  = '';

		$out .= "<script type=\"text/javascript\">//<![CDATA[\n";
		$out .= "if (typeof addLoadEvent == 'undefined') addLoadEvent = function(func) {if (typeof jQuery != 'undefined') jQuery(document).ready(func); else if (typeof wpOnload!='function'){wpOnload=func;} else {var oldonload=wpOnload; wpOnload=function(){oldonload();func();}}};\n";
		$out .= "addLoadEvent(function(){\n";

		$out .= "if (!jQuery('input[name^=ap_editMode]').attr('checked')){";
		$out .= "jQuery('tr.commentedit div, select.commentedit').slideUp(function(){jQuery('tr.commentedit').css({display:'none'});});";
		$out .= "}";

		$out .= "jQuery('input[name^=ap_editMode]').unbind('click').click(function(){";
		$out .= "if (this.checked) {";
		$out .= "jQuery('tr.commentedit').css({display:'table-row'});";
		$out .= "jQuery('tr.commentedit div, select.commentedit').slideDown();";
		$out .= "} else {";
		$out .= "jQuery('tr.commentedit div, select.commentedit').slideUp(function(){jQuery('tr.commentedit').css({display:'none'});});";
		$out .= "}";
		$out .= "});";

		$out .= "});\n";
		$out .= "//]]></script>\n";

		echo $out;
	}

	// Show Option Page
	function optionPage() {
		$template = get_settings('template');

		if (isset($_POST['ap_options_update'])) {
			if ($this->wp25) check_admin_referer("update_options", "_wpnonce_update_options");

			// strip slashes array
			$_POST = $this->stripArray($_POST);

			// get options
			$this->options['form']        = $_POST['ap_form'];
			$this->options['list']        = $_POST['ap_list'];
			$this->options['message']     = $_POST['ap_message'];
			$this->options['message2']    = $_POST['ap_message2'];
			$this->options['loader']      = $_POST['ap_loader'];
			$this->options['messageCSS']  = $_POST['ap_messageCSS'];
			$this->options['overlayCSS']  = $_POST['ap_overlayCSS'];
			$this->options['effect']      = $_POST['ap_effect'];
			$this->options['speed']       = $_POST['ap_speed'];

			$this->options['editMode']    = (isset($_POST['ap_editMode']) && $_POST['ap_editMode'] == 'on' ? true : false);
			$this->options['editMin']     = (int) $_POST['ap_editMin'];
			$this->options['editName']    = (isset($_POST['ap_editName']) && $_POST['ap_editName'] == 'on' ? true : false);
			$this->options['editEmail']   = (isset($_POST['ap_editEmail']) && $_POST['ap_editEmail'] == 'on' ? true : false);
			$this->options['editUrl']     = (isset($_POST['ap_editUrl']) && $_POST['ap_editUrl'] == 'on' ? true : false);
			$this->options['editIcon']    = $_POST['ap_editIcon'];
			$this->options['editReturn']  = $_POST['ap_editReturn'];
			$this->options['editorChk']   = ($_POST['ap_editorChk'] == "1" ? 1 : 2);
			$this->options['editButton']  = $_POST['ap_editButton'];
			$this->options['setEditIcon'] = (isset($_POST['ap_setEditIcon']) && $_POST['ap_setEditIcon'] == 'on' ? true : false);
			$this->options['notifyUpdate']= (isset($_POST['ap_notifyUpdate']) && $_POST['ap_notifyUpdate'] == 'on' ? true : false);
			$this->options['rejectSpamIP']= (isset($_POST['ap_rejectSpamIP']) && $_POST['ap_rejectSpamIP'] == 'on' ? true : false);
			$this->options['notifyCommentAuthor']= (isset($_POST['ap_notifyCommentAuthor']) && $_POST['ap_notifyCommentAuthor'] == 'on' ? true : false);
			$this->options['sendToGzip'] = (isset($_POST['ap_sendToGzip']) && $_POST['ap_sendToGzip'] == 'on' ? true : false);
			if ( preg_match('/^wp.vicuna/i', $template) ) {
				$this->options['lastCommentOnly'] = false;
			} else {
				$this->options['lastCommentOnly'] = (isset($_POST['ap_lastCommentOnly']) && $_POST['ap_lastCommentOnly'] == 'on' ? true : false);
			}

			$this->options['template'] = $template;
			$_POST = '';

			// options update
			$this->updateOptions();

			// Done!
			$this->note .= "<strong>".__('Done!', $this->textdomain_name)."</strong>";

		} elseif(isset($_POST['ap_options_delete'])) {
			if ($this->wp25) check_admin_referer("delete_options", "_wpnonce_delete_options");

			// options delete
			$this->deleteOptions();
			$this->options = $this->_initOptions();

			// Notify Comment Author settings delete
			global $notify_comment_author;
			if (isset($notify_comment_author))
				$notify_comment_author->deleteSettings();

			// Done!
			$this->note .= "<strong>".__('Done!', $this->textdomain_name)."</strong>";
			$this->error++;
		}

		$out  = '';

		// Add Options
		$out .= "<div class=\"wrap\">\n";
		$out .= "<h2>".__('Quick Comments Options', $this->textdomain_name)."</h2><br />\n";
		$out .= "<form method=\"post\" id=\"update_options\" action=\"".$this->admin_action."\">\n";
		if ($this->wp25) $out .= $this->makeNonceField("update_options", "_wpnonce_update_options", true, false);

		$out .= "<table class=\"optiontable form-table\" style=\"margin-top:0;\"><tbody>\n";

		// Form
		$out .= "<tr>";
		$out .= "<th>".__('Comment Form CSS Path', $this->textdomain_name)."</th>";
		$out .= "<td><input type=\"text\" name=\"ap_form\" id=\"ap_form\" size=\"50\" value=\"".$this->options['form']."\" /></td>";
		$out .= "</tr>\n";

		// List
		$out .= "<tr>";
		$out .= "<th>".__('Comment List CSS Path', $this->textdomain_name)."</th>";
		$out .= "<td><input type=\"text\" name=\"ap_list\" id=\"ap_list\" size=\"50\" value=\"".$this->options['list']."\" /></td>";
		$out .= "</tr>\n";

		// Wait Message
		$out .= "<tr>";
		$out .= "<th>".__('Wait Message', $this->textdomain_name)."</th>";
		$out .= "<td><input type=\"text\" name=\"ap_message\" id=\"ap_message\" size=\"50\" value=\"".$this->options['message']."\" /></td>";
		$out .= "</tr>\n";

		// Loading Image
		$out .= "<tr>";
		$out .= "<th>".__('Loading Image', $this->textdomain_name)."</th>";
		$out .= "<td><input type=\"text\" name=\"ap_loader\" id=\"ap_loader\" size=\"50\" value=\"".$this->options['loader']."\" /></td>";
		$out .= "</tr>\n";

		// Message CSS
		$out .= "<tr>";
		$out .= "<th>".__('Message CSS', $this->textdomain_name)."</th>";
		$out .= "<td><input type=\"text\" name=\"ap_messageCSS\" id=\"ap_messageCSS\" size=\"50\" value=\"".$this->options['messageCSS']."\" /></td>";
		$out .= "</tr>\n";

		// Overlay CSS
		$out .= "<tr>";
		$out .= "<th>".__('Overlay CSS', $this->textdomain_name)."</th>";
		$out .= "<td><input type=\"text\" name=\"ap_overlayCSS\" id=\"ap_overlayCSS\" size=\"50\" value=\"".$this->options['overlayCSS']."\" /></td>";
		$out .= "</tr>\n";

		// Effect
		$out .= "<tr>";
		$out .= "<th>".__('Effect', $this->textdomain_name)."</th>";
		$out .= "<td>";
		$out .= "<select name=\"ap_effect\">";
		foreach($this->_effects as $key => $value) {
			$out .= "<option value=\"{$key}\"".($this->options['effect']==$key ? " selected=\"true\"": "").">{$value}</option>";
		}
		$out .= "</select>";

		$out .= "<select name=\"ap_speed\" style=\"margin-left:1em;\">";
		foreach($this->_effect_speeds as $key => $value) {
			$out .= "<option value=\"{$key}\"".($this->options['speed']==$key ? " selected=\"true\"": "").">{$value}</option>";
		}
		$out .= "</select>";
		$out .= "</td>";
		$out .= "</tr>\n";

		// Last Comment Only
		if ( preg_match('/^wp.vicuna/i', $template) !== FALSE ) {
			$out .= "<tr>";
			$out .= "<th><div>".__('Only the changed comment is sent.', $this->textdomain_name)."</div></th>";
			$out .= "<td><div>";
			$out .= "<input type=\"checkbox\" name=\"ap_lastCommentOnly\" value=\"on\" style=\"margin-right:0.5em;\" ".($this->options['lastCommentOnly'] === true ? " checked=\"true\"" : "")." />";
			$out .= __('Enable', $this->textdomain_name);
			$out .= "</div></td>";
			$out .= "</tr>\n";
		}

		// Send to Gzip
		$out .= "<tr>";
		$out .= "<th><div>".__('Should compress comments (gzip) if browsers ask for them.', $this->textdomain_name)."</div></th>";
		$out .= "<td><div>";
		$out .= "<input type=\"checkbox\" name=\"ap_sendToGzip\" value=\"on\" style=\"margin-right:0.5em;\" ".($this->options['sendToGzip'] === true ? " checked=\"true\"" : "")." />";
		$out .= __('Enable', $this->textdomain_name);
		$out .= "</div></td>";
		$out .= "</tr>\n";


		// Allows users to edit their comments?
		$out .= "<tr>";
		$out .= "<th>".__('Allows users to edit their comments?', $this->textdomain_name)."</th>";
		$out .= "<td>";
		$out .= "<input type=\"checkbox\" name=\"ap_editMode\" value=\"on\" style=\"margin-right:0.5em;\" ".($this->options['editMode'] === true ? " checked=\"true\"" : "")." />";
		$out .= __('Allows users to edit their comments for a limited number of minutes after posting.', $this->textdomain_name)."<br />";
		$out .= "<select name=\"ap_editorChk\" class=\"commentedit\">";
		foreach($this->_editor_chk_mode as $key => $value) {
			$out .= "<option value=\"{$key}\"".($this->options['editorChk']==$key ? " selected=\"true\"": "").">{$value}</option>";
		}
		$out .= "</select>";
		$out .= "</td>";
		$out .= "</tr>\n";

		// Time Limit
		$out .= "<tr class=\"commentedit\">";
		$out .= "<th><div>".__('Number of minutes that users are allowed to edit their comment', $this->textdomain_name)."</div></th>";
		$out .= "<td><div>";
		$out .= "<input type=\"text\" name=\"ap_editMin\" id=\"ap_editMin\" size=\"5\" value=\"".$this->options['editMin']."\" />&nbsp;".__('minutes after posting', $this->textdomain_name);
		$out .= "</div></td>";
		$out .= "</tr>\n";

		// Item that permits edit
		$out .= "<tr class=\"commentedit\">";
		$out .= "<th><div>".__('Item that permits edit', $this->textdomain_name)."</div></th>";
		$out .= "<td><div>";
		$out .= "<input type=\"checkbox\" name=\"ap_editName\" value=\"on\" style=\"margin-right:0.5em;\" ".($this->options['editName'] === true ? " checked=\"true\"" : "")." />";
		$out .= __('Name', $this->textdomain_name)."&nbsp;&nbsp;&nbsp;";
		$out .= "<input type=\"checkbox\" name=\"ap_editEmail\" value=\"on\" style=\"margin-right:0.5em;\" ".($this->options['editEmail'] === true ? " checked=\"true\"" : "")." />";
		$out .= __('Email', $this->textdomain_name)."&nbsp;&nbsp;&nbsp;";
		$out .= "<input type=\"checkbox\" name=\"ap_editUrl\" value=\"on\" style=\"margin-right:0.5em;\" ".($this->options['editUrl'] === true ? " checked=\"true\"" : "")." />";
		$out .= __('Website', $this->textdomain_name)."&nbsp;&nbsp;&nbsp;";
		$out .= "</div></td>";
		$out .= "</tr>\n";

		// Loading Message
		$out .= "<tr class=\"commentedit\">";
		$out .= "<th><div>".__('Comment Loading Message', $this->textdomain_name)."</div></th>";
		$out .= "<td><div>";
		$out .= "<input type=\"text\" name=\"ap_message2\" id=\"ap_message2\" size=\"50\" value=\"".$this->options['message2']."\" />";
		$out .= "</div></td>";
		$out .= "</tr>\n";

		// Edit Icon
		$out .= "<tr class=\"commentedit\">";
		$out .= "<th><div>".__('Edit icon', $this->textdomain_name)."</div></th>";
		$out .= "<td><div>";
		$out .= "<input type=\"text\" name=\"ap_editIcon\" id=\"ap_editIcon\" size=\"50\" value=\"".str_replace('"', '&quot;', wp_specialchars($this->options['editIcon']))."\" /><br />";
		$out .= "<input type=\"checkbox\" name=\"ap_setEditIcon\" value=\"on\" style=\"margin-right:0.5em;\" ".($this->options['setEditIcon'] === true ? " checked=\"true\"" : "")." />";
		$out .= __('Automatically display it', $this->textdomain_name);
		$out .= "</div></td>";
		$out .= "</tr>\n";

		// Edit Button Label
		$out .= "<tr class=\"commentedit\">";
		$out .= "<th><div>".__('Edit button label', $this->textdomain_name)."</div></th>";
		$out .= "<td><div>";
		$out .= "<input type=\"text\" name=\"ap_editButton\" id=\"ap_editButton\" size=\"50\" value=\"".str_replace('"', '&quot;', wp_specialchars($this->options['editButton']))."\" />";
		$out .= "</div></td>";
		$out .= "</tr>\n";

		// Position that returns after it edits it (CSS path)
		$out .= "<tr class=\"commentedit\">";
		$out .= "<th><div>".__('Position that returns after it edits it', $this->textdomain_name)."</div></th>";
		$out .= "<td><div>";
		$out .= "<input type=\"text\" name=\"ap_editReturn\" id=\"ap_editReturn\" size=\"30\" value=\"{$this->options['editReturn']}\" />";
		$out .= __('css path (%ID% is converted into comment ID.)', $this->textdomain_name);
		$out .= "</div></td>";
		$out .= "</tr>\n";

		// Reject SPAM
		$out .= "<tr>";
		$out .= "<th><div>".__('Reject SPAM', $this->textdomain_name)."</div></th>";
		$out .= "<td><div>";
		$out .= "<input type=\"checkbox\" name=\"ap_rejectSpamIP\" value=\"on\" style=\"margin-right:0.5em;\" ".($this->options['rejectSpamIP'] === true ? " checked=\"true\"" : "")." />";
		$out .= __('Reject SPAM. (IP Address is registered in the DNSBL &quot;<a href="http://spam-champuru.livedoor.com/dnsbl/">SPAM Champuru</a>&quot;)', $this->textdomain_name);
		$out .= "</div></td>";
		$out .= "</tr>\n";

//		// Notify Update
//		$out .= "<tr>";
//		$out .= "<th><div>".__('Notify Update', $this->textdomain_name)."</div></th>";
//		$out .= "<td><div>";
//		$out .= "<input type=\"checkbox\" name=\"ap_notifyUpdate\" value=\"on\" style=\"margin-right:0.5em;\" ".($this->options['notifyUpdate'] === true ? " checked=\"true\"" : "")." />";
//		$out .= __('Enable', $this->textdomain_name);
//		$out .= "</div></td>";
//		$out .= "</tr>\n";

		// Notify Comment Author
		$out .= "<tr>";
		$out .= "<th><div>".__('Notify Comment Author', $this->textdomain_name)."</div></th>";
		$out .= "<td><div>";
		$out .= "<input type=\"checkbox\" name=\"ap_notifyCommentAuthor\" value=\"on\" style=\"margin-right:0.5em;\" ".($this->options['notifyCommentAuthor'] === true ? " checked=\"true\"" : "")." />";
		$out .= __('Enable', $this->textdomain_name);
		$out .= "</div></td>";
		$out .= "</tr>\n";

		$out .= "</tbody></table>";

		// Add Update Button
		$out .= "<p style=\"margin-top:1em\"><input type=\"submit\" name=\"ap_options_update\" value=\"".__('Update Options', $this->textdomain_name)." &raquo;\" class=\"button\" /></p>";
		$out .= "</form></div>\n";

		// Add Options
		$out .= "<div class=\"wrap\" style=\"margin-top:2em;\">\n";
		$out .= "<h2>".__('Uninstall', $this->textdomain_name)."</h2><br />\n";
		$out .= "<form method=\"post\" id=\"delete_options\" action=\"".$this->admin_action."\">\n";

		if ($this->wp25) $out .= $this->makeNonceField("delete_options", "_wpnonce_delete_options", true, false);

		// Delete Button
		$out .= "<input type=\"submit\" name=\"ap_options_delete\" value=\"".__('Delete Options', $this->textdomain_name)." &raquo;\" class=\"button\" />";
		$out .= "</form></div>\n";

		// How To Use
		$out .= "<div class=\"wrap\" style=\"margin-top:2em;\">\n";
		$out .= "<h2>".__('To use it by your theme', $this->textdomain_name)."</h2><br />\n";
		$out .= "<p>";
		$out .= __('When you remove the check on &quot;Automatically display it&quot; of the comment edit icon.', $this->textdomain_name)."<br />";
		$out .= __('Please insert the following codes in the template to display the comment edit icon.', $this->textdomain_name)."<br />";
		$out .= "wp-content/themes/&lt;name of theme&gt;/comments.php</p>";

		$out .= '<pre style="background:#F5F5F5 none repeat scroll 0 0;border:1px solid #DADADA;"><code>';
		$out .= '&lt;?php if (function_exists(&quot;qc_comment_edit_link&quot;)) qc_comment_edit_link(); ?&gt;';
		$out .= '</code></pre>';

		// Output
		echo ( !empty($this->note) ? "<div id=\"message\" class=\"updated fade\"><p>{$this->note}</p></div>\n" : '' ) . "\n";
		echo ( $this->error == 0 ? $out : '' ) . "\n";
	}

	// get auth param
	function _getAuthParam($param = '') {
		switch ($this->options['editorChk']) {
		case 1:
			if (empty($param))
				$param = $_SERVER['REMOTE_ADDR'];
			return preg_replace( '/[^0-9a-fA-F:., ]/', '', $param);
			break;
		case 2:
			if (empty($param)) {
				global $comment;
				$param = $comment;
			}
			return md5($param->comment_author_IP
			          .$param->comment_agent
			          .$param->comment_author
			          .$param->comment_author_email
			          .$param->comment_author_url);
			break;
		default:
			return false;
		}
	}

	// Comment Redirect
	function commentRedirect($location) {
		global $comment_id, $comment_post_ID;
		if (isset($_POST['quick-comments']) && !$this->isKtai()) {
			$auth_param = $this->_getAuthParam();
			$param = '?getlist'
			       . '&comment_post_ID='.$comment_post_ID
			       . '&comment_ID='.$comment_id
			       . '&qc_auth_param='.$auth_param;

			// set COOKIE
			if ($this->options['editorChk'] == 2)
				setcookie('qc_auth_param_'.COOKIEHASH, $auth_param, time() + (60 * intval($this->options['editMin'])), COOKIEPATH, COOKIE_DOMAIN );

			if (isset($_POST['redirect_to']) && strstr($_POST['redirect_to'], '?'))
				$param .= '&'.preg_replace('/^.*\?(.*)$/' ,'$1', $_POST['redirect_to']);

			return $this->plugin_url.$this->plugin_file.$param;
		} else {
			return $location;
		}
	}

	// is Comment or (Trackback or Pingback) ?
	function _isComment($comment_id = '') {
		global $comment;

		if (!isset($comment)) $comment = &get_comment($comment_id);

		return  (  $comment->comment_type != "trackback"
			&& $comment->comment_type != "pingback"
			&& !ereg("<pingback />", $comment->comment_content)
			&& !ereg("<trackback />", $comment->comment_content)
			);
	}

	// Time limit ?
	function _isTimeLimit($date_gmt){
		$time_ago  = time() - strtotime($date_gmt . ' GMT');	           // in seconds
		$time_left = round(($this->options['editMin'] - ($time_ago / 60)), 0); // in minutes
		return $time_ago < (60 * intval($this->options['editMin']));
	}

	// Allow Comment ?
	function _isCommentAllow($comment_ID = '') {
		global $comment, $user_ID, $post;

		if (!$this->options['editMode'] || $this->isKtai()) return false;

		if (!isset($comment)) $comment = &get_comment($comment_ID);
		if (!isset($post))    $post = &get_post($comment->comment_post_ID);
		if ($post->comment_status !== 'open') return false;

		$auth_param = (isset($_GET['qc_auth_param']) ? $_GET['qc_auth_param'] : (isset($_POST['qc_auth_param']) ? $_POST['qc_auth_param'] : (isset($_COOKIE['qc_auth_param_'.COOKIEHASH]) ? $_COOKIE['qc_auth_param_'.COOKIEHASH] : '')));
		if ($this->options['editorChk'] != 2)
			$auth_param = preg_replace( '/[^0-9a-fA-F:., ]/', '', (!empty($auth_param) ? $auth_param : $_SERVER['REMOTE_ADDR']));

		return  current_user_can( 'edit_'.$post->post_type, $post->ID )
			|| user_can_edit_post_comments($user_ID, $post->ID)
			|| (
				$auth_param == $this->_getAuthParam($this->options['editorChk'] == 1 ? $comment->comment_author_IP : $comment)
				&& $this->_isTimeLimit($comment->comment_date_gmt)
			)
			;
	}

	// Get Last Comment Only
	function getLastCommentOnly($comments, $post_ID) {
		$this->_comments = $comments;
		$this->_comment_count = count($this->_comments);
		if ($this->comment_ID === true) {
			$comments = array($this->_comments[count($this->_comments)-1]);
		} else {
			foreach ($this->_comments as $comment) {
				if ($comment->comment_ID == $this->comment_ID) {
					$comments = array($comment);
					break;
				}
			}
			unset($comment);
		}
		return $comments;
	}

	// Get Comments from post ID
	function _getComments($comment_post_ID, $comment_ID = false, $with_stylesheet = false) {
		global $post, $comment, $authordata, $withcomments, $wp_query;

		// get comment list elements
		$list_element = 'ol';
		$list_id      = '';
		$list_class   = '';
		if (preg_match('/^([^#\.]*)([#\.])([^:]*)/', $this->options['list'], $matches)) {
			$list_element = $matches[1];
			$list_id      = ($matches[2]=='#' ? $matches[3] : '');
			$list_class   = ($matches[2]=='.' ? $matches[3] : '');
		} else {
			$list_element = preg_replace('/^([^#\.]*)[#\.].*$/', '$1', $this->options['list']);
		}
		unset($matches);

		// get post data
		if (function_exists('get_post')) {
			$post = get_post($comment_post_ID);
			$authordata = get_userdata($post->post_author);
		} else {
			$post->ID = $comment_post_ID;
		}
		$withcomments = true;

		// generate HTML
		$out  = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
		$out .= "<html>\n";
		$out .= "<head>";
		$out .= "<title>Comments (PostID:{$comment_post_ID})</title>";
		if ($with_stylesheet) $out .= "<link rel=\"stylesheet\" href=\"".get_stylesheet_uri()."\" type=\"text/css\" media=\"screen\" />";
		$out .= "</head>\n";
		$out .= "<body><div>";

		// get comment data
		if ($this->options['lastCommentOnly'] && $comment_ID !== false) {
			$this->comment_ID = $comment_ID;
			add_filter('comments_array', array(&$this, 'getLastCommentOnly'), 10, 2);
		}

		ob_start();								// start buffering output
		$this->_isAddScripts = true;
		comments_template();
		$commentout = preg_replace('/[\r\n\t]/ims', '', ob_get_clean());	// grab buffered output


		// get comment list element
		$list_id    = ($list_id    != '' ? ' [^>]*id=[\'"]'.$list_id.'[\'"]' : '');
		$list_class = ($list_class != '' ? ' [^>]*class=[\'"]'.$list_class.'[\'"]' : '');
		if (preg_match('/<'.$list_element.$list_id.$list_class.'[^>]*>.*<\/'.$list_element.'>/i', preg_replace('/<form.*$/i', '', $commentout), $matches)) {
			$out .= $matches[0];
		} else {
			$out .= $commentout;
		}
		unset($matches);

		$out .= "<p>Comment count:<span id=\"comment_count\">".($this->options['lastCommentOnly'] ? $this->_comment_count : $wp_query->comment_count)."</span></p>";
		$out .= "<p>Output comment count:<span id=\"output_comment_count\">{$wp_query->comment_count}</span></p>";
		$out .= "<p>Last comment only:<span id=\"last_comment_only\">".($wp_query->comment_count == 1 ? 'TRUE' : 'FALSE')."</span></p>";
		$out .= "</div></body>\n";
		$out .= "</html>";

		if ($this->options['lastCommentOnly'] && $comment_ID !== false) {
			$comments = $wp_query->comments = $this->_comments;
			$wp_query->comment_count = count($wp_query->comments);
			update_comment_cache($comments);
		}

		// convert encoding (UTF-8)
		if (strtoupper($this->charset) != "UTF-8")
			$out = mb_convert_encoding($out, "UTF-8", $this->charset);

		// output
		if ($this->options['sendToGzip']) ob_start("ob_gzhandler");
		nocache_headers();
		header('Content-type: text/html; charset=utf-8');
		echo $out;
		if ($this->options['sendToGzip']) ob_end_flush();
	}

	// get comments list
	function getCommentList($comment_post_ID, $comment_ID = '') {
		if (!$this->isActive() && $this->_isCommentAllow($comment_ID)) {
			header("HTTP/1.0 403 Forbidden");
			wp_die(__('403 Forbidden', $this->textdomain_name));
		}

		$this->_getComments($comment_post_ID, (empty($comment_ID) ? true : $comment_ID));
	}

	// Get Comment Data (JSON) from comment ID
	function getCommentData($comment_id = '') {
		global $comment;

		if (!$this->options['editMode'] || !$this->isActive()) {
			header("HTTP/1.0 403 Forbidden");
			wp_die(__("You aren't allowed to edit this comment.", $this->textdomain_name));
		}

		// get comment
		if (!isset($comment)) $comment = get_comment($comment_id);
		if (isset($comment) && $this->_isCommentAllow($comment->comment_ID)) {
			$comment_content = str_replace('"', '\\"', preg_replace("/\r\n/ims", "\n", $comment->comment_content));
			$out  = '{';
			$out .= '"status":true';
			$out .= ',"id":"'.$comment->comment_ID.'"';
			$out .= ',"author":"'.$comment->comment_author.'"';
			$out .= ',"email":"'.$comment->comment_author_email.'"';
			$out .= ',"url":"'.$comment->comment_author_url.'"';
			$out .= ',"datetime":"'.$comment->comment_date.'"';
			$out .= ',"content":"'.preg_replace('/\n/ims', '\\n', $comment_content).'"';
			$out .= '}';
		} else {
			$out  = '{';
			$out .= '"status":false';
			$out .= ',"message":"'.sprintf(
				 __("You aren't allowed to edit this comment, either because you didn't write it or you passed the %d minute time limit.", $this->textdomain_name)
				,$this->options['editMin']
				).'"';
			$out .= '}';
		}

		// convert encoding (UTF-8)
		if (strtoupper($this->charset) != "UTF-8")
			$out = mb_convert_encoding($out, "UTF-8", $this->charset);

		// output
		if ($this->options['sendToGzip']) ob_start("ob_gzhandler");
		nocache_headers();
		header('Content-Type: application/x-javascript; charset=utf-8');
		echo $out;
		if ($this->options['sendToGzip']) ob_end_flush();
	}

	// Edit Comment
	function updateCommentData($comment_post_ID, $comment_ID, $comment_content, $comment_author = '', $comment_author_email = '', $comment_author_url = ''){
		global $wpdb, $comment, $post, $user, $user_ID;

		if ( 'POST' != $_SERVER['REQUEST_METHOD'] ) {
			header('Allow: POST');
			header('HTTP/1.1 405 Method Not Allowed');
			header('Content-Type: text/plain');
			wp_die(__("You aren't allowed to edit this comment.", $this->textdomain_name));
		}

		// is this Plugin Active and Edit Mode?
		if (!$this->options['editMode'] || !$this->isActive()) {
			header("HTTP/1.0 403 Forbidden");
			wp_die(__("You aren't allowed to edit this comment.", $this->textdomain_name));
		}

		// get comments & post
		if (!isset($comment)) $comment = &get_comment($comment_ID);
		if (!isset($post))    $post = &get_post($comment_post_ID);

		// create comment data
		$comment_author = (!empty($comment_author) ? $comment_author : $comment->comment_author );
		$comment_author_email = (!empty($comment_author_email) ? $comment_author_email : $comment->comment_author_email );
		$comment_author_url = (!empty($comment_author_url) ? $comment_author_url : $comment->comment_author_url );
		$comment_type = $comment->comment_type;
		$comment_content = str_replace('\\"', '"', $comment_content);
		$comment_approved = 1;
		$commentdata = compact(
			 'comment_ID'
			,'comment_post_ID'
			,'comment_author'
			,'comment_author_email'
			,'comment_author_url'
			,'comment_content'
			,'comment_type'
			,'comment_approved'
			,'user_ID'
			);

		// allow comment ?
		if (!$this->_isCommentAllow($commentdata['comment_ID'])) {
			unset($commentdata);
			header("HTTP/1.0 403 Forbidden");
			wp_die(sprintf(
				 __("You aren't allowed to edit this comment, either because you didn't write it or you passed the %d minute time limit.", $this->textdomain_name)
				,$this->options['editMin'])
				);
		}

		$status = $wpdb->get_row( $wpdb->prepare("SELECT post_status, comment_status FROM $wpdb->posts WHERE ID = %d", $comment_post_ID) );
		if ( empty($status->comment_status) ) {
			unset($commentdata);
			do_action('comment_id_not_found', $comment_post_ID);
			return false;
		} elseif ( !comments_open($comment_post_ID) ) {
			unset($commentdata);
			do_action('comment_closed', $comment_post_ID);
			header("HTTP/1.0 403 Forbidden");
			wp_die( __('Sorry, comments are closed for this item.') );
		} elseif ( in_array($status->post_status, array('draft', 'pending') ) ) {
			unset($commentdata);
			do_action('comment_on_draft', $comment_post_ID);
			return false;
		}

		// If the user is logged in
		if (!isset($user)) $user = wp_get_current_user();
		if (!$user->ID && get_option('comment_registration') ) {
			unset($commentdata);
			header("HTTP/1.0 403 Forbidden");
			wp_die( __('Sorry, you must be logged in to post a comment.') );
		}

		if ( get_option('require_name_email') && !$user->ID ) {
			if ( 6 > strlen($comment_author_email) || '' == $comment_author ) {
				unset($commentdata);
				header("HTTP/1.0 403 Forbidden");
				wp_die( __('Error: please fill the required fields (name, email).') );
			} elseif ( !is_email($comment_author_email)) {
				unset($commentdata);
				header("HTTP/1.0 403 Forbidden");
				wp_die( __('Error: please enter a valid email address.') );
			}
		}

		if ( '' == $comment_content ) {
			unset($commentdata);
			header("HTTP/1.0 403 Forbidden");
			wp_die( __('Error: please type a comment.') );
		}

		// allow comment ?
		if(function_exists('wp_allow_comment')) {
			remove_action('check_comment_flood', 'check_comment_flood_db', 10, 3);
			$commentdata['comment_approved'] = wp_allow_comment($commentdata);
		}

		// comment update
		if (function_exists('wp_update_comment')) {
			wp_update_comment($commentdata);
		} else {
			foreach ( $commentdata as $key => $value )
				$commentdata[$key] = $wpdb->escape($value);
			$commentdata['comment_content'] = apply_filters('comment_save_pre', $commentdata['comment_content']); // escaping and shiz. Same as wp-admin comment editing
			$wpdb->query($wpdb->prepare(
				  " UPDATE"
				 ."  $wpdb->comments"
				 ." SET"
				 ."  comment_content = %s"
				 ." ,comment_author = %s"
				 ." ,comment_author_email = %s"
				 ." ,comment_approved = %s"
				 ." ,comment_author_url = %s"
				 ." WHERE"
				 ."  comment_ID = %d"
				, $commentdata['comment_content']
				, $commentdata['comment_author']
				, $commentdata['comment_author_email']
				, $commentdata['comment_approved']
				, $commentdata['comment_author_url']
				, $commentdata['comment_ID']
				)
			);
			if(function_exists('clean_comment_cache')) clean_comment_cache($commentdata['comment_ID']);
			if(function_exists('wp_update_comment_count')) wp_update_comment_count($commentdata['comment_post_ID']);
			do_action('edit_comment', $commentdata['comment_ID']);
		}

		// Set Cookie
		setcookie('comment_author_' . COOKIEHASH, $commentdata['comment_author'], time() + 30000000, COOKIEPATH, COOKIE_DOMAIN);
		setcookie('comment_author_email_' . COOKIEHASH, $commentdata['comment_author_email'], time() + 30000000, COOKIEPATH, COOKIE_DOMAIN);
		setcookie('comment_author_url_' . COOKIEHASH, clean_url($commentdata['comment_author_url']), time() + 30000000, COOKIEPATH, COOKIE_DOMAIN);
		if ($this->options['editorChk'] == 2)
			setcookie('qc_auth_param_'.COOKIEHASH, $this->_getAuthParam(get_comment($comment_ID)), time() + (60 * intval($this->options['editMin'])), COOKIEPATH, COOKIE_DOMAIN );

//		// Notify Post Author
//		if ($this->options['notifyUpdate'])
//			wp_notify_postauthor($commentdata['comment_ID'], $commentdata['comment_type']);

		unset($commentdata);

		// get comments list
		$this->_getComments($comment_post_ID, $comment_ID);
	}

	// Get comment edit link
	function getCommentEditLink($comment_id = 0, $edit_icon = '') {
		global $comment;

		// allow comment ?
		if (!isset($comment)) $comment = get_comment($comment_id);
		$comment_id = $comment->comment_ID;

		if ($this->_isComment($comment_id) && $this->_isCommentAllow($comment_id)) {
			$edit_icon = (empty($edit_icon) ? $this->options['editIcon'] : $edit_icon);
			return "<a href=\"#\" title=\"".__('Edit comment')."\" class=\"edit-comment\" id=\"edit-comment-{$comment_id}\" style=\"cursor:pointer;\">{$edit_icon}</a>";
		} else {
			return '';
		}
	}

	// Add Edit Icon before comment author link
	function commentAuthorLink($link) {
		if (!is_admin() && $this->options['setEditIcon'] && $this->_isAddScripts())
			return $this->getCommentEditLink().$link;
		else
			return $link;
	}

	function rejectSpamIP($ip, $email, $date) {
		if (!$this->options['rejectSpamIP']) return;

		$spam_IP  = '127.0.0.2';
		$host     = "dnsbl.spam-champuru.livedoor.com";
		$pattern  = '/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/';
		$check_IP = trim(preg_match($pattern, $ip) ? $ip : $_SERVER['REMOTE_ADDR']);
		$spam     = false;
		if (preg_match($pattern, $check_IP)) {
			$host = implode('.',array_reverse(split('\.',$check_IP))) . '.' . $host;
			if (function_exists('dns_get_record')) {
				$check_recs = dns_get_record($host, DNS_A);
				if (isset($check_recs[0]['ip'])) $spam = ($check_recs[0]['ip'] === $spam_IP);
				unset($check_recs);
			} elseif (function_exists('gethostbyname')) {
				$checked = (gethostbyname($host) === $spam_IP);
			} elseif (class_exists('Net_DNS_Resolver')) {
				$resolver = new Net_DNS_Resolver();
				$response = $resolver->query($host, 'A');
				if ($response) {
					foreach ($response->answer as $rr) {
						if ($rr->type === 'A') {
							$spam = ($rr->address === $spam_IP);
							break;
						}
					}
				}
				unset($response);
				unset($resolver);
			} elseif (function_exists('checkdnsrr')) {
				$spam = (checkdnsrr($host, "A") === true);
			}
		}
		if ($spam) {
			wp_die(__('Error: Your IP Address is registered in the DNSBL (http://spam-champuru.livedoor.com/dnsbl/).', $this->textdomain_name));
		}
	}
}//class

// Show Edit Icon
function qc_comment_edit_link($editIcon = '', $pre_text = '', $post_text = '', $show = true, $comment_id = ''){
	global $quick_comments;

	if (!isset($quick_comments))
		$quick_comments = new QuickCommentsController();
	if (!is_admin() && !$quick_comments->options['setEditIcon']) {
		$editIcon = $quick_comments->getCommentEditLink($comment_id, $editIcon);
		if (!empty($editIcon))
			$editIcon = $pre_text . $editIcon . $post_text;
	}
	if ($show)
		echo $editIcon;
	else
		return $editIcon;
}

global $quick_comments, $notify_comment_author;

$quick_comments = new QuickCommentsController();

// Add Edit Icon before comment author link
if ($quick_comments->getOption('editMode') && $quick_comments->getOption('setEditIcon'))
	add_filter('get_comment_author_link', array(&$quick_comments,'commentAuthorLink'));

// Reject SPAM IP
if ($quick_comments->getOption('rejectSpamIP'))
	add_action('check_comment_flood', array(&$quick_comments,'rejectSpamIP'), 10, 3);

if (strstr($_SERVER['PHP_SELF'], '/quick-comments.php')) {
	// get Param
	$comment_post_ID = (int) (isset($_POST['comment_post_ID']) ? $_POST['comment_post_ID'] : (isset($_GET['comment_post_ID']) ? $_GET['comment_post_ID'] : ''));
	$comment_ID      = (int) (isset($_POST['comment_ID']) ? $_POST['comment_ID'] : (isset($_GET['comment_ID']) ? $_GET['comment_ID'] : ''));

	if (isset($_GET['getlist']) || isset($_POST['getlist'])) {
		// Get comment list
		$quick_comments->getCommentList($comment_post_ID, $comment_ID);
	} elseif (isset($_GET['json']) || isset($_POST['json'])) {
		// Get comment data
		$quick_comments->getCommentData($comment_ID);
	} elseif (isset($_POST['update'])) {
		// Edit comment data
		$quick_comments->updateCommentData(
			 $comment_post_ID
			,$comment_ID
			,trim($_POST['comment'])
			,trim(strip_tags($_POST['author']))
			,trim($_POST['email'])
			,trim($_POST['url'])
		);
	} else {
		$err_message = $quick_comments->getText('403 Forbidden');
		unset($quick_comments);
		header("HTTP/1.0 403 Forbidden");
		wp_die($err_message);
	}

} else {
	// Add Admin Menu
	add_action('admin_menu', array(&$quick_comments,'addAdminMenu'));

	// Add scripts to "Single post" or "Page"
	if (function_exists('wp_enqueue_script')) {
		// Wordpress 2.1+
		add_action('wp_print_scripts', array(&$quick_comments,'addScripts'));
		add_action('wp_head', array(&$quick_comments,'addHead'));
		if ( preg_match('/^k2/i', get_settings('template')) ) {
			add_filter('print_scripts_array', array(&$quick_comments, 'removeK2Comments'), 11);
		}
	} else {
		// Wordpress 2.0.x
		add_action('wp_head', array(&$quick_comments,'addHeadScripts'));
	}

	// Add redirected after "Comment post"
	add_filter('comment_post_redirect', array(&$quick_comments,'commentRedirect'));

	// Notify Comment Author
	if (!class_exists('NotifyCommentAuthorController'))
		require(dirname(__FILE__).'/notify-comment-author.php');
}
?>