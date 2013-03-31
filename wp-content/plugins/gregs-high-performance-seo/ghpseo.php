<?php
/*
Plugin Name: Greg's High Performance SEO
Plugin URI: http://gregsplugins.com/lib/plugin-details/gregs-high-performance-seo/
Description: Configure over 100 separate on-page SEO characteristics. Fewer than 700 lines of code per page view. No junk: just high performance SEO at its best.
Version: 1.5.4
Author: Greg Mulhauser
Author URI: http://gregsplugins.com/
*/

/*  Copyright (c) 2009-12 Greg Mulhauser

    This WordPress plugin is released under the GPL license
    http://www.opensource.org/licenses/gpl-license.php
    
    **********************************************************************
    This program is distributed in the hope that it will be useful, but
    WITHOUT ANY WARRANTY -- without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
    *****************************************************************
*/

if (!function_exists ('is_admin')) {
   header('Status: 403 Forbidden');
   header('HTTP/1.1 403 Forbidden');
   exit();
   }

class gregsHighPerformanceSEO {

	var $plugin_prefix;        // prefix for option names and post meta tables
	var $consolidate;          // whether we'll be consolidating our options into single array, or keeping discrete

	function gregsHighPerformanceSEO($plugin_prefix='',$option_style='') {
		$this->__construct($plugin_prefix,$option_style);
		return;
	} 

	function __construct($plugin_prefix='',$option_style='') {
		$this->plugin_prefix = $plugin_prefix . '_';
		if (!empty($option_style)) $this->consolidate = ('consolidate' == $option_style) ? true : false;
		else $this->consolidate = true;
		// set up to enable dupe content handling, head description and keywords, and robots
		add_filter('the_content',array(&$this,'paged_comments_dupefix'),$this->opt('comment_page_replacement_level'));
		add_action('wp_head', array(&$this,'head_desc'), 2);
		add_action('wp_head', array(&$this,'head_keywords'), 3);
		add_action('wp_head', array(&$this,'canonical'), 5);
		if ($this->opt('canonical_disable_builtin') && function_exists('rel_canonical')) remove_action('wp_head', 'rel_canonical');
		if ($this->opt('index_enable')) {
			remove_action('wp_head', 'noindex', 1);
			add_action('wp_head', array(&$this,'robots'), 4);
		} // end index modifications
		return;
	} // end constructor

	// grab a setting
	function opt($name) {
		$prefix = rtrim($this->plugin_prefix, '_');
		// try getting consolidated settings
		if ($this->consolidate) $settings = get_option($prefix . '_settings');
		// is_array test will fail if settings not consolidated, isset will fail for private option not in array
		if (is_array($settings)) $value = (isset($settings[$name])) ? $settings[$name] : get_option($prefix . '_' . $name);
		// get discrete-style settings instead
		else $value = get_option($prefix . '_' . $name);
		return $value;
	} // end option retriever

	// grab a setting and tidy it up
	function opt_clean($name) {
		return stripslashes(wp_specialchars_decode($this->opt($name),ENT_QUOTES));
	} // end clean option retriever

	function get_meta($post_id='', $key='', $single=false) { // get post meta
		return get_post_meta($post_id,'_' . $this->plugin_prefix . $key,$single);
	} // end replacement for get_post_meta

	function get_meta_clean($post_id='', $key='', $single=false) { // get cleaned up post meta
		return stripslashes(wp_specialchars_decode($this->get_meta($post_id,$key,$single),ENT_QUOTES));
	} // end clean meta retriever

	function prepout($content) { // general cleanup of text in preparation for display
		return wptexturize(convert_chars(force_balance_tags($content)));
	} // end cleaner upper

	function titlecase($string, $forcelower = false) { // conversion to title case
		// note this doesn't work for words in quotes, because ucfirst doesn't work
		if (!$this->opt('title_case')) return $string;
		$exceptions = str_replace(",", " ",$this->opt('title_case_exceptions'));
		$exceptions = str_replace("  ", "",$exceptions);
		$exceptions = explode(" ", $exceptions);
		$words = explode(" ", $string);
		$newwords = array();
		foreach ($words as $word) {
			if (!in_array($word, $exceptions)) {
				if (strtoupper($word) != $word) { // mess with it only if not already all caps
					$word = ($forcelower) ? ucfirst(strtolower($word)) : ucfirst($word);
				}
			}
			array_push($newwords, $word);
		}
		return ucfirst(join(" ", $newwords)); // ucfirst again in case first word was in the exception list
	} // end titlecase

	function id_to_check($type = false) { // detect special case where WP's static front page options mess up the ID we need to check for titles, descriptions, etc.
		global $post;
		if (!$type) $type = $this->get_type_key(); // if no type passed in, grab it
		if ($type == 'homestaticposts') $tocheck = get_option('page_for_posts');
		elseif ($type == 'homestaticfront') $tocheck = get_option('page_on_front');
		else $tocheck = $post->ID;
		return $tocheck;
	} // end id_to_check

	function treat_like_post($type) { // detect whether we are on a page with its own custom fields
		return (in_array($type, array('single', 'page', 'homestaticfront', 'homestaticposts'))) ? true : false;
	} // end treat_like_post

	function get_comment_page() { // check for whether we're on a paged comment page
		global $wp_query,$post,$overridden_cpage;
		// the following line checks for $overridden_cpage getting set by WP function 'comments_template', which may happen in case some other rude plugin is output buffering the entire page, corrupting the value of the query var cpage that we need; note it will only be set if the original cpage was empty
		if ( $overridden_cpage ) return false;
		$page = get_query_var('cpage');
		if ( !$page )
			$page = 0;
		if ( $page < 1 )
			return false;
		else return true;
	} // end check for comment page

	function get_type_key() { // what kind of page are we on?
		global $wp_query,$paged,$post;
		$key = '';
		if (is_home() && get_option('page_for_posts') && (get_option('show_on_front') == 'page')) $key = 'homestaticposts';
		elseif (is_front_page() && get_option('page_on_front') && (get_option('show_on_front') == 'page')) $key = 'homestaticfront';
		elseif (is_front_page() && (!is_paged())) $key = 'frontnotpaged';
		elseif (is_front_page() && is_paged()) $key = 'frontispaged';
		elseif (is_home()) $key = 'home';
		elseif (is_single()) $key = 'single';
		elseif (is_tag()) $key = 'tag';
		elseif (is_author()) $key = 'author';
		elseif (is_search()) $key = 'search';
		elseif (is_category()) $key = 'category';
		elseif (is_page()) $key = 'page';
		elseif (is_date()) {
			if (is_year()) $key = 'year';
			elseif (is_month()) $key = 'month';
			elseif (is_day()) $key = 'day';
			else $key = 'otherdate';
		} // end handling date-based archives
		elseif (is_404()) $key = '404';
		elseif (is_feed()) $key = 'feed';
		return $key;
	} // end setting type of page

	function get_category_quick ($post) { // grab cat(s) for this post
		$cats = get_the_category ($post->ID);
		if (count ($cats) > 0) {
			foreach ($cats as $cat)
				$category[] = $cat->cat_name;
			$category = implode (', ', $category);
			return $category;
		} else return '';
	}

	function strip_para($content,$leavebreaks='false') {
		// Drop paragraph tags wrapped around content
		$stripped = preg_replace('/<p.*?>([\w\W]+?)<\/p>/','$1 ',$content); // put in extra space in case of multiple paragraphs
		if (!$leavebreaks) $stripped = str_replace(array('<br />',"\n","\r"),' ',$stripped); // drop breaks too
		$stripped = str_replace('  ',' ',$stripped); // kill double spaces introduced while dropping breaks
		return trim($stripped);
	} // end stripping paragraph tags

	function is_multipage() { // check for paged post/page; works outside loop
		global $post,$multipage;
		if (!is_singular()) return null;
		if (isset($multipage)) return $multipage;
		else {
			$content = $post->post_content;
			if ( strpos( $content, '<!--nextpage-->' ) ) $multipage = 1;
			else $multipage = 0;
		}
		return $multipage;
	} // end check for multipage

	function this_page() { // return current page number
		global $wp_query,$paged;
		if ($paged > 1) return $paged;
		$page = get_query_var('page');
		if (!$page) $page = 1;
		return $page;
	}

	function this_page_total() { // return total pages for paged posts/pages
		global $wp_query,$post,$multipage,$numpages;
		if (!is_singular()) return null;
		if (isset($multipage) && isset($numpages)) return $numpages;
		else {
			$content = $post->post_content;
			$pages = explode('<!--nextpage-->', $content);
			$num = count($pages);
			return $num;
		}
		return;
	}

	function get_swaps($type='') { // return replacements necessary to construct titles and descriptions
		// the returned array holds all our option base names for main (_title) and secondary (_title_secondary) titles and secondary descriptions (_desc), plus arrays with any additional swapping that needs to be done in addition to the basics already included locally by whatever function is calling this one
		global $wp_query,$paged,$post,$multipage,$numpages;
		$this_page = $this->this_page();
		$this_page_total = ($this->is_multipage()) ? $this->this_page_total() : intval($wp_query->max_num_pages);
		$secondary = $this->treat_like_post($type) ? $this->get_secondary_title() : '';
		$full_url = ($type == '404') ? 'http://' . str_replace('\\','/',htmlspecialchars(strip_tags(stripslashes($_SERVER['SERVER_NAME']))) .   htmlspecialchars(strip_tags(stripslashes($_SERVER['REQUEST_URI'])))) : '';
		if (is_404()) return array(
			"404" => array('404',array("%error_url%" => $full_url)),
			);
		$cat_desc = ($type == 'category') ? wp_specialchars_decode($this->strip_para(stripslashes(category_description()),$this->opt('cat_desc_leave_breaks')),ENT_QUOTES) : '';
		$cat_of_post = ($type == 'single') ? $this->titlecase($this->get_category_quick($post)) : '';
		$tag_desc = (($type == 'tag') && function_exists('tag_description')) ? $this->strip_para(tag_description(),$this->opt('tag_desc_leave_breaks')) : '';
		$swaps = array (
			"frontnotpaged" => array ('home',''),
			"frontispaged" => array ('home_paged',''),
			"homestaticfront" => array ('home_static_front',array("%page_title%" => single_post_title('',false), "%page_title_custom%" => $secondary)),
			"homestaticposts" => array ('home_static_posts',array("%page_title%" => ltrim(wp_title('',false)), "%page_title_custom%" => $secondary)),
			"home" => array ('home',''),
			"single" => array ('post',array("%post_title%" => single_post_title('',false), "%post_title_custom%" => $secondary, "%category_title%" => $cat_of_post)),
			"tag" => array ('tag',array("%tag_title%" => $this->titlecase(single_tag_title('',false)),"%tag_desc%" => $tag_desc)),
			"author" => array ('author',array("%author_name%" => $this->get_author(), "%author_desc%" => $this->get_author('description'))),
			"search" => array ('search',array("%search_terms%" => strip_tags(stripslashes(get_search_query())))),
			"category" => array ('category',array("%category_title%" => $this->titlecase(single_cat_title('',false)),"%category_desc%"=>$cat_desc)),
			"page" => array ('page',array("%page_title%" => ltrim(wp_title('',false)), "%page_title_custom%" => $secondary)),
			"year" => array ('year_archive',array("%year%" => get_the_time('Y'))),
			"month" => array ('month_archive',array("%month%" => get_the_time('F, Y'))),
			"day" => array ('day_archive',array("%day%" => get_the_time('F jS, Y'))),
			"otherdate" => array ('other_date_archive',''),
			"paged" => array ('paged_modification',array("%page_number%" => $this_page, "%page_total%" => $this_page_total)),
//			"404" => array('404',array("%error_url%" => $full_url)),
			);
		return $swaps;
	} // end setting array of swaps

	function select_desc_comments() { // select and construct the secondary description to use for comment pages
		global $post;
		if ($this->get_comment_page()) {
			$desc = $this->opt_clean('comment_desc_replacement');
			($this->opt('comment_desc_replacement_override') && $this->opt('enable_secondary_titles')) ?
				$title_for_insertion = $this->get_secondary_title() :
				$title_for_insertion = single_post_title('',false);
			$desc = str_replace('%post_title%',$title_for_insertion,$desc);
			$desc = str_replace('%comment_page%',get_query_var('cpage'),$desc);
		} // end handling comment pages
		else $desc = get_the_excerpt();
		return $desc;
	} // end getting secondary description for comments pages

	function select_desc($echo=true) { // select and construct the secondary description if enabled
		global $post;
		$desc = '';
		$suffix = '_desc';
		$key = $this->get_type_key();
		if ($this->opt('enable_secondary_desc')) {
			$default = $this->opt_clean('secondary_desc_override_text');
			if ($this->opt('secondary_desc_override_all') && !$this->get_comment_page()) {
				$desc = $default;
				if (($desc == '') && !($this->opt('secondary_desc_use_blank')))
					$desc = get_the_excerpt();
			}
			elseif ($this->treat_like_post($key)) { // singles, pages, and static front page or posts
				if ($this->get_comment_page() && $this->opt('paged_comments_descfix'))
					$desc = $this->select_desc_comments();
				else {
					$tocheck = $this->id_to_check($key);
					$desc = $this->get_meta_clean($tocheck, 'secondary_desc', true);
					if (($desc == '') && has_excerpt())
						$desc = get_the_excerpt();
					if (($desc == '') || ($this->opt('secondary_desc_override_excerpt')))
						$desc = $default;
					if (($desc == '') && !($this->opt('secondary_desc_use_blank')))
						$desc = get_the_excerpt();
				} // end handling single posts and pages not comments
			} // end handling single posts and pages
			else {
				$swap = array(
							"%blog_name%" => get_bloginfo('name'),
							"%blog_desc%" => get_bloginfo('description'),
							);
				$descswaps = $this->get_swaps($key);
				if ($key != '') {
					$desc = $this->opt_clean($descswaps[$key]['0'] . $suffix);
					// Special handling for tag archives, so we can use a tag description if one is specified under 2.8+, or fall back to a different description if not
					if (($key == 'tag') && ($descswaps[$key]['1']['%tag_desc%'] != '') && $this->opt('tag_desc_override'))
						$desc = $this->opt_clean($descswaps[$key]['0'] . $suffix . '_extra');
					// end special handling for tag archives
					if ($desc == '') $desc = $default; // if blank, use default
					if (is_array($descswaps[$key]['1'])) $swap = array_merge($swap,$descswaps[$key]['1']);
				}  
				else $desc = $default;
				$desc = str_replace(array_keys($swap), array_values($swap),$desc);
			} // end handling other than single posts and pages and overrides
		} else { $desc = ''; }// end handling with secondary desc enabled
		// 20100429: decode and strip before prepout, because WP stores fields like blog desc with hard-coded entities for single quotes, etc., meaning the text can't be wptexturized properly
		$desc = $this->prepout(stripslashes(wp_specialchars_decode($desc, ENT_QUOTES)));
		if ($this->opt('secondary_desc_wrap')) $desc = wpautop($desc); // wrap only if requested
		if ($echo) echo $desc;
		else return $desc;
		return;
	} // end getting secondary description

	function get_legacy_title() { // grab titles stored by old SEO plugins
		global $post;
		$legacy = '';
		if ($this->opt('enable_secondary_titles_legacy')) {
			$supported = array('_aioseop_title','_headspace_page_title','title','_wpseo_edit_title','_su_title');
			foreach ($supported as $titlefield) {
				$legacy = get_post_meta($post->ID, $titlefield, true);
				if ($legacy != '') break;
			} // end loop over legacy titles to check
			if (('' == $legacy) && $this->opt('enable_seott')) { // SEO Title Tag is slightly more involved
				$seott = $this->opt_clean('seott_key_name');
				if ('' != $seott) $legacy = get_post_meta($post->ID, $seott, true);
			} // end handling SEO Title Tag data
		} // end handling legacy titles
		return $legacy;
	} // end getting legacy titles

	function get_secondary_title() { // select the secondary title, if enabled
		global $post;
		if ($this->opt('enable_secondary_titles')) {
			$tocheck = $this->id_to_check();
			$secondary = $this->get_meta_clean($tocheck, 'secondary_title', true);
			if ('' != $secondary) return $this->prepout($secondary);
			elseif ($this->opt('enable_secondary_titles_legacy') && !$this->opt('legacy_title_invert')) $secondary = $this->get_legacy_title();
			if ('' != $secondary) return $this->prepout(stripslashes(wp_specialchars_decode($secondary, ENT_QUOTES)));
		} // end of secondary titles enabled
		$secondary = ltrim(wp_title('',false));
		return $secondary;
	} // end getting secondary title

	function get_comment_page_title($ismain = false) { // construct the title for paged comment pages
		global $post;
		$title_for_insertion = '';
		if ($this->get_comment_page() && $this->opt('paged_comments_titlefix')) {
			$title = stripslashes($this->opt('comment_title_replacement'));
			if ($this->opt('comment_title_replacement_override') && !$ismain && $this->opt('enable_secondary_titles')) // do not override if main
				$title_for_insertion = $this->get_secondary_title();
			else {
				if ($this->opt('legacy_title_invert') && $this->opt('enable_secondary_titles_legacy')) 
					$title_for_insertion = $this->get_legacy_title();
				if ('' == $title_for_insertion) $title_for_insertion = single_post_title('',false);
			} // end check in case of legacy title inversion
		   $title = str_replace('%post_title%',$title_for_insertion,$title);
		   $title = str_replace('%comment_page%',get_query_var('cpage'),$title);
		} // end handling comment pages
		else $title = ltrim(wp_title('',false));
		return $title; // output will still need texturizing, but that's OK
	} // end getting comment page title

	function select_title($main=true,$echo=true) { // root function for titles calls on other functions to produce the title, depending on type of page; $main controls whether to return main or secondary title
		global $post;
		if (is_single() || is_page()) 
			$title = ($this->get_comment_page()) ? $this->get_comment_page_title($main) : $this->get_other_titles($main);
			// end handling singles and pages
		else $title = (($this->opt('main_for_secondary')) || $main) ? $this->get_other_titles(true) : $this->get_other_titles(false);
			// end handling pages other than singles and pages
		$title = $this->prepout(stripslashes(wp_specialchars_decode($title, ENT_QUOTES)));
		if ($echo) echo $title;
			else return $title;
		return;
	} // end select title

	function get_other_titles($main=false) { // get titles for other than paged comments; $main controls whether to return main or secondary title
		global $wp_query,$post;
		$suffix = ($main || !($this->opt('enable_secondary_titles'))) ? '_title' : '_title_secondary';
		
		$swap = array("%blog_name%" => get_bloginfo('name'));
		
		$key = $this->get_type_key();

		$titleswaps = $this->get_swaps($key);
		
		if ($key != '') {
			$title = $this->opt_clean($titleswaps[$key]['0'] . $suffix);
			if (is_array($titleswaps[$key]['1'])) $swap = array_merge($swap,$titleswaps[$key]['1']);
		}   
		else $title = wp_title('| ',false,'right') . get_bloginfo('name'); // if it was none of these, just get the usual
		
		if ((($key == 'single') || ($key == 'page')) && ($main && $this->opt('legacy_title_invert') && $this->opt('enable_secondary_titles_legacy'))) { // handle legacy titles as main titles
			$title = $this->get_legacy_title();
		} // end handling screwy legacy titles as main titles
		
		if ($title == '') $title = ltrim(wp_title('',false));
		if (is_paged() || $this->is_multipage()) { // modify with something like a page number, if this is paged?
			$modifier = $this->opt_clean($titleswaps['paged']['0'] . $suffix); // do some trickery to modify the title for paging
			if ($modifier != '') $title = str_replace('%prior_title%',$title,$modifier); 
			$swap = array_merge($swap,$titleswaps['paged']['1']);
		} // end handling paged
		$title = str_replace(array_keys($swap), array_values($swap),$title);
		
		return $title;
		
	} // end getting other titles

	function paged_comments_dupefix($content) { // remove post content if we're on a paged comment page
		if ($this->get_comment_page() && $this->opt('paged_comments_dupefix')) {
			global $post;
			$content = '<p class="commentsactive">' . $this->opt_clean('comment_page_replacement') . '</p>';
			($this->opt('comment_page_replacement_override') && $this->opt('enable_secondary_titles')) ?
				$title_for_insertion = $this->get_secondary_title() :
				$title_for_insertion = single_post_title('',false);
			$post_link = '&#8220;<a href="' . get_permalink() . '">' . $title_for_insertion . '</a>&#8221;';
			$swaps = array (
						"%post_title_linked%" => $post_link,
						"%post_title%" => $title_for_insertion,
						"%post_permalink%" => get_permalink(),
						);
			$content = str_replace(array_keys($swaps), array_values($swaps), $content);
			return $this->prepout($content);
		}
		else return $content;
	} // end paged comments dupefix

	function get_author($meta = 'display_name') { // simple author meta grabber, just for use on author archives
		global $wp_query;
		if (!is_author()) return '';
		$curauth = get_userdata(get_query_var('author'));
		return $curauth->$meta;
	} // end get author

	function trimmer($totrim='',$length=160,$ellipsis='...') { // trim strings down to size
		if (strlen($totrim) > $length) {
			$totrim = substr($totrim, 0, $length);
			$lastdot = strrpos($totrim, ".");
			$lastspace = strrpos($totrim, " ");
			$shorter = substr($totrim, 0, ($lastdot > $lastspace? $lastdot : $lastspace)); // truncate at either last dot or last space
			$shorter = rtrim($shorter, ' .') . $ellipsis; // trim off ending periods or spaces and append ellipsis
		} // end of snipping when too long
		else $shorter = $totrim;
		return $shorter;
	} // end trimmer

	function head_desc_comments() { // construct the head description for paged comment pages
		global $post;
		$desc = $this->opt_clean('paged_comments_meta_replacement');
		$desc = str_replace('%post_title%',single_post_title('',false),$desc);
		$desc = str_replace('%comment_page%',get_query_var('cpage'),$desc);
		return $desc; // note value hasn't been texurized or escaped
	} // end head desc for paged comments

	function clean_fancies($content) { // get rid of some (space-wasting) common typographical fanciness
		$replace = array (
					"&ldquo;" => '"',
					"&rdquo;"=> '"',
					"&quot;" => '"',
					"&lsquo;" => "'",
					"&rsquo;" => "'",
					"&mdash;" => "--",
					 );
		return str_replace(array_keys($replace), array_values($replace), $content);
	} // end cleaning out fancies

	function clean_shortcodes($content) { // get rid of shortcode junk
		$content = preg_replace('|\[(.+?)\](.+?\[/\\1\])?|s', '', $content);
		return trim($content);
	} // end cleaning up shortcode junk

	function head_desc() { // construct the head description
		global $post,$paged;
		if (is_404()) return;
		if ($this->opt('paged_comments_meta_enable') && $this->get_comment_page()) {
			$description = $this->head_desc_comments();
			$custom = true;
			$secondary_fallback = false;
		} // end handling comments pages
		else { // all the rest of this occurs only if we don't need a custom comments page meta
			$key = $this->get_type_key();
			$default  = get_bloginfo('name') . ': ' . get_bloginfo('description');
			$custom = $mp = $secondary_fallback = false;
			if ($this->treat_like_post($key)) { // posts, pages, and static front page or posts
				if ($this->opt('enable_alt_description')) {
					$tocheck = $this->id_to_check($key);
					$description = $this->get_meta_clean($tocheck,'alternative_description', true);
					if ($description != '') $custom = true;
					elseif ($this->opt('use_secondary_for_head')) $description = strip_tags($this->get_meta_clean($tocheck,'secondary_desc', true));
					if ($description != '') $custom = $secondary_fallback = true; // flag will tell us if this was secondary description
					elseif ($this->opt('enable_descriptions_legacy')) {
						$supported = array('_aioseop_description','_headspace_description','description','_wpseo_edit_description','_su_description');
						foreach ($supported as $descfield) {
							$description = get_post_meta($post->ID, $descfield, true);
							if ($description != '') {$custom = true; break;}
						} // end loop over legacy descriptions to check
					} // end handling legacy descriptions
				} // end check for alt desc enabled
				if (!$custom) { // no custom description?
					$description_longer = apply_filters('get_the_excerpt', $post->post_excerpt);
					if ($description_longer == '') $description_longer = $post->post_content;
					$description = trim(strip_tags(stripcslashes(str_replace(array("\r\n", "\r", "\n"), " ", $description_longer))));
				} // end handling single or page but not custom
				if ($this->is_multipage()) $mp = true; // and tweak for multi-page singles
			} // end handling single or page
			else { // if not single or page...
				$swap = array(
						"%blog_name%" => get_bloginfo('name'),
						"%blog_desc%" => get_bloginfo('description'),
						);
				$metaswaps = $this->get_swaps($key);
				$suffix = '_meta_desc';   
				if ($key != '') {
					$description = $this->opt_clean($metaswaps[$key]['0'] . $suffix);
					// Special handling for tag archives, so we can use a tag description if one is specified under 2.8+, or fall back to a different description if not
					if (($key == 'tag') && ($metaswaps[$key]['1']['%tag_desc%'] != '') && $this->opt('tag_meta_desc_override'))
						$description = $this->opt_clean($metaswaps[$key]['0'] . $suffix . '_extra');
					// end special handling for tag archives
					$custom = true;
					if (is_array($metaswaps[$key]['1'])) $swap = array_merge($swap,$metaswaps[$key]['1']);
				}    
				else $description = $default; // if it was none of these, just get name, desc
				if (is_paged())$mp = true; // modify with something like a page number, if this is paged
				$description = str_replace(array_keys($swap), array_values($swap),$description);
				$description = wp_specialchars_decode($description, ENT_QUOTES); // just to make sure we don't send it out encoded twice
				$description = strip_tags($this->strip_para($description)); // kill leftover markup
				if ($description == '') $description = $default;
			} // end handling other than single or page, now do stuff common to both
			if ($mp) { // multi-page mods, same for singular and others
				$suffix = '_meta_desc';
				$metaswaps = $this->get_swaps('paged');
				$modifier = $this->opt_clean($metaswaps['paged']['0'] . $suffix); // do some trickery to modify the title for paging
				if ($modifier != '') $description = str_replace('%prior_meta_desc%',$description,$modifier);
				$swap = $metaswaps['paged']['1'];
				$description = str_replace(array_keys($swap), array_values($swap),$description);
			}
		} // end of handling other than comments pages
		
		$description = $this->clean_shortcodes($description); // get rid of shortcodes
		$description = $this->clean_fancies($description); // get rid of common typographical fanciness
		$description = str_replace('"',"'",$description); // double quotes have to be htmlspecialchar-ed, but that wastes space in meta description
		$description = preg_replace('/  +/',' ',$description); // get rid of extraneous spaces
		
		$length = ('0' == $this->opt('desc_length')) ? 160 : $this->opt('desc_length');
		
		if (((!$this->opt('desc_length_override')) && $custom) || !$custom || $secondary_fallback)
			$description = $this->trimmer($description,$length); // only trim if not custom, or custom but not overriding
		
		$description = htmlspecialchars($description);
		$output = "<meta name=\"description\" content=\"{$description}\" />\n";
		if ($this->opt('obnoxious_mode')) return $output;
		else echo $output;
		return;
	} // end getting meta description

	function legacy_keyword_cleanup ($list) { // clean up legacy lists of keywords
		$list = stripslashes(wp_specialchars_decode($list,ENT_QUOTES));
		// commented out following line because some plugins store without commas, some with; we will err on the side of too few commas rather than inserting them where they shouldn't be
		// $list = str_replace(' ', ', ', $list);
		$list = str_replace('"', '', $list);
		$list = str_replace('+', ' ', $list);
		$list = str_replace('_', ' ', $list);
		$list = str_replace('-', ' ', $list);
		$list = str_replace(',,', ',', $list);
		return $list;
	} // end legacy keyword cleanup

	function head_keywords() { // construct head keyword list
		global $post;
		if (is_404()) return;
		if ((!$this->opt('enable_keywords'))) return;
		$defaults = $this->opt_clean('default_keywords');
		if ($defaults == '')
			$defaults = get_bloginfo('name');
		$taglist = '';
		if (is_singular()) { // thanks to Aaron Harun for noticing we no longer needed a loop here
			if ($this->opt('enable_keywords_custom'))
				$taglist = $this->get_meta_clean($post->ID,'keywords', true);
			if ($this->opt('enable_keywords_tags'))
				$posttags = get_the_tags($post->ID);
			if ($posttags) {
				if ($taglist != '') $taglist .= ', ';
				$showtags = array_slice($posttags,0,$this->opt('keyword_tags_limit')); // just keep the first specified number of tags
				foreach ($showtags as $tag) {
					$taglist .= wp_specialchars_decode($tag->name,ENT_QUOTES) . ', ';
				}
				$taglist = rtrim($taglist,', ');
			} // end check for whether we have tags
			
			if ($this->opt('enable_keywords_legacy')) {
				// add in any custom field keywords
				$supported = array('_aioseop_keywords','_headspace_keywords','_headspace_metakey', '_wpseo_edit_keywords','_su_keywords','autometa','keyword','keywords');
				foreach ($supported as $fieldname) {
					$extras = get_post_meta($post->ID, $fieldname, true);
					if ($extras != '') $taglist .= ', ' . $this->legacy_keyword_cleanup($extras);
				} // end loop for custom field keywords
			} // end check for supporting legacy keywords
			
			if ($taglist == '') $taglist = $defaults; // if nothing else, use defaults
			if ($this->opt('enable_keywords_title')) $taglist = wp_specialchars_decode(strip_tags($post->post_title)) . ', ' . $taglist;
			
		} // end handling single or page
		elseif (is_archive()) $taglist = $defaults;
		if (is_home()) {
			$homewords = $this->opt_clean('custom_home_keywords');
			$taglist = ('' == $homewords) ? $defaults : $homewords . ', ' . get_bloginfo('name');
		} // end handling home
		elseif(is_author())
			$taglist = $this->get_author() . ', ' . $taglist;
		elseif(is_tag())
			$taglist = single_tag_title('',false) . ', ' . $taglist;
		elseif(is_category())
			$taglist = stripslashes(wp_specialchars_decode(single_cat_title('',false),ENT_QUOTES)) . ', ' . $taglist;
		if (trim($taglist,', ') == '') $taglist = $defaults;
		
		$taglist = htmlspecialchars(trim($this->trimmer($taglist,$this->opt('tags_length'),''), ', '));
		$output = "<meta name=\"keywords\" content=\"{$taglist}\" />\n";
		if ($this->opt('obnoxious_mode')) return $output;
		else echo $output;
		return;
	} // end head keywords

	// check whether the passed type should be excluded from indexing at this depth
	function exclude_by_depth($check = 'date') {
		$depth_limit = intval($this->opt("depth_{$check}_exclude")); // depth limit specified?
		if ($depth_limit < 1) return false;
		if ($this->this_page() > $depth_limit) return true;
		else return false;
	}
	
	function robots() { // construct head robots
		global $post;
		if (is_404()) return;
		// 20100506: check again to see whether user wants us to add robots just in case this function is called directly via Sledgehammer Mode
		if (!$this->opt('index_enable')) return;
		$tocheck = array ('author','category','search','tag','date', 'attachment');
		$exclude = false;
		foreach ($tocheck as $check) { // have we been told to exclude certain types?
			$fx = 'is_' . $check;
			if ($fx() && ($this->opt("index_{$check}_exclude") || $this->exclude_by_depth($check)) ) $exclude = true;
		} // end loop over types to check
		if ($exclude) {
			$index = 'noindex';
			if ($this->opt('index_nofollow')) $index .= ',nofollow';
		} // end case for excluding
		else $index = 'index,follow';
		if ($this->opt('index_noodp')) $index .= ',noodp,noydir';
		if (is_ssl() && $this->opt('index_no_ssl')) $index = str_replace(array('index','follow'), array('noindex','nofollow'), $index);
		$output = "<meta name=\"robots\" content=\"{$index}\" />\n";
		if ($this->opt('obnoxious_mode')) return $output;
		else echo $output;
		return;
	} // end robots

	// Adapted from WP's private _wp_link_page(): provides URL for page $i of multi-page posts
	function get_current_paged_link($i = 1) {
		global $post, $wp_rewrite;
		$total = $this->this_page_total();
		if ((1 == $i) || (1 == $total)) {
			$url = get_permalink();
		}
		else {
			if ($i > $total) $i = $total;
			if ( '' == get_option('permalink_structure') || in_array($post->post_status, array('draft', 'pending')) )
				$url = add_query_arg( 'page', $i, get_permalink() );
			elseif ( 'page' == get_option('show_on_front') && get_option('page_on_front') == $post->ID )
				$url = trailingslashit(get_permalink()) . user_trailingslashit("$wp_rewrite->pagination_base/" . $i, 'single_paged');
			else
				$url = trailingslashit(get_permalink()) . user_trailingslashit($i, 'single_paged');
		}
		return $url;
	}
	
	function canonical() { // handle canonical URLs
		global $post;
		if (is_404()) return;
		if (!is_singular()) return;
		if ($this->get_comment_page()) return;
		if (!$this->opt('canonical_enable')) return;
		$link = $this->get_current_paged_link($this->this_page()); // handles permalink + paged links
		if (is_ssl() && $this->opt('canonical_no_ssl')) $link = str_replace('https://', 'http://', $link);
		if ($this->opt('enable_modifications')) $link = apply_filters('ghpseo_canonical_url',$link);
		$output = "<link rel=\"canonical\" href=\"{$link}\" />\n";
		if ($this->opt('obnoxious_mode')) return $output;
		else echo $output;
		return;
	} // end canonical

} // end class definition

// Here's where we start executing

if (is_admin()) { // only load the admin stuff if we have to
	include ('ghpseo-setup-functions.php');
	include('ghpseo-writing.php');
	function ghpseo_setup_setngo() { // set up and instantiate admin class
		$prefix = 'ghpseo';
		// don't use plugin_basename -- buggy when using symbolic links
		$dir = basename(dirname( __FILE__)) . '/';
		$base = basename( __FILE__);
		$location_full = WP_PLUGIN_DIR . '/' . $dir . $base;
		$location_local = $dir . $base;
		$args = compact('prefix','location_full','location_local');
		$options_page_details = array ('Greg&#8217;s HP SEO Options','High Performance SEO','gregs-high-performance-seo/ghpseo-options.php');
		new ghpseoSetupHandler($args,$options_page_details);
	} // end setup function
	ghpseo_setup_setngo();
	} // end admin-only stuff
else
	{ // code for regular page views: instantiate class and provide interface function
	$ghpseo = new gregsHighPerformanceSEO('ghpseo');
	function ghpseo_output($type='main',$echo=true) {
		global $ghpseo;
		switch ($type) {
			case "main": $result = $ghpseo->select_title(true,false); break;
			case "main_title": $result = $ghpseo->select_title(true,false); break;
			case "secondary_title": $result = $ghpseo->select_title(false,false); break;
			case "description": $result = $ghpseo->select_desc(false); break;
		}
		if ($ghpseo->opt('enable_modifications')) $result = apply_filters('ghpseo_output', $result, $type);
		if (!$echo) return $result;
		else echo $result;
		return;
	}
	// last and least, if we're running with output buffering, set it up now:
	if ($ghpseo->opt('obnoxious_mode')) include ('ghpseo-sledgehammer-mode.php');
} // end non-admin stuff

?>