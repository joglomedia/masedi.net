<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'banner.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
?>
  <div id="wrapper"></div>
      <div class="win"> 
        <div class="win_tl"></div><div class="win_t"></div><div class="win_tr"></div><div class="win_bl"></div><div class="win_b"></div><div class="win_br"></div><div class="win_r"></div><div class="win_l"></div>
        <div class="win_title"></div>
        <div class="win_ted">
          <div class="win_edt"></div>
          <div class="win_pd"></div>
        </div>                                                                                     
        <div class="win_bgb"></div>
        <div class="win_outb">
          <div class="banner">
              <img class="blogicon" src="<?php bloginfo('template_directory'); ?>/images/blogicon.png" alt="Blog Icon" />
              <?php 
              $blog_title = get_bloginfo(); 
              if ($blog_title==""){echo '';}
              else {echo '<h1><a href="'.get_bloginfo('url').'">'.$blog_title.'</a></h1>';}
              ?>
              <div class="blogdesc"><?php bloginfo('description'); ?></div>    
              <div class="fadeThis"><div id="sizer"></div></div>
          </div> 
        </div>
      </div>
  <hr class="rule" />
  <!--[if gte IE 5.5]>
    <![if lt IE 7]>
    <div><h4 class="ie6"><?php _e('You are using Internet Explorer 6, or older. We highly suggest that you seek out an alternative or newer web browser, to bring your web surfing experience up to current standards.','inanis');?></h4></div>
    <![endif]>
  <![endif]-->