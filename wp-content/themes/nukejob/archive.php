<?php
/**
 * Blog Archive
 *
 * @package WPNuke
 * @subpackage Nuke_Job
 * @since Nuke Job 1.0
 */
?>
<?php get_header(); ?>
		<div id="container">
			<div id="content" role="main">
			
				<?php if(function_exists('wpnuke_breadcrumbs')) wpnuke_breadcrumbs(); ?><!--breadcrumb-->

				<div class="content-header">
					<?php /* If this is a category archive */ if (is_category()) { ?>
						<h1><?php printf(__('All Posts in the %s Category', 'wpnuke'), single_cat_title('',false)); ?></h1>
						<p class="desc"><?php echo term_description(); ?></p>
					<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
						<h1><?php printf(__('All Posts Tagged in %s', 'wpnuke'), single_tag_title('',false)); ?></h1>
						<p class="desc"><?php echo term_description(); ?></p>
					<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
						<h1><?php _e('Archive for', 'wpnuke') ?> <?php the_time('F jS, Y'); ?></h1>
					<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
						<h1><?php _e('Archive for', 'wpnuke') ?> <?php the_time('F, Y'); ?></h1>
					<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
						<h1><?php _e('Archive for', 'wpnuke') ?> <?php the_time('Y'); ?></h1>
					<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
						<h1><?php _e('Blog Archives', 'wpnuke') ?></h1>
					<?php } ?>
				</div><!--content-header-->
			
				<?php get_template_part('loop'); ?>

			</div><!--content-->
			<?php get_sidebar(); ?>
			<div class="clearfix"></div>
		</div><!--container-->
<?php get_footer(); ?>