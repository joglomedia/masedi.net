<?php get_header(); ?>
<!-- index.php start -->
        <div id="content">

	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
        	<div class="post" id="post-<?php the_ID(); ?>">
            	<h2 class="post_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
                <div class="post_body">

						<?php if (is_search()) { 
                            the_excerpt(); 
                        } else { 
                            the_content(__('Read the rest of') . "\"" . the_title('', '', false) . "\" &raquo;"); 
                        } ?>
				
				</div>

                <?php edit_post_link('Edit', '', ''); ?>

			</div>
			<!--post-->

	<?php endwhile; ?>
		
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