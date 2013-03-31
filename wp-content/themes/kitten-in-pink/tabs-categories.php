<?php // This file controls how category tabs are displayed on the front page

// Controls the categories displayed through the theme options page
global $options;


// If you don't want to or for some reason can't use the theme options page, you can edit this manually
// Just change each category variable to your category slug.
// Example: $c1 = "Entertainment";
// Tabs 1 - 8
	$c1 = "Free Themes";
	$c2 = "Habits";
	$c3 = $st_category_3;
	$c4 = $st_category_4;
	$c5 = $st_category_5;
	$c6 = $st_category_6;
	$c7 = $st_category_7;
	$c8 = $st_category_8;
?>
<div id="home-categories">
	<div class="menu tabbed">
	<ul class="tabs">
	<?php
	// Checks to see if each tab is set.  If it is, then a list item and link (tab) are displayed
	// Sets $loop to the number of tabs there are
		if($c1 !== '') { echo '<li class="c1"><a  class="c1 tabs" title="' . $c1 .'">' . $c1 . '</a></li>'; $loop = 1; }
		if($c2 !== '') { echo '<li class="c2"><a  class="c2 tabs" title="' . $c2 .'">' . $c2 . '</a></li>'; $loop = 2; }
		if($c3 !== '') { echo '<li class="c3"><a  class="c3 tabs" title="' . $c3 .'">' . $c3 . '</a></li>'; $loop = 3; }
		if($c4 !== '') { echo '<li class="c4"><a  class="c4 tabs" title="' . $c4 .'">' . $c4 . '</a></li>'; $loop = 4; }
		if($c5 !== '') { echo '<li class="c5"><a  class="c5 tabs" title="' . $c5 .'">' . $c5 . '</a></li>'; $loop = 5; }
		if($c6 !== '') { echo '<li class="c6"><a  class="c6 tabs" title="' . $c6 .'">' . $c6 . '</a></li>'; $loop = 6; }
		if($c7 !== '') { echo '<li class="c7"><a  class="c7 tabs" title="' . $c7 .'">' . $c7 . '</a></li>'; $loop = 7; }
		if($c8 !== '') { echo '<li class="c8"><a  class="c8 tabs" title="' . $c8 .'">' . $c8 . '</a></li>'; $loop = 8; }
	echo '</ul>';
// Loop through each category to display the latest two posts
// While $i is less than or equal to the number of tabs
	$i = 1;
	while($i <= $loop) {

// Set the category name to whatever category posts should be displayed (query for posts is below)
switch($i) { 
	case 1: $c_name = $c1; break;
	case 2: $c_name = $c2; break;
	case 3: $c_name = $c3; break;
	case 4: $c_name = $c4; break;
	case 5: $c_name = $c5; break;
	case 6: $c_name = $c6; break;
	case 7: $c_name = $c7; break;
	case 8: $c_name = $c8; break;
	default: break;
	} // endswitch

if($i >= 1) {
	echo '<div class="c c'. $i . '">';
	rewind_posts();
// Query last 2 posts for the specific category (determined by switch statement above)
	$c_query = new WP_Query('category_name='.$c_name.'&showposts=2');
// Loop through the posts
	while ($c_query->have_posts()) : $c_query->the_post();
		// Show the post and its contents
		?><div class="post">
		<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
		<div class="entry"><?php the_excerpt(); ?></div>
		</div><?php 
	endwhile;
	echo '</div>';
	} // endif
	$i++; // Iterate until $i reaches the number of tabs
} ?>
	</div><!-- tabbed -->
</div><!-- home-categories -->