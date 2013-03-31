<!--Start Right -->
<div id="right">

<div class="r1">

  <div class="widget"> 
	<h3>Categories</h3> 
	<ul> 
		<?php wp_list_categories('show_count=1&title_li='); ?> 
	</ul> 
	</div>

	<div class="widget">
	 <h3>Archives</h3>
	  <ul>
	   <?php wp_get_archives('type=monthly'); ?>
	  </ul>
	</div>
    
<!--Start Dynamic Sidebar -->
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>
<?php endif; ?>
<!--End Dynamic Sidebar -->

</div>




<div class="r2">

<?php if (function_exists('get_flickrrss')) { ?>
<div class="widget widget_flickrRSS" style="border-bottom: none;">
  <h3>Flickr PhotoStream</h3>
  <ul>
   <?php get_flickrrss(); ?> 
  </ul>
</div>
<?php } ?>

<?php if (function_exists('aktt_latest_tweet')) { ?>
<div class="widget">
 <h3>Latest tweets</h3>
  <?php aktt_latest_tweet(); ?>
 </div>
<?php } ?>

<!--Start Dynamic Sidebar -->
 <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(2) ) : else : ?>
 <?php endif; ?>
<!--End Dynamic Sidebar -->

</div>

</div>
<!--End Right -->