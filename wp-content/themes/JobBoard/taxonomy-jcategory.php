<?php get_header(); ?>
<div class="category_list">
    <div class="category_list-in">
        <ul>
         <li class="bnone"><?php echo CATEGORY; ?> : </li>
         <?php 
         $blogcatids = get_category_by_cat_name(get_option('pt_blog_cat')); //remove blog category from listing page
         wp_list_categories_custom('exclude='. $blogcatids.'&title_li=&jtype='.$_REQUEST['jtype']);  
         ?>
         </ul>
         <div class="clear"></div>
    </div>
	<div class="clear"></div>
</div> <!-- category_list -->
<!-- category_list -->
<div id="page">
<div id="content-wrap" class="clear <?php if(get_option("ptthemes_page_layout") == "Right Sidebar") { echo "right-side"; } else { echo "left-side"; } ?>" >
<div id="content">
<?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') { ?><div class="breadcums"><ul class="page-nav"><li><?php yoast_breadcrumb('',''); ?></li></ul></div><?php } ?>
  <h2>
    <?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
    <?php /* If this is a category archive */ if (is_tax()) { ?>
    <?php global $wp_query, $post;
	$current_term = $wp_query->get_queried_object();	
	global $current_term;
	$category_link = get_term_link( $current_term->slug, CUSTOM_CATEGORY_TYPE1 );
	if( $current_term->name){
		echo $ptitle = $current_term->name;
	} ?>
    <?php /* If this is a daily archive */ } elseif (is_day()) { ?>
    <?php the_time('F jS, Y'); ?>
    <?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
    <?php _e('Archive for');?>
    <?php the_time('F, Y'); ?>
    <?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
   <?php _e('Archive for');?>
    <?php the_time('Y'); ?>
    <?php /* If this is a search */ } elseif (is_search()) { ?>
    <?php _e('Search Results');?>
    <?php /* If this is an author archive */ } elseif (is_author()) { ?>
    <?php _e('Author Archive');?>
    <?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
      <?php _e('Blog Archives');?>
      <!--do not delete-->
      <?php }
	  	elseif( is_tag() ) { ?>
		<?php _e('Tagged');?> &#8216;<?php single_tag_title(); ?>&#8217; 
        <?php }?>
  </h2>
  <p><a href="<?php  if(get_option('pt_feedburner_url')){ echo get_option('pt_feedburner_url');}else{ bloginfo('rss_url');} ?>" class="rss"><?php _e('RSS FEED');?></a></p>
  <?php if(is_home()){
	  $page =(get_query_var('paged')) ? get_query_var ('paged') :".$pt_index_posts";
  		query_posts("showposts= $pt_index_posts&paged=$page");
  } 
?>
  <?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>
<?php
  $query="select meta_value from ".$wpdb->prefix."postmeta where post_id='".get_the_ID()."' and meta_key='featured_type'";
  $m_value = $wpdb->get_var( $wpdb->prepare($query, $meta_key) );
  
	if ($m_value == 'c' || $m_value == 'both') {
		echo "<div class='featured'>";
	}
	else {
		echo "<div class='listings'>";
	}

?>
	<?php if(get_post_meta($post->ID,'company_logo', $single = true)): ?>
	    <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><img class="company_logo" src="<?php echo get_post_meta($post->ID,"company_logo",$single = true); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" height="60" width="60"  /></a>
    <?php else: ?>
	    <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><img class="company_logo" src="<?php echo get_bloginfo('template_directory'); ?>/images/no-image.png" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" height="60" width="60"  /></a>
    <?php endif; ?>    
    <div class="featured-data">
    <h3 id="post-<?php the_ID(); ?>"> 
      <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a>
       <span class="company_name "><?php echo stripslashes(get_post_meta($post->ID,'company_name', $single = true));?></span> </h3>
    <span class="place"><?php echo stripslashes(get_post_meta($post->ID,'job_location', $single = true));?> <br  />
    <small><?php echo stripslashes(get_post_meta($post->ID,'job_type', $single = true));?> </small> </span>
    <span class="date" >
    <?php  the_time('j M ') ?>
    <small>
    <?php  the_time('Y') ?>
    </small> </span>
    </div>
    <!--Post Meta-->
  </div>
  <!--post end -->
  <?php endwhile; ?>
  <!-- Prev/Next page navigation -->
   <?php pagenavi('<div class="pagenavi">',' </div>');  ?>
  <!--page navi end -->
  <?php else : ?>
  <h3><?php _e('Sorry, no posts matched your criteria.');?></h3>
  <p><?php _e('Please try searching again here...');?></p>
  <p class="clear"><strong><?php _e('Or, take a look at Archives and Categories');?></strong></p>
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
  <?php endif; ?>
</div>
<div id="sidebar">
	<?php dynamic_sidebar("job-listing-area"); ?>
</div>    
<?php get_footer(); ?>