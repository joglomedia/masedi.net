<!-- #sidebar from here -->
<div id="sidebar">
  <div id="space">&nbsp;</div>
  <div id="advertisment" style="padding-top: 5px;">
    <div style="margin-left: 3px;">
  <?php include (TEMPLATEPATH . '/advertisment.php'); /* Open advertisment.txt to edit */?>
    </div>
  </div>
	<ul>
	  <li id="categories">
      <h3 class="sbtitle">&nbsp; <?php _e('Categories'); ?></h3>
       <ul>
         <?php wp_list_cats('sort_column=name&hierarchical=1') ?>
       </ul>
    </li>
    
    <li id="archive">
      <h3 class="sbtitle">&nbsp; <?php _e('Monthly archives'); ?></h3>
       <ul>
         <?php wp_get_archives('type=monthly'); ?>
       </ul>
    </li>
    
    <li id="pages">
      <h3 class="sbtitle">&nbsp; Pages</h3>
       <ul>
         <?php wp_list_pages('sort_column=menu_order&title_li=&child_of='. $parent_id); ?>
       </ul>
    </li>
    
    <!-- from here start display widget bar -->
    
    <?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar() ) : ?>
    <?php endif; ?>
    
  </ul> 
</div>