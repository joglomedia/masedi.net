<?php get_header() ?>
<!-- #content from here -->
<div id="post">
  <br />
<?php while ( have_posts() ) : the_post() ?>  
  <h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
  <div class="dots"></div> 
  <span class="details">Posted <?php unset($previousday); printf(__('%1$s &#8211; %2$s'), the_date('', '', '', false), get_the_time()) ?> in: <?php printf(get_the_category_list(', ')); ?></span>
  <?php the_content(''.('read more &raquo;').''); ?> 
  <span class="comments"> &nbsp; <?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?> &nbsp;|&nbsp; Tags: <?php the_tags('', ', ', ' '); ?></span>  

<?php endwhile ?>
  <div id="nav-below">
	  <div class="nav-previous">&nbsp; <?php next_posts_link(__('<span class="meta-nav">&laquo;</span> Older posts')) ?></div>
		<div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&raquo;</span>')) ?><br />&nbsp;</div>
  </div>			
</div>
<!-- #content ends here -->		
</div>
</div>
<?php  get_sidebar(); ?>
<?php get_footer(); ?>