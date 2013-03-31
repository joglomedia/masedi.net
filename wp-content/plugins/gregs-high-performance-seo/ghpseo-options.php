<?php

/*  Greg's Options Page Setup
	
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

require_once('ghpseo-options-functions.php');

function ghpseo_options_setngo($option_style = 'consolidate') { // set up our options pages
	$name = "Greg's High Performance SEO";
	$plugin_prefix = 'ghpseo';
	$domain = $plugin_prefix . '-plugin'; // text domain
	$instname = 'instructions'; // name of page holding instructions
	$plugin_page = " <a href=\"http://gregsplugins.com/lib/plugin-details/gregs-high-performance-seo/\">Greg's High Performance SEO plugin</a>";
	$paypal_button = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=2799661"><img src="https://www.paypal.com/en_GB/i/btn/btn_donate_LG.gif" name="paypalsubmit" alt="" border="0" /></a>';
	$notices = array();
	// WP 3.0 apparently fails occasionally to allow plugins newly activated on a subdomain to add options, so if we have no options, this will let us know; note that the workaround assumes consolidated options style
	if (false === get_option("{$plugin_prefix}_settings"))
		$notices[] = array(
						'error',
						__("On rare occasions when using WordPress 3.0+ in multisite/network mode, WordPress interferes with the normal process by which plugins first save their settings with default values. This plugin has detected that its default settings have not yet been saved, and it will not operate correctly with empty settings. Please deactivate the plugin from your plugin management screen, and then reactivate it. Hopefully WordPress will then allow the plugin to initialise its required settings.", $domain),
						);
	$replacements = array( // values we'll swap out in our option page text
						'%plugin_page%' => $plugin_page,
						'%paypal_button%' => $paypal_button,
						);
	$standard_warning = __('The plugin listed above, which employs output buffering hacks to circumvent limitations imposed by WordPress APIs, may interfere with the usability of many different plugins designed to enhance the functionality of the head section of WordPress output. It may interfere with the normal operation of this plugin:', $domain);
	$problems = array( // these indicate presence of other plugins which may cause problems
				'headspace' => array(
					'class' => 'HeadSpace2_Plugin',
					'name' => 'HeadSpace 2',
					'warning' => $standard_warning,
					 ),
				'aiosp' => array(
					'class' => 'All_in_One_SEO_Pack',
					'name' => 'All in One SEO Pack',
					'warning' => $standard_warning,
					 ),
				'platinum' => array(
					'class' => 'Platinum_SEO_Pack',
					'name' => 'Platinum SEO Pack',
					'warning' => $standard_warning,
					 ),
				'metaseo' => array(
					'class' => 'MetaSeoPack',
					'name' => 'Meta SEO Pack',
					'warning' => $standard_warning,
					 ),
				'seoultimate' => array(
					'class' => 'SU_Module',
					'name' => 'SEO Ultimate',
					'warning' => $standard_warning,
					 ),
				'wpseo' => array(
					'class' => 'wpSEO',
					'name' => 'wpSEO',
					'warning' => $standard_warning,
					 ),
				);
	$pages = array ( // file names and titles for each page of options
				   'default' => array(
				   "$name: " . __('Configuration',$domain),
				   __('Configuration',$domain),
				   ),
				   'maintitles' => array(
				   "$name: " . __('Main Titles',$domain),
				   __('Main Titles',$domain),
				   ),
				   'secondarytitles' => array(
				   "$name: " . __('Secondary (Body) Titles',$domain),
				   __('Secondary Titles',$domain),
				   ),
				   'secondarydesc' => array(
				   "$name: " . __('Secondary Descriptions',$domain),
				   __('Secondary Descriptions',$domain),
				   ),
				   'pagedcomments' => array(
				   "$name: " . __('Paged Comments',$domain),
				   __('Paged Comments',$domain),
				   ),
				   'headmeta' => array(
				   "$name: " . __('Head Meta',$domain),
				   __('Head Meta',$domain),
				   ),
				   'legacy' => array(
				   "$name: " . __('Support for Legacy SEO Plugins',$domain),
				   __('Legacy SEO Plugins',$domain),
				   ),
				   $instname => array(
				   "$name: " . __('Instructions and Background Information',$domain),
				   __('Instructions',$domain),
				   ),
				   'donating' => array(
				   "$name: " . __('Support This Plugin',$domain),
				   __('Contribute',$domain),
				   ),
				   );
	
	$args = compact('plugin_prefix','instname','replacements','pages','notices','problems','option_style');
	
	$options_handler = new ghpseoOptionsHandler($args); // prepares settings
	
	// just in case we need to grab anything from the parsed result first, this is where we'd do it
	
	$options_handler->display_options($name); // now show the page
	
	return;
} // end displaying the options

if (current_user_can('manage_options')) ghpseo_options_setngo();

?>