<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && '404.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
?>
<?php get_header(); ?>
  <div id="page">
    <div id="colwrap">
    <?php include 'banner.php'; ?>
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
            <h1 class="ctr"><?php _e('Error 404 - Not found','inanis'); ?></h1>
          </div>
        </div>
      </div>
      <div style="clear:right;"></div>
      </div>
    </div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
