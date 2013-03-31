<?php get_header(); ?>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
		
<!--Start Post-->
<div <?php post_class(); ?> style="margin-bottom: 40px;">
<div class="p-head">
 <h2><?php the_title(); ?></h2>
<a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?></a>
</div>

<div class="p-con">
<p><a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'fullsize' ); ?></a>
<?php if ( !empty($post->post_excerpt) ) the_excerpt(); // this is the "caption" ?></p>
<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>

<div class="nav">
 <div class="left"><?php previous_image_link() ?></div>
 <div class="right"><?php next_image_link() ?></div>
</div>

<?php edit_post_link('Edit this entry.','',''); ?>

</div>
</div>

<?php comments_template(); ?>

<?php endwhile; ?>
<?php include("nav.php"); ?>
<?php else : ?>

<?php include("404.php"); ?>
<?php endif; ?>

<?php get_footer(); ?>
