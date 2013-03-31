<?php  
add_action('wp_enqueue_scripts', 'login_radius_get_sharing_code'); 
if($loginRadiusSettings['LoginRadius_shareEnable'] == "1" ){
	if(isset( $loginRadiusSettings['LoginRadius_sharehome'] ) || isset( $loginRadiusSettings['LoginRadius_sharepost'] ) || isset( $loginRadiusSettings['LoginRadius_sharepage'] ) || isset( $loginRadiusSettings['LoginRadius_shareexcerpt'] ) || isset( $loginRadiusSettings['LoginRadius_sharearchive'] ) || isset( $loginRadiusSettings['LoginRadius_sharefeed'])){
	function loginRadiusShareContent($content){
		global $loginRadiusSettings, $post;
		$loginRadiusSettings['LoginRadius_sharingTitle'] = isset($loginRadiusSettings['LoginRadius_sharingTitle']) ? trim($loginRadiusSettings['LoginRadius_sharingTitle']) : "";
		$lrMeta = get_post_meta($post->ID, '_login_radius_meta', true);
		// if sharing disabled on this page/post, return content unaltered
		if(isset($lrMeta['sharing']) && $lrMeta['sharing'] == 1 && !is_front_page()){
			return $content;
		}
		if(!isset($loginRadiusSettings['LoginRadius_sharingTheme']) || $loginRadiusSettings['LoginRadius_sharingTheme'] == "horizontal" || $loginRadiusSettings['LoginRadius_sharingTheme'] == ""){
			if(trim($loginRadiusSettings['LoginRadius_sharingTitle']) != ""){
				$append = "<div style='margin:0'><b>".ucfirst($loginRadiusSettings['LoginRadius_sharingTitle'])."</b></div><div class='lrsharecontainer'></div>";
				$bottomAppend = "<div style='margin:0'><b>".ucfirst($loginRadiusSettings['LoginRadius_sharingTitle'])."</b></div><div class='lrsharecontainer2'></div>";
			}else{
				$append = "<div class='lrsharecontainer'></div>";
				$bottomAppend = "<div class='lrsharecontainer2'></div>";
			}
		}elseif($loginRadiusSettings['LoginRadius_sharingTheme'] == "vertical"){
			$append = "<div class='lrsharecontainer'></div>";
			if(isset($loginRadiusSettings['LoginRadius_sharetop']) && isset($loginRadiusSettings['LoginRadius_sharebottom']) && $loginRadiusSettings['LoginRadius_sharetop'] == '1' && $loginRadiusSettings['LoginRadius_sharebottom'] == '1'){
				$bottomAppend = "";
			}elseif(isset($loginRadiusSettings['LoginRadius_sharebottom']) && $loginRadiusSettings['LoginRadius_sharebottom'] == '1'){
				$bottomAppend = "<div class='lrsharecontainer'></div>";
			}
		}
		if((isset( $loginRadiusSettings['LoginRadius_sharehome']) && is_front_page()) || ( isset( $loginRadiusSettings['LoginRadius_sharepost'] ) && is_single() ) || ( isset( $loginRadiusSettings['LoginRadius_sharepage'] ) && is_page() ) || ( isset( $loginRadiusSettings['LoginRadius_shareexcerpt'] ) && has_excerpt() ) || ( isset( $loginRadiusSettings['LoginRadius_sharearchive'] ) && is_archive() ) || ( isset( $loginRadiusSettings['LoginRadius_sharefeed'] ) && is_feed() ) ){	
			if(isset($loginRadiusSettings['LoginRadius_sharetop'] ) && isset($loginRadiusSettings['LoginRadius_sharebottom'])){
				$content = $append.'<br/>'.$content.'<br/>'.$bottomAppend;
			}else{
				if(isset($loginRadiusSettings['LoginRadius_sharetop'])){
					$content = $append.$content;
				}
				elseif(isset($loginRadiusSettings['LoginRadius_sharebottom'])){
					$content = $content.$bottomAppend;
				}
			}
		}
	  	return $content;
	}
	add_filter('the_content', 'loginRadiusShareContent');
	} 
}