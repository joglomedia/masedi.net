<!-- Side Right - START -->
<div class="SR">

 <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>

<?php endif; ?>

 <div class="SRL">
 


  <div class="Categories">
   <h2><strong>Categories</strong></h2>
    <ul>
      <?php list_cats(0, '', 'name', 'asc', '', 1, 0, 0, 1, 1, 1, 0,'','','','','') ?>
   </ul>
   </div>
    
<div class="Archives">   
 <h2>Archives</h2>
  <ul>
   <?php wp_get_archives('type=monthly'); ?>
  </ul>
</div>

  <div class="Links">
   <h2><strong>Links</strong></h2>
    <ul>
     <?php get_links('-1', '<li>', '</li>', '', FALSE, 'id', FALSE, 
FALSE, -1, FALSE); ?>
    </ul>
   </div>
 
<div class="Meta">  
<h2>Meta</h2>
<ul>
<?php wp_register(); ?>
 <li><?php wp_loginout(); ?></li>
 <li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>
 <li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
 <li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
<?php wp_meta(); ?>
</ul>
</div>

</div>

<div class="SRR">
 
<div class="Calendar">
 <h2>Calendar</h2>
 <?php get_calendar(daylength); ?>
</div>

 </div>


</div>

<!-- Side Right - END -->