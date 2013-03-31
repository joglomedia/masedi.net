<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head profile="http://gmpg.org/xfn/11">
	<title><?php wp_title('&raquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

	<meta http-equiv="X-UA-Compatible" content="IE=8" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<link rel="stylesheet" href="http://www.masedi.net/wp-content/themes/designpile/style.css" type="text/css" media="screen" />
	<?php if(get_option('designpile_style')!=''){?>
		<link rel="stylesheet" href="http://www.masedi.net/wp-content/themes/designpile/css/<?php echo get_option('designpile_style'); ?>" media="screen" />
	<?php }else{?>
		<link rel="stylesheet" href="http://www.masedi.net/wp-content/themes/designpile/css/pink.css" media="screen" />
	<?php }?>
	<link rel="stylesheet" href="http://www.masedi.net/wp-content/themes/designpile/css/jquery.lightbox-0.5.css" media="screen" />
	<!--[if IE 7]>
	<link rel="stylesheet" media="screen" type="text/css" href="http://www.masedi.net/wp-content/themes/designpile/ie7.css" />
	<![endif]-->
		
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="http://www.masedi.net/feed" />
	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="http://www.masedi.net/feed/atom" />
	<link rel="pingback" href="http://www.masedi.net/xmlrpc.php" />
	<link rel="shortcut icon" href="http://www.masedi.net/wp-content/themes/cordobo-green-park-2/favicon.ico" type="image/x-icon" />

	<!--
	<script language="JavaScript" type="text/javascript" src="http://www.masedi.net/wp-content/themes/designpile/js/jquery-1.3.2.min.js"></script>
	<script language="JavaScript" type="text/javascript" src="http://www.masedi.net/wp-content/themes/designpile/js/jquery.form.js"></script>
	<script language="JavaScript" type="text/javascript" src="http://www.masedi.net/wp-content/themes/designpile/js/jquery.lightbox-0.5.min.js"></script>
	// -->
	
	<script language="JavaScript" type="text/javascript" src="http://www.masedi.net/wp-content/themes/designpile/js/designpile.compressed.js"></script>
	
	<!-- lightbox initialize script -->
	<script type="text/javascript">
		$(function() {
		   $('a.lightbox').lightBox();
		});
	 </script>

	<?php //wp_get_archives('type=monthly&format=link'); ?>
	<?php //comments_popup_script(); // off by default ?>
	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
	<?php wp_head(); ?>
</head>
<body>
	
<!-- begin mainWrapper -->
<div id="mainWrapper">
	<!-- begin wrapper -->
	<div id="wrapper">
		<!-- begin header-->
			<div id="header">
			<div id="getSocial"></div>
			
			<!-- begin search box -->
			<div id="searchBox" class="clearfix">
				<form id="searchform" action="" method="get">
					<label for="s">&nbsp;</label><input id="s" type="text" name="s" value=""/>
					<input id="searchsubmit" type="submit" value=""/>
				</form>
			</div>
			<!-- end search box -->

			<div id="logox">
			
			<?php if (is_home()) : ?>
			<h1><a href="http://www.masedi.net/" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></h1>
			<div class="homedesc description"><?php bloginfo('description'); ?></div>
			<?php else : ?>
			<div class="titleblog"><a href="http://www.masedi.net/" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a></div>
			<div class="singledesc description"><?php bloginfo('description'); ?></div>
			<?php endif; ?>
		
			<!--
            <a href="<?php bloginfo('url'); ?>/">
             <?php if(get_option('designpile_style')=='green.css' &&  get_option('designpile_logo_img') == ''){?>
             <img src="<?php bloginfo('template_url'); ?>/images/green/logo.png" alt="DesignPile by Site5.com" />
             <?php }elseif(get_option('designpile_style')=='blue.css' &&  get_option('designpile_logo_img') == ''){?>
              <img src="<?php bloginfo('template_url'); ?>/images/blue/logo.png" alt="DesignPile by Site5.com" />
              <?php }elseif(get_option('designpile_style')=='pink.css' &&  get_option('designpile_logo_img') == ''){?>
              <img src="<?php bloginfo('template_url'); ?>/images/pink/logo.png" alt="DesignPile by Site5.com" />
              <?php }else{?>
				<img src="<?php echo get_option('designpile_logo_img'); ?>" alt="<?php echo get_option('designpile_logo_alt'); ?>" />
              <?php }?>
            </a>
			-->
			
			</div>
			<!-- begin top menu (added SF menu) -->
			<div id="topMenuCont" class="clearfix">
				<ul class="clearfix" id="menu">
					<li><a href="<?php bloginfo('url'); ?>/">Home</a></li>
					<?php
						wp_list_pages('title_li=');
						//wp_list_categories('sort_column=menu_order&title_li=');
					?>
				</ul>
			</div>	
			<!-- end top menu -->
			<!-- social links -->
			<ul id="socialLinks">
                <?php if(get_option('designpile_flickr_link')!=""){ ?>
				<li>
                <a rel="nofollow" href="<?php echo get_option('designpile_flickr_link'); ?>" target="_blank" title="Twitter"><img src="<?php bloginfo('template_url'); ?>/images/ico_flickr.png" alt="Flickr" /></a></li><?php }?>
                 <?php if(get_option('designpile_twitter_link')!=""){ ?>
				<li>
                <a rel="nofollow" href="<?php echo get_option('designpile_twitter_link'); ?>" target="_blank" title="Twitter"><img src="<?php bloginfo('template_url'); ?>/images/ico_twitter.png" alt="Twitter" /></a></li><?php }?>
                 <?php if(get_option('designpile_facebook_link')!=""){ ?>
				<li>
                <a rel="nofollow" href="<?php echo get_option('designpile_facebook_link'); ?>" target="_blank" title="Facebook"><img src="<?php bloginfo('template_url'); ?>/images/ico_facebook.png" alt="Facebook" /></a></li><?php }?>
				<li><a href="<?php bloginfo('rss2_url'); ?>" title="RSS" class="rssTag"><img src="<?php bloginfo('template_url'); ?>/images/ico_rss.png" alt="Feeds" /></a></li>
			</ul>
			<!-- end social links -->
			</div>
		<!-- end header -->
		
		<!-- begin content -->
			<div id="content" class="clearfix">