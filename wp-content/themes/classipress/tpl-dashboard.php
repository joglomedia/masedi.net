<?php
/*
Template Name: Dashboard Page
*/


$wpdb->hide_errors(); 
auth_redirect_login(); // if not logged in, redirect to login page
nocache_headers();

global $userdata;
get_currentuserinfo(); // grabs the user info and puts into vars



require_once dirname( __FILE__ ) . '/form_process.php';
get_header( ); 
include_classified_form();
?>


<style>
.alternate{background:#F1F1F1 none repeat scroll 0%}
.standard{background:#FFFFFF none repeat scroll 0%}
.ins {background:#FFFFFF none repeat scroll 0 0; padding:20px; }
.ins .full { float:left;width:100%;}
.ins .full .title h2 { font-size: 24px; font-family: 'Arial', 'Trebuchet MS', 'Verdana', sans-serif; font-weight: bold; line-height: 30px; float: left; }
.box-yellow {background-color:#FFFFCC;border:1px dotted #D8D2A9;margin-bottom:20px;min-height:25px;padding:10px 10px 5px;}
</style>

<?php

// check to see if we want to pause or restart the ad
if(!empty($_GET['action']))
{
  $d=trim($_GET['action']);
  $aid=trim($_GET['aid']);

  // make sure author matches ad. Prevents people from trying to hack other peoples ads	
  $querystr = "SELECT wposts.post_author FROM $wpdb->posts wposts WHERE ID = $aid AND post_author = $userdata->ID";
  $checkauthor = $wpdb->get_row($querystr, OBJECT);	
	
  if( $checkauthor != null ) { // author check is ok. now update ad status
	
	if ($d=="pause") {
	  $my_ad = array();
	  $my_ad['ID'] = $aid;
	  $my_ad['post_status'] = 'pending';
	  wp_update_post( $my_ad );
	  
	} elseif ($d=="restart") {
	  $my_ad = array();
	  $my_ad['ID'] = $aid;
	  $my_ad['post_status'] = 'publish';
	  wp_update_post( $my_ad ); 
	  
	} else {  
	  //echo "nothing here";
	}
	
  }	
}
//check end



$prun_period = get_option("prun_period");

query_posts('cat=1');

// retreive all the ads for the current user
$sql_statement = "SELECT * FROM $wpdb->posts WHERE post_author = $userdata->ID AND post_type = 'post' AND (post_status = 'publish' OR post_status = 'pending' OR post_status = 'draft') ORDER BY ID DESC";	
$pageposts = $wpdb->get_results($sql_statement, OBJECT);

// calculate the total count of live ads for current user
$post_count = $wpdb->get_var("SELECT count(*) FROM $wpdb->posts WHERE post_author = $userdata->ID AND post_type = 'post' AND post_status = 'publish'");
if ($post_count) { $post_count = $post_count; } else { $post_count = '0'; }

$row_num = 1; 

?>

<div class="content">
		<div class="main ins">

		<div id="profile-link"><a href="<?php bloginfo('url'); ?>/profile/"><?php _e('My Profile','cp'); ?></a></div>
		
<?php if ($pageposts): ?>		
			<div class="full">
				<div class="title">
					<h2><?php _e('Dashboard for','cp');?> <?php echo($userdata->user_login . "\n"); ?></h2>
					
				</div>
				<div class="product">

				<strong><?php echo($userdata->user_identity . "\n"); ?></strong>
				

<p><?php _e('Below you will find all of your classified ads. You currently have','cp');?> <strong><?php echo $post_count; ?></strong> <?php _e('live ads. Edit or pause your ads by clicking on the option icons.','cp');?></p>

<table border="0" cellpadding="4" cellspacing="1" width="100%" bgcolor=#cccccc>
<thead>
<tr>
<th>&nbsp;</th>
<th width="40px"><?php _e('Ad ID','cp');?></th>
<th><?php _e('Title','cp');?></th>
<th><?php _e('Price','cp');?></th>
<th width="120px"><?php _e('Submitted','cp');?></th>
<th width="70px"><?php _e('Status','cp');?></th>
<th width="80px"><div style="text-align: center;"><?php _e('Options','cp');?></div></th>
</tr>
</thead>
<tbody>



  <?php foreach ($pageposts as $post): 
  
  if ($class == 'standard') { $class = 'alternate';} else { $class = 'standard';} 
  ?>
  
    <?php setup_postdata($post); ?>
	
<?php 
// if ad pruning is turned on, then mark expired ads as such
if ($post->post_date < date('Y-m-d h:i:s', strtotime("-$prun_period days")) && get_option("post_prun") == "yes") {
			$poststatus = __('ended','cp');
			$fontcolor = "#666666";
			$postimage = "";
			$postalt = "";
			$postaction = "ended";
} else {
			

	if ($post->post_status == 'publish') { 	
			$poststatus = "<b>" . __('live','cp') . "</b>";
			$fontcolor = "#33CC33";
			$postimage = "ad-pause.png";
			$postalt =  __('pause ad','cp');
			$postaction = "pause";
		} elseif ($post->post_status == 'draft') {
			if (get_option('activate_paypal') == 'yes') { $poststatus = __('awaiting payment','cp'); } else { $poststatus = __('awaiting approval','cp'); }
			$fontcolor = "#C00202";
			$postimage = "";
			$postalt = "";
			$postaction = "draft";
		} elseif ($post->post_status == 'pending') {
			$poststatus = __('offline','cp');
			$fontcolor = "#bbbbbb";
			$postimage = "ad-start-blue.png";
			$postalt = __('restart ad','cp');
			$postaction = "restart";
		} else { 
			$poststatus = "-";
		}
}
?>

<tr class='<?php echo $class ?>'>
<td align="center"><?php echo $row_num ?></td>
<td align="center"><?php echo the_id(); ?></td>



<?php 
if ($post->post_status == 'draft' || $poststatus == 'ended' || $poststatus == 'offline') { ?>
	<td><?php the_title(); ?></td>	
	
<?php } else { ?>

	<td><a target="_new" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
	
<?php } ?>


<td align="center"><?php echo get_option("currency") ?><?php echo get_post_meta($post->ID, "price", true); ?></td>
<td align="center"><?php the_time(get_option('date_format'))?><br /><?php the_time(get_option('time_format')) ?></td>
<td align="center"><span style="color:<?php echo $fontcolor ?>;"><?php echo $poststatus ?></span></td>
<td align="center">

<?php 

// get_option('activate_paypal') != 'yes'

if ($post->post_status == 'draft' && $postaction != 'ended') { 


if (get_option('activate_paypal') == 'yes') {

if(get_option('paypal_sandbox') == 1){
	$paypalurl="https://www.sandbox.paypal.com/cgi-bin/webscr";
}else {
	$paypalurl="https://www.paypal.com/cgi-bin/webscr";
}
?>

<form target="_blank" action="<?php echo $paypalurl ?>" method="post">
   <input type="hidden" name="cmd" value="_xclick">
   <input type="hidden" name="business" value="<?php echo get_option('paypal_email'); ?>">
   <input type="hidden" name="item_name" value="<?php _e('Classified ad listing on ','cp') ?><?php bloginfo('name'); ?> <?php _e('for','cp') ?> <?php echo get_option("prun_period"); ?> <?php _e('days','cp'); ?>">
   <input type="hidden" name="item_number" value="<?php echo $post_id; ?>">
   <input type="hidden" name="amount" value="<?php if (get_post_meta($post->ID, "cp_totalcost", true) != "") { echo get_post_meta($post->ID, "cp_totalcost", true); } else { echo get_option('ad_value'); }; ?>">
   <input type="hidden" name="no_shipping" value="1">
   <input type="hidden" name="no_note" value="1">
   <input type="hidden" name="notify_url" value="<?php echo get_option('home'); ?>/">
   <input type="hidden" name="cancel_return" value="<?php echo get_option('home'); ?>/">
   <input type="hidden" name="return" value="<?php echo get_option('home'); ?>/?payment=1">
   <input type="hidden" name="currency_code" value="<?php echo get_option('paypal_currency'); ?>">
   <input type="hidden" name="bn" value="IC_Sample">
   <input type="image" src="<?php bloginfo('template_directory'); ?>/images/paypal_btn.gif" name="submit">
   <img alt="" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

	
<?php 

} else { ?>

<?php if (cp_edit_ad_url == "/edit-ad/") {$cp_edit_ad_url = cp_edit_ad_url . "?";} else {$cp_edit_ad_url = cp_edit_ad_url;} ?>
<a href="<?php bloginfo('url')?><?php echo $cp_edit_ad_url; ?>aid=<?php the_id(); ?>"><img src='<?php bloginfo('template_directory'); ?>/images/pencil.png' title='edit ad' alt='edit ad' border=0></a>&nbsp;&nbsp;

<?php if (cp_dashboard_url == "/dashboard/") {$cp_dashboard_url = cp_dashboard_url . "?";} else {$cp_dashboard_url = cp_dashboard_url;} ?>
<a href="<?php bloginfo('url')?><?php echo $cp_dashboard_url; ?>aid=<?php the_id(); ?>&action=<?php echo $postaction; ?>"><img src='<?php bloginfo('template_directory'); ?>/images/<?php echo $postimage; ?>' title='<?php echo $postalt; ?>' alt='<?php echo $postalt; ?>' border=0></a>

<?php 
}

} elseif ($post->post_status == 'draft' || $postaction == 'ended') { ?>

&mdash;

<?php } else { ?>

<?php if (cp_edit_ad_url == "/edit-ad/") {$cp_edit_ad_url = cp_edit_ad_url . "?";} else {$cp_edit_ad_url = cp_edit_ad_url;} ?>
<a href="<?php bloginfo('url')?><?php echo $cp_edit_ad_url; ?>aid=<?php the_id(); ?>"><img src='<?php bloginfo('template_directory'); ?>/images/pencil.png' title='edit ad' alt='edit ad' border=0></a>&nbsp;&nbsp;

<?php if (cp_dashboard_url == "/dashboard/") {$cp_dashboard_url = cp_dashboard_url . "?";} else {$cp_dashboard_url = cp_dashboard_url;} ?>
<a href="<?php bloginfo('url')?><?php echo $cp_dashboard_url; ?>aid=<?php the_id(); ?>&action=<?php echo $postaction; ?>"><img src='<?php bloginfo('template_directory'); ?>/images/<?php echo $postimage; ?>' title='<?php echo $postalt; ?>' alt='<?php echo $postalt; ?>' border=0></a>

<?php } ?>


</td>
</tr>


<?php $row_num = $row_num + 1; 

	endforeach; ?>

 
</tbody>
</table>				

<p>

<table border="0" cellpadding="2" cellspacing="1" width="100%" bgcolor=#ffffff>
<thead>
<tr>
<td colspan="2"><strong><?php _e('Legend','cp');?></strong></td>
</tr>
<tr>
<td width="20px"><img src='<?php bloginfo('template_directory'); ?>/images/pencil.png' border=0></td>
<td><small><?php _e('Edit Ad - Allows you to edit your existing ad details.','cp');?></small></td>
</tr>
<tr>
<td><img src='<?php bloginfo('template_directory'); ?>/images/ad-pause.png' border=0></td>
<td><small><?php _e('Pause Ad - Instantly take your ad offline (i.e. if you sold or are negotiating a sale).','cp');?></small></td>
</tr>
<tr>
<td><img src='<?php bloginfo('template_directory'); ?>/images/ad-start-blue.png' border=0></td>
<td><small><?php _e('Restart Ad - Makes your ad live again if you paused it previously.','cp');?></small></td>
</tr>

</table>

</p>


<?php else : ?>
    <p class="center"><?php _e('You currently have no classified ads. Your dashboard will automatically be setup once you submit your first ad.','cp');?><br /></p>
 <?php endif; ?>

				
				
				
				</div>
			</div>


			
			
			<div class="clear"></div>
		</div>
	</div>


<?php get_footer(); ?>
