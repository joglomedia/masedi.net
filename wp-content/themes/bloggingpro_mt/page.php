<?php get_header(); ?>

<!-- Side Central START -->
<div class="SCS">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		<h1><?php the_title(); ?></h1>
			<div class="entry">
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

			</div>
<?php endwhile; ?>
		
<?php else : ?>
<h2 class="center">Not Found</h2>
<p class="center"><?php _e("Sorry, but you are looking for something that isn't here."); ?></p>

<?php endif; ?> 
</div> 
<!--  Side Central END -->
</div> 
<?php get_sidebar(); ?>
<?php get_footer(); ?>