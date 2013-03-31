<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'sm_searchform.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
?>
<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
  <div class="search-form">
    <input id="searchbox" type="text" value="<?php echo wp_specialchars($s, 1); ?>" name="s" class="search sm-search-text" /><input type="submit" id="searchsubmit" value="" class="sm-search-submit" />
  </div>
</form>
