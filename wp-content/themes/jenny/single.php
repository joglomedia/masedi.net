<?php get_header(); ?>
<div id="content" class="narrow">
<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
		<div <?php post_class(); ?>>
		<div class="post-header">
			<h1><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
			<p><?php _e('By', 'jenny');?> <?php the_author_posts_link(); ?> | <?php the_time('F j, Y') ?></p>
		</div>
			
		<!--Show Ads Below Post Title -->
		<?php if (get_option('p2h_posttop_adcode') != '') { ?>
		<div class="alignleft"><span>Advertisements</span><br />
		<?php echo(stripslashes (get_option('p2h_posttop_adcode')));?>
		</div>
		<?php } ?>
			
		<?php the_content( __('<p>Read more &raquo;</p>', 'jenny') ); ?>
		<?php wp_link_pages( __('before=<div class="post-page-links">Pages:&after=</div>', 'jenny')) ; ?>
			
		<!--Show Ads Below Post -->
		<?php if (get_option('p2h_postend_adcode') != '') { ?>
		<div class="bottomad">
		<?php echo(stripslashes (get_option('p2h_postend_adcode')));?>
		</div>
		<?php } ?>
		
		<div class="post-meta">
		<ul><li><?php comments_popup_link( __('Leave your comment', 'jenny'), __( '1 comment', 'jenny'), __('% comments', 'jenny')); ?> &bull; <?php the_category(' &bull; ');?></li>
		<?php the_tags( __('<li>Tagged as: ', 'jenny'), ' &bull; ', '</li>'); ?>
		<li><?php _e('Share on ', 'jenny'); ?><a rel="nofollow" href="http://twitter.com/home?status=Currently reading: <?php the_title(); ?> <?php the_permalink(); ?>"  target="_blank"><?php _e('Twitter','jenny'); ?></a>, <a rel="nofollow" href="http://www.facebook.com/share.php?u=<?php the_permalink(); ?>&amp;t=<?php the_title_attribute(); ?>"  target="_blank"><?php _e('Facebook', 'jenny'); ?></a>, <a rel="nofollow" href="http://del.icio.us/post?v=4;url=<?php the_permalink(); ?>"  target="_blank"><?php _e('Delicious', 'jenny'); ?></a>, <a rel="nofollow" href="http://digg.com/submit?url=<?php the_permalink(); ?>"  target="_blank"><?php _e('Digg', 'jenny'); ?></a>, <a rel="nofollow" href="http://www.reddit.com/submit?url=<?php the_permalink(); ?>&amp;title=<?php the_title_attribute(); ?>"  target="_blank"><?php _e('Reddit', 'jenny'); ?></a></li>
		<?php edit_post_link(__('Edit this post','jenny'), '<li>', '</li>'); ?>
		</ul>
		</div>
			
		<!--Next Previous Links-->
		<ul class="next-prev-links">
			<li><?php previous_post_link('%link',  __('&laquo;Previous Post','jenny') );?></li>
			<li><?php next_post_link('%link', __('Next Post &raquo;','jenny') ); ?></li>
		</ul>	

		</div><!--#post-->

		<?php endwhile; ?>
		
<?php else : ?>
	<h2 class="page-title">Not Found</h2>
	<p>Sorry, but you are looking for something that isn't here.</p>
	<?php get_search_form(); ?>
				
	<script type="text/javascript">
		// focus on search field after it has loaded
		document.getElementById('s') && document.getElementById('s').focus();
	</script>			
<?php endif; ?>
<?php comments_template(); ?>
</div><!--#content-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>