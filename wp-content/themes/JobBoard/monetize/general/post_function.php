<?php 
/* fetch categories options */
function display_wpcategories_options($taxonomy,$cid)
{ 
		if($taxonomy == "")
		{
			$taxonomy ="category";
		}
		global $wpdb;
		$table_prefix = $wpdb->prefix;
		$wpcat_id = NULL;
		if($taxonomy == '1')
		{
			$wpcategories = (array)$wpdb->get_results("
        SELECT * FROM {$table_prefix}terms, {$table_prefix}term_taxonomy
        WHERE {$table_prefix}terms.term_id = {$table_prefix}term_taxonomy.term_id
                AND ({$table_prefix}term_taxonomy.taxonomy ='".CUSTOM_CATEGORY_TYPE1."' OR {$table_prefix}term_taxonomy.taxonomy ='".CUSTOM_CATEGORY_TYPE2."') ORDER BY {$table_prefix}terms.name");
		}else{
		$wpcategories = (array)$wpdb->get_results("
        SELECT * FROM {$table_prefix}terms, {$table_prefix}term_taxonomy
        WHERE {$table_prefix}terms.term_id = {$table_prefix}term_taxonomy.term_id
                AND {$table_prefix}term_taxonomy.taxonomy ='".$taxonomy."' ORDER BY {$table_prefix}terms.name");
		}
		$wpcategories = array_values($wpcategories);
		$wpcat2 = NULL;

		 	foreach ($wpcategories as $wpcat)
    		{ 	if($wpcat->parent =='0' ) {?>
				<option value="<?php echo $wpcat->term_id; ?>" <?php if($wpcat->term_id == $cid) { echo 'selected="selected"'; } ?>><?php echo apply_filters('single_cat_title', stripslashes(str_replace('"', '', ucfirst($wpcat->name)." "))); ?></option>
			<?php }else{ ?>
				<option value="<?php echo $wpcat->term_id; ?>" <?php if($wpcat->term_id == $cid) { echo 'selected="selected"'; } ?>><?php echo apply_filters('single_cat_title', stripslashes(str_replace('"', '', " - ".ucfirst($wpcat->name)." "))); ?></option>
			<?php }
			}
}
/* end of function */

/* function to display dropdown of taxonomies term */
function get_wp_post_categores($taxonomy)
{ 
		global $wpdb;
		$table_prefix = $wpdb->prefix;
		$wpcategories = (array)$wpdb->get_results("
        SELECT * FROM {$table_prefix}terms, {$table_prefix}term_taxonomy
        WHERE {$table_prefix}terms.term_id = {$table_prefix}term_taxonomy.term_id
                AND {$table_prefix}term_taxonomy.taxonomy ='".$taxonomy."' AND {$table_prefix}term_taxonomy.parent = 0 ORDER BY {$table_prefix}terms.name");
		
		$wpcategories = array_values($wpcategories);

			echo "<select name='post_category'  class='textfield sctof' id='post_category' echo='0'>";
			echo "<option value='0' selected='selected'>Select category</option>";
		 	foreach ($wpcategories as $wpcat)
    		{
					echo "<option value='".$wpcat->term_id."'>".apply_filters('single_cat_title', stripslashes(str_replace('"', '', ucfirst($wpcat->name)." ")))."</option>";
					 $wpsubcategories = (array)$wpdb->get_results("
					SELECT * FROM {$table_prefix}terms, {$table_prefix}term_taxonomy
					WHERE {$table_prefix}terms.term_id = {$table_prefix}term_taxonomy.term_id
							AND {$table_prefix}term_taxonomy.taxonomy = '".$taxonomy."' AND {$table_prefix}term_taxonomy.parent = '".$wpcat->term_id."'");
					if(mysql_affected_rows() >0)
					{
						foreach ($wpsubcategories as $wpscat)
						{
							echo "<option value='".$wpscat->term_id."'>".apply_filters('single_cat_title', "-".stripslashes(str_replace('"', '', ucfirst($wpscat->name)." ")))."</option>";
						}
					}
			}
			echo "</select>"; 
}
/* end of function  */

/* Function to fetch category name BOF */
function get_categoty_name($cat_id)
{

	global $wpdb;
	$cat_name ="";
		$table_prefix = $wpdb->prefix;
		$wpcat_id = NULL; 
	$pos = explode(',',$cat_id);
	$cat_id1 = implode('&',$pos);
	$pos_of = strpos($cat_id1,'&');
	if($pos_of == false){
		$wpcategories = $wpdb->get_row("
        SELECT * FROM {$table_prefix}terms
        WHERE {$table_prefix}terms.term_id = '".$cat_id."'");
		_e($wpcategories->name,'templatic');
	}else{
		$cid = explode('&',$cat_id1);
		$total_cid = count($cid);
		for($c=0;$c<=$total_cid;$c++){
			$wpcategories = $wpdb->get_row("
        SELECT * FROM {$table_prefix}terms
        WHERE {$table_prefix}terms.term_id = '".$cid[$c]."'");
			if($wpcategories->name !=""){
			$cat_name .= $wpcategories->name.", "; }
		}
			echo $cat_name;
	}
	
	   
}
/* Function to fetch category name EOF */

function display_custom_post_field($custom_metaboxes,$session_variable,$geo_latitude='',$geo_longitude='',$geo_address='',$post_type){
	foreach($custom_metaboxes as $key=>$val) {
		$name = $val['name'];
		$site_title = $val['site_title'];
		$type = $val['type'];
		$htmlvar_name = $val['htmlvar_name'];
		$admin_desc = $val['desc'];
		$option_values = $val['option_values'];
		$default_value = $val['default'];
		$style_class = $val['style_class'];
		$extra_parameter = $val['extra_parameter'];
		/* Is required CHECK BOF */
		$is_required = '';
		$input_type = '';
		if($val['is_require'] == '1'){
			$is_required = '<span class="required">*</span>';
			$is_required_msg = '<span id="'.$name.'_error" class="message_error2"></span>';
		} else {
			$is_required = '';
			$is_required_msg = '';
		}
		/* Is required CHECK EOF */
		if($_REQUEST['pid'])
		{
			$post_info = get_post_info($_REQUEST['pid']);
			if($name == 'position_title' || $name == 'resume_title') {
				$value = $post_info['post_title'];
			}else {
				$value = get_post_meta($_REQUEST['pid'], $name,true);
			}
			
		}
		if($_SESSION[$session_variable] && $_REQUEST['backandedit'])
		{
			$value = $_SESSION[$session_variable][$name];
		}
	?>
	<div class="form_row clearfix">
	   <?php if($type=='text'){?>
	   <label><?php echo $site_title.$is_required; ?></label>
	   <?php if($name == 'geo_latitude' || $name == 'geo_longitude') {
			$extra_script = 'onblur="changeMap();"';
			
		} else {
			$extra_script = '';
			
		}?>
		 <input name="<?php echo $name;?>" id="<?php echo $name;?>" value="<?php echo $value;?>" type="text" class="textfield <?php echo $style_class;?>" <?php echo $extra_parameter;?> <?php echo $extra_script;?> PLACEHOLDER="<?php echo  $val['default']; ?>"/>
		<?php
		}elseif($type=='date'){
		?>     
		<label><?php echo $site_title.$is_required; ?></label>
		<input type="text" name="<?php echo $name;?>" id="<?php echo $name;?>" class="textfield <?php echo $style_class;?>" value="<?php echo esc_attr(stripslashes($value)); ?>" size="25" <?php echo 	$extra_parameter;?> />
		&nbsp;
        <?php if($post_type == CUSTOM_POST_TYPE2): ?>
        	 <img src="<?php echo bloginfo('template_directory');?>/images/cal.gif" alt="Calendar" onclick="displayCalendar(document.resumeform.<?php echo $name;?>,'yyyy-mm-dd',this)" style="cursor: pointer; margin-left:5px;" />
		<?php else: ?>
	        <img src="<?php echo bloginfo('template_directory');?>/images/cal.gif" alt="Calendar" onclick="displayCalendar(document.jobform.<?php echo $name;?>,'yyyy-mm-dd',this)" style="cursor: pointer; margin-left:5px;" />
		<?php endif; ?>
		<?php
		}
		elseif($type=='multicheckbox')
		{ ?>
		 <label><?php echo $site_title.$is_required; ?></label>
        <?php if($htmlvar_name == 'category'): ?> 
             <div class="category_label"><?php require_once (TT_MODULES_FOLDER_PATH.'job/job_category.php');?></div>
            <span class="message_note msgcat"><?php echo CATEGORY_MSG;?></span>
            <span id="category_span" class="message_error2"></span>
		<?php endif; ?>        
        <?php if($htmlvar_name == 'resume_category'): ?> 
            <div class="category_label"><?php require_once (TT_MODULES_FOLDER_PATH.'resume/resume_category.php');?></div>
           	<span class="message_note msgcat"><?php echo CATEGORY_MSG;?></span>
            <span id="category_span" class="message_error2"></span>
		<?php endif; ?>        
        
		<?php
			$options = $val['option_values'];
			if($options)
			{  $chkcounter = 0;
				echo '<div class="form_cat_right">';
				$option_values_arr = explode(',',$options);
				for($i=0;$i<count($option_values_arr);$i++)
				{
					$chkcounter++;
					$seled='';
					$default_value = $value;
					if($default_value !=''){
					if(in_array($option_values_arr[$i],$default_value)){ 
					$seled='checked="checked"';} }	
										
					echo '
					<div class="form_cat">
						<label>
							<input name="'.$key.'[]"  id="'.$key.'_'.$chkcounter.'" type="checkbox" value="'.$option_values_arr[$i].'" '.$seled.'  '.$extra_parameter.' /> '.$option_values_arr[$i].'
						</label>
					</div>';							
				}
				echo '</div>';
			}
		}
		
		elseif($type=='texteditor'){	?>
		<label><?php echo $site_title.$is_required; ?></label>
		<textarea name="<?php echo $name;?>" id="<?php echo $name;?>" PLACEHOLDER="<?php echo  $val['default']; ?>" class="mce <?php if($style_class != '') { echo $style_class;}?>" <?php echo $extra_parameter;?> ><?php if($value != '') { echo $value; }else{ echo  $val['default']; } ?></textarea>
		<?php
		}elseif($type=='textarea'){ 
		?>
		<label><?php echo $site_title.$is_required; ?></label>
		<textarea name="<?php echo $name;?>" id="<?php echo $name;?>" class="<?php if($style_class != '') { echo $style_class;}?> textarea" <?php echo $extra_parameter;?>><?php echo $value;?></textarea>       
		<?php
		}elseif($type=='radio'){
		?>
        <?php if($name != 'position_filled' || $_REQUEST['pid']): ?>
		 <label class="r_lbl"><?php echo $site_title.$is_required; ?></label>
		<?php
			$options = $val['option_values'];
			if($options)
			{  $chkcounter = 0;
				echo '<div class="form_cat_right">';
				$option_values_arr = explode(',',$options);
				for($i=0;$i<count($option_values_arr);$i++)
				{
					$chkcounter++;
					$seled='';
					if($default_value == $option_values_arr[$i]){ $seled='checked="checked"';}
					if (trim($value) == trim($option_values_arr[$i])){ $seled='checked="checked"';}
					echo '<div class="form_cat">
						<label class="r_lbl">
							<input name="'.$key.'"  id="'.$key.'_'.$chkcounter.'" type="radio" value="'.$option_values_arr[$i].'" '.$seled.'  '.$extra_parameter.' /> '.$option_values_arr[$i].'
						</label>
					</div>';
				}
				echo '</div>';
			}
		 endif;	
		}elseif($type=='select'){
		?>
		 <label><?php echo $site_title.$is_required; ?></label>
  		<?php if($htmlvar_name == 'job_location'): ?>
           	<select name="job_location" id="job_location" class="jobtextfield mini">
				<option value=""><?php echo SELECT_LOCATION_TEXT;?></option>
				<?php echo get_location_dl($value);?>
			</select>
			<span class="message_error2" id="job_location_span"></span>
  		<?php elseif($htmlvar_name == 'resume_location'): ?>
           	<select name="resume_location" id="resume_location" class="jobtextfield mini">
				<option value=""><?php echo SELECT_LOCATION_TEXT;?></option>
				<?php echo get_location_resume($value);?>
			</select>
			<span class="message_error2" id="resume_location_span"></span>
	   <?php else: ?> 
            <select name="<?php echo $name;?>" id="<?php echo $name;?>" class="textfield textfield_x <?php echo $style_class;?>" <?php echo $extra_parameter;?>>
            <option value="">Please Select</option>
            <?php if($option_values){
            $option_values_arr = explode(',',$option_values);
            for($i=0;$i<count($option_values_arr);$i++)
            {
            ?>
            <option value="<?php echo $option_values_arr[$i]; ?>" <?php if($value==$option_values_arr[$i]){ echo 'selected="selected"';} else if($default_value==$option_values_arr[$i]){ echo 'selected="selected"';}?>><?php echo $option_values_arr[$i]; ?></option>
            <?php	
            }
            ?>
            <?php }?>
           
            </select>
		<?php endif; ?>
		<?php
		}else if($type=='upload'){ ?>
		 <label><?php echo $site_title.$is_required; ?></label>
		 <input type="file" value="<?php echo $value; ?>" name="<?php echo $name; ?>" class="apply_resume" />
         <?php if($htmlvar_name == 'apply_resume'): ?>
         	<?php if($_REQUEST['pid']): ?>
         		<p class="resumback"><a href="<?php echo get_post_meta($_REQUEST['pid'],'attachment', $single = true); ?>"><?php echo basename(get_post_meta($_REQUEST['pid'],'attachment', $single = true)); ?></a></p>
            <?php elseif($_SESSION['file_info']): ?>
	            <p class="resumback"><a href="<?php echo $_SESSION['file_info']; ?>"><?php echo basename($_SESSION['file_info']); ?></a></p>
            <?php endif; ?>
         <?php endif; ?>
         <?php if($htmlvar_name == 'company_logo'): ?>
         	<?php if($_REQUEST['pid']): ?>
         		<p class="resumback"><a href="<?php echo get_post_meta($_REQUEST['pid'],'company_logo', $single = true); ?>"><?php echo basename(get_post_meta($_REQUEST['pid'],'company_logo', $single = true)); ?></a></p>
            <?php elseif($_SESSION['file_info']): ?>    
	            <p class="resumback"><img src="<?php echo $_SESSION['file_info']; ?>" title="<?php echo basename($_SESSION['file_info']); ?>" alt="<?php echo basename($_SESSION['file_info']); ?>" height="100" width="100" /></p>
            <?php endif; ?>    
         <?php endif; ?>

		<?php } 
		if($type != 'image_uploader' ) {?>
           <?php if($admin_desc != ''): ?>
	           <?php if($name != 'position_filled' || $_REQUEST['pid']): ?>
				 <span class="message_note msgcat"><?php echo $admin_desc;?></span>
               <?php endif; ?>  
           <?php endif; ?>  
		   <?php if($type!='geo_map') { ?>
			   <?php echo $is_required_msg;?>
		 <?php }} ?>
        <?php if($htmlvar_name == 'company_logo'): ?>
	        <h4 class="sub_head"><?php _e('Job Information');?></h4>
        <?php endif; ?>    
	  <?php if($type=='geo_map') { ?>
		 <?php include_once(TEMPLATEPATH . "/library/map/location_add_map.php"); ?>
		<?php if(GET_MAP_MSG):?>
			 <span class="message_note"><?php echo GET_MAP_MSG;?></span>
		<?php endif; ?>
        <?php } ?>
     </div>    
    <?php
	}
}
function search_custom_post_field($custom_metaboxes){
		foreach($custom_metaboxes as $key=>$val) {
		$name = $val['htmlvar_name'];
		$htmlvar_name = $val['htmlvar_name'];
		$site_title = $val['site_title'];
		$type = $val['type'];
		$admin_desc = $val['desc'];
		$option_values = $val['option_values'];
		$default_value = $val['default'];
		$style_class = $val['style_class'];
		$extra_parameter = $val['extra_parameter'];
		if($_POST[$name]){
			$value = $_POST[$name];
		} ?>
	
	   <?php if($type=='text'){?>
	   <div class="jobform"> 
		<div class="jobform_l"><?php echo $site_title; ?></div>
		<div class="jobform_r"><input name="<?php echo $name;?>"  value="<?php echo $value;?>" type="text" class="jobtextfield <?php echo $style_class;?>" <?php echo $extra_parameter;?> /></div>
	   </div>
	   <?php 
		}elseif($type=='geo_map'){
		?>     
		<div class="jobform"> 
		<div class="jobform_l"><?php echo $site_title; ?></div>      
		<div class="jobform_r"><input name="<?php echo $name;?>"  value="<?php echo $value;?>" type="text" class="jobtextfield <?php echo $style_class;?>" <?php echo $extra_parameter;?> /></div>
		</div>
		<?php
		}elseif($type=='checkbox'){
		?>  
		<div class="jobform"> 
		<div class="jobform_l"><?php echo $site_title; ?></div>   
		<div class="jobform_r"><input name="<?php echo $name;?>"  <?php if($value){ echo 'checked="checked"';}?>  value="<?php echo $value;?>" type="checkbox" <?php echo 	$extra_parameter;?> /> <?php echo $site_title; ?></div>
		</div>
		<?php
		}elseif($type=='radio'){
		?>     
		<div class="jobform"> 
		<div class="jobform_l"><?php echo $site_title; ?></div>
		<div class="jobform_r">
		<?php
			$options = $val['option_values'];
			if($options)
			{  $chkcounter = 0;
				
				$option_values_arr = explode(',',$options);
				for($i=0;$i<count($option_values_arr);$i++)
				{
					$chkcounter++;
					$seled='';
					if($default_value == $option_values_arr[$i]){ $seled='checked="checked"';}							
					if (trim($value) == trim($option_values_arr[$i])){ $seled='checked="checked"';}	
					echo '
					<div>
						<label>
							<input name="'.$key.'"   type="radio" value="'.$option_values_arr[$i].'" '.$seled.'  '.$extra_parameter.' /> '.$option_values_arr[$i].'
						</label>
					</div>';							
				}
				
			}
		?></div>
		</div>
		<?php
		}elseif($type=='date'){
		?>     
		<div class="jobform"> 
		<div class="jobform_l"><?php echo $site_title; ?></div>
		<div class="jobform_r"><input type="text" name="<?php echo $name;?>" class="jobtextfield <?php echo $style_class;?>" value="<?php echo esc_attr(stripslashes($value)); ?>" size="25" <?php echo 	$extra_parameter;?> />
		&nbsp;<img src="<?php echo bloginfo('template_directory');?>/images/cal.gif" alt="Calendar" onclick="displayCalendar(document.searchform.<?php echo $name;?>,'yyyy-mm-dd',this)" style="cursor: pointer; margin-left:5px;" /></div>
		</div>
		<?php
		}
		elseif($type=='multicheckbox')	{ ?>
		<div class="jobform"> 
		<div class="jobform_l"><?php echo $site_title; ?></div>
		<div class="jobform_r">
		<?php
			$options = $val['option_values'];
			if($options)
			{  $chkcounter = 0;
				
				$option_values_arr = explode(',',$options);
				for($i=0;$i<count($option_values_arr);$i++)
				{
					$chkcounter++;
					$seled='';
					if($default_value == $option_values_arr[$i]){ $seled='checked="checked"';}							
					echo '
					<div >
						<label>
							<input name="'.$key.'[]"   type="checkbox" value="'.$option_values_arr[$i].'" '.$seled.'  '.$extra_parameter.' /> '.$option_values_arr[$i].'
						</label>
					</div>';							
				}
				
			} ?>
		</div>
		</div>
		<?php }elseif($type=='textarea' || $type=='texteditor'){ ?>
		<div class="jobform"> 
		<div class="jobform_l"><?php echo $site_title ?></div>
		<div class="jobform_r"><textarea name="<?php echo $name;?>"  class="<?php if($style_class != '') { echo $style_class;}?> jobtextfield" <?php echo $extra_parameter;?>><?php echo $value;?></textarea> </div>
		</div>
		<?php
		}elseif($type=='select'){
	   
		?>
		<div class="jobform"> 
		<div class="jobform_l"><?php echo $site_title; ?></div>
		<div class="jobform_r">
		<?php if($htmlvar_name == 'job_location'): ?>
           	<select name="job_location" id="job_location" class="jobtextfield mini">
				<option value=""><?php echo SELECT_LOCATION_TEXT;?></option>
				<?php echo get_location_dl($value);?>
			</select>
			<span class="message_error2" id="job_location_span"></span>
  		<?php elseif($htmlvar_name == 'resume_location'): ?>
           	<select name="resume_location" id="resume_location" class="jobtextfield mini">
				<option value=""><?php echo SELECT_LOCATION_TEXT;?></option>
				<?php echo get_location_resume($value);?>
			</select>
			<span class="message_error2" id="resume_location_span"></span>
	   <?php else: ?> 
            <select name="<?php echo $name;?>" id="<?php echo $name;?>" class="jobtextfield textfield_x <?php echo $style_class;?>" <?php echo $extra_parameter;?>>
            <option value="">Please Select</option>
            <?php if($option_values){
            $option_values_arr = explode(',',$option_values);
            for($i=0;$i<count($option_values_arr);$i++)
            {
            ?>
            <option value="<?php echo $option_values_arr[$i]; ?>" <?php if($value==$option_values_arr[$i]){ echo 'selected="selected"';} else if($default_value==$option_values_arr[$i]){ echo 'selected="selected"';}?>><?php echo $option_values_arr[$i]; ?></option>
            <?php
            }
            ?>
            <?php }?>
           
            </select>
			</div>
            </div>
		<?php endif; ?>
		
		<?php
		}

	}
}
function get_price_info($title='',$catid = '',$ptype)
{
	global $price_db_table_name,$wpdb;
	$pricesql = "select * from $price_db_table_name where status=1" ;
	$priceinfo = $wpdb->get_results($pricesql);
	if($priceinfo)
	{
		$counter=1;
		foreach($priceinfo as $priceinfoObj)
		{	
			$pricecat= stristr($priceinfoObj->price_post_cat,$catid1);
	
		?>
         <div class="package">
		 <label><input type="radio" value="<?php echo $priceinfoObj->pid;?>" <?php if($title==$priceinfoObj->pid){ echo 'checked="checked"';}?> name="price_select" id="price_select<?php echo $counter ?>" onClick="show_featuredprice(this.value);"/>
		 <h3><?php _e($priceinfoObj->price_title,'templatic');?></h3>
		 <p><?php _e($priceinfoObj->price_desc,'templatic');?></p>
		 <p class="cost"><span><strong><?php _e('Cost :','templatic'); ?></strong> <?php _e(display_amount_with_currency($priceinfoObj->package_cost),'templatic'); ?></span>&nbsp;&nbsp;&nbsp;<span><strong><?php _e('Validity :','templatic'); ?></strong> <?php _e($priceinfoObj->validity,'templatic'); if($priceinfoObj->validity_per == 'D'){ _e(' Days','templatic'); }else if($priceinfoObj->validity_per == 'M'){ _e(' Months','templatic'); }else{   _e(' Years','templatic'); }?><?php if($priceinfoObj->billing_cycle != "") { ?></span>  <span><?php _e('Billing cycle :','templatic'); ?> <?php _e($priceinfoObj->billing_cycle,'templatic'); if($priceinfoObj->billing_per == 'D'){ _e(' Days','templatic'); }else if($priceinfoObj->billing_per == 'M'){ _e('Months','templatic'); }else{   _e('Years','templatic'); } } ?></span></p> </label>
		 </div>
        <?php $counter++;
		}
	}
}

function templ_get_usermeta($types='registration')
{ 
	global $wpdb,$custom_usermeta_db_table_name;
	$custom_usermeta_db_table_name = $wpdb->prefix . "templatic_custom_usermeta";
	$user_meta_info = $wpdb->get_results("select * from $custom_usermeta_db_table_name where is_active=1 and post_type=\"$types\" order by sort_order asc,admin_title asc");
	$return_arr = array();
	if($user_meta_info){
		foreach($user_meta_info as $post_meta_info_obj){	
			if($post_meta_info_obj->ctype){ 
				//$options = explode(',',$post_meta_info_obj->option_values);
				$options = '';
			}
			$custom_fields = array(
					"name"		=> $post_meta_info_obj->htmlvar_name,
					"label" 	=> $post_meta_info_obj->clabels,
					"site_title" 	=> $post_meta_info_obj->site_title,
					"default" 	=> $post_meta_info_obj->default_value,
					"type" 		=> $post_meta_info_obj->ctype,
					"desc"      => $post_meta_info_obj->admin_desc,
					"option_values" => $post_meta_info_obj->option_values,
					"is_require"  => $post_meta_info_obj->is_require,
					"on_registration"  => $post_meta_info_obj->show_on_listing,
					"on_profile"  => $post_meta_info_obj->show_on_detail,
					"extrafield1"  => $post_meta_info_obj->extrafield1,
					"extrafield2"  => $post_meta_info_obj->extrafield2,
					);
			if($options)
			{
				$custom_fields["options"] = $options;
			}
			$return_arr[$post_meta_info_obj->htmlvar_name] = $custom_fields;
		}
	}
	return $return_arr;
}

?>