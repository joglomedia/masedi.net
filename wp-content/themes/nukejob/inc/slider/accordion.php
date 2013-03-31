<div id="accordion-wrapper">
	<ul class="accordion" id="accordion">
		<?php
		$accordion_slide_number = nuke_get_option('accordion_slide_number');
		$slide_query = new WP_Query('post_type=wpnuke_slide&orderby=date&order=ASC&posts_per_page=' . $accordion_slide_number);
		while ( $slide_query->have_posts() ) : $slide_query->the_post();
		if (has_post_thumbnail()) :
			$image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'slide' );
		?>
		<li style="background-image:url(<?php echo $image_attributes[0] ?>)">
		<?php endif; ?>
			<h2><?php the_title(); ?></h2>
			<div>
				<h2><?php the_title(); ?></h2>
				<?php  if((get_post_meta($post->ID, "_wpnuke_slide_desc", true))) { ?>
				<p><?php echo get_post_meta($post->ID, '_wpnuke_slide_desc', true); ?></p>
				<?php } ?>
				<?php  if((get_post_meta($post->ID, "_wpnuke_slide_link", true))) { ?>
				<a href="<?php echo get_post_meta($post->ID, '_wpnuke_slide_link', true); ?>">more &rarr;</a>
				<?php } ?>
			</div>
		</li>
		<?php endwhile; ?>
		<?php wp_reset_query(); ?>
	</ul>
</div><!--accordion-wrapper-->
<div class="clear"></div>