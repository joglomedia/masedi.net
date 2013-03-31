<?php
function mytheme_add_admin() {

    global $kampylefeedback, $themename, $shortname, $options;

    if ( $_GET['page'] == 'theme_settings' ) {
    
        if ( 'save' == $_REQUEST['action'] ) {
	
                foreach ($options as $value) {
					
					///LOGO IMAGE UPLOAD CODING START//
				if($value['type'] == 'file')
				{
					if($_FILES)
					{
						$destination_path = ABSPATH.'/wp-content/uploads/';
						if (!file_exists(ABSPATH.'/wp-content')){
						  mkdir(ABSPATH.'/wp-content', 0777);
						}
						if (!file_exists(ABSPATH.'/wp-content/uploads/')){
						  mkdir(ABSPATH.'/wp-content/uploads/', 0777);
						} 
						$image_var = $value['id'].'_image';
						if($_FILES[$image_var]['name'] && $_FILES[$image_var]['size']>0)
						{
							$name = str_replace(',','_',$_FILES[$image_var]['name']);
							$tmp_name = $_FILES[$image_var]['tmp_name'];
							$target_path = $destination_path . $name;
							if(move_uploaded_file($tmp_name, $target_path)) 
							{
								$imagepath1 = get_option( 'siteurl' ) ."/wp-content/uploads/".$name;
								$upload_path = get_option('upload_path');
								$imagepath1 = str_replace($upload_path,'files',$imagepath1);
								//update_option($value['id'], $imagepath1 );
								$_REQUEST[ $value['id'] ] = $imagepath1;
							}
						}
					}
				}
				 ///LOGO IMAGE UPLOAD CODING END//
					
					if($value['type'] != 'multicheck'){
                    	update_option( $value['id'], $_REQUEST[ $value['id'] ] ); 
					}else{
						foreach($value['options'] as $mc_key => $mc_value){
							$up_opt = $value['id'].'_'.$mc_key;
							update_option($up_opt, $_REQUEST[$up_opt] );
						}
					}
				}

                foreach ($options as $value) {
					if($value['type'] != 'multicheck'){
                    	if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } 
					}else{
						foreach($value['options'] as $mc_key => $mc_value){
							$up_opt = $value['id'].'_'.$mc_key;						
							if( isset( $_REQUEST[ $up_opt ] ) ) { update_option( $up_opt, $_REQUEST[ $up_opt ]  ); } else { delete_option( $up_opt ); } 
						}
					}
				}
               // header("Location: admin.php?page=theme_settings&saved=true");
               // die;

        } else if( 'reset' == $_REQUEST['action'] ) {

            foreach ($options as $value) {
				if($value['type'] != 'multicheck'){
                	delete_option( $value['id'] ); 
				}else{
					foreach($value['options'] as $mc_key => $mc_value){
						$del_opt = $value['id'].'_'.$mc_key;
						delete_option($del_opt);
					}
				}
			}
            //header("Location: themes.php?page=functions.php&reset=true");
			// header("Location: admin.php?page=theme_settings&saved=true");
           // die;

        }
    }

//add_theme_page($themename." Options", "$themename Theme Options", 'switch_themes', 'functions.php', 'mytheme_admin');
//	mytheme_wp_head();
	mytheme_admin_head();
	mytheme_admin();
	
}
function mytheme_admin() {

    global $customserviceurl, $kampylefeedback, $themename, $bloghomeurl, $shortname, $options;
   
?>

<div class="clear">
  <!---->
</div>
<div class="ptadmin">
<h2><?php echo $themename; ?> <?php _e('Theme Options');?> &nbsp;&nbsp;</h2>
<div class="introduction"> <a class="switch-link" id="master_switch" href="" title="Show/Hide All Options"><span class="pos"><b>+</b></span><span class="neg"><b>&#8211;</b></span> <?php _e('Show/Hide All Options');?></a> </div>
<?php 
    
	if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved!&nbsp; <a href="'.$bloghomeurl.'">Check out your blog &rarr;</a></strong></p></div>';
    if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset!&nbsp; <a href="'.$bloghomeurl.'">Check out your blog &rarr;</a></strong></p></div>'; 
	
?>
<form method="post" enctype="multipart/form-data">
  <?php foreach ($options as $value) { 
	
	switch ( $value['type'] ) {
		
		 ///LOGO IMAGE UPLOAD CODING START//
		case 'file':
		option_wrapper_header($value);
		global $thumb_url;
		?>
  <input class="text_input" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
  <p style="height:100%; overflow: hidden;"><input type="file" name="<?php echo $value['id']; ?>_image" id="<?php echo $value['id']; ?>_image" style="width:260px; float:left;" /> 
<input type="submit" value="Upload" name="Upload" style="width:100px; float:left;"  /> </p>
  <?php if ( get_settings( $value['id'] ) != "") { ?>
  <a href="<?php echo get_settings( $value['id'] );?>" title=""><img src="<?php echo get_settings( $value['id']); ?>" width="150" alt="" /></a>
  <?php }?>
  <?php
		option_wrapper_footer($value);
		break;
		 ///LOGO IMAGE UPLOAD CODING END//
		
		case 'text':
		option_wrapper_header($value);
		?>
  <input class="text_input" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" />
  <?php
		option_wrapper_footer($value);
		break;
		
		case 'select':
		option_wrapper_header($value);
		?>
  <select class="select_input" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
    <?php foreach ($value['options'] as $option) { ?>
    <option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option>
    <?php } ?>
  </select>
  <?php
		option_wrapper_footer($value);
		break;
		
		case 'textarea':
		$ta_options = $value['options'];
		option_wrapper_header($value);
		?>
  <textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" cols="<?php echo $ta_options['cols']; ?>" rows="8"><?php  if( get_settings($value['id']) != "") { echo stripslashes(get_settings($value['id'])); } else { echo $value['std']; } ?>
</textarea>
  <?php
		option_wrapper_footer($value);
		break;
		
		case 'textarea2':
		$ta_options = $value['options'];
		option_wrapper_header($value);
		?>
  <textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" cols="<?php echo $ta_options['cols']; ?>" rows="2"><?php  if( get_settings($value['id']) != "") { echo stripslashes(get_settings($value['id'])); } else { echo $value['std']; } ?>
</textarea>
  <?php
		option_wrapper_footer($value);
		break;

		case "radio":
		option_wrapper_header($value);
		
 		foreach ($value['options'] as $key=>$option) { 
				$radio_setting = get_settings($value['id']);
				if($radio_setting != ''){
		    		if ($key == get_settings($value['id']) ) {
						$checked = "checked=\"checked\"";
						} else {
							$checked = "";
						}
				}else{
					if($key == $value['std']){
						$checked = "checked=\"checked\"";
					}else{
						$checked = "";
					}
				}?>
  <input type="radio" name="<?php echo $value['id']; ?>" value="<?php echo $key; ?>" <?php echo $checked; ?> />
  <?php echo $option; ?><br />
  <?php 
		}
		 
		option_wrapper_footer($value);
		break;
		
		case "checkbox":
		option_wrapper_header($value);
						if(get_settings($value['id'])){
							$checked = "checked=\"checked\"";
						}else{
							$checked = "";
						}
					?>
  <input <?php echo $value['disabled']; ?> class="input_checkbox" type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
  &nbsp;
  <label><?php _e($value['label']); ?></label>
  <br />
  <?php
		option_wrapper_footer($value);
		break;
		
		case "multicheck":
		option_wrapper_header($value);
		
 		foreach ($value['options'] as $key=>$option) {
	 			$pn_key = $value['id'] . '_' . $key;
				$checkbox_setting = get_settings($pn_key);
				if($checkbox_setting != ''){
		    		if (get_settings($pn_key) ) {
						$checked = "checked=\"checked\"";
						} else {
							$checked = "";
						}
				}else{
					if($key == $value['std']){
						$checked = "checked=\"checked\"";
					}else{
						$checked = "";
					}
				}?>
  <input type="checkbox" name="<?php echo $pn_key; ?>" id="<?php echo $pn_key; ?>" value="true" <?php echo $checked; ?> />
  <label for="<?php echo $pn_key; ?>"><?php _e($option); ?></label>
  <br />
  <?php 
		}
		 
		option_wrapper_footer($value);
		break;
		
		case "heading":
		?>
  <div class="box-title"><?php _e($value['name']); ?> </div>
  <div class="fr submit submit-title">
    <input name="save" type="submit" value="Save changes" />
    <input type="hidden" name="action" value="save" />
  </div>
  <?php
		break;
		
		case "subheadingtop":
		?>
  <div class="feature-box">
    <div class="subheading">
      <?php if ($value['toggle'] <> "") { ?>
      <a href="" title="Show/hide additional information"><span class="pos">+</span><span class="neg">&#8211;</span></a>&nbsp;&nbsp;
      <?php } ?>
      <?php _e($value['name']); ?></div>
    <div class="options-box">
      <?php
		break;
		
		case "subheadingbottom":
		?>
    </div>
  </div>
  <?php
		break;
		
		case "wraptop":
		?>
  <div class="bottom-container">
    <p class="text">
    <div class="wrap-dropdown">
      <?php
		break;
		case "wrapbottom":
		?>
    </div>
    </p>
  </div>
  </div>
  <?php
		break;
		case "multihead":
		option_wrapper_header2($value);
		break;
		
		case "maintabletop":
		?>
  <div class="maintable">
    <?php
		break;
		case "maintablebottom":
		?>
  </div>
  <?php
		break;
		case "maintablebreak":
		?>
  <br/>
  <?php
		break;
		default:
		break;
	}
}
?>
  <div class="clear"></div>
  <br/>
  <p class="submit reset_save">
    <input name="save" type="submit" value="<?php _e('Save changes');?>" />
    <input type="hidden" name="action" value="save" />
  </p>
</form>
<form method="post">
  <p class="submit reset_save reset">
    <input name="reset" type="submit" value="<?php _e('Reset');?>" />
    <input type="hidden" name="action" value="reset" />
  </p>
</form>
<?php
}

function option_wrapper_header2($values){
	?>
<div class="table-row">
<?php
}

function option_wrapper_header($values){
	?>
<div class="table-row">
  <div class="top-container"><?php _e($values['name']); ?>
    <!--<a href="" title="Show/hide additional information">[+]</a>-->
  </div>
  <div class="bottom-container">
    <p class="description"><?php _e($values['desc']); ?></p>
    <p class="text">
      <?php
}

function option_wrapper_footer($values){
	?>
    </p>
  </div>
</div>
<?php 
}

function mytheme_wp_head() { 
	$stylesheet = get_option('ptthemes_alt_stylesheet');
	if($stylesheet != ''){?>
<link href="<?php bloginfo('template_directory'); ?>/skins/<?php echo $stylesheet; ?>.css" rel="stylesheet" type="text/css" />
<?php }
} 

add_action('wp_head', 'mytheme_wp_head');
//add_action('admin_menu', 'mytheme_add_admin');
//add_action('admin_head', 'mytheme_admin_head');	
?>
