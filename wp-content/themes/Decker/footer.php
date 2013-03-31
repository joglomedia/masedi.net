<div id="footer">
  <div id="footer_content">
     <div id="recent">
        <h3>Recent posts</h3>
        
				<?php
        $latest = get_posts('numberposts=4');
        foreach( $latest as $post ):
        ?>
        <p>
          <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" ><?php the_title(); ?></a>
          <br /><span class="date"><?php the_time(get_option('date_format')); ?></span>
        </p>
        <?php endforeach ?>
		 </div>
		 
		 <div id="recent_comments">
		  <?php include (TEMPLATEPATH . '/simple_recent_comments.php'); /* recent comments plugin by: www.g-loaded.eu */?>
		  <?php if (function_exists('src_simple_recent_comments')) { src_simple_recent_comments(4, 60, '<h3>Recent Comments</h3>', ''); } ?>
		 </div>
		 
		 <div id="blogroll">
        <h3>Blogroll</h3> 
        <?php /* get_links(); */ ?>
     </div>
		 
		 <div style="clear: left"></div>
	</div>
	<div id="footer_down">
     <span class="copyright"><center>&nbsp; &nbsp;Copyright <?php $md=date('Y'); $mh=580; $hd=$md-$mh; echo $md." (".$hd." H)"; ?> 
<a href="<?Php bloginfo('url'); ?>" title="<?Php bloginfo('description'); ?>"><strong><?php bloginfo('name'); ?></strong></a> | <a href="http://www.proxynoxy.com/blog/nowgoogle/nowgoogle-com-adalah-multiple-search-engine-popular.html" title="nowGoogle.com adalah Multiple Search Engine Popular">nowGoogle.com adalah Multiple Search Engine Popular</a> | <a rel="nofollow" href="http://www.dailyblogtips.com/wordpress-themes/">WordPress Themes</a> by DBT
 &nbsp;</center></span>
	</div>
</div>
</div>

<script type='text/javascript' src='http://track4.mybloglog.com/js/jsserv.php?mblID=2010021607394335'></script>

</body>
</html>