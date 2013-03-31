
<?php get_header(); ?>

		<div class="span-15" id="main-content">
		  <!-- main loop start -->
		  
		  <?php //include(TEMPLATEPATH . '/features.php'); ?>
		  <?php //include(TEMPLATEPATH . '/tabs-categories2.php'); ?>
	
				  	<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>

		<div class="post" id="post-<?php the_ID(); ?>">

			<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>

			<div class="entry">
<?php the_excerpt(); ?>
				<?php //the_content(); ?>

				

			</div>

		</div>

	<?php endwhile; ?>

		<div class="navigation"><br />
			<?php posts_nav_link(); ?>
		</div>

	<?php else : ?>

		<div class="post">
			<h2><?php _e('Not Found'); ?></h2>
		</div>

	<?php endif; ?>
		</div>  
		  
		  <!-- main loop end -->
		<?php get_sidebar(); ?>
		

<?php get_footer(); ?>