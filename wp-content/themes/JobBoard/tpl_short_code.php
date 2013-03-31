<?php
/*
Template Name: Page - Short code
*/
?>
<?php get_header();?>
<div id="page">
<div id="content-wrap">
<?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') { ?><div class="breadcums"><ul class="page-nav"><li><?php yoast_breadcrumb('',''); ?></li></ul></div><?php } ?>
<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>
<!-- Content  2 column - Right Sidebar  -->
<div class="title-container">
    <h1 class="title_green"><span><?php the_title(); ?></span></h1>
    <div class="clearfix"></div>
</div>
<div class="content content_full">
  <?php if (function_exists('dynamic_sidebar')){ dynamic_sidebar('page_content_above'); }?>
  <div class="entry">
    <div id="post_<?php the_ID(); ?>">
      <div class="post-content">
        <?php the_content(); ?>
      </div>
    </div>
  </div>
</div>
<!-- /Content -->
<?php endwhile; ?>
<?php endif; ?>
</div>
<?php get_footer();?>
<!--Page full width #end  -->
