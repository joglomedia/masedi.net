<?php
require_once dirname( __FILE__ ) . '/form_process.php';
get_header( ); 
include_classified_form();
?>

	<div class="content">
		<div class="main ins">
			<div class="left" style="float: none; margin: 0 auto;">
				<div class="title">
					<h2><?php _e('Page Not Found','cp')?></h2>
					<div class="clear"></div>
				</div>
				<div class="product">

			<p><?php _e('The page you are looking for has been moved or does not exist. Please try another url or use our search to find what you are looking for.','cp')?></p>
			<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
				
				</div>
			</div>
			<div class="clear"></div>
		</div>
	</div>


<?php get_footer(); ?>
