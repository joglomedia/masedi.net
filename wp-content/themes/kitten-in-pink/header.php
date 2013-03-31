<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>
<?php
if (is_home()) {
	echo bloginfo('name'); echo ": "; echo bloginfo('description');
} elseif (is_404()) {
	echo '404 Not Found';
} elseif (is_category()) {
	echo 'Topics:'; wp_title('');
} elseif (is_search()) {
	echo 'Search Results';
} elseif (is_day() || is_month() || is_year() ) {
	echo 'Archives:'; wp_title('');
} else {
	echo wp_title('');
	$subtitle = get_post_meta($post->ID, 'Subtitle', $single = true);
	if($subtitle !== '') { echo ': ' . $subtitle; }
} ?>
</title></title>

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />	
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" /> <!-- leave this for stats please -->
 <!-- Framework CSS -->
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/screen.css" type="text/css" media="screen, projection" />
	
  <!--[if IE]><link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/ie.css" type="text/css" media="screen, projection" /><![endif]-->

	
	<!-- Import fancy-type plugin for the sample page. -->
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/plugins/fancy-type/screen.css" type="text/css" media="screen, projection" />

	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />     
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	


	<?php wp_get_archives('type=monthly&format=link'); ?>
	<?php //comments_popup_script(); // off by default ?>
	<?php wp_head(); ?>
</head>
<body>
	
	<div id="wrapper" class="container"> 
		
	
	
	
	<div id="header" class="span-24  last">
		 <div id="header-menu" class="span-15">
		 	<ul>
       <li class="<?php if (is_home()) { echo "current_page_item"; } ?>"><a href="<?php echo get_settings('home'); ?>">Home</a></li>		
		<?php wp_list_pages('title_li=&depth=1&exclude='); ?>

      </ul>
		 </div>
		 
		 
		 <div id="search" class="span-0  last">
		 	<form method="get" action="<?php bloginfo('home'); ?>">
        <input name="s" id="s" type="text" class="search_field" value=""/>
        <input name="search" type="image" src="<?php echo get_stylesheet_directory_uri(); ?>/images/magnifier.png" class="search_button" alt="search" />
      </form>
		 	
		 </div>
		 <div id="logo-title" class="span-15">
		 		
<h1><a  id="header_name" href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a> <a href="<?php bloginfo('rss_url'); ?>" title="Subscribe to my RSS"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/rss.gif"  border="0" alt="" ></a>	<br />	 </h1>
<p class="descrip"><?php bloginfo('description'); ?><p />
		 	
		 </div>
		 <div id="goog-ad1" class="span-18">
		 	
		 </div>
		 
		</div>