<?php
///=============HEADER SETTINGS========================================/////

/************************************
//FUNCTION NAME : templ_footer_settings
//ARGUMENTS : None
//RETURNS : Footer scripts desing option content
***************************************/
add_action('wp_footer','templ_footer_settings');
function templ_footer_settings()
{
	echo stripslashes(get_option('ptthemes_scripts_footer'));
}

/************************************
//FUNCTION NAME : templ_header_settings
//ARGUMENTS : None
//RETURNS : Site Header inside <head>...</head> settings
***************************************/

function templ_head_css_settings()
{
	$stylesheet = get_option('ptthemes_alt_stylesheet');
	if($stylesheet != '')
	{
	?>
	<link href="<?php bloginfo('template_directory'); ?>/skins/<?php echo $stylesheet; ?>.css" rel="stylesheet" type="text/css" />
	<?php }
	include(TT_ADMIN_FOLDER_PATH.'functions/add_style.php');
	
	if(strtolower(get_option('ptthemes_customcss'))=='activate')
	{
	?>
		<link href="<?php bloginfo('template_directory'); ?>/custom.css" rel="stylesheet" type="text/css" />
	<?php
	}
}
add_action('templ_head_js','templ_head_js_settings');

add_action('templ_head_css','templ_head_css_settings');
function templ_head_js_settings()
{
	echo stripslashes(get_option('ptthemes_scripts_header'));
}


add_action('templ_head_meta','templ_header_settings');
function templ_header_settings()
{
	if(get_option('ptthemes_favicon'))
	{
	?>
    <link rel="shortcut icon" type="image/png" href="<?php echo get_option('ptthemes_favicon'); ?>" />
    <?php	
	}
	if(get_option('ptthemes_feedburner_url'))
	{
		if (apply_filters('templ_facebook_button_script', true))
		{
	?>
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php echo get_option('ptthemes_feedburner_url'); ?>" />
    <?php
		}
	}
	templ_seo_meta();
}

///=============Page Title Above ========================================/////
function templ_page_title_above()
{
	do_action('templ_page_title_above');	
}

///=============Page Title Below ========================================/////
function templ_page_title_below()
{
	do_action('templ_page_title_below');	
}

///=============SITE LOGO SETTINGS========================================/////
function templ_site_logo()
{
	do_action('templ_site_logo');
}

///=============TWITTER BUTTON========================================/////
function templ_show_twitter_button()
{
	do_action('templ_show_twitter_button');	
}

///=============FACEBOOK BUTTON========================================/////
function templ_show_facebook_button()
{
	do_action('templ_show_facebook_button');	
}


///=============TOP HEADER NAVIGATION========================================/////
function templ_get_top_header_navigation()
{
	do_action('templ_get_top_header_navigation');	
}


///=============MAIN HEADER NAVIGATION========================================/////
function templ_get_main_header_navigation()
{
	do_action('templ_get_main_header_navigation');	
}

///=============EXCERPT LENGTH SETTING FILTER========================================/////
function templ_excerpt_length($length) {
	return 200;
}
add_filter('excerpt_length', 'templ_excerpt_length');

///=============SEO META TAGS========================================/////
function templ_seo_meta()
{
	do_action('templ_seo_meta');	
}



/************************************
Layout Hooks 
***************************************/
///=============HEADER HOOK========================================/////
function templ_wp_head()
{
	do_action('templ_wp_head');	
}

///=============BODY START HOOK========================================/////
function templ_body_start()
{
	do_action('templ_body_start');	
}

///=============BODY END HOOK========================================/////
function templ_body_end()
{
	do_action('templ_body_end');	
}
///=============HEADER START HOOK========================================/////
function templ_header_start()
{
	do_action('templ_header_start');	
}

///=============HEADER END HOOK========================================/////
function templ_header_end()
{
	do_action('templ_header_end');	
}
///=============CONTENT START HOOK========================================/////
function templ_content_start()
{
	do_action('templ_content_start');	
}

///=============CONTENT END HOOK========================================/////
function templ_content_end()
{
	do_action('templ_content_end');	
}
///=============BEFORE SINGLE ENTRY HOOK========================================/////
function templ_before_single_entry()
{
	do_action('templ_before_single_entry');	
}

///=============AFTER SINGLE ENTRY HOOK========================================/////
function templ_after_single_entry()
{
	do_action('templ_after_single_entry');	
}
///=============BEFORE SINGLE POST CONTENT HOOK========================================/////
function templ_before_single_post_content()
{
	do_action('templ_before_single_post_content');	
}

///=============AFTER SINGLE POST CONTENT HOOK========================================/////
function templ_after_single_post_content()
{
	do_action('templ_after_single_post_content');	
}
///=============BEFORE LOOP HOOK========================================/////
function templ_before_loop()
{
	do_action('templ_before_loop');	
}

///=============AFTER LOOP HOOK========================================/////
function templ_after_loop()
{
	do_action('templ_after_loop');	
}
///=============BEFORE LOOP POST CONTENT HOOK========================================/////
function templ_before_loop_post_content()
{
	do_action('templ_before_loop_post_content');	
}

///=============AFTER LOOP POST CONTENT HOOK========================================/////
function templ_after_loop_post_content()
{
	do_action('templ_after_loop_post_content');	
}
///=============BEFORE SIDEBAR HOOK========================================/////
function templ_before_sidebar()
{
	do_action('templ_before_sidebar');	
}

///=============AFTER SIDEBAR HOOK========================================/////
function templ_after_sidebar()
{
	do_action('templ_after_sidebar');	
}
///=============BEFORE FOOTER HOOK========================================/////
function templ_before_footer()
{
	do_action('templ_before_footer');	
}

///=============AFTER FOOTER HOOK========================================/////
function templ_after_footer()
{
	do_action('templ_after_footer');	
}



/************************************
//FUNCTION NAME : templ_get_listing_content
//ARGUMENTS :NONE
//RETURNS : display content or excerpt or sub part of it.
***************************************/
function templ_get_listing_content()
{
	do_action('templ_get_listing_content');	
}

/************************************
//FUNCTION NAME : templ_comments_link_attributes
//ARGUMENTS : NONE
//RETURNS : Comment link class added via filter
***************************************/
function templ_comments_link_attributes(){
    return ' class="comments_popup_link" ';
}
add_filter('comments_popup_link_attributes', 'templ_comments_link_attributes');

/************************************
//FUNCTION NAME : templ_next_posts_attributes
//ARGUMENTS : NONE
//RETURNS : Post link class added via filter
***************************************/
function templ_next_posts_attributes(){
    return ' class="nextpostslink" ';
}
add_filter('next_posts_link_attributes', 'templ_next_posts_attributes');


function templ_previous_posts_attributes(){
    return ' class="previouspostslink" ';
}
add_filter('previous_posts_link_attributes', 'templ_previous_posts_attributes');



/************************************
//FUNCTION NAME : templ_get_top_header_navigation_above
//ARGUMENTS : NONE
//RETURNS : Top header navigation above content hook
***************************************/
function templ_get_top_header_navigation_above()
{
	do_action('templ_get_top_header_navigation_above');	
}

/************************************
//FUNCTION NAME : templ_add_template_page_hook
//ARGUMENTS : NONE
//RETURNS : add New pages via this action hook
***************************************/
function templ_add_template_page_hook()
{
	do_action('templ_add_template_page_hook');
}
/************************************
//FUNCTION NAME : templ_set_listing_post_per_page
//ARGUMENTS : None
//RETURNS : Set the filete for the post per page for listing page
***************************************/
function templ_post_limits_listing_page() {
	global $posts_per_page;
	if ( is_home() || is_search()  || is_archive())
	{
		if(is_home())
		{
			if(isset($_REQUEST['per_pg']) && $_REQUEST['per_pg'] !='')
			{
				$rtr = $_REQUEST['per_pg'];
			}elseif(get_option('ptthemes_home_page')>0)
			{
				$rtr = get_option('ptthemes_home_page');
			}else
			{
				$rtr =  10;	
			}				
		}
		if ( is_archive())
		{
			if($_REQUEST['per_pg'])
			{
				$rtr = $_REQUEST['per_pg'];
			}elseif(get_option('ptthemes_cat_page')>0)
			{
				$rtr = get_option('ptthemes_cat_page');
			}elseif($posts_per_page)
			{
				$rtr =  $posts_per_page;
			}else
			{
				$rtr =  10;	
			}
			
		}
		if ( is_search())
		{
			
			if($_REQUEST['per_pg'])
			{
				$rtr = $_REQUEST['per_pg'];
			}elseif(get_option('ptthemes_search_page')>0)
			{
				$rtr = get_option('ptthemes_search_page');
			}elseif($posts_per_page)
			{
				$rtr =  $posts_per_page;
			}else
			{
				$rtr =  10;	
			}
			
		}
		return $rtr;
	}
	if ( is_category() || is_month() || is_year() || is_tag() || is_date())
	{
		if($_REQUEST['per_pg'])
		{
			$rtr = $_REQUEST['per_pg'];
		}elseif($posts_per_page)
		{
			$rtr =  $posts_per_page;
		}else
		{
			$rtr =  10;	
		}
		return $rtr;
	}
}
//add_filter('pre_option_posts_per_page', 'templ_post_limits_listing_page');

/************************************
//FUNCTION NAME : templ_page_title_filter
//ARGUMENTS : title,starting tag,ending tag
//RETURNS : filtered contnet
***************************************/
function templ_page_title_filter($title,$st='',$end='')
{
	return apply_filters('templ_page_title_filter',$st.$title.$end);
}

?>
