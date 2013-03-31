<?php
session_start();
global $wpdb;
$job_price_info = get_job_price_info($_SESSION['job_info']['price_select'],$_SESSION['job_info']['total_price']);
$job_price_info = $job_price_info[0];
$payable_amount = $job_price_info['price'];
if($_SESSION['job_info']['job_add_coupon'])
{
	$payable_amount = get_payable_amount_with_coupon($payable_amount,$_SESSION['job_info']['job_add_coupon']);
}

if($_REQUEST['pid']=='' && $_REQUEST['paymentmethod'] == '' && $payable_amount>0)
{
	wp_redirect(get_option( 'siteurl' ).'/?page=preview&msg=nopaymethod');
	exit;
}
global $current_user;
$current_user_id = $current_user->ID;
if($current_user->ID=='' && $_SESSION['job_info'])
{
	include_once(TEMPLATEPATH . '/library/includes/single_page_checkout_insertuser.php');
}

if($_POST)
{	
	if($_POST['paynow'])
	{
		$job_info = $_SESSION['job_info'];
		$custom = array("address" 		=> $job_info['address'],
					"geo_latitude"		=> $job_info['geo_latitude'],
					"geo_longitude"		=> $job_info['geo_longitude'],
					"location"	=> $job_info['location'],					
					"price"				=> str_replace(',','',$job_info['price']),
					"rentperiod"	=> $job_info['rentperiod'],
					"area"				=> str_replace(',','',$job_info['area']),
					"additional_features" => $job_info['additional_features'],
					"job_type"		=>  $job_info['job_type'],
					"total_price"		=>  $job_info['total_price'],
					"featured_type"		=>  $job_info['featured_type'],
					"job_add_coupon" => $job_info['job_add_coupon'],
					"language"			=>  $job_info['language']
					);
		$post_title = $job_info['position_title'];
		$post_address = $job_info['address'];
		$latitude = $job_info['geo_latitude'];
		$longitude = $job_info['geo_longitude'];
		$location = $job_info['job_location'];
		$description = $job_info['job_desc'];
		$catids_arr = array();
		$my_post = array();
		if($_REQUEST['pid'] && $job_info['renew']=='')
		{
			$my_post['ID'] = $_POST['pid'];
			if($job_info['remove_feature'] !='' && $job_info['remove_feature']=='0' && in_category(get_cat_id_from_name(get_option('ptthemes_featuredcategory')),$_REQUEST['pid']))
			{
				$catids_arr[] = get_cat_id_from_name(get_option('ptthemes_featuredcategory'));	
			}
			$my_post['post_status'] = get_post_status($_POST['pid']);
		}else
		{
			
			$custom['paid_amount'] = $payable_amount;
			if($_REQUEST['pid'] !='' && $job_price_info['alive_days']=="")
				$custom['alive_days'] = 'Unlimited';
			if($job_info['alive_days'])
				$custom['alive_days'] = $job_price_info['alive_days'];
			$custom['paymentmethod'] = $_REQUEST['paymentmethod'];
			$custom['coupon_code'] = $job_info['job_add_coupon'];

			if($job_price_info['is_feature'] && get_cat_id_from_name(get_option('ptthemes_featuredcategory')))
			{
				$catids_arr[] = get_cat_id_from_name(get_option('ptthemes_featuredcategory'));
			}
			if($payable_amount>0)
			{
				$post_default_status = 'draft';
			}else
			{
				$post_default_status = get_default_status();
			}			
			$my_post['post_status'] = $post_default_status;
		}
		if($current_user_id)
		{
			$my_post['post_author'] = $current_user_id;
		}
		$my_post['post_title'] = $post_title;
		$my_post['post_name'] = $post_name;
		$my_post['post_content'] = $description;
		$my_post['post_category'] = $job_price_info['category'];
		$my_post['post_excerpt'] = $post_excerpt;
		$my_post['post_type'] = CUSTOM_POST_TYPE1;
		if($job_info['category'])
		{	
			$post_category = $job_info['category'];
		}
		
		if($_REQUEST['pid'])
		{
			if($job_info['renew'])
			{
				$post_status = get_option('ptthemes_listing_ex_status');
				if($post_status==''){
					$post_status ='publish';
				}
				$my_post['post_date'] = date('Y-m-d H:i:s');
				$my_post['post_status'] = $post_status;
				$custom['paid_amount'] = $payable_amount;
				$custom['alive_days'] = $job_price_info['alive_days'];
				$custom['paymentmethod'] = $_REQUEST['paymentmethod'];
				$my_post['ID'] = $_REQUEST['pid'];
				$last_postid = wp_insert_post($my_post);	
			}else
			{
				$last_postid = wp_update_post($my_post);
			}
			update_post_meta($last_postid, 'remote_ip',getenv('REMOTE_ADDR'));
			/* Update data for radius search BOF*/
			global $wpdb;
			$pcid = $wpdb->get_var("select pcid from $tbl_postcodes where post_id = '".$last_postid."'");
			$tbl_postcodes = $table_prefix . "postcodes";
			$postcodes_update = "UPDATE $tbl_postcodes set 
				location = '".$location."',
				address = '".$post_address."',
				latitude ='".$latitude."',
				longitude='".$longitude."' where pcid = '".$pcid."' and post_id = '".$last_postid."'";
			$wpdb->prepare($wpdb->query($postcodes_update));
			/* Update data for radius search EOF*/
		}else
		{
			$last_postid = wp_insert_post( $my_post ); //Insert the post into the database
			/* Insert data for radius search BOF*/
			global $wpdb;
			$tbl_postcodes = $table_prefix . "postcodes";
			$postcodes_insert = 'INSERT INTO '.$tbl_postcodes.' set 
			pcid="",
			post_id="'.$last_postid.'",
			location = "'.$location.'",
			address = "'.$post_address.'",
			latitude ="'.$latitude.'",
			longitude="'.$longitude.'"';
			$wpdb->prepare($wpdb->query($postcodes_insert));
			/* Insert data for radius search EOF*/
		}
		$custom["paid_amount"] = $payable_amount;
		//$custom["coupon_code"] = $coupon_code;
		global $custom_post_meta_db_table_name;
				$sql = "select * from $custom_post_meta_db_table_name where is_active=1  and (post_type='".CUSTOM_POST_TYPE1."' or post_type='both')";
				if($fields_name)
				{
					$fields_name = '"'.str_replace(',','","',$fields_name).'"';
					$sql .= " and htmlvar_name in ($fields_name) ";
				}
				$sql .=  " order by sort_order asc,cid asc";
				$post_meta_info = $wpdb->get_results($sql);
				$i = 0;
				foreach($post_meta_info as $post_meta_info_obj){
					if($post_meta_info_obj->ctype =='text' || $post_meta_info_obj->ctype =='texteditor' || $post_meta_info_obj->ctype =='select' || $post_meta_info_obj->ctype =='radio' || $post_meta_info_obj->ctype =='textarea' || $post_meta_info_obj->ctype =='date' || $post_meta_info_obj->ctype =='multicheckbox'){
					if($_SESSION['job_info'][$post_meta_info_obj->htmlvar_name] != ""){
						if($post_meta_info_obj->htmlvar_name != "category" && $post_meta_info_obj->htmlvar_name != "address" && $post_meta_info_obj->htmlvar_name != "geo_latitude" && $post_meta_info_obj->htmlvar_name != "geo_longitude" && $post_meta_info_obj->htmlvar_name != "position_title")
						{
							$custom[$post_meta_info_obj->htmlvar_name] = $job_info[$post_meta_info_obj->htmlvar_name];
						}
					 
					 
					 }
		}
		}
		if(!$custom['featured_type'])
		  {
			  $custom['featured_type'] = 'none';
			  $custom['featured_c'] = 'n';
			  $custom['featured_h'] = 'n';
		  }
		if($custom['featured_type'] == 'c')
		 {
			 $custom['featured_h'] = 'n';
			 $custom['featured_c'] = 'c';
		 }
		if($custom['featured_type'] == 'h')
		 {
			 $custom['featured_c'] = 'n';
			 $custom['featured_h'] = 'h';
		 }
 		if($custom['featured_type'] == 'both')
		 {
			 $custom['featured_c'] = 'c';
			 $custom['featured_h'] = 'h';
		 }
 		if($custom['featured_type'] == 'none')
		 {
			 $custom['featured_c'] = 'n';
			 $custom['featured_h'] = 'n';
		 }
		
		foreach($custom as $key=>$val)
		{				
			update_post_meta($last_postid, $key, $val);
		}
		
		
		
		/* Transaction Reoprt */
		global $wpdb;
		$paymentmethod = $_REQUEST['paymentmethod'];
		if($paymentmethod !="" && $last_postid !=""){
		$post_author  = $wpdb->get_row("select * from $wpdb->posts where ID = '".$last_postid."'") ;
		$post_author  = $post_author->post_author ;
		$uinfo = get_userdata($post_author);
		$user_fname = $uinfo->display_name;
		$user_email = $uinfo->user_email;
		$user_billing_name = $uinfo->display_name;
		$billing_Address = '';
		global $transection_db_table_name;
		$transaction_insert = 'INSERT INTO '.$transection_db_table_name.' set 
		post_id="'.$last_postid.'",
		user_id = "'.$post_author.'",
		post_title ="'.$post_title.'",
		payment_method="'.$paymentmethod.'",
		payable_amt='.$payable_amount.',
		payment_date="'.date("Y-m-d H:i:s").'",
		paypal_transection_id="",
		status="0",
		user_name="'.$user_fname.'",
		pay_email="'.$user_email.'",
		billing_name="'.$user_billing_name.'",
		billing_add="'.$billing_Address.'"';
		}
		$wpdb->query($transaction_insert);
		/* End Transaction Report */
		if($post_category != '' )
		{	global $wpdb;
			$termtable = $wpdb->prefix."term_relationships";
				$post_id = $last_postid;
				if(is_array($post_category)) {
					$cat = implode("-",$post_category);
					$category = explode("-",$cat);
					for($cat_cnt =0; $cat_cnt <= count($category); $cat_cnt++)
						{
						 if($category[$cat_cnt] != "" && $post_id != "")
						   {
							 $mycat = explode(',',$category[$cat_cnt]);						
							 if($_REQUEST['pid'])
							  {
								if($job_info['renew'])
								  {
									$cat_cntcat = $wpdb->query("INSERT INTO " . $termtable . "(object_id, term_taxonomy_id, term_order)VALUES ('".$post_id."','".$mycat[0]."','0') ");
								  }
								  else
								  {
									$selobj = $wpdb->get_row("select * from " . $termtable . " where object_id = '".$post_id."' and term_taxonomy_id = '".$mycat[0]."'");
									if(mysql_affected_rows() > 0)
									  {
										$cat_cntcat = $wpdb->query("UPADTE " . $termtable . " set object_id = '".$post_id."',term_taxonomy_id = '".$mycat[0]."',term_order = '0')");
									  }
									  else
									  {
										$cat_cntcat = $wpdb->query("INSERT INTO " . $termtable . "(object_id, term_taxonomy_id, term_order)VALUES ('".$post_id."','".$mycat[0]."','0') ");
								      }
								  }
							 } else {
								$cat_cntcat = mysql_query("INSERT INTO " . $termtable . "(object_id, term_taxonomy_id, term_order)VALUES ('".$post_id."','".$mycat[0]."','0') ");
							} 
						}
					}
				} else {
					if($_REQUEST['pid']){
						if($job_info['renew']) {	
							$cat_cntcat = $wpdb->query("INSERT INTO " . $termtable . "(object_id, term_taxonomy_id, term_order)VALUES ('".$post_id."','".$job_info['category']."','0') ");
						} else {
							$cat_cntcat = $wpdb->query("UPADTE " . $termtable . " set object_id = '".$post_id."',term_taxonomy_id = '".$job_info['category']."',term_order = '0')");	
						}
					} else {
						$cat_cntcat = $wpdb->query("INSERT INTO " . $termtable . "(object_id, term_taxonomy_id, term_order)VALUES ('".$post_id."','".$job_info['category']."','0') ");
					}
				}
		}
		if($_SESSION["file_info"])
		{
			update_post_meta($last_postid,'company_logo',$_SESSION["file_info"]);
		}
		if(!$_REQUEST['pid']){
		update_post_meta($last_postid, 'remote_ip',getenv('REMOTE_ADDR'));
		update_post_meta($last_postid,'ip_status',$_SESSION['job_info']['ip_status']);
		}
	
		///////ADMIN EMAIL START//////
			$fromEmail = get_site_emailId();
			$fromEmailName = get_site_emailName();
			$store_name = get_option('blogname');
			$email_content = get_option('post_submited_success_email_content');
			$email_subject = get_option('post_submited_success_email_subject');
			
			$email_content_user = get_option('post_submited_success_email_user_content');
			$email_subject_user = get_option('post_submited_success_email_user_subject');
			
			if(!$email_subject)
			{
				$email_subject = __('New Job listing of ID:#'.$last_postid);	
			}
			if(!$email_content)
			{
				$email_content = __('<p>Dear [#to_name#],</p>
				<p>A New listing has been submitted on your site. Here is the information about the listing:</p>
				[#information_details#]
				<br>
				<p>[#site_name#]</p>');
			}
			
			if(!$email_subject_user)
			{
				$email_subject_user = __(sprintf('New job listing of ID:#%s',$last_postid));
			}
			if(!$email_content_user)
			{
				$email_content_user = __('<p>Dear [#to_name#],</p><p>A New job has been submitted by you . Here is the information about the Job:</p>[#information_details#]<br><p>[#site_name#]</p>');
			}
			
			$information_details = "<p>".__('ID')." : ".$last_postid."</p>";
			$information_details .= '<p>'.__('View more detail from').' <a href="'.get_permalink($last_postid).'">'.$my_post['post_title'].'</a></p>';
			
			$search_array = array('[#to_name#]','[#information_details#]','[#site_name#]');
			$replace_array_admin = array($fromEmail,$information_details,$store_name);
			$replace_array_client =  array($user_email,$information_details,$store_name);
			$email_content_admin = str_replace($search_array,$replace_array_admin,$email_content);
			$email_content_client = str_replace($search_array,$replace_array_client,$email_content_user);

				templ_sendEmail($user_email,$user_fname,$fromEmail,$fromEmailName,$email_subject,$email_content_admin,$extra='');///To admin email
				templ_sendEmail($fromEmail,$fromEmailName,$user_email,$user_fname,$email_subject_user,$email_content_client,$extra='');//to client email
		//////ADMIN EMAIL END////////

		if($_REQUEST['paymentmethod']!='authorizenet')
		{
			$_SESSION['job_info'] = array();
			$_SESSION["file_info"] = array();	
		}
		
		if($_REQUEST['pid']>0 && $job_info['renew']=='')
		{
			wp_redirect(get_author_link($echo = false, $current_user->ID));
			exit;
		}else
		{
			if($payable_amount == '' || $payable_amount <= 0)
			{
				$suburl .= "&pid=$last_postid";
				wp_redirect(get_option('siteurl')."/?page=success$suburl");
				exit;
			}else
			{
				$paymentmethod = $_REQUEST['paymentmethod'];
				$paymentSuccessFlag = 0;
				if($paymentmethod == 'prebanktransfer' || $paymentmethod == 'payondelevary')
				{
					if($job_info['renew'])
					{
						$suburl = "&renew=1";
					}
					$suburl .= "&pid=$last_postid";
					wp_redirect(get_option('siteurl').'/?page=success&paydeltype='.$paymentmethod.$suburl);
				}
				else
				{
					if(file_exists( TEMPLATEPATH.'/library/payment/'.$paymentmethod.'/'.$paymentmethod.'_response.php'))
					{
						include_once(TEMPLATEPATH.'/library/payment/'.$paymentmethod.'/'.$paymentmethod.'_response.php');
					}
				}
				exit;	
			}
		}
	}
}
?>