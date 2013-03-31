<?php
/**
 * WPNuke Widget
 *
 * Main widget file which loads all default available widgets and sidebars.
 *
 * @author 		WPNuke
 * @category 	Admin
 * @package 	WPNuke/Admin
 * @version     1.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Auto Load All Widget Files
 */
define('WPNUKE_WIDGET_DIR', wpnuke_correct_path(WPNUKE_INCLUDES_DIR . '/widgets'));

// include all widget files (.php)
$widget_files = wpnuke_readdir(WPNUKE_WIDGET_DIR, array('php'));
foreach ($widget_files as $widget_file) {
	wpnuke_include( WPNUKE_WIDGET_DIR . '/' . $widget_file );
}

/**
 * Register default theme sidebars
 */
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => __( 'Homepage Sidebar', 'nukejob' ),
		'id' => 'homepage-sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'name' => __( 'Main Sidebar', 'nukejob' ),
		'id' => 'main-sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'name' => __( 'Job Sidebar', 'nukejob' ),
		'id' => 'job-sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
	
	register_sidebar(array(
		'name' => __( 'Resume Sidebar', 'nukejob' ),
		'id' => 'resume-sidebar',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'name' => 'Footer 1',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'name' => 'Footer 2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'name' => 'Footer 3',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));

	register_sidebar(array(
		'name' => 'Footer 4',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4>',
		'after_title' => '</h4>',
	));
}
?>