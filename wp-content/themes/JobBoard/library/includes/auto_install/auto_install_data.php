<?php
set_time_limit(0);
global  $wpdb;
//require_once (TEMPLATEPATH . '/delete_data.php');

/////////////// TERMS & products START ///////////////
//$category_array = array('Art Work','Designer','Development','Mobile','Programmer','XHTML Coder');
/////////////// TERMS START ///////////////
require_once(ABSPATH.'wp-admin/includes/taxonomy.php');

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

//Adding a "Blog" category.
$category_array1 = array(array('Blog'));
insert_category($category_array1);
function insert_category($category_array1)
{
	for($i=0;$i<count($category_array1);$i++)
	{
		$parent_catid = 0;
		if(is_array($category_array1[$i]))
		{
			$cat_name_arr = $category_array1[$i];
			for($j=0;$j<count($cat_name_arr);$j++)
			{
				$catname = $cat_name_arr[$j];
				$last_catid = wp_create_category( $catname, $parent_catid);
				if($j==0)
				{
					$parent_catid = $last_catid;
				}
			}
			
		}else
		{
			$catname = $category_array1[$i];
			wp_create_category( $catname, $parent_catid);
		}
	}
}
/////////////// TERMS END ///////////////

/*Function to insert taxonomy category EOF*/

//Adding some Blogs.
$dummy_image_path = get_template_directory_uri().'/images/dummy/';

$post_array = array();
$post_author = $wpdb->get_var("SELECT ID FROM $wpdb->users order by ID asc limit 1");
$post_info = array();
$post_info[] = array(
					"post_title"	=>	'Sample Post 1',
					"post_content"	=>	'Blogs (also known as Community Blogging) are articles written one person that can be commented on and 		organized into a listing like a typical blog.<br><p>For some individuals, blogs are their projects of every day living, as they talk about their daily episodes as well as make tribute to friends and family. Furthermore, blogs assume a profound meaning written to compose and assemble political statements, endorse a product, supply information on research, and even offer tutorials. Any subject that are of your interests, you can be sure that someone has written a blog about it. </p><p>Blogs are now being written by musicians, politicians, sports figures, novelists, newscasters as well as other known figures. It is this blog fever that has raised controversy. The fact that anyone can compose and regarding any subject matter under the sun, complaints about certain write-ups are an issue. In a lot of blogs, names are being mentioned; do bear in mind that although you are entitled to write anything that interests you in a blog, you have to be very careful and take in a lot of responsibility. Do not make any statements which can become controversial; or else, be very prepared.</p><br>
					<ul><ol>1.For personal acquaintances, relationships and hobby. A person can write a blog about his daily activities, whats going on with his life as his way of telling his family and friends the things that goes on in his life. Likewise, one may also write a blog just so he can express what he feels about himself, or about a certain subject matter that is of interest to him.</ol>
					<ol>2.Topical. Some blogs are committed to a precise topic, like computer hardware or politics. These are frequently read like magazines.</ol><ol>3.For marketing. Corporations are too, into blogging; when well written and implemented, this kind of blog can be a powerful instrument for business communications, forming eagerness and anticipation regarding their products and services offered, or used as tool within the company, keeping employees well informed about company issues and news.</ol>
',
					"post_category"	=>	array('Blog'),
					);
$post_info[] = array(
					"post_title"	=>	'Sample Post 2',
					"post_content"	=>	'Blogs (also known as Community Blogging) are articles written one person that can be commented on and 		organized into a listing like a typical blog.<br><p>For some individuals, blogs are their projects of every day living, as they talk about their daily episodes as well as make tribute to friends and family. Furthermore, blogs assume a profound meaning written to compose and assemble political statements, endorse a product, supply information on research, and even offer tutorials. Any subject that are of your interests, you can be sure that someone has written a blog about it. </p><p>Blogs are now being written by musicians, politicians, sports figures, novelists, newscasters as well as other known figures. It is this blog fever that has raised controversy. The fact that anyone can compose and regarding any subject matter under the sun, complaints about certain write-ups are an issue. In a lot of blogs, names are being mentioned; do bear in mind that although you are entitled to write anything that interests you in a blog, you have to be very careful and take in a lot of responsibility. Do not make any statements which can become controversial; or else, be very prepared.</p><br>
					<ul><ol>1.For personal acquaintances, relationships and hobby. A person can write a blog about his daily activities, whats going on with his life as his way of telling his family and friends the things that goes on in his life. Likewise, one may also write a blog just so he can express what he feels about himself, or about a certain subject matter that is of interest to him.</ol>
					<ol>2.Topical. Some blogs are committed to a precise topic, like computer hardware or politics. These are frequently read like magazines.</ol><ol>3.For marketing. Corporations are too, into blogging; when well written and implemented, this kind of blog can be a powerful instrument for business communications, forming eagerness and anticipation regarding their products and services offered, or used as tool within the company, keeping employees well informed about company issues and news.</ol>',
					"post_category"	=>	array('Blog'),
					);
$post_info[] = array(
					"post_title"	=>	'Sample Post 3',
					"post_content"	=>	'Blogs (also known as Community Blogging) are articles written one person that can be commented on and 		organized into a listing like a typical blog.<br><p>For some individuals, blogs are their projects of every day living, as they talk about their daily episodes as well as make tribute to friends and family. Furthermore, blogs assume a profound meaning written to compose and assemble political statements, endorse a product, supply information on research, and even offer tutorials. Any subject that are of your interests, you can be sure that someone has written a blog about it. </p><p>Blogs are now being written by musicians, politicians, sports figures, novelists, newscasters as well as other known figures. It is this blog fever that has raised controversy. The fact that anyone can compose and regarding any subject matter under the sun, complaints about certain write-ups are an issue. In a lot of blogs, names are being mentioned; do bear in mind that although you are entitled to write anything that interests you in a blog, you have to be very careful and take in a lot of responsibility. Do not make any statements which can become controversial; or else, be very prepared.</p><br>
					<ul><ol>1.For personal acquaintances, relationships and hobby. A person can write a blog about his daily activities, whats going on with his life as his way of telling his family and friends the things that goes on in his life. Likewise, one may also write a blog just so he can express what he feels about himself, or about a certain subject matter that is of interest to him.</ol>
					<ol>2.Topical. Some blogs are committed to a precise topic, like computer hardware or politics. These are frequently read like magazines.</ol><ol>3.For marketing. Corporations are too, into blogging; when well written and implemented, this kind of blog can be a powerful instrument for business communications, forming eagerness and anticipation regarding their products and services offered, or used as tool within the company, keeping employees well informed about company issues and news.</ol>',
					"post_category"	=>	array('Blog'),
					);
$post_info[] = array(
					"post_title"	=>	'Sample Post 4',
					"post_content"	=>	'Blogs (also known as Community Blogging) are articles written one person that can be commented on and 		organized into a listing like a typical blog.<br><p>For some individuals, blogs are their projects of every day living, as they talk about their daily episodes as well as make tribute to friends and family. Furthermore, blogs assume a profound meaning written to compose and assemble political statements, endorse a product, supply information on research, and even offer tutorials. Any subject that are of your interests, you can be sure that someone has written a blog about it. </p><p>Blogs are now being written by musicians, politicians, sports figures, novelists, newscasters as well as other known figures. It is this blog fever that has raised controversy. The fact that anyone can compose and regarding any subject matter under the sun, complaints about certain write-ups are an issue. In a lot of blogs, names are being mentioned; do bear in mind that although you are entitled to write anything that interests you in a blog, you have to be very careful and take in a lot of responsibility. Do not make any statements which can become controversial; or else, be very prepared.</p><br>
					<ul><ol>1.For personal acquaintances, relationships and hobby. A person can write a blog about his daily activities, whats going on with his life as his way of telling his family and friends the things that goes on in his life. Likewise, one may also write a blog just so he can express what he feels about himself, or about a certain subject matter that is of interest to him.</ol>
					<ol>2.Topical. Some blogs are committed to a precise topic, like computer hardware or politics. These are frequently read like magazines.</ol><ol>3.For marketing. Corporations are too, into blogging; when well written and implemented, this kind of blog can be a powerful instrument for business communications, forming eagerness and anticipation regarding their products and services offered, or used as tool within the company, keeping employees well informed about company issues and news.</ol>',
					"post_category"	=>	array('Blog'),
					);
$post_info[] = array(
					"post_title"	=>	'Sample Post 5',
					"post_content"	=>	'Blogs (also known as Community Blogging) are articles written one person that can be commented on and 		organized into a listing like a typical blog.<br><p>For some individuals, blogs are their projects of every day living, as they talk about their daily episodes as well as make tribute to friends and family. Furthermore, blogs assume a profound meaning written to compose and assemble political statements, endorse a product, supply information on research, and even offer tutorials. Any subject that are of your interests, you can be sure that someone has written a blog about it. </p><p>Blogs are now being written by musicians, politicians, sports figures, novelists, newscasters as well as other known figures. It is this blog fever that has raised controversy. The fact that anyone can compose and regarding any subject matter under the sun, complaints about certain write-ups are an issue. In a lot of blogs, names are being mentioned; do bear in mind that although you are entitled to write anything that interests you in a blog, you have to be very careful and take in a lot of responsibility. Do not make any statements which can become controversial; or else, be very prepared.</p><br>
					<ul><ol>1.For personal acquaintances, relationships and hobby. A person can write a blog about his daily activities, whats going on with his life as his way of telling his family and friends the things that goes on in his life. Likewise, one may also write a blog just so he can express what he feels about himself, or about a certain subject matter that is of interest to him.</ol>
					<ol>2.Topical. Some blogs are committed to a precise topic, like computer hardware or politics. These are frequently read like magazines.</ol><ol>3.For marketing. Corporations are too, into blogging; when well written and implemented, this kind of blog can be a powerful instrument for business communications, forming eagerness and anticipation regarding their products and services offered, or used as tool within the company, keeping employees well informed about company issues and news.</ol>',
					"post_category"	=>	array('Blog'),
					);
$post_info[] = array(
					"post_title"	=>	'Sample Post 6',
					"post_content"	=>	'Blogs (also known as Community Blogging) are articles written one person that can be commented on and 		organized into a listing like a typical blog.<br><p>For some individuals, blogs are their projects of every day living, as they talk about their daily episodes as well as make tribute to friends and family. Furthermore, blogs assume a profound meaning written to compose and assemble political statements, endorse a product, supply information on research, and even offer tutorials. Any subject that are of your interests, you can be sure that someone has written a blog about it. </p><p>Blogs are now being written by musicians, politicians, sports figures, novelists, newscasters as well as other known figures. It is this blog fever that has raised controversy. The fact that anyone can compose and regarding any subject matter under the sun, complaints about certain write-ups are an issue. In a lot of blogs, names are being mentioned; do bear in mind that although you are entitled to write anything that interests you in a blog, you have to be very careful and take in a lot of responsibility. Do not make any statements which can become controversial; or else, be very prepared.</p><br>
					<ul><ol>1.For personal acquaintances, relationships and hobby. A person can write a blog about his daily activities, whats going on with his life as his way of telling his family and friends the things that goes on in his life. Likewise, one may also write a blog just so he can express what he feels about himself, or about a certain subject matter that is of interest to him.</ol>
					<ol>2.Topical. Some blogs are committed to a precise topic, like computer hardware or politics. These are frequently read like magazines.</ol><ol>3.For marketing. Corporations are too, into blogging; when well written and implemented, this kind of blog can be a powerful instrument for business communications, forming eagerness and anticipation regarding their products and services offered, or used as tool within the company, keeping employees well informed about company issues and news.</ol>',
					"post_category"	=>	array('Blog'),
					);				

/***- Insert Blog post BOF-***/
insert_posts($post_info);
require_once(ABSPATH . 'wp-admin/includes/image.php');
function insert_posts($post_info)
{
	global $wpdb,$current_user;
	for($i=0;$i<count($post_info);$i++)
	{
		$post_title = $post_info[$i]['post_title'];
		$post_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='post' and post_status in ('publish','draft')");
		if(!$post_count)
		{
			$post_info_arr = array();
			$catids_arr = array();
			$my_post = array();
			$post_info_arr = $post_info[$i];
			if($post_info_arr['post_category'])
			{
				for($c=0;$c<count($post_info_arr['post_category']);$c++)
				{
					$catids_arr[] = get_cat_ID($post_info_arr['post_category'][$c]);
				}
			}else
			{
				$catids_arr[] = 1;
			}
			$my_post['post_title'] = $post_info_arr['post_title'];
			$my_post['post_content'] = $post_info_arr['post_content'];
			if($post_info_arr['post_author'])
			{
				$my_post['post_author'] = $post_info_arr['post_author'];
			}else
			{
				$my_post['post_author'] = 1;
			}
			$my_post['post_status'] = 'publish';
			$my_post['post_category'] = $catids_arr;
			$my_post['tags_input'] = $post_info_arr['post_tags'];
			$last_postid = wp_insert_post( $my_post );
			add_post_meta($last_postid,'auto_install', "auto_install");
			$post_meta = $post_info_arr['post_meta'];
			if($post_meta)
			{
				foreach($post_meta as $mkey=>$mval)
				{
					update_post_meta($last_postid, $mkey, $mval);
				}
			}
			
			$post_image = $post_info_arr['post_image'];
			if($post_image)
			{
				for($m=0;$m<count($post_image);$m++)
				{
					$menu_order = $m+1;
					$image_name_arr = explode('/',$post_image[$m]);
					$img_name = $image_name_arr[count($image_name_arr)-1];
					$img_name_arr = explode('.',$img_name);
					$post_img = array();
					$post_img['post_title'] = $img_name_arr[0];
					$post_img['post_status'] = 'attachment';
					$post_img['post_parent'] = $last_postid;
					$post_img['post_type'] = 'attachment';
					$post_img['post_mime_type'] = 'image/jpeg';
					$post_img['menu_order'] = $menu_order;
					$last_postimage_id = wp_insert_post( $post_img );
					update_post_meta($last_postimage_id, '_wp_attached_file', $post_image[$m]);					
					$post_attach_arr = array(
										"width"	=>	700,
										"height" =>	420,
										"hwstring_small"=> "height='180' width='140'",
										"homeslide"=> "height='960' width='400'",
										"single-image"=> "height='700' width='400'",
										"file"	=> $post_image[$m],
										//"sizes"=> $sizes_info_array,
										);
					wp_update_attachment_metadata($last_postimage_id, $post_attach_arr );
				}
			}
		}
	}
}
/***- Insert Blog post EOF-***/

//Add some categories in "Job" post type.
$category_array1 = array();
$category_array1 = array('Art Work','Designer','Development','Mobile','Programmer','XHTML Coder');
insert_taxonomy_category($category_array1);
/*--Function to insert taxonomy category BOF-*/
function insert_taxonomy_category($category_array1)
{
	global $wpdb;
	for($i=0;$i<count($category_array1);$i++)
	{
		$parent_catid = 0;
		if(is_array($category_array1[$i]))
		{
			$cat_name_arr = $category_array1[$i];
			for($j=0;$j<count($cat_name_arr);$j++)
			{
				$catname = $cat_name_arr[$j];
				if($j>1)
				{
					$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					if(!$catid)
					{
						$last_catid = wp_insert_term( $catname, 'jcategory' );
					}					
				}else
				{
					$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					if(!$catid)
					{
						$last_catid = wp_insert_term( $catname, 'jcategory');
					}
				}
			}
			
		}else
		{
			$catname = $category_array1[$i];
			$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
			if(!$catid)
			{
				wp_insert_term( $catname, 'jcategory');
			}
		}
	}
	
	for($i=0;$i<count($category_array1);$i++)
	{
		$parent_catid = 0;
		if(is_array($category_array1[$i]))
		{
			$cat_name_arr = $category_array1[$i];
			for($j=0;$j<count($cat_name_arr);$j++)
			{
				$catname = $cat_name_arr[$j];
				if($j>0)
				{
					$parentcatname = $cat_name_arr[0];
					$parent_catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$parentcatname\"");
					$last_catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					wp_update_term( $last_catid, 'jcategory', $args = array('parent'=>$parent_catid) );
				}
			}
			
		}
	}
}

//===================== Add some jobs ======================//
$post_info = array();
////Job 1 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name",	
					"company_web"		=> 'http://www.companyweb.com',		
					"company_email"		=> 'info@companyname.com',		
					"job_location"		=> 'North Carolina',		
					"job_type"			=> 'Full Time', //Full Time,Part Time,freelance
					"job_expiry_days"	=> '30',		
					"promocode"			=> '',
					"address"			=> 'Carolina Beach Road, Wilmington, NC, United States',
					"geo_latitude"		=> '34.1334600363166',
					"geo_longitude"		=> '-77.91745350000002',
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo1.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'Graphic Designer and Developer',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category"	=>	array('Art Work','Designer'),
					);
////Job 1 end///
////Job 2 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name",	
					"company_web"		=> 'http://www.companyweb.com',		
					"company_email"		=> 'info@companyname.com',		
					"job_location"		=> 'North Dakota',
					"address"			=> 'Dakota Street, Winnipeg, MB, Canada',
					"geo_latitude"		=> '49.82057499773663',
					"geo_longitude"		=> '-97.10196274999998',					
					"job_type"			=> 'Part Time', //Full Time,Part Time,freelance
					"job_expiry_days"	=> '30',		
					"promocode"			=> '',
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo2.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'Desktop Developer',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category"	=>	array('Programmer'),
					);
////Job 2 end///
////Job 3 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name",	
					"company_web"		=> 'http://www.companyname.com',		
					"company_email"		=> 'info@company_email.com',		
					"job_location"		=> 'Alaska',
					"address"			=> 'Alaskan Way, Seattle, WA, United State',
					"geo_latitude"		=> '47.59064284101658',
					"geo_longitude"		=> '-122.33772579999999',					
					"job_type"			=> 'freelance', //Full Time,Part Time,freelance
					"alive_days"	=> '30',		
					"promocode"			=> '', 
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo3.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'Work from Home',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category"	=>	array('Development'),
					);
////Job 3 end///
////Job 4 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name",	
					"company_web"		=> 'http://www.companyname.com',		
					"company_email"		=> 'info@company_email.com',		
					"job_location"		=> 'California',
					"address"			=> 'California Avenue Southwest, Seattle, WA, United States',
					"geo_latitude"		=> '47.550281221089804',
					"geo_longitude"		=> '-122.38634315000002',					
					"job_type"			=> 'Full Time', //Full Time,Part Time,freelance
					"alive_days"	=> '30',		
					"promocode"			=> '', 
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo5.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'Lead Web/Interaction Designer',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category"	=>	array('Development'),
					);
////Job 4 end///
////Job 5 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name",	
					"company_web"		=> 'http://www.companyweb.com',		
					"company_email"		=> 'info@companyname.com',		
					"job_location"		=> 'Illinois',
					"address"			=> 'Illinois Street, San Francisco, CA, United States',
					"geo_latitude"		=> '37.756374007080936',
					"geo_longitude"		=> '-122.38552264999998',					
					"job_type"			=> 'Part Time', //Full Time,Part Time,freelance
					"alive_days"		=> '30',		
					"promocode"			=> '', 
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo1.png',
					"post_category" =>	array('Development'),
				);
$post_info[] = array(
					"post_title"	=>	'Front End Internet Enginee',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"company_logo"		=> $dummy_image_path.'logo2.png',
					"post_category"	=>	array('Development'),
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
					);
////Job 5 end///
////Job 6 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name ",	
					"company_web"		=> 'http://www.companyweb.com',		
					"company_email"		=> 'info@companyname.com',		
					"job_location"		=> 'Indiana',
					"address"			=> 'Indiana Street, San Francisco, CA, United States',
					"geo_latitude"		=> '37.756085590154804',
					"geo_longitude"		=> '-122.39106915000002',					
					"job_type"			=> 'Full Time', //Full Time,Part Time,freelance
					"alive_days"	=> '30',		
					"promocode"			=> '',
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo1.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'Magento Developer',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category" =>	array('Development'),
					);
////Job 6 end///
////Job 7 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name",	
					"company_web"		=> 'http://www.companyweb.com',		
					"company_email"		=> 'info@companyname.com',		
					"job_location"		=> 'Kansas',
					"address"			=> 'Kansas City, KS, United States',
					"geo_latitude"		=> '39.114052993477756',
					"geo_longitude"		=> '-94.6274636',					
					"job_type"			=> 'Part Time', //Full Time,Part Time,freelance
					"alive_days"	=> '30',		
					"promocode"			=> '',
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo2.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'Application Developer',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category" =>	array('Programmer'),
					);
////Job 7 end///
////Job 8 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name",	
					"company_web"		=> 'http://www.companyname.com',		
					"company_email"		=> 'info@company_email.com',		
					"job_location"		=> 'Kentucky',
					"address"			=> 'Kentucky Street, Lawrence, KS, United States',
					"geo_latitude"		=> '38.95892457569876',
					"geo_longitude"		=> '-95.23837049999997',					
					"job_type"			=> 'freelance', //Full Time,Part Time,freelance
					"alive_days"	=> '30',		
					"promocode"			=> '', 
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo3.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'Ecommerce Work',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category" =>	array('Development'),
					);
////Job 8 end///
////Job 9 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name",	
					"company_web"		=> 'http://www.companyname.com',		
					"company_email"		=> 'info@company_email.com',		
					"job_location"		=> 'Louisiana',
					"address"			=> 'Louisiana Street, Houston, TX, United States',
					"geo_latitude"		=> '29.75549595189908',
					"geo_longitude"		=> '-95.37178675000001',					
					"job_type"			=> 'Full Time', //Full Time,Part Time,freelance
					"alive_days"	=> '30',		
					"promocode"			=> '', 
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo4.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'Lead Web/Interaction Designer',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category" =>	array('Designer'),
					);
////Job 9 end///
////Job 10 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name",	
					"company_web"		=> 'http://www.companyweb.com',		
					"company_email"		=> 'info@companyname.com',		
					"job_location"		=> 'Massachusetts',
					"address"			=> 'Massachusetts Avenue Northwest, Washington, DC, United States',
					"geo_latitude"		=> '38.92256631958141',
					"geo_longitude"		=> '-77.05360435',					
					"job_type"			=> 'Part Time', //Full Time,Part Time,freelance
					"alive_days"	=> '30',		
					"promocode"			=> '', 
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo5.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'Front End Internet Enginee',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category" =>	array('Development'),
					);
////Job 10 end///
////Job 11 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name ",	
					"company_web"		=> 'http://www.companyweb.com',		
					"company_email"		=> 'info@companyname.com',		
					"job_location"		=> 'Maryland',
					"address"			=> 'Maryland Avenue, Rockville, MD, United States',
					"geo_latitude"		=> '39.081568368325996',
					"geo_longitude"		=> '-77.15622340000004',					
					"job_type"			=> 'Full Time', //Full Time,Part Time,freelance
					"alive_days"		=> '30',		
					"promocode"			=> '',
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo1.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'HTML Designer and Developer',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category" =>	array('Development'),
					);
////Job 11 end///
////Job 12 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name",	
					"company_web"		=> 'http://www.companyweb.com',		
					"company_email"		=> 'info@companyname.com',
					"job_location"		=> 'Maine',
					"address"			=> 'Maine Avenue Southwest, Washington, DC, United States',
					"geo_latitude"		=> '38.88207077465083',
					"geo_longitude"		=> '-77.02876980000002',
					"job_type"			=> 'Part Time', //Full Time,Part Time,freelance
					"alive_days"		=> '30',		
					"promocode"			=> '',
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo2.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'SEO Developer',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category" =>	array('Programmer'),
					);
////Job 12 end///
////Job 13 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name",	
					"company_web"		=> 'http://www.companyname.com',		
					"company_email"		=> 'info@company_email.com',		
					"job_location"		=> 'New Hampshire',	
					"address"			=> 'New Hampshire Avenue, Hillandale, MD, United States',
					"geo_latitude"		=> '39.02404183584668',
					"geo_longitude"		=> '-76.97746959999995',					
					"job_type"			=> 'freelance', //Full Time,Part Time,freelance
					"alive_days"		=> '30',		
					"promocode"			=> '', 
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo3.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'PSD Export',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"company_logo"		=> $dummy_image_path.'logo3.png',
					"post_category" =>	array('Development'),
					);
////Job 13 end///
////Job 14 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name ",	
					"company_web"		=> 'http://www.companyname.com',		
					"company_email"		=> 'info@company_email.com',		
					"job_location"		=> 'New Jersey',		
					"address"			=> 'New Jersey Turnpike, Mount Laurel, NJ, United States',
					"geo_latitude"		=> '39.95796638154377',
					"geo_longitude"		=> '-74.91579899999999',
					"job_type"			=> 'Full Time', //Full Time,Part Time,freelance
					"alive_days"		=> '30',		
					"promocode"			=> '', 
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo4.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'Lead Web/Interaction Designer',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category" =>	array('Designer'),
					);
////Job 14 end///
////Job 15 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name",	
					"company_web"		=> 'http://www.companyweb.com',		
					"company_email"		=> 'info@companyname.com',		
					"job_location"		=> 'New Mexico',
					"address"			=> 'New Mexico 15, Silver City, NM, United States',
					"geo_latitude"		=> '47.550281221089804',
					"geo_longitude"		=> '-122.38634315000002',					
					"job_type"			=> 'Part Time', //Full Time,Part Time,freelance
					"alive_days"		=> '30',		
					"promocode"			=> '', 
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo5.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'Mobile Wordpress Developer',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category" =>	array('Mobile'),
					);
////Job 15 end///
//// Job 16 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name ",	
					"company_web"		=> 'http://www.companyweb.com',		
					"company_email"		=> 'info@companyname.com',		
					"job_location"		=> 'New York',
					"address"			=> 'New York Avenue Northwest, Washington, DC, United States',
					"geo_latitude"		=> '38.896039212811964',
					"geo_longitude"		=> '-77.04257365000001',					
					"job_type"			=> 'Full Time', //Full Time,Part Time,freelance
					"alive_days"		=> '30',		
					"promocode"			=> '',
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo1.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'PSD Export and Designer',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category" =>	array('Designer'),
					);
////Job 16 end///
////Job 17 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name",	
					"company_web"		=> 'http://www.companyweb.com',		
					"company_email"		=> 'info@companyname.com',		
					"job_location"		=> 'Oklahoma',	
					"address"			=> 'Oklahoma Avenue Northeast, Washington, DC, United States',
					"geo_latitude"		=> '38.89588932476756',
					"geo_longitude"		=> '7226769999997',					
					"job_type"			=> 'Part Time', //Full Time,Part Time,freelance
					"alive_days"		=> '30',		
					"promocode"			=> '',
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo2.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'Software Engineer',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category" =>	array('Programmer'),
					);
////Job 17 end///
////Job 18 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name",	
					"company_web"		=> 'http://www.companyname.com',		
					"company_email"		=> 'info@company_email.com',		
					"job_location"		=> 'Pennsylvania',	
					"address"			=> 'Pennsylvania Avenue Northwest, Washington, DC, United States',
					"geo_latitude"		=> '38.89792652557963',
					"geo_longitude"		=> '-77.03521999999998',					
					"job_type"			=> 'freelance', //Full Time,Part Time,freelance
					"alive_days"		=> '30',		
					"promocode"			=> '', 
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo3.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'Wordpress Theme Integration',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category" =>	array('Development'),
					);
////Job 18 end///
////Job 19 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name",	
					"company_web"		=> 'http://www.companyname.com',		
					"company_email"		=> 'info@company_email.com',		
					"job_location"		=> 'Minnesota',		
					"address"			=> 'Minnesota Avenue Northeast, Washington, DC, United States',
					"geo_latitude"		=> '38.89977735542155',
					"geo_longitude"		=> '-76.94239679999998',
					"job_type"			=> 'Full Time', //Full Time,Part Time,freelance
					"alive_days"		=> '30',		
					"promocode"			=> '', 
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo4.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'Lead Web/Interaction Designer',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category" =>	array('Development'),
					);
////Job 19 end///
////Job 20 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name",	
					"company_web"		=> 'http://www.companyweb.com',		
					"company_email"		=> 'info@companyname.com',		
					"job_location"		=> 'Pennsylvania',	
					"address"			=> 'Pennsylvania Avenue Northwest, Washington, DC, United States',
					"geo_latitude"		=> '38.89792652557963',
					"geo_longitude"		=> '-77.03521999999998',					
					"job_type"			=> 'Part Time', //Full Time,Part Time,freelance
					"alive_days"		=> '30',		
					"promocode"			=> '', 
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo5.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'XHTML Developer',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category" =>	array('XHTML Coder'),
					);
////Job 20 end///
////Job 21 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name ",	
					"company_web"		=> 'http://www.companyweb.com',		
					"company_email"		=> 'info@companyname.com',		
					"job_location"		=> 'U.S. Minor Outlying Islands',
					"address"			=> 'U.S. Minor Outlying Islands near Minnesota Ave NE, Washington, DC',
					"geo_latitude"		=> '38.89977735542155',
					"geo_longitude"		=> '-76.94239679999998',					
					"job_type"			=> 'Full Time', //Full Time,Part Time,freelance
					"alive_days"		=> '30',		
					"promocode"			=> '',
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo1.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'Wordpress Theme Supporter',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category" =>	array('Development'),
					);
////Job 21 end///
////Job 22 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name",	
					"company_web"		=> 'http://www.companyweb.com',		
					"company_email"		=> 'info@companyname.com',		
					"job_location"		=> 'Virgin Islands of the U.S.',
					"address"			=> 'Virgin Islands of the U.S.',
					"geo_latitude"		=> '18.335764967318593',
					"geo_longitude"		=> '-64.89633499999997',					
					"job_type"			=> 'Part Time', //Full Time,Part Time,freelance
					"alive_days"		=> '30',		
					"promocode"			=> '',
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo2.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'Web Designer',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category" =>	array('Programmer'),
					);
////Job 22 end///
////Job 23 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name",	
					"company_web"		=> 'http://www.companyname.com',		
					"company_email"		=> 'info@company_email.com',		
					"job_location"		=> 'Mississippi',		
					"address"			=> 'Mississippi Avenue, Takoma Park, MD, United States',
					"geo_latitude"		=> '38.987948362854084',
					"geo_longitude"		=> '-77.0085401',
					"job_type"			=> 'freelance', //Full Time,Part Time,freelance
					"alive_days"		=> '30',		
					"promocode"			=> '', 
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo3.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'Data Entry in Word',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category" =>	array('Development'),
					);
////Job 23 end///
////Job 24 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name",	
					"company_web"		=> 'http://www.companyname.com',		
					"company_email"		=> 'info@company_email.com',		
					"job_location"		=> 'South Carolina',	
					"address"			=> 'South Carolina, United States',
					"geo_latitude"		=> '33.8360809997136',
					"geo_longitude"		=> '-81.1637245',					
					"job_type"			=> 'Full Time', //Full Time,Part Time,freelance
					"alive_days"		=> '30',		
					"promocode"			=> '', 
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo4.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'Lead Web/Interaction Designer',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category" =>	array('Development'),
					);
////Job 24 end///
////Job 25 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name",	
					"company_web"		=> 'http://www.companyweb.com',		
					"company_email"		=> 'info@companyname.com',		
					"job_location"		=> 'Tennessee',		
					"address"			=> 'Tennessee Avenue, Chattanooga, TN, United States',
					"geo_latitude"		=> '34.99925423275303',
					"geo_longitude"		=> '-85.32808365',
					"job_type"			=> 'Part Time', //Full Time,Part Time,freelance
					"alive_days"	=> '30',		
					"promocode"			=> '', 
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo5.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'XML Coder',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category" =>	array('XHTML Coder'),
					);
////Job 25 end///
// Job 26 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name ",	
					"company_web"		=> 'http://www.companyweb.com',		
					"company_email"		=> 'info@companyname.com',		
					"job_location"		=> 'Washington',
					"address"			=> 'Washington, PA, United States',
					"geo_latitude"		=> '40.17396004218726',
					"geo_longitude"		=> '-80.24617139999998',					
					"job_type"			=> 'Full Time', //Full Time,Part Time,freelance
					"alive_days"	=> '30',		
					"promocode"			=> '',
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo5.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'ASP.NET Developer',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category" =>	array('Development'),
					);
////Job 26 end///
////Job 27 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name",	
					"company_web"		=> 'http://www.companyweb.com',		
					"company_email"		=> 'info@companyname.com',		
					"job_location"		=> 'Wisconsin',
					"address"			=> 'Wisconsin Dells, WI, United States',
					"geo_latitude"		=> '43.627479431820234',
					"geo_longitude"		=> '-89.77095789999998',					
					"job_type"			=> 'Part Time', //Full Time,Part Time,freelance
					"alive_days"	=> '30',		
					"promocode"			=> '',
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo4.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'Web Developer',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category" =>	array('Programmer'),
					);
////Job 27 end///
////Job 28 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name",	
					"company_web"		=> 'http://www.companyname.com',		
					"company_email"		=> 'info@company_email.com',		
					"job_location"		=> 'Kentucky',
					"address"			=> 'Kentucky Street, Lawrence, KS, United States',
					"geo_latitude"		=> '38.95892457569876',
					"geo_longitude"		=> '-95.23837049999997',				
					"job_type"			=> 'freelance', //Full Time,Part Time,freelance
					"alive_days"	=> '30',		
					"promocode"			=> '', 
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo3.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'PDF File Programing',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category" =>	array('Development'),
					);
////Job 28 end///
////Job 29 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name ",	
					"company_web"		=> 'http://www.companyname.com',		
					"company_email"		=> 'info@company_email.com',		
					"job_location"		=> 'Vermont',
					"address"			=> 'Vermont, WI, United States',
					"geo_latitude"		=> '43.07221719200889',
					"geo_longitude"		=> '-89.78567860000004',					
					"job_type"			=> 'Full Time', //Full Time,Part Time,freelance
					"alive_days"	=> '30',		
					"promocode"			=> '', 
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo2.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'Lead Web/Interaction Designer',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category" =>	array('Designer'),
					);
////Job 29 end///
////Job 30 start///
$post_meta = array();
$post_meta = array(
					"company_name"		=> "Company Name",	
					"company_web"		=> 'http://www.companyweb.com',		
					"company_email"		=> 'info@companyname.com',		
					"job_location"		=> 'Connecticut',
					"address"			=> 'Connecticut Avenue, Norwalk, CT, United States',
					"geo_latitude"		=> '41.10072653179946',
					"geo_longitude"		=> '-73.43682654999998',					
					"job_type"			=> 'Part Time', //Full Time,Part Time,freelance
					"alive_days"		=> '30',		
					"promocode"			=> '', 
					"coupon_code"		=> '',
					"company_logo"		=> $dummy_image_path.'logo1.png',
					"how_to_apply"		=> 'The area that describes how an applicant can apply for a job. Add the application process in brief. 
											Provide the direct link or guideline so that the job seekers can reach you easily.',
				);
$post_info[] = array(
					"post_title"	=>	'Iphone Developer',
					"post_content"	=>	'The area to describe a job in brief. Job descriptions are essential. Job descriptions are required for recruitment so that you and the applicants can understand the role. Job descriptions are necessary for all people in work. A job description defines a role of a person and accountability.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category" =>	array('Mobile'),
					);
////Job 30 end///

insert_taxonomy_posts($post_info);
function insert_taxonomy_posts($post_info)
{
	global $wpdb,$current_user;
	for($i=0;$i<count($post_info);$i++)
	{
		$post_title = $post_info[$i]['post_title'];
		$post_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='".CUSTOM_POST_TYPE1."' and post_status in ('publish','draft')");
		if(!$post_count)
		{
			$post_info_arr = array();
			$catids_arr = array();
			$my_post = array();
			$post_info_arr = $post_info[$i];
			$my_post['post_title'] = $post_info_arr['post_title'];
			$my_post['post_content'] = $post_info_arr['post_content'];
			$my_post['post_type'] = CUSTOM_POST_TYPE1;
			if($post_info_arr['post_author'])
			{
				$my_post['post_author'] = $post_info_arr['post_author'];
			}else
			{
				$my_post['post_author'] = 1;
			}
			$my_post['post_status'] = 'publish';
			$my_post['post_category'] = $post_info_arr['post_category'];
			$my_post['tags_input'] = $post_info_arr['post_tags'];
			$my_post['comment_count'] = $post_info_arr['comment_count'];
			$last_postid = wp_insert_post( $my_post );
			add_post_meta($last_postid,'auto_install', "auto_install");
			wp_set_object_terms($last_postid,$post_info_arr['post_category'], $taxonomy=CUSTOM_CATEGORY_TYPE1);
			wp_set_object_terms($last_postid,$post_info_arr['post_tags'], $taxonomy='cartags');

			$post_meta = $post_info_arr['post_meta'];
			if($post_meta)
			{
				foreach($post_meta as $mkey=>$mval)
				{
					update_post_meta($last_postid, $mkey, $mval);
				}
			}
		}
	}
}
function set_post_tag($pid,$post_tags)
{
	global $wpdb;
	$post_tags_arr = explode(',',$post_tags);
	for($t=0;$t<count($post_tags_arr);$t++)
	{
		$posttag = $post_tags_arr[$t];
		$term_id = $wpdb->get_var("SELECT t.term_id FROM $wpdb->terms t join $wpdb->term_taxonomy tt on tt.term_id=t.term_id where t.name=\"$posttag\" and tt.taxonomy='post_tag'");
		if($term_id == '')
		{
			$srch_arr = array('&amp;',"'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," ",';',',','_');
				$replace_arr = array('','','','','','','','','','','','','','','','','','','','',',','','');
			$posttagslug = str_replace($srch_arr,$replace_arr,$posttag);
			$termsql = "insert into $wpdb->terms (name,slug) values (\"$posttag\",\"$posttagslug\")";
			$wpdb->query($termsql);
			$last_termsid = $wpdb->get_var("SELECT max(term_id) as term_id FROM $wpdb->terms");
		}else
		{
			$last_termsid = $term_id;
		}
		$term_taxonomy_id = $wpdb->get_var("SELECT term_taxonomy_id FROM $wpdb->term_taxonomy where term_id=\"$last_termsid\" and taxonomy='post_tag'");
		if($term_taxonomy_id=='')
		{
			$termpost = "insert into $wpdb->term_taxonomy (term_id,taxonomy,count) values (\"$last_termsid\",'post_tag',1)";
			$wpdb->query($termpost);
			$term_taxonomy_id = $wpdb->get_var("SELECT term_taxonomy_id FROM $wpdb->term_taxonomy where term_id=\"$last_termsid\" and taxonomy='post_tag'");
		}else
		{
			$termpost = "update $wpdb->term_taxonomy set count=count+1 where term_taxonomy_id=\"$term_taxonomy_id\"";
			$wpdb->query($termpost);
		}
		$termsql = "insert into $wpdb->term_relationships (object_id,term_taxonomy_id) values (\"$pid\",\"$term_taxonomy_id\")";
		$wpdb->query($termsql);
	}
}

//Add some categories in "Resume" post type.
 $category_array2 = array();
$category_array2 = array('Software engineer','Hardware Engineer','Website Designer','Theme Developer','PHP Programmer');
insert_taxonomy_category1($category_array2);
/*--Function to insert taxonomy category BOF-*/
function insert_taxonomy_category1($category_array2)
{
	global $wpdb;
	for($i=0;$i<count($category_array2);$i++)
	{
		$parent_catid = 0;
		if(is_array($category_array2[$i]))
		{
			$cat_name_arr = $category_array2[$i];
			for($j=0;$j<count($cat_name_arr);$j++)
			{
				$catname = $cat_name_arr[$j];
				if($j>1)
				{
					$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					if(!$catid)
					{
						$last_catid = wp_insert_term( $catname, 'rcategory' );
					}					
				}else
				{
					$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					if(!$catid)
					{
						$last_catid = wp_insert_term( $catname, 'rcategory');
					}
				}
			}
			
		}else
		{
			$catname = $category_array2[$i];
			$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
			if(!$catid)
			{
				wp_insert_term( $catname, 'rcategory');
			}
		}
	}
	
	for($i=0;$i<count($category_array2);$i++)
	{
		$parent_catid = 0;
		if(is_array($category_array2[$i]))
		{
			$cat_name_arr = $category_array2[$i];
			for($j=0;$j<count($cat_name_arr);$j++)
			{
				$catname = $cat_name_arr[$j];
				if($j>0)
				{
					$parentcatname = $cat_name_arr[0];
					$parent_catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$parentcatname\"");
					$last_catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					wp_update_term( $last_catid, 'rcategory', $args = array('parent'=>$parent_catid) );
				}
			}
			
		}
	}
}
// End of "Resume" categories.

//Add some sample Resumes.
$post_info = array();
////Resume 1 start///
$post_meta = array();
$post_meta = array(
					"fname"				=> "Mark",	
					"lname"				=> 'Flournoy',		
					"availability"		=> 'Full Time',		
					"experience"		=> '2',		
					"resume_location"	=> 'Alaska',
					"address"			=> 'Alaskan Way, Seattle, WA, United State',
					"salary"			=> '30000',
					"phone"				=> '564654564564',
					"skills"			=> 'Java Programming',
					"activities"		=> 'Reading',
					"apply_resume"		=> 'Displays a direct link to download the resume.',
				);
$post_info[] = array(
					"post_title"	=>	'Software engineer',
					"post_content"	=>	'The area to describe about yourself. Write in brief about your skills and your strength.Write your hobbies and interests. Write that how can you be helpful to the company.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category"	=>	array('Software engineer'),
					);
////Resume 1 end///
////Resume 2 start///
$post_meta = array();
$post_meta = array(
					"fname"				=> "Ben",	
					"lname"				=> 'McIntosh',		
					"availability"		=> 'Part Time',		
					"experience"		=> '2',		
					"resume_location"	=> 'California',
					"address"			=> 'California Avenue Southwest, Seattle, WA, United States',
					"salary"			=> '30000',
					"phone"				=> '564654564564',
					"skills"			=> 'Computer hardware trouble shooting',
					"activities"		=> 'Reading',
					"apply_resume"		=> 'Displays a direct link to download the resume.',
				);
$post_info[] = array(
					"post_title"	=>	'Hardware Engineer',
					"post_content"	=>	'The area to describe about yourself. Write in brief about your skills and your strength.Write your hobbies and interests. Write that how can you be helpful to the company.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category"	=>	array('Hardware Engineer'),
					);
////Resume 2 end///
////Resume 3 start///
$post_meta = array();
$post_meta = array(
					"fname"				=> "Alison",	
					"lname"				=> 'Wood',		
					"availability"		=> 'Freelance',		
					"experience"		=> '2',		
					"resume_location"	=> 'Florida',
					"address"			=> 'Florida, NY, United States',
					"salary"			=> '30000',
					"phone"				=> '564654564564',
					"skills"			=> 'HTML5',
					"activities"		=> 'Managing people and events',
					"apply_resume"		=> 'Displays a direct link to download the resume.',
				);
$post_info[] = array(
					"post_title"	=>	'Website Designer',
					"post_content"	=>	'The area to describe about yourself. Write in brief about your skills and your strength.Write your hobbies and interests. Write that how can you be helpful to the company.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category"	=>	array('Website Designer'),
					);
////Resume 3 end///
////Resume 4 start///
$post_meta = array();
$post_meta = array(
					"fname"				=> "James",	
					"lname"				=> 'Connors',		
					"availability"		=> 'Full Time',		
					"experience"		=> '2',		
					"resume_location"	=> 'Hawaii',
					"address"			=> 'Hawaiian Gardens, CA, United States',
					"salary"			=> '30000',
					"phone"				=> '564654564564',
					"skills"			=> 'Wordpress',
					"activities"		=> 'Community Service',
					"apply_resume"		=> 'Displays a direct link to download the resume.',
				);
$post_info[] = array(
					"post_title"	=>	'Theme Developer',
					"post_content"	=>	'The area to describe about yourself. Write in brief about your skills and your strength.Write your hobbies and interests. Write that how can you be helpful to the company.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category"	=>	array('Theme Developer'),
					);
////Resume 4 end////
///Resume 5 start///
$post_meta = array();
$post_meta = array(
					"fname"				=> "Cathleen",	
					"lname"				=> 'Cornell',		
					"availability"		=> 'Freelance',		
					"experience"		=> '2',		
					"resume_location"	=> 'Maryland',
					"address"			=> 'Maryland Avenue, Rockville, MD, United States',
					"salary"			=> '30000',
					"phone"				=> '564654564564',
					"skills"			=> 'PHP',
					"activities"		=> 'Writing',
					"apply_resume"		=> 'Displays a direct link to download the resume.',
				);
$post_info[] = array(
					"post_title"	=>	'PHP Programmer',
					"post_content"	=>	'The area to describe about yourself. Write in brief about your skills and your strength.Write your hobbies and interests. Write that how can you be helpful to the company.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category"	=>	array('PHP Programmer'),
					);
////Resume 5 end////
///Resume 6 start///
$post_meta = array();
$post_meta = array(
					"fname"				=> "Amy",	
					"lname"				=> 'Penland',		
					"availability"		=> 'Part Time',		
					"experience"		=> '2',		
					"resume_location"	=> 'Mississippi',
					"address"			=> 'Mississippi Avenue, Takoma Park, MD, United States',
					"salary"			=> '30000',	
					"phone"				=> '564654564564',
					"skills"			=> 'Wordpress',
					"activities"		=> 'Technical Training',
					"apply_resume"		=> 'Displays a direct link to download the resume.',
				);
$post_info[] = array(
					"post_title"	=>	'Theme Developer',
					"post_content"	=>	'The area to describe about yourself. Write in brief about your skills and your strength.Write your hobbies and interests. Write that how can you be helpful to the company.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category"	=>	array('Theme Developer'),
					);
////Resume 6 end////
///Resume 7 start///
$post_meta = array();
$post_meta = array(
					"fname"				=> "Christy",	
					"lname"				=> 'Rudolph',		
					"availability"		=> 'Part Time',		
					"experience"		=> '2',		
					"resume_location"	=> 'Alaska',
					"address"			=> 'Alaskan Way, Seattle, WA, United State',
					"salary"			=> '30000',	
					"phone"				=> '564654564564',
					"skills"			=> 'Photoshop',
					"activities"		=> 'Managing people and events',
					"apply_resume"		=> 'Displays a direct link to download the resume.',
				);
$post_info[] = array(
					"post_title"	=>	'Website Designer',
					"post_content"	=>	'The area to describe about yourself. Write in brief about your skills and your strength.Write your hobbies and interests. Write that how can you be helpful to the company.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category"	=>	array('Website Designer'),
					);
////Resume 7 end////
///Resume 8 start///
$post_meta = array();
$post_meta = array(
					"fname"				=> "Stephen",	
					"lname"				=> 'Tittle',		
					"availability"		=> 'Freelance',		
					"experience"		=> '2',		
					"resume_location"	=> 'Indiana',
					"address"			=> 'Indiana Street, San Francisco, CA, United States',
					"salary"			=> '30000',	
					"phone"				=> '564654564564',
					"skills"			=> 'Hardware trouble shooting',
					"activities"		=> 'Community Service',
					"apply_resume"		=> 'Displays a direct link to download the resume.',
				);
$post_info[] = array(
					"post_title"	=>	'Hardware Engineer',
					"post_content"	=>	'The area to describe about yourself. Write in brief about your skills and your strength.Write your hobbies and interests. Write that how can you be helpful to the company.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category"	=>	array('Hardware Engineer'),
					);
////Resume 8 end////
///Resume 9 start///
$post_meta = array();
$post_meta = array(
					"fname"				=> "Amanda",	
					"lname"				=> 'Davis',		
					"availability"		=> 'Freelance',		
					"experience"		=> '2',		
					"resume_location"	=> 'Alaska',
					"address"			=> 'Alaskan Way, Seattle, WA, United State',
					"salary"			=> '30000',	
					"phone"				=> '564654564564',
					"skills"			=> 'C++ Programming',
					"activities"		=> 'Technical Training',
					"apply_resume"		=> 'Displays a direct link to download the resume.',
				);
$post_info[] = array(
					"post_title"	=>	'Software Engineer',
					"post_content"	=>	'The area to describe about yourself. Write in brief about your skills and your strength.Write your hobbies and interests. Write that how can you be helpful to the company.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category"	=>	array('Software Engineer'),
					);
////Resume 9 end////
///Resume 10 start///
$post_meta = array();
$post_meta = array(
					"fname"				=> "Rebecca",	
					"lname"				=> 'Young',		
					"availability"		=> 'Part Time',		
					"experience"		=> '2',		
					"resume_location"	=> 'Indiana',
					"address"			=> 'Indiana Street, San Francisco, CA, United States',
					"salary"			=> '30000',	
					"phone"				=> '564654564564',
					"skills"			=> 'Wordpress, PHP',
					"activities"		=> 'Managing people and events',
					"apply_resume"		=> 'Displays a direct link to download the resume.',
				);
$post_info[] = array(
					"post_title"	=>	'Wordpress Developer',
					"post_content"	=>	'The area to describe about yourself. Write in brief about your skills and your strength.Write your hobbies and interests. Write that how can you be helpful to the company.',
					"post_meta"		=>	$post_meta,
					"post_feature"	=>	0,
					"post_category"	=>	array('PHP Programmer','Theme Developer'),
					);
////Resume 10 end///

insert_taxonomy_posts1($post_info);
function insert_taxonomy_posts1($post_info)
{
	global $wpdb,$current_user;
	for($i=0;$i<count($post_info);$i++)
	{
		$post_title = $post_info[$i]['post_title'];
		$post_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='".CUSTOM_POST_TYPE2."' and post_status in ('publish','draft')");
		if(!$post_count)
		{
			$post_info_arr = array();
			$catids_arr = array();
			$my_post = array();
			$post_info_arr = $post_info[$i];
			$my_post['post_title'] = $post_info_arr['post_title'];
			$my_post['post_content'] = $post_info_arr['post_content'];
			$my_post['post_type'] = CUSTOM_POST_TYPE2;
			if($post_info_arr['post_author'])
			{
				$my_post['post_author'] = $post_info_arr['post_author'];
			}else
			{
				$my_post['post_author'] = 1;
			}
			$my_post['post_status'] = 'publish';
			$my_post['post_category'] = $post_info_arr['post_category'];
			$my_post['tags_input'] = $post_info_arr['post_tags'];
			$my_post['comment_count'] = $post_info_arr['comment_count'];
			$last_postid = wp_insert_post( $my_post );
			add_post_meta($last_postid,'auto_install', "auto_install");
			wp_set_object_terms($last_postid,$post_info_arr['post_category'], $taxonomy=CUSTOM_CATEGORY_TYPE2);
			wp_set_object_terms($last_postid,$post_info_arr['post_tags'], $taxonomy='cartags');

			$post_meta = $post_info_arr['post_meta'];
			if($post_meta)
			{
				foreach($post_meta as $mkey=>$mval)
				{
					update_post_meta($last_postid, $mkey, $mval);
				}
			}
		}
	}
}

function set_post_info_autorun($post_info_arr)
{
	if(count($post_info_arr)>0)
	{
		global $last_tt_id,$feature_cat_name,$post_author,$wpdb;
		for($p=0;$p<count($post_info_arr);$p++)
		{
			$post_title = $post_info_arr[$p]['post_title'];
			$post_content = $post_info_arr[$p]['post_content'];
			$post_date = date('Y-m-d H:s:i');
			$post_IDs = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like \"$post_title\" and post_type='post'");
			if($post_IDs==0)
			{
				$post_name = strtolower(str_replace(array('&amp;',"'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," ",';',',','_','/'),array('','','','','','','','','','','','','','','','','','','','',',','','',''),$post_title));
				$post_name_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_name like \"$post_name%\" and post_type='post'");
				if($post_name_count>0)
				{
					$post_name = $post_name.'-'.($post_name_count+1);
				}
				$post_sql = "insert into $wpdb->posts (post_author,post_date,post_date_gmt,post_content,post_title,post_name,post_type) values (\"$post_author\", \"$post_date\", \"$post_date\", \"$post_content\", \"$post_title\", \"$post_name\" ,  'post')";
				$wpdb->query($post_sql);
				$last_post_id = $wpdb->get_var("SELECT max(ID) FROM $wpdb->posts");
				$guid = get_option('siteurl')."/?p=$last_post_id";
				$guid_sql = "update $wpdb->posts set guid=\"$guid\" where ID=\"$last_post_id\"";
				$wpdb->query($guid_sql);
				if($post_info_arr[$p]['post_meta'])
				{
					foreach($post_info_arr[$p]['post_meta'] as $mkey=>$mval)
					{
						update_post_meta( $last_post_id, $mkey, $mval );
					}
				}
				update_post_meta( $last_post_id, 'pt_dummy_content', 1 );
				if($post_info_arr[$p]['post_tags'])
				{
					set_post_tag($last_post_id,$post_info_arr[$p]['post_tags']);
				}
				$ter_relation_sql = "insert into $wpdb->term_relationships (object_id,term_taxonomy_id) values (\"$last_post_id\",\"$last_tt_id\")";
				$wpdb->query($ter_relation_sql);
				$post_feature = $post_info_arr[$p]['post_feature'];
				$feature_cat_id = $wpdb->get_var("SELECT term_id FROM $wpdb->terms where name=\"$feature_cat_name\"");
				
				if($post_feature && $feature_cat_id)
				{
					$ter_relation_sql = "insert into $wpdb->term_relationships (object_id,term_taxonomy_id) values (\"$last_post_id\",\"$feature_cat_id\")";
					$wpdb->query($ter_relation_sql);
					$tt_update_sql = "update $wpdb->term_taxonomy set count=count+1 where term_id=\"$feature_cat_id\"";
					$wpdb->query($tt_update_sql);
				}
			}
		}
	}
}
$pages_array = array(array('Page Templates','Contact Us','Archives','Map','Short Codes','Site Map'));
$page_info_arr = array();
$page_info_arr['Page Templates'] = '
<p>We are providing the following page templates with this theme : <br>
	<ul style="margin-left:35px;">
		<li>Archives</li>
		<li>Contact Us</li>
		<li>Map</li>
		<li>Short Codes</li><br>
		and
		<li>Site Map</li>
	</ul></p>
<p>You can create a page with a sidebar by using these page templates.</p>
<p>Follow the below steps to use this page tempate in your site : 
	<ul>
		<ol>1. Go to the Dashboard of your site.</ol>
		<ol>2. Now, Go to Dashboard >> Pages >> Add New Page. </ol>
		<ol>3. Give a title of your choice. Now, you will see "Page Attribute" meta box in the right hand site of the page.<br>
			Looks like : <img src="'.$dummy_image_path.'add_page.png" >
		</ol>
		<ol>4. Now, select a Template from here.</ol>
	</ul></p>
';
$page_info_arr['Contact Us'] = '
<p>Simply designed page template to display a contact form. An easy to use page template to get contacted by the users directly via an email. You can use this page template the same way mentioned in "Page Templates" page. You just need to select <strong>Contact Us</strong> template to use it.</p>
';
$page_info_arr['Archives'] = 'This is Archives page template. Just select <strong>Archives</strong> page template from templates section and you&rsquo;re good to go.';
$page_info_arr['Site Map'] =  '
See, how easy is to use page templates. Just add a new page and select <strong>Sitemap</strong> from the page templates section. Easy peasy, isn&rsquo;t it.
';

$page_info_arr['Short Codes'] = '
This theme comes with built in shortcodes. The shortcodes make it easy to add stylised content to your site, plus they&rsquo;re very easy to use. Below is a list of shortcodes which you will find in this theme.
[ Download ]
[Download] Download: Look, you can use me for highlighting some special parts in a post. I can make download links more highlighted. [/Download]
[ Alert ]
[Alert] Alert: Look, you can use me for highlighting some special parts in a post. I can be used to alert to some special points in a post. [/Alert]
[ Note ]
[Note] Note: Look, you can use me for highlighting some special parts in a post. I can be used to display a note and thereby bringing attention.[/Note]
[ Info ]
[Info] Info: Look, you can use me for highlighting some special parts in a post. I can be used to provide any extra information. [/Info]
[ Author Info ]
[Author Info]<img src="'.$dummy_image_path.'no-avatar.png" alt="" />
<h4>About The Author</h4>
Use me for adding more information about the author. You can use me anywhere within a post or a page, i am just awesome. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing.
[/Author Info]
<h3>Button List</h3>
[ Small_Button class="red" ]
[Small_Button class="red"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="grey"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="black"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="blue"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="lightblue"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="purple"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="magenta"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="green"]<a href="#">Button Text</a>[/Small_Button]  [Small_Button class="orange"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="yellow"]<a href="#">Button Text</a>[/Small_Button] [Small_Button class="pink"]<a href="#">Button Text</a>[/Small_Button]
<hr />
<h3>Icon list view</h3>
[ Icon List ]
[Icon List]
<ul>
	<li> Use the shortcode to add this attractive unordered list</li>
	<li> SEO options in every page and post</li>
	<li> 5 detailed color schemes</li>
	<li> Fully customizable front page</li>
	<li> Excellent Support</li>
	<li> Theme Guide &amp; Tutorials</li>
	<li> PSD File Included with multiple use license</li>
	<li> Gravatar Support &amp; Threaded Comments</li>
	<li> Inbuilt custom widgets</li>
	<li> 30 built in shortcodes</li>
	<li> 8 Page templates</li>
	<li>Valid, Cross browser compatible</li>
</ul>
[/Icon List]
<h3>Dropcaps Content</h3>
[ Dropcaps ] 
[Dropcaps] Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.[/Dropcaps]

[Dropcaps] Dropcaps can be so useful sometimes. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.[/Dropcaps]

<h3>Content boxes</h3>
We, the content boxes can be used to highlight special parts in the post. We can be used anywhere, just use the particular shortcode and we will be there.
[ Normal_Box ]
[Normal_Box]
<h3>Normal Box</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.

[/Normal_Box]

[ Warning_Box ]
[Warning_Box]
<h3>Warring Box</h3>
This is how a warning content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.

[/Warning_Box]

[ Download_Box ]
[Download_Box]
<h3>Download Box</h3>
This is how a download content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.

[/Download_Box]

[ About_Box ]
[About_Box]
<h3>About Box</h3>
This is how about content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus.

[/About_Box]

[ Info_Box ]

[Info_Box]
<h3>Info Box</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.

[/Info_Box]

[ Alert_Box ]
[Alert_Box]
<h3>Alert Box</h3>
This is how alert content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis  ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean  sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at,  odio. Donec et ipsum et sapien vehicula nonummy.

[/Alert_Box]

[Info_Box_Equal]
<h3>Info Box</h3>
This is how info content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna porttitor, felis. Use this shortcode for this type of Info box.<strong> [ Info_Box_Equal ]</strong>
[/Info_Box_Equal]


[Alert_Box_Equal]

<h3>Alert Box</h3>
This is how alert content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna porttitor, felis. Use this shortcode for this type of alert box.<strong> [ Alert_Box_Equal ]</strong>


[/Alert_Box_Equal]

[About_Box_Equal]

<h3>About Box</h3>
This is how about content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, molestie in, commodo  porttitor. Use this shortcode for this type of about box. <strong>[ About_Box_Equal ]</strong>

[/About_Box_Equal]


[One_Half]
<h3>One Half Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, felis. Nam blandit quam ut lacus. <strong>[ One_Half ]</strong>

[/One_Half]


[One_Half_Last]
<h3>One Half Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, felis. Nam blandit quam ut lacus. <strong>[ One_Half_Last ]</strong>

[/One_Half_Last]



[One_Third]
<h3>One Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam ut lacus. <strong>[ One_Third ]</strong>

[/One_Third]


[One_Third]
<h3>One Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in. Commodo  porttitor, felis. Nam lacus. <strong> [ One_Third ]</strong>

[/One_Third]



[One_Third_Last]
<h3>One Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, felis. <strong>[ One_Third_Last ]</strong>

[/One_Third_Last]



[One_Fourth]
<h3>One Fourth Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in to the.<strong>[ One_Fourth ]</strong>

[/One_Fourth]



[One_Fourth]
<h3>One Fourth Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in to the.<strong> [ One_Fourth ]</strong>

[/One_Fourth]


[One_Fourth]
<h3>One Fourth Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in to the.<strong>[ One_Fourth ]</strong>

[/One_Fourth]



[One_Fourth_Last]
<h3>One Fourth Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in to the.<strong>[ One_Fourth_Last ]</strong>

[/One_Fourth_Last]



[One_Third]
<h3>One Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus. <strong>[ One_Third ]</strong>

[/One_Third]



[Two_Third_Last]
<h3>Two Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. in, commodo  porttitor, felis. Nam blandit quam ut lacus.in, commodo  porttitor, felis. Nam blandit quam ut lacus.  <strong> [ Two_Third_Last ]</strong>

[/Two_Third_Last]



[Two_Third]
<h3>Two Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo  porttitor, felis. Nam blandit quam ut lacus. in, commodo  porttitor, felis. Nam blandit quam ut lacus.in, commodo  porttitor, felis. Nam blandit quam ut lacus. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. <strong>[ Two_Third ]</strong>

[/Two_Third]



[One_Third_Last]
<h3>One Third Column</h3>
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam,  justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam  ante ac quam. Maecenas urna purus, commodo  porttitor, felis.  <strong> [ One_Third_Last ]</strong>

[/One_Third_Last]
';
$page_info_arr['Map'] = '<p>Here is for you, a page template that displays a large map with the <strong>Pin Points</strong> of the <strong>Job Locations</strong> added in your site. You can use this page template the same way mentioned in "Page Templates" page. You just need to select <strong>Map</strong> template to use it.</p><br><p>You need to click on the RED pin points to see the job locations.</p>';

set_page_info_autorun($pages_array,$page_info_arr);
function set_page_info_autorun($pages_array,$page_info_arr_arg)
{
	global $post_author,$wpdb;
	$last_tt_id = 1;
	if(count($pages_array)>0)
	{
		$page_info_arr = array();
		for($p=0;$p<count($pages_array);$p++)
		{
			if(is_array($pages_array[$p]))
			{
				for($i=0;$i<count($pages_array[$p]);$i++)
				{
					$page_info_arr1 = array();
					$page_info_arr1['post_title'] = $pages_array[$p][$i];
					$page_info_arr1['post_content'] = $page_info_arr_arg[$pages_array[$p][$i]];
					$page_info_arr1['post_parent'] = $pages_array[$p][0];
					$page_info_arr[] = $page_info_arr1;
				}
			}
			else
			{
				$page_info_arr1 = array();
				$page_info_arr1['post_title'] = $pages_array[$p];
				$page_info_arr1['post_content'] = $page_info_arr_arg[$pages_array[$p]];
				$page_info_arr1['post_parent'] = '';
				$page_info_arr[] = $page_info_arr1;
			}
		}

		if($page_info_arr)
		{
			for($j=0;$j<count($page_info_arr);$j++)
			{
				$post_title = $page_info_arr[$j]['post_title'];
				$post_content = addslashes($page_info_arr[$j]['post_content']);
				$post_parent = $page_info_arr[$j]['post_parent'];
				if($post_parent!='')
				{
					$post_parent_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like \"$post_parent\" and post_type='page'");
				}else
				{
					$post_parent_id = 0;
				}
				$post_date = date('Y-m-d H:s:i');
				
				$post_name = strtolower(str_replace(array('&amp;',"'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," ",';',',','_','/'),array('','','','','','','','','','','','','','','','','','','','',',','','',''),$post_title));
				$post_name_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title=\"$post_title\" and post_type='page'");
				if($post_name_count>0)
				{
					$post_name = $post_name.'-'.($post_name_count+1);
				}
				$post_id_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='page'");
				if($post_id_count==0)
				{
					$post_sql = "insert into $wpdb->posts (post_author,post_date,post_date_gmt,post_title,post_content,post_name,post_parent,post_type) values (\"$post_author\", \"$post_date\", \"$post_date\",  \"$post_title\", \"$post_content\", \"$post_name\",\"$post_parent_id\",'page')";
					$wpdb->query($post_sql);
					$last_post_id = $wpdb->get_var("SELECT max(ID) FROM $wpdb->posts");
					$guid = get_option('siteurl')."/?p=$last_post_id";
					$guid_sql = "update $wpdb->posts set guid=\"$guid\" where ID=\"$last_post_id\"";
					$wpdb->query($guid_sql);
					$ter_relation_sql = "insert into $wpdb->term_relationships (object_id,term_taxonomy_id) values (\"$last_post_id\",\"$last_tt_id\")";
					$wpdb->query($ter_relation_sql);
					update_post_meta( $last_post_id, 'pt_dummy_content', 1 );
				}
			}
		}
	}
}

//Update the page templates
$page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Contact Us' and post_type='page'");
update_post_meta( $page_id, '_wp_page_template', 'tpl_contact.php' );

$page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Archives' and post_type='page'");
update_post_meta( $page_id, '_wp_page_template', 'tpl_archives.php' );

$page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Site Map' and post_type='page'");
update_post_meta( $page_id, '_wp_page_template', 'tpl_sitemap.php' );

$page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Short Codes' and post_type='page'");
update_post_meta( $page_id, '_wp_page_template', 'tpl_short_code.php' );

$page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Map' and post_type='page'");
update_post_meta( $page_id, '_wp_page_template', 'tpl_map.php' );

/////////////// Design Settings START ///////////////
update_option("site_email_id",get_option('admin_email'));
update_option("jobpost_default_status",'publish');
update_option("jobpost_status_after_expiry",'draft');
update_option("pt_show_postajoblink",'Yes');
update_option("pt_show_postacomment",'No');
update_option("pt_includepages",'1,2'); ////
update_option("pt_blog_cat",'Blog');
update_option("pt_excludepages",'1,2'); ////
update_option("ptthemes_logo_url",get_template_directory_uri()."/images/logo.png");
update_option("approve_status","Draft");
update_option("ptthemes_package_type","Pay per job listing");
update_option("pt_body_color",'red');
update_option("pt_ad_one",$dummy_image_path.'advt_244x188.png');
update_option("pt_ad_one_link",'http://templatic.com/');
update_option("pt_feedburner_id");
update_option("ptthemes_feedburner_url",'http://feeds.feedburner.com/Templatic');
update_option("pt_twitter_id");
update_option("pt_body_color",'red');
update_option("ptthemes_show_menu",'Yes');
update_option("ptthemes_footer_text",'<p class="by"> <span class="themeby"> JobBoard theme by</span>  <span class="templatic"><a href="http://templatic.com" target="_blank" title="Templatic.com"  >Templatic.com</a> </span>  </p>');
update_option("pttthemes_milestone_unit",'Miles');


/////////////// Design Settings END ///////////////

/////////////// WIDGET SETTINGS START ///////////////

/////////////////////////////////////////////////////////////////////////////////
$advt = array();
$advt[1] = array(
					"advt1"				=>	$dummy_image_path.'advt_244x188.png',
					"advt_link1"		=>	'#',
					);
$advt['_multiwidget'] = '1';
update_option('widget_widget_advt',$advt);
$advt = get_option('widget_widget_advt');
krsort($advt);
foreach($advt as $key1=>$val1)
{
	$advt_key = $key1;
	if(is_int($advt_key))
	{
		break;
	}
}

/////////////////////////////////////////////////////////////////////////////////
$dashboard = array();
$dashboard[1] = array(
					"title"				=>	'',
					);
$dashboard['_multiwidget'] = '1';
update_option('widget_listing_link',$dashboard);
$dashboard = get_option('widget_listing_link');
krsort($dashboard);
foreach($dashboard as $key1=>$val1)
{
	$dashboard_key = $key1;
	if(is_int($dashboard_key))
	{
		break;
	}
}


$text_info = array();
$text_info[1] = array(
					"title"				=>	'About Us',
					"text"				=>	'This is a default <strong>Text</strong> widget. Here you can write in brief about your company.<br>
											For Example : This Job Board is for Job Providers and Job Seekers. It is all about giving someone a career footstep or getting a dream job.',
					"filter"			=>	'',
					);
$text_info['_multiwidget'] = '1';
update_option('widget_text',$text_info);
$text_info = get_option('widget_text');
krsort($text_info);
foreach($text_info as $key1=>$val1)
{
	$text_info_key = $key1;
	if(is_int($text_info_key))
	{
		break;
	}
}


$feature_info = array();
$feature_info[1] = array(
					"title"				=>	'Featured Companies',
					"logo1"				=>	$dummy_image_path.'c1.png',
					"url1"				=>	'http://www.templatic.com',
					"logo2"				=>	$dummy_image_path.'c2.png',
					"url2"				=>	'http://www.google.com',
					"logo3"				=>	$dummy_image_path.'c3.png',
					"url3"				=>	'http://www.templatic.com/demo/jobBoard',
					"logo4"				=>	$dummy_image_path.'c4.png',
					"url4"				=>	'http://www.templatic.com/demo/eshop',
					);
$feature_info['_multiwidget'] = '1';
update_option('widget_example_widget',$feature_info);
$feature_info = get_option('widget_example_widget');
krsort($feature_info);
foreach($feature_info as $key1=>$val1)
{
	$feature_info_key = $key1;
	if(is_int($feature_info_key))
	{
		break;
	}
}
$sidebars_widgets["home-page-sidebar"] = array("listing_link-$dashboard_key","widget_advt-$advt_key",'text-'.$text_info_key,'example-widget-'.$feature_info_key);
$sidebars_widgets["post-job-sidebar"] = array("listing_link-$dashboard_key","widget_advt-$advt_key",'text-'.$text_info_key,'example-widget-'.$feature_info_key);
$sidebars_widgets["post-resume-sidebar"] = array("listing_link-$dashboard_key","widget_advt-$advt_key",'text-'.$text_info_key,'example-widget-'.$feature_info_key);

/////////////////////////////////////////////////////////////////////////////////
$search = array();
$search[1] = array(
					"title"				=>	'',
					);
$search['_multiwidget'] = '1';
update_option('widget_templ_searchbyjob',$search);
$search = get_option('widget_templ_searchbyjob');
krsort($search);
foreach($search as $key1=>$val1)
{
	$search_key = $key1;
	if(is_int($search_key))
	{
		break;
	}
}

$sidebars_widgets["header-search-widget-area"] = array("templ_searchbyjob-$search_key");


/////////////////////////////////////////////////////////////////////////////////
$social = array();
$social[1] = array(
					"title"	=>	'',
					"twitter" => 'http://www.twitter.com/templatic',
					"facebook" => 'http://www.facebook.com/templatic',
					"email" => 'mailto:',
					"rss" => 'http://feeds.feedburner.com/Templatic',
					);
$social['_multiwidget'] = '1';
update_option('widget_social_media',$social);
$social = get_option('widget_social_media');
krsort($social);
foreach($social as $key1=>$val1)
{
	$social_key = $key1;
	if(is_int($social_key))
	{
		break;
	}
}

$sidebars_widgets["header-top-right-widget-area"] = array("social_media-$social_key");

//Latest Jobs widget =======================================================================
$latest_job_info = array();
$latest_job_info[1] = array(
					"title"				=>	'Recently Added Jobs',
					"post_number"		=>	'3',
					"category"			=>	'',
					);
$latest_job_info['_multiwidget'] = '1';
update_option('widget_tmpl_latest_job',$latest_job_info);
$latest_job_info = get_option('widget_tmpl_latest_job');
krsort($latest_job_info); 
foreach($latest_job_info as $key2=>$val2)
{
	$latest_job_info_key = $key2; 
	if(is_int($latest_job_info_key))
	{
		break;
	}
}

// Categories widget
$cat_info = array();
$cat_info[1] = array(
					"title"				=>	'Job Categories',
					"post_category_type"=>	'Job',
					"show_count"		=>	'0',
					);
$cat_info['_multiwidget'] = '1';
update_option('widget_cat_listing',$cat_info);
$cat_info = get_option('widget_cat_listing');
krsort($cat_info); 
foreach($cat_info as $key2=>$val2)
{
	$cat_info_key = $key2; 
	if(is_int($cat_info_key))
	{
		break;
	}
}

// Other jobs listed by the company widget
$other_jobs_info = array();
$other_jobs_info[1] = array(
					"title"				=>	'Other jobs listed by the company',
					"post_number"		=>	'5',
					"category"			=>	'',
					);
$other_jobs_info['_multiwidget'] = '1';
update_option('widget_tmpl_other_job',$other_jobs_info);
$other_jobs_info = get_option('widget_tmpl_other_job');
krsort($other_jobs_info); 
foreach($other_jobs_info as $key2=>$val2)
{
	$other_jobs_info_key = $key2; 
	if(is_int($other_jobs_info_key))
	{
		break;
	}
}

$sidebars_widgets["job-listing-area"] = array("listing_link-$dashboard_key","widget_advt-$advt_key","tmpl_latest_job-$latest_job_info_key","cat_listing-$cat_info_key");
$sidebars_widgets["job-detail-area"] = array("listing_link-$dashboard_key","tmpl_latest_job-$latest_job_info_key","tmpl_other_job-$other_jobs_info_key");

//Latest Resume widget
$latest_resume_info = array();
$latest_resume_info[1] = array(
					"title"				=>	'Recently Added Resumes',
					"post_number"		=>	'3',
					"category"			=>	'',
					);
$latest_resume_info['_multiwidget'] = '1';
update_option('widget_tmpl_latest_resume',$latest_resume_info);
$latest_resume_info = get_option('widget_tmpl_latest_resume');
krsort($latest_resume_info); 
foreach($latest_resume_info as $key3=>$val3)
{
	$latest_resume_info_key = $key3; 
	
	if(is_int($latest_resume_info_key))
	{
		break;
	}
}

// Categories widget
$cat_info = array();
$cat_info[1] = array(
					"title"				=>	'Resume Categories',
					"post_category_type"=>	'Resume',
					"show_count"		=>	'0',
					);
$cat_info['_multiwidget'] = '1';
update_option('widget_cat_listing',$cat_info);
$cat_info = get_option('widget_cat_listing');
krsort($cat_info); 
foreach($cat_info as $key2=>$val2)
{
	$cat_info_key = $key2; 
	if(is_int($cat_info_key))
	{
		break;
	}
}

$sidebars_widgets["resume-listing-area"] = array("listing_link-$dashboard_key","widget_advt-$advt_key","tmpl_latest_resume-$latest_resume_info_key","cat_listing-$cat_info_key");
$sidebars_widgets["resume-detail-area"] = array("listing_link-$dashboard_key","tmpl_latest_resume-$latest_resume_info_key");

update_option('sidebars_widgets',$sidebars_widgets);  //save widget iformations
/////////////// WIDGET SETTINGS END ///////////////


?>