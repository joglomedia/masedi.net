	</div><!--main-wrapper-->
	<footer id="footer">
		<div class="inner clearfix">
			<nav class="footer-nav">
				<?php wp_nav_menu(array('theme_location' => 'footer_navigation', 'menu_id' => 'footernav', 'fallback_cb' => '', 'container' => false)); ?>
			</nav>
			<div class="clearfix"></div>
			<p class="copyright"><?php $footer_text = wpnuke_get_option(WPNUKE_PREFIX . 'footer_text'); if ($footer_text) { echo $footer_text; } else { ?>&copy; <?php echo date("Y");?> <a href="<?php bloginfo('url') ?>"><?php bloginfo('name'); ?></a>. All Rights Reserved. <?php } ?></p>
			<p class="credits">
				<a href="http://hibiniu.com/"><img alt="Hibiniu Labs" src="<?php bloginfo('template_directory'); ?>/images/hibiniu.png">Designed &amp; Developed by <strong>Hibiniu</strong></a>
			</p>
		</div><!--inner-->
	</footer><!--footer-->
<?php if (is_single()) : ?>
	<!--Facebook-->
	<div id="fb-root"></div>
	<script type="text/javascript">
		(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
		fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
	<!--Google plus-->
	<script type="text/javascript">
		window.___gcfg = {lang: 'id'};
		(function() {
			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			po.src = 'https://apis.google.com/js/plusone.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		})();
	</script>
	<!--Twitter-->
	<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
	<?php
	// Include map js script for add/remove job application
	if('job' == get_post_type()) {
		echo '<script src="http://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>';
		wpnuke_require(WPNUKE_INCLUDES_DIR . '/lib/job/apply-for-job.js.php');
	}
	?>
<?php endif; ?>
<?php echo wpnuke_get_option('track_code'); ?>
<?php wp_footer(); ?>
</body>
</html>