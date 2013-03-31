<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <title><?php wp_title('--',true,'right'); ?> <?php bloginfo('name');?></title>
    
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/switch.js"></script>
    
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/style.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/blue.css" type="text/css" media="screen" title="default"/>
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/pink.css" type="text/css" media="screen" title="pink"/>
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/green.css" type="text/css" media="screen" title="green"/>
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/purple.css" type="text/css" media="screen" title="purple"/>
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/red.css" type="text/css" media="screen" title="red"/>
    
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
    <?php wp_head(); ?>
</head>
<body>

<!--#wrapper:start-->
	<div id="wrapper">
    
<!--#header:start-->
    	<div id="header">
        	<h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>

<!--#navigation:start-->
            <div id="navigation">
            	<ul>
                	<li><a href="<?php echo get_option('home'); ?>/" class="<?php echo (is_home() ? 'current' : ''); ?>">Home</a></li>
                    <?php wp_list_pages('title_li='); ?>
                </ul>
            </div>
<!--#navigation:end-->
<!--#search:start-->
            <div id="search">
				<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
                <input type="text" value="<?php the_search_query(); ?>" name="s" id="s" />
                <input type="submit" id="searchsubmit" value="<?php _e('search'); ?>" />

                </form>
            </div>
<!--#search:end-->
        </div>
<!--#header:end-->