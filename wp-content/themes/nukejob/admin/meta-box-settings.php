<?php
/**
 * Registering meta boxes
 *
 * In this file, I'll show you how to extend the class to add more field type (in this case, the 'taxonomy' type)
 * All the definitions of meta boxes are listed below with comments, please read them carefully.
 * Note that each validation method of the Validation Class MUST return value instead of boolean as before
 *
 * You also should read the changelog to know what has been changed
 *
 * For more information, please visit: http://www.deluxeblogtips.com/2010/04/how-to-create-meta-box-wordpress-post.html
 *
 */

/********************* BEGIN DEFINITION OF META BOXES ***********************/

function wpnuke_register_meta_boxes() {
	// prefix of meta keys, optional
	// use underscore (_) at the beginning to make keys hidden, for example $prefix = '_rw_';
	// you also can make prefix empty to disable it

	//$prefix = '';
	$prefix = WPNUKE_PREFIX;

	$meta_boxes = array();

	// Set meta box for job post type
	$meta_boxes[] = array(
		'id' => 'job_apply',
		'title' => 'How to Apply?',
		'pages' => array('job'),
		'context' => 'normal',
		'priority' => 'high',
		
		'fields' => array(
			array(
				'name'          => '',
				'id'            => $prefix . 'job_instruction',
				'type'          => 'wysiwyg',
				'std'			=> '',
				'desc'			=> 'Enter your instruction for apply this job.'
			)
		)
	);
	
	$meta_boxes[] = array(
		'id' => 'job_settings',
		'title' => 'Job Settings (Recommended)',
		'pages' => array('job'),
		'context' => 'normal',
		'priority' => 'high',
		
		'fields' => array(
			array(
				'name' => 'Job Type',
				'id' => $prefix . 'job_type',
				'type' => 'select',
				'options' => array(
					'fulltime' => 'Full Time',
					'parttime' => 'Part Time',
					'freelance' => 'Freelance',
					'contract' => 'Contract',
					'internship' => 'Internship'
				),
				'std' => array('fulltime'),
				'desc' => 'Choose your job type.'
			),
			array(
				'name' => 'Job Feature Listing',
				'id' => $prefix . 'job_featured_list',
				'type' => 'select',
				'options' => array(
					'none' => 'None',
					'homepage' => 'Featured for home page',
					'category' => 'Featured for category page',
					'both' => 'Both'
				),
				'std' => array('none'),
				'desc' => 'Choose your job type.'
			),
			array(
				'name'          => 'Job Expiration Date',
				'id'            => $prefix . 'job_expire_date',
				'type'          => 'datetime',
				'format'		=> 'yy-mm-dd',
				'desc'			=> 'Enter your job expiration / end date (YYYY-MM-DD HH:MM:SS).'
			),
			/*
			array(
				'name' => 'Company Name',
				'id' => $prefix . 'company_name',
				'type' => 'text',
				'desc' => 'Enter your company name.'
			),
			array(
				'name' => 'Company Phone (Office)',
				'id' => $prefix . 'company_phone',
				'type' => 'text',
				'desc' => 'Enter your company office phone number. (Ex. +621210210).'
			),
			array(
				'name' => 'Company Phone (Mobile)',
				'id' => $prefix . 'company_mobile',
				'type' => 'text',
				'desc' => 'Enter your company mobile/sms phone number. (Ex. +628550000000).'
			),
			array(
				'name' => 'Company Email',
				'id' => $prefix . 'company_email',
				'type' => 'text',
				'desc' => 'Enter your company email address.'
			),
			array(
				'name' => 'Company Website',
				'id' => $prefix . 'company_website',
				'type' => 'text',
				'desc' => 'Enter your company website url.'
			),
			array(
				'name' => 'Company Logo',
				'id' => $prefix . 'company_logo',
				'type' => 'image',
				'desc' => 'Choose your company logo.'
			),
			// */
			array(
				'name'          => 'Job Location',
				'id'            => $prefix . 'job_location',
				'type'          => 'text',
				'std'           => '',
				'desc'			=> 'Enter comma separated places where your company is located (Ex. City, State, Country).'
				),
			array(
				'name'          => 'Job on Map',
				'id'            => $prefix . 'map_location',
				'type'          => 'gmap',
				'std'           => '-6.211544,106.84517200000005,15',	// 'latitude,longitude[,zoom]' (zoom is optional)
				'style'         => 'width: 550px; height: 360px',
				'address_field' => $prefix . 'job_location',			// Name of text field where address is entered. Can be list of text fields, separated by commas (for ex. city, state)
				'desc'			=> 'Click on "Find Address" and then you can also drag pinpoint to locate the correct address.'
			)
		)
	);
	
	// Set meta box for resume post type
	$meta_boxes[] = array(
		'id' => 'resume_settings',
		'title' => 'Resume Information (Recommended)',
		'pages' => array('resume'),
		'context' => 'normal',
		'priority' => 'high',
		
		'fields' => array(
			array(
				'name' => 'First Name',
				'id' => $prefix . 'resume_fname',
				'type' => 'text',
				'desc' => 'Enter your first name.'
			),
			array(
				'name' => 'Last Name',
				'id' => $prefix . 'resume_lname',
				'type' => 'text',
				'desc' => 'Enter your last name.'
			),
			array(
				'name' => 'Date of Birth',
				'id' => $prefix . 'resume_dob',
				'type' => 'date',
				'format' => 'yy-mm-dd',
				'desc' => 'Enter your date of birth (YYYY-MM-DD).'
			),
			array(
				'name' => 'Gender',
				'id' => $prefix . 'resume_gender',
				'type' => 'radio',
				'options' => array('male' => 'Male', 'female' => 'Female'),
				'desc' => 'Choose your gender.'
			),
			array(
				'name' => 'Home/Postal Address',
				'id' => $prefix . 'resume_address',
				'type' => 'textarea',
				'desc' => 'Enter your address.'
			),
			array(
				'name' => 'Phone Number (Home)',
				'id' => $prefix . 'resume_phone',
				'type' => 'text',
				'desc' => 'Enter your home phone number.'
			),
			array(
				'name' => 'Phone Number (Mobile)',
				'id' => $prefix . 'resume_mobile',
				'type' => 'text',
				'desc' => 'Enter your mobile phone number.'
			),
			array(
				'name' => 'Working Experience',
				'id' => $prefix . 'resume_experience',
				'type' => 'text',
				'desc' => 'Enter your working experience (Ex. 10 years experienced in web development).'
			),
			array(
				'name'	=> 'Desired Location',
				'id'	=> $prefix . 'resume_location',
				'type'	=> 'text',
				'desc'	=> 'Enter your desired working location (Ex. City, State, Country).'
			),
			array(
				'name' => 'Expected Salary',
				'id' => $prefix . 'resume_salary',
				'type' => 'text',
				'desc' => 'Enter your expected salary (Ex. 10000000).'
			),
			array(
				'name' => 'Skills',
				'id' => $prefix . 'resume_skill',
				'type' => 'text',
				'desc' => 'Enter your skills, multiple skills separated by comma (Ex. System administrator, Network administrator).'
			),
			array(
				'name' => 'Extra Activities',
				'id' => $prefix . 'resume_activity',
				'type' => 'textarea',
				'desc' => 'Enter your extra activities.'
			),
			array(
				'name' => 'Availability',
				'id' => $prefix . 'resume_type',
				'type' => 'select',
				'options' => array(
					'fulltime' => 'Full Time',
					'parttime' => 'Part Time',
					'freelance' => 'Freelance'
				),
				'std' => array('fulltime'),
				'desc' => 'Choose your availability type.'
			),
			array(
				'name' => 'Ready to work date',
				'id' => $prefix . 'resume_workdate',
				'type' => 'datetime',
				'format' => 'yy-mm-dd',
				'desc' => 'Enter your availability date to start working (YYYY-MM-DD HH:MM:SS).'
			),
			array(
				'name' => 'Upload Your Resume/CV File(s)',
				'id' => $prefix . 'resume_attachment',
				'type' => 'resume',
				'allowed_ext' => 'doc,docx,odt,pdf,rar,rtf,xls,zip',
				'desc' => 'Recommended formats: DOC, DOCX, ODT, PDF, RTF and Archive format (ZIP &amp; RAR) and can be no larger than 512KB'
			)
		)
	);
	
	foreach ($meta_boxes as $meta_box) {
		new RW_Meta_Box($meta_box);
	}
}
add_action( 'admin_init', 'wpnuke_register_meta_boxes' );

?>
