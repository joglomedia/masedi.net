		<?php
			$feed_uri = get_option('crybook_feed_uri');
			
			if(!$feed_uri or $feed_uri == '') :
				$feed_uri = get_bloginfo('rss2_url');
			else :
				$feed_uri = 'http://feeds.feedburner.com/' . $feed_uri;
			endif;
			
			$feed_email = get_option('crybook_feed_id');
			if($feed_email or $feed_email != '') :
				$feed_email = " or <a href='http://www.feedburner.com/fb/a/emailverifySubmit?feedId=".$feed_email."&amp;loc=en_US'>e-mail</a>";
			endif;
		?>
		<div id="sidebar">
        	<p id="switcher">
            	<a href="/" onclick="setActiveStyleSheet('default'); return false;" id="blue" title="Blue">Blue</a>
				<a href="/" onclick="setActiveStyleSheet('pink'); return false;" id="pink" title="Pink">Pink</a>
				<a href="/" onclick="setActiveStyleSheet('green'); return false;" id="green" title="Green">Green</a>
                <a href="/" onclick="setActiveStyleSheet('purple'); return false;" id="purple" title="Purple">Purple</a>
                <a href="/" onclick="setActiveStyleSheet('red'); return false;" id="red" title="Red">Red</a>
            </p>
        	<div class="about box">
            <?php query_posts('pagename=about'); ?>
        	<?php while (have_posts()) : the_post(); ?>
            	<h3><?php _e('About'); ?></h3>
            	<p><?php echo get_avatar( get_the_author_id(), '80', ''); ?> <?php echo get_option('crybook_about_site'); ?></p>
                <div class="clear"></div>
            
            <?php endwhile; ?>
            </div>
            <div class="feeds"><?php echo get_option('crybook_feed_count'); ?><?php echo (get_option('crybook_feed_enable') === 'yes' ? '. ' : '');?>You can get update via <a href="<?php echo $feed_uri; ?>">feed</a><?php echo $feed_email; ?>.</div>
            
			<div class="col">
            <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-left')) : ?>

			<?php endif; ?>
            </div>
            <div class="col2">
            <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-right')) : ?>

			<?php endif; ?>
			</div>
        </div>