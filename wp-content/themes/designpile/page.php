<?php get_header(); ?>

<!-- begin colLeft -->
	<div id="colLeft">
    <!-- begin colLeftInner -->
    <div id="colLeftInner" class="clearfix">
    		<div class="page">
            <h1><?php the_title(); ?></h1>	
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            
            <?php the_content(__('(more...)')); ?>
            
            
            <?php endwhile; else: ?>
            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
            <?php endif; ?>
        	</div>
        </div>
        <!-- end colLeftInner -->
	</div>
	<!-- end colleft -->
	
	<?php get_sidebar(); ?>	

<?php get_footer(); ?>