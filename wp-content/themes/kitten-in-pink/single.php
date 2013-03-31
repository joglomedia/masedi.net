
<?php get_header(); ?>

		<div class="span-15" id="main-content">
		  <!-- main loop start -->
		  
		 
	
				  	<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>

		<div class="post" id="post-<?php the_ID(); ?>">

			<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
<div class="post_by">By <?php the_author_posts_link() ?> on <?php the_time('F jS, Y') ?>.  <br />Filed Under:<?php the_category(', ') ?> <br />Subscribe via: <a href="<?php bloginfo('rss_url'); ?>">RSS</a> </div>
			<div class="entry">
<?php //the_excerpt(); ?>
				<?php the_content(); ?><div style="clear:both;"></div>
<div class="category"><?php the_tags(); ?>
      	  </div>  
				<div id="comments-template">
         <?php comments_template(); ?>
         </div>

			</div>

		</div>

	<?php endwhile; ?>

		<div class="navigation"><br />
			<?php previous_post_link('&laquo; %link') ?> <?php next_post_link(' %link &raquo;') ?>
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