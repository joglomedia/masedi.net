<?php 
/**
 * Select Option
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
function templ_option_tree_select( $value, $settings, $int ) 
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
        <?php $options_array = explode( ',', $value->item_options ); ?>
        <div class="select_wrapper">
          <select name="<?php echo $value->item_id; ?>" id="<?php echo $value->item_id; ?>" class="select">
          <?php
          echo '<option value="">-- '.__('Choose One','templatic').' --</option>';
          foreach ( $options_array as $option ) 
          {
            $selected = '';
  	        if ( $option_val == trim( $option ) ) 
  	        { 
              $selected = ' selected="selected"'; 
            }
  	        echo '<option'.$selected.'>'.trim( $option ).'</option>';
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
}?>