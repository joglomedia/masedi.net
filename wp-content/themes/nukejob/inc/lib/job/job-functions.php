<?php
/**
 * All Jobsite Functions
 */

// For future reference & update
define('APP_TAX_COMPANY', 'job_company');

/**
 * Convert array to object
 */
function wpnuke_array2object($data) {
	if (!is_array($data)) return $data;

	$object = new stdClass();
	if (is_array($data) && count($data) > 0) {
		foreach ($data as $name=>$value) {
			$name = strtolower(trim($name));
			if (!empty($name)) {
				$object->$name = wpnuke_array2object($value);
			}
		}
	}
	return $object;
}

/**
 * Build custom taxonomy term, specially for job_company taxonomy
 */
function wpnuke_get_term_meta($post_id, $taxonomy, $return = "ARRAY", $single = true) {
	/** Get job custom tax job-companies **/
	$wpn_terms = get_the_terms($post_id, $taxonomy);
	
	if ($wpn_terms && !is_wp_error($wpn_terms)) {
		$terms = array();

		// loop the available terms
		$n = 0;

		foreach($wpn_terms as $n => $wpn_term) {
			$term_id = $wpn_term->term_id;
			$terms["$n"]['term_id'] = $term_id;
			$terms["$n"]['name'] = $wpn_term->name;
			$terms["$n"]['slug'] = $wpn_term->slug;
			$terms["$n"]['term_group'] = $wpn_term->term_group;
			$terms["$n"]['term_order'] = $wpn_term->term_order;
			$terms["$n"]['term_taxonomy_id'] = $wpn_term->term_taxonomy_id;
			$terms["$n"]['taxonomy'] = $wpn_term->taxonomy;
			$terms["$n"]['description'] = $wpn_term->description;
			$terms["$n"]['parent'] = $wpn_term->parent;
			$terms["$n"]['count'] = $wpn_term->count;
			$terms["$n"]['object_id'] = $wpn_term->object_id;
			
			switch($taxonomy) {
				case 'job_company':
					if ($term_id) {
						// get the custom term meta data
						$terms["$n"]['company_slogan'] = get_metadata('post', $term_id, WPNUKE_PREFIX . 'job_company_slogan', true);
						$terms["$n"]['company_phone'] = get_metadata('post', $term_id, WPNUKE_PREFIX . 'job_company_phone', true);
						$terms["$n"]['company_email'] = get_metadata('post', $term_id, WPNUKE_PREFIX . 'job_company_email', true);
						$terms["$n"]['company_url'] = get_metadata('post', $term_id, WPNUKE_PREFIX . 'job_company_url', true);
						$thumb_id = get_metadata('post', $term_id, WPNUKE_PREFIX . 'job_company_thumbid', true);
						$terms["$n"]['company_thumb_id'] = $thumb_id;
						if ($thumb_id) {
							//$nmage = wp_get_attachment_url($thumb_id);
							$src  = wp_get_attachment_image_src($thumb_id, 'company-logo-small');
							$terms["$n"]['company_thumb_url']  = $src[0];
						} else {
							$terms["$n"]['company_thumb_url'] = get_bloginfo('template_directory') . '/admin/assets/images/no-image.png';
						}
					}
				break;
				
				default:
				break;
			}
		
			$n++;
		}
	
		if ("object" != strtolower($return)) {
			// return as an array
			if ($single)
				return $terms[$term_id];
			else
				return $terms;
		} else {
			// return as a std object
			$obj = wpnuke_array2object($terms);

			if ($single)
				return $obj->$term_id;
			else
				return $obj;
		}

	}
}

/**
 * Get job type
 */
function wpnuke_get_jobtype($post_id, $text = true) {
	$job_type = get_post_meta($post_id, WPNUKE_PREFIX . 'job_type', true); 
	
	if ($text) {
		switch($job_type) { 
			case 'fulltime': $txt_job_type = 'Full Time'; break; 
			case 'parttime': $txt_job_type = 'Part Time'; break; 
			case 'freelance': $txt_job_type = 'Freelance'; break;
			case 'contract': $txt_job_type = 'Contract'; break;
			case 'internship': $txt_job_type = 'Internship'; break;
			default: $txt_job_type = 'Full Time'; break;
		}
		return $txt_job_type;
	} else {
		return $job_type;
	}
}

/**
 * Get job company thumbnail
 */
function wpnuke_get_jobthumb($post_id, $thumb_size = 'company-logo') {
	// for backward post custom-field compatibility
	$thumb_id = absint(get_post_meta($post_id, WPNUKE_PREFIX . 'company_logo', true));
	if (!$thumb_id) {
		$tax = wpnuke_get_term_meta($post_id, 'job_company');
		$thumb_id = absint($tax['company_thumb_id']);
	}
	if ($thumb_id) {
		$thumb_image = wp_get_attachment_image_src($thumb_id, $thumb_size);
		$thumb_src = $thumb_image[0];
	} else {
		$thumb_src = get_bloginfo('template_directory') . '/images/default-logo.png';
	}
	
	return $thumb_src;
}

/**
 * Get job status (Active / Expired)
 */
function wpnuke_get_jobstatus($post_id) {
	// Get job expiration date
	$end_date = get_post_meta($post_id, WPNUKE_PREFIX . 'job_expire_date', true);

	// Get Job post status (Expired?)
	$job_status = get_post_status($post_id);

	if ('expired' == $job_status) {
		$job_status = 'Expired';
	} elseif ($end_date) {
		//$end_date = str_replace('-', '/', $end_date);
		$time_end = strtotime($end_date);
		$time_left = $time_end - time(); // time() --> time now
		$seconds = round($time_left);

		if ($seconds > 60) {
			$minutes = floor($seconds/60);
			$secondsleft = $seconds % 60;
		} else {
			$secondsleft = $seconds % 60;
		}
		
		if ($minutes > 60) {
			$hours = floor($minutes/60);
			$minutesleft = $minutes % 60;
		} else {
			$minutesleft = $minutes % 60;
		}
		
		if ($hours > 24) {
			$days = floor($hours/24);
			$hoursleft = $hours % 24;
		} else {
			$hoursleft = $hours % 24;
		}
		
		if (!$days && !$hoursleft && !$minutesleft) {
			$job_status = "Expired";
		} else {
			if ($days<10) $days = "0" . $days;
			if ($hoursleft<10) $hoursleft = "0" . $hoursleft;
			if ($minutesleft<10) $minutesleft = "0" . $minutesleft;
			if ($secondsleft<10) $secondsleft = "0" . $secondsleft;

			$job_status = "Valid:&nbsp;";

			if ($days != "00") {
				$days_s = ($days != "01") ? "days" : "day";
				$job_status .= "$days $days_s";
			} elseif ($hoursleft != "00") {
				$hour_s = ($hours != "01") ? "hours" : "hour";
				$job_status .= "$hoursleft $hour_s";
			} elseif ($minutesleft != "00") {
				$minute_s = ($minutes != "01") ? "minutes" : "minute";
				$job_status .= "$minutesleft $minute_s";
			} else {
				$job_status = "Expired";
			}
		}
	}else{
		$job_status = 'N/A';
	}

	return $job_status;
}


/**
 * Checks if a particular user has a role. 
 * Returns true if a match was found.
 * http://docs.appthemes.com/tutorials/wordpress-check-user-role-function/
 *
 * @param string $role Role name, ex: administrator.
 * @param int $user_id (Optional) The ID of a user. Defaults to the current user.
 * @return bool
 */
function wpnuke_check_user_role($role, $user_id = null) {
	if (is_numeric($user_id))
		$user = get_userdata($user_id);
	else
		$user = wp_get_current_user();
 
	if (empty($user))
		return false;

	return in_array($role, (array) $user->roles);
}

/**
 * Get job / resume submit link
 *
 * This function useful to handle getting job / resume link
 */
function wpnuke_submit_job_button(&$current_user) {
	$login = $current_user->user_login;
	$site_url = get_option('siteurl');
	$link = (array) $link;
	
	if ($login) {
		// get user role
		$role = $current_user->roles[1];
		$admin = $current_user->caps['administrator'];
		
		// Show job submit button link for administrator and job_provider
		if ($admin or ($role == "job_provider")) {
			if (wpnuke_get_option('show_postajoblink') == '1') {
				$link['url'] = $site_url . '/?page=submit_job';
				$link['anchor'] = __('Submit a Job', 'nukejob');
			}
		// Show resume submit button link for job_seeker
		} elseif ($role == "job_seeker") {
			if (wpnuke_get_option('show_postaresumelink') == '1') {
				$user_id = $current_user->ID;
				$arg_status = array('publish', 'pending', 'draft');
				$resume_id = wpnuke_get_user_posts_id($user_id, 'resume', $arg_status);

				if ($resume_id) {
					$link['url'] = $site_url . '/?page=edit_resume&amp;pid=' . $resume_id;
					$link['anchor'] = __('Edit a Resume', 'nukejob');
				} else {
					$link['url'] = $site_url . '/?page=submit_resume';
					$link['anchor'] = __('Submit a Resume', 'nukejob');
				}	
			}
		// Show resume submit button link for other user role
		} else {
			if (wpnuke_get_option('show_postaresumelink') == '1') {
				$link['url'] = $site_url . '/?page=submit_resume';
				$link['anchor'] = __('Submit a Resume', 'nukejob');
			}
		}
	} else {
		if (wpnuke_get_option('show_button') == 'Post a job') {
			$link['url'] = $site_url . '/?page=submit_job';
			$link['anchor'] = __('Submit a Job', 'nukejob');
		} elseif (wpnuke_get_option('show_button') == 'Post a resume') {
			$link['url'] = $site_url . '/?page=submit_resume';
			$link['anchor'] = __('Submit a Resume', 'nukejob');
		} else {
			$link['url'] = $site_url . '/?page=register';
			$link['anchor'] = __('Sign Up', 'nukejob');
		}
	}
	
	return $link;
}

/**
 * Get posts id posted/submited by user
 *
 * This function useful to handle getting user resume photo, cv/file attachment or etc
 *
 * Sample of usage, getting attachment (cv/file) from user posted resume:
 * $resume_id = wpnuke_get_user_posts_id($user_id, 'resume', 'publish');
 * $attachment_id = get_post_meta($resume_id, 'attachment', true);
 * $attachment_url = wp_get_attachment_link($attachment_id);
 */
function wpnuke_get_user_posts_id($post_author=null, $post_type=array(), $post_status=array(), $single = true) {
	global $wpdb;

	if (empty($post_author))
		return 0;

	$post_status = (array) $post_status;
	$post_type = (array) $post_type;

	$wpn_sql = $wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_author = %d AND ", $post_author);

	// Add post status
	if (!empty($post_status)) {
		$argtype = array_fill(0, count($post_status), '%s');
		$where = "(post_status = ".implode(" OR post_status = ", $argtype).') AND ';
		$wpn_sql .= $wpdb->prepare($where, $post_status);
	}

	// Add post type
	if (!empty($post_type)) {
		$argtype = array_fill(0, count($post_type), '%s');
		$where = "(post_type = ".implode(" OR post_type = ", $argtype).') AND ';
		$wpn_sql .= $wpdb->prepare($where, $post_type);
	}

	$wpn_sql .= '1=1';
	$wpn_posts = $wpdb->get_results($wpn_sql);
	
	$p_ID = (array) $p_ID;
	
	foreach($wpn_posts as $wpn_post) {
		$ID = $wpn_post->ID;
		$p_ID[] = $wpn_post->ID;
	}
	
	if ($single)
		return $ID;
	else
		return $p_ID;
}

/**
 * Function to check is current user has the resume both published or pending
 */
function is_currentuser_resume($user_id) {
	global $wpdb;
	
	$wpn_sql = $wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_author = '%d' AND post_type = 'resume' AND (post_status = 'publish' OR post_status = 'pending')", $user_id);
	$resume = $wpdb->get_row($wpn_sql);

	if ($resume){
		return true;
	} else {
		return false;
	}
}

/**
 * Function to print out html application button
 */
function wpnuke_apply_job_button($post_author, $post_id) {
	$current_user = wp_get_current_user();
	
	/*
	$user_meta_data = get_user_meta($current_user->ID, 'user_applied_jobs', true);
	
	if ($user_meta_data && in_array($post_id, $user_meta_data)) {
		$html .= '<span id="applied_job_' . $post_id . '" class="job"> <a href="javascript:void(0);" class="button removejob" onclick="javascript:applyForJob(\'' . $post_id . '\',\'remove\');">' . __('Remove Applied', 'wpnuke') . '</a></span>';  
	} else {
		$html .= '<span id="applied_job_' . $post_id . '" class="job"><a href="javascript:void(0);" class="button applyjob"  onclick="javascript:applyForJob(\'' . $post_id . '\',\'add\');">' . __('Apply Now', 'wpnuke') . '</a></span>';
	}
	*/
	
	$job_meta_data = get_post_meta($post_id, WPNUKE_PREFIX . 'job_applicant');
	
	if ($job_meta_data && in_array($current_user->ID, $job_meta_data)) {
		$html .= '<span id="applied_job_' . $post_id . '" class="job"><a href="javascript:void(0);" class="button job-remove" onclick="javascript:applyForJob(\'' . $post_id . '\',\'remove\');">' . __('Remove Application', 'wpnuke') . '</a></span>';  
	} else {
		$html .= '<span id="applied_job_' . $post_id . '" class="job"><a href="javascript:void(0);" class="button job-apply"  onclick="javascript:applyForJob(\'' . $post_id . '\',\'add\');">' . __('Apply Now', 'wpnuke') . '</a></span>';
	}
	
	echo $html;
}

/**
 * This function would add property to favorite listing and store the value in wp_postmeta table job_applicant field
 *
 * @param int $post_id
 * @return
 */
function wpnuke_apply_for_job($post_id) {
	global $current_user, $post;

	if (!get_current_user_id()) {
		$html = '<div class="apply-job">';
		$html .= __('<span class="job-register">To apply this job, please register as a job seeker from <a href="'.get_option("siteurl").'/?page=register">here</a>.</span>', 'wpnuke');
		$html .= '</div>';
		echo $html;
		exit;
	}
		
	/*
	$user_meta_data = array();
	$user_meta_data = get_user_meta($current_user->ID, 'user_applied_jobs', true);
	$user_meta_data[] = $post_id;
	add_user_meta($current_user->ID, 'user_applied_jobs', $user_meta_data);
	
	$author_id = $post->post_author;
	$meta_data = get_user_meta($author_id, 'user_applied_jobs', true);
	$meta_data[] = $current_user->ID;
	add_user_meta($author_id, 'user_applied_jobs', $meta_data);
	
	echo '<a href="javascript:void(0);" class="button removejob" onclick="javascript:applyForJob(\'' . $post_id . '\',\'remove\');">' . __('Remove application','wpnuke') . '</a>';
	
	// add job author to be an applicant so they have no apply job displayed when viewing his/her posted job, silly hack
	$author_id = $post->post_author;
	$app_meta_data = get_post_meta($author_id, WPNUKE_PREFIX . 'job_applicant');
	
	if ($app_meta_data && !in_array($author_id, $app_meta_data))
		add_user_meta($post_id, WPNUKE_PREFIX . 'job_applicant', $author_id);
	*/
	
	add_post_meta($post_id, WPNUKE_PREFIX . 'job_applicant', $current_user->ID);

	echo '<a href="javascript:void(0);" class="button job-remove" onclick="javascript:applyForJob(\'' . $post_id . '\',\'remove\');">' . __('Remove Application', 'wpnuke') . '</a>';
	
	// send email notification
	$notify = wpnuke_get_option('enable_notification');
	if ($notify || $notify == '1') {
		wpnuke_job_apply_notification($post_id);
	}
}

/**
 * This function would remove the user favorited job earlier
 *
 * @param int $post_id
 * @return echo
 */
function wpnuke_remove_from_job($post_id) {
	global $current_user, $post;
	$current_user = wp_get_current_user();
	
	/*
	$user_meta_data = array();
	$user_meta_data = get_user_meta($current_user->ID, 'user_applied_jobs', true);
	
	if (in_array($post_id, $user_meta_data)) {
		$user_new_data = array();
		foreach($user_meta_data as $key => $value) {
			if ($post_id == $value) {
				$value= '';
			} else {
				$user_new_data[] = $value;
			}
		}
		$user_meta_data	= $user_new_data;
	}
	update_user_meta($current_user->ID, 'user_applied_jobs', $user_meta_data);
	
	$author_id = $post->post_author;
	$meta_data = get_user_meta($author_id, 'user_applied_jobs', true);
	$array_data = array_diff($meta_data,array($current_user->ID));
	update_user_meta($author_id, 'user_applied_jobs', $array_data);
	*/
	
	$app_meta_data = get_post_meta($post_id, WPNUKE_PREFIX . 'job_applicant');
	
	if ($app_meta_data && in_array($current_user->ID, $app_meta_data)) {
		delete_post_meta($post_id, WPNUKE_PREFIX . 'job_applicant', $current_user->ID);
	}
	
	// send email notification
	$notify = wpnuke_get_option('enable_notification');
	if ($notify || $notify == '1')
		wpnuke_job_remove_notification($post_id);
	
	echo '<a class="button job-apply" href="javascript:void(0);" onclick="javascript:applyForJob(\''.$post_id.'\',\'add\');">' . __('Apply Job', 'wpnuke') . '</a>';
}

/**
 * Function to sent email notification for new job application
 *
 * @param int $post_id
 * @return 
 */
function wpnuke_job_apply_notification($post_id) {
	global $current_user, $post;
	$current_user = wp_get_current_user();
	
	// Get user resume information
	$user_id = $current_user->ID;
	$user_name = $current_user->display_name;
	$user_email = $current_user->user_email;
	$user_comments = get_user_meta($user_id, 'description', true);
	
	// Get user attachment files
	$resume_id = wpnuke_get_user_posts_id($user_id, 'resume', array('publish', 'pending'));
	$attachments_id = get_post_meta($resume_id, WPNUKE_PREFIX . 'resume_attachment');

	// Get wp upload base directory and base url, silly hack to get abspath of attachment file
	$uploads = wp_upload_dir();
	$upload_path = $uploads['basedir'];
	$upload_url = $uploads['baseurl'];
	
	// Get all resume attached files
	$attachments = array();
	
	$att = 0;
	foreach($attachments_id as $attachment_id) {
		$attachment_url = wp_get_attachment_url($attachment_id);
		$attachment_path = str_replace($upload_url, '', $attachment_url);
		$attachments_url[] = $attachment_url;
		$attachments[] = wpnuke_correct_path($upload_path . $attachment_path);
		$att++;
	}
	
	// Define recipients contact
	$recipients= array();
	
	// Get site administrator contact
	$site_name = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
	$site_url = get_bloginfo('url');
	$admin_email = get_bloginfo('admin_email');
	
	// Add site admin as recipients
	$recipients[] = array('name' => $site_name, 'email' => $admin_email);

	// Get post resume information
	//$post = $wpdb->get_row("select * from $wpdb->posts where ID = '".$post_id."'");
	$post = get_post($post_id);
	$post_title = $post->post_title;
	$post_link = get_permalink($post->ID);
	
	// Get job author information
	$author = get_userdata($post->post_author);
	$author_name = $author->display_name;
	$author_email = $author->user_email;
	
	// Add author as recipients if it is not the site admin
	if ($author_email != $admin_email) {
		$recipients[] = array('name' => $author_name, 'email' => $author_email);
	}
	
	// Get company job provider information
	//$job_terms = wpnuke_get_term_meta($post->ID, 'job_company');
	$job_terms = get_the_terms($post->ID, 'job_company');
	
	foreach($job_terms as $job_term) {
		$term_id = $job_term->term_id;
		$company_name = $job_term->name;
		$company_email = get_metadata('post', $term_id, WPNUKE_PREFIX . 'job_company_email', true);
		
		// Add company information as recipients
		$recipients[] = array('name' => $company_name, 'email' => $company_email);
	}
	
	// Set email subject
	$subject = wpnuke_get_option('apply_email_subject');
	if (!$subject){
		$subject = __('New job application for - ', 'wpnuke') . '%post_title%';
	}
	$subject = str_replace('%post_title%', $post_title, $subject);

	// Set email content
	$messages = wpnuke_get_option('apply_email_content');
	if (!$messages) {
		$messages = "<p>" . __('Dear', 'wpnuke') . " %company_name%, <br /><br /></p>" .
		"<p><strong>" . __('There is a new online application for the job post - ', 'wpnuke') . "<a href=\"%post_link%\" target=\"_blank\">%post_title%</a></strong></p>" .
		"<ul>" .
		"<li>" . __('Applicant Name', 'wpnuke') . " : %user_name%</li>" .
		"<li>" . __('Applicant Email', 'wpnuke') . " : %user_email%</li>" .
		"<li>" . __('Description', 'wpnuke') . " : %user_comments%</li>" .
		"<li>" . __('Attached Resume/CV files', 'wpnuke') . " : %attachments%</li>" .
		"<p>Thank You.<br /><a href=\"%site_url%\">%site_name%</a></p>";
	}
	
	if (!empty($attachments_url)) {
		$attachment_list .= "<ul>";
			
		foreach ($attachments_url as $attachment_url) {
			$attachment_list .= "<li><a target=\"_blank\" href=\"" . $attachment_url . "\">View Resume</a></li>";
		}
		
		$attachment_list .= "</ul>";
	} else {
		$attachment_list .= "No attachment file uploaded.";
	}


	$search_array = array('%post_link%', '%post_title%', '%user_name%', '%user_email%','%user_comments%', '%site_url%', '%site_name%', '%attachments%');
	$replace_array = array($post_link, $post_title, $user_name, $user_email, nl2br($user_comments), $site_url, $site_name, $attachment_list);
	
	$messages = str_replace($search_array, $replace_array, $messages);
 
 	$mailsender = wpnuke_get_option('mail_sender');
	
	// set wp mail header
	$headers = 'From: ' . $site_name . ' <' . $admin_email . '>' . "\r\n";
	add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));
	
	// send email notification
	foreach ($recipients as $recipient) {
		$message = str_replace('%company_name%', $recipient['name'], $messages);
		wp_mail($recipient['email'], $subject, $message, $headers, $attachments);
		//var_dump($message);
	}
}

/**
 * Function to sent email notification for job application removal
 *
 * @param int $post_id
 * @return 
 */
function wpnuke_job_remove_notification($post_id){
	global $current_user, $post;
	$current_user = wp_get_current_user();
	
	// Get user resume information
	$user_id = $current_user->ID;
	$user_name = $current_user->display_name;
	$user_email = $current_user->user_email;
	$user_comments = get_user_meta($user_id, 'description', true);
	
	// Define recipients contact
	$recipients= array();
	
	// Get site administrator contact
	$site_name = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
	$site_url = get_bloginfo('url');
	$admin_email = get_bloginfo('admin_email');
	
	// Add site admin as recipients
	$recipients[] = array('name' => $site_name, 'email' => $admin_email);

	// Get post resume information
	//$post = $wpdb->get_row("select * from $wpdb->posts where ID = '".$post_id."'");
	$post = get_post($post_id);
	$post_title = $post->post_title;
	$post_link = get_permalink($post->ID);
	
	// Get job author information
	$author = get_userdata($post->post_author);
	$author_name = $author->display_name;
	$author_email = $author->user_email;
	
	// Add author as recipients if it is not the site admin
	if ($author_email != $admin_email) {
		$recipients[] = array('name' => $author_name, 'email' => $author_email);
	}
	
	// Get company job provider information
	//$job_terms = wpnuke_get_term_meta($post->ID, 'job_company');
	$job_terms = get_the_terms($post->ID, 'job_company');
	
	foreach($job_terms as $job_term) {
		$term_id = $job_term->term_id;
		$company_name = $job_term->name;
		$company_email = get_metadata('post', $term_id, WPNUKE_PREFIX . 'job_company_email', true);
		
		// Add company information as recipients
		$recipients[] = array('name' => $company_name, 'email' => $company_email);
	}
	
	// Set email subject
	$subject = wpnuke_get_option('removal_email_subject');
	if (!$subject){
		$subject = __('Job application removal for - ', 'wpnuke') . '%post_title%';
	}
	$subject = str_replace('%post_title%', $post_title, $subject);

	// Set email content
	$messages = wpnuke_get_option('removal_email_content');
	if (!$messages) {
		$messages = "<p>" . __('Dear', 'wpnuke') . " %company_name%, <br /><br /></p>\r\n" .
		"<p><strong>%user_name% " . __('removed application for the job post -', 'wpnuke') . " <a href=\"%post_link%\" target=\"_blank\">%post_title%</a></strong></p>\r\n" .
		"<ul>\r\n" .
		"<li>" . __('Applicant Name', 'wpnuke') . " : %user_name%</li>\r\n" .
		"<li>" . __('Applicant Email', 'wpnuke') . " : %user_email%</li>\r\n" .
		"</ul>\r\n" .
		"<p>Thank You.<br /><a href=\"%site_url%\">%site_name%</a></p>";
	}

	$search_array = array('%post_link%', '%post_title%', '%user_name%', '%user_email%','%user_comments%', '%site_url%', '%site_name%');
	$replace_array = array($post_link, $post_title, $user_name, $user_email, nl2br($user_comments), $site_url, $site_name);
	
	$messages = str_replace($search_array, $replace_array, $messages);
 	
	// set wp mail header
	$headers = 'From: ' . $site_name . ' <' . $admin_email . '>' . "\r\n";
	add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));
	
	// send email notification
	foreach ($recipients as $recipient) {
		$message = str_replace('%company_name%', $recipient['name'], $messages);
		wp_mail($recipient['email'], $subject, $message, $headers, $attachments);
		//var_dump($message);
	}
}


/**
 * Custom MySQL Post's Query Join
 *
 * Provides joins for expired or unreliable post filters
 */
function wpnuke_custom_posts_join($join, $wp_query){
	global $wpdb;
	
	// Provide left/inner join for not_expired_job filter_unreliable expression
	if ($wp_query->get('not_expired_post') || $wp_query->get('unreliable_post')) {
		$join .= " INNER JOIN $wpdb->postmeta AS pm1 ON (pm1.post_id = $wpdb->posts.ID)";
		//$join .= " INNER JOIN $wpdb->postmeta AS pm2 ON (pm2.post_id = $wpdb->posts.ID)";
	}
	
	// Provide left/inner join only for expired_job expression
	if ($wp_query->get('expired_post')) {
		$join .= " LEFT JOIN $wpdb->postmeta AS pm1 ON (pm1.post_id = $wpdb->posts.ID)";
	}
	
	return $join;
}
add_filter('posts_join', 'wpnuke_custom_posts_join', 10, 2);

/**
 * Custom MySQL Post's Query Filter
 *
 * Filters active, expired or unreliable posts
 * Expired or unreliable posts marked by post meta custom-post_expire_date field
 */
function wpnuke_custom_posts_filter($where, $wp_query){
	global $wpdb;

	// Filters out expired and unreliable posts
	if ($wp_query->get('unreliable_post')) {
		$expired = " (pm1.meta_key = '" . WPNUKE_PREFIX . "job_expire_date' AND STR_TO_DATE(pm1.meta_value, '%Y-%m-%d') < CURRENT_DATE())";
		$not_empty = " (pm1.meta_key = '" . WPNUKE_PREFIX . "job_expire_date' AND pm1.meta_value != '')";
		$expired_match = " ($expired AND $not_empty)";

		$where .= " AND $expired_match";
	}
	
	// Filters out expired posts (predefined by meta key expire_date or post status 'expired'), and Return only not expired (active) posts
	if ($wp_query->get('not_expired_post')) {
		$where .= " AND ((pm1.meta_key = '" . WPNUKE_PREFIX . "job_expire_date') AND (STR_TO_DATE(pm1.meta_value, '%Y-%m-%d') >= CURRENT_DATE() OR (pm1.meta_value = ''))) AND ($wpdb->posts.post_status != 'expired')";
	}
	
	// Filters out non-expired posts, and Return only expired posts predefined by meta key expire_date
	if ($wp_query->get('expired_post')) {
		$where .= " AND (pm1.meta_key = '" . WPNUKE_PREFIX . "job_expire_date') AND (STR_TO_DATE(pm1.meta_value, '%Y-%m-%d') < CURRENT_DATE())";
	}
	
	return $where;
}
add_filter('posts_where', 'wpnuke_custom_posts_filter', 10, 2);

/**
 * Prune expired job
 *
 * Update job post status from publish to expired or draft or trash it
 * And sent email notification to site admin, job author and/or job provider
 */
function wpnuke_job_prune() {
	// If prune not set, return it
	$pruned = wpnuke_get_option('prune_expired');
	if ($pruned == 'no' || $pruned == false)
		return;
	
	// Define recipients contact
	$recipients= array();
	
	// Get site administrator contact
	$site_name = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
	$site_url = get_bloginfo('url');
	$admin_email = get_bloginfo('admin_email');

	// Get all posts with an expired date that have expired
	$args = array(
		'post_type' => 'job',
		'expired_post' => true,
		'posts_per_page' => -1,
		'fields' => 'ids',
		'meta_query' => array(
  			array(
				'key' => WPNUKE_PREFIX . 'job_expire_date',
				'value' => '',
				'compare' => '!='
  			)
		)
	);
	$expired = new WP_Query($args);
	
	$total_expired_post = $expired->found_posts;
	$message_details = '';
	$expired_jobs = array();
	$recipients = array();
	$have_expired = false;

	// Set new post status
	$prune_status = wpnuke_get_option('prune_status');
	if (!$prune_status || $prune_status == 'none') {
		$prune_status = 'expired';
	}
	
	// Add site admin as recipients
	//$recipients[] = array('name' => $site_name, 'email' => $admin_email, 'message' => '');

	if (isset($expired->posts) && is_array($expired->posts)) {
		foreach ($expired->posts as $post_id) {
			if($post_id) {
				// Update post status
				wp_update_post(array('ID' => $post_id, 'post_status' => $prune_status));
				
				// Get post author data
				$post = get_post($post_id);
				$author = get_userdata($post->post_author);
				$author_name = $author->display_name;
				$author_email = $author->user_email;
				
				$expired_job = array('title' => $post->post_title, 'url' => get_bloginfo('url') . '/?p=' . $post_id);
	
				// Add author as recipients if it is not the site admin
				if ($author_email != $admin_email) {
					$recipients[] = array('name' => $author_name, 'email' => $author_email, 'info' => $expired_job);
				}
				
				$expired_jobs[] = $expired_job;
				
				$have_expired = true;
			}
		}
	}

	// Send email notification
	$prune_notify = wpnuke_get_option('prune_notification');
	if ($prune_notify || $prune_notify == '1') {
		
		// Set email header
		$headers = 'From: '. $site_name .' <'. $admin_email .'>' . "\r\n";
		// overwrite content type
		add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));

		// Set email subject
		$subject = wpnuke_get_option('prune_email_subject');
		if (!$subject){
			$subject = __('You have %total_expired_post% expired jobs', 'wpnuke' );
		}

		// Set email message
		$admin_message = '';
		
		if ($have_expired) {
			$expired_post = '<p>' . __('The following jobs expired and have been taken down from %site_url%: ', 'wpnuke') . '</p>' . "\r\n";
			$expired_post .= '<ul>' . "\r\n";
			
			foreach ($expired_jobs as $expired_job) {
				$expired_post .= '<li><a href="' . $expired_job['url'] . '">' . $expired_job['title'] . '</a></li>' . "\r\n";
			}
			
			$expired_post .= '</ul>' . "\r\n";
		} else {
			$expired_post = __('No expired jobs were found.', 'wpnuke');
		}
			
		$admin_message = '<p>' . __('Dear %company_name%', 'wpnuke') . ',<br /></p>' . "\r\n" . 
			'<p>' . __('Your cron job has run successfully at %today_date%.', 'wpnuke') . '</p>' . "\r\n" . 
			'%expired_post%' . "\r\n" .
			'<p>Thank You.<br /><a href="%site_url%">%site_name%</a></p>';

		$search_array = array('%today_date%', '%total_expired_post%', '%expired_post%', '%site_url%', '%site_name%', '%admin_email%');
		$replace_array = array(date('Y-m-d h:m:s'), $total_expired_post, $expired_post, $site_url, $site_name, $admin_email);
		
		// Set admin email subject
		$admin_subject = str_replace('%total_expired_post%', $total_expired_post, $subject);

		// Set admin email message
		$admin_message = str_replace($search_array, $replace_array, $admin_message);
		$admin_message = str_replace('%company_name%', 'Site Admin', $admin_message);
		
		// Send email notification to site admin
		wp_mail($admin_email, $admin_subject, $admin_message, $headers);
		
		// Send email notification to job author/provider
		foreach ($recipients as $recipient) {
			
			wp_mail($recipient, __('Jobs Listing Expired', 'wpnuke'), $message, $headers);
		} // */
	}
	
	//var_dump($admin_message);
}
add_action('wpnuke_job_prune', 'wpnuke_job_prune');

/**
 * Schedules prune expired job.
 *
 * Runs a Wordpress cron to prune jobs which has expired.
 */
if (wpnuke_get_option('cron') == 'wordpress') :
function wpnuke_schedule_job_prune() {
	$do_prune = wpnuke_get_option('prune_expired');
	$interval = wpnuke_get_option('prune_interval');
	if ($interval == 'none') { $interval = 'daily'; }
	
	if ($do_prune == 'yes') {
		if (!wp_next_scheduled('wpnuke_job_prune')) {
			wp_schedule_event(time(), $interval, 'wpnuke_job_prune');
		}
	}
	//wpnuke_job_prune();
}
add_action('init', 'wpnuke_schedule_job_prune');
endif;

/**
 * Add custom schedule interval to wp cron
 *
 * Runs a custom schedule event at custom interval
 */
if(!function_exists('wpnuke_add_cron_schedules')) :
	function wpnuke_add_cron_schedules($schedules) {
		// Adds once weekly, once monthly and custom interval to the existing cron schedules.
		$interval = wpnuke_get_option('prune_interval');

		if($interval && $interval != 'none') {
			switch($interval) {
				case 'weekly':
					$schedules['weekly'] = array(
						'interval' => 604800,
						'display' => __('Once Weekly', 'wpnuke')
					);
				break;
				case 'monthly':
					// assume 30 days
					$schedules['monthly'] = array(
						'interval' => 2592000,
						'display' => __('Once Monthly', 'wpnuke')
					);
				break;
				default:
					// for custom interval, require interval value
					$interval_value = absint(wpnuke_get_option('prune_interval_value'));
					if(!empty($interval_value)) {
						$schedules['custom'] = array(
							'interval' => $interval_value,
							'display' => sprintf(__('Custom cron interval every %s seconds', 'wpnuke'), $interval_value)
						);
					}
				break;
			}
		}
		
		return $schedules;
	}
	add_filter('cron_schedules', 'wpnuke_add_cron_schedules');
endif;

/** Job Companies Function **/

/**
 * Get all hidden companies
 *
 * company active status marked as 'no'
 * return array of hidden companies ids
 */
function wpnuke_get_hidden_companies() {
	global $wpdb, $hidden_companies;

	if (!isset($hidden_companies) || !is_array($hidden_companies)) {
			// get ids of all hidden companies
			$hidden_companies_query = "SELECT $wpdb->postmeta.post_id FROM $wpdb->postmeta WHERE $wpdb->postmeta.meta_key = %s AND $wpdb->postmeta.meta_value = %s";
			$hidden_companies = $wpdb->get_col($wpdb->prepare($hidden_companies_query, WPNUKE_PREFIX . 'job_company_active', 'no'));
	}

	return $hidden_companies;
}

/**
 * Get company list for company page template
 */
function wpnuke_get_company_list() {
	// get all the companies	
	$companies = get_terms('job_company', array('hide_empty' => 0, 'child_of' => 0, 'pad_counts' => 1));

	// get ids of all hidden companies 
	$hidden_companies = wpnuke_get_hidden_companies();
	$list = '';
	$groups = array();

	if ($companies && is_array($companies) ) {

		// unset child 
		foreach($companies as $key => $value) {
			if($value->parent != 0)
				unset($companies[$key]);
		}
		
		// Get First letter for shorting by name
		foreach($companies as $company) {
			$groups[mb_strtoupper(mb_substr($company->name, 0, 1))][] = $company;
		}
		
		if (!empty($groups)) {
		
			foreach($groups as $letter => $companies) {
				$old_list = $list;
				$letter_items = false;
				$list .= "\n\t" . '<h2 class="companies-cap">' . apply_filters( 'the_title', $letter ) . '</h2>';
				$list .= "\n\t" . '<ul class="companies clearfix">';
				
				foreach($companies as $company) {
					if (!in_array($company->term_id, $hidden_companies)) {
						$list .= "\n\t\t" . '<li><a href="' . get_term_link($company, 'job_company') . '">' . apply_filters('the_title', $company->name). '</a> (' . intval($company->count) . ')</li>';
						$letter_items = true;
					}
				}	
					
				$list .= "\n\t" . '</ul>';

				if(!$letter_items)
					$list = $old_list;
			}
			
		}
		
	} else {
		$list .= "\n\t" . '<p class="error">' . __('Sorry, but no companies were found.', 'wpnuke') .'</p>';
	}
	
	if($list)
		return $list;
	else
		return false;
}

/** 
 * Get popular companies
 *
 * return company links by most popular (most job post)
 */
function wpnuke_get_popular_companies($the_limit = 5, $before = '', $after = '') {
	global $wpdb;

	$hidden_companies = wpnuke_get_hidden_companies();
	$companies_array = get_terms('job_company', array('orderby' => 'count', 'hide_empty' => 1, 'number' => $the_limit, 'exclude' => $hidden_companies));
	$pop_companies = '';
	
	if ($companies_array && is_array($companies_array)) {
		foreach ($companies_array as $company) {
			$link = get_term_link($company, 'job_company');
			$pop_companies .= $before . '<a class="tax-link" href="'.$link.'">'.$company->name.'</a>'. $after;
		}
	}
	
	return $pop_companies;
}

/**
 * Ajax auto-complete search for company name
 * Search format suggestion: Job title, company name
 */
function wpnuke_tax_name_suggest() {
	global $wpdb;

	if ( !isset($_GET['tax']) )
		die('0');

	$taxonomy = $_GET['tax'];
	if ( !taxonomy_exists( $taxonomy ) )
		die('0');

	$s = $_GET['term']; // is this slashed already?

	// search term format: job title, company name
	if ( false !== strpos( $s, ',' ) ) {
		$s = explode( ',', $s );
		$s = end( $s );
	}

	$s = trim( $s );
	if ( strlen( $s ) < 2 )
		die; // require 2 chars for matching

	$sql = "SELECT t.slug FROM $wpdb->term_taxonomy AS tt INNER JOIN
		$wpdb->terms AS t ON tt.term_id = t.term_id
		WHERE tt.taxonomy = %s
		AND t.name LIKE ('%%" . esc_sql( like_escape( $s ) ) . "%%')
		LIMIT 50
		";

	$sql = $wpdb->prepare( $sql, $taxonomy );
	$terms = $wpdb->get_col($sql);

	// return the term details via json
	if (empty($terms)){
		echo json_encode($terms);
		die;
	} else {
		$i = 0;
		$results = array();
		foreach ($terms as $term) {

			$obj = get_term_by( 'slug', $term, $taxonomy );

			// Don't return stores with no active coupons or hidden stores
			if( ($obj->count < 1) || (get_metadata($obj->taxonomy, $obj->term_id, WPNUKE_PREFIX . 'job_company_active', true) == 'no') )
				continue;

			$results[$i] = $obj;
			$results[$i]->company_url = get_metadata($results[$i]->taxonomy, $results[$i]->term_id, WPNUKE_PREFIX . 'job_company_url', true);
			$results[$i]->company_image_url = ($results[$i]->company_url ? "http://s.wordpress.com/mshots/v1/" . urlencode($results[$i]->company_url) . "?w=110" : false);
			$i++;

			// Limit to 5 search results
			if($i == 5){
				break;
			}
		}
		echo json_encode($results);
		die;
	}
}

?>
