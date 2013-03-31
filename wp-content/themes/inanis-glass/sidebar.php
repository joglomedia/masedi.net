<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'sidebar.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
?>
<div id="sidebar">
  <div class="bp">
    <div class="bpt"><img src="<?php bloginfo('template_directory'); ?>/images/1pxtrans.gif" alt=" " /></div>
    <div class="bpm"><div id="bp"><img src="<?php bloginfo('template_directory'); ?>/images/1pxtrans.gif" alt=" " /></div></div>
    <div class="bpb"><img src="<?php bloginfo('template_directory'); ?>/images/1pxtrans.gif" alt=" " /></div>
  </div>
  
  <?php /* Single */ if(is_single() && !is_attachment()) { ?>
  <div class="sidebar-top"><img src="<?php bloginfo('template_directory'); ?>/images/1pxtrans.gif" alt=" " /></div>
  <div class="sidebar-mid">
    <h3><?php _e('About this Post','inanis');?></h3>    
    <?php rewind_posts(); ?>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <p>&raquo; <b><?php _e('Title','inanis');?>:</b> <a href="<?php the_permalink() ?>" title="<?php _e('Permanent Link','inanis');?>: <?php the_title(); ?>"><?php the_title(); ?></a><br />&raquo; <b><?php _e('Posted','inanis');?>:</b> <?php the_time('F jS, Y'); ?><br />&raquo; <b><?php _e('Author','inanis');?>:</b> <?php the_author_posts_link(); ?><br />&raquo; <b><?php _e('Filed Under','inanis');?>:</b> <?php the_category(',') ?>.</p>
    <?php endwhile; endif; ?>
    <?php rewind_posts(); ?>
    <?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
    
    // Both Comments and Pings are open ?>
    <p><?php comments_number('&raquo; '.__('There are no responses','inanis'),'&raquo; '.__('There is one response','inanis'),'&raquo; '.__('There are % responses','inanis')); ?>.</p>
    <p>&raquo;  <a href="#comments"><?php _e('Read comments','inanis');?></a>, <a href="#post"><?php _e('respond','inanis');?></a> <?php _e('or follow responses via','inanis');?> <?php comments_rss_link(__("RSS",'inanis')); ?>.</p>
    <p><span id="trackback">&raquo; 
    <a href="<?php trackback_url() ?>" title="<?php _e('Copy this URI to trackback this entry.','inanis');?>" rel="nofollow"><?php _e('Trackback this entry','inanis');?>.</a></span></p>
    <?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
    
    // Only Pings are Open ?>
    <p><span id="trackback">
    <a href="<?php trackback_url() ?>" title="<?php _e('Copy this URI to trackback this entry.','inanis');?>" rel="nofollow"><?php _e('Trackback this entry','inanis');?>.</a></span></p>
    <?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
    
    // Comments are open, Pings are not ?>
    <p><?php comments_number('&raquo; '.__('There are no responses','inanis'),'&raquo; '.__('There is one response','inanis'),'&raquo; '.__('There are % responses','inanis')); ?>.</p>
    <p>&raquo;  <a href="#comments"><?php _e('Read comments','inanis');?></a>, <a href="#post"><?php _e('respond','inanis');?></a> <?php _e('or follow responses via','inanis');?> <?php comments_rss_link(__("RSS",'inanis')); ?>.</p>
    <?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
    // Neither Comments, nor Pings are open ?>
  <?php } ?>
  </div>
  <div class="sidebar-bottom"><img src="<?php bloginfo('template_directory'); ?>/images/1pxtrans.gif" alt=" " /></div>

  <?php if ((function_exists('related_posts'))) { ?>
  <div class="sidebar-top"><img src="<?php bloginfo('template_directory'); ?>/images/1pxtrans.gif" alt=" " /></div>
  <div class="sidebar-mid">
  <h3><?php _e('Related Posts','inanis');?></h3>
  <ul>
  <?php related_posts($limit, $len, '$before_title', '$after_title', '$before_post', '$after_post', $show_pass_post, $show_excerpt); ?>
  </ul>
  </div>
  <div class="sidebar-bottom"><img src="<?php bloginfo('template_directory'); ?>/images/1pxtrans.gif" alt=" " /></div>
  <?php } ?>
  <?php } ?>

  <?php /* attachment */ if(is_attachment()) { ?>
  <div class="sidebar-top"><img src="<?php bloginfo('template_directory'); ?>/images/1pxtrans.gif" alt=" " /></div>
  <div class="sidebar-mid">
    <h3><?php _e('Attachment...','inanis');?></h3>    
    <?php rewind_posts(); ?>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <p>&raquo; <b><?php _e('Title','inanis');?>:</b> <a href="<?php the_permalink() ?>" title="<?php _e('Permanent Link','inanis');?>: <?php the_title(); ?>"><?php the_title(); ?></a><br />&raquo; <b><?php _e('Posted','inanis');?>:</b> <?php the_time('F jS, Y'); ?><br />&raquo; <b><?php _e('Author','inanis');?>:</b> <?php the_author_posts_link(); ?><br /></p>
    <?php endwhile; endif; ?>
  </div>
  <div class="sidebar-bottom"><img src="<?php bloginfo('template_directory'); ?>/images/1pxtrans.gif" alt=" " /></div>

  <?php if ((function_exists('related_posts'))) { ?>
  <div class="sidebar-top"><img src="<?php bloginfo('template_directory'); ?>/images/1pxtrans.gif" alt=" " /></div>
  <div class="sidebar-mid">
  <h3><?php _e('Related Posts','inanis');?></h3>
  <ul>
  <?php related_posts($limit, $len, '$before_title', '$after_title', '$before_post', '$after_post', $show_pass_post, $show_excerpt); ?>
  </ul>
  </div>
  <div class="sidebar-bottom"><img src="<?php bloginfo('template_directory'); ?>/images/1pxtrans.gif" alt=" " /></div>
  <?php } ?>
  <?php } ?>

    <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar') ) : else : ?>

    <div class="sidebar-top"><img src="<?php bloginfo('template_directory'); ?>/images/1pxtrans.gif" alt=" " /></div>
    <div class="sidebar-mid">
      <h3><?php _e('Recent Posts','inanis');?></h3>
      <ul>
        <?php wp_get_archives('type=postbypost&limit=10'); ?>
      </ul>
    </div>
    <div class="sidebar-bottom"><img src="<?php bloginfo('template_directory'); ?>/images/1pxtrans.gif" alt=" " /></div>
    <?php endif; ?>
    
  <?php
  global $DiscOn, $Disclaimer;
  include "useroptions.php";
  if ($DiscOn != 0){
  ?>
  <div class="sidebar-top"><img src="<?php bloginfo('template_directory'); ?>/images/1pxtrans.gif" alt=" " /></div>
  <div class="sidebar-mid">
    <h3><?php _e('Disclaimer','inanis');?></h3>
      <p><small><?php echo $Disclaimer; ?></small></p>

        <p class="ctr">
          <a href="http://www.wordpress.org"><img src="<?php bloginfo('template_directory'); ?>/images/wplogo_32.png" alt="" /></a>  <a href="http://www.inanis.net/"><img src="<?php bloginfo('template_directory'); ?>/images/ilogo_32.png" alt="" /></a>
        </p>
  </div>
  <div class="sidebar-bottom"><img src="<?php bloginfo('template_directory'); ?>/images/1pxtrans.gif" alt=" " /></div>
  <?php } ?>
</div>
<hr class="rule" />