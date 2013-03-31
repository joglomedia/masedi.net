<?php
if($_REQUEST['alook'])
{
}else
{
?>
<div class="published_box">
<?php
global $current_user;
$form_action_url = get_ssl_normal_url(get_option( 'siteurl' ).'/?page=paynow');
?>
<form method="post" action="<?php echo $form_action_url; ?>" name="paynow_frm"  >
	<?php
	$job_price_info = get_job_price_info($_REQUEST['price_select']);
	$payable_amount = $_POST['total_price'];
	$alive_days = $job_price_info[0]['alive_days'];
	if($payable_amount==0 && get_alive_days($current_user->ID)){
		$alive_days = get_alive_days($current_user->ID);
	}
	$type_title = $job_price_info[0]['title'];
	if($_REQUEST['job_add_coupon']!='')
	{
		if(is_valid_coupon($_SESSION['job_info']['job_add_coupon']))
		{
			$payable_amount = get_payable_amount_with_coupon($payable_amount,$_SESSION['job_info']['job_add_coupon']);
		}else
		{
			echo '<p class="error_msg_fix">'.WRONG_COUPON_MSG.'</p>';
		}
	}
	if(($_REQUEST['pid']=='' && $payable_amount>0) || ($_POST['renew'] && $payable_amount>0 && $_REQUEST['pid']!=''))
	{
		$message = sprintf(__('You are going to submit %s job and pay %s for %s days.'),$type_title,get_currency_sym().$payable_amount,$alive_days);
	}else
	{
		if($_REQUEST['pid']=='')
		{
			$message = sprintf(__('You are going to submit %s job for %s days.'),$type_title,$alive_days);
		}elseif(!$is_delet_job)
		{
			$message = sprintf(__('You are going to update job for %s days.'),$alive_days);
		}
	}
	?>
	<h5 class="free_property"> <?php _e($message);?> </h5>
	<?php
	if(($_REQUEST['pid']=='' && $payable_amount>0) || ($_POST['renew'] && $payable_amount>0 && $_REQUEST['pid']!=''))
	{
		$paymentsql = "select * from $wpdb->options where option_name like 'payment_method_%' order by option_id";
		$paymentinfo = $wpdb->get_results($paymentsql);
		if($paymentinfo)
		{
		?>
  <h5 class="payment_head"> <?php echo SELECT_PAY_MEHTOD_TEXT; ?></h5>
  <ul class="payment_method">
	<?php
			$paymentOptionArray = array();
			$paymethodKeyarray = array();
			foreach($paymentinfo as $paymentinfoObj)
			{
				$paymentInfo = unserialize($paymentinfoObj->option_value);
				if($paymentInfo['isactive'])
				{
					$paymethodKeyarray[] = $paymentInfo['key'];
					$paymentOptionArray[$paymentInfo['display_order']][] = $paymentInfo;
				}
			}
			ksort($paymentOptionArray);
			if($paymentOptionArray)
			{
				foreach($paymentOptionArray as $key=>$paymentInfoval)
				{
					for($i=0;$i<count($paymentInfoval);$i++)
					{
						$paymentInfo = $paymentInfoval[$i];
						$jsfunction = 'onclick="showoptions(this.value);"';
						$chked = '';
						if($key==1)
						{
							$chked = 'checked="checked"';
						}
					?>
		<li id="<?php echo $paymentInfo['key'];?>">
		  <input <?php echo $jsfunction;?>  type="radio" value="<?php echo $paymentInfo['key'];?>" id="<?php echo $paymentInfo['key'];?>_id" name="paymentmethod" <?php echo $chked;?> />  <?php echo $paymentInfo['name']?>
		 
		  <?php
						if(file_exists(TEMPLATEPATH.'/library/payment/'.$paymentInfo['key'].'/'.$paymentInfo['key'].'.php'))
						{
						?>
		  <?php
							include_once(TEMPLATEPATH.'/library/payment/'.$paymentInfo['key'].'/'.$paymentInfo['key'].'.php');
							?>
		  <?php
						} 
					 ?> </li>
		  <?php
					}
				}
			}else
			{
			?>
			<li><?php echo NO_PAYMENT_METHOD_MSG;?></li>
			<?php
			}
			
		?>
 	  
  </ul>
  <?php
		}
	}
	?>
	
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
	if($is_delet_job)
	{
		$post_sql = mysql_query("select post_author,ID from $wpdb->posts where post_author = '".$current_user->ID."' and ID = '".$_REQUEST['pid']."'");
	if((mysql_num_rows($post_sql) > 0) || ($current_user->ID == 1)){
		
	?>
		<h5 class="payment_head"><?php echo PRO_DELETE_PRE_MSG;?></h5>
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
		<?php if($payable_amount>0): ?>
	        <input type="submit" name="paynow" value="<?php echo PRO_SUBMIT_BUTTON;?>" class="btn_input_highlight btn_spacer fr" />
        <?php else: ?>
	        <input type="submit" name="paynow" value="<?php echo PUB_SUBMIT_BUTTON;?>" class="btn_input_highlight btn_spacer fr" />
        <?php endif; ?>    
	<?php
	}
	?>
    <?php if($_POST['renew'] == 1): ?>
        <input type="button" name="Cancel" value="<?php echo PRO_CANCEL_BUTTON;?>" class="btn_input_normal fl" onclick="window.location.href='<?php echo get_author_link($echo = false, $current_user->ID);?>'" />
        <a href="<?php echo get_option('siteurl');?>/?page=postajob&amp;backandedit=1&amp;renew=1<?php if($_REQUEST['pid']){ echo '&pid='.$_REQUEST['pid'];}?>" class="btn_input_normal fl left" ><?php echo PRO_BACK_AND_EDIT_TEXT;?></a>
	<?php else: ?>
        <input type="button" name="Cancel" value="<?php echo PRO_CANCEL_BUTTON;?>" class="btn_input_normal fl" onclick="window.location.href='<?php echo get_author_link($echo = false, $current_user->ID);?>'" />
        <a href="<?php echo get_option('siteurl');?>/?page=postajob&amp;backandedit=1<?php if($_REQUEST['pid']){ echo '&pid='.$_REQUEST['pid'];}?>" class="btn_input_normal fl left" ><?php echo PRO_BACK_AND_EDIT_TEXT;?></a>
	<?php endif; ?>
	 <?php }?>  
     </form>
     </div>
<?php }?>