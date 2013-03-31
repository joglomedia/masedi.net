<?php
/*
Template Name: Profile Page
*/


$wpdb->hide_errors(); 
auth_redirect_login(); // if not logged in, redirect to login page
nocache_headers();

global $userdata;
get_currentuserinfo(); // grabs the user info and puts into vars


// check to see if the form has been posted. If so, validate the fields
if(!empty($_POST['submit']))
{

require_once(ABSPATH . 'wp-admin/includes/user.php');
require_once(ABSPATH . WPINC . '/registration.php');

check_admin_referer('update-profile_' . $user_ID);


$errors = edit_user($user_ID);

if ( is_wp_error( $errors ) ) {
	foreach( $errors->get_error_messages() as $message )
		$errmsg = "$message";
	//exit;
}


// if there are no errors, then process the ad updates
if($errmsg == '')
	{

	do_action('personal_options_update');
	$d_url = $_POST['dashboard_url'];
	wp_redirect( './?updated=true&d='. $d_url );

	} else {

	  $errmsg = '<div class="box-red"><strong>**  ' . $errmsg . ' **</strong></div>'; 
	  $errcolor = 'style="background-color:#FFEBE8;border:1px solid #CC0000;"';
	}

}	

wp_enqueue_script('jquery');

require_once dirname( __FILE__ ) . '/form_process.php';
get_header(); 
include_classified_form();
?>

<script type='text/javascript' src='<?php echo get_option('home'); ?>/wp-admin/js/password-strength-meter.js?ver=20081210'></script>

<style type="text/css">
#your-profile {padding:0px;}
table.form-table td {border:0px solid #CCC; margin-bottom:10px; padding:5px;}
table.form-table th {width: 150px;vertical-align: middle;text-align: left;}
p.message {padding: 3px 5px;background-color: lightyellow;border: 1px solid yellow;}
#display_name {width: 250px;}
.field-hint {display: block;font-size:10px;clear: both;}
.mid2 {border:1px solid #CCC; margin-bottom:10px; padding:5px;}
#pass-strength-result {border-style:solid;border-width:1px;float:left;margin:12px 5px 5px 1px;padding:3px 5px;text-align:center;width:200px;}
#pass-strength-result.good {background-color:#FFEC8B;border-color:#FFCC00 !important;}
#pass-strength-result {background-color:#EEEEEE;border-color:#DDDDDD !important;}
#pass-strength-result.bad {background-color:#FFB78C;border-color:#FF853C !important;}
#pass-strength-result.strong {background-color:#C3FF88;border-color:#8DFF1C !important;}
#pass-strength-result.short {background-color:#FFA0A0;border-color:#F04040 !important;}
</style>


<script type="text/javascript">
(function($){

	function check_pass_strength () {

		var pass = $('#pass1').val();
		var user = $('#user_login').val();

		$('#pass-strength-result').removeClass('short bad good strong');
		if ( ! pass ) {
			$('#pass-strength-result').html( pwsL10n.empty );
			return;
		}

		var strength = passwordStrength(pass, user);

		if ( 2 == strength )
			$('#pass-strength-result').addClass('bad').html( pwsL10n.bad );
		else if ( 3 == strength )
			$('#pass-strength-result').addClass('good').html( pwsL10n.good );
		else if ( 4 == strength )
			$('#pass-strength-result').addClass('strong').html( pwsL10n.strong );
		else
			// this catches 'Too short' and the off chance anything else comes along
			$('#pass-strength-result').addClass('short').html( pwsL10n.short );

	}

	$(document).ready( function() {
		$('#pass1').val('').keyup( check_pass_strength );
    });
})(jQuery);
</script>

<script type='text/javascript'>
/* <![CDATA[ */
	pwsL10n = {
		empty: "Strength indicator",
		short: "Very weak",
		bad: "Weak",
		good: "Medium",
		strong: "Strong"
	}
	try{convertEntities(pwsL10n);}catch(e){};
/* ]]> */
</script>


<div class="content">
		<div class="main ins">
		
			<div class="left">
			
				<div class="title">
					<h2><?php echo(ucfirst($userdata->user_login)); ?><?php _e('\'s Profile','cp')?></h2>
					
		<?php 
		if(function_exists('userphoto_exists')){
		  echo "<div id='user-photo'>";
			if(userphoto_exists($user_ID))
				userphoto($user_ID);
			else
				echo get_avatar($userdata->user_email, 96);
		  echo "</div>";
		}	
		 ?>
		
					<div class="clear"></div>
				</div>
				
				<div class="product">

<?php if ( isset($_GET['updated']) ) { 
	  $d_url = $_GET['d'];?>

	<div class="box-yellow">
	<strong><?php _e('Your profile has been updated.','cp')?></strong><br /><br /><a href=".<?php echo $d_url ?>"><?php _e('My Dashboard &rsaquo;&rsaquo;','cp')?></a>
	</div>
	  
<?php  } ?>


<?php echo $errmsg; ?>	


		<form name="profile" id="your-profile" action="" method="post">
		<?php wp_nonce_field('update-profile_' . $user_ID) ?>
		
		<input type="hidden" name="from" value="profile" />
		<input type="hidden" name="checkuser_id" value="<?php echo $user_ID ?>" />
		<input type="hidden" name="dashboard_url" value="<?php echo cp_dashboard_url; ?>" />


		<table class="form-table">
			<tr>
				<th><label for="user_login"><?php _e('Username','cp'); ?></label></th>
				<td><input type="text" name="user_login" class="mid2" id="user_login" value="<?php echo $userdata->user_login; ?>" size="35" maxlength="100" disabled /></td>
			</tr>
			<tr>
				<th><label for="first_name"><?php _e('First Name','cp') ?></label></th>
				<td><input type="text" name="first_name" class="mid2" id="first_name" value="<?php echo $userdata->first_name ?>" size="35" maxlength="100" /></td>
			</tr>
			<tr>
				<th><label for="last_name"><?php _e('Last Name','cp') ?></label></th>
				<td><input type="text" name="last_name" class="mid2" id="last_name" value="<?php echo $userdata->last_name ?>" size="35" maxlength="100" /></td>
			</tr>
			<tr>
				<th><label for="nickname"><?php _e('Nickname','cp') ?></label></th>
				<td><input type="text" name="nickname" class="mid2" id="nickname" value="<?php echo $userdata->nickname ?>" size="35" maxlength="100" /></td>
			</tr>
			<tr>
				<th><label for="display_name"><?php _e('Display Name','cp') ?></label></th>
				<td>
					<select name="display_name" class="mid2" id="display_name">
					<?php
						$public_display = array();
						$public_display['display_displayname'] = $userdata->display_name;
						$public_display['display_nickname'] = $userdata->nickname;
						$public_display['display_username'] = $userdata->user_login;
						$public_display['display_firstname'] = $userdata->first_name;
						$public_display['display_firstlast'] = $userdata->first_name.' '.$userdata->last_name;
						$public_display['display_lastfirst'] = $userdata->last_name.' '.$userdata->first_name;
						$public_display = array_unique(array_filter(array_map('trim', $public_display)));
						foreach($public_display as $id => $item) {
					?>
						<option id="<?php echo $id; ?>" value="<?php echo $item; ?>"><?php echo $item; ?></option>
					<?php
						}
					?>
					</select>
				</td>
			</tr>

		<tr>
			<th><label for="email"><?php _e('Email','cp') ?></label></th>
			<td><input type="text" name="email" class="mid2" id="email" value="<?php echo $userdata->user_email ?>" size="35" maxlength="100" /></td>
		</tr>

		<tr>
			<th><label for="url"><?php _e('Website','cp') ?></label></th>
			<td><input type="text" name="url" class="mid2" id="url" value="<?php echo $userdata->user_url ?>" size="35" maxlength="100" /></td>
		</tr>


		<tr>
			<th><label for="description"><?php _e('About Me','cp'); ?></label></th>
			<td><textarea name="description" class="mid2" id="description" rows="10" cols="50"><?php echo $userdata->description ?></textarea></td>
		</tr>

		<?php
		$show_password_fields = apply_filters('show_password_fields', true);
		if ( $show_password_fields ) :
		?>
		<tr>
			<th><label for="pass1"><?php _e('New Password','cp'); ?></label></th>
			<td>
				<input type="password" name="pass1" class="mid2" id="pass1" size="35" maxlength="50" value="" /><br/><small><?php _e('Leave this field blank unless you\'d like to change your password.','cp'); ?></small>
			</td>
		</tr>
		<tr>
		<th><label for="pass1"><?php _e('Password Again','cp'); ?></label></th>
			<td>
				<input type="password" name="pass2" class="mid2" id="pass2" size="35" maxlength="50" value="" /><br/><small><?php _e('Type your new password again.','cp'); ?></small></td>
		</tr>
		<tr>
		<th><label for="pass1">&nbsp;</label></th>
			<td>	
				<div id="pass-strength-result"><?php _e('Strength indicator','cp'); ?></div><br />
		<small><?php _e('Your password should be at least seven characters long.','cp'); ?></small>
			</td>
		</tr>
		<?php endif; ?>
		</table>
		<br />

		<?php
			do_action('profile_personal_options');
			do_action('show_user_profile');
		?>
		
		
		<?php if($userdata->userphoto_image_file): ?>
			<table class="form-table">
				<tr>
					<th>&nbsp;</th>
					<td>
						<p><label><input type="checkbox" name="userphoto_delete" id="userphoto_delete" /> <?php _e('Delete existing photo?','cp') ?></label></p>
					</td>
				</tr>
			</table>
		<?php endif; ?>
	

		<p class="submit">
			<input type="hidden" name="action" value="update" />
			<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" />
			<input type="submit" id="cpsubmit" class="lbutton" value="<?php _e('Update Profile &raquo;', 'cp')?>" name="submit" />
		 </p>
		</form>

</div>
			</div>
	
			
		<?php get_sidebar(); ?>	
			
			<div class="clear"></div>
		</div>
	</div>

<?php get_footer(); ?>
