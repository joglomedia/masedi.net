<?php get_header() ?>
<!-- #content from here -->
<div id="post">
  <br />  
  <?php the_post(); ?>  

  <?php if ( is_day() ) : ?>
  <h1><?php printf(__('Daily Archives: <span style="color: #c1e66d;">%s</span>'), get_the_time(get_settings('date_format'))) ?></h1>
  <?php elseif ( is_month() ) : ?>
  <h1><?php printf(__('Monthly Archives: <span style="color: #c1e66d;">%s</span>'), get_the_time('F Y')) ?></h1>
  <?php elseif ( is_year() ) : ?>
  <h1><?php printf(__('Yearly Archives: <span style="color: #c1e66d;">%s</span>'), get_the_time('Y')) ?></h1>
  <?php elseif ( isset($_GET['paged']) && !empty($_GET['paged']) ) : ?>
  <h1><?php _e('Blog Archives') ?></h2>
  <?php endif; ?>
  
  <?php rewind_posts() ?>
	
<?php while ( have_posts() ) : the_post() ?>  

  <h1><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h1>
  <div class="dots"></div>
  <span class="details">Posted <?php unset($previousday); printf(__('%1$s &#8211; %2$s'), the_date('', '', '', false), get_the_time()) ?> in: <?php printf(get_the_category_list(', ')); ?></span>
  <?php the_excerpt(__('Read more'));?>
  <span class="comments"> &nbsp; <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?> &nbsp;|&nbsp; Tags: <?php the_tags('', ', ', ' '); ?></span>

<?php endwhile ?>

  <div id="nav-below">
	  <div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&laquo;</span> Older posts')) ?></div>
		<div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&raquo;</span>')) ?><br />&nbsp;</div>
  </div>			
</div>
<!-- #content ends here -->		
</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
