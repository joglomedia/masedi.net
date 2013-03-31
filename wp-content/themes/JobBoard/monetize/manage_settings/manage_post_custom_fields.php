<?php
//Custom Settings
if(!function_exists('templ_get_post_custom_fields_array')){
function templ_get_post_custom_fields_array()
{
	$pt_metaboxes = array();
	return apply_filters('templ_admin_post_custom_fields_filter',$pt_metaboxes);
}
}
global $post;

if(!function_exists('ptthemes_job_meta_box_content')){
function ptthemes_job_meta_box_content($post, $metabox ) {
    global $post,$wpdb;
	$pt_metaboxes = get_post_custom_fields_templ($metabox['args']['post_types']);
    $output = '';
    if($pt_metaboxes){
	if(get_post_meta($post->ID,'remote_ip',true)  != ""){
		$remote_ip = get_post_meta($post->ID,'remote_ip',true);
	} else {
		$remote_ip= getenv("REMOTE_ADDR");
	}
	if(get_post_meta($post->ID,'ip_status',true)  != ""){
		$ip_status = get_post_meta($post->ID,'ip_status',true);
	} else {
		$ip_status= '0';
	}
	$geo_latitude= get_post_meta($post->ID,'geo_latitude',true);
	$geo_longitude= get_post_meta($post->ID,'geo_longitude',true);
	$zooming_factor= get_post_meta($post->ID,'zooming_factor',true);
   echo '<div class="pt_metaboxes_table">'."\n";
   echo '<script>var rootfolderpath = "'.get_template_directory_uri().'/images/";</script>'."\n";
   echo '<script type="text/javascript" src="'.get_template_directory_uri().'/library/js/dhtmlgoodies_calendar.js"></script>'."\n";
   echo ' <link href="'.get_template_directory_uri().'/library/css/dhtmlgoodies_calendar.css" rel="stylesheet" type="text/css" />'."\n";
   echo '<input type="hidden" name="templatic_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />
   <input type="hidden" name="remote_ip" value="'.$remote_ip.'" />
   <input type="hidden" name="zooming_factor" id="zooming_factor" value="'.$zooming_factor.'" />
   <input type="hidden" name="ip_status" value="'.$ip_status.'" />';
   foreach ($pt_metaboxes as $pt_id => $pt_metabox) {
    if($pt_metabox['type'] == 'text' OR $pt_metabox['type'] == 'select' OR $pt_metabox['type'] == 'radio' OR $pt_metabox['type'] == 'checkbox' OR $pt_metabox['type'] == 'textarea' OR $pt_metabox['type'] == 'upload' OR $pt_metabox['type'] == 'date' OR $pt_metabox['type'] == 'multicheckbox' OR $pt_metabox['type'] == 'texteditor')
            $pt_metaboxvalue = get_post_meta($post->ID,$pt_metabox["name"],true);
            if ($pt_metaboxvalue == "" || !isset($pt_metaboxvalue)) {
                $pt_metaboxvalue = $pt_metabox['default'];
            }
			
            if($pt_metabox['type'] == 'text'){
				if($pt_metabox["name"] == 'geo_latitude' || $pt_metabox["name"] == 'geo_longitude')
				  {
					 $extra_script = 'onblur="changeMap();"';
				  } 
				else 
				  {
					$extra_script = '';
				  }
                echo  "\t".'<div class="row" style="float:none;margin-left:0px;">';
                echo  "\t\t".'<p><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></p>'."\n";
                echo  "\t\t".'<p><input size="100" class="pt_input_text" type="'.$pt_metabox['type'].'" name="'.$pt_metabox['name'].'"  value="'.$pt_metaboxvalue.'" id="'.$pt_id.'" '.$extra_script.'/></p>'."\n";
                echo  "\t\t".'<p class="note">'.$pt_metabox['desc'].'</p>'."\n";
                echo  "\t".'</div>'."\n"; 
				
                              
            }
            
            elseif ($pt_metabox['type'] == 'textarea'){
            			
				echo  "\t".'<div class="row">';
                echo  "\t\t".'<p><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></p>'."\n";
                echo  "\t\t".'<p><textarea rows="5" cols="98" class="pt_input_textarea" name="'.$pt_metabox["name"].'" id="'.$pt_id.'">' . $pt_metaboxvalue . '</textarea></p>'."\n";
                echo  "\t\t".'<p class="note">'.$pt_metabox['desc'].'</p>'."\n";
                echo  "\t".'</div>'."\n";
                              
            }
			
			elseif ($pt_metabox['type'] == 'texteditor'){
            			
				echo  "\t".'<div class="row">';
                echo  "\t\t".'<p><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></p>'."\n";
                echo  "\t\t".'<p><textarea rows="5" cols="98" class="pt_input_textarea" name="'.$pt_metabox["name"].'" id="'.$pt_id.'">' . $pt_metaboxvalue . '</textarea></p>'."\n";
                echo  "\t\t".'<p class="note">'.$pt_metabox['desc'].'</p>'."\n";
                echo  "\t".'</div>'."\n";
                              
            }

            elseif ($pt_metabox['type'] == 'select'){
                echo  "\t".'<div class="row">';
                echo  "\t\t".'<p><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></p>'."\n";
  				if($pt_metabox['htmlvar_name'] == 'job_location'):
		           	echo '<select name="job_location" id="job_location" class="select_s">';
					echo '<option value="">'.SELECT_LOCATION_TEXT.'</option>';
				    echo get_location_dl($pt_metaboxvalue);
					echo '</select>';
					echo '<span class="message_error2" id="job_location_span"></span>';
 				elseif($pt_metabox['htmlvar_name'] == 'resume_location'):
		           	echo '<select name="resume_location" id="resume_location" class="select_s">';
					echo '<option value="">'.SELECT_LOCATION_TEXT.'</option>';
				    echo get_location_resume($pt_metaboxvalue);
					echo '</select>';
					echo '<span class="message_error2" id="job_location_span"></span>';
				else:
					echo  "\t\t".'<p><select class="pt_input_select" id="'.$pt_id.'" name="'. $pt_metabox["name"] .'"></p>'."\n";
					echo  '<option>Select a '.$pt_metabox['label'].'</option>';
                	$array = $pt_metabox['options'];
					if($array){
						foreach ( $array as $id => $option ) {
							$selected = '';
							if($pt_metabox['default'] == $option){$selected = 'selected="selected"';} 
							if($pt_metaboxvalue == $option){$selected = 'selected="selected"';}
							echo  '<option value="'. $option .'" '. $selected .'>' . $option .'</option>';
						}
					}
					echo  '</select><p class="note">'.$pt_metabox['desc'].'</p>'."\n";
				endif;
                echo  "\t".'</div>'."\n";
            }
			elseif ($pt_metabox['type'] == 'multicheckbox'){
				
					echo  "\t".'<div class="row">';
					echo  "\t\t".'<p><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></p>'."\n";
					 $array = $pt_metabox['options'];
					if($array){
						foreach ( $array as $id => $option ) {
						   
						    $checked='';
							if(is_array($pt_metaboxvalue)){
							$fval_arr = $pt_metaboxvalue;
							if(in_array($option,$fval_arr)){ $checked='checked=checked';}
							}elseif($pt_metaboxvalue !='' && !is_array($pt_metaboxvalue)){ 
							$fval_arr[] = array($pt_metaboxvalue,'');
							
							if(in_array($option,$fval_arr[0])){ $checked='checked=checked';}
							}else{
							$fval_arr = $pt_metabox['default'];
							if(is_array($fval_arr)){
							if(in_array($option,$fval_arr)){$checked = 'checked=checked';}  }
							}
							echo  "\t\t".'<div class="multicheckbox"><input type="checkbox" '.$checked.' class="pt_input_radio" value="'.$option.'" name="'. $pt_metabox["name"] .'[]" />  ' . $option .'</div>'."\n";
						}
					}
					echo  '<p class="note">'.$pt_metabox['desc'].'</p>'."\n";
					echo  "\t".'</div>'."\n";
			}
			 elseif ($pt_metabox['type'] == 'date'){
            			
				echo  "\t".'<div class="row">';
                echo  "\t\t".'<p><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></p>'."\n";
                echo  "\t\t".'<p><input size="40" class="pt_input_text" type="text" value="'.$pt_metaboxvalue.'" name="'.$pt_metabox["name"].'" /><img src="'.get_template_directory_uri().'/images/cal.gif" class="calendar_img" alt="Calendar"  onclick="displayCalendar(document.post.'.$pt_metabox["name"].',\'yyyy-mm-dd\',this)" style="cursor: pointer;" align="absmiddle" border="0" /></p>'."\n";
                echo  "\t\t".'<p class="note">'.$pt_metabox['desc'].'</p>'."\n";
                echo  "\t".'</div>'."\n";
                              
            }
			elseif ($pt_metabox['type'] == 'radio'){
					echo  "\t".'<div class="row">';
					echo  "\t\t".'<p><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></p>'."\n";
					 $array = $pt_metabox['options'];
					if($array){
						foreach ( $array as $id => $option ) {
						   $checked='';
						   if($pt_metabox['default'] == $option){$checked = 'checked="checked"';} 
							if(trim($pt_metaboxvalue) == trim($option)){$checked = 'checked="checked"';}
							echo  "\t\t".'<div class="input_radio"><input type="radio" '.$checked.' class="pt_input_radio" value="'.$option.'" name="'. $pt_metabox["name"] .'" />  ' . $option .'</div>'."\n";
						}
					}
					echo  '<p class="note">'.$pt_metabox['desc'].'</p>'."\n";
					echo  "\t".'</div>'."\n";
			}
            elseif ($pt_metabox['type'] == 'checkbox'){
                if($pt_metaboxvalue == '1') { $checked = 'checked="checked"';} else {$checked='';}
				echo  "\t".'<div class="row">';
                echo  "\t\t".'<p><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></p>'."\n";
                echo  "\t\t".'<p class="value"><input type="checkbox" '.$checked.' class="pt_input_checkbox"  id="'.$pt_id.'" value="1" name="'. $pt_metabox["name"] .'" />'."\n";
                echo  "\t\t".''.$pt_metabox['desc'].'</p>'."\n";
                echo  "\t".'</div>'."\n";
            }
			 elseif ($pt_metabox['type'] == 'upload'){
               $pt_metaboxvalue = get_post_meta($post->ID,$pt_metabox["name"],true);
			   if($pt_metaboxvalue!=""):
			   		$up_class="upload ".$pt_metaboxvalue;
					echo  "\t\t".'<div class="row option option-upload">';
					echo  "\t\t".'<div class="section">';
					echo  "\t\t".'<div class="element">';
					echo  "\t\t".'<p><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></p>'."\n";
					echo  '<input type="file" class="'.$up_class.'"  id="'.$pt_metabox["name"] .'" name="'.$pt_metabox["name"] .'" value="'.$pt_metaboxvalue.'"/>';
					echo  '</div></div></div>'."\n";
					echo '<img src='.get_post_meta($post->ID,"company_logo", $single = true).' border="0" class="company_logo" height="140" width="140" />';
			   else:
			    $up_class="upload has-file";
				echo  "\t\t".'<div class="row option option-upload">';
				echo  "\t\t".'<div class="section">';
      			echo  "\t\t".'<div class="element">';
                echo  "\t\t".'<p><label for="'.$pt_id.'">'.$pt_metabox['label'].'</label></p>'."\n";
                echo  '<input type="file" class="'.$up_class.'"  id="'.$pt_metabox["name"] .'" name="'.$pt_metabox["name"] .'" value="'.$pt_metaboxvalue.'"/>';
				echo  '<div class="screenshot" id="ptthemes_'. $pt_metabox["name"] .'_image">';
				 if ( isset( $pt_metaboxvalue ) && $pt_metaboxvalue != '' ) 
				     { 
						$remove = '<a href="javascript:(void);" class="remove">Remove</a>';
						$image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $pt_metaboxvalue );
						if ( $image ) 
						{
							echo '<img src="'.$pt_metaboxvalue.'" alt="" />'.$remove.'';
						} 
						else 
						{
							$parts = explode( "/", $pt_metaboxvalue );
							for( $i = 0; $i < sizeof($parts); ++$i ) 
							{
								$title = $parts[$i];
							}
							echo '<div class="no_image"><a href="'.$pt_metaboxvalue.'">'.$title.'</a>'.$remove.'</div>';
						}
					 }
					echo  '<div class="description">'.$pt_metabox['desc'].' </div>';
					echo  '</div></div></div></div>'."\n";
			  endif;		
            }else {
			if($pt_metabox['type'] == 'geo_map'){
				echo  "\t\t".'<div class="row">';
				include_once(TEMPLATEPATH . "/library/map/location_add_map.php");
				echo  "\t\t".'<p class="note">'.GET_MAP_MSG.'</p>'."\n";
				 echo  "\t".'</div>'."\n";
            }
			}
			
        }
		
	if(get_post_meta($post->ID,'featured_type',true) == "h"){ $checked = "checked=checked"; }
		elseif(get_post_meta($post->ID,'featured_type',true) == "c"){ $checked1 = "checked=checked"; }
		elseif(get_post_meta($post->ID,'featured_type',true) == "both"){ $checked2 = "checked=checked"; }
		elseif(get_post_meta($post->ID,'featured_type',true) == "none"){ $checked3 = "checked=checked"; }
	else { $checked = ""; }
	if($metabox['args']['post_types'] == 'job'):
		echo "\t".'<div class="row">';
		echo  "\t".'<p><label for="map_view">'._e('Select feature listing for this job','templatic').'</label></p>';
		echo  "\t\t".'<p><input size="100" type="radio" '.$checked.' value="h" name="featured_type"/>&nbsp; Featured for home page</p>'."\n";
		echo  "\t\t".'<p><input size="100" type="radio"   '.$checked1.' value="c" name="featured_type"/>&nbsp; Featured for category page</p>'."\n";
		echo  "\t\t".'<p><input size="100" type="radio"   '.$checked2.' value="both" name="featured_type"/>&nbsp; Both</p>'."\n";
		echo  "\t\t".'<p><input size="100" type="radio"  '.$checked3.' value="none" name="featured_type" />&nbsp; None of above</p>'."\n";
		echo  "\t".'</div>'."\n";
		echo '</div>'."\n\n";
		
		echo  "\t".'<div class="row" style="float:none;margin-left:0px;">';
		echo  "\t\t".'<p><label for="alive_days">'._e('Total Alive days','templatic') .'</label></p>'."\n";
		echo  "\t\t".'<p><input size="100" class="pt_input_text" type="text" name="alive_days"  value="'.get_post_meta($post->ID,'alive_days',true).'" id="alive_days"/></p>'."\n";
		echo  "\t\t".'<p class="note">Enter alive days for this job.</p>'."\n";
		echo  "\t".'</div>'."\n\n";
	endif;	
    }
}
}

if(!function_exists('ptthemes_job_metabox_insert')){
function ptthemes_job_metabox_insert($post_id) {
    global $globals;
	// verify nonce
    if (!wp_verify_nonce($_POST['templatic_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    $pt_metaboxes = get_post_custom_fields_templ($_POST['post_type']);
    $pID = $_POST['post_ID'];
    $counter = 0;
	if($_POST['zooming_factor'] != ""){
		update_post_meta($pID ,'zooming_factor',$_POST['zooming_factor']);
	}else{
		update_post_meta($pID ,'zooming_factor','13');
	}
			if($_FILES):
				$logo = get_company_logo($_FILES);
				if($logo != ""):
					update_post_meta($pID, 'company_logo',$logo);
				else:
					add_post_meta($pID, 'company_logo',$logo,true);
				endif;
				
				$apply_resume = get_resume_upload($_FILES);
				if($apply_resume != ""):
					update_post_meta($pID, 'attachment',$apply_resume);
				else:
					add_post_meta($pID, 'attachment',$apply_resume,true);
				endif;
			endif;
			/* Insert data for radius search BOF*/
			global $wpdb;
			$tbl_postcodes = $wpdb->prefix . "postcodes";

			$pcid = $wpdb->get_var("select pcid from $tbl_postcodes where post_id = '".$pID."'");
			
			$post_address = $_POST['address'];
			$latitude = $_POST['geo_latitude'];
			$longitude = $_POST['geo_longitude'];
			$location = $_POST['job_location'];
			if($pcid){
				$postcodes_update = 'UPDATE '.$tbl_postcodes.' set 
				location = "'.$location.'",
				address = "'.$post_address.'",
				latitude ="'.$latitude.'",
				longitude="'.$longitude.'" where pcid = '.$pcid.'';
				$wpdb->prepare($wpdb->query($postcodes_update));
			}else{
				$postcodes_insert = 'INSERT INTO '.$tbl_postcodes.' set 
				pcid="",
				post_id="'.$pID.'",
				location = "'.$location.'",
				address = "'.$post_address.'",
				latitude ="'.$latitude.'",
				longitude="'.$longitude.'"';
				$wpdb->prepare($wpdb->query($postcodes_insert));
			}
			
			/* Insert data for radius search EOF*/
    foreach ($pt_metaboxes as $pt_metabox) { // On Save.. this gets looped in the header response and saves the values submitted
    if($pt_metabox['type'] == 'text' OR $pt_metabox['type'] == 'select' OR $pt_metabox['type'] == 'checkbox' OR $pt_metabox['type'] == 'textarea' OR $pt_metabox['type'] == 'radio'  OR $pt_metabox['type'] == 'upload' OR $pt_metabox['type'] == 'date' OR $pt_metabox['type'] == 'multicheckbox' OR $pt_metabox['type'] == 'geo_map' OR $pt_metabox['type'] == 'texteditor') // Normal Type Things...
        { 
            $var = $pt_metabox["name"];
			if($pt_metabox['type'] == 'geo_map'){ 
				update_post_meta($pID, 'geo_address', $_POST['ptthemes_geo_address']);
				update_post_meta($pID, 'geo_latitude', $_POST['ptthemes_geo_latitude']);
				update_post_meta($pID, 'geo_longitude', $_POST['ptthemes_geo_longitude']);
			}
				if($pt_metabox['type'] != 'upload'){ 
					add_post_meta($pID, $pt_metabox["name"], $_POST[$var], true );
				   }
				if( get_post_meta( $pID, $pt_metabox["name"] ) == "" && $pt_metabox['type'] != 'upload'){
                   	add_post_meta($pID, $pt_metabox["name"], $_POST[$var], true );
					}
                elseif($_POST[$var] != get_post_meta($pID, $pt_metabox["name"], true) && $pt_metabox['type'] != 'upload')
                    update_post_meta($pID, $pt_metabox["name"], $_POST[$var]);
                elseif($_POST[$var] == "" && $pt_metabox['type'] != 'upload')
                    delete_post_meta($pID, $pt_metabox["name"], get_post_meta($pID, $pt_metabox["name"], true));
				if( get_post_meta( $pID, 'remote_ip' ) == "" )
                    add_post_meta($pID, 'remote_ip', $_POST['remote_ip'], true );
                elseif($_POST['remote_ip'] != get_post_meta($pID, 'remote_ip', true))
                    update_post_meta($pID, 'remote_ip', $_POST['remote_ip']);
                elseif($_POST['remote_ip'] == "")
                    delete_post_meta($pID, 'remote_ip', get_post_meta($pID, 'remote_ip', true));
				
				if( get_post_meta( $pID, 'ip_status' ) == "" )
                    add_post_meta($pID, 'ip_status', $_POST['ip_status'], true );
                elseif($_POST['ip_status'] != get_post_meta($pID, 'ip_status', true))
                    update_post_meta($pID, 'ip_status', $_POST['ip_status']);
                elseif($_POST['ip_status'] == ""){
                    delete_post_meta($pID, 'ip_status', get_post_meta($pID, 'ip_status', true));}
				elseif($_POST['alive_days']){ 
					update_post_meta($pID, 'alive_days', $_POST['alive_days']);
				}
                elseif($_POST['featured_type'] != get_post_meta($pID, 'featured_type', true)){
					if($_POST['featured_type']):
					
					    if($_POST['featured_type'] == 'both'):
							 update_post_meta($pID, 'featured_c', 'c');
							 update_post_meta($pID, 'featured_h', 'h');
    	                	 update_post_meta($pID, 'featured_type', $_POST['featured_type']);
						endif;
					    if($_POST['featured_type'] == 'c'):
							 update_post_meta($pID, 'featured_c', 'c');
							 update_post_meta($pID, 'featured_h', 'n');
    	                	 update_post_meta($pID, 'featured_type', $_POST['featured_type']);
						endif;	 
					    if($_POST['featured_type'] == 'h'):
							 update_post_meta($pID, 'featured_h', 'h');
							 update_post_meta($pID, 'featured_c', 'n');
    	                	 update_post_meta($pID, 'featured_type', $_POST['featured_type']);
						endif;
					    if($_POST['featured_type'] == 'none'):
							 update_post_meta($pID, 'featured_h', 'n');
							 update_post_meta($pID, 'featured_c', 'n');
    	                	 update_post_meta($pID, 'featured_type', $_POST['featured_type']);
						endif;	 
					else:
						 update_post_meta($pID, 'featured_type', 'none');
						 update_post_meta($pID, 'featured_c', 'n');
						 update_post_meta($pID, 'featured_h', 'n');
					endif;
						
					}
				}
        } 
    }
}



if(!function_exists('ptthemes_job_meta_box')){
	function ptthemes_job_meta_box() {
		$custom_post_types_args = array();  
		$custom_post_types = get_post_types($custom_post_types_args,'objects');
		foreach ($custom_post_types as $content_type) 
		{
			if($content_type->name!='nav_menu_item' && $content_type->name!='attachment' && $content_type->name!='revision' && $content_type->name!='page' && $content_type->name!='post')
			{
				$post_types = $content_type->name;
				//$pt_metaboxes = get_post_custom_fields_templ($post_types,'0','admin_side');
				if ( function_exists('add_meta_box')) {
					apply_filters('templ_admin_post_type_custom_filter',add_meta_box('ptthemes-settings',apply_filters('templ_admin_post_custom_fields_title_filter','Custom Settings'),'ptthemes_job_meta_box_content',$post_types,'normal','high',array( 'post_types' => $post_types)));
				}
			}
		}
	}
}
add_action('admin_menu', 'ptthemes_job_meta_box');
add_action('save_post', 'ptthemes_job_metabox_insert');
?>