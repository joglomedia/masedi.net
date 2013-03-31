<?php

if (!function_exists ('is_admin'))
{
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
}
elseif (!class_exists('OnPageSEOClient'))
{
	class OnPageSEOClient
	{
		// Instance Variables
		var $options = array();

		// PHP 4 Constructor (For Backwards Compatibility)
		function OnPageSEOClient($options)
		{
			$this->__construct($options);
			return;
		}

		// PHP 5 Constructor
		function __construct($options)
		{
			// Plugin Settings
			$this->options = $options;

			// Include Automatic Decoration Class
			include('onpageseo-client-decoration.php');
			$decoration = new OnPageSEOClientDecoration($this->options);

			// Content Filter
			add_filter('the_content', array($decoration, 'contentHandler'));
		}
	}
}
?>