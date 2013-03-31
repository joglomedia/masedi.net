<?php if ( !defined('ABSPATH') ) die('No direct access');

$opl_cd = 0;
add_shortcode('opl_countdown', 'opl_countdown_handler');
add_shortcode('ez_countdown', 'opl_countdown_handler');
function opl_countdown_handler( $atts, $content = null ) {
	@date_default_timezone_set(opl_getLocalTimezone());
	
	extract( shortcode_atts( array(
		'day' => '0',
		'month' => '0',
		'year' => '0',
		'hour' => '0',
		'min' => '0',
		'sec' => '0',
		'style' => 'dark',
		'redirect' => ''
	), $atts ) );
	
	global $opl_cd;
	
	$countdown = '';
	$pattern = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
	$comma = ( preg_match($pattern, $redirect) ) ? ',' : ''; 
	$script = ( preg_match($pattern, $redirect) ) ? 'onComplete: function(){ window.location = "' . $redirect . '"; }' : '';
	
	$today = time();
	$target = mktime($hour, $min, $sec, $month, $day, $year);
	
	$differ = opl_datediff('d', $today, $target, true);
	$box_width = 450;
	
	if ( $differ < 7 )
		$box_width -= 90;
	
	if ( $differ < 1 )
		$box_width -= 90;
	
	$countdown .= '
		[raw]<!-- Countdown start -->[/raw]
		[raw]<div id="opl_countdown_' . $opl_cd . '" class="opl-countdown opl-countdown-' . $style . '" style="width:' . $box_width . 'px">[/raw]
	';
	
	if ( $differ > 7 ) :
		$countdown .= '
			[raw]<div class="opl-dash weeks_dash">[/raw]
				[raw]<span class="dash_title">weeks</span>[/raw]
				[raw]<div class="digit">0</div>[/raw]
				[raw]<div class="digit">0</div>[/raw]
				[raw]<div class="clearfix"></div>[/raw]
			[raw]</div>[/raw]
		';
	endif;
	
	if ( $differ > 0 ) :
		$countdown .= '
			[raw]<div class="opl-dash days_dash">[/raw]
				[raw]<span class="dash_title">days</span>[/raw]
				[raw]<div class="digit">0</div>[/raw]
				[raw]<div class="digit">0</div>[/raw]
				[raw]<div class="clearfix"></div>[/raw]
			[raw]</div>[/raw]
		';
	endif;
	
	$countdown .= '
			[raw]<div class="opl-dash hours_dash">[/raw]
				[raw]<span class="dash_title">hours</span>[/raw]
				[raw]<div class="digit">0</div>[/raw]
				[raw]<div class="digit">0</div>[/raw]
				[raw]<div class="clearfix"></div>[/raw]
			[raw]</div>[/raw]
			[raw]<div class="opl-dash minutes_dash">[/raw]
				[raw]<span class="dash_title">minutes</span>[/raw]
				[raw]<div class="digit">0</div>[/raw]
				[raw]<div class="digit">0</div>[/raw]
				[raw]<div class="clearfix"></div>[/raw]
			[raw]</div>[/raw]
			[raw]<div class="opl-dash seconds_dash">[/raw]
				[raw]<span class="dash_title">seconds</span>[/raw]
				[raw]<div class="digit">0</div>[/raw]
				[raw]<div class="digit">0</div>[/raw]
				[raw]<div class="clearfix"></div>[/raw]
			[raw]</div>[/raw]
			[raw]<div class="clearfix"></div>[/raw]
		[raw]</div>[/raw]
		[raw]<!-- Countdown end -->[/raw]
		
		
		[raw]<script type="text/javascript">[/raw]
			[raw]jQuery(document).ready(function() {[/raw]
				[raw]jQuery(\'#opl_countdown_' . $opl_cd . '\').countDown({[/raw]
					[raw]targetDate: {[/raw]
						[raw]\'day\': ' . $day . ',[/raw]
						[raw]\'month\': ' . $month . ',[/raw]
						[raw]\'year\': ' . $year . ',[/raw]
						[raw]\'hour\': ' . $hour . ',[/raw]
						[raw]\'min\': ' . $min . ',[/raw]
						[raw]\'sec\': ' . $sec . '[/raw]
					[raw]}' . $comma . '[/raw]
					[raw]' . $script . '[/raw]
				[raw]});[/raw]
	';
		if ( defined('WP_HEADLINE_PLUGIN') ) 
			$countdown .= '[raw]jQuery.noConflict(true);[/raw]';
		
	$countdown .= '
			[raw]});[/raw]
		[raw]</script>[/raw]
	';
	
	
	$opl_cd++;
	
	return $countdown;
}

add_shortcode('opl_fb', 'opl_fb_handler');
add_shortcode('ez_fb', 'opl_fb_handler');
function opl_fb_handler( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'for' => 'non-fans',
	), $atts ) );
	
	$tab = '';
	if ( opl_isset($_GET['facebook']) == 'true' && opl_isset($_GET['fb_page_id']) != '' && opl_isset($_GET['fb_liked']) != '' ) {
		if ( $_GET['fb_liked'] == 'yes' && $for == 'fans' )
			$tab .= do_shortcode($content);
		
		if ( $_GET['fb_liked'] != 'yes' && $for == 'non-fans' )
			$tab .= do_shortcode($content);
	}
	
	return $tab;
}

add_shortcode('opl_optin_form', 'opl_optin_form_handler');
add_shortcode('ez_optin_form', 'opl_optin_form_handler');
function opl_optin_form_handler( $atts, $content = null ) {
	global $post;
	
	$meta = get_post_meta($post->ID, 'opl_settings', true);
	$optin = opl_isset($meta['optin']);
	
	$ar_code = stripslashes(opl_isset($meta['ar_code']));
	$manual_subs = opl_isset($optin['subs_method_manual']);
	$name_label = stripslashes(opl_isset($optin['name_field']));
	$email_label = stripslashes(opl_isset($optin['email_field']));
	$form_mode = opl_isset($optin['form_mode']);
	$resp = ( $optin['form_mode'] == 'advanced' ) ? opl_extract_adv_fields($ar_code) : opl_extract_fields($ar_code, $name_label, $email_label);
	$optin_form = opl_optin_form($resp, $manual_subs, $optin, $form_mode);
	
	require_once( OPL_PATH . 'inc/Mobile_Detect.php');
	$detect = new Mobile_Detect;
	
	$width = ( $detect->isMobile() ) ? '100%' : '60%';
	
	$html  = '';
	$html .= '[raw]<div style="width:' . $width . ';margin:0 auto">[/raw]' . "\n";
	$html .= opl_video_optin($optin_form, $optin);
	$html .= '[raw]</div>[/raw]' . "\n";
	
	return opl_clean_wpautop($html);
}

add_shortcode('opl_box', 'opl_box_handler');
add_shortcode('ez_box', 'opl_box_handler');
function opl_box_handler( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'color' => 'grey',
		'title' => '',
		'size' => 'normal'
	), $atts ) );

	$width = ( $size == 'wide' ) ? ' style="width:99%"' : ( ($size == 'full') ? ' style="width:100%"' : '' );
	
	return '[raw]<div class="opl-feat-box"' . $width . '><h3 class="opl-feat-title-' . $color . '">' . $title . '</h3><div>[/raw]' . do_shortcode($content) . '[raw]</div></div>[/raw]';
}

$opl_ts = 0;
add_shortcode('opl_tabs', 'opl_tabs_handler');
add_shortcode('ez_tabs', 'opl_tabs_handler');
function opl_tabs_handler( $atts, $content = null ) {
	global $opl_ts;
	extract(shortcode_atts(array(), $atts));

	$html = '';
	$html .= '[raw]<div id="opl-tabs">[/raw]';
	$html .= '[raw]<ul class="opl-tab-titles">[/raw]';
	foreach ( $atts as $tab ) {
		$tab_ID = 'opl-tab-' . $opl_ts++;
		$html .= '[raw]<li><a href="#" rel="' . $tab_ID . '" class="opl-tab"><span>' . $tab . '</span></a></li>[/raw]';
	}
	
	$html .= '[raw]</ul>[/raw]';
	$html .= '[raw]<div class="clearfix"></div>[/raw]';
	$html .= '[raw]<ul class="opl-tab-contents">[/raw]' . do_shortcode($content) . '[raw]</ul>[/raw]';
	$html .= '[raw]</div>[/raw]';
	
	return $html;
}

$opl_tc = 0;
add_shortcode('opl_tab', 'opl_tab_handler');
add_shortcode('ez_tab', 'opl_tab_handler');
function opl_tab_handler( $atts, $content = null ) {
	global $opl_tc;

	$tab_ID = 'opl-tab-' . $opl_tc++;
	
	$html = '';
	$html .= '[raw]<li id="' . $tab_ID . '" class="opl-tab-content">[/raw]' . do_shortcode($content) . '[raw]</li>[/raw]';
	
	return $html;
}

add_shortcode('opl_columns', 'opl_columns_handler');
add_shortcode('ez_columns', 'opl_columns_handler');
function opl_columns_handler( $atts, $content = null ) {
	$cols = '';
	$cols .= '[raw]<div class="opl-columns">[/raw]' . "\n";
	$cols .= do_shortcode($content);
	$cols .= "\n" . '[raw]<div class="clearfix"></div>[/raw]' . "\n";
	$cols .= "\n" . '[raw]</div>[/raw]' . "\n";
	return $cols;
}

add_shortcode('opl_col', 'opl_col_handler');
add_shortcode('ez_col', 'opl_col_handler');
function opl_col_handler( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'width' => '250',
		'last' => 'no'
	), $atts ) );

	$px = ( stristr($width, '%') ) ? '' : 'px';
	$last_class = ( $last == 'yes' ) ? ' last-col' : '';
	$col = '[raw]<div class="opl-col' . $last_class . '" style="width:' . $width . $px . '">[/raw]' . do_shortcode($content) . '[raw]</div>[/raw]';
	return $col;
}

add_shortcode('opl_two', 'opl_two_handler');
add_shortcode('ez_two', 'opl_two_handler');
function opl_two_handler( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'width' => '49%'
	), $atts ) );

	$px = ( stristr($width, '%') ) ? '' : 'px';
	$col = '[raw]<div class="opl-col" style="width:' . $width . $px . '">[/raw]' . do_shortcode($content) . '[raw]</div>[/raw]';
	return $col;
}

add_shortcode('opl_two_last', 'opl_two_last_handler');
add_shortcode('ez_two_last', 'opl_two_last_handler');
function opl_two_last_handler( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'width' => '49%'
	), $atts ) );

	$px = ( stristr($width, '%') ) ? '' : 'px';
	$col = '[raw]<div class="opl-col last-col" style="width:' . $width . $px . '">[/raw]' . do_shortcode($content) . '[raw]</div>[/raw]' . "\n";
	$col .= '[raw]<div class="clearfix"></div>[/raw]';
	
	return $col;
}

add_shortcode('opl_one_third', 'opl_three_handler');
add_shortcode('opl_three', 'opl_three_handler');
add_shortcode('ez_one_third', 'opl_three_handler');
add_shortcode('ez_three', 'opl_three_handler');
function opl_three_handler( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'width' => '32%'
	), $atts ) );

	$px = ( stristr($width, '%') ) ? '' : 'px';
	$col = '[raw]<div class="opl-col" style="width:' . $width . $px . '">[/raw]' . do_shortcode($content) . '[raw]</div>[/raw]';
	return $col;
}

add_shortcode('opl_one_third_last', 'opl_three_last_handler');
add_shortcode('opl_three_last', 'opl_three_last_handler');
add_shortcode('ez_one_third_last', 'opl_three_last_handler');
add_shortcode('ez_three_last', 'opl_three_last_handler');
function opl_three_last_handler( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'width' => '32%'
	), $atts ) );

	$px = ( stristr($width, '%') ) ? '' : 'px';
	$col = '[raw]<div class="opl-col last-col" style="width:' . $width . $px . '">[/raw]' . do_shortcode($content) . '[raw]</div>[/raw]' . "\n";
	$col .= '[raw]<div class="clearfix"></div>[/raw]';
	
	return $col;
}

add_shortcode('opl_one_fourth', 'opl_four_handler');
add_shortcode('opl_four', 'opl_four_handler');
add_shortcode('ez_one_fourth', 'opl_four_handler');
add_shortcode('ez_four', 'opl_four_handler');
function opl_four_handler( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'width' => '23.5%'
	), $atts ) );

	$px = ( stristr($width, '%') ) ? '' : 'px';
	$col = '[raw]<div class="opl-col" style="width:' . $width . $px . '">[/raw]' . do_shortcode($content) . '[raw]</div>[/raw]';
	return $col;
}

add_shortcode('opl_one_fourth_last', 'opl_four_last_handler');
add_shortcode('opl_four_last', 'opl_four_last_handler');
add_shortcode('ez_one_fourth_last', 'opl_four_last_handler');
add_shortcode('ez_four_last', 'opl_four_last_handler');
function opl_four_last_handler( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'width' => '23.5%'
	), $atts ) );

	$px = ( stristr($width, '%') ) ? '' : 'px';
	$col = '[raw]<div class="opl-col last-col" style="width:' . $width . $px . '">[/raw]' . do_shortcode($content) . '[raw]</div>[/raw]' . "\n";
	$col .= '[raw]<div class="clearfix"></div>[/raw]';
	
	return $col;
}

add_shortcode('opl_five', 'opl_five_handler');
add_shortcode('ez_five', 'opl_five_handler');
function opl_five_handler( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'width' => '18.4%'
	), $atts ) );

	$px = ( stristr($width, '%') ) ? '' : 'px';
	$col = '[raw]<div class="opl-col" style="width:' . $width . $px . '">[/raw]' . do_shortcode($content) . '[raw]</div>[/raw]';
	return $col;
}

add_shortcode('opl_five_last', 'opl_five_last_handler');
add_shortcode('ez_five_last', 'opl_five_last_handler');
function opl_five_last_handler( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'width' => '18.4%'
	), $atts ) );

	$px = ( stristr($width, '%') ) ? '' : 'px';
	$col = '[raw]<div class="opl-col last-col" style="width:' . $width . $px . '">[/raw]' . do_shortcode($content) . '[raw]</div>[/raw]' . "\n";
	$col .= '[raw]<div class="clearfix"></div>[/raw]';
	
	return $col;
}

add_shortcode('opl_six', 'opl_six_handler');
add_shortcode('ez_six', 'opl_six_handler');
function opl_six_handler( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'width' => '15%'
	), $atts ) );

	$px = ( stristr($width, '%') ) ? '' : 'px';
	$col = '[raw]<div class="opl-col" style="width:' . $width . $px . '">[/raw]' . do_shortcode($content) . '[raw]</div>[/raw]';
	return $col;
}

add_shortcode('opl_six_last', 'opl_six_last_handler');
add_shortcode('ez_six_last', 'opl_six_last_handler');
function opl_six_last_handler( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'width' => '15%'
	), $atts ) );

	$px = ( stristr($width, '%') ) ? '' : 'px';
	$col = '[raw]<div class="opl-col last-col" style="width:' . $width . $px . '">[/raw]' . do_shortcode($content) . '[raw]</div>[/raw]' . "\n";
	$col .= '[raw]<div class="clearfix"></div>[/raw]';
	
	return $col;
}

add_shortcode('opl_three_fourth', 'opl_three_fourth_handler');
add_shortcode('ez_three_fourth', 'opl_three_fourth_handler');
function opl_three_fourth_handler( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'width' => '74%'
	), $atts ) );

	$px = ( stristr($width, '%') ) ? '' : 'px';
	$col = '[raw]<div class="opl-col" style="width:' . $width . $px . '">[/raw]' . do_shortcode($content) . '[raw]</div>[/raw]';
	return $col;
}

add_shortcode('opl_three_fourth_last', 'opl_three_fourth_last_handler');
add_shortcode('ez_three_fourth_last', 'opl_three_fourth_last_handler');
function opl_three_fourth_last_handler( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'width' => '74%'
	), $atts ) );

	$px = ( stristr($width, '%') ) ? '' : 'px';
	$col = '[raw]<div class="opl-col last-col" style="width:' . $width . $px . '">[/raw]' . do_shortcode($content) . '[raw]</div>[/raw]' . "\n";
	$col .= '[raw]<div class="clearfix"></div>[/raw]';
	
	return $col;
}

add_shortcode('opl_two_third', 'opl_two_third_handler');
add_shortcode('ez_two_third', 'opl_two_third_handler');
function opl_two_third_handler( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'width' => '65.33%'
	), $atts ) );

	$px = ( stristr($width, '%') ) ? '' : 'px';
	$col = '[raw]<div class="opl-col" style="width:' . $width . $px . '">[/raw]' . do_shortcode($content) . '[raw]</div>[/raw]';
	return $col;
}

add_shortcode('opl_two_third_last', 'opl_two_third_last_handler');
add_shortcode('ez_two_third_last', 'opl_two_third_last_handler');
function opl_two_third_last_handler( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'width' => '65.33%'
	), $atts ) );

	$px = ( stristr($width, '%') ) ? '' : 'px';
	$col = '[raw]<div class="opl-col last-col" style="width:' . $width . $px . '">[/raw]' . do_shortcode($content) . '[raw]</div>[/raw]' . "\n";
	$col .= '[raw]<div class="clearfix"></div>[/raw]';
	
	return $col;
}

$opl_pi = 0;
add_shortcode('opl_popup', 'opl_popup_handler');
add_shortcode('ez_popup', 'opl_popup_handler');
function opl_popup_handler( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'type' => 'image',
		'text' => '',
		'thumb_url' => '',
		'width' => '',
		'height' => ''
	), $atts ) );

	global $opl_pi;
	
	$pop_width = ( $width != '' && $width > 0 ) ? ', width:"' . $width . '"' : ', width:"600"';
	$pop_height = ( $height != '' && $height > 0 ) ? ', height:"' . $height . '"' : '';
	
	$innerWidth = $innerHeight = '';
	if ( $type == 'youtube' || $type == 'vimeo' ) {
		$innerWidth = ( $width != '' && $width > 0 ) ? ', innerWidth:"' . $width . '"' : ', innerWidth:"640"';
		$innerHeight = ( $height != '' && $height > 0 ) ? ', innerHeight:"' . $height . '"' : ', innerHeight:"360"';
	}
	
	$popup = '';
	$popup .= '<a href="#" id="opl-pop-' . $opl_pi . '" class="opl-colorbox">';
	
	if ( $thumb_url != '' )
		$popup .= '<img src="' . $thumb_url . '" border="0" /><br />';
	
	if ( $text != '' )
		$popup .= stripslashes($text);
	
	$popup .= '</a>';
	
	if ( $type == 'content' )
		$popup .= '[raw]<div id="opl-inline-' . $opl_pi . '" style="display:none;"><div style="padding:30px 20px 20px 20px">[/raw]' . do_shortcode($content) . '[raw]</div></div>[/raw]';
	
	$yt_url = '';
	if ( $type == 'youtube' ) {
		$youtube_id = opl_get_youtube_id($content);
		$yt_url = 'http://www.youtube.com/embed/' . $youtube_id . '?autoplay=1&amp;rel=0&amp;wmode=transparent';
	}
	
	$vm_url = '';
	if ( $type == 'vimeo' ) {
		$vimeo_id = opl_get_vimeo_id($content);
		$vm_url = 'http://player.vimeo.com/video/' . $vimeo_id . '?autoplay=1&amp;title=0&amp;byline=0&amp;portrait=0';
	}
	
	$popup .= '<script type="text/javascript">';
	$popup .= 'jQuery(document).ready(function($){';
	
	if ( $type == 'content' ) {
		$popup .= 'var icontent = $("#opl-inline-' . $opl_pi . '").html();';
		$popup .= '$("#opl-pop-' . $opl_pi . '").colorbox({html:icontent' . $pop_width . $pop_height . '});';
	} else if ( $type == 'image' ) {
		$popup .= '$("#opl-pop-' . $opl_pi . '").colorbox({photo:true, href:"' . $content . '"});';
	} else if ( $type == 'youtube' ) {
		$popup .= '$("#opl-pop-' . $opl_pi . '").colorbox({iframe:true, href:"' . $yt_url . '"' . $innerWidth . $innerHeight . '});';
	} else if ( $type == 'vimeo' ) {
		$popup .= '$("#opl-pop-' . $opl_pi . '").colorbox({iframe:true, href:"' . $vm_url . '"' . $innerWidth . $innerHeight . '});';
	}
	
	$popup .= '});';
	$popup .= '</script>';
	
	$opl_pi++;
	return $popup;
}

add_shortcode('opl_btn', 'opl_btn_handler');
add_shortcode('ez_btn', 'opl_btn_handler');
function opl_btn_handler( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'color' => 'grey',
		'url' => 'http://',
		'target' => '_self'
	), $atts ) );

	$button = '<a href="' . $url . '" target="' . $target . '" class="opl-btn btn-' . $color . '"><span>' . $content . '</span></a>';
	return $button;
}

add_shortcode('opl_big_btn', 'opl_big_btn_handler');
add_shortcode('ez_big_btn', 'opl_big_btn_handler');
function opl_big_btn_handler( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'color' => 'grey',
		'url' => 'http://',
		'target' => '_self',
		'circle' => 'yes'
	), $atts ) );

	$circle_class = ( $color == 'yellow' || $color == 'orange' || $color == 'red' ) ? 'blue' : 'red';
	$button = '';
	if ( $circle == 'yes' )
		$button .= "\n" . '<span class="opl-circle-' . $circle_class . '">';
	$button .= '<a href="' . $url . '" target="' . $target . '" class="opl-big-btn btn-big-' . $color . '"><span>' . $content . '</span></a>';
	
	if ( $circle == 'yes' )
		$button .= '</span>';
	return $button;
}

add_shortcode('opl_video', 'opl_video_handler');
add_shortcode('ez_video', 'opl_video_handler');
function opl_video_handler( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'url' => '',
		'alturl' => '',
		'player' => 'flowplayer',
		'width' => '640',
		'height' => '360',
		'autoplay' => 0,
		'controls' => 1,
		'autohide' => 1,
		'splash' => ''
	), $atts ) );

	$video = array();
	$video['video_url'] = $url;
	$video['ivideo_url'] = $alturl;
	$video['video_width'] = $width;
	$video['video_height'] = $height;
	$video['autoplay'] = $autoplay;
	$video['autohide'] = $autohide;
	$video['disable_control'] = ( $controls == 1 ) ? 0 : 1;
	$video['video_scr'] = $splash;
	
	$show_video = '<div class="opl-vid-shadow" style="margin-bottom:25px; max-width:' . $width . 'px; max-height:' . $height . 'px">';
	if ( $player == 'flowplayer' ) {
		$show_video .= opl_flowplayer( $video );
	} else if ( $player == 'jwplayer' ) {
		$show_video .= opl_jwplayer( $video );
	}
	$show_video .= '</div>';
	unset($video);
	
	return opl_clean_wpautop($show_video);
}

add_shortcode('opl_youtube', 'opl_youtube_handler');
add_shortcode('ez_youtube', 'opl_youtube_handler');
function opl_youtube_handler( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'url' => '',
		'width' => '640',
		'height' => '360',
		'privacy' => 'no',
		'autoplay' => 0,
		'controls' => 1,
		'autohide' => 2,
		'loop' => 0,
		'ssl' => 'no'
	), $atts ) );

	$youtube = '';
	if ( $url == '' )
		return '';
	
	$youtube_id = opl_get_youtube_id($url);
	if ( $youtube_id == '' )
		return '';
	
	$autoplay = (int) $autoplay;
	$autohide = (int) $autohide;
	$controls = (int) $controls;
	$loop = (int) $loop;
	
	$proto = ( $ssl == 'yes' ) ? 'https://' : 'http://';
	$domain = ( $privacy == 'yes' ) ? 'www.youtube-nocookie.com' : 'www.youtube.com';
	
	$embed_url = $proto . $domain . '/embed/' . $youtube_id . '?rel=0';
	$embed_url .= ( $autohide != 2 ) ? '&amp;autohide=' . $autohide : '';
	$embed_url .= ( $autoplay == 1 ) ? '&amp;autoplay=' . $autoplay : '';
	$embed_url .= ( $controls == 0 ) ? '&amp;controls=' . $controls : '';
	$embed_url .= ( $loop == 1 ) ? '&amp;loop=' . $loop : '';
	$embed_url .= '&amp;wmode=transparent';
	
	$youtube .= '<div style="max-width:' . $width . 'px; margin:5px auto 15px auto;" class="opl-youtube opl-vid-wrap opl-vid-shadow">';
	$youtube .= '<iframe width="' . $width . '" height="' . $height . '" src="' . $embed_url . '" frameborder="0" allowfullscreen></iframe>';
	$youtube .= '</div>';
	
	return $youtube;
}

add_shortcode('opl_viral_download', 'opl_viral_download_handler');
add_shortcode('ez_viral_download', 'opl_viral_download_handler');
function opl_viral_download_handler( $atts ) {
	global $post;
	
	$meta = get_post_meta($post->ID, 'opl_settings', true);
	$viral = opl_isset($meta['viral']);
	$url = opl_isset($viral['viral_download']);
	$color = opl_isset($viral['viral_btnclr']);
	$label = opl_isset($viral['viral_btntxt']);
	
	$body = '<a name="opl_viral_' . $post->ID . '"></a>';
	$body .= '<div style="margin:0 auto 25px auto; width:60%; background:#F5F5F5; border:1px solid #CCC; padding:20px;">';
	$body .= opl_isset($viral['content']);
	
	if ( opl_isset($viral['viral_fb']) == 1 )
		$body .= '<div style="float:left; width:48%; margin-right:2%; margin-bottom:16px; text-align:right;"><strong><span class="opl-shadow-light" style="color:#a7a7a7; font-size:13px;"><em>Share on Facebook:</em></span></strong></div><div style="float:left; width:48%; margin-bottom:16px;"><a href="#" class="opl-fb-lock"><img src="' . OPL_URL . 'images/fb-share.png" border="0" style="vertical-align:middle" /></a></div><div class="clearfix"></div>';
	
	if ( opl_isset($viral['viral_tw']) == 1 )
		$body .= '<div style="float:left; width:48%; margin-right:2%; margin-bottom:16px; text-align:right;"><strong><span class="opl-shadow-light" style="color:#a7a7a7; font-size:13px;"><em>Share on Twitter:</em></span></strong></div><div style="float:left; width:48%; margin-bottom:16px"><a href="' . opl_format_url($post->ID, "opl_ID={$post->ID}&share=twitter&action=tweet") . '"><img src="' . OPL_URL . 'images/tw-share.png" border="0" style="vertical-align:middle" /></a></div><div class="clearfix"></div>';
	
	if ( isset($_COOKIE['__opl_unlock_' . $post->ID]) ) {
		$body .= '<div style="width:90%; margin:10px auto; padding:15px; border-top:2px dashed #E5E5E5; text-align:center">';
		$body .= '<a href="' . $url . '" target="_blank" class="opl-btn btn-' . $color . '"><span>' . $label . '</span></a>';
		$body .= '</div>';
	}

	$body .= '</div>';

	return str_replace(array("<code>", "</code>"), '', $body);
}

add_shortcode('opl_vimeo', 'opl_vimeo_handler');
add_shortcode('ez_vimeo', 'opl_vimeo_handler');
function opl_vimeo_handler( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'url' => '',
		'width' => '640',
		'height' => '360',
		'autoplay' => 0,
		'loop' => 0,
		'portrait' => 1,
		'title' => 1,
		'byline' => 1,
	), $atts ) );

	$vimeo = '';
	if ( $url == '' )
		return '';
	
	$clip_id = opl_get_vimeo_id($url);
	if ( $clip_id == '' )
		return '';
	
	$autoplay = (int) $autoplay;
	$portrait = (int) $portrait;
	$title = (int) $title;
	$byline = (int) $byline;
	$loop = (int) $loop;
	
	$proto = 'http://';
	$domain = 'player.vimeo.com';
	
	$embed_url = $proto . $domain . '/video/' . $clip_id . '?portrait=' . $portrait;
	$embed_url .= ( $autoplay == 1 ) ? '&amp;autoplay=' . $autoplay : '';
	$embed_url .= ( $title == 0 ) ? '&amp;title=' . $title : '';
	$embed_url .= ( $byline == 0 ) ? '&amp;byline=' . $byline : '';
	$embed_url .= ( $loop == 1 ) ? '&amp;loop=' . $loop : '';
	$embed_url .= '&amp;wmode=transparent';
	
	$vimeo .= '<div style="max-width:' . $width . 'px; margin:5px auto 15px auto;" class="opl-vimeo opl-vid-wrap opl-vid-shadow">';
	$vimeo .= '<iframe width="' . $width . '" height="' . $height . '" src="' . $embed_url . '" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowfullscreen></iframe>';
	$vimeo .= '</div>';
	
	return $vimeo;
}

add_shortcode('opl_date', 'opl_date_handler');
add_shortcode('ez_date', 'opl_date_handler');
function opl_date_handler( $atts ) {
$date = '<p>
<script>
// Courtesy of SimplytheBest.net - http://simplythebest.net/scripts/
var mydate=new Date()
var theYear=mydate.getFullYear()
var day=mydate.getDay()
var month=mydate.getMonth()
var daym=mydate.getDate()
if (daym<10)
daym="0"+daym
var dayarray=new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday")
var montharray=new Array("January","February","March","April","May","June","July","August","September","October","November","December")
document.write(dayarray[day]+", "+montharray[month]+" "+daym+", "+theYear)
</script>
</p>';

return $date;
}

function opl_clean_wpautop( $content ) {

   /* Parse nested shortcodes and add formatting. */
    $content = trim( do_shortcode( shortcode_unautop( $content ) ) );

    /* Remove '' from the start of the string. */
    if ( substr( $content, 0, 4 ) == '' )
        $content = substr( $content, 4 );

    /* Remove '' from the end of the string. */
    if ( substr( $content, -3, 3 ) == '' )
        $content = substr( $content, 0, -3 );

    /* Remove any instances of ''. */
    $content = str_replace( array( '<p></p>' ), '', $content );
    $content = str_replace( array( '<p> </p>' ), '', $content );
	$content = str_replace( array("\r", "\n", "\r\n"), '', $content);
	
    return $content;
}