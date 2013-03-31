<?php
/********************************************************************
You can add your filetes in this file and it will affected.
This is the common filter functions file where you can add you filtes.
********************************************************************/

add_filter('templ_page_title_filter','templ_page_title_fun');
function templ_page_title_fun($title)
{
	return '<h1>'.$title.'</h1>';
}

add_filter('templ_theme_forum_link_filter','templ_theme_forum_link_fun');
function templ_theme_forum_link_fun($forumlink)
{
	$forumlink .= "/test123form_link"; // templatic.com site Forum url here
	return $forumlink;
}

add_filter('templ_admin_menu_title_filter','templ_admin_menu_title_fun');
function templ_admin_menu_title_fun($content)
{
	return $content=__('Job Board','templatic');
}

add_filter('templ_breadcrumbs_navigation_filter','templ_breadcrumbs_navigation_fun');
function templ_breadcrumbs_navigation_fun($bc){
	global $post;
	if($post->post_type == CUSTOM_POST_TYPE1){
		if(strstr($bc,CUSTOM_MENU_TAG_TITLE)) {
			$templ = substr($bc, strrpos($bc,'. &raquo; '.CUSTOM_MENU_TAG_TITLE.':') , strlen($bc));
			$arr = explode('&raquo;',$templ);
			$bc = str_replace($arr[1],'',$bc);
		}	
		$bread = str_replace('. &raquo;',' &raquo;',$bc);
		$bread = str_replace(CUSTOM_MENU_CAT_TITLE.':','',$bread);
		$bread = str_replace(', and',',',$bread);
		$bread = str_replace(' and ',', ',$bread);
		$bread = str_replace(' &raquo;&raquo; ',' &raquo; ',$bread);
		$bread = str_replace(' &raquo;  &raquo; ',' &raquo; ',$bread);
	} else if($post->post_type == CUSTOM_POST_TYPE2){
		if(strstr($bc,CUSTOM_MENU_TAG_TITLE2)) {
			$templ = substr($bc, strrpos($bc,'. &raquo; '.CUSTOM_MENU_TAG_TITLE2.':') , strlen($bc));
			$arr = explode('&raquo;',$templ);
			$bc = str_replace($arr[1],'',$bc);
		}	
		$bread = str_replace('. &raquo;',' &raquo;',$bc);
		$bread = str_replace(CUSTOM_MENU_CAT_TITLE2.':','',$bread);
		$bread = str_replace(', and',',',$bread);
		$bread = str_replace(' and ',', ',$bread);
		$bread = str_replace(' &raquo;&raquo; ',' &raquo; ',$bread);
		$bread = str_replace(' &raquo;  &raquo; ',' &raquo; ',$bread);
	}
	return __($bread,'templatic');	
}

add_action('templ_page_title_above','templ_page_title_above_fun'); //page title above action hook
//add_action('templ_page_title_below','templ_page_title_below_fun');  //page title below action hook
function templ_page_title_above_fun()
{
	templ_set_breadcrumbs_navigation();
}

add_filter('templ_anything_slider_widget_content_filter','templ_anything_slider_content_fun');
function templ_anything_slider_content_fun($post)
{
	$post_img = bdw_get_images_with_info($post->ID,'homeslider');
	  $post_images = $post_img[0]['file'];
	  $attachment_id = $post_img[0]['id'];
	  $attach_data = get_post($attachment_id);
	  $img_title = $attach_data->post_title;
	  if(!$img_title){ $img_title = $post->post_title; }
	  $img_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
	  if(!$img_alt){  $img_alt = $post->post_title; }
	global $thumb_url;
	?>
	<a class="post_img" href="<?php echo get_permalink($post->ID);?>">
	 <img src="<?php echo $post_images;?>" alt="<?php echo $img_alt;?>" title="<?php echo $img_title; ?>"/></a>

    <div class="tslider3_content">
    <h3> <a class="widget-title" href="<?php echo get_permalink($post->ID);?>"><?php echo get_the_title($post->ID);?></a></h3>
    <p>
	<?php echo bm_better_excerpt(605, ' ... ');?></p>
    <p><a href="<?php echo get_permalink($post->ID);?>" class="more"><?php _e('Read More','templatic')?></a></p>
   </div>
	<?php
	$return = ob_get_contents(); // don't remove this code
	ob_end_clean(); // don't remove this code
	return  $return;
}
/************************************
//FUNCTION NAME : templ_set_breadcrumbs_navigation
//ARGUMENTS :arg1=custom seperator, arg2=cutom breadcrumbs content
//RETURNS : breadcrums for each pages
***************************************/
function templ_set_breadcrumbs_navigation($arg1='',$arg2='')
{
	do_action('templ_set_breadcrumbs_navigation');
	if (strtolower(get_option('ptthemes_breadcrumbs'))=='Yes') {  ?>
    <div class="breadcrumb clearfix">
        <div class="breadcrumb_in">
		<?php 
		ob_start();
		yoast_breadcrumb(''.$arg1,''.$arg2);
		$breadcrumb = ob_get_contents();
		ob_end_clean();
		echo apply_filters('templ_breadcrumbs_navigation_filter',$breadcrumb);
		?></div>
    </div>
    <?php }
}

add_filter('templ_widgets_listing_filter','templ_widgets_listing_fun');
function templ_widgets_listing_fun($content)
{
	//print_r($content);
	$content['featured_video']='';
	$content['pika_choose_slider']='';
	$content['anything_slider']='';
	//$content['login']='';
	$content['anything_listing_slider']='';
	$content['nivo_slider']='';
	$content['my_bio']='';
	//$content['social_media']='';
	
	//print_r($content);
	//$content['flickr']='';
	return $content;
}
/** function to add feature of IP security BOF **/
	add_action("admin_init", "admin_init"); 

	function admin_init(){
		add_meta_box("Block IP", "Block IP", "blockip_options", CUSTOM_POST_TYPE1, "normal", "high");
		add_meta_box("Block IP", "Block IP", "blockip_options", CUSTOM_POST_TYPE2, "normal", "high");
	}
/** function to add feature of IP security EOF **/

/*******
 Create the function to output the contents of block ip Widget in add place area-BOF
 *****/
	function blockip_options()
	{ ?>
		<script type="text/javascript" language="javascript">
		/* <![CDATA[ */
		function blockIp(postid)
		{
			window.location = "<?php echo site_url(); ?>/wp-admin/post.php?post="+postid+"&action=edit&blockip="+postid;	
		}
		function unblockIp(postid)
		{
			window.location = "<?php echo site_url(); ?>/wp-admin/post.php?post="+postid+"&action=edit&unblockip="+postid;
		}
		/* ]]> */
		</script>
	<?php
		global $post;
		if($_REQUEST['post_type'] != "")
		{
			echo "<p><strong>" . IP_IS . "</strong>: ".getenv("REMOTE_ADDR") . "</p>";
			echo "<input type='hidden' name='remote_ip' id='remote_ip' value='".getenv("REMOTE_ADDR")."'/>";
			echo "<input type='hidden' name='ip_status' id='ip_status' value='0'/>";
		}else{
		$rip =get_post_meta($post->ID,'remote_ip',true); 
		$ipstatus = get_post_meta($post->ID,'ip_status',true);
		if($rip != "")
		{
		echo "<strong>" . SUBMITTED_IP . "</strong> ".$rip;
		
		global $wpdb,$post; 
			$ipstatus = get_post_meta($post->ID,'ip_status',true);
				if($ipstatus == 0 || $ipstatus == ""){
				$parray = $wpdb->get_results("select * from $wpdb->postmeta where post_id != '".$post->ID."' and meta_value='".$rip."'");
				
					foreach($parray as $pa)
					{ 
						$blocked = get_post_meta($pa->post_id,'ip_status',true);
						if($blocked == 1)
						{
							break;
							return $blocked;
						}
					}
					if($blocked != 0)
					{
						echo "<a href='javascript:void(0)' onclick='unblockIp(".$post->ID.")'> (" . UNBLOCK_IP . ")</a>";
						update_post_meta($post->ID,'ip_status',1);
					}else{ 
						echo "<a href='javascript:void(0)' onclick='blockIp(".$post->ID.")'> (" . BLOCK_IP . ")</a>";
					}
				}else{
				echo "<a href='javascript:void(0)' onclick='unblockIp(".$post->ID.")'> (" . UNBLOCK_IP . ")</a>";
				}
			}else{
			echo IP_NOT_DETECTED;
		}
		}
	}
	if(isset($_REQUEST['blockip']) && $_REQUEST['blockip'] != "")
	{
		global $post,$wpdb;
		$post_id = $_REQUEST['blockip'];
		$rip = get_post_meta($post_id,'remote_ip',true);
		if($rip =="")
		{
			$rip = getenv("REMOTE_ADDR");
			add_post_meta($post_id,'remote_ip',$rip); 
		}
		$ipstatus = get_post_meta($post_id,'ip_status',true);
		$parray = $wpdb->get_results("select * from $wpdb->postmeta where post_id != '".$post_id."' and meta_value='".$rip."'");
		if(mysql_affected_rows() > 0)
		{ 		
			foreach($parray as $parrayobj){ 
			$ips = get_post_meta($parrayobj->post_id,'ip_status',true);
			if($ips == 1)
			{ ?>
				<script> 
				alert("<?php echo IP_BLOCKED; ?>"); 
				window.location = "<?php echo site_url(); ?>/wp-admin/post.php?post=<?php echo $post_id; ?>&action=edit";
				</script>	
			<?php }
			}
		}
		if($rip =="")
		{
			$rip = getenv("REMOTE_ADDR");
			add_post_meta($post_id,'remote_ip',$rip); 
		}
		if($rip != "")
		{ 
			if(!isset($ipstatus)){
				add_post_meta($post_id,'ip_status','1'); 
			}else{ 	
				update_post_meta($post_id,'ip_status','1'); 
			} 
			global $wpdb,$ip_db_table_name;
			$ip_db_table_name = $wpdb->prefix."ip_settings";
			$wpdb->get_row("select * from $ip_db_table_name where ipaddress = '".$rip."'");
			if(mysql_affected_rows() > 0)
			{	
				$wpdb->query("update $ip_db_table_name set ipstatus = '1' where ipaddress = '".$rip."'");
			}else{ 
				$wpdb->query("INSERT INTO $ip_db_table_name (`ipid`, `ipaddress`, `ipstatus`) VALUES (NULL, '".$rip."', '1')");
			}
		} ?>
		<script>location.href = "<?php echo site_url(); ?>/wp-admin/post.php?post="+postid+"&action=edit";</script>
	<?php }elseif(isset($_REQUEST['unblockip']) != "")
	{
		
		$post_id = $_REQUEST['unblockip'];
		update_post_meta($post_id,'ip_status',0);
		$rip = get_post_meta($post_id ,'remote_ip',true);
		$ipstatus = get_post_meta($post_id ,'ip_status',true);
		$parray = $wpdb->get_results("select * from $wpdb->postmeta where post_id != '".$post_id."' and meta_value='".$rip."'");
			global $wpdb,$ip_db_table_name;
			$ip_db_table_name = $wpdb->prefix."ip_settings";
			$wpdb->get_row("select * from $ip_db_table_name where ipaddress = '".$rip."'");
			if(mysql_affected_rows() > 0)
			{
				$wpdb->query("update $ip_db_table_name set ipstatus = '0' where ipaddress = '".$rip."'");
			}else{
				$wpdb->query("INSERT INTO $ip_db_table_name (`ipid`, `ipaddress`, `ipstatus`) VALUES (NULL, '".$rip."', '0')");
			}
		$parray = $wpdb->get_results("select * from $wpdb->postmeta where meta_value='".$rip."'");

		if(mysql_affected_rows() > 0)
		{ 	
			foreach($parray as $parrayobj){ 
			$ips = get_post_meta($parrayobj->post_id,'ip_status',true);
			if($ips == 1)
			{ 
				update_post_meta($parrayobj->post_id,'ip_status',0);
			}
			}
		}
		if($rip != "")
		{	if(!isset($ipstatus)){
					add_post_meta($post_id ,'ip_status','0'); 
			}else{ 	update_post_meta($post_id ,'ip_status','0'); 
			}
		} ?>
		<script>window.location = "<?php echo site_url(); ?>/wp-admin/post.php?post="+postid+"&action=edit";</script>
<?php	} ?>