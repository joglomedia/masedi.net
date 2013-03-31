<?php
if($_POST && !$userInfo)
{
	if (  $_SESSION['job_info']['user_email'] == '' )
	{
		echo "<div class=error_msg>".__('Email for Contact Details is Empty. Please enter Email, your all informations will sent to your Email.')."</div>";	
		echo '<h6><b><a href="'.get_option('siteurl').'/?page=postajob&backandedit=1">Return to '.__(SUBMIT_PROPERTY_TEXT).'</a></b></h6>';
		exit;
	}
	
	require( 'wp-load.php' );
	require(ABSPATH.'wp-includes/registration.php');
	
	global $wpdb;
	$errors = new WP_Error();
	
	$user_email = $_SESSION['job_info']['user_email'];
	$user_login = $_SESSION['job_info']['user_fname'];
	$user_login = sanitize_user( $user_login );
	$user_email = apply_filters( 'user_registration_email', $user_email );
	
	// Check the username
	if ( $user_login == '' )
		$errors->add('empty_username', __('ERROR: Please enter a username.'));
	elseif ( !validate_username( $user_login ) ) {
		$errors->add('invalid_username', __('<strong>ERROR</strong>: This username is invalid.  Please enter a valid username.'));
		$user_login = '';
	} elseif ( username_exists( $user_login ) )
		$errors->add('username_exists', __('<strong>ERROR</strong>: '.$user_email.' This username is already registered, please choose another one.'));

	// Check the e-mail address
	if ($user_email == '') {
		$errors->add('empty_email', __('<strong>ERROR</strong>: Please type your e-mail address.'));
	} elseif ( !is_email( $user_email ) ) {
		$errors->add('invalid_email', __('<strong>ERROR</strong>: The email address isn&#8217;t correct.'));
		$user_email = '';
	} elseif ( email_exists( $user_email ) )
		$errors->add('email_exists', __('<strong>ERROR</strong>: '.$user_email.' This email is already registered, please choose another one.'));

	do_action('register_post', $user_login, $user_email, $errors);	
	
	$errors = apply_filters( 'registration_errors', $errors );
	if($errors)
	{
		echo "<br><br><br><br><br>";
		foreach($errors as $errorsObj)
		{
			foreach($errorsObj as $key=>$val)
			{
				for($i=0;$i<count($val);$i++)
				{
					echo "<div class=error_msg>".$val[$i].'</div>';	
				}
			} 
		}
		echo "<br><br><br>";
	}	
	if ( $errors->get_error_code() )
	{
		echo '<h6><b><a href="'.get_option('siteurl').'/?page=postajob&backandedit=1">Return to '.__(SUBMIT_PROPERTY_TEXT).'</a></b></h6>';
		exit;
	}
		
	$user_pass = wp_generate_password(12,false);
	$user_id = wp_create_user( $user_login, $user_pass, $user_email );
	$crd = array();
	$crd['user_login'] = $user_login;
	$crd['user_password'] = $user_pass;
	$crd['remember'] = true;
	$user = wp_signon($crd, false );
	if ( !$user_id ) {
		$errors->add('registerfail', sprintf(__('<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:%s">webmaster</a> !'), get_option('admin_email')));
		exit;
	}
	
	$user_fname = $_SESSION['job_info']['user_fname'];
	$user_phone = $_SESSION['job_info']['user_phone'];
	$userName = $_SESSION['job_info']['user_fname'];
	$user_nicename = strtolower(str_replace(array("'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," "),array('-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-','-'),$user_login));
	$user_nicename = get_user_nice_name($user_fname,''); //generate nice name
	$user_nicename = get_user_nice_name($user_fname); //generate nice name
	$user_address_info = array(
							"user_phone" 	=> $user_phone,
							"first_name"	=>	$_SESSION['job_info']['user_fname'],
							);
		foreach($user_address_info as $key=>$val)
		{
			update_usermeta($user_id, $key, $val); // User Address Information Here
		}
		$user_role['Job Provider'] = 1;
		update_usermeta($user_id, 'wp_capabilities', $user_role);
		$updateUsersql = "update $wpdb->users set user_url=\"$user_web\", user_nicename=\"$user_nicename\" , display_name=\"$user_fname\"  where ID=\"$user_id\"";
		$wpdb->query($updateUsersql);
	
	//wp_new_user_notification($user_id, $user_pass);
	if ( $user_id) 
	{
		$userrole = 'Job Provider';
		$user_role[$userrole] = 1;
		update_usermeta($user_id, 'wp_capabilities', $user_role);
		update_usermeta($user_id, $wpdb->prefix.'capabilities', $user_role);

		wp_new_user_notification($user_id, $user_pass);
		///////REGISTRATION EMAIL START//////
		$fromEmail = get_site_emailId();
		$fromEmailName = get_site_emailName();
		$store_name = get_option('blogname');
		global $upload_folder_path;
		$clientdestinationfile = stripslashes(get_option('registration_success_email_content')); // ABSPATH . $upload_folder_path . "notification/emails/registration.txt";
		if(!$clientdestinationfile)
		{
			$client_message = REGISTRATION_EMAIL_DEFAULT_TEXT;
		}else
		{
			$client_message = $clientdestinationfile;
		}
		$filecontent_arr1 = explode('[SUBJECT-STR]',$client_message);
		$filecontent_arr2 = explode('[SUBJECT-END]',$filecontent_arr1[1]);
		$subject = $filecontent_arr2[0];
		if($subject == '')
		{
			$subject = "Registration Email";
		}
		$client_message = $filecontent_arr2[1];
		$store_login = get_option('siteurl').'/?page=login';
		$store_login_url = '<a href="'.$store_login.'">'.__('Login').'</a>';
		/////////////customer email//////////////
		$search_array = array('[#$user_name#]','[#$user_login#]','[#$user_password#]','[#$store_name#]','[#$store_login_url#]','[#$store_login_url_link#]');
		$replace_array = array($_POST['user_fname'],$user_login,$user_pass,$store_name,$store_login,$store_login_url);
		$client_message = str_replace($search_array,$replace_array,$client_message);	
		//echo "<br><br>From : $fromEmail -- $fromEmailName <br>To : $user_email -- $userName <br>Subject : $subject <br>Message : $client_message ";	exit;
		sendEmail($fromEmail,$fromEmailName,$user_email,$userName,$subject,$client_message,$extra='');///To client email
		//////REGISTRATION EMAIL END////////
	}
	$current_user_id = $user_id;
}
?>