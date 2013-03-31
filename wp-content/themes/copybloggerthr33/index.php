<?php get_header(); ?>

	<div id="content_box">
	
		<div id="left_box">
		
			<div id="content" class="posts" id="post-<?php the_ID(); ?>">
			
			<?php if (have_posts()) : ?>
			
			<?php while (have_posts()) : the_post(); ?>
			
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<p class="author"><em>by</em> <a href="<?php the_author() ?>" title="Posts by <?php the_author() ?>"><?php the_author() ?></a></p>
				<div class="entry">
				<p><?php the_content("<br /><br />Click to continue &rarr;"); ?></p>
				</div>
			<p class="to_comments"><span class="post_date"><?php the_time('F jS, Y') ?></span><span class="comments_num"><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></span></p>
			
			<?php endwhile; ?>
	
			<?php include (TEMPLATEPATH . '/navigation.php'); ?>
			
			<?php else : ?>
	
			<div class="entry">
				<?php include (TEMPLATEPATH . "/404.php"); ?>
			</div>
	
			<?php endif; ?>
		
			</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>