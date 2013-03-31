<?php get_header(); ?>

<!-- Side Central START -->
<div class="SC">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="Post">

<div class="PostHead">
 <h1 class="title"><a href="#"></a><a title="Permanent Link to <?php the_title(); ?>" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
 <p class="PostDate">
   <strong class="day"><?php the_time('d'); ?></strong>
   <strong class="month"><?php the_time('M'); ?></strong>
 </p>
  <p class="PostInfo">Posted by <?php the_author() ?> as <em><?php the_category(', ') ?></em></p>
</div>
  
<div class="PostContent">
  <?php the_content('Read the rest of this entry &raquo;'); ?>

<!--<div class="RelatedPosts">
<h3>Related Posts</h3>
 <ul><? //php related_posts(5, 10, '<li>', '</li>', '', '', false, false); ?>
</ul>
</div>-->
  
</div>
</div> 
<?php comments_template(); ?>
<?php endwhile; ?>
		
<?php else : ?>
<h2 class="center">Not Found</h2>
<p class="center"><?php _e("Sorry, but you are looking for something that isn't here."); ?></p>

<?php endif; ?> 

<!--  Side Central END -->
</div> 
<?php get_sidebar(); ?>
<?php get_footer(); ?>