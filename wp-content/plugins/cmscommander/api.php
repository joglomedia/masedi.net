<?php
/*************************************************************
 * 
 * api.php
 * 
 * CMS Commander addons api
 * 
 * Copyright (c) 2011 Prelovac Media
 * www.prelovac.com
 **************************************************************/
if( !function_exists('cmsc_add_action')) :
	function cmsc_add_action($action = false, $callback = false)
	{
		if (!$action || !$callback)
			return false;
		
		global $cmsc_actions;
		cmsc_function_exists($callback);
		
		if (isset($cmsc_actions[$action]))
			wp_die('Cannot redeclare CMS Commander action "' . $action . '".');
		
		$cmsc_actions[$action] = $callback;
	}
endif;

if( !function_exists('cmsc_function_exists') ) :
	function cmsc_function_exists($callback)
	{
		global $cmsc_core;
		if (count($callback) === 2) {
			if (!method_exists($callback[0], $callback[1]))
				wp_die($cmsc_core->cmsc_dashboard_widget('Information', '', '<p>Class ' . get_class($callback[0]) . ' does not contain <b>"' . $callback[1] . '"</b> function</p>', '', '50%'));
		} else {
			if (!function_exists($callback))
				wp_die($cmsc_core->cmsc_dashboard_widget('Information', '', '<p>Function <b>"' . $callback . '"</b> does not exists.</p>', '', '50%'));
		}
	}
endif;

?>
