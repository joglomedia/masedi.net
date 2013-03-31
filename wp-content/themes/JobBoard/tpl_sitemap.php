<?php
/*
Template Name: Page - Sitemap
*/
?>
<?php get_header(); ?>
<div id="page">
<div id="content-wrap" class="clear <?php if(get_option("ptthemes_page_layout") == "Right Sidebar") { echo "right-side"; } else { echo "left-side"; } ?>" >
<div id="content" class="content">
<?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') { ?><div class="breadcums"><ul class="page-nav"><li><?php yoast_breadcrumb('',''); ?></li></ul></div><?php } ?>
<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>
<div class="content-title"></div>

<div>
<!--  CONTENT AREA START -->


<div class="entry sitemap">
  <div id="post_<?php the_ID(); ?>">
    
    
    <div class="title-container">
        <h1 class="title_green"><span><?php echo SITE_MAP;?></span></h1>
        <div class="clearfix"></div>
    </div>
    <div class="post-content">
    
    <?php the_content(); ?>
    
      <div class="arclist">
        <div class="title-container">
        	<h1 class="title_green"><span><?php echo PAGE_TEXT;?></span></h1>
			<div class="clearfix"></div>
        </div>

        <ul>
          <?php wp_list_pages('title_li='); ?>
        </ul>
      </div>
      <!--/arclist -->
      <div class="arclist">
        <div class="title-container">
        	<h1 class="title_green"><span><?php echo JOB_TEXT;?></span></h1>
			<div class="clearfix"></div>
        </div>
        
        <ul>
          <?php $archive_query = new WP_Query('showposts=60&post_type='.CUSTOM_POST_TYPE1);
            while ($archive_query->have_posts()) : $archive_query->the_post(); ?>
          <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
            <?php the_title(); ?>
            </a> <span class="arclist_comment">
            <?php comments_number(__('0 comment','templatic'), __('1 comment','templatic'),__('% comments','templatic')); ?>
            </span></li>
          <?php endwhile; ?>
        </ul>
      </div>
      <!--/arclist -->
      <div class="arclist">
        <div class="title-container">
        	<h1 class="title_green"><span><?php echo RESUME_TEXT;?></span></h1>
			<div class="clearfix"></div>
        </div>
        
        <ul>
          <?php $archive_query = new WP_Query('showposts=60&post_type='.CUSTOM_POST_TYPE2);
            while ($archive_query->have_posts()) : $archive_query->the_post(); ?>
          <li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>">
            <?php the_title(); ?>
            </a> <span class="arclist_comment">
            <?php comments_number(__('0 comment','templatic'), __('1 comment','templatic'),__('% comments','templatic')); ?>
            </span></li>
          <?php endwhile; ?>
        </ul>
      </div>
      <div class="arclist">
        <div class="title-container">
        	<h1 class="title_green"><span><?php echo ARCHIVE_TEXT;?></span></h1>
			<div class="clearfix"></div>
        </div>
        <ul>
          <?php wp_get_archives('type=monthly'); ?>
        </ul>
      </div>
      <!--/arclist -->
      <div class="arclist">
        <div class="title-container">
        	<h1 class="title_green"><span><?php echo JOB_CATGORIES_TEXT;?></span></h1>
        	<div class="clearfix"></div>
        </div>
        <ul>
          <?php wp_list_categories('title_li=&hierarchical=0&show_count=1&taxonomy='.CUSTOM_CATEGORY_TYPE1)  ?>
        </ul>
      </div>
      <div class="arclist">
        <div class="title-container">
        	<h1 class="title_green"><span><?php echo RESUME_CATGORIES_TEXT;?></span></h1>
        	<div class="clearfix"></div>
        </div>
        <ul>
          <?php wp_list_categories('title_li=&hierarchical=0&show_count=1&taxonomy='.CUSTOM_CATEGORY_TYPE2)  ?>
        </ul>
      </div>
      <!--/arclist -->
      <div class="arclist">
      	<div class="title-container">
        	<h1 class="title_green"><span><?php echo META_TEXT;?></span></h1>
			<div class="clearfix"></div>
        </div>
        <ul>
          <li><a href="<?php bloginfo('rdf_url'); ?>" title="<?php echo RDF_RSS.' '.ONE_FEED;?>"><?php echo RDF_RSS.' '.ONE_FEED;?></a></li>
          <li><a href="<?php bloginfo('rss_url'); ?>" title="<?php echo RSS_TEXT.' '.POINT_FEED;?>"><?php echo RSS_TEXT.' '.POINT_FEED;?></a></li>
          <li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php echo RSS_TEXT.' '.TWO_FEED;?>"><?php echo RSS_TEXT.' '.TWO_FEED;?></a></li>
          <li><a href="<?php bloginfo('atom_url'); ?>" title="<?php echo ATOM_FEED;?>"><?php echo ATOM_FEED;?></a></li>
        </ul>
      </div>
      <!--/arclist -->
    </div>
  </div>
</div>
<?php endwhile; ?>
<?php endif; ?>
<!--  CONTENT AREA END -->
</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>