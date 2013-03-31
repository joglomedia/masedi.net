<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title>
	<?php if ( is_home() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;<?php bloginfo('description'); ?><?php } ?>
	<?php if ( is_search() ) { ?><?php _e('Search Results','cp'); ?>&nbsp;|&nbsp;<?php bloginfo('name'); ?><?php } ?>
	<?php if ( is_author() ) { ?><?php _e('Author Posts','cp'); ?>&nbsp;|&nbsp;<?php bloginfo('name'); ?><?php } ?>
	<?php if ( is_single() ) { ?><?php wp_title(''); ?>&nbsp;|&nbsp;<?php bloginfo('name'); ?><?php } ?>
	<?php if ( is_page() ) { ?><?php wp_title(''); ?>&nbsp;|&nbsp;<?php bloginfo('name'); ?><?php } ?>
	<?php if ( is_category() ) { ?><?php single_cat_title(); ?>&nbsp;|&nbsp;<?php bloginfo('name'); ?><?php } ?>
	<?php if ( is_month() ) { ?><?php bloginfo('name'); ?>&nbsp;|&nbsp;<?php the_time('F'); ?><?php } ?>
	<?php if (function_exists('is_tag')) { if ( is_tag() ) { ?><?php  single_tag_title("", true); } } ?>
</title>

	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/style.css" media="screen" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php if ( get_option('feedburner_url') <> "" ) { echo get_option('feedburner_url'); } else { echo get_bloginfo_rss('rss2_url'); } ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<!--[if IE]>
		<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ie.css" type="text/css" media="screen" />
	<![endif]-->

	<?php wp_enqueue_script('jquery'); ?>

	<?php wp_head(); ?>
	
	<script type='text/javascript' src='<?php bloginfo('template_url'); ?>/includes/js/global.js'></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/iconified.js"></script>
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/iconified.css" media="screen" />

	<script type='text/javascript' src='<?php bloginfo('template_url'); ?>/includes/js/fancybox/jquery.easing.1.3.js'></script>
	<script type='text/javascript' src='<?php bloginfo('template_url'); ?>/includes/js/fancybox/jquery.fancybox-1.2.1.pack.js'></script>
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/includes/js/fancybox/jquery.fancybox.css" type="text/css">
	
</head>


<body>

<?php
//grab the current theme image directory
$theme_image_dir = substr(get_option('stylesheet'), 0, -4);

define("cp_dashboard_url", "/dashboard/");
//define("cp_dashboard_url", "/?page_id=745&"); //uncomment this and enter the dashboard page id (replace 745) if you don't have pretty permalinks on.

define("cp_edit_ad_url", "/edit-ad/");
//define("cp_edit_ad_url", "/?page_id=748&"); //uncomment this and enter the edit ads page id (replace 748) if you don't have pretty permalinks on.

// show the total number of live ads. Uncomment when ready to use
//$numposts = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_status = 'publish'");
//if (0 < $numposts) $numposts = number_format($numposts);
//echo $numposts;
?>


	<div class="header-nav">
	
			<div class="left">
                <ul id="nav">
                    <?php if (is_page()) { $highlight = "page_item"; } else {$highlight = "page_item current_page_item"; } ?>
                    <li class="<?php echo $highlight; ?>"><a href="<?php bloginfo('url'); ?>">Home</a></li>
                    <?php 
						wp_list_pages('sort_column=menu_order&depth=0&title_li=&exclude='.get_option('excluded_pages')); 
					?>
                </ul>
            </div>
	
	
		<div class="right">
		
	<?php if (get_option('login_form') == "yes" || get_option('login_form') == "") { ?>	

	   <?php global $user_ID; if ( $user_ID ) : ?>
 		
		<?php global $current_user; get_currentuserinfo(); ?>
		
		<?php _e('Welcome,','cp'); ?> <strong><?php echo $current_user->user_login; ?></strong></a> 
           [ <a href="<?php echo get_option('home')?><?php echo cp_dashboard_url ?>"><?php _e('My Dashboard','cp'); ?></a> | <a href="<?php echo wp_logout_url(); ?>"><?php _e('Log out','cp'); ?></a> ]
		   
       <?php else : ?> 
	   
           <strong><?php _e('Welcome, visitor!','cp'); ?></strong> [ <a href="<?php echo get_option('home'); ?>/wp-login.php?action=register"><?php _e('Register','cp'); ?></a> | <a href="<?php echo get_option('home'); ?>/wp-login.php"><?php _e('Login','cp'); ?></a> ] &nbsp;

		<?php endif; ?>
		
	<?php } ?>

	
		<span style="padding-left:5px;top:3px;position:relative;">
		<a href="<?php if ( get_option('feedburner_url') <> "" ) { echo get_option('feedburner_url'); } else { echo get_bloginfo_rss('rss2_url'); } ?>"><img src="<?php bloginfo('template_url'); ?>/images/feed.jpg" border="0" alt="rss feed" /></a>
		</span>
		
		</div>
		<div class="clear"></div>
	</div>


	<div id="header">
	
	  <div class="header-logo">
	  
		<a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('description'); ?>"><img src="<?php if ( get_option('cp_logo') <> "" ) { echo get_option('cp_logo').'"'; } else { bloginfo('template_directory'); ?>/images/header-logo.gif<?php } ?>" border="0" alt="<?php bloginfo('name'); ?>" /></a>
			
		<!-- uncomment the lines below and remove the a href line above if you want to display your blog title and description instead of an image -->
		<!-- <h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
		 <p><?php bloginfo('description'); ?></p> -->
		 
	  </div>
	  
		<!-- Header Ad Starts -->
		<div class="header-ad">
		
			<?php cp_header_ad_468x60();?>	

		</div>
		<!-- Header Ad Ends -->
	
	</div><!-- end header div -->
	

	<div class="topbar">
		<div class="in">
			<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
				<div class="search">
					<input type="text" name="s" id="s" class="input" onclick="this.value=''" value="<?php _e('Search Classifieds...','cp'); ?>" onfocus="if (this.value == '<?php _e('Search Classifieds...','cp'); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e('Search Classifieds...','cp'); ?>';}" />
					<input type="submit" class="go" value="Go!" />
				</div>
			</form>
			<a href="#" id="ad-toggle" class="postbutton"><?php _e('Post a Classified!','cp'); ?></a>
			<div class="clear"></div>
		</div>
	</div>
	
	
<?php
$payment = (int)$_GET['payment'];
$item_number = "";
if ( $payment == "1" ) {
	foreach ($_POST as $key => $value) {
		if ($key == "payment_date") { $mess1 = __('Payment date:','cp') . "$value \n"; }
		if ($key == "first_name") { $mess2 .= __('First name:','cp') . "$value \n"; }
		if ($key == "last_name") { $mess2 .= __('Last name:','cp') . "$value \n"; }
		if ($key == "residence_country") { $mess3 .= __('Country:','cp') . "$value \n"; }
		if ($key == "item_name") { $mess3 .= __('Ad title:','cp') . "$value \n"; }
		if ($key == "payer_email") { $mess3 .= __('Payer email:','cp') . "$value \n"; }
		if ($key == "payer_status") { $mess3 .= __('Payer status:','cp') . "$value \n"; }
		if ($key == "verify_sign") { $mess3 .= __('Verify sign:','cp') . "$value \n"; }
		if ($key == "item_number") { $item_number = $value; }
	}
	
	if ( $item_number != "" ) {
		if ( get_option('notif_pay') == "yes" ) {
			$user_info = get_userdata(1);
			$admin_email = $user_info->user_email;
			$subject2 = __('New ad payment','cp');
			$email2 = __('ClassiPress','cp');

			$body = __('Someone just paid for an ad.','cp') . "\n\n" . $mess1 . $mess2 . $mess3;
	   		mail($admin_email,$subject2,$body,"From: $email2");
		} // if notif_pay == yes

		// publish the ad
		$item_number = (int)$item_number;
		$my_post = array();
		$my_post['ID'] = $item_number;
		$my_post['post_status'] = 'publish';
		wp_update_post( $my_post );
		?>
			<div style="clear: both;">
			<div class="payment_made"><?php _e('Thank you for your payment. Your ad has been published.','cp'); ?></div>
			<div style="clear: both;">
		<?php
	}// if $item_number != ""
} // if payment == 1
?>
