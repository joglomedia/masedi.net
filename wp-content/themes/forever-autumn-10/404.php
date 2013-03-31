<?php
/*
Template Name: Archives Page
*/
?>
<?php get_header(); ?>
<!-- index.php start -->
        <div id="content">
		
		<div class="post_body">
		  <h2>Not Found.</h2>
			<p><?php _e('Sorry, the page you are looking for does not exist. Please use the search box below or check out my archives.'); ?></p>
			<?php include (TEMPLATEPATH . "/searchform.php"); ?>
  
    <h2>By Month:</h2>
  <ul>
    <?php wp_get_archives('type=monthly'); ?>
  </ul>
  <h2>By Year:</h2>
  <ul>
    <?php wp_get_archives('type=yearly'); ?>
  </ul>
  <h2>By Subject:</h2>
  <ul>
     <?php wp_list_cats(); ?>
  </ul>
			</div>
			<!--post-->

        </div><!--content-->
        
        <!-- index.php end -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>