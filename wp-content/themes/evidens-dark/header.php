<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>
<meta name="generator" content="WordPress.com" /> 
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="<?php echo bloginfo('template_url'); ?>/javascript/tabs.js"></script>
<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); wp_head(); ?>
</head>
<body>

<div id="top"></div>

<!-- Start BG -->
<div id="bg">

<!-- Start Header -->
<div id="header">

<!-- Start Head -->
<div class="head">

<div class="logo">
 <?php
	if ( get_option('evidens_header') == 'logo' ) 
	{ include (TEMPLATEPATH . "/logo-img.php");	}
	else
	{ include (TEMPLATEPATH . "/logo-txt.php"); }
  ?>
</div>
 
 <div class="search">
  <h2>Search</h2>
  <form method="get" action="<?php bloginfo('url'); ?>/">
   <fieldset>
   <input type="text" value="<?php the_search_query(); ?>" name="s" />
   <input type="submit" id="searchsubmit" value="Search" />
   <!--<button type="submit">Search</button>-->
   </fieldset>
  </form>
 </div>
 
 <div class="date">
  <span class="day"><?php echo date('l'); ?></span>
  <span class="time"><?php echo date('F j, Y'); ?></span>
 </div>
 
</div>
<!-- End Head -->

<!-- Start Menu -->
<div class="menu">
 <div class="pages">
   <ul>
   <li<?php if ( is_front_page() ) echo ' class="current_page_item"'; ?>><a href="<?php echo get_option('home'); ?>/"><span>Home</span></a></li>
<?php $pages = wp_list_pages('sort_column=menu_order&title_li=&echo=0');
$pages = preg_replace('%<a ([^>]+)>%U','<a $1><span>', $pages);
$pages = str_replace('</a>','</span></a>', $pages);
echo $pages; ?>
  </ul>
<? unset($pages); ?> 
 </div>
 
<div class="feed">
 <ul>
  <li class="rss"><a href="<?php bloginfo('rss2_url'); ?>">Full Posts</a>&nbsp; | &nbsp;<a href="<?php bloginfo('comments_rss2_url'); ?>">Comments</a></li>
  <li class="email"><a href="#">By Email</a></li>
 </ul>
 </div> 
</div> 
<!-- End Menu -->

</div>
<!-- End Header -->


<div class="border"></div>

<!-- Start Container-->
<div id="container">

<!-- Start Sidebar -->
<?php if(!is_attachment()) get_sidebar(); ?>
<!-- End Sidebar -->


<!-- Start Center -->
<div id="center<?php if(is_attachment()) echo ' center-attachment'; ?>"><div id="center-wap">
