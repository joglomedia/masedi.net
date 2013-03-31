<?php

//classipress register, login, and forgot password themed pages

// $error = sprintf(__("Unable to place the user photo at: %s", 'user-photo'), $imagepath);

function cp_login_init() {
	require( ABSPATH . '/wp-load.php' );
		
	if (isset($_REQUEST["action"])) {
		$action = $_REQUEST["action"];
	} else {
		$action = 'login';
	}
	
	switch($action) {
		case 'lostpassword' :
		case 'retrievepassword' :
			cp_password();
			break;
		case 'register':
			cp_show_register();
			break;
		case 'login':
		default:
			cp_show_login();
			break;
	}
	die();
}


function cp_head($cp_msg) {
	global $cp_options;
	include(TEMPLATEPATH . '/header.php');
	include_classified_form( );
	echo "<div class='content'><div class='main ins'><div class='left'><div class='title'>";
	echo "<h2>".__($cp_msg)."</h2>";
}

function cp_title($title) {
	global $pagenow;
	if ($pagenow == "wp-login.php") {
		switch($_GET['action']) {
			case 'register':
				$title = __('Register at ','cp');
				break;
			case 'lostpassword':
				$title = __('Retrieve your lost password for ','cp');
				break;
			case 'login':
			default:
				$title = __('Login at ','cp');
				break;
		}
	} else if ($pagenow == "profile.php") {
		$title = __('Your Profile at ','cp');
	}
	$title .= get_bloginfo('name');
	return $title;
}


function cp_show_login() {
	if ( isset( $_REQUEST['redirect_to'] ) )
		$redirect_to = $_REQUEST['redirect_to'];
	else
		$redirect_to = admin_url();

	if ( is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
		$secure_cookie = false;
	else
		$secure_cookie = '';

	$user = wp_signon('', $secure_cookie);

	$redirect_to = apply_filters('login_redirect', $redirect_to, isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '', $user);

	if ( !is_wp_error($user) ) {
		// If the user can't edit posts, send them to their profile.
		if ( !$user->has_cap('edit_posts') && ( empty( $redirect_to ) || $redirect_to == 'wp-admin/' ) )
			$redirect_to = admin_url('profile.php');
		wp_safe_redirect($redirect_to);
		exit();
	}

	$errors = $user;
	// Clear errors if loggedout is set.
	if ( !empty($_GET['loggedout']) )
		$errors = new WP_Error();

	cp_head(__('Login','cp'));	

	// If cookies are disabled we can't log in even with a valid user+pass
	if ( isset($_POST['testcookie']) && empty($_COOKIE[TEST_COOKIE]) )
		$errors->add('test_cookie', __("<strong>ERROR</strong>: Cookies are blocked or not supported by your browser. You must <a href='http://www.google.com/cookies.html'>enable cookies</a>.",'cp'));		
	if	( isset($_GET['loggedout']) && TRUE == $_GET['loggedout'] )			$errors->add('loggedout', __('You are now logged out.','cp'), 'message');
	elseif	( isset($_GET['registration']) && 'disabled' == $_GET['registration'] )	$errors->add('registerdisabled', __('User registration is currently not allowed.','cp'));
	elseif	( isset($_GET['checkemail']) && 'confirm' == $_GET['checkemail'] )	$errors->add('confirm', __('Check your e-mail for the confirmation link.','cp'), 'message');
	elseif	( isset($_GET['checkemail']) && 'newpass' == $_GET['checkemail'] )	$errors->add('newpass', __('Check your e-mail for your new password.','cp'), 'message');
	elseif	( isset($_GET['checkemail']) && 'registered' == $_GET['checkemail'] )	$errors->add('registered', __('Registration complete. Please check your e-mail.','cp'), 'message');

?>
	
			<div class="clear"></div>
				</div>
				<div class="product">
				
		<?php echo cp_show_errors($errors); ?>
			
		<form class="loginform" action="<?php bloginfo('wpurl'); ?>/wp-login.php" method="post" >
		<p>
			<label for="user_login"><?php _e('Username:','cp') ?></label>
			<input name="log" value="<?php echo attribute_escape(stripslashes($_POST['log'])); ?>" class="mid" id="user_login" type="text" />
			<br/>
			<label for="user_pass"><?php _e('Password:','cp') ?></label>
			<input name="pwd" class="mid" id="user_pass" type="password" />
			<br/>
		</p>
		
		<div id="checksave">
			<input name="rememberme" class="checkbox" id="rememberme" value="forever" type="checkbox" checked="checked"/>
			<label for="rememberme"><?php _e('Remember me','cp'); ?></label>
			
		<p class="submit">
			<input type="submit" class="lbutton" name="wp-submit" id="wp-submit" value="<?php _e('Login','cp'); ?> &raquo;" />
			<input type="hidden" name="testcookie" value="1" />
		</p>
		</div>
	</form>
			
<?php	
	cp_footer();
}


function cp_show_errors($wp_error) {
	global $error;
	
	if ( !empty( $error ) ) {
		$wp_error->add('error', $error);
		unset($error);
	}

	if ( !empty($wp_error) ) {
		if ( $wp_error->get_error_code() ) {
			$errors = '';
			$messages = '';
			foreach ( $wp_error->get_error_codes() as $code ) {
				$severity = $wp_error->get_error_data($code);
				foreach ( $wp_error->get_error_messages($code) as $error ) {
					if ( 'message' == $severity )
						$messages .= '	' . $error . "<br />\n";
					else
						$errors .= '	' . $error . "<br />\n";
				}
			}
			if ( !empty($errors) )
				echo '<p id="login_error">' . apply_filters('login_errors', $errors) . "</p>\n";
			if ( !empty($messages) )
				echo '<p class="message">' . apply_filters('login_messages', $messages) . "</p>\n";
		}
	}
}

function cp_footer() {
	global $pagenow, $user_ID, $cp_options;

	if ($pagenow == "wp-login.php") {
			// Show the appropriate options
			echo '<div id="cpnav">'."\n";
			if (isset($_GET['action']) && $_GET['action'] != 'login') 
				echo '<a href="'.site_url('wp-login.php', 'login').'">'.__('Log in','cp').'</a><br />'."\n";
			if (get_option('users_can_register') && $_GET['action'] != 'register')
				echo '<a href="'.site_url('wp-login.php?action=register', 'login').'">'.__('Register','cp').'</a><br />'."\n";
			if ($_GET['action'] != 'lostpassword')
				echo '<a href="'.site_url('wp-login.php?action=lostpassword', 'login').'" title="'.__('Password Lost and Found','cp').'">'.__('Lost your password?','cp').'</a></li>'."\n";		
			echo '</div>'."\n";

			// autofocus the username field  ?>
			<script type="text/javascript">try{document.getElementById('user_login').focus();}catch(e){}</script>
		<?php		
	} else if (isset($user_ID)){
		//echo '<div id="cpnav">'."\n";
		//if (function_exists('wp_logout_url')) {
		//	echo '<a href="'.wp_logout_url().'">'.__('Log out','cp').'</a><br />'."\n";
		//} else {
		//	echo '<a href="'.site_url('wp-login.php?action=logout', 'logout').'">'.__('Log out','cp').'</a>'."\n";			
		//}
		//echo '</div>'."\n";
	}
	// this is the end of page code before the sidebar
	echo "</div></div><div class='right'>";
	
	
	
	if (function_exists('thesis_get_sidebars')) {
		thesis_get_sidebars();
	} else {
		//include(TEMPLATEPATH . '/sidebar.php');
	}?>
	
	<?php if (function_exists('dynamic_sidebar')&&dynamic_sidebar('Page Sidebar')):else: ?>
				
				<li><h2><?php _e('Archives','cp'); ?></h2>
					<ul>
					<?php wp_get_archives('type=monthly'); ?>
					</ul>
				</li>

			<?php wp_list_categories('show_count=1&title_li=<h2>Categories</h2>'); ?>
				
				<?php endif; ?>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	
	<?php
	include(TEMPLATEPATH . '/footer.php');
}

function cp_show_register() {
	global $cp_pluginpath, $cp_options;
	if ( !get_option('users_can_register') ) {
		wp_redirect(get_bloginfo('wpurl').'/wp-login.php?registration=disabled');
		exit();
	}

	$user_login = '';
	$user_email = '';
   
	if ( isset($_POST['user_login']) ) {
		if( !$cp_options['captcha'] || ( $cp_options['captcha'] && ($_SESSION['security_code'] == $_POST['security_code']) && (!empty($_SESSION['security_code']) ) ) 
			) {
			unset($_SESSION['security_code']);
			require_once( ABSPATH . WPINC . '/registration.php');

			$user_login = $_POST['user_login'];
			$user_email = $_POST['user_email'];
			$errors = register_new_user($user_login, $user_email);
			if ( !is_wp_error($errors) ) {
				wp_redirect('wp-login.php?checkemail=registered');
				exit();
			}
		} else {
			$user_login = $_POST['user_login'];
			$user_email = $_POST['user_email'];
			$errors = new WP_error();
			$errors->add('captcha', __("<strong>ERROR</strong>: You didn't correctly enter the captcha, please try again.",'cp'));		
		}
	}
	
	cp_head(__('Register','cp'));
	
	
?>
<div class="clear"></div>
				</div>
				<div class="product">

		<?php cp_show_errors($errors); ?>
				
	<form class="loginform" name="registerform" id="registerform" action="<?php echo site_url('wp-login.php?action=register', 'login_post') ?>" method="post">
		<p>
			<label><?php _e('Username','cp') ?>:</label>
			<input tabindex="1" type="text" name="user_login" id="user_login" class="mid" value="<?php echo attribute_escape(stripslashes($user_login)); ?>" size="20" tabindex="10" /><br/>
			<label><?php _e('E-mail','cp') ?>:</label>
			<input tabindex="2" type="text" name="user_email" id="user_email" class="mid" value="<?php echo attribute_escape(stripslashes($user_email)); ?>" size="25" tabindex="20" />
<?php if ($cp_options['captcha']) { ?>
			<label>&nbsp;</label>
			<img alt="captcha" width="155" height="30" src="<?php echo $cp_pluginpath; ?>captcha.php?width=155&amp;height=30&amp;characters=5" /><br/>
			<label for="security_code"><?php _e('Type the code above:','cp');?></label>
			<input tabindex="3" id="security_code" name="security_code" class="input" type="text" />
<?php } ?>
		</p>
	<div id="checksave">	
		<?php do_action('register_form'); ?>
		<p id="reg_passmail"><?php _e('A password will be e-mailed to you.','cp') ?></p>
		<p class="submit"><input tabindex="4" class="lbutton" type="submit" name="wp-submit" id="wp-submit" value="<?php _e('Register','cp'); ?>" tabindex="100" /></p>
	</div>
	</form>
<?php
	cp_footer();
}


function cp_password() {
	$errors = new WP_Error();
	if ( $_POST['user_login'] ) {
		$errors = retrieve_password();
		if ( !is_wp_error($errors) ) {
			wp_redirect('wp-login.php?checkemail=confirm');
			exit();
		}
	}
	
	if ( 'invalidkey' == $_GET['error'] ) 
		$errors->add('invalidkey', __('Sorry, that key does not appear to be valid.','cp'));

	$errors->add('registermsg', __('Please enter your username or e-mail address. You will receive a new password via e-mail.','cp'), 'message');
	do_action('lost_password');
	do_action('lostpassword_post');
	cp_head("Lost Password");

	
?>

<div class="clear"></div>
				</div>
				<div class="product">
				
		<?php echo cp_show_errors($errors); ?>
				
	<form class="loginform" name="lostpasswordform" id="lostpasswordform" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post') ?>" method="post">
		<p>
			<label><?php _e('Username or Email:','cp') ?></label>
			<input type="text" name="user_login" id="user_login" class="mid" value="<?php echo attribute_escape(stripslashes($_POST['user_login'])); ?>" size="20" tabindex="10" />
		</p>
		
	<div id="checksave">	
		<?php do_action('lostpassword_form'); ?>
		<p class="submit"><input type="submit" class="lbutton" name="wp-submit" id="wp-submit" value="<?php _e('Get New Password','cp'); ?>" tabindex="100" /></p>
	</div>
	</form>
<?php
	cp_footer();
}


function cp_login_css ( ) {
?>
<style type="text/css">
.loginform p label{width:100px; margin-top:4px; float:left; clear:both}
div#checksave{padding-left:100px; margin-top:-10px}
.mid{border:1px solid #CCC; margin-bottom:10px; padding:5px; width:200px}
.checkbox{clear:both; padding-left:10px}
div#cpnav{padding:10px 0 30px 100px}
form.loginform p img{width:155px; float:left}
form.loginform, form.loginform p{clear:both}
p.message, p#login_error{padding:3px 5px}
p.message{background-color:lightyellow; border:1px solid yellow}
p#login_error{background-color:#FFEBE8; border:1px solid #CC0000; color:#000}
</style>
<?php
}

function cp_redirect($redirect_to, $request_redirect_to, $user) {
	if (is_a($user, 'WP_User') && $user->has_cap('level_3') === false) {
		return get_bloginfo('wpurl'); 
	}
	return $redirect_to;
}

global $pagenow; 

if ( $pagenow == "wp-login.php"  && $_GET['action'] != 'logout' && !isset($_GET['key']) ) {
	add_action('init', 'cp_login_init', 98);
	add_filter('wp_title','cp_title');
	add_action('wp_head', 'cp_login_css');
}

/*
Main Plugin call for Profile Page:
Init the script when current page is profile.php, but don't init it when:
- a form has been submitted (the original PHP file should take care of form submissions)
- user has write and/or edit rights on the blog, he/she can see the backend anyway, so why not for this page?
*/

if ( !isset($_POST['from']) && $_POST['from'] != 'profile' ) {
	//add_action('load-profile.php', 'cp_profile_init', 98);
}


// If the current user has no edit rights, redirect them to their dashboard page
add_filter('login_redirect', 'cp_redirect', 10, 3);



// BEGIN Custom show price dropdown 
function cp_dropdown_categories_prices( $args = '' ) {
	$defaults = array( 'show_option_all' => '', 'show_option_none' => '','orderby' => 'ID', 'order' => 'ASC','show_last_update' => 0, 'show_count' => 0,'hide_empty' => 1, 'child_of' => 0,'exclude' => '', 'echo' => 1,'selected' => 0, 'hierarchical' => 0,'name' => 'cat', 'class' => 'postform','depth' => 0, 'tab_index' => 0 );

	$defaults['selected'] = ( is_category() ) ? get_query_var( 'cat' ) : 0;
	$r = wp_parse_args( $args, $defaults );
	$r['include_last_update_time'] = $r['show_last_update'];
	extract( $r );

	$tab_index_attribute = '';
	if ( (int) $tab_index > 0 )
		$tab_index_attribute = " tabindex=\"$tab_index\"";
	$categories = get_categories( $r );
	$output = '';
	if ( ! empty( $categories ) ) {
		$output = "<select name='$name' id='$name' class='$class' $tab_index_attribute>\n";

		if ( $show_option_all ) {
			$show_option_all = apply_filters( 'list_cats', $show_option_all );
			$selected = ( '0' === strval($r['selected']) ) ? " selected='selected'" : '';
			$output .= "\t<option value='0'$selected>$show_option_all</option>\n";
		}
		
		if ( $show_option_none ) {
			$show_option_none = apply_filters( 'list_cats', $show_option_none );
			$selected = ( '-1' === strval($r['selected']) ) ? " selected='selected'" : '';
			$output .= "\t<option value='-1'$selected>$show_option_none</option>\n";
		}

		if ( $hierarchical )
			$depth = $r['depth'];  // Walk the full depth.
		else
			$depth = -1; // Flat.

		$output .= cp_category_dropdown_tree( $categories, $depth, $r );
		$output .= "</select>\n";
	}

	$output = apply_filters( 'wp_dropdown_cats', $output );

	if ( $echo )
		echo $output;
		
	return $output;
}

function cp_category_dropdown_tree() {
	$args = func_get_args();
	if ( empty($args[2]['walker']) || !is_a($args[2]['walker'], 'Walker') )
		$walker = new cp_CategoryDropdown;
	else
		$walker = $args[2]['walker'];
	return call_user_func_array(array( &$walker, 'walk' ), $args );
}


class cp_CategoryDropdown extends Walker {
	var $tree_type = 'category';
	var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');
	function start_el(&$output, $category, $depth, $args) {
		$pad = str_repeat('&nbsp;', $depth * 3);
		$cat_name = apply_filters('list_cats', $category->name, $category);
		$output .= "\t<option class=\"level-$depth\" value=\"".$category->term_id."\">";
		$output .= $pad.$cat_name;
		$output .= " - " . get_option("currency") . get_option("cp_cat_price_".$category->cat_ID) . "</option>\n";
	}
}

// END Custom show price dropdown 


if ( !get_option('post_status') || !get_option('notif_ad') ) {
	function cp_install_warning() {
		//$vurl = "../wp-content/themes/".get_option('template');
		echo "
		<div id='cp-warning' class='updated fade'><p><strong>".__('ClassiPress setup is incomplete.', 'cp')."</strong> ".sprintf(__('You must save the <a href="%1$s">configure</a> and <a href="%2$s">settings</a> option pages before ClassiPress will work properly. Read the <a href="%3$s" target="_blank">online documentation</a> before getting started.', 'cp'), "admin.php?page=functions.php", "admin.php?page=settings", "http://xmobile.yw.sk/install/")."</p></div>
		";
	}
	add_action('admin_notices', 'cp_install_warning');
	return;
}

?>