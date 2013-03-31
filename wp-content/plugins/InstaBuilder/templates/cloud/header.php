<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<?php opl_document_header(); ?>
<link rel="stylesheet" media="all" href="<?php echo $opl_theme_url; ?>style.css"/>
<link rel="stylesheet" media="all" href="<?php echo $opl_theme_url; ?>css/<?php echo $opl_color; ?>.css"/>
<link rel="stylesheet" media="all" href="<?php echo $opl_theme_url; ?>css/mobile.css"/>
<link rel="stylesheet" media="all" href="<?php echo OPL_URL; ?>css/buttons.css"/>

<?php do_action('opl_custom_style'); ?>
</head>
	
<body lang="en" class="opl-canvas">
<?php opl_load_facebook(); ?>
<?php do_action('opl_body'); ?>