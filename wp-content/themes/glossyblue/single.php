<?php get_header(); ?>

	<div id="content">

	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>

		<div class="post">
			<div class="post-date"><span class="post-month"><?php the_time('M') ?></span> <span class="post-day"><?php the_time('j') ?></span></div>
			<div class="post-title">
				<h2><?php the_title(); ?></h2>
				<span class="post-cat"><?php the_category(', ') ?></span> 
			</div>
			<div class="entry">

				<?php the_content('Read the rest of this entry &raquo;'); ?>

				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

			</div>
			
			<?php comments_template(); ?>
			
		</div>

		<?php endwhile; ?>

		<div class="navigation"> 
			<span class="previous-entries"><?php previous_post_link(' %link') ?></span>
			<span class="next-entries"><?php next_post_link('%link') ?></span> 
		</div>

	<?php else : ?>

		<h2>Not Found</h2>
		<p>Sorry, but you are looking for something that isn't here.</p>

	<?php endif; ?>

	</div>
	<!--/content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>