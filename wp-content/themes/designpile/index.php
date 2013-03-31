<?php get_header(); ?>
	
<!-- begin colLeft -->
	<div id="colLeft">
        <!-- begin colLeftInner -->
        <div id="colLeftInner" class="clearfix">
		<!-- archive-title -->				
			<?php if(is_month()) { ?>
			<div id="archive-title">
				Browsing articles from "<strong><?php the_time('F, Y') ?></strong>"
			</div>
			<?php } ?>
			<?php if(is_category()) { ?>
			<div id="archive-title">
				Browsing articles in "<strong><?php $current_category = single_cat_title("", true); ?></strong>"
			</div>
			<?php } ?>
			<?php if(is_tag()) { ?>
			<div id="archive-title">
				Browsing articles tagged with "<strong><?php wp_title('',true,''); ?></strong>"
			</div>
			<?php } ?>
			<?php if(is_author()) { ?>
			<div id="archive-title">
				Browsing articles by "<strong><?php wp_title('',true,''); ?></strong>"
			</div>
			<?php } ?>
		<!-- /archive-title -->
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		
        <!-- begin post -->        
        <div class="blogPost">
        	<div class="date"><?php the_time('M') ?><br /><span><?php the_time('j') ?></span></div>
			<h2 class="title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
			<div class="meta">
				By <span class="author"><?php the_author_link(); ?></span> &nbsp;//&nbsp;  <?php the_category(', ') ?>  &nbsp;//&nbsp;  <?php comments_popup_link('No Comments', '1 Comment ', '% Comments'); ?> 
			</div>
			<?php the_content(__('read more')); ?> 				
		</div>
		<!-- end post -->
		<?php endwhile; ?>
		
		<!-- pagging -->
		<div class="pagination navigation">
		<?php if(function_exists('wp_pagenavi')) {
				wp_pagenavi();
			}elseif(function_exists('wp_page_numbers')) {
				wp_page_numbers(); 
			}else{
		?>
			<div class="alignleft" style="margin-right:15px;"><?php next_posts_link(); ?></div>
			<div class="alignright" style="margin-left:15px;"><?php previous_posts_link(); ?></div>
		<?php } ?>
		</div>

		<?php else : ?>

			<p>Sorry, but you are looking for something that isn't here.</p>

		<?php endif; ?>
		</div>
		<!-- end colLeftInner -->

	</div>
<!-- end colLeft -->

<?php get_sidebar(); ?>	

<?php get_footer(); ?>