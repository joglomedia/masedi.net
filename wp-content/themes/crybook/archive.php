<?php get_header(); ?>
<!--#content:start-->
    	<div id="content">
        

		<?php if (have_posts()) : ?>

 	  <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
 	  <?php /* If this is a category archive */ if (is_category()) { ?>
		<h2 class="pagetitle">Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h2>
 	  <?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		<h2 class="pagetitle">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
 	  <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		<h2 class="pagetitle">Archive for <?php the_time('F jS, Y'); ?></h2>
 	  <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		<h2 class="pagetitle">Archive for <?php the_time('F, Y'); ?></h2>
 	  <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		<h2 class="pagetitle">Archive for <?php the_time('Y'); ?></h2>
	  <?php /* If this is an author archive */ } elseif (is_author()) { ?>
		<h2 class="pagetitle">Author Archive</h2>
 	  <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		<h2 class="pagetitle">Blog Archives</h2>
 	  <?php } ?>

		<?php while (have_posts()) : the_post(); ?>
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
