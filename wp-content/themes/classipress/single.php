<?php
require_once dirname( __FILE__ ) . '/form_process.php';
get_header( ); 
include_classified_form();
?>

	<?php 
	$gmaps_key = get_option('cp_gmaps_key');
	if (!empty($gmaps_key)) {?>	
	<script src="http://maps.google.com/maps?file=api&amp;v=1&amp;key=<?php echo $gmaps_key; ?>" type="text/javascript"></script>
	<?php  }?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="content">
	
		<div class="breadcrumb">
			<?php if(function_exists('bcn_display')) { bcn_display(); } ?>
		</div>
		
<div class="alignright" style="margin-top:-19px;"><?php previous_post_link('&laquo; %link', __('Previous','cp'), TRUE) ?>&nbsp;&nbsp;<?php next_post_link('%link &raquo;', __('Next','cp'), TRUE) ?></div>

		<div class="main ins">
			<div class="left">
				<div class="title">
					<h2><?php the_title(); ?></h2>
					<div class="prices"><?php echo get_option('currency'); ?><?php echo get_post_meta($post->ID, "price", true); ?></div>
					<div class="clear"></div>
				</div>
				<div class="product">

					<h3><?php _e('Description','cp'); ?></h3>
					
						<?php the_content(); ?>
					
					<br />
					
					<p class="prdetails">
					<h3>Classifieds Meta Info:</h3>

					<?php if (get_post_meta($post->ID, "expires", true) != "") { ?>
					<strong><?php _e('Expires','cp'); ?>: </strong> <?php echo get_post_meta($post->ID, "expires", true); ?><br />
					<?php } ?>

					<?php if (get_post_meta($post->ID, "cp_adURL", true) != "") { ?>
					<strong><?php _e('URL:','cp'); ?></strong> <a target="_blank" rel="nofollow" href="<?php echo get_post_meta($post->ID, "cp_adURL", true); ?>"><?php echo get_post_meta($post->ID, "cp_adURL", true); ?></a><br />
					<?php } ?>
					<strong><?php _e('Tags','cp'); ?>:</strong> <?php the_tags( '', ', ', ''); ?><br />
					<strong><?php _e('Stats','cp'); ?>:</strong> <?php if (function_exists('todays_overall_count')) { todays_overall_count($post->ID, '', __('total views','cp'), __('so far today','cp'), '1', 'show'); } ?>	<br /><br />
					
					<?php if(function_exists('wp_email')) { email_link(); } ?>  
					<?php if(function_exists('wp_print')) { print_link(); } ?>  
					<?php edit_post_link(__('Edit Ad','cp'), '<br />', '<br />'); ?>	
					</p>	

				<?php 
				if (get_option('cp_gmaps') != "no") { ?>	
					<h3><?php _e('Item Location','cp'); ?></h3>
					<div id="gmap" style="padding:10px 0 40px 0;">
                  	<div id="map" style="height:300px;"></div>
					
					<script type="text/javascript">var address = "<?php echo get_post_meta($post->ID, "location", true); ?>";</script>
					<?php gmaps_js(); ?>  

					</div>
				<?php  } ?>
				
					
					<h3><?php _e('Images','cp'); ?></h3>
					<p class="prdetails">
					<?php if(function_exists('classi_lightbox')) {classi_lightbox(get_post_meta($post->ID, 'images', true)); } ?>
					</p>
				

					
						<?php cp_single_ad_336x280(); ?>			
					

				
				
					<?php comments_template('',true); ?>
			
				</div>
			</div>
			<div class="right">

<?php if (get_option('report_button') == "yes" || get_option('report_button') == "") { 

if (isset($_POST['action']) && $_POST['action'] == 'report') {
    $subject2 = __('URL reported for:') . get_the_title();
    $condiment = strip_tags($_POST['condiment']);
    $report_url = strip_tags($_POST['page_url']);

	if ( $condiment != "") {
		exit;
	}

	$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	$ip = getenv("REMOTE_ADDR");

	$body = __('Someone has reported the following classified ad on your site: ','cp') . $report_url . "\n\n IP Address: " . $ip . "\n Server: " . $hostname ;
	$admin_email = get_bloginfo('admin_email');
	$email2 = $admin_email;
	// $admin_email = "tester2@localhost";	// uncomment this for local testing
    mail($admin_email,$subject2,$body,"From: $email2");
    $email_ok = "ok";
    unset($admin_email, $email2, $body, $subject2);
    echo "<span style='float: left;color: red;'><b>" . __('The report has been sent!','cp') . "</b></span>";
}
?>
		<form action="<?php echo selfURL(); ?>" method="post">
			<input type="text" class="condiment" name="condiment" value="" />
			<input type="hidden" name="page_url" value="<?php echo selfURL(); ?>" />
			<input type="submit" class="report" name="submit" value="" />
			<input type="hidden" name="action" value="report" />
		</form>
<?php } ?>



		<span><?php _e('Posted By:','cp');?></span>
	
			<h1>
			<?php if (get_the_author() != "") { ?>
				<a href="<?php bloginfo('url'); ?>/author/<?php echo strtolower(the_author_login()); ?>"><?php echo get_post_meta($post->ID, "name", true); ?></a>
			<?php } else { 
				echo get_post_meta($post->ID, "name", true); 
			} ?>
			</h1>
	
		<div style="padding-left:15px;padding-top:10px;padding-bottom:5px;">
			<div id="location"><?php echo get_post_meta($post->ID, "location", true); ?></div><br /><br />
			<div id="listed"><?php the_time(get_option('date_format') . ' ' . get_option('time_format')) ?></div><br /><br />
			<div id="phone"><?php echo get_post_meta($post->ID, "phone", true); ?></div><br /><br />
			
			<?php if (get_option('post_prun') == "yes" && get_post_meta($post->ID, "expires", true) != "") { ?>			
			<div id="expires"><?php $get_expires = strtotime(get_post_meta($post->ID, "expires", true)); echo cp_timeleft($get_expires); ?> 
			</div><br /><br />
			<?php } ?>
		
			
		</div>

					
			
		
<?php if (get_option('email_form') == "yes" || get_option('email_form') == "") { ?>
	<div class="email_form">
		<h3><a href="#" id="email-toggle"><?php _e('Contact Ad Owner','cp'); ?></a></h3><br />
<?php
	$email_err = "";
	$email_ok = "";
if (isset($_POST['action']) && $_POST['action'] == 'email') {
    $subject2 = "Re: ".get_the_title();
    $name2 = strip_tags($_POST['name2']);
    $email2 = strip_tags($_POST['email2']);
    $receiver_email = strip_tags($_POST['receiver_email']);
	$receiver_email = str_replace("gd6j83ksl", "@", $receiver_email);
	$receiver_email = str_replace("m3gd0374h", ".", $receiver_email);
    $message2 = strip_tags($_POST['message2']);

	if ( $name2 == "") {
		$email_err .= __('Enter your name','cp') . "<br />";
	}

	if ( $email2 == "") {
		$email_err .= __('Enter your email address','cp') . "<br />";
	} else {
		if ( !cp_check_email($email2) ) {
			$email_err .= __('Email format is incorrect','cp') . "<br />";
		}
	}

	if ( $message2 == "") {
		$email_err .= __('Enter a message','cp') . "<br />";
	}

	$email_total = (int)$_POST['email_total'];
	$email_nr1 = (int)$_POST['email_nr1']; $email_nr1 = str_replace("60293", "", $email_nr1);
	$email_nr2 = (int)$_POST['email_nr2']; $email_nr2 = str_replace("36202", "", $email_nr2);
	$email_nr1nr2 = $email_nr1 + $email_nr2;

	if ( $email_total != $email_nr1nr2 ) {
		$email_err .= __('The spam field is incorrect','cp') . "<br />";
	}

	if ( $email_err == "" ) {
		$body = __('Someone is interested in your classified ad! They sent you a message from the following page:','cp') . "\n\n" . selfURL()."
	\n 
	Name: $name2
	Email: $email2
	Message: $message2
	";
	// $receiver_email = "tester@localhost"; //uncomment this line to test locally
	// ini_set('sendmail_from', 'me@domain.com'); //this line might need to be enabled for some people using Windows hosted sites
	    mail($receiver_email,$subject2,$body,"From: $email2");
	    $email_ok = "ok";
	    unset($receiver_email, $name2, $email2, $message2, $subject2);
	}
}
?>
<a name="email-form"></a>
<?php
if ( $email_err != "" ) {
	echo "<div class=\"email_err\">$email_err</div>";
}
?>
<?php
if ( $email_ok == "ok" ) {
	echo "<div class=\"email_ok\">" . __('Your email has been sent.','cp') . "</div>";
}
?>

<?php if (get_option('expand_email_form') == "yes" ) { ?>		
					<div id="email_form_data">
					<?php } else { ?>
					<div id="email_form_data" <?php if ($email_err == "") { echo "style=\"display: none;\""; } ?>>
					<?php } ?>

					

					<form action="<?php the_permalink(); ?>#email-form" method="post">
						<?php _e('Name','cp'); ?>:<br /><input type="text" name="name2" value="<?php echo $name2;?>" /><br />
						<?php _e('Email','cp'); ?>:<br /><input type="text" name="email2" value="<?php echo $email2;?>" /><br />
						<?php _e('Subject','cp'); ?>:<br />
						<div class="like_input"><?php _e('Re:','cp'); ?> <?php the_title(); ?></div><br />
						<?php _e('Message','cp'); ?>:<br /><textarea name="message2" rows="1" cols="2"><?php echo $message2;?></textarea>
						<input type="hidden" name="action" value="email" />
						<input type="hidden" name="receiver_email" value="<?php email_spam(get_post_meta($post->ID, "email", true)); ?>" />
			<div class="capcha" style="text-align: center;">
							<?php
							$email_nr1 = rand("0", "9");
							$email_nr2 = rand("0", "9");
							?>
				<?php echo $email_nr1; ?> + <?php echo $email_nr2; ?> = <input type="text" name="email_total" class="email_captcha" maxlength="2" value="" /> &nbsp; 
				<input type="hidden" name="email_nr1" value="60293<?php echo $email_nr1; ?>" />
				<input type="hidden" name="email_nr2" value="36202<?php echo $email_nr2; ?>" />
			</div><br />
						<input type="submit" style="width:240px;" name="send" value="<?php _e('Send Email','cp'); ?>" />
					</form>
					</div>
				</div>
<?php } ?>				
							

				<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Ads Sidebar')) : else : ?>
				<!-- no dynamic sidebar so don't do anything -->
				<?php endif; ?>
				
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<?php endwhile; endif; ?>
	

<?php get_footer(); ?>
