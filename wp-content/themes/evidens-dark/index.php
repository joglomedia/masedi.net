<?php get_header(); ?>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
		
<!--Start Post-->
<div <?php post_class(); ?> style="margin-bottom: 40px;">
      			
<div class="p-head">
<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
<small class="p-time">
<strong class="day"><?php the_time('j') ?></strong>
<strong class="month-year"><?php the_time('M') ?> <br /><?php the_time('Y') ?></strong>
</small></div>


<div class="p-con">
<?php the_content('Read the rest of this entry &raquo;'); ?>
<div class="clear"></div>
<?php wp_link_pages(); ?>
<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
</div>


<div class="p-det">
 <ul>
  <li class="p-det-cat">In: <?php the_category('|') ?></li>
  <?php if (function_exists('the_tags')) { ?> <?php the_tags('<li class="p-det-tag">Tags: ', ', ', '</li>'); ?> <?php } ?>
 </ul>
</div>

<div class="p-more">
 <ul>
  <li class="p-more-read"><a href="<?php the_permalink() ?>" title="Read More <?php the_title(); ?>">Read More </a></li>
  <li class="p-more-com"><?php comments_popup_link('No Comments', '(1) Comment', '(%) Comments'); ?></li>
</ul>
</div>

</div>
<!--End Post-->

				
<?php endwhile; ?>
<?php include("nav.php"); ?>
<?php else : ?>

<?php include("404.php"); ?>
<?php endif; ?>

<?php if (function_exists('trackTheme')) { ?>
 <?php trackTheme("evidens-dark");  ?>
<?php } ?>

<?php get_footer(); ?>
