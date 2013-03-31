<?php
/*
Template Name: Edit Ad Page
*/


$wpdb->hide_errors(); 
auth_redirect_login(); // if not logged in, redirect to login page
nocache_headers();

global $userdata;
get_currentuserinfo(); // grabs the user info and puts into vars


// check to see if the form has been posted. If so, validate the fields
if(!empty($_POST['submit']))
{

   $title    	= trim($_POST['post_title']);
   $price	 	= cp_filter($_POST['price']);
   $location 	= cp_filter($_POST['location']);
   $phone	 	= cp_filter($_POST['phone']);
   $email	 	= cp_filter($_POST['email']);
   $name_owner 	= cp_filter($_POST['name_owner']);
   $cp_adURL	= cp_filter($_POST['cp_adURL']);   
   
   $description	= trim($_POST['description']);
   
	if($title == '')
	{
      $errmsg = __('Ad title cannot be blank','cp');
	  $hfield = '1';
	}
	else if($price == '')
	{
      $errmsg = __('Price cannot be blank','cp');
	  $hfield = '2';
	}
	else if($location == '')
	{
      $errmsg = __('Location cannot be blank','cp');
	  $hfield = '3';
	}
	else if($email == '')
	{
      $errmsg = __('Email address cannot be blank','cp');
	  $hfield = '5';
	}
	else if ( !cp_check_email($email) ) {
	  $errmsg = __('Email address is not valid','cp');
	  $hfield = '5';
	}
	else if($name_owner == '')
	{
      $errmsg = __('Name cannot be blank','cp');
	  $hfield = '6';
	}
	else if($description == '')
	{
      $errmsg = __('The description cannot be blank','cp');
	  $hfield = '7';
	}

	

// if there are no errors, then process the ad updates
if($errmsg == '')
	{
		if ( get_option('filter_html') != "yes" ) {
			$description 	= cp_filter($description);
		}

		  
	  // Put all post variables into an array 
	  $my_ad = array();
	  $my_ad['ID'] = trim($_POST['ad_id']);
	  $my_ad['post_title'] = cp_filter($_POST['post_title']);
	  $my_ad['post_content'] = $description;

	  // Update the ad in the db
	  wp_update_post( $my_ad );

	  // now go back and update the meta fields
	  update_post_meta($_POST['ad_id'], 'price', $price);
	  update_post_meta($_POST['ad_id'], 'location', $location);
	  update_post_meta($_POST['ad_id'], 'phone', $phone);
	  update_post_meta($_POST['ad_id'], 'email', $email);
	  update_post_meta($_POST['ad_id'], 'name', $name_owner);
	  update_post_meta($_POST['ad_id'], 'cp_adURL', $cp_adURL);
	  
	  
	  $cp_dashboard_url = $_POST['dashboard_url'];
	  
	  $errmsg = '<div class="box-yellow"><b>' . __('Your ad has been updated!','cp') . '</b><br /><br /> <a href=".' . $cp_dashboard_url . '">' . __('My Dashboard &rsaquo;&rsaquo;','cp') . '</a></div>'; 
	
	} else {
	
	  $errmsg = '<div class="box-red"><strong>**  ' . $errmsg . ' **</strong></div>'; 
	  $errcolor = 'style="background-color:#FFEBE8;border:1px solid #CC0000;"';
	}

  
}	  
	  

// get the ad id from the querystring. Need this for the sql statement
$aid = $_GET["aid"];

$querystr = "SELECT wposts.* FROM $wpdb->posts wposts WHERE ID = $aid AND post_status <> 'draft' AND post_author = $userdata->ID";

// pull ad fields from db
$getmyad = $wpdb->get_row($querystr, OBJECT);




// start main edit page
require_once dirname( __FILE__ ) . '/form_process.php';

get_header(); 
include_classified_form();
?>

<style type="text/css">
.mid2 { border:1px solid #CCC; margin-bottom:10px; padding:5px; }
</style>

<script type="text/javascript">
function textCounter(field,cntfield,maxlimit) { if (field.value.length > maxlimit) field.value = field.value.substring(0, maxlimit); else cntfield.value = maxlimit - field.value.length; }
</script>

<div class="content">
		<div class="main ins">
		
			<div class="left">
				
				<div class="product">

<?php 
if (get_option('cp_ad_edit') != "no") { 
?>
				
	<?php if ($getmyad): ?>


	<?php echo $errmsg; ?>	

	<form name="edit_ad" id="edit_ad" action="" method="post" enctype="multipart/form-data">
	<input type="hidden" name="ad_id" value="<?php echo $getmyad->ID; ?>" />
	<input type="hidden" name="dashboard_url" value="<?php echo cp_dashboard_url; ?>" />


	<h2><?php _e('Edit Your Ad','cp');?></h2>
	<p><?php _e('Edit the fields below and click save to update your ad. Your changes will be updated instantly on the site.','cp');?></p>

	<p><strong><?php _e('Ad ID:','cp');?></strong> <span style="background-color:#eee;padding:5px;"><?php echo $getmyad->ID; ?></span></p>


	<p><label><b><?php _e('Title','cp');?></b> *<br />
	<input <?php if ($hfield == '1') { echo $errcolor; } ?> type="text" name="post_title" class="mid2" id="post_title" value="<?php echo $getmyad->post_title; ?>" size="50" maxlength="100" /></label></p>

	<p><label><b><?php _e('Price','cp');?></b> *<br />
	<input <?php if ($hfield == '2') { echo $errcolor; } ?> type="text" name="price" class="mid2" id="price" value="<?php echo get_post_meta($getmyad->ID, "price", true); ?>" size="50" maxlength="100" /></label></p>
	
	<p><label><b><?php _e('Location','cp');?></b> *<br />
	<input <?php if ($hfield == '3') { echo $errcolor; } ?> type="text" name="location" class="mid2" id="location" value="<?php echo get_post_meta($getmyad->ID, "location", true); ?>" size="50" maxlength="100" /></label></p>
		
	<p><label><b><?php _e('Name','cp');?></b> *<br />
	<input <?php if ($hfield == '6') { echo $errcolor; } ?> type="text" name="name_owner" class="mid2" id="name_owner" value="<?php echo get_post_meta($getmyad->ID, "name", true); ?>" size="50" maxlength="100" /></label></p>

	<p><label><b><?php _e('Email','cp');?></b> *<br />
	<input <?php if ($hfield == '5') { echo $errcolor; } ?> type="text" name="email" class="mid2" id="email" value="<?php echo get_post_meta($getmyad->ID, "email", true); ?>" size="50" maxlength="100" /></label></p>
	
	<p><label><b><?php _e('Phone','cp');?></b><br />
	<input type="text" name="phone" class="mid2" id="phone" value="<?php echo get_post_meta($getmyad->ID, "phone", true); ?>" size="50" maxlength="100" /></label></p>
	
	<p><label><b><?php _e('URL','cp');?></b><br />
	<input type="text" name="cp_adURL" class="mid2" id="cp_adURL" value="<?php echo get_post_meta($getmyad->ID, "cp_adURL", true); ?>" size="50" maxlength="250" /></label></p>

	

	<p><b><?php _e('Description','cp');?></b> *<br />
	<textarea <?php if ($hfield == '7') { echo $errcolor; } ?> name="description" class="mid2" id="description" rows="15" cols="57" onkeydown="textCounter(document.edit_ad.description,document.edit_ad.remLen1,5000)"
					onkeyup="textCounter(document.edit_ad.description,document.edit_ad.remLen1,5000)"><?php echo stripslashes($getmyad->post_content); ?></textarea></p>

	<div class="limit">
		<input readonly="readonly" type="text" name="remLen1" size="4" maxlength="4" value="5000" style="width: 50px;" /><span style="font-size:11px;"> <?php _e('characters left','cp'); ?></span>
	</div>


	<p class="submit"><input type="submit" class="lbutton" value="<?php _e('Update Ad &raquo;','cp') ?>" name="submit" /></p>
	</form>


  
  <?php else : ?>

    <h2 class="center"><?php _e('Ad Not Found','cp');?></h2>
    <p class="center"><?php _e('Sorry, but you are looking for something that isn\'t here.','cp');?><br /> <?php _e('Go to','cp');?> <a href="<?php bloginfo('url')?><?php echo cp_dashboard_url; ?>"><?php _e('My Dashboard','cp');?> &rsaquo;&rsaquo;</a></p>

<?php endif; ?>

<?php } else { ?>

<h2 class="center"><?php _e('Ad Editing is Disabled','cp');?></h2>
    <p class="center"><?php _e('Your site administrator has disabled ad editing. Please contact them for further instructions.','cp');?><br /> <?php _e('Go to','cp');?> <a href="<?php bloginfo('url')?><?php echo cp_dashboard_url; ?>"><?php _e('My Dashboard','cp');?> &rsaquo;&rsaquo;</a></p>

<?php } ?>



				</div>
			</div>
	
			<div class="right">
			
			<?php if (function_exists('dynamic_sidebar')&&dynamic_sidebar('Page Sidebar')):else: ?>
				
				<li><h2><?php _e('Archives','cp'); ?></h2>
					<ul>
					<?php wp_get_archives('type=monthly'); ?>
					</ul>
				</li>

				<?php wp_list_categories('show_count=1&title_li=<h2>'.__('Categories','cp').'</h2>'); ?>
				
			<?php endif; ?>
			
			</div>
			<div class="clear"></div>
		</div>
	</div>

<?php get_footer(); ?>

