<div id="piecemaker-wrapper">
	<?php
		$piecemaker_id = get_post_meta($post->ID, '_wpnuke_piecemaker_id', true);
		$piecemaker_shortcode = "[piecemaker id=" . $piecemaker_id . "/]";
		echo do_shortcode($piecemaker_shortcode);
	?>
</div><!--piecemaker-wrapper-->
<div class="clear"></div>