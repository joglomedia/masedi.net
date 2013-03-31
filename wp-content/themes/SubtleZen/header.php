<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php if (is_home () ) { bloginfo(‘name’); }
elseif ( is_category() ) { single_cat_title(); echo ' - ' ; bloginfo(‘name’); }
elseif (is_single() ) { single_post_title();}
elseif (is_page() ) { single_post_title();}
else { wp_title(‘’,true); } ?></title>


<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<style type="text/css" media="screen">



</style>

<?php wp_head(); ?>
</head>
<body>
<div id="page">


<div id="header">
	<div id="headerimg">
<div class="title"><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></div>
		<!--- <div class="description"><?php bloginfo('description'); ?></div> -->
	</div>
</div>


<!---start horizontal nav-->
<div id="navmenu">
<ul>
 <li><a href="<?php echo get_settings('home'); ?>">HOME</a></li>
<?php list_cats(FALSE, '', 'ID',
                'asc', '', TRUE, FALSE, 
                FALSE, FALSE, TRUE, 
                FALSE, FALSE, '', FALSE, 
                '', '', '1,33', 
                TRUE); ?>
<li id="rss"><a href="<?php bloginfo('rss2_url'); ?>">Subscribe</a><li>
</ul>
</div>
<!---end horizontal nav-->


<hr />
