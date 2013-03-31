<?php get_header() ?>
<!-- #content from here -->
<div id="post">
  <br />
<?php if (have_posts()) : ?>
  <h1><?php _e('Search results for:') ?> <span class="search-terms"><?php echo wp_specialchars(stripslashes($_GET['s']), true); ?></span></h1>
  
	<?php while ( have_posts() ) : the_post() ?>
  <h1><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h1>
  <div class="dots"></div>
  <span class="details">Posted <?php unset($previousday); printf(__('%1$s &#8211; %2$s'), the_date('', '', '', false), get_the_time()) ?> in: <?php printf(get_the_category_list(', ')); ?></span>
  <?php the_excerpt(); ?>
  <?php endwhile ?>  

  <div id="nav-below">
	  <div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&laquo;</span> Older posts')) ?></div>
		<div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&raquo;</span>')) ?><br />&nbsp;</div>
  </div>
	<?php else : ?>
	<h1><?php _e('Nothing found searching for:') ?> <span class="search-terms"><?php echo wp_specialchars(stripslashes($_GET['s']), true); ?></span></h1>
  <p><?php _e('Please try again with some different keywords.') ?></p>
	
	<?php endif; ?>
				
</div>
<!-- #content ends here -->		
</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
