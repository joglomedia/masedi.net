<?php get_header(); ?>
<!-- index.php start -->
        <div id="content">
<div class="navigation">
			<div class="alignleft"><?php previous_post_link('&laquo; %link') ?></div>
			<div class="alignright"><?php next_post_link('%link &raquo;') ?></div>
<br />
</div>
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
        	<div class="post" id="post-<?php the_ID(); ?>">
            	<h2 class="post_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
                <div class="post_datetime"><?php the_time('F jS, Y') ?> at <?php the_time('g:ia'); ?> | <?php if(function_exists('the_views')) { the_views(); } ?></div>
                <div class="post_body">
						<?php if (is_search()) { 
                            the_excerpt(); 
                        } else { 
                            the_content(__('Read the rest of') . "\"" . the_title('', '', false) . "\" &raquo;"); 
                        } ?>
				
				
				</div>
                <div class="post_category">Posted in <?php the_category(', ') ?></div>
                <div class="post_data"><?php comments_rss_link('RSS 2.0'); ?> | <a href="<?php trackback_url(true); ?>" rel="trackback">Trackback</a> | 	<a href="#respond">Comment</a> 
                <?php edit_post_link('Edit', '', ''); ?></div>

			</div>
			<!--post-->

	<?php endwhile; ?>
	<?php comments_template(); ?>
		
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