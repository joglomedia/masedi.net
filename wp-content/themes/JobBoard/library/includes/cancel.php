<?php get_header(); ?>
<div class="breadcrumbs">
	<p><?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') { yoast_breadcrumb('',' &raquo; '.PAY_CANCELATION_TITLE); } ?></p>
</div>
 <div class="contentarea">
	<div id="content" class="content_<?php echo stripslashes(get_option('ptthemes_sidebar_left'));  ?>">
	<h1 class="page_head"><?php echo PAY_CANCELATION_TITLE;?></h1>			
		<?php
		global $upload_folder_path;
		$destinationfile =  stripslashes(get_option('post_payment_cancel_msg_content'));
		if($destinationfile)
		{
			$filecontent = $destinationfile;
		}else
		{
			$filecontent = PRPOERTY_PAY_CANCEL_MSG;
		}
		?>
		<?php
		$store_name = get_option('blogname');
		$post_link = get_option('siteurl').'/?page=preview&alook=1&pid='.$_REQUEST['pid'];
		$search_array = array('[#site_name#]','[#submited_property_link#]');
		$replace_array = array($store_name,$post_link);
		$filecontent = str_replace($search_array,$replace_array,$filecontent);
		if($filecontent)
		{
		?>
		
		 <?php echo $filecontent; ?> 
		
		<?php
		}else
		{
		?>
		<h1><?php echo PAY_CANCEL_MSG; ?></h1> 
		<?php
		}
		?>	
	</div> <!-- content #end -->
		
		<?php get_sidebar(); ?>  <!-- sidebar #end -->
	
	</div> <!--contentarea #end  -->
<?php get_footer(); ?>