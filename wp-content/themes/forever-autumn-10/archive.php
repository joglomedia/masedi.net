<?php get_header(); ?>
<!-- index.php start -->
        <div id="content">

	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
        	<div class="post" id="post-<?php the_ID(); ?>">
            	<h2 class="post_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
                <div class="post_datetime"><?php the_time('F jS, Y') ?> at <?php the_time('g:ia'); ?> | <?php if(function_exists('the_views')) { the_views(); } ?></div>
                <div class="post_body">
						<?php the_excerpt(); ?> 
				 <p>Read the rest of <a href="<?php the_permalink() ?>"><?php the_title(); ?></a></p>

				</div>
			</div>
			<!--post-->

	<?php endwhile; ?>
	<div class="navigation">
		<div class="alignleft"><?php next_posts_link(__('&laquo; Previous Entries')) ?></div>
		<div class="alignright"><?php previous_posts_link(__('Next Entries &raquo;')) ?></div>
	</div>
		
<?php else : ?>

	<div class="post">
		<h2 class="post_title"><?php _e('Not Found'); ?></h2>
		<div class="post_body">
			<p><?php _e('Sorry, but no posts matched your criteria.'); ?></p>
			<?php include (TEMPLATEPATH . "/searchform.php"); ?>
		</div>
	</div>
		
<?php endif; ?>
        </div><!--content-->
        
        <!-- index.php end -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>