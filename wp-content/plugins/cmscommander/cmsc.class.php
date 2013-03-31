<?php
/*************************************************************
 * Copyright (c) 2011 CMS Commander
 * www.cmscommander.com
 **************************************************************/

class CMSC_Functions extends CMSC_Core
{
    function __construct()
    {
        parent::__construct();
    }
	
    function api($args)
    {
	
		$appid = $args['appid'];
		$source = $args['source'];
		$request = $args['request'];
		
		if ( function_exists('curl_init') ) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Konqueror/4.0; Microsoft Windows) KHTML/4.0.80 (like Gecko)");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_URL, $request);
			curl_setopt($ch, CURLOPT_TIMEOUT, 60);
			if($source == "cj" || $source == "commissionjunction") {curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Host: link-search.api.cj.com',
				'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8',
				'Authorization: '.$appid,
				'Content-Type: application/xml'
				));	}					
			$response = curl_exec($ch);
			if (!$response) {
				$return["error"] = __("cURL Error Number ","cmsc").curl_errno($ch).": ".curl_error($ch);	
				return $return;
			}		
			curl_close($ch);
		} else { 				
			$response = @file_get_contents($request);
			if (!$response) {
				$return["error"] = __("cURL is not installed on this server!","cmsc");	
				return $return;		
			}
		}
		return $response;
	}	
	
    function bulk_create_post($args)
    {
		$po = new CMSC_Post(); 
		$ids = array();		
		foreach($args["post"] as $arg) {
			$id = $po->create($arg);
			$ids[] = $id;
			if(!empty($arg['comments'])) {
				$com = new CMSC_Comments(); 
				foreach($arg['comments'] as $comment) {					
					$cid = $com->create(array("post_id" => $id, "postdate" => "", "comment" => array("content" => $comment["content"], "author" => $comment["author"])));
				}
			}
	
		}
		return $ids;	
	} 

    function get_users($args)
    {

    	if(!function_exists('get_users'))
			include_once(ABSPATH . WPINC . '/user.php');			
	
		$num = $args['num'];
		if(empty($num)) {$num = 50;}		

		return get_users('number='.$num);
	} 	
	
    function delete_user($args)
    {
	
		$uid = $args['user_id'];  // can accept array of user ids
		
		if(empty($uid)) {return 'User could not be found.';}	

    	if(!function_exists('wp_delete_user'))
			include_once(ABSPATH .  'wp-admin/includes/user.php');				

		return wp_delete_user( $uid );
	}		
	
	function bulk_add_users($args)
	{
		$users = new CMSC_User();
	
		$ids = array();		
		foreach($args["users"] as $user) {
			$ids[] = $users->add_user($user);
		}
		return $ids;		
	}		

	function add_category($args)
    {	
		$category = $args['category'];		
		$cat_name = $category['name'];	
		$parent = $category['parent'];	
		
		if(!function_exists('wp_create_category'))
			include_once (ABSPATH . 'wp-admin/includes/taxonomy.php');	
	
		if(empty($cat_name)) {
			return 'Invalid data received.';
		}			

		return wp_create_category( $cat_name, $parent );

	}		
	
    function get_stats($args)
    {	
		// return recent post drafts and comments, upgradeable plugins, core
		$data = array();

        $data["drafts"] = get_posts('post_status=draft&numberposts=5&orderby=modified&order=desc');
		
		// Comments
		$status = "hold";
        $comments = get_comments('status='.$status.'&number=5');
        foreach ($comments as &$comment) {
            $commented_post      = get_post($comment->comment_post_ID);
            $comment->post_title = $commented_post->post_title;
        }		
		$data["comments"] = $comments;

		// Plugins
   		if(!function_exists('get_plugins')){
   			include_once(ABSPATH.'wp-admin/includes/plugin.php');
   		}		
		
		$all_plugins = get_plugins();
		if(is_array($all_plugins) && !empty($all_plugins)){
		
			$upgradeable_plugins = $this->cmsc_get_transient('update_plugins');
			
			if (empty($upgradeable_plugins->response)) {$upgradeable_plugins = array();} else {$upgradeable_plugins = $upgradeable_plugins->response;}

			$br_i = 0;
			foreach($all_plugins as $path => $plugin){	
				if($plugin['Name'] != 'CMS Commander'){		
					if(!empty($upgradeable_plugins[$path])) {
						$plugins[$br_i]['path'] = $path;
						$plugins[$br_i]['name'] = $plugin['Name'];
						$plugins[$br_i]['version'] = $plugin['Version'];
						$plugins[$br_i]['description'] = $plugin['Description'];					
						$plugins[$br_i]['update'] = (array) $upgradeable_plugins[$path];
					}				
					$br_i++;
				}
			}			
		}		
		$data["plugins"] = $plugins;
		
		// Themes
   		if(!function_exists('get_themes')){
   			include_once(ABSPATH.WPINC.'/theme.php');
   		}
		
		$all_themes = get_themes();
		$themes     = array();
		
		if(is_array($all_themes) && !empty($all_themes)) {
		
			$current_theme = get_current_theme();
			
			$upgradeable_themes = $this->cmsc_get_transient('update_themes');
			
			if (empty($upgradeable_themes->response)) {$upgradeable_themes = array();} else {$upgradeable_themes = $upgradeable_themes->response;}			

			$br_i = 0;
			foreach($all_themes as $theme_name => $theme){
				$path = $theme['Template'];				
				if(!empty($upgradeable_themes[$path])) {
					$themes[$br_i]['path'] = $theme['Template'];
					$themes[$br_i]['name'] = strip_tags($theme['Name']);
					$themes[$br_i]['stylesheet'] = $theme['Stylesheet'];
					$themes[$br_i]['description'] = $theme['Description'];
					$themes[$br_i]['version'] = $theme['Version'];				
					$themes[$br_i]['update'] = (array) $upgradeable_themes[$path];				
				}
				$br_i++;			
			}
		}		
		$data["themes"] = $themes;		
		
		// Core
		global $wp_version;
		$core = $this->cmsc_get_transient('update_core');
		if (isset($core->updates) && !empty($core->updates)) {
			$current_transient = $core->updates[0];
			if ($current_transient->response == "development" || version_compare($wp_version, $current_transient->current, '<')) {
				$current_transient->current_version = $wp_version;
				$data['core_updates'] = $current_transient;
			} else {
				$data['core_updates'] = false;
			}	
		} else {
			$data['core_updates'] = false;
		}
		
		// Backups
		$data['backups'] = get_option('cmsc_backup_tasks');
		
		$data['versions'] = CMSC_WORKER_VERSION;
		
		return $data;		

	}
	
    function get_categories()
    {	

		return get_categories(array("hide_empty" => 0));
	}	
	
	function delete_category($args)
    {	
		$cat_id = $args['cat_id'];	
	
		if(!function_exists('wp_delete_category'))
			include_once (ABSPATH . 'wp-includes/taxonomy.php');	
	
		if(empty($cat_id)) {
			return 'Invalid data received.';
		}			

		return wp_delete_category( $cat_id );

	}

    function get_settings()
    {	

		return get_alloptions();
	}	
	
    function save_settings($args)
    {	
		$settings = $args['settings'];	
	
		if(empty($settings) || !is_array($settings)) {
			return 'Invalid data received.';
		}			
	
		foreach($settings as $name => $key) {
			if(!empty($name)) {
				update_option($name, $key);
			}
		}

		return true;
	}

    function get_post($args)
    {	
		$post_id = $args['post_id'];
		if(empty($post_id)) {return false;}
		$catnames = array();
		$cats = wp_get_post_categories( $post_id, $args );
		foreach($cats as $cat) {
			$catnames[] = get_cat_name($cat);
		}
		$post = get_post( $post_id, ARRAY_A );
		$post["categories"] = $catnames;
		return $post;
	}	
	
    function get_posts($args)
    {	

        global $wpdb, $cmsc_wp_version, $cmsc_plugin_dir, $wp_version, $wp_local_package;
		
		$num = $args['num'];
		if(empty($num)) {$num = 10;}
		
        $all_posts = get_posts('post_status=any&numberposts='.$num.'&orderby=modified&order=desc');	// 
		
		return $all_posts;
	}

	function return_site_data($args)
	{
		$data = array();
		
		$data["wpusers"] = $this->get_users($params);
		
		$data["wpcats"] = $this->get_categories($params);		
	
		$data["wpposttypes"] = get_post_types();		
	
		//$tclass = new CMSC_Terms(); 
		//$data["wpposttypes"] = $tclass->get($params);	

		return $data;
	}
	
   function get_themes($args)
   {
   		
   		if(!function_exists('get_themes')){
   			include_once(ABSPATH.WPINC.'/theme.php');
   		}
		
		$all_themes = get_themes();
		$themes     = array();
		
		if(is_array($all_themes) && !empty($all_themes)) {
		
			$current_theme = get_current_theme();
			
			$upgradeable_themes = $this->cmsc_get_transient('update_themes');
			
			if (empty($upgradeable_themes->response)) {$upgradeable_themes = array();} else {$upgradeable_themes = $upgradeable_themes->response;}			

			$br_i = 0;
			foreach($all_themes as $theme_name => $theme){
				$path = $theme['Template'];
				$themes[$br_i]['path'] = $theme['Template'];
				$themes[$br_i]['name'] = strip_tags($theme['Name']);
				$themes[$br_i]['stylesheet'] = $theme['Stylesheet'];
				$themes[$br_i]['description'] = $theme['Description'];
				$themes[$br_i]['version'] = $theme['Version'];
				
				if($current_theme == $theme_name){
					$themes[$br_i]['active'] = 1;
				}	

				if(!empty($upgradeable_themes[$path])) {
					$themes[$br_i]['update'] = (array) $upgradeable_themes[$path];
				}	
				$br_i++;
			}
		}
			
		return array("themes" => $themes);		
   }	

    function get_plugins($args)
    {	

   		if(!function_exists('get_plugins')){
   			include_once(ABSPATH.'wp-admin/includes/plugin.php');
   		}
		
		$all_plugins = get_plugins();
		if(is_array($all_plugins) && !empty($all_plugins)){
			$activated_plugins = get_option('active_plugins');
			if(!$activated_plugins) {$activated_plugins = array();}
		
			$upgradeable_plugins = $this->cmsc_get_transient('update_plugins');
			
			if (empty($upgradeable_plugins->response)) {$upgradeable_plugins = array();} else {$upgradeable_plugins = $upgradeable_plugins->response;}

			$br_i = 0;
			foreach($all_plugins as $path => $plugin){
				if($plugin['Name'] != 'CMS Commander'){	
					$plugins[$br_i]['path'] = $path;
					$plugins[$br_i]['name'] = $plugin['Name'];
					$plugins[$br_i]['version'] = $plugin['Version'];
					$plugins[$br_i]['description'] = $plugin['Description'];
					
					if(in_array($path,$activated_plugins)) {$plugins[$br_i]['active'] = 1;} else {$plugins[$br_i]['active'] = 0;}
		
					if(!empty($upgradeable_plugins[$path])) {
						$plugins[$br_i]['update'] = (array) $upgradeable_plugins[$path];
					}

					$br_i++;
				}
			}			
		}
		
		return array("plugins" => $plugins);
	}

	function update_plugins($args)
	{	
		$installer = new CMSC_Installer();
		
		if(1 == $args['updateall']) {
			$upgrade_plugins = $installer->get_upgradable_plugins();
		} elseif(empty($args['plugins'])) {
			return array('error' => 'No plugin files to upgrade.');		
		} else {
			$plugin_files = $args['plugins'];
		}
	
		if(!empty($upgrade_plugins)){
			$plugin_files = array();
			foreach($upgrade_plugins as $plugin){				
				if(isset($plugin->file))
					$plugin_files[$plugin->file] = $plugin->old_version;
			}
		}

		if(!empty($plugin_files)) {
			$upgrades = $installer->upgrade_plugins($plugin_files);
		} else {
			return array('error' => 'No plugin files to upgrade found.');		
		}		
	
		return $upgrades;
    }
	
	function update_themes($args)
	{
		$installer = new CMSC_Installer();
		
		if(1 == $args['updateall']) {
			$upgrade_themes = $installer->get_upgradable_themes();
		} elseif(empty($args['themes'])) {
			return array('error' => 'No theme files to upgrade.');		
		} else {
			$theme_files = $args['themes'];
		}
	
		if(!empty($upgrade_themes)){
			$theme_files = array();
			foreach($upgrade_themes as $theme){
				if(isset($theme['theme_tmp']))
					$theme_files[] = $theme['theme_tmp'];
			}
		}

		if(!empty($theme_files)) {
			$upgrades = $installer->upgrade_themes($theme_files);
		} else {
			return array('error' => 'No theme files to upgrade found.');		
		}
	
		return $upgrades;
    }
	
	function update_core($args)
	{	
	
		$current = $args['current'];
	
		$installer = new CMSC_Installer();
		return $installer->upgrade_core($current);
	}
	
	function get_backup_results($args)
	{	
		return get_option('cmsc_backup_tasks');
	}	
	
	function bulk_edit($args)
	{	
		include_once ABSPATH . 'wp-admin/includes/taxonomy.php';
		$scount = 0;
		$posts = $args['posts'];
		foreach($posts as $post) {
			$data = get_post( $post, ARRAY_A );
			$new_post = array();
			$new_post['ID'] = (int) $post;	
			
			if(!empty($args['replace']['text'])) {
				$data["post_content"] = str_replace($args['replace']['text'], $args['replace']['with'], $data["post_content"]);	
				$new_post['post_content'] = $data["post_content"];
			}
			
			if(!empty($args['cats']['cats'])) {
				$cats = explode(",", $args['cats']['cats']);
				
				$cat_ids = wp_create_categories($cats);//, $post
				
				if($args['cats']['replace'] == 1) {
					$data['post_category'] = $cat_ids;	
				} else {
					$data['post_category'] = wp_get_post_categories( $post );
					foreach($cat_ids as $cat_id) {
						$data['post_category'][] = $cat_id;
					}
				} 
				$new_post['post_category'] = $data["post_category"];
			}	

			if(!empty($args['tags']['tags'])) {
				$tags = explode(",", $args['tags']['tags']);
				if($args['tags']['replace'] == 1) {
					$data['tags_input'] = $tags;	
				} else {
					$currtags = wp_get_post_tags( $post );
					foreach($currtags as $ctag) {
						$data['tags_input'][] = $ctag->name;
					}
					foreach($tags as $tag) {
						$data['tags_input'][] = $tag;
					}				
				}
				$new_post['tags_input'] = $data['tags_input'];
			}

			if(!empty($args['status'])) {
				if($args['status'] == "publish" || $args['status'] == "draft" || $args['status'] == "private" || $args['status'] == "pending") {
					$new_post['post_status'] = $args['status'];
				}
			}			

			if(!empty($args['link']['keywords'])) {
				if(!empty($new_post['post_content'])) {$data['post_content'] = $new_post['post_content'];}
				$keywords = explode(",", $args['link']['keywords']);
				foreach($keywords as $keyword) {
					preg_match_all("/ ".$keyword." /s", $data["post_content"], $matches);
					foreach($matches[0] as $match) {
						if($args['link']['chance'] >= rand(0, 100)) {
							if($args['link']['newwindow'] == 1) {$newwindow = ' target="_blank"';} else {$newwindow = ' ';}					
							if($args['link']['nofollow'] == 1) {$nofollow = ' rel="nofollow"';} else {$nofollow = ' ';}
							$link = ' <a href="'.$args['link']['url'].'" '.$nofollow.$newwindow.'>'.trim($match).'</a> ';		
							$data["post_content"] = preg_replace('/'.$match.'/', $link, $data["post_content"], 1);
						}
					}
				}
				$new_post['post_content'] = $data['post_content'];
			}
			
			if(!empty($args['content']) && $args['content']['yes'] == 1) {
				if($args['content']['where'] == "end") {
					$data['post_content'] = $data['post_content'] . " " . $args['contents'][$post];
				} else {
					$data['post_content'] = $args['contents'][$post] . " " . $data['post_content'];				
				}
				$new_post['post_content'] = $data['post_content'];
			}			
			
			$res = wp_update_post( $new_post ); // save results
			if($res != 0) {$scount++;}
		}
		return $scount;
	}		
}

function cmsc_ebay_handler($atts, $content = null) {

	$campID = $atts['cid'];	
	
	$lang = $atts['lang'];
	if (empty($lang)) {$lang="en-US";}			
	
	$country = $atts['country'];
	if (empty($country)) {$country=0;}		
	
	$sortby = $atts['sort'];
	if (empty($sortby)) {$sortby="bestmatch";}	
	
	$ebaycat = $atts["ebcat"];
	if (empty($ebaycat) || $ebaycat == "all") {$ebaycat="-1";}		
	
	$number = $atts['num'];
	if(empty($number)) {$number = rand(1,30);}	
	
	$arrFeeds = array();

	require_once ( ABSPATH . WPINC .  '/rss.php' );	

	if($country == 0) {$program = 1;}
	elseif($country == 205) {$program = 2;}
	elseif($country == 16) {$program = 3;}
	elseif($country == 15) {$program = 4;}
	elseif($country == 23) {$program = 5;}
	elseif($country == 2) {$program = 7;}
	elseif($country == 71) {$program = 10;}
	elseif($country == 77) {$program = 11;}
	elseif($country == 101) {$program = 12;}
	elseif($country == 186) {$program = 13;}
	elseif($country == 193) {$program = 14;}
	elseif($country == 3) {$program = 15;}
	elseif($country == 146) {$program = 16;}
	else {$program = $country;}	
	$rssurl= "http://rest.ebay.com/epn/v1/find/item.rss?keyword=" . str_replace(" ","+", ($atts['kw']))."&campaignid=" . urlencode($campID) . "&sortOrder=BestMatch&programid=".$program."";	
	
	if(!empty($ebaycat) && $ebaycat != -1){
		$rssurl.="&categoryId1=".$ebaycat;
	}		
	
	
	$therss = fetch_rss($rssurl);
	
	if($therss->items != "" && $therss->items != null) {
		foreach ($therss->items as $item) { 
			$itemRSS = array (
				'title' => $item['title'],
				'desc' => $item['description'],
				'link' => $item['link'],
				'date' => $item['pubDate']
				);
			array_push($arrFeeds, $itemRSS);
		}
	}

	$ebcontent = "<strong>".$arrFeeds[$number]['title']."</strong>".$arrFeeds[$number]['desc'];	
	if($arrFeeds[$number]['title'] != "") {
	} else {$ebcontent = "";}

	return $ebcontent;
}
add_shortcode('cmsc_ebay', 'cmsc_ebay_handler' );

?>