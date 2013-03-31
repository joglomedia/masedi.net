<?php
/*************************************************************
 * 
 * core.class.php
 * 
 * Upgrade Plugins
 * 
 * 
 * Copyright (c) 2011 Prelovac Media
 * www.prelovac.com
 **************************************************************/
if(basename($_SERVER['SCRIPT_FILENAME']) == "core.class.php"):
    exit;
endif;
class CMSC_Core extends CMSC_Helper
{
    var $name;
    var $slug;
    var $settings;
    var $remote_client;
    var $comment_instance;
    var $plugin_instance;
    var $theme_instance;
    var $wp_instance;
    var $post_instance;
    var $stats_instance;
    var $search_instance;
    var $links_instance;
    var $user_instance;
    var $backup_instance;
    var $installer_instance;
    var $cmsc_multisite;
    var $network_admin_install;
    private $action_call;
    private $action_params;
    private $cmsc_pre_init_actions;
    private $cmsc_pre_init_filters;
    private $cmsc_init_actions;
    
 	var $comments_instance;	
    var $cmsc_instance;
    var $wpr_instance;
	
    function __construct()
    {
        global $cmsc_plugin_dir, $wpmu_version, $blog_id, $_cmsc_plugin_actions, $_cmsc_item_filter, $_cmsc_options;
        
		$_cmsc_plugin_actions = array();
		$_cmsc_options = get_option('cmscsettings');
		$_cmsc_options = !empty($_cmsc_options) ? $_cmsc_options : array();
		
        $this->name     = 'Manage Multiple Blogs';
		$this->action_call = null;
		$this->action_params = null;
		
		if ( function_exists('is_multisite') ) {
            if ( is_multisite() ) {
                $this->cmsc_multisite = $blog_id;
                $this->network_admin_install = get_option('cmsc_network_admin_install');
            }
        } else if (!empty($wpmu_version)) {
            $this->cmsc_multisite = $blog_id;
            $this->network_admin_install = get_option('cmsc_network_admin_install');
        } else {
			$this->cmsc_multisite = false;
			$this->network_admin_install = null;
		}
		
		// admin notices
		if ( !get_option('_cmsc_public_key') ){
			if( $this->cmsc_multisite ){
				if( is_network_admin() && $this->network_admin_install == '1'){
					add_action('network_admin_notices', array( &$this, 'network_admin_notice' ));
				} else if( $this->network_admin_install != '1' ){
					$parent_key = $this->get_parent_blog_option('_cmsc_public_key');
					if(empty($parent_key))
						add_action('admin_notices', array( &$this, 'admin_notice' ));
				}
			} else {
				add_action('admin_notices', array( &$this, 'admin_notice' ));
			}
		}
		
		// default filters
		//$this->cmsc_pre_init_filters['get_stats']['cmsc_stats_filter'][] = array('CMSC_Stats', 'pre_init_stats'); // called with class name, use global $cmsc_core inside the function instead of $this
		$this->cmsc_pre_init_filters['get_stats']['cmsc_stats_filter'][] = 'cmsc_pre_init_stats';
		
		$_cmsc_item_filter['pre_init_stats'] = array( 'core_update', 'hit_counter', 'comments', 'backups', 'posts', 'drafts', 'scheduled' );
		$_cmsc_item_filter['get'] = array( 'updates', 'errors' );
		
		$this->cmsc_pre_init_actions = array(
			'backup_req' => 'cmsc_get_backup_req',
		);
		
		$this->cmsc_init_actions = array(
			'do_upgrade' => 'cmsc_do_upgrade',
			'get_stats' => 'cmsc_stats_get',
			'remove_site' => 'cmsc_remove_site',
			'backup_clone' => 'cmsc_backup_now',
			'restore' => 'cmsc_restore_now',
			'optimize_tables' => 'cmsc_optimize_tables',
			'check_wp_version' => 'cmsc_wp_checkversion',
			'create_post' => 'cmsc_post_create',
			'update_worker' => 'cmsc_update_cmsc_plugin',
			'change_comment_status' => 'cmsc_change_comment_status',
			'change_post_status' => 'cmsc_change_post_status',
			'get_comment_stats' => 'cmsc_comment_stats_get',
			'install_addon' => 'cmsc_install_addon',
			'get_links' => 'cmsc_get_links',
			'add_link' => 'cmsc_add_link',
			'delete_link' => 'cmsc_delete_link',
			'delete_links' => 'cmsc_delete_links',
			'add_user' => 'cmsc_add_user',
			'email_backup' => 'cmsc_email_backup',
			'check_backup_compat' => 'cmsc_check_backup_compat',
			'scheduled_backup' => 'cmsc_scheduled_backup',
			'run_task' => 'cmsc_run_task_now',
			'execute_php_code' => 'cmsc_execute_php_code',
			'delete_backup' => 'cmsc_delete_backup',
			'remote_backup_now' => 'cmsc_remote_backup_now',
			'set_notifications' => 'cmsc_set_notifications',
			'clean_orphan_backups' => 'cmsc_clean_orphan_backups',
			//'get_users' => 'cmsc_get_users',
			'edit_users' => 'cmsc_edit_users', 
			'delete_post' => 'cmsc_delete_post',
			'delete_posts' => 'cmsc_delete_posts',
			'edit_posts' => 'cmsc_edit_posts',
			'get_pages' => 'cmsc_get_pages',
			'delete_page' => 'cmsc_delete_page',
			'get_plugins_themes' => 'cmsc_get_plugins_themes',
			'edit_plugins_themes' => 'cmsc_edit_plugins_themes',
			'worker_brand' => 'cmsc_worker_brand',
			'set_alerts' => 'cmsc_set_alerts',
			'maintenance' => 'cmsc_maintenance_mode',
			
			'get_posts_search' => 'cmsc_get_posts',		
			
			/* CMSC */
			'get_site_data' => 'cmsc_content_get_site_data',	
			'get_cmsc_stats' => 'cmsc_get_stats',
			'cmsc_get_backup_results' => 'cmsc_get_backup_results',
			
			/* Content */
			'process_api_request' => 'cmsc_process_api_request',	
			'get_post' => 'cmsc_stats_get_post',	
			'get_posts' => 'cmsc_stats_get_posts',		
			'edit_post' => 'cmsc_post_create',	
			'create_post_bulk' => 'cmsc_post_create_bulk',
			'bulk_edit' => 'cmsc_bulk_edit',	
			
			/* Categories */
			'add_category' => 'cmsc_add_category',
			'get_categories' => 'cmsc_get_categories',
			'delete_category' => 'cmsc_delete_category',	
			
			/* Users */		
			//'get_user' => 'cmsc_user_get',
			'get_users' => 'cmsc_get_users_2',			
			'add_users' => 'cmsc_add_users',		
			'delete_user' => 'cmsc_delete_user',
			//'edit_user' => 'cmsc_user_edit',	

			/* Settings */
			'get_settings' => 'cmsc_get_settings',
			'save_settings' => 'cmsc_save_settings',	
			
			/* Comments */	
			'get_comments' => 'cmsc_comments_get',
			'delete_comments' => 'cmsc_comments_delete',
			'approve_comments' => 'cmsc_comments_approve',
			'unapprove_comments' => 'cmsc_comments_unapprove',	

			/* Plugins */
			'get_plugins' => 'cmsc_plugins_get',
			'update_plugins' => 'cmsc_plugins_update',	
			'update_core' => 'cmsc_core_update',	
			'get_themes' => 'cmsc_themes_get',
			'update_themes' => 'cmsc_themes_update',	
			
			/* WP ROBOT */	
			'wpr_get_campaigns' => 'cmsc_wpr_get_campaigns',	
			'wpr_get_campaign' => 'cmsc_wpr_get_campaign',	
			'wpr_create_campaign' => 'cmsc_wpr_create_campaign',				
			'wpr_campaign_controls' => 'cmsc_wpr_campaign_controls',
			'wpr_get_options' => 'cmsc_wpr_get_options',	
			'wpr_update_options' => 'cmsc_wpr_update_options',	
			'wpr_get_log' => 'cmsc_wpr_get_log',
			'wpr_get_post_templates' => 'cmsc_wpr_get_post_templates',
			'wpr_get_module_templates' => 'cmsc_wpr_get_module_templates',		
			'wpr_save_module_templates' => 'cmsc_wpr_save_module_templates',
			'wpr_save_post_templates' => 'cmsc_wpr_save_post_templates',			
		);

		add_action('rightnow_end', array( &$this, 'add_right_now_info' )); 
		add_action('admin_init', array(&$this,'admin_actions'));  		
		//add_action('init', array( &$this, 'cmsc_remote_action'), 9999);		
		add_action('setup_theme', array( &$this, 'cmsc_remote_action'), 9);
		add_action('setup_theme', 'cmsc_parse_request', 8);				
		add_action('set_auth_cookie', array( &$this, 'cmsc_set_auth_cookie'));
		add_action('set_logged_in_cookie', array( &$this, 'cmsc_set_logged_in_cookie'));				

    }
    
	function cmsc_remote_action(){
		if($this->action_call != null){
			$params = isset($this->action_params) && $this->action_params != null ? $this->action_params : array();
			call_user_func($this->action_call, $params);
		}
	}
	
	function register_action_params( $action = false, $params = array() ){
		
		if(isset($this->cmsc_pre_init_actions[$action]) && function_exists($this->cmsc_pre_init_actions[$action])){
			call_user_func($this->cmsc_pre_init_actions[$action], $params);
		}
		
		if(isset($this->cmsc_init_actions[$action]) && function_exists($this->cmsc_init_actions[$action])){
			$this->action_call = $this->cmsc_init_actions[$action];
			$this->action_params = $params;
			
			if( isset($this->cmsc_pre_init_filters[$action]) && !empty($this->cmsc_pre_init_filters[$action])){
				global $cmsc_filters;
				
				foreach($this->cmsc_pre_init_filters[$action] as $_name => $_functions){
					if(!empty($_functions)){
						$data = array();
						
						foreach($_functions as $_k => $_callback){
							if(is_array($_callback) && method_exists($_callback[0], $_callback[1]) ){
								$data = call_user_func( $_callback, $params );
							} elseif (is_string($_callback) && function_exists( $_callback )){
								$data = call_user_func( $_callback, $params );
							}
							$cmsc_filters[$_name] = isset($cmsc_filters[$_name]) && !empty($cmsc_filters[$_name]) ? array_merge($cmsc_filters[$_name], $data) : $data;
							add_filter( $_name, create_function( '$a' , 'global $cmsc_filters; return array_merge($a, $cmsc_filters["'.$_name.'"]);') );
						}
					}
					
				}
			}
			return true;
		} 
		return false;
	}
	
    /**
     * Add notice to network admin dashboard for security reasons    
     * 
     */
    function network_admin_notice()
    {
        echo '<div class="error" style="text-align: center;"><p style="color: red; font-size: 14px; font-weight: bold;">Attention !</p><p>
	  	Please add this site and your network blogs, with your network adminstrator username, to your <a target="_blank" href="http://cmscommander.com/wp-admin">CMSCommander.com</a> account now to remove this notice or "Network Deactivate" the CMS Commander plugin to avoid security issues.	  	
	  	</p></div>';
    }
	
		
	/**
     * Add notice to admin dashboard for security reasons    
     * 
     */
    function admin_notice()
    {
        echo '<div class="error" style="text-align: center;"><p style="color: red; font-size: 14px; font-weight: bold;">Attention !</p><p>
	  	Please add this site to your <a target="_blank" href="http://cmscommander.com/wp-admin">CMSCommander.com</a> account now or deactivate the CMS Commander plugin until you are ready to do so to avoid security issues.	  	
	  	</p></div>';
    }
    
    /**
     * Add an item into the Right Now Dashboard widget 
     * to inform that the blog can be managed remotely
     * 
     */
    function add_right_now_info()
    {
        echo '<div class="mmb-slave-info">
            <p>This site can be managed remotely in <a href="http://cmscommander.com/">CMS Commander</a>. Go to <a title="Log into your CMS Commander account" href="http://cmscommander.com/wp-admin">Your Dashboard</a></p>
        </div>';
    }
    
    /**
     * Get parent blog options
     * 
     */
    private function get_parent_blog_option( $option_name = '' )
    {
		global $wpdb;
		$option = $wpdb->get_var( $wpdb->prepare( "SELECT `option_value` FROM {$wpdb->base_prefix}options WHERE option_name = '{$option_name}' LIMIT 1" ) );
        return $option;
    }
    
    /**
     * Gets an instance of the Comment class
     * 
     */
    function get_comment_instance()
    {
        if (!isset($this->comment_instance)) {
            $this->comment_instance = new CMSC_Comment();
        }
        
        return $this->comment_instance;
    }
    
    /**
     * Gets an instance of the Plugin class
     * 
     */
    function get_plugin_instance()
    {
        if (!isset($this->plugin_instance)) {
            $this->plugin_instance = new CMSC_Plugin();
        }
        
        return $this->plugin_instance;
    }
    
    /**
     * Gets an instance of the Theme class
     * 
     */
    function get_theme_instance()
    {
        if (!isset($this->theme_instance)) {
            $this->theme_instance = new CMSC_Theme();
        }
        
        return $this->theme_instance;
    }
    
    
    /**
     * Gets an instance of CMSC_Post class
     * 
     */
    function get_post_instance()
    {
        if (!isset($this->post_instance)) {
            $this->post_instance = new CMSC_Post();
        }
        
        return $this->post_instance;
    }
    
    /**
     * Gets an instance of Blogroll class
     * 
     */
    function get_blogroll_instance()
    {
        if (!isset($this->blogroll_instance)) {
            $this->blogroll_instance = new CMSC_Blogroll();
        }
        
        return $this->blogroll_instance;
    }
    
    
    
    /**
     * Gets an instance of the WP class
     * 
     */
    function get_wp_instance()
    {
        if (!isset($this->wp_instance)) {
            $this->wp_instance = new CMSC_WP();
        }
        
        return $this->wp_instance;
    }
    
    /**
     * Gets an instance of User
     * 
     */
    function get_user_instance()
    {
        if (!isset($this->user_instance)) {
            $this->user_instance = new CMSC_User();
        }
        
        return $this->user_instance;
    }
    
    /**
     * Gets an instance of stats class
     * 
     */
    function get_stats_instance()
    {
        if (!isset($this->stats_instance)) {
            $this->stats_instance = new CMSC_Stats();
        }
        return $this->stats_instance;
    }
    /**
     * Gets an instance of search class
     * 
     */
    function get_search_instance()
    {
        if (!isset($this->search_instance)) {
            $this->search_instance = new CMSC_Search();
        }
        //return $this->search_instance;
        return $this->search_instance;
    }
    /**
     * Gets an instance of stats class
     *
     */
    function get_backup_instance()
    {
        if (!isset($this->backup_instance)) {
            $this->backup_instance = new CMSC_Backup();
        }
        
        return $this->backup_instance;
    }
    
    /**
     * Gets an instance of links class
     *
     */
    function get_link_instance()
    {
        if (!isset($this->link_instance)) {
            $this->link_instance = new CMSC_Link();
        }
        
        return $this->link_instance;
    }
    
    function get_installer_instance()
    {
        if (!isset($this->installer_instance)) {
            $this->installer_instance = new CMSC_Installer();
        }
        return $this->installer_instance;
    }
    
    /**
     * Plugin install callback function
     * Check PHP version
     */
    function install() {
		
        global $wpdb, $_wp_using_ext_object_cache, $current_user;
        $_wp_using_ext_object_cache = false;
		
        //delete plugin options, just in case
        if ($this->cmsc_multisite != false) {
			$network_blogs = $wpdb->get_results($wpdb->prepare("select `blog_id`, `site_id` from `{$wpdb->blogs}`"));
			if(!empty($network_blogs)){
				if( is_network_admin() ){
					update_option('cmsc_network_admin_install', 1);
					foreach($network_blogs as $details){
						if($details->site_id == $details->blog_id)
							update_blog_option($details->blog_id, 'cmsc_network_admin_install', 1);
						else 
							update_blog_option($details->blog_id, 'cmsc_network_admin_install', -1);
							
						delete_blog_option($blog_id, '_cmsc_nossl_key');
						delete_blog_option($blog_id, '_cmsc_public_key');
						delete_blog_option($blog_id, '_cmsc_action_message_id');
					}
				} else {
					update_option('cmsc_network_admin_install', -1);
					delete_option('_cmsc_nossl_key');
					delete_option('_cmsc_public_key');
					delete_option('_cmsc_action_message_id');
				}
			}
        } else {
            delete_option('_cmsc_nossl_key');
            delete_option('_cmsc_public_key');
            delete_option('_cmsc_action_message_id');
        }
        
        delete_option('cmsc_backup_tasks');
        delete_option('cmsc_notifications');
        delete_option('cmsc_worker_brand');
        delete_option('cmsc_pageview_alerts');
        
    }
    
    /**
     * Saves the (modified) options into the database
     * 
     */
    function save_options( $options = array() ){
		global $_cmsc_options;
		
		$_cmsc_options = array_merge( $_cmsc_options, $options );
		update_option('cmscsettings', $options);
    }
    
    /**
     * Deletes options for communication with master
     * 
     */
    function uninstall( $deactivate = false )
    {
        global $current_user, $wpdb, $_wp_using_ext_object_cache;
		$_wp_using_ext_object_cache = false;
        
        if ($this->cmsc_multisite != false) {
			$network_blogs = $wpdb->get_col($wpdb->prepare("select `blog_id` from `{$wpdb->blogs}`"));
			if(!empty($network_blogs)){
				if( is_network_admin() ){
					if( $deactivate ) {
						delete_option('cmsc_network_admin_install');
						foreach($network_blogs as $blog_id){
							delete_blog_option($blog_id, 'cmsc_network_admin_install');
							delete_blog_option($blog_id, '_cmsc_nossl_key');
							delete_blog_option($blog_id, '_cmsc_public_key');
							delete_blog_option($blog_id, '_cmsc_action_message_id');
							delete_blog_option($blog_id, 'cmsc_maintenace_mode');
							delete_blog_option($blog_id, 'cmsc_backup_tasks');
							delete_blog_option($blog_id, 'cmsc_notifications');
							delete_blog_option($blog_id, 'cmsc_worker_brand');
							delete_blog_option($blog_id, 'cmsc_pageview_alerts');
							delete_blog_option($blog_id, 'cmsc_pageview_alerts');
						}
					}
				} else {
					if( $deactivate )
						delete_option('cmsc_network_admin_install');
						
					delete_option('_cmsc_nossl_key');
					delete_option('_cmsc_public_key');
					delete_option('_cmsc_action_message_id');
				}
			}
        } else {
			delete_option('_cmsc_nossl_key');
            delete_option('_cmsc_public_key');
            delete_option('_cmsc_action_message_id');
        }
        
        //Delete options
		delete_option('cmsc_maintenace_mode');
        delete_option('cmsc_backup_tasks');
        delete_option('cmsc_notifications');
        delete_option('cmsc_worker_brand');
        delete_option('cmsc_pageview_alerts');
        wp_clear_scheduled_hook('cmsc_backup_tasks');
        wp_clear_scheduled_hook('cmsc_notifications');
        wp_clear_scheduled_hook('cmsc_datasend');
    }
    
    
    /**
     * Constructs a url (for ajax purpose)
     * 
     * @param mixed $base_page
     */
    function construct_url($params = array(), $base_page = 'index.php')
    {
        $url = "$base_page?_wpnonce=" . wp_create_nonce($this->slug);
        foreach ($params as $key => $value) {
            $url .= "&$key=$value";
        }
        
        return $url;
    }
    
    /**
     * Worker update
     * 
     */
    function update_cmsc_plugin($params)
    {
        extract($params);
        if ($download_url) {
            @include_once ABSPATH . 'wp-admin/includes/file.php';
            @include_once ABSPATH . 'wp-admin/includes/misc.php';
            @include_once ABSPATH . 'wp-admin/includes/template.php';
            @include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
            @include_once ABSPATH . 'wp-admin/includes/screen.php';
            
            if (!$this->is_server_writable()) {
                return array(
                    'error' => 'Failed, please <a target="_blank" href="http://cmscommander.com/user-guide/faq/my-pluginsthemes-fail-to-update-or-i-receive-a-yellow-ftp-warning">add FTP details for automatic upgrades.</a>'
                );
            }
            
            ob_start();
            @unlink(dirname(__FILE__));
            $upgrader = new Plugin_Upgrader();
            $result   = $upgrader->run(array(
                'package' => $download_url,
                'destination' => WP_PLUGIN_DIR,
                'clear_destination' => true,
                'clear_working' => true,
                'hook_extra' => array(
                    'plugin' => 'cmscommander/cmscommander.php'
                )
            ));
            ob_end_clean();
            if (is_wp_error($result) || !$result) {
                return array(
                    'error' => 'CMS Commander plugin could not be updated.'
                );
            } else {
                return array(
                    'success' => 'CMS Commander plugin successfully updated.'
                );
            }
        }
        return array(
            'error' => 'Bad download path for CMS Commander plugin installation file.'
        );
    }
    
    /**
     * Automatically logs in when called from Master
     * 
     */
    function automatic_login()
    {
		$where      = isset($_GET['cmsc_goto']) ? $_GET['cmsc_goto'] : false;
        $username   = isset($_GET['username']) ? $_GET['username'] : '';
        $auto_login = isset($_GET['auto_login']) ? $_GET['auto_login'] : 0;
        
		if( !function_exists('is_user_logged_in') )
			include_once( ABSPATH.'wp-includes/pluggable.php' );
		
		if (( $auto_login && strlen(trim($username)) && !is_user_logged_in() ) || (isset($this->cmsc_multisite) && $this->cmsc_multisite )) {
			$signature  = base64_decode($_GET['signature']);
            $message_id = trim($_GET['message_id']);
        
            $auth = $this->authenticate_message($where . $message_id, $signature, $message_id);
			if ($auth === true) {
				
				if (!headers_sent())
					header('P3P: CP="CAO PSA OUR"');
				
				if(!defined('CMSC_USER_LOGIN'))
					define('CMSC_USER_LOGIN', true);
				
				$siteurl = function_exists('get_site_option') ? get_site_option( 'siteurl' ) : get_option('siteurl');
				$user = $this->cmsc_get_user_info($username);
				wp_set_current_user($user->ID);
				
				if(!defined('COOKIEHASH') || (isset($this->cmsc_multisite) && $this->cmsc_multisite) )
					wp_cookie_constants();
				
				wp_set_auth_cookie($user->ID);
				@cmsc_worker_header();
				
				if((isset($this->cmsc_multisite) && $this->cmsc_multisite ) || isset($_REQUEST['cmscredirect'])){
					if(function_exists('wp_safe_redirect') && function_exists('admin_url')){
						wp_safe_redirect(admin_url($where));
						exit();
					}
				}
			} else {
                wp_die($auth['error']);
            }
        } elseif( is_user_logged_in() ) {
			@cmsc_worker_header();
			if(isset($_REQUEST['cmscredirect'])){
				if(function_exists('wp_safe_redirect') && function_exists('admin_url')){
					wp_safe_redirect(admin_url($where));
					exit();
				}
			}
		}
    }
    
	function cmsc_set_auth_cookie( $auth_cookie ){
		if(!defined('CMSC_USER_LOGIN'))
			return false;
		
		if( !defined('COOKIEHASH') )
			wp_cookie_constants();
			
		$_COOKIE['wordpress_'.COOKIEHASH] = $auth_cookie;
		
	}
	function cmsc_set_logged_in_cookie( $logged_in_cookie ){
		if(!defined('CMSC_USER_LOGIN'))
			return false;
	
		if( !defined('COOKIEHASH') )
			wp_cookie_constants();
			
		$_COOKIE['wordpress_logged_in_'.COOKIEHASH] = $logged_in_cookie;
	}
		
    function admin_actions(){
    	add_filter('all_plugins', array($this, 'worker_replace'));
    }
    
    function worker_replace($all_plugins){
    	$replace = get_option("cmsc_worker_brand");
    	if(is_array($replace)){
    		if($replace['name'] || $replace['desc'] || $replace['author'] || $replace['author_url']){
    			$all_plugins['cmscommander/cmscommander.php']['Name'] = $replace['name'];
    			$all_plugins['cmscommander/cmscommander.php']['Title'] = $replace['name'];
    			$all_plugins['cmscommander/cmscommander.php']['Description'] = $replace['desc'];
    			$all_plugins['cmscommander/cmscommander.php']['AuthorURI'] = $replace['author_url'];
    			$all_plugins['cmscommander/cmscommander.php']['Author'] = $replace['author'];
    			$all_plugins['cmscommander/cmscommander.php']['AuthorName'] = $replace['author'];
    			$all_plugins['cmscommander/cmscommander.php']['PluginURI'] = '';
    		}
    		
    		if($replace['hide']){
    			if (!function_exists('get_plugins')) {
            include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        	}
          $activated_plugins = get_option('active_plugins');
          if (!$activated_plugins)
                $activated_plugins = array();
          if(in_array('cmscommander/cmscommander.php',$activated_plugins))
           	unset($all_plugins['cmscommander/cmscommander.php']);   	
    		}
    	}
    	
    	  	
    	return $all_plugins;
    }
	
    /**
     * Gets an instance of comments class
     *
     */
    function get_comments_instance()
    {
        if (!isset($this->comments_instance)) {
            $this->comments_instance = new CMSC_Comments();
        }
        
        return $this->comments_instance;
    }

     /**
     * Gets an instance of cmsc class
     * 
     */
    function get_cmsc_instance()
    {
        if (!isset($this->cmsc_instance)) {
            $this->cmsc_instance = new CMSC_Functions();
        }
        return $this->cmsc_instance;
    } 
	
     /**
     * Gets an instance of WP Robot class
     * 
     */
    function get_wpr_instance() {
        if (!isset($this->wpr_instance)) {
            $this->wpr_instance = new CMSC_WP_Robot();
        }
        return $this->wpr_instance;
    }	
    
}
?>