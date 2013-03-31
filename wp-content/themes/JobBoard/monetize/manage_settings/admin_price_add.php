<?php
global $wpdb,$price_db_table_name;
if($_POST['priceact'] == 'addprice')
{
	$id = $_POST['price_id'];
	$price_title = $_POST['price_title'];
	$price_desc = $_POST['price_desc'];
	$package_cost = $_POST['amount'];
	$validity = $_POST['validity'];
	$validity_per = $_POST['validity_per'];
	$is_recurring = $_POST['recurring'];
	$billing_num = $_POST['billing_num'];
	$billing_per = $_POST['billing_per'];
	$status = $_POST['status'];
	$billing_cycle = $_POST['billing_cycle'];
	if($cat){
		$price_post_cat = implode(",",$cat);
	}
	$is_featured = $_POST['is_featured'];
	$feature_amount = $_POST['feature_amount'];
	$feature_cat_amount = $_POST['feature_cat_amount'];

	if($id)	{
		$wpdb->query("update $price_db_table_name set price_title=\"$price_title\", price_desc=\"$price_desc\", package_cost=\"$package_cost\",validity=\"$validity\",validity_per=\"$validity_per\",is_recurring=\"$is_recurring\",billing_num=\"$billing_num\",billing_per=\"$billing_per\",billing_cycle=\"$billing_cycle\",status=\"$status\",is_featured=\"$is_featured\",feature_amount=\"$feature_amount\",feature_cat_amount=\"$feature_cat_amount\" where pid=\"$id\"");
		$msgtype = 'edit_price';
	}else	{
		$insertprice = "insert into $price_db_table_name (price_title,price_desc,package_cost,validity,validity_per,is_recurring,billing_num,billing_per,billing_cycle,status,is_featured,feature_amount,feature_cat_amount) values ('".$price_title."','".$price_desc."','".$package_cost."','".$validity."','".$validity_per."','".$is_recurring."','".$billing_num."','".$billing_per."','".$billing_cycle."','".$status."','".$is_featured."','".$feature_amount."','".$feature_cat_amount."')";
		$wpdb->query($insertprice);
		$msgtype = 'add_price';
	}
	$location = site_url()."/wp-admin/admin.php";
	echo '<form action="'.$location.'#option_display_price" method=get name="price_success">
	<input type=hidden name="page" value="manage_settings"><input type=hidden name="msg" value="pricesuccess"><input type=hidden name="msgtype" value="'.$msgtype.'"></form>';
	echo '<script>document.price_success.submit();</script>';
	exit;

}
if($_REQUEST['price_id']!='')
{
	$pid = $_REQUEST['price_id'];
	$pricesql = "select * from $price_db_table_name where pid=\"$pid\"";
	$addpriceinfo = $wpdb->get_results($pricesql);
	$price_title = 'Edit price';
	$price_msg = PRICE_EDIT_MOD_TITLE;
} else {
	$price_title = PRICE_MOD_TITLE;
	$price_msg = PRICE_MOD_MSG;
}
?>
<form action="<?php echo site_url()?>/wp-admin/admin.php?page=manage_settings&mod=price&pagetype=addedit" method="post" name="price_frm">
<input type="submit" name="submit" value="<?php _e('Save all changes','templatic');?>" onclick="return price_validation();" class="button-framework-imp right position_top" />
<h4><?php _e($price_title,'templatic');?> 

<a href="<?php echo site_url();?>/wp-admin/admin.php?page=manage_settings#option_display_price" name="btnviewlisting" class="l_back" title="<?php _e('Back to manage price list','templatic');?>"/><?php echo PRICE_BACK_LABLE; ?></a>
</h4>
 <p class="notes_spec"><?php _e($price_msg,'templatic');?></p>
<p style="background: #f4f4f4; padding:10px; margin-bottom:20px;"><b><?php echo PRICE_SETTING_TITLE; ?></b></p>

  <input type="hidden" name="priceact" value="addprice">
  <input type="hidden" name="price_id" value="<?php echo $_REQUEST['price_id'];?>">
  
  <div class="option option-select"  >
    <h3><?php echo PRICE_PACK_TITLE;?></h3>
    <div class="section">
      <div class="element">
           <input type="text" name="price_title" id="title" value="<?php echo $addpriceinfo[0]->price_title;?>">
   		</div>
      <div class="description"><?php echo PRICE_TITLE_NOTE;?></div>
    </div>
  </div> <!-- #end -->
  
  <div class="option option-select"  >
    <h3><?php echo PRICE_DESC_TITLE;?></h3>
    <div class="section">
      <div class="element">
         <textarea name="price_desc" cols="40" rows="5" id="title_desc"><?php echo stripslashes($addpriceinfo[0]->price_desc);?></textarea>
   		</div>
      <div class="description"><?php echo PRICE_DESC_NOTE;?></div>
    </div>
  </div> <!-- #end -->
  <div class="option option-select"  >
    <h3><?php echo PRICE_AMOUNT_TITLE;?></h3>
    <div class="section">
      <div class="element">
          <input type="text" name="amount" value="<?php echo $addpriceinfo[0]->package_cost;?>">
   		</div>
      <div class="description"><?php echo PRICE_AMOUNT_NOTE;?> </div>
    </div>
  </div> <!-- #end -->
  
  <div class="option option-select"  >
    <h3><?php echo VALIDITY_TITLE;?></h3>
    <div class="section">
      <div class="element">
			  <input type="text" class="textfield billing_num" name="validity" id="validity" value="<?php echo $addpriceinfo[0]->validity;?>">
			  <select name="validity_per" id="validity_per" class="textfield billing_per">
			  <option <?php if($addpriceinfo[0]->validity_per == 'D') { ?> selected="selected" <?php } ?> value="D"><?php _e('days','templatic'); ?></option>
			  <option <?php if($addpriceinfo[0]->validity_per == 'M') { ?> selected="selected" <?php } ?> value="M"><?php _e('months','templatic'); ?></option>
			  <option <?php if($addpriceinfo[0]->validity_per == 'Y') { ?> selected="selected" <?php } ?> value="Y"><?php _e('years','templatic'); ?></option>
			  </select>
   		</div>
      <div class="description"><?php echo VALIDITY_NOTE;?></div>
    </div>
  </div> <!-- #end -->
  
   <div class="option option-select"  >
    <h3><?php _e('Status','templatic');?></h3>
    <div class="section">
      <div class="element">
         <select name="status" >
          <option value="1" <?php if($addpriceinfo[0]->status=='1'){ echo 'selected="selected"';}?> ><?php _e("Active",'templatic');?></option>
          <option value="0" <?php if($addpriceinfo[0]->status=='0'){ echo 'selected="selected"';}?> ><?php _e("Inactive",'templatic');?></option>
          </select>
   		</div>
      <div class="description"><?php echo STATUS_NOTE;?></div>
    </div>
  </div> <!-- #end -->
  
  <div class="option option-select"  >
    <h3><?php echo REC_TITLE; ?></h3>
    <div class="section">
      <div class="element">
		<div class="input_wrap">
		 <select name="recurring" id="recurring" onChange="rec_div_show(this.value)">
          <option value="1" <?php if($addpriceinfo[0]->is_recurring ==1){ echo 'selected=selected';}?> ><?php _e("Yes",'templatic');?></option>
          <option value="0" <?php if($addpriceinfo[0]->is_recurring==0){ echo 'selected=selected';}?> ><?php _e("No",'templatic');?></option>
          </select>
			</div>
   	</div>
      <div class="description"><?php echo REC_NOTE;?></div>
		
    </div>
		
   </div> <!-- #end -->
	<div class="option option-select" id="rec_div" <?php if($addpriceinfo[0]->is_recurring!='1'){ echo "style=display:none"; }?> >
	 <div class="section change_user">
			<h4><?php echo BILLING_PERIOD_TITLE; ?></h4>
			  <span class="option_label"><?php echo CHARGES_USER; ?> </span>
			  <input type="text" class="textfield billing_num" name="billing_num" id="billing_num" value="<?php echo $addpriceinfo[0]->billing_num; ?>">
			  <select name="billing_per" id="billing_per" class="textfield billing_per">
			  <option value="D" <?php if($addpriceinfo[0]->billing_per =='D'){ echo 'selected=selected';}?> ><?php _e('days','templatic'); ?></option>
			  <option value="M" <?php if($addpriceinfo[0]->billing_per =='M'){ echo 'selected=selected';}?> ><?php _e('months','templatic'); ?></option>
			  <option value="Y" <?php if($addpriceinfo[0]->billing_per =='Y'){ echo 'selected=selected';}?> ><?php _e('years','templatic'); ?></option>
			  </select>
	
			  <div class="description"><?php echo BILLING_PERIOD_NOTE; ?></div>
	 </div>	
	<div class="section change_user">
			<h4><?php echo BILLING_CYCLE_TITLE; ?></h4>
			  <input type="text" class="textfield" name="billing_cycle" id="billing_cycle" value="<?php echo $addpriceinfo[0]->billing_cycle; ?>">
			  <div class="description"><?php echo BILLING_CYCLE_NOTE; ?></div>
	 </div>		 
	</div><!-- #end -->
	<p style="background: #f4f4f4; padding:10px; margin-bottom:20px;"><b><?php echo FEATURE_HEAD_TITLE; ?></b></p>
	<p><?php echo FEATURE_HEAD_NOTE; ?></p><!-- End -->
	
     <div class="option option-select">
		<h3><?php _e('Status','templatic'); ?></h3>
		  <div class="section">
		  <div class="element">
			 <select name="is_featured" id="is_featured">
			  <option value="1"  <?php if($addpriceinfo[0]->is_featured ==1){ echo 'selected=selected';}?> ><?php _e('Active','templatic'); ?></option>
			  <option value="0" <?php if($addpriceinfo[0]->is_featured ==0){ echo 'selected=selected';}?> ><?php _e('Deactive','templatic'); ?></option>
			 
			  </select>
			</div>
		  <div class="description"><?php echo FEATURE_STATUS_NOTE; ?></div>
		</div>
	</div> <!-- #end -->
	
	<div class="option option-select"  >
    <h3><?php echo FEATURE_AMOUNT_TITLE;?></h3>
    <div class="section">
      <div class="element">
           <input type="text" name="feature_amount" id="feature_amount" value="<?php if($addpriceinfo[0]->feature_amount != "") { echo $addpriceinfo[0]->feature_amount; }else{ echo "0";}?>">
   		</div>
      <div class="description"><?php echo FEATURE_AMOUNT_NOTE;?></div>
    </div>
	</div> <!-- #end -->
	
	<div class="option option-select"  >
    <h3><?php echo FEATURE_CAT_TITLE;?></h3>
    <div class="section">
      <div class="element">
           <input type="text" name="feature_cat_amount" id="feature_cat_amount" value="<?php if($addpriceinfo[0]->feature_cat_amount != "") { echo $addpriceinfo[0]->feature_cat_amount; }else{ echo "0"; } ?>">
   		</div>
      <div class="description"><?php echo FEATURE_CAT_NOTE;?></div>
    </div>
	</div> <!-- #end -->
<input type="submit" name="submit" value="<?php _e('Save all changes','templatic');?>" onclick="return price_validation();" class="button-framework-imp right position_bottom" />
</form>
