<?php get_header(); ?>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

<div class="post" id="post-<?php the_ID(); ?>">

<div class="p-head">
 <h2><?php the_title(); ?></h2>
</div>
<div class="p-con">
<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
</div> 

<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>

</div>
<br />

<?php //comments_template(); ?>
				
<?php endwhile; ?>
<?php include("nav.php"); ?>
<?php else : ?>

<?php include("404.php"); ?>
<?php endif; ?>

<?php get_footer(); ?>
