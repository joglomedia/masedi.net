<?php
//----------------------------------------------------------------------//
// Initiate the plugin to add custom post type
//----------------------------------------------------------------------//

add_action("init", "custom_posttype_menu_wp_admin");
function custom_posttype_menu_wp_admin()
{
//===============Job Listing SECTION START================
$custom_post_type = CUSTOM_POST_TYPE1;
$custom_cat_type = CUSTOM_CATEGORY_TYPE1;
$custom_tag_type = CUSTOM_TAG_TYPE1;

register_post_type(	"$custom_post_type", 
				array(	'label' 			=> CUSTOM_MENU_TITLE,
						'labels' 			=> array(	'name' 					=> 	CUSTOM_MENU_NAME,
														'singular_name' 		=> 	CUSTOM_MENU_SIGULAR_NAME,
														'add_new' 				=>  CUSTOM_MENU_ADD_NEW,
														'add_new_item' 			=>  CUSTOM_MENU_ADD_NEW_ITEM,
														'edit' 					=>  CUSTOM_MENU_EDIT,
														'edit_item' 			=>  CUSTOM_MENU_EDIT_ITEM,
														'new_item' 				=>  CUSTOM_MENU_NEW,
														'view_item'				=>  CUSTOM_MENU_VIEW,
														'search_items' 			=>  CUSTOM_MENU_SEARCH,
														'not_found' 			=>  CUSTOM_MENU_NOT_FOUND,
														'not_found_in_trash' 	=>  CUSTOM_MENU_NOT_FOUND_TRASH	),
						'public' 			=> true,
						'can_export'		=> true,
						'show_ui' 			=> true, // UI in admin panel
						'_builtin' 			=> false, // It's a custom post type, not built in
						'_edit_link' 		=> 'post.php?post=%d',
						'capability_type' 	=> 'post',
						'menu_icon' 		=> get_bloginfo('template_url').'/images/favicon.ico',
						'hierarchical' 		=> false,
						'rewrite' 			=> array("slug" => "$custom_post_type"), // Permalinks
						'query_var' 		=> "$custom_post_type", // This goes to the WP_Query schema
						'supports' 			=> array(	'title',
														'author', 
														'excerpt',
														'thumbnail',
														'comments',
														'editor', 
														'trackbacks',
														'custom-fields',
														'revisions') ,
						'show_in_nav_menus'	=> true ,
						'taxonomies'		=> array("$custom_cat_type","$custom_tag_type")
					)
				);

// Register custom taxonomy
register_taxonomy(	"$custom_cat_type", 
				array(	"$custom_post_type"	), 
				array (	"hierarchical" 		=> true, 
						"label" 			=> CUSTOM_MENU_CAT_LABEL, 
						'labels' 			=> array(	'name' 				=>  CUSTOM_MENU_CAT_TITLE,
														'singular_name' 	=>  CUSTOM_MENU_SIGULAR_CAT,
														'search_items' 		=>  CUSTOM_MENU_CAT_SEARCH,
														'popular_items' 	=>  CUSTOM_MENU_CAT_SEARCH,
														'all_items' 		=>  CUSTOM_MENU_CAT_ALL,
														'parent_item' 		=>  CUSTOM_MENU_CAT_PARENT,
														'parent_item_colon' =>  CUSTOM_MENU_CAT_PARENT_COL,
														'edit_item' 		=>  CUSTOM_MENU_CAT_EDIT,
														'update_item'		=>  CUSTOM_MENU_CAT_UPDATE,
														'add_new_item' 		=>  CUSTOM_MENU_CAT_ADDNEW,
														'new_item_name' 	=>  CUSTOM_MENU_CAT_NEW_NAME,	), 
						'public' 			=> true,
						'show_ui' 			=> true,
						"rewrite" 			=> true	)
				);
register_taxonomy(	"$custom_tag_type", 
				array(	"$custom_post_type"	), 
				array(	"hierarchical" 		=> false, 
						"label" 			=> CUSTOM_MENU_TAG_LABEL, 
						'labels' 			=> array(	'name' 				=>  CUSTOM_MENU_TAG_TITLE,
														'singular_name' 	=>  CUSTOM_MENU_TAG_NAME,
														'search_items' 		=>  CUSTOM_MENU_TAG_SEARCH,
														'popular_items' 	=>  CUSTOM_MENU_TAG_POPULAR,
														'all_items' 		=>  CUSTOM_MENU_TAG_ALL,
														'parent_item' 		=>  CUSTOM_MENU_TAG_PARENT,
														'parent_item_colon' =>  CUSTOM_MENU_TAG_PARENT_COL,
														'edit_item' 		=>  CUSTOM_MENU_TAG_EDIT,
														'update_item'		=>  CUSTOM_MENU_TAG_UPDATE,
														'add_new_item' 		=>  CUSTOM_MENU_TAG_ADD_NEW,
														'new_item_name' 	=>  CUSTOM_MENU_TAG_NEW_ADD,	),  
						'public' 			=> true,
						'show_ui' 			=> true,
						"rewrite" 			=> true	)
				);


add_filter( 'manage_edit-job_columns', 'templatic_edit_job_columns' ) ;

function templatic_edit_job_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Job' ),
		'logo' => __( 'Logo' ),
		'company_name' => __( 'Company Name' ),
		'post' => __( 'Location' ),
		'author' => __( 'Author' ),
		'post_category' => __( 'Categories' ),
		'date' => __( 'Date' )
	);

	return $columns;
}

add_action( 'manage_job_posts_custom_column', 'templatic_manage_job_columns', 10, 2 );

function templatic_manage_job_columns( $column, $post_id ) {
	echo '<link href="'.get_template_directory_uri().'/monetize/admin.css" rel="stylesheet" type="text/css" />';
	global $post;

	switch( $column ) {
	case 'post_category' :
			/* Get the post_category for the post. */
			
			$templ_propertys = get_the_terms($post_id,CUSTOM_CATEGORY_TYPE1);
			if (is_array($templ_propertys)) {
				foreach($templ_propertys as $key => $templ_property) {
					$edit_link = site_url()."/wp-admin/edit.php?".CUSTOM_CATEGORY_TYPE1."=".$templ_property->slug."&post_type=".CUSTOM_POST_TYPE1;
					$templ_propertys[$key] = '<a href="'.$edit_link.'">' . $templ_property->name . '</a>';
				}
				echo implode(' , ',$templ_propertys);
			}else {
				_e( 'Uncategorized' );
			}

			break;

		
		case 'logo' :
			if(get_post_meta($post_id,'company_logo', $single = true)): ?>
						<img class="company_logo" src="<?php echo get_post_meta($post_id,"company_logo",$single = true); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" height="60" width="60"  />
					<?php else: ?>
						<img class="company_logo" src="<?php echo get_bloginfo('template_directory'); ?>/images/no-image.png" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" height="60" width="60"  />
					<?php endif;  
		break;
		case 'company_name' :
			$company_name = get_post_meta($post_id,'company_name',true);
			if($company_name){
			echo get_post_meta($post_id,'company_name',true);
			}else{
			echo 'No name';
			}
		break;
		case 'post' :
			echo get_post_meta($post_id,'job_location', $single = true);
		break;
		case 'post_tags' :
			/* Get the post_tags for the post. */
			$templ_property_tags = get_the_terms($post_id,CUSTOM_TAG_TYPE1);
			if (is_array($templ_property_tags)) {
				foreach($templ_property_tags as $key => $templ_property_tag) {
					$edit_link = site_url()."/wp-admin/edit.php?".CUSTOM_TAG_TYPE1."=".$templ_property_tag->slug."&post_type=".CUSTOM_POST_TYPE1;
					$templ_property_tags[$key] = '<a href="'.$edit_link.'">' . $templ_property_tag->name . '</a>';
				}
				echo implode(' , ',$templ_property_tags);
			}else {
				_e( '' );
			}
				
			break;
		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}
add_filter( 'manage_edit-job_sortable_columns', 'templatic_job_sortable_columns' );
function templatic_job_sortable_columns( $columns ) {
	$columns['post_category'] = 'Categories';
	$columns['geo_address'] = 'Address';
	return $columns;
}


//////////////////////////////////////////////////////////////////////////////////////
//===============Resume Listing SECTION START================
$custom_post_type = CUSTOM_POST_TYPE2;
$custom_cat_type = CUSTOM_CATEGORY_TYPE2;
$custom_tag_type = CUSTOM_TAG_TYPE2;

register_post_type(	"$custom_post_type", 
				array(	'label' 			=> CUSTOM_MENU_TITLE2,
						'labels' 			=> array(	'name' 					=> 	CUSTOM_MENU_NAME2,
														'singular_name' 		=> 	CUSTOM_MENU_SIGULAR_NAME2,
														'add_new' 				=>  CUSTOM_MENU_ADD_NEW2,
														'add_new_item' 			=>  CUSTOM_MENU_ADD_NEW_ITEM2,
														'edit' 					=>  CUSTOM_MENU_EDIT2,
														'edit_item' 			=>  CUSTOM_MENU_EDIT_ITEM2,
														'new_item' 				=>  CUSTOM_MENU_NEW2,
														'view_item'				=>  CUSTOM_MENU_VIEW2,
														'search_items' 			=>  CUSTOM_MENU_SEARCH2,
														'not_found' 			=>  CUSTOM_MENU_NOT_FOUND2,
														'not_found_in_trash' 	=>  CUSTOM_MENU_NOT_FOUND_TRASH2),
						'public' 			=> true,
						'can_export'		=> true,
						'show_ui' 			=> true, // UI in admin panel
						'_builtin' 			=> false, // It's a custom post type, not built in
						'_edit_link' 		=> 'post.php?post=%d',
						'capability_type' 	=> 'post',
						'menu_icon' 		=> get_bloginfo('template_url').'/images/favicon.ico',
						'hierarchical' 		=> false,
						'rewrite' 			=> array("slug" => "$custom_post_type"), // Permalinks
						'query_var' 		=> "$custom_post_type", // This goes to the WP_Query schema
						'supports' 			=> array(	'title',
														'author', 
														'excerpt',
														'thumbnail',
														'comments',
														'editor', 
														'trackbacks',
														'custom-fields',
														'revisions') ,
						'show_in_nav_menus'	=> true ,
						'taxonomies'		=> array("$custom_cat_type","$custom_tag_type")
					)
				);

//// Register custom taxonomy
register_taxonomy(	"$custom_cat_type", 
				array(	"$custom_post_type"	), 
				array (	"hierarchical" 		=> true, 
						"label" 			=> CUSTOM_MENU_CAT_LABEL2, 
						'labels' 			=> array(	'name' 				=>  CUSTOM_MENU_CAT_TITLE2,
														'singular_name' 	=>  CUSTOM_MENU_SIGULAR_CAT2,
														'search_items' 		=>  CUSTOM_MENU_CAT_SEARCH2,
														'popular_items' 	=>  CUSTOM_MENU_CAT_SEARCH2,
														'all_items' 		=>  CUSTOM_MENU_CAT_ALL2,
														'parent_item' 		=>  CUSTOM_MENU_CAT_PARENT2,
														'parent_item_colon' =>  CUSTOM_MENU_CAT_PARENT_COL2,
														'edit_item' 		=>  CUSTOM_MENU_CAT_EDIT2,
														'update_item'		=>  CUSTOM_MENU_CAT_UPDATE2,
														'add_new_item' 		=>  CUSTOM_MENU_CAT_ADDNEW2,
														'new_item_name' 	=>  CUSTOM_MENU_CAT_NEW_NAME2,	), 
						'public' 			=> true,
						'show_ui' 			=> true,
						"rewrite" 			=> true	)
				);
register_taxonomy(	"$custom_tag_type", 
				array(	"$custom_post_type"	), 
				array(	"hierarchical" 		=> false, 
						"label" 			=> CUSTOM_MENU_TAG_LABEL2, 
						'labels' 			=> array(	'name' 				=>  CUSTOM_MENU_TAG_TITLE2,
														'singular_name' 	=>  CUSTOM_MENU_TAG_NAME2,
														'search_items' 		=>  CUSTOM_MENU_TAG_SEARCH2,
														'popular_items' 	=>  CUSTOM_MENU_TAG_POPULAR2,
														'all_items' 		=>  CUSTOM_MENU_TAG_ALL2,
														'parent_item' 		=>  CUSTOM_MENU_TAG_PARENT2,
														'parent_item_colon' =>  CUSTOM_MENU_TAG_PARENT_COL2,
														'edit_item' 		=>  CUSTOM_MENU_TAG_EDIT2,
														'update_item'		=>  CUSTOM_MENU_TAG_UPDATE2,
														'add_new_item' 		=>  CUSTOM_MENU_TAG_ADD_NEW2,
														'new_item_name' 	=>  CUSTOM_MENU_TAG_NEW_ADD2,),  
						'public' 			=> true,
						'show_ui' 			=> true,
						"rewrite" 			=> true	)
				);

}
add_filter( 'manage_edit-resume_columns', 'templatic_edit_resume_columns' ) ;

function templatic_edit_resume_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Resume' ),
		'author' => __( 'Author' ),
		'experience' => __( 'Experiance' ),
		'resume_location' => __( 'Location' ),
		'post_category' => __( 'Categories' ),
		'salary' => __( 'ETC' ),
		'post_tags' => __( 'Tags' ),
		'date' => __( 'Date' ),
		
	);

	return $columns;
}

add_action( 'manage_resume_posts_custom_column', 'templatic_manage_resume_columns', 10, 2 );

function templatic_manage_resume_columns( $column, $post_id ) {
	echo '<link href="'.get_template_directory_uri().'/monetize/admin.css" rel="stylesheet" type="text/css" />';
	global $post;

	switch( $column ) {
	case 'post_category' :
			/* Get the post_category for the post. */
			$templ_events = get_the_terms($post_id,CUSTOM_CATEGORY_TYPE2);
			if (is_array($templ_events)) {
				foreach($templ_events as $key => $templ_event) {
					$edit_link = site_url()."/wp-admin/edit.php?".CUSTOM_CATEGORY_TYPE2."=".$templ_event->slug."&post_type=".CUSTOM_POST_TYPE2;
					$templ_events[$key] = '<a href="'.$edit_link.'">' . $templ_event->name . '</a>';
					}
				echo implode(' , ',$templ_events);
			}else {
				_e( 'Uncategorized' );
			}
			break;
			
		case 'post_tags' :
			/* Get the post_tags for the post. */
			$templ_event_tags = get_the_terms($post_id,CUSTOM_TAG_TYPE2);
			if (is_array($templ_event_tags)) {
				foreach($templ_event_tags as $key => $templ_event_tag) {
					$edit_link = site_url()."/wp-admin/edit.php?".CUSTOM_TAG_TYPE2."=".$templ_event_tag->slug."&post_type=".CUSTOM_POST_TYPE2;
					$templ_event_tags[$key] = '<a href="'.$edit_link.'">' . $templ_event_tag->name . '</a>';
				}
				echo implode(' , ',$templ_event_tags);
			}else {
				_e( '' );
			}
				
			break;
		case 'resume_location' :
			/* Get the address for the post. */
			$resume_location = get_post_meta( $post_id, 'resume_location', true );
				if($resume_location != ''){
					$resume_location = $resume_location;
				} else {
					$resume_location = '-';
				}
				echo $resume_location;
			break;
		case 'salary' :
			/* Get the start_timing for the post. */
			$salary = get_post_meta( $post_id, 'salary', true );
				if($salary != ''){
					$salary = get_post_meta( $post_id, 'salary', true );
				} else {
					$salary = ' ';
				}
				echo display_amount_with_currency($salary);
			break;
		case 'date1' :
			/* Get the end_timing for the post. */
			global $wpdb;
			$date = $wpdb->get_row("select * from $wpdb->posts where ID = '".$post_id."'");
			$end_date = $date->post_date;
				if($end_date != ''){
					$end_date = $end_date;
				} else {
					$end_date = ' ';
				}
				echo $end_date;
			break;
		case 'experience' :
			/* Get the end_timing for the post. */
			global $wpdb;
			$experience = get_post_meta($post_id,'experience',true);

				if($experience != ''){
					$experience = $experience;
				} else {
					$experience = ' ';
				}
				echo $experience;
			break;
		
		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}
//===============Event Listing END================


/////The filter code to get the custom post type in the RSS feed
function myfeed_request($qv) {
	if (isset($qv['feed']))
		$qv['post_type'] = get_post_types();
	return $qv;
}
add_filter('request', 'myfeed_request');

?>