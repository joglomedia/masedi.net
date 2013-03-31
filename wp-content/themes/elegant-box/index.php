<?php get_header(); ?>
<?php
	$options = get_option('elegantbox_options');
	if (function_exists('wp_list_comments')) {
		add_filter('get_comments_number', 'comment_count', 0);
	}
?>

		<?php if ($options['notice']) : ?>
			<div id="notice">
				<div class="inner">
					<?php if ($options['notice_icon']) : ?>
						<img class="icon" src="<?php bloginfo('template_url'); ?>/images/transparent.gif" alt="notice" />
					<?php endif; ?>
					<div class="content"><?php echo($options['notice_content']); ?></div>
					<div class="fixed"></div>
				</div>
			</div>
		<?php endif; ?>

		<?php if (have_posts()) : while (have_posts()) : the_post(); update_post_caches($posts); ?>

				<div class="post">
					<div class="title">
						<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						<div class="fixed"></div>
					</div>

					<div class="info">
						<?php edit_post_link(__('Edit', 'elegantbox'), '<span class="edit">', '</span>'); ?>

						<span><?php the_time(__('F jS, Y', 'elegantbox')) ?></span>
						<?php if ($options['categories']) : ?>
							<span><?php _e(' | Categories: ', 'elegantbox'); ?><?php the_category(', ') ?></span>
						<?php endif; ?>
						<?php if ($options['tags']) : ?>
							<span><?php _e(' | Tags: ', 'elegantbox'); ?><?php the_tags('', ', ', ''); ?></span>
						<?php endif; ?>

						<div class="fixed"></div>
					</div>

					<div class="content">
						<?php the_content(__('Read more...', 'elegantbox')); ?>
						<div class="fixed"></div>
					</div>

					<div class="comments">
						<?php comments_popup_link(__('0 comments', 'elegantbox'), __('1 comment', 'elegantbox'), __('% comments', 'elegantbox')); ?>
						<?php if (function_exists('the_views')) : ?>
							(<?php the_views(); ?>)
						<?php endif; ?>
					</div>
				</div>

		<?php endwhile; else : ?>
			<div class="messagebox">
				<div class="content small">
					<?php _e('Sorry, no posts matched your criteria.', 'elegantbox'); ?>
				</div>
			</div>

		<?php endif; ?>
	</div>

	<?php get_sidebar(); ?>

	<div class="fixed"></div>

		<div id="bottom">
			<div class="postnav">

	<?php if(function_exists('wp_pagenavi')) : ?>
				<?php wp_pagenavi() ?>
	<?php else : ?>
				<span class="alignleft"><?php previous_posts_link(__('&laquo; Newer Entries', 'elegantbox')); ?></span>
				<span class="alignright"><?php next_posts_link(__('Older Entries &raquo;', 'elegantbox')); ?></span>
	<?php endif; ?>

				<div class="fixed"></div>
			</div>

<?php get_footer(); ?>
