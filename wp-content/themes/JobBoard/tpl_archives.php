<?php
/*
Template Name: Page - Archives
*/
?>
<?php get_header(); ?>
<div id="page">
<div id="content-wrap" class="clear <?php if(get_option("ptthemes_page_layout") == "Right Sidebar") { echo "right-side"; } else { echo "left-side"; } ?>" >
<div id="content">
<?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') { ?><div class="breadcums"><ul class="page-nav"><li><?php yoast_breadcrumb('',''); ?></li></ul></div><?php } ?>
<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>
<?php $post_images = bdw_get_images($post->ID,'large'); ?>

<div class="entry archive_list">
    <div class="title-container">
        <h1 class="title_green"><span><?php echo ARCHIVE ?></span></h1>
        <div class="clearfix"></div>
    </div>
  <div <?php post_class('single clear'); ?> id="post_<?php the_ID(); ?>"></div>
    <div class="post-content">
      <?php endwhile; ?>
      <?php endif; ?>
        <div class="post-content">
    	 <?php the_content(); ?>
    	</div>
     		
            
            <?php
         	$years = $wpdb->get_results("SELECT DISTINCT MONTH(post_date) AS month, YEAR(post_date) as year
		FROM $wpdb->posts WHERE post_status = 'publish' and post_date <= now( ) and post_type = 'post'   ORDER BY post_date DESC");
	if($years)
		{
			foreach($years as $years_obj)
			{
				$year = $years_obj->year;	
				$month = $years_obj->month;
				?>
                <?php query_posts("showposts=1000&year=$year&monthnum=$month"); ?>
         		<div class="arclist">  
               <div class="arclist_head">
                   <h3><?php echo $year; ?></h3>
                   <h4> <?php echo  date('F', mktime(0,0,0,$month,1)); ?>  </h4>
               </div>
    	       <ul>
	          <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                   <li>
                        <a href="<?php the_permalink() ?>">
                            <?php the_title(); ?>
                        </a><br />
                        <span class="arclist_date">  <?php _e('by','templatic');?>
                        <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" title="Posts by <?php the_author(); ?>"><?php the_author(); ?></a>
                        <?php _e('on','templatic');?>  <?php the_time(__('M j, Y'),'templatic') ?> // <?php comments_popup_link(__('No Comments','templatic'), __('1 Comment','templatic'), __('% Comments','templatic'), '', __('Comments Closed','templatic')); ?>
                        </span>
                    </li> 
          <?php endwhile; endif; ?>
	          </ul>
            </div>
                <?php
			}
		}
	 ?> 
      
     
    </div>
  </div>


</div>
<!--  CONTENT AREA END -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>