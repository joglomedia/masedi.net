
<?php get_header(); ?>

		<div class="span-15" id="main-content">
		  <!-- main loop start -->
		  
		
	
				  	<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>

		<div class="post" id="post-<?php the_ID(); ?>" style="border:0px;">

			<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>

			<div class="entry" style="padding-top:10px;">
<?php //the_excerpt(); ?>
				<?php the_content(); ?>
<div class="category"><?php the_tags(); ?>
      	  </div>  
				

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