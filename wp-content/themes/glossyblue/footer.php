	<div id="footer">
		<div class="left-col">
			<h4>Recent Posts </h4>

			<?php query_posts('showposts=5'); ?>
			<ul class="recent-posts">
			<?php while (have_posts()) : the_post(); ?>
				<li>
					<strong><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent link to'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></strong><br />
					<small><?php the_time('m-d-Y') ?></small>
				</li>
			<?php endwhile;?>
			</ul>

		</div>
		<div class="left-col">
			<?php include (TEMPLATEPATH . '/simple_recent_comments.php'); /* recent comments plugin by: www.g-loaded.eu */?>
			<?php if (function_exists('src_simple_recent_comments')) { src_simple_recent_comments(5, 60, '<h4>Recent Comments</h4>', ''); } ?>
		</div>
		<div class="right-col">
			<h4>About</h4>
			<p>Welcome to my design blog and portfolio showcase. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis.</p>
			<p>Feel free to <a href="#"> contact me.</a></p>
		</div>
		<hr class="clear" />
	</div>
	<!--/footer -->
</div>
<!--/page -->
<div id="credits"><span class="left">Powered by <a href="http://www.wordpress.org">WordPress</a> | Theme by <a href="http://www.ndesign-studio.com">N.Design Studio</a><br/>Free Blog at <strong><a href="http://masedi.net/">MasEDI Networked Blogs</a></strong> hosted by <strong><a href="http://www.joglohosting.com/">JOGLOHosting</a></strong></span> <span class="right"><a href="<?php bloginfo('rss2_url'); ?>" class="rss">Entries RSS</a> <a href="<?php bloginfo('comments_rss2_url'); ?>" class="rss">Comments RSS</a></span></div>
</body>
</html>