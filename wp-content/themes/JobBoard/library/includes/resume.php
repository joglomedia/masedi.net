<?php get_header(); ?>
<div class="category_list">
    <div class="category_list-in">
        <ul>
         <li class="bnone"><?php echo CATEGORY; ?> : </li>
         <?php 
         wp_list_categories_resume('&title_li=&jtype='.$_REQUEST['jtype']);
         ?>
         </ul>
         <div class="clear"></div>
    </div>
	<div class="clear"></div>
</div> <!-- category_list -->
<?php
    global $current_user,$post;
	$role =  $current_user->roles[0];
	$login = $current_user->user_login;
?>
<div id="page">
<div id="content-wrap" class="clear <?php if(get_option("ptthemes_page_layout") == "Right Sidebar") { echo "right-side"; } else { echo "left-side"; } ?>" >
<div id="content">
<div class="breadcums"><ul class="page-nav"><li><?php if ( get_option( 'ptthemes_breadcrumbs' )) { yoast_breadcrumb('',' &raquo; '.__('All Resume')); } ?></li></ul></div>
<?php if($role == "Job Seeker" || !$login): ?>
	<p class="specialnote"><?php _e('Please <a href="'.get_option('siteurl').'/?page=register">register</a> as a job provider to view resume detail page.'); ?></p>
<?php endif; ?>
  <div class="newlisting">
  <h1><?php echo ALL_RESUME; ?></h1>
  <p><a href="<?php  if(get_option('pt_feedburner_url')){ echo get_option('pt_feedburner_url');}else{ bloginfo('rss_url');} ?>" class="rss"><?php _e('RSS FEED');?></a></p>
  <?php 
  query_posts( array('post_type' => 'resume',
			'post_status' => 'publish',
			'paged' => get_query_var( 'paged' )));
  if (have_posts()) :
	while (have_posts()) : the_post(); // begin the Loop
	$pcount++;
	$author = $post->post_author;
	$email = get_user_meta( $author, 'user_email', true );
	
	 ?>
      <ul class="rs_list">
      	<li>
            <?php if($role == "Job Provider" || current_user_can( 'administrator' )): ?>
	            <a href="<?php the_permalink(); ?>" class="img"><?php echo get_avatar( $email,40); ?></a>
            <?php else: ?>
	            <a class="img"><?php echo get_avatar( $email,40); ?></a>
            <?php endif; ?>    
            <div class="col1">
                <?php if($role == "Job Provider" || current_user_can( 'administrator' )): ?>
	                <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                <?php else: ?>
	                <h1><?php the_title(); ?></h1>
                <?php endif; ?>
                <p><?php echo get_post_meta($post->ID,'fname',true); ?> <?php echo get_post_meta($post->ID,'lname',true); ?></p>
                <p><span><?php echo TOTAL_EXP; ?> : <?php echo get_post_meta($post->ID,'experience',true); ?> <?php echo YEAR; ?></span></p>
            </div>
            <div class="col2">
            	<p><span><?php echo EXP_LOCATION; ?> :</span> <?php echo get_post_meta($post->ID,'resume_location',true); ?></p>
                <p><span><?php echo EXP_JOB_TYPE; ?> :</span> <?php echo get_post_meta($post->ID,'availability',true); ?></p>
                <p><span><?php echo EXP_SALARY; ?> :</span> <?php echo get_post_meta($post->ID,'salary',true); ?></p>
            </div>
            <div class="clear"></div>
        </li>
      </ul>
   <?php endwhile; ?>
  <?php else: ?>
	  <h3><?php _e(NO_RESUME_DASHBOARD_MSG);?></h3>
  <?php endif; ?>
 </div>  
  <?php pagenavi('<div class="pagenavi">',' </div>');  ?>
</div>

<div id="sidebar">
	<?php dynamic_sidebar("resume-listing-area"); ?>
</div>    
<?php get_footer(); ?>