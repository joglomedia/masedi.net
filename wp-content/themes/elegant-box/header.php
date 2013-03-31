<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	$options = get_option('elegantbox_options');
	if (is_home()) {
		$home_menu = 'current_page_item';
	} else {
		$home_menu = 'page_item';
	}
	if($options['feed'] && $options['feed_url']) {
		if (substr(strtoupper($options['feed_url']), 0, 7) == 'HTTP://') {
			$feed = $options['feed_url'];
		} else {
			$feed = 'http://' . $options['feed_url'];
		}
	} else {
		$feed = get_bloginfo('rss2_url');
	}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />

	<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
	<link rel="alternate" type="application/rss+xml" title="<?php _e('RSS 2.0 - all posts', 'elegantbox'); ?>" href="<?php echo $feed; ?>" />
	<link rel="alternate" type="application/rss+xml" title="<?php _e('RSS 2.0 - all comments', 'elegantbox'); ?>" href="<?php bloginfo('comments_rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<!-- style START -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
	<?php if (strtoupper(get_locale()) == 'ZH_CN' || strtoupper(get_locale()) == 'ZH_TW') : ?>
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/chinese.css" type="text/css" media="screen" />
	<?php endif; ?>
	<!--[if IE]>
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/ie.css" type="text/css" media="screen" />
	<![endif]-->

	<!-- default style -->
	<?php if($options['style']) : ?>
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/styles/<?php echo($options['style']); ?>/default.css" type="text/css" media="screen" title="<?php echo($options['style']); ?>" />
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/styles/<?php echo($options['style']); ?>/global.css" type="text/css" media="screen" />
	<?php else : ?>
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/styles/white/default.css" type="text/css" media="screen" title="white" />
		<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/styles/white/global.css" type="text/css" media="screen" />
	<?php endif; ?>

	<!-- others styles -->
<?php
	if($options['style_switcher']) {

		// get the styles folder listing
		$styleFolder = TEMPLATEPATH . '/styles/';
		$styleArray = array();
		$objStyleFolder = dir($styleFolder);
		while(false !== ($styleFile = $objStyleFolder->read())) {
			if(is_dir($styleFolder . $styleFile) && $styleFile != '.' &&  $styleFile != '..') {
				$styleArray[] = $styleFile;
			}
		}
		$objStyleFolder->close();

		// display other styles
		if (is_array($styleArray)) {
			foreach ($styleArray as $style) {
				if($style != $options['style']) {
?>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/styles/<?php echo($style); ?>/default.css" type="text/css" media="screen" title="<?php echo($style); ?>" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/styles/<?php echo($style); ?>/global.css" type="text/css" media="screen" />
<?php
				}
			}
		}
	}
?>
	<!-- style END -->

	<!-- javascript START -->
	<?php if ($options['style_switcher']) : ?>
		<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/styleswitcher.js"></script>
	<?php endif; ?>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/base.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/menu.js"></script>
	<!-- javascript END -->

	<?php if(is_singular()) wp_enqueue_script('comment-reply'); ?>
	<?php wp_head(); ?>
</head>

<?php flush(); ?>

<body>
	<!-- header START -->
	<div id="header">
		<div class="inner">
			<div class="content">
				<div class="caption">
					<h1 id="title"><a href="<?php echo get_settings('home'); ?>/" title="<?php bloginfo('description'); ?>"><?php bloginfo('title'); ?></a></h1>
					<div id="tagline"><?php bloginfo('description'); ?></div>
				</div>

				<!-- search box -->
				<?php if($options['google_cse'] && $options['google_cse_cx']) : ?>
					<form action="http://www.google.com/cse" id="search_box" method="get">
						<div id="searchbox">
							<input type="text" id="searchtxt" class="textfield" name="q" size="24" />
							<input type="hidden" name="cx" value="<?php echo $options['google_cse_cx']; ?>" />
							<input type="hidden" name="ie" value="UTF-8" />
						</div>
					</form>
				<?php else : ?>
					<form action="<?php bloginfo('home'); ?>/" id="search_box" method="get">
						<div id="searchbox">
							<input type="text" id="searchtxt" class="textfield" name="s" value="<?php echo wp_specialchars($s, 1); ?>" />
						</div>
					</form>
				<?php endif; ?>
<script type="text/javascript">
//<![CDATA[
	var searchbox = document.getElementById("searchbox");
	var searchtxt = document.getElementById("searchtxt");
	var tiptext = "<?php _e('Type text to search here...', 'elegantbox'); ?>";
	if(searchtxt.value == "" || searchtxt.value == tiptext) {
		searchtxt.className += " searchtip";
		searchtxt.value = tiptext;
	}
	searchtxt.onfocus = function(e) {
		if(searchtxt.value == tiptext) {
			searchtxt.value = "";
			searchtxt.className = searchtxt.className.replace(" searchtip", "");
		}
	}
	searchtxt.onblur = function(e) {
		if(searchtxt.value == "") {
			searchtxt.className += " searchtip";
			searchtxt.value = tiptext;
		}
	}
//]]>
</script>

				<!-- navigation START -->
				<ul id="navigation">

					<li class="<?php echo($home_menu); ?>"><a href="<?php echo get_settings('home'); ?>/"><?php _e('Home', 'elegantbox'); ?></a></li>
					<?php
						if($options['menu_type'] == 'categories') {
							wp_list_categories('title_li=0&orderby=name&show_count=0');
						} else {
							wp_list_pages('title_li=0&sort_column=menu_order');
						}
						if($options['twitter'] && $options['twitter_username']) { ?>
					<li>
						<a rel="external nofollow" title="<?php _e('Follow me!', 'elegantbox'); ?>" id="twitter" href="http://twitter.com/<?php echo $options['twitter_username']; ?>/"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/transparent.gif" alt="<?php _e('Twitter', 'elegantbox'); ?>" /></a>
					</li>
						<?php } ?>
					<li id="subscribe">
						<a rel="external nofollow" title="<?php _e('Subscribe to this blog...', 'elegantbox'); ?>" id="feed" href="<?php echo $feed; ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/transparent.gif" alt="<?php _e('RSS feed', 'elegantbox'); ?>" /></a>
						<?php if($options['feed_readers']) : ?>
							<ul>
								<li class="first"><a rel="external nofollow" title="<?php _e('Subscribe with ', 'elegantbox'); _e('Youdao', 'elegantbox'); ?>" href="http://reader.youdao.com/b.do?url=<?php echo $feed; ?>"> <?php _e('Youdao', 'elegantbox'); ?></a></li>
								<li><a rel="external nofollow" title="<?php _e('Subscribe with ', 'elegantbox'); _e('Xian Guo', 'elegantbox'); ?>" href="http://www.xianguo.com/subscribe.php?url=<?php echo $feed; ?>"> <?php _e('Xian Guo', 'elegantbox'); ?></a></li>
								<li><a rel="external nofollow" title="<?php _e('Subscribe with ', 'elegantbox'); _e('Zhua Xia', 'elegantbox'); ?>" href="http://www.zhuaxia.com/add_channel.php?url=<?php echo $feed; ?>"> <?php _e('Zhua Xia', 'elegantbox'); ?></a></li>
								<li><a rel="external nofollow" title="<?php _e('Subscribe with ', 'elegantbox'); _e('Google', 'elegantbox'); ?>" href="http://fusion.google.com/add?feedurl=<?php echo $feed; ?>"> <?php _e('Google', 'elegantbox'); ?></a></li>
								<li><a rel="external nofollow" title="<?php _e('Subscribe with ', 'elegantbox'); _e('My Yahoo!', 'elegantbox'); ?>" href="http://add.my.yahoo.com/rss?url=<?php echo $feed; ?>"> <?php _e('My Yahoo!', 'elegantbox'); ?></a></li>
								<li><a rel="external nofollow" title="<?php _e('Subscribe with ', 'elegantbox'); _e('newsgator', 'elegantbox'); ?>" href="http://www.newsgator.com/ngs/subscriber/subfext.aspx?url=<?php echo $feed; ?>"> <?php _e('newsgator', 'elegantbox'); ?></a></li>
								<li><a rel="external nofollow" title="<?php _e('Subscribe with ', 'elegantbox'); _e('Bloglines', 'elegantbox'); ?>" href="http://www.bloglines.com/sub/<?php echo $feed; ?>"> <?php _e('Bloglines', 'elegantbox'); ?></a></li>
								<li><a rel="external nofollow" title="<?php _e('Subscribe with ', 'elegantbox'); _e('iNezha', 'elegantbox'); ?>" href="http://inezha.com/add?url=<?php echo $feed; ?>"> <?php _e('iNezha', 'elegantbox'); ?></a></li>
							</ul>
						<?php endif; ?>
					</li>

				</ul>
				<!-- navigation END -->

			</div>
		</div>
	</div>
	<!-- header END -->

	<div id="container">
		<div id="content">
			<div id="main">
