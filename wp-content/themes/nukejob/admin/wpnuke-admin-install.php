<?php
/**
 * WPNuke Install
 *
 * Theme install script which adds default pages, taxonomies, and database tables to WordPress. Runs on activation and upgrade.
 */

/** Copied from Wocommerce **/

/**
 * Create a page
 *
 * @access public
 * @param mixed $slug Slug for the new page
 * @param mixed $option Option name to store the page's ID
 * @param string $page_title (default: '') Title for the new page
 * @param string $page_content (default: '') Content for the new page
 * @param int $post_parent (default: 0) Parent for the new page
 * @return void
 */
function wpnuke_create_page( $slug, $option, $page_title = '', $page_content = '', $page_template = '', $post_parent = 0 ) {
	global $wpdb;

	$option_value = wpnuke_get_option( $option );

	if ( $option_value > 0 && get_post( $option_value ) )
		return;

	$page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM " . $wpdb->posts . " WHERE post_name = %s LIMIT 1;", $slug ) );
	if ( $page_found ) {
		if ( ! $option_value )
			wpnuke_update_option( $option, $page_found );
		return;
	}

	$page_data = array(
        'post_status' 		=> 'publish',
        'post_type' 		=> 'page',
        'post_author' 		=> 1,
        'post_name' 		=> $slug,
        'post_title' 		=> $page_title,
        'post_content' 		=> $page_content,
        'post_parent' 		=> $post_parent,
        'comment_status' 	=> 'closed'
    );
    $page_id = wp_insert_post( $page_data );
	
	// update page template meta
	update_post_meta($page_id, '_wp_page_template', $page_template);

	// update theme option
    wpnuke_update_option( $option, $page_id );
}


/**
 * Create pages that the plugin relies on, storing page id's in variables.
 *
 * @access public
 * @return void
 */
function wpnuke_create_pages() {

	// Company page
    wpnuke_create_page( esc_sql( _x( 'job-company', 'page_slug', 'wpnuke' ) ), 'company_page_id', __( 'Company', 'wpnuke' ), '', 'template-companies.php' );

    // Blog page
    wpnuke_create_page( esc_sql( _x( 'blog', 'page_slug', 'wpnuke' ) ), 'blog_page_id', __( 'Blog', 'wpnuke' ), '', 'template-blog.php' );

	// My Account page
    wpnuke_create_page( esc_sql( _x( 'myaccount', 'page_slug', 'wpnuke' ) ), 'myaccount_page_id', __( 'My Account', 'wpnuke' ), '', 'template-myaccount.php' );
	
	// Lost password page
	wpnuke_create_page( esc_sql( _x( 'lost-password', 'page_slug', 'wpnuke' ) ), 'lost_password_page_id', __( 'Lost Password', 'wpnuke' ), '', 'template-myaccount-lost-password.php', wpnuke_get_page_id( 'myaccount' ) );

    // Change password page
    wpnuke_create_page( esc_sql( _x( 'change-password', 'page_slug', 'wpnuke' ) ), 'change_password_page_id', __( 'Change Password', 'wpnuke' ), '', 'template-myaccount-edit-account.php', wpnuke_get_page_id( 'myaccount' ) );
}

/**
 * Set up the database tables which the plugin needs to function.
 *
 * Tables:
 *		wpnuke_attribute_taxonomies - Table for storing attribute taxonomies - these are user defined
 *		wpnuke_termmeta - Term meta table - sadly WordPress does not have termmeta so we need our own
 *		wpnuke_order_items - Order line items are stored in a table to make them easily queryable for reports
 *		wpnuke_job_companymeta - Job company item meta is stored in a table for storing extra data.
 *
 * @access public
 * @return void
 */
function wpnuke_tables_install() {
	global $wpdb, $wpnuke;

	$wpdb->hide_errors();

	$collate = '';

    if ( $wpdb->has_cap( 'collation' ) ) {
		if( ! empty($wpdb->charset ) )
			$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
		if( ! empty($wpdb->collate ) )
			$collate .= " COLLATE $wpdb->collate";
    }

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	// WPNuke Tables
	$wpnuke_tables = "
CREATE TABLE IF NOT EXISTS {$wpdb->prefix}termmeta (
  meta_id bigint(20) NOT NULL auto_increment,
  wpnuke_term_id bigint(20) NOT NULL,
  meta_key varchar(255) NULL,
  meta_value longtext NULL,
  PRIMARY KEY (meta_id),
  KEY wpnuke_term_id (wpnuke_term_id),
  KEY meta_key (meta_key)
) $collate;
CREATE TABLE IF NOT EXISTS {$wpdb->prefix}jobmeta (
  meta_id bigint(20) NOT NULL auto_increment,
  job_id bigint(20) NOT NULL,
  meta_key varchar(255) DEFAULT NULL,
  meta_value longtext,
  PRIMARY KEY (meta_id),
  KEY job_id (job_id),
  KEY meta_key (meta_key)
) $collate;
CREATE TABLE IF NOT EXISTS {$wpdb->prefix}job_companymeta (
  meta_id bigint(20) NOT NULL auto_increment,
  job_company_id bigint(20) NOT NULL,
  meta_key varchar(255) NULL,
  meta_value longtext NULL,
  PRIMARY KEY (meta_id),
  KEY job_company_id (job_company_id),
  KEY meta_key (meta_key)
) $collate;
CREATE TABLE IF NOT EXISTS {$wpdb->prefix}resumemeta (
  meta_id bigint(20) NOT NULL auto_increment,
  resume_id bigint(20) NOT NULL,
  meta_key varchar(255) DEFAULT NULL,
  meta_value longtext,
  PRIMARY KEY (meta_id),
  KEY resume_id (resume_id),
  KEY meta_key (meta_key)
) $collate;
";
	
	dbDelta( $wpnuke_tables );
}
?>