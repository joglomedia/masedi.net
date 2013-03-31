<?php
/**
 * 404 Page
 *
 * @package WPNuke
 * @subpackage Vacancy
 * @since Vacancy 1.0
 */
?>
<?php get_header(); ?>
		<div id="container">
			<div id="content" role="main">
				<div class="post">
					<article class="post-content">
						<header>
							<h1 class="post-title"><a href="submit-resume.html">Page Not Found</a></h1>
						</header>
						<div class="entry clearfix">
							<p class="error clearfix"><?php _e('Apologies, but no results were found. Perhaps searching will help find a related post.', 'wpnuke');?></p>
							<p>It's probably some thing we've done wrong but now we know about it and we'll try to fix it. In the meantime, try returning to the <a href="<?php bloginfo('siteurl'); ?>">homepage</a> or search something <a href="<?php bloginfo('siteurl'); ?>/?s=job">here</a>.</p>
						</div><!--entry-->
					</article><!--post-content-->
				</div><!--post-->			</div><!--content-->
			<?php get_sidebar(); ?>
			<div class="clearfix"></div>
		</div><!--container-->
<?php get_footer(); ?>