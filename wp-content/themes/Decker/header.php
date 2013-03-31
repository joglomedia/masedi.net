<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php if (is_home () ) { bloginfo('name'); }
elseif ( is_category() ) { single_cat_title(); echo ' - ' ; bloginfo('name'); }
elseif (is_single() ) { single_post_title();}
elseif (is_page() ) { single_post_title();}
else { wp_title(‘’,true); } ?></title>
<meta name="google-site-verification" content="mzZ1v5t6I38_A2-cLzdua5il1Hvy1ZUNzjrYFJk2KVM" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style.css" />
		<!--[if IE 6]>
		 <style type="text/css">
			/*<![CDATA[*/
			div#about_author {width: 719px;};
			div#ad1{margin-left: 5px;};
			div#ad2{margin-right: 5px;};
			div#ad3{margin-left: 5px;};
			div#ad4{margin-right: 5px;};
			div#post .dots{margin-top: 0px;};
			div#content .comments{margin: 10px 0 20px 10px;};
			div#blogroll {width: 280px;};
			div#post .details{margin: -14px 0 12px 23px;};
			div#content{margin: 0 280px 0 0px;};
			div#content .comments{width: 658px;};
      /*]]>*/
      </style>
      <![endif]-->
    
	  <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" /> 
	  <link rel="pingback" href="xmlrpc.php" />
	  <link rel="EditURI" type="application/rsd+xml" title="RSD" href="xmlrpc.php?rsd" />
    <link rel="wlwmanifest" type="application/wlwmanifest+xml" href="wlwmanifest.xml" /> 

    
</head>
<body>
<div id="container">
  <div id="header">
       <div id="logo">
<?Php if(is_single()) {?>
           <a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('description');?>"><?php bloginfo('name'); ?></a>
<?Php }else{ ?>
           <h1><a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('description');?>"><?php bloginfo('name'); ?></a></h1>
<?Php } ?>
<?Php if(is_single()) { ?>
           <div id="sub" style="font-weight:bold;"><?php bloginfo('description');?></div>
<?Php }else{ ?>
           <div id="sub"><h2><?php bloginfo('description');?></h2></div>
<?Php } ?>
            <!-- <a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('description');?>"><img src="<?php bloginfo('template_directory'); ?>/images/logo.gif" alt="<?php bloginfo('description');?>" /></a> -->
        </div>
        <div id="search">
           <form role="search" id="searchform" action="<?php bloginfo('url'); ?>" method="get">
               <input onfocus="this.value=''" type="text" name="s" value="Type here your search" class="textfield" style="display: inline;"/><input type="image" src="<?php bloginfo('template_directory'); ?>/images/button-search.gif" style="display: inline;" />
           </form>

        </div>
		</div>
		<div id="header2">
		   <div id="header2_left">
<ul>
			<li><a href="<?php bloginfo('url'); ?>" title="<?Php bloginfo('description');?>">Home</a></li>
<?php
    		if($post->post_parent)
    		$children = wp_list_pages("title_li=&echo=0");
    		else
    		$children = wp_list_pages("title_li=&echo=0");
    		
          echo $children;
?>
</ul>
		   </div>
		   <div id="header2_right">
<ul>
<li class="feed2"><img src="<?php bloginfo('template_directory'); ?>/images/feed2.gif" alt="" /><a href="http://feeds.feedburner.com/noxier">&nbsp;Subcribe via RSS</a></li>
<li class="feedemail"><img src="<?php bloginfo('template_directory'); ?>/images/email2.gif" alt="" /><a href="http://www.feedburner.com/fb/a/emailverifySubmit?feedId=noxier">&nbsp;Subcribe via Email</a></li>

<li><?php wp_loginout(); ?></li>
</ul>
			 </div>
		</div>
<div style="clear:both;"></div>
<div id="wrapper">
  <div id="content">
    <!--
    <div id="about_author">
      <?php include (TEMPLATEPATH . '/about-author.txt'); /* Open about-author.txt to edit */?> 
		</div>
		-->
