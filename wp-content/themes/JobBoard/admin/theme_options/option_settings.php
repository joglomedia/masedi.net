<?php
global $table_prefix,$wpdb;
define('OPTIONS_TREE_TABLE_NAME',$table_prefix . 'option_tree');
$options_tree_table_name = OPTIONS_TREE_TABLE_NAME;

add_action( 'after_setup_theme', 'after_setup_theme_option_tree_setup' );
function after_setup_theme_option_tree_setup()
{
	global $wpdb,$options_tree_table_name;
	if($_REQUEST['page']=='templatic_wp_admin_menu')
	{
		// drop table
		$wpdb->query( "DROP TABLE $options_tree_table_name" );
		// create table
		$sql = "CREATE TABLE IF NOT EXISTS $options_tree_table_name (
				  id mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				  item_id VARCHAR(50) NOT NULL,
				  item_title VARCHAR(100) NOT NULL,
				  item_desc LONGTEXT,
				  item_type VARCHAR(30) NOT NULL,
				  item_options VARCHAR(250) DEFAULT NULL,
				  item_sort mediumint(9) DEFAULT '0' NOT NULL,
				  UNIQUE KEY (item_id)
			  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;";
		$wpdb->query($sql);
		$xmlfilename = apply_filters('templ_theme_options_xmlpath_filter',TT_FUNCTIONS_FOLDER_PATH.'theme_options/theme-options.xml');
		if(file_exists($xmlfilename))
		{
			$rawdata = implode('',file($xmlfilename));
		}
		if($rawdata)
		{
			if(!$new_options = new SimpleXMLElement( $rawdata ))
			{
				_e('&quot;simplexmlelement&quot; is not supported under PHP 4.x. Please use version 5 or higher','templatic');
			}
			// insert data
			foreach ( $new_options->row as $value ) 
			{
				$wpdb->insert($options_tree_table_name, 
				  array( 
					'item_id' => $value->item_id,
					'item_title' => $value->item_title,
					'item_desc' => $value->item_desc,
					'item_type' => $value->item_type,
					'item_options' => $value->item_options
				  )
				);
			}
		}
	}
}



add_action('admin_head', 'ajax_option_url_var_func');
function ajax_option_url_var_func()
{
	echo '<script type="text/javascript">var ajax_option_url_var = "'.site_url().'/wp-admin/";</script>';	
}

function temp_option_tree_load() 
{
if($_GET['page']=='templatic_wp_admin_menu' || $_GET['page']=='manage_settings'){
// enqueue styles
wp_enqueue_style( 'option-tree-style',TT_THEME_OPTIONS_FOLDER_URL.'css/option_tree_style.css', false, 1, 'screen');	
// enqueue scripts
add_thickbox();
wp_enqueue_script( 'jquery-table-dnd', TT_THEME_OPTIONS_FOLDER_URL.'js/jquery.table.dnd.js', array('jquery') );
wp_enqueue_script( 'jquery-color-picker', TT_THEME_OPTIONS_FOLDER_URL.'js/jquery.color.picker.js', array('jquery') );
wp_enqueue_script( 'jquery-option-tree', TT_THEME_OPTIONS_FOLDER_URL.'js/jquery.option.tree.js', array('jquery','media-upload','thickbox','jquery-ui-core','jquery-ui-tabs','jquery-table-dnd','jquery-color-picker') );

// remove GD star rating conflicts
wp_deregister_style( 'gdsr-jquery-ui-core' );
wp_deregister_style( 'gdsr-jquery-ui-theme' );
}
}
add_action( 'admin_init', 'temp_option_tree_load'); //adction to add js and css to wp-admin head section

function temp_get_option_tree_informations()
{
	global $wpdb;
	$option_tree_table = OPTIONS_TREE_TABLE_NAME;
	return $wpdb->get_results("select * from $option_tree_table");	
}

if(current_user_can('manage_options'))
{
IF(isset($_REQUEST['ajaxact']) && $_REQUEST['ajaxact'] != ""){
	if($_REQUEST['ajaxact']=='save_options')
	{
		if($_POST)
		{
			foreach($_POST as $key=>$val)
			{
				if(is_array($val))
				{
					foreach($val as $key1=>$val1)
					{
						if(is_array($val1))
						{
							$val12 = implode(',',$val1);	
						}else
						{
							$val12 = $val1;
						}
						if($key1){
							update_option( $key1, $val12 );
						}
					}
				}else
				{
					if($key){update_option( $key, $val );}
				}
			}
		}
		exit;
	}elseif($_REQUEST['ajaxact']=='reset_options')
	{
		$option_tree_info = temp_get_option_tree_informations();
		foreach($option_tree_info as $option_tree_info_obj)
		{
			if($option_tree_info_obj->item_id)
			{
				update_option($option_tree_info_obj->item_id,'');	
			}
		}
	}
	}
}
?>