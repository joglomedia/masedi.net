<?php
function is_wp_admin()
{
	if(strstr($_SERVER['REQUEST_URI'],'/wp-admin/'))
	{
		return true;
	}
	return false;
}

add_action("admin_head", "templ_add_admin_custom_css");
function templ_add_admin_custom_css()
{?>
 <link rel="stylesheet" type="text/css" media="all" href="<?php echo TT_ADMIN_FOLDER_URL; ?>admin_style.css" />
<?php
}
/**-SEO third party enabled/disabled BOF-**/
function templ_is_third_party_seo()
{
	if(strtolower(get_option('ptthemes_use_third_party_data'))=='Yes')
	{
		return true;	
	}
	return false;		
}
/**-SEO third party enabled/disabled EOF-**/

/************************************
//FUNCTION NAME : templ_seo_meta_content
//ARGUMENTS : None
//RETURNS : Meta Content, Description and Noindex settings for SEO
***************************************/
function templ_seo_meta_content()
{
	if (is_home() || is_front_page()) 
	{
		$description = stripslashes(get_option('ptthemes_home_desc_seo'));
		$keywords = stripslashes(get_option('ptthemes_home_keyword_seo'));
	}elseif (is_single() || is_page())
	{
		global $post;
		$description = get_post_meta($post->ID,'templ_seo_page_desc',true);
		$keywords = get_post_meta($post->ID,'templ_seo_page_kw',true);
	}else if (is_tax() || is_category() ) {
		$str_desc = str_replace(array('</p>','<br />'),',',category_description());
		$description = strip_tags($str_desc);
	}
	if(is_archive() && strtolower(get_option( 'ptthemes_archives_noindex' ))=='yes')
	{
		echo '<meta name="robots" content="noindex" />';
	}elseif(is_tag() && strtolower(get_option( 'ptthemes_tag_archives_noindex' ))=='yes')
	{
		echo '<meta name="robots"  content="noindex" />';
	}elseif((is_archive() || is_tax() || is_category()) && strtolower(get_option('ptthemes_category_noindex'))=='yes')
	{
		echo '<meta name="robots"  content="noindex" />';
	}
	if($description){ echo '<meta name="description" content="'.$description.'"  />';}
	if($keywords){ echo '<meta content="'.$keywords.'" name="keywords" />';}
	
}
add_action('templ_seo_meta','templ_seo_meta_content');

/************************************
//FUNCTION NAME : templ_seo_title
//ARGUMENTS : None
//RETURNS : SEO page title
***************************************/
function templ_seo_title() { 
	if(templ_is_third_party_seo()){ 
	}else
	{
		
		global $page, $paged,$page_title;
		$sep = " | "; # delimiter
		$newtitle = get_bloginfo('name'); # default title
	if(isset($_GET['ptype']) && $_GET['ptype'] != '') {
			$newtitle = $page_title;
			$newtitle .=  $sep .get_bloginfo('name');
	} else {
		# Single & Page ##################################
		if (is_single() || is_page())
		{
			global $post;
			$newtitle = get_post_meta($post->ID,'templ_seo_page_title',true);
			if($newtitle=='')
			{
				$newtitle = single_post_title("", false);
			}
		}
	
		# Category ######################################
		if (is_category())
			$newtitle = single_cat_title("", false);
		# taxonomy ######################################
		if (is_tax())
			$newtitle = single_cat_title("", false);
	
		# Tag ###########################################
		if (is_tag())
		 $newtitle = single_tag_title("", false);
	
		# Search result ################################
		if (is_search())
		 $newtitle = __("Search Result ",'templatic') . $s;
	
		# Taxonomy #######################################
		if (is_tax()) {
			$curr_tax = get_taxonomy(get_query_var('taxonomy'));
			$curr_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy')); # current term data
			# if it's term
			if (!empty($curr_term)) {
				$newtitle = $curr_tax->label . $sep . $curr_term->name;
			} else {
				$newtitle = $curr_tax->label;
			}
		}
	
		if ( is_author() ) {
			$newtitle = __('Author Archives','templatic');
		}
		# Page number
		if ($paged >= 2 || $page >= 2)
				$newtitle .= $sep . sprintf('Page %s', max($paged, $page));
	
		# Home & Front Page ########################################
		if (is_home() || is_front_page()) {
			if(get_option('ptthemes_home_title_seo')){
				$newtitle = stripslashes(get_option('ptthemes_home_title_seo'));
			}else
			{
				$newtitle = get_bloginfo('name') . $sep . stripslashes(get_bloginfo('description'));
			}
		} else {
			$newtitle .=  $sep . get_bloginfo('name');
		}
	}	}
		return $newtitle;
}
if(strtolower(get_option('ptthemes_use_third_party_data')) == 'no'){
 add_filter('wp_title', 'templ_seo_title');
}
function templ_top_header_navigation_content()
{
  wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'secondary' ));
}
add_action('templ_get_top_header_navigation','templ_top_header_navigation_content');
/************************************
//FUNCTION NAME : templ_sendEmail
//ARGUMENTS : from email ID,From email Name, To email ID, To email name, Mail Subject, Mail Content, Mail Header.
//RETURNS : Send Mail to the email address.
***************************************/
function templ_sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$message,$extra='')
{
	$fromEmail = apply_filters('templ_send_from_emailid', $fromEmail);
	$fromEmailName = apply_filters('templ_send_from_emailname', $fromEmailName);
	$toEmail = apply_filters('templ_send_to_emailid', $toEmail);
	$toEmailName = apply_filters('templ_send_to_emailname', $toEmailName);

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
		// Additional headers
	$headers .= 'To: '.$toEmailName.' <'.$toEmail.'>' . "\r\n";
	//$headers .= 'From: '.get_option('blogname').' <'.$fromEmail.'>' . "\r\n";
		
	$subject = apply_filters('templ_send_email_subject', $subject);
	$message = apply_filters('templ_send_email_content', $message);
	$headers = apply_filters('templ_send_email_headers', $headers);
	
	// Mail it
	if(templ_is_php_mail())
	{
		@mail($toEmail, $subject, $message, $headers);	
	}else
	{
		wp_mail($toEmail, $subject, $message, $headers);	
	}	
}

function templ_is_php_mail()
{
	if(get_option('ptthemes_notification_type')=='PHP Mail')
	{
		return true;	
	}
	return false;
}

/* get category checklist tree BOF*/
	function get_wp_category_checklist($post_taxonomy,$pid)
	{
	    $pid = explode(',',$pid);
		global $wpdb;
		$taxonomy = $post_taxonomy;
		$table_prefix = $wpdb->prefix;
		$wpcat_id = NULL;
		/*-Fetch main category-*/
		if($taxonomy == "")
		{
		$wpcategories = (array)$wpdb->get_results("
        SELECT * FROM {$table_prefix}terms, {$table_prefix}term_taxonomy
        WHERE {$table_prefix}terms.term_id = {$table_prefix}term_taxonomy.term_id
                AND ({$table_prefix}term_taxonomy.taxonomy ='".CUSTOM_CATEGORY_TYPE2."' or {$table_prefix}term_taxonomy.taxonomy ='".CUSTOM_CATEGORY_TYPE1."')and  {$table_prefix}term_taxonomy.parent=0  ORDER BY {$table_prefix}terms.name");
		}else{
		$wpcategories = (array)$wpdb->get_results("
        SELECT * FROM {$table_prefix}terms, {$table_prefix}term_taxonomy
        WHERE {$table_prefix}terms.term_id = {$table_prefix}term_taxonomy.term_id
                AND {$table_prefix}term_taxonomy.taxonomy ='".$taxonomy."' and  {$table_prefix}term_taxonomy.parent=0  ORDER BY {$table_prefix}terms.name");
		}
		$wpcategories = array_values($wpcategories);
		$wpcat2 = NULL;
		if($wpcategories)
		{
		echo "<ul>"; 
		if($taxonomy == CUSTOM_CATEGORY_TYPE1){
		}
		foreach ($wpcategories as $wpcat)
		{ 
		$counter++;
		$termid = $wpcat->term_id;;
		$name = ucfirst($wpcat->name); 
		$termprice = $wpcat->term_price;
		$tparent =  $wpcat->parent;	
		?>
		<li><label><input type="checkbox" name="category[]" id="<?php echo $termid; ?>" value="<?php echo $termid; ?>" class="checkbox" <?php if($pid[0]){ if(in_array($termid,$pid)){ echo "checked=checked"; } }else{  }?> /></label>&nbsp;<?php echo $name; ?></li>
		<?php
		
		if($taxonomy !=""){

		 $child = get_term_children( $termid, $post_taxonomy );
		 foreach($child as $child_of)
		 { 
		 	$p = 0;
			$term = get_term_by( 'id', $child_of,$post_taxonomy);
			$termid = $term->term_taxonomy_id;
			$term_tax_id = $term->term_id;
			$termprice = $term->term_price;
			$name = $term->name;

			if($child_of)
			{
				$catprice = $wpdb->get_row("select * from $wpdb->term_taxonomy tt ,$wpdb->terms t where t.term_id='".$child_of."' and t.term_id = tt.term_id AND tt.taxonomy ='".$taxonomy."'");
				for($i=0;$i<count($catprice);$i++)
				{
					if($catprice->parent)
					{	
						$p++;
						$catprice1 = $wpdb->get_row("select * from $wpdb->term_taxonomy tt ,$wpdb->terms t where t.term_id='".$catprice->parent."' and t.term_id = tt.term_id AND tt.taxonomy ='".$taxonomy."'");
						if($catprice1->parent)
						{
							$i--;
							$catprice = $catprice1;
							continue;
						}
					}
				}
			}
			$p = $p*15;
		 ?>
			<li style="margin-left:<?php echo $p; ?>px;"><label><input type="checkbox" name="category[]" id="<?php echo $term_tax_id; ?>" value="<?php echo $term_tax_id; ?>" class="checkbox" <?php if($pid[0]){ if(in_array($term_tax_id,$pid)){ echo "checked=checked"; } }else{  }?> /></label>&nbsp;<?php echo $name; ?></li>
		<?php  }	}else{
		$post_taxonomy  = CUSTOM_CATEGORY_TYPE1;
		
		 $child = get_term_children( $termid, $post_taxonomy );
		 if($child ==''){
		 $post_taxonomy  = CUSTOM_CATEGORY_TYPE2;
		 $child = get_term_children( $termid, $post_taxonomy ); }
		 foreach($child as $child_of)
		 { 
		 	$p = 0;
			$term = get_term_by( 'id', $child_of,$post_taxonomy);
			$termid = $term->term_taxonomy_id;
			$term_tax_id = $term->term_id;
			$termprice = $term->term_price;
			$name = $term->name;

			if($child_of)
			{
				$catprice = $wpdb->get_row("select * from $wpdb->term_taxonomy tt ,$wpdb->terms t where t.term_id='".$child_of."' and t.term_id = tt.term_id AND (tt.taxonomy ='".CUSTOM_CATEGORY_TYPE1."')");
				for($i=0;$i<count($catprice);$i++)
				{
					if($catprice->parent)
					{	
						$p++;
						$catprice1 = $wpdb->get_row("select * from $wpdb->term_taxonomy tt ,$wpdb->terms t where t.term_id='".$catprice->parent."' and t.term_id = tt.term_id AND (tt.taxonomy ='".CUSTOM_CATEGORY_TYPE1."')");
						if($catprice1->parent)
						{
							$i--;
							$catprice = $catprice1;
							continue;
						}
					}
				}
			}
			$p = $p*15;
		 ?>
			<li style="margin-left:<?php echo $p; ?>px;"><label><input type="checkbox" name="category[]" id="<?php echo $term_tax_id; ?>" value="<?php echo $term_tax_id; ?>" class="checkbox" <?php if($pid[0]){ if(in_array($term_tax_id,$pid)){ echo "checked=checked"; } }else{  }?> /></label>&nbsp;<?php echo $name; ?></li>
		<?php  }	
				}		
}
	echo "</ul>"; } 
}
/* get category checklist tree EOF*/

?>