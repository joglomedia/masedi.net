<?php $page_title = PAY_CANCELATION_TITLE;
global $page_title;?>
<?php get_header(); ?>
<?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') {  ?>
<div class="breadcrumb_in"><a href="<?php echo site_url(); ?>"><?php _e('Home'); ?></a> &raquo; <?php echo $page_title; ?></div><?php } ?>
<div class="content-title"><?php echo $page_title; ?></div>
<div  class="<?php templ_content_css();?>" >
<div class="post-content">

<?php 
$filecontent = stripslashes(get_option('post_payment_cancel_msg_content'));
if(!$filecontent)
{
	$filecontent = PAY_CANCEL_MSG;
}
$store_name = get_option('blogname');
$search_array = array('[#site_name#]');
$replace_array = array($store_name);
$filecontent = str_replace($search_array,$replace_array,$filecontent);
echo $filecontent;
?> 
</div> <!-- content #end -->
</div> 
<div id="sidebar">
<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>