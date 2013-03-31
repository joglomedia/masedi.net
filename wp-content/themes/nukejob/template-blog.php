<?php
/**
 * Template Name: Blog Template
 *
 * Description: A page template that provides a key component of WPNuke as a blog site.
 * The blog template in WPNuke Job site useful to display all blog post.
 * This template must be assigned to a page in order for it to work correctly.
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
				<div class="post">
				<?php
				global $more; $more = 0;
				$wpn_paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$wpn_args = array('post_type=' => 'post', 'paged' => $wpn_paged);
				
				$tmp_query = $wp_query;
				$wp_query = null;
				$wp_query = new WP_Query();
				$wp_query->query($wpn_args);
				
				if (have_posts()) :
					while (have_posts()) : the_post();
				?>
					<article class="post-content" id="post-<?php the_ID(); ?>">
						<header>
							<h2 class="post-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
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
					<p>It's probably some thing we've done wrong but now we know about it and we'll try to fix it. In the meantime, try returning to the <a href="<?php bloginfo('siteurl'); ?>">homepage</a> or search something <a href="<?php bloginfo('siteurl'); ?>/?s=job">here</a>.</p>
				<?php endif; ?>
				<?php if(function_exists('wpnuke_pagenavi')) : ?>
					<div class="pagination">
						<?php wpnuke_pagenavi(); ?>
					</div><!--pagination-->
				<?php endif; ?>
				<?php
				// Restore original WP Query Post Data
				$wp_query = null;
				$wp_query = $tmp_query;
				wp_reset_postdata(); // not sure needed because we're using temp query
				?>
				</div><!--post-->
			</div><!--content-->
			<?php get_sidebar(); ?>
			<div class="clearfix"></div>
		</div><!--container-->
<?php get_footer(); ?>