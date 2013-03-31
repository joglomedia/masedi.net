<?php get_header(); ?>

<!-- Side Central START -->
<div class="SC">

<?php $countervariable=1; if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>


<div class="Post" style="padding-bottom: 50px;">

<div class="PostHead">
 <h1 class="title"><a href="#"></a><a title="Permanent Link to <?php the_title(); ?>" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
 <p class="PostDate">
   <strong class="day"><?php the_time('d'); ?></strong>
   <strong class="month"><?php the_time('M'); ?></strong>
 </p>
  <p class="PostInfo">Posted by <?php the_author() ?> as <em><?php the_category(', ') ?></em></p>
</div>
  
<div class="PostContent">

<? if (is_home() && (!$paged || $paged == 1) || is_search() || is_single() || is_page()): ?> 
<?php the_content('Read the rest of this entry &raquo;'); ?>
<? else: ?><?php the_excerpt() ?><? endif; ?>
 

  <ul class="PostDetails">
   <li class="PostCom"><?php comments_popup_link('<span><strong>0</strong> Comments</span>', '<span><strong>1</strong> Comment</span>', '<span><strong>%</strong> Comments</span>'); ?></li>
   <?php // the_bunny_tags('<li class="Tags"></li>'); ?>
  </ul>
  
 </div>
 
</div>


<!-- <?php trackback_rdf(); ?> -->  
<?php endwhile; ?>

<?php posts_nav_link('','','&laquo; Previous Entries') ?>&nbsp;&nbsp;<?php posts_nav_link('','Next Entries &raquo;','') ?>
		
<?php else : ?>

<h2 class="center">Not Found</h2>
<p class="center"><?php _e("Sorry, but you are looking for something that isn't here."); ?></p>

<?php endif; ?> 
<!--  Side Central END -->
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>