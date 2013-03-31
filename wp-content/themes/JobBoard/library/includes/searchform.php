<?php
if($_GET['s'])
{
	$s = $_GET['s'];	
}else
{
	$s = FIND_A_JOB_TEXT;
}
$location = $_REQUEST['location'];
if(!$location){ $location = LOCATION; }
?>
<div id="search">
 <form method="get" id="searchform" action="<?php echo site_url(); ?>/">
 <?php if(get_option("ptttheme_enable_radius_search") == 'Yes')
        {
			$class = "textfeild_bg";
		}
	   else
	    {
			$class = "textfeild_bg no";
		}
 
 ?>
	<div class="<?php echo $class; ?>">
    	<input type="text" value="<?php echo $s;?>" name="s" class="searchjob" onfocus="if (this.value == '<?php echo FIND_A_JOB_TEXT;?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo FIND_A_JOB_TEXT;?>';}"/>
		<input type="text" name="location" id="location" class="location" onfocus="if (this.value == '<?php echo LOCATION;?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php echo LOCATION;?>';}" value="<?php echo $location;?>" />
		<?php $radius = $_REQUEST['radius'];
		if(is_enable_radius()){
		$mileunit = get_option('pttthemes_milestone_unit');
		if($mileunit == 'Miles')
		  {
			 $unit = 'mile';
			 $units = 'miles';
		  }
		else
		  {
			  $unit = 'kilometer';
			  $units = 'kilometers';
		  }
		$all_radius = explode(',',get_option('pttthemes_milestone'));
		?>
		<select class="radius" name="radius">
			<?php for($r=0 ; $r <= count($all_radius) ; $r ++){ 
			if($all_radius[$r] !=''){
			?>
			<?php if($all_radius[$r] == 1 || $all_radius[$r] == 0): ?>
				<option value="<?php echo $all_radius[$r]; ?>" <?php if($radius == $all_radius[$r]){ ?>selected=selected<?php } ?>><?php echo $all_radius[$r]." "; _e($unit,'templatic'); ?></option>
			<?php else: ?>	
				<option value="<?php echo $all_radius[$r]; ?>" <?php if($radius == $all_radius[$r]){ ?>selected=selected<?php } ?>><?php echo $all_radius[$r]." "; _e($units,'templatic'); ?></option>
			<?php endif; ?>	
			<?php } } ?>
	    </select><?php } ?>
		<?php $jtype = $_REQUEST['jtype']; 
		if($jtype){ ?>
		<input type="hidden" value="<?php echo $jtype; ?>" name="jtype"/>
		<?php }else{ ?>
		<input type="hidden" value="all" name="jtype"/>
		<?php } ?>
    </div>
	<div class="submit_bg"><input type="submit" alt="" class="sgo" value="<?php _e('Go');?> &raquo;" /></div>
    <div class="clear"></div>
</form>
<a href="<?php echo get_option('siteurl');?>/?page=advance_search&true=1" class="advance_search"><?php echo ADV_SEARCH_TEXT; ?></a>
</div> 