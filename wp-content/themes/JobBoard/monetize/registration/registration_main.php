<?php
/******************************************************************
=======  PLEASE DO NOT CHANGE BELOW CODE  =====
You can add in below code but don't remove original code.
This code to include registration, login and edit profile page.
This file is included in functions.php of theme root at very last php coding line.

You can call registration, login and edit profile page  by the link 
edit profile : http://mydomain.com/?ptype=profile  => echo site_url().'/?ptype=profile';
registration : http://mydomain.com/?ptype=register => echo site_url().'/?ptype=register';
login : http://mydomain.com/?ptype=login => echo site_url().'/?ptype=login';
logout : http://mydomain.com/?ptype=login&action=logout => echo site_url().'/?ptype=login&action=logout';
********************************************************************/

define('TEMPL_REGISTRATION_FOLDER',TT_MODULES_FOLDER_PATH . "registration/");
define('TEMPL_REGISTRATION_URI',get_bloginfo('template_directory') . "/monetize/registration/");

include_once(TEMPL_REGISTRATION_FOLDER.'registration_language.php'); // language file
////////Conditions to retrive the page HTML from the url.
add_filter('templ_add_template_page_filter','templ_add_template_reg_page');
function templ_add_template_reg_page($template)
{
		if(isset($_REQUEST['ptype']) && $_REQUEST['ptype']!=""){
	if($_REQUEST['ptype']=='profile')
	{
		global $current_user;
		if(!$current_user->ID)
		{
			wp_redirect(get_option('siteurl').'/?ptype=login');
			exit;
		}
		$template = TEMPL_REGISTRATION_FOLDER.'profile.php';
	}else
	if($_REQUEST['ptype'] == 'register' || $_REQUEST['ptype'] == 'login')
	{
		$template =  TEMPL_REGISTRATION_FOLDER . "registration.php";
	}
	}
	return $template;
}

function get_user_nice_name($fname,$lname='')
{
	global $wpdb;
	if($lname)
	{
		$uname = $fname.'-'.$lname;
	}else
	{
		$uname = $fname;
	}
	$nicename = strtolower(str_replace(array("'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," "),array('','','','-','','-','-','','','','','','','','','','-','-',''),$uname));
	$nicenamecount = $wpdb->get_var("select count(user_nicename) from $wpdb->users where user_nicename like \"$nicename\"");
	if($nicenamecount=='0')
	{
		return trim($nicename);
	}else
	{
		$lastuid = $wpdb->get_var("select max(ID) from $wpdb->users");
		return $nicename.'-'.$lastuid;
	}
}
?>