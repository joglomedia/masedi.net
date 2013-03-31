<?php

/*  Greg's Writing Additions Setup
	
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

require_once('ghpseo-writing-functions.php');

class ghpseoWritingSetup {

	var $plugin_prefix;        // prefix for this plugin
	var $consolidate;          // whether we'll be consolidating our options into single array, or keeping discrete

	function ghpseoWritingSetup($name='', $plugin_prefix='', $option_style='') {
		$this->__construct($name, $plugin_prefix, $option_style);
		return;
	} 

	function __construct($name='', $plugin_prefix='', $option_style='') {
		$this->plugin_prefix = $plugin_prefix;
		if (!empty($option_style)) $this->consolidate = ('consolidate' == $option_style) ? true : false;
		else $this->consolidate = true;
		$this->writing_setngo($name);
		return;
	} // end constructor

	// grab a setting
	function opt($name) {
		$prefix = rtrim($this->plugin_prefix, '_');
		// try getting consolidated settings
		if ($this->consolidate) $settings = get_option($prefix . '_settings');
		// is_array test will fail if settings not consolidated, isset will fail for private option not in array
		if (is_array($settings)) $value = (isset($settings[$name])) ? $settings[$name] : get_option($prefix . '_' . $name);
		// get discrete-style settings instead
		else $value = get_option($prefix . '_' . $name);
		return $value;
	} // end option retriever

	function writing_setngo($name) { // set up our writing page additions
		$prefix = $this->plugin_prefix;
		$domain = $prefix . '-plugin';
		$restricted = $this->opt('restrict_access'); // indicates whether to restrict access to just those authors who can publish
		$meta_set = array(  // our set of additions
		"secondary_title" => array(  
						"name" => "_{$prefix}_secondary_title",  
						"type" => "text",  
						"std" => "",  
						"title" => __( 'Secondary Title', $domain ),  
						"description" => __( 'You can specify how the secondary title will be used on the plugin settings pages.', $domain ),
						"allow_tags" => true,
						),
		"keywords" => array(  
						"name" => "_{$prefix}_keywords",  
						"type" => "text",  
						"std" => "",  
						"title" => __( 'Head Keywords', $domain ),  
						"description" => __( 'This comma-separated list will be included in the head along with any specified tags.', $domain ),
						"allow_tags" => false,
						),
		"alternative_description" => array(  
						"name" => "_{$prefix}_alternative_description",  
						"type" => "textarea",  
						"rows" => 3,
						"cols" => 40,
						"std" => "",  
						"title" => __( 'Head Description', $domain ),  
						"description" => __( 'If specified, this description overrides the excerpt for use in the head.', $domain ),
						"allow_tags" => false,
						),
		"secondary_description" => array(  
						"name" => "_{$prefix}_secondary_desc",  
						"type" => "textarea",  
						"rows" => 3,
						"cols" => 40,
						"std" => "",  
						"title" => __( 'Secondary (On-Page) Description', $domain ),  
						"description" => __( 'If specified, this description can be displayed in the post or page body.', $domain ),
						"allow_tags" => true,
						),
		);
		
		// clean up our array according to options set
		if (!$this->opt('editing_title')) unset($meta_set['secondary_title']);
		if (!$this->opt('editing_description')) unset($meta_set['alternative_description']);
		if (!$this->opt('editing_keywords')) unset($meta_set['keywords']);
		
		$page_set = $post_set = $meta_set;
		
		if (!$this->opt('editing_secondary_description_pages')) unset($page_set['secondary_description']);
		
		if (!$this->opt('editing_secondary_description_posts')) unset($post_set['secondary_description']);
		
		$docounter = ($this->opt('editing_counter') && $this->opt('editing_description')) ? "_{$prefix}_alternative_description" : '';
		
		$cust_types = $this->opt('support_custom_post_types');
		
		// and do it!
		
		$args = compact('name', 'prefix', 'post_set', 'page_set', 'restricted', 'docounter', 'cust_types');
		
		new ghpseoWritingAdditions($args);
		
		return;
		
	} // end doing the writing additions

} // end writing setup class

new ghpseoWritingSetup("Greg's High Performance SEO", 'ghpseo');

?>