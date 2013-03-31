<?php get_header(); ?>
<div id="page">
<div class="top"></div>
<div id="content-wrap" class="clear <?php if(get_option("ptthemes_page_layout") == "Right Sidebar") { echo "right-side"; } else { echo "left-side"; } ?>" >
<div id="content">

 <div class="content-title"><h1>404! We couldn't find the page!</h1></div>
  <h3><?php _e('Sorry, no posts matched your criteria.');?></h3>
    <p><?php _e('Please try searching again here...');?></p>
    <p><strong><?php _e('Or, take a look at Archives and Categories');?></strong></p>
     
    <div class="category">
    	<h2><?php _e('Category'); ?></h2>
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

</div>	

<!--include sidebar-->
<?php get_sidebar();?>
<!--include footer-->
<?php get_footer(); ?>

