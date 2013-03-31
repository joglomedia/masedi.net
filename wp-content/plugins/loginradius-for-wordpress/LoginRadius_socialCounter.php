<?php  
add_action('wp_enqueue_scripts', 'login_radius_get_counter_code'); 
	if($loginRadiusSettings['LoginRadius_counterEnable'] == "1"){
		if( isset( $loginRadiusSettings['LoginRadius_counterhome'] ) || isset( $loginRadiusSettings['LoginRadius_counterpost'] ) || isset( $loginRadiusSettings['LoginRadius_counterpage'] ) || isset( $loginRadiusSettings['LoginRadius_counterexcerpt'] ) || isset( $loginRadiusSettings['LoginRadius_counterarchive'] ) || isset( $loginRadiusSettings['LoginRadius_counterfeed'] ) ){
			$loginRadiusVerticalAtHome = false;
			function loginRadiusCounterContent($content){
				global $loginRadiusSettings, $post;
				$loginRadiusSettings['LoginRadius_counterTitle'] = isset($loginRadiusSettings['LoginRadius_counterTitle']) ? trim($loginRadiusSettings['LoginRadius_counterTitle']) : "";
				$lrMeta = get_post_meta($post->ID, '_login_radius_meta', true);
				// if sharing disabled on this page/post, return content unaltered
				if(isset($lrMeta['counter']) && $lrMeta['counter'] == 1 && !is_front_page()){
					return $content;
				}
				if(!isset($loginRadiusSettings['LoginRadius_counterTheme']) || $loginRadiusSettings['LoginRadius_counterTheme'] == "horizontal" || $loginRadiusSettings['LoginRadius_counterTheme'] == ""){
					// bottom counter div
					$bottomAppend = trim($loginRadiusSettings['LoginRadius_counterTitle']) != "" ? "<div style='margin:0'><b>".ucfirst($loginRadiusSettings['LoginRadius_counterTitle'])."</b></div><div class='lrcounter_simplebox2'></div>" : "<div class='lrcounter_simplebox2'></div>";
					// top counter div
					if($loginRadiusSettings['LoginRadius_counterTitle'] != ""){
						$append = "<div style='margin:0'><b>".ucfirst($loginRadiusSettings['LoginRadius_counterTitle'])."</b></div><div class='lrcounter_simplebox'></div>";
					}else{
						$append = "<div class='lrcounter_simplebox'></div>";
					}
				}elseif($loginRadiusSettings['LoginRadius_counterTheme'] == "vertical"){
					$append = "<div class='lrcounter_simplebox'></div>";
					if(isset($loginRadiusSettings['LoginRadius_countertop']) && isset($loginRadiusSettings['LoginRadius_counterbottom']) && $loginRadiusSettings['LoginRadius_countertop'] == '1' && $loginRadiusSettings['LoginRadius_counterbottom'] == '1'){
						$bottomAppend = "";
					}elseif(isset($loginRadiusSettings['LoginRadius_counterbottom']) && $loginRadiusSettings['LoginRadius_counterbottom'] == '1'){
						$bottomAppend = "<div class='lrcounter_simplebox'></div>";
					}
				}
				if((isset($loginRadiusSettings['LoginRadius_counterhome'] ) && is_front_page() ) || ( isset( $loginRadiusSettings['LoginRadius_counterpost'] ) && is_single()) || (isset($loginRadiusSettings['LoginRadius_counterpage'] ) && is_page() ) || ( isset( $loginRadiusSettings['LoginRadius_counterexcerpt'] ) && has_excerpt()) || (isset($loginRadiusSettings['LoginRadius_counterarchive'] ) && is_archive() ) || (isset($loginRadiusSettings['LoginRadius_counterfeed'] ) && is_feed())){	
					if(isset($loginRadiusSettings['LoginRadius_counterTheme']) && $loginRadiusSettings['LoginRadius_counterTheme'] == 'vertical' && is_front_page()){
						global $loginRadiusVerticalAtHome;
						if($loginRadiusVerticalAtHome){
							return $content;
						}
						$loginRadiusVerticalAtHome = true;
					}
					if( isset( $loginRadiusSettings['LoginRadius_countertop'] ) && isset( $loginRadiusSettings['LoginRadius_counterbottom'] ) ){
						$content = $append.'<br/>'.$content.'<br/>'.$bottomAppend;
					}else{
						if(isset($loginRadiusSettings['LoginRadius_countertop'])){
							$content = $append.$content;
						}elseif(isset( $loginRadiusSettings['LoginRadius_counterbottom'])){
							$content = $content.$bottomAppend;
						}
					}
				}
			  return $content;
			}
		add_filter('the_content', 'loginRadiusCounterContent');
	}
}