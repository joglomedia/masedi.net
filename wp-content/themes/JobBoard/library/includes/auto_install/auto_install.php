<?php if(get_option('ptthemes_auto_install')=='No' || get_option('ptthemes_auto_install')=='')
{
global $wpdb;

 $wp_user_roles_arr = get_option($wpdb->prefix.'user_roles');

if(strstr($_SERVER['REQUEST_URI'],'/themes.php') )
{
$wp_user_roles_arr['Job Provider'] = array(
							"name"	=> "Job Provider",
							"capabilities" => array
												(
													"read" => 1,
													"level_0" => 1,
												)

							);

update_option($wpdb->prefix.'user_roles', $wp_user_roles_arr);
$wp_user_roles_arr = get_option($wpdb->prefix.'user_roles');
}

function autoinstall_admin_header()
	{
		global $wpdb;
		if(strstr($_SERVER['REQUEST_URI'],'themes.php') && $_REQUEST['template']=='' && $_GET['page']=='') 
		{
			
			if($_REQUEST['dummy']=='del')
			{
				delete_dummy_data();	
				$dummy_deleted = '<p><b>All Dummy data has been removed from your database successfully!</b></p>';
			}
			if($_REQUEST['dummy_insert'])
			{
				require_once (TEMPLATEPATH . '/library/includes/auto_install/auto_install_data.php');
			}
			if($_REQUEST['activated']=='true')
			{
				$theme_actived_success = '<p class="message">Theme activated successfully.</p>';	
			}
			$post_counts = $wpdb->get_var("select count(post_id) from $wpdb->postmeta where (meta_key='pt_dummy_content' || meta_key='tl_dummy_content') and meta_value=1");
			if($post_counts>0)
			{
				$dummy_data_msg = '<p> <b>Sample data has been populated on your site. Wish to delete sample data?</b> <br />  <a class="button_delete" href="'.get_option('siteurl').'/wp-admin/themes.php?dummy=del">Yes Delete Please!</a><p>';
			}else
			{
				$dummy_data_msg = '<p> <b>Would you like to auto install this theme and populate sample data on your site?</b> <br />  <a class="button_insert" href="'.get_option('siteurl').'/wp-admin/themes.php?dummy_insert=1">Yes, insert sample data please</a></p>';
			}
	
	
			define('THEME_ACTIVE_MESSAGE','
		<style>
		.highlight { width:60% !important; background:#FFFFE0 !important; overflow:hidden; display:table; border:2px solid #558e23 !important; padding:15px 20px 0px 20px !important; -moz-border-radius:11px  !important;  -webkit-border-radius:11px  !important; } 
		.highlight p { color:#444 !important; font:15px Arial, Helvetica, sans-serif !important; text-align:center;  } 
		.highlight p.message { font-size:13px !important; }
		.highlight p a { color:#ff7e00; text-decoration:none !important; } 
		.highlight p a:hover { color:#000; }
		.highlight p a.button_insert 
			{ display:block; width:230px; margin:10px auto 0 auto;  background:#5aa145; padding:10px 15px; color:#fff; border:1px solid #4c9a35; -moz-border-radius:5px;  -webkit-border-radius:5px;  } 
		.highlight p a:hover.button_insert { background:#347c1e; color:#fff; border:1px solid #4c9a35;   } 
		.highlight p a.button_delete 
			{ display:block; width:140px; margin:10px auto 0 auto; background:#dd4401; padding:10px 15px; color:#fff; border:1px solid #9e3000; -moz-border-radius:5px;  -webkit-border-radius:5px;  } 
		.highlight p a:hover.button_delete { background:#c43e03; color:#fff; border:1px solid #9e3000;   } 
		#message0 { display:none !important;  }
		</style>
		
		<div class="updated highlight fade"> '.$theme_actived_success.$dummy_deleted.$dummy_data_msg.'</div>');
			echo THEME_ACTIVE_MESSAGE;
			
		}
	}
	
	add_action("admin_head", "autoinstall_admin_header"); // please comment this line if you wish to DEACTIVE SAMPLE DATA INSERT.

	function delete_dummy_data()
	{
		global $wpdb;
		delete_option('sidebars_widgets'); //delete widgets
		$productArray = array();
		$pids_sql = "select p.ID from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where (meta_key='pt_dummy_content' || meta_key='tl_dummy_content' || meta_key='auto_install') and (meta_value=1 || meta_value='auto_install')";
		$pids_info = $wpdb->get_results($pids_sql);
		foreach($pids_info as $pids_info_obj)
		{
			wp_delete_post($pids_info_obj->ID);
		}
	}
	
if(1) // set "0" if you wan to disable auto expiry property
{
global $table_prefix, $wpdb;
$table_name = $table_prefix . "job_expire_session";
$current_date = date('Y-m-d');
if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name)
{
   global $table_prefix, $wpdb,$table_name;
   $sql = 'DROP TABLE `' . $table_name . '`';  // drop the existing table
   mysql_query($sql);

	$sql = 'CREATE TABLE `'.$table_name.'` (
			`session_id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`execute_date` DATE NOT NULL ,
			`is_run` TINYINT( 4 ) NOT NULL DEFAULT "0"
			) ENGINE = MYISAM ;';
   mysql_query($sql);
}
$today_executed = $wpdb->get_var("select session_id from $table_name where execute_date=\"$current_date\"");
if($today_executed && $today_executed>0)
{
}else
{

	$postid_str = $wpdb->get_var("select group_concat(p.ID) from $wpdb->posts p where p.post_type='post' and p.post_status='publish' and datediff(\"$current_date\",date_format(p.post_date,'%Y-%m-%d')) > (select meta_value from $wpdb->postmeta pm where post_id=p.ID  and meta_key='alive_days')");

	if($postid_str)
	{
		$wpdb->query("update $wpdb->posts set post_status='draft' where ID in ($postid_str)");
	}
$wpdb->query("insert into $table_name (execute_date,is_run) values (\"$current_date\",'1')");
}
}

}
?>