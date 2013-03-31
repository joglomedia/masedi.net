
<?php get_header(); ?>

		<div class="span-15" id="main-content">
		  <!-- main loop start -->
		  
		  <?php //include(TEMPLATEPATH . '/features.php'); ?>
		  <?php //include(TEMPLATEPATH . '/tabs-categories2.php'); ?>
	
				  	<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>

		<div class="post" id="post-<?php the_ID(); ?>">

			<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
<div class="post_by">By <?php the_author_posts_link() ?> on <?php the_time('F jS, Y') ?>. This post has <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?> <br />Filed Under:<?php the_category(', ') ?> <br />Subscribe via: <a href="<?php bloginfo('rss_url'); ?>">RSS</a> or <a href="http://www.feedburner.com/fb/a/emailverifySubmit?feedId=973631">Email</a> </div>
			<div class="entry">
<?php the_excerpt(); ?><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">Read full story &raquo;</a>
				<?php //the_content(); ?>
<div class="category"><?php the_tags(); ?>
      	  </div>  
				

			</div>

		</div>

	<?php endwhile; ?>

		<div class="navigation"><br />
			<?php posts_nav_link(); ?>
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