<?php get_header(); ?>
<!--#content:start-->
    	<div id="content">
        <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
        	<div class="entry" id="post-<?php the_ID(); ?>">
            	<h2><?php the_title(); ?></h2>
                
                <?php 
				the_content(__(''));
				wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); 
				edit_post_link('Edit this entry.', '<p>', '</p>'); 
				?>
            </div>
        <?php endwhile; ?>
        <?php endif; ?>

        </div>
<!--#content:end-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>