<?php get_header(); ?>

<div id="wrap">
<div id="content">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="line"></div>
	
	<h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
	<div id="data"><span style="font-size:10px;">POSTED BY</span> <span style="font-size:13px; font-weight:bold"><?php the_author_posts_link(); ?></span> on <span style="font-weight:bold"><?php the_time('M j'); ?></span> under <?php the_category(', ') ?></div>
	<?php the_excerpt(__('Read more'));?>
 	
	<div id="postinfo">
	<p><?php comments_popup_link('Comment', '1 Comment', '% Comments'); ?>

</div>
	<!--
	<?php trackback_rdf(); ?>
	-->
	
	<?php endwhile; else: ?>
	<p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
	<p><?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')); ?></p>
	
</div>

<!-- The main column ends  -->

<?php get_sidebar(); ?>
<?php get_footer(); ?></div>