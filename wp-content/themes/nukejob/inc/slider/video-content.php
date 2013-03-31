<div id="video-content-wrapper">
	<div class="video-box">
		<?php if (get_post_meta( get_the_ID( ), '_wpnuke_slide_video_embed_code', true )) { echo do_shortcode(get_post_meta( get_the_ID( ), '_wpnuke_slide_video_embed_code', true )); } ?>
	</div>
	<div class="video-content-box">
		<h2><?php if (get_post_meta( get_the_ID( ), '_wpnuke_slide_video_title', true )) { echo do_shortcode(get_post_meta( get_the_ID( ), '_wpnuke_slide_video_title', true )); } ?></h2>
		<?php if (get_post_meta( get_the_ID( ), '_wpnuke_slide_video_content', true )) { echo apply_filters('the_content', get_post_meta( get_the_ID( ), '_wpnuke_slide_video_content', true )); } ?>
	</div>
	<div class="clear"></div>
</div>
<div class="clear"></div>