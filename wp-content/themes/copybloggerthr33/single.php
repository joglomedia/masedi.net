<?php get_header(); ?>
<?php
/* custom for displaying all content for logged in user only */
global $more;    // Declare global $more (before the loop).
?>

	<div id="content_box">
		<div id="left_box">
			<div id="content" class="posts" id="post-<?php the_ID(); ?>">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="posts" id="post-<?php the_ID(); ?>">

			<h1><?php the_title(); ?></h1>
			<p class="author"><em>by</em> <a href="<?php the_author() ?>" title="Posts by <?php the_author() ?>"><?php the_author() ?></a></p>
				<div class="entry">
				<?php
if ( is_user_logged_in() ) {
the_content("<br /><br />Click to continue &rarr;");
} else {
$more = 0; // Set (inside the loop) to display content above the more tag.
the_content("");
echo "<blockquote>Please <a href=\"http://software.masedi.net/wp-login.php\" title=\"Member Login\">login</a> or <a href=\"http://software.masedi.net/wp-login.php?action=register\" title=\"Member Registration\">register</a> to download <strong>" .get_the_title(). "</strong> for free.</blockquote>";
}
?>
				<?php include (TEMPLATEPATH . '/afterpost.php'); ?>
				</div><?php comments_template(); ?>
			</div>
			
			<?php endwhile; ?>
	
			<?php include (TEMPLATEPATH . '/navigation.php'); ?>
			
			<?php else : ?>
	
			<div class="entry">
				<?php include (TEMPLATEPATH . "/404.php"); ?>
			</div>
	
			<?php endif; ?>
		
			</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>