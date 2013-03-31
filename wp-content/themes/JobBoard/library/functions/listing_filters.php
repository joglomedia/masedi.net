<?php
if(strstr($_SERVER['REQUEST_URI'],'/wp-admin/'))
{
	remove_filter('pre_get_posts', 'search_filter');
}
add_action('pre_get_posts', 'custom_post_author_archive');

/* Set post type while search for jobs BOF */
function custom_post_author_archive( &$query )
{
	if(is_search()){
		$ptype = $_REQUEST['post_type'];
		if($ptype == 'job' || !isset($ptype)){
		$query->set('post_type', array('job','attachment'));
		}else if($ptype =='resume'){
		$query->set('post_type', array('resume','attachment'));
		}
	}
	if(!strstr($_SERVER['REQUEST_URI'],'/wp-admin/'))
	 {
		add_action('pre_get_posts', 'search_filter');
		add_action('pre_get_posts', 'jobs_filter');
	 }
}
/* Set post type while search for jobs EOF */

function search_filter($local_wp_query)
{
	if(is_author() && !is_search())
	  {
		global $current_user,$wp_query;
		$qvar = $wp_query->query_vars;
		$authname = $qvar['author_name'];
		$nicename = $current_user->user_nicename;
		add_filter('posts_where', 'author_filter_where');
		add_filter('posts_orderby', 'author_filter_orderby');
	  }
	if(is_tax())
	{
	  add_filter('posts_orderby', 'category_filter_orderby');
	}
	if(isset($_REQUEST['adv_search']) && $_REQUEST['adv_search'] !='')
	{
		add_filter('posts_where', 'searching_filter_where');
	}
	if(is_search()){
		add_filter('posts_where', 'searching_filter_where');
	}
	if (is_home() && $_REQUEST['page'] != 'resume')
	{
		add_filter('posts_where', 'home_post_where');
		add_filter('posts_orderby', 'home_post_orderby');
	}
	else
	{
		remove_filter('posts_where', 'post_where');
		remove_filter('posts_orderby', 'home_post_orderby');
	}

}

function author_filter_where($where)
{
	global $wpdb,$current_user,$curauth,$wp_query;
	$query_var = $wp_query->query_vars;
	$user_id = $query_var['author'];
	$role =  $current_user->roles[0];
	if($role == "Job Provider")
	  {	
		$where = " AND ($wpdb->posts.post_author = $user_id) AND ( $wpdb->posts.post_type ='job') AND ($wpdb->posts.post_status = 'publish' OR $wpdb->posts.post_status = 'draft')";
	  }
	elseif($role == "Job Seeker")
	  {
		$where = " AND ($wpdb->posts.post_author = $user_id) AND ( $wpdb->posts.post_type ='resume') AND ($wpdb->posts.post_status = 'publish' OR $wpdb->posts.post_status = 'draft')"; 
	  }
	else
	  {
		 $where = " AND ($wpdb->posts.post_author = $user_id) AND ( $wpdb->posts.post_type ='post') AND ($wpdb->posts.post_status = 'publish' OR $wpdb->posts.post_status = 'draft')";  
	  }
	return $where;
}

function author_filter_orderby($orderby) {
	global $wpdb;
	$orderby = " $wpdb->posts.post_date DESC"; 
	return $orderby;
}
function category_filter_orderby($orderby)
{
	global $wpdb;
	//$orderby = "(select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key = 'featured_c') ASC,post_date DESC";
	$orderby = "(SELECT $wpdb->postmeta.meta_value from $wpdb->postmeta where ($wpdb->posts.ID = $wpdb->postmeta.post_id) AND $wpdb->postmeta.meta_key = 'featured_c' AND $wpdb->postmeta.meta_value = 'c') DESC,$wpdb->posts.ID DESC";
	return $orderby;
}

function home_post_where($where)
{
	global $wpdb,$wp_query;
	$where = " AND $wpdb->posts.post_type = '".CUSTOM_POST_TYPE1."' AND $wpdb->posts.post_status = 'publish' ";
	return $where;
}

function home_post_orderby($orderby) {
	global $wpdb,$current_term,$wp_query;
	$orderby = "(SELECT $wpdb->postmeta.meta_value from $wpdb->postmeta where ($wpdb->posts.ID = $wpdb->postmeta.post_id) AND $wpdb->postmeta.meta_key = 'featured_h' AND $wpdb->postmeta.meta_value = 'h') DESC,$wpdb->posts.ID DESC"; 
	return $orderby;	
}
/**-- serching fiter where for location and radious wise searching --**/
function searching_filter_where($where){
	global $wpdb,$wp_query;
	$search = str_replace(' ','',$_REQUEST['location']);
	$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$search.'&sensor=false');
	$wp_query->set('post_type', array('post','job','attachment'));
	$output= json_decode($geocode);
	$scat = trim($_REQUEST['catdrop']);
	$stag = trim($_REQUEST['tag_s']);
	$articleauthor = trim($_REQUEST['articleauthor']);
	$ptype = $_REQUEST['post_type'];
	$s_tag = $_REQUEST['tag_s'];
	$lat = $output->results[0]->geometry->location->lat;
	$long = $output->results[0]->geometry->location->lng;
	$miles = $_REQUEST['radius'];
	
	if(strtolower(get_option('pttthemes_milestone_unit')) == strtolower('Kilometer')){
		$miles = $_REQUEST['radius'] * 0.621;
	}else{
		$miles = $_REQUEST['radius'];	
	}
	
	$tbl_postcodes = $wpdb->prefix . "postcodes";
	$adv_search = $_REQUEST['adv_search'];
	if(($ptype == CUSTOM_POST_TYPE1 OR !isset($ptype)) && $adv_search==''){
		if($_REQUEST['location'] !='Address'):
		if(is_enable_radius() && $miles !=''){
		$where .= " AND ($wpdb->posts.ID in (SELECT post_id FROM $tbl_postcodes WHERE truncate((degrees(acos( sin(radians(`latitude`)) * sin( radians('".$lat."')) + cos(radians(`latitude`)) * cos( radians('".$lat."')) * cos( radians(`longitude` - '".$long."') ) ) ) * 69.09),1) <= ".$miles." ORDER BY truncate((degrees(acos( sin(radians(`latitude`)) * sin( radians('".$lat."')) + cos(radians(`latitude`)) * cos( radians('".$lat."')) * cos( radians(`longitude` - '".$long."') ) ) ) * 69.09),1) ASC))";
		}else{
				if(is_enable_radius()){
				$where .= " AND ($wpdb->posts.ID in (SELECT post_id  FROM $wpdb->postmeta where `meta_key` LIKE 'job_location' AND `meta_value` LIKE '%".$search."%' OR `meta_key` LIKE 'address' AND `meta_value` LIKE '%".$search."%'))";
				}
		}
		endif;
	}else if($ptype == CUSTOM_POST_TYPE2){
		if(($_REQUEST['address'] !='' && $_REQUEST['location'] !='Address') || $_REQUEST['resume_location'] !='')
		$search = $_REQUEST['address'];
		$where .= " AND ($wpdb->posts.ID in (SELECT post_id  FROM $wpdb->postmeta where `meta_key` LIKE 'resume_location' AND `meta_value` LIKE '%".$search."%' OR `meta_key` LIKE 'address' AND `meta_value` LIKE '%".$search."%'))";
	}
	if($scat>0)
	{
		$where .= " AND  $wpdb->posts.ID in (select $wpdb->term_relationships.object_id from $wpdb->term_relationships join $wpdb->term_taxonomy on $wpdb->term_taxonomy.term_taxonomy_id=$wpdb->term_relationships.term_taxonomy_id and $wpdb->term_taxonomy.term_id=\"$scat\" ) ";
	}else if($stag >0)
			{
				$where .= " AND  $wpdb->posts.ID in (select $wpdb->term_relationships.object_id from $wpdb->term_relationships join $wpdb->term_taxonomy on $wpdb->term_taxonomy.term_taxonomy_id=$wpdb->term_relationships.term_taxonomy_id and $wpdb->term_taxonomy.term_id=\"$stag\" ) ";
			}
	else if($todate!="")
	{
		$where .= " AND   DATE_FORMAT($wpdb->posts.post_date,'%Y-%m-%d') >='".$todate."'";
	}
	else if($frmdate!="")
	{
		$where .= " AND  DATE_FORMAT($wpdb->posts.post_date,'%Y-%m-%d') <='".$frmdate."'";
	}
	else if($todate!="" && $frmdate!="")
	{
		$where .= " AND  DATE_FORMAT($wpdb->posts.post_date,'%Y-%m-%d') BETWEEN '".$todate."' and '".$frmdate."'";
	}
	if($articleauthor!="" && $exactyes!=1)
	{
		$where .= " AND  $wpdb->posts.post_author in (select $wpdb->users.ID from $wpdb->users where $wpdb->users.display_name  like '".$articleauthor."') ";
	}
	
	$serch_post_types = "'".$ptype."','attachment'";
	$custom_metaboxes = get_post_custom_fields_templ($serch_post_types,'','user_side','1');
	foreach($custom_metaboxes as $key=>$val) {
	$name = $key;
		if($_REQUEST[$name]){ 
			$value = $_REQUEST[$name];
			if($name == 'proprty_desc' || $name == 'event_desc'){
				$where .= " AND ($wpdb->posts.post_content like \"%$value%\" )";
			} else if($name == 'property_name'){
				$where .= " AND ($wpdb->posts.post_title like \"%$value%\" )";
			}else {
				$where .= " AND ($wpdb->posts.ID in (select $wpdb->postmeta.post_id from $wpdb->postmeta where $wpdb->postmeta.meta_key='$name' and ($wpdb->postmeta.meta_value like \"%$value%\" ))) ";
			}
		}
	}
	
	// Added for tags
	if(is_search() && $s_tag){
	$where .= " AND  ($wpdb->posts.ID in (select p.ID from $wpdb->terms c,$wpdb->term_taxonomy tt,$wpdb->term_relationships tr,$wpdb->posts p ,$wpdb->postmeta t where c.name like '%".$s_tag."%' and c.term_id=tt.term_id and tt.term_taxonomy_id=tr.term_taxonomy_id and tr.object_id=p.ID and p.ID = t.post_id and p.post_status = 'publish' group by  p.ID))";
	}
   // echo $where;
	return $where;
}
/**-- Filter for applied job listing BOF --**/

function author_applied_jobs($where){
	global $wpdb,$current_user,$curauth,$wp_query;
		$query_var = $wp_query->query_vars;
		$user_id = $query_var['author'];
		$post_ids = get_user_meta($current_user->ID,'user_applied_jobs',true);
		$final_ids = '';
		if($post_ids)
		  {
			foreach($post_ids as $key=>$value)
			 {
			  if($value != '')
				{
				 $final_ids .= $value.',';
				}
			}
			$post_ids = substr($final_ids,0,-1);
		 }
	$where = " AND ($wpdb->posts.ID in ($post_ids)) AND ($wpdb->posts.post_type in('job','attachment') OR $wpdb->posts.post_type = '".CUSTOM_POST_TYPE1."') AND ($wpdb->posts.post_status = 'publish' OR $wpdb->posts.post_status = 'private' OR $wpdb->posts.post_status = 'draft' OR $wpdb->posts.post_status = 'attachment') ";			
	return $where;
}
/**-- Filter for applied job listing EOF --**/

function jobs_filter()
{
	if($_REQUEST['jtype'] && $_REQUEST['jtype']!='all')
	{
		add_filter('posts_where', 'jobs_filter_where');	
	}else
	{
		remove_filter('posts_where', 'jobs_filter_where');
	}
}

function jobs_filter_where($where)
{
	global $wpdb;
	$where = '';
	$jtype = $_REQUEST['jtype'];
	$where .= " AND $wpdb->posts.post_status = 'publish' AND $wpdb->posts.ID in (select pm.post_id from $wpdb->postmeta pm where pm.meta_key like 'job_type' and pm.meta_value = \"$jtype\")";
	return $where;
}

?>