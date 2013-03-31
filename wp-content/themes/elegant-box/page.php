<?php get_header(); ?>

		<?php if (have_posts()) : the_post(); ?>
			<div class="post">
				<div class="title">
					<h2><?php the_title(); ?></h2>
					<div class="fixed"></div>
				</div>
				<div class="info">
					<?php edit_post_link(__('Edit', 'elegantbox'), '<span class="edit">', '</span>'); ?>
					<span><?php _e('Update: ', 'elegantbox'); the_modified_time(__('F jS, Y', 'elegantbox')) ?></span>
					<div class="fixed"></div>
				</div>
				<div class="content">
					<?php the_content(); ?>
					<div class="fixed"></div>
				</div>
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

	<?php get_sidebar(); ?>

	<div class="fixed"></div>

		<div id="bottom">

<?php get_footer(); ?>
