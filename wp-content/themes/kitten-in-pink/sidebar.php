<div id="sidebar" class="span-8 last">
 
<?php include(TEMPLATEPATH . '/boxads.php'); ?>	


<div id="leftsidebar">

<ul>
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>


	

	<li id="calendar"><h2><?php _e('Calendar'); ?></h2>
		<?php get_calendar(); ?>
	</li>

	


<?php endif; ?>
</ul>














</div>




	
	
	
	</div>