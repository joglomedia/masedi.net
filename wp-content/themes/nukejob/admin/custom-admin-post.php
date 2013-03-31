<?php
/**
 * Admin post type functions
 *
 * These functions control admin interface for post type and post status bits like modifying a job columns.
 *
 * @author 		WPNuke
 * @category 	Admin
 * @package 	WPNuke/Admin/
 * @version     1.0
 */

if (! defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Add Edit Screen Columns to Custom Post Type Job
 */
function wpnuke_edit_job_columns($columns) {
    $wpnuke_job_columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => __('Job', 'wpnuke'),
        'company_name' => __('Job Provider', 'wpnuke'),
		'location' => __('Job Location', 'wpnuke'),
		'author' => __('Submitted By', 'wpnuke'),
		'category' => __('Categories', 'wpnuke'),
        'applicant' => __('Applicants', 'wpnuke'),
		'expire' => __('Expire Date', 'wpnuke'),
        'date' => __('Date', 'wpnuke')
   );
	
    //$wpnuke_job_columns['job_category'] = '<a href="edit.php?post_type=job&orderby=job_category&order=asc"><span>Categories</span><span class="sorting-indicator"></span></a>';
    
	return $wpnuke_job_columns;
}
add_filter('manage_edit-job_columns', 'wpnuke_edit_job_columns');

/**
 * Modify Edit Screen Columns for Custom Post Type Job
 */
function wpnuke_manage_job_column($columns, $post_id){
	global $post;

	switch ($columns) {
		case 'company_name' :
			/** Get Company Logo */
			$tax = wpnuke_get_term_meta($post_id, 'job_company');
			$thumb_id = $tax['company_thumb_id'];
			$company_name = $tax['name'];
			$edit_link = site_url()."/wp-admin/edit.php?job_company=".$tax['slug']."&post_type=job";
			
			if($thumb_id) {
			$image_logo = wp_get_attachment_image($thumb_id, 'company-logo-medium');
				echo '<a href="' . $edit_link . '">' . $image_logo . '<br />' . $company_name . '</a>';
			} else {
				echo '<a href="' . $edit_link . '"><img class="company_logo" src="' . get_bloginfo('template_directory') . '/images/default-logo.png" alt="' . get_the_title(). '" title="' . get_the_title() . '" height="60px" width="60px" /><br />' . $company_name . '</a>';
			}
		break;
		
		case 'location' :
			echo get_post_meta($post_id, WPNUKE_PREFIX . 'job_location', true);
		break;
		
		case 'category' :
			/** Get the job_category for the job post. */
			
			$job_categories = get_the_terms($post_id, 'job_category');
			
			if (is_array($job_categories)) {
				foreach($job_categories as $key => $job_category) {
					$edit_link = site_url()."/wp-admin/edit.php?job_category=".$job_category->slug."&post_type=job";
					$job_categories[$key] = '<a href="'.$edit_link.'">' . $job_category->name . '</a>';
				}
				echo implode(' , ', $job_categories);
			} else {
				_e('Uncategorized');
			}
		break;
		
		case 'applicant' :
			$applicants = get_post_meta($post_id, WPNUKE_PREFIX . 'job_applicant');
			
			if($applicants) {
				echo '<div style="text-align:center;">' . count($applicants) . '</div>';
			} else {
				echo '<div style="text-align:center;">0</div>';
			}
		break;
		
		case 'expire' :
			$exp_date = get_post_meta($post_id, WPNUKE_PREFIX . 'job_expire_date', true);
			$exp_date = str_replace('-', '/', $exp_date);
			$end_date = explode(' ', $exp_date);
			$job_status = wpnuke_get_jobstatus($post_id);
			
			echo '<abbr title="' . $exp_date . '">' . $end_date[0] . '</abbr><br />' . $job_status;
		break;
		
		default :
		break;
	}
}
add_action('manage_job_posts_custom_column', 'wpnuke_manage_job_column', 10, 2);

/**
 * Add sortable columns
 */
function wpnuke_job_sortable_columns($columns) {
	$columns['author'] = __('Submitted By', 'wpnuke');
	$columns['company_name'] = __('Company', 'wpnuke');
	$columns['category'] = __('Categories', 'wpnuke');
	$columns['applicant'] = __('Applicants', 'wpnuke');
	$columns['expire'] = __('Expire Date', 'wpnuke');
	return $columns;
}
add_filter('manage_edit-job_sortable_columns', 'wpnuke_job_sortable_columns');

/**
 * Job column orderby
 *
 * http://scribu.net/wordpress/custom-sortable-columns.html#comment-4732
 */
function wpnuke_job_orderby_columns($vars) {
	if (isset($vars['orderby'])) {
		if ('author' == $vars['orderby']) {
			$vars = array_merge($vars, array(
				'meta_key' 	=> '_author',
				'orderby' 	=> 'meta_value'
			));
		}
		if ('applicant' == $vars['orderby']) {
			$vars = array_merge($vars, array(
				'meta_key' 	=> WPNUKE_PREFIX . 'job_applicant',
				'orderby' 	=> 'meta_value'
			));
		}
		if ('expire' == $vars['orderby']) {
			$vars = array_merge($vars, array(
				'meta_key' 	=> WPNUKE_PREFIX . 'job_expire_date',
				'orderby' 	=> 'meta_value'
			));
		}
	}

	return $vars;
}
add_filter('request', 'wpnuke_job_orderby_columns');

?>
