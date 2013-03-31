<?php session_start();

global $upload_folder_path;
if($_POST)
{
	if(!is_int($_POST['total_price']) && $_POST['total_price']<0)
	{ ?>
	<script>
	alert('<?php _e('Price is Invalid,please select valid price','templatic');?>');
	window.location= '<?php echo site_url(); ?>'+'/?page=postajob&backandedit=1';</script>
<?php
	}
	$job_name = $_POST['position_title'];
	$company_name = $_POST['company_name'];
	$company_web = $_POST['company_web'];
	$company_email = $_POST['company_email'];
	$job_type = $_POST['job_type'];
	$address = $_POST['address'];
	$geo_latitude = $_POST['geo_latitude'];
	$geo_longitude = $_POST['geo_longitude'];
	$job_desc = $_POST['job_desc'];
	$how_to_apply = $_POST['how_to_apply'];
	$job_add_coupon = $_POST['job_add_coupon'];
	$position_filled = $_POST['position_filled'];
	

	if(is_array($_POST['category'])){
		$cat_array1 = implode("-",$_POST['category']);
		$cat_array2 = explode("-",$cat_array1) ;
		$tc= count($cat_array2 );
		$allcat ="";
		for($i=0; $i<=$tc; $i++ )
		{
			//echo $cat_array2[$i];
			$allc = explode(',',$cat_array2[$i]);
			if($allc[0] != ""){
			$allc1 .= $allc[0].","; }

		}
		$cat = explode(',',$allc1);

	}else{
		$cat = $_POST['category'];
	}
	$sep = "";
	$a = "";
	$cat1 = "";
	$_SESSION['job_info'] = $_POST;
	if($current_user->ID ==''){
			if ($_POST['user_email'] == '' ){
			$_SESSION['userinset_error'] = array();
			$_SESSION['userinset_error'][] = __('Email for Contact Details is Empty. Please enter Email, your all informations will sent to your Email.','templatic');
			wp_redirect(site_url().'/?page=postajob&backandedit=1&usererror=1');
			exit;
			}
		require( 'wp-load.php' );
		require(ABSPATH.'wp-includes/registration.php');
		$creds = array();
		$creds['user_login'] = $_POST['user_fname'];
		wp_signon($creds, false);
		
		global $wpdb;
		$errors1 = new WP_Error();
		
		$user_email = $_POST['user_email'];
		$user_fname = $_POST['user_fname'];
		$user_login = $user_fname;	
		$user_login = sanitize_user( $user_login );
		$user_email = apply_filters( 'user_registration_email', $user_email );
		
		// Check the username
		if ( $user_login == '' )
			$errors1->add('empty_username', __('ERROR: Please enter a username.'));
		elseif ( !validate_username( $user_login ) ) {
			$errors1->add('invalid_username', __('<strong>ERROR</strong>: This username is invalid.  Please enter a valid username.'));
			$user_login = '';
		} elseif ( username_exists( $user_login ) )
			$errors1->add('username_exists', __('<strong>ERROR</strong>: '.$user_login.' This username is already registered, please choose another one.'));

		// Check the e-mail address
		if ($user_email == '') {
			$errors1->add('empty_email', __('<strong>ERROR</strong>: Please type your e-mail address.'));
		} elseif ( !is_email( $user_email ) ) {
			$errors1->add('invalid_email', __('<strong>ERROR</strong>: The email address isn&#8217;t correct.'));
			$user_email = '';
		} elseif ( email_exists( $user_email ) )
			$errors1->add('email_exists', __('<strong>ERROR</strong>: '.$user_email.' This email is already registered, please choose another one.'));

		do_action('register_post', $user_login, $user_email, $errors1);	
		
		//$errors1 = apply_filters( 'registration_errors', $errors1 );
		if($errors1)
		{
			$_SESSION['userinset_error'] = array();
			foreach($errors1 as $errorsObj)
			{
				foreach($errorsObj as $key=>$val)
				{
					for($i=0;$i<count($val);$i++)
					{
						$_SESSION['userinset_error'][] = $val[$i];
						if($val[$i]){break;}
					}
				} 
			}
		}	
		if ($errors1->get_error_code() )
		{
			wp_redirect(site_url().'/?page=postajob&backandedit=1&usererror=1');
			exit;
		}
	}	/**registration validation for user EOF**/
	
}
else
{
 if($_REQUEST['pid'])
	{
		$is_delet_job = 1;
	}
}
$pcd = explode(',',get_option('ptthemes_captcha_dislay'));
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if((in_array('Post a Job page',$pcd) || in_array('Both',$pcd)) && is_plugin_active('wp-recaptcha/wp-recaptcha.php')){
		require_once( ABSPATH.'wp-content/plugins/wp-recaptcha/recaptchalib.php');
		$a = get_option("recaptcha_options");
		$privatekey = $a['private_key'];
  						$resp = recaptcha_check_answer ($privatekey,
                                getenv("REMOTE_ADDR"),
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
								
		if (!$resp->is_valid ) {
			wp_redirect(site_url().'/?page=postajob&backandedit=1&ecptcha=captch');
			exit;
		} 
	}
?>
<?php get_header(); ?>
<div id="page">
<div id="content-wrap" class="clear <?php if(get_option("ptthemes_page_layout") == "Right Sidebar") { echo "right-side"; } else { echo "left-side"; } ?>" >
<div id="content">
<?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') { ?><div class="breadcums"><ul class="page-nav"><li><?php  yoast_breadcrumb('',''); ?></li></ul></div><?php } ?>
<?php include (TEMPLATEPATH . "/monetize/job/job_preview_buttons.php");?>
         <div class="newlisting newlisting-block">
         <h1><?php echo $job_name; ?></h1>
         <?php
		 if($_FILES['company_logo']['name'])
		  {
        	$logo = get_company_logo($_FILES);
			$_SESSION['file_info'] = $logo;
		  }
		 ?>
         <div class="detail_list">
        	<?php if($_SESSION['file_info']): ?>
		        <a href="<?php the_permalink(); ?>" class="img"><img src="<?php echo $_SESSION['file_info']; ?>" width="100" height="100"  border="0" class="company_logo" /></a>
			<?php else: ?>
	             <a href="<?php the_permalink(); ?>" class="img"><img src="<?php bloginfo("template_directory"); ?>/images/no-image.png" alt="" /></a>
            <?php endif; ?>
			<div class="col_right">
           
        <!-- custom Information starts -->
			<?php	
				global $custom_post_meta_db_table_name;
				$sql = "select * from $custom_post_meta_db_table_name where is_active=1  and (post_type='".CUSTOM_POST_TYPE1."' or post_type='both')";
				if($fields_name)
				{
					$fields_name = '"'.str_replace(',','","',$fields_name).'"';
					$sql .= " and htmlvar_name in ($fields_name) ";
				}
				$sql .=  " order by sort_order asc,cid asc";
				$post_meta_info = $wpdb->get_results($sql);
				foreach($post_meta_info as $post_meta_info_obj){
					if($post_meta_info_obj->ctype =='text' || $post_meta_info_obj->ctype =='texteditor' || $post_meta_info_obj->ctype =='textarea' || $post_meta_info_obj->ctype =='date' || $post_meta_info_obj->ctype =='multicheckbox' || $post_meta_info_obj->ctype =='radio' || $post_meta_info_obj->ctype =='select'){
						if($_SESSION['job_info'][$post_meta_info_obj->htmlvar_name] != ""){
							if($post_meta_info_obj->htmlvar_name != "category" && $post_meta_info_obj->htmlvar_name != "address" && $post_meta_info_obj->htmlvar_name != "geo_latitude" && $post_meta_info_obj->htmlvar_name != "geo_longitude" && $post_meta_info_obj->htmlvar_name != "position_title" && $post_meta_info_obj->htmlvar_name != "position_filled")
								{
									if($post_meta_info_obj->ctype =='texteditor') {
									   if($post_meta_info_obj->htmlvar_name == 'job_desc')
										  {
											 $job_desc =  $_SESSION['job_info'][$post_meta_info_obj->htmlvar_name];
										  }
										elseif($post_meta_info_obj->htmlvar_name == 'how_to_apply')
										  {
                                        	 $how_to_apply =  $_SESSION['job_info'][$post_meta_info_obj->htmlvar_name];
										  }
										else
										  {
 											 echo "<div class='text-editor'><span>".$post_meta_info_obj->site_title."</span> ".$_SESSION['job_info'][$post_meta_info_obj->htmlvar_name]."</div>";  
										  }
                                    }
									elseif($post_meta_info_obj->ctype =='textarea') {
	                                         echo "<p><span>".$post_meta_info_obj->site_title."</span></p><p class='text-width'> ".$_SESSION['job_info'][$post_meta_info_obj->htmlvar_name]."</p>";
                                    }
									else {
										if($post_meta_info_obj->ctype == 'multicheckbox'):
										    $checkArr = $_SESSION['job_info'][$post_meta_info_obj->htmlvar_name];
											if($checkArr):
												foreach($checkArr as $_checkArr)
												{
													$check .= $_checkArr.",";
												}
											endif;	
											$check = substr($check,0,-1);
											echo "<p><span>".$post_meta_info_obj->site_title."</span></p><p class='text-width'> ".$check."</p></li>";
										else:
                                        	echo "<p><span>".$post_meta_info_obj->site_title."</span></p><p class='text-width'> ".stripslashes($_SESSION['job_info'][$post_meta_info_obj->htmlvar_name])."</p></li>";
										endif;	
                                    } 
						}?>
					 <?php  $i++;
					 }	
					 }
		}
		?>
        <div class="clear"></div>
        </div>
        </div>
        <h3> <?php _e('Description');?> : </h3>
		<?php echo $job_desc; ?>
        <h3><?php _e('How to apply','templatic');?> : </h3>
        <p><?php echo $how_to_apply; ?></p>
		<?php
        if($address)
        {
        ?>
			<div class="row">
                <div class="title_space">
                    <div class="title-container">
                        <h3><span><?php echo JOB_MAP_TEXT;?></span></h3>
                        <div class="clearfix"></div>
                    </div>
                    <p><strong><?php _e('Location : '); echo $add_str;?></strong></p>
                </div>
				<div id="gmap" class="graybox img-pad">
            <?php if($geo_longitude &&  $geo_latitude):
					$title = $job_name;
					$address = $address;
				 	$pimg = $logo;
					if(!$pimg):
						$pimg = get_template_directory_uri()."/images/no-image.png";
					endif;	
					$more = VIEW_MORE_DETAILS_TEXT;
                    require_once (TEMPLATEPATH . '/library/map/preview_map.php');
					$retstr .= "<img src=\"$pimg\" width=\"140\" height=\"140\" alt=\"\" />";
					$retstr .= "<h1><a href=\"\" class=\"ptitle\" style=\"color:#444444;font-size:16px;\"><span>$title</span></a></h1>";
					if($address){$retstr .= "<span style=\"font-size:10px;\">$address</span>";}
                    preview_address_google_map($geo_latitude,$geo_longitude,$retstr);
            	  else:
			?>
            		<iframe src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo $address;?>&amp;ie=UTF8&amp;z=14&amp;iwloc=A&amp;output=embed" height="358" width="100%" scrolling="no" frameborder="0" ></iframe>
            <?php endif; ?>
</div>
			</div>
		<?php }?>
	</div>
<br/>   
<?php if(!$_REQUEST['pid']):?>
	<?php include (TEMPLATEPATH . "/monetize/job/job_preview_buttons.php");?>
<?php endif; ?>
</div>
<div id="sidebar">
    <?php dynamic_sidebar("post-job-sidebar"); ?>
</div>
<?php get_footer(); ?>