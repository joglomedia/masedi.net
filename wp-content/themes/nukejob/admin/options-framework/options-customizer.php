<?php
/**
 * Options Framework Front End Customizer
 * Modified and Adapted for WPNuke Framework
 *
 * WordPress 3.4 Required
 * https://codex.wordpress.org/Theme_Customization_API
 */
 
/**
 * Need to include options framework settings in order this options customizer work
 */
wpnuke_require(WPNUKE_ADMIN_DIR . '/options-settings.php');


function options_theme_customizer_register($wp_customize) {

	/**
	 * This is optional, but if you want to reuse some of the defaults
	 * or values you already have built in the options panel, you
	 * can load them into $options for easy reference
	 */
	
	// Theme options
	$options = optionsframework_options();
	
	// options prefix
	$option_prefix = WPNUKE_PREFIX;
	
	//var_dump($options);
	
	/* Basic */

	$wp_customize->add_section( 'options_theme_customizer_general', array(
		'title' => __( 'General', 'options_theme_customizer' ),
		'priority' => 100
	) );
	
	$wp_customize->add_setting( 'options_theme_customizer['.$option_prefix .'logo]', array(
		'default' => $options[$option_prefix . 'logo']['std'],
		'type' => 'upload'
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $option_prefix . 'logo', array(
		'label' => $options[$option_prefix . 'logo']['name'],
		'section' => 'options_theme_customizer_general',
		'settings' => 'options_theme_customizer['.$option_prefix .'logo]',
	) ) );
	
	$wp_customize->add_setting( 'options_theme_customizer['.$option_prefix .'favicon]', array(
		'default' => $options[$option_prefix . 'favicon']['std'],
		'type' => 'upload'
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $option_prefix . 'favicon', array(
		'label' => $options[$option_prefix . 'favicon']['name'],
		'section' => 'options_theme_customizer_general',
		'settings' => 'options_theme_customizer['.$option_prefix .'favicon]',
	) ) );
	
	$wp_customize->add_setting( 'options_theme_customizer['.$option_prefix .'login_logo]', array(
		'default' => $options[$option_prefix . 'login_logo']['std'],
		'type' => 'upload'
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $option_prefix . 'login_logo', array(
		'label' => $options[$option_prefix . 'login_logo']['name'],
		'section' => 'options_theme_customizer_general',
		'settings' => 'options_theme_customizer['.$option_prefix .'login_logo]',
	) ) );
	
	
	/* Extended */

	$wp_customize->add_section( 'options_theme_customizer_extended', array(
		'title' => __( 'Extended', 'options_theme_customizer' ),
		'priority' => 110
	) );
	
	$wp_customize->add_setting( 'options_theme_customizer[example_uploader]', array(
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'example_uploader', array(
		'label' => $options['example_uploader']['name'],
		'section' => 'options_theme_customizer_extended',
		'settings' => 'options_theme_customizer[example_uploader]'
	) ) );
	
	$wp_customize->add_setting( 'options_theme_customizer[example_colorpicker]', array(
		'default' => $options['example_colorpicker']['std'],
		'type' => 'option'
	) );
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
		'label'   => $options['example_colorpicker']['name'],
		'section' => 'options_theme_customizer_extended',
		'settings'   => 'options_theme_customizer[example_colorpicker]'
	) ) );
}

add_action( 'customize_register', 'options_theme_customizer_register' );

?>