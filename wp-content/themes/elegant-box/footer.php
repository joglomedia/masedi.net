			<div class="anchor">
				<span><a href="#" onclick="MGJS.goTop();return false;"><?php _e('TOP', 'elegantbox'); ?></a></span>
			</div>
			<div class="fixed"></div>
			</div>
		<div class="fixed"></div>
	</div>
</div>

<!-- footer START -->
<div id="footer">
	<div class="inner">
		<div class="content">
			<p id="about">
				<?php
					global $wpdb;
					$post_datetimes = $wpdb->get_row($wpdb->prepare("SELECT YEAR(min(post_date_gmt)) AS firstyear, YEAR(max(post_date_gmt)) AS lastyear FROM $wpdb->posts WHERE post_date_gmt > 1970"));
					if ($post_datetimes) {
						$firstpost_year = $post_datetimes->firstyear;
						$lastpost_year = $post_datetimes->lastyear;

						$copyright = __('Copyright &copy; ', 'elegantbox') . $firstpost_year;
						if($firstpost_year != $lastpost_year) {
							$copyright .= '-'. $lastpost_year;
						}
						$copyright .= ' ';

						echo $copyright;
						bloginfo('name');
					}
					printf(__(' | Powered by <a href="%1$s">WordPress</a>', 'elegantbox'), 'http://wordpress.org/');
					printf(__(' | Theme by <a href="%1$s">NeoEase</a>', 'elegantbox'), 'http://www.neoease.com/');
				?>
			</p>

			<ul id="admin">
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
			</ul>

			<div class="fixed"></div>
		</div>
	</div>
</div><!-- footer END --><?php	wp_footer();	$options = get_option('elegantbox_options');	if ($options['analytics']) {		echo($options['analytics_content']);	}?>
</body>
</html>
