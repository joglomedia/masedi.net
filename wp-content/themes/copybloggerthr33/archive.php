<?php get_header(); ?>
		
	<div id="content_box">
	
		<div id="left_box">
			
			<div id="content" class="pages archives">
	
		<?php if (have_posts()) : ?>

			<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	
			<?php /* If this is a category archive */ if (is_category()) { ?>				
			<h1>Archive for the '<?php echo single_cat_title(); ?>' Category &darr;</h1>
			
			<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
			<h1>Entries Tagged '<?php single_tag_title(); ?>' &darr;</h1>
			
			<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
			<h1>Entries from <?php the_time('F jS, Y'); ?> &darr;</h1>
			
			<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
			<h1>Entries from <?php the_time('Y'); ?> &darr;</h1>
			
			<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
			<h1>Entries from <?php the_time('F Y'); ?> &darr;</h1>

			<?php } ?>

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
		
			<div class="entry">
				<?php include (TEMPLATEPATH . "/404.php"); ?>
			</div>
			
		<?php endif; ?>
			
		</div>
	
<?php get_sidebar(); ?>	
<?php get_footer(); ?>