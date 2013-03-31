<?php
if($_REQUEST['alook'])
{
}else
{
?>
<div class="published_box">
<?php
$form_action_url = get_ssl_normal_url(get_option( 'siteurl' ).'/?page=paynows');
?>
<form method="post" action="<?php echo $form_action_url; ?>" name="paynow_frm"  >
 <script type="text/javascript">
 /* <![CDATA[ */
function showoptions(paymethod)
{
<?php
for($i=0;$i<count($paymethodKeyarray);$i++)
{
?>
showoptvar = '<?php echo $paymethodKeyarray[$i]?>options';
if(eval(document.getElementById(showoptvar)))
{
	document.getElementById(showoptvar).style.display = 'none';
	if(paymethod=='<?php echo $paymethodKeyarray[$i]?>')
	{
		document.getElementById(showoptvar).style.display = '';
	}
}

<?php
}	
?>
}
<?php
for($i=0;$i<count($paymethodKeyarray);$i++)
{
?>
if(document.getElementById('<?php echo $paymethodKeyarray[$i];?>_id').checked)
{
showoptions(document.getElementById('<?php echo $paymethodKeyarray[$i];?>_id').value);
}
<?php
}	
?>
/* ]]> */
</script>
	<?php
	if($is_delet_resume)
	{
		$post_sql = mysql_query("select post_author,ID from $wpdb->posts where post_author = '".$current_user->ID."' and ID = '".$_REQUEST['pid']."'");
	if((mysql_num_rows($post_sql) > 0) || ($current_user->ID == 1)){
		
	?>
		<h5 class="payment_head"><?php echo PRO_DELETE_RESUME_MSG;?></h5>
		<input type="button" name="Delete" value="<?php echo PRO_DELETE_BUTTON;?>" class="btn_input_highlight btn_spacer fr" onclick="window.location.href='<?php echo get_option('siteurl');?>/?page=delete&amp;pid=<?php echo $_REQUEST['pid']?>'" />
		<input type="button" name="Cancel" value="<?php echo PRO_CANCEL_BUTTON;?>" class="btn_input_normal fl" onclick="window.location.href='<?php echo get_author_link($echo = false, $current_user->ID);?>'" />

            <?php  } else { echo "ERROR: SORRY, you can not delete this post."; }?>

	<?php
	}else
	{
	?>
    
    <input type="hidden" name="paynow" value="1" />
	<input type="hidden" name="pid" value="<?php echo $_POST['pid'];?>" />
	<?php
	if($_REQUEST['pid'])
	{
	?> 
		<input type="submit" name="paynow" value="<?php echo PRO_UPDATE_BUTTON;?>" class="btn_input_highlight btn_spacer fr" />
	<?php
	}else
	{
	?>
		<input type="submit" name="paynow" value="<?php echo PUB_SUBMIT_BUTTON;?>" class="btn_input_highlight btn_spacer fr" />
	<?php
	}
	?>
    <?php if($_POST['renew'] == 1): ?>
        <input type="button" name="Cancel" value="<?php echo PRO_CANCEL_BUTTON;?>" class="btn_input_normal fl" onclick="window.location.href='<?php echo get_author_link($echo = false, $current_user->ID);?>'" />
        <a href="<?php echo get_option('siteurl');?>/?page=postaresume&amp;backandedit=1&amp;renew=1<?php if($_REQUEST['pid']){ echo '&pid='.$_REQUEST['pid'];}?>" class="btn_input_normal fl left" ><?php echo PRO_BACK_AND_EDIT_TEXT;?></a>
	<?php else: ?>
        <input type="button" name="Cancel" value="<?php echo PRO_CANCEL_BUTTON;?>" class="btn_input_normal fl" onclick="window.location.href='<?php echo get_author_link($echo = false, $current_user->ID);?>'" />
        <a href="<?php echo get_option('siteurl');?>/?page=postaresume&amp;backandedit=1<?php if($_REQUEST['pid']){ echo '&pid='.$_REQUEST['pid'];}?>" class="btn_input_normal fl left" ><?php echo PRO_BACK_AND_EDIT_TEXT;?></a>
	<?php endif; ?>
	 <?php }?>  
     </form>
     </div>
<?php }?>