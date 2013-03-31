<?php 
/**
 * Heading Option
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
function templ_option_tree_heading( $value, $settings, $int ) 
{
  echo ( $int > 1 ) ? '</div>' : false;
  echo '<div id="option_' . $value->item_id . '" class="block">';
  echo '<h2>' . htmlspecialchars_decode( $value->item_title ) . '</h2>';
  echo '<input type="hidden" name="' . $value->item_id . '" value="' . htmlspecialchars_decode( $value->item_title ) . '" />';
}?>