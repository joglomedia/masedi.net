<?php
/*
Template Name: Links
*/
?>
<?php get_header(); ?>

<div id="container">
	<div id="main">
    <div class="title_page">
			<h2>Links Page</h2>
    </div> <!-- end title -->
		
		<div class="linkpage">
			<ul>
			<?php wp_list_bookmarks('categorize=1&orderby=rand&before=<li>&after=</li>&show_images=0&show_discription=0&title_before=<h3>&title_after=</h3>'); ?>
			</ul>
		</div>
  </div><!-- edn main -->
<?php get_sidebar(); ?>
</div><!-- end container -->
<?php get_footer(); ?>