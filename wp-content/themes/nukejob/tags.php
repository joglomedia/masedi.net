<?php
/**
 * Blog Tags
 *
 * @package WPNuke
 * @subpackage Vacancy
 * @since Vacancy 1.0
 */
?>
<?php get_header(); ?>
		<div id="container">
			<div id="content" role="main">
				<?php if(function_exists('wpnuke_breadcrumbs')) wpnuke_breadcrumbs(); ?><!--breadcrumb-->
				<div class="content-header">
					<h1><?php printf(__('All Posts Tagged in "%s"', 'wpnuke'), single_cat_title('',false)); ?></h1>								
					<p class="desc"></p>	
				</div><!--content-header-->
				<div class="post">
				<?php
				global $more; $more = 0;
				if (have_posts()) :
					while (have_posts()) : the_post();
				?>
					<article class="post-content" id="post-<?php the_ID(); ?>">
						<header>
							<h1 class="post-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
							<div class="meta clearfix"><span class="meta-author"><?php the_author_posts_link('nickname'); ?></span><span class="meta-time"><?php the_time(get_option('date_format')); ?></span><span class="meta-category"><?php the_category(', '); ?></span><span class="meta-comment"><?php comments_popup_link(__('No comments', 'wpnuke'), __('1 Comment', 'wpnuke'), __('% Comments', 'wpnuke')); ?></span></div>
						</header>
						<div class="entry clearfix">
							<?php if (has_post_thumbnail()) : ?>
							<figure class="post-thumb"><?php the_post_thumbnail('archive-post'); ?></figure>
							<?php endif; ?>
							<?php the_excerpt(); // the_content('<p>Read More '. get_the_title() .'...</p>'); ?>
						</div><!--entry-->
					</article><!--post-content-->
					<?php endwhile; ?>
				<?php else : ?>
					<p class="error"><?php _e('Apologies, but no results were found. Perhaps searching will help find a related post.', 'wpnuke');?></p>
				<?php endif; ?>
				<?php if(function_exists('wpnuke_pagenavi')) : ?>
					<div class="pagination">
						<?php wpnuke_pagenavi(); ?>
					</div><!--pagination-->
				<?php endif; ?>
				</div><!--post-->
			</div><!--content-->
			<?php get_sidebar(); ?>
			<div class="clearfix"></div>
		</div><!--container-->
<?php get_footer(); ?>