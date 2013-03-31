<?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') { ?><div class="breadcums"><ul class="page-nav"><li><?php yoast_breadcrumb('',' &raquo; '.__('All Jobs')); ?></li></ul></div><?php } ?>
<h2>
<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
<?php /* If this is a category archive */ if (is_category()) { ?>
<?php echo single_cat_title(); ?>
<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
<?php _e('Archive for');?>
<?php the_time('F jS, Y'); ?>
<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
<?php _e('Archive for');?>
<?php the_time('F, Y'); ?>
<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
<?php _e('Archive for');?>
<?php the_time('Y'); ?>
<?php /* If this is a search */ } elseif (is_search()) { ?>
<?php _e('Search Results');?>
<?php /* If this is an author archive */ }?>
<?php		
if($_REQUEST['jtype'] == ''){$_REQUEST['jtype']='all';}
if($_REQUEST['jtype']=='all')
{
	echo ALL_JOB.' <span class="lblue"></span>';
}
$query = "select option_values from $custom_post_meta_db_table_name where htmlvar_name = 'job_type'";
$jobs_type_predefined_values = explode(",",$wpdb->get_var($query));
foreach($jobs_type_predefined_values as $_jobs_type_predefined_values)
 {
 	$job_type[$_jobs_type_predefined_values] = $_jobs_type_predefined_values;
 }
$jobs_type_predefined_values = $job_type;
if(array_key_exists($_REQUEST['jtype'],$jobs_type_predefined_values))
{
 echo $jobs_type_predefined_values[$_REQUEST['jtype']].' <span class="lblue"></span>'; 
}
if($_REQUEST['catid'])
{
 echo ' in <a href="'.get_category_link($_REQUEST['catid']).'">'.get_the_category_by_ID( $_REQUEST['catid'] ) .'</a>';
}
?>
</h2>
<p> <a href="<?php  if(get_option('ptthemes_feedburner_url')){ echo get_option('ptthemes_feedburner_url');}else{ bloginfo('rss_url');} ?>" class="rss"><?php echo RSS_TEXT;?></a>
</p>
<?php if(is_home()){
  $page =(get_query_var('page')) ? get_query_var ('page') :".$pt_index_posts";
  } ?>
<?php 
global $wpdb;
?> 
<?php  /* query_posts( array('post_type' => 'job',
			'post_status' => 'publish',
			'paged' => get_query_var( 'paged' ),
			'meta_key'=>'featured_type',
			'orderby'=>array('h','both'),
			'order'=>'ASC')  ); */?>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<?php
  $query="select meta_value from ".$wpdb->prefix."postmeta where post_id='".get_the_ID()."' and meta_key='featured_type'";
  $m_value = $wpdb->get_var( $wpdb->prepare($query, $meta_key) );
  
	if ($m_value == 'h' || $m_value == 'both'): ?>
		<div class="featured">
    <?php else: ?>
		<div class="listings">
	<?php endif; ?>
	<?php if(get_post_meta($post->ID,'company_logo', $single = true)): ?>
	    <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><img class="company_logo" src="<?php echo get_post_meta($post->ID,"company_logo",$single = true); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" height="60" width="60"  /></a>
    <?php else: ?>
	    <a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><img class="company_logo" src="<?php echo get_bloginfo('template_directory'); ?>/images/no-image.png" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" height="60" width="60"  /></a>
    <?php endif; ?>    
    <div class="featured-data">
    <h3 id="post-<?php the_ID(); ?>">  
	<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a>
      <span class="company_name "><?php echo stripslashes(get_post_meta($post->ID,'company_name', $single = true));?></span>
      <?php if(get_post_meta($post->ID,'position_filled',true)=='Yes'){?><span><?php if(get_option('pt_position_filled')){echo get_option('pt_position_filled'); }else{ _e('Position:filled');}?></span><?php }?>
    </h3>
    <span class="place"><?php echo stripslashes(get_post_meta($post->ID,'job_location', $single = true));?> <br  /> 
	<small><?php echo stripslashes(get_post_meta($post->ID,'job_type', $single = true));?> </small> </span>
    <span class="date" ><?php the_time(templ_get_date_format()); ?></small> </span>   
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
    <h2><?php echo CAT_TEXT; ?></h2>
    <ul>
    <?php wp_list_categories('orderby=name&title_li'); ?>
    </ul>
  </div>
  <div class="archives"> 
     <h2 class="sidebartitle"><?php echo ARC_TEXT; ?></h2>
     <ul>
       <?php wp_get_archives('type=monthly'); ?>
     </ul>
  </div> 
<?php endif; ?>