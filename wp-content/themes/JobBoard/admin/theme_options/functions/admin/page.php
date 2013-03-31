<?php 
/**
 * Page Option
 *
 * @access public
 * @since 1.0.0
 *
 * @param array $value
 * @param array $settings
 * @param int $int
 *
 * @return string
 */
function templ_option_tree_page( $value, $settings, $int ) 
{ 
	if($value->item_id)
	{
		$option_val = get_option($value->item_id);	
	}
?>
  <div class="option option-select">
    <h3><?php echo htmlspecialchars_decode( $value->item_title ); ?></h3>
    <div class="section">
      <div class="element">
        <div class="select_wrapper">
          <select name="<?php echo $value->item_id; ?>" id="<?php echo $value->item_id; ?>" class="select">
          <?php
       		$pages = &get_pages();
       		if ( $pages )
       		{
       	    echo '<option value="">-- '.__('Choose One','templatic').' --</option>';
            foreach ( $pages as $page ) 
            {
              $selected = '';
    	        if ( isset( $option_val ) && $option_val == $page->ID ) 
    	        { 
                $selected = ' selected="selected"'; 
              }
            	echo '<option value="'.$page->ID.'"'.$selected.'>'.$page->post_title.'</option>';
            }
          } 
          else 
          {
            echo '<option value="0">'.__('No Pages Available','templatic').'</option>';
          }
          ?>
          </select>
        </div>
      </div>
      <div class="description">
        <?php echo htmlspecialchars_decode( $value->item_desc ); ?>
      </div>
    </div>
  </div>
<?php
}

/**
 * Pages Option
 *
 * @access public
 * @since 1.0.0
 *
 * @param array $value
 * @param array $settings
 * @param int $int
 *
 * @return string
 */
function templ_option_tree_pages( $value, $settings, $int ) 
{ 
	if($value->item_id)
	{
		$option_val = get_option($value->item_id);	
	}
?>
  <div class="option option-checbox">
    <h3><?php echo htmlspecialchars_decode( $value->item_title ); ?></h3>
    <div class="section">
      <div class="element">
        <?php
        // check for settings item value
	      if ( isset( $option_val ) )
	      {
          $ch_values = explode(',', $option_val );
        }
        else
        {
          $ch_values = array();
        }
        
        // loop through tags
	      $pages = &get_pages();
       	if ( $pages )
       	{
			 if ( in_array( 'none', $ch_values ) ) 
			 {
				 $chkednone = ' checked="checked"'; 
			 }
			echo '<div class="input_wrap"><input type="checkbox" value="none" id="'.$value->item_id.'" '.$chkednone.' name="checkboxes['.$value->item_id.'][]"><label for="'.$value->item_id.'">None</label></div>';
       	  $count = 0;
  	      foreach ( $pages as $page ) 
  	      {
            $checked = '';
  	        if ( in_array( $page->ID, $ch_values ) ) 
  	        { 
              $checked = ' checked="checked"'; 
            }
  	        echo '<div class="input_wrap"><input name="checkboxes['.$value->item_id.'][]" id="'.$value->item_id.'_'.$count.'" type="checkbox" value="'.$page->ID.'"'.$checked.' /><label for="'.$value->item_id.'_'.$count.'">'.$page->post_title.'</label></div>';
  	        $count++;
       		}
       	}
       	else
       	{
       	  echo '<p>No Pages Available</p>';
       	}
        ?>
      </div>
      <div class="description">
        <?php echo htmlspecialchars_decode( $value->item_desc ); ?>
      </div>
    </div>
  </div>
<?php
}?>