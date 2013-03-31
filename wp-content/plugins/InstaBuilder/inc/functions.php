<?php if ( !defined('ABSPATH') ) die('No direct access');
function opl_document_header() {
	if ( defined('PARENT_THEME_NAME') && PARENT_THEME_NAME == 'Genesis' ) {
		do_action( 'genesis_title' );
	} else if ( defined('THESIS_LIB') && class_exists('thesis_head') ) {
		$thesis_title = new thesis_head;
		$thesis_title->title();
		$thesis_title->output();
	} else if ( function_exists('catalyst_site_title') ) {
		catalyst_site_title();
	} else {
?>
<title><?php wp_title(''); ?></title>
<?php } ?>
<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<meta name="HandheldFriendly" content="True" />
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<!-- Adding "maximum-scale=1" fixes the Mobile Safari auto-zoom bug: http://filamentgroup.com/examples/iosScaleBug/ -->
<?php
	if ( defined('PARENT_THEME_NAME') && PARENT_THEME_NAME == 'Genesis' ) do_action( 'genesis_meta' );
	if ( defined('THESIS_LIB') && class_exists('thesis_head') ) {
		$thesis_head = new thesis_head;
		$thesis_head->meta();
		$thesis_head->conditional_styles();
		$thesis_head->stylesheets();
		$thesis_head->links();
		$thesis_head->scripts();
		$thesis_head->output();
	}
	if ( function_exists('catalyst_meta') ) catalyst_meta();
	wp_head();
}

function opl_oto_check($oto, $oto_redir) {
	global $post;
	
	if ( $oto != 1 )
		return;
	
	if ( isset($_COOKIE['__opl_oto_' . $post->ID]) ) {
		wp_redirect($oto_redir);
		exit;
	} else {
		add_action('wp_footer', 'opl_oto_cookie');
	}
}

function opl_oto_cookie() {
	global $post;
	
	$rand = md5($post->ID . time());
?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery.cookie('__opl_oto_<?php echo $post->ID; ?>', '<?php echo $rand; ?>', { expires: 365, path: '<?php echo SITECOOKIEPATH; ?>' });
});
</script>
<?php
}

function opl_social_share( $social ) {
	if ( !is_array($social) )
		return '';
	
	global $post; 
	
	$share = '';
	$share .= ( opl_is_share($social) ) ? '<div id="opl-social-share">' . "\n" : '';
	$share .= ( opl_isset($social['fb_like']) == 1 ) ? '<div class="fb-like" data-send="false" data-layout="box_count" data-width="49" data-show-faces="true" style="width:49px;margin:0 auto 7px auto"></div>' . "\n" : '';
	$share .= ( opl_isset($social['tw_share']) == 1 ) ? '<div style="width:59px;margin:0 auto 7px auto"><script src="http://platform.twitter.com/widgets.js" type="text/javascript"></script><a href="http://twitter.com/share" class="twitter-share-button" data-url="' . get_permalink($post->ID) . '" data-text="' . $post->post_title . '"  data-count="vertical">Tweet</a></div>' : '';
	$share .= ( opl_isset($social['g1_share']) == 1 ) ? '<div style="width:52px;margin:0 auto 7px auto"><script type="text/javascript" src="http://apis.google.com/js/plusone.js"></script><g:plusone size="tall"></g:plusone></div>' : '';
	$share .= ( opl_isset($social['pin_share']) == 1 ) ? '<div style="width:45px;margin:0 auto 7px auto"><a href="http://pinterest.com/pin/create/button/?url=' . urlencode(get_permalink($post->ID)) . '" class="pin-it-button" count-layout="vertical"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a></div>' : '';
	$share .= ( opl_isset($social['lin_share']) == 1 ) ? '<div style="width:62px;margin:0 auto 7px auto"><script src="//platform.linkedin.com/in.js" type="text/javascript"></script><script type="IN/Share" data-url="' . get_permalink($post->ID) . '" data-counter="top"></script></div>' : '';
	$share .= ( opl_isset($social['su_share']) == 1 ) ? '<div style="width:50px;margin:0 auto 7px auto"><su:badge layout="5"></su:badge></div>' : '';
	$share .= ( opl_is_share($social) ) ? '</div>' . "\n\n" : '';
	
	return $share;
}

function opl_is_share( $social ) {
	if ( opl_isset($social['fb_like']) == 1 )
		return true;
	 
	if ( opl_isset($social['tw_share']) == 1 )
		return true;
	 
	if ( opl_isset($social['pin_share']) == 1 )
		return true;
	
	if ( opl_isset($social['g1_share']) == 1 )
		return true;
	
	if ( opl_isset($social['lin_share']) == 1 )
		return true;
	
	if ( opl_isset($social['su_share']) == 1 )
		return true;
	
	return false;
}

add_action('wp_footer', 'opl_share_script');
function opl_share_script() {
	global $post;
	
	$meta = get_post_meta($post->ID, 'opl_settings', true);
	
	if ( opl_isset($meta['enable_opl']) != 1 )
		return;
	
	$social = opl_isset($meta['social_settings']);
?>
<?php if ( opl_isset($social['su_share']) == 1 ) : ?>
<script type="text/javascript">
  (function() {
    var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;
    li.src = 'https://platform.stumbleupon.com/1/widgets.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);
  })();
</script>
<?php endif; ?>

<?php if ( opl_isset($social['pin_share']) == 1 ) : ?>
<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
<?php endif; ?>
<?php
}

function opl_buy_area( $buy_area ) {
	$content = stripslashes($buy_area);
	
	return opl_webtreats_formatter(do_shortcode($content));
}

function opl_delay_script( $delay ) {
	$script = '';
	if ( $delay > 0 ) {
		$script = "
			<script type='text/javascript'>
			jQuery(document).ready(function(){
				setTimeout(function(){
					jQuery('#opl-user-action').show('medium');
					jQuery('#full_width_col').show('medium');
				}, " . $delay ." * 1000);
			});
			</script>
		";
	}
	
	return $script;
}

function opl_video_optin($optin_form, $optin) {
	if ( !is_array($optin) )
		return '';
	
	$html = '<div id="opl-optin-under" style="text-align:center">';
	$html .= '
	<p class="optin_title">' . stripslashes(opl_isset($optin['title'])) . '</p>
	<p>' . stripslashes(opl_isset($optin['text'])) . '</p>';
	$html .= $optin_form;
				
	if ( opl_isset($optin['subs_method_fb']) == 1 ) :
		$html .= '<div class="optin_facebook">';
		if ( opl_isset($optin['fb_text']) != '' ) :
			$html .= '<p class="optin_fb_text">' . stripslashes($optin['fb_text']) . '</p>';
		endif;
		
		$html .= '<button class="opl-facebook-btn" name="opl-connect" id="opl-connect">' . stripslashes(opl_isset($optin['fb_label'])) . '</button>';
		$html .= '</div>';
	endif;
	$html .= '<p class="privacy_notice"><small>' . stripslashes(esc_attr(opl_isset($optin['privacy_text']))) . '</small></p>';
	$html .= '</div>';
	
	return $html;
}

function opl_show_video( $video ) {
	if ( !is_array($video) )
			return '';
	
	$insertion = opl_isset($video['insertion']); 
	switch ($insertion) {
		case 'hosted':
			return opl_hosted_video( $video );
			break;
		case 'embed':
			return opl_embed_video( $video );
			break;
		default:
			return '';
	}
}

function opl_hosted_video( $video ) {
	if ( !is_array($video) )
			return '';
	
	$player = opl_isset($video['video_player']); 
	switch ($player) {
		case 'jw':
			return opl_jwplayer( $video );
			break;
		case 'flow':
		default:
			return opl_flowplayer( $video );
			break;
	}
}

add_action('wp_head', 'opl_load_mediaelement');
function opl_load_mediaelement() {
	global $post;
	require_once( OPL_PATH . 'inc/Mobile_Detect.php');
	$detect = new Mobile_Detect;
	
	if ( !$detect->isMobile() || !$detect->isTablet() ) 
		return;
		
	echo '<link href="' . OPL_URL . 'js/mediaelement/mediaelementplayer.css" rel="stylesheet">';
	echo '<script src="' . OPL_URL . 'js/mediaelement/mediaelement-and-player.min.js"></script>';
}

function opl_mediaelement( $video ) {
	if ( !is_array($video) )
			return '';
	
	$url = opl_isset($video['video_url']);
	$webm = opl_isset($video['ivideo_url']);
	
	// check if mobile video is mp4
	$ext = substr( $url, strripos($url, '.'), strlen($url) );
	$is_mp4 = ( strtolower($ext) == '.mp4' ) ? true : false;
	$ext2 = substr( $webm, strripos($webm, '.'), strlen($webm) );
	$is_webm = ( $webm != '' && strtolower($ext2) == '.webm' ) ? true : false;
	
	if ( !is_mp4 && !is_webm )
		$url = '';
	
	if ( $url == '' )
		return '';
	
	require_once( OPL_PATH . 'inc/Mobile_Detect.php');
	$detect = new Mobile_Detect;
	
	$width = ( opl_isset($video['video_width']) != '' ) ? $video['video_width'] : '640';
	$height = ( opl_isset($video['video_height']) != '' ) ? $video['video_height'] : '360';
	$autoplay = ( opl_isset($video['autoplay']) == 1 ) ? true : false;
	$autohide = ( opl_isset($video['autohide']) == 1 ) ? true : false;
	$disable_control = ( opl_isset($video['disable_control']) == 1 ) ? true : false;
	$splash = ( opl_isset($video['video_scr']) != '' ) ? 'poster="' . trim($video['video_scr']) . '"' : '';
	$ratio = $height / $width;
	
	if ( $detect->isMobile() && $width > 256 ) {
		$width = '256';
		$height = $width * $ratio;
	} else if ( $detect->isTablet() && $width > 640 ) {
		$width = '640';
		$height = $width * $ratio;
	}
	
	$controls = ( $disable_control ) ? 'controls="controls"' : '';
	$html5 = '
	<video id="opl-html5-video" class="opl-html5" ' . $controls . ' preload="auto" width="' . $width . '" height="' . $height . '" ' . $splash . '>
  		<source src="' . $url . '" type="video/mp4">
  	';
	
	$html5 = ( $is_webm ) ? '<source src="' . $webm . '" type="video/webm">' : '';
	$html5 .= '
	</video>
	<script>
	jQuery("#opl-html5-video").mediaelementplayer(/* Options */);
	</script>
	';
	
	return $html5;
}

function opl_flowplayer( $video ) {
	if ( !is_array($video) )
			return '';
	
	require_once( OPL_PATH . 'inc/Mobile_Detect.php');
	$detect = new Mobile_Detect;
	
	if ( $detect->isMobile() || $detect->isTablet() ) {
		if ( !$detect->isiOS() )
			return opl_mediaelement( $video );
	}
	
	$url = opl_isset($video['video_url']);
	
	if ( $url == '' )
		return '';
	
	$width = ( opl_isset($video['video_width']) != '' ) ? $video['video_width'] : '640';
	$height = ( opl_isset($video['video_height']) != '' ) ? $video['video_height'] : '360';
	$autoplay = ( opl_isset($video['autoplay']) == 1 ) ? 'true' : 'false';
	$autohide = ( opl_isset($video['autohide']) == 1 ) ? 'true' : 'false';
	$disable_control = ( opl_isset($video['disable_control']) == 1 ) ? true : false;
	$splash = trim( opl_isset($video['video_scr']) );
	$ratio = $height / $width;
	
	if ( $detect->isMobile() && $width > 256 ) {
		$width = '256';
		$height = $width * $ratio;
	} else if ( $detect->isTablet() && $width > 640 ) {
		$width = '640';
		$height = $width * $ratio;
	}
	
	$flow = '';
	$flow .= '<script type="text/javascript" src="' . OPL_URL . 'js/flowplayer/flowplayer-3.2.9.min.js"></script>' . "\n";
	$flow .= '<script type="text/javascript" src="' . OPL_URL . 'js/flowplayer/flowplayer.ipad-3.2.8.min.js"></script>' . "\n";
	$flow .= '<div id="player" style="display:inline-block; width:' . $width . 'px; height:' . $height . 'px"></div>' . "\n\n";
	
	$flow .= '
	<script type="text/javascript">
	$f("player", "' . OPL_URL . 'js/flowplayer/flowplayer-3.2.10.swf", {
		playlist: [
	';

	if ( $splash != '' ) {
		$flow .= '
			{
				url: "' . $splash . '", 
				scaling: "orig"
			},
		';
	}

	$flow .= '			
			{
				url: "' . $url . '",
				scaling: "scale",
				autoPlay: ' . $autoplay . ',
				autoBuffering: true
			}	
		],
	';

	if ( $disable_control ) {
		$flow .= '
		plugins: {
				controls: null
		}
		';
	} else {
		$flow .= '
		plugins: {
			controls: { 
				autoHide: ' . $autohide . '
			}
		}
		';
	}

	$flow .= '}).ipad();' . "\n" . '</script>';
	
	return $flow;
}

function opl_jwplayer( $video ) {
	if ( !is_array($video) )
			return '';
	
	require_once( OPL_PATH . 'inc/Mobile_Detect.php');
	$detect = new Mobile_Detect;
	
	$url = opl_isset($video['video_url']);
	$webm = opl_isset($video['ivideo_url']);
	
	if ( $url == '' )
		return '';
	
	$width = ( opl_isset($video['video_width']) != '' ) ? $video['video_width'] : '640';
	$height = ( opl_isset($video['video_height']) != '' ) ? $video['video_height'] : '360';
	$autoplay = ( opl_isset($video['autoplay']) == 1 ) ? 'true' : 'false';
	$autohide = ( opl_isset($video['autohide']) == 1 ) ? true : false;
	$disable_control = ( opl_isset($video['disable_control']) == 1 ) ? true : false;
	$splash = trim( opl_isset($video['video_scr']) );
	$ratio = $height / $width;
	
	if ( $detect->isMobile() && $width > 256 ) {
		$width = '256';
		$height = $width * $ratio;
	} else if ( $detect->isTablet() && $width > 640 ) {
		$width = '640';
		$height = $width * $ratio;
	}
		
	$jw = '';
	$jwplayer = ( defined('JWPLAYER_FILES_URL') ) ? JWPLAYER_FILES_URL . '/player/player.swf' : get_option('jw_player_location');
	$jwplayerjs = str_replace( 'player.swf', 'jwplayer.js', $jwplayer);
	
	$ext = substr( $url, strripos($url, '.'), strlen($url) );
	$ext2 = substr( $webm, strripos($webm, '.'), strlen($webm) );
	$is_mp4 = ( strtolower($ext) == '.mp4' ) ? true : false;
	$is_webm = ( $webm != '' && strtolower($ext2) == '.webm' ) ? true : false;
	
	if ( $is_mp4 ) {
			$poster = ( $splash != '' ) ? ' poster="' . $splash . '" ' : ' ';
			$jw .= '
			<video' . $poster . 'id="opl-jwplayer" height="' . $height . '" width="' . $width . '">
				<source src="' . $url . '" type="video/mp4">
			';
			
			$jw .= ( $is_webm ) ? '<source src="' . $webm . '" type="video/webm">' . "\n" : '';
			$jw .= '
			</video>
			
			<script type="text/javascript">
    		jwplayer("opl-jwplayer").setup({
        		flashplayer: "' . $jwplayer . '",		
			';

			if ( $disable_control ) {
				$jw .= '
					controlbar: "none",
				';
			} else if ( !$disable_control && $autohide ) {
				$jw .= 'controlbar: "over",';
			} else if ( !$disable_control && !$autohide ) {
				$jw .= 'controlbar: "bottom",';
			}
			$jw .= '
					autostart: ' . $autoplay . '
    		});
			</script>
			';
	} else {
			$jw .= '<div id="opl-jwplayer">Please install JW Player Plugin For WordPress.</div>';

			$jw .= "
			<script type='text/javascript'>
    		var so = new SWFObject('{$jwplayer}', 'playerID', '{$width}', '{$height}', '9');
    		so.addParam('allowfullscreen','true');
    		so.addParam('allowscriptaccess','always');
			so.addParam('wmode','transparent');
    		so.addVariable('file', '{$url}');
 			so.addVariable('autostart', {$autoplay});
 			\n";
			
			$jw .= ( $disable_control ) ? "so.addVariable('controlbar','none');\n" : '';
			$jw .= ( !$disable_control && $autohide ) ? "so.addVariable('controlbar','over')\n" : '';
			$jw .= ( !$disable_control && !$autohide ) ? "so.addVariable('controlbar','bottom')\n" : '';
			$jw .= ( $autoplay == 'false' && $splash != '' ) ? "so.addVariable('image','{$splash}');\n" : '';
			$jw .= "
			so.addVariable('stretching','fill');
    		so.write('opl-jwplayer');
			</script>
			\n\n";
	}
	
	return $jw;
}

function opl_embed_video( $video ) {
	return '<div class="opl-vid-wrap">' . trim(stripslashes(opl_isset($video['video_code']))) . '</div>';
}

function opl_show_comments( $fb_comment, $dq_comment ) {
	if ( $fb_comment == 1 )
		return true;
	
	if ( $dq_comment == 1 )
		return true;
	
	return false;
}

function opl_comment_title( $title ) {
	$comment_title = '<h3 class="opl-comment-title">' . $title . '</h3>';
	
	return $comment_title;
}

function opl_facebook_comment( $fb_comment_width ) {
	global $post;
	$comment = '';
	$comment .= '<div id="fb_com" style="width:100%; margin:0 0 15px 0">';
	$comment .= '<div class="fb-comments" data-href="' . get_permalink($post->ID) . '" data-num-posts="20" data-width="' . $fb_comment_width . '"></div>';
	$comment .= '</div>';
	return $comment;
}

function opl_disqust_comment() {
	global $post;
	
	$opl = get_option('opl_settings');
	$dq_short = opl_isset($opl['dq_short']);
	
	if ( $dq_short == '' )
		return '';
	
	$disqus = '
		<div id="disqus_thread"></div>
		<script type="text/javascript">
    	/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
    	var disqus_shortname = "' . $dq_short . '"; // required: replace example with your forum shortname
		var disqus_title = "' . esc_attr($post->post_title) . '";
		var disqus_url = "' . get_permalink($post->ID) . '";
		/* var disqus_developer = 1; */
		
    	/* * * DON\'T EDIT BELOW THIS LINE * * */
    	(function() {
        	var dsq = document.createElement("script"); dsq.type = "text/javascript"; dsq.async = true;
        	dsq.src = "http://" + disqus_shortname + ".disqus.com/embed.js";
        	(document.getElementsByTagName("head")[0] || document.getElementsByTagName("body")[0]).appendChild(dsq);
    	})();
		</script>
		<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
		<a href="http://disqus.com" class="dsq-brlink">blog comments powered by <span class="logo-disqus">Disqus</span></a>
	';
	
	return $disqus;
}

if ( !is_admin() ) add_action('init', 'opl_head');
function opl_head() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-cookie', OPL_URL . 'js/jquery.cookie.js');
	wp_enqueue_script('instabuilder', OPL_URL . 'js/instabuilder.js', array('jquery', 'jquery-ui-core'));
	wp_enqueue_script('colorbox', OPL_URL . 'js/colorbox/jquery.colorbox-min.js', array('jquery'));
	wp_enqueue_script('lwt-countdown', OPL_URL . 'js/countdown/jquery.lwtCountdown-1.0.js', array('jquery'));
}

add_action('wp_print_styles', 'opl_main_style');
function opl_main_style() {
	wp_register_style('instabuilder', OPL_URL . 'css/instabuilder.css', array(), '1.0.0', 'all');
	wp_register_style('colorbox', OPL_URL . 'js/colorbox/colorbox.css');
	wp_enqueue_style('instabuilder');
	wp_enqueue_style('colorbox');
}

function opl_display_header( $logo, $topnav, $header_bg = 0 ) {
	if ( $logo == 1 )
		return true;
	
	if ( !empty($topnav) )
		return true;
	
	if ( $header_bg == 1 )
		return true;
	
	return false;
}
function opl_top_nav( $top_nav ) {
	if ( $top_nav == '' )
		return '';

	$opl_top_nav = wp_nav_menu(array( 'menu' => $top_nav, 'container' => 'ul', 'menu_class' => '', 'menu_id' => 'opl_nav', 'fallback_cb' => '', 'echo' => 0 ));
	return $opl_top_nav;
}

function opl_footer_nav( $footer_nav ) {
	if ( $footer_nav == '' )
		return '';

	$opl_foot_nav = wp_nav_menu(array( 'menu' => $footer_nav, 'container' => 'ul', 'menu_class' => '', 'menu_id' => 'foot_nav', 'fallback_cb' => '', 'depth' => 1, 'echo' => 0 ));
	return strip_tags($opl_foot_nav, '<a>');
}

add_action('wp_footer', 'opl_format_footernav');
function opl_format_footernav() {
?>
<script>
jQuery(document).ready(function(){
	jQuery(".footer-nav a:last-child").css('border-right', 'none');

});
</script>
<?php
}

add_action('opl_custom_style', 'opl_custom_background');
function opl_custom_background() {
	global $post;

	if ( !is_page() )
		return;

	$meta = get_post_meta($post->ID, 'opl_settings', true);
	if ( opl_isset($meta['enable_opl']) != 1 )
		return;

	$bg = opl_isset($meta['bg']);
	$css = '';
	
	// Body
	$image_url = opl_isset($bg['bodybg_url']);
	$color = ( opl_isset($bg['bodybg_color']) != '' ) ? '#' . opl_isset($bg['bodybg_color']) : 'transparent';
	$pos = opl_isset($bg['bodybg_pos']);
	$repeat = opl_isset($bg['bodybg_repeat']);
	$size = opl_isset($bg['bodybg_size']);
	$attach = opl_isset($bg['bodybg_att']);
	$body_image = ( $image_url != '' ) ? " url({$image_url}) {$pos} {$repeat} {$attach}" : '';
	
	$body_size = '';
	if ( $repeat == 'no-repeat' && $size == 1 ) {
		$body_size = "
			background-size: cover !important;
  			-moz-background-size: cover !important;
		";
	}
	
	if ( opl_isset($bg['opl_bodybg']) == 1 ) {
		$css .= "
		body.opl-canvas {
			background:{$color}{$body_image} !important;
			{$body_size}
		}
		
		#out-wrapper,
		#wrapper,
		#footer-background,
		#footer-content {
			background-color:transparent;
			background-image:none !important;
			border:none !important;
		}
		
		";
	}
	
	// Header	
	$image_url = opl_isset($bg['headerbg_url']);
	$color = ( opl_isset($bg['headerbg_color']) != '' ) ? '#' . opl_isset($bg['headerbg_color']) : 'transparent';
	$pos = opl_isset($bg['headerbg_pos']);
	$repeat = opl_isset($bg['headerbg_repeat']);
	$height = opl_isset($bg['headerbg_height']);
	$selector = ( opl_isset($bg['headerbg_wide']) == 1 ) ? '#opl-header-bg' : '#opl-header';
	$header_image = ( $image_url != '' ) ? " url({$image_url}) {$pos} {$repeat} " : '';
	
	if ( opl_isset($bg['opl_headerbg']) == 1 ) {
		$css .= "
		{$selector} {
			background:{$color}{$header_image}!important;
			height: {$height}px;
			border:none !important;
		}
		
		#opl-header, #opl-logo {
			padding:0 !important;
			height: {$height}px;
		}

		#opl-logo {
			width:100%;
			position:relative;
			display:block;
			vertical-align:middle !important;
		}

		#opl-top-nav {
			top:25px !important;
		}
		";
	}

	if ( $css == '' )
		return;
	
	echo "\n<style type='text/css'>\n";
	echo $css;
	echo "\n</style>\n";
}

add_action('wp_head', 'opl_header_code', 20);
function opl_header_code() {
	if ( !is_page() )
		return;
	
	global $post;
	
	$meta = get_post_meta($post->ID, 'opl_settings', true);
	if ( opl_isset($meta['enable_opl']) != 1 )
		return;
	
	$header_script = '';
	$header_script .= trim(stripslashes(addslashes(opl_isset($meta['head_code']))));
	ob_start();
	eval('?>' . $header_script . '<?php ');
	$output = ob_get_contents();
	ob_end_clean();

	echo $output;
}

add_action('opl_body', 'opl_body_code', 20);
function opl_body_code() {
	if ( !is_page() )
		return;
	
	global $post;
	
	$meta = get_post_meta($post->ID, 'opl_settings', true);
	if ( opl_isset($meta['enable_opl']) != 1 )
		return;
	
	$body_script = '';
	$body_script .= trim(stripslashes(addslashes(opl_isset($meta['body_code']))));
	ob_start();
	eval('?>' . $body_script . '<?php ');
	$output = ob_get_contents();
	ob_end_clean();

	echo $output;
}

add_action('wp_footer', 'opl_footer_code', 20);
function opl_footer_code() {
	if ( !is_page() )
		return;
	
	global $post;
	
	$meta = get_post_meta($post->ID, 'opl_settings', true);
	if ( opl_isset($meta['enable_opl']) != 1 )
		return;
	
	$footer_script = '';
	$footer_script .= trim(stripslashes(addslashes(opl_isset($meta['footer_code']))));
	ob_start();
	eval('?>' . $footer_script . '<?php ');
	$output = ob_get_contents();
	ob_end_clean();

	echo $output;
}

add_action('wp_footer', 'opl_smart_optin_cookie');
function opl_smart_optin_cookie() {
	global $post;

	if ( !is_page() )
		return;

	$meta = get_post_meta($post->ID, 'opl_settings', true);

	if ( opl_isset($meta['enable_opl']) != 1 )
		return;

	if ( opl_isset($meta['type']) != 'front' )
		return;
	
	$optin = opl_isset($meta['optin']);
	
	if ( opl_isset($optin['smart_optin']) != 1 )
		return;
	
	$redirect_url = get_permalink(opl_isset($optin['smart_page']));
?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery("#opl-ar-submit, .opl-facebook-btn").click(function(){
			jQuery.cookie('__opl_gate_<?php echo $post->ID; ?>', 1, { expires: 365, path: '<?php echo SITECOOKIEPATH; ?>' });
		});
	});
</script>

<?php
}

add_action('template_redirect', 'opl_smart_optin_check', 2);
function opl_smart_optin_check() {
	if ( isset($_GET['opl_ID']) && isset($_GET['opl_list']) ) {
		global $post;
		
		$post_id = (int) $_GET['opl_ID'];
		if ( ( $meta = get_post_meta($post_id, 'opl_settings', true) ) === FALSE ) {
			wp_redirect(get_permalink($post->ID));
			exit;
		}
		
		if ( opl_isset($meta['enable_opl']) != 1 ) {
			wp_redirect(get_permalink($post->ID));
			exit;
		}
		
		$optin = opl_isset($meta['optin']);
		if ( opl_isset($optin['smart_optin']) != 1 )
			return;
		
		if ( isset($_COOKIE['__opl_gate_' . $post_id]) ) 
			@setcookie( '__opl_subscribed_' . $post_id, $_GET['opl_list'], time()+86400*365, SITECOOKIEPATH );
		
		wp_redirect(get_permalink($post->ID));
		exit;
	}
}

add_action('template_redirect', 'opl_smart_optin_redirect', 1);
function opl_smart_optin_redirect() {
	global $post;
	
	if ( !is_object($post) )
		return;
	
	if ( isset($_COOKIE['__opl_subscribed_' . $post->ID]) ) {
		$meta = get_post_meta($post->ID, 'opl_settings', true);
		
		if ( opl_isset($meta['enable_opl']) != 1 )
			return;
		
		$optin = opl_isset($meta['optin']);
		if ( opl_isset($optin['smart_optin']) != 1 )
			return;
			
		$redirect_url = get_permalink(opl_isset($optin['smart_page']));
		wp_redirect($redirect_url);
		exit;
	}
}

add_action('template_redirect', 'opl_smart_optin_refuse', 5);
function opl_smart_optin_refuse() {
	if ( !is_page() )
		return;
	
	global $post;
	if ( ( $smart = get_post_meta($post->ID, 'opl_smart_settings', true) ) === FALSE )
		return;
	
	// Check the squeeze page settings first...
	$squeeze_id = opl_isset($smart['squeeze_id']);
	$squeeze_meta = get_post_meta($squeeze_id, 'opl_settings', true);
	
	if ( opl_isset($squeeze_meta['enable_opl']) != 1 )
		return;
	
	if ( opl_isset($squeeze_meta['type']) != 'front' )
		return;
	
	$squeeze_optin = opl_isset($squeeze_meta['optin']);
	if ( opl_isset($squeeze_optin['smart_optin']) != 1 )
			return;
	
	if ( $post->ID != opl_isset($squeeze_optin['smart_page']) )
		return;
	
	// Check this page settings first...
	$meta = get_post_meta($post->ID, 'opl_settings', true);	
	if ( opl_isset($meta['enable_opl']) == 1 && opl_isset($meta['type']) == 'front' )
		return;
	
	if ( !isset($_COOKIE['__opl_subscribed_' . $squeeze_id]) ) {
		$redirect_url = get_permalink(opl_isset($squeeze_id));
		wp_redirect($redirect_url);
		exit;
	}
}

function opl_optin_form( $resp, $method, $optin, $mode = 'simple' ) {
	if ( $resp == '' )
		return '';
	
	$html = '';
	if ( $mode == 'advanced' ) {
		$html = opl_optin_form_advanced( $resp, $method, $optin );
	} else {
		$html = opl_optin_form_simple( $resp, $method, $optin );
	}
	
	return $html;
}

function opl_optin_form_simple( $resp, $method, $optin ) {
	if ( $resp == '' )
		return '';
	
	$html = '';
	$html .= '<form method="post" id="opl-ar-submit" action="' . opl_isset($resp['action']) . '">' . "\n";
	if ( isset($resp['fields']) && is_array($resp['fields']) && count($resp['fields']) > 0 ) {
		foreach ( $resp['fields'] as $k => $v ) {
			$field_id = ( stristr( $k, 'mail') || stristr( $k, 'from') ) ? 'opl_email' : 'opl_name';
			$field_class = ( stristr( $k, 'mail') || stristr( $k, 'from') ) ? 'opl-email' : 'opl-name';
			if ( $method != 1 )
				$html .= '<input type="hidden" name="' . $k . '" value="' . stripslashes($v) . '" id="' . $field_id . '" class="' . $field_class . '" />' . "\n";
			else
				$html .= '<input type="text" name="' . $k . '" value="' . stripslashes($v) . '" id="' . $field_id . '" class="opl-text-field ' . $field_class . '" onfocus="if ( this.value == \'' . stripslashes($v) . '\') this.value = \'\';" onblur="if ( this.value == \'\') this.value = \'' . stripslashes($v) . '\';" />' . "\n";
		}
	}

	if ( isset($resp['hiddens']) && is_array($resp['hiddens']) && count($resp['hiddens']) > 0 ) {
		foreach ( $resp['hiddens'] as $k => $v ) {
			$html .= '<input type="hidden" name="' . $k . '" value="' . $v . '" />' . "\n";
		}
	}

	if ( $method == 1 ) {
		if ( opl_isset($optin['btn_type']) == 'text' ) {
			$html .= '<input type="submit" name="opl_submit" value="' . stripslashes(opl_isset($optin['button_label'])) . '" class="opl-optin-button opl-button-' . opl_isset($optin['button_color']) . '" />' . "\n";
		} else {
			$btn_img = ( opl_isset($optin['btn_type']) == 'upload' ) ? opl_isset($optin['button_custom']) : OPL_URL . 'images/buttons/' . opl_isset($optin['button_premade']);	
			$html .= '<div style="text-align:center;margin:10px 0;"><input type="image" name="opl_submit" src="' . $btn_img . '" alt="" /></div>';		
		}
	}
	$html .= '</form>';

	return $html;
}

function opl_optin_form_advanced( $resp, $method, $optin ) {
	if ( $resp == '' )
		return '';
	
	$html = '';
	$html .= '<form method="post" id="opl-ar-submit" action="' . opl_isset($resp['action']) . '">' . "\n";
	if ( isset($optin['adv_fields']) && is_array($optin['adv_fields']) && count($optin['adv_fields']) > 0 ) {
		$i = 0;
		$value = opl_isset($resp['fields']);
		foreach ( $optin['adv_fields'] as $field ) {
			if ( $field['show'] == 0 )
				continue;
			$class= '';
			if ( $field['type'] == 'email' ) {
				$class = 'opl-email';
			}if ( $field['type'] == 'first_name' ) {
				$class = 'opl-name';
			}

			if ( $method != 1 )
				$html .= '<input type="hidden" name="' . opl_isset($value[$i]) . '" value="' . stripslashes(opl_isset($field['label'])) . '" class="' . $class . '" />' . "\n";
			else
				$html .= '<input type="text" name="' . opl_isset($value[$i]) . '" value="' . stripslashes(opl_isset($field['label'])) . '" class="opl-text-field ' . $class . '" onfocus="if ( this.value == \'' . stripslashes(opl_isset($field['label'])) . '\') this.value = \'\';" onblur="if ( this.value == \'\') this.value = \'' . stripslashes(opl_isset($field['label'])) . '\';" />' . "\n";
			$i++;
		}
	}

	if ( isset($resp['hiddens']) && is_array($resp['hiddens']) && count($resp['hiddens']) > 0 ) {
		foreach ( $resp['hiddens'] as $k => $v ) {
			$html .= '<input type="hidden" name="' . $k . '" value="' . $v . '" />' . "\n";
		}
	}

	if ( $method == 1 ) {
		if ( opl_isset($optin['btn_type']) == 'text' ) {
			$html .= '<input type="submit" name="opl_submit" value="' . stripslashes(opl_isset($optin['button_label'])) . '" class="opl-optin-button opl-button-' . opl_isset($optin['button_color']) . '" />' . "\n";
		} else {
			$btn_img = ( opl_isset($optin['btn_type']) == 'upload' ) ? opl_isset($optin['button_custom']) : OPL_URL . 'images/buttons/' . opl_isset($optin['button_premade']);	
			$html .= '<div style="text-align:center;margin:10px 0;"><input type="image" name="opl_submit" src="' . $btn_img . '" alt="" /></div>';		
		}
	}
	$html .= '</form>';

	return $html;
}

function opl_extract_fields( $code, $name_label, $email_label ) {
	if ( $code == '' ) return false;

	preg_match('/<form\s[^>]*action=[\'"]([^\'"]+)[\'"]/i', stripslashes( $code ), $form);
	preg_match_all('/<input\s[^>]*type=[\'"]?hidden[^>]*>/i', stripslashes( $code ), $hiddens);
	preg_match_all('/<input\s[^>]*type=([\'"])?(text|email)[^>]*>/i', stripslashes( $code ), $texts);
	
	// Text fields
	$fields = '';
	if ( !empty($texts[0]) ) {
		foreach( $texts[0] as $text ) {
			$name  = opl_extract_attribute( $text, 'name' );

			if ( !is_array($fields) )
				$fields = array();

			$fields[$name] = ( stristr( $name, 'mail') || stristr( $name, 'from') ) ? $email_label : $name_label;
		}
	}

	// Hidden fields
	$values = '';
	if ( !empty($hiddens[0]) ) {
		foreach( $hiddens[0] as $hidden ) {
			$name  = opl_extract_attribute( $hidden, 'name' );
			$value = opl_extract_attribute( $hidden, 'value' );

			if ( !is_array($values) )
				$values = array();

			$values[$name] = $value;
		}
	}

	$post_data['action'] = opl_isset($form[1]);
	$post_data['fields'] = $fields;
	$post_data['hiddens'] = $values;

	return $post_data;
}

function opl_extract_adv_fields( $code ) {
	if ( $code == '' ) return false;

	preg_match('/<form\s[^>]*action=[\'"]([^\'"]+)[\'"]/i', stripslashes( $code ), $form);
	preg_match_all('/<input\s[^>]*type=[\'"]?hidden[^>]*>/i', stripslashes( $code ), $hiddens);
	preg_match_all('/<input\s[^>]*type=([\'"])?(text|email)[^>]*>/i', stripslashes( $code ), $texts);
	
	// Text fields
	$fields = '';
	if ( !empty($texts[0]) ) {
		foreach( $texts[0] as $text ) {
			$name  = opl_extract_attribute( $text, 'name' );

			if ( !is_array($fields) )
				$fields = array();

			$fields[] = $name;
		}
	}

	// Hidden fields
	$values = '';
	if ( !empty($hiddens[0]) ) {
		foreach( $hiddens[0] as $hidden ) {
			$name  = opl_extract_attribute( $hidden, 'name' );
			$value = opl_extract_attribute( $hidden, 'value' );

			if ( !is_array($values) )
				$values = array();

			$values[$name] = $value;
		}
	}

	$post_data['action'] = opl_isset($form[1]);
	$post_data['fields'] = $fields;
	$post_data['hiddens'] = $values;

	return $post_data;
}

function opl_extract_attribute( $field, $attrib ) {
	$remove    = array($attrib . '=', '"', "'", "/>");
	$field     = str_replace("'", "\"", $field);
	$pos       = strpos($field, $attrib . "=");
	$filter    = substr_replace($field, "", 0, $pos);
	$pos2      = strpos($filter, " ");
	$pos2      = ( $pos2 != '' ) ? $pos2 : strpos($filter, ">");
	$attribute = substr_replace($filter, "", $pos2, 1000);
	$attribute = str_replace( $remove, '', $attribute );

	return $attribute;
}

add_action('wp_head', 'opl_load_style');
function opl_load_style() {
	global $post;

	if ( !is_page() )
		return;

	$meta = get_post_meta($post->ID, 'opl_settings', true);
	$header = get_post_meta($post->ID, 'opl_headers', true);
	$social = opl_isset($meta['social_settings']);
	
	$headline = opl_isset($meta['headline']);
	//$font = explode("|", opl_isset($headline['font']));

	//$line_height = opl_isset($headline['size']) + 12;
	//$headline_size = opl_isset($headline['size']);

	$text_logo = opl_isset($header['text_logo']);
	$logo_color = opl_isset($header['logo_color']);
	$logo_size = opl_isset($header['logo_size']);
	$logo_font = explode("|", opl_isset($header['logo_font']));
	$logo_align = opl_isset($header['logo_align']);
	
	$comment_font = explode("|", opl_isset($meta['comment_font']));
	$comment_color = opl_isset($meta['comment_color']);
	$comment_size = opl_isset($meta['comment_size']);
	$comment_line_height = opl_isset($comment_size) + 8;
	
	$social_pos = opl_isset($social['social_pos']);

	if ( opl_is_mobile() && $headline_size > 28 )
		$headline_size = $headline_size - 3;
?>
<style>
<?php if ( opl_isset($_GET['facebook']) == 'true' ) : ?>
html, body {
	max-height:100%;
	overflow:hidden !important;
}
<?php endif; ?>

.opl-headline {
	margin:7px 0 10px 0;
	padding:0;
	font-family: 'Open Sans', sans-serif;
}

.opl-comment-title {
	color: #<?php echo $comment_color; ?> !important;
	font-family: <?php echo opl_isset($comment_font[1]); ?> !important;
	font-size: <?php echo $comment_size; ?>pt !important;
	line-height: <?php echo $comment_line_height; ?>px !important;
	margin-top:15px !important;
	margin-bottom:13px !important;
}

#opl-social-share {
	<?php echo ( ($social_pos == 'left') ? 'padding:10px 4px 3px 14px;' . "\n" : 'padding:10px 8px 3px 7px;' . "\n" ); ?>
	<?php echo $social_pos; ?>: -7px;
}

#opl-logo {
	text-align:<?php echo $logo_align; ?>;
	color: #<?php echo $logo_color; ?> !important;
	font-family: <?php echo opl_isset($logo_font[1]); ?> !important;
	font-size: <?php echo $logo_size; ?>pt !important;
	text-decoration: none !important;
}
.opl-text-logo a {
	color: #<?php echo $logo_color; ?> !important;
	font-family: <?php echo opl_isset($logo_font[1]); ?> !important;
	font-size: <?php echo $logo_size; ?>pt !important;
	text-decoration: none !important;
	text-shadow: 1px 1px 1px #FFFFFF;
	filter: dropshadow(color=#FFFFFF, offx=1, offy=1);
}
</style>
<?php
}

function opl_is_mobile() {
	$strings = array(
	'iPhone',
	'iPod',
	'iPad',
	'iTouch',
	'Sony Reader',
	'Kindle',
	'Nook',
	'PlayStation',
	'Nintendo',
	'Wii',
	'Dell Streak',
	'Dell Axim',
	'HP iPAQ',
	'palmOne',
	'PalmOS',
	'Palm',
	'PalmSource',
	'Pocket PC',
	'Android',
	'O2',
	'Bell Mobility',
	'Rogers',
	'Verizon',
	'Spring',
	'Cingular',
	'T-Mobile',
	'RiM',
	'BenQ',
	'AT&T',
	'Pearl',
	'ARCHOS',
	'Xiino',
	'PIE',
	'NetFront',
	'Plucker',
	'PocketLink',
	'OpenWave',
	'Minimo',
	'ftxBrowser',
	'EudoraWeb',
	'ASTEL',
	'PDXGW',
	'Air-Edge',
	'J-Phone',
	'Vodafone',
	'UP.Browser',
	'KDDI-KC31',
	'KDDI',
	'DoCoMo',
	'AvantGo',
	'Orange',
	'Cricket',
	'bSquare',
	'Nexus One',
	'HTC',
	'LGE',
	'LG',
	'Motorola',
	'MOT',
	'NEC',
	'Nokia',
	'Psion',
	'QTEK',
	'SAGEM',
	'Samsung',
	'SEC',
	'AU-MIC',
	'Sanyo',
	'Siemens',
	'Sharp',
	'Samsung',
	'Ericsson',
	'SonyEricsson',
	'Tear',
	'UCWEB',
	'ZTE',
	'WebPro',
	'ProxiNet',
	'Elaine',
	'BlackBerry'
	);

	$user_agent = opl_isset($_SERVER['HTTP_USER_AGENT']);
	$mobile = false;
	foreach ( $strings as $string ) {
		if ( stripos($user_agent, $string) !== FALSE ) :
			$mobile = true;
			break;
		endif;
	}

	return $mobile;
}

function opl_powered() {
	$opl = get_option('opl_settings');
	$disable = opl_isset($opl['disable_powered']);

	if ( $disable != 1 ) {
		$url = ( opl_isset($opl['aff_url']) !== '' ) ? opl_isset($opl['aff_url']) : 'http://instabuilder.com';
		echo '<p class="opl-powered"><strong>Powered by <a href="' . $url . '" target="_blank" class="opl-powered-logo">InstaBuilder</a></strong></p>';
	}
}

function opl_load_facebook() {
	global $post;
	
	$meta = get_post_meta($post->ID, 'opl_settings', true);
	$opl = get_option('opl_settings');
	
	if ( opl_isset($meta['enable_opl']) != 1 )
		return;
	
	if ( opl_isset($opl['fb_appid']) == '' )
		return '';
?>
<div id="fb-root"></div>
<script>
	window.fbAsyncInit = function() {
    	FB.init({
      		appId      : '<?php echo stripslashes(opl_isset($opl['fb_appid'])); ?>',
      		channelUrl : '<?php echo get_permalink($post->ID); ?>', 
      		status     : true,
      		cookie     : true,
      		xfbml      : true
    	});
    	// Additional initialization code here
    	FB.Canvas.setAutoGrow();
    	if ( jQuery('#fb_com').length > 0 ) {
	    	jQuery(window).resize(function(){
				var newWidth = jQuery('#fb_com').width();
				jQuery('#fb_com').html('<div class="fb-comments" data-href="<?php get_permalink($post->ID); ?>" data-num-posts="20" data-width="' + newWidth + '"></div>');
				FB.XFBML.parse();
			}).resize();
		}
  	};

  	// Load the SDK Asynchronously
  	(function(d){
	     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
	     if (d.getElementById(id)) {return;}
	     js = d.createElement('script'); js.id = id; js.async = true;
	     js.src = "//connect.facebook.net/en_US/all.js";
	     ref.parentNode.insertBefore(js, ref);
   	}(document));
</script>
<?php
}
function opl_facebook_connect( $headline = '' ) {
	global $post;

	$image = opl_facebook_image();
	$desc = strip_tags(str_replace(array("\n", "\r"), ' ', $post->post_content));
	$desc = substr($desc, 0, 160);

	$opl = get_option('opl_settings');
	$meta = get_post_meta($post->ID, 'opl_settings', true);
	$optin = opl_isset($meta['optin']);
	
	$title = ( $headline != '' ) ? trim(strip_tags(stripslashes($headline))) : trim(strip_tags(stripslashes($post->post_title)));
	$title = str_replace(array("\r", "\r\n", "\n"), ' ', $title);
?>
	<script type='text/javascript'>
		function opl_facebook($) {
			var button = $('#opl-connect');
			button.click(function(e){
				$('.opl-optin-button').hide();
				button.hide();
				button.parent().append('<div style="text-align:center"><img src="<?php echo OPL_URL; ?>images/loader.gif" border="0" /></div>');
				FB.getLoginStatus(function(response) {
					if ( response.status == 'connected' ) {
						<?php if ( opl_isset($optin['fb_msg_disable']) == 1 ) { ?>
						opl_facebook_subscribe_nopost($);
						<?php } else { ?>
						opl_facebook_subscribe($);
						<?php  } ?>
					} else {
						opl_facebook_login($);
					}

					e.preventDefault();
				});
			});
		}

		function opl_facebook_login($) {
			FB.login(function(response) {
				if ( response.authResponse ) {
					if ( response.status == 'connected' ) {
						<?php if ( opl_isset($optin['fb_msg_disable']) == 1 ) { ?>
						opl_facebook_subscribe_nopost($);
						<?php } else { ?>
						opl_facebook_subscribe($);
						<?php  } ?>
					}
				}
			}, {scope: 'email,publish_stream'});
		}

		function opl_facebook_subscribe($) {
			FB.api('/me/feed', 'post', {
				link: '<?php echo get_permalink($post->ID); ?>',
				picture : '<?php echo $image; ?>',
				name : '<?php echo wptexturize(esc_attr($title)); ?>',
				caption : '',
				description : '<?php echo wptexturize(esc_attr($desc)); ?>'
			}, function(response) {
				FB.api('/me', function(response) {
					var opl_name  = response.first_name;
					var opl_email = response.email;
					$('.opl-name').val(opl_name);
					$('.opl-email').val(opl_email);
					setTimeout(function(){
						document.getElementById('opl-ar-submit').submit();
					}, 1000);
				});
			});
		}
		
		function opl_facebook_subscribe_nopost($) {
			FB.api('/me', function(response) {
				var opl_name  = response.first_name;
				var opl_email = response.email;
				$('.opl-name').val(opl_name);
				$('.opl-email').val(opl_email);
				setTimeout(function(){
					document.getElementById('opl-ar-submit').submit();
				}, 1000);
			});
		}
		opl_facebook(jQuery);
	</script>
<?php
}

add_filter('language_attributes', 'opl_facebook_attribute', 100);
function opl_facebook_attribute( $content ) {
	if ( preg_match( '/xmlns:fb="(.*)"/', $content ) )
		return $content;
		
	$content .= ' xmlns:fb="http://www.facebook.com/2008/fbml"';
	return $content;
}

add_filter('language_attributes', 'opl_opengraph_attribute', 100);
function opl_opengraph_attribute( $content ) {
	if ( preg_match( '/xmlns:og="(.*)"/', $content ) ) return $content;
  	$content .= ' xmlns:og="http://ogp.me/ns#"';
	return $content;
}

function opl_facebook_image() {
	global $post;
	
	if (isset($post->ID)){
		require_once (ABSPATH . 'wp-includes/post-thumbnail-template.php');
		$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
		$src = wp_get_attachment_image_src( $post_thumbnail_id );
		$image = '';
		if ( has_post_thumbnail($post->ID) ) {
	
				$image = $src[0];
		} else {
				$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );
				$image = opl_isset($matches[1][0]);
		}
	
		return $image;
	}
	
	return false;
}

add_action('wp_head', 'opl_facebook_meta');
function opl_facebook_meta( ) {
	global $post;

	$opl = get_option('opl_settings');

	$image = opl_facebook_image();
	$desc = strip_tags(str_replace(array("\n", "\r"), ' ', $post->post_content));
	$desc = substr($desc, 0, 160);

	$content = '';
	if ( opl_isset($opl['fb_appid']) != '' ) {
		$content .= '<meta property="fb:app_id" content="' . $opl['fb_appid'] . '" />' . "\n";
	}
	
	$content .= '
		<meta property="og:title" content="' . wptexturize(esc_attr(get_the_title($post->ID))) . '"/>
		<meta property="og:description" content="' . wptexturize(esc_attr($desc)) . ' ..." />
		<meta property="og:url" content="' . get_permalink($post->ID) . '"/>
	';

	if ( $image )
		$content .= '<meta property="og:image" content="' . $image . '"/>' . "\n";

	$content .= '
		<meta property="og:type" content="article"/>
		<meta property="og:site_name" content="' . get_bloginfo('name') . '"/>
	';

	echo $content;
}

add_action('wp_footer', 'opl_widget_submit');
function opl_widget_submit(){
?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('.opl-widget-btn').each(function(){
		var $this = jQuery(this);
		$this.click(function(e){
			document.getElementById('opl-widget-submit').submit();
		});
	});
});
</script>
<?php	
}

add_action('wp_footer', 'opl_exit_redirect');
function opl_exit_redirect() {
	if ( !is_page() )
		return;

	global $post;
	
	$meta = get_post_meta($post->ID, 'opl_settings', true);
	if ( opl_isset($meta['enable_opl']) != 1 )
		return;
	
	$exit = opl_isset($meta['exit_settings']);
	if ( opl_isset($exit['opl_exit']) != 1 )
		return;
	
	if ( opl_isset($exit['exit_msg']) == '' )
		return;
	
	$exitmsg = opl_isset(stripslashes($exit['exit_msg']));
	
	if ( $exitmsg != '' ) {
		$remove = array("\n", "\r\n", "\r");
		$exit_msg = str_replace($remove, "+", strip_tags(trim($exitmsg)));
		$exit_msg = str_replace("++", "<%enter%>", $exit_msg);
		$exit_msg = str_replace("<%enter%>", '\n', $exit_msg);
	} else {
		$exit_msg = '';
	}
	
?>
<script type="text/javascript">
var oplPreventExit = false;
var ctrlKeyIsDown = false;
function oplShowExitPage() {
	var oplExitMsg = '<?php echo $exit_msg; ?>';
	var oplExitURL = '<?php echo opl_isset($exit['exit_url']); ?>';
	var oplExitPage = '';
	
	if ( oplPreventExit == false ) {
		window.scrollTo(0,0);
		if ( jQuery.browser.mozilla && parseInt(jQuery.browser.version) >= 2 ) {
			window.alert(oplExitMsg);
		}
			
		oplExitPage = '<div id="opl-exit" align="center">';
		oplExitPage += '<iframe src="' + oplExitURL + '" align="middle" frameborder="0" marginheight="0" marginwidth="0" width="100%" height="100%"></iframe>';
		oplExitPage += '</div>';
		
		oplPreventExit = true;
		
		jQuery('body').html('');
		jQuery('html').css('overflow', 'hidden');
		jQuery('body').css({
			'margin': '0',
			'width': '100%',
			'height': '100%',
			'overflow': 'hidden'
		});
		jQuery('body').append(oplExitPage);
		jQuery('#opl-exit').css({
			'background-color': '#FFFFFF',
			'position': 'fixed',
			'z-index': '9999',
			'width':'100%',
			'height':'100%',
			'top': '0',
			'left': '0',
			'display':'block'
		});
		
		jQuery('iframe').css({
			'display' : 'block',
			'width' : '100%',
			'height': '100%',
			'border' : 'none',
		});
		
		return oplExitMsg;
	}
}

jQuery(document).ready(function() {
	jQuery("a").each(function() {
		var obj = jQuery(this);
		if ( obj.attr('target') != '_blank' ) {
			obj.bind("click", function(){
				oplPreventExit = true;
    		});
		}
	});

	jQuery("form").each(function() {
		var obj = jQuery(this);
		obj.submit(function(){
			oplPreventExit = true;
		});
	});
	
	jQuery('#opl-connect').click(function(){
		oplPreventExit = true;
	});
	
	jQuery(document).keypress(function(e){
		if ( e.keyCode == 116 )
			oplPreventExit = true;
	});
	
	window.onbeforeunload = oplShowExitPage;
});
</script>

<?php
}

function opl_get_youtube_id($url) {
	preg_match('#(\.be/|/embed/|/v/|/watch\?v=)([A-Za-z0-9_-]{5,11})#', $url, $matches);
	if ( isset($matches[2]) && $matches[2] != '' )
     	return $matches[2];
	
	return '';
}

function opl_get_vimeo_id($url) {
	if ( preg_match('~^http://(?:www\.)?vimeo\.com/(?:clip:)?(\d+)~', $url, $match) )
		return $match[1];
	
	return '';
}

function opl_facebook_signed() {
	require_once( OPL_PATH . 'inc/facebook/facebook.php' );
	
	$opl = get_option('opl_settings');
	$fb_appid = trim(opl_isset($opl['fb_appid']));
	$fb_secret = trim(opl_isset($opl['fb_secret']));
	
	if ( $fb_appid == '' || $fb_secret == '' )
		return false;
	
	$facebook = new Facebook(array(
		'appId' => $fb_appid,
		'secret' => $fb_secret
	));

	$signed = $facebook->getSignedRequest();
	
	return $signed;
}

add_action('template_redirect', 'opl_facebook_tab');
function opl_facebook_tab() {
	opl_facebook_tab_save();
	
	if ( opl_isset($_GET['mode']) == 'facebook_tab' ) {
		global $wpdb;
		$opl = get_option('opl_settings');
		$fb_appid = trim(opl_isset($opl['fb_appid']));
	
		if ( isset($_GET['tabs_added']) ) {
			
			echo '<p><strong>A New Facebook Tab has been successfully added.</strong></p>';
			if ( is_array($_GET['tabs_added']) ) :
				foreach ( $_GET['tabs_added'] as $k => $v ) {
					$page_info = json_decode(file_get_contents("https://graph.facebook.com/{$k}"));
    				$url = $page_info->link . '?sk=app_' . $fb_appid;
					echo '<p><a href="' . $url . '">Click here to continue</a></p>';
				}
			endif;
			exit;
		}
		
		$signed = opl_facebook_signed();
		$page = opl_isset($signed['page']);
		$fb_page_id = ( opl_isset($page['id']) != '' ) ? $page['id'] : opl_isset($_POST['opl_fbpageid']);
		
		$qry = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}opl_facebook_tab` WHERE `fb_page_id` = %s", $fb_page_id));
		if ( !$qry && $page['admin'] ) {
			?>
			<!DOCTYPE html>
			<html <?php language_attributes(); ?>>
			<head>
			<meta charset="<?php bloginfo( 'charset' ); ?>" />
			<title>Untitled</title>
			<?php wp_head(); ?>
			</head>
			
			<body>
			<h2>Final Step: Select Page For Your Facebook Tab</h2>
			<form name="opl_fbtab_form" id="opl_fbtab_form" method="post" action="">
				<p>Enable Facebook Reveal Tab: <input type="checkbox" name="opl_fb_tab_reveal" id="opl_fb_tab_reveal" value="1" /></p>
				<p>
					Facebook Tab Content<span class="tab_for_non_fans"> for fans</span> :<br />
					<select name="opl_fb_tab" id="opl_fb_tab" class="widefat">
					<option value=''>[ -- Select Page For Facebook Tab -- ]</option>
					<?php if ( get_pages() ) :
						foreach ( get_pages() as $post ) :
							echo '<option value="' . $post->ID . '">' . $post->post_title . '</option>';
							endforeach; endif;
					?>
					</select>
				</p>
			
				<p class="tab_for_non_fans">Facebook Tab Content for non-fans:<br />
				<select name="opl_fb_tab2" id="opl_fb_tab2" class="widefat">
					<option value=''>[ -- Select Page For Facebook Tab (non-fans) -- ]</option>
					<?php if ( get_pages() ) :
						foreach ( get_pages() as $post ) :
							echo '<option value="' . $post->ID . '">' . $post->post_title . '</option>';
							endforeach; endif;
					?>
					</select>
				</p>
			
				<input type="hidden" name="opl_fbpageid" value="<?php echo $fb_page_id; ?>" />
				<input type="hidden" name="opl_fbtabadmin" value="yes" />
				<?php if ( $page['liked'] ) : echo '<input type="hidden" name="opl_fbtabliked" value="yes" />'; endif; ?>
				<input type="hidden" name="opl_fbtabaction" value="save" />
				<input type="submit" name="opl_fbtabsubmit" value="Save" />
			</form>
			<div class="fb_tab_error" style="color:#cc0000; margin:10px 0"></div>
			<script>
			jQuery(document).ready(function($){
				$('#opl_fb_tab_reveal').click(function(){
					if ( this.checked == true )
						$('.tab_for_non_fans').show();
					else
						$('.tab_for_non_fans').hide();
				});
		
				if ( jQuery('#opl_fb_tab_reveal').is(":checked") )
					$('.tab_for_non_fans').show();
				else
					$('.tab_for_non_fans').hide();
					
				$('#opl_fbtab_form').submit(function(){
					if ( $('#opl_fb_tab').val() == '' ) {
						if ( jQuery('#opl_fb_tab_reveal').is(":checked") )
							$('.fb_tab_error').text('ERROR: Please select a page for the fans.');
						else
							$('.fb_tab_error').text('ERROR: Please select a page.');
						return false;
					}
					
					if ( jQuery('#opl_fb_tab_reveal').is(":checked") && $('#opl_fb_tab2').val() == '' ) {
						$('.fb_tab_error').text('ERROR: Please select a page for the non-fans.');
						return false;	
					}
					
					$('.fb_tab_error').text('');
					return true;
				});
			});
			</script>
			
			</body>
			</html>
			<?php
			exit;
		}
		
		$admin_status = ( $page['admin'] || opl_isset($_POST['opl_fbtabadmin']) == 'yes' ) ? 'yes' : 'no';
		$liked = ( $page['liked'] || opl_isset($_POST['opl_fbtabliked']) == 'yes' ) ? 'yes' : 'no';
		
		if ( $qry->reveal == 1 )
				$content_id = ( $liked == 'yes' ) ? $qry->post_id : $qry->post_id2;
		else
				$content_id = $qry->post_id;
		
		$url = opl_format_url($content_id, 'facebook=true&fb_admin=' . $admin_status . '&fb_page_id=' . $fb_page_id . '&fb_liked=' . $liked);
		
		// echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=' . $url . '">';
		if ( !function_exists('wp_remote_get') )
			require_once(ABSPATH . 'wp-includes/http.php');
		
		$response = wp_remote_get($url);
		if ( !is_wp_error( $response ) )
			echo opl_isset($response['body']);
		
		exit;
	}
}

//add_action('init', 'opl_facebook_tab_save');
function opl_facebook_tab_save(){
		if ( isset($_POST['opl_fbtabaction']) && $_POST['opl_fbtabaction'] == 'save' ) {
			global $wpdb;
			
			$reveal = ( isset($_POST['opl_fb_tab_reveal']) ) ? 1 : 0;
			$new_post_id = (int) $_POST['opl_fb_tab'];
			$new_post_id2 = (int) $_POST['opl_fb_tab2'];
			$fb_page_id = $_POST['opl_fbpageid'];
			
			$data = array(
					'fb_page_id' => $fb_page_id,
					'reveal' => $reveal,
					'post_id' => $new_post_id,
					'post_id2' => $new_post_id2
				);
				
			$count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM `{$wpdb->prefix}opl_facebook_tab` WHERE `fb_page_id` = %s", $fb_page_id));
			if ( $count > 0 ) {
				$wpdb->update($wpdb->prefix . 'opl_facebook_tab', $data, array('fb_page_id' => $fb_page_id));
			} else {
				$wpdb->insert($wpdb->prefix . 'opl_facebook_tab', $data);
			}

			//wp_redirect(opl_format_url(get_bloginfo('siteurl'), 'mode=facebook_tab'));
			//exit;
		}
}

add_action('template_redirect', 'opl_facebook_tab_admin');
function opl_facebook_tab_admin() {
	if ( opl_isset($_GET['facebook']) == 'true') :
		$opl = get_option('opl_settings');
		$fb_appid = trim(opl_isset($opl['fb_appid']));
		$fb_secret = trim(opl_isset($opl['fb_secret']));
	
		if ( $fb_appid == '' || $fb_secret == '' )
			return;

		if ( opl_isset($_GET['fb_admin']) == 'yes' ) {
			add_action('wp_footer', 'opl_facebook_tab_edit');
			add_action('wp_head', 'opl_facebook_tab_script');
		}
	endif;
}

function opl_facebook_tab_edit(){
	global $wpdb;
	
	$qry = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}opl_facebook_tab` WHERE `fb_page_id` = %s", opl_isset($_GET['fb_page_id'])));
	?>
	<div id="fb_tab_edit" style="display:none">
	<form name="opl_fbtab_form" id="opl_fbtab_form" method="post" action="">
		<p>Enable Facebook Reveal Tab: <input type="checkbox" name="opl_fb_tab_reveal" id="opl_fb_tab_reveal" value="1" <?php if ( opl_isset($qry->reveal) == 1 ) echo 'checked="checked" '; ?>/></p>
		<p>
			Facebook Tab Content<span class="tab_for_non_fans"> for fans</span> :<br />
			<select name="opl_fb_tab" id="opl_fb_tab" class="widefat">
			<option value=''>[ -- Select Page For Facebook Tab -- ]</option>
			<?php if ( get_pages() ) :
				foreach ( get_pages() as $post ) :
					$selected = ( opl_isset($qry->post_id) == $post->ID ) ? ' selected="selected" ' : '';
					echo '<option value="' . $post->ID . '"' . $selected . '>' . $post->post_title . '</option>';
				endforeach; endif;
			?>
			</select>
		</p>
			
		<p class="tab_for_non_fans">Facebook Tab Content for non-fans:<br />
			<select name="opl_fb_tab2" id="opl_fb_tab2" class="widefat">
			<option value=''>[ -- Select Page For Facebook Tab (non-fans) -- ]</option>
			<?php if ( get_pages() ) :
				foreach ( get_pages() as $post ) :
					$selected = ( opl_isset($qry->post_id2) == $post->ID ) ? ' selected="selected" ' : '';
					echo '<option value="' . $post->ID . '"' . $selected . '>' . $post->post_title . '</option>';
				endforeach; endif;
			?>
			</select>
		</p>
			
		<input type="hidden" name="opl_fbpageid" value="<?php echo opl_isset($_GET['fb_page_id']); ?>" />
		<?php if ( opl_isset($_GET['fb_admin']) == 'yes' ) : echo '<input type="hidden" name="opl_fbtabadmin" value="yes" />'; endif; ?>
		<?php if ( opl_isset($_GET['fb_liked']) == 'yes' ) : echo '<input type="hidden" name="opl_fbtabliked" value="yes" />'; endif; ?>
		<input type="hidden" name="opl_fbtabaction" value="save" />
		<input type="submit" name="opl_fbtabsubmit" value="Save" />
	</form>
	<div class="fb_tab_error" style="color:#cc0000; margin:10px 0"></div>
	<p style="text-align:right"><a href="#" class="close_tab_settings">[Close]</a></p>
	</div>
		<?php
}

function opl_facebook_tab_script() {
?>
	<script>
	jQuery(document).ready(function($){
		var edit_btn = '<div class="opl_tab_edit"><img src="<?php echo OPL_URL; ?>images/edit.png" style="vertical-align:middle" /> <a href="#" class="opl_open_tab_settings">Settings</a></div>';
		$('body').prepend(edit_btn);
		$('.opl_open_tab_settings').click(function(e){
			$('#fb_tab_edit').css({
				'position' : 'absolute',
				'max-width' : '100%',
				'top' : '0',
				'right' : '0'
			});
			$('#fb_tab_edit').show();
			$('.opl_tab_edit').hide();
			e.preventDefault();
		});
		$('.close_tab_settings').click(function(e){
			$('#fb_tab_edit').hide();
			$('.opl_tab_edit').show();
			e.preventDefault();
		});
		$('#opl_fb_tab_reveal').click(function(){
			if ( this.checked == true )
				$('.tab_for_non_fans').show();
			else
				$('.tab_for_non_fans').hide();
		});
		
		if ( jQuery('#opl_fb_tab_reveal').is(":checked") )
			$('.tab_for_non_fans').show();
		else
			$('.tab_for_non_fans').hide();
			
		$('#opl_fbtab_form').submit(function(){
			if ( $('#opl_fb_tab').val() == '' ) {
				if ( jQuery('#opl_fb_tab_reveal').is(":checked") )
					$('.fb_tab_error').text('ERROR: Please select a page for the fans.');
				else
					$('.fb_tab_error').text('ERROR: Please select a page.');
				return false;
			}
					
			if ( jQuery('#opl_fb_tab_reveal').is(":checked") && $('#opl_fb_tab2').val() == '' ) {
				$('.fb_tab_error').text('ERROR: Please select a page for the non-fans.');
				return false;	
			}
					
			$('.fb_tab_error').text('');
			return true;
		});
	});
	</script>
<?php
}

function opl_launch_bar( $items, $pos = 'bottom' ) {
	require_once( OPL_PATH . 'inc/vt_resize.php' );
	$html = '';

	if ( !is_array($items) )
		return '';
	
	$class = ( $pos == 'top' ) ? ' opl-launch-top' : '';
	$html .= '<ul id="opl-launch-items">';
	foreach ( $items as $item ) {
		$img = ( opl_isset($item['thumb']) != '' ) ? $item['thumb'] : OPL_URL . 'images/unavailable.png';
		$image = vt_resize( '', $img, 200, 145, true );
		$url = ( $item['page'] != '' && $item['page'] != 'unreleased' ) ? get_permalink($item['page']) : '#';
		$urlclass = ( $item['page'] != '' && $item['page'] != 'unreleased' ) ? '' : ' class="opl-launch-unreleased"';
		
		$html .= '<li class="' . $class . '">';
		$html .= '<div class="opl-launch-item-image' . $class . '"><a href="' . $url . '"' . $urlclass .'><img src="' . $image['url'] . '" border="0" /></a></div>';
		$html .= '<div class="opl-launch-item-title' . $class . '"><strong>' . $item['title'] . '</strong></div>';
		$html .= '</li>';
	}
	$html .= '</ul>';
	$html .= "\n" . '<script type="text/javascript">';
	$html .= "
		jQuery(document).ready(function(){
			jQuery('.opl-launch-unreleased').each(function(){
				var dis_itm = jQuery(this);
				dis_itm.click(function(e){
					alert('Video isn\'t available yet. Please check again later.');
					e.preventDefault();
				});
			});
		});
	";
	$html .= '</script>'. "\n";
	return $html;
}

function is_opl_admin() {
	if ( is_user_logged_in() && current_user_can('manage_options') ) return true;

	return false;
}

function opl_datediff($interval, $datefrom, $dateto, $using_timestamps = false) {
    /*
    $interval can be:
    yyyy - Number of full years
    q - Number of full quarters
    m - Number of full months
    y - Difference between day numbers
        (eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
    d - Number of full days
    w - Number of full weekdays
    ww - Number of full weeks
    h - Number of full hours
    n - Number of full minutes
    s - Number of full seconds (default)
    */
    
    if (!$using_timestamps) {
        $datefrom = strtotime($datefrom, 0);
        $dateto = strtotime($dateto, 0);
    }
    $difference = $dateto - $datefrom; // Difference in seconds
     
    switch($interval) {
     
    case 'yyyy': // Number of full years

        $years_difference = floor($difference / 31536000);
        if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
            $years_difference--;
        }
        if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
            $years_difference++;
        }
        $datediff = $years_difference;
        break;

    case "q": // Number of full quarters

        $quarters_difference = floor($difference / 8035200);
        while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
            $months_difference++;
        }
        $quarters_difference--;
        $datediff = $quarters_difference;
        break;

    case "m": // Number of full months

        $months_difference = floor($difference / 2678400);
        while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
            $months_difference++;
        }
        $months_difference--;
        $datediff = $months_difference;
        break;

    case 'y': // Difference between day numbers

        $datediff = date("z", $dateto) - date("z", $datefrom);
        break;

    case "d": // Number of full days

        $datediff = floor($difference / 86400);
        break;

    case "w": // Number of full weekdays

        $days_difference = floor($difference / 86400);
        $weeks_difference = floor($days_difference / 7); // Complete weeks
        $first_day = date("w", $datefrom);
        $days_remainder = floor($days_difference % 7);
        $odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
        if ($odd_days > 7) { // Sunday
            $days_remainder--;
        }
        if ($odd_days > 6) { // Saturday
            $days_remainder--;
        }
        $datediff = ($weeks_difference * 5) + $days_remainder;
        break;

    case "ww": // Number of full weeks

        $datediff = floor($difference / 604800);
        break;

    case "h": // Number of full hours

        $datediff = floor($difference / 3600);
        break;

    case "n": // Number of full minutes

        $datediff = floor($difference / 60);
        break;

    default: // Number of full seconds (default)

        $datediff = $difference;
        break;
    }    

    return $datediff;

}

add_action('wp_footer', 'opl_top_menu_pos');
function opl_top_menu_pos(){
?>
<script>
	jQuery(document).ready(function($){
		var opl_topnav_w = $('#opl-top-nav').outerWidth() + 20;
		$('#opl-top-nav').css({
			'width' : opl_topnav_w + 'px',
		});
	});
</script>
<?php
}

function opl_getLocalTimezone() {
    $iTime = time();
    $arr = localtime($iTime);
    $arr[5] += 1900;
    $arr[4]++;
    $iTztime = gmmktime($arr[2], $arr[1], $arr[0], $arr[4], $arr[3], $arr[5], $arr[8]);
    $offset = doubleval(($iTztime-$iTime)/(60*60));
    $zonelist =
    array
    (
        'Kwajalein' => -12.00,
        'Pacific/Midway' => -11.00,
        'Pacific/Honolulu' => -10.00,
        'America/Anchorage' => -9.00,
        'America/Los_Angeles' => -8.00,
        'America/Denver' => -7.00,
        'America/Tegucigalpa' => -6.00,
        'America/New_York' => -5.00,
        'America/Caracas' => -4.30,
        'America/Halifax' => -4.00,
        'America/St_Johns' => -3.30,
        'America/Argentina/Buenos_Aires' => -3.00,
        'America/Sao_Paulo' => -3.00,
        'Atlantic/South_Georgia' => -2.00,
        'Atlantic/Azores' => -1.00,
        'Europe/Dublin' => 0,
        'Europe/Belgrade' => 1.00,
        'Europe/Minsk' => 2.00,
        'Asia/Kuwait' => 3.00,
        'Asia/Tehran' => 3.30,
        'Asia/Muscat' => 4.00,
        'Asia/Yekaterinburg' => 5.00,
        'Asia/Kolkata' => 5.30,
        'Asia/Katmandu' => 5.45,
        'Asia/Dhaka' => 6.00,
        'Asia/Rangoon' => 6.30,
        'Asia/Krasnoyarsk' => 7.00,
        'Asia/Brunei' => 8.00,
        'Asia/Seoul' => 9.00,
        'Australia/Darwin' => 9.30,
        'Australia/Canberra' => 10.00,
        'Asia/Magadan' => 11.00,
        'Pacific/Fiji' => 12.00,
        'Pacific/Tongatapu' => 13.00
    );
    $index = array_keys($zonelist, $offset);
    if(sizeof($index)!=1)
        return false;
    return $index[0];
} 