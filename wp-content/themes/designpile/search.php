<?php get_header(); ?>

<!-- begin colLeft -->
	<div id="colLeft">
    <!-- begin colLeftInner -->
        <div id="colLeftInner" class="clearfix">
			<div class="searchQuery">Search results for "<?php /* Search Count */ $allsearch = &new WP_Query("s=$s&showposts=-1"); $key = wp_specialchars($s, 1); $count = $allsearch->post_count; _e(''); _e('<strong>'); echo $key; _e('</strong>'); wp_reset_query(); ?>"</div>
			
			
	<?php if (have_posts()) : while (have_posts()) : the_post();
		  ?>
		<!-- begin post -->        
        <div class="blogPost">
        				<div class="date"><?php the_time('M') ?><br /><span><?php the_time('j') ?></span></div>
						<h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
						<div class="meta">
							By <span class="author"><?php the_author_link(); ?></span> &nbsp;//&nbsp;  <?php the_category(', ') ?>  &nbsp;//&nbsp;  <?php comments_popup_link('No Comments', '1 Comment ', '% Comments'); ?> 
						</div>
						<?php the_excerpt(); ?> 
						
		</div>
		<!-- end post -->
		<?php endwhile; ?>
	<?php else : ?>

		<p>Sorry, but you are looking for something that isn't here.</p>

	<?php endif; ?>
	</div>
    <!-- end colLeftInner -->
    <div class="navigation">
			<div class="alignleft"><?php next_posts_link('Older') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer') ?></div>
		</div>
</div>
<!-- end colLeft -->

<!-- begin colRight -->
		<div id="colRight" class="clearfix">	
			<?php get_sidebar(); ?>	
			</div>
<!-- end colRight -->


<?php get_footer(); ?>
