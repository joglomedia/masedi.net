<?php
/**
 * Template Name: Companies Template
 *
 * Description: A page template that provides a key component of WPNuke as a Job board site.
 * The companies template in WPNuke Job site useful to display all companies taxonomy
 * This template must be assigned to a page in order for it to work correctly.
 *
 * @package WPNuke
 * @subpackage Vacancy
 * @since Vacancy 1.0
 */
?>
<?php get_header(); ?>
		<div id="container">
			<div id="content" role="main">
				<?php get_search_form(); ?>
				<?php if(function_exists('wpnuke_breadcrumbs')) wpnuke_breadcrumbs(); ?><!--breadcrumb-->
				<div class="post">
					<article class="post-content">
						<header>
							<h1 class="page-title"><?php _e('Browse by Company', 'wpnuke'); ?></h1>								
							<p class="page-desc">Browse job listing posted by company or job provider.</p>	
						</header><!--content-header-->
						<div class="entry clearfix">
						
						<?php echo wpnuke_get_company_list(); ?>
						
						</div><!--entry-->
					</article><!--article-->
				</div><!--post-->
			</div><!--content-->
			<?php get_sidebar(); ?>
			<div class="clearfix"></div>
		</div><!--container-->
<?php get_footer(); ?>