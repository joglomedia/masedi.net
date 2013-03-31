<?php get_header(); ?>
<div id="page">
 <div id="content-wrap" class="clear <?php if(get_option("ptthemes_page_layout") == "Right Sidebar") { echo "right-side"; } else { echo "left-side"; } ?>" >
 
<div id="content">

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
<?php if (is_paged()) $is_paged = true; ?>


<?php if(have_posts()) : ?>
<?php 
while(have_posts()) : the_post() ?>

<div class="posts clearfix">        
<h3  class="title" id="post-<?php the_ID(); ?>"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>">
<?php the_title(); ?>
</a></h3>
<p class="time_blog"><span class="i_clock alignleft"> <?php the_time('j F, Y') ?> at <?php the_time('g:i a') ?> </span>  
<?php if(function_exists('the_views')) { the_views(); } ?>  &nbsp; in   <?php the_category(' / ') ?>  // <?php comments_popup_link('(0) Comment', '(1) Comment', '(%) Comment'); ?></p>




<?php if($mimg !== '') { ?>
<?php } else { echo ''; } ?>
<?php the_content('continue'); ?>




<div class="post_bottom"> 
<?php the_tags(' <span class="i_tags">'.__('Tags : ').'', ', ', '</span>'); ?> 
</div>                     
</div>

<?php endwhile; ?>
  <?php pagenavi('<div class="pagenavi">',' </div>');  ?>

   <?php else : ?>
 <h3><?php _e('Sorry, no posts matched your criteria.');?></h3>
    <p><?php _e('Please try searching again here...');?></p>
         
    <p class="clear"><strong><?php _e('Or, take a look at Archives and Categories');?></strong></p>
     
     </div> 
       
<?php endif; ?>
        
 </div>
 
<?php get_sidebar(); ?>
<?php get_footer(); ?>