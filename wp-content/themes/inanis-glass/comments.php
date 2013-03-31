<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');
?>
<?php 
  if (function_exists('wp_list_comments')) {
    include("newcomments.php");
  }
  else {
    include("legacycomments.php");
  }
?>