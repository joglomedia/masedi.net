<?php get_header(); ?>

<div id="wrap">
<div id="content">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="line"></div>
	<h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
	<div id="data"><span style="font-size:10px;">POSTED BY</span> <span style="font-size:13px; font-weight:bold"><?php the_author_posts_link(); ?></span> on <span style="font-weight:bold"><?php the_time('M j'); ?></span> under <?php the_category(', ') ?></div>
	<?php the_content(__('Read more'));?>

	<div id="postinfo">
	<p><?php comments_popup_link('Comment', '1 Comment', '% Comments'); ?>

</div>

	<!--
	<?php trackback_rdf(); ?>
	-->
	
	<?php comments_template(); // Get wp-comments.php template ?>
	<?php endwhile; else: ?><?php endif; ?>
	
<div class="prevnext">

					<div class="alignleft">
						<?php next_posts_link('&laquo; Previous Entries') ?>
					</div>

					<div class="alignright">
						<?php previous_posts_link('Next Entries &raquo;') ?>
					</div>

                		</div>

	
</div>

<!-- The main column ends  -->

<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>