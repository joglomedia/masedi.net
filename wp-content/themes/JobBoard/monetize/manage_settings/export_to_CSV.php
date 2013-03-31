<?php
$file = dirname(__FILE__);
$file = substr($file,0,stripos($file, "wp-content"));
require($file . "/wp-load.php");
$fname = get_option('post_type_export')."_report_".strtotime(date('Y-m-d')).".csv";
header('Content-Description: File Transfer');
header("Content-type: application/force-download");
header('Content-Disposition: inline; filename="'.$fname.'"');

		function get_post_images($pid)
		{
			$image_array = array();
			$pmeta = get_post_meta($pid, 'key', $single = true);
			if($pmeta['productimage'])
			{
				$image_array[] = $pmeta['productimage'];
			}
			if($pmeta['productimage1'])
			{
				$image_array[] = $pmeta['productimage1'];
			}
			if($pmeta['productimage2'])
			{
				$image_array[] = $pmeta['productimage2'];
			}
			if($pmeta['productimage3'])
			{
				$image_array[] = $pmeta['productimage3'];
			}
			if($pmeta['productimage4'])
			{
				$image_array[] = $pmeta['productimage4'];
			}
			if($pmeta['productimage5'])
			{
				$image_array[] = $pmeta['productimage5'];
			}
			if($pmeta['productimage6'])
			{
				$image_array[] = $pmeta['productimage6'];
			}
			return $image_array;
		}
		
		function get_post_image($post,$img_size='thumb',$detail='',$numberofimgs=6)
		{
			$return_arr = array();
			if($post->ID)
			{
				$images = get_post_images($post->ID);
				if(is_array($images))
				{
					$return_arr = $images;
				}
			}
			$arrImages =&get_children('order=ASC&orderby=menu_order ID&post_type=attachment&post_mime_type=image&post_parent=' . $post->ID );
			if($arrImages) 
			{
				$counter=0;
			   foreach($arrImages as $key=>$val)
			   {
					$counter++;
					$id = $val->ID;
					if($img_size == 'large')
					{
						$img_arr = wp_get_attachment_image_src($id,'full');	// THE FULL SIZE IMAGE INSTEAD
						if(!strstr($post->post_content,$img_arr[0]))
						{
							if($detail)
							{
								$img_arr['id']=$id;
								$return_arr[] = $img_arr;
							}else
							{
								$return_arr[] = $img_arr[0];
							}
						}
					}
					elseif($img_size == 'medium')
					{
						$img_arr = wp_get_attachment_image_src($id, 'medium'); //THE medium SIZE IMAGE INSTEAD
						if(!strstr($post->post_content,$img_arr[0]))
						{
							if($detail)
							{
								$img_arr['id']=$id;
								$return_arr[] = $img_arr;
							}else
							{
								$return_arr[] = $img_arr[0];
							}
						}
					}
					elseif($img_size == 'thumb')
					{
						$img_arr = wp_get_attachment_image_src($id, 'thumbnail'); // Get the thumbnail url for the attachment
						if(!strstr($post->post_content,$img_arr[0]))
						{
							if($detail)
							{
								$img_arr['id']=$id;
								$return_arr[] = $img_arr;
							}else
							{
								$return_arr[] = $img_arr[0];
							}
						}						
					}
			   }
			  return $return_arr;
			}			
		}
global $wpdb,$current_user;
$post_table = $wpdb->prefix."posts";
$post_meta_table = $wpdb->prefix."postmeta";

$authorsql_select = "select DISTINCT p.ID,p.*";
$authorsql_from= " from $post_table p,$post_meta_table pm";
$authorsql_conditions= " where p.post_type = '".get_option('post_type_export')."' and p.post_status='publish' and p.ID = pm.post_id";
$authorinfo = $wpdb->get_results($authorsql_select.$authorsql_from.$authorsql_conditions);
if(get_option('post_type_export') == CUSTOM_POST_TYPE1)
{
	$post_cat_type = CUSTOM_CATEGORY_TYPE1;
	$post_tag_type = CUSTOM_TAG_TYPE1;
}elseif(get_option('post_type_export') == CUSTOM_POST_TYPE2){
	$post_cat_type = CUSTOM_CATEGORY_TYPE2;
	$post_tag_type = CUSTOM_TAG_TYPE2;
}
else{
	$post_cat_type = 'category';
	$post_tag_type = 'post_tag';
}

$old_pattern = array("/[^a-zA-Z0-9-:;<>\/=.& ]/", "/_+/", "/_$/");
$new_pattern = array("_", "_", "");

$file_name = strtolower(preg_replace($old_pattern, $new_pattern , $text_title));
if(get_option('post_type_export') == CUSTOM_POST_TYPE1)
{
	if($authorinfo)
	{
	$header_top =  "Post_author,post_date,post_date_gmt,post_title,category,IMAGE,tags,post_content,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,menu_order,post_type,post_mime_type,comment_count,company name,website,email,logo,job type,geo_address,geo_latitude,geo_longitude,how to apply,allow_resume,paid_amount,alive_days,paymentmethod,remote_ip,ip_status,pkg_id,featured_type,total_amount";
	echo $header_top .= ",comments_data"." \r\n";
		foreach($authorinfo as $postObj)
		{
		global $post,$wpdb;
		$product_image_arr = get_post_image($postObj,'large','',5);
		$image = '';
		if(count($product_image_arr)>1)
		{
			foreach($product_image_arr as $_product_image_arr)
				{
				  $image .= basename($_product_image_arr).";";
				}
			$image = substr($image,0,-1);
		}
		$post_title =  preg_replace($old_pattern, $new_pattern , $postObj->post_title); 
		$post_date =  $postObj->post_date;
		$post_date_gmt = $postObj->post_date_gmt;
		$post_content = preg_replace($old_pattern, $new_pattern , $postObj->post_content);
		$post_excerpt = preg_replace($old_pattern, $new_pattern , $postObj->post_excerpt);
		$is_featured =  preg_replace($old_pattern, $new_pattern , get_post_meta($postObj->ID,'is_featured',true));
		$company_name =  get_post_meta($postObj->ID,'company_name',true);
		$company_web =  get_post_meta($postObj->ID,'company_web',true);
		$company_email =  get_post_meta($postObj->ID,'company_email',true);
		$company_logo =  get_post_meta($postObj->ID,'company_logo',true);
		$job_type =  get_post_meta($postObj->ID,'job_type',true);
		$geo_address =  preg_replace($old_pattern, $new_pattern , get_post_meta($postObj->ID,'address',true));
		$geo_latitude = get_post_meta($postObj->ID,'geo_latitude',true);
		$geo_longitude = get_post_meta($postObj->ID,'geo_longitude',true);
		$allow_resume =  get_post_meta($postObj->ID,'allow_resume',true);
		$paid_amount = preg_replace($old_pattern, $new_pattern , get_post_meta($postObj->ID,'paid_amount',true));
		$alive_days =  preg_replace($old_pattern, $new_pattern , get_post_meta($postObj->ID,'alive_days',true));
		$paymentmethod = preg_replace($old_pattern, $new_pattern , get_post_meta($postObj->ID,'paymentmethod',true));
		$remote_ip = get_post_meta($postObj->ID,'remote_ip',true);
		$ip_status =  get_post_meta($postObj->ID,'ip_status',true);
		$pkg_id =  get_post_meta($postObj->ID,'pkg_id',true);
		$featured_type =  get_post_meta($postObj->ID,'featured_type',true);
		$total_amount = get_post_meta($postObj->ID,'total_amount',true);
		$how_to_apply = preg_replace($old_pattern, $new_pattern ,get_post_meta($postObj->ID,'how_to_apply',true));
		
		
		$udata = get_userdata($postObj->post_author);
		$category_array = wp_get_post_terms($postObj->ID,$taxonomy = $post_cat_type, array('fields' => 'names'));
		$category = '';
		if($category_array){
			$category =implode('&',$category_array);
		}
		$tag_array = wp_get_post_terms($postObj->ID,$taxonomy = $post_tag_type, array('fields' => 'names'));
		$tags = '';
		if($tag_array){
			$tags =implode('&',$tag_array);
		}
		$args = array('post_id'=>$postObj->ID);
		$comments_data = get_comments( $args );
		//*--fetch comments ----*//;
	
		if($comments_data){
		foreach($comments_data as $comments_data_obj){
			foreach($comments_data_obj as $_comments_data_obj)
			  {
				if($_comments_data_obj ==""){
				$_comments_data_obj = "null";
				}
				 $newarray .= $_comments_data_obj."~";
			  }
			  $newarray .="##";
		}
		$newarray = str_replace(','," ",$newarray);
		}else{
		$newarray = "";
		}
	
		$content_1 =  "$postObj->post_author,$post_date,$post_date_gmt,$post_title,$category,$image,$tags,$post_content,$post_excerpt,$postObj->post_status,$postObj->comment_status,$postObj->ping_status,$postObj->post_password,$postObj->post_name,$postObj->to_ping,$postObj->pinged,$postObj->post_modified,$postObj->post_modified_gmt,$postObj->post_content_filtered,$postObj->post_parent,$postObj->menu_order,$postObj->post_type,$postObj->post_mime_type,$postObj->comment_count,$company_name,$company_web,$company_email,$company_logo,$job_type,$geo_address,$geo_latitude,$geo_longitude,$how_to_apply,$allow_resume,$paid_amount,$alive_days,$paymentmethod,$remote_ip,$ip_status,$pkg_id,$featured_type,$total_amount";
		$content_1 .= ",$newarray";
		echo $content_1." \r\n";
		}
	}else
	{
	echo "No record available";
	
	}
}
elseif(get_option('post_type_export') == CUSTOM_POST_TYPE2)
{
		if($authorinfo)
	{
	$header_top =  "Post_author,post_date,post_date_gmt,post_title,category,IMAGE,tags,post_content,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,menu_order,post_type,post_mime_type,comment_count,availability,first name,last name,experience,geo_address,salary,resuem,remote_ip,ip_status,pkg_id";
	echo $header_top .= ",comments_data"." \r\n";
		foreach($authorinfo as $postObj)
		{
		global $post,$wpdb;
		$product_image_arr = get_post_image($postObj,'large','',5);
		$image = '';
		if(count($product_image_arr)>1)
		{
			foreach($product_image_arr as $_product_image_arr)
				{
				  $image .= basename($_product_image_arr).";";
				}
			$image = substr($image,0,-1);
		}
		$post_title =  preg_replace($old_pattern, $new_pattern , $postObj->post_title); 
		$post_date =  $postObj->post_date;
		$post_date_gmt = $postObj->post_date_gmt;
		$post_content = preg_replace($old_pattern, $new_pattern , $postObj->post_content);
		$post_excerpt = preg_replace($old_pattern, $new_pattern , $postObj->post_excerpt);
		$availability =  get_post_meta($postObj->ID,'availability',true);
		$fname =  get_post_meta($postObj->ID,'fname',true);
		$lname =  get_post_meta($postObj->ID,'lname',true);
		$experience =  get_post_meta($postObj->ID,'experience',true);
		$geo_address =  preg_replace($old_pattern, $new_pattern , get_post_meta($postObj->ID,'address',true));
		$salary =  get_post_meta($postObj->ID,'salary',true);
		$resume =  get_post_meta($postObj->ID,'attachement',true);
		$remote_ip = get_post_meta($postObj->ID,'remote_ip',true);
		$ip_status =  get_post_meta($postObj->ID,'ip_status',true);
		$pkg_id =  get_post_meta($postObj->ID,'pkg_id',true);
		
		$udata = get_userdata($postObj->post_author);
		$category_array = wp_get_post_terms($postObj->ID,$taxonomy = $post_cat_type, array('fields' => 'names'));
		$category = '';
		if($category_array){
			$category =implode('&',$category_array);
		}
		$tag_array = wp_get_post_terms($postObj->ID,$taxonomy = $post_tag_type, array('fields' => 'names'));
		$tags = '';
		if($tag_array){
			$tags =implode('&',$tag_array);
		}
		$args = array('post_id'=>$postObj->ID);
		$comments_data = get_comments( $args );
		//*--fetch comments ----*//;
	
		if($comments_data){
		foreach($comments_data as $comments_data_obj){
			foreach($comments_data_obj as $_comments_data_obj)
			  {
				if($_comments_data_obj ==""){
				$_comments_data_obj = "null";
				}
				 $newarray .= $_comments_data_obj."~";
			  }
			  $newarray .="##";
		}
		$newarray = str_replace(','," ",$newarray);
		}else{
		$newarray = "";
		}
	
		$content_1 =  "$postObj->post_author,$post_date,$post_date_gmt,$post_title,$category,$image,$tags,$post_content,$post_excerpt,$postObj->post_status,$postObj->comment_status,$postObj->ping_status,$postObj->post_password,$postObj->post_name,$postObj->to_ping,$postObj->pinged,$postObj->post_modified,$postObj->post_modified_gmt,$postObj->post_content_filtered,$postObj->post_parent,$postObj->menu_order,$postObj->post_type,$postObj->post_mime_type,$postObj->comment_count,$availability,$fname,$lname,$experience,$geo_address,$salary,$resume,$remote_ip,$ip_status,$pkg_id";
		$content_1 .= ",$newarray";
		echo $content_1." \r\n";
		}
	}else
	{
	echo "No record available";
	
	}
	
}
else
{
  	if($authorinfo)
	{
	$header_top =  "Post_author,post_date,post_date_gmt,post_title,category,IMAGE,tags,post_content,post_excerpt,post_status,comment_status,ping_status,post_password,post_name,to_ping,pinged,post_modified,post_modified_gmt,post_content_filtered,post_parent,menu_order,post_type,post_mime_type,comment_count";
	echo $header_top .= ",comments_data"." \r\n";
		foreach($authorinfo as $postObj)
		{
		global $post,$wpdb;
		$product_image_arr = get_post_image($postObj,'large','',5);
		$image = '';
		if(count($product_image_arr)>1)
		{
			foreach($product_image_arr as $_product_image_arr)
				{
				  $image .= basename($_product_image_arr).";";
				}
			$image = substr($image,0,-1);
		}
		$post_title =  preg_replace($old_pattern, $new_pattern , $postObj->post_title); 
		$post_date =  $postObj->post_date;
		$post_date_gmt = $postObj->post_date_gmt;
		$post_content = preg_replace($old_pattern, $new_pattern , $postObj->post_content);
		$post_excerpt = preg_replace($old_pattern, $new_pattern , $postObj->post_excerpt);
		
		$udata = get_userdata($postObj->post_author);
		$category_array = wp_get_post_terms($postObj->ID,$taxonomy = $post_cat_type, array('fields' => 'names'));
		$category = '';
		if($category_array){
			$category =implode('&',$category_array);
		}
		$tag_array = wp_get_post_terms($postObj->ID,$taxonomy = $post_tag_type, array('fields' => 'names'));
		$tags = '';
		if($tag_array){
			$tags =implode('&',$tag_array);
		}
		$args = array('post_id'=>$postObj->ID);
		$comments_data = get_comments( $args );
		//*--fetch comments ----*//;
	
		if($comments_data){
		foreach($comments_data as $comments_data_obj){
			foreach($comments_data_obj as $_comments_data_obj)
			  {
				if($_comments_data_obj ==""){
				$_comments_data_obj = "null";
				}
				 $newarray .= $_comments_data_obj."~";
			  }
			  $newarray .="##";
		}
		$newarray = str_replace(','," ",$newarray);
		}else{
		$newarray = "";
		}
	
		$content_1 =  "$postObj->post_author,$post_date,$post_date_gmt,$post_title,$category,$image,$tags,$post_content,$post_excerpt,$postObj->post_status,$postObj->comment_status,$postObj->ping_status,$postObj->post_password,$postObj->post_name,$postObj->to_ping,$postObj->pinged,$postObj->post_modified,$postObj->post_modified_gmt,$postObj->post_content_filtered,$postObj->post_parent,$postObj->menu_order,$postObj->post_type,$postObj->post_mime_type,$postObj->comment_count";
		$content_1 .= ",$newarray";
		echo $content_1." \r\n";
		}
	}else
	{
	echo "No record available";
	
	}
	
}
	?>