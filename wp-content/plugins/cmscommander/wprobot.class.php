<?php
/*************************************************************
 * Copyright (c) 2011 CMS Commander
 * www.cmscommander.com
 **************************************************************/

class CMSC_WP_Robot extends CMSC_Core
{
    function __construct()
    {
        parent::__construct();
    }	

	function wpr_xmlrpc_get_log($args) {
		global $wpr_table_errors,$wpdb;

		$id   = $args[0];
		$num   = $args[1];
		
		if(empty($wpr_table_errors)) {return 'The <a href="http://wprobot.net/" target="_blank">WP Robot</a> plugin could not be found. Is it installed and activated on this website?';}		
		
		if(!empty($id)) {
			$where = " WHERE campaign = '$id'";
		} else {
			$where = "";	
		}
		
		return $wpdb->get_results("SELECT * FROM " . $wpr_table_errors . "$where ORDER BY id DESC LIMIT $num", "ARRAY_A"); 
	}	
	
	function wpr_xmlrpc_get_next_postdate($args) {
		global $wpr_table_errors,$wpdb;

		$id   = $args[2];

		return date('m/j/Y H:i:s',wp_next_scheduled("wprobothook",array($id)));
	}

	function wpr_xmlrpc_get_campaigns($args) {
		global $wpr_table_campaigns, $wpdb;

		if(empty($wpr_table_campaigns)) {return 'The <a href="http://wprobot.net/" target="_blank">WP Robot</a> plugin could not be found. Is it installed and activated on this website?';}
		
		return $wpdb->get_results("SELECT * FROM " . $wpr_table_campaigns . " ORDER BY id ASC", "ARRAY_A"); 
	}

	function wpr_xmlrpc_get_campaign($args) {
		global $wpr_table_campaigns,$wpdb;

		$id   = $args[0];

		if(empty($wpr_table_campaigns)) {return 'The <a href="http://wprobot.net/" target="_blank">WP Robot</a> plugin could not be found. Is it installed and activated on this website?';}
		
		return $wpdb->get_row("SELECT * FROM " . $wpr_table_campaigns . " WHERE id = '$id' ORDER BY id ASC", "ARRAY_A");	
	}

	function wpr_xmlrpc_get_options($args) {

		$options = unserialize(get_option("wpr_options"));
		
		if(empty($options)) {return 'The <a href="http://wprobot.net/" target="_blank">WP Robot</a> plugin could not be found. Is it installed and activated on this website?';}
				
		$options["wpr_cloak"] = get_option("wpr_cloak");
		return $options;
	}	

	function wpr_xmlrpc_get_post_templates($args) {
		global $wpr_table_templates,$wpdb;
		
		if(empty($wpr_table_templates)) {return 'The <a href="http://wprobot.net/" target="_blank">WP Robot</a> plugin could not be found. Is it installed and activated on this website?';}						
		
		return $wpdb->get_results("SELECT * FROM " . $wpr_table_templates . " WHERE type = 'post' ORDER BY id DESC", "ARRAY_A"); 	
	}
		
	function wpr_xmlrpc_get_module_templates($args) {
		global $wpr_table_templates,$wpdb;
		
		if(empty($wpr_table_templates)) {return 'The <a href="http://wprobot.net/" target="_blank">WP Robot</a> plugin could not be found. Is it installed and activated on this website?';}						

		return $wpdb->get_results("SELECT * FROM " . $wpr_table_templates . " WHERE type != 'post' ORDER BY type ASC", "ARRAY_A"); 
	}	
		
	function wpr_xmlrpc_edit_options($args) {
		global $wpr_modules;

		$_POST = $args[0];
		
		$options = unserialize(get_option("wpr_options"));

		$options['wpr_resetcount'] = $_POST['wpr_resetcount'];
		$options['wpr_autotag'] = $_POST['wpr_autotag'];
		$options['wpr_badwords'] = $_POST['wpr_badwords'];
		$options['wpr_randomize'] = $_POST['wpr_randomize'];
		$options['wpr_randomize_comments'] = $_POST['wpr_randomize_comments'];
		$options['wpr_help'] = $_POST['wpr_help'];
		$options['wpr_poststatus'] = $_POST['wpr_poststatus'];
		$options['wpr_cb_affkey'] = $_POST['wpr_cb_affkey'];		
		$options['wpr_cb_filter'] = $_POST['wpr_cb_filter'];	
		$options['wpr_openlinks'] = $_POST['wpr_openlinks'];
		$options['wpr_authorid'] = $_POST['wpr_authorid'];	
		$options['wpr_err_retries'] = $_POST['wpr_err_retries'];
		$options['wpr_err_maxerr'] = $_POST['wpr_err_maxerr'];
		$options['wpr_err_minmod'] = $_POST['wpr_err_minmod'];	
		$options['wpr_err_disable'] = $_POST['wpr_err_disable'];
		$options["wpr_global_exclude"] = $_POST['wpr_global_exclude'];
		$options['wpr_check_unique_old'] = $_POST['wpr_check_unique_old'];
		$options['wpr_simple'] = $_POST['wpr_simple'];
		//$options['wpr_rewrite_active'] = $_POST['wpr_rewrite_active'];	
		$options['wpr_rewrite_active_tbs'] = $_POST['wpr_rewrite_active_tbs'];
		$options['wpr_rewrite_active_sc'] = $_POST['wpr_rewrite_active_sc'];
		$options['wpr_rewrite_active_schimp'] = $_POST['wpr_rewrite_active_schimp'];
		$options['wpr_rewrite_active_ucg'] = $_POST['wpr_rewrite_active_ucg'];	
		$options['wpr_rewrite_active_sr'] = $_POST['wpr_rewrite_active_sr'];	
		$options['wpr_rewrite_email'] = $_POST['wpr_rewrite_email'];
		$options['wpr_rewrite_key'] = $_POST['wpr_rewrite_key'];
		$options['wpr_rewrite_level'] = $_POST['wpr_rewrite_level'];
		$options['wpr_save_images'] = $_POST['wpr_save_images'];
		$options['wpr_tbs_rewrite_email'] = $_POST['wpr_tbs_rewrite_email'];
		$options['wpr_tbs_rewrite_pw'] = $_POST['wpr_tbs_rewrite_pw'];	
		$options['wpr_tbs_spintxt'] = $_POST['wpr_tbs_spintxt'];	
		$options['wpr_tbs_quality'] = $_POST['wpr_tbs_quality'];
		$options['wpr_tbs_rewrite_title'] = $_POST['wpr_tbs_rewrite_title'];
		$options['wpr_rewrite_protected'] = $_POST['wpr_rewrite_protected'];
		$options['wpr_sc_rewrite_email'] = $_POST['wpr_sc_rewrite_email'];
		$options['wpr_sc_rewrite_pw'] = $_POST['wpr_sc_rewrite_pw'];
		$options['wpr_sc_quality'] = $_POST['wpr_sc_quality'];
		$options['wpr_sc_port'] = $_POST['wpr_sc_port'];
		$options['wpr_sc_thesaurus'] = $_POST['wpr_sc_thesaurus'];
		$options['wpr_schimp_rewrite_email'] = $_POST['wpr_schimp_rewrite_email'];
		$options['wpr_schimp_rewrite_pw'] = $_POST['wpr_schimp_rewrite_pw'];
		$options['wpr_schimp_quality'] = $_POST['wpr_schimp_quality'];	
		$options['wpr_sr_rewrite_email'] = $_POST['wpr_sr_rewrite_email'];	
		$options['wpr_sr_rewrite_pw'] = $_POST['wpr_sr_rewrite_pw'];	
		$options['wpr_sr_quality'] = $_POST['wpr_sr_quality'];	
		$options['wpr_trans_use_proxies'] = $_POST['wpr_trans_use_proxies'];	
		$options['wpr_trans_proxies'] = $_POST['wpr_trans_proxies'];	
		foreach($wpr_modules as $module) {
			$function = "wpr_".$module."_options_default";
			if(function_exists($function)) {
				$moptions = $function();
				foreach($moptions as $moption => $default) {
					$options[$moption] = $_POST[$moption];
				}
			}
		}
		update_option("wpr_options", serialize($options));	
		update_option('wpr_cloak',$_POST['wpr_cloak']);
		return true;	
	}	
		
	function wpr_xmlrpc_create_campaign($args) {
		global $wpr_modules;

		$_POST = $args[0];

		if(!function_exists("wpr_create_campaign")) {return 'The <a href="http://wprobot.net/" target="_blank">WP Robot</a> plugin could not be found. Is it installed and activated on this website?';}
		
		wpr_create_campaign();
	}	
		
	function wpr_xmlrpc_bulk_update($args) {
		global $wpdb, $wpr_table_campaigns, $wpr_table_templates,$wpr_loadedmodules, $wpr_modules;

		$_POST = $args[2];

		$options = unserialize(get_option("wpr_options"));	
		
		if($options['wpr_simple']=='Yes') {
			$totalchance = 0;
			foreach($wpr_loadedmodules as $lmodule) {
				if($_POST[$lmodule."chance"] > 0) {
					$totalchance = $totalchance + $_POST[$lmodule."chance"];
				}
			}	
				if($_POST["mixchance"] > 0) {
					$totalchance = $totalchance + $_POST["mixchance"];
				}		
		} else {
			for ($i = 1; $i <= $_POST['tnum']; $i++) {
				if($_POST["chance$i"] > 0) {
					$totalchance = $totalchance + $_POST["chance$i"];
				}
			}
		}
			
		if($_POST['title1'] == "" && $options['wpr_simple']!='Yes' || $_POST['content1'] == "" && $options['wpr_simple']!='Yes' || $_POST['chance1'] == "" && $options['wpr_simple']!='Yes') {
			return "2";
		} elseif($_POST['amazon_department'] == "All" && $_POST['type'] == "nodes") {
			return "3";
		} elseif($totalchance != 100 && $options['wpr_simple']=='Yes' && $_POST['type'] == "keyword") {
			return "4";
		} elseif($totalchance != 100 && $options['wpr_simple']!='Yes') {
			return "5";
		} elseif($_POST["mixchance"] > 0 && $options['wpr_simple']=='Yes' && empty($_POST["mixcontent"]) && $_POST['type'] == "keyword") {	
			return "6";
		} else {

			$type = $_POST['type'];

			// Templates
			if($_POST['massedit_templates'] == "1") {
				$templates = array();
				if($options['wpr_simple']=='Yes' && $type == "keyword") {
					$i = 1;
					foreach($wpr_loadedmodules as $lmodule) {
						if($_POST[$lmodule."chance"] > 0) {
							$templates[$i]["title"] = "{".$lmodule."title}";
							$templates[$i]["content"] = "{".$lmodule."}";
							if($lmodule == "ebay" || $lmodule == "yahoonews") {$templates[$i]["content"] .= "\n{".$lmodule."}\n{".$lmodule."}";}
							$templates[$i]["chance"] = $_POST[$lmodule."chance"];
							if($lmodule == "amazon") {$templates[$i]["comments"]["amazon"] = 1;} else {$templates[$i]["comments"]["amazon"] = 0;}
							if($lmodule == "flickr") {$templates[$i]["comments"]["flickr"] = 1;} else {$templates[$i]["comments"]["flickr"] = 0;}
							if($lmodule == "yahooanswers") {$templates[$i]["comments"]["yahooanswers"] = 1;} else {$templates[$i]["comments"]["yahooanswers"] = 0;}
							if($lmodule == "youtube") {$templates[$i]["comments"]["youtube"] = 1;} else {$templates[$i]["comments"]["youtube"] = 0;}
							$i++;
						}
					}
					if($_POST["mixchance"] > 0) {
						$templates[$i]["title"] = "{title}";
						$templates[$i]["content"] = stripslashes($_POST["mixcontent"]);
						$templates[$i]["chance"] = $_POST["mixchance"];		
						$templates[$i]["comments"]["amazon"] = 1;
						$templates[$i]["comments"]["flickr"] = 1;
						$templates[$i]["comments"]["yahooanswers"] = 1;
						$templates[$i]["comments"]["youtube"] = 1;				
					}
				} else {
					for ($i = 1; $i <= $_POST['tnum']; $i++) {
						if($_POST["chance$i"] > 0) {
							$templates[$i]["title"] = stripslashes($_POST["title$i"]);
							$templates[$i]["content"] = stripslashes($_POST["content$i"]);
							$templates[$i]["chance"] = $_POST["chance$i"];
							$templates[$i]["comments"]["amazon"] = $_POST["comments_amazon$i"];
							$templates[$i]["comments"]["flickr"] = $_POST["comments_flickr$i"];
							$templates[$i]["comments"]["yahooanswers"] = $_POST["comments_yahoo$i"];
							$templates[$i]["comments"]["youtube"] = $_POST["comments_youtube$i"];
						}
					}
				}
				$templates = $wpdb->escape(serialize($templates));
			}
			
			// Optional settings
			if($_POST['massedit_optional'] == "1") {		
				$amadept = $_POST['amazon_department'];

				$yahoocat = array();
				$yahoocat["ps"] = $_POST['wpr_poststatus'];
				$yahoocat["rw"] = $_POST['wpr_rewriter'];
				$yahoocat = $wpdb->escape(serialize($yahoocat));
				
				$ebaycat = $_POST['ebay_category'];
				
				$_POST['replace'] = stripslashes($_POST['replace']);
				$replaceinput = str_replace("\r", "", $_POST['replace']);
				$replaceinput = explode("\n", $replaceinput);    
				
				$i=0;
				$replaces = array();
				foreach( $replaceinput as $replace) {
					if($replace != "") {
						$replace = explode("|", $replace);  
						$replaces[$i]["from"] = $replace[0];
						$replaces[$i]["to"] = str_replace('\"', "", $replace[1]);
						$replaces[$i]["chance"] = $replace[2];
						$replaces[$i]["code"] = $replace[3];
					}
					$i++;
				}
				$replaces = $wpdb->escape(serialize($replaces));	
				
				$_POST['exclude'] = stripslashes($_POST['exclude']);
				$exclude = str_replace("\r", "", $_POST['exclude']);
				$exclude = explode("\n", $exclude);
				foreach($exclude as $key => $value) {
					if($value == "") {
						unset($array[$key]);
					}
				}
				$exclude = array_values($exclude); 
				$exclude = $wpdb->escape(serialize($exclude));
				
				$name = $_POST['name'];
				$postevery = $_POST['interval'];
				$cr_period = $_POST['period'];
				$postspan = "WPR_" . $postevery . "_" . $cr_period;	
				
				$customfield = array();
				for ($i = 1; $i <= $_POST['cfnum']; $i++) {
					if(!empty($_POST["cf_value$i"]) && !empty($_POST["cf_name$i"])) {
						$customfield[$i]["name"] = $_POST["cf_name$i"];
						$customfield[$i]["value"] = $_POST["cf_value$i"];
					}
				}
				$customfield = $wpdb->escape(serialize($customfield));
				
				$translation = array();
				$translation["chance"] = $_POST['transchance'];
				$translation["from"] = $_POST['trans1'];
				$translation["to1"] = $_POST['trans2'];
				$translation["to2"] = $_POST['trans3'];
				$translation["to3"] = $_POST['trans4'];
				$translation["comments"] = $_POST['trans_comments'];
				$translation = $wpdb->escape(serialize($translation));
			}
			
			$update = "UPDATE " . $wpr_table_campaigns . " SET ";
			
			if($_POST['massedit_templates'] == "1") {
				$update .= "templates = '$templates'";
			}
			if($_POST['massedit_optional'] == "1") {
				if($_POST['massedit_templates'] == "1") {$update .= ", ";}
				$update .= "replacekws = '$replaces', excludekws = '$exclude', amazon_department = '$amadept', ebay_cat = '$ebaycat', yahoo_cat = '$yahoocat', translation = '$translation', customfield = '$customfield'";
			}	

			$update .= "WHERE ctype = '$type'";

			$results = $wpdb->query($update);
			if ($results) {
				return "1";
			} else {
				return "0";
			}			
		}	
	}
		
	function wpr_xmlrpc_campaign_controls($args) {

		$_POST = $args[0];
		$_GET = $args[1];

		if(!function_exists("wpr_campaign_controls")) {return 'The <a href="http://wprobot.net/" target="_blank">WP Robot</a> plugin could not be found. Is it installed and activated on this website?';}

		wpr_campaign_controls();
	}
		
	function wpr_xmlrpc_single_campaign_controls($args) {

		$_POST = $args[2];
		$_GET = $args[3];

		wpr_single();
	}	
		
	function wpr_xmlrpc_edit_module_templates($args) {
		global $wpr_table_templates, $wpdb;

		if(empty($wpr_table_templates)) {return 'The <a href="http://wprobot.net/" target="_blank">WP Robot</a> plugin could not be found. Is it installed and activated on this website?';}
		
		$_POST = $args[0];
		$_GET = $args[1];
		
		if($_POST['tmodsave']) {	
			for ($i = 0; $i <= $_POST['modnum']; $i++) {
				$content = $_POST[$i."c"];
				$type = $_POST[$i."type"];
				$sql = "UPDATE " . $wpr_table_templates . " SET `content` = '".$content."' WHERE `type` = '".$type."'";
				$results = $wpdb->query($sql);			
			}		
			if($results === false) {return false;} else {return true;}
		}
	}	
		
	function wpr_xmlrpc_edit_post_templates($args) {
		global $wpr_table_templates, $wpdb;

		if(empty($wpr_table_templates)) {return 'The <a href="http://wprobot.net/" target="_blank">WP Robot</a> plugin could not be found. Is it installed and activated on this website?';}		
		
		$_POST = $args[0];
		$_GET = $args[1];		
		
		$tids = explode(",",$_POST["tids"]);
		 foreach ($tids as $tid) { 
			$i = $tid;
			if($_POST["tsave$i"]) {$id = $i;} else {$tsave = false;}
			if($_POST["tdelete$i"]) {$id = $i;} else {$tdelete = false;}
			if($_POST["tcopy$i"]) {$id = $i;} else {$tcopy = false;}		
		}
		
		if($_POST['saveall']){
		
			if($_POST['deleteall']){
				// delete old templates
				$results = $wpdb->query("DELETE FROM $wpr_table_templates WHERE type = 'post'");			
			}
			
			$esql = "INSERT INTO ".$wpr_table_templates." ( type, content, title, name, comments_amazon, comments_flickr, comments_yahoo, comments_youtube ) VALUES";

			foreach ($tids as $tid) { 
				$id = $tid;
				$content = stripslashes($wpdb->escape($_POST["tcontent$id"]));
				$title = $wpdb->escape($_POST["ttitle$id"]);
				$name = $wpdb->escape($_POST["tname$id"]);
				$comments_amazon = $wpdb->escape($_POST["comments_amazon$id"]);
				$comments_yahoo = $wpdb->escape($_POST["comments_yahoo$id"]);
				$comments_flickr = $wpdb->escape($_POST["comments_flickr$id"]);
				$comments_youtube = $wpdb->escape($_POST["comments_youtube$id"]);
				$esql .= " ( 'post', '$content', '$title', '$name', '$comments_amazon', '$comments_flickr', '$comments_yahoo', '$comments_youtube' ),";
				
			}
			$esql = substr_replace($esql ,";",-1);
			$results = $wpdb->query($esql);	
			if($results === false) {return false;} else {return true;}	
		}

		if($_POST["tsave$id"]){
			$content = $_POST["tcontent$id"];
			$title = $_POST["ttitle$id"];
			$name = $_POST["tname$id"];
			$comments_amazon = $_POST["comments_amazon$id"];
			$comments_yahoo = $_POST["comments_yahoo$id"];
			$comments_flickr = $_POST["comments_flickr$id"];
			$comments_youtube = $_POST["comments_youtube$id"];
			$sql = "UPDATE " . $wpr_table_templates . " SET `content` = '".$content."',`title` = '".$title."',`name` = '".$name."',`comments_amazon` = '".$comments_amazon."',`comments_flickr` = '".$comments_flickr."',`comments_yahoo` = '".$comments_yahoo."',`comments_youtube` = '".$comments_youtube."' WHERE `id` = '".$id."'";

			$results = $wpdb->query($sql);	
			if($results === false) {return false;} else {return true;}
		}
		
		if($_POST["tdelete$id"]){
			$sql = "DELETE FROM " . $wpr_table_templates . " WHERE `id` = '".$id."'";
			$results = $wpdb->query($sql);	
			if($results === false) {return false;} else {return true;}
		}	
		
		if($_POST["tcopy$id"]){
			$templ = $wpdb->get_row("SELECT * FROM " . $wpr_table_templates . " WHERE `id` = '".$id."'");
			$content = $templ->content;
			$type = $templ->type;
			$title = $templ->title;
			$name = $templ->name;
			$comments_amazon = $templ->comments_amazon;
			$comments_yahoo = $templ->comments_yahoo;
			$comments_flickr = $templ->comments_flickr;
			$comments_youtube = $templ->comments_youtube;
			$sql = "INSERT INTO " . $wpr_table_templates . " SET type = '$type', content = '$content',`title` = '".$title."',`name` = '".$name."',`comments_amazon` = '".$comments_amazon."',`comments_flickr` = '".$comments_flickr."',`comments_yahoo` = '".$comments_yahoo."',`comments_youtube` = '".$comments_youtube."'";
			$results = $wpdb->query($sql);	
			if($results === false) {return false;} else {return true;}	
		}		
	}	
	
}

?>