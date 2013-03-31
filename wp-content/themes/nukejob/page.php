<?php get_header(); ?>
		<div id="container">
			<div id="content" role="main">
				<?php if(function_exists('wpnuke_breadcrumbs')) wpnuke_breadcrumbs(); ?><!--breadcrumb-->
				<div class="post">
					<?php 
					// <!--do not delete-->
					if (have_posts()) :
						while (have_posts()) : the_post();
					?>
					<article class="post-content">
						<header>
							<h1 class="post-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
							<div class="meta clearfix"><span class="meta-author"><?php _e('by ', 'wpnuke'); the_author_posts_link('nickname'); ?></span><span class="meta-time"><?php the_time( get_option('date_format') ) ?></span><span class="meta-comment"><?php comments_popup_link(__('No comments', 'wpnuke'), __('1 Comment', 'wpnuke'), __('% Comments', 'wpnuke')); ?></span></div>
						</header>
						<div class="entry clearfix">
							<?php the_content(''); ?>
						</div><!--entry-->
					</article><!--post-content-->
					<div class="author-box">
						<h4><?php _e('About the Author', 'wpnuke'); ?></h4>
						<div class="author-info">
							<div class="image"><?php echo get_avatar(get_the_author_id(), 80); ?></div>
							<div class="author-bio">
								<h3><a href="<?php the_author_url(); ?>"><?php the_author_firstname() . '&nbsp;' . the_author_lastname(); ?></a></h3>
								<p><?php the_author_description(); ?></p>
								<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php printf( __( 'View all posts by %s &raquo;', 'wpnuke' ), get_the_author() ); ?></a>
							</div><!--author-bio-->
							<div class="clear"></div>
						</div><!--author-info-->
					</div><!--author-box-->
					<?php
						// show comments
						comments_template();
						
						// <!--do not delete-->
						endwhile; 
					else:
					?>
					<article class="post-content">
						<header>
							<h1 class="post-title"><?php _e('Page Not Found', 'wpnuke'); ?></h1>
						</header>
						<div class="entry clearfix">
							<p class="error clearfix"><?php _e('Apologies, but no results were found. Perhaps searching will help find a related post.', 'wpnuke'); ?></p>
						</div><!--entry-->
					</article><!--post-content-->
					<?php endif; ?>
				</div><!--post-->
			</div><!--content-->
			<?php get_sidebar(); ?>
			<div class="clearfix"></div>
		</div><!--container-->
<?php get_footer(); ?>