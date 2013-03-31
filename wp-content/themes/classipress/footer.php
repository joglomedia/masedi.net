
<div class="footer">
		<div class="left">
			<ul>
				<li><a href="<?php echo get_option('home'); ?>/"><?php _e('Home','cp'); ?></a></li>
				<?php wp_list_pages('title_li=&depth=6&exclude=' . get_option('excluded_pages') .'' ); ?>
			</ul>
			<div style="clear: both;"></div>
			<a href="<?Php get_option('home'); ?>" title="<?Php bloginfo('description'); ?>"><strong><?php bloginfo('name'); ?></strong></a>
		</div>
		<div class="right">


		</div>
  <div class="clear"></div>
	</div>

<?php wp_footer(); ?>



</body>
</html>