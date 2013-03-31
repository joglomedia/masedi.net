<?php
define('TEMPL_FRAMWORK_CHANGE_LOG_PATH','http://templatic.com/updates/change_log.txt');
define('TEMPL_FRAMWORK_ZIP_FOLDER_PATH','http://templatic.com/updates/framework.zip');
define('TEMPL_FRAMWORK_CURRENT_VERSION','1.0.2');
define('TT_FRAMEWORK_FOLDER_PATH',TT_ADMIN_FOLDER_PATH);
include_once(TT_ADMIN_FOLDER_PATH.'functions/custom_functions.php');
include_once(TT_ADMIN_FOLDER_PATH.'functions/hooks.php');
include_once(TT_ADMIN_FOLDER_PATH.'functions/tpl_control.php');
//include_once (TT_ADMIN_FOLDER_PATH . 'breadcrumbs/yoast-breadcrumbs.php'); //BREAD CRUMS RELATED FILE FOR FRONT END


if(is_wp_admin())
{
	include_once(TT_ADMIN_FOLDER_PATH.'admin_menu.php');
	if((strtolower(get_option('ptthemes_use_third_party_data'))=='no' || !get_option('ptthemes_use_third_party_data')) && (strtolower(get_option('pttheme_seo_hide_fields'))=='no' || !get_option('pttheme_seo_hide_fields')))
	{
		include_once(TT_ADMIN_FOLDER_PATH.'seo_settings.php');
	}
	if(file_exists(TT_ADMIN_FOLDER_PATH . 'theme_options/option_settings.php'))
	{
		include_once(TT_ADMIN_FOLDER_PATH . 'theme_options/option_settings.php');
	}
	if(file_exists(TT_ADMIN_FOLDER_PATH . 'theme_options/functions/functions.load.php'))
	{
		include_once(TT_ADMIN_FOLDER_PATH.'theme_options/functions/functions.load.php');
	}
}
?>