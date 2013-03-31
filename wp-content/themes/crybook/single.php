<?php get_header(); ?>
<!--#content:start-->
    	<div id="content">
        <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
        	<div class="entry" id="post-<?php the_ID(); ?>">
            <?php
            
			if(!!get_option('crybook_aside_cat') and in_category(get_option('crybook_aside_cat'))) : ?>
            	<p><strong><a href="<?php the_permalink() ?>"><?php echo $post->post_title; ?></a></strong> &mdash; <?php echo $post->post_content; ?> <span class="aside-date"><?php the_date(); ?></span></p>
                <div class="meta-footer">
                	<ul>
                    	<?php edit_post_link(__('Edit'), '<li>', '</li>'); ?>
                    </ul>
                    <div class="clear-left"></div>
				</div>
                
        	<?php else : ?>
            	<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                <p class="meta-header"><?php _e("Posted on the"); ?> <?php the_time('F jS, Y') ?> under <?php the_category(',') ?> by <?php the_author() ?> <?php edit_post_link(__('<span class="edit">Edit</a>')); ?></p>
                <?php
                
				the_content(__('')); 
				
				?>
                
                <div class="meta-footer">
                	<ul>
                        <?php edit_post_link(__('Edit'), '<li>', '</li>'); ?>
                    </ul>
                    <div class="clear-left"></div>
				</div>
			<?php endif; ?>
                
            </div>
            
            <?php comments_template(); ?>
            
        <?php endwhile; ?>
        <?php else: ?>
		<p>Sorry, no posts matched your criteria.</p>
        <?php endif; ?>
        	
        </div>
<!--#content:end-->
<?php get_sidebar(); ?>
<?php get_footer(); ?>