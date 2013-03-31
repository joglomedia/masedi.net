<?php 

/* <WP plugin data>
 * Plugin Name:   Smilies Themer
 * Version:       0.5.3
 * Plugin URI:    http://rick.jinlabs.com/code/smilies-themer/
 * Description:   Allows you to choose different smilies  themes. Based in More Smilies by <a href="http://www.mattread.com/">Matt Read</a>.
 * Author:        Ricardo Gonz&aacute;lez
 * Author URI:    http://rick.jinlabs.com/
 *
 * License:       GNU General Public License
 *
 * 
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * Based n Matt Read's More Smilies (http://matread.com)
 */

# include dependencies
include('smilies-package.inc.php');

# Path constants.
define('k_SMILIES_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('k_SMILIES_URL', get_settings('siteurl') .'/wp-content/plugins/smilies-themer/');
define('k_SMILIES_CONFIG_FILE', 'package-config.php');

# Version constant

# Plugin constant

class smilies_themer
{
	var $current_smilies = 'default';
	var $use_smilies = false;
	var $smilies;
	var $url;
	var $path;
	
	function smilies_themer() {
		# add actions
		add_action('activate_'. plugin_basename(__FILE__), array(&$this, 'activate'));
		add_action('deactivate_'. plugin_basename(__FILE__), array(&$this, 'deactivate'));
		add_action('upgrade_'. plugin_basename(__FILE__), array(&$this, 'upgrade'));
		add_action('init', array(&$this, 'init'), 67);
		add_action('admin_menu', array(&$this, 'admin_menu'));
		
		# remove filters remove_filter('comment_text', 'convert_smilies'); 
		remove_filter('the_content', 'convert_smilies'); 
		remove_filter('the_excerpt', 'convert_smilies');
		
		# add filters
		add_filter('comment_text', array(&$this, 'convert_smilies'));
		add_filter('the_content', array(&$this, 'convert_smilies'));
		add_filter('the_excerpt', array(&$this, 'convert_smilies'));
		
		# set base vars
		if (get_option('smilies_themer'))
			$this->current_smilies = get_option('smilies_themer');
		$this->use_smilies = get_settings('use_smilies');
		$this->url = k_SMILIES_URL;
		$this->path = k_SMILIES_PATH;
	}
	
	function init() {
		if ($this->use_smilies) {
			$this->current_smilies = apply_filters('smilies_themer', $this->current_smilies);
			$this->smilies =& new smilies_package($this->current_smilies);
			# set WP's global vars to ours
			$this->smilies->set_smilies();
		}
	}
	
	function convert_smilies($text) {
    $output = '';
	if ($this->use_smilies) {
		// HTML loop taken from texturize function, could possible be consolidated
		$textarr = preg_split("/(<.*>)/Us", $text, -1, PREG_SPLIT_DELIM_CAPTURE); // capture the tags as well as in between
		$stop = count($textarr);// loop stuff 
		for ($i = 0; $i < $stop; $i++) { 
			$content = $textarr[$i]; 
			if ((strlen($content) > 0) && ('<' != $content{0})) { // If it's not a tag 
				$content = preg_replace($this->smilies->smiliessearch, $this->smilies->smiliesreplace, $content); 
			} 
			$output .= $content; 
		}
	} else {
		// return default text.
		$output = $text;
	}
	return $output;
}

	
	
	function activate() {
		add_option('smilies_themer', 'default', 'The smilies theme to use.', 'no');
		wp_cache_flush();
		return true;
	}
	
	function deactivate() {
		delete_option('smilies_themer');
		wp_cache_flush();
		return true;
	}
	
	function upgrade() {
		wp_cache_flush();
		return true;
	}
	
	function load_textdomain() {
		$locale = get_locale();
		$domain = 'smilies-themer';
		$mofile = k_SMILIES_PATH . "language". DIRECTORY_SEPARATOR ."$domain-$locale.mo";
		load_textdomain($domain, $mofile);
	}
	
	function admin_menu() {
		add_options_page('Smilies Themer', 'Smilies Themer', 'manage_options', plugin_basename(__FILE__), array(&$this, 'options_page'));
	}
	
	function get_package_list($path) {
		$packages = array();
		$packages_dir = @ dir($path);
		if ($packages_dir) {
			while(($package_dir = $packages_dir->read()) !== false) {
				if (is_dir($path . $package_dir)) {
					$this_package_dir = @ dir($path . $package_dir);
					while(($package_file = $this_package_dir->read()) !== false) {
						if ( $package_file == k_SMILIES_CONFIG_FILE ) {
							$packages[] = $package_dir;
							break;
						}
					}
				}
			}
		}
		return $packages;
	}
	
	function update_options() {
		if ('update_smilies_themer' != $_POST['action'])
			return false;
		
		check_admin_referer('update_smilies_themer');
		
		$package = trim(stripslashes($_POST['smilies_themer']));
		$use_smilies = trim(stripslashes($_POST['use_smilies']));
		
		update_option('smilies_themer', $package);
		update_option('use_smilies', $use_smilies);
		$this->current_smilies = $package;
		$this->use_smilies = $use_smilies;
		
		wp_cache_delete($this->current_smilies, 'smilies');
		
		$this->notice(1, '<strong>'. __('Options saved.', 'smilies-themer') .'</strong>');
	}
	
	function options_page() {
		//$this->load_textdomain();
		load_plugin_textdomain('smilies-themer', "/wp-content/plugins/smilies-themer/locales/");

		$this->update_options();
		
		if (!$this->use_smilies) {
			$this->notice(3, __('You need to check "convert emoticons" for this to work.', 'smilies-themer'));
		}
		
		require('options-page.inc.php');
	}
	
	function notice($code, $msg) {
		switch ($code) {
			default:
			case 1: // simple notice
				echo '<div id="message" class="updated fade"><p>'. $msg .'</p></div>';
				break;
			case 3: // simple error
				echo '<div id="error" class="updated fade-ff0000"><p>'. $msg .'</p></div>';
				break;
			case 2: // advanced notice
			case 4: // advanced error
				echo '<div class="wrap">'. $msg .'</div>';
				break;
			case 5: // super duper wicked crazy critical error!
				die($msg);
				break;
		}
	}
	
	function footer() {

	}
	

}

$smilies_themer =& new smilies_themer;

?>