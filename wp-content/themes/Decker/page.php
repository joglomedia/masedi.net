<?php get_header() ?>
<!-- #content from here -->
<div id="post">
  <br />
<?php the_post(); ?>  

  <h1><a href="#"><?php the_title() ?></a></h1>
  <div class="dots"></div>
  <?php the_content(); ?>
  <?php edit_post_link(__('Edit', ''), "<span class=\"edit-link\">", "</span>"); ?>
			
</div>
<!-- #content ends here -->		
</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
