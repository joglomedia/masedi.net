<?php get_header() ?>
<!-- #content from here -->
<div id="post">
  <br />
<?php the_post(); ?>
  <h1><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h1>
  <div class="dots"></div>
  <span class="details">Posted <?php unset($previousday); printf(__('%1$s &#8211; %2$s'), the_date('', '', '', false), get_the_time()) ?> in: <?php printf(get_the_category_list(', ')); ?></span>
  <?php the_content(''.('read more &raquo;').''); ?>
  <span class="tags">&nbsp; Tags: <?php the_tags('', ', ', ' '); ?></span>
 
  <div class="entry-status">
		<span><?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) : // Comments and trackbacks open ?>
		 
		 <?php elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) : // Only trackbacks open ?>
		 <?php printf(__('Comments are closed, but you can <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">leave a trackback</a>', 'sandbox'), get_trackback_url()) ?>
		 <?php elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) : // Only comments open ?>
		 <?php printf(__('Trackbacks are closed, but you can <a class="comment-link" href="#respond" title="Post a comment">post a comment</a>', 'sandbox')) ?>
		 <?php elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) : // Comments and trackbacks closed ?>
		 <?php _e('Both comments and trackbacks are currently closed') ?>
		 <?php endif; ?>
		</span>
  </div>  

  <div class="navigation">
	  <div class="alignleft"><?php next_posts_link(__('<span class="meta-nav">&laquo;</span> Older posts')) ?></div>
		<div class="alignright"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&raquo;</span>')) ?></div>
  </div>			
</div>
<?php comments_template('', true); ?>
<!-- #content ends here -->		
</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
