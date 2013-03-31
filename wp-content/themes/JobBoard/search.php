<?php get_header(); ?>

<div class="category_list">
  <div class="category_list-in">
    <ul>
      <li class="bnone"><?php _e('Category');?> : </li>
      <?php 
	  //wp_list_categories('orderby=name&title_li');
	  $blogcatids = get_category_by_cat_name(get_option('pt_blog_cat')); //remove blog category from listing page
	  wp_list_categories_custom('exclude='. $blogcatids.'&title_li=&jtype='.$_REQUEST['jtype']); 
	  ?>
    </ul>
    <div class="clear"></div>
  </div>
</div>
<!-- category_list -->
<div id="content-wrap" class="clear <?php if(get_option("ptthemes_page_layout") == "Right Sidebar") { echo "right-side"; } else { echo "left-side"; } ?>" >
<div id="content">
  <!--the loop-->
  <?php if(is_home()){
  $page =(get_query_var('paged')) ? get_query_var ('paged') :".$pt_index_posts";
  query_posts("cat=$pt_exclude_news&showposts= $pt_index_posts&paged=$page");
  } ?>
  <?php $mimg = get_post_meta($post->ID, 'mimg', $single = true);	?>
  <?php if (have_posts()) : ?>
  <h1><?php echo SEARCH_RESULTS_TEXT;?></h1>
  <!--loop article begin-->
  <?php while (have_posts()) : the_post(); ?>
  <div class="listings">
    <h3  id="post-<?php the_ID(); ?>"> <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>">
      <?php the_title(); ?>
      </a> <span class="company_name "><?php echo stripslashes(get_post_meta($post->ID,'company_name', $single = true));?></span> </h3>
    <span class="place"><?php echo stripslashes(get_post_meta($post->ID,'job_location', $single = true));?> <br  />
    <small><?php echo stripslashes(get_post_meta($post->ID,'job_type', $single = true));?> </small> </span> <span class="date" >
    <?php  the_time('j M ') ?>
    <small>
    <?php  the_time('Y') ?>
    </small> </span>
    <!--Post Meta-->
  </div>
  <?php endwhile; ?>
  <div class="googleads"> <?php echo "$pt_googleads"; ?> </div>
  <!--page nav end -->
  
  <?php pagenavi('<div class="pagenavi">',' </div>');  ?>

  <!-- do not delete-->
  <?php else : ?>
  <h3><?php _e('Sorry, no posts matched your criteria.');?></h3>
  <p><?php _e('Please try searching again here...');?></p>
  <p><strong><?php _e('Or, take a look at Archives and Categories');?></strong></p>
  <div class="category">
    <h2>
      <?php _e('Category'); ?>
    </h2>
    <ul>
      <?php wp_list_categories('orderby=name&title_li'); ?>
    </ul>
  </div>
  <div class="archives">
    <h2 class="sidebartitle">
      <?php _e('Archives'); ?>
    </h2>
    <ul>
      <?php wp_get_archives('type=monthly'); ?>
    </ul>
  </div>
  <!--do not delete-->
  <?php endif; ?>
  <!--search.php end-->
</div>
<!--include sidebar-->
<?php get_sidebar();?>
<!--include footer-->
<?php get_footer(); ?>
