<?php
/*
Template Name: Page - Advanced Search
*/
?>
<?php
add_action('wp_head','templ_header_tpl_advsearch');
function templ_header_tpl_advsearch()
{
	?>
	<script type="text/javascript" language="javascript">var rootfolderpath = '<?php echo bloginfo('template_directory');?>/images/';</script>
	<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/dhtmlgoodies_calendar.js"></script>
    <?php
}
?>
<?php get_header(); ?>
<div id="content-wrap" class="clear <?php if(get_option("ptthemes_page_layout") == "Right Sidebar") { echo "right-side"; } else { echo "left-side"; } ?>" >
<?php if ( get_option( 'ptthemes_breadcrumbs' ) == 'Yes') {  ?>
   <div class="breadcrumb">
    <ul class="page-nav"><li><?php yoast_breadcrumb('',' &raquo; '.__(SEARCH_WEBSITE));  ?></li></ul>
	</div><?php } ?>
<!--  CONTENT AREA START -->
<?php if($_REQUEST['true'] ==1){ ?>

<div id="content">
  <div <?php post_class('single clear'); ?> id="post_<?php the_ID(); ?>">
    <div class="post-meta">
      <?php //templ_page_title_above(); //page title above action hook?>
      <?php echo templ_page_title_filter(SEARCH_WEBSITE); //page tilte filter?>
      <?php templ_page_title_below(); //page title below action hook?>
     </div>
    <div class="post-content">
<?php }else{ ?>
<?php if ( have_posts() ) : ?>
<?php while ( have_posts() ) : the_post(); ?>
<div id="content">
  <div <?php post_class('single clear'); ?> id="post_<?php the_ID(); ?>">
    <div class="post-meta">
      <?php //templ_page_title_above(); //page title above action hook?>
      <?php echo templ_page_title_filter(get_the_title()); //page tilte filter?>
      <?php templ_page_title_below(); //page title below action hook?>
     </div>
    <div class="post-content">
      <?php endwhile; ?>
      <?php endif; 
 }    ?>
        <div class="post-content">
    	 <?php the_content(); ?>
    </div>
      
      
      <div id="advancedsearch">
        <form method="get"  action="<?php echo bloginfo('url')."/"; ?>" name="searchform" onsubmit="return sformcheck();">

           <div class="jobform"> 
			<div class="jobform_l"><?php echo SEARCH;?></div>
               <div class="jobform_r"> <input class="jobtextfield" name="s" id="adv_s" type="text" PLACEHOLDER="<?php echo SEARCH; ?>" value="" /></div>
			  <input class="jobtextfield" name="adv_search" id="adv_search" type="hidden" value="1"  />
            </div> 
			<div class="jobform"> 
			<div class="jobform_l"><?php echo TAG_SEARCG_TEXT;?></div>
            <div class="jobform_r"> <input class="jobtextfield" name="tag_s" id="tag_s" type="text"  PLACEHOLDER="<?php echo TAG_SEARCG_TEXT; ?>" value=""  /></div>
			  <input class="jobtextfield" name="adv_search" id="adv_search" type="hidden" value="1"  />
            </div>
            <div class="jobform"> 
			<div class="jobform_l"><?php echo POST_TYPE_TEXT; ?></div>
            <div class="jobform_r">     
			<?php
			$custom_post_types_args = array();  
			$ptype = $_REQUEST['post_type'];  ?>
                 <select name="post_type" id="post_type">
					<option value="job" <?php if($ptype =='job'){ echo 'selected=selected'; }?>><?php _e('Jobs','templatic');?></option>
                  	<option value="resume" <?php if($ptype =='resume'){ echo 'selected=selected';}?>><?php _e('Resumes','templatic'); ?></option>
                  </select></div>
            </div> 
			
			<div class="jobform"> 
			<div class="jobform_l"><?php echo CATEGORY;?></div>
            <div class="jobform_r">   <?php wp_dropdown_categories( array('name' => 'catdrop','orderby'=> 'name','show_option_all' => __('select category','templatic'), 'taxonomy'=>array(CUSTOM_CATEGORY_TYPE1,CUSTOM_CATEGORY_TYPE2)) ); ?></div>
            </div>
           
            
			
			<?php 
			$post_types = "'job','resume'";
			$custom_metaboxes = get_post_custom_fields_templ($post_types,'0','user_side','1');
			search_custom_post_field($custom_metaboxes); ?>
		<div class="jobform"> 
   
		<div class="jobform_r"><input type="submit" value="Submit" class="normal_button" />
		</div>
		</div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php get_sidebar(); ?>

<!--  CONTENT AREA END -->
</div>
<script type="text/javascript" >
function sformcheck()
{
if(document.getElementById('adv_s').value=="")
{
	alert('<?php echo SEARCH_ALERT_MSG;?>');
	document.getElementById('adv_s').focus();
	return false;
}
if(document.getElementById('adv_s').value=='<?php echo SEARCH;?>')
{
document.getElementById('adv_s').value = ' ';
}
return true;
}
</script>

<?php get_footer(); ?>