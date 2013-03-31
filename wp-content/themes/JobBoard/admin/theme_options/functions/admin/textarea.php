<?php 
/**
 * Textarea Option
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
function templ_option_tree_textarea( $value, $settings, $int ) 
{ 
	if($value->item_id)
	{
		$option_val = get_option($value->item_id);	
	}
?>
  <div class="option option-textarea">
    <h3><?php echo htmlspecialchars_decode( $value->item_title ); ?></h3>
    <div class="section">
      <div class="element">
        <textarea name="<?php echo $value->item_id; ?>" rows="<?php echo $int; ?>"><?php 
          if ( isset( $option_val ) ) 
            echo stripslashes ($option_val);
          ?></textarea>
      </div>
      <div class="description">
        <?php echo htmlspecialchars_decode( $value->item_desc ); ?>
      </div>
    </div>
  </div>
<?php
}
?>