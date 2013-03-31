<div id="sidebar">
	<ul>
		
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
		
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
		
		<li>
			<h2>Subscribe</h2>
				<span class="feed"><a href="<?php bloginfo('rss2_url'); ?>" title="Subscribe <?php bloginfo('name'); ?>">Subscribe <?php bloginfo('name'); ?></a></span>
    </li>
    
		<li>
			<h2>Recent Entries</h2>
			<ul class="latest_post">
				<?php wp_get_archives('type=postbypost&limit=8'); ?>
			</ul>
		</li>
		
    <li>
			<h2>Categories</h2>
			<ul class="categories">
				<?php wp_list_categories('title_li=&show_count=1'); ?>
			</ul>
		</li>
    
    <!-- need popularity contest plugin -->
    <?php if ((function_exists('akpc_most_popular_in_month')) and is_home()) { ?>
		<li>
			<h2>Popular This Month</h2>
			<ul class="popular">
				<?php akpc_most_popular_in_month(); ?>
			</ul>
		</li>
    <?php } ?>
    
    <?php if ((function_exists('akpc_most_popular_in_month')) and is_single()) { ?>
		<li>
			<h2>Most Popular</h2>
			<ul class="popular">
				<?php akpc_most_popular(); ?>
			</ul>
		</li>
    <?php } ?>
    
    <?php if ((function_exists('akpc_most_popular_in_month')) and is_category()) { ?>
		<li>
			<h2>Popular in Category</h2>
			<ul class="popular">
				<?php akpc_most_popular_in_cat(); ?>
			</ul>
		</li>
    <?php } ?>
    
    <!-- need simple tags plugin -->
    <?php if ((function_exists('st_tag_cloud'))) { ?>
    <li>
			<h2>Random Tags</h2>
      <div class="tagcloud"><?php st_tag_cloud('cloud_selection=random&smallest=12&largest=20&unit=px&number=20&cloud_sort=random&maxcolor=#777777&mincolor=#999999&title='); ?>
			</div>
		</li>
    <?php } ?>
		
		<?php endif; ?>
		
	</ul><!-- end ul -->
</div><!-- end sidebar -->