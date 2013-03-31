<?php 
/**
 * Radio Option
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
function templ_option_tree_radio( $value, $settings, $int ) 
{ 
	if($value->item_id)
	{
		$option_val = get_option($value->item_id);	
	}
?>
  <div class="option option-radio">
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
        
        $count = 0;
        
        // create options array
        $options_array = explode( ',', $value->item_options );
        
        // loop through options array
	      foreach ( $options_array as $option ) 
	      {
          $checked = '';
	        if ( in_array( trim( $option ), $ch_values ) ) 
	        { 
            $checked = ' checked="checked"'; 
          }
	        echo '<div class="input_wrap"><input name="radios['.$value->item_id.'][]" id="'.$value->item_id.'_'.$count.'" type="radio" value="'.trim( $option ).'"'.$checked.' /><label for="'.$value->item_id.'_'.$count.'">'.trim( $option ).'</label></div>';
	        $count++;
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