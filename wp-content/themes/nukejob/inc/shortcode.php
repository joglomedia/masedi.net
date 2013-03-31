<?php
// Pull Quote Left
function wpnuke_left_quote( $atts, $content = null ) {
    return '<span class="left-quote">'.do_shortcode($content).'</span>';
}
add_shortcode("left_quote", "wpnuke_left_quote");
// Pull Quote Right
function wpnuke_right_quote( $atts, $content = null ) {
    return '<span class="right-quote">'.do_shortcode($content).'</span>';
}
add_shortcode("right_quote", "wpnuke_right_quote");
// Back to Top
function wpnuke_back_top( $atts, $content = null ) {
    return '<div class="hr top" id="backtop"><a href="#">top</a></div>';
}
add_shortcode("back_top", "wpnuke_back_top");
// Horizontal Rule
function wpnuke_hr( $atts, $content = null ) {
    return '<div class="hr"></div>';
}
add_shortcode("hr", "wpnuke_hr");
// Image Without Frame
function wpnuke_img_no_frame( $atts, $content = null ) {
    return '<span class="img-no-frame">'.do_shortcode($content).'</span>';
}
add_shortcode("img_no_frame", "wpnuke_img_no_frame");
// Text Highlight
function wpnuke_highlight( $atts, $content = null ) {
    extract(shortcode_atts(array(
    'text_bg_color'	=> '',
	'color'	=> '',
	), $atts));
	return '<span style="background:'.$text_bg_color.'; color:'.$color.';">'.do_shortcode($content).'</span>';
}
add_shortcode("highlight", "wpnuke_highlight");
// Dropcap
function wpnuke_dropcap( $atts, $content = null ) {
    return '<span class="dropcap">'.do_shortcode($content).'</span>';
}
add_shortcode("dropcap", "wpnuke_dropcap");
// Button
function wpnuke_button( $atts, $content = null ) {
    extract(shortcode_atts(array(
    'link'	=> '#',
	'color'	=> '',
    'size'	=> '',
	), $atts));
	return '<a class="button '.$color.' '.$size.'" href="' .$link. '">'.do_shortcode($content).'</a>';
}
add_shortcode('button', 'wpnuke_button');
// Check List
function wpnuke_check_list( $atts, $content = null ) {
	$content = str_replace('<ul>', '<ul class="checklist">', do_shortcode($content));
	return $content;
}
add_shortcode('check_list', 'wpnuke_check_list');
// Check List with Lines
function wpnuke_check_list_line( $atts, $content = null ) {
	$content = str_replace('<ul>', '<ul class="checklist-line">', do_shortcode($content));
	return $content;
}
add_shortcode('check_list_line', 'wpnuke_check_list_line');
// Arrow List
function wpnuke_arrow_list( $atts, $content = null ) {
	$content = str_replace('<ul>', '<ul class="arrowlist">', do_shortcode($content));
	return $content;
}
add_shortcode('arrow_list', 'wpnuke_arrow_list');
// Arrow List with Lines
function wpnuke_arrow_list_line( $atts, $content = null ) {
	$content = str_replace('<ul>', '<ul class="arrowlist-line">', do_shortcode($content));
	return $content;	
}
add_shortcode('arrow_list_line', 'wpnuke_arrow_list_line');
// Info Box
function wpnuke_info_box( $atts, $content = null ) {
    return '<div class="info">'.do_shortcode($content).'</div>';
}
add_shortcode("info_box", "wpnuke_info_box");
// Success Box
function wpnuke_success_box( $atts, $content = null ) {
    return '<div class="success">'.do_shortcode($content).'</div>';
}
add_shortcode("success_box", "wpnuke_success_box");
// Warning Box
function wpnuke_warning_box( $atts, $content = null ) {
    return '<div class="warning">'.do_shortcode($content).'</div>';
}
add_shortcode("warning_box", "wpnuke_warning_box");
// Error Box
function wpnuke_error_box( $atts, $content = null ) {
    return '<div class="error">'.do_shortcode($content).'</div>';
}
add_shortcode("error_box", "wpnuke_error_box");
// Toggle
function wpnuke_toggle( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'title' => '',
    ), $atts));
	
	$out .= '<h4 class="toggle">' .$title. '</h4>';
	$out .= '<div class="toggle-content">';
	$out .= do_shortcode($content);
	$out .= '</div>';
	return $out;
}
add_shortcode('toggle', 'wpnuke_toggle');
// Iconbox
function wpnuke_iconbox( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'title' => '',
		'icon' => ''
    ), $atts));
	
	$out .= '<div class="iconbox"><span class="iconbox-icon"><img alt="" src="' . get_template_directory_uri() . '/images/iconbox/' . $icon . '"></span>';
	$out .= '<div class="iconbox-content"><h3>' . $title . '</h3>';
	$out .= do_shortcode($content);
	$out .= '</div></div>';
	return $out;
}
add_shortcode('iconbox', 'wpnuke_iconbox');
// Google Map
function wpnuke_gmap($atts, $content = null) {
	extract(shortcode_atts(array(
		"width" => '456',
		"height" => '300',
		"src" => ''
	), $atts));
	return '<div class="gmap"><iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$src.'&iwloc=near&output=embed"></iframe></div>';
	}
add_shortcode("googlemap", "wpnuke_gmap");
// Tab
add_shortcode( 'tabs', 'wpnuke_tabs' );
function wpnuke_tabs( $atts, $content ){
	$GLOBALS['tab_count'] = 0;
	do_shortcode( $content );
	if( is_array( $GLOBALS['tabs'] ) ){
		foreach( $GLOBALS['tabs'] as $tab ){
			$tabs[] = '<li><a class="" href="#">'.$tab['title'].'</a></li>';
			$panes[] = '<div class="tab-content">'.$tab['content'].'</div>';
		}
		$return = "\n".'<ul class="tabs">'.implode( "\n", $tabs ).'</ul>'."\n".'<div class="tab-container">'.implode( "\n", $panes ).'</div>'."\n";
	}
	return $return;
}
add_shortcode( 'tab', 'wpnuke_tab' );
function wpnuke_tab( $atts, $content ){
	extract(shortcode_atts(array(
		'title' => 'Tab %d'
	), $atts));
	$x = $GLOBALS['tab_count'];
	$GLOBALS['tabs'][$x] = array( 'title' => sprintf( $title, $GLOBALS['tab_count'] ), 'content' =>  $content );
	$GLOBALS['tab_count']++;
}
// Contact form
function wpnuke_contact_form( $atts, $content = null ) {
    $out .= '<form method="post" action="' . WPNUKE_INCLUDES . '/contact-send.php">';
	$out .= '<fieldset>';
	$out .= '<input type="hidden" id="myemail" name="myemail" value="' . do_shortcode($content) . '" />';
	$out .= '<p><input class="text-input" id="form-name" type="text" name="name" size="20" value="" /><label for="form-name">Name <small>(required)</small></label></p>';
	$out .= '<p><input class="text-input" id="form-email" type="text" name="email" size="20" value="" /><label for="form-email">Email <small>(required)</small></label></p>';
	$out .= '<p><input class="text-input" id="form-subject" type="text" name="subject" size="20" value="" /><label for="form-subject">Subject</label></p>';
	$out .= '<p><textarea class="text-area" id="form-message" rows="7" cols="60" name="message" ></textarea></p>';
	$out .= '<input class="input-btn" id="form-submit" type="submit" name="submit" value="Send Message" />';
	$out .= '<p class="hide" id="response"></p>';
	$out .= '</fieldset>';
	$out .= '</form>';
	return $out;
}
add_shortcode("contact_form", "wpnuke_contact_form");
// Columns
// One Half
function wpnuke_one_half( $atts, $content = null ) {
   return '<div class="one-half">'.do_shortcode($content).'</div>';
}
add_shortcode('one_half', 'wpnuke_one_half');
// One Half Last
function wpnuke_one_half_last( $atts, $content = null ) {
   return '<div class="one-half last">'.do_shortcode($content).'</div>';
}
add_shortcode('one_half_last', 'wpnuke_one_half_last');
// One Third
function wpnuke_one_third( $atts, $content = null ) {
   return '<div class="one-third">'.do_shortcode($content).'</div>';
}
add_shortcode('one_third', 'wpnuke_one_third');
// One Third Last
function wpnuke_one_third_last( $atts, $content = null ) {
   return '<div class="one-third last">'.do_shortcode($content).'</div>';
}
add_shortcode('one_third_last', 'wpnuke_one_third_last');
// Two Third
function wpnuke_two_third( $atts, $content = null ) {
   return '<div class="two-third">'.do_shortcode($content).'</div>';
}
add_shortcode('two_third', 'wpnuke_two_third');
// Two Third Last
function wpnuke_two_third_last( $atts, $content = null ) {
   return '<div class="two-third last">'.do_shortcode($content).'</div>';
}
add_shortcode('two_third_last', 'wpnuke_two_third_last');
// One Fourth
function wpnuke_one_fourth( $atts, $content = null ) {
   return '<div class="one-fourth">'.do_shortcode($content).'</div>';
}
add_shortcode('one_fourth', 'wpnuke_one_fourth');
// One Fourth Last
function wpnuke_one_fourth_last( $atts, $content = null ) {
   return '<div class="one-fourth last">'.do_shortcode($content).'</div>';
}
add_shortcode('one_fourth_last', 'wpnuke_one_fourth_last');
// Three Fourth
function wpnuke_three_fourth( $atts, $content = null ) {
   return '<div class="three-fourth">'.do_shortcode($content).'</div>';
}
add_shortcode('three_fourth', 'wpnuke_three_fourth');
// Three Fourth Last
function wpnuke_three_fourth_last( $atts, $content = null ) {
   return '<div class="three-fourth last">'.do_shortcode($content).'</div>';
}
add_shortcode('three_fourth_last', 'wpnuke_three_fourth_last');
// One Fifth
function wpnuke_one_fifth( $atts, $content = null ) {
   return '<div class="one-fifth">'.do_shortcode($content).'</div>';
}
add_shortcode('one_fifth', 'wpnuke_one_fifth');
// One Fifth Last
function wpnuke_one_fifth_last( $atts, $content = null ) {
   return '<div class="one-fifth last">'.do_shortcode($content).'</div>';
}
add_shortcode('one_fifth_last', 'wpnuke_one_fifth_last');
// Two Fifth
function wpnuke_two_fifth( $atts, $content = null ) {
   return '<div class="two-fifth">'.do_shortcode($content).'</div>';
}
add_shortcode('two_fifth', 'wpnuke_two_fifth');
// Two Fifth Last
function wpnuke_two_fifth_last( $atts, $content = null ) {
   return '<div class="two-fifth last">'.do_shortcode($content).'</div>';
}
add_shortcode('two_fifth_last', 'wpnuke_two_fifth_last');
// Three Fifth
function wpnuke_three_fifth( $atts, $content = null ) {
   return '<div class="three-fifth">'.do_shortcode($content).'</div>';
}
add_shortcode('three_fifth', 'wpnuke_three_fifth');
// Three Fifth Last
function wpnuke_three_fifth_last( $atts, $content = null ) {
   return '<div class="three-fifth last">'.do_shortcode($content).'</div>';
}
add_shortcode('three_fifth_last', 'wpnuke_three_fifth_last');
// Four Fifth
function wpnuke_four_fifth( $atts, $content = null ) {
   return '<div class="four-fifth">'.do_shortcode($content).'</div>';
}
add_shortcode('four_fifth', 'wpnuke_four_fifth');
// Four Fifth Last
function wpnuke_four_fifth_last( $atts, $content = null ) {
   return '<div class="four-fifth last">'.do_shortcode($content).'</div>';
}
add_shortcode('four_fifth_last', 'wpnuke_four_fifth_last');
// One Sixth
function wpnuke_one_sixth( $atts, $content = null ) {
   return '<div class="one-sixth">'.do_shortcode($content).'</div>';
}
add_shortcode('one_sixth', 'wpnuke_one_sixth');
// One Sixth Last
function wpnuke_one_sixth_last( $atts, $content = null ) {
   return '<div class="one-sixth last">'.do_shortcode($content).'</div>';
}
add_shortcode('one_sixth_last', 'wpnuke_one_sixth_last');
// Five Sixth
function wpnuke_five_sixth( $atts, $content = null ) {
   return '<div class="five-sixth">'.do_shortcode($content).'</div>';
}
add_shortcode('five_sixth', 'wpnuke_five_sixth');
// Five Sixth Last
function wpnuke_five_sixth_last( $atts, $content = null ) {
   return '<div class="five-sixth last">'.do_shortcode($content).'</div>';
}
add_shortcode('five_sixth_last', 'wpnuke_five_sixth_last');

// Shortcodes in Widget
add_filter('widget_text', 'do_shortcode');
?>