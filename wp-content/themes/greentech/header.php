<?php include(TEMPLATEPATH."/config.inc.php");?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">

<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<meta name="distribution" content="global" />

<meta name="robots" content="follow, all" />

<meta name="language" content="en, sv" />



<title><?php if (is_home () ) { bloginfo(�name�); }
elseif ( is_category() ) { single_cat_title(); echo ' - ' ; bloginfo(�name�); }
elseif (is_single() ) { single_post_title();}
elseif (is_page() ) { single_post_title();}
else { wp_title(��,true); } ?></title>

<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />

<!-- leave this for stats please -->



<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php if($db_feedburner_address) { echo $db_feedburner_address; } else { bloginfo('rss2_url'); } ?>" /><?php /* if you put your feedburner into the theme options, the autodiscover will use that instead of the WP default feed */ ?>

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php wp_get_archives('type=monthly&format=link'); ?>

<?php wp_head(); ?>

<style type="text/css" media="screen">

<!-- @import url( <?php bloginfo('stylesheet_url'); ?> ); -->

</style>



</head>



<body>



<div id="header">



<h1 class="mainHeading"><a href="<?php bloginfo('url'); ?>" title="<?php _e('Home'); ?>"><?php bloginfo('name'); ?></a></h1><ul class="headerMenu">

<li><a href="<?php if($db_feedburner_address) { echo $db_feedburner_address; } else { bloginfo('rss2_url'); }?>" class="rssIco"></a></li>

<li><a href="#" class="emailIco"></a></li></ul>

<div class="clearer"></div>





<div class="search_header"><form id="searchform_header" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>"><input type="text" name="s" id="s" value="Search this site..." onfocus="if (this.value == 'Search this site...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search this site...';}" /></form></div>



   	 





<div class="TopMenu">



   <ul>

     <?php wp_list_pages('depth=1&sort_column=menu_order&title_li=' . __('') . '' ); ?>

   </ul>

</div>





 





</div>





