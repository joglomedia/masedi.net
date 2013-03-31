<?php get_header(); ?>
<div id="page">
 <div id="content-wrap" class="clear <?php if(get_option("ptthemes_page_layout") == "Right Sidebar") { echo "right-side"; } else { echo "left-side"; } ?>" >
 
<div id="content">
<?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') { ?><div class="breadcums"><ul class="page-nav"><li><?php  yoast_breadcrumb('',''); ?></li></ul></div><?php } ?>
    <?php if (is_category()) { ?>
        <h1  class="head" ><?php echo get_option('ptthemes_browsing_category'); ?> <?php echo single_cat_title(); ?> </h1>  

        <?php } elseif (is_day()) { ?>
        <h1  class="head"><?php echo get_option('ptthemes_browsing_day'); ?> <?php the_time('F jS, Y'); ?> </h1>

        <?php } elseif (is_month()) { ?>
        <h1  class="head"><?php echo get_option('ptthemes_browsing_month'); ?> <?php the_time('F, Y'); ?> </h1>

        <?php } elseif (is_year()) { ?>
        <h1  class="head"><?php echo get_option('ptthemes_browsing_year'); ?> <?php the_time('Y'); ?> </h1>
        
        <?php } elseif (is_author()) { ?>
        <h1  class="head"><?php echo get_option('ptthemes_browsing_author'); ?> <?php echo $curauth->nickname; ?> </h1>
                        
        <?php } elseif (is_tag()) { ?>
        <h1  class="head"><?php echo get_option('ptthemes_browsing_tag'); ?> <?php echo single_tag_title('', true); ?> </h1>
        <?php }  elseif ($_GET['page']=='blog') { ?>
        <h1  class="head"><?php _e('Blog');?></h1>
        <?php } ?>
        
          <?php
        if(isset($_GET['author_name'])) :
        $curauth = get_userdatabylogin($author_name);
        else :
        $curauth = get_userdata(intval($author));
        endif;
    ?>
    <?php
	$blogCategoryIdStr = get_category_by_cat_name(get_option('pt_blog_cat'));
	if($blogCategoryIdStr=='')
	{
		?>
        <h3><?php _e('Sorry! Blog Category is not selected.');?></h3>
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
        <?php
	}else
	{
	
	?>
    <?php
    if(!is_category())
	{
		$totalpost_count = 0;
		$limit = 1000;
		$blogCategoryIdStr = $blogCategoryIdStr;
		query_posts('showposts=' . $limit . '&cat='.$blogCategoryIdStr);
		if(have_posts())
		{
			while(have_posts())
			{
				 the_post();
				$totalpost_count++;
			}
		}
	}
    ?>
<?php if (is_paged()) $is_paged = true; ?>


        <?php if(have_posts()) : ?>
        <?php 
        if(!is_category())
		{
			global $posts_per_page;
			$limit = $posts_per_page;
			global $paged;
			$blogCategoryIdStr = $blogCategoryIdStr;
			query_posts('showposts=' . $limit . '&paged=' . $paged .'&cat='.$blogCategoryIdStr);
        }
		while(have_posts()) : the_post() ?>
    
   <div class="posts clearfix">        
<h3  class="title" id="post-<?php the_ID(); ?>"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>">
  <?php the_title(); ?>
  </a></h3>
<p class="time_blog"><span class="i_clock alignleft"> <?php the_time('j F, Y') ?> at <?php the_time('g:i a') ?> </span>  
<?php if(function_exists('the_views')) { the_views(); } ?>  &nbsp; in   <?php the_category(' / ') ?>  // <?php comments_popup_link('(0) Comment', '(1) Comment', '(%) Comment'); ?></p>
  
  
  
     
    <?php if($mimg !== '') { ?>
<?php } else { echo ''; } ?>
<?php the_excerpt(); ?>

  
   
  
   <div class="post_bottom"> 
    <?php the_tags(' <span class="i_tags">'.__('Tags : ').'', ', ', '</span>'); ?> 
     </div>                     
 </div>
    
        <?php endwhile; ?>
        
        <div class="wp-pagenavi">
        
            <?php if (function_exists('wp_pagenavi')) { ?><?php wp_pagenavi(); ?><?php } ?>
                    
        </div>
        
       
    
        <?php endif; ?>
        <?php
        }
		?>
        
 </div>
 
<?php get_sidebar(); ?>
<?php get_footer(); ?>