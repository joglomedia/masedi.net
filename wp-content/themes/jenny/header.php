<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head profile="http://gmpg.org/xfn/11">
<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<?php 
//Select a Colour Scheme stylesheet
$stylesheet = get_option('p2h_alt_stylesheet');
if($stylesheet != ''){
echo '<link href="'. get_template_directory_uri() .'/styles/'. $stylesheet .'" rel="stylesheet" type="text/css" />'."\n";         
} else{
echo '<link href="'. get_template_directory_uri() .'/styles/default.css" rel="stylesheet" type="text/css" />'."\n";         		  
} 
?>
<!--[if lt IE 8]>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/ie-fixes.css" type="text/css" media="screen" />
<![endif]-->	
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php if((is_home() && ($paged < 2 )) || is_single() || is_page()){
echo "<meta name=\"robots\" content=\"index,follow\" />";
} else {
echo "<meta name=\"robots\" content=\"noindex,follow\" />";
} ?>
<!-- Google+ Page Place this tag in the <head> of your document -->
<link href="https://plus.google.com/112106051225403096483" rel="publisher" /><script type="text/javascript">
(function() 
{var po = document.createElement("script");
po.type = "text/javascript"; po.async = true;po.src = "https://apis.google.com/js/plusone.js";
var s = document.getElementsByTagName("script")[0];
s.parentNode.insertBefore(po, s);
})();</script>
<!--Tynt-anti-copas-->
<script type="text/javascript">
if(document.location.protocol=='http:'){
 var Tynt=Tynt||[];Tynt.push('b6H-3GwZir4ATFacwqm_6l');Tynt.i={"ap":"Read more:","cc":"6","b":true};
 (function(){var s=document.createElement('script');s.async="async";s.type="text/javascript";s.src='http://tcr.tynt.com/ti.js';var h=document.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);})();
}
</script>
<?php
/* We add some JavaScript to pages with the comment form
 * to support sites with threaded comments (when in use).
 */
if ( is_singular() && get_option( 'thread_comments' ) )
wp_enqueue_script( 'comment-reply' );
/* Always have wp_head() just before the closing </head>
 * tag of your theme, or you will break many plugins, which
 * generally use this hook to add elements to <head> such
 * as styles, scripts, and meta tags.
 */
wp_head();
?>
</head>
<body>
<div id="wrapper">
	<div id="header">
		<!--Dynamic Heading-->
		<div id="masthead">
			<?php $heading_tag = ( is_home() || is_front_page() ) ? 'h1' : 'div'; ?>
			<<?php echo $heading_tag; ?> id="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></<?php echo $heading_tag; ?>>
			<div id="site-description"><?php bloginfo( 'description' ); ?></div>
		</div><!-- #masthead -->

		<div id="navigation-wrap">
		<?php wp_nav_menu( array( 'menu' => 'Header Navigation', 'container_id' => 'navigation', 'menu_class' => 'nav navbar', 'theme_location' => 'primary-menu' ,  'fallback_cb' => '') ); ?>
		<ul id="connect">	
		<li>
		<?php if (get_option('p2h_feedurl') != '') { ?>
		<a class="feedicon" href="<?php echo( (get_option('p2h_feedurl'))); ?>" title="<?php _e('Subscribe ', 'jenny'); ?><?php bloginfo('name'); ?><?php _e(' RSS Feed', 'jenny'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/feed.png" alt="<?php _e(' RSS', 'jenny'); ?>" /></a>
		<?php } else { ?>
		<a class="feedicon" href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Subscribe ', 'jenny'); ?><?php bloginfo('name'); ?><?php _e(' RSS Feed', 'jenny'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/feed.png" alt="<?php _e(' RSS', 'jenny'); ?>" /></a>
		<?php } ?>
		</li>
		
		<?php if (get_option('p2h_twitterid') != '') { ?>
		<li>
		<a class="twittericon" href="http://twitter.com/<?php echo( get_option('p2h_twitterid') );?>" title="<?php _e('Follow ', 'jenny'); ?><?php bloginfo('name'); ?><?php _e(' on Twitter', 'jenny'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/twitter.png" alt="<?php _e('Twitter', 'jenny'); ?>" /></a>
		</li>
		<?php } ?>

		<?php if (get_option('p2h_facebookid') != '') { ?>
		<li>
		<a class="facebookicon" href="<?php echo(stripslashes (get_option('p2h_facebookid')));?>" title="<?php _e('Find ', 'jenny'); ?><?php bloginfo('name'); ?><?php _e(' on Facebook', 'jenny'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/facebook.png" alt="<?php _e('Facebook', 'jenny'); ?>" /></a>
		</li>
		<?php } ?>
		</ul>

		</div><!-- #navigation-wrap -->
		<?php if (function_exists('rdfa_breadcrumb')) {
			rdfa_breadcrumb();
		}
		?>
	</div><!-- #header -->