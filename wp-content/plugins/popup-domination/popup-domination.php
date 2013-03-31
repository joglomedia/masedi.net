<?php

/*
Plugin Name: PopUp Domination 
Author: PopUp Domination Team
Version: 3.3.5.2
Author URI: http://www.popupdomination.com
Description: The Ultimate plugin to increase your list size. Make more money by using our beautiful themes and specific functionality to grow your subscriber list by over 500%. 
*/

class PopUp_Domination {
	
	/**
	* Setting up all objects needed throughout the classes. 
	*/
	
	var $base_name = '';
	var $menu_url = '';
	var $theme_path = '';
	var $theme_url = '';
	var $plugin_url = '';
	var $plugin_path = '';
	var $opts_url = '';
	var $install_url = '';
	var $currentcss = '';
	var $newcampid = '';
	var $wpadmin_page = '';
	var $themes = array();
	var $natypes = array('.original.php','.original.htm','.original.html','.original.css','.original.txt');
	var $atypes = array('.php','.htm','.html','.css','.txt');
	var $is_preview = false;
	var $version = '3.3.5.2';
	var $custominputs = 0;
	var $submenu = array();
	var $curpage = array();
	var $campaigns = array();
	var $campaigndata = array();
	var $abcamp = array();
	var $update_msg = '';
	var $success = false;
	var $facebook = '';
	var $user = '';
	var $TMP = '';
	
	/**
	* PopUp_Domination();
	*
	* The Daddy function in the plugin. ALL Main funcitonailty (hooks, filters, Ajax Hooks ect) all get registered here. 
	* This function is fired as soon as the plugin is turned on and fired after ever function Wordpress does.
	*/
	
	function PopUp_Domination(){
		/**
		* More objects being set.
		*/
		$this->base_name = plugin_basename(__FILE__);
		$this->menu_url = dirname(plugin_basename(__FILE__)).'/';
		$this->plugin_url = WP_PLUGIN_URL.'/'.dirname($this->base_name).'/';
		$this->plugin_path = WP_PLUGIN_DIR.'/'.dirname($this->base_name).'/';
		$this->theme_url = $this->plugin_url.'themes/';
		$this->theme_path = $this->plugin_path.'themes/';
		define('POPUP_DOM_PATH',$this->plugin_path);
		$checkifpopdom = 0;
		
		/*
		add_action('init', 'popup_domination_dashboard_widget');*/
		//Hook into the 'wp_dashboard_setup' action to register our other functions
		
		
		/**
		* Check if license already checked.
		*/
		$check = $this->option('v3installed');
		if(isset($check) && $check == 'Y'){
			$this->update('installed', 'Y');
		}
		/**
		* For backing up themes after user logs in.
		*/
		add_action('wp_login', array(&$this, 'login_move'));
		add_action('init', array(&$this, 'facebook'));
		
		$protocol = ($_SERVER['HTTPS']=='on') ?'https':'http';
		$port = ($_SERVER['SERVER_PORT'] == '80')? '' : ':'.$_SERVER['SERVER_PORT'];
		$base = $protocol. '://' . $_SERVER['HTTP_HOST'] . $port . $_SERVER['REQUEST_URI'];
		
		
		if(function_exists("admin_url"))
			$url = admin_url("admin.php?page=" .  $this->base_name);
		else
			$url = "admin.php?page=" .  $this->base_name;
			
		$install = $base;
		$this->opts_url = $url;
		$this->install_url = $install;
		$this->install_fin =  "admin.php?page=popup-domination/campaigns";
		if(is_admin()){
			/**
			* Encoded plugin Updater functionality. 
			* Don't change unless update JSON location is ever moved.
			*/
			require 'plugin-update-checker.php';
			//http//popupdomination.com/update/update.json
			//
			$hfscmxvsri="\x45\x78\x61m\x70\x6c\x65Upda\x74e\x43\x68\x65\x63\x6b\x65\x72";${$hfscmxvsri}=new PluginUpdateChecker("htt\x70://\x70op\x75pdo\x6din\x61t\x69\x6fn\x2ecom\x2fupda\x74e/\x75\x70d\x61te\x2ejs\x6f\x6e",__FILE__,"\x70\x6f\x70up\x2d\x64om\x69na\x74i\x6f\x6e",0.01,"p\x6fpu\x70\x5fdo\x6dina\x74io\x6e\x5f\x75\x70\x64\x61te\x69nf\x6f");
			if(isset($_GET['page'])){
				$wpadmin_page = $_GET['page'];
				$checkifpopdom = strpos($wpadmin_page,'domination/');
			}
			/**
			* Register all Stylesheets if the user is navigating to plugin's admin pages.
			*/		
			if(!empty($checkifpopdom) && $checkifpopdom > 0){
				wp_register_style('popup-domination-page', $this->plugin_url.'css/page.css');
				wp_register_style('popup-domination-campaigns', $this->plugin_url.'css/campaigns.css');
				wp_register_style('popup-domination-anayltics', $this->plugin_url.'css/analytics.css');
				wp_register_style('popup-domination-ab', $this->plugin_url.'css/ab.css');
				wp_register_style('popup-domination-mailing', $this->plugin_url.'css/mailing.css');
				wp_register_style('popup-domination-promote', $this->plugin_url.'css/promote.css');
				wp_register_style('popup-domination-support', $this->plugin_url.'css/support.css' );
				wp_register_style('fancybox', $this->plugin_url.'js/fancybox/jquery.fancybox-1.3.4.css' );
				wp_register_style('fileuploader', $this->plugin_url.'css/fileuploader.css' );
				wp_register_style('the_graphs', $this->plugin_url.'css/graph.css');
			}
			add_action('admin_menu', array(&$this, 'admin_menu'));
			add_filter('plugin_action_links', array(&$this, 'plugin_action_links'), 10, 2);
					
		}
		/**
		* If plugin installed an verified as 3.0.
		*/
		if($ins = $this->option('v3installed')){
			if(is_admin()){
				add_action('wp_dashboard_setup', array(&$this, 'popup_domination_dashboard_widget') );
				/**
				* Check if update info is in DB. If running newest version, move themes from backup folder. (See login_move() for break down)
				*/
				$current_plugin_version_tmp = $this->get_db('options','option_name = "popup_domination_updateinfo"', 'option_value');
				if(isset($current_plugin_version_tmp[0]->option_value) && !empty($current_plugin_version_tmp[0]->option_value)){
					$current_plugin_version = unserialize($current_plugin_version_tmp[0]->option_value);
					$version_check = $this->fixclass('stdClass',$current_plugin_version->update);
					if($this->version >= $version_check->version){
						
						if($this->dir_is_empty(WP_PLUGIN_DIR.'/popdom-themes-backup/') != NULL || file_exists(WP_PLUGIN_DIR.'/popdom-themes-backup/')){
							$this->theme_backup('Y');
							$this->update("updateinfo", "");
						}
					}
				}
				/**
				* Admin Ajax Functions.
				*/
				add_action('wp_ajax_popup_domination_file_upload', array(&$this, 'upload_file'));
				add_action('wp_ajax_popup_domination_upload_theme', array(&$this, 'upload_theme'));
				add_action('wp_ajax_popup_domination_activation', array(&$this, 'activate'));
				add_action('wp_ajax_popup_domination_clear_cookie', array(&$this, 'clear_cookie'));
				add_action('wp_ajax_popup_domination_aweber_cookies', array(&$this, 'aweber_cookies_clear'));
				add_action('wp_ajax_popup_domination_preview', array(&$this, 'preview'));
				add_action('wp_ajax_popup_domination_mailing_client', array(&$this, 'get_mailing_list'));
				add_action('wp_print_scripts', array(&$this, 'wp_print_scripts'));
				add_action('wp_ajax_popup_domination_delete_camp', array(&$this, 'deletecamp'));
				add_action('wp_ajax_popup_domination_check_name', array(&$this, 'check_camp_name'));
			} else {
				add_action('wp_enqueue_scripts', array(&$this, 'wp_print_scripts'));
				add_action('wp_print_styles', array(&$this, 'wp_print_styles'));
			}
			/**
			* Front-End Ajax Functions.
			*/
			add_action('wp_ajax_nopriv_popup_domination_lightbox_submit', array(&$this, 'lightbox_submit'));
			add_action('wp_ajax_popup_domination_lightbox_submit', array(&$this, 'lightbox_submit'));
			add_action('wp_ajax_nopriv_popup_domination_ab_split', array(&$this, 'lightbox_split_db'));
			add_action('wp_ajax_popup_domination_ab_split', array(&$this, 'lightbox_split_db'));
			add_action('wp_ajax_nopriv_popup_domination_analytics_add', array(&$this, 'analytics_add'));
			add_action('wp_ajax_popup_domination_analytics_add', array(&$this, 'analytics_add'));
		}else{
			/**
			* Functions for non-verfied stages.
			*/
			$url = "admin.php?page=" .  $this->base_name;
			$install = "admin.php?page=popup-domination/install";
			add_action('admin_menu', array(&$this, 'install_menu'));
		}
	}
	
	// Create the function use in the action hook
	function popup_domination_dashboard_widget() {
		wp_add_dashboard_widget('popup_domination_dashboard_widget', 'PopUp Domination', array(&$this, 'popup_domination_dashboard_function'));
		$this->place_at_top();
	}
	
	
	// Create the function to output the contents of our Dashboard Widget
	function popup_domination_dashboard_function() {
		$rss = new DOMDocument();
		$rss->load('http://www.popupdomination.com/blog/feed/');
		$feed = array();
		foreach ($rss->getElementsByTagName('item') as $node) {
			$item = array ( 
				'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
				'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
				'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
				'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
				);
			array_push($feed, $item);
		}
		$limit = 5;
		for($x=0;$x<$limit;$x++) {
			$title = str_replace(' & ', ' &amp; ', $feed[$x]['title']);
			$link = $feed[$x]['link'];
			$description = $feed[$x]['desc'];
			$date = date('l F d, Y', strtotime($feed[$x]['date']));
			echo '<p><strong><a href="'.$link.'" title="'.$title.'">'.$title.'</a></strong><br />';
			echo '<small><em>Posted on '.$date.'</em></small></p>';
			echo '<p>'.$description.'</p>';
		}
		
	}
	
	
	
	
	function place_at_top(){
		global $wp_meta_boxes;
		
		// Get the regular dashboard widgets array 
		// (which has our new widget already but at the end)
		$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];
		
		// Backup and delete our new dashbaord widget from the end of the array
		$example_widget_backup = array('popup_domination_dashboard_widget' => $normal_dashboard['popup_domination_dashboard_widget']);
		unset($normal_dashboard['popup_domination_dashboard_widget']);
	
		// Merge the two arrays together so our widget is at the beginning
		$sorted_dashboard = array_merge($example_widget_backup, $normal_dashboard);
	
		// Save the sorted array back into the original metaboxes
		$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
	}
	


	
	
	
	
	function facebook(){
		if($this->option('facebook_enabled', false) == 'Y'){
			require $this->plugin_path.'inc/facebook/facebook.php';
			$this->facebook = new Facebook(array(
			  'appId'  => $this->option('facebook_id', false),
			  'secret' => $this->option('facebook_sec', false),
			  'cookie' => true,
			));
		}
	}
	
	/**
	* login_move();
	* 
	* Backs up and moves themes from outsite PopDom folder. 
	* Updates overwrites themes, basic work around as no support from WP.
	*/
	
	function login_move(){
		$current_plugin_version_tmp = $this->get_db('options','option_name = "popup_domination_updateinfo"', 'option_value');
		if(isset($current_plugin_version_tmp[0]->option_value) && !empty($current_plugin_version_tmp[0]->option_value)){
			$current_plugin_version = unserialize($current_plugin_version_tmp[0]->option_value);
			$version_check = $this->fixclass('stdClass',$current_plugin_version->update);
			if($this->version >= $version_check->version){
				if($this->dir_is_empty(WP_PLUGIN_DIR.'/popdom-themes-backup/') != NULL || file_exists(WP_PLUGIN_DIR.'/popdom-themes-backup/')){
					$this->theme_backup('Y');
					$this->update("updateinfo", "");
				}
			}else{
				$this->theme_backup();
			}
		}else{
			$this->theme_backup();
		}
	}
	
	/**
	* dir_is_empty();
	* 
	* Ronseal (Does exactly what is says on the tin). Used for theme backup.
	*/
	
	function dir_is_empty($dir) {
 		if (!is_readable($dir)) return NULL;
 		return (count(scandir($dir)) == 2);
	}

	/**
	* dir_is_empty();
	* 
	* Backs up and moves themes. Used in conjuction with login_move() & PopUp_Domination().
	*/
	
	function theme_backup($move = NULL){
		$source = $this->plugin_path.'themes';
		$destination = WP_PLUGIN_DIR.'/';
		
		if (!file_exists($destination.'popdom-themes-backup')) {
	       $createfolder =  mkdir($destination.'popdom-themes-backup', 0777);
	    }else{
	       $createfolder = true;
	    }
		if($createfolder){
			if($move == NULL){
				$this->full_copy($source, $destination.'popdom-themes-backup');
			}else{
				$this->full_copy($destination.'popdom-themes-backup', $source.'/');
				//$this->deleteDir($destination.'popdom-themes-backup');
			}
		}
	}
	
	/**
	* fixclass();
	* 
	* $current_plugin_version->version comes back as a broken class.
	* This baby fixes that for use in the login_move(). 
	*/
	
	function fixclass($class, $object){
  		return unserialize(preg_replace('/^O:\d+:"[^"]++"/', 'O:' . strlen($class) . ':"' . $class . '"', serialize($object)));
	}

	/**
	* deleteDir();
	* 
	* Ronseal. 
	*/
	
	function deleteDir($path){
		$this_func = array($this, __FUNCTION__);
    	return is_file($path) ?
            @unlink($path) :
            array_map($this_func, glob($path.'/*')) == @rmdir($path);
	}
	
	/**
	* full_copy();
	* 
	* Copies a directory and all files in it.
	* Used for theme backup. 
	*/
	
	function full_copy( $source, $target ) {
		if ( is_dir( $source ) ) {
			@mkdir( $target );
			$d = dir( $source );
			while ( FALSE !== ( $entry = $d->read() ) ) {
				if ( $entry == '.' || $entry == '..' ) {
					continue;
				}
				$Entry = $source . '/' . $entry; 
				if ( is_dir( $Entry ) ) {
					$this->full_copy( $Entry, $target . '/' . $entry );
					continue;
				}
				copy( $Entry, $target . '/' . $entry );
			}
	 
			$d->close();
		}else {
			copy( $source, $target );
		}
	}
	
	/**
	* aweber_cookies_clear()
	*
	* Used to clear cookies the aweber api needs to connect to accounts.
	* Fixes error when using aweber api.
	*/
	
	function aweber_cookies_clear(){
		if(wp_verify_nonce($_POST['wpnonce'], 'update-options')){
			setcookie('accessToken','',time()-60*60*24*100,'/'.$_POST['wpurl'].'inc/');
			setcookie('accessTokenSecret','',time()-60*60*24*100,'/'.$_POST['wpurl'].'inc/');
			setcookie('awTokenSecret','',time()-60*60*24*100,'/');
			setcookie('awToken','',time()-60*60*24*100,'/');
			setcookie('aw_getlists','',time()-60*60*24*100,'/');
			$this->update('formapi', '', false);
		}else{
			echo '{"error":"Verification failed, please refresh the page and try again."}';
		}
		exit;
	}
	
	/**
	* clear_cookie()
	*
	* Clears the cookies stopping the PopUp from appearing.
	*/
	
	function clear_cookie(){
		if(wp_verify_nonce($_GET['_wpnonce'], 'update-options')){
			if($_GET['id'] == 0){
				$id = 'zero';
			}else if($_GET['id'] == 1){
				$id = 'one';
			}else if($_GET['id'] == 3){
				$id = 'three';
			}else if($_GET['id'] == 4){
				$id = 'four';
			}else{
				$id = $_GET['id'];
			}
			setcookie('popup_domination_hide_lightbox'.$id,'',time()-60*60*24*100,COOKIEPATH);
			echo '{"done":"done"}';
		} else {
			echo '{"error":"Verification failed, please refresh the page and try again."}';
		}
		exit;
	}
	
	/**
	* lastday()
	*
	* Works out if it's the last day of the month.
	* Used in Conjuction with analytics_add().
	*/
	
	function lastday($month = '', $year = '') {
	   if (empty($month)) {
	      $month = date('m');
	   }
	   if (empty($year)) {
	      $year = date('Y');
	   }
	   $result = strtotime("{$year}-{$month}-01");
	   $result = strtotime('-1 second', strtotime('+1 month', $result));
	   return date('d-m-Y', $result);
	}
	
	/**
	* analytics_add()
	*
	* Adds analytic data for a PopUp into the DB.
	* Trigger through the Ajax in PopUp_Domination().
	*/
	
	function analytics_add(){
		if (!is_numeric($_POST['popupid'])) {
			exit('Illegal operation. Exiting.');
		}
		$new = false;
		$sentdata = $_POST;
		$campname = $this->get_db('popdom_campaigns', 'id = '.$sentdata['popupid']);
		$datasplit = $this->get_db('popdom_analytics', 'campname = "'.$campname[0]->campaign.'"');
		if(!empty($datasplit)){
			$datasplit = get_object_vars($datasplit[0]);
		}
		/**
		* Works out if data already in DB or not.
		*/
		if(empty($datasplit)){
			$new = true;
			$analytic = array('campname' => $campname[0]->campaign, $sentdata['popupid'] => array('views' => 0, 'conversions'=> 0));
		}else{
			/**
			* If data already there, works out if last day and should be stored and then creates array for handling.
			*/
			$analytic = $datasplit;
			$date = $this->lastday();
			if(date('d-m-Y') == $date){
				$prevdata = $analytic['previousdata'];
				if(!isset($prevdata[date('m')])){
					$data = array(date('m') => array('views' => $analytic['views'], 'conversions' => $analytic['conversions']));
					if(count($data) > 5){
						array_shift($data);
					}
					$data = serialize($data);
					$update = $this->write_db('popdom_analytics',array('previousdata'=> $data), array('%s'), 'true',array('campname' => $campname[0]->campaign), array('%s'));
					unset($analytic);
					$analytic = array('campname' => $campname[0]->campaign, $sentdata['popupid'] => array('views' => 0, 'conversions'=> 0));
				}
			}
		}
		
		
		/**
		* Does all the writing to the DB.
		*/
		if($sentdata['stage'] == 'opt-in'){
			$analytic['conversions'] = $analytic['conversions'] + 1;
			if($new){
				echo $update = $this->write_db('popdom_analytics',array('conversions'=> $analytic['conversions'], 'campname' => $campname[0]->campaign),array('%s','%s'));
			}else{
				$update = $this->write_db('popdom_analytics',array('conversions'=> $analytic['conversions']),array('%s'), 'true',array('campname' => $campname[0]->campaign), array('%s'));
			}
		}else{
			$analytic['views'] = $analytic['views'] + 1;
			if($new == '1'){
				$update = $this->write_db('popdom_analytics',array('views'=> $analytic['views'], 'campname' => $campname[0]->campaign),array('%s','%s'));
			}else{
				$update = $this->write_db('popdom_analytics',array('views'=> $analytic['views']),array('%s'), 'true',array('campname' => $campname[0]->campaign), array('%s'));
			}
		}
		die();
	}
		
	
	/**
	* generate_js()
	*
	* returns all the data and produces this on the web page.
	*/
	
	function generate_js($delay,$center,$cookie_time,$opts=array(),$show_opt,$unload_msg,$icount=0,$redirect){
		$js = '';
		if(count($opts) > 0){
			foreach($opts as $o){
				if(!empty($o['default']) && !empty($o['class'])){
				$js .= (($js=='')?'':',').'".'.$o['class'].'":"'.$this->input_val($o['default']).'"';
				}
			}
		}
		return 'var popup_domination_defaults = {'.$js.'}, delay = '.floatval($delay).', popup_domination_cookie_time = '.floatval($cookie_time).', popup_domination_center = \''.$center.'\', popup_domination_cookie_path = \''.$this->cookie_path.'\', popup_domination_show_opt = \''.$show_opt.'\', popup_domination_unload_msg = \''.$this->input_val($unload_msg).'\', popup_domination_impression_count = '.intval($icount).', popup_domination_redirect = \''.$redirect.'\' ;
		';
	}



	
	/**
	* lightbox_split_db()
	*
	* Sorts out the analytics data for the A/B Split Testing.
	* Trigger through the Ajax in PopUp_Domination().
	*/
	
	function lightbox_split_db(){
		if (!is_numeric($_POST['popupid']) || !is_numeric($_POST['camp'])) {
			exit('Illegal operation. Exiting.');
		}
		$sentdata = $_POST;
		$datasplit = $this->get_db('popdom_ab', 'id = '.$sentdata['camp'], 'astats');
		$current = array();
		$current = $datasplit[0]->astats;
		if(empty($current['popupid'])){
			$current[$sentdata['popupid']] = array( date('m') => array('optin' => '', 'show'=> ''));
		}else{
			$current = unserialize($current);
		}
		if(array_key_exists($sentdata['popupid'],$current)){
			if($sentdata['stage'] == 'opt-in'){
				$current[$sentdata['popupid']][date('m')]['optin'] = $current[$sentdata['popupid']][date('m')]['optin'] + 1;
			} else if ($sentdata['stage'] == 'show'){
				$current[$sentdata['popupid']][date('m')]['show'] = $current[$sentdata['popupid']][date('m')]['show'] + 1;
			}
		}else{
			$current[$sentdata['popupid']] = array(date('m') => array('optin' => '', 'show'=> ''));
			if($sentdata['stage'] == 'opt-in'){
				$current[$sentdata['popupid']][date('m')]['optin'] = 1;
			} else if ($sentdata['stage'] == 'show'){
				$current[$sentdata['popupid']][date('m')]['show'] = 1;
			}
		}
		$popup = serialize($current);
		$update = $this->write_db('popdom_ab',array('astats'=> $popup),array('%s'), 'true',array('id' => $sentdata['camp']), array('%s'));
		die();
	}
	
	/**
	* get_db()
	*
	* Generic database retreval code, used all over the shop to grab data from the main 3 PopDom tables.
	*/
	
	function get_db($from,$where = NULL,$select = NULL,$single = NULL,$and = NULL,$array = NULL){
		global $wpdb;
		if($where != NULL){
			$where = 'WHERE '.$where;
		}else{
			$where = '';
		}
		if($and != NULL){
			$and = 'AND WHERE '.$and;
		}else{
			$and = '';
		}
		if($select == NULL){
			$select = '*';
			$results = $wpdb->get_results("SELECT $select FROM `{$wpdb->prefix}$from` $where $and");
		}else{
			if($array == NULL){
				$results = $wpdb->get_results($wpdb->prepare("SELECT $select FROM `{$wpdb->prefix}$from` $where $and", $array));
			}else{
				echo 'Setup is wrong, check function';
			}
		}
		return $results;
	}
	
	/**
	* write_db()
	*
	* Generic database write code, used all over the shop to write data to the main 3 PopDom tables.
	*/
	
	function write_db($table, $values = NULL, $array = NULL, $update = NULL, $where = NULL, $wherearray = NULL){
		global $wpdb;
		$table = $wpdb->prefix.$table;
		
		
		//code used to convert previous older version of PopUp Domination to use foreign characters - REMOVE at some point
		$sql = "alter table " . $table . " CONVERT TO CHARACTER SET utf8";
		$wpdb->query($sql);

		if($update == NULL){
			$results = $wpdb->insert( $table, $values, $array);
			$this->newcampid = $wpdb->insert_id;
		}else{
			$results = $wpdb->update( $table, $values, $where, $array, $wherearray);
		}
		return $results;
	}
	
	/**
	* delete_db()
	*
	* Generic database delete code, used all over the shop to delete data to the main 3 PopDom tables.
	*/
	
	function delete_db($table, $rowid, $column = NULL){
		global $wpdb;
		$table = $wpdb->prefix.$table;
		if(isset($column) && $column != NULL){
			$results = $wpdb->query($wpdb->prepare("DELETE FROM $table WHERE $column = %s", $rowid));
		}else{
			$results = $wpdb->query($wpdb->prepare("DELETE FROM $table WHERE id = %d", $rowid));
		}
		return $results;
	}
	
	/**
	* wp_print_scripts()
	*
	* Enqueues all javascript scripts on front end and admin end.
	* Checks if user is "in" PopDom admin panels before registering admin scripts.
	*/
	
	function wp_print_scripts(){
		global $pagenow;
		global $plugin_page;
		
		if(is_admin()){
			$this->wpadmin_page = $_GET['page'];
			$checkifpopdom = strpos($this->wpadmin_page,'popup-domination/');
			if(isset($plugin_page) && $checkifpopdom > -1){
				wp_enqueue_script('popup_domination_placeholder_support',$this->plugin_url.'js/placeholder.jquery.js',array('jquery'),'3.0');
				wp_enqueue_script('popup_domination',$this->plugin_url.'js/page.js',array('jquery', 'popup_domination_placeholder_support'),'3.0');
				
				//wp_enqueue_script('popup_dominaton_master_jquery',$this->plugin_url.'js/master.js',array('jquery'),'3.0');
				
				if(strstr($this->wpadmin_page,'mailinglist')){
					//scripts have been separated simply to aid development and clean up the mess that was made
					wp_enqueue_script('popup_domination_mailing',$this->plugin_url.'js/mailing.js',array('jquery'),'3.0');
					
					
					wp_enqueue_script('thickbox-js', $this->plugin_url.'js/fancybox/jquery.fancybox-1.3.4.pack.js', array('jquery', 'popup_domination'), '3.0');
					/*wp_enqueue_script('popup_domination_mailing',$this->plugin_url.'js/mailing/mailing.js',array('jquery', 'popup_domination'),'3.0');
					wp_enqueue_script('popup_domination_mailchimp',$this->plugin_url.'js/mailing/mailchimp.js',array('jquery', 'popup_domination'),'3.0');
					wp_enqueue_script('popup_domination_aweber',$this->plugin_url.'js/mailing/aweber.js',array('jquery', 'popup_domination'),'3.0');
					wp_enqueue_script('popup_domination_icontact',$this->plugin_url.'js/mailing/icontact.js',array('jquery', 'popup_domination'),'3.0');
					wp_enqueue_script('popup_domination_constant_contact',$this->plugin_url.'js/mailing/constantcontact.js',array('jquery', 'popup_domination'),'3.0');
					wp_enqueue_script('popup_domination_campaign_monitor',$this->plugin_url.'js/mailing/campaignmonitor.js',array('jquery', 'popup_domination'),'3.0');
					wp_enqueue_script('popup_domination_get_response',$this->plugin_url.'js/mailing/getresponse.js',array('jquery', 'popup_domination'),'3.0');
					wp_enqueue_script('popup_domination_email',$this->plugin_url.'js/mailing/email.js',array('jquery', 'popup_domination'),'3.0');
					wp_enqueue_script('popup_domination_html_form',$this->plugin_url.'js/mailing/htmlform.js',array('jquery', 'popup_domination'),'3.0');*/
				}else if(strstr($this->wpadmin_page,'promote')){
					wp_enqueue_script('popup_domination_promote',$this->plugin_url.'js/promote/promote.js',array('jquery', 'popup_domination'),'3.0');
				}else if(strstr($this->wpadmin_page,'a-btesting')){
					wp_enqueue_script('popup_domination_abtesting',$this->plugin_url.'js/ab/abtesting.js',array('jquery', 'popup_domination'),'3.0');
					wp_enqueue_script('popup_dominaton_delete_command',$this->plugin_url.'js/delete.js',array('jquery', 'popup_domination'),'3.0');
					wp_enqueue_script('popup_domination_graphs',$this->plugin_url.'js/graphs.jquery.1.0.js',array('jquery', 'popup_domination'),'3.0');
				}else if(strstr($this->wpadmin_page,'analytics')){
					wp_enqueue_script('popup_domination_graphs',$this->plugin_url.'js/graphs.jquery.1.0.js',array('jquery', 'popup_domination'),'3.0');
					wp_enqueue_script('popup_domination_analytics',$this->plugin_url.'js/analytics/analytics.js',array('jquery', 'popup_domination'),'3.0');
				}else if(strstr($this->wpadmin_page,'theme_upload')){
					wp_enqueue_script('ajax-theme-uploader',$this->plugin_url.'js/theme_upload/fileuploader.js',array('jquery', 'popup_domination'),'3.0');
					wp_enqueue_script('popup_domination_theme_upload',$this->plugin_url.'js/theme_upload/themeupload.js',array('jquery', 'popup_domination','ajax-theme-uploader'),'3.0');
				}else if(strstr($this->wpadmin_page,'support')){
					wp_enqueue_script('popup_domination_support',$this->plugin_url.'js/support/support.js',array('jquery', 'popup_domination'),'3.0');
				}else if(strstr($this->wpadmin_page,'campaigns')){
					if(isset($_GET['action'])){
						wp_enqueue_script('ajax-upload',$this->plugin_url.'js/campaign/ajaxupload.js',array('jquery', 'popup_domination'),'3.0');
						wp_enqueue_script('popup_domination_campaigns',$this->plugin_url.'js/campaign/admin_lightbox.js',array('jquery', 'popup_domination','ajax-upload'),'13.0');
					}else{
						wp_enqueue_script('popup_dominaton_delete_command',$this->plugin_url.'js/delete.js',array('jquery', 'popup_domination'),'3.0');
					}
				}
				
			}
		} else {
			if($this->is_enabled()){
				if( !in_array( $pagenow , array( 'wp-login.php', 'wp-register.php' ) ) ){
					if(!is_404()){
						wp_enqueue_script('popup_domination_lightbox',$this->plugin_url.'js/lightbox.js',array('jquery'),'3.3');
						wp_enqueue_script('flowplayer',$this->plugin_url.'inc/flowplayer/example/flowplayer-3.2.6.min.js',array('jquery', 'popup_domination_lightbox'),'3.0');
						wp_enqueue_script('flowplayer-ipad',$this->plugin_url.'inc/flowplayer/example/flowplayer.ipad-3.2.2.min.js',array('jquery', 'flowplayer','popup_domination_lightbox'),'3.0');
						wp_enqueue_script('popup_domination_placeholder_support',$this->plugin_url.'js/placeholder.jquery.js',array('jquery', 'popup_domination_lightbox'),'3.0');
						$this->load_lightbox();
					}
				}
			}
		}
	}
	
	/**
	* is_enabled()
	*
	* Ronseal. Used to check is plugin has been turned on.
	*/
	
	function is_enabled(){
		static $enabled;
		if(!isset($enabled)){
			if(!$e = $this->option('enabled'))
				return false;
			if($this->is_mobile()){
				return false;
			}
			$enabled = $e;
		}
		return $enabled == 'Y' ? true : false;
	}
	
	/**
	* should_show()
	*
	* Checks if PopUp has been assigned to show somewhere.
	* More a security check than functionality.
	*/
	
	function should_show(){
		return true;
	}
	
	/**
	* show_var()
	*
	* ???
	*/
	
	function show_var($backup=false){
		$var = 'show';
		if($backup)
			$var .= '_backup';
		$$var = array();
		if($s = $this->option($var,false)){
			if(!empty($s)){
				if(is_array($s))
					$$var = $s;
				else
					$$var = unserialize($s);
			}
		}
		return $$var;
	}
	
	/**
	* plugin_action_links()
	*
	* When users click settings in the plugin menu, this kicks in and re-directs them to admin panels.
	*/
	
	function plugin_action_links($links, $file){
		if($file == $this->base_name){
			 $ins = '';
			if($ins != $this->option('v3installed')){
				$settings_link = '<a href="admin.php?page=popup-domination/campaigns">'.__('Settings').'</a>';
			}else{
				$settings_link = '<a href="options-general.php?page=popup-domination/install">'.__('Settings').'</a>';
			}
			array_unshift($links,$settings_link);
		}
		return $links;
	}
	
	/**
	* activate()
	*
	* Ronseal. Turns plugin on.
	*/
	
	function activate(){
		if(wp_verify_nonce($_GET['_wpnonce'], 'update-options')){
			$update = $_GET['todo'] == 'turn-on' ? 'Y' : 'N';
			$this->update('enabled',$update);
			echo '{"active":"'.$update.'"}';
		} else {
			echo '{"error":"Verification failed, please refresh the page and try again."}';
		}
		exit;
	}
	
	/**
	* upload_file()
	*
	* PHP for image files uploaded through the plugin.
	* Moves images to upload folder in wp-content.
	*/
	
	function upload_file(){
		if(wp_verify_nonce($_POST['_wpnonce'], 'update-options') && isset($_POST['template']) && $t = $this->get_theme_info($_POST['template'])){
			if(isset($_POST['fieldid'])){
				if($field = $this->get_field($t,$_POST['fieldid'])){
					$uploads = wp_upload_dir();
					$fileobj = $_FILES['userfile'];
					if(!empty($fileobj['tmp_name']) && file_is_displayable_image($fileobj['tmp_name'])){
						if($file = wp_handle_upload($fileobj,array('test_form'=>false,'action'=>'wp_handle_upload'))){
							$sizes = array();
							if(isset($field['field_opts'])){
								$opts = $field['field_opts'];
								if(isset($opts['max_w']) && isset($opts['max_h']))
									$sizes = array($opts['max_w'],$opts['max_h']);
							}
							$image_url = $file['url'];
							if(count($sizes) == 2){
								$resized = image_make_intermediate_size($file['file'],$sizes[0],$sizes[1]);
								if($resized)
									$image_url = $uploads['url'].'/'.$resized['file'];
							}
							$attachment = array('post_title' => $fileobj['name'],
												'post_content' => '',
												'post_status' => 'inherit',
												'post_mime_type' => $file['type'],
												'guid' => $image_url);
							$aid = wp_insert_attachment($attachment,$file['file'],0);
							if(!is_wp_error($aid)){
								wp_update_attachment_metadata($aid,wp_generate_attachment_metadata($aid,$file['file']));
								echo $image_url.'|'.$aid.'|';
							} else {
								echo 'error|<strong>Upload Error:</strong> ' . $aid->get_error_message();
							}
							exit;
						}
					} else {
						echo 'error|<strong>Upload Error:</strong> The file you tried to upload is not a valid image.';
						exit;
					}
				}
			}
		}
		echo 'error|<strong>Upload Error:</strong> There was an error finding the field.';
		die();
	}
	
	/**
	* upload_theme()
	*
	* PHP for processing and unzipping uploaded themes through then uploader.
	*/
	
	function upload_theme(){
		require 'php.php';
		$allowedExtensions = array();
		// max file size in bytes
		$sizeLimit = 5 * 1024 * 1024;
		
		$file = new qqFileUploader($allowedExtensions, $sizeLimit);
		$name = $file->getName();
		$result = $file->handleUpload($this->plugin_path.'tmp/');
		if($result['success'] == '1'){
			/**
			* Checks if .zip saved in TMP folder then unzips.
			* Has some hacks for working with WP unzipper as some ppl may not have PHP upzip applied on server.
			*/
			function __return_direct() { return 'direct'; }
			add_filter( 'filesystem_method', '__return_direct' );
			WP_Filesystem();
			remove_filter( 'filesystem_method', '__return_direct' );
			$folder = $this->plugin_path.'themes/';
			$result = unzip_file($this->plugin_path.'tmp/'.$name, $folder );
			$this->theme_backup();
			echo '{success:true}';
		}else{
			echo '{success:false}';
		}
		die();
	}
	
	/**
	* sort_array()
	*
	* Ronseal.
	*/
	
	function sort_array($a,$b){
		if($a['name'] == $b['name'])
			return 0;
		return ($a['name'] < $b['name']) ? -1 : 1;
	}
	
	/**
	* get_field()
	*
	* Gets theme fields from the theme.txt file.
	*/
	
	function get_field($theme,$field){
		if(empty($field))
			return false;
		if(!isset($theme['fields']))
			return false;
		foreach($theme['fields'] as $f){
			if($f['field_opts']['id'] == $field)
				return $f;
		}
		return false;
	}
	
	/**
	* option()
	*
	* Security checks and gets data from PopDom fields in wp_options.
	*/
	
	function option($key,$enc=true){
		return (($enc)?$this->encode(get_option('popup_domination_'.$key)):get_option('popup_domination_'.$key));
	}
	
	/**
	* update()
	*
	* Security checks and saves data from PopDom fields in wp_options.
	*/
	
	function update($key,$val,$enc=true){
		update_option( 'popup_domination_'.$key,(($enc)?$this->encode($val):$val));
	}
	
	/**
	* encode()
	*
	* Removes html code to stop the plugin from breaking.
	* Used for the field inputs in the campaign builder.
	*/
	
	function encode($str,$striptags=true){
		if($striptags){
			$str = strip_tags($str,'<b><strong><em><i><br>');
			$str = preg_replace('{<br\s*>}si','<br />',$str);
		}
		return $str;
	}
	
	/**
	* encode2()
	*
	* Removes script and style tags to stop plugin from breaking.
	* used for the field inputs in the campaign builder.
	*/
	
	function encode2($str){
		$str = preg_replace('{<style[^>]*>.*</style>}si','',$str);
		$str = preg_replace('{<script[^>]*>.*</script>}si','',$str);
		return utf8_encode(stripslashes($str));
	}
	
	/**
	* check_file_type()
	*
	* ???
	*/
	
	function check_file_type($file,$types=array(),$natypes=array()){
		if(empty($file))
			return false;
		if(count($types) == 0 && count($natypes) == 0)
			return true;
		$lower = strtolower($file); $fl = strlen($file);
		if(count($natypes) > 0){
			foreach($natypes as $n){
				$nl = strlen($n);
				$tmp = substr($lower,($fl-$nl),$nl);
				if($tmp == $n)
					return false;
			}
		}
		if(count($types) > 0){
			foreach($types as $t){
				$tl = strlen($t);
				$tmp = substr($lower,($fl-$tl),$tl);
				if($tmp == $t)
					return true;
			}
		}
		return false;
	}
	
	/**
	* get_file_list()
	*
	* Gets a full list of files that are in a directory.
	*/
	
	function get_file_list($dir,$dirs=false,$types=array(),$natypes=array()){
		$t_dir = @opendir($dir);
		if(!$t_dir)
			return false;
		$na = array('','.','..');
		$files = array();
		while(($file = readdir($t_dir)) !== false){
			if(!in_array($file,$na)){
				if($dirs){
					if(is_dir($dir.$file))
						$files[] = $file;
				} else {
					if(!is_dir($dir.$file)){
						if($this->check_file_type($file,$types,$natypes))
							$files[] = $file;
					}
				}
			}
		}
		if($t_dir)
			@closedir($t_dir);
		return $files;
	}
	
	/**
	* get_theme_info()
	*
	* Ronseal. Gets the theme info from the theme.txt file.
	*/
	
	function get_theme_info($t){
		$files = $this->get_file_list($this->theme_path.$t);
		if(in_array('theme.txt',$files)){
			$template_data = implode( '', file( $this->theme_path.$t.'/theme.txt' ));
			$name = '';
			$opts = array();
			if(preg_match('|Template Name:(.*)$|mi', $template_data, $name)){
				$opts['name'] = _cleanup_header_comment($name[1]);
				$opts['center'] = 'N';
				if(preg_match( '|Center:(.*)$|mi', $template_data, $size))
					$opts['center'] = _cleanup_header_comment($size[1]);
				if(preg_match( '|Preview Size:(.*)$|mi', $template_data, $size))
					$opts['size'] = array_filter(explode('x',_cleanup_header_comment($size[1])));
				$opts['ext'] = 'png';
				if(preg_match( '|Preview Ext:(.*)$|mi', $template_data, $ext))
					$opts['ext'] = _cleanup_header_comment($ext[1]);
				if(preg_match( '|Colors:(.*)$|mi', $template_data, $color)){
					$opts['colors'] = $this->color_opts($t,$opts['ext'],array_filter(explode(' | ',_cleanup_header_comment($color[1]))));
				} else {
					if(file_exists($this->theme_path.$t.'/preview.'.$opts['ext']))
						$opts['img'] = $t.'/preview.'.$opts['ext'];
				}
				if(preg_match('|Button Colors:(.*)$|mi',$template_data, $colors))
					$opts['button_colors'] = $this->button_colors($t,array_filter(explode('|',_cleanup_header_comment($colors[1]))));
				if(preg_match( '|List Items:(.*)$|mi', $template_data, $list))
					$opts['list'] = intval(_cleanup_header_comment($list[1]));
				if(preg_match( '|Fields:(.*)$|mi', $template_data, $fields))
					$opts['fields'] = $this->field_opts(array_filter(explode('|',_cleanup_header_comment($fields[1]))));
				if(preg_match( '|NumberExtraInputs:(.*)$|mi', $template_data, $numfields))
					$opts['numfields'] = intval(_cleanup_header_comment($numfields[1]));
				$opts['theme'] = $t;
				return $opts;
			}
		}
		return false;
	}
	
	/**
	* field_opts()
	*
	* Gets all field options.
	* Used in conjuction with get_theme_info().
	*/
	
	function field_opts($fields=array()){
		if(is_array($fields) && count($fields) > 0){
			$arr = array();
			foreach($fields as $f){
				$tmp_arr = array();
				$f2 = explode('[',$f);
				$tmp_arr['name'] = $f2[0];
				$f2 = explode(']',$f2[1]);
				$f2 = array_filter(explode(',',$f2[0]));
				$tmp_arr['field_opts'] = array();
				foreach($f2 as $a => $b){
					$f3 = explode(':',$b);
					if(count($f3) > 1){
						$tmp_arr['field_opts'][$f3[0]] = $f3[1];
					}
				}
				$arr[] = $tmp_arr;
			}
			return $arr;
		}
		return false;
	}
	
	/**
	* color_opts()
	*
	* Gets all colour options for the templates.
	* Used in conjuction with get_theme_info().
	*/
	
	function color_opts($t,$ext,$colors=array()){
		if(is_array($colors) && count($colors) > 0){
			$arr = array();
			foreach($colors as $c){
				$tmp_arr = array();
				$c2 = explode('[',$c);
				$tmp_arr['name'] = $c2[0];
				$c2 = explode(']',$c2[1]);
				$info = array_filter(explode(':',$c2[0]));
				$file = $t.'/previews/'.$info[0].'.'.$ext;
				if(file_exists($this->theme_path.$file) && is_file($this->theme_path.$file)){
					$info[2] = $file;
				}
				$tmp_arr['info'] =  $info;
				$arr[] = $tmp_arr;
			}
			return $arr;
		}
		return false;
	}
	
	/**
	* button_colors()
	*
	* Gets all button colour options for the templates.
	* Used in conjuction with get_theme_info().
	*/
	
	function button_colors($t,$colors=array()){
		if(is_array($colors) && count($colors) > 0){
			$arr = array();
			foreach($colors as $c){
				$tmp_arr = array();
				$c2 = explode('[',$c);
				$tmp_arr['name'] = $c2[0];
				$c2 = explode(']',$c2[1]);
				$tmp_arr['color_id'] = $c2[0];
				$arr[] = $tmp_arr;
			}
			usort($arr,array(&$this,'sort_array'));
			return $arr;
		}
		return false;
	}
	
	/**
	* get_themes()
	*
	* Ronseal.
	* Used for dropdown list of themes in campaign builder.
	*/
	
	function get_themes(){
		if(count($this->themes) == 0){
			$themes = $this->get_file_list($this->theme_path,true);
			$this->themes = array();
			foreach($themes as $t){
				if($t = $this->get_theme_info($t))
					$this->themes[] = $t;
			}
			usort($this->themes,array(&$this,'sort_array'));
		}
		return $this->themes;
	}
	
	/**
	* show_lightbox()
	*
	* ???
	*/
	
	function show_lightbox(){
		echo $this->load_lightbox();
	}
	
	/**
	* page_list_recursive()
	*
	* Get list of pages from the WP DB.
	* Used in campaign builder "display settings".
	*/
	
	function page_list_recursive($parentid=0,$exclude='',$selected=array()){
		$pages = get_pages('parent='.$parentid.'&child_of='.$parentid.'&exclude='.$exclude);
		if(count($pages) > 0){
			$str = '
		<ul class="children">';
			foreach($pages as $p){
				$sel = false;
				if(isset($selected['pageid']) && in_array($p->ID,$selected['pageid']))
					$sel = true;
				$str .= '
			<li><input type="checkbox" name="popup_domination_show[pageid][]" value="'.$p->ID.'" id="pageid_'.$p->ID.'"'.(($sel)?' checked="checked"':'').' /> <label for="pageid_'.$p->ID.'">'.esc_html($p->post_title).'</label>'.$this->page_list_recursive($p->ID,$exclude,$selected).'</li>';
			}
			$str .= '
		</ul>';
			return $str;
		}
	}
	
	/**
	* cat_list_recursive()
	*
	* Get list of categories from the WP DB.
	* Used in campaign builder "display settings".
	*/
	
	function cat_list_recursive($parentid=0,$selected=array()){
		$cats = get_categories('hide_empty=0&child_of='.$parentid.'&parent='.$parentid);
		if(count($cats) > 0){
			$str = '
				<ul class="children">';
			foreach($cats as $c){
				$sel = false;
				if(isset($selected['catid']) && in_array($c->cat_ID,$selected['catid']))
					$sel = true;
				$str .= '
					<li><input type="checkbox" name="popup_domination_show[catid][]" value="'.$c->cat_ID.'" id="catid_'.$c->cat_ID.'"'.(($sel)?' checked="checked"':'').' /> <label for="catid_'.$c->cat_ID.'">'.esc_html($c->cat_name).'</label>'.$this->cat_list_recursive($c->cat_ID,$selected).'</li>';
				}
			$str .= '</ul>';
			return $str;
		}
		return '';
	}
	
	/**
	* is_mobile()
	*
	* Finds if users is using a mobile device, and if so, which.
	*/
	
	function is_mobile(){
		static $browser;
		if(!isset($browser)){
			$mobile = array('2.0 MMP','240x320','400X240','Android','AvantGo','BlackBerry','BlackBerry9530','Blazer','Cellphone','Danger','DoCoMo',
							'Elaine/3.0','EudoraWeb','Googlebot-Mobile','hiptop','IEMobile','iPhone','iPod','KYOCERA/WX310K','LGE VX','LG/U990',
							'LG-TU915 Obigo','MIDP-2.','MMEF20','MOT-V','NetFront','Newt','Nintendo Wii','Nitro','Nokia','Nokia5800','Opera Mini',
							'Palm','PlayStation Portable','portalmmm','Proxinet','ProxiNet','SHARP-TQ-GX10','SHG-i900','Small','SonyEricsson',
							'Symbian OS','SymbianOS','TS21i-10','UP.Browser','UP.Link','webOS','Windows CE','WinWAP','YahooSeeker/M1A1-R2D2', 'iPad');
			$browser = '';
			$agent = trim($_SERVER['HTTP_USER_AGENT']);
			
			if(isset($agent) && !empty($agent)){
				foreach($mobile as $m){
					//TODO toLowerCase for strpos
					if(!empty($m) && strpos($agent, trim($m)) !== false){
						$browser = $m;
						return true;
					}
				}
			} else {
				return false;
			}
		}
		return false;
	}
	
	/**
	* input_val()
	*
	* Security for all input fields.
	*/
	
	function input_val($str){
		$str = htmlspecialchars($str);
		$str = str_replace(array("'",'"'),array('&#39;','&quot;'),$str);
		return $str;
	}
	
	/**
	* get_cur_url()
	*
	* Ronseal. Used for cURL.
	*/
	
	function get_cur_url(){
		return 'http'.(($_SERVER['HTTPS']=='on')?'s':'').'://'.$_SERVER['SERVER_NAME'].(($_SERVER['SERVER_PORT'] != '80')?':'.$_SERVER['SERVER_PORT']:'').$_SERVER['REQUEST_URI'];
	}
	
	/**
	* lightbox_submit()
	*
	* Ajax triggered, loads file where plugin does action depening on the mailing list provider selected.
	*/
	
	function lightbox_submit(){
		include $this->plugin_path.'inc/submitdetails.php';
		die();
	}
	
}

/**
* Don't fiddle with these, helps manage the 3 file system.
*/

if(!function_exists('_cleanup_header_comment')){
	function _cleanup_header_comment($str){
		return trim(preg_replace("/\s*(?:\*\/|\?>).*/", '', $str));
	}
}

if(is_admin()){
	require_once plugin_basename('popup-domination.admin.php');
} else {
	require_once plugin_basename('popup-domination.front.php');
}

?>