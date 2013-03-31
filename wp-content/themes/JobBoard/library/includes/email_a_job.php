<script type="text/javascript">
jQuery.noConflict();
var $q = jQuery.noConflict();
jQuery(document).ready(function(){

//global vars

	var enquiryfrm = jQuery("#email_a_job_frm");

	var job_frnd_name = jQuery("#job_frnd_name");

	var job_frnd_nameInfo = jQuery("#job_frnd_nameInfo");

	var job_frnd_email = jQuery("#job_frnd_email");

	var job_frnd_emailInfo = jQuery("#job_frnd_emailInfo");

	var job_your_name = jQuery("#job_your_name");

	var job_your_nameInfo = jQuery("#job_your_nameInfo");

	var job_your_email = jQuery("#job_your_email");

	var job_your_emailInfo = jQuery("#job_your_emailInfo");

	var job_frnd_comment = jQuery("#job_frnd_comment");

	var job_frnd_commentInfo = jQuery("#job_frnd_commentInfo");

	

	//On blur

	job_frnd_name.blur(validate_job_frnd_name);

	job_frnd_email.blur(validate_job_frnd_email);

	job_your_name.blur(validate_job_your_name);

	job_your_email.blur(validate_job_your_email);

	job_frnd_comment.blur(validate_job_frnd_comment);

	

	//On key press

	job_frnd_name.keyup(validate_job_frnd_name);

	job_frnd_email.keyup(validate_job_frnd_email);

	job_your_name.keyup(validate_job_your_name);

	job_your_email.keyup(validate_job_your_email);

	job_frnd_comment.keyup(validate_job_frnd_comment);

	

	//On Submitting

	enquiryfrm.submit(function(){

		if(validate_job_frnd_name() & validate_job_frnd_email() & validate_job_your_name() & validate_job_your_email() & validate_job_frnd_comment())

		{

			function reset_send_email_agent_form()
			{
				document.getElementById('job_frnd_name').value = '';
				document.getElementById('job_frnd_email').value = '';
				document.getElementById('job_your_name').value = '';
				document.getElementById('job_your_email').value = '';	
				document.getElementById('frnd_subject').value = '';
				document.getElementById('job_frnd_comment').value = '';	
			}
			//hideform();
			setTimeout("document.getElementById('job_frnd_name').value = ''; document.getElementById('job_frnd_email').value = ''; document.getElementById('job_your_name').value = ''; document.getElementById('job_your_email').value = ''; document.getElementById('frnd_subject').value = ''; document.getElementById('job_frnd_comment').value = '';",1000);
			setTimeout("document.getElementById('reply_send_success').style.display='';document.getElementById('reply_send_success').innerHTML = 'Message Send Successfully!'",1000);
			return true

		}

		else

		{

			return false;

		}

	});



	//validation functions

	function validate_job_frnd_name()

	{

		if(jQuery("#job_frnd_name").val() == '')

		{

			job_frnd_name.addClass("error");

			job_frnd_nameInfo.text("Please Enter To Name");

			job_frnd_nameInfo.addClass("message_error2");

			return false;

		}

		else{

			job_frnd_name.removeClass("error");

			job_frnd_nameInfo.text("");

			job_frnd_nameInfo.removeClass("message_error2");

			return true;

		}

	}

	function validate_job_frnd_email()
	{

		var isvalidemailflag = 0;
		if(jQuery("#job_frnd_email").val() == '')
		{
			isvalidemailflag = 1;
		}else
		if($q("#job_frnd_email").val() != '')
		{
			var a = $q("#job_frnd_email").val();
			var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
			if(filter.test(a)){
				isvalidemailflag = 0;
			}else{
				isvalidemailflag = 1;	
			}
		}
		if(isvalidemailflag)
		{
			job_frnd_email.addClass("error");
			job_frnd_emailInfo.text("Please Enter valid Email Address");
			job_frnd_emailInfo.addClass("message_error2");
			return false;
		}else
		{
			job_frnd_email.removeClass("error");
			job_frnd_emailInfo.text("");
			job_frnd_emailInfo.removeClass("message_error");
			return true;
		}

	}

	

	function validate_job_your_name()

	{

		if(jQuery("#job_your_name").val() == '')

		{

			job_your_name.addClass("error");

			job_your_nameInfo.text("Please Enter Your Name");

			job_your_nameInfo.addClass("message_error2");

			return false;

		}

		else{

			job_your_name.removeClass("error");

			job_your_nameInfo.text("");

			job_your_nameInfo.removeClass("message_error2");

			return true;

		}

	}

	

	function validate_job_your_email()
	{

		var isvalidemailflag = 0;
		if($q("#job_your_email").val() == '')
		{
			isvalidemailflag = 1;

		}else
		if($q("#job_your_email").val() != '')
		{
			var a = $q("#job_your_email").val();
			var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
			//if it's valid email
			if(filter.test(a)){
				isvalidemailflag = 0;
			}else{
				isvalidemailflag = 1;	
			}
		}
		if(isvalidemailflag)
		{
			job_your_email.addClass("error");
			job_your_emailInfo.text("Please enter your valid email address");
			job_your_emailInfo.addClass("message_error2");
			return false;
		}else
		{
			job_your_email.removeClass("error");
			job_your_emailInfo.text("");
			job_your_emailInfo.removeClass("message_error");
			return true;
		}


	}

	function validate_job_frnd_comment()

	{

		if(jQuery("#job_frnd_comment").val() == '')

		{

			job_frnd_comment.addClass("error");

			job_frnd_commentInfo.text("Please Enter Comments");

			job_frnd_commentInfo.addClass("message_error2");

			return false;

		}

		else{

			job_frnd_comment.removeClass("error");

			job_frnd_commentInfo.text("");

			job_frnd_commentInfo.removeClass("message_error2");

			return true;

		}

	}



});
</script>
<div class="invite_friend_box" id="inviteafriend" style="display:none;" >

<form method="post" action="<?php echo get_permalink($post->ID);?>" name="email_a_job_frm" id="email_a_job_frm">
<input type="hidden" name="act" value="email_job" />
    <h3> <?php _e('Email to a Friend');?> </h3>
    
    <div class="row">
        <label><?php _e('Friend Name');?> :   </label>
        <input name="job_frnd_name" id="job_frnd_name" type="text" class="" />
        <span id="job_frnd_nameInfo"></span>
    </div>
    
    <div class="row">
        <label><?php _e('Friend Email');?> :  </label>
        <input name="job_frnd_email" id="job_frnd_email" type="text" class="" />
        <span id="job_frnd_emailInfo"></span>
    </div>
    
    <div class="row">
        <label><?php _e('Your Name');?> :   </label>
        <input name="job_your_name" id="job_your_name" type="text" class="" />
        <span id="job_your_nameInfo"></span>
    </div>
    
    <div class="row">
        <label><?php _e('Your Email');?> :  </label>
        <input name="job_your_email" id="job_your_email" type="text" class="" />
        <span id="job_your_emailInfo"></span>
    </div>
    
    <div class="row">
        <label><?php _e('Comments');?> :  </label>
        <textarea name="job_frnd_comment" id="job_frnd_comment" cols="" rows="" class="textarea"></textarea>
        <span id="job_frnd_commentInfo"></span>
    </div>
    <div class="row">
		<?php
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			$conform = get_option("pttthemes_contact_captcha");
			$a = get_option("recaptcha_options");
			if( file_exists(ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php') && is_plugin_active('wp-recaptcha/wp-recaptcha.php') && $conform == 'Yes' ){
				echo '<label>'.WORD_VERIFICATION.'</label>';
				$publickey = $a['public_key']; // you got this from the signup page
				echo recaptcha_get_html($publickey); 
			}
		?>
    </div> 

    <input name="submit" type="submit" value="Submit" class="normal_button" /> 
    
  
</form>
</div>
<?php
if($_POST['act']=='email_job')
{
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
		if(file_exists(ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php')) {
			require_once( ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php');
			$a = get_option("recaptcha_options");
			$privatekey = $a['private_key'];
  						$resp = recaptcha_check_answer ($privatekey,
                                getenv("REMOTE_ADDR"),
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
								
			if (!$resp->is_valid ) {
				if(strstr($requesturl,'?'))
					{
						$requesturl .= "&ecptcha=captch";
					}else
					{
						$requesturl .= "?ecptcha=captch";
					}
					wp_redirect($requesturl);
					exit;
			} 
		}	
	$site_email_id = get_option('site_email_id');
	$blogname = get_option('blogname');
	$job_frnd_name = $_POST['job_frnd_name'];
	$job_frnd_email = $_POST['job_frnd_email'];
	$job_your_name = $_POST['job_your_name'];
	$job_your_email = $_POST['job_your_email'];	
	$job_frnd_comment = $_POST['job_frnd_comment'];

	$subject = __('Your friend ').$job_your_name. __("sent you a job request");
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'To: '.$job_frnd_name.' <'.$job_frnd_email.'>' . "\r\n";
	//$headers .= 'From: '.$job_your_name.' <'.$job_your_email.'>' . "\r\n";
	
	$post_title = the_title('','',false);
	$post_id = $post->ID;
	$post_link = get_permalink($post->ID);
		
	$message = "Hello $job_frnd_name,
	<p>Here is a Job Request from your friend $job_your_name.</p>
	<p>Job Title : <a href=\"$post_link\" target=\"_blank\">$post_title</a></p>
	$job_your_name 's Comments : <br>".nl2br($job_frnd_comment)." <br>";
	$message .= "<br>Thank You,<br>From <a href=\"".get_option('siteurl')."\">$blogname</a>.";
	@mail($job_frnd_email,$subject,$message,$headers);	
	if(strstr($requesturl,'?'))
	{
		$requesturl .= "&jemail=success";
	}else
	{
		$requesturl .= "?jemail=success";
	}
	wp_redirect($requesturl);
}
?>
</script>