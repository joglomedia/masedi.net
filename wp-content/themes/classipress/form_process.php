<?php
set_time_limit(0);
if (isset($_POST['action']) && $_POST['action'] == 'post') {

if ( get_option("permissions") == "no" ) {
	if ( !is_user_logged_in() ){
		wp_redirect( get_bloginfo( 'url' ) . '/' );
		exit;
	};
}

	check_admin_referer( 'new-post' );
	$err = ""; $ok = "";
	$user_id 		= $current_user->user_id;
	$post_title 	= cp_filter($_POST['post_title']);
	$post_cat 		= (int)cp_filter($_POST['cat']);
	$post_cat_array	= array("$post_cat");

	if ( get_option('filter_html') == "yes" ) {
		$description 	= trim($_POST['description']);
		// $description 	= addslashes($_POST['description']);
		// $description	= str_replace("javascript", "", $description);
	} else {
		$description 	= cp_filter($_POST['description']);
	}

	$name_ad 		= cp_filter($_POST['name_ad']);
	$phone 			= cp_filter($_POST['phone']);
	$price 			= cp_filter($_POST['price']);
	$location 		= cp_filter($_POST['location']);
	$name 			= cp_filter($_POST['name_owner']);
	$email 			= cp_filter($_POST['email']);
//	$title 			= cp_filter($_POST['title']);
	$post_tags 		= cp_filter($_POST['post_tags']);
	$cp_adURL 		= cp_filter($_POST['cp_adURL']);
	$featured_ad	= cp_filter($_POST['featured_ad']);
	
	$ad_length = get_option("prun_period");
	$expires = date('m/d/Y G:i:s', strtotime("+" . $ad_length . " days"));
	
	
    $images = strip_tags($_POST['images']);

	$total = (int)$_POST['total'];
	$nr1 = (int)$_POST['nr1']; $nr1 = str_replace("892347", "", $nr1);
	$nr2 = (int)$_POST['nr2']; $nr2 = str_replace("234543", "", $nr2);
	$nr1nr2 = $nr1 + $nr2;

	if ( $post_cat == "-1") {
		$err .= __('Please select a category','cp') . "<br />";
	} else {
		global $wpdb;
		$cat_ids = (array) $wpdb->get_col("SELECT `term_id` FROM $wpdb->terms");
		if ( !in_array($post_cat, $cat_ids) && $post_cat != "-1") {
			$err .= __('This category does not exist','cp') . "<br />";
		}
	}
	
	if ($post_title == "" || $post_cat == "" || $price == "" || $location == "" || $name == "" || $email == "" || $description == "") {
		$err .= __('Please fill in all mandatory * fields','cp') . "<br />";
	}
	
	if ( !cp_check_email($email) ) {
		$err .= __('Please enter a valid email','cp') . "<br />";
	}
	
	if ( $total != $nr1nr2 ) {
		$err .= __('The spam field is incorrect','cp') . "<br />";
	}
	
	if ( $err == "" ) {

   //1024 bytes = 1kb
   //1024000 bytes = 1mb
   $image_folder_name = "classipress";
   $size_bytes = 1024000;
   $size_mb = $size_bytes / 1024000;
   $limitedext = array(".gif",".png",".jpg",".jpeg");

		// http://codex.wordpress.org/Function_Reference/wp_upload_dir
		$upload_arr = wp_upload_dir();
		$dir_to_make = trailingslashit($upload_arr['basedir']) . $image_folder_name;
		// $dir_to_make = "wp-content/uploads/classipress";
		$image_baseurl = trailingslashit($upload_arr['baseurl']) . $image_folder_name;
		$image_name = substr(sanitize_title(alphanumericAndSpace($post_title)), 0, 20);
		
		$i = rand();
		$images = "";
		$err2 = "";
		while(list($key,$value) = each($_FILES['images']['name'])) {
			if(!empty($value)) {
				$filename = strtolower($value);
				$filename = str_replace(" ", "-", $filename);
				//get image extension
				$tipul = strrchr($filename,'.');
				$filename = $image_name."-$i".$tipul;
				$add = "$dir_to_make/$filename";
				$image = "$image_baseurl/$filename";
				//$add = "$filename";

           //Make sure that file size is correct
				$file_size = $_FILES['images']['size'][$key]; //getting the right size that coresponds with the image uploaded
           		if ($file_size == "0"){
              		$err2 .= __('The file $value has 0 bytes.','cp') . "<br />";
           		} else {
					if ($file_size > $size_bytes){
              			$err2 .= __('The file $value is bigger than 2MB.','cp') . "<br />";
           			}
           		}
           		//check file extension
           		$ext = strrchr($filename,'.');
           		if ( (!in_array(strtolower($ext),$limitedext)) ) {
              		$err2 .= __('The file $value is not an image.','cp') . "<br />";
           		}


				//echo $_FILES['images']['type'][$key];
				if ( $err2 == "" ) {
					if (!file_exists($dir_to_make)) { mkdir($dir_to_make, 0777); }
					copy($_FILES['images']['tmp_name'][$key], $add);
					chmod("$add",0777);

					//$images .= get_option('home')."/".$add.",";
					$images .= $image . ",";

				}
				$err2 = "";
				$i++;
			}//if empty $value
		}//end while

	$post_code = time();


		if ( get_option('activate_paypal') == "yes" ) {
		
			if (get_option('cp_price_scheme') == "category" ) {
				// if the ad cost is zero AND featured is not checked, then it should automatically be set to published
				$cat_price_check = get_option('cp_cat_price_'.$post_cat); // 0 
				if (($cat_price_check == "0") && ($featured_ad == "")) { $post_status = "publish"; } else { $post_status = "draft"; }
			} else {
				$post_status = "draft";	
			} 

		} else {
			$post_status = get_option("post_status");
		}


		$post_id = wp_insert_post( array(
			'post_author'	=> $user_id,
			'post_title'	=> $post_title,
			'post_content'	=> $description,
			'post_category'	=> $post_cat_array,
			'post_status'	=> $post_status,
			'tags_input'	=> $post_tags
		) );
		
		add_post_meta($post_id, 'location', $location, true);
		add_post_meta($post_id, 'price', $price, true);
		add_post_meta($post_id, 'name', $name, true);
		add_post_meta($post_id, 'email', $email, true);
		add_post_meta($post_id, 'phone', $phone, true);
		add_post_meta($post_id, 'images', $images, true);
		add_post_meta($post_id, 'expires', $expires, true);
		add_post_meta($post_id, 'cp_adURL', $cp_adURL, true);
		
		
		
		if ($featured_ad == 1 ) {
			stick_post($post_id); // if they checked the box and paid for a featured ad, then make the post sticky
		}
		
		$ok = "ok";


		// send notification email
		if ( get_option('notif_ad') == "yes" ) {
			$user_info = get_userdata(1);
			$admin_email = $user_info->user_email;
			$subject2 = __('New ad submission','cp');
			$email2 = __('ClassiPress','cp');
			$body = __('Someone has submitted a new ad. Go to your admin panel to view it.','cp') . "\n\n" . get_option('home')."/wp-admin/edit.php";
			
	    	wp_mail($admin_email,$subject2,$body,"From: $email2");
	    }

		if ( get_option('activate_paypal') == "yes" ) {
			$post_title = str_replace(" ", "+", $post_title);
			wp_redirect( get_bloginfo( 'url' ) . '/?ok=ok&title='.$post_title.'&id='.$post_id.'&catid='.$post_cat.'&fid='.$featured_ad.'&lprice='.$price );
		} else {
			wp_redirect( get_bloginfo( 'url' ) . '/?ok=ok' );
		}
		exit;
	}
}

?>