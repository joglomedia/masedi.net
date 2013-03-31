<?php // This file shows the latest feature article on the home page

// Query one post tagged "features"
	$my_query = new WP_Query('tag=features&showposts=1');
	while ($my_query->have_posts()) : $my_query->the_post();
// Set a variable to the post ID, so that we won't duplicate the post later
	global $do_not_duplicate;
	$do_not_duplicate = $post->ID;
	$feature_id = $post->ID;
// Checks for a feature image
	$feature_image = get_post_meta($post->ID, 'Feature Image', $single = true);
// Checks for feature image alt text
	$feature_alt = get_post_meta($post->ID, 'Feature Image Alt', $single = true);
?>
	<div id="post-<?php the_ID(); ?>" class="post feature"><small class="feature-title">Featured Story </small>
	<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>

<?php  // If there's an image associated with the post, display it, link it to single.php, and set alt text
if($feature_image !== '') {
// display the image, its alt text, and wrap it with a link to "single.php" ?>
	<p>
	<a href="<?php the_permalink(); ?>" title="<?php if($feature_alt !== '') echo $feature_alt; else the_title(); ?>">
	<img src="<?php echo $feature_image; ?>" 
	alt="<?php if($feature_alt !== '') echo $feature_alt; else the_title(); ?>" 
	class="left" /></a>
	</p>
	<?php } // endif

// If there's not an image in the custom field Key of "Feature Image"
	else { 
	echo '<!-- User did not add an image URL to custom field "Key" of "Feature Image." Support question check. -->';
	} // endelse ?>

	<div class="entry">
	<p class="byline">By <?php the_author_posts_link() ?> on <?php the_time('F jS, Y') ?></p>

<?php // display the excerpt, post meta, comments, etc.
	the_excerpt();
	echo '<p class="post-meta-data">';
	edit_post_link('Edit', '', ' | ');
	comments_popup_link('No Comments', '1 Comment', '% Comments'); ?> | 
	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">Read full story &raquo;</a></p>

<?php // close off entry and feature divs and end while loop
	echo '</div></div>';
	endwhile; ?>