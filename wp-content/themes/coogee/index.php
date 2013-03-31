<?php get_header(); ?>
<div id="container">
  <div id="main">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			
			<div class="postdate">
        <div class="month"><?php the_time('M') ?></div>
        <div class="date"><?php the_time('d') ?></div>
      </div><!-- end postdate-->
			<div class="title">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanet Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
				<div class="postmeta">
					<span class="postmeta_author"><?php the_author() ?></span>
          <span class="postmeta_category"><?php the_category(', ') ?></span>
        	<span class="postmeta_comments"><?php comments_popup_link('Add you comment', '1 comment', '% comments'); ?></span>
        </div><!-- end postmeta -->
		  </div><!-- end title -->
			
      <div class="entry">
			  <?php the_content('<p class="read_rest">Read the rest of this entry</p>'); ?>
			  <div style="clear:both;"></div>
        <?php the_tags('<span class="tags">',', ','</span>'); ?>
      </div><!-- end entry -->
    </div><!-- end post -->
    <?php endwhile; ?>
			
    	<div class="navi">
        <div class="left"><?php next_posts_link('&laquo; Previous Entries'); ?></div>
			  <div class="right"><?php previous_posts_link('Next Entries &raquo;'); ?></div>
      </div><!-- end navi -->
			
    <?php else : ?>
      
			<div class="post">
				<div class="title"><h2>Sorry, nothing found!</h2></div>
					<p>Sorry, nothing found! Please use the SEARCH on the sidebar, or visit our ARCHIVES page.</p>
		  </div><!-- end post -->
		  
    <?php endif; ?>
  </div><!-- end main -->
<?php get_sidebar(); ?>
</div><!-- end container -->
<?php get_footer(); ?>