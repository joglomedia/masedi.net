<?php
/**
 * Register custom taxonomy functions
 *
 * These functions handle registration of new custom taxonomy
 *
 * @author 		WPNuke
 * @category 	Admin
 * @package 	WPNuke/Admin/
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Register Custom Taxonomy
 **/
function wpnuke_custom_taxonomies() {
	// Register Custom Job Category Taxonomy
	register_taxonomy(	
		'job_category',
		array( 'job' ),
		array(	
			'hierarchical'	=> true,
			'label' 		=> 'Job Categories',
			'labels' 		=> array (	
									'name' 				=>  __( 'Job Categories', 'nukejob' ),
									'singular_name' 	=>  __( 'Category', 'nukejob' ),
									'search_items' 		=>  __( 'Search Category', 'nukejob' ),
									'popular_items' 	=>  __( 'Popular Categories', 'nukejob' ),
									'all_items' 		=>  __( 'All Categories', 'nukejob' ),
									'parent_item' 		=>  __( 'Parent Category', 'nukejob' ),
									'parent_item_colon' =>  __( 'Parent Category:', 'nukejob' ),
									'edit_item' 		=>  __( 'Edit Category', 'nukejob' ),
									'update_item'		=>  __( 'Update Category', 'nukejob' ),
									'add_new_item' 		=>  __( 'Add New Category', 'nukejob' ),
									'new_item_name' 	=>  __( 'New Category Name', 'nukejob' )
								),
			'public' 		=> true,
			'show_ui' 		=> true,
			'query_var'		=> true,
			'rewrite'		=> array( 
									'slug' => 'job-category',
									'with_front' => false,
									'hierarchical' => true
								)
		)
	);

	// Register Custom Job Company Taxonomy
	register_taxonomy(
		'job_company',
		array( 'job' ),
		array(
			'hierarchical'	=> true,
			'label' 		=> 'Job Companies',
			'labels' 		=> array (	
									'name' 				=>  __( 'Job Companies', 'nukejob' ),
									'singular_name' 	=>  _x( 'Company', 'taxonomy singular name' ),
									'search_items' 		=>  __( 'Search Company', 'nukejob' ),
									'popular_items' 	=>  __( 'Popular Companies', 'nukejob' ),
									'all_items' 		=>  __( 'All Companies', 'nukejob' ),
									'parent_item' 		=>  __( 'Parent Company', 'nukejob' ),
									'parent_item_colon' =>  __( 'Parent Company:', 'nukejob' ),
									'edit_item' 		=>  __( 'Edit Company', 'nukejob' ),
									'update_item'		=>  __( 'Update Company', 'nukejob' ),
									'add_new_item' 		=>  __( 'Add New Company', 'nukejob' ),
									'new_item_name' 	=>  __( 'New Company Name', 'nukejob' ),
									'separate_items_with_commas' => __( 'Select only single company', 'nukejob' ),
									'add_or_remove_items' => __( 'Add or remove companies', 'nukejob' ),
									'choose_from_most_used' => __( 'Choose from existing company', 'nukejob' )
								),
			'public' 		=> true,
			'show_ui' 		=> true,
			'query_var'		=> true,
			'rewrite'		=> array( 
									'slug' => 'job-company',
									'with_front' => false,
									'hierarchical' => false
								)
		)
	);

	// Register Custom Job Tag Taxonomy
	register_taxonomy(	
		'job_tag',
		array( 'job' ),
		array(
			'hierarchical'	=> false,
			'label' 		=> 'Job Tags',
			'labels' 		=> array (	
									'name' 				=>  __( 'Job Tags', 'nukejob' ),
									'singular_name' 	=>  __( 'Tag', 'nukejob' ),
									'search_items' 		=>  __( 'Search Tag', 'nukejob' ),
									'popular_items' 	=>  __( 'Popular Tags', 'nukejob' ),
									'all_items' 		=>  __( 'All Tags', 'nukejob' ),
									'edit_item' 		=>  __( 'Edit Tag', 'nukejob' ),
									'update_item'		=>  __( 'Update Tag', 'nukejob' ),
									'add_new_item' 		=>  __( 'Add New Tag', 'nukejob' ),
									'new_item_name' 	=>  __( 'New Tag Name', 'nukejob' )
								),
			'public' 		=> true,
			'show_ui' 		=> true,
			'query_var'		=> true,
			'rewrite'		=> array( 
									'slug' => 'job-tag',
									'with_front' => false,
									'hierarchical' => false
								)
			)
		);

	// Register Custom Resume Category Taxonomy
	register_taxonomy(
		'resume_category',
		array( 'resume' ),
		array(	
			'hierarchical'	=> true,
			'label' 		=> 'Resume Categories',
			'labels' 		=> array (	
									'name' 				=>  __( 'Resume Categories', 'nukejob' ),
									'singular_name' 	=>  __( 'Resume Category', 'nukejob' ),
									'search_items' 		=>  __( 'Search Resume Category', 'nukejob' ),
									'popular_items' 	=>  __( 'Popular Resume Categories', 'nukejob' ),
									'all_items' 		=>  __( 'All Resume Categories', 'nukejob' ),
									'parent_item' 		=>  __( 'Parent Resume Category', 'nukejob' ),
									'parent_item_colon' =>  __( 'Parent Resume Category:', 'nukejob' ),
									'edit_item' 		=>  __( 'Edit Resume Category', 'nukejob' ),
									'update_item'		=>  __( 'Update Resume Category', 'nukejob' ),
									'add_new_item' 		=>  __( 'Add New Resume Category', 'nukejob' ),
									'new_item_name' 	=>  __( 'New Resume Category Name', 'nukejob' )
								),
			'public' 		=> true,
			'show_ui' 		=> true,
			'query_var'		=> true,
			'rewrite'		=> array( 
									'slug' => 'resume-category',
									'with_front' => false,
									'hierarchical' => true
								)
		)
	);

	// Register Custom Resume Tag Taxonomy
	register_taxonomy(
		'resume_tag',
		array( 'resume' ),
		array(	
			'hierarchical'	=> false,
			'label' 		=> 'Resume Tags',
			'labels' 		=> array(	
									'name' 				=>  __( 'Resume Tags', 'nukejob' ),
									'singular_name' 	=>  __( 'Resume Tag', 'nukejob' ),
									'search_items' 		=>  __( 'Search Resume Tag', 'nukejob' ),
									'popular_items' 	=>  __( 'Popular Resume Tags', 'nukejob' ),
									'all_items' 		=>  __( 'All Resume Tags', 'nukejob' ),
									'edit_item' 		=>  __( 'Edit Resume Tag', 'nukejob' ),
									'update_item'		=>  __( 'Update Resume Tag', 'nukejob' ),
									'add_new_item' 		=>  __( 'Add New Resume Tag', 'nukejob' ),
									'new_item_name' 	=>  __( 'New Resume Tag Name', 'nukejob' )
								),
			'public' 		=> true,
			'show_ui' 		=> true,
			'query_var'		=> true,
			'rewrite'		=> array( 
									'slug' => 'resume-tag',
									'with_front' => false,
									'hierarchical' => false
								)
		)
	);
	
	// register another taxonomies here

}
add_action( 'init', 'wpnuke_custom_taxonomies' );
?>
