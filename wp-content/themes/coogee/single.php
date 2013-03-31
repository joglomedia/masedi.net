<?php get_header(); ?>
<div id="container">
	<div id="main">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<div class="postdate">
				<div class="month"><?php the_time('M') ?></div>
        <div class="date"><?php the_time('d') ?></div>
      </div><!-- end postdate -->
      <div class="title">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
				<div class="postmeta">
					<span class="postmeta_author"><?php the_author() ?></span>
					<span class="postmeta_category"><?php the_category(', ') ?></span>					
					<span class="postmeta_time"><?php the_time('Y-m-d') ?></span>
				</div><!-- end postmeta -->
		  </div><!-- end title -->
        
      <div class="entry">
				<?php the_content('<p>Read the rest of this entry</p>'); ?>
			  <div style="clear:both;"></div>
			</div><!-- end entry -->
			
			<?php the_tags('<span class="tags">',', ','</span>'); ?>
      <div class="info">
				Address:  <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_permalink() ?></a>
      </div><!-- end info -->
      
      <?php if (function_exists('st_related_posts')) { ?>
      <div class="relate">
				<?php st_related_posts('number=8&title=<h3>Related Post</h3>&include_page=false&order=date-desc&nopoststext=no related post&xformat=<a href="%permalink%" title="%title% ( %date% )">%title%</a>'); ?>
      </div><!-- end relate -->
      <?php } ?>
    </div><!-- end post --> 
    
		<div class="navi">
			<div class="left"><?php previous_post_link('&laquo; %link') ?></div>
			<div class="right"><?php next_post_link('%link  &raquo;') ?></div>
			<div style="clear:both;"></div>
		</div><!-- end navi -->
    
		<?php comments_template(); ?>
		<?php endwhile; ?>
		<?php else : ?>
		
		<div class="post">
			<div class="title">
				<h2>Sorry, nothing found!</h2>
			</div><!-- end title -->
      <p>Sorry, nothing found! Please use the SEARCH on the sidebar, or visit our ARCHIVES page.</p>
		</div><!-- end post -->
		
		<?php endif; ?> 
	</div><!-- end main --> 
<?php get_sidebar(); ?>
</div><!-- end container -->
<?php get_footer(); ?>