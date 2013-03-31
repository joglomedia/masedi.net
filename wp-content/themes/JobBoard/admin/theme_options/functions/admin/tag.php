<?php 
/**
 * Tag Option
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
function templ_option_tree_tag( $value, $settings, $int ) 
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
       		$tags = &get_tags( array( 'hide_empty' => false ) );
       		if ( $tags )
       		{
            echo '<option value="">-- '.__('Choose One','templatic').' --</option>';
            foreach ( $tags as $tag ) 
            {
              $selected = '';
    	        if ( isset( $option_val ) && $option_val == $tag->term_id ) 
    	        { 
                $selected = ' selected="selected"'; 
              }
            	echo '<option value="'.$tag->term_id.'"'.$selected.'>'.$tag->name.'</option>';
            }
          } 
          else 
          {
            echo '<option value="0">'.__('No Tags Available','templatic').'</option>';
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
 * Tags Option
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
function templ_option_tree_tags( $value, $settings, $int ) 
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
	      $tags = &get_tags( array( 'hide_empty' => false ) );
       	if ( $tags )
       	{
       	  $count = 0;
  	      foreach ( $tags as $tag ) 
  	      {
            $checked = '';
  	        if ( in_array( $tag->term_id, $ch_values ) ) 
  	        { 
              $checked = ' checked="checked"'; 
            }
  	        echo '<div class="input_wrap"><input name="checkboxes['.$value->item_id.'][]" id="'.$value->item_id.'_'.$count.'" type="checkbox" value="'.$tag->term_id.'"'.$checked.' /><label for="'.$value->item_id.'_'.$count.'">'.$tag->name.'</label></div>';
  	        $count++;
       		}
       	}
       	else
       	{
       	  echo '<p>'.__('No Tags Available','templatic').'</p>';
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