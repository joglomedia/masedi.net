<script type="text/javascript">
function textCounter(field,cntfield,maxlimit) { if (field.value.length > maxlimit) field.value = field.value.substring(0, maxlimit); else cntfield.value = maxlimit - field.value.length; }
</script>




<?php
$ok = cp_filter($_GET['ok']);
if ($err != "") { echo "<div id=\"err\" class=\"err\"><div id='closelink'><a href=\"#\" onClick=\"document.getElementById('err').style.display = 'none';\">X</a></div>$err</div>"; }

if ($ok == "ok") {
	echo "<div class=\"ok\"><strong>" . __('Thank you! Your classified ad has been submitted succesfully.','cp') . "</strong><br />";
	
if ( get_option("post_status") == "draft" && get_option('activate_paypal') != "yes") { 
	echo __('Someone will review your ad shortly. If you have any questions, please contact the site owner.','cp') . "<br />";
 }	
	
if ( get_option('activate_paypal') == "yes" ) {
	$post_id = (int)$_GET['id'];
	$post_title = $_GET['title'];
	$post_title = str_replace("+", " ", $post_title);
	$ad_value = get_option('ad_value'); // 10
	$featured_ad_check = (int)$_GET['fid'];
	$lprice = (int)$_GET['lprice'];
	
	if ($featured_ad_check == '1') {$isfeatured = get_option('cp_featured_ad');}
	
	if ( get_option('cp_price_scheme') == "category" ) {
	
		$getcatid = $_GET['catid'];  // 21
		
		// if cat is blank then assign it the first category
		if ($getcatid == "") { $getcatid = "1"; }
		
		$cat_price = get_option('cp_cat_price_'.$getcatid); // 0
		
		// if cat price is blank then assign it default price
		if ($cat_price != "") { $totalcost = $cat_price; } else { $totalcost = $ad_value; }
		
	}
	
	elseif( get_option('cp_price_scheme') == "percentage" ) {
	
		// first grab the % and then put it into a workable number
		$ad_percentage = (get_option('cp_ad_percent') * 0.01);
		
		// calculate the ad cost. Ad listing price x percentage. 
		$totalcost =  (trim($lprice) * trim($ad_percentage));
	
	} else {
		$totalcost = $ad_value; 
	}
	
	// calculate the total cost for the ad. 
	$totalcost_out = $totalcost + $isfeatured;
	
	// put the total cost of the ad into a custom field
	add_post_meta($post_id, 'cp_totalcost', $totalcost_out, true);
	
	?>
<br />

<?php if ($totalcost_out != "0") { ?>


		<?php _e('Please click the PayPal button below to submit your','cp'); ?> <b><?php echo get_option('currency'); ?><?php echo $totalcost_out; ?>&nbsp;<?php echo get_option('paypal_currency'); ?></b> <?php _e('listing fee.','cp'); ?><br /><?php _e('Your ad will not be published until payment has been received.','cp'); ?><br /><br />
		<center>

		<?php 
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
		   <input type="hidden" name="amount" value="<?php echo $totalcost_out; ?>">
		   <input type="hidden" name="no_shipping" value="1">
		   <input type="hidden" name="no_note" value="1">
		   <input type="hidden" name="notify_url" value="<?php echo get_option('home'); ?>/">
		   <input type="hidden" name="cancel_return" value="<?php echo get_option('home'); ?>/">
		   <input type="hidden" name="return" value="<?php echo get_option('home'); ?>/?payment=1">
		   <input type="hidden" name="currency_code" value="<?php echo get_option('paypal_currency'); ?>">
		   <input type="hidden" name="bn" value="IC_Sample">
		   <input type="image" src="<?php bloginfo('template_directory'); ?>/images/paypal_btn.gif" name="submit">
		   <img alt="" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
		</form><br />
		<span style="color: red; background-color: #fff; padding: 2px 5px;"><b><?php _e('IMPORTANT','cp');?></b></span> <?php _e('Be sure to click RETURN TO STORE (from paypal.com) for your ad to be activated.','cp'); ?>
		</center>
		<?php	

	}
}
	echo "</div>";
} 
?>

<div class="classform" id="formbox" <?php if ($err == "") { echo "style=\"display: none;\""; } ?>>


	<div class='box-yellow'>

		<h3 style="text-align:top;"><img src="<?php bloginfo('template_url'); ?>/images/star.png" border="0" alt="" />&nbsp;	

		<?php 
		// if not charging for any ads 
		if ( get_option('activate_paypal') != "yes" ) { _e('All ad listings are FREE.','cp'); }

		// if paypal is turned on and NO category-level pricing
		elseif ( get_option('cp_price_scheme') == "single" && get_option('activate_paypal') == "yes" ) { ?>
		<?php _e('One ad listing costs','cp'); ?> <strong><?php echo get_option('currency'); ?><?php echo get_option('ad_value'); ?></strong> 
		<?php _e('for','cp'); ?> <strong><?php echo get_option("prun_period"); ?> <?php _e('days.','cp'); ?></strong>
		<?php } 

		// if paypal is turned on and category-level pricing
		elseif ( get_option('cp_price_scheme') == "category" && get_option('activate_paypal') == "yes" ) { ?>
		<?php _e('Ad listing prices vary based on category. List your item for','cp'); ?> <strong><?php echo get_option("prun_period"); ?> <?php _e('days.','cp'); ?></strong> 
		<?php } 
		
		// if paypal is turned on and category-level pricing
		elseif ( get_option('cp_price_scheme') == "percentage" && get_option('activate_paypal') == "yes" ) {?>
		<?php _e('Ad listing price equates to','cp')?> <strong> <?php echo get_option('cp_ad_percent'); ?>%</strong> <?php _e('of your item price. List your item for','cp');?> <strong><?php echo get_option("prun_period"); ?> <?php _e('days.','cp'); ?></strong>
		<?php } ?> 

		</h3><br />


		<?php if(get_option('ads_form_note') != "") { ?>

		<?php echo stripslashes(get_option('ads_form_note')) ?>
		<?php } ?>
	
	</div>


	<form action="" method="post" enctype="multipart/form-data" id="new_post2" name="new_post2">
		<input type="hidden" name="action" value="post" />
		<?php wp_nonce_field( 'new-post' ); ?>

		<div class="left_form">


		
		<label for="cat"><?php _e('Choose a Category','cp'); ?> <span>*</span></label>
		
		<?php if ( get_option('cp_price_scheme') == "category" && get_option('activate_paypal') == "yes" ) { ?>
				<?php cp_dropdown_categories_prices('show_option_none=Select One&orderby=name&order=ASC&hide_empty=0&hierarchical=1'); ?>
		<?php } else { ?>
				<?php wp_dropdown_categories('show_option_none=Select One&orderby=name&order=ASC&hide_empty=0&hierarchical=1'); ?>
		<?php } ?>		
		
				<label for="title"><?php _e('Title','cp'); ?> <span>*</span></label>
				<input type="text" id="title" class="adfields" name="post_title" size="60" maxlength="100" value="<?php echo $_POST['post_title'];?>" />
				
				<label for="price"><?php _e('Price','cp'); ?> <span>*</span> <small><?php _e('(do not enter currency symbol)','cp'); ?></small></label>
				<input type="text" id="price" class="adfields" name="price" size="60" maxlength="100" value="<?php echo $_POST['price']; ?>" />
				
				<label for="location"><?php _e('Location','cp'); ?> <span>*</span></label>
				<input type="text" id="location" class="adfields" name="location" size="60" maxlength="100" value="<?php echo $_POST['location']; ?>" />

				<label for="description"><?php _e('Description','cp'); ?> <span>*</span></label>
				<textarea name="description" id="description" class="adfields" rows="10" cols="46" onkeydown="textCounter(document.new_post2.description,document.new_post2.remLen1,5000)"
				onkeyup="textCounter(document.new_post2.description,document.new_post2.remLen1,5000)"><?php echo $_POST['description']; ?></textarea><br />

				<div class="limit">
					<input disabled="disabled" readonly="readonly" type="text" name="remLen1" size="4" maxlength="4" value="5000" style="width: 40px;" /><span style="font-size:11px;"> <?php _e('characters left','cp'); ?></span>
				</div>


		</div>


<?
	// call this param so we can prefill the form for registered users
	global $current_user;
?>

		
		<div class="right_form">

				<label for="name_owner"><?php _e('Name','cp'); ?> <span>*</span></label>
				<input type="text" id="name_owner" class="adfields" name="name_owner" size="60" maxlength="100" value="<?php if ($current_user->user_firstname != "") { echo $current_user->user_firstname ." ". $current_user->user_lastname; } else { echo $_POST['name_owner']; }?>" />

				<label for="email"><?php _e('Email','cp'); ?> <span>*</span> <small><?php _e('(will not be displayed)','cp'); ?></small></label>
				<input type="text" id="email" class="adfields" name="email" size="60" maxlength="100" value="<?php if ($current_user->user_email != "") { echo $current_user->user_email; } else { echo $_POST['email']; }?>" />		
				
				<label for="phone"><?php _e('Phone','cp'); ?> </label>
				<input type="text" id="phone" class="adfields" name="phone" size="60" maxlength="100" value="<?php echo $_POST['phone']; ?>" />
				
				<label for="post_tags"><?php _e('Tags','cp'); ?> <small><?php _e('(separate with commas)','cp'); ?></small></label>
				<input type="text" id="post_tags" class="adfields" name="post_tags" size="60" maxlength="100" value="<?php echo $_POST['post_tags']; ?>" />	

				<label for="post_tags"><?php _e('URL','cp'); ?> <small><?php _e('(i.e. http://www.mysite.com)','cp'); ?></small></label>
				<input type="text" id="cp_adURL" class="adfields" name="cp_adURL" size="60" maxlength="250" value="<?php echo $_POST['cp_adURL']; ?>" />				
				<label for="post_tags"><?php _e('Add images','cp'); ?> <small>(<?php _e('images must be under 1 MB','cp'); ?>)</small></label>
				<input type="file" name="images[]" class="wwIconified" /><br />

				<br />
				
				<?php if(get_option('cp_featured_ad') != "" && get_option('activate_paypal') == "yes" ) : ?>
				  <div class="extrasbox">
				    <div style="margin:10px 10px 10px 0;">
					  <span class="alignleft" style="padding:10px;"><input name="featured_ad" value="1" type="checkbox" <?php if ($_POST['featured_ad'] == '1') { echo "CHECKED";}  ?> /></span>
					  <strong><?php _e('Featured Listing','cp'); ?> <?php echo get_option('currency'); ?><?php echo get_option('cp_featured_ad'); ?></strong><br />
					  <?php _e('Your listing will appear highlighted in yellow on the front page and category page.','cp'); ?>
				    </div>
				  </div>
				<?php endif; ?>		
				
				
				
				
		</div>		<div style="clear: both;"></div>
		<center>
			<div class="captcha">
				<?php
				$nr1 = rand("0", "9");
				$nr2 = rand("0", "9");
				?>
				<?php echo $nr1; ?> + <?php echo $nr2; ?> = <input type="text" name="total" style="width: 30px; text-align: center; border: 1px #DF0005 solid; padding: 4px;" maxlength="2" value="" /> &nbsp; 
				<input type="hidden" name="nr1" value="892347<?php echo $nr1; ?>" />
				<input type="hidden" name="nr2" value="234543<?php echo $nr2; ?>" />
			</div>
			<input id="submit" type="submit" value="<?php _e('Submit Ad','cp'); ?>" class="postit" />
		</center>
	</form>
</div> <!-- // postbox -->
<?php // } //if the form is ok don't display the form anymore ?>