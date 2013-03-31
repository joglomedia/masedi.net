<?php 
/**
 * Input Option
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
function templ_option_tree_input( $value, $settings, $int ) 
{ 
	if($value->item_id)
	{
		$option_val = get_option($value->item_id);	
	}
?>
  <div class="option option-input">
    <h3><?php echo htmlspecialchars_decode( $value->item_title ); ?></h3>
    <div class="section">
      <div class="element">
        <input type="text" name="<?php echo $value->item_id; ?>" id="<?php echo $value->item_id; ?>" value="<?php if ( isset($option_val) ) { echo htmlspecialchars( stripslashes( $option_val ), ENT_QUOTES); } ?>" />
      </div>
      <div class="description">
        <?php echo htmlspecialchars_decode( $value->item_desc ); ?>
      </div>
    </div>
  </div>
  
<?php
}?>