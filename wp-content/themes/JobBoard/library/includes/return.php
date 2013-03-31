<?php get_header(); ?>
<?php st_before_content($columns=''); ?>
<ul class="page-nav"><li><?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') { yoast_breadcrumb('',' &raquo; '.PAYMENT_SUCCESS_TITLE); } ?></li></ul>
	<div id="content" class="eleven columns">
         <h1 class="page_head"><?php echo PAYMENT_SUCCESS_TITLE;?></h1>
            <?php
            global $upload_folder_path;
            $destinationfile =  stripslashes(get_option('post_payment_success_msg_content'));
            if($destinationfile)
            {
                $filecontent = $destinationfile;
            }else
            {
                $filecontent = __(PAYMENT_SUCCESS_AND_RETURN_MSG);
            }
            ?>
            <?php
            $store_name = get_option('blogname');
            $post_link = get_option('siteurl').'/?page=preview&alook=1&pid='.$_REQUEST['pid'];
            $search_array = array('[#site_name#]','[#submited_information_link#]');
            $replace_array = array($store_name,$post_link);
            $filecontent = str_replace($search_array,$replace_array,$filecontent);
            if($filecontent)
            {
            echo $filecontent;
            }else
            {
            ?> 
            <h4><?php echo PAYMENT_SUCCESS_MSG1; ?></h4>
            <h6><?php echo PAYMENT_SUCCESS_MSG2; ?></h6>
            <h6><?php echo PAYMENT_SUCCESS_MSG3.' '.get_option(('blogname').'.'); ?></h6>
            <?php
            }
            ?>
	</div>
<?php st_after_content(); ?>
<?php get_sidebar(); ?>  <!-- sidebar #end -->
<?php get_footer(); ?>