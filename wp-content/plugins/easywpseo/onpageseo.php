<?php
/*
 Plugin Name: Easy WP SEO
 Plugin URI: http://www.easywpseo.com
 Description: Just push a button, and Easy WP SEO analyzes your post, page, or custom post type for 23 proven on-page SEO factors. It displays an SEO and keyword density score that reveals how well your content is optimized for the search engines, and provides you with a detailed checklist of suggested SEO tweaks.
 Version: 1.7.2
 Author: Chris Landrum
 Author URI: http://www.easywpseo.com
 */

if (!function_exists ('is_admin'))
{
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
}
else
{
	// Minimum Requirements
	$opseoError = 0;

	// Requires PHP 5.0+
	if (version_compare(PHP_VERSION, '5.0.0', '<'))
	{
		require_once(ABSPATH.'wp-admin/includes/plugin.php');

		// Deactivate Plugin
		if(function_exists('deactivate_plugins'))
		{
			deactivate_plugins(plugin_basename(__FILE__), true);
		}

		// Display Error Message
		add_action('admin_notices', create_function('', "echo '<div id=\"message\" class=\"error\"><p><strong>ERROR:</strong> Easy WP SEO requires PHP 5.0 or newer. Your version is '.phpversion().'. Please, ask your web host to upgrade to PHP 5.0.</p></div>';"));
		$opseoError = 1;
	}

	// Requires Wordpress 3.0+
	global $wp_version;
	if (version_compare( $wp_version, '3.0', '<' ))
	{
		require_once(ABSPATH.'wp-admin/includes/plugin.php');

		// Deactivate Plugin
		if(function_exists('deactivate_plugins'))
		{
			deactivate_plugins(plugin_basename(__FILE__), true);
		}

		// Display Error Message
		add_action('admin_notices', create_function('', "echo '<div id=\"message\" class=\"error\"><p><strong>ERROR:</strong> Easy WP SEO requires Wordpress 3.0 or newer. Your version is $wp_version. Please, upgrade to the latest version of Wordpress.</p></div>';"));
		$opseoError = 1;
	}

	// Requires DomDocument
	if (!class_exists('DomDocument'))
	{
		require_once(ABSPATH.'wp-admin/includes/plugin.php');

		// Deactivate Plugin
		if(function_exists('deactivate_plugins'))
		{
			deactivate_plugins(plugin_basename(__FILE__), true);
		}

		// Display Error Message
		add_action('admin_notices', create_function('', "echo '<div id=\"message\" class=\"error\"><p><strong>ERROR:</strong> Easy WP SEO requires the PHP class DomDocument to analyze the content on your site. Please, contact your web hosting provider and request the installation of DomDocument and DomXPath on the server.</p></div>';"));
		$opseoError = 1;
	}


	// Requires Multi-Byte String Functions
	if(!function_exists('mb_strtolower') || !function_exists('mb_convert_encoding') || !function_exists('mb_strlen'))
	{
		require_once(ABSPATH.'wp-admin/includes/plugin.php');

		// Deactivate Plugin
		if(function_exists('deactivate_plugins'))
		{
			deactivate_plugins(plugin_basename(__FILE__), true);
		}

		// Display Error Message
		add_action('admin_notices', create_function('', "echo '<div id=\"message\" class=\"error\"><p><strong>ERROR:</strong> Easy WP SEO requires the PHP multi-byte string functions to analyze the content on your site. Please, contact your web hosting provider and request the installation of the mb functions on the server.</p></div>';"));
		$opseoError = 1;
	}



	// Requires JSON_Encode (PHP >= 5.2)
	if (!function_exists('json_encode'))
	{
		function json_encode($data)
		{
			switch ($type = gettype($data))
			{
				case 'NULL':
					return 'null';
				case 'boolean':
					return ($data ? 'true' : 'false');
				case 'integer':
				case 'double':
				case 'float':
					return $data;
				case 'string':
					return '"' . addslashes($data) . '"';
				case 'object':
					$data = get_object_vars($data);
				case 'array':
					$output_index_count = 0;
					$output_indexed = array();
					$output_associative = array();
					foreach ($data as $key => $value)
					{
						$output_indexed[] = json_encode($value);
						$output_associative[] = json_encode($key) . ':' . json_encode($value);
						if ($output_index_count !== NULL && $output_index_count++ !== $key)
						{
							$output_index_count = NULL;
						}
					}
					if ($output_index_count !== NULL)
					{
						return '[' . implode(',', $output_indexed) . ']';
					}
					else
					{
						return '{' . implode(',', $output_associative) . '}';
					}
				default:
					return ''; // Not supported
			}
		}
	}

	if(!$opseoError)
	{
		global $blog_id;
		$opseoUploadDir = wp_upload_dir();

		// Constants
		define('OPSEO_NAME', 'Easy WP SEO');
		define('OPSEO_VERSION', '1.7.2');
		define('OPSEO_URL', 'http://www.easywpseo.com');
		define('OPSEO_PREFIX', 'onpageseo');
		define('OPSEO_TEXT_DOMAIN', 'easywpseo');
		define('OPSEO_SITE_URL', get_bloginfo('wpurl'));
		define('OPSEO_WP_ADMIN_URL', trailingslashit(OPSEO_SITE_URL).'wp-admin');
		define('OPSEO_PLUGIN_FULL_PATH', plugin_dir_path(__FILE__));
		define('OPSEO_PLUGIN_PATH', plugin_basename(__FILE__));
		define('OPSEO_PLUGIN_DIR_NAME', dirname(OPSEO_PLUGIN_PATH));
		define('OPSEO_POST_META_DATA', 'onpageseo_post_meta_data');
		define('OPSEO_PLUGIN_URL', plugins_url('', __FILE__));
		define('OPSEO_UPLOAD_PATH', $opseoUploadDir['basedir']);
		define('OPSEO_UPLOAD_URL', $opseoUploadDir['baseurl']);
		define('OPSEO_CACHE_PATH', trailingslashit(OPSEO_UPLOAD_PATH).OPSEO_PREFIX.'/'.$blog_id);
		define('OPSEO_CACHE_URL', trailingslashit(OPSEO_UPLOAD_URL).OPSEO_PREFIX.'/'.$blog_id);

		// Administrative
		if(is_admin())
		{
			$opseoArgs = array();

			// Include Admin Class
			require_once('onpageseo-admin.php');

			// Initialize New Object
			$onPageSEO = new onPageSEOAdmin($opseoArgs);
		}
		// Client
		else
		{
			// Get Plugin Settings
			$opseoOptions = get_option('onpageseo_options');

			if(is_array($opseoOptions) && isset($opseoOptions['decoration_type']) && $opseoOptions['decoration_type'] == 'client')
			{
				// Include Client Class
				require_once('onpageseo-client.php');

				// Initialize Client Object
				$client = new OnPageSEOClient($opseoOptions);
			}
		}
	}
}
?>