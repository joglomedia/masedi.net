<?php

if (!function_exists ('is_admin'))
{
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
}
elseif (!class_exists('OnPageSEOUpdate'))
{
	class OnPageSEOUpdate
	{
		/**
		 * Instance Variables
		 */

		var $updateURL = 'http://www.easywpseo.com/update/update.txt';
		var $checkTime = 43200; // seconds
		var $updateOptionName;
		var $downloadURL;
		var $latestVersion;
		var $update = array();
		var $options;


		/**
		 * PHP 4 constructor (for backwards compatibility)
		 *
		 * @param	void
		 * @return	bool	true
		 */

		function OnPageSEOUpdate($options)
		{
			$this->__construct($options);
			return;
		}


		/**
		 * PHP 5 constructor
		 *
		 * @param	void
		 * @return	void
		 */

		function __construct($options)
		{
			// Plugin Options
			$this->options = $options;

			// Default to Current Version
			$this->latestVersion = OPSEO_VERSION;

			// Set Update Option Name
			$this->updateOptionName = OPSEO_PREFIX.'_update_check';

			// Check For An Update
			$this->lastUpdateCheck();
		}


		function getUpdateInfo($afterPluginRow=0)
		{
			// Request Update Info From External URL
			if(!class_exists('WP_Http'))
				include_once(ABSPATH.WPINC.'/class-http.php');

			$request = new WP_Http;

			// Set Timeout
			$requestArgs = array(
				'timeout'=>$this->options['request_timeout']
			);

			$result = $request->request($this->updateURL, $requestArgs);

			// Error? Die and Display Error Message
			if(is_wp_error($result))
			{
				add_action('admin_notices', create_function('', "echo '<div id=\"message\" class=\"error\"><p><strong>ERROR:</strong> The web server\'s connection was too slow. Go to Easy WP SEO -> Settings -> Miscellaneous Settings and set the \"Request Timeout\" setting to a higher number.</p></div>';"));
			}
			else
			{
				// Valid Authentication
				if($result['response']['code']=='200')
				{
					// Store Update Information
					$update = explode("\n", $result['body']);
					for($i=0; $i < sizeof($update); $i++)
					{
						list($key,$value) = explode('|||', $update[$i]);
						if(isset($key) && strlen(trim($key)) > 0) { $this->update[trim($key)] = trim($value); }
					}

					// Update Last Checked
					$this->update['last_checked'] = date('Y-m-d H:i:s');

					// Set Legacy Variables
					$this->latestVersion = $this->update['latest_version'];
					$this->downloadURL = $this->update['download_url'];

					// Update Options
					update_option($this->updateOptionName, $this->update);

					// After Plugin Row
					if($afterPluginRow && ($this->update['latest_version'] > OPSEO_VERSION))
						$this->afterPluginRow();
				}
			}
		}


		function afterPluginRow()
		{
			$display = $this->update['after_plugin_row'];

			// Plugin Name
			$display = str_replace('%plugin-name%', OPSEO_NAME, $display);

			// Latest Version
			$display = str_replace('%latest-version%', $version, $display);

			// License Email Address
			$this->downloadURL = str_replace('%email_address%', $this->options['license_email'], $this->downloadURL);

			// License Serial Number
			$this->downloadURL = str_replace('%serial_number%', $this->options['license_serial'], $this->downloadURL);

			// Download URL
			$display = str_replace('%download_url%', $this->downloadURL, $display);

			// Display Update Message
			if((isset($this->options['license_email']) && (strlen(trim($this->options['license_email'])) > 0)) && (isset($this->options['license_serial']) && (strlen(trim($this->options['license_serial'])) > 0)))
			{
				if($this->licenseHide)
				{
					echo '<tr class="plugin-update-tr"><td colspan="3" class="plugin-update"><div class="update-message">'.$display.'</td></tr>';
				}
				else
				{
					echo '<tr class="plugin-update-tr"><td colspan="3" class="plugin-update"><div class="update-message">There is a new version of Easy WP SEO available. <a href="admin.php?page=onpageseo-settings&action=upgrade"><b>Click here</b></a> to upgrade automatically.</td></tr>';
				}
			}
		}


		function lastUpdateCheck()
		{
			// Get Options
			$this->getOptions();

			// Last Update Check
			if( strtotime(date('Y-m-d H:i:s')) > (strtotime($this->update['last_checked']) + $this->checkTime) )			{

				$this->getUpdateInfo();
			}

		}



		function getOptions()
		{
			// Last Update Check
			$this->update = get_option($this->updateOptionName);

			if(!$this->update)
			{
				// Get Latest Update Information
				$this->getUpdateInfo();

				// Create New Option
				$this->update = array('last_checked'=>date('Y-m-d H:i:s'), 'latest_version'=>$this->update['latest_version'], 'download_url'=>$this->downloadURL);
				add_option($this->updateOptionName, $this->update);
			}
		}



		function getLatestVersion()
		{
			return($this->update['latest_version']);
		}


		function getDownloadURL()
		{
			$dl = $this->update['download_url'];

			// License Email Address
			$dl = str_replace('%email_address%', $this->options['license_email'], $dl);

			// License Serial Number
			$dl = str_replace('%serial_number%', $this->options['license_serial'], $dl);

			return($dl);
		}



		/**
		 * Update plugin code modified from "wordpress/wp-admin/includes/update.php"
		 *
		 * @param	string	$plugin
		 * @return	bool
		 */

		function updatePlugin($plugin)
		{
			global $wp_filesystem;

			// Check if plugin is already activated
			$is_activate = is_plugin_active($plugin);

			// Is a filesystem accessor setup? 
			if ( ! $wp_filesystem || ! is_object($wp_filesystem) ) 
				WP_Filesystem(); 

			if ( ! is_object($wp_filesystem) )
			{
				echo '<p>Could not access filesystem&#8230;</p>';
				return false;
			}

			if ( $wp_filesystem->errors->get_error_code() )
			{
				echo '<p>Filesystem error: '.$wp_filesystem->errors.'&#8230;</p>';
				return false;
			}

			// Get the package URL
			$package = $this->getDownloadURL();

			if ( empty($package) )
			{
				echo '<p>Install package not available&#8230;</p>';
				return false;
			}

			echo '<p>Downloading update from '.OPSEO_URL.'&#8230;</p>';

			// Download the package 
			$download_file = download_url($package);

			if ( is_wp_error($download_file) )
			{
				echo '<p>Download of update failed: '.$download_file->get_error_message().'</p>';
				return false;
			}

			$working_dir = WP_CONTENT_DIR . '/upgrade/' . OPSEO_PLUGIN_DIR_NAME;

			// Clean up working directory 
			if ( $wp_filesystem->is_dir($working_dir) ) 
				$wp_filesystem->delete($working_dir, true);

			echo '<p>Unpacking the update&#8230;</p>';

			// Unzip package to working directory 
			$result = $this->unzipFile($download_file, $working_dir);

			if ( is_wp_error($result) ) {
				unlink($download_file);
				$wp_filesystem->delete($working_dir, true);
				echo '<p>Error unpacking the update&#8230;</p>';
				return false;
			}

			// Once extracted, delete the package 
			unlink($download_file);

			if ( is_plugin_active($plugin) ) {
				//Deactivate the plugin silently, Prevent deactivation hooks from running.
				echo '<p>Deactivating the plugin&#8230;</p>';
				deactivate_plugins($plugin, true);
			}

			echo '<p>Removing the old version of the plugin&#8230;</p>';

			// Remove the existing plugin.
			$plugin_dir = dirname(WP_PLUGIN_DIR . "/$plugin");
			$plugin_dir = trailingslashit($plugin_dir);

			// If plugin is in its own directory, recursively delete the directory.
			$plugDir = 1;
			if ( strpos($plugin, '/') && $plugin_dir != WP_PLUGIN_DIR . '/' ) //base check on if plugin includes directory seperator AND that its not the root plugin folder
			{
				$deleted = $wp_filesystem->delete($plugin_dir, true);
			}
			else
			{
				$deleted = $wp_filesystem->delete(WP_PLUGIN_DIR . "/$plugin");
				$plugDir = 0;
			}

			if ( !$deleted ) {
				$wp_filesystem->delete($working_dir, true);
				echo '<p>Could not remove the old plugin&#8230;</p>';
				return false;
			}

			echo '<p>Installing the latest version&#8230;</p>';

			if($plugDir) {
				if ( !$wp_filesystem->is_dir(WP_PLUGIN_DIR.'/'.OPSEO_PLUGIN_DIR_NAME) )
				{
					if ( !$wp_filesystem->mkdir(WP_PLUGIN_DIR.'/'.OPSEO_PLUGIN_DIR_NAME, 0755) )
					{
						echo '<p>Could not create new plugin directory&#8230;</p>';
						return false;
					}
				}
			}

			// Copy new version of plugin into place.
			if ( !$this->copyDir($working_dir.'/'.OPSEO_PLUGIN_DIR_NAME, WP_PLUGIN_DIR.'/'.OPSEO_PLUGIN_DIR_NAME) ) {
				echo '<p>Could not copy the new plugin files&#8230;</p>';
				return false;
			}

			echo '<p>Removing the temporary update directory&#8230;</p>';

			//Get a list of the directories in the working directory before we delete it, We need to know the new folder for the plugin
			$filelist = array_keys( $wp_filesystem->dirlist($working_dir) );

			// Remove working directory
			$wp_filesystem->delete($working_dir, true);

			// No files in the working dir
			if( empty($filelist) )
				return false;

			echo '<p>Plugin upgraded successfully.</p>';

			// Reactivate the plugin
			if($is_activate)
			{
				echo '<p>Reactivating the plugin&#8230;</p>';	
				echo '<iframe style="display:none;" src="' . wp_nonce_url('plugins.php?action=activate&plugin='.OPSEO_PLUGIN_PATH.'&plugin_status=all&paged=1','activate-plugin_' . OPSEO_PLUGIN_PATH).'"></iframe>';
				echo '<p>Plugin reactivated successfully.</p>';	
			}

			echo '<p><strong>Actions:</strong> <a href="plugins.php" title="Goto plugins page" target="_parent">Return to Plugins page</a></p>';

			return true;
		}



		/**
		 * Unzip file code modified from "wordpress/wp-admin/includes/file.php"
		 *
		 * @param	$file	string
		 * @param	$to	string
		 * @return	bool
		 */

		function unzipFile($file, $to)
		{
			global $wp_filesystem;

			if ( ! $wp_filesystem || !is_object($wp_filesystem) )
			{
				echo '<p>Could not access filesysystem&#8230;</p>';
				return false;
			}

			$fs =& $wp_filesystem;

			require_once(ABSPATH . 'wp-admin/includes/class-pclzip.php');

			$archive = new PclZip($file);

			// Is the archive valid?
			if ( false == ($archive_files = $archive->extract(PCLZIP_OPT_EXTRACT_AS_STRING)) )
			{
				echo '<p>Incompatible archive: '.$archive->errorInfo(true).'&#8230;</p>';
				return false;
			}

			if ( 0 == count($archive_files) )
				wp_die('empty_archive', __('Empty archive'));

			$to = trailingslashit($to);
			$path = explode('/', $to);
			$tmppath = '';
			for ( $j = 0; $j < count($path) - 1; $j++ ) {
				$tmppath .= $path[$j] . '/';
				if ( ! $fs->is_dir($tmppath) )
					$fs->mkdir($tmppath, 0755);
			}

			foreach ($archive_files as $file) {
				$path = explode('/', $file['filename']);
				$tmppath = '';

				// Loop through each of the items and check that the folder exists.
				for ( $j = 0; $j < count($path) - 1; $j++ ) {
					$tmppath .= $path[$j] . '/';
					if ( ! $fs->is_dir($to . $tmppath) )
					{
						if ( !$fs->mkdir($to . $tmppath, 0755) )
						{
							echo '<p>Could not create directory&#8230;</p>';
							return false;
						}
					}
				}

				// We've made sure the folders are there, so let's extract the file now:
				if ( ! $file['folder'] )
				{
					if ( !$fs->put_contents( $to . $file['filename'], $file['content']) )
					{
						echo '<p>Could not copy file&#8230;</p>';
						return false;
					}

					$fs->chmod($to . $file['filename'], 0644);
				}
			}

			return true;
		}



		/**
		 * Copy directory code modified from "wordpress/wp-admin/includes/file.php"
		 *
		 * @param	$from	string
		 * @param	$to	string
		 * @return	bool
		 */

		function copyDir($from, $to)
		{
			global $wp_filesystem;

			$dirlist = $wp_filesystem->dirlist($from);

			$from = trailingslashit($from);
			$to = trailingslashit($to);

			foreach ( (array) $dirlist as $filename => $fileinfo ) {
				if ( 'f' == $fileinfo['type'] ) {
					if ( ! $wp_filesystem->copy($from . $filename, $to . $filename, true) )
						return false;
					$wp_filesystem->chmod($to . $filename, 0644);
				} elseif ( 'd' == $fileinfo['type'] ) {
					if ( !$wp_filesystem->mkdir($to . $filename, 0755) )
						return false;
					$result = $this->copyDir($from . $filename, $to . $filename);
					if ( is_wp_error($result) )
						return $result;
				}
			}

			return true;
		}
	}

}

?>