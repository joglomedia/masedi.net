<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'header.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
  <title>
    <?php bloginfo('name'); ?> 
    <?php if ( is_single() ) { ?> &raquo; Blog Archive 
    <?php } ?> 
    <?php wp_title(); ?>
  </title>
  <meta content="WordPress" name="generator" />
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
  <link rel="alternate stylesheet" type="text/css" media="screen" title="water-theme" href="<?php bloginfo('template_directory'); ?>/water.css" />
  <link rel="alternate stylesheet" type="text/css" media="screen" title="life-theme" href="<?php bloginfo('template_directory'); ?>/life.css" />
  <link rel="alternate stylesheet" type="text/css" media="screen" title="earth-theme" href="<?php bloginfo('template_directory'); ?>/earth.css" />
  <link rel="alternate stylesheet" type="text/css" media="screen" title="wind-theme" href="<?php bloginfo('template_directory'); ?>/wind.css" />
  <link rel="alternate stylesheet" type="text/css" media="screen" title="fire-theme" href="<?php bloginfo('template_directory'); ?>/fire.css" />
  <link rel="alternate stylesheet" type="text/css" media="handheld,screen" title="lite-theme" href="<?php bloginfo('template_directory'); ?>/lite.css" />
  <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
  <link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
  <link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
  
  <!-- IE6 Specific Fixes -->
  <!--[if gte IE 5.5]>
    <![if lt IE 7]>
      <style type="text/css">
       @import url("<?php bloginfo('template_directory'); ?>/ie6style.css");
       .SMsub ul li a:hover{background:#D4EEFC;}
       .SMsgb A {display:block;}
       .SMsgb A:hover{background:#D4EEFC;}
       .SMRtPoCom {cursor:hand;cursor:pointer;background:none;}
        #menuspan {
          position: absolute; left: 0px; bottom: 0px;
        }
        #StartMenu{
          position: absolute; left: 0px; bottom: 30px;
        }
        div#menuspan {
          right: auto; bottom: auto;
          left: expression( ( -0 - menuspan.offsetWidth + ( document.documentElement.clientWidth ? document.documentElement.clientWidth : document.body.clientWidth ) + ( ignoreMe2 = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft ) ) + 'px' );
          top: expression( ( -0 - menuspan.offsetHeight + ( document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight ) + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ) ) + 'px' );
        }
        div#StartMenu {
          /*right: auto; bottom: auto; */
          right: expression( ( -0 - StartMenu.offsetWidth + ( document.documentElement.clientWidth ? document.documentElement.clientWidth : document.body.clientWidth ) + ( ignoreMe2 = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft ) ) + 'px' );
          top: expression( ( -30 - StartMenu.offsetHeight + ( document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight ) + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop ) ) + 'px' );
        }
        #sidebar{background:none;border-left:1px #888 solid;}
      </style>
    <![endif]>
  <![endif]-->
  <!--[if lte IE 7]>
      <style type="text/css">
        .win_in{display:inline-block;width:100%;border:1px #94A5AD solid;background:#fff}
      </style>
  <![endif]--> 
  
  <?php wp_get_archives('type=monthly&format=link'); ?>
  <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
  <?php wp_enqueue_script('jquery'); ?>
  <?php wp_head(); ?>
  <?php default_stylesheet(); time_style(); op_throb();?>
<script>
  var templatedir = "<?php bloginfo('template_directory'); ?>";
</script>

<script src="<?php bloginfo('template_directory'); ?>/js/functions.js" type="text/javascript"></script>
<script type="text/javascript">var $sboxtext="<?php _e('Start Search','inanis'); ?>";</script>
</head>
<body id="bdy">
<div class="clear"><!-- Req'd for IE! --></div>