<?php get_header(); ?>
<?php $options = get_option('elegantbox_options'); ?>

		<?php if (have_posts()) : the_post(); ?>

			<div class="post">
				<div class="title">
					<h2><?php the_title(); ?></h2>
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
					<?php the_content(); ?>
					<div class="fixed"></div>
				</div>

				<div class="comments comments_single">
					<a href="#respond"><?php _e('Leave a comment', 'elegantbox'); ?></a>
					<?php if(pings_open()) : ?>
						 | <a href="<?php trackback_url(); ?>" rel="trackback"><?php _e('Trackback', 'elegantbox'); ?></a>
					<?php endif; ?>
				</div>

				<!-- related posts START -->
				<?php
					if(function_exists('wp23_related_posts')) {
						echo '<div id="related_posts">';
						wp23_related_posts();
						echo '</div>';
					}
				?>
				<!-- related posts END -->
			</div>

<?php
	// Support comments for WordPress 2.7 or higher
	if (function_exists('wp_list_comments')) {
		comments_template('', true);
	} else {
		comments_template();
	}
?>

		<?php else : ?>
			<div class="messagebox">
				<div class="content small">
					<?php _e('Sorry, no posts matched your criteria.', 'elegantbox'); ?>
				</div>
			</div>

		<?php endif; ?>	

	</div>

	<?php $post_backup = $post; get_sidebar(); $post = $post_backup; ?>

	<div class="fixed"></div>

		<div id="bottom">
			<div class="postnav">
				<span class="alignleft"><?php previous_post_link('&laquo; %link') ?></span>
				<span class="alignright"><?php next_post_link('%link &raquo;') ?></span>
				<div class="fixed"></div>
			</div>

<?php get_footer(); ?>
