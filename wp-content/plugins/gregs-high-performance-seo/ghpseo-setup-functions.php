<?php

/*  Greg's Setup Handler
	
	Copyright (c) 2009-2012 Greg Mulhauser
	http://gregsplugins.com
	
	Released under the GPL license
	http://www.opensource.org/licenses/gpl-license.php
	
	**********************************************************************
	This program is distributed in the hope that it will be useful, but
	WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
	*****************************************************************
*/

if (!function_exists ('is_admin')) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
	}

// This setup class is only loaded if we're actually on admin pages

class ghpseoSetupHandler {

	var $plugin_prefix;                       // prefix for this plugin
	var $options_page_details = array();      // setting up our options page
	var $consolidate;                         // whether to consolidate options into arrays, or keep discrete

	function ghpseoSetupHandler ($args,$options_page_details) {
		$this->__construct($args,$options_page_details);
		return;
	} 

	function __construct($args,$options_page_details) {
		extract($args);
		$this->plugin_prefix = $prefix;
		$this->options_page_details = $options_page_details;
		if (!empty($option_style)) $this->consolidate = ('consolidate' == $option_style) ? true : false;
		else $this->consolidate = true;
		// set up all our admin necessities
		add_filter( "plugin_action_links_{$location_local}", array(&$this,'plugin_settings_link'));
		add_action('admin_menu', array(&$this,'plugin_menu'));
		add_action('admin_menu', array(&$this,'wp_postbox_js'));
		add_action('admin_init', array(&$this,'admin_init') );
		add_action('admin_head', array(&$this,'styles') );
		register_activation_hook($location_full, array(&$this,'activate') );
		return;
	} // end constructor

	function grab_settings($mode = 'full') {
		
		// array keys correspond to the page of options on which that option gets handled
		// option array itself holds option name, default value, sanitization function
		
		$options_set = array(
			'default' => array(
				array("abbreviate_options", "0", 'intval'),
				array("editing_title", "1", 'intval'),
				array("editing_description", "1", 'intval'),
				array("editing_keywords", "1", 'intval'),
				array("editing_secondary_description_posts", "0", 'intval'),
				array("editing_secondary_description_pages", "1", 'intval'),
				array("editing_counter", "1", 'intval'),
				array("support_custom_post_types", "0", 'intval'),
				array("restrict_access", "1", 'intval'),
				array("enable_modifications", "0", 'intval'),
				array("obnoxious_mode", "0", 'intval'),
				array("title_case", "1", 'intval'),
				array("title_case_exceptions", "a an and by in of the to with", 'wp_filter_nohtml_kses'),
				),
			'pagedcomments' => array(
				array("paged_comments_dupefix", "1", 'intval'),
				array("comment_page_replacement", __('You are currently browsing comments. If you would like to return to the full story, you can read the full entry here: %post_title_linked%.'), 'htmlspecialchars'),
				array("comment_page_replacement_override", "0", 'intval'),
				array("comment_page_replacement_level", "20", 'intval'),
				array("paged_comments_titlefix", "1", 'intval'),
				array("comment_title_replacement", __('Comments on "%post_title%", Page %comment_page%'), 'wp_filter_nohtml_kses'),
				array("comment_title_replacement_override", "0", 'intval'),
				array("paged_comments_descfix", "1", 'intval'),
				array("comment_desc_replacement", __('You are currently browsing page %comment_page% of comments on the article %post_title%.'), 'htmlspecialchars'),
				array("comment_desc_replacement_override", "0", 'intval'),
				array("paged_comments_meta_enable", "1", 'intval'),
				array("paged_comments_meta_replacement", __("Page %comment_page% of comments on '%post_title%'"), 'wp_filter_nohtml_kses'),
				),
			'secondarydesc' => array(
				array("enable_secondary_desc", "1", 'intval'),
				array("secondary_desc_override_all", "0", 'intval'),
				array("secondary_desc_override_excerpt", "0", 'intval'),
				array("secondary_desc_use_blank", "0", 'intval'),
				array("secondary_desc_override_text", '', 'htmlspecialchars'),
				array("secondary_desc_wrap", "0", 'intval'),
				array("home_desc", '%blog_desc%', 'htmlspecialchars'),
				array("home_paged_desc", '%blog_desc%', 'htmlspecialchars'),
				array("author_desc", __("%author_name% has published the following articles at %blog_name%."), 'htmlspecialchars'),
				array("search_desc", __("'%search_terms%' at %blog_name%."), 'htmlspecialchars'),
				array("tag_desc", __("The following articles are related to '%tag_title%' at %blog_name%."), 'htmlspecialchars'),
				array("tag_desc_extra", __("%tag_desc%"), 'htmlspecialchars'),
				array("tag_desc_override", "1", 'intval'),
				array("tag_desc_leave_breaks", "0", 'intval'),
				array("category_desc", '%category_desc%', 'htmlspecialchars'),
				array("cat_desc_leave_breaks", "0", 'intval'),
				array("day_archive_desc", __('%blog_name% published the following articles on %day%.'), 'htmlspecialchars'),
				array("month_archive_desc", __('%blog_name% published the following articles in %month%.'), 'htmlspecialchars'),
				array("year_archive_desc", __('%blog_name% published the following articles in %year%.'), 'htmlspecialchars'),
				array("other_date_archive_desc", __('These are the historical archives for %blog_name%.'), 'htmlspecialchars'),
				array("404_desc", __("Sorry, but we couldn't find anything matching your request."), 'htmlspecialchars'),
				),
			'secondarytitles' => array(
				array("enable_secondary_titles", "1", 'intval'),
				array("main_for_secondary", "1", 'intval'),
				array("post_title_secondary", '%post_title_custom%', 'htmlspecialchars'),
				array("page_title_secondary", '%page_title_custom%', 'htmlspecialchars'),
				array("home_title_secondary", __('%blog_name%: Welcome!'), 'htmlspecialchars'),
				array("home_paged_title_secondary", '%blog_name%', 'htmlspecialchars'),
				array("home_static_front_title_secondary", '%page_title_custom%', 'wp_filter_nohtml_kses'),
				array("home_static_posts_title_secondary", '%page_title_custom%', 'wp_filter_nohtml_kses'),
				array("author_title_secondary", __("%author_name%'s Articles at %blog_name%"), 'htmlspecialchars'),
				array("search_title_secondary", __("'%search_terms%' at %blog_name%"), 'htmlspecialchars'),
				array("tag_title_secondary", __("'%tag_title%' Articles at %blog_name%"), 'htmlspecialchars'),
				array("category_title_secondary", __('Posts in the %category_title% Category at %blog_name%'), 'htmlspecialchars'),
				array("day_archive_title_secondary", __('%blog_name% Archives for %day%'), 'htmlspecialchars'),
				array("month_archive_title_secondary", __('%blog_name% Articles in %month%'), 'htmlspecialchars'),
				array("year_archive_title_secondary", __('%blog_name% Articles in %year%'), 'htmlspecialchars'),
				array("other_date_archive_title_secondary", __('Historical Archives for %blog_name%'), 'htmlspecialchars'),
				array("404_title_secondary", __("We Couldn't Find That"), 'htmlspecialchars'),
				array("paged_modification_title_secondary", __('%prior_title%, Page %page_number%'), 'htmlspecialchars'),
				),
			'headmeta' => array(
				array("enable_alt_description", "1", 'intval'),
				array("use_secondary_for_head", "1", 'intval'),
				array("desc_length", "160", 'intval'),
				array("desc_length_override", "0", 'intval'),
				array("home_meta_desc", '%blog_name%: %blog_desc%', 'wp_filter_nohtml_kses'),
				array("home_paged_meta_desc", '%blog_name%: %blog_desc%', 'wp_filter_nohtml_kses'),
				array("author_meta_desc", __("Articles by %author_name% at %blog_name%"), 'wp_filter_nohtml_kses'),
				array("search_meta_desc", __("Results for '%search_terms%' at %blog_name%"), 'wp_filter_nohtml_kses'),
				array("tag_meta_desc", __("Articles tagged with '%tag_title%' at %blog_name%"), 'wp_filter_nohtml_kses'),
				array("tag_meta_desc_extra", __("%tag_desc%"), 'htmlspecialchars'),
				array("tag_meta_desc_override", "1", 'intval'),
				array("category_meta_desc", __('Posts in the %category_title% category at %blog_name%'), 'wp_filter_nohtml_kses'),
				array("day_archive_meta_desc", __('%blog_name% archives for %day%'), 'wp_filter_nohtml_kses'),
				array("month_archive_meta_desc", __('%blog_name% articles in %month%'), 'wp_filter_nohtml_kses'),
				array("year_archive_meta_desc", __('%blog_name% articles in %year%'), 'wp_filter_nohtml_kses'),
				array("other_date_archive_meta_desc", __('Historical archives at %blog_name%'), 'wp_filter_nohtml_kses'),
				array("paged_modification_meta_desc", __('Page %page_number%: %prior_meta_desc%'), 'wp_filter_nohtml_kses'),
				array("enable_keywords", "1", 'intval'),
				array("enable_keywords_tags", "1", 'intval'),
				array("keyword_tags_limit", "16", 'intval'),
				array("enable_keywords_custom", "1", 'intval'),
				array("tags_length", "250", 'intval'),
				array("enable_keywords_title", "0", 'intval'),
				array("custom_home_keywords", "", 'wp_filter_nohtml_kses'),
				array("default_keywords", "", 'wp_filter_nohtml_kses'),
				array("index_enable", "1", 'intval'),
				array("index_noodp", "1", 'intval'),
				array("index_author_exclude", "0", 'intval'),
				array("index_category_exclude", "1", 'intval'),
				array("index_search_exclude", "0", 'intval'),
				array("index_tag_exclude", "0", 'intval'),
				array("index_date_exclude", "1", 'intval'),
				array("index_attachment_exclude", "1", 'intval'),
				array("depth_author_exclude", "", 'intval'),
				array("depth_category_exclude", "", 'intval'),
				array("depth_search_exclude", "", 'intval'),
				array("depth_tag_exclude", "", 'intval'),
				array("depth_date_exclude", "", 'intval'),
				array("depth_attachment_exclude", "", 'intval'),
				array("index_nofollow", "0", 'intval'),
				array("index_no_ssl", "0", 'intval'),
				array("canonical_enable", "1", 'intval'),
				array("canonical_no_ssl", "0", 'intval'),
				array("canonical_disable_builtin", "1", 'intval'),
				),
			'maintitles' => array(
				array("enable_main_title_modifications", "1", 'intval'),
				array("post_title", '%post_title%', 'wp_filter_nohtml_kses'),
				array("page_title", '%page_title%', 'wp_filter_nohtml_kses'),
				array("home_title", __('%blog_name%: Welcome!'), 'wp_filter_nohtml_kses'),
				array("home_paged_title", '%blog_name%', 'wp_filter_nohtml_kses'),
				array("home_static_front_title", '%page_title%', 'wp_filter_nohtml_kses'),
				array("home_static_posts_title", '%page_title%', 'wp_filter_nohtml_kses'),
				array("author_title", __("%author_name%'s Articles at %blog_name%"), 'wp_filter_nohtml_kses'),
				array("search_title", __("'%search_terms%' at %blog_name%"), 'wp_filter_nohtml_kses'),
				array("tag_title", __("'%tag_title%' Articles at %blog_name%"), 'wp_filter_nohtml_kses'),
				array("category_title", __('Posts in the %category_title% Category at %blog_name%'), 'wp_filter_nohtml_kses'),
				array("day_archive_title", __('%blog_name% Archives for %day%'), 'wp_filter_nohtml_kses'),
				array("month_archive_title", __('%blog_name% Articles in %month%'), 'wp_filter_nohtml_kses'),
				array("year_archive_title", __('%blog_name% Articles in %year%'), 'wp_filter_nohtml_kses'),
				array("other_date_archive_title", __('Historical Archives for %blog_name%'), 'wp_filter_nohtml_kses'),
				array("404_title", __('Whoops!'), 'wp_filter_nohtml_kses'),
				array("paged_modification_title", __('%prior_title%, Page %page_number%'), 'wp_filter_nohtml_kses'),
				),
			'legacy' => array(
				array("enable_secondary_titles_legacy", "1", 'intval'),
				array("legacy_title_invert", "0", 'intval'),
				array("enable_seott", "0", 'intval'),
				array("seott_key_name", "title_tag", 'wp_filter_nohtml_kses'),
				array("enable_keywords_legacy", "1", 'intval'),
				array("enable_descriptions_legacy", "1", 'intval'),
				),
			'donating' => array(
				array("donated", "0", 'intval'),
				),
			);

		// first deal with requests involving private data store
		if ( 'private' == $mode ) return $options_set['private'];
		else unset($options_set['private']);
		
		// now get on with the other forms we can provide sets of options in
		if ( ('filled' == $mode )
			|| ( 'callbacks' == $mode )
			|| ( 'pagekeys' == $mode )
			|| ( 'flat' == $mode ) ) { // option arrays only or options plus either default values, callbacks or page keys
			$result = array();
			foreach ($options_set as $optionset=>$optionarray) {
				foreach ($optionarray as $option) {
					if ('pagekeys' == $mode) $result[$option[0]] = $optionset;
					elseif ('flat' == $mode) $result[] = $option;
					else $result[$option[0]] = ('filled' == $mode) ? $option[1] : $option[2];
				} // end loop over individual options
			} // end loop over options arrays
		}
		
		else $result = $options_set; // otherwise we just give our full set, broken down by page
		
		return $result;
	} // end settings grabber

	// handle filtering of individual options when using consolidated options array
	function option_filters($options) { // sanitise option values and merge a subset with new values into the full set
		// If array is empty, or we don't know what page we're on, just give it back and rely on WP's nonce to know we've run amok
		if (empty($options) || !isset($options['current_page'])) return $options;
		$callbacks = $this->grab_settings('callbacks');
		$pagekeys = $this->grab_settings('pagekeys');
		// check which options page we're on
		$thispage = $options['current_page'];
		// now we know which option page was submitted, so prepare to loop over only the options on that page
		$pagekeys = array_filter($pagekeys, create_function('$a', "return (\$a == '$thispage');"));
		// run through the settings which belong on this page
		$filtered = array();
		foreach ($pagekeys as $setting=>$page) {
			if (!isset($options[$setting])) $options[$setting] = 0; // special case for checkboxes, absent when 0
			if ($callbacks[$setting]) $filtered[$setting] = $callbacks[$setting]($options[$setting]);
			else $filtered[$setting] = $options[$setting];
		}
		// now merge so the latest filtered values will replace the existing values, but we won't lose any existing values from the array unless they're being replaced by new ones
		$fullset = array_merge(get_option($this->plugin_prefix . '_settings'), $filtered);
		return $fullset;
	}
	
	// when we're first moving from discrete to monolithic options, this function will consolidate and cleanup
	function do_consolidation() {
		$prefix = $this->plugin_prefix . '_';
		if (get_option($prefix . 'settings')) return; // if we already have some consolidated settings, don't mess with anything
		$types = array('settings', 'private');
		foreach ($types as $type) {
			$options = $this->grab_settings(('settings' == $type) ? 'flat' : $type);
			if (is_array($options)) {
				$new = array();
				foreach ($options as $option) {
					$existing = get_option($prefix . $option[0]);
					if (false !== $existing) {
						$new[$option[0]] = $existing; // save in new form
						delete_option($prefix . $option[0]); // and drop the old form
					}
				}
				if ($new) add_option($prefix . $type, $new);
			}
		}
		return;
	}
	
	function activate() {
		$prefix = $this->plugin_prefix . '_';
		if (($this->consolidate) && !get_option($prefix . 'settings')) $this->do_consolidation();
		if ($this->consolidate) { // if consolidated, just add one array with default values and go
			$previous_options = get_option($prefix . 'settings');
			if (!$previous_options) add_option($prefix . 'settings', $this->grab_settings('filled'));
			else {
				// when we already have a settings array, we merge to get the old values together with default values for any new settings we're adding
				$new_options = array_merge($this->grab_settings('filled'), $previous_options);
				update_option($prefix . 'settings', $new_options);
			}
		}
		else { // otherwise, do it the longer way...
			$options_set = $this->grab_settings('flat');
			foreach ($options_set as $option) {
				add_option($prefix . $option[0], $option[1]);
			}
		}
		// also initialize any options we're going to use as a private data store as a single array
		$private_data = $this->grab_settings('private');
		if (is_array($private_data)) {
			$new_options = array();
			foreach ($private_data as $data) {
				$new_options[$data[0]] = $data[1];
			}
 			$previous_options = get_option($prefix . 'private');
 			if (!$previous_options) add_option($prefix . 'private', $new_options);
 			else add_option($prefix . 'private', array_merge($new_options, $previous_options));
		}
		return;
	}
	
	function admin_init(){
		$prefix_setting = $this->plugin_prefix . '_options_';
		$prefix = $this->plugin_prefix . '_';
		if (($this->consolidate) && !get_option($prefix . 'settings')) $this->do_consolidation();
		// WP 3.0: now we check AGAIN, because on an individual site of a multisite installation, we may have been activated without WP ever running what we registered with our register_activation_hook (are you serious????); we'll take the absence of any settings as an indication that WP failed to run the registered activation function
		// for now, we'll assume consolidated options -- would need to change this if using discrete options
		if (($this->consolidate) && !get_option($prefix . 'settings')) $this->activate();
		if ($this->consolidate) { // if consolidated, do it the quick way
			register_setting($prefix_setting . 'settings', $prefix . 'settings', array(&$this,'option_filters'));
		}
		else { // otherwise, do it the longer way
			$options_set = $this->grab_settings();
			foreach ($options_set as $optionset=>$optionarray) {
				foreach ($optionarray as $option) {
					register_setting($prefix_setting . $optionset, $prefix . $option[0],$option[2]);
				} // end loop over individual options
			} // end loop over options arrays
		}
		return;
	}
	
	function plugin_menu() {
		$details = $this->options_page_details;
		$page_hook = add_options_page("{$details[0]}", "{$details[1]}", 'manage_options', "{$details[2]}");
		// NOTE: WP's system for unobtrusively inserting JS, css, etc. only on pages that are needed, documented in several places such as at http://codex.wordpress.org/Function_Reference/wp_enqueue_script appears to be broken when we're using another separate options page, so we'll have to do it the clunky way, with a URL check in the delivering function instead, and putting the add_action up in the constructor
		//add_action('admin_print_scripts-' . $page_hook, array(&$this,'wp_postbox_js'));
		return;
	}
	
	function pay_attention() {
		// See note on plugin_menu function as to why we're doing this the crazy clunky way
		$page = $this->options_page_details[2];
		if (strpos(urldecode($_SERVER['REQUEST_URI']), $page) === false) return false;
		else return true;
	}
	
	function wp_postbox_js() {
		// See note on plugin_menu function as to why we're doing this check the crazy clunky way
		if (!$this->pay_attention()) return;
		wp_enqueue_script('common');
		wp_enqueue_script('wp-lists');
		wp_enqueue_script('postbox');
		return;
	}
	
	function plugin_settings_link($links) {
		$prefix = $this->plugin_prefix;
		$here = basename(dirname( __FILE__)) . '/'; // get plugin folder name
		$settings = "options-general.php?page={$here}{$prefix}-options.php";
		$settings_link = "<a href='{$settings}'>" . __('Settings') . '</a>';
		array_unshift( $links, $settings_link );
		return $links;
	} // end settings link

	function styles() { // we'll need a few styles for our options pages
		// See note on plugin_menu function as to why we're doing this check the crazy clunky way
		if (!$this->pay_attention()) return;
		$prefix = $this->plugin_prefix . '_';
		echo <<<EOT
			<style type="text/css">
			#poststuff .inside p {font-size:1.1em;}
			.{$prefix}table th {text-align:right; font-weight:bold; color:#333;}
			.{$prefix}menu ul, .{$prefix}menu li {display:inline;line-height:1.8em;}
			.{$prefix}menu {margin:15px 0;}
			.{$prefix}menu li a {text-decoration:none;}
			.{$prefix}thanks {font-style:italic;font-weight:bold;color:purple;padding:1.5em;border:1px dotted grey;}
			.{$prefix}warning {margin:2.5em;padding:1.5em;border:1px solid red;background-color:white;}
			.{$prefix}aside, .{$prefix}toc {float:right;margin:0 0 1em 1em;padding:.5em 1em;border:1px solid grey;width:300px;background-color:white;}
			.{$prefix}toc {float:left;margin:0 1em 1em 0;width:200px;}
			.{$prefix}toc ul ul {margin:.5em 0 0 1em;}
			.{$prefix}aside h4, .{$prefix}toc h4 {margin-top:0;padding-top:.5em;}
			ol.{$prefix}numlist {list-style-type:decimal;padding-left:2em;margin-left:0;}
			.{$prefix}fine_print {font-size:.8em;font-style:italic;}
			</style>
EOT;
		return;
	} // end admin styles

} // end class

?>