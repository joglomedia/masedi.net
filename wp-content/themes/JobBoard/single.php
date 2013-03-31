<?php get_header(); 
global $options;
foreach ($options as $value) {
		global $$value['id'];
        if (get_settings( $value['id'] ) === FALSE) { $value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
?>
<div id="page">
<div id="content-wrap" class="clear <?php if(get_option("ptthemes_page_layout") == "Right Sidebar") { echo "right-side"; } else { echo "left-side"; } ?>" >
<div id="content" class="content"  >
<?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') { ?><div class="breadcums"><ul class="page-nav"><li><?php  yoast_breadcrumb('',''); ?></li></ul></div><?php } ?>
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <div class="posts posts_spacer">
    <h1  class="title" id="post-<?php the_ID(); ?>"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>">
      <?php the_title(); ?>
      </a></h1>
    <div class="post_top"> 
		<?php echo POSTED_IN; ?>
        <?php the_category(", "); ?>
        <?php echo AT; ?>
        <?php the_time(templ_get_date_format()); ?>
    </div>
    <?php the_content('continue'); ?>
    <?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
     </div>
     <div class="post_bottom"> 
	 <p><?php the_tags(' <span class="i_tags">'.__('Tags : ').'', ', ', '</span>'); ?> </p>
     <p><span class="i_print"><a href="#" onclick="window.print();return false;" ><?php _e('Print This Post');?></a></span></p>
     </div>
   <?php
	   if(get_option('pt_show_postacomment') == 'Yes')  //Please comment to display comment on blog page as default settins
	  {
	 	comments_template(); 
      }
	  ?> 
    <!--do not delete-->
    <?php endwhile;  else: ?>
    <?php _e('Sorry, no posts matched your criteria.');?>
    <!--do not delete-->
    <?php endif; ?>
    <!--single.php end-->
  <!--single.php end-->
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
