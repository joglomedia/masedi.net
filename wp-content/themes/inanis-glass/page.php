<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'page.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
?>
<?php get_header(); ?>
  <div id="page">
    <div id="colwrap">
    <?php include 'banner.php'; ?>
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <?php if ($TimeStyle=="2"){$PostTime=get_the_time('G:i');$Post_Modified=get_the_modified_date('H:i');}else{$PostTime=get_the_time('g:i A');$Post_Modified=get_the_modified_date('h:i A');} ?>
      <div class="win"> 
        <div class="win_tl"></div><div class="win_t"></div><div class="win_tr"></div><div class="win_bl"></div><div class="win_b"></div><div class="win_br"></div><div class="win_r"></div><div class="win_l"></div>
        <div class="win_title"><span class="win_tbl">&nbsp;</span><h3><?php the_title(); ?></h3><span class="win_tbr">&nbsp;</span></div>
        
        <div class="win_ted">
          <div class="win_edt"><?php edit_post_link(__('edit','inanis'),'[ ',' ] '); ?></div>
          <div class="win_pd"></div>
        </div>                                                                                     
        <div class="win_bg"></div><div class="win_tlgr"></div><div class="win_trgr"></div>
        <div class="win_out">
          <div class="win_in">
            <div class="win_post">
              <?php 
                  $content = get_the_content(__('More','inanis').' &raquo;');
                  $content = str_replace('<embed', '<embed wmode="transparent"', $content);
                  $content = str_replace('</object>', '<param name="wmode" value="transparent" /></object>', $content);
                  $content = apply_filters('the_content', $content);
                  echo $content;
                  wp_link_pages();
                ?> 
            </div>
            
            <div class="win_info">
              <div class="win_infot"></div>
              <div class="win_infod">
                <a rel="nofollow" href="mailto:?subject=<?php the_title(); ?>&amp;body=<?php _e('I thought you might like this','inanis'); ?>: <?php the_permalink() ?>"><?php _e('Email','inanis');?></a> &bull; 
                <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to','inanis');?> <?php the_title(); ?>"><?php _e('Permalink','inanis') ?></a> 
                
              </div> 
              <img class="win_infoi" src="<?php bloginfo('template_directory'); ?>/images/question.png" alt="Info" />
              <div class="win_infoc">
                <strong><?php _e('Date Posted','inanis');?>:</strong> <?php the_time('d M Y') ?> @ <?php echo $PostTime; ?><br />
                <strong><?php _e('Last Modified','inanis');?>:</strong> <?php the_modified_date('d M Y'); ?> @ <?php echo $Post_Modified; ?><br />
                <strong><?php _e('Posted By','inanis');?>:</strong> <?php the_author() ?><br />
              </div>
            </div>
          </div> 
        </div>
      </div>

      
      <?php comments_template(); ?>
      
      <?php endwhile; ?>

      <?php endif; ?>
      <div style="clear:right;"></div>
      </div>
    </div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
