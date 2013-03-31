<?php
$notification_email = array();

$content = array();
$content['title'] = __('Successful post submission email to the administrator','templatic');
$content['subject'] = array('post_submited_success_email_subject',__('Post submitted successfully Acknowledgment','templatic'));
$content['content'] = array('post_submited_success_email_content','<p>'.__('Dear','templatic').' [#to_name#],</p><p>'.__('Following informations have been submitted. This email is just for your knowledge','templatic').'.</p><p>[#information_details#]</p><br><p>'.__('We hope you enjoy. Thanks','templatic').'!</p><p>[#site_name#]</p>');
$content['status'] = '1';
$notification_email[] = $content;

$content = array();
$content['title'] = __('Payment success email to client','templatic');
$content['subject'] = array('post_payment_success_client_email_subject',__('Acknowledgment for your Payment','templatic'));
$content['content'] = array('post_submited_success_admin_email_content','<p>'.__('Dear','templatic').' [#to_name#],</p><p>[#transaction_details#]</p><br><p>'.__('We hope you enjoy. Thanks','templatic').'!</p><p>[#site_name#]</p>');
$content['status'] = '1';
$notification_email[] = $content;

$content = array();
$content['title'] = __('Payment success email to administrator ','templatic');
$content['subject'] = array('post_payment_success_admin_email_subject',__('Payment received successfully','templatic'));
$content['content'] = array('post_payment_success_admin_email_content','<p>'.__('Dear','templatic').' [#to_name#],</p><p>[#transaction_details#]</p><br><p>'.__('We hope you enjoy . Thanks','templatic').'!</p><p>[#site_name#]</p>');
$content['status'] = '1';
$notification_email[] = $content;

$content = array();
$content['title'] = __('Registration success email','templatic');
$content['subject'] = array('registration_success_email_subject',__('Log In Details','templatic'));
$content['content'] = array('registration_success_email_content','<p>'.__('Dear','templatic').' [#user_name#],</p>
<p>'.__('You can log in  with the following information','templatic').':</p><p>'.__('Username','templatic').': [#user_login#]</p><p>'.__('Password','templatic').': [#user_password#]</p>
<p>'.__('You can login from','templatic').' [#site_login_url#] '.__('or the URL is','templatic').' : [#site_login_url_link#] .</p><br><p>'.__('We hope you enjoy, Thanks','templatic').'!</p>
<p>[#site_name#]</p>');
$content['status'] = '1';
$notification_email[] = $content;

$content = array();
$content['title'] = __('Job apply email to admin','templatic');
$content['subject'] = array('job_apply_email_subject',__('Application for - [#post_title#]','templatic'));
$content['content'] = array('job_apply_email_content','Hello [#companyname#], <br><br>
			<p><b>Online application for the job post - <a href="[#post_link#]" target="_blank">[#post_title#]</a></b></p>
			<p>Applicant Name : [#apply_name#] </p>
			<p>Applicant Email : [#apply_email#] </p>
			<p>Description : [#apply_comments#] </p>
			<p>Resume : <a target="_blank" href="[#attachment#]">View Resume</a>   OR   [#attachment#] </p>
			<br>Thank You.');
$content['status'] = '1';
$notification_email[] = $content;

$notification_email = apply_filters('templ_email_notifications_filter',$notification_email);  //wp-admin email notification content controller filter

//////////////////////////////////////////////////////////////////////////
$notification_msg = array();

$content = array();
$content['title'] = __('Successful post submission notification','templatic');
$content['content'] = array('post_added_success_msg_content','<p>'.__('Thank you, your information has been successfully received','templatic').'.</p><p><a href="[#submited_information_link#]" >'.__('View your submitted information','templatic').' &raquo;</a></p>
<p>'.__('Thank you for visiting us at','templatic').' [#site_name#].</p>');
$notification_msg[] = $content;

$content = array();
$content['title'] = __('Payment successful notification','templatic');
$content['content'] = array('post_payment_success_msg_content','<h4>'.__('Your payment received successfully and your information is published','templatic').'.</h4><p><a href="[#submited_information_link#]" >'.__('View your submitted information','templatic').' &raquo;</a></p>
<h5>'.__('Thank you for becoming a member at','templatic').' [#site_name#].</h5>');
$notification_msg[] = $content;

$content = array();
$content['title'] = __('Payment canceled notification','templatic');
$content['content'] = array('post_payment_cancel_msg_content','<h3>'.__('Your listing is cancelled. Sorry for cancellation','templatic').'.</h3>
<h5>'.__('Thank you for visiting us at','templatic').' [#site_name#].</h5>');
$notification_msg[] = $content;

$content = array();
$content['title'] = __('Payment via bank transfer success notification','templatic');
$content['content'] = array('post_pre_bank_trasfer_msg_content','<p>'.__('Thank you, your request has been received successfully','templatic').'.</p>
<p>'.__('To publish the job please transfer the amount of','templatic').' <u>[#payable_amt#] </u> '.__('at our bank with the following information','templatic').' :</p><p>'.__('Bank Name','templatic').' : [#bank_name#]</p><p>'.__('Account Number','templatic').' : [#account_number#]</p><br><p>'.__('Please include the ID as reference','templatic').' :#[#submition_Id#]</p><p><a href="[#submited_information_link#]" >'.__('View your submitted listing','templatic').' &raquo;</a>
<br><p>Thank you for visit at [#site_name#].</p>');
$notification_msg[] = $content;

$notification_msg = apply_filters('templ_msg_notifications_filter',$notification_msg);  //wp-admin message notification content controller filter
?>