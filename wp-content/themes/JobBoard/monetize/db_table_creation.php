<?php
global $wpdb,$table_prefix;

if(!get_option('ptthemes_page_layout'))
{
add_option('ptthemes_page_layout','Right Sidebar'); }

if(!get_option('ptthemes_notification_type'))
{
add_option('ptthemes_notification_type','PHP Mail'); }
if(!get_option('ptthemes_customcss'))
{
add_option('ptthemes_customcss','Deactivate'); }
if(!get_option('ptthemes_top_pages_nav_enable'))
{
add_option('ptthemes_top_pages_nav_enable','Activate'); }
if(!get_option('ptthemes_category_noindex'))
{
add_option('ptthemes_category_noindex','No'); }
if(!get_option('ptthemes_archives_noindex'))
{
add_option('ptthemes_archives_noindex','No'); }
if(!get_option('ptthemes_tag_archives_noindex'))
{
add_option('ptthemes_tag_archives_noindex','No'); }
if(!get_option('ptthemes_captcha_dislay')){
add_option('ptthemes_captcha_dislay','None of them'); }

if(get_option('ptthemes_logo_url') ==''){
add_option("ptthemes_logo_url",get_template_directory_uri()."/images/logo.png");
}

if(get_option('approve_status') ==''){
add_option("approve_status","publish");
}

if(!get_option('pttthemes_milestone')){
update_option("pttthemes_milestone","1,5,10,100,1000,5000");
}

if(!get_option('ptthemes_package_type')){
update_option("ptthemes_package_type","Listing as per subscriptions");
}

if(get_option('ptthemes_map_width') ==''){
update_option("ptthemes_map_width","976");
}
if(get_option('ptthemes_map_height') ==''){
update_option("ptthemes_map_height","500");
}
if(get_option('ptthemes_map_latitude') ==''){
update_option("ptthemes_map_latitude","20");
}
if(get_option('ptthemes_map_longitude') ==''){
update_option("ptthemes_map_longitude","0");
}
if(get_option('pttthemes_maptype') ==''){
update_option("pttthemes_maptype","TERRAIN");
}
if(get_option('ptthemes_map_display') ==''){
update_option("ptthemes_map_display","Fit all available listing");
}
if(get_option('ptthemes_is_allow_ssl') ==''){
update_option("ptthemes_is_allow_ssl","No");
}
if(get_option('pt_show_postajoblink') ==''){
update_option("pt_show_postajoblink","Yes");
}
if(get_option('pt_show_postaresumelink') ==''){
update_option("pt_show_postaresumelink","Yes");
}

if(get_option('ptttheme_enable_radius_search') ==''){
update_option("ptttheme_enable_radius_search","Yes");
}

if(get_option('ptthemes_show_blog_title') ==''){
update_option("ptthemes_show_blog_title","No");
}
if(get_option('ptthemes_auto_install') ==''){
update_option("ptthemes_auto_install","No");
}
if(get_option('ptthemes_noindex_category') ==''){
update_option("ptthemes_noindex_category","Yes");
}
if(get_option('ptthemes_archives_noindex') ==''){
update_option("ptthemes_archives_noindex","Yes");
}
if(get_option('ptthemes_noindex_tag') ==''){
update_option("ptthemes_noindex_tag","Yes");
}
if(get_option('ptthemes_use_third_party_data') ==''){
update_option("ptthemes_use_third_party_data","Yes");
}
if(get_option('pttheme_seo_hide_fields') ==''){
update_option("pttheme_seo_hide_fields","Yes");
}

if(get_option('ptttheme_currency_code') ==''){
update_option("ptttheme_currency_code","USD");
}

if(get_option('ptttheme_currency_symbol') ==''){
update_option("ptttheme_currency_symbol","$");
}

if(get_option('ptttheme_currency_position') ==''){
update_option("ptttheme_currency_position","Symbol Before amount");
}

if(get_option('ptthemes_email_on_detailpage') ==''){
update_option("ptthemes_email_on_detailpage","Yes");
}

if(get_option('ptthemes_related_job') ==''){
update_option("ptthemes_related_job","5");
}

if(get_option('pt_show_postacomment') ==''){
update_option("pt_show_postacomment","Yes");
}

if(get_option('ptthemes_print') ==''){
update_option("ptthemes_print","Yes");
}

if(get_option('ptthemes_share') ==''){
update_option("ptthemes_share","Yes");
}

if(get_option('ptthemes_rss') ==''){
update_option("ptthemes_rss","Yes");
}

if(get_option('pt_position_filled') ==''){
update_option("pt_position_filled","Position:Filled");
}

if(get_option('ptthemes_other_job') ==''){
update_option("ptthemes_other_job","3");
}

if(get_option('ptttheme_fb_opt') ==''){
update_option("ptttheme_fb_opt","No");
}

if(get_option('date_format') ==''){
update_option("date_format","j M, Y");
}

if(get_option('ptthemes_customcss') ==''){
update_option("ptthemes_customcss","Deactivate");
}

if(get_option('ptthemes_captcha_dislay_resume') ==''){
update_option("ptthemes_captcha_dislay_resume","No");
}

if(get_option('ptthemes_other_job_display') ==''){
update_option("ptthemes_other_job_display","Yes");
}
if(get_option('post_type_export') ==''){
	update_option('post_type_export','post');
}

if(get_option('ptthemes_listing_ex_status') ==''){
	update_option('ptthemes_listing_ex_status','draft');
}

if(get_option('listing_email_notification') ==''){
	update_option('listing_email_notification','5');
}

if(get_option('ptthemes_show_menu') ==''){
update_option("ptthemes_show_menu",'Yes');
}

if(get_option('pttthemes_milestone_unit') ==''){
update_option("pttthemes_milestone_unit",'Miles');
}

/* Custom Post Field TABLE Creation BOF */
$custom_post_meta_db_table_name = strtolower($table_prefix . "templatic_custom_post_fields");
global $custom_post_meta_db_table_name,$wpdb ;
//$wpdb->query("DROP TABLE $custom_post_meta_db_table_name");
if($wpdb->get_var("SHOW TABLES LIKE \"$custom_post_meta_db_table_name\"") != $custom_post_meta_db_table_name){
$wpdb->query("CREATE TABLE IF NOT EXISTS $custom_post_meta_db_table_name (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `post_type` varchar(255) NOT NULL,
  `admin_title` varchar(255) NOT NULL,
  `field_category` varchar(118) NOT NULL ,
  `htmlvar_name` varchar(255) NOT NULL,
  `admin_desc` text NOT NULL,
  `site_title` varchar(255) NOT NULL,
  `ctype` varchar(255) NOT NULL COMMENT 'text,checkbox,date,radio,select,textarea,upload',
  `default_value` text NOT NULL,
  `option_values` text NOT NULL,
  `clabels` text NOT NULL,
  `sort_order` int(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT '1',
  `is_search` tinyint(4) NOT NULL DEFAULT '1',
  `is_delete` tinyint(4) NOT NULL DEFAULT '0',
  `is_edit` tinyint(4) NOT NULL DEFAULT '1',
  `is_require` tinyint(4) NOT NULL DEFAULT '0',
  `show_on_page` varchar(20) NOT NULL ,
  `show_on_listing` tinyint(4) NOT NULL DEFAULT '1',
  `show_on_detail` tinyint(4) NOT NULL DEFAULT '1',
  `field_require_desc` text NOT NULL,
  `style_class` varchar(200) NOT NULL,
  `extra_parameter` text NOT NULL,
  `validation_type` varchar(20) NOT NULL,
  `extrafield1` text NOT NULL,
  `extrafield2` text NOT NULL,
  PRIMARY KEY (`cid`)
);");
global $wpdb;
$ins = "INSERT INTO $custom_post_meta_db_table_name (`cid`, `post_type`, `admin_title`, `field_category`, `htmlvar_name`, `admin_desc`, `site_title`, `ctype`, `default_value`, `option_values`, `clabels`, `sort_order`, `is_active`,`is_search`, `is_delete`, `is_edit`, `is_require`, `show_on_page`, `show_on_listing`, `show_on_detail`, `field_require_desc`, `style_class`, `extra_parameter`, `validation_type`, `extrafield1`, `extrafield2`) VALUES
(1, 'job', 'Company Name', '0', 'company_name', '', 'Company Name', 'text', '', '', 'Company Name', 1, 1, 1, 0, 1, 1, 'both_side', 0, 1, 'Please Enter Company Name', '', '', 'require', '', ''),
(2, 'job', 'Company Website', '0', 'company_web', '', 'Company Website', 'text', '', '', 'Company Website', 2, 1, 0, 0, 1, 1, 'both_side', 0, 1, 'Please Enter Website Name', '', '', ' ', '', ''),
(3, 'job', 'Company Email', '0', 'company_email', '', 'Company Email', 'text', '', '', 'Company Email', 3, 1,0, 0, 1, 1, 'both_side', 0, 1, 'Please Enter Email', '', '', 'email', '', ''),
(4, 'job', 'Company Logo', '0', 'company_logo', '', 'Company Logo', 'upload', '', '', 'Company Logo', 4, 1, 0, 0, '1', 0, 'both_side', 0, 1, '', '', '', '', '', ''),
(5, 'job', 'Job Type', '0', 'job_type', '', 'Job Type', 'radio', '', 'Full Time,Part Time,Freelance', 'Job Type', 5, 1, 0, 1, '1', 0, 'both_side', 0, 1, '', '', '', ' ', '', ''),
(6, 'job', 'Location', '0', 'job_location', 'Enter comma separated places where your company is located', 'Location', 'text', '', '', 'Location', 6, 1, 0, 0, 1, 1, 'both_side', 0, 1, 'Please Enter Location', '', '', 'require', '', ''),
(7, 'job', 'Address', '0', 'address', '', 'Address', 'text', '', '', 'Address', 7, 1, 1, 0, 1, 1, 'both_side', 0, 1, 'Please Enter Address', '', '', 'require', '', ''),
(8, 'job', 'Address', '0', 'geo_address', '', 'Address', 'geo_map', '', '', 'Address', 8, 1, 0, 0, 1, 1, 'both_side', 0, 0, '', '', '', ' ', '', ''),
(9, 'job', 'Address Latitude', '0', 'geo_latitude', 'Please enter latitude for google map perfection. eg. : 39.955823048131286', 'Address Latitude', 'text', '', '', 'Address Latitude', 9, 1, 0, 0, 1, 1, 'both_side', 0, 0, 'Please Enter Address Latitude', '', '', '', '', ''),
(10, 'job', 'Address Longitude', '0', 'geo_longitude', 'Please enter logngitude for google map perfection. eg. : -75.14408111572266', 'Address Longitude', 'text', '', '', 'Address Longitude', 10, 1, 0, 0, 1, 1, 'both_side', 0, 0, 'Please Enter Address Longitude', '', '', '', '', ''),
(11, 'job', 'Job Category', '0', 'category', '', 'Job Category', 'multicheckbox', '', '', 'Job Category', 11, 1, 0,0, 1, 1, 'user_side', 0, 0, '', '', '', '', '', ''),
(12, 'job', 'Position Title', '0', 'position_title', '', 'Position Title', 'text', '', '', 'Position Title', 12, 1, 0, 0, 1, 1, 'user_side', 0, 0, 'Please Enter Title', '', '', 'require', '', ''),
(13, 'job', 'Description', '0', 'job_desc', 'Note : Basic HTML tags are allowed', 'Description', 'texteditor', '', '', 'Description', 13, 1, 0, 0, 1, 1, 'user_side', 0, 1, 'Please Enter Description', '', '', 'require', '', ''),
(14, 'job', 'How to apply', '0', 'how_to_apply', '', 'How to apply', 'texteditor', '', '', 'How to apply',14, 1, 0, 0, '1', 0, 'both_side', 0, 1, '', '', '', 'require', '', ''),
(23, 'job', 'Wish to declare this job as filled?', '0', 'position_filled', 'A message will be displayed as position filled on listing and detail pages.', 'Wish to declare this job as filled?', 'radio', '', 'Yes,No', 'Wish to declare this job as filled?', 23, 1, 0, 0, 1, 1, 'both_side', 0, 0, '', '', '', '', '', ''),
(24, 'resume', 'Resume Title', '0', 'resume_title', '', 'Resume Title', 'text', '', '', 'Resume Title', 24, 1, 0, 0, 1, 1, 'user_side', 0, 0, 'Please Enter Resume Title', '', '', 'require', '', ''),
(25, 'resume', 'Resume Category', '0', 'resume_category', '', 'Resume Category', 'multicheckbox', '', '', 'Resume Category', 25, 1, 0, 0, 1, 1, 'user_side', 0, 0, '', '', '', '', '', ''),
(26, 'resume', 'Availability', '0', 'availability', '', 'Availability', 'radio', '', 'Full Time,Part Time,Freelance', 'Availability', 26, 1, 0, 0, 1, 1, 'both_side', 0, 1, '', '', '', '', '', ''),
(27, 'resume', 'First Name', '0', 'fname', '', 'First Name', 'text', '', '', 'First Name', 27, 1, 0, 0, 1, 1, 'both_side', 0, 1, 'Please Enter First Name', '', '', '', '', ''),
(28, 'resume', 'Last Name', '0', 'lname', '', 'Last Name', 'text', '', '', 'Last Name', 28, 1, 0, 0, 1, 1, 'both_side', 0, 1, 'Please Enter Last Name', '', '', '', '', ''),
(29, 'resume', 'Your Address', '0', 'address', '', 'Your Address', 'text', '', '', 'Your Address', 29, 1, 0, 0, 1, 1, 'both_side', 0, 1, 'Please Enter Address', '', '', 'require', '', ''),
(30, 'resume', 'Experience in Year', '0', 'experience', '', 'Experience', 'text', '', '', 'Experience', 30, 1, 0, 0, 1, 1, 'both_side', 0, 1, 'Please Enter Experience', '', '', 'require', '', ''),
(31, 'resume', 'Desired Location', '0', 'resume_location', '', 'Desired Location', 'text', '', '', 'Desired Location', 31, 1, 0, 0, 1, 1, 'both_side', 0, 1, 'Please Enter Location', '', '', 'require', '', ''),
(32, 'resume', 'Phone Number', '0', 'phone', '', 'Phone Number', 'text', '', '', 'Phone Number', 32, 1, 0, 0, 1, 0, 'both_side', 0, 1, '', '', '', '', '', ''),
(33, 'resume', 'Expected Salary', '0', 'salary', '', 'Expected Salary', 'text', '', '', 'Expected Salary', 33, 1, 0, 0, 1, 1, 'both_side', 0, 1, 'Please Enter Your Expected Salary', '', '', '', '', ''),
(34, 'resume', 'Skills', '0', 'skills', '', 'Skills', 'text', '', '', 'Skills', 34, 1, 0, 0, 1, 0, 'both_side', 0, 1, '', '', '', '', '', ''),
(35, 'resume', 'Extra Curricular Activities', '0', 'activities', '', 'Extra Activities', 'textarea', '', '', 'Extra Activities', 35, 1, 0, 0, 1, 0, 'both_side', 0, 1, '', '', '', '', '', ''),
(36, 'resume', 'Description', '0', 'resume_desc', 'Note : Basic HTML tags are allowed', 'Description', 'texteditor', '', '', 'Description', 36, 1, 0, 0, 1, 0, 'user_side', 0, 1, 'Please Enter Description', '', '', 'require', '', ''),
(37, 'resume', 'Browse Resume', '0', 'apply_resume', '', 'Browse Resume', 'upload', '', '', 'Browse Resume', 37, 1, 0, 0, 1, 1, 'both_side', 0, 1, '', '', '', '', '', '')
";
$qry = $wpdb->query($ins);
}


/* Price TABLE Creation BOF */

$price_db_table_name = $table_prefix . "price";

global $price_db_table_name;
if($wpdb->get_var("SHOW TABLES LIKE \"$price_db_table_name\"") != $price_db_table_name){
	$price_table = 'CREATE TABLE IF NOT EXISTS '.$price_db_table_name.' (
	  `pid` int(11) NOT NULL AUTO_INCREMENT,
	  `price_title` varchar(255) NOT NULL,
	  `price_desc` varchar(1000) NOT NULL,
	  `package_cost` int(10) NOT NULL,
	  `validity` int(10) NOT NULL,
	  `validity_per` varchar(10) NOT NULL,
	  `status` int(10) NOT NULL ,
	  `is_recurring` int(10) NOT NULL ,
	  `billing_num` int(10) NOT NULL,
	  `billing_per` varchar(10) NOT NULL,
	  `billing_cycle` varchar(10) NOT NULL,
	  `is_featured` int(10) NOT NULL,
	  `feature_amount` int(10) NOT NULL,
	  `feature_cat_amount` int(10) NOT NULL,
	  PRIMARY KEY (`pid`)
	)'; 
	$wpdb->query($price_table);

	$price_insert = '
	INSERT INTO `'.$price_db_table_name.'` (`pid`, `price_title`, `price_desc`,`package_cost`,`validity`,`validity_per`,`status`,`is_recurring`,`billing_num`,`billing_per`,`billing_cycle`,`is_featured`,`feature_amount`,`feature_cat_amount`) VALUES
	(1, "Free", "Special time-limited offer: No charges for listing your job.","0","Unlimited","","1","","","","", 1,"0","0"),
	(2, "Summer pack", "Special time-limited offer","40","3","M","1","","","","",1,"10","15")';
	$wpdb->query($price_insert);
}

/* Price TABLE Creation EOF */

$ip_db_table_name= strtolower($table_prefix . "ip_settings");
global $ip_db_table_name;
if($wpdb->get_var("SHOW TABLES LIKE \"$ip_db_table_name\"") != $ip_db_table_name){
	$ip_table = 'CREATE TABLE IF NOT EXISTS `'.$ip_db_table_name.'` (
	  `ipid` int(11) NOT NULL AUTO_INCREMENT,
	  `ipaddress` varchar(255) NOT NULL,
	  `ipstatus` varchar(25) NOT NULL,
	  PRIMARY KEY (`ipid`)
	)';
	$wpdb->query($ip_table);
}

/* Custome User meta TABLE Creation BOF */
$table_prefix = $wpdb->prefix;
global $wpdb,$table_prefix;
$custom_usermeta_db_table_name = $table_prefix . "templatic_custom_usermeta";
global $wpdb,$custom_usermeta_db_table_name;
if(strtolower($wpdb->get_var("SHOW TABLES LIKE \"$custom_usermeta_db_table_name\"")) != strtolower($custom_usermeta_db_table_name))
{
$wpdb->query('CREATE TABLE IF NOT EXISTS `'.$custom_usermeta_db_table_name.'` (
	  `cid` int(11) NOT NULL AUTO_INCREMENT,
	  `post_type` varchar(255) NOT NULL,
	  `admin_title` varchar(255) NOT NULL,
	  `htmlvar_name` varchar(255) NOT NULL,
	  `admin_desc` text NOT NULL,
	  `site_title` varchar(255) NOT NULL,
	  `ctype` varchar(255) NOT NULL COMMENT "text,checkbox,date,radio,select,textarea,upload",
	  `default_value` text NOT NULL,
	  `option_values` text NOT NULL,
	  `clabels` text NOT NULL,
	  `sort_order` int(11) NOT NULL,
	  `is_active` tinyint(4) NOT NULL DEFAULT "1",
	  `is_delete` tinyint(4) NOT NULL DEFAULT "0",
	  `is_require` tinyint(4) NOT NULL DEFAULT "0",
	  `show_on_listing` tinyint(4) NOT NULL DEFAULT "1",
	  `show_on_detail` tinyint(4) NOT NULL DEFAULT "1",
	  `extrafield1` text NOT NULL,
	  `extrafield2` text NOT NULL,
	  PRIMARY KEY (`cid`)
	)');
	$qry = $wpdb->query("INSERT INTO $custom_usermeta_db_table_name (`cid`, `post_type`, `htmlvar_name`, `admin_desc`, `site_title`,  `ctype`, `default_value`, `option_values`, `clabels`, `sort_order`, `is_active`, `is_delete`, `is_require`,  `show_on_listing`, `show_on_detail`,  `extrafield1`, `extrafield2`) VALUES
(1, 'registration', 'user_email', '',  'Email', 'text', '', '', '', 0, 1, 0, 1, 1, '1', '', ''),
(2, 'registration', 'user_fname', '',  'User Name / First Name', 'text', '', '', '', 1, 1, 0, 1, 1, '1', '', ''),
(3, 'registration', 'user_lname', '',  'Last Name', 'text', '', '', '', 2, 1, 0, 0, 1, '1', '', ''),
(4, 'registration', 'user_phone', '',  'Contact', 'text', '', '', '', 2, 1, 0, 0, 1, '1', '', ''),
(5, 'registration', 'description', '',  'Description', 'textarea', '', '', '', 5, 1, 0, 0, 1, '1', '', ''),
(6, 'registration', 'login_type', '',  'Register As', 'radio', '', 'Job Provider,Job Seeker', '', 6, 1, 0, 1, 1, '1', '', '')
");
}
/* Custome User meta TABLE Creation EOF */


/*transaction table BOF*/

global $wpdb,$table_prefix;
$transection_db_table_name = $table_prefix . "transactions";
if($wpdb->get_var("SHOW TABLES LIKE \"$transection_db_table_name\"") != $transection_db_table_name)
{
	$transaction_table = 'CREATE TABLE IF NOT EXISTS `'.$transection_db_table_name.'` (
	`trans_id` bigint(20) NOT NULL AUTO_INCREMENT,
	`user_id` bigint(20) NOT NULL,
	`post_id` bigint(20) NOT NULL,
	`post_title` varchar(255) NOT NULL,
	`status` int(2) NOT NULL,
	`payment_method` varchar(255) NOT NULL,
	`payable_amt` float(25,5) NOT NULL,
	`payment_date` datetime NOT NULL,
	`paypal_transection_id` varchar(255) NOT NULL,
	`user_name` varchar(255) NOT NULL,
	`pay_email` varchar(255) NOT NULL,
	`billing_name` varchar(255) NOT NULL,
	`billing_add` text NOT NULL,
	PRIMARY KEY (`trans_id`)
	)';
	$wpdb->query($transaction_table);	
}

/*transaction table EOF*/

/* table for radious search BOT */

global $wpdb,$table_prefix;
$tbl_postcodes = $table_prefix . "postcodes";
if($wpdb->get_var("SHOW TABLES LIKE \"$tbl_postcodes\"") != $tbl_postcodes)
{
	$tbl_postcodes_ = 'CREATE TABLE IF NOT EXISTS `'.$tbl_postcodes.'` (
	`pcid` bigint(20) NOT NULL AUTO_INCREMENT,
	`post_id` bigint(20) NOT NULL,
	`location` varchar(255) NOT NULL,
	`address` varchar(255) NOT NULL,
	`latitude` varchar(255) NOT NULL,
	`longitude` varchar(255) NOT NULL,
	 PRIMARY KEY (`pcid`)
	)';
	$wpdb->query($tbl_postcodes_);	
}

/* table for radious search EOT */

/* Price TABLE Creation BOF */

$ip_db_table_name= strtolower($table_prefix . "ip_settings");
global $ip_db_table_name;
//$wpdb->query("drop table $ip_db_table_name");
if($wpdb->get_var("SHOW TABLES LIKE \"$ip_db_table_name\"") != $ip_db_table_name){
	$ip_table = 'CREATE TABLE IF NOT EXISTS `'.$ip_db_table_name.'` (
	  `ipid` int(11) NOT NULL AUTO_INCREMENT,
	  `ipaddress` varchar(255) NOT NULL,
	  `ipstatus` varchar(25) NOT NULL,
	  PRIMARY KEY (`ipid`)
	)';
	$wpdb->query($ip_table);
}
/* Price TABLE Creation EOF */

//====================================================================================//
/////////////// PAYMENT SETTINGS START ///////////////
$paymethodinfo = array();
$payOpts = array();
$payOpts[] = array(
				"title"			=>	"Merchant Id",
				"fieldname"		=>	"merchantid",
				"value"			=>	"myaccount@paypal.com",
				"description"	=>	"Example : myaccount@paypal.com",
				);
$payOpts[] = array(
				"title"			=>	"Cancel Url",
				"fieldname"		=>	"cancel_return",
				"value"			=>	get_option('siteurl')."/?page=cancel_return&pmethod=paypal",
				"description"	=>	"Example : http://mydomain.com/cancel_return.php",
				);
$payOpts[] = array(
				"title"			=>	"Return Url",
				"fieldname"		=>	"returnUrl",
				"value"			=>	get_option('siteurl')."/?page=return&pmethod=paypal",
				"description"	=>	"Example : http://mydomain.com/return.php",
				);
$payOpts[] = array(
				"title"			=>	"Notify Url",
				"fieldname"		=>	"notify_url",
				"value"			=>	get_option('siteurl')."/?page=notifyurl&pmethod=paypal",
				"description"	=>	"Example : http://mydomain.com/notifyurl.php",
				);								
$paymethodinfo[] = array(
					"name" 		=> 'Paypal',
					"key" 		=> 'paypal',
					"isactive"	=>	'1', // 1->display,0->hide
					"display_order"=>'1',
					"payOpts"	=>	$payOpts,
					);
//////////pay settings end////////
//////////google checkout start////////
$payOpts = array();
$payOpts[] = array(
				"title"			=>	"Merchant Id",
				"fieldname"		=>	"merchantid",
				"value"			=>	"1234567890",
				"description"	=>	"Example : 1234567890"
				);
$paymethodinfo[] = array(
					"name" 		=> 'Google Checkout',
					"key" 		=> 'googlechkout',
					"isactive"	=>	'1', // 1->display,0->hide
					"display_order"=>'2',
					"payOpts"	=>	$payOpts,
					);
//////////google checkout end////////
//////////authorize.net start////////
$payOpts = array();
$payOpts[] = array(
				"title"			=>	"Login ID",
				"fieldname"		=>	"loginid",
				"value"			=>	"yourname@domain.com",
				"description"	=>	"Example : yourname@domain.com"
				);
$payOpts[] = array(
				"title"			=>	"Transaction Key",
				"fieldname"		=>	"transkey",
				"value"			=>	"1234567890",
				"description"	=>	"Example : 1234567890",
				);
$paymethodinfo[] = array(
					"name" 		=> 'Authorize.net',
					"key" 		=> 'authorizenet',
					"isactive"	=>	'1', // 1->display,0->hide
					"display_order"=>'3',
					"payOpts"	=>	$payOpts,
					);
//////////authorize.net end////////
//////////worldpay start////////
$payOpts = array();	
$payOpts[] = array(
				"title"			=>	"Instant Id",
				"fieldname"		=>	"instId",
				"value"			=>	"123456",
				"description"	=>	"Example : 123456"
				);
$payOpts[] = array(
				"title"			=>	"Account Id",
				"fieldname"		=>	"accId1",
				"value"			=>	"12345",
				"description"	=>	"Example : 12345"
				);
$paymethodinfo[] = array(
					"name" 		=> 'Worldpay',
					"key" 		=> 'worldpay',
					"isactive"	=>	'1', // 1->display,0->hide\
					"display_order"=>'4',
					"payOpts"	=>	$payOpts,
					);
//////////worldpay end////////
//////////2co start////////
$payOpts = array();
$payOpts[] = array(
				"title"			=>	"Vendor ID",
				"fieldname"		=>	"vendorid",
				"value"			=>	"1303908",
				"description"	=>	"Enter Vendor ID Example : 1303908"
				);
$payOpts[] = array(
				"title"			=>	"Notify Url",
				"fieldname"		=>	"ipnfilepath",
				"value"			=>	get_option('siteurl')."/?page=notifyurl&pmethod=2co",
				"description"	=>	"Example : http://mydomain.com/2co_notifyurl.php",
				);
$paymethodinfo[] = array(
					"name" 		=> '2CO (2Checkout)',
					"key" 		=> '2co',
					"isactive"	=>	'1', // 1->display,0->hide
					"display_order"=>'5',
					"payOpts"	=>	$payOpts,
					);
//////////2co end////////
//////////pre bank transfer start////////
$payOpts = array();
$payOpts[] = array(
				"title"			=>	"Bank Information",
				"fieldname"		=>	"bankinfo",
				"value"			=>	"ICICI Bank",
				"description"	=>	"Enter the bank name to which you want to transfer payment"
				);
$payOpts[] = array(
				"title"			=>	"Account ID",
				"fieldname"		=>	"bank_accountid",
				"value"			=>	"AB1234567890",
				"description"	=>	"Enter your bank Account ID",
				);
$paymethodinfo[] = array(
					"name" 		=> 'Pre Bank Transfer',
					"key" 		=> 'prebanktransfer',
					"isactive"	=>	'1', // 1->display,0->hide
					"display_order"=>'6',
					"payOpts"	=>	$payOpts,
					);				
//////////pre bank transfer end////////
//////////pay cash on devivery start////////
$payOpts = array();
$paymethodinfo[] = array(
					"name" 		=> 'Pay Cash On Delivery',
					"key" 		=> 'payondelevary',
					"isactive"	=>	'1', // 1->display,0->hide
					"display_order"=>'7',
					"payOpts"	=>	$payOpts,
					);
//////////pay cash on devivery end////////
for($i=0;$i<count($paymethodinfo);$i++)
{
$payment_method_info = array();
$payment_method_info  = get_option('payment_method_'.$paymethodinfo[$i]['key']);
if(!$payment_method_info)
{
	update_option('payment_method_'.$paymethodinfo[$i]['key'],$paymethodinfo[$i]);
}
}
/////////////// PAYMENT SETTINGS END ///////////////

if(!get_option('ptthemes_job_link_flag'))
{
	update_option('ptthemes_job_link_flag','Yes');
}
if(!get_option('ptthemes_resume_link_flag'))
{
	update_option('ptthemes_resume_link_flag','Yes');
}


?>