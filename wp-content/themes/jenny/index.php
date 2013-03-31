<?php get_header(); ?>

	<div id="content" class="narrow">
	
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
		
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="post-header">
				<h2><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
				<p><?php _e('By ','jenny'); ?><?php the_author_posts_link(); ?> | <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_time('F j, Y') ?></a></p>
			</div>

				<?php /*the_content( __('Read more &raquo;', 'jenny') ); */ ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute( ); ?>" rel="bookmark">
				<?php the_post_thumbnail(array( 150, 150 ), array( 'class' => 'alignleft' )); ?>
				</a>
				<?php the_excerpt(); ?>
				<p><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute( ); ?>" rel="bookmark"><?php _e('Read more', 'jenny'); ?> &raquo;</a></p>
			
				<?php wp_link_pages( __('before=<div class="post-page-links">Pages:&after=</div>', 'jenny')) ; ?>
			
			<div class="post-meta">
				<ul>
					<li><?php comments_popup_link( __('Leave your comment', 'jenny'), __( '1 comment', 'jenny'), __('% comments', 'jenny')); ?> &bull; <?php the_category(' &bull; ');?></li>
					<?php the_tags( __('<li>Tagged as: ', 'jenny'), ' &bull; ', '</li>'); ?>
					<li><?php _e('Share on ', 'jenny'); ?><a rel="nofollow" href="http://twitter.com/home?status=Currently reading: <?php the_title(); ?> <?php the_permalink(); ?>" target="_blank"><?php _e('Twitter','jenny'); ?></a>, <a rel="nofollow" href="http://www.facebook.com/share.php?u=<?php the_permalink(); ?>&amp;t=<?php the_title_attribute(); ?>" target="_blank"><?php _e('Facebook', 'jenny'); ?></a>, <a rel="nofollow" href="http://del.icio.us/post?v=4;url=<?php the_permalink(); ?>"  target="_blank"><?php _e('Delicious', 'jenny'); ?></a>, <a rel="nofollow" href="http://digg.com/submit?url=<?php the_permalink(); ?>"  target="_blank"><?php _e('Digg', 'jenny'); ?></a>, <a rel="nofollow" href="http://www.reddit.com/submit?url=<?php the_permalink(); ?>&amp;title=<?php the_title_attribute(); ?>"  target="_blank"><?php _e('Reddit', 'jenny'); ?></a></li>
					<?php edit_post_link(__('Edit this post','jenny'), '<li>', '</li>'); ?>
				</ul>
			</div>
		</div><!--#posts-->

		<?php endwhile; ?>

		<?php if (show_posts_nav()) : ?>
		
		<div class="post-navigation">
		<?php if(function_exists('wp_pagenavi')) {
				wp_pagenavi();
			}else{
		?>
			<ul>
				<li><?php next_posts_link( __('&laquo; Previous Page')) ?></li>
				<li><?php previous_posts_link( __('Next Page &raquo;')) ?></li>
			</ul>
		<?php } ?>
		</div>
		
		<?php endif; ?>
		
	<?php else : ?>
		
		<h2 class="page-title"><?php _e('Not Found', 'jenny'); ?></h2>
		<p><?php _e('Sorry, but you are looking for something that is not here.', 'jenny'); ?></p>
		<?php get_search_form(); ?>
		
	<?php endif; ?>

	</div><!--#content-->
	<hr />
	
		
	<?php get_sidebar(); ?>
	<?php get_footer(); ?>
