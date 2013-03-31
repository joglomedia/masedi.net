</div>
<!-- end content -->
	
	</div>
	<!-- end wrapper -->
	<!-- begin footer -->
	<div id="footer">
		<div id="footerInner" class="clearfix">

			<?php
				if (function_exists('wpp_get_mostpopular')) {
					echo '<!-- wp most Popular Post -->
						<div class="boxFooter">
							<h2>Popular Articles</h2>';
							
					echo wpp_get_mostpopular();
					
					echo '</div>';
					
				} else if (function_exists('dp_most_popular_posts')) {
					echo '<!-- Popular Post -->
						<div class="boxFooter">
							<h2>Popular Articles</h2>';
							
					echo dp_most_popular_posts(10);
					
					echo '</div>';
				}
			
				if (function_exists('stt_recent_terms')) {
					echo '<!-- STT -->
					<div class="boxFooter">
						<h2>Searched Articles</h2>';
						
					echo stt_recent_terms(30);
					
					echo '</div>';
				}

				/* Widgetized sidebar footer */
				if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer') ) :
				endif;
			?>
			
			<!-- Start GFC -->

			<!-- End GFC -->
			
		</div>
	</div>
	<div id="copyright">
		<div id="copyrightInner">
			<strong>Right&lt;-Copy-&gt;Left</strong> &copy; <?Php $recent_year = date('Y'); $hijri_diff = '578'; $hijri_year = $recent_year - $hijri_diff; echo $recent_year. ' (' .$hijri_year; ?> H) owned by <a href="http://www.masedi.net"><strong>MasEDI Networks</strong></a>. I Love <a rel="nofollow" href="http://wordpress.com" target="_blank">WordPress</a> so much.
<br>Some contents on this page licensed under <a rel="nofollow" href="http://www.gnu.org/copyleft/" target="_blank">CopyLeft</a> terms.<br>
Another some contents copyrighted to their respective owner.	
		<div id="site5bottom"><a href="<?Php echo get_option('designpile_site5_affiliate'); ?>">Site5 | Experts in Reseller Hosting.</a></div>
		</div>
	</div>
	<!-- end footer -->
</div>
<!-- end mainWrapper -->

<!-- Twitter follow -->
<script src="http://platform.twitter.com/anywhere.js?id=emSRaSzgMXr5oC0BQu6JMw&v=1" type="text/javascript"></script>
<script type="text/javascript">
twttr.anywhere(onAnywhereLoad);
function onAnywhereLoad(twitter) {
twitter('#follow-gombile').followButton("gombile");
};
</script>

<?php if (get_option('designpile_analytics') <> "") { 
		echo stripslashes(stripslashes(get_option('designpile_analytics'))); 
	}else{ ?>
	
	<!-- Start Google Analytic -->
	<script type="text/javascript">
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
	</script>
	<script type="text/javascript">
	try {
	var pageTracker = _gat._getTracker("UA-15806534-1");
	pageTracker._trackPageview();
	} catch(err) {}</script>
	<!-- End Google Analytic -->

<?php } 
//end of analytic ?>

</body>
</html>