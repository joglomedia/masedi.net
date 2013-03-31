<?php
session_start();
global $wpdb;
global $current_user;
$current_user_id = $current_user->ID;
if($current_user->ID=='' && $_SESSION['resume_info'])
{
	include_once(TEMPLATEPATH . '/library/includes/single_page_checkout_insertuser_resume.php');
}

if($_POST)
{	
	if($_POST['paynow'])
	{
		$resume_info = $_SESSION['resume_info'];
		$custom = array("availability" 		=> $resume_info['availability'],
					"resume_location"	=> $resume_info['resume_location'],					
					"salary"				=> $resume_info['salary'],
					"experience"		=>  $resume_info['experience'],
					);
		$post_title = $resume_info['resume_title'];
		$description = $resume_info['resume_desc'];
		$catids_arr = array();
		$my_post = array();
		if($_REQUEST['pid'] && $resume_info['renew']=='')
		{
			$my_post['ID'] = $_POST['pid'];
			$my_post['post_status'] = get_post_status($_POST['pid']);
		}else
		{
			$post_default_status = get_default_status();
			$my_post['post_status'] = $post_default_status;
		}
		if($current_user_id)
		{
			$my_post['post_author'] = $current_user_id;
		}
		$my_post['post_title'] = $post_title;
		$my_post['post_name'] = $post_name;
		$my_post['post_content'] = $description;
		$my_post['post_excerpt'] = $post_excerpt;
		$my_post['post_type'] = CUSTOM_POST_TYPE2;
		if($resume_info['category'])
		{	
			$post_category = $resume_info['category'];
		}
		
		if($_REQUEST['pid'])
		{
			if($resume_info['renew'])
			{
				$post_status = get_option('ptthemes_listing_ex_status');
				if($post_status==''){
					$post_status ='publish';
				}
				$my_post['post_date'] = date('Y-m-d H:i:s');
				$my_post['post_status'] = $post_status;
				$my_post['ID'] = $_REQUEST['pid'];
				$last_postid = wp_insert_post($my_post);	
			}else
			{
				$last_postid = wp_update_post($my_post);
			}
		}else
		{
			$last_postid = wp_insert_post( $my_post ); //Insert the post into the database
		}
		global $custom_post_meta_db_table_name;
				$sql = "select * from $custom_post_meta_db_table_name where is_active=1  and (post_type='".CUSTOM_POST_TYPE2."' or post_type='both')";
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
					if($_SESSION['resume_info'][$post_meta_info_obj->htmlvar_name] != ""){
						if($post_meta_info_obj->htmlvar_name != "category" && $post_meta_info_obj->htmlvar_name != "resume_title")
						{
							$custom[$post_meta_info_obj->htmlvar_name] = $resume_info[$post_meta_info_obj->htmlvar_name];
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
								if($resume_info['renew'])
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
						if($resume_info['renew']) {	
							$cat_cntcat = $wpdb->query("INSERT INTO " . $termtable . "(object_id, term_taxonomy_id, term_order)VALUES ('".$post_id."','".$resume_info['category']."','0') ");
						} else {
							$cat_cntcat = $wpdb->query("UPADTE " . $termtable . " set object_id = '".$post_id."',term_taxonomy_id = '".$resume_info['category']."',term_order = '0')");	
						}
					} else {
						$cat_cntcat = $wpdb->query("INSERT INTO " . $termtable . "(object_id, term_taxonomy_id, term_order)VALUES ('".$post_id."','".$resume_info['category']."','0') ");
					}
				}
		}
		if($_SESSION["file_info"])
		{
			update_post_meta($last_postid,'attachment',$_SESSION["file_info"]);
		}
		if(!$_REQUEST['pid']){
		update_post_meta($last_postid, 'remote_ip',getenv('REMOTE_ADDR'));
		update_post_meta($last_postid,'ip_status',$_SESSION['resume_info']['ip_status']);
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
				$email_subject = __('New Resume listing of ID:#'.$last_postid);	
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
				$email_subject_user = __(sprintf('New resume listing of ID:#%s',$last_postid));	
			}
			if(!$email_content_user)
			{
				$email_content_user = __('<p>Dear [#to_name#],</p><p>A New resume has been submitted by you . Here is the information about the Resume:</p>[#information_details#]<br><p>[#site_name#]</p>');
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
			$_SESSION['resume_info'] = array();
			$_SESSION["file_info"] = array();	
		}
		
		if($_REQUEST['pid']>0 && $resume_info['renew']=='')
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
			}
		}
	}
}
?>