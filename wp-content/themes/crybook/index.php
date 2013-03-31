<?php get_header(); ?>
<!--#content:start-->
    	<div id="content">
        <?php 
        $delicious = get_option('crybook_delicious_uri');
		if (have_posts()) : 
		while (have_posts()) : the_post();
		?>
        <div class="entry" id="post-<?php the_ID(); ?>">
        
		
            	<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                <p class="meta-header"><?php _e("Posted on the"); ?> <?php the_time('F jS, Y') ?> under <?php the_category(',') ?> by <?php the_author_posts_link(); ?> <?php edit_post_link(__('<span class="edit">Edit</a>')); ?></p>
                
                <?php the_content(__('')); ?>
                
                <div class="meta-footer">
                	<ul>
                        <li><a href="<?php the_permalink() ?>">Read More</a></li>
                        <li><a href="<?php the_permalink() ?>#comment"><?php comments_number(); ?></a></li>
                        <?php edit_post_link(__('Edit'), '<li>', '</li>'); ?>
                    </ul>
                 <div class="clear-left"></div>   
				</div>
        
        	</div>
        <?php endwhile; ?>
        <?php endif; ?>
			<div class="pagination">
                <div class="prev-page"><?php next_posts_link('Older Entries') ?></div>
                <div class="next-page"><?php previous_posts_link('Newer Entries') ?></div>
            </div>
        </div>
<!--#content:end-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>