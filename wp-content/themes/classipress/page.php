<?php
require_once dirname( __FILE__ ) . '/form_process.php';
get_header( ); 
include_classified_form();
?>

	
	<div class="content">
		<div class="main ins">
		
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>	
	
			<div class="left">
			
				<div class="title">
					<h2><?php the_title(); ?></h2>
					<div class="clear"></div>
				</div>
				
				<div class="product">
					<?php the_content(__('Read more &raquo;','cp')); ?>
					<?php edit_post_link(__('Edit Page','cp'), '<p>', '</p>'); ?>
				</div>
				
			</div>
			
		<?php endwhile; endif; ?>		
			
		<?php get_sidebar(); ?>	
			
			<div class="clear"></div>
			
		</div>
	</div>

<?php get_footer(); ?>
