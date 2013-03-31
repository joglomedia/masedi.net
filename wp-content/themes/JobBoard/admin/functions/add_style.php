<?php ob_start(); ?>

<?php if(get_option('ptthemes_fonts')){?>
body.home-bg, .home-bg input, .home-bg textarea, .home-bg select { 
font-family:<?php echo get_option('ptthemes_fonts');?> !important; }

body, input, textarea, select { 
font-family:<?php echo get_option('ptthemes_fonts');?> !important;
 }<?php }?>

<?php if(get_option('ptthemes_body_background_color')){?>
body.home-bg { background: <?php echo get_option('ptthemes_body_background_color');?> !important; }
body { background: <?php echo get_option('ptthemes_body_background_color');?> !important; }
<?php }?>

<?php if(get_option('ptthemes_body_background_image')){?>
body.home-bg{ background:<?php if(get_option('ptthemes_body_background_image')){?>url(<?php echo get_option('ptthemes_body_background_image');?>)<?php }?> <?php if(get_option('ptthemes_body_bg_postions')){ echo get_option('ptthemes_body_bg_postions');}?> !important;  }
body{ background:<?php if(get_option('ptthemes_body_background_image')){?>url(<?php echo get_option('ptthemes_body_background_image');?>)<?php }?> <?php if(get_option('ptthemes_body_bg_postions')){ echo get_option('ptthemes_body_bg_postions');}?> !important;  }
<?php }?>

<?php if(get_option('ptthemes_header_background_first_color')){?>
.bg_first { background-color:<?php echo get_option('ptthemes_header_background_first_color');?> !important; }
<?php }?>

<?php if(get_option('ptthemes_header_background_second_color')){?>
.bg_second { background-color:<?php echo get_option('ptthemes_header_background_second_color');?> !important; }
<?php }?>

<?php if(get_option('ptthemes_link_color_normal')){?>
a { color:<?php echo get_option('ptthemes_link_color_normal');?> !important;  }
<?php }?>

<?php if(get_option('ptthemes_link_color_hover')){?>
a:hover { color:<?php echo get_option('ptthemes_link_color_hover');?> !important;   }
<?php }?>

<?php if(get_option('ptthemes_main_title_color')){?>
h1, h2, h3, h4, h5, h6, h6.a,.list-style li h6{ color:<?php echo get_option('ptthemes_main_title_color');?> !important; }
<?php }?>

<?php if(get_option('ptthemes_page_title_image')){?>
.title-container h1 span { background: url("<?php echo get_option('ptthemes_page_title_image');?>") !important; }
<?php }?>

<?php if(get_option('ptthemes_page_title_background')){?>
.title-container { background:<?php echo get_option('ptthemes_page_title_background');?> !important; }
<?php }?>

<?php if(get_option('ptthemes_page_title_border')){?>
.title-container { border-color:<?php echo get_option('ptthemes_page_title_border');?> !important; }
<?php }?>

<?php if(get_option('ptthemes_sidebar_title_image')){?>
.widget-container h3 span, .title_green span { background: url("<?php echo get_option('ptthemes_sidebar_title_image');?>") !important; }
<?php }?>

<?php if(get_option('ptthemes_sidebar_color')){?>
.widget-container { background:<?php echo get_option('ptthemes_sidebar_color');?> !important; }
<?php }?>

<?php if(get_option('ptthemes_sidebar_border_color')){?>
.widget-container { border-color:<?php echo get_option('ptthemes_sidebar_border_color');?> !important; }
<?php }?>

<?php if(get_option('ptthemes_footer_color')){?>
#footer { background:<?php echo get_option('ptthemes_footer_color');?> !important; }
<?php }?>

<?php if(get_option('ptthemes_footer_border_color')){?>
#footer { border-color:<?php echo get_option('ptthemes_footer_border_color');?> !important; }
<?php }?>

<?php if(get_option('ptthemes_navigation_border_color')){?>
#navigation { border-color: 1px solid <?php echo get_option('ptthemes_navigation_border_color');?> !important; }
<?php }?>

<?php if(get_option('ptthemes_navigation_gradient_top') || get_option('ptthemes_navigation_gradient_middle') || get_option('ptthemes_navigation_gradient_bottom')){?>
#navigation, .top_navigation_in .currentmenu
 { 
	background-image: linear-gradient(top, <?php echo get_option('ptthemes_navigation_gradient_top');?> 0%, <?php echo get_option('ptthemes_navigation_gradient_middle');?> 20%, <?php echo get_option('ptthemes_navigation_gradient_bottom');?> 97%) !important; 
	background-image: -o-linear-gradient(top, <?php echo get_option('ptthemes_navigation_gradient_top');?> 0%, <?php echo get_option('ptthemes_navigation_gradient_middle');?> 20%, <?php echo get_option('ptthemes_navigation_gradient_bottom');?> 97%) !important;
	background-image: -moz-linear-gradient(top, <?php echo get_option('ptthemes_navigation_gradient_top');?> 0%, <?php echo get_option('ptthemes_navigation_gradient_middle');?> 20%, <?php echo get_option('ptthemes_navigation_gradient_bottom');?> 97%) !important;
	background-image: -webkit-linear-gradient(top, <?php echo get_option('ptthemes_navigation_gradient_top');?> 0%, <?php echo get_option('ptthemes_navigation_gradient_middle');?> 20%, <?php echo get_option('ptthemes_navigation_gradient_bottom');?> 97%) !important;
	background-image: -ms-linear-gradient(top, <?php echo get_option('ptthemes_navigation_gradient_top');?> 0%, <?php echo get_option('ptthemes_navigation_gradient_middle');?> 20%, <?php echo get_option('ptthemes_navigation_gradient_bottom');?> 97%) !important;
	background-image: -webkit-gradient(	linear,	left top, left bottom, color-stop(0, <?php echo get_option('ptthemes_navigation_gradient_top');?>), color-stop(0.2, <?php echo get_option('ptthemes_navigation_gradient_middle');?>), color-stop(0.97, <?php echo get_option('ptthemes_navigation_gradient_bottom');?>) ) !important;
	background-color: <?php echo get_option('ptthemes_navigation_gradient_bottom');?> !important;
}
.pagination a, .pagination a.nextpostslink, .pagination a.previouspostslink
 { 
	background-image: linear-gradient(top, <?php echo get_option('ptthemes_navigation_gradient_top');?> 0%, <?php echo get_option('ptthemes_navigation_gradient_bottom');?> 100%) !important; 
	background-image: -o-linear-gradient(top, <?php echo get_option('ptthemes_navigation_gradient_top');?> 0%, <?php echo get_option('ptthemes_navigation_gradient_bottom');?> 100%) !important;
	background-image: -moz-linear-gradient(top, <?php echo get_option('ptthemes_navigation_gradient_top');?> 0%, <?php echo get_option('ptthemes_navigation_gradient_bottom');?> 100%) !important;
	background-image: -webkit-linear-gradient(top, <?php echo get_option('ptthemes_navigation_gradient_top');?> 0%, <?php echo get_option('ptthemes_navigation_gradient_bottom');?> 100%) !important;
	background-image: -ms-linear-gradient(top, <?php echo get_option('ptthemes_navigation_gradient_top');?> 0%, <?php echo get_option('ptthemes_navigation_gradient_bottom');?> 100%) !important;
	background-image: -webkit-gradient(	linear,	left top, left bottom, color-stop(0, <?php echo get_option('ptthemes_navigation_gradient_top');?>), color-stop(1, <?php echo get_option('ptthemes_navigation_gradient_bottom');?>) ) !important;
	background-color: <?php echo get_option('ptthemes_navigation_gradient_bottom');?> !important;
    border-color: <?php echo get_option('ptthemes_navigation_gradient_bottom');?> !important;  
}
#navigation ul li { background-image: none !important; border-right: 1px solid <?php echo get_option('ptthemes_navigation_gradient_bottom');?> !important; }
<?php }?>

<?php if(get_option('ptthemes_navigation_gradient_top_hover') || get_option('ptthemes_navigation_gradient_middle_hover') || get_option('ptthemes_navigation_gradient_bottom_hover')){?>
#navigation ul li:hover a, #navigation ul li a:hover, .top_navigation_in .currentmenu
{ 
	background-image: linear-gradient(top, <?php echo get_option('ptthemes_navigation_gradient_top_hover');?> 0%, <?php echo get_option('ptthemes_navigation_gradient_middle_hover');?> 20%, <?php echo get_option('ptthemes_navigation_gradient_bottom_hover');?> 97%) !important; 
	background-image: -o-linear-gradient(top, <?php echo get_option('ptthemes_navigation_gradient_top_hover');?> 0%, <?php echo get_option('ptthemes_navigation_gradient_middle_hover');?> 20%, <?php echo get_option('ptthemes_navigation_gradient_bottom_hover');?> 97%) !important;
	background-image: -moz-linear-gradient(top, <?php echo get_option('ptthemes_navigation_gradient_top_hover');?> 0%, <?php echo get_option('ptthemes_navigation_gradient_middle_hover');?> 20%, <?php echo get_option('ptthemes_navigation_gradient_bottom_hover');?> 97%) !important;
	background-image: -webkit-linear-gradient(top, <?php echo get_option('ptthemes_navigation_gradient_top_hover');?> 0%, <?php echo get_option('ptthemes_navigation_gradient_middle_hover');?> 20%, <?php echo get_option('ptthemes_navigation_gradient_bottom_hover');?> 97%) !important;
	background-image: -ms-linear-gradient(top, <?php echo get_option('ptthemes_navigation_gradient_top_hover');?> 0%, <?php echo get_option('ptthemes_navigation_gradient_middle_hover');?> 20%, <?php echo get_option('ptthemes_navigation_gradient_bottom_hover');?> 97%) !important;
	background-image: -webkit-gradient(	linear,	left top, left bottom, color-stop(0, <?php echo get_option('ptthemes_navigation_gradient_top_hover');?>), color-stop(0.2, <?php echo get_option('ptthemes_navigation_gradient_middle_hover');?>), color-stop(0.97, <?php echo get_option('ptthemes_navigation_gradient_bottom_hover');?>) ) !important;
	background-color: <?php echo get_option('ptthemes_navigation_gradient_bottom_hover');?> !important;
}
.pagination a:hover, .pagination a.current, .pagination *:hover a, .pagination a:focus, .pagination a.nextpostslink:hover, .pagination a.previouspostslink:hover
{ 
	background-image: linear-gradient(top, <?php echo get_option('ptthemes_navigation_gradient_top_hover');?> 0%, <?php echo get_option('ptthemes_navigation_gradient_bottom_hover');?> 100%) !important; 
	background-image: -o-linear-gradient(top, <?php echo get_option('ptthemes_navigation_gradient_top_hover');?> 0%, <?php echo get_option('ptthemes_navigation_gradient_bottom_hover');?> 100%) !important;
	background-image: -moz-linear-gradient(top, <?php echo get_option('ptthemes_navigation_gradient_top_hover');?> 0%, <?php echo get_option('ptthemes_navigation_gradient_bottom_hover');?> 100%) !important;
	background-image: -webkit-linear-gradient(top, <?php echo get_option('ptthemes_navigation_gradient_top_hover');?> 0%, <?php echo get_option('ptthemes_navigation_gradient_bottom_hover');?> 100%) !important;
	background-image: -ms-linear-gradient(top, <?php echo get_option('ptthemes_navigation_gradient_top_hover');?> 0%, <?php echo get_option('ptthemes_navigation_gradient_bottom_hover');?> 100%) !important;
	background-image: -webkit-gradient(	linear,	left top, left bottom, color-stop(0, <?php echo get_option('ptthemes_navigation_gradient_top_hover');?>), color-stop(1, <?php echo get_option('ptthemes_navigation_gradient_bottom_hover');?>) ) !important;
	background-color: <?php echo get_option('ptthemes_navigation_gradient_bottom_hover');?> !important;
    border-color: <?php echo get_option('ptthemes_navigation_gradient_bottom_hover');?> !important;  
}
<?php }?>

<?php if(get_option('ptthemes_sub_navigation_background_color')){?>
#navigation ul.sub-menu, #navigation ul.children { border: 1px solid <?php echo get_option('ptthemes_sub_navigation_background_color_hover');?> !important; }
#navigation ul.sub-menu li a, #navigation ul.children li a { background-color:<?php echo get_option('ptthemes_sub_navigation_background_color');?> !important; background-image: none !important; }
#navigation ul.sub-menu li, #navigation ul.children li { border-bottom: 1px solid <?php echo get_option('ptthemes_sub_navigation_background_color_hover');?> !important; border-top: none !important; border-right: none !important;  }
<?php }?>

<?php if(get_option('ptthemes_sub_navigation_background_color_hover')){?>
#navigation ul.sub-menu li a:hover, #navigation ul.children li a:hover { background:<?php echo get_option('ptthemes_sub_navigation_background_color_hover');?> !important; background-image: none !important; }
<?php }?>

<?php if(get_option('ptthemes_top_navigation_background_color')){?>
#menu-top-menu li ul { background-color:<?php echo get_option('ptthemes_top_navigation_background_color');?> !important; }
<?php }?>

<?php if(get_option('ptthemes_top_navigation_border_color')){?>
#menu-top-menu li ul, .top_navigation_in .menu-header { border-color:<?php echo get_option('ptthemes_top_navigation_border_color');?> !important; }
#menu-top-menu li:hover ul li a { border-color:<?php echo get_option('ptthemes_top_navigation_border_color');?> !important; }
#menu-top-menu li:hover ul li { border-bottom: none !important; }
<?php }?>

<?php if(get_option('ptthemes_top_navigation_background_color_hover')){?>
#menu-top-menu li:hover ul li a:hover { background-color: <?php echo get_option('ptthemes_top_navigation_background_color_hover');?> !important; }
<?php }?>

<?php if(get_option('ptthemes_button_border_color')){?>
a.button_green, 
button,
input[type="reset"], 
input[type="submit"], 
input[type="button"],
.upload
 	{ border-color: <?php echo get_option('ptthemes_button_border_color');?> !important; }
<?php }?>

<?php if(get_option('ptthemes_button_background_gredient_top') || get_option('ptthemes_button_background_gredient_bottom')){?>
a.button_green, 
button,
input[type="reset"], 
input[type="submit"], 
input[type="button"],
.upload
   { 
	background-image: linear-gradient(top, <?php echo get_option('ptthemes_button_background_gredient_top');?> 0%, <?php echo get_option('ptthemes_button_background_gredient_bottom');?> 62%) !important;
    background-image: -o-linear-gradient(top, <?php echo get_option('ptthemes_button_background_gredient_top');?> 0%, <?php echo get_option('ptthemes_button_background_gredient_bottom');?> 62%) !important;
    background-image: -moz-linear-gradient(top, <?php echo get_option('ptthemes_button_background_gredient_top');?> 0%, <?php echo get_option('ptthemes_button_background_gredient_bottom');?> 62%) !important;
    background-image: -webkit-linear-gradient(top, <?php echo get_option('ptthemes_button_background_gredient_top');?> 0%, <?php echo get_option('ptthemes_button_background_gredient_bottom');?> 62%) !important;
    background-image: -ms-linear-gradient(top, <?php echo get_option('ptthemes_button_background_gredient_top');?> 0%, <?php echo get_option('ptthemes_button_background_gredient_bottom');?> 62%) !important;
	background-image: -webkit-gradient( linear, left top, left bottom, color-stop(0, <?php echo get_option('ptthemes_button_background_gredient_top');?>), color-stop(0.62, <?php echo get_option('ptthemes_button_background_gredient_bottom');?>)) !important;
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=<?php echo get_option('ptthemes_button_background_gredient_top');?>, endColorstr=<?php echo get_option('ptthemes_button_background_gredient_bottom');?>,GradientType=0 ) !important;
}
<?php }?>

<?php if(get_option('ptthemes_button_background_gredient_top') || get_option('ptthemes_button_background_gredient_bottom')){?>
a.button_green:hover, 
button:hover,
input[type="reset"]:hover,
input[type="submit"]:hover, 
input[type="button"]:hover,
.upload
	{ 
	background-image: linear-gradient(top, <?php echo get_option('ptthemes_button_background_gredient_bottom');?> 0%, <?php echo get_option('ptthemes_button_background_gredient_top');?> 62%) !important;
    background-image: -o-linear-gradient(top, <?php echo get_option('ptthemes_button_background_gredient_bottom');?> 0%, <?php echo get_option('ptthemes_button_background_gredient_top');?> 62%) !important;
    background-image: -moz-linear-gradient(top, <?php echo get_option('ptthemes_button_background_gredient_bottom');?> 0%, <?php echo get_option('ptthemes_button_background_gredient_top');?> 62%) !important;
    background-image: -webkit-linear-gradient(top, <?php echo get_option('ptthemes_button_background_gredient_bottom');?> 0%, <?php echo get_option('ptthemes_button_background_gredient_top');?> 62%) !important;
    background-image: -ms-linear-gradient(top, <?php echo get_option('ptthemes_button_background_gredient_bottom');?> 0%, <?php echo get_option('ptthemes_button_background_gredient_top');?> 62%) !important;
	background-image: -webkit-gradient( linear, left top, left bottom, color-stop(0, <?php echo get_option('ptthemes_button_background_gredient_bottom');?>), color-stop(0.62, <?php echo get_option('ptthemes_button_background_gredient_top');?>)) !important;
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=<?php echo get_option('ptthemes_button_background_gredient_bottom');?>, endColorstr=<?php echo get_option('ptthemes_button_background_gredient_top');?>,GradientType=0 ) !important;
}
<?php }?>



<?php 
$data = ob_get_contents();
ob_clean();
if($data !='')
{
?>
<style type="text/css"><?php echo $data;?> </style>
<?php }?>