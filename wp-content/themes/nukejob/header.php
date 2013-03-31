<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" <?php language_attributes(); ?>><!--<![endif]-->
<head>
	<title><?php wp_title('- ',true,'right'); bloginfo('name'); echo ($paged > 1)? " - Page $paged":"";?></title>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/styles/normalize.css" type="text/css" />
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/style.css" type="text/css" />
	<script src="<?php bloginfo('template_directory'); ?>/js/modernizr-2.6.1.min.js"></script>
	<script src="<?php bloginfo('template_directory'); ?>/js/jquery.min.js"></script>
<?php
	// Load styles and scripts for homepage only
	if ( is_home() ) :
?>
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/styles/flexslider.css" type="text/css" />
	<script src="<?php bloginfo('template_directory'); ?>/js/jquery.flexslider-min.js"></script>
	<script type="text/javascript">
		jQuery(window).load(function(){
			jQuery('.flexslider').flexslider({
				animation: "fade",
				start: function(slider){
					jQuery('body').removeClass('loading');
				}
			});
			/* prepend menu icon */
			jQuery('.main-nav').prepend('<div class="icon-nav-btn"><span class="icon-nav"></span></div>');
			
			/* toggle nav */
			jQuery(".icon-nav-btn").on("click", function(){
				jQuery(".menu").slideToggle();
				jQuery(this).toggleClass("active");
			});
		});
	</script>
<?php
	endif;
?>
<?php
	// Load styles and scripts for job details only
	if ( is_single() ) :
?>
	<script type="text/javascript">
		$(window).load(function(){
			/* prepend menu icon */
			jQuery('.main-nav').prepend('<div class="icon-nav-btn"><span class="icon-nav"></span></div>');
			
			/* toggle nav */
			jQuery(".icon-nav-btn").on("click", function(){
				jQuery(".menu").slideToggle();
				jQuery(this).toggleClass("active");
			});
		});
	</script>
<?php
	endif;
?>
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
	<!--[if lt IE 7]>
	<p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
	<![endif]-->
	<div id="main-wrapper">
		<header id="header" role="banner">
			<div class="inner clearfix">
			<?php $html_tag = is_home() ? 'h1' : 'span'; ?>
				<div class="logo">
					<<?php echo $html_tag; ?>><a href="<?php bloginfo('url'); ?>"><img src="<?php if (wpnuke_get_option('logo')) { echo wpnuke_get_option('logo'); } else { ?><?php bloginfo('template_directory'); ?>/images/logo.png <?php } ?>" alt="<?php echo get_bloginfo('name') . ' - ' . get_bloginfo('description'); ?>" /></a></<?php echo $html_tag; ?>>
				</div><!--logo-->
				<nav class="main-nav">
					<ul id="nav" class="menu">
						<li><a class="active" href="<?php bloginfo('url'); ?>">Home</a></li>
						<?php
						/** Job/Resume Menu Link **/
						global $current_user, $jobresume_link;

						// getting user information
						$current_user = wp_get_current_user();
						
						// add post a job/resume button link
						$jobresume_link = wpnuke_submit_job_button(&$current_user);
						if($jobresume_link) {
							echo '<li><a href="' . $jobresume_link['url'] . '">' . $jobresume_link['anchor'] . '</a></li>';
						}
						?>
						<li><a href="page.html">About</a></li>
						<li><a href="blog.html">Blog</a></li>
						<li><a href="#">Contact</a></li>
						<?php
						if ( is_user_logged_in() ) {
							echo '<li><a href="' . wp_logout_url('index.php') . '" title="Logout">Logout</a></li>';
						}
						?>
					</ul>
				</nav><!--main-nav-->
			</div><!--inner-->
		</header>