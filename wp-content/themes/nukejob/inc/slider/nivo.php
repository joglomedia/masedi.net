<div id="slider-wrapper">
	<div class="nivo-container">
		<div id="slider" class="nivoSlider">
			<?php
			$i = 1;
			$nivo_slide_number = nuke_get_option('nivo_slide_number');
			$slide_query = new WP_Query('post_type=wpnuke_slide&orderby=date&order=ASC&posts_per_page=' . $nivo_slide_number);
			while ( $slide_query->have_posts() ) : $slide_query->the_post();
			?>
			<a href="<?php echo get_post_meta($post->ID, '_wpnuke_slide_link', true); ?>">
				<?php
				if (has_post_thumbnail()) :
				$image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'slide' );
				?>
				<img src="<?php echo $image_attributes[0] ?>" title="#htmlcaption<?php echo $i; ?>" alt="<?php the_title(); ?>" />
				<?php endif; ?>
			</a>
			<?php $i++; ?>
			<?php endwhile; ?>
			<?php wp_reset_query(); ?>
		</div><!--nivoSlider-->
		<?php
		$i = 1;
		$slide_query = new WP_Query('post_type=wpnuke_slide&orderby=date&order=ASC&posts_per_page=' . $nivo_slide_number);
		while ( $slide_query->have_posts() ) : $slide_query->the_post();
		?>
		<div id="htmlcaption<?php echo $i; ?>" class="nivo-html-caption">
			<h2><?php the_title(); ?></h2>
			<?php echo get_post_meta($post->ID, '_wpnuke_slide_desc', true); ?>
		</div>
		<?php $i++; ?>
		<?php endwhile; ?>
		<?php wp_reset_query(); ?>
	</div><!--nivo-container-->
</div><!--slider-wrapper-->
<div class="clear"></div>