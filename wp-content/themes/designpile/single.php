<?php
get_header();
?>

<!-- begin col left -->
	<div id="colLeft">	
    <!-- begin colLeftInner -->	
	<div id="colLeftInner" class="clearfix">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<!-- begin post -->        
	<div class="blogPost">
        	<div class="date"><?php the_time('M') ?><br /><span><?php the_time('j') ?></span></div>
<h1><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
<div class="meta">
By <span class="author"><?php the_author_link(); ?> (<?php edit_post_link('Edit Post', ''); ?>) </span> &nbsp;//&nbsp;  <?php the_category(', ') ?>  &nbsp;//&nbsp;  <?php comments_popup_link('No Comments', '1 Comment ', '% Comments'); ?>
<br /><br />
		<!-- FB like button -->
		<div style="margin-left:64px;"><iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;layout=standard&amp;show_faces=true&amp;width=468&amp;action=like&amp;colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden;  width:468px; height:60px;"></iframe></div>

</div>

		<?php the_content(); ?>

		<div class="postTags"><?php the_tags(); ?></div>
	</div>
	<!-- end post -->

	<!-- post author -->
	<div class="postauthor">
		<?php echo get_avatar( get_the_author_id() , 60 ); ?>

		<h4>Author: <a href="<?php the_author_url(); ?>">

		<?php the_author_firstname(); ?> <?php the_author_lastname(); ?></a></h4>

		<?php the_author_description(); ?>

		<br /><a href="<?php bloginfo('url'); ?>/?author=<?php the_author_ID(); ?>"><?php the_author_firstname(); ?> <?php the_author_lastname(); ?> has written <?php the_author_posts(); ?> articles for us.</a>
	</div>
	<!-- end post author -->

		<!-- Social Sharing Icons -->
		<div class="social">
			<strong>Share this article:</strong>
			<a rel="nofollow" href="http://buzz.yahoo.com/buzz?targetUrl=<?php the_permalink(); ?>&amp;headline=<?php the_title(); ?>&amp;src=<?php bloginfo('name'); ?>" target="_blank" title="Share on Yahoo! Buzz.">
			<img src="<?php bloginfo('template_directory'); ?>/images/ybuzz.png" alt="Share on Yahoo! Buzz" /></a>				
			<a rel="nofollow" href="http://del.icio.us/post?url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>" target="_blank" title="Bookmark on Delicious.">
			<img src="<?php bloginfo('template_directory'); ?>/images/delicious.png" alt="Bookmark on Delicious" /></a>
			<a rel="nofollow" href="http://digg.com/submit?phase=2&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>" target="_blank" title="Digg this!">
			<img src="<?php bloginfo('template_directory'); ?>/images/digg.png" alt="Digg This!" /></a>				
			<a rel="nofollow" href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&amp;t=<?php the_title(); ?>" target="_blank" title="Share on Facebook.">

			<img src="<?php bloginfo('template_directory'); ?>/images/facebook.png" alt="Share on Facebook" id="sharethis-last" /></a>
			<a rel="nofollow" href="http://www.mixx.com/submit?page_url=<?php the_permalink(); ?>" target="_blank" title="Mixx thiss!">
			<img src="<?php bloginfo('template_directory'); ?>/images/mixx.png" alt="Mixx thiss!" /></a>				
			<a rel="nofollow" href="http://www.stumbleupon.com/submit?url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>" target="_blank" title="StumbleUpon.">
			<img src="<?php bloginfo('template_directory'); ?>/images/stumbleupon.png" alt="StumbleUpon" /></a>
			<a rel="nofollow" href="http://twitter.com/home/?status=<?php the_title(); ?> : <?php if (function_exists('wpme_get_shortlink')) { echo wpme_get_shortlink($post->ID); }else{ the_permalink(); } ?>" target="_blank" title="Tweet this!">
			<img src="<?php bloginfo('template_directory'); ?>/images/twitter.png" alt="Tweet this!" /></a>				

		</div>
		<!-- end Social Sharing Icons -->	

		<?php comments_template(); ?>

		<?php endwhile; else: ?>

		<p>Sorry, but you are looking for something that isn't here.</p>

	<?php endif; ?>

		</div>
		<!-- end colLeftInner -->

	</div>
	<!-- end col left -->

<?php get_sidebar(); ?>	

<?php get_footer(); ?>
