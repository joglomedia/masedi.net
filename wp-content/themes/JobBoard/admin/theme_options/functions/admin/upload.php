<?php 
/**
 * Upload Option
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
function templ_option_tree_upload( $value, $settings, $int ) { 
	if($value->item_id)
	{
		$option_val = get_option($value->item_id);	
	}
?>
  <div class="option option-upload">
    <h3><?php echo htmlspecialchars_decode( $value->item_title ); ?></h3>
    <div class="section">
      <div class="element">
        <input type="text" name="<?php echo $value->item_id; ?>" id="<?php echo $value->item_id; ?>" value="<?php if ( isset( $option_val ) ) { echo $option_val; } ?>" class="upload<?php if ( isset( $option_val ) ) { echo ' has-file'; } ?>" />
        <input id="upload_<?php echo $value->item_id; ?>" class="upload_button" type="button" value="Upload" rel="<?php echo $int; ?>" />
        <div class="screenshot" id="<?php echo $value->item_id; ?>_image">
          <?php 
          if ( isset( $option_val ) && $option_val != '' ) 
          { 
            $remove = '<a href="javascript:(void);" class="remove">Remove</a>';
            $image = preg_match( '/(^.*\.jpg|jpeg|png|gif|ico*)/i', $option_val );
            if ( $image ) 
            {
              echo '<img src="'.$option_val.'" alt="" />'.$remove.'';
            } 
            else 
            {
              $parts = explode( "/", $option_val );
              for( $i = 0; $i < sizeof($parts); ++$i ) 
              {
                $title = $parts[$i];
              }
              echo '<div class="no_image"><a href="'.$option_val.'">'.$title.'</a>'.$remove.'</div>';
            }
          }
          ?>
        </div>
      </div>
      <div class="description">
        <?php echo htmlspecialchars_decode( $value->item_desc ); ?>
      </div>
    </div>
  </div>
<?php
}
?>