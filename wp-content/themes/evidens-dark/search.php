<?php get_header(); ?>
<?php if (have_posts()) : ?>


<h2 class="title">Search Results</h2>

<?php include("nav.php"); ?>
<?php while (have_posts()) : the_post(); ?>

<div <?php post_class(); ?> style="margin-bottom: 40px;">

<div class="p-head">
<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
<small class="p-time">
<strong class="month-year" style="color:#596166;"><?php the_time('j, M Y') ?></strong>
</small>
</div>

<div class="p-con">
 <?php the_excerpt(); ?>
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

<?php endwhile; ?>
<br clear="all" />	
<?php include("nav.php"); ?>
<?php else : ?>

<h2 class="title">No posts found.</h2>
<p>Try a different search!</p>
<?php endif; ?>


<?php get_footer(); ?>
