<?php
/**
 * Register custom post types and custom post statuses
 *
 * These functions handle registration of new custom post types and post statuses
 *
 * @author 		WPNuke
 * @category 	Admin
 * @package 	WPNuke/Admin
 * @version 1.0
 */

if (! defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Register Custom Post Type & Status
 **/
function wpnuke_custom_posts() {

	/**
	 * Custom Post Type
	 */
	// Post Type: jobs
	register_post_type(
		'job',
		array(	
			'label' 	=> 'job',
			'labels' 	=> array(	
								'name'				=> __('Jobs'),
								'singular_name'		=> __('Job', 'nukejob'),
								'menu_name'			=> _x('All Jobs', 'Admin menu name', 'nukejob'),
								'add_new'			=> __('Add New Job', 'nukejob'),
								'add_new_item'		=> __('Add New Job', 'nukejob'),
								'edit'				=> __('Edit', 'nukejob'),
								'edit_item'			=> __('Edit Job', 'nukejob'),
								'new_item'			=> __('New Job', 'nukejob'),
								'view_item'			=> __('View Job', 'nukejob'),
								'search_items'		=> __('Search Job', 'nukejob'),
								'not_found'			=> __('No jobs found', 'nukejob'),
								'not_found_in_trash'=> __('No jobs found in trash', 'nukejob'),
								'parent' 			=> __('Parent Job', 'nukejob')
							),
			'public'				=> true,
			'can_export'			=> true,
			'show_ui'				=> true, // Show UI in admin panel
			'_builtin' 				=> false, // It's a custom post type, not built in
			'_edit_link' 			=> 'post.php?post=%d',
			'capability_type' 		=> 'post',
			'map_meta_cap'			=> true,
			'publicly_queryable' 	=> true,
			'exclude_from_search' 	=> false,
			'hierarchical' 			=> false, // It is not a hierarchical taxonomy
			'menu_position'			=> 5,
			'menu_icon'				=> get_template_directory_uri() .'/admin/assets/images/favicon.png',
			'rewrite'				=> array('slug' => 'jobs'),
			'query_var'				=> 'job', // This goes to the WP_Query schema
			'supports' 				=> array('title', 'author', 'excerpt', 'thumbnail', 'comments', 'editor', 'trackbacks', 'custom-fields', 'page-attributes', 'revisions'),
			'show_in_nav_menus'		=> true ,
			'taxonomies'			=> array('job_category', 'job_company', 'job_tag')
		)
	);
	
	// Post Type: Resume
	register_post_type(
		'resume',
		array(	
			'label' 		=> 'resume',
			'labels' 		=> array(	
									'name'				=> __('Resumes'),
									'singular_name'		=> __('Resume', 'nukejob'),
									'menu_name'			=> _x('All Resumes', 'Admin menu name', 'nukejob'),
									'add_new'			=> __('Add New Resume', 'nukejob'),
									'add_new_item'		=> __('Add New Resume', 'nukejob'),
									'edit'				=> __('Edit', 'nukejob'),
									'edit_item'			=> __('Edit Resume', 'nukejob'),
									'new_item'			=> __('New Resume', 'nukejob'),
									'view_item'			=> __('View Resume', 'nukejob'),
									'search_items'		=> __('Search Resume', 'nukejob'),
									'not_found'			=> __('No resumes found', 'nukejob'),
									'not_found_in_trash'=> __('No resumes found in trash', 'nukejob')
								),
			'public'				=> true,
			'can_export'			=> true,
			'show_ui'				=> true, // Show UI in admin panel
			'_builtin' 				=> false, // It's a custom post type, not built in
			'_edit_link' 			=> 'post.php?post=%d',
			'capability_type' 		=> 'post',
			'map_meta_cap'			=> true,
			'publicly_queryable' 	=> true,
			'exclude_from_search' 	=> false,
			'hierarchical' 			=> false, // It is not a hierarchical taxonomy
			'menu_position'			=> 6,
			'menu_icon'				=> get_template_directory_uri() .'/admin/assets/images/favicon.png',
			'rewrite'				=> array('slug' => 'resume'),
			'query_var'				=> 'resume', // This goes to the WP_Query schema
			'supports' 				=> array('title', 'author', 'excerpt', 'thumbnail', 'comments', 'editor', 'trackbacks', 'custom-fields', 'page-attributes', 'revisions', 'sticky'),
			'show_in_nav_menus'		=> true ,
			'taxonomies'			=> array('resume_category', 'resume_tag')
		)
	);
	
	// Add another post type here
	
	/**
	 * Custom Post Status
	 */
	// register post status for expired jobs
register_post_status(
		'expired', 
		array(
			'label'						=> _x('Expired', 'nukejob'),
			'post_type'					=> 'job',
			'public'=> true,
			'_builtin'					=> true,
			'label_count'				=> _n_noop('Expired <span class="count">(%s)</span>', 'Expired <span class="count">(%s)</span>'),
			/*'exclude_from_search'   => false,
			'publicly_queryable'		=> true,
			'show_ui'					=> true,
			'show_in_admin_all_list'=> true,
			'show_in_admin_status_list' => true,
			'capability_type'			=> 'job'
			*/
		)
	);
}
add_action('init', 'wpnuke_custom_posts');

/**
 * Add filter to ensure the text Job, or job, is displayed when user updates a job
 */
function wpnuke_custom_updated_messages($messages) {
	global $post, $post_ID;
	
	// Job screen
	$messages['job'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf(__('Job updated. <a href="%s">View job</a>', 'wpnuke'), esc_url(get_permalink($post_ID))),
		2 => __('Custom field updated.', 'wpnuke'),
		3 => __('Custom field deleted.', 'wpnuke'),
		4 => __('Job updated.', 'wpnuke'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf(__('Job restored to revision from %s', 'wpnuke'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
		6 => sprintf(__('Job published. <a href="%s">View job</a>', 'wpnuke'), esc_url(get_permalink($post_ID))),
		7 => __('Job saved.', 'wpnuke'),
		8 => sprintf(__('Job submitted. <a target="_blank" href="%s">Preview job</a>', 'wpnuke'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
		9 => sprintf(__('Job scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview job</a>', 'wpnuke'),
			// translators: Publish box date format, see http://php.net/date
			date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
		10 => sprintf(__('Job draft updated. <a target="_blank" href="%s">Preview job</a>', 'wpnuke'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
	);

	// Resume screen
	$messages['resume'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf(__('Resume updated. <a href="%s">View resume</a>', 'wpnuke'), esc_url(get_permalink($post_ID))),
		2 => __('Custom field updated.', 'wpnuke'),
		3 => __('Custom field deleted.', 'wpnuke'),
		4 => __('Resume updated.', 'wpnuke'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf(__('Resume restored to revision from %s', 'wpnuke'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
		6 => sprintf(__('Resume published. <a href="%s">View resume</a>', 'wpnuke'), esc_url(get_permalink($post_ID))),
		7 => __('Resume saved.', 'wpnuke'),
		8 => sprintf(__('Resume submitted. <a target="_blank" href="%s">Preview resume</a>', 'wpnuke'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
		9 => sprintf(__('Resume scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview resume</a>', 'wpnuke'),
			// translators: Publish box date format, see http://php.net/date
			date_i18n(__('M j, Y @ G:i'), strtotime($post->post_date)), esc_url(get_permalink($post_ID))),
		10 => sprintf(__('Resume draft updated. <a target="_blank" href="%s">Preview resume</a>', 'wpnuke'), esc_url(add_query_arg('preview', 'true', get_permalink($post_ID)))),
	);

	return $messages;
}
add_filter('post_updated_messages', 'wpnuke_custom_updated_messages');

/**
 * Display contextual help for Jobs and Resumes
 */
function wpnuke_add_help_text( $contextual_help, $screen_id, $screen ) { 
	//$contextual_help .= var_dump( $screen ); // use this to help determine $screen->id
	
	// Job screen
	if ( 'job' == $screen->id ) {
		$contextual_help =
		'<p>' . __('Things to remember when adding or editing a job:', 'wpnuke') . '</p>' .
		'<ul>' .
		'<li>' . __('Specify the correct category such as Accounting, or Engineering.', 'wpnuke') . '</li>' .
		'<li>' . __('Specify the correct company or provider of the job. Remember that the Author module refers to you, the author of this job listing.', 'wpnuke') . '</li>' .
		'</ul>' .
		'<p>' . __('If you want to schedule the job listing to be published in the future:', 'wpnuke') . '</p>' .
		'<ul>' .
		'<li>' . __('Under the Job Publishing Tool, click on the Edit link next to Publish.', 'wpnuke') . '</li>' .
		'<li>' . __('Change the date to the date to actual publish this job listing, then click on Ok.', 'wpnuke') . '</li>' .
		'</ul>' .
		'<p><strong>' . __('For more support:', 'wpnuke') . '</strong></p>' .
		'<p>' . __('<a href="http://wpnuke.com/forums/" target="_blank">WPNuke Support Ticket</a>', 'wpnuke');
	} elseif ( 'edit-job' == $screen->id ) {
		$contextual_help = '<p>' . __('This is the help screen displaying the table of jobs...', 'wpnuke') . '</p>' ;
	}
	
	// Resume screen
	if ( 'resume' == $screen->id ) {
		$contextual_help =
		'<p>' . __('Things to remember when adding or editing a resume:', 'wpnuke') . '</p>' .
		'<ul>' .
		'<li>' . __('Specify the correct category such as Accounting, or Engineering.', 'wpnuke') . '</li>' .
		'</ul>' .
		'<p>' . __('If you want to schedule the resume to be published in the future:', 'wpnuke') . '</p>' .
		'<ul>' .
		'<li>' . __('Under the Publish module, click on the Edit link next to Publish.', 'wpnuke') . '</li>' .
		'<li>' . __('Change the date to the date to actual publish this resume, then click on Ok.', 'wpnuke') . '</li>' .
		'</ul>' .
		'<p><strong>' . __('For more support:', 'wpnuke') . '</strong></p>' .
		'<p>' . __('<a href="http://wpnuke.com/forums/" target="_blank">WPNuke Support Ticket</a>', 'wpnuke');
	} elseif ( 'edit-resume' == $screen->id ) {
		$contextual_help = '<p>' . __('This is the help screen displaying the table of resumes...', 'wpnuke') . '</p>' ;
	}

	// Add/Edit job company screen
	if ( 'edit-job_company' == $screen->id ) {
		$contextual_help =
		'<p>' . __('Things to remember when adding or editing a job company or job provider:', 'wpnuke') . '</p>' .
		'<ul>' .
		'<li>' . __('Specify the company name on the name column such as <em>WPNuke</em>.', 'wpnuke') . '</li>' .
		'<li>' . __('Specify the parent company on the parent column. It is useful to group the subsidiary company to its parent company.', 'wpnuke') . '</li>' .

		'</ul>' .
		'<p><strong>' . __('It is required to specify the company detials below!', 'wpnuke') . '</strong></p>' .
		'<ul>' .
		'<li>' . __('Scroll down to the Company Details area.', 'wpnuke') . '</li>' .
		'<li>' . __('Specify the company slogan such as <em>Handcrafted Wordpress Themes</em>.', 'wpnuke') . '</li>' .
		'<li>' . __('Specify the company phone number without the plus sign, such as <em>6227400000</em>.', 'wpnuke') . '</li>' .
		'<li>' . __('Specify the company email address such as <em>contact@yourcompany.com</em>. It is useful to send email notification when new user apply your job.', 'wpnuke') . '</li>' .
		'<li>' . __('Specify the company site url if any such as <em>http://wpnuke.com/</em>.', 'wpnuke') . '</li>' .
		'<li>' . __('Specify the company logo image, recommended in jpg/png format.', 'wpnuke') . '</li>' .
		'</ul>' .
		'<p><strong>' . __('For more support:', 'wpnuke') . '</strong></p>' .
		'<p>' . __('<a href="http://wpnuke.com/forums/" target="_blank">WPNuke Support Ticket</a>', 'wpnuke');
	}
	
	return $contextual_help;
	// */
}
add_action('contextual_help', 'wpnuke_add_help_text', 10, 3);

?>
