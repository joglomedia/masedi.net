<script>
function check_frm()
{
	if(document.getElementById('bulk_upload_csv').value == '')
	{
		alert("<?php _e('Please select csv file to upload','templatic');?>");
		return false;
	}
	return true;
}

function update_posttype(ptype){
	if (ptype=="")  {
		document.getElementById("ptype").innerHTML="";
		return;
	}else{
		document.getElementById("ptype").innerHTML= ptype;
	}
	if (window.XMLHttpRequest)  {// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}else {
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
		xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
		document.getElementById("ptype").innerHTML=xmlhttp.responseText;
		}
	} 
	
	url = "<?php echo get_template_directory_uri(); ?>/monetize/manage_settings/ajax_manage_settings.php?ptype="+ptype
	xmlhttp.open("GET",url,true);
	xmlhttp.send();
}
</script>

<?php
$sample_csv = apply_filters('templ_bulk_sample_csv_link_filter', get_template_directory_uri().'/post_sample.csv');
global $wpdb,$current_user;
$dirinfo = wp_upload_dir();
$path = $dirinfo['path'];
$url = $dirinfo['url'];
$subdir = $dirinfo['subdir'];
$basedir = $dirinfo['basedir'];
$baseurl = $dirinfo['baseurl'];
$tmppath = "/csv/";

if(isset($_POST['submit_csv']))
{
	if($_FILES['bulk_upload_csv']['name']!='' && $_FILES['bulk_upload_csv']['error']=='0')
	{
		$filename = $_FILES['bulk_upload_csv']['name'];
		$filenamearr = explode('.',$filename);
		$extensionarr = array('csv','CSV');
		
		if(in_array($filenamearr[count($filenamearr)-1],$extensionarr))
		{
			$destination_path = $basedir . $tmppath;
			if (!file_exists($destination_path))
			{
				mkdir($destination_path, 0777);
			}
			$target_path = $destination_path . $filename;
			$csv_target_path = $target_path;
			if(move_uploaded_file($_FILES['bulk_upload_csv']['tmp_name'], $target_path)) 
			{
				$fd = fopen($target_path, "rt");
				$rowcount = 0;
				$customKeyarray = array();
				while (!feof ($fd))
				{
					$buffer = fgetcsv($fd, 4096);
					if($rowcount == 0)
					{
						/*echo '<pre>';
						print_r($buffer);die;*/
						for($k=0;$k<count($buffer);$k++)
						{
							$customKeyarray[$k] = $buffer[$k];
						}
						if($customKeyarray[0]=='')
						{
							$url = site_url('/wp-admin/admin.php');
							echo '<form action="'.$url.'#option_bulk_upload" method="get" id="frm_bulk_upload" name="frm_bulk_upload">
							<input type="hidden" value="manage_settings" name="page"><input type="hidden" value="bulkupload" name="mod"><input type="hidden" value="wrong" name="emsg">
							</form>
							<script>document.frm_bulk_upload.submit();</script>';exit;
						}
					}else
					{ 
						$userid = trim(iconv('', 'utf-8',$buffer[0]));
						$post_date = trim(iconv('', 'utf-8',$buffer[1]));
						$post_date_gmt = trim(iconv('', 'utf-8',$buffer[2]));
						$post_title = addslashes(iconv('', 'utf-8',$buffer[3]));
						$post_cat = array();
						$catids_arr = array();
						$post_cat = trim(iconv('', 'utf-8',$buffer[4]));
						$post_desc = addslashes(iconv('', 'utf-8',$buffer[7]));					
						$post_excerpt = addslashes(iconv('', 'utf-8',$buffer[8]));						
						$post_status = addslashes(iconv('', 'utf-8',$buffer[9]));						
						$comment_status = addslashes(iconv('', 'utf-8',$buffer[10]));						
						$ping_status = addslashes(iconv('', 'utf-8',$buffer[11]));						
						$post_password = addslashes(iconv('', 'utf-8',$buffer[12]));						
						$post_name = addslashes(iconv('', 'utf-8',$buffer[13]));						
						$to_ping = addslashes(iconv('', 'utf-8',$buffer[14]));						
						$pinged = addslashes(iconv('', 'utf-8',$buffer[15]));						
						$post_modified = addslashes(iconv('', 'utf-8',$buffer[16]));						
						$post_modified_gmt = addslashes($buffer[17]);						
						$post_content_filter = addslashes($buffer[18]);						
						$post_parent = addslashes($buffer[19]);						
						$menu_oreder = addslashes($buffer[20]);	
						
						$my_post_type = $_POST['my_post_type'];
						$post_mime_type = addslashes($buffer[22]);
						$comment_count = addslashes($buffer[23]);
						$company_name =  addslashes(iconv('', 'utf-8',$buffer[24]));
						$website = 	addslashes(iconv('', 'utf-8',$buffer[25]));
						$email = 	addslashes($buffer[26]);
						$logo = 	addslashes($buffer[27]);
						$job_type = 	addslashes($buffer[28]);
						$job_location = addslashes($buffer[29]);
						$geo_address = 	addslashes($buffer[30]);
						$geo_latitude = 	addslashes($buffer[31]);
						$geo_longitude = 	addslashes($buffer[32]);
						$allow_resume = 	addslashes($buffer[33]);
						$paid_amount = 	addslashes($buffer[34]);
						$alive_days = 	addslashes($buffer[35]);
						$payment_method = 	addslashes($buffer[36]);
						$remote_ip = 	addslashes($buffer[37]);
						$ip_status = 	addslashes($buffer[38]);
						$pkg_id = 	addslashes($buffer[39]);
						$featured_type = addslashes($buffer[40]);
						$total_amount = addslashes($buffer[41]);
						$how_to_apply = addslashes($buffer[43]);

						
						if($my_post_type ==  trim(CUSTOM_POST_TYPE2)):
							/*--- Variable for post type2---*/
							$availability = addslashes(iconv('', 'utf-8',$buffer[24]));
							$fname = addslashes(iconv('', 'utf-8',$buffer[25]));
							$lname = addslashes($buffer[26]);
							$experience = addslashes($buffer[27]);
							$geo_address = addslashes($buffer[28]);
							$salary = addslashes($buffer[29]);
							$resuem = addslashes($buffer[30]);
							$remote_ip = 	addslashes($buffer[31]);
							$ip_status = 	addslashes($buffer[32]);
							/*--- Variable for post type2 EOF---*/
						endif;			
						if($post_cat)
						{
							$post_cat_arr = explode('&',$post_cat);
							for($c=0;$c<count($post_cat_arr);$c++)
							{
								$catid = trim($post_cat_arr[$c]);
								if(get_cat_ID($catid))
								{
									$catids_arr[] = get_cat_ID($catid);
								}
							}
						}
						if(!$catids_arr)
						{
							$catids_arr[] = 1;	
						}
						$post_tags = trim($buffer[6]); // comma seperated tags
						$tag_arr = '';
						if($post_tags)
						{
							$tag_arr = explode('&',$post_tags);	
						}
						
						if($post_title!='')
						{
							$my_post['post_title'] = $post_title;
							$my_post['post_content'] = $post_desc;
							if($userid)
							{
								$my_post['post_author'] = $userid;
							}else
							{
								$my_post['post_author'] = $current_user->ID;
							}
							
							$my_post['post_status'] = $post_status;
							$my_post['comment_status'] = $comment_status;
							$my_post['ping_status'] = $ping_status;
							$my_post['post_password'] = $post_password;
							$my_post['post_name'] = $post_name;
							$my_post['to_ping'] = $to_ping;
							$my_post['pinged'] = $pinged;
							$my_post['post_modified'] = $post_modified;
							$my_post['post_modified_gmt'] = $post_modified_gmt;
							$my_post['post_content_filtered'] = $post_content_filtered;
							$my_post['post_parent'] = $post_parent;
							$my_post['menu_order'] = $menu_order;
							$my_post['post_date'] = $post_date;
							$my_post['post_date_gmt'] = $post_date_gmt;
							$my_post['post_excerpt'] = $post_excerpt;
							$my_post['post_type'] = $my_post_type;
							$my_post['post_mime_type'] = $post_mime_type;
							$my_post['comment_count'] = $comment_count;
							$my_post['post_category'] = $catids_arr;
							$my_post['tags_input'] = $tag_arr;
							$last_postid = wp_insert_post( $my_post );
							if($my_post_type!='post'){
								if($my_post_type == trim(CUSTOM_POST_TYPE1)){
									wp_set_object_terms($last_postid, $post_cat_arr, CUSTOM_CATEGORY_TYPE1); //custom category
									wp_set_object_terms($last_postid, $tag_arr, CUSTOM_TAG_TYPE1); //custom tags
								}
								if($my_post_type == trim(CUSTOM_POST_TYPE2)){
									wp_set_object_terms($last_postid, $post_cat_arr, CUSTOM_CATEGORY_TYPE2); //custom category
									wp_set_object_terms($last_postid, $tag_arr, CUSTOM_TAG_TYPE2); //custom tags
								}
								
							}
							
							/*---- If post type is job then enter in below condition ----*/
							if($my_post_type ==  trim(CUSTOM_POST_TYPE1))
							{
								update_post_meta($last_postid,'company_name', $company_name);
								update_post_meta($last_postid,'company_logo', $logo);
								update_post_meta($last_postid,'job_type', $job_type);
								update_post_meta($last_postid,'allow_resume', $allow_resume);
								update_post_meta($last_postid,'job_location', $job_location);
								update_post_meta($last_postid,'address', $geo_address);
								update_post_meta($last_postid,'geo_latitude', $geo_latitude);
								update_post_meta($last_postid,'geo_longitude', $geo_longitude);
								update_post_meta($last_postid,'company_email', $email);
								update_post_meta($last_postid,'paid_amount', $paid_amount);
								update_post_meta($last_postid,'alive_days', $alive_days);
								update_post_meta($last_postid,'paymentmethod', $paymentmethod);
								update_post_meta($last_postid,'remote_ip', $remote_ip);
								update_post_meta($last_postid,'ip_status', $ip_status);
								update_post_meta($last_postid,'pkg_id', $pkg_id);
								update_post_meta($last_postid,'featured_type', $featured_type);
								update_post_meta($last_postid,'total_amount', $total_amount);
								update_post_meta($last_postid,'company_web', $website);
								update_post_meta($last_postid,'how_to_apply', $how_to_apply);
								
								
							}
							
							if($my_post_type ==  trim(CUSTOM_POST_TYPE2))
							 {
								update_post_meta($last_postid,'fname', $fname);
								update_post_meta($last_postid,'lname', $lname);
								update_post_meta($last_postid,'availability', $availability);
								update_post_meta($last_postid,'experience', $experience);
								update_post_meta($last_postid,'address', $geo_address);
								update_post_meta($last_postid,'salary', $salary);
								update_post_meta($last_postid,'attachment', $resuem);
								update_post_meta($last_postid,'remote_ip', $remote_ip);
								update_post_meta($last_postid,'ip_status', $ip_status);

								 
							 }
							/*---- End of condition ----*/
							
							$menu_order = 0;
							$image_folder_name = 'bulk/';
							
							for($c=5;$c<count($customKeyarray);$c++)
							{
								global $wpdb,$custom_post_meta_db_table_name;
								$post_meta_info = $wpdb->get_row("select * from $custom_post_meta_db_table_name where is_active=1 and ( post_type = '".$my_post_type."' or post_type = 'both') and htmlvar_name = '".$customKeyarray[$c]."' and ctype = 'multicheckbox' order by sort_order asc,cid asc");

								if(isset($post_meta_info) && $post_meta_info!= '')
								{
									$array = explode(",",$buffer[$c]);
									update_post_meta($last_postid, $customKeyarray[$c], ($array));
									
								}
								else
								{
									if($customKeyarray[$c]=='featured_type' && $buffer[$c] == '')
									{
										$buffer[$c] = 'n';
									}
									update_post_meta($last_postid, $customKeyarray[$c], addslashes($buffer[$c]));
								}
								if($customKeyarray[$c]=='IMAGE' && isset($buffer[$c]) && $buffer[$c] != '')
								{
									$image_name = $buffer[$c];
									$menu_order = $c+1;
									$image_name_arr = explode(';',$image_name);
									foreach($image_name_arr as $_image_name_arr)
									{
									$img_name = $_image_name_arr;
									$img_name_arr = explode('.',$img_name);
									$post_img = array();
									$post_img['post_title'] = $_image_name_arr;
									$post_img['post_status'] = 'attachment';
									$post_img['post_parent'] = $last_postid;
									$post_img['post_type'] = 'attachment';
									$post_img['post_mime_type'] = 'image/jpeg';
									$post_img['menu_order'] = $menu_order;
									$last_postimage_id = wp_insert_post( $post_img );
									update_post_meta($last_postimage_id, '_wp_attached_file', $image_folder_name.$img_name);
									$post_attach_arr = array(
														"width"	=>	580,
														"height" =>	480,
														"hwstring_small"=> "height='150' width='150'",
														"file"	=> $image_folder_name.$image_name,
														);
									wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
									}
								}else if($customKeyarray[$c] == 'comments_data'){ 
								$time = current_time('mysql');
								$comments = $buffer[$c];
								$comeents_explode = explode('##',$comments);
								foreach($comeents_explode as $comeents_explode_obj){
								$comment_data = explode("~",$comeents_explode_obj);
								$data = array(
										'comment_post_ID' => $last_postid,
										'comment_author' => $comment_data[2],
										'comment_author_email' =>  $comment_data[3],
										'comment_author_url' =>  $comment_data[4],
										'comment_content' =>  $comment_data[8],
										'comment_type' =>  $comment_data[12],
										'comment_parent' =>  $comment_data[13],
										'user_id' =>  $comment_data[14],
										'comment_author_IP' => $comment_data[5],
										'comment_agent' =>  $comment_data[11],
										'comment_date' =>  $comment_data[6],
										'comment_approved' =>  $comment_data[10],
									);

									remove_action('wp_insert_comment', 'save_comment_rating' );
									wp_insert_comment($data);
									$lastid = $wpdb->insert_id;

									$rating = $buffer[$c+1];
									if($rating ){
									$rating_explode = explode('##',$rating);
									foreach($rating_explode as $rating_explode_obj){
									$rating_data = explode("~",$rating_explode_obj);
									
									$rating_postid = $last_postid;
									$rating_posttitle = $rating_data[2];
									if($rating_posttitle  == 'null'){
									$rating_posttitle = $post_title;
									}
									$rating_rating =  $rating_data[3];
									$rating_timestamp =  $rating_data[4];
									if($rating_timestamp == 'null'){
									$rating_timestamp = '';
									}
									$rating_ip =  $rating_data[5];
									if($rating_ip == 'null'){
									$rating_ip = $_SERVER['REMOTE_ADDR'];
									}
									$rating_host =  $rating_data[6];
									if($rating_host == 'null'){
									$rating_host = '';
									}
									$rating_username = $rating_data[7];
									if($rating_username == 'null'){
									$rating_username = '';
									}
									$rating_userid = $rating_data[8];
									if(!$rating_userid || $rating_userid == 'null'){
									$rating_userid = 0;
									}
									$comment_id =$lastid;
									}
									}
								}
								
								}
								
							}
						}
					}				
				$rowcount++;
				}
				@unlink($csv_target_path);
				$url = site_url().'/wp-admin/admin.php';
				echo '<form action="'.$url.'#option_bulk_upload" method="get" id="frm_bulk_upload" name="frm_bulk_upload">
				<input type="hidden" value="manage_settings" name="page"><input type="hidden" value="bulkupload" name="mod"><input type="hidden" value="success" name="upload_msg"><input type="hidden" value="'.$rowcount.'" name="rowcount">
				</form>
				<script>document.frm_bulk_upload.submit();</script>
				';exit;
			}
			else
			{
				$url = site_url().'/wp-admin/admin.php';
				echo '<form action="'.$url.'#option_bulk_upload" method="get" id="frm_bulk_upload" name="frm_bulk_upload">
				<input type="hidden" value="manage_settings" name="page"><input type="hidden" value="bulkupload" name="mod"><input type="hidden" value="tmpfile" name="emsg">
				</form>
				<script>document.frm_bulk_upload.submit();</script>
				';exit;
			}
		}else
		{
			$url = site_url().'/wp-admin/admin.php';
			echo '<form action="'.$url.'#option_bulk_upload" method="get" id="frm_bulk_upload" name="frm_bulk_upload">
			<input type="hidden" value="manage_settings" name="page"><input type="hidden" value="bulkupload" name="mod"><input type="hidden" value="csvonly" name="emsg">
			</form>
			<script>document.frm_bulk_upload.submit();</script>
			';exit;
		}
	}else
	{
		$url = site_url().'/wp-admin/admin.php';
		echo '<form action="'.$url.'#option_bulk_upload" method="get" id="frm_bulk_upload" name="frm_bulk_upload">
		<input type="hidden" value="manage_settings" name="page"><input type="hidden" value="bulkupload" name="mod"><input type="hidden" value="invalid_file" name="emsg">
		</form>
		<script>document.frm_bulk_upload.submit();</script>
		';exit;
	}
}

// BOF Upload Function

define('ABSPATH', dirname(__FILE__) . '/');
$wp_upload_dir = wp_upload_dir();
$basedir = $wp_upload_dir['basedir'];
$baseurl = $wp_upload_dir['baseurl'];
$folderpath = $basedir."/bulk/";
if(!file_exists($folderpath)){
full_copy( TEMPLATEPATH."/images/bulk/", $folderpath );
}
function full_copy( $source, $target ) 
{
	$imagepatharr = explode('/',str_replace(TEMPLATEPATH,'',$target));
	for($i=0;$i<count($imagepatharr);$i++)
	{
	  if($imagepatharr[$i])
	  {
		  $year_path = ABSPATH.$imagepatharr[$i]."/";
		  if (!file_exists($year_path)){
			 @mkdir($year_path, 0777);
		  }     
		}
	}
	if ( is_dir( $source ) ) {
		@mkdir( $target );
		$d = dir( $source );
		while ( FALSE !== ( $entry = $d->read() ) ) {
			if ( $entry == '.' || $entry == '..' ) {
				continue;
			}
			$Entry = $source . '/' . $entry; 
			if ( is_dir( $Entry ) ) {
				full_copy( $Entry, $target . '/' . $entry );
				continue;
			}
			@copy( $Entry, $target . '/' . $entry );
		}
	
		$d->close();
	}else {
		@copy( $source, $target );
	}
}
// EOF Upload Function

?>
<?php

if($_REQUEST['upload_msg']=='success'){ 
$rowcount = $_REQUEST['rowcount'];
$success_msg = '';
$rowcount = $rowcount-2;
if($rowcount > 0)
  {
	$success_msg .=  "<div id=message1 class=updated>".__('<p style="padding-bottom:5px;">CSV uploaded successfully.','templatic');
	$success_msg .= __(sprintf('<br /><b>Total of %s records inserted.</b></p>',$rowcount),'templatic');
	echo $success_msg .= "</div>";
  }
else
  {
 	$success_msg = __(sprintf('<b style="color:red;">No record available .</b>'),'templatic');
	echo $success_msg;
  }
}
?>
<?php
$sample_csv = apply_filters('templ_bulk_sample_csv_link_filter', get_template_directory_uri().'/post_sample.csv');
?> 
<h4><?php _e('Bulk upload','templatic');?></h4>	
<?php
$update_framework = get_option('templatic_new_childtheme');
if(!$update_framework): ?>
<div class="updated settings-error">
   <p style="padding:7px 0px;">
	   <?php
	       $count_message  ="<form name='changecustomptype' id='changecustomptype' method='GET' action=''>";
		   $count_message .= "If you are using older version of JobBoard (2.0 tp 2.5) then please <a href='". site_url()."/wp-admin/admin.php?page=manage_settings&ver-data=1&mod=bulkupload#option_bulk_upload'>Click here</a> to move your <b>post</b> in to <b>Job</b> taxonomy. OR <a href='". site_url()."/wp-admin/admin.php?page=manage_settings&ver-data=-1&mod=bulkupload#option_bulk_upload' onclick='document.changecustomptype.submit()' class='dismiss'>Dismiss</a>";
		   $count_message .="<input type='hidden' name='ver-data' value='1'/></form>";
		   echo $count_message;
		?>
   </p> 
</div>
<?php endif; ?>
<form action="<?php echo site_url('/wp-admin/admin.php')?>?page=manage_settings&mod=bulkupload#option_bulk_upload" method="post" name="bukl_upload_frm" enctype="multipart/form-data">

<input type="hidden" name="ptype" id="ptype" value="post"/>
  <p><?php
  echo _e('You can import listings from another jobboard site in CSV format to this site. To export listings from an older version of this theme, i.e. JobBoard v2 or older, you will have to <a href="#">follow this tutorial</a> to enable the export feature.','templatic');
    ?></p>
   
 <?php if($_REQUEST['emsg']=='csvonly'){?>
 <div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;" >
 <?php _e('Please upload CSV file only.','templatic');?>
 </div>
 <br />
 <?php }?>
 <?php if($_REQUEST['emsg']=='invalid_file'){?>
 <div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;" >
 <?php _e('Please select valid CSV file only for listing bulk upload.','templatic');?>
 </div>
 <br />
 <?php }?>
  <?php if($_REQUEST['emsg']=='tmpfile'){?>
 <div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;" >
 <?php echo $target_path;  echo sprintf(__('Cannot move the bulk upload file to Temporary system folder','templatic').' <b>"%s"</b>. '.__('Please check folder permission should be 0777.','templatic'),$destination_path);?>
 </div>
 <br />
 <?php }?>
  <?php if($_REQUEST['emsg']=='wrong'){?>
 <div class="updated fade below-h2" id="message" style="padding:5px; font-size:11px;" >
 <?php echo $target_path;  _e('File you are uploading is not valid. First column should be "Post Title".','templatic');?>
 </div>
 <br />
 <?php }?>

<p style="background: #f4f4f4; padding:10px; margin-bottom:20px;"><b><?php _e('Import','templatic');?></b></p>
<div class="option option-select"  >
<p style="font-size:13px;"><?php _e('Import Jobs, Resumes and blog posts','templatic');?></p>
    <h3 style="width:163px;"><?php _e('Select post type','templatic');?> : </h3>
    <div class="section">
		<div class="element" style="padding:8px 0px;">
			<input type="radio" value="post" name="my_post_type" checked="checked" /> <?php _e('Post','templatic');?> &nbsp;&nbsp;
			<input type="radio" value="<?php echo CUSTOM_POST_TYPE1; ?>" name="my_post_type" /> <?php echo CUSTOM_MENU_TITLE; ?> &nbsp;&nbsp;
			<input type="radio" value="<?php echo CUSTOM_POST_TYPE2; ?>" name="my_post_type" /> <?php echo CUSTOM_MENU_TITLE2; ?>
   		</div>
	</div>
	<h3 style="width:163px; clear:both;"><?php _e('Select CSV file to upload','templatic');?> : </h3>
    <div class="section">
		<div class="element">
			<input type="file" name="bulk_upload_csv" id="bulk_upload_csv">
   		</div>
		<div class="description"><input type="submit" name="submit_csv" value="<?php _e('Submit','templatic');?>" class="button-framework-imp" onClick="return check_frm();"></div>    
    </div> 
	<div class="section">
		<div class="element">
		<p><?php _e('You can download');?> <a href="<?php echo site_url()?>/?page=csvdl"><?php _e('sample Post CSV file');?></a></p>
        <p><?php _e('You can download');?> <a href="<?php echo site_url()?>/?page=csvdl_job"><?php _e('sample Job CSV file');?></a></p>
        <p><?php _e('You can download');?> <a href="<?php echo site_url()?>/?page=csvdl_resume"><?php _e('sample Resume CSV file');?></a></p>
     
   		</div>
		  
    </div>
	
</div> <!-- #end -->
  
  	
  
</form>

<!-- #end --> 

<!-- It's section to export csv form BOF-->
<p style="background: #f4f4f4; padding:10px; margin-bottom:20px;"><b><?php _e('Export','templatic');?></b></p>	
<div class="option option-select"  >
    <h3 style="width:163px;"><?php _e('Select post type','templatic');?> : </h3>
    <div class="section">
		<div class="element" style="padding:8px 0px;">
			<input type="radio" value="post" name="post_type_export" checked="checked" onclick="update_posttype(this.value)"/> Post &nbsp;&nbsp;
			<input type="radio" value="<?php echo CUSTOM_POST_TYPE1; ?>" name="post_type_export" onclick="update_posttype(this.value)"/> <?php echo CUSTOM_MENU_TITLE; ?> &nbsp;&nbsp;
			<input type="radio" value="<?php echo CUSTOM_POST_TYPE2; ?>" name="post_type_export" onclick="update_posttype(this.value)"/> <?php echo CUSTOM_MENU_TITLE2; ?>
   		</div>
	</div>
	<h3 style="width:163px; clear:both;"></h3>
    <div class="section">
		<div class="description"><a href="<?php echo get_template_directory_uri().'/monetize/manage_settings/export_to_CSV.php';?>" title="Export To CSV" class="button-framework-csv"><?php echo "Export to CSV"; ?></a></div>    </div>
</div> 
<!-- #end -->
<?php
// Custom Category List
function get_inc_categories1($label) {
	$include = '';
	$counter = 0;
	$catsx = get_categories('hide_empty=0');	
	if($catsx )
	{
	foreach ($catsx as $cat) {
		$counter++;		
		if ( get_option( $label.$cat->cat_ID ) ) {
			if ( $counter >= 1 ) { $include .= ','; }
			$include .= $cat->cat_ID;
			}	
	}
	}
	return $include;
}

function get_blog_sub_cats_str1($type='array')
{
	$catid = get_inc_categories1("cat_exclude_");
	$catid_arr = explode(',',$catid);
	$blogcatids = '';
	$subcatids_arr = array();
	for($i=0;$i<count($catid_arr);$i++)
	{
		if($catid_arr[$i])
		{
			$subcatids_arr = array_merge($subcatids_arr,array($catid_arr[$i]),get_term_children( $catid_arr[$i],'category'));
		}
	}
	if($subcatids_arr && $type=='string')
	{
		$blogcatids = implode(',',$subcatids_arr);
		return $blogcatids;	
	}else
	{
		return $subcatids_arr;
	}			
}

global $General,$wpdb,$post;

if($_REQUEST['ver-data'] == -1){
	update_option('templatic_new_childtheme','yes');
}
$blog_cat = get_option("pt_blog_cat");
$blogCatArray = $wpdb->get_results("select term_id from $wpdb->terms where name LIKE '%".$blog_cat."%'");

for($b=0; $b < count($blogCatArray); $b++){ 
	if($b == (count($blogCatArray) - 1))
	{
		$sep = "";
	}
	else
	{
		$sep = ",";
	}
	$b_cat .= "-".$blogCatArray[$b]->term_id.$sep;
	}
$b_pcat = $b_cat;
if($_REQUEST['ver-data'] == 1){
	update_option('templatic_theme','yes');
	$old_posts =  query_posts(array( 'post_type' => 'post','post_status' => 'publish,draft','cat'=>$b_pcat,'posts_per_page'=>-1));
	$select_blog = $wpdb->get_row("SELECT *  FROM $wpdb->terms WHERE `name` LIKE 'Blog'"); 
	$tid = $select_blog->term_id;
	if($tid ==''){ $tid =0;}
		global $posts;
		foreach($old_posts as $new_posts){
		
		$post_id = $new_posts->ID;
		$terms_id = wp_get_post_categories( $post_id );
		$terms_tags_id = wp_get_post_tags($post_id);
		$wpdb->query("UPDATE $wpdb->posts SET `post_type` = '".CUSTOM_POST_TYPE1."' WHERE $wpdb->posts.ID = $post_id LIMIT 1");

		if($terms_id){ 
		for($ti=0;$ti <= count($terms_id); $ti ++ ){
		$cat_id = $terms_id[$ti];
		$term_row = $wpdb->get_var("SELECT term_taxonomy_id from $wpdb->term_taxonomy where $wpdb->term_taxonomy.term_id = $cat_id and $wpdb->term_taxonomy.taxonomy ='category'");
		$tid = $term_row;
		if(!$term_row->term_taxonomy_id)
		{
			$wpdb->query("UPDATE $wpdb->term_relationships SET `term_taxonomy_id` = '".$tid."' WHERE object_id ='".$post_id."'");
			$wpdb->query("UPDATE $wpdb->term_taxonomy SET `taxonomy` = 'jcategory' WHERE $wpdb->term_taxonomy.term_taxonomy_id = $tid");
		}
		}

		}
		
		
		if($terms_tags_id){ 
		for($ti=0;$ti <= count($terms_tags_id); $ti ++ ){
		$tags_id = $terms_tags_id[$ti]->term_id;
		$term_row1 = $wpdb->get_var("SELECT term_taxonomy_id from $wpdb->term_taxonomy where $wpdb->term_taxonomy.term_id = $tags_id and $wpdb->term_taxonomy.taxonomy ='post_tag'");
		$tid1 = $term_row1;
		if(!$term_row1->term_taxonomy_id){
		$wpdb->query("UPDATE $wpdb->term_relationships SET `term_taxonomy_id` = '".$tid1."' WHERE `$wpdb->term_relationships`.`object_id` ='".$post_id."'");
		$wpdb->query("UPDATE $wpdb->term_taxonomy SET `taxonomy` = '".CUSTOM_TAG_TYPE1."' WHERE $wpdb->term_taxonomy.term_taxonomy_id = $tid1");
		}
		}}

		echo "<script>location.href='".site_url()."/wp-admin/edit.php?post_type=".CUSTOM_POST_TYPE1.";</script>";
		}	
}
?>