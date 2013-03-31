<?php

if (!function_exists ('is_admin'))
{
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
}
elseif (!class_exists('OnPageSEOClientDecoration'))
{
	class OnPageSEOClientDecoration
	{
		// Instance Variables
		var $options = array();
		var $strippedChars = array();
		var $keyword;
		var $marker = 'XqXsXvX';
		var $hexKeyword;
		var $hexRegEx;

		// PHP 4 Constructor (For Backwards Compatibility)
		function OnPageSEOClientDecoration($options)
		{
			$this->__construct($options);
			return;
		}

		// PHP 5 Constructor
		function __construct($options)
		{
			// Plugin Settings
			$this->options = $options;
		}

		function contentHandler($content)
		{
			global $post;

			// Plugin Settings Exist (Plugin Needs To Be Reactivated If Not)
			if($this->options)
			{
				// Get Post/Page Settings
				$metaData = get_post_meta($post->ID, 'onpageseo_post_meta_data', true);

				// Post/Page Settings Exist
				if(is_array($metaData['onpageseo_global_settings']) && isset($metaData['onpageseo_global_settings']['MainKeyword']) && (strlen(trim($metaData['onpageseo_global_settings']['MainKeyword'])) > 0))
				{

					// Include UT8 to Unicode Functions (8-25-11)
					if($this->prcb_check($this->options['unicode_support']))
					{

						include_once('onpageseo-utf8.php');
					}

					// Get Main Keyword For Post/Page
					$this->keyword = trim(stripslashes($metaData['onpageseo_global_settings']['MainKeyword']));

					// Save Copy of Original
					$keyword = $this->keyword;

					// Strip Slashes From Content
					$content = stripslashes($content);

					if($this->prcb_check($this->options['unicode_support']))
					{
						// Hex RegEx (8-25-11)
						$charHex = opseoUTF8ToUnicode($keyword);
						$hexRegEx = '';

						for($i = 0; $i < sizeof($charHex); $i++)
						{
							$hexRegEx .= '\x{'.dechex($charHex[$i]).'}';
						}

						$charHex = '';
						$this->hexKeyword = $hexRegEx;
						$this->hexRegEx = '/(?:(?<=\pL|\pN)(?!\pL|\pN)|(?<!\pL|\pN)(?=\pL|\pN))('.$this->hexKeyword.')(?:(?<=\pL|\pN)(?!\pL|\pN)|(?<!\pL|\pN)(?=\pL|\pN))/uisU';
					}


					// Convert Characters to RegEx
					$regex = $this->prcb_check($this->options['unicode_support']) ? $this->hexRegEx : '/'.preg_quote($this->keyword,'/').'/isU';

					$regex = str_replace('&', '&#?[a-zA-Z0-9]+;', $regex);
					$regex = str_replace("'", '&#?[a-zA-Z0-9]+;', $regex);
					$regex = str_replace('"', '&#?[a-zA-Z0-9]+;', $regex);
					$regex = str_replace('--', '&#?[a-zA-Z0-9]+;', $regex);

					$tempContent = preg_replace_callback($regex, array($this,'replaceHTMLEntities'), $content);
					$content = ($this->prcb_check($tempContent)) ? $tempContent : $content;


					// Keyword RegEx
					$regex = '/\b'.preg_quote($this->keyword,'/').'\b/is';
					$replaceChars = 'jEsdfSDF';
					$stripped = 0;

					// Keyword Contains Non-Alphanumeric Characters
					if(!$this->prcb_check($this->options['unicode_support']))
					{
						// Keyword Contains Non-Alphanumeric Characters
						if(preg_match('/[^\w\d\s]/', $this->keyword))
						{
							// Solves Word Boundary Issue With Non-Alphanumeric Characters (At Beginning or End)
							$this->keyword = preg_replace('/[^\w\d\s]/i', $replaceChars, $this->keyword);
							$regex = '/\b'.$this->keyword.'\b/is';

							// Replace Content
							$tempContent = preg_replace_callback('/'.preg_quote($keyword,'/').'/i', array($this, 'keywordReplacer'), $content);
							$content = ($this->prcb_check($tempContent)) ? $tempContent : $content;

							$stripped = 1;
						}
					}


					// Check For Keyword Decoration
					$boldFont = $this->analyzeBoldDecoration($content, $this->keyword);
					$italicFont = $this->analyzeItalicDecoration($content, $this->keyword);
					$underlineFont = $this->analyzeUnderlineDecoration($content, $this->keyword);


					// In Tag
					$inTagRegEx = $this->prcb_check($this->options['unicode_support']) ? '/(<(\pL[\pL\pN]*)\s)([^>]+)(>)/uisU' : '/(<([a-z][a-z0-9]*)\s)([^>]+)(>)/isU';
					$tempContent = preg_replace_callback($inTagRegEx, array($this,'keywordMarker'), $content);
					$content = ($this->prcb_check($tempContent)) ? $tempContent : $content;

					// H#
					$inHTagRegEx = $this->prcb_check($this->options['unicode_support']) ? '/(<(h\pN)[^>]*>)(.*)(<\/h\pN>)/uisU' : '/(<(h[0-9])[^>]*>)(.*)(<\/h[0-9]>)/isU';
					$tempContent = preg_replace_callback($inHTagRegEx, array($this,'keywordMarker'), $content);
					$content = ($this->prcb_check($tempContent)) ? $tempContent : $content;

					// B | STRONG | I | EM | U
					$inDecorateTagRegEx = '/(<(b|strong|i|em|u)>)(.*)(<\/(b|strong|i|em|u)>)/isU';
					$tempContent = preg_replace_callback($inDecorateTagRegEx, array($this,'keywordMarker'), $content);
					$content = ($this->prcb_check($tempContent)) ? $tempContent : $content;

					// SPAN
					$inStyleTagRegEx = '/(<span\s.*style.+(bold|italic|underline)[^>]+>)(.*)(<\/span>)/isU';
					$tempContent = preg_replace_callback($inStyleTagRegEx, array($this,'keywordMarker'), $content);
					$content = ($this->prcb_check($tempContent)) ? $tempContent : $content;


					// Bold
					if($this->options['bold_keyword'] && !$boldFont)
					{
						switch($this->options['bold_style'])
						{
							case 'b':

								$content = $this->prcb_check($this->options['unicode_support']) ? preg_replace($this->hexRegEx, '<b>${1}XqXsXvX</b>', $content, 1) : preg_replace('/\b('.$this->keyword.')\b/siU', '<b>${1}XqXsXvX</b>', $content, 1);
								break;

							case 'fontweightbold':

								$content = $this->prcb_check($this->options['unicode_support']) ? preg_replace($this->hexRegEx, '<span style="font-weight:bold;">${1}XqXsXvX</span>', $content, 1) : preg_replace('/\b('.$this->keyword.')\b/siU', '<span style="font-weight:bold;">${1}XqXsXvX</span>', $content, 1);
								break;

							default:

								$content = $this->prcb_check($this->options['unicode_support']) ? preg_replace($this->hexRegEx, '<strong>${1}XqXsXvX</strong>', $content, 1) : preg_replace('/\b('.$this->keyword.')\b/siU', '<strong>${1}XqXsXvX</strong>', $content, 1);
								break;								
						}
					}


					// Italic
					if($this->options['italic_keyword'] && !$italicFont)
					{
						switch($this->options['italic_style'])
						{
							case 'i':

								$content = $this->prcb_check($this->options['unicode_support']) ? preg_replace($this->hexRegEx, '<i>${1}XqXsXvX</i>', $content, 1) : preg_replace('/\b('.$this->keyword.')\b/siU', '<i>${1}XqXsXvX</i>', $content, 1);
								break;

							case 'fontstyleitalic':

								$content = $this->prcb_check($this->options['unicode_support']) ? preg_replace($this->hexRegEx, '<span style="font-style:italic;">${1}XqXsXvX</span>', $content, 1) : preg_replace('/\b('.$this->keyword.')\b/siU', '<span style="font-style:italic;">${1}XqXsXvX</span>', $content, 1);
								break;

							default:

								$content = $this->prcb_check($this->options['unicode_support']) ? preg_replace($this->hexRegEx, '<em>${1}XqXsXvX</em>', $content, 1) : preg_replace('/\b('.$this->keyword.')\b/siU', '<em>${1}XqXsXvX</em>', $content, 1);
								break;								
						}
					}


					// Underline
					if($this->options['underline_keyword'] && !$underlineFont)
					{
						switch($this->options['underline_style'])
						{
							case 'u':
								$content = $this->prcb_check($this->options['unicode_support']) ? preg_replace($this->hexRegEx, '<u>${1}XqXsXvX</u>', $content, 1) : preg_replace('/\b('.$this->keyword.')\b/siU', '<u>${1}XqXsXvX</u>', $content, 1);
								break;

							default:
								$content = $this->prcb_check($this->options['unicode_support']) ? preg_replace($this->hexRegEx, '<span style="text-decoration:underline;">${1}XqXsXvX</span>', $content, 1) : preg_replace('/\b('.$this->keyword.')\b/siU', '<span style="text-decoration:underline;">${1}XqXsXvX</span>', $content, 1);
								break;						
						}
					}



					// No Follow and Link Target
					if($this->options['no_follow'] || $this->options['link_target'])
					{
						$tempContent = preg_replace_callback('/<a([^>]+)>/siU', array($this,'autoNoFollow'), $content);
						$content = ($this->prcb_check($tempContent)) ? $tempContent : $content;
					}


					// Image ALT Attribute
					if($this->options['image_alt'])
					{
						$tempContent = preg_replace_callback('/<img([^>]+)\/?>/siU', array($this,'autoIMGALT'), $content);
						$content = ($this->prcb_check($tempContent)) ? $tempContent : $content;
					}


					// Delete Markers
					$content = str_replace('XqXsXvX', '', $content);

					if($stripped)
					{
						// Get Characters
						preg_match_all('/[^\w\d\s]/i', $keyword, $matches);

						// Store Chars In Array
						for($i = 0; $i < sizeof($matches[0]); $i++) { $this->strippedChars[$i] = $matches[0][$i];	}

						// Restore Characters
						$tempContent = preg_replace_callback('/'.$this->keyword.'/i', array($this, 'keywordRestorer'), $content);
						$content = ($this->prcb_check($tempContent)) ? $tempContent : $content;
					}

				}
				// No Primary Keyword
				else
				{
					// No Follow and Link Target
					if($this->options['no_follow'] || $this->options['link_target'])
					{
						$tempContent = preg_replace_callback('/<a([^>]+)>/siU', array($this,'autoNoFollow'), $content);
						$content = ($this->prcb_check($tempContent)) ? $tempContent : $content;
					}
				}
			}

			return $content;
		}



		function keywordMarker($matches)
		{
			if($this->prcb_check($this->options['unicode_support']))
			{
				return($matches[1].preg_replace($this->hexRegEx, '${1}XqXsXvX', $matches[3]).$matches[4]);
			}
			else
			{
				return($matches[1].preg_replace('/\b('.$this->keyword.')\b/i', '${1}XqXsXvX', $matches[3]).$matches[4]);
			}
		}


		function keywordReplacer($matches)
		{
			return(preg_replace('/[^\w\d\s]/i', 'jEsdfSDF', $matches[0]));	
		}


		function keywordRestorer($matches)
		{
			$temp = $matches[0];

			for($i = 0; $i < sizeof($this->strippedChars); $i++)
			{
				$matches[0] = preg_replace('/jEsdfSDF/', $this->strippedChars[$i], $matches[0], 1);
			}

			return($matches[0]);	
		}


		function prcb_check($content)
		{
			if(!isset($content) || is_null($content) || (strlen(trim($content)) == 0)) { return '0'; }
			else { return '1'; }
		}



		function analyzeBoldDecoration($content, $keyword)
		{
			@$dom = new DOMDocument();

			if($this->prcb_check($this->options['unicode_support']))
			{
				$content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
				@$dom->loadHTML(mb_strtolower($content, 'UTF-8'));
			}
			else
			{
				@$dom->loadHTML(strtolower($content));
			}

			@$xpath = new DOMXPath(@$dom);
			@$elements = $this->prcb_check($this->options['unicode_support']) ? $xpath->query('//b[contains(., "'.mb_strtolower($keyword, 'UTF-8').'")]|//strong[contains(., "'.mb_strtolower($keyword, 'UTF-8').'")]|//span[contains(@style, "bold") and contains(., "'.mb_strtolower($keyword, 'UTF-8').'")]') : $xpath->query('//b[contains(., "'.strtolower($keyword).'")]|//strong[contains(., "'.strtolower($keyword).'")]|//span[contains(@style, "bold") and contains(., "'.strtolower($keyword).'")]');

			$result = 0;
			$regex = $this->prcb_check($this->options['unicode_support']) ? $this->hexRegEx : '/\b'.$keyword.'\b/i';

			foreach ($elements as $e)
			{
				$val = '';
				if(isset($e->nodeValue) && (strlen(trim($e->nodeValue)) > 0)) { $val = $e->nodeValue; }
				else { $val = $e->getAttribute('style'); }

				if(preg_match($regex, $val, $matches))
				{
					$result = 1;
				}
			}

			return $result;
		}



		function analyzeItalicDecoration($content, $keyword)
		{
			@$dom = new DOMDocument();

			if($this->prcb_check($this->options['unicode_support']))
			{
				$content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
				@$dom->loadHTML(mb_strtolower($content, 'UTF-8'));
			}
			else
			{
				@$dom->loadHTML(strtolower($content));
			}

			@$xpath = new DOMXPath(@$dom);
			@$elements = $this->prcb_check($this->options['unicode_support']) ? $xpath->query('//i[contains(., "'.mb_strtolower($keyword, 'UTF-8').'")]|//em[contains(., "'.mb_strtolower($keyword, 'UTF-8').'")]|//span[contains(@style, "italic") and contains(., "'.mb_strtolower($keyword, 'UTF-8').'")]') : $xpath->query('//i[contains(., "'.strtolower($keyword).'")]|//em[contains(., "'.strtolower($keyword).'")]|//span[contains(@style, "italic") and contains(., "'.strtolower($keyword).'")]');

			$result = 0;
			$regex = $this->prcb_check($this->options['unicode_support']) ? $this->hexRegEx : '/\b'.$keyword.'\b/i';

			foreach ($elements as $e)
			{
				$val = '';
				if(isset($e->nodeValue) && (strlen(trim($e->nodeValue)) > 0)) { $val = $e->nodeValue; }
				else { $val = $e->getAttribute('style'); }

				if(preg_match($regex, $val, $matches))
				{
					$result = 1;
				}
			}

			return $result;
		}



		function analyzeUnderlineDecoration($content, $keyword)
		{
			@$dom = new DOMDocument();

			if($this->prcb_check($this->options['unicode_support']))
			{
				$content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
				@$dom->loadHTML(mb_strtolower($content, 'UTF-8'));
			}
			else
			{
				@$dom->loadHTML(strtolower($content));
			}

			@$xpath = new DOMXPath(@$dom);
			@$elements = $this->prcb_check($this->options['unicode_support']) ? $xpath->query('//u[contains(., "'.mb_strtolower($keyword, 'UTF-8').'")]|//span[contains(@style, "underline") and contains(., "'.mb_strtolower($keyword, 'UTF-8').'")]') : $xpath->query('//u[contains(., "'.strtolower($keyword).'")]|//span[contains(@style, "underline") and contains(., "'.strtolower($keyword).'")]');

			$result = 0;
			$regex = $this->prcb_check($this->options['unicode_support']) ? $this->hexRegEx : '/\b'.$keyword.'\b/i';

			foreach ($elements as $e)
			{
				$val = '';
				if(isset($e->nodeValue) && (strlen(trim($e->nodeValue)) > 0)) { $val = $e->nodeValue; }
				else { $val = $e->getAttribute('style'); }

				if(preg_match($regex, $val, $matches))
				{
					$result = 1;
				}
			}

			return $result;
		}



		function replaceHTMLEntities($matches)
		{
			$content = $matches[0];
			$content = str_replace('&#8216;', "'", $content); // '
			$content = str_replace('&#8217;', "'", $content); // '
			$content = str_replace('&#8242;', "'", $content); // '
			$content = str_replace('&#8220;', '"', $content); // “
			$content = str_replace('&#8221;', '"', $content); // ”
			$content = str_replace('&#8243;', '"', $content); // "
			$content = str_replace('&#8211;', '--', $content); // test–ing
			$content = str_replace(' &#8212; ', ' -- ', $content); // test — ing
			$content = preg_replace('/&#8212;/', '---', $content); // test — ing
			$content = str_replace('&#8230;', '...', $content); // …
			$content = str_replace('&#215;', 'x', $content); // ×
			$content = str_replace('&amp;', '&', $content); // &
			$content = str_replace('&#038;', '&', $content); // &
			$content = str_replace('&quot;', "'", $content); // '
			$content = str_replace('&#169;', '(c)', $content); // ©
			$content = str_replace('&#174;', '(r)', $content); // ®
			$content = str_replace('&Prime;', '"', $content); // "
			$content = str_replace('&prime;', "'", $content); // '

			return($content);
		}



		function autoNoFollow($matches)
		{
			// Clean Up Link
			$linkContent = $this->prcb_check($this->options['unicode_support']) ? mb_strtolower(stripslashes($matches[0])) : strtolower(stripslashes($matches[0]));

			// Domain Name
			$url = parse_url(get_bloginfo('url'), PHP_URL_HOST);

			// Check If Contains No Follow
			if($this->options['no_follow'] && ($this->prcb_check($this->options['unicode_support']) ? (mb_strpos($linkContent, 'nofollow') === false) : (strpos($linkContent, 'nofollow') === false)))
			{
				// No Follow White List
				$whiteList = array();

				$whiteListCheck = 0;
				if(isset($this->options['no_follow_white_list']) && ($this->prcb_check($this->options['unicode_support']) ? (mb_strlen(trim($this->options['no_follow_white_list'])) > 0) : (strlen(trim($this->options['no_follow_white_list'])) > 0)))
				{
					$whiteList = explode("\n", $this->options['no_follow_white_list']);

					for($i = 0; $i < sizeof($whiteList); $i++)
					{
						if(isset($whiteList[$i]) && ($this->prcb_check($this->options['unicode_support']) ? (mb_strlen(trim($whiteList[$i])) > 0) : (strlen(trim($whiteList[$i])) > 0)))
						{
							if($this->prcb_check($this->options['unicode_support']) ? (mb_strpos($linkContent, $whiteList[$i]) !== false) : (strpos($linkContent, $whiteList[$i]) !== false))
								$whiteListCheck = 1;
						}
					}
				}

				$linkAttributes = '';

				// Check If No Follow White List
				if(!$whiteListCheck && ($this->prcb_check($this->options['unicode_support']) ? (mb_strpos($linkContent, $url) === false) : (strpos($linkContent, $url) === false)) && ($this->prcb_check($this->options['unicode_support']) ? (mb_strpos($linkContent, 'href="/') === false) : (strpos($linkContent, 'href="/') === false)) && ($this->prcb_check($this->options['unicode_support']) ? (mb_strpos($linkContent, 'href=\'/') === false) : (strpos($linkContent, 'href=\'/') === false)))
				{
					if(isset($this->options['link_target']) && ($this->prcb_check($this->options['unicode_support']) ? (mb_strpos($linkContent, 'target=') === false) : (strpos($linkContent, 'target=') === false)))
					{
						$linkAttributes = ' rel="nofollow" target="_blank">';
					}
					else
					{
						$linkAttributes = ' rel="nofollow">';
					}

					$linkContent = '<a'.$matches[1].$linkAttributes;
				}
				else
				{
					// Add TARGET Attribute
					if(isset($this->options['link_target']) && ($this->prcb_check($this->options['unicode_support']) ? (mb_strpos($linkContent, 'target=') === false) : (strpos($linkContent, 'target=') === false)) && (strpos($linkContent, $url) === false) && ($this->prcb_check($this->options['unicode_support']) ? (strpos($linkContent, $url) === false) : (strpos($linkContent, $url) === false)) && ($this->prcb_check($this->options['unicode_support']) ? (mb_strpos($linkContent, 'href=\'/') === false) : (strpos($linkContent, 'href=\'/') === false)))
					{
						$linkContent = '<a'.$matches[1].' target="_blank">';
					}
					else
					{
						$linkContent = $matches[0];
					}
				}

				return($linkContent);
			}
			// No TARGET Attribute
			elseif(($this->prcb_check($this->options['unicode_support']) ? (mb_strpos($linkContent, 'target=') === false) : (strpos($linkContent, 'target=') === false)) && ($this->prcb_check($this->options['unicode_support']) ? (mb_strpos($linkContent, $url) === false) : (strpos($linkContent, $url) === false)) && ($this->prcb_check($this->options['unicode_support']) ? (mb_strpos($linkContent, 'href="/') === false) : (strpos($linkContent, 'href="/') === false)) && ($this->prcb_check($this->options['unicode_support']) ? (mb_strpos($linkContent, 'href=\'/') === false) : (strpos($linkContent, 'href=\'/') === false)))
			{
				$linkContent = $matches[0];

				// Add TARGET Attribute
				if(isset($this->options['link_target']) && ($this->prcb_check($this->options['unicode_support']) ? (mb_strpos($linkContent, 'target=') === false) : (strpos($linkContent, 'target=') === false)))
				{
					$linkContent = '<a'.$matches[1].' target="_blank">';
				}

				return($linkContent);
			}
			else { return $matches[0]; }
		}



		function autoIMGALT($matches)
		{
			// Clean Up
			$imgContent = $this->prcb_check($this->options['unicode_support']) ? mb_strtolower(stripslashes($matches[0])) : strtolower(stripslashes($matches[0]));

			// No ALT Attribute
			if($this->prcb_check($this->options['unicode_support']) ? (mb_strpos($imgContent, 'alt=') === false) : (strpos($imgContent, 'alt=') === false))
			{
				return('<img '.trim($matches[1]).' alt="'.$this->keyword.'" />');
			}
			else { return $matches[0]; }
		}


	}
}
?>