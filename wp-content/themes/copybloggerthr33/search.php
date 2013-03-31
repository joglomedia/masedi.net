<?php get_header(); ?>

	<div id="content_box">
	
		<div id="left_box">
	
			<div id="content" class="pages archives">

		<?php if (have_posts()) : ?>
	
			<h1>Search Results for '<?php echo $s; ?>' &darr;</h1>
	
			<?php while (have_posts()) : the_post(); ?>		
			
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2><br />
			<div class="entry">
				<ul>
					<li><?php the_time('F jS, Y') ?></li>
					<li>Filed under: <?php the_category(', ') ?></li>
					<li><?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?></li>
				</ul>
			</div>
				
			<?php endwhile; ?>
			
			<?php include (TEMPLATEPATH . '/navigation.php'); ?>
		
		<?php else : ?>
	
			<h1>Hmm, no results... try again?</h1>
	
			<div class="entry">
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			</div>
		
		<?php endif; ?>
			
		</div>

		<?php get_sidebar(); ?>

	

<?php get_footer(); ?>