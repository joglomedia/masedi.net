<?php
/*
Template Name: Page Template
*/
?>
<?php get_header(); ?>

<div id="container">
	<div id="main">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<div class="title_page">
				<h2><?php the_title(); ?></h2>
			</div>
		
			<div class="entry">
				<?php the_content('<p class="read_rest">Read the rest of this entry</p>'); ?>
			</div>
    <?php endwhile; ?>
		</div><!-- end post -->
		<?php endif; ?>
		<!-- comments are closed by default -->
    <?php //comments_template(); ?>
  </div><!-- end main -->
<?php get_sidebar(); ?>
</div><!-- end container -->
<?php get_footer(); ?>