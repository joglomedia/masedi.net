<?php
if(file_exists(TT_MODULES_FOLDER_PATH . 'custom_post_type/custom_post_type_lang.php'))
{
	include_once(TT_MODULES_FOLDER_PATH.'custom_post_type/custom_post_type_lang.php');
}
if(file_exists(TT_MODULES_FOLDER_PATH . 'custom_post_type/custom_post_type.php'))
{
	include_once(TT_MODULES_FOLDER_PATH.'custom_post_type/custom_post_type.php');
}

if(file_exists(TT_MODULES_FOLDER_PATH. 'manage_settings/function_manage_settings.php'))
{
	include_once(TT_MODULES_FOLDER_PATH . 'manage_settings/function_manage_settings.php');
}
if(file_exists(TT_MODULES_FOLDER_PATH . 'general/post_function.php'))
{
	include_once (TT_MODULES_FOLDER_PATH . 'general/post_function.php');
	
}
if(file_exists(TT_MODULES_FOLDER_PATH . 'registration/registration_functions.php'))
{
	include_once(TT_MODULES_FOLDER_PATH . 'registration/registration_functions.php');
	include_once(TT_MODULES_FOLDER_PATH . 'registration/registration_language.php');
}

if(file_exists(TT_MODULES_FOLDER_PATH . 'db_table_creation.php'))
{
	include_once(TT_MODULES_FOLDER_PATH . 'db_table_creation.php');
}
if(file_exists(TT_MODULES_FOLDER_PATH . 'basic_settings.php'))
{
	include_once (TT_MODULES_FOLDER_PATH . 'basic_settings.php');
}


?>