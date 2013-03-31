<?php get_header(); ?>
<?php
if($_REQUEST['page']=='registration' && $_REQUEST['frm']=='jobpost')
{
	$secure_cookie = '';

	if ( !empty($_POST['log']) && !force_ssl_admin() ) {
		$user_name = sanitize_user($_POST['log']);
		if ( $user = get_userdatabylogin($user_name) ) {
			if ( get_user_option('use_ssl', $user->ID) ) {
				$secure_cookie = true;
				force_ssl_admin(true);
			}
		}
	}

	if ( isset( $_REQUEST['redirect_to'] ) ) {
		$redirect_to = $_REQUEST['redirect_to'];
		// Redirect to https if user wants ssl
		if ( $secure_cookie && false !== strpos($redirect_to, 'wp-admin') )
			$redirect_to = preg_replace('|^http://|', 'https://', $redirect_to);
	} else {
		$redirect_to = admin_url();
	}

	if ( !$secure_cookie && is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
		$secure_cookie = false;

	$user = wp_signon('', $secure_cookie);

	$redirect_to = apply_filters('login_redirect', $redirect_to, isset( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '', $user);

	if ( !is_wp_error($user) ) {
		// If the user can't edit posts, send them to their profile.
		if ( !$user->has_cap('edit_posts') && ( empty( $redirect_to ) || $redirect_to == 'wp-admin/' || $redirect_to == admin_url() ) )
			$redirect_to = admin_url('profile.php');
		wp_safe_redirect($redirect_to);
		exit();
	}
	$errors = $user;
	foreach($errors as $errorsObj)
	{
		
		foreach($errorsObj as $key=>$val)
		{
			$error_content =  "&msg=".$key;
		} 
	}
	wp_redirect(get_option('siteurl').'/?page=postajob'.$error_content);
	exit;	
}else
if($_REQUEST['page']=='postajob' || $_REQUEST['page']=='editjob')
{
	include (TEMPLATEPATH . "/monetize/job/job_submit_frm.php");
	exit;
}
elseif($_REQUEST['page'] == 'job')
{
 get_header();
 ?>	
     <div class="category_list">
        <div class="category_list-in">
            <ul>
             <li class="bnone"><?php echo CATEGORY; ?> : </li>
             <?php 
             $blogcatids = get_category_by_cat_name(get_option('pt_blog_cat')); //remove blog category from listing page
             wp_list_categories_custom('exclude='. $blogcatids.'&title_li=&jtype='.$_REQUEST['jtype']);
             ?>
             </ul>
             <div class="clear"></div>
        </div>
        <div class="clear"></div>
     </div> <!-- category_list -->

 	<div id="page">
 	<div id="content-wrap" class="clear <?php if(get_option("ptthemes_page_layout") == "Right Sidebar") { echo "right-side"; } else { echo "left-side"; } ?>" >
	<div id="content">
	<?php include_once(TEMPLATEPATH.'/library/includes/jobs_listing.php'); ?>
	</div>
    <div id="sidebar">
        <?php dynamic_sidebar("job-listing-area"); ?>
    </div>    
<?php	
	get_footer();
	exit;
}
elseif($_REQUEST['page']=='postaresume' || $_REQUEST['page']=='editresume')
{
	include (TEMPLATEPATH . "/monetize/resume/resume_submit_frm.php");
	exit;
}elseif($_REQUEST['page']=='previews')
{
	include (TEMPLATEPATH . "/monetize/resume/resume_preview.php");
	exit;
}
elseif($_REQUEST['page'] == 'paynows')
{
	include (TT_MODULES_FOLDER_PATH . "/resume/paynow.php");
	exit;
}

elseif($_REQUEST['page']=='preview')
{
	include (TEMPLATEPATH . "/monetize/job/job_preview.php");
	exit;
}
elseif($_REQUEST['page'] == 'paynow')
{
	include (TT_MODULES_FOLDER_PATH . "/job/paynow.php");
	exit;
}
elseif($_REQUEST['page'] == 'cancel_return')
{
	include(TEMPLATEPATH . '/library/includes/cancel.php');
	set_property_status($_REQUEST['pid'],'draft');
	exit;
}
elseif($_GET['page'] == 'return' || $_GET['page'] == 'payment_success')  // PAYMENT GATEWAY RETURN
{
	set_property_status($_REQUEST['pid'],'publish');
	include(TEMPLATEPATH . '/library/includes/return.php');
	exit;
}
elseif($_GET['page'] == 'success')  // PAYMENT GATEWAY RETURN
{
	include(TEMPLATEPATH . '/monetize/general/success.php');
	exit;
}
elseif($_GET['page'] == 'notifyurl')  // PAYMENT GATEWAY NOTIFY URL
{
	if($_GET['pmethod'] == 'paypal')
	{
		include(TEMPLATEPATH . '/library/includes/ipn_process.php');
	}elseif($_GET['pmethod'] == '2co')
	{
		include(TEMPLATEPATH . '/library/includes/ipn_process_2co.php');
	}
	exit;
}

elseif($_REQUEST['page'] == 'delete')
{
	global $current_user;
	if($_REQUEST['pid'])
	{
		wp_delete_post($_REQUEST['pid']);
		wp_redirect(get_author_link($echo = false, $current_user->ID));
	}
	
}

elseif($_REQUEST['page']=='advance_search')
{
	include (TEMPLATEPATH . "/advance_search.php");
	exit;
}elseif($_REQUEST['page']=='ipn')
{
	include (TEMPLATEPATH . "/ipn.php");
	exit;
}elseif($_REQUEST['page']=='resume')
{
	include (TEMPLATEPATH . "/library/includes/resume.php");
	exit;
}
if($_REQUEST['page'] == 'profile')
{
	include (TEMPLATEPATH . "/library/includes/edit_profile.php");
	exit;
}
if($_REQUEST['page'] == 'register' || $_REQUEST['page'] == 'login')
{
	include (TEMPLATEPATH . "/monetize/registration/registration.php");
	exit;
}

?>
<?php get_header(); ?>

<div class="category_list">
      	<div class="category_list-in">
		    <ul>
             <li class="bnone"><?php echo CATEGORY; ?> : </li>
             <?php 
			 $blogcatids = get_category_by_cat_name(get_option('pt_blog_cat')); //remove blog category from listing page
			 wp_list_categories_custom('exclude='. $blogcatids.'&title_li=&jtype='.$_REQUEST['jtype']);  
             ?>
             </ul>
             <div class="clear"></div>
      	</div>
      </div> <!-- category_list -->

<div id="page">
 <div id="content-wrap" class="clear <?php if(get_option("ptthemes_page_layout") == "Right Sidebar") { echo "right-side"; } else { echo "left-side"; } ?>" >
 <div id="content" class="content">
    <?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') { ?><div class="breadcums"><ul class="page-nav"><li><?php yoast_breadcrumb('',''); ?></li></ul></div><?php } ?>
 <?php
 if($_REQUEST['page']=='return')
{
	include (TEMPLATEPATH . "/return.php");
}elseif($_REQUEST['page']=='cancel')
{
	wp_delete_post($_REQUEST['pid']);
	include (TEMPLATEPATH . "/cancel.php");
}

elseif($_REQUEST['jtype'] == 'all' || $_REQUEST['jtype'] == 'Full Time' || $_REQUEST['jtype'] == 'Part Time' || $_REQUEST['jtype'] == 'Freelance')
{
?>      
 <?php
 include_once(TEMPLATEPATH.'/library/includes/jobs_listing.php');
 ?>
   
 </div>

<?php } else {?>

  <div class="newlisting"> 
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <!--post title-->
      <h1   id="post-<?php the_ID(); ?>">
        <?php the_title(); ?>
      </h1>
      <!--post with more link -->
      <div class="clear">
        <?php the_content('<p class="serif">continue</p>'); ?>
      </div>
      <!--if you paginate pages-->
      <?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
      <!--end of post and end of loop-->
      <?php endwhile; endif; ?>
 </div>  
 <?php } ?>
 </div>
<?php get_sidebar(); ?>
 <?php get_footer(); ?>