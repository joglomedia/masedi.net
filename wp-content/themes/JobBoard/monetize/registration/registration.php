<?php
global $user_identity;
get_currentuserinfo();
if (is_user_logged_in() && $_REQUEST['action']!='logout')
{
	wp_redirect(get_option( 'siteurl' ).'/?page=myaccount');
	exit;
}
include_once( 'wp-load.php' );
include_once(ABSPATH.'wp-includes/registration.php');

// Redirect to https login if forced to use SSL
if ( force_ssl_admin() && !is_ssl() ) {
	if ( 0 === strpos($_SERVER['REQUEST_URI'], 'http') ) {
		wp_redirect(preg_replace('|^http://|', 'https://', $_SERVER['REQUEST_URI']));
		exit();
	} else {
		wp_redirect('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
		exit();
	}
}

	$message = apply_filters('login_message', $message);
	if ( !empty( $message ) ) echo $message . "\n";


/**
 * Handles sending password retrieval email to user.
 *
 * @uses $wpdb WordPress Database object
 *
 * @return bool|WP_Error True: when finish. WP_Error on error
 */
function retrieve_password() {
	global $wpdb;

	$errors = new WP_Error();
	if ( empty( $_POST['user_login'] ) && empty( $_POST['user_email'] ) )
		$errors->add('empty_username', __('<strong>ERROR</strong>: Enter a username or e-mail address.'));

	if ( strpos($_POST['user_login'], '@') ) {
		$user_data = get_user_by_email(trim($_POST['user_login']));
		if ( empty($user_data) )
			$errors->add('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.'));
	} else {
		$login = trim($_POST['user_login']);
		$user_data = get_userdatabylogin($login);
	}

	do_action('lostpassword_post');

	if ( $errors->get_error_code() )
		return $errors;

	if ( !$user_data ) {
		$errors->add('invalidcombo', __('<strong>ERROR</strong>: Invalid username or e-mail.'));
		return $errors;
	}

	// redefining user_login ensures we return the right case in the email
	$user_login = $user_data->user_login;
	$user_email = $user_data->user_email;

	do_action('retreive_password', $user_login);  // Misspelled and deprecated
	do_action('retrieve_password', $user_login);

	////////////////////////////////////
	$user_email = $_POST['user_email'];
	$user_login = $_POST['user_login'];
	
	$user = $wpdb->get_row("SELECT * FROM $wpdb->users WHERE user_login like \"$user_login\" or user_email like \"$user_login\"");
	if ( empty( $user ) )
		return new WP_Error('invalid_key', __('Invalid key'));
		
	$new_pass = wp_generate_password(12,false);

	do_action('password_reset', $user, $new_pass);

	wp_set_password($new_pass, $user->ID);
	update_usermeta($user->ID, 'default_password_nag', true); //Set up the Password change nag.
	$message  = '<p><b>Your login Information :</b></p>';
	$message  .= '<p>'.sprintf(__('Username: %s'), $user->user_login) . "</p>";
	$message .= '<p>'.sprintf(__('Password: %s'), $new_pass) . "</p>";
	$message .= '<p>You can login to : <a href="'.get_option( 'siteurl' ).'/?page=login' . "\">Login</a> or the URL is :  ".get_option( 'siteurl' )."/?page=login</p>";
	$message .= '<p>Thank You,<br> '.get_option('blogname').'</p>';
	$user_email = $user_data->user_email;
	$user_name = $user_data->user_nicename;
	$fromEmail = get_site_emailId();
	$fromEmailName = get_site_emailName();
	$store_login = get_option('siteurl').'/?page=login';
	$store_login_url = '<a href="'.$store_login.'">'.__('Login').'</a>';
	$title = sprintf(__('[%s] Your new password'), get_option('blogname'));
	$title = apply_filters('password_reset_title', $title);
	$message = apply_filters('password_reset_message', $message, $new_pass);
	$store_name = get_option('blogname');
	$search_array = array('[#$user_name#]','[#$user_login#]','[#$user_password#]','[#$store_name#]','[#$store_login_url#]','[#$store_login_url_link#]');
	$replace_array = array($user_login,$user_login,$new_pass,$store_name,$store_login,$store_login_url);
	$message = str_replace($search_array,$replace_array,$message);	
	sendEmail($fromEmail,$fromEmailName,$user_email,$user_name,$title,$message,$extra='');///forgot password email
	return true;
}

/**
 * Handles registering a new user.
 *
 * @param string $user_login User's username for logging in
 * @param string $user_email User's email address to send password and add
 * @return int|WP_Error Either user's ID or error on failure.
 */
function register_new_user($user_login, $user_email) {
	global $wpdb;
	$errors = new WP_Error();

	$pcd = explode(',',get_option('ptthemes_captcha_dislay'));

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if((in_array('User registration page',$pcd) || in_array('Both',$pcd)) && is_plugin_active('wp-recaptcha/wp-recaptcha.php')){
		require_once( ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php');
		$a = get_option("recaptcha_options");
		$privatekey = $a['private_key'];
  						$resp = recaptcha_check_answer ($privatekey,
                                getenv("REMOTE_ADDR"),
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
								
		if (!$resp->is_valid ) {
			wp_redirect(site_url().'/?page=login&page1=sign_up&ecptcha=captch');
			exit;
		} 
	}

	$user_login = sanitize_user( $user_login );
	$user_email = apply_filters( 'user_registration_email', $user_email );

	// Check the username
	if ( $user_login == '' )
		$errors->add('empty_username', __('ERROR: Please enter a username.'));
	elseif ( !validate_username( $user_login ) ) {
		$errors->add('invalid_username', __('<strong>ERROR</strong>: This username is invalid.  Please enter a valid username.'));
		$user_login = '';
	} elseif ( username_exists( $user_login ) )
		$errors->add('username_exists', __('<strong>ERROR</strong>: This username is already registered, please choose another one.'));

	// Check the e-mail address
	if ($user_email == '') {
		$errors->add('empty_email', __('<strong>ERROR</strong>: Please type your e-mail address.'));
	} elseif ( !is_email( $user_email ) ) {
		$errors->add('invalid_email', __('<strong>ERROR</strong>: The email address isn&#8217;t correct.'));
		$user_email = '';
	} elseif ( email_exists( $user_email ) )
		$errors->add('email_exists', __('<strong>ERROR</strong>: This email is already registered, please choose another one.'));

	do_action('register_post', $user_login, $user_email, $errors);

	$errors = apply_filters( 'registration_errors', $errors );

	if ( $errors->get_error_code() )
		return $errors;


	$user_pass = wp_generate_password(12,false);
	$user_id = wp_create_user( $user_login, $user_pass, $user_email );
	$capabilities = $wpdb->prefix."capabilities";
	$login_type = array($_POST['login_type']);
	$description = $_POST['description'];
	
	if($user_web && !strstr($user_web,'http://'))
	{
		$user_web = 'http://'.$user_web;
	}
	$user_address_info = array(
						"first_name"	=>	$_POST['user_fname'],
						"last_name"	=>	$_POST['user_lname'],
						"description"  => addslashes($description),
						);
	foreach($user_address_info as $key=>$val)
	{
		update_usermeta($user_id, $key, $val); // User Address Information Here
	}
	
	global $upload_folder_path;
	global $form_fields_usermeta;
	foreach($form_fields_usermeta as $fkey=>$fval)
	{
		$fldkey = "$fkey";
		$$fldkey = $_POST["$fkey"];
		
		if($fval['type']=='upload')
		{
			if($_FILES[$fkey]['name'] && $_FILES[$fkey]['size']>0)
			{
				$dirinfo = wp_upload_dir();
				$path = $dirinfo['path'];
				$url = $dirinfo['url'];
				$destination_path = $path."/";
				$destination_url = $url."/";
				
				$src = $_FILES[$fkey]['tmp_name'];
				$file_ame = date('Ymdhis')."_".$_FILES[$fkey]['name'];
				$target_file = $destination_path.$file_ame;
				if(move_uploaded_file($_FILES[$fkey]["tmp_name"],$target_file))
				{
					$image_path = $destination_url.$file_ame;
				}else
				{
					$image_path = '';	
				}
				
				$_POST[$fkey] = $image_path;
				$$fldkey = $image_path;
			}
			
		}
		update_usermeta($user_id, $fkey, $$fldkey); // User Custom Metadata Here
	}

	//update_usermeta($user_id, 'user_address_info', ($user_address_info)); // User Address Information Here
	update_usermeta($user_id, 'first_name', $_POST['user_fname']); // User Address Information Here
	update_usermeta($user_id, 'last_name', $_POST['user_lname']); // User Address Information Here
	$userName = $_POST['user_fname'].' '.$_POST['user_lname'];
	
	$user_nicename = get_user_nice_name($_POST['user_fname'],$_POST['user_lname']); //generate nice name
	$updateUsersql = "update $wpdb->users set user_url=\"$user_web\", user_nicename=\"$user_nicename\", display_name=\"$userName\"  where ID=\"$user_id\"";
	$wpdb->query($updateUsersql);
	
	if ( !$user_id ) {
		$errors->add('registerfail', sprintf(__('<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:%s">webmaster</a> !'), get_option('admin_email')));
		return $errors;
	}
	global $upload_folder_path;
	
	if ( $user_id ) 
	{
		$userrole = $_POST['login_type'];
		$user_role[$userrole] = 1;
		//$special_user = new WP_User($user_id);
        //$special_user->add_cap($userrole);
		update_usermeta($user_id, 'wp_capabilities', $user_role);
		update_usermeta($user_id, $wpdb->prefix.'capabilities', $user_role);
				
		///////REGISTRATION EMAIL START//////
		$fromEmail = get_site_emailId();
		$fromEmailName = get_site_emailName();
		$store_name = get_option('blogname');
		$clientdestinationfile =  stripslashes(get_option('registration_success_email_content'));
		
		if(!$clientdestinationfile && $clientdestinationfile=="")
		{
		$store_login = get_option('siteurl').'/?page=login';
		$store_login_url = '<a href="'.$store_login.'">'.__('Login').'</a>';
		$client_message = '[SUBJECT-STR]Registration Email[SUBJECT-END]<p>Dear [#user_name#],</p>
		<p>You can log in with the following information:</p>
		<p>Username: [#user_login#]</p>
		<p>Password: [#user_password#]</p>
		<p>You can login from $store_login_url or the URL is : [#site_login_url_link#].</p>
		<p>We hope you enjoy. Thanks!</p>
		<p>[#site_name#]</p>';
		$filecontent_arr1 = explode('[SUBJECT-STR]',$client_message);
		$filecontent_arr2 = explode('[SUBJECT-END]',$filecontent_arr1[1]);
		$subject = $filecontent_arr2[0];
		$client_message = $filecontent_arr2[1];

		}else
		{
			$client_message = $clientdestinationfile;
		}
		if($subject == '')
		{
			$subject = "Registration Email";
		}
		
		$store_login = '<a href="'.get_option('siteurl').'/?page=login">Click Login</a>';
		$store_login_link = get_option('siteurl').'/?page=login';
		/////////////customer email//////////////
		$search_array = array('[#user_name#]','[#user_login#]','[#user_password#]','[#site_name#]','[#site_login_url#]','[#site_login_url_link#]');
		$replace_array = array($user_login,$user_login,$user_pass,$store_name,$store_login,$store_login_link);
		$client_message = str_replace($search_array,$replace_array,$client_message);
		templ_sendEmail($fromEmail,$fromEmailName,$user_email,$userName,$subject,$client_message,$extra='');
		//sendEmail($user_email,$userName,$fromEmail,$fromEmailName,$subject,$client_message,$extra='');///To admin email
		//////REGISTRATION EMAIL END////////
	}
	return array($user_id,$user_pass);
}			
?>
<?php
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login';
$errors = new WP_Error();

if ( isset($_GET['key']) )
	$action = 'resetpass';

// validate action so as to default to the login screen
if ( !in_array($action, array('logout', 'lostpassword', 'retrievepassword', 'resetpass', 'rp', 'register', 'login')) && false === has_filter('login_form_' . $action) )
	$action = 'login';

nocache_headers();

//header('Content-Type: '.get_bloginfo('html_type').'; charset='.get_bloginfo('charset'));

if ( defined('RELOCATE') ) { // Move flag is set
	if ( isset( $_SERVER['PATH_INFO'] ) && ($_SERVER['PATH_INFO'] != $_SERVER['PHP_SELF']) )
		$_SERVER['PHP_SELF'] = str_replace( $_SERVER['PATH_INFO'], '', $_SERVER['PHP_SELF'] );

	$schema = ( isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ) ? 'https://' : 'http://';
	if ( dirname($schema . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']) != get_option('siteurl') )
		update_option('siteurl', dirname($schema . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']) );
}

//Set a cookie now to see if they are supported by the browser.
//setcookie(TEST_COOKIE, 'WP Cookie check', 0, COOKIEPATH, COOKIE_DOMAIN);
if ( SITECOOKIEPATH != COOKIEPATH )
	setcookie(TEST_COOKIE, 'WP Cookie check', 0, SITECOOKIEPATH, COOKIE_DOMAIN);

// allow plugins to override the default actions, and to add extra actions if they want
do_action('login_form_' . $action);

$http_post = ('POST' == $_SERVER['REQUEST_METHOD']);

switch ($action) {

case 'logout' :
	//check_admin_referer('log-out');
	wp_logout();

	$redirect_to =  $_SERVER['HTTP_REFERER'];
	//$redirect_to = get_option( 'siteurl' ).'/?page=login&loggedout=true';
	if ( isset( $_REQUEST['redirect_to'] ) )
		$redirect_to = $_REQUEST['redirect_to'];
	$redirect_to = get_option('siteurl');
	wp_safe_redirect($redirect_to);
	exit();

break;

case 'lostpassword' :
case 'retrievepassword' :
	if ( $http_post ) {
		$errors = retrieve_password();
		$error_message = $errors->errors['invalid_email'][0];
		if ( !is_wp_error($errors) ) {
			wp_redirect(get_option( 'siteurl' ).'/?page=login&page1=sign_in&checkemail=confirm');
			exit();
		}else
		{
			wp_redirect(get_option( 'siteurl' ).'/?page=login&page1=sign_in&emsg=fw');
			exit();
		}
	}
	if ( isset($_GET['error']) && 'invalidkey' == $_GET['error'] ) $errors->add('invalidkey', __('Sorry, that key does not appear to be valid.'));
	do_action('lost_password');
	$message = '<div class="sucess_msg">'.ENTER_USER_EMAIL_NEW_PW_MSG.'</div>';
	$user_login = isset($_POST['user_login']) ? stripslashes($_POST['user_login']) : '';

break;

case 'resetpass' :
case 'rp' :
	$errors = reset_password($_GET['key'], $_GET['login']);

	if ( ! is_wp_error($errors) ) {
		wp_redirect(get_option( 'siteurl' ).'/?page=login&action=login&checkemail=newpass');
		exit();
	}

	wp_redirect(get_option( 'siteurl' ).'/?page=login&action=lostpassword&page1=sign_in&error=invalidkey');
	exit();

break;

case 'register' :

	$user_login = '';
	$user_email = '';
	if ( $http_post ) {
		$user_login = $_POST['user_fname'];
		$user_email = $_POST['user_email'];
		$user_fname = $_POST['user_fname'];
		$user_lname = $_POST['user_lname'];		  
		$user_phone = $_POST['user_phone'];
		
		$errors = register_new_user($user_login, $user_email);
		if(is_wp_error($errors))
		{
			wp_redirect(get_option('siteurl').'?page=login&page1=sign_up&emsg=1');
		}
		if ( !is_wp_error($errors) ) 
		{
			$_POST['log'] = $user_login;
			$_POST['pwd'] = $errors[1];
			$_POST['testcookie'] = 1;
			
			$secure_cookie = '';
			// If the user wants ssl but the session is not ssl, force a secure cookie.
			if ( !empty($_POST['log']) && !force_ssl_admin() )
			{
				$user_name = sanitize_user($_POST['log']);
				if ( $user = get_userdatabylogin($user_name) )
				{
					if ( get_user_option('use_ssl', $user->ID) )
					{
						$secure_cookie = true;
						force_ssl_admin(true);
					}
				}
			}
			if($_REQUEST['reg_redirect_link']=='')
			{
				$_REQUEST['reg_redirect_link']=get_author_link($echo = false, $errors[0]);
			}
			$redirect_to = $_REQUEST['reg_redirect_link'];
			if ( !$secure_cookie && is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
				$secure_cookie = false;
		
			$user = wp_signon('', $secure_cookie);
		
			$redirect_to = apply_filters('login_redirect', $redirect_to, isset( $_REQUEST['reg_redirect_link'] ) ? $_REQUEST['reg_redirect_link'] : '', $user);
		
			if ( !is_wp_error($user) ) 
			{
				wp_safe_redirect($redirect_to);
				exit();
			}
			exit();
		}
	}

break;

case 'login' :
default:
	$secure_cookie = '';

	if ( !empty($_POST['log']) && !force_ssl_admin() ) {
		$user_name = sanitize_user($_POST['log']);
		if ( $user = get_userdatabylogin($user_name) ) {
			if ( get_user_option('use_ssl', $user->ID) ) {
				$secure_cookie = true;
				force_ssl_admin(true);
			}
		}
	}
	///////////////////////////
	
	if($_REQUEST['redirect_to']=='')
	{
		$_REQUEST['redirect_to']=get_author_link($echo = false, $user->ID);
	}
	if ( isset( $_REQUEST['redirect_to'] ) ) {
		$redirect_to = $_REQUEST['redirect_to'];
		// Redirect to https if user wants ssl
		if ( $secure_cookie && false !== strpos($redirect_to, 'wp-admin') )
			$redirect_to = preg_replace('|^http://|', 'https://', $redirect_to);
	} else {
		$redirect_to = admin_url();
	}

	if ( !$secure_cookie && is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
		$secure_cookie = false;

	$user = wp_signon('', $secure_cookie);

	$redirect_to = apply_filters('login_redirect', $redirect_to, isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '', $user);

	if(is_wp_error($user))
	{
		if(strstr($_SERVER['HTTP_REFERER'],'page=postajob') && $_POST['log']!='' && $_POST['pwd']!='')
		{
			wp_redirect($_SERVER['HTTP_REFERER'].'&emsg=1');
			//?page=login&page1=sign_in
		}
		
	}
	if ( !is_wp_error($user) ) {
		// If the user can't edit posts, send them to their profile.
		if ( !$user->has_cap('edit_posts') && ( empty( $redirect_to ) || $redirect_to == 'wp-admin/' || $redirect_to == admin_url() ) )
			$redirect_to = admin_url('profile.php');
		wp_safe_redirect($redirect_to);
		exit();
	}

	$errors = $user;
	// Clear errors if loggedout is set.
	if ( !empty($_GET['loggedout']) )
		$errors = new WP_Error();
	// If cookies are disabled we can't log in even with a valid user+pass
	if ( isset($_POST['testcookie']) && empty($_COOKIE[TEST_COOKIE]) )
		$errors->add('test_cookie', __("<strong>ERROR</strong>: Cookies are blocked or not supported by your browser. You must <a href='http://www.google.com/cookies.html'>enable cookies</a> to use WordPress."));

	// Some parts of this script use the main login form to display a message
	if( isset($_GET['loggedout']) && TRUE == $_GET['loggedout'] )
	{
		$successmsg = '<div class="sucess_msg">'.YOU_ARE_LOGED_OUT_MSG.'</div>';
	}
	elseif( isset($_GET['registration']) && 'disabled' == $_GET['registration'] )
	{
		$successmsg = USER_REG_NOT_ALLOW_MSG;
	}
	elseif( isset($_GET['checkemail']) && 'confirm' == $_GET['checkemail'] )
	{
		$successmsg = EMAIL_CONFIRM_LINK_MSG;
	}
	elseif( isset($_GET['checkemail']) && 'newpass' == $_GET['checkemail'] )
	{
		$successmsg = NEW_PW_EMAIL_MSG;
	}
	elseif( isset($_GET['checkemail']) && 'registered' == $_GET['checkemail'] )
	{
		$successmsg = REG_COMPLETE_MSG;
	}
	
	if(($_POST['log'] && $errors) || ($_POST['log']=='' && $_REQUEST['testcookie']))
	{
		if($_REQUEST['pagetype'])
		{
			wp_redirect($_REQUEST['pagetype'].'&emsg=1');
		}else
		{
			if($_REQUEST['loginfrm'] == 1)
			  {	
				wp_redirect(get_option('siteurl').'?page=login&emsg=2');
			  }
			else
			  {
				  wp_redirect(get_option('siteurl').'?page=register&emsg=1');
			  }
		}
		exit;
	}
break;

} // end action switch
?>

<?php get_header(); ?>
<div id="page">
 <div id="content-wrap" class="clear <?php if(get_option("ptthemes_page_layout") == "Right Sidebar") { echo "right-side"; } else { echo "left-side"; } ?>" >
	<div id="content">

<script type="text/javascript" >
<?php if ( $user_login ) { ?>
setTimeout( function(){ try{
d = document.getElementById('user_pass');
d.value = '';
d.focus();
} catch(e){}
}, 200);
<?php } else { ?>
try{document.getElementById('user_login').focus();}catch(e){}
<?php } ?>
</script>
<ul class="page-nav"><li><?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') { yoast_breadcrumb('',' &raquo; '.__(SIGN_IN_PAGE_TITLE)); } ?></li></ul>
<div class="row">
<?php
foreach($errors as $errorsObj)
{
	foreach($errorsObj as $key=>$val)
	{
		for($i=0;$i<count($val);$i++)
		{
			echo "<div class=sucess_msg>".$val[$i].'</div>';	
			$registration_error_msg = 1;
		}
	} 
}
?> 
<div class="content_spacer">
    <div class="form_col_1 fr">
        	<div class="form login_form">
	            <?php include (TEMPLATEPATH . "/monetize/registration/login_frm.php"); ?>
            </div>
        </div>
   		<div class="registration_col">
			   <?php include (TEMPLATEPATH . "/monetize/registration/reg_frm.php");?>
	    </div>
    </div>    
</div>
<?php if($_REQUEST['ptype'] == 'login'): ?>
	<script type="text/javascript">
    try{document.getElementById('user_login').focus();}catch(e){}
    </script>
<?php else: ?>
	<script type="text/javascript">
    try{document.getElementById('user_email').focus();}catch(e){}
    </script>
<?php endif; ?>
<?php
if($errors->errors['invalidcombo'] || $errors->errors['empty_username'])
{

?>
<script type="text/javascript">document.getElementById('lostpassword_form').style.display = '';</script>
<?php
}
?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>