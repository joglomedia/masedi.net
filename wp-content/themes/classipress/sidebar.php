<div class="right">
			
	<?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Page Sidebar')) : else : ?>
		
		<li><h2><?php _e('Archives','cp'); ?></h2>
			<ul>
			<?php wp_get_archives('type=monthly'); ?>
			</ul>
		</li>

	<?php wp_list_categories('show_count=1&title_li=<h2>Categories</h2>'); ?>
		
		<?php endif; ?>
</div>
<!--/rightcol -->
