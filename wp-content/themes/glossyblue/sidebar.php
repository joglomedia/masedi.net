	<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	
	<div id="sidebar">
		<h3>Category</h3>
		<ul class="ul-cat">
			<?php wp_list_categories('show_count=1&title_li='); ?>
		</ul>
		<h3>Archives</h3>
		<ul class="ul-archives">
			<?php wp_get_archives('type=monthly'); ?>
		</ul>
	</div>
	<!--/sidebar -->
