<?php get_header(); ?>

	<div id="content">

	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>

		<div class="post">
			<div class="post-date"><span class="post-month"><?php the_time('M') ?></span> <span class="post-day"><?php the_time('j') ?></span></div>
			<div class="post-title">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
				<span class="post-cat"><?php the_category(', ') ?></span> 
				<span class="post-comments"><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></span> 
			</div>
			<div class="entry">
				<?php the_content('Read the rest of this entry &raquo;'); ?>
			</div>
		</div>

		<?php endwhile; ?>

		<div class="navigation"> 
			<span class="previous-entries"><?php next_posts_link('Older Entries') ?></span>
			<span class="next-entries"><?php previous_posts_link('Newer Entries') ?></span> 
		</div>

	<?php else : ?>

		<h2>Not Found</h2>
		<p>Sorry, but you are looking for something that isn't here.</p>

	<?php endif; ?>

	</div>
	<!--/content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>