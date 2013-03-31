
<!-- begin colRight -->
	<div id="colRight">
    <?php if(get_option('designpile_ads') == 'yes' && function_exists('wp125_write_ads')){?>
	<!-- begin ads -->
	<div id="ads" class="clearfix">
          <?php wp125_write_ads(); ?>
	</div>
	<!-- end ads -->
    <?php }?>
	<?php 
	/* Widgetized sidebar */
	if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar') ) : ?><?php endif; ?>
	
	</div>
<!-- end colRight -->
