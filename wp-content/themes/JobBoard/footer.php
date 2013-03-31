<?php
global $options;
foreach ($options as $value) {
		global $$value['id'];
        if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
?>
</div>
</div>
<!--content-wrap end -->

<div id="footer" class="clearfix">
  <div id="footer-in">
	  <p>Copyright <?php echo date("Y"); ?> &copy; <?php bloginfo('name'); ?> All rights reserved.</p>
      <div id="flinks">
	    <?php dynamic_sidebar("footer-area"); ?>
   	  </div>
      <?php echo stripslashes(get_option('ptthemes_footer_text')); ?>
  </div>
  <!--footer-in end-->
</div>
<script type="text/javascript">
/* <![CDATA[ */
function applyForJob(post_id,action)
{
 	<?php 
	global $current_user;
	?>
	var fav_url; 
	if(action == 'add')
	{
		document.getElementById('applied_job_'+post_id).innerHTML ="<span style='color:green;'>Processing....</span>";
		fav_url = '<?php echo site_url(); ?>/index.php?page=apply&action=add&pid='+post_id;
	}
	else
	{
		fav_url = '<?php echo site_url(); ?>/index.php?page=apply&action=remove&pid='+post_id;
		
	}
	var $ac = jQuery.noConflict();
	$ac.ajax({	
		url: fav_url ,
		type: 'GET',
		dataType: 'html',
		timeout: 20000,
		error: function(){
			alert('Error while apply for job.');
		},
		success: function(html){	
		<?php 
		if($_REQUEST['list']=='apply')
		{ ?>
			//document.getElementById('list_property_'+post_id).style.display='none';	
			document.getElementById('post_'+post_id).style.display='none';	
			<?php
		}
		?>	
			document.getElementById('applied_job_'+post_id).innerHTML=html;								
		}
	});
	return false;
	
}
/* ]]> */
</script>
<?php wp_footer(); ?>
<!--footer end-->
</body></html>