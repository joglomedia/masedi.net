<?php

class smilies_package
{
	
	var $path;
	# you can override the url_path in the package config
	var $url_path;
	
	var $smilies = array();
	var $smiliessearch = array();
	var $smiliesreplace = array();
	
	var $author;
	var $author_url;
	var $description;
	var $name;
	var $url;
	
	var $sort_smilies = false;
	
	
	function smilies_package($package = 'default', $sort_override = false) {
		if (false !== ($cache = wp_cache_get($package, 'smilies'))) {
			$this->load_cache($cache);
		}
		else {
			if ($sort_override)
			$this->sort_smilies = true;
			$this->path = k_SMILIES_PATH . $package . DIRECTORY_SEPARATOR;
			$this->url_path = k_SMILIES_URL . $package;
			
			/*
			$this->load_smilies();
			$this->get_package_data();
			$this->construct_smilies();
			*/
			$this->get_package_data();
			
			include($this->path . k_SMILIES_CONFIG_FILE);
			
			$this->smilies = $wp_smilies;
			
			foreach ( (array) $this->smilies as $smiley => $img ) {
				$this->smiliessearch[] = '/(\s|^)'.preg_quote($smiley, '/').'(\s|$)/';
				$smiley_masked = htmlspecialchars(trim($smiley), ENT_QUOTES);
				$this->smiliesreplace[]  = " <img src='$this->url_path/$img' alt='$smiley_masked' class='wp-smiley' /> ";
			}
	
			wp_cache_add($package, get_object_vars($this), 'smilies');
		}
	}
	
	function get_package_data() {
		$package_data = implode('', file($this->path . k_SMILIES_CONFIG_FILE));
		
		preg_match("|Package-Name:(.*)|i", $package_data, $package_name);
		preg_match("|Package-URI:(.*)|i", $package_data, $package_url);
		preg_match("|Package-Description:(.*)|i", $package_data, $description);
		preg_match("|Package-Author:(.*)|i", $package_data, $author_name);
		preg_match("|Package-Author-URI:(.*)|i", $package_data, $author_url);
		
		$this->author = trim($author_name[1]);
		$this->author_url = trim($author_url[1]);
		$this->name = trim($package_name[1]);
		$this->url = trim($package_url[1]);
		$this->description = wptexturize(trim($description[1]));
	}
	
	function load_cache($cache) {
		foreach ($cache as $var => $value) {
			$this->$var = $value;
		}
	}
	
		function set_smilies() {
		global $wpsmiliestrans, $wp_smiliessearch, $wp_smiliesreplace;
		
		$wpsmiliestrans = $this->smilies;
		$wp_smiliessearch = $this->smiliessearch;
		$wp_smiliesreplace = $this->smiliesreplace;
		add_action('wp_footer', array(&$this, 'credit_author'));
	}
	
	/*
	function load_smilies() {
		include($this->path . k_SMILIES_CONFIG_FILE);
		$this->smilies = $wp_smilies;
	}
	
	function construct_smilies() {
		if ($this->sort_smilies)
			uksort($this->smilies, array(&$this, 'smiliescmp'));
		foreach($this->smilies as $smiley => $img) {
			$this->smiliessearch[] = $this->trim($smiley);
			$this->smiliesreplace[] = $this->smiley_img($smiley, $this->url_path .'/'. $img);
		}
	}
	
	function smiley_img($smiley, $img) {
		return ' <img src="'. $img .'" alt="'. $this->mask($smiley) .'" class="wp-smiley" /> ';
	}
	
	function set_smilies() {
		global $wpsmiliestrans, $wp_smiliessearch, $wp_smiliesreplace;
		
		$wpsmiliestrans = $this->smilies;
		$wp_smiliessearch = $this->smiliessearch;
		$wp_smiliesreplace = $this->smiliesreplace;
		add_action('wp_footer', array(&$this, 'credit_author'));
	}
	
	function add_smiley($smiley, $img, $force = false) {
		if ($this->smilies[$smiley] && !$force)
			return false;
		$this->smilies[$smiley] = $img;
		$this->smiliessearch[] = $this->trim($smiley);
		$this->smiliesreplace[] = $this->smiley_img($smiley, $img);
		return true;
	}
	
	function replace_smiley($smiley, $img) {
		if (!$this->smilies[$smiley])
			return false;
		$key = array_search($smiley, $this->smiliessearch);
		$this->smilies[$smiley] = $img;
		$this->smiliessearch[$key] = $this->trim($smiley);
		$this->smiliesreplace[$key] = $this->smiley_img($smiley, $img);
		return true;
	}
	
	function mask($smiley) {
		# take out : and ; to prevent duplicate replacement
		# hackish :(
		$smiley = str_replace(array(':', ';'), '', $smiley);
		return wp_specialchars(trim($smiley));
	}
	
	function trim($smiley) {
		# trim any smilies like :mrgreen:
		if (preg_match('|:(.+):|s', $smiley, $matches))
			return $matches[0];
		return $smiley;
	}
	
	function smiliescmp ($a, $b) {
		if (strlen($a) == strlen($b)) {
			return strcmp($a, $b);
		}
		return (strlen($a) > strlen($b)) ? -1 : 1;
	}
	
	*/
	function credit_author() {
		$author = ($this->author_url) ? $this->author .' ('. $this->author_url .')' : $this->author;
		echo "\t\n<!-- Smilies package, {$this->name}, courtesy of $author -->\n";
	}
	
	
	

	
	
}

?>