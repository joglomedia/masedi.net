<?php

DEFINE('_ISO','charset=UTF-8');

if (!function_exists ('is_admin'))
{
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
}
elseif (!class_exists('OnPageSEOAdmin'))
{
	class OnPageSEOAdmin
	{
		/**
		 * Variables
		 */

		var $postMetaDataName = 'onpageseo_post_meta_data';
		var $copyscapeMetaDataName = 'onpageseo_post_copyscape';
		var $options = array();
		var $developerOptions = array();
		var $pagehook;
		var $manageKeywordsHook;
		var $nonPostHook;
		var $postID;
		var $postMeta = array();
		var $seoReport = array();
		var $totalScore = 0;
		var $keywordDensity = 0;
		var $minimumScore = 70;
		var $postRecency = '3 months';
		var $update;
		var $license;
		var $licenseHide = 0;
		var $copyscapeResults;
		var $importError = 0;
		var $importErrorMessage;
		var $successMessage = 0;
		var $pwProtectionLoggedIn = 0;
		var $permalink;
		var $title;
		var $descriptionMetaTag;
		var $keywordsMetaTag;
		var $h1 = array();
		var $h2 = array();
		var $h3 = array();
		var $hexKeyword;
		var $hexRegEx;
		var $charEncoding = 'UTF-8';
		var $savePostFlag = 0;
		var $analyzeErrorMessage;
		var $networkAdminNewSites;
		var $networkAdminError;



		/**
		 * PHP 4 constructor (for backwards compatibility)
		 *
		 * @param	array	$args
		 * @return	bool	true
		 */

		function OnPageSEOAdmin($args)
		{
			$this->__construct($args);
			return;
		}



		/**
		 * PHP 5 constructor
		 *
		 * @param	array	$args
		 * @return	void
		 */

		function __construct($args)
		{
			extract($args);

			// Sanitize Post ID
			$this->sanitizePostID();

			// Import Settings
			if(isset($_REQUEST[OPSEO_PREFIX.'_import_settings'])) { $this->importSettings(); }

			// Get Options
			if(!$this->options)
			{
				$this->options = $this->getOptions();
			}

			// Get Update Information
			$this->getUpdate();

			// Get License Information
			$this->getLicense();

			// Init
			add_action('init', array($this, 'opseoInit'));

			// Options Menu
			add_action('admin_menu', array($this,'adminMenu'));

			// Network Admin Menu
			add_action('network_admin_menu', array($this,'networkAdminMenu'));

			// Network Admin New Site
			add_action('wpmu_new_blog', array($this, 'networkAdminNewSite'), 10, 6); 

			// Register Options
			add_action('admin_init', array($this, 'optionsInit'));

			// Enqueue Scripts
			add_action('admin_enqueue_scripts', array($this, 'enqueueScripts'));

			// Automatic Decorations (Admin-Side)
			if(isset($this->options['decoration_type']) && (strlen(trim($this->options['decoration_type'])) > 0) && ($this->options['decoration_type'] == 'admin'))
			{
				add_filter('wp_insert_post_data', array($this,'automaticDecorations'), 10, 2);
			}

			// Admin Head
			//add_action('admin_head', array($this, 'ajaxCopyscape'), 10, 2);
			add_action('wp_ajax_onpageseo_copyscape', array($this, 'ajaxCopyscapeCheck'));
			add_action('wp_ajax_onpageseo_copyscape_balance', array($this, 'ajaxCopyscapeBalance'));
			add_action('wp_ajax_onpageseo_lsi_keywords', array($this, 'ajaxLSIKeywords'));

			add_action('wp_ajax_onpageseo_seo_report', array($this, 'ajaxSEOReport'));

			// Save Post/Page
			add_action('save_post', array($this, 'saveMetaData'), 10, 2);

			// Modify Post Columns
			add_action('manage_posts_custom_column', array($this, 'displayEditColumns'), 10, 2);
			add_filter('manage_posts_columns', array($this, 'addEditColumns'));

			// Modify Page Columns
			add_action('manage_pages_custom_column', array($this, 'displayEditColumns'), 10, 2);
			add_filter('manage_pages_columns', array($this, 'addEditColumns'));

			// Add Meta Boxes
			if(!$this->license->isLicenseError())
			{
				add_action('admin_menu', array($this,'addMetaBoxes'));
			}

			// Check For Updates
			add_action('after_plugin_row', array($this, 'checkForUpdates'));
		}



		function getUpdate()
		{
			// Include Update Class
			require_once('onpageseo-admin-update.php');

			// Initialize Update Object
			$this->update = new OnPageSEOUpdate($this->options);
		}



		function checkForUpdates($plugin)
		{
			if(strpos($plugin, OPSEO_PREFIX) !== false)
				$this->update->getUpdateInfo(1);
		}



		function getLicense()
		{
			// Include License Class
			require_once('onpageseo-admin-license.php');

			// Initialize License Object
			$this->license = new OnPageSEOLicense($this->options);
		}



		/**
		 * Creates main plugin options when plugin gets activated
		 *
		 * @param	void
		 * @return	void
		 */

		function activatePlugin()
		{
			// Get Options
			$this->options = $this->getOptions();
		}



		/**
		 * Get main plugin options (or add default values if not found)
		 *
		 * @param	void
		 * @return	array	$options
		 */

		function getOptions()
		{
			$options = get_option(OPSEO_PREFIX.'_options');

			// Options Exist
			if($options)
			{
				// Validate Required Options
				$options = $this->validateRequiredOptions($options);
				// 7-6-2012
				$options['unicode_support'] = 1;
				$update = $options['temp_update'];
				unset($options['temp_update']);

				// Update Options If Necessary
				if($update) { update_option(OPSEO_PREFIX.'_options', $options); }
			}
			// No Options Exist - Set Default
			else
			{
				$options = $this->getDefaultOptions();
				add_option(OPSEO_PREFIX.'_options', $options);
			}

			// Get Developer Options
			if(!$this->licenseHide) { $this->licenseHide = get_option(OPSEO_PREFIX.'_license_hide'); }

			return($options);
		}



		/**
		 * Get main plugin developer options
		 *
		 * @param	void
		 * @return	array	$options
		 */

		function getDeveloperOptions()
		{
			$options = get_option(OPSEO_PREFIX.'developer_options');

			// Create If Doesn't Exist
			if(!$options)
			{
				$options = array();
				add_option(OPSEO_PREFIX.'_options', $options);
			}

			return($options);
		}


		/**
		 * Verify required plugin options
		 *
		 * @param	void
		 * @return	bool
		 */

		function validateRequiredOptions($options)
		{
			$options['temp_update'] = 0;

			// Import Stop Words
			ob_start();
			include_once('templates/english_stop_words.txt');
			$stopWords = ob_get_contents();
			ob_end_clean();

			$requiredNumeric = array(
						"keyword_density_minimum"=>"2.0",
						"keyword_density_maximum"=>"5.5",
						"keyword_density_formula"=>"1",
						"description_meta_tag_maximum"=>"160",
						"post_content_length"=>"300",
						"title_length_minimum"=>"3",
						"title_length_maximum"=>"66",
						"posts_per_page"=>"20",
						"lsi_keyword_maximum_results"=>"50",
						"internal_links_posts_per_page"=>"10",
						"internal_images_per_page"=>"20",
						"request_timeout"=>"100"
						);

			$requiredAlpha = array(
						"bold_style"=>"b",
						"italic_style"=>"i",
						"underline_style"=>"u",
						"keyword_density_type"=>"post",
						"lsi_keyword_region"=>"us|en",
						"lsi_keyword_region_bing"=>"en-US",
						"lsi_keyword_sort"=>"frequency",
						"copyscape_role"=>"administrator",
						"password_activation"=>"deactivated",
						"password_file_path"=>trailingslashit(OPSEO_PLUGIN_FULL_PATH)."cookie.txt",
						"stop_words"=>$stopWords
						);

			$requiredFactors = array(
						"title_factor"=>"1",
						"title_beginning_factor"=>"1",
						"title_words_factor"=>"1",
						"title_characters_factor"=>"1",
						"url_factor"=>"1",
						"description_meta_factor"=>"1",
						"description_chars_meta_factor"=>"1",
						"description_beginning_meta_factor"=>"1",
						"keywords_meta_factor"=>"1",
						"h1_factor"=>"1",
						"h1_beginning_factor"=>"1",
						"h2_factor"=>"1",
						"h3_factor"=>"1",
						"content_words_factor"=>"1",
						"content_kw_density_factor"=>"1",
						"content_first_factor"=>"1",
						"content_alt_factor"=>"1",
						"content_bold_factor"=>"1",
						"content_italic_factor"=>"1",
						"content_underline_factor"=>"1",
						"content_external_link_factor"=>"1",
						"content_internal_link_factor"=>"1",
						"content_last_factor"=>"1",
						"shortcode_support"=>"1",
						"unicode_support"=>"1"
						);

			$requiredColumns = array(
						"posts_columns_score"=>"1",
						"posts_columns_keyword"=>"1"
						);

			foreach($requiredNumeric as $key=>$value)
			{
				// Required Option Not Valid
				if( !isset($options[$key]) || (strlen(trim($options[$key])) == 0) || !is_numeric($options[$key]) )
				{
					// Set Default Option Value
					$options[$key] = $value;
					$options['temp_update'] = 1;
				}
			}

			foreach($requiredAlpha as $key=>$value)
			{
				// Required Option Not Valid
				if( !isset($options[$key]) || (strlen(trim($options[$key])) == 0) )
				{
					// Set Default Option Value
					$options[$key] = $value;
					$options['temp_update'] = 1;
				}
			}

			if(!isset($options['factor_update']))
			{
				foreach($requiredFactors as $key=>$value)
				{
					// Required Option Not Valid
					if( !isset($options[$key]) || (strlen(trim($options[$key])) == 0) )
					{
						// Set Default Option Value
						$options[$key] = $value;
						$options['temp_update'] = 1;
					}
				}

				// On-Page SEO Factors Updated
				$options['factor_update'] = 1;
			}

			if(!isset($options['columns_update']))
			{
				foreach($requiredColumns as $key=>$value)
				{
					// Required Option Not Valid
					if( !isset($options[$key]) || (strlen(trim($options[$key])) == 0) )
					{
						// Set Default Option Value
						$options[$key] = $value;
						$options['temp_update'] = 1;
					}
				}

				// Columns Updated
				$options['columns_update'] = 1;
			}

			return($options);
		}



		/**
		 * Get the default plugin options
		 *
		 * @param	void
		 * @return	array	$options
		 */

		function getDefaultOptions()
		{
			// Import Stop Words
			ob_start();
			include_once('templates/english_stop_words.txt');
			$stopWords = ob_get_contents();
			ob_end_clean();

			$options = array(
					"bold_keyword"=>"1",
					"bold_style"=>"strong",
					"italic_keyword"=>"1",
					"italic_style"=>"em",
					"underline_keyword"=>"1",
					"underline_style"=>"fontdecorationunderline",
					"keyword_density_minimum"=>"2.0",
					"keyword_density_maximum"=>"5.5",
					"keyword_density_formula"=>"1",
					"keyword_density_type"=>"post",
					"description_meta_tag_maximum"=>"160",
					"post_content_length"=>"300",
					"title_length_minimum"=>"3",
					"title_length_maximum"=>"66",
					"posts_per_page"=>"20",
					"lsi_keyword_region"=>"us|en",
					"lsi_keyword_region_bing"=>"en-US",
					"lsi_keyword_sort"=>"frequency",
					"lsi_keyword_maximum_results"=>"50",
					"internal_links_posts_per_page"=>"10",
					"internal_images_per_page"=>"20",
					"request_timeout"=>"100",
					"title_factor"=>"1",
					"title_beginning_factor"=>"1",
					"title_words_factor"=>"1",
					"title_characters_factor"=>"1",
					"url_factor"=>"1",
					"description_meta_factor"=>"1",
					"description_chars_meta_factor"=>"1",
					"description_beginning_meta_factor"=>"1",
					"keywords_meta_factor"=>"1",
					"h1_factor"=>"1",
					"h1_beginning_factor"=>"1",
					"h2_factor"=>"1",
					"h3_factor"=>"1",
					"content_words_factor"=>"1",
					"content_kw_density_factor"=>"1",
					"content_first_factor"=>"1",
					"content_alt_factor"=>"1",
					"content_bold_factor"=>"1",
					"content_italic_factor"=>"1",
					"content_underline_factor"=>"1",
					"content_external_link_factor"=>"1",
					"content_internal_link_factor"=>"1",
					"content_last_factor"=>"1",
					"copyscape_confirm"=>"1",
					"factor_update"=>"1",
					"password_activation"=>"deactivated",
					"password_file_path"=>trailingslashit(OPSEO_PLUGIN_FULL_PATH)."cookie.txt",
					"posts_columns_score"=>"1",
					"posts_columns_keyword"=>"1",
					"stop_words"=>$stopWords,
					"shortcode_support"=>"1",
					"unicode_support"=>"1"
					);

			return($options);
		}



		/**
		 * Register plugin options
		 *
		 * @param	void
		 * @return	void
		 */

		function optionsInit()
		{
			// Process Actions/Commands
			if(current_user_can('edit_plugins'))
				$this->processActions();

			register_setting( OPSEO_PREFIX.'_settings', OPSEO_PREFIX.'_options' );
			register_setting( OPSEO_PREFIX.'_developer', OPSEO_PREFIX.'_developer_options' );
		}



		function opseoInit()
		{
			if(function_exists('load_plugin_textdomain'))
			{
				load_plugin_textdomain(OPSEO_TEXT_DOMAIN, false, OPSEO_PLUGIN_DIR_NAME.'/languages');
			}

			// Create SEO Factor Profile Table
			//$this->seoProfileDBTable();
		}



		function enqueueScripts()
		{
			global $pagenow;
			if (false !== strpos($pagenow, 'post') || false !== strpos($pagenow, 'page'))
			{
				wp_enqueue_style('onpageseo-css', OPSEO_PLUGIN_URL.'/style/style.css');
				wp_enqueue_style('thickbox');
				wp_enqueue_script('jquery');
				wp_enqueue_script('jquery-ui-core');
				wp_enqueue_script('jquery-ui-draggable');
				wp_enqueue_script('jquery-ui-droppable');
				wp_enqueue_script('jquery-ui-sortable');
				wp_enqueue_script('jquery-ui-tabs');
				wp_enqueue_script('thickbox');
				wp_enqueue_script('onpageseo-ajax-js', OPSEO_PLUGIN_URL.'/js/ajax.js');
			}
		}



		/**
		 * Adds the "On-Page SEO" menu to the WP Admin Dashboard
		 *
		 * @param	void
		 * @return	void
		 */

		function adminMenu()
		{
			// Add a new top-level menu:
			add_menu_page('Easy WP SEO', 'Easy WP SEO', 'administrator', 'onpageseo-settings', array($this,'updatePluginOrSettings'));

			// Add a submenu to the custom top-level menu:
			$this->pagehook = add_submenu_page('onpageseo-settings', __('Settings', OPSEO_TEXT_DOMAIN), __('Settings', OPSEO_TEXT_DOMAIN), 'administrator', 'onpageseo-settings', array($this,'updatePluginOrSettings'));

			if(!$this->license->isLicenseError())
			{
				// Add a submenu to the custom top-level menu:
				$this->manageKeywordsHook = add_submenu_page('onpageseo-settings', __('Manage Keywords', OPSEO_TEXT_DOMAIN), __('Manage Keywords', OPSEO_TEXT_DOMAIN), 'administrator', 'onpageseo-manage-keywords', array($this,'keywordsMenu'));

				// Add a submenu to the custom top-level menu:
				$this->nonPostHook = add_submenu_page('onpageseo-settings', __('URL Analyzer', OPSEO_TEXT_DOMAIN), __('URL Analyzer', OPSEO_TEXT_DOMAIN), 'administrator', 'onpageseo-url-analyzer', array($this,'nonPostMenu'));

				// Manage Keywords Scripts
				add_action('load-'.$this->manageKeywordsHook, array($this, 'settingsAdminMenu'));

				// admin_print_styles
				add_action('load-'.$this->nonPostHook, array($this, 'settingsNonPostMenu'));
			}

			add_action('load-'.$this->pagehook, array($this, 'settingsAdminMenu'));
		}


		/**
		 * Adds the "On-Page SEO" menu to the WP Network Admin Dashboard
		 *
		 * @param	void
		 * @return	void
		 */

		function networkAdminMenu()
		{
			// Add a new top-level menu:
			$this->manageKeywordsHook = add_menu_page('Easy WP SEO', 'Easy WP SEO', 'administrator', 'onpageseo-network-settings', array($this,'networkSettingsMenu'));

			// Network Admin Settings Scripts
			add_action('load-'.$this->manageKeywordsHook, array($this, 'settingsAdminMenu'));
		}



		/**
		 * Display for the "Settings" section of the "On-Page SEO" menu
		 *
		 * @param	void
		 * @return	void
		 */

		function networkSettingsMenu()
		{
			// Network New Sites Updated
			if($this->strExists($_REQUEST['action']) && $_REQUEST['action'] == 'network-new-sites')
			{
				if( ($this->strExists($_REQUEST['onpageseoNewBlogID']) && is_numeric($_REQUEST['onpageseoNewBlogID'])) || !$this->strExists($_REQUEST['onpageseoNewBlogID']) )
				{
					update_option(OPSEO_PREFIX.'_network_new_sites', $_REQUEST['onpageseoNewBlogID']);
				}
			}

			// Get Default New Sites Option
			$this->networkAdminNewSites = get_option(OPSEO_PREFIX.'_network_new_sites');

			// Network Settings Updated
			if($this->strExists($_REQUEST['action']) && $_REQUEST['action'] == 'network-settings')
			{
				$this->networkAdminUpdateSettings($_REQUEST['onpageseoBlogID'], $_REQUEST['onpageseoSecondaryIDs']);
			}

			include_once('templates/admin-network-settings-menu.php');
		}




		/**
		 * Updates Sites with Default Settings in WP Network Admin Dashboard
		 *
		 * @param	string	$blogID
		 * @param	array	$secondaryIDs
		 * @return	void
		 */

		function networkAdminUpdateSettings($blogID, $secondaryIDs)
		{
			global $wpdb;

			// Get Default Network Blog ID
			$oldBlogID = $wpdb->blogid;

			// Default Blog Site
			if($this->strExists($blogID) && is_numeric($blogID))
			{
				// Switch To Blog
				switch_to_blog($blogID);

				// Get Default Site Blog Settings
				$settings = get_option(OPSEO_PREFIX.'_options');
				$licenseHide = get_option(OPSEO_PREFIX.'_license_hide');

				// Secondary IDs
				if(is_array($secondaryIDs) && (sizeof($secondaryIDs) > 0))
				{
					for($i = 0; $i < sizeof($secondaryIDs); $i++)
					{
						// Perform Update If Not Same Blog As Default
						if($secondaryIDs[$i] != $blogID)
						{
							// Switch To Blog
							switch_to_blog($secondaryIDs[$i]);

							// Update Options
							update_option(OPSEO_PREFIX.'_options', $settings);

							// Update License Options
							update_option(OPSEO_PREFIX.'_license_hide', $licenseHide);
						}
					}
				}
				else
				{
					// Secondary Blog IDs Not Found
					$this->networkAdminError = 2;
				}
			}
			else
			{
				// Default Blog Site ID Not Found
				$this->networkAdminError = 1;
			}

			// Switch To Default Network Blog
			switch_to_blog($oldBlogID);
		}




		/**
		 * Update New Sites Added to the Network with Default Settings
		 *
		 * @param	string	$blog_id
		 * @param	string	$user_id
		 * @param	string	$domain
		 * @param	string	$path
		 * @param	string	$site_id
		 * @param	string	$meta
		 * @return	void
		 */

		function networkAdminNewSite($blog_id, $user_id, $domain, $path, $site_id, $meta)
		{
			global $wpdb;
			$oldBlogID = $wpdb->blogid;

			// Get Default New Sites Option
			$defaultBlogID = get_option(OPSEO_PREFIX.'_network_new_sites');

			if($this->strExists($defaultBlogID) && $this->strExists($blog_id) && is_numeric($blog_id))
			{
				// Switch To Default Blog
				switch_to_blog($defaultBlogID);

				// Get Default Site Blog Settings
				$settings = get_option(OPSEO_PREFIX.'_options');
				$licenseHide = get_option(OPSEO_PREFIX.'_license_hide');

				// Switch To New Blog
				switch_to_blog($blog_id);

				// Update Options
				update_option(OPSEO_PREFIX.'_options', $settings);

				// Update License Options
				update_option(OPSEO_PREFIX.'_license_hide', $licenseHide);

				// Switch To Old Blog
				switch_to_blog($oldBlogID);
			}
		}






		function settingsNonPostMenu()
		{
			wp_enqueue_style('onpageseo-css', OPSEO_PLUGIN_URL.'/style/style.css');
			wp_enqueue_script('common');
			wp_enqueue_script('wp-lists');
			wp_enqueue_script('postbox');
			wp_enqueue_style('thickbox');
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script('jquery-ui-draggable');
			wp_enqueue_script('jquery-ui-droppable');
			wp_enqueue_script('jquery-ui-sortable');
			wp_enqueue_script('jquery-ui-tabs');
			wp_enqueue_script('thickbox');
			wp_enqueue_script('onpageseo-ajax-js', OPSEO_PLUGIN_URL.'/js/ajax.js');
			wp_enqueue_script('onpageseo-url-analyzer-js', OPSEO_PLUGIN_URL.'/js/url-analyzer.js');

			add_filter('screen_layout_columns', array($this, 'screenLayoutColumns'), 10, 2);

			// URL Analyzer 2 Columns Fix For Wordpress 3.3 (12-23-2011)
			add_filter('get_user_option_screen_layout_'.$this->nonPostHook, array($this, 'screenLayoutColumnsSelected'));

			add_meta_box('opseo-metaboxes-sidebox-1', 'Easy WP SEO', array($this, 'scoreMetaBox'), $this->nonPostHook, 'side', 'core');
			add_meta_box('opseo-metaboxes-contentbox-1', __('Title', OPSEO_TEXT_DOMAIN), array($this, 'nonPostTitle'), $this->nonPostHook, 'normal', 'core');
			add_meta_box('opseo-metaboxes-contentbox-2', __('URL', OPSEO_TEXT_DOMAIN), array($this, 'nonPostURL'), $this->nonPostHook, 'normal', 'core');
		}



		function screenLayoutColumns($columns, $screen)
		{
			if ($screen == $this->nonPostHook)
			{
				$columns[$this->nonPostHook] = 2;
			}

			return $columns;
		}



		function screenLayoutColumnsSelected()
		{

			return 2;
		}



		function nonPostTitle()
		{
			echo '<input type="text" name="nonpost-title" id="nonpost-title" value="'.stripslashes($_REQUEST['nonpost-title']).'" style="width:100% !important;" />';
		}



		function nonPostURL()
		{
			echo '<input type="text" name="nonpost-url" id="nonpost-url" value="'.stripslashes($_REQUEST['nonpost-url']).'" style="width:100% !important;" />';

			echo '<table border="0" cellspacing="0" cellpadding="0"><tr><td style="padding-right:20px !important;">';

			echo '<p id="categorieslinkplus" style="text-align:left !important;"><a href="#" onclick="jQuery(this).toggleOPSEOURL(1);return false;" style="text-decoration:underline !important;color:rgb(33,117,155);">+ '.__('Categories', OPSEO_TEXT_DOMAIN).'</a></p>';
			echo '<p id="categorieslinkminus" style="text-align:left !important;"><a href="#" onclick="jQuery(this).toggleOPSEOURL(0);return false;" style="text-decoration:underline !important;color:rgb(33,117,155);">- '.__('Categories', OPSEO_TEXT_DOMAIN).'</a></p>';

			echo '</td><td>';

			echo '<p id="archiveslinkplus" style="text-align:left !important;"><a href="#" onclick="jQuery(this).toggleOPSEOURL(3);return false;" style="text-decoration:underline !important;color:rgb(33,117,155);">+ '.__('Archives', OPSEO_TEXT_DOMAIN).'</a></p>';
			echo '<p id="archiveslinkminus" style="text-align:left !important;"><a href="#" onclick="jQuery(this).toggleOPSEOURL(2);return false;" style="text-decoration:underline !important;color:rgb(33,117,155);">- '.__('Archives', OPSEO_TEXT_DOMAIN).'</a></p>';

			echo '</td></tr></table>';

			echo '<div id="opseocategories" style="width:100% !important;"><select name="opseo-categories-select" id="opseo-categories-select" size="5" style="width:50% !important;height:75px !important;margin:0 !important;">';

			$args = array('type'=>'post', 'orderby'=>'name', 'order'=>'ASC', 'hide_empty'=>0, 'hierarchical'=>1);
			$categories = get_categories($args); 

			foreach($categories as $category)
			{
  				echo '<option value="'.get_category_link($category->cat_ID).'" title="'.$category->cat_name.'">'.$category->cat_name.'</option>';
			}

			echo '</select></div>';

			echo '<div id="opseoarchives" style="width:100% !important;"><select name="opseo-archives-select" id="opseo-archives-select" size="5" style="width:50% !important;height:75px !important;margin:0 !important;">';

			$args = array('type'=>'monthly', 'format'=>'option', 'show_post_count'=>0);
			wp_get_archives($args);

			echo '</select></div>';


		}



		/**
		 * Displays admin header for the "Settings" pages
		 *
		 * @param	string	$pageSlug
		 * @param	string	$pageName
		 * @return	void
		 */

		function adminHeader($pageSlug, $pageName, $headerType=1)
		{
			($headerType == 1) ? include_once('templates/admin-header.php') : include_once('templates/admin-network-header.php');
		}



		/**
		 * Display for the Update Plugin screen
		 *
		 * @param	void
		 * @return	void
		 */

		function updatePluginScreen()
		{?>
			<div class="wrap"><div id="icon-plugins" class="icon32"><br /></div>
			<h2><?php echo __('Upgrade Plugin', OPSEO_TEXT_DOMAIN);?></h2>

				<?php if(!$this->update->updatePlugin(OPSEO_PLUGIN_PATH)) { wp_die('install_failed', __('Plugin upgrade failed', OPSEO_TEXT_DOMAIN)); }?>

			</div>
		<?php }



		/**
		 * Display Update Plugin or Settings screen
		 *
		 * @param	void
		 * @return	void
		 */

		function updatePluginOrSettings()
		{
			// Update Plugin Screen
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'upgrade') { $this->updatePluginScreen(); }
			// Settings Screen
			else { $this->settingsMenu(); }
		}



		/**
		 * Display for the "Settings" section of the "On-Page SEO" menu
		 *
		 * @param	void
		 * @return	void
		 */

		function settingsMenu()
		{
			if(!$this->license->isLicenseError()) { include_once('templates/admin-settings-menu.php'); }
			else { include_once('templates/admin-enter-license.php'); }
		}



		/**
		 * Display License information
		 *
		 * @param	void
		 * @return	void
		 */

		function licenseFooter()
		{
			include_once('templates/admin-license-footer.php');
		}



		/**
		 * Display Reset information
		 *
		 * @param	void
		 * @return	void
		 */

		function resetFooter()
		{
			include_once('templates/admin-reset-footer.php');
		}



		/**
		 * Options panel for the Settings menu
		 *
		 * @param	void
		 * @return	void
		 */

		function settingsAdminMenu()
		{
			wp_enqueue_style('onpageseo-settings-css', OPSEO_PLUGIN_URL.'/style/settings-style.css');
			wp_enqueue_style('thickbox');
			wp_enqueue_script('jquery');
			wp_enqueue_script('thickbox');
		}



		/**
		 * Display for the "Manage Keywords" section of the "On-Page SEO" menu
		 *
		 * @param	void
		 * @return	void
		 */

		function keywordsMenu()
		{
			if(!$this->license->isLicenseError()) { include_once('templates/admin-keywords-menu.php'); }
			else { include_once('templates/admin-enter-license.php'); }
		}



		/**
		 * Display for the "Non-Post" section of the "On-Page SEO" menu
		 *
		 * @param	void
		 * @return	void
		 */

		function nonPostMenu()
		{
			if(!$this->license->isLicenseError())
			{
				// Create Non-Post URLs Table
				$this->nonPostDBTable();

				include_once('templates/admin-non-post.php');
			}
			else { include_once('templates/admin-enter-license.php'); }
		}



		function nonPostDBTable()
		{
			global $wpdb;
			global $blog_id;

			$table_name = $wpdb->prefix.'onpageseo_urls';

			if(!$wpdb->get_var('SELECT COUNT(*) FROM '.$table_name))
			{
				$sql = "CREATE TABLE ".$table_name." (
					id bigint(20) unsigned NOT NULL auto_increment,
					blog_id int(11) NOT NULL default '0',
					name tinytext NOT NULL default '',
					url tinytext NOT NULL,
					score longtext NOT NULL,
					report longtext NOT NULL,
					modified datetime NOT NULL default '0000-00-00 00:00:00',
					PRIMARY KEY  (id),
					UNIQUE KEY id (id)
				);";

 				require_once(ABSPATH.'wp-admin/includes/upgrade.php');
 				dbDelta($sql);
			}
		}


		function addNonPostURL()
		{
			global $wpdb;
			global $blog_id;

			$table_name = $wpdb->prefix.'onpageseo_urls';

			$wpdb->query( $wpdb->prepare( "INSERT INTO {$table_name} ( blog_id, name, url, score, modified ) VALUES ( %d, %s, %s, %s, %s )", 
        				$blog_id, $_REQUEST['nonpost-title'], $_REQUEST['nonpost-url'], serialize($this->postMeta), date('Y-m-d H:i:s', time()) ) );
		}


		function editNonPostURL($url_id)
		{
			global $wpdb;

			$table_name = $wpdb->prefix.'onpageseo_urls';

			$wpdb->query( $wpdb->prepare( "UPDATE {$table_name} SET name=%s, url=%s, score=%s, modified=%s WHERE id=%d", 
        				$_REQUEST['nonpost-title'], $_REQUEST['nonpost-url'], serialize($this->postMeta), date('Y-m-d H:i:s', time()), $url_id ) );
		}



		function checkNonPostURL($url_id)
		{
			global $wpdb;
			global $blog_id;

			$table_name = $wpdb->prefix.'onpageseo_urls';

			if(!$wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$table_name} WHERE id=%d", $url_id))) { return(0); }
			else { return(1); }
		}



		function getNonPostURL($url_id)
		{
			global $wpdb;
			global $blog_id;

			$table_name = $wpdb->prefix.'onpageseo_urls';

			$results = $wpdb->get_results("SELECT * FROM $table_name WHERE id=$url_id");

			if($results)
			{
				foreach($results as $result)
				{
					$_REQUEST['nonpost-title'] = stripslashes($result->name);
					$_REQUEST['nonpost-url'] = stripslashes($result->url);
					$this->postMeta = $this->preUnSerialize($result->score);
				}
			}
		}




		function deleteNonPostURL($url_id)
		{
			global $wpdb;
			global $blog_id;

			$table_name = $wpdb->prefix.'onpageseo_urls';

			$wpdb->query( $wpdb->prepare( "DELETE FROM {$table_name} WHERE id=%d AND blog_id=%d", 
        				$url_id, $blog_id ) );
		}


		function clearNonPostURL($url_id)
		{
			global $wpdb;
			global $blog_id;

			$table_name = $wpdb->prefix.'onpageseo_urls';

			$wpdb->query( $wpdb->prepare( "UPDATE {$table_name} SET score='' WHERE id=%d and blog_id=%d", 
        				$url_id, $blog_id ) );
		}



		/**
		 * Create table for "SEO profiles"
		 *
		 * @param	void
		 * @return	void
		 */

		function seoProfileDBTable()
		{
			global $wpdb;
			global $blog_id;

			$table_name = $wpdb->prefix.'onpageseo_profiles';

			if(!$wpdb->get_var('SELECT COUNT(*) FROM '.$table_name))
			{
				$sql = "CREATE TABLE ".$table_name." (
					id bigint(20) unsigned NOT NULL auto_increment,
					blog_id int(11) NOT NULL default '0',
					keyword tinytext NOT NULL default '',
					profile longtext NOT NULL,
					modified datetime NOT NULL default '0000-00-00 00:00:00',
					PRIMARY KEY  (id),
					UNIQUE KEY id (id)
				);";

 				require_once(ABSPATH.'wp-admin/includes/upgrade.php');
 				dbDelta($sql);
			}
		}



		function addSEOProfile()
		{
			global $wpdb;
			global $blog_id;

			$table_name = $wpdb->prefix.'onpageseo_profiles';

			$wpdb->query( $wpdb->prepare( "INSERT INTO {$table_name} ( blog_id, keyword, profile, modified ) VALUES ( %d, %s, %s, %s )", 
        				$blog_id, $_REQUEST['mainkeyword'], serialize($this->postMeta), date('Y-m-d H:i:s', time()) ) );
		}


		function editSEOProfile($url_id)
		{
			global $wpdb;

			$table_name = $wpdb->prefix.'onpageseo_profiles';

			$wpdb->query( $wpdb->prepare( "UPDATE {$table_name} SET keyword=%s, profile=%s, modified=%s WHERE id=%d", 
        				$_REQUEST['mainkeyword'], serialize($this->postMeta), date('Y-m-d H:i:s', time()), $url_id ) );
		}




		/**
 		 * Generates the table for the admin module
 		 *
		 * @param  array	$cols		column headers for the table
		 * @param  array	$rows		multidemensional array containing all the rows
		 * @param  mixed	$msg		the message, if any, to add to bottom of the table
		 * @param  bool	$tfoot	whether to display the tfooter
		 * @param  bool	$add_break	whether to add a br tag at the bottom of the table
		 * @return string	$table
		 */

		function adminTable($cols, $rows, $msg = FALSE, $tfoot = TRUE, $add_break = FALSE)
		{
			$total_cols = count($cols);
			$total_rows = count($rows);

			$table = '<table class="widefat comments-box " cellspacing="0"><thead><tr>';
			$table_cols = '';
			for($i=0;$i<$total_cols;$i++)
			{
				//$table_cols .='<th>'.$cols[$i].'</th>';
				$table_cols .= $cols[$i];
			}

			$table .= $table_cols.'
';
			if($tfoot)
			{
				$table .= '<tfoot><tr>'.$table_cols.'</tr></tfoot>';
			}

			if($total_rows == 0)
			{
				$table .= '<tr><td colspan="'.$total_cols.'" align="center">'.__('Nothing Found', OPSEO_TEXT_DOMAIN).'</td></tr>';
			}
			else
			{
				for($i=0;$i<$total_rows;$i++)
				{
					$table .= '<tr>';
					$total_cols = count($rows[$i]);
					for($k=0;$k<$total_cols;$k++)
					{
						//$table .='<td>'.$rows[$i][$k].'</td>';
						$table .= $rows[$i][$k];
					}
					$table .= '<tr>';
				}
			}

			$table .= '<tbody id="the-comment-list" class="list:comment"></tbody></table>';

			if($add_break)
			{
				$table .= '<br />';
			}

			return $table;
		}




		function wpRobotDBTable()
		{
			global $wpdb;
			global $blog_id;

			$table_name = $wpdb->prefix.'onpageseo_wprobot';

			if(!$wpdb->get_var('SELECT COUNT(*) FROM '.$table_name))
			{
				$sql = "CREATE TABLE ".$table_name." (
					id bigint(20) unsigned NOT NULL auto_increment,
					blog_id int(11) NOT NULL default '0',
					post_title text NOT NULL default '',
					post_date datetime NOT NULL default '0000-00-00 00:00:00',
					PRIMARY KEY  (id),
					UNIQUE KEY id (id)
				);";

 				require_once(ABSPATH.'wp-admin/includes/upgrade.php');
 				dbDelta($sql);
			}
		}




		/**
		 * Displays the Score meta box on the edit post/page screen
		 *
		 * @param	void
		 * @return	void
		 */

		function addMetaBoxes()
		{
			if($this->strExists($this->options['unicode_support']))
			{
				header("Content-Type: text/html; charset=utf-8");
			}

			$metaData = get_post_meta($this->postID, $this->postMetaDataName, true);

			// Post Meta Data Already Exists
			if(!empty($metaData))
			{
				// Update Total Scores (In Real Time)
				if(is_array($metaData) && isset($metaData['onpageseo_global_settings']))
				{
					foreach($metaData as $key=>$val)
					{
						if($key != 'onpageseo_global_settings')
						{
							$metaData[$key]['TotalScore'] = $this->getKeywordScore($key, $metaData);
						}
					}
				}

				$this->postMeta = $metaData;

				$this->totalScore = $this->postMeta['score'];

				// Copyscape
				$copyscapeMetaData = get_post_meta($this->postID, $this->copyscapeMetaDataName, true);

				if(!empty($copyscapeMetaData))
				{
					$_REQUEST['allcopyscaperesultstemp'] = $copyscapeMetaData;
				}
			}

			if( function_exists('add_meta_box'))
			{
				foreach($this->getPostTypes() as $type)
				{
					// Hide Post Types 7-6-2012
					if(!isset($this->options['hide_'.$type]))
					{
						add_meta_box('onpageseo_post', 'Easy WP SEO', array($this, 'scoreMetaBox'), $type, 'side', 'high' );
					}
				}
			}
		}



		/**
		 * Returns all the registered post types
		 *
		 * @param	void
		 * @return	array
		 */

		function getPostTypes()
		{
			if(function_exists('get_post_types')) { return(get_post_types('','names')); }
			else { return(array('post','page')); }
		}



		/**
		 * Displays the Score meta box on the edit post/page screen
		 *
		 * @param	void
		 * @return	void
		 */

		function scoreMetaBox()
		{
			include_once('templates/admin-score-metabox.php');
		}



		/**
		 * Returns bullet class name for Score meta box
		 *
		 * @param	bool	$val
		 * @return	string
		 */

		function getMarkClass($val)
		{
			if($val){ return('onpageseoscorelitrue'); }
			else { return('onpageseoscorelifalse'); }
		}



		/**
		 * Returns bullet class name for Score meta box
		 *
		 * @param	bool	$val
		 * @return	string
		 */

		function getTotalScoreColorClass($score)
		{
			if($score >= $this->minimumScore) { return('onpageseogreenscore'); }
			else { return('onpageseoredscore'); }
		}



		/**
		 * Returns total score/keyword density class name for Score meta box
		 *
		 * @param	int	$score
		 * @return	string
		 */

		function getKeywordDensityColorClass($score)
		{
			if($score <= $this->options['keyword_density_maximum'] && $score >= $this->options['keyword_density_minimum']) { return('onpageseogreenscore'); }
			else { return('onpageseoredscore'); }
		}



		/**
		 * Returns total score/keyword density class name for Score meta box
		 *
		 * @param	int	$postID
		 * @return	array
		 */

		function getScoreKeyword($postID)
		{
			$metaData = get_post_meta($postID, $this->postMetaDataName, true);
			$mainKeyword = '';
			$totalScore = '';
			$kwDensityScore = '';

			if( isset($metaData['onpageseo_global_settings']) && is_array($metaData['onpageseo_global_settings']) )
			{
				$mainKeyword = $metaData['onpageseo_global_settings']['MainKeyword'];
				//$totalScore = $metaData[trim(strtolower($mainKeyword))]['TotalScore'];

				if($this->strExists($this->options['unicode_support']))
				{
					$totalScore = $this->getKeywordScore(mb_strtolower($mainKeyword, 'UTF-8'), $metaData);
					$kwDensityScore = $metaData[trim(mb_strtolower($mainKeyword, 'UTF-8'))]['KeywordDensityScore'];
				}
				else
				{
					$totalScore = $this->getKeywordScore(strtolower($mainKeyword), $metaData);
					$kwDensityScore = $metaData[trim(strtolower($mainKeyword))]['KeywordDensityScore'];
				}
			}

			return(array($totalScore,$mainKeyword,$kwDensityScore));
		}



		function getKeywordScore($keyword, $postMeta)
		{
			$totalCount = 0;
			$factorCount = 0;
			$score = 0;

			if(is_array($postMeta) && isset($postMeta[$keyword]))
			{
				// Title contains keyword.
				if(isset($this->options['title_factor']))
				{
					$totalCount += $postMeta[$keyword]['KeywordTitle'];
					$factorCount += 1;
				}

				// Title begins with keyword.
				if(isset($this->options['title_beginning_factor']))
				{
					$totalCount += $postMeta[$keyword]['KeywordTitleBeginning'];
					$factorCount += 1;
				}

				// Title contains at least # words.
				if(isset($this->options['title_words_factor']))
				{
					$totalCount += $postMeta[$keyword]['TitleWords'];
					$factorCount += 1;
				}

				// Title contains at least # characters.
				if(isset($this->options['title_characters_factor']))
				{
					$totalCount += $postMeta[$keyword]['TitleChars'];
					$factorCount += 1;
				}

				// Permalink contains keyword.
				if(isset($this->options['url_factor']))
				{
					$totalCount += $postMeta[$keyword]['Permalink'];
					$factorCount += 1;
				}

				// Description meta tag contains keyword.
				if(isset($this->options['description_meta_factor']))
				{
					$totalCount += $postMeta[$keyword]['DescriptionMetaTag'];
					$factorCount += 1;
				}

				// Description meta tag contains up to # characters.
				if(isset($this->options['description_chars_meta_factor']))
				{
					$totalCount += $postMeta[$keyword]['DescriptionMetaTagLength'];
					$factorCount += 1;
				}

				// Description meta tag begins with keyword.
				if(isset($this->options['description_beginning_meta_factor']))
				{
					$totalCount += $postMeta[$keyword]['DescriptionMetaTagBeginning'];
					$factorCount += 1;
				}

				// Keywords meta tag contains keyword.
				if(isset($this->options['keywords_meta_factor']))
				{
					$totalCount += $postMeta[$keyword]['KeywordsMetaTag'];
					$factorCount += 1;
				}

				// H1 tag contains keyword.
				if(isset($this->options['h1_factor']))
				{
					$totalCount += $postMeta[$keyword]['H1'];
					$factorCount += 1;
				}

				// H1 tag begins with keyword.
				if(isset($this->options['h1_beginning_factor']))
				{
					$totalCount += $postMeta[$keyword]['H1Beginning'];
					$factorCount += 1;
				}

				// H2 tag contains keyword.
				if(isset($this->options['h2_factor']))
				{
					$totalCount += $postMeta[$keyword]['H2'];
					$factorCount += 1;
				}

				// H3 tag contains keyword.
				if(isset($this->options['h3_factor']))
				{
					$totalCount += $postMeta[$keyword]['H3'];
					$factorCount += 1;
				}

				// Content contains at least # words.
				if(isset($this->options['content_words_factor']))
				{
					$totalCount += $postMeta[$keyword]['PostWords'];
					$factorCount += 1;
				}

				// Content has #-#% keyword density.
				if(isset($this->options['content_kw_density_factor']))
				{
					$totalCount += $postMeta[$keyword]['KeywordDensity'];
					$factorCount += 1;
				}

				// Content contains keyword in first 50-100 words.
				if(isset($this->options['content_first_factor']))
				{
					$totalCount += $postMeta[$keyword]['First100Words'];
					$factorCount += 1;
				}

				// Content contains contains at least one image with keyword in ALT attribute.
				if(isset($this->options['content_alt_factor']))
				{
					$totalCount += $postMeta[$keyword]['ImageALT'];
					$factorCount += 1;
				}

				// Content contains at least one bold keyword.
				if(isset($this->options['content_bold_factor']))
				{
					$totalCount += $postMeta[$keyword]['Bold'];
					$factorCount += 1;
				}

				// Content contains at least one italicized keyword.
				if(isset($this->options['content_italic_factor']))
				{
					$totalCount += $postMeta[$keyword]['Italic'];
					$factorCount += 1;
				}

				// Content contains at least one underlined keyword.
				if(isset($this->options['content_underline_factor']))
				{
					$totalCount += $postMeta[$keyword]['Underline'];
					$factorCount += 1;
				}

				// Content contains keyword in anchor text of at least one external link.
				if(isset($this->options['content_external_link_factor']))
				{
					$totalCount += $postMeta[$keyword]['ExternalAnchorText'];
					$factorCount += 1;
				}

				// Content contains keyword in anchor text of at least one internal link.
				if(isset($this->options['content_internal_link_factor']))
				{
					$totalCount += $postMeta[$keyword]['InternalAnchorText'];
					$factorCount += 1;
				}

				// Content contains keyword in last 50-100 words.
				if(isset($this->options['content_last_factor']))
				{
					$totalCount += $postMeta[$keyword]['Last100Words'];
					$factorCount += 1;
				}

				if($totalCount && $factorCount)
				{
					$score = $totalCount / $factorCount * 100;
				}

				return(number_format($score, 2, '.', ','));
			}
		}




		/**
		 * Saves post meta data (or deletes previous post meta data if keyword does not exist)
		 *
		 * @param	void
		 * @return	void
		 */

		function saveMetaData($postID)
		{
			// Auto Blog Fix (12-28-2011)
			$this->postID = $postID;

			// Save Only Once
			if(false !== (wp_is_post_autosave($postID) || wp_is_post_revision($postID)) ) { return; }
			if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) { return; }

			// Flag Added 12-28-2011
			if($this->savePostFlag) { return; }
			else { $this->savePostFlag = 1; }

			if(current_user_can('edit_posts'))
			{
				// Keyword Exists
				if(   (isset($_REQUEST['mainkeyword']) && (strlen(trim($_REQUEST['mainkeyword'])) > 0)) || (isset($this->options['automatic_keyword']) && (strlen(trim($this->options['automatic_keyword'])) > 0))   )
				{
					// Analyze Post
					$this->analyzePost();

					// Update Post Meta Data
					update_post_meta($this->postID, $this->postMetaDataName, $this->postMeta);



					// Update Copyscape Meta Data
					if((isset($_REQUEST['allcopyscaperesults']) && (strlen(trim($_REQUEST['allcopyscaperesults'])) > 0)) && (isset($_REQUEST['updatedcopyscaperesults']) && (strlen(trim($_REQUEST['updatedcopyscaperesults'])) > 0) && ($_REQUEST['updatedcopyscaperesults'] == 1)))
					{
						// Get Current Post Information
						$currentPost = get_post($this->postID);

						// Convert DateTime to Unix Time
						$timestamp = $this->convertDateTimeToUnixTime($currentPost->post_modified);

						$updateMsg = '<p style="font-weight:normal !important;margin:5px 0 0 0 !important;padding:0 !important;text-align:center !important;">'.__('Saved on', OPSEO_TEXT_DOMAIN).' '.date('M j, Y \a\t g:i a', $timestamp).'</p>';

						update_post_meta($this->postID, $this->copyscapeMetaDataName, $_REQUEST['allcopyscaperesults'].$updateMsg);
					}
				}
				// Update Secondary Keywords
				elseif(isset($_REQUEST['allsecondarykeywords']) && (strlen(trim($_REQUEST['allsecondarykeywords'])) > 0))
				{
					// Main Keyword
					$_REQUEST['mainkeyword'] = '';

					// Analyze Post
					$this->analyzePost();

					// Update Post Meta Data
					update_post_meta($this->postID, $this->postMetaDataName, $this->postMeta);

					// Update Copyscape Meta Data
					if((isset($_REQUEST['allcopyscaperesults']) && (strlen(trim($_REQUEST['allcopyscaperesults'])) > 0)) && (isset($_REQUEST['updatedcopyscaperesults']) && (strlen(trim($_REQUEST['updatedcopyscaperesults'])) > 0) && ($_REQUEST['updatedcopyscaperesults'] == 1)))
					{
						// Get Current Post Information
						$currentPost = get_post($this->postID);

						// Convert DateTime to Unix Time
						$timestamp = $this->convertDateTimeToUnixTime($currentPost->post_modified);

						$updateMsg = '<p style="font-weight:normal !important;margin:5px 0 0 0 !important;padding:0 !important;text-align:center !important;">'.__('Saved on', OPSEO_TEXT_DOMAIN).' '.date('M j, Y \a\t g:i a', $timestamp).'</p>';

						update_post_meta($this->postID, $this->copyscapeMetaDataName, $_REQUEST['allcopyscaperesults'].$updateMsg);
					}
				}
				// Delete Old Meta Data if Keyword Does Not Exist
				elseif(isset($this->postMeta['onpageseo_global_settings']['MainKeyword']))
				{
					delete_post_meta($this->postID, $this->postMetaDataName);
				}

			}
			else
			{
				wp_die(__('You do not have permission to edit this post.', OPSEO_TEXT_DOMAIN));
			}
		}



		/**
		 * Saves URL meta data (or deletes previous post meta data if keyword does not exist)
		 *
		 * @param	void
		 * @return	void
		 */

		function saveMetaDataURL($url)
		{
			if(current_user_can('edit_posts'))
			{
				// Keyword Exists
				if(isset($_REQUEST['mainkeyword']) && (strlen(trim($_REQUEST['mainkeyword'])) > 0))
				{
					// Analyze Post
					$this->analyzePost(2, $url);
				}
				// Update Secondary Keywords
				elseif(isset($_REQUEST['allsecondarykeywords']) && (strlen(trim($_REQUEST['allsecondarykeywords'])) > 0))
				{
					// Main Keyword
					$_REQUEST['mainkeyword'] = '';

					// Analyze Post
					$this->analyzePost(2, $url);
				}
			}
			else
			{
				wp_die(__('You do not have permission to edit this URL.', OPSEO_TEXT_DOMAIN));
			}
		}





		function getDraftPermalink($post, $permalink, $postName)
		{
			$rewritecode = array(
				'%year%',
				'%monthnum%',
				'%day%',
				'%hour%',
				'%minute%',
				'%second%',
				'%postname%',
				'%post_id%',
				'%category%',
				'%author%',
				'%pagename%'
			);

			$unixtime = strtotime($post->post_date);
			$category = '';

			if ( strpos($permalink, '%category%') !== false )
			{
				$cats = get_the_category($post->ID);
				if($cats)
				{
					usort($cats, '_usort_terms_by_ID'); // order by ID
					$category = $cats[0]->slug;
					if($parent = $cats[0]->parent)
						$category = get_category_parents($parent, false, '/', true) . $category;
				}

				// show default category in permalinks, without having to assign it explicitly
				if(empty($category))
				{
					$default_category = get_category( get_option( 'default_category' ) );
					$category = is_wp_error( $default_category ) ? '' : $default_category->slug;
				}
			}

			$author = '';

			if(strpos($permalink, '%author%') !== false)
			{
				$authordata = get_userdata($post->post_author);
				$author = $authordata->user_nicename;
			}

			$date = explode(" ",date('Y m d H i s', $unixtime));

			$rewritereplace = array(
				$date[0],
				$date[1],
				$date[2],
				$date[3],
				$date[4],
				$date[5],
				$postName,
				$post->ID,
				$category,
				$author,
				$postName
			);

//echo 'Get Permalink1: ' . $permalink . '<br />';

			$permalink = str_replace($rewritecode, $rewritereplace, $permalink);

//echo 'Get Permalink2: ' . $permalink . '<br />';

			// Site URL Ends with Trailing Slash
			if(preg_match('/\/$/', OPSEO_SITE_URL))
			{
				// Permalink Begins with Slash
				if(preg_match('/^\//', $permalink))
				{
					$permalink = substr($permalink, 1);
				}
			}
			// Site URL Does NOT End with Trailing Slash
			else
			{
				// Permalink Does NOT Begin with Slash
				if(!preg_match('/^\//', $permalink))
				{
					$permalink = '/'.$permalink;
				}
			}

			return(OPSEO_SITE_URL.$permalink);


		}








		function analyzePost($type='1', $permalink='')
		{
			if($this->strExists($this->options['unicode_support']))
			{
				//header("Content-Type: text/html; charset=utf-8");
			}

			if($type == 1)
			{
				$permalink = '';

				// Get Current Post Information
				$currentPost = get_post($this->postID);

				// Automatic Keyword Insertion (12-20-2011)
				if((!isset($_REQUEST['mainkeyword']) || (strlen(trim($_REQUEST['mainkeyword'])) == 0)) && (isset($this->options['automatic_keyword']) && (strlen(trim($this->options['automatic_keyword'])) > 0)))
				{
					$postMetaData = '';

					switch($this->options['automatic_keyword'])
					{
						case 'title':
							$_REQUEST['mainkeyword'] = $currentPost->post_title;
							break;

						case 'categories':

							foreach(get_the_category() as $category)
							{
								foreach(get_the_category($this->postID) as $category)
								{
									$postMetaData .= $category->cat_name . ', ';
								}

								if(strlen(trim($postMetaData)) > 0)
								{
									$postMeta = explode(',', trim($postMetaData));
									$_REQUEST['mainkeyword'] = trim($postMeta[0]);

									if(!isset($_REQUEST['allsecondarykeywords']) || (strlen(trim($_REQUEST['allsecondarykeywords'])) == 0))
									{
										for($i=1; $i < sizeof($postMeta); $i++)
										{
											if(strlen(trim($postMeta[$i])) > 0)
											{
												$_REQUEST['allsecondarykeywords'] .= trim($postMeta[$i]) . '|||';
											}
										}
									}
								}
							}

							break;

						case 'tags':

							foreach(wp_get_post_tags($this->postID) as $tag)
							{
								$postMetaData .= $tag->name . ', ';
							}

							if(strlen(trim($postMetaData)) > 0)
							{
								$postMeta = explode(',', trim($postMetaData));
								$_REQUEST['mainkeyword'] = trim($postMeta[0]);

								if(!isset($_REQUEST['allsecondarykeywords']) || (strlen(trim($_REQUEST['allsecondarykeywords'])) == 0))
								{
									for($i=1; $i < sizeof($postMeta); $i++)
									{
										if(strlen(trim($postMeta[$i])) > 0)
										{
											$_REQUEST['allsecondarykeywords'] .= trim($postMeta[$i]) . '|||';
										}
									}
								}
							}

							break;

						case 'aioseo_keywords':
							if(isset($_REQUEST['aiosp_keywords']) && (strlen(trim($_REQUEST['aiosp_keywords'])) > 0))
							{
								$postMetaData = $_REQUEST['aiosp_keywords'];
							}
							else
							{
								$postMetaData = get_post_meta($this->postID, '_aioseop_keywords', true);
							}

							// Import If Exists
							if(strlen(trim($postMetaData)) > 0)
							{
								$postMeta = explode(',', $postMetaData);
								$_REQUEST['mainkeyword'] = trim($postMeta[0]);

								if(!isset($_REQUEST['allsecondarykeywords']) || (strlen(trim($_REQUEST['allsecondarykeywords'])) == 0))
								{
									for($i=1; $i < sizeof($postMeta); $i++)
									{
										$_REQUEST['allsecondarykeywords'] .= trim($postMeta[$i]) . '|||';
									}
								}
							}

							break;
















					}

					// No Primary Keyword
					if(strlen(trim($_REQUEST['mainkeyword'])) == 0) { return; }
				}

				// Check Post Status
				$postStatus = $currentPost->post_status;

				// Post/Page Not Published
				if($postStatus != 'publish')
				{
					// Change Post Status To "Publish"
					$this->updatePost($this->postID, 'post_status', 'publish');

					$currentPost = get_post($this->postID);

					// Get Custom Permalink Structure
					$permalink_structure = get_option('permalink_structure');

					// Custom Permalink Structure
					if($permalink_structure)
					{
						// Save Current Post Name (UTF-8 Support - 9-21-11)
						$postName = $currentPost->post_name;

						// No Post Name Saved or Is Numeric (Possible 404 Errors) (Page Draft Fix (strlen) - 1-29-2012)
						if((strlen(trim($postName)) == 0) || is_numeric(trim($postName)))
						{
							// Set Post ID As Title If Post Title Does Not Exist
							if(!$currentPost->post_title)
								$currentPost->post_title = (strlen(trim($this->postID)) > 0) ? 'draft'.$this->postID : 'draft';

							// Does Post Name Already Exist In DB
							global $wpdb;
							$incr = -1;

							do {
								// Sanitize Title With Dashes
								$postName = sanitize_title_with_dashes($currentPost->post_title);
								//$postName = urldecode($postName);

								++$incr;
								if($incr) { $postName .= '-'.$incr; }

							} while($wpdb->get_row( $wpdb->prepare("SELECT post_title FROM $wpdb->posts WHERE post_name = '" . $postName . "'", 'ARRAY_A') ));

							//$this->updatePost($this->postID, 'post_excerpt', 'yahyahyah');

							// Update Post Name
							$this->updatePost($this->postID, 'post_name', $postName);

							//$permalink = $this->addTrailingCharacter(get_bloginfo('wpurl'), '/') . $postName;


							// Page
							//if ($currentPost->post_type == 'page') { $permalink = get_page_link($this->postID); }
							// Post
							//else { $permalink = $this->getDraftPermalink($currentPost, $permalink_structure, $postName); }

							// (Page Draft Fix - 1-29-2012)
							$permalink = $this->getDraftPermalink($currentPost, $permalink_structure, $postName);
						}
						else
						{

							// Update Post Name (Page Draft Fix - 1-29-2012)
							//$this->updatePost($this->postID, 'post_name', $postName);

							// Page
							//if ($currentPost->post_type == 'page') { $permalink = get_page_link($this->postID); }
							// Post
							//else
							//{
								//$permalink = $this->addTrailingCharacter(get_bloginfo('wpurl'), '/') . $currentPost->post_name;
								$permalink = $this->getDraftPermalink($currentPost, $permalink_structure, $postName);
							//}
						}
					}
					// Default Permalink Structure
					else { $permalink = get_permalink($this->postID); }

				}
				else { $permalink = get_permalink($this->postID); }
			}

			// URL Decode (9-20-11)
			$permalink = urldecode($permalink);

			// For Permalinks With Spaces (7-27-11)
			$permalink = str_replace(' ','%20', $permalink);


			$domainName = parse_url($permalink, PHP_URL_HOST);


			// Update Theme Post Meta Data
			$this->updateWPThemesPostMetaData($this->postID);

			// Important Variable
			$result = '';
			$rand1 = rand(99,29999);
			$rand2 = rand(99,29999);
			$rand3 = rand(99,29999);
			$rand4 = rand(99,29999);

			// For Proxy Server URL (8-5-2011)
			$getPermalink = $permalink;

			if($this->strExists($this->options['proxy_server_url']))
			{
				$getPermalink = $this->options['proxy_server_url'].'?url='.$permalink;
			}

			// cUrl - Password Protection
			if(($this->options['password_activation'] == 'activated'))
			{
				$ch = curl_init();
				curl_setopt ($ch, CURLOPT_URL, $getPermalink);
				curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/'.$rand1.'.'.$rand2.' (KHTML, like Gecko) Safari/'.$rand3.'.'.$rand4);
				curl_setopt ($ch, CURLOPT_TIMEOUT, $this->options['request_timeout']);
				curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt ($ch, CURLOPT_COOKIEJAR, $this->options['password_file_path']);
				curl_setopt ($ch, CURLOPT_COOKIEFILE, $this->options['password_file_path']);
				ob_start();
				$urlResult = curl_exec($ch);
				ob_end_clean();

				// Check for cURL Errors
				if(curl_errno($ch))
				{
					// Handle Error Messages (4-4-2012)
					$this->analyzeErrorMessage = 'The web server failed to request the URL.  Go to WP Admin -> Easy WP SEO -> Settings -> Miscellaneous Settings and set the "Request Timeout" setting to a higher number.  If this does not work, contact your web hosting provider and ask if they allow PHP files to request local URLs (ask if they allow "loopback connections"). If loopback connections are not allowed, you will need to set up a proxy server (refer to the user guide).';

					update_option(OPSEO_PREFIX.'_error_message', $this->analyzeErrorMessage);

					return;
				}
				// Success
				else
				{
					$result['body'] = $this->unTexturize($urlResult);
				}

				curl_close($ch);
				unset($ch);
			}
			// WP_Http
			else
			{
				// Request Post/Page URL
				if(!class_exists('WP_Http'))
					include_once( ABSPATH . WPINC. '/class-http.php' );

				$request = new WP_Http;

				// Set Timeout
				$requestArgs = array(
					'timeout'=>$this->options['request_timeout'],
					'user-agent'=>'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/'.$rand1.'.'.$rand2.' (KHTML, like Gecko) Safari/'.$rand3.'.'.$rand4
				);

				$result = $request->request($getPermalink, $requestArgs);

				// Error? Die and Display Error Message
				if(is_wp_error($result))
				{
					// Handle Error Messages (4-4-2012)
					$this->analyzeErrorMessage = 'The web server failed to request the URL.  Go to WP Admin -> Easy WP SEO -> Settings -> Miscellaneous Settings and set the "Request Timeout" setting to a higher number.  If this does not work, contact your web hosting provider and ask if they allow PHP files to request local URLs (ask if they allow "loopback connections"). If loopback connections are not allowed, you will need to set up a proxy server (refer to the user guide).';

					update_option(OPSEO_PREFIX.'_error_message', $this->analyzeErrorMessage);

					return;
				}

				// Success
				if($result['response']['code']=='200')
				{
					// UnTexturize
					$result['body'] = $this->unTexturize($result['body']);
				}
			}


			// Include UT8 to Unicode Functions (8-25-11)
			if($this->strExists($this->options['unicode_support']))
			{

				include_once('onpageseo-utf8.php');
			}

			do_shortcode($result['body']);

			// HTML Entities Decode (1-11-2012)
			$result['body'] = html_entity_decode($result['body'], ENT_QUOTES, 'UTF-8');

			// Reduce Whitespace (12-23-2011)
			$result['body'] = trim(preg_replace('/\s{2,}/',' ',$result['body']));


			// Content-Type Problem Solved (10-4-2011)
			if($this->strExists($this->options['unicode_support']))
			{
				$result['body'] = preg_replace('/(<head[^>]*>)/i', '$1'."\n".'<meta http-equiv="content-type" content="text/html; charset=utf-8" />', $result['body']);
			}

			// Get Keywords
			$_REQUEST['allsecondarykeywords'] = trim(preg_replace('/|||$/', '', stripslashes(trim($_REQUEST['allsecondarykeywords']))));
			$keywords = explode('|||', $_REQUEST['allsecondarykeywords']);
			array_unshift($keywords, $_REQUEST['mainkeyword']);
			for($i = 0; $i < sizeof($keywords); $i++)
			{
				if(!isset($keywords[$i]) || (strlen(trim($keywords[$i])) == 0))
				{
					unset($keywords[$i]);
				}
				else
				{
					$keywords[$i] = str_replace('"','',$keywords[$i]);
				}
			}


			// Remove Stop Words (1-6-2012)
			if($this->strExists($this->options['stop_words_enabled']))
			{
				$result['body'] = $this->removeStopWords($result['body']);
			}



			// Clear Previous Entries
			$this->postMeta = array();

			// Main Keyword Check
			$mainKeywordCheck = 0;

			// Post Words (For Readability Score)
			$postWords = 0;

			for($i = 0; $i < sizeof($keywords); $i++)
			{
				// Check If Blank Primary Keyword With Secondary Keywords
				if((strlen(trim($_REQUEST['mainkeyword'])) == 0) && !$mainKeywordCheck){$i+=1; $mainKeywordCheck+=1;}


				// Main Keyword
				$keyword = stripslashes(trim($keywords[$i]));

				// 9-7-2011
				$kwkey = $this->strExists($this->options['unicode_support']) ? mb_strtolower($keyword, $this->charEncoding) : strtolower($keyword);
				$this->postMeta[$kwkey]['Keyword'] = $keyword;

				// Reduce Whitespace (12-23-2011)
				$keyword = trim(preg_replace('/\s{2,}/', ' ', $keyword));


				// Remove Stop Words (1-6-2012)
				if($this->strExists($this->options['stop_words_enabled']))
				{
					$keyword = $this->removeStopWords($keyword);
				}


				$replaceChars = 'jEsdfSDF';

				// Keyword RegEx
				$regex = '/\b'.$keyword.'\b/is';
				$strippedKeyword = $keyword;

				$stripped = 0;



//##################################################################

				if($this->strExists($this->options['unicode_support']))
				{
					// Hex RegEx (8-25-11)
					$charHex = opseoUTF8ToUnicode($keyword);
					$hexRegEx = '';

					for($iz = 0; $iz < sizeof($charHex); $iz++)
					{
						$hexRegEx .= '\x{'.dechex($charHex[$iz]).'}';
					}

					$charHex = '';
					$this->hexKeyword = $hexRegEx;
					$this->hexRegEx = '/(?<=[\s\p{P}\p{S}\p{C}]|^)'.$this->hexKeyword.'(?=[\s\p{P}\p{S}\p{C}]|$)/uisx';
					$regex = $this->hexRegEx;
				}
				else
				{
					// Keyword Contains Non-Alphanumeric Characters
					if(preg_match('/[^\w\d\s]/', $keyword))
					{
						// Solves Word Boundary Issue With Non-Alphanumeric Characters (At Beginning or End)
						$strippedKeyword = preg_replace('/[^\w\d\s]/i', $replaceChars, $keyword);
						$regex = '/\b'.$strippedKeyword.'\b/is';
						$stripped = 1;
					}
				}

//##################################################################


				$keywordWords = $this->countWords($keyword);

				// Entire HTML Document
				$strippedBody = $result['body'];

				// Replace Non-Alphanumeric Characters
				// preg_quote() Fix for RegEx escape characters (6-15-11)
				if($stripped) { $strippedBody = preg_replace('/'.preg_quote($keyword, '/').'/i', $strippedKeyword, $strippedBody); }


				// Permalink
				if($this->strExists($this->options['unicode_support']))
				{
					$permalink = trim(preg_replace('/[^\pL\pN\s]/ui', ' ', urldecode($permalink)));
					$permalink2 = trim(preg_replace('/[^\pL\pN]/ui', '', $permalink));
					$permalinkKeyword2 = trim(preg_replace('/[^\pL\pN]+/ui', '', $keyword));

					// Stop Words (1-6-2012)
					if($this->strExists($this->options['stop_words_enabled']))
					{
						// Keyword Found
						if($this->checkFactor('/'.$permalinkKeyword2.'/ui', $permalink2))
						{
							$this->postMeta[$kwkey]['Permalink'] = 1;
						}
						// Keyword Not Found
						else
						{
							// Search Parts of Keyword
							$permalink3 = trim(preg_replace('/[^\pL\pN ]+/ui', '', $keyword));
							$permalink3 = preg_replace('/\s{2,}/', ' ', trim($permalink3));
							$swWords = explode(' ', $permalink3);
							$swWordsFound = 0;

							if(sizeof($swWords) > 1)
							{
								for($swI = 0; $swI < sizeof($swWords); $swI++)
								{
									$swWordsFound += $this->checkFactor('/'.$swWords[$swI].'/ui', $permalink2);
								}

								// All Words In Keyword Were Found In The URL
								$this->postMeta[$kwkey]['Permalink'] = ($swWordsFound == sizeof($swWords)) ? 1 : 0;
							}
							// Already Performed Search In Previous Attempt
							else
							{
								// Keyword Not Found
								$this->postMeta[$kwkey]['Permalink'] = 0;
							}
						}
					}
					else
					{
						$this->postMeta[$kwkey]['Permalink'] = $this->checkFactor('/'.$permalinkKeyword2.'/ui', $permalink2);
					}

				}
				else
				{
					$permalink = trim(preg_replace('/[^\w\d\s]/', ' ', $permalink));
					$permalink2 = trim(preg_replace('/[^\w\d]/', '', $permalink));
					$permalinkKeyword2 = trim(preg_replace('/[^\w\d]+/', '', $keyword));

					// Stop Words (1-6-2012)
					if($this->strExists($this->options['stop_words_enabled']))
					{
						// Keyword Found
						if($this->checkFactor('/'.$permalinkKeyword2.'/ui', $permalink2))
						{
							$this->postMeta[$kwkey]['Permalink'] = 1;
						}
						// Keyword Not Found
						else
						{
							// Search Parts of Keyword
							$permalink3 = trim(preg_replace('/[^\w\d ]+/ui', '', $keyword));
							$permalink3 = preg_replace('/\s{2,}/', ' ', trim($permalink3));
							$swWords = explode(' ', $permalink3);
							$swWordsFound = 0;

							if(sizeof($swWords) > 1)
							{
								for($swI = 0; $swI < sizeof($swWords); $swI++)
								{
									$swWordsFound += $this->checkFactor('/'.$swWords[$swI].'/ui', $permalink2);
								}

								// All Words In Keyword Were Found In The URL
								$this->postMeta[$kwkey]['Permalink'] = ($swWordsFound == sizeof($swWords)) ? 1 : 0;
							}
							// Already Performed Search In Previous Attempt
							else
							{
								// Keyword Not Found
								$this->postMeta[$kwkey]['Permalink'] = 0;
							}
						}
					}
					else
					{
						$this->postMeta[$kwkey]['Permalink'] = $this->checkFactor('/'.$permalinkKeyword2.'/ui', $permalink2);
					}
				}


				// Title

					list($keywordTitle, $keywordTitleBeginning) = $this->analyzeTag('title', $strippedBody, $strippedKeyword, 1);

					// Keyword in Title
					$this->postMeta[$kwkey]['KeywordTitle'] = $keywordTitle;

					// Keyword at Beginning of Title
					$this->postMeta[$kwkey]['KeywordTitleBeginning'] = $keywordTitleBeginning;

					list($titleWords, $titleChars) = $this->analyzeTagLength('title', $strippedBody, $strippedKeyword, 1);

					// Title Length (# Words)
					$this->postMeta[$kwkey]['TitleWords'] = ($titleWords >= $this->options['title_length_minimum']) ? 1 : 0;

					// Title Characters
					$this->postMeta[$kwkey]['TitleChars'] = ($titleChars >= 1 && $titleChars <= $this->options['title_length_maximum']) ? 1 : 0;

				// Meta Tags

					// Description
					list($descriptionMetaTag, $descriptionMetaTagBeginning) = $this->analyzeMetaTag('description', $strippedBody, $strippedKeyword, 1);

					$this->postMeta[$kwkey]['DescriptionMetaTag'] = $descriptionMetaTag;

					list($descriptionMetaTagWords, $descriptionMetaTagChars) = $this->analyzeMetaTagLength('description', $strippedBody, $strippedKeyword);

					// Description Length
					$this->postMeta[$kwkey]['DescriptionMetaTagLength'] = ($descriptionMetaTagChars <= $this->options['description_meta_tag_maximum'] && $descriptionMetaTagChars >= 1) ? '1' : '0';

					// Description Keyword At Beginning
					$this->postMeta[$kwkey]['DescriptionMetaTagBeginning'] = $descriptionMetaTagBeginning;

					// Keywords
					$this->postMeta[$kwkey]['KeywordsMetaTag'] = $this->analyzeMetaTag('keywords', $strippedBody, $strippedKeyword);
























				// Post Content

					$strippedContent = '';

					// Post or Page
					if(($type == 1) && ($this->options['keyword_density_type'] == 'post'))
					{
						// Shortcode Fix (12-20-2011)
						if($this->strExists($this->options['shortcode_support']))
						{
							$currentPost->post_content = do_shortcode($currentPost->post_content);
						}

						$content = stripslashes($currentPost->post_content);

						// HTML Entities Decode (1-11-2012)
						$content = html_entity_decode($content, ENT_QUOTES, 'UTF-8');

						$strippedContent = $this->unTexturize($content);
					}
					// URL Analyzer
					else
					{
						$strippedContent = $this->getURLBodyText($this->stripOtherTags(stripslashes($strippedBody)));
					}


					// Strip Tags and Replace Non-Alphanumeric Characters
					//if($stripped) { $strippedContent = preg_replace('/[^\w\d\s]/i', $replaceChars, strip_tags($strippedContent)); }
					// Just Strip Tags
					//else { $strippedContent = strip_tags($strippedContent); }

					// Strip Tags
					$strippedContent = $this->stripTagsAddSpace($strippedContent);

					// Post Count Number of Words (250+)
					$strippedContent = str_replace("\n", ' ', $strippedContent);
					$strippedContent = preg_replace('/\s{2,}/', ' ', trim($strippedContent));

					// Remove Stop Words (1-6-2012)
					if($this->strExists($this->options['stop_words_enabled']))
					{
						$strippedContent = $this->removeStopWords($strippedContent);
					}

					// Replace Non-Alphanumeric Characters
					if($stripped) { $strippedContent = preg_replace('/[^\w\d\s]/i', $replaceChars, $strippedContent); }

					// Remove Non-Letters And Numbers (1-7-2012)
					//$kwdStrippedContent = $strippedContent;
					//$kwdStrippedContent = $this->strExists($this->options['unicode_support']) ? preg_replace('/[^ \pL\pN]+/uis', '', $kwdStrippedContent) : preg_replace('/[^ \w\d]+/is', '', $kwdStrippedContent);


					//$words = explode(' ', trim($strippedContent));
					//$postWords = sizeof($words);
					//$this->postMeta[$kwkey]['PostWords'] = ($postWords >= $this->options['post_content_length']) ? 1 : 0;


					// Keyword Density
					$keywordInstances = 0;
					$kwdWords = 0;
					$words = 0;
					$postWords = 0;

					// Post or Page - Analyze Entire Document
					if($type && $this->options['keyword_density_type'] == 'full')
					{
						$kwdContent = $this->getURLBodyText($this->stripOtherTags(stripslashes($strippedBody)));

						// UTF-8 Encode (9-25-2012)
						$kwdContent = $this->str_encode_utf8($kwdContent);
						$kwdContent = str_replace("\n", ' ', $kwdContent);
						$kwdContent = preg_replace('/\s{2,}/', ' ', trim($kwdContent));

						// Remove Stop Words (1-6-2012)
						if($this->strExists($this->options['stop_words_enabled']))
						{
							$kwdContent = $this->removeStopWords($kwdContent);
						}

						$keywordInstances = preg_match_all($regex, $kwdContent, $matches);



						// Remove Non-Letters And Numbers (1-7-2012)
						$strippedContent = $kwdContent = $this->strExists($this->options['unicode_support']) ? preg_replace('/(?<=[\s\p{P}\p{S}\p{C}]|^)[^ \pL\pN]+(?=[\s\p{P}\p{S}\p{C}]|$)/uis', '', $kwdContent) : preg_replace('/(?<=[\s\W\D]|^)[^ \w\d]+(?=[\s\W\D]|$)/is', '', $kwdContent);

						$kwdWordsTemp = $words = explode(' ', trim($kwdContent));
						$kwdWords = $postWords = sizeof($kwdWordsTemp);

						$kwdContent = '';
						$kwdWordsTemp = '';

					}
					else
					{
						// UTF-8 Encode (9-25-2012)
						$strippedContent = $this->str_encode_utf8($strippedContent);
						$keywordInstances = preg_match_all($regex, $strippedContent, $matches);

						// Remove Non-Letters And Numbers (1-7-2012)
						$strippedContent = $this->strExists($this->options['unicode_support']) ? preg_replace('/(?<=[\s\p{P}\p{S}\p{C}]|^)[^ \pL\pN]+(?=[\s\p{P}\p{S}\p{C}]|$)/uis', '', $strippedContent) : preg_replace('/(?<=[\s\W\D]|^)[^ \w\d]+(?=[\s\W\D]|$)/is', '', $strippedContent);

						$strippedContent = preg_replace('/\s{2,}/', ' ', trim($strippedContent));

						$words = explode(' ', trim($strippedContent));
						$postWords = sizeof($words);

						$kwdWords = $postWords;
					}

					$this->postMeta[$kwkey]['PostWords'] = ($postWords >= $this->options['post_content_length']) ? 1 : 0;

					// At Least One Keyword
					if($keywordInstances)
					{
						// First Keyword Density Formula
						if($this->options['keyword_density_formula'] == 1)
						{
							$this->postMeta[$kwkey]['KeywordDensityScore'] = ($keywordInstances / $kwdWords) * 100;
						}
						// Second Keyword Density Formula
						elseif($this->options['keyword_density_formula'] == 2)
						{
							//$this->postMeta[$kwkey]['KeywordDensityScore'] = ($keywordInstances / ($kwdWords / $keywordWords)) * 100;
							$this->postMeta[$kwkey]['KeywordDensityScore'] = ($keywordInstances * $keywordWords / $kwdWords) * 100;
						}

						// Third Keyword Density Formula
						else
						{
							$this->postMeta[$kwkey]['KeywordDensityScore'] =  ($keywordInstances / ($kwdWords - ($keywordInstances * ($keywordWords - 1)))) * 100;
						}
					}
					// No Keyword Matches (Ensure No Division By Zero Errors)
					else { $this->postMeta[$kwkey]['KeywordDensityScore'] = 0; }

					$this->postMeta[$kwkey]['KeywordDensityScore'] = number_format($this->postMeta[$kwkey]['KeywordDensityScore'], 2, '.', ',');
					$this->postMeta[$kwkey]['KeywordDensity'] = ($this->postMeta[$kwkey]['KeywordDensityScore'] >= $this->options['keyword_density_minimum']&& $this->postMeta[$kwkey]['KeywordDensityScore'] <= $this->options['keyword_density_maximum']) ? 1 : 0;









					// Keyword In First 50-100 Words
					$first100words = '';

					// More Than Or Equal To 100 Words
					if(sizeof($words) > 100)
					{
						for($zr = 0; $zr < 100; $zr++) { $first100[$zr] = $words[$zr]; }
						$first100words = implode(' ', $first100);
					}
					else
					{
						$first100words = trim($strippedContent);
					}

					$this->postMeta[$kwkey]['First100Words'] = $this->checkFactor($regex, $first100words);

					// Save for SEO Report
					//$this->postMeta['onpageseo_global_settings']['First100Words'] = $first100words;


					// Keyword In Last 50-100 Words
					$last100words = '';

					// More Than Or Equal To 100 Words
					if(sizeof($words) >= 99)
					{
						$arrStart = sizeof($words) - 99;
						for($z = $arrStart; $arrStart < sizeof($words); $arrStart++) { $last100wordstemp[] = $words[$arrStart]; }
						$last100words = implode(' ', $last100wordstemp);
						$this->postMeta[$kwkey]['Last100Words'] = $this->checkFactor($regex, $last100words);

					}
					// Less Than 100 Words
					else
					{
						if($this->postMeta[$kwkey]['First100Words']){ $this->postMeta[$kwkey]['Last100Words'] = 1; }
						else{ $this->postMeta[$kwkey]['Last100Words'] = 0; }
						$last100words = $first100words;
					}

					// Save for SEO Report
					//$this->postMeta['onpageseo_global_settings']['Last100Words'] = $last100words;

					// Clear Words Array
					$words = array();



					// External Link Anchor Text
					$this->postMeta[$kwkey]['ExternalAnchorText'] = $this->analyzeAnchorTag('external', $strippedBody, $strippedKeyword, $domainName);


					// Internal Link Anchor Text
					$this->postMeta[$kwkey]['InternalAnchorText'] = $this->analyzeAnchorTag('internal', $strippedBody, $strippedKeyword, $domainName);





					// Header Tags
					list($H1, $H1Beginning) = $this->analyzeTag('h1', $strippedBody, $strippedKeyword, 1);
					$this->postMeta[$kwkey]['H1'] = $H1;
					$this->postMeta[$kwkey]['H1Beginning'] = $H1Beginning;
					$this->postMeta[$kwkey]['H2'] = $this->analyzeTag('h2', $strippedBody, $strippedKeyword);
					$this->postMeta[$kwkey]['H3'] = $this->analyzeTag('h3', $strippedBody, $strippedKeyword);


					// IMG Tags
					$this->postMeta[$kwkey]['ImageALT'] = $this->analyzeImageTag($strippedBody, $strippedKeyword);


					// Bold
					$this->postMeta[$kwkey]['Bold'] = $this->analyzeBoldDecoration($strippedBody, $strippedKeyword);

					// Italic
					$this->postMeta[$kwkey]['Italic'] = $this->analyzeItalicDecoration($strippedBody, $strippedKeyword);

					// Underline
					$this->postMeta[$kwkey]['Underline'] = $this->analyzeUnderlineDecoration($strippedBody, $strippedKeyword);


				// Calculate Score
				$this->postMeta[$kwkey]['TotalScore'] = $this->getKeywordScore($kwkey, $this->postMeta);

				// Main Keyword
				if(!$i) { $this->totalScore = $this->postMeta[$kwkey]['TotalScore']; }

			
			} // End of For Loop


			// Unstripped Content

				$unStrippedContent = '';

				// Post or Page
				if(($type == 1) && ($this->options['keyword_density_type'] == 'post'))
				{
					$unStrippedContent = $this->stripTagsAddSpace(stripslashes($currentPost->post_content));
				}
				// URL Analyzer
				else
				{
					$unStrippedContent = $this->stripTagsAddSpace($this->getURLBodyText($this->stripOtherTags(stripslashes($result['body']))));
				}

				// HTML Entities Decode (1-11-2012)
				$unStrippedContent = html_entity_decode($unStrippedContent, ENT_QUOTES, 'UTF-8');

				// UTF-8 Encode (9-25-2012)
				$unStrippedContent = $this->str_encode_utf8($unStrippedContent);

				//$unStrippedContent = str_replace("\n", ' ', $unStrippedContent);
				$unStrippedContent = trim(preg_replace('/\s{2,}/', ' ', $unStrippedContent));

				// Remove Stop Words (1-6-2012)
				if($this->strExists($this->options['stop_words_enabled']))
				{
					$unStrippedContent = $this->removeStopWords($unStrippedContent);
				}



				// Remove Non-Letters And Numbers (1-7-2012)
				$unStrippedContent = $this->strExists($this->options['unicode_support']) ? preg_replace('/(?<=[\s\p{P}\p{S}\p{C}]|^)[^ \pL\pN]+(?=[\s\p{P}\p{S}\p{C}]|$)/uis', '', $unStrippedContent) : preg_replace('/(?<=[\s\W\D]|^)[^ \w\d]+(?=[\s\W\D]|$)/is', '', $unStrippedContent);



			// Change Post Status
			if($postStatus != 'publish')
			{
				$this->updatePost($this->postID, 'post_status', $postStatus);
				//$this->updatePost($this->postID, 'post_name', $postName);
			}





























			// Global Settings

				// Main Keyword
				$this->postMeta['onpageseo_global_settings']['MainKeyword'] = str_replace('"','',stripslashes(trim($_REQUEST['mainkeyword'])));

				// Secondary Keywords
				$this->postMeta['onpageseo_global_settings']['SecondaryKeywords'] = str_replace('"','',stripslashes(trim($_REQUEST['allsecondarykeywords'])));


				// Readability Scores
				require_once('onpageseo-readability.php');
				$readability = new opseoTextStatistics();

					// Flesch-Kincaid Reading Ease
					$this->postMeta['onpageseo_global_settings']['FleschEase'] = $readability->flesch_kincaid_reading_ease($unStrippedContent);

					// Flesch-Kincaid Reading Ease Level
					$this->postMeta['onpageseo_global_settings']['FleschLevel'] = $readability->flesch_kincaid_reading_ease_level($this->postMeta['onpageseo_global_settings']['FleschEase']);

					// Flesch-Kincaid Grade Level
					$this->postMeta['onpageseo_global_settings']['FleschGradeLevel'] = $readability->flesch_kincaid_grade_level($unStrippedContent);

					// Gunning-Fog Score
					$this->postMeta['onpageseo_global_settings']['GunningFogScore'] = $readability->gunning_fog_score($unStrippedContent);

					// Coleman-Liau Index
					$this->postMeta['onpageseo_global_settings']['ColemanLiauIndex'] = $readability->coleman_liau_index($unStrippedContent);

					// SMOG Index
					$this->postMeta['onpageseo_global_settings']['SMOGIndex'] = $readability->smog_index($unStrippedContent);

					// Automated Readability Index
					$this->postMeta['onpageseo_global_settings']['AutomatedReadabilityIndex'] = $readability->automated_readability_index($unStrippedContent);

				// Readability Statistics

					// Clean Text
					$readableContent = $readability->clean_text($unStrippedContent);

					// Sentence Count
					$this->postMeta['onpageseo_global_settings']['SentenceCount'] = (int)$readability->sentence_count($unStrippedContent);

					// Word Count
					//$this->postMeta['onpageseo_global_settings']['WordCount'] = (int)$readability->word_count($unStrippedContent);
					$this->postMeta['onpageseo_global_settings']['WordCount'] = $postWords;

					// Average Words Per Sentence
					//$this->postMeta['onpageseo_global_settings']['AverageWordsPerSentence'] = (int)$readability->average_words_per_sentence($unStrippedContent);
					$this->postMeta['onpageseo_global_settings']['AverageWordsPerSentence'] = number_format($readability->average_words_per_sentence($unStrippedContent), 2, '.', '');

					// Average Syllables Per Word
					$this->postMeta['onpageseo_global_settings']['AverageSyllablesPerWord'] = number_format($readability->average_syllables_per_word($unStrippedContent), 2, '.', '');

					// Number Of Words With Three+ Syllables (Complex Words)
					$this->postMeta['onpageseo_global_settings']['ComplexWordsNumber'] = (int)$readability->words_with_three_syllables($unStrippedContent);

					// Percentage Of Words With Three+ Syllables (Complex Words)
					$this->postMeta['onpageseo_global_settings']['ComplexWordsPercentage'] = number_format($readability->percentage_words_with_three_syllables($unStrippedContent), 2, '.', '');

		}







		function str_encode_utf8($string)
		{ 
			if (mb_detect_encoding($string, 'UTF-8', true) === FALSE)
			{ 
				$string = utf8_encode($string); 
			}

			return $string; 
		}






		function stripOtherTags($content)
		{
			$content = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', " ", $content);
			$content = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', " ", $content);
			$content = preg_replace('/<div class="quicklinks">(.*?)<\/div>/is', " ", $content);

			// Corrects Issue With getURLBodyText() Stripping Tags Without Leaving Spaces (1-11-2012)
			$content = str_replace('<', ' <', $content);

			return($content);
		}



		function updatePost($postID, $postKey, $postVar)
		{
			global $wpdb;
			// UTF-8 Escape Percent 10-3-2011
			$postVar = str_replace('%', '%%', $postVar);
			$wpdb->query($wpdb->prepare("UPDATE $wpdb->posts SET $postKey='%s' WHERE ID='%d'", $postVar, $postID));
		}



		function stripChars($content)
		{
			return preg_replace('/[^\w\- ]/i', '', html_entity_decode($this->stripTagsAddSpace(stripslashes(trim($content))), ENT_QUOTES, get_bloginfo('charset')));
		}



		function selected($field, $value)
		{
			if(isset($_REQUEST[$field]) && $_REQUEST[$field] == $value)
				return ' selected="selected"';
		}



		function getMonthName($month)
		{
			$mon = array('', __('January', OPSEO_TEXT_DOMAIN), __('February', OPSEO_TEXT_DOMAIN), __('March', OPSEO_TEXT_DOMAIN), __('April', OPSEO_TEXT_DOMAIN), __('May', OPSEO_TEXT_DOMAIN), __('June', OPSEO_TEXT_DOMAIN), __('July', OPSEO_TEXT_DOMAIN), __('August', OPSEO_TEXT_DOMAIN), __('September', OPSEO_TEXT_DOMAIN), __('October', OPSEO_TEXT_DOMAIN), __('November', OPSEO_TEXT_DOMAIN), __('December', OPSEO_TEXT_DOMAIN));
			return $mon[(int)$month];
		}



		function checkKeyword()
		{
			if($this->strExists($this->options['unicode_support']))
			{
				return ((isset($_REQUEST['mainkeyword']) && (strlen(trim($_REQUEST['mainkeyword'])) > 0))  || (isset($this->postMeta[mb_strtolower($this->postMeta['onpageseo_global_settings']['MainKeyword'], 'UTF-8')]['Keyword']) && (strlen(trim($this->postMeta[mb_strtolower($this->postMeta['onpageseo_global_settings']['MainKeyword'], 'UTF-8')]['Keyword'])) > 0))) ? 1 : 0;
			}
			else
			{
				return ((isset($_REQUEST['mainkeyword']) && (strlen(trim($_REQUEST['mainkeyword'])) > 0))  || (isset($this->postMeta[strtolower($this->postMeta['onpageseo_global_settings']['MainKeyword'])]['Keyword']) && (strlen(trim($this->postMeta[strtolower($this->postMeta['onpageseo_global_settings']['MainKeyword'])]['Keyword'])) > 0))) ? 1 : 0;
			}
		}



		function checkFactor($pattern, $content, $all=0)
		{
			$result = 0;
			if($all) { if(preg_match_all($pattern, $content)) {$result = 1;} }
			else { if(preg_match($pattern, $content)) {$result = 1;} }
			return($result);
		}





		function getURLBodyText($content)
		{
			@$dom = new DOMDocument();
			@$dom->loadHTML($content);
			@$xpath = new DOMXPath(@$dom);
			@$elements = $xpath->query('//body');
			$tempContent = '';

			foreach ($elements as $e)
			{
				$tempContent .= trim($e->textContent);
			}

			if(trim($tempContent))
			{
				$tempContent = str_replace('[edit]', '', $tempContent);
				return $tempContent;
			}
			else
			{
				$content = str_replace('[edit]', '', $content);
				return $content;
			}
		}






		function getTagContents($tagname, $content)
		{
			@$dom = new DOMDocument();
			@$dom->encoding = 'UTF-8';
			@$dom->loadHTML($content);
			@$xpath = new DOMXPath(@$dom);
			@$elements = $xpath->query('//'.$tagname);

			foreach ($elements as $e)
			{
				$nodeValue = $e->nodeValue;

				if($tagname == 'title') { $this->seoReport['Title'][] = $nodeValue; }
				elseif($tagname == 'h1') { $this->seoReport['H1'][] = $nodeValue; }
				elseif($tagname == 'h2') { $this->seoReport['H2'][] = $nodeValue; }
				elseif($tagname == 'h3') { $this->seoReport['H3'][] = $nodeValue; }
			}
		}



		function getMetaTagContents($attribute, $content)
		{
			@$dom = new DOMDocument();
			@$dom->loadHTML($content);
			@$xpath = new DOMXPath(@$dom);
			@$elements = $xpath->query('//meta[contains(@name, "'.$attribute.'")]');

			foreach ($elements as $e)
			{
				$attributeContent = $e->getAttribute('content');

				if($attribute == 'description') { $this->seoReport['DescriptionMetaTag'][] = $attributeContent; }
				elseif($attribute == 'keywords') { $this->seoReport['KeywordsMetaTag'][] = $attributeContent; }
			}
		}



		function analyzeTag($tagname, $content, $keyword, $beginning="")
		{
			@$dom = new DOMDocument();

			if($this->strExists($this->options['unicode_support']))
			{
				$content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
				@$dom->loadHTML(mb_strtolower($content, 'UTF-8'));
			}
			else
			{
				@$dom->loadHTML(strtolower($content));
			}


			@$xpath = new DOMXPath(@$dom);
			@$elements = $this->strExists($this->options['unicode_support']) ? $xpath->query('//'.$tagname.'[contains(., "'.mb_strtolower($keyword, 'UTF-8').'")]') : $xpath->query('//'.$tagname.'[contains(., "'.strtolower($keyword).'")]');

			$result = 0;
			$begin = 0;
			$regex = $this->strExists($this->options['unicode_support']) ? $this->hexRegEx : '/\b'.$keyword.'\b/i';
			$regexBeginning = $this->strExists($this->options['unicode_support']) ? '/^'.$this->hexKeyword.'(?=[\s\p{P}\p{S}\p{C}]|$)/uis' : '/^'.$keyword.'\b/i';

			foreach ($elements as $e)
			{
				if(preg_match($regex, $e->nodeValue, $matches))
				{
					$result = 1;

					// Beginning
					if($beginning && !$begin)
					{
						if(preg_match($regexBeginning, trim($e->nodeValue), $matches))
						{
							$begin = 1;
						}
					}
				}
			}

			if($beginning) { return(array($result, $begin)); }
			else { return $result; }
		}



		function analyzeTagLength($tagname, $content, $keyword)
		{
			@$dom = new DOMDocument();
			@$dom->loadHTML(strtolower($content));
			@$xpath = new DOMXPath(@$dom);
			@$elements = $xpath->query('//'.$tagname);

			$words = 0;
			$chars = 0;

			foreach ($elements as $e)
			{
				$words = $this->strExists($this->options['unicode_support']) ? $this->countWords(trim($e->nodeValue)) : str_word_count(trim($e->nodeValue));
				$numChars = str_replace('jesdfsdf', 'X', $e->nodeValue);
				$chars = $this->strExists($this->options['unicode_support']) ? mb_strlen($numChars) : strlen(utf8_decode($numChars));
				//$chars = strlen(utf8_decode($numChars));
				if($tagname == 'title') { break; }
			}

			return(array($words, $chars));
		}



		function analyzeImageTag($content, $keyword)
		{
			@$dom = new DOMDocument();

			if($this->strExists($this->options['unicode_support']))
			{
				$content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
				@$dom->loadHTML(mb_strtolower($content, 'UTF-8'));
			}
			else
			{
				@$dom->loadHTML(strtolower($content));
			}

			@$xpath = new DOMXPath(@$dom);
			@$elements = $this->strExists($this->options['unicode_support']) ? $xpath->query('//img[contains(@alt, "'.mb_strtolower($keyword, 'UTF-8').'")]') : $xpath->query('//img[contains(@alt, "'.strtolower($keyword).'")]');

			$result = 0;
			$regex = $this->strExists($this->options['unicode_support']) ? $this->hexRegEx : '/\b'.$keyword.'\b/i';

			foreach ($elements as $e)
			{
				if(preg_match($regex, $e->getAttribute('alt'), $matches))
				{
					$result = 1;
				}
			}

			return $result;
		}




















		function analyzeMetaTag($attribute, $content, $keyword, $beginning="")
		{
			@$dom = new DOMDocument();

			if($this->strExists($this->options['unicode_support']))
			{
				$content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
				@$dom->loadHTML(mb_strtolower($content, 'UTF-8'));
			}
			else
			{
				@$dom->loadHTML(strtolower($content));
			}

			@$xpath = new DOMXPath(@$dom);
			@$elements = $this->strExists($this->options['unicode_support']) ? $xpath->query('//meta[contains(@name, "'.$attribute.'") and contains(@content, "'.mb_strtolower($keyword, 'UTF-8').'")]') : $xpath->query('//meta[contains(@name, "'.$attribute.'") and contains(@content, "'.strtolower($keyword).'")]');

			$result = 0;
			$begin = 0;
			$regex = $this->strExists($this->options['unicode_support']) ? $this->hexRegEx : '/\b'.$keyword.'\b/i';
			$regexBeginning = $this->strExists($this->options['unicode_support']) ? '/^'.$this->hexKeyword.'(?=[\s\p{P}\p{S}\p{C}]|$)/uis' : '/^'.$keyword.'\b/i';

			foreach ($elements as $e)
			{
				if(preg_match($regex, $e->getAttribute('content'), $matches))
				{

					$result = 1;

					// Beginning
					if($beginning && !$begin)
					{
						if(preg_match($regexBeginning, trim($e->getAttribute('content')), $matches))
						{
							$begin = 1;
						}
					}
				}
			}

			if($beginning) { return(array($result, $begin)); }
			else { return $result; }
		}



		function analyzeMetaTagLength($attribute, $content, $keyword)
		{
			@$dom = new DOMDocument();

			if($this->strExists($this->options['unicode_support']))
			{
				$content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
				@$dom->loadHTML(mb_strtolower($content, 'UTF-8'));
			}
			else
			{
				@$dom->loadHTML(strtolower($content));
			}

			@$xpath = new DOMXPath(@$dom);

			@$elements = $xpath->query('//meta[contains(@name, "'.$attribute.'")]');

			$words = 0;
			$chars = 0;

			foreach ($elements as $e)
			{
				$words = $this->strExists($this->options['unicode_support']) ? $this->countWords(trim($e->getAttribute('content'))) : str_word_count(trim($e->getAttribute('content')));

				$numChars = str_replace('jesdfsdf', 'X', $e->getAttribute('content'));

				$chars = strlen(utf8_decode($numChars));
			}

			return(array($words, $chars));
		}



		function analyzeBoldDecoration($content, $keyword)
		{
			@$dom = new DOMDocument();

			if($this->strExists($this->options['unicode_support']))
			{
				$content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
				@$dom->loadHTML(mb_strtolower($content, 'UTF-8'));
			}
			else
			{
				@$dom->loadHTML(strtolower($content));
			}

			@$xpath = new DOMXPath(@$dom);

			@$elements = $this->strExists($this->options['unicode_support']) ? $xpath->query('//b[contains(., "'.mb_strtolower($keyword, 'UTF-8').'")]|//strong[contains(., "'.mb_strtolower($keyword, 'UTF-8').'")]|//span[contains(@style, "bold") and contains(., "'.mb_strtolower($keyword, 'UTF-8').'")]') : $xpath->query('//b[contains(., "'.strtolower($keyword).'")]|//strong[contains(., "'.strtolower($keyword).'")]|//span[contains(@style, "bold") and contains(., "'.strtolower($keyword).'")]');

			$result = 0;
			$regex = $this->strExists($this->options['unicode_support']) ? $this->hexRegEx : '/\b'.$keyword.'\b/i';

			foreach ($elements as $e)
			{
				$val = '';
				if(isset($e->nodeValue) && (strlen(trim($e->nodeValue)) > 0)) { $val = $e->nodeValue; }
				else { $val = $e->getAttribute('style'); }

				if(preg_match($regex, $val, $matches))
				{
					$result = 1;
				}
			}

			return $result;
		}



		function analyzeItalicDecoration($content, $keyword)
		{
			@$dom = new DOMDocument();

			if($this->strExists($this->options['unicode_support']))
			{
				$content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
				@$dom->loadHTML(mb_strtolower($content, 'UTF-8'));
			}
			else
			{
				@$dom->loadHTML(strtolower($content));
			}

			@$xpath = new DOMXPath(@$dom);

			@$elements = $this->strExists($this->options['unicode_support']) ? $xpath->query('//i[contains(., "'.mb_strtolower($keyword, 'UTF-8').'")]|//em[contains(., "'.mb_strtolower($keyword, 'UTF-8').'")]|//span[contains(@style, "italic") and contains(., "'.mb_strtolower($keyword, 'UTF-8').'")]') : $xpath->query('//i[contains(., "'.strtolower($keyword).'")]|//em[contains(., "'.strtolower($keyword).'")]|//span[contains(@style, "italic") and contains(., "'.strtolower($keyword).'")]');

			$result = 0;
			$regex = $this->strExists($this->options['unicode_support']) ? $this->hexRegEx : '/\b'.$keyword.'\b/i';

			foreach ($elements as $e)
			{
				$val = '';
				if(isset($e->nodeValue) && (strlen(trim($e->nodeValue)) > 0)) { $val = $e->nodeValue; }
				else { $val = $e->getAttribute('style'); }

				if(preg_match($regex, $val, $matches))
				{
					$result = 1;
				}
			}

			return $result;
		}



		function analyzeUnderlineDecoration($content, $keyword)
		{
			@$dom = new DOMDocument();

			if($this->strExists($this->options['unicode_support']))
			{
				$content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
				@$dom->loadHTML(mb_strtolower($content, 'UTF-8'));
			}
			else
			{
				@$dom->loadHTML(strtolower($content));
			}

			@$xpath = new DOMXPath(@$dom);

			@$elements = $this->strExists($this->options['unicode_support']) ? $xpath->query('//u[contains(., "'.mb_strtolower($keyword, 'UTF-8').'")]|//span[contains(@style, "underline") and contains(., "'.mb_strtolower($keyword, 'UTF-8').'")]') : $xpath->query('//u[contains(., "'.strtolower($keyword).'")]|//span[contains(@style, "underline") and contains(., "'.strtolower($keyword).'")]');

			$result = 0;
			$regex = $this->strExists($this->options['unicode_support']) ? $this->hexRegEx : '/\b'.$keyword.'\b/i';

			foreach ($elements as $e)
			{
				$val = '';
				if(isset($e->nodeValue) && (strlen(trim($e->nodeValue)) > 0)) { $val = $e->nodeValue; }
				else { $val = $e->getAttribute('style'); }

				if(preg_match($regex, $val, $matches))
				{
					$result = 1;
				}
			}

			return $result;
		}





		function analyzeAnchorTag($linkType, $content, $keyword, $domainName)
		{
			@$dom = new DOMDocument();

			if($this->strExists($this->options['unicode_support']))
			{
				$content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
				@$dom->loadHTML(mb_strtolower($content, 'UTF-8'));
			}
			else
			{
				@$dom->loadHTML(strtolower($content));
			}

			@$xpath = new DOMXPath(@$dom);
			@$elements = $this->strExists($this->options['unicode_support']) ? $xpath->query('//a[contains(., "'.mb_strtolower($keyword, 'UTF-8').'")]') : $xpath->query('//a[contains(., "'.strtolower($keyword).'")]');

			$result = 0;
			$domainName = str_replace('/', '\/', $domainName);
			$regex = $this->strExists($this->options['unicode_support']) ? $this->hexRegEx : '/\b'.$keyword.'\b/i';

			foreach ($elements as $e)
			{
				if(preg_match($regex, $e->nodeValue, $matches))
				{
					// Internal
					if(preg_match('/^\/|'.$domainName.'/i', trim($e->getAttribute('href')), $matches))
					{
						if($linkType == 'internal') { $result = 1; }
					}
					// External
					else { if($linkType == 'external') { $result = 1; } }
				}
			}

			return $result;
		}





		function checkHeaderTags($tag, $keyword, $content, $beginning=0)
		{
			$result = 0;
			$pattern = '';
			$pattern1 = '';

			if($this->strExists($this->options['unicode_support']))
			{
				$pattern = '/<'.$tag.'[^>]*>(.*(?<=[\s\p{P}\p{S}\p{C}]|^)'.$this->hexKeyword.'(?=[\s\p{P}\p{S}\p{C}]|$).*)<\/'.$tag.'>/siU';
				$pattern1 = '/<'.$tag.'[^>]*>((?<=[\s\p{P}\p{S}\p{C}]|^)'.$this->hexKeyword.'(?=[\s\p{P}\p{S}\p{C}]|$).*)<\/'.$tag.'>/siU';
			}
			else
			{
				$pattern = '/<'.$tag.'[^>]*>(.*\b'.$keyword.'\b.*)<\/'.$tag.'>/siU';
				$pattern1 = '/<'.$tag.'[^>]*>(\b'.$keyword.'\b.*)<\/'.$tag.'>/siU';
			}

			if($beginning) { $pattern = $pattern1; }

			if(preg_match($pattern, $content, $matches))
			{
				$result = 1;
			}

			return $result;
		}


		function sanitizePostID()
		{
			if(isset($_REQUEST['post_ID']) && !is_array($_REQUEST['post_ID']) && (strlen(trim($_REQUEST['post_ID'])) > 0))
				$this->postID = intval(stripslashes($_REQUEST['post_ID']));
			elseif(isset($_REQUEST['post']) && !is_array($_REQUEST['post']) && (strlen(trim($_REQUEST['post'])) > 0))
				$this->postID = intval(stripslashes($_REQUEST['post']));
		}



		function filterInput($data)
		{
			$data = trim(htmlentities($this->stripTagsAddSpace($data)));

			if (get_magic_quotes_gpc())
				$data = stripslashes($data);

			//$data = mysql_real_escape_string($data);

			return $data;
		}



		function unTexturize($content)
		{
			$content = str_replace('&#8216;', "'", $content);
			$content = str_replace('&#8217;', "'", $content);
			$content = str_replace('&#8242;', "'", $content);
			$content = str_replace('&#8220;', '"', $content);
			$content = str_replace('&#8221;', '"', $content);
			$content = str_replace('&#8243;', '"', $content);
			$content = str_replace('&#8211;', '--', $content);
			$content = str_replace(' &#8212; ', ' -- ', $content);
			$content = preg_replace('/(\w)&#8212;(\w)/', '$1---$2', $content);
			$content = str_replace('&#8230;', '...', $content);
			$content = str_replace('&#215;', 'x', $content);
			$content = str_replace('&amp;', '&', $content);
			$content = str_replace('&#038;', '&', $content);
			$content = str_replace('&quot;', "'", $content);
			$content = str_replace('&#169;', '(c)', $content);
			$content = str_replace('&#174;', '(r)', $content);
			$content = str_replace('&Prime;', '"', $content);
			$content = str_replace('&prime;', "'", $content);
			//$content = preg_replace('/[\x{82}]/usix', '', $content);
			//$content = str_replace('\x{fffd}', '', $content);

			return($content);
		}



		function convertDateTimeToUnixTime($dateTime)
		{
			list($date, $time) = explode(' ', $dateTime);
			list($year, $month, $day) = explode('-', $date);
			list($hour, $minute, $second) = explode(':', $time);
			return(mktime($hour, $minute, $second, $month, $day, $year));
		}



		/**
		 * Ensure string ends with the specified character
		 *
		 * @param	$str	String to validate
		 * @return	$str
		 */

		function addTrailingCharacter($str, $char)
		{
			if (strlen($str) > 0)
			{
				if (substr($str, -1) !== $char) { return $str . $char; }
				else { return $str; }
			}
			else { return $char; }
		}



		function preUnSerialize($content)
		{
    			$content = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $content);
    			return unserialize($content);
		}



		/**
		 * Posts success message in WP Admin
		 *
		 * @param	string	$msg
		 */

		function alertMessage($msg)
		{
			echo "<div id='setting-error-settings_updated' class='updated settings-error'> 
			<p><strong>".$msg."</strong></p></div>";

		}



		/**
		 * Posts error message in WP Admin
		 *
		 * @param	string	$msg
		 */

		function errorMessage($msg)
		{
			echo "<div class='error'><p><strong>".$msg."</strong></p></div>";

		}



		function displayEditColumns($columns, $postID)
		{
			list($score,$keyword,$kwDensity) = $this->getScoreKeyword($postID);

			switch ($columns)
			{
				case 'onpagescore':
					$color = ($score >= $this->minimumScore) ? 'green' : 'red';
					if ($score) {echo '<span style="color:'.$color.';">'.$score.'%</span>'; }
					break;
				case 'mainkeyword':
					if ($keyword) {echo $keyword; }
					break;
				case 'kwdensity':
					$color = ( ($kwDensity <= $this->options['keyword_density_maximum'] && $kwDensity >= $this->options['keyword_density_minimum']) ) ? 'green' : 'red';
					if ($kwDensity) {echo '<span style="color:'.$color.';">'.$kwDensity.'%</span>'; }
					break;
			}
		}



		function addEditColumns($columns)
		{
			$columns2 = array();
			$count=0;

			foreach($columns as $key=>$val)
			{
				// Insert Two Columns After "Author"
				if($count == 3)
				{
					// On-Page SEO Score
					if(isset($this->options['posts_columns_score']))
					{
						$columns2['onpagescore'] = __('On-Page SEO Score', OPSEO_TEXT_DOMAIN);
					}

					// Primary Keyword
					if(isset($this->options['posts_columns_keyword']))
					{
						$columns2['mainkeyword'] = __('Primary Keyword', OPSEO_TEXT_DOMAIN);
					}

					// Keyword Density
					if(isset($this->options['posts_columns_kw_density']))
					{
						$columns2['kwdensity'] = __('Keyword Density', OPSEO_TEXT_DOMAIN);
					}

					$columns2[$key] = $val;
				}
				else { $columns2[$key] = $val; }

				$count++;
			}

			return $columns2;
		}



		function updateWPThemesPostMetaData($postID)
		{
			global $wpdb;

			// Thesis
			if(isset($_REQUEST['thesis_title']) && isset($_REQUEST['thesis_description']) && isset($_REQUEST['thesis_keywords']))
			{
				update_post_meta($postID, 'thesis_title', $_REQUEST['thesis_title']);
				update_post_meta($postID, 'thesis_description', $_REQUEST['thesis_description']);
				update_post_meta($postID, 'thesis_keywords', $_REQUEST['thesis_keywords']);
			}

			// Headway
			if(isset($_REQUEST['seo']) && is_array($_REQUEST['seo']) && isset($_REQUEST['seo']['title']) && isset($_REQUEST['seo']['description']) && isset($_REQUEST['seo']['keywords']))
			{
				update_post_meta($postID, '_title', $_REQUEST['seo']['title']);
				update_post_meta($postID, '_description', $_REQUEST['seo']['description']);
				update_post_meta($postID, '_keywords', $_REQUEST['seo']['keywords']);
			}

			// Catalyst
			if(isset($_REQUEST['catalyst_options']) && is_array($_REQUEST['catalyst_options']) && isset($_REQUEST['catalyst_options']['_catalyst_title']) && isset($_REQUEST['catalyst_options']['_catalyst_description']) && isset($_REQUEST['catalyst_options']['_catalyst_keywords']))
			{
				update_post_meta($postID, '_catalyst_title', $_REQUEST['catalyst_options']['_catalyst_title']);
				update_post_meta($postID, '_catalyst_description', $_REQUEST['catalyst_options']['_catalyst_description']);
				update_post_meta($postID, '_catalyst_keywords', $_REQUEST['catalyst_options']['_catalyst_keywords']);
			}

			// Genesis Framework
			if(isset($_REQUEST['genesis_seo']) && is_array($_REQUEST['genesis_seo']) && isset($_REQUEST['genesis_seo']['_genesis_title']) && isset($_REQUEST['genesis_seo']['_genesis_description']) && isset($_REQUEST['genesis_seo']['_genesis_keywords']))
			{
				update_post_meta($postID, '_genesis_title', $_REQUEST['genesis_seo']['_genesis_title']);
				update_post_meta($postID, '_genesis_description', $_REQUEST['genesis_seo']['_genesis_description']);
				update_post_meta($postID, '_genesis_keywords', $_REQUEST['genesis_seo']['_genesis_keywords']);
			}

			// WooThemes and Elegant Themes
			if(isset($_REQUEST['seo_title']) && isset($_REQUEST['seo_description']) && isset($_REQUEST['seo_keywords']))
			{
				update_post_meta($postID, 'seo_title', $_REQUEST['seo_title']);
				update_post_meta($postID, 'seo_description', $_REQUEST['seo_description']);
				update_post_meta($postID, 'seo_keywords', $_REQUEST['seo_keywords']);
			}

			// OptimizePress
			if(isset($_REQUEST['_seo_customtitletag']) && isset($_REQUEST['_seo_metadescription']) && isset($_REQUEST['_seo_metakeywords']))
			{
				update_post_meta($postID, '_seo_customtitletag', $_REQUEST['_seo_customtitletag']);
				update_post_meta($postID, '_seo_metadescription', $_REQUEST['_seo_metadescription']);
				update_post_meta($postID, '_seo_metakeywords', $_REQUEST['_seo_metakeywords']);
			}

			// Hybrid Framework
			if(isset($_REQUEST['Title']) && isset($_REQUEST['Description']) && isset($_REQUEST['Keywords']))
			{
				update_post_meta($postID, 'Title', $_REQUEST['Title']);
				update_post_meta($postID, 'Description', $_REQUEST['Description']);
				update_post_meta($postID, 'Keywords', $_REQUEST['Keywords']);
			}

			// ProfitsTheme
			if(isset($_REQUEST['seo_title']) && isset($_REQUEST['seo_desc']) && isset($_REQUEST['seo_keywords']))
			{
				update_post_meta($postID, 'seo_title', $_REQUEST['seo_title']);
				update_post_meta($postID, 'seo_desc', $_REQUEST['seo_desc']);
				update_post_meta($postID, 'seo_keywords', $_REQUEST['seo_keywords']);
			}
		}



	function ajaxCopyscape()
	{
?>
<script type="text/javascript" >
jQuery(document).ready(function($) {

	$('#onpageseo-copyscape-loader').hide();
	//$('#onpageseo-copyscape-results').hide();

	jQuery('#check-copyscape-scores').click(function(){

	$('#onpageseo-copyscape-loader').show();
	$('#onpageseo-copyscape-results').hide();

	var data = {
		action: 'onpageseo_copyscape',
		content: document.getElementById('content').value
	};

	jQuery.post(ajaxurl, data, function(response) {
		if(response)
		{
			$('#onpageseo-copyscape-results').html(response);
			$('#onpageseo-copyscape-loader').hide();
			$('#onpageseo-copyscape-results').show();

			$('#allcopyscaperesults').val($('#onpageseo-copyscape-results').html());
			$('#updatedcopyscaperesults').val('1');

			// Update Balance
			$(this).opseoCopyScapeBalance();
		}
	});
	return false;
	});

});

jQuery.fn.opseoCopyScapeBalance = function() {

	var data = {
		action: 'onpageseo_copyscape_balance'
	};

	jQuery.post(ajaxurl, data, function(response) {
		if(response)
		{
			jQuery('#onpageseo-copyscape-balance').html(response);
		}
	});

	return false;

};


</script>
<?php
}


function ajaxCopyscapeCheck()
{
	include(trailingslashit(OPSEO_PLUGIN_FULL_PATH).'onpageseo-admin-copyscape.php');
	$copyScape = new OnPageSEOCopyscape($this->options);

	// Request
	$copyScapeResults = $copyScape->copyscape_api_text_search($this->stripTagsAddSpace($_POST['content']), get_bloginfo('charset'));

	// Could Not Connect To Copyscape
	if(!isset($copyScapeResults) || !is_array($copyScapeResults) || sizeof($copyScapeResults) == 0)
	{
		echo 'ERROR: Could not connect to Copyscape service.  Please, try again in a few minutes.';
	}
	// Error
	elseif($copyScapeResults['error'])
	{
		echo 'ERROR: '.$copyScapeResults['error'];
	}
	// Success
	else
	{
		// Passed Copyscape
		if(isset($copyScapeResults['count']) && $copyScapeResults['count'] == 0)
		{
			echo '<p style="font-weight:normal !important;margin:10px 0 !important;padding:0 !important;text-align:center !important;">'.__('Content Passed Copyscape!', OPSEO_TEXT_DOMAIN).'</p>';
		}
		// Duplicates Found
		else
		{
			echo '<p style="font-weight:normal !important;margin:10px 0 !important;padding:0 !important;text-align:center !important;" id="copyscape-duplicates-found">'.sprintf(__('Copyscape Found %d Duplicates', OPSEO_TEXT_DOMAIN), sizeof($copyScapeResults['result'])).':</p>';

			echo '<ol class="overflowol" id="copyscapeinner">';

			foreach($copyScapeResults['result'] as $result)
			{
				echo '<li class="onpageseocopyscapeli"><strong>'.$result['index'].'. <a href="'.$result['url'].'" target="_blank">'.$result['title'].'</a></strong><br />';
				echo $result['htmlsnippet'].'</li>';
			}

			echo '</ol>';
		}
	}

	die();

}



function ajaxCopyscapeBalance()
{
	include(trailingslashit(OPSEO_PLUGIN_FULL_PATH).'onpageseo-admin-copyscape.php');
	$copyScape = new OnPageSEOCopyscape($this->options);


	if(isset($this->options['copyscape_username']) && (strlen(trim($this->options['copyscape_username'])) > 0) && isset($this->options['copyscape_api_key']) && (strlen(trim($this->options['copyscape_api_key'])) > 0))
	{
		// Check Balance
		$balance = $copyScape->copyscape_api_check_balance();

		// Error
		if(isset($balance['error']))
		{
			echo '<p style="font-weight:normal !important;margin:0 !important;padding:0 !important;">'.__('ERROR', OPSEO_TEXT_DOMAIN).': '.$balance['error'].'</p>';
		}
		// No Credits
		elseif(!$balance['total'])
		{
			echo '<p style="font-weight:normal !important;margin:0 !important;padding:0 !important;">'.__('ERROR: You need to buy more Copyscape Premium credits.', OPSEO_TEXT_DOMAIN).'</p>';
		}
		// Available Credits
		else
		{
			echo '<p style="font-weight:normal !important;margin:0 !important;padding:0 !important;text-align:center !important;" id="onpageseo-copyscape-balance"><strong>'.__('Balance', OPSEO_TEXT_DOMAIN).':</strong> $'.$balance['value'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>'.__('Credits', OPSEO_TEXT_DOMAIN).':</strong> '.$balance['total'].'</p>';
		}
	}
	else
	{
		echo '<p style="font-weight:normal !important;margin:0 !important;padding:0 !important;">'.__('Sorry, but you need to enter your Copyscape username and API key.', OPSEO_TEXT_DOMAIN).'</p>';
	}


	die();

}



		function ajaxLSIKeywords()
		{
			echo $this->stripTagsAddSpace($_POST['content']);

			die();
		}




		function stripTagsAddSpace($content)
		{
			$content = strip_tags(str_replace('<', ' <', $content));
			return(preg_replace('/\s{2,}/', ' ', trim($content)));
		}



		function displaySEOKeywordReport($selectedKeyword)
		{
			echo '<h3 style="margin:0 0 10px 0 !important;padding-bottom:0 0 3px 0 !important;border-bottom:1px solid #03486e;color:#03486e !important;">'.__('Scores', OPSEO_TEXT_DOMAIN).'</h3>

			<p style="margin:0 0 10px 0 !important;padding-bottom:0 0 5px 0 !important;"><b>'.__('SEO Score', OPSEO_TEXT_DOMAIN).':</b> '.$this->postMeta[$selectedKeyword]['TotalScore'].'%</p>

			<p style="margin:0 0 20px 0 !important;padding-bottom:0 0 5px 0 !important;"><b>'.__('Keyword Density', OPSEO_TEXT_DOMAIN).':</b> '.$this->postMeta[$selectedKeyword]['KeywordDensityScore'].'%</p>


			<h3 style="margin:0 0 10px 0 !important;padding-bottom:0 0 3px 0 !important;border-bottom:1px solid #03486e;color:#03486e !important;">'.__('Title', OPSEO_TEXT_DOMAIN).'</h3>';

			$answer = (isset($this->postMeta[$selectedKeyword]['KeywordTitleBeginning']) && $this->postMeta[$selectedKeyword]['KeywordTitleBeginning']) ? __('Yes', OPSEO_TEXT_DOMAIN) : __('No', OPSEO_TEXT_DOMAIN);
			echo '<p style="margin:0 0 10px 0 !important;padding-bottom:0 0 5px 0 !important;"><b>'.__('Title contains keyword', OPSEO_TEXT_DOMAIN).':</b> '.$answer.'</p>';

			$answer = (isset($this->postMeta[$selectedKeyword]['KeywordTitleBeginning']) && $this->postMeta[$selectedKeyword]['KeywordTitleBeginning']) ? __('Yes', OPSEO_TEXT_DOMAIN) : __('No', OPSEO_TEXT_DOMAIN);
			echo '<p style="margin:0 0 10px 0 !important;padding-bottom:0 0 5px 0 !important;"><b>'.__('Title begins with keyword', OPSEO_TEXT_DOMAIN).':</b> '.$answer.'</p>';

			$answer = (isset($this->postMeta[$selectedKeyword]['TitleWords']) && $this->postMeta[$selectedKeyword]['TitleWords']) ? __('Yes', OPSEO_TEXT_DOMAIN) : __('No', OPSEO_TEXT_DOMAIN);
			echo '<p style="margin:0 0 10px 0 !important;padding-bottom:0 0 5px 0 !important;"><b>'.sprintf(__('Title contains at least %d words', OPSEO_TEXT_DOMAIN), $this->options['title_length_minimum']).':</b> '.$answer.'</p>';

			$answer = (isset($this->postMeta[$selectedKeyword]['TitleChars']) && $this->postMeta[$selectedKeyword]['TitleChars']) ? __('Yes', OPSEO_TEXT_DOMAIN) : __('No', OPSEO_TEXT_DOMAIN);
			echo '<p style="margin:0 0 20px 0 !important;padding-bottom:0 0 5px 0 !important;"><b>'.sprintf(__('Title contains up to %d characters', OPSEO_TEXT_DOMAIN), $this->options['title_length_maximum']).':</b> '.$answer.'</p>';


			echo '<h3 style="margin:0 0 10px 0 !important;padding-bottom:0 0 3px 0 !important;border-bottom:1px solid #03486e;color:#03486e !important;">'.__('Permalink', OPSEO_TEXT_DOMAIN).'</h3>';

			$answer = (isset($this->postMeta[$selectedKeyword]['Permalink']) && $this->postMeta[$selectedKeyword]['Permalink']) ? __('Yes', OPSEO_TEXT_DOMAIN) : __('No', OPSEO_TEXT_DOMAIN);
			echo '<p style="margin:0 0 20px 0 !important;padding-bottom:0 0 5px 0 !important;"><b>'.__('Permalink contains keyword', OPSEO_TEXT_DOMAIN).':</b> '.$answer.'</p>';


			echo '<h3 style="margin:0 0 10px 0 !important;padding-bottom:0 0 3px 0 !important;border-bottom:1px solid #03486e;color:#03486e !important;">'.__('Meta', OPSEO_TEXT_DOMAIN).'</h3>';

			$answer = (isset($this->postMeta[$selectedKeyword]['DescriptionMetaTag']) && $this->postMeta[$selectedKeyword]['DescriptionMetaTag']) ? __('Yes', OPSEO_TEXT_DOMAIN) : __('No', OPSEO_TEXT_DOMAIN);
			echo '<p style="margin:0 0 10px 0 !important;padding-bottom:0 0 5px 0 !important;"><b>'.__('Description meta tag contains keyword', OPSEO_TEXT_DOMAIN).':</b> '.$answer.'</p>';

			$answer = (isset($this->postMeta[$selectedKeyword]['DescriptionMetaTagLength']) && $this->postMeta[$selectedKeyword]['DescriptionMetaTagLength']) ? __('Yes', OPSEO_TEXT_DOMAIN) : __('No', OPSEO_TEXT_DOMAIN);
			echo '<p style="margin:0 0 10px 0 !important;padding-bottom:0 0 5px 0 !important;"><b>'.sprintf(__('Description meta tag contains up to %d characters', OPSEO_TEXT_DOMAIN), $this->options['description_meta_tag_maximum']).':</b> '.$answer.'</p>';

			$answer = (isset($this->postMeta[$selectedKeyword]['DescriptionMetaTagBeginning']) && $this->postMeta[$selectedKeyword]['DescriptionMetaTagBeginning']) ? __('Yes', OPSEO_TEXT_DOMAIN) : __('No', OPSEO_TEXT_DOMAIN);
			echo '<p style="margin:0 0 10px 0 !important;padding-bottom:0 0 5px 0 !important;"><b>'.__('Description meta tag begins with keyword', OPSEO_TEXT_DOMAIN).':</b> '.$answer.'</p>';

			$answer = (isset($this->postMeta[$selectedKeyword]['KeywordsMetaTag']) && $this->postMeta[$selectedKeyword]['KeywordsMetaTag']) ? __('Yes', OPSEO_TEXT_DOMAIN) : __('No', OPSEO_TEXT_DOMAIN);
			echo '<p style="margin:0 0 20px 0 !important;padding-bottom:0 0 5px 0 !important;"><b>'.__('Keywords meta tag contains keyword', OPSEO_TEXT_DOMAIN).':</b> '.$answer.'</p>';


			echo '<h3 style="margin:0 0 10px 0 !important;padding-bottom:0 0 3px 0 !important;border-bottom:1px solid #03486e;color:#03486e !important;">'.__('Heading', OPSEO_TEXT_DOMAIN).'</h3>';

			$answer = (isset($this->postMeta[$selectedKeyword]['H1']) && $this->postMeta[$selectedKeyword]['H1']) ? __('Yes', OPSEO_TEXT_DOMAIN) : __('No', OPSEO_TEXT_DOMAIN);
			echo '<p style="margin:0 0 10px 0 !important;padding-bottom:0 0 5px 0 !important;"><b>'.__('H1 tag contains keyword', OPSEO_TEXT_DOMAIN).':</b> '.$answer.'</p>';

			$answer = (isset($this->postMeta[$selectedKeyword]['H1']) && $this->postMeta[$selectedKeyword]['H1Beginning']) ? __('Yes', OPSEO_TEXT_DOMAIN) : __('No', OPSEO_TEXT_DOMAIN);
			echo '<p style="margin:0 0 10px 0 !important;padding-bottom:0 0 5px 0 !important;"><b>'.__('H1 tag begins with keyword', OPSEO_TEXT_DOMAIN).':</b> '.$answer.'</p>';

			$answer = (isset($this->postMeta[$selectedKeyword]['H2']) && $this->postMeta[$selectedKeyword]['H2']) ? __('Yes', OPSEO_TEXT_DOMAIN) : __('No', OPSEO_TEXT_DOMAIN);
			echo '<p style="margin:0 0 10px 0 !important;padding-bottom:0 0 5px 0 !important;"><b>'.__('H2 tag contains keyword', OPSEO_TEXT_DOMAIN).':</b> '.$answer.'</p>';

			$answer = (isset($this->postMeta[$selectedKeyword]['H3']) && $this->postMeta[$selectedKeyword]['H3']) ? __('Yes', OPSEO_TEXT_DOMAIN) : __('No', OPSEO_TEXT_DOMAIN);
			echo '<p style="margin:0 0 20px 0 !important;padding-bottom:0 0 5px 0 !important;"><b>'.__('H3 tag contains keyword', OPSEO_TEXT_DOMAIN).':</b> '.$answer.'</p>';


			echo '<h3 style="margin:0 0 10px 0 !important;padding-bottom:0 0 3px 0 !important;border-bottom:1px solid #03486e;color:#03486e !important;">'.__('Content', OPSEO_TEXT_DOMAIN).'</h3>';

			$answer = (isset($this->postMeta[$selectedKeyword]['PostWords']) && $this->postMeta[$selectedKeyword]['PostWords']) ? __('Yes', OPSEO_TEXT_DOMAIN) : __('No', OPSEO_TEXT_DOMAIN);
			echo '<p style="margin:0 0 10px 0 !important;padding-bottom:0 0 5px 0 !important;"><b>'.sprintf(__('Content contains at least %d words', OPSEO_TEXT_DOMAIN), $this->options['post_content_length']).':</b> '.$answer.'</p>';

			$answer = (isset($this->postMeta[$selectedKeyword]['KeywordDensity']) && $this->postMeta[$selectedKeyword]['KeywordDensity']) ? __('Yes', OPSEO_TEXT_DOMAIN) : __('No', OPSEO_TEXT_DOMAIN);
			echo '<p style="margin:0 0 10px 0 !important;padding-bottom:0 0 5px 0 !important;"><b>'.sprintf(__('Content has %s-%s%% keyword density', OPSEO_TEXT_DOMAIN), $this->options['keyword_density_minimum'], $this->options['keyword_density_maximum']).':</b> '.$answer.'</p>';

			$answer = (isset($this->postMeta[$selectedKeyword]['First100Words']) && $this->postMeta[$selectedKeyword]['First100Words']) ? __('Yes', OPSEO_TEXT_DOMAIN) : __('No', OPSEO_TEXT_DOMAIN);
			echo '<p style="margin:0 0 10px 0 !important;padding-bottom:0 0 5px 0 !important;"><b>'.__('Content contains keyword in the first 50-100 words', OPSEO_TEXT_DOMAIN).':</b> '.$answer.'</p>';

			$answer = (isset($this->postMeta[$selectedKeyword]['ImageALT']) && $this->postMeta[$selectedKeyword]['ImageALT']) ? __('Yes', OPSEO_TEXT_DOMAIN) : __('No', OPSEO_TEXT_DOMAIN);
			echo '<p style="margin:0 0 10px 0 !important;padding-bottom:0 0 5px 0 !important;"><b>'.__('Content contains at least one image with keyword in ALT attribute', OPSEO_TEXT_DOMAIN).':</b> '.$answer.'</p>';

			$answer = (isset($this->postMeta[$selectedKeyword]['Bold']) && $this->postMeta[$selectedKeyword]['Bold']) ? __('Yes', OPSEO_TEXT_DOMAIN) : __('No', OPSEO_TEXT_DOMAIN);
			echo '<p style="margin:0 0 10px 0 !important;padding-bottom:0 0 5px 0 !important;"><b>'.__('Content contains at least one bold keyword', OPSEO_TEXT_DOMAIN).':</b> '.$answer.'</p>';

			$answer = (isset($this->postMeta[$selectedKeyword]['Italic']) && $this->postMeta[$selectedKeyword]['Italic']) ? __('Yes', OPSEO_TEXT_DOMAIN) : __('No', OPSEO_TEXT_DOMAIN);
			echo '<p style="margin:0 0 10px 0 !important;padding-bottom:0 0 5px 0 !important;"><b>'.__('Content contains at least one italicized keyword', OPSEO_TEXT_DOMAIN).':</b> '.$answer.'</p>';

			$answer = (isset($this->postMeta[$selectedKeyword]['Underline']) && $this->postMeta[$selectedKeyword]['Underline']) ? __('Yes', OPSEO_TEXT_DOMAIN) : __('No', OPSEO_TEXT_DOMAIN);
			echo '<p style="margin:0 0 10px 0 !important;padding-bottom:0 0 5px 0 !important;"><b>'.__('Content contains at least one underlined keyword', OPSEO_TEXT_DOMAIN).':</b> '.$answer.'</p>';

			$answer = (isset($this->postMeta[$selectedKeyword]['ExternalAnchorText']) && $this->postMeta[$selectedKeyword]['ExternalAnchorText']) ? __('Yes', OPSEO_TEXT_DOMAIN) : __('No', OPSEO_TEXT_DOMAIN);
			echo '<p style="margin:0 0 10px 0 !important;padding-bottom:0 0 5px 0 !important;"><b>'.__('Content contains keyword in anchor text of at least one external link', OPSEO_TEXT_DOMAIN).':</b> '.$answer.'</p>';

			$answer = (isset($this->postMeta[$selectedKeyword]['InternalAnchorText']) && $this->postMeta[$selectedKeyword]['InternalAnchorText']) ? __('Yes', OPSEO_TEXT_DOMAIN) : __('No', OPSEO_TEXT_DOMAIN);
			echo '<p style="margin:0 0 10px 0 !important;padding-bottom:0 0 5px 0 !important;"><b>'.__('Content contains keyword in anchor text of at least one internal link', OPSEO_TEXT_DOMAIN).':</b> '.$answer.'</p>';

			$answer = (isset($this->postMeta[$selectedKeyword]['Last100Words']) && $this->postMeta[$selectedKeyword]['Last100Words']) ? __('Yes', OPSEO_TEXT_DOMAIN) : __('No', OPSEO_TEXT_DOMAIN);
			echo '<p style="margin:0 0 30px 0 !important;padding-bottom:0 0 5px 0 !important;"><b>'.__('Content contains keyword in the last 50-100 words', OPSEO_TEXT_DOMAIN).':</b> '.$answer.'</p>';
		}



		function getCurrentUserRole()
		{
			if(current_user_can('level_10') || current_user_can('level_9') || current_user_can('level_8'))
			{
				return('administrator');
			}
			elseif(current_user_can('level_7') || current_user_can('level_6') || current_user_can('level_5'))
			{
				return('editor');
			}
			elseif(current_user_can('level_4') || current_user_can('level_3') || current_user_can('level_2'))
			{
				return('author');
			}
			elseif(current_user_can('level_1'))
			{
				return('contributor');
			}
			else
			{
				return('subscriber');
			}
		}



		function copyscapeRolePermissions($copyscapeRole)
		{
			$userRole = $this->getCurrentUserRole();

			if($userRole == 'administrator')
			{
				return(1);
			}
			elseif($userRole == 'editor')
			{
				if($copyscapeRole == 'administrator') { return(0); }
				else { return(1); }
			}
			elseif($userRole == 'author')
			{
				if(($copyscapeRole == 'administrator') || ($copyscapeRole == 'editor')) { return(0); }
				else { return(1); }
			}
			elseif($userRole == 'contributor')
			{
				if(($copyscapeRole == 'administrator') || ($copyscapeRole == 'editor') || ($copyscapeRole == 'author')) { return(0); }
				else { return(1); }
			}
			elseif($userRole == 'subscriber')
			{
				if($copyscapeRole != 'subscriber') { return(0); }
				else { return(1); }
			}
		}



		function processActions()
		{
			// Clear Keywords and Scores
			if(isset($_REQUEST[OPSEO_PREFIX.'_clear_all_keywords'])) { $this->clearAllKeywords(); }

			// Reset Options to Defaults
			elseif(isset($_REQUEST[OPSEO_PREFIX.'_reset_options'])) { $this->resetOptionsToDefault(); }

			// Uninstall Plugin
			elseif(isset($_REQUEST[OPSEO_PREFIX.'_uninstall_plugin'])) { $this->uninstallPlugin(); }

			// Hide License
			elseif(isset($_REQUEST[OPSEO_PREFIX.'_hide_license'])) { $this->hideLicense(); }

			// Import SEOPressor Keywords
			elseif(isset($_REQUEST[OPSEO_PREFIX.'_import_seopressor'])) { $this->importKeywords('seopressor'); }

			// Import ClickBump SEO! Keywords
			elseif(isset($_REQUEST[OPSEO_PREFIX.'_import_clickbump'])) { $this->importKeywords('clickbump'); }

			// Import BloggerHigh SEO Keywords
			elseif(isset($_REQUEST[OPSEO_PREFIX.'_import_bloggerhigh'])) { $this->importKeywords('bloggerhigh'); }

			// Import SEO Beast Keywords
			elseif(isset($_REQUEST[OPSEO_PREFIX.'_import_seobeast'])) { $this->importBeastKeywords(); }

			// Save SEO Report
			elseif(isset($_REQUEST[OPSEO_PREFIX.'_save_report'])) { $this->ajaxSaveReport(); }

			// Export Settings
			elseif(isset($_REQUEST[OPSEO_PREFIX.'_export_settings'])) { $this->exportSettings(); }
		}



		function importSettings()
		{
			// HANDLE UPLOAD

			// No File Uploaded
			if (empty($_FILES))
			{
				$this->importError = 1;
			}
			else
			{
				// Upload Error
				if(!$_FILES['file']['name'])
				{
					$this->importError = 1;
				}
				elseif($_FILES['file']['error'] > 0 || !$_FILES['file']['name'])
				{
					$this->importError = 2;
				}
				else
				{
					// Get File Extension
					$ext = strtolower(substr($_FILES['file']['name'], strrpos($_FILES['file']['name'], '.') + 1));

					// Invalid File Type
					if(!$ext || $ext != 'txt')
					{
						$this->importError = 3;
					}
					else
					{
						$dir = wp_upload_dir();
						$directory = trailingslashit($dir['basedir']);
						$fileName = 'onpageseo-settings.txt';

						// Upload File
						if(!move_uploaded_file($_FILES['file']['tmp_name'], $directory.$fileName))
						{
							$this->importError = 4;
							$this->importErrorMessage = sprintf(__('ERROR: Cannot upload %s file to %s directory.', OPSEO_TEXT_DOMAIN), $_FILES["file"]["tmp_name"], $directory);
						}

						// Read File Contents
						$settings = '';
						if(file_exists($directory.$fileName))
						{
							$fh = fopen($directory.$fileName,'r');
							$settings = fread($fh, filesize($directory.$fileName));
							fclose($fh);

							// Update Settings
							if($settings)
							{
								list($settingsArr, $licenseHide) = explode('||||||', $settings);
								$settingsArr = $this->preUnSerialize($settingsArr);
								update_option(OPSEO_PREFIX.'_options', $settingsArr);
								if(trim($licenseHide)) { update_option(OPSEO_PREFIX.'_license_hide', '1'); }
							}

							// Display Updated Message
							$this->successMessage = 1;
						}
						else
						{
							$this->importError = 5;
							$this->importErrorMessage = sprintf(__('ERROR: Cannot open file at %s%s', OPSEO_TEXT_DOMAIN), $directory, $fileName);
						}



					}

				}
			}
		}


		function exportSettings()
		{
			header("Content-Type: plain/text");
			header("Content-Disposition: Attachment; filename=easywpseo-settings.txt");
			header("Pragma: no-cache");

			$settings = get_option(OPSEO_PREFIX.'_options');
			$licenseHide = get_option(OPSEO_PREFIX.'_license_hide');
			echo serialize($settings);
			echo '||||||'.$licenseHide;

			exit;
		}



		function clearAllKeywords()
		{
			global $wpdb;
			$wpdb->query($wpdb->prepare("DELETE FROM $wpdb->postmeta WHERE meta_key='".$this->postMetaDataName."'"));
		}



		function resetOptionsToDefault()
		{
			// Get Old Options
			$oldOptions = get_option(OPSEO_PREFIX.'_options');

			// Get Default Options
			$options = $this->getDefaultOptions();

			// Save License Info
			$options['license_email'] = $oldOptions['license_email'];
			$options['license_serial'] = $oldOptions['license_serial'];

			// Save Default Options
			update_option(OPSEO_PREFIX.'_options', $options);
		}



		function uninstallPlugin()
		{
			global $wpdb;
			global $wp_filesystem;

			// Delete All Keywords and Scores
			$wpdb->query($wpdb->prepare("DELETE FROM $wpdb->postmeta WHERE meta_key='".$this->postMetaDataName."'"));

			// Delete All Plugin Options
			$wpdb->query($wpdb->prepare("DELETE FROM $wpdb->options WHERE option_name='".OPSEO_PREFIX."_options' OR option_name='".OPSEO_PREFIX."_license_check' OR option_name='".OPSEO_PREFIX."_update_check' OR option_name='".OPSEO_PREFIX."_license_hide'"));

			// Deactivate Plugin
			deactivate_plugins(OPSEO_PLUGIN_PATH, true);

			// Redirect
			$this->redirect('plugins.php?deactivate=true');
		}


		function hideLicense()
		{
			$options = update_option(OPSEO_PREFIX.'_license_hide', '1');
			$this->licenseHide = 1;
		}



		function importKeywords($plugin)
		{
			global $wpdb;

			// SEOPressor
			$meta_key = 'posts_rate_key';

			// ClickBump SEO!
			if($plugin == 'clickbump') { $meta_key = '_rseo_keyword'; }

			// BloggerHigh SEO
			elseif($plugin == 'bloggerhigh') { $meta_key = '_psoff_seo_keyword'; }

			$sql_query = "SELECT post_id,meta_value FROM $wpdb->postmeta WHERE meta_key='$meta_key'";
			$sql_result = $wpdb->get_results($wpdb->prepare($sql_query));

			foreach($sql_result as $row)
			{
				$metaData = get_post_meta($row->post_id, $this->postMetaDataName, true);

				// Import If Exists
				if(empty($metaData))
				{
					// Set Post ID
					$this->postID = $row->post_id;

					// Set Main Keyword
					$_REQUEST['mainkeyword'] = $row->meta_value;

					// Save Meta Data
					$this->saveMetaData($row->post_id);
				}
			}
		}


		function importBeastKeywords()
		{
			global $wpdb;
			$option_name = 'seo_beast_meta%';

			$sql_query = "SELECT option_name,option_value FROM $wpdb->options WHERE option_name LIKE 'seo_beast_meta%%' AND blog_id='$wpdb->blogid'";
			$sql_result = $wpdb->get_results($wpdb->prepare($sql_query));

			foreach($sql_result as $row)
			{
				// Extract Post ID
				preg_match('/seo_beast_meta([0-9]+)/i', $row->option_name, $matches);
				$postID = $matches[1];

				// Extract Keyword
				$optionValues = $this->preUnSerialize($row->option_value);
				$keyword = $optionValues['seob_mkwd'];

				if((isset($postID) && (strlen(trim($postID)) > 0)) && (isset($keyword) && (strlen(trim($keyword)) > 0)))
				{
					$metaData = get_post_meta($postID, $this->postMetaDataName, true);

					// Import If Exists
					if(empty($metaData))
					{
						// Set Post ID
						$this->postID = $postID;

						// Set Main Keyword
						$_REQUEST['mainkeyword'] = $keyword;

						// Save Meta Data
						$this->saveMetaData($postID);
					}
				}
			}
		}



		function automaticDecorations($content)
		{
			// Include Automatic Decoration Class
			include('onpageseo-admin-decoration.php');
			$decoration = new OnPageSEOAdminDecoration($this->options);

			if(isset($_REQUEST['mainkeyword']) && (strlen(trim($_REQUEST['mainkeyword'])) > 0))
			{
				$content['post_content'] = $decoration->contentHandler($content['post_content']);
			}
			// No Primary Keyword (12-18-2011)
			else
			{
				// No Follow and Link Target
				if($this->options['no_follow'] || $this->options['link_target'])
				{
					$tempContent = preg_replace_callback('/<a([^>]+)>/siU', array($decoration,'autoNoFollow'), $content['post_content']);
					$content['post_content'] = ($decoration->prcb_check($tempContent)) ? $tempContent : $content['post_content'];
				}
			}

			return($content);
		}



		function redirect($url)
		{
			header('Location:'.$url);
			exit;
		}



		function countWords($string)
		{
			$string = trim(preg_replace('/\s{2,}/', ' ', $string));
			$word_array = explode(' ', $string);
			return(count($word_array));
		}


		function strExists($string)
		{
			if(isset($string) && (strlen(trim($string)) > 0)) { return(1); }
			else { return(0); }
		}



		function removeStopWords($content)
		{
			// Stop Words (12-29-2011)
			$stopWords = '';
			if($this->strExists($this->options['stop_words_enabled']))
			{
				$stopWords = explode("\n", $this->options['stop_words']);
				$swRegEx = '';

				for($i = 0; $i < sizeof($stopWords); $i++)
				{
					$swRegEx = ($this->strExists($this->options['unicode_support'])) ? '/(?<=[\s\p{P}\p{S}\p{C}!\<!\.!\/]|^)(?<![\.\/\<])'.trim($stopWords[$i]).'(?![\/\>=])(?=[\s\p{P}\p{S}\p{C}!\>!\.!\/]|$)/uisx' : '/(?<![\w\d\<\.\/])'.trim($stopWords[$i]).'(?![\w\d\>\/=])/is';

					$content = preg_replace($swRegEx, '', $content);
				}
			}

			// Remove Excess Whitespace
			$content = preg_replace('/\s{2,}/', ' ', trim($content));

			return($content);
		}



		function ajaxSEOReport()
		{
			$this->postID = mysql_real_escape_string($_REQUEST['opseopostid']);
			$type = mysql_real_escape_string($_REQUEST['opseotype']);
			$opseoURL = $_REQUEST['opseourl'];

			// URL Analyzer
			if($type == 2)
			{
				$this->getNonPostURL($this->postID);
			}
			// Post or Page
			else
			{
				$metaData = get_post_meta($this->postID, $this->postMetaDataName, true);

				// Post Meta Data Already Exists
				if(!empty($metaData))
				{
					// Update Total Scores (In Real Time)
					if(is_array($metaData) && isset($metaData['onpageseo_global_settings']))
					{
						foreach($metaData as $key=>$val)
						{
							if($key != 'onpageseo_global_settings')
							{
								$metaData[$key]['TotalScore'] = $this->getKeywordScore($key, $metaData);
							}
						}
					}

					$this->postMeta = $metaData;
				}
			}

			// Analyze Content
			$this->analyzePostSEOReport($type, $opseoURL);

			// Include SEO report
			include_once(OPSEO_PLUGIN_FULL_PATH.'/templates/admin-seo-report.php');

			die();

		}







		function analyzePostSEOReport($type='1', $permalink='')
		{
			if($this->strExists($this->options['unicode_support']))
			{
				header("Content-Type: text/html; charset=utf-8");
			}

			if($type == 1)
			{
				$permalink = '';

				// Get Current Post Information
				$currentPost = get_post($this->postID);

				// Check Post Status
				$postStatus = $currentPost->post_status;

				// Post/Page Not Published
				if($postStatus != 'publish')
				{
					// Change Post Status To "Publish"
					$this->updatePost($this->postID, 'post_status', 'publish');

					// Get Custom Permalink Structure
					$permalink_structure = get_option('permalink_structure');

					// Custom Permalink Structure
					if($permalink_structure)
					{
						// Save Current Post Name
						$postName = $currentPost->post_name;

						// No Post Name Saved or Is Numeric (Possible 404 Errors)
						if((strlen(trim($postName)) == 0) || is_numeric(trim($postName)))
						{
							// Set Post ID As Title If Post Title Does Not Exist
							if(!$currentPost->post_title)
								$currentPost->post_title = (strlen(trim($this->postID)) > 0) ? 'draft'.$this->postID : 'draft';

							// Does Post Name Already Exist In DB
							global $wpdb;
							$incr = -1;

							do {
								// Sanitize Title With Dashes
								$postName = sanitize_title_with_dashes($currentPost->post_title);

								++$incr;
								if($incr) { $postName .= '-'.$incr; }

							} while($wpdb->get_row( $wpdb->prepare("SELECT post_title FROM $wpdb->posts WHERE post_name = '" . $postName . "'", 'ARRAY_A') ));

							// Update Post Name
							$this->updatePost($this->postID, 'post_name', $postName);

							//$permalink = $this->addTrailingCharacter(get_bloginfo('wpurl'), '/') . $postName;

							// Page
							//if ($currentPost->post_type == 'page') { $permalink = get_page_link($this->postID); }
							// Post
							//else { $permalink = $this->getDraftPermalink($currentPost, $permalink_structure, $postName); }

							$permalink = $this->getDraftPermalink($currentPost, $permalink_structure, $postName);
						}
						else
						{
							// Page
							//if ($currentPost->post_type == 'page') { $permalink = get_page_link($this->postID); }
							// Post
							//else
							//{
								//$permalink = $this->addTrailingCharacter(get_bloginfo('wpurl'), '/') . $currentPost->post_name;
								$permalink = $this->getDraftPermalink($currentPost, $permalink_structure, $postName);
							//}
						}
					}
					// Default Permalink Structure
					else { $permalink = get_permalink($this->postID); }

				}
				else { $permalink = get_permalink($this->postID); }
			}

			// URL Decode (9-20-11)
			$permalink = urldecode($permalink);

			// For Permalinks With Spaces (7/27/11)
			$permalink = str_replace(' ','%20', $permalink);

			$domainName = parse_url($permalink, PHP_URL_HOST);

			// For Proxy Server URL (8-5-2011)
			$getPermalink = $permalink;

			if(isset($this->options['proxy_server_url']) && (strlen(trim($this->options['proxy_server_url'])) > 0))
			{
				$getPermalink = $this->options['proxy_server_url'].'?url='.$permalink;
			}

			// Important Variable
			$result = '';
			$rand1 = rand(99,29999);
			$rand2 = rand(99,29999);
			$rand3 = rand(99,29999);
			$rand4 = rand(99,29999);

			// cUrl - Password Protection
			if(($this->options['password_activation'] == 'activated'))
			{
				$ch = curl_init();
				curl_setopt ($ch, CURLOPT_URL, $getPermalink);
				curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/'.$rand1.'.'.$rand2.' (KHTML, like Gecko) Safari/'.$rand3.'.'.$rand4);
				curl_setopt ($ch, CURLOPT_TIMEOUT, $this->options['request_timeout']);
				curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt ($ch, CURLOPT_COOKIEJAR, $this->options['password_file_path']);
				curl_setopt ($ch, CURLOPT_COOKIEFILE, $this->options['password_file_path']);
				//curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-Type: text/xml; charset=utf-8', 'Expect: 100-continue'));
				ob_start();
				$urlResult = curl_exec($ch);
				ob_end_clean();

				// Check for cURL Errors
				if(curl_errno($ch))
				{
					$curlError = curl_error($ch);
					add_action('admin_notices', create_function('', "echo '<div id=\"message\" class=\"error\"><p><strong>'.__('cURL ERROR', OPSEO_TEXT_DOMAIN).':</strong> $curlError.</p></div>';"));
				}
				// Success
				else
				{
					$result['body'] = $this->unTexturize($urlResult);
				}

				curl_close($ch);
				unset($ch);
			}
			// WP_Http
			else
			{
				// Request Post/Page URL
				if(!class_exists('WP_Http'))
					include_once( ABSPATH . WPINC. '/class-http.php' );

				$request = new WP_Http;

				// Set Timeout
				$requestArgs = array(
					'timeout'=>$this->options['request_timeout'],
					'user-agent'=>'Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/'.$rand1.'.'.$rand2.' (KHTML, like Gecko) Safari/'.$rand3.'.'.$rand4,
				);

				$result = $request->request($getPermalink, $requestArgs);

				// Error? Die and Display Error Message
				if(is_wp_error($result))
				{
					// Handle Error Messages
					add_action('admin_notices', create_function('', "echo '<div id=\"message\" class=\"error\"><p><strong>'.__('ERROR', OPSEO_TEXT_DOMAIN).':</strong> '.__('The web server\'s connection was too slow. Go to Easy WP SEO -> Settings -> Miscellaneous Settings and set the \"Request Timeout\" setting to a higher number.', OPSEO_TEXT_DOMAIN).'</p></div>';"));
				}

				// Success
				if($result['response']['code']=='200')
				{
					// UnTexturize
					$result['body'] = $this->unTexturize($result['body']);
				}
			}

			// Reduce Whitespace (12-23-2011)
			$result['body'] = preg_replace('/\s{2,}/', ' ', trim($result['body']));


			// Include UT8 to Unicode Functions (8-25-11)
			if($this->strExists($this->options['unicode_support']))
			{

				include_once('onpageseo-utf8.php');
			}

			// Content-Type Problem Solved (10-4-2011)
			if($this->strExists($this->options['unicode_support']))
			{
				$result['body'] = preg_replace('/(<head[^>]*>)/i', '$1<meta http-equiv="content-type" content="text/html; charset=utf-8" />', $result['body']);
			}


			// Clear Previous Entries
			$this->seoReport = array();

				// HTML Entities Decode (1-11-2012)
				$result['body'] = html_entity_decode($result['body'], ENT_QUOTES, 'UTF-8');


				// Remove Stop Words (1-4-2012)
				if($this->strExists($this->options['stop_words_enabled']))
				{
					$result['body'] = $this->removeStopWords($result['body']);
				}

				// Entire HTML Document
				$strippedBody = $result['body'];

				// Replace Non-Alphanumeric Characters
				// preg_quote() Fix for RegEx escape characters (6-15-11)
				if($stripped) { $strippedBody = preg_replace('/'.preg_quote($keyword, '/').'/i', $strippedKeyword, $strippedBody); }

				// Post Content

					$unStrippedContent = '';

					// Post or Page
					if(($type == 1) && ($this->options['keyword_density_type'] == 'post'))
					{
						// Shortcode Fix (12-20-2011)
						if($this->strExists($this->options['shortcode_support']))
						{
							$currentPost->post_content = do_shortcode($currentPost->post_content);
						}

						// HTML Entities Decode (1-11-2012)
						$unStrippedContent = html_entity_decode(stripslashes($currentPost->post_content), ENT_QUOTES, 'UTF-8');

						$unStrippedContent = $this->stripTagsAddSpace($unStrippedContent);
					}
					// URL Analyzer
					else
					{
						$unStrippedContent = $this->stripTagsAddSpace($this->getURLBodyText($this->stripOtherTags(stripslashes($result['body']))));
					}

					// UTF-8 Encode (9-25-2012)
					$unStrippedContent = $this->str_encode_utf8($unStrippedContent);

					$unStrippedContent = trim(preg_replace('/\s{2,}/',' ',$unStrippedContent));

					// Remove Stop Words (1-4-2012)
					if($this->strExists($this->options['stop_words_enabled']))
					{
						$unStrippedContent = $this->removeStopWords($unStrippedContent);
					}

					// Remove Non-Letters And Numbers (1-7-2012)
					$unStrippedContent = $this->strExists($this->options['unicode_support']) ? preg_replace('/(?<=[\s\p{P}\p{S}\p{C}]|^)[^ \pL\pN]+(?=[\s\p{P}\p{S}\p{C}]|$)/uis', '', $unStrippedContent) : preg_replace('/(?<=[\s\W\D]|^)[^ \w\d]+(?=[\s\W\D]|$)/is', '', $unStrippedContent);


				// SEO Report

					// Title
					$this->seoReport['Title'] = array();
					$this->getTagContents('title', $result['body']);

					$this->seoReport['Title'] = $this->seoReport['Title'];

					// Description Meta Tag
					$this->seoReport['DescriptionMetaTag'] = array();
					$this->getMetaTagContents('description', $result['body']);

					// Keywords Meta Tag
					$this->seoReport['KeywordsMetaTag'] = array();
					$this->getMetaTagContents('keywords', $result['body']);

					// H1
					$this->seoReport['H1'] = array();
					$this->getTagContents('h1', $result['body']);

					// H2
					$this->seoReport['H2'] = array();
					$this->getTagContents('h2', $result['body']);

					// H3
					$this->seoReport['H3'] = array();
					$this->getTagContents('h3', $result['body']);

					// First and Last 100 Words

						// Post Count Number of Words (250+)
						$firstLastWords = explode(' ', trim($unStrippedContent));

						// Keyword In First 50-100 Words
						$first100words = '';

						// More Than Or Equal To 100 Words
						if(sizeof($firstLastWords) > 100)
						{
							$first100 = array();
							for($zrx = 0; $zrx < 100; $zrx++) { $first100[$zrx] = $firstLastWords[$zrx]; }
							$first100words = implode(' ', $first100);
						}
						else
						{
							$first100words = $unStrippedContent;
						}

						// First 100 Words
						$this->seoReport['First100Words'] = $first100words;

						// Keyword In Last 50-100 Words
						$last100words = '';

						// More Than Or Equal To 100 Words
						if(sizeof($firstLastWords) >= 99)
						{
							$last100wordstemp = array();
							for($arrStart = (sizeof($firstLastWords) - 99); $arrStart < sizeof($firstLastWords); $arrStart++) { $last100wordstemp[] = $firstLastWords[$arrStart]; }
							$last100words = implode(' ', $last100wordstemp);
						}
						// Less Than 100 Words
						else
						{
							$last100words = $first100words;
						}

						// Save for SEO Report

						$this->seoReport['Last100Words'] = $last100words;

						// Clear Words Array
						$firstLastWords = array();
						$first100words = '';
						$last100words = '';

			// Change Post Status
			if($postStatus != 'publish')
			{
				$this->updatePost($this->postID, 'post_status', $postStatus);
				$this->updatePost($this->postID, 'post_name', $postName);
			}
		}




	}
}
?>