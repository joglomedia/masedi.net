<?php get_header(); ?>
<?php if (have_posts()) : ?>

<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<?php /* If this is a category archive */ if (is_category()) { ?>
<h2 class="title">Archive for the &#8216;<strong><?php single_cat_title(); ?></strong>&#8217; Category</h2>
<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
<h2 class="title">Posts Tagged &#8216;<strong><?php single_tag_title(); ?></strong>&#8217;</h2>
<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
<h2 class="title">Archive for <strong><?php the_time('F jS, Y'); ?></strong></h2>
<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
<h2 class="title">Archive for <strong><?php the_time('F, Y'); ?></strong></h2>
<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
<h2 class="title">Archive for <strong><?php the_time('Y'); ?></strong></h2>
<?php /* If this is an author archive */ } elseif (is_author()) { ?>
<h2 class="title">Author Archive</h2>
<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
<h2 class="title">Blog Archives</h2>
<?php } ?>

<?php include("nav.php"); ?>

<?php while (have_posts()) : the_post(); ?>

<!--Start Post-->
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
<br />
<?php include("nav.php"); ?>
<?php else : ?>

<h2 class="center">Not Found</h2>
<?php include (TEMPLATEPATH . '/searchform.php'); ?>

<?php endif; ?>
<?php get_footer(); ?>
