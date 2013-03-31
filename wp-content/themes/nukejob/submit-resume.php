<?php
/*
 * Template Name: Resume
 */

/**
 * This function handle upload, edit, and manage user resume
 */

$post_type	= 'resume';
$post_tax	= array( 'resume_category', 'resume_tag' );
$terms = array( '' ); // array of custom category id, get from $_POST data

$wpn_post = array(
'post_title'	=> wp_strip_all_tags( $post_title ),
'post_content'	=> $post_content,
'post_status'	=> 'draft',
'post_author'	=> $post_author,
'post_type'		=> $post_type,
'tax_input'		=> array( 'taxonomy_name' => $post_tax )
);

$post_id = wp_insert_post( $wpn_post, $wp_error );

// Set post taxonomy terms and add post meta
if( $post_id ) {
	// wp_set_post_terms( $post_id, $terms, $taxonomy, $append );
	wp_set_post_terms( $post_id, $terms, 'resume_category', true );

	// set post meta
	// add_post_meta($post_id, $meta_key, $meta_value, $unique);
	add_post_meta($post_id, $meta_key, $meta_value);
}

// create category / tax
//Checking if category already there
$cat_name = $_POST['name'];
$cat_desc = $_POST['description'];
$cat_ID = get_cat_ID( $cat_name );

//If not create new category
if($cat_ID == 0) {
	$catarr = array(
		'cat_name' => $cat_name,
		'category_description' => $cat_desc,
		'category_nicename' => ,
		'category_parent' => ,
		'taxonomy' => 'job_company'
	);
	// Add new category and get the ID of newly created category
	$cat_ID = wp_insert_category( $catarr );
}


?>