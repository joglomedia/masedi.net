<table cellpadding="5" class="widefat post fixed" >
	<thead>
		<tr>
			<th align="left" width="120"><?php _e('Title','templatic'); ?></th>
			<th align="left"><?php _e('Price','templatic'); ?> (<?php echo fetch_currency(get_option('currency_symbol'),'currency_symbol');?>)</th>
			<th align="left"><?php _e('Billing period','templatic'); ?></th>
			<th align="left"><?php _e('Status','templatic'); ?></th>
			<th align="left"><?php _e('Featured?','templatic'); ?></th>
			<th align="left" width="70"><?php _e('Action','templatic'); ?></th>
        </tr>
<?php
	$pricesql = "select * from $price_db_table_name";
	$priceinfo = $wpdb->get_results($pricesql);
if($priceinfo) {
	foreach($priceinfo as $priceinfoObj) { ?>
		<tr>
			<td><?php echo $priceinfoObj->price_title;?></td>
			<td><strong><?php echo display_amount_with_currency($priceinfoObj->package_cost);    ?></strong></td>
			<td><?php echo $priceinfoObj->validity;
			$vper = $priceinfoObj->validity_per;
			if($vper == "D")
			{	_e(' Days','templatic');
			
			}else if($vper == "M"){ _e(' Months','templatic');
			}else if($vper == "Y"){ _e(' Years','templatic');
			}
			?></td>
			<td><?php if($priceinfoObj->status==1) _e("<span class='active' id='#dashboard_right_now' >Active</span>",'templatic'); else _e("<span class='deactive' id='#dashboard_right_now' >Deactive</span>",'templatic');?></td>
			<td><?php if($priceinfoObj->is_featured==1){ _e("Yes",'templatic'); }else{ _e("No",'templatic'); } ?></td>
			<td><a href="javascript:void(0);show_price_detail(<?php echo $priceinfoObj->pid; ?>);"><img border="0" title="Detail of price package" alt="Detail" src="<?php echo get_template_directory_uri(); ?>/images/details.png"></a>&nbsp;&nbsp;<a href="<?php echo site_url().'/wp-admin/admin.php?page=manage_settings&mod=price&price_id='.$priceinfoObj->pid.'#option_display_price';?>" title="<?php _e('Edit price package','templatic');?>"><img src="<?php echo get_template_directory_uri(); ?>/images/edit.png" alt="<?php _e('Edit price','templatic');?>" border="0" /></a> &nbsp;&nbsp;<a href="javascript:void(0);" title="<?php _e('Delete price package','templatic');?>" onclick="delete_pack(<?php echo $priceinfoObj->pid; ?>);"><img src="<?php echo get_template_directory_uri(); ?>/images/delete.png" alt="<?php _e('Delete price','templatic');?>" border="0" /></a></td>
        </tr>
		
		<tr id="price_<?php echo $priceinfoObj->pid; ?>" style="display:none;">
		<td colspan="6">
			<table width="100%" style="background-color:#eee;">
			  <tbody>
			<tr><td><?php echo PRICE_TITLE." :"; ?> <strong><?php echo $priceinfoObj->price_title; ?></strong></td>
				<td><?php echo PRICE_PKG." :"; ?> <strong><?php echo $priceinfoObj->package_cost;?></strong></td>
				<td><?php echo PRICE_STATUS." :"; ?><strong><?php if($priceinfoObj->status == '1') { echo "Active"; }else{ echo "Deactive"; } ?></strong></td></tr> 
			<tr><td colspan='2' width="200px"><?php echo PRICE_DESC." :"; ?><strong><?php echo $priceinfoObj->price_desc; ?></strong></td>
				<td><?php echo PRICE_VAL." :"; ?><strong><?php 
				$val = $priceinfoObj->validity;
				$per = $priceinfoObj->validity_per;
				if($per == "D"){
				echo $val." Days"; }else if($per == "M"){ 
				echo $val." Month";
				}else if($per == "Y"){ 
				echo $val." Year";
				} ?></strong></td>
				</tr> 
			<tr>
				<td colspan='2' width="200px"><?php echo PRICE_CAT." :"; ?><strong><?php
				if($priceinfoObj->price_post_cat != "")
				{
				
				$pcat = explode(',',$priceinfoObj->price_post_cat);
				$pc = count($pcat);
				$catque  ="";
				for($c =0 ; $c <= count($pcat); $c ++)
				{
					$catq = $wpdb->get_row("select * from $wpdb->terms,$wpdb->term_taxonomy where $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id and $wpdb->term_taxonomy.term_taxonomy_id = '".$pcat[$c]."'");
					
					if($catq->name != "" && $c != ($pc-1)){ $catque .= $catq->name." , "; }else{
							$catque .= $catq->name;
					}					
				}echo $catque;
				
				} ?></strong></td></tr>
			<tr>
				<td colspan="2"><?php echo REC_PAY." :"; ?><strong><?php if($priceinfoObj->is_recurring == "1"){ echo "Active"; }else{ echo "Deactive"; } ?></strong></td>
				<td><?php _e('Featured :','templatic');?>  <strong><?php if($priceinfoObj->is_featured == "1"){ echo "Yes"; }else{ echo "No"; } ?></strong></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
			</tbody>
			</table>
		</td>
		</tr>
    <?php
	}
}else{ ?>
	<td colspan="6">
	<?php echo NO_RECORD; ?>
	</td>
<?php } ?>
	</thead>
</table>