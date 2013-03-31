<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'searchform.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
?>
<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
  <div class="search-form" style="margin:-1px 0 0 -10px;padding:0 0 25px 0;">
    <input id="searchbox1" type="text" value="" name="s" class="search search-text" /><input type="submit" id="searchsubmit" value="" class="search-submit" />
  </div>
</form>
