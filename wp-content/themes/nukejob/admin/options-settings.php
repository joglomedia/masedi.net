<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);

	//echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {

	// Slide Animation Effect
	$nivo_slide_effect = array("sliceDown" => "Slice Down","sliceDownLeft" => "Slice Down Left","sliceUp" => "Slice Up","sliceUpLeft" => "Slice Up Left","sliceUpDown" => "Slice Up Down","sliceUpDownLeft" => "Slice Up Down Left","fold" => "Fold","fade" => "Fade","random" => "Random","slideInRight" => "Slide In Right","slideInLeft" => "Slide In Left","boxRandom" => "Box Random","boxRain" => "Box Rain","boxRainReverse" => "Box Rain Reverse","boxRainGrow" => "Box Rain Grow","boxRainGrowReverse" => "Box Rain Grow Reverse");
	
	// Heading Font
	$heading_font = array(
		'arial'                    => 'Arial',
		'verdana'                  => 'Verdana, Geneva',
		'trebuchet'                => 'Trebuchet',
		'georgia'                  => 'Georgia',
		'times'                    => 'Times New Roman',
		'tahoma'                   => 'Tahoma, Geneva',
		'palatino'                 => 'Palatino',
		'helvetica'                => 'Helvetica',
		'Titillium Text Light'     => 'Titillium Text Light',
		''                         => '-- Google Webfont --',
		'PT Sans'                  => 'PT Sans',
		'PT Serif'                 => 'PT Serif',
		'Droid Sans'               => 'Droid Sans',
		'Droid Serif'              => 'Droid Serif',
		'Nobile'                   => 'Nobile',
		'Dancing Script'           => 'Dancing Script',
		'Cantarell'                => 'Cantarell',
		'Josefin Sans'             => 'Josefin Sans',
		'Old Standard TT'          => 'Old Standard TT',
		'Playfair Display'         => 'Playfair Display',
		'Quattrocento'             => 'Quattrocento',
		'Quattrocento Sans'        => 'Quattrocento Sans',
		'The Girl Next Door'       => 'The Girl Next Door',
		'Over the Rainbow'         => 'Over the Rainbow',
		'Tangerine'                => 'Tangerine',
		'Puritan'                  => 'Puritan',
		'Goudy Bookletter 1911'    => 'Goudy Bookletter 1911',
		'Arimo'                    => 'Arimo',
		'EB Garamond'              => 'EB Garamond',
		'Molengo'                  => 'Molengo',
		'OFL Sorts Mill Goudy TT'  => 'OFL Sorts Mill Goudy TT',
		'Crimson Text'             => 'Crimson Text',
		'Cabin'                    => 'Cabin',
		'Annie Use Your Telescope' => 'Annie Use Your Telescope',
		'Philosopher'              => 'Philosopher',
		'Bitter'                   => 'Bitter',
		'Terminal Dosis'           => 'Terminal Dosis',
		'Cardo'                    => 'Cardo'
	);
	
	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/images';
	
	$options = array();

	/** General Site Settings **/
	
	$options[] = array(
		'name' => __('General', 'wpnuke'),
		'type' => 'heading'
	);
	
	$options['logo'] = array(
		'name' => __('Site Logo', 'wpnuke'),
		'desc' => __('Upload a logo for your website, or specify an image URL directly here.', 'wpnuke'),
		'id' => 'logo',
		'std' => $imagepath . '/logo.png',
		'type' => 'upload'
	);
	
	$options['favicon'] = array(
		'name' => __('Site Favicon', 'wpnuke'),
		'desc' => __('A favicon is a 16x16 pixel icon that represents your site, upload your favicon here.', 'wpnuke'),
		'id' => 'favicon',
		'std' => $imagepath . '/favicon.png',
		'type' => 'upload'
	);
	
	$options['login_logo'] = array(
		'name' => __('Custom Login Logo', 'wpnuke'),
		'desc' => __('Upload your custom login logo here.', 'wpnuke'),
		'id' => 'login_logo',
		'std' => $imagepath . '/logo.png',
		'type' => 'upload'
	);
	
	$options['rss_url'] = array(
		'name' => __('RSS Feed URL', 'wpnuke'),
		'desc' => __('Enter your Feedburner (or other) RSS feed URL here.', 'wpnuke'),
		'id' => 'rss_url',
		'std' => '',
		'type' => 'text'
	);
	
	$options['page_comment'] = array(
		'name' => __('Enable Comment on Page?', 'wpnuke'),
		'desc' => __('Check if you want to enable comment on standard page.', 'wpnuke'),
		'id' => 'page_comment',
		'std' => '0',
		'type' => 'checkbox'
	);
	
	$options['footer_text'] = array(
		'name' => __('Custom Footer Text', 'wpnuke'),
		'desc' => __('Enter text used in the left side of the footer. e.g: Copyright &copy; WPNuke. All Rights Reserved.', 'wpnuke'),
		'id' => 'footer_text',
		'std' => '',
		'type' => 'textarea'
	);
	
	$options['error404_text'] = array(
		'name' => __('Error 404 Text', 'wpnuke'),
		'desc' => sprintf(__('This text will appear on error 404 page. You can visit your 404 page here: %s/404', 'wpnuke'), get_bloginfo('url')),
		'id' => 'error404_text',
		'std' => "We're sorry, but we can't find the page you were looking for. It's probably some thing we've done wrong but now we know about it we'll try to fix it. In the meantime, try returning to the homepage or search something below.",
		'type' => 'textarea',
		//'settings' => array('textarea_rows' => 5)
	);
	
	$options[] = array(
		'name' => __('Analytic/Tracking Code', 'wpnuke'),
		'type' => 'subheading'
	);
	
	$options['track_code'] = array(
		'name' => __('Analytic/Tracking Code', 'wpnuke'),
		'desc' => __('Paste your Google Analytics (or other) tracking code here. This will be automatically added to the footer.', 'wpnuke'),
		'id' => 'track_code',
		'std' => '',
		'type' => 'textarea'
	);
	
	/** **/
	
	$options[] = array(
		'name' => __('Skins', 'wpnuke'),
		'type' => 'heading');
	
	$options[] = array(
		"name" => __('Skins', 'wpnuke'),
		"desc" => __('Select your theme alternative skins.', 'wpnuke'),
		"id" => "theme_skin",
		"std" => "dark-blue",
		"type" => "images",
		"options" => array(
			'dark-blue' => $imagepath . '/admin/dark-blue.jpg',
			'light-blue' => $imagepath . '/admin/light-blue.jpg',
			'dark-green' => $imagepath . '/admin/dark-green.jpg',
			'light-green' => $imagepath . '/admin/light-green.jpg',
			'dark-red' => $imagepath . '/admin/dark-red.jpg')
	);
	
	$options[] = array(
		'name' => __('Homepage', 'wpnuke'),
		'type' => 'heading');
	
	$options[] = array(
		'name' => __('Homepage Slider', 'wpnuke'),
		'desc' => __('Choose type of slider you want to use on your homepage or disable it.', 'wpnuke'),
		'id' => 'home_slider',
		'std' => 'nivo',
		'type' => 'select',
		'options' => array('nivo' => 'Nivo Slider','accordion' => 'Accordion Slider','piecemaker' => 'Piecemaker 2 Slider','video_content' => 'Video and Content','disable' => 'Disable Slider'));
	
	$options[] = array(
		'name' => __('Piecemaker ID', 'wpnuke'),
		'desc' => __('Insert your piecemaker ID here. Leave it blank if you are using another slider.', 'wpnuke'),
		'id' => 'home_piecemaker_id',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Video Embed Code', 'wpnuke'),
		'desc' => __('Insert your YouTube or other video embed code here, best viewed at 560px wide. Leave it blank if you are using another slider.', 'wpnuke'),
		'id' => 'home_video_embed_code',
		'std' => '',
		'type' => 'textarea');
	
	$options[] = array(
		'name' => __('Video Title', 'wpnuke'),
		'desc' => __('Insert your video title here. Leave it blank if you are using another slider.', 'wpnuke'),
		'id' => 'home_video_title',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Content Under Video Title', 'wpnuke'),
		'desc' => __('Type your content here, you can use shortcode here. Leave it blank if you are using another slider.', 'wpnuke'),
		'id' => 'home_video_content',
		'std' => '',
		'type' => 'textarea');
	
	$options[] = array(
		'name' => __('Homepage Teaser Text', 'wpnuke'),
		'desc' => __('Type your homepage teaser text here, leave it blank if you want to disable teaser text on the homepage.', 'wpnuke'),
		'id' => 'home_teaser',
		'std' => 'Welcome to Concorde, a Professional WordPress Themes',
		'type' => 'textarea');
	
	$options[] = array(
		'name' => __('Homepage Teaser Text Subheading', 'wpnuke'),
		'desc' => __('Type your homepage teaser text subheading here, leave it blank to disable it.', 'wpnuke'),
		'id' => 'home_teaser_sub',
		'std' => '',
		'type' => 'textarea');
	
	$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array( 'plugins' => 'wordpress' )
	);
	
	$options[] = array(
		'name' => __('Homepage Custom Content', 'wpnuke'),
		'desc' => __( 'Type your custom content here, this content will appear under the teaser text. Leave it blank to disable it.', 'wpnuke' ),
		'id' => 'home_custom_content',
		'type' => 'editor',
		'settings' => $wp_editor_settings );
	
	$options[] = array(
		'name' => __('Homepage Sidebar', 'wpnuke'),
		'desc' => __('Choose your sidebar position or disable it.', 'wpnuke'),
		'id' => 'home_sidebar',
		'std' => 'right',
		'type' => 'select',
		'options' => array('right' => 'Right Sidebar','left' => 'Left Sidebar','no_sidebar' => 'Disable Sidebar'));
	
	$options[] = array(
		'name' => __('Enable Latest Blog Posts', 'wpnuke'),
		'desc' => __('Check if you want to enable latest blog posts on the homepage.', 'wpnuke'),
		'id' => 'home_blog_post',
		'std' => '1',
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => __('Latest Blog Posts Title', 'wpnuke'),
		'desc' => __('Type the title of latest blog posts you wish to display.', 'wpnuke'),
		'id' => 'blog_post_title',
		'std' => 'Latest News',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Number of Blog Entries', 'wpnuke'),
		'desc' => __('Enter the number of blog entries you wish to display.', 'wpnuke'),
		'id' => 'blog_post_num',
		'std' => '3',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Enable Gallery', 'wpnuke'),
		'desc' => __("Check if you want to enable latest gallery on the homepage. Add gallery posts using the 'Gallery' custom post type.", 'wpnuke'),
		'id' => 'home_gallery',
		'std' => '1',
		'type' => 'checkbox');
	
	$options[] = array(
		'name' => __('Gallery Title', 'wpnuke'),
		'desc' => __('Type the title of latest gallery you wish to display.', 'wpnuke'),
		'id' => 'gallery_title',
		'std' => 'Latest Projects',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Number of Gallery Posts', 'wpnuke'),
		'desc' => __('Enter the number of gallery posts you wish to display.', 'wpnuke'),
		'id' => 'gallery_num',
		'std' => '4',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Slider', 'wpnuke'),
		'type' => 'heading');
	
	$options[] = array(
		'name' => __('Nivo Slider Options', 'wpnuke'),
		'type' => 'info');
	
	$options[] = array(
		'name' => __('Animation Effect', 'wpnuke'),
		'desc' => __('Select the slider animation effect.', 'wpnuke'),
		'id' => 'nivo_slide_effect',
		'std' => 'random',
		'type' => 'select',
		'options' => $nivo_slide_effect);
	
	$options[] = array(
		'name' => __('Number of Slides', 'wpnuke'),
		'desc' => __('Enter the number of slides you want to display.', 'wpnuke'),
		'id' => 'nivo_slide_number',
		'std' => '5',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Animation Speed', 'wpnuke'),
		'desc' => __('The time in miliseconds the animation between frames will take.', 'wpnuke'),
		'id' => 'nivo_slide_anim_speed',
		'std' => '800',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Slide Interval', 'wpnuke'),
		'desc' => __('The time in milliseconds each slide pauses for, before sliding to the next.', 'wpnuke'),
		'id' => 'nivo_slide_interval',
		'std' => '5000',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Pause on Hover', 'wpnuke'),
		'desc' => __('Stop animation while hovering slide.', 'wpnuke'),
		'id' => 'nivo_slide_pause_hover',
		'std' => 'true',
		'type' => 'select',
		'options' => array('true' => 'Yes','false' => 'No'));
	
	$options[] = array(
		'name' => __('Keyboard Navigation', 'wpnuke'),
		'desc' => __('Use keyboard left & right arrows to control slider.', 'wpnuke'),
		'id' => 'nivo_slide_keyboard',
		'std' => 'true',
		'type' => 'select',
		'options' => array('true' => 'Yes','false' => 'No'));
	
	$options[] = array(
		'name' => __('Next/Previous Buttons', 'wpnuke'),
		'desc' => __('Display next/previous buttons while hovering slide.', 'wpnuke'),
		'id' => 'nivo_slide_next_prev',
		'std' => 'true',
		'type' => 'select',
		'options' => array('true' => 'Yes','false' => 'No'));
	
	$options[] = array(
		'name' => __('Accordion Slider Options', 'wpnuke'),
		'type' => 'info');
	
	$options[] = array(
		'name' => __('Number of Slides', 'wpnuke'),
		'desc' => __('Enter the number of slides you want to display.', 'wpnuke'),
		'id' => 'accordion_slide_number',
		'std' => '5',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Autoplay', 'wpnuke'),
		'desc' => __('Slider play automatically.', 'wpnuke'),
		'id' => 'accordion_autoplay',
		'std' => 'false',
		'type' => 'select',
		'options' => array('true' => 'Yes','false' => 'No'));
	
	$options[] = array(
		'name' => __('Pause on Hover', 'wpnuke'),
		'desc' => __('If autoplay is enabled, the slider will pause while hovering slide.', 'wpnuke'),
		'id' => 'accordion_pause_on_hover',
		'std' => 'true',
		'type' => 'select',
		'options' => array('true' => 'Yes','false' => 'No'));
	
	$options[] = array(
		'name' => __('Slide Interval', 'wpnuke'),
		'desc' => __('How long between slide transitions in autoplay mode.', 'wpnuke'),
		'id' => 'accordion_slide_interval',
		'std' => '3000',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Animation Time', 'wpnuke'),
		'desc' => __('How long the slide transition takes.', 'wpnuke'),
		'id' => 'accordion_animation_time',
		'std' => '800',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Expanded Width', 'wpnuke'),
		'desc' => __('Width of the expanded slide (in pixels).', 'wpnuke'),
		'id' => 'accordion_expanded_width',
		'std' => '600',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Typography', 'wpnuke'),
		'type' => 'heading');
	
	$options[] = array(
		'name' => __('Enable Custom Typography', 'wpnuke'),
		'desc' => __('Check to enable the use of custom typography for your site.', 'wpnuke'),
		'id' => 'custom_typo',
		'std' => '0',
		'type' => 'checkbox');
	
	$options[] = array( 'name' => __('General Typography', 'wpnuke'),
		'desc' => __('General Typography', 'wpnuke'),
		'id' => "body_typo",
		'std' => array('size' => '14px','face' => 'arial','style' => 'normal','color' => '#666666'),
		'type' => 'typography' );
	
	$options[] = array(
		'name' => __('General Heading Font', 'wpnuke'),
		'desc' => __('Font setting for general heading.', 'wpnuke'),
		'id' => 'head_typo',
		'std' => 'Titillium Text Light',
		'type' => 'select',
		'options' => $heading_font);
	
	$options[] = array( 'name' => __('Link', 'wpnuke'),
		'desc' => __('Setting for general link font.', 'wpnuke'),
		'id' => "link_typo",
		'std' => array('size' => '14px','face' => 'arial','style' => 'normal','color' => '#111111'),
		'type' => 'typography' );
	
	$options[] = array( 'name' => __('Link Hover', 'wpnuke'),
		'desc' => __('Setting for general link font when mouse over the link.', 'wpnuke'),
		'id' => "link_typo_hover",
		'std' => array('size' => '14px','face' => 'arial','style' => 'normal','color' => '#777777'),
		'type' => 'typography' );
	
	$options[] = array( 'name' => __('Post Title', 'wpnuke'),
		'desc' => __('Setting for post title font.', 'wpnuke'),
		'id' => "post_title_typo",
		'std' => array('size' => '28px','face' => 'Titillium Text Light','style' => 'normal','color' => ''),
		'type' => 'typography' );
	
	$options[] = array( 'name' => __('Post Title Hover', 'wpnuke'),
		'desc' => __('Setting post title font when mouse over the link.', 'wpnuke'),
		'id' => "post_title_typo_hover",
		'std' => array('size' => '28px','face' => 'Titillium Text Light','style' => 'normal','color' => ''),
		'type' => 'typography' );
	
	$options[] = array( 'name' => __('Teaser Text Heading', 'wpnuke'),
		'desc' => __('Setting for teaser text heading font.', 'wpnuke'),
		'id' => "teaser_head_typo",
		'std' => array('size' => '30px','face' => 'Titillium Text Light','style' => 'normal','color' => '#333333'),
		'type' => 'typography' );
	
	$options[] = array( 'name' => __('Teaser Text Subheading', 'wpnuke'),
		'desc' => __('Setting for teaser text subheading font.', 'wpnuke'),
		'id' => "teaser_subhead_typo",
		'std' => array('size' => '22px','face' => 'Titillium Text Light','style' => 'italic','color' => '#555555'),
		'type' => 'typography' );


	/** Job Settings **/
	
	$options[] = array(
		'name' => __('Job Settings', 'wpnuke'),
		'type' => 'heading'
	);
	
	$options['prune_expired'] = array(
		'name' => __('Prune Expired Jobs?', 'wpnuke'),
		'desc' => __('A Wordpress cron job runs once a day or depending on your Prune Interval setting and automatically removes all expired jobs from your site (does not delete them, just changes the post status to your selected <em>new job status</em>). If no one is selected, the job will remain live on your site, marked as expired, and moved under the expired status.', 'wpnuke'),
		'id' => 'prune_expired',
		'std' => 'no',
		'type' => 'radio',
		'options' => array('no' => 'No', 'yes' => 'Yes')
	);
	
	$options['prune_status'] = array(
		'name' => __('New Job Status', 'wpnuke'),
		'desc' => __('If you choose to prune expired job it is required to assign the job with new status. If no one is selected, the job will be marked as expired.', 'wpnuke'),
		'id' => 'prune_status',
		'std' => 'none',
		'type' => 'select',
		'options' => array('none' => '--- Choose ---', 'expired' => 'Expired', 'draft' => 'Draft', 'trash' => 'Trash')
	);
	
	$options['prune_interval'] = array(
		'name' => __('Prune Interval', 'wpnuke'),
		'desc' => __('Select Interval in seconds used by Wordpress cron to prune the expired job.', 'wpnuke'),
		'id' => 'prune_interval',
		'std' => 'daily',
		'type' => 'select',
		'options' => array('none' => '--- Choose ---', 'hourly' => 'Once Hourly', 'twicedaily' => 'Twice Daily', 'daily' => 'Once Daily', 'weekly' => 'Once Weekly', 'monthly' => 'Once Monthly', 'custom' => 'Custom Interval')
	);
	
	$options['prune_interval_value'] = array(
		'name' => __('Prune Custom Interval Value', 'wpnuke'),
		'desc' => __('If you choose custom prune interval, you must specify the interval value in seconds used by Wordpress cron to prune the expired job.', 'wpnuke'),
		'id' => 'prune_interval_value',
		'std' => 86400,
		'type' => 'text'
	);
	
	$options['cron'] = array(
		'name' => __('Run Cron Using?', 'wpnuke'),
		'desc' => __('WordPress comes with a built in automation function called wp_cron. But this cron is not perfect and may cause a performance issue, you can replace it with a real CRON job to solve the issue.', 'wpnuke'),
		'id' => 'cron',
		'std' => 'server',
		'type' => 'radio',
		'options' => array('server' => 'Server Cron (recommended)', 'wordpress' => 'Wordpress Cron')
	);
	
	$options['prune_notification'] = array(
		'name' => __('Prune Email Notification', 'wpnuke'),
		'desc' => __('Yes! Notify admin site and job provider when their job expired and has been pruned successfully.', 'wpnuke'),
		'id' => 'prune_notification',
		'std' => '1',
		'type' => 'checkbox'
	);

	/** Mail Settings **/
	
	$options[] = array(
		'name' => __('Email Settings', 'wpnuke'),
		'type' => 'heading'
	);
	
	$options['enable_notification'] = array(
		'name' => __('Enable Email Notification?', 'wpnuke'),
		'desc' => __('Check to enable email notification.', 'wpnuke'),
		'id' => 'enable_notification',
		'std' => '1',
		'type' => 'checkbox'
	);
	
	$options['mailer'] = array(
		'name' => __('Email Sender', 'wpnuke'),
		'desc' => __('By default, WP Nuke use Wordpress mailer to send email notification. Otherwise you can choose to use your own SMTP server instead.', 'wpnuke'),
		'id' => 'mailer',
		'std' => 'wpmailer',
		'type' => 'radio',
		'options' => array('wpmailer' => 'PHP Mailer', 'smtp' => 'SMTP Mailer')
	);

	$options[] = array(
		'name' => __('SMTP Mailer Settings', 'wpnuke'),
		'type' => 'subheading'
	);
	
	$options['smtp_mail_from'] = array(
		'name' => __('SMTP Sender Email', 'wpnuke'),
		'desc' => __('Enter your email address for SMTP default email sender address (Ex. <em>yourname@domain.com</em>).', 'wpnuke'),
		'id' => 'smtp_mail_from',
		'std' => '',
		'type' => 'text'
	);
	
	$options['smtp_mail_from_name'] = array(
		'name' => __('SMTP Sender Name', 'wpnuke'),
		'desc' => __('Enter your real name for SMTP default email sender name (Ex. <em>Your Company</em>).', 'wpnuke'),
		'id' => 'smtp_mail_from_name',
		'std' => '',
		'type' => 'text'
	);
	
	$options['smtp_host'] = array(
		'name' => __('SMTP Server Hostname', 'wpnuke'),
		'desc' => __('Enter your SMTP server hostname.', 'wpnuke'),
		'id' => 'smtp_host',
		'std' => '',
		'type' => 'text'
	);
	
	$options['smtp_port'] = array(
		'name' => __('SMTP Server Port', 'wpnuke'),
		'desc' => __('Enter your SMTP server port.', 'wpnuke'),
		'id' => 'smtp_port',
		'std' => '25',
		'type' => 'text'
	);
	
	$options['smtp_auth'] = array(
		'name' => __('SMTP Authentication?', 'wpnuke'),
		'desc' => __('Some public SMTP server such as GMail require an authentication to log in.', 'wpnuke'),
		'id' => 'smtp_auth',
		'std' => 'true',
		'type' => 'radio',
		'options' => array('true' => 'Yes', 'false' => 'No')
	);
	
	$options['smtp_username'] = array(
		'name' => __('SMTP Username', 'wpnuke'),
		'desc' => __('Enter your SMTP authentication username.', 'wpnuke'),
		'id' => 'smtp_username',
		'std' => '',
		'type' => 'text'
	);
	
	$options['smtp_password'] = array(
		'name' => __('SMTP Password', 'wpnuke'),
		'desc' => __('Enter your SMTP authentication password.', 'wpnuke'),
		'id' => 'smtp_password',
		'std' => '',
		'type' => 'password'
	);
	
	$options['smtp_secure'] = array(
		'name' => __('SMTP Secure Connection', 'wpnuke'),
		'desc' => __('Select SSL/TLS if secure connection required. Some public SMTP server such as GMail requires secure connection to be enabled.', 'wpnuke'),
		'id' => 'smtp_secure',
		'std' => 'none',
		'type' => 'radio',
		'options' => array('none' => 'None', 'ssl' => 'SSL', 'tls' => 'TLS')
	);
	
	$options['smtp_set_return_path'] = array(
		'name' => __('SMTP Set Return Path', 'wpnuke'),
		'desc' => __('Enable the sender (return-path).', 'wpnuke'),
		'id' => 'smtp_set_return_path',
		'std' => '0',
		'type' => 'checkbox'
	);
	
	$options[] = array(
		'name' => __('User Registration Notification Email', 'wpnuke'),
		'type' => 'subheading'
	);
	
	$options['register_email_subject'] = array(
		'name' => __('Registration Email Subject', 'wpnuke'),
		'desc' => __('Enter your email subject for new user registration notification.', 'wpnuke'),
		'id' => 'register_email_subject',
		'std' => __('Registration Details for - ', 'wpnuke') . '%site_name%',
		'type' => 'text'
	);
	
	$register_email_content = "<p>" . __('Dear', 'wpnuke') . " %user_name%, <br /><br /></p>\r\n" .
		"<p>" . sprintf(__('We have received your registration for %s. You can log in with the following information:', 'wpnuke'), '%site_name%') . "</p>\r\n" .
		"<ul>\r\n" .
		"<li>" . __('Username', 'wpnuke') . " : %user_login%</li>\r\n" .
		"<li>" . __('Password', 'wpnuke') . " : %user_password%</li>\r\n" .
		"</ul>\r\n" .
		"<p>" . sprintf(__('You can login from : %s', 'wpnuke'), '%site_login_url%') . "</p>\r\n" .
		"<p><br />Thank You.<br /><a href=\"%site_url%\">%site_name%</a></p>";
	
	$options['register_email_content'] = array(
		'name' => __('Registration Email Content', 'wpnuke'),
		'desc' => __('Enter your email content for new user registration notification.', 'wpnuke'),
		'id' => 'register_email_content',
		'std' => $register_email_content,
		'type' => 'editor',
		'settings' => array('textarea_rows' => 5, 'tinymce' => array('plugins' => 'wordpress'))
	);
	
	$options[] = array(
		'name' => __('Job Apply Notification Email', 'wpnuke'),
		'type' => 'subheading'
	);
	
	$options['apply_email_subject'] = array(
		'name' => __('Job Apply Email Subject', 'wpnuke'),
		'desc' => __('Enter your email subject for job apply notification.', 'wpnuke'),
		'id' => 'apply_email_subject',
		'std' => __('New application for - ', 'wpnuke') . '%post_title%',
		'type' => 'text'
	);
	
	$apply_email_content = "<p>" . __('Dear', 'wpnuke') . " %company_name%, <br /><br /></p>\r\n" .
		"<p><strong>" . __('There is a new online application for the job post - ', 'wpnuke') . "<a href=\"%post_link%\" target=\"_blank\">%post_title%</a></strong></p>\r\n" .
		"<ul>\r\n" .
		"<li>" . __('Applicant Name', 'wpnuke') . " : %user_name%</li>\r\n" .
		"<li>" . __('Applicant Email', 'wpnuke') . " : %user_email%</li>\r\n" .
		"<li>" . __('Description', 'wpnuke') . " : %user_comments%</li>\r\n" .
		"<li>" . __('Attached Resume/CV files', 'wpnuke') . " : %attachments%</li>\r\n" .
		"</ul>\r\n" .
		"<p><br />Thank You.<br /><a href=\"%site_url%\">%site_name%</a></p>";
	
	$options['apply_email_content'] = array(
		'name' => __('Job Apply Email Content', 'wpnuke'),
		'desc' => __('Enter your email content for job apply notification.', 'wpnuke'),
		'id' => 'apply_email_content',
		'std' => $apply_email_content,
		'type' => 'editor',
		'settings' => array('textarea_rows' => 5, 'tinymce' => array('plugins' => 'wordpress'))
	);
	
	$options[] = array(
		'name' => __('Job Apply Removal Notification Email', 'wpnuke'),
		'type' => 'subheading'
	);
	
	$options['removal_email_subject'] = array(
		'name' => __('Job Application Removal Email Subject', 'wpnuke'),
		'desc' => __('Enter your email subject for job apply notification.', 'wpnuke'),
		'id' => 'removal_email_subject',
		'std' => __('Application removal for - ', 'wpnuke') . '%post_title%',
		'type' => 'text'
	);
	
	$removal_email_content = "<p>" . __('Dear', 'wpnuke') . " %company_name%, <br /><br /></p>\r\n" .
		"<p><strong>%user_name% " . __('removed application for the job post -', 'wpnuke') . " <a href=\"%post_link%\" target=\"_blank\">%post_title%</a></strong></p>\r\n" .
		"<ul>\r\n" .
		"<li>" . __('Applicant Name', 'wpnuke') . " : %user_name%</li>\r\n" .
		"<li>" . __('Applicant Email', 'wpnuke') . " : %user_email%</li>\r\n" .
		"</ul>\r\n" .
		"<p><br />Thank You.<br /><a href=\"%site_url%\">%site_name%</a></p>";
	
	$options['removal_email_content'] = array(
		'name' => __('Job Application Removal Email Content', 'wpnuke'),
		'desc' => __('Enter your email content for job apply notification.', 'wpnuke'),
		'id' => 'removal_email_content',
		'std' => $removal_email_content,
		'type' => 'editor',
		'settings' => array('textarea_rows' => 5, 'tinymce' => array('plugins' => 'wordpress'))
	);
	
	return $options;
}
/*
 * This is an example of how to add custom scripts to the options panel.
 * This example shows/hides an option when a checkbox is clicked.
 */
function optionsframework_custom_scripts() { ?>
<script type="text/javascript">
jQuery(document).ready(function($) {
	$('#example_showhidden').click(function() {
  		$('#section-example_text_hidden').fadeToggle(400);
	});
	if ($('#example_showhidden:checked').val() !== undefined) {
		$('#section-example_text_hidden').show();
	}
});
</script>
<?php
}
add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

// Override a default filter for 'textarea' sanitization
function optionscheck_change_sanitization() {
	remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
	add_filter( 'of_sanitize_textarea', 'of_sanitize_textarea_custom' );
}
add_action('admin_init','optionscheck_change_sanitization', 100);

function of_sanitize_textarea_custom($input) {
	global $allowedtags;
	$of_custom_allowedtags["embed"] = array(
		"src" => array(),
		"type" => array(),
		"allowfullscreen" => array(),
		"allowscriptaccess" => array(),
		"height" => array(),
		"width" => array()
	);
	$of_custom_allowedtags["iframe"] = array(
		"src" => array(),
		"type" => array(),
		"allowfullscreen" => array(),
		"allowscriptaccess" => array(),
		"frameborder" => array(),
		"height" => array(),
		"width" => array()
	);
	$of_custom_allowedtags["script"] = array(
		"src" => array(),
		"type" => array(),
	);
	$of_custom_allowedtags = array_merge($of_custom_allowedtags, $allowedtags);
	$output = wp_kses( $input, $of_custom_allowedtags);
	return $output;
}

?>